<?php
namespace Cmsr;

use ErrorException;
use LogicException;
use InvalidArgumentException;
use Cmsr\Exception\FileNotFoundException;
use Cmsr\Exception\InvalidFormatException;
use Cmsr\Exception\JsonParseException;
use Cmsr\Model\Struct\PluginInfoStruct;
use Cmsr\Utility\ClassUtil;;
use Cmsr\Utility\EnvironmentUtil;
use Cmsr\Utility\FileUtil;
use Cmsr\Utility\SessionUtil;
use Cmsr\Utility\StringUtil;
use Cmsr\Utility\ValidationUtil;

/**
 * CMSRマネージャクラス
 * CMSRの全体的な制御処理を行う。
 * 本システムを利用する場合は、必ず本クラスのInitializationメソッドを実行する必要があります。
 */
class CmsrManager
{
    // ================================================================
    // 変数
    // ================================================================
    /** @var string[] CMSR設定情報 */
    private static $cmsrSettings;

    /** @var string[] ルーティング情報 */
    private static $routingSettings;






    // ================================================================
    // メソッド
    // ================================================================
    /**
     * CMSRを初期化する。
     * @throws FileNotFoundException 設定ファイルが存在しない場合に、FileNotFoundExceptionを投げる。
     * @throws JsonParseException メンテナンス設定ファイルのパースに失敗した場合に、JsonParseExceptionを投げる。
     */
    #region Initialization
    public static function Initialization() : void
    {
        // 各種設定
        mb_internal_encoding(FWConst::ENCODING_UTF8);

        // CMSR設定の読込
        $settingsJsonFilePath = FWConst::FILE_PATH_CMSR_SETTINGS;

        if(!FileUtil::ExistsFile($settingsJsonFilePath))
        {
            throw new FileNotFoundException('CMSR設定ファイルが存在しません。'.PHP_EOL.$settingsJsonFilePath);
        }

        $settingsJsonStr = FileUtil::ReadString($settingsJsonFilePath);
        $settings = json_decode($settingsJsonStr);

        if(!is_object($settings))
        {
            throw new JsonParseException('CMSR設定ファイルのパースに失敗しました。');
        }

        $settings = (array)$settings;

        // 値読み込み・例外検査
        foreach($settings as $key => $value)
        {
            if(is_string($key) && $value !== null)
            {
                self::SetSettingValue($key, $value);
            }
            else
            {
                throw new InvalidFormatException('CMSR設定ファイルの様式が不正です。');
            }
        }

        #region CMSR設定値のバリデーションと正規化
        // アプリケーション名
        if(
            !isset($settings[FWConst::CMSR_SETTING_ITEM_APPLICATION_NAME])
            || StringUtil::IsNullOrWhiteSpace($settings[FWConst::CMSR_SETTING_ITEM_APPLICATION_NAME])
        )
        {
            $settings[FWConst::CMSR_SETTING_ITEM_APPLICATION_NAME] = FWConst::CMSR_SETTING_DEFAULT_VALUE_APPLICATION_NAME;
        }

        // サイト名
        if(
            !isset($settings[FWConst::CMSR_SETTING_ITEM_SITE_TITLE])
            || StringUtil::IsNullOrWhiteSpace($settings[FWConst::CMSR_SETTING_ITEM_SITE_TITLE])
        )
        {
            $settings[FWConst::CMSR_SETTING_ITEM_SITE_TITLE] = FWConst::CMSR_SETTING_DEFAULT_VALUE_SITE_TITLE;
        }

        // タイトル区切り文字
        if(
            !isset($settings[FWConst::CMSR_SETTING_ITEM_TITLE_SEPARATOR])
            || StringUtil::IsNullOrWhiteSpace($settings[FWConst::CMSR_SETTING_ITEM_TITLE_SEPARATOR])
        )
        {
            $settings[FWConst::CMSR_SETTING_ITEM_TITLE_SEPARATOR] = FWConst::CMSR_SETTING_DEFAULT_VALUE_TITLE_SEPARATOR;
        }

        // サイトUrl(必須)
        if(
            !isset($settings[FWConst::CMSR_SETTING_ITEM_SITE_URL])
            || StringUtil::IsNullOrWhiteSpace($settings[FWConst::CMSR_SETTING_ITEM_SITE_URL])
            || !ValidationUtil::IsCorrectUrlFormat($settings[FWConst::CMSR_SETTING_ITEM_SITE_URL])
        )
        {
            throw new InvalidFormatException('CMSR設定ファイルにサイトURLが設定されていないか、その書式が不正です。');
        }

        // 運用Eメールアドレス(必須)
        if(
            !isset($settings[FWConst::CMSR_SETTING_ITEM_MASTER_EMAIL_ADR])
            || StringUtil::IsNullOrWhiteSpace($settings[FWConst::CMSR_SETTING_ITEM_MASTER_EMAIL_ADR])
            || !ValidationUtil::IsCorrectEMailAdrFormat($settings[FWConst::CMSR_SETTING_ITEM_MASTER_EMAIL_ADR])
        )
        {
            throw new InvalidFormatException('CMSR設定ファイルに運用Eメールアドレスが設定されていないか、その書式が不正です。');
        }

        // アプリケーション名前空間
        if(
            !isset($settings[FWConst::CMSR_SETTING_ITEM_APPLICATION_NAME_SPACE])
            || StringUtil::IsNullOrWhiteSpace($settings[FWConst::CMSR_SETTING_ITEM_APPLICATION_NAME_SPACE])
        )
        {
            $settings[FWConst::CMSR_SETTING_ITEM_APPLICATION_NAME_SPACE] = FWConst::CMSR_SETTING_DEFAULT_VALUE_APPLICATION_NAME_SPACE;
        }

        // 開発者モード
        if(
            !isset($settings[FWConst::CMSR_SETTING_ITEM_DEVELOPER_MODE])
            || !is_bool($settings[FWConst::CMSR_SETTING_ITEM_DEVELOPER_MODE])
        )
        {
            $settings[FWConst::CMSR_SETTING_ITEM_DEVELOPER_MODE] = FWConst::CMSR_SETTING_DEFAULT_VALUE_DEVELOPER_MODE;
        }
        #endregion

        // 設定
        self::$cmsrSettings = $settings;


        // ルーティング設定の読込

        // オートロード
        spl_autoload_register(
            function(string $className)
            {
                $existsClass = ClassUtil::LoadClass($className);

                if(!$existsClass)
                {
                    throw new LogicException('クラス:'.$className.' が存在しません。');
                }
            }
        );

            // エラー表示
        if(EnvironmentUtil::IsDeveloperMode())
        {
            ini_set('display_errors', "On");
        }
        else
        {
            ini_set('display_errors', "Off");
        }


        // エラーハンドリング
        set_error_handler(
            function($severity, $message, $file, $line)
            {
                if (!(error_reporting() & $severity))
                {
                    // エラーレポート対象でない場合
                    return;
                }

                throw new ErrorException($message, 0, $severity, $file, $line);
            }
        );

        // セッション
        SessionUtil::Start();
    }
    #endregion




