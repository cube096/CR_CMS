<?php
namespace Cmsr\Model\Struct;

/**
 * 構造体: DB接続情報構造体
 */
class DataBaseConnectInfoStruct
{
    // ================================================================
    // - 変数
    // ================================================================
    /** @var string ホスト名 */
    public $Host = '';

    /** @var string ポート番号 */
    public $Port = '';

    /** @var string データベース名 */
    public $Name = '';

    /** @var string ユーザー名 */
    public $User = '';

    /** @var string パスワード */
    public $Password = '';

    /** @var string 文字セット */
    public $Charset = '';
}
