<?php
namespace Cmsr;

/**
 * フレームワーク定数群
 */
class FWConst
{
    // ================================================================
    // CMSR
    // ================================================================
    #region CMSR
    /** CMSRでサポートしているHTTPメソッドのリスト */
    public const SUPPORTED_HTTP_METHOD_LIST = [
        self::HTTP_METHOD_HEAD
      , self::HTTP_METHOD_GET
      , self::HTTP_METHOD_POST
      , self::HTTP_METHOD_PUT
      , self::HTTP_METHOD_DELETE
    ];
    #endregion




    // ================================================================
    // - CMSR設定項目 (cmsr-settings.json)
    // ================================================================
    #region CMSR設定項目 (cmsr-settings.json)
    /** CMSR設定項目: アプリケーション名 */
    public const CMSR_SETTING_ITEM_APPLICATION_NAME = 'ApplicationName';

    /** CMSR設定項目: サイト名 */
    public const CMSR_SETTING_ITEM_SITE_TITLE = 'SiteTitle';

    /** CMSR設定項目: タイトル区切文字 */
    public const CMSR_SETTING_ITEM_TITLE_SEPARATOR = 'TitleSeparator';

    /** CMSR設定項目: サイトUrl */
    public const CMSR_SETTING_ITEM_SITE_URL = 'SiteUrl';

    /** CMSR設定項目: 運用Eメールアドレス */
    public const CMSR_SETTING_ITEM_MASTER_EMAIL_ADR = 'MasterEMailAdr';

    /** CMSR設定項目: アプリケーション名前空間 */
    public const CMSR_SETTING_ITEM_APPLICATION_NAME_SPACE = 'ApplicationNameSpace';

    /** CMSR設定項目: 開発者モード */
    public const CMSR_SETTING_ITEM_DEVELOPER_MODE = 'DeveloperMode';

    /** CMSR設定既定値: アプリケーション名 */
    public const CMSR_SETTING_DEFAULT_VALUE_APPLICATION_NAME = '無題のアプリケーション';

    /** CMSR設定既定値: サイト名 */
    public const CMSR_SETTING_DEFAULT_VALUE_SITE_TITLE = '無題のサイト';

    /** CMSR設定既定値: タイトル区切文字 */
    public const CMSR_SETTING_DEFAULT_VALUE_TITLE_SEPARATOR = ' | ';

    /** CMSR設定既定値: アプリケーション名前空間 */
    public const CMSR_SETTING_DEFAULT_VALUE_APPLICATION_NAME_SPACE = 'CmsrApplication';

    /** CMSR設定既定値: 開発者モード */
    public const CMSR_SETTING_DEFAULT_VALUE_DEVELOPER_MODE = false;
    #endregion




    // ================================================================
    // - ルーティング設定項目 (cmsr-routing.json)
    // ================================================================
    #region ルーティング設定項目 (cmsr-routing.json)
    /** ルーティング設定項目: リクエストURI */
    public const ROUTING_SETTING_ITEM_REQUEST_URI = 'SiteTitle';

    /** ルーティング設定項目: コントローラ名 */
    public const ROUTING_SETTING_ITEM_CONTROLLER_NAME = 'ControllerName';

    /** ルーティング設定項目: ビューファイルパス */
    public const ROUTING_SETTING_ITEM_VIEW_FILE_PATH = 'ViewFile';
    #endregion




    // ================================================================
    // - データベース設定項目 (cmsr-database.json)
    // ================================================================
    #region データベース設定項目 (cmsr-database.json)
    /** データベース設定項目: サーバーホスト名 */
    public const DATABASE_SETTING_ITEM_HOST = 'Host';

    /** データベース設定項目: サーバーポート */
    public const DATABASE_SETTING_ITEM_PORT = 'Port';

    /** データベース設定項目: データベース名 */
    public const DATABASE_SETTING_ITEM_DATABASE = 'Name';

    /** データベース設定項目: ユーザー名 */
    public const DATABASE_SETTING_ITEM_USER = 'User';

    /** データベース設定項目: パスワード */
    public const DATABASE_SETTING_ITEM_PASSWORD = 'Pswd';

    /** データベース設定項目: 文字エンコーディング */
    public const DATABASE_SETTING_ITEM_CHARSET = 'Char';
    #endregion




