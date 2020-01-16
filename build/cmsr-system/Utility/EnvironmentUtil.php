<?php
namespace Cmsr\Utility;

use Cmsr\FWConst;
use Cmsr\CmsrManager;
use Cmsr\Exception\FileNotFoundException;
use Cmsr\Exception\JsonParseException;
use Cmsr\Exception\InvalidFormatException;
use Cmsr\Model\Struct\DataBaseConnectInfoStruct;
use Cmsr\Model\Struct\MaintenanceInfoStruct;
use Cmsr\Model\Struct\PluginInfoStruct;

/**
 * 環境情報に関する操作を行うユーティリティクラス
 */
class EnvironmentUtil
{
    // ================================================================
    // - 変数
    // ================================================================
    /** @var bool メンテナンスモードであるか */
    protected static $underMaintenance = null;

    /** @var bool 開発者モードであるか。 */
    protected static $isDeveloperMode = null;

    /** @var DataBaseConnectInfoStruct DB接続情報構造体 */
    protected static $databaseConnectInfoStruct = null;

    /** @var MaintenanceInfoStruct メンテナンス情報構造体 */
    protected static $maintenanceInfoStruct = null;

    /** @var PluginInfoStruct[] プラグイン情報構造体リスト */
    protected static $pluginInfoStructList = null;





    // ================================================================
    // - メソッド
    // ================================================================
    /**
     * メンテナンスモードであるか判定する
     * @return bool メンテナンスモードならばtrue、それ以外はfalse
     */
    #region UnderMaintenance
    public static function UnderMaintenance() : bool
    {
        if(self::$underMaintenance === null)
        {
            $maintenanceInfoStruct = self::GetMaintenanceInfoStruct();

            if(
                $maintenanceInfoStruct->CanActivate
                && ValidationUtil::IsCorrectDateTimeFormat($maintenanceInfoStruct->BeginDtTm)
                && ValidationUtil::IsCorrectDateTimeFormat($maintenanceInfoStruct->EndDtTm)
            )
            {
                $beginDtTm = strtotime($maintenanceInfoStruct->BeginDtTm);
                $endDtTm = strtotime($maintenanceInfoStruct->EndDtTm);
                $currentDtTm = strtotime(date(FWConst::DATETIME_FORMAT_SYSTEM));

                if($beginDtTm <= $currentDtTm && $currentDtTm <= $endDtTm)
                {
                    self::$underMaintenance = true;
                }
                else
                {
                    self::$underMaintenance = false;
                }
            }
            else
            {
                self::$underMaintenance = false;
            }
        }

        return self::$underMaintenance;
    }
    #endregion




    /**
     * 開発者モードであるか判定する
     * @return bool 開発者モードならばtrue、それ以外はfalse
     */
    #region IsDeveloperMode
    public static function IsDeveloperMode() : bool
    {
        if(self::$isDeveloperMode === null)
        {
            self::$isDeveloperMode = (bool)CmsrManager::GetSettingValue(FWConst::CMSR_SETTING_ITEM_DEVELOPER_MODE);
        }

        return self::$isDeveloperMode;
    }
    #endregion



