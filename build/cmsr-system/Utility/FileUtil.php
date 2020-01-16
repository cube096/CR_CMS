<?php
namespace Cmsr\Utility;

use Exception;
use Cmsr\FWConst;
use Cmsr\Exception\FileNotFoundException;

/**
 * ファイル関連の操作を行う為のUtilityクラス
 */
class FileUtil
{
    // ================================================================
    // - メソッド
    // ================================================================
    /**
     * データをファイルに書き込む
     * @param string $filePath ファイルパス
     * @param string $data 書き込み内容
     * @return int ファイルに書き込まれたバイト数(失敗した場合に-1)
     */
    #region FilePutContents
    public static function FilePutContents(string $filePath, string $data) : int
    {
        $dir = mb_substr($filePath, 0, (mb_strrpos($filePath, DIRECTORY_SEPARATOR) + 1)); // ディレクトリを抽出

        if(!file_exists($dir) || !is_dir($dir))
        {
            // 保管ディレクトリがない場合は作成
            $mkdirResult = mkdir($dir, FWConst::FILE_PERMISSION_DEFAULT, true);
            if(!$mkdirResult )
            {
                return -1;
            }
        }

        $writtenBytes = file_put_contents($filePath, $data);

        if($writtenBytes === false) {
            $writtenBytes = -1;
        }

        return $writtenBytes;
    }
    #endregion




    /**
     * ファイルサイズを取得する。
     * @param string $filePath ファイルパス
     * @return int ファイルの総バイト数
     * @throws FileNotFoundException 指定ファイルが存在しない場合に、FileNotFoundExceptionを投げる。
     */
    #region GetFileBytes
    public static function GetFileBytes(string $filePath) : int {
        if(!self::ExistsFile($filePath))
        {
            // ファイルが存在しない場合は、例外を発生させる。
            throw new FileNotFoundException("ファイル:\"'{$filePath}'\"が存在しません。");
        }

        return filesize($filePath);
    }
    #endregion




    /**
     * そのファイルの文字列を返す
     * @param string $path ファイルパス
     * @return string そのファイルの文字列
     * @throws FileNotFoundException 指定ファイルが存在しない場合に、FileNotFoundExceptionを投げる。
     * @throws Exception 指定ファイルを取得できなかった場合に、Exceptionを投げる。
     */
    #region ReadString
    public static function ReadString(string $path) : string
    {
        if(!self::ExistsFile($path))
        {
            throw new FileNotFoundException("ファイル:\"'{$path}'\"が存在しません。");
        }

        $str = file_get_contents($path);

        if($str === false)
        {
            throw new Exception("ファイル:\"'{$path}'\"が取得できませんでした。");
        }

        return $str;
    }
    #endregion



    /**
     * ファイルが存在するか判定する。
     * @param string $path ファイルパス
     * @return bool ファイルが存在するならばtrue、それ以外はfalse
     */
    #region ExistsFile
    public static function ExistsFile(string $path) : bool
    {
        if(file_exists($path) && !is_dir($path))
        {
            return true;
        }

        return false;
    }
    #endregion




    /**
     * ディレクトリが存在するか判定する。
     * @param string $path ディレクトリパス
     * @return bool ディレクトリが存在するならばtrue、それ以外はfalse
     */
    #region ExistsDirectory
    public static function ExistsDirectory(string $path) : bool
    {
        if(file_exists($path) && is_dir($path))
        {
            return true;
        }

        return false;
    }
    #endregion
}
