<?php
namespace Cmsr;

// 基本ファイルの読み込み
require_once(__DIR__.'/FWConst.php');
require_once(__DIR__.'/CmsrManager.php');
require_once(__DIR__.'/Exception/APExceptionBase.php');
require_once(__DIR__.'/Exception/FileNotFoundException.php');
require_once(__DIR__.'/Exception/InvalidFormatException.php');
require_once(__DIR__.'/Exception/JsonParseException.php');
require_once(__DIR__.'/Model/Struct/PluginInfoStruct.php');
require_once(__DIR__.'/Utility/ClassUtil.php');
require_once(__DIR__.'/Utility/EnvironmentUtil.php');
require_once(__DIR__.'/Utility/FileUtil.php');
require_once(__DIR__.'/Utility/StringUtil.php');
require_once(__DIR__.'/Utility/ValidationUtil.php');

// 初期化処理
CmsrManager::Initialization();
