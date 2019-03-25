<?php
/*
 __________________________________________________
|  Encode by BajieTeam on we7                      |
|__________________________________________________|
*/

goto n4do4;
Q97_f:
include_once "\106\154\141\163\150\x48\x6f\156\x67\102\141\x6f\105\x78\x63\x65\160\x74\x69\157\156\56\x70\150\160";
goto qFCn7;
n4do4:
/**
 * 微信红包类
 * 本代码出自一位前辈之手，由于作者被封，无法与其取得联系，如有侵权，请联系本人 QQ 1214512299
 */
include_once "\x43\x6f\x6d\155\x6f\x6e\x55\164\151\154\56\160\150\x70";
goto SRipY;
dqVZP:
include_once "\x4d\104\65\x53\151\147\156\x55\164\x69\154\x2e\160\x68\x70";
goto Q97_f;
SRipY:
include_once "\123\x44\113\122\165\x6e\x74\x69\x6d\145\105\170\143\145\160\164\x69\157\156\56\x63\x6c\x61\163\163\56\160\x68\x70";
goto dqVZP;
qFCn7:
class FlashHongBaoHelper
{
    var $parameters;
    var $apiclient_cert;
    var $apiclient_key;
    var $rootca;
    var $passkey;
    function __construct($cert, $key, $ca, $passkey = '')
    {
        goto rbA62;
        gqe8d:
        $this->apiclient_key = $key;
        goto UoM36;
        rbA62:
        $this->apiclient_cert = $cert;
        goto gqe8d;
        UoM36:
        $this->rootca = $ca;
        goto M7Cet;
        M7Cet:
        $this->passkey = $passkey;
        goto eK5_k;
        eK5_k:
    }
    function setParameter($parameter, $parameterValue)
    {
        $this->parameters[CommonUtil::trimString($parameter)] = CommonUtil::trimString($parameterValue);
    }
    function getParameter($parameter)
    {
        return $this->parameters[$parameter];
    }
    protected function create_noncestr($length = 16)
    {
        goto iB0v5;
        cdBpl:
        goto Z__ep;
        goto s1lF8;
        kVnvL:
        SO6Lc:
        goto GWIWU;
        gM7ac:
        $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        goto kVnvL;
        iB0v5:
        $chars = "\141\142\143\x64\145\146\147\150\151\x6a\x6b\154\x6d\156\x6f\x70\x71\x72\163\x74\x75\x76\167\x78\x79\172\x41\x42\103\x44\105\106\x47\110\111\112\x4b\114\x4d\x4e\x4f\x50\x51\122\x53\x54\x55\x56\127\x58\131\x5a\x30\x31\62\63\64\x35\x36\x37\x38\x39";
        goto itTSY;
        itTSY:
        $str = '';
        goto sQMMO;
        f351n:
        return $str;
        goto HK88T;
        V9j7D:
        if (!($i < $length)) {
            goto Xwox3;
        }
        goto gM7ac;
        tTLOe:
        Z__ep:
        goto V9j7D;
        GWIWU:
        $i++;
        goto cdBpl;
        s1lF8:
        Xwox3:
        goto f351n;
        sQMMO:
        $i = 0;
        goto tTLOe;
        HK88T:
    }
    function check_sign_parameters()
    {
        goto HqkFh;
        HqkFh:
        if (!($this->parameters["\156\157\x6e\143\x65\x5f\163\x74\162"] == null || $this->parameters["\155\143\x68\x5f\x62\151\154\x6c\x6e\x6f"] == null || $this->parameters["\155\143\150\x5f\151\144"] == null || $this->parameters["\167\x78\141\160\160\x69\144"] == null || $this->parameters["\156\x69\143\x6b\137\156\x61\155\145"] == null || $this->parameters["\163\145\x6e\x64\137\x6e\141\x6d\x65"] == null || $this->parameters["\162\x65\137\157\x70\x65\156\151\144"] == null || $this->parameters["\164\x6f\164\141\154\137\141\155\x6f\165\156\164"] == null || $this->parameters["\x74\157\164\141\x6c\x5f\x6e\165\155"] == null || $this->parameters["\x77\151\x73\150\151\156\147"] == null || $this->parameters["\143\154\x69\145\156\164\137\151\x70"] == null || $this->parameters["\141\143\x74\x5f\156\x61\x6d\145"] == null || $this->parameters["\162\x65\155\x61\x72\x6b"] == null)) {
            goto le1rV;
        }
        goto DEf4L;
        DEf4L:
        return false;
        goto pg6Xn;
        pg6Xn:
        le1rV:
        goto xL3yi;
        xL3yi:
        return true;
        goto Da_2p;
        Da_2p:
    }
    /**
     例如：
    	appid：    wxd930ea5d5a258f4f
    		mch_id：    10000100
    		device_info：  1000
    		Body：    test
    		nonce_str：  ibuaiVcKdpRxkhJA
    		第一步：对参数按照 key=value 的格式，并按照参数名 ASCII 字典序排序如下：
    		stringA="appid=wxd930ea5d5a258f4f&body=test&device_info=1000&mch_i
    		d=10000100&nonce_str=ibuaiVcKdpRxkhJA";
    		第二步：拼接支付密钥：
    		stringSignTemp="stringA&key=192006250b4c09247ec02edce69f6a2d"
    		sign=MD5(stringSignTemp).toUpperCase()="9A0A8659F005D6984697E2CA0A
    		9CF3B7"
    */
    protected function get_sign()
    {
        try {
            goto L6F1H;
            fHUy1:
            if (!($this->check_sign_parameters() == false)) {
                goto i9tpb;
            }
            goto Wj4js;
            Ih3st:
            Xhj3W:
            goto fHUy1;
            eLUT7:
            $unSignParaString = $commonUtil->formatQueryParaMap($this->parameters, false);
            goto CT2h1;
            CT2h1:
            $md5SignUtil = new MD5SignUtil();
            goto RSBlR;
            zyb0c:
            ksort($this->parameters);
            goto eLUT7;
            Uo9q5:
            return $sign;
            goto hlQqz;
            Wj4js:
            throw new SDKRuntimeException("\347\224\x9f\xe6\210\x90\347\255\276\xe5\220\215\xe5\217\x82\xe6\x95\260\347\xbc\272\345\xa4\261\x21");
            goto G4Hms;
            RSBlR:
            $sign = $md5SignUtil->sign($unSignParaString, $commonUtil->trimString($this->passkey));
            goto Uo9q5;
            L6F1H:
            if (!(null == $this->passkey || '' == $this->passkey)) {
                goto Xhj3W;
            }
            goto SQEgI;
            SQEgI:
            throw new SDKRuntimeException("\345\xaf\x86\xe9\222\245\344\270\215\350\203\xbd\xe4\xb8\272\347\xa9\xba\x21");
            goto Ih3st;
            G4Hms:
            i9tpb:
            goto pF0Dt;
            pF0Dt:
            $commonUtil = new CommonUtil();
            goto zyb0c;
            hlQqz:
        } catch (SDKRuntimeException $e) {
            throw new FlashHongBaoException($e->errorMessage(), 10302);
        }
    }
    function create_hongbao_xml($retcode = 0, $reterrmsg = "\157\x6b")
    {
        try {
            goto I16SZ;
            I16SZ:
            $this->setParameter("\163\x69\147\156", $this->get_sign());
            goto saH4q;
            saH4q:
            $xml = CommonUtil::arrayToXml($this->parameters);
            goto LTjbJ;
            LTjbJ:
            return $xml;
            goto rPMbX;
            rPMbX:
        } catch (SDKRuntimeException $e) {
            throw new FlashHongBaoException($e->errorMessage(), 10301);
        }
    }
    function curl_post_ssl($url, $vars, $second = 30, $aHeader = array())
    {
        goto TmIhn;
        lHuRy:
        curl_setopt($ch, CURLOPT_HTTPHEADER, $aHeader);
        goto uzC5D;
        p98Gt:
        $error = curl_errno($ch);
        goto TAeb3;
        NgvQZ:
        return $data;
        goto kHe8n;
        F1VI2:
        curl_setopt($ch, CURLOPT_POST, 1);
        goto ggWKL;
        ggWKL:
        curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
        goto v9Ow7;
        TAeb3:
        curl_close($ch);
        goto MtWU2;
        D5zzp:
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        goto Gm23t;
        Am7HN:
        curl_setopt($ch, CURLOPT_URL, $url);
        goto gccg4;
        kHe8n:
        ttulo:
        goto U8D61;
        vUHb9:
        iUBKW:
        goto nLTeE;
        nLTeE:
        curl_close($ch);
        goto NgvQZ;
        tWVai:
        goto ttulo;
        goto vUHb9;
        Ndy5f:
        if (!(count($aHeader) >= 1)) {
            goto vEMnO;
        }
        goto lHuRy;
        eNKPP:
        curl_setopt($ch, CURLOPT_SSLKEY, ATTACHMENT_ROOT . $this->apiclient_key);
        goto FNNP2;
        uzC5D:
        vEMnO:
        goto F1VI2;
        Vz5ZF:
        if ($data) {
            goto iUBKW;
        }
        goto p98Gt;
        v9Ow7:
        $data = curl_exec($ch);
        goto Vz5ZF;
        FNNP2:
        curl_setopt($ch, CURLOPT_CAINFO, ATTACHMENT_ROOT . $this->rootca);
        goto Ndy5f;
        ffSa0:
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);
        goto MSq2B;
        TmIhn:
        $ch = curl_init();
        goto ffSa0;
        Gm23t:
        curl_setopt($ch, CURLOPT_SSLCERT, ATTACHMENT_ROOT . $this->apiclient_cert);
        goto eNKPP;
        MtWU2:
        return false;
        goto tWVai;
        gccg4:
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        goto D5zzp;
        MSq2B:
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        goto Am7HN;
        U8D61:
    }
}
goto Ne17v;
Ne17v:
?>
