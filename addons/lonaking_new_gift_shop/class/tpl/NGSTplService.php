<?php
/*
 __________________________________________________
|  Encode by BajieTeam on we7                      |
|__________________________________________________|
*/

goto Okc84;
Okc84:
/**
 * Created by PhpStorm.
 * User: leon
 * Date: 15/9/29
 * Time: 上午12:34
 */
require_once dirname(__FILE__) . "\57\56\56\57\56\56\x2f\x2e\x2e\57\154\x6f\156\x61\153\151\156\x67\x5f\x66\154\x61\x73\150\57\x46\154\x61\163\x68\x43\157\x6d\155\157\156\x53\145\x72\x76\x69\x63\x65\56\160\150\x70";
goto dIo3x;
dIo3x:
require_once dirname(__FILE__) . "\57\x2e\56\x2f\x2e\x2e\57\x2e\56\57\154\x6f\156\141\x6b\x69\156\x67\137\x66\154\x61\x73\150\x2f\x46\154\141\x73\x68\125\x73\x65\x72\123\145\162\166\151\x63\145\56\160\x68\x70";
goto Z_z6H;
Z_z6H:
class NGSTplService extends FlashCommonService
{
    const NOTICE_TYPE_TPL = 2;
    const NOTICE_TYPE_TEXT = 1;
    private $flashUserService;
    public function __construct()
    {
        goto lHVcG;
        qGJI0:
        $this->flashUserService = new FlashUserService();
        goto nhbf5;
        tzVwr:
        $this->table_name = "\154\x6f\x6e\x61\153\151\x6e\x67\137\x6e\145\167\137\147\x69\146\x74\137\x73\150\x6f\160\x5f\x6e\x6f\164\x69\143\x65\x5f\x63\x6f\x6e\146\x69\147";
        goto vhO0M;
        vhO0M:
        $this->columns = "\x69\144\54\x75\x6e\x69\x61\x63\x69\x64\54\x74\x79\x70\x65\x2c\147\x65\x74\137\156\157\164\x69\143\145\54\x63\150\x65\143\x6b\x5f\163\x74\x61\164\x75\x73\137\141\143\143\145\x73\x73\x5f\x6e\x6f\x74\x69\143\145\54\x63\x68\145\143\153\x5f\163\x74\x61\164\x75\x73\137\x72\x65\x66\165\163\145\137\x6e\x6f\164\151\x63\x65\x2c\x73\x65\x6e\x64\x5f\156\x6f\x74\151\x63\145\x2c\143\x72\145\x61\x74\x65\x5f\x74\151\x6d\x65\54\x75\160\x64\x61\x74\145\x5f\x74\x69\x6d\145";
        goto qGJI0;
        lHVcG:
        $this->plugin_name = "\x6c\x6f\x6e\141\x6b\151\156\147\137\x6e\145\x77\137\147\x69\x66\164\137\x73\150\157\160";
        goto tzVwr;
        nhbf5:
    }
    public function getTplConfigByUniacid($uniacid = null)
    {
        goto K_w7i;
        pLZA6:
        return $config;
        goto wyAIG;
        meFqd:
        if (!empty($config)) {
            goto b11mZ;
        }
        goto QkJAG;
        K_w7i:
        global $_W;
        goto UJ872;
        SUPxN:
        $config = $this->insertData($config);
        goto k3QXt;
        QkJAG:
        $config = array("\165\156\x69\x61\143\151\x64" => $_W["\x75\x6e\151\141\143\151\144"]);
        goto SUPxN;
        bdPo_:
        $config = $this->selectOne('');
        goto meFqd;
        UJ872:
        if (!is_null($uniacid)) {
            goto CNbZj;
        }
        goto UNikc;
        k3QXt:
        b11mZ:
        goto pLZA6;
        UNikc:
        $uniacid = $_W["\x75\156\x69\x61\143\x69\x64"];
        goto p21MT;
        p21MT:
        CNbZj:
        goto bdPo_;
        wyAIG:
    }
    /**
     * 礼品兑换成功的模板消息
     */
    public function sendGetGiftSuccessNotice($openid, $goodNameText, $priceText, $leftScoreText, $url = '')
    {
        goto Kz1Le;
        A7Vnd:
        $account = $this->createWexinAccount();
        goto pyN0G;
        briP_:
        PFFmq:
        goto WYijE;
        Ufs6d:
        if (!($config["\164\x79\160\145"] == NGSTplService::NOTICE_TYPE_TEXT)) {
            goto PFFmq;
        }
        goto H1x0i;
        H1x0i:
        $text = "\347\244\xbc\345\223\201\345\x85\221\346\x8d\242\346\x88\x90\xe5\212\237\351\x80\232\xe7\x9f\xa5\x3a\xa\xe6\x82\xa8\345\205\x91\346\x8d\xa2\347\x9a\x84\347\244\274\xe5\223\201\133{$goodNameText}\135\xe5\267\262\347\xbb\x8f\345\x85\221\346\215\xa2\346\x88\x90\345\x8a\237\x3b\xa\346\xb6\x88\xe8\x80\x97\x5b{$priceText}\135\x3b\12\xe5\205\x91\346\215\242\xe6\227\266\xe9\x97\xb4\72" . date("\x6d\346\x9c\210\144\346\x97\xa5\x20\110\x3a\151", time());
        goto WGMz4;
        WYijE:
        $template_id = $config["\147\x65\164\137\156\x6f\x74\151\143\x65"];
        goto cLkGk;
        J50Hk:
        $result = $account->sendTplNotice($openid, $template_id, $postData, $url);
        goto TLetp;
        pyN0G:
        $config = $this->getTplConfigByUniacid($_W["\165\x6e\x69\141\x63\151\144"]);
        goto Ufs6d;
        WGMz4:
        return $this->sendTextMessage($openid, $text);
        goto briP_;
        Kz1Le:
        global $_W;
        goto A7Vnd;
        cLkGk:
        $postData = array("\146\x69\162\163\164" => array("\166\x61\154\165\x65" => "\347\xa4\274\xe5\x93\201\345\x85\221\346\x8d\242\xe6\217\x90\xe4\xba\244\346\210\x90\345\212\x9f\357\xbc\x8c\344\xbf\xa1\xe6\x81\257\xe5\xa6\202\xe4\270\213", "\x63\x6f\x6c\x6f\162" => "\43\x39\x39\x39"), "\153\x65\171\167\157\162\144\61" => array("\166\x61\x6c\x75\x65" => $goodNameText, "\143\x6f\154\157\x72" => ''), "\153\145\171\x77\157\x72\144\x32" => array("\x76\141\154\x75\145" => $priceText, "\143\157\x6c\157\x72" => "\x23\106\x46\66\70\63\x46"), "\x6b\x65\x79\x77\157\162\144\63" => array("\166\x61\154\165\x65" => $leftScoreText, "\x63\x6f\154\x6f\x72" => ''), "\x6b\x65\171\x77\x6f\162\x64\x34" => array("\x76\141\x6c\x75\x65" => date("\155\xe6\234\210\144\346\x97\xa5\x20\110\72\x69", time()), "\143\157\154\x6f\x72" => ''), "\x72\145\155\x61\162\153" => array("\166\x61\x6c\x75\145" => "\xe7\244\274\xe5\223\201\345\205\x91\346\215\242\350\xaf\xb7\346\261\202\346\x88\220\345\x8a\237\54\347\256\241\xe7\220\206\345\x91\x98\xe5\xae\xa1\xe6\240\270\351\x80\232\350\277\x87\xe5\220\216\xe5\260\x86\344\270\xba\xe6\x82\250\xe5\217\221\xe6\224\xbe\xe7\xa4\xbc\xe5\223\x81", "\x63\157\x6c\157\162" => ''));
        goto N6v0s;
        N6v0s:
        $sendArray = array("\157\x70\x65\x6e\151\144" => $openid, "\x74\x65\x6d\x70\x6c\x61\164\x65\x5f\x69\x64" => $template_id, "\x70\x6f\163\164\x44\x61\164\141" => $postData, "\165\162\154" => $url);
        goto J50Hk;
        TLetp:
    }
    /**
     * 发送礼品兑换订单审核通过的模板消息
     */
    public function sendGiftOrderCheckStatusAccessNotice($openid, $giftNameText, $url = '')
    {
        goto sntv8;
        wkTlw:
        if (!$url) {
            goto fDlCI;
        }
        goto cRypp;
        C6m8G:
        fDlCI:
        goto vkcAN;
        cRypp:
        $text .= "\x3c\141\x20\x68\162\x65\146\75\42{$url}\42\76\350\xaf\xa6\xe6\x83\205\xe7\x82\271\345\207\273\xe8\277\231\351\207\x8c\xe6\x9f\245\xe7\x9c\x8b\x3c\57\141\x3e";
        goto C6m8G;
        yVXUg:
        if (!($config["\164\171\x70\x65"] == NGSTplService::NOTICE_TYPE_TEXT)) {
            goto dG4jC;
        }
        goto Kwy1c;
        Kwy1c:
        $text = "\xe8\xae\242\xe5\215\x95\xe5\256\241\346\xa0\270\351\200\x9a\xe8\xbf\207\x3a\12\346\202\250\xe5\x85\x91\346\x8d\242\xe7\x9a\x84\347\244\274\xe5\x93\201\x5b{$giftNameText}\135\345\267\xb2\347\xbb\x8f\345\256\xa1\xe6\xa0\xb8\351\200\x9a\350\277\207\x3b\12\345\256\xa1\346\240\270\346\227\xb6\xe9\x97\264\72" . date("\155\xe6\x9c\210\144\346\227\245\40\x48\72\x69", time()) . "\x3b\xa";
        goto wkTlw;
        OpN3k:
        $account = $this->createWexinAccount();
        goto kc7NA;
        kc7NA:
        $config = $this->getTplConfigByUniacid($_W["\x75\x6e\x69\x61\x63\151\144"]);
        goto yVXUg;
        Il3E7:
        $sendArray = array("\157\160\x65\x6e\151\x64" => $openid, "\164\145\155\x70\x6c\141\164\x65\137\151\144" => $template_id, "\160\157\163\x74\x44\x61\x74\x61" => $postData, "\x75\162\x6c" => $url);
        goto AiIks;
        sGmZn:
        dG4jC:
        goto Uzv7H;
        sntv8:
        global $_W;
        goto OpN3k;
        LrHVf:
        $postData = array("\146\x69\x72\163\x74" => array("\x76\141\x6c\x75\x65" => "\xe6\x82\xa8\345\205\221\xe6\215\xa2\347\x9a\x84\xe7\244\274\345\x93\201\133" . $giftNameText . "\x5d\xe5\256\241\346\240\270\xe9\200\x9a\xe8\xbf\x87\344\xba\206", "\143\x6f\154\x6f\x72" => "\x23\71\x39\71"), "\153\x65\171\x77\157\x72\144\61" => array("\166\x61\x6c\165\145" => "\351\x80\x9a\xe8\xbf\x87", "\143\x6f\x6c\x6f\162" => ''), "\x6b\x65\x79\167\157\162\x64\62" => array("\x76\x61\x6c\x75\x65" => date("\x6d\xe6\234\210\x64\346\227\245\x20\110\72\x69", time()), "\143\x6f\x6c\x6f\162" => ''));
        goto Il3E7;
        vkcAN:
        return $this->sendTextMessage($openid, $text);
        goto sGmZn;
        AiIks:
        $result = $account->sendTplNotice($openid, $template_id, $postData, $url);
        goto zdNzZ;
        Uzv7H:
        $template_id = $config["\143\x68\145\x63\153\x5f\163\164\141\x74\165\163\137\x61\x63\x63\x65\x73\x73\x5f\x6e\x6f\x74\x69\143\145"];
        goto LrHVf;
        zdNzZ:
    }
    /**
     * 拒绝一个兑换记录
     */
    public function sendGiftOrderCheckStatusRefuseNotice($openid, $giftNameText, $reasonText, $url = '')
    {
        goto kdrst;
        XzdI2:
        $postData = array("\146\x69\x72\163\x74" => array("\166\141\154\x75\145" => "\346\202\250\xe5\205\x91\346\x8d\242\xe7\x9a\204\xe7\xa4\xbc\xe5\x93\201\x5b" . $giftNameText . "\x5d\345\xae\xa1\346\240\270\xe6\262\241\xe6\234\211\xe9\200\x9a\350\277\x87", "\x63\x6f\x6c\157\x72" => "\43\x39\71\x39"), "\153\x65\171\167\157\x72\144\61" => array("\x76\141\154\165\145" => "\346\234\xaa\xe9\x80\x9a\350\277\x87", "\143\157\154\157\x72" => "\x23\106\x46\66\70\x33\106"), "\153\x65\x79\x77\157\162\x64\62" => array("\166\x61\x6c\x75\145" => date("\x6d\xe6\x9c\210\144\346\x97\xa5\40\x48\x3a\x69", time()), "\x63\x6f\x6c\157\162" => ''), "\162\145\x6d\x61\x72\x6b" => array("\x76\x61\154\165\x65" => "\346\x82\xa8\347\x9a\x84\xe5\205\x91\xe6\x8d\242\xe7\x94\261\344\272\x8e\x5b" . $reasonText . "\135\346\xb2\xa1\346\x9c\x89\xe9\200\232\xe8\xbf\207\xe5\xae\xa1\346\xa0\270\357\xbc\214\346\x88\x91\344\273\xac\xe5\xb7\262\xe5\260\206\347\244\274\xe5\223\x81\347\247\257\xe5\210\x86\xe9\200\200\xe5\233\x9e\346\202\xa8\xe7\232\x84\xe8\xb4\xa6\346\210\xb7\xef\xbc\214\344\xb8\272\xe6\202\250\345\270\246\346\x9d\245\xe7\x9a\x84\xe4\270\x8d\344\xbe\277\xe9\235\x9e\xe5\270\270\346\212\261\346\255\211\xef\xbc\x8c\346\204\x9f\350\260\242\346\202\250\345\257\xb9\346\210\x91\344\273\xac\xe7\x9a\204\xe6\x94\257\346\x8c\201", "\x63\157\154\x6f\162" => ''));
        goto Ra49V;
        E6Bgc:
        $account = $this->createWexinAccount();
        goto Rrva7;
        Ra49V:
        $sendArray = array("\x6f\160\145\x6e\151\x64" => $openid, "\x74\x65\x6d\160\154\141\x74\145\x5f\151\144" => $template_id, "\160\157\163\x74\104\x61\164\141" => $postData, "\165\x72\154" => $url);
        goto qJlyE;
        xgTS4:
        if (!($config["\164\x79\160\x65"] == NGSTplService::NOTICE_TYPE_TEXT)) {
            goto CbG7f;
        }
        goto AKWhP;
        AMPsg:
        bCYoY:
        goto Af_qV;
        GlQdm:
        CbG7f:
        goto v4Fgr;
        AKWhP:
        $text = "\350\256\242\xe5\215\x95\350\242\253\346\213\222\xe7\273\235\72\xa\346\x82\250\xe5\x85\221\xe6\215\xa2\xe7\x9a\x84\xe7\244\274\xe5\223\201\x5b{$giftNameText}\x5d\xe5\xb7\262\347\xbb\x8f\350\xa2\xab\346\x8b\x92\347\xbb\235\73\12\xe6\213\x92\347\273\x9d\xe5\216\237\345\233\xa0\xef\xbc\x9a{$reasonText}\12\xe5\xae\xa1\346\240\xb8\xe6\x97\xb6\351\227\264\x3a" . date("\155\346\234\x88\x64\xe6\x97\xa5\40\110\x3a\151", time()) . "\73\12";
        goto mcP3n;
        Rrva7:
        $config = $this->getTplConfigByUniacid($_W["\165\156\151\141\143\x69\144"]);
        goto xgTS4;
        mcP3n:
        if (!$url) {
            goto bCYoY;
        }
        goto eUcTl;
        eUcTl:
        $text .= "\x3c\x61\40\x68\162\x65\x66\75\42{$url}\42\76\350\xaf\xa6\xe6\x83\x85\347\x82\xb9\345\x87\xbb\xe8\277\x99\351\207\x8c\xe6\237\245\347\234\x8b\74\x2f\x61\76";
        goto AMPsg;
        qJlyE:
        $result = $account->sendTplNotice($openid, $template_id, $postData, $url);
        goto tdg_8;
        v4Fgr:
        $template_id = $config["\143\150\x65\x63\x6b\x5f\x73\x74\141\x74\x75\163\137\x61\143\143\145\x73\163\137\156\x6f\164\151\x63\x65"];
        goto XzdI2;
        kdrst:
        global $_W;
        goto E6Bgc;
        Af_qV:
        return $this->sendTextMessage($openid, $text);
        goto GlQdm;
        tdg_8:
    }
    /**
     * 发货通知
     */
    public function sendGiftSendUpNotice($openid, $giftNameText, $transCompanyText, $transNumText, $receiveInfoText, $url = '')
    {
        goto H8UET;
        u5usB:
        $config = $this->getTplConfigByUniacid($_W["\165\x6e\151\141\x63\x69\144"]);
        goto M2JqS;
        WTVeH:
        $sendArray = array("\157\x70\145\x6e\151\144" => $openid, "\164\145\x6d\x70\154\141\x74\x65\x5f\x69\144" => $template_id, "\160\x6f\163\164\x44\x61\x74\141" => $postData, "\x75\x72\x6c" => $url);
        goto Q65a0;
        MOAWS:
        $text .= "\74\x61\x20\150\x72\145\x66\x3d\x22{$url}\42\76\350\257\246\346\x83\205\xe7\x82\271\345\x87\xbb\350\xbf\x99\351\x87\x8c\346\x9f\245\347\x9c\213\74\57\141\76";
        goto BJlET;
        l1V_6:
        $postData = array("\146\151\x72\x73\164" => array("\166\x61\x6c\x75\145" => "\xe6\x82\xa8\345\205\x91\346\x8d\xa2\347\232\204\347\244\xbc\xe5\223\x81\133" . $giftNameText . "\x5d\xe5\267\262\347\xbb\x8f\xe5\217\x91\350\264\xa7\xef\274\214\xe8\xaf\267\xe5\205\xb3\xe6\xb3\250\xe7\211\xa9\xe6\265\201\xe4\xbf\241\346\x81\xaf", "\143\157\154\157\x72" => "\x23\71\x39\x39"), "\x6b\x65\171\167\x6f\x72\x64\61" => array("\166\141\154\165\145" => $giftNameText, "\x63\x6f\x6c\157\162" => "\43\106\x46\66\x38\x33\x46"), "\153\145\x79\167\157\x72\x64\x32" => array("\x76\x61\154\165\145" => $transCompanyText, "\143\157\x6c\x6f\162" => ''), "\153\145\x79\x77\x6f\x72\144\x33" => array("\x76\x61\x6c\x75\145" => $transNumText, "\143\157\x6c\157\x72" => "\x23\x46\x46\66\x38\x33\106"), "\153\x65\171\167\157\x72\x64\x34" => array("\x76\x61\154\x75\145" => $receiveInfoText, "\143\x6f\154\x6f\x72" => ''), "\x72\x65\155\x61\x72\153" => array("\x76\141\154\x75\145" => "\346\x82\250\347\x9a\204\xe7\244\xbc\xe5\x93\x81\xe5\267\xb2\xe7\xbb\217\xe7\x94\261\345\xbf\253\351\x80\222\xe5\x8f\x91\345\x87\272\xef\274\214\346\x82\xa8\345\x8f\257\xe4\273\xa5\345\234\250\xe7\231\276\xe5\272\xa6\346\237\xa5\xe8\xaf\242\xe8\xbf\x90\xe5\215\225\xe5\217\267\xe5\x85\263\346\xb3\xa8\347\x89\xa9\346\xb5\x81\345\x8a\250\346\200\x81", "\143\157\x6c\x6f\162" => ''));
        goto WTVeH;
        BJlET:
        return $this->sendTextMessage($openid, $text);
        goto ueDA5;
        H8UET:
        global $_W;
        goto P9vpN;
        P9vpN:
        $account = $this->createWexinAccount();
        goto u5usB;
        M2JqS:
        if (!($config["\x74\171\x70\x65"] == NGSTplService::NOTICE_TYPE_TEXT)) {
            goto lXLnp;
        }
        goto O5Io5;
        O5Io5:
        $text = "\xe5\x8f\221\xe8\264\247\xe9\x80\x9a\xe7\x9f\xa5\x3a\xe6\202\xa8\xe5\205\x91\346\215\xa2\347\x9a\x84\347\xa4\274\xe5\x93\201\133{$giftNameText}\135\345\267\xb2\xe7\273\x8f\xe5\x8f\221\xe8\xb4\247\x3b\xa\xe5\277\xab\351\200\222\xe5\205\254\345\x8f\270\72{$transCompanyText}\x3b\xa\350\xbf\x90\345\x8d\x95\xe5\217\267\347\xa0\x81\72{$transNumText}";
        goto MOAWS;
        Q65a0:
        $result = $account->sendTplNotice($openid, $template_id, $postData, $url);
        goto pQzYb;
        ueDA5:
        lXLnp:
        goto w68Cr;
        w68Cr:
        $template_id = $config["\163\145\x6e\x64\137\x6e\x6f\x74\x69\x63\145"];
        goto l1V_6;
        pQzYb:
    }
}
