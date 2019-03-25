<?php
/*
 __________________________________________________
|  Encode by BajieTeam on we7                      |
|__________________________________________________|
*/

goto aDYIs;
EfyZP:
require_once dirname(__FILE__) . "\x2f\154\151\x62\57\120\x6f\163\x74\x65\162\x48\x61\x6e\144\x6c\145\162\56\160\x68\x70";
goto aqhMe;
C39dd:
require_once dirname(__FILE__) . "\x2f\143\x6c\x61\163\x73\57\155\x65\x6e\165\57\x4e\x47\x53\115\x65\x6e\x75\x53\x65\x72\x76\151\143\x65\56\160\x68\x70";
goto YloBv;
Plmx1:
function emojiFilter($nickname)
{
    goto u_XNF;
    T0m4Z:
    return $text;
    goto bWGbi;
    RLhNO:
    $tmpStr = preg_replace("\43\x28\134\134\165\144\133\x30\x2d\71\x61\x2d\146\135\173\63\x7d\x29\174\50\134\134\165\x65\x5b\x30\x2d\x39\x61\55\x66\135\173\63\175\x29\x23\x69\x65", '', $tmpStr);
    goto Y1bgm;
    Y1bgm:
    $text = json_decode($tmpStr, true);
    goto T0m4Z;
    u_XNF:
    $tmpStr = json_encode($nickname);
    goto RLhNO;
    bWGbi:
}
goto o1swi;
c9eQ_:
require_once dirname(__FILE__) . "\57\143\x6c\141\163\163\57\161\x75\x61\x6e\57\116\107\123\121\165\x61\x6e\123\x65\x72\x76\x69\143\145\x2e\x70\x68\x70";
goto BgjzD;
qPmvC:
require_once dirname(__FILE__) . "\57\56\x2e\x2f\x6c\157\156\141\x6b\x69\156\147\137\146\154\141\163\150\x2f\106\x6c\141\x73\150\125\163\x65\162\123\x65\162\166\151\143\x65\56\x70\150\x70";
goto CI2mo;
S5W8p:
require_once dirname(__FILE__) . "\57\x2e\x2e\x2f\x6c\x6f\x6e\x61\153\151\156\147\137\x66\154\x61\163\x68\x2f\x75\x74\x69\x6c\x73\x2f\x46\x6c\x61\163\x68\x48\x65\x6c\x70\x65\x72\x2e\160\150\x70";
goto qPmvC;
axxjm:
require_once dirname(__FILE__) . "\57\x63\x6c\x61\163\163\57\164\160\x6c\x2f\x4e\107\x53\124\x70\154\x53\145\162\166\151\x63\145\x2e\160\x68\x70";
goto EfyZP;
Gdz2H:
function jf_uuid()
{
    goto b4AN1;
    Uep51:
    $uuid = '' . substr($charid, 0, 8) . $hyphen . substr($charid, 8, 4) . $hyphen . substr($charid, 12, 4) . $hyphen . substr($charid, 16, 4) . $hyphen . substr($charid, 20, 12);
    goto MbbHx;
    ZNeOE:
    K0qen:
    goto cC1hP;
    MbbHx:
    return $uuid;
    goto XUAnE;
    b4AN1:
    if (function_exists("\x63\157\x6d\137\x63\x72\x65\141\x74\x65\137\x67\x75\x69\144")) {
        goto K0qen;
    }
    goto ZMGWT;
    lSPVj:
    qLc6C:
    goto bGUb0;
    LYCxX:
    $hyphen = chr(45);
    goto Uep51;
    ZMGWT:
    mt_srand((double) microtime() * 10000);
    goto VUiUV;
    cC1hP:
    return com_create_guid();
    goto lSPVj;
    XUAnE:
    goto qLc6C;
    goto ZNeOE;
    VUiUV:
    $charid = strtoupper(md5(uniqid(rand(), true)));
    goto LYCxX;
    bGUb0:
}
goto EwPy3;
EwPy3:
function is_local_resource($resource)
{
    goto bIKX_;
    lsz_m:
    return false;
    goto IZi5r;
    h2ZkY:
    return false;
    goto B3vap;
    K2i9u:
    return true;
    goto GGJhZ;
    B3vap:
    fWFvt:
    goto DIZTu;
    bIKX_:
    if (!(trim($resource) == '')) {
        goto Vam_m;
    }
    goto lsz_m;
    Ubxgq:
    if (trim(substr($resource, 0, 4)) == "\x68\x74\x74\x70") {
        goto aFukj;
    }
    goto K2i9u;
    IZi5r:
    Vam_m:
    goto Ubxgq;
    oAtW7:
    aFukj:
    goto h2ZkY;
    GGJhZ:
    goto fWFvt;
    goto oAtW7;
    DIZTu:
}
goto Plmx1;
CI2mo:
require_once dirname(__FILE__) . "\57\143\x6c\141\x73\163\x2f\147\162\157\x75\x70\57\116\107\x53\107\162\x6f\x75\x70\123\x65\x72\x76\x69\143\145\x2e\x70\150\x70";
goto C39dd;
mALYn:
require_once dirname(__FILE__) . "\57\x63\154\x61\163\x73\x2f\150\x62\57\116\107\x53\110\x62\123\x65\162\166\x69\143\145\56\x70\x68\160";
goto WQHuF;
BgjzD:
require_once dirname(__FILE__) . "\57\143\x6c\141\x73\x73\x2f\141\x64\x64\162\145\163\163\57\x4e\x47\123\x41\144\x64\162\x65\163\x73\x53\145\162\166\151\143\145\56\x70\x68\160";
goto mALYn;
qKmPv:
require_once dirname(__FILE__) . "\57\143\x6c\141\163\163\57\x75\163\x65\x72\x2f\116\x47\123\125\x73\145\x72\x53\x65\x72\x76\151\143\x65\x2e\x70\x68\160";
goto sdXjr;
vQFj8:
require_once dirname(__FILE__) . "\57\x63\154\x61\163\163\x2f\157\162\x64\x65\162\x2f\x4e\x47\123\x4f\x72\x64\145\x72\123\145\x72\166\151\x63\x65\56\160\x68\160";
goto c9eQ_;
sdXjr:
require_once dirname(__FILE__) . "\x2f\143\154\x61\x73\163\x2f\x69\156\x76\x69\x74\x65\57\x4e\107\123\111\156\166\x69\164\x65\122\145\x63\x6f\162\x64\x53\x65\162\166\151\x63\145\56\160\150\160";
goto vQFj8;
aqhMe:
class Lonaking_new_gift_shopModuleSite extends WeModuleSite
{
    private $groupService;
    private $menuService;
    private $giftService;
    private $giftImageService;
    private $adService;
    private $userService;
    private $inviteRecordService;
    private $orderService;
    private $quanService;
    private $addressService;
    private $HBService;
    private $posterService;
    private $noticeService;
    private $flashUserService;
    public function __construct()
    {
        goto noB_1;
        noB_1:
        $this->groupService = new NGSGroupService();
        goto ZnNKX;
        GTtbe:
        $this->inviteRecordService = new NGSInviteRecordService();
        goto Wa2zl;
        khIRS:
        $this->userService = new NGSUserService();
        goto GTtbe;
        vwz_x:
        $this->menuService = new NGSMenuService();
        goto MOxgz;
        g9KBf:
        $this->quanService = new NGSQuanService();
        goto JyU9f;
        MOxgz:
        $this->adService = new NGSAdService();
        goto khIRS;
        ZnNKX:
        $this->giftService = new NGSGiftService();
        goto Wqc8_;
        Wa2zl:
        $this->orderService = new NGSOrderService();
        goto g9KBf;
        JyU9f:
        $this->addressService = new NGSAddressService();
        goto YAi2G;
        YAi2G:
        $this->HBService = new NGSHbService();
        goto fACBL;
        Wqc8_:
        $this->giftImageService = new NGSGiftImageService();
        goto vwz_x;
        r7bJ1:
        $this->noticeService = new NGSTplService();
        goto q1fJ1;
        q1fJ1:
        $this->flashUserService = new FlashUserService();
        goto TczVE;
        fACBL:
        $this->posterService = new NGSPosterService();
        goto r7bJ1;
        TczVE:
    }
    /**
     * delete everything
     */
    public function doWebHardRemove()
    {
        goto ke61k;
        uBR4x:
        if (!empty($opt)) {
            goto RNMVv;
        }
        goto lseOB;
        ke61k:
        global $_W, $_GPC;
        goto RQy4p;
        lseOB:
        return $this->returnJson(400, "\346\234\252\346\217\220\344\xbe\233\xe6\xad\244\345\x8a\237\xe8\203\275\x2c\350\257\267\350\x81\x94\xe7\xb3\273\xe5\274\x80\xe5\x8f\x91\350\x80\205", null);
        goto JufgD;
        gd13O:
        $opt = $_GPC["\x6f\160\164"];
        goto uBR4x;
        jvXT3:
        try {
            goto PhG8z;
            qSEnK:
            return $this->returnJson(null);
            goto NcM4Q;
            rUp9W:
            PVa32:
            goto qSEnK;
            dOA7Z:
            Hqgn5:
            goto rUp9W;
            PhG8z:
            switch ($opt) {
                case "\155\x65\156\x75":
                    $this->menuService->deleteById($id);
                    goto PVa32;
                case "\147\151\x66\164":
                    $this->giftService->deleteById($id);
                    goto PVa32;
                case "\147\162\x6f\x75\160":
                    $this->groupService->deleteById($id);
                    goto PVa32;
                case "\x61\x64":
                    $this->adService->deleteById($id);
                    goto PVa32;
                case "\161\x75\141\x6e":
                    $this->quanService->deleteById($id);
                    goto PVa32;
                case "\x75\163\x65\162":
                    $this->userService->deleteById($id);
                    goto PVa32;
                default:
                    throw new Exception("\xe4\270\215\346\x94\xaf\346\x8c\201\347\x9a\x84\346\223\215\344\xbd\234\347\xb1\273\345\x9e\213\xef\274\214\350\xaf\267\xe8\x81\x94\347\263\xbb\xe5\xbc\200\345\x8f\x91\xe8\x80\x85", 400);
            }
            goto dOA7Z;
            NcM4Q:
        } catch (Exception $e) {
            return $this->returnJson(null, $e->getCode(), $e->getMessage());
        }
        goto cmqBI;
        RQy4p:
        $id = $_GPC["\x69\144"];
        goto gd13O;
        JufgD:
        RNMVv:
        goto jvXT3;
        cmqBI:
    }
    public function doMobileIndex()
    {
        goto v3FfJ;
        Xfa5I:
        if (!($mode == 2)) {
            goto pFyZy;
        }
        goto cEAec;
        RdBjb:
        $appkey = $this->module["\x63\157\x6e\146\x69\x67"]["\144\165\x69\142\141\137\153\x65\x79"];
        goto rMRU5;
        wEta_:
        $url = buildCreditAutoLoginRequest($appkey, $secret, $user["\151\x64"], intval($credits));
        goto Te3Nd;
        rMRU5:
        $secret = $this->module["\x63\157\156\x66\151\147"]["\144\165\151\x62\141\x5f\x73\145\143\162\x65\164"];
        goto xLiVS;
        Te3Nd:
        header("\x4c\157\143\x61\x74\x69\157\156\72\x20" . $url);
        goto doaZW;
        uBrJZ:
        $html = array("\x61\x64\x73" => $ads, "\x6d\145\x6e\165\163" => $menus, "\147\151\x66\164\163" => $gifts, "\150\145\x6e\147\137\x67\x69\x66\164\x73" => $hengs, "\x75\163\x65\x72" => $user, "\143\157\x6e\146\151\147" => $this->module["\143\157\x6e\x66\x69\147"], "\152\163\143\x6f\x6e\x66\151\147" => $_W["\141\143\x63\x6f\x75\x6e\164"]["\152\x73\x73\144\153\x63\x6f\156\x66\x69\x67"], "\x74\x61\142\163" => $tabs);
        goto l0yrT;
        d6Abe:
        $this->adService->log($gifts, "\xe6\237\245\345\207\xba\xe6\211\200\346\234\211\xe7\232\x84\347\244\xbc\xe5\223\x81");
        goto eJI5W;
        X4snQ:
        $gifts = $this->giftService->selectAllOrderBy("\x20\141\x6e\x64\x20\x68\x69\x64\145\75\x30", "\162\141\x6e\153\40\x44\105\123\103\54");
        goto d6Abe;
        YG9Zo:
        $user = $this->userService->getUserInfo($_W["\157\160\x65\x6e\x69\x64"]);
        goto Xfa5I;
        IOkxY:
        $tabs = $this->menuService->getAllTabMenus();
        goto X4snQ;
        qqH8M:
        return message("\350\xaf\xb7\345\234\250\xe5\xbe\xae\xe4\xbf\241\346\xb5\217\350\xa7\x88\345\x99\250\344\270\xad\xe6\x89\x93\xe5\xbc\x80", '', "\x65\x72\162\x6f\162");
        goto YvVFz;
        l0yrT:
        $resource = $this->htmlStatic();
        goto ayMxL;
        eJI5W:
        $hengs = $this->giftService->selectAll("\40\141\156\x64\40\x68\151\x64\145\x3d\x30\x20\x61\156\144\x20\x76\151\x65\167\x5f\x74\171\x70\145\x3d\x32");
        goto L4Gud;
        qZoDE:
        $mode = $this->module["\x63\x6f\156\146\151\x67"]["\x6d\157\x64\145"];
        goto YG9Zo;
        doaZW:
        die;
        goto YefBf;
        xLiVS:
        $credits = $this->flashUserService->fetchUserScore($user["\157\160\145\x6e\x69\144"]);
        goto wEta_;
        L4Gud:
        $share = array("\x73\150\x61\162\x65\x5f\164\x69\x74\x6c\x65" => $this->module["\x63\157\156\146\151\x67"]["\x73\150\x61\x72\x65\x5f\x74\x69\x74\x6c\x65"], "\x73\150\141\x72\x65\x5f\x6c\x6f\x67\157" => tomedia($this->module["\x63\x6f\156\146\151\x67"]["\x73\150\x61\162\x65\x5f\x6c\x6f\147\157"]), "\x73\x68\141\162\145\137\x75\x72\154" => empty($this->module["\143\x6f\156\x66\x69\x67"]["\x73\x68\x61\x72\x65\x5f\x75\x72\154"]) ? $_W["\163\151\164\x65\x72\157\x6f\164"] . "\141\160\160" . substr($this->createMobileUrl("\111\x6e\x64\145\x78"), 1) : $this->module["\x63\157\x6e\146\151\147"]["\x73\x68\141\162\x65\x5f\x75\162\x6c"], "\x73\150\141\162\145\137\x64\x65\x73\143\x72\x69\160\x74\151\x6f\156" => $this->module["\x63\157\x6e\x66\x69\x67"]["\163\x68\x61\162\x65\x5f\x64\145\x73\143\162\151\x70\x74\151\157\x6e"]);
        goto uBrJZ;
        ga6DE:
        $menus = $this->menuService->getAllHomeMenus();
        goto IOkxY;
        ayMxL:
        $template = empty($this->module["\143\x6f\x6e\x66\151\x67"]["\x74\145\x6d\160\x6c\x61\x74\x65"]) ? "\x69\156\144\x65\170" : $this->module["\143\x6f\156\x66\151\x67"]["\x74\x65\x6d\160\154\141\x74\x65"];
        goto iJYqx;
        v3FfJ:
        global $_W, $_GPC;
        goto GDRN6;
        cEAec:
        require_once "\154\x69\x62\57\x44\165\x69\x62\x61\x53\x44\x4b\56\x70\x68\x70";
        goto RdBjb;
        YvVFz:
        IicjP:
        goto qZoDE;
        iJYqx:
        include $this->template($template);
        goto UhyR0;
        qwljZ:
        if (!(strpos($user_agent, "\115\x69\x63\162\x6f\x4d\x65\x73\x73\x65\x6e\x67\x65\162") == false)) {
            goto IicjP;
        }
        goto qqH8M;
        YefBf:
        pFyZy:
        goto P2_UK;
        P2_UK:
        $ads = $this->adService->selectAll("\x20\141\156\x64\x20\x74\171\x70\145\x3d\x31");
        goto ga6DE;
        GDRN6:
        $user_agent = $_SERVER["\x48\x54\x54\120\137\x55\123\x45\x52\x5f\101\107\105\116\124"];
        goto qwljZ;
        UhyR0:
    }
    public function doWebRandomQuan()
    {
        goto UezLn;
        rqj0V:
        L4KfE:
        goto JJN20;
        ZnDS2:
        if (!($i <= 100)) {
            goto L4KfE;
        }
        goto bn0JK;
        qzaZ0:
        echo $u1 . "\54" . $u2 . "\74\x62\x72\57\76";
        goto qQC56;
        kOeZ3:
        $u2 = substr(jf_uuid(), 8);
        goto qzaZ0;
        UezLn:
        global $_W, $_GPC;
        goto I1faz;
        I1faz:
        $i = 0;
        goto owas9;
        owas9:
        WUAs2:
        goto ZnDS2;
        fd5Xq:
        $i++;
        goto Znh84;
        bn0JK:
        $u1 = substr(jf_uuid(), 8);
        goto kOeZ3;
        Znh84:
        goto WUAs2;
        goto rqj0V;
        qQC56:
        cyirI:
        goto fd5Xq;
        JJN20:
    }
    public function doMobileGood()
    {
        goto lZ5fm;
        TUoCc:
        header("\114\157\143\x61\164\x69\157\156\72\40" . $_W["\163\x69\x74\x65\x72\157\x6f\x74"] . "\x61\160\160" . substr($this->createMobileUrl("\x47\157\x6f\x64", array("\x69\144" => $id)), 1));
        goto rgEBR;
        AZ7_b:
        $id = $_GPC["\x69\144"];
        goto Unz19;
        euxkF:
        $this->userService->updateData($user);
        goto XAoOk;
        WTMix:
        VanlH:
        goto JxD47;
        LTiis:
        jDEv8:
        goto EA2Pz;
        dEOEz:
        if (!$oauth) {
            goto VanlH;
        }
        goto glfxb;
        dWrDj:
        $fan = mc_oauth_userinfo();
        goto qWzwY;
        pDH7L:
        $share = array("\x73\150\141\162\145\x5f\x74\151\x74\154\145" => $gift["\x74\x69\x74\x6c\x65"], "\x73\x68\141\x72\145\x5f\154\x6f\147\x6f" => tomedia($gift["\x69\143\157\156"]), "\163\150\x61\162\145\x5f\x75\x72\x6c" => $_W["\163\x69\x74\145\162\157\x6f\x74"] . "\141\160\160" . substr($this->createMobileUrl("\x47\157\x6f\x64", array("\x69\156\166\x69\164\145\137\151\144" => $user["\151\x64"], "\151\x64" => $id)), 1), "\x73\x68\x61\x72\145\137\144\145\x73\143\x72\151\160\x74\x69\x6f\156" => $this->module["\143\x6f\x6e\146\151\147"]["\x73\x68\141\162\x65\137\x64\x65\163\143\x72\x69\160\x74\x69\x6f\x6e"]);
        goto tDET5;
        MTn3N:
        $oauth_account = WeAccount::create($oauth);
        goto SZbXj;
        LEtEF:
        header("\114\x6f\143\141\x74\x69\x6f\156\72\x20" . $forward);
        goto ZgJE4;
        SZbXj:
        if ($code) {
            goto wIX2Y;
        }
        goto oItl7;
        xlRqm:
        include $this->template("\147\157\157\x64");
        goto rUixc;
        EA2Pz:
        $oauth = pdo_fetch("\x73\x65\x6c\x65\143\164\40\x60\x6b\145\x79\140\54\163\145\143\x72\x65\164\54\x61\x63\x69\144\54\x6c\x65\x76\x65\154\x20\x66\162\157\x6d\40" . tablename("\x61\x63\x63\x6f\165\156\x74\137\x77\x65\143\x68\x61\x74\163") . "\x20\x77\x68\x65\162\145\40\x75\x6e\151\x61\x63\x69\x64\x3d\x27{$borrow_uniacid}\x27");
        goto dEOEz;
        Er47U:
        goto wgrTc;
        goto BJX59;
        bGHcx:
        $borrow_uniacid = $this->module["\x63\157\x6e\x66\151\147"]["\157\141\165\164\x68\137\141\143\151\144"];
        goto RH0Jn;
        e6AXb:
        $html["\x70\x72\151\143\151\x6e\x67\x5f\x70\162\151\x63\x65\x5f\x74\145\x78\x74"] = str_replace("\x28\346\266\210\xe8\264\xb9", '', $pricingText);
        goto InxGz;
        i9KxC:
        $html["\x70\162\x69\143\x69\156\x67\x5f\x74\x65\170\164"] = $this->pricingText($pricing);
        goto RmANE;
        TIzCD:
        if (!$oauthInfo["\145\162\x72\143\x6f\144\x65"]) {
            goto oL1N6;
        }
        goto TUoCc;
        Unz19:
        $gift = $this->giftService->selectById($id);
        goto weRCV;
        ZgJE4:
        die;
        goto h3cVE;
        UkB_N:
        MCq8h:
        goto SAoVn;
        RmANE:
        $pricingText = $html["\160\162\x69\x63\x69\x6e\147\x5f\164\145\x78\164"];
        goto e6AXb;
        JxD47:
        $code = $_GPC["\x63\x6f\144\145"];
        goto bunTJ;
        htxEn:
        $address = array();
        goto xJmOQ;
        rgEBR:
        oL1N6:
        goto NZnvV;
        BJX59:
        Ol2Qu:
        goto cqO1o;
        RH0Jn:
        if ($borrow_uniacid > 0 && $gift["\x74\x79\x70\x65"] == 1) {
            goto jDEv8;
        }
        goto Lgadx;
        InxGz:
        $html["\160\x72\x69\x63\x69\156\147\137\x70\x72\x69\x63\x65\137\x74\145\x78\x74"] = str_replace("\x29", '', $html["\160\162\x69\143\x69\156\147\x5f\160\x72\151\143\145\x5f\164\145\x78\164"]);
        goto xlRqm;
        QbyzD:
        $oauthInfo = $oauth_account->getOauthInfo($code);
        goto TIzCD;
        NZnvV:
        $user["\x62\x6f\x72\162\157\167\137\x6f\160\145\156\x69\144"] = $oauthInfo["\x6f\x70\x65\156\x69\x64"];
        goto UkB_N;
        fCNKd:
        goto JVW8O;
        goto LTiis;
        CNvBO:
        $address = $this->addressService->selectById($addressId);
        goto Er47U;
        bunTJ:
        $state = $_GPC["\163\x74\x61\164\145"];
        goto MTn3N;
        cqO1o:
        $address = $this->addressService->getAddressByOpenid($_W["\x6f\x70\145\x6e\151\x64"]);
        goto Mzq0G;
        xJmOQ:
        if (empty($addressId)) {
            goto Ol2Qu;
        }
        goto CNvBO;
        Pj45D:
        wIX2Y:
        goto QbyzD;
        Mzq0G:
        wgrTc:
        goto trnin;
        qWzwY:
        $user["\142\x6f\162\x72\x6f\x77\137\x6f\x70\x65\x6e\x69\x64"] = $fan["\157\160\x65\156\151\144"];
        goto fCNKd;
        LyT2d:
        $forward = $oauth_account->getOauthUserInfoUrl($redirect, "\x62\157\162\x72\157\167");
        goto LEtEF;
        JJ6Mz:
        $resource = $this->htmlStatic();
        goto pDH7L;
        SAoVn:
        JVW8O:
        goto euxkF;
        h3cVE:
        goto MCq8h;
        goto Pj45D;
        lZ5fm:
        global $_W, $_GPC;
        goto AZ7_b;
        glfxb:
        $oauth["\x74\x79\x70\x65"] = 1;
        goto WTMix;
        XAoOk:
        $addressId = $_GPC["\x61\x64\x64\x72\x65\163\x73"];
        goto htxEn;
        tDET5:
        $html = array("\147\157\157\144" => $gift, "\165\x73\x65\x72" => $user, "\x73\157\x6c\144\x5f\x6f\165\x74" => $gift["\x6e\165\x6d"] > 0 ? true : false, "\141\144\144\162\145\163\163" => $address, "\x61\144\x64\x72\145\x73\x73\123\x65\164\164\x69\x6e\147\x50\x61\x67\x65" => empty($address) ? $this->createMobileUrl("\101\144\x64\x72\x65\163\x73\x53\145\x74\164\x69\156\147\120\x61\x67\x65", array("\x67\x6f\x6f\x64" => $id)) : $this->createMobileUrl("\x41\144\144\162\145\163\x73\123\x65\164\164\151\x6e\147\x50\141\147\x65", array("\147\x6f\x6f\144" => $id, "\x61\x64\x64\x72\x65\x73\163\x5f\151\144" => $address["\x69\x64"])), "\143\157\x6e\146\x69\x67" => $this->module["\143\x6f\x6e\146\151\x67"], "\152\x73\143\x6f\x6e\x66\151\147" => $_W["\x61\143\143\x6f\165\x6e\164"]["\152\x73\x73\x64\x6b\143\x6f\156\x66\x69\x67"], "\160\x72\151\143\151\156\147" => $pricing);
        goto i9KxC;
        oItl7:
        $redirect = urlencode($_W["\163\151\164\x65\162\157\x6f\x74"] . "\x61\160\160" . substr($this->createMobileUrl("\x47\157\x6f\x64", array("\151\144" => $id)), 1));
        goto LyT2d;
        Lgadx:
        load()->model("\x6d\143");
        goto dWrDj;
        trnin:
        $userScore = $this->flashUserService->fetchUserScore($user["\x6f\160\x65\x6e\151\144"]);
        goto JJahZ;
        JJahZ:
        $pricing = $this->giftService->pricing($gift, $userScore);
        goto JJ6Mz;
        weRCV:
        $user = $this->userService->getUserInfo($_W["\x6f\x70\145\x6e\x69\144"], false);
        goto bGHcx;
        rUixc:
    }
    private function pricingText($pricing)
    {
        goto PK6rR;
        P00TZ:
        if (!($pricing["\163\143\157\162\x65"] == 0 && $pricing["\155\157\x6e\145\x79"] > 0)) {
            goto QswAv;
        }
        goto j16vL;
        k3Sev:
        $text .= $pricing["\163\x63\157\162\x65"] . $scoreName;
        goto IRbQH;
        wPwiP:
        if (!($pricing["\x73\x63\x6f\162\145"] > 0 && $pricing["\x6d\x6f\156\x65\x79"] == 0)) {
            goto PtfmQ;
        }
        goto IF0lm;
        PK6rR:
        $scoreName = "\xe7\247\xaf\xe5\210\206";
        goto CLtaU;
        IRbQH:
        $text .= "\x2b" . $pricing["\155\157\x6e\145\171"] . "\345\205\203";
        goto U9vOA;
        IF0lm:
        $text .= $pricing["\163\143\x6f\x72\145"] . $scoreName;
        goto Q2FB5;
        uVjO_:
        return '';
        goto kpYjH;
        xP1Oy:
        if (!($pricing["\x73\x63\x6f\162\145"] == 0 && $pricing["\155\x6f\x6e\145\171"] == 0)) {
            goto gzN0k;
        }
        goto uVjO_;
        FEDaY:
        $scoreName = $this->module["\143\x6f\156\x66\151\x67"]["\x73\x63\157\x72\145\137\x6e\x61\155\145"];
        goto UMQAc;
        U9vOA:
        s3toY:
        goto z_mh1;
        z_mh1:
        $text .= "\x29";
        goto RkN23;
        kpYjH:
        gzN0k:
        goto wPwiP;
        CLtaU:
        if (!$this->module["\143\157\156\146\151\x67"]["\x73\x63\157\162\145\x5f\156\x61\155\145"]) {
            goto Uns1f;
        }
        goto FEDaY;
        Q2FB5:
        PtfmQ:
        goto P00TZ;
        CF3HV:
        $text = "\x28\xe6\266\210\xe8\xb4\xb9";
        goto xP1Oy;
        UMQAc:
        Uns1f:
        goto CF3HV;
        j16vL:
        $text .= $pricing["\155\157\x6e\145\171"] . "\xe5\205\203";
        goto tQUkC;
        mjleI:
        if (!($pricing["\163\143\157\162\145"] > 0 && $pricing["\155\x6f\x6e\x65\171"] > 0)) {
            goto s3toY;
        }
        goto k3Sev;
        tQUkC:
        QswAv:
        goto mjleI;
        RkN23:
        return $text;
        goto Uo_Ox;
        Uo_Ox:
    }
    public function doMobileAddressSettingPage()
    {
        goto uX1H3;
        r7iX1:
        $address = $this->addressService->getAddressByOpenid($_W["\157\x70\x65\x6e\151\144"]);
        goto rdWTN;
        TuR6E:
        $user = $this->userService->getUserInfo($_W["\157\160\145\156\151\144"]);
        goto NGi3t;
        OyubJ:
        if (!(null == $address || $address["\157\x70\145\156\x69\144"] != $_W["\157\x70\145\156\x69\x64"])) {
            goto lTILZ;
        }
        goto qQXOp;
        Ct4NP:
        sd0U2:
        goto OyubJ;
        uX1H3:
        global $_W, $_GPC;
        goto sM5Jh;
        dAPpu:
        $html = array("\147\151\146\x74" => $gift, "\x61\144\x64\162\x65\163\x73" => $address, "\x75\x73\145\162" => $user, "\143\157\156\146\x69\x67" => $this->module["\x63\x6f\x6e\x66\x69\147"]);
        goto J2qtL;
        y9xVk:
        pA3Yl:
        goto zeMaj;
        WYU7d:
        lTILZ:
        goto umY20;
        NGi3t:
        $address = null;
        goto anIkz;
        rdWTN:
        goto sd0U2;
        goto y9xVk;
        qQXOp:
        $address = null;
        goto WYU7d;
        anIkz:
        if (!empty($id)) {
            goto pA3Yl;
        }
        goto r7iX1;
        umY20:
        $resource = $this->htmlStatic();
        goto dAPpu;
        MuJk3:
        $goodId = $_GPC["\x67\157\x6f\x64"];
        goto d44IT;
        J2qtL:
        include $this->template("\163\145\x74\x74\151\x6e\x67\55\x61\x64\x64\162\145\x73\x73");
        goto aY7_g;
        d44IT:
        $gift = $this->giftService->selectById($goodId);
        goto TuR6E;
        zeMaj:
        $address = $this->addressService->selectById($id);
        goto Ct4NP;
        sM5Jh:
        $id = $_GPC["\141\144\x64\162\x65\x73\x73\x5f\x69\x64"];
        goto MuJk3;
        aY7_g:
    }
    public function doMobileAddressApi()
    {
        goto fpY_L;
        rqPQL:
        $data["\143\162\145\x61\x74\145\x5f\164\151\x6d\x65"] = $existAddress["\143\x72\145\141\x74\x65\137\164\151\155\145"];
        goto Qqsn4;
        MB8SA:
        $data["\143\162\145\141\x74\x65\x5f\164\x69\x6d\145"] = time();
        goto NWLTg;
        oJTTf:
        $data = array("\x75\x6e\x69\141\x63\151\144" => $_W["\x75\156\x69\141\x63\151\x64"], "\156\141\x6d\145" => $_GPC["\x6e\141\155\x65"], "\x6d\x6f\142\x69\x6c\145" => $_GPC["\x6d\157\x62\x69\x6c\x65"], "\141\144\x64\162\x65\163\163" => $_GPC["\141\144\x64\162\x65\163\x73"], "\160\x72\157\166\x69\x6e\x63\145" => $_GPC["\x70\162\157\x76\x69\x6e\x63\x65"], "\x63\151\x74\x79" => $_GPC["\x63\151\x74\x79"], "\x61\162\x65\141" => $_GPC["\x61\162\x65\x61"], "\165\163\x65\x72\x5f\151\x64" => $_GPC["\165\x73\x65\162\137\x69\x64"], "\157\x70\145\x6e\151\x64" => $_W["\157\x70\145\x6e\151\x64"], "\162\145\x6d\x61\162\153" => $_GPC["\162\145\x6d\x61\x72\153"], "\x75\160\x64\141\164\x65\x5f\164\151\x6d\x65" => time());
        goto YesB9;
        ZJUns:
        $this->returnJson($result);
        goto HOdPM;
        GcP1f:
        $data["\151\144"] = $existAddress["\151\144"];
        goto rqPQL;
        xmVa2:
        $existAddress = $this->addressService->selectById($_GPC["\151\x64"]);
        goto xf4AI;
        fpY_L:
        global $_W, $_GPC;
        goto ukTlX;
        YesB9:
        if (!(!is_null($_GPC["\151\x64"]) && $_GPC["\151\144"] > 0)) {
            goto wM_To;
        }
        goto xmVa2;
        xf4AI:
        if (!empty($existAddress)) {
            goto qsije;
        }
        goto MB8SA;
        SC1vZ:
        wM_To:
        goto IHZQK;
        IHZQK:
        $data = $this->addressService->insertOrUpdate($data);
        goto B7g7E;
        NWLTg:
        goto FiPjr;
        goto OyeXi;
        OyeXi:
        qsije:
        goto GcP1f;
        B7g7E:
        $redirect = $this->createMobileUrl("\107\x6f\x6f\x64", array("\x69\144" => $goodId, "\141\144\x64\x72\145\163\x73" => $data["\x69\144"]));
        goto cOp1l;
        ukTlX:
        $goodId = $_GPC["\x67\157\x6f\144"];
        goto oJTTf;
        cOp1l:
        $result = array("\162\145\144\151\x72\145\x63\x74" => $redirect);
        goto ZJUns;
        Qqsn4:
        FiPjr:
        goto SC1vZ;
        HOdPM:
    }
    public function doMobileGoodList2()
    {
        goto s4ok8;
        jNB44:
        $good = loopToMedia($good, array("\x64\x65\x74\141\151\x6c\x5f\151\x6d\x61\147\x65", "\x74\150\x75\x6d\x62\x6e\x61\151\154"));
        goto xmf1P;
        s4ok8:
        global $_W, $_GPC;
        goto QyW1p;
        O_2KK:
        IoMbP:
        goto fkiF6;
        plZ8Y:
        foreach ($good as $g) {
            goto rsvOC;
            fpAgs:
            unset($g["\x64\145\x73\143\x72\151\160\164\151\157\156"]);
            goto kLB_Y;
            kLB_Y:
            $newGoods[] = $g;
            goto jhonk;
            jhonk:
            Jrl4M:
            goto x7srf;
            rsvOC:
            unset($g["\x67\165\x69\x64\145\x6c\151\x6e\145\163"]);
            goto fpAgs;
            x7srf:
        }
        goto O_2KK;
        xmf1P:
        $newGoods = array();
        goto plZ8Y;
        fkiF6:
        return $this->returnJson($newGoods);
        goto s4h1q;
        QyW1p:
        $good = $this->giftService->selectPage();
        goto jNB44;
        s4h1q:
    }
    public function doMobileGoodList()
    {
        goto clEU2;
        p7Fqw:
        $group = array();
        goto P8neE;
        oAdBS:
        if (!(!is_null($groupId) && is_numeric($groupId) && $groupId > 0)) {
            goto ZlRw5;
        }
        goto yUOM5;
        goRZ1:
        $buyType = $_GPC["\x62\x75\171\137\x74\171\160\x65"];
        goto f2Ejx;
        xXuPn:
        if ($ajax == true) {
            goto FxeoI;
        }
        goto CNIJ8;
        XeVgZ:
        $end = $page["\143\157\165\x6e\x74"] / $page["\160\x61\147\145\x5f\163\x69\172\x65"] >= $page["\160\141\147\145\x5f\x69\156\x64\145\x78"] ? true : false;
        goto R3uf4;
        P8neE:
        if (!$groupId) {
            goto vUze_;
        }
        goto Y3qU1;
        wF_3M:
        QM7bQ:
        goto hcK5T;
        f2Ejx:
        $raffle = $_GPC["\x72\x61\146\146\154\x65"];
        goto L17gN;
        MjPTt:
        $pageIndex = max(1, intval($_GPC["\x70\x61\x67\145"]));
        goto wF_3M;
        nE003:
        if (!(!is_null($buyType) && is_numeric($buyType) && $buyType > 0)) {
            goto a_IvF;
        }
        goto Bs2nr;
        QTZc7:
        a_IvF:
        goto ndoyU;
        hcK5T:
        $page = $this->giftService->selectPageOrderBy($where, "\x72\141\156\x6b\x20\104\105\x53\103\54", $pageIndex);
        goto FI_zI;
        FI_zI:
        $resource = $this->htmlStatic();
        goto XeVgZ;
        clEU2:
        global $_W, $_GPC;
        goto s5KYt;
        crzUD:
        goto nxeLh;
        goto qA0Mw;
        Wxnrv:
        qUNZU:
        goto nE003;
        WkO3I:
        return $this->returnGoodListJson($page);
        goto suFPe;
        C6VTL:
        $where .= "\40\141\156\x64\40\164\171\160\x65\x3d{$type}";
        goto Wxnrv;
        yzZYc:
        ZlRw5:
        goto NUZh9;
        qA0Mw:
        FxeoI:
        goto WkO3I;
        s5KYt:
        $groupId = $_GPC["\x67\x72\x6f\x75\x70"];
        goto QBjp1;
        PXDQe:
        if (!empty($pageIndex)) {
            goto QM7bQ;
        }
        goto MjPTt;
        U9_Fw:
        $pageIndex = max(1, intval($_GPC["\x61\x70\x70\111\164\145\x6d\120\141\x67\x65"]));
        goto PXDQe;
        yUOM5:
        $where .= "\40\x61\x6e\x64\x20\x67\162\x6f\x75\160\137\x69\x64\75{$groupId}";
        goto yzZYc;
        CNIJ8:
        include $this->template("\147\157\x6f\144\55\154\151\163\164");
        goto crzUD;
        AMcs_:
        $where .= "\40\x61\x6e\144\x20\162\141\146\146\154\x65\75\47{$raffle}\x27";
        goto ujwaW;
        ujwaW:
        rXTGP:
        goto U9_Fw;
        xiIal:
        $where = "\x20\141\156\144\40\150\151\x64\145\75\x30";
        goto p7Fqw;
        NUZh9:
        if (!(!is_null($type) && is_numeric($type) && $type > 0)) {
            goto qUNZU;
        }
        goto C6VTL;
        QBjp1:
        $type = $_GPC["\x74\x79\x70\145"];
        goto goRZ1;
        Bs2nr:
        $where .= "\40\x61\156\x64\x20\164\x79\160\145\75{$buyType}";
        goto QTZc7;
        suFPe:
        nxeLh:
        goto X0hCq;
        ndoyU:
        if (!(!is_null($raffle) && $raffle == NGSGiftService::GIFT_RAFFLE)) {
            goto rXTGP;
        }
        goto AMcs_;
        Y3qU1:
        $group = $this->groupService->selectById($groupId);
        goto gNFnK;
        gNFnK:
        vUze_:
        goto oAdBS;
        R3uf4:
        $html = array("\143\157\x6e\x66\x69\x67" => $this->module["\143\157\156\146\151\147"], "\164\171\x70\x65" => $type, "\x65\x6e\x64" => $end);
        goto xXuPn;
        L17gN:
        $ajax = $_GPC["\141\x6a\x61\x78"];
        goto xiIal;
        X0hCq:
    }
    public function doMobileInvitedUserList()
    {
        goto ygEYE;
        ygEYE:
        global $_W, $_GPC;
        goto S21xK;
        V3Kkv:
        $html = array("\152\x73\x63\157\x6e\x66\151\x67" => $_W["\x61\x63\x63\157\165\156\x74"]["\152\163\x73\x64\153\143\x6f\156\x66\151\147"], "\165\163\x65\162" => $user);
        goto MHNVO;
        S21xK:
        $user = $this->userService->getUserInfo($_W["\x6f\x70\x65\156\151\144"]);
        goto JiiG5;
        I8xFE:
        $resource = $this->htmlStatic();
        goto KPoV_;
        KPoV_:
        $invited_users = $this->userService->invitedUsers($userId);
        goto V3Kkv;
        JiiG5:
        $userId = $user["\x69\144"];
        goto Ki0_L;
        Ki0_L:
        $stat = array("\x74\x6f\x74\141\x6c\137\x69\x6e\x76\151\x74\x65\x5f\163\143\157\162\145" => $user["\164\x6f\x74\141\x6c\137\151\x6e\166\x69\164\145\x5f\x73\143\x6f\162\x65"], "\164\157\164\x61\154\x5f\151\156\166\x69\x74\145\137\x6d\x6f\156\145\171" => $user["\x74\x6f\164\141\154\137\x69\x6e\166\x69\164\x65\x5f\155\157\156\x65\x79"], "\151\x6e\x76\x69\x74\145\137\143\157\165\156\x74" => $user["\151\156\166\x69\x74\145\137\x63\x6f\x75\x6e\164"] - $user["\x69\x6e\x76\x69\164\145\137\143\x61\156\143\145\154\x5f\x63\157\x75\x6e\164"], "\x69\x6e\144\x69\x72\x65\143\164\154\x79\137\151\x6e\166\151\164\x65\x5f\143\157\165\x6e\164" => $user["\163\x65\x63\x6f\156\144\137\151\156\166\x69\164\145\137\x63\157\x75\x6e\x74"] - $user["\163\145\143\x6f\x6e\x64\x5f\151\x6e\x76\151\164\145\x5f\x63\141\156\x63\145\x6c\x5f\143\x6f\165\156\164"] + $user["\164\150\x69\162\x64\137\151\x6e\x76\151\x74\x65\137\143\x6f\x75\x6e\164"] - $user["\x74\x68\151\162\144\137\151\156\166\x69\x74\145\x5f\x63\141\156\x63\x65\x6c\x5f\x63\157\165\156\x74"], "\143\141\x6e\x63\145\x6c\x5f\143\157\x75\156\164" => $user["\x69\x6e\166\x69\164\x65\x5f\143\x61\x6e\x63\x65\154\x5f\x63\x6f\x75\156\164"] + $user["\163\145\143\x6f\156\x64\137\x69\x6e\x76\151\164\145\137\143\141\156\x63\x65\154\137\143\157\165\x6e\x74"] + $user["\164\x68\151\x72\x64\x5f\x69\156\166\151\164\145\137\x63\141\156\143\145\x6c\137\x63\157\165\156\164"]);
        goto I8xFE;
        MHNVO:
        include $this->template("\x69\156\166\x69\164\141\164\x69\157\x6e\x2d\154\151\163\x74");
        goto CHa5V;
        CHa5V:
    }
    private function checkParamDuiba($requestParam)
    {
    }
    public function doMobileDuibaConsumeApi()
    {
        goto QXhAY;
        txGz1:
        VH3Y0:
        goto KYsw2;
        ySgzz:
        foreach ($_GPC as $key => $value) {
            goto zgoSC;
            zgoSC:
            if (in_array($key, $system_key)) {
                goto DUPnc;
            }
            goto PZQvS;
            PZQvS:
            $requestParam[$key] = $value;
            goto aZluZ;
            aZluZ:
            DUPnc:
            goto O9cBw;
            O9cBw:
            f6xbo:
            goto TWm9U;
            TWm9U:
        }
        goto txGz1;
        QXhAY:
        global $_W, $_GPC;
        goto N4kP1;
        KYsw2:
        try {
            goto w3USN;
            OFC15:
            $secret = $this->module["\143\157\156\x66\x69\x67"]["\144\165\151\x62\x61\x5f\x73\x65\143\162\x65\164"];
            goto npKXM;
            ft_ik:
            $this->flashUserService->reduceUserScore($credits, $user["\157\x70\145\x6e\x69\x64"], "\144\142\72" . urldecode($requestParam["\144\x65\163\143\x72\151\160\x74\151\x6f\x6e"]));
            goto XAEAr;
            npKXM:
            $result = parseCreditConsume($appkey, $secret, $requestParam);
            goto hKnki;
            XAEAr:
            $score = $this->flashUserService->fetchUserScore($user["\x6f\x70\145\156\151\x64"]);
            goto sf5Hs;
            hKnki:
            $user = $this->userService->selectById($uid);
            goto ft_ik;
            XsapU:
            $appkey = $this->module["\143\x6f\156\x66\x69\x67"]["\144\165\x69\142\x61\137\153\x65\x79"];
            goto OFC15;
            RTHAf:
            $credits = $_GPC["\x63\162\145\144\x69\x74\x73"];
            goto XsapU;
            w3USN:
            $uid = $_GPC["\165\151\144"];
            goto RTHAf;
            sf5Hs:
            return $this->returnDuibaJson(time(), intval($score));
            goto wCkg3;
            wCkg3:
        } catch (Exception $e) {
            return $this->returnJson($requestParam, 400, $e->getMessage());
        }
        goto acY5K;
        JQoJf:
        $system_key = array("\151", "\143", "\155", "\x64\157", "\x5f\137\x73\145\163\x73\151\x6f\x6e", "\x5f\137\x75\156\x69\141\143\151\144", "\137\x5f\165\151\x64", "\x5f\137\x65\x6e\x74\162\171", "\x5f\137\163\x74\141\x74\145");
        goto rxanX;
        N4kP1:
        include_once "\154\151\142\57\x44\165\151\x62\141\123\104\x4b\56\160\150\160";
        goto JQoJf;
        rxanX:
        $requestParam = array();
        goto ySgzz;
        acY5K:
    }
    public function doMobileDuibaOrderResultApi()
    {
    }
    private function returnDuibaJson($bizId, $credits, $status = "\x6f\153", $message = '')
    {
        die(json_encode(array("\163\164\x61\164\x75\x73" => $status, "\x65\x72\x72\x6f\x72\x4d\x65\163\x73\141\x67\x65" => $message, "\x62\x69\x7a\x49\x64" => $bizId, "\143\x72\x65\144\151\x74\x73" => $credits)));
    }
    private function returnGoodListJson($page)
    {
        goto z2wav;
        V2WMB:
        $goodList = array();
        goto B89jU;
        B89jU:
        if (!is_array($page["\x64\141\x74\x61"])) {
            goto B02PV;
        }
        goto tHwVb;
        Or2B0:
        $result = array("\x61\160\x70\x49\164\145\x6d\116\145\x78\164\120\x61\x67\x65" => $end, "\141\162\165\x6e\x75\x6d" => $page["\x70\x61\x67\145\137\x73\x69\172\145"], "\x61\x75\x74\x6f\122\145\143\x6f\x6d\155\145\156\144\116\145\170\x74\120\x61\147\145" => false, "\x61\165\164\x6f\x52\145\143\157\x6d\x6d\145\x6e\x64\x50\141\147\x65" => 1, "\151\164\x65\x6d\163" => $goodList);
        goto d4fmH;
        Tk7Yl:
        ApyF2:
        goto a1hEX;
        d4fmH:
        die(json_encode($result));
        goto s7LzU;
        tHwVb:
        foreach ($page["\x64\x61\x74\x61"] as $good) {
            goto pUkb9;
            hCZFT:
            $recommendText = "\xe5\x94\xae\xe5\xae\x8c";
            goto TO0lU;
            wVuFn:
            if (!($good["\142\x75\171\x5f\164\x79\160\145"] == NGSGiftService::GIFT_BUY_TYPE_SCORE)) {
                goto R16Zh;
            }
            goto J_Ktl;
            Y2uzH:
            nmqiF:
            goto rdn4S;
            s_3mR:
            if ($good["\x62\x75\x79\137\x74\171\160\145"] == NGSGiftService::GIFT_BUY_TYPE_SCORE) {
                goto Hdsn5;
            }
            goto clJMz;
            K5DjM:
            $goodList[] = $item;
            goto uJ9tK;
            clJMz:
            $recommendText = "\xe8\264\xad\xe4\271\260";
            goto gdcns;
            rdn4S:
            VYI9h:
            goto Y5HXH;
            Wgku5:
            $recommendText = "\345\x85\221\xe6\215\242";
            goto mC0DO;
            uJ9tK:
            U7z6T:
            goto WjHN_;
            KaoPk:
            lSt06:
            goto VtAOJ;
            cGu3t:
            if (!($good["\142\165\171\x5f\x74\171\x70\x65"] == NGSGiftService::GIFT_BUY_TYPE_MONEY)) {
                goto lSt06;
            }
            goto rIkS4;
            pUkb9:
            $credits = '';
            goto wVuFn;
            gdcns:
            if (!($good["\x6e\165\155"] <= 0)) {
                goto tsuVD;
            }
            goto hCZFT;
            Cwudw:
            $credits = "{$good["\163\143\x6f\x72\145"]}\xe7\247\xaf\345\210\206\40\x2b\40{$good["\x6d\x6f\x6e\145\x79"]}\345\x85\x83";
            goto AyZ84;
            VtAOJ:
            if (!($good["\142\165\x79\x5f\x74\171\160\x65"] == NGSGiftService::GIFT_BUY_TYPE_SCORE_AND_MONEY)) {
                goto Zu7Kt;
            }
            goto Cwudw;
            Y5HXH:
            $item = array("\143\x72\145\x64\x69\x74\163" => $credits, "\x6c\157\x67\157" => tomedia($good["\x74\x68\165\155\142\156\x61\151\x6c"]), "\162\x65\143\157\155\x6d\x65\x6e\x64\x54\145\x78\164" => $recommendText, "\x74\141\147\x54\x65\170\x74" => $good["\x74\141\147"], "\164\151\x74\x6c\145" => $good["\164\x69\x74\x6c\x65"], "\x74\171\x70\x65" => '', "\x75\162\x6c" => $this->createMobileUrl("\107\157\x6f\144", array("\151\144" => $good["\151\144"])), "\x74\141\147\x43\154\x61\163\x73\145\x73" => '');
            goto K5DjM;
            AhPSK:
            Hdsn5:
            goto Wgku5;
            rIkS4:
            $credits = "{$good["\x6d\x6f\x6e\145\x79"]}\345\205\x83";
            goto KaoPk;
            WY1j9:
            $recommendText = "\345\205\x91\xe5\256\214";
            goto Y2uzH;
            TO0lU:
            tsuVD:
            goto To3mi;
            AyZ84:
            Zu7Kt:
            goto fPqbL;
            J_Ktl:
            $credits = "{$good["\x73\x63\157\x72\145"]}\xe7\xa7\257\xe5\x88\x86";
            goto du2Ti;
            du2Ti:
            R16Zh:
            goto cGu3t;
            To3mi:
            goto VYI9h;
            goto AhPSK;
            fPqbL:
            $recommendText = '';
            goto s_3mR;
            mC0DO:
            if (!($good["\156\x75\155"] <= 0)) {
                goto nmqiF;
            }
            goto WY1j9;
            WjHN_:
        }
        goto Tk7Yl;
        z2wav:
        $end = $page["\143\x6f\x75\x6e\164"] / $page["\160\x61\x67\x65\137\163\151\x7a\x65"] >= $page["\160\141\x67\145\137\151\x6e\144\x65\x78"] ? true : false;
        goto V2WMB;
        a1hEX:
        B02PV:
        goto Or2B0;
        s7LzU:
    }
    public function doMobileRecordList()
    {
        goto lbDKq;
        xfG1P:
        $openid = $_W["\x6f\x70\145\156\x69\x64"];
        goto nQxgA;
        FzGI4:
        $page = $this->setGiftInfoFormOrderPage($page);
        goto YmguP;
        nQxgA:
        $ajax = $_GPC["\x61\152\x61\170"];
        goto udkNI;
        YmguP:
        $nextPage = $page["\x63\x6f\x75\x6e\164"] / $page["\160\141\x67\145\137\163\x69\x7a\145"] >= $page["\160\141\x67\145\137\151\x6e\x64\x65\x78"] ? true : false;
        goto jQSZ1;
        mrLuy:
        return $this->returnRecordListJson($page);
        goto pqfQs;
        DXHOB:
        MQ1_F:
        goto mrLuy;
        xwbqn:
        goto N44bW;
        goto DXHOB;
        jQSZ1:
        $html = array("\143\157\x6e\146\x69\x67" => $this->module["\x63\157\x6e\x66\x69\x67"], "\x6e\145\170\164\120\141\x67\x65" => $nextPage);
        goto Kai2b;
        udkNI:
        $page = $this->orderService->selectPageOrderBy("\40\141\x6e\x64\40\x6f\160\x65\x6e\x69\144\75\47{$openid}\47", "\x20\x63\x72\145\141\x74\x65\x5f\x74\x69\x6d\x65\x20\x64\x65\x73\143\54");
        goto FzGI4;
        hccqN:
        $page["\x64\x61\164\141"] = $this->pageData2Records($page["\x64\x61\x74\x61"]);
        goto xwbqn;
        lbDKq:
        global $_W, $_GPC;
        goto xfG1P;
        Q7tHP:
        include $this->template("\162\145\x63\157\x72\x64\55\154\x69\163\164");
        goto Jl8i3;
        kbQ15:
        if ($ajax == true) {
            goto MQ1_F;
        }
        goto hccqN;
        Kai2b:
        $resource = $this->htmlStatic();
        goto kbQ15;
        pqfQs:
        N44bW:
        goto Q7tHP;
        Jl8i3:
    }
    /**
     * 给订单page 装配礼品信息， 给返回结果加上gift字段
     * @param $page
     * @return mixed
     * @throws Exception
     */
    private function setGiftInfoFormOrderPage($page)
    {
        goto DQKQu;
        BmM_5:
        j2dO_:
        goto PXBkP;
        SaBsx:
        uciCL:
        goto sTz8c;
        FvfbG:
        $goodIdList = FlashHelper::fetchModelArrayIds($list, "\147\x69\146\x74\x5f\x69\x64");
        goto N4Igc;
        qEitF:
        $newOrderList = array();
        goto oHrhe;
        u3F5w:
        $list = $page["\x64\141\x74\x61"];
        goto FvfbG;
        PXBkP:
        return $page;
        goto UuMle;
        N4Igc:
        $goodList = $this->giftImageService->selectByIds($goodIdList);
        goto LPl7L;
        LPl7L:
        $goodMap = FlashHelper::array2Map($goodList, "\x69\x64");
        goto qEitF;
        sTz8c:
        $page["\144\141\x74\x61"] = $newOrderList;
        goto BmM_5;
        DQKQu:
        if (!($page["\x63\x6f\x75\156\x74"] >= 1)) {
            goto j2dO_;
        }
        goto u3F5w;
        oHrhe:
        foreach ($page["\144\x61\164\x61"] as $order) {
            goto p5ytJ;
            bKtZP:
            sKxSy:
            goto HkDXt;
            p5ytJ:
            $order["\147\x69\146\164"] = $goodMap[$order["\x67\151\x66\164\x5f\x69\144"]];
            goto KFhha;
            KFhha:
            $newOrderList[] = $order;
            goto bKtZP;
            HkDXt:
        }
        goto SaBsx;
        UuMle:
    }
    private function pageData2Records($pageData)
    {
        goto gubQL;
        Vpibm:
        include_once "\143\x6f\156\x66\151\147\x2e\x70\150\160";
        goto ObCoc;
        hsfmd:
        return $records;
        goto iO1MP;
        GYGa5:
        Zcr_0:
        goto hsfmd;
        gubQL:
        $records = array();
        goto Vpibm;
        ObCoc:
        foreach ($pageData as $data) {
            goto lraxu;
            U7uFt:
            if (!(date("\x59\55\155\x2d\x64") == date("\x59\55\155\x2d\x64", $data["\143\162\x65\x61\164\145\x5f\164\x69\x6d\x65"]))) {
                goto usAGt;
            }
            goto c6Aeo;
            quCfp:
            $invalid == true;
            goto FEyDd;
            Gzq0B:
            if (!($data["\x73\x74\141\164\x75\x73"] == -1)) {
                goto Nlnf2;
            }
            goto quCfp;
            yPtf2:
            $records[] = $record;
            goto Mi2Dm;
            lraxu:
            $new = false;
            goto U7uFt;
            QX8l3:
            $invalid = false;
            goto KZczG;
            Mi2Dm:
            O2ACb:
            goto vHv2Z;
            j9nMY:
            $statusText .= "\x3c\151\40\143\154\141\x73\x73\75\47\x74\157\157\154\164\151\160\x27\76{$module_config["\x6f\162\x64\145\x72"]["\x73\164\x61\164\165\163"][$data["\163\164\x61\164\165\163"]]}\x3c\x2f\x69\76";
            goto LFY_E;
            NBGt0:
            if (!($data["\163\x74\141\164\165\x73"] <= 0)) {
                goto PQqII;
            }
            goto j9nMY;
            hIsxX:
            usAGt:
            goto QX8l3;
            c6Aeo:
            $new = true;
            goto hIsxX;
            FEyDd:
            Nlnf2:
            goto FwHQS;
            KZczG:
            $statusText = "\xe5\205\x91\xe6\215\242\346\227\xa5\xe6\x9c\x9f\72" . date("\x59\55\x6d\x2d\144\x20\x48\72\x69\72\x73", $data["\143\x72\145\x61\164\145\137\164\151\155\x65"]);
            goto NBGt0;
            FwHQS:
            $record = array("\151\x64" => $data["\151\144"], "\157\162\x64\145\162\x5f\156\x75\x6d" => $data["\x6f\x72\x64\145\162\137\x6e\x75\x6d"], "\x69\155\x67" => tomedia($data["\x67\151\x66\164"]["\x69\x63\157\x6e"]), "\x69\156\166\x61\x6c\151\144" => $invalid, "\156\145\167" => $new, "\x73\x74\141\164\x75\x73\124\145\x78\164" => $statusText, "\x74\x69\164\x6c\145" => $data["\147\x69\146\x74"]["\164\x69\164\x6c\145"], "\x75\162\x6c" => $this->createMobileUrl("\x52\x65\x63\157\162\144", array("\x6f\162\144\x65\x72\x5f\156\x75\x6d" => $data["\157\x72\x64\145\x72\137\156\x75\x6d"])));
            goto yPtf2;
            LFY_E:
            PQqII:
            goto Gzq0B;
            vHv2Z:
        }
        goto GYGa5;
        iO1MP:
    }
    private function returnRecordListJson($page)
    {
        goto wgt0Z;
        F432P:
        $records = $this->pageData2Records($page["\x64\x61\x74\x61"]);
        goto lyzrV;
        wgt0Z:
        $nextPage = $page["\x63\x6f\165\156\164"] / $page["\160\141\147\145\137\163\151\172\145"] >= $page["\160\141\147\145\x5f\151\x6e\x64\145\x78"] ? true : false;
        goto F432P;
        gmi0b:
        die(json_encode($result));
        goto SF4wm;
        lyzrV:
        $result = array("\x6e\x65\x78\x74\120\x61\147\145" => $nextPage, "\163\x75\x63\x63\145\163\x73" => true, "\162\145\143\x6f\162\144\x73" => $records);
        goto gmi0b;
        SF4wm:
    }
    public function doMobileRecord()
    {
        goto gnL7t;
        OLA9C:
        $html = array("\x6f\162\x64\145\162" => $order, "\147\x69\x66\164" => $image, "\143\x6f\156\x66\151\x67" => $this->module["\x63\157\x6e\x66\x69\147"]);
        goto XnUi6;
        kROU5:
        include_once "\143\x6f\156\x66\151\x67\x2e\x70\150\160";
        goto OLA9C;
        XnUi6:
        $resource = $this->htmlStatic();
        goto H8iSk;
        io6RR:
        $image = $this->giftImageService->selectById($order["\x67\151\146\x74\137\x69\144"]);
        goto Gzt0l;
        k4gPa:
        $order = $this->orderService->getOrderDetailByOrderNum($orderNum);
        goto io6RR;
        Jfgy5:
        $order["\161\x75\x61\156"] = $this->quanService->selectById($order["\161\x75\x61\156\137\151\144"]);
        goto Rpfkh;
        mgQNF:
        include $this->template("\x72\x65\x63\157\162\144");
        goto l1qlS;
        r6DMF:
        $orderNum = $_GPC["\x6f\162\x64\145\162\x5f\x6e\x75\x6d"];
        goto k4gPa;
        Gzt0l:
        if (!($order["\164\171\160\145"] == NGSGiftService::GIFT_TYPE_VIRTUAL)) {
            goto do0Ic;
        }
        goto Jfgy5;
        gnL7t:
        global $_W, $_GPC;
        goto lM_5T;
        H8iSk:
        load()->func("\164\x70\x6c");
        goto mgQNF;
        Rpfkh:
        do0Ic:
        goto kROU5;
        lM_5T:
        $id = $_GPC["\x69\144"];
        goto r6DMF;
        l1qlS:
    }
    public function doMobileTransInfo()
    {
        goto UuWDp;
        VrGAv:
        if (!empty($transNum)) {
            goto QNy0u;
        }
        goto lM6Qf;
        UuWDp:
        global $_W, $_GPC;
        goto zWjZb;
        zWjZb:
        $transNum = $_GPC["\x74\x72\141\x6e\x73\x5f\x6e\165\155"];
        goto VrGAv;
        ZGe9Z:
        $data["\x6c\141\163\x74\x5f\x75\x70\144\x61\164\x65\137\164\151\x6d\145"] = $handler->getLastUpdateTime();
        goto eQ6vW;
        FRiPK:
        return $this->returnJson($data);
        goto FhAEZ;
        ceQPU:
        include_once "\x6c\151\142\57\x4e\107\x53\x45\x78\160\x72\145\163\x73\110\141\x6e\x64\x6c\145\162\56\160\x68\x70";
        goto oOASQ;
        uuauW:
        QNy0u:
        goto ceQPU;
        eQ6vW:
        $data["\143\x6f\156\x74\145\156\x74"] = $handler->getLastContent();
        goto FRiPK;
        vQiQd:
        $data = array();
        goto ZGe9Z;
        oOASQ:
        $handler = new NGSExpressHandler($transNum);
        goto vQiQd;
        lM6Qf:
        return $this->returnJson(null);
        goto uuauW;
        FhAEZ:
    }
    public function doMobileAccountInfoClean()
    {
        goto EOdHK;
        dSdRx:
        unset($_SESSION["\157\160\x65\x6e\151\x64"]);
        goto BhjM_;
        rxIYv:
        unset($_SESSION["\x75\x73\145\x72\x69\156\x66\157"]);
        goto dSdRx;
        EOdHK:
        global $_W;
        goto rxIYv;
        BhjM_:
        echo "\345\xae\214\xe6\xaf\225";
        goto e7wX_;
        e7wX_:
    }
    public function doMobileBorrowOauth()
    {
        goto Z8J5D;
        owHMf:
        ZHvmR:
        goto Z3ek0;
        Yf60R:
        HIPh_:
        goto K8BoL;
        OpdJ2:
        iyXLb:
        goto gHt2b;
        SQwkg:
        header("\114\157\x63\x61\164\151\157\x6e\72\40" . $forward);
        goto SHinj;
        x9YA1:
        die(json_encode($oauthInfo));
        goto owHMf;
        SHinj:
        goto ZHvmR;
        goto OpdJ2;
        Uxcsh:
        $redirect = urlencode($_W["\163\151\x74\145\x72\x6f\x6f\164"] . "\141\160\x70" . substr($this->createMobileUrl("\x42\157\x72\162\x6f\167\117\141\x75\164\150"), 1));
        goto IAOhZ;
        ZP5O2:
        $_W["\x61\143\x63\x6f\165\x6e\x74"]["\x6f\x61\x75\x74\150"] = $oauth;
        goto Yf60R;
        KENJ3:
        if (!($borrow_uniacid > 0)) {
            goto i1qle;
        }
        goto GYhmx;
        nnaNq:
        $oauth["\164\171\160\x65"] = 1;
        goto ZP5O2;
        wdzMQ:
        if (!$oauthInfo["\x65\x72\162\x63\157\x64\145"]) {
            goto LsaxB;
        }
        goto IEa4y;
        iSxA7:
        LsaxB:
        goto x9YA1;
        GYhmx:
        $oauth = pdo_fetch("\x73\145\154\x65\143\x74\x20\x60\x6b\x65\x79\x60\54\163\145\143\162\145\164\54\141\143\x69\144\x2c\154\x65\x76\145\x6c\40\146\x72\157\155\x20" . tablename("\141\143\x63\x6f\165\x6e\x74\137\x77\x65\x63\150\x61\x74\x73") . "\40\167\x68\145\x72\145\x20\x75\x6e\151\x61\x63\x69\x64\x3d\47{$borrow_uniacid}\x27");
        goto Zyp87;
        BGGml:
        $code = $_GPC["\x63\x6f\x64\x65"];
        goto NSPM3;
        Zyp87:
        if (!$oauth) {
            goto HIPh_;
        }
        goto nnaNq;
        IEa4y:
        header("\x4c\x6f\143\x61\164\x69\x6f\156\72\x20" . $_W["\163\x69\x74\x65\162\157\x6f\x74"] . "\x61\x70\x70" . substr($this->createMobileUrl("\x42\x6f\162\162\157\x77\x4f\141\x75\164\150"), 1));
        goto iSxA7;
        IAOhZ:
        $forward = $oauth_account->getOauthUserInfoUrl($redirect, "\142\157\x72\162\157\167");
        goto SQwkg;
        K8BoL:
        i1qle:
        goto BGGml;
        NSPM3:
        $state = $_GPC["\x73\x74\x61\164\x65"];
        goto NdfSe;
        ntzh_:
        if ($code) {
            goto iyXLb;
        }
        goto Uxcsh;
        gHt2b:
        $oauthInfo = $oauth_account->getOauthInfo($code);
        goto wdzMQ;
        Z8J5D:
        global $_W, $_GPC;
        goto gu_Op;
        NdfSe:
        $oauth_account = WeAccount::create($_W["\141\143\x63\157\165\156\x74"]["\x6f\x61\165\164\x68"]);
        goto ntzh_;
        gu_Op:
        $borrow_uniacid = $this->module["\x63\157\x6e\146\151\147"]["\157\x61\165\164\150\137\x61\x63\151\144"];
        goto KENJ3;
        Z3ek0:
    }
    public function doMobileAccountInfo()
    {
        goto d6v4q;
        TjqyZ:
        Zg9Fq:
        goto pb_ZY;
        xyDMu:
        $borrow_uniacid = $this->module["\143\157\x6e\146\151\x67"]["\x6f\141\x75\x74\x68\x5f\x61\x63\151\x64"];
        goto JgJtA;
        d6v4q:
        global $_W;
        goto vHt3O;
        ueWkp:
        if (!$oauth) {
            goto Zg9Fq;
        }
        goto pQwpc;
        pQwpc:
        $oauth["\164\171\x70\145"] = 1;
        goto lMHvJ;
        cV2Ot:
        echo json_encode(array("\x6f\x61\165\164\150" => $_W["\x61\x63\x63\157\x75\x6e\x74"]["\157\141\x75\x74\150"], "\x75\x73\x65\x72\x69\x6e\x66\x6f" => $userinfo));
        goto C2zbI;
        qrQvL:
        $oauth = pdo_fetch("\163\x65\154\145\143\x74\40\140\x6b\x65\x79\140\54\163\x65\143\162\145\164\54\141\x63\151\144\x2c\154\x65\x76\145\x6c\40\146\162\x6f\x6d\x20" . tablename("\141\143\143\x6f\x75\156\164\137\x77\x65\x63\x68\141\x74\163") . "\x20\167\x68\145\162\x65\40\165\x6e\151\141\x63\x69\144\x3d\47{$borrow_uniacid}\47");
        goto ueWkp;
        lMHvJ:
        $_W["\141\143\143\x6f\165\x6e\x74"]["\x6f\x61\x75\x74\150"] = $oauth;
        goto TjqyZ;
        pb_ZY:
        V3znQ:
        goto o9MYI;
        pAIMM:
        load()->model("\x6d\x63");
        goto HW278;
        JgJtA:
        if (!($borrow_uniacid > 0)) {
            goto V3znQ;
        }
        goto qrQvL;
        vHt3O:
        $uniacid = $_W["\x75\156\x69\x61\143\x69\144"];
        goto xyDMu;
        o9MYI:
        $this->userService->log($_W["\141\143\143\157\x75\156\x74"]["\x6f\x61\165\x74\150"], "\157\x61\165\x74\x68\xe6\265\213\350\257\225");
        goto pAIMM;
        HW278:
        $userinfo = mc_oauth_userinfo($borrow_uniacid);
        goto cV2Ot;
        C2zbI:
    }
    public function doMobileOrderApi()
    {
        goto Zbk9N;
        XVxJm:
        $lat = $_GPC["\154\x61\164"];
        goto uWwyZ;
        TUJTS:
        $giftId = $_GPC["\147\151\x66\164\137\151\x64"];
        goto To3ce;
        A6eAw:
        try {
            goto QAee7;
            KNyq9:
            $message_and_redirect = $this->generate_result_text_by_order($order);
            goto Zz3Lf;
            QAee7:
            $user = $this->userService->getUserInfo($openid);
            goto a9Zkc;
            CN_GF:
            throw new Exception("\346\202\xa8\xe5\267\xb2\xe7\xbb\x8f\xe8\xa2\253\xe6\x8b\211\xe5\205\245\351\xbb\x91\345\x90\215\xe5\215\x95\357\xbc\x8c\344\272\244\xe6\230\223\346\x97\240\346\263\225\350\xbf\x9b\350\241\214", 400);
            goto eD5sd;
            Zz3Lf:
            $result = array("\x72\x65\x64\151\x72\x65\143\x74" => $message_and_redirect["\162\145\x64\151\x72\145\x63\164"]);
            goto c0m19;
            a9Zkc:
            if (!($user["\x62\x6c\x61\x63\x6b"] == 1)) {
                goto KQMwj;
            }
            goto CN_GF;
            c0m19:
            return $this->returnJson($result, 200, $message_and_redirect["\x6d\x65\163\163\141\147\x65"]);
            goto dIwSs;
            eD5sd:
            KQMwj:
            goto XAHlV;
            XAHlV:
            $order = $this->orderService->order($user, $giftId, $_GPC["\x69\156\166\x69\x74\145\x5f\151\144"], $addressId, $lng, $lat);
            goto KNyq9;
            dIwSs:
        } catch (Exception $e) {
            goto TmksS;
            qSjzp:
            $message = "\xe5\276\x88\xe9\x81\227\xe6\206\xbe\xef\xbc\x8c\xe6\212\275\345\245\226\345\xa4\xb1\350\264\xa5\344\xba\206\xef\274\x81\xe6\x9c\254\346\254\xa1\346\x8a\xbd\345\245\x96\xe6\x89\xa3\xe9\231\244{$gift["\163\x63\157\162\x65"]}\347\xa7\257\xe5\210\206\xe3\200\x82";
            goto StvJk;
            TmksS:
            if ($e->getCode() == 4808) {
                goto zzQsR;
            }
            goto zGmHi;
            StvJk:
            return $this->returnJson($result, 4808, $message);
            goto kF8_n;
            kF8_n:
            jzujj:
            goto AstCx;
            HtCV0:
            zzQsR:
            goto IwtGb;
            eUrJt:
            goto jzujj;
            goto HtCV0;
            zGmHi:
            return $this->returnJson(null, 400, $e->getMessage());
            goto eUrJt;
            IwtGb:
            $gift = $this->giftService->selectById($giftId);
            goto qSjzp;
            AstCx:
        }
        goto CiigJ;
        vuXR_:
        $lng = $_GPC["\154\x6e\x67"];
        goto XVxJm;
        O5FQh:
        $openid = $_W["\157\x70\145\156\x69\x64"];
        goto TUJTS;
        uWwyZ:
        $this->orderService->log($_GPC, "\347\224\xa8\346\210\267\345\274\200\345\xa7\x8b\345\205\x91\346\x8d\242\xe7\xa4\xbc\345\x93\x81\xef\xbc\x8c\xe8\xaf\xb7\346\xb1\202\xe6\x95\260\346\x8d\256\xe5\xa6\x82\xe4\xb8\213");
        goto IyUYx;
        Zbk9N:
        global $_GPC, $_W;
        goto O5FQh;
        To3ce:
        $addressId = $_GPC["\141\x64\144\162\x65\x73\x73"];
        goto vuXR_;
        IyUYx:
        $order = null;
        goto A6eAw;
        CiigJ:
    }
    private function generate_result_text_by_order($order)
    {
        goto vei7X;
        DzxHn:
        $message = "\xe5\276\x88\351\x81\x97\xe6\x86\276\357\274\214\346\x8a\xbd\345\245\226\345\xa4\xb1\xe8\264\245\344\xba\x86\xef\274\x81\346\234\xac\346\254\241\xe6\x8a\xbd\xe5\xa5\x96\xe6\x89\243\xe9\231\xa4{$order["\x6f\162\144\x65\x72\x5f\x73\143\157\x72\x65"]}\xe7\xa7\xaf\xe5\x88\206\xe3\x80\x82";
        goto Fg_XC;
        u3QnY:
        $redirect = $this->createMobileUrl("\x52\145\143\x6f\162\x64", array("\157\x72\x64\x65\162\x5f\156\165\x6d" => $order["\x6f\162\144\145\x72\137\x6e\x75\x6d"], "\146\x69\162\x73\164" => true));
        goto e08b7;
        MhKR7:
        uTcg7:
        goto TJCxn;
        dWiZT:
        goto Um6b3;
        goto zHxmC;
        dD00v:
        xwZoF:
        goto jr29a;
        GB2D3:
        BL1IL:
        goto dD00v;
        PFPXG:
        if ($order["\164\171\x70\x65"] == NGSGiftService::GIFT_TYPE_SEND && $order["\x74\162\x61\x6e\x73\137\146\145\x65"] > 0 && $order["\164\x72\141\x6e\163\x5f\146\145\145\x5f\163\164\141\x74\x75\x73"] == NGSOrderService::ORDER_TRANS_FEE_STATUS_NOT_PAY) {
            goto TN203;
        }
        goto J5oN_;
        FXEUV:
        if ($order["\x74\162\x61\x6e\x73\137\146\145\x65"] > 0 && $order["\164\162\x61\x6e\x73\x5f\x66\x65\145\x5f\163\164\141\164\x75\163"] == NGSOrderService::ORDER_TRANS_FEE_STATUS_NOT_PAY) {
            goto R1jXM;
        }
        goto ggZxb;
        If0uE:
        goto BL1IL;
        goto c3eqR;
        jsLiT:
        knmm_:
        goto nvnOu;
        tmddQ:
        vx5a7:
        goto BYrO6;
        e08b7:
        goto knmm_;
        goto jTooH;
        TJCxn:
        $message = "\347\x82\xb9\345\207\273\350\277\233\345\x85\xa5\xe6\224\257\344\273\x98{$order["\157\x72\144\145\162\137\x6d\x6f\x6e\x65\x79"]}\345\205\x83";
        goto fmMpr;
        HleX6:
        $message .= "\347\202\271\345\207\273\350\277\233\xe5\x85\245\346\x94\xaf\xe4\273\x98{$order["\164\162\141\x6e\x73\x5f\x66\145\x65"]}\xe5\205\x83\351\202\256\xe8\264\xb9\xef\274\201";
        goto tdYjn;
        ggZxb:
        $message .= "\50\345\214\205\351\x82\xae\51";
        goto dWiZT;
        DY4r5:
        ZEMq_:
        goto Zej3c;
        J5oN_:
        $message .= "\347\202\xb9\345\207\273\346\237\xa5\347\234\213\350\256\xa2\345\x8d\x95\350\257\246\xe6\203\x85\x21";
        goto u3QnY;
        Kwyl8:
        $redirect = $this->createMobileUrl("\x4f\x72\144\x65\162\x50\x61\x79", array("\157\x72\144\145\x72\137\156\165\x6d" => $order["\157\162\x64\x65\162\137\x6e\x75\x6d"]));
        goto DY4r5;
        fmMpr:
        if (!($order["\x74\x79\x70\145"] == NGSGiftService::GIFT_TYPE_SEND)) {
            goto vx5a7;
        }
        goto FXEUV;
        jr29a:
        if ($order["\157\x72\x64\145\162\137\x6d\157\156\x65\171"] > 0) {
            goto uTcg7;
        }
        goto PFPXG;
        jTooH:
        TN203:
        goto HleX6;
        jl27s:
        $message = "\xe6\201\255\xe5\x96\234\346\202\xa8\357\xbc\x81\357\274\x81\357\274\201\xe4\270\xad\345\245\226\345\x95\246\xef\274\201\xef\274\x81\357\xbc\201";
        goto If0uE;
        Zej3c:
        return array("\x6d\x65\x73\x73\x61\x67\x65" => $message, "\x72\x65\144\x69\x72\145\143\164" => $redirect);
        goto lfPOS;
        RUH3n:
        if (!($order["\x72\141\146\146\154\145"] == NGSGiftService::GIFT_RAFFLE)) {
            goto xwZoF;
        }
        goto beO5k;
        vei7X:
        $message = '';
        goto RUH3n;
        zHxmC:
        R1jXM:
        goto CU0w9;
        dBZZe:
        Um6b3:
        goto tmddQ;
        c3eqR:
        blVm7:
        goto DzxHn;
        nvnOu:
        goto ZEMq_;
        goto MhKR7;
        Fg_XC:
        return array("\x6d\x65\163\163\141\147\x65" => $message);
        goto GB2D3;
        BYrO6:
        $message .= "\xe7\x8e\xb0\351\207\x91\345\xae\214\346\210\220\345\x85\221\346\215\xa2\41";
        goto Kwyl8;
        CU0w9:
        $message .= "\x2b{$order["\164\162\x61\156\163\137\x66\145\145"]}\345\205\203\351\202\xae\xe8\264\xb9";
        goto dBZZe;
        tdYjn:
        $redirect = $this->createMobileUrl("\117\x72\x64\145\162\x50\141\171", array("\x6f\162\x64\x65\162\137\156\165\155" => $order["\x6f\162\144\145\162\137\156\x75\155"]));
        goto jsLiT;
        beO5k:
        if ($order["\162\141\146\x66\x6c\x65\137\x73\164\x61\x74\165\163"] == NGSOrderService::ORDER_RAFFLE_FAIL) {
            goto blVm7;
        }
        goto jl27s;
        lfPOS:
    }
    public function doMobileZlConfirm()
    {
        goto qDmHq;
        HP2MA:
        try {
            $this->orderService->zlConfirm($orderNum);
            return $this->returnJson(null, 200, "\xe6\201\xad\345\x96\x9c\346\x82\xa8\351\xa2\x86\345\217\x96\xe6\x88\220\345\x8a\237\x21");
        } catch (Exception $e) {
            return $this->returnJson($e->getTrace(), $e->getCode(), $e->getMessage());
        }
        goto uaTiW;
        qDmHq:
        global $_W, $_GPC;
        goto Q6lny;
        CYtjN:
        $orderNum = $_GPC["\x6f\x72\144\145\162\x5f\x6e\165\x6d"];
        goto HP2MA;
        Q6lny:
        $openid = $_W["\x6f\160\x65\x6e\151\x64"];
        goto CYtjN;
        uaTiW:
    }
    public function doMobileTakeOverConfirm()
    {
        goto tY4Rv;
        OSCax:
        $orderNum = $_GPC["\x6f\162\x64\x65\x72\137\156\x75\155"];
        goto XQwuF;
        tY4Rv:
        global $_W, $_GPC;
        goto ZD4B_;
        ZD4B_:
        $openid = $_W["\157\x70\145\x6e\151\x64"];
        goto OSCax;
        XQwuF:
        try {
            $this->orderService->takeOverConfirm($orderNum);
            return $this->returnJson(null, 200, "\346\201\255\345\226\x9c\346\202\xa8\346\x94\266\350\264\xa7\xe6\x88\x90\xe5\x8a\x9f\x21");
        } catch (Exception $e) {
            return $this->returnJson($e->getTrace(), $e->getCode(), $e->getMessage());
        }
        goto IJBhu;
        IJBhu:
    }
    /**
     * 支付成功后的页面
     */
    public function doMobileOrderResult()
    {
    }
    public function doMobileOrderPay()
    {
        goto JTHe2;
        m7ZWI:
        $title = $image["\164\x69\x74\x6c\x65"] . $order["\x6f\162\144\x65\162\137\x6d\157\156\145\171"] . "\345\205\203";
        goto bk9BO;
        LB4EM:
        die;
        goto BFclv;
        desiM:
        $payData = array("\164\x69\x64" => $order["\157\162\x64\x65\162\137\x6e\165\x6d"], "\157\x72\x64\145\x72\163\156" => $order["\x6f\x72\x64\x65\x72\137\156\165\x6d"], "\164\x69\164\x6c\x65" => $title, "\146\145\145" => $fee, "\165\163\145\162" => $_W["\155\x65\155\142\x65\162"]["\165\151\x64"]);
        goto YTSHE;
        Pl31N:
        wZOsq:
        goto ZF6lO;
        YTSHE:
        $this->pay($payData);
        goto LB4EM;
        Hw1Oc:
        $image = $this->giftImageService->selectById($order["\147\x69\x66\x74\137\151\x64"]);
        goto waOuH;
        owO9U:
        $order_num = $_GPC["\x6f\x72\144\145\162\137\x6e\x75\155"];
        goto xGYWa;
        waOuH:
        if (!empty($order)) {
            goto wZOsq;
        }
        goto iSnTo;
        xGYWa:
        $order = $this->orderService->getOrderDetailByOrderNum($order_num);
        goto Hw1Oc;
        iSnTo:
        return message("\xe9\235\236\346\263\225\xe6\x93\215\xe4\275\x9c\xef\274\214\xe8\256\242\xe5\215\x95\344\270\x8d\xe5\255\230\xe5\234\xa8\x2c\xe7\202\271\345\207\xbb\xe8\277\x94\xe5\x9b\x9e", $this->createMobileUrl("\x69\x6e\144\145\170"), "\x65\x72\162\x6f\162");
        goto Pl31N;
        iResc:
        $fee = $order["\x74\162\141\156\x73\x5f\146\145\x65"] + $fee;
        goto fNsQT;
        fNsQT:
        $title .= "\x28\xe5\x90\xab\350\xbf\x90\xe8\264\271{$order["\x74\x72\x61\x6e\163\x5f\146\145\145"]}\345\x85\x83\x29";
        goto hTurO;
        nO_y1:
        $fee = $order["\x6f\162\144\145\162\137\x6d\x6f\x6e\x65\171"];
        goto m7ZWI;
        JTHe2:
        global $_W, $_GPC;
        goto owO9U;
        HlJCx:
        MpfsV:
        goto nO_y1;
        hTurO:
        v1Qk9:
        goto desiM;
        bk9BO:
        if (!($order["\164\171\160\x65"] == NGSGiftService::GIFT_TYPE_SEND && $order["\x74\x72\x61\x6e\163\137\146\x65\x65"] > 0)) {
            goto v1Qk9;
        }
        goto iResc;
        ZF6lO:
        if (!($order["\x73\164\141\164\x75\x73"] != NGSOrderService::ORDER_STATUS_DEFAULT)) {
            goto MpfsV;
        }
        goto vKRAT;
        vKRAT:
        return message("\350\xaf\245\xe8\256\242\345\215\x95\347\212\266\xe6\200\201\xe4\xb8\215\xe6\255\xa3\xe7\241\256\x2c\xe6\227\240\xe6\xb3\x95\346\x94\xaf\344\273\230\54\347\202\xb9\345\207\273\xe8\277\x94\xe5\233\x9e", $this->createMobileUrl("\x69\x6e\144\145\170"), "\x65\162\x72\157\x72");
        goto HlJCx;
        BFclv:
    }
    public function payResult($params)
    {
        goto DQhNm;
        F03Ac:
        if (!($params["\164\171\x70\x65"] == "\167\145\143\150\141\x74")) {
            goto j26tV;
        }
        goto eN_nO;
        ueCIR:
        j26tV:
        goto JyEXi;
        C4eAE:
        $data = array("\x73\x74\141\164\165\x73" => $params["\x72\x65\163\x75\154\x74"] == "\x73\x75\143\x63\145\163\163" ? 1 : 0);
        goto xBhpY;
        eN_nO:
        $data["\164\x72\x61\x6e\x73\151\144"] = $params["\164\x61\x67"]["\164\162\141\x6e\x73\141\143\164\x69\x6f\x6e\137\151\x64"];
        goto ueCIR;
        x6R3n:
        $fee = floatval($params["\146\145\145"]);
        goto C4eAE;
        DQhNm:
        global $_W;
        goto x6R3n;
        JyEXi:
        try {
            goto Yg2We;
            EofXI:
            return message("\xe6\224\xaf\xe4\273\x98\346\x88\220\345\x8a\237\357\xbc\x81", $redirectUrl, "\163\165\143\143\145\x73\163");
            goto L984X;
            L984X:
            die;
            goto nmXr6;
            NjaSg:
            $redirectUrl = $this->createMobileUrl("\x52\145\x63\157\x72\x64", array("\157\162\x64\145\162\x5f\x6e\x75\x6d" => $orderNum));
            goto EofXI;
            Yg2We:
            $this->orderService->payCallBack($orderNum);
            goto NjaSg;
            nmXr6:
        } catch (Exception $e) {
            return message($e->getMessage(), $this->createMobileUrl("\x52\145\x63\157\x72\144"), "\x65\x72\x72\157\162");
        }
        goto Sqvuy;
        xBhpY:
        $orderNum = $params["\164\151\x64"];
        goto F03Ac;
        Sqvuy:
    }
    public function doWebMenuManage()
    {
        goto pxsPj;
        Rz0jQ:
        include $this->template("\x6d\x65\156\x75\55\x6d\x61\x6e\141\x67\x65");
        goto jjfKO;
        pxsPj:
        global $_GPC, $_W;
        goto wuTOl;
        wuTOl:
        $page = $this->menuService->selectPageOrderByAdmin('', "\x72\x61\x6e\153\40\144\145\163\143\54");
        goto Rz0jQ;
        jjfKO:
    }
    public function doWebGroupManage()
    {
        goto b1Lbl;
        b1Lbl:
        global $_GPC, $_W;
        goto KNDcu;
        KNDcu:
        $page = $this->groupService->selectPageAdmin();
        goto v5Um_;
        v5Um_:
        include $this->template("\x67\x72\x6f\x75\160\x2d\x6d\141\156\x61\x67\145");
        goto qKukt;
        qKukt:
    }
    public function doWebAdManage()
    {
        goto Rkelx;
        pufYE:
        include $this->template("\x61\144\x2d\155\x61\x6e\141\x67\145");
        goto mRWkS;
        Jy2Ih:
        $page = $this->adService->selectPageAdmin();
        goto pufYE;
        Rkelx:
        global $_GPC, $_W;
        goto Jy2Ih;
        mRWkS:
    }
    public function doWebAdEdit()
    {
        global $_GPC, $_W;
        return $this->webEdit($this->adService, $_GPC["\151\x64"], $_GPC["\144\x61\x74\x61"], $this->createWebUrl("\101\x64\115\141\156\x61\147\x65"), "\141\144\x2d\145\x64\151\164");
    }
    public function doWebGroupEdit()
    {
        global $_GPC, $_W;
        return $this->webEdit($this->groupService, $_GPC["\x69\144"], $_GPC["\x64\x61\164\x61"], $this->createWebUrl("\x47\x72\x6f\165\x70\115\x61\156\x61\x67\x65"), "\147\x72\157\x75\x70\x2d\145\144\x69\x74");
    }
    public function doWebMenuEdit()
    {
        global $_GPC, $_W;
        return $this->webEdit($this->menuService, $_GPC["\151\144"], $_GPC["\144\x61\164\141"], $this->createWebUrl("\115\145\156\x75\115\141\x6e\x61\x67\x65"), "\155\x65\x6e\x75\55\x65\144\x69\164");
    }
    public function doWebGiftEdit()
    {
        goto Y1fFF;
        Zxe1S:
        whjNY:
        goto O0cp6;
        s4heo:
        load()->model("\155\x63");
        goto p3bc0;
        azeC9:
        iyihu:
        goto JbYAn;
        ZCaGo:
        if ($_GPC["\151\144"]) {
            goto wmqV8;
        }
        goto EOLw8;
        ZLQ0O:
        if (!checksubmit()) {
            goto hAw56;
        }
        goto MrszW;
        mZ7be:
        goto djUAV;
        goto azeC9;
        LR16C:
        $groups = $mc_groups;
        goto WlQU6;
        oYkkD:
        goto whjNY;
        goto yaOuT;
        qpMdF:
        $data["\145\156\144\137\144\x61\x74\145"] = $_GPC["\x67\x65\x74\x5f\166\141\154\151\x64\137\144\x61\164\x65"]["\x65\x6e\144"];
        goto sK6wP;
        Qp0h4:
        require "\143\157\156\146\151\x67\x2e\x70\x68\x70";
        goto s4heo;
        MfZ9_:
        $gift = $this->giftService->selectById($_GPC["\151\x64"]);
        goto cudcF;
        JbYAn:
        $data["\x6d\143\137\147\162\x6f\x75\160"] = implode("\54", $_GPC["\155\143\x5f\147\162\157\165\x70"]);
        goto J8sIr;
        yaOuT:
        w5qt2:
        goto Y1ui0;
        EOLw8:
        $mc_groups = $groups;
        goto Knsjf;
        Knsjf:
        goto mM5Rk;
        goto SjfwB;
        HFRWA:
        $mc_groups = $groups;
        goto GYHyo;
        WR8ml:
        $data = $_GPC["\x64\141\164\x61"];
        goto ZLQ0O;
        sNsuv:
        nDknO:
        goto LR16C;
        J8sIr:
        djUAV:
        goto w3Sqm;
        aVZQM:
        $data["\x76\x61\154\x69\x64\137\x64\141\164\145\x5f\x74\171\x70\x65"] = 1;
        goto TkqG_;
        w3Sqm:
        $data["\x64\x65\164\x61\x69\x6c\x5f\151\155\141\147\145"] = serialize($data["\144\145\x74\x61\x69\154\x5f\151\155\x61\147\145"]);
        goto D9PWn;
        SjfwB:
        wmqV8:
        goto MfZ9_;
        f3S2d:
        foreach ($groups as $g) {
            goto Cs2qN;
            Cs2qN:
            if (!in_array($g["\147\162\x6f\x75\x70\151\144"], $limit_group_ids)) {
                goto U_QL4;
            }
            goto RgU_9;
            r1gZ3:
            PNdBu:
            goto u_pob;
            RgU_9:
            $g["\143\150\145\143\153\145\144"] = true;
            goto JhlnT;
            wahai:
            $mc_groups[] = $g;
            goto r1gZ3;
            JhlnT:
            U_QL4:
            goto wahai;
            u_pob:
        }
        goto sNsuv;
        ZqCOO:
        include $this->template("\147\x69\x66\164\x2d\145\x64\x69\164");
        goto oYkkD;
        GYHyo:
        goto UgCy7;
        goto FNvgu;
        FNvgu:
        t01nQ:
        goto m6R4B;
        m6R4B:
        $limit_group_ids = explode("\x2c", $gift["\x6d\143\x5f\147\x72\x6f\165\160"]);
        goto f3S2d;
        TkqG_:
        yY_tt:
        goto C8uDN;
        cudcF:
        if ($gift["\x6d\x63\x5f\x67\162\x6f\x75\x70\x5f\154\151\x6d\151\164"] = 1) {
            goto t01nQ;
        }
        goto HFRWA;
        p3bc0:
        $groups = mc_groups($_W["\165\156\x69\141\x63\x69\x64"]);
        goto lK6Lj;
        R7upa:
        mM5Rk:
        goto WR8ml;
        D9PWn:
        $data["\x73\164\141\x72\x74\137\144\141\164\145"] = $_GPC["\147\145\164\x5f\x76\141\154\x69\144\x5f\x64\x61\x74\145"]["\x73\164\x61\x72\x74"];
        goto qpMdF;
        sK6wP:
        $data["\x76\141\x6c\151\144\141\x74\x65\137\x73\x74\141\x72\164\137\144\141\164\x65"] = $_GPC["\x75\x73\x65\x5f\x76\x61\x6c\151\x64\x5f\x64\x61\x74\145"]["\x73\x74\x61\162\164"];
        goto uyevH;
        gIf_P:
        if (!empty($data["\x76\x61\x6c\x69\144\x5f\x64\141\x74\145\x5f\x74\x79\x70\145"])) {
            goto yY_tt;
        }
        goto aVZQM;
        tJgNH:
        $data["\155\x63\137\147\162\x6f\165\160"] = '';
        goto mZ7be;
        uyevH:
        $data["\x76\x61\154\151\144\141\x74\145\x5f\145\x6e\x64\x5f\x64\x61\164\x65"] = $_GPC["\165\x73\x65\137\166\141\154\x69\x64\137\x64\141\164\x65"]["\145\156\x64"];
        goto gIf_P;
        woA58:
        if (checksubmit()) {
            goto w5qt2;
        }
        goto ZqCOO;
        Y1fFF:
        global $_GPC, $_W;
        goto Qp0h4;
        Y1ui0:
        return message("\344\xbf\241\346\x81\xaf\344\277\x9d\xe5\255\230\xe6\210\220\345\212\237", $this->createWebUrl("\107\x69\146\x74\115\x61\156\141\x67\145"), "\x73\x75\143\x63\x65\163\163");
        goto Zxe1S;
        C8uDN:
        hAw56:
        goto zPsrf;
        zPsrf:
        $data = $this->webEdit($this->giftService, $_GPC["\x69\x64"], $data, $this->createWebUrl("\107\151\146\x74\115\141\x6e\141\147\145"), "\x67\151\146\x74\55\x65\x64\151\x74", true);
        goto woA58;
        WlQU6:
        UgCy7:
        goto R7upa;
        lK6Lj:
        $mc_groups = array();
        goto ZCaGo;
        MrszW:
        if ($data["\x6d\143\x5f\x67\x72\157\x75\160\x5f\154\151\155\151\164"] == 1) {
            goto iyihu;
        }
        goto tJgNH;
        O0cp6:
    }
    public function doWebRaffleTest()
    {
        goto d3k1g;
        Z93Kg:
        echo "\xe5\275\x93\xe5\211\215\344\270\255\345\xa5\x96\346\xa6\x82\xe7\x8e\207{$_GPC["\x72\141\146\x66\x6c\145\x5f\x63\x68\141\156\x63\x65"]}\45\357\274\x8c\xe5\x85\xb1\346\265\213\xe8\257\225\346\254\xa1\346\x95\260\x31\60\60\x30\60\346\254\241\74\x62\162\57\76";
        goto Gi3W7;
        YqZja:
        cIjt4:
        goto Z93Kg;
        etn0i:
        if (!($_GPC["\162\141\146\x66\x6c\145\x5f\x63\150\x61\156\x63\x65"] < 0)) {
            goto EFJUE;
        }
        goto zXxtf;
        ILdL8:
        $trues = 0;
        goto Aeod8;
        d3k1g:
        function raffle($num)
        {
            goto Jhof2;
            ocPQc:
            tkcQd:
            goto XTMaS;
            ZsQIw:
            x31X2:
            goto gV27g;
            yR1VJ:
            $chanceNumbersKey = array_rand($oneHundred, $num);
            goto t3Z3k;
            ghPHH:
            $i = 1;
            goto ZsQIw;
            z0EXO:
            goto TjEvV;
            goto JoX2L;
            Jhof2:
            $oneHundred = array();
            goto ghPHH;
            t3Z3k:
            $key = array_rand($oneHundred, 1);
            goto iDpYK;
            iDpYK:
            if (in_array($key, $chanceNumbersKey)) {
                goto K0Znf;
            }
            goto UZOyr;
            o0xfv:
            CMb8Z:
            goto yR1VJ;
            wI73F:
            TjEvV:
            goto OvYm1;
            JoX2L:
            K0Znf:
            goto pdbde;
            pdbde:
            return true;
            goto wI73F;
            gV27g:
            if (!($i <= 100)) {
                goto CMb8Z;
            }
            goto AfyN9;
            XTMaS:
            $i++;
            goto F1Cxv;
            AfyN9:
            $oneHundred[] = $i;
            goto ocPQc;
            F1Cxv:
            goto x31X2;
            goto o0xfv;
            UZOyr:
            return false;
            goto z0EXO;
            OvYm1:
        }
        goto VjliX;
        E7tlT:
        if (!($i <= 10000)) {
            goto cIjt4;
        }
        goto m_H3i;
        D2HRg:
        b4GAH:
        goto gEZfW;
        zX81c:
        goto eHlwe;
        goto YqZja;
        FIqw_:
        $i = 0;
        goto YmDRB;
        a4Ju3:
        GwYsn:
        goto YbZGg;
        VPZsu:
        echo "\xe6\xb5\x8b\350\257\x95\xe6\x9c\252\xe4\xb8\xad\xe5\xa5\226\xe6\xac\241\346\x95\xb0\x3d{$falses}\346\xac\241\74\x62\162\57\76";
        goto iRu2n;
        YbZGg:
        syBUq:
        goto ljpLW;
        iRu2n:
        echo "\xe7\211\271\345\x88\xab\xe8\xaf\264\xe6\x98\x8e\xef\274\232\346\x9c\xac\346\xb5\x8b\xe8\xaf\x95\344\270\xba\347\xb3\273\xe7\273\x9f\xe4\xb8\xad\345\xa5\226\xe6\xb5\213\xe8\257\x95\357\274\214\344\xbb\205\344\276\233\345\217\x82\350\200\203";
        goto BiOMR;
        sZw7W:
        $falses++;
        goto zwvMu;
        zXxtf:
        die("\344\xb8\200\345\256\232\344\xb8\215\344\xb8\xad\345\245\226");
        goto xR31W;
        VjliX:
        global $_GPC;
        goto etn0i;
        Aeod8:
        $falses = 0;
        goto FIqw_;
        YmDRB:
        eHlwe:
        goto E7tlT;
        m_H3i:
        if (raffle($_GPC["\162\141\146\x66\x6c\145\137\143\x68\x61\156\143\145"])) {
            goto b4GAH;
        }
        goto sZw7W;
        gEZfW:
        $trues++;
        goto a4Ju3;
        zwvMu:
        goto GwYsn;
        goto D2HRg;
        xR31W:
        EFJUE:
        goto ILdL8;
        Gi3W7:
        echo "\346\265\213\350\xaf\225\344\xb8\255\xe5\xa5\226\xe6\xac\241\xe6\x95\260\x3d{$trues}\346\xac\241\74\x62\x72\57\x3e";
        goto VPZsu;
        ljpLW:
        $i++;
        goto zX81c;
        BiOMR:
    }
    public function doWebNoticeConfig()
    {
        goto RB26s;
        WkkBu:
        if (checksubmit()) {
            goto kGQ0k;
        }
        goto u6bYv;
        T0yhn:
        yxFXi:
        goto oav7n;
        MzpvZ:
        $data["\165\156\x69\x61\x63\x69\x64"] = $notice["\165\156\151\141\x63\151\x64"];
        goto T0yhn;
        f1SLR:
        kGQ0k:
        goto wGaSh;
        RB26s:
        global $_GPC, $_W;
        goto GfAmu;
        u6bYv:
        $data = $notice;
        goto ETZsP;
        oav7n:
        return $this->webEdit($this->noticeService, $_GPC["\x69\144"], $data, $this->createWebUrl("\x4e\x6f\x74\x69\x63\145\x43\157\x6e\x66\x69\147"), "\x6e\x6f\164\151\x63\145\55\x63\157\156\146\x69\147");
        goto wtTrw;
        wGaSh:
        $data["\x69\144"] = $notice["\x69\x64"];
        goto MzpvZ;
        ETZsP:
        goto yxFXi;
        goto f1SLR;
        GfAmu:
        $data = $_GPC["\144\x61\164\x61"];
        goto oPzhp;
        oPzhp:
        $notice = $this->noticeService->getTplConfigByUniacid($_W["\165\x6e\151\x61\143\151\144"]);
        goto WkkBu;
        wtTrw:
    }
    public function doWebHbConfig()
    {
        goto JTZyk;
        F28vb:
        $data = $_GPC["\x64\x61\x74\x61"];
        goto v9EOi;
        m52Il:
        $data["\x72\x6f\x6f\164\143\x61"] = "\x63\x65\x72\164\x73\57{$time}\x2f{$appid}\57\162\157\157\164\143\141\x2e\x70\145\155";
        goto oKRWB;
        B6hTi:
        $this->HBService->checkRegister();
        goto hrweH;
        JTZyk:
        global $_GPC, $_W;
        goto F28vb;
        hrweH:
        return $this->webEdit($this->HBService, $_GPC["\151\144"], $data, $this->createWebUrl("\x48\142\103\157\156\146\151\147"), "\150\x62\x2d\145\x64\x69\x74");
        goto foxWZ;
        FDxX3:
        t4HZQ:
        goto B6hTi;
        KCIDC:
        file_write("\x63\145\x72\x74\163\x2f{$time}\x2f\151\156\x64\145\x78\56\x68\x74\x6d\x6c", '');
        goto QGYyh;
        DGSou:
        $data["\x61\160\x69\143\x6c\x69\x65\x6e\x74\137\x6b\145\x79"] = "\x63\x65\162\164\x73\x2f{$time}\57{$appid}\57\x61\x70\151\x63\x6c\151\145\x6e\164\137\x6b\145\171\x2e\x70\145\155";
        goto m52Il;
        QGYyh:
        file_write("\x63\145\162\164\163\57{$time}\57{$appid}\57\141\160\151\143\x6c\151\x65\x6e\x74\137\x63\x65\x72\x74\x2e\x70\145\155", $apiclient_cert);
        goto nq7LD;
        dA2u1:
        file_write("\143\145\x72\164\x73\x2f{$time}\57{$appid}\57\x72\x6f\157\x74\x63\141\56\x70\145\x6d", $rootca);
        goto Y1BTh;
        yl5Bv:
        load()->func("\164\x70\154");
        goto Nz6Vl;
        v9EOi:
        load()->func("\x66\151\154\145");
        goto yl5Bv;
        Nz6Vl:
        $appid = $data["\141\160\160\151\144"];
        goto T0S8c;
        T0S8c:
        $apiclient_cert = $data["\x61\160\151\143\x6c\151\145\x6e\x74\137\x63\x65\x72\164\x5f\143\x6f\156\x74\x65\x6e\x74"];
        goto e08wB;
        FvXYk:
        $rootca = $data["\162\x6f\x6f\164\x63\141\x5f\143\x6f\156\164\x65\x6e\164"];
        goto wGVh8;
        nq7LD:
        file_write("\143\x65\x72\x74\x73\x2f{$time}\x2f{$appid}\57\x61\160\x69\143\154\x69\x65\156\x74\x5f\153\x65\171\x2e\160\145\x6d", $apiclient_key);
        goto dA2u1;
        e08wB:
        $apiclient_key = $data["\x61\160\151\143\154\151\145\156\164\137\x6b\145\x79\137\143\157\156\x74\145\156\164"];
        goto FvXYk;
        oKRWB:
        if (!empty($data["\151\144"])) {
            goto t4HZQ;
        }
        goto KEWwT;
        KEWwT:
        $data = $this->HBService->getHbConfig($_W["\x75\156\151\141\x63\x69\x64"]);
        goto FDxX3;
        Y1BTh:
        $data["\141\160\151\143\154\x69\x65\156\x74\x5f\x63\145\x72\x74"] = "\x63\145\x72\x74\163\x2f{$time}\57{$appid}\57\x61\x70\x69\143\x6c\151\145\x6e\x74\137\x63\145\x72\164\56\x70\145\155";
        goto DGSou;
        wGVh8:
        $time = time();
        goto KCIDC;
        foxWZ:
    }
    public function doWebPosterConfig()
    {
        goto XNVZZ;
        XpdTS:
        try {
            $this->checkBuedDyposter();
        } catch (Exception $e) {
            return message($e->getMessage(), '', "\144\x61\156\147\x65\162");
        }
        goto nx0ot;
        XNVZZ:
        global $_GPC, $_W;
        goto JKUue;
        JEVa2:
        $data["\x73\x75\x62\163\x63\162\x69\x62\145\137\164\151\160"] = htmlspecialchars($_GPC["\x64\141\x74\141"]["\x73\165\x62\163\143\162\151\142\x65\x5f\x74\x69\160"]);
        goto wzwvl;
        jwEOe:
        if (!($data["\160\157\x73\164\x65\x72\x5f\x74\171\x70\145"] == "\62")) {
            goto OW_Ro;
        }
        goto XpdTS;
        CTqlB:
        $bgSrc = ATTACHMENT_ROOT . $data["\x70\157\163\x74\145\x72\137\x62\x67"];
        goto Q6ohE;
        hXL6o:
        $font = file_exists(dirname(__FILE__) . "\x2f\154\x69\142\x2f\146\157\156\x74\x2f\x6d\163\171\150\56\164\164\x66");
        goto svgoL;
        TVwxi:
        if (!checksubmit()) {
            goto e_Rap;
        }
        goto TWwrD;
        svgoL:
        $data["\150\x74\155\154"]["\146\157\156\164"] = $font;
        goto g55uZ;
        DjKlF:
        e_Rap:
        goto y1giu;
        TWwrD:
        $data = $_GPC["\144\x61\164\141"];
        goto jwEOe;
        wzwvl:
        $imgRoot = ATTACHMENT_ROOT . "\x6c\157\x6e\x61\153\x69\156\x67\x5f\x6e\145\167\137\147\151\x66\x74\137\x73\150\157\160\x2f\160\x6f\x73\x74\x65\162\x2f{$_W["\x75\156\151\141\143\151\x64"]}\57";
        goto CTqlB;
        JrOeZ:
        goto oD5bz;
        goto DjKlF;
        JKUue:
        load()->func("\146\x69\x6c\x65");
        goto n04UT;
        y1giu:
        $data = $this->posterService->getPosterConfig($_W["\165\156\x69\141\143\151\144"]);
        goto hXL6o;
        Q6ohE:
        try {
            goto yb8kU;
            E5OIB:
            $data["\160\157\163\164\x65\x72\137\x62\x67\137\x72"] = "\154\x6f\156\141\153\x69\156\147\x5f\156\x65\167\137\147\151\x66\164\137\x73\150\x6f\x70\x2f\160\157\x73\164\x65\162\57{$_W["\x75\156\151\141\x63\x69\x64"]}\57{$name}\x2e\x6a\x70\147";
            goto tz_DB;
            fRq8V:
            file_write("\154\157\x6e\141\x6b\x69\x6e\x67\137\156\x65\167\137\147\151\x66\164\137\x73\x68\x6f\x70\x2f\x70\157\163\164\x65\x72\x2f{$_W["\x75\x6e\151\141\x63\151\x64"]}\57{$name}\x2e\x6a\160\x67", $tmpFile);
            goto E5OIB;
            RwQHn:
            $name = time();
            goto QyXst;
            QyXst:
            $handler = new PosterHandler();
            goto uSpHP;
            KKGFb:
            $handler->setOnlyCut(true);
            goto TgLBH;
            yb8kU:
            file_write($data["\160\x6f\x73\x74\145\x72\137\x62\147"], file_get_contents(tomedia($data["\160\x6f\x73\x74\145\x72\137\142\x67"])));
            goto RwQHn;
            lqzjD:
            $tmpFile = file_get_contents(tomedia($data["\160\x6f\163\x74\145\162\137\x62\147"]));
            goto fRq8V;
            FpxIq:
            $name = time();
            goto w3pnQ;
            w3pnQ:
            $handler->setDstImg($imgRoot . "{$name}\x2e\x6a\x70\147");
            goto KKGFb;
            TgLBH:
            $handler->createImg(100);
            goto lqzjD;
            uSpHP:
            $handler->setSrcImg($bgSrc);
            goto FpxIq;
            tz_DB:
        } catch (Exception $e) {
            return message($e->getMessage(), '', "\145\162\162\x6f\162");
        }
        goto JrOeZ;
        n04UT:
        load()->func("\164\x70\x6c");
        goto Af6NX;
        g55uZ:
        oD5bz:
        goto GacR8;
        GacR8:
        $this->posterService->checkRegister();
        goto xYtMO;
        xYtMO:
        return $this->webEdit($this->posterService, $_GPC["\151\144"], $data, $this->createWebUrl("\x50\157\163\x74\145\x72\103\157\156\x66\151\147"), "\x70\x6f\163\x74\145\x72\55\145\x64\x69\x74");
        goto v8rNr;
        nx0ot:
        OW_Ro:
        goto JEVa2;
        Af6NX:
        $data = $_GPC["\x64\141\164\141"];
        goto TVwxi;
        v8rNr:
    }
    public function doWebDownloadFont()
    {
        goto kMmQu;
        KMWaa:
        $api = "\x68\x74\164\160\72\x2f\57\167\x65\67\x2e\x6d\171\x77\x6e\x74\x63\56\143\x6f\155\57\146\x6f\156\x74\x2f\x6d\163\x79\150\56\164\164\146";
        goto yYRff;
        MDXVW:
        file_put_contents(dirname(__FILE__) . "\x2f\154\x69\142\x2f\146\157\156\x74\57\x6d\163\171\150\x2e\164\x74\x66", $font);
        goto BFxtj;
        BFxtj:
        die("\xe4\270\213\350\xbd\xbd\xe5\xae\214\xe6\x88\x90\357\274\214\xe8\xaf\267\xe5\x85\263\351\227\xad\xe6\xad\244\351\xa1\265\351\235\242\xef\xbc\x8c\xe5\271\266\345\210\xb7\346\x96\260\xe5\x88\232\346\211\x8d\347\232\x84\351\241\xb5\xe9\235\242");
        goto HSgIW;
        kMmQu:
        global $_GPC;
        goto KMWaa;
        yYRff:
        $font = file_get_contents($api);
        goto acqwj;
        acqwj:
        echo "\345\xad\227\344\xbd\223\xe6\xad\xa3\xe5\234\250\344\270\213\xe8\xbd\xbd\xef\274\x8c\350\xaf\267\347\xa8\x8d\345\220\x8e\357\xbc\214\345\244\247\347\xba\xa6\xe9\x9c\200\xe8\246\x81\x33\x30\xe7\247\222\xe5\267\246\345\217\263\56\x2e\56\74\142\162\57\x3e";
        goto MDXVW;
        HSgIW:
    }
    public function doWebSendTrans()
    {
        goto HaHlJ;
        p__Un:
        try {
            $this->orderService->sendTrans($orderNum, $trans_num, $company);
            return $this->returnJson();
        } catch (Exception $e) {
            return $this->returnJson($e->getTrace(), $e->getMessage(), $e->getMessage());
        }
        goto jWHF3;
        vtiKO:
        $company = $_GPC["\143\157\155\160\x61\156\x79"];
        goto p__Un;
        bH748:
        $orderNum = $_GPC["\157\162\x64\x65\x72\137\x6e\165\x6d"];
        goto vtiKO;
        Gztur:
        $trans_num = $_GPC["\x74\162\x61\156\x73\x5f\156\165\155"];
        goto bH748;
        HaHlJ:
        global $_W, $_GPC;
        goto Gztur;
        jWHF3:
    }
    public function doMobileMyPoster()
    {
        goto JD5Mz;
        KDPF1:
        mkdirs(ATTACHMENT_ROOT . "\x2f\154\x6f\x6e\x61\x6b\151\x6e\x67\137\156\x65\167\x5f\x67\151\146\x74\x5f\163\x68\157\160\x2f\165\x72\154\55\160\x6f\x73\x74\x65\x72\x2f" . $user["\x69\144"] . "\x2f");
        goto PDetR;
        xOndA:
        $qrcodeFilename = $userRoot . "\x71\x72\143\x6f\x64\145\x53\162\x63\x2e\160\156\147";
        goto tj3ZG;
        aOd9c:
        n674C:
        goto lXkGJ;
        Ne35H:
        $fan = mc_oauth_userinfo();
        goto ndvj7;
        lO8aw:
        SZvK6:
        goto G91c5;
        XZGDN:
        if (file_exists(ATTACHMENT_ROOT . "\57\x6c\x6f\156\x61\153\x69\156\147\137\x6e\x65\167\137\147\151\146\x74\137\163\150\157\160\x2f\x75\x72\x6c\55\x70\157\163\164\145\x72\57" . $user["\151\x64"] . "\x2f")) {
            goto OwU3y;
        }
        goto KDPF1;
        BXl7I:
        if (file_exists(ATTACHMENT_ROOT . "\57\x6c\x6f\x6e\141\x6b\x69\x6e\147\x5f\156\145\167\137\147\151\x66\164\137\163\150\x6f\160\57\x2e\144\x2e\x6b\x65\171")) {
            goto FYq9m;
        }
        goto ikrXE;
        ApcfP:
        $avatarContent = file_get_contents($user["\x61\x76\x61\x74\x61\162"]);
        goto Thsxc;
        uxt17:
        $qrcodeSRCPath = $userRoot . "\161\x72\x63\157\144\x65\x53\x72\143\x2e\152\x70\147";
        goto R4ZN2;
        EHfwc:
        die;
        goto EfWeP;
        UWI_6:
        $qrcode = QRcode::png($qrcodeContent, $qrcodeFilename, "\x4c", 6, 2);
        goto PQZeC;
        infSz:
        $oauthInfo = $oauth_account->getOauthInfo($code);
        goto wcvaX;
        ajx5a:
        $time["\155\141\x6b\x65\137\x71\162\143\157\x64\x65"] = time() - $start;
        goto nJ_c5;
        m6oOe:
        $borrow_uniacid = $this->module["\x63\x6f\x6e\146\x69\x67"]["\157\141\165\x74\x68\x5f\x61\143\151\x64"];
        goto Z3W01;
        I1tRp:
        $time = array();
        goto i2sto;
        dmZN2:
        $oauth_account = WeAccount::create($oauth);
        goto OGH44;
        Mb0hr:
        $avatarSRCPath = "{$userRoot}\x61\x76\x61\x74\x61\x72\x53\x72\x63\56\152\x70\x65\147";
        goto uxt17;
        nin3h:
        die("\345\xa4\xb4\345\x83\x8f\344\270\x8b\350\xbd\xbd\xe5\xa4\261\350\264\245\xef\274\214\xe8\257\xb7\345\x88\xb7\xe6\x96\xb0\xe6\255\xa4\351\xa1\265\351\235\242\xe6\210\226\xe5\x85\xb3\xe9\x97\xad\xe9\207\215\346\226\260\xe6\x89\x93\xe5\274\x80");
        goto k3BPG;
        G91c5:
        $code = $_GPC["\x63\x6f\x64\x65"];
        goto usVd_;
        VISuB:
        load()->func("\x66\x69\x6c\x65");
        goto XZGDN;
        k3BPG:
        I5Cbt:
        goto NhBVs;
        OGH44:
        if ($code) {
            goto S35BF;
        }
        goto zdlod;
        eUCKU:
        $oauth["\x74\171\x70\145"] = 1;
        goto lO8aw;
        PDetR:
        OwU3y:
        goto dg2ot;
        tj3ZG:
        $qrcodeContent = $_W["\163\x69\164\145\162\157\157\x74"] . "\57\x61\x70\x70\57" . $this->createMobileUrl("\106\157\154\x6c\157\x77\120\141\x67\145", array("\x69\151" => $user["\x69\144"]));
        goto UWI_6;
        F7qPc:
        header("\x4c\x6f\143\141\164\151\157\x6e\72\x20" . $forward);
        goto EHfwc;
        ikrXE:
        return message("\346\x9c\252\350\xb4\xad\xe4\xb9\260\350\256\xa2\351\230\205\xe5\217\xb7\346\265\267\346\212\245\xe5\x8a\237\350\203\275\54\xe8\257\xb7\xe8\x81\x94\xe7\xb3\273\347\256\241\347\x90\206\xe5\x91\230\350\264\255\xe4\xb9\260", '', "\145\x72\x72\x6f\162");
        goto JB9Dl;
        uo8f9:
        $start = time();
        goto I1tRp;
        G1wfU:
        $bg = ATTACHMENT_ROOT . $posterConfig["\x70\157\163\x74\145\162\137\x62\x67\137\x72"];
        goto Mb0hr;
        tkxGH:
        gVssL:
        goto rzVT3;
        qJaFH:
        lcDsW:
        goto aOd9c;
        sxjay:
        goto mZ4FV;
        goto NsY71;
        iMCky:
        K3IHg:
        goto ajx5a;
        EJ2Eu:
        $openid = $_W["\157\160\145\156\151\144"];
        goto BXl7I;
        APs9K:
        S35BF:
        goto infSz;
        dg2ot:
        $posterConfig = $this->posterService->getPosterConfig($_W["\165\x6e\x69\x61\x63\151\144"]);
        goto LMKwU;
        Thsxc:
        if (!empty($avatarContent)) {
            goto I5Cbt;
        }
        goto nin3h;
        gpCjI:
        if (is_local_resource($user["\141\166\141\x74\141\x72"])) {
            goto lcDsW;
        }
        goto LIG30;
        NORSu:
        znGKs:
        goto qh7NX;
        PQZeC:
        $qrcodeSRCPath = $userRoot . "\161\x72\x63\x6f\x64\x65\x53\162\143\x2e\x6a\x70\147";
        goto ZNaMx;
        EfWeP:
        goto znGKs;
        goto APs9K;
        La7aE:
        VVs_U:
        goto qJaFH;
        NhBVs:
        file_put_contents("{$userRoot}\x2f\x61\166\141\x74\141\x72\x53\162\143\x2e\152\x70\145\x67", $avatarContent);
        goto La7aE;
        zdlod:
        $redirect = urlencode($_W["\x73\x69\164\x65\x72\x6f\157\164"] . "\x61\x70\x70" . substr($this->createMobileUrl("\115\x79\120\157\163\x74\145\x72"), 1));
        goto HUPk6;
        EHCVW:
        $user = $this->userService->updateData($user);
        goto GiKrC;
        usVd_:
        $state = $_GPC["\163\164\x61\164\145"];
        goto dmZN2;
        JD5Mz:
        global $_W, $_GPC;
        goto EJ2Eu;
        ndvj7:
        $user["\x62\157\x72\162\157\167\137\157\160\x65\156\151\144"] = $fan["\157\x70\145\156\151\x64"];
        goto sxjay;
        nJ_c5:
        try {
            goto TWBbF;
            Zqdrh:
            if (!$user["\x6e\x69\x63\153\156\x61\x6d\x65"]) {
                goto Lix1W;
            }
            goto IaanM;
            p3lsT:
            $time["\x6d\x61\153\x65\137\160\x6f\163\164\x65\x72"] = time() - $start;
            goto YHKpC;
            A0lcc:
            $qrcodeHandler->setSrcImg($qrcodeSRCPath);
            goto XHHY1;
            xwLz9:
            $handler->setDstImg($userRoot . "\x70\157\x73\x74\x65\x72\x2e\152\160\x67");
            goto nDpPu;
            vzsSd:
            $handler->setNicknameOffsetX($posterConfig["\x70\x6f\x73\x74\x65\x72\137\156\x61\155\x65\x5f\160\x6f\x73\151\x74\151\157\x6e\137\170"]);
            goto j8jgC;
            aTb0p:
            $handler->setNicknameFontColor($posterConfig["\x70\157\x73\164\145\162\x5f\156\141\155\x65\x5f\143\157\154\x6f\x72"]);
            goto wwyr2;
            IaanM:
            $handler->setNickname($user["\156\151\x63\153\x6e\x61\x6d\x65"]);
            goto aSg99;
            nrhGi:
            $qrcodeHandler = new PosterHandler();
            goto A0lcc;
            IYQ3y:
            include $this->template("\155\171\x2d\160\157\163\x74\x65\162");
            goto dIZ7a;
            nOvEl:
            $avatarHandler->setOnlyCut(true);
            goto cjXKF;
            XHHY1:
            $qrcodeHandler->setOnlyCut(true);
            goto SNcnQ;
            ssYr0:
            $handler = new PosterHandler();
            goto EcVFi;
            fsIu0:
            $avatarHandler->createImg($posterConfig["\x70\x6f\163\x74\x65\162\x5f\x61\166\x61\164\x61\x72\137\x73\x69\144\145"], $posterConfig["\160\x6f\163\x74\x65\x72\137\141\166\x61\x74\x61\x72\137\x73\x69\x64\145"]);
            goto nrhGi;
            wwyr2:
            $handler->setNicknameFontSize($posterConfig["\160\x6f\x73\164\x65\162\x5f\x6e\x61\155\145\x5f\146\x6f\x6e\x74\x5f\163\x69\172\145"]);
            goto vzsSd;
            imsFE:
            $handler->setQrcodeOffsetX($posterConfig["\x70\x6f\x73\164\145\x72\x5f\161\162\x63\x6f\144\x65\137\160\x6f\163\x69\x74\x69\x6f\156\x5f\170"]);
            goto zjuD7;
            j1s9Q:
            $qrcodeHandler->createImg($posterConfig["\x70\157\163\x74\x65\162\x5f\161\162\143\157\x64\x65\137\163\151\144\x65"], $posterConfig["\x70\157\163\164\x65\x72\x5f\x71\162\x63\x6f\x64\145\137\163\151\x64\145"]);
            goto ssYr0;
            ceEvx:
            $handler->setQrcodeImg($userRoot . "\x71\x72\x63\x6f\x64\x65\56\152\160\147");
            goto imsFE;
            YHKpC:
            $html = array("\x70\157\x73\x74\x65\162" => $_W["\163\151\x74\x65\x72\x6f\x6f\164"] . "\x2f\x61\x74\x74\x61\143\x68\x6d\x65\156\x74\57\154\x6f\x6e\141\x6b\151\156\x67\137\156\145\x77\137\x67\x69\x66\x74\137\163\150\157\x70\x2f\x75\x72\x6c\55\x70\157\163\164\x65\162\57{$user["\x69\x64"]}\57\x70\157\x73\x74\x65\x72\x2e\152\160\x67", "\x74\x69\160" => "\xe7\202\xb9\xe5\x87\xbb\344\xbf\235\345\xad\x98\345\223\246", "\x74\x69\164\x6c\145" => "{$user["\x6e\x69\143\153\x6e\x61\x6d\x65"]}\xe7\x9a\204\xe6\265\xb7\346\212\xa5");
            goto IYQ3y;
            aSg99:
            $handler->setNicknameFont(dirname(__FILE__) . "\x2f\154\x69\142\x2f\x66\x6f\x6e\x74\x2f\x6d\x73\171\150\56\164\164\146");
            goto aTb0p;
            SNcnQ:
            $qrcodeHandler->setDstImg("{$userRoot}\x71\162\143\157\144\x65\56\152\160\147");
            goto j1s9Q;
            j8jgC:
            $handler->setNicknameOffsetY($posterConfig["\160\x6f\x73\x74\x65\162\x5f\x6e\141\x6d\x65\x5f\160\x6f\163\151\164\x69\x6f\x6e\137\x79"]);
            goto PsgQO;
            XoFfo:
            $avatarHandler->setSrcImg($avatarSRCPath);
            goto nOvEl;
            zjuD7:
            $handler->setQrcodeOffsetY($posterConfig["\x70\x6f\x73\x74\145\x72\137\x71\x72\x63\157\x64\x65\x5f\160\157\x73\x69\164\151\x6f\156\137\x79"]);
            goto ziNGn;
            EcVFi:
            $handler->setSrcImg($bg);
            goto ceEvx;
            zQxRV:
            $handler->setAvatarOffsetX($posterConfig["\x70\157\x73\x74\145\162\x5f\x61\166\x61\x74\x61\162\137\x70\157\x73\x69\x74\151\157\156\137\170"]);
            goto iCQkJ;
            iCQkJ:
            $handler->setAvatarOffsetY($posterConfig["\160\x6f\163\x74\145\x72\137\141\x76\141\x74\x61\162\x5f\x70\x6f\163\x69\164\151\157\156\x5f\x79"]);
            goto Zqdrh;
            TWBbF:
            $avatarHandler = new PosterHandler();
            goto XoFfo;
            nDpPu:
            $res = $handler->createImg(100);
            goto p3lsT;
            PsgQO:
            Lix1W:
            goto xwLz9;
            cjXKF:
            $avatarHandler->setDstImg("{$userRoot}\x61\x76\141\164\141\162\x2e\x6a\160\x67");
            goto fsIu0;
            ziNGn:
            $handler->setAvatarImg($userRoot . "\x61\166\141\164\141\x72\x2e\x6a\160\x67");
            goto zQxRV;
            dIZ7a:
        } catch (Exception $e) {
            die($e->getMessage());
        }
        goto w3w0i;
        NsY71:
        C8L0W:
        goto Px1Al;
        LS5Jn:
        L6Gfv:
        goto VISuB;
        d3q1x:
        if (!$oauth) {
            goto SZvK6;
        }
        goto eUCKU;
        uXxpX:
        header("\114\x6f\143\141\164\x69\x6f\156\x3a\40" . $_W["\163\151\x74\145\x72\x6f\x6f\164"] . "\x61\x70\160" . substr($this->createMobileUrl("\x4d\x79\120\x6f\163\x74\145\162"), 1));
        goto tkxGH;
        rzVT3:
        $user["\142\x6f\x72\162\x6f\167\x5f\x6f\x70\x65\156\x69\x64"] = $oauthInfo["\157\x70\x65\x6e\x69\x64"];
        goto NORSu;
        ZNaMx:
        png2jpg($qrcodeFilename, false);
        goto iMCky;
        i2sto:
        $acid = $this->module["\143\157\156\x66\151\147"]["\x6f\141\165\164\x68\137\141\x63\151\x64"];
        goto Ye7oW;
        R4ZN2:
        if (!($posterConfig["\160\157\163\x74\x65\162\x5f\150\141\163\x5f\141\x76\141\x74\x61\x72"] && !file_exists($avatarSRCPath))) {
            goto n674C;
        }
        goto gpCjI;
        JB9Dl:
        FYq9m:
        goto uo8f9;
        sJg1F:
        if (!($user["\142\x6c\141\x63\153"] == 1)) {
            goto L6Gfv;
        }
        goto CCHuz;
        PpG94:
        if (!(!file_exists($qrcodeSRCPath) || !file_exists("{$userRoot}\x71\162\x63\157\144\145\56\152\x70\x67"))) {
            goto K3IHg;
        }
        goto k88gI;
        Px1Al:
        $oauth = pdo_fetch("\x73\145\x6c\x65\x63\164\40\140\x6b\x65\171\140\x2c\163\x65\x63\162\x65\164\54\141\x63\151\x64\54\154\145\166\145\x6c\40\146\162\157\155\40" . tablename("\141\143\x63\157\165\x6e\x74\137\x77\145\143\x68\x61\164\x73") . "\x20\167\150\145\x72\x65\x20\165\x6e\151\x61\x63\x69\144\75\x27{$borrow_uniacid}\47");
        goto d3q1x;
        wcvaX:
        if (!$oauthInfo["\145\x72\162\x63\157\144\x65"]) {
            goto gVssL;
        }
        goto uXxpX;
        GiKrC:
        $time["\x67\x65\164\137\165\x73\x65\x72\x5f\151\x6e\x66\157"] = time() - $start;
        goto sJg1F;
        LMKwU:
        $userRoot = ATTACHMENT_ROOT . "\57\154\157\156\x61\153\x69\156\147\137\156\x65\x77\137\x67\x69\146\164\137\163\150\x6f\160\57\x75\162\154\55\160\157\163\164\x65\x72\x2f{$user["\151\144"]}\x2f";
        goto G1wfU;
        LIG30:
        if (file_exists("{$userRoot}\57\141\x76\141\164\x61\x72\x53\162\143\x2e\x6a\160\145\147")) {
            goto VVs_U;
        }
        goto ApcfP;
        k88gI:
        require IA_ROOT . "\x2f\x66\162\141\155\x65\x77\x6f\x72\153\57\x6c\151\x62\162\x61\x72\171\57\161\162\x63\x6f\144\145\57\160\150\x70\x71\162\x63\157\x64\x65\56\x70\150\x70";
        goto xOndA;
        Ye7oW:
        $user = $this->userService->getUserInfo($_W["\157\x70\145\156\x69\x64"], false);
        goto m6oOe;
        lXkGJ:
        $time["\155\141\x6b\145\137\x61\x76\x61\x74\141\x72"] = time() - $start;
        goto PpG94;
        gksw3:
        load()->model("\x6d\143");
        goto Ne35H;
        CCHuz:
        return message("\346\x82\250\xe5\267\262\350\242\xab\345\210\227\xe5\x85\xa5\xe9\xbb\221\xe5\x90\x8d\345\215\x95\xef\xbc\214\346\x97\240\xe6\263\x95\347\224\x9f\346\x88\220\xe6\265\267\346\212\245", '', "\145\x72\x72\x6f\162");
        goto LS5Jn;
        HUPk6:
        $forward = $oauth_account->getOauthUserInfoUrl($redirect, "\x62\x6f\x72\x72\x6f\167");
        goto F7qPc;
        Z3W01:
        if ($borrow_uniacid > 0) {
            goto C8L0W;
        }
        goto gksw3;
        qh7NX:
        mZ4FV:
        goto EHCVW;
        w3w0i:
    }
    public function doWebMakePoster()
    {
        goto kL8jo;
        kL8jo:
        global $_W, $_GPC;
        goto XDV_s;
        Ow6Aj:
        $bg = ATTACHMENT_ROOT . $config["\x70\x6f\163\x74\145\162\137\x62\x67\137\x72"];
        goto wX5WM;
        XDV_s:
        $config = $this->posterService->getPosterConfig($_W["\x75\156\151\141\x63\151\144"]);
        goto GEOja;
        wX5WM:
        try {
            goto mxFK4;
            Y3BmR:
            $qrcodeHandler->setDstImg($imgTestRoot . "\x71\x72\143\157\144\x65\x2e\152\160\147");
            goto o_E5F;
            VinqN:
            $handler->setNicknameFontColor($config["\160\x6f\163\164\x65\162\x5f\156\x61\155\145\137\x63\157\154\x6f\x72"]);
            goto fVxgn;
            JXql2:
            $handler->setNickname("\346\210\221\346\230\257\xe6\x98\265\xe7\xa7\xb0");
            goto uJ7CZ;
            Hcr2m:
            $handler->setQrcodeOffsetX($config["\x70\x6f\x73\x74\x65\x72\x5f\161\x72\143\157\144\145\x5f\x70\157\x73\x69\164\x69\157\x6e\x5f\170"]);
            goto K2_hK;
            zCn18:
            $qrcodeHandler = new PosterHandler();
            goto Puimw;
            gOr3N:
            $handler->setAvatarOffsetX($config["\x70\x6f\163\164\145\162\137\x61\x76\141\164\141\162\137\x70\157\x73\x69\164\151\x6f\156\137\x78"]);
            goto EGbez;
            mxFK4:
            $avatarHandler = new PosterHandler();
            goto VerWO;
            EGbez:
            $handler->setAvatarOffsetY($config["\160\x6f\163\x74\145\162\137\141\x76\141\x74\x61\162\x5f\x70\x6f\163\151\x74\x69\x6f\156\137\171"]);
            goto JXql2;
            uJ7CZ:
            $handler->setNicknameFont(dirname(__FILE__) . "\x2f\x6c\151\142\57\146\x6f\156\x74\x2f\x6d\163\x79\150\56\164\x74\x66");
            goto VinqN;
            Nxk_D:
            echo "\x6e\x69\x68\x61\157";
            goto inPnt;
            lzdjd:
            $avatarHandler->createImg($config["\160\x6f\x73\x74\x65\x72\137\x61\166\141\164\x61\162\x5f\163\x69\144\145"], $config["\x70\157\x73\164\145\162\137\141\166\x61\164\141\162\137\x73\151\144\145"]);
            goto zCn18;
            ChiiY:
            $avatarHandler->setOnlyCut(true);
            goto svCos;
            EJjxy:
            $handler->setSrcImg($bg);
            goto XsSh0;
            Gkmb9:
            $handler->setNicknameOffsetY($config["\160\157\x73\x74\x65\162\137\x6e\141\x6d\x65\x5f\x70\x6f\x73\151\164\x69\x6f\x6e\137\171"]);
            goto f2Ec1;
            VerWO:
            $avatarHandler->setSrcImg(dirname(__FILE__) . "\x2f\x74\145\x6d\x70\x6c\141\164\145\x2f\x63\163\x73\57\x61\x76\x61\164\x61\162\56\x6a\x70\147");
            goto ChiiY;
            o_E5F:
            $qrcodeHandler->createImg($config["\x70\x6f\163\x74\x65\x72\x5f\x71\x72\x63\157\x64\x65\x5f\x73\151\x64\145"], $config["\160\x6f\163\164\x65\162\x5f\x71\x72\143\157\x64\x65\137\x73\151\144\145"]);
            goto s4MVR;
            fVxgn:
            $handler->setNicknameFontSize($config["\x70\x6f\x73\x74\145\162\x5f\x6e\x61\x6d\145\x5f\x66\x6f\x6e\164\137\163\151\x7a\145"]);
            goto RQ9H2;
            s4MVR:
            $handler = new PosterHandler();
            goto EJjxy;
            f2Ec1:
            $res = $handler->createImg(100);
            goto Nxk_D;
            K2_hK:
            $handler->setQrcodeOffsetY($config["\x70\x6f\163\x74\x65\x72\137\x71\x72\x63\x6f\144\145\137\x70\157\x73\x69\164\151\157\x6e\x5f\171"]);
            goto FVsuX;
            XsSh0:
            $handler->setQrcodeImg($imgTestRoot . "\161\162\143\157\x64\x65\x2e\152\160\x67");
            goto Hcr2m;
            svCos:
            $avatarHandler->setDstImg($imgTestRoot . "\141\x76\141\164\141\162\56\x6a\160\147");
            goto lzdjd;
            Ianbj:
            $qrcodeHandler->setOnlyCut(true);
            goto Y3BmR;
            FVsuX:
            $handler->setAvatarImg($imgTestRoot . "\141\x76\x61\x74\141\x72\x2e\152\160\x67");
            goto gOr3N;
            RQ9H2:
            $handler->setNicknameOffsetX($config["\x70\x6f\163\x74\145\162\x5f\x6e\141\155\145\137\160\157\x73\151\x74\x69\157\156\137\170"]);
            goto Gkmb9;
            Puimw:
            $qrcodeHandler->setSrcImg(dirname(__FILE__) . "\57\164\x65\155\160\x6c\x61\x74\145\x2f\143\163\x73\x2f\x71\162\143\157\x64\x65\x2e\x6a\160\x67");
            goto Ianbj;
            inPnt:
        } catch (Exception $e) {
            return message($e->getMessage(), '' . "\x65\x72\162\x6f\x72");
        }
        goto zblt7;
        GEOja:
        $imgTestRoot = ATTACHMENT_ROOT . "\57\154\x6f\x6e\141\x6b\151\x6e\x67\137\156\145\167\137\x67\151\x66\x74\137\163\x68\x6f\160\x2f\x70\x6f\x73\164\x65\162\57\164\145\x73\x74\x2f";
        goto Ow6Aj;
        zblt7:
    }
    public function doWebAddressEdit()
    {
        global $_GPC, $_W;
        return $this->webEdit($this->giftService, $_GPC["\x69\144"], $_GPC["\x64\x61\164\141"], $this->createWebUrl("\107\151\146\x74\115\x61\x6e\141\147\x65"), "\x67\151\146\x74\55\x65\x64\151\x74");
    }
    public function doWebQuanAdd()
    {
        goto k0KEa;
        DRuoU:
        $data = $_GPC["\144\x61\x74\141"];
        goto O63fC;
        If4bA:
        $giftId = $_GPC["\x67\151\x66\164\x5f\151\x64"];
        goto LEcIl;
        k0KEa:
        global $_GPC, $_W;
        goto If4bA;
        j1JQs:
        $quan = array("\x75\156\x69\x61\143\151\x64" => $_W["\165\156\x69\x61\x63\x69\144"]);
        goto QF64d;
        LEcIl:
        $gift = $this->giftService->selectById($giftId);
        goto DRuoU;
        O63fC:
        $quans = $_GPC["\x71\x75\x61\156"];
        goto j1JQs;
        QF64d:
    }
    public function doWebQuanBatchEdit()
    {
        goto knIXg;
        C6bLw:
        if ($submit) {
            goto jwkXe;
        }
        goto Pbjj5;
        SSRdP:
        $giftId = $_GPC["\147\151\146\x74\x5f\151\144"];
        goto BgUDP;
        k5nPQ:
        if (!($type == 2)) {
            goto DFd4n;
        }
        goto Coli2;
        X_THn:
        rND4s:
        goto Ibfjm;
        V_FyL:
        IpOsQ:
        goto qHdug;
        ixPh9:
        goto IpOsQ;
        goto NQoUO;
        f7WDy:
        DFd4n:
        goto OVYTm;
        Coli2:
        $time = 1;
        goto f7WDy;
        MgZ9g:
        $quans = $_GPC["\x71\165\141\x6e"];
        goto SMfbz;
        Ibfjm:
        return message("\xe6\211\xb9\xe9\207\x8f\346\267\xbb\xe5\x8a\xa0\346\210\x90\xe5\212\x9f\x2c\xe7\x82\271\345\207\xbb\xe8\xbf\x94\345\233\x9e", $this->createWebUrl("\121\x75\141\156\115\x61\156\x61\147\x65"), "\x73\165\x63\x63\145\163\x73");
        goto V_FyL;
        aQ5GM:
        $time = $_GPC["\x74\x69\x6d\145"];
        goto k5nPQ;
        GCi_p:
        foreach ($quans as $quan) {
            goto BIKL1;
            KsgRO:
            KpRtT:
            goto kM7T3;
            v1msg:
            $q["\150\141\157"] = $map[0];
            goto BGo8j;
            DV4Hn:
            $map = explode("\x2c", $quan);
            goto v1msg;
            BIKL1:
            $q = array("\165\156\x69\x61\x63\151\x64" => $_W["\165\156\x69\141\x63\151\144"], "\x74\x79\160\145" => $type, "\147\151\146\x74\x5f\x69\x64" => $giftId, "\x73\164\x61\x74\x75\x73" => 0, "\x74\151\x6d\145" => $time, "\x63\162\x65\141\x74\x65\137\x74\151\155\145" => time(), "\165\160\x64\x61\164\x65\x5f\x74\x69\x6d\x65" => time());
            goto DV4Hn;
            TVBbd:
            $this->quanService->insertData($q);
            goto KsgRO;
            BGo8j:
            $q["\x76\141\154\x75\x65"] = $map[1];
            goto TVBbd;
            kM7T3:
        }
        goto X_THn;
        knIXg:
        global $_GPC, $_W;
        goto SSRdP;
        BgUDP:
        $data = $_GPC["\144\141\164\x61"];
        goto ffG8B;
        Pbjj5:
        $allQuan = $this->giftService->selectAllQuan();
        goto M6QsL;
        OVYTm:
        $submit = checksubmit();
        goto C6bLw;
        M6QsL:
        include $this->template("\x71\165\141\156\x2d\142\141\x74\x63\150\x2d\145\x64\x69\x74");
        goto ixPh9;
        ffG8B:
        $type = $_GPC["\x74\x79\160\x65"];
        goto aQ5GM;
        SMfbz:
        $quans = array_filter(explode("\15\xa", $quans));
        goto GCi_p;
        NQoUO:
        jwkXe:
        goto MgZ9g;
        qHdug:
    }
    private function webEdit($service, $id, $data, $redirect, $template, $return = false, $isAjax = false)
    {
        $arr = array("\x69\x64" => $id, "\144\141\164\141" => $data, "\163\x65\x72\166\x69\x63\x65" => $service, "\164\145\x6d\x70\x6c\141\164\145" => $template, "\x72\145\144\151\x72\145\x63\x74" => $redirect);
        return $this->edit($arr, $return, $isAjax);
    }
    /**
     * data : array()
     * service:
     * redirect : $this->createWebUrl("AdManage")
     * template
     * @param array $arr
     * @param bool|false $isAjax
     * @return mixed|void
     */
    private function edit($arr = array(), $return = false, $isAjax = false)
    {
        goto jcxRx;
        cGhel:
        if (!empty($_GPC["\163\165\142\x6d\x69\x74"])) {
            goto evk_K;
        }
        goto biLWU;
        AnGI6:
        $resource = $this->htmlStatic();
        goto xPnMR;
        vUuDC:
        try {
            goto d51pQ;
            Wz1Hc:
            goto wSz81;
            goto XcRfm;
            nIMpO:
            wSz81:
            goto moKBz;
            PeNI0:
            return $data;
            goto ioKl5;
            XcRfm:
            T9VwJ:
            goto nGmgz;
            ioKl5:
            FLEDj:
            goto Kc9cZ;
            d51pQ:
            $data["\x75\x70\144\141\x74\x65\x5f\x74\151\x6d\x65"] = time();
            goto aGMZE;
            aGMZE:
            $data = $arr["\163\145\x72\x76\x69\143\x65"]->insertOrUpdate($data);
            goto gCxWG;
            gCxWG:
            if (!$return) {
                goto FLEDj;
            }
            goto PeNI0;
            j0csF:
            return message("\xe4\xbf\xa1\xe6\201\xaf\344\277\x9d\xe5\255\230\346\x88\x90\xe5\212\237", $arr["\162\x65\x64\151\162\x65\143\164"], "\163\x75\x63\x63\145\x73\x73");
            goto Wz1Hc;
            Kc9cZ:
            if ($isAjax) {
                goto T9VwJ;
            }
            goto j0csF;
            nGmgz:
            return $this->returnJson($data);
            goto nIMpO;
            moKBz:
        } catch (Exception $e) {
            goto k8a8s;
            d4ZtS:
            TXeK7:
            goto cZwi8;
            Ksfue:
            R0vdh:
            goto H84y2;
            uPEq5:
            return null;
            goto VOeEL;
            k8a8s:
            if (!$return) {
                goto WigET;
            }
            goto uPEq5;
            cZwi8:
            return $this->returnJson(null, $e->getCode(), $e->getMessage());
            goto Ksfue;
            uSwrN:
            return message("\344\xbf\241\346\x81\xaf\344\277\235\345\xad\x98\xe5\xa4\xb1\xe8\264\245", '', "\x65\162\162\x6f\162");
            goto CZuQl;
            CZuQl:
            goto R0vdh;
            goto d4ZtS;
            VOeEL:
            WigET:
            goto nGJyN;
            nGJyN:
            if ($isAjax) {
                goto TXeK7;
            }
            goto uSwrN;
            H84y2:
        }
        goto adIKu;
        CSitQ:
        $data["\165\156\x69\x61\x63\151\144"] = $_W["\165\x6e\151\141\x63\151\x64"];
        goto vUuDC;
        adIKu:
        J41eQ:
        goto UnIyJ;
        S4f08:
        o6TRU:
        goto uafcE;
        pqHA9:
        load()->func("\x66\x69\154\145");
        goto nQolw;
        J9_3d:
        GvOEi:
        goto yL3ec;
        LfsqE:
        goto f18DM;
        goto J9_3d;
        biLWU:
        if (is_null($id)) {
            goto vJofw;
        }
        goto uzmS1;
        jcxRx:
        global $_GPC, $_W;
        goto eTDTg;
        eTDTg:
        $id = $arr["\x69\144"];
        goto Tgzfj;
        oMUYu:
        evk_K:
        goto CSitQ;
        D19Eu:
        goto J41eQ;
        goto oMUYu;
        MHRQw:
        return $data;
        goto S4f08;
        GN6ar:
        f18DM:
        goto D19Eu;
        uafcE:
        if ($isAjax) {
            goto GvOEi;
        }
        goto pqHA9;
        QExve:
        if (!$return) {
            goto o6TRU;
        }
        goto MHRQw;
        yL3ec:
        return $this->returnJson($data);
        goto GN6ar;
        uzmS1:
        $data = $arr["\x73\145\x72\166\151\143\145"]->selectById($id);
        goto A44Ec;
        A44Ec:
        vJofw:
        goto QExve;
        nQolw:
        load()->func("\164\x70\x6c");
        goto AnGI6;
        xPnMR:
        return include $this->template($arr["\164\145\155\160\154\141\x74\x65"]);
        goto LfsqE;
        Tgzfj:
        $data = $arr["\144\x61\x74\141"];
        goto cGhel;
        UnIyJ:
    }
    public function doWebGiftManage()
    {
        goto irMDz;
        wl6u7:
        aA1a6:
        goto kXMH6;
        uCpBD:
        include $this->template("\x67\x69\146\164\x2d\155\x61\156\x61\x67\x65");
        goto vmJo2;
        zm_kW:
        $page = $this->giftService->selectPageOrderByAdmin($where, "\143\162\x65\x61\x74\145\137\x74\x69\x6d\145\40\x64\x65\163\x63");
        goto uCpBD;
        upma7:
        $buy_type = intval($_GPC["\142\165\171\137\164\x79\x70\145"]);
        goto p8ejy;
        Xjshs:
        if (!$buy_type) {
            goto fcNpB;
        }
        goto Drz33;
        Drz33:
        $where .= "\x20\x61\x6e\x64\40\x62\x75\171\x5f\164\x79\160\x65\75{$buy_type}";
        goto dPHhT;
        A5E1F:
        EwD3Z:
        goto zm_kW;
        XVIom:
        $where .= "\40\141\156\144\x20\164\x69\164\x6c\145\x20\x6c\151\153\145\40\x27\45{$title}\45\47";
        goto A5E1F;
        irMDz:
        global $_GPC, $_W;
        goto upma7;
        q4229:
        $title = $_GPC["\x74\151\164\x6c\x65"];
        goto DGk5W;
        kXMH6:
        if (!$title) {
            goto EwD3Z;
        }
        goto XVIom;
        dPHhT:
        fcNpB:
        goto EWtLL;
        EWtLL:
        if (!$type) {
            goto aA1a6;
        }
        goto YJK0X;
        p8ejy:
        $type = intval($_GPC["\164\171\160\x65"]);
        goto q4229;
        YJK0X:
        $where .= "\x20\141\156\144\x20\164\x79\x70\145\x3d{$type}";
        goto wl6u7;
        DGk5W:
        $where = '';
        goto Xjshs;
        vmJo2:
    }
    public function doWebUserManage()
    {
        goto Xkws3;
        b83AN:
        $orderby = '';
        goto bAC8S;
        sYH3x:
        P2m93:
        goto Rux4a;
        KqDV4:
        $where .= "\40\x61\x6e\x64\40\x63\x72\x65\141\164\x65\137\x74\151\155\145\74\75\x27{$end}\x27";
        goto gVgnf;
        HWocT:
        $where .= "\x20\x61\x6e\144\x20\x63\x72\145\141\x74\x65\137\164\151\x6d\145\x3e\x3d\x27{$start}\47";
        goto FiSG1;
        TAIiM:
        $orderby .= "\x2c\164\157\x74\x61\x6c\x5f\151\156\x76\151\x74\x65\137\x73\143\157\162\145\40{$scoreOrderBy}";
        goto i4rAW;
        jNx_k:
        if ($orderbyFirst) {
            goto OAukY;
        }
        goto Bmst2;
        Bi3on:
        $orderby .= "\40\151\x6e\x76\151\x74\145\137\x63\x6f\x75\156\164\40{$inviteCountOrderBy}";
        goto yS4jz;
        iA1f3:
        if ($orderbyFirst) {
            goto Hzak0;
        }
        goto NJ2VO;
        SFRui:
        $posting = $_GPC["\x69\x6e\137\160\157\x73\x74\151\x6e\147"];
        goto tW1Tl;
        g6MH6:
        if (!$end) {
            goto gSDaT;
        }
        goto KqDV4;
        S2Koc:
        $users = pdo_fetchall("\x73\x65\x6c\x65\x63\164\x20\x6f\160\145\x6e\151\144\x2c\40\x66\157\x6c\x6c\x6f\x77\54\146\x6f\154\154\x6f\167\x74\151\x6d\x65\x2c\x20\165\x6e\x66\157\154\x6c\157\x77\164\151\x6d\145\40\x66\x72\157\155\x20" . tablename("\155\143\x5f\155\x61\160\160\x69\156\147\137\146\x61\156\163") . "\x20\x77\x68\x65\x72\x65\40\x6f\160\x65\156\x69\x64\x20\x69\156\40\x28\x27{$openidsText}\47\51");
        goto pg8Pt;
        gQ6M0:
        goto szcr4;
        goto FLgBC;
        eCD52:
        if (!$scoreOrderBy) {
            goto ARKQE;
        }
        goto F_Ae0;
        Bmst2:
        $orderby .= "\54\143\162\145\141\164\145\x5f\164\151\155\x65\x20\144\x65\x73\143";
        goto kjSVy;
        kjSVy:
        goto cTNnO;
        goto DGE5V;
        mtNra:
        foreach ($page["\x64\141\x74\141"] as $u) {
            goto Yooy3;
            jwNFF:
            WP7dG:
            goto f6gYe;
            Im6dQ:
            oBlrL:
            goto vwPrn;
            Yooy3:
            if (!($u["\160\151\144"] && intval($u["\160\x69\x64"]) > 0)) {
                goto oBlrL;
            }
            goto qV1LE;
            vwPrn:
            $newPageData[] = $u;
            goto jwNFF;
            qV1LE:
            $u["\x69\x6e\x76\151\x74\x65\137\x75\x73\145\x72"] = $inviteUserMap[$u["\x70\151\144"]];
            goto Im6dQ;
            f6gYe:
        }
        goto cY_GJ;
        kyRcD:
        if (empty($nickname)) {
            goto wy2rt;
        }
        goto Fcnn0;
        mrYym:
        VkIfk:
        goto PhDkA;
        FiSG1:
        lZQI2:
        goto g6MH6;
        G__Xh:
        yJAYO:
        goto bofnC;
        G_UBZ:
        $page["\144\141\164\141"] = $newPageData;
        goto sYH3x;
        DEOFn:
        foreach ($page["\x64\x61\164\141"] as $d) {
            goto O8lH_;
            BZ_uu:
            kE33W:
            goto me81_;
            O8lH_:
            if (in_array($d["\157\x70\145\x6e\x69\144"], $openids)) {
                goto O8zkh;
            }
            goto nlreA;
            XNcGr:
            O8zkh:
            goto BZ_uu;
            nlreA:
            $openids[] = $d["\157\x70\x65\x6e\151\144"];
            goto XNcGr;
            me81_:
        }
        goto lu9RX;
        cPpIa:
        ARKQE:
        goto jNx_k;
        wT0_E:
        foreach ($inviteUsers as $u) {
            $inviteUserMap[$u["\151\144"]] = $u;
            yAZmI:
        }
        goto xnTEZ;
        uNusf:
        $inviteUserIds = FlashHelper::fetchColumnArray($page["\x64\141\164\x61"], "\160\151\144");
        goto iFAPE;
        cE2Do:
        QEiKh:
        goto zalr5;
        Uvpsn:
        if (!($page["\x64\x61\x74\x61"] && sizeof($page["\x64\x61\x74\141"]) > 0)) {
            goto f2fCf;
        }
        goto uNusf;
        gxdQs:
        $openidsText = implode("\x27\x2c\x27", $openids);
        goto J_p63;
        zalr5:
        $orderbyFirst = false;
        goto cPpIa;
        DGE5V:
        OAukY:
        goto uy0U0;
        eVZxE:
        $orderby .= "\x20\x74\157\x74\141\154\x5f\151\x6e\166\x69\164\145\x5f\163\x63\x6f\162\x65\x20{$scoreOrderBy}";
        goto cE2Do;
        kvwOZ:
        $nickname = $_GPC["\x6e\x69\x63\153\156\x61\155\x65"];
        goto S3vTR;
        pg8Pt:
        $userMap = array();
        goto VnitM;
        DYLtZ:
        K7pfB:
        goto eVZxE;
        cxQjq:
        if (empty($inviteUsers)) {
            goto P2m93;
        }
        goto K6XF9;
        xnTEZ:
        T6qyb:
        goto mtNra;
        qgJ1P:
        $page = $this->userService->selectPageOrderByAdmin($where, $orderby);
        goto Uvpsn;
        WccAH:
        $where .= "\x20\141\x6e\x64\40\163\x75\142\163\x63\162\151\142\145\x3d{$subscribe}";
        goto blIF9;
        jVb_l:
        $end = empty($_GPC["\x63\x72\x65\141\x74\x65\137\164\x69\x6d\x65"]["\x65\156\x64"]) ? TIMESTAMP : strtotime($_GPC["\x63\x72\145\141\164\145\x5f\164\x69\x6d\145"]["\x65\x6e\144"]) + 86399;
        goto kvwOZ;
        S3vTR:
        $subscribe = $_GPC["\163\165\x62\163\143\x72\x69\x62\145"];
        goto BVJrv;
        i4rAW:
        goto QEiKh;
        goto DYLtZ;
        Xkws3:
        global $_GPC, $_W;
        goto VW88S;
        EXUFP:
        $orderbyFirst = false;
        goto E7Nhk;
        yS4jz:
        szcr4:
        goto EXUFP;
        F_Ae0:
        if ($orderbyFirst) {
            goto K7pfB;
        }
        goto TAIiM;
        NJ2VO:
        $orderby .= "\54\151\156\166\151\164\x65\137\143\157\x75\x6e\164\40{$inviteCountOrderBy}";
        goto gQ6M0;
        gVgnf:
        gSDaT:
        goto zfJA4;
        iFAPE:
        $inviteUsers = $this->userService->selectByIds($inviteUserIds);
        goto cxQjq;
        d01CS:
        if (!$start) {
            goto lZQI2;
        }
        goto HWocT;
        FLgBC:
        Hzak0:
        goto Bi3on;
        HQ7gj:
        if (!$inviteCountOrderBy) {
            goto i3Bmu;
        }
        goto iA1f3;
        xm0t6:
        $create_time = $_GPC["\x63\x72\145\x61\164\145\x5f\x74\x69\155\145"];
        goto OsBVw;
        K6XF9:
        $newPageData = array();
        goto nz3OA;
        VW88S:
        $where = '';
        goto xm0t6;
        E7Nhk:
        i3Bmu:
        goto eCD52;
        VnitM:
        foreach ($users as $u) {
            $userMap[$u["\157\x70\145\x6e\x69\x64"]] = $u;
            JKofY:
        }
        goto mrYym;
        Cj7D1:
        Jk5dl:
        goto gNI9H;
        nz3OA:
        $inviteUserMap = array();
        goto wT0_E;
        lu9RX:
        oC7s0:
        goto gxdQs;
        bofnC:
        $page["\144\141\164\x61"] = $newPageData;
        goto Cj7D1;
        J_p63:
        if (empty($openids)) {
            goto Jk5dl;
        }
        goto S2Koc;
        uy0U0:
        $orderby .= "\40\x63\162\x65\x61\164\x65\137\164\x69\155\145\40\x64\x65\163\143";
        goto JCz1u;
        JCz1u:
        cTNnO:
        goto qgJ1P;
        PhDkA:
        $newPageData = array();
        goto OGGdA;
        bGTjY:
        $inviteCountOrderBy = empty($_GPC["\151\x6e\166\151\164\145\137\x63\157\165\156\x74\x5f\x6f\162\144\145\162\x62\x79"]) ? null : (in_array($_GPC["\151\x6e\x76\x69\x74\145\137\143\157\x75\156\x74\137\157\x72\x64\145\162\142\x79"], array("\144\x65\163\x63", "\x61\x73\143")) ? $_GPC["\151\x6e\166\151\164\x65\x5f\x63\x6f\165\x6e\164\x5f\x6f\162\x64\145\162\x62\x79"] : null);
        goto SFRui;
        OsBVw:
        $start = empty($_GPC["\143\162\145\x61\x74\x65\x5f\x74\151\155\145"]["\163\164\141\x72\164"]) ? strtotime("\x2d\61\x32\40\155\157\x6e\164\150") : strtotime($_GPC["\x63\x72\x65\141\x74\145\137\164\x69\x6d\x65"]["\163\x74\141\162\164"]);
        goto jVb_l;
        Rux4a:
        f2fCf:
        goto Yeuwm;
        cY_GJ:
        bfZDM:
        goto G_UBZ;
        kA_2d:
        $where .= "\40\x61\156\x64\x20\151\156\137\x70\157\x73\x74\x69\x6e\x67\75\47{$posting}\47";
        goto uLqJY;
        OGGdA:
        foreach ($page["\x64\x61\x74\x61"] as $d) {
            goto syRFR;
            syRFR:
            $d["\146\x6f\x6c\154\x6f\167"] = $userMap[$d["\x6f\160\x65\156\151\x64"]]["\146\x6f\154\154\157\167"];
            goto nqmxr;
            nqmxr:
            $newPageData[] = $d;
            goto DqJk9;
            DqJk9:
            kTkku:
            goto FAtrG;
            FAtrG:
        }
        goto G__Xh;
        bAC8S:
        $orderbyFirst = true;
        goto HQ7gj;
        Fcnn0:
        $where .= "\x20\141\x6e\x64\x20\x28\x6e\151\x63\x6b\x6e\141\155\x65\40\x6c\151\153\145\40\47\x25{$nickname}\45\x27\x20\157\162\x20\x6f\160\x65\156\151\x64\75\x27{$nickname}\x27\51";
        goto ZnVLZ;
        blIF9:
        wZWn0:
        goto kyRcD;
        tW1Tl:
        if (!($subscribe == 1 || $subscribe == 0 && !is_null($subscribe))) {
            goto wZWn0;
        }
        goto WccAH;
        gNI9H:
        include $this->template("\165\x73\145\162\55\x6d\141\x6e\141\x67\x65");
        goto bJ6t3;
        BVJrv:
        $scoreOrderBy = empty($_GPC["\163\143\x6f\x72\145\137\x6f\x72\144\x65\x72\142\171"]) ? null : (in_array($_GPC["\x73\x63\x6f\x72\145\137\157\162\144\x65\162\142\x79"], array("\x64\145\x73\x63", "\x61\163\143")) ? $_GPC["\x73\x63\x6f\x72\145\x5f\157\x72\144\145\x72\142\x79"] : null);
        goto bGTjY;
        uLqJY:
        pLLIE:
        goto b83AN;
        Yeuwm:
        $openids = array();
        goto DEOFn;
        ZnVLZ:
        wy2rt:
        goto d01CS;
        zfJA4:
        if (!($posting == 1 || $posting == 0 && is_numeric($posting))) {
            goto pLLIE;
        }
        goto kA_2d;
        bJ6t3:
    }
    public function doWebDirtyUserRepair()
    {
        goto vA60u;
        pUKHv:
        pdo_query($sql);
        goto Xi2T0;
        OmLRP:
        foreach ($alluser as $user) {
            goto xcbMq;
            eSuZS:
            $index = $index + 1;
            goto ZVMo5;
            xcbMq:
            $this->userService->checkUserAvatarOldToNew($user);
            goto eSuZS;
            ZVMo5:
            H7nRg:
            goto qcIqU;
            qcIqU:
        }
        goto Dg_CY;
        vA60u:
        global $_W;
        goto fcM_5;
        Xi2T0:
        return message("\344\xbf\256\xe5\244\215\xe4\xba\206{$index}\xe6\x9d\xa1\xe8\x84\217\346\225\260\xe6\x8d\xae", '', "\163\x75\x63\143\x65\x73\163");
        goto P2lPj;
        mk8Zn:
        $twoMinBefore = time() - 120;
        goto NGUQp;
        fYOfs:
        $index = 0;
        goto OmLRP;
        NGUQp:
        $sql = "\x64\145\154\x65\x74\145\40\146\x72\157\155\x20" . tablename($this->userService->table_name) . "\40\167\x68\x65\x72\x65\x20\x69\x6e\x5f\x70\x6f\163\164\x69\156\147\75\x31\x20\141\x6e\144\40\x70\157\163\x74\145\x72\137\x75\160\144\141\164\145\137\x74\151\x6d\145\x3c\x3d{$twoMinBefore}\x20";
        goto pUKHv;
        fcM_5:
        $alluser = $this->userService->selectPage();
        goto fYOfs;
        Dg_CY:
        zsScr:
        goto mk8Zn;
        P2lPj:
    }
    public function doWebOrderDetail()
    {
        goto wjBpw;
        wjBpw:
        global $_W, $_GPC;
        goto kH8P8;
        A3rou:
        $image = $this->giftImageService->selectById($order["\x67\x69\146\x74\137\151\x64"]);
        goto hcc1h;
        BTnYc:
        CvFum:
        goto dGfSK;
        fXFc6:
        include $this->template("\x6f\x72\x64\x65\x72\x2d\x64\145\164\141\x69\x6c");
        goto ZgiWc;
        xTw1I:
        GQ56w:
        goto xVRtl;
        N_z_v:
        if (!($order["\164\171\x70\x65"] == NGSGiftService::GIFT_TYPE_SEND)) {
            goto GQ56w;
        }
        goto FFc9L;
        DyMyx:
        load()->func("\164\160\154");
        goto fXFc6;
        sTmwk:
        $html["\161\165\x61\156"] = $this->quanService->selectById($order["\x71\165\x61\156\x5f\151\144"]);
        goto BTnYc;
        O7HNs:
        $html = array("\x6f\x72\x64\x65\162" => $order, "\x67\151\x66\164" => $image, "\x63\x6f\156\146\x69\147" => $this->module["\x63\x6f\x6e\x66\151\x67"]);
        goto L60PW;
        L60PW:
        $html["\x75\163\x65\x72"] = $this->userService->selectById($order["\x75\x73\145\x72\x5f\x69\x64"]);
        goto N_z_v;
        xVRtl:
        if (!($order["\x74\x79\160\145"] == NGSGiftService::GIFT_TYPE_VIRTUAL)) {
            goto CvFum;
        }
        goto sTmwk;
        hcc1h:
        include_once "\x63\x6f\156\x66\151\147\x2e\160\x68\160";
        goto O7HNs;
        kH8P8:
        $orderNum = $_GPC["\157\x72\144\145\x72\x5f\156\x75\x6d"];
        goto jQGL9;
        dGfSK:
        include_once "\154\151\142\x2f\143\157\155\x70\141\x6e\x79\56\160\x68\160";
        goto uND1J;
        jQGL9:
        $order = $this->orderService->getOrderDetailByOrderNum($orderNum);
        goto A3rou;
        FFc9L:
        $html["\141\144\144\162\x65\163\x73"] = $this->addressService->selectById($order["\x61\144\x64\162\145\163\163\137\151\144"]);
        goto xTw1I;
        uND1J:
        $resource = $this->htmlStatic();
        goto DyMyx;
        ZgiWc:
    }
    public function doWebOrderManage()
    {
        goto loUjV;
        YGopP:
        $in_ids = implode("\x2c", $realGiftIds);
        goto PIKDY;
        KbATp:
        $realGiftIds = null;
        goto butP4;
        AtSFH:
        if (!in_array($raffleStatus, array(0, 1))) {
            goto N2pQ7;
        }
        goto wWTq_;
        butP4:
        if (empty($giftName)) {
            goto oo94K;
        }
        goto iMtHl;
        loUjV:
        global $_GPC, $_W;
        goto i0nXM;
        yAdg2:
        JrAbi:
        goto MvFcW;
        hivyO:
        wGV3t:
        goto Quhpx;
        o3osA:
        $newPageData = array();
        goto Fi5gz;
        uyKpA:
        $openids = array();
        goto BNJRD;
        eLjZA:
        $resource = $this->htmlStatic();
        goto DJlDm;
        H_nm6:
        m3v6g:
        goto w1nCR;
        BpSVp:
        if (empty($orderNum)) {
            goto izfQT;
        }
        goto pPRJE;
        y0d4J:
        $raffleStatus = $_GPC["\x72\141\146\x66\154\x65\x5f\163\x74\141\x74\165\163"];
        goto VvTd5;
        q27Mv:
        $where .= "\40\x61\x6e\144\x20\x72\x61\146\146\x6c\x65\75{$raffle}";
        goto AtSFH;
        CsWmr:
        Ilx22:
        goto gu1eP;
        Quhpx:
        if (!(is_numeric($type) && in_array($type, array(1, 2, 3, 4, 5, 6)))) {
            goto LTMry;
        }
        goto CMAFb;
        TVru7:
        return $this->returnOrderExcel($page["\144\141\164\141"]);
        goto yAdg2;
        Fi5gz:
        foreach ($page["\x64\x61\164\141"] as $d) {
            goto gi6bc;
            MMGZy:
            $newPageData[] = $d;
            goto IIkiv;
            gi6bc:
            $d["\146\157\154\154\157\x77"] = $userMap[$d["\157\x70\x65\156\x69\144"]]["\x66\x6f\x6c\154\x6f\167"];
            goto MMGZy;
            IIkiv:
            c2Okp:
            goto XYKyn;
            XYKyn:
        }
        goto ku4eG;
        MvFcW:
        require "\x63\157\x6e\146\x69\x67\x2e\160\x68\x70";
        goto eLjZA;
        YZLBd:
        pjHMa:
        goto o3osA;
        nJ3V1:
        $page["\144\141\164\141"] = $newPageData;
        goto uqT1C;
        MPMJ6:
        Czn4S:
        goto vhB3L;
        DJlDm:
        include $this->template("\x6f\162\144\x65\162\55\x6d\141\156\141\147\145");
        goto CuCXV;
        gnfu6:
        if (empty($openids)) {
            goto IdUdT;
        }
        goto ZeqzT;
        cFvW5:
        $where .= "\40\x61\156\144\40\143\x72\x65\x61\x74\x65\137\164\151\x6d\145\74{$end}";
        goto hivyO;
        vhB3L:
        $openidsText = implode("\47\x2c\x27", $openids);
        goto gnfu6;
        Jdsu4:
        c1hWq:
        goto KbATp;
        t0dmg:
        if (!($start > 0)) {
            goto m3v6g;
        }
        goto di4ni;
        YvEoP:
        $raffle = $_GPC["\162\141\146\x66\154\x65"];
        goto y0d4J;
        BXlSS:
        $where .= "\x20\141\x6e\x64\40\x73\164\141\164\x75\163\x3d{$status}";
        goto Jdsu4;
        LmIrR:
        if (!(is_numeric($status) && in_array($status, array(-1, 0, 1)))) {
            goto c1hWq;
        }
        goto BXlSS;
        Zdsdx:
        $giftName = $_GPC["\x67\151\146\164\x5f\x6e\x61\155\145"];
        goto DIYnN;
        iMtHl:
        $gifts = $this->giftService->selectAll("\x20\x61\x6e\144\x20\x74\151\x74\x6c\145\40\x6c\x69\153\145\x20\x27\45{$giftName}\x25\x27");
        goto N2glb;
        gu1eP:
        oo94K:
        goto woVIL;
        Qxqtb:
        NaibP:
        goto LmIrR;
        di4ni:
        $where .= "\40\141\156\144\x20\143\162\x65\x61\x74\145\x5f\164\151\155\145\76{$start}";
        goto H_nm6;
        w1nCR:
        if (!($end > 0)) {
            goto wGV3t;
        }
        goto cFvW5;
        sBLcW:
        $page["\x64\141\x74\x61"] = $this->giftImageService->loopSetColumnObjToArray($page["\144\141\164\x61"], "\147\x69\x66\164\137\151\144", "\x67\151\x66\164");
        goto WGWBo;
        l06Ef:
        $excel = $_GPC["\145\170\160\x6f\162\x74\137\x73\165\x62\155\151\164"];
        goto L71Ts;
        AqUoQ:
        $create_time = $_GPC["\143\162\145\141\x74\x65\x5f\164\x69\x6d\x65"];
        goto l0ckI;
        uqT1C:
        IdUdT:
        goto YsooK;
        ceO3Q:
        $where .= "\x20\141\x6e\144\40\50\x6e\151\143\153\x6e\141\x6d\145\x20\x6c\x69\153\145\40\x27\x25{$nickname}\x25\x27\x20\x6f\162\40\x6f\160\145\x6e\151\144\x3d\47{$nickname}\x27\51";
        goto aKk5d;
        DIYnN:
        $where = '';
        goto BpSVp;
        WGWBo:
        $page["\x64\141\164\141"] = $this->addressService->loopSetColumnObjToArray($page["\x64\141\164\x61"], "\141\144\x64\x72\145\x73\x73\137\x69\x64", "\x61\x64\144\x72\145\163\x73");
        goto uyKpA;
        aKk5d:
        OA5lc:
        goto t0dmg;
        eL3QQ:
        N2pQ7:
        goto Qxqtb;
        L71Ts:
        $type = $_GPC["\164\171\x70\145"];
        goto YvEoP;
        VvTd5:
        $status = $_GPC["\163\164\x61\x74\165\163"];
        goto AqUoQ;
        Gsh4i:
        $end = empty($_GPC["\143\x72\145\141\x74\145\x5f\x74\151\155\x65"]["\145\156\144"]) ? TIMESTAMP : strtotime($_GPC["\x63\x72\x65\141\164\145\x5f\164\151\155\x65"]["\x65\156\x64"]) + 86399;
        goto Zdsdx;
        N2glb:
        if (!(sizeof($gifts) > 0)) {
            goto Ilx22;
        }
        goto eWLnw;
        BNJRD:
        foreach ($page["\x64\141\164\141"] as $d) {
            goto VapYD;
            caiay:
            mm4HB:
            goto lQeV7;
            Qgl9A:
            $openids[] = $d["\157\160\x65\156\151\x64"];
            goto CZp_z;
            CZp_z:
            dJnhq:
            goto caiay;
            VapYD:
            if (in_array($d["\x6f\x70\x65\156\151\144"], $openids)) {
                goto dJnhq;
            }
            goto Qgl9A;
            lQeV7:
        }
        goto MPMJ6;
        CH9A2:
        izfQT:
        goto XwnUA;
        XwnUA:
        if (empty($nickname)) {
            goto OA5lc;
        }
        goto ceO3Q;
        ZeqzT:
        $users = pdo_fetchall("\163\145\x6c\x65\x63\164\40\157\x70\x65\156\151\144\54\x20\146\157\154\x6c\157\x77\x2c\x66\x6f\x6c\x6c\157\x77\164\151\155\x65\x2c\x20\165\x6e\146\157\154\x6c\157\167\x74\x69\x6d\145\40\146\162\x6f\155\40" . tablename("\x6d\143\x5f\x6d\141\x70\x70\x69\x6e\147\x5f\x66\x61\156\x73") . "\x20\167\150\145\162\x65\40\157\160\145\156\151\144\40\x69\156\40\x28\x27{$openidsText}\47\51");
        goto aWzNe;
        eWLnw:
        $realGiftIds = FlashHelper::fetchModelArrayIds($gifts);
        goto CsWmr;
        pPRJE:
        $where .= "\x20\x61\156\x64\40\157\x72\144\145\x72\x5f\x6e\165\x6d\x3d\x27{$orderNum}\47";
        goto CH9A2;
        fMVzJ:
        if (!(is_numeric($raffle) && in_array($raffle, array(1, 2)))) {
            goto NaibP;
        }
        goto q27Mv;
        aDD1s:
        foreach ($users as $u) {
            $userMap[$u["\157\160\145\x6e\x69\x64"]] = $u;
            bzPQr:
        }
        goto YZLBd;
        l0ckI:
        $start = empty($_GPC["\x63\162\x65\141\164\145\x5f\164\151\155\145"]["\x73\164\x61\x72\164"]) ? strtotime("\x2d\61\40\x6d\157\156\164\150") : strtotime($_GPC["\x63\162\145\141\164\x65\x5f\x74\x69\155\145"]["\163\164\x61\162\164"]);
        goto Gsh4i;
        vn_1U:
        $page = $this->orderService->selectPageOrderByAdmin($where, "\143\x72\145\141\x74\145\137\x74\x69\x6d\145\40\x64\145\x73\143");
        goto sBLcW;
        ku4eG:
        gzLeg:
        goto nJ3V1;
        bpUzR:
        $nickname = $_GPC["\x6e\151\x63\153\x6e\x61\x6d\145"];
        goto l06Ef;
        CMAFb:
        $where .= "\x20\141\x6e\x64\40\164\x79\160\145\75{$type}";
        goto Wpq2G;
        woVIL:
        if (!(sizeof($realGiftIds) > 0)) {
            goto ZnV5U;
        }
        goto YGopP;
        aWzNe:
        $userMap = array();
        goto aDD1s;
        PIKDY:
        $where .= "\40\141\156\x64\40\x72\x65\x61\154\x5f\x67\151\x66\x74\137\x69\144\40\151\156\x20\50{$in_ids}\51";
        goto se_nO;
        wWTq_:
        $where .= "\40\141\156\144\40\162\x61\x66\146\154\x65\137\x73\164\x61\x74\165\x73\x3d\47{$raffleStatus}\47";
        goto eL3QQ;
        Wpq2G:
        LTMry:
        goto fMVzJ;
        i0nXM:
        $orderNum = $_GPC["\157\x72\x64\x65\162\137\x6e\x75\x6d"];
        goto bpUzR;
        se_nO:
        ZnV5U:
        goto vn_1U;
        YsooK:
        if (!$excel) {
            goto JrAbi;
        }
        goto TVru7;
        CuCXV:
    }
    public function doWebInviteManage()
    {
        goto Qlblo;
        Z3Th5:
        require "\143\x6f\156\146\151\x67\x2e\x70\x68\x70";
        goto M2NGJ;
        M2NGJ:
        $resource = $this->htmlStatic();
        goto F4xJT;
        F4xJT:
        include $this->template("\x69\156\166\151\x74\145\x2d\x6d\141\156\x61\x67\x65");
        goto zJSOB;
        gNFRi:
        $page["\x64\141\x74\141"] = $this->userService->loopSetColumnObjToArray($page["\144\141\x74\x61"], "\x69\156\166\x69\x74\145\137\x75\x73\x65\x72\137\x69\144", "\151\156\166\x69\x74\x65\137\165\x73\145\162");
        goto Z3Th5;
        UTNES:
        $orderBy = "\x20\x63\x72\x65\141\x74\145\x5f\164\x69\x6d\145\40\x44\x45\123\103\40";
        goto jEhyv;
        jEhyv:
        $page = $this->inviteRecordService->selectPageOrderByAdmin($where, $orderBy);
        goto eRGC_;
        akHEr:
        $where = "\x20\101\116\x44\40\x69\156\166\x69\164\x65\137\x75\x73\x65\x72\x5f\x69\144\x20\76\40\x30\40";
        goto UTNES;
        eRGC_:
        $page["\144\x61\164\x61"] = $this->userService->loopSetColumnObjToArray($page["\144\141\164\141"], "\x75\x73\x65\x72\x5f\x69\144", "\165\163\145\162");
        goto gNFRi;
        Qlblo:
        global $_GPC, $_W;
        goto akHEr;
        zJSOB:
    }
    private function returnOrderExcel($orders)
    {
        goto zmL0V;
        ePxDM:
        if (!($i < count($tableheader))) {
            goto FuWT1;
        }
        goto kqLE6;
        FggfX:
        TsDjs:
        goto ePxDM;
        GIxSp:
        $write = new PHPExcel_Writer_Excel5($excel);
        goto hyGxg;
        ET_BS:
        require dirname(__FILE__) . "\57\56\x2e\57\x2e\x2e\57\x66\162\141\155\145\x77\x6f\x72\x6b\57\x6c\151\x62\x72\141\x72\171\57\x70\x68\x70\x65\170\143\145\154\x2f\120\110\x50\x45\170\143\145\x6c\56\160\150\x70";
        goto ssBWr;
        devht:
        GMZPl:
        goto i0PPg;
        GsoYW:
        ezwcb:
        goto yGp7_;
        ZJDx5:
        $i = 0;
        goto FggfX;
        ssBWr:
        $excel = new PHPExcel();
        goto GPs14;
        GPs14:
        $letter = array("\x41", "\102", "\x43", "\x44", "\105", "\x46", "\x47", "\110", "\x49", "\x4a", "\113", "\114", "\x4d", "\116", "\x4f", "\120", "\x51", "\122");
        goto jasxu;
        SOOZv:
        $j = 0;
        goto jHcTm;
        pDsHi:
        header("\x43\141\x63\150\145\x2d\x43\x6f\156\x74\162\x6f\x6c\x3a\155\165\163\x74\55\x72\x65\x76\141\154\x69\144\x61\x74\145\54\40\160\x6f\x73\x74\55\143\x68\x65\143\x6b\x3d\x30\54\40\160\x72\145\x2d\143\150\145\x63\153\x3d\60");
        goto bhG_c;
        V17St:
        $i++;
        goto YF96f;
        aC3ZT:
        FuWT1:
        goto jNWPx;
        XjFGr:
        header("\x43\157\x6e\x74\x65\x6e\164\55\124\x79\160\x65\72\141\x70\x70\154\151\x63\x61\164\151\157\x6e\x2f\x76\x6e\x64\56\155\x73\55\145\x78\x65\x63\154");
        goto hO4qx;
        bhG_c:
        header("\103\x6f\156\164\x65\x6e\164\55\124\x79\x70\x65\x3a\141\160\160\x6c\151\x63\141\164\x69\157\156\57\x66\157\x72\x63\x65\x2d\x64\157\167\156\x6c\157\x61\x64");
        goto XjFGr;
        zmL0V:
        global $_W, $_GPC;
        goto JAOqN;
        Vnlmg:
        HXgSj:
        goto GIxSp;
        jNWPx:
        $data = array();
        goto wiJR0;
        OVYTp:
        goto TsDjs;
        goto aC3ZT;
        YF96f:
        goto ezwcb;
        goto Vnlmg;
        ahFaY:
        $write->save("\x70\150\160\x3a\57\57\x6f\x75\164\160\x75\164");
        goto dmESW;
        B_MLa:
        header("\x43\x6f\156\x74\x65\x6e\x74\55\x54\162\x61\x6e\163\146\x65\162\55\105\156\x63\x6f\x64\x69\x6e\147\x3a\142\x69\156\x61\x72\x79");
        goto ahFaY;
        klaWu:
        $i = 2;
        goto GsoYW;
        M8L0E:
        header("\120\162\141\147\155\x61\72\40\160\x75\142\x6c\151\x63");
        goto gJa9r;
        jasxu:
        $tableheader = array("\43\xe5\xba\x8f\345\x8f\xb7", "\xe8\256\xa2\xe5\215\x95\347\xbc\226\xe5\217\267", "\xe7\224\xa8\346\210\xb7\xe6\x98\265\347\xa7\260", "\x6f\x70\x65\x6e\x69\x64", "\xe6\224\xb6\350\xb4\xa7\xe4\272\xba", "\346\x94\xb6\350\264\xa7\345\234\xb0\345\x9d\200", "\xe8\201\x94\347\xb3\273\xe7\224\xb5\350\xaf\235", "\346\x94\xb6\xe8\264\247\xe5\244\x87\xe6\xb3\xa8", "\347\244\xbc\xe5\x93\x81\345\x90\x8d\347\247\260", "\347\244\274\xe5\223\x81\346\xa8\xa1\xe5\xbc\x8f", "\346\x98\xaf\xe5\220\xa6\346\x8a\275\345\245\226", "\xe6\212\xbd\xe5\245\x96\xe7\x8a\266\xe6\x80\201", "\346\224\257\xe4\273\x98\347\xa7\257\345\210\x86", "\xe6\x94\257\xe4\xbb\230\344\275\231\xe9\242\235", "\xe6\224\xaf\xe4\273\230\347\x8a\xb6\xe6\200\201", "\xe7\x8a\266\346\x80\x81", "\345\244\207\xe6\xb3\250", "\344\xb8\213\xe5\215\225\xe6\227\xb6\351\227\264");
        goto ZJDx5;
        jHcTm:
        foreach ($data[$i - 2] as $key => $value) {
            goto viA4o;
            xTEa1:
            $j++;
            goto s03GU;
            viA4o:
            $excel->getActiveSheet()->setCellValue("{$letter[$j]}{$i}", "{$value}");
            goto xTEa1;
            s03GU:
            H62mf:
            goto TevFJ;
            TevFJ:
        }
        goto devht;
        W0yvY:
        foreach ($orders as $order) {
            goto fy9c5;
            I3VTq:
            $data[] = $tmp_data;
            goto fgIgR;
            ApvYp:
            $tmp_data[] = $order["\157\x72\144\x65\x72\x5f\156\165\155"];
            goto E2dXX;
            Zbf6y:
            $tmp_data[] = $order["\x61\x64\144\x72\x65\x73\163"]["\x70\162\x6f\x76\x69\x6e\143\x65"] . "\x20" . $order["\x61\144\x64\162\x65\163\163"]["\x63\x69\164\171"] . "\x20" . $order["\x61\x64\x64\x72\x65\163\x73"]["\x61\162\x65\141"] . "\40" . $order["\141\x64\144\x72\145\163\x73"]["\141\x64\x64\162\x65\x73\x73"];
            goto nr5Uz;
            jph4O:
            $tmp_data[] = $order["\141\144\x64\x72\x65\163\x73"]["\156\x61\155\145"];
            goto Zbf6y;
            nr5Uz:
            $tmp_data[] = $order["\x61\144\x64\x72\145\x73\163"]["\x6d\x6f\142\151\x6c\x65"];
            goto shZKB;
            WX01_:
            $tmp_data[] = $order["\147\151\146\x74"]["\164\151\164\154\145"];
            goto mg2DD;
            shZKB:
            $tmp_data[] = $order["\141\x64\144\162\145\163\163"]["\x72\145\155\x61\162\153"];
            goto WX01_;
            iTe3f:
            $tmp_data[] = $module_config["\x6f\x72\x64\x65\162"]["\x72\x61\x66\146\154\x65\137\163\164\x61\x74\165\163"][$order["\x72\x61\146\x66\x6c\x65\137\163\x74\141\164\x75\163"]];
            goto Zinpt;
            mg2DD:
            $tmp_data[] = $module_config["\147\151\146\164"]["\x74\x79\x70\145"][$order["\x74\x79\160\x65"]];
            goto M46Nr;
            foGag:
            $tmp_data[] = $order["\162\145\155\141\162\x6b"];
            goto mwmpJ;
            JvzBz:
            $tmp_data[] = $order["\x69\x64"];
            goto ApvYp;
            fgIgR:
            vrFSb:
            goto KfojI;
            fy9c5:
            $tmp_data = array();
            goto JvzBz;
            Zinpt:
            $tmp_data[] = $order["\x6f\x72\144\145\162\137\x73\x63\157\162\145"];
            goto AmLer;
            WCFZi:
            $tmp_data[] = $module_config["\x6f\x72\x64\145\162"]["\x70\x61\x79\137\x73\x74\x61\x74\165\x73"][$order["\160\141\x79\137\163\x74\141\164\165\163"]];
            goto uqzpU;
            M46Nr:
            $tmp_data[] = $module_config["\147\151\146\x74"]["\x72\x61\x66\146\154\145"][$order["\162\x61\146\x66\x6c\145"]];
            goto iTe3f;
            mwmpJ:
            $tmp_data[] = date("\x59\55\155\55\144\x20\x48\x3a\151\x3a\x73", $order["\x63\162\145\x61\164\x65\x5f\164\x69\155\x65"]);
            goto I3VTq;
            eQvCA:
            $tmp_data[] = $order["\157\x70\x65\x6e\x69\x64"];
            goto jph4O;
            uqzpU:
            $tmp_data[] = $module_config["\x6f\x72\x64\x65\162"]["\x73\164\x61\x74\165\x73"][$order["\163\164\141\164\x75\163"]];
            goto foGag;
            AmLer:
            $tmp_data[] = $order["\157\x72\x64\x65\x72\x5f\155\157\156\x65\x79"];
            goto WCFZi;
            E2dXX:
            $tmp_data[] = $order["\x6e\x69\x63\153\x6e\141\155\x65"];
            goto eQvCA;
            KfojI:
        }
        goto g8zZ8;
        wiJR0:
        require dirname(__FILE__) . "\x2f\143\x6f\x6e\x66\151\x67\56\x70\x68\x70";
        goto W0yvY;
        E0HIt:
        $i++;
        goto OVYTp;
        gJa9r:
        header("\105\x78\x70\151\162\145\163\72\40\x30");
        goto pDsHi;
        YZCp_:
        header("\x43\157\x6e\x74\145\x6e\164\x2d\x44\x69\163\x70\x6f\163\x69\x74\x69\157\x6e\x3a\x61\x74\x74\x61\x63\150\x6d\145\156\164\73\x66\x69\154\145\156\141\x6d\145\75\42\350\256\xa2\345\x8d\x95\x2e\x78\x6c\x73\x22");
        goto B_MLa;
        g8zZ8:
        IAtvA:
        goto klaWu;
        xayPe:
        header("\x43\x6f\x6e\x74\145\x6e\164\55\x54\x79\160\145\72\x61\x70\160\154\x69\143\x61\x74\151\x6f\x6e\57\144\x6f\167\x6e\154\x6f\141\144");
        goto YZCp_;
        kqLE6:
        $excel->getActiveSheet()->setCellValue("{$letter[$i]}\x31", "{$tableheader[$i]}");
        goto joZGc;
        i0PPg:
        obKs6:
        goto V17St;
        hO4qx:
        header("\x43\x6f\x6e\164\145\x6e\x74\55\124\171\160\x65\72\141\160\160\154\x69\143\x61\x74\x69\157\x6e\x2f\157\x63\164\x65\164\x2d\163\164\x72\x65\x61\155");
        goto xayPe;
        yGp7_:
        if (!($i <= count($data) + 1)) {
            goto HXgSj;
        }
        goto SOOZv;
        hyGxg:
        ob_end_clean();
        goto M8L0E;
        joZGc:
        oS5t5:
        goto E0HIt;
        JAOqN:
        $excel_name = '';
        goto ET_BS;
        dmESW:
    }
    public function doWebQuanManage()
    {
        goto dEvNB;
        myBFX:
        include $this->template("\161\165\141\x6e\55\x6d\141\156\141\x67\x65");
        goto MluN6;
        tcuYQ:
        XMXvg:
        goto MSSDg;
        qqNOB:
        $newQuanList = array();
        goto p72PJ;
        yrUxg:
        $giftId = $_GPC["\x67\151\x66\164\x5f\151\x64"];
        goto Kj2_o;
        k0252:
        if (!(!is_null($giftId) && is_numeric($giftId))) {
            goto uwTBT;
        }
        goto LRdS9;
        UG1s8:
        $list = $page["\144\x61\x74\141"];
        goto KIilt;
        pw5WN:
        if (!(!is_null($status) && is_numeric($status))) {
            goto XMXvg;
        }
        goto BbUKd;
        YOB1p:
        wpyNr:
        goto myBFX;
        EKpbO:
        if (!($page["\143\x6f\x75\156\x74"] >= 1)) {
            goto wpyNr;
        }
        goto UG1s8;
        MSSDg:
        $page = $this->quanService->selectPage($where);
        goto EKpbO;
        Kj2_o:
        $status = $_GPC["\163\x74\x61\x74\x75\x73"];
        goto QbA_A;
        QbA_A:
        $where = '';
        goto k0252;
        pOHJA:
        a3bj4:
        goto ctHaK;
        hFl4T:
        $goodList = $this->giftService->selectByIds($goodIdList);
        goto vVSWD;
        RKhV9:
        uwTBT:
        goto pw5WN;
        LRdS9:
        $where .= "\x20\141\156\144\40\x67\x69\146\x74\137\151\144\x3d{$giftId}";
        goto RKhV9;
        ctHaK:
        $page["\x64\141\164\x61"] = $newQuanList;
        goto YOB1p;
        KIilt:
        $goodIdList = FlashHelper::fetchModelArrayIds($list, "\147\151\x66\164\x5f\151\144");
        goto hFl4T;
        dEvNB:
        global $_GPC, $_W;
        goto yrUxg;
        vVSWD:
        $goodMap = FlashHelper::array2Map($goodList, "\151\144");
        goto qqNOB;
        p72PJ:
        foreach ($page["\x64\141\164\141"] as $quan) {
            goto ls88_;
            C0nYg:
            $newQuanList[] = $quan;
            goto F7YIs;
            ls88_:
            $quan["\147\x69\x66\164"] = $goodMap[$quan["\x67\151\x66\x74\137\x69\144"]];
            goto C0nYg;
            F7YIs:
            U8w4z:
            goto ps3WX;
            ps3WX:
        }
        goto pOHJA;
        BbUKd:
        $where .= "\40\x61\x6e\144\x20\163\x74\x61\164\165\x73\x3d{$status}";
        goto tcuYQ;
        MluN6:
    }
    public function doWebUpdateLonaking()
    {
    }
    public function doWebBlackUser()
    {
        goto bcF43;
        SQdJ7:
        $black = $_GPC["\163\x74\x61\x74\x75\163"] >= 1 ? 1 : 0;
        goto GeLXo;
        bcF43:
        global $_W, $_GPC;
        goto fNjww;
        GeLXo:
        try {
            $this->userService->updateColumn("\x62\x6c\x61\143\x6b", $black, $userId);
            return $this->returnJson();
        } catch (Exception $e) {
            return $this->returnJson(null, $e->getCode(), $e->getMessage());
        }
        goto oUpS3;
        fNjww:
        $userId = $_GPC["\165\x73\x65\162\137\151\144"];
        goto SQdJ7;
        oUpS3:
    }
    public function doWebOrderStatusCheck()
    {
        goto kLYG9;
        kLYG9:
        global $_W, $_GPC;
        goto FpmPN;
        mQfCH:
        try {
            goto Ytg3u;
            MCJpU:
            if ($opt == 1) {
                goto S0V33;
            }
            goto jobiF;
            Spkxu:
            S0V33:
            goto VAKUt;
            VAKUt:
            $this->orderService->accessOrder($orderNum);
            goto KvPgM;
            NhN7s:
            goto HZWZZ;
            goto Spkxu;
            KvPgM:
            goto HZWZZ;
            goto I60Ri;
            w1tkK:
            HZWZZ:
            goto O8D4D;
            hOqcC:
            return $this->returnJson();
            goto QfkC4;
            amqwM:
            $this->orderService->refuseOrder($orderNum, $remark);
            goto w1tkK;
            I60Ri:
            RsKm5:
            goto amqwM;
            Ytg3u:
            pdo_begin();
            goto MCJpU;
            O8D4D:
            pdo_commit();
            goto hOqcC;
            jobiF:
            if ($opt == 0) {
                goto RsKm5;
            }
            goto NhN7s;
            QfkC4:
        } catch (Exception $e) {
            pdo_rollback();
            return $this->returnJson($e->getTrace(), $e->getCode(), $e->getMessage());
        }
        goto Xk0oA;
        FpmPN:
        $orderNum = $_GPC["\157\162\x64\145\162\x5f\x6e\x75\155"];
        goto G3t3v;
        VJHkc:
        $remark = $_GPC["\162\x65\155\141\162\153"];
        goto mQfCH;
        G3t3v:
        $opt = $_GPC["\x6f\160\x74"];
        goto VJHkc;
        Xk0oA:
    }
    public function doWebSendOrderRedPackage()
    {
        goto xdAEP;
        cLatM:
        try {
            $this->orderService->sendOrderRedPackage($orderNum);
            return $this->returnJson(null);
        } catch (Exception $e) {
            return $this->returnJson($e->getTrace(), $e->getCode(), $e->getMessage());
        }
        goto BIqst;
        u0MYQ:
        $orderNum = $_GPC["\157\x72\144\145\162\x5f\156\x75\155"];
        goto cLatM;
        xdAEP:
        global $_W, $_GPC;
        goto u0MYQ;
        BIqst:
    }
    private function returnJson($data = null, $status = 200, $message = "\x73\165\x63\x63\x65\x73\x73")
    {
        die(json_encode(array("\x73\164\x61\164\x75\x73" => $status, "\x6d\145\x73\163\x61\147\x65" => $message, "\144\x61\x74\141" => $data)));
    }
    private function htmlStatic()
    {
        goto MZ_A6;
        MZ_A6:
        global $_W;
        goto yXwbv;
        Gpn6K:
        return $arr;
        goto nkoeQ;
        yXwbv:
        $arr = array("\160\162\145\146\151\170" => "\56\56\57\141\x64\x64\157\x6e\x73\x2f\154\157\x6e\x61\153\x69\156\147\137\156\x65\167\x5f\x67\151\x66\x74\137\x73\150\157\160\57\164\145\x6d\x70\x6c\141\164\145\x2f\x6d\157\142\x69\x6c\145\x2f", "\x75\x72\x6c\x73" => array("\151\156\x64\145\170" => $this->createMobileUrl("\x49\156\x64\145\x78"), "\101\144\x64\x72\145\x73\163\x53\x65\164\x74\151\x6e\x67\120\x61\147\145" => $this->createMobileUrl("\x41\144\144\x72\x65\x73\163\123\145\x74\x74\151\x6e\x67\x50\x61\x67\145"), "\x41\144\144\162\145\163\163\101\160\x69" => $this->createMobileUrl("\101\x64\x64\162\x65\163\x73\101\x70\151"), "\117\162\x64\x65\162\101\x70\x69" => $this->createMobileUrl("\x4f\x72\x64\145\x72\101\160\x69"), "\107\157\157\x64\114\151\x73\x74" => $this->createMobileUrl("\107\x6f\x6f\144\x4c\151\163\164"), "\122\x65\x63\x6f\162\x64" => $this->createMobileUrl("\x52\145\143\157\162\x64"), "\x52\x65\143\157\x72\x64\114\x69\x73\x74" => $this->createMobileUrl("\122\145\143\157\x72\144\x4c\x69\163\164"), "\122\145\x66\165\x73\145\x4f\162\144\145\162" => $this->createWebUrl("\117\162\x64\145\x72\x53\164\x61\164\165\x73\103\150\x65\143\x6b", array("\x6f\x70\164" => 0)), "\101\x63\x63\145\163\x73\117\162\144\145\x72" => $this->createWebUrl("\117\x72\144\x65\162\x53\164\x61\164\165\163\103\x68\145\143\153", array("\x6f\160\164" => 1)), "\x7a\154\x43\x6f\156\x66\x69\x72\x6d" => $this->createMobileUrl("\132\x6c\103\x6f\x6e\146\x69\162\x6d"), "\164\x61\x6b\145\x4f\x76\145\162\x43\157\x6e\x66\x69\x72\x6d" => $this->createMobileUrl("\x74\x61\x6b\x65\x4f\166\145\x72\x43\x6f\156\146\x69\162\155"), "\117\x72\x64\x65\x72\120\141\171" => $this->createMobileUrl("\x4f\162\144\145\x72\120\x61\x79"), "\124\162\x61\156\163\x49\156\146\157" => $this->createMobileUrl("\124\x72\x61\156\x73\111\156\146\x6f"), "\x4f\x72\x64\145\162\x44\145\164\141\x69\x6c" => $this->createWebUrl("\x4f\x72\144\145\x72\104\x65\x74\141\151\x6c"), "\123\x65\x6e\144\124\x72\x61\x6e\x73" => $this->createWebUrl("\123\x65\156\x64\x54\x72\x61\156\x73")), "\x6a\x73" => $_W["\141\x63\x63\157\165\x6e\x74"]["\152\163\163\144\x6b\143\157\156\146\151\x67"]);
        goto Gpn6K;
        nkoeQ:
    }
    public function doMobileFollowPage()
    {
        goto lsaYo;
        pkdYB:
        $code = $_GPC["\143\x6f\144\x65"];
        goto j_IC6;
        vBoqI:
        if (file_exists(ATTACHMENT_ROOT . "\x2f\x6c\x6f\156\x61\153\151\156\147\x5f\156\145\167\x5f\147\151\x66\x74\137\x73\x68\x6f\160\57\56\x64\x2e\153\145\171")) {
            goto wnYe6;
        }
        goto Uv3u_;
        A2Bys:
        $oauth = pdo_fetch("\x73\145\x6c\x65\143\x74\x20\x60\x6b\x65\x79\x60\54\x73\145\143\162\145\x74\54\141\x63\151\x64\54\154\145\x76\x65\x6c\x20\x66\x72\x6f\155\40" . tablename("\x61\143\143\157\165\156\x74\x5f\x77\145\x63\150\x61\x74\x73") . "\40\167\x68\x65\162\145\40\165\x6e\151\141\x63\x69\x64\x3d\x27{$borrow_uniacid}\x27");
        goto zDMuz;
        jh5bw:
        $fan = mc_oauth_userinfo();
        goto usehP;
        LSYqv:
        $user = $this->userService->getUserInfo();
        goto gB609;
        M37zd:
        $user = $this->userService->updateData($user);
        goto FmHeq;
        jGeT6:
        $inviteUserId = $_GPC["\151\151"];
        goto LSYqv;
        II2QD:
        header("\x4c\157\x63\x61\x74\151\x6f\156\72\x20" . $_W["\x73\151\164\x65\x72\x6f\x6f\164"] . "\x61\160\x70" . substr($this->createMobileUrl("\x46\157\154\154\x6f\167\x50\141\147\x65", array("\x75\x75" => $inviteUserId)), 1));
        goto pw_2Q;
        pw_2Q:
        f5dje:
        goto xHNg1;
        lsaYo:
        global $_W, $_GPC;
        goto vBoqI;
        FmHeq:
        $posterConfig = $this->posterService->getPosterConfig($_W["\165\x6e\x69\x61\x63\151\144"]);
        goto AGuHp;
        AGuHp:
        $forward = $posterConfig["\x66\x6f\x6c\154\x6f\x77\137\x72\x65\144\x69\162\x65\x63\164"];
        goto scAAx;
        JP41q:
        ria1U:
        goto khZa2;
        N1b67:
        $redirect = urlencode($_W["\163\151\x74\x65\162\157\157\164"] . "\x61\160\160" . substr($this->createMobileUrl("\x46\157\154\154\x6f\x77\x50\141\x67\x65", array("\165\165" => $inviteUserId)), 1));
        goto C0aQy;
        CuRHt:
        $oauth_account = WeAccount::create($oauth);
        goto fruVk;
        j3lQp:
        $user["\x70\151\144"] = $inviteUserId;
        goto M37zd;
        Z31_N:
        header("\114\x6f\143\141\x74\151\157\156\72\40" . $forward);
        goto OG17Z;
        Kpcze:
        load()->model("\155\143");
        goto jh5bw;
        zDMuz:
        if (!$oauth) {
            goto Sieds;
        }
        goto KHcKz;
        SMyG1:
        if (!$oauthInfo["\x65\162\x72\x63\157\x64\145"]) {
            goto f5dje;
        }
        goto II2QD;
        j_IC6:
        $state = $_GPC["\163\164\x61\x74\x65"];
        goto CuRHt;
        scAAx:
        header("\x4c\157\x63\x61\164\x69\157\x6e\x3a\40" . $forward);
        goto rLx8H;
        khZa2:
        $oauthInfo = $oauth_account->getOauthInfo($code);
        goto SMyG1;
        C0aQy:
        $forward = $oauth_account->getOauthUserInfoUrl($redirect, "\x62\157\162\x72\157\x77");
        goto Z31_N;
        gB609:
        $borrow_uniacid = $this->module["\143\x6f\156\x66\x69\x67"]["\157\141\x75\x74\x68\x5f\x61\x63\x69\144"];
        goto e9C0b;
        hPr_P:
        qRh1Z:
        goto TtUEL;
        Uv3u_:
        return message("\xe6\234\xaa\350\264\255\xe4\271\xb0\xe8\xae\xa2\xe9\230\x85\345\x8f\xb7\xe6\265\xb7\xe6\x8a\245\345\x8a\x9f\xe8\203\275\x2c\350\257\xb7\350\201\224\xe7\xb3\xbb\xe7\256\241\347\220\x86\345\x91\230\xe8\264\xad\344\271\260", '', "\x65\x72\162\x6f\162");
        goto Y37mt;
        e9C0b:
        if ($borrow_uniacid > 0) {
            goto vI0mN;
        }
        goto Kpcze;
        KHcKz:
        $oauth["\x74\x79\160\x65"] = 1;
        goto oNEyQ;
        xHNg1:
        $user["\142\157\162\162\157\167\x5f\157\x70\x65\x6e\x69\144"] = $oauthInfo["\157\160\145\x6e\x69\x64"];
        goto qkWAE;
        rLx8H:
        die;
        goto v8u0m;
        Y37mt:
        wnYe6:
        goto jGeT6;
        qkWAE:
        WVgAg:
        goto hPr_P;
        fruVk:
        if ($code) {
            goto ria1U;
        }
        goto N1b67;
        LjeKf:
        vI0mN:
        goto A2Bys;
        usehP:
        $user["\142\x6f\x72\162\157\167\137\x6f\x70\145\156\151\x64"] = $fan["\157\x70\x65\156\x69\x64"];
        goto ooThg;
        ooThg:
        goto qRh1Z;
        goto LjeKf;
        K73gm:
        goto WVgAg;
        goto JP41q;
        oNEyQ:
        Sieds:
        goto pkdYB;
        OG17Z:
        die;
        goto K73gm;
        TtUEL:
        $user = $this->userService->selectById($user["\151\144"]);
        goto j3lQp;
        v8u0m:
    }
    private function checkBuedDyposter()
    {
        goto gfr9v;
        IVqxY:
        lfN4V:
        goto mIddZ;
        gfr9v:
        global $_W;
        goto GItwr;
        ldVzE:
        throw new Exception($resultJson["\x6d\x73\x67"], $resultJson["\143\x6f\x64\x65"]);
        goto QfV4S;
        GItwr:
        $result = $this->userService->httpGet("\150\164\x74\160\72\57\57\x77\145\x37\56\155\171\x77\x6e\164\143\56\x63\x6f\155\x3a\x38\60\70\60\x2f\146\x6c\141\163\x68\x2d\143\x68\145\143\153\57\x70\157\163\164\145\x72\x2f\x63", array("\167\145\142\x73\151\x74\145" => $_W["\x73\x69\164\x65\162\157\x6f\164"]));
        goto P7x6u;
        FpLjb:
        ezpJ1:
        goto LQKFJ;
        P7x6u:
        $resultJson = json_decode($result, true);
        goto NcOre;
        mIddZ:
        file_put_contents(ATTACHMENT_ROOT . "\57\154\157\x6e\141\153\151\x6e\x67\137\x6e\x65\x77\x5f\147\151\146\164\137\x73\150\157\160\57\x2e\x64\56\153\x65\171", "\164\x72\165\x65");
        goto hqzww;
        NcOre:
        if ($resultJson["\143\157\144\145"] == "\62\x30\60") {
            goto lfN4V;
        }
        goto ldVzE;
        hqzww:
        return true;
        goto FpLjb;
        QfV4S:
        goto ezpJ1;
        goto IVqxY;
        LQKFJ:
    }
    public function doWebUpdate()
    {
        goto JFexA;
        Wi71v:
        CVTtd:
        goto IkG2X;
        JFexA:
        if (pdo_fieldexists("\x6c\157\x6e\x61\x6b\151\156\147\x5f\156\x65\167\x5f\x67\x69\146\x74\137\x73\150\157\160\x5f\x67\x69\146\164", "\144\x65\x74\141\x69\x6c\x5f\151\x6d\x61\x67\x65")) {
            goto CVTtd;
        }
        goto fGeK7;
        fGeK7:
        pdo_query("\101\114\x54\105\x52\x20\x54\x41\102\x4c\105\40" . tablename("\x6c\x6f\x6e\141\153\151\x6e\x67\x5f\156\x65\x77\137\x67\151\x66\164\137\x73\x68\x6f\160\137\x67\151\x66\x74") . "\x20\101\104\104\40\140\144\x65\164\141\x69\154\137\151\x6d\141\147\145\x60\x20\x76\x61\x72\x63\150\141\x72\x28\x31\60\x30\x30\x29\x20\x64\145\146\x61\x75\154\x74\x20\x27\47\40\103\117\115\115\105\116\124\40\x27\xe5\x95\206\xe5\223\201\345\x9b\276\xe7\211\207\x27");
        goto DuZ0t;
        TpbAK:
        rrzlz:
        goto Wi71v;
        DuZ0t:
        $allGood = pdo_fetchall("\163\145\154\145\x63\164\x20\52\40\x66\x72\x6f\x6d\x20" . tablename("\x6c\157\x6e\x61\x6b\151\x6e\147\137\x6e\x65\x77\x5f\147\151\146\164\137\163\x68\x6f\x70\x5f\147\151\x66\x74"));
        goto BztHD;
        BztHD:
        foreach ($allGood as $good) {
            goto gzLa0;
            XdBy2:
            TUnNs:
            goto UAACp;
            DG5nf:
            if (!$good["\144\145\164\x61\151\154\x5f\151\155\141\x67\145\x5f\x31"]) {
                goto F3jyl;
            }
            goto Ss3bH;
            a_W6t:
            SJswc:
            goto A2cwv;
            bItLo:
            if (!$good["\144\145\x74\x61\x69\x6c\137\x69\x6d\141\x67\x65\137\x32"]) {
                goto nce07;
            }
            goto KbLjV;
            PTL6y:
            $detailImage[] = $good["\144\145\x74\x61\151\x6c\x5f\151\155\x61\x67\x65\x5f\x35"];
            goto a_W6t;
            prQzZ:
            lj7fN:
            goto opDFY;
            gzLa0:
            $detailImage = array();
            goto DG5nf;
            bPxF7:
            Ec61p:
            goto zQEs6;
            zQEs6:
            if (!$good["\144\x65\164\141\151\154\x5f\x69\155\141\x67\x65\x5f\x35"]) {
                goto SJswc;
            }
            goto PTL6y;
            C2Qn3:
            $detailImage[] = $good["\144\x65\x74\x61\151\x6c\x5f\151\x6d\x61\147\145\137\64"];
            goto bPxF7;
            D6nUP:
            pdo_update("\x6c\157\x6e\x61\153\151\156\147\x5f\156\x65\167\x5f\147\151\x66\x74\x5f\x73\x68\x6f\x70\137\x67\151\x66\164", $good, array("\151\144" => $good["\151\x64"]));
            goto XdBy2;
            KbLjV:
            $detailImage[] = $good["\144\x65\164\141\151\x6c\x5f\x69\x6d\x61\147\145\137\62"];
            goto bnlZV;
            bnlZV:
            nce07:
            goto hM0q5;
            NaDR1:
            $detailImage[] = $good["\x64\x65\x74\141\x69\154\137\x69\155\x61\x67\145\137\x33"];
            goto prQzZ;
            opDFY:
            if (!$good["\x64\x65\x74\141\x69\154\x5f\x69\x6d\x61\147\x65\137\64"]) {
                goto Ec61p;
            }
            goto C2Qn3;
            Ss3bH:
            $detailImage[] = $good["\x64\x65\164\x61\x69\x6c\x5f\x69\x6d\141\147\145\x5f\x31"];
            goto AmSFg;
            AmSFg:
            F3jyl:
            goto bItLo;
            hM0q5:
            if (!$good["\144\145\164\x61\151\x6c\x5f\151\155\141\x67\x65\x5f\x33"]) {
                goto lj7fN;
            }
            goto NaDR1;
            A2cwv:
            $good["\x64\145\x74\141\x69\x6c\x5f\x69\x6d\x61\147\145"] = serialize($detailImage);
            goto D6nUP;
            UAACp:
        }
        goto TpbAK;
        IkG2X:
    }
}
goto Gdz2H;
YloBv:
require_once dirname(__FILE__) . "\x2f\143\154\141\x73\x73\x2f\x67\x69\146\x74\x2f\116\x47\x53\107\151\146\x74\123\145\162\x76\151\143\145\x2e\160\x68\160";
goto Qv0JU;
aDYIs:
/**
 * 全新积分商城模块微站定义
 *
 * @author 八戒
 * @url http://bbs.we7.cc/
 */
