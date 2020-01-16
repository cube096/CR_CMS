<?php
namespace Cmsr\Utility;

use Exception;
use Cmsr\FWConst;
use Cmsr\Exception\EnvironmentException;
use Cmsr\Model\Struct\HttpResponseStruct;

/**
 * HTTP関連の操作を行う為のUtilityクラス
 */
final class HttpUtil
{
    // ================================================================
    // - 定数
    // ================================================================
    /** URIにクエリストンリングを付加する。 */
    public const APPEND_QUERY_STRING = 1;

    /** URIにインデックスファイル名を付加する。 */
    public const APPEND_INDEX_FILE_NAME = 2;






    // ================================================================
    // - 変数
    // ================================================================
    /** @var string HTTPリクエストBody */
    private static $requestBody = null;






    // ================================================================
    // - メソッド
    // ================================================================
    /**
     * アクセスURIを取得する。
     * @param int $flgBit フラグ値(Bit)
     * @return string アクセスURI
     * @throws EnvironmentException $_SERVER['REQUEST_URI']が定義されていない場合に、EnvironmentExceptionを投げる。
     */
    #region GetRequestUri
    public static function GetRequestUri(int $flgBit = 0) : string
    {
        if(!isset($_SERVER['REQUEST_URI']))
        {
            throw new EnvironmentException('サーバー環境に問題あり。 パラメータ:$_SERVER["REQUEST_URI"]が定義されていません。');
        }

        $requestUri = $_SERVER['REQUEST_URI'];

        // クエリストリングを除去
        $requestUri = strtok($requestUri, '?');


        // インデックスファイル名を付加する。
        if(self::APPEND_INDEX_FILE_NAME & $flgBit)
        {
            if(mb_substr($requestUri, -1) === '/')
            {
                $requestUri .= FWConst::FILE_NAME_INDEX;
            }
        }
        else
        {
            if(mb_substr($requestUri, -(mb_strlen(FWConst::FILE_NAME_INDEX))) === FWConst::FILE_NAME_INDEX)
            {
                $requestUri = mb_substr($requestUri, 0, -(mb_strlen(FWConst::FILE_NAME_INDEX)));
            }
        }


        // クエリストリングを付加する。
        if(self::APPEND_QUERY_STRING & $flgBit)
        {
            if(!isset($_SERVER['QUERY_STRING']))
            {
                throw new Exception('サーバー環境に問題あり。 パラメータ:$_SERVER["QUERY_STRING"]が定義されていません。');
            }

            $queryString = $_SERVER['QUERY_STRING'];

            if(mb_strlen($queryString) > 0)
            {
                if($queryString[0] !== '?')
                {
                    $queryString = '?'.$queryString;
                }
            }

            $requestUri .= $queryString;
        }


        return $requestUri;
    }
    #endregion




    /**
     * HTTPSでのアクセスか判定する。
     * @return bool HTTPSでのアクセスならばtrue、それ以外はfalse
     */
    #region HasHttpsAccess
    public static function HasHttpsAccess() : bool
    {
        if(!isset($_SERVER['HTTPS']))
        {
            return false;
        }

        $https = $_SERVER['HTTPS'];

        if(
            StringUtil::IsNullOrEmpty(trim($https))
            || $https === 'off'
            || $https === 'false'
            || $https === '0'
            || $https === false
        )
        {
            return false;
        }

        return true;
    }
    #endregion




    /**
     * 許可されたメソッドでアクセスしていることを確認する。
     * @param string[] $acceptedMethods 許可されているHTTPメソッドのリスト
     * @param string[] $deniededMethods 拒否されているHTTPメソッドのリスト
     * @return bool 許可されたメソッドでのアクセスならばtrue、それ以外はfalse
     */
    #region HasAcceptedMethod
    public static function HasAcceptedMethod(
        array $acceptedMethods = FWConst::SUPPORTED_HTTP_METHOD_LIST
        , array $deniededMethods = []
    ) : bool
    {
        $requestHttpMethod = mb_strtoupper(self::GetRequestMethod());

        // 許可されているか確認
        if(array_search($requestHttpMethod, $acceptedMethods, true) === false)
        {
            return false;
        }

        // 拒否されていないか確認
        if(count($deniededMethods) > 0 && array_search($requestHttpMethod, $deniededMethods, true) !== false) {
            return false;
        }

        return true;
    }
    #endregion




    /**
     * $_SERVER['REQUEST_METHOD']の値を取得する。
     * @return string $_SERVER['REQUEST_METHOD']の文字列
     * @throws EnvironmentException $_SERVER['REQUEST_METHOD']が定義されていない場合に、EnvironmentExceptionを投げる。
     */
    #region GetRequestMethod
    public static function GetRequestMethod() : string
    {
        if(!isset($_SERVER['REQUEST_METHOD']))
        {
            throw new EnvironmentException('サーバー環境に問題あり。 パラメータ:$_SERVER["REQUEST_METHOD"]が定義されていません。');
        }

        return strtoupper(trim($_SERVER['REQUEST_METHOD']));
    }
    #endregion




