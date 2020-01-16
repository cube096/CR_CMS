<?php
namespace Cmsr\Utility;

use DateTime;
use Cmsr\FWConst;

/**
 * バリデーション関係のUtilityクラス
 */
class ValidationUtil
{
    // ========================================================
    // - メソッド
    // ========================================================
    /**
     * その文字列が、指定の日時形式として正しいか判定する。
     * @param string $datetime 判定したい文字列
     * @param string $format 正とする日時書式
     * @return bool 判定結果が正ならばtrue、それ以外はfalse
     */
    #region IsCorrectDateTimeFormat
    public static function IsCorrectDateTimeFormat(string $datetime, string $format = FWConst::DATETIME_FORMAT_SYSTEM) : bool
    {
        $dtTmObj = DateTime::createFromFormat($format, $datetime);

        if($dtTmObj === false || $dtTmObj->format($format) !== $datetime)
        {
            return false;
        }

        return true;
    }
    #endregion




    /**
     * その文字列が、Eメールアドレスとして正しい書式か判定する。
     * @param string $emailAdr 判定したい文字列
     * @return bool 判定結果が正ならばtrue、それ以外はfalse
     */
    #region IsCorrectEMailAdrFormat
    public static function IsCorrectEMailAdrFormat(string $emailAdr) : bool
    {
        $result = filter_var($emailAdr, FILTER_VALIDATE_EMAIL);

        if($result !== $emailAdr) {
            return false;
        }

        return true;
    }
    #endregion




    /**
     * その文字列が、IPアドレスとして正しい書式か判定する。
     * (IPv4とIPv6に対応)
     * @param string $ipAdr 判定したい文字列
     * @return bool 判定結果が正ならばtrue、それ以外はfalse
     */
    #region IsCorrectIpAdrFormat
    public static function IsCorrectIpAdrFormat(string $ipAdr) : bool
    {
        $result = inet_pton($ipAdr);

        if($result !== false)
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
     * その文字列が、URLとして正しい書式か判定する。
     * @param string $url 判定したい文字列
     * @return bool 判定結果が正ならばtrue、それ以外はfalse
     */
    #region IsCorrectUrlFormat
    public static function IsCorrectUrlFormat(string $url) : bool
    {
        return ((false !== filter_var($url, FILTER_VALIDATE_URL)) && preg_match('@^https?+://@i', $url));
    }
    #endregion
}