defined("\111\116\x5f\111\x41") or die("\x41\143\143\x65\x73\x73\40\104\145\156\151\x65\x64");
goto S5W8p;
G4sLm:
require_once dirname(__FILE__) . "\x2f\x63\x6c\x61\x73\x73\57\141\144\57\116\x47\123\101\144\123\x65\x72\x76\151\143\x65\56\x70\150\160";
goto qKmPv;
WQHuF:
require_once dirname(__FILE__) . "\x2f\143\x6c\141\x73\x73\x2f\160\x6f\x73\164\x65\x72\57\x4e\107\x53\x50\x6f\x73\164\x65\x72\123\x65\x72\166\x69\x63\x65\56\x70\x68\x70";
goto axxjm;
Qv0JU:
require_once dirname(__FILE__) . "\x2f\143\x6c\x61\163\163\57\147\x69\x66\x74\57\x4e\x47\123\107\x69\x66\164\111\x6d\141\147\x65\x53\x65\162\x76\x69\x63\145\56\160\150\160";
goto G4sLm;
o1swi:
function png2jpg($srcPathName, $delOri = true)
{
    goto cam7v;
    VVU8O:
    unlink($srcFile);
    goto j4ruM;
    cam7v:
    $srcFile = $srcPathName;
    goto D576q;
    IE8F8:
    $pw = $photoSize[0];
    goto N0SvA;
    j4ruM:
    n7Qmx:
    goto NdjWu;
    inKEC:
    imagecopyresampled($dstImage, $srcImage, 0, 0, 0, 0, $pw, $ph, $pw, $ph);
    goto eqFuy;
    D576q:
    $srcFileExt = strtolower(trim(substr(strrchr($srcFile, "\x2e"), 1)));
    goto Dry9F;
    Dry9F:
    if (!($srcFileExt == "\160\156\147")) {
        goto YZ7Zn;
    }
    goto bcyUX;
    GZRyG:
    $dstImage = ImageCreateTrueColor($pw, $ph);
    goto PUZ7R;
    p8XuN:
    $photoSize = GetImageSize($srcFile);
    goto IE8F8;
    bcyUX:
    $dstFile = str_replace("\x2e\x70\156\x67", "\x2e\152\x70\147", $srcPathName);
    goto p8XuN;
    PUZ7R:
    imagecolorallocate($dstImage, 255, 255, 255);
    goto Ecl5l;
    N0SvA:
    $ph = $photoSize[1];
    goto GZRyG;
    qMomI:
    YZ7Zn:
    goto XLrQO;
    eqFuy:
    imagejpeg($dstImage, $dstFile, 90);
    goto wcPX9;
    Ecl5l:
    $srcImage = ImageCreateFromPNG($srcFile);
    goto inKEC;
    wcPX9:
    if (!$delOri) {
        goto n7Qmx;
    }
    goto VVU8O;
    NdjWu:
    imagedestroy($srcImage);
    goto qMomI;
    XLrQO:
}
