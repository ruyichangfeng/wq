<?php

/**
 * 请求封装类
 * User: TT
 * Date: 2016/3/3
 * Time: 12:52
 */

namespace Core\Lib;

class Request
{

    /**
     * CURL封装
     */
    public static function _curl( $url, $postData = null )
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);  //请求URL
        curl_setopt($ch, CURLOPT_HEADER, 0);  //禁止输出头部信息
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //获取信息以文件流的格式返回
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        if( !is_null($postData) ){
            //启用POST提交
            curl_setopt($ch, CURLOPT_POST, 1);  //POST提交
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        }
        $return = curl_exec($ch);
        curl_close($ch);
        return $return;
    }

    /**
     * 以post方式提交xml到对应的接口url
     *
     * @param string $xml  需要post的xml数据
     * @param string $url  url
     * @param bool $useCert 是否需要证书，默认不需要
     * @param int $second   url执行超时时间，默认30s
     * @throws WxPayException
     */
    public static function postXmlCurl($xml, $url, $useCert = array(), $second = 30)
    {
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, TRUE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST, 2);
        //设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        if(!empty($useCert)){
            //设置证书
            //使用证书：cert 与 key 分别属于两个.pem文件
            curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
            curl_setopt($ch,CURLOPT_SSLCERT, $useCert[0]);
            curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
            curl_setopt($ch,CURLOPT_SSLKEY, $useCert[1]);
        }
        //post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        //运行curl
        $data = curl_exec($ch);
        //返回结果
        if($data){
            curl_close($ch);
            return $data;
        } else {
            $error = curl_errno($ch);
            curl_close($ch);
            return array(
                'status' => false,
                'code'   => $error,
            );
        }
    }

}