    /**
     * $_SERVER['HTTP_USER_AGENT']の値を取得する。
     * @return string $_SERVER['HTTP_USER_AGENT']の文字列 (但し$_SERVER['HTTP_USER_AGENT']の定義がない場合は空文字)
     */
    #region GetUserAgent
    public static function GetUserAgent() : string
    {
        if(!isset($_SERVER['HTTP_USER_AGENT']))
        {
            return '';
        }

        return trim($_SERVER['HTTP_USER_AGENT']);
    }
    #endregion




    /**
     * HTTPリクエストBodyを取得する。
     * @return string リクエストbodyの文字列
     */
    #region GetRequestBody
    public static function GetRequestBody() : string {
        if(self::$requestBody === null)
        {
            $requestBody = '';

            $requestBody = file_get_contents('php://input');

            if($requestBody === false)
            {
                $requestBody = '';
            }

            self::$requestBody = $requestBody;
        }

        return self::$requestBody;
    }
    #endregion




    /**
     * GETパラメータを取得する。
     * @return array
     */
    #region GetQueryParameter
    public static function GetQueryParameter() : array
    {
        if(!isset($_GET))
        {
            return [];
        }

        return $_GET;
    }
    #endregion




    /**
     * $_SERVER['REMOTE_ADDR']の値を取得する。
     * @return string $_SERVER['REMOTE_ADDR']の文字列
     * @throws EnvironmentException $_SERVER['REMOTE_ADDR']が定義されていない場合に、EnvironmentExceptionを投げる。
     */
    #region GetIPAdr
    public static function GetIPAdr() : string
    {
        if(!isset($_SERVER['REMOTE_ADDR']))
        {
            throw new EnvironmentException('サーバー環境に問題あり。 パラメータ:$_SERVER["REMOTE_ADDR"]が定義されていません。');
        }

        return trim($_SERVER['REMOTE_ADDR']);
    }
    #endregion




    /**
     * HTTP応答を行う。
     * @param HttpResponseStruct $httpResponseStruct HTTP応答構造体
     */
    #region Respond
    public static function Respond(HttpResponseStruct $httpResponseStruct) : void
    {
        // ヘダー追加
        $httpResponseStruct->Header['Content-Type'] = $httpResponseStruct->MimeType;

        // ステータスコード
        http_response_code($httpResponseStruct->HTTPStatusCode);

        // HTTP応答ヘダー
        foreach($httpResponseStruct->Header as $key => $value)
        {
            header((string)$key.': '.(string)$value);
        }

        // HTTP応答ボディ
        echo $httpResponseStruct->Body;
    }
    #endregion




    /**
     * リダイレクトを行う。
     * @param string $uri 遷移先のURIを指定
     * @param integer $responseCode リダイレクトに際して、返答するHTTPレスポンスコード
     */
    #region Redirect
    public static function Redirect(string $uri, int $responseCode) : void
    {
        header('Location: '.$uri, true, $responseCode);
        exit;
    }
    #endregion




    /**
     * HTTPメソッドのパラメータを取得する。
     * @param string $methodName メソッド名
     * @return array メソッドの配列、ただし定義されない場合は空配列
     */
    #region GetParameters
    public static function GetParameters(string $methodName) : array
    {
        $methodName = mb_strtoupper($methodName);
        $args = [];

        switch(true) {
            // GET
            case $methodName === FWConst::HTTP_METHOD_GET:
                if(isset($_GET)) {
                    $args = $_GET;
                }
                break;
            // POST
            case $methodName === FWConst::HTTP_METHOD_POST:
                if(isset($_POST)) {
                    $args = $_POST;
                }
                break;
            default:
                parse_str(self::GetRequestBody(), $args);
        }

        return $args;
    }
    #endregion




    /**
     * $_SERVER['HTTP_HOST']の値を取得する。
     * @return string $_SERVER['HTTP_HOST']の文字列
     * @throws EnvironmentException $_SERVER['HTTP_HOST']が定義されていない場合に、EnvironmentExceptionを投げる。
     */
    #region GetHostName
    public static function GetHostName() : string
    {
        if(!isset($_SERVER['HTTP_HOST'])) {
            throw new EnvironmentException('サーバー環境に問題あり。 パラメータ:$_SERVER["HTTP_HOST"]が定義されていません。');
        }

        return trim($_SERVER['HTTP_HOST']);
    }
    #endregion




    /**
     * (未実装)正規化されたURLを生成する。
     * @param string $fixedUrl 正規化したい絶対URL文字列
     * @param bool $forceSSL SSL通信を強制するか否か
     * @param bool $removeWWW ドメイン先頭に"www."がある場合、それを除去するか否か
     * @param bool $removeIndexFileName リクエストURI末尾が既定ファイル名である場合、それを除去するか否か
     * @return string 正規化された絶対URL文字列
     */
    #region NormalizeUri
    public static function NormalizeUri (
          string $fixedUrl
        , bool $forceSSL = true
        , bool $removeWWW = true
        , bool $removeIndexFileName = true
    ) : string
    {
        // TODO: HttpUtil::NormalizeUri()を実装する。
        throw new \Cmsr\Exception\NotImplementedException('HttpUtil::NormalizeUri()は、実装されていません。');
    }
    #endregion
}