    /**
     * データベース接続情報を取得する。
     * @return DataBaseConnectInfoStruct DB接続情報構造体
     * @throws FileNotFoundException データベース設定ファイルが存在しない場合に、FileNotFoundExceptionを投げる。
     * @throws JsonParseException データベース設定ファイルのパースに失敗した場合に、JsonParseExceptionを投げる。
     * @throws InvalidFormatException データベース設定ファイルの様式が不正な場合に、InvalidFormatExceptionを投げる。
     */
    #region GetDataBaseConnectInfoStruct
    public static function GetDataBaseConnectInfoStruct() : DataBaseConnectInfoStruct
    {
        if(self::$databaseConnectInfoStruct === null)
        {
            $path = FWConst::FILE_PATH_DATABASE_SETTINGS;

            if(!FileUtil::ExistsFile($path))
            {
                throw new FileNotFoundException('データベース設定ファイルが存在しません。'.PHP_EOL.$path);
            }

            $databaseSettingJsonStr = FileUtil::ReadString($path);

            $dbSettings = json_decode($databaseSettingJsonStr, true);

            if(!is_object($dbSettings))
            {
                throw new JsonParseException('データベース設定ファイルのパースに失敗しました。');
            }

            $dbSettings = (array)$dbSettings;


            // 例外検査
            if(
                !isset(
                    $dbSettings[FWConst::DATABASE_SETTING_ITEM_HOST],
                    $dbSettings[FWConst::DATABASE_SETTING_ITEM_PORT],
                    $dbSettings[FWConst::DATABASE_SETTING_ITEM_DATABASE],
                    $dbSettings[FWConst::DATABASE_SETTING_ITEM_USER],
                    $dbSettings[FWConst::DATABASE_SETTING_ITEM_PASSWORD],
                    $dbSettings[FWConst::DATABASE_SETTING_ITEM_CHARSET]
                )
                || !is_string($dbSettings[FWConst::DATABASE_SETTING_ITEM_HOST])
                || !is_string($dbSettings[FWConst::DATABASE_SETTING_ITEM_PORT])
                || !is_string($dbSettings[FWConst::DATABASE_SETTING_ITEM_DATABASE])
                || !is_string($dbSettings[FWConst::DATABASE_SETTING_ITEM_USER])
                || !is_string($dbSettings[FWConst::DATABASE_SETTING_ITEM_PASSWORD])
                || !is_string($dbSettings[FWConst::DATABASE_SETTING_ITEM_CHARSET])
            )
            {
                throw new InvalidFormatException('データベース設定ファイルの様式が不正です。');
            }

            // 要素の作成
            $dbConnectInfoStruct = new DataBaseConnectInfoStruct();
            $dbConnectInfoStruct->Host = $dbSettings[FWConst::DATABASE_SETTING_ITEM_HOST];
            $dbConnectInfoStruct->Port = $dbSettings[FWConst::DATABASE_SETTING_ITEM_PORT];
            $dbConnectInfoStruct->Name = $dbSettings[FWConst::DATABASE_SETTING_ITEM_DATABASE];
            $dbConnectInfoStruct->User = $dbSettings[FWConst::DATABASE_SETTING_ITEM_USER];
            $dbConnectInfoStruct->Password = $dbSettings[FWConst::DATABASE_SETTING_ITEM_PASSWORD];
            $dbConnectInfoStruct->Charset = $dbSettings[FWConst::DATABASE_SETTING_ITEM_CHARSET];

            self::$databaseConnectInfoStruct === $dbConnectInfoStruct;
        }


        return self::$databaseConnectInfoStruct;
    }
    #endregion




    /**
     * メンテナンス情報を取得する。
     * @return MaintenanceInfoStruct メンテナンス情報構造体
     * @throws FileNotFoundException メンテナンス設定ファイルが存在しない場合に、FileNotFoundExceptionを投げる。
     * @throws JsonParseException メンテナンス設定ファイルのパースに失敗した場合に、JsonParseExceptionを投げる。
     * @throws InvalidFormatException メンテナンス設定ファイルの様式が不正な場合に、InvalidFormatExceptionを投げる。
     */
    #region GetMaintenanceInfoStruct
    public static function GetMaintenanceInfoStruct() : MaintenanceInfoStruct
    {
        if(self::$maintenanceInfoStruct === null)
        {
            $maintenanceInfoStruct = new MaintenanceInfoStruct();
            $path = FWConst::FILE_PATH_MAINTENANCE_SETTINGS;

            if(!FileUtil::ExistsFile($path))
            {
                throw new FileNotFoundException('メンテナンス設定ファイルが存在しません。'.PHP_EOL.$path);
            }

            $maintenanceSettingsJsonStr = FileUtil::ReadString($path);

            $maintenanceSettings = (array)json_decode($maintenanceSettingsJsonStr, true);

            if(!is_object($maintenanceSettings))
            {
                throw new JsonParseException('メンテナンス設定ファイルのパースに失敗しました。');
            }

            $maintenanceSettings = (array)$maintenanceSettings;


            // 例外検査
            if(
                !isset(
                    $maintenanceSettings[FWConst::MAINTENANCE_SETTING_ITEM_CAN_ACTIVATE],
                    $maintenanceSettings[FWConst::MAINTENANCE_SETTING_ITEM_BEGIN_DATETIME],
                    $maintenanceSettings[FWConst::MAINTENANCE_SETTING_ITEM_END_DATETIME],
                    $maintenanceSettings[FWConst::MAINTENANCE_SETTING_ITEM_GUIDANCE]
                )
                || !is_bool($maintenanceSettings[FWConst::MAINTENANCE_SETTING_ITEM_CAN_ACTIVATE])
                || !is_string($maintenanceSettings[FWConst::MAINTENANCE_SETTING_ITEM_BEGIN_DATETIME])
                || !is_string($maintenanceSettings[FWConst::MAINTENANCE_SETTING_ITEM_END_DATETIME])
                || !is_string($maintenanceSettings[FWConst::MAINTENANCE_SETTING_ITEM_GUIDANCE])
            )
            {
                throw new InvalidFormatException('メンテナンス設定ファイルの様式が不正です。');
            }

            // 要素の作成
            $maintenanceInfoStruct->CanActivate = $maintenanceSettings[FWConst::MAINTENANCE_SETTING_ITEM_CAN_ACTIVATE];
            $maintenanceInfoStruct->BeginDtTm = $maintenanceSettings[FWConst::MAINTENANCE_SETTING_ITEM_BEGIN_DATETIME];
            $maintenanceInfoStruct->EndDtTm = $maintenanceSettings[FWConst::MAINTENANCE_SETTING_ITEM_END_DATETIME];
            $maintenanceInfoStruct->Text = $maintenanceSettings[FWConst::MAINTENANCE_SETTING_ITEM_GUIDANCE];

            self::$maintenanceInfoStruct = $maintenanceInfoStruct;
        }


        return self::$maintenanceInfoStruct;
    }
    #endregion




