<?php
/*
 __________________________________________________
|  Encode by BajieTeam on we7                      |
|__________________________________________________|
*/

goto mnZyl;
rh2iS:
define("\x50\x43\114\x5a\x49\120\x5f\103\102\137\120\117\123\124\137\101\x44\x44", 78004);
goto nc8cg;
nc8cg:
class PclZip
{
    public $zipname = '';
    public $zip_fd = 0;
    public $error_code = 1;
    public $error_string = '';
    public $magic_quotes_status;
    public function __construct($p_zipname)
    {
        goto BZsOQ;
        T73B1:
        $this->magic_quotes_status = -1;
        goto gcAoJ;
        D7Fwx:
        $this->zipname = $p_zipname;
        goto vo9gh;
        jK3DE:
        A3lxM:
        goto D7Fwx;
        vo9gh:
        $this->zip_fd = 0;
        goto T73B1;
        hBu25:
        die("\x41\142\157\162\164\40" . basename(__FILE__) . "\x20\72\x20\x4d\x69\x73\x73\151\x6e\147\40\x7a\154\151\x62\x20\145\170\x74\145\x6e\x73\151\157\x6e\163");
        goto jK3DE;
        gcAoJ:
        return;
        goto eLao7;
        BZsOQ:
        if (function_exists("\x67\x7a\x6f\160\x65\156")) {
            goto A3lxM;
        }
        goto hBu25;
        eLao7:
    }
    public function create($p_filelist)
    {
        goto ewJf5;
        XJpA1:
        xXLYn:
        goto DJmwU;
        ZHtJJ:
        $this->privErrorReset();
        goto Cx2ad;
        Na5YF:
        if ($v_size == 2) {
            goto Fj_Pt;
        }
        goto xL9Ny;
        vUKU1:
        jzIyk:
        goto wNIFO;
        iL2MY:
        if (is_string($p_filelist)) {
            goto jzIyk;
        }
        goto x5D_H;
        z8Zo3:
        IwzUw:
        goto lfiSH;
        yAoYa:
        dm5Dy:
        goto PSmDc;
        ajyID:
        x8d7l:
        goto cTPJL;
        lfiSH:
        $v_result = $this->privFileDescrExpand($v_filedescr_list, $v_options);
        goto w_6Wt;
        Rv7Y4:
        LecFI:
        goto olTyl;
        k4iR2:
        R9YaO:
        goto gvlkS;
        ppsce:
        Fj_Pt:
        goto kM3P2;
        lQ3bl:
        return 0;
        goto l7RDI;
        pJcXJ:
        WInGm:
        goto vNxFz;
        H5LQb:
        $v_att_list = $p_filelist;
        goto jmIkK;
        RWSGV:
        goto xXLYn;
        goto vUKU1;
        s6C2B:
        return 0;
        goto tbcN4;
        enfw3:
        $v_result = $this->privCreate($v_filedescr_list, $p_result_list, $v_options);
        goto noQRZ;
        tWZbY:
        foreach ($v_att_list as $v_entry) {
            goto fQcO9;
            fQcO9:
            $v_result = $this->privFileDescrParseAtt($v_entry, $v_filedescr_list[], $v_options, $v_supported_attributes);
            goto zESNS;
            KjEVJ:
            return 0;
            goto SzGaE;
            zESNS:
            if (!($v_result != 1)) {
                goto HCp9v;
            }
            goto KjEVJ;
            SzGaE:
            HCp9v:
            goto bLCZ3;
            bLCZ3:
            mMVDP:
            goto usUta;
            usUta:
        }
        goto z8Zo3;
        PYGp6:
        goto xXLYn;
        goto HxjF1;
        olTyl:
        $v_result = $this->privParseOptions($v_arg_list, $v_size, $v_options, array(PCLZIP_OPT_REMOVE_PATH => "\x6f\x70\164\x69\157\x6e\x61\154", PCLZIP_OPT_REMOVE_ALL_PATH => "\x6f\160\x74\x69\157\156\141\x6c", PCLZIP_OPT_ADD_PATH => "\x6f\x70\164\151\x6f\x6e\141\x6c", PCLZIP_CB_PRE_ADD => "\x6f\160\x74\x69\157\156\x61\x6c", PCLZIP_CB_POST_ADD => "\x6f\160\164\151\x6f\x6e\x61\154", PCLZIP_OPT_NO_COMPRESSION => "\x6f\160\x74\151\157\156\141\x6c", PCLZIP_OPT_COMMENT => "\x6f\x70\x74\151\157\x6e\141\x6c", PCLZIP_OPT_TEMP_FILE_THRESHOLD => "\157\x70\164\x69\x6f\x6e\141\154", PCLZIP_OPT_TEMP_FILE_ON => "\x6f\x70\164\151\157\156\141\154", PCLZIP_OPT_TEMP_FILE_OFF => "\157\160\x74\x69\157\x6e\141\154"));
        goto q_NHG;
        H2OSu:
        return 0;
        goto oUWxH;
        SslWr:
        $p_result_list = array();
        goto ECkZH;
        Mqy71:
        if (is_integer($v_arg_list[0]) && $v_arg_list[0] > 77000) {
            goto LecFI;
        }
        goto v0TFt;
        kM3P2:
        $v_options[PCLZIP_OPT_REMOVE_PATH] = $v_arg_list[1];
        goto nD0OH;
        KSD0Q:
        $v_att_list = array();
        goto ti5dB;
        T8qEs:
        return 0;
        goto PYGp6;
        xL9Ny:
        if ($v_size > 2) {
            goto dm5Dy;
        }
        goto PkphQ;
        noQRZ:
        if (!($v_result != 1)) {
            goto oQiXv;
        }
        goto H2OSu;
        qwEqb:
        array_shift($v_arg_list);
        goto PzDUO;
        PSmDc:
        PclZip::privErrorLog(PCLZIP_ERR_INVALID_PARAMETER, "\111\156\x76\x61\154\x69\x64\40\x6e\x75\x6d\x62\145\162\x20\57\x20\164\171\x70\145\x20\x6f\146\40\x61\162\147\165\x6d\x65\x6e\x74\x73");
        goto s6C2B;
        jmIkK:
        UMOPt:
        goto RWSGV;
        Wj8oA:
        $v_string_list = $p_filelist;
        goto cMK15;
        cTPJL:
        wZe32:
        goto UYEUi;
        ewJf5:
        $v_result = 1;
        goto ZHtJJ;
        x5D_H:
        PclZip::privErrorLog(PCLZIP_ERR_INVALID_PARAMETER, "\x49\156\166\141\x6c\x69\144\40\166\141\162\151\x61\x62\154\145\x20\x74\x79\x70\145\40\160\137\146\x69\x6c\145\154\x69\163\x74");
        goto T8qEs;
        hd6wY:
        if (!($v_size > 1)) {
            goto WInGm;
        }
        goto TkHkn;
        tbcN4:
        T0VxF:
        goto Zrp0S;
        Pj5x8:
        $v_size = func_num_args();
        goto hd6wY;
        nD0OH:
        goto T0VxF;
        goto yAoYa;
        QnfEg:
        if (isset($p_filelist[0]) && is_array($p_filelist[0])) {
            goto nCcWL;
        }
        goto Wj8oA;
        gvlkS:
        ZrtCf:
        goto pJcXJ;
        TkHkn:
        $v_arg_list = func_get_args();
        goto qwEqb;
        FgnPs:
        foreach ($v_string_list as $v_string) {
            goto jDh2D;
            jDh2D:
            if ($v_string != '') {
                goto psr4G;
            }
            goto vZqCR;
            BqwS0:
            psr4G:
            goto yTpTU;
            XSClP:
            nn44R:
            goto Tbxor;
            bJROY:
            fZ7fN:
            goto XSClP;
            yTpTU:
            $v_att_list[][PCLZIP_ATT_FILE_NAME] = $v_string;
            goto bJROY;
            vZqCR:
            goto fZ7fN;
            goto BqwS0;
            Tbxor:
        }
        goto ajyID;
        cMK15:
        goto UMOPt;
        goto Rka0N;
        q_NHG:
        if (!($v_result != 1)) {
            goto R9YaO;
        }
        goto PWcqB;
        l7RDI:
        Mn_Hb:
        goto enfw3;
        Cx2ad:
        $v_options = array();
        goto OhzZv;
        Zrp0S:
        goto ZrtCf;
        goto Rv7Y4;
        PkphQ:
        goto T0VxF;
        goto ppsce;
        oUWxH:
        oQiXv:
        goto cvbDG;
        OhzZv:
        $v_options[PCLZIP_OPT_NO_COMPRESSION] = false;
        goto Pj5x8;
        cvbDG:
        return $p_result_list;
        goto ywK7k;
        ti5dB:
        $v_filedescr_list = array();
        goto SslWr;
        ECkZH:
        if (is_array($p_filelist)) {
            goto dVOOP;
        }
        goto iL2MY;
        PzDUO:
        $v_size--;
        goto Mqy71;
        v0TFt:
        $v_options[PCLZIP_OPT_ADD_PATH] = $v_arg_list[0];
        goto Na5YF;
        PmmYz:
        $v_string_list = array();
        goto KSD0Q;
        DJmwU:
        if (!(sizeof($v_string_list) != 0)) {
            goto wZe32;
        }
        goto FgnPs;
        w_6Wt:
        if (!($v_result != 1)) {
            goto Mn_Hb;
        }
        goto lQ3bl;
        PWcqB:
        return 0;
        goto k4iR2;
        HxjF1:
        dVOOP:
        goto QnfEg;
        wNIFO:
        $v_string_list = explode(PCLZIP_SEPARATOR, $p_filelist);
        goto XJpA1;
        Rka0N:
        nCcWL:
        goto H5LQb;
        UYEUi:
        $v_supported_attributes = array(PCLZIP_ATT_FILE_NAME => "\155\x61\156\x64\141\x74\x6f\162\x79", PCLZIP_ATT_FILE_NEW_SHORT_NAME => "\x6f\160\x74\x69\157\156\141\x6c", PCLZIP_ATT_FILE_NEW_FULL_NAME => "\x6f\160\164\x69\157\x6e\x61\x6c", PCLZIP_ATT_FILE_MTIME => "\x6f\x70\164\x69\157\156\x61\x6c", PCLZIP_ATT_FILE_CONTENT => "\157\x70\164\151\157\x6e\141\x6c", PCLZIP_ATT_FILE_COMMENT => "\157\160\164\151\x6f\156\x61\x6c");
        goto tWZbY;
        vNxFz:
        $this->privOptionDefaultThreshold($v_options);
        goto PmmYz;
        ywK7k:
    }
    public function add($p_filelist)
    {
        goto yomXg;
        mT17k:
        if (is_integer($v_arg_list[0]) && $v_arg_list[0] > 77000) {
            goto NFT2h;
        }
        goto PKI6G;
        ZKCa_:
        Rv_uf:
        goto jff8a;
        U1ygj:
        if (is_array($p_filelist)) {
            goto K8lAH;
        }
        goto E1tzG;
        Cqxov:
        $v_filedescr_list = array();
        goto E0Z5C;
        J92po:
        JeSP2:
        goto Sp9d4;
        I5JIz:
        $v_supported_attributes = array(PCLZIP_ATT_FILE_NAME => "\x6d\x61\x6e\x64\141\x74\157\x72\x79", PCLZIP_ATT_FILE_NEW_SHORT_NAME => "\157\x70\164\151\x6f\x6e\141\154", PCLZIP_ATT_FILE_NEW_FULL_NAME => "\x6f\x70\164\151\x6f\x6e\141\154", PCLZIP_ATT_FILE_MTIME => "\x6f\160\x74\151\x6f\x6e\141\x6c", PCLZIP_ATT_FILE_CONTENT => "\157\160\164\x69\157\x6e\141\154", PCLZIP_ATT_FILE_COMMENT => "\157\x70\x74\151\157\156\x61\154");
        goto nXi78;
        i0J2h:
        p0w2p:
        goto I5JIz;
        XNypT:
        goto hncH5;
        goto xIVkn;
        UMNH_:
        if (!($v_result != 1)) {
            goto MTIiC;
        }
        goto A0phQ;
        tE_GC:
        foreach ($v_string_list as $v_string) {
            $v_att_list[][PCLZIP_ATT_FILE_NAME] = $v_string;
            dJplU:
        }
        goto M_EgB;
        TM7qJ:
        $v_size = func_num_args();
        goto RVza4;
        y0Yic:
        return 0;
        goto XNypT;
        jNAwP:
        MTIiC:
        goto RLhmH;
        cApk0:
        PclZip::privErrorLog(PCLZIP_ERR_INVALID_PARAMETER, "\x49\156\166\141\154\151\x64\40\166\x61\162\x69\141\142\x6c\x65\40\x74\x79\x70\145\x20\47" . gettype($p_filelist) . "\47\x20\146\x6f\x72\x20\160\x5f\x66\x69\x6c\x65\x6c\x69\163\x74");
        goto y0Yic;
        B9Uyk:
        goto AJD92;
        goto vkuFD;
        xIVkn:
        K8lAH:
        goto JTzXF;
        X5N_G:
        if (!($v_result != 1)) {
            goto DeS16;
        }
        goto RfG1x;
        XIohp:
        $v_arg_list = func_get_args();
        goto bwyUj;
        JTzXF:
        if (isset($p_filelist[0]) && is_array($p_filelist[0])) {
            goto hIElt;
        }
        goto XOTOX;
        KGdfC:
        return 0;
        goto mnoIm;
        CBLVu:
        return 0;
        goto tModa;
        lGAJC:
        $v_options = array();
        goto yHTkp;
        LcePt:
        PclZip::privErrorLog(PCLZIP_ERR_INVALID_PARAMETER, "\x49\x6e\166\x61\154\151\144\40\x6e\x75\x6d\x62\x65\x72\40\x2f\40\164\x79\x70\145\x20\157\x66\x20\x61\x72\x67\165\x6d\145\156\164\x73");
        goto KGdfC;
        HFo8W:
        $v_options[PCLZIP_OPT_REMOVE_PATH] = $v_arg_list[1];
        goto B9Uyk;
        mRmhs:
        goto AJD92;
        goto oUKVQ;
        PKI6G:
        $v_options[PCLZIP_OPT_ADD_PATH] = $v_add_path = $v_arg_list[0];
        goto yvneA;
        RfG1x:
        return 0;
        goto OSQ9B;
        yHTkp:
        $v_options[PCLZIP_OPT_NO_COMPRESSION] = false;
        goto TM7qJ;
        vkuFD:
        N2UoR:
        goto LcePt;
        YJ703:
        if ($v_size > 2) {
            goto N2UoR;
        }
        goto mRmhs;
        h16Yp:
        $v_att_list = $p_filelist;
        goto jwIaz;
        tModa:
        SIeQ3:
        goto ZKCa_;
        A0phQ:
        return 0;
        goto jNAwP;
        E0Z5C:
        $p_result_list = array();
        goto U1ygj;
        jff8a:
        tXPuV:
        goto Hp6mT;
        tGAE1:
        if (!($v_result != 1)) {
            goto SIeQ3;
        }
        goto CBLVu;
        yvneA:
        if ($v_size == 2) {
            goto IxVKS;
        }
        goto YJ703;
        XOTOX:
        $v_string_list = $p_filelist;
        goto OBBdD;
        GZBD1:
        if (!(sizeof($v_string_list) != 0)) {
            goto p0w2p;
        }
        goto tE_GC;
        nXi78:
        foreach ($v_att_list as $v_entry) {
            goto ikbt8;
            UDfuY:
            return 0;
            goto sT14c;
            uHWTZ:
            if (!($v_result != 1)) {
                goto kXZVU;
            }
            goto UDfuY;
            Q5U0A:
            iB1V0:
            goto LybUk;
            sT14c:
            kXZVU:
            goto Q5U0A;
            ikbt8:
            $v_result = $this->privFileDescrParseAtt($v_entry, $v_filedescr_list[], $v_options, $v_supported_attributes);
            goto uHWTZ;
            LybUk:
        }
        goto J92po;
        M_EgB:
        qvqyN:
        goto i0J2h;
        H12z9:
        $v_result = $this->privParseOptions($v_arg_list, $v_size, $v_options, array(PCLZIP_OPT_REMOVE_PATH => "\x6f\x70\164\151\157\156\141\x6c", PCLZIP_OPT_REMOVE_ALL_PATH => "\x6f\x70\x74\x69\157\x6e\x61\154", PCLZIP_OPT_ADD_PATH => "\157\160\164\x69\157\156\141\154", PCLZIP_CB_PRE_ADD => "\157\x70\164\151\x6f\156\141\x6c", PCLZIP_CB_POST_ADD => "\157\160\164\x69\157\156\141\154", PCLZIP_OPT_NO_COMPRESSION => "\x6f\160\164\x69\x6f\x6e\141\154", PCLZIP_OPT_COMMENT => "\x6f\x70\164\x69\x6f\156\141\154", PCLZIP_OPT_ADD_COMMENT => "\x6f\160\x74\151\x6f\x6e\141\154", PCLZIP_OPT_PREPEND_COMMENT => "\x6f\x70\164\151\x6f\x6e\141\154", PCLZIP_OPT_TEMP_FILE_THRESHOLD => "\x6f\x70\x74\x69\x6f\x6e\141\154", PCLZIP_OPT_TEMP_FILE_ON => "\157\160\x74\x69\x6f\x6e\141\x6c", PCLZIP_OPT_TEMP_FILE_OFF => "\x6f\x70\164\x69\x6f\156\141\x6c"));
        goto tGAE1;
        sErdm:
        $v_string_list = explode(PCLZIP_SEPARATOR, $p_filelist);
        goto KKyWm;
        YMkEQ:
        goto hncH5;
        goto JUI7k;
        E1tzG:
        if (is_string($p_filelist)) {
            goto VM1bD;
        }
        goto cApk0;
        RLhmH:
        $v_result = $this->privAdd($v_filedescr_list, $p_result_list, $v_options);
        goto X5N_G;
        Sp9d4:
        $v_result = $this->privFileDescrExpand($v_filedescr_list, $v_options);
        goto UMNH_;
        RRM7k:
        $this->privErrorReset();
        goto lGAJC;
        OBBdD:
        goto f_zOi;
        goto AP0iM;
        Hp6mT:
        $this->privOptionDefaultThreshold($v_options);
        goto sFnGu;
        cxpxE:
        $v_size--;
        goto mT17k;
        OSQ9B:
        DeS16:
        goto ejzED;
        sFnGu:
        $v_string_list = array();
        goto h0Wt_;
        C6Nrx:
        goto Rv_uf;
        goto VFybp;
        RVza4:
        if (!($v_size > 1)) {
            goto tXPuV;
        }
        goto XIohp;
        VFybp:
        NFT2h:
        goto H12z9;
        JUI7k:
        VM1bD:
        goto sErdm;
        bwyUj:
        array_shift($v_arg_list);
        goto cxpxE;
        mnoIm:
        AJD92:
        goto C6Nrx;
        jwIaz:
        f_zOi:
        goto YMkEQ;
        h0Wt_:
        $v_att_list = array();
        goto Cqxov;
        KKyWm:
        hncH5:
        goto GZBD1;
        yomXg:
        $v_result = 1;
        goto RRM7k;
        ejzED:
        return $p_result_list;
        goto tOkm1;
        AP0iM:
        hIElt:
        goto h16Yp;
        oUKVQ:
        IxVKS:
        goto HFo8W;
        tOkm1:
    }
    public function listContent()
    {
        goto GaLWT;
        fmqv9:
        I435M:
        goto oy0fP;
        GaLWT:
        $v_result = 1;
        goto E14m7;
        nT4M1:
        unset($p_list);
        goto S4c09;
        iB0kw:
        CXs0C:
        goto Ulz4v;
        UjNkZ:
        if (!(($v_result = $this->privList($p_list)) != 1)) {
            goto I435M;
        }
        goto nT4M1;
        S4c09:
        return 0;
        goto fmqv9;
        oy0fP:
        return $p_list;
        goto Zjhsi;
        E14m7:
        $this->privErrorReset();
        goto lwFD5;
        lwFD5:
        if ($this->privCheckFormat()) {
            goto CXs0C;
        }
        goto mWgZK;
        Ulz4v:
        $p_list = array();
        goto UjNkZ;
        mWgZK:
        return 0;
        goto iB0kw;
        Zjhsi:
    }
    public function extract()
    {
        goto Dgmit;
        BepKf:
        $v_remove_all_path = $v_options[PCLZIP_OPT_REMOVE_ALL_PATH];
        goto I8oiU;
        UAFwC:
        goto vd_Nc;
        goto phKVC;
        i8PuK:
        $this->privOptionDefaultThreshold($v_options);
        goto XzY5H;
        Lsjr3:
        if (!isset($v_options[PCLZIP_OPT_REMOVE_PATH])) {
            goto CE0Fr;
        }
        goto IKhyD;
        TJzIF:
        $v_remove_path = $v_arg_list[1];
        goto Xldh8;
        W93yp:
        $v_path = $v_arg_list[0];
        goto ALZ26;
        isJT_:
        L3Qwd:
        goto aDtJG;
        JQPdg:
        $v_path .= "\57";
        goto YmvNl;
        qi4cd:
        $v_result = $this->privExtractByRule($p_list, $v_path, $v_remove_path, $v_remove_all_path, $v_options);
        goto A1YLy;
        YmvNl:
        zgLP0:
        goto o2ozu;
        Xldh8:
        goto vd_Nc;
        goto fE426;
        JGzWd:
        if (!isset($v_options[PCLZIP_OPT_ADD_PATH])) {
            goto L3Qwd;
        }
        goto qy3qG;
        XrmX2:
        if ($v_size > 2) {
            goto XbbWV;
        }
        goto UAFwC;
        vK2vJ:
        $v_options = array();
        goto dx_Wx;
        ALZ26:
        if ($v_size == 2) {
            goto wcjQh;
        }
        goto XrmX2;
        a0LmF:
        if (!isset($v_options[PCLZIP_OPT_PATH])) {
            goto eylQA;
        }
        goto sCmhv;
        FXPkh:
        if (!($v_size > 0)) {
            goto qnrXA;
        }
        goto Ul7UH;
        TVQrB:
        CE0Fr:
        goto lD6mv;
        OdgDa:
        qnrXA:
        goto i8PuK;
        iSGFL:
        return 0;
        goto g8ffl;
        lD6mv:
        if (!isset($v_options[PCLZIP_OPT_REMOVE_ALL_PATH])) {
            goto EzGMg;
        }
        goto BepKf;
        qy3qG:
        if (!(strlen($v_path) > 0 && substr($v_path, -1) != "\57")) {
            goto zgLP0;
        }
        goto JQPdg;
        x9PME:
        unset($p_list);
        goto Kmlwq;
        D0FqA:
        iacHS:
        goto JCmfM;
        DV2xP:
        return $p_list;
        goto ENqmW;
        K2cix:
        return 0;
        goto veyBZ;
        Ul7UH:
        $v_arg_list = func_get_args();
        goto tntQ3;
        A1YLy:
        if (!($v_result < 1)) {
            goto oDN41;
        }
        goto x9PME;
        cVGfY:
        goto q1ST6;
        goto D0FqA;
        fE426:
        XbbWV:
        goto P_kxW;
        dx_Wx:
        $v_path = '';
        goto MXQIF;
        j3BW8:
        if (!($v_result != 1)) {
            goto vCFb3;
        }
        goto K2cix;
        g8ffl:
        vd_Nc:
        goto cVGfY;
        phKVC:
        wcjQh:
        goto TJzIF;
        ymIpc:
        if ($this->privCheckFormat()) {
            goto oGQeV;
        }
        goto fsZtO;
        Dgmit:
        $v_result = 1;
        goto CotYv;
        yShmO:
        oDN41:
        goto DV2xP;
        aDtJG:
        q1ST6:
        goto OdgDa;
        N5C1j:
        $v_remove_all_path = false;
        goto r2plf;
        MXQIF:
        $v_remove_path = '';
        goto N5C1j;
        wuuzG:
        oGQeV:
        goto vK2vJ;
        UnATw:
        $v_options[PCLZIP_OPT_EXTRACT_AS_STRING] = false;
        goto FXPkh;
        veyBZ:
        vCFb3:
        goto a0LmF;
        r2plf:
        $v_size = func_num_args();
        goto UnATw;
        sCmhv:
        $v_path = $v_options[PCLZIP_OPT_PATH];
        goto xkjZQ;
        Kmlwq:
        return 0;
        goto yShmO;
        P_kxW:
        PclZip::privErrorLog(PCLZIP_ERR_INVALID_PARAMETER, "\111\156\x76\141\154\x69\x64\x20\156\165\x6d\x62\145\162\x20\x2f\40\x74\171\x70\x65\40\157\146\x20\141\x72\x67\165\155\145\156\x74\x73");
        goto iSGFL;
        fsZtO:
        return 0;
        goto wuuzG;
        IKhyD:
        $v_remove_path = $v_options[PCLZIP_OPT_REMOVE_PATH];
        goto TVQrB;
        xkjZQ:
        eylQA:
        goto Lsjr3;
        tntQ3:
        if (is_integer($v_arg_list[0]) && $v_arg_list[0] > 77000) {
            goto iacHS;
        }
        goto W93yp;
        o2ozu:
        $v_path .= $v_options[PCLZIP_OPT_ADD_PATH];
        goto isJT_;
        I8oiU:
        EzGMg:
        goto JGzWd;
        JCmfM:
        $v_result = $this->privParseOptions($v_arg_list, $v_size, $v_options, array(PCLZIP_OPT_PATH => "\157\x70\x74\x69\157\x6e\141\x6c", PCLZIP_OPT_REMOVE_PATH => "\157\x70\164\x69\x6f\156\x61\x6c", PCLZIP_OPT_REMOVE_ALL_PATH => "\157\160\x74\x69\x6f\x6e\141\154", PCLZIP_OPT_ADD_PATH => "\x6f\x70\164\151\x6f\x6e\x61\x6c", PCLZIP_CB_PRE_EXTRACT => "\157\x70\x74\x69\x6f\156\x61\154", PCLZIP_CB_POST_EXTRACT => "\x6f\x70\x74\x69\x6f\156\x61\x6c", PCLZIP_OPT_SET_CHMOD => "\157\x70\164\151\157\x6e\x61\x6c", PCLZIP_OPT_BY_NAME => "\x6f\160\164\x69\x6f\156\x61\x6c", PCLZIP_OPT_BY_EREG => "\x6f\160\164\x69\157\x6e\141\x6c", PCLZIP_OPT_BY_PREG => "\157\160\x74\151\157\156\x61\x6c", PCLZIP_OPT_BY_INDEX => "\157\x70\164\151\157\156\x61\x6c", PCLZIP_OPT_EXTRACT_AS_STRING => "\x6f\x70\164\151\157\156\x61\x6c", PCLZIP_OPT_EXTRACT_IN_OUTPUT => "\x6f\160\x74\x69\x6f\156\x61\x6c", PCLZIP_OPT_REPLACE_NEWER => "\x6f\160\164\151\x6f\156\x61\x6c", PCLZIP_OPT_STOP_ON_ERROR => "\x6f\160\164\x69\157\156\x61\x6c", PCLZIP_OPT_EXTRACT_DIR_RESTRICTION => "\x6f\x70\164\151\x6f\x6e\x61\x6c", PCLZIP_OPT_TEMP_FILE_THRESHOLD => "\157\160\x74\151\x6f\156\141\154", PCLZIP_OPT_TEMP_FILE_ON => "\x6f\160\164\x69\x6f\156\x61\154", PCLZIP_OPT_TEMP_FILE_OFF => "\157\x70\x74\151\157\156\x61\154"));
        goto j3BW8;
        CotYv:
        $this->privErrorReset();
        goto ymIpc;
        XzY5H:
        $p_list = array();
        goto qi4cd;
        ENqmW:
    }
    public function extractByIndex($p_index)
    {
        goto AX_s7;
        bFavJ:
        zyly5:
        goto U1NRi;
        zACVs:
        ZIxpx:
        goto NdlXP;
        uJfRt:
        if (!isset($v_options[PCLZIP_OPT_REMOVE_ALL_PATH])) {
            goto epfcK;
        }
        goto xXqpu;
        Hc0B1:
        $v_options[PCLZIP_OPT_EXTRACT_AS_STRING] = false;
        goto HkJQt;
        Bv43n:
        if (!isset($v_options[PCLZIP_OPT_ADD_PATH])) {
            goto vhL91;
        }
        goto itlNE;
        O4lf0:
        vUgWy:
        goto x3q0r;
        x3q0r:
        lAaYO:
        goto VMF7M;
        fWsDa:
        k54TL:
        goto pj8WG;
        SPciO:
        if (!isset($v_options[PCLZIP_OPT_PATH])) {
            goto BfQ24;
        }
        goto jVCir;
        xLpMc:
        $v_remove_path = $v_options[PCLZIP_OPT_REMOVE_PATH];
        goto t0zDa;
        Ud73J:
        yVS5d:
        goto kkvfp;
        nrbXo:
        BfQ24:
        goto jUJC5;
        fxXEr:
        $v_options_trick = array();
        goto TSc0T;
        RaqQC:
        Jvhtx:
        goto ym2MC;
        xXqpu:
        $v_remove_all_path = $v_options[PCLZIP_OPT_REMOVE_ALL_PATH];
        goto miTA7;
        BTnnq:
        $v_options[PCLZIP_OPT_EXTRACT_AS_STRING] = false;
        goto O4lf0;
        U1NRi:
        return $p_list;
        goto G5YKn;
        GtEcS:
        return 0;
        goto fWsDa;
        EjobT:
        DY0Ii:
        goto SPciO;
        zMRlQ:
        if (is_integer($v_arg_list[0]) && $v_arg_list[0] > 77000) {
            goto ZIxpx;
        }
        goto RsWSG;
        uU8PQ:
        if ($v_size == 2) {
            goto l6nkZ;
        }
        goto AvBv3;
        d8tIQ:
        vhL91:
        goto bBLg5;
        NdlXP:
        $v_result = $this->privParseOptions($v_arg_list, $v_size, $v_options, array(PCLZIP_OPT_PATH => "\x6f\x70\164\x69\157\x6e\141\154", PCLZIP_OPT_REMOVE_PATH => "\x6f\x70\164\151\x6f\156\x61\x6c", PCLZIP_OPT_REMOVE_ALL_PATH => "\157\160\x74\151\x6f\x6e\x61\x6c", PCLZIP_OPT_EXTRACT_AS_STRING => "\x6f\x70\x74\x69\157\x6e\141\x6c", PCLZIP_OPT_ADD_PATH => "\x6f\x70\x74\x69\157\156\x61\154", PCLZIP_CB_PRE_EXTRACT => "\157\x70\164\x69\x6f\156\x61\154", PCLZIP_CB_POST_EXTRACT => "\157\160\164\x69\x6f\x6e\x61\x6c", PCLZIP_OPT_SET_CHMOD => "\157\160\164\x69\157\x6e\141\x6c", PCLZIP_OPT_REPLACE_NEWER => "\x6f\160\x74\151\x6f\156\141\x6c", PCLZIP_OPT_STOP_ON_ERROR => "\157\x70\164\151\x6f\x6e\x61\x6c", PCLZIP_OPT_EXTRACT_DIR_RESTRICTION => "\157\160\x74\x69\x6f\x6e\141\x6c", PCLZIP_OPT_TEMP_FILE_THRESHOLD => "\157\x70\x74\151\157\156\x61\x6c", PCLZIP_OPT_TEMP_FILE_ON => "\x6f\160\164\x69\x6f\156\141\x6c", PCLZIP_OPT_TEMP_FILE_OFF => "\157\160\x74\x69\x6f\x6e\x61\x6c"));
        goto j9t9V;
        BFryB:
        $v_size = func_num_args();
        goto Hc0B1;
        RsWSG:
        $v_path = $v_arg_list[0];
        goto uU8PQ;
        G067s:
        return 0;
        goto EjobT;
        v_2K0:
        array_shift($v_arg_list);
        goto lPY7I;
        j9t9V:
        if (!($v_result != 1)) {
            goto DY0Ii;
        }
        goto G067s;
        kkvfp:
        $v_options = array();
        goto KTCmE;
        WZsRs:
        $v_remove_all_path = false;
        goto BFryB;
        AtwEx:
        $this->privErrorReset();
        goto AEsd6;
        vyEAp:
        $v_path .= $v_options[PCLZIP_OPT_ADD_PATH];
        goto d8tIQ;
        jUJC5:
        if (!isset($v_options[PCLZIP_OPT_REMOVE_PATH])) {
            goto oe1Br;
        }
        goto xLpMc;
        itlNE:
        if (!(strlen($v_path) > 0 && substr($v_path, -1) != "\x2f")) {
            goto fMekb;
        }
        goto n2lN9;
        ro7Q0:
        goto k54TL;
        goto r27Dc;
        dvWAw:
        $v_remove_path = '';
        goto WZsRs;
        l1Vtx:
        fMekb:
        goto vyEAp;
        AX_s7:
        $v_result = 1;
        goto AtwEx;
        t0zDa:
        oe1Br:
        goto uJfRt;
        TSc0T:
        $v_result = $this->privParseOptions($v_arg_trick, sizeof($v_arg_trick), $v_options_trick, array(PCLZIP_OPT_BY_INDEX => "\157\160\164\151\x6f\x6e\x61\x6c"));
        goto gktfj;
        AEsd6:
        if ($this->privCheckFormat()) {
            goto yVS5d;
        }
        goto DtDxM;
        LJOrW:
        $this->privOptionDefaultThreshold($v_options);
        goto yczr8;
        VeC01:
        return 0;
        goto bFavJ;
        U1Hfn:
        $v_arg_trick = array(PCLZIP_OPT_BY_INDEX, $p_index);
        goto fxXEr;
        AvBv3:
        if ($v_size > 2) {
            goto DRy6V;
        }
        goto ZmEiB;
        yczr8:
        if (!(($v_result = $this->privExtractByRule($p_list, $v_path, $v_remove_path, $v_remove_all_path, $v_options)) < 1)) {
            goto zyly5;
        }
        goto VeC01;
        uX2tc:
        goto vUgWy;
        goto j0dYh;
        bBLg5:
        if (!isset($v_options[PCLZIP_OPT_EXTRACT_AS_STRING])) {
            goto EsLds;
        }
        goto uX2tc;
        DtDxM:
        return 0;
        goto Ud73J;
        faUq7:
        return 0;
        goto RaqQC;
        ZmEiB:
        goto k54TL;
        goto ZMyYb;
        WQok_:
        $v_remove_path = $v_arg_list[1];
        goto ro7Q0;
        pj8WG:
        goto lAaYO;
        goto zACVs;
        ym2MC:
        $v_options[PCLZIP_OPT_BY_INDEX] = $v_options_trick[PCLZIP_OPT_BY_INDEX];
        goto LJOrW;
        j0dYh:
        EsLds:
        goto BTnnq;
        jVCir:
        $v_path = $v_options[PCLZIP_OPT_PATH];
        goto nrbXo;
        n2lN9:
        $v_path .= "\57";
        goto l1Vtx;
        HkJQt:
        if (!($v_size > 1)) {
            goto CqX2V;
        }
        goto QbqBW;
        gktfj:
        if (!($v_result != 1)) {
            goto Jvhtx;
        }
        goto faUq7;
        qphki:
        PclZip::privErrorLog(PCLZIP_ERR_INVALID_PARAMETER, "\x49\156\166\x61\154\151\144\40\156\165\155\x62\145\x72\40\57\40\x74\x79\x70\145\40\x6f\x66\x20\x61\x72\147\x75\155\145\x6e\164\x73");
        goto GtEcS;
        VMF7M:
        CqX2V:
        goto U1Hfn;
        r27Dc:
        DRy6V:
        goto qphki;
        KTCmE:
        $v_path = '';
        goto dvWAw;
        QbqBW:
        $v_arg_list = func_get_args();
        goto v_2K0;
        ZMyYb:
        l6nkZ:
        goto WQok_;
        miTA7:
        epfcK:
        goto Bv43n;
        lPY7I:
        $v_size--;
        goto zMRlQ;
        G5YKn:
    }
    public function delete()
    {
        goto YZKGe;
        hl_pZ:
        return $v_list;
        goto LYVEh;
        WA9RU:
        $v_list = array();
        goto I4lR1;
        rYSGM:
        aluY0:
        goto EcaZT;
        Gepv1:
        return 0;
        goto EcwwQ;
        VEHeG:
        if ($this->privCheckFormat()) {
            goto os0ig;
        }
        goto gks4Q;
        Vund1:
        $v_arg_list = func_get_args();
        goto FpeDQ;
        EcaZT:
        $this->privDisableMagicQuotes();
        goto WA9RU;
        gks4Q:
        return 0;
        goto KjgHC;
        KjgHC:
        os0ig:
        goto MCSDQ;
        FpeDQ:
        $v_result = $this->privParseOptions($v_arg_list, $v_size, $v_options, array(PCLZIP_OPT_BY_NAME => "\x6f\160\164\151\157\156\141\154", PCLZIP_OPT_BY_EREG => "\157\x70\x74\x69\157\156\141\154", PCLZIP_OPT_BY_PREG => "\x6f\160\164\x69\x6f\x6e\x61\x6c", PCLZIP_OPT_BY_INDEX => "\x6f\x70\164\x69\x6f\x6e\x61\x6c"));
        goto KkSwh;
        YZKGe:
        $v_result = 1;
        goto mXKqr;
        mXKqr:
        $this->privErrorReset();
        goto VEHeG;
        FaAHf:
        unset($v_list);
        goto gutLl;
        pMJIE:
        $this->privSwapBackMagicQuotes();
        goto FaAHf;
        d3GN9:
        if (!($v_size > 0)) {
            goto aluY0;
        }
        goto Vund1;
        bLQts:
        $this->privSwapBackMagicQuotes();
        goto hl_pZ;
        kJeFi:
        Cstgg:
        goto bLQts;
        KkSwh:
        if (!($v_result != 1)) {
            goto cYDYC;
        }
        goto Gepv1;
        qFMUa:
        $v_size = func_num_args();
        goto d3GN9;
        EcwwQ:
        cYDYC:
        goto rYSGM;
        MCSDQ:
        $v_options = array();
        goto qFMUa;
        gutLl:
        return 0;
        goto kJeFi;
        I4lR1:
        if (!(($v_result = $this->privDeleteByRule($v_list, $v_options)) != 1)) {
            goto Cstgg;
        }
        goto pMJIE;
        LYVEh:
    }
    public function deleteByIndex($p_index)
    {
        $p_list = $this->delete(PCLZIP_OPT_BY_INDEX, $p_index);
        return $p_list;
    }
    public function properties()
    {
        goto pEYRj;
        KRpLB:
        $v_prop["\163\x74\x61\x74\165\x73"] = "\156\157\x74\137\x65\x78\151\x73\164";
        goto osd2X;
        uiSi7:
        u39FA:
        goto huBp0;
        oRheD:
        return $v_prop;
        goto E_35b;
        huBp0:
        $this->privSwapBackMagicQuotes();
        goto oRheD;
        x9MdJ:
        if (!(($v_result = $this->privReadEndCentralDir($v_central_dir)) != 1)) {
            goto B1kj_;
        }
        goto Ttt_c;
        jkfq4:
        $this->privSwapBackMagicQuotes();
        goto BBeb5;
        IqVDB:
        return 0;
        goto Lq_ps;
        WmIND:
        if (!(($this->zip_fd = @fopen($this->zipname, "\x72\x62")) == 0)) {
            goto L25_d;
        }
        goto wir8f;
        oyutR:
        $v_prop["\156\x62"] = $v_central_dir["\145\x6e\x74\x72\151\145\163"];
        goto c9fkl;
        cEoCY:
        $v_prop["\x63\x6f\x6d\x6d\145\x6e\x74"] = '';
        goto M_d67;
        pEYRj:
        $this->privErrorReset();
        goto rX2ov;
        osd2X:
        if (!@is_file($this->zipname)) {
            goto u39FA;
        }
        goto WmIND;
        l3rh0:
        $v_prop["\x63\157\x6d\x6d\145\156\x74"] = $v_central_dir["\x63\x6f\155\155\145\x6e\164"];
        goto oyutR;
        mA9zC:
        PclZip::privErrorLog(PCLZIP_ERR_READ_OPEN_FAIL, "\125\156\x61\x62\154\x65\40\x74\x6f\40\x6f\160\145\156\40\141\162\143\150\151\166\x65\40\47" . $this->zipname . "\x27\40\x69\156\x20\x62\x69\x6e\141\x72\171\x20\x72\x65\x61\144\40\155\x6f\144\x65");
        goto IqVDB;
        BBeb5:
        return 0;
        goto u2iub;
        Lq_ps:
        L25_d:
        goto iRIBB;
        u2iub:
        E6k8o:
        goto zpxfz;
        vgz8v:
        $this->privCloseFd();
        goto l3rh0;
        M_d67:
        $v_prop["\x6e\142"] = 0;
        goto KRpLB;
        Ttt_c:
        $this->privSwapBackMagicQuotes();
        goto yV_Cp;
        rX2ov:
        $this->privDisableMagicQuotes();
        goto xYXdy;
        wir8f:
        $this->privSwapBackMagicQuotes();
        goto mA9zC;
        yV_Cp:
        return 0;
        goto d3xgk;
        xYXdy:
        if ($this->privCheckFormat()) {
            goto E6k8o;
        }
        goto jkfq4;
        c9fkl:
        $v_prop["\x73\164\x61\164\165\x73"] = "\x6f\153";
        goto uiSi7;
        iRIBB:
        $v_central_dir = array();
        goto x9MdJ;
        zpxfz:
        $v_prop = array();
        goto cEoCY;
        d3xgk:
        B1kj_:
        goto vgz8v;
        E_35b:
    }
    public function duplicate($p_archive)
    {
        goto DhgAT;
        hQ6sA:
        $v_result = $this->privDuplicate($p_archive->zipname);
        goto Nh5WD;
        cc60g:
        if (!is_file($p_archive)) {
            goto snoIu;
        }
        goto cjzz8;
        jX5J1:
        $v_result = PCLZIP_ERR_INVALID_PARAMETER;
        goto u7Fho;
        Nh5WD:
        goto qhUQu;
        goto yr_fz;
        dwqxE:
        PclZip::privErrorLog(PCLZIP_ERR_INVALID_PARAMETER, "\111\x6e\x76\141\154\x69\x64\40\166\141\162\x69\141\142\x6c\x65\40\x74\171\160\x65\x20\160\137\141\x72\143\x68\x69\x76\x65\137\164\157\137\x61\144\144");
        goto jX5J1;
        zT5tC:
        PclZip::privErrorLog(PCLZIP_ERR_MISSING_FILE, "\116\x6f\x20\146\x69\x6c\x65\40\167\151\164\150\x20\x66\x69\154\x65\x6e\x61\x6d\x65\x20\47" . $p_archive . "\x27");
        goto j10Vx;
        DhgAT:
        $v_result = 1;
        goto sl_Rr;
        ULbN1:
        goto PgQ_f;
        goto J4bXz;
        cjzz8:
        $v_result = $this->privDuplicate($p_archive);
        goto ULbN1;
        J4bXz:
        snoIu:
        goto zT5tC;
        u7Fho:
        goto qhUQu;
        goto q7N5x;
        MFaDp:
        qhUQu:
        goto ewdqV;
        jaURK:
        PgQ_f:
        goto MFaDp;
        ewdqV:
        return $v_result;
        goto LIZQO;
        j10Vx:
        $v_result = PCLZIP_ERR_MISSING_FILE;
        goto jaURK;
        sl_Rr:
        $this->privErrorReset();
        goto QVHY4;
        yr_fz:
        lTO0L:
        goto cc60g;
        q7N5x:
        Pfe3o:
        goto hQ6sA;
        HSBYM:
        if (is_string($p_archive)) {
            goto lTO0L;
        }
        goto dwqxE;
        QVHY4:
        if (is_object($p_archive) && get_class($p_archive) == "\160\143\x6c\172\x69\x70") {
            goto Pfe3o;
        }
        goto HSBYM;
        LIZQO:
    }
    public function merge($p_archive_to_add)
    {
        goto l0QHf;
        Wtm4c:
        $v_result = $this->privMerge($v_object_archive);
        goto j4Y7P;
        ipOrF:
        PclZip::privErrorLog(PCLZIP_ERR_INVALID_PARAMETER, "\111\x6e\166\x61\154\151\x64\40\166\x61\x72\151\141\x62\154\x65\x20\164\x79\x70\145\x20\160\x5f\x61\162\x63\150\x69\166\x65\137\164\157\137\x61\144\x64");
        goto jcHeS;
        Tlg0k:
        $v_object_archive = new PclZip($p_archive_to_add);
        goto Wtm4c;
        w6Efj:
        goto Daz0g;
        goto GFGAA;
        mp_n1:
        $this->privErrorReset();
        goto KHHNs;
        vY6Oq:
        if (is_object($p_archive_to_add) && get_class($p_archive_to_add) == "\160\x63\154\x7a\151\x70") {
            goto k33sY;
        }
        goto JVMg4;
        KHHNs:
        if ($this->privCheckFormat()) {
            goto n6RSI;
        }
        goto YJ5v_;
        XX3VR:
        $v_result = $this->privMerge($p_archive_to_add);
        goto E8rTA;
        l0QHf:
        $v_result = 1;
        goto mp_n1;
        j4Y7P:
        Daz0g:
        goto VxVFB;
        jUI10:
        gqRkE:
        goto Tlg0k;
        YJ5v_:
        return 0;
        goto NtmAT;
        jcHeS:
        $v_result = PCLZIP_ERR_INVALID_PARAMETER;
        goto w6Efj;
        JVMg4:
        if (is_string($p_archive_to_add)) {
            goto gqRkE;
        }
        goto ipOrF;
        E8rTA:
        goto Daz0g;
        goto jUI10;
        GFGAA:
        k33sY:
        goto XX3VR;
        NtmAT:
        n6RSI:
        goto vY6Oq;
        VxVFB:
        return $v_result;
        goto uhfcr;
        uhfcr:
    }
    public function errorCode()
    {
        goto hP1uE;
        t3mS3:
        goto HuYre;
        goto z2HRD;
        opPW6:
        return $this->error_code;
        goto t3mS3;
        z2HRD:
        Hvux5:
        goto spfNq;
        hP1uE:
        if (PCLZIP_ERROR_EXTERNAL == 1) {
            goto Hvux5;
        }
        goto opPW6;
        gelGk:
        HuYre:
        goto SlNIM;
        spfNq:
        return PclErrorCode();
        goto gelGk;
        SlNIM:
    }
    public function errorName($p_with_code = false)
    {
        goto lf9MQ;
        IfjVv:
        $v_value = "\116\157\x4e\141\155\145";
        goto R4N6x;
        RX4hT:
        xHdP8:
        goto tBAA8;
        WOt8T:
        if (isset($v_name[$this->error_code])) {
            goto bbuZl;
        }
        goto IfjVv;
        XOx4w:
        if ($p_with_code) {
            goto UnBMB;
        }
        goto YupPT;
        QSXN8:
        x3C2G:
        goto XOx4w;
        q2Fh3:
        $v_value = $v_name[$this->error_code];
        goto QSXN8;
        lf9MQ:
        $v_name = array(PCLZIP_ERR_NO_ERROR => "\x50\103\114\132\x49\120\x5f\x45\x52\122\x5f\x4e\x4f\137\x45\122\x52\x4f\122", PCLZIP_ERR_WRITE_OPEN_FAIL => "\x50\103\x4c\132\x49\x50\x5f\x45\x52\122\137\x57\122\x49\x54\x45\x5f\117\120\105\x4e\137\106\101\x49\x4c", PCLZIP_ERR_READ_OPEN_FAIL => "\x50\x43\x4c\132\111\x50\137\105\x52\x52\x5f\x52\x45\101\x44\137\x4f\120\x45\x4e\x5f\106\101\111\114", PCLZIP_ERR_INVALID_PARAMETER => "\x50\103\114\x5a\111\120\137\105\x52\x52\x5f\x49\x4e\x56\x41\x4c\x49\x44\x5f\120\101\x52\x41\115\x45\124\105\x52", PCLZIP_ERR_MISSING_FILE => "\120\x43\x4c\132\x49\120\137\105\x52\x52\x5f\x4d\x49\123\x53\111\116\107\137\x46\x49\x4c\x45", PCLZIP_ERR_FILENAME_TOO_LONG => "\120\x43\x4c\132\x49\x50\x5f\105\122\122\137\x46\111\114\x45\116\101\115\x45\137\124\117\x4f\x5f\x4c\x4f\116\107", PCLZIP_ERR_INVALID_ZIP => "\120\x43\x4c\x5a\111\x50\x5f\x45\122\x52\x5f\x49\x4e\x56\101\114\x49\104\x5f\132\x49\120", PCLZIP_ERR_BAD_EXTRACTED_FILE => "\120\103\114\x5a\111\120\137\x45\122\x52\x5f\x42\x41\104\137\x45\130\x54\x52\x41\x43\x54\x45\104\137\x46\x49\114\x45", PCLZIP_ERR_DIR_CREATE_FAIL => "\x50\103\x4c\x5a\x49\120\137\105\122\x52\x5f\104\111\x52\x5f\103\122\x45\101\x54\x45\137\x46\101\x49\x4c", PCLZIP_ERR_BAD_EXTENSION => "\120\103\114\132\x49\120\137\105\122\x52\x5f\102\101\x44\137\x45\130\x54\x45\116\x53\x49\117\116", PCLZIP_ERR_BAD_FORMAT => "\x50\x43\x4c\132\x49\120\137\x45\x52\122\137\x42\101\104\x5f\106\117\122\115\101\124", PCLZIP_ERR_DELETE_FILE_FAIL => "\x50\x43\x4c\132\111\x50\x5f\105\122\x52\x5f\104\105\114\x45\124\x45\x5f\x46\111\x4c\105\x5f\x46\x41\x49\114", PCLZIP_ERR_RENAME_FILE_FAIL => "\x50\x43\x4c\132\x49\x50\x5f\x45\122\122\137\x52\x45\x4e\x41\115\105\137\x46\x49\x4c\105\x5f\x46\x41\111\114", PCLZIP_ERR_BAD_CHECKSUM => "\120\x43\114\x5a\x49\x50\x5f\x45\x52\122\x5f\102\101\x44\137\x43\110\105\x43\x4b\x53\x55\x4d", PCLZIP_ERR_INVALID_ARCHIVE_ZIP => "\x50\103\114\132\x49\120\x5f\105\122\122\137\111\116\x56\101\x4c\x49\104\137\101\x52\x43\x48\111\126\105\137\x5a\111\x50", PCLZIP_ERR_MISSING_OPTION_VALUE => "\120\x43\114\132\111\120\137\x45\122\122\x5f\115\111\x53\123\x49\x4e\107\137\117\120\x54\x49\x4f\116\137\126\x41\x4c\125\x45", PCLZIP_ERR_INVALID_OPTION_VALUE => "\x50\103\114\x5a\x49\120\137\x45\x52\122\x5f\111\x4e\x56\101\114\111\x44\137\117\x50\124\111\117\116\x5f\126\x41\114\125\105", PCLZIP_ERR_UNSUPPORTED_COMPRESSION => "\x50\103\x4c\x5a\111\120\x5f\105\122\122\137\x55\116\123\x55\120\120\117\122\124\x45\x44\137\x43\x4f\115\120\x52\105\x53\123\111\x4f\x4e", PCLZIP_ERR_UNSUPPORTED_ENCRYPTION => "\120\103\x4c\x5a\111\120\x5f\x45\122\122\137\x55\x4e\123\x55\120\120\117\122\124\x45\x44\x5f\x45\x4e\103\x52\x59\x50\124\111\x4f\x4e", PCLZIP_ERR_INVALID_ATTRIBUTE_VALUE => "\120\x43\x4c\x5a\x49\x50\x5f\x45\x52\x52\x5f\x49\x4e\126\101\114\x49\x44\137\101\124\x54\122\x49\x42\125\x54\x45\x5f\x56\101\114\125\105", PCLZIP_ERR_DIRECTORY_RESTRICTION => "\120\103\114\132\x49\120\137\105\122\122\x5f\x44\111\122\105\103\124\117\122\x59\x5f\122\105\x53\124\x52\x49\x43\124\x49\117\116");
        goto WOt8T;
        R4N6x:
        goto x3C2G;
        goto ui6Tk;
        ui6Tk:
        bbuZl:
        goto q2Fh3;
        HdNCI:
        goto xHdP8;
        goto V9heJ;
        YupPT:
        return $v_value;
        goto HdNCI;
        V9heJ:
        UnBMB:
        goto ae9Ws;
        ae9Ws:
        return $v_value . "\x20\50" . $this->error_code . "\51";
        goto RX4hT;
        tBAA8:
    }
    public function errorInfo($p_full = false)
    {
        goto Qa6gc;
        H3FPt:
        return $this->errorName(true) . "\x20\x3a\40" . $this->error_string;
        goto KUoyb;
        au3QQ:
        O51u6:
        goto H3FPt;
        cPlLX:
        goto BAEJE;
        goto PQlj7;
        PQlj7:
        c8Aup:
        goto rz2Eh;
        Qa6gc:
        if (PCLZIP_ERROR_EXTERNAL == 1) {
            goto c8Aup;
        }
        goto UYuBq;
        UYuBq:
        if ($p_full) {
            goto O51u6;
        }
        goto xo_T7;
        zXQbY:
        BAEJE:
        goto bZazI;
        xo_T7:
        return $this->error_string . "\40\x5b\x63\x6f\x64\x65\40" . $this->error_code . "\135";
        goto pkVol;
        KUoyb:
        dErfP:
        goto cPlLX;
        pkVol:
        goto dErfP;
        goto au3QQ;
        rz2Eh:
        return PclErrorString();
        goto zXQbY;
        bZazI:
    }
    public function privCheckFormat($p_level = 0)
    {
        goto x4lW5;
        bIaq4:
        PclZip::privErrorLog(PCLZIP_ERR_MISSING_FILE, "\x4d\151\x73\163\x69\x6e\x67\x20\141\x72\x63\x68\x69\x76\145\x20\146\x69\154\x65\x20\x27" . $this->zipname . "\x27");
        goto CA9PH;
        eGo6J:
        plmga:
        goto bOWOD;
        D4hYb:
        PclZip::privErrorLog(PCLZIP_ERR_READ_OPEN_FAIL, "\x55\x6e\x61\142\154\145\40\164\x6f\40\x72\x65\x61\x64\40\x61\x72\x63\x68\151\x76\145\x20\x27" . $this->zipname . "\x27");
        goto cPIOy;
        znbzM:
        if (is_readable($this->zipname)) {
            goto plmga;
        }
        goto D4hYb;
        CA9PH:
        return false;
        goto OvKmT;
        mXg4w:
        $this->privErrorReset();
        goto aj4Z3;
        hnMtD:
        clearstatcache();
        goto mXg4w;
        cPIOy:
        return false;
        goto eGo6J;
        OvKmT:
        R9Q7d:
        goto znbzM;
        x4lW5:
        $v_result = true;
        goto hnMtD;
        aj4Z3:
        if (is_file($this->zipname)) {
            goto R9Q7d;
        }
        goto bIaq4;
        bOWOD:
        return $v_result;
        goto sFAWn;
        sFAWn:
    }
    public function privParseOptions(&$p_options_list, $p_size, &$v_result_list, $v_requested_options = false)
    {
        goto EgnK6;
        hKcze:
        PclZip::privErrorLog(PCLZIP_ERR_INVALID_PARAMETER, "\115\x69\x73\x73\x69\156\147\x20\155\141\156\144\x61\164\157\x72\171\x20\160\141\162\141\x6d\x65\x74\145\x72\x20" . PclZipUtilOptionText($key) . "\50" . $key . "\x29");
        goto AThVD;
        MRv6f:
        if (isset($v_result_list[PCLZIP_OPT_TEMP_FILE_THRESHOLD])) {
            goto FJvo4;
        }
        goto CInnK;
        jsRNw:
        return PclZip::errorCode();
        goto O2LUM;
        EgnK6:
        $v_result = 1;
        goto cZsVc;
        AThVD:
        return PclZip::errorCode();
        goto TAl8k;
        j4uOf:
        $key = reset($v_requested_options);
        goto X4mHA;
        sFkZ3:
        RWHD9:
        goto c0Xhd;
        vDvVe:
        goto MPntC;
        goto sFkZ3;
        TkFMM:
        f3h4C:
        goto at3ip;
        gq9wR:
        nlc_V:
        goto XjDck;
        P3nS0:
        PclZip::privErrorLog(PCLZIP_ERR_INVALID_PARAMETER, "\x49\156\x76\x61\x6c\151\144\x20\157\160\x74\151\157\156\141\x6c\x20\x70\141\162\x61\x6d\145\164\145\x72\x20\x27" . $p_options_list[$i] . "\x27\x20\x66\157\x72\x20\164\150\151\163\40\155\145\x74\x68\x6f\144");
        goto jsRNw;
        at3ip:
        $key = next($v_requested_options);
        goto CzzQE;
        uz1d2:
        $i++;
        goto vDvVe;
        CInnK:
        FJvo4:
        goto Pd8Iv;
        GcljU:
        if (isset($v_requested_options[$p_options_list[$i]])) {
            goto plE81;
        }
        goto P3nS0;
        c0Xhd:
        if (!($v_requested_options !== false)) {
            goto C0mvS;
        }
        goto j4uOf;
        Tj14w:
        if (isset($v_result_list[$key])) {
            goto LQwOH;
        }
        goto hKcze;
        zTdPR:
        if (!($key = key($v_requested_options))) {
            goto nlc_V;
        }
        goto KUppe;
        Pd8Iv:
        return $v_result;
        goto GXAxL;
        O1N7l:
        switch ($p_options_list[$i]) {
            case PCLZIP_OPT_PATH:
            case PCLZIP_OPT_REMOVE_PATH:
            case PCLZIP_OPT_ADD_PATH:
                goto NlrUY;
                RiDNp:
                PclZip::privErrorLog(PCLZIP_ERR_MISSING_OPTION_VALUE, "\x4d\151\163\163\x69\x6e\x67\40\160\x61\162\141\155\145\164\x65\x72\x20\166\141\154\165\x65\40\146\x6f\x72\x20\x6f\x70\164\151\157\156\x20\x27" . PclZipUtilOptionText($p_options_list[$i]) . "\x27");
                goto L8uOY;
                vy0I0:
                $v_result_list[$p_options_list[$i]] = PclZipUtilTranslateWinPath($p_options_list[$i + 1], false);
                goto wvGMh;
                L8uOY:
                return PclZip::errorCode();
                goto QFC5c;
                wvGMh:
                $i++;
                goto R3Ipy;
                QFC5c:
                SZpvi:
                goto vy0I0;
                R3Ipy:
                goto tVLCH;
                goto j6TIG;
                NlrUY:
                if (!($i + 1 >= $p_size)) {
                    goto SZpvi;
                }
                goto RiDNp;
                j6TIG:
            case PCLZIP_OPT_TEMP_FILE_THRESHOLD:
                goto ASPVX;
                TSjBg:
                PclZip::privErrorLog(PCLZIP_ERR_MISSING_OPTION_VALUE, "\x4d\x69\163\x73\x69\156\147\40\x70\141\x72\141\155\145\164\x65\162\40\x76\x61\x6c\x75\145\x20\146\x6f\162\x20\157\x70\164\151\x6f\x6e\x20\47" . PclZipUtilOptionText($p_options_list[$i]) . "\x27");
                goto y54Od;
                ILBxj:
                if (!isset($v_result_list[PCLZIP_OPT_TEMP_FILE_OFF])) {
                    goto BOZoP;
                }
                goto QYINZ;
                TNkfs:
                y_dw0:
                goto ILBxj;
                SsVWn:
                return PclZip::errorCode();
                goto Lm8rL;
                jODyT:
                if (!(!is_integer($v_value) || $v_value < 0)) {
                    goto eH0KE;
                }
                goto lJoDy;
                Lm8rL:
                eH0KE:
                goto uyPPs;
                aneMb:
                return PclZip::errorCode();
                goto LIwHF;
                uyPPs:
                $v_result_list[$p_options_list[$i]] = $v_value * 1048576;
                goto OkjZp;
                OkjZp:
                $i++;
                goto hWUtN;
                y54Od:
                return PclZip::errorCode();
                goto TNkfs;
                hWUtN:
                goto tVLCH;
                goto aRnwC;
                LIwHF:
                BOZoP:
                goto trZ2h;
                QYINZ:
                PclZip::privErrorLog(PCLZIP_ERR_INVALID_PARAMETER, "\x4f\x70\x74\x69\157\156\40\47" . PclZipUtilOptionText($p_options_list[$i]) . "\x27\x20\x63\x61\x6e\x20\156\x6f\164\x20\x62\145\40\x75\163\145\x64\x20\x77\151\164\150\40\157\160\164\x69\157\156\40\47\120\x43\114\132\x49\x50\x5f\x4f\120\x54\137\x54\x45\x4d\120\137\106\111\x4c\105\137\117\106\x46\x27");
                goto aneMb;
                lJoDy:
                PclZip::privErrorLog(PCLZIP_ERR_INVALID_OPTION_VALUE, "\x49\156\x74\145\x67\145\162\40\x65\170\x70\x65\143\x74\x65\x64\40\146\x6f\x72\40\157\160\164\x69\157\156\x20\47" . PclZipUtilOptionText($p_options_list[$i]) . "\x27");
                goto SsVWn;
                ASPVX:
                if (!($i + 1 >= $p_size)) {
                    goto y_dw0;
                }
                goto TSjBg;
                trZ2h:
                $v_value = $p_options_list[$i + 1];
                goto jODyT;
                aRnwC:
            case PCLZIP_OPT_TEMP_FILE_ON:
                goto iFrMY;
                HPtEa:
                goto tVLCH;
                goto puAub;
                Ksf9U:
                PclZip::privErrorLog(PCLZIP_ERR_INVALID_PARAMETER, "\117\160\164\x69\157\156\x20\x27" . PclZipUtilOptionText($p_options_list[$i]) . "\x27\40\x63\x61\156\x20\x6e\157\164\40\142\145\x20\165\x73\145\x64\x20\x77\151\x74\150\x20\x6f\x70\x74\151\x6f\x6e\40\x27\120\x43\114\x5a\111\x50\x5f\x4f\x50\x54\x5f\124\x45\x4d\x50\x5f\106\x49\x4c\x45\x5f\x4f\106\106\x27");
                goto yTZl2;
                iFrMY:
                if (!isset($v_result_list[PCLZIP_OPT_TEMP_FILE_OFF])) {
                    goto tt2xr;
                }
                goto Ksf9U;
                yTZl2:
                return PclZip::errorCode();
                goto N3y3q;
                N3y3q:
                tt2xr:
                goto z2tqB;
                z2tqB:
                $v_result_list[$p_options_list[$i]] = true;
                goto HPtEa;
                puAub:
            case PCLZIP_OPT_TEMP_FILE_OFF:
                goto VPKKj;
                VPKKj:
                if (!isset($v_result_list[PCLZIP_OPT_TEMP_FILE_ON])) {
                    goto LCEkm;
                }
                goto OhP9a;
                IGI8d:
                goto tVLCH;
                goto P4M0E;
                H4hAq:
                if (!isset($v_result_list[PCLZIP_OPT_TEMP_FILE_THRESHOLD])) {
                    goto Z8owS;
                }
                goto vrk5N;
                kCB7q:
                return PclZip::errorCode();
                goto cWMjp;
                OhP9a:
                PclZip::privErrorLog(PCLZIP_ERR_INVALID_PARAMETER, "\117\160\164\x69\x6f\x6e\x20\47" . PclZipUtilOptionText($p_options_list[$i]) . "\x27\x20\x63\x61\x6e\x20\x6e\157\x74\x20\x62\145\x20\x75\163\x65\144\x20\167\151\x74\150\x20\x6f\x70\164\x69\157\x6e\40\47\x50\103\x4c\x5a\111\120\137\x4f\120\x54\137\124\105\115\120\x5f\106\x49\114\105\x5f\x4f\116\47");
                goto kCB7q;
                cWMjp:
                LCEkm:
                goto H4hAq;
                uwtPY:
                $v_result_list[$p_options_list[$i]] = true;
                goto IGI8d;
                vrk5N:
                PclZip::privErrorLog(PCLZIP_ERR_INVALID_PARAMETER, "\x4f\x70\x74\151\x6f\156\x20\x27" . PclZipUtilOptionText($p_options_list[$i]) . "\47\x20\143\141\x6e\40\156\157\164\40\142\145\40\x75\x73\145\x64\x20\167\x69\164\150\x20\x6f\160\x74\x69\x6f\156\40\47\120\103\x4c\x5a\111\x50\137\117\120\x54\137\124\105\115\x50\137\106\x49\x4c\x45\x5f\124\x48\122\105\x53\110\x4f\114\x44\x27");
                goto CEMBl;
                CEMBl:
                return PclZip::errorCode();
                goto CXFuM;
                CXFuM:
                Z8owS:
                goto uwtPY;
                P4M0E:
            case PCLZIP_OPT_EXTRACT_DIR_RESTRICTION:
                goto hQspj;
                Ththq:
                cH56M:
                goto U0k3K;
                dh9BY:
                goto cH56M;
                goto LFnxo;
                hQspj:
                if (!($i + 1 >= $p_size)) {
                    goto D_mR1;
                }
                goto czlG4;
                czlG4:
                PclZip::privErrorLog(PCLZIP_ERR_MISSING_OPTION_VALUE, "\x4d\x69\163\163\x69\156\x67\40\x70\141\162\x61\155\x65\x74\145\162\x20\x76\141\x6c\165\145\x20\x66\157\162\x20\157\x70\x74\151\157\156\x20\x27" . PclZipUtilOptionText($p_options_list[$i]) . "\47");
                goto DapvM;
                umrcn:
                $i++;
                goto Ththq;
                noBiX:
                D_mR1:
                goto YLC1x;
                U0k3K:
                goto tVLCH;
                goto jfYCR;
                YLC1x:
                if (is_string($p_options_list[$i + 1]) && $p_options_list[$i + 1] != '') {
                    goto nM5DO;
                }
                goto dh9BY;
                LFnxo:
                nM5DO:
                goto rJAJ1;
                rJAJ1:
                $v_result_list[$p_options_list[$i]] = PclZipUtilTranslateWinPath($p_options_list[$i + 1], false);
                goto umrcn;
                DapvM:
                return PclZip::errorCode();
                goto noBiX;
                jfYCR:
            case PCLZIP_OPT_BY_NAME:
                goto i3Tra;
                ho_0m:
                return PclZip::errorCode();
                goto OnrwW;
                BKnUM:
                goto LoZ1i;
                goto pzsiv;
                rjOI3:
                XPZRH:
                goto RwZtX;
                MVhqC:
                if (is_array($p_options_list[$i + 1])) {
                    goto XPZRH;
                }
                goto AGKRK;
                r4hGI:
                goto tVLCH;
                goto wcZrx;
                Kadi3:
                goto LoZ1i;
                goto rjOI3;
                RwZtX:
                $v_result_list[$p_options_list[$i]] = $p_options_list[$i + 1];
                goto MNLKl;
                QMZ8w:
                $i++;
                goto r4hGI;
                KTL5r:
                if (is_string($p_options_list[$i + 1])) {
                    goto iygJD;
                }
                goto MVhqC;
                AGKRK:
                PclZip::privErrorLog(PCLZIP_ERR_INVALID_OPTION_VALUE, "\127\x72\157\x6e\x67\x20\160\x61\x72\x61\155\x65\164\145\162\x20\x76\x61\154\x75\145\x20\x66\157\162\x20\157\x70\164\x69\157\x6e\40\47" . PclZipUtilOptionText($p_options_list[$i]) . "\x27");
                goto CaY0Q;
                GkKPR:
                PclZip::privErrorLog(PCLZIP_ERR_MISSING_OPTION_VALUE, "\115\x69\x73\x73\x69\156\x67\40\x70\x61\162\x61\155\145\x74\145\x72\x20\x76\141\154\165\145\40\x66\157\x72\x20\x6f\x70\164\x69\157\156\x20\47" . PclZipUtilOptionText($p_options_list[$i]) . "\x27");
                goto ho_0m;
                SkjOc:
                $v_result_list[$p_options_list[$i]][0] = $p_options_list[$i + 1];
                goto Kadi3;
                i3Tra:
                if (!($i + 1 >= $p_size)) {
                    goto V011G;
                }
                goto GkKPR;
                CaY0Q:
                return PclZip::errorCode();
                goto BKnUM;
                pzsiv:
                iygJD:
                goto SkjOc;
                MNLKl:
                LoZ1i:
                goto QMZ8w;
                OnrwW:
                V011G:
                goto KTL5r;
                wcZrx:
            case PCLZIP_OPT_BY_EREG:
                $p_options_list[$i] = PCLZIP_OPT_BY_PREG;
            case PCLZIP_OPT_BY_PREG:
                goto cQWEm;
                nArrA:
                if (is_string($p_options_list[$i + 1])) {
                    goto H1ihy;
                }
                goto GmTSg;
                iB59v:
                return PclZip::errorCode();
                goto Bz1Id;
                vRhjZ:
                goto WdJGz;
                goto ZbpS5;
                mAI4a:
                $i++;
                goto kf8Xz;
                kf8Xz:
                goto tVLCH;
                goto Ks_ZL;
                c337B:
                $v_result_list[$p_options_list[$i]] = $p_options_list[$i + 1];
                goto p3nNM;
                Q_WAw:
                PclZip::privErrorLog(PCLZIP_ERR_MISSING_OPTION_VALUE, "\x4d\151\163\163\x69\x6e\x67\x20\x70\x61\x72\141\x6d\145\164\x65\162\40\x76\x61\154\165\145\40\x66\x6f\162\x20\157\x70\164\151\157\x6e\x20\x27" . PclZipUtilOptionText($p_options_list[$i]) . "\47");
                goto iB59v;
                ZbpS5:
                H1ihy:
                goto c337B;
                n3wVu:
                return PclZip::errorCode();
                goto vRhjZ;
                Bz1Id:
                z6586:
                goto nArrA;
                cQWEm:
                if (!($i + 1 >= $p_size)) {
                    goto z6586;
                }
                goto Q_WAw;
                GmTSg:
                PclZip::privErrorLog(PCLZIP_ERR_INVALID_OPTION_VALUE, "\x57\162\x6f\156\147\40\160\x61\x72\141\x6d\145\x74\145\x72\x20\x76\x61\154\x75\145\40\146\x6f\x72\x20\157\x70\164\x69\157\x6e\x20\x27" . PclZipUtilOptionText($p_options_list[$i]) . "\47");
                goto n3wVu;
                p3nNM:
                WdJGz:
                goto mAI4a;
                Ks_ZL:
            case PCLZIP_OPT_COMMENT:
            case PCLZIP_OPT_ADD_COMMENT:
            case PCLZIP_OPT_PREPEND_COMMENT:
                goto uuYsb;
                T0VVR:
                A1Va1:
                goto l0ggV;
                KwCOu:
                return PclZip::errorCode();
                goto I8xkX;
                WkIWN:
                goto tVLCH;
                goto k03NQ;
                Lkdn8:
                if (is_string($p_options_list[$i + 1])) {
                    goto A1Va1;
                }
                goto ya7hG;
                l0ggV:
                $v_result_list[$p_options_list[$i]] = $p_options_list[$i + 1];
                goto fjrxq;
                fjrxq:
                oFceY:
                goto UFbkx;
                I8xkX:
                ihDOa:
                goto Lkdn8;
                p7t4p:
                goto oFceY;
                goto T0VVR;
                UFbkx:
                $i++;
                goto WkIWN;
                KOEO8:
                PclZip::privErrorLog(PCLZIP_ERR_MISSING_OPTION_VALUE, "\115\x69\x73\x73\x69\x6e\x67\40\160\x61\162\141\x6d\145\x74\x65\162\40\166\141\154\x75\145\40\x66\157\x72\x20\157\160\164\x69\157\156\40\x27" . PclZipUtilOptionText($p_options_list[$i]) . "\x27");
                goto KwCOu;
                ya7hG:
                PclZip::privErrorLog(PCLZIP_ERR_INVALID_OPTION_VALUE, "\127\x72\x6f\x6e\x67\x20\160\141\162\x61\155\x65\x74\145\x72\40\166\x61\154\165\x65\x20\x66\157\162\x20\157\160\x74\x69\x6f\x6e\40\47" . PclZipUtilOptionText($p_options_list[$i]) . "\x27");
                goto ZPbWN;
                uuYsb:
                if (!($i + 1 >= $p_size)) {
                    goto ihDOa;
                }
                goto KOEO8;
                ZPbWN:
                return PclZip::errorCode();
                goto p7t4p;
                k03NQ:
            case PCLZIP_OPT_BY_INDEX:
                goto tWHvw;
                t7nmJ:
                if ($v_size_item_list == 2) {
                    goto phOTy;
                }
                goto L2sy8;
                z_bWw:
                return PclZip::errorCode();
                goto RsPLh;
                vLt9f:
                $v_result_list[$p_options_list[$i]][$j]["\x73\164\x61\162\x74"] = $v_item_list[0];
                goto Kr3SB;
                g2iXQ:
                if (is_string($p_options_list[$i + 1])) {
                    goto CFs3c;
                }
                goto YIczV;
                ZK88R:
                goto jeCCv;
                goto uZyCY;
                GqdU2:
                Rryj4:
                goto ENdSV;
                IpeDF:
                $v_sort_value = $v_result_list[$p_options_list[$i]][$j]["\x73\164\x61\162\x74"];
                goto hdzsW;
                hdzsW:
                IpLEq:
                goto B80r6;
                tWHvw:
                if (!($i + 1 >= $p_size)) {
                    goto nplX5;
                }
                goto SWbCk;
                YIczV:
                if (is_integer($p_options_list[$i + 1])) {
                    goto o28et;
                }
                goto DenUs;
                DSYHp:
                goto Rryj4;
                goto ZIHcF;
                avIhm:
                CFs3c:
                goto ftOAi;
                Kr3SB:
                $v_result_list[$p_options_list[$i]][$j]["\145\x6e\x64"] = $v_item_list[0];
                goto ZK88R;
                nyilc:
                $v_size_item_list = sizeof($v_item_list);
                goto u083k;
                kWCo7:
                goto jeCCv;
                goto wkNGA;
                L2sy8:
                PclZip::privErrorLog(PCLZIP_ERR_INVALID_OPTION_VALUE, "\x54\157\x6f\40\155\141\x6e\171\40\166\x61\154\165\x65\x73\x20\151\x6e\x20\x69\x6e\x64\x65\170\x20\162\x61\156\x67\x65\40\146\x6f\162\x20\x6f\160\164\x69\157\x6e\x20\x27" . PclZipUtilOptionText($p_options_list[$i]) . "\47");
                goto Loey3;
                VJ32X:
                $v_work_list = explode("\54", $p_options_list[$i + 1]);
                goto c5I_i;
                BQAFl:
                goto tVLCH;
                goto z8POO;
                Oayhq:
                $v_sort_flag = false;
                goto S8Zld;
                wkNGA:
                WgdjJ:
                goto vLt9f;
                QAFpV:
                PclZip::privErrorLog(PCLZIP_ERR_INVALID_OPTION_VALUE, "\x49\x6e\x76\x61\x6c\151\144\40\157\x72\144\x65\x72\40\157\146\x20\x69\x6e\x64\x65\x78\x20\x72\141\156\147\145\40\x66\157\162\40\x6f\x70\164\x69\x6f\x6e\40\x27" . PclZipUtilOptionText($p_options_list[$i]) . "\x27");
                goto uZnOS;
                eKcvV:
                jeCCv:
                goto ovPI3;
                wthPP:
                goto tX6O_;
                goto avIhm;
                B80r6:
                $j++;
                goto DSYHp;
                Mw2FR:
                $v_result_list[$p_options_list[$i]][$j]["\163\x74\x61\x72\x74"] = $v_item_list[0];
                goto xT7BV;
                pYzVC:
                yHe7O:
                goto CVie8;
                HkgOG:
                goto tX6O_;
                goto pYzVC;
                ENdSV:
                if (!($j < sizeof($v_work_list))) {
                    goto G2DZh;
                }
                goto bJ7RV;
                ZIHcF:
                G2DZh:
                goto SJKje;
                DenUs:
                if (is_array($p_options_list[$i + 1])) {
                    goto yHe7O;
                }
                goto itZZ4;
                c5I_i:
                goto tX6O_;
                goto VW6D0;
                FUQha:
                tX6O_:
                goto Oayhq;
                J0uXw:
                return PclZip::errorCode();
                goto wthPP;
                bJ7RV:
                $v_item_list = explode("\55", $v_work_list[$j]);
                goto nyilc;
                WqkP4:
                ak3N_:
                goto WEw_U;
                ftOAi:
                $p_options_list[$i + 1] = strtr($p_options_list[$i + 1], "\x20", '');
                goto VJ32X;
                itZZ4:
                PclZip::privErrorLog(PCLZIP_ERR_INVALID_OPTION_VALUE, "\x56\x61\x6c\165\x65\x20\x6d\x75\x73\x74\x20\x62\x65\40\151\156\x74\145\147\x65\x72\54\40\x73\x74\162\151\x6e\147\40\157\162\40\141\162\162\141\x79\40\x66\x6f\x72\40\x6f\160\164\151\x6f\156\40\47" . PclZipUtilOptionText($p_options_list[$i]) . "\47");
                goto J0uXw;
                SJKje:
                if (!$v_sort_flag) {
                    goto ak3N_;
                }
                goto WqkP4;
                CVie8:
                $v_work_list = $p_options_list[$i + 1];
                goto FUQha;
                SWbCk:
                PclZip::privErrorLog(PCLZIP_ERR_MISSING_OPTION_VALUE, "\115\x69\x73\163\151\156\x67\40\160\x61\162\x61\155\145\164\x65\x72\x20\166\141\x6c\x75\145\x20\146\x6f\162\40\x6f\160\164\x69\x6f\x6e\x20\x27" . PclZipUtilOptionText($p_options_list[$i]) . "\47");
                goto z_bWw;
                u083k:
                if ($v_size_item_list == 1) {
                    goto WgdjJ;
                }
                goto t7nmJ;
                WV4Oh:
                GIM9x:
                goto IpeDF;
                VW6D0:
                o28et:
                goto xwMTO;
                r4LKV:
                $v_work_list = array();
                goto g2iXQ;
                ovPI3:
                if (!($v_result_list[$p_options_list[$i]][$j]["\x73\x74\x61\162\x74"] < $v_sort_value)) {
                    goto GIM9x;
                }
                goto RTt6z;
                FqBDl:
                $j = 0;
                goto GqdU2;
                xwMTO:
                $v_work_list[0] = $p_options_list[$i + 1] . "\55" . $p_options_list[$i + 1];
                goto HkgOG;
                uZnOS:
                return PclZip::errorCode();
                goto WV4Oh;
                RTt6z:
                $v_sort_flag = true;
                goto QAFpV;
                RsPLh:
                nplX5:
                goto r4LKV;
                S8Zld:
                $v_sort_value = 0;
                goto FqBDl;
                Loey3:
                return PclZip::errorCode();
                goto kWCo7;
                uZyCY:
                phOTy:
                goto Mw2FR;
                xT7BV:
                $v_result_list[$p_options_list[$i]][$j]["\145\x6e\144"] = $v_item_list[1];
                goto eKcvV;
                WEw_U:
                $i++;
                goto BQAFl;
                z8POO:
            case PCLZIP_OPT_REMOVE_ALL_PATH:
            case PCLZIP_OPT_EXTRACT_AS_STRING:
            case PCLZIP_OPT_NO_COMPRESSION:
            case PCLZIP_OPT_EXTRACT_IN_OUTPUT:
            case PCLZIP_OPT_REPLACE_NEWER:
            case PCLZIP_OPT_STOP_ON_ERROR:
                $v_result_list[$p_options_list[$i]] = true;
                goto tVLCH;
            case PCLZIP_OPT_SET_CHMOD:
                goto mYsjC;
                RVLnV:
                $v_result_list[$p_options_list[$i]] = $p_options_list[$i + 1];
                goto xzTgJ;
                bcP8z:
                goto tVLCH;
                goto ERd8v;
                o7xgB:
                return PclZip::errorCode();
                goto ikqS_;
                ikqS_:
                rW8ZF:
                goto RVLnV;
                G84a7:
                PclZip::privErrorLog(PCLZIP_ERR_MISSING_OPTION_VALUE, "\x4d\x69\x73\163\151\156\x67\x20\160\x61\x72\141\155\145\164\145\x72\40\166\x61\154\165\x65\40\x66\157\162\x20\157\x70\x74\x69\157\x6e\40\47" . PclZipUtilOptionText($p_options_list[$i]) . "\x27");
                goto o7xgB;
                mYsjC:
                if (!($i + 1 >= $p_size)) {
                    goto rW8ZF;
                }
                goto G84a7;
                xzTgJ:
                $i++;
                goto bcP8z;
                ERd8v:
            case PCLZIP_CB_PRE_EXTRACT:
            case PCLZIP_CB_POST_EXTRACT:
            case PCLZIP_CB_PRE_ADD:
            case PCLZIP_CB_POST_ADD:
                goto oOl4f;
                NvUJZ:
                $i++;
                goto aBjal;
                p4TfB:
                V_37F:
                goto TP1P0;
                gOpY2:
                return PclZip::errorCode();
                goto p4TfB;
                m282o:
                $v_result_list[$p_options_list[$i]] = $v_function_name;
                goto NvUJZ;
                nHaws:
                if (function_exists($v_function_name)) {
                    goto gMHfO;
                }
                goto yqQZV;
                M9nc_:
                gMHfO:
                goto m282o;
                aBjal:
                goto tVLCH;
                goto UVFaM;
                oOl4f:
                if (!($i + 1 >= $p_size)) {
                    goto V_37F;
                }
                goto hb4tf;
                TP1P0:
                $v_function_name = $p_options_list[$i + 1];
                goto nHaws;
                ilH_q:
                return PclZip::errorCode();
                goto M9nc_;
                yqQZV:
                PclZip::privErrorLog(PCLZIP_ERR_INVALID_OPTION_VALUE, "\x46\165\156\x63\164\151\157\156\40\47" . $v_function_name . "\x28\51\47\x20\x69\163\x20\x6e\x6f\x74\40\x61\x6e\40\145\x78\151\x73\x74\x69\156\147\x20\146\165\156\x63\164\x69\157\156\40\146\157\x72\40\157\x70\x74\151\x6f\156\x20\x27" . PclZipUtilOptionText($p_options_list[$i]) . "\47");
                goto ilH_q;
                hb4tf:
                PclZip::privErrorLog(PCLZIP_ERR_MISSING_OPTION_VALUE, "\115\x69\x73\163\x69\x6e\147\x20\160\x61\x72\x61\x6d\x65\164\x65\162\40\x76\x61\154\x75\145\x20\146\157\x72\40\x6f\x70\164\x69\x6f\x6e\x20\x27" . PclZipUtilOptionText($p_options_list[$i]) . "\x27");
                goto gOpY2;
                UVFaM:
            default:
                PclZip::privErrorLog(PCLZIP_ERR_INVALID_PARAMETER, "\125\156\x6b\x6e\x6f\x77\156\x20\x70\x61\x72\x61\x6d\145\164\145\162\x20\x27" . $p_options_list[$i] . "\47");
                return PclZip::errorCode();
        }
        goto YpsBY;
        O2LUM:
        plE81:
        goto O1N7l;
        jnJhp:
        MPntC:
        goto wUczy;
        YpsBY:
        Vu_y8:
        goto BQrXt;
        BQrXt:
        tVLCH:
        goto uz1d2;
        XjDck:
        C0mvS:
        goto MRv6f;
        wUczy:
        if (!($i < $p_size)) {
            goto RWHD9;
        }
        goto GcljU;
        CzzQE:
        goto jOHiQ;
        goto gq9wR;
        T1u7w:
        wX63e:
        goto TkFMM;
        cZsVc:
        $i = 0;
        goto jnJhp;
        TAl8k:
        LQwOH:
        goto T1u7w;
        X4mHA:
        jOHiQ:
        goto zTdPR;
        KUppe:
        if (!($v_requested_options[$key] == "\155\141\x6e\144\x61\x74\x6f\162\171")) {
            goto wX63e;
        }
        goto Tj14w;
        GXAxL:
    }
    public function privOptionDefaultThreshold(&$p_options)
    {
        goto ot8Uz;
        M84De:
        if (!($last == "\x6b")) {
            goto ySegF;
        }
        goto qjmKg;
        fJuiM:
        tmRLf:
        goto m7l2j;
        uuy3u:
        if (!(isset($p_options[PCLZIP_OPT_TEMP_FILE_THRESHOLD]) || isset($p_options[PCLZIP_OPT_TEMP_FILE_OFF]))) {
            goto tmRLf;
        }
        goto BtABU;
        ot8Uz:
        $v_result = 1;
        goto uuy3u;
        OMq8g:
        if (!($last == "\x67")) {
            goto nvSB1;
        }
        goto K2fQz;
        Zp5ui:
        unset($p_options[PCLZIP_OPT_TEMP_FILE_THRESHOLD]);
        goto ZXq3T;
        lhXxx:
        return $v_result;
        goto Olz_d;
        qjmKg:
        $v_memory_limit = $v_memory_limit * 1024;
        goto eluzR;
        IoP5S:
        if (!($p_options[PCLZIP_OPT_TEMP_FILE_THRESHOLD] < 1048576)) {
            goto jSAWv;
        }
        goto Zp5ui;
        eluzR:
        ySegF:
        goto ogWUX;
        JmTDM:
        $v_memory_limit = $v_memory_limit * 1048576;
        goto BedUD;
        V08Ax:
        $v_memory_limit = trim($v_memory_limit);
        goto Cu6PR;
        BedUD:
        gj2Wr:
        goto M84De;
        IjqlD:
        if (!($last == "\x6d")) {
            goto gj2Wr;
        }
        goto JmTDM;
        ay1Bs:
        nvSB1:
        goto IjqlD;
        ogWUX:
        $p_options[PCLZIP_OPT_TEMP_FILE_THRESHOLD] = floor($v_memory_limit * PCLZIP_TEMPORARY_FILE_RATIO);
        goto IoP5S;
        K2fQz:
        $v_memory_limit = $v_memory_limit * 1073741824;
        goto ay1Bs;
        Cu6PR:
        $last = strtolower(substr($v_memory_limit, -1));
        goto OMq8g;
        BtABU:
        return $v_result;
        goto fJuiM;
        ZXq3T:
        jSAWv:
        goto lhXxx;
        m7l2j:
        $v_memory_limit = ini_get("\155\x65\155\157\162\x79\x5f\x6c\x69\x6d\151\164");
        goto V08Ax;
        Olz_d:
    }
    public function privFileDescrParseAtt(&$p_file_list, &$p_filedescr, $v_options, $v_requested_options = false)
    {
        goto D16Rt;
        G8f5G:
        return $v_result;
        goto h_Oqu;
        rsbth:
        foreach ($p_file_list as $v_key => $v_value) {
            goto tiBOT;
            gliP0:
            kgc3A:
            goto aZn6O;
            quav7:
            if (!($v_requested_options !== false)) {
                goto b4O5V;
            }
            goto l3AGA;
            z2BzU:
            At0qR:
            goto QDQD7;
            l3AGA:
            $key = reset($v_requested_options);
            goto gliP0;
            BGHXm:
            SWfoR:
            goto z2BzU;
            sRM1W:
            ltWS6:
            goto TdnGY;
            UAbGi:
            PclZip::privErrorLog(PCLZIP_ERR_INVALID_PARAMETER, "\115\151\x73\163\151\156\147\40\155\x61\x6e\144\141\x74\157\x72\171\40\x70\x61\162\141\155\x65\164\145\162\40" . PclZipUtilOptionText($key) . "\x28" . $key . "\x29");
            goto Cftxu;
            JW1bL:
            yZ3Ki:
            goto BGHXm;
            f2yB3:
            gmfbU:
            goto quav7;
            tiBOT:
            if (isset($v_requested_options[$v_key])) {
                goto LWG4s;
            }
            goto Z70fE;
            X2qo9:
            return PclZip::errorCode();
            goto TBEkB;
            Cftxu:
            return PclZip::errorCode();
            goto JW1bL;
            dnOGB:
            goto kgc3A;
            goto sRM1W;
            QDQD7:
            $key = next($v_requested_options);
            goto dnOGB;
            c7qqA:
            gQdb2:
            goto RZILJ;
            TBEkB:
            LWG4s:
            goto Nixm2;
            Lt4sz:
            if (isset($p_file_list[$key])) {
                goto yZ3Ki;
            }
            goto UAbGi;
            Nixm2:
            switch ($v_key) {
                case PCLZIP_ATT_FILE_NAME:
                    goto MRWlT;
                    MRWlT:
                    if (is_string($v_value)) {
                        goto gQfKr;
                    }
                    goto at0jO;
                    FAYrb:
                    goto gmfbU;
                    goto tYyhr;
                    u426Q:
                    if (!($p_filedescr["\x66\151\154\x65\156\x61\155\x65"] == '')) {
                        goto Rvdi4;
                    }
                    goto Y7niX;
                    ev21T:
                    Rvdi4:
                    goto FAYrb;
                    c7q6I:
                    gQfKr:
                    goto YQ9lS;
                    YQ9lS:
                    $p_filedescr["\146\151\x6c\x65\156\141\155\145"] = PclZipUtilPathReduction($v_value);
                    goto u426Q;
                    Y7niX:
                    PclZip::privErrorLog(PCLZIP_ERR_INVALID_ATTRIBUTE_VALUE, "\111\156\166\141\x6c\x69\144\40\x65\x6d\160\x74\x79\40\x66\x69\154\145\x6e\141\x6d\145\40\146\x6f\162\x20\141\x74\x74\162\151\x62\x75\x74\145\x20\x27" . PclZipUtilOptionText($v_key) . "\47");
                    goto GDvq8;
                    at0jO:
                    PclZip::privErrorLog(PCLZIP_ERR_INVALID_ATTRIBUTE_VALUE, "\x49\156\x76\141\154\x69\x64\40\x74\x79\160\145\40" . gettype($v_value) . "\x2e\40\x53\x74\x72\151\156\x67\40\145\x78\160\x65\143\164\145\x64\x20\x66\157\x72\40\x61\x74\164\162\x69\142\x75\x74\145\x20\x27" . PclZipUtilOptionText($v_key) . "\x27");
                    goto pNodv;
                    GDvq8:
                    return PclZip::errorCode();
                    goto ev21T;
                    pNodv:
                    return PclZip::errorCode();
                    goto c7q6I;
                    tYyhr:
                case PCLZIP_ATT_FILE_NEW_SHORT_NAME:
                    goto wcuny;
                    szUDg:
                    gVfFW:
                    goto knik2;
                    PME4X:
                    goto gmfbU;
                    goto TqASx;
                    wcuny:
                    if (is_string($v_value)) {
                        goto gVfFW;
                    }
                    goto FgOs_;
                    l8DQx:
                    return PclZip::errorCode();
                    goto szUDg;
                    FgOs_:
                    PclZip::privErrorLog(PCLZIP_ERR_INVALID_ATTRIBUTE_VALUE, "\111\x6e\166\141\x6c\x69\144\40\164\x79\x70\145\40" . gettype($v_value) . "\x2e\x20\123\164\162\x69\x6e\147\40\x65\x78\160\145\x63\164\145\144\40\x66\x6f\162\40\141\x74\x74\x72\151\142\x75\164\145\x20\x27" . PclZipUtilOptionText($v_key) . "\47");
                    goto l8DQx;
                    l1isG:
                    return PclZip::errorCode();
                    goto GqiMG;
                    GqiMG:
                    odK4e:
                    goto PME4X;
                    LC6ee:
                    if (!($p_filedescr["\x6e\x65\x77\x5f\163\150\x6f\x72\x74\x5f\x6e\141\155\x65"] == '')) {
                        goto odK4e;
                    }
                    goto UJ6rm;
                    knik2:
                    $p_filedescr["\156\145\x77\137\x73\150\x6f\162\x74\137\x6e\x61\155\x65"] = PclZipUtilPathReduction($v_value);
                    goto LC6ee;
                    UJ6rm:
                    PclZip::privErrorLog(PCLZIP_ERR_INVALID_ATTRIBUTE_VALUE, "\x49\156\166\141\x6c\151\x64\40\x65\x6d\x70\x74\171\x20\x73\x68\157\162\164\x20\146\x69\154\x65\156\141\x6d\145\x20\x66\157\x72\x20\x61\164\164\162\x69\142\x75\x74\x65\x20\47" . PclZipUtilOptionText($v_key) . "\47");
                    goto l1isG;
                    TqASx:
                case PCLZIP_ATT_FILE_NEW_FULL_NAME:
                    goto Srl2a;
                    qvhxU:
                    PclZip::privErrorLog(PCLZIP_ERR_INVALID_ATTRIBUTE_VALUE, "\x49\156\166\141\x6c\151\144\x20\145\155\160\x74\171\x20\146\x75\x6c\x6c\x20\146\x69\x6c\145\x6e\x61\x6d\x65\40\146\x6f\162\x20\x61\164\164\x72\x69\142\165\x74\145\40\x27" . PclZipUtilOptionText($v_key) . "\47");
                    goto GDp3d;
                    Jf7UZ:
                    return PclZip::errorCode();
                    goto naJBg;
                    t1tyB:
                    PclZip::privErrorLog(PCLZIP_ERR_INVALID_ATTRIBUTE_VALUE, "\x49\x6e\166\x61\x6c\151\144\x20\164\171\x70\x65\40" . gettype($v_value) . "\56\40\x53\x74\162\151\x6e\147\x20\145\170\160\145\x63\x74\x65\x64\40\146\157\x72\x20\141\164\x74\x72\x69\x62\165\x74\145\40\47" . PclZipUtilOptionText($v_key) . "\47");
                    goto Jf7UZ;
                    ejTjt:
                    goto gmfbU;
                    goto ZK97d;
                    GDp3d:
                    return PclZip::errorCode();
                    goto WIS0u;
                    VXvMp:
                    if (!($p_filedescr["\x6e\x65\167\137\x66\165\x6c\x6c\137\x6e\141\x6d\x65"] == '')) {
                        goto ZI7uC;
                    }
                    goto qvhxU;
                    WIS0u:
                    ZI7uC:
                    goto ejTjt;
                    Srl2a:
                    if (is_string($v_value)) {
                        goto MRN1e;
                    }
                    goto t1tyB;
                    blPu9:
                    $p_filedescr["\x6e\x65\x77\x5f\146\x75\x6c\154\137\x6e\141\155\x65"] = PclZipUtilPathReduction($v_value);
                    goto VXvMp;
                    naJBg:
                    MRN1e:
                    goto blPu9;
                    ZK97d:
                case PCLZIP_ATT_FILE_COMMENT:
                    goto gkDRZ;
                    M63hU:
                    $p_filedescr["\x63\x6f\x6d\155\x65\156\164"] = $v_value;
                    goto cjPLF;
                    qyfP4:
                    return PclZip::errorCode();
                    goto iKDo2;
                    cjPLF:
                    goto gmfbU;
                    goto Y1xqP;
                    gkDRZ:
                    if (is_string($v_value)) {
                        goto RqxOl;
                    }
                    goto pF1t2;
                    pF1t2:
                    PclZip::privErrorLog(PCLZIP_ERR_INVALID_ATTRIBUTE_VALUE, "\111\156\x76\x61\154\x69\x64\x20\164\171\x70\145\40" . gettype($v_value) . "\56\x20\123\x74\x72\x69\x6e\147\x20\145\x78\160\145\143\164\145\x64\40\146\x6f\x72\x20\x61\164\x74\x72\151\x62\x75\164\x65\40\47" . PclZipUtilOptionText($v_key) . "\47");
                    goto qyfP4;
                    iKDo2:
                    RqxOl:
                    goto M63hU;
                    Y1xqP:
                case PCLZIP_ATT_FILE_MTIME:
                    goto OcMnu;
                    siWxl:
                    vnoif:
                    goto QhoMw;
                    QhoMw:
                    $p_filedescr["\155\x74\151\155\x65"] = $v_value;
                    goto tknfo;
                    OcMnu:
                    if (is_integer($v_value)) {
                        goto vnoif;
                    }
                    goto PPtHg;
                    PPtHg:
                    PclZip::privErrorLog(PCLZIP_ERR_INVALID_ATTRIBUTE_VALUE, "\111\x6e\166\141\154\x69\x64\x20\x74\x79\160\x65\x20" . gettype($v_value) . "\56\x20\x49\x6e\x74\145\x67\x65\162\40\x65\170\x70\145\x63\164\x65\x64\x20\x66\x6f\162\x20\x61\164\164\x72\151\142\165\x74\x65\x20\47" . PclZipUtilOptionText($v_key) . "\47");
                    goto YAxhv;
                    tknfo:
                    goto gmfbU;
                    goto MuFBI;
                    YAxhv:
                    return PclZip::errorCode();
                    goto siWxl;
                    MuFBI:
                case PCLZIP_ATT_FILE_CONTENT:
                    $p_filedescr["\x63\157\156\x74\145\x6e\164"] = $v_value;
                    goto gmfbU;
                default:
                    PclZip::privErrorLog(PCLZIP_ERR_INVALID_PARAMETER, "\125\x6e\x6b\156\157\x77\x6e\x20\x70\141\162\x61\x6d\x65\164\x65\162\40\x27" . $v_key . "\x27");
                    return PclZip::errorCode();
            }
            goto wvR29;
            i0aFe:
            if (!($v_requested_options[$key] == "\x6d\141\x6e\x64\x61\164\x6f\162\171")) {
                goto SWfoR;
            }
            goto Lt4sz;
            aZn6O:
            if (!($key = key($v_requested_options))) {
                goto ltWS6;
            }
            goto i0aFe;
            wvR29:
            Zm8ZC:
            goto f2yB3;
            Z70fE:
            PclZip::privErrorLog(PCLZIP_ERR_INVALID_PARAMETER, "\x49\x6e\166\x61\x6c\151\x64\40\146\151\x6c\x65\x20\x61\164\x74\x72\151\x62\165\x74\x65\x20\x27" . $v_key . "\47\40\x66\157\x72\x20\164\150\151\x73\x20\x66\151\x6c\x65");
            goto X2qo9;
            TdnGY:
            b4O5V:
            goto c7qqA;
            RZILJ:
        }
        goto F8zE_;
        D16Rt:
        $v_result = 1;
        goto rsbth;
        F8zE_:
        BDx4u:
        goto G8f5G;
        h_Oqu:
    }
    public function privFileDescrExpand(&$p_filedescr_list, &$p_options)
    {
        goto h1VgS;
        Ph5EN:
        k4wcZ:
        goto uJjkR;
        CoQ3D:
        $v_result_list = array();
        goto Uu06f;
        y4u0z:
        $v_descr["\146\151\154\x65\x6e\141\x6d\x65"] = PclZipUtilPathReduction($v_descr["\146\x69\x6c\145\x6e\141\155\x65"]);
        goto fwjWD;
        R0_RD:
        @closedir($v_folder_handler);
        goto hu0aY;
        LII2N:
        if (!($i < sizeof($p_filedescr_list))) {
            goto EhdCT;
        }
        goto dj1Ve;
        VJQx0:
        ei0wg:
        goto a_agI;
        NHAzn:
        P56nN:
        goto Ph5EN;
        OQUFf:
        $v_descr["\164\171\160\x65"] = "\x66\x69\154\145";
        goto NUWgd;
        d25wO:
        Nhxun:
        goto J1P7F;
        HiWgk:
        rWq0u:
        goto R0_RD;
        rBbE_:
        $v_dirlist_nb++;
        goto it2wi;
        yxVL5:
        goto H61GI;
        goto Fcr2g;
        pSieQ:
        if ($v_dirlist_nb != 0) {
            goto B7ajz;
        }
        goto vVBe4;
        pci4O:
        GWfY3:
        goto uRpMH;
        uJjkR:
        $i++;
        goto nAPds;
        KwlcO:
        goto WqU72;
        goto VJQx0;
        h1VgS:
        $v_result = 1;
        goto CoQ3D;
        uRpMH:
        goto k4wcZ;
        goto rM06P;
        j0OE3:
        goto k4wcZ;
        goto yxVL5;
        EolLw:
        WjLpq:
        goto wBeL5;
        Zcr9B:
        if ($v_descr["\x73\x74\x6f\162\x65\x64\137\146\151\x6c\x65\156\x61\155\x65"] != '') {
            goto WjLpq;
        }
        goto GoYWQ;
        TLb67:
        PclZip::privErrorLog(PCLZIP_ERR_MISSING_FILE, "\106\x69\154\x65\x20\x27" . $v_descr["\x66\151\154\x65\156\141\x6d\x65"] . "\47\x20\x64\x6f\145\163\40\156\x6f\164\40\x65\170\x69\163\x74");
        goto s46PP;
        Cvlhc:
        wMBzM:
        goto a5WLF;
        yf7HG:
        if (@is_file($v_descr["\x66\x69\x6c\145\156\x61\155\145"])) {
            goto ZPt2Q;
        }
        goto S5STk;
        a5WLF:
        $v_dirlist_descr[$v_dirlist_nb]["\146\151\x6c\145\x6e\141\x6d\145"] = $v_descr["\x66\x69\x6c\x65\156\x61\x6d\x65"] . "\57" . $v_item_handler;
        goto RjQAx;
        tYfGS:
        if (!($v_descr["\164\x79\160\145"] == "\x66\x6f\x6c\144\x65\x72")) {
            goto P56nN;
        }
        goto UoYFz;
        DlMRO:
        $v_descr["\x74\171\x70\x65"] = "\166\151\x72\164\x75\141\x6c\137\x66\151\154\145";
        goto XwOnP;
        wBeL5:
        $v_dirlist_descr[$v_dirlist_nb]["\x6e\145\167\x5f\146\165\x6c\154\x5f\x6e\x61\155\x65"] = $v_descr["\x73\164\x6f\162\145\144\137\146\151\154\145\x6e\x61\x6d\x65"] . "\57" . $v_item_handler;
        goto dpOY3;
        Fcr2g:
        ZPt2Q:
        goto OQUFf;
        s46PP:
        return PclZip::errorCode();
        goto TEkRE;
        Uu06f:
        $i = 0;
        goto ykBrh;
        S5STk:
        if (@is_dir($v_descr["\146\151\154\145\x6e\x61\x6d\145"])) {
            goto RthGz;
        }
        goto JowGB;
        XwOnP:
        MvygR:
        goto ezMbB;
        PJFZ9:
        $v_dirlist_nb = 0;
        goto w_Z9t;
        fwjWD:
        if (file_exists($v_descr["\x66\151\x6c\x65\156\x61\x6d\x65"])) {
            goto uBCE2;
        }
        goto teinH;
        RjQAx:
        if (!($v_descr["\x73\x74\157\162\145\144\137\x66\151\x6c\145\x6e\141\x6d\145"] != $v_descr["\146\x69\154\145\156\x61\x6d\145"] && !isset($p_options[PCLZIP_OPT_REMOVE_ALL_PATH]))) {
            goto Z3hfU;
        }
        goto Zcr9B;
        vVBe4:
        goto PMsFG;
        goto Uh8LM;
        it2wi:
        goto H6uPC;
        goto HiWgk;
        iVYP7:
        $v_descr["\146\x69\154\x65\156\x61\155\145"] = PclZipUtilTranslateWinPath($v_descr["\146\x69\x6c\145\x6e\141\155\145"], false);
        goto y4u0z;
        dpOY3:
        OsY0k:
        goto yLyZY;
        WC2_Q:
        return $v_result;
        goto Smdcw;
        nAPds:
        goto E6KR4;
        goto GaDZo;
        ftKQM:
        $v_result_list[sizeof($v_result_list)] = $v_descr;
        goto tYfGS;
        fKJ4p:
        goto OsY0k;
        goto EolLw;
        UiulB:
        goto MvygR;
        goto g2zu6;
        bFxZv:
        if (!(($v_result = $this->privFileDescrExpand($v_dirlist_descr, $p_options)) != 1)) {
            goto Nhxun;
        }
        goto kdAjj;
        NUWgd:
        goto H61GI;
        goto ruRX0;
        Uh8LM:
        B7ajz:
        goto bFxZv;
        teinH:
        if (isset($v_descr["\143\157\x6e\164\x65\156\164"])) {
            goto Zzxyx;
        }
        goto TLb67;
        kdAjj:
        return $v_result;
        goto d25wO;
        J1P7F:
        $v_result_list = array_merge($v_result_list, $v_dirlist_descr);
        goto y2VH4;
        JowGB:
        if (@is_link($v_descr["\146\x69\x6c\x65\x6e\141\155\145"])) {
            goto GWfY3;
        }
        goto j0OE3;
        GoYWQ:
        $v_dirlist_descr[$v_dirlist_nb]["\156\145\167\x5f\x66\x75\x6c\154\137\x6e\x61\155\145"] = $v_item_handler;
        goto fKJ4p;
        rM06P:
        H61GI:
        goto UiulB;
        hu0aY:
        WqU72:
        goto pSieQ;
        yLyZY:
        Z3hfU:
        goto rBbE_;
        w_Z9t:
        if ($v_folder_handler = @opendir($v_descr["\x66\x69\x6c\145\x6e\x61\x6d\x65"])) {
            goto ei0wg;
        }
        goto KwlcO;
        XpcWd:
        if (!(($v_item_handler = @readdir($v_folder_handler)) !== false)) {
            goto rWq0u;
        }
        goto Kd67d;
        y2VH4:
        PMsFG:
        goto o6QoQ;
        TEkRE:
        goto MvygR;
        goto i1g4O;
        AlAzN:
        goto H61GI;
        goto pci4O;
        ruRX0:
        RthGz:
        goto A8QID;
        i1g4O:
        uBCE2:
        goto yf7HG;
        A8QID:
        $v_descr["\x74\171\160\145"] = "\x66\157\154\144\x65\162";
        goto AlAzN;
        ykBrh:
        E6KR4:
        goto LII2N;
        BwJIK:
        $p_filedescr_list = $v_result_list;
        goto WC2_Q;
        GaDZo:
        EhdCT:
        goto BwJIK;
        g2zu6:
        Zzxyx:
        goto DlMRO;
        a_agI:
        H6uPC:
        goto XpcWd;
        Kd67d:
        if (!($v_item_handler == "\56" || $v_item_handler == "\56\56")) {
            goto wMBzM;
        }
        goto KuYN_;
        ezMbB:
        $this->privCalculateStoredFilename($v_descr, $p_options);
        goto ftKQM;
        KuYN_:
        goto H6uPC;
        goto Cvlhc;
        o6QoQ:
        unset($v_dirlist_descr);
        goto NHAzn;
        UoYFz:
        $v_dirlist_descr = array();
        goto PJFZ9;
        dj1Ve:
        $v_descr = $p_filedescr_list[$i];
        goto iVYP7;
        Smdcw:
    }
    public function privCreate($p_filedescr_list, &$p_result_list, &$p_options)
    {
        goto p6kpO;
        Vmb2N:
        $this->privSwapBackMagicQuotes();
        goto Y8uEW;
        YHD4D:
        $this->privDisableMagicQuotes();
        goto FQ7OS;
        Wz9nf:
        $v_result = $this->privAddList($p_filedescr_list, $p_result_list, $p_options);
        goto c0POA;
        Y8uEW:
        return $v_result;
        goto kludG;
        FQ7OS:
        if (!(($v_result = $this->privOpenFd("\x77\142")) != 1)) {
            goto TnLoI;
        }
        goto CY2yN;
        CY2yN:
        return $v_result;
        goto RHw_D;
        RHw_D:
        TnLoI:
        goto Wz9nf;
        se_o8:
        $v_list_detail = array();
        goto YHD4D;
        p6kpO:
        $v_result = 1;
        goto se_o8;
        c0POA:
        $this->privCloseFd();
        goto Vmb2N;
        kludG:
    }
    public function privAdd($p_filedescr_list, &$p_result_list, &$p_options)
    {
        goto HjkyO;
        M8tOe:
        j0BeG:
        goto sGS4v;
        kSwPA:
        Azxyp:
        goto iTcOS;
        sGS4v:
        $v_count++;
        goto hGSUg;
        I9RAk:
        $this->privSwapBackMagicQuotes();
        goto zAesG;
        NZgde:
        if (!(($v_zip_temp_fd = @fopen($v_zip_temp_name, "\167\142")) == 0)) {
            goto uEoaO;
        }
        goto J8wtL;
        xUgtO:
        if (!isset($p_options[PCLZIP_OPT_ADD_COMMENT])) {
            goto jMMr4;
        }
        goto RS5Hn;
        lyv_v:
        $this->privSwapBackMagicQuotes();
        goto dl9s_;
        hEN2m:
        $v_header_list = array();
        goto FD9qr;
        kX_Jx:
        $v_comment = $p_options[PCLZIP_OPT_COMMENT];
        goto Fz9ZK;
        k2WL8:
        @fwrite($v_zip_temp_fd, $v_buffer, $v_read_size);
        goto HfVqc;
        JW7eB:
        @fclose($v_zip_temp_fd);
        goto pVu6V;
        PDtHx:
        $this->privCloseFd();
        goto PzQ5M;
        tRznl:
        @fwrite($this->zip_fd, $v_buffer, $v_read_size);
        goto B7O2D;
        mdKCx:
        $v_swap = $this->zip_fd;
        goto DgpSG;
        a8Ypq:
        $v_buffer = @fread($v_zip_temp_fd, $v_read_size);
        goto tRznl;
        wzE5u:
        if (!isset($p_options[PCLZIP_OPT_COMMENT])) {
            goto Xv5hV;
        }
        goto kX_Jx;
        cm9fE:
        if (!($v_size != 0)) {
            goto wS455;
        }
        goto IQc6n;
        HjkyO:
        $v_result = 1;
        goto hjN28;
        cNO7y:
        $v_zip_temp_name = PCLZIP_TEMPORARY_DIR . uniqid("\160\143\x6c\x7a\151\160\x2d") . "\56\x74\x6d\160";
        goto NZgde;
        TIM0I:
        PclZip::privErrorLog(PCLZIP_ERR_READ_OPEN_FAIL, "\x55\x6e\x61\x62\154\145\40\164\x6f\x20\x6f\x70\x65\x6e\40\x74\145\155\160\157\162\141\x72\171\40\146\x69\154\x65\x20\x27" . $v_zip_temp_name . "\47\40\151\x6e\x20\x62\151\x6e\141\x72\x79\x20\x77\x72\151\x74\145\40\155\157\144\145");
        goto Oq1p7;
        aEIaa:
        @unlink($v_zip_temp_name);
        goto EGR3L;
        nADG2:
        $i = 0;
        goto OikvG;
        FZHq8:
        $this->privSwapBackMagicQuotes();
        goto Y7h_U;
        dmXEm:
        fclose($v_zip_temp_fd);
        goto R0pYh;
        Yipti:
        PclZipUtilRename($v_zip_temp_name, $this->zipname);
        goto Sh27A;
        tWT5z:
        if (!(!is_file($this->zipname) || filesize($this->zipname) == 0)) {
            goto Q7qiD;
        }
        goto lMcKX;
        gpdQ5:
        if (!isset($p_options[PCLZIP_OPT_PREPEND_COMMENT])) {
            goto vq8CN;
        }
        goto b5KZY;
        PzQ5M:
        $this->privSwapBackMagicQuotes();
        goto B1IQC;
        hszoI:
        yjA4Z:
        goto UH18b;
        hjN28:
        $v_list_detail = array();
        goto tWT5z;
        F6T7R:
        ebXyl:
        goto tzV_r;
        ttmFG:
        if (!(($v_result = $this->privWriteCentralHeader($v_count + $v_central_dir["\x65\x6e\x74\x72\151\x65\163"], $v_size, $v_offset, $v_comment)) != 1)) {
            goto wATze;
        }
        goto Uf4Ey;
        iTcOS:
        @rewind($this->zip_fd);
        goto cNO7y;
        UKZE_:
        goto jskVZ;
        goto qQPIH;
        b5KZY:
        $v_comment = $p_options[PCLZIP_OPT_PREPEND_COMMENT] . $v_comment;
        goto Mnc3p;
        GxUg8:
        if (!($v_header_list[$i]["\163\164\x61\164\x75\163"] == "\157\x6b")) {
            goto YfZAd;
        }
        goto EVa1m;
        j5NWE:
        $v_central_dir = array();
        goto jVnr4;
        pVu6V:
        $this->privSwapBackMagicQuotes();
        goto uALvb;
        Muu2L:
        $v_size = $v_central_dir["\163\151\x7a\145"];
        goto M3jXC;
        ShK07:
        $this->privCloseFd();
        goto aEIaa;
        qs5jw:
        $v_size = @ftell($this->zip_fd) - $v_offset;
        goto ttmFG;
        B7O2D:
        $v_size -= $v_read_size;
        goto UKZE_;
        N7RxK:
        uEoaO:
        goto fhTpY;
        ktg23:
        $this->privCloseFd();
        goto JW7eB;
        Mnc3p:
        vq8CN:
        goto qs5jw;
        AWKvi:
        SshW1:
        goto j5NWE;
        OU3Wp:
        Q7qiD:
        goto ytz0r;
        ZWKma:
        if (!($i < sizeof($v_header_list))) {
            goto ebXyl;
        }
        goto GxUg8;
        q44Vh:
        if (!(($v_result = $this->privOpenFd("\162\x62")) != 1)) {
            goto SshW1;
        }
        goto I9RAk;
        sC9l0:
        goto vJLpP;
        goto F6T7R;
        hGSUg:
        YfZAd:
        goto ZLj0i;
        J8wtL:
        $this->privCloseFd();
        goto mAQpK;
        TTt2B:
        goto kM32c;
        goto Iyetq;
        EGR3L:
        $this->privSwapBackMagicQuotes();
        goto hWqC0;
        M3jXC:
        jskVZ:
        goto cm9fE;
        sf4_R:
        return $v_result;
        goto OU3Wp;
        B1IQC:
        return $v_result;
        goto kSwPA;
        tzV_r:
        $v_comment = $v_central_dir["\143\x6f\x6d\x6d\x65\x6e\x74"];
        goto wzE5u;
        R0pYh:
        $this->privCloseFd();
        goto sd8L2;
        VoORQ:
        vJLpP:
        goto ZWKma;
        HfVqc:
        $v_size -= $v_read_size;
        goto TTt2B;
        ME3EU:
        $v_zip_temp_fd = $v_swap;
        goto ktg23;
        mEMq8:
        $v_zip_temp_fd = $v_swap;
        goto hEN2m;
        sd8L2:
        @unlink($v_zip_temp_name);
        goto lyv_v;
        UH18b:
        $i++;
        goto sC9l0;
        hWqC0:
        return $v_result;
        goto M8tOe;
        IQc6n:
        $v_read_size = $v_size < PCLZIP_READ_BLOCK_SIZE ? $v_size : PCLZIP_READ_BLOCK_SIZE;
        goto a8Ypq;
        ZLj0i:
        $this->privConvertHeader2FileInfo($v_header_list[$i], $p_result_list[$i]);
        goto hszoI;
        Y7h_U:
        return $v_result;
        goto VIpGX;
        Fz9ZK:
        Xv5hV:
        goto xUgtO;
        Oq1p7:
        return PclZip::errorCode();
        goto N7RxK;
        mAQpK:
        $this->privSwapBackMagicQuotes();
        goto TIM0I;
        FD9qr:
        if (!(($v_result = $this->privAddFileList($p_filedescr_list, $v_header_list, $p_options)) != 1)) {
            goto RNiA6;
        }
        goto dmXEm;
        fhTpY:
        $v_size = $v_central_dir["\x6f\146\x66\x73\145\164"];
        goto UnQMA;
        uALvb:
        @unlink($this->zipname);
        goto Yipti;
        zUOug:
        $v_buffer = fread($this->zip_fd, $v_read_size);
        goto k2WL8;
        Sh27A:
        return $v_result;
        goto T0Shf;
        UnQMA:
        kM32c:
        goto RotQ5;
        SPqNd:
        fclose($v_zip_temp_fd);
        goto ShK07;
        EVa1m:
        if (!(($v_result = $this->privWriteCentralFileHeader($v_header_list[$i])) != 1)) {
            goto j0BeG;
        }
        goto SPqNd;
        jVnr4:
        if (!(($v_result = $this->privReadEndCentralDir($v_central_dir)) != 1)) {
            goto Azxyp;
        }
        goto PDtHx;
        OikvG:
        $v_count = 0;
        goto VoORQ;
        dl9s_:
        return $v_result;
        goto X7FhN;
        wvfkf:
        $v_offset = @ftell($this->zip_fd);
        goto Muu2L;
        zAesG:
        return $v_result;
        goto AWKvi;
        RotQ5:
        if (!($v_size != 0)) {
            goto NkZjR;
        }
        goto aRcGo;
        Iyetq:
        NkZjR:
        goto v_SpI;
        aRcGo:
        $v_read_size = $v_size < PCLZIP_READ_BLOCK_SIZE ? $v_size : PCLZIP_READ_BLOCK_SIZE;
        goto zUOug;
        lMcKX:
        $v_result = $this->privCreate($p_filedescr_list, $p_result_list, $p_options);
        goto sf4_R;
        X7FhN:
        RNiA6:
        goto wvfkf;
        v_SpI:
        $v_swap = $this->zip_fd;
        goto xjFMk;
        RS5Hn:
        $v_comment = $v_comment . $p_options[PCLZIP_OPT_ADD_COMMENT];
        goto M3zCW;
        M3zCW:
        jMMr4:
        goto gpdQ5;
        qQPIH:
        wS455:
        goto nADG2;
        Uf4Ey:
        unset($v_header_list);
        goto FZHq8;
        VIpGX:
        wATze:
        goto mdKCx;
        DgpSG:
        $this->zip_fd = $v_zip_temp_fd;
        goto ME3EU;
        xjFMk:
        $this->zip_fd = $v_zip_temp_fd;
        goto mEMq8;
        ytz0r:
        $this->privDisableMagicQuotes();
        goto q44Vh;
        T0Shf:
    }
    public function privOpenFd($p_mode)
    {
        goto rbtPv;
        NXvwZ:
        PclZip::privErrorLog(PCLZIP_ERR_READ_OPEN_FAIL, "\x55\x6e\x61\142\x6c\145\x20\164\x6f\x20\x6f\160\145\x6e\x20\x61\x72\x63\x68\x69\166\145\40\47" . $this->zipname . "\x27\x20\151\x6e\x20" . $p_mode . "\x20\155\157\x64\145");
        goto zGr6d;
        qittg:
        return $v_result;
        goto SQjHR;
        caSGO:
        return PclZip::errorCode();
        goto yAnqK;
        iCSPL:
        pZCk3:
        goto qittg;
        rbtPv:
        $v_result = 1;
        goto sgty0;
        i8b3o:
        PclZip::privErrorLog(PCLZIP_ERR_READ_OPEN_FAIL, "\x5a\x69\x70\40\x66\151\x6c\x65\x20\47" . $this->zipname . "\47\x20\141\x6c\162\x65\x61\x64\x79\x20\x6f\x70\145\156");
        goto caSGO;
        sgty0:
        if (!($this->zip_fd != 0)) {
            goto LE6hD;
        }
        goto i8b3o;
        yAnqK:
        LE6hD:
        goto Ya7Ad;
        Ya7Ad:
        if (!(($this->zip_fd = @fopen($this->zipname, $p_mode)) == 0)) {
            goto pZCk3;
        }
        goto NXvwZ;
        zGr6d:
        return PclZip::errorCode();
        goto iCSPL;
        SQjHR:
    }
    public function privCloseFd()
    {
        goto eItZ0;
        om5Sf:
        return $v_result;
        goto Jhrfv;
        NFPVk:
        $this->zip_fd = 0;
        goto om5Sf;
        eItZ0:
        $v_result = 1;
        goto O77N2;
        O77N2:
        if (!($this->zip_fd != 0)) {
            goto JLdDp;
        }
        goto QkPoQ;
        Xd2yz:
        JLdDp:
        goto NFPVk;
        QkPoQ:
        @fclose($this->zip_fd);
        goto Xd2yz;
        Jhrfv:
    }
    public function privAddList($p_filedescr_list, &$p_result_list, &$p_options)
    {
        goto km1dq;
        Vz3En:
        if (!($i < sizeof($v_header_list))) {
            goto v31bJ;
        }
        goto SPsIU;
        jNOwv:
        goto BGuXI;
        goto DbsUA;
        AymnC:
        if (!(($v_result = $this->privAddFileList($p_filedescr_list, $v_header_list, $p_options)) != 1)) {
            goto T0Xoe;
        }
        goto sdaMb;
        EhUI9:
        return $v_result;
        goto oXtDt;
        eg8wV:
        $i++;
        goto jNOwv;
        km1dq:
        $v_result = 1;
        goto jEFST;
        jEFST:
        $v_header_list = array();
        goto AymnC;
        SOH48:
        return $v_result;
        goto cxi4c;
        pV_XO:
        unset($v_header_list);
        goto SOH48;
        vvT9E:
        if (!(($v_result = $this->privWriteCentralFileHeader($v_header_list[$i])) != 1)) {
            goto CWPPQ;
        }
        goto KyT4Y;
        B5GZF:
        CWPPQ:
        goto lvXw2;
        wf141:
        R_hf7:
        goto eg8wV;
        BeloE:
        $v_comment = '';
        goto KHwSO;
        lvXw2:
        $v_count++;
        goto E1gJV;
        fCniY:
        $v_offset = @ftell($this->zip_fd);
        goto VfFe5;
        KyT4Y:
        return $v_result;
        goto B5GZF;
        E1gJV:
        AcR3e:
        goto cvLOT;
        bPjnt:
        $v_comment = $p_options[PCLZIP_OPT_COMMENT];
        goto sxQ0S;
        KHwSO:
        if (!isset($p_options[PCLZIP_OPT_COMMENT])) {
            goto hstFp;
        }
        goto bPjnt;
        VfFe5:
        $i = 0;
        goto T3l7E;
        E2QHW:
        $v_size = @ftell($this->zip_fd) - $v_offset;
        goto UfLN2;
        Ygm7T:
        BGuXI:
        goto Vz3En;
        DbsUA:
        v31bJ:
        goto BeloE;
        cvLOT:
        $this->privConvertHeader2FileInfo($v_header_list[$i], $p_result_list[$i]);
        goto wf141;
        sxQ0S:
        hstFp:
        goto E2QHW;
        sdaMb:
        return $v_result;
        goto A46jg;
        cxi4c:
        N0ytW:
        goto EhUI9;
        UfLN2:
        if (!(($v_result = $this->privWriteCentralHeader($v_count, $v_size, $v_offset, $v_comment)) != 1)) {
            goto N0ytW;
        }
        goto pV_XO;
        T3l7E:
        $v_count = 0;
        goto Ygm7T;
        SPsIU:
        if (!($v_header_list[$i]["\163\164\141\x74\x75\x73"] == "\157\x6b")) {
            goto AcR3e;
        }
        goto vvT9E;
        A46jg:
        T0Xoe:
        goto fCniY;
        oXtDt:
    }
    public function privAddFileList($p_filedescr_list, &$p_result_list, &$p_options)
    {
        goto QGcUw;
        gv8Oa:
        PclZip::privErrorLog(PCLZIP_ERR_MISSING_FILE, "\x46\x69\x6c\145\x20\47" . $p_filedescr_list[$j]["\x66\151\154\145\156\x61\155\x65"] . "\47\40\x64\x6f\145\163\40\156\157\x74\x20\x65\x78\151\163\164");
        goto uWVyK;
        uIXPG:
        return $v_result;
        goto B4qyB;
        uWVyK:
        return PclZip::errorCode();
        goto Cg8eJ;
        ZCLW2:
        if (!($v_result != 1)) {
            goto uYNrk;
        }
        goto X1Tmm;
        DW8Su:
        if (!($p_filedescr_list[$j]["\164\x79\160\145"] == "\x66\151\154\145" || $p_filedescr_list[$j]["\164\171\x70\x65"] == "\x76\151\162\x74\165\x61\x6c\x5f\x66\x69\x6c\x65" || $p_filedescr_list[$j]["\x74\x79\x70\x65"] == "\x66\x6f\x6c\144\145\x72" && (!isset($p_options[PCLZIP_OPT_REMOVE_ALL_PATH]) || !$p_options[PCLZIP_OPT_REMOVE_ALL_PATH]))) {
            goto F2On_;
        }
        goto eBvCB;
        kIpcu:
        mMyqM:
        goto o0oqz;
        QGcUw:
        $v_result = 1;
        goto hXGFz;
        UD2fM:
        $j = 0;
        goto kIpcu;
        gyyNp:
        $p_filedescr_list[$j]["\146\x69\154\x65\156\141\155\x65"] = PclZipUtilTranslateWinPath($p_filedescr_list[$j]["\146\151\154\x65\156\x61\x6d\145"], false);
        goto VBiUn;
        hfb0d:
        goto SVJW8;
        goto zQkuW;
        LUZG8:
        F2On_:
        goto vjlE5;
        X1Tmm:
        return $v_result;
        goto E7S0q;
        h0xFM:
        if (!($p_filedescr_list[$j]["\x74\x79\x70\145"] != "\166\x69\162\x74\x75\141\x6c\137\146\151\x6c\x65" && !file_exists($p_filedescr_list[$j]["\x66\x69\154\145\156\141\x6d\145"]))) {
            goto YilVl;
        }
        goto gv8Oa;
        VBiUn:
        if (!($p_filedescr_list[$j]["\146\x69\x6c\145\x6e\x61\x6d\x65"] == '')) {
            goto Ikc2b;
        }
        goto hfb0d;
        E7S0q:
        uYNrk:
        goto JC2cg;
        ynngI:
        goto mMyqM;
        goto sV2DW;
        eBvCB:
        $v_result = $this->privAddFile($p_filedescr_list[$j], $v_header, $p_options);
        goto ZCLW2;
        zQkuW:
        Ikc2b:
        goto h0xFM;
        vjlE5:
        SVJW8:
        goto W1hmQ;
        Cg8eJ:
        YilVl:
        goto DW8Su;
        JC2cg:
        $p_result_list[$v_nb++] = $v_header;
        goto LUZG8;
        iuHDM:
        $v_nb = sizeof($p_result_list);
        goto UD2fM;
        sV2DW:
        lctiB:
        goto uIXPG;
        hXGFz:
        $v_header = array();
        goto iuHDM;
        W1hmQ:
        $j++;
        goto ynngI;
        o0oqz:
        if (!($j < sizeof($p_filedescr_list) && $v_result == 1)) {
            goto lctiB;
        }
        goto gyyNp;
        B4qyB:
    }
    public function privAddFile($p_filedescr, &$p_header, &$p_options)
    {
        goto yBzHc;
        IIk4z:
        return $v_result;
        goto xwdsI;
        tyKug:
        yKTnF:
        goto F4MHt;
        qrhiT:
        o64FG:
        goto lRL8J;
        LU9rd:
        goto E6Vr0;
        goto slnhC;
        gl462:
        $v_local_header = array();
        goto i4HT8;
        lRL8J:
        $p_header["\x6d\x74\x69\155\x65"] = $p_filedescr["\155\x74\x69\155\x65"];
        goto MN3B4;
        K0LeS:
        $p_filename = $p_filedescr["\x66\151\154\145\x6e\x61\x6d\x65"];
        goto BmKW3;
        i4HT8:
        $this->privConvertHeader2FileInfo($p_header, $v_local_header);
        goto c8wJa;
        HnRTK:
        if (!(@substr($p_header["\x73\x74\157\x72\x65\144\x5f\x66\151\154\x65\x6e\x61\155\x65"], -1) != "\57")) {
            goto luz1o;
        }
        goto zCAgC;
        i59TF:
        goto v1RqO;
        goto PfoZf;
        w9tPT:
        vLZzh:
        goto ZyF84;
        CJqaZ:
        if ($p_filedescr["\x74\x79\160\145"] == "\166\x69\x72\x74\165\x61\x6c\x5f\146\151\154\145") {
            goto YtXZw;
        }
        goto AwJCE;
        Wny4v:
        $p_header["\x65\170\x74\145\162\x6e\x61\154"] = 0;
        goto iqLq5;
        Qd7rF:
        goto oALKw;
        goto SKSV9;
        PfoZf:
        HmbXE:
        goto cQWq8;
        iqLq5:
        $p_header["\163\x69\172\x65"] = strlen($p_filedescr["\x63\x6f\156\164\x65\x6e\x74"]);
        goto cLqYG;
        IgEdo:
        wOwuU:
        goto FWnHg;
        fE6gt:
        $this->privConvertHeader2FileInfo($p_header, $v_local_header);
        goto SHX9I;
        hZqCe:
        $p_header["\x63\162\x63"] = 0;
        goto jZ_oc;
        MBHvg:
        if (!($p_header["\x73\164\157\162\145\x64\x5f\146\151\x6c\145\x6e\x61\155\x65"] != $v_local_header["\x73\x74\x6f\162\145\144\137\146\151\x6c\145\156\x61\155\x65"])) {
            goto uWie_;
        }
        goto wiEG2;
        p0dwe:
        $v_result = 1;
        goto q3nO5;
        emLgw:
        if (!(($v_result = $this->privWriteFileHeader($p_header)) != 1)) {
            goto IZ_nT;
        }
        goto gRiTt;
        gGBTo:
        goto E6Vr0;
        goto cAoXW;
        edgVq:
        $v_content = @gzdeflate($v_content);
        goto Fzy2A;
        D4kf0:
        $v_local_header = array();
        goto fE6gt;
        cAoXW:
        TEbv7:
        goto DrG8Q;
        YKz0c:
        XKOeM:
        goto MBHvg;
        f6bQi:
        u2F1_:
        goto Wny4v;
        kn_zc:
        goto E6Vr0;
        goto KClXp;
        OXlgG:
        mkOtq:
        goto Lx73s;
        m1c5S:
        $v_content = $p_filedescr["\x63\x6f\x6e\x74\x65\156\164"];
        goto pjOhb;
        rUHUR:
        $p_header["\163\151\172\x65"] = filesize($p_filename);
        goto Q6H10;
        NO_s9:
        $p_header["\x66\x69\x6c\145\156\141\155\145\x5f\154\x65\x6e"] = strlen($p_filename);
        goto AKKkE;
        ZyF84:
        $p_header["\x65\x78\164\x65\162\x6e\x61\154"] = 16;
        goto lngHF;
        elUQu:
        $p_header["\163\164\141\x74\x75\x73"] = "\157\153";
        goto ws3xC;
        fhHIP:
        if (!(strlen($p_header["\x73\164\157\162\145\x64\137\x66\x69\154\145\156\x61\x6d\x65"]) > 255)) {
            goto wOwuU;
        }
        goto LHK2q;
        qMIPN:
        if (!($v_result == 0)) {
            goto iv9Hl;
        }
        goto p0dwe;
        XVH3K:
        return $v_result;
        goto CfyXz;
        wX62Z:
        $v_content = @gzdeflate($v_content);
        goto ZhQjo;
        sZE0S:
        $p_header["\x63\162\x63"] = @crc32($v_content);
        goto dFDcx;
        SKSV9:
        ik2RJ:
        goto o25V3;
        MN3B4:
        goto QBZTw;
        goto To5TW;
        vlIlI:
        Iu8tX:
        goto uOdfh;
        DQs0m:
        return $v_result;
        goto SlQTz;
        AwJCE:
        $p_header["\155\164\151\x6d\x65"] = filemtime($p_filename);
        goto phMhR;
        Fj9TT:
        $p_header["\146\x6c\x61\147"] = 0;
        goto U0un1;
        gRiTt:
        @fclose($v_file);
        goto MXrwz;
        tOMyB:
        if (!isset($p_options[PCLZIP_CB_PRE_ADD])) {
            goto L0EG4;
        }
        goto D4kf0;
        TbMJa:
        @fwrite($this->zip_fd, $v_content, $p_header["\x63\x6f\x6d\x70\162\x65\x73\x73\x65\144\137\x73\151\172\x65"]);
        goto qrgT_;
        cLqYG:
        X7kt_:
        goto t3_pi;
        iV2NT:
        $p_header["\x64\x69\163\x6b"] = 0;
        goto RSzmx;
        Gr0Bx:
        uWie_:
        goto byS77;
        DrG8Q:
        if (!isset($p_options[PCLZIP_OPT_TEMP_FILE_OFF]) && (isset($p_options[PCLZIP_OPT_TEMP_FILE_ON]) || isset($p_options[PCLZIP_OPT_TEMP_FILE_THRESHOLD]) && $p_options[PCLZIP_OPT_TEMP_FILE_THRESHOLD] <= $p_header["\163\151\172\145"])) {
            goto a_bDj;
        }
        goto Fur0I;
        X8ejq:
        $p_header["\163\x74\x6f\162\145\x64\x5f\x66\x69\154\145\156\x61\155\x65"] = $p_filedescr["\x73\x74\x6f\x72\145\144\137\146\151\x6c\145\x6e\141\x6d\x65"];
        goto GJmJ0;
        CPYtz:
        if (!(($v_result = $this->privWriteFileHeader($p_header)) != 1)) {
            goto ShQDf;
        }
        goto DQs0m;
        ZMIhZ:
        $p_header["\x73\x74\x61\x74\165\x73"] = "\x73\x6b\x69\160\x70\145\x64";
        goto qFveT;
        VBiFw:
        if ($p_filedescr["\x74\x79\x70\145"] == "\166\151\162\x74\x75\141\x6c\x5f\146\151\154\x65") {
            goto iAkym;
        }
        goto H0FjJ;
        KClXp:
        iAkym:
        goto m1c5S;
        Lx73s:
        $v_content = @fread($v_file, $p_header["\x73\x69\172\x65"]);
        goto wGo76;
        CfyXz:
        FPSqz:
        goto TbMJa;
        rik1H:
        $p_header["\x76\145\162\163\151\x6f\156\137\145\170\x74\162\x61\x63\164\x65\x64"] = 10;
        goto Fj9TT;
        ZhQjo:
        $p_header["\x63\157\155\160\162\x65\163\x73\x65\144\137\163\151\172\145"] = strlen($v_content);
        goto IDfLk;
        Dwq99:
        PclZip::privErrorLog(PCLZIP_ERR_INVALID_PARAMETER, "\x49\x6e\x76\141\x6c\151\144\40\146\151\x6c\145\x20\x6c\151\x73\x74\40\160\x61\x72\141\x6d\x65\164\145\162\x20\50\x69\156\166\x61\154\x69\144\40\157\x72\40\x65\155\x70\164\x79\x20\x6c\x69\x73\164\x29");
        goto MbYwD;
        yBzHc:
        $v_result = 1;
        goto K0LeS;
        VaiCw:
        $p_header["\157\146\x66\x73\x65\x74"] = 0;
        goto EyV6j;
        qFveT:
        $v_result = 1;
        goto YKz0c;
        dkxgH:
        Lv4hT:
        goto emLgw;
        pZJ6_:
        yfoFc:
        goto ypIvr;
        BmKW3:
        if (!($p_filename == '')) {
            goto w3rXR;
        }
        goto Dwq99;
        pjOhb:
        $p_header["\143\x72\x63"] = @crc32($v_content);
        goto fPH7S;
        RODiL:
        if (!(($v_result = $this->privWriteFileHeader($p_header)) != 1)) {
            goto FPSqz;
        }
        goto gMKoR;
        y9UYc:
        goto X7kt_;
        goto tyKug;
        RSzmx:
        $p_header["\x69\156\164\x65\162\156\x61\x6c"] = 0;
        goto VaiCw;
        kfA4c:
        $p_header["\143\x6f\x6d\155\x65\156\x74"] = '';
        goto Qd7rF;
        I_T0G:
        w3rXR:
        goto FimPF;
        zCAgC:
        $p_header["\163\164\157\x72\x65\144\x5f\x66\x69\x6c\x65\x6e\x61\155\145"] .= "\57";
        goto iDDUY;
        ju6LW:
        if (!($v_result < PCLZIP_ERR_NO_ERROR)) {
            goto k3zM9;
        }
        goto mjDSP;
        d9TTr:
        $p_header["\x73\x69\x7a\145"] = filesize($p_filename);
        goto R1WQJ;
        FE92H:
        $p_header["\x73\164\141\x74\x75\163"] = "\x66\x69\x6c\x74\x65\162\x65\x64";
        goto lvQLm;
        GJmJ0:
        $p_header["\x65\x78\x74\x72\x61"] = '';
        goto elUQu;
        HTwll:
        if (!($p_header["\x73\x74\157\x72\145\x64\137\146\151\x6c\145\156\141\155\x65"] == '')) {
            goto KIuWO;
        }
        goto FE92H;
        Fur0I:
        if (!(($v_file = @fopen($p_filename, "\162\x62")) == 0)) {
            goto mkOtq;
        }
        goto JO5M_;
        E3HM2:
        $p_header["\x6d\x74\151\x6d\x65"] = time();
        goto hDQyH;
        ihoHt:
        if ($p_filedescr["\x74\x79\160\x65"] == "\146\x69\154\x65") {
            goto TEbv7;
        }
        goto VBiFw;
        MXrwz:
        return $v_result;
        goto NUa0P;
        NUa0P:
        IZ_nT:
        goto f9cuU;
        lvQLm:
        KIuWO:
        goto fhHIP;
        fPH7S:
        if ($p_options[PCLZIP_OPT_NO_COMPRESSION]) {
            goto yfoFc;
        }
        goto edgVq;
        OXcej:
        v1RqO:
        goto RODiL;
        Q6H10:
        goto X7kt_;
        goto f6bQi;
        t3_pi:
        if (isset($p_filedescr["\155\164\151\x6d\x65"])) {
            goto o64FG;
        }
        goto CJqaZ;
        jZ_oc:
        $p_header["\143\x6f\x6d\160\x72\x65\163\163\145\x64\x5f\163\151\x7a\x65"] = 0;
        goto NO_s9;
        To5TW:
        YtXZw:
        goto E3HM2;
        p6A3T:
        $p_header["\166\145\x72\163\x69\x6f\156"] = 20;
        goto rik1H;
        qrgT_:
        goto HMbIQ;
        goto gZ1OW;
        ypIvr:
        $p_header["\143\x6f\x6d\160\162\145\x73\163\x65\x64\x5f\x73\x69\x7a\x65"] = $p_header["\163\x69\x7a\x65"];
        goto uWh2o;
        dFDcx:
        if ($p_options[PCLZIP_OPT_NO_COMPRESSION]) {
            goto HmbXE;
        }
        goto wX62Z;
        gMKoR:
        @fclose($v_file);
        goto XVH3K;
        JO5M_:
        PclZip::privErrorLog(PCLZIP_ERR_READ_OPEN_FAIL, "\125\x6e\x61\x62\154\x65\x20\x74\157\40\x6f\160\145\156\x20\x66\x69\x6c\x65\40\x27{$p_filename}\x27\40\x69\x6e\x20\x62\151\x6e\141\162\171\40\x72\x65\x61\144\40\x6d\x6f\144\x65");
        goto rCsx0;
        uOdfh:
        if (!isset($p_options[PCLZIP_CB_POST_ADD])) {
            goto yVqRx;
        }
        goto gl462;
        q3nO5:
        iv9Hl:
        goto kGPwc;
        FudWx:
        if ($p_filedescr["\164\171\x70\x65"] == "\146\157\x6c\144\145\x72") {
            goto vLZzh;
        }
        goto z7AZT;
        R1WQJ:
        goto X7kt_;
        goto w9tPT;
        Fzy2A:
        $p_header["\143\157\155\160\162\x65\163\x73\x65\144\x5f\x73\151\172\x65"] = strlen($v_content);
        goto EbqoO;
        rCsx0:
        return PclZip::errorCode();
        goto OXlgG;
        p_7q8:
        HMbIQ:
        goto kn_zc;
        FzLZL:
        $p_header["\x73\x69\172\145"] = 0;
        goto MGODk;
        byS77:
        L0EG4:
        goto HTwll;
        o25V3:
        $p_header["\x63\157\x6d\x6d\145\156\164\137\154\x65\x6e"] = strlen($p_filedescr["\x63\x6f\x6d\155\x65\x6e\164"]);
        goto VFvy2;
        DI5tI:
        $v_result = $this->privAddFileUsingTempFile($p_filedescr, $p_header, $p_options);
        goto ju6LW;
        LHK2q:
        $p_header["\163\164\141\164\x75\163"] = "\146\151\x6c\145\156\x61\x6d\x65\x5f\x74\x6f\157\137\x6c\157\x6e\147";
        goto IgEdo;
        gZ1OW:
        a_bDj:
        goto DI5tI;
        f9cuU:
        @fwrite($this->zip_fd, $v_content, $p_header["\143\157\x6d\x70\162\145\x73\163\145\x64\137\163\151\x7a\x65"]);
        goto LU9rd;
        SlQTz:
        ShQDf:
        goto lZsqi;
        U0un1:
        $p_header["\143\157\155\x70\x72\145\x73\x73\151\x6f\156"] = 0;
        goto hZqCe;
        c8wJa:
        $v_result = $p_options[PCLZIP_CB_POST_ADD](PCLZIP_CB_POST_ADD, $v_local_header);
        goto qMIPN;
        u5f3X:
        $p_header["\x63\x6f\155\x6d\145\156\x74\137\154\145\156"] = 0;
        goto kfA4c;
        HSqBG:
        if (isset($p_filedescr["\143\157\155\155\145\x6e\164"])) {
            goto ik2RJ;
        }
        goto u5f3X;
        SHX9I:
        $v_result = $p_options[PCLZIP_CB_PRE_ADD](PCLZIP_CB_PRE_ADD, $v_local_header);
        goto vNsSg;
        VPGzt:
        $p_header["\143\x6f\x6d\160\x72\145\x73\163\x69\x6f\x6e"] = 0;
        goto OXcej;
        mjDSP:
        return $v_result;
        goto Ij2hG;
        phMhR:
        goto QBZTw;
        goto qrhiT;
        F4MHt:
        $p_header["\145\170\x74\x65\162\156\x61\154"] = 0;
        goto d9TTr;
        FimPF:
        clearstatcache();
        goto p6A3T;
        EyV6j:
        $p_header["\146\151\x6c\145\x6e\141\155\x65"] = $p_filename;
        goto X8ejq;
        HDu1c:
        goto Lv4hT;
        goto pZJ6_;
        FWnHg:
        if (!($p_header["\163\x74\x61\164\x75\163"] == "\157\x6b")) {
            goto Iu8tX;
        }
        goto ihoHt;
        lngHF:
        $p_header["\155\x74\151\x6d\x65"] = filemtime($p_filename);
        goto rUHUR;
        MbYwD:
        return PclZip::errorCode();
        goto I_T0G;
        iDDUY:
        luz1o:
        goto FzLZL;
        hDQyH:
        QBZTw:
        goto HSqBG;
        h8b1L:
        oALKw:
        goto tOMyB;
        VFvy2:
        $p_header["\143\x6f\155\x6d\x65\x6e\x74"] = $p_filedescr["\x63\157\155\x6d\145\x6e\164"];
        goto h8b1L;
        lZsqi:
        E6Vr0:
        goto vlIlI;
        wGo76:
        @fclose($v_file);
        goto sZE0S;
        ws3xC:
        $p_header["\x69\x6e\x64\x65\170"] = -1;
        goto vbB04;
        z7AZT:
        if ($p_filedescr["\164\171\160\145"] == "\x76\151\162\164\x75\x61\x6c\137\146\x69\x6c\145") {
            goto u2F1_;
        }
        goto y9UYc;
        EbqoO:
        $p_header["\143\157\x6d\x70\162\145\163\163\x69\x6f\156"] = 8;
        goto HDu1c;
        MGODk:
        $p_header["\x65\170\x74\145\162\x6e\x61\154"] = 16;
        goto CPYtz;
        kGPwc:
        yVqRx:
        goto IIk4z;
        slnhC:
        j5nlU:
        goto HnRTK;
        wiEG2:
        $p_header["\x73\164\157\x72\x65\x64\x5f\146\x69\x6c\145\x6e\x61\155\145"] = PclZipUtilPathReduction($v_local_header["\163\x74\157\162\145\144\137\x66\151\154\145\156\x61\155\x65"]);
        goto Gr0Bx;
        uWh2o:
        $p_header["\143\x6f\155\160\x72\145\163\x73\151\157\156"] = 0;
        goto dkxgH;
        AKKkE:
        $p_header["\145\170\164\162\x61\x5f\x6c\x65\x6e"] = 0;
        goto iV2NT;
        Ij2hG:
        k3zM9:
        goto p_7q8;
        cQWq8:
        $p_header["\x63\157\155\x70\x72\x65\163\x73\145\x64\x5f\163\x69\172\x65"] = $p_header["\x73\x69\172\145"];
        goto VPGzt;
        vNsSg:
        if (!($v_result == 0)) {
            goto XKOeM;
        }
        goto ZMIhZ;
        IDfLk:
        $p_header["\x63\157\x6d\160\x72\145\x73\163\x69\x6f\x6e"] = 8;
        goto i59TF;
        H0FjJ:
        if ($p_filedescr["\164\171\160\x65"] == "\x66\x6f\x6c\x64\145\162") {
            goto j5nlU;
        }
        goto gGBTo;
        vbB04:
        if ($p_filedescr["\164\171\160\145"] == "\x66\151\154\x65") {
            goto yKTnF;
        }
        goto FudWx;
        xwdsI:
    }
    public function privAddFileUsingTempFile($p_filedescr, &$p_header, &$p_options)
    {
        goto CFk93;
        mOw19:
        hoETc:
        goto nYSM3;
        uTX1W:
        return PclZip::errorCode();
        goto WxU1L;
        YUplL:
        PclZip::privErrorLog(PCLZIP_ERR_READ_OPEN_FAIL, "\x55\x6e\141\x62\x6c\x65\x20\164\157\x20\x6f\x70\x65\156\40\146\x69\x6c\145\40\x27{$p_filename}\47\x20\151\156\x20\x62\x69\x6e\x61\162\171\40\x72\145\x61\144\40\x6d\157\144\x65");
        goto tST9K;
        iFZOO:
        dHdZO:
        goto Bp279;
        WdWYR:
        $v_binary_data = @fread($v_file_compressed, 10);
        goto RYPuH;
        hL8ZL:
        fseek($v_file_compressed, 10);
        goto tiv30;
        VG8SX:
        if (!(($v_result = $this->privWriteFileHeader($p_header)) != 1)) {
            goto RbRAg;
        }
        goto L2tBU;
        LwJQz:
        bFbel:
        goto VW_vL;
        knCwg:
        $p_header["\143\162\x63"] = $v_data_footer["\x63\x72\143"];
        goto H35ib;
        H4Ju1:
        $v_size -= $v_read_size;
        goto IBaVN;
        nobrh:
        @fclose($v_file_compressed);
        goto VG8SX;
        f442s:
        if (!(filesize($v_gzip_temp_name) < 18)) {
            goto UZHOv;
        }
        goto eMrb3;
        yaRh2:
        Q8iuh:
        goto S3Hwe;
        eMrb3:
        PclZip::privErrorLog(PCLZIP_ERR_BAD_FORMAT, "\147\x7a\151\160\40\x74\145\155\x70\x6f\x72\x61\162\171\x20\x66\x69\x6c\145\40\47" . $v_gzip_temp_name . "\47\x20\150\x61\x73\40\151\156\x76\141\154\x69\x64\x20\146\x69\x6c\x65\163\151\172\145\x20\x2d\x20\163\150\x6f\x75\154\x64\40\142\145\40\155\151\156\151\x6d\x75\155\x20\61\x38\x20\x62\x79\164\145\163");
        goto DoR7x;
        qz_wW:
        uf5ky:
        goto WXOLS;
        L2tBU:
        return $v_result;
        goto euW1d;
        H35ib:
        $p_header["\143\x6f\155\160\162\145\163\163\x65\x64\x5f\163\151\x7a\x65"] = filesize($v_gzip_temp_name) - 18;
        goto nobrh;
        UU08q:
        $v_buffer = @fread($v_file_compressed, $v_read_size);
        goto BZndg;
        crepd:
        @fseek($v_file_compressed, filesize($v_gzip_temp_name) - 8);
        goto VM_IN;
        A_Jre:
        PclZip::privErrorLog(PCLZIP_ERR_READ_OPEN_FAIL, "\x55\156\x61\x62\x6c\x65\x20\164\157\x20\x6f\x70\145\x6e\x20\164\x65\x6d\x70\x6f\162\141\x72\171\40\146\x69\x6c\145\x20\x27" . $v_gzip_temp_name . "\47\40\x69\156\40\x62\151\156\141\162\171\x20\162\145\x61\x64\x20\155\x6f\x64\x65");
        goto cThS5;
        auCmr:
        $p_header["\143\157\x6d\160\162\x65\163\163\151\x6f\x6e"] = ord($v_data_header["\143\155"]);
        goto knCwg;
        H9NYF:
        @gzclose($v_file_compressed);
        goto f442s;
        euW1d:
        RbRAg:
        goto RMgA7;
        VM_IN:
        $v_binary_data = @fread($v_file_compressed, 8);
        goto MUnGw;
        HlN6S:
        goto uf5ky;
        goto LwJQz;
        wthur:
        PclZip::privErrorLog(PCLZIP_ERR_READ_OPEN_FAIL, "\125\156\141\x62\154\145\40\164\157\x20\157\160\x65\156\40\164\x65\x6d\x70\157\162\141\x72\x79\40\x66\x69\x6c\145\40\x27" . $v_gzip_temp_name . "\x27\x20\x69\156\x20\142\151\156\141\162\x79\x20\x72\145\x61\x64\40\x6d\157\144\145");
        goto uTX1W;
        nYSM3:
        $v_size = filesize($p_filename);
        goto iFZOO;
        DoR7x:
        return PclZip::errorCode();
        goto x41wi;
        sC5O1:
        $v_size -= $v_read_size;
        goto HlN6S;
        S3Hwe:
        $v_gzip_temp_name = PCLZIP_TEMPORARY_DIR . uniqid("\160\143\x6c\x7a\151\x70\55") . "\56\x67\x7a";
        goto HGtW8;
        tiv30:
        $v_size = $p_header["\143\x6f\x6d\x70\x72\x65\163\x73\x65\144\137\x73\151\x7a\145"];
        goto qz_wW;
        HGtW8:
        if (!(($v_file_compressed = @gzopen($v_gzip_temp_name, "\167\x62")) == 0)) {
            goto hoETc;
        }
        goto trL8u;
        Bp279:
        if (!($v_size != 0)) {
            goto H4gfj;
        }
        goto PSoAJ;
        jF7ti:
        $p_filename = $p_filedescr["\x66\x69\154\145\x6e\141\x6d\145"];
        goto V2wIW;
        MUnGw:
        $v_data_footer = unpack("\x56\x63\162\x63\x2f\126\143\x6f\x6d\160\162\145\x73\x73\145\x64\137\x73\x69\172\145", $v_binary_data);
        goto auCmr;
        CFk93:
        $v_result = PCLZIP_ERR_NO_ERROR;
        goto jF7ti;
        BZndg:
        @fwrite($this->zip_fd, $v_buffer, $v_read_size);
        goto sC5O1;
        dzhz_:
        @unlink($v_gzip_temp_name);
        goto imhMy;
        RYPuH:
        $v_data_header = unpack("\141\61\151\x64\x31\57\141\x31\x69\144\x32\x2f\141\x31\143\155\x2f\x61\61\x66\154\x61\x67\57\126\x6d\164\x69\155\x65\57\141\61\x78\x66\x6c\57\x61\61\157\x73", $v_binary_data);
        goto x6Prk;
        TjZS0:
        $v_read_size = $v_size < PCLZIP_READ_BLOCK_SIZE ? $v_size : PCLZIP_READ_BLOCK_SIZE;
        goto UU08q;
        RMgA7:
        if (!(($v_file_compressed = @fopen($v_gzip_temp_name, "\162\142")) == 0)) {
            goto Am0JT;
        }
        goto A_Jre;
        NzEry:
        PclZip::privErrorLog(PCLZIP_ERR_WRITE_OPEN_FAIL, "\125\x6e\x61\x62\x6c\145\x20\x74\157\40\157\x70\145\156\x20\164\145\x6d\x70\x6f\162\x61\x72\171\x20\146\151\154\145\40\x27" . $v_gzip_temp_name . "\47\x20\151\156\40\x62\151\x6e\141\162\171\x20\167\162\151\x74\145\x20\155\x6f\144\145");
        goto hXsRi;
        gwmnJ:
        @fclose($v_file);
        goto H9NYF;
        VW_vL:
        @fclose($v_file_compressed);
        goto dzhz_;
        tST9K:
        return PclZip::errorCode();
        goto yaRh2;
        x41wi:
        UZHOv:
        goto pkt7f;
        IBaVN:
        goto dHdZO;
        goto FWMKL;
        WXOLS:
        if (!($v_size != 0)) {
            goto bFbel;
        }
        goto TjZS0;
        pkt7f:
        if (!(($v_file_compressed = @fopen($v_gzip_temp_name, "\162\142")) == 0)) {
            goto oLZmo;
        }
        goto wthur;
        imhMy:
        return $v_result;
        goto CdmzH;
        G4Cgd:
        Am0JT:
        goto hL8ZL;
        FWMKL:
        H4gfj:
        goto gwmnJ;
        x6Prk:
        $v_data_header["\157\x73"] = bin2hex($v_data_header["\x6f\163"]);
        goto crepd;
        mq5Vu:
        @gzputs($v_file_compressed, $v_buffer, $v_read_size);
        goto H4Ju1;
        WxU1L:
        oLZmo:
        goto WdWYR;
        hXsRi:
        return PclZip::errorCode();
        goto mOw19;
        V2wIW:
        if (!(($v_file = @fopen($p_filename, "\x72\142")) == 0)) {
            goto Q8iuh;
        }
        goto YUplL;
        PSoAJ:
        $v_read_size = $v_size < PCLZIP_READ_BLOCK_SIZE ? $v_size : PCLZIP_READ_BLOCK_SIZE;
        goto k4oPA;
        k4oPA:
        $v_buffer = @fread($v_file, $v_read_size);
        goto mq5Vu;
        trL8u:
        fclose($v_file);
        goto NzEry;
        cThS5:
        return PclZip::errorCode();
        goto G4Cgd;
        CdmzH:
    }
    public function privCalculateStoredFilename(&$p_filedescr, &$p_options)
    {
        goto yFNPV;
        eKGwn:
        if (isset($p_filedescr["\156\145\167\137\163\150\x6f\x72\x74\x5f\156\141\155\x65"])) {
            goto MiOnx;
        }
        goto ey9ix;
        RynMa:
        $v_path_info = pathinfo($p_filename);
        goto l5C2Z;
        V9XyM:
        if ($p_remove_dir != '') {
            goto eXS4K;
        }
        goto euhUa;
        Dza6p:
        eh3F_:
        goto rsSBy;
        KUVIR:
        $p_remove_dir = '';
        goto detiP;
        KCszK:
        R4qZI:
        goto g0iyA;
        E4NOo:
        $v_stored_filename = substr($v_stored_filename, strlen($p_remove_dir));
        goto LLaML;
        f2_R6:
        $p_add_dir = $p_options[PCLZIP_OPT_ADD_PATH];
        goto KqwV8;
        x_utk:
        goto kpo8_;
        goto q_4qu;
        cB2Np:
        ZyBfR:
        goto b2jEl;
        DPHMi:
        if (isset($p_options[PCLZIP_OPT_REMOVE_ALL_PATH])) {
            goto WuogL;
        }
        goto YGrUD;
        nWgJX:
        $v_dir = $v_path_info["\144\x69\x72\156\x61\155\145"] . "\57";
        goto Ul0TI;
        Ewi5n:
        goto PQUzI;
        goto LbmyA;
        AxWd5:
        Ded3R:
        goto dPNHt;
        zxnso:
        $v_stored_filename = PclZipUtilPathReduction($v_stored_filename);
        goto kYZWw;
        U_rTw:
        if (!($p_add_dir != '')) {
            goto o6ZrW;
        }
        goto OrNDs;
        pFI84:
        if ($v_compare == 2) {
            goto ZyBfR;
        }
        goto E4NOo;
        XUfMm:
        if (!($v_path_info["\144\151\162\x6e\x61\155\145"] != '')) {
            goto MQjW2;
        }
        goto nWgJX;
        LbmyA:
        ATPJW:
        goto MwlrQ;
        euhUa:
        goto Ded3R;
        goto oisp7;
        rsSBy:
        $v_stored_filename = PclZipUtilTranslateWinPath($p_filedescr["\156\x65\167\137\x66\x75\154\x6c\137\156\x61\155\x65"]);
        goto ZCbVc;
        pUPje:
        kbL5t:
        goto AxWd5;
        x7NvL:
        $v_compare = PclZipUtilPathInclusion($p_remove_dir, $v_stored_filename);
        goto IlqTO;
        t0fzJ:
        return $v_result;
        goto ynBFf;
        ey9ix:
        $v_stored_filename = $p_filename;
        goto BCpMc;
        oisp7:
        T13KM:
        goto mbYwW;
        q_4qu:
        Cii3h:
        goto f2_R6;
        bZZWN:
        $p_filename = $p_filedescr["\x66\151\154\x65\156\141\x6d\145"];
        goto fSICB;
        dPNHt:
        $v_stored_filename = PclZipUtilTranslateWinPath($v_stored_filename);
        goto U_rTw;
        kYZWw:
        $p_filedescr["\163\x74\x6f\x72\x65\x64\x5f\x66\x69\154\x65\156\x61\x6d\x65"] = $v_stored_filename;
        goto t0fzJ;
        OFS20:
        hAuSq:
        goto U8_zu;
        CHMId:
        goto KoQkH;
        goto ljI6h;
        OrNDs:
        if (substr($p_add_dir, -1) == "\57") {
            goto ATPJW;
        }
        goto WPPHB;
        vgy88:
        $p_remove_dir .= "\x2f";
        goto xw4NL;
        U8_zu:
        $p_remove_dir = $p_options[PCLZIP_OPT_REMOVE_PATH];
        goto fQtMY;
        rkudt:
        BmRQ7:
        goto x7NvL;
        IlqTO:
        if (!($v_compare > 0)) {
            goto kbL5t;
        }
        goto pFI84;
        RhvGO:
        $p_remove_dir = substr($p_remove_dir, 2);
        goto YBTQY;
        fSICB:
        if (isset($p_options[PCLZIP_OPT_ADD_PATH])) {
            goto Cii3h;
        }
        goto RIMVJ;
        ZCbVc:
        iYAQM:
        goto zxnso;
        b2jEl:
        $v_stored_filename = '';
        goto mpXBd;
        mbYwW:
        $v_stored_filename = basename($p_filename);
        goto ZsgDQ;
        uqmvc:
        MiOnx:
        goto RynMa;
        ljI6h:
        WuogL:
        goto IrbCY;
        xw4NL:
        BkUzd:
        goto I9M9A;
        m5CO8:
        if (isset($p_filedescr["\x6e\145\x77\x5f\146\165\154\154\137\156\x61\x6d\x65"])) {
            goto eh3F_;
        }
        goto eKGwn;
        I9M9A:
        if (!(substr($p_filename, 0, 2) == "\x2e\x2f" || substr($p_remove_dir, 0, 2) == "\x2e\x2f")) {
            goto BmRQ7;
        }
        goto bM70p;
        YGrUD:
        $p_remove_all_dir = 0;
        goto CHMId;
        RIMVJ:
        $p_add_dir = '';
        goto x_utk;
        g0iyA:
        if ($p_remove_all_dir) {
            goto T13KM;
        }
        goto V9XyM;
        bM70p:
        if (!(substr($p_filename, 0, 2) == "\56\x2f" && substr($p_remove_dir, 0, 2) != "\x2e\57")) {
            goto KyoKd;
        }
        goto md4g1;
        yFNPV:
        $v_result = 1;
        goto bZZWN;
        ZsgDQ:
        goto Ded3R;
        goto mLnhs;
        IrbCY:
        $p_remove_all_dir = $p_options[PCLZIP_OPT_REMOVE_ALL_PATH];
        goto qxIXm;
        Jpngx:
        o6ZrW:
        goto I9oSs;
        YBTQY:
        m5d_P:
        goto rkudt;
        kQ1iI:
        $v_stored_filename = $v_dir . $p_filedescr["\156\145\167\137\163\x68\x6f\162\164\137\156\141\155\x65"];
        goto KCszK;
        KqwV8:
        kpo8_:
        goto NjBJl;
        YJu_f:
        if (!(substr($p_remove_dir, -1) != "\x2f")) {
            goto BkUzd;
        }
        goto vgy88;
        qxIXm:
        KoQkH:
        goto m5CO8;
        i__0l:
        PQUzI:
        goto Jpngx;
        Ul0TI:
        MQjW2:
        goto kQ1iI;
        detiP:
        goto xwlZn;
        goto OFS20;
        l5C2Z:
        $v_dir = '';
        goto XUfMm;
        MwlrQ:
        $v_stored_filename = $p_add_dir . $v_stored_filename;
        goto i__0l;
        WPPHB:
        $v_stored_filename = $p_add_dir . "\57" . $v_stored_filename;
        goto Ewi5n;
        mpXBd:
        HyGey:
        goto pUPje;
        dKHA4:
        if (!(substr($p_filename, 0, 2) != "\56\57" && substr($p_remove_dir, 0, 2) == "\x2e\57")) {
            goto m5d_P;
        }
        goto RhvGO;
        XqB_B:
        KyoKd:
        goto dKHA4;
        fQtMY:
        xwlZn:
        goto DPHMi;
        LLaML:
        goto HyGey;
        goto cB2Np;
        BCpMc:
        goto R4qZI;
        goto uqmvc;
        I9oSs:
        goto iYAQM;
        goto Dza6p;
        NjBJl:
        if (isset($p_options[PCLZIP_OPT_REMOVE_PATH])) {
            goto hAuSq;
        }
        goto KUVIR;
        mLnhs:
        eXS4K:
        goto YJu_f;
        md4g1:
        $p_remove_dir = "\x2e\x2f" . $p_remove_dir;
        goto XqB_B;
        ynBFf:
    }
    public function privWriteFileHeader(&$p_header)
    {
        goto pWHRq;
        pWHRq:
        $v_result = 1;
        goto IxO73;
        rPT7V:
        LCrCM:
        goto dVuaE;
        dVuaE:
        return $v_result;
        goto nZm9b;
        oVvcW:
        $v_date = getdate($p_header["\155\x74\x69\x6d\x65"]);
        goto xJZgS;
        T0Wn4:
        ad1lE:
        goto nstyX;
        nstyX:
        if (!($p_header["\145\x78\x74\162\141\x5f\154\x65\156"] != 0)) {
            goto LCrCM;
        }
        goto FsAbC;
        SRtXw:
        fputs($this->zip_fd, $v_binary_data, 30);
        goto zYypZ;
        IxO73:
        $p_header["\157\146\x66\163\x65\164"] = ftell($this->zip_fd);
        goto oVvcW;
        zYypZ:
        if (!(strlen($p_header["\x73\x74\x6f\162\x65\x64\137\x66\x69\154\145\x6e\141\x6d\x65"]) != 0)) {
            goto ad1lE;
        }
        goto dmoKY;
        wpxp1:
        $v_mdate = ($v_date["\171\145\141\x72"] - 1980 << 9) + ($v_date["\155\x6f\156"] << 5) + $v_date["\x6d\144\141\171"];
        goto YzrTe;
        YzrTe:
        $v_binary_data = pack("\126\166\x76\x76\x76\x76\126\x56\126\166\166", 67324752, $p_header["\x76\145\162\x73\151\157\x6e\x5f\145\170\x74\x72\141\x63\164\x65\144"], $p_header["\x66\154\x61\x67"], $p_header["\x63\157\155\x70\162\x65\x73\x73\151\x6f\x6e"], $v_mtime, $v_mdate, $p_header["\x63\162\143"], $p_header["\x63\x6f\x6d\x70\x72\x65\x73\163\x65\144\x5f\x73\151\x7a\145"], $p_header["\x73\x69\172\145"], strlen($p_header["\x73\164\x6f\x72\x65\144\137\x66\x69\x6c\145\156\141\x6d\145"]), $p_header["\x65\170\x74\x72\x61\x5f\x6c\145\156"]);
        goto SRtXw;
        FsAbC:
        fputs($this->zip_fd, $p_header["\x65\x78\164\x72\x61"], $p_header["\x65\x78\164\x72\x61\x5f\x6c\x65\x6e"]);
        goto rPT7V;
        xJZgS:
        $v_mtime = ($v_date["\x68\157\165\162\163"] << 11) + ($v_date["\155\x69\156\x75\x74\145\163"] << 5) + $v_date["\x73\145\x63\x6f\156\x64\x73"] / 2;
        goto wpxp1;
        dmoKY:
        fputs($this->zip_fd, $p_header["\x73\164\157\162\x65\x64\x5f\x66\x69\x6c\145\156\141\155\x65"], strlen($p_header["\163\164\157\162\x65\144\137\146\151\154\145\156\141\x6d\145"]));
        goto T0Wn4;
        nZm9b:
    }
    public function privWriteCentralFileHeader(&$p_header)
    {
        goto brObY;
        brObY:
        $v_result = 1;
        goto Gi5Cb;
        KvaqI:
        $v_binary_data = pack("\126\166\x76\166\166\166\166\x56\x56\x56\166\166\x76\x76\166\x56\126", 33639248, $p_header["\166\145\x72\x73\x69\157\x6e"], $p_header["\166\x65\x72\163\151\x6f\156\137\x65\x78\x74\162\x61\x63\164\x65\144"], $p_header["\x66\154\x61\147"], $p_header["\x63\157\155\x70\162\x65\163\163\151\x6f\x6e"], $v_mtime, $v_mdate, $p_header["\x63\x72\x63"], $p_header["\x63\157\x6d\160\x72\x65\163\163\145\x64\137\163\151\172\145"], $p_header["\x73\151\x7a\145"], strlen($p_header["\x73\164\x6f\162\x65\x64\137\x66\x69\x6c\x65\x6e\141\x6d\145"]), $p_header["\145\170\164\x72\141\x5f\154\145\x6e"], $p_header["\x63\x6f\x6d\155\145\156\164\137\x6c\x65\156"], $p_header["\144\x69\163\x6b"], $p_header["\151\156\164\x65\x72\156\x61\154"], $p_header["\x65\x78\x74\145\162\156\x61\x6c"], $p_header["\x6f\146\x66\x73\145\164"]);
        goto hKVbZ;
        Qtvid:
        if (!(strlen($p_header["\163\164\x6f\x72\x65\144\137\146\x69\154\x65\x6e\x61\155\145"]) != 0)) {
            goto JRj5m;
        }
        goto yyV0P;
        l26qA:
        return $v_result;
        goto P00qH;
        pYhpd:
        $v_mtime = ($v_date["\150\157\165\162\163"] << 11) + ($v_date["\x6d\x69\156\165\164\145\x73"] << 5) + $v_date["\163\145\143\x6f\x6e\144\x73"] / 2;
        goto GtiJ2;
        hKVbZ:
        fputs($this->zip_fd, $v_binary_data, 46);
        goto Qtvid;
        GtiJ2:
        $v_mdate = ($v_date["\171\x65\141\162"] - 1980 << 9) + ($v_date["\x6d\157\x6e"] << 5) + $v_date["\x6d\144\x61\x79"];
        goto KvaqI;
        bZEHn:
        if (!($p_header["\x63\x6f\x6d\155\145\156\x74\137\154\145\156"] != 0)) {
            goto HbJIR;
        }
        goto KVCMh;
        toflC:
        JRj5m:
        goto AF3mB;
        yyV0P:
        fputs($this->zip_fd, $p_header["\x73\164\x6f\x72\145\144\137\x66\151\154\145\x6e\141\x6d\145"], strlen($p_header["\163\x74\157\162\145\x64\x5f\x66\x69\154\145\156\x61\x6d\x65"]));
        goto toflC;
        pRwq1:
        fputs($this->zip_fd, $p_header["\x65\x78\x74\162\141"], $p_header["\145\x78\164\162\x61\137\x6c\145\156"]);
        goto eyAN1;
        AF3mB:
        if (!($p_header["\145\x78\x74\162\141\x5f\154\x65\x6e"] != 0)) {
            goto BbO80;
        }
        goto pRwq1;
        eyAN1:
        BbO80:
        goto bZEHn;
        Gi5Cb:
        $v_date = getdate($p_header["\155\164\151\155\x65"]);
        goto pYhpd;
        KVCMh:
        fputs($this->zip_fd, $p_header["\x63\x6f\155\x6d\x65\156\x74"], $p_header["\x63\157\155\155\145\x6e\x74\137\154\145\x6e"]);
        goto X2HIh;
        X2HIh:
        HbJIR:
        goto l26qA;
        P00qH:
    }
    public function privWriteCentralHeader($p_nb_entries, $p_size, $p_offset, $p_comment)
    {
        goto IABWZ;
        Apqtb:
        return $v_result;
        goto Y4uLX;
        hgNm3:
        $v_binary_data = pack("\126\x76\x76\166\x76\126\126\x76", 101010256, 0, 0, $p_nb_entries, $p_nb_entries, $p_size, $p_offset, strlen($p_comment));
        goto uY9Bn;
        c5Z31:
        if (!(strlen($p_comment) != 0)) {
            goto T9p59;
        }
        goto TCfdk;
        dZ_7k:
        T9p59:
        goto Apqtb;
        uY9Bn:
        fputs($this->zip_fd, $v_binary_data, 22);
        goto c5Z31;
        IABWZ:
        $v_result = 1;
        goto hgNm3;
        TCfdk:
        fputs($this->zip_fd, $p_comment, strlen($p_comment));
        goto dZ_7k;
        Y4uLX:
    }
    public function privList(&$p_list)
    {
        goto u42ho;
        l256R:
        @rewind($this->zip_fd);
        goto zfhDQ;
        zfhDQ:
        if (!@fseek($this->zip_fd, $v_central_dir["\x6f\x66\146\163\x65\164"])) {
            goto fv91t;
        }
        goto YiesV;
        mF1Tp:
        return $v_result;
        goto JKqAQ;
        hVDH2:
        XF4hL:
        goto QLM5u;
        lI74z:
        $this->privSwapBackMagicQuotes();
        goto mF1Tp;
        bavGE:
        if (!(($this->zip_fd = @fopen($this->zipname, "\162\x62")) == 0)) {
            goto XF4hL;
        }
        goto VIz7R;
        Sv4an:
        jgni6:
        goto cHBSa;
        DD3r8:
        return $v_result;
        goto t0Xzt;
        u42ho:
        $v_result = 1;
        goto GaY2y;
        cHBSa:
        $v_header["\151\156\144\145\170"] = $i;
        goto L3UxU;
        iHEKj:
        iLnGn:
        goto tx5Nx;
        YiesV:
        $this->privSwapBackMagicQuotes();
        goto m6izo;
        Pj2Xc:
        $i = 0;
        goto iHEKj;
        hLVjo:
        oluz1:
        goto yomEb;
        QLM5u:
        $v_central_dir = array();
        goto YwXhB;
        L3UxU:
        $this->privConvertHeader2FileInfo($v_header, $p_list[$i]);
        goto W8pmW;
        Qy2ek:
        $i++;
        goto Q1A7a;
        JKqAQ:
        DmPZ4:
        goto l256R;
        GaY2y:
        $this->privDisableMagicQuotes();
        goto bavGE;
        YwXhB:
        if (!(($v_result = $this->privReadEndCentralDir($v_central_dir)) != 1)) {
            goto DmPZ4;
        }
        goto lI74z;
        FvVVY:
        fv91t:
        goto Pj2Xc;
        tx5Nx:
        if (!($i < $v_central_dir["\x65\x6e\x74\x72\x69\x65\163"])) {
            goto oluz1;
        }
        goto mL1Q2;
        VIz7R:
        $this->privSwapBackMagicQuotes();
        goto n71lU;
        m6izo:
        PclZip::privErrorLog(PCLZIP_ERR_INVALID_ARCHIVE_ZIP, "\x49\156\166\141\x6c\151\x64\x20\x61\x72\143\150\151\x76\x65\x20\163\x69\x7a\145");
        goto FeIAs;
        j3WXF:
        return $v_result;
        goto Sv4an;
        Q1A7a:
        goto iLnGn;
        goto hLVjo;
        FeIAs:
        return PclZip::errorCode();
        goto FvVVY;
        jhSud:
        return PclZip::errorCode();
        goto hVDH2;
        W8pmW:
        unset($v_header);
        goto Z7rPk;
        n71lU:
        PclZip::privErrorLog(PCLZIP_ERR_READ_OPEN_FAIL, "\125\x6e\x61\x62\x6c\x65\40\164\157\40\157\x70\145\x6e\40\141\x72\143\150\x69\x76\145\40\x27" . $this->zipname . "\x27\40\151\156\x20\x62\151\156\x61\162\x79\40\x72\145\x61\x64\x20\155\x6f\144\145");
        goto jhSud;
        jYnI9:
        $this->privSwapBackMagicQuotes();
        goto DD3r8;
        XqmAe:
        $this->privSwapBackMagicQuotes();
        goto j3WXF;
        mL1Q2:
        if (!(($v_result = $this->privReadCentralFileHeader($v_header)) != 1)) {
            goto jgni6;
        }
        goto XqmAe;
        Z7rPk:
        UvuWO:
        goto Qy2ek;
        yomEb:
        $this->privCloseFd();
        goto jYnI9;
        t0Xzt:
    }
    public function privConvertHeader2FileInfo($p_header, &$p_info)
    {
        goto UWTDB;
        ES8al:
        $p_info["\x66\157\154\144\145\162"] = ($p_header["\145\x78\x74\x65\162\x6e\141\154"] & 16) == 16;
        goto e12bL;
        mt36u:
        $p_info["\143\157\155\160\x72\145\163\x73\x65\144\x5f\x73\151\172\145"] = $p_header["\x63\x6f\155\160\x72\145\x73\163\145\x64\137\x73\151\x7a\x65"];
        goto rgyoq;
        xKuuQ:
        $p_info["\x73\164\157\162\145\x64\x5f\x66\151\154\145\156\141\155\145"] = $v_temp_path;
        goto xRuC4;
        X7Ufn:
        $p_info["\143\x72\143"] = $p_header["\143\x72\x63"];
        goto dgTuh;
        xRuC4:
        $p_info["\163\151\172\x65"] = $p_header["\163\151\172\145"];
        goto mt36u;
        LHJ8W:
        $v_temp_path = PclZipUtilPathReduction($p_header["\x66\x69\x6c\x65\x6e\141\155\x65"]);
        goto VuYj8;
        VuYj8:
        $p_info["\x66\x69\x6c\x65\156\141\x6d\145"] = $v_temp_path;
        goto fJXRF;
        mXuXW:
        $p_info["\143\x6f\155\155\x65\x6e\x74"] = $p_header["\143\x6f\155\x6d\145\x6e\x74"];
        goto ES8al;
        rgyoq:
        $p_info["\155\164\151\x6d\145"] = $p_header["\155\164\x69\x6d\x65"];
        goto mXuXW;
        dgTuh:
        return $v_result;
        goto Fr8zz;
        fJXRF:
        $v_temp_path = PclZipUtilPathReduction($p_header["\x73\x74\x6f\162\x65\x64\137\146\151\154\x65\x6e\141\155\145"]);
        goto xKuuQ;
        UWTDB:
        $v_result = 1;
        goto LHJ8W;
        jBjFL:
        $p_info["\163\164\x61\164\x75\x73"] = $p_header["\x73\164\x61\x74\x75\163"];
        goto X7Ufn;
        e12bL:
        $p_info["\151\x6e\144\x65\x78"] = $p_header["\151\x6e\x64\145\x78"];
        goto jBjFL;
        Fr8zz:
    }
    public function privExtractByRule(&$p_file_list, $p_path, $p_remove_path, $p_remove_all_path, &$p_options)
    {
        goto hKnnB;
        hPkJ8:
        return $v_result;
        goto wQbXh;
        rZxE6:
        VQsVS:
        goto ft1ru;
        Q5emZ:
        ctX8V:
        goto QPspc;
        nbb4T:
        iymFz:
        goto LSPZ1;
        FI6ou:
        $j++;
        goto kIFWv;
        NJ4p2:
        $this->privCloseFd();
        goto tF5dN;
        HyhYv:
        Yr9RL:
        goto BMu1a;
        OYPLh:
        goto jMOKR;
        goto tYsCQ;
        zLryW:
        kk_Zh:
        goto HVfDf;
        Egw_z:
        $j++;
        goto U2_fJ;
        UFLjw:
        $j = 0;
        goto kfz1h;
        W0KV7:
        ZIh57:
        goto gJhG9;
        LQx0m:
        if (!($v_result1 < 1)) {
            goto UVbC1;
        }
        goto atfyQ;
        uGPhR:
        fPDXj:
        goto uZ3Pg;
        ft1ru:
        $v_extract = true;
        goto Nrt6M;
        yxA2R:
        $this->privSwapBackMagicQuotes();
        goto styOj;
        oJ55Z:
        $v_result1 = $this->privExtractFileInOutput($v_header, $p_options);
        goto WQSO1;
        NdK3k:
        return PclZip::errorCode();
        goto s9tYT;
        ZO4dC:
        $this->privSwapBackMagicQuotes();
        goto dptJ6;
        DZQdJ:
        $this->privCloseFd();
        goto wZrVq;
        GjEoR:
        DcjrH:
        goto MJaEV;
        HxJg5:
        goto DcjrH;
        goto gyBEy;
        IqTwn:
        ft_vl:
        goto r1so3;
        z0flA:
        if (!($i >= $p_options[PCLZIP_OPT_BY_INDEX][$j]["\163\x74\x61\x72\164"] && $i <= $p_options[PCLZIP_OPT_BY_INDEX][$j]["\145\156\x64"])) {
            goto fPDXj;
        }
        goto Wh5h1;
        mR6NM:
        goto rbg08;
        goto pyt2j;
        Amzuw:
        if (isset($p_options[PCLZIP_OPT_BY_PREG]) && $p_options[PCLZIP_OPT_BY_PREG] != '') {
            goto otmke;
        }
        goto fgqmS;
        tF5dN:
        $this->privSwapBackMagicQuotes();
        goto FZcMW;
        QPspc:
        $v_central_dir = array();
        goto X7tc1;
        kZMtr:
        pxT_X:
        goto Egw_z;
        RqXMY:
        fZzg8:
        goto h9Xgr;
        UlgZi:
        $this->privCloseFd();
        goto HTcGu;
        zZYot:
        qe4eC:
        goto b7WHd;
        QVNO5:
        if (substr($p_options[PCLZIP_OPT_BY_NAME][$j], -1) == "\x2f") {
            goto p1z4p;
        }
        goto MIPX_;
        A1OI0:
        $v_extract = true;
        goto OYPLh;
        gQiBu:
        ve9Bw:
        goto Nig1H;
        xECYX:
        c4au6:
        goto RU2VL;
        YbvQm:
        return $v_result1;
        goto DgQMk;
        fgqmS:
        if (isset($p_options[PCLZIP_OPT_BY_INDEX]) && $p_options[PCLZIP_OPT_BY_INDEX] != 0) {
            goto jiLFP;
        }
        goto A1OI0;
        gJhG9:
        if (!($p_path != "\56\57" && $p_path != "\57")) {
            goto ft_vl;
        }
        goto kgc2g;
        Boqjs:
        $this->privCloseFd();
        goto yjYyv;
        QC5ft:
        if (!preg_match($p_options[PCLZIP_OPT_BY_PREG], $v_header["\x73\164\157\x72\x65\144\137\x66\x69\154\145\x6e\141\155\145"])) {
            goto o8AMc;
        }
        goto hJw2Q;
        SEGik:
        goto rAa7n;
        goto R3VWt;
        Nrt6M:
        w6qLm:
        goto hMIMg;
        wJDuT:
        esCVu:
        goto aGTK4;
        kSawN:
        xOQzH:
        goto mfoK3;
        KiYch:
        goto mX4eI;
        goto ebPe6;
        r0EOR:
        if (isset($p_options[PCLZIP_OPT_EXTRACT_IN_OUTPUT]) && $p_options[PCLZIP_OPT_EXTRACT_IN_OUTPUT]) {
            goto ynpVP;
        }
        goto yU78F;
        N3YRr:
        zLqOz:
        goto WBHpB;
        k42l3:
        $p_path = substr($p_path, 0, strlen($p_path) - 1);
        goto SEGik;
        ugdSU:
        if (!(($v_result = $this->privOpenFd("\162\x62")) != 1)) {
            goto ctX8V;
        }
        goto WHwLI;
        ytxIL:
        $v_nb_extracted = 0;
        goto GjEoR;
        deCDx:
        $this->privSwapBackMagicQuotes();
        goto AMGFg;
        FyxBj:
        if (!(isset($p_options[PCLZIP_OPT_STOP_ON_ERROR]) && $p_options[PCLZIP_OPT_STOP_ON_ERROR] === true)) {
            goto rqP6L;
        }
        goto tD6sX;
        aiXQE:
        $v_string = '';
        goto Udl2Z;
        alDBu:
        if (!(strlen($v_header["\x73\164\157\x72\145\144\137\146\151\x6c\x65\x6e\141\155\145"]) > strlen($p_options[PCLZIP_OPT_BY_NAME][$j]) && substr($v_header["\x73\164\x6f\162\x65\144\137\146\151\x6c\x65\156\x61\x6d\x65"], 0, strlen($p_options[PCLZIP_OPT_BY_NAME][$j])) == $p_options[PCLZIP_OPT_BY_NAME][$j])) {
            goto le4KV;
        }
        goto AI5xk;
        mMkkv:
        niWjQ:
        goto Esy7j;
        Iocm0:
        PclZip::privErrorLog(PCLZIP_ERR_UNSUPPORTED_ENCRYPTION, "\x55\156\x73\165\x70\160\157\162\x74\x65\144\x20\145\156\143\x72\x79\x70\164\151\x6f\156\40\x66\157\x72\x20" . "\40\x66\151\x6c\145\156\141\x6d\x65\40\x27" . $v_header["\163\164\x6f\162\x65\144\137\146\151\154\145\156\141\x6d\145"] . "\47");
        goto NdK3k;
        tYsCQ:
        ahs1Q:
        goto UFLjw;
        aF4Z1:
        eRgDj:
        goto Y52f7;
        rXO0f:
        $v_header["\x73\164\x61\x74\x75\x73"] = "\x75\x6e\x73\x75\160\160\x6f\162\x74\x65\144\137\143\157\x6d\160\162\145\x73\163\x69\x6f\x6e";
        goto N_a8x;
        v32uv:
        if (!($v_result != 1)) {
            goto esCVu;
        }
        goto Hmm3V;
        xzZbd:
        goto w6qLm;
        goto rZxE6;
        Js00K:
        goto w6qLm;
        goto kkK9J;
        hBdTC:
        $p_path = "\56\57" . $p_path;
        goto W0KV7;
        X7tc1:
        if (!(($v_result = $this->privReadEndCentralDir($v_central_dir)) != 1)) {
            goto iymFz;
        }
        goto CO3rk;
        WJ0Gv:
        return $v_result;
        goto Q5emZ;
        Y7dbC:
        fb3W1:
        goto Oy2H6;
        MJaEV:
        if (!($i < $v_central_dir["\x65\156\164\162\151\145\163"])) {
            goto mX4eI;
        }
        goto lmne9;
        hMIMg:
        YXeVx:
        goto FI6ou;
        jgr9h:
        $this->privCloseFd();
        goto uHDj0;
        u5pIR:
        jhz64:
        goto I5SC0;
        C4blF:
        return PclZip::errorCode();
        goto HyhYv;
        QvBVi:
        PclZip::privErrorLog(PCLZIP_ERR_INVALID_ARCHIVE_ZIP, "\111\156\x76\x61\x6c\x69\144\x20\141\x72\143\x68\151\x76\x65\x20\x73\151\172\145");
        goto YnyBk;
        U2_fJ:
        goto p859Q;
        goto kSawN;
        RU2VL:
        goto jMOKR;
        goto OWfT2;
        m8ASb:
        $p_remove_path .= "\57";
        goto G73jd;
        kfz1h:
        bCi7M:
        goto udpjC;
        eCZYy:
        $this->privSwapBackMagicQuotes();
        goto oCWXj;
        KvrmT:
        return PclZip::errorCode();
        goto n7m0Y;
        mc_2R:
        $this->privCloseFd();
        goto yxA2R;
        mpOw7:
        $j = $j_start;
        goto sllbB;
        dnpA8:
        goto xOQzH;
        goto kk6O7;
        Esy7j:
        if (!($p_options[PCLZIP_OPT_BY_INDEX][$j]["\x73\164\x61\162\164"] > $i)) {
            goto Pe1LJ;
        }
        goto dnpA8;
        s9tYT:
        rqP6L:
        goto Y7dbC;
        Iwgd3:
        if (!(($v_result = $this->privReadCentralFileHeader($v_header)) != 1)) {
            goto fZzg8;
        }
        goto m3itY;
        jNQib:
        DyX4V:
        goto V9oRS;
        CO3rk:
        $this->privCloseFd();
        goto kJrcy;
        G73jd:
        eOzmC:
        goto sP8De;
        WQSO1:
        if (!($v_result1 < 1)) {
            goto Kxsmk;
        }
        goto Boqjs;
        MIPX_:
        if ($v_header["\x73\164\x6f\x72\145\x64\137\x66\151\x6c\x65\156\141\155\145"] == $p_options[PCLZIP_OPT_BY_NAME][$j]) {
            goto VQsVS;
        }
        goto Js00K;
        fLe9t:
        $v_nb_extracted++;
        goto wFSeO;
        kgc2g:
        rAa7n:
        goto yIy4r;
        l32jC:
        QLXjw:
        goto I2bMy;
        AI5xk:
        $v_extract = true;
        goto MgEnr;
        Hmm3V:
        $this->privCloseFd();
        goto deCDx;
        Wh5h1:
        $v_extract = true;
        goto uGPhR;
        VabkE:
        $j_start = 0;
        goto wuER8;
        LkDsr:
        return $v_result;
        goto zLryW;
        wFSeO:
        if (!($v_result1 == 2)) {
            goto A6jJT;
        }
        goto EAcCd;
        Fx6tr:
        $v_extract = false;
        goto iujFQ;
        h9Xgr:
        $v_header["\151\x6e\x64\x65\170"] = $i;
        goto sjfYW;
        atfyQ:
        $this->privCloseFd();
        goto eCZYy;
        udpjC:
        if (!($j < sizeof($p_options[PCLZIP_OPT_BY_NAME]) && !$v_extract)) {
            goto c4au6;
        }
        goto QVNO5;
        wuER8:
        $i = 0;
        goto ytxIL;
        HTcGu:
        $this->privSwapBackMagicQuotes();
        goto hPkJ8;
        FDsYJ:
        $v_header["\x73\x74\141\x74\165\x73"] = "\x75\x6e\163\x75\160\160\x6f\162\164\x65\144\137\145\x6e\x63\x72\171\x70\x74\151\x6f\156";
        goto FyxBj;
        HHGB1:
        if (!@fseek($this->zip_fd, $v_header["\x6f\x66\146\163\x65\x74"])) {
            goto DyX4V;
        }
        goto NufmU;
        VYSe1:
        @rewind($this->zip_fd);
        goto HHGB1;
        tD6sX:
        $this->privSwapBackMagicQuotes();
        goto Iocm0;
        ogXcu:
        goto rbg08;
        goto oa3dq;
        yjYyv:
        $this->privSwapBackMagicQuotes();
        goto YbvQm;
        oC1u7:
        PclZip::privErrorLog(PCLZIP_ERR_UNSUPPORTED_COMPRESSION, "\106\x69\154\x65\156\x61\155\145\40\x27" . $v_header["\x73\164\157\162\x65\144\x5f\x66\x69\x6c\x65\x6e\x61\x6d\x65"] . "\47\x20\151\163\40" . "\143\x6f\x6d\x70\162\145\163\x73\145\x64\40\142\x79\40\141\156\x20\165\156\163\x75\160\x70\x6f\x72\164\145\x64\40\143\157\x6d\x70\162\145\163\163\x69\157\156\x20" . "\x6d\145\x74\x68\157\x64\x20\x28" . $v_header["\x63\157\155\160\162\x65\x73\163\x69\157\156"] . "\x29\40");
        goto KvrmT;
        Y52f7:
        rbg08:
        goto XjbxQ;
        styOj:
        return $v_result1;
        goto l32jC;
        iiQZG:
        A6jJT:
        goto mR6NM;
        wZrVq:
        $this->privSwapBackMagicQuotes();
        goto yLs46;
        sllbB:
        p859Q:
        goto N_Cf5;
        kIFWv:
        goto bCi7M;
        goto xECYX;
        YnyBk:
        return PclZip::errorCode();
        goto jNQib;
        uHDj0:
        $this->privSwapBackMagicQuotes();
        goto LkDsr;
        EUWje:
        jiLFP:
        goto mpOw7;
        b7WHd:
        $i++;
        goto HxJg5;
        yKRw8:
        $this->privCloseFd();
        goto ZO4dC;
        WHwLI:
        $this->privSwapBackMagicQuotes();
        goto WJ0Gv;
        sjfYW:
        $v_pos_entry = ftell($this->zip_fd);
        goto Fx6tr;
        hJw2Q:
        $v_extract = true;
        goto Jd3QJ;
        lmne9:
        @rewind($this->zip_fd);
        goto OJ0e5;
        dptJ6:
        return $v_result;
        goto u5pIR;
        gyBEy:
        mX4eI:
        goto NJ4p2;
        gAVH2:
        goto jMOKR;
        goto EUWje;
        Nig1H:
        if (!$v_extract) {
            goto OeXBK;
        }
        goto VYSe1;
        I5SC0:
        $p_file_list[$v_nb_extracted]["\143\x6f\x6e\x74\145\156\164"] = $v_string;
        goto fLe9t;
        aGTK4:
        $v_extract = false;
        goto gQiBu;
        OWfT2:
        otmke:
        goto QC5ft;
        tR4Di:
        UVbC1:
        goto beL1g;
        fydzS:
        $this->privSwapBackMagicQuotes();
        goto IZQG7;
        hKnnB:
        $v_result = 1;
        goto GqYBZ;
        AMGFg:
        return $v_result;
        goto wJDuT;
        n7m0Y:
        b97Ew:
        goto N3YRr;
        r1so3:
        if (!($p_remove_path != '' && substr($p_remove_path, -1) != "\x2f")) {
            goto eOzmC;
        }
        goto m8ASb;
        Udl2Z:
        $v_result1 = $this->privExtractFileAsString($v_header, $v_string, $p_options);
        goto LQx0m;
        N_a8x:
        if (!(isset($p_options[PCLZIP_OPT_STOP_ON_ERROR]) && $p_options[PCLZIP_OPT_STOP_ON_ERROR] === true)) {
            goto b97Ew;
        }
        goto Qwxqu;
        EAcCd:
        goto mX4eI;
        goto iiQZG;
        f7abS:
        if (!($v_result1 < 1)) {
            goto QLXjw;
        }
        goto mc_2R;
        Qwxqu:
        $this->privSwapBackMagicQuotes();
        goto oC1u7;
        HVfDf:
        if (!($v_result1 == 2)) {
            goto eRgDj;
        }
        goto bUnrY;
        MgEnr:
        le4KV:
        goto xzZbd;
        ebPe6:
        u0fZf:
        goto ogXcu;
        SbrF5:
        if (!($v_result1 == 2)) {
            goto u0fZf;
        }
        goto KiYch;
        yLs46:
        PclZip::privErrorLog(PCLZIP_ERR_INVALID_ARCHIVE_ZIP, "\111\x6e\166\141\154\x69\144\x20\141\162\x63\150\151\166\145\x20\x73\x69\x7a\145");
        goto C4blF;
        OBFVv:
        if (!(($v_result = $this->privConvertHeader2FileInfo($v_header, $p_file_list[$v_nb_extracted++])) != 1)) {
            goto kk_Zh;
        }
        goto jgr9h;
        Jd3QJ:
        o8AMc:
        goto gAVH2;
        BMu1a:
        $v_header = array();
        goto Iwgd3;
        sP8De:
        $p_remove_path_size = strlen($p_remove_path);
        goto ugdSU;
        I2bMy:
        if (!(($v_result = $this->privConvertHeader2FileInfo($v_header, $p_file_list[$v_nb_extracted++])) != 1)) {
            goto KmoA1;
        }
        goto UlgZi;
        M0xqB:
        $j_start = $j + 1;
        goto mMkkv;
        FZcMW:
        return $v_result;
        goto hsGUS;
        WBHpB:
        if (!($v_extract && ($v_header["\146\x6c\x61\147"] & 1) == 1)) {
            goto fb3W1;
        }
        goto FDsYJ;
        wQbXh:
        KmoA1:
        goto SbrF5;
        kJrcy:
        $this->privSwapBackMagicQuotes();
        goto wHoKC;
        Oy2H6:
        if (!($v_extract && $v_header["\163\x74\x61\164\165\x73"] != "\x6f\153")) {
            goto ve9Bw;
        }
        goto n4zEb;
        kkK9J:
        p1z4p:
        goto alDBu;
        R3VWt:
        b8kKt:
        goto IqTwn;
        mfoK3:
        jMOKR:
        goto C_3x0;
        kk6O7:
        Pe1LJ:
        goto kZMtr;
        IZQG7:
        return $v_result;
        goto RqXMY;
        C_3x0:
        if (!($v_extract && ($v_header["\x63\x6f\155\160\x72\x65\163\x73\x69\157\156"] != 8 && $v_header["\143\x6f\x6d\x70\162\x65\x73\163\151\157\156"] != 0))) {
            goto zLqOz;
        }
        goto rXO0f;
        beL1g:
        if (!(($v_result = $this->privConvertHeader2FileInfo($v_header, $p_file_list[$v_nb_extracted])) != 1)) {
            goto jhz64;
        }
        goto yKRw8;
        yU78F:
        $v_result1 = $this->privExtractFile($v_header, $p_path, $p_remove_path, $p_remove_all_path, $p_options);
        goto f7abS;
        yIy4r:
        if (!(substr($p_path, -1) == "\57")) {
            goto b8kKt;
        }
        goto k42l3;
        StGg0:
        if (!($p_path == '' || substr($p_path, 0, 1) != "\57" && substr($p_path, 0, 3) != "\56\x2e\57" && substr($p_path, 1, 2) != "\72\57")) {
            goto ZIh57;
        }
        goto hBdTC;
        LSPZ1:
        $v_pos_entry = $v_central_dir["\157\146\x66\163\x65\x74"];
        goto VabkE;
        GqYBZ:
        $this->privDisableMagicQuotes();
        goto StGg0;
        oa3dq:
        Ost4B:
        goto aiXQE;
        uZ3Pg:
        if (!($i >= $p_options[PCLZIP_OPT_BY_INDEX][$j]["\x65\x6e\x64"])) {
            goto niWjQ;
        }
        goto M0xqB;
        A875x:
        $this->privSwapBackMagicQuotes();
        goto QvBVi;
        iujFQ:
        if (isset($p_options[PCLZIP_OPT_BY_NAME]) && $p_options[PCLZIP_OPT_BY_NAME] != 0) {
            goto ahs1Q;
        }
        goto Amzuw;
        OJ0e5:
        if (!@fseek($this->zip_fd, $v_pos_entry)) {
            goto Yr9RL;
        }
        goto DZQdJ;
        DgQMk:
        Kxsmk:
        goto OBFVv;
        N_Cf5:
        if (!($j < sizeof($p_options[PCLZIP_OPT_BY_INDEX]) && !$v_extract)) {
            goto xOQzH;
        }
        goto z0flA;
        bUnrY:
        goto mX4eI;
        goto aF4Z1;
        pyt2j:
        ynpVP:
        goto oJ55Z;
        n4zEb:
        $v_result = $this->privConvertHeader2FileInfo($v_header, $p_file_list[$v_nb_extracted++]);
        goto v32uv;
        V9oRS:
        if ($p_options[PCLZIP_OPT_EXTRACT_AS_STRING]) {
            goto Ost4B;
        }
        goto r0EOR;
        oCWXj:
        return $v_result1;
        goto tR4Di;
        m3itY:
        $this->privCloseFd();
        goto fydzS;
        NufmU:
        $this->privCloseFd();
        goto A875x;
        wHoKC:
        return $v_result;
        goto nbb4T;
        XjbxQ:
        OeXBK:
        goto zZYot;
        hsGUS:
    }
    public function privExtractFile(&$p_entry, $p_path, $p_remove_path, $p_remove_all_path, &$p_options)
    {
        goto COMef;
        UbLG2:
        $v_result = 1;
        goto TA1P6;
        kJEP5:
        $p_entry["\146\x69\x6c\x65\x6e\x61\x6d\x65"] = $v_local_header["\x66\151\x6c\x65\x6e\141\155\x65"];
        goto RlGR6;
        ryDJ4:
        if (!(($v_result = $this->privDirCheck($v_dir_to_check, ($p_entry["\x65\170\x74\145\x72\x6e\141\154"] & 16) == 16)) != 1)) {
            goto S4LO7;
        }
        goto INi_T;
        k0Yab:
        touch($p_entry["\x66\151\x6c\145\x6e\x61\x6d\145"], $p_entry["\x6d\x74\151\155\145"]);
        goto qJtND;
        miEmH:
        qPM6t:
        goto z4lJP;
        JRyPX:
        t6yBN:
        goto I1tq7;
        EvWUu:
        $v_size -= $v_read_size;
        goto ntvzu;
        FxiFG:
        $v_local_header = array();
        goto r3Qj0;
        xYfgH:
        PclZip::privErrorLog(PCLZIP_ERR_UNSUPPORTED_ENCRYPTION, "\x46\x69\154\x65\x20\x27" . $p_entry["\x66\x69\x6c\145\156\x61\155\145"] . "\x27\40\151\163\40\145\156\143\x72\x79\x70\164\x65\x64\56\40\x45\x6e\143\x72\171\x70\164\145\144\x20\146\x69\154\145\163\40\x61\x72\x65\x20\156\x6f\x74\x20\x73\165\x70\x70\157\162\164\145\144\x2e");
        goto U_xmr;
        DlCB7:
        fclose($v_dest_file);
        goto k0Yab;
        UhZwg:
        $p_entry["\163\x74\141\164\x75\163"] = "\x65\x72\x72\x6f\162";
        goto Mgl_i;
        j_P2i:
        GYQnX:
        goto DXG8F;
        KohLC:
        if (($p_entry["\x65\170\x74\145\x72\x6e\x61\154"] & 16) == 16 || substr($p_entry["\x66\x69\x6c\145\x6e\141\155\x65"], -1) == "\57") {
            goto ewELf;
        }
        goto ZtQj1;
        LPAFX:
        $v_read_size = $v_size < PCLZIP_READ_BLOCK_SIZE ? $v_size : PCLZIP_READ_BLOCK_SIZE;
        goto hNNEO;
        LmQZR:
        if (!isset($p_options[PCLZIP_OPT_SET_CHMOD])) {
            goto ivHwO;
        }
        goto RYFdq;
        oNAvh:
        p1S_F:
        goto rCjKT;
        BvuXP:
        Il1tk:
        goto DvdVG;
        vFNTr:
        goto xJrZa;
        goto mp_Rx;
        T6X5E:
        xJrZa:
        goto ryDJ4;
        taYwq:
        $v_inclusion = PclZipUtilPathInclusion($p_options[PCLZIP_OPT_EXTRACT_DIR_RESTRICTION], $p_entry["\x66\x69\x6c\145\156\141\155\x65"]);
        goto TnGVB;
        EXSvG:
        $p_entry["\x73\x74\x61\x74\165\163"] = "\x77\x72\x69\x74\145\x5f\160\162\x6f\164\145\143\164\145\144";
        goto EHzDD;
        xS9dR:
        $v_dir_to_check = dirname($p_entry["\146\151\x6c\x65\x6e\141\x6d\145"]);
        goto neg9A;
        Pi1M2:
        if (!is_writeable($p_entry["\x66\151\154\145\x6e\141\155\x65"])) {
            goto Fpi53;
        }
        goto hTVKD;
        U7qEs:
        $p_entry["\163\x74\x61\x74\165\163"] = "\141\154\162\145\141\144\171\x5f\141\x5f\144\x69\x72\145\143\164\157\x72\x79";
        goto HvBRV;
        OPB3m:
        PclZip::privErrorLog(PCLZIP_ERR_ALREADY_A_DIRECTORY, "\106\x69\x6c\145\x6e\141\x6d\x65\40\47" . $p_entry["\x66\151\x6c\x65\156\141\x6d\145"] . "\x27\x20\151\163\40" . "\x61\x6c\x72\145\x61\144\171\x20\x75\163\x65\x64\40\142\171\40\141\156\40\x65\170\x69\x73\164\151\x6e\x67\x20\x64\151\x72\x65\143\x74\157\x72\x79");
        goto oB8Xn;
        ZtiYP:
        return $v_result;
        goto USplM;
        IVupO:
        $p_entry["\163\x74\x61\x74\x75\x73"] = "\x66\151\154\x74\x65\162\145\x64";
        goto MFC1U;
        Eq2P2:
        @fclose($v_dest_file);
        goto slzAy;
        kO59J:
        zfh4g:
        goto NMY17;
        VCcqy:
        $p_entry["\x73\164\x61\164\165\x73"] = "\x77\162\x69\164\x65\137\x65\162\x72\157\x72";
        goto ZtiYP;
        R9UjO:
        if ($p_entry["\x73\164\141\x74\165\163"] == "\141\x62\157\x72\x74\145\144") {
            goto N_74T;
        }
        goto U2U7z;
        INi_T:
        $p_entry["\163\x74\141\164\x75\163"] = "\x70\x61\x74\x68\x5f\143\162\x65\x61\x74\151\157\156\137\146\141\151\x6c";
        goto LJehj;
        zOuep:
        if (!($this->privCheckFileHeaders($v_header, $p_entry) != 1)) {
            goto DSQeK;
        }
        goto Knmfi;
        ZEw27:
        $p_entry["\x73\x74\x61\164\165\x73"] = "\x73\153\151\160\160\x65\144";
        goto UbLG2;
        U_xmr:
        return PclZip::errorCode();
        goto yJgFF;
        YNI6F:
        $v_buffer = @fread($this->zip_fd, $p_entry["\x63\x6f\x6d\x70\162\145\163\163\145\144\137\163\x69\x7a\x65"]);
        goto V9aVu;
        WR7sn:
        $this->privConvertHeader2FileInfo($p_entry, $v_local_header);
        goto BnDW5;
        uWf0f:
        if (!($v_result == 2)) {
            goto hsmTm;
        }
        goto y9rvA;
        RYFdq:
        @chmod($p_entry["\146\x69\154\x65\156\x61\x6d\145"], $p_options[PCLZIP_OPT_SET_CHMOD]);
        goto T8MBr;
        dyHYf:
        goto eapwT;
        goto dMDaX;
        RlGR6:
        Xu5Yi:
        goto Mtyko;
        Du5io:
        return $v_result;
        goto Ptfrb;
        z4lJP:
        $v_size = $p_entry["\143\157\x6d\160\162\x65\163\163\145\144\137\x73\x69\x7a\x65"];
        goto zB_iH;
        EbgdH:
        EQwIL:
        goto k9oeF;
        Yqxe4:
        N_74T:
        goto Nh1WL;
        DjNsf:
        if (!($v_result == 0)) {
            goto kSZK4;
        }
        goto ZEw27;
        iqz_a:
        S4LO7:
        goto J0gQi;
        DXG8F:
        if (!(($p_entry["\145\170\x74\x65\162\156\141\154"] & 16) == 16)) {
            goto h7EYI;
        }
        goto Whpnt;
        rsss5:
        if (!(isset($p_options[PCLZIP_OPT_STOP_ON_ERROR]) && $p_options[PCLZIP_OPT_STOP_ON_ERROR] === true)) {
            goto pEsRt;
        }
        goto Uk3jh;
        al_M9:
        return PclZip::errorCode();
        goto BvuXP;
        G6lHC:
        UeLfM:
        goto vQuQX;
        G8gPh:
        LWpI7:
        goto DlCB7;
        qJtND:
        S63zm:
        goto LmQZR;
        I1tq7:
        Fe2GR:
        goto jPos7;
        zB_iH:
        b5zKl:
        goto a01VR;
        J0gQi:
        goto XL_7f;
        goto kO59J;
        JsPzs:
        if (!(($p_entry["\146\x6c\141\147"] & 1) == 1)) {
            goto vPK7K;
        }
        goto xYfgH;
        FN1MT:
        $v_dir_to_check = '';
        goto T6X5E;
        WNtFD:
        if (!isset($p_options[PCLZIP_OPT_EXTRACT_DIR_RESTRICTION])) {
            goto L27BW;
        }
        goto taYwq;
        y9rvA:
        $p_entry["\163\164\141\x74\165\x73"] = "\141\x62\157\162\x74\x65\144";
        goto BaabF;
        tIzJz:
        $v_result = $p_options[PCLZIP_CB_POST_EXTRACT](PCLZIP_CB_POST_EXTRACT, $v_local_header);
        goto Y0lwA;
        oXvY4:
        if (!isset($p_options[PCLZIP_OPT_TEMP_FILE_OFF]) && (isset($p_options[PCLZIP_OPT_TEMP_FILE_ON]) || isset($p_options[PCLZIP_OPT_TEMP_FILE_THRESHOLD]) && $p_options[PCLZIP_OPT_TEMP_FILE_THRESHOLD] <= $p_entry["\x73\x69\172\x65"])) {
            goto FSBX1;
        }
        goto YNI6F;
        vQuQX:
        if (isset($p_options[PCLZIP_OPT_REPLACE_NEWER]) && $p_options[PCLZIP_OPT_REPLACE_NEWER] === true) {
            goto o89vK;
        }
        goto llGRh;
        FkV3p:
        return $v_result;
        goto eOJrM;
        Mgl_i:
        return $v_result;
        goto brGBp;
        rCjKT:
        goto eapwT;
        goto kkcED;
        lqktl:
        fPJ4k:
        goto ObRHl;
        NuOt8:
        if (file_exists($p_entry["\x66\x69\x6c\x65\156\141\x6d\145"])) {
            goto zfh4g;
        }
        goto KohLC;
        Zuhrd:
        goto Fe2GR;
        goto bw8JM;
        RPIib:
        $v_result = $this->privExtractFileUsingTempFile($p_entry, $p_options);
        goto nwLxi;
        neg9A:
        goto xJrZa;
        goto NDxEZ;
        llGRh:
        $p_entry["\x73\164\141\164\165\x73"] = "\x6e\145\167\x65\x72\x5f\145\x78\151\x73\164";
        goto rsss5;
        ZtQj1:
        if (!strstr($p_entry["\x66\151\154\145\156\x61\x6d\x65"], "\57")) {
            goto jpUu4;
        }
        goto xS9dR;
        jPos7:
        if (!($p_path != '')) {
            goto oZE1N;
        }
        goto qW6_K;
        eMxMs:
        @touch($p_entry["\x66\151\154\x65\156\x61\x6d\145"], $p_entry["\x6d\x74\151\155\x65"]);
        goto gPt9E;
        Mtyko:
        if (!($p_entry["\x73\x74\x61\x74\x75\163"] == "\157\x6b")) {
            goto Rv9Iy;
        }
        goto NuOt8;
        IfOsr:
        eapwT:
        goto ecm7f;
        waBnI:
        return $v_result;
        goto Fj0UX;
        RwVbA:
        if (($p_entry["\145\x78\x74\145\x72\156\141\x6c"] & 16) == 16) {
            goto qktki;
        }
        goto FhXSl;
        oB8Xn:
        return PclZip::errorCode();
        goto oNAvh;
        hNNEO:
        $v_buffer = @fread($this->zip_fd, $v_read_size);
        goto zC9a5;
        ps1h7:
        qxsJT:
        goto R9UjO;
        Uk3jh:
        PclZip::privErrorLog(PCLZIP_ERR_WRITE_OPEN_FAIL, "\116\145\167\x65\162\x20\x76\145\162\x73\x69\x6f\x6e\40\x6f\146\x20\x27" . $p_entry["\146\x69\x6c\145\x6e\x61\155\145"] . "\47\40\145\170\151\163\164\x73\40" . "\x61\x6e\144\x20\157\160\x74\151\x6f\156\x20\120\x43\x4c\x5a\x49\x50\137\117\120\124\137\x52\105\x50\114\101\103\105\x5f\116\105\x57\105\x52\x20\x69\x73\40\x6e\157\x74\40\x73\x65\x6c\145\x63\x74\x65\144");
        goto s5LBo;
        gPt9E:
        goto S63zm;
        goto lqktl;
        DvdVG:
        L27BW:
        goto A63Rp;
        Y0lwA:
        if (!($v_result == 2)) {
            goto IjkOA;
        }
        goto ygRJV;
        Bvw1S:
        goto M0gm2;
        goto w68i8;
        Nh0kY:
        if (!(($v_dest_file = @fopen($p_entry["\146\x69\154\x65\156\141\155\145"], "\x77\x62")) == 0)) {
            goto rm9pd;
        }
        goto VCcqy;
        QvAjJ:
        @fwrite($v_dest_file, $v_file_content, $p_entry["\163\151\x7a\x65"]);
        goto gZ1gR;
        MFC1U:
        return $v_result;
        goto asvXV;
        gZ1gR:
        unset($v_file_content);
        goto Eq2P2;
        QV9JZ:
        if (!($p_entry["\163\164\141\164\165\163"] == "\x6f\x6b")) {
            goto qxsJT;
        }
        goto RwVbA;
        MyYXF:
        oZE1N:
        goto WNtFD;
        T8MBr:
        ivHwO:
        goto farBP;
        LJehj:
        $v_result = 1;
        goto iqz_a;
        Y1yt8:
        Rv9Iy:
        goto QV9JZ;
        A63Rp:
        if (!isset($p_options[PCLZIP_CB_PRE_EXTRACT])) {
            goto Xu5Yi;
        }
        goto BJOz1;
        jvaRz:
        if (!(substr($p_entry["\146\x69\154\x65\156\x61\155\x65"], 0, $p_remove_path_size) == $p_remove_path)) {
            goto t6yBN;
        }
        goto lZOPV;
        ecm7f:
        XL_7f:
        goto Y1yt8;
        MKjJo:
        $p_remove_path_size = strlen($p_remove_path);
        goto jvaRz;
        BnDW5:
        $v_result = $p_options[PCLZIP_CB_PRE_EXTRACT](PCLZIP_CB_PRE_EXTRACT, $v_local_header);
        goto DjNsf;
        ObRHl:
        if (!(($v_dest_file = @fopen($p_entry["\146\x69\x6c\145\156\141\155\x65"], "\167\142")) == 0)) {
            goto qPM6t;
        }
        goto PXICW;
        eOJrM:
        nUp2w:
        goto zOuep;
        iChUQ:
        if ($p_remove_all_path == true) {
            goto GYQnX;
        }
        goto KJnWS;
        s5LBo:
        return PclZip::errorCode();
        goto i9Dtz;
        k9oeF:
        goto eapwT;
        goto G6lHC;
        fGLIb:
        if (!(PclZipUtilPathInclusion($p_remove_path, $p_entry["\x66\x69\x6c\145\156\x61\x6d\x65"]) == 2)) {
            goto BUxbf;
        }
        goto IVupO;
        a01VR:
        if (!($v_size != 0)) {
            goto LWpI7;
        }
        goto LPAFX;
        MMMtj:
        return PclZip::errorCode();
        goto EbgdH;
        qW6_K:
        $p_entry["\146\151\154\145\156\141\155\x65"] = $p_path . "\57" . $p_entry["\x66\151\x6c\x65\x6e\x61\x6d\x65"];
        goto MyYXF;
        OM9Hg:
        FSBX1:
        goto RPIib;
        brGBp:
        bvZlQ:
        goto Nh0kY;
        N96N1:
        UGa3m:
        goto FxiFG;
        zC9a5:
        @fwrite($v_dest_file, $v_buffer, $v_read_size);
        goto EvWUu;
        EhJl9:
        unset($v_buffer);
        goto oY5Pp;
        Whpnt:
        $p_entry["\x73\x74\141\x74\165\163"] = "\x66\x69\x6c\x74\145\162\145\144";
        goto waBnI;
        XDQ5B:
        M0gm2:
        goto IfOsr;
        ntvzu:
        goto b5zKl;
        goto G8gPh;
        COMef:
        $v_result = 1;
        goto jVoWN;
        i9Dtz:
        pEsRt:
        goto Bvw1S;
        oY5Pp:
        if (!($v_file_content === false)) {
            goto bvZlQ;
        }
        goto UhZwg;
        nwLxi:
        if (!($v_result < PCLZIP_ERR_NO_ERROR)) {
            goto z7vIT;
        }
        goto ZAqsc;
        NMY17:
        if (is_dir($p_entry["\146\151\x6c\145\156\x61\x6d\145"])) {
            goto LDbSv;
        }
        goto Pi1M2;
        mDaIP:
        goto Fe2GR;
        goto j_P2i;
        eO7nQ:
        $v_dir_to_check = $p_entry["\x66\x69\154\145\x6e\x61\155\145"];
        goto vFNTr;
        NDxEZ:
        ewELf:
        goto eO7nQ;
        MaLig:
        return $v_result;
        goto miEmH;
        asvXV:
        BUxbf:
        goto MKjJo;
        SxdGD:
        goto q303u;
        goto N96N1;
        PXICW:
        $p_entry["\163\164\141\x74\165\163"] = "\167\x72\x69\164\145\137\145\162\162\157\162";
        goto MaLig;
        lZOPV:
        $p_entry["\146\151\154\145\x6e\141\x6d\145"] = substr($p_entry["\146\x69\x6c\x65\x6e\x61\155\x65"], $p_remove_path_size);
        goto JRyPX;
        TA1P6:
        kSZK4:
        goto uWf0f;
        dMDaX:
        LDbSv:
        goto U7qEs;
        TnGVB:
        if (!($v_inclusion == 0)) {
            goto Il1tk;
        }
        goto SuUEK;
        slzAy:
        goto j_q4J;
        goto OM9Hg;
        zZ_b3:
        hsmTm:
        goto kJEP5;
        Knmfi:
        DSQeK:
        goto iChUQ;
        ZAqsc:
        return $v_result;
        goto tiL65;
        tiL65:
        z7vIT:
        goto gJWId;
        farBP:
        qktki:
        goto ps1h7;
        mp_Rx:
        jpUu4:
        goto FN1MT;
        Fj0UX:
        h7EYI:
        goto le_Xf;
        LvEX3:
        PclZip::privErrorLog(PCLZIP_ERR_WRITE_OPEN_FAIL, "\x46\x69\x6c\x65\156\141\155\145\40\x27" . $p_entry["\x66\151\x6c\x65\156\x61\155\145"] . "\x27\40\x65\x78\151\163\x74\x73\40" . "\141\x6e\x64\x20\x69\x73\40\167\x72\x69\x74\x65\40\x70\162\157\x74\145\143\164\145\x64");
        goto MMMtj;
        yJgFF:
        vPK7K:
        goto oXvY4;
        FhXSl:
        if ($p_entry["\143\157\155\x70\162\x65\163\163\151\157\156"] == 0) {
            goto fPJ4k;
        }
        goto JsPzs;
        BJOz1:
        $v_local_header = array();
        goto WR7sn;
        le_Xf:
        $p_entry["\146\x69\154\145\156\141\155\x65"] = basename($p_entry["\146\x69\x6c\x65\156\x61\x6d\x65"]);
        goto Zuhrd;
        KJnWS:
        if ($p_remove_path != '') {
            goto Yek0c;
        }
        goto mDaIP;
        USplM:
        rm9pd:
        goto QvAjJ;
        kkcED:
        Fpi53:
        goto EXSvG;
        R5MvJ:
        q303u:
        goto Du5io;
        FJX99:
        goto q303u;
        goto Yqxe4;
        r3Qj0:
        $this->privConvertHeader2FileInfo($p_entry, $v_local_header);
        goto tIzJz;
        bw8JM:
        Yek0c:
        goto fGLIb;
        gJWId:
        j_q4J:
        goto eMxMs;
        BaabF:
        $v_result = PCLZIP_ERR_USER_ABORTED;
        goto zZ_b3;
        w68i8:
        o89vK:
        goto XDQ5B;
        V9aVu:
        $v_file_content = @gzinflate($v_buffer);
        goto EhJl9;
        Nh1WL:
        $p_entry["\163\x74\x61\x74\165\163"] = "\163\153\x69\160\160\145\x64";
        goto SxdGD;
        EHzDD:
        if (!(isset($p_options[PCLZIP_OPT_STOP_ON_ERROR]) && $p_options[PCLZIP_OPT_STOP_ON_ERROR] === true)) {
            goto EQwIL;
        }
        goto LvEX3;
        jVoWN:
        if (!(($v_result = $this->privReadFileHeader($v_header)) != 1)) {
            goto nUp2w;
        }
        goto FkV3p;
        U2U7z:
        if (isset($p_options[PCLZIP_CB_POST_EXTRACT])) {
            goto UGa3m;
        }
        goto FJX99;
        hTVKD:
        if (filemtime($p_entry["\146\x69\x6c\145\156\x61\x6d\x65"]) > $p_entry["\155\x74\151\x6d\145"]) {
            goto UeLfM;
        }
        goto dyHYf;
        LD4mR:
        IjkOA:
        goto R5MvJ;
        SuUEK:
        PclZip::privErrorLog(PCLZIP_ERR_DIRECTORY_RESTRICTION, "\x46\x69\x6c\145\x6e\x61\155\x65\x20\x27" . $p_entry["\146\151\154\x65\x6e\x61\x6d\145"] . "\x27\x20\151\x73\x20" . "\x6f\165\x74\163\x69\144\x65\40\x50\x43\114\132\111\120\x5f\117\x50\x54\137\x45\x58\x54\122\101\x43\124\x5f\104\111\122\137\x52\105\123\x54\x52\x49\x43\124\x49\117\116");
        goto al_M9;
        ygRJV:
        $v_result = PCLZIP_ERR_USER_ABORTED;
        goto LD4mR;
        HvBRV:
        if (!(isset($p_options[PCLZIP_OPT_STOP_ON_ERROR]) && $p_options[PCLZIP_OPT_STOP_ON_ERROR] === true)) {
            goto p1S_F;
        }
        goto OPB3m;
        Ptfrb:
    }
    public function privExtractFileUsingTempFile(&$p_entry, &$p_options)
    {
        goto gkDvZ;
        mIswP:
        @unlink($v_gzip_temp_name);
        goto a0Wdv;
        tsbJX:
        $v_size -= $v_read_size;
        goto Dvt8o;
        soWme:
        goto aU6BT;
        goto KTrwM;
        rjf2Y:
        $p_entry["\163\x74\x61\x74\165\163"] = "\162\145\141\144\x5f\x65\162\x72\x6f\x72";
        goto qYq8u;
        Xdizk:
        @fclose($v_dest_file);
        goto GSo0P;
        pVkEI:
        KdH2k:
        goto qpVgI;
        B97c1:
        aabLW:
        goto Xdizk;
        Ca_0g:
        $v_size -= $v_read_size;
        goto soWme;
        AR3DZ:
        PclZip::privErrorLog(PCLZIP_ERR_WRITE_OPEN_FAIL, "\125\x6e\141\x62\x6c\x65\40\164\x6f\x20\x6f\x70\x65\156\40\164\145\155\160\157\162\x61\162\x79\40\146\151\x6c\145\40\x27" . $v_gzip_temp_name . "\x27\x20\x69\x6e\x20\x62\x69\156\x61\162\x79\40\x77\162\151\164\145\40\155\x6f\144\145");
        goto NkMkN;
        C04CD:
        @fwrite($v_dest_file, $v_buffer, $v_read_size);
        goto Ca_0g;
        qd97l:
        return $v_result;
        goto sYpWE;
        GSo0P:
        @gzclose($v_src_file);
        goto mIswP;
        vtE47:
        Ph8UO:
        goto giuI8;
        qpVgI:
        $v_size = $p_entry["\x73\151\172\x65"];
        goto gMT80;
        NkMkN:
        return PclZip::errorCode();
        goto vtE47;
        Yn5VS:
        if (!($v_size != 0)) {
            goto bSpeJ;
        }
        goto KmaNb;
        PH9vM:
        $v_binary_data = pack("\x56\x56", $p_entry["\143\x72\143"], $p_entry["\163\x69\x7a\145"]);
        goto XDn3N;
        KNJLX:
        @fclose($v_dest_file);
        goto rjf2Y;
        l243_:
        $p_entry["\163\x74\141\164\165\163"] = "\167\x72\151\164\145\x5f\x65\x72\162\x6f\x72";
        goto qd97l;
        hV3Pi:
        if (!(($v_src_file = @gzopen($v_gzip_temp_name, "\x72\142")) == 0)) {
            goto KdH2k;
        }
        goto KNJLX;
        cFulX:
        fclose($v_file);
        goto AR3DZ;
        RQ2rV:
        @fwrite($v_dest_file, $v_buffer, $v_read_size);
        goto tsbJX;
        KTrwM:
        bSpeJ:
        goto PH9vM;
        a0Wdv:
        return $v_result;
        goto g9H5u;
        XDn3N:
        @fwrite($v_dest_file, $v_binary_data, 8);
        goto UXjOe;
        gMT80:
        CSsks:
        goto g7yPM;
        mNTEZ:
        $v_buffer = @fread($this->zip_fd, $v_read_size);
        goto C04CD;
        kM1qg:
        $v_buffer = @gzread($v_src_file, $v_read_size);
        goto RQ2rV;
        dQxFO:
        $v_gzip_temp_name = PCLZIP_TEMPORARY_DIR . uniqid("\x70\x63\x6c\x7a\151\x70\55") . "\56\x67\172";
        goto zRfPB;
        yyE6o:
        $v_size = $p_entry["\143\157\x6d\160\x72\145\x73\163\x65\144\x5f\163\x69\x7a\x65"];
        goto pSIwU;
        BYA2S:
        if (!(($v_dest_file = @fopen($p_entry["\146\x69\154\145\156\141\155\x65"], "\x77\142")) == 0)) {
            goto O3zoa;
        }
        goto l243_;
        pSIwU:
        aU6BT:
        goto Yn5VS;
        UXjOe:
        @fclose($v_dest_file);
        goto BYA2S;
        gkDvZ:
        $v_result = 1;
        goto dQxFO;
        g7yPM:
        if (!($v_size != 0)) {
            goto aabLW;
        }
        goto ciq6W;
        sYpWE:
        O3zoa:
        goto hV3Pi;
        qYq8u:
        PclZip::privErrorLog(PCLZIP_ERR_READ_OPEN_FAIL, "\125\x6e\141\x62\154\145\40\x74\157\40\x6f\x70\x65\x6e\x20\164\x65\155\160\157\x72\x61\x72\171\40\146\151\x6c\x65\40\47" . $v_gzip_temp_name . "\47\x20\151\x6e\40\x62\x69\x6e\x61\162\x79\x20\162\x65\141\144\40\155\x6f\x64\145");
        goto i8f93;
        YF1F1:
        @fwrite($v_dest_file, $v_binary_data, 10);
        goto yyE6o;
        i8f93:
        return PclZip::errorCode();
        goto pVkEI;
        Dvt8o:
        goto CSsks;
        goto B97c1;
        zRfPB:
        if (!(($v_dest_file = @fopen($v_gzip_temp_name, "\167\142")) == 0)) {
            goto Ph8UO;
        }
        goto cFulX;
        KmaNb:
        $v_read_size = $v_size < PCLZIP_READ_BLOCK_SIZE ? $v_size : PCLZIP_READ_BLOCK_SIZE;
        goto mNTEZ;
        giuI8:
        $v_binary_data = pack("\x76\x61\61\141\61\x56\141\x31\141\61", 35615, Chr($p_entry["\143\157\155\160\162\x65\x73\163\x69\157\x6e"]), Chr(0), time(), Chr(0), Chr(3));
        goto YF1F1;
        ciq6W:
        $v_read_size = $v_size < PCLZIP_READ_BLOCK_SIZE ? $v_size : PCLZIP_READ_BLOCK_SIZE;
        goto kM1qg;
        g9H5u:
    }
    public function privExtractFileInOutput(&$p_entry, &$p_options)
    {
        goto Eaj3M;
        MIqxE:
        if (isset($p_options[PCLZIP_CB_POST_EXTRACT])) {
            goto igt8m;
        }
        goto Yl5R6;
        xXyJv:
        iDFjR:
        goto GdrX0;
        dR1uD:
        $v_file_content = gzinflate($v_buffer);
        goto I5HPI;
        F4JDz:
        echo $v_buffer;
        goto Etqma;
        jZEEb:
        k2ZWv:
        goto ANG2F;
        ozKwR:
        $v_result = PCLZIP_ERR_USER_ABORTED;
        goto Tq0Mz;
        e5CJE:
        igt8m:
        goto eBCmp;
        EqEJv:
        if (!(($v_result = $this->privReadFileHeader($v_header)) != 1)) {
            goto Mu43S;
        }
        goto HQEBx;
        lA0W0:
        $v_buffer = @fread($this->zip_fd, $p_entry["\x63\x6f\x6d\160\x72\145\x73\163\145\144\137\163\151\x7a\x65"]);
        goto dR1uD;
        cTzZp:
        unset($v_file_content);
        goto mx3d1;
        bi6TV:
        $v_result = $p_options[PCLZIP_CB_PRE_EXTRACT](PCLZIP_CB_PRE_EXTRACT, $v_local_header);
        goto g0QjJ;
        B2h2e:
        if (!($this->privCheckFileHeaders($v_header, $p_entry) != 1)) {
            goto Ktr6F;
        }
        goto Y7IZz;
        KAr5p:
        echo $v_file_content;
        goto cTzZp;
        I5HPI:
        unset($v_buffer);
        goto KAr5p;
        RLCPG:
        if (($p_entry["\145\x78\x74\145\x72\156\x61\x6c"] & 16) == 16) {
            goto xV45P;
        }
        goto w7rRd;
        ANG2F:
        $v_buffer = @fread($this->zip_fd, $p_entry["\x63\157\155\x70\162\145\163\x73\145\144\137\163\x69\x7a\x65"]);
        goto F4JDz;
        Y7IZz:
        Ktr6F:
        goto iOPmf;
        Etqma:
        unset($v_buffer);
        goto Q_1P_;
        UP75m:
        rxFdE:
        goto Zp0ft;
        GDP1W:
        if ($p_entry["\163\x74\x61\x74\165\x73"] == "\141\142\x6f\162\x74\145\144") {
            goto iDFjR;
        }
        goto MIqxE;
        HQEBx:
        return $v_result;
        goto JzfM2;
        yeW41:
        return $v_result;
        goto Gnc_T;
        mIvGX:
        xV45P:
        goto N2fzG;
        w7rRd:
        if ($p_entry["\x63\157\x6d\x70\162\x65\163\163\145\x64\137\x73\151\172\145"] == $p_entry["\163\151\172\x65"]) {
            goto k2ZWv;
        }
        goto lA0W0;
        Yl5R6:
        goto l7JkE;
        goto xXyJv;
        cTeXP:
        $v_result = 1;
        goto JfgTf;
        c_zIe:
        $v_result = PCLZIP_ERR_USER_ABORTED;
        goto UP75m;
        iBLe4:
        $v_local_header = array();
        goto surfw;
        GTzhA:
        goto l7JkE;
        goto e5CJE;
        g0QjJ:
        if (!($v_result == 0)) {
            goto UWC2g;
        }
        goto A0uSw;
        bez4h:
        l7JkE:
        goto yeW41;
        Zp0ft:
        $p_entry["\146\151\x6c\x65\156\141\x6d\145"] = $v_local_header["\146\151\x6c\x65\x6e\x61\x6d\x65"];
        goto uOgvN;
        eBCmp:
        $v_local_header = array();
        goto EJVX6;
        Eaj3M:
        $v_result = 1;
        goto EqEJv;
        JfgTf:
        UWC2g:
        goto oaw50;
        lCANm:
        if (!($v_result == 2)) {
            goto F6ScD;
        }
        goto ozKwR;
        Q_1P_:
        REcot:
        goto mIvGX;
        N2fzG:
        WzaN2:
        goto GDP1W;
        A0uSw:
        $p_entry["\163\164\141\164\x75\x73"] = "\x73\153\x69\x70\x70\145\144";
        goto cTeXP;
        yi1Zc:
        $v_result = $p_options[PCLZIP_CB_POST_EXTRACT](PCLZIP_CB_POST_EXTRACT, $v_local_header);
        goto lCANm;
        ErRI2:
        $p_entry["\163\164\141\x74\x75\x73"] = "\x61\x62\x6f\x72\x74\145\x64";
        goto c_zIe;
        GdrX0:
        $p_entry["\163\x74\141\164\165\163"] = "\163\x6b\151\160\x70\145\144";
        goto GTzhA;
        surfw:
        $this->privConvertHeader2FileInfo($p_entry, $v_local_header);
        goto bi6TV;
        uOgvN:
        gjtZp:
        goto okAdM;
        mx3d1:
        goto REcot;
        goto jZEEb;
        iOPmf:
        if (!isset($p_options[PCLZIP_CB_PRE_EXTRACT])) {
            goto gjtZp;
        }
        goto iBLe4;
        JzfM2:
        Mu43S:
        goto B2h2e;
        oaw50:
        if (!($v_result == 2)) {
            goto rxFdE;
        }
        goto ErRI2;
        EJVX6:
        $this->privConvertHeader2FileInfo($p_entry, $v_local_header);
        goto yi1Zc;
        Tq0Mz:
        F6ScD:
        goto bez4h;
        okAdM:
        if (!($p_entry["\x73\x74\x61\x74\165\x73"] == "\157\x6b")) {
            goto WzaN2;
        }
        goto RLCPG;
        Gnc_T:
    }
    public function privExtractFileAsString(&$p_entry, &$p_string, &$p_options)
    {
        goto Y_RQh;
        dg2Cv:
        DInw8:
        goto K34FK;
        mI1lL:
        if (!($v_result == 0)) {
            goto mZF6P;
        }
        goto C0icO;
        P_dXT:
        goto oQZx6;
        goto ro5wA;
        n0Mi3:
        goto oQZx6;
        goto nWYT9;
        oHbdJ:
        $v_local_header = array();
        goto E0zOE;
        uCxL6:
        KCvm9:
        goto Uu1VR;
        nWYT9:
        qgcLF:
        goto dc8B2;
        fGgH_:
        $v_data = @fread($this->zip_fd, $p_entry["\x63\157\x6d\x70\x72\145\x73\163\x65\x64\137\x73\151\x7a\x65"]);
        goto hhtR7;
        QwmO1:
        $v_header = array();
        goto HZCbD;
        lYB1V:
        if (!($v_result == 2)) {
            goto HiEgH;
        }
        goto NqMQv;
        IDxnb:
        $v_result = 1;
        goto F3GN1;
        fJhO1:
        $v_result = $p_options[PCLZIP_CB_POST_EXTRACT](PCLZIP_CB_POST_EXTRACT, $v_local_header);
        goto cMe9D;
        J37PA:
        return $v_result;
        goto UTZdm;
        mP3HL:
        dpTF5:
        goto cUp7r;
        NqMQv:
        $p_entry["\163\x74\141\164\x75\x73"] = "\x61\142\x6f\162\164\x65\144";
        goto hzJHk;
        JTfoT:
        return $v_result;
        goto bhxlL;
        cZ3Dz:
        if (isset($p_options[PCLZIP_CB_POST_EXTRACT])) {
            goto wOVOG;
        }
        goto n0Mi3;
        tdgvd:
        if (!(($p_entry["\x65\x78\164\x65\x72\156\141\x6c"] & 16) == 16)) {
            goto KCvm9;
        }
        goto whn9D;
        X1Xtr:
        if (!($this->privCheckFileHeaders($v_header, $p_entry) != 1)) {
            goto LItdK;
        }
        goto vNkk8;
        uxO8m:
        $p_entry["\146\x69\154\x65\156\x61\155\145"] = $v_local_header["\146\x69\154\145\156\141\155\145"];
        goto mP3HL;
        K34FK:
        oQZx6:
        goto J37PA;
        cUp7r:
        if (!($p_entry["\x73\164\141\x74\165\x73"] == "\x6f\x6b")) {
            goto jagRL;
        }
        goto tdgvd;
        OeEDA:
        MfZE0:
        goto u0Qap;
        F3GN1:
        mZF6P:
        goto lYB1V;
        whn9D:
        goto NpyZC;
        goto uCxL6;
        E0zOE:
        $this->privConvertHeader2FileInfo($p_entry, $v_local_header);
        goto b31pl;
        uhibb:
        $p_string = '';
        goto fJhO1;
        yVm1s:
        HiEgH:
        goto uxO8m;
        u0Qap:
        $p_string = @fread($this->zip_fd, $p_entry["\143\x6f\155\x70\162\145\x73\x73\x65\x64\x5f\163\151\172\145"]);
        goto g0uKu;
        C0icO:
        $p_entry["\x73\164\141\164\165\163"] = "\x73\153\151\x70\x70\145\x64";
        goto IDxnb;
        Y_RQh:
        $v_result = 1;
        goto QwmO1;
        vNkk8:
        LItdK:
        goto rLX8t;
        dc8B2:
        $p_entry["\163\164\x61\x74\165\x73"] = "\x73\153\151\160\160\x65\x64";
        goto P_dXT;
        AZ3H0:
        rVm1x:
        goto c2ttK;
        xWdHF:
        if ($p_entry["\163\164\141\164\x75\x73"] == "\141\142\157\162\164\x65\x64") {
            goto qgcLF;
        }
        goto cZ3Dz;
        c2ttK:
        goto uy2z3;
        goto OeEDA;
        b31pl:
        $v_result = $p_options[PCLZIP_CB_PRE_EXTRACT](PCLZIP_CB_PRE_EXTRACT, $v_local_header);
        goto mI1lL;
        bhxlL:
        yKcUx:
        goto X1Xtr;
        rLX8t:
        if (!isset($p_options[PCLZIP_CB_PRE_EXTRACT])) {
            goto dpTF5;
        }
        goto oHbdJ;
        s3kSf:
        $v_local_header["\143\157\x6e\164\145\156\x74"] = $p_string;
        goto uhibb;
        vA0CZ:
        $v_result = PCLZIP_ERR_USER_ABORTED;
        goto dg2Cv;
        ro5wA:
        wOVOG:
        goto Mj8_O;
        ZNKav:
        unset($v_local_header["\x63\157\x6e\164\x65\156\x74"]);
        goto hxyAt;
        QcNyw:
        NpyZC:
        goto dvt9F;
        Uu1VR:
        if ($p_entry["\143\x6f\x6d\160\162\145\x73\163\x69\x6f\x6e"] == 0) {
            goto MfZE0;
        }
        goto fGgH_;
        cMe9D:
        $p_string = $v_local_header["\x63\x6f\x6e\164\x65\156\x74"];
        goto ZNKav;
        Mj8_O:
        $v_local_header = array();
        goto W60ET;
        g0uKu:
        uy2z3:
        goto QcNyw;
        W60ET:
        $this->privConvertHeader2FileInfo($p_entry, $v_local_header);
        goto s3kSf;
        hzJHk:
        $v_result = PCLZIP_ERR_USER_ABORTED;
        goto yVm1s;
        hxyAt:
        if (!($v_result == 2)) {
            goto DInw8;
        }
        goto vA0CZ;
        hhtR7:
        if (!(($p_string = @gzinflate($v_data)) === false)) {
            goto rVm1x;
        }
        goto AZ3H0;
        HZCbD:
        if (!(($v_result = $this->privReadFileHeader($v_header)) != 1)) {
            goto yKcUx;
        }
        goto JTfoT;
        dvt9F:
        jagRL:
        goto xWdHF;
        UTZdm:
    }
    public function privReadFileHeader(&$p_header)
    {
        goto kxzLQ;
        z5icq:
        $p_header["\x6d\x74\151\x6d\x65"] = @mktime($v_hour, $v_minute, $v_seconde, $v_month, $v_day, $v_year);
        goto v0lPA;
        Ux4v8:
        $v_binary_data = @fread($this->zip_fd, 4);
        goto Jjo8e;
        g4xiH:
        $p_header["\155\x74\151\x6d\145"] = time();
        goto us7uB;
        v0lPA:
        zgD63:
        goto URnlV;
        hHdnD:
        $v_hour = ($p_header["\x6d\164\x69\155\x65"] & 63488) >> 11;
        goto LeA3M;
        a7F7C:
        $p_header["\145\170\x74\162\141"] = fread($this->zip_fd, $v_data["\145\x78\164\x72\141\137\154\145\156"]);
        goto qGY7d;
        KR3AO:
        oKZyh:
        goto hHdnD;
        diSaq:
        $p_header["\x66\x69\x6c\x65\156\x61\x6d\x65\x5f\x6c\145\156"] = $v_data["\146\x69\154\145\156\141\x6d\x65\137\x6c\145\156"];
        goto HqZ17;
        d5ggs:
        return $v_result;
        goto qXzOf;
        sXK_K:
        if (!($v_data["\x69\x64"] != 67324752)) {
            goto ZT4zR;
        }
        goto MHlXY;
        MHlXY:
        PclZip::privErrorLog(PCLZIP_ERR_BAD_FORMAT, "\x49\156\x76\x61\x6c\x69\144\x20\x61\x72\x63\x68\151\x76\x65\40\x73\x74\x72\x75\143\164\x75\162\145");
        goto tM08M;
        nroWv:
        $v_binary_data = fread($this->zip_fd, 26);
        goto aaDqr;
        us7uB:
        goto zgD63;
        goto KR3AO;
        Jjo8e:
        $v_data = unpack("\126\x69\x64", $v_binary_data);
        goto sXK_K;
        Kr2a_:
        $p_header["\x73\164\141\164\165\163"] = "\151\x6e\x76\x61\x6c\x69\x64\137\x68\145\x61\x64\x65\x72";
        goto iUE1G;
        D45i9:
        if ($p_header["\x6d\144\141\x74\x65"] && $p_header["\x6d\164\x69\x6d\x65"]) {
            goto oKZyh;
        }
        goto g4xiH;
        cbMc6:
        if ($v_data["\145\x78\x74\x72\x61\x5f\154\145\x6e"] != 0) {
            goto NgfhT;
        }
        goto hmcMQ;
        CjP3G:
        s10b7:
        goto ZCLAb;
        E4MwY:
        $p_header["\x6d\x74\x69\x6d\145"] = $v_data["\155\x74\x69\155\145"];
        goto D45i9;
        z4Fo1:
        goto wa5bt;
        goto Gudw_;
        bIoSh:
        $p_header["\x76\x65\162\x73\x69\157\156\x5f\x65\170\x74\162\x61\143\164\x65\144"] = $v_data["\x76\145\x72\163\151\x6f\156"];
        goto Ut2_f;
        Tggsc:
        $p_header["\163\164\x61\x74\x75\163"] = "\x6f\x6b";
        goto d5ggs;
        d817a:
        $p_header["\x63\x72\143"] = $v_data["\143\162\x63"];
        goto FojjI;
        KaEyT:
        $v_month = ($p_header["\x6d\x64\x61\x74\x65"] & 480) >> 5;
        goto pFBdp;
        PGhqN:
        $v_year = (($p_header["\155\x64\141\x74\x65"] & 65024) >> 9) + 1980;
        goto KaEyT;
        uYG01:
        $p_header["\x66\151\x6c\x65\156\141\x6d\145"] = fread($this->zip_fd, $v_data["\x66\151\154\x65\x6e\x61\x6d\145\x5f\x6c\x65\x6e"]);
        goto cbMc6;
        Ut2_f:
        $p_header["\x63\x6f\x6d\x70\x72\x65\163\163\151\x6f\x6e"] = $v_data["\143\157\155\x70\x72\x65\163\x73\x69\x6f\156"];
        goto EbhmT;
        arRh9:
        $p_header["\143\x6f\155\x70\162\x65\x73\x73\x65\x64\x5f\x73\x69\172\x65"] = $v_data["\x63\157\x6d\160\162\x65\163\163\x65\x64\137\x73\151\172\145"];
        goto d817a;
        EbhmT:
        $p_header["\x73\x69\172\145"] = $v_data["\163\x69\172\145"];
        goto arRh9;
        Bvvf9:
        ZT4zR:
        goto nroWv;
        NOwuO:
        $v_seconde = ($p_header["\155\164\151\x6d\x65"] & 31) * 2;
        goto PGhqN;
        tM08M:
        return PclZip::errorCode();
        goto Bvvf9;
        kxzLQ:
        $v_result = 1;
        goto Ux4v8;
        qGY7d:
        wa5bt:
        goto bIoSh;
        FojjI:
        $p_header["\x66\x6c\141\147"] = $v_data["\x66\x6c\141\147"];
        goto diSaq;
        Gudw_:
        NgfhT:
        goto a7F7C;
        hmcMQ:
        $p_header["\145\x78\x74\162\x61"] = '';
        goto z4Fo1;
        ZCLAb:
        $v_data = unpack("\x76\166\x65\x72\x73\151\157\x6e\x2f\166\x66\154\141\147\57\166\143\157\155\160\162\145\x73\163\x69\x6f\156\x2f\x76\155\x74\x69\x6d\x65\x2f\166\155\144\x61\164\x65\x2f\x56\x63\x72\x63\x2f\x56\x63\157\x6d\160\x72\x65\163\163\x65\x64\137\163\151\x7a\x65\x2f\x56\163\151\x7a\x65\57\166\x66\151\x6c\x65\x6e\x61\x6d\145\x5f\x6c\x65\x6e\x2f\166\x65\170\x74\x72\x61\x5f\154\x65\x6e", $v_binary_data);
        goto uYG01;
        LeA3M:
        $v_minute = ($p_header["\x6d\x74\x69\155\145"] & 2016) >> 5;
        goto NOwuO;
        iUE1G:
        PclZip::privErrorLog(PCLZIP_ERR_BAD_FORMAT, "\x49\x6e\166\141\154\x69\144\x20\x62\x6c\x6f\x63\x6b\x20\163\x69\172\x65\x20\72\40" . strlen($v_binary_data));
        goto hcdMO;
        HqZ17:
        $p_header["\155\144\141\x74\145"] = $v_data["\x6d\144\x61\x74\145"];
        goto E4MwY;
        OvGz4:
        $p_header["\x66\151\154\145\x6e\x61\155\x65"] = '';
        goto Kr2a_;
        pFBdp:
        $v_day = $p_header["\155\144\141\x74\x65"] & 31;
        goto z5icq;
        hcdMO:
        return PclZip::errorCode();
        goto CjP3G;
        aaDqr:
        if (!(strlen($v_binary_data) != 26)) {
            goto s10b7;
        }
        goto OvGz4;
        URnlV:
        $p_header["\x73\x74\157\x72\x65\144\x5f\x66\151\154\x65\156\x61\x6d\x65"] = $p_header["\x66\151\154\145\156\x61\155\145"];
        goto Tggsc;
        qXzOf:
    }
    public function privReadCentralFileHeader(&$p_header)
    {
        goto Vx61i;
        f0Myn:
        $p_header["\x6d\x74\x69\x6d\x65"] = time();
        goto a6fHE;
        aaRe0:
        $v_month = ($p_header["\155\144\x61\164\145"] & 480) >> 5;
        goto j826x;
        sTTAU:
        $v_hour = ($p_header["\155\164\x69\x6d\145"] & 63488) >> 11;
        goto PnNq1;
        ctt_a:
        PclZip::privErrorLog(PCLZIP_ERR_BAD_FORMAT, "\x49\x6e\166\141\x6c\151\144\x20\141\x72\x63\x68\151\x76\x65\x20\163\164\162\x75\143\x74\165\x72\145");
        goto Clblm;
        YxjSj:
        $p_header = unpack("\166\x76\x65\162\x73\151\x6f\156\x2f\166\x76\x65\162\x73\x69\x6f\x6e\x5f\145\170\164\x72\141\143\x74\x65\144\x2f\x76\x66\154\x61\147\57\x76\x63\157\x6d\160\162\x65\163\x73\151\157\x6e\57\x76\155\164\151\155\145\x2f\x76\155\x64\x61\x74\145\x2f\126\143\162\143\57\x56\x63\x6f\x6d\160\x72\145\x73\x73\x65\x64\x5f\x73\x69\x7a\x65\57\x56\163\151\172\145\57\x76\146\151\x6c\145\156\141\155\x65\x5f\154\145\156\x2f\x76\x65\170\164\162\141\137\154\x65\156\x2f\166\143\157\155\x6d\145\x6e\x74\137\154\145\x6e\57\x76\x64\151\163\x6b\57\x76\151\x6e\x74\145\162\156\141\x6c\57\126\x65\x78\164\145\x72\156\141\x6c\57\x56\x6f\x66\146\x73\145\164", $v_binary_data);
        goto f1rLa;
        QUfBZ:
        if (!(strlen($v_binary_data) != 42)) {
            goto YzaBv;
        }
        goto SRJdY;
        Clblm:
        return PclZip::errorCode();
        goto CEMK5;
        CgbRt:
        goto DLC_J;
        goto S2NDd;
        cBurG:
        lFuBQ:
        goto sTTAU;
        wOdsF:
        goto Ev2Ye;
        goto dIsaI;
        YMzLq:
        return $v_result;
        goto GcDpE;
        j826x:
        $v_day = $p_header["\155\x64\141\x74\x65"] & 31;
        goto kUMmS;
        ED6uo:
        $p_header["\x73\x74\x61\x74\165\x73"] = "\x6f\153";
        goto J8B1r;
        fJ2e0:
        $p_header["\x63\x6f\x6d\155\145\x6e\x74"] = '';
        goto CgbRt;
        byolz:
        $v_binary_data = @fread($this->zip_fd, 4);
        goto zk_Sf;
        J8B1r:
        if (!(substr($p_header["\x66\x69\x6c\145\156\x61\155\x65"], -1) == "\x2f")) {
            goto CgtjJ;
        }
        goto D9Wmx;
        QGJVF:
        $p_header["\x66\x69\x6c\145\x6e\x61\x6d\145"] = '';
        goto wOdsF;
        LPcnL:
        PclZip::privErrorLog(PCLZIP_ERR_BAD_FORMAT, "\x49\156\x76\x61\x6c\151\x64\40\142\154\157\x63\153\x20\163\151\172\x65\x20\x3a\40" . strlen($v_binary_data));
        goto CfJWg;
        uNxmd:
        goto Ehgpq;
        goto OfC1H;
        PnNq1:
        $v_minute = ($p_header["\155\164\151\155\x65"] & 2016) >> 5;
        goto YQt6J;
        BfQhT:
        CgtjJ:
        goto YMzLq;
        uLAw9:
        $p_header["\x73\164\x6f\162\x65\x64\x5f\x66\x69\x6c\x65\156\141\155\145"] = $p_header["\146\151\x6c\x65\156\141\155\x65"];
        goto ED6uo;
        CfJWg:
        return PclZip::errorCode();
        goto snNcE;
        QLM02:
        $p_header["\143\x6f\x6d\x6d\145\x6e\164"] = fread($this->zip_fd, $p_header["\143\x6f\x6d\155\145\x6e\x74\x5f\154\x65\x6e"]);
        goto okTRp;
        SRJdY:
        $p_header["\x66\x69\154\145\x6e\x61\155\145"] = '';
        goto mDFjw;
        bb8k3:
        $v_year = (($p_header["\155\144\141\x74\145"] & 65024) >> 9) + 1980;
        goto aaRe0;
        okTRp:
        DLC_J:
        goto Th4KY;
        EB9EX:
        $p_header["\145\x78\164\162\x61"] = '';
        goto uNxmd;
        vSvaf:
        $v_binary_data = fread($this->zip_fd, 42);
        goto QUfBZ;
        CEMK5:
        VV4rF:
        goto vSvaf;
        kUMmS:
        $p_header["\x6d\x74\151\x6d\145"] = @mktime($v_hour, $v_minute, $v_seconde, $v_month, $v_day, $v_year);
        goto PoW1r;
        PoW1r:
        HhjPZ:
        goto uLAw9;
        Scthb:
        if ($p_header["\143\157\155\x6d\145\x6e\x74\137\154\145\x6e"] != 0) {
            goto dGeA8;
        }
        goto fJ2e0;
        f1rLa:
        if ($p_header["\146\151\154\145\x6e\x61\x6d\145\137\154\x65\x6e"] != 0) {
            goto q9HRh;
        }
        goto QGJVF;
        a6fHE:
        goto HhjPZ;
        goto cBurG;
        YQt6J:
        $v_seconde = ($p_header["\x6d\x74\151\155\145"] & 31) * 2;
        goto bb8k3;
        D9Wmx:
        $p_header["\145\x78\x74\x65\x72\x6e\141\x6c"] = 16;
        goto BfQhT;
        snNcE:
        YzaBv:
        goto YxjSj;
        bKI8k:
        $p_header["\x66\151\x6c\145\x6e\x61\155\x65"] = fread($this->zip_fd, $p_header["\146\151\154\x65\156\x61\155\x65\137\154\x65\x6e"]);
        goto SbZFI;
        dIsaI:
        q9HRh:
        goto bKI8k;
        yWZ3M:
        if (!($v_data["\x69\144"] != 33639248)) {
            goto VV4rF;
        }
        goto ctt_a;
        Th4KY:
        if (1) {
            goto lFuBQ;
        }
        goto f0Myn;
        S2NDd:
        dGeA8:
        goto QLM02;
        mDFjw:
        $p_header["\x73\x74\141\164\165\x73"] = "\x69\156\166\x61\x6c\151\x64\137\x68\x65\141\144\x65\x72";
        goto LPcnL;
        OfC1H:
        e2wwT:
        goto HBmEM;
        SAmN0:
        if ($p_header["\145\170\164\162\141\x5f\154\145\x6e"] != 0) {
            goto e2wwT;
        }
        goto EB9EX;
        HBmEM:
        $p_header["\145\170\164\162\141"] = fread($this->zip_fd, $p_header["\x65\170\x74\162\141\137\154\145\x6e"]);
        goto ZBxTS;
        Vx61i:
        $v_result = 1;
        goto byolz;
        zk_Sf:
        $v_data = unpack("\x56\x69\144", $v_binary_data);
        goto yWZ3M;
        ZBxTS:
        Ehgpq:
        goto Scthb;
        SbZFI:
        Ev2Ye:
        goto SAmN0;
        GcDpE:
    }
    public function privCheckFileHeaders(&$p_local_header, &$p_central_header)
    {
        goto UNT8R;
        YA1qb:
        $p_local_header["\x63\157\x6d\160\162\145\163\x73\x65\144\x5f\163\x69\x7a\145"] = $p_central_header["\x63\157\155\160\x72\145\x73\x73\145\x64\x5f\163\x69\172\x65"];
        goto ncb6n;
        QaNpc:
        $p_local_header["\x73\151\172\x65"] = $p_central_header["\163\151\172\x65"];
        goto YA1qb;
        nf0_l:
        EL1dN:
        goto PUBgT;
        UNT8R:
        $v_result = 1;
        goto at432;
        UGAJR:
        jBMPE:
        goto dkuZn;
        jzW2V:
        GH2C0:
        goto qN5cA;
        at432:
        if (!($p_local_header["\x66\x69\x6c\145\156\141\x6d\x65"] != $p_central_header["\x66\x69\154\x65\156\141\x6d\145"])) {
            goto clYHP;
        }
        goto tZCbI;
        iafXE:
        aQhmE:
        goto bkQ3K;
        tZCbI:
        clYHP:
        goto dr9o8;
        n1I1p:
        tlubD:
        goto V3Ttl;
        V3Ttl:
        if (!($p_local_header["\x63\157\155\x70\x72\x65\163\x73\x69\157\x6e"] != $p_central_header["\143\x6f\x6d\160\162\145\163\x73\151\x6f\156"])) {
            goto EL1dN;
        }
        goto nf0_l;
        ncb6n:
        $p_local_header["\143\162\143"] = $p_central_header["\143\162\143"];
        goto jzW2V;
        dr9o8:
        if (!($p_local_header["\166\x65\162\163\151\x6f\156\137\x65\x78\164\x72\141\x63\164\x65\144"] != $p_central_header["\x76\x65\162\x73\x69\x6f\x6e\137\x65\x78\x74\x72\x61\x63\164\x65\144"])) {
            goto Hmukg;
        }
        goto irPlk;
        PUBgT:
        if (!($p_local_header["\x6d\164\151\155\145"] != $p_central_header["\155\x74\151\x6d\x65"])) {
            goto jBMPE;
        }
        goto UGAJR;
        bkQ3K:
        if (!(($p_local_header["\146\x6c\141\147"] & 8) == 8)) {
            goto GH2C0;
        }
        goto QaNpc;
        qN5cA:
        return $v_result;
        goto LC9dv;
        Kdejo:
        if (!($p_local_header["\x66\x6c\141\147"] != $p_central_header["\x66\154\141\147"])) {
            goto tlubD;
        }
        goto n1I1p;
        dkuZn:
        if (!($p_local_header["\x66\x69\154\x65\156\x61\155\145\137\x6c\x65\x6e"] != $p_central_header["\x66\x69\x6c\x65\156\141\x6d\145\x5f\x6c\145\x6e"])) {
            goto aQhmE;
        }
        goto iafXE;
        irPlk:
        Hmukg:
        goto Kdejo;
        LC9dv:
    }
    public function privReadEndCentralDir(&$p_central_dir)
    {
        goto em0uH;
        CK7Ex:
        @fseek($this->zip_fd, $v_size - $v_maximum_size);
        goto ZBaeu;
        N_QsF:
        $v_binary_data = fread($this->zip_fd, 18);
        goto idIc_;
        uqqgW:
        $v_binary_data = @fread($this->zip_fd, 4);
        goto RFPl5;
        p4bwf:
        SM8Uf:
        goto aNWkS;
        w85NU:
        cJpYI:
        goto uqqgW;
        q0oDl:
        return PclZip::errorCode();
        goto RJnQ3;
        QC7al:
        $v_data = unpack("\x76\144\151\x73\x6b\57\166\144\x69\163\x6b\137\x73\x74\x61\162\x74\57\x76\x64\x69\163\153\137\145\156\164\x72\151\145\163\57\x76\145\156\164\162\x69\145\x73\x2f\x56\163\x69\172\145\57\x56\x6f\x66\x66\x73\x65\164\x2f\166\x63\157\155\x6d\145\x6e\x74\x5f\163\x69\x7a\145", $v_binary_data);
        goto DoBu5;
        SoWiR:
        @fseek($this->zip_fd, $v_size - 22);
        goto AE7BM;
        DoBu5:
        if (!($v_pos + $v_data["\143\x6f\155\155\145\x6e\164\137\x73\x69\172\x65"] + 18 != $v_size)) {
            goto Ivf0C;
        }
        goto ZdWUf;
        ZBaeu:
        if (!(@ftell($this->zip_fd) != $v_size - $v_maximum_size)) {
            goto deDiA;
        }
        goto jxq3T;
        N9RV8:
        $v_maximum_size = $v_size;
        goto eEh62;
        FjmoN:
        $v_pos = ftell($this->zip_fd);
        goto G9lC1;
        BxRh3:
        $p_central_dir["\x63\157\x6d\155\x65\156\x74"] = fread($this->zip_fd, $v_data["\143\157\155\155\145\x6e\x74\137\163\x69\172\145"]);
        goto FeD8s;
        ocaIn:
        if (!($v_size > 26)) {
            goto zVqqx;
        }
        goto SoWiR;
        Q7ZFO:
        nexH6:
        goto QC7al;
        jAehX:
        mD0fn:
        goto HLn7v;
        Rv0Kv:
        Po2qq:
        goto lZUpf;
        h1BLB:
        return PclZip::errorCode();
        goto w85NU;
        oVzyY:
        sngfl:
        goto gJSft;
        RJnQ3:
        deDiA:
        goto FjmoN;
        Rb9bu:
        $v_maximum_size = 65557;
        goto gVfj3;
        G9lC1:
        $v_bytes = 0;
        goto jvNaH;
        wCMI_:
        $v_pos++;
        goto bcLJu;
        HLn7v:
        jPQeI:
        goto N_QsF;
        FeD8s:
        PPfbF:
        goto R6bb1;
        gJSft:
        $v_pos = ftell($this->zip_fd);
        goto AHqFX;
        ur9JY:
        $v_found = 1;
        goto oVzyY;
        QxB7n:
        return PclZip::errorCode();
        goto cebiG;
        FlK4O:
        PclZip::privErrorLog(PCLZIP_ERR_BAD_FORMAT, "\x55\x6e\x61\142\154\x65\40\164\157\x20\x66\x69\156\144\x20\105\x6e\x64\40\x6f\146\x20\x43\145\156\x74\x72\141\x6c\x20\x44\151\x72\x20\x52\145\143\157\162\144\x20\163\151\147\x6e\141\164\x75\x72\x65");
        goto ncuqv;
        bcLJu:
        goto F5h0L;
        goto Rv0Kv;
        KOoAL:
        $p_central_dir["\x73\x69\x7a\x65"] = $v_data["\163\151\172\145"];
        goto hfzbz;
        vo0se:
        if (!($v_pos < $v_size)) {
            goto F5h0L;
        }
        goto dKlFF;
        ncuqv:
        return PclZip::errorCode();
        goto jAehX;
        f4UKd:
        return $v_result;
        goto ANrie;
        pynCj:
        goto xJRCw;
        goto NLi1B;
        h31g7:
        PclZip::privErrorLog(PCLZIP_ERR_BAD_FORMAT, "\124\150\145\x20\x63\145\156\164\x72\141\154\40\x64\151\162\x20\151\163\40\x6e\x6f\x74\x20\141\x74\x20\x74\150\145\x20\x65\x6e\144\x20\x6f\146\x20\x74\150\145\40\141\x72\143\x68\x69\166\x65\x2e" . "\x20\123\157\155\145\40\164\x72\141\x69\x6c\151\x6e\147\x20\x62\171\x74\145\x73\x20\x65\170\151\x73\164\163\40\141\x66\x74\x65\162\x20\164\x68\145\x20\x61\162\143\x68\x69\166\145\56");
        goto QxB7n;
        AHqFX:
        zVqqx:
        goto Px8UO;
        yl9e0:
        $p_central_dir["\143\157\155\x6d\x65\x6e\x74"] = '';
        goto DGvaz;
        em0uH:
        $v_result = 1;
        goto wQowc;
        A0h3D:
        return PclZip::errorCode();
        goto p4bwf;
        XFwez:
        $v_bytes = ($v_bytes & 16777215) << 8 | Ord($v_byte);
        goto XAYje;
        Iu26e:
        if (!($v_data["\151\x64"] == 101010256)) {
            goto sngfl;
        }
        goto ur9JY;
        GdQET:
        if (!(@ftell($this->zip_fd) != $v_size)) {
            goto SM8Uf;
        }
        goto oRVOH;
        sxxZH:
        $p_central_dir["\157\x66\x66\163\x65\x74"] = $v_data["\157\146\146\163\145\164"];
        goto KOoAL;
        P84Yk:
        if ($v_data["\x63\157\x6d\155\145\156\164\x5f\x73\x69\172\x65"] != 0) {
            goto PeC5H;
        }
        goto yl9e0;
        Px8UO:
        if ($v_found) {
            goto jPQeI;
        }
        goto Rb9bu;
        idIc_:
        if (!(strlen($v_binary_data) != 18)) {
            goto nexH6;
        }
        goto MDRc5;
        cebiG:
        QkxEN:
        goto f1Jk0;
        DGvaz:
        goto PPfbF;
        goto qYQXk;
        gVfj3:
        if (!($v_maximum_size > $v_size)) {
            goto LbL92;
        }
        goto N9RV8;
        AE7BM:
        if (!(($v_pos = @ftell($this->zip_fd)) != $v_size - 22)) {
            goto cJpYI;
        }
        goto cWnCF;
        qYQXk:
        PeC5H:
        goto BxRh3;
        NLi1B:
        F5h0L:
        goto tsc_7;
        RFPl5:
        $v_data = @unpack("\126\x69\x64", $v_binary_data);
        goto Iu26e;
        aNWkS:
        $v_found = 0;
        goto ocaIn;
        eiphO:
        $p_central_dir["\144\151\163\153\x5f\x73\164\141\162\164"] = $v_data["\144\x69\163\x6b\x5f\x73\x74\141\x72\164"];
        goto f4UKd;
        ZdWUf:
        if (!0) {
            goto QkxEN;
        }
        goto h31g7;
        R6bb1:
        $p_central_dir["\145\156\164\x72\x69\x65\x73"] = $v_data["\x65\156\x74\x72\x69\x65\163"];
        goto I27wZ;
        dKlFF:
        $v_byte = @fread($this->zip_fd, 1);
        goto XFwez;
        XAYje:
        if (!($v_bytes == 1347093766)) {
            goto Po2qq;
        }
        goto wCMI_;
        MDRc5:
        PclZip::privErrorLog(PCLZIP_ERR_BAD_FORMAT, "\x49\x6e\166\141\x6c\151\144\40\x45\156\x64\40\157\x66\40\103\145\156\164\162\141\x6c\x20\x44\151\x72\40\122\145\143\157\162\144\40\x73\x69\172\145\40\x3a\x20" . strlen($v_binary_data));
        goto HRstv;
        eEh62:
        LbL92:
        goto CK7Ex;
        xaCm2:
        @fseek($this->zip_fd, $v_size);
        goto GdQET;
        jvNaH:
        xJRCw:
        goto vo0se;
        hfzbz:
        $p_central_dir["\x64\x69\x73\x6b"] = $v_data["\144\x69\163\153"];
        goto eiphO;
        wQowc:
        $v_size = filesize($this->zipname);
        goto xaCm2;
        HRstv:
        return PclZip::errorCode();
        goto Q7ZFO;
        jxq3T:
        PclZip::privErrorLog(PCLZIP_ERR_BAD_FORMAT, "\125\x6e\141\x62\154\145\40\164\x6f\40\163\x65\x65\x6b\40\x62\x61\143\153\x20\x74\x6f\x20\x74\x68\145\x20\x6d\x69\144\144\x6c\145\x20\157\x66\40\164\150\145\x20\141\162\x63\x68\x69\166\x65\40\x27" . $this->zipname . "\x27");
        goto q0oDl;
        cWnCF:
        PclZip::privErrorLog(PCLZIP_ERR_BAD_FORMAT, "\125\156\x61\x62\x6c\x65\x20\x74\x6f\40\163\x65\145\153\x20\142\x61\x63\x6b\40\164\157\x20\164\150\x65\x20\x6d\151\x64\x64\x6c\145\40\157\x66\40\164\150\x65\x20\141\162\x63\x68\151\166\x65\40\x27" . $this->zipname . "\x27");
        goto h1BLB;
        lZUpf:
        $v_pos++;
        goto pynCj;
        oRVOH:
        PclZip::privErrorLog(PCLZIP_ERR_BAD_FORMAT, "\x55\x6e\141\x62\154\x65\40\x74\157\40\x67\x6f\40\x74\x6f\x20\164\x68\145\40\x65\156\x64\x20\x6f\x66\40\x74\150\145\40\x61\162\x63\x68\151\166\145\40\x27" . $this->zipname . "\x27");
        goto A0h3D;
        I27wZ:
        $p_central_dir["\144\151\x73\x6b\x5f\x65\156\x74\162\x69\145\x73"] = $v_data["\144\151\163\153\x5f\145\156\x74\x72\151\x65\163"];
        goto sxxZH;
        f1Jk0:
        Ivf0C:
        goto P84Yk;
        tsc_7:
        if (!($v_pos == $v_size)) {
            goto mD0fn;
        }
        goto FlK4O;
        ANrie:
    }
    public function privDeleteByRule(&$p_result_list, &$p_options)
    {
        goto G9wMz;
        UUl3h:
        unset($v_local_header);
        goto APXw_;
        ZZ4WM:
        return $v_result;
        goto m7els;
        F0lqY:
        jX_ns:
        goto C7dlO;
        N5tvf:
        PclZipUtilRename($v_zip_temp_name, $this->zipname);
        goto ofZHE;
        HjWNy:
        SRN2y:
        goto XbapO;
        DHoNH:
        $j = $j_start;
        goto Jwrt5;
        OGjkH:
        @unlink($v_zip_temp_name);
        goto CANKz;
        zR25L:
        if (!($j < sizeof($p_options[PCLZIP_OPT_BY_NAME]) && !$v_found)) {
            goto CuZjy;
        }
        goto NgjPj;
        fPMrv:
        goto P73qs;
        goto A6gSo;
        QvjzZ:
        return $v_result;
        goto IYwap;
        m1unJ:
        pODL2:
        goto UqoNx;
        mifE6:
        $this->privCloseFd();
        goto OGjkH;
        QoWQs:
        $i++;
        goto MYRzN;
        TZuPc:
        $v_size = @ftell($v_temp_zip->zip_fd) - $v_offset;
        goto yAX3a;
        oBEsf:
        if (!@fseek($this->zip_fd, $v_header_list[$i]["\157\x66\x66\163\145\164"])) {
            goto SV7ja;
        }
        goto YNbvN;
        m7F5Q:
        @rewind($this->zip_fd);
        goto I6xMO;
        OPoTT:
        $i = 0;
        goto Fi_9a;
        P5FDS:
        if (!(($v_result = $this->privReadEndCentralDir($v_central_dir)) != 1)) {
            goto eFxAO;
        }
        goto winW8;
        t55Uy:
        ofuYo:
        goto rym_H;
        wPeec:
        if (isset($p_options[PCLZIP_OPT_BY_PREG]) && $p_options[PCLZIP_OPT_BY_PREG] != '') {
            goto AjHYZ;
        }
        goto tAehD;
        x2Yi3:
        $this->privCloseFd();
        goto h3aoV;
        SYwcP:
        XpYrJ:
        goto YvHXy;
        Og8KB:
        TE63y:
        goto c9hfs;
        uexA_:
        @unlink($v_zip_temp_name);
        goto ZZ4WM;
        L7IMe:
        if (!($i >= $p_options[PCLZIP_OPT_BY_INDEX][$j]["\x65\x6e\x64"])) {
            goto vmhgo;
        }
        goto vpiQy;
        taoh1:
        $v_found = true;
        goto PSLQV;
        jIwW1:
        goto pzAof;
        goto GLHLd;
        A2ieP:
        unset($v_header_list[$v_nb_extracted]);
        goto IeUuz;
        u4NKS:
        A4FVn:
        goto Ahr4i;
        wstUu:
        mjxMt:
        goto EmaSe;
        irGjX:
        if (!($i < $v_central_dir["\x65\x6e\164\x72\x69\x65\163"])) {
            goto FPXe0;
        }
        goto ctKtM;
        c9hfs:
        $j++;
        goto k7JOl;
        EN0s4:
        z7BdA:
        goto N3gcJ;
        eXyvS:
        $this->privCloseFd();
        goto Pl0Zx;
        winW8:
        $this->privCloseFd();
        goto I4Z2R;
        vx0UK:
        if (($v_header_list[$v_nb_extracted]["\145\x78\x74\x65\162\x6e\141\x6c"] & 16) == 16 && $v_header_list[$v_nb_extracted]["\163\x74\x6f\x72\145\x64\x5f\x66\x69\154\145\156\141\155\x65"] . "\x2f" == $p_options[PCLZIP_OPT_BY_NAME][$j]) {
            goto XpYrJ;
        }
        goto XJ5SI;
        io3pp:
        pXUa1:
        goto EN0s4;
        UBXX1:
        $v_temp_zip->privCloseFd();
        goto V9USk;
        DXgZi:
        $v_list_detail = array();
        goto RyKdy;
        uTrEt:
        $v_central_dir = array();
        goto P5FDS;
        ChEm1:
        $this->privCloseFd();
        goto zgsXq;
        A6JdI:
        return PclZip::errorCode();
        goto m1unJ;
        k0luu:
        $this->privCloseFd();
        goto qyGlg;
        Pl0Zx:
        PclZip::privErrorLog(PCLZIP_ERR_INVALID_ARCHIVE_ZIP, "\x49\x6e\x76\141\154\x69\144\40\141\162\143\150\151\x76\145\x20\163\151\x7a\145");
        goto A6JdI;
        YnqHX:
        goto pzAof;
        goto u4NKS;
        nxMet:
        $v_found = true;
        goto F3AVW;
        lKJqH:
        CuZjy:
        goto cCuqU;
        fMwoV:
        h5wfn:
        goto UUl3h;
        EN5zV:
        xHjFV:
        goto S66ft;
        hF_su:
        PdWb_:
        goto taoh1;
        Nr2Iu:
        $v_temp_zip->privCloseFd();
        goto k0luu;
        NdJJW:
        $v_local_header = array();
        goto Q72iT;
        Ebidl:
        @rewind($this->zip_fd);
        goto FU1AW;
        b4Pas:
        $this->privCloseFd();
        goto oGZz_;
        hL2wL:
        GhNaC:
        goto hLKMs;
        UqoNx:
        $v_header_list = array();
        goto oOYyc;
        J4G5x:
        if (!(($v_result = $this->privReadCentralFileHeader($v_header_list[$v_nb_extracted])) != 1)) {
            goto knvYV;
        }
        goto x2Yi3;
        F3AVW:
        goto BoF5J;
        goto HXUcH;
        Fi_9a:
        $v_nb_extracted = 0;
        goto TYwzx;
        KHLg1:
        knvYV:
        goto G71F2;
        I4Z2R:
        return $v_result;
        goto fTr1E;
        APXw_:
        if (!(($v_result = $v_temp_zip->privWriteFileHeader($v_header_list[$i])) != 1)) {
            goto ayNKx;
        }
        goto NPKbG;
        h3aoV:
        return $v_result;
        goto KHLg1;
        sM3fr:
        if (!($j < sizeof($p_options[PCLZIP_OPT_BY_INDEX]) && !$v_found)) {
            goto iGrUx;
        }
        goto ZiMfi;
        IneBo:
        goto NlmfD;
        goto X9Cjc;
        YvHXy:
        $v_found = true;
        goto FOI3U;
        rym_H:
        $i = 0;
        goto HjWNy;
        CtLHQ:
        @unlink($v_zip_temp_name);
        goto zisFZ;
        FOI3U:
        hcYws:
        goto kwdSd;
        OkoEW:
        $v_temp_zip->privCloseFd();
        goto mifE6;
        NgjPj:
        if (substr($p_options[PCLZIP_OPT_BY_NAME][$j], -1) == "\x2f") {
            goto xHjFV;
        }
        goto i9zr1;
        m7els:
        ayNKx:
        goto DzhlX;
        xElOU:
        $v_temp_zip->privCloseFd();
        goto uexA_;
        qyGlg:
        @unlink($this->zipname);
        goto N5tvf;
        FU1AW:
        $v_pos_entry = $v_central_dir["\157\x66\146\163\145\x74"];
        goto m7F5Q;
        TVqSu:
        if ($v_found) {
            goto oDupe;
        }
        goto hgDc4;
        Pjokf:
        FPXe0:
        goto QNHBQ;
        PggG4:
        return PclZip::errorCode();
        goto eAscP;
        fxt31:
        K9ETv:
        goto L7IMe;
        G73ft:
        $v_comment = $p_options[PCLZIP_OPT_COMMENT];
        goto gyEvn;
        MYRzN:
        goto S8dlH;
        goto Pjokf;
        v0DDd:
        if (!(($v_result = $v_temp_zip->privOpenFd("\x77\x62")) != 1)) {
            goto ofuYo;
        }
        goto jp_Qz;
        ipx1v:
        if (!preg_match($p_options[PCLZIP_OPT_BY_PREG], $v_header_list[$v_nb_extracted]["\x73\164\157\162\145\x64\137\x66\x69\154\x65\x6e\x61\x6d\145"])) {
            goto mjxMt;
        }
        goto to6Sq;
        T_nGB:
        $v_found = true;
        goto fxt31;
        R2N1f:
        return $v_result;
        goto wyF9y;
        ofZHE:
        unset($v_temp_zip);
        goto jIwW1;
        H2qOP:
        return $v_result;
        goto hL2wL;
        hgDc4:
        $v_nb_extracted++;
        goto fPMrv;
        wb44i:
        IFZzz:
        goto UXwGz;
        GLHLd:
        wkHiD:
        goto rExgW;
        DJZF4:
        return $v_result;
        goto KOp_6;
        zisFZ:
        return $v_result;
        goto mSBr2;
        gyEvn:
        dYBo7:
        goto TZuPc;
        cCuqU:
        goto BoF5J;
        goto wUjlh;
        EmaSe:
        goto BoF5J;
        goto YHPCA;
        wUjlh:
        AjHYZ:
        goto ipx1v;
        wyF9y:
        b1f4c:
        goto eJrjW;
        G71F2:
        $v_header_list[$v_nb_extracted]["\151\x6e\144\x65\170"] = $i;
        goto h0nax;
        oGZz_:
        $v_temp_zip->privCloseFd();
        goto dDv5f;
        rExgW:
        $this->privCloseFd();
        goto DE4og;
        A6gSo:
        oDupe:
        goto A2ieP;
        YNbvN:
        $this->privCloseFd();
        goto UBXX1;
        DE4og:
        if (!(($v_result = $this->privOpenFd("\x77\x62")) != 1)) {
            goto GhNaC;
        }
        goto H2qOP;
        ZiMfi:
        if (!($i >= $p_options[PCLZIP_OPT_BY_INDEX][$j]["\x73\164\141\162\x74"] && $i <= $p_options[PCLZIP_OPT_BY_INDEX][$j]["\x65\x6e\144"])) {
            goto K9ETv;
        }
        goto T_nGB;
        Ahr4i:
        $v_zip_temp_name = PCLZIP_TEMPORARY_DIR . uniqid("\x70\x63\154\172\151\160\x2d") . "\56\164\x6d\x70";
        goto VHlZ5;
        QNHBQ:
        if ($v_nb_extracted > 0) {
            goto A4FVn;
        }
        goto esVrc;
        I6xMO:
        if (!@fseek($this->zip_fd, $v_pos_entry)) {
            goto pODL2;
        }
        goto eXyvS;
        Cb1YM:
        unset($v_header_list);
        goto OkoEW;
        kwdSd:
        goto tHVpc;
        goto Oe0cL;
        Q72iT:
        if (!(($v_result = $this->privReadFileHeader($v_local_header)) != 1)) {
            goto WVH3r;
        }
        goto ChEm1;
        NPKbG:
        $this->privCloseFd();
        goto xElOU;
        CE1Nw:
        $i++;
        goto vQdx0;
        ziRhJ:
        vmhgo:
        goto dqd5u;
        N3gcJ:
        $j++;
        goto IneBo;
        yAX3a:
        if (!(($v_result = $v_temp_zip->privWriteCentralHeader(sizeof($v_header_list), $v_size, $v_offset, $v_comment)) != 1)) {
            goto ZtYMP;
        }
        goto Cb1YM;
        LDiY4:
        $this->privCloseFd();
        goto d5BQf;
        YHPCA:
        QmM_n:
        goto DHoNH;
        b1qMe:
        @rewind($this->zip_fd);
        goto oBEsf;
        V9USk:
        @unlink($v_zip_temp_name);
        goto BSNd2;
        Pqub_:
        hcsGo:
        goto ZMwv2;
        ByZSx:
        if (!($this->privCheckFileHeaders($v_local_header, $v_header_list[$i]) != 1)) {
            goto h5wfn;
        }
        goto fMwoV;
        XJ5SI:
        goto hcYws;
        goto hF_su;
        VHlZ5:
        $v_temp_zip = new PclZip($v_zip_temp_name);
        goto v0DDd;
        iZ2FJ:
        ZtYMP:
        goto Nr2Iu;
        Sarpk:
        goto iGrUx;
        goto io3pp;
        hLKMs:
        if (!(($v_result = $this->privWriteCentralHeader(0, 0, 0, '')) != 1)) {
            goto IFZzz;
        }
        goto qzzcu;
        BSNd2:
        PclZip::privErrorLog(PCLZIP_ERR_INVALID_ARCHIVE_ZIP, "\x49\x6e\166\141\x6c\x69\x64\x20\141\162\x63\150\x69\x76\x65\40\163\x69\x7a\145");
        goto PggG4;
        dqd5u:
        if (!($p_options[PCLZIP_OPT_BY_INDEX][$j]["\x73\164\x61\162\x74"] > $i)) {
            goto pXUa1;
        }
        goto Sarpk;
        Oe0cL:
        QKEvi:
        goto A2nuw;
        G9wMz:
        $v_result = 1;
        goto DXgZi;
        h0nax:
        $v_found = false;
        goto YqYoG;
        ctKtM:
        $v_header_list[$v_nb_extracted] = array();
        goto J4G5x;
        XbapO:
        if (!($i < sizeof($v_header_list))) {
            goto Jg7bb;
        }
        goto b1qMe;
        Ub2Ok:
        O9qYF:
        goto zR25L;
        xDPZb:
        return $v_result;
        goto e7IGL;
        vpiQy:
        $j_start = $j + 1;
        goto ziRhJ;
        A2nuw:
        $v_found = true;
        goto mzl6t;
        IfWvN:
        K2Ewo:
        goto HMU7Q;
        esVrc:
        if ($v_central_dir["\x65\x6e\x74\x72\x69\x65\x73"] != 0) {
            goto wkHiD;
        }
        goto YnqHX;
        d5BQf:
        @unlink($v_zip_temp_name);
        goto R2N1f;
        S66ft:
        if (strlen($v_header_list[$v_nb_extracted]["\x73\x74\157\162\145\144\x5f\x66\151\154\x65\156\141\x6d\145"]) > strlen($p_options[PCLZIP_OPT_BY_NAME][$j]) && substr($v_header_list[$v_nb_extracted]["\x73\164\157\x72\x65\x64\137\146\x69\x6c\145\156\x61\155\145"], 0, strlen($p_options[PCLZIP_OPT_BY_NAME][$j])) == $p_options[PCLZIP_OPT_BY_NAME][$j]) {
            goto PdWb_;
        }
        goto vx0UK;
        ZMwv2:
        $v_comment = '';
        goto Z6rNG;
        kZiU5:
        $v_offset = @ftell($v_temp_zip->zip_fd);
        goto or85X;
        mzl6t:
        tHVpc:
        goto Og8KB;
        oOYyc:
        $j_start = 0;
        goto OPoTT;
        b5ErU:
        Jg7bb:
        goto kZiU5;
        PSLQV:
        goto hcYws;
        goto SYwcP;
        j_0CB:
        NvoYa:
        goto QoWQs;
        tAehD:
        if (isset($p_options[PCLZIP_OPT_BY_INDEX]) && $p_options[PCLZIP_OPT_BY_INDEX] != 0) {
            goto QmM_n;
        }
        goto nxMet;
        djveX:
        BoF5J:
        goto TVqSu;
        TYwzx:
        S8dlH:
        goto irGjX;
        vQdx0:
        goto K2Ewo;
        goto Pqub_;
        eAscP:
        SV7ja:
        goto NdJJW;
        to6Sq:
        $v_found = true;
        goto wstUu;
        mSBr2:
        WVH3r:
        goto ByZSx;
        RyKdy:
        if (!(($v_result = $this->privOpenFd("\162\x62")) != 1)) {
            goto P1yVc;
        }
        goto DJZF4;
        eJrjW:
        $v_temp_zip->privConvertHeader2FileInfo($v_header_list[$i], $p_result_list[$i]);
        goto Pao6u;
        PKagx:
        goto SRN2y;
        goto b5ErU;
        k7JOl:
        goto O9qYF;
        goto lKJqH;
        B7kHY:
        $j = 0;
        goto Ub2Ok;
        YqYoG:
        if (isset($p_options[PCLZIP_OPT_BY_NAME]) && $p_options[PCLZIP_OPT_BY_NAME] != 0) {
            goto eUcwc;
        }
        goto wPeec;
        Pao6u:
        CJyp0:
        goto CE1Nw;
        jp_Qz:
        $this->privCloseFd();
        goto PTHzg;
        S8DUU:
        goto tHVpc;
        goto EN5zV;
        HMU7Q:
        if (!($i < sizeof($v_header_list))) {
            goto hcsGo;
        }
        goto vKWEu;
        Jwrt5:
        NlmfD:
        goto sM3fr;
        or85X:
        $i = 0;
        goto IfWvN;
        UXwGz:
        $this->privCloseFd();
        goto DD247;
        C7dlO:
        $i++;
        goto PKagx;
        zgsXq:
        $v_temp_zip->privCloseFd();
        goto CtLHQ;
        PTHzg:
        return $v_result;
        goto t55Uy;
        Z6rNG:
        if (!isset($p_options[PCLZIP_OPT_COMMENT])) {
            goto dYBo7;
        }
        goto G73ft;
        Yv8Dn:
        $v_temp_zip->privCloseFd();
        goto LDiY4;
        KOp_6:
        P1yVc:
        goto uTrEt;
        fTr1E:
        eFxAO:
        goto Ebidl;
        IeUuz:
        P73qs:
        goto j_0CB;
        qzzcu:
        return $v_result;
        goto wb44i;
        IYwap:
        HPEAu:
        goto F0lqY;
        DD247:
        pzAof:
        goto xDPZb;
        HXUcH:
        eUcwc:
        goto B7kHY;
        vKWEu:
        if (!(($v_result = $v_temp_zip->privWriteCentralFileHeader($v_header_list[$i])) != 1)) {
            goto b1f4c;
        }
        goto Yv8Dn;
        DzhlX:
        if (!(($v_result = PclZipUtilCopyBlock($this->zip_fd, $v_temp_zip->zip_fd, $v_header_list[$i]["\143\157\155\160\x72\x65\163\163\145\x64\x5f\163\x69\x7a\145"])) != 1)) {
            goto HPEAu;
        }
        goto b4Pas;
        i9zr1:
        if ($v_header_list[$v_nb_extracted]["\163\164\x6f\162\145\x64\x5f\x66\x69\x6c\x65\156\x61\155\145"] == $p_options[PCLZIP_OPT_BY_NAME][$j]) {
            goto QKEvi;
        }
        goto S8DUU;
        dDv5f:
        @unlink($v_zip_temp_name);
        goto QvjzZ;
        X9Cjc:
        iGrUx:
        goto djveX;
        CANKz:
        return $v_result;
        goto iZ2FJ;
        e7IGL:
    }
    public function privDirCheck($p_dir, $p_is_dir = false)
    {
        goto kkSM0;
        BTISG:
        if (!($p_parent_dir != $p_dir)) {
            goto X1j6q;
        }
        goto JHkv9;
        Fo_xA:
        kgQzg:
        goto oMjvN;
        LgLC0:
        mzCos:
        goto OTsWF;
        PXB87:
        Z57jT:
        goto vG0py;
        oMjvN:
        X1j6q:
        goto vLQo_;
        kkSM0:
        $v_result = 1;
        goto BqLjx;
        JHkv9:
        if (!($p_parent_dir != '')) {
            goto kgQzg;
        }
        goto ElLfP;
        OTsWF:
        $p_parent_dir = dirname($p_dir);
        goto BTISG;
        vG0py:
        if (!(is_dir($p_dir) || $p_dir == '')) {
            goto mzCos;
        }
        goto U4F0m;
        ElLfP:
        if (!(($v_result = $this->privDirCheck($p_parent_dir)) != 1)) {
            goto gpjgZ;
        }
        goto G_C7T;
        eIPow:
        Ef8dz:
        goto hke17;
        U4F0m:
        return 1;
        goto LgLC0;
        u43vF:
        PclZip::privErrorLog(PCLZIP_ERR_DIR_CREATE_FAIL, "\x55\156\141\x62\x6c\145\40\164\157\x20\x63\x72\145\141\164\145\40\x64\x69\x72\x65\x63\164\x6f\162\171\40\47{$p_dir}\x27");
        goto ItHmp;
        AVOGT:
        $p_dir = substr($p_dir, 0, strlen($p_dir) - 1);
        goto PXB87;
        nNZXm:
        gpjgZ:
        goto Fo_xA;
        ItHmp:
        return PclZip::errorCode();
        goto eIPow;
        vLQo_:
        if (@mkdir($p_dir, 511)) {
            goto Ef8dz;
        }
        goto u43vF;
        hke17:
        return $v_result;
        goto uX1t3;
        G_C7T:
        return $v_result;
        goto nNZXm;
        BqLjx:
        if (!($p_is_dir && substr($p_dir, -1) == "\57")) {
            goto Z57jT;
        }
        goto AVOGT;
        uX1t3:
    }
    public function privMerge(&$p_archive_to_add)
    {
        goto YWu99;
        dUn7d:
        S40Kt:
        goto hczxj;
        ZE2d2:
        if (is_file($p_archive_to_add->zipname)) {
            goto op81H;
        }
        goto Nxjho;
        SPEZo:
        op81H:
        goto SiXgu;
        SiXgu:
        if (is_file($this->zipname)) {
            goto vj715;
        }
        goto pnm63;
        rYgDD:
        $v_central_dir_to_add = array();
        goto jNDe0;
        bVtQ4:
        vj715:
        goto D1hKL;
        jNDe0:
        if (!(($v_result = $p_archive_to_add->privReadEndCentralDir($v_central_dir_to_add)) != 1)) {
            goto ocK5e;
        }
        goto g9jWt;
        Odw94:
        $this->privCloseFd();
        goto nl6MI;
        kgAk6:
        fhsZI:
        goto j9h1Q;
        oGl3k:
        return $v_result;
        goto JbyuM;
        yCn_Z:
        return $v_result;
        goto Wa1VR;
        qpJ4F:
        $this->privCloseFd();
        goto I52RH;
        hczxj:
        $v_size = $v_central_dir["\157\146\x66\163\145\164"];
        goto rj5TT;
        ZQSEz:
        $p_archive_to_add->privCloseFd();
        goto isMr7;
        a68TZ:
        @fwrite($v_zip_temp_fd, $v_buffer, $v_read_size);
        goto u6ppR;
        zASsM:
        $p_archive_to_add->privCloseFd();
        goto YtIGn;
        gOnV2:
        @unlink($this->zipname);
        goto fY2U4;
        g0CZI:
        return $v_result;
        goto SPEZo;
        ZPVvt:
        goto ENcZn;
        goto wWYOG;
        KS8_G:
        goto QDYMY;
        goto Ijlf_;
        FY1oQ:
        @fwrite($v_zip_temp_fd, $v_buffer, $v_read_size);
        goto virDv;
        S1EEa:
        $v_buffer = fread($this->zip_fd, $v_read_size);
        goto a68TZ;
        KdBT9:
        $v_read_size = $v_size < PCLZIP_READ_BLOCK_SIZE ? $v_size : PCLZIP_READ_BLOCK_SIZE;
        goto MtPiK;
        Jlu9O:
        $v_size = $v_central_dir_to_add["\x73\x69\x7a\145"];
        goto kgAk6;
        uJTM1:
        $v_buffer = @fread($p_archive_to_add->zip_fd, $v_read_size);
        goto FY1oQ;
        NMClR:
        if (!($v_size != 0)) {
            goto yRaFs;
        }
        goto tknRJ;
        n8XPJ:
        return $v_result;
        goto iKvAQ;
        TVLDq:
        $v_swap = $this->zip_fd;
        goto i4jTo;
        LzVF6:
        unset($v_header_list);
        goto yCn_Z;
        b6Sj4:
        $this->privCloseFd();
        goto zASsM;
        gaI_i:
        if (!(($v_result = $p_archive_to_add->privOpenFd("\162\x62")) != 1)) {
            goto ipRBD;
        }
        goto Odw94;
        u6ppR:
        $v_size -= $v_read_size;
        goto HuEuk;
        zf6LB:
        $v_zip_temp_fd = $v_swap;
        goto b6Sj4;
        efUyW:
        @rewind($p_archive_to_add->zip_fd);
        goto IyggT;
        XO3mv:
        if (!($v_size != 0)) {
            goto mKY2x;
        }
        goto wqdW4;
        D1hKL:
        if (!(($v_result = $this->privOpenFd("\162\142")) != 1)) {
            goto wXAvv;
        }
        goto RJ6e4;
        Kbejf:
        wXAvv:
        goto H8qqu;
        NWvhv:
        if (!(($v_zip_temp_fd = @fopen($v_zip_temp_name, "\167\142")) == 0)) {
            goto S40Kt;
        }
        goto qpJ4F;
        YWu99:
        $v_result = 1;
        goto ZE2d2;
        rEeqE:
        $v_offset = @ftell($v_zip_temp_fd);
        goto Jg2fk;
        j9h1Q:
        if (!($v_size != 0)) {
            goto DH4t_;
        }
        goto sP1zp;
        tzpba:
        $this->zip_fd = $v_zip_temp_fd;
        goto jAsPi;
        tknRJ:
        $v_read_size = $v_size < PCLZIP_READ_BLOCK_SIZE ? $v_size : PCLZIP_READ_BLOCK_SIZE;
        goto CySM4;
        ihEw3:
        if (!(($v_result = $this->privWriteCentralHeader($v_central_dir["\145\x6e\x74\162\151\145\x73"] + $v_central_dir_to_add["\145\156\164\162\151\145\163"], $v_size, $v_offset, $v_comment)) != 1)) {
            goto oBAKe;
        }
        goto lhas1;
        sP1zp:
        $v_read_size = $v_size < PCLZIP_READ_BLOCK_SIZE ? $v_size : PCLZIP_READ_BLOCK_SIZE;
        goto uJTM1;
        RJ6e4:
        return $v_result;
        goto Kbejf;
        Xr3gM:
        mKY2x:
        goto Y3qqZ;
        Naxlz:
        if (!(($v_result = $this->privReadEndCentralDir($v_central_dir)) != 1)) {
            goto fSaA3;
        }
        goto axwww;
        virDv:
        $v_size -= $v_read_size;
        goto Y9Bs0;
        i4jTo:
        $this->zip_fd = $v_zip_temp_fd;
        goto zf6LB;
        Ijlf_:
        M8TKn:
        goto rEeqE;
        JbyuM:
        ocK5e:
        goto efUyW;
        TJQb6:
        $v_swap = $this->zip_fd;
        goto tzpba;
        IyggT:
        $v_zip_temp_name = PCLZIP_TEMPORARY_DIR . uniqid("\160\143\x6c\x7a\151\160\55") . "\56\x74\x6d\160";
        goto NWvhv;
        PiZFh:
        $v_size -= $v_read_size;
        goto KS8_G;
        Y3qqZ:
        $v_size = $v_central_dir_to_add["\x6f\146\x66\163\x65\164"];
        goto GZiDe;
        hq363:
        $v_size = @ftell($v_zip_temp_fd) - $v_offset;
        goto TJQb6;
        GDYbs:
        ENcZn:
        goto NMClR;
        g9jWt:
        $this->privCloseFd();
        goto RTF_c;
        wqdW4:
        $v_read_size = $v_size < PCLZIP_READ_BLOCK_SIZE ? $v_size : PCLZIP_READ_BLOCK_SIZE;
        goto S1EEa;
        rj5TT:
        MhZ2b:
        goto XO3mv;
        wWYOG:
        yRaFs:
        goto Jlu9O;
        sddjY:
        if (!($v_size != 0)) {
            goto M8TKn;
        }
        goto KdBT9;
        GZiDe:
        QDYMY:
        goto sddjY;
        is3Cx:
        PclZip::privErrorLog(PCLZIP_ERR_READ_OPEN_FAIL, "\125\x6e\141\142\x6c\145\x20\164\x6f\x20\157\x70\x65\156\x20\x74\145\155\x70\157\162\141\162\171\40\146\x69\x6c\x65\x20\47" . $v_zip_temp_name . "\47\x20\x69\156\x20\142\x69\x6e\x61\162\171\40\x77\x72\x69\164\x65\x20\155\x6f\x64\x65");
        goto gJ_n7;
        Y9Bs0:
        goto fhsZI;
        goto iv91R;
        AaJOg:
        @rewind($this->zip_fd);
        goto gaI_i;
        bYUl8:
        return $v_result;
        goto M8yAM;
        qL8Bo:
        $v_comment = $v_central_dir["\143\x6f\155\x6d\x65\x6e\x74"] . "\40" . $v_central_dir_to_add["\x63\157\x6d\155\x65\156\x74"];
        goto hq363;
        CySM4:
        $v_buffer = @fread($this->zip_fd, $v_read_size);
        goto I7TbT;
        zvxdE:
        return $v_result;
        goto bVtQ4;
        iv91R:
        DH4t_:
        goto qL8Bo;
        axwww:
        $this->privCloseFd();
        goto n8XPJ;
        RTF_c:
        $p_archive_to_add->privCloseFd();
        goto oGl3k;
        nl6MI:
        return $v_result;
        goto whvyJ;
        lhas1:
        $this->privCloseFd();
        goto ZQSEz;
        pnm63:
        $v_result = $this->privDuplicate($p_archive_to_add->zipname);
        goto zvxdE;
        Wa1VR:
        oBAKe:
        goto TVLDq;
        Jg2fk:
        $v_size = $v_central_dir["\163\x69\172\x65"];
        goto GDYbs;
        lCIB3:
        @fwrite($v_zip_temp_fd, $v_buffer, $v_read_size);
        goto PiZFh;
        jAsPi:
        $v_zip_temp_fd = $v_swap;
        goto ihEw3;
        Nxjho:
        $v_result = 1;
        goto g0CZI;
        fY2U4:
        PclZipUtilRename($v_zip_temp_name, $this->zipname);
        goto bYUl8;
        H8qqu:
        $v_central_dir = array();
        goto Naxlz;
        iKvAQ:
        fSaA3:
        goto AaJOg;
        isMr7:
        @fclose($v_zip_temp_fd);
        goto mKUi9;
        gJ_n7:
        return PclZip::errorCode();
        goto dUn7d;
        wu19q:
        $v_size -= $v_read_size;
        goto ZPVvt;
        I52RH:
        $p_archive_to_add->privCloseFd();
        goto is3Cx;
        I7TbT:
        @fwrite($v_zip_temp_fd, $v_buffer, $v_read_size);
        goto wu19q;
        YtIGn:
        @fclose($v_zip_temp_fd);
        goto gOnV2;
        mKUi9:
        $this->zip_fd = null;
        goto LzVF6;
        whvyJ:
        ipRBD:
        goto rYgDD;
        MtPiK:
        $v_buffer = fread($p_archive_to_add->zip_fd, $v_read_size);
        goto lCIB3;
        HuEuk:
        goto MhZ2b;
        goto Xr3gM;
        M8yAM:
    }
    public function privDuplicate($p_archive_filename)
    {
        goto ikdIR;
        e6b9X:
        $v_size = filesize($p_archive_filename);
        goto uZRKK;
        Gmk7a:
        goto hrdS3;
        goto wwxFl;
        LQTdA:
        return $v_result;
        goto rLpw5;
        HLC7n:
        A62FK:
        goto qYlcG;
        zswGu:
        return $v_result;
        goto LrhHb;
        bb9el:
        $this->privCloseFd();
        goto exxXQ;
        u7v7E:
        if (!(($v_zip_temp_fd = @fopen($p_archive_filename, "\162\x62")) == 0)) {
            goto ZaRGk;
        }
        goto bb9el;
        dYmn6:
        @fwrite($this->zip_fd, $v_buffer, $v_read_size);
        goto Itawt;
        dkg1b:
        if (!($v_size != 0)) {
            goto uvsv2;
        }
        goto iLZsl;
        rLpw5:
        DdyTx:
        goto u7v7E;
        RJdYI:
        $this->privCloseFd();
        goto RaPQI;
        exxXQ:
        PclZip::privErrorLog(PCLZIP_ERR_READ_OPEN_FAIL, "\125\156\141\142\x6c\x65\40\x74\x6f\40\x6f\x70\145\x6e\x20\x61\x72\143\150\x69\x76\145\x20\x66\x69\154\x65\x20\47" . $p_archive_filename . "\47\40\x69\156\40\x62\151\156\141\x72\171\x20\167\162\x69\164\x65\x20\155\x6f\x64\145");
        goto FFZTA;
        wwxFl:
        uvsv2:
        goto RJdYI;
        uZRKK:
        hrdS3:
        goto dkg1b;
        FFZTA:
        return PclZip::errorCode();
        goto Kcy4D;
        RaPQI:
        @fclose($v_zip_temp_fd);
        goto zswGu;
        Itawt:
        $v_size -= $v_read_size;
        goto Gmk7a;
        c35SM:
        $v_buffer = fread($v_zip_temp_fd, $v_read_size);
        goto dYmn6;
        QxIr6:
        $v_result = 1;
        goto hpE4A;
        Kcy4D:
        ZaRGk:
        goto e6b9X;
        iLZsl:
        $v_read_size = $v_size < PCLZIP_READ_BLOCK_SIZE ? $v_size : PCLZIP_READ_BLOCK_SIZE;
        goto c35SM;
        hpE4A:
        return $v_result;
        goto HLC7n;
        qYlcG:
        if (!(($v_result = $this->privOpenFd("\167\142")) != 1)) {
            goto DdyTx;
        }
        goto LQTdA;
        kwLRT:
        if (is_file($p_archive_filename)) {
            goto A62FK;
        }
        goto QxIr6;
        ikdIR:
        $v_result = 1;
        goto kwLRT;
        LrhHb:
    }
    public function privErrorLog($p_error_code = 0, $p_error_string = '')
    {
        goto vFLMH;
        vFLMH:
        if (PCLZIP_ERROR_EXTERNAL == 1) {
            goto Om0CK;
        }
        goto PvldF;
        tj9cX:
        $this->error_string = $p_error_string;
        goto JnoML;
        PvldF:
        $this->error_code = $p_error_code;
        goto tj9cX;
        JnoML:
        goto iGnug;
        goto EgtOV;
        aTX3u:
        iGnug:
        goto WArJT;
        EgtOV:
        Om0CK:
        goto XOAJ2;
        XOAJ2:
        PclError($p_error_code, $p_error_string);
        goto aTX3u;
        WArJT:
    }
    public function privErrorReset()
    {
        goto e8ohy;
        yfF63:
        $this->error_code = 0;
        goto xudVV;
        xudVV:
        $this->error_string = '';
        goto RAQeB;
        e8ohy:
        if (PCLZIP_ERROR_EXTERNAL == 1) {
            goto YuDg1;
        }
        goto yfF63;
        uPPOp:
        YuDg1:
        goto BDUas;
        RAQeB:
        goto iT9In;
        goto uPPOp;
        BDUas:
        PclErrorReset();
        goto sJAAp;
        sJAAp:
        iT9In:
        goto SFqA0;
        SFqA0:
    }
    public function privDisableMagicQuotes()
    {
        goto U3VYE;
        mTnyD:
        return $v_result;
        goto hIrC2;
        Fnw5B:
        FCYqS:
        goto GQcXz;
        bocc7:
        return $v_result;
        goto Fnw5B;
        U3VYE:
        $v_result = 1;
        goto C80Sq;
        hIrC2:
        J45c0:
        goto LIXdZ;
        C80Sq:
        if (!(!function_exists("\147\145\164\x5f\155\x61\147\151\x63\137\161\165\157\164\145\163\137\162\165\x6e\164\151\155\145") || !function_exists("\x73\x65\164\137\x6d\141\147\x69\x63\137\161\x75\157\x74\x65\163\137\x72\165\x6e\x74\151\155\x65"))) {
            goto FCYqS;
        }
        goto bocc7;
        LIXdZ:
        $this->magic_quotes_status = @get_magic_quotes_runtime();
        goto aj4is;
        BFnZO:
        return $v_result;
        goto COG2h;
        GQcXz:
        if (!($this->magic_quotes_status != -1)) {
            goto J45c0;
        }
        goto mTnyD;
        aailS:
        FUDI9:
        goto BFnZO;
        wyUX5:
        @set_magic_quotes_runtime(0);
        goto aailS;
        aj4is:
        if (!($this->magic_quotes_status == 1)) {
            goto FUDI9;
        }
        goto wyUX5;
        COG2h:
    }
    public function privSwapBackMagicQuotes()
    {
        goto kD4N_;
        kD4N_:
        $v_result = 1;
        goto MKxxw;
        gFJWp:
        f_TfI:
        goto Nq3Ie;
        Nq3Ie:
        return $v_result;
        goto Ez1dl;
        zu1r5:
        O03gb:
        goto puvzB;
        k_Q3o:
        return $v_result;
        goto zu1r5;
        VOnRw:
        return $v_result;
        goto zkP_u;
        MKxxw:
        if (!(!function_exists("\x67\145\x74\137\x6d\141\x67\x69\143\x5f\x71\165\157\164\145\163\137\x72\165\156\x74\151\155\x65") || !function_exists("\x73\x65\164\137\x6d\141\147\x69\x63\137\161\x75\x6f\164\x65\163\x5f\162\165\x6e\164\x69\155\145"))) {
            goto O03gb;
        }
        goto k_Q3o;
        zkP_u:
        kmAwS:
        goto g93JI;
        oPKFx:
        @set_magic_quotes_runtime($this->magic_quotes_status);
        goto gFJWp;
        g93JI:
        if (!($this->magic_quotes_status == 1)) {
            goto f_TfI;
        }
        goto oPKFx;
        puvzB:
        if (!($this->magic_quotes_status != -1)) {
            goto kmAwS;
        }
        goto VOnRw;
        Ez1dl:
    }
}
goto y1K5U;
kjlM9:
define("\x50\x43\x4c\132\x49\x50\x5f\105\x52\x52\x5f\104\105\114\x45\124\105\137\106\x49\x4c\105\137\106\x41\x49\x4c", -11);
goto rI3dg;
ZU8fP:
define("\120\103\114\132\x49\120\x5f\117\x50\124\137\x42\131\x5f\120\122\105\x47", 77011);
goto uNcCJ;
eeFDc:
define("\120\103\114\x5a\x49\x50\x5f\x45\122\x52\137\125\x4e\123\x55\120\120\x4f\x52\x54\x45\104\137\105\116\103\x52\x59\120\124\111\117\x4e", -19);
goto BMlsb;
CiHdL:
define("\x50\103\x4c\x5a\x49\x50\x5f\x45\x52\x52\117\x52\x5f\x45\130\x54\105\122\116\101\x4c", 0);
goto qfFlc;
p7Zhp:
define("\120\103\x4c\132\111\x50\x5f\105\x52\x52\137\x55\x53\105\x52\137\x41\x42\x4f\x52\124\x45\x44", 2);
goto S9Mlk;
Exooq:
define("\120\103\114\x5a\111\120\137\117\x50\x54\x5f\122\105\115\117\126\105\137\101\114\114\x5f\120\x41\124\x48", 77004);
goto j4euu;
LVv4C:
xh5Oe:
goto k1_l7;
IspMU:
define("\x50\x43\114\x5a\111\120\x5f\117\120\124\x5f\x45\130\x54\x52\101\x43\x54\137\104\111\x52\137\x52\x45\123\x54\x52\x49\103\124\x49\x4f\x4e", 77019);
goto zpQqe;
UXIFQ:
define("\120\x43\114\x5a\x49\120\137\x54\x45\x4d\x50\117\122\x41\122\131\x5f\x44\x49\122", '');
goto y7OQp;
aXT12:
define("\120\x43\114\132\x49\x50\137\x45\122\122\137\104\111\122\x45\103\x54\117\x52\x59\x5f\122\105\x53\x54\x52\111\x43\124\111\x4f\116", -21);
goto vEoaX;
Mf6al:
define("\120\103\x4c\x5a\111\x50\x5f\x4f\x50\124\x5f\x42\131\137\x45\x52\x45\107", 77010);
goto ZU8fP;
p9lda:
$g_pclzip_version = "\x32\x2e\70\x2e\62";
goto p7Zhp;
jIc0I:
if (defined("\x50\103\114\x5a\111\120\137\x54\105\115\120\x4f\122\x41\x52\x59\137\x44\111\x52")) {
    goto Hyyct;
}
goto UXIFQ;
ylShh:
define("\120\103\114\x5a\x49\x50\x5f\x4f\120\x54\x5f\116\x4f\x5f\103\x4f\x4d\120\122\x45\123\123\x49\x4f\116", 77007);
goto suCou;
iS2u0:
define("\x50\103\114\x5a\111\x50\137\117\120\124\x5f\x41\104\104\137\124\105\x4d\120\x5f\x46\x49\114\x45\x5f\117\x46\106", 77022);
goto aMXVo;
nhcSL:
function PclZipUtilOptionText($p_option)
{
    goto EPB84;
    DXw1t:
    ZYij2:
    goto YvLto;
    K2oJv:
    HhPuJ:
    goto Q431Y;
    tUd0J:
    return $v_key;
    goto DXw1t;
    HLinY:
    reset($v_list);
    goto M9gbD;
    EPB84:
    $v_list = get_defined_constants();
    goto HLinY;
    eANSx:
    goto dLktQ;
    goto K2oJv;
    I4VJR:
    return $v_result;
    goto mxfWL;
    M9gbD:
    dLktQ:
    goto G3BHu;
    Q431Y:
    $v_result = "\125\x6e\x6b\x6e\x6f\x77\x6e";
    goto I4VJR;
    qUELB:
    if (!(($v_prefix == "\120\103\114\x5a\x49\x50\137\x4f\x50\x54" || $v_prefix == "\x50\103\114\132\x49\x50\137\103\102\137" || $v_prefix == "\x50\x43\x4c\x5a\x49\120\137\x41\124\124") && $v_list[$v_key] == $p_option)) {
        goto ZYij2;
    }
    goto tUd0J;
    YvLto:
    qgyB4:
    goto NwWsi;
    G3BHu:
    if (!($v_key = key($v_list))) {
        goto HhPuJ;
    }
    goto Q1U3o;
    NwWsi:
    next($v_list);
    goto eANSx;
    Q1U3o:
    $v_prefix = substr($v_key, 0, 10);
    goto qUELB;
    mxfWL:
}
goto c10mP;
y1K5U:
function PclZipUtilPathReduction($p_dir)
{
    goto DUQPH;
    P1fub:
    $i--;
    goto sMBW0;
    Z3dLt:
    FzNid:
    goto uPXJ2;
    rbGmB:
    goto yAvVg;
    goto yLVYu;
    EKhK1:
    $v_result = $p_dir;
    goto k4Ioz;
    dLQdW:
    if ($v_list[$i] == "\x2e\x2e") {
        goto t7uuB;
    }
    goto uKT3R;
    IEFxH:
    $v_result = $v_list[$i];
    goto xdV3b;
    Hn4fx:
    t7uuB:
    goto sL46N;
    RZFla:
    eyusq:
    goto pgiFC;
    OZfvw:
    $v_skip = 0;
    goto q7H0P;
    u41Tu:
    qS6FI:
    goto QD_wr;
    Lpwsp:
    if ($i == sizeof($v_list) - 1) {
        goto A5RYC;
    }
    goto ddYPc;
    uPXJ2:
    if (!($i >= 0)) {
        goto LL9MR;
    }
    goto KjVmb;
    ACMxP:
    LL9MR:
    goto l_3lc;
    zP3FV:
    goto rLrAH;
    goto oHdNJ;
    beTfC:
    $v_result = "\56\56\57" . $v_result;
    goto KjExA;
    gYcaD:
    goto I3pQh;
    goto Hn4fx;
    Ls09f:
    if ($i == 0) {
        goto kcbry;
    }
    goto Lpwsp;
    yYm7p:
    if (!($p_dir != '')) {
        goto qS6FI;
    }
    goto PDZFB;
    kHKrK:
    if (!($v_skip > 0)) {
        goto eyusq;
    }
    goto EKhK1;
    xdV3b:
    HKeCM:
    goto fjDcQ;
    KjExA:
    $v_skip--;
    goto rbGmB;
    MevIL:
    reZAV:
    goto u41Tu;
    pgiFC:
    goto HKeCM;
    goto FdSPv;
    QD_wr:
    return $v_result;
    goto O1Pkr;
    gwUJP:
    yzdhj:
    goto P1fub;
    FdSPv:
    A5RYC:
    goto IEFxH;
    YUbpJ:
    $v_skip--;
    goto umXxo;
    IJkad:
    goto I3pQh;
    goto wHd8U;
    KjVmb:
    if ($v_list[$i] == "\x2e") {
        goto di5_b;
    }
    goto dLQdW;
    k4Ioz:
    $v_skip = 0;
    goto RZFla;
    yLVYu:
    g2Wb4:
    goto MevIL;
    sMBW0:
    goto FzNid;
    goto ACMxP;
    ii5hZ:
    goto I3pQh;
    goto pjL16;
    UqhpZ:
    $v_result = "\x2f" . $v_result;
    goto kHKrK;
    ddYPc:
    goto HKeCM;
    goto wDzyO;
    umXxo:
    rLrAH:
    goto IJkad;
    PDZFB:
    $v_list = explode("\x2f", $p_dir);
    goto OZfvw;
    oHdNJ:
    ZPqhQ:
    goto YUbpJ;
    wHd8U:
    di5_b:
    goto gYcaD;
    X3dL0:
    yAvVg:
    goto fsSZm;
    uKT3R:
    if ($v_list[$i] == '') {
        goto Bl863;
    }
    goto McbX1;
    DUQPH:
    $v_result = '';
    goto yYm7p;
    fjDcQ:
    I3pQh:
    goto gwUJP;
    pPXpZ:
    $v_result = $v_list[$i] . ($i != sizeof($v_list) - 1 ? "\x2f" . $v_result : '');
    goto zP3FV;
    McbX1:
    if ($v_skip > 0) {
        goto ZPqhQ;
    }
    goto pPXpZ;
    wDzyO:
    kcbry:
    goto UqhpZ;
    q7H0P:
    $i = sizeof($v_list) - 1;
    goto Z3dLt;
    l_3lc:
    if (!($v_skip > 0)) {
        goto reZAV;
    }
    goto X3dL0;
    sL46N:
    $v_skip++;
    goto ii5hZ;
    pjL16:
    Bl863:
    goto Ls09f;
    fsSZm:
    if (!($v_skip > 0)) {
        goto g2Wb4;
    }
    goto beTfC;
    O1Pkr:
}
goto d4KzF;
JqdQc:
define("\x50\x43\114\132\111\120\x5f\x45\x52\x52\137\104\111\x52\x5f\x43\122\x45\101\x54\105\x5f\106\x41\111\x4c", -8);
goto ZzdyY;
siYqH:
define("\x50\x43\114\x5a\111\120\137\105\122\122\x5f\122\105\101\x44\137\117\x50\x45\116\137\x46\101\x49\114", -2);
goto FlxAH;
zaP4P:
define("\x50\x43\114\132\x49\120\x5f\117\120\124\x5f\101\104\104\137\x54\x45\x4d\x50\x5f\106\x49\114\x45\x5f\x4f\x4e", 77021);
goto HlHlO;
ZssxZ:
define("\120\103\x4c\132\111\120\x5f\101\124\124\137\106\x49\x4c\x45\137\103\x4f\115\115\x45\x4e\x54", 79006);
goto gUr9E;
suCou:
define("\x50\x43\114\132\x49\x50\x5f\x4f\x50\124\137\x42\x59\x5f\x4e\101\x4d\105", 77008);
goto lyVIb;
m6dus:
define("\x50\103\x4c\132\111\120\x5f\x4f\x50\124\x5f\122\105\x4d\117\x56\x45\137\120\x41\124\110", 77003);
goto Exooq;
i2Ent:
function PclZipUtilRename($p_src, $p_dest)
{
    goto K_P28;
    pQRNB:
    $v_result = 0;
    goto swQt_;
    evpeZ:
    oHe8g:
    goto pQRNB;
    pIWX4:
    if (@rename($p_src, $p_dest)) {
        goto gs2wv;
    }
    goto Zu7sw;
    zoJFy:
    gs2wv:
    goto OmPFC;
    ScZhC:
    CV6vp:
    goto JHLvp;
    eiz9_:
    o6Xkm:
    goto zoJFy;
    swQt_:
    goto o6Xkm;
    goto ScZhC;
    K_P28:
    $v_result = 1;
    goto pIWX4;
    Zu7sw:
    if (!@copy($p_src, $p_dest)) {
        goto oHe8g;
    }
    goto YnI1g;
    OmPFC:
    return $v_result;
    goto mnsHP;
    R8D0f:
    goto o6Xkm;
    goto evpeZ;
    JHLvp:
    $v_result = 0;
    goto eiz9_;
    YnI1g:
    if (!@unlink($p_src)) {
        goto CV6vp;
    }
    goto R8D0f;
    mnsHP:
}
goto nhcSL;
h9p4h:
define("\x50\103\x4c\132\x49\x50\x5f\x45\x52\122\x5f\111\x4e\126\101\x4c\111\104\x5f\x4f\x50\x54\x49\117\116\137\126\101\x4c\x55\105", -16);
goto gMxmt;
Jf8JV:
define("\x50\x43\x4c\132\111\120\137\105\x52\x52\x5f\127\x52\111\x54\x45\x5f\117\120\x45\x4e\137\x46\x41\111\114", -1);
goto siYqH;
vxW4i:
define("\x50\x43\x4c\x5a\111\120\x5f\117\x50\124\137\x54\105\x4d\x50\137\x46\111\x4c\x45\x5f\117\116", 77021);
goto zaP4P;
wuLjm:
function PclZipUtilCopyBlock($p_src, $p_dest, $p_size, $p_mode = 0)
{
    goto FTL3R;
    Gjrs5:
    fHvtO:
    goto vbkCO;
    vbkCO:
    return $v_result;
    goto pZ_fd;
    Nnf8k:
    if (!($p_size != 0)) {
        goto re_ZZ;
    }
    goto pt3eJ;
    NM2ZL:
    $v_read_size = $p_size < PCLZIP_READ_BLOCK_SIZE ? $p_size : PCLZIP_READ_BLOCK_SIZE;
    goto wqB35;
    esman:
    if ($p_mode == 2) {
        goto st3TD;
    }
    goto daYmP;
    KXPpr:
    aG1DJ:
    goto NoqEi;
    AkodR:
    BGoFE:
    goto PfB3p;
    H2T1I:
    if (!($p_size != 0)) {
        goto fcDjL;
    }
    goto NM2ZL;
    l2gvc:
    goto fHvtO;
    goto v7hpS;
    B_hxG:
    @gzwrite($p_dest, $v_buffer, $v_read_size);
    goto hPGSL;
    NoqEi:
    if (!($p_size != 0)) {
        goto BGoFE;
    }
    goto CR7m7;
    CR7m7:
    $v_read_size = $p_size < PCLZIP_READ_BLOCK_SIZE ? $p_size : PCLZIP_READ_BLOCK_SIZE;
    goto eeugX;
    Qe6jz:
    if (!($p_size != 0)) {
        goto KN_JU;
    }
    goto TOQpP;
    i_Hsa:
    @fwrite($p_dest, $v_buffer, $v_read_size);
    goto b0yA3;
    xni5q:
    goto aG1DJ;
    goto AkodR;
    isEi6:
    OEyNC:
    goto Qe6jz;
    S5YAe:
    $v_buffer = @fread($p_src, $v_read_size);
    goto i_Hsa;
    NQ5VJ:
    if ($p_mode == 0) {
        goto anVVJ;
    }
    goto jowNQ;
    pt3eJ:
    $v_read_size = $p_size < PCLZIP_READ_BLOCK_SIZE ? $p_size : PCLZIP_READ_BLOCK_SIZE;
    goto S5YAe;
    gOk0u:
    goto bKEYT;
    goto yVL6z;
    aFM0Z:
    QmNpN:
    goto nI0Bg;
    hPGSL:
    $p_size -= $v_read_size;
    goto HBt3Y;
    eeugX:
    $v_buffer = @fread($p_src, $v_read_size);
    goto juRNL;
    bSndV:
    goto fHvtO;
    goto QchnI;
    PfB3p:
    goto fHvtO;
    goto ikfaf;
    HBt3Y:
    goto OEyNC;
    goto gYAyG;
    pnYQt:
    fcDjL:
    goto bSndV;
    wqB35:
    $v_buffer = @gzread($p_src, $v_read_size);
    goto dF5fM;
    nI0Bg:
    ECnON:
    goto H2T1I;
    v7hpS:
    anVVJ:
    goto VPsKH;
    gYAyG:
    KN_JU:
    goto Gjrs5;
    dF5fM:
    @fwrite($p_dest, $v_buffer, $v_read_size);
    goto gvUp4;
    ikfaf:
    F2g4G:
    goto isEi6;
    TOQpP:
    $v_read_size = $p_size < PCLZIP_READ_BLOCK_SIZE ? $p_size : PCLZIP_READ_BLOCK_SIZE;
    goto Ofb9v;
    b0yA3:
    $p_size -= $v_read_size;
    goto gOk0u;
    Ofb9v:
    $v_buffer = @gzread($p_src, $v_read_size);
    goto B_hxG;
    QchnI:
    st3TD:
    goto KXPpr;
    gvUp4:
    $p_size -= $v_read_size;
    goto Qq1oQ;
    OqQcg:
    $p_size -= $v_read_size;
    goto xni5q;
    jowNQ:
    if ($p_mode == 1) {
        goto QmNpN;
    }
    goto esman;
    Qq1oQ:
    goto ECnON;
    goto pnYQt;
    ne1pd:
    goto fHvtO;
    goto aFM0Z;
    yVL6z:
    re_ZZ:
    goto ne1pd;
    juRNL:
    @gzwrite($p_dest, $v_buffer, $v_read_size);
    goto OqQcg;
    VPsKH:
    bKEYT:
    goto Nnf8k;
    daYmP:
    if ($p_mode == 3) {
        goto F2g4G;
    }
    goto l2gvc;
    FTL3R:
    $v_result = 1;
    goto NQ5VJ;
    pZ_fd:
}
goto i2Ent;
d4KzF:
function PclZipUtilPathInclusion($p_dir, $p_path)
{
    goto VTxOa;
    PCEaG:
    goto oJs6U;
    goto aHek4;
    BdzU7:
    $v_list_dir = explode("\57", $p_dir);
    goto UmmhM;
    DcANg:
    dSbWG:
    goto YSwtS;
    e8R2D:
    $i = 0;
    goto LtR_u;
    dLfSN:
    FO1tW:
    goto mRJ_u;
    pYMBL:
    $j++;
    goto PCEaG;
    LtR_u:
    $j = 0;
    goto mFWMa;
    OwZwC:
    g87n0:
    goto BdzU7;
    IzcEt:
    if (!($p_path == "\x2e" || strlen($p_path) >= 2 && substr($p_path, 0, 2) == "\56\x2f")) {
        goto g87n0;
    }
    goto yPZjC;
    pXOGE:
    if (!($i < $v_list_dir_size && $v_list_dir[$i] == '')) {
        goto FO1tW;
    }
    goto phgVC;
    FYxyk:
    $i++;
    goto kHWMD;
    phgVC:
    $i++;
    goto gaIQ8;
    aHek4:
    LVtz1:
    goto sEs1F;
    KNNv6:
    eEsHI:
    goto vhCQ8;
    fOnJ6:
    $i++;
    goto tE3xb;
    Te896:
    G6BVC:
    goto IzcEt;
    UmmhM:
    $v_list_dir_size = sizeof($v_list_dir);
    goto q0Duc;
    eH4l6:
    if (!($i < $v_list_dir_size && $j < $v_list_path_size && $v_result)) {
        goto LfULN;
    }
    goto pKfJz;
    YSwtS:
    I1SOR:
    goto uTK_T;
    kHWMD:
    $j++;
    goto RkDeF;
    yPZjC:
    $p_path = PclZipUtilTranslateWinPath(getcwd(), false) . "\x2f" . substr($p_path, 1);
    goto OwZwC;
    VTxOa:
    $v_result = 1;
    goto zP1pC;
    Ri_JK:
    goto dSbWG;
    goto z5hzU;
    gaIQ8:
    goto Gor2I;
    goto dLfSN;
    pi042:
    oJs6U:
    goto S3RlY;
    uOOyd:
    goto dSbWG;
    goto BPJMH;
    e3NcR:
    if ($i < $v_list_dir_size) {
        goto DJlp1;
    }
    goto Ri_JK;
    z5hzU:
    xIvpe:
    goto dZOQF;
    L7tTZ:
    sqTCl:
    goto tLNOk;
    tLNOk:
    if (!($v_list_path[$j] == '')) {
        goto eEsHI;
    }
    goto VxJvE;
    q0Duc:
    $v_list_path = explode("\x2f", $p_path);
    goto vzY2Y;
    uTK_T:
    return $v_result;
    goto Ccw2o;
    mRJ_u:
    if ($i >= $v_list_dir_size && $j >= $v_list_path_size) {
        goto xIvpe;
    }
    goto e3NcR;
    zP1pC:
    if (!($p_dir == "\56" || strlen($p_dir) >= 2 && substr($p_dir, 0, 2) == "\x2e\x2f")) {
        goto G6BVC;
    }
    goto liGIN;
    Pgsq7:
    LfULN:
    goto i_CmT;
    dZOQF:
    $v_result = 2;
    goto uOOyd;
    i_CmT:
    if (!$v_result) {
        goto I1SOR;
    }
    goto pi042;
    liGIN:
    $p_dir = PclZipUtilTranslateWinPath(getcwd(), false) . "\57" . substr($p_dir, 1);
    goto Te896;
    mFWMa:
    zRWMv:
    goto eH4l6;
    pKfJz:
    if (!($v_list_dir[$i] == '')) {
        goto sqTCl;
    }
    goto fOnJ6;
    vhCQ8:
    if (!($v_list_dir[$i] != $v_list_path[$j] && $v_list_dir[$i] != '' && $v_list_path[$j] != '')) {
        goto X9aOf;
    }
    goto z_q2y;
    tE3xb:
    goto zRWMv;
    goto L7tTZ;
    VxJvE:
    $j++;
    goto mWBRd;
    mWBRd:
    goto zRWMv;
    goto KNNv6;
    htO9i:
    X9aOf:
    goto FYxyk;
    sEs1F:
    Gor2I:
    goto pXOGE;
    vzY2Y:
    $v_list_path_size = sizeof($v_list_path);
    goto e8R2D;
    BPJMH:
    DJlp1:
    goto Dgc2e;
    z_q2y:
    $v_result = 0;
    goto htO9i;
    Dgc2e:
    $v_result = 0;
    goto DcANg;
    RkDeF:
    goto zRWMv;
    goto Pgsq7;
    S3RlY:
    if (!($j < $v_list_path_size && $v_list_path[$j] == '')) {
        goto LVtz1;
    }
    goto pYMBL;
    Ccw2o:
}
goto wuLjm;
o2f2p:
define("\120\x43\114\132\x49\x50\137\105\122\x52\137\x49\x4e\x56\x41\114\x49\x44\137\132\111\120", -6);
goto ZZX0P;
j4euu:
define("\x50\x43\x4c\132\111\x50\137\x4f\120\124\x5f\x53\105\124\137\103\110\115\117\x44", 77005);
goto yCoF3;
PlY2m:
define("\120\103\114\132\111\x50\x5f\117\x50\124\x5f\101\x44\x44\x5f\x50\x41\x54\110", 77002);
goto m6dus;
YygIB:
define("\120\x43\114\x5a\111\x50\137\103\102\x5f\x50\x4f\123\x54\137\x45\130\124\x52\x41\x43\x54", 78002);
goto WfIHk;
NMFz2:
define("\x50\x43\x4c\x5a\111\x50\x5f\x53\105\x50\x41\x52\101\x54\x4f\122", "\54");
goto LVv4C;
aMXVo:
define("\x50\x43\x4c\x5a\x49\120\137\101\124\124\x5f\x46\x49\114\x45\x5f\x4e\x41\x4d\x45", 79001);
goto RC0EG;
S9Mlk:
define("\x50\103\114\132\x49\120\137\105\x52\122\x5f\116\x4f\x5f\105\122\x52\x4f\x52", 0);
goto Jf8JV;
dHU7B:
if (defined("\120\x43\114\132\x49\x50\137\x54\105\115\120\117\122\x41\x52\131\137\x46\111\114\105\137\122\x41\x54\x49\x4f")) {
    goto Fje3l;
}
goto SF2pT;
nvElR:
define("\x50\x43\114\x5a\x49\x50\x5f\105\x52\122\x5f\x55\x4e\x53\125\x50\x50\117\x52\124\x45\104\137\103\x4f\115\120\122\x45\x53\123\111\117\x4e", -18);
goto eeFDc;
rI3dg:
define("\x50\103\x4c\132\x49\120\137\105\122\122\137\x52\105\116\x41\x4d\x45\137\x46\x49\x4c\105\137\x46\x41\x49\x4c", -12);
goto oyxZp;
BMlsb:
define("\120\103\114\x5a\111\x50\137\x45\122\x52\137\111\x4e\x56\x41\x4c\111\104\x5f\101\124\x54\x52\111\102\125\x54\x45\137\126\x41\114\x55\105", -20);
goto aXT12;
HlHlO:
define("\x50\103\x4c\x5a\x49\120\x5f\117\120\124\137\x54\x45\115\120\x5f\106\x49\x4c\x45\x5f\x4f\106\x46", 77022);
goto iS2u0;
JAgkt:
define("\120\x43\114\x5a\111\120\x5f\x45\x52\x52\137\x42\101\x44\137\106\117\122\x4d\x41\124", -10);
goto kjlM9;
PsQUr:
define("\x50\103\x4c\x5a\111\x50\137\x45\x52\x52\x5f\115\111\123\123\111\x4e\107\137\x4f\120\124\111\x4f\x4e\x5f\126\101\x4c\125\105", -15);
goto h9p4h;
sfZKO:
define("\120\103\114\x5a\x49\120\137\x4f\x50\124\x5f\101\x44\104\x5f\124\105\115\x50\x5f\x46\x49\x4c\105\137\124\110\122\x45\123\110\x4f\x4c\x44", 77020);
goto vxW4i;
bVBUT:
define("\x50\x43\x4c\132\x49\x50\x5f\105\x52\x52\137\115\111\123\x53\x49\x4e\x47\x5f\106\x49\114\x45", -4);
goto EwYoC;
MHfj0:
Fje3l:
goto p9lda;
qfFlc:
OWEbd:
goto jIc0I;
EwYoC:
define("\x50\103\x4c\132\111\120\137\x45\x52\x52\x5f\106\x49\x4c\x45\116\101\115\x45\x5f\x54\x4f\x4f\x5f\x4c\x4f\116\x47", -5);
goto o2f2p;
QDn3L:
define("\120\103\x4c\x5a\x49\120\137\117\x50\124\x5f\123\x54\117\120\137\117\x4e\137\x45\122\122\117\122", 77017);
goto IspMU;
RC0EG:
define("\120\x43\114\132\111\120\x5f\x41\124\124\137\106\111\x4c\105\137\116\105\x57\137\x53\110\x4f\x52\x54\x5f\x4e\x41\115\x45", 79002);
goto HNeVq;
ZZX0P:
define("\120\x43\114\x5a\111\x50\x5f\x45\x52\x52\137\x42\x41\104\137\105\x58\x54\x52\101\x43\x54\105\x44\x5f\x46\x49\114\x45", -7);
goto JqdQc;
Q9peg:
define("\x50\103\114\x5a\x49\120\137\117\x50\x54\x5f\120\122\105\120\x45\116\104\x5f\103\x4f\x4d\115\x45\116\x54", 77014);
goto mz_fL;
uNcCJ:
define("\x50\103\114\132\x49\120\x5f\x4f\x50\x54\137\x43\x4f\x4d\x4d\105\116\124", 77012);
goto XhOzF;
pv8kQ:
Fzhm5:
goto R7fu3;
gUr9E:
define("\120\x43\114\x5a\111\120\137\103\102\137\120\x52\105\x5f\105\130\x54\x52\101\x43\124", 78001);
goto YygIB;
WfIHk:
define("\120\103\114\132\111\120\x5f\x43\102\137\x50\x52\x45\x5f\101\x44\x44", 78003);
goto rh2iS;
WOOK1:
define("\120\x43\x4c\x5a\111\120\137\101\x54\124\137\106\111\114\x45\137\115\x54\x49\115\105", 79004);
goto tblHq;
HNeVq:
define("\x50\x43\114\x5a\111\x50\137\101\124\x54\137\106\111\114\105\137\x4e\x45\127\x5f\106\125\x4c\114\x5f\x4e\101\115\x45", 79003);
goto WOOK1;
R7fu3:
if (defined("\x50\x43\x4c\132\x49\x50\137\123\x45\120\x41\x52\x41\x54\117\x52")) {
    goto xh5Oe;
}
goto NMFz2;
cwNrB:
define("\x50\x43\x4c\132\x49\120\137\x4f\120\124\137\x52\105\120\x4c\x41\x43\x45\137\x4e\105\127\x45\x52", 77016);
goto QDn3L;
gMxmt:
define("\x50\103\114\132\111\x50\137\105\122\x52\137\101\x4c\x52\105\x41\104\x59\x5f\x41\137\x44\x49\x52\105\103\x54\117\x52\x59", -17);
goto nvElR;
yCoF3:
define("\x50\103\x4c\132\x49\x50\137\x4f\x50\x54\137\105\x58\x54\122\101\x43\x54\x5f\x41\x53\x5f\123\124\x52\x49\x4e\107", 77006);
goto ylShh;
mnZyl:
if (defined("\x50\x43\x4c\x5a\111\x50\137\x52\105\x41\104\137\x42\x4c\117\103\x4b\x5f\123\111\132\105")) {
    goto Fzhm5;
}
goto AO5Gh;
lyVIb:
define("\120\x43\114\x5a\x49\x50\137\x4f\x50\x54\137\102\x59\137\x49\x4e\104\x45\x58", 77009);
goto Mf6al;
mz_fL:
define("\x50\x43\x4c\x5a\x49\120\x5f\x4f\120\x54\137\105\130\124\122\x41\103\124\x5f\x49\116\x5f\117\125\124\x50\x55\124", 77015);
goto cwNrB;
tblHq:
define("\120\x43\x4c\x5a\111\x50\x5f\101\124\124\x5f\106\111\x4c\x45\x5f\103\x4f\x4e\x54\105\x4e\x54", 79005);
goto ZssxZ;
XhOzF:
define("\120\103\114\x5a\x49\120\x5f\x4f\120\x54\x5f\101\104\x44\137\103\117\115\115\x45\x4e\x54", 77013);
goto Q9peg;
oyxZp:
define("\x50\103\x4c\x5a\x49\x50\137\x45\122\x52\137\102\101\x44\137\x43\110\x45\103\x4b\123\125\x4d", -13);
goto itVtB;
zpQqe:
define("\120\103\x4c\x5a\111\120\x5f\x4f\x50\x54\x5f\x54\x45\x4d\120\x5f\x46\x49\114\105\137\x54\x48\122\x45\123\110\117\114\104", 77020);
goto sfZKO;
k1_l7:
if (defined("\x50\103\114\x5a\111\120\137\105\x52\122\117\x52\137\x45\x58\x54\x45\122\116\x41\114")) {
    goto OWEbd;
}
goto CiHdL;
SF2pT:
define("\x50\x43\114\x5a\x49\x50\x5f\x54\105\115\x50\x4f\x52\101\122\x59\137\106\x49\x4c\105\137\x52\x41\124\111\x4f", 0.47);
goto MHfj0;
vEoaX:
define("\x50\103\114\132\x49\120\x5f\x4f\x50\x54\x5f\120\101\124\110", 77001);
goto PlY2m;
y7OQp:
Hyyct:
goto dHU7B;
itVtB:
define("\120\x43\114\x5a\x49\120\x5f\x45\x52\122\x5f\111\116\126\x41\x4c\x49\x44\x5f\x41\122\x43\x48\x49\126\105\137\132\111\x50", -14);
goto PsQUr;
ZzdyY:
define("\120\x43\114\x5a\111\120\x5f\105\x52\x52\137\102\101\104\x5f\x45\x58\x54\x45\x4e\123\111\x4f\116", -9);
goto JAgkt;
AO5Gh:
define("\120\103\114\x5a\x49\120\137\x52\x45\101\104\137\x42\x4c\117\103\x4b\137\123\x49\132\105", 2048);
goto pv8kQ;
FlxAH:
define("\120\x43\x4c\132\x49\x50\137\x45\122\122\x5f\111\116\x56\x41\x4c\111\104\x5f\x50\101\x52\x41\115\x45\x54\x45\x52", -3);
goto bVBUT;
c10mP:
function PclZipUtilTranslateWinPath($p_path, $p_remove_disk_letter = true)
{
    goto Vqryh;
    WyOTC:
    yyMbO:
    goto aP9V0;
    cr82j:
    lNpz0:
    goto UoxeS;
    Z31I7:
    $p_path = substr($p_path, $v_position + 1);
    goto WyOTC;
    aP9V0:
    if (!(strpos($p_path, "\134") > 0 || substr($p_path, 0, 1) == "\134")) {
        goto ltQvm;
    }
    goto Kub0D;
    Kub0D:
    $p_path = strtr($p_path, "\x5c", "\57");
    goto afNHD;
    UoxeS:
    return $p_path;
    goto mKINS;
    afNHD:
    ltQvm:
    goto cr82j;
    Vqryh:
    if (!stristr(php_uname(), "\x77\x69\x6e\144\x6f\167\x73")) {
        goto lNpz0;
    }
    goto pdTe9;
    pdTe9:
    if (!($p_remove_disk_letter && ($v_position = strpos($p_path, "\x3a")) != false)) {
        goto yyMbO;
    }
    goto Z31I7;
    mKINS:
}
