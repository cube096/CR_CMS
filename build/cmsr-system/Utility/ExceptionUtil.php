<?php
namespace Cmsr\Utility;

use Throwable;
use Cmsr\FWConst;
use Cmsr\CmsrManager;
use Cmsr\Exception\APExceptionBase;
use Cmsr\Model\Struct\ExceptionInfoStruct;

/**
 * 例外に関する操作を行うユーティリティクラス
 */
class ExceptionUtil
{
    // ================================================================
    // 定数
    // ================================================================
    /** バッチ処理環境 */
    public const ENV_BATCH = 1;

    /** CGI処理環境 */
    public const ENV_CGI = 2;






    // ================================================================
    // メソッド
    // ================================================================
    /**
     * Throwable実装クラスのインスタンスから、例外情報構造体を作成する。
     * @param Throwable $throwable Throwable実装クラスのインスタンス
     * @param int $flgBit フラグ値(Bit)
     * @return ExceptionInfoStruct 例外情報構造体
     */
    #region CreExceptionInfoStruct
    public static function CreExceptionInfoStruct(Throwable $throwable, int $flgBit = self::ENV_CGI) : ExceptionInfoStruct
    {
        $exceptionInfoStruct = new ExceptionInfoStruct();

        if($throwable instanceof APExceptionBase)
        {
            // AP例外の場合
            $exceptionInfoStruct->Code = (string)$throwable->getCode();
            $exceptionInfoStruct->Message = $throwable->getMessage();
            $exceptionInfoStruct->OccurredDtTm = $throwable->GetOccurredDtTm();
        }
        else
        {
            // 標準例外の場合
            $exceptionInfoStruct->Code = (string)$throwable->getCode();
            $exceptionInfoStruct->Message = $throwable->getMessage();
            $exceptionInfoStruct->OccurredDtTm = date(FWConst::DATETIME_FORMAT_SYSTEM);
        }

        $exceptionInfoStruct->FileName = $throwable->getFile();
        $exceptionInfoStruct->LineNumber = $throwable->getLine();
        $exceptionInfoStruct->StackTrace = $throwable->getTraceAsString();
        $exceptionInfoStruct->StackTraceArray = $throwable->getTrace();

        if(self::ENV_CGI & $flgBit)
        {
            $exceptionInfoStruct->IPAdr = HttpUtil::GetIPAdr();
            $exceptionInfoStruct->UserAgent = HttpUtil::GetUserAgent();
            $exceptionInfoStruct->HttpMethod = HttpUtil::GetRequestMethod();
            $exceptionInfoStruct->RequestUri = HttpUtil::GetRequestUri();
            $exceptionInfoStruct->SessionID = session_id();
        }

        return $exceptionInfoStruct;
    }
    #endregion




    /**
     * エラーを記録する。
     * @param ExceptionInfoStruct $exInfoStruct 例外情報構造体
     */
    #region Logging
    public static function Logging(ExceptionInfoStruct $exInfoStruct) : void
    {
        // テキストログ
        $loggedAt = $exInfoStruct->OccurredDtTm;

        $path = FWConst::PATH_ERROR_LOG_ROOT.'/';
        $path .= date(FWConst::DATETIME_FORMAT_FILE_NAME_DATE, strtotime($loggedAt)).'/';
        $path .= date(FWConst::DATETIME_FORMAT_FILE_NAME_DATETIME, strtotime($loggedAt));
        $path .= '_'.hash(FWConst::HASH_ALGO_RANDOM, $loggedAt.(string)mt_rand()).'.'.FWConst::FILE_EXTENSION_LOG;

        $elements = [];
        $elements[] = 'Code        : '.$exInfoStruct->Code;
        $elements[] = 'Message     : '.$exInfoStruct->Message;
        $elements[] = 'File        : '.$exInfoStruct->FileName;
        $elements[] = 'Line        : '.(string)$exInfoStruct->LineNumber;
        $elements[] = 'OccurredDtTm: '.$exInfoStruct->OccurredDtTm;
        $elements[] = 'IPAdr       : '.$exInfoStruct->IPAdr;
        $elements[] = 'UserAgent   : '.$exInfoStruct->UserAgent;
        $elements[] = 'HttpMethod  : '.$exInfoStruct->HttpMethod;
        $elements[] = 'RequestUri  : '.$exInfoStruct->RequestUri;
        $elements[] = 'SessionID   : '.$exInfoStruct->SessionID;
        $elements[] = 'StackTrace  : '.FWConst::EOL_LF.$exInfoStruct->StackTrace;

        $txt = '';
        foreach($elements as $value)
        {
            $txt .= $value.FWConst::EOL_LF;
        }

        FileUtil::FilePutContents($path, $txt);
    }
    #endregion




    /**
     * エラーを通知する。
     * @param ExceptionInfoStruct $exInfoStruct 例外情報構造体
     */
    #region Notify
    public static function Notify(ExceptionInfoStruct $exInfoStruct) : void
    {
        $elements = [];
        $elements[] = 'Code        : '.$exInfoStruct->Code;
        $elements[] = 'Message     : '.$exInfoStruct->Message;
        $elements[] = 'File        : '.$exInfoStruct->FileName;
        $elements[] = 'Line        : '.(string)$exInfoStruct->LineNumber;
        $elements[] = 'OccurredDtTm: '.$exInfoStruct->OccurredDtTm;
        $elements[] = 'IPAdr       : '.$exInfoStruct->IPAdr;
        $elements[] = 'UserAgent   : '.$exInfoStruct->UserAgent;
        $elements[] = 'HttpMethod  : '.$exInfoStruct->HttpMethod;
        $elements[] = 'RequestUri  : '.$exInfoStruct->RequestUri;
        $elements[] = 'SessionID   : '.$exInfoStruct->SessionID;
        $elements[] = 'StackTrace  : '.FWConst::EOL_LF.$exInfoStruct->StackTrace;

        $applicationName = (string)CmsrManager::GetSettingValue(FWConst::CMSR_SETTING_ITEM_APPLICATION_NAME);
        $subject = '';
        $subject .= '['.hash(FWConst::HASH_ALGO_RANDOM, $exInfoStruct->OccurredDtTm.(string)mt_rand()).'] '.$applicationName;
        $subject .= ' - Emergency ['.$exInfoStruct->OccurredDtTm.']';

        $body = '';
        foreach($elements as $value) {
            $body .= $value.FWConst::EOL_LF;
        }


        // メール送信
        $origEMailAdr = (string)CmsrManager::GetSettingValue(FWConst::CMSR_SETTING_ITEM_MASTER_EMAIL_ADR);
        $destEMailAdr = (string)CmsrManager::GetSettingValue(FWConst::CMSR_SETTING_ITEM_MASTER_EMAIL_ADR);
        EMailUtil::Send($origEMailAdr, $destEMailAdr, $subject, $body);
    }
    #endregion
}