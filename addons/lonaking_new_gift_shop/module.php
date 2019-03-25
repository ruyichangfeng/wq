<?php
/*
 __________________________________________________
|  Encode by BajieTeam on we7                      |
|__________________________________________________|
*/

/**
 * 全新积分商城模块定义
 *
 * @author 八戒
 * @url http://bbs.we7.cc/
 */
defined("\111\116\137\x49\x41") or die("\x41\143\x63\x65\163\x73\40\x44\145\x6e\151\x65\x64");
class Lonaking_new_gift_shopModule extends WeModule
{
    public function settingsDisplay($settings)
    {
        goto jD_8m;
        cYsRH:
        $flag = $this->saveSettings($data);
        goto c2Nts;
        tx7GI:
        if (!checksubmit()) {
            goto sP2BR;
        }
        goto bHKtk;
        tobwN:
        message("\344\277\241\346\x81\257\xe4\277\x9d\xe5\255\x98\345\244\xb1\350\264\245", '', "\145\x72\162\157\x72");
        goto wUXJu;
        c2Nts:
        if ($flag) {
            goto kkh0L;
        }
        goto tobwN;
        Ao1Jb:
        load()->func("\x74\160\154");
        goto I6VXd;
        bHKtk:
        load()->func("\x66\151\x6c\x65");
        goto kYgcf;
        AiWUb:
        $data = $_GPC["\144\x61\x74\141"];
        goto tx7GI;
        hjXM2:
        sP2BR:
        goto Ao1Jb;
        fnIVZ:
        message("\344\xbf\xa1\346\x81\xaf\xe4\xbf\235\345\xad\x98\346\210\x90\345\x8a\x9f", '', "\163\x75\143\x63\x65\x73\163");
        goto L277g;
        wUXJu:
        goto M1iP9;
        goto DaaFc;
        I6VXd:
        include $this->template("\163\145\x74\164\x69\x6e\147");
        goto z72kT;
        L277g:
        M1iP9:
        goto hjXM2;
        DaaFc:
        kkh0L:
        goto fnIVZ;
        jD_8m:
        global $_W, $_GPC;
        goto AiWUb;
        kYgcf:
        empty($data["\164\151\164\x6c\x65"]) && message("\346\240\x87\351\242\x98\344\270\x8d\xe8\x83\275\xe4\xb8\xba\xe7\251\xba");
        goto cYsRH;
        z72kT:
    }
}
