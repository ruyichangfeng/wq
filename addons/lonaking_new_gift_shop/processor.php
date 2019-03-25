<?php
/*
 __________________________________________________
|  Encode by BajieTeam on we7                      |
|__________________________________________________|
*/

goto Kjrpn;
CNS4C:
require_once dirname(__FILE__) . "\x2f\143\154\x61\163\x73\x2f\165\163\x65\162\x2f\x4e\x47\123\115\x61\x78\123\143\x65\x6e\145\123\145\x72\166\151\x63\145\56\x70\x68\160";
goto HR4LZ;
HR4LZ:
require_once dirname(__FILE__) . "\57\x63\x6c\x61\163\163\57\142\154\x6f\x63\x6b\x2f\116\x47\x53\x42\154\157\143\x6b\123\145\162\x76\151\x63\x65\x2e\160\x68\x70";
goto Ke0vu;
Ke0vu:
require_once dirname(__FILE__) . "\x2f\x6c\x69\x62\x2f\120\157\163\x74\145\162\110\141\x6e\x64\x6c\x65\162\x2e\x70\150\160";
goto kTcqr;
Kjrpn:
/**
 * 全新积分商城模块处理程序
 *
 * @author 八戒
 * @url http://bbs.we7.cc/
 */
defined("\111\x4e\x5f\111\x41") or die("\101\143\x63\x65\x73\x73\40\x44\145\156\151\145\144");
goto Rah0D;
Rah0D:
require_once dirname(__FILE__) . "\57\143\x6c\141\x73\x73\x2f\160\x6f\x73\x74\x65\162\57\x4e\x47\x53\x50\157\x73\x74\145\x72\x53\x65\x72\166\151\143\145\x2e\160\x68\x70";
goto PU0kN;
PU0kN:
require_once dirname(__FILE__) . "\57\143\154\x61\163\163\57\x75\163\x65\x72\57\116\x47\x53\x55\163\145\162\x53\x65\x72\166\151\143\145\x2e\x70\x68\160";
goto CNS4C;
kTcqr:
class Lonaking_new_gift_shopModuleProcessor extends WeModuleProcessor
{
    private $posterService;
    private $userService;
    private $maxSceneService;
    private $blockService;
    public function __construct()
    {
        goto ODEQn;
        xKRNW:
        $this->blockService = new NGSBlockService();
        goto EtwbT;
        EZuLn:
        $this->maxSceneService = new NGSMaxSceneService();
        goto xKRNW;
        kJql1:
        $this->userService = new NGSUserService();
        goto EZuLn;
        ODEQn:
        $this->posterService = new NGSPosterService();
        goto kJql1;
        EtwbT:
    }
    public function respond()
    {
        goto oB23f;
        Xh6IF:
        return $this->respText($this->module["\x63\x6f\156\x66\151\147"]["\x6d\141\153\x65\137\154\151\x6d\151\164\x5f\164\x69\x70"]);
        goto d17M9;
        is1mV:
        $userAvatarPath = '';
        goto nrGLE;
        cAVay:
        $this->posterService->log($res, "\xe5\x8f\221\351\x80\201\xe7\x94\237\346\210\x90\346\265\267\xe6\x8a\245\xe5\x89\215\347\x9a\x84\351\x80\x9a\xe7\x9f\xa5\346\x88\x90\xe5\x8a\237\54\345\274\x80\345\247\x8b\xe6\x9f\245\346\211\276\346\265\267\346\212\xa5\351\x85\x8d\xe7\275\256\xe4\277\xa1\346\201\xaf");
        goto r25xo;
        TeWlt:
        $openid = $this->message["\146\162\157\x6d\x75\x73\145\x72\156\141\155\x65"];
        goto h9KoJ;
        UKzVM:
        $this->posterService->log($this->message, "\xe6\255\xa3\xe5\x9c\250\xe7\224\237\346\210\220\xe4\xb8\255\x2e\x2e\x2e");
        goto Yk0tq;
        Jx6DC:
        $userAvatarPath = "{$userRoot}\141\166\x61\164\141\162\x53\x72\143\x2e\152\160\x65\x67";
        goto YoX2B;
        SGlDy:
        $this->userService->log($tmp_fans, "\347\x94\237\346\x88\220\xe6\265\267\346\x8a\245\345\211\x8d\xe6\243\x80\346\xb5\213\xe7\x94\xa8\346\x88\267\347\232\204\345\244\264\xe5\x83\x8f\xe6\210\220\345\x8a\237");
        goto s2kA_;
        YiCPo:
        file_write("{$userRoot}\x2f\161\162\x63\157\144\145\123\162\x63\56\x6a\160\x65\x67", $qrcodeContent);
        goto ZUc1H;
        KlnJe:
        $this->userService->startPosting($user["\x6f\x70\145\156\x69\144"]);
        goto log9q;
        Osjd0:
        $this->userService->log($user["\151\x6e\x76\x69\164\145\137\143\157\x64\x65"], "\xe7\x94\237\346\x88\220\351\x82\200\350\257\267\xe7\240\x81\346\210\220\xe5\x8a\237");
        goto sZleT;
        XGKqd:
        $qrcodeContent = file_get_contents($qrcodeUrl);
        goto YiCPo;
        NJDeW:
        o4tN4:
        goto NEfFv;
        sZleT:
        ladnw:
        goto z1ICn;
        oB23f:
        $start = time();
        goto ndhnb;
        jP87d:
        M9q2q:
        goto vSRyt;
        vSRyt:
        if (!(time() - $user["\160\157\x73\x74\145\x72\137\165\x70\x64\141\x74\145\x5f\164\151\x6d\145"] < 20 && $this->module["\x63\x6f\156\x66\x69\x67"]["\160\157\163\x74\145\x72\x5f\144\145\x62\165\147"] == 0)) {
            goto zzMMM;
        }
        goto Xh6IF;
        d17M9:
        zzMMM:
        goto KLmwv;
        Cflkx:
        $qrcodeUrl = $this->makeQrcode($user);
        goto CVcDl;
        q0vw2:
        if (!($user["\142\x6c\141\x63\153"] == 1)) {
            goto mmePS;
        }
        goto UKsce;
        r25xo:
        $posterConfig = $this->posterService->getPosterConfig($_W["\x75\x6e\151\141\x63\x69\x64"]);
        goto MBYab;
        YoX2B:
        $this->userService->log($user["\x61\x76\141\x74\141\162"], "\347\224\x9f\346\210\220\xe7\x94\xa8\xe6\x88\xb7\347\232\x84\xe5\244\264\xe5\203\217");
        goto boUI9;
        U17Id:
        $realBaseRoot = ATTACHMENT_ROOT . "\57" . $baseRoot;
        goto apVGu;
        qmSRI:
        $_W["\146\x72\157\155\x75\x73\x65\162\156\141\x6d\x65"] = $openid;
        goto MmhaG;
        ivsOx:
        try {
            goto sW7Uc;
            gQQtc:
            $handler->setDstImg(ATTACHMENT_ROOT . "\57" . $userRoot . "\160\157\x73\164\x65\162\x2e\152\160\x67");
            goto NQXT3;
            oKEA0:
            $handler = new PosterHandler();
            goto Wkd8l;
            Hnd4C:
            $handler->setNicknameOffsetY($posterConfig["\160\157\163\164\x65\162\x5f\x6e\x61\155\x65\x5f\160\157\x73\151\x74\x69\157\156\137\x79"]);
            goto crAY8;
            wKIcI:
            $res = $this->posterService->sendImageMessage($openid, $mediaId);
            goto d87x7;
            i0CuZ:
            $this->userService->updateLastPosterTime($openid);
            goto Uq2ao;
            e7_lm:
            $mediaId = $this->upload_img_to_wechat_server($realUserRoot . "\57\x70\x6f\x73\164\x65\x72\56\x6a\x70\147");
            goto wKIcI;
            fCaci:
            $this->userService->endPosting($user["\157\x70\145\x6e\151\144"]);
            goto DiOoL;
            crAY8:
            i4fzm:
            goto gQQtc;
            Oqvhs:
            $user["\160\157\x73\x74\145\x72\137\165\160\144\141\x74\x65\137\164\x69\x6d\x65"] = time();
            goto i0CuZ;
            x181b:
            $handler->setDstImg($realUserRoot . "\x2f\160\x6f\163\164\x65\162\x2e\152\160\147");
            goto bElFW;
            D8u1z:
            $avatarHandler->setOnlyCut(true);
            goto atTai;
            s8tzp:
            ouh2V:
            goto jy7N9;
            HlPJb:
            $avatarHandler = new PosterHandler();
            goto cOzkT;
            atTai:
            $avatarHandler->setDstImg($realUserRoot . "\x61\166\141\164\x61\x72\56\152\160\x65\147");
            goto tXcAc;
            pcf2y:
            return $this->respText('');
            goto TGx4W;
            duIQ9:
            $qrcodeHandler->setOnlyCut(true);
            goto KIpvJ;
            dn2Ja:
            $handler->setNicknameOffsetX($posterConfig["\x70\x6f\163\164\x65\x72\x5f\x6e\141\x6d\145\x5f\160\157\163\151\x74\x69\157\x6e\137\x78"]);
            goto Hnd4C;
            KIpvJ:
            $qrcodeHandler->setDstImg($realUserRoot . "\161\162\143\157\x64\145\x2e\x6a\160\145\147");
            goto fmHpL;
            C0Zsa:
            $handler->setAvatarOffsetX($posterConfig["\x70\157\x73\164\x65\162\x5f\x61\x76\x61\164\x61\162\137\160\x6f\x73\151\x74\x69\x6f\156\137\x78"]);
            goto Pek5x;
            AxT8p:
            $handler->setQrcodeOffsetX($posterConfig["\160\x6f\x73\x74\x65\x72\x5f\161\162\x63\157\x64\x65\x5f\x70\157\x73\151\164\151\x6f\156\x5f\x78"]);
            goto VJ8k2;
            bElFW:
            $handler->setQrcodeImg($realUserRoot . "\161\x72\143\x6f\x64\x65\56\x6a\x70\145\x67");
            goto AxT8p;
            Uq2ao:
            $this->posterService->sendTextMessage($openid, $this->module["\x63\157\x6e\146\x69\147"]["\155\141\153\x65\137\x61\146\164\x65\x72\137\164\x69\x70"]);
            goto ez4ty;
            cOzkT:
            $avatarHandler->setSrcImg($realUserRoot . "\x61\x76\141\164\x61\162\123\162\143\x2e\x6a\x70\x65\x67");
            goto D8u1z;
            kmK2H:
            $handler->setNicknameFontSize($posterConfig["\x70\x6f\x73\x74\145\162\137\x6e\x61\155\x65\137\146\157\156\164\x5f\163\x69\172\145"]);
            goto dn2Ja;
            LGy6L:
            $handler->setNicknameFontColor($posterConfig["\160\157\163\164\x65\162\x5f\x6e\141\155\145\x5f\143\x6f\154\x6f\162"]);
            goto kmK2H;
            tvx3J:
            $qrcodeHandler = new PosterHandler();
            goto ugyf3;
            NQXT3:
            $handler->createImg(100);
            goto vwrpD;
            ez4ty:
            $this->blockService->unBlock($openid, $createtime);
            goto pcf2y;
            VJ8k2:
            $handler->setQrcodeOffsetY($posterConfig["\160\x6f\x73\x74\145\162\137\161\x72\x63\157\144\x65\x5f\160\x6f\x73\x69\164\151\157\x6e\137\x79"]);
            goto PbcTU;
            yiB33:
            RZtwL:
            goto tvx3J;
            vwrpD:
            $this->posterService->log($this->message, "\xe5\217\221\xe9\x80\201\346\266\210\xe6\x81\xaf\72");
            goto e7_lm;
            fmHpL:
            $qrcodeHandler->createImg($posterConfig["\160\x6f\x73\x74\x65\x72\137\x71\162\x63\157\x64\145\137\x73\x69\144\145"], $posterConfig["\160\x6f\x73\x74\145\162\137\161\162\143\x6f\144\x65\x5f\163\151\144\145"]);
            goto cX03x;
            jj_Nj:
            $handler->setNicknameFont(dirname(__FILE__) . "\x2f\x6c\151\x62\x2f\x66\157\156\164\x2f\155\x73\x79\x68\56\164\164\x66");
            goto LGy6L;
            cX03x:
            $this->posterService->log(null, "\344\272\214\xe7\xbb\xb4\347\240\x81\350\xa3\201\xe5\211\252\xe6\210\x90\345\x8a\x9f");
            goto oKEA0;
            nclrV:
            $this->posterService->log(null, "\xe5\xa4\xb4\xe5\x83\217\xe8\243\201\345\x89\xaa\346\210\220\xe5\212\x9f");
            goto yiB33;
            Wkd8l:
            $handler->setSrcImg($bg);
            goto x181b;
            vXVBs:
            $handler->setAvatarImg(ATTACHMENT_ROOT . "\57" . $userRoot . "\x61\x76\141\164\141\x72\56\x6a\x70\x65\147");
            goto C0Zsa;
            sW7Uc:
            if (!$posterConfig["\160\x6f\x73\164\x65\x72\x5f\150\141\x73\137\141\166\x61\164\x61\162"]) {
                goto RZtwL;
            }
            goto GUFC0;
            tXcAc:
            $avatarHandler->createImg($posterConfig["\x70\157\x73\x74\145\x72\x5f\141\x76\x61\164\141\x72\137\163\151\144\145"], $posterConfig["\160\157\163\x74\x65\162\x5f\141\x76\x61\164\141\x72\x5f\x73\151\144\x65"]);
            goto nclrV;
            jy7N9:
            if (!$posterConfig["\x70\157\163\164\145\162\x5f\x68\x61\x73\x5f\156\x69\x63\153\x6e\141\x6d\x65"]) {
                goto i4fzm;
            }
            goto Bp3L2;
            GUFC0:
            $this->posterService->log($userAvatarPath, "\345\274\200\345\xa7\x8b\xe8\xa3\201\xe5\211\xaa\xe5\244\xb4\xe5\x83\217");
            goto HlPJb;
            DiOoL:
            $user["\x69\156\x5f\x70\x6f\x73\x74\151\156\x67"] = NGSUserService::POSTER_FREE;
            goto Oqvhs;
            ugyf3:
            $qrcodeHandler->setSrcImg($realUserRoot . "\161\162\143\157\144\145\123\162\x63\56\152\x70\145\x67");
            goto duIQ9;
            PbcTU:
            if (!$posterConfig["\x70\x6f\163\x74\x65\x72\137\150\141\163\x5f\x61\166\141\164\x61\x72"]) {
                goto ouh2V;
            }
            goto vXVBs;
            Bp3L2:
            $handler->setNickname($this->emojiFilter($user["\x6e\151\143\x6b\x6e\x61\x6d\145"]));
            goto jj_Nj;
            d87x7:
            $this->posterService->log($res, "\xe5\217\221\xe9\x80\201\346\265\267\346\212\245\xe6\210\x90\345\212\x9f");
            goto fCaci;
            Pek5x:
            $handler->setAvatarOffsetY($posterConfig["\x70\157\163\164\x65\162\137\141\x76\x61\164\141\162\x5f\160\x6f\x73\151\164\151\157\156\x5f\171"]);
            goto s8tzp;
            TGx4W:
        } catch (Exception $e) {
            goto dxJyW;
            BTp0H:
            $this->blockService->unBlock($openid, $createtime);
            goto t6ppv;
            t6ppv:
            $this->userService->endPosting($user["\x6f\x70\x65\156\x69\x64"]);
            goto xGKS0;
            dxJyW:
            $this->posterService->log($e->getCode(), $e->getMessage());
            goto BTp0H;
            xGKS0:
            return $this->respText($e->getMessage());
            goto z_pV1;
            z_pV1:
        }
        goto Zf03L;
        VWDXA:
        $this->posterService->log($user, "\xe8\x8e\xb7\xe5\x8f\x96\xe5\x88\260\347\224\250\346\210\267\xe4\xbf\xa1\xe6\201\257\345\xa6\x82\xe4\xb8\x8b");
        goto Ix0yG;
        Yk0tq:
        return $this->respText('');
        goto jP87d;
        boUI9:
        q9Tam:
        goto j93dS;
        D_bPf:
        $this->blockService->block($openid, $createtime);
        goto YvWZQ;
        ndhnb:
        global $_W;
        goto g5ZDI;
        YvWZQ:
        $res = $this->posterService->sendTextMessage($openid, $this->module["\143\157\x6e\146\151\147"]["\155\141\153\x65\137\142\145\146\157\x72\145\137\x74\x69\x70"]);
        goto cAVay;
        NOPfZ:
        $this->posterService->log(file_exists("{$realUserRoot}\161\162\143\x6f\x64\x65\x53\x72\x63\56\152\160\145\x67"), "\xe6\xa3\x80\346\265\x8b\xe4\272\214\xe7\xbb\264\347\xa0\x81\xe6\x98\257\xe5\220\xa6\350\xbf\x87\346\234\237");
        goto AFpBE;
        pcg4V:
        $realUserRoot = $realBaseRoot . $openid . "\57";
        goto tYgnc;
        ivfbM:
        if (!($user["\151\x6e\x5f\160\x6f\x73\x74\x69\156\147"] == NGSUserService::POSTER_POSTING)) {
            goto M9q2q;
        }
        goto UKzVM;
        To7W9:
        $this->userService->log($user, "\346\243\200\346\265\213\347\224\xa8\346\210\267\347\x9a\204\345\244\xb4\345\203\217\xe6\210\x90\xe5\212\237");
        goto azT6T;
        Xj1AE:
        $this->userService->log($user, "\x67\145\164\x55\163\x65\x72\111\156\146\x6f\x49\x6e\101\x70\160\347\xbb\x93\346\x9e\234\xe4\270\272");
        goto To7W9;
        Ix0yG:
        load()->func("\146\151\154\145");
        goto Eylp2;
        j93dS:
        l1cC6:
        goto NOPfZ;
        rRS5S:
        if (file_exists("{$realUserRoot}\141\166\x61\164\x61\x72\x53\162\143\x2e\x6a\160\x65\147")) {
            goto IFqUA;
        }
        goto nTES9;
        g5ZDI:
        $content = $this->message["\143\157\156\x74\x65\156\164"];
        goto fesX8;
        nMuEp:
        load()->func("\146\x69\154\145");
        goto oCOhF;
        AFpBE:
        if (!(!$this->is_local_resource($user["\161\x72\x63\x6f\144\145"]) || time() - intval($user["\x71\x72\x63\157\144\145\x5f\165\x70\144\141\x74\145\x5f\x74\x69\155\x65"]) >= 2590000 || !file_exists("{$realUserRoot}\x71\x72\143\x6f\x64\x65\x53\162\143\56\152\x70\x65\147" || !file_exists("{$realUserRoot}\x71\x72\143\157\x64\145\x2e\x6a\160\x65\x67")))) {
            goto o4tN4;
        }
        goto Cflkx;
        ykRwp:
        if (!(empty($user["\151\156\x76\x69\x74\x65\137\143\x6f\144\145"]) || $user["\151\156\x76\151\x74\x65\x5f\143\157\x64\145"] == 0)) {
            goto ladnw;
        }
        goto iXstD;
        xqmR2:
        $this->userService->updateData($user);
        goto ivsOx;
        oCOhF:
        $bg = ATTACHMENT_ROOT . $posterConfig["\x70\x6f\x73\164\x65\162\137\142\x67\137\x72"];
        goto is1mV;
        KLmwv:
        goto K3GM9;
        goto rk0S9;
        ayjTg:
        $user["\160\157\163\164\145\x72\x5f\x74\x69\x6d\145\163"] = $user["\x70\157\163\x74\145\162\x5f\164\x69\155\145\163"] + 1;
        goto xqmR2;
        S7yXz:
        $this->userService->log($user["\x71\x72\143\x6f\x64\x65"], "\347\x94\237\xe6\x88\220\347\x94\250\xe6\x88\267\xe7\232\204\xe4\xba\x8c\347\xbb\xb4\xe7\xa0\201");
        goto NJDeW;
        MBYab:
        $this->posterService->log($posterConfig, "\346\237\xa5\346\x89\xbe\345\x87\272\xe6\265\xb7\346\x8a\xa5\347\x9a\x84\351\205\215\xe7\275\256\xe4\xbf\xa1\xe6\201\257\xe5\246\x82\344\xb8\x8b\x3a");
        goto nMuEp;
        J23K8:
        return $this->respText('');
        goto Yz6l9;
        nTES9:
        $avatarContent = file_get_contents($user["\x61\166\141\x74\141\x72"]);
        goto e3qNe;
        Zf03L:
        SC9oY:
        goto rsW7l;
        Yz6l9:
        K3GM9:
        goto ykRwp;
        wG5mo:
        $this->posterService->log($this->message, "\346\234\254\346\254\xa1\350\xaf\267\346\xb1\x82\344\xb8\272\351\x87\x8d\xe5\xa4\x8d\350\xaf\xb7\xe6\xb1\x82");
        goto J23K8;
        F1GoC:
        $this->userService->log($tmp_fans, "\xe8\216\xb7\xe5\217\226\345\x88\260\344\xb8\264\xe6\227\xb6\347\262\211\xe4\270\x9d\344\xbf\xa1\xe6\201\257\344\270\xba");
        goto VWDXA;
        UKsce:
        return $this->respText("\xe6\202\250\345\xb7\xb2\xe8\242\253\346\x8b\211\xe5\x85\245\xe9\xbb\221\345\x90\215\345\x8d\225\xef\274\x8c\346\x97\xa0\346\263\x95\347\x94\237\346\210\220\xe6\xb5\xb7\xe6\x8a\xa5");
        goto MTSeH;
        ZUc1H:
        $user["\161\x72\143\157\144\145\x5f\x75\x70\x64\x61\x74\145\137\164\x69\155\145"] = time();
        goto R6Iw0;
        s2kA_:
        if ($this->is_local_resource($user["\x61\x76\x61\164\x61\x72"])) {
            goto q9Tam;
        }
        goto rRS5S;
        Eylp2:
        if ($this->blockService->isBlock($openid, $createtime)) {
            goto ZioxF;
        }
        goto ivfbM;
        azT6T:
        $tmp_fans = mc_fansinfo($user["\157\x70\x65\156\x69\144"]);
        goto F1GoC;
        z1ICn:
        if (!($content == $makeKey)) {
            goto SC9oY;
        }
        goto KlnJe;
        rk0S9:
        ZioxF:
        goto wG5mo;
        NEfFv:
        $user["\160\157\x73\x74\x65\162\x5f\x75\160\144\x61\x74\x65\137\x74\x69\x6d\x65"] = time();
        goto ayjTg;
        e3qNe:
        file_write("{$userRoot}\57\141\166\141\x74\x61\x72\x53\162\x63\56\152\160\x65\x67", $avatarContent);
        goto HTpzc;
        h9KoJ:
        $createtime = $this->message["\x63\x72\x65\141\164\145\164\151\x6d\145"];
        goto qmSRI;
        HTpzc:
        IFqUA:
        goto Jx6DC;
        GaAE7:
        $msgid = $this->message["\x6d\163\x67\151\144"];
        goto TeWlt;
        iXstD:
        $user["\151\156\x76\x69\164\x65\x5f\143\157\x64\x65"] = $this->maxSceneService->generateOneInviteCode($_W["\x75\156\x69\x61\143\151\144"]);
        goto Osjd0;
        XDh2K:
        $tmp_fans = mc_fansinfo($user["\157\x70\145\x6e\x69\144"]);
        goto SGlDy;
        CVcDl:
        $this->posterService->log($user, "\xe9\x87\215\xe6\226\xb0\347\224\237\346\x88\x90\344\272\x8c\347\273\264\347\240\x81\72{$qrcodeUrl}");
        goto XGKqd;
        MTSeH:
        mmePS:
        goto Xj1AE;
        fesX8:
        $makeKey = $this->module["\x63\x6f\x6e\146\x69\x67"]["\x6d\x61\x6b\x65\x5f\153\145\171"];
        goto GaAE7;
        MmhaG:
        $baseRoot = "\x6c\157\x6e\x61\153\x69\x6e\147\137\x6e\145\167\137\x67\x69\x66\164\137\163\150\157\x70\x2f\x70\x6f\163\x74\145\x72\x2f{$_W["\x75\x6e\x69\141\143\x69\144"]}\57";
        goto U17Id;
        tYgnc:
        $user = $this->userService->getUserInfoInApp($openid);
        goto q0vw2;
        c2ayn:
        $user["\x69\x6e\x5f\x70\157\x73\x74\151\x6e\147"] = NGSUserService::POSTER_POSTING;
        goto D_bPf;
        apVGu:
        $userRoot = $baseRoot . $openid . "\57";
        goto pcg4V;
        nrGLE:
        if (!$posterConfig["\x70\x6f\163\164\145\162\x5f\x68\x61\x73\137\141\x76\141\x74\141\x72"]) {
            goto l1cC6;
        }
        goto XDh2K;
        log9q:
        $this->userService->log('', "\345\xbc\200\345\xa7\213\347\x94\x9f\xe6\210\220\xe6\265\267\346\x8a\xa5");
        goto c2ayn;
        R6Iw0:
        $user["\161\162\143\x6f\144\145"] = "\154\x6f\x6e\x61\x6b\151\x6e\147\137\x6e\x65\167\x5f\147\x69\146\164\x5f\163\x68\157\160\x2f\160\x6f\163\164\145\x72\x2f{$_W["\x75\156\x69\141\143\x69\x64"]}\x2f{$openid}\57\161\x72\x63\157\x64\x65\x53\x72\143\56\x6a\x70\145\147";
        goto S7yXz;
        rsW7l:
    }
    private function makePoster($posterConfig, $openid, $uniacid)
    {
    }
    private function makeQrcode($user)
    {
        goto zH21b;
        FI_3s:
        if (!($qrcode["\145\x72\162\x6e\x6f"] != -1)) {
            goto ixmtE;
        }
        goto dKF5v;
        dKF5v:
        $qrcode_url = "\x68\164\164\160\x73\x3a\57\x2f\x6d\x70\56\x77\145\x69\170\x69\x6e\x2e\x71\x71\56\x63\x6f\x6d\x2f\x63\147\151\55\x62\x69\156\57\163\150\x6f\167\161\162\143\157\x64\145\77\164\151\x63\153\x65\164\75" . urlencode($qrcode["\x74\x69\143\153\x65\164"]);
        goto Q_ViT;
        TSa52:
        $barcode = array("\145\x78\160\151\x72\145\137\x73\145\143\x6f\156\144\x73" => 2592000, "\141\143\x74\151\157\156\x5f\x6e\x61\155\x65" => "\121\x52\137\x53\x43\x45\x4e\105", "\141\143\164\151\157\156\137\x69\x6e\x66\x6f" => array("\x73\143\145\156\x65" => array("\163\143\x65\x6e\145\137\x69\144" => $user["\x69\156\166\151\x74\x65\137\143\157\x64\x65"])));
        goto Xm9Bq;
        zH21b:
        global $_GPC, $_W;
        goto TSa52;
        Q_ViT:
        return $qrcode_url;
        goto dNrJx;
        xgmhm:
        $qrcode = $account->barCodeCreateDisposable($barcode);
        goto FI_3s;
        XqFe4:
        $account = WeiXinAccount::create($this->userService->getUniacid());
        goto xgmhm;
        dNrJx:
        ixmtE:
        goto VCcTw;
        Xm9Bq:
        load()->classs("\x77\x65\x69\170\151\x6e\56\141\143\143\x6f\165\x6e\164");
        goto XqFe4;
        VCcTw:
    }
    private function is_local_resource($resource)
    {
        goto BA0A1;
        SXWB9:
        return true;
        goto Hm1aT;
        BA0A1:
        if (!(trim($resource) == '')) {
            goto WrkTS;
        }
        goto w118n;
        w118n:
        return false;
        goto RqQr6;
        eExaZ:
        Az30K:
        goto dBlo2;
        RqQr6:
        WrkTS:
        goto iizUd;
        dBlo2:
        return false;
        goto bTNOW;
        bTNOW:
        i_Miz:
        goto pz0nj;
        Hm1aT:
        goto i_Miz;
        goto eExaZ;
        iizUd:
        if (trim(substr($resource, 0, 4)) == "\x68\x74\164\160") {
            goto Az30K;
        }
        goto SXWB9;
        pz0nj:
    }
    private function upload_img_to_wechat_server($imgPath)
    {
        goto te1Dr;
        itmUQ:
        $result = curl_exec($ch1);
        goto LhhhO;
        Mp8Y7:
        curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, FALSE);
        goto YtBtw;
        VFkuh:
        goto tnnvg;
        goto At12k;
        YtBtw:
        curl_setopt($ch1, CURLOPT_SSL_VERIFYHOST, FALSE);
        goto Fcj8W;
        zB9Mo:
        curl_setopt($ch1, CURLOPT_POSTFIELDS, $data);
        goto itmUQ;
        LhhhO:
        curl_close($ch1);
        goto lJEGY;
        ZyDfN:
        $res = json_decode($result, true);
        goto P1TS2;
        Y0qsi:
        $ch1 = curl_init();
        goto RUztu;
        VVmwh:
        curl_setopt($ch1, CURLOPT_POST, true);
        goto zB9Mo;
        RUztu:
        if (!(strpos($api, "\x68\164\164\160\163\x3a\57\x2f") !== FALSE)) {
            goto xf_HM;
        }
        goto Mp8Y7;
        LnHba:
        $api = "\x68\x74\164\160\163\x3a\x2f\x2f\141\x70\x69\56\x77\145\x69\170\151\x6e\56\161\x71\x2e\143\x6f\x6d\x2f\x63\x67\x69\55\x62\151\x6e\x2f\x6d\x65\144\x69\x61\57\x75\x70\x6c\157\141\x64\x3f\x61\x63\143\x65\163\x73\x5f\164\157\153\145\156\x3d" . $access_token . "\46\x74\171\160\145\75\x69\155\x61\x67\145";
        goto BpRT0;
        P1TS2:
        $this->posterService->log($res, "\xe8\xbf\x94\xe5\233\x9e\xe7\273\223\xe6\236\x9c");
        goto bzm8s;
        wujwC:
        curl_setopt($ch1, CURLOPT_URL, $api);
        goto kI4o0;
        zz8wn:
        tnnvg:
        goto qXnA0;
        BpRT0:
        $data = array("\155\x65\144\x69\141" => "\x40" . $imgPath);
        goto Y0qsi;
        eQHEb:
        curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
        goto VVmwh;
        u2sSB:
        $access_token = $account->getAccessToken();
        goto C8GOh;
        kI4o0:
        curl_setopt($ch1, CURLOPT_SAFE_UPLOAD, false);
        goto eQHEb;
        lJEGY:
        if (curl_errno($ch1) == 0) {
            goto qzUbp;
        }
        goto V5ipH;
        bzm8s:
        return $res["\x6d\145\x64\151\141\x5f\x69\144"];
        goto zz8wn;
        V5ipH:
        return false;
        goto VFkuh;
        Fcj8W:
        xf_HM:
        goto wujwC;
        C8GOh:
        $this->posterService->log($access_token, "\346\x9c\x80\346\226\xb0\xe7\232\204\x74\x6f\x6b\145\x6e\346\x98\xaf");
        goto LnHba;
        te1Dr:
        global $_W;
        goto gnrsj;
        gnrsj:
        $account = $this->posterService->createWexinAccount();
        goto u2sSB;
        At12k:
        qzUbp:
        goto ZyDfN;
        qXnA0:
    }
    function emojiFilter($nickname)
    {
        goto fT65A;
        n5vQR:
        $tmpStr = preg_replace("\43\50\134\x5c\x75\144\x5b\60\55\71\141\x2d\x66\x5d\x7b\x33\175\51\x7c\50\134\134\x75\145\x5b\60\x2d\x39\141\x2d\x66\135\x7b\63\175\51\x23\x69\x65", '', $tmpStr);
        goto c9e2w;
        WWcnf:
        return $text;
        goto lnZaV;
        c9e2w:
        $text = json_decode($tmpStr, true);
        goto WWcnf;
        fT65A:
        $tmpStr = json_encode($nickname);
        goto n5vQR;
        lnZaV:
    }
}