    // ================================================================
    // - メンテナンス設定項目 (cmsr-maintenance.json)
    // ================================================================
    #region メンテナンス設定項目 (cmsr-maintenance.json)
    /** メンテナンス設定項目: メンテナンスモードへ移行可能か否か */
    public const MAINTENANCE_SETTING_ITEM_CAN_ACTIVATE = 'CanActivate';

    /** メンテナンス設定項目: メンテナンス開始日時 */
    public const MAINTENANCE_SETTING_ITEM_BEGIN_DATETIME = 'BeginDtTm';

    /** データベース設定項目: メンテナンス終了日時 */
    public const MAINTENANCE_SETTING_ITEM_END_DATETIME = 'EndDtTm';

    /** データベース設定項目: 案内文言 */
    public const MAINTENANCE_SETTING_ITEM_GUIDANCE = 'Text';
    #endregion




    // ================================================================
    // - プラグイン設定項目 (cmsr-plugins.json)
    // ================================================================
    #region プラグイン設定項目 (cmsr-plugins.json)
    /** プラグイン設定項目: ディレクトリ名 */
    public const PLUGIN_SETTING_ITEM_DIR_NAME = 'PluginDir';

    /** プラグイン設定項目: 有効か否か */
    public const PLUGIN_SETTING_ITEM_ENABLED = 'Enabled';

    /** プラグイン設定項目: プラグインのルートネームスペース */
    public const PLUGIN_SETTING_ITEM_ROOT_NAMESPACE = 'RootNameSpace';
    #endregion




    // ================================================================
    // ディレクトリ
    // ================================================================
    #region ディレクトリ
    /** PATH: Root */
    public const PATH_ROOT = __DIR__.'/..';

    /** PATH: コンテンツ類Root */
    public const PATH_CONTENT_ROOT = self::PATH_ROOT.'/cmsr-contents';

    /** PATH: システムRoot */
    public const PATH_SYSTEM_ROOT = self::PATH_ROOT.'/cmsr-system';

    /** PATH: アプリケーション */
    public const PATH_APPLICATION_ROOT = self::PATH_ROOT.'/cmsr-application';

    /** PATH: 外部ライブラリ類Root */
    public const PATH_EXT_LIB_ROOT = self::PATH_CONTENT_ROOT.'/libs';

    /** PATH: ログ類Root */
    public const PATH_LOG_ROOT = self::PATH_CONTENT_ROOT.'/logs';

    /** PATH: エラーログRoot */
    public const PATH_ERROR_LOG_ROOT = self::PATH_LOG_ROOT.'/error';

    /** PATH: アクションログRoot */
    public const PATH_ACTION_LOG_ROOT = self::PATH_LOG_ROOT.'/action';

    /** PATH: プラグイン類Root */
    public const PATH_PLUGIN_ROOT = self::PATH_CONTENT_ROOT.'/plugins';
    #endregion




    // ================================================================
    // ファイルパス
    // ================================================================
    #region ファイルパス
    /** ファイルパス: CMSR設定ファイル */
    public const FILE_PATH_CMSR_SETTINGS = self::PATH_APPLICATION_ROOT.'/'.self::FILE_NAME_CMSR_SETTINGS;

    /** ファイルパス: ルーティング設定ファイル */
    public const FILE_PATH_ROUTING_SETTINGS = self::PATH_APPLICATION_ROOT.'/'.self::FILE_NAME_ROUTING_SETTINGS;

    /** ファイルパス: データベース設定ファイル */
    public const FILE_PATH_DATABASE_SETTINGS = self::PATH_ROOT.'/'.self::FILE_NAME_DATABASE_SETTINGS;

    /** ファイルパス: メンテナンス設定ファイル */
    public const FILE_PATH_MAINTENANCE_SETTINGS = self::PATH_ROOT.'/'.self::FILE_NAME_MAINTENANCE_SETTINGS;

    /** ファイルパス: プラグイン設定ファイル */
    public const FILE_PATH_PLUGIN_SETTINGS = self::PATH_PLUGIN_ROOT.'/'.self::FILE_NAME_PLUGIN_SETTINGS;
    #endregion




    // ================================================================
    // ファイル名
    // ================================================================
    #region ファイル名
    /** ファイル名: CMSR設定ファイル */
    public const FILE_NAME_CMSR_SETTINGS = 'cmsr-settings.json';

    /** ファイル名: ルーティング設定ファイル */
    public const FILE_NAME_ROUTING_SETTINGS = 'cmsr-routing.json';