    /**
     * CMSR設定項目値を追加する。
     * @param $key string 追加する設定項目のキー
     * @param $value mixed 追加する設定項目の値
     * @param $override bool 設定項目キーの衝突時に上書きするか否か。
     * @throws InvalidArgumentException $overrideがfalseかつ、設定項目キーが衝突した場合に、InvalidArgumentExceptionを投げる。
     */
    #region SetSettingValue
    public static function SetSettingValue(string $key, $value, bool $override = false) : void
    {
        if(self::ExistsSettingItem($key) && !$override)
        {
            throw new InvalidArgumentException('設定項目キー:"'.$key.'"は、既に設定されています。');
        }

        self::$cmsrSettings[$key] = $value;
    }
    #endregion




    /**
     * CMSR設定項目値を取得する。
     * @param $key string 取得したい設定項目のキー
     * @return mixed 設定項目が存在するならばその値、それ以外はnull
     */
    #region GetSettingValue
    public static function GetSettingValue(string $key)
    {
        if(self::ExistsSettingItem($key))
        {
            return self::$cmsrSettings[$key];
        }

        return null;
    }
    #endregion




    /**
     * CMSR設定項目が存在するか判定する。
     * @param $key string 存在するか判定したい設定項目のキー
     * @return bool $keyと同一の設定項目が存在し、かつその値がnull以外ならばtrue、それ以外はfalase
     */
    #region ExistsSettingItem
    public static function ExistsSettingItem(string $key) : bool
    {
        $settings = self::$cmsrSettings;
        return (isset($settings[$key]));
    }
    #endregion




    /**
     * サイトURLを取得する。
     * @return string サイトURL
     */
    #region GetBaseUri
    public static function GetSiteUrl() : string
    {
        return (string)self::GetSettingValue(FWConst::CMSR_SETTING_ITEM_SITE_URL);
    }
    #endregion
}