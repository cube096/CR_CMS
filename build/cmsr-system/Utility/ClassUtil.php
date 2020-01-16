<?php
namespace Cmsr\Utility;

use ReflectionClass;
use Cmsr\CmsrManager;
use Cmsr\FWConst;
use Cmsr\Model\Struct\PluginInfoStruct;

/**
 * クラス関係のUtilityクラス
 */
class ClassUtil
{
    // ========================================================
    // - メソッド
    // ========================================================
    /**
     * クラスを読み込む
     * @param string $className 名前空間を含む完全なクラス名
     * @return bool クラスが存在するならばtrue、それ以外はfalse
     */
    #region LoadClass
    public static function LoadClass(string $className) : bool
    {
        $applicationNamespace = CmsrManager::GetSettingValue(FWConst::CMSR_SETTING_ITEM_APPLICATION_NAME_SPACE);

        // 名前空間の先頭が"\"の場合は、それを除去する。
        if($className[0] === '\\')
        {
            $className = mb_substr($className, 1);
        }

        $appNamespaceLength = mb_strlen($applicationNamespace);
        $fwNamespaceLength = mb_strlen(FWConst::NAMESPACE_FW_ROOT);
        $isPluginClass = false;
        $pluginNamespace = '';
        $pluginNamespaceLength = 0;
        $pluginDirName = '';

        foreach(EnvironmentUtil::GetPluginInfoStructList() as $pluginInfoStruct)
        {
            if($pluginInfoStruct instanceof PluginInfoStruct)
            {
                if($pluginInfoStruct->Enabled)
                {
                    $pluginRootNamespace = '';
                    $pluginRootNamespace = $pluginInfoStruct->RootNameSpace;

                    if($pluginRootNamespace[0] === '\\')
                    {
                        $pluginRootNamespace = mb_substr($pluginRootNamespace, 1);
                    }

                    $pluginRootNamespaceLength = mb_strlen($pluginRootNamespace);
                    if(mb_substr($className, 0, $pluginRootNamespaceLength) === $pluginRootNamespace)
                    {
                        $isPluginClass = true;
                        $pluginNamespace = $pluginRootNamespace;
                        $pluginNamespaceLength = $pluginRootNamespaceLength;
                        $pluginDirName = $pluginInfoStruct->DirName;
                    }
                }
            }
        }


        // クラス定義ファイルの相対パス取得処理クロージャ
        $getClassFileRelatePath = function(string $className, int $prefixNamespaceLength) : string
        {
            $classPath = mb_substr($className, $prefixNamespaceLength);
            $classPath = str_replace('\\', '/', $classPath);
            $classPath = $classPath.'.'.FWConst::FILE_EXTENSION_PHP;
            if($classPath[0] === '/')
            {
                $classPath = mb_substr($classPath, 1);
            }
            return $classPath;
        };


        // クラスファイル絶対パス抽出処理
        $classFilePath = '';

        switch(true)
        {
            case mb_substr($className, 0, $appNamespaceLength) === $applicationNamespace:
                // アプリケーション
                $classFileRelatPath = $getClassFileRelatePath($className, $appNamespaceLength);
                $classFilePath = FWConst::PATH_APPLICATION_ROOT.'/'.$classFileRelatPath;
                break;
            case mb_substr($className, 0, $fwNamespaceLength) === FWConst::NAMESPACE_FW_ROOT:
                // CMSR
                $classFileRelatPath = $getClassFileRelatePath($className, $fwNamespaceLength);
                $classFilePath = FWConst::PATH_SYSTEM_ROOT.'/'.$classFileRelatPath;
                break;
            case $isPluginClass:
                // プラグイン
                $classFileRelatPath = $getClassFileRelatePath($className, $pluginNamespaceLength);
                $classFilePath = FWConst::PATH_PLUGIN_ROOT.'/'.$pluginDirName.'/'.$classFileRelatPath;
                break;
            default :
                // 外部ライブラリ
                $classFileRelatPath = $getClassFileRelatePath($className, 0);
                $classFilePath = FWConst::PATH_EXT_LIB_ROOT.'/'.$classFileRelatPath;
                break;
        }


        if(class_exists($className) || interface_exists($className) || trait_exists($className))
        {
            return true;
        }

        if(!FileUtil::ExistsFile($classFilePath))
        {
            return false;
        }

        require_once($classFilePath);

        return (class_exists($className) || interface_exists($className) || trait_exists($className));
    }
    #endregion




    /**
     * 指定したクラスに定義される定数の一覧を配列で返す
     * @param string $className 名前空間を含む完全なクラス名
     * @return array 指定したクラスで定義される定数を含む配列
     */
    #region GetClassConstants
    public static function GetClassConstants(string $className) : array
    {
        $reflect = new ReflectionClass($className);
        $constants = $reflect->getConstants();
        return $constants;
    }
    #endregion
}