    /** ファイル名: データベース設定ファイル */
    public const FILE_NAME_DATABASE_SETTINGS = 'cmsr-database.json';

    /** ファイル名: メンテナンス設定ファイル */
    public const FILE_NAME_MAINTENANCE_SETTINGS = 'cmsr-maintenance.json';

    /** ファイル名: プラグイン設定ファイル */
    public const FILE_NAME_PLUGIN_SETTINGS = 'cmsr-plugins.json';

    /** ファイル名: Indexファイル */
    public const FILE_NAME_INDEX = 'index.html';
    #endregion




    // ================================================================
    // 名前空間
    // ================================================================
    #region 名前空間
    /** 名前空間: CMSR本体 */
    public const NAMESPACE_FW_ROOT = 'Cmsr';
    #endregion




    // ================================================================
    // 日時/日付フォーマット
    // ================================================================
    #region 日時/日付フォーマット
    /** 日時フォーマット: システム用 */
    const DATETIME_FORMAT_SYSTEM= 'Y-m-d H:i:s';

    /** 日時フォーマット: ファイル名用(年月日) */
    const DATETIME_FORMAT_FILE_NAME_DATE = 'Y-m-d';

    /** 日時フォーマット: ファイル名用(日時) */
    const DATETIME_FORMAT_FILE_NAME_DATETIME = 'Y-m-d_H-i-s';

    /** 日付フォーマット: 画面表示用(年月日) */
    const DATETIME_FORMAT_DISPLAY_DATE = 'Y年m月d日';

    /** 日付フォーマット: 画面表示用(日時) */
    const DATETIME_FORMAT_DISPLAY_DATETIME = 'Y年m月d日 H時i分s秒';

    /** 日時フォーマット: HTML.datetime属性用(年月日) */
    const DATETIME_FORMAT_HTML_ATTR_DATE = 'Y-m-d H:i:s';

    /** 日時フォーマット: HTML.datetime属性用(日時) */
    const DATETIME_FORMAT_HTML_ATTR_DATETIME = 'Y-m-d H:i:s';
    #endregion




    // ================================================================
    // MimeType
    // ================================================================
    #region MimeType
    /** MimeType: TEXT */
    public const MIMETYPE_TEXT = 'text/plain';

    /** MimeType: HTML */
    public const MIMETYPE_HTML = 'text/html';

    /** MimeType: JSON */
    public const MIMETYPE_JSON = 'application/json';

    /** MimeType: JPEG */
    public const MIMETYPE_JPG = 'image/jpeg';

    /** MimeType: PNG */
    public const MIMETYPE_PNG = 'image/png';

    /** MimeType: GIF */
    public const MIMETYPE_GIF = 'image/gif';
    #endregion




    // ================================================================
    // BASE SYSTEM / OPERATION SYSTEM
    // ================================================================
    #region BASE SYSTEM / OPERATION SYSTEM
    /** ファイル拡張子: PHP */
    public const FILE_EXTENSION_PHP = 'php';

    /** ファイル拡張子: LOG */
    public const FILE_EXTENSION_LOG = 'log';

    /** ファイル拡張子: JSON */
    public const FILE_EXTENSION_JSON = 'json';

    /** ファイル拡張子: HTML */
    public const FILE_EXTENSION_HTML = 'html';

    /** ファイル拡張子: SQL */
    public const FILE_EXTENSION_SQL = 'sql';

    /** ファイル拡張子: TPL */
    public const FILE_EXTENSION_TPL = 'tpl';

    /** ファイル拡張子: JPEG */
    public const FILE_EXTENSION_JPG = 'jpg';

    /** ファイル拡張子: PNG */
    public const FILE_EXTENSION_PNG = 'png';

    /** ファイル拡張子: GIF */
    public const FILE_EXTENSION_GIF = 'gif';

    /** ファイル拡張子: Eメールテンプレート: */
    public const FILE_EXTENSION_MAIL_TEMPLATE = 'mtpl';

    /** ファイルパーミッション: 既定 */
    public const FILE_PERMISSION_DEFAULT = 0777;
    #endregion




    // ================================================================
    // DISPATCH / WEB CONTROLLER
    // ================================================================
    #region DISPATCH / WEB CONTROLLER
    /** Controllerのクラス名接尾辞 */
    public const CONTOLLER_CLASS_SUFFIX = 'Controller';
    #endregion





