<?php
namespace Cmsr\Model\Struct;

/**
 * 構造体: メンテナンス情報構造体
 */
final class MaintenanceInfoStruct
{
    // ================================================================
    // - 変数
    // ================================================================
    /** @var bool メンテナンスを有効化出来るか否か */
    public $CanActivate = false;

    /** @var string 開始日時 */
    public $BeginDtTm = '';

    /** @var string 終了日時 */
    public $EndDtTm = '';

    /** @var string 案内文言 */
    public $Text = '';
}
