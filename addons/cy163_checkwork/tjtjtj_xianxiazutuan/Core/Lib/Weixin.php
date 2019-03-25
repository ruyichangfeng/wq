<?php
/**
 * Created by PhpStorm.
 * User: TT
 * Date: 2016/3/13
 * Time: 13:56
 */

namespace Core\Lib;

class Weixin
{

    /**
     * @var 客服消息接口
     */
    CONST SEND_TEMPLATE_MESSAGE = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=%s';

    /**
     * @var 请求Access_Token URI
     */
    CONST GET_ACCESSTOKEN_URI = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s';

    /**
     * 发送模版消息
     * @author qsnh <616896861@qq.com>
     */
    public static function sendMessage( $access_token, $send )
    {
        $uri = sprintf( self::SEND_TEMPLATE_MESSAGE, $access_token );
        return \Core\Lib\Request::_curl( $uri, json_encode( $send ) );
    }

    /**
     * 获取普通的Access_token
     * @param string $appid
     * @param string $appsecret
     * @return json
     * @author qsnh <616896861@qq.com>
     */
    public static function getAccessToken( $appid, $appsecret )
    {
        $uri = sprintf( self::GET_ACCESSTOKEN_URI, $appid, $appsecret );
        $res = \Core\Lib\Request::_curl( $uri );
        $arr = json_decode( $res, true );
        return $arr;
    }

    /**
     *
     * 申请退款，WxPayRefund中out_trade_no、transaction_id至少填一个且
     * out_refund_no、total_fee、refund_fee、op_user_id为必填参数
     * appid、mchid、spbill_create_ip、nonce_str不需要填入
     * @param Weixin/Refund $inputObj
     * @param int $timeOut
     * @throws WxPayException
     * @return 成功时返回，其他抛异常
     */
    public static function refund($inputObj, $weixin)
    {
        $url = "https://api.mch.weixin.qq.com/secapi/pay/refund";
        //检测必填参数
        if(!$inputObj->IsOut_trade_noSet() && !$inputObj->IsTransaction_idSet()) {
            throw new \Exception("退款申请接口中，out_trade_no、transaction_id至少填一个！");
        }else if(!$inputObj->IsOut_refund_noSet()){
            throw new \Exception("退款申请接口中，缺少必填参数out_refund_no！");
        }else if(!$inputObj->IsTotal_feeSet()){
            throw new \Exception("退款申请接口中，缺少必填参数total_fee！");
        }else if(!$inputObj->IsRefund_feeSet()){
            throw new \Exception("退款申请接口中，缺少必填参数refund_fee！");
        }else if(!$inputObj->IsOp_user_idSet()){
            throw new \Exception("退款申请接口中，缺少必填参数op_user_id！");
        }
        $inputObj->SetAppid($weixin['appid']);//公众账号ID
        $inputObj->SetMch_id($weixin['mchid']);//商户号
        $inputObj->SetNonce_str(self::getNonceStr());//随机字符串

        $inputObj->SetSign();//签名
        $xml = $inputObj->ToXml();
        $response = \Core\Lib\Request::postXmlCurl($xml, $url, $weixin['pem'], 6);
        return $response;
    }

    /**
     * 查询退款
     * 提交退款申请后，通过调用该接口查询退款状态。退款有一定延时，
     * 用零钱支付的退款20分钟内到账，银行卡支付的退款3个工作日后重新查询退款状态。
     * WxPayRefundQuery中out_refund_no、out_trade_no、transaction_id、refund_id四个参数必填一个
     * appid、mchid、spbill_create_ip、nonce_str不需要填入
     * @param WxPayRefundQuery $inputObj
     * @param int $timeOut
     * @throws WxPayException
     * @return 成功时返回，其他抛异常
     */
    public static function refundQuery($inputObj, $weixin)
    {
        $url = "https://api.mch.weixin.qq.com/pay/refundquery";
        //检测必填参数
        if(!$inputObj->IsOut_refund_noSet() &&
            !$inputObj->IsOut_trade_noSet() &&
            !$inputObj->IsTransaction_idSet() &&
            !$inputObj->IsRefund_idSet()) {
            throw new WxPayException("退款查询接口中，out_refund_no、out_trade_no、transaction_id、refund_id四个参数必填一个！");
        }
        $inputObj->SetAppid($weixin['appid']);//公众账号ID
        $inputObj->SetMch_id($weixin['mchid']);//商户号
        $inputObj->SetNonce_str(self::getNonceStr());//随机字符串
        
        $inputObj->SetSign();//签名
        $xml = $inputObj->ToXml();
        $response = \Core\Lib\Request::postXmlCurl($xml, $url, false, 6);
        return $response;
    }


    /**
     *
     * 产生随机字符串，不长于32位
     * @param int $length
     * @return 产生的随机字符串
     */
    public static function getNonceStr($length = 32)
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str ="";
        for ( $i = 0; $i < $length; $i++ )  {
            $str .= substr($chars, mt_rand(0, strlen($chars)-1), 1);
        }
        return $str;
    }


}