    // ================================================================
    // HASH
    // ================================================================
    #region HASH
    /** ハッシュアルゴリズム: セキュアな処理用 */
    public const HASH_ALGO_SECURITY = 'SHA512';

    /** ハッシュアルゴリズム: ランダムな処理用 */
    public const HASH_ALGO_RANDOM = 'md5';
    #endregion




    // ================================================================
    // 文字列
    // ================================================================
    #region 文字列
    /** LANGUAGE:JA */
    public const LANGUAGE_JA = 'ja';

    /** ENCODING:UTF-8 */
    public const ENCODING_UTF8 = 'UTF-8';

    /** CR改行文字 */
    public const EOL_CR = "\r";

    /** LF改行文字 */
    public const EOL_LF = "\n";

    /** CRLF改行文字 */
    public const EOL_CRLF = "\r\n";
    #endregion




    // ================================================================
    // EMAIL
    // ================================================================
    #region EMAIL
    /** Eメールヘダーフィールドの1行辺りの最大長 */
    public const EMAIL_HEADER_FIELD_MAX_LENGTH = 998;
    #endregion



    // ================================================================
    // HTTP
    // ================================================================
    #region HTTP
    // - HTTPステータスコード
    /** 200: OK */
    public const HTTP_STATUSCODE_OK = 200;

    /** 301: Moved Permanently */
    public const HTTP_STATUSCODE_MOVED_PERMANENTLY = 301;

    /** 302: Found */
    public const HTTP_STATUSCODE_FOUND = 302;

    /** 303: See Other */
    public const HTTP_STATUSCODE_SEE_OTHER = 303;

    /** 307: Temporary Redirect */
    public const HTTP_STATUSCODE_TEMPORARY_REDIRECT = 307;

    /** 400: Bad Request */
    public const HTTP_STATUSCODE_BAD_REQUEST = 400;

    /** 401: Unauthorized */
    public const HTTP_STATUSCODE_UNAUTHRIZED = 401;

    /** 403: Forbidden */
    public const HTTP_STATUSCODE_FORBIDDEN = 403;

    /** 404: Not Found */
    public const HTTP_STATUSCODE_NOT_FOUND = 404;

    /** 405: Method Not Allowed */
    public const HTTP_STATUSCODE_METHOD_NOT_ALLOWED = 405;

    /** 500: Internal Server Error */
    public const HTTP_STATUSCODE_INTERNAL_SERVER_ERROR = 500;

    /** 503: Service Unavailable */
    public const HTTP_STATUSCODE_SERVICE_UNAVAILABLE = 503;

    /** GET Method */
    public const HTTP_METHOD_GET = 'GET';

    /** POST Method */
    public const HTTP_METHOD_POST = 'POST';

    /** PUT Method */
    public const HTTP_METHOD_PUT = 'PUT';

    /** DELETE Method */
    public const HTTP_METHOD_DELETE = 'DELETE';

    /** HEAD Method */
    public const HTTP_METHOD_HEAD = 'HEAD';
    #endregion




    // ================================================================
    // - データベース
    // ================================================================
    #region データベース
    /** DB: 文字列型初期値 */
    public const DATABASE_INIT_VALUE_STRING = '';

    /** DB: 整数型初期値 */
    public const DATABASE_INIT_VALUE_INTEGER = 0;

    /** DB: Date型初期値 */
    public const DATABASE_INIT_VALUE_DATE = '1000-01-01';

    /** DB: DateTime型初期値 */
    public const DATABASE_INIT_VALUE_DATETIME = '1000-01-01 00:00:00';

    /** DB: フラグ:True */
    public const DATABASE_FLG_VALUE_TRUE = 1;

    /** DB: フラグ:False */
    public const DATABASE_FLG_VALUE_FALSE = 0;

    /** DB: DateTime型MAX値 */
    public const DATABASE_MAX_VALUE_DATETIME = '9999-12-31 23:59:59';

    /** DB: DateTime型MIN値 */
    public const DATABASE_MIN_VALUE_DATETIME = '1000-01-01 00:00:00';
    #endregion




    // ================================================================
    // - 処理制御
    // ================================================================
    #region 処理制御
    /** 文字列処理: 置換範囲マーカ */
    public const REPLACE_RANGE_MARKER = '*';
    #endregion
}