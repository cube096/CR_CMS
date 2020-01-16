<?php
namespace Cmsr\Model\Struct;

/**
 * 構造体: 例外情報構造体
 */
class ExceptionInfoStruct
{
    // ================================================================
    // - 変数
    // ================================================================
    /** @var string 種別区分 */
    public $ErrorKbn = '';

    /** @var string コード */
    public $Code = '';

    /** @var string メッセージ */
    public $Message = '';

    /** @var string ファイル名 */
    public $FileName = '';

    /** @var int 行*/
    public $LineNumber = 0;

    /** @var string スタックトレース */
    public $StackTrace = '';

    /** @var array スタックトレース(配列) */
    public $StackTraceArray = [];

    /** @var string 発生日時 */
    public $OccurredDtTm = '';

    /** @var string IPアドレス */
    public $IPAdr = '';

    /** @var string HTTP User-Agent */
    public $UserAgent = '';

    /** @var string HTTP Method */
    public $HttpMethod = '';

    /** @var string リクエストURI */
    public $RequestUri = '';

    /** @var string セッションID */
    public $SessionID = '';
}
