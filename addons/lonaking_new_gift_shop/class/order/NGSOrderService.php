<?php
/*
 __________________________________________________
|  Encode by BajieTeam on we7                      |
|__________________________________________________|
*/

goto QsRWL;
Xpg5o:
require_once dirname(__FILE__) . "\x2f\x2e\x2e\x2f\x61\144\x64\x72\x65\163\163\x2f\116\107\x53\x41\144\x64\162\145\x73\163\123\145\x72\166\x69\143\145\x2e\x70\150\x70";
goto GCFg7;
wZx5X:
require_once dirname(__FILE__) . "\57\56\56\57\56\56\57\x2e\56\x2f\154\157\156\x61\x6b\151\x6e\x67\137\146\154\141\x73\150\x2f\x63\x6c\141\163\x73\57\x46\154\x61\163\x68\x4c\x6f\x63\141\164\151\x6f\x6e\123\x65\162\x76\x69\143\145\x2e\160\150\160";
goto SnlBP;
QMcIg:
require_once dirname(__FILE__) . "\57\x2e\56\x2f\x68\x62\x2f\116\107\123\x48\142\123\x65\x72\x76\x69\x63\145\56\160\x68\x70";
goto c6OCG;
QsRWL:
require_once dirname(__FILE__) . "\57\56\56\57\x2e\56\x2f\56\56\57\x6c\157\156\x61\153\x69\x6e\147\137\x66\x6c\x61\x73\150\x2f\x46\154\141\163\150\103\157\155\x6d\x6f\x6e\x53\x65\162\x76\x69\143\x65\x2e\x70\150\x70";
goto wZx5X;
QRm1s:
require_once dirname(__FILE__) . "\57\x2e\56\x2f\147\x69\x66\164\x2f\116\107\123\x47\151\x66\x74\123\145\x72\x76\x69\x63\145\x2e\160\150\x70";
goto ymIEF;
SnlBP:
require_once dirname(__FILE__) . "\x2f\56\56\x2f\56\56\57\56\x2e\x2f\154\x6f\156\141\x6b\151\x6e\x67\x5f\146\x6c\141\x73\x68\57\x46\x6c\x61\163\150\x55\163\x65\162\123\145\x72\166\x69\x63\x65\x2e\x70\150\x70";
goto OpA45;
GCFg7:
require_once dirname(__FILE__) . "\x2f\56\x2e\57\147\151\146\164\57\x4e\x47\x53\x47\151\x66\x74\x52\x61\146\x66\154\x65\x53\x65\162\x76\x69\x63\145\56\x70\x68\160";
goto QMcIg;
OpA45:
require_once dirname(__FILE__) . "\x2f\x2e\x2e\57\x2e\x2e\x2f\56\56\x2f\154\x6f\x6e\141\x6b\x69\156\147\x5f\x66\154\x61\163\x68\57\143\x6c\x61\163\x73\57\106\154\141\x73\150\x4d\143\x47\162\x6f\x75\160\123\145\162\166\x69\143\x65\56\160\150\x70";
goto ElOaf;
ElOaf:
require_once dirname(__FILE__) . "\57\x2e\56\57\x75\x73\x65\x72\57\116\107\123\x55\x73\145\162\x53\145\162\166\151\x63\x65\x2e\x70\x68\x70";
goto QRm1s;
ymIEF:
require_once dirname(__FILE__) . "\x2f\x2e\x2e\57\x67\x69\146\164\57\116\x47\123\x47\x69\146\164\x49\x6d\141\147\145\x53\x65\162\166\x69\143\x65\56\x70\x68\x70";
goto Xpg5o;
c6OCG:
require_once dirname(__FILE__) . "\x2f\x2e\56\57\x71\165\141\x6e\57\x4e\x47\123\x51\x75\141\156\x53\145\x72\x76\151\x63\x65\x2e\x70\150\160";
goto QFt1x;
QFt1x:
/**
 * 异常码 48**
 * Class NGSOrderService
 */
