<?php
namespace Cmsr\Utility;

use InvalidArgumentException;

/**
 * 文字列関連の操作を行う為のUtilityクラス
 */
class StringUtil
{
    // ================================================================
    // 定数
    // ================================================================
    /** パスカルケースへ変換する際に、単語の区切りとみなす文字のリスト */
    public const PASCALIZE_TGT_CHAR_LIST = [' ', '_', '-'];

    /** キャメルケースへ変換する際に、単語の区切りとみなす文字のリスト */
    public const CAMELIZE_TGT_CHAR_LIST = [' ', '_', '-'];

    #region Unicode制御文字名
    /** Unicode制御文字名:NUL */
    public const UNICODE_CTRL_CHAR_NUL = 'NUL';

    /** Unicode制御文字名:SOH */
    public const UNICODE_CTRL_CHAR_SOH = 'SOH';

    /** Unicode制御文字名:STX */
    public const UNICODE_CTRL_CHAR_STX = 'STX';

    /** Unicode制御文字名:ETX */
    public const UNICODE_CTRL_CHAR_ETX = 'ETX';

    /** Unicode制御文字名:EOT */
    public const UNICODE_CTRL_CHAR_EOT = 'EOT';

    /** Unicode制御文字名:ENQ */
    public const UNICODE_CTRL_CHAR_ENQ = 'ENQ';

    /** Unicode制御文字名:ACK */
    public const UNICODE_CTRL_CHAR_ACK = 'ACK';

    /** Unicode制御文字名:BEL */
    public const UNICODE_CTRL_CHAR_BEL = 'BEL';

    /** Unicode制御文字名:BS */
    public const UNICODE_CTRL_CHAR_BS = 'BS';

    /** Unicode制御文字名:HT */
    public const UNICODE_CTRL_CHAR_HT = 'HT';

    /** Unicode制御文字名:LF */
    public const UNICODE_CTRL_CHAR_LF = 'LF';

    /** Unicode制御文字名:VT */
    public const UNICODE_CTRL_CHAR_VT = 'VT';

    /** Unicode制御文字名:FF */
    public const UNICODE_CTRL_CHAR_FF = 'FF';

    /** Unicode制御文字名:CR */
    public const UNICODE_CTRL_CHAR_CR = 'CR';

    /** Unicode制御文字名:SO */
    public const UNICODE_CTRL_CHAR_SO = 'SO';

    /** Unicode制御文字名:SI */
    public const UNICODE_CTRL_CHAR_SI = 'SI';

    /** Unicode制御文字名:DLE */
    public const UNICODE_CTRL_CHAR_DLE = 'DLE';

    /** Unicode制御文字名:DC1 */
    public const UNICODE_CTRL_CHAR_DC1 = 'DC1';

    /** Unicode制御文字名:DC2 */
    public const UNICODE_CTRL_CHAR_DC2 = 'DC2';

    /** Unicode制御文字名:DC3 */
    public const UNICODE_CTRL_CHAR_DC3 = 'DC3';

    /** Unicode制御文字名:DC4 */
    public const UNICODE_CTRL_CHAR_DC4 = 'DC4';

    /** Unicode制御文字名:NAK */
    public const UNICODE_CTRL_CHAR_NAK = 'NAK';

    /** Unicode制御文字名:SYN */
    public const UNICODE_CTRL_CHAR_SYN = 'SYN';

    /** Unicode制御文字名:ETB */
    public const UNICODE_CTRL_CHAR_ETB = 'ETB';

    /** Unicode制御文字名:CAN */
    public const UNICODE_CTRL_CHAR_CAN = 'CAN';

    /** Unicode制御文字名:EM */
    public const UNICODE_CTRL_CHAR_EM = 'EM';

    /** Unicode制御文字名:SUB */
    public const UNICODE_CTRL_CHAR_SUB = 'SUB';

    /** Unicode制御文字名:ESC */
    public const UNICODE_CTRL_CHAR_ESC = 'ESC';

    /** Unicode制御文字名:FS */
    public const UNICODE_CTRL_CHAR_FS = 'FS';

    /** Unicode制御文字名:GS */
    public const UNICODE_CTRL_CHAR_GS = 'GS';

    /** Unicode制御文字名:RS */
    public const UNICODE_CTRL_CHAR_RS = 'RS';

