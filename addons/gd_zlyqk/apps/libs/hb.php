<?php
/**
 * hb.php
 * 这不是一个自由软件！。
 * 任何企业和个人不允许对程序代码以任何形式任何目的再发布。
 * 开发: 冰源
 * 日期: 18-1-20
 * 时间: 下午2:03
 */

namespace ext\apps\libs;


class hb
{

    public $apiUrl="https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack";

    //发放红包
    function send($param,$scene,$hbInfo) {
        global $_W;
        $msg=array("code"=>0,"msg"=>"");
        $setting = uni_setting_load('payment', $_W['uniacid']);
        $papSetting = is_array($setting['payment']) ? $setting['payment'] : array();
        if(empty($papSetting['wechat'])){
            $msg['msg']="微信支付未配置";
            $this->createHbLog($param,$scene,$msg,$hbInfo);
            return $msg;
        }
        if(empty($papSetting['wechat']['mchid'])){
            $msg['msg']="微信商户号错误";
            $this->createHbLog($param,$scene,$msg,$hbInfo);
            return $msg;
        }
        $account=$_W['account'];
        $param['total_num'] = 1;
        $param['mch_id'] = $papSetting['wechat']['mchid'];
        $param['client_ip'] = $_SERVER['REMOTE_ADDR'];
        $param['wxappid']   = $account['key'];
        $scene['order_sn']=$param['mch_billno']= "10000098".date("YmdHis").rand(100000,999999);
        $param['nonce_str'] = $this->createRand();
        $stringA = $this->createSign($param,false);
        $stringSignTemp = $stringA."&key=".$papSetting['wechat']['apikey'];
        $sign = strtoupper(md5($stringSignTemp));
        $param['sign'] = $sign;
        $postXml = $this->arrayToXml($param);
        $responseXml = $this->postSsl($this->apiUrl,$postXml);
        $response = simplexml_load_string($responseXml,null,LIBXML_NOCDATA);
        if($response->return_code=="FAIL"){
            $msg['msg']=$response->return_msg;
            $this->createHbLog($param,$scene,$msg,$hbInfo);
            return $msg;
        }
        if($response->result_code=="FAIL"){
            $msg['msg']=(string)$response->err_code_des;
            $this->createHbLog($param,$scene,$msg,$hbInfo);
            return $msg;
        }
        $msg['msg']="红包发送成功";
        $msg['code']=1;
        $this->createHbLog($param,$scene,$msg,$hbInfo);
        return $msg;
    }

    //生成签名,参数：生成签名的参数和是否编码
    function createSign($arr,$urlEncode) {
        $buff = "";
        $reqPar="";
        ksort($arr);
        foreach ($arr as $k=>$v) {
            if(null!=$v && "null" != $v && "sign" != $k) {
                if ($urlEncode)  $v = urlencode($v);
                $buff.=$k."=".$v."&";
            }
        }
        if (strlen($buff)>0) {
            $reqPar = substr($buff,0,strlen($buff)-1);
        }
        return $reqPar;
    }

    //生成随机字符串，默认32位
    function createRand($length=32) {
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        $str = "";
        for($i=0;$i<$length;$i++) {
            $str.=substr($chars, mt_rand(0,strlen($chars)-1),1);
        }
        return $str;
    }

    //数组转xml
    function arrayToXml($arr) {
        $xml = "<xml>";
        foreach ($arr as $key=>$val) {
            if (is_numeric($val)) {
                $xml.="<".$key.">".$val."</".$key.">";
            } else {
                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
            }
        }
        $xml.="</xml>";
        return $xml;
    }

    //创建红包日志
    public function createHbLog($param,$scene,$result,$hbInfo){
        global $_W;
        $memberInfo = pdo_get('gd_member',array("open_id"=>$param['re_openid']));
        $insert['uniacid']=$_W['uniacid'];
        $insert['member_name']=$memberInfo['name'];
        $insert['member_id']=$memberInfo['id'];
        $insert['money']=$param['total_amount']/100;
        $insert['send_name']=$param['send_name'];
        $insert['wishing']=$param['wishing'];
        $insert['act_name']=$param['act_name'];
        $insert['remark']=$param['remark'];
        $insert['open_id']=$param['re_openid'];
        $insert['scene']=$scene['name'];
        $insert['gd_sn']=$scene['gd_sn'];
        $insert['hb_id']=$hbInfo['id'];
        $insert['order_sn']=$scene['order_sn'];
        $insert['code']=$result['code'];
        $insert['msg']=$result['msg'];
        $insert['create_time']=time();
        pdo_insert("gd_hblog",$insert);
    }

    //post请求网站，需要证书
    function postSsl($url, $vars, $second=30,$aHeader=array())
    {
        global $_W;
        $uniacid =$_W['uniacid'];
        $certRoot = MODULE_ROOT.DIRECTORY_SEPARATOR."cert/".$uniacid;
        if(!is_dir($certRoot)){
            mkdir($certRoot);
        }
        //获取配置参数
        $hbSet = pdo_get("gd_hbset",array("uniacid"=>$_W['uniacid']));
        if(empty($hbSet)){
            return false;
        }
        $certPath=$certRoot."/apiclient_cert.pem";
        $keyPath = $certRoot."/apiclient_key.pem";
//        $caPath = $certRoot."/rootca.pem";
        file_put_contents($certPath,$hbSet['cert']);
        file_put_contents($keyPath,$hbSet['key']);
//        file_put_contents($caPath,$hbSet['ca']);

        $ch = curl_init();
        curl_setopt($ch,CURLOPT_TIMEOUT,$second);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
        curl_setopt($ch,CURLOPT_SSLCERT,$certPath);
        curl_setopt($ch,CURLOPT_SSLKEY,$keyPath);
//        curl_setopt($ch,CURLOPT_CAINFO,$caPath);
        if( count($aHeader) >= 1 ){
            curl_setopt($ch, CURLOPT_HTTPHEADER, $aHeader);
        }
        curl_setopt($ch,CURLOPT_POST, 1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$vars);
        $data = curl_exec($ch);
        if($data){
            curl_close($ch);
            return $data;
        } else {
            $error = curl_errno($ch);
            echo "call faild, errorCode:$error\n";
            curl_close($ch);
            return false;
        }
    }


}