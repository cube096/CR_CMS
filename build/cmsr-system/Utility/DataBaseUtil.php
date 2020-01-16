<?php
namespace Cmsr\Utility;

use InvalidArgumentException;
use LogicException;
use PDO;
use Cmsr\FWConst;
use Cmsr\Exception\EnvironmentException;
use Cmsr\Model\Struct\DataBaseConnectInfoStruct;

/**
 * データベース関連の操作を行う為のUtilityクラス
 */
class DataBaseUtil
{
    // ========================================================
    // - 変数
    // ========================================================
    /** @var PDO PDOインスタンスリスト */
    protected static $pdoInstance;






    // ========================================================
    // - メソッド
    // ========================================================
    /**
     * データベースとの接続を確立する。
     */
    #region Connect
    protected function Connect() : void
    {
        $dbInfoStruct = EnvironmentUtil::GetDataBaseConnectInfoStruct();

        $dbHost = $dbInfoStruct->Host;
        $dbPort = $dbInfoStruct->Port;
        $dbName = $dbInfoStruct->Name;
        $dbUser = $dbInfoStruct->User;
        $dbPswd = $dbInfoStruct->Password;
        $dbChar = $dbInfoStruct->Charset;

        $dsn = 'mysql:dbname='.$dbName.';host='.$dbHost.';port='.$dbPort.';charset='.$dbChar;

        $options = [
            PDO::ATTR_EMULATE_PREPARES => false
          , PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];

        self::$pdoInstance = new PDO($dsn, $dbUser, $dbPswd, $options);
    }
    #endregion




    /**
     * データベースのPDOインスタンス(常に同一)を取得する。
     * @return PDO 指定したデータベース操作用のPDOインスタンス(常に同一)
     */
    #region GetInstance
    public static function GetInstance(string $databaseId) : PDO
    {
        if (!isset(self::$pdoInstance))
        {
            self::Connect();
        }

        return self::$pdoInstance;
    }
    #endregion
}
