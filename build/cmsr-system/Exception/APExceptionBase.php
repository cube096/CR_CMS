<?php
namespace Cmsr\Exception;

use Exception;
use Cmsr\FWConst;
use Cmsr\Utility\ExceptionUtil;

/**
 * 例外クラスの基底クラス
 */
abstract class APExceptionBase extends Exception
{
    // ================================================================
    // - 変数
    // ================================================================
    /** @var string 例外発生日時 */
    protected $occurredDtTm = '';






    // ================================================================
    // - メソッド
    // ================================================================
    /**
     * コンストラクタ
     * @param string $message エラーメッセージ
     */
    #region __construct
    public function __construct(string $message = '')
    {
        $this->message = $message;
        $this->occurredDtTm = date(FWConst::DATETIME_FORMAT_SYSTEM);
    }
    #endregion




    /**
     * 例外発生を報告する。(ログ+メール通知)
     */
    #region Report
    public function Report() : void
    {
        // データ用意
        $exInfoStruct = ExceptionUtil::CreExceptionInfoStruct($this);

        // ログファイル作成
        ExceptionUtil::Logging($exInfoStruct);

        // 通知
        ExceptionUtil::Notify( $exInfoStruct);
    }
    #endregion




    /**
     * エラー発生日時を取得する。
     * @return string エラーの発生日時
     */
    #region GetOccurredDtTm
    public function GetOccurredDtTm() : string
    {
        return $this->occurredDtTm;
    }
    #endregion
}