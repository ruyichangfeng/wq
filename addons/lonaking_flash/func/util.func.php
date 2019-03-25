<?php
/*
 __________________________________________________
|  Encode by BajieTeam on we7                      |
|__________________________________________________|
*/

goto BHjqj;
m9yAP:
function distance_text($list, $name = "\144\151\163\x74\x61\156\143\x65", $time = false)
{
    goto wmvlF;
    wmvlF:
    $v_bu = 100;
    goto uKiYb;
    uxqzv:
    $result = array();
    goto Ql1Jd;
    D5W_Y:
    wlRIU:
    goto exNz2;
    S2Uqv:
    if (!is_array($name)) {
        goto ScTp0;
    }
    goto mke5B;
    exNz2:
    kRpIV:
    goto S2Uqv;
    rInVD:
    ScTp0:
    goto Wi72q;
    Wi72q:
    return $result;
    goto exmIX;
    mke5B:
    foreach ($list as $data) {
        goto fbc1X;
        nzkSZ:
        $result[] = $data;
        goto UgB9J;
        ztsLV:
        T1hWh:
        goto nzkSZ;
        UgB9J:
        sHSAj:
        goto O529D;
        fbc1X:
        foreach ($name as $n) {
            goto LKr6b;
            CqvO1:
            if ($data[$n] >= 1500) {
                goto y62pE;
            }
            goto kFHOH;
            A2yM9:
            $time_text = '';
            goto CqvO1;
            kIBX3:
            if (!$time) {
                goto FT4wh;
            }
            goto A2yM9;
            I5GVC:
            $data["\x64\x69\163\164\x61\156\x63\145\137\164\x65\170\164"] = $text;
            goto oskOe;
            SKAqm:
            fvM0w:
            goto oqC9M;
            Lc3nm:
            $tmp = $data[$n] / 2;
            goto cLPVO;
            pi5RU:
            MZl7j:
            goto xsq7j;
            Uc4Mq:
            $text = round($data[$n] / 1000, 2) . "\xe5\x8d\x83\xe7\261\263";
            goto Fzmyk;
            H5Bja:
            if (intval($data[$n]) >= 1000) {
                goto I8hEk;
            }
            goto jMQHf;
            SspjD:
            NYYtl:
            goto dDCRT;
            u66pI:
            goto ILhZG;
            goto SspjD;
            mefFB:
            FT4wh:
            goto I5GVC;
            G_Ct_:
            goto MZl7j;
            goto SKAqm;
            k3TEe:
            $data["\164\151\x6d\x65\x5f\164\x65\170\x74"] = $time_text;
            goto mefFB;
            kFHOH:
            $tmp = $data[$n] / 9;
            goto R9JAB;
            Fzmyk:
            avlKF:
            goto kIBX3;
            lrqy1:
            I8hEk:
            goto Uc4Mq;
            LKr6b:
            $text = '';
            goto H5Bja;
            oqC9M:
            $time_text = intval($tmp) . "\345\210\206";
            goto pi5RU;
            sR5s9:
            $time_text = round($tmp / 60, 1) . "\xe5\260\217\346\227\266";
            goto G_Ct_;
            oskOe:
            ITKID:
            goto jeygP;
            jMQHf:
            $text = intval($data[$n]) . "\xe7\261\xb3";
            goto RL8ak;
            RL8ak:
            goto avlKF;
            goto lrqy1;
            dDCRT:
            $time_text = intval($tmp) . "\345\x88\206";
            goto IEfW7;
            R9JAB:
            if ($tmp < 60) {
                goto fvM0w;
            }
            goto sR5s9;
            IEfW7:
            ILhZG:
            goto Hki9R;
            xsq7j:
            goto kObGP;
            goto Nvm5F;
            cLPVO:
            if ($tmp < 60) {
                goto NYYtl;
            }
            goto DlaK2;
            DlaK2:
            $time_text = round($tmp / 60, 1) . "\xe5\260\x8f\346\227\266";
            goto u66pI;
            Nvm5F:
            y62pE:
            goto Lc3nm;
            Hki9R:
            kObGP:
            goto k3TEe;
            jeygP:
        }
        goto ztsLV;
        O529D:
    }
    goto kVHjo;
    liNqH:
    foreach ($list as $data) {
        goto sDIx7;
        mVLZ2:
        if (!($time == true)) {
            goto Fbwdt;
        }
        goto kCmQd;
        wovW_:
        t5HPL:
        goto LWQub;
        rjRl7:
        Fbwdt:
        goto wuDaT;
        Tyi8e:
        $data["\x64\x69\163\x74\141\156\x63\145\x5f\164\145\170\x74"] = $text;
        goto mVLZ2;
        kCpod:
        $result[] = $data;
        goto Be095;
        n8W6e:
        if ($tmp < 60) {
            goto ficvP;
        }
        goto selS7;
        DpVcM:
        MeZyV:
        goto ykM2E;
        uBOr9:
        $tmp = $distance / $v_bu;
        goto c65ur;
        y342q:
        $desc = '';
        goto ZzV6j;
        nFge3:
        $desc = "\344\271\x98\350\xbd\246";
        goto QdiR6;
        wuDaT:
        $data["\x64\151\163\164\141\156\143\145\137\x64\x65\x73\x63"] = $desc;
        goto kCpod;
        mJdj8:
        goto z3z0Z;
        goto wovW_;
        kQH9I:
        if ($distance <= 2000) {
            goto t5HPL;
        }
        goto nFge3;
        f__jO:
        $text = intval($data[$name]) . "\xe7\xb1\263";
        goto NJBM_;
        jddWm:
        $data["\164\x69\155\x65\137\x74\145\x78\164"] = $time_text;
        goto rjRl7;
        Be095:
        tRKst:
        goto unx18;
        N1MmD:
        goto rNVqP;
        goto jQUpj;
        pj9Q_:
        rNVqP:
        goto mJdj8;
        LWQub:
        $desc = "\346\xad\245\xe8\xa1\214";
        goto uBOr9;
        jQUpj:
        ficvP:
        goto agqXI;
        ykM2E:
        $text = round($data[$name] / 1000, 2) . "\345\x8d\x83\xe7\261\263";
        goto eJgDQ;
        NJBM_:
        goto J2UT_;
        goto DpVcM;
        kCmQd:
        $time_text = '';
        goto kQH9I;
        ZzV6j:
        $distance = intval($data[$name]);
        goto Z4ctI;
        c65ur:
        $time_text = intval($tmp) + 1 . "\xe5\x88\x86";
        goto tHkvC;
        tHkvC:
        z3z0Z:
        goto jddWm;
        selS7:
        $time_text = round($tmp / 60, 1) . "\345\xb0\217\xe6\227\266";
        goto N1MmD;
        eJgDQ:
        J2UT_:
        goto Tyi8e;
        agqXI:
        $time_text = intval($tmp) + 1 . "\xe5\x88\206";
        goto pj9Q_;
        QdiR6:
        $tmp = floatval($distance / $v_drive);
        goto n8W6e;
        Z4ctI:
        if ($distance >= 1000) {
            goto MeZyV;
        }
        goto f__jO;
        sDIx7:
        $text = '';
        goto y342q;
        unx18:
    }
    goto D5W_Y;
    Ql1Jd:
    if (!is_string($name)) {
        goto kRpIV;
    }
    goto liNqH;
    kVHjo:
    nyKep:
    goto rInVD;
    uKiYb:
    $v_drive = 1000;
    goto uxqzv;
    exmIX:
}
goto vvNJJ;
LIoOP:
function looptomedia($list, $name = null)
{
    goto R4xlu;
    pvBrJ:
    if (!(is_null($name) && is_array($list))) {
        goto soHfw;
    }
    goto pXg0j;
    Q80TK:
    soHfw:
    goto OnbPY;
    xTieB:
    foreach ($list as $data) {
        goto fcMKo;
        ZeJiq:
        hp5Tx:
        goto hUhZL;
        tg4Pf:
        vPo_Y:
        goto RTmBy;
        RTmBy:
        $result[] = $data;
        goto ZeJiq;
        fcMKo:
        foreach ($name as $n) {
            $data[$n] = tomedia($data[$n]);
            qhtmO:
        }
        goto tg4Pf;
        hUhZL:
    }
    goto wkta7;
    ZmZE4:
    rhUMX:
    goto oc53g;
    R4xlu:
    $result = array();
    goto wdOGH;
    OnbPY:
    return $result;
    goto yPnpa;
    wkta7:
    vegzW:
    goto oN3Bo;
    oN3Bo:
    DIPAG:
    goto pvBrJ;
    c8au3:
    foreach ($list as $data) {
        goto KSVDh;
        iU1FB:
        $result[] = $data;
        goto ndyX6;
        ndyX6:
        eSwcm:
        goto U1M2b;
        KSVDh:
        $data[$name] = tomedia($data[$name]);
        goto iU1FB;
        U1M2b:
    }
    goto Itilt;
    VRN2A:
    return array();
    goto iqAh4;
    J8XXF:
    if (!(is_string($name) && is_array($list))) {
        goto rhUMX;
    }
    goto c8au3;
    iqAh4:
    P54nz:
    goto J8XXF;
    oc53g:
    if (!(is_array($name) && is_array($list))) {
        goto DIPAG;
    }
    goto xTieB;
    pXg0j:
    foreach ($list as $data) {
        $result[] = tomedia($data);
        IWDKV:
    }
    goto cnagx;
    wdOGH:
    if (!empty($list)) {
        goto P54nz;
    }
    goto VRN2A;
    cnagx:
    ANTVo:
    goto Q80TK;
    Itilt:
    TEJIZ:
    goto ZmZE4;
    yPnpa:
}
goto CAZIK;
j5uEA:
function array2maps($arr, $key = "\x69\x64")
{
    goto wiDvc;
    DlsF3:
    ak6zw:
    goto GJU3E;
    hbtCw:
    foreach ($arr as $data) {
        $result[$data[$key]][] = $data;
        ZPbGQ:
    }
    goto DlsF3;
    wiDvc:
    $result = array();
    goto hbtCw;
    GJU3E:
    return $result;
    goto L72FM;
    L72FM:
}
goto oBOPm;
BHjqj:
/**
 * 公用的方法
 */
