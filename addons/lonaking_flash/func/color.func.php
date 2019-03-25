<?php
/*
 __________________________________________________
|  Encode by BajieTeam on we7                      |
|__________________________________________________|
*/

function rgb2hex($rgb)
{
    goto UeaZJ;
    YMTZ8:
    if (!($c > 16)) {
        goto e4C56;
    }
    goto gEPmC;
    Ao5dA:
    $re = preg_match($regexp, $rgb, $match);
    goto x4oCT;
    kHkvd:
    goto tUvP9;
    goto d0Zm2;
    o201U:
    if (!($i < 3)) {
        goto LgrjB;
    }
    goto g_o1X;
    oWmwr:
    $i = 0;
    goto ITH66;
    lGua2:
    $ret = array_reverse($hexAr);
    goto fM2NG;
    UeaZJ:
    $regexp = "\57\x5e\x72\x67\x62\x5c\50\x28\133\60\55\x39\135\x7b\60\54\x33\x7d\51\134\54\134\163\x2a\x28\x5b\x30\x2d\x39\135\x7b\60\54\63\175\x29\x5c\54\x5c\x73\x2a\50\x5b\60\x2d\x39\x5d\x7b\x30\54\63\175\x29\x5c\x29\x2f";
    goto Ao5dA;
    fkbJo:
    goto V0mE9;
    goto Y3u6y;
    x81Ll:
    array_push($hexAr, $hex[$r]);
    goto kHkvd;
    R_fUN:
    aIt6k:
    goto w5RLL;
    GmyWC:
    $hexAr = array();
    goto FvmSN;
    KFmMd:
    $hex = array("\60", "\61", "\x32", "\x33", "\x34", "\x35", "\66", "\67", "\x38", "\x39", "\x41", "\102", "\103", "\104", "\x45", "\106");
    goto oWmwr;
    u5cWj:
    $item = str_pad($item, 2, "\60", STR_PAD_LEFT);
    goto nB2VQ;
    fM2NG:
    $item = implode('', $ret);
    goto u5cWj;
    ePvSI:
    array_push($hexAr, $hex[$c]);
    goto lGua2;
    NSYUG:
    $hexColor = "\x23";
    goto KFmMd;
    KIT_d:
    return $hexColor;
    goto eIodH;
    x4oCT:
    $re = array_shift($match);
    goto NSYUG;
    FvmSN:
    tUvP9:
    goto YMTZ8;
    d0Zm2:
    e4C56:
    goto ePvSI;
    w5RLL:
    $i++;
    goto fkbJo;
    gEPmC:
    $r = $c % 16;
    goto g1r8H;
    hbCSX:
    $c = $match[$i];
    goto GmyWC;
    g_o1X:
    $r = null;
    goto hbCSX;
    ITH66:
    V0mE9:
    goto o201U;
    nB2VQ:
    $hexColor .= $item;
    goto R_fUN;
    Y3u6y:
    LgrjB:
    goto KIT_d;
    g1r8H:
    $c = $c / 16 >> 0;
    goto x81Ll;
    eIodH:
}
/**
 * 十六进制 转 RGB
 */
function hex2rgb($hexColor, $opacity = 1, $return = "\163\x74\x72")
{
    goto dVxg4;
    OpJes:
    $b = substr($color, 2, 1) . substr($color, 2, 1);
    goto TUR0b;
    LzJ3d:
    $color = $hexColor;
    goto R3XIq;
    rQuAS:
    $rgb = array("\162" => hexdec(substr($color, 0, 2)), "\147" => hexdec(substr($color, 2, 2)), "\x62" => hexdec(substr($color, 4, 2)));
    goto H0oQg;
    bqoAl:
    PVfpr:
    goto MMyrv;
    kfdLy:
    $g = substr($color, 1, 1) . substr($color, 1, 1);
    goto OpJes;
    R3XIq:
    $r = substr($color, 0, 1) . substr($color, 0, 1);
    goto kfdLy;
    zrvVa:
    if ($return == "\163\x74\x72") {
        goto rpcif;
    }
    goto CZsFV;
    TUR0b:
    $rgb = array("\x72" => hexdec($r), "\x67" => hexdec($g), "\x62" => hexdec($b));
    goto z3fhr;
    STKBI:
    if (strlen($color) > 3) {
        goto eDW2X;
    }
    goto LzJ3d;
    ixnWj:
    return "\162\x67\142\x61\50" . $rgb["\x72"] . "\x2c" . $rgb["\147"] . "\54" . $rgb["\x62"] . "\x2c" . $opacity . "\x29";
    goto bqoAl;
    jgw6_:
    rpcif:
    goto ixnWj;
    dgO0p:
    goto PVfpr;
    goto jgw6_;
    CZsFV:
    return $rgb;
    goto dgO0p;
    dVxg4:
    $color = str_replace("\43", '', $hexColor);
    goto STKBI;
    N7gLM:
    eDW2X:
    goto rQuAS;
    z3fhr:
    goto nsKiV;
    goto N7gLM;
    H0oQg:
    nsKiV:
    goto zrvVa;
    MMyrv:
}
