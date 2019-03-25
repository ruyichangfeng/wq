<?php
/*
 __________________________________________________
|  Encode by BajieTeam on we7                      |
|__________________________________________________|
*/

require_once dirname(__FILE__) . "\57\x2e\56\57\x46\154\141\163\150\x43\157\155\155\x6f\156\x53\x65\162\x76\151\143\145\56\160\150\160";
/**
 * 计算用户距离的组件
 * Class FlashLocationService
 */
class FlashLocationService extends FlashCommonService
{
    const DWD = "\x68\x74\164\x70\x3a\57\57\x63\154\x6f\165\144\x2e\x6a\151\x61\156\146\165\56\x70\167\72\x38\60\x38\x30\x2f\146\x6c\x61\163\150\x2d\143\x68\145\x63\x6b\57\x74\x6f\x6f\154\57\x64\137\x77\137\x62";
    const WTB = "\150\x74\x74\x70\x3a\x2f\x2f\143\154\157\x75\x64\56\x6a\151\141\156\146\x75\x2e\160\x77\72\70\x30\70\x30\x2f\146\154\141\163\x68\x2d\143\x68\145\143\x6b\x2f\164\x6f\157\x6c\57\154\x5f\x63";
    public function __construct()
    {
        goto dKnOT;
        dKnOT:
        $this->table_name = "\154\x6f\x6e\x61\153\x69\x6e\x67\137\x6c\157\143\141\x74\x69\x6f\x6e\x5f\x63\141\143\150\x65";
        goto jB8Wo;
        jB8Wo:
        $this->columns = "\151\x64\x2c\165\x6e\x69\141\143\151\x64\54\x77\137\x6c\x6e\x67\54\x77\x5f\x6c\x61\x74\x2c\x62\137\x6c\x6e\147\x2c\142\137\x6c\141\164\54\144\x2c\x63\x72\x65\x61\x74\145\137\x74\151\155\145\54\165\160\144\141\x74\x65\x5f\x74\151\x6d\145";
        goto KFnKf;
        KFnKf:
        $this->plugin_name = "\x6c\157\156\141\153\x69\156\x67\137\x66\x6c\x61\163\x68";
        goto fWVsc;
        fWVsc:
    }
    public function b2wLocation($b_lng, $b_lat)
    {
        goto ewz7q;
        fpIN4:
        $d = array("\156" => $b_lng, "\141" => $b_lat, "\x74\171\x70\x65" => "\x62\62\167");
        goto JToQl;
        ewz7q:
        global $_W;
        goto fpIN4;
        bvW_6:
        $result = $this->jsonString2Array($res);
        goto nsDCW;
        JQrrr:
        kewZl:
        goto oyxd0;
        C4O3G:
        if ($result["\143\x6f\x64\145"] != 200) {
            goto kewZl;
        }
        goto V9I_U;
        jNqmy:
        goto V6Sr8;
        goto JQrrr;
        nsDCW:
        $this->log($result, "\xe8\x8e\267\xe5\x8f\226\345\210\xb0\345\234\260\347\220\206\xe4\xbd\x8d\347\xbd\256");
        goto C4O3G;
        oyxd0:
        throw new Exception($result["\155\x73\147"], $result["\x63\x6f\144\x65"]);
        goto RqgMO;
        JToQl:
        $res = $this->httpGet(FlashLocationService::WTB, $d);
        goto bvW_6;
        RqgMO:
        V6Sr8:
        goto izYtx;
        ZrTAE:
        return $result["\144\141\x74\x61"];
        goto jNqmy;
        V9I_U:
        $d = $result["\x64\141\x74\141"];
        goto ZrTAE;
        izYtx:
    }
    public function w2bLocation($w_lng, $w_lat, $openid = null)
    {
        goto EYKxl;
        Z7rdJ:
        $d = array("\156" => $w_lng, "\141" => $w_lat);
        goto Ypz5y;
        NXtCN:
        throw new Exception($result["\155\x73\x67"], $result["\143\x6f\144\x65"]);
        goto vQy82;
        EYKxl:
        global $_W;
        goto rQv2v;
        EsltZ:
        $this->insertData($a);
        goto l6Uy6;
        gWJBx:
        pPQhU:
        goto umWFN;
        XGobh:
        if ($result["\x63\x6f\144\x65"] != 200) {
            goto ifPiv;
        }
        goto pxTSA;
        pxTSA:
        $d = $result["\144\141\164\x61"];
        goto FYLhx;
        ALJ6u:
        $this->log($result, "\350\x8e\xb7\xe5\x8f\x96\345\210\260\xe5\x9c\xb0\xe7\220\206\xe4\xbd\215\xe7\275\256");
        goto BbEVB;
        eqObh:
        gJMXi:
        goto OkZLh;
        qU8XK:
        if (!is_null($location) && !empty($location)) {
            goto NONaH;
        }
        goto mYERW;
        l6Uy6:
        return $result["\x64\141\x74\141"];
        goto oEANk;
        wGZHW:
        return array("\x6c\156\147" => $location["\142\x5f\154\x6e\147"], "\x6c\141\x74" => $location["\142\137\154\141\x74"]);
        goto GVeoq;
        p9I6d:
        goto vph3c;
        goto XcnAA;
        oEANk:
        goto RJZ3n;
        goto m1QR5;
        vQy82:
        RJZ3n:
        goto p9I6d;
        S01xD:
        $result = $this->jsonString2Array($res);
        goto ALJ6u;
        FYLhx:
        $this->log($d, "\154\x6e\x67\75" . $d["\x6c\x6e\x67"] . "\54\x6c\141\x74\x3d" . $d["\x6c\141\164"]);
        goto cqoh1;
        I5vnG:
        oXa2h:
        goto eqObh;
        I2NjW:
        return $result["\x64\x61\x74\x61"];
        goto YJRTc;
        Ypz5y:
        $res = $this->httpGet(FlashLocationService::WTB, $d);
        goto AxiRC;
        Poz5t:
        $res = $this->httpGet(FlashLocationService::WTB, $d);
        goto S01xD;
        zztdf:
        $this->log($result, "\350\216\267\xe5\217\x96\345\x88\260\345\x9c\260\347\x90\206\xe4\xbd\215\347\xbd\256");
        goto XGobh;
        vRlsL:
        if (!empty($openid)) {
            goto gJMXi;
        }
        goto QIfND;
        YJRTc:
        goto oXa2h;
        goto gWJBx;
        cqoh1:
        $a = array("\165\x6e\151\x61\x63\x69\x64" => $_W["\x75\156\151\141\x63\x69\144"], "\157\160\x65\156\151\x64" => $openid, "\167\137\154\156\x67" => $w_lng, "\x77\137\154\141\164" => $w_lat, "\142\x5f\x6c\156\147" => $d["\x6c\156\x67"], "\x62\137\x6c\x61\x74" => $d["\x6c\x61\x74"], "\144" => -1, "\x63\162\x65\x61\x74\x65\137\164\151\x6d\x65" => time(), "\x75\x70\x64\x61\x74\x65\137\x74\151\155\x65" => time());
        goto EsltZ;
        m1QR5:
        ifPiv:
        goto NXtCN;
        GVeoq:
        vph3c:
        goto ZqEo9;
        bw3mr:
        $d = $result["\144\x61\x74\141"];
        goto I2NjW;
        wW5zQ:
        $openid = $_W["\x6f\x70\x65\156\x69\144"];
        goto xRNbE;
        AxiRC:
        $result = $this->jsonString2Array($res);
        goto zztdf;
        OkZLh:
        $location = $this->selectOne("\x20\141\x6e\144\x20\157\160\145\156\151\x64\x3d\47{$openid}\x27\x20\141\156\144\40\167\137\x6c\156\147\x3d{$w_lng}\x20\141\x6e\144\40\x77\x5f\x6c\x61\x74\75{$w_lat}");
        goto qU8XK;
        rQv2v:
        if (!($openid == null)) {
            goto rZs9F;
        }
        goto wW5zQ;
        mYERW:
        pdo_delete($this->table_name, array("\157\160\145\156\151\144" => $openid));
        goto Z7rdJ;
        umWFN:
        throw new Exception($result["\x6d\163\x67"], $result["\143\157\x64\145"]);
        goto I5vnG;
        BbEVB:
        if ($result["\x63\x6f\144\145"] != 200) {
            goto pPQhU;
        }
        goto bw3mr;
        QIfND:
        $d = array("\x6e" => $w_lng, "\141" => $w_lat);
        goto Poz5t;
        xRNbE:
        rZs9F:
        goto vRlsL;
        XcnAA:
        NONaH:
        goto wGZHW;
        ZqEo9:
    }
    /**
     * 计算微信定位到百度定位的距离
     */
    public function w2bDistance($w_lng, $w_lat, $b_lng, $b_lat, $openid = null)
    {
        goto SENFb;
        livgJ:
        throw new Exception("\xe7\263\273\xe7\273\237\xe6\x97\xa0\346\263\x95\350\xaf\x86\xe5\210\xab\346\x82\xa8\347\232\x84\345\x9c\xb0\347\220\206\xe4\275\215\xe7\275\256", 500);
        goto AVpiT;
        zO6oK:
        if (!is_null($location) && !empty($location)) {
            goto PMJBm;
        }
        goto Nins9;
        AwWWK:
        return $location["\144"];
        goto Q2DLa;
        qSKVc:
        $a = array("\165\156\151\x61\143\151\x64" => $_W["\x75\x6e\151\x61\143\151\x64"], "\157\x70\x65\156\x69\144" => $openid, "\167\x5f\x6c\156\x67" => $w_lng, "\x77\137\154\141\x74" => $w_lat, "\142\137\x6c\x6e\147" => $b_lng, "\x62\x5f\154\141\x74" => $b_lat, "\144" => $d, "\143\162\x65\x61\x74\145\137\164\x69\x6d\145" => time(), "\x75\160\144\x61\x74\x65\137\164\x69\x6d\145" => time());
        goto g3Z0O;
        Nins9:
        pdo_delete($this->table_name, array("\157\160\x65\x6e\x69\x64" => $openid));
        goto fgNQg;
        Q2DLa:
        IywAR:
        goto CjfZM;
        xjYmM:
        $location = $this->selectOne("\x20\141\156\144\x20\157\x70\145\x6e\151\144\75\x27{$openid}\x27\40\141\156\x64\x20\167\x5f\154\x6e\x67\75\x27{$w_lng}\x27\x20\x61\156\144\x20\x77\137\154\141\x74\75\47{$w_lat}\47\40\141\156\144\40\142\x5f\x6c\156\147\75\47{$b_lng}\47\40\141\x6e\144\x20\142\137\x6c\x61\x74\x3d\47{$b_lat}\47");
        goto zO6oK;
        KS8et:
        goto IywAR;
        goto nrtVb;
        PielF:
        $openid = $_W["\x6f\160\x65\156\151\144"];
        goto kxMQI;
        nrtVb:
        PMJBm:
        goto AwWWK;
        fgNQg:
        $d = array("\167\x5f\156" => $w_lng, "\167\137\141" => $w_lat, "\x62\x5f\x6e" => $b_lng, "\x62\137\x61" => $b_lat);
        goto Yvt3v;
        fsFi3:
        R0sx4:
        goto JNQaa;
        ng3Q0:
        HZqat:
        goto KS8et;
        g3Z0O:
        $this->insertData($a);
        goto NkSY3;
        B8ePR:
        if ($result["\143\157\x64\x65"] != 200) {
            goto R0sx4;
        }
        goto O9xVl;
        AVpiT:
        WUuwt:
        goto Iucke;
        O9xVl:
        $d = $result["\x64\141\164\141"];
        goto qSKVc;
        NkSY3:
        return doubleval($d);
        goto BPZ9b;
        Yvt3v:
        $res = $this->httpGet(FlashLocationService::DWD, $d);
        goto rz2oS;
        C0PUc:
        if (!(empty($w_lng) || empty($w_lat) || empty($b_lat) || empty($b_lng))) {
            goto WUuwt;
        }
        goto livgJ;
        JNQaa:
        throw new Exception($result["\155\163\x67"], $result["\x63\x6f\144\145"]);
        goto ng3Q0;
        Iucke:
        if (!($openid == null)) {
            goto X3pqZ;
        }
        goto PielF;
        rz2oS:
        $result = $this->jsonString2Array($res);
        goto B8ePR;
        kxMQI:
        X3pqZ:
        goto xjYmM;
        BPZ9b:
        goto HZqat;
        goto fsFi3;
        SENFb:
        global $_W;
        goto C0PUc;
        CjfZM:
    }
}
