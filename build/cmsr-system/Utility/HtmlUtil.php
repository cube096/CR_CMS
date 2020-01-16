<?php
namespace Cmsr\Utility;

use DateTime;
use Cmsr\FWConst;
use Cmsr\Utility\StringUtil;
use Cmsr\CmsrManager;

/**
 * HTML関連の操作を行う為のUtilityクラス
 */
class HtmlUtil
{
    // ========================================================
    // - メソッド
    // ========================================================
    /**
     * エスケープ
     * 指定文字列のHTML特殊文字を、実体参照に変換した文字列を取得する。
     * @param string $str エスケープしたい文字列
     * @param int $flgBit フラグ値(Bit)
     * @return string エスケープした文字列
     */
    #region Escape
    public static function Escape(string $str, int $flgBit = ENT_QUOTES|ENT_HTML5) : string
    {
        return htmlspecialchars($str, $flgBit);
    }
    #endregion




    /**
     * エスケープ(HtmlUtil::Escape())した文字列を出力する。
     * @param string $str エスケープして出力したい文字列
     * @param bool $isNewLineToBrElm 改行文字を<br>要素に変換するか否か
     * @param int $flgBit フラグ値(Bit)
     */
    #region Display
    public static function Display(string $str, bool $isNewLineToBrElm = false, int $flgBit = ENT_QUOTES|ENT_HTML5) : void
    {
        if($str !== null)
        {
            if($isNewLineToBrElm)
            {
                echo nl2br(self::Escape($str, $flgBit));
            }
            else
            {
                echo self::Escape($str, $flgBit);
            }
        }
    }
    #endregion



    /**
     * Title要素を出力する。
     * 第1引数($title)がnull乃至は、空文字である場合は出力しない。
     * @param string|null $title タイトル
     */
    #region TheMetaTitle
    public static function TheMetaTitle(?string $title) : void
    {
        if(!StringUtil::IsNullOrEmpty($title))
        {
            $elm = '<title>'.self::Escape($title).'</title>';
            echo $elm.PHP_EOL;
        }
    }
    #endregion




    /**
     * Meta要素(Description)を出力する。
     * 第1引数($description)がnull乃至は、空文字である場合は出力しない。
     * @param string|null $description 説明
     */
    #region TheMetaKeywords
    public static function TheMetaDescription(?string $description) : void
    {
        if(!StringUtil::IsNullOrEmpty($description))
        {
            $elm = '<meta name="description" content="'.self::Escape($description).'">';
            echo $elm.PHP_EOL;
        }
    }
    #endregion




    /**
     * Meta要素(Keywords)を出力する。
     * 第1引数($keywords)がnull又は、空配列である場合は、出力しない。
     * @param array|null $keywords キーワードを要素として持つ配列
     */
    #region TheMetaKeywords
    public static function TheMetaKeywords(?array $keywords) : void
    {
        if(is_array($keywords) && count($keywords) > 0)
        {
            $implodedKeywords = implode(',', $keywords);
            $elm = '<meta name="keywords" content="'.self::Escape($implodedKeywords).'">';
            echo $elm.PHP_EOL;
        }
    }
    #endregion




    /**
     * Link要素(Canonical)を出力する。
     * 第1引数($canonical)がnull乃至は、空文字である場合は出力しない。
     * @param string|null $canonical 絶対URL文字列
     */
    #region TheLinkCanonical
    public static function TheLinkCanonical(?string $canonical) : void
    {
        if(!StringUtil::IsNullOrEmpty($canonical))
        {
            $elm = '<link rel="canonical" href="'.self::Escape($canonical).'">';
            echo $elm.PHP_EOL;
        }
    }
    #endregion




    /**
     * Link要素(rel="stylesheet")を出力する。
     * 第1引数($stylesheets)がnull又は、空配列である場合は、出力しない。
     * @param string[]|null $stylesheets CSSファイルへのパスを要素として持つ配列
     */
    #region TheLinksToStylesheet
    public static function TheLinksToStylesheet(?array $stylesheets) : void
    {
        if(is_array($stylesheets) && count($stylesheets) > 0)
        {
            foreach($stylesheets as $path)
            {
                $elm = '';
                $elm .= '<link rel="stylesheet" href="'.self::Escape($path).'">';
                echo $elm.PHP_EOL;
            }
        }
    }
    #endregion




    /**
     * 日時を指定書式にフォーマットしたものを出力する。
     * @param string $datetime 日時文字列(フォーマットの定め無し)
     * @param string $format 出力フォーマット
     */
    #region TheDateTime
    public static function TheDateTime(string $datetime, string $format = FWConst::DATETIME_FORMAT_DISPLAY_DATE) : void
    {
        $dateTime = new DateTime($datetime);
        self::Display($dateTime->format($format));
    }
    #endregion




    /**
     * TOPページであるか判定する。
     * @return bool TOPページであるならばtrue、それ以外はfalse
     */
    #region IsHome
    public static function IsHome() : bool
    {
        $requestUri = HttpUtil::GetRequestUri();
        $homeUri = (string)CmsrManager::GetSettingValue(FWConst::CMSR_SETTING_ITEM_SITE_URL).'/';

        if($requestUri === $homeUri)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    #endregion




    /**
     * フォームCSRF対策トークンを取得する。
     */
    #region GetFormToken
    public static function GetFormToken() : string
    {
        $uri = HttpUtil::GetRequestUri();
        $sessionId = session_id();
        $ipAdr = HttpUtil::GetIPAdr();

        $salt = hash(FWConst::HASH_ALGO_SECURITY, $uri.$sessionId.$ipAdr);

        return hash(FWConst::HASH_ALGO_SECURITY, $sessionId.$salt.$ipAdr);
    }
    #endregion




    /**
     * フォームCSRF対策トークンを出力する。
     */
    #region TheFormToken
    public static function TheFormToken() : void
    {
        self::Display(self::GetFormToken());
    }
    #endregion
}