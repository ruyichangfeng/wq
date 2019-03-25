<?php
/*
 __________________________________________________
|  Encode by BajieTeam on we7                      |
|__________________________________________________|
*/

goto EU1vD;
T_77f:
require_once dirname(__FILE__) . "\57\143\x6c\141\x73\163\x2f\x70\x6f\x73\x74\145\x72\x2f\116\x47\123\120\x6f\163\x74\x65\162\x53\145\x72\166\x69\x63\x65\56\160\150\x70";
goto qzqho;
dKT9W:
require_once dirname(__FILE__) . "\x2f\x63\154\x61\x73\x73\x2f\142\x6c\x6f\143\x6b\57\x4e\x47\123\x42\154\157\x63\153\123\x65\x72\x76\x69\143\x65\x2e\160\x68\x70";
goto nDD14;
EU1vD:
/**
 * 全新积分商城模块订阅器
 *
 * @author 八戒
 * @url http://bbs.we7.cc/
 */
defined("\111\x4e\x5f\111\101") or die("\101\x63\143\145\163\x73\x20\x44\145\x6e\x69\145\144");
goto T_77f;
qzqho:
require_once dirname(__FILE__) . "\57\143\x6c\141\x73\x73\57\165\x73\x65\162\57\x4e\x47\123\125\163\145\162\123\145\x72\x76\151\143\145\56\x70\x68\x70";
goto dKT9W;
nDD14:
class Lonaking_new_gift_shopModuleReceiver extends WeModuleReceiver
{
    private $posterService;
    private $userService;
    private $blockService;
    private $flashUserService;
    public function __construct()
    {
        goto au33v;
        mBXA1:
        $this->userService = new NGSUserService();
        goto pQ7Am;
        au33v:
        $this->posterService = new NGSPosterService();
        goto mBXA1;
        pQ7Am:
        $this->blockService = new NGSBlockService();
        goto J4FfO;
        J4FfO:
        $this->flashUserService = new FlashUserService();
        goto eZIdR;
        eZIdR:
    }
    public function receive()
    {
        goto dfKAc;
        XdUNG:
        goto CiKMd;
        goto AE4S7;
        ZpJuT:
        lQcux:
        goto q2Egg;
        dfKAc:
        global $_GPC;
        goto sg0gy;
        BtITQ:
        $this->userService->log($this->message, "\345\xbd\223\345\x89\x8d\xe8\xaf\xb7\xe6\261\202\351\x87\215\345\xa4\x8d\54\351\224\201\350\xa1\xa8\xe4\xb8\xad\x2e\x2e\x2e");
        goto Iarny;
        l0dYm:
        if ($this->message["\x65\x76\x65\x6e\164"] == "\165\x6e\x73\x75\x62\x73\x63\162\151\142\145") {
            goto WxAOH;
        }
        goto gBVBB;
        q2Egg:
        if (!($this->message["\x6d\163\147\x74\x79\x70\x65"] == "\145\x76\145\x6e\x74")) {
            goto OGXXM;
        }
        goto sA_r4;
        gBVBB:
        if ($this->message["\145\x76\x65\x6e\164"] == "\x73\165\142\163\143\162\x69\142\x65") {
            goto O2ywM;
        }
        goto XdUNG;
        AE4S7:
        WxAOH:
        goto s75z5;
        D9Inj:
        O2ywM:
        goto nOy0k;
        amgqo:
        gYZbd:
        goto bJMcR;
        uZry2:
        $this->userService->log($user, "\xe5\275\x93\345\x89\215\347\224\250\346\x88\xb7\344\277\241\xe6\x81\257\xe4\270\xba");
        goto vc_HT;
        Iarny:
        return '';
        goto ZpJuT;
        s75z5:
        $this->userService->log($this->message, "\xe5\217\226\xe6\xb6\x88\345\205\263\xe6\xb3\xa8");
        goto crLFC;
        Dh8fe:
        return '';
        goto amgqo;
        Cd7I6:
        if (!$this->blockService->isBlock($openid, $createtime)) {
            goto lQcux;
        }
        goto BtITQ;
        RuOx7:
        return '';
        goto Zmd7A;
        Y5sMx:
        $this->posterService->log($_GPC, "\xe5\xbe\256\xe6\x93\216\xe7\x9a\x84\350\xae\242\351\x98\205\346\xb5\213\xe8\xaf\225\346\x9c\xba\xe5\x88\266");
        goto Dh8fe;
        A0UGo:
        $type = $this->message["\x74\171\160\x65"];
        goto mQZ26;
        b4NYN:
        CiKMd:
        goto FYV0V;
        sA_r4:
        $this->blockService->block($openid, $createtime);
        goto l0dYm;
        bJMcR:
        $this->posterService->log($this->message, "\350\xaf\xb7\346\261\202\346\225\260\xe6\215\xae");
        goto A0UGo;
        FYV0V:
        $this->blockService->unBlock($openid, $createtime);
        goto c8mdK;
        c6Yvr:
        if (!($_GPC["\x64\157"] == "\x63\x68\145\143\x6b")) {
            goto gYZbd;
        }
        goto Y5sMx;
        nOy0k:
        $user = $this->userService->getUserInfoInApp($openid);
        goto uZry2;
        ldKlH:
        $createtime = $this->message["\x63\x72\145\141\x74\x65\x74\x69\x6d\145"];
        goto AHSe0;
        vc_HT:
        $this->userService->log($this->message, "\xe5\x85\263\xe6\263\250");
        goto i7Dyx;
        sg0gy:
        $this->posterService->log($_GPC, "\346\225\xb0\xe6\215\256");
        goto c6Yvr;
        AHSe0:
        $tmp_fans = mc_fansinfo($openid);
        goto Cd7I6;
        mQZ26:
        $openid = $this->message["\146\162\157\x6d\165\163\145\x72\x6e\x61\x6d\x65"];
        goto ldKlH;
        i7Dyx:
        $this->subscribeHandle($this->message);
        goto b4NYN;
        f4gF8:
        goto CiKMd;
        goto D9Inj;
        crLFC:
        $this->unSubscribeHandle($this->message);
        goto f4gF8;
        c8mdK:
        OGXXM:
        goto RuOx7;
        Zmd7A:
    }
    private function subscribeHandle($message)
    {
        goto nBvKd;
        ZBaE0:
        $user = $this->userService->getUserInfoInApp($openid);
        goto KhZ_a;
        uHN19:
        if (empty($poster["\163\x75\x62\163\143\162\x69\142\145\x5f\x74\x69\x70"])) {
            goto tQ1Vx;
        }
        goto n7pEr;
        W0ZP0:
        $this->userService->log($scene, "\344\270\x8a\xe7\272\247\351\x82\200\350\257\267\xe4\272\xba\xe7\x9a\x84\xe9\202\x80\xe8\257\267\143\157\144\145\xe4\270\xba");
        goto BM6EL;
        gcPIq:
        if (empty($scene) && $user["\x70\151\x64"] > 0) {
            goto T7aex;
        }
        goto YDkSJ;
        j_F0B:
        $pUser = null;
        goto gcPIq;
        hOung:
        $this->userService->log(null, "\345\xa5\x96\xe5\212\xb1\xe5\x88\x9d\xe5\xa7\x8b\xe5\x8c\226\345\205\xb3\xe6\263\xa8\xe7\xa7\xaf\345\210\x86\xe5\xb9\xb6\xe6\x9b\xb4\xe6\x96\260\xe5\205\xb3\xe6\xb3\xa8\xe5\xa5\226\xe5\212\xb1\347\212\266\346\200\x81\xe6\x88\220\345\x8a\x9f");
        goto gq20Q;
        KhZ_a:
        $scene = $this->message["\x73\143\x65\156\x65"];
        goto BN3tK;
        dVq_W:
        if (!($poster["\x73\x75\142\x73\143\162\151\x62\x65\137\x72\x65\x77\x61\162\x64\163\137\x73\143\157\162\x65"] > 0 && $user["\163\x75\142\x73\143\x72\151\x62\145\x5f\143\150\x61\x72\147\x65\x5f\163\164\x61\164\x75\163"] == 0)) {
            goto c2XnY;
        }
        goto LqDXN;
        SC0Dq:
        $user["\160\x69\x64"] = $pUser["\151\x64"];
        goto CnyrV;
        l1mv5:
        $poster = $this->posterService->getPosterConfig($_W["\165\x6e\x69\141\x63\x69\x64"]);
        goto wMUVk;
        dwwf_:
        RdbX3:
        goto fcQ3A;
        fcQ3A:
        tQ1Vx:
        goto BnwjO;
        V_7TS:
        $this->userService->subscribeCharge($user["\x70\x69\144"], $poster, $user, $type);
        goto fzph6;
        LqDXN:
        $this->flashUserService->addUserScore($poster["\163\165\x62\163\143\x72\x69\x62\145\137\162\145\167\141\162\x64\163\137\163\143\x6f\x72\x65"], $openid, "\345\205\xb3\xe6\xb3\250\345\x88\x9d\xe5\xa7\213\xe5\xa5\226\345\x8a\261");
        goto gwa_o;
        gq20Q:
        c2XnY:
        goto uHN19;
        LTWdG:
        $type = "\160\151\144";
        goto Pfbsl;
        BM6EL:
        $type = "\x69\156\166\x69\164\x65\x5f\143\157\x64\145";
        goto j_F0B;
        XWR5Z:
        $this->userService->sendTextMessage($openid, $this->prepareText($poster["\x73\165\x62\x73\143\x72\x69\142\145\x5f\x74\x69\160"], array("\x6e\151\143\x6b\x6e\141\155\145" => $user["\x6e\x69\143\x6b\156\141\155\x65"], "\151\156\x76\151\x74\145\137\x75\163\x65\x72\137\156\x61\155\145" => $pUser["\156\151\143\153\156\x61\155\145"])));
        goto OaXxM;
        fzph6:
        goto ka8n6;
        goto aTEel;
        YDkSJ:
        if ($scene && empty($user["\x70\x69\x64"])) {
            goto lvMol;
        }
        goto M0pyl;
        mCgiL:
        $this->userService->log(null, "\163\x75\142\x73\143\x72\x69\x62\145\x48\141\156\x64\154\145\x20\x65\170\143\165\x74\x69\156\x67\40\x2e\56\x2e");
        goto l1mv5;
        j3zt0:
        $this->userService->log($scene, "\346\262\241\346\234\x89\344\270\212\347\xba\247\xe9\x82\x80\xe8\xaf\xb7\344\272\272\xe7\232\204\346\240\207\350\257\x86\346\x89\276\xe5\210\xb0");
        goto DlpB1;
        M0pyl:
        goto ka8n6;
        goto NNen_;
        gIYLQ:
        $type = "\151\156\x76\x69\x74\145\x5f\x63\x6f\144\x65";
        goto EQE_x;
        gwa_o:
        $this->userService->updateColumn("\163\x75\x62\163\x63\x72\151\142\x65\x5f\x63\x68\141\162\x67\x65\137\163\x74\x61\x74\x75\163", "\x31", $user["\151\x64"]);
        goto hOung;
        Pnu5a:
        WyPLI:
        goto dwwf_;
        NNen_:
        T7aex:
        goto LTWdG;
        EQE_x:
        $pUser = $this->userService->selectOne("\40\x61\x6e\x64\x20\151\156\x76\151\x74\x65\137\x63\157\x64\x65\x3d{$scene}");
        goto UZawh;
        S5y5Q:
        if ($user["\x73\165\142\163\143\162\x69\x62\145\x5f\x63\150\141\162\x67\145\x5f\163\164\141\164\165\x73"] > 0) {
            goto WyPLI;
        }
        goto XWR5Z;
        BN3tK:
        if (!(empty($scene) && empty($user["\x70\x69\144"]))) {
            goto hXQDT;
        }
        goto j3zt0;
        DlpB1:
        return true;
        goto vxb9Y;
        nBvKd:
        global $_W;
        goto mCgiL;
        wMUVk:
        $openid = $message["\146\162\157\x6d\165\163\145\x72\x6e\x61\x6d\145"];
        goto ZBaE0;
        n7pEr:
        $message = htmlspecialchars_decode($poster["\163\165\142\163\x63\x72\151\x62\145\137\164\151\160"]);
        goto S5y5Q;
        vxb9Y:
        hXQDT:
        goto W0ZP0;
        Li4vC:
        $this->userService->log(null, "\xe8\256\xbe\xe7\xbd\256\xe7\273\x91\345\xae\x9a\xe7\210\266\xe9\202\200\xe8\257\267\344\xba\272\xe6\x88\220\345\212\237");
        goto dVq_W;
        aTEel:
        lvMol:
        goto gIYLQ;
        Pfbsl:
        $pUser = $this->userService->selectById($user["\160\151\144"]);
        goto V_7TS;
        CnyrV:
        $this->userService->updateData($user);
        goto rDkFV;
        OaXxM:
        goto RdbX3;
        goto Pnu5a;
        rDkFV:
        ka8n6:
        goto Li4vC;
        UZawh:
        $this->userService->subscribeCharge($scene, $poster, $user, $type);
        goto SC0Dq;
        BnwjO:
    }
    private function unSubscribeHandle($message)
    {
        goto k33vV;
        uunAW:
        if (!is_null($user)) {
            goto FI8aH;
        }
        goto KceDh;
        ISH6I:
        FI8aH:
        goto BeEpG;
        F6f13:
        return true;
        goto G2qzE;
        dAaxh:
        $user["\160\151\144"] = 0;
        goto D48pd;
        BeEpG:
        if ($user["\160\151\x64"] > 0) {
            goto uPZ2y;
        }
        goto BrYle;
        d_gRU:
        dT35s:
        goto gwEWG;
        hDOwn:
        $openid = $message["\146\162\x6f\155\165\163\145\x72\x6e\x61\x6d\x65"];
        goto zVDQD;
        KceDh:
        return true;
        goto ISH6I;
        IpLDI:
        $user["\x73\165\x62\x73\x63\x72\151\142\x65"] = 0;
        goto dAaxh;
        xHu9V:
        $this->flashUserService->reduceUserScore($poster["\x73\165\142\x73\x63\x72\151\142\145\137\x72\145\167\x61\162\x64\x73\x5f\x73\x63\157\162\145"], $openid, "\345\217\226\xe6\xb6\210\xe5\x85\263\346\xb3\xa8\345\x88\235\xe5\247\x8b\345\245\x96\xe5\x8a\xb1\346\211\xa3\351\231\244");
        goto VW0rW;
        zVDQD:
        $user = $this->userService->selectOne("\40\141\156\144\40\157\x70\x65\x6e\x69\144\x3d\47{$openid}\x27");
        goto ixceh;
        EuJE3:
        $poster = $this->posterService->getPosterConfig($_W["\x75\156\x69\x61\143\151\x64"]);
        goto Nhwga;
        BrYle:
        $user["\163\x75\142\163\143\x72\151\142\x65"] = 0;
        goto ca7Yo;
        c9SC2:
        $user = $this->userService->getUserInfoInApp($openid);
        goto IpLDI;
        ca7Yo:
        $this->userService->updateData($user);
        goto F6f13;
        ibGyB:
        uPZ2y:
        goto EuJE3;
        ixceh:
        if (!($poster["\163\x75\142\x73\x63\x72\x69\x62\145\137\162\x65\x77\141\x72\144\163\x5f\163\143\x6f\162\x65"] > 0 && $user["\163\165\142\163\x63\162\151\142\145\137\x63\150\141\x72\147\145\x5f\x73\164\x61\x74\165\163"] == 0)) {
            goto Oat_i;
        }
        goto xHu9V;
        FvY5l:
        $poster = $this->posterService->getPosterConfig($_W["\165\156\151\141\143\x69\x64"]);
        goto hDOwn;
        k33vV:
        global $_W;
        goto FvY5l;
        D48pd:
        $this->userService->updateData($user);
        goto d_gRU;
        G2qzE:
        goto dT35s;
        goto ibGyB;
        Nhwga:
        $this->userService->unSubscribePunish($user["\160\151\144"], $poster, $user);
        goto c9SC2;
        VW0rW:
        Oat_i:
        goto uunAW;
        gwEWG:
    }
    private function prepareText($text, $arr)
    {
        goto km6sB;
        j91TD:
        return $text;
        goto AEV3X;
        ZASUk:
        $text = str_replace("\43\173\x69\x6e\166\x69\x74\145\137\165\x73\145\x72\x5f\x6e\141\x6d\145\x7d\43", $arr["\151\156\166\151\164\x65\x5f\x75\x73\145\x72\137\156\141\x6d\145"], $text);
        goto j91TD;
        km6sB:
        $text = str_replace("\x23\x7b\x6e\151\143\153\156\141\155\x65\175\43", $arr["\x6e\151\143\153\x6e\141\x6d\x65"], $text);
        goto ZASUk;
        AEV3X:
    }
}
