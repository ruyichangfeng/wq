<?php
/*
 __________________________________________________
|  Encode by BajieTeam on we7                      |
|__________________________________________________|
*/

goto e5Hri;
TeqDS:
require_once dirname(__FILE__) . "\x2f\143\154\x61\163\x73\x2f\x46\x6c\141\163\x68\x48\142\x52\x65\x63\x6f\x72\x64\123\145\x72\x76\x69\143\x65\56\x70\150\160";
goto lf8X1;
e5Hri:
/**
 * @author lonaking_flash
 * @url http://bbs.we7.cc/
 */
defined("\x49\x4e\137\x49\x41") or die("\101\143\x63\x65\x73\163\40\x44\145\x6e\x69\145\144");
goto TeqDS;
lf8X1:
class Lonaking_flashModuleSite extends WeModuleSite
{
    public function doWebDashboard()
    {
        goto f8E3g;
        d_KhZ:
        goto u7lja;
        goto QcmWU;
        obMvG:
        $html["\144\x65\x62\x75\147"] = true;
        goto GE1RR;
        f8E3g:
        global $_W, $_GPC;
        goto EVuDF;
        LmSsx:
        include $this->template("\144\141\x73\x68\142\x6f\141\162\x64");
        goto b9avY;
        yZoN8:
        if ($mode) {
            goto XSKdM;
        }
        goto gwoUp;
        weaZT:
        $mode = strstr($configContent, $search);
        goto bQ1Oj;
        bQ1Oj:
        $html = array("\144\145\142\165\147" => false);
        goto yZoN8;
        sFfhL:
        $search = "\x24\x63\x6f\156\146\151\x67\x5b\x27\x73\145\x74\164\x69\x6e\x67\x27\x5d\133\47\x64\145\166\145\x6c\157\x70\155\x65\156\x74\47\135\40\75\x20\61\73";
        goto weaZT;
        EVuDF:
        $configContent = file_get_contents(IA_ROOT . "\57\x64\x61\164\141\57\x63\157\x6e\146\x69\x67\56\x70\150\x70");
        goto sFfhL;
        QcmWU:
        XSKdM:
        goto obMvG;
        gwoUp:
        $html["\144\145\x62\165\147"] = false;
        goto d_KhZ;
        GE1RR:
        u7lja:
        goto LmSsx;
        b9avY:
    }
    public function doWebDebug()
    {
        goto CCLDz;
        dBVO_:
        $replace = '';
        goto eSsaw;
        FM0Lz:
        goto qBm0o;
        goto ualbE;
        YeELS:
        $newConfigContent = str_replace($search, $replace, $configContent);
        goto NmyRI;
        I_3au:
        cwq3p:
        goto bdwhl;
        IVn7k:
        if ($do == 0) {
            goto cwq3p;
        }
        goto FM0Lz;
        Yn5BM:
        if (!$mode) {
            goto NNrk7;
        }
        goto YeELS;
        dCjfD:
        $replace = "\x24\x63\157\156\146\151\147\133\47\x73\x65\x74\x74\x69\x6e\147\x27\x5d\133\x27\x64\145\166\x65\154\157\160\155\x65\156\164\x27\135\x20\75\40\x30\73";
        goto XJXD_;
        Wr2Ft:
        $mode = strstr($configContent, $search);
        goto Yn5BM;
        XJXD_:
        qBm0o:
        goto Wr2Ft;
        xmtzA:
        $configContent = file_get_contents(IA_ROOT . "\x2f\144\141\164\x61\x2f\x63\157\156\146\x69\x67\56\160\x68\x70");
        goto mNRA0;
        mNRA0:
        $search = '';
        goto dBVO_;
        bGjYV:
        goto qBm0o;
        goto I_3au;
        bdwhl:
        $search = "\x24\x63\x6f\156\x66\151\147\x5b\47\x73\145\x74\x74\x69\156\147\47\x5d\x5b\47\144\x65\166\x65\x6c\x6f\160\x6d\x65\x6e\x74\x27\135\x20\75\40\61\73";
        goto dCjfD;
        eSsaw:
        if ($do == 1) {
            goto xhSxG;
        }
        goto IVn7k;
        AiqeR:
        die(json_encode(array("\x73\164\141\x74\x75\163" => 200, "\155\x65\x73\163\x61\x67\x65" => '', "\x64\141\164\141" => null)));
        goto fFyRn;
        dVnwl:
        $do = $_GPC["\144\x65\142\x75\147"];
        goto xmtzA;
        ocrQQ:
        NNrk7:
        goto AiqeR;
        CCLDz:
        global $_W, $_GPC;
        goto dVnwl;
        NmyRI:
        file_put_contents(IA_ROOT . "\x2f\x64\x61\164\x61\x2f\143\x6f\x6e\x66\151\x67\56\x70\150\x70\56\142\x61\143\x6b\56" . date("\131\155\144\110\x69\x73"), $configContent);
        goto phnzM;
        ualbE:
        xhSxG:
        goto DXhC6;
        phnzM:
        file_put_contents(IA_ROOT . "\57\x64\141\x74\x61\57\143\157\x6e\146\x69\147\x2e\160\x68\160", $newConfigContent);
        goto ocrQQ;
        zQuzW:
        $replace = "\x24\143\x6f\156\146\x69\147\133\x27\x73\145\164\164\151\x6e\x67\47\x5d\133\x27\144\145\166\x65\x6c\x6f\x70\x6d\x65\156\x74\x27\x5d\40\75\40\x31\x3b";
        goto bGjYV;
        DXhC6:
        $search = "\44\143\157\x6e\x66\151\x67\133\x27\x73\145\164\164\151\x6e\x67\47\x5d\133\x27\144\x65\166\145\154\157\x70\155\145\x6e\164\x27\x5d\x20\75\40\60\73";
        goto zQuzW;
        fFyRn:
    }
    public function doWebHbRecordManage()
    {
        goto j64dD;
        j64dD:
        global $_GPC, $_W;
        goto F46Uc;
        IVN_R:
        $page = $hbRecordService->selectPageOrderBy($where, "\x20\x63\162\145\x61\x74\145\137\x74\151\155\x65\x20\x64\145\163\143\x2c");
        goto yTK_n;
        I16gW:
        $where .= "\40\141\156\144\x20\x74\x6f\137\157\x70\145\156\151\x64\x3d\x27{$_GPC["\x6f\x70\x65\x6e\151\x64"]}\x27";
        goto Ofv2L;
        RDDZU:
        $where = '';
        goto xEPxT;
        yTK_n:
        include $this->template("\150\x62\55\162\x65\x63\x6f\162\144\x2d\x6d\141\x6e\x61\x67\145");
        goto mZxuj;
        F46Uc:
        $hbRecordService = new FlashHbRecordService();
        goto RDDZU;
        Ofv2L:
        IGDXT:
        goto IVN_R;
        xEPxT:
        if (!$_GPC["\157\x70\x65\156\x69\144"]) {
            goto IGDXT;
        }
        goto I16gW;
        mZxuj:
    }
    public function doMobileForceUpdate()
    {
        global $_GPC, $_W;
    }
}
