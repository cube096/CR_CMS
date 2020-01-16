<?php
namespace Cmsr\Model\Struct;

/**
 * 構造体: プラグイン情報構造体
 */
final class PluginInfoStruct
{
    // ================================================================
    // - 変数
    // ================================================================
    /** @var string ディレクトリ名 */
    public $DirName = '';

    /** @var bool 有効か否か */
    public $Enabled = false;

    /** @var string プラグインのルートネームスペース */
    public $RootNameSpace = '';
}