    /** Unicode制御文字名:US */
    public const UNICODE_CTRL_CHAR_US = 'US';

    /** Unicode制御文字名:SPACE */
    public const UNICODE_CTRL_CHAR_SPACE = 'SPACE';

    /** Unicode制御文字名:DEL */
    public const UNICODE_CTRL_CHAR_DEL = 'DEL';

    #endregion

    /** Unicode制御文字リスト */
    #region UNICODE_CTRL_CHAR_LIST
    public const UNICODE_CTRL_CHAR_LIST = [
        self::UNICODE_CTRL_CHAR_NUL => 'x00'
      , self::UNICODE_CTRL_CHAR_SOH => 'x01'
      , self::UNICODE_CTRL_CHAR_STX => 'x02'
      , self::UNICODE_CTRL_CHAR_ETX => 'x03'
      , self::UNICODE_CTRL_CHAR_EOT => 'x04'
      , self::UNICODE_CTRL_CHAR_ENQ => 'x05'
      , self::UNICODE_CTRL_CHAR_ACK => 'x06'
      , self::UNICODE_CTRL_CHAR_BEL => 'x07'
      , self::UNICODE_CTRL_CHAR_BS => 'x08'
      , self::UNICODE_CTRL_CHAR_HT => 'x09'
      , self::UNICODE_CTRL_CHAR_LF => 'x0a'
      , self::UNICODE_CTRL_CHAR_VT => 'x0b'
      , self::UNICODE_CTRL_CHAR_FF => 'x0c'
      , self::UNICODE_CTRL_CHAR_CR => 'x0d'
      , self::UNICODE_CTRL_CHAR_SO => 'x0e'
      , self::UNICODE_CTRL_CHAR_SI => 'x0f'
      , self::UNICODE_CTRL_CHAR_DLE => 'x10'
      , self::UNICODE_CTRL_CHAR_DC1 => 'x11'
      , self::UNICODE_CTRL_CHAR_DC2 => 'x12'
      , self::UNICODE_CTRL_CHAR_DC3 => 'x13'
      , self::UNICODE_CTRL_CHAR_DC4 => 'x14'
      , self::UNICODE_CTRL_CHAR_NAK => 'x15'
      , self::UNICODE_CTRL_CHAR_SYN => 'x16'
      , self::UNICODE_CTRL_CHAR_ETB => 'x17'
      , self::UNICODE_CTRL_CHAR_CAN => 'x18'
      , self::UNICODE_CTRL_CHAR_EM => 'x19'
      , self::UNICODE_CTRL_CHAR_SUB => 'x1a'
      , self::UNICODE_CTRL_CHAR_ESC => 'x1b'
      , self::UNICODE_CTRL_CHAR_FS => 'x1c'
      , self::UNICODE_CTRL_CHAR_GS => 'x1d'
      , self::UNICODE_CTRL_CHAR_RS => 'x1e'
      , self::UNICODE_CTRL_CHAR_US => 'x1f'
      , self::UNICODE_CTRL_CHAR_SPACE => 'x20'
      , self::UNICODE_CTRL_CHAR_DE => 'x7f'
    ];
    #endregion








    // ================================================================
    // メソッド
    // ================================================================
    /**
     * 文字列をパスカルケース変換する(PascalCase)
     * @param $str string パスカルケースへ変換したい文字列
     * @param $tgtCharList string[] パスカルケースへ変換する際に、単語の区切りとみなす文字のリスト
     * @return string 引数$strをパスカルケースへ変換した文字列
     */
    #region Pascalize
    public static function Pascalize(string $str, array $tgtCharList = self::PASCALIZE_TGT_CHAR_LIST) : string
    {
        return str_replace($tgtCharList, '', ucwords($str, implode('', $tgtCharList)));
    }
    #endregion




    /**
     * 文字列をキャメルケース変換する(camelCase)
     * @param $str string キャメルケースへ変換したい文字列
     * @param $tgtCharList string[] キャメルケースへ変換する際に、単語の区切りとみなす文字のリスト
     * @return string 引数$strをキャメルケースへ変換した文字列
     */
    #region Camelize
    public static function Camelize(string $str, array $tgtCharList = self::CAMELIZE_TGT_CHAR_LIST) : string
    {
        return lcfirst(self::Pascalize($str, $tgtCharList));
    }
    #endregion




