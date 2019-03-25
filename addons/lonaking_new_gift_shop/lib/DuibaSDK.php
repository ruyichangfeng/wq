<?php
/*
 __________________________________________________
|  Encode by BajieTeam on we7                      |
|__________________________________________________|
*/

goto MxRog;
LJoRg:
function buildCreditOrderStatusRequest($appKey, $appSecret, $orderNum, $bizId)
{
    goto Ty0Sq;
    UhrOr:
    return $url;
    goto iqDm6;
    ARWb9:
    $timestamp = time() * 1000 . '';
    goto Rso6b;
    TVZpC:
    $sign = sign($array);
    goto X0zb_;
    X0zb_:
    $url = $url . "\x6f\162\x64\x65\162\x4e\x75\x6d\x3d" . $orderNum . "\46\142\151\x7a\111\144\75" . $bizId . "\x26\141\160\x70\x4b\145\x79\x3d" . $appKey . "\46\x74\x69\x6d\145\x73\x74\x61\x6d\160\x3d" . $timestamp . "\46\163\151\147\156\x3d" . $sign;
    goto UhrOr;
    Rso6b:
    $array = array("\x6f\162\x64\x65\162\x4e\x75\155" => $orderNum, "\142\151\172\111\144" => $bizId, "\x61\160\x70\113\145\171" => $appKey, "\141\160\160\x53\x65\143\162\x65\x74" => $appSecret, "\x74\151\x6d\x65\163\x74\x61\x6d\160" => $timestamp);
    goto TVZpC;
    Ty0Sq:
    $url = "\150\x74\164\160\x3a\x2f\57\167\167\x77\x2e\144\165\x69\142\x61\56\x63\157\155\x2e\x63\x6e\x2f\x73\x74\x61\x74\x75\163\x2f\157\x72\144\145\x72\123\164\141\x74\165\x73\x3f";
    goto ARWb9;
    iqDm6:
}
goto QtwO5;
UPl6Y:
function parseCreditConsume($appKey, $appSecret, $request_array)
{
    goto gy5zO;
    jFbzH:
    throw new Exception("\164\151\x6d\x65\x73\164\141\155\160\40\143\141\x6e\47\164\x20\x62\145\40\x6e\x75\154\154");
    goto Jcm03;
    Jcm03:
    tTJ00:
    goto sW_IF;
    sW_IF:
    $verify = signVerify($appSecret, $request_array);
    goto iyugC;
    lnrbY:
    $ret = array("\141\160\160\x4b\x65\x79" => $request_array["\141\160\160\113\145\x79"], "\143\x72\x65\144\151\164\x73" => $request_array["\x63\x72\145\144\151\164\163"], "\164\151\155\145\x73\164\x61\x6d\160" => $request_array["\164\151\x6d\145\x73\164\141\x6d\x70"], "\x64\145\x73\143\162\151\160\x74\x69\157\156" => $request_array["\144\145\163\x63\x72\x69\160\x74\151\x6f\156"], "\157\x72\144\x65\162\x4e\x75\x6d" => $request_array["\157\x72\x64\x65\x72\116\165\155"]);
    goto kyY7s;
    I1Bsi:
    h_rQf:
    goto lnrbY;
    GnI01:
    throw new Exception("\x73\x69\x67\x6e\x20\x76\145\x72\x69\146\171\x20\x66\141\151\154");
    goto I1Bsi;
    iyugC:
    if ($verify) {
        goto h_rQf;
    }
    goto GnI01;
    tx3Pa:
    throw new Exception("\141\x70\160\113\x65\171\40\156\157\x74\40\155\x61\x74\x63\150");
    goto wVofI;
    wVofI:
    wPwt2:
    goto SxG2S;
    SxG2S:
    if (!($request_array["\164\151\155\145\x73\164\x61\x6d\160"] == null)) {
        goto tTJ00;
    }
    goto jFbzH;
    kyY7s:
    return $ret;
    goto L2cDw;
    gy5zO:
    if (!($request_array["\141\160\x70\113\145\171"] != $appKey)) {
        goto wPwt2;
    }
    goto tx3Pa;
    L2cDw:
}
goto Ux7Nx;
MxRog:
function sign($array)
{
    goto Iib6y;
    QZ18C:
    $string = $string . $val;
    goto A38e2;
    GUL19:
    return md5($string);
    goto d8dFz;
    dO8cM:
    PVt02:
    goto GUL19;
    vUkWD:
    Urirf:
    goto No0_G;
    Iib6y:
    ksort($array);
    goto ToGT1;
    A38e2:
    goto Urirf;
    goto dO8cM;
    ToGT1:
    $string = '';
    goto vUkWD;
    No0_G:
    if (!(list($key, $val) = each($array))) {
        goto PVt02;
    }
    goto QZ18C;
    d8dFz:
}
goto ZwcuA;
QtwO5:
function buildCreditAuditRequest($appKey, $appSecret, $passOrderNums, $rejectOrderNums)
{
    goto GUnpa;
    sWOe6:
    RnffJ:
    goto jkAMN;
    YndKK:
    if (!($passOrderNums != null && !empty($passOrderNums))) {
        goto nyVe0;
    }
    goto PNJ8w;
    zI0XQ:
    $string = $val;
    goto k4mfq;
    BS1pZ:
    $sign = sign($array);
    goto rkfS0;
    ASmb8:
    $string = null;
    goto C92uc;
    GkbUs:
    $string = $string . "\x2c" . $val;
    goto iutTf;
    k9byO:
    $timestamp = time() * 1000 . '';
    goto ZP9ss;
    HHh5e:
    goto ok21H;
    goto nYiE3;
    nduLF:
    if (!(list($key, $val) = each($rejectOrderNums))) {
        goto CiOBV;
    }
    goto YenNQ;
    QY71T:
    goto hexE_;
    goto DcgXr;
    DcgXr:
    M_Qz3:
    goto pJfjf;
    NTS7g:
    fQGjw:
    goto QY71T;
    qiILG:
    if (!(list($key, $val) = each($passOrderNums))) {
        goto M_Qz3;
    }
    goto SqacH;
    uBjuy:
    xcMdE:
    goto BS1pZ;
    ZhsXL:
    nyVe0:
    goto Vq6GY;
    jkAMN:
    $string = $val;
    goto NTS7g;
    nYiE3:
    CiOBV:
    goto Pie0Y;
    pJfjf:
    $array["\160\x61\163\x73\x4f\162\144\145\x72\116\165\155\x73"] = $string;
    goto ZhsXL;
    k4mfq:
    ovPIy:
    goto HHh5e;
    PNJ8w:
    $string = null;
    goto qcS6l;
    R2rF6:
    $string = $string . "\x2c" . $val;
    goto P7JzN;
    rkfS0:
    $url = $url . "\141\160\x70\x4b\145\x79\75" . $appKey . "\46\160\x61\163\163\x4f\162\x64\145\x72\x4e\x75\155\163\x3d" . $array["\x70\141\163\x73\117\x72\x64\145\162\116\x75\x6d\163"] . "\x26\x72\x65\x6a\145\143\x74\x4f\x72\144\145\x72\x4e\x75\155\163\x3d" . $array["\x72\x65\152\x65\143\x74\117\162\x64\145\x72\116\x75\155\163"] . "\46\163\151\x67\156\75" . $sign . "\46\x74\151\155\x65\163\164\x61\x6d\160\75" . $timestamp;
    goto r7J_Z;
    Vq6GY:
    if (!($rejectOrderNums != null && !empty($rejectOrderNums))) {
        goto xcMdE;
    }
    goto ASmb8;
    GUnpa:
    $url = "\150\x74\164\x70\x3a\57\57\167\x77\x77\x2e\x64\x75\151\142\x61\x2e\x63\157\155\x2e\143\x6e\57\141\x75\x64\x69\x74\57\x61\x70\x69\101\165\144\x69\x74\x3f";
    goto k9byO;
    YenNQ:
    if ($string == null) {
        goto TRPvQ;
    }
    goto R2rF6;
    BDMQh:
    TRPvQ:
    goto zI0XQ;
    Pie0Y:
    $array["\162\x65\152\145\143\164\117\162\x64\145\x72\116\165\x6d\163"] = $string;
    goto uBjuy;
    qcS6l:
    hexE_:
    goto qiILG;
    SqacH:
    if ($string == null) {
        goto RnffJ;
    }
    goto GkbUs;
    r7J_Z:
    return $url;
    goto gbVjF;
    C92uc:
    ok21H:
    goto nduLF;
    iutTf:
    goto fQGjw;
    goto sWOe6;
    P7JzN:
    goto ovPIy;
    goto BDMQh;
    ZP9ss:
    $array = array("\141\x70\x70\113\145\x79" => $appKey, "\x61\x70\160\123\145\143\162\x65\x74" => $appSecret, "\x74\x69\155\145\163\164\x61\x6d\x70" => $timestamp);
    goto YndKK;
    gbVjF:
}
goto UPl6Y;
Ux7Nx:
function parseCreditNotify($appKey, $appSecret, $request_array)
{
    goto l05U5;
    MMHRQ:
    if ($verify) {
        goto j8l6r;
    }
    goto ln4EW;
    ILwp4:
    if (!($request_array["\x74\x69\x6d\x65\163\164\x61\155\x70"] == null)) {
        goto FoVnl;
    }
    goto QXiGd;
    ln4EW:
    throw new Exception("\163\x69\147\156\40\x76\x65\x72\151\146\171\x20\x66\141\151\x6c");
    goto r1nXL;
    rd5g1:
    throw new Exception("\x61\x70\x70\113\x65\x79\40\156\x6f\164\x20\155\x61\x74\x63\150");
    goto Qw0a3;
    r1nXL:
    j8l6r:
    goto ghA9N;
    QXiGd:
    throw new Exception("\x74\151\155\x65\x73\x74\x61\155\x70\40\143\141\x6e\47\164\x20\x62\145\x20\156\x75\x6c\154");
    goto dfpxI;
    l05U5:
    if (!($request_array["\x61\160\160\x4b\145\x79"] != $appKey)) {
        goto GY8e7;
    }
    goto rd5g1;
    nkhGO:
    $verify = signVerify($appSecret, $request_array);
    goto MMHRQ;
    ghA9N:
    $ret = array("\x73\165\x63\143\x65\x73\x73" => $request_array["\x73\165\x63\143\x65\163\x73"], "\145\x72\x72\157\162\x4d\145\163\163\141\x67\145" => $request_array["\x65\162\x72\157\x72\115\145\x73\x73\x61\147\x65"], "\142\x69\x7a\111\x64" => $request_array["\x62\x69\172\111\x64"]);
    goto m07Zn;
    dfpxI:
    FoVnl:
    goto nkhGO;
    m07Zn:
    return $ret;
    goto IL4Ro;
    Qw0a3:
    GY8e7:
    goto ILwp4;
    IL4Ro:
}
goto hp4A6;
ZwcuA:
function signVerify($appSecret, $array)
{
    goto yAJRq;
    WA23Q:
    reset($array);
    goto L_0mH;
    bPmjx:
    if (!($sign == $array["\163\151\x67\x6e"])) {
        goto LeWQR;
    }
    goto RCk7r;
    x6Nmq:
    return false;
    goto sWc_D;
    UUXn2:
    goto AvURE;
    goto PE4TY;
    dsvqV:
    eJltJ:
    goto UUXn2;
    Jq_V0:
    LeWQR:
    goto x6Nmq;
    p29on:
    $newarray[$key] = $val;
    goto dsvqV;
    igH76:
    if (!(list($key, $val) = each($array))) {
        goto X2nFO;
    }
    goto M9XzK;
    RCk7r:
    return true;
    goto Jq_V0;
    wL5G9:
    $newarray["\x61\160\160\123\145\x63\162\x65\x74"] = $appSecret;
    goto WA23Q;
    L_0mH:
    AvURE:
    goto igH76;
    PE4TY:
    X2nFO:
    goto pPmb9;
    pPmb9:
    $sign = sign($newarray);
    goto bPmjx;
    M9XzK:
    if (!($key != "\x73\x69\147\156")) {
        goto eJltJ;
    }
    goto p29on;
    yAJRq:
    $newarray = array();
    goto wL5G9;
    sWc_D:
}
goto d1om7;
d1om7:
function buildCreditAutoLoginRequest($appKey, $appSecret, $uid, $credits)
{
    goto yw6Bz;
    j_r6y:
    $array = array("\x75\151\144" => $uid, "\143\162\x65\144\x69\164\163" => $credits, "\141\x70\x70\123\145\x63\162\145\x74" => $appSecret, "\x61\160\160\113\145\x79" => $appKey, "\x74\151\155\x65\163\164\141\x6d\160" => $timestamp);
    goto tae6j;
    yw6Bz:
    $url = "\150\x74\x74\x70\x3a\x2f\57\167\x77\x77\x2e\144\165\x69\x62\141\x2e\143\x6f\x6d\x2e\x63\156\57\141\x75\x74\x6f\114\157\147\151\156\57\x61\165\x74\x6f\x6c\x6f\147\x69\156\77";
    goto WmkFT;
    WmkFT:
    $timestamp = time() * 1000 . '';
    goto j_r6y;
    BHUt7:
    return $url;
    goto e5S2v;
    tae6j:
    $sign = sign($array);
    goto H9bU7;
    H9bU7:
    $url = $url . "\165\x69\x64\x3d" . $uid . "\x26\143\x72\x65\144\151\x74\163\75" . $credits . "\x26\x61\160\x70\x4b\x65\171\75" . $appKey . "\x26\x73\151\147\156\x3d" . $sign . "\46\164\x69\x6d\145\163\x74\x61\x6d\160\x3d" . $timestamp;
    goto BHUt7;
    e5S2v:
}
goto LJoRg;
hp4A6:
?>