function array2columnarray($arr, $columns_name, $kill_null = false, $kill_repeat = false)
{
    goto SUHtd;
    yKHO6:
    nlhXc:
    goto iGEWR;
    FxfGj:
    return $result;
    goto mEnuk;
    wx9V2:
    foreach ($result as $item) {
        goto PTb3Q;
        RgkyY:
        $newResult[] = $item;
        goto I07Zo;
        ZBqml:
        i2R1r:
        goto FZd2R;
        I07Zo:
        eRTJI:
        goto ZBqml;
        PTb3Q:
        if (in_array($item, $newResult)) {
            goto eRTJI;
        }
        goto RgkyY;
        FZd2R:
    }
    goto u6fxC;
    Dxz3p:
    $newResult = array();
    goto wx9V2;
    BkZ3O:
    foreach ($arr as $a) {
        goto cGDOR;
        oS2pj:
        EoYuv:
        goto FlKFt;
        kHSRv:
        $result[] = $a[$columns_name];
        goto FSERR;
        X3V3A:
        if (!($kill_null && $isNull == false || !$kill_null)) {
            goto znIqA;
        }
        goto kHSRv;
        cGDOR:
        $isNull = empty($a[$columns_name]) || is_null($a[$columns_name]);
        goto X3V3A;
        FSERR:
        znIqA:
        goto oS2pj;
        FlKFt:
    }
    goto yKHO6;
    iGEWR:
    if (!$kill_repeat) {
        goto dasTt;
    }
    goto Dxz3p;
    u6fxC:
    oA0ZH:
    goto afc1i;
    afc1i:
    $result = $newResult;
    goto peQTq;
    peQTq:
    dasTt:
    goto FxfGj;
    SUHtd:
    $result = array();
    goto BkZ3O;
    mEnuk:
}
goto j5uEA;
CAZIK:
function del_file_or_dir($dirName)
{
    goto vxiED;
    tD1Oa:
    if (is_dir("{$dirName}\x2f{$item}")) {
        goto NbkxT;
    }
    goto yrRKZ;
    yrRKZ:
    if (!unlink("{$dirName}\x2f{$item}")) {
        goto lNOXb;
    }
    goto uuljF;
    XJtmJ:
    return true;
    goto mPKKI;
    LTb90:
    if (rmdir($dirName)) {
        goto LawuB;
    }
    goto FCVsp;
    HHitk:
    if (!($item != "\56" && $item != "\x2e\x2e")) {
        goto RjdDB;
    }
    goto tD1Oa;
    C0lL0:
    if (!(false !== ($item = readdir($handle)))) {
        goto H_Uag;
    }
    goto HHitk;
    Heg5T:
    LawuB:
    goto XJtmJ;
    FCVsp:
    return false;
    goto k3U1v;
    vxiED:
    if (!($handle = opendir($dirName))) {
        goto xfBLj;
    }
    goto iByR9;
    RprSq:
    goto hXall;
    goto uBGF1;
    CqJoM:
    RjdDB:
    goto Lx8AO;
    rY6Jo:
    delDirAndFile("{$dirName}\x2f{$item}");
    goto fKtJI;
    J3uBY:
    closedir($handle);
    goto LTb90;
    Lx8AO:
    goto F0eHM;
    goto p7uXM;
    mPKKI:
    lvZMu:
    goto tdokE;
    p7uXM:
    H_Uag:
    goto J3uBY;
    tdokE:
    xfBLj:
    goto jTBP1;
    iByR9:
    F0eHM:
    goto C0lL0;
    uBGF1:
    NbkxT:
    goto rY6Jo;
    k3U1v:
    goto lvZMu;
    goto Heg5T;
    fKtJI:
    hXall:
    goto CqJoM;
    uuljF:
    echo "\xe6\x88\220\xe5\212\x9f\xe5\210\xa0\xe9\x99\xa4\xe6\x96\207\xe4\xbb\266\xef\274\x9a\x20{$dirName}\x2f{$item}\x3c\x62\162\x20\57\x3e\156";
    goto yNXip;
    yNXip:
    lNOXb:
    goto RprSq;
    jTBP1:
}
goto yTFJq;
c6hJ6:
function distance($lat1, $lng1, $lat2, $lng2)
{
    goto S8Kyo;
    EFX1A:
    $calcLatitude = $lat2 - $lat1;
    goto skAFK;
    S3Mei:
    $lng1 = $lng1 * pi() / 180;
    goto IPsi6;
    MaRe0:
    $lng2 = $lng2 * pi() / 180;
    goto pxIZp;
    doK0T:
    $lat1 = $lat1 * pi() / 180;
    goto S3Mei;
    skAFK:
    $stepOne = pow(sin($calcLatitude / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($calcLongitude / 2), 2);
    goto fTaLR;
    Nisoq:
    return round($calculatedDistance);
    goto gjkmR;
    S8Kyo:
    $earthRadius = 6367000;
    goto doK0T;
    dgFgN:
    $calculatedDistance = $earthRadius * $stepTwo;
    goto Nisoq;
    fTaLR:
    $stepTwo = 2 * asin(min(1, sqrt($stepOne)));
    goto dgFgN;
    IPsi6:
    $lat2 = $lat2 * pi() / 180;
    goto MaRe0;
    pxIZp:
    $calcLongitude = $lng2 - $lng1;
    goto EFX1A;
    gjkmR:
}
goto clfBn;
oBOPm:
function array2map($arr, $key = "\151\144")
{
    goto LAKo0;
    t6Loy:
    foreach ($arr as $data) {
        $result[$data[$key]] = $data;
        VeDR3:
    }
    goto Ipwt3;
    LAKo0:
    $result = array();
    goto t6Loy;
    sNOra:
    return $result;
    goto jduLe;
    Ipwt3:
    Tfdrf:
    goto sNOra;
    jduLe:
}
goto m9yAP;
vvNJJ:
function uuid()
{
    goto QQfms;
    PPVhh:
    $charid = strtoupper(md5(uniqid(rand(), true)));
    goto Awi6O;
    CT6QX:
    y23bK:
    goto WdD2Z;
    JJ9oT:
    $uuid = '' . substr($charid, 0, 8) . $hyphen . substr($charid, 8, 4) . $hyphen . substr($charid, 12, 4) . $hyphen . substr($charid, 16, 4) . $hyphen . substr($charid, 20, 12);
    goto bFYRz;
    bFYRz:
    return $uuid;
    goto AsWGl;
    y0o6s:
    KYodW:
    goto xPsfx;
    AsWGl:
    goto KYodW;
    goto CT6QX;
    QQfms:
    if (function_exists("\143\x6f\155\137\143\x72\x65\141\164\x65\x5f\147\x75\x69\144")) {
        goto y23bK;
    }
    goto bRu5_;
    bRu5_:
    mt_srand((double) microtime() * 10000);
    goto PPVhh;
    WdD2Z:
    return com_create_guid();
    goto y0o6s;
    Awi6O:
    $hyphen = chr(45);
    goto JJ9oT;
    xPsfx:
}
goto c6hJ6;
clfBn:
function get_param_from_url($url, $param)
{
    goto nLYgm;
    nLYgm:
    $data = array();
    goto Nkz90;
    exEpF:
    foreach ($parameter as $val) {
        goto XnSYH;
        zgRCS:
        OzL4G:
        goto rvAkc;
        oskN6:
        $data[$tmp[0]] = $tmp[1];
        goto zgRCS;
        XnSYH:
        $tmp = explode("\75", $val);
        goto oskN6;
        rvAkc:
    }
    goto pYimw;
    Nkz90:
    $parameter = explode("\46", end(explode("\77", $url)));
    goto exEpF;
    ijXeI:
    return $data[$param];
    goto Hn8AU;
    pYimw:
    p7NyB:
    goto ijXeI;
    Hn8AU:
}
goto LIoOP;
yTFJq:
function is_write_able($file)
{
    goto fDikT;
    JaHkA:
    lDB_A:
    goto s5Ej2;
    mzvdl:
    $writeable = 1;
    goto i82y6;
    u13PX:
    b7Zr6:
    goto kL0f2;
    i82y6:
    Uy126:
    goto vPBuH;
    Qcsx_:
    n69gf:
    goto u13PX;
    s5Ej2:
    $dir = $file;
    goto LU9Ma;
    LU9Ma:
    $num = rand(10000, 99999);
    goto Y33zy;
    hF8vB:
    @unlink("{$dir}\x2f\x74\x65\163\164\x2d{$num}\x2e\164\x78\164");
    goto YogfT;
    kL0f2:
    return $writeable;
    goto BFHdP;
    TlEkl:
    goto n69gf;
    goto dY7IO;
    n9z_V:
    $writeable = 0;
    goto TlEkl;
    yibHj:
    @fclose($fp);
    goto hF8vB;
    dY7IO:
    mBw_v:
    goto yibHj;
    oTnC8:
    $writeable = 0;
    goto WYerG;
    myYMm:
    if ($fp = @fopen($file, "\x61\x2b")) {
        goto CmxbB;
    }
    goto oTnC8;
    Y33zy:
    if ($fp = @fopen("{$dir}\57\x74\145\x73\x74\x2d{$num}\56\x74\170\x74", "\x77")) {
        goto mBw_v;
    }
    goto n9z_V;
    BFddL:
    @fclose($fp);
    goto mzvdl;
    vPBuH:
    goto b7Zr6;
    goto JaHkA;
    fDikT:
    if (is_dir($file)) {
        goto lDB_A;
    }
    goto myYMm;
    OGMTI:
    CmxbB:
    goto BFddL;
    WYerG:
    goto Uy126;
    goto OGMTI;
    YogfT:
    $writeable = 1;
    goto Qcsx_;
    BFHdP:
}