    /**
     * 文字列をスネークケース変換する(snake_case)
     * @param $str string スネークケースへ変換したい文字列
     * @return string 引数$strをスネークケースへ変換した文字列
     */
    #region Snakify
    public static function Snakify(string $str) : string
    {
        $str = preg_replace('/([A-Z])/', '_$1', $str);
        $str = strtolower($str);
        return ltrim($str, '_');
    }
    #endregion





    /**
     * 文字列の先頭と終端の空白文字並びに、制御文字を取り除く。
     * @param $str string 制御文字を取り除きたい文字列
     * @return string 引数$strの先端と終端の制御文字を取り除いた文字列
     */
    #region Trim
    public static function Trim(string $str) : string
    {
        return preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '', $str);
    }
    #endregion




    /**
     * 文字列にUnicodeの制御文字が存在するか判定する。
     * @param $str string 制御文字が存在するか判定したい文字列
     * @param $removeJudgeTgtCharList array 判定対象外としたい制御文字キー(StringUtil::UNICODE_CTRL_CHAR_LISTのキー)
     * @return bool 制御文字が存在するならばtrue、それ以外はfalse
     * @throws InvalidArgumentException 制御文字キーが定義されていない場合に、InvalidArgumentExceptionを投げる。
     */
    #region ExistsUnicodeCtrlChars
    public static function ExistsUnicodeCtrlChars(string $str, array $removeJudgeTgtCharList = []) : bool
    {
        foreach($removeJudgeTgtCharList as $removeJudgeTgtChar)
        {
            if(!isset(self::UNICODE_CTRL_CHAR_LIST[$removeJudgeTgtChar]))
            {
                $msg = 'パラメータ:$removeJudgeTgtCharが不正です。'.PHP_EOL;
                $msg .= (string)$removeJudgeTgtChar.'は、StringUtil::UNICODE_CTRL_CHAR_LISTに、定義されていません。';
                throw new InvalidArgumentException($msg);
            }
        }


        // 対象制御文字の生成
        $needle = '';

        foreach(self::UNICODE_CTRL_CHAR_LIST as $unicodeCtrlCharKey => $unicodeCtrlChar)
        {
            if(!array_search($unicodeCtrlCharKey, $removeJudgeTgtCharList, true))
            {
                $needle[] = hex2bin($unicodeCtrlChar);
            }
        }


        // 検索処理
        $ret = strpos($str, $needle);

        if($ret === false)
        {
            return false;
        }

        return true;
    }
    #endregion




    /**
     * Null又は、空文字列であるか判定する。
     * @param $arg string|null Null又は、空文字列であるか判定したい変数
     * @return bool Null又は、空文字列である場合にtrue、それ以外の場合はfalse
     */
    #region IsNullOrEmpty
    public static function IsNullOrEmpty(?string $arg) : bool
    {
        if($arg === null)
        {
            return true;
        }

        if(strlen($arg) < 1)
        {
            return true;
        }

        return false;
    }
    #endregion




    /**
     * Null又は、空文字列、制御文字列のみであるか判定する。
     * @param string|null Null又は、空文字列、制御文字列のみであるか判定したい変数
     * @return bool Null又は、空文字列、制御文字列のみである場合にtrue、それ以外の場合はfalse
     */
    #region IsNullOrWhiteSpace
    public static function IsNullOrWhiteSpace(?string $arg) : bool
    {
        if($arg === null)
        {
            return true;
        }

        $arg = self::Trim($arg);

        return self::IsNullOrEmpty($arg);
    }
    #endregion




    /**
     * 文字列を置換する。(mb対応のstr_replace())
     * @param string 検索文字列
     * @param string 置換文字列
     * @param string 対象文字列
     * @return string 検索文字列内の対象文字列を置換文字列で置き換えた文字列
     */
    #region StrReplace
    public static function StrReplace(string $search, string $replace, string $subject)
    {
        $searchLen = mb_strlen($search);
        $replaceLen = mb_strlen($replace);


        // 置換処理
        $offset = mb_strpos($subject, $search);
        while ($offset !== FALSE)
        {
            $subject = mb_substr($subject, 0, $offset).$replace.mb_substr($subject, $offset + $searchLen);
            $offset = mb_strpos($subject, $search, $offset + $replaceLen);
        }


        return $subject;
    }
    #endregion
}