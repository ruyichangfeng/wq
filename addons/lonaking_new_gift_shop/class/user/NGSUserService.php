<?php
/*
 __________________________________________________
|  Encode by BajieTeam on we7                      |
|__________________________________________________|
*/

goto aoWbs;
QM4w0:
require_once dirname(__FILE__) . "\57\x2e\x2e\57\x69\x6e\166\151\164\x65\x2f\x4e\107\123\111\x6e\166\151\x74\x65\122\145\143\157\x72\144\x53\x65\162\x76\151\143\145\x2e\x70\150\160";
goto I2TXM;
OqEeA:
require_once dirname(__FILE__) . "\x2f\56\56\57\56\56\x2f\x2e\56\57\x6c\157\x6e\x61\x6b\151\x6e\147\137\x66\154\141\163\x68\57\106\154\141\163\150\125\163\145\x72\123\145\162\x76\x69\143\x65\56\160\150\x70";
goto cys1r;
aoWbs:
require_once dirname(__FILE__) . "\x2f\56\x2e\57\56\x2e\57\56\56\57\x6c\x6f\156\141\153\x69\156\x67\x5f\x66\154\x61\x73\x68\x2f\x46\x6c\x61\x73\x68\x43\157\x6d\x6d\157\x6e\123\x65\162\x76\151\143\145\x2e\x70\150\x70";
goto OqEeA;
cys1r:
require_once dirname(__FILE__) . "\x2f\56\56\57\x2e\x2e\57\x2e\x2e\x2f\154\157\156\x61\153\x69\x6e\x67\137\x66\154\141\163\x68\x2f\x75\x73\145\x72\x2f\143\162\x65\144\x69\x74\x2f\x46\154\141\163\x68\x43\x72\x65\x64\151\x74\x53\145\x72\x76\x69\x63\145\56\x70\150\x70";
goto QM4w0;
I2TXM:
class NGSUserService extends FlashCommonService
{
    const POSTER_MODE_SCORE = 1;
    const POSTER_MODE_MONEY = 2;
    const POSTER_MODE_SCORE_AND_MONEY = 3;
    const POSTER_POSTING = 1;
    const POSTER_FREE = 0;
    private $flashUserService;
    private $flashCreditService;
    private $ngsInviteRecordService;
    public function __construct()
    {
        goto KMyIN;
        ufd9H:
        $this->table_name = "\154\157\156\x61\x6b\151\156\x67\x5f\x6e\145\x77\x5f\x67\151\146\164\137\163\150\x6f\x70\x5f\165\163\145\x72";
        goto S8uWX;
        FsSKN:
        $this->ngsInviteRecordService = new NGSInviteRecordService();
        goto ZyzzJ;
        KMyIN:
        $this->plugin_name = "\154\157\x6e\141\153\x69\x6e\x67\137\x6e\x65\167\x5f\x67\151\146\x74\x5f\163\150\157\x70";
        goto ufd9H;
        vlvXl:
        $this->flashCreditService = new FlashCreditService();
        goto FsSKN;
        S8uWX:
        $this->columns = "\x69\x64\x2c\x75\x6e\151\141\x63\x69\x64\x2c\155\x6f\x62\151\154\x65\54\151\x6e\166\151\x74\x65\x5f\x63\x6f\144\x65\x2c\x70\157\x73\164\145\162\137\164\151\155\x65\x73\54\x69\x6e\x5f\x70\157\x73\x74\x69\156\147\54\155\x73\147\x5f\151\x64\x2c\x73\x75\142\x73\143\162\x69\x62\145\x5f\143\150\141\162\147\145\137\x73\164\141\x74\165\x73\54\165\151\x64\54\x73\x75\142\163\x63\x72\x69\142\145\54\157\x70\145\156\x69\x64\x2c\x62\x6f\x72\162\x6f\x77\137\157\160\x65\156\151\x64\x2c\x6e\151\x63\153\156\141\x6d\x65\x2c\141\x76\141\x74\x61\162\54\160\151\144\x2c\160\157\x73\164\145\x72\x2c\160\157\x73\164\145\x72\x5f\165\x70\144\141\x74\145\137\164\151\x6d\x65\54\161\162\x63\157\x64\145\54\161\162\143\x6f\144\x65\x5f\165\160\x64\141\x74\x65\x5f\x74\151\x6d\145\x2c\x69\x6e\166\x69\164\145\137\163\x63\x6f\x72\145\x2c\151\x6e\166\151\164\x65\x5f\155\157\156\145\171\x2c\x69\x6e\166\x69\x74\145\137\x63\x6f\x75\156\164\x2c\151\156\166\151\164\145\x5f\x63\x61\156\143\x65\x6c\x5f\x63\157\x75\x6e\164\x2c\x69\156\x76\151\164\x65\137\143\x61\156\x63\145\x6c\x5f\x73\143\157\x72\145\54\x69\x6e\166\151\x74\x65\137\x63\141\156\143\145\154\137\155\x6f\156\x65\171\54\x73\x65\x63\x6f\x6e\144\137\x69\x6e\x76\151\164\145\137\x73\143\x6f\x72\x65\x2c\163\x65\x63\157\156\x64\137\x69\x6e\166\151\x74\145\137\x6d\157\156\145\171\x2c\x73\x65\x63\157\x6e\x64\137\x69\156\166\x69\164\145\x5f\143\157\x75\x6e\x74\x2c\163\145\x63\x6f\156\144\x5f\151\x6e\x76\151\164\x65\137\x63\x61\x6e\x63\145\154\x5f\143\x6f\165\156\x74\x2c\163\x65\x63\157\x6e\144\137\151\156\166\x69\x74\x65\x5f\x63\x61\x6e\143\145\x6c\x5f\163\x63\x6f\162\145\x2c\163\x65\x63\157\x6e\x64\137\151\x6e\166\151\x74\x65\x5f\143\x61\x6e\143\x65\x6c\137\155\x6f\156\145\171\x2c\164\x68\151\x72\x64\x5f\x69\156\x76\151\x74\145\x5f\x73\143\x6f\162\145\x2c\x74\x68\151\x72\144\137\x69\x6e\x76\151\x74\145\x5f\x6d\157\x6e\x65\171\x2c\164\x68\x69\x72\144\x5f\x69\x6e\166\151\164\x65\137\143\x6f\165\156\164\54\164\150\x69\x72\x64\x5f\x69\156\166\x69\164\145\137\143\x61\156\x63\x65\x6c\137\x63\x6f\x75\156\x74\x2c\164\150\151\162\144\137\x69\156\166\x69\x74\145\x5f\x63\141\156\143\145\154\x5f\x73\x63\157\162\x65\54\164\150\x69\162\144\x5f\151\x6e\x76\x69\x74\145\137\x63\141\x6e\x63\145\x6c\x5f\155\157\156\x65\x79\54\x74\x6f\164\141\x6c\x5f\151\x6e\x76\151\x74\145\137\163\143\157\x72\x65\54\x74\x6f\164\141\154\137\151\x6e\x76\151\164\x65\x5f\155\157\156\145\x79\x2c\x62\x6c\141\x63\x6b\54\x63\162\145\141\164\145\137\164\151\x6d\145\54\x75\x70\144\141\x74\x65\137\x74\x69\155\x65";
        goto MVyiZ;
        MVyiZ:
        $this->flashUserService = new FlashUserService();
        goto vlvXl;
        ZyzzJ:
    }
    private function initUser($openid = '')
    {
        goto nO6lx;
        R9elO:
        return $user;
        goto AZ4Ra;
        VxStH:
        $user = $this->insertData($user);
        goto R9elO;
        NNX0H:
        $this->log($fansInfo, "\x47\x65\164\x20\x66\141\156\x73\40\151\x6e\146\157\40\x66\162\157\x6d\40\x77\x65\x37\40\x64\x61\164\141");
        goto PPlCT;
        Z7MJ9:
        $fansInfo = $this->flashUserService->fetchFansInfo($openid);
        goto NNX0H;
        V3xN7:
        return $user;
        goto HluV0;
        AZ4Ra:
        zaP_G:
        goto V3xN7;
        WYLhR:
        $user = $this->selectOne("\x20\141\x6e\x64\40\x6f\x70\145\x6e\x69\x64\75\47{$openid}\x27");
        goto FCqGO;
        FCqGO:
        if (!empty($user)) {
            goto zaP_G;
        }
        goto Z7MJ9;
        PPlCT:
        $user = array("\x75\156\151\x61\143\x69\144" => $_W["\x75\156\x69\x61\143\x69\144"], "\151\156\166\151\x74\145\x5f\x63\157\144\x65" => '', "\160\157\x73\x74\145\x72\137\164\x69\155\145\163" => 0, "\151\156\x5f\x70\x6f\x73\164\151\x6e\147" => 0, "\x75\151\x64" => $fansInfo["\165\x69\144"], "\x6f\160\x65\x6e\x69\x64" => $fansInfo["\157\160\x65\x6e\151\x64"], "\142\157\162\162\157\x77\137\x6f\160\145\x6e\151\x64" => $fansInfo["\x6f\160\x65\156\x69\x64"], "\x6e\151\143\x6b\x6e\141\x6d\145" => $fansInfo["\x6e\151\143\x6b\x6e\141\x6d\145"], "\141\x76\141\164\141\162" => $fansInfo["\164\x61\147"]["\141\166\141\x74\x61\162"], "\160\151\x64" => '', "\160\x6f\x73\x74\145\162" => '', "\x71\x72\143\157\144\145" => '', "\x71\x72\143\x6f\144\145\137\165\x70\x64\x61\164\x65\137\164\151\155\145" => '', "\x69\156\x76\151\x74\145\137\x73\143\157\x72\145" => 0, "\151\x6e\x76\x69\164\145\x5f\155\x6f\x6e\x65\x79" => 0, "\x69\156\166\x69\164\x65\x5f\x63\157\165\x6e\164" => 0, "\151\x6e\x76\151\164\145\137\143\141\156\143\145\x6c\137\143\157\x75\156\164" => 0, "\151\156\166\x69\164\x65\137\143\141\x6e\143\145\154\137\163\x63\x6f\x72\x65" => 0, "\151\x6e\166\x69\x74\x65\137\x63\x61\x6e\143\145\154\137\x6d\x6f\x6e\x65\x79" => 0, "\x73\145\x63\157\156\144\137\x69\156\166\151\164\x65\137\163\x63\157\x72\145" => 0, "\163\x65\x63\157\x6e\x64\x5f\x69\x6e\166\151\164\x65\x5f\x6d\157\x6e\x65\171" => 0, "\x73\145\x63\157\x6e\144\x5f\151\x6e\166\151\x74\145\x5f\x63\x6f\165\x6e\x74" => 0, "\x73\x65\x63\x6f\156\144\x5f\x69\x6e\x76\x69\164\x65\x5f\143\x61\156\x63\145\154\137\x63\157\165\156\164" => 0, "\x73\145\143\157\156\144\137\x69\156\166\x69\164\145\137\143\x61\x6e\x63\145\x6c\137\x73\x63\x6f\x72\x65" => 0, "\x73\x65\143\157\x6e\x64\x5f\x69\x6e\x76\x69\x74\145\137\x63\x61\156\x63\145\x6c\x5f\x6d\157\156\145\171" => 0, "\164\150\x69\162\144\137\151\x6e\x76\x69\x74\x65\137\x73\143\157\162\145" => 0, "\x74\150\151\x72\144\137\x69\x6e\166\x69\x74\x65\137\x6d\x6f\156\145\171" => 0, "\x74\150\x69\x72\x64\x5f\151\x6e\x76\x69\164\145\137\x63\157\x75\156\x74" => 0, "\164\x68\151\x72\x64\x5f\x69\x6e\x76\x69\164\x65\x5f\x63\x61\x6e\x63\x65\x6c\x5f\143\157\165\x6e\164" => 0, "\164\150\x69\162\144\x5f\x69\x6e\x76\151\164\145\x5f\x63\141\x6e\x63\x65\154\x5f\163\x63\x6f\x72\145" => 0, "\x74\x68\x69\162\x64\137\x69\x6e\x76\x69\164\145\137\x63\x61\156\x63\x65\154\137\155\157\156\x65\x79" => 0, "\x74\157\x74\x61\x6c\x5f\151\x6e\x76\151\x74\145\x5f\x73\x63\157\162\145" => 0, "\164\x6f\x74\141\x6c\x5f\151\156\166\151\x74\145\137\x6d\x6f\x6e\145\x79" => 0, "\x63\162\145\x61\164\145\x5f\x74\151\155\x65" => time(), "\165\160\144\141\164\145\x5f\x74\151\x6d\x65" => time());
        goto VxStH;
        nO6lx:
        global $_W;
        goto WYLhR;
        HluV0:
    }
    private function initUserInApp($openid)
    {
        goto Y3Yg9;
        Y3Yg9:
        global $_W;
        goto PsFI5;
        lnd84:
        $user = $this->insertData($user);
        goto N91vd;
        lV8lR:
        $fansInfo = mc_fansinfo($openid, $this->getUniacid());
        goto msS0b;
        PsFI5:
        load()->model("\155\x63");
        goto lV8lR;
        msS0b:
        $this->log($fansInfo, "\xe8\216\267\xe5\217\226\xe5\210\260\xe7\262\211\xe4\xb8\x9d\344\xbf\xa1\346\x81\257\xe4\xb8\xba");
        goto ECEwJ;
        N91vd:
        return $user;
        goto RPm_J;
        ECEwJ:
        $user = array("\x75\x6e\151\141\x63\x69\144" => $_W["\x75\x6e\151\141\143\x69\x64"], "\x69\x6e\166\151\164\145\137\143\157\144\x65" => '', "\x70\x6f\163\164\145\162\137\x74\x69\x6d\145\x73" => 0, "\151\156\x5f\x70\x6f\x73\164\151\x6e\147" => 0, "\x75\151\x64" => $fansInfo["\x75\151\x64"], "\x6f\x70\x65\156\x69\x64" => $fansInfo["\157\160\145\156\x69\x64"], "\x62\x6f\162\162\x6f\x77\137\157\160\145\156\151\144" => $fansInfo["\157\x70\x65\x6e\151\x64"], "\x6e\151\x63\153\x6e\x61\x6d\145" => $fansInfo["\156\x69\143\x6b\156\x61\155\145"], "\141\166\141\x74\141\162" => $fansInfo["\164\x61\147"]["\141\166\x61\164\x61\x72"], "\160\151\144" => '', "\x70\157\163\x74\145\162" => '', "\x70\157\163\164\145\x72\137\x75\160\x64\141\164\145\137\x74\151\155\145" => '', "\x71\162\143\x6f\144\x65" => '', "\x71\162\x63\x6f\x64\145\x5f\x75\x70\x64\141\x74\145\137\x74\151\x6d\145" => '', "\x69\156\166\x69\x74\x65\x5f\x73\143\x6f\x72\x65" => 0, "\151\x6e\x76\151\x74\145\137\155\x6f\x6e\145\171" => 0, "\x69\x6e\166\151\x74\145\x5f\x63\x6f\x75\x6e\x74" => 0, "\151\x6e\x76\151\164\x65\137\143\x61\x6e\x63\145\x6c\x5f\x63\157\165\156\x74" => 0, "\x69\156\x76\151\x74\x65\137\143\x61\x6e\143\145\154\137\163\143\157\162\145" => 0, "\151\156\x76\151\x74\145\x5f\x63\x61\156\143\x65\x6c\x5f\155\x6f\156\x65\171" => 0, "\163\145\143\x6f\x6e\x64\x5f\151\156\x76\x69\164\x65\x5f\163\x63\x6f\x72\145" => 0, "\163\x65\143\x6f\156\144\x5f\151\156\166\x69\x74\x65\137\x6d\157\156\x65\171" => 0, "\163\145\143\x6f\x6e\144\137\151\156\x76\x69\164\x65\x5f\143\x6f\165\156\x74" => 0, "\163\145\143\157\156\144\x5f\151\156\x76\151\x74\x65\x5f\143\141\x6e\x63\x65\x6c\x5f\143\x6f\x75\x6e\x74" => 0, "\163\145\143\x6f\156\x64\x5f\151\156\166\x69\164\145\137\x63\141\x6e\143\145\154\x5f\x73\143\x6f\162\145" => 0, "\x73\145\143\x6f\156\x64\137\x69\x6e\166\151\164\145\137\143\x61\156\x63\x65\x6c\137\155\x6f\x6e\x65\171" => 0, "\x74\x68\x69\x72\144\x5f\151\156\166\x69\x74\145\x5f\x73\143\157\162\145" => 0, "\164\150\x69\x72\144\x5f\151\x6e\166\x69\x74\145\x5f\x6d\x6f\x6e\x65\x79" => 0, "\x74\150\151\x72\144\x5f\x69\156\166\x69\164\x65\x5f\143\157\165\156\164" => 0, "\x74\x68\151\162\144\137\x69\x6e\x76\151\164\x65\x5f\143\141\156\143\145\154\137\143\157\x75\156\x74" => 0, "\x74\150\151\x72\144\x5f\151\x6e\166\x69\164\x65\x5f\x63\x61\x6e\x63\145\x6c\x5f\x73\x63\157\x72\x65" => 0, "\164\x68\x69\162\144\137\x69\156\x76\151\x74\x65\x5f\143\x61\x6e\143\x65\x6c\137\155\157\156\145\x79" => 0, "\164\x6f\x74\x61\154\137\x69\x6e\x76\x69\x74\x65\x5f\x73\x63\157\x72\145" => 0, "\164\x6f\x74\x61\x6c\137\x69\x6e\x76\151\x74\x65\x5f\155\157\x6e\145\x79" => 0, "\x63\x72\145\141\164\x65\137\164\x69\x6d\x65" => time(), "\165\160\144\x61\x74\145\x5f\x74\x69\x6d\145" => time());
        goto lnd84;
        RPm_J:
    }
    public function getUserInfo($openid = '', $fan = true)
    {
        goto fHe1n;
        F05ba:
        $user = $this->initUser($_W["\x6f\x70\145\156\151\x64"]);
        goto t9k3B;
        TPTQM:
        if (!empty($openid)) {
            goto EmcR2;
        }
        goto oUoYI;
        fMjaK:
        $user["\146\x61\156\x5f\x69\x6e\x66\157"] = $this->flashUserService->fetchFansInfo($openid);
        goto gktPx;
        v6IHY:
        if (!$fan) {
            goto FSoAE;
        }
        goto fMjaK;
        gktPx:
        FSoAE:
        goto wl3qW;
        hV_Uv:
        fFLVf:
        goto tmZPE;
        VKo11:
        $user = $this->selectOne("\x20\141\156\144\40\x6f\160\x65\156\151\x64\x3d\x27{$openid}\x27");
        goto s04QZ;
        s04QZ:
        if (!(is_null($user) || empty($user))) {
            goto fFLVf;
        }
        goto F05ba;
        wl3qW:
        return $user;
        goto UTbni;
        t9k3B:
        $this->log($user, "\x49\156\151\164\40\x75\x73\145\162\40\x69\x6e\146\157\40\163\x75\143\x63\145\x73\163\x21\41\x21");
        goto hV_Uv;
        fHe1n:
        global $_W;
        goto TPTQM;
        oUoYI:
        $openid = $_W["\157\160\145\156\x69\144"];
        goto ayEH0;
        tmZPE:
        $this->log($user, "\x46\145\164\143\x68\x20\x75\x73\x65\162\x20\151\156\x66\157\40\x73\x75\x63\143\x65\x73\x73");
        goto v6IHY;
        ayEH0:
        EmcR2:
        goto VKo11;
        UTbni:
    }
    public function check_user_is_safe($userOrId)
    {
        goto KlF4H;
        fOmJ9:
        $user = $this->getByIdOrObj($userOrId);
        goto a7S0s;
        ZCljR:
        hEAhM:
        goto BvaWX;
        tZW9T:
        $count2 = $this->flashCreditService->count("\40\141\156\144\40\x75\x69\144\75{$uid}\x20\141\156\x64\40\156\165\155\x3e\60\40\141\156\144\40\x63\x72\x65\x61\x74\145\164\x69\x6d\x65\74\75{$lastWeekTimestamp}");
        goto VzGxx;
        y9H2i:
        NJ0PT:
        goto F9bkV;
        tCPmi:
        $fan = pdo_fetch("\x73\x65\154\x65\x63\164\x20\x2a\40\x66\x72\157\155\40" . tablename("\x6d\143\x5f\155\141\160\160\151\156\147\x5f\x66\x61\156\x73") . "\40\167\150\x65\x72\x65\x20\x6f\160\x65\156\x69\x64\x3d\47{$openid}\47\x20\141\156\x64\x20\165\x6e\x69\141\143\x69\x64\75{$_W["\x75\156\x69\141\x63\151\x64"]}");
        goto D9PbZ;
        JZCpy:
        throw new Exception("\346\226\xb0\347\224\xa8\346\x88\xb7\xef\xbc\x8c\345\x85\263\346\xb3\xa8\344\xb8\x8d\xe8\266\xb3\xe4\270\200\xe6\230\237\346\234\237\xef\274\x8c\xe8\xaf\267\346\205\216\xe9\x87\x8d\345\xae\241\xe6\xa0\270", -4);
        goto j3npZ;
        RCkQT:
        throw new Exception("\350\257\245\347\224\xa8\346\x88\xb7\346\234\xaa\xe6\xb3\250\345\206\214\xe4\xb8\xba\344\274\232\xe5\221\x98\xef\274\x8c\345\xb1\205\347\204\xb6\345\217\xaf\344\273\xa5\345\205\x91\346\215\242\xe7\xa4\274\345\x93\201", -5);
        goto y9H2i;
        D9PbZ:
        if (!($fan["\x75\x69\144"] == 0)) {
            goto bz_Hy;
        }
        goto dWK2e;
        xxX9X:
        $uid = $this->flashUserService->fetchUid($openid);
        goto q7wrT;
        a7S0s:
        $openid = $user["\x6f\160\x65\156\x69\144"];
        goto xxX9X;
        Pmp29:
        $lastWeek = date("\131\x2d\x6d\x2d\144", strtotime("\55\x31\40\167\x65\x65\153"));
        goto OUIg0;
        dX1PB:
        if (!($count <= 2)) {
            goto OE0SU;
        }
        goto YDwXr;
        BvaWX:
        if (!($fan["\x66\157\x6c\154\x6f\x77\x74\x69\x6d\145"] > $lastWeekTimestamp)) {
            goto Da5tI;
        }
        goto JZCpy;
        tc9Id:
        throw new Exception("\350\xaf\245\xe7\x94\250\346\x88\267\xe4\270\200\xe6\230\x9f\xe6\234\237\345\x89\215\345\207\240\xe4\xb9\216\344\270\x8d\xe6\xb4\xbb\xe8\xb7\203\xef\274\x8c\347\252\201\347\x84\xb6\xe6\235\xa5\345\x85\221\xe6\x8d\xa2\xe7\xa4\xbc\345\x93\201\357\274\214\xe6\x88\x96\350\xae\xb8\xe6\234\211\xe4\xbb\x80\xe4\xb9\210\xe9\227\xae\xe9\xa2\x98", -1);
        goto nV_JO;
        QvS11:
        throw new Exception("\350\257\xa5\347\224\xa8\346\x88\xb7\345\xb9\xb6\xe6\xb2\xa1\xe6\234\211\xe5\205\xb3\346\xb3\xa8\346\x88\221\xe4\273\254\357\xbc\214\350\257\267\346\x85\x8e\351\x87\215\345\256\xa1\xe6\xa0\270", -6);
        goto ZCljR;
        MqEVi:
        if (!($fan["\x66\x6f\x6c\154\157\x77"] == 0)) {
            goto hEAhM;
        }
        goto QvS11;
        KlF4H:
        global $_W;
        goto fOmJ9;
        q_vYm:
        OE0SU:
        goto Pmp29;
        j3npZ:
        Da5tI:
        goto YV7bK;
        q7wrT:
        if ($uid) {
            goto NJ0PT;
        }
        goto RCkQT;
        F9bkV:
        $count = $this->flashCreditService->count("\40\x61\156\x64\40\165\151\x64\x3d{$uid}\x20\141\x6e\x64\x20\156\x75\x6d\x3e\60");
        goto dX1PB;
        YV7bK:
        return true;
        goto pLZ_T;
        dWK2e:
        throw new Exception("\xe8\xaf\245\347\x94\250\xe6\210\xb7\346\x9c\252\xe6\xb3\250\345\x86\214\344\270\272\344\274\x9a\345\221\230\xef\274\214\345\261\205\347\204\xb6\xe5\217\257\344\273\245\345\205\x91\xe6\215\242\347\xa4\274\xe5\x93\201", -5);
        goto FU9zs;
        YDwXr:
        throw new Exception("\xe8\xaf\xa5\xe7\x94\250\346\x88\xb7\350\242\xab\347\xb3\xbb\347\xbb\237\xe5\210\244\345\x88\xab\344\270\272\344\270\215\346\xb4\273\xe8\267\x83\347\224\250\xe6\x88\xb7\xef\xbc\x8c\347\xa7\257\345\210\206\xe8\256\xb0\xe5\xbd\x95\xe5\xb0\221\xe7\x9a\x84\xe5\217\xaf\346\x80\234", -2);
        goto q_vYm;
        VzGxx:
        if (!($count2 <= 1)) {
            goto ydYd1;
        }
        goto tc9Id;
        OUIg0:
        $lastWeekTimestamp = strtotime($lastWeek);
        goto tZW9T;
        nV_JO:
        ydYd1:
        goto tCPmi;
        FU9zs:
        bz_Hy:
        goto MqEVi;
        pLZ_T:
    }
    public function getUserInfoInApp($openid)
    {
        goto pvrwX;
        ZQMGT:
        $user = $this->selectOne("\40\141\156\144\x20\x6f\160\x65\156\x69\144\x3d\x27{$openid}\47");
        goto eZvFq;
        SVENQ:
        if (!empty($user)) {
            goto VAOmD;
        }
        goto xRzRM;
        OCdnR:
        return $user;
        goto ZqZeI;
        pvrwX:
        global $_W;
        goto ZQMGT;
        xRzRM:
        $user = $this->initUserInApp($openid);
        goto Ey9u8;
        h6xf0:
        $this->checkUserAvatarOldToNew($user);
        goto OCdnR;
        Ey9u8:
        VAOmD:
        goto h6xf0;
        eZvFq:
        $this->log($user, "\346\237\245\xe8\257\242\345\x87\xba\347\224\xa8\346\x88\xb7\xe4\277\241\xe6\201\xaf\xe5\246\x82\xe4\270\x8b");
        goto SVENQ;
        ZqZeI:
    }
    public function checkUserAvatarOldToNew($user)
    {
        goto CdRVg;
        AjJ86:
        return $user;
        goto k8VPQ;
        k8VPQ:
        goto V2QTp;
        goto RFSft;
        h3d7A:
        if (trim(substr($user["\141\166\141\x74\141\162"], 0, 4)) == "\x68\164\x74\x70" && !empty($user["\x6e\x69\x63\x6b\156\x61\155\x65"])) {
            goto DLinm;
        }
        goto RkV13;
        RkV13:
        if (strpos(empty($user["\x61\166\141\164\141\x72"]) || $user["\141\x76\141\164\141\x72"], "\154\x6f\156\x61\153\151\x6e\x67\137\156\x65\x77\x5f\147\151\x66\164\137\163\150\157\160") == 0 || empty($user["\156\x69\x63\153\156\141\x6d\145"])) {
            goto E8qTM;
        }
        goto AjJ86;
        Dj_Tn:
        $user["\156\151\143\153\x6e\x61\155\145"] = $fansInfo["\156\151\x63\x6b\156\141\x6d\x65"];
        goto dpRnb;
        kf61D:
        return $user;
        goto rAUd3;
        vA217:
        return $user;
        goto mNYWI;
        GceY_:
        DLinm:
        goto omHaO;
        n0ku0:
        load()->model("\155\x63");
        goto Srm84;
        GcoYh:
        $user["\141\166\x61\164\x61\x72"] = $fansInfo["\164\141\147"]["\x61\x76\x61\164\x61\162"];
        goto Dj_Tn;
        RFSft:
        E8qTM:
        goto n0ku0;
        hcFwP:
        tvTAc:
        goto h3d7A;
        CdRVg:
        if (!($user["\x75\151\144"] == 0)) {
            goto tvTAc;
        }
        goto uZlkt;
        x8Qu5:
        goto B5PFH;
        goto GceY_;
        dpRnb:
        pdo_update($this->table_name, array("\141\x76\141\x74\141\162" => $fansInfo["\164\141\x67"]["\x61\x76\x61\x74\141\x72"], "\x6e\151\x63\x6b\156\x61\x6d\x65" => $fansInfo["\x6e\x69\143\x6b\156\141\x6d\x65"]), array("\x69\144" => $user["\x69\144"]));
        goto QA8kF;
        QA8kF:
        $this->log($fansInfo, "\xe6\xa3\x80\xe6\xb5\x8b\xe5\210\260\xe7\x94\xa8\xe6\x88\267\345\xa4\xb4\xe5\x83\x8f\346\230\257\xe8\200\201\345\244\264\345\x83\x8f\357\xbc\x8c\xe6\x9b\xbf\xe6\215\xa2\xe6\x88\x90\346\226\260\347\x9a\204\xe5\244\264\345\x83\217\xe5\x92\xaf");
        goto vA217;
        uZlkt:
        $this->log(null, "\xe6\243\200\346\xb5\x8b\345\210\260\xe7\x94\xa8\xe6\x88\xb7\x75\x69\144\344\xb8\272\60");
        goto dLsbt;
        mNYWI:
        V2QTp:
        goto x8Qu5;
        omHaO:
        $this->log($user["\141\x76\141\164\141\162"], "\xe6\243\x80\346\265\213\xe5\210\xb0\347\224\xa8\xe6\210\xb7\xe5\244\xb4\xe5\203\217\346\x98\xaf\xe5\xbe\256\xe4\xbf\241\xe5\256\x98\346\226\xb9\xe5\244\264\xe5\x83\217\345\271\266\344\xb8\x94\346\230\265\347\xa7\xb0\344\270\215\344\270\272\xe7\251\xba");
        goto kf61D;
        rAUd3:
        B5PFH:
        goto vSBgn;
        dLsbt:
        return $user;
        goto hcFwP;
        Srm84:
        $fansInfo = mc_fansinfo($user["\x6f\160\145\x6e\x69\144"]);
        goto GcoYh;
        vSBgn:
    }
    public function unSubscribePunish($inviteUserId, $poster, $user, $inviteCodeType = "\x69\x6e\166\151\164\x65\x5f\x63\157\x64\145")
    {
        goto Zd692;
        XpNrw:
        $tip .= "\350\216\xb7\xe5\xbe\227\xe7\247\257\345\210\206\xe6\203\xa9\xe7\275\x9a{$third_unfollow_score}\347\247\257\xe5\210\206";
        goto gPwR1;
        ieWFz:
        WDObc:
        goto B23SJ;
        ZX6Xv:
        if (!$poster["\151\x6e\x76\151\164\157\162\x5f\165\x6e\163\x75\x62\163\x63\162\x69\x62\145\137\164\x69\x70"]) {
            goto qpEdf;
        }
        goto VZAsU;
        m2Kiw:
        $secondUser = null;
        goto V6JP3;
        LQS92:
        $tip .= "\xe8\242\253\xe6\x89\243\351\231\xa4\347\xa7\257\xe5\210\206{$third_unfollow_score}\xe7\xa7\xaf\345\x88\x86\343\x80\x81\346\x89\243\351\x99\xa4\xe7\216\260\351\207\221{$third_unfollow_money}\345\205\203";
        goto ieWFz;
        e0njc:
        if ($mode == NGSUserService::POSTER_MODE_SCORE) {
            goto CY1RP;
        }
        goto cgijX;
        WimNL:
        if (!($deep >= 1)) {
            goto MQfH8;
        }
        goto lbbKJ;
        weCMT:
        $third_unfollow_score = $poster["\164\150\x69\162\x64\137\165\156\x66\157\x6c\154\157\x77\137\163\143\x6f\x72\145"];
        goto pPmra;
        MbB41:
        if ($mode == NGSUserService::POSTER_MODE_SCORE_AND_MONEY) {
            goto S9i1O;
        }
        goto pEAc7;
        t4eon:
        $inviteUser["\x69\156\x76\151\x74\x65\x5f\143\141\x6e\x63\145\154\137\x6d\x6f\x6e\x65\x79"] = $inviteUser["\151\x6e\166\x69\164\x65\x5f\x63\141\x6e\143\145\154\x5f\155\x6f\156\145\x79"] + $unfollow_money;
        goto PcOSg;
        TIupd:
        $mode = $poster["\x6d\x6f\x64\145"];
        goto ANjwm;
        nIJdN:
        $this->sendTextMessage($secondUser["\x6f\x70\145\x6e\x69\144"], $tip);
        goto zBr06;
        ANjwm:
        $unfollow_score = $poster["\x75\156\x66\157\x6c\x6c\157\x77\x5f\x73\x63\157\x72\x65"];
        goto hH3J6;
        vAoDz:
        $tip .= "\350\x8e\267\345\276\x97\347\216\260\351\207\221\xe6\203\251\347\xbd\x9a{$second_unfollow_money}\xe5\x85\x83";
        goto n1_Q3;
        Wrrkv:
        $this->ngsInviteRecordService->moneySuccess($inviteRecord);
        goto vAoDz;
        gE_WB:
        $uniacid = $_W["\165\156\x69\141\143\x69\x64"];
        goto WimNL;
        ROczr:
        $thirdUser["\164\157\164\141\154\x5f\151\x6e\166\x69\x74\145\x5f\x73\143\157\162\x65"] = $thirdUser["\x74\157\x74\x61\154\137\x69\x6e\166\x69\x74\x65\137\163\x63\x6f\162\x65"] - $third_unfollow_score;
        goto VNf3f;
        hlYA5:
        $this->updateData($thirdUser);
        goto uJvRO;
        YjjIW:
        $thirdUser = $this->selectById($secondUser["\160\x69\144"]);
        goto iVIVC;
        lGA3H:
        $third_unfollow_money = $poster["\164\x68\151\162\x64\x5f\x75\156\146\x6f\x6c\x6c\x6f\x77\137\155\157\x6e\145\171"];
        goto IEV3J;
        WRBt1:
        $this->ngsInviteRecordService->scoreMoneyStart($inviteRecord, -$third_unfollow_score, -$third_unfollow_money);
        goto m_PyG;
        sZMgj:
        $this->ngsInviteRecordService->scoreSuccess($inviteRecord);
        goto XpNrw;
        hlqwL:
        $this->ngsInviteRecordService->scoreStart($inviteRecord, -$unfollow_score);
        goto ZfoFJ;
        MfVJF:
        goto WDObc;
        goto XL2f5;
        uYGzk:
        $inviteUser["\x69\x6e\166\151\x74\145\137\x63\x61\156\x63\x65\154\x5f\155\157\x6e\x65\x79"] = $inviteUser["\151\156\x76\x69\x74\145\137\x63\x61\156\143\x65\154\x5f\x6d\157\x6e\x65\x79"] + $unfollow_money;
        goto bD3cs;
        aph9J:
        $inviteRecord = $this->ngsInviteRecordService->createUnSubscribeRecord($user, $inviteUser, 1, $uniacid);
        goto rWa3p;
        DPwad:
        $thirdUser["\x74\150\151\x72\144\x5f\151\156\x76\x69\164\145\x5f\143\141\x6e\143\145\154\137\155\157\156\145\x79"] = $thirdUser["\164\x68\x69\162\144\137\x69\156\x76\x69\x74\x65\x5f\x63\141\156\143\x65\154\137\x6d\157\x6e\145\171"] + $third_unfollow_money;
        goto Umojk;
        k4lfj:
        $this->ngsInviteRecordService->scoreSuccess($inviteRecord);
        goto kQ2I5;
        Nt3mm:
        eELmV:
        goto Nk_Uq;
        DAwaz:
        $secondUser["\165\x70\144\x61\x74\x65\137\164\151\155\x65"] = time();
        goto Ppi3M;
        Umojk:
        $thirdUser["\164\x6f\x74\141\154\x5f\x69\x6e\166\151\x74\x65\137\155\157\x6e\x65\x79"] = $thirdUser["\164\157\x74\141\x6c\x5f\x69\156\x76\x69\164\145\137\155\x6f\156\145\x79"] - $third_unfollow_money;
        goto LhvDo;
        B23SJ:
        $thirdUser["\x75\160\144\x61\x74\x65\x5f\164\x69\x6d\145"] = time();
        goto P3sOS;
        Ppi3M:
        $secondUser["\x73\145\x63\x6f\156\144\137\151\x6e\x76\151\x74\145\x5f\x63\x61\156\x63\145\x6c\137\x63\x6f\x75\x6e\164"] = $secondUser["\163\x65\x63\157\x6e\144\137\151\156\166\151\164\x65\137\x63\141\156\143\x65\154\x5f\x63\157\165\156\x74"] + 1;
        goto qFoLF;
        BoRj3:
        $this->flashUserService->reduceUserScore($second_unfollow_score, $secondUser["\x6f\160\x65\x6e\151\x64"], "\xe4\270\x8b\xe7\272\xa7\x5b{$inviteUser["\156\151\x63\153\x6e\x61\x6d\145"]}\x5d\351\x82\x80\xe8\257\xb7\xe7\x94\250\xe6\210\267\xe5\217\226\xe6\xb6\210\xe5\205\xb3\xe6\xb3\250\xe6\203\xa9\xe7\275\x9a");
        goto z5W60;
        jK1O5:
        $this->ngsInviteRecordService->scoreStart($inviteRecord, -$third_unfollow_score);
        goto YtYki;
        kuNRR:
        $secondUser["\163\145\143\157\x6e\x64\137\151\x6e\x76\151\x74\145\137\143\141\156\143\x65\154\x5f\155\157\156\x65\171"] = $secondUser["\x73\x65\x63\157\156\144\x5f\151\x6e\x76\151\164\x65\x5f\143\141\x6e\x63\x65\x6c\137\155\157\156\x65\171"] + $second_unfollow_money;
        goto JB5Tp;
        YAGze:
        $this->ngsInviteRecordService->moneySuccess($inviteRecord);
        goto Ff_Pb;
        Sr69u:
        $this->sendTextMessage($inviteUser["\x6f\160\x65\x6e\151\x64"], $tip);
        goto Cu3Kb;
        Nk_Uq:
        $this->ngsInviteRecordService->moneyStart($inviteRecord, -$third_unfollow_money);
        goto DPwad;
        rlC8g:
        if (!($deep >= 3 && $secondUser["\x70\151\x64"] > 0)) {
            goto iLfVE;
        }
        goto YjjIW;
        Cu3Kb:
        MQfH8:
        goto ZLAmy;
        rWa3p:
        if ($mode == NGSUserService::POSTER_MODE_SCORE) {
            goto EcjRn;
        }
        goto zgNCp;
        sJwIX:
        E2yBw:
        goto p1zbf;
        z5W60:
        $this->ngsInviteRecordService->scoreSuccess($inviteRecord);
        goto d1mLr;
        y4dDZ:
        if ($mode == NGSUserService::POSTER_MODE_SCORE_AND_MONEY) {
            goto r4EIM;
        }
        goto hZxA4;
        oLJJF:
        $inviteUser["\151\x6e\166\x69\x74\x65\x5f\x63\x61\x6e\x63\x65\x6c\137\163\143\157\162\x65"] = $inviteUser["\x69\x6e\x76\151\x74\x65\137\x63\141\x6e\143\x65\x6c\137\x73\143\x6f\162\x65"] + $unfollow_score;
        goto Nhfm3;
        ede6D:
        $tip .= "\350\xa2\xab\346\211\xa3\351\x99\244{$unfollow_score}\347\xa7\xaf\345\x88\x86\343\x80\x81\xe6\x89\243\351\x99\244\xe7\216\260\xe9\207\x91{$unfollow_money}\345\205\x83";
        goto uuT4E;
        AOvUT:
        $secondUser["\x73\145\143\x6f\156\x64\137\x69\156\166\151\164\145\x5f\x63\x61\x6e\x63\x65\x6c\x5f\155\157\x6e\x65\171"] = $secondUser["\163\x65\143\x6f\156\144\137\x69\x6e\x76\x69\164\145\x5f\x63\141\x6e\143\145\x6c\137\155\x6f\156\145\171"] + $second_unfollow_money;
        goto BoCmz;
        VNf3f:
        $this->flashUserService->reduceUserScore($third_unfollow_score, $thirdUser["\x6f\160\x65\x6e\151\x64"], "\xe4\270\x89\347\272\247\347\224\xa8\346\x88\267\xe5\217\x96\346\xb6\210\xe5\205\263\346\xb3\250\346\203\251\xe7\275\232");
        goto sZMgj;
        uJvRO:
        if (!$poster["\x74\x68\x69\162\144\137\x69\x6e\166\151\164\x6f\x72\x5f\165\x6e\163\165\142\163\143\162\151\x62\145\x5f\164\x69\x70"]) {
            goto uLLyz;
        }
        goto IAKAr;
        qzIDA:
        $this->ngsInviteRecordService->scoreSuccess($inviteRecord);
        goto W8I2Q;
        VwKLy:
        if ($mode == NGSUserService::POSTER_MODE_SCORE_AND_MONEY) {
            goto hneZT;
        }
        goto MfVJF;
        cHB1m:
        hneZT:
        goto WRBt1;
        gPwR1:
        goto WDObc;
        goto Nt3mm;
        jNroh:
        goto WDObc;
        goto cHB1m;
        hZxA4:
        goto lPrzS;
        goto Z1lgt;
        Ff_Pb:
        $tip .= "\xe8\216\xb7\xe5\276\x97\xe7\216\260\xe9\x87\x91\xe6\x83\251\xe7\xbd\232{$unfollow_money}\345\x85\203";
        goto PO2Bo;
        hVBTz:
        goto lPrzS;
        goto mr_V7;
        cgijX:
        if ($mode == NGSUserService::POSTER_MODE_MONEY) {
            goto eELmV;
        }
        goto VwKLy;
        d1mLr:
        $this->flashUserService->reduceUserMoney($second_unfollow_money, $secondUser["\x6f\x70\x65\156\151\x64"], "\xe4\270\x8b\xe7\xba\247\133{$inviteUser["\156\151\x63\x6b\x6e\141\155\145"]}\x5d\351\202\x80\350\257\xb7\xe7\224\xa8\346\x88\267\345\x8f\226\346\xb6\210\xe5\205\xb3\xe6\xb3\250\xe6\x83\251\xe7\275\232");
        goto ecL22;
        ACSdg:
        $this->ngsInviteRecordService->scoreSuccess($inviteRecord);
        goto YPvNE;
        V6JP3:
        $thirdUser = null;
        goto gE_WB;
        dpFee:
        if (!is_null($secondUser)) {
            goto oRT7_;
        }
        goto URX1I;
        kZMFT:
        qpEdf:
        goto Sr69u;
        yJNkn:
        $inviteRecord = $this->ngsInviteRecordService->createUnSubscribeRecord($user, $secondUser, 2, $uniacid);
        goto VzXbV;
        payiO:
        $this->ngsInviteRecordService->moneySuccess($inviteRecord);
        goto R_MvH;
        L0j1r:
        if ($mode == NGSUserService::POSTER_MODE_MONEY) {
            goto vJyxF;
        }
        goto y4dDZ;
        BoCmz:
        $secondUser["\164\157\164\x61\x6c\137\x69\156\166\151\x74\145\137\155\157\x6e\145\x79"] = $secondUser["\164\157\x74\x61\154\x5f\151\156\x76\151\x74\x65\137\x6d\x6f\x6e\x65\171"] - $second_unfollow_money;
        goto BoRj3;
        OiCWt:
        $this->ngsInviteRecordService->scoreSuccess($inviteRecord);
        goto g7v4t;
        xpQ7o:
        uLLyz:
        goto hnb4n;
        P3sOS:
        $thirdUser["\164\150\x69\x72\144\x5f\x69\x6e\x76\x69\x74\145\x5f\x63\141\x6e\143\x65\154\x5f\143\157\165\x6e\x74"] = $thirdUser["\164\150\x69\162\144\x5f\151\156\x76\x69\x74\145\137\143\x61\x6e\143\145\154\x5f\143\x6f\165\x6e\164"] + 1;
        goto hlYA5;
        SshF6:
        $this->ngsInviteRecordService->moneyStart($inviteRecord, -$unfollow_money);
        goto t4eon;
        NAttb:
        $secondUser["\164\x6f\164\x61\154\137\151\x6e\166\151\164\145\x5f\x73\x63\157\162\x65"] = $secondUser["\x74\157\x74\141\x6c\x5f\x69\x6e\x76\x69\x74\x65\137\163\x63\157\x72\x65"] - $second_unfollow_score;
        goto AOvUT;
        ZLAmy:
        if (!($deep >= 2 && $inviteUser["\x70\151\x64"] > 0)) {
            goto nMwmd;
        }
        goto vIYuh;
        PO2Bo:
        goto K2tiA;
        goto gyn76;
        URX1I:
        return false;
        goto TmUHC;
        dMMgr:
        $tip = $this->prepareUnSubscribeToInvitorMessage($poster, $inviteUser, $user, 2);
        goto JgUAC;
        bD3cs:
        $inviteUser["\164\x6f\x74\141\x6c\137\x69\x6e\x76\151\x74\145\137\x6d\x6f\156\x65\x79"] = $inviteUser["\x74\x6f\164\141\x6c\137\x69\156\166\x69\x74\x65\x5f\155\157\x6e\x65\171"] - $unfollow_money;
        goto xom8R;
        P7sPm:
        $this->flashUserService->reduceUserScore($third_unfollow_score, $thirdUser["\157\160\x65\156\151\x64"], "\344\xb8\211\xe7\272\247\xe7\224\250\xe6\x88\267\xe5\x8f\x96\xe6\266\210\xe5\205\xb3\xe6\xb3\xa8\346\x83\xa9\347\xbd\232");
        goto k4lfj;
        Z1lgt:
        jBQLK:
        goto wB4am;
        CNLDj:
        $this->ngsInviteRecordService->scoreMoneyStart($inviteRecord, -$second_unfollow_score, -$second_unfollow_money);
        goto ju1X3;
        BqrRk:
        $inviteRecord = $this->ngsInviteRecordService->createUnSubscribeRecord($user, $thirdUser, 3, $uniacid);
        goto e0njc;
        YPvNE:
        $tip .= "\xe8\x8e\xb7\xe5\276\x97\xe7\xa7\xaf\xe5\x88\x86\xe6\203\251\347\xbd\232{$second_unfollow_score}\347\xa7\257\xe5\210\x86";
        goto hVBTz;
        kH8Pt:
        $thirdUser["\x74\157\164\141\x6c\x5f\x69\156\166\x69\x74\x65\137\155\x6f\156\x65\171"] = $thirdUser["\x74\x6f\164\x61\154\x5f\151\156\166\x69\x74\145\137\155\157\x6e\x65\171"] - $third_unfollow_money;
        goto P7sPm;
        YtYki:
        $thirdUser["\164\x68\151\162\x64\137\151\x6e\166\x69\164\x65\137\143\141\x6e\143\145\x6c\x5f\163\143\157\x72\x65"] = $thirdUser["\164\150\151\x72\x64\137\151\156\x76\151\164\145\x5f\x63\141\156\143\x65\154\x5f\x73\x63\157\x72\145"] + $third_unfollow_score;
        goto ROczr;
        zgNCp:
        if ($mode == NGSUserService::POSTER_MODE_MONEY) {
            goto f8DJt;
        }
        goto MbB41;
        vIYuh:
        $secondUser = $this->selectById($inviteUser["\x70\151\x64"]);
        goto dpFee;
        Nhfm3:
        $inviteUser["\164\157\164\x61\x6c\x5f\x69\x6e\166\x69\164\x65\x5f\x73\x63\x6f\x72\x65"] = $inviteUser["\x74\x6f\x74\x61\x6c\x5f\x69\x6e\166\x69\x74\145\137\x73\143\157\162\x65"] - $unfollow_score;
        goto uYGzk;
        TmUHC:
        oRT7_:
        goto r299B;
        LhvDo:
        $this->flashUserService->reduceUserMoney($third_unfollow_money, $thirdUser["\x6f\160\x65\156\x69\144"], "\344\270\211\xe7\xba\247\347\x94\xa8\xe6\210\267\345\x8f\226\346\xb6\210\345\x85\263\346\263\250\xe6\x83\251\xe7\275\x9a");
        goto payiO;
        ecL22:
        $this->ngsInviteRecordService->moneySuccess($inviteRecord);
        goto NzNgb;
        IEV3J:
        $inviteUser = $this->selectById($inviteUserId);
        goto m2Kiw;
        qcu02:
        EcjRn:
        goto hlqwL;
        GUeZB:
        if (!$poster["\163\145\143\x6f\156\x64\137\x69\x6e\166\151\x74\x6f\x72\x5f\165\156\163\x75\142\x73\143\x72\x69\x62\x65\137\164\151\160"]) {
            goto PWN_9;
        }
        goto dMMgr;
        n1_Q3:
        goto lPrzS;
        goto zGcJf;
        IAKAr:
        $tip = $this->prepareUnSubscribeToInvitorMessage($poster, $inviteUser, $user, 3);
        goto xpQ7o;
        mr_V7:
        vJyxF:
        goto I2Ugr;
        p1zbf:
        $tip = "\345\xbe\x88\xe6\x8a\xb1\346\xad\211\346\202\xa8\xe9\x97\xb4\346\x8e\xa5\xe9\202\200\350\xaf\xb7\347\232\x84\347\224\250\xe6\210\xb7\x5b{$user["\156\151\x63\153\156\x61\155\145"]}\x5d\345\x8f\x96\346\266\x88\xe5\205\263\346\263\250\54";
        goto BqrRk;
        UIEdP:
        $inviteUser["\x69\x6e\166\x69\164\145\x5f\143\x61\156\143\x65\x6c\137\143\x6f\x75\156\164"] = $inviteUser["\x69\156\x76\x69\x74\x65\x5f\143\x61\x6e\x63\145\154\x5f\x63\x6f\x75\x6e\164"] + 1;
        goto Bde7z;
        ZfoFJ:
        $inviteUser["\x69\x6e\x76\x69\164\x65\x5f\143\x61\x6e\143\145\x6c\x5f\163\143\x6f\x72\145"] = $inviteUser["\x69\x6e\166\x69\x74\x65\137\143\x61\x6e\x63\x65\x6c\137\x73\143\x6f\162\145"] + $unfollow_score;
        goto mzBHO;
        VsHWT:
        $this->flashUserService->reduceUserMoney($unfollow_money, $inviteUser["\157\x70\x65\x6e\151\144"], "\351\202\200\xe8\257\xb7\347\x94\250\346\210\267\133{$user["\156\151\x63\153\x6e\141\155\x65"]}\x5d\xe5\217\x96\xe6\266\x88\345\205\xb3\346\263\250\xe6\203\xa9\xe7\275\x9a");
        goto YAGze;
        VzXbV:
        if ($mode == NGSUserService::POSTER_MODE_SCORE) {
            goto jBQLK;
        }
        goto L0j1r;
        qFoLF:
        $this->updateData($secondUser);
        goto GUeZB;
        Zd692:
        global $_W;
        goto UDfHK;
        Sx2WX:
        return false;
        goto sJwIX;
        JgUAC:
        PWN_9:
        goto nIJdN;
        Bde7z:
        $this->updateData($inviteUser);
        goto ZX6Xv;
        VWDpO:
        $inviteUser["\165\160\x64\141\164\145\x5f\164\x69\155\x65"] = time();
        goto UIEdP;
        zGcJf:
        r4EIM:
        goto CNLDj;
        lbbKJ:
        $tip = "\345\276\x88\346\x8a\xb1\xe6\xad\x89\346\x82\250\347\x9b\264\xe6\216\xa5\xe9\202\x80\xe8\257\xb7\347\232\204\xe7\224\250\xe6\210\267\133{$user["\156\151\x63\x6b\x6e\x61\155\x65"]}\135\345\217\226\xe6\xb6\x88\xe5\205\xb3\xe6\263\250\54";
        goto aph9J;
        iVIVC:
        if (!is_null($thirdUser)) {
            goto E2yBw;
        }
        goto Sx2WX;
        cCz9_:
        $this->flashUserService->reduceUserMoney($second_unfollow_money, $secondUser["\x6f\x70\145\156\151\x64"], "\344\270\x8b\xe7\272\xa7\x5b{$inviteUser["\156\151\143\x6b\156\141\155\145"]}\135\xe9\202\200\350\257\xb7\347\224\250\xe6\210\267\345\217\x96\xe6\xb6\210\xe5\205\xb3\xe6\263\xa8\xe6\203\251\347\275\232");
        goto Wrrkv;
        VZAsU:
        $tip = $this->prepareUnSubscribeToInvitorMessage($poster, $inviteUser, $user);
        goto kZMFT;
        it9n9:
        iLfVE:
        goto e4mQJ;
        hnb4n:
        $this->sendTextMessage($thirdUser["\157\x70\145\x6e\151\x64"], $tip);
        goto it9n9;
        PcOSg:
        $inviteUser["\x74\x6f\x74\x61\x6c\137\x69\x6e\166\x69\x74\145\x5f\155\157\156\145\x79"] = $inviteUser["\164\x6f\x74\141\x6c\x5f\151\156\x76\151\164\145\x5f\x6d\x6f\x6e\x65\171"] - $unfollow_money;
        goto VsHWT;
        r299B:
        $tip = "\xe5\276\210\346\212\xb1\xe6\xad\x89\346\x82\250\xe9\x97\xb4\xe6\216\245\xe9\202\x80\350\257\267\347\232\x84\xe7\224\xa8\346\210\xb7\x5b{$user["\156\151\x63\x6b\x6e\141\x6d\x65"]}\x5d\xe5\x8f\226\346\xb6\x88\345\x85\xb3\xe6\263\xa8\x2c";
        goto yJNkn;
        zBr06:
        nMwmd:
        goto rlC8g;
        W8I2Q:
        $tip .= "\xe8\216\xb7\xe5\276\227\xe7\247\xaf\xe5\210\206\xe6\203\251\347\275\232{$unfollow_score}\347\xa7\257\345\x88\206";
        goto kBgNs;
        kQ2I5:
        $this->flashUserService->reduceUserMoney($third_unfollow_money, $thirdUser["\x6f\160\x65\156\151\x64"], "\344\xb8\211\347\272\247\xe7\224\xa8\xe6\x88\267\345\x8f\226\346\xb6\210\xe5\x85\263\346\xb3\250\xe6\203\251\347\xbd\232");
        goto X5oxv;
        R_MvH:
        $tip .= "\xe8\216\267\xe5\276\x97\xe7\216\xb0\xe9\x87\221\xe6\x83\xa9\xe7\275\232{$third_unfollow_money}\xe5\x85\x83";
        goto jNroh;
        ju1X3:
        $secondUser["\163\x65\x63\x6f\156\144\x5f\x69\x6e\x76\x69\164\145\137\x63\x61\156\143\145\x6c\x5f\x73\143\157\162\x65"] = $secondUser["\163\145\143\157\156\x64\x5f\x69\x6e\166\x69\164\145\x5f\143\x61\156\143\145\154\137\x73\x63\157\x72\x65"] + $second_unfollow_score;
        goto NAttb;
        V58NA:
        f8DJt:
        goto SshF6;
        m_PyG:
        $thirdUser["\x74\150\x69\162\x64\x5f\151\x6e\x76\x69\164\x65\x5f\143\x61\x6e\x63\145\x6c\137\163\143\x6f\x72\x65"] = $thirdUser["\164\x68\x69\x72\x64\137\x69\x6e\166\151\x74\x65\137\x63\x61\156\x63\145\x6c\137\x73\143\x6f\162\x65"] + $third_unfollow_score;
        goto PWHNK;
        NzNgb:
        $tip .= "\350\xa2\xab\346\x89\xa3\351\x99\244{$second_unfollow_score}\347\247\xaf\345\x88\x86\xe3\x80\x81\346\x89\243\351\x99\244\xe7\216\260\351\x87\x91{$second_unfollow_money}\xe5\x85\203";
        goto vZ1FB;
        UDfHK:
        $deep = $poster["\144\145\145\160"];
        goto TIupd;
        Wd3yA:
        $thirdUser["\164\150\151\x72\x64\x5f\x69\156\x76\151\164\x65\x5f\143\x61\x6e\x63\x65\x6c\137\155\157\x6e\145\x79"] = $thirdUser["\x74\150\x69\x72\x64\x5f\x69\156\166\151\164\145\x5f\143\x61\156\143\x65\154\137\x6d\x6f\156\x65\171"] + $third_unfollow_money;
        goto kH8Pt;
        VwI_N:
        $secondUser["\164\157\x74\141\154\x5f\x69\x6e\166\151\x74\145\x5f\163\x63\x6f\x72\x65"] = $secondUser["\164\157\164\141\154\x5f\x69\156\166\x69\164\145\137\163\x63\157\162\145"] - $second_unfollow_score;
        goto e38Uj;
        wB4am:
        $this->ngsInviteRecordService->scoreStart($inviteRecord, -$second_unfollow_score);
        goto dlw5L;
        XL2f5:
        CY1RP:
        goto jK1O5;
        gyn76:
        S9i1O:
        goto IXl79;
        xom8R:
        $this->flashUserService->reduceUserScore($unfollow_score, $inviteUser["\157\160\x65\156\151\x64"], "\351\202\200\350\257\267\347\x94\250\xe6\x88\267\133{$user["\156\151\143\x6b\156\141\155\x65"]}\135\345\217\x96\346\266\210\345\205\xb3\xe6\263\xa8\xe6\203\251\xe7\xbd\232");
        goto OiCWt;
        pEAc7:
        goto K2tiA;
        goto qcu02;
        PWHNK:
        $thirdUser["\x74\157\164\x61\x6c\x5f\151\x6e\x76\x69\164\145\x5f\x73\143\157\162\145"] = $thirdUser["\x74\x6f\164\141\154\137\151\156\x76\151\x74\145\137\163\x63\x6f\x72\x65"] - $third_unfollow_score;
        goto Wd3yA;
        e38Uj:
        $this->flashUserService->reduceUserScore($second_unfollow_score, $secondUser["\157\160\x65\x6e\x69\144"], "\344\270\213\xe7\272\xa7\133{$inviteUser["\x6e\151\143\153\156\x61\155\x65"]}\135\351\202\x80\350\257\267\347\224\xa8\346\210\xb7\345\x8f\226\346\266\210\345\205\xb3\xe6\263\xa8\346\203\251\xe7\xbd\232");
        goto ACSdg;
        hH3J6:
        $second_unfollow_score = $poster["\x73\145\x63\157\156\x64\x5f\165\156\146\157\x6c\154\x6f\x77\x5f\x73\x63\x6f\162\145"];
        goto weCMT;
        xD45D:
        $this->flashUserService->reduceUserScore($unfollow_score, $inviteUser["\157\x70\145\x6e\x69\x64"], "\351\202\200\350\257\267\xe7\224\xa8\346\x88\xb7\x5b{$user["\156\151\x63\x6b\156\141\155\145"]}\x5d\345\217\x96\346\xb6\210\345\205\263\346\xb3\250\346\203\xa9\347\275\x9a");
        goto qzIDA;
        uuT4E:
        K2tiA:
        goto VWDpO;
        dlw5L:
        $secondUser["\x73\x65\x63\x6f\x6e\x64\137\x69\156\166\151\164\145\x5f\x63\141\x6e\x63\x65\154\137\163\x63\x6f\162\x65"] = $secondUser["\x73\x65\x63\157\x6e\x64\137\151\x6e\166\151\164\x65\x5f\143\x61\156\143\145\x6c\137\x73\x63\x6f\162\x65"] + $second_unfollow_score;
        goto VwI_N;
        yTeDD:
        $second_unfollow_money = $poster["\163\x65\x63\157\156\x64\x5f\165\x6e\x66\x6f\154\154\157\167\x5f\x6d\157\x6e\x65\171"];
        goto lGA3H;
        vZ1FB:
        lPrzS:
        goto DAwaz;
        IXl79:
        $this->ngsInviteRecordService->scoreMoneyStart($inviteRecord, -$unfollow_score, -$unfollow_money);
        goto oLJJF;
        g7v4t:
        $this->flashUserService->reduceUserMoney($unfollow_money, $inviteUser["\157\160\x65\156\151\144"], "\351\202\200\350\257\xb7\xe7\x94\xa8\346\210\xb7\133{$user["\156\x69\143\x6b\156\141\x6d\x65"]}\135\345\217\x96\346\xb6\210\345\205\xb3\xe6\xb3\xa8\346\x83\251\347\275\232");
        goto edDGB;
        kBgNs:
        goto K2tiA;
        goto V58NA;
        mzBHO:
        $inviteUser["\164\x6f\164\x61\154\x5f\x69\x6e\166\x69\x74\x65\137\x73\143\x6f\162\x65"] = $inviteUser["\x74\x6f\164\141\x6c\x5f\x69\x6e\x76\151\x74\145\x5f\x73\143\157\162\145"] - $unfollow_score;
        goto xD45D;
        I2Ugr:
        $this->ngsInviteRecordService->moneyStart($inviteRecord, -$second_unfollow_money);
        goto kuNRR;
        pPmra:
        $unfollow_money = $poster["\x75\x6e\146\x6f\x6c\x6c\x6f\167\137\x6d\x6f\x6e\x65\171"];
        goto yTeDD;
        X5oxv:
        $this->ngsInviteRecordService->moneySuccess($inviteRecord);
        goto LQS92;
        edDGB:
        $this->ngsInviteRecordService->moneySuccess($inviteRecord);
        goto ede6D;
        JB5Tp:
        $secondUser["\x74\157\164\141\154\137\x69\156\166\x69\x74\x65\x5f\x6d\x6f\156\x65\x79"] = $secondUser["\x74\157\164\x61\x6c\137\151\156\x76\x69\164\x65\137\155\157\156\145\171"] - $second_unfollow_money;
        goto cCz9_;
        e4mQJ:
    }
    public function subscribeCharge($inviteCode, $poster, $user, $inviteCodeType = "\x69\156\166\x69\x74\145\x5f\143\x6f\x64\x65")
    {
        goto dqsVh;
        ukJXr:
        return false;
        goto me9j_;
        VeLOn:
        $tip .= "\xe8\x8e\xb7\345\xbe\227\xe7\xa7\xaf\345\x88\206\xe5\245\x96\xe5\212\261{$third_follow_score}\347\xa7\257\345\210\x86\xef\274\214\xe5\222\214\347\x8e\xb0\351\207\221\345\245\226\345\x8a\xb1{$third_follow_money}\345\205\203";
        goto eKy8o;
        qNt9Y:
        $thirdUser["\164\157\x74\x61\x6c\137\151\156\x76\x69\164\x65\x5f\x6d\157\x6e\145\x79"] += $third_follow_money;
        goto WtqWl;
        Nty2H:
        E4_II:
        goto x03kw;
        SLgLT:
        $this->flashUserService->addUserScore($third_follow_score, $thirdUser["\157\160\x65\156\151\144"], "\351\202\200\350\xaf\xb7\xe5\x85\xb3\xe6\263\250\344\xb8\x89\347\xba\xa7\345\245\x96\345\x8a\261");
        goto USa7T;
        ue_kd:
        $this->flashUserService->addUserMoney($follow_money, $inviteUser["\x6f\x70\x65\156\x69\144"], "\351\x82\x80\350\xaf\xb7\x5b{$user["\x6e\x69\x63\153\x6e\x61\155\145"]}\x5d\xe5\205\xb3\346\263\250\xe4\270\200\347\272\247\345\xa5\x96\345\x8a\261");
        goto RANRk;
        ZDE3b:
        $thirdUser["\164\x6f\164\x61\154\137\151\156\x76\151\164\145\x5f\163\x63\x6f\x72\x65"] += $third_follow_score;
        goto SDgbD;
        Iqucd:
        $secondUser = $this->selectById($inviteUser["\x70\151\x64"]);
        goto UHJaB;
        Fd057:
        $this->updateData($thirdUser);
        goto BwIk9;
        chZge:
        goto MWQ8M;
        goto XuUFF;
        luyHS:
        return false;
        goto DZkTq;
        YBEVP:
        $this->log('', "\xe7\247\257\345\x88\x86\xef\xbc\x8b\xe7\x8e\260\xe9\x87\221\xe5\xa5\226\xe5\212\xb1\346\x88\x90\345\x8a\x9f");
        goto Nty2H;
        cb2nF:
        if ($mode == NGSUserService::POSTER_MODE_MONEY) {
            goto Xa163;
        }
        goto KA88O;
        P_QX3:
        goto OUA6L;
        goto czO9A;
        vG_2B:
        $invite_record = $this->ngsInviteRecordService->createSubscribeRecord($user, $thirdUser, 3, $uniacid);
        goto LRI7C;
        Mzi8O:
        return false;
        goto DGHC1;
        vNzfm:
        $invite_record = $this->ngsInviteRecordService->scoreSuccess($invite_record);
        goto aRwX9;
        VjA0c:
        if (!(is_null($inviteUser) || !$inviteUser["\x69\144"])) {
            goto Y0Bh3;
        }
        goto rRBuj;
        PrygZ:
        $this->ngsInviteRecordService->scoreMoneyStart($invite_record, $second_follow_score, $second_follow_money);
        goto vUvLy;
        bYzsb:
        $inviteUser["\151\x6e\166\x69\x74\145\137\x6d\x6f\x6e\145\x79"] = $inviteUser["\151\x6e\166\151\164\145\137\x6d\157\x6e\x65\171"] + $follow_money;
        goto Fh3x9;
        s9kJp:
        $tip .= "\350\x8e\267\xe5\xbe\x97\347\247\xaf\xe5\210\x86\xe5\xa5\x96\xe5\212\xb1{$third_follow_score}\xe7\xa7\xaf\345\210\x86";
        goto P_QX3;
        oDVZS:
        $this->ngsInviteRecordService->scoreMoneyStart($invite_record, $follow_score, $follow_money);
        goto bl93i;
        PrR7e:
        if (!$poster["\163\145\x63\157\156\144\x5f\x69\x6e\166\x69\x74\157\x72\137\x73\165\142\163\143\x72\x69\142\145\x5f\x74\x69\160"]) {
            goto yZvUt;
        }
        goto EtDUu;
        lWl2i:
        $this->log($secondUser, "\xe5\274\200\345\xa7\213\xe8\277\233\350\xa1\214\344\272\214\xe7\xba\247\xe5\xa5\x96\xe5\212\xb1");
        goto axZ9a;
        fefUQ:
        $this->log($thirdUser, "\xe5\xbc\200\xe5\xa7\x8b\xe8\xbf\233\350\xa1\x8c\344\xb8\211\xe7\272\247\345\245\x96\xe5\x8a\261");
        goto ClIrJ;
        TBrIe:
        ii0sP:
        goto sySkA;
        yi6NQ:
        goto OUA6L;
        goto xFYXt;
        aR7EX:
        $this->flashUserService->addUserScore($third_follow_score, $thirdUser["\157\x70\x65\156\151\144"], "\351\x82\200\xe8\xaf\267\xe5\205\263\346\263\250\xe4\270\211\347\xba\xa7\345\xa5\226\345\212\261");
        goto OB9en;
        hv60g:
        $thirdUser = null;
        goto yOdxb;
        A0dqn:
        $inviteUser["\x69\x6e\x76\x69\164\145\x5f\163\143\x6f\162\145"] = $inviteUser["\151\x6e\166\151\x74\x65\x5f\x73\x63\x6f\x72\x65"] + $follow_score;
        goto RKZZ1;
        LOgjy:
        $inviteUser["\164\157\164\x61\154\137\x69\156\x76\x69\164\145\137\x6d\157\156\145\x79"] += $follow_money;
        goto mJCzQ;
        OB9en:
        $invite_record = $this->ngsInviteRecordService->scoreSuccess($invite_record);
        goto HhpPk;
        rkPoL:
        $deep = intval($poster["\x64\145\145\x70"]);
        goto RDb0O;
        fS_pf:
        Pdx5b:
        goto q9pqA;
        me9j_:
        PwVpY:
        goto lWl2i;
        C8yMd:
        $tip .= "\350\x8e\xb7\345\xbe\x97\xe7\x8e\xb0\xe9\x87\221\345\xa5\x96\xe5\212\261{$follow_money}\345\205\x83";
        goto E3F0A;
        YW1lj:
        $thirdUser["\x74\x68\x69\162\144\137\151\156\x76\x69\x74\x65\137\x6d\157\x6e\x65\x79"] = $thirdUser["\x74\150\151\x72\x64\x5f\x69\156\166\x69\164\x65\137\x6d\x6f\156\x65\171"] + $third_follow_money;
        goto qNt9Y;
        z0krU:
        $invite_record = $this->ngsInviteRecordService->moneySuccess($invite_record);
        goto k4EFJ;
        duw3X:
        $secondUser["\163\x65\x63\x6f\156\x64\x5f\x69\x6e\166\151\164\145\137\x6d\157\156\145\171"] = $secondUser["\163\145\143\x6f\156\x64\137\151\156\x76\x69\164\x65\x5f\155\157\156\x65\x79"] + $second_follow_money;
        goto u1SXK;
        gHmjM:
        $this->log($result, "\345\217\221\xe9\x80\201\x32\xe7\xba\xa7\345\245\x96\xe5\x8a\xb1\xe9\x80\232\xe7\237\245");
        goto rN5PP;
        dX7eh:
        Xa163:
        goto ljOKX;
        SVlco:
        I7fp4:
        goto VjA0c;
        U39jU:
        $tip .= "\350\216\267\xe5\xbe\x97\xe7\247\257\345\210\x86\345\245\x96\345\x8a\261{$follow_score}\347\xa7\257\345\210\206\357\274\214\345\x92\214\347\216\xb0\351\x87\x91\xe5\xa5\x96\xe5\x8a\261{$follow_money}\345\205\x83";
        goto YBEVP;
        sySkA:
        $this->ngsInviteRecordService->scoreStart($invite_record, $third_follow_score);
        goto zNUTm;
        PSViV:
        if ($mode == NGSUserService::POSTER_MODE_SCORE) {
            goto pAMWf;
        }
        goto cb2nF;
        q0E1Y:
        $mode = $poster["\x6d\157\144\145"];
        goto PwBIe;
        W8ly3:
        pWwPg:
        goto RmHGH;
        BG4AZ:
        T39kB:
        goto QejvM;
        Fh3x9:
        $inviteUser["\164\157\x74\x61\154\x5f\151\156\166\x69\164\x65\137\155\x6f\156\145\171"] += $follow_money;
        goto fMv9z;
        m5mvs:
        $inviteUser["\x69\x6e\x76\151\x74\145\x5f\143\157\165\x6e\x74"] = $inviteUser["\x69\x6e\x76\151\x74\x65\x5f\x63\157\x75\156\x74"] + 1;
        goto m8Bxd;
        Vm94e:
        $follow_money = $poster["\146\x6f\x6c\x6c\x6f\167\x5f\155\157\x6e\145\x79"];
        goto Jfog3;
        eG14c:
        $invite_record = $this->ngsInviteRecordService->createSubscribeRecord($user, $secondUser, 2, $uniacid);
        goto PSViV;
        HeeuP:
        Dtw_c:
        goto ircH9;
        TgBIy:
        if ($inviteCodeType == "\151\156\166\151\164\145\137\143\157\x64\145") {
            goto v4Dbh;
        }
        goto nc4EP;
        cdDj3:
        $invite_record = $this->ngsInviteRecordService->moneySuccess($invite_record);
        goto C8yMd;
        ljOKX:
        $this->ngsInviteRecordService->moneyStart($invite_record, $second_follow_money);
        goto duw3X;
        q9pqA:
        $inviteUser = $this->selectById($inviteCode);
        goto W8ly3;
        l47Qm:
        $this->flashUserService->addUserScore($second_follow_score, $secondUser["\157\x70\145\156\151\x64"], "\344\xb8\x8b\xe7\xba\247\x5b{$inviteUser["\x6e\151\143\x6b\x6e\x61\155\x65"]}\x5d\xe9\202\x80\350\257\267\345\205\263\xe6\xb3\250\344\272\x8c\xe7\272\247\xe5\xa5\x96\345\x8a\261");
        goto QWY4s;
        RDb0O:
        $this->log($inviteCode, "\345\256\203\351\x82\x80\xe8\xaf\xb7\xe4\272\206\344\xb8\x80\xe4\xb8\xaa\xe7\224\xa8\xe6\x88\xb7\x5b{$user["\156\x69\x63\153\x6e\x61\x6d\145"]}\135\xe5\205\xb3\xe6\263\250");
        goto q0E1Y;
        QWY4s:
        $invite_record = $this->ngsInviteRecordService->scoreSuccess($invite_record);
        goto LYiRb;
        UHJaB:
        if (!is_null($secondUser)) {
            goto PwVpY;
        }
        goto ukJXr;
        kQWlX:
        $secondUser["\x73\145\x63\157\x6e\x64\x5f\151\156\166\x69\164\x65\137\x63\x6f\x75\156\x74"] = $secondUser["\163\145\x63\x6f\x6e\144\137\151\156\x76\151\164\145\x5f\143\157\x75\x6e\164"] + 1;
        goto FFv0G;
        rRBuj:
        $this->log('', "\xe7\224\xa8\346\210\267\xe5\205\263\xe6\263\250\357\274\214\xe6\227\xa0\xe9\202\x80\xe8\257\xb7\344\xba\xba");
        goto Mzi8O;
        Mz_Bz:
        $secondUser["\x75\160\144\141\x74\x65\x5f\x74\151\x6d\145"] = time();
        goto kQWlX;
        aBiso:
        $second_follow_score = $poster["\163\145\143\157\156\144\137\146\x6f\x6c\154\157\167\x5f\163\x63\x6f\x72\145"];
        goto SNq0t;
        C7sBc:
        Dc_xk:
        goto lbd07;
        ypm8O:
        $tip .= "\xe8\x8e\xb7\345\276\x97\347\216\xb0\351\x87\x91\xe5\xa5\x96\xe5\212\xb1{$third_follow_money}\345\205\203";
        goto yi6NQ;
        W7lb3:
        if (!$poster["\x69\x6e\x76\x69\164\x6f\x72\x5f\x73\165\142\x73\143\x72\151\x62\145\137\x74\151\x70"]) {
            goto jsStR;
        }
        goto F3rM1;
        Aa07v:
        if ($mode == NGSUserService::POSTER_MODE_MONEY) {
            goto T39kB;
        }
        goto nI6Ng;
        C1hca:
        $secondUser["\163\x65\x63\x6f\x6e\x64\x5f\151\x6e\166\151\164\145\137\163\143\x6f\162\145"] += $second_follow_score;
        goto iJSq3;
        ea1QX:
        $third_follow_money = $poster["\164\x68\x69\162\144\x5f\146\157\x6c\x6c\157\167\x5f\x6d\x6f\156\145\171"];
        goto sfHoG;
        Aidnz:
        $thirdUser["\x74\x6f\x74\x61\x6c\137\151\156\166\x69\164\145\x5f\x73\143\157\162\x65"] += $third_follow_score;
        goto SLgLT;
        XuUFF:
        Jy5Sx:
        goto PrygZ;
        KA88O:
        if ($mode == NGSUserService::POSTER_MODE_SCORE_AND_MONEY) {
            goto Jy5Sx;
        }
        goto X0ZNo;
        x03kw:
        $inviteUser["\165\160\x64\x61\x74\x65\x5f\164\151\x6d\x65"] = time();
        goto m5mvs;
        DGHC1:
        Y0Bh3:
        goto g5zEZ;
        HZZbY:
        $this->flashUserService->addUserScore($follow_score, $inviteUser["\x6f\160\145\156\151\x64"], "\xe9\x82\200\xe8\257\267\x5b{$user["\156\151\x63\153\156\x61\x6d\x65"]}\x5d\xe5\x85\xb3\346\263\250\344\xb8\x80\347\272\xa7\345\xa5\x96\xe5\x8a\261");
        goto vNzfm;
        EexBZ:
        $invite_record = $this->ngsInviteRecordService->moneySuccess($invite_record);
        goto VeLOn;
        yOdxb:
        $this->log($inviteUser, "\351\x82\200\xe8\257\267\xe4\xba\xba");
        goto uMTYX;
        Li13s:
        $invite_record = $this->ngsInviteRecordService->moneySuccess($invite_record);
        goto ypm8O;
        tcogn:
        return false;
        goto SVlco;
        RG3Uv:
        $result = $this->sendTextMessage($inviteUser["\157\160\x65\156\151\x64"], $tip);
        goto lATLQ;
        w6ECK:
        if ($mode == NGSUserService::POSTER_MODE_SCORE) {
            goto AAfrE;
        }
        goto Aa07v;
        yA5bs:
        $this->flashUserService->addUserScore($second_follow_score, $secondUser["\x6f\x70\145\156\x69\144"], "\344\xb8\x8b\347\xba\247\x5b{$inviteUser["\x6e\151\x63\153\156\141\155\145"]}\x5d\351\202\200\xe8\xaf\267\345\205\263\346\xb3\250\xe4\xba\x8c\xe7\xba\247\345\245\x96\xe5\x8a\261");
        goto oerFa;
        lzrnR:
        jsStR:
        goto RG3Uv;
        llw4b:
        $secondUser["\x74\x6f\164\141\154\137\151\156\166\151\x74\145\x5f\x73\x63\157\x72\145"] += $second_follow_score;
        goto R44y_;
        u1SXK:
        $secondUser["\x74\157\x74\141\x6c\x5f\x69\156\166\151\164\x65\137\155\157\x6e\x65\x79"] += $second_follow_money;
        goto Wykj6;
        HhpPk:
        $this->flashUserService->addUserMoney($third_follow_money, $thirdUser["\157\160\x65\156\x69\x64"], "\351\202\x80\350\257\xb7\345\x85\263\xe6\263\250\xe4\270\211\xe7\272\xa7\345\xa5\x96\345\x8a\xb1");
        goto EexBZ;
        pIWrf:
        $tip = "\xe6\201\255\xe5\x96\234\xe6\x82\xa8\xe7\233\264\xe6\x8e\xa5\351\202\200\350\xaf\xb7\xe7\224\250\xe6\210\xb7\x5b{$user["\x6e\x69\x63\x6b\156\141\x6d\x65"]}\x5d\345\x85\263\346\xb3\250\54";
        goto w6ECK;
        ircH9:
        if (!($deep >= 2 && $inviteUser["\x70\x69\x64"] > 0)) {
            goto xuX5s;
        }
        goto Iqucd;
        eKy8o:
        OUA6L:
        goto SizkQ;
        k9kD9:
        pAMWf:
        goto kX8bA;
        Sozyr:
        $secondUser["\x74\157\x74\141\x6c\x5f\x69\156\166\x69\164\x65\137\155\157\156\145\x79"] += $second_follow_money;
        goto yA5bs;
        uMTYX:
        $uniacid = $_W["\x75\156\x69\x61\x63\151\x64"];
        goto uqS4V;
        jzm_4:
        if (!is_null($thirdUser)) {
            goto j57VM;
        }
        goto luyHS;
        kX8bA:
        $this->ngsInviteRecordService->scoreStart($invite_record, $second_follow_score);
        goto C1hca;
        WtqWl:
        $this->flashUserService->addUserMoney($third_follow_money, $thirdUser["\157\160\145\x6e\x69\x64"], "\351\202\x80\xe8\257\267\345\205\xb3\346\263\250\xe4\270\211\347\xba\247\345\xa5\x96\345\x8a\xb1");
        goto Li13s;
        SDgbD:
        $thirdUser["\164\150\151\x72\x64\137\x69\x6e\166\x69\x74\145\x5f\x6d\157\156\145\171"] = $thirdUser["\164\x68\x69\162\x64\137\151\x6e\166\x69\164\x65\137\x6d\x6f\x6e\x65\x79"] + $third_follow_money;
        goto rqFXW;
        W4xZy:
        yZvUt:
        goto PXyhR;
        iJSq3:
        $secondUser["\164\157\x74\x61\x6c\x5f\151\x6e\166\151\x74\145\137\163\x63\157\x72\x65"] += $second_follow_score;
        goto l47Qm;
        WSyHz:
        $thirdUser = $this->selectById($secondUser["\x70\151\144"]);
        goto jzm_4;
        rqFXW:
        $thirdUser["\164\x6f\164\141\154\137\x69\156\x76\151\164\x65\137\x6d\x6f\156\145\x79"] += $third_follow_money;
        goto aR7EX;
        PXyhR:
        $result = $this->sendTextMessage($secondUser["\157\x70\145\x6e\151\144"], $tip);
        goto gHmjM;
        E0v9v:
        $result = $this->sendTextMessage($thirdUser["\157\160\x65\x6e\151\x64"], $tip);
        goto idlqk;
        mx_KL:
        goto OUA6L;
        goto TBrIe;
        nI6Ng:
        if ($mode == NGSUserService::POSTER_MODE_SCORE_AND_MONEY) {
            goto rRe7O;
        }
        goto BX0zZ;
        iMw6T:
        MWQ8M:
        goto Mz_Bz;
        m8D2_:
        if ($mode == NGSUserService::POSTER_MODE_SCORE_AND_MONEY) {
            goto lxAPM;
        }
        goto mx_KL;
        IVrtG:
        $invite_record = $this->ngsInviteRecordService->createSubscribeRecord($user, $inviteUser, 1, $uniacid);
        goto pIWrf;
        jKgA0:
        $thirdUser["\164\150\151\162\x64\x5f\x69\x6e\x76\x69\164\x65\137\x63\x6f\165\x6e\164"] = $thirdUser["\164\150\151\162\x64\x5f\151\156\166\x69\164\x65\137\x63\x6f\x75\156\x74"] + 1;
        goto Fd057;
        zNUTm:
        $thirdUser["\x74\x68\x69\162\144\137\x69\156\166\x69\x74\145\x5f\163\x63\x6f\x72\x65"] += $third_follow_score;
        goto Aidnz;
        LN15t:
        rRe7O:
        goto oDVZS;
        LRI7C:
        if ($mode == NGSUserService::POSTER_MODE_SCORE) {
            goto ii0sP;
        }
        goto DgBbL;
        fMv9z:
        $this->flashUserService->addUserScore($follow_score, $inviteUser["\x6f\160\x65\x6e\151\144"], "\351\202\200\xe8\xaf\267\133{$user["\x6e\151\143\153\x6e\x61\x6d\145"]}\135\345\205\263\xe6\263\250\xe4\270\x80\347\xba\xa7\xe5\xa5\226\345\x8a\261");
        goto eK9th;
        oerFa:
        $invite_record = $this->ngsInviteRecordService->scoreSuccess($invite_record);
        goto DIXdU;
        WSpKJ:
        $thirdUser["\164\x68\x69\x72\144\x5f\x69\156\166\x69\x74\x65\137\x73\143\157\162\x65"] = $thirdUser["\x74\150\151\x72\x64\137\x69\156\x76\x69\164\145\x5f\163\x63\157\162\x65"] + $third_follow_score;
        goto ZDE3b;
        aNCLG:
        goto E4_II;
        goto LN15t;
        p6DTr:
        $invite_record = $this->ngsInviteRecordService->moneySuccess($invite_record);
        goto OYLTi;
        k4EFJ:
        $tip .= "\xe8\216\267\xe5\276\227\347\xa7\257\345\x88\x86\345\xa5\x96\xe5\x8a\261{$second_follow_score}\347\247\257\345\x88\206\357\274\214\xe5\222\214\xe7\x8e\260\351\207\221\345\xa5\226\xe5\x8a\261{$second_follow_money}\xe5\205\203";
        goto iMw6T;
        JNu06:
        $this->log('', "\347\xa7\257\xe5\x88\206\345\xa5\x96\345\x8a\xb1\346\210\x90\345\212\x9f");
        goto Auzpm;
        LYiRb:
        $tip .= "\xe8\216\xb7\xe5\276\227\xe7\xa7\xaf\345\x88\206\345\xa5\226\xe5\212\xb1{$second_follow_score}\347\247\xaf\xe5\210\206";
        goto EJrgW;
        ON8ft:
        goto pWwPg;
        goto fS_pf;
        DgBbL:
        if ($mode == NGSUserService::POSTER_MODE_MONEY) {
            goto kW1j1;
        }
        goto m8D2_;
        qmemp:
        $this->ngsInviteRecordService->moneyStart($invite_record, $third_follow_money);
        goto YW1lj;
        EJrgW:
        goto MWQ8M;
        goto dX7eh;
        kYxge:
        $this->ngsInviteRecordService->scoreMoneyStart($invite_record, $third_follow_score, $third_follow_money);
        goto WSpKJ;
        EtDUu:
        $tip = $this->prepareSubscribeToInvitorMessage($poster, $inviteUser, $user, 2);
        goto W4xZy;
        lATLQ:
        $this->log($result, "\345\217\221\xe9\x80\x81\xe9\x80\x9a\347\x9f\xa5");
        goto HeeuP;
        P2Seg:
        goto pWwPg;
        goto a4zOe;
        rN5PP:
        xuX5s:
        goto b8tPk;
        BX0zZ:
        goto E4_II;
        goto yKT7J;
        BwIk9:
        if (!$poster["\164\150\x69\x72\144\137\x69\156\x76\151\x74\157\162\137\x73\165\142\x73\143\162\x69\142\x65\137\x74\x69\160"]) {
            goto Z2LTa;
        }
        goto RuW3U;
        DIEDd:
        $inviteUser["\164\157\164\141\x6c\x5f\151\156\x76\151\x74\x65\x5f\x73\143\x6f\x72\145"] += $follow_score;
        goto bYzsb;
        yKT7J:
        AAfrE:
        goto qu9Ng;
        aRwX9:
        $tip .= "\350\x8e\267\345\276\227\347\247\xaf\345\x88\x86\345\xa5\226\xe5\x8a\261{$follow_score}\347\247\xaf\345\210\x86";
        goto JNu06;
        czO9A:
        kW1j1:
        goto qmemp;
        idlqk:
        $this->log($result, "\345\217\x91\xe9\200\201\x33\xe7\xba\247\xe5\xa5\226\xe5\212\xb1\xe9\x80\x9a\347\x9f\245");
        goto C7sBc;
        E27u5:
        Z2LTa:
        goto E0v9v;
        vUvLy:
        $secondUser["\x73\145\143\157\156\144\137\151\x6e\x76\x69\164\x65\x5f\163\x63\x6f\162\145"] = $secondUser["\x73\145\x63\x6f\x6e\x64\x5f\x69\156\166\x69\164\145\x5f\163\143\157\162\x65"] + $second_follow_score;
        goto llw4b;
        R44y_:
        $secondUser["\163\145\143\x6f\x6e\144\137\151\x6e\x76\151\x74\145\137\x6d\x6f\156\145\171"] = $secondUser["\163\145\143\x6f\156\144\x5f\x69\x6e\x76\151\x74\x65\x5f\155\x6f\x6e\x65\x79"] + $second_follow_money;
        goto Sozyr;
        E3F0A:
        $this->log('', "\347\x8e\260\xe9\x87\x91\345\xa5\x96\xe5\212\xb1\346\x88\220\xe5\212\237");
        goto aNCLG;
        USa7T:
        $invite_record = $this->ngsInviteRecordService->scoreSuccess($invite_record);
        goto s9kJp;
        F3rM1:
        $tip = $this->prepareSubscribeToInvitorMessage($poster, $inviteUser, $user);
        goto lzrnR;
        X0ZNo:
        goto MWQ8M;
        goto k9kD9;
        sfHoG:
        $inviteUser = null;
        goto TgBIy;
        GWGQI:
        $inviteUser = $this->selectOne("\x20\141\x6e\144\x20\x69\x6e\x76\x69\x74\145\x5f\x63\x6f\x64\145\x3d{$inviteCode}");
        goto ON8ft;
        eK9th:
        $invite_record = $this->ngsInviteRecordService->scoreSuccess($invite_record);
        goto ue_kd;
        a4zOe:
        v4Dbh:
        goto GWGQI;
        nc4EP:
        if ($inviteCodeType == "\x70\151\144") {
            goto Pdx5b;
        }
        goto P2Seg;
        b8tPk:
        if (!($deep >= 3 && $secondUser["\x70\151\144"] > 0)) {
            goto Dc_xk;
        }
        goto WSyHz;
        FFv0G:
        $this->updateData($secondUser);
        goto PrR7e;
        OYLTi:
        $tip .= "\350\x8e\xb7\xe5\xbe\x97\xe7\x8e\xb0\351\x87\x91\xe5\245\226\xe5\x8a\xb1{$second_follow_money}\345\205\x83";
        goto chZge;
        mJCzQ:
        $this->flashUserService->addUserMoney($follow_money, $inviteUser["\157\160\x65\x6e\x69\144"], "\xe9\x82\200\350\xaf\xb7\133{$user["\156\151\143\153\156\141\155\145"]}\x5d\xe5\205\xb3\346\263\250\344\270\x80\xe7\xba\247\345\245\x96\345\x8a\261");
        goto cdDj3;
        Jfog3:
        $second_follow_money = $poster["\x73\145\x63\x6f\x6e\144\137\x66\x6f\154\x6c\157\167\137\155\157\156\x65\171"];
        goto ea1QX;
        SizkQ:
        $thirdUser["\165\x70\x64\x61\x74\145\137\164\x69\155\x65"] = time();
        goto jKgA0;
        g5zEZ:
        $secondUser = null;
        goto hv60g;
        RANRk:
        $invite_record = $this->ngsInviteRecordService->moneySuccess($invite_record);
        goto U39jU;
        xFYXt:
        lxAPM:
        goto kYxge;
        QejvM:
        $this->ngsInviteRecordService->moneyStart($invite_record, $follow_money);
        goto s2b_t;
        Wykj6:
        $this->flashUserService->addUserMoney($second_follow_money, $secondUser["\157\160\145\156\151\x64"], "\344\270\213\347\272\247\133{$inviteUser["\x6e\151\143\x6b\x6e\141\155\x65"]}\x5d\351\202\x80\xe8\257\xb7\345\205\263\346\xb3\250\344\272\x8c\347\xba\xa7\345\xa5\x96\345\x8a\261");
        goto p6DTr;
        axZ9a:
        $tip = "\xe6\201\255\xe5\226\x9c\xe6\202\xa8\xe7\232\x84\344\xb8\x8b\347\272\247\133{$inviteUser["\x6e\151\x63\153\156\141\155\145"]}\135\xe9\x82\200\xe8\xaf\267\347\224\xa8\346\x88\xb7\133{$user["\156\151\x63\x6b\156\141\155\x65"]}\135\345\205\263\346\263\xa8";
        goto eG14c;
        dqsVh:
        global $_W;
        goto rkPoL;
        RmHGH:
        if (!($inviteUser["\x62\x6c\x61\x63\153"] == 1)) {
            goto I7fp4;
        }
        goto WUe0r;
        bl93i:
        $inviteUser["\151\x6e\x76\x69\164\x65\x5f\x73\143\157\162\145"] = $inviteUser["\151\156\x76\151\x74\x65\x5f\163\143\x6f\162\145"] + $follow_score;
        goto DIEDd;
        qu9Ng:
        $this->ngsInviteRecordService->scoreStart($invite_record, $follow_score);
        goto A0dqn;
        ClIrJ:
        $tip = "\346\201\255\345\x96\234\xe6\202\xa8\xe9\x97\xb4\346\216\xa5\xe9\202\200\xe8\xaf\267\xe7\x94\xa8\346\x88\267\133{$user["\x6e\x69\143\x6b\x6e\141\x6d\x65"]}\135\xe5\205\xb3\xe6\263\250";
        goto vG_2B;
        s2b_t:
        $inviteUser["\x69\156\166\x69\164\x65\137\155\x6f\156\x65\171"] = $inviteUser["\151\x6e\166\151\x74\x65\x5f\155\157\156\x65\171"] + $follow_money;
        goto LOgjy;
        RKZZ1:
        $inviteUser["\164\157\x74\x61\x6c\x5f\151\156\166\x69\x74\x65\137\x73\x63\x6f\x72\145"] += $follow_score;
        goto HZZbY;
        WUe0r:
        $this->log($inviteUser, "\xe9\202\x80\xe8\xaf\267\xe4\272\xba\xe5\267\262\xe7\xbb\x8f\350\242\xab\346\x8b\x89\345\205\245\351\xbb\221\345\x90\x8d\345\x8d\x95\357\274\x8c\344\270\x8d\xe8\277\233\xe8\241\x8c\xe6\266\211\xe5\217\x8a\xe5\210\260\xe7\232\x84\346\211\x80\xe6\x9c\x89\347\272\247\345\x88\253\xe5\xa5\226\xe5\x8a\261");
        goto tcogn;
        DIXdU:
        $this->flashUserService->addUserMoney($second_follow_money, $secondUser["\157\x70\145\x6e\x69\144"], "\344\270\213\347\272\xa7\x5b{$inviteUser["\x6e\151\143\x6b\x6e\x61\155\x65"]}\135\xe9\x82\x80\xe8\257\xb7\xe5\x85\xb3\xe6\xb3\250\344\272\x8c\xe7\xba\247\345\xa5\x96\xe5\212\xb1");
        goto z0krU;
        Auzpm:
        goto E4_II;
        goto BG4AZ;
        DZkTq:
        j57VM:
        goto fefUQ;
        SNq0t:
        $third_follow_score = $poster["\x74\x68\x69\162\x64\x5f\146\x6f\154\154\x6f\x77\x5f\163\x63\157\x72\x65"];
        goto Vm94e;
        m8Bxd:
        $this->updateData($inviteUser);
        goto W7lb3;
        uqS4V:
        if (!($deep >= 1)) {
            goto Dtw_c;
        }
        goto IVrtG;
        RuW3U:
        $tip = $this->prepareSubscribeToInvitorMessage($poster, $inviteUser, $user, 3);
        goto E27u5;
        PwBIe:
        $follow_score = $poster["\146\x6f\x6c\154\157\x77\137\x73\143\157\x72\145"];
        goto aBiso;
        lbd07:
    }
    public function startPosting($openid)
    {
        global $_W;
        pdo_update($this->table_name, array("\x69\x6e\137\x70\157\163\x74\x69\x6e\147" => NGSUserService::POSTER_POSTING), array("\x6f\x70\x65\x6e\x69\144" => $openid, "\165\x6e\x69\x61\x63\151\x64" => $_W["\x75\x6e\151\141\143\x69\x64"]));
    }
    public function endPosting($openid)
    {
        global $_W;
        pdo_update($this->table_name, array("\x69\x6e\137\x70\157\x73\164\x69\x6e\x67" => NGSUserService::POSTER_FREE), array("\157\160\x65\x6e\x69\144" => $openid, "\165\156\x69\x61\143\151\144" => $_W["\165\x6e\151\x61\143\x69\x64"]));
    }
    public function updateLastPosterTime($openid)
    {
        global $_W;
        pdo_update($this->table_name, array("\160\157\163\x74\145\162\137\165\160\x64\141\164\145\x5f\x74\x69\x6d\145" => time()), array("\157\x70\145\x6e\x69\144" => $openid, "\x75\x6e\x69\x61\143\151\144" => $_W["\165\x6e\151\141\x63\151\x64"]));
    }
    public function orderChargeShareUser($shareUserId, $order, $good)
    {
        goto a7oxw;
        iPmsk:
        $recharge_text .= "{$order["\x73\x68\141\162\145\137\x61\155\157\165\156\x74"]}\345\x85\x83";
        goto l6eV6;
        pULjg:
        AlVsu:
        goto HVTO3;
        fjq0Z:
        JyZho:
        goto QmRy7;
        u6Ysj:
        $recharge = true;
        goto NtQHW;
        GZj1w:
        W0HjY:
        goto FxtLZ;
        QV9Sh:
        $recharge_text = '';
        goto ksoi3;
        SxALv:
        G24Kv:
        goto tMKjm;
        oJKNA:
        exS5u:
        goto oIDbI;
        a7oxw:
        $user = $this->selectById($shareUserId);
        goto NfJC_;
        cJxpR:
        $this->sendTextMessage($user["\157\x70\x65\x6e\151\144"], $message);
        goto GZj1w;
        NfJC_:
        if (!empty($user)) {
            goto AlVsu;
        }
        goto fbAS2;
        t90VJ:
        if (!($recharge == true)) {
            goto W0HjY;
        }
        goto QV9Sh;
        FTAq5:
        $recharge_text .= "{$order["\x73\150\141\162\145\137\155\157\x6e\x65\171"]}\345\205\203\xe5\222\x8c{$order["\163\x68\x61\162\x65\137\x73\143\x6f\162\x65"]}\xe7\xa7\xaf\xe5\x88\x86";
        goto oJKNA;
        ksoi3:
        if ($order["\x73\150\141\x72\x65\137\155\157\x6e\x65\x79"] > 0 && $order["\163\x68\141\x72\x65\x5f\x73\143\157\x72\145"] > 0) {
            goto hUqlw;
        }
        goto On_NK;
        KE4sV:
        if (!($order["\163\x68\141\x72\x65\137\x61\155\x6f\x75\156\x74"] > 0)) {
            goto G24Kv;
        }
        goto sNU4d;
        HVTO3:
        $recharge = false;
        goto KE4sV;
        NtQHW:
        m1t9G:
        goto t90VJ;
        sNU4d:
        $this->flashUserService->addUserMoney($order["\163\150\x61\162\145\137\141\x6d\157\x75\156\x74"], $user["\157\160\x65\x6e\x69\x64"], "{$order["\156\x69\x63\153\x6e\141\x6d\x65"]}\xe9\200\x9a\xe8\xbf\207\345\x88\x86\xe4\xba\xab\351\x93\xbe\xe6\x8e\245\350\xb4\255\344\271\260\345\245\226\345\x8a\xb1");
        goto LdvuT;
        LdvuT:
        $recharge = true;
        goto SxALv;
        ixZRg:
        hUqlw:
        goto FTAq5;
        QmRy7:
        goto exS5u;
        goto ixZRg;
        fZzCv:
        $this->flashUserService->addUserScore($order["\163\x68\x61\162\x65\137\163\143\157\162\145"], $user["\x6f\160\145\156\x69\144"], "{$order["\156\x69\x63\153\156\141\x6d\x65"]}\xe9\x80\x9a\xe8\277\x87\xe5\x88\x86\xe4\272\xab\351\x93\276\xe6\x8e\245\xe8\xb4\xad\xe4\xb9\260\345\245\x96\345\212\261");
        goto u6Ysj;
        l6eV6:
        y4DaN:
        goto d3n0H;
        d3n0H:
        if (!($order["\x73\150\141\162\145\137\x73\143\x6f\162\x65"] > 0)) {
            goto JyZho;
        }
        goto qrhLN;
        qrhLN:
        $recharge_text .= "{$order["\x73\150\141\x72\x65\x5f\x73\143\157\x72\145"]}\xe7\247\xaf\345\210\x86";
        goto fjq0Z;
        fbAS2:
        return false;
        goto pULjg;
        tMKjm:
        if (!($order["\x73\150\141\162\x65\137\163\143\x6f\x72\x65"] > 0)) {
            goto m1t9G;
        }
        goto fZzCv;
        On_NK:
        if (!($order["\163\150\141\x72\x65\137\x61\155\x6f\x75\x6e\164"] > 0)) {
            goto y4DaN;
        }
        goto iPmsk;
        oIDbI:
        $message = "{$order["\156\x69\x63\x6b\x6e\141\x6d\x65"]}\xe9\200\232\350\277\x87\xe6\x82\250\xe5\x88\206\344\272\xab\347\x9a\204\351\x93\276\xe6\216\xa5\xe8\264\xad\344\xb9\260\xe4\xba\x86\x5b{$good["\164\x69\x74\x6c\145"]}\x5d\54\347\263\xbb\347\273\237\345\245\226\345\212\261\xe6\202\xa8{$recharge_text}\41";
        goto cJxpR;
        FxtLZ:
    }
    public function orderChargeInviteUser($inviteUserId, $order, $good)
    {
    }
    public function invitedUsers($userId)
    {
        goto WdipK;
        FJBGz:
        $invited["\154\145\x76\145\154\137\x31"] = $this->directlyInvitedById($userId);
        goto WXrNX;
        iWRAb:
        if (!($invited["\154\145\x76\x65\x6c\137\x32"] != null && !empty($invited["\154\145\x76\145\x6c\137\62"]))) {
            goto OGJeL;
        }
        goto K4GdT;
        K4GdT:
        $invited["\x6c\145\166\145\x6c\x5f\x33"] = $this->directlyInvitedByUsers($invited["\154\x65\x76\145\154\x5f\x32"]);
        goto tCwe3;
        oeU5i:
        KIyio:
        goto iWRAb;
        tCwe3:
        OGJeL:
        goto OQ4N_;
        WXrNX:
        if (!($invited["\x6c\x65\x76\x65\x6c\x5f\x31"] != null && !empty($invited["\154\x65\166\x65\154\x5f\61"]))) {
            goto KIyio;
        }
        goto dN1AA;
        OQ4N_:
        return $invited;
        goto p1FBK;
        WdipK:
        $invited = array();
        goto FJBGz;
        dN1AA:
        $invited["\154\145\x76\x65\x6c\x5f\x32"] = $this->directlyInvitedByUsers($invited["\154\145\x76\x65\154\x5f\x31"]);
        goto oeU5i;
        p1FBK:
    }
    private function directlyInvitedById($parentId)
    {
        $where = "\40\101\116\104\40\160\151\144\x20\75\x20" . $parentId . "\x20";
        return $this->selectAll($where);
    }
    private function directlyInvitedByUsers($parents)
    {
        $parent_ids = array_map(function ($parent) {
            return $parent["\151\x64"];
        }, $parents);
        return $this->selectAllIn("\x70\x69\x64", $parent_ids, "\40\x6f\162\144\x65\162\40\142\171\x20\x63\x72\145\x61\164\x65\x5f\x74\x69\155\x65\x20\x44\x45\x53\103\40");
    }
    private function prepareSubscribeToInvitorMessage($poster, $invitorUser, $user, $level = 1)
    {
        goto n1Rl5;
        KuRnU:
        if ($level == 2) {
            goto oXxyj;
        }
        goto peFfF;
        QX8Kx:
        return $baseTip;
        goto dteCr;
        peFfF:
        if ($level == 3) {
            goto hsI6a;
        }
        goto jTnii;
        WRnBf:
        $baseTip = str_replace("\x23\x7b\x72\x65\167\141\162\144\x5f\163\x63\157\x72\x65\175\x23", $poster["\x74\x68\151\162\144\137\146\157\154\x6c\x6f\x77\137\x73\143\x6f\162\145"], $baseTip);
        goto TT9Mw;
        TT9Mw:
        $baseTip = str_replace("\43\173\162\145\167\x61\x72\x64\137\141\x6d\157\x75\x6e\164\x7d\43", $poster["\164\150\151\x72\x64\137\x66\x6f\154\154\157\167\137\155\157\x6e\145\x79"], $baseTip);
        goto hUSG5;
        NY2TT:
        return $baseTip;
        goto NX7Xu;
        jTnii:
        goto bqTQ0;
        goto S352z;
        W9ym7:
        if ($level == 1) {
            goto VK6X0;
        }
        goto KuRnU;
        gcgtP:
        hsI6a:
        goto K0XsL;
        QKfEL:
        $baseTip = str_replace("\43\173\x72\x65\x77\x61\x72\144\x5f\x73\x63\157\162\145\175\x23", $poster["\163\x65\x63\157\156\x64\137\x66\x6f\x6c\154\x6f\x77\137\163\143\x6f\x72\145"], $baseTip);
        goto cFKR3;
        giHu0:
        bqTQ0:
        goto kdAqw;
        NX7Xu:
        goto bqTQ0;
        goto gcgtP;
        n1Rl5:
        $baseTip = $poster["\151\156\166\x69\x74\x6f\x72\x5f\x73\x75\x62\x73\143\x72\151\x62\x65\137\164\151\160"];
        goto W9ym7;
        hUSG5:
        return $baseTip;
        goto giHu0;
        eU8yz:
        $baseTip = str_replace("\x23\173\x69\156\166\x69\x74\x65\x5f\165\x73\145\162\x5f\x6e\141\155\x65\175\x23", $invitorUser["\x6e\151\143\x6b\156\141\x6d\x65"], $baseTip);
        goto eaLUW;
        ido6p:
        $baseTip = str_replace("\43\173\162\145\x77\x61\x72\x64\x5f\x73\143\157\162\x65\175\43", $poster["\146\x6f\154\x6c\157\167\137\x73\143\157\x72\x65"], $baseTip);
        goto lm46D;
        Te052:
        oXxyj:
        goto TIuXA;
        eaLUW:
        $baseTip = str_replace("\x23\173\156\151\143\x6b\x6e\x61\155\145\175\x23", $user["\156\151\x63\153\156\x61\x6d\x65"], $baseTip);
        goto QKfEL;
        ydbrE:
        $baseTip = str_replace("\43\173\x69\x6e\166\151\164\x65\137\x75\x73\145\x72\137\156\x61\x6d\x65\x7d\43", $invitorUser["\156\151\x63\153\x6e\141\x6d\145"], $baseTip);
        goto Hqyqh;
        Hqyqh:
        $baseTip = str_replace("\x23\x7b\156\151\x63\x6b\x6e\x61\155\x65\175\43", $user["\x6e\151\x63\x6b\156\x61\x6d\x65"], $baseTip);
        goto WRnBf;
        TIuXA:
        $baseTip = $poster["\163\145\143\157\x6e\x64\x5f\x69\156\166\x69\x74\157\162\x5f\x73\x75\x62\x73\143\x72\x69\x62\x65\137\x74\151\160"];
        goto eU8yz;
        cFKR3:
        $baseTip = str_replace("\x23\x7b\162\x65\x77\x61\162\x64\x5f\x61\x6d\157\165\x6e\x74\175\43", $poster["\x73\x65\x63\157\x6e\144\x5f\146\157\154\x6c\157\167\x5f\x6d\x6f\156\145\171"], $baseTip);
        goto NY2TT;
        lm46D:
        $baseTip = str_replace("\x23\173\162\145\167\x61\162\x64\137\141\155\x6f\165\156\x74\x7d\43", $poster["\x66\x6f\x6c\154\157\x77\137\x6d\x6f\x6e\x65\x79"], $baseTip);
        goto QX8Kx;
        K0XsL:
        $baseTip = $poster["\x74\x68\151\x72\144\137\x69\156\164\x69\166\164\x6f\162\137\x73\x75\142\x73\x63\x72\x69\x62\x65\137\164\x69\160"];
        goto ydbrE;
        ARGwI:
        $baseTip = str_replace("\43\x7b\x6e\x69\x63\153\156\141\x6d\145\x7d\43", $user["\x6e\x69\x63\x6b\x6e\x61\155\x65"], $baseTip);
        goto ido6p;
        aBvE1:
        $baseTip = str_replace("\x23\x7b\151\156\166\x69\x74\x65\137\x75\x73\x65\162\x5f\156\x61\155\145\x7d\x23", $invitorUser["\156\151\143\153\156\x61\x6d\145"], $baseTip);
        goto ARGwI;
        dteCr:
        goto bqTQ0;
        goto Te052;
        S352z:
        VK6X0:
        goto aBvE1;
        kdAqw:
    }
    private function prepareUnSubscribeToInvitorMessage($poster, $invitorUser, $user, $level = 1)
    {
        goto Ba1NJ;
        FY_j2:
        ZdLAi:
        goto YhfEe;
        vMrab:
        jcxzm:
        goto zkJoZ;
        PPxgZ:
        $baseTip = str_replace("\43\173\151\x6e\x76\x69\x74\x65\137\x75\163\145\162\137\x6e\x61\x6d\145\175\43", $invitorUser["\x6e\151\x63\153\156\x61\x6d\x65"], $baseTip);
        goto WRV3G;
        YhfEe:
        $baseTip = $poster["\x74\x68\151\x72\x64\x5f\151\x6e\x74\x69\x76\164\x6f\x72\137\165\x6e\163\x75\x62\x73\143\162\x69\x62\145\137\164\x69\x70"];
        goto PPxgZ;
        mSFTT:
        $baseTip = str_replace("\43\173\x72\145\x77\141\x72\x64\137\x73\143\x6f\x72\x65\x7d\43", $poster["\x73\145\x63\157\x6e\144\137\165\x6e\146\x6f\x6c\154\157\167\137\163\x63\x6f\162\145"], $baseTip);
        goto jGcI5;
        zkJoZ:
        $baseTip = str_replace("\x23\x7b\151\x6e\x76\x69\x74\x65\137\x75\163\x65\x72\137\x6e\x61\x6d\145\175\43", $invitorUser["\x6e\151\143\153\x6e\x61\155\x65"], $baseTip);
        goto vC8uG;
        x9i27:
        $baseTip = str_replace("\x23\x7b\x72\x65\167\141\162\x64\x5f\x73\x63\157\x72\145\175\x23", $poster["\x74\x68\x69\x72\x64\x5f\165\x6e\x66\157\154\x6c\157\x77\137\163\143\x6f\x72\145"], $baseTip);
        goto drhvP;
        pGJ3n:
        if ($level == 2) {
            goto bvYqc;
        }
        goto q5paK;
        FWHHO:
        return $baseTip;
        goto ikylY;
        jGcI5:
        $baseTip = str_replace("\x23\173\x72\145\x77\x61\x72\x64\x5f\x61\155\157\x75\x6e\x74\x7d\x23", $poster["\x73\x65\143\x6f\156\144\x5f\x75\x6e\146\157\154\x6c\157\167\x5f\x6d\x6f\x6e\x65\171"], $baseTip);
        goto gH4mw;
        p6mwG:
        if ($level == 1) {
            goto jcxzm;
        }
        goto pGJ3n;
        fe_P3:
        $baseTip = str_replace("\43\173\x72\145\167\141\162\x64\x5f\x73\143\x6f\x72\x65\x7d\43", $poster["\x75\156\146\157\x6c\x6c\157\167\x5f\x73\x63\157\x72\x65"], $baseTip);
        goto kPCx4;
        D2RhW:
        goto EnKnR;
        goto vMrab;
        vC8uG:
        $baseTip = str_replace("\x23\173\156\151\x63\153\x6e\x61\x6d\x65\x7d\x23", $user["\x6e\x69\143\x6b\x6e\x61\x6d\145"], $baseTip);
        goto fe_P3;
        kPCx4:
        $baseTip = str_replace("\43\x7b\162\x65\x77\141\x72\x64\137\141\155\x6f\x75\x6e\164\x7d\43", $poster["\165\156\x66\157\x6c\154\x6f\167\x5f\155\x6f\156\145\171"], $baseTip);
        goto FWHHO;
        gH4mw:
        return $baseTip;
        goto JhV7R;
        V0g7v:
        bvYqc:
        goto OqJBj;
        drhvP:
        $baseTip = str_replace("\43\173\162\145\x77\x61\x72\x64\x5f\141\155\157\165\x6e\x74\175\x23", $poster["\x74\150\151\162\144\x5f\165\x6e\146\x6f\154\154\x6f\167\x5f\x6d\157\x6e\x65\171"], $baseTip);
        goto iqux_;
        dmoLy:
        EnKnR:
        goto W3Qnt;
        JhV7R:
        goto EnKnR;
        goto FY_j2;
        q5paK:
        if ($level == 3) {
            goto ZdLAi;
        }
        goto D2RhW;
        ZfAMB:
        $this->log(null, "\345\217\226\xe6\xb6\210\xe5\205\263\xe6\263\xa8\346\x8f\x90\xe7\xa4\272\344\270\272" . $baseTip);
        goto p6mwG;
        vN0Mc:
        $baseTip = str_replace("\43\x7b\156\151\143\x6b\156\x61\155\x65\x7d\x23", $user["\x6e\151\x63\153\156\141\155\145"], $baseTip);
        goto mSFTT;
        iqux_:
        return $baseTip;
        goto dmoLy;
        WRV3G:
        $baseTip = str_replace("\43\173\x6e\x69\143\x6b\156\141\x6d\x65\x7d\x23", $user["\156\151\x63\153\x6e\141\155\145"], $baseTip);
        goto x9i27;
        av6nm:
        $baseTip = str_replace("\x23\x7b\x69\156\166\x69\164\x65\137\165\163\x65\162\137\156\x61\x6d\145\x7d\x23", $invitorUser["\156\151\x63\153\x6e\141\155\x65"], $baseTip);
        goto vN0Mc;
        ikylY:
        goto EnKnR;
        goto V0g7v;
        OqJBj:
        $baseTip = $poster["\163\145\x63\x6f\x6e\144\137\x69\156\166\151\x74\x6f\162\x5f\x75\156\163\x75\x62\163\143\x72\151\x62\x65\x5f\164\151\160"];
        goto av6nm;
        Ba1NJ:
        $baseTip = $poster["\151\x6e\x76\151\164\x6f\x72\x5f\165\x6e\x73\165\142\x73\x63\162\x69\x62\145\137\x74\x69\160"];
        goto ZfAMB;
        W3Qnt:
    }
}
