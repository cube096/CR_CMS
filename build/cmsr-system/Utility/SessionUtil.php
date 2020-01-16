<?php
namespace Cmsr\Utility;

use Exception;
use LogicException;

/**
 * セッション関連の操作を行う為のUtilityクラス
 */
class SessionUtil
{
    // ========================================================
    // - 変数
    // ========================================================
    /** @var array Session情報配列 */
    private static $session;





    // ========================================================
    // - メソッド
    // ========================================================
    /**
     * セッションを開始する。
     * @return string セッションID
     * @throws Exception セッション開始に失敗した場合に、Exceptionを投げる。
     */
    #region Start
    public static function Start() : string
    {
        if(!session_start())
        {
            throw new Exception('セッション開始に失敗しました。');
        }

        self::$session = &$_SESSION;

        return session_id();
    }
    #endregion




    /**
     * セッションデータを取得する。
     * @return array セッションデータ
     * @throws LogicException セッションデータが配列でない場合に、LogicExceptionを投げる。
     */
    #region GetSessionData
    public static function GetSessionData() : array
    {
        if(!is_array(self::$session))
        {
            throw new LogicException('セッション開始に失敗しました。');
        }

        $session = unserialize(serialize(self::$session));

        return $session;
    }
    #endregion
}
