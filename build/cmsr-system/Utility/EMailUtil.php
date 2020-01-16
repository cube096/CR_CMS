<?php
namespace Cmsr\Utility;

use Exception;
use Cmsr\FWConst;

/**
 * メール関係のUtilityクラス
 */
class EMailUtil
{
    // ========================================================
    // - メソッド
    // ========================================================
    /**
     * メールを送信する。
     * @param string $originEMailAdr 送信元メールアドレス
     * @param string $destEMailAdr 送信先メールアドレス
     * @param string $subject 件名
     * @param string $body 本文
     * @param array $header メールヘッダー
     * @throws Exception メール送信に失敗した場合に、Exceptionを投げる。
     */
    #region Send
    public static function Send(string $originEMailAdr, string $destEMailAdr, string $subject, string $body, array $header = []) : void
    {
        $header['From'] = $originEMailAdr;

        if(!mb_send_mail($destEMailAdr, $subject, $body, $header))
        {
            throw new Exception('メール送信に失敗しました。');
        }
    }
    #endregion




    /**
     * メールテンプレートを基準にメール本文を作成する。
     * @param string $mailTplPath メールテンプレートのパス
     * @param array $params 置換パラメータ
     * @return string メール本文
     */
    #region CreMailMsgByTemplate
    public static function CreMsgByTemplate(string $mailTplPath, array $params) : string
    {
        $mailBodyMsg = FileUtil::ReadString($mailTplPath);

        foreach($params as $key => $value)
        {
            if(is_string($value))
            {
                $search = FWConst::REPLACE_RANGE_MARKER.(string)$key.FWConst::REPLACE_RANGE_MARKER;
                $mailBodyMsg = StringUtil::StrReplace($search, $value, $mailBodyMsg);
            }
        }

        return $mailBodyMsg;
    }
    #endregion
}
