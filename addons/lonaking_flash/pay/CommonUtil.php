<?php
/*
 __________________________________________________
|  Encode by BajieTeam on we7                      |
|__________________________________________________|
*/

/**
 * 本代码出自一位前辈之手，由于作者被封，无法与其取得联系，如有侵权，请联系本人 QQ 1214512299
 */
class CommonUtil
{
    function genAllUrl($toURL, $paras)
    {
        goto TLGnx;
        ioBR6:
        $allUrl = $toURL . "\77" . $paras;
        goto ELz1R;
        vTGPD:
        r7gXn:
        goto ioBR6;
        TLGnx:
        $allUrl = null;
        goto rRCao;
        cSM4A:
        die("\x74\157\125\122\114\x20\151\163\x20\x6e\x75\x6c\154");
        goto XkqVe;
        rRCao:
        if (!(null == $toURL)) {
            goto qVBzh;
        }
        goto cSM4A;
        vLoRA:
        return $allUrl;
        goto qpOc1;
        NiSEn:
        if (strripos($toURL, "\x3f") == '') {
            goto r7gXn;
        }
        goto u743L;
        XkqVe:
        qVBzh:
        goto NiSEn;
        ELz1R:
        uZiSS:
        goto vLoRA;
        wIr04:
        goto uZiSS;
        goto vTGPD;
        u743L:
        $allUrl = $toURL . "\46" . $paras;
        goto wIr04;
        qpOc1:
    }
    function create_noncestr($length = 16)
    {
        goto aSXEf;
        hqljS:
        if (!($i < $length)) {
            goto iAeFv;
        }
        goto VwnZ5;
        aSXEf:
        $chars = "\141\142\x63\x64\x65\x66\147\150\151\152\153\x6c\x6d\x6e\x6f\160\161\x72\163\164\x75\166\167\x78\x79\172\x41\x42\x43\x44\105\x46\x47\x48\111\x4a\113\x4c\x4d\116\x4f\120\121\122\123\x54\125\126\127\x58\x59\132\60\61\62\x33\64\65\66\67\x38\71";
        goto BQbTB;
        VwnZ5:
        $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        goto jkohi;
        T2TNB:
        $i = 0;
        goto FgoF7;
        uJQs7:
        iAeFv:
        goto R2i0T;
        R2i0T:
        return $str;
        goto B_vAm;
        BQbTB:
        $str = '';
        goto T2TNB;
        iYwIS:
        goto KD41t;
        goto uJQs7;
        hri3U:
        $i++;
        goto iYwIS;
        jkohi:
        GZNYq:
        goto hri3U;
        FgoF7:
        KD41t:
        goto hqljS;
        B_vAm:
    }
    /**
     * 
     * 
     * @param src
     * @param token
     * @return
     */
    function splitParaStr($src, $token)
    {
        goto FeQyN;
        Y5IuY:
        xlxiU:
        goto DD7mQ;
        DD7mQ:
        return $resMap;
        goto f3V5T;
        b0HPa:
        foreach ($items as $item) {
            goto sIP2o;
            z6eF1:
            if (!($paraAndValue != '')) {
                goto eeHq1;
            }
            goto sN4Ub;
            sN4Ub:
            $resMap[$paraAndValue[0]] = $parameterValue[1];
            goto nYYUF;
            nYYUF:
            eeHq1:
            goto IGfoI;
            IGfoI:
            TGI4P:
            goto VqMFm;
            sIP2o:
            $paraAndValue = explode("\x3d", $item);
            goto z6eF1;
            VqMFm:
        }
        goto Y5IuY;
        FeQyN:
        $resMap = array();
        goto QXSWr;
        QXSWr:
        $items = explode($token, $src);
        goto b0HPa;
        f3V5T:
    }
    /**
     * trim 
     * 
     * @param value
     * @return
     */
    static function trimString($value)
    {
        goto bpEEC;
        nj2Db:
        if (!(strlen($ret) == 0)) {
            goto TdYrB;
        }
        goto gEkt0;
        q4l8s:
        return $ret;
        goto FlTnn;
        JVwF1:
        TdYrB:
        goto l2AVV;
        zhPX4:
        if (!(null != $value)) {
            goto VejGb;
        }
        goto wRYbd;
        wRYbd:
        $ret = $value;
        goto nj2Db;
        gEkt0:
        $ret = null;
        goto JVwF1;
        bpEEC:
        $ret = null;
        goto zhPX4;
        l2AVV:
        VejGb:
        goto q4l8s;
        FlTnn:
    }
    function formatQueryParaMap($paraMap, $urlencode)
    {
        goto XMTNv;
        mpVJM:
        return $reqPar;
        goto WYqmm;
        WI3ZR:
        foreach ($paraMap as $k => $v) {
            goto RF1aW;
            SLT4G:
            if (!$urlencode) {
                goto F9xLw;
            }
            goto ZvWCc;
            fzjzo:
            O1xBw:
            goto yKv4x;
            ZvWCc:
            $v = urlencode($v);
            goto xXApH;
            ev5Mz:
            lWkWW:
            goto fzjzo;
            RF1aW:
            if (!(null != $v && "\156\165\154\154" != $v && "\x73\151\x67\x6e" != $k)) {
                goto lWkWW;
            }
            goto SLT4G;
            xXApH:
            F9xLw:
            goto hyl8V;
            hyl8V:
            $buff .= $k . "\75" . $v . "\46";
            goto ev5Mz;
            yKv4x:
        }
        goto tQOad;
        DcaBZ:
        ksort($paraMap);
        goto WI3ZR;
        k5t6D:
        $reqPar = substr($buff, 0, strlen($buff) - 1);
        goto cz_ZE;
        XMTNv:
        $buff = '';
        goto DcaBZ;
        cz_ZE:
        WW6S7:
        goto mpVJM;
        m_Tvz:
        if (!(strlen($buff) > 0)) {
            goto WW6S7;
        }
        goto k5t6D;
        pWszo:
        $reqPar;
        goto m_Tvz;
        tQOad:
        l5eYm:
        goto pWszo;
        WYqmm:
    }
    function formatBizQueryParaMap($paraMap, $urlencode)
    {
        goto xWeRC;
        xWeRC:
        $buff = '';
        goto nkECV;
        VXbJ4:
        IIq8g:
        goto R3Td0;
        q7Vru:
        iS0Jg:
        goto DWSGp;
        b8fuq:
        foreach ($paraMap as $k => $v) {
            goto tABC2;
            Pz3Pu:
            $v = urlencode($v);
            goto FcISm;
            esmUE:
            Fuc1M:
            goto lw6CL;
            FcISm:
            D7Lpi:
            goto DVRMG;
            DVRMG:
            $buff .= strtolower($k) . "\75" . $v . "\46";
            goto esmUE;
            tABC2:
            if (!$urlencode) {
                goto D7Lpi;
            }
            goto Pz3Pu;
            lw6CL:
        }
        goto VXbJ4;
        nkECV:
        ksort($paraMap);
        goto b8fuq;
        DWSGp:
        return $reqPar;
        goto Z5cXN;
        NjhiF:
        $reqPar = substr($buff, 0, strlen($buff) - 1);
        goto q7Vru;
        R3Td0:
        $reqPar;
        goto FcPv7;
        FcPv7:
        if (!(strlen($buff) > 0)) {
            goto iS0Jg;
        }
        goto NjhiF;
        Z5cXN:
    }
    static function arrayToXml($arr)
    {
        goto vZsel;
        vZsel:
        $xml = "\x3c\170\155\x6c\76";
        goto aXQpa;
        q0gRW:
        $xml .= "\74\57\170\x6d\x6c\76";
        goto r4W91;
        r4W91:
        return $xml;
        goto NUwv3;
        Hcxj8:
        rVGhv:
        goto q0gRW;
        aXQpa:
        foreach ($arr as $key => $val) {
            goto R5WzE;
            LO1D9:
            goto tJWO5;
            goto PCwsV;
            leNnA:
            uZKIw:
            goto RjH46;
            HuYAb:
            tJWO5:
            goto leNnA;
            yqOVg:
            $xml .= "\x3c" . $key . "\x3e" . $val . "\74\x2f" . $key . "\x3e";
            goto HuYAb;
            PCwsV:
            XirAL:
            goto yqOVg;
            SfDPM:
            $xml .= "\x3c" . $key . "\x3e\74\x21\133\103\104\x41\124\101\x5b" . $val . "\135\135\x3e\x3c\x2f" . $key . "\x3e";
            goto LO1D9;
            R5WzE:
            if (is_numeric($val)) {
                goto XirAL;
            }
            goto SfDPM;
            RjH46:
        }
        goto Hcxj8;
        NUwv3:
    }
}
?>
