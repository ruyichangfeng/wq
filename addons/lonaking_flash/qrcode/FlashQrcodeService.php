<?php
/*
 __________________________________________________
|  Encode by BajieTeam on we7                      |
|__________________________________________________|
*/

require_once dirname(__FILE__) . "\x2f\56\x2e\57\106\154\141\163\150\x43\157\x6d\155\x6f\x6e\x53\145\162\x76\151\143\145\56\160\x68\x70";
class FlashQrcodeService extends FlashCommonService
{
    const TMP_QRCODE = 1;
    const FOREVER_QRCODE = 2;
    public function __construct()
    {
        goto jOACM;
        x4V90:
        $this->columns = "\x69\x64\54\x75\x6e\x69\x61\x63\151\x64\x2c\141\143\x69\144\x2c\161\162\x63\151\x64\54\156\x61\x6d\x65\54\153\x65\x79\x77\x6f\162\x64\54\x6d\157\144\x65\x6c\x2c\x74\x69\x63\153\x65\164\x2c\x65\170\160\151\162\x65\54\x73\x75\x62\x6e\x75\x6d\54\x63\x72\x65\141\164\x65\164\151\x6d\x65\x2c\x73\164\x61\164\x75\x73\x2c\x74\x79\160\x65\54\145\x78\164\x72\141\x2c\x75\x72\154\x2c\163\143\x65\x6e\x65\137\x73\164\x72";
        goto LTSMJ;
        jOACM:
        $this->table_name = "\x71\162\143\157\144\x65";
        goto x4V90;
        LTSMJ:
        $this->plugin_name = "\x6c\157\156\141\x6b\x69\156\147\137\x66\x6c\141\163\x68";
        goto HX7E8;
        HX7E8:
    }
    public function createTempQrcode($name, $keyword, $expireSeconds = 2592000)
    {
        goto ElODI;
        MgLdg:
        if (is_error($qrcode)) {
            goto u8kJ9;
        }
        goto etRK2;
        U6JH7:
        throw new Exception("\346\212\261\346\255\x89\357\274\214\xe7\224\x9f\346\210\220\xe4\272\214\xe7\xbb\264\xe7\xa0\x81\xe5\244\xb1\xe8\264\245\357\xbc\214\346\x82\250\xe7\x9a\x84\345\x85\254\xe4\274\227\345\x8f\xb7\xe5\x8f\257\xe8\203\275\xe4\xb8\x8d\346\224\257\346\x8c\x81\345\217\x82\346\225\xb0\xe4\272\214\347\273\xb4\xe7\xa0\201", 9001);
        goto cJ46u;
        KpNLS:
        $qrcid = pdo_fetchcolumn("\123\x45\114\105\103\124\x20\161\x72\143\151\144\x20\x46\x52\x4f\115\40" . tablename("\x71\162\143\157\x64\145") . "\40\127\x48\x45\x52\105\40\141\143\x69\144\40\x3d\40\72\141\143\151\144\40\101\116\104\x20\165\156\x69\x61\143\151\144\75\72\x75\x6e\x69\141\143\x69\144\x20\101\x4e\x44\x20\155\x6f\144\145\x6c\x20\x3d\40\47\x32\47\40\x4f\x52\104\105\122\x20\x42\x59\40\161\162\143\151\144\40\x44\105\x53\103\40\114\111\x4d\x49\124\40\x31", array("\72\x61\143\151\144" => $acid, "\72\165\x6e\x69\x61\143\x69\144" => $uniacid));
        goto J5VGq;
        D9U75:
        $account = $this->createWexinAccount();
        goto nc79I;
        J5VGq:
        $barcode = array("\145\170\160\x69\162\145\137\x73\x65\143\157\156\x64\x73" => $expireSeconds, "\x61\143\x74\151\157\x6e\x5f\x6e\x61\155\x65" => "\121\x52\137\x53\x43\x45\x4e\x45", "\x61\x63\x74\151\157\156\x5f\151\x6e\146\157" => array("\163\x63\145\x6e\x65" => array("\x73\143\x65\x6e\145\x5f\151\144" => !empty($qrcid) ? $qrcid + 1 : 100001)));
        goto D9U75;
        awSCX:
        $uniacid = intval($_W["\x75\x6e\x69\x61\143\x69\144"]);
        goto KpNLS;
        nc79I:
        $qrcode = $account->barCodeCreateDisposable($barcode);
        goto MgLdg;
        qtItu:
        return $this->insertData($insert);
        goto MHRR3;
        H2rY6:
        $acid = intval($_W["\x61\x63\151\x64"]);
        goto awSCX;
        etRK2:
        $insert = array("\x75\x6e\151\141\x63\151\x64" => $_W["\165\156\151\141\143\151\x64"], "\141\x63\151\144" => $acid, "\161\162\143\x69\x64" => $barcode["\x61\x63\164\151\157\156\137\x69\156\x66\157"]["\163\x63\145\156\x65"]["\x73\x63\x65\156\145\x5f\151\x64"], "\163\143\145\x6e\145\137\163\164\162" => '', "\153\x65\171\167\x6f\162\x64" => $keyword, "\156\x61\x6d\145" => $name, "\155\157\x64\145\x6c" => self::TMP_QRCODE, "\164\x69\x63\x6b\x65\x74" => $qrcode["\164\151\143\153\145\164"], "\165\162\154" => $qrcode["\165\162\154"], "\x65\170\x70\x69\162\x65" => $expireSeconds, "\x63\x72\145\141\x74\145\164\x69\x6d\145" => time(), "\163\164\141\164\165\x73" => "\x31", "\164\x79\x70\x65" => "\163\143\145\x6e\x65");
        goto qtItu;
        MHRR3:
        goto VP37g;
        goto Nrn1w;
        Nrn1w:
        u8kJ9:
        goto U6JH7;
        cJ46u:
        VP37g:
        goto g4UPy;
        ElODI:
        global $_W;
        goto H2rY6;
        g4UPy:
    }
    public function createForeverQrcode($name, $keyword)
    {
        goto SeKX_;
        TXUUS:
        $insert = array("\x75\156\x69\141\x63\x69\x64" => $_W["\165\x6e\151\141\x63\x69\x64"], "\x61\x63\151\144" => $acid, "\161\x72\143\151\144" => $barcode["\141\143\164\151\157\156\x5f\x69\x6e\146\157"]["\x73\x63\145\156\x65"]["\x73\143\145\x6e\145\137\151\144"], "\x73\143\x65\x6e\x65\x5f\163\164\x72" => '', "\x6b\x65\171\167\x6f\x72\144" => $keyword, "\156\x61\155\145" => $name, "\155\x6f\x64\145\154" => self::FOREVER_QRCODE, "\164\151\x63\x6b\145\164" => $qrcode["\164\x69\143\153\145\164"], "\x75\x72\154" => $qrcode["\165\x72\154"], "\145\x78\160\x69\x72\145" => 0, "\143\x72\x65\141\x74\145\164\x69\155\145" => time(), "\x73\x74\x61\164\165\163" => "\x31", "\164\171\160\145" => "\163\x63\145\x6e\145");
        goto xCgP4;
        IYc47:
        $qrcode = $account->barCodeCreateFixed($barcode);
        goto MWnyR;
        rOGJ6:
        AHgmK:
        goto c63qC;
        EGsyS:
        goto AHgmK;
        goto JQi4w;
        xCgP4:
        return $this->insertData($insert);
        goto EGsyS;
        hLOKu:
        $qrcid = pdo_fetchcolumn("\123\x45\114\x45\x43\x54\x20\161\162\x63\151\144\x20\106\x52\x4f\115\40" . tablename("\x71\162\143\157\x64\145") . "\x20\x57\110\105\122\105\x20\x61\143\x69\x64\40\75\40\72\x61\x63\151\144\40\101\x4e\x44\x20\x75\156\x69\x61\143\x69\144\x3d\x3a\165\156\x69\x61\143\151\x64\x20\101\x4e\x44\x20\155\157\x64\145\154\40\x3d\40\47\62\x27\x20\117\x52\104\x45\122\x20\102\x59\40\x71\x72\143\151\144\40\104\105\123\x43\40\114\x49\115\111\124\40\61", array("\x3a\141\143\x69\144" => $acid, "\72\x75\x6e\x69\141\x63\x69\x64" => $uniacid));
        goto jwuzr;
        jwuzr:
        $barcode = array("\x61\143\164\151\157\x6e\137\x6e\x61\155\145" => "\x51\x52\x5f\114\x49\115\x49\x54\x5f\123\x43\x45\x4e\105", "\141\x63\x74\151\x6f\156\137\x69\x6e\x66\x6f" => array("\163\x63\x65\x6e\x65" => array("\x73\x63\x65\156\145\137\x69\x64" => !empty($qrcid) ? $qrcid + 1 : 100001)));
        goto WUTZQ;
        JQi4w:
        fzApd:
        goto vc5QB;
        MWnyR:
        if (is_error($qrcode)) {
            goto fzApd;
        }
        goto TXUUS;
        WUTZQ:
        $account = $this->createWexinAccount();
        goto IYc47;
        SeKX_:
        global $_W;
        goto J6MG8;
        J6MG8:
        $acid = intval($_W["\x61\x63\151\x64"]);
        goto TzglK;
        vc5QB:
        throw new Exception("\xe6\212\xb1\346\255\x89\xef\xbc\x8c\xe7\224\x9f\xe6\210\x90\344\272\214\347\273\264\347\240\x81\345\xa4\xb1\xe8\264\xa5\357\xbc\x8c\346\202\xa8\xe7\x9a\x84\xe5\205\xac\344\xbc\227\345\x8f\267\xe5\x8f\257\350\203\275\xe4\xb8\215\xe6\224\257\346\214\x81\345\x8f\202\xe6\x95\xb0\344\xba\x8c\xe7\xbb\264\347\xa0\201", 9001);
        goto rOGJ6;
        TzglK:
        $uniacid = intval($_W["\x75\x6e\151\141\143\151\144"]);
        goto hLOKu;
        c63qC:
    }
    public function createForeverStrSceneQrcode($name, $keyword, $sceneStr)
    {
        goto EYL5C;
        fij5X:
        throw new Exception("\xe6\x8a\xb1\346\xad\211\xef\xbc\214\347\224\237\xe6\x88\220\344\272\x8c\347\273\264\xe7\xa0\201\345\xa4\xb1\350\264\245\xef\xbc\214\xe6\202\xa8\xe7\x9a\204\xe5\x85\254\344\274\227\xe5\x8f\267\345\217\xaf\xe8\x83\275\344\270\x8d\346\x94\xaf\346\x8c\201\345\x8f\202\346\225\xb0\xe4\272\x8c\xe7\273\xb4\347\240\201", 9001);
        goto NyEiI;
        FM5jQ:
        Stald:
        goto fij5X;
        gWfN7:
        $acid = intval($_W["\141\143\151\x64"]);
        goto ajwbp;
        ajwbp:
        $uniacid = intval($_W["\x75\156\151\141\x63\151\x64"]);
        goto aVLp3;
        h2ACF:
        $account = $this->createWexinAccount();
        goto UQdZN;
        UQdZN:
        $qrcode = $account->barCodeCreateFixed($barcode);
        goto gMCKm;
        nc24t:
        return $this->insertData($insert);
        goto Hz30G;
        gMCKm:
        if (is_error($qrcode)) {
            goto Stald;
        }
        goto kGYsf;
        NyEiI:
        H3sT2:
        goto fGNoA;
        aVLp3:
        $barcode = array("\141\x63\164\151\x6f\156\x5f\156\x61\x6d\145" => "\x51\x52\137\x4c\x49\115\111\x54\137\x53\124\122\137\123\x43\105\116\105", "\x61\x63\x74\x69\x6f\x6e\137\151\156\146\x6f" => array("\x73\x63\145\x6e\145" => array("\x73\143\145\x6e\145\x5f\x73\164\162" => $sceneStr)));
        goto h2ACF;
        kGYsf:
        $insert = array("\165\156\151\x61\143\151\144" => $uniacid, "\x61\143\x69\x64" => $acid, "\x71\x72\x63\151\x64" => "\x30", "\x73\143\x65\x6e\145\x5f\x73\x74\x72" => $sceneStr, "\x6b\145\x79\x77\157\x72\x64" => $keyword, "\x6e\141\155\145" => $name, "\x6d\x6f\x64\x65\154" => self::FOREVER_QRCODE, "\164\x69\x63\153\145\164" => $qrcode["\164\x69\x63\x6b\145\164"], "\x75\x72\x6c" => $qrcode["\x75\162\154"], "\145\170\160\x69\x72\145" => 0, "\143\162\x65\141\x74\145\164\151\x6d\145" => time(), "\163\x74\141\164\165\163" => "\x31", "\164\x79\x70\145" => "\163\x63\145\156\x65");
        goto nc24t;
        Hz30G:
        goto H3sT2;
        goto FM5jQ;
        EYL5C:
        global $_W;
        goto gWfN7;
        fGNoA:
    }
}