class NGSOrderService extends FlashCommonService
{
    const ORDER_TRANS_STATUS_DEFAULT = 0;
    const ORDER_TRANS_STATUS_SEND = 1;
    const ORDER_TRANS_STATUS_RECEIVE = 2;
    const ORDER_ZL_STATUS_DEFAULT = 1;
    const ORDER_ZL_STATUS_OK = 2;
    const ORDER_HB_STATUS_NO_SEND = 1;
    const ORDER_HB_STATUS_SEND = 2;
    const ORDER_HB_STATUS_SEND_ERROR = -1;
    const ORDER_HF_STATUS_DEFAULT = 1;
    const ORDER_HF_STATUS_OK = 2;
    const ORDER_LL_STATUS_DEFAULT = 1;
    const ORDER_LL_STATUS_OK = 2;
    const ORDER_RAFFLE_SCORE_STATUS_DEFAULT = 1;
    const ORDER_RAFFLE_SCORE_STATUS_OK = 2;
    const ORDER_TRANS_FEE_STATUS_NOT_PAY = 1;
    const ORDER_TRANS_FEE_STATUS_PAID = 2;
    const ORDER_PAY_STATUS_NOT_PAY = 0;
    const ORDER_PAY_STATUS_PAID = 1;
    const ORDER_QUAN_STATUS_NOT_SEND = 1;
    const ORDER_QUAN_STATUS_SEND_OK = 2;
    const ORDER_QUAN_STATUS_USED = 3;
    const ORDER_STATUS_DEFAULT = 0;
    const ORDER_STATUS_SUCCESS = 1;
    const ORDER_STATUS_REFUSED = -1;
    const ORDER_NORMAL = 0;
    const ORDER_ABNORMAL = 1;
    const ORDER_RAFFLE_SUCCESS = 1;
    const ORDER_RAFFLE_FAIL = 0;
    private $userService;
    private $giftService;
    private $addressService;
    private $flashUserService;
    private $raffleService;
    private $hbService;
    private $quanService;
    private $noticeService;
    private $flashLocationService;
    private $flashMcGroupService;
    public function __construct()
    {
        goto CLsGS;
        BO9n9:
        $this->addressService = new NGSAddressService();
        goto meLrA;
        qKJa4:
        $this->giftImageService = new NGSGiftImageService();
        goto BO9n9;
        iIVG1:
        $this->flashMcGroupService = new FlashMcGroupService();
        goto Z9qRZ;
        cf5cV:
        $this->flashLocationService = new FlashLocationService();
        goto iIVG1;
        viYUk:
        $this->raffleService = new NGSGiftRaffleService();
        goto bBR3a;
        bBR3a:
        $this->hbService = new NGSHbService();
        goto nF8jP;
        uNlHi:
        $this->noticeService = new NGSTplService();
        goto cf5cV;
        CLsGS:
        $this->plugin_name = "\x6c\157\156\141\153\x69\x6e\x67\x5f\156\x65\x77\137\147\151\146\164\x5f\x73\x68\x6f\x70";
        goto MImkF;
        d_Htz:
        $this->columns = "\151\x64\54\165\156\x69\141\143\151\x64\54\164\x79\160\145\x2c\157\x72\144\x65\162\137\156\165\155\x2c\x75\163\x65\162\137\x69\144\x2c\x75\151\144\x2c\x6f\160\145\x6e\151\144\x2c\x6e\151\x63\x6b\x6e\x61\155\145\x2c\141\x64\144\x72\145\163\x73\x5f\x69\144\54\x72\x65\141\x6c\x5f\147\151\x66\x74\x5f\151\144\54\147\x69\146\164\137\151\144\54\x62\x75\x79\137\x74\171\x70\145\54\157\162\x64\145\162\137\163\143\x6f\x72\x65\x2c\x6f\x72\144\145\x72\137\x6d\157\x6e\x65\171\54\160\x61\x79\137\163\164\141\164\x75\163\x2c\x72\141\x66\x66\154\145\x2c\x72\x61\x66\146\154\145\137\x73\x74\141\x74\x75\163\x2c\150\142\137\141\155\157\x75\156\x74\54\150\142\137\157\160\x65\156\151\x64\54\150\x62\137\x73\164\141\x74\x75\163\54\x74\x72\141\156\x73\x5f\143\157\155\160\x61\x6e\x79\54\x74\x72\141\x6e\163\x5f\x6e\165\155\x2c\x74\x72\141\156\163\x5f\x73\164\x61\164\165\163\54\x74\x72\x61\156\x73\137\146\145\x65\x2c\x74\x72\141\156\x73\137\146\x65\145\137\x73\x74\141\164\165\x73\x2c\164\162\141\x6e\163\x5f\x63\x6f\x6e\x66\151\162\x6d\137\164\151\155\x65\x2c\x7a\x6c\x5f\x73\164\x61\x74\165\163\x2c\172\x6c\137\x74\151\x6d\x65\x2c\150\146\137\x61\x6d\x6f\x75\156\164\x2c\x68\x66\137\163\x74\141\x74\165\x73\54\x6c\x6c\137\141\155\x6f\165\x6e\x74\x2c\x6c\x6c\137\163\164\x61\x74\x75\163\54\x71\x75\x61\x6e\x5f\151\144\x2c\x71\x75\x61\156\137\x73\164\141\x74\165\x73\x2c\x72\x61\146\x66\154\x65\137\x73\143\x6f\x72\145\137\141\x6d\x6f\165\x6e\x74\x2c\162\141\146\x66\154\x65\137\x73\143\157\162\145\137\163\x74\x61\164\165\x73\54\x64\151\x73\x74\x72\x69\142\x75\x74\145\x5f\x73\143\157\x72\145\54\x64\151\x73\164\162\x69\142\165\x74\145\137\141\155\x6f\165\156\164\x2c\x73\x68\141\x72\145\x5f\163\143\157\162\145\x2c\163\150\x61\x72\145\x5f\x61\x6d\x6f\x75\x6e\x74\x2c\162\x65\x77\x61\162\144\137\163\143\x6f\162\x65\54\x72\x65\x77\141\x72\x64\137\x61\155\x6f\x75\x6e\164\x2c\151\x6e\166\151\x74\x65\137\x75\x73\x65\162\x5f\x69\x64\x2c\163\x74\x61\x74\x75\163\54\162\145\x6d\141\x72\x6b\54\141\x62\156\x6f\x72\155\x61\x6c\x2c\143\x72\145\141\164\x65\x5f\x74\151\x6d\x65\x2c\x75\x70\144\x61\x74\145\x5f\164\x69\155\x65";
        goto rZ3sd;
        rZ3sd:
        $this->userService = new NGSUserService();
        goto qZM6u;
        nF8jP:
        $this->quanService = new NGSQuanService();
        goto uNlHi;
        meLrA:
        $this->flashUserService = new FlashUserService();
        goto viYUk;
        MImkF:
        $this->table_name = "\154\157\x6e\x61\x6b\x69\156\147\137\156\145\x77\137\147\x69\x66\164\137\163\x68\x6f\x70\x5f\157\x72\x64\x65\162";
        goto d_Htz;
        qZM6u:
        $this->giftService = new NGSGiftService();
        goto qKJa4;
        Z9qRZ:
    }
    /**
     * @param $user
     * @param $giftId
     * @param int $addressId
     * @return bool
     * @throws Exception
     */
    public function order($user, $giftId, $inviteId = 0, $addressId = 0, $lng = 0.0, $lat = 0.0)
    {
        goto qZCre;
        k34nd:
        $this->checkLocation($gift, $lng, $lat);
        goto rjrhs;
        aH9ej:
        qIyGs:
        goto G3JZk;
        Jf6Zu:
        if ($gift["\x62\x75\x79\x5f\164\171\x70\x65"] == NGSGiftService::GIFT_BUY_TYPE_SCORE) {
            goto qcxAt;
        }
        goto S511k;
        G7Flf:
        $this->deductCredit($gift, $user, $order);
        goto Qi6_n;
        mIVHx:
        $order["\150\142\x5f\141\155\157\165\x6e\164"] = $this->getHbAmount($gift);
        goto RMFmq;
        Qi6_n:
        $this->log(3, "\347\247\257\345\210\206\346\211\xa3\351\x99\xa4\346\x88\220\xe5\212\237");
        goto WsHsx;
        xnbQ6:
        M0VdF:
        goto mIVHx;
        l7Lig:
        goto IGr3C;
        goto OlOvm;
        fmNpR:
        $order["\164\x72\141\x6e\163\x5f\x66\145\145"] = $gift["\x74\162\x61\156\163\137\146\145\145"];
        goto qdFOd;
        fmnbk:
        $this->accessOrder($order["\x6f\x72\x64\145\162\x5f\x6e\165\x6d"]);
        goto kSEUX;
        MY2xJ:
        if (!(null == $gift)) {
            goto Z7NWI;
        }
        goto C6l3h;
        XM5F2:
        try {
            $isBlackUser = $this->userService->check_user_is_safe($user);
        } catch (Exception $e) {
            goto nDRyT;
            O6uFS:
            $order["\162\x65\x6d\x61\x72\x6b"] = "\xe8\xaf\xa5\347\224\xa8\xe6\x88\267\345\xad\x98\345\x9c\xa8\xe4\270\x80\344\272\233\xe9\227\256\351\xa2\x98\357\xbc\214\350\242\253\345\217\x8d\346\254\xba\350\257\210\347\xb3\xbb\347\273\x9f\xe6\213\246\346\x88\xaa\357\xbc\x9a" . $e->getMessage();
            goto bdHgy;
            nDRyT:
            $isBlackUser = true;
            goto Cq6uJ;
            Cq6uJ:
            $order["\x61\142\x6e\x6f\162\155\141\154"] = NGSOrderService::ORDER_ABNORMAL;
            goto O6uFS;
            bdHgy:
        }
        goto QwoOt;
        bAhhv:
        $this->accessOrder($order["\157\x72\144\145\162\137\156\165\155"]);
        goto c_G1u;
        RqDVu:
        cY7hr:
        goto QXBbk;
        zizlG:
        $pricing = $this->giftService->pricing($gift, $userScore);
        goto KF2Ja;
        n9t1A:
        $order["\x73\x74\141\x74\x75\163"] = NGSOrderService::ORDER_STATUS_SUCCESS;
        goto RqDVu;
        g1HTU:
        if ($gift["\164\x79\x70\145"] == NGSGiftService::GIFT_TYPE_ZL) {
            goto mlu0A;
        }
        goto DRiAA;
        qEFCd:
        $this->giftService->reduceOneGift($gift["\x69\x64"]);
        goto gAlaQ;
        jels2:
        $order["\154\x6c\x5f\x73\164\x61\x74\x75\x73"] = NGSOrderService::ORDER_LL_STATUS_DEFAULT;
        goto qkmiH;
        oAdRA:
        o56uV:
        goto l7Lig;
        qdFOd:
        $order["\164\x72\x61\156\x73\x5f\146\145\145\x5f\163\x74\x61\164\165\x73"] = NGSOrderService::ORDER_TRANS_FEE_STATUS_NOT_PAY;
        goto oAdRA;
        ZLKD7:
        if ($gift["\x61\142\156\x6f\x72\x6d\x61\154\137\162\x61\156\153"] == NGSGiftService::GIFT_ABNORMAL_CLOSE) {
            goto IBpGb;
        }
        goto n8zN6;
        RMFmq:
        $order["\x68\x62\137\163\164\x61\x74\x75\163"] = NGSOrderService::ORDER_HB_STATUS_NO_SEND;
        goto LAIAI;
        PSe7p:
        $order["\x72\x61\146\x66\x6c\145"] = 1;
        goto m0nUF;
        HsSBw:
        $this->log($image, "\xe7\244\274\345\x93\201\351\x95\234\xe5\x83\x8f\350\241\xa8\xe7\x94\237\xe6\x88\220\346\210\x90\xe5\212\x9f");
        goto QRLpa;
        gAlaQ:
        $this->noticeService->sendGetGiftSuccessNotice($order["\157\160\145\x6e\151\144"], $gift["\x74\151\x74\x6c\145"], $order["\x6f\x72\x64\145\x72\x5f\163\x63\157\x72\x65"] . "\347\xa7\xaf\345\210\x86", $credits["\143\x72\x65\144\x69\164\x31"] . "\xe7\247\xaf\xe5\x88\x86\x2b" . $credits["\143\162\x65\144\151\x74\62"] . "\xe4\275\x99\xe9\xa2\x9d");
        goto mA277;
        pFj_R:
        $this->log($gift, "\xe8\xaf\245\347\244\274\345\x93\x81\xe6\x9c\252\345\274\200\345\x90\257\345\x8f\215\xe6\xac\272\350\257\210\xe8\xa7\x84\xe5\210\231");
        goto fmnbk;
        sQ2aI:
        $this->checkGiftUsingTime($gift);
        goto k34nd;
        Mib2f:
        $order["\x72\x61\x66\x66\154\145\x5f\x73\x74\141\x74\165\163"] = $this->checkRaffle($gift);
        goto YZNTf;
        cfTlZ:
        q0qix:
        goto M35z_;
        TKJbJ:
        goto o56uV;
        goto esbEU;
        bRlo9:
        $order["\162\141\146\x66\154\x65\137\163\x63\157\162\145\x5f\x73\x74\141\164\x75\163"] = NGSOrderService::ORDER_RAFFLE_SCORE_STATUS_OK;
        goto ZWsN2;
        mA277:
        BMgCE:
        goto T8t0O;
        O7xSK:
        $order["\162\x61\x66\x66\154\145"] = $gift["\x72\141\146\x66\x6c\x65"];
        goto n_6Zj;
        b6doE:
        dR2C7:
        goto eGw__;
        S511k:
        if (!($gift["\x72\x65\x64\x75\143\145\x5f\164\x79\x70\x65"] == 1)) {
            goto ZG3c8;
        }
        goto SdD2H;
        aShO6:
        if ($order["\157\162\144\145\x72\x5f\155\x6f\156\145\171"] > 0) {
            goto dR2C7;
        }
        goto ZLKD7;
        uuUos:
        return $order;
        goto FjUi_;
        T8t0O:
        gw9VG:
        goto Z7elD;
        FNE1D:
        $order["\x72\x65\155\141\162\x6b"] = $address["\162\145\x6d\141\x72\153"];
        goto YziLf;
        n_6Zj:
        if (!($gift["\162\141\x66\x66\x6c\145"] == 2)) {
            goto SfCXX;
        }
        goto PSe7p;
        f8OxD:
        if ($gift["\164\x79\160\145"] == NGSGiftService::GIFT_TYPE_SEND) {
            goto w31tk;
        }
        goto g1HTU;
        SdD2H:
        $this->giftService->reduceOneGift($gift["\x69\x64"]);
        goto Zvv6Q;
        LAIAI:
        $order["\150\x62\137\157\x70\145\x6e\151\x64"] = $user["\142\157\162\x72\157\x77\137\x6f\160\x65\x6e\151\x64"];
        goto jZQyY;
        YziLf:
        if ($gift["\164\x72\141\x6e\163\x5f\146\145\x65"] > 0) {
            goto n0EYK;
        }
        goto GpMqc;
        W2vQ8:
        u8eM2:
        goto Qtr85;
        AAdgA:
        $this->checkByLimit($gift, $user);
        goto JYx6T;
        c_G1u:
        VSce4:
        goto EF5hK;
        qkmiH:
        goto IGr3C;
        goto COzYd;
        GpMqc:
        $order["\x74\x72\x61\156\x73\137\x66\x65\x65"] = 0;
        goto ILaq1;
        m0nUF:
        SfCXX:
        goto Mib2f;
        aSMaU:
        if ($gift["\x74\171\x70\x65"] == NGSGiftService::GIFT_TYPE_RED_PACKETS) {
            goto M0VdF;
        }
        goto DlTnz;
        Qtr85:
        $this->checkMcLimit($user, $gift);
        goto sQ2aI;
        OlOvm:
        mlu0A:
        goto R7ojY;
        DRiAA:
        if ($gift["\x74\171\160\x65"] == NGSGiftService::GIFT_TYPE_MOBILE_FEE) {
            goto cc5Vu;
        }
        goto c71qk;
        ElyWW:
        $this->checkAddressWithGiftType($gift, $address);
        goto AAdgA;
        dG0_Y:
        if (!(!$isBlackUser && $order["\163\164\141\x74\x75\163"] != NGSOrderService::ORDER_STATUS_SUCCESS)) {
            goto VSce4;
        }
        goto RlTtX;
        UhlCf:
        throw new Exception("\345\205\x91\346\215\242\345\244\xb1\xe8\264\xa5\357\274\214\347\244\xbc\345\223\201\xe5\x81\x9c\xe6\xad\xa2\345\205\221\xe6\x8d\242\344\xb8\255\357\xbc\214\350\257\267\347\250\215\xe5\220\x8e\xe5\206\x8d\346\x9d\245", 4803);
        goto W2vQ8;
        yWEgX:
        $order["\164\162\141\156\x73\137\x73\164\x61\164\165\163"] = NGSOrderService::ORDER_TRANS_STATUS_DEFAULT;
        goto FNE1D;
        OuX1y:
        if (!($order["\162\141\146\x66\154\145"] == NGSGiftService::GIFT_RAFFLE && $order["\x72\141\x66\x66\x6c\x65\137\x73\164\x61\164\165\163"] == 1 || $order["\x72\141\146\146\154\145"] == NGSGiftService::GIFT_NOT_RAFFLE)) {
            goto gw9VG;
        }
        goto aSMaU;
        WCxH1:
        qcxAt:
        goto u5Slc;
        M35z_:
        goto IGr3C;
        goto xvUlt;
        esbEU:
        n0EYK:
        goto fmNpR;
        yDQc6:
        goto IGr3C;
        goto I2oN4;
        cY2xf:
        goto IGr3C;
        goto aH9ej;
        T3mvQ:
        if (!($order["\x72\141\146\x66\x6c\145\x5f\x73\164\x61\164\x75\163"] == NGSOrderService::ORDER_RAFFLE_FAIL)) {
            goto cY7hr;
        }
        goto n9t1A;
        I2oN4:
        cc5Vu:
        goto ESyzP;
        IPTet:
        if ($gift["\x74\171\160\145"] == NGSGiftService::GIFT_TYPE_SCORE_RAFFLE) {
            goto N0s_Q;
        }
        goto d2FED;
        r2BKh:
        $order["\150\x66\137\163\164\x61\x74\x75\163"] = NGSOrderService::ORDER_HF_STATUS_DEFAULT;
        goto cY2xf;
        EF5hK:
        goto NhOV4;
        goto bKmQ0;
        bjvUw:
        $this->giftService->columnAddCount("\x72\141\x66\x66\154\x65\x5f\150\151\164", 1, $gift["\151\x64"]);
        goto xBj2T;
        NoQgl:
        $image = $this->giftImageService->gift2Image($gift);
        goto HsSBw;
        eGw__:
        JU1sa:
        goto CBhaW;
        u5Slc:
        $credits = $this->flashUserService->fetchUserCredit($order["\157\x70\145\156\151\144"]);
        goto qEFCd;
        G3JZk:
        $order["\x6c\x6c\x5f\x61\155\157\165\x6e\x74"] = $gift["\x6c\154\x5f\x61\155\x6f\x75\x6e\x74"];
        goto jels2;
        Zvv6Q:
        ZG3c8:
        goto q2e8a;
        QXBbk:
        ExssO:
        goto OuX1y;
        UYXKM:
        $order["\162\141\x66\146\154\x65\137\163\143\x6f\x72\x65\x5f\141\x6d\x6f\x75\x6e\x74"] = $gift["\x72\141\x66\146\x6c\x65\137\x73\x63\157\x72\145\137\x61\155\157\x75\156\164"];
        goto y3SCW;
        C6l3h:
        throw new Exception("\xe7\xa4\xbc\xe5\223\x81\344\xb8\215\345\xad\230\xe5\234\xa8", 4801);
        goto UI94S;
        zsbke:
        $isBlackUser = false;
        goto XM5F2;
        XXoaf:
        sKPDe:
        goto EDYDJ;
        RlTtX:
        $this->log($order, "\xe8\xaf\xa5\350\256\xa2\xe5\x8d\x95\346\xb2\xa1\346\234\211\344\xbb\200\344\xb9\x88\345\244\247\xe6\xaf\233\347\x97\x85\357\274\214\347\233\xb4\346\216\245\xe9\200\x9a\350\xbf\x87");
        goto bAhhv;
        y3SCW:
        $order["\162\x61\x66\146\154\x65\x5f\163\x63\157\x72\x65\x5f\163\x74\x61\164\165\163"] = NGSOrderService::ORDER_RAFFLE_SCORE_STATUS_DEFAULT;
        goto bRlo9;
        COzYd:
        N0s_Q:
        goto UYXKM;
        ZWsN2:
        IGr3C:
        goto Jf6Zu;
        xvUlt:
        w31tk:
        goto BzL8R;
        QRLpa:
        $order["\147\151\146\x74\137\151\144"] = $image["\151\144"];
        goto zsbke;
        Z7elD:
        $this->log(4, "\346\225\260\xe9\207\217\xe5\207\217\345\xb0\221\xe6\x88\220\345\x8a\x9f");
        goto NoQgl;
        fs69F:
        goto JU1sa;
        goto b6doE;
        EDYDJ:
        if (!($gift["\163\x74\x61\164\x75\x73"] == NGSGiftService::GIFT_STATUS_STOP)) {
            goto u8eM2;
        }
        goto UhlCf;
        ILaq1:
        $order["\x74\162\141\156\163\137\x66\145\145\x5f\x73\164\x61\164\x75\x73"] = NGSOrderService::ORDER_TRANS_FEE_STATUS_PAID;
        goto TKJbJ;
        d2FED:
        goto IGr3C;
        goto xnbQ6;
        PIol2:
        $gift = $this->giftService->selectById($giftId);
        goto MY2xJ;
        c71qk:
        if ($gift["\164\x79\x70\145"] == NGSGiftService::GIFT_TYPE_MOBILE_LL) {
            goto qIyGs;
        }
        goto IPTet;
        rjrhs:
        $address = $addressId > 0 ? $this->addressService->selectById($addressId) : null;
        goto ElyWW;
        JYx6T:
        $this->checkCreditEnough($gift, $user);
        goto ZE_R4;
        g7Fzr:
        $this->log($order, "\346\212\275\345\245\x96\347\273\x93\xe6\x9e\234");
        goto G7Flf;
        QwoOt:
        $order = $this->insertData($order);
        goto AzQb0;
        YZNTf:
        if (!($order["\x72\141\146\x66\154\145\x5f\x73\x74\x61\164\x75\x73"] == 1)) {
            goto AoMR1;
        }
        goto bjvUw;
        qZCre:
        global $_W;
        goto PIol2;
        WsHsx:
        if (!($order["\x72\141\x66\146\154\x65"] == NGSGiftService::GIFT_RAFFLE)) {
            goto ExssO;
        }
        goto T3mvQ;
        q2e8a:
        goto BMgCE;
        goto WCxH1;
        CBhaW:
        AtBDA:
        goto uuUos;
        UI94S:
        Z7NWI:
        goto IFJ0Q;
        xrNau:
        throw new Exception("\345\x85\221\xe6\215\242\345\244\xb1\350\264\245\54\xe5\xba\223\xe5\xad\230\xe4\xb8\x8d\350\266\xb3\x2c\350\xaf\xb7\347\xa8\x8d\xe5\220\216\345\x86\x8d\xe6\x9d\245\357\274\x81", 4802);
        goto XXoaf;
        AzQb0:
        if (!($gift["\141\x75\164\x6f"] == NGSGiftService::GIFT_AUTO)) {
            goto AtBDA;
        }
        goto aShO6;
        bKmQ0:
        IBpGb:
        goto pFj_R;
        kSEUX:
        NhOV4:
        goto fs69F;
        n8zN6:
        $this->log($gift, "\xe8\257\245\347\xa4\xbc\345\223\x81\xe5\274\200\xe5\x90\xaf\xe4\xba\206\345\217\215\346\254\xba\350\257\x88\xe8\xa7\x84\xe5\210\x99");
        goto dG0_Y;
        ESyzP:
        $order["\150\146\x5f\141\x6d\x6f\165\x6e\x74"] = $gift["\x68\x66\x5f\x61\x6d\x6f\x75\156\164"];
        goto r2BKh;
        IFJ0Q:
        if (!($gift["\x6e\165\155"] <= 0)) {
            goto sKPDe;
        }
        goto xrNau;
        ZE_R4:
        $userScore = $this->flashUserService->fetchUserScore($user["\x6f\160\145\x6e\151\x64"]);
        goto zizlG;
        jZQyY:
        goto IGr3C;
        goto cfTlZ;
        DlTnz:
        if ($gift["\x74\x79\x70\145"] == NGSGiftService::GIFT_TYPE_VIRTUAL) {
            goto q0qix;
        }
        goto f8OxD;
        R7ojY:
        $order["\172\x6c\x5f\x73\x74\x61\x74\165\163"] = NGSOrderService::ORDER_ZL_STATUS_DEFAULT;
        goto yDQc6;
        BzL8R:
        $order["\x74\162\x61\156\x73\137\x66\x65\x65"] = $gift["\x74\162\141\156\x73\x5f\146\x65\x65"];
        goto yWEgX;
        KF2Ja:
        $order = array("\x75\156\x69\x61\x63\151\144" => $_W["\x75\156\151\x61\x63\151\144"], "\164\x79\x70\145" => $gift["\x74\171\160\x65"], "\x6f\162\144\x65\x72\137\156\165\155" => time() . $user["\151\144"] . $gift["\x69\144"], "\165\x73\145\162\x5f\x69\x64" => $user["\151\144"], "\165\x69\x64" => $user["\165\x69\x64"], "\157\x70\145\156\x69\144" => $user["\x6f\160\145\x6e\151\144"], "\156\x69\143\x6b\x6e\141\x6d\x65" => $user["\x6e\151\x63\x6b\156\141\x6d\145"], "\141\x64\x64\x72\x65\163\163\137\151\x64" => $gift["\x74\171\160\x65"] == NGSGiftService::GIFT_TYPE_SEND ? $address["\151\x64"] : 0, "\162\x65\141\x6c\137\x67\x69\x66\x74\137\151\x64" => $giftId, "\x62\165\x79\x5f\x74\171\160\x65" => $gift["\142\165\171\137\x74\x79\x70\x65"], "\x6f\x72\144\145\x72\x5f\x73\x63\x6f\x72\x65" => $pricing["\x73\x63\x6f\162\x65"], "\157\162\144\x65\x72\137\155\x6f\156\x65\x79" => $pricing["\155\x6f\156\x65\x79"], "\x64\x69\163\164\x72\151\x62\x75\x74\x65\137\x73\143\157\162\145" => $gift["\x64\x69\163\x74\x72\151\x62\x75\x74\x65\x5f\x73\x63\157\x72\145"], "\144\151\163\164\x72\151\142\x75\x74\145\137\141\155\157\x75\156\x74" => $gift["\144\151\163\x74\x72\151\142\x75\164\x65\x5f\x61\155\157\x75\156\x74"], "\x73\150\141\x72\145\137\163\x63\x6f\x72\145" => $gift["\163\x68\141\162\x65\137\163\143\x6f\x72\x65"], "\163\150\x61\162\x65\137\x61\x6d\x6f\x75\156\164" => $gift["\163\x68\x61\x72\145\137\x61\x6d\157\165\156\164"], "\162\x65\x77\x61\x72\x64\x5f\163\143\x6f\162\145" => $gift["\162\x65\x77\x61\162\x64\x5f\163\143\x6f\x72\x65"], "\162\145\x77\141\162\x64\137\141\x6d\x6f\x75\x6e\x74" => $gift["\162\145\167\141\162\144\137\141\x6d\157\165\x6e\x74"], "\x69\x6e\x76\151\164\x65\x5f\x75\x73\x65\x72\x5f\151\144" => $inviteId, "\160\141\171\137\163\x74\141\x74\x75\163" => NGSOrderService::ORDER_PAY_STATUS_NOT_PAY, "\x72\x61\x66\x66\154\x65" => $gift["\x72\x61\x66\x66\154\145"], "\163\x74\141\x74\x75\x73" => 0, "\x61\x62\156\x6f\x72\155\x61\154" => NGSOrderService::ORDER_NORMAL, "\143\x72\145\141\164\x65\137\164\x69\155\145" => time(), "\165\160\x64\x61\x74\x65\x5f\x74\151\x6d\145" => time());
        goto O7xSK;
        xBj2T:
        AoMR1:
        goto g7Fzr;
        FjUi_:
    }
    private function checkRaffle($gift)
    {
        goto kZ44B;
        N9qyN:
        iH_Fd:
        goto mzGPC;
        XRgC2:
        return 0;
        goto lglZS;
        L0VPI:
        $oneHundred = array();
        goto OIHAg;
        rGl8g:
        $chanceNumbersKey = array_rand($oneHundred, $gift["\162\141\x66\146\x6c\x65\x5f\143\x68\141\x6e\x63\x65"]);
        goto Yznsr;
        MOmh5:
        if (in_array($key, $chanceNumbersKey)) {
            goto K5ebS;
        }
        goto XRgC2;
        Xr_De:
        if (!($i <= 100)) {
            goto gt0nR;
        }
        goto h9qnc;
        cU2Fl:
        cFd__:
        goto L0VPI;
        A6xLm:
        goto qzJvh;
        goto VBs5p;
        eCRxl:
        return 0;
        goto j0lXd;
        g_Kls:
        return 0;
        goto cU2Fl;
        ham3U:
        return 0;
        goto rThPn;
        ejI2f:
        K5ebS:
        goto c86To;
        OIHAg:
        $i = 1;
        goto D5JDb;
        oiJCx:
        if ($gift["\x72\x61\146\146\x6c\145\137\x63\150\x61\x6e\143\x65"] >= 100) {
            goto h5UQD;
        }
        goto BvMv6;
        bUBo6:
        rOcko:
        goto XowLu;
        Yznsr:
        $key = array_rand($oneHundred, 1);
        goto MOmh5;
        h9qnc:
        $oneHundred[] = $i;
        goto N9qyN;
        DWeDZ:
        if ($gift["\162\141\x66\x66\154\x65\137\x63\x68\141\156\143\145"] == 0) {
            goto D3P6B;
        }
        goto oiJCx;
        YkHgo:
        W2FkD:
        goto AA_bd;
        BvMv6:
        goto rOcko;
        goto yMkk7;
        VBs5p:
        gt0nR:
        goto rGl8g;
        tNtvG:
        if ($gift["\162\x61\x66\146\154\x65"] == 0) {
            goto uDdt7;
        }
        goto jI9bp;
        jI9bp:
        if (!($gift["\162\141\146\x66\x6c\x65\x5f\x6d\x61\170"] == -1)) {
            goto pNksC;
        }
        goto ham3U;
        kZ44B:
        if (!($gift["\x6e\x75\155"] <= 0)) {
            goto Dkn_b;
        }
        goto IXbZj;
        mzGPC:
        $i++;
        goto A6xLm;
        rHVC0:
        Dkn_b:
        goto tNtvG;
        LfJ3m:
        uDdt7:
        goto g_Kls;
        j0lXd:
        r1VHM:
        goto DWeDZ;
        lglZS:
        goto W2FkD;
        goto ejI2f;
        yMkk7:
        D3P6B:
        goto mG7RS;
        rThPn:
        pNksC:
        goto nOOWT;
        D5JDb:
        qzJvh:
        goto Xr_De;
        JTucd:
        return 1;
        goto bUBo6;
        XowLu:
        goto cFd__;
        goto LfJ3m;
        IXbZj:
        return 0;
        goto rHVC0;
        c86To:
        return 1;
        goto YkHgo;
        n7ojz:
        h5UQD:
        goto JTucd;
        nOOWT:
        if (!($gift["\162\141\x66\x66\154\x65\137\150\151\164"] >= $gift["\162\x61\x66\x66\x6c\145\137\x6d\141\x78"])) {
            goto r1VHM;
        }
        goto eCRxl;
        mG7RS:
        return 0;
        goto cFu67;
        cFu67:
        goto rOcko;
        goto n7ojz;
        AA_bd:
    }
    private function checkRaffle2($gift)
    {
        goto oFQjm;
        LGv0B:
        if ($gift["\x72\141\x66\x66\x6c\x65"] == NGSGiftService::GIFT_RAFFLE) {
            goto Pk9Qe;
        }
        goto tyvSX;
        j1MH5:
        NAUgO:
        goto p0Bm_;
        lR3fC:
        goto YOdU2;
        goto Wo_GY;
        GLwpL:
        return 1;
        goto j1MH5;
        MmZ50:
        goto YOdU2;
        goto eide7;
        Wo_GY:
        mHP0e:
        goto uvEqP;
        R2KBf:
        $hits = explode("\x2c", $gift["\x72\141\146\146\154\145\137\150\151\x74"]);
        goto Y4NmL;
        uvEqP:
        $min = $gift["\162\141\146\146\154\x65\137\155\151\156"];
        goto U7f26;
        r1N5d:
        if (in_array($hit, $hits)) {
            goto HB3UW;
        }
        goto OeyUG;
        V9E5F:
        return 0;
        goto bKJ0O;
        OeyUG:
        $this->log(1, "\xe6\262\241\344\xb8\xad\xe5\245\226");
        goto V9E5F;
        MU0kb:
        $hit = rand($min, $max);
        goto ajdvh;
        bKJ0O:
        goto NAUgO;
        goto OtiWJ;
        ajdvh:
        YOdU2:
        goto R2KBf;
        oFQjm:
        $hit = null;
        goto LGv0B;
        Y4NmL:
        $this->log(array("\150\x69\164" => $hit, "\x68\x69\x74\163" => $hits), "\346\234\254\xe6\254\xa1\xe6\x8a\275\xe5\245\x96\xe5\217\202\xe7\x85\247\347\273\223\xe6\x9e\x9c");
        goto r1N5d;
        QZclR:
        $this->log(1, "\xe4\270\255\xe5\245\226\xe4\272\206");
        goto GLwpL;
        tyvSX:
        if ($gift["\162\x61\x66\x66\x6c\145"] == NGSGiftService::GIFT_RAFFLE_RANDOM) {
            goto mHP0e;
        }
        goto MmZ50;
        PKFj4:
        $hit = $this->raffleService->raffleGo($gift["\x69\144"]);
        goto lR3fC;
        OtiWJ:
        HB3UW:
        goto QZclR;
        eide7:
        Pk9Qe:
        goto PKFj4;
        U7f26:
        $max = $gift["\162\x61\x66\146\154\145\137\x6d\141\170"];
        goto MU0kb;
        p0Bm_:
    }
    public function checkLocation($gift, $lng = 0.0, $lat = 0.0)
    {
        goto VkosJ;
        H8gH7:
        goto G4VW0;
        goto XQRxT;
        V9sC3:
        G4VW0:
        goto vy44I;
        G62Mw:
        return true;
        goto V9sC3;
        A6j1Z:
        throw new Exception("\xe6\x82\xa8\346\211\x80\345\234\250\xe7\x9a\x84\344\275\x8d\347\xbd\256\xe4\270\x8d\xe5\x9c\250\xe8\257\xa5\347\244\xbc\345\x93\201\xe7\x9a\x84\xe5\x85\221\xe6\x8d\242\350\214\x83\xe5\x9b\xb4\xe5\x86\205\54\350\xb7\x9d\xe7\xa6\273" . $radius / 1000 . "\345\215\x83\xe7\xb1\263", 4809);
        goto J8ZSe;
        Kn1mk:
        $radius = $gift["\x72\x61\144\151\165\163"] * 1000;
        goto OYNfl;
        VkosJ:
        if ($gift["\x72\x61\144\x69\165\x73"] <= 0 || $lng == 0 || $lat == 0) {
            goto QbCnx;
        }
        goto E7fAg;
        EI4Mr:
        $this->log($distance, "\347\x94\250\xe6\x88\267\xe6\x89\200\345\x9c\xa8\xe5\234\xb0\xe4\270\x8d\xe5\234\xa8\xe7\244\274\xe5\x93\x81\xe5\x85\x91\xe6\x8d\xa2\xe8\214\203\xe5\x9b\264\xe5\206\205\357\274\214\xe8\267\x9d\xe7\246\273" . $radius / 1000 . "\xe5\215\203\xe7\xb1\xb3");
        goto A6j1Z;
        E7fAg:
        $distance = $this->flashLocationService->w2bDistance($lng, $lat, $gift["\154\156\x67"], $gift["\x6c\141\164"]);
        goto SjTqk;
        XQRxT:
        QbCnx:
        goto G62Mw;
        z8CcA:
        $this->log(null, "\347\224\xa8\xe6\x88\267\346\211\x80\345\234\xa8\xe5\234\260\xe8\xb7\x9d\xe7\246\xbb\347\xa4\xbc\345\x93\x81\xe5\x85\221\346\x8d\242\xe5\x9c\260\345\x8c\272{$distance}\347\261\263\54\345\234\250\345\205\x91\xe6\215\242\xe8\214\x83\xe5\233\264\345\206\x85");
        goto H8gH7;
        OYNfl:
        if (!($distance > $radius)) {
            goto z2mSq;
        }
        goto EI4Mr;
        SjTqk:
        $this->log($distance, "\350\256\xa1\347\xae\x97\xe5\207\272\350\xb7\235\347\246\xbb\xe4\270\xba");
        goto Kn1mk;
        J8ZSe:
        z2mSq:
        goto z8CcA;
        vy44I:
    }
    private function deductCredit($gift, $user, $order)
    {
        goto HbSz9;
        gEP6P:
        $this->flashUserService->reduceUserScore($order["\x6f\162\144\x65\162\x5f\163\143\x6f\162\x65"], $user["\x6f\x70\145\156\151\x64"], "\xe7\247\257\xe5\210\x86\xe6\x8a\275\xe5\245\226\x5b{$gift["\164\x69\x74\154\145"]}\135\x2c\346\234\252\xe4\xb8\xad\345\xa5\226");
        goto a58z0;
        yPuGH:
        $this->flashUserService->reduceUserScore($order["\157\x72\x64\145\162\x5f\163\143\157\162\145"], $user["\157\x70\x65\x6e\151\x64"], "\347\xa7\257\345\x88\206\346\x8a\xbd\xe5\xa5\x96\133{$gift["\x74\x69\x74\154\145"]}\x5d\x2c\346\201\255\xe5\226\x9c\xe6\x82\xa8\344\270\xad\xe5\245\226\xe4\272\206");
        goto nqqPN;
        zC6uo:
        $this->flashUserService->reduceUserScore($order["\x6f\162\x64\x65\162\137\163\143\x6f\x72\x65"], $user["\157\160\x65\x6e\151\x64"], "\xe7\xa7\257\xe5\x88\x86\345\x85\x91\xe6\215\xa2\133{$gift["\x74\151\164\x6c\x65"]}\x5d");
        goto nddfl;
        Cu6by:
        XZmsL:
        goto yPuGH;
        nddfl:
        SEHpD:
        goto Zi3JR;
        HbSz9:
        if (!($order["\x6f\x72\x64\x65\x72\137\163\x63\157\162\x65"] > 0)) {
            goto GWhe0;
        }
        goto wrZVO;
        nqqPN:
        LgKzv:
        goto XFZBN;
        XFZBN:
        goto SEHpD;
        goto DO4Al;
        sAB3p:
        goto LgKzv;
        goto aI4pB;
        Zi3JR:
        GWhe0:
        goto cMf1a;
        KpvwJ:
        if ($order["\x72\x61\146\x66\154\145\x5f\x73\164\x61\164\165\163"] == 1) {
            goto XZmsL;
        }
        goto sAB3p;
        aI4pB:
        nzpeG:
        goto gEP6P;
        JqRQJ:
        if ($order["\162\x61\x66\x66\x6c\145\137\163\x74\x61\164\165\163"] == 0) {
            goto nzpeG;
        }
        goto KpvwJ;
        wrZVO:
        if ($gift["\162\141\146\146\154\x65"] == NGSGiftService::GIFT_NOT_RAFFLE) {
            goto YgRPC;
        }
        goto JqRQJ;
        a58z0:
        goto LgKzv;
        goto Cu6by;
        DO4Al:
        YgRPC:
        goto zC6uo;
        cMf1a:
    }
    private function checkCreditEnough($gift, $user)
    {
        goto jO4Uk;
        g4vod:
        if (!($user["\146\141\x6e\137\x69\156\x66\x6f"]["\163\x63\x6f\162\145"] < $gift["\163\x63\x6f\x72\145"] && $gift["\155\157\156\x65\171\x5f\164\157\137\x73\x63\157\162\x65\137\x66\x6c\141\147"] == 0)) {
            goto wSOd4;
        }
        goto YDIhi;
        suKqU:
        DY4N6:
        goto g4vod;
        YDIhi:
        throw new Exception("\347\247\257\xe5\x88\206\344\270\x8d\xe8\266\xb3\357\274\214\xe6\x97\240\346\263\225\345\205\x91\346\x8d\xa2", 4804);
        goto twDwf;
        twDwf:
        wSOd4:
        goto X_iHE;
        jO4Uk:
        if ($gift["\142\165\x79\x5f\164\x79\x70\x65"] == NGSGiftService::GIFT_BUY_TYPE_SCORE || $gift["\x62\x75\x79\x5f\x74\x79\x70\x65"] == NGSGiftService::GIFT_BUY_TYPE_SCORE_AND_MONEY) {
            goto DY4N6;
        }
        goto xEdA_;
        fDha4:
        bX1Pn:
        goto tFQtv;
        xEdA_:
        if (!($gift["\142\165\x79\x5f\x74\x79\160\x65"] == NGSGiftService::GIFT_BUY_TYPE_MONEY)) {
            goto bX1Pn;
        }
        goto fDha4;
        tFQtv:
        goto xIv6W;
        goto suKqU;
        X_iHE:
        xIv6W:
        goto QkDwb;
        QkDwb:
    }
    private function checkGiftUsingTime($gift)
    {
        goto njkau;
        PzKa3:
        Mf8PP:
        goto Qs2PD;
        UL4hn:
        if (!($currentTime < $startTime)) {
            goto Mf8PP;
        }
        goto lxwM6;
        JrUI4:
        NiDCA:
        goto qoRpi;
        lxwM6:
        throw new Exception("\346\227\xb6\xe9\227\xb4\350\xbf\230\xe6\234\252\xe5\xbc\200\345\247\x8b\54\xe8\257\xb7\xe7\250\215\xe5\x90\216\xe5\x86\x8d\xe6\235\xa5\x2c\345\274\200\xe5\247\213\346\227\266\xe9\227\264\x3a{$gift["\x73\164\x61\162\x74\137\144\x61\x74\x65"]}", 48002);
        goto PzKa3;
        PqE52:
        $currentTime = time();
        goto UL4hn;
        vtqSB:
        $endTime = strtotime($gift["\145\156\144\x5f\x64\x61\x74\145"]);
        goto PqE52;
        Qs2PD:
        if (!($currentTime > $endTime)) {
            goto NiDCA;
        }
        goto Lb5__;
        njkau:
        $startTime = strtotime($gift["\163\x74\141\162\x74\137\x64\141\164\145"]);
        goto vtqSB;
        Lb5__:
        throw new Exception("\350\257\245\347\244\xbc\345\223\201\345\205\221\xe6\215\242\346\227\266\xe9\227\xb4\345\267\262\xe4\xba\x8e{$gift["\x65\156\x64\x5f\144\141\x74\145"]}\347\xbb\x93\346\235\x9f\x2c\346\x84\237\xe8\260\xa2\346\x82\250\xe7\x9a\x84\345\217\x82\xe4\270\216\x21", 48002);
        goto JrUI4;
        qoRpi:
    }
    private function checkMcLimit($user, $gift)
    {
        goto OieMC;
        qY3Qk:
        $uid = null;
        goto gQOuV;
        MAKqQ:
        $user = $this->flashUserService->fetchFansInfo($user["\x6f\x70\145\156\151\x64"]);
        goto Tyiry;
        KBd93:
        return true;
        goto uyv4s;
        Tyiry:
        $uid = $user["\165\x69\144"];
        goto ODybh;
        GJ_gb:
        $limitGroups = $this->flashMcGroupService->selectByIds($limit_group_ids);
        goto RK4lb;
        Y8QpJ:
        return true;
        goto u1u5t;
        nrBEY:
        foreach ($limitGroups as $g) {
            $groupName[] = $g["\x74\151\164\x6c\x65"];
            XJ2QU:
        }
        goto RMfBK;
        u1u5t:
        JNqqB:
        goto qY3Qk;
        gVp5t:
        $limit_group_ids = explode("\x2c", $gift["\155\x63\137\147\x72\157\165\160"]);
        goto rDeNj;
        KL65G:
        ywH2Z:
        goto IXEg0;
        OieMC:
        if (!($gift["\x6d\x63\x5f\x67\x72\x6f\x75\x70\137\x6c\x69\x6d\x69\164"] == 0 || empty($gift["\x6d\143\x5f\147\x72\157\165\x70"]))) {
            goto tn89U;
        }
        goto KBd93;
        RMfBK:
        EZSQz:
        goto NQ8oA;
        IXEg0:
        $uid = $user["\x75\151\144"];
        goto ZLp3D;
        d1u3F:
        attzz:
        goto CA2Z7;
        uyv4s:
        tn89U:
        goto gVp5t;
        F8sjC:
        $myGroup = $this->flashMcGroupService->getUserMcGroupByUid($uid);
        goto GJ_gb;
        RK4lb:
        $groupName = array();
        goto nrBEY;
        gQOuV:
        if (!empty($user["\165\x69\144"]) && $user["\165\151\x64"] != 0) {
            goto ywH2Z;
        }
        goto MAKqQ;
        NQ8oA:
        if (in_array($myGroup["\147\x72\x6f\165\x70\x69\x64"], $limit_group_ids)) {
            goto attzz;
        }
        goto D7ewJ;
        D7ewJ:
        throw new Exception("\350\257\xa5\347\xa4\xbc\345\x93\x81\344\xbb\x85\xe9\231\220\133" . implode("\54", $groupName) . "\x5d\xe5\x85\x91\xe6\215\xa2\357\274\x8c\346\202\250\346\211\200\xe5\234\250\xe7\x9a\204\344\xbc\232\xe5\221\x98\xe7\xbb\204\344\xb8\xba\x5b{$myGroup["\164\151\x74\x6c\x65"]}\x5d", 48003);
        goto d1u3F;
        ZLp3D:
        yVp5a:
        goto F8sjC;
        ODybh:
        goto yVp5a;
        goto KL65G;
        rDeNj:
        if (!(sizeof($limit_group_ids) == 0)) {
            goto JNqqB;
        }
        goto Y8QpJ;
        CA2Z7:
    }
    private function checkByLimit($gift, $user)
    {
        goto Lz0Ru;
        i0Hid:
        if (!($gift["\142\x75\171\x5f\154\x69\155\x69\164\137\x64\141\171"] > 0 && $gift["\x62\165\x79\x5f\154\151\x6d\x69\164\x5f\x6e\165\155"] > 0)) {
            goto yM1g1;
        }
        goto a1UBj;
        zLoM1:
        $startCreateTime = strtotime(date("\x59\55\x6d\55\144", strtotime("\x2d" . $gift["\142\x75\x79\137\154\151\155\x69\164\137\x64\141\x79"] . "\40\x64\x61\x79")));
        goto EOvi2;
        EOvi2:
        $orderRecords = $this->selectAll("\40\141\156\x64\40\x72\x65\x61\x6c\137\147\x69\x66\x74\137\151\x64\x3d{$gift["\x69\144"]}\40\141\156\x64\40\165\x73\x65\x72\x5f\x69\x64\x3d\47{$user["\151\x64"]}\47");
        goto l36ci;
        Xej7v:
        vjEff:
        goto Dfwl6;
        l36ci:
        $limitNum = 0;
        goto GXF1c;
        z8M6v:
        xGUT3:
        goto htrHn;
        C6org:
        zDHaJ:
        goto FR3eQ;
        GXF1c:
        foreach ($orderRecords as $order) {
            goto W7619;
            U173l:
            UjAtf:
            goto ijqjL;
            gjdFc:
            $limitNum = $limitNum + 1;
            goto U173l;
            ijqjL:
            fPUWq:
            goto LwDFI;
            W7619:
            if (!($order["\x63\162\x65\141\164\145\137\x74\x69\x6d\145"] > $startCreateTime)) {
                goto UjAtf;
            }
            goto gjdFc;
            LwDFI:
        }
        goto C6org;
        a1UBj:
        if (!($gift["\x62\165\171\x5f\154\x69\x6d\x69\164\x5f\156\x75\x6d"] <= $limitNum)) {
            goto vjEff;
        }
        goto jGAbY;
        jGAbY:
        throw new Exception("\xe8\257\xa5\347\244\274\xe5\223\x81{$gift["\x62\165\171\x5f\x6c\151\x6d\x69\164\137\144\141\171"]}\xe5\xa4\xa9\345\x86\205\346\257\x8f\344\272\xba\346\x9c\x80\xe5\244\x9a\xe5\205\x91\xe6\215\xa2{$gift["\142\x75\x79\137\154\151\x6d\x69\x74\137\156\x75\x6d"]}\xe6\xac\241\xef\xbc\x81", 4803);
        goto Xej7v;
        htrHn:
        XiKaf:
        goto Vi3D6;
        H4nIU:
        if (!($totalOrderCount >= $gift["\x62\x75\x79\x5f\x6c\x69\155\151\164\x5f\x74\157\164\x61\x6c"])) {
            goto xGUT3;
        }
        goto wxz7l;
        Oe3E9:
        if (!($gift["\x62\165\x79\x5f\154\151\155\x69\x74\137\164\x6f\x74\x61\154"] > 0)) {
            goto XiKaf;
        }
        goto H4nIU;
        Dfwl6:
        yM1g1:
        goto Oe3E9;
        Lz0Ru:
        $todayStart = strtotime(date("\x59\x2d\155\x2d\144"));
        goto zLoM1;
        FR3eQ:
        $totalOrderCount = sizeof($orderRecords);
        goto i0Hid;
        wxz7l:
        throw new Exception("\350\257\xa5\347\xa4\274\xe5\223\201\xe6\257\217\344\xba\xba\351\231\220\345\210\xb6\345\205\x91\346\215\242{$totalOrderCount}\xe6\xac\241\xef\xbc\x81", 4803);
        goto z8M6v;
        Vi3D6:
    }
    private function checkAddressWithGiftType($gift, $address)
    {
        goto cojxS;
        cojxS:
        if ($gift["\x74\171\x70\x65"] == NGSGiftService::GIFT_TYPE_SEND) {
            goto TkCmt;
        }
        goto Olc23;
        zzHSY:
        if (!(empty($address["\x6e\141\155\145"]) || empty($address["\x6d\157\142\x69\x6c\x65"]) || empty($address["\x61\144\144\162\145\x73\163"]))) {
            goto MtWHi;
        }
        goto kmNSx;
        qniju:
        goto fDIYc;
        goto uCDRg;
        mQ2sS:
        TkCmt:
        goto J1zif;
        kjy8k:
        MtWHi:
        goto qniju;
        WQc3x:
        goto fDIYc;
        goto mQ2sS;
        uCDRg:
        j4dRJ:
        goto BFmpt;
        b9HJS:
        owgxw:
        goto zzHSY;
        Olc23:
        if ($gift["\x74\171\160\x65"] == NGSGiftService::GIFT_TYPE_MOBILE_FEE) {
            goto j4dRJ;
        }
        goto eHU3e;
        AXe_8:
        if (!empty($address["\x6d\157\x62\x69\154\145"])) {
            goto ryg42;
        }
        goto RvckO;
        J1zif:
        if (!is_null($address)) {
            goto owgxw;
        }
        goto sM0wf;
        BFmpt:
        if (!empty($address["\x6d\157\x62\x69\154\x65"])) {
            goto U4kEn;
        }
        goto pbG6Z;
        GXslD:
        pehN1:
        goto AXe_8;
        sfmbJ:
        U4kEn:
        goto W2L8q;
        FhsVa:
        ryg42:
        goto kSAJZ;
        RvckO:
        throw new Exception("\346\211\213\346\234\272\345\217\xb7\347\xa0\201\xe4\270\215\xe8\203\xbd\344\270\xba\xe7\251\xba", 4805);
        goto FhsVa;
        eHU3e:
        if ($gift["\164\171\x70\145"] == NGSGiftService::GIFT_TYPE_MOBILE_LL) {
            goto pehN1;
        }
        goto WQc3x;
        W2L8q:
        goto fDIYc;
        goto GXslD;
        pbG6Z:
        throw new Exception("\xe6\x89\x8b\346\x9c\272\xe5\217\xb7\xe7\240\x81\xe4\270\x8d\350\x83\275\xe4\xb8\xba\xe7\xa9\272", 4805);
        goto sfmbJ;
        kmNSx:
        throw new Exception("\346\224\266\xe8\264\xa7\xe4\xbf\241\xe6\x81\xaf\344\270\x8d\345\xae\x8c\346\x95\264\357\274\x8c\346\211\213\xe6\234\272\xe3\x80\201\xe5\xa7\223\xe5\x90\215\343\x80\x81\350\xaf\xa6\347\xbb\x86\345\x9c\260\345\x9d\x80\345\x9d\x87\344\270\xba\345\277\205\xe5\241\xab\351\241\271\347\x9b\256", 4806);
        goto kjy8k;
        kSAJZ:
        fDIYc:
        goto m8wgV;
        sM0wf:
        throw new Exception("\xe8\257\xb7\xe5\xa1\253\345\x86\231\xe6\x94\266\xe8\264\xa7\xe4\xbf\xa1\xe6\x81\xaf", 48066);
        goto b9HJS;
        m8wgV:
    }
    /**
     * 获取红包金额
     * @param array $gift
     * @return mixed
     */
    private function getHbAmount($gift)
    {
        goto OmXyD;
        fAu2p:
        if ($gift["\x68\x62\x5f\x6d\157\x64\145"] == NGSGiftService::GIFT_HB_MODE_RANDOM_AMOUNT) {
            goto U3Tdw;
        }
        goto RxmtS;
        hls0c:
        kHu0a:
        goto q59e1;
        q59e1:
        return $gift["\x68\142\137\x61\155\157\x75\x6e\164"];
        goto eMEDY;
        bHbW8:
        $max = $gift["\x68\x62\137\x72\x61\x6e\144\157\155\x5f\x6d\x61\170"];
        goto z1yUK;
        NDwhu:
        ba_NV:
        goto PovXB;
        z1yUK:
        $random = intval(rand($min * 100, $max * 100)) / 100;
        goto e77W7;
        e77W7:
        return $random;
        goto NDwhu;
        RxmtS:
        goto ba_NV;
        goto hls0c;
        OmXyD:
        if ($gift["\150\x62\137\155\157\144\x65"] == NGSGiftService::GIFT_HB_MODE_FIXED_AMOUNT) {
            goto kHu0a;
        }
        goto fAu2p;
        eMEDY:
        goto ba_NV;
        goto a3yGV;
        a3yGV:
        U3Tdw:
        goto UImNN;
        UImNN:
        $min = $gift["\x68\142\137\162\x61\x6e\144\x6f\x6d\x5f\x6d\151\x6e"];
        goto bHbW8;
        PovXB:
    }
    public function getOrderSuccessMessageTip($order)
    {
    }
    public function getOrderDetailByOrderNum($orderNum)
    {
        goto rpU55;
        iXdK6:
        return $order;
        goto cV_xc;
        rpU55:
        global $_GPC;
        goto U4ZSq;
        hqpIr:
        $this->log($_GPC, "\xe7\x94\250\346\x88\267\xe6\240\xb8\351\x94\x80\357\274\x8c\xe6\212\245\xe9\224\231\346\x8f\220\xe7\244\272\xef\xbc\xbb\xe8\256\242\345\x8d\x95\344\xb8\215\xe5\xad\x98\345\234\250\xef\274\xbd{$orderNum}\54\xe7\224\xa8\346\x88\267\xe6\217\x90\344\272\244\346\225\260\xe6\215\256\xe5\246\x82\344\270\213");
        goto Zzww8;
        JpxM1:
        D1EJP:
        goto iXdK6;
        Zzww8:
        throw new Exception("\xe8\256\xa2\xe5\x8d\225\344\270\x8d\345\xad\230\xe5\x9c\xa8", 4807);
        goto JpxM1;
        CzAq0:
        if (!empty($order)) {
            goto D1EJP;
        }
        goto hqpIr;
        U4ZSq:
        $order = $this->selectOne("\x20\141\x6e\x64\40\157\x72\144\x65\x72\137\156\165\x6d\x3d\47{$orderNum}\x27");
        goto CzAq0;
        cV_xc:
    }
    private function check_status_before_safe_check($order)
    {
        goto ws2VR;
        ws2VR:
        if (!($order["\x73\164\x61\164\x75\163"] == NGSOrderService::ORDER_STATUS_SUCCESS)) {
            goto QxOiz;
        }
        goto wg4cj;
        GKmak:
        if (!($order["\x72\x61\146\x66\154\x65"] == NGSGiftService::GIFT_RAFFLE && $order["\162\141\x66\x66\x6c\145\x5f\163\164\x61\164\x75\163"] == NGSOrderService::ORDER_RAFFLE_FAIL)) {
            goto Yboxf;
        }
        goto kCXpe;
        kCXpe:
        throw new Exception("\xe5\xa4\261\xe8\264\245\72\xe8\257\xa5\350\xae\xa2\345\x8d\x95\xe4\xb8\xba\xe6\212\275\xe5\245\x96\xe8\xae\242\345\x8d\225\xef\xbc\x8c\xe6\212\275\xe5\245\x96\xe5\244\261\xe8\xb4\245\x2c\346\227\240\346\xb3\225\xe9\x80\232\350\277\x87", 4808);
        goto SWZ_Z;
        wg4cj:
        throw new Exception("\xe5\244\xb1\xe8\xb4\xa5\x3a\xe8\257\xa5\350\256\242\345\215\225\xe5\xb7\262\xe7\xbb\x8f\xe5\256\214\xe6\210\x90\54\xe6\x97\240\xe9\234\x80\351\207\215\xe5\244\x8d\xe5\xae\xa1\346\xa0\xb8", 4808);
        goto MpwXM;
        MpwXM:
        QxOiz:
        goto VzGqn;
        g_D6c:
        throw new Exception("\345\244\xb1\xe8\264\245\72\xe8\257\xa5\xe8\xae\242\xe5\x8d\225\345\267\xb2\xe7\273\217\350\242\253\xe6\213\x92\xe7\273\235\xef\274\214\346\213\222\xe7\xbb\235\345\x8e\x9f\xe5\233\xa0\72{$order["\162\x65\x6d\141\162\153"]}", 4808);
        goto qpnUj;
        VzGqn:
        if (!($order["\163\164\x61\164\165\x73"] == NGSOrderService::ORDER_STATUS_REFUSED)) {
            goto HfKed;
        }
        goto g_D6c;
        qpnUj:
        HfKed:
        goto GKmak;
        SWZ_Z:
        Yboxf:
        goto XoytD;
        XoytD:
    }
    public function accessOrder($orderNum)
    {
        goto OYfrO;
        Dvf1d:
        E0YFJ:
        goto S0FLy;
        FwcP_:
        if (!($order["\164\171\160\x65"] == NGSGiftService::GIFT_TYPE_SEND)) {
            goto YoCcq;
        }
        goto XMK5r;
        jx1ND:
        pzFfO:
        goto BxXwH;
        ISf0G:
        khXoU:
        goto hnPbx;
        ZV_nC:
        $order = $this->getOrderDetailByOrderNum($orderNum);
        goto AnIh3;
        Ez78f:
        E6jEy:
        goto Qj2Wu;
        JTRuK:
        return $this->updateData($order);
        goto I7SdC;
        WCDiF:
        $password = trim($quan["\x76\141\x6c\165\x65"]) == '' ? "\xe6\x97\240" : $quan["\166\141\x6c\x75\145"];
        goto k0Psy;
        pqa35:
        $this->flashUserService->addUserMoney($order["\162\145\x77\141\162\x64\x5f\x61\x6d\157\165\x6e\164"], $order["\157\x70\145\156\x69\x64"], "\xe8\xb4\255\xe4\271\260\345\225\206\345\x93\201\344\275\x99\xe9\242\x9d\xe5\245\x96\xe5\x8a\261");
        goto sSnn5;
        bEpUu:
        XsxIG:
        goto vOJO4;
        Qj2Wu:
        XH4oY:
        goto DFuOy;
        u7fRC:
        throw new Exception("\xe5\244\xb1\350\264\245\72\xe8\257\xa5\xe8\256\xa2\xe5\x8d\x95\xe6\x9c\252\xe6\224\xaf\xe4\xbb\x98\54\344\270\215\350\203\275\xe9\200\x9a\xe8\277\207", 4809);
        goto bEpUu;
        Utt8w:
        if (!($order["\164\171\160\x65"] == NGSGiftService::GIFT_TYPE_SCORE_RAFFLE)) {
            goto hTtgp;
        }
        goto sXsbZ;
        NVFzj:
        $openid = $config["\155\157\144\x65"] == NGSHbService::MODE_BORROW_OAUTH ? $user["\x62\157\162\162\157\167\137\x6f\x70\x65\156\151\144"] : $user["\157\160\x65\x6e\x69\x64"];
        goto ISnI9;
        vOJO4:
        oncCb:
        goto JuZyt;
        XMK5r:
        YoCcq:
        goto S7CBL;
        lNRMU:
        throw new Exception("\xe7\xa7\257\xe5\x88\x86\345\xb7\xb2\xe7\273\x8f\345\xa5\x96\345\212\xb1\357\xbc\214\346\x97\xa0\351\234\x80\xe9\x87\215\345\244\215\xe5\xa5\x96\345\212\xb1", 4808);
        goto ISf0G;
        mD_6A:
        $quan = $this->quanService->giveAQuanToUser($image["\147\151\146\164\x5f\151\144"], $user);
        goto zlMrV;
        hnPbx:
        $this->flashUserService->addUserScore($order["\162\141\x66\146\x6c\145\137\x73\143\x6f\x72\x65\x5f\141\x6d\157\165\x6e\164"], $order["\x6f\160\145\156\x69\x64"], "\347\xa7\257\xe5\210\x86\xe5\225\x86\xe5\x9f\x8e\xe6\x8a\275\347\247\257\345\210\x86\344\xb8\255\345\xa5\226");
        goto hgxOK;
        VtScb:
        $image = $this->giftImageService->selectById($order["\x67\x69\x66\164\137\151\x64"]);
        goto D7sbO;
        AnIh3:
        $user = $this->userService->selectById($order["\x75\163\145\162\x5f\151\x64"]);
        goto lfQI8;
        pmTN6:
        if (!($order["\x72\x65\167\x61\x72\x64\x5f\141\x6d\x6f\165\156\x74"] > 0)) {
            goto k40DN;
        }
        goto pqa35;
        JuZyt:
        if (!($order["\x74\171\x70\x65"] == 3)) {
            goto LghCN;
        }
        goto Ghq_G;
        ISnI9:
        $money = $order["\150\142\137\141\155\x6f\165\x6e\x74"];
        goto NmkZe;
        sSnn5:
        k40DN:
        goto VhfkK;
        MpOoE:
        if (!($order["\160\141\171\x5f\x73\x74\141\x74\165\x73"] == 0 && $order["\x6f\x72\x64\145\x72\x5f\155\x6f\x6e\145\171"] > 0)) {
            goto XsxIG;
        }
        goto u7fRC;
        KMKfZ:
        if (!($order["\x73\164\x61\164\x75\163"] == NGSOrderService::ORDER_STATUS_DEFAULT)) {
            goto XH4oY;
        }
        goto VtScb;
        DFuOy:
        $order["\163\164\x61\164\165\x73"] = NGSOrderService::ORDER_STATUS_SUCCESS;
        goto JTRuK;
        Sglli:
        SLsAM:
        goto Utt8w;
        QtH4m:
        if (!($order["\x74\x79\160\145"] == NGSGiftService::GIFT_TYPE_MOBILE_FEE)) {
            goto pzFfO;
        }
        goto jx1ND;
        D7sbO:
        if (!($order["\x74\171\x70\x65"] == NGSGiftService::GIFT_TYPE_RED_PACKETS)) {
            goto jh_iS;
        }
        goto Nf6gk;
        nk82L:
        qI01S:
        goto QtH4m;
        S0FLy:
        jh_iS:
        goto vbnUt;
        oi3Kf:
        if (!($order["\x72\x65\167\141\x72\144\x5f\163\x63\157\x72\x65"] > 0)) {
            goto KJLMl;
        }
        goto sYx6N;
        wTSQC:
        throw new Exception("\345\xa4\xb1\xe8\264\xa5\x3a\347\x94\250\346\x88\xb7\xe8\xbf\x98\xe6\xb2\241\346\x9c\211\xe6\x94\xaf\344\273\230\xe9\202\xae\xe8\xb4\271", 4809);
        goto TpQoy;
        vbnUt:
        if (!($order["\x74\171\x70\145"] == NGSGiftService::GIFT_TYPE_VIRTUAL)) {
            goto lWY51;
        }
        goto mD_6A;
        sXsbZ:
        if (!($order["\162\141\146\146\154\145\137\x73\x63\157\162\145\x5f\163\164\x61\x74\165\x73"] == NGSOrderService::ORDER_RAFFLE_SCORE_STATUS_OK)) {
            goto khXoU;
        }
        goto lNRMU;
        zlMrV:
        $order["\x71\x75\x61\x6e\x5f\163\164\x61\x74\x75\x73"] = NGSOrderService::ORDER_QUAN_STATUS_SEND_OK;
        goto zpNKs;
        lfQI8:
        $this->check_status_before_safe_check($order);
        goto lWv3B;
        fwREZ:
        KJLMl:
        goto pmTN6;
        OCK30:
        $this->sendTextMessage($order["\x6f\160\x65\156\x69\x64"], $message);
        goto FatrU;
        k0Psy:
        $message = "\346\x82\250\xe5\205\221\346\x8d\242\xe7\x9a\204\133{$image["\x74\x69\164\154\145"]}\x5d\xe5\x8d\241\xe5\xaf\x86\xe5\xa6\x82\xe4\270\x8b\xef\xbc\232\xa\xe5\215\241\345\x8f\267\x3a{$quan["\150\x61\157"]}\12\345\215\xa1\xe5\xaf\x86\72{$password}";
        goto OCK30;
        OYfrO:
        global $_W, $_GPC;
        goto ZV_nC;
        hgxOK:
        hTtgp:
        goto rf1R0;
        BxXwH:
        if (!($order["\164\171\160\145"] == NGSGiftService::GIFT_TYPE_MOBILE_LL)) {
            goto SLsAM;
        }
        goto Sglli;
        sYx6N:
        $this->flashUserService->addUserScore($order["\162\x65\x77\141\x72\144\137\x73\x63\x6f\162\145"], $order["\x6f\x70\145\156\151\144"], "\350\264\xad\xe4\xb9\260\xe5\x95\x86\345\223\x81\xe7\247\257\345\210\x86\345\xa5\x96\xe5\x8a\261");
        goto fwREZ;
        zpNKs:
        $order["\x71\165\141\156\x5f\151\144"] = $quan["\x69\x64"];
        goto WCDiF;
        TpQoy:
        Bn6zP:
        goto qtvAx;
        VhfkK:
        if (!(!is_null($order["\x69\156\x76\x69\164\x65\137\165\x73\x65\162\137\151\x64"]) && $order["\x69\x6e\166\x69\x74\x65\x5f\x75\x73\145\x72\137\151\x64"] > 0)) {
            goto E6jEy;
        }
        goto wlYO1;
        Nf6gk:
        if (!($order["\x68\142\137\163\164\x61\x74\165\x73"] == NGSOrderService::ORDER_HB_STATUS_NO_SEND)) {
            goto E0YFJ;
        }
        goto H17ek;
        wlYO1:
        $this->userService->orderChargeShareUser($order["\151\156\166\x69\164\145\x5f\x75\163\x65\x72\x5f\x69\x64"], $order, $image);
        goto Ez78f;
        qtvAx:
        LghCN:
        goto KMKfZ;
        rf1R0:
        $this->noticeService->sendGiftOrderCheckStatusAccessNotice($order["\157\160\145\x6e\x69\144"], $image["\x74\151\164\154\x65"]);
        goto oi3Kf;
        Ghq_G:
        if (!($order["\164\162\x61\x6e\x73\x5f\146\145\145"] > 0 && $order["\x74\162\141\x6e\163\x5f\x66\x65\145\137\x73\x74\141\164\x75\x73"] == 1)) {
            goto Bn6zP;
        }
        goto wTSQC;
        H17ek:
        $config = $this->hbService->getHbConfig($_W["\165\x6e\x69\x61\x63\x69\x64"]);
        goto NVFzj;
        lWv3B:
        if (!($order["\x62\x75\x79\x5f\164\171\160\145"] == 2 || $order["\142\x75\x79\137\x74\x79\160\145"] == 2)) {
            goto oncCb;
        }
        goto MpOoE;
        S7CBL:
        if (!($order["\164\171\160\145"] == NGSGiftService::GIFT_TYPE_ZL)) {
            goto qI01S;
        }
        goto nk82L;
        FatrU:
        lWY51:
        goto FwcP_;
        NmkZe:
        try {
            $this->hbService->send($openid, $money);
            $order["\x68\142\137\x73\164\x61\164\165\x73"] = NGSOrderService::ORDER_HB_STATUS_SEND;
        } catch (Exception $e) {
            goto ntRWA;
            R3CxN:
            $order["\x61\x62\x6e\x6f\162\x6d\141\154"] = NGSOrderService::ORDER_ABNORMAL;
            goto H2bTG;
            ntRWA:
            $this->log($e->getTrace(), $e->getMessage() . "\347\272\242\345\x8c\205\345\217\221\346\x94\276\xe5\xa4\xb1\350\xb4\245\xe5\x8e\237\345\x9b\xa0");
            goto h3l52;
            h3l52:
            $order["\x68\142\x5f\163\164\x61\164\165\163"] = NGSOrderService::ORDER_HB_STATUS_SEND_ERROR;
            goto iApC9;
            H2bTG:
            throw new Exception("\xe7\272\242\xe5\214\x85\xe5\217\x91\346\224\xbe\xe5\244\xb1\xe8\xb4\xa5\x5b{$e->getMessage()}\135\357\274\214\351\x80\x9a\350\xbf\x87\xe5\xa4\261\350\264\xa5", 400);
            goto rxGqB;
            iApC9:
            $order["\162\x65\x6d\x61\162\153"] .= "\x2d\55\55\55\347\272\xa2\345\x8c\205\xe5\x8f\x91\xe6\224\xbe\xe5\244\261\xe8\xb4\245\345\x8e\237\xe5\233\xa0" . $e->getMessage();
            goto R3CxN;
            rxGqB:
        }
        goto Dvf1d;
        I7SdC:
    }
    public function refuseOrder($orderNum, $remark)
    {
        goto vyVmT;
        p0_Zq:
        $this->flashUserService->addUserMoney($order["\x6f\162\144\x65\x72\x5f\x6d\157\x6e\x65\x79"], $user["\x6f\x70\145\x6e\151\x64"], "\xe8\xae\xa2\345\215\225\xe6\213\x92\347\273\x9d\xef\xbc\214\xe7\216\xb0\xe9\207\221\351\x80\x80\xe5\233\x9e");
        goto LMO_m;
        ImJno:
        if (!(($order["\142\x75\171\x5f\164\x79\160\145"] == NGSGiftService::GIFT_BUY_TYPE_MONEY || $order["\142\x75\171\x5f\164\171\160\145"] == NGSGiftService::GIFT_BUY_TYPE_SCORE_AND_MONEY) && $order["\x6f\x72\x64\145\x72\x5f\155\x6f\x6e\145\171"] > 0 && $order["\x70\141\171\x5f\x73\164\141\164\165\x73"])) {
            goto zkO7M;
        }
        goto p0_Zq;
        JjeLH:
        $order = $this->getOrderDetailByOrderNum($orderNum);
        goto JVJi0;
        Phl98:
        $this->flashUserService->addUserScore($order["\157\x72\144\145\162\x5f\163\143\x6f\x72\145"], $user["\157\160\145\156\x69\144"], "\350\256\242\345\215\225\xe6\x8b\x92\347\xbb\x9d\357\xbc\214\xe7\xa7\257\xe5\210\x86\xe9\x80\200\345\x9b\236");
        goto bcHXX;
        vwyjR:
        $order["\x72\145\155\x61\x72\x6b"] = $remark;
        goto fbaAP;
        Fk19l:
        $order["\163\x74\x61\x74\x75\x73"] = NGSOrderService::ORDER_STATUS_REFUSED;
        goto vwyjR;
        KbcoY:
        $this->noticeService->sendGiftOrderCheckStatusRefuseNotice($order["\x6f\x70\145\x6e\151\144"], $image["\x74\x69\164\x6c\145"], $remark);
        goto U8LpV;
        JVJi0:
        $user = $this->userService->selectById($order["\x75\x73\x65\x72\137\151\x64"]);
        goto npuy4;
        fbaAP:
        $image = $this->giftImageService->selectById($order["\x67\x69\x66\164\137\x69\144"]);
        goto KbcoY;
        vyVmT:
        global $_W, $_GPC;
        goto JjeLH;
        bcHXX:
        i_p4h:
        goto ImJno;
        npuy4:
        $this->check_status_before_safe_check($order);
        goto Fk19l;
        U8LpV:
        $this->updateData($order);
        goto OJXxy;
        LMO_m:
        zkO7M:
        goto ah_H1;
        OJXxy:
        if (!($order["\142\165\171\137\164\171\x70\x65"] == NGSGiftService::GIFT_BUY_TYPE_SCORE || $order["\x62\x75\x79\x5f\164\x79\x70\145"] == NGSGiftService::GIFT_BUY_TYPE_SCORE_AND_MONEY)) {
            goto i_p4h;
        }
        goto Phl98;
        ah_H1:
    }
    public function sendOrderRedPackage($orderOrNum)
    {
        goto LEuEk;
        i2heU:
        $order = array();
        goto sDKps;
        d_A2b:
        $config = $this->hbService->getHbConfig($_W["\x75\156\x69\x61\x63\151\x64"]);
        goto UpszO;
        UpszO:
        $openid = $config["\x6d\157\x64\145"] == NGSHbService::MODE_BORROW_OAUTH ? $user["\142\157\162\x72\157\167\x5f\x6f\x70\x65\x6e\x69\144"] : $user["\157\x70\x65\x6e\151\144"];
        goto Ek3lK;
        jc8Bh:
        goto vBIbd;
        goto rxM1_;
        Ek3lK:
        $money = $order["\x68\x62\137\x61\x6d\x6f\x75\156\x74"];
        goto hwlUZ;
        sDKps:
        if (is_array($orderOrNum)) {
            goto gEOPF;
        }
        goto fkzQ2;
        tCv83:
        if (!($order["\x68\x62\x5f\163\164\x61\x74\x75\163"] == NGSOrderService::ORDER_HB_STATUS_SEND)) {
            goto qfcTq;
        }
        goto UvUgO;
        LEuEk:
        global $_W;
        goto i2heU;
        UvUgO:
        throw new Exception("\xe8\xaf\xa5\350\xae\xa2\345\x8d\225\xe7\xba\xa2\345\214\205\xe5\xb7\xb2\xe5\217\221\xe9\x80\x81\xef\xbc\x8c\xe6\227\xa0\xe9\234\200\345\x86\215\346\254\241\xe5\217\221\xe9\x80\x81", 4808);
        goto Sgz7n;
        rxM1_:
        gEOPF:
        goto RUHaz;
        fkzQ2:
        $order = $this->getOrderDetailByOrderNum($orderOrNum);
        goto jc8Bh;
        uLEdj:
        vBIbd:
        goto FPtQg;
        FPtQg:
        $user = $this->userService->selectById($order["\165\163\x65\x72\x5f\151\144"]);
        goto AHtN2;
        Yy00W:
        DmDWd:
        goto Kfb5G;
        RUHaz:
        $order = $orderOrNum;
        goto uLEdj;
        AHtN2:
        if (!($order["\164\171\160\145"] == NGSGiftService::GIFT_TYPE_RED_PACKETS)) {
            goto DmDWd;
        }
        goto tCv83;
        Sgz7n:
        qfcTq:
        goto d_A2b;
        hwlUZ:
        try {
            goto ZBUc3;
            vFJVx:
            $order["\x68\142\137\163\x74\141\164\165\x73"] = NGSOrderService::ORDER_HB_STATUS_SEND;
            goto iLxZj;
            ZBUc3:
            $this->hbService->send($openid, $money);
            goto vFJVx;
            iLxZj:
            $this->updateData($order);
            goto RS6mz;
            RS6mz:
        } catch (Exception $e) {
            goto xP432;
            WLV6F:
            throw new Exception("\347\xba\xa2\xe5\214\205\xe5\217\x91\xe6\224\276\xe5\xa4\xb1\xe8\xb4\xa5{$e->getMessage()}", $e->getCode());
            goto XgV4n;
            xP432:
            $order["\x68\x62\x5f\x73\x74\141\164\165\x73"] = NGSOrderService::ORDER_HB_STATUS_SEND_ERROR;
            goto TnTGI;
            TnTGI:
            $this->updateData($order);
            goto WLV6F;
            XgV4n:
        }
        goto Yy00W;
        Kfb5G:
    }
    /**
     * 1.自己领取 2管理员设置
     * @param $orderNum
     * @param int $type
     * @throws Exception
     */
    public function zlConfirm($orderNum, $type = 1)
    {
        goto TVkdV;
        QQXQ4:
        lzis4:
        goto uNk03;
        HYOTd:
        if (!($order["\163\164\141\164\165\163"] != NGSOrderService::ORDER_STATUS_SUCCESS)) {
            goto tmH3J;
        }
        goto DpsMz;
        PHjzu:
        throw new Exception("\346\xa0\xb8\351\224\200\xe8\xbf\207\xe6\x9c\237\x3a\xe8\257\xb7\345\x9c\xa8\xe5\205\x91\xe6\x8d\xa2\xe5\220\216{$good["\x76\x61\154\151\x64\137\144\x61\164\145\137\141\146\x74\x65\x72\137\x64\141\x79\163"]}\xe5\xa4\xa9\345\206\x85\xe4\xbd\277\xe7\x94\xa8\xef\xbc\x8c\xe6\x82\250\345\267\xb2\350\xb6\x85\346\234\237\xef\xbc\x8c\345\x85\x91\346\215\242\346\x97\266\xe9\227\264\133{$orderDate}\x5d\41\x28\x5e\xcf\x89\136\x29");
        goto kn2ws;
        KGdVm:
        throw new Exception("\345\244\261\xe8\xb4\245\72\350\257\245\xe7\244\xbc\345\223\201\xe5\267\xb2\347\273\x8f\350\242\xab\351\xa2\206\345\217\x96\xef\xbc\214\351\xa2\206\345\217\x96\xe6\227\xb6\351\227\xb4" . date("\x59\x2d\155\x2d\x64\x20\110\x3a\151\x3a\163", $order["\172\x6c\x5f\x74\x69\x6d\145"]), 48010);
        goto u6lI8;
        voq1U:
        goto b8fH5;
        goto Fj5eU;
        QzfY_:
        $good = $this->giftImageService->selectById($order["\147\x69\x66\164\137\151\144"]);
        goto HYOTd;
        K7C1G:
        $startValidate = strtotime($good["\166\x61\154\151\144\141\164\145\137\163\164\141\x72\164\x5f\x64\141\x74\x65"]);
        goto B1W6h;
        yBC6M:
        throw new Exception("\xe6\xa0\xb8\xe9\x94\x80\xe5\244\xb1\xe8\264\xa5\x3a\xe8\xaf\xb7\344\xba\216" . $good["\x76\x61\154\151\144\141\164\145\x5f\x73\164\x61\x72\x74\137\x64\x61\x74\x65"] . "\345\x88\260" . $good["\x76\141\x6c\x69\x64\141\x74\145\137\x65\x6e\x64\x5f\x64\141\x74\x65"] . "\345\x89\215\345\276\200\x5b" . $good["\x6c\x69\x6e\153\137\x61\x64\144\162\x65\x73\163"] . "\135\xe9\xa2\x86\xe5\x8f\x96\41\50\x5e\xcf\x89\x5e\x29");
        goto LhQ4u;
        xO3uz:
        $order = $this->getOrderDetailByOrderNum($orderNum);
        goto QzfY_;
        Fj5eU:
        CQOJA:
        goto Fm4Nm;
        wLBsp:
        $this->updateData($order);
        goto rTXUz;
        r4yNx:
        if (!(time() > $validEndDate)) {
            goto XzT5v;
        }
        goto PHjzu;
        rTXUz:
        b8fH5:
        goto DDOgd;
        uNk03:
        $orderDate = date("\x59\x2d\155\x2d\x64\40\x48\72\151\x3a\163", $order["\x63\x72\x65\x61\x74\x65\x5f\164\151\155\145"]);
        goto s4k10;
        KB1j1:
        $order["\172\x6c\137\163\164\141\164\165\163"] = NGSOrderService::ORDER_ZL_STATUS_OK;
        goto tkCxC;
        jiKGy:
        if ($good["\166\141\154\151\x64\137\x64\x61\x74\x65\137\164\x79\160\x65"] == 1 || empty($good["\x76\x61\154\x69\144\137\x64\141\164\145\137\164\171\x70\145"])) {
            goto Yjon0;
        }
        goto qwoni;
        qwoni:
        if ($good["\x76\x61\x6c\x69\x64\x5f\x64\141\x74\145\137\x74\x79\x70\145"] == 2) {
            goto lzis4;
        }
        goto RJRXB;
        Fm4Nm:
        $this->log($order, "\xe8\xae\xa2\xe5\x8d\225\344\277\241\xe6\x81\257\x3a");
        goto r43nB;
        Xpmyy:
        KbG3C:
        goto S5NrE;
        tkCxC:
        $order["\172\x6c\x5f\x74\x69\x6d\145"] = time();
        goto wLBsp;
        ZnK1q:
        if (!(time() < $startValidate && $startValidate > 0)) {
            goto gPNTU;
        }
        goto yBC6M;
        eB9gn:
        tmH3J:
        goto K7C1G;
        kn2ws:
        XzT5v:
        goto Xpmyy;
        cI179:
        throw new Exception("\351\235\236\346\263\x95\xe6\x93\215\xe4\xbd\234\xef\274\214\xe7\244\xbc\345\223\x81\xe7\261\273\345\236\213\344\xb8\215\346\255\243\xe7\xa1\256", 48010);
        goto voq1U;
        ghPxa:
        Yjon0:
        goto ZnK1q;
        We3_m:
        throw new Exception("\346\xa0\270\xe9\224\200\350\277\x87\xe6\234\x9f\x3a\xe8\xaf\xa5\347\244\xbc\345\x93\201\345\xb7\262\xe4\272\x8e" . $good["\166\141\x6c\151\144\141\164\145\137\x65\156\x64\x5f\x64\x61\164\145"] . "\xe5\201\x9c\xe6\255\xa2\xe9\242\x86\xe5\217\x96" . strtotime($good["\166\x61\x6c\151\x64\x61\164\145\x5f\145\156\x64\x5f\x64\141\164\x65"]) . "\41\50\136\xcf\211\x5e\51");
        goto Lz5EE;
        mTimT:
        if (!(time() > $endValidate && $endValidate > 0)) {
            goto fFRm6;
        }
        goto We3_m;
        r43nB:
        if (!($order["\172\154\x5f\x73\x74\141\164\165\163"] == NGSOrderService::ORDER_ZL_STATUS_OK)) {
            goto ZmFpC;
        }
        goto KGdVm;
        RJRXB:
        goto KbG3C;
        goto ghPxa;
        TVkdV:
        global $_W;
        goto xO3uz;
        LhQ4u:
        gPNTU:
        goto mTimT;
        s4k10:
        $validEndDate = $order["\143\x72\145\141\164\145\x5f\x74\151\x6d\145"] + $good["\166\x61\154\151\144\137\x64\141\164\145\x5f\x61\x66\x74\145\162\x5f\x64\141\x79\x73"] * 86400;
        goto r4yNx;
        S5NrE:
        if ($order["\x74\171\x70\145"] == NGSGiftService::GIFT_TYPE_ZL) {
            goto CQOJA;
        }
        goto cI179;
        PUxKk:
        goto KbG3C;
        goto QQXQ4;
        Lz5EE:
        fFRm6:
        goto PUxKk;
        DpsMz:
        throw new Exception("\350\256\xa2\345\215\225\345\xb0\x9a\xe6\x9c\xaa\345\256\241\xe6\240\xb8\357\274\214\350\257\267\347\xad\211\xe5\xbe\205\347\256\241\347\x90\206\xe5\221\x98\xe5\xae\xa1\xe6\xa0\270\xe5\x90\216\xe9\242\206\xe5\x8f\226\x21", 48010);
        goto eB9gn;
        B1W6h:
        $endValidate = strtotime($good["\166\x61\x6c\x69\144\x61\x74\145\137\x65\x6e\x64\x5f\144\x61\x74\145"]);
        goto jiKGy;
        u6lI8:
        ZmFpC:
        goto KB1j1;
        DDOgd:
    }
    public function takeOverConfirm($orderNum)
    {
        goto hqj1v;
        hzpmD:
        goto dehsR;
        goto HK_ia;
        mL9AY:
        dehsR:
        goto qMtRw;
        dBj0h:
        if ($order["\x74\171\x70\145"] == NGSGiftService::GIFT_TYPE_SEND) {
            goto AqEpy;
        }
        goto SAr43;
        de4H0:
        dG_xK:
        goto dBj0h;
        ydHZM:
        $order["\164\x72\141\x6e\163\x5f\143\157\x6e\146\151\162\155\137\x74\151\155\145"] = time();
        goto T04yI;
        HK_ia:
        AqEpy:
        goto cBwF4;
        TuN8D:
        throw new Exception("\350\256\xa2\xe5\215\225\345\260\232\346\x9c\252\xe5\xae\xa1\346\xa0\270\xef\274\214\350\xaf\xb7\xe7\255\211\345\xbe\205\xe7\256\xa1\347\220\206\xe5\x91\230\345\xae\241\xe6\xa0\270\xe5\x90\216\xe9\242\x86\xe5\217\x96\x21", 48010);
        goto de4H0;
        SAr43:
        throw new Exception("\351\x9d\x9e\xe6\xb3\x95\346\x93\215\344\xbd\x9c\357\274\214\347\244\274\xe5\223\201\xe7\261\273\xe5\x9e\x8b\344\270\215\xe6\xad\243\347\241\256", 48010);
        goto hzpmD;
        AS5AI:
        YjyOV:
        goto yIMv2;
        hqj1v:
        global $_W;
        goto zJDUf;
        yIMv2:
        $order["\x74\x72\141\x6e\x73\x5f\x73\164\x61\164\165\163"] = NGSOrderService::ORDER_TRANS_STATUS_RECEIVE;
        goto ydHZM;
        zJDUf:
        $order = $this->getOrderDetailByOrderNum($orderNum);
        goto EFLT0;
        T04yI:
        $this->updateData($order);
        goto mL9AY;
        EFLT0:
        if (!($order["\x73\164\x61\164\x75\163"] != NGSOrderService::ORDER_STATUS_SUCCESS)) {
            goto dG_xK;
        }
        goto TuN8D;
        cBwF4:
        if (!($order["\x74\162\141\x6e\163\137\163\164\x61\x74\165\163"] == NGSOrderService::ORDER_TRANS_STATUS_RECEIVE)) {
            goto YjyOV;
        }
        goto ngEiH;
        ngEiH:
        throw new Exception("\xe5\xa4\261\xe8\xb4\245\72\350\257\xa5\347\xa4\274\xe5\x93\201\345\267\262\xe7\xbb\x8f\xe8\242\253\347\241\xae\350\xae\xa4\xe6\224\xb6\350\xb4\xa7\357\xbc\214\347\241\xae\350\256\xa4\346\227\xb6\351\227\264" . date("\131\x2d\155\x2d\144\40\x48\x3a\151\72\x73", $order["\x7a\x6c\137\164\x69\155\x65"]), 48010);
        goto AS5AI;
        qMtRw:
    }
    public function payCallBack($orderNum)
    {
        goto Xz13h;
        MFt1u:
        if (!($gift["\162\145\144\x75\x63\x65\137\164\x79\x70\x65"] == 2)) {
            goto k_7oq;
        }
        goto BYmvc;
        BYmvc:
        $this->giftService->reduceOneGift($gift["\x69\144"]);
        goto z6Ggj;
        Xz13h:
        $order = $this->getOrderDetailByOrderNum($orderNum);
        goto J_Ss2;
        LYJW8:
        if (!($image["\x61\x75\164\x6f"] == NGSGiftService::GIFT_AUTO)) {
            goto vD9ui;
        }
        goto yFn8B;
        YBVhp:
        vD9ui:
        goto qTCKe;
        FlgYO:
        if (!($order["\164\171\160\x65"] == NGSGiftService::GIFT_TYPE_SEND)) {
            goto DDUP1;
        }
        goto CHv0g;
        vYsSf:
        $gift = $this->giftService->selectById($image["\x67\x69\146\164\137\x69\144"]);
        goto MFt1u;
        qTCKe:
        $order = $this->updateData($order);
        goto tvnP_;
        z6Ggj:
        k_7oq:
        goto LYJW8;
        YmxdP:
        $this->noticeService->sendGetGiftSuccessNotice($order["\x6f\160\x65\156\151\x64"], $image["\164\151\x74\x6c\x65"], $order["\x6f\162\144\x65\x72\x5f\x73\x63\x6f\x72\145"] . "\xe7\xa7\xaf\345\210\x86\x2b" . $order["\x6f\x72\x64\145\162\x5f\155\x6f\156\x65\171"] . "\345\205\x83", $credits["\x63\x72\x65\144\151\x74\x31"] . "\347\xa7\257\xe5\x88\206\53" . $credits["\143\162\x65\x64\x69\x74\x32"] . "\xe4\275\x99\xe9\242\235");
        goto VLzV9;
        CHv0g:
        $order["\164\x72\x61\x6e\x73\x5f\x66\x65\x65\137\x73\164\141\164\x75\163"] = NGSOrderService::ORDER_TRANS_FEE_STATUS_PAID;
        goto CZuLc;
        VLzV9:
        return $order;
        goto V2zGs;
        zX4yn:
        if (!($order["\x62\x75\x79\137\164\x79\x70\145"] == NGSGiftService::GIFT_BUY_TYPE_SCORE_AND_MONEY || NGSGiftService::GIFT_BUY_TYPE_MONEY)) {
            goto x1z4x;
        }
        goto Emgc0;
        yFn8B:
        $this->accessOrder($order["\157\x72\x64\145\x72\137\x6e\165\x6d"]);
        goto YBVhp;
        J_Ss2:
        $image = $this->giftImageService->selectById($order["\x67\151\146\164\137\151\x64"]);
        goto FlgYO;
        Emgc0:
        $order["\x70\x61\x79\x5f\163\x74\x61\164\x75\x73"] = NGSOrderService::ORDER_PAY_STATUS_PAID;
        goto ejJqn;
        ejJqn:
        x1z4x:
        goto vYsSf;
        CZuLc:
        DDUP1:
        goto zX4yn;
        tvnP_:
        $credits = $this->flashUserService->fetchUserCredit($order["\x6f\x70\x65\x6e\151\144"]);
        goto YmxdP;
        V2zGs:
    }
    private function isNormalOrder($userId)
    {
        return true;
    }
    public function sendTrans($orderNum, $transNum, $company = '')
    {
        goto E31LV;
        etHkS:
        $receiveInfo = $address["\143\151\x74\x79"] . "\x20" . $address["\x61\162\x65\141"] . "\40" . $address["\141\x64\x64\162\145\163\x73"] . "\54\40" . $address["\156\x61\x6d\145"] . "\346\x94\xb6\xef\274\x8c\350\x81\x94\347\xb3\xbb\347\224\xb5\350\257\x9d\72\x20" . $address["\155\x6f\142\151\154\145"];
        goto xYhsT;
        SyPcm:
        x2OaW:
        goto xNOol;
        Eh828:
        throw new Exception("\350\257\245\350\xae\242\345\215\225\xe4\270\x8d\351\234\200\350\246\201\xe5\x8f\221\350\xb4\xa7", 4812);
        goto mruui;
        KpMAt:
        $image = $this->giftImageService->selectById($order["\x67\x69\x66\x74\x5f\151\144"]);
        goto pDrdK;
        E4hCo:
        $this->updateData($order);
        goto Mdglm;
        jx5Yx:
        $order["\x74\x72\141\156\163\137\156\165\155"] = $transNum;
        goto E4hCo;
        W2xk0:
        $order["\164\x72\141\156\163\137\143\157\x6d\160\141\156\x79"] = $company;
        goto fcD2p;
        pDrdK:
        if (!($order["\164\171\160\x65"] != NGSGiftService::GIFT_TYPE_SEND)) {
            goto eOLbs;
        }
        goto Eh828;
        MAKkc:
        Phz1g:
        goto SufsJ;
        xYhsT:
        $this->noticeService->sendGiftSendUpNotice($order["\157\160\145\x6e\x69\144"], $image["\164\x69\x74\x6c\x65"], $company, $transNum, $receiveInfo);
        goto gluZK;
        MQtHX:
        $order["\x74\x72\141\156\163\137\x6e\165\x6d"] = $transNum;
        goto W2xk0;
        fcD2p:
        $this->updateData($order);
        goto MAKkc;
        E31LV:
        $order = $this->getOrderDetailByOrderNum($orderNum);
        goto KpMAt;
        mruui:
        eOLbs:
        goto KtUFg;
        gluZK:
        $order["\x74\x72\141\156\x73\137\163\164\x61\x74\x75\163"] = NGSOrderService::ORDER_TRANS_STATUS_SEND;
        goto MQtHX;
        KtUFg:
        if ($order["\x74\162\141\156\163\137\x73\164\141\x74\165\x73"] == NGSOrderService::ORDER_TRANS_STATUS_DEFAULT) {
            goto x2OaW;
        }
        goto jx5Yx;
        xNOol:
        $address = $this->addressService->selectById($order["\141\144\x64\x72\145\x73\163\x5f\x69\144"]);
        goto etHkS;
        Mdglm:
        goto Phz1g;
        goto SyPcm;
        SufsJ:
    }
}
