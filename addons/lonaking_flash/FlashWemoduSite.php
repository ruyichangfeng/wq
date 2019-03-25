<?php
/*
 __________________________________________________
|  Encode by BajieTeam on we7                      |
|__________________________________________________|
*/

/**
 * Created by PhpStorm.
 * User: leon
 * Date: 16/1/23
 * Time: 下午7:06
 */
class FlashWemoduSite extends WeModuleSite
{
    protected function pay($params = array())
    {
        goto yfPes;
        QVG9R:
        $setting = uni_setting($_W["\165\156\x69\x61\143\x69\144"], array("\x70\x61\x79\x6d\145\156\x74", "\143\162\145\144\151\x74\x62\145\150\x61\x76\151\x6f\162\x73"));
        goto Y9uqw;
        nIhyu:
        die($site->{$method}($pars));
        goto mhln_;
        lB5bC:
        $pars["\x72\145\163\165\x6c\x74"] = "\163\x75\143\143\145\x73\163";
        goto ZaaKU;
        O92Ao:
        ffRiy:
        goto CWLRd;
        ZaaKU:
        $pars["\x74\x79\160\145"] = "\141\154\x69\160\x61\171";
        goto Uy9Bd;
        CWLRd:
        $params["\155\x6f\144\165\154\x65"] = $this->module["\x6e\141\x6d\x65"];
        goto ULJLl;
        pJRUY:
        message("\xe6\262\241\xe6\234\x89\xe6\x9c\211\xe6\225\x88\347\x9a\x84\346\x94\257\xe4\xbb\230\xe6\x96\271\xe5\xbc\x8f\x2c\40\350\257\xb7\350\x81\224\xe7\xb3\xbb\347\275\221\347\xab\x99\347\256\xa1\347\x90\206\345\x91\x98\x2e");
        goto hgnKR;
        ULJLl:
        $pars = array();
        goto FbFrL;
        L_H10:
        $pars["\x66\162\157\x6d"] = "\162\145\164\x75\162\x6e";
        goto lB5bC;
        w53FV:
        $credtis = mc_credit_fetch($_W["\x6d\x65\x6d\142\145\x72"]["\x75\x69\x64"]);
        goto RVJm1;
        Uy9Bd:
        $pars["\164\151\x64"] = $params["\x74\151\x64"];
        goto j7kb_;
        x4cl2:
        $pars["\72\155\x6f\144\165\x6c\x65"] = $params["\155\157\x64\x75\154\x65"];
        goto QVfDG;
        YxCvn:
        nyHNT:
        goto QVG9R;
        QiyyR:
        XgWpu:
        goto eJYQU;
        sPiOu:
        if (!($params["\146\x65\x65"] <= 0)) {
            goto XgWpu;
        }
        goto L_H10;
        HAhDV:
        checkauth();
        goto O92Ao;
        Y9uqw:
        if (is_array($setting["\x70\x61\x79\x6d\145\156\164"])) {
            goto OJsG8;
        }
        goto pJRUY;
        w6nyv:
        $method = "\160\141\171\x52\145\163\x75\154\164";
        goto GDdO5;
        BPoYT:
        message("\xe8\xbf\x99\344\270\252\350\xae\xa2\345\x8d\x95\xe5\267\xb2\347\xbb\x8f\xe6\224\xaf\xe4\xbb\x98\xe6\x88\x90\xe5\x8a\x9f\54\x20\344\xb8\x8d\351\234\200\xe8\246\201\351\207\215\345\xa4\215\346\x94\xaf\xe4\xbb\x98\x2e");
        goto YxCvn;
        SDglf:
        message("\xe6\224\xaf\344\xbb\x98\345\212\237\xe8\x83\275\345\217\xaa\350\203\275\xe5\x9c\250\346\211\213\xe6\234\272\344\xb8\x8a\344\xbd\xbf\xe7\x94\250");
        goto G467N;
        G467N:
        G9vG1:
        goto eoCjv;
        hgnKR:
        OJsG8:
        goto e2W0g;
        mhln_:
        Et4Xw:
        goto QiyyR;
        RVJm1:
        sia3A:
        goto H3go4;
        yfPes:
        global $_W;
        goto qCVdz;
        GDdO5:
        if (!method_exists($site, $method)) {
            goto Et4Xw;
        }
        goto nIhyu;
        q6fne:
        if (empty($pay["\143\x72\145\144\x69\x74"]["\163\x77\x69\x74\143\x68"])) {
            goto sia3A;
        }
        goto w53FV;
        JoIQm:
        if (!(!empty($log) && $log["\x73\164\x61\164\x75\x73"] == "\x31")) {
            goto nyHNT;
        }
        goto BPoYT;
        QVfDG:
        $pars["\72\164\151\x64"] = $params["\164\x69\x64"];
        goto sPiOu;
        FbFrL:
        $pars["\72\165\x6e\151\141\x63\x69\x64"] = $_W["\x75\x6e\x69\141\143\x69\144"];
        goto x4cl2;
        KeZhl:
        $log = pdo_fetch($sql, $pars);
        goto JoIQm;
        j7kb_:
        $site = WeUtility::createModuleSite($pars["\72\x6d\157\144\165\x6c\145"]);
        goto w6nyv;
        e2W0g:
        $pay = $setting["\x70\x61\x79\155\145\x6e\x74"];
        goto q6fne;
        eJYQU:
        $sql = "\123\x45\x4c\105\103\124\x20\x2a\40\x46\x52\117\x4d\x20" . tablename("\143\157\x72\145\x5f\x70\x61\x79\x6c\157\x67") . "\x20\127\x48\105\122\x45\x20\x60\x75\156\x69\x61\143\x69\x64\x60\x3d\72\165\x6e\151\x61\143\151\x64\40\101\116\x44\40\140\x6d\157\144\x75\x6c\x65\140\75\72\x6d\x6f\144\x75\x6c\145\40\x41\x4e\104\40\x60\164\151\144\x60\x3d\x3a\164\151\144";
        goto KeZhl;
        H3go4:
        include $this->template("\x63\157\155\155\157\x6e\x2f\x70\141\x79\x63\145\156\x74\145\x72");
        goto z7jWJ;
        qCVdz:
        if ($this->inMobile) {
            goto G9vG1;
        }
        goto SDglf;
        eoCjv:
        if (!empty($_W["\x6d\x65\155\x62\145\x72"]["\165\151\x64"])) {
            goto ffRiy;
        }
        goto HAhDV;
        z7jWJ:
    }
    public function payResult($ret)
    {
        goto OTso1;
        QudOn:
        Z9T7J:
        goto w5QtV;
        LztMY:
        if (!($ret["\x66\162\x6f\x6d"] == "\x72\145\x74\x75\x72\156")) {
            goto RgHOH;
        }
        goto PQZxn;
        PQZxn:
        if ($ret["\x74\171\160\145"] == "\x63\162\145\x64\x69\x74\62") {
            goto Z9T7J;
        }
        goto qABaa;
        w5QtV:
        message("\345\267\262\xe7\xbb\217\xe6\210\220\345\x8a\x9f\346\x94\xaf\xe4\xbb\x98", url("\155\157\x62\151\154\145\x2f\x63\x68\x61\156\x6e\145\x6c", array("\156\141\x6d\x65" => "\151\156\144\145\x78", "\x77\145\151\144" => $_W["\167\x65\151\x64"])));
        goto Wft5y;
        kYLQM:
        goto KoQuX;
        goto QudOn;
        OTso1:
        global $_W;
        goto LztMY;
        Wft5y:
        KoQuX:
        goto J6yqS;
        J6yqS:
        RgHOH:
        goto hk4ko;
        qABaa:
        message("\345\267\262\347\273\x8f\xe6\x88\x90\xe5\x8a\237\346\224\257\xe4\xbb\230", "\56\x2e\x2f\56\x2e\57" . url("\x6d\157\142\151\x6c\x65\57\x63\150\141\156\x6e\145\154", array("\156\141\x6d\x65" => "\151\156\144\145\170", "\x77\x65\x69\x64" => $_W["\x77\x65\x69\144"])));
        goto kYLQM;
        hk4ko:
    }
}
