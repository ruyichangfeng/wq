<?php
/*
 __________________________________________________
|  Encode by BajieTeam on we7                      |
|__________________________________________________|
*/

class PosterHandler
{
    var $dst_img;
    var $h_src;
    var $h_dst;
    var $h_mask;
    var $img_create_quality = 100;
    var $img_display_quality = 100;
    var $img_scale = 0;
    var $src_w = 0;
    var $src_h = 0;
    var $dst_w = 0;
    var $dst_h = 0;
    var $fill_w;
    var $fill_h;
    var $copy_w;
    var $copy_h;
    var $src_x = 0;
    var $src_y = 0;
    var $start_x;
    var $start_y;
    var $mask_word;
    var $mask_img;
    var $mask_pos_x = 0;
    var $mask_pos_y = 0;
    var $mask_offset_x = 5;
    var $mask_offset_y = 5;
    var $font_w;
    var $font_h;
    var $mask_w;
    var $mask_h;
    var $mask_font_color = "\43\146\146\146\146\146\x66";
    var $mask_font = 2;
    var $font_size;
    var $mask_position = 0;
    var $mask_img_pct = 100;
    var $mask_txt_pct = 1;
    var $img_border_size = 0;
    var $img_border_color;
    var $_flip_x = 0;
    var $_flip_y = 0;
    var $cut_type = 0;
    var $img_type;
    var $create_index = 0;
    var $nickname;
    var $nickname_font;
    var $nickname_font_size;
    var $nickname_font_color = "\x23\x66\x66\x66\146\x66\146";
    var $nickname_pos_x = 0;
    var $nickname_pos_y = 0;
    var $nickname_offset_x = 5;
    var $nickname_offset_y = 5;
    var $nickname_font_w;
    var $nickname_font_h;
    var $nickname_mask_w;
    var $nickname_mask_h;
    var $nickname_position = 0;
    var $avatar_img;
    var $avatar_pos_x = 0;
    var $avatar_pos_y = 0;
    var $avatar_offset_x = 5;
    var $avatar_offset_y = 5;
    var $avatar_mask_w;
    var $avatar_mask_h;
    var $avatar_position = 0;
    var $qrcode_img;
    var $qrcode_pos_x = 0;
    var $qrcode_pos_y = 0;
    var $qrcode_offset_x = 5;
    var $qrcode_offset_y = 5;
    var $qrcode_mask_w;
    var $qrcode_mask_h;
    var $qrcode_position = 0;
    var $invite_code;
    var $invite_code_font;
    var $invite_code_font_size;
    var $invite_code_font_color = "\43\146\146\146\x66\x66\146";
    var $invite_code_pos_x = 0;
    var $invite_code_pos_y = 0;
    var $invite_code_offset_x = 5;
    var $invite_code_offset_y = 5;
    var $invite_code_font_w;
    var $invite_code_font_h;
    var $invite_code_mask_w;
    var $invite_code_mask_h;
    var $invite_code_position = 0;
    var $only_cut = false;
    var $all_type = array("\152\x70\x67" => array("\x6f\165\164\160\x75\164" => "\x69\x6d\141\x67\x65\152\160\145\147"), "\x67\x69\x66" => array("\x6f\165\164\x70\165\x74" => "\151\155\141\147\x65\147\151\x66"), "\160\156\x67" => array("\x6f\x75\x74\x70\165\164" => "\x69\155\141\x67\145\160\156\147"), "\x77\142\155\160" => array("\157\165\164\x70\165\x74" => "\x69\x6d\x61\x67\145\62\x77\x62\155\x70"), "\152\160\145\x67" => array("\x6f\165\164\x70\x75\164" => "\151\155\141\147\145\152\160\145\x67"));
    /**
     * 构造函数
     */
    function CusThumbHandler()
    {
        goto RwaSJ;
        hDTDp:
        $this->font = 2;
        goto Dbcsx;
        Dbcsx:
        $this->font_size = 12;
        goto TlvLn;
        RwaSJ:
        $this->mask_font_color = "\43\x66\146\x66\146\x66\x66";
        goto hDTDp;
        TlvLn:
    }
    /**
     * 取得图片的宽
     */
    function getImgWidth($src)
    {
        return imagesx($src);
    }
    /**
     * 取得图片的高
     */
    function getImgHeight($src)
    {
        return imagesy($src);
    }
    /**
     * 设置源图片路径
     *
     * @param    string    $src_img   图片生成路径
     */
    function setSrcImg($src_img, $img_type = null)
    {
        goto jET3a;
        Tqi6r:
        $this->h_src = @ImageCreateFromString($src);
        goto iQBrW;
        MLoXM:
        if (!empty($img_type)) {
            goto L5KcJ;
        }
        goto Mc2X7;
        dgLwM:
        $this->img_type = $img_type;
        goto F7Z7r;
        h4sK_:
        $handle = fopen($src_img, "\162");
        goto lPUU2;
        QefWg:
        goto UusTr;
        goto DmK4P;
        vsq9p:
        if (function_exists("\146\151\154\145\x5f\147\x65\x74\x5f\143\x6f\x6e\164\145\156\x74\x73")) {
            goto SW9z1;
        }
        goto h4sK_;
        rHyzl:
        if (!empty($src)) {
            goto tGUGS;
        }
        goto k7JeR;
        F7Z7r:
        Py7jx:
        goto pj5vw;
        lPUU2:
        Leh1_:
        goto a8ygf;
        Mc2X7:
        $this->img_type = $this->_getImgType($src_img);
        goto YMK3L;
        k7JeR:
        throw new Exception("\xe5\233\xbe\347\x89\207\xe6\xba\220\344\xb8\272\347\xa9\272" . $src_img, 400);
        goto nHFc9;
        deF4G:
        F3HRu:
        goto OsvSY;
        nHFc9:
        tGUGS:
        goto Tqi6r;
        YMK3L:
        goto Py7jx;
        goto ND8YS;
        rWIkR:
        throw new Exception("\xe5\x9b\276\347\x89\207\344\270\x8d\345\xad\x98\xe5\x9c\xa8" . $src_img, 400);
        goto N_9e4;
        iQBrW:
        $this->src_w = $this->getImgWidth($this->h_src);
        goto Ym7ta;
        we_1Y:
        $src = file_get_contents($src_img);
        goto rfw_F;
        OsvSY:
        fclose($handle);
        goto QefWg;
        a8ygf:
        if (feof($handle)) {
            goto F3HRu;
        }
        goto YaOci;
        frFFw:
        goto Leh1_;
        goto deF4G;
        DmK4P:
        SW9z1:
        goto we_1Y;
        jET3a:
        if (file_exists($src_img)) {
            goto hzzJa;
        }
        goto rWIkR;
        Ym7ta:
        $this->src_h = $this->getImgHeight($this->h_src);
        goto htjfW;
        N_9e4:
        hzzJa:
        goto MLoXM;
        AO7HU:
        $src = '';
        goto vsq9p;
        rfw_F:
        UusTr:
        goto rHyzl;
        ND8YS:
        L5KcJ:
        goto dgLwM;
        YaOci:
        $src .= fgets($fd, 4096);
        goto frFFw;
        pj5vw:
        $this->_checkValid($this->img_type);
        goto AO7HU;
        htjfW:
    }
    /**
     * 设置图片生成路径
     *
     * @param    string    $dst_img   图片生成路径
     */
    function setDstImg($dst_img)
    {
        goto UgZW8;
        Macts:
        $last = array_pop($arr);
        goto AKC0X;
        AKC0X:
        $path = implode("\x2f", $arr);
        goto gRPqi;
        Kz1zj:
        $this->dst_img = $dst_img;
        goto C3JjU;
        UgZW8:
        $arr = explode("\57", $dst_img);
        goto Macts;
        gRPqi:
        $this->_mkdirs($path);
        goto Kz1zj;
        C3JjU:
    }
    /**
     * 设置图片的显示质量
     *
     * @param    string      $n    质量
     */
    function setImgDisplayQuality($n)
    {
        $this->img_display_quality = (int) $n;
    }
    /**
     * 设置图片的生成质量
     *
     * @param    string      $n    质量
     */
    function setImgCreateQuality($n)
    {
        $this->img_create_quality = (int) $n;
    }
    /**
     * 设置文字水印
     *
     * @param    string     $word    水印文字
     * @param    integer    $font    水印字体
     * @param    string     $color   水印字体颜色
     */
    function setMaskWord($word)
    {
        $this->mask_word = $word;
    }
    /**
     * 设置字体颜色
     *
     * @param    string     $color    字体颜色
     */
    function setMaskFontColor($color = "\43\x66\x66\146\x66\x66\x66")
    {
        $this->mask_font_color = $color;
    }
    /**
     * 设置水印字体
     *
     * @param    string|integer    $font    字体
     */
    function setMaskFont($font = 2)
    {
        goto ztXtb;
        ztXtb:
        if (!(!is_numeric($font) && !file_exists($font))) {
            goto PRx6h;
        }
        goto BummA;
        sdSkb:
        $this->font = $font;
        goto PNaNk;
        eo6Cr:
        PRx6h:
        goto sdSkb;
        BummA:
        throw new Exception("\xe5\255\x97\xe4\275\x93\346\x96\207\xe4\xbb\266\xe4\270\x8d\xe5\255\x98\xe5\234\xa8", 400);
        goto eo6Cr;
        PNaNk:
    }
    /**
     * 设置文字字体大小,仅对truetype字体有效
     */
    function setMaskFontSize($size = "\61\62")
    {
        $this->font_size = $size;
    }
    /**
     * 设置图片水印
     *
     * @param    string    $img     水印图片源
     */
    function setMaskImg($img)
    {
        $this->mask_img = $img;
    }
    /**
     * 设置水印横向偏移
     *
     * @param    integer     $x    横向偏移量
     */
    function setMaskOffsetX($x)
    {
        $this->mask_offset_x = (int) $x;
    }
    /**
     * 设置水印纵向偏移
     *
     * @param    integer     $y    纵向偏移量
     */
    function setMaskOffsetY($y)
    {
        $this->mask_offset_y = (int) $y;
    }
    /**
     * 指定水印位置
     *
     * @param    integer     $position    位置,1:左上,2:左下,3:右上,0/4:右下
     */
    function setMaskPosition($position = 0)
    {
        $this->mask_position = (int) $position;
    }
    /**
     * 设置图片合并程度
     *
     * @param    integer     $n    合并程度
     */
    function setMaskImgPct($n)
    {
        $this->mask_img_pct = (int) $n;
    }
    /**
     * 设置文字合并程度
     *
     * @param    integer     $n    合并程度
     */
    function setMaskTxtPct($n)
    {
        $this->mask_txt_pct = (int) $n;
    }
    /**
     * 设置缩略图边框
     *
     * @param    (类型)     (参数名)    (描述)
     */
    function setDstImgBorder($size = 1, $color = "\x23\60\60\x30\60\x30\60")
    {
        $this->img_border_size = (int) $size;
        $this->img_border_color = $color;
    }
    /**
     * 水平翻转
     */
    function flipH()
    {
        $this->_flip_x++;
    }
    /**
     * 垂直翻转
     */
    function flipV()
    {
        $this->_flip_y++;
    }
    /**
     * 设置剪切类型
     *
     * @param    (类型)     (参数名)    (描述)
     */
    function setCutType($type)
    {
        $this->cut_type = (int) $type;
    }
    /**
     * 设置图片剪切
     *
     * @param    integer     $width    矩形剪切
     */
    function setRectangleCut($width, $height)
    {
        $this->fill_w = (int) $width;
        $this->fill_h = (int) $height;
    }
    /**
     * 设置源图剪切起始坐标点
     *
     * @param    (类型)     (参数名)    (描述)
     */
    function setSrcCutPosition($x, $y)
    {
        $this->src_x = (int) $x;
        $this->src_y = (int) $y;
    }
    /**
     * 创建图片,主函数
     * @param    integer    $a     当缺少第二个参数时，此参数将用作百分比，
     *                             否则作为宽度值
     * @param    integer    $b     图片缩放后的高度
     */
    function createImg($a, $b = null)
    {
        goto ytIYB;
        WJJeS:
        $this->_createMask();
        goto tUoTI;
        tUoTI:
        goto vOwMW;
        goto udxhe;
        ytIYB:
        $num = func_num_args();
        goto JZ0oi;
        ZHqwD:
        if (!($r < 1)) {
            goto IVKSd;
        }
        goto XB7md;
        gzdfy:
        $this->img_scale = $r;
        goto lYFem;
        UHWPv:
        vOwMW:
        goto D4GQN;
        P733b:
        if (!(0 == $h)) {
            goto awPgF;
        }
        goto FUn1V;
        iKDJd:
        $this->_setNewImgSize($w, $h);
        goto x5px3;
        x5px3:
        CkRzZ:
        goto kYhz7;
        UgOP2:
        if (!($this->_flip_y % 2 != 0)) {
            goto mVP8S;
        }
        goto f24Fh;
        Q9dtp:
        if (!(0 == $w)) {
            goto LFdco;
        }
        goto a4pHp;
        kYhz7:
        if (!($this->_flip_x % 2 != 0)) {
            goto FLg10;
        }
        goto h92a5;
        D4GQN:
        $this->_output();
        goto aDac5;
        lc4wI:
        goto zDx6g;
        goto jRcmi;
        vXBl1:
        IVKSd:
        goto gzdfy;
        Ow7Ek:
        if (!(2 == $num)) {
            goto CkRzZ;
        }
        goto Eqz8g;
        aDac5:
        if (imagedestroy($this->h_src) && imagedestroy($this->h_dst)) {
            goto VI2Yv;
        }
        goto Z1wT_;
        J74Gt:
        zDx6g:
        goto mQ7lI;
        Oz4aL:
        awPgF:
        goto iKDJd;
        lYFem:
        $this->_setNewImgSize($r);
        goto u7aZq;
        udxhe:
        NPsS5:
        goto T3Qwa;
        wNuiQ:
        mVP8S:
        goto BJvgR;
        T3Qwa:
        $this->_cutImg();
        goto UHWPv;
        Na8r8:
        LFdco:
        goto P733b;
        h92a5:
        $this->_flipH($this->h_src);
        goto Hp5AR;
        EtDAB:
        $r = (int) $a;
        goto ZHqwD;
        a4pHp:
        throw new Exception("\xe7\233\xae\xe6\240\207\xe5\xae\xbd\345\272\246\xe4\270\x8d\350\x83\275\xe4\270\272\x30");
        goto Na8r8;
        BJvgR:
        if ($this->only_cut) {
            goto NPsS5;
        }
        goto WJJeS;
        f24Fh:
        $this->_flipV($this->h_src);
        goto wNuiQ;
        Hp5AR:
        FLg10:
        goto UgOP2;
        FUn1V:
        throw new Exception("\xe7\x9b\xae\346\240\207\xe9\xab\230\xe5\272\xa6\xe4\270\x8d\350\203\275\xe4\xb8\272\60");
        goto Oz4aL;
        jRcmi:
        VI2Yv:
        goto gyB8t;
        Eqz8g:
        $w = (int) $a;
        goto vbVDU;
        vbVDU:
        $h = (int) $b;
        goto Q9dtp;
        XB7md:
        throw new Exception("\345\x9b\xbe\xe7\211\x87\xe7\274\251\xe6\224\276\346\257\x94\xe4\xbe\213\xe4\xb8\215\345\276\x97\xe5\xb0\217\344\xba\x8e\61");
        goto vXBl1;
        JZ0oi:
        if (!(1 == $num)) {
            goto YAy27;
        }
        goto EtDAB;
        Z1wT_:
        return false;
        goto lc4wI;
        u7aZq:
        YAy27:
        goto Ow7Ek;
        gyB8t:
        return true;
        goto J74Gt;
        mQ7lI:
    }
    function _cutImg()
    {
        goto GywDx;
        pa_Uu:
        imagecopyresampled($this->h_dst, $this->h_src, $this->start_x, $this->start_y, $this->src_x, $this->src_y, $this->fill_w, $this->fill_h, $this->copy_w, $this->copy_h);
        goto J0TMn;
        sp3l7:
        $white = ImageColorAllocate($this->h_dst, 255, 255, 255);
        goto o0pkh;
        o0pkh:
        imagefilledrectangle($this->h_dst, 0, 0, $this->dst_w, $this->dst_h, $white);
        goto pa_Uu;
        GywDx:
        $this->h_dst = imagecreatetruecolor($this->dst_w, $this->dst_h);
        goto sp3l7;
        J0TMn:
    }
    /**
     * 生成水印,调用了生成水印文字和水印图片两个方法
     */
    function _createMask()
    {
        goto DYVvu;
        K6Ubm:
        $this->_drawBorder();
        goto rZTAu;
        xajLr:
        if ($this->_isInviteCodeFull()) {
            goto CpHD_;
        }
        goto thhLq;
        l4llc:
        jFHTK:
        goto GY_CI;
        McRnp:
        if (!$this->nickname) {
            goto uaSQZ;
        }
        goto Mvi8d;
        smPgD:
        $this->_createAvatarMaskImg($this->h_dst);
        goto MqS2U;
        h83G7:
        imagefilledrectangle($this->h_dst, 0, 0, $this->dst_w, $this->dst_h, $white);
        goto Z1LpA;
        VsaDA:
        CpHD_:
        goto LGDQa;
        dVADd:
        if ($firstAppend) {
            goto x0nHd;
        }
        goto WLyL0;
        pTjN0:
        b1Vmo:
        goto vs6vl;
        ptnlE:
        $white = ImageColorAllocate($this->h_dst, 255, 255, 255);
        goto ZuDGk;
        wNccB:
        $this->h_dst = imagecreatetruecolor($this->dst_w, $this->dst_h);
        goto ptnlE;
        MA8Pe:
        $this->_createInviteCodeMaskWord($this->h_dst);
        goto nNPJY;
        DV8oM:
        YXUdy:
        goto BLDKQ;
        Vy2t2:
        if ($firstAppend) {
            goto Rpcd4;
        }
        goto qO3Y0;
        qO3Y0:
        $this->_createAvatarMaskImg($this->h_src);
        goto eyzvs;
        xt9Wc:
        m6HOh:
        goto DV8oM;
        bTxiW:
        goto z_xEC;
        goto ezXwW;
        Z1LpA:
        $this->_drawBorder();
        goto N4FZy;
        XEz6q:
        imagefilledrectangle($this->h_dst, 0, 0, $this->dst_w, $this->dst_h, $white);
        goto l0X6u;
        ALlhh:
        h_15e:
        goto xt9Wc;
        ZuDGk:
        imagefilledrectangle($this->h_dst, 0, 0, $this->dst_w, $this->dst_h, $white);
        goto XrOmV;
        RsUtD:
        $this->_createNicknameMaskWord($this->h_dst);
        goto YoWFL;
        gT9Gl:
        imagecopyresampled($this->h_dst, $this->h_src, $this->start_x, $this->start_y, $this->src_x, $this->src_y, $this->fill_w, $this->fill_h, $this->copy_w, $this->copy_h);
        goto MA8Pe;
        MqS2U:
        goto cFRTj;
        goto PjQnD;
        l0X6u:
        $this->_drawBorder();
        goto Vejja;
        Opzal:
        nIWcf:
        goto CWXo9;
        d_yWs:
        goto m6HOh;
        goto pTjN0;
        CWXo9:
        $firstAppend = true;
        goto urkjp;
        HQLD1:
        zRdon:
        goto wbRXp;
        rZTAu:
        imagecopyresampled($this->h_dst, $this->h_src, $this->start_x, $this->start_y, $this->src_x, $this->src_y, $this->fill_w, $this->fill_h, $this->copy_w, $this->copy_h);
        goto RsUtD;
        nNPJY:
        goto WX07o;
        goto LUSLU;
        YqvR2:
        goto eT0Xy;
        goto VsaDA;
        ezXwW:
        qjv_1:
        goto sLufr;
        HWT51:
        $this->_createQrcodeMaskImg($this->h_dst);
        goto bTxiW;
        YoWFL:
        goto nIWcf;
        goto nhI3V;
        lhiPo:
        $white = ImageColorAllocate($this->h_dst, 255, 255, 255);
        goto h2BU0;
        Vejja:
        imagecopyresampled($this->h_dst, $this->h_src, $this->start_x, $this->start_y, $this->src_x, $this->src_y, $this->fill_w, $this->fill_h, $this->copy_w, $this->copy_h);
        goto smPgD;
        hD11t:
        WX07o:
        goto ylIFr;
        vs6vl:
        if ($firstAppend) {
            goto HvSeX;
        }
        goto JAW9R;
        fa1Du:
        goto zJzkH;
        goto hiDU0;
        WLyL0:
        $this->h_dst = imagecreatetruecolor($this->dst_w, $this->dst_h);
        goto P4qc8;
        qMG80:
        if (!$this->invite_code) {
            goto zRdon;
        }
        goto NjEx_;
        BLDKQ:
        if (!$this->avatar_img) {
            goto S6CVc;
        }
        goto HPXKJ;
        s73G0:
        imagefilledrectangle($this->h_dst, 0, 0, $this->dst_w, $this->dst_h, $white);
        goto QAazg;
        oooDX:
        goto h_15e;
        goto BQBpi;
        rGO2l:
        $this->_createQrcodeMaskImg($this->h_src);
        goto ALlhh;
        UY_nT:
        $this->h_dst = imagecreatetruecolor($this->dst_w, $this->dst_h);
        goto R7hYF;
        QmCX0:
        $this->_loadQrcodeMaskImg();
        goto bSGr5;
        NjEx_:
        $this->_setInviteCodeInfo();
        goto xajLr;
        Mvi8d:
        $this->_setNicknameInfo();
        goto oRgdJ;
        sLufr:
        $this->_createQrcodeMaskImg($this->h_dst);
        goto Ahtjh;
        DYVvu:
        $firstAppend = false;
        goto McRnp;
        Q53A1:
        imagecopyresampled($this->h_dst, $this->h_src, $this->start_x, $this->start_y, $this->src_x, $this->src_y, $this->fill_w, $this->fill_h, $this->copy_w, $this->copy_h);
        goto HWT51;
        PjQnD:
        x0nHd:
        goto Nbv92;
        LGDQa:
        throw new Exception("\xe9\202\200\350\257\267\347\xa0\x81\346\xb0\xb4\345\215\xb0\346\226\x87\xe5\xad\227\xe8\277\x87\345\xa4\xa7", 400);
        goto KfKCd;
        oRgdJ:
        if ($this->_isNicknameFull()) {
            goto q_p13;
        }
        goto U4jhn;
        JAW9R:
        $this->_createQrcodeMaskImg($this->h_src);
        goto wNccB;
        R7hYF:
        $white = ImageColorAllocate($this->h_dst, 255, 255, 255);
        goto s73G0;
        bSGr5:
        if ($this->_isQrcodeFull()) {
            goto b1Vmo;
        }
        goto egz5W;
        wbRXp:
        if (!$this->qrcode_img) {
            goto YXUdy;
        }
        goto QmCX0;
        QAazg:
        $this->_drawBorder();
        goto gT9Gl;
        Nbv92:
        $this->_createAvatarMaskImg($this->h_dst);
        goto uLHsK;
        sN55P:
        $this->_drawBorder();
        goto Q53A1;
        VBCy3:
        $this->_createInviteCodeMaskWord($this->h_dst);
        goto hD11t;
        Ahtjh:
        z_xEC:
        goto d_yWs;
        eyzvs:
        $this->h_dst = imagecreatetruecolor($this->dst_w, $this->dst_h);
        goto xBpG7;
        uLHsK:
        cFRTj:
        goto fa1Du;
        U4jhn:
        $this->h_dst = imagecreatetruecolor($this->dst_w, $this->dst_h);
        goto RZ3S0;
        BQBpi:
        HvSeX:
        goto rGO2l;
        rCUy4:
        $this->_createAvatarMaskImg($this->h_src);
        goto l4llc;
        XrOmV:
        imagecopyresampled($this->h_dst, $this->h_src, $this->start_x, $this->start_y, $this->src_x, $this->src_y, $this->fill_w, $this->start_y, $this->copy_w, $this->copy_h);
        goto oooDX;
        hiDU0:
        Jxinv:
        goto Vy2t2;
        Btc9O:
        S6CVc:
        goto x1oni;
        KtNMo:
        $this->h_dst = imagecreatetruecolor($this->dst_w, $this->dst_h);
        goto lhiPo;
        h5wXI:
        imagefilledrectangle($this->h_dst, 0, 0, $this->dst_w, $this->dst_h, $white);
        goto K6Ubm;
        RZ3S0:
        $white = ImageColorAllocate($this->h_dst, 255, 255, 255);
        goto h5wXI;
        nhI3V:
        q_p13:
        goto C7_lb;
        FRl3H:
        goto jFHTK;
        goto bjdNN;
        HPXKJ:
        $this->_loadAvatarMaskImg();
        goto V7EIk;
        LUSLU:
        WpFJ8:
        goto VBCy3;
        urkjp:
        uaSQZ:
        goto qMG80;
        P4qc8:
        $white = ImageColorAllocate($this->h_dst, 255, 255, 255);
        goto XEz6q;
        GY_CI:
        zJzkH:
        goto Btc9O;
        V7EIk:
        if ($this->_isAvatarFull()) {
            goto Jxinv;
        }
        goto dVADd;
        C7_lb:
        throw new Exception("\346\230\265\347\247\260\xe6\xb0\xb4\345\x8d\xb0\xe6\226\207\xe5\255\227\xe8\xbf\x87\xe5\xa4\247", 400);
        goto Opzal;
        thhLq:
        if ($firstAppend) {
            goto WpFJ8;
        }
        goto UY_nT;
        KfKCd:
        eT0Xy:
        goto HQLD1;
        ylIFr:
        $firstAppend = true;
        goto YqvR2;
        bjdNN:
        Rpcd4:
        goto rCUy4;
        h2BU0:
        imagefilledrectangle($this->h_dst, 0, 0, $this->dst_w, $this->dst_h, $white);
        goto sN55P;
        xBpG7:
        $white = ImageColorAllocate($this->h_dst, 255, 255, 255);
        goto h83G7;
        N4FZy:
        imagecopyresampled($this->h_dst, $this->h_src, $this->start_x, $this->start_y, $this->src_x, $this->src_y, $this->fill_w, $this->start_y, $this->copy_w, $this->copy_h);
        goto FRl3H;
        egz5W:
        if ($firstAppend) {
            goto qjv_1;
        }
        goto KtNMo;
        x1oni:
    }
    function thumb($filename, $width = 200, $height = 200)
    {
        goto RbrKH;
        fEhjX:
        $image_p = imagecreatetruecolor($width, $height);
        goto PUnvW;
        ne5ug:
        imagejpeg($image_p, $filename);
        goto oBdc5;
        ev2pF:
        goto Tcg18;
        goto sLinI;
        Q3rkU:
        $width = $height / $height_orig * $width_orig;
        goto vfRB2;
        PUnvW:
        $image = imagecreatefromjpeg($filename);
        goto Gm967;
        vfRB2:
        Tcg18:
        goto fEhjX;
        Gm967:
        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
        goto ne5ug;
        sr3Wi:
        imagedestroy($image);
        goto N1giV;
        XO87S:
        $height = $width / $width_orig * $height_orig;
        goto ev2pF;
        JfAE1:
        if ($width && $width_orig < $height_orig) {
            goto HntW7;
        }
        goto XO87S;
        RbrKH:
        list($width_orig, $height_orig) = getimagesize($filename);
        goto JfAE1;
        oBdc5:
        imagedestroy($image_p);
        goto sr3Wi;
        sLinI:
        HntW7:
        goto Q3rkU;
        N1giV:
    }
    /**
     * 画边框
     */
    function _drawBorder()
    {
        goto C46r1;
        z6EyR:
        irGHj:
        goto CzEGu;
        upbEU:
        $color = ImageColorAllocate($this->h_src, $c[0], $c[1], $c[2]);
        goto tGsh9;
        C46r1:
        if (empty($this->img_border_size)) {
            goto irGHj;
        }
        goto rYxk6;
        rYxk6:
        $c = $this->_parseColor($this->img_border_color);
        goto upbEU;
        tGsh9:
        imagefilledrectangle($this->h_dst, 0, 0, $this->dst_w, $this->dst_h, $color);
        goto z6EyR;
        CzEGu:
    }
    /**
     * 生成水印文字
     */
    function _createMaskWord($src)
    {
        goto IS30P;
        smNfG:
        mnOBR:
        goto qFz7t;
        IOOcF:
        $color = imagecolorallocatealpha($src, $c[0], $c[1], $c[2], $this->mask_txt_pct);
        goto TR7Yl;
        ma92S:
        imagestring($src, $this->font, $this->mask_pos_x, $this->mask_pos_y, $this->mask_word, $color);
        goto smNfG;
        d4QRl:
        NLu5B:
        goto ma92S;
        IS30P:
        $this->_countMaskPos();
        goto xnQjz;
        TR7Yl:
        if (is_numeric($this->font)) {
            goto NLu5B;
        }
        goto d_8Zg;
        xnQjz:
        $this->_checkMaskValid();
        goto o1Jc4;
        d_8Zg:
        imagettftext($src, $this->font_size, 0, $this->mask_pos_x, $this->mask_pos_y, $color, $this->font, $this->mask_word);
        goto E_gli;
        o1Jc4:
        $c = $this->_parseColor($this->mask_font_color);
        goto IOOcF;
        E_gli:
        goto mnOBR;
        goto d4QRl;
        qFz7t:
    }
    function _createNicknameMaskWord($src)
    {
        goto cSrpc;
        R7CJx:
        goto c8XQ2;
        goto mw7r8;
        z2xwq:
        imagestring($src, $this->nickname_font, $this->nickname_pos_x, $this->nickname_pos_y, $this->nickname, $color);
        goto TzW_Z;
        fHbbM:
        if (is_numeric($this->nickname_font)) {
            goto R8eCc;
        }
        goto ZYjPX;
        mw7r8:
        R8eCc:
        goto z2xwq;
        TzW_Z:
        c8XQ2:
        goto J9Bcn;
        DB5c0:
        $this->_checkNicknameMaskValid();
        goto PCNjv;
        cSrpc:
        $this->_countNicknameMaskPos();
        goto DB5c0;
        ZYjPX:
        imagettftext($src, $this->nickname_font_size, 0, $this->nickname_pos_x, $this->nickname_pos_y, $color, $this->nickname_font, $this->nickname);
        goto R7CJx;
        agYtm:
        $color = imagecolorallocatealpha($src, $c[0], $c[1], $c[2], $this->mask_txt_pct);
        goto fHbbM;
        PCNjv:
        $c = $this->_parseColor($this->nickname_font_color);
        goto agYtm;
        J9Bcn:
    }
    function _createInviteCodeMaskWord($src)
    {
        goto Ld6lB;
        Ew5Bh:
        ILIWo:
        goto lzdr6;
        KKG1D:
        goto Ynf7q;
        goto Ew5Bh;
        m74tz:
        imagettftext($src, $this->invite_code_font_size, 0, $this->invite_code_pos_x, $this->invite_code_pos_y, $color, $this->invite_code_font, $this->invite_code);
        goto KKG1D;
        DA3uW:
        $c = $this->_parseColor($this->invite_code_font_color);
        goto jmLZ1;
        u6q2E:
        Ynf7q:
        goto TpWOo;
        jmLZ1:
        $color = imagecolorallocatealpha($src, $c[0], $c[1], $c[2], $this->mask_txt_pct);
        goto Bda7y;
        y0N0z:
        $this->_checkInviteCodeMaskValid();
        goto DA3uW;
        Ld6lB:
        $this->_countInviteCodeMaskPos();
        goto y0N0z;
        lzdr6:
        imagestring($src, $this->invite_code_font, $this->invite_code_pos_x, $this->invite_code_pos_y, $this->invite_code, $color);
        goto u6q2E;
        Bda7y:
        if (is_numeric($this->invite_code_font)) {
            goto ILIWo;
        }
        goto m74tz;
        TpWOo:
    }
    function _createMaskWord2($src)
    {
        goto OVHPU;
        phtBP:
        imagestring($src, $this->font, $this->mask_pos_x, $this->mask_pos_y, $this->mask_word, $color);
        goto hUHCC;
        BTEBQ:
        $this->_checkMaskValid();
        goto cU4AJ;
        A5ihd:
        $color = imagecolorallocatealpha($src, $c[0], $c[1], $c[2], $this->mask_txt_pct);
        goto OLpof;
        bBZ37:
        vlwFs:
        goto phtBP;
        OLpof:
        if (is_numeric($this->font)) {
            goto vlwFs;
        }
        goto T0wh4;
        cU4AJ:
        $c = $this->_parseColor($this->mask_font_color);
        goto A5ihd;
        Ghrjr:
        goto S39Hg;
        goto bBZ37;
        lN8KZ:
        $this->mask_position = 2;
        goto ohdqx;
        ohdqx:
        $this->_countMaskPos();
        goto BTEBQ;
        T0wh4:
        imagettftext($src, $this->font_size, 0, $this->mask_pos_x, $this->mask_pos_y, $color, $this->font, $this->mask_word);
        goto Ghrjr;
        OVHPU:
        $this->mask_pos_x = 100;
        goto UQTv0;
        ywqoo:
        $this->mask_word = "\x61\x64\155\151\x6e";
        goto lN8KZ;
        UQTv0:
        $this->mask_pos_y = 200;
        goto ywqoo;
        hUHCC:
        S39Hg:
        goto xpW_N;
        xpW_N:
    }
    /**
     * 生成水印图
     */
    function _createMaskImg($src)
    {
        goto MuoE2;
        MuoE2:
        $this->_countMaskPos();
        goto gVzLN;
        YkXp9:
        imagedestroy($this->h_mask);
        goto x0gGd;
        gVzLN:
        $this->_checkMaskValid();
        goto jwMVq;
        jwMVq:
        imagecopymerge($src, $this->h_mask, $this->mask_pos_x, $this->mask_pos_y, 0, 0, $this->mask_w, $this->mask_h, $this->mask_img_pct);
        goto YkXp9;
        x0gGd:
    }
    function _createQrcodeMaskImg($src)
    {
        goto cpWoI;
        m0xrU:
        $this->_checkQrcodeMaskValid();
        goto QJsIW;
        cpWoI:
        $this->_countQrcodeMaskPos();
        goto m0xrU;
        bml44:
        imagedestroy($this->h_mask);
        goto lhcXH;
        QJsIW:
        imagecopymerge($src, $this->h_mask, $this->qrcode_pos_x, $this->qrcode_pos_y, 0, 0, $this->qrcode_mask_w, $this->qrcode_mask_h, $this->mask_img_pct);
        goto bml44;
        lhcXH:
    }
    function _createAvatarMaskImg($src)
    {
        goto gKRpb;
        z4wDC:
        imagecopymerge($src, $this->h_mask, $this->avatar_pos_x, $this->avatar_pos_y, 0, 0, $this->avatar_mask_w, $this->avatar_mask_h, $this->mask_img_pct);
        goto pH4DN;
        gKRpb:
        $this->_countAvatarMaskPos();
        goto JJwuW;
        pH4DN:
        imagedestroy($this->h_mask);
        goto U1YRR;
        JJwuW:
        $this->_checkAvatarMaskValid();
        goto z4wDC;
        U1YRR:
    }
    /**
     * 加载水印图
     */
    function _loadMaskImg()
    {
        goto w22sJ;
        AWQ8t:
        $src .= fgets($fd, 4096);
        goto wlOjK;
        a4zDh:
        yBE58:
        goto a8hfS;
        w22sJ:
        $mask_type = $this->_getImgType($this->mask_img);
        goto Xyghw;
        ULJ5d:
        $src = '';
        goto Rp_T8;
        Rp_T8:
        if (function_exists("\146\151\x6c\145\x5f\147\145\x74\x5f\143\157\156\x74\x65\x6e\x74\x73")) {
            goto zgQB_;
        }
        goto TJsyc;
        aoJ0L:
        AvdX2:
        goto R3yGH;
        eBiwl:
        $this->h_mask = ImageCreateFromString($src);
        goto AXVuB;
        KzNwp:
        goto jFs9x;
        goto HyqfL;
        HyqfL:
        zgQB_:
        goto jVSKx;
        Xyghw:
        $this->_checkValid($mask_type);
        goto ULJ5d;
        aY57h:
        CIUUP:
        goto eBiwl;
        TJsyc:
        $handle = fopen($this->mask_img, "\162");
        goto a4zDh;
        kk2gA:
        $this->mask_h = $this->getImgHeight($this->h_mask);
        goto xvbvP;
        Fpsix:
        throw new Exception("\xe6\xb0\264\xe5\215\xb0\345\x9b\276\347\x89\207\344\xb8\xba\xe7\251\272", 400);
        goto aY57h;
        R3yGH:
        fclose($handle);
        goto KzNwp;
        cTSRg:
        jFs9x:
        goto DDiMS;
        a8hfS:
        if (feof($handle)) {
            goto AvdX2;
        }
        goto AWQ8t;
        AXVuB:
        $this->mask_w = $this->getImgWidth($this->h_mask);
        goto kk2gA;
        jVSKx:
        $src = file_get_contents($this->mask_img);
        goto cTSRg;
        wlOjK:
        goto yBE58;
        goto aoJ0L;
        DDiMS:
        if (!empty($this->mask_img)) {
            goto CIUUP;
        }
        goto Fpsix;
        xvbvP:
    }
    function _loadQrcodeMaskImg()
    {
        goto BisEY;
        xzxOX:
        if (feof($handle)) {
            goto XpLDY;
        }
        goto arGU1;
        q5khB:
        $this->qrcode_mask_h = $this->getImgHeight($this->h_mask);
        goto zOIpL;
        BisEY:
        $mask_type = $this->_getImgType($this->qrcode_img);
        goto d8SyK;
        NC3Yo:
        goto eEDnn;
        goto kLiCi;
        Oj8Zi:
        $src = file_get_contents($this->qrcode_img);
        goto RU5aB;
        wCp2b:
        fclose($handle);
        goto NC3Yo;
        eeA6F:
        MouFQ:
        goto xzxOX;
        kLiCi:
        NNLOd:
        goto Oj8Zi;
        GIdBT:
        XpLDY:
        goto wCp2b;
        WweuC:
        Ucvd9:
        goto njgVO;
        RU5aB:
        eEDnn:
        goto OLLlR;
        OLLlR:
        if (!empty($this->qrcode_img)) {
            goto Ucvd9;
        }
        goto A7XDb;
        d8SyK:
        $this->_checkValid($mask_type);
        goto HsiLX;
        njgVO:
        $this->h_mask = ImageCreateFromString($src);
        goto ltA1x;
        HsiLX:
        $src = '';
        goto vwIIW;
        ltA1x:
        $this->qrcode_mask_w = $this->getImgWidth($this->h_mask);
        goto q5khB;
        I1zD0:
        goto MouFQ;
        goto GIdBT;
        vwIIW:
        if (function_exists("\x66\x69\x6c\145\x5f\x67\x65\x74\137\143\157\x6e\164\x65\x6e\164\163")) {
            goto NNLOd;
        }
        goto MZLtj;
        A7XDb:
        throw new Exception("\xe6\260\xb4\345\215\260\xe5\233\276\347\211\x87\344\270\272\xe7\251\xba", 400);
        goto WweuC;
        arGU1:
        $src .= fgets($fd, 4096);
        goto I1zD0;
        MZLtj:
        $handle = fopen($this->qrcode_img, "\162");
        goto eeA6F;
        zOIpL:
    }
    function _loadAvatarMaskImg()
    {
        goto x90c8;
        q158j:
        fclose($handle);
        goto S9KQE;
        mIC96:
        $handle = fopen($this->avatar_img, "\162");
        goto ZXMR9;
        TVgVO:
        if (function_exists("\146\151\x6c\145\x5f\147\x65\x74\137\143\x6f\x6e\x74\x65\x6e\x74\163")) {
            goto efokx;
        }
        goto mIC96;
        pA15J:
        efokx:
        goto LsT7F;
        cqDlx:
        goto o987U;
        goto oRc_a;
        ZXMR9:
        o987U:
        goto DWBGq;
        cApFz:
        $this->avatar_mask_w = $this->getImgWidth($this->h_mask);
        goto KnZEO;
        bemqR:
        $src = '';
        goto TVgVO;
        ssnzF:
        cfEqk:
        goto NVw53;
        x90c8:
        $mask_type = $this->_getImgType($this->avatar_img);
        goto RgQ4k;
        S9KQE:
        goto cfEqk;
        goto pA15J;
        NVw53:
        if (!empty($this->avatar_img)) {
            goto lFcJh;
        }
        goto fe83I;
        fe83I:
        throw new Exception("\xe6\xb0\264\345\x8d\xb0\xe5\x9b\276\xe7\x89\207\344\270\xba\347\251\272", 400);
        goto fc7sJ;
        fc7sJ:
        lFcJh:
        goto pXbji;
        DWBGq:
        if (feof($handle)) {
            goto tWqte;
        }
        goto Xuru9;
        KnZEO:
        $this->avatar_mask_h = $this->getImgHeight($this->h_mask);
        goto eLraY;
        pXbji:
        $this->h_mask = ImageCreateFromString($src);
        goto cApFz;
        RgQ4k:
        $this->_checkValid($mask_type);
        goto bemqR;
        LsT7F:
        $src = file_get_contents($this->avatar_img);
        goto ssnzF;
        Xuru9:
        $src .= fgets($fd, 4096);
        goto cqDlx;
        oRc_a:
        tWqte:
        goto q158j;
        eLraY:
    }
    /**
     * 图片输出
     */
    function _output()
    {
        goto My4YG;
        IiVCh:
        if (function_exists($func_name)) {
            goto b21dH;
        }
        goto h7VJg;
        rwSd2:
        goto ecaDs;
        goto bbMbq;
        uBa9g:
        c4Od3:
        goto JMCeT;
        KCeqx:
        $ua = strtoupper($_SERVER["\110\124\x54\120\137\x55\123\x45\x52\137\x41\x47\x45\x4e\124"]);
        goto zjQZl;
        JMCeT:
        $func_name($this->h_dst, $this->dst_img, $this->img_display_quality);
        goto GYFW5;
        GYFW5:
        ecaDs:
        goto UElzQ;
        h7VJg:
        return false;
        goto rwSd2;
        My4YG:
        $img_type = $this->img_type;
        goto lN5Lg;
        e_aew:
        header("\x43\x6f\x6e\164\x65\x6e\164\55\164\x79\160\x65\72{$img_type}");
        goto Vavqc;
        lN5Lg:
        $func_name = $this->all_type[$img_type]["\x6f\165\164\x70\x75\x74"];
        goto IiVCh;
        zjQZl:
        if (preg_match("\x2f\x5e\x2e\x2a\x4d\123\x49\105\x2e\x2a\x5c\x29\44\57\x69", $ua)) {
            goto GukIf;
        }
        goto e_aew;
        bbMbq:
        b21dH:
        goto JhNUR;
        JhNUR:
        if (!isset($_SERVER["\110\x54\124\120\137\125\123\x45\122\x5f\101\107\105\x4e\124"])) {
            goto c4Od3;
        }
        goto KCeqx;
        Vavqc:
        GukIf:
        goto uBa9g;
        UElzQ:
    }
    /**
     * 分析颜色
     *
     * @param    string     $color    十六进制颜色
     */
    function _parseColor($color)
    {
        goto SJ_r9;
        DarjP:
        return $arr;
        goto C6LJh;
        SJ_r9:
        $arr = array();
        goto ADTYZ;
        uDtqA:
        PcPo6:
        goto DarjP;
        fhCHm:
        $arr[] = hexdec(substr($color, $ii, 2));
        goto i2Bcl;
        i2Bcl:
        $ii++;
        goto R4te_;
        ADTYZ:
        $ii = 1;
        goto QLE4x;
        j97vh:
        goto kdOs9;
        goto uDtqA;
        sxZ1V:
        if (!($ii < strlen($color))) {
            goto PcPo6;
        }
        goto fhCHm;
        IIteC:
        $ii++;
        goto j97vh;
        QLE4x:
        kdOs9:
        goto sxZ1V;
        R4te_:
        wle0A:
        goto IIteC;
        C6LJh:
    }
    /**
     * 计算出位置坐标
     */
    function _countMaskPos()
    {
        goto DbhD6;
        k6iJz:
        x9gkr:
        goto qdq35;
        Lo5hE:
        goto x9gkr;
        goto TUG_Y;
        H80Lc:
        r58VY:
        goto KQgMn;
        KWkoY:
        switch ($this->mask_position) {
            case 1:
                goto DtuKP;
                DtuKP:
                $this->mask_pos_x = $this->mask_offset_x + $this->img_border_size;
                goto BudHg;
                azJnf:
                goto JP6nj;
                goto KQDUP;
                BudHg:
                $this->mask_pos_y = $this->mask_offset_y + $this->img_border_size;
                goto azJnf;
                KQDUP:
            case 2:
                goto gB0kl;
                AYTie:
                $this->mask_pos_y = $this->dst_h - $this->mask_h - $this->mask_offset_y - $this->img_border_size;
                goto MVfd4;
                gB0kl:
                $this->mask_pos_x = $this->mask_offset_x + $this->img_border_size;
                goto AYTie;
                MVfd4:
                goto JP6nj;
                goto Xcy8z;
                Xcy8z:
            case 3:
                goto ea0Gl;
                ea0Gl:
                $this->mask_pos_x = $this->dst_w - $this->mask_w - $this->mask_offset_x - $this->img_border_size;
                goto eXM2L;
                eXM2L:
                $this->mask_pos_y = $this->mask_offset_y + $this->img_border_size;
                goto vQwoH;
                vQwoH:
                goto JP6nj;
                goto A_0B6;
                A_0B6:
            case 4:
                goto zAmRe;
                zAmRe:
                $this->mask_pos_x = $this->dst_w - $this->mask_w - $this->mask_offset_x - $this->img_border_size;
                goto VjBRX;
                Y9AFo:
                goto JP6nj;
                goto jmeJD;
                VjBRX:
                $this->mask_pos_y = $this->dst_h - $this->mask_h - $this->mask_offset_y - $this->img_border_size;
                goto Y9AFo;
                jmeJD:
            default:
                goto WCWW9;
                HJbPq:
                $this->mask_pos_y = $this->mask_offset_y + $this->img_border_size;
                goto X2q1T;
                X2q1T:
                goto JP6nj;
                goto NA3BG;
                WCWW9:
                $this->mask_pos_x = $this->mask_offset_x + $this->img_border_size;
                goto HJbPq;
                NA3BG:
        }
        goto O4qAm;
        TUG_Y:
        l5TGr:
        goto pugUY;
        KQgMn:
        XhUF9:
        goto k6iJz;
        jtp4d:
        JP6nj:
        goto Lo5hE;
        DbhD6:
        if ($this->_isFull()) {
            goto l5TGr;
        }
        goto KWkoY;
        pugUY:
        switch ($this->mask_position) {
            case 1:
                goto fttq4;
                fttq4:
                $this->mask_pos_x = $this->mask_offset_x + $this->img_border_size;
                goto wlCl3;
                hZzia:
                goto XhUF9;
                goto Zfbty;
                wlCl3:
                $this->mask_pos_y = $this->mask_offset_y + $this->img_border_size;
                goto hZzia;
                Zfbty:
            case 2:
                goto QrSS2;
                QrSS2:
                $this->mask_pos_x = $this->mask_offset_x + $this->img_border_size;
                goto qfHAM;
                fX2cK:
                goto XhUF9;
                goto KBhTD;
                qfHAM:
                $this->mask_pos_y = $this->src_h - $this->mask_h - $this->mask_offset_y;
                goto fX2cK;
                KBhTD:
            case 3:
                goto E1NM2;
                E1NM2:
                $this->mask_pos_x = $this->src_w - $this->mask_w - $this->mask_offset_x;
                goto GILTS;
                qbMwg:
                goto XhUF9;
                goto ocdCz;
                GILTS:
                $this->mask_pos_y = $this->mask_offset_y + $this->img_border_size;
                goto qbMwg;
                ocdCz:
            case 4:
                goto bfEJ0;
                bfEJ0:
                $this->mask_pos_x = $this->src_w - $this->mask_w - $this->mask_offset_x;
                goto c7_j2;
                c7_j2:
                $this->mask_pos_y = $this->src_h - $this->mask_h - $this->mask_offset_y;
                goto Ky2LG;
                Ky2LG:
                goto XhUF9;
                goto hup9p;
                hup9p:
            default:
                goto lacAS;
                BimK0:
                $this->mask_pos_y = $this->mask_offset_y + $this->img_border_size;
                goto Oyut8;
                lacAS:
                $this->mask_pos_x = $this->mask_offset_x + $this->img_border_size;
                goto BimK0;
                Oyut8:
                goto XhUF9;
                goto fqTkj;
                fqTkj:
        }
        goto H80Lc;
        O4qAm:
        WLLg7:
        goto jtp4d;
        qdq35:
    }
    function _countNicknameMaskPos()
    {
        goto a0bVw;
        UwbXS:
        KSqTU:
        goto ylWiJ;
        MPLiX:
        switch ($this->nickname_position) {
            case 1:
                goto za_tH;
                NZZZ1:
                $this->nickname_pos_y = $this->nickname_offset_y + $this->img_border_size;
                goto WTdgF;
                za_tH:
                $this->nickname_pos_x = $this->nickname_offset_x + $this->img_border_size;
                goto NZZZ1;
                WTdgF:
                goto zQk6k;
                goto L30MQ;
                L30MQ:
            case 2:
                goto GB7g0;
                s9wpq:
                $this->nickname_pos_y = $this->src_h - $this->nickname_mask_h - $this->nickname_offset_y;
                goto oj2kt;
                oj2kt:
                goto zQk6k;
                goto LJUXq;
                GB7g0:
                $this->nickname_pos_x = $this->nickname_offset_x + $this->img_border_size;
                goto s9wpq;
                LJUXq:
            case 3:
                goto dSKyd;
                y3fcO:
                $this->nickname_pos_y = $this->nickname_offset_y + $this->img_border_size;
                goto SoKGv;
                dSKyd:
                $this->nickname_pos_x = $this->src_w - $this->nickname_mask_w - $this->nickname_offset_x;
                goto y3fcO;
                SoKGv:
                goto zQk6k;
                goto UoY5v;
                UoY5v:
            case 4:
                goto pTQKe;
                pTQKe:
                $this->nickname_pos_x = $this->src_w - $this->nickname_mask_w - $this->nickname_offset_x;
                goto cySCd;
                cySCd:
                $this->nickname_pos_y = $this->src_h - $this->nickname_mask_h - $this->nickname_offset_y;
                goto Ajlmi;
                Ajlmi:
                goto zQk6k;
                goto nwkRe;
                nwkRe:
            default:
                goto FV97n;
                TgFSD:
                goto zQk6k;
                goto VL2Vd;
                FV97n:
                $this->nickname_pos_x = $this->nickname_offset_x + $this->img_border_size;
                goto B5xBs;
                B5xBs:
                $this->nickname_pos_y = $this->nickname_offset_y + $this->img_border_size;
                goto TgFSD;
                VL2Vd:
        }
        goto UwbXS;
        otdXA:
        Qfr7r:
        goto RHSG7;
        ylWiJ:
        zQk6k:
        goto mXY2j;
        ooC8r:
        switch ($this->nickname_position) {
            case 1:
                goto vAPvq;
                vAPvq:
                $this->nickname_pos_x = $this->nickname_offset_x + $this->img_border_size;
                goto OmFkF;
                OmFkF:
                $this->nickname_pos_y = $this->nickname_offset_y + $this->img_border_size;
                goto VkmMX;
                VkmMX:
                goto PIkU8;
                goto rL5Wp;
                rL5Wp:
            case 2:
                goto jjNuU;
                bzis7:
                $this->nickname_pos_y = $this->dst_h - $this->nickname_mask_h - $this->nickname_offset_y - $this->img_border_size;
                goto TEv2i;
                TEv2i:
                goto PIkU8;
                goto RjnXn;
                jjNuU:
                $this->nickname_pos_x = $this->nickname_offset_x + $this->img_border_size;
                goto bzis7;
                RjnXn:
            case 3:
                goto iMFGf;
                qCq6q:
                goto PIkU8;
                goto SY4kQ;
                iMFGf:
                $this->nickname_pos_x = $this->dst_w - $this->nickname_mask_w - $this->nickname_offset_x - $this->img_border_size;
                goto Yqpbc;
                Yqpbc:
                $this->nickname_pos_y = $this->nickname_offset_y + $this->img_border_size;
                goto qCq6q;
                SY4kQ:
            case 4:
                goto o53Q7;
                ZUcIB:
                goto PIkU8;
                goto s1GVG;
                o53Q7:
                $this->nickname_pos_x = $this->dst_w - $this->nickname_mask_w - $this->nickname_offset_x - $this->img_border_size;
                goto mc7rT;
                mc7rT:
                $this->nickname_pos_y = $this->dst_h - $this->nickname_mask_h - $this->nickname_offset_y - $this->img_border_size;
                goto ZUcIB;
                s1GVG:
            default:
                goto BP8gB;
                u6yad:
                goto PIkU8;
                goto dy2FZ;
                wXw83:
                $this->nickname_pos_y = $this->nickname_offset_y + $this->img_border_size;
                goto u6yad;
                BP8gB:
                $this->nickname_pos_x = $this->nickname_offset_x + $this->img_border_size;
                goto wXw83;
                dy2FZ:
        }
        goto otdXA;
        a0bVw:
        if ($this->_isNicknameFull()) {
            goto DUwgE;
        }
        goto ooC8r;
        YXnbN:
        goto xtDjL;
        goto W9ojo;
        W9ojo:
        DUwgE:
        goto MPLiX;
        RHSG7:
        PIkU8:
        goto YXnbN;
        mXY2j:
        xtDjL:
        goto dMEXI;
        dMEXI:
    }
    function _countInviteCodeMaskPos()
    {
        goto MCG_4;
        RmSR3:
        OqR6N:
        goto wUuH2;
        poqOb:
        PUzW3:
        goto bAt_7;
        ZjE1W:
        ljl2o:
        goto cPnkr;
        bAt_7:
        switch ($this->invite_code_position) {
            case 1:
                goto DrlzA;
                h4iUP:
                $this->invite_code_pos_y = $this->invite_code_offset_y + $this->img_border_size;
                goto AT423;
                DrlzA:
                $this->invite_code_pos_x = $this->invite_code_offset_x + $this->img_border_size;
                goto h4iUP;
                AT423:
                goto oS0Zi;
                goto AG90J;
                AG90J:
            case 2:
                goto fZKda;
                HKVeg:
                $this->invite_code_pos_y = $this->src_h - $this->invite_code_mask_h - $this->invite_code_offset_y;
                goto IT7aY;
                IT7aY:
                goto oS0Zi;
                goto Y4XxZ;
                fZKda:
                $this->invite_code_pos_x = $this->invite_code_offset_x + $this->img_border_size;
                goto HKVeg;
                Y4XxZ:
            case 3:
                goto iEvRS;
                e6gY1:
                $this->invite_code_pos_y = $this->invite_code_offset_y + $this->img_border_size;
                goto Go2wB;
                iEvRS:
                $this->invite_code_pos_x = $this->src_w - $this->invite_code_mask_w - $this->invite_code_offset_x;
                goto e6gY1;
                Go2wB:
                goto oS0Zi;
                goto I5MwJ;
                I5MwJ:
            case 4:
                goto SwHG2;
                eAWwB:
                goto oS0Zi;
                goto vqiej;
                SwHG2:
                $this->invite_code_pos_x = $this->src_w - $this->invite_code_mask_w - $this->invite_code_offset_x;
                goto EENbm;
                EENbm:
                $this->invite_code_pos_y = $this->src_h - $this->invite_code_mask_h - $this->invite_code_offset_y;
                goto eAWwB;
                vqiej:
            default:
                goto V_XMZ;
                SadoU:
                $this->invite_code_pos_y = $this->invite_code_offset_y + $this->img_border_size;
                goto CiAKm;
                V_XMZ:
                $this->invite_code_pos_x = $this->invite_code_offset_x + $this->img_border_size;
                goto SadoU;
                CiAKm:
                goto oS0Zi;
                goto to9ZX;
                to9ZX:
        }
        goto RmSR3;
        MCG_4:
        if ($this->_isInviteCodeFull()) {
            goto PUzW3;
        }
        goto vAzO3;
        ZPK0g:
        OoRi3:
        goto VZnRo;
        cRrjs:
        ejItw:
        goto ZjE1W;
        vAzO3:
        switch ($this->invite_code_position) {
            case 1:
                goto fCMYE;
                mtwyw:
                $this->invite_code_pos_y = $this->invite_code_offset_y + $this->img_border_size;
                goto crO3W;
                crO3W:
                goto ljl2o;
                goto ncGRE;
                fCMYE:
                $this->invite_code_pos_x = $this->invite_code_offset_x + $this->img_border_size;
                goto mtwyw;
                ncGRE:
            case 2:
                goto FAEmP;
                FAEmP:
                $this->invite_code_pos_x = $this->invite_code_offset_x + $this->img_border_size;
                goto vFPeK;
                yxDWz:
                goto ljl2o;
                goto yP5n6;
                vFPeK:
                $this->invite_code_pos_y = $this->dst_h - $this->invite_code_mask_h - $this->invite_code_offset_y - $this->img_border_size;
                goto yxDWz;
                yP5n6:
            case 3:
                goto DYhOa;
                uzhga:
                goto ljl2o;
                goto xzha3;
                x4EXk:
                $this->invite_code_pos_y = $this->invite_code_offset_y + $this->img_border_size;
                goto uzhga;
                DYhOa:
                $this->invite_code_pos_x = $this->dst_w - $this->invite_code_mask_w - $this->invite_code_offset_x - $this->img_border_size;
                goto x4EXk;
                xzha3:
            case 4:
                goto xdlUz;
                wKu00:
                $this->invite_code_pos_y = $this->dst_h - $this->invite_code_mask_h - $this->invite_code_offset_y - $this->img_border_size;
                goto TAzWq;
                TAzWq:
                goto ljl2o;
                goto CusHy;
                xdlUz:
                $this->invite_code_pos_x = $this->dst_w - $this->invite_code_mask_w - $this->invite_code_offset_x - $this->img_border_size;
                goto wKu00;
                CusHy:
            default:
                goto APRet;
                VHGKu:
                goto ljl2o;
                goto NzIpk;
                APRet:
                $this->invite_code_pos_x = $this->invite_code_offset_x + $this->img_border_size;
                goto qDUOO;
                qDUOO:
                $this->invite_code_pos_y = $this->invite_code_offset_y + $this->img_border_size;
                goto VHGKu;
                NzIpk:
        }
        goto cRrjs;
        cPnkr:
        goto OoRi3;
        goto poqOb;
        wUuH2:
        oS0Zi:
        goto ZPK0g;
        VZnRo:
    }
    function _countQrcodeMaskPos()
    {
        goto v6TvF;
        v6TvF:
        if ($this->_isQrcodeFull()) {
            goto gGNAa;
        }
        goto lHM_u;
        LHCWX:
        lAwc9:
        goto c1eoQ;
        QE083:
        switch ($this->qrcode_position) {
            case 1:
                goto kyhO1;
                o6CQl:
                goto lAwc9;
                goto M6q2u;
                ir2zz:
                $this->qrcode_pos_y = $this->qrcode_offset_y + $this->img_border_size;
                goto o6CQl;
                kyhO1:
                $this->qrcode_pos_x = $this->qrcode_offset_x + $this->img_border_size;
                goto ir2zz;
                M6q2u:
            case 2:
                goto PLJWf;
                am7BX:
                goto lAwc9;
                goto yQbIV;
                hEhVS:
                $this->qrcode_pos_y = $this->src_h - $this->qrcode_mask_h - $this->qrcode_offset_y;
                goto am7BX;
                PLJWf:
                $this->qrcode_pos_x = $this->qrcode_offset_x + $this->img_border_size;
                goto hEhVS;
                yQbIV:
            case 3:
                goto vbuB4;
                cohk7:
                $this->qrcode_pos_y = $this->qrcode_offset_y + $this->img_border_size;
                goto CE9t8;
                CE9t8:
                goto lAwc9;
                goto l4nVc;
                vbuB4:
                $this->qrcode_pos_x = $this->src_w - $this->qrcode_mask_w - $this->qrcode_offset_x;
                goto cohk7;
                l4nVc:
            case 4:
                goto bwfS5;
                cHI2A:
                goto lAwc9;
                goto rAKsn;
                zWLMn:
                $this->qrcode_pos_y = $this->src_h - $this->qrcode_mask_h - $this->qrcode_offset_y;
                goto cHI2A;
                bwfS5:
                $this->qrcode_pos_x = $this->src_w - $this->qrcode_mask_w - $this->qrcode_offset_x;
                goto zWLMn;
                rAKsn:
            default:
                goto Ve2bD;
                uRK5W:
                $this->qrcode_pos_y = $this->qrcode_offset_y + $this->img_border_size;
                goto JTTK7;
                Ve2bD:
                $this->qrcode_pos_x = $this->qrcode_offset_x + $this->img_border_size;
                goto uRK5W;
                JTTK7:
                goto lAwc9;
                goto RjAsR;
                RjAsR:
        }
        goto bZ79f;
        c1eoQ:
        YAIn4:
        goto QCWkm;
        lHM_u:
        switch ($this->qrcode_position) {
            case 1:
                goto jSYZd;
                Ace30:
                goto Rptgy;
                goto dgHuD;
                jSYZd:
                $this->qrcode_pos_x = $this->qrcode_offset_x + $this->img_border_size;
                goto MsfGh;
                MsfGh:
                $this->qrcode_pos_y = $this->qrcode_offset_y + $this->img_border_size;
                goto Ace30;
                dgHuD:
            case 2:
                goto uhHAq;
                nWXot:
                goto Rptgy;
                goto T2P1Y;
                nQbYj:
                $this->qrcode_pos_y = $this->dst_h - $this->qrcode_mask_h - $this->qrcode_offset_y - $this->img_border_size;
                goto nWXot;
                uhHAq:
                $this->qrcode_pos_x = $this->qrcode_offset_x + $this->img_border_size;
                goto nQbYj;
                T2P1Y:
            case 3:
                goto J8Wg9;
                J8Wg9:
                $this->qrcode_pos_x = $this->dst_w - $this->qrcode_mask_w - $this->qrcode_offset_x - $this->img_border_size;
                goto Fd243;
                nfa22:
                goto Rptgy;
                goto FP3ai;
                Fd243:
                $this->qrcode_pos_y = $this->qrcode_offset_y + $this->img_border_size;
                goto nfa22;
                FP3ai:
            case 4:
                goto rLDho;
                uSA_X:
                goto Rptgy;
                goto E534Q;
                AfdLV:
                $this->qrcode_pos_y = $this->dst_h - $this->qrcode_mask_h - $this->qrcode_offset_y - $this->img_border_size;
                goto uSA_X;
                rLDho:
                $this->qrcode_pos_x = $this->dst_w - $this->qrcode_mask_w - $this->qrcode_offset_x - $this->img_border_size;
                goto AfdLV;
                E534Q:
            default:
                goto eE1aK;
                eE1aK:
                $this->qrcode_pos_x = $this->qrcode_offset_x + $this->img_border_size;
                goto fSLwS;
                fSLwS:
                $this->qrcode_pos_y = $this->qrcode_offset_y + $this->img_border_size;
                goto N1q5L;
                N1q5L:
                goto Rptgy;
                goto fcseN;
                fcseN:
        }
        goto So2_P;
        bZ79f:
        N3gHm:
        goto LHCWX;
        l4mSK:
        Rptgy:
        goto Tyuvs;
        jztUR:
        gGNAa:
        goto QE083;
        Tyuvs:
        goto YAIn4;
        goto jztUR;
        So2_P:
        HY1cU:
        goto l4mSK;
        QCWkm:
    }
    function _countAvatarMaskPos()
    {
        goto O9Ppp;
        c9oUf:
        fq5Ms:
        goto kGioz;
        MWVLs:
        CyfC8:
        goto GEeLW;
        IFBKi:
        fK5fs:
        goto jHeSF;
        jHeSF:
        switch ($this->avatar_position) {
            case 1:
                goto bAysT;
                bAysT:
                $this->avatar_pos_x = $this->avatar_offset_x + $this->img_border_size;
                goto rd3PS;
                rd3PS:
                $this->avatar_pos_y = $this->avatar_offset_y + $this->img_border_size;
                goto MEkPW;
                MEkPW:
                goto CyfC8;
                goto E_mxU;
                E_mxU:
            case 2:
                goto Befue;
                DL8WK:
                goto CyfC8;
                goto uDwWw;
                H4o3a:
                $this->avatar_pos_y = $this->src_h - $this->avatar_mask_h - $this->avatar_offset_y;
                goto DL8WK;
                Befue:
                $this->avatar_pos_x = $this->avatar_offset_x + $this->img_border_size;
                goto H4o3a;
                uDwWw:
            case 3:
                goto nIrFW;
                fwV4J:
                goto CyfC8;
                goto sRLHV;
                iHer9:
                $this->avatar_pos_y = $this->avatar_offset_y + $this->img_border_size;
                goto fwV4J;
                nIrFW:
                $this->avatar_pos_x = $this->src_w - $this->avatar_mask_w - $this->avatar_offset_x;
                goto iHer9;
                sRLHV:
            case 4:
                goto cIJPH;
                L46yE:
                $this->avatar_pos_y = $this->src_h - $this->avatar_mask_h - $this->avatar_offset_y;
                goto OVSh5;
                cIJPH:
                $this->avatar_pos_x = $this->src_w - $this->avatar_mask_w - $this->avatar_offset_x;
                goto L46yE;
                OVSh5:
                goto CyfC8;
                goto XtHWb;
                XtHWb:
            default:
                goto OUoUU;
                nyu3W:
                $this->avatar_pos_y = $this->avatar_offset_y + $this->img_border_size;
                goto kpfW5;
                kpfW5:
                goto CyfC8;
                goto k5_Ad;
                OUoUU:
                $this->avatar_pos_x = $this->avatar_offset_x + $this->img_border_size;
                goto nyu3W;
                k5_Ad:
        }
        goto ZXSj9;
        ZXSj9:
        E3332:
        goto MWVLs;
        GEeLW:
        i4PK0:
        goto kraZE;
        nnLUp:
        b2xjy:
        goto c9oUf;
        O9Ppp:
        if ($this->_isAvatarFull()) {
            goto fK5fs;
        }
        goto L0N7O;
        L0N7O:
        switch ($this->avatar_position) {
            case 1:
                goto o3tOJ;
                pEHvq:
                $this->avatar_pos_y = $this->avatar_offset_y + $this->img_border_size;
                goto DCjAr;
                o3tOJ:
                $this->avatar_pos_x = $this->avatar_offset_x + $this->img_border_size;
                goto pEHvq;
                DCjAr:
                goto fq5Ms;
                goto m1_7c;
                m1_7c:
            case 2:
                goto I8fMu;
                I8fMu:
                $this->avatar_pos_x = $this->avatar_offset_x + $this->img_border_size;
                goto AXsHS;
                TprLp:
                goto fq5Ms;
                goto hYuu9;
                AXsHS:
                $this->avatar_pos_y = $this->dst_h - $this->avatar_mask_h - $this->avatar_offset_y - $this->img_border_size;
                goto TprLp;
                hYuu9:
            case 3:
                goto ic4AD;
                ic4AD:
                $this->avatar_pos_x = $this->dst_w - $this->avatar_mask_w - $this->avatar_offset_x - $this->img_border_size;
                goto FjJcW;
                YAxfV:
                goto fq5Ms;
                goto wqA0F;
                FjJcW:
                $this->avatar_pos_y = $this->avatar_offset_y + $this->img_border_size;
                goto YAxfV;
                wqA0F:
            case 4:
                goto r0L4j;
                r0L4j:
                $this->avatar_pos_x = $this->dst_w - $this->avatar_mask_w - $this->avatar_offset_x - $this->img_border_size;
                goto G5_X3;
                G5_X3:
                $this->avatar_pos_y = $this->dst_h - $this->avatar_mask_h - $this->avatar_offset_y - $this->img_border_size;
                goto o3ThX;
                o3ThX:
                goto fq5Ms;
                goto SWnYX;
                SWnYX:
            default:
                goto XXW7z;
                XXW7z:
                $this->avatar_pos_x = $this->avatar_offset_x + $this->img_border_size;
                goto xO4_K;
                znZd1:
                goto fq5Ms;
                goto FLDd9;
                xO4_K:
                $this->avatar_pos_y = $this->avatar_offset_y + $this->img_border_size;
                goto znZd1;
                FLDd9:
        }
        goto nnLUp;
        kGioz:
        goto i4PK0;
        goto IFBKi;
        kraZE:
    }
    /**
     * 设置字体信息
     */
    function _setFontInfo()
    {
        goto d0XXw;
        WMA0c:
        goto figB3;
        goto jhGRA;
        gyEoT:
        $this->mask_w = $this->font_w * $word_length;
        goto Hz6FR;
        ZzTkB:
        $this->font_h = imagefontheight($this->font);
        goto uT46M;
        uT46M:
        $word_length = strlen($this->mask_word);
        goto gyEoT;
        jZlcG:
        $this->mask_h = abs($arr[7] - $arr[1]);
        goto WMA0c;
        jhGRA:
        AWlcG:
        goto uMHID;
        Hz6FR:
        $this->mask_h = $this->font_h;
        goto dOr8x;
        gHm8s:
        $this->mask_w = abs($arr[0] - $arr[2]);
        goto jZlcG;
        dOr8x:
        figB3:
        goto yb1X3;
        uMHID:
        $this->font_w = imagefontwidth($this->font);
        goto ZzTkB;
        d0XXw:
        if (is_numeric($this->font)) {
            goto AWlcG;
        }
        goto EyWxa;
        EyWxa:
        $arr = imagettfbbox($this->font_size, 0, $this->font, $this->mask_word);
        goto gHm8s;
        yb1X3:
    }
    function _setNicknameInfo()
    {
        goto LU3Mm;
        eZAHy:
        $this->nickname_mask_w = $this->nickname_font_w * $word_length;
        goto kyzpr;
        zRnTM:
        $this->nickname_mask_w = abs($arr[0] - $arr[2]);
        goto L3UUN;
        p7ztp:
        $this->nickname_font_w = imagefontwidth($this->nickname_font);
        goto IBeHK;
        knQ3V:
        lN0Ut:
        goto p7ztp;
        FOsRk:
        $word_length = strlen($this->nickname);
        goto eZAHy;
        hOxKW:
        $arr = imagettfbbox($this->nickname_font_size, 0, $this->nickname_font, $this->nickname);
        goto zRnTM;
        kvFnP:
        BaMzF:
        goto iD5qG;
        c6N1h:
        goto BaMzF;
        goto knQ3V;
        LU3Mm:
        if (is_numeric($this->nickname_font)) {
            goto lN0Ut;
        }
        goto hOxKW;
        L3UUN:
        $this->nickname_mask_h = abs($arr[7] - $arr[1]);
        goto c6N1h;
        kyzpr:
        $this->nickname_mask_h = $this->nickname_font_h;
        goto kvFnP;
        IBeHK:
        $this->nickname_font_h = imagefontheight($this->nickname_font);
        goto FOsRk;
        iD5qG:
    }
    function _setInviteCodeInfo()
    {
        goto dY2qi;
        Mq0Ro:
        $word_length = strlen($this->invite_code);
        goto GnUQP;
        aMVC1:
        $this->invite_code_font_h = imagefontheight($this->invite_code_font);
        goto Mq0Ro;
        dY2qi:
        if (is_numeric($this->invite_code)) {
            goto mUjqm;
        }
        goto HCS8r;
        ap6aG:
        $this->invite_code_mask_h = abs($arr[7] - $arr[1]);
        goto ld7I5;
        HCS8r:
        $arr = imagettfbbox($this->invite_code_font_size, 0, $this->invite_code_font, $this->invite_code);
        goto ClPvw;
        MayRe:
        mUjqm:
        goto B5vx9;
        ld7I5:
        goto czt9d;
        goto MayRe;
        B5vx9:
        $this->invite_code_font_w = imagefontwidth($this->invite_code_font);
        goto aMVC1;
        jnNUG:
        $this->invite_code_mask_h = $this->invite_code_font_h;
        goto dUWtb;
        GnUQP:
        $this->invite_code_mask_w = $this->invite_code_font_w * $word_length;
        goto jnNUG;
        ClPvw:
        $this->invite_code_mask_w = abs($arr[0] - $arr[2]);
        goto ap6aG;
        dUWtb:
        czt9d:
        goto GL1S4;
        GL1S4:
    }
    /**
     * 设置新图尺寸
     *
     * @param    integer     $img_w   目标宽度
     * @param    integer     $img_h   目标高度
     */
    function _setNewImgSize($img_w, $img_h = null)
    {
        goto iSzsJ;
        u2VRo:
        $this->src_y = 0;
        goto CkDUH;
        j9exP:
        $this->img_scale = $img_w;
        goto zjKwK;
        rJCU0:
        UnzFJ:
        goto uiJpG;
        BRNs1:
        $rate_w = $this->src_w / $fill_w;
        goto rbcOf;
        N4c4r:
        $fill_h = (int) $img_h - $this->img_border_size * 2;
        goto ojLEJ;
        EjPX4:
        $fill_w = (int) $img_w - $this->img_border_size * 2;
        goto N4c4r;
        RH2AU:
        $this->dst_w = $this->fill_w + $this->img_border_size * 2;
        goto thFBN;
        ojLEJ:
        if (!($fill_w < 0 || $fill_h < 0)) {
            goto mh5Mi;
        }
        goto bcjbn;
        YzhYw:
        $this->src_x = 0;
        goto u2VRo;
        o68Ge:
        $this->start_x = $this->img_border_size;
        goto cSMMN;
        Bh5E5:
        $this->fill_h = round($this->src_h * $this->img_scale / 100) - $this->img_border_size * 2;
        goto YzhYw;
        zjKwK:
        $this->fill_w = round($this->src_w * $this->img_scale / 100) - $this->img_border_size * 2;
        goto Bh5E5;
        uiJpG:
        MtjHJ:
        goto o68Ge;
        thFBN:
        $this->dst_h = $this->fill_h + $this->img_border_size * 2;
        goto T1Jt1;
        tWZlH:
        u4hq0:
        goto rJCU0;
        bcjbn:
        throw new Exception("\345\x9b\276\xe7\x89\x87\xe8\276\xb9\xe6\xa1\206\350\xbf\207\345\244\xa7\357\274\214\345\xb7\xb2\xe8\xb6\x85\xe8\277\207\344\272\x86\xe5\x9b\276\347\x89\x87\347\232\x84\xe5\256\xbd\345\xba\246");
        goto UXABt;
        xBrKf:
        $this->copy_h = $this->src_h;
        goto RH2AU;
        LgmNr:
        if (!(2 == $num)) {
            goto MtjHJ;
        }
        goto EjPX4;
        CkDUH:
        $this->copy_w = $this->src_w;
        goto xBrKf;
        iSzsJ:
        $num = func_num_args();
        goto ERC2O;
        ERC2O:
        if (!(1 == $num)) {
            goto KnxR8;
        }
        goto j9exP;
        cSMMN:
        $this->start_y = $this->img_border_size;
        goto pBrIv;
        T1Jt1:
        KnxR8:
        goto LgmNr;
        rbcOf:
        $rate_h = $this->src_h / $fill_h;
        goto yNfGH;
        yNfGH:
        switch ($this->cut_type) {
            case 0:
                goto z9rTp;
                b0YE2:
                $this->copy_h = $this->src_h;
                goto q8GDu;
                eJ6aX:
                $this->fill_w = round($this->src_w / $rate_h);
                goto lKqxS;
                WIhur:
                GWVKH:
                goto ugege;
                vv7Ii:
                if ($rate_w >= $rate_h) {
                    goto Xej60;
                }
                goto eJ6aX;
                TW0bu:
                $this->fill_h = round($this->src_h / $rate_w);
                goto iW33q;
                LtnGM:
                $this->dst_h = $this->fill_h + $this->img_border_size * 2;
                goto uMFz1;
                iW33q:
                Zsgue:
                goto NFmZ2;
                Zog0j:
                eyNGM:
                goto QBOpd;
                lKqxS:
                $this->fill_h = (int) $fill_h;
                goto FVgCX;
                NFmZ2:
                goto GWVKH;
                goto Zog0j;
                o3GPZ:
                $this->fill_w = (int) $fill_w;
                goto TW0bu;
                FVgCX:
                goto Zsgue;
                goto JGYs1;
                QBOpd:
                $this->fill_w = (int) $this->src_w;
                goto YmTwX;
                q8GDu:
                $this->dst_w = $this->fill_w + $this->img_border_size * 2;
                goto LtnGM;
                xd9Ps:
                $this->copy_w = $this->src_w;
                goto b0YE2;
                z9rTp:
                if ($rate_w < 1 && $rate_h < 1) {
                    goto eyNGM;
                }
                goto vv7Ii;
                YmTwX:
                $this->fill_h = (int) $this->src_h;
                goto WIhur;
                ugege:
                $this->src_x = 0;
                goto CrmDG;
                JGYs1:
                Xej60:
                goto o3GPZ;
                uMFz1:
                goto UnzFJ;
                goto nxNbK;
                CrmDG:
                $this->src_y = 0;
                goto xd9Ps;
                nxNbK:
            case 1:
                goto qMSuk;
                iuxp4:
                $this->setSrcCutPosition(0, 0);
                goto aUUpC;
                TAe0W:
                $this->copy_h = $this->src_h;
                goto z0Wha;
                OGfhh:
                goto UnzFJ;
                goto VREOB;
                q6Gxw:
                JgWBy:
                goto BAeAN;
                X8f75:
                if ($this->src_w < $this->src_h) {
                    goto DwGuW;
                }
                goto iuxp4;
                W6r4b:
                $this->setRectangleCut($fill_w, $fill_h);
                goto M6QIZ;
                qhDI8:
                goto lFGye;
                goto ixV5c;
                CWC5i:
                jaQxp:
                goto Ust2p;
                sbVtY:
                $this->setRectangleCut($fill_w, $fill_h);
                goto qlw6f;
                YZjSR:
                $this->copy_w = $this->src_w;
                goto MA07n;
                N4DBT:
                $this->setRectangleCut($this->src_w, $this->src_h);
                goto YZjSR;
                Ust2p:
                $src_x = round($this->src_w - $this->src_h) / 2;
                goto Tgcnn;
                M6QIZ:
                $this->copy_w = $this->src_w;
                goto ubdIb;
                aUUpC:
                $this->copy_w = $this->src_w;
                goto n2CJU;
                Tgcnn:
                $this->setSrcCutPosition($src_x, 0);
                goto hOqvQ;
                YNuOg:
                $this->setSrcCutPosition(0, 0);
                goto N4DBT;
                X1jXQ:
                $src_y = round($this->src_h - $this->src_w) / 2;
                goto g3NpI;
                ixV5c:
                FTlbE:
                goto Uptpc;
                BAeAN:
                lFGye:
                goto DZ1KX;
                VfdHc:
                $this->dst_h = $this->fill_h + $this->img_border_size * 2;
                goto OGfhh;
                sT3Ka:
                DwGuW:
                goto X1jXQ;
                MA07n:
                $this->copy_h = $this->src_h;
                goto qhDI8;
                z0Wha:
                goto JgWBy;
                goto sT3Ka;
                HmZyf:
                $this->copy_w = $this->src_h;
                goto TAe0W;
                DZ1KX:
                $this->dst_w = $this->fill_w + $this->img_border_size * 2;
                goto VfdHc;
                Uptpc:
                if ($this->src_w > $this->src_h) {
                    goto jaQxp;
                }
                goto X8f75;
                n2CJU:
                $this->copy_h = $this->src_w;
                goto sbVtY;
                ubdIb:
                $this->copy_h = $this->src_w;
                goto q6Gxw;
                g3NpI:
                $this->setSrcCutPosition(0, $src_y);
                goto W6r4b;
                hOqvQ:
                $this->setRectangleCut($fill_h, $fill_h);
                goto HmZyf;
                qlw6f:
                goto JgWBy;
                goto CWC5i;
                qMSuk:
                if ($rate_w >= 1 && $rate_h >= 1) {
                    goto FTlbE;
                }
                goto YNuOg;
                VREOB:
            case 2:
                goto L9cby;
                G0e_O:
                goto UnzFJ;
                goto X26WB;
                ltEjS:
                $this->copy_h = $this->fill_h;
                goto t0Z5V;
                L9cby:
                $this->copy_w = $this->fill_w;
                goto ltEjS;
                lVfdM:
                $this->dst_h = $this->fill_h + $this->img_border_size * 2;
                goto G0e_O;
                t0Z5V:
                $this->dst_w = $this->fill_w + $this->img_border_size * 2;
                goto lVfdM;
                X26WB:
            default:
                goto UnzFJ;
        }
        goto tWZlH;
        UXABt:
        mh5Mi:
        goto BRNs1;
        pBrIv:
    }
    /**
     * 检查水印图是否大于生成后的图片宽高
     */
    function _isFull()
    {
        return $this->mask_w + $this->mask_offset_x > $this->fill_w || $this->mask_h + $this->mask_offset_y > $this->fill_h ? true : false;
    }
    function _isNicknameFull()
    {
        return $this->nickname_mask_w + $this->nickname_offset_x > $this->fill_w || $this->nickname_mask_h + $this->nickname_offset_y > $this->fill_h ? true : false;
    }
    function _isInviteCodeFull()
    {
        return $this->invite_code_mask_w + $this->invite_code_offset_x > $this->fill_w || $this->invite_code_mask_h + $this->invite_code_offset_y > $this->fill_h ? true : false;
    }
    function _isQrcodeFull()
    {
        return $this->qrcode_mask_w + $this->qrcode_offset_x > $this->fill_w || $this->qrcode_mask_h + $this->qrcode_offset_y > $this->fill_h ? true : false;
    }
    function _isAvatarFull()
    {
        return $this->avatar_mask_w + $this->avatar_offset_x > $this->fill_w || $this->avatar_mask_h + $this->avatar_offset_y > $this->fill_h ? true : false;
    }
    /**
     * 检查水印图是否超过原图
     */
    function _checkMaskValid()
    {
        goto mHm0i;
        ORLM3:
        smpJg:
        goto NRZcv;
        mHm0i:
        if (!($this->mask_w + $this->mask_offset_x > $this->src_w || $this->mask_h + $this->mask_offset_y > $this->src_h)) {
            goto smpJg;
        }
        goto xaZkv;
        xaZkv:
        throw new Exception("\xe6\xb0\xb4\xe5\215\xb0\xe5\233\276\xe7\211\207\xe5\xb0\xba\345\xaf\xb8\345\244\247\344\272\x8e\xe5\x8e\237\345\x9b\276\357\274\214\xe8\xaf\xb7\347\xbc\251\xe5\260\217\346\xb0\264\345\215\xb0\345\233\276");
        goto ORLM3;
        NRZcv:
    }
    function _checkQrcodeMaskValid()
    {
        goto fJcIz;
        PD3nw:
        U11Ye:
        goto j0WKX;
        fJcIz:
        if (!($this->qrcode_mask_w + $this->qrcode_offset_x > $this->src_w || $this->qrcode_mask_h + $this->qrcode_offset_y > $this->src_h)) {
            goto U11Ye;
        }
        goto o_qiI;
        o_qiI:
        throw new Exception("\344\272\x8c\347\273\xb4\xe7\xa0\x81\xe5\x9b\xbe\347\x89\x87\xe5\xb0\272\xe5\xaf\xb8\xe5\244\xa7\344\xba\x8e\345\x8e\x9f\xe5\x9b\xbe\xef\xbc\x8c\350\xaf\267\347\xbc\251\345\260\217\344\xba\x8c\xe7\xbb\xb4\347\xa0\x81\xe5\x9b\xbe\347\x89\207");
        goto PD3nw;
        j0WKX:
    }
    function _checkAvatarMaskValid()
    {
        goto K3v2d;
        KpYhQ:
        throw new Exception("\345\244\xb4\345\203\x8f\345\260\xba\345\257\xb8\xe5\244\247\344\272\216\345\x8e\237\345\x9b\xbe\357\xbc\x8c\350\xaf\267\xe7\xbc\251\xe5\xb0\217\345\xa4\264\xe5\x83\217\345\x9b\xbe\xe7\x89\207");
        goto irOJ1;
        irOJ1:
        oFamR:
        goto ic1Vk;
        K3v2d:
        if (!($this->avatar_mask_w + $this->avatar_offset_x > $this->src_w || $this->avatar_mask_h + $this->avatar_offset_y > $this->src_h)) {
            goto oFamR;
        }
        goto KpYhQ;
        ic1Vk:
    }
    function _checkNicknameMaskValid()
    {
        goto GrqUk;
        T5ETC:
        U1r9H:
        goto JwCwP;
        e1PJz:
        throw new Exception("\xe6\230\xb5\xe7\247\xb0\345\260\xba\345\xaf\xb8\345\xa4\xa7\xe4\272\216\345\216\237\xe5\x9b\xbe\357\274\x8c\xe8\257\xb7\xe7\xbc\251\345\xb0\217\346\x98\265\347\xa7\260\xe5\233\276\xe7\x89\207");
        goto T5ETC;
        GrqUk:
        if (!($this->nickname_mask_w + $this->nickname_offset_x > $this->src_w || $this->nickname_mask_h + $this->nickname_offset_y > $this->src_h)) {
            goto U1r9H;
        }
        goto e1PJz;
        JwCwP:
    }
    function _checkInviteCodeMaskValid()
    {
        goto nnOUg;
        M8uwx:
        throw new Exception("\351\x82\x80\xe8\xaf\xb7\347\240\x81\345\260\272\345\xaf\xb8\345\244\247\344\272\216\xe5\216\237\345\x9b\xbe\xef\xbc\x8c\350\257\267\347\xbc\251\345\xb0\x8f\351\202\x80\350\257\267\347\240\201\xe5\x9b\xbe\xe7\x89\x87");
        goto mBd6p;
        nnOUg:
        if (!($this->invite_code_mask_w + $this->invite_code_offset_x > $this->src_w || $this->invite_code_mask_h + $this->invite_code_offset_y > $this->src_h)) {
            goto kWdrW;
        }
        goto M8uwx;
        mBd6p:
        kWdrW:
        goto QqwO_;
        QqwO_:
    }
    /**
     * 取得图片类型
     *
     * @param    string     $file_path    文件路径
     */
    function _getImgType($file_path)
    {
        goto uqlUN;
        g4khZ:
        DbZoD:
        goto gpnGE;
        Wvg7g:
        VaMhr:
        goto ovQA6;
        i_dJn:
        if (file_exists($file_path)) {
            goto DbZoD;
        }
        goto yGHhB;
        AZ0j8:
        eignK:
        goto Wvg7g;
        kDdc9:
        goto VaMhr;
        goto g4khZ;
        uqlUN:
        $type_list = array("\61" => "\147\x69\x66", "\x32" => "\152\160\x67", "\63" => "\160\x6e\x67", "\64" => "\163\x77\146", "\65" => "\x70\x73\144", "\x36" => "\x62\x6d\160", "\61\65" => "\x77\142\x6d\x70");
        goto i_dJn;
        C_l8m:
        return $type_list[$img_info[2]];
        goto AZ0j8;
        yGHhB:
        throw new Exception("\xe6\x96\207\344\273\266\xe4\270\215\xe5\255\230\345\234\250\x2c\344\270\x8d\350\203\275\345\217\x96\xe5\xbe\227\xe6\x96\x87\344\273\xb6\xe7\261\xbb\345\x9e\213\41");
        goto kDdc9;
        f7HJn:
        if (!isset($type_list[$img_info[2]])) {
            goto eignK;
        }
        goto C_l8m;
        gpnGE:
        $img_info = @getimagesize($file_path);
        goto f7HJn;
        ovQA6:
    }
    /**
     * 检查图片类型是否合法,调用了array_key_exists函数，此函数要求
     * php版本大于4.1.0
     *
     * @param    string     $img_type    文件类型
     */
    function _checkValid($img_type)
    {
        goto OKomO;
        sXEvY:
        yDxEV:
        goto RPffD;
        E0VIL:
        return false;
        goto sXEvY;
        OKomO:
        if (array_key_exists($img_type, $this->all_type)) {
            goto yDxEV;
        }
        goto E0VIL;
        RPffD:
    }
    /**
     * 按指定路径生成目录
     *
     * @param    string     $path    路径
     */
    function _mkdirs($path)
    {
        goto apShN;
        PSdwE:
        dThcr:
        goto J2L6p;
        QmI4z:
        @mkdir($rootdir);
        goto KEezY;
        apShN:
        $adir = explode("\57", $path);
        goto hJTpT;
        hJTpT:
        $dirlist = '';
        goto eFhCy;
        KEezY:
        Ztyfk:
        goto dRD0g;
        dRD0g:
        foreach ($adir as $key => $val) {
            goto VYjfd;
            eAKX8:
            @chmod($dirpath, 511);
            goto XnO6W;
            jyjyt:
            $dirpath = $rootdir . $dirlist;
            goto WWN33;
            OFfL6:
            VFNlF:
            goto Baq5E;
            bzK2a:
            @mkdir($dirpath);
            goto eAKX8;
            XnO6W:
            opnPY:
            goto K6iA8;
            VYjfd:
            if (!($val != "\x2e" && $val != "\56\56")) {
                goto hBBGE;
            }
            goto hzEhD;
            K6iA8:
            hBBGE:
            goto OFfL6;
            hzEhD:
            $dirlist .= "\57" . $val;
            goto jyjyt;
            WWN33:
            if (file_exists($dirpath)) {
                goto opnPY;
            }
            goto bzK2a;
            Baq5E:
        }
        goto PSdwE;
        WX_Dy:
        if (!(($rootdir != "\56" || $rootdir != "\x2e\x2e") && !file_exists($rootdir))) {
            goto Ztyfk;
        }
        goto QmI4z;
        eFhCy:
        $rootdir = array_shift($adir);
        goto WX_Dy;
        J2L6p:
    }
    /**
     * 垂直翻转
     *
     * @param    string     $src    图片源
     */
    function _flipV($src)
    {
        goto EOist;
        WiwDa:
        goto SFGQv;
        goto xH3LF;
        cEYFE:
        $src_y = $this->getImgHeight($src);
        goto R6dSx;
        EOist:
        $src_x = $this->getImgWidth($src);
        goto cEYFE;
        FNqdg:
        if (!($y < $src_y)) {
            goto WWWtw;
        }
        goto NNsW2;
        R6dSx:
        $new_im = imagecreatetruecolor($src_x, $src_y);
        goto RG_Lf;
        WF3op:
        $this->h_src = $new_im;
        goto RBUbz;
        NNsW2:
        imagecopy($new_im, $src, 0, $src_y - $y - 1, 0, $y, $src_x, 1);
        goto Rmy3F;
        Rmy3F:
        hb2Z1:
        goto uaaTy;
        m1xoN:
        SFGQv:
        goto FNqdg;
        xH3LF:
        WWWtw:
        goto WF3op;
        uaaTy:
        $y++;
        goto WiwDa;
        RG_Lf:
        $y = 0;
        goto m1xoN;
        RBUbz:
    }
    /**
     * 水平翻转
     *
     * @param    string     $src    图片源
     */
    function _flipH($src)
    {
        goto omocd;
        dfntl:
        $this->h_src = $new_im;
        goto VrjEc;
        anAoB:
        tkNrG:
        goto blE1G;
        omocd:
        $src_x = $this->getImgWidth($src);
        goto PrKgi;
        q0Lce:
        goto tkNrG;
        goto fxpf4;
        DxzbZ:
        mMdpR:
        goto QP051;
        PrKgi:
        $src_y = $this->getImgHeight($src);
        goto e3PBV;
        QbgCH:
        imagecopy($new_im, $src, $src_x - $x - 1, 0, $x, 0, 1, $src_y);
        goto DxzbZ;
        blE1G:
        if (!($x < $src_x)) {
            goto UG1OR;
        }
        goto QbgCH;
        e3PBV:
        $new_im = imagecreatetruecolor($src_x, $src_y);
        goto kNb__;
        QP051:
        $x++;
        goto q0Lce;
        fxpf4:
        UG1OR:
        goto dfntl;
        kNb__:
        $x = 0;
        goto anAoB;
        VrjEc:
    }
    /**
     * @param mixed $nickname
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;
    }
    /**
     * @param mixed $nickname_font
     */
    public function setNicknameFont($nickname_font = 2)
    {
        goto rqq8e;
        rqq8e:
        if (!(!is_numeric($nickname_font) && !file_exists($nickname_font))) {
            goto advCs;
        }
        goto a_Mob;
        a_Mob:
        throw new Exception("\xe5\255\227\344\275\x93\xe6\226\207\344\xbb\266\344\xb8\215\345\255\x98\xe5\234\xa8");
        goto DRucC;
        HOwL_:
        $this->nickname_font = $nickname_font;
        goto QFaY6;
        DRucC:
        advCs:
        goto HOwL_;
        QFaY6:
    }
    /**
     * @param mixed $nickname_font_size
     */
    public function setNicknameFontSize($nickname_font_size = "\x31\62")
    {
        $this->nickname_font_size = $nickname_font_size;
    }
    /**
     * @param string $nickname_font_color
     */
    public function setNicknameFontColor($nickname_font_color = "\x23\146\x66\146\146\146\x66")
    {
        $this->nickname_font_color = $nickname_font_color;
    }
    /**
     * @param int $nickname_pos_x
     */
    public function setNicknamePosX($nickname_pos_x)
    {
        $this->nickname_pos_x = $nickname_pos_x;
    }
    /**
     * @param int $nickname_pos_y
     */
    public function setNicknamePosY($nickname_pos_y)
    {
        $this->nickname_pos_y = $nickname_pos_y;
    }
    /**
     * @param int $nickname_offset_x
     */
    public function setNicknameOffsetX($nickname_offset_x)
    {
        $this->nickname_offset_x = (int) $nickname_offset_x;
    }
    /**
     * @param int $nickname_offset_y
     */
    public function setNicknameOffsetY($nickname_offset_y)
    {
        $this->nickname_offset_y = (int) $nickname_offset_y;
    }
    /**
     * @param mixed $nickname_w
     */
    public function setNicknameW($nickname_w)
    {
        $this->nickname_w = $nickname_w;
    }
    /**
     * @param mixed $nickname_h
     */
    public function setNicknameH($nickname_h)
    {
        $this->nickname_h = $nickname_h;
    }
    /**
     * @param int $nickname_position
     */
    public function setNicknamePosition($nickname_position)
    {
        $this->nickname_position = $nickname_position;
    }
    /**
     * @param mixed $avatar_img
     */
    public function setAvatarImg($avatar_img)
    {
        $this->avatar_img = $avatar_img;
    }
    /**
     * @param int $avatar_pos_x
     */
    public function setAvatarPosX($avatar_pos_x)
    {
        $this->avatar_pos_x = $avatar_pos_x;
    }
    /**
     * @param int $avatar_pos_y
     */
    public function setAvatarPosY($avatar_pos_y)
    {
        $this->avatar_pos_y = $avatar_pos_y;
    }
    /**
     * @param int $avatar_offset_x
     */
    public function setAvatarOffsetX($avatar_offset_x)
    {
        $this->avatar_offset_x = (int) $avatar_offset_x;
    }
    /**
     * @param int $avatar_offset_y
     */
    public function setAvatarOffsetY($avatar_offset_y)
    {
        $this->avatar_offset_y = (int) $avatar_offset_y;
    }
    /**
     * @param mixed $avatar_w
     */
    public function setAvatarW($avatar_w)
    {
        $this->avatar_w = $avatar_w;
    }
    /**
     * @param mixed $avatar_h
     */
    public function setAvatarH($avatar_h)
    {
        $this->avatar_h = $avatar_h;
    }
    /**
     * @param int $avatar_position
     */
    public function setAvatarPosition($avatar_position)
    {
        $this->avatar_position = $avatar_position;
    }
    /**
     * @param mixed $qrcode_img
     */
    public function setQrcodeImg($qrcode_img)
    {
        $this->qrcode_img = $qrcode_img;
    }
    /**
     * @param int $qrcode_pos_x
     */
    public function setQrcodePosX($qrcode_pos_x)
    {
        $this->qrcode_pos_x = $qrcode_pos_x;
    }
    /**
     * @param int $qrcode_pos_y
     */
    public function setQrcodePosY($qrcode_pos_y)
    {
        $this->qrcode_pos_y = $qrcode_pos_y;
    }
    /**
     * @param int $qrcode_offset_x
     */
    public function setQrcodeOffsetX($qrcode_offset_x)
    {
        $this->qrcode_offset_x = (int) $qrcode_offset_x;
    }
    /**
     * @param int $qrcode_offset_y
     */
    public function setQrcodeOffsetY($qrcode_offset_y)
    {
        $this->qrcode_offset_y = (int) $qrcode_offset_y;
    }
    /**
     * @param mixed $qrcode_w
     */
    public function setQrcodeW($qrcode_w)
    {
        $this->qrcode_w = $qrcode_w;
    }
    /**
     * @param mixed $qrcode_h
     */
    public function setQrcodeH($qrcode_h)
    {
        $this->qrcode_h = $qrcode_h;
    }
    /**
     * @param int $qrcode_position
     */
    public function setQrcodePosition($qrcode_position)
    {
        $this->qrcode_position = $qrcode_position;
    }
    /**
     * @param mixed $invite_code
     */
    public function setInviteCode($invite_code)
    {
        $this->invite_code = $invite_code;
    }
    /**
     * @param mixed $invite_code_font
     */
    public function setInviteCodeFont($invite_code_font = 2)
    {
        goto BaRDd;
        VdQTe:
        $this->invite_code_font = $invite_code_font;
        goto OsiZd;
        BaRDd:
        if (!(!is_numeric($invite_code_font) && !file_exists($invite_code_font))) {
            goto QgDjS;
        }
        goto NVU5H;
        NVU5H:
        throw new Exception("\xe5\xad\227\xe4\275\x93\346\x96\207\344\xbb\xb6\344\xb8\215\xe5\255\230\xe5\x9c\xa8");
        goto ybhSZ;
        ybhSZ:
        QgDjS:
        goto VdQTe;
        OsiZd:
    }
    /**
     * @param mixed $invite_code_font_size
     */
    public function setInviteCodeFontSize($invite_code_font_size = "\x31\62")
    {
        $this->invite_code_font_size = $invite_code_font_size;
    }
    /**
     * @param string $invite_code_font_color
     */
    public function setInviteCodeFontColor($invite_code_font_color)
    {
        $this->invite_code_font_color = $invite_code_font_color;
    }
    /**
     * @param int $invite_code_pos_x
     */
    public function setInviteCodePosX($invite_code_pos_x)
    {
        $this->invite_code_pos_x = $invite_code_pos_x;
    }
    /**
     * @param int $invite_code_pos_y
     */
    public function setInviteCodePosY($invite_code_pos_y)
    {
        $this->invite_code_pos_y = $invite_code_pos_y;
    }
    /**
     * @param int $invite_code_offset_x
     */
    public function setInviteCodeOffsetX($invite_code_offset_x)
    {
        $this->invite_code_offset_x = (int) $invite_code_offset_x;
    }
    /**
     * @param int $invite_code_offset_y
     */
    public function setInviteCodeOffsetY($invite_code_offset_y)
    {
        $this->invite_code_offset_y = (int) $invite_code_offset_y;
    }
    /**
     * @param mixed $invite_code_w
     */
    public function setInviteCodeW($invite_code_w)
    {
        $this->invite_code_w = $invite_code_w;
    }
    /**
     * @param mixed $invite_code_h
     */
    public function setInviteCodeH($invite_code_h)
    {
        $this->invite_code_h = $invite_code_h;
    }
    /**
     * @param int $invite_code_position
     */
    public function setInviteCodePosition($invite_code_position)
    {
        $this->invite_code_position = $invite_code_position;
    }
    /**
     * @param mixed $invite_code_mask_h
     */
    public function setInviteCodeMaskH($invite_code_mask_h)
    {
        $this->invite_code_mask_h = $invite_code_mask_h;
    }
    /**
     * @param mixed $nickname_font_w
     */
    public function setNicknameFontW($nickname_font_w)
    {
        $this->nickname_font_w = $nickname_font_w;
    }
    /**
     * @param mixed $nickname_font_h
     */
    public function setNicknameFontH($nickname_font_h)
    {
        $this->nickname_font_h = $nickname_font_h;
    }
    /**
     * @param mixed $nickname_mask_w
     */
    public function setNicknameMaskW($nickname_mask_w)
    {
        $this->nickname_mask_w = $nickname_mask_w;
    }
    /**
     * @param mixed $nickname_mask_h
     */
    public function setNicknameMaskH($nickname_mask_h)
    {
        $this->nickname_mask_h = $nickname_mask_h;
    }
    /**
     * @param mixed $avatar_mask_w
     */
    public function setAvatarMaskW($avatar_mask_w)
    {
        $this->avatar_mask_w = $avatar_mask_w;
    }
    /**
     * @param mixed $avatar_mask_h
     */
    public function setAvatarMaskH($avatar_mask_h)
    {
        $this->avatar_mask_h = $avatar_mask_h;
    }
    /**
     * @param mixed $qrcode_mask_w
     */
    public function setQrcodeMaskW($qrcode_mask_w)
    {
        $this->qrcode_mask_w = $qrcode_mask_w;
    }
    /**
     * @param mixed $qrcode_mask_h
     */
    public function setQrcodeMaskH($qrcode_mask_h)
    {
        $this->qrcode_mask_h = $qrcode_mask_h;
    }
    /**
     * @param mixed $invite_code_font_w
     */
    public function setInviteCodeFontW($invite_code_font_w)
    {
        $this->invite_code_font_w = $invite_code_font_w;
    }
    /**
     * @param mixed $invite_code_font_h
     */
    public function setInviteCodeFontH($invite_code_font_h)
    {
        $this->invite_code_font_h = $invite_code_font_h;
    }
    /**
     * @param mixed $invite_code_mask_w
     */
    public function setInviteCodeMaskW($invite_code_mask_w)
    {
        $this->invite_code_mask_w = $invite_code_mask_w;
    }
    /**
     * @param boolean $only_cut
     */
    public function setOnlyCut($only_cut = false)
    {
        $this->only_cut = $only_cut;
    }
}
?>