    /**
     * プラグイン情報を取得する。
     * @return PluginInfoStruct[] プラグイン情報構造体リスト
     * @throws FileNotFoundException プラグイン設定ファイルが存在しない場合に、FileNotFoundExceptionを投げる。
     * @throws JsonParseException プラグイン設定ファイルのパースに失敗した場合に、JsonParseExceptionを投げる。
     * @throws InvalidFormatException プラグイン設定ファイルの様式が不正な場合に、InvalidFormatExceptionを投げる。
     */
    #region GetPluginInfoStructList
    public static function GetPluginInfoStructList() : array
    {
        if(self::$pluginInfoStructList === null)
        {
            $path = FWConst::FILE_PATH_PLUGIN_SETTINGS;
            $pluginInfoStructList = [];

            if(!FileUtil::ExistsFile($path))
            {
                throw new FileNotFoundException('プラグイン設定ファイルが存在しません。'.PHP_EOL.$path);
            }

            $pluginSettingsJsonStr = FileUtil::ReadString($path);

            $pluginSettingsList = json_decode($pluginSettingsJsonStr);

            if(!is_array($pluginSettingsList))
            {
                throw new JsonParseException('プラグイン設定ファイルのパースに失敗しました。');
            }


            // 要素作成・例外検査
            foreach($pluginSettingsList as $pluginSettings) {
                if(!is_object($pluginSettings))
                {
                    throw new InvalidFormatException('プラグイン設定ファイルの様式が不正です。');
                }

                $pluginSettings = (array)$pluginSettings;

                if(
                    !is_array($pluginSettings)
                    || !isset(
                        $pluginSettings[FWConst::PLUGIN_SETTING_ITEM_DIR_NAME],
                        $pluginSettings[FWConst::PLUGIN_SETTING_ITEM_ENABLED],
                        $pluginSettings[FWConst::PLUGIN_SETTING_ITEM_ROOT_NAMESPACE]
                    )
                    || !is_string($pluginSettings[FWConst::PLUGIN_SETTING_ITEM_DIR_NAME])
                    || !is_bool($pluginSettings[FWConst::PLUGIN_SETTING_ITEM_ENABLED])
                    || !is_string($pluginSettings[FWConst::PLUGIN_SETTING_ITEM_ROOT_NAMESPACE])
                )
                {
                    throw new InvalidFormatException('プラグイン設定ファイルの様式が不正です。');
                }
                else
                {
                    $pluginInfoStruct = new PluginInfoStruct();
                    $pluginInfoStruct->DirName = $pluginSettings[FWConst::PLUGIN_SETTING_ITEM_DIR_NAME];
                    $pluginInfoStruct->Enabled = $pluginSettings[FWConst::PLUGIN_SETTING_ITEM_ENABLED];
                    $pluginInfoStruct->RootNameSpace = $pluginSettings[FWConst::PLUGIN_SETTING_ITEM_ROOT_NAMESPACE];
                    $dirNameLastCharIndex = mb_strlen($pluginInfoStruct->DirName) - 1;

                    if($pluginInfoStruct->DirName[0] === '/' || $pluginInfoStruct->DirName[0] === '\\')
                    {
                        $pluginInfoStruct->DirName[0] = mb_substr($pluginInfoStruct->DirName, 1);
                    }

                    if($pluginInfoStruct->DirName[$dirNameLastCharIndex] === '/' || $pluginInfoStruct->DirName[$dirNameLastCharIndex] === '\\')
                    {
                        $pluginInfoStruct->DirName[$dirNameLastCharIndex] = '';
                    }

                    $pluginInfoStructList[] = $pluginInfoStruct;
                    $pluginInfoStruct = null;
                }
            }

            self::$pluginInfoStructList = $pluginInfoStructList;
        }

        return self::$pluginInfoStructList;
    }
    #endregion
}