<?php
namespace Cmsr\Model\Struct;

use Cmsr\FWConst;

/**
 * 構造体: HTTP応答構造体
 */
class HttpResponseStruct
{
    // ================================================================
    // - 変数
    // ================================================================
    /** @var string MimeType */
    public $MimeType = '';

    /** @var int HTTPステータスコード */
    public $HTTPStatusCode = FWConst::HTTP_STATUSCODE_OK;

    /** @var string[] 応答ヘダー */
    public $Header = [];

    /** @var string 応答文字列 */
    public $Body = '';
}
