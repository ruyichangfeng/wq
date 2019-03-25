<?php
/*
 __________________________________________________
|  Encode by BajieTeam on we7                      |
|__________________________________________________|
*/

goto lgb7d;
qaeJl:
require_once "\x70\x61\x79\57\106\154\x61\163\x68\x48\x6f\x6e\147\102\141\157\x45\170\x63\145\x70\164\151\x6f\x6e\56\160\150\160";
goto PmAX6;
lgb7d:
/**
 * Created by PhpStorm.
 * User: leon
 * Date: 16/3/16
 * Time: 上午10:57
 */
require_once "\160\141\171\57\x46\154\x61\x73\x68\110\x6f\156\147\102\141\x6f\x48\145\154\160\145\162\56\160\150\160";
goto qaeJl;
PmAX6:
class FlashHBService
{
    private $DS;
    private $SIGNTYPE = "\x73\150\x61\x31";
    private $APPID;
    private $MCHID;
    private $PASSKEY;
    private $NICK_NAME;
    private $SEND_NAME;
    private $WISHING;
    private $ACT_NAME;
    private $REMARK;
    private $apiclient_cert;
    private $apiclient_key;
    private $rootca;
    private $money;
    private $openid;
    private $client_ip;
    public function __construct($openid, $money, $config)
    {
        goto rS71t;
        jnRq1:
        $this->APPID = $config["\141\160\160\x69\x64"];
        goto xsU_b;
        u0HKQ:
        $this->openid = $openid;
        goto zrAx_;
        oMJlW:
        $this->apiclient_key = $config["\x61\x70\151\143\154\x69\x65\156\164\137\x6b\145\x79"];
        goto UatR_;
        rS71t:
        $this->DS = DIRECTORY_SEPARATOR;
        goto KZ_00;
        KZ_00:
        $this->SIGNTYPE = "\163\x68\x61\x31";
        goto jnRq1;
        ChiRQ:
        $this->WISHING = $config["\x77\151\163\150\x69\156\147"];
        goto ttktj;
        ttktj:
        $this->ACT_NAME = $config["\141\143\164\137\156\x61\155\x65"];
        goto gTEUv;
        UatR_:
        $this->rootca = $config["\x72\x6f\157\x74\143\141"];
        goto AGPyD;
        ln0s3:
        $this->money = intval($money * 100);
        goto u0HKQ;
        MuROV:
        $this->NICK_NAME = $config["\x6e\x69\x63\x6b\x5f\156\141\x6d\145"];
        goto MGprR;
        AGPyD:
        $this->client_ip = $config["\143\154\x69\x65\156\x74\x5f\151\x70"];
        goto ln0s3;
        MGprR:
        $this->SEND_NAME = $config["\x73\145\x6e\x64\137\156\141\x6d\x65"];
        goto ChiRQ;
        gTEUv:
        $this->REMARK = $config["\162\145\155\x61\x72\x6b"];
        goto Qx4ok;
        qQ3qG:
        $this->PASSKEY = $config["\160\x61\163\163\153\x65\171"];
        goto MuROV;
        xsU_b:
        $this->MCHID = $config["\155\x63\150\x69\x64"];
        goto qQ3qG;
        Qx4ok:
        $this->apiclient_cert = $config["\141\160\151\x63\x6c\x69\145\156\x74\x5f\143\145\162\x74"];
        goto oMJlW;
        zrAx_:
    }
    public function send()
    {
        goto bXz1B;
        k4KFr:
        if ($responseObj->err_code == "\x44\x41\x59\x5f\117\x56\105\x52\137\x4c\x49\x4d\111\124\105\104") {
            goto ZjAOP;
        }
        goto IilKm;
        brLju:
        try {
            $postXml = $wxHongBaoHelper->create_hongbao_xml();
        } catch (FlashHongBaoException $e) {
            goto JCaw2;
            nPRUM:
            $recordData["\163\145\x6e\x64\x5f\144\x61\x74\141"] = $parametersText;
            goto USlQq;
            XGd0q:
            throw new FlashHongBaoException("\xe7\xba\xa2\345\214\205\345\x8f\221\xe6\224\xbe\xe5\xa4\261\xe8\xb4\xa5\xef\274\x81" . $e->getErrorMessage() . "\xef\274\x81\xe8\257\267\xe7\xa8\215\345\220\x8e\xe5\x86\215\350\257\x95\357\xbc\x81", 10406);
            goto N0NyZ;
            JCaw2:
            $parametersText = json_encode($wxHongBaoHelper->parameters);
            goto nPRUM;
            USlQq:
            pdo_insert("\x6c\x6f\x6e\x61\x6b\151\x6e\147\137\150\142\x5f\x72\x65\143\x6f\162\x64", $recordData);
            goto XGd0q;
            N0NyZ:
        }
        goto Lu15h;
        KT9Bj:
        $wxHongBaoHelper->setParameter("\x61\143\x74\137\156\x61\x6d\145", $this->ACT_NAME);
        goto UH3oo;
        QPkrh:
        pdo_insert("\x6c\157\156\x61\153\151\156\147\x5f\150\x62\x5f\162\145\143\157\x72\x64", $recordData);
        goto MrzJR;
        reJ9T:
        GUJAW:
        goto wgl21;
        MrzJR:
        $total_amount = $responseObj->total_amount * 1.0 / 100;
        goto lkOsI;
        RNQLE:
        goto LV3PS;
        goto NpYrr;
        Lu15h:
        $url = "\150\164\x74\160\x73\x3a\57\57\141\160\151\56\x6d\x63\x68\56\167\145\x69\170\x69\x6e\x2e\161\161\x2e\x63\x6f\x6d\57\x6d\155\160\141\x79\155\x6b\164\164\x72\141\156\163\146\x65\162\163\x2f\163\x65\x6e\144\162\145\x64\x70\141\143\x6b";
        goto GWJ8O;
        xKz4a:
        $responseObjArr = json_decode($responseObjText, true);
        goto zPimQ;
        vbTIQ:
        throw new FlashHongBaoException("\346\257\x8f\xe5\x88\x86\351\x92\237\347\xba\xa2\xe5\x8c\x85\xe5\xb7\xb2\xe8\xbe\276\xe4\270\x8a\xe9\x99\220\xef\xbc\214\xe8\xaf\267\xe7\xa8\x8d\xe5\220\x8e\345\x86\x8d\xe8\257\225\x21", 10405);
        goto KwQbt;
        eJ3S1:
        $recordData["\162\145\163\160\x6f\x6e\163\145\x5f\x72\x65\164\165\162\x6e\137\143\157\144\145"] = $responseObjArr["\162\145\x74\165\x72\156\137\143\157\x64\x65"];
        goto xI3Zg;
        xjadi:
        $wxHongBaoHelper->setParameter("\155\143\x68\x5f\x62\151\154\x6c\156\157", $mch_billno);
        goto Ap0wL;
        tKzbP:
        $recordData = array("\x74\x6f\137\x6f\x70\x65\x6e\x69\x64" => $this->openid, "\x75\156\151\x61\143\x69\x64" => $_W["\x75\156\151\141\x63\x69\144"], "\x61\155\x6f\x75\156\x74" => $this->money, "\x73\164\x61\164\x75\x73" => 0, "\155\x63\x68\137\x62\151\154\154\x6e\157" => $mch_billno, "\x63\162\x65\x61\164\145\x5f\x74\151\155\145" => time(), "\165\x70\144\x61\164\145\x5f\x74\151\x6d\145" => time());
        goto XfhCX;
        r02_F:
        iolat:
        goto KaGzG;
        uNqE4:
        ZjAOP:
        goto dAWPa;
        v1u2p:
        $wxHongBaoHelper->setParameter("\x77\151\163\150\x69\156\x67", $this->WISHING);
        goto uP9Lw;
        eL3KC:
        pdo_insert("\154\x6f\156\x61\153\151\x6e\147\x5f\150\142\x5f\x72\145\x63\x6f\x72\x64", $recordData);
        goto kzpi1;
        gLdDI:
        LctJT:
        goto ecjN1;
        XHcJ4:
        $recordData["\162\x65\x73\x70\157\156\x73\145\137\145\162\x72\137\x63\157\x64\x65"] = $responseObjArr["\x65\162\x72\137\x63\x6f\144\145"];
        goto d74dX;
        uP9Lw:
        $wxHongBaoHelper->setParameter("\x63\154\x69\x65\x6e\x74\137\x69\160", empty($this->client_ip) ? "\x31\x32\67\x2e\x30\56\60\56\x31" : $this->client_ip);
        goto KT9Bj;
        gKAPm:
        if ($responseObj->err_code == "\x44\101\x59\137\x4f\126\x45\x52\137\114\111\115\x49\x54\x45\104") {
            goto iAFF8;
        }
        goto Vz7fL;
        Mj8IC:
        Vx5MP:
        goto EXtME;
        KaGzG:
        goto nNk9l;
        goto PBMP6;
        xt29O:
        global $_W;
        goto tKzbP;
        tUBIF:
        $wxHongBaoHelper->setParameter("\x73\145\x6e\144\x5f\x6e\141\155\x65", $this->SEND_NAME);
        goto FH5xP;
        JtySN:
        $recordData["\x73\x65\156\x64\137\144\x61\x74\141"] = $postXml;
        goto LpT4C;
        yHdmg:
        nNk9l:
        goto xYC82;
        cuS_q:
        throw new FlashHongBaoException("\347\xb3\xbb\xe7\xbb\237\xe7\xb9\x81\xe5\xbf\x99\xef\274\x8c\350\xaf\267\xe7\250\215\xe5\220\216\345\x86\x8d\xe8\257\x95\41" . $responseObj->err_code_des, 10403);
        goto KgJ6m;
        cnQMt:
        $return_code = $responseObj->return_code;
        goto gKocz;
        pZV4h:
        goto iwbAQ;
        goto reJ9T;
        oX28C:
        goto iolat;
        goto GhIYu;
        Ye6iQ:
        LV3PS:
        goto CrO6h;
        rg_R0:
        if ($responseObj->err_code == "\x4e\x4f\124\x45\x4e\117\125\107\x48") {
            goto LpQaH;
        }
        goto Ama3J;
        xmy0C:
        BVl03:
        goto pZV4h;
        NCtfm:
        $recordData["\x72\x65\x73\160\x6f\156\163\x65\x5f\162\145\164\165\x72\x6e\137\155\x73\x67"] = $responseObjArr["\x72\x65\164\165\162\156\x5f\x6d\x73\x67"];
        goto eL3KC;
        w9vv2:
        throw new FlashHongBaoException("\347\272\242\345\214\205\345\x8f\x91\xe6\x94\276\xe5\244\261\350\xb4\xa5\xef\274\201" . $responseObj->return_msg . "\xef\xbc\201\350\xaf\xb7\347\xa8\215\345\x90\x8e\xe5\x86\x8d\350\257\x95\xef\xbc\201", 10406);
        goto RNQLE;
        hxxwh:
        $postXml = '';
        goto brLju;
        R7ET_:
        if ($responseObj->err_code == "\123\x59\x53\124\x45\115\x45\122\x52\x4f\x52") {
            goto GUJAW;
        }
        goto gKAPm;
        E09Ny:
        throw new FlashHongBaoException("\xe7\216\xb0\345\x9c\xa8\351\235\x9e\347\xba\xa2\345\x8c\x85\345\x8f\221\xe6\224\xbe\346\227\xb6\xe9\x97\264\357\274\x8c\350\xaf\267\345\x9c\250\xe5\x8c\x97\xe4\272\xac\346\227\266\xe9\227\xb4\60\72\60\x30\x2d\x38\x3a\x30\x30\xe4\271\x8b\345\xa4\226\xe7\232\x84\346\227\xb6\xe9\x97\264\xe5\x89\x8d\xe6\235\245\351\xa2\206\345\217\x96", 10402);
        goto twqrR;
        zPimQ:
        $recordData["\162\x65\163\160\157\156\x73\x65\137\157\x62\x6a\137\164\145\170\164"] = $responseObjText;
        goto eJ3S1;
        Vh2bK:
        throw new FlashHongBaoException("\346\x82\xa8\xe6\x9d\xa5\350\xbf\237\344\xba\206\xef\xbc\214\347\xba\xa2\345\x8c\x85\345\267\xb2\347\273\x8f\345\x8f\221\345\xae\214\xef\274\x81\357\xbc\x81\xef\274\x81", 10401);
        goto yHdmg;
        gKocz:
        $result_code = $responseObj->result_code;
        goto JtySN;
        UqvNA:
        $recordData["\162\145\163\160\157\x6e\163\x65\137\145\x72\x72\137\143\x6f\x64\x65\x5f\144\145\163"] = $responseObjArr["\145\x72\x72\137\143\x6f\x64\145\137\144\x65\x73"];
        goto MS2CY;
        FH5xP:
        $wxHongBaoHelper->setParameter("\162\145\x5f\x6f\160\x65\156\x69\144", $this->openid);
        goto d1NvE;
        UH3oo:
        $wxHongBaoHelper->setParameter("\162\x65\x6d\141\162\153", $this->REMARK);
        goto hxxwh;
        KwQbt:
        j_645:
        goto snsbX;
        xYC82:
        throw new FlashHongBaoException("\347\272\242\345\x8c\205\345\x8f\221\xe6\224\xbe\345\244\xb1\350\264\245\357\274\x81" . $responseObj->return_msg . "\357\xbc\x81\xe8\xaf\267\347\250\x8d\xe5\220\216\xe5\206\215\xe8\xaf\x95\xef\274\201", 10406);
        goto I22vN;
        H1hdT:
        HDRFS:
        goto cuS_q;
        NpYrr:
        ICr60:
        goto mopj7;
        mopj7:
        $recordData["\x73\x74\141\x74\165\163"] = 1;
        goto QPkrh;
        lkOsI:
        return "\347\xba\242\xe5\x8c\205\345\217\221\346\x94\276\346\x88\x90\345\212\237\357\274\201\xe9\x87\x91\351\242\235\344\270\272\xef\xbc\x9a" . $total_amount . "\xe5\x85\203\357\274\201";
        goto Ye6iQ;
        GWJ8O:
        $responseXml = $wxHongBaoHelper->curl_post_ssl($url, $postXml);
        goto HhapC;
        EXtME:
        throw new FlashHongBaoException("\xe6\x82\xa8\346\235\xa5\xe8\277\237\344\272\x86\357\274\214\347\xba\xa2\345\214\x85\345\267\262\xe7\273\217\xe5\217\x91\345\256\x8c\xef\xbc\x81\xef\xbc\x81\xef\274\201", 10401);
        goto rg1z2;
        j5CMq:
        E3P1_:
        goto IziW0;
        d74dX:
        $recordData["\162\145\163\x70\157\156\163\x65\x5f\145\x72\162\x5f\x63\157\x64\145\137\144\x65\x73"] = $responseObjArr["\145\x72\162\x5f\x63\x6f\144\145\x5f\x64\145\x73"];
        goto NCtfm;
        MS2CY:
        $recordData["\162\145\x73\x70\157\156\x73\x65\137\162\x65\164\x75\162\x6e\x5f\x6d\x73\x67"] = $responseObjArr["\162\x65\164\x75\x72\x6e\137\x6d\x73\147"];
        goto gtbEs;
        fALwL:
        $wxHongBaoHelper->setParameter("\x77\x78\x61\160\x70\x69\x64", $this->APPID);
        goto OhCgH;
        IziW0:
        goto CiIet;
        goto H1hdT;
        gtbEs:
        $recordData["\145\x72\x72\157\x72\137\x63\157\144\x65"] = $responseObjArr["\145\x72\162\157\x72\x5f\x63\157\x64\x65"];
        goto s3Hay;
        kzpi1:
        if ($responseObj->err_code == "\x4e\x4f\124\105\116\117\x55\107\110") {
            goto Vx5MP;
        }
        goto NfiZN;
        Qbm7p:
        throw new FlashHongBaoException("\346\xaf\x8f\345\x88\206\351\222\x9f\347\272\xa2\345\x8c\205\xe5\267\262\350\xbe\xbe\xe4\270\212\351\231\220\357\xbc\x8c\350\xaf\267\347\xa8\215\xe5\x90\216\345\x86\215\350\257\x95\x21", 10405);
        goto gLdDI;
        xI3Zg:
        $recordData["\162\x65\163\160\x6f\x6e\x73\145\137\x72\x65\163\x75\154\164\x5f\x63\x6f\x64\145"] = $responseObjArr["\162\x65\163\x75\154\x74\x5f\143\157\144\145"];
        goto m_biQ;
        z3Vdk:
        throw new FlashHongBaoException("\344\xbb\212\xe6\x97\245\347\xba\xa2\345\214\x85\xe5\xb7\262\xe8\276\276\xe4\xb8\x8a\xe9\231\x90\357\274\214\xe8\257\267\346\x98\216\346\227\xa5\xe5\x86\x8d\xe8\xaf\225\41", 10404);
        goto xmy0C;
        Ap0wL:
        $wxHongBaoHelper->setParameter("\155\143\150\137\x69\144", $this->MCHID);
        goto fALwL;
        OhCgH:
        $wxHongBaoHelper->setParameter("\x6e\x69\143\x6b\137\x6e\141\x6d\x65", $this->NICK_NAME);
        goto tUBIF;
        VB0OJ:
        goto zb1bS;
        goto Mj8IC;
        S9VNq:
        goto uaDoP;
        goto EFdLZ;
        GhIYu:
        Af1PL:
        goto QUHuI;
        XfhCX:
        $commonUtil = new CommonUtil();
        goto x6sUv;
        m_biQ:
        if ($return_code == "\123\125\103\103\x45\x53\x53") {
            goto yTDtD;
        }
        goto Ku1bS;
        YaxFP:
        if ($result_code == "\123\125\x43\103\105\123\x53") {
            goto ICr60;
        }
        goto XHcJ4;
        s3Hay:
        pdo_insert("\154\157\x6e\x61\x6b\x69\156\x67\x5f\150\x62\137\162\x65\x63\157\x72\x64", $recordData);
        goto rg_R0;
        bP8t9:
        $wxHongBaoHelper->setParameter("\164\157\x74\x61\154\137\x6e\165\x6d", 1);
        goto v1u2p;
        IilKm:
        if (!($responseObj->err_code == "\x53\x45\x43\x4f\116\x44\x5f\x4f\126\105\122\x5f\114\x49\115\x49\124\x45\x44")) {
            goto j_645;
        }
        goto vbTIQ;
        ecjN1:
        goto BVl03;
        goto TURE5;
        BHw3h:
        if ($responseObj->err_code == "\123\131\x53\x54\x45\115\105\122\122\x4f\x52") {
            goto HDRFS;
        }
        goto k4KFr;
        CrO6h:
        Vcd0Q:
        goto T_Sct;
        snsbX:
        goto E3P1_;
        goto uNqE4;
        PBMP6:
        LpQaH:
        goto Vh2bK;
        x6sUv:
        $wxHongBaoHelper = new FlashHongBaoHelper($this->apiclient_cert, $this->apiclient_key, $this->rootca, $this->PASSKEY);
        goto ghKIR;
        Ama3J:
        if ($responseObj->err_code == "\x54\111\115\x45\x5f\114\111\115\111\124\x45\x44") {
            goto Af1PL;
        }
        goto R7ET_;
        wgl21:
        throw new FlashHongBaoException("\xe7\xb3\xbb\xe7\xbb\x9f\xe7\xb9\201\xe5\xbf\231\357\xbc\214\350\xaf\267\xe7\250\215\345\220\216\xe5\x86\215\xe8\xaf\x95\41" . $responseObj->err_code_des, 10403);
        goto JYHG4;
        I22vN:
        goto Vcd0Q;
        goto hTI2E;
        TURE5:
        iAFF8:
        goto z3Vdk;
        dAWPa:
        throw new FlashHongBaoException("\344\xbb\212\346\x97\xa5\347\272\xa2\345\x8c\x85\xe5\267\262\350\276\xbe\344\270\212\xe9\231\220\357\xbc\214\xe8\xaf\xb7\xe6\230\x8e\xe6\227\xa5\345\x86\x8d\350\xaf\x95\41", 10404);
        goto j5CMq;
        KgJ6m:
        CiIet:
        goto S9VNq;
        bXz1B:
        $mch_billno = date("\x59\x6d\x64\x48\x69\163") . rand(10, 9999);
        goto xt29O;
        rg1z2:
        zb1bS:
        goto w9vv2;
        EFdLZ:
        yjgKt:
        goto E09Ny;
        d1NvE:
        $wxHongBaoHelper->setParameter("\164\157\x74\x61\154\137\x61\x6d\x6f\165\156\x74", $this->money);
        goto bP8t9;
        NfiZN:
        if ($responseObj->err_code == "\124\x49\115\x45\137\x4c\111\x4d\x49\124\105\x44") {
            goto yjgKt;
        }
        goto BHw3h;
        QUHuI:
        throw new FlashHongBaoException("\xe7\216\260\xe5\234\xa8\xe9\x9d\x9e\347\272\xa2\345\x8c\205\xe5\217\x91\xe6\x94\xbe\xe6\x97\xb6\351\227\xb4\357\xbc\214\350\xaf\xb7\xe5\234\xa8\345\x8c\227\344\xba\254\346\x97\266\351\x97\xb4\60\x3a\x30\x30\x2d\x38\72\x30\x30\344\xb9\213\345\xa4\x96\xe7\x9a\x84\346\x97\xb6\xe9\x97\264\345\x89\215\346\235\245\351\xa2\x86\345\217\x96", 10402);
        goto r02_F;
        Ku1bS:
        $recordData["\163\164\141\x74\165\163"] = 0;
        goto O59Ai;
        ghKIR:
        $wxHongBaoHelper->setParameter("\x6e\x6f\156\143\145\137\163\x74\162", $commonUtil->create_noncestr());
        goto xjadi;
        HhapC:
        $responseObj = simplexml_load_string($responseXml, "\x53\x69\x6d\x70\x6c\x65\x58\x4d\x4c\105\154\x65\x6d\145\x6e\x74", LIBXML_NOCDATA);
        goto cnQMt;
        O59Ai:
        $recordData["\x72\145\x73\x70\157\156\163\145\x5f\145\162\162\x5f\143\157\144\x65"] = $responseObjArr["\145\x72\x72\137\x63\157\x64\145"];
        goto UqvNA;
        hTI2E:
        yTDtD:
        goto YaxFP;
        Vz7fL:
        if (!($responseObj->err_code == "\123\x45\103\x4f\116\104\x5f\117\126\105\122\137\114\x49\x4d\x49\x54\x45\x44")) {
            goto LctJT;
        }
        goto Qbm7p;
        twqrR:
        uaDoP:
        goto VB0OJ;
        JYHG4:
        iwbAQ:
        goto oX28C;
        LpT4C:
        $responseObjText = json_encode($responseObj);
        goto xKz4a;
        T_Sct:
    }
}
