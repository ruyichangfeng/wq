<?php
 class Kanjia extends ZskWxapp { public function goodsList() { goto KvGQL; DNzxP: $result["\x67\157\157\x64\x73"] = $goods; goto ZMxF7; Hywvy: $uniacid = intval($_W["\x75\x6e\151\x61\143\151\x64"]); goto pyWwy; tcChN: $result["\164\151\155\145\x73\x74\x61\155\160"] = time(); goto DNzxP; E4U3i: $tab3 = $model->tablename("\x6b\141\156\152\151\x61\x5f\144\x65\x74\x61\151\154"); goto JY0Gu; zxbv3: $tab1 = $model->tablename("\144\151\x73\143\157\x75\x6e\164"); goto vpLCA; vpLCA: $sql = "\123\105\114\x45\103\x54\x20{$tab1}\56\x2a\54{$tab1}\x2e\x69\x64\x20\x61\x73\x20\144\x69\163\x63\x6f\x75\156\164\x5f\x69\x64\x2c{$tab0}\56\156\x61\x6d\x65\x2c{$tab0}\x2e\160\151\x63\164\x75\162\145\54{$tab0}\56\160\x72\151\143\145\60\x2c{$tab0}\56\160\x72\x69\143\x65\54{$tab0}\x2e\x70\x69\x63\x74\x75\162\145\x5f\167\151\x64\x65\54\x30\40\141\163\x20\151\x73\x5f\x73\164\x6f\160\54\x30\x20\x61\163\x20\x73\x74\x6f\x70\137\x64\x61\x79\x2c\60\40\x61\163\40\163\164\x6f\160\x5f\150\157\165\x72\x2c\60\x20\141\x73\x20\163\164\x6f\x70\137\155\x69\x6e\165\164\145\54\x30\40\x61\x73\40\x73\164\x6f\160\137\x73\x65\x63\x6f\x6e\144\x20\40\x46\122\117\115\40{$tab1}\40\114\105\x46\124\40\40\x4a\x4f\x49\x4e\x20{$tab0}\40\x4f\116\40{$tab0}\56\x69\x64\x3d{$tab1}\x2e\147\x6f\157\x64\x73\x69\x64\40\167\x68\x65\x72\145\40{$tab1}\x2e\165\x6e\x69\141\x63\151\144\x3d{$uniacid}\x20\x61\x6e\x64\40{$tab1}\x2e\163\164\x61\x74\x75\163\76\60\x20\x61\156\x64\x20{$tab0}\x2e\163\164\x61\164\x75\x73\76\x30\40\40\x61\156\144\40{$tab1}\x2e\164\171\x70\x65\75\x35\40\157\162\144\145\x72\40\x62\171\40{$tab1}\x2e\163\x74\x6f\160\164\151\155\x65\x20\144\145\x73\143"; goto H3ttM; lMi2b: kqIBP: goto geLp5; Ogw_R: vhiYM: goto mK6zR; WDAZN: $tab0 = $model->tablename("\x67\157\157\x64\163"); goto zxbv3; pyWwy: $model = Model("\144\151\x73\143\x6f\165\x6e\x74"); goto WDAZN; cbOfL: $list = $result["\144\141\164\x61\163\x65\x74"]; goto E4U3i; KvGQL: global $_W, $_GPC; goto Hywvy; mK6zR: $goods = getKanjiaGoodsInfo($list); goto tcChN; JY0Gu: $tab4 = $model->tablename("\x6d\145\x6d\142\x65\x72"); goto Lfj4z; Lfj4z: foreach ($list as $key => $val) { goto zP4j3; KLNg4: yutAq: goto jBx43; bPNJc: $sql = "\x53\105\x4c\105\103\x54\x20{$tab4}\x2e\141\x76\x61\164\x61\x72\54{$tab4}\x2e\x6f\160\x65\156\151\x64\x2c{$tab4}\56\x6e\x69\x63\x6b\156\x61\x6d\145\x20\106\122\117\115\x20{$tab4}\40\x4c\x45\106\124\40\112\117\x49\116\x20{$tab3}\40\117\116\x20{$tab4}\x2e\x6f\x70\145\x6e\151\144\x3d{$tab3}\x2e\157\160\x65\x6e\x69\x64\40\x57\x48\105\122\x45\40{$tab3}\56\144\151\x73\143\157\165\156\164\x5f\151\144\75" . intval($val["\x64\x69\x73\x63\x6f\165\156\x74\137\x69\144"]) . "\x20\107\122\x4f\125\x50\x20\102\131\x20{$tab4}\56\157\160\x65\x6e\x69\144\x20\x4f\122\104\x45\122\x20\102\131\40{$tab3}\56\143\162\x65\x61\x74\145\x74\x69\x6d\x65\40\104\105\123\x43\40\x4c\111\115\x49\x54\x20\x31\60"; goto Mobol; Mobol: $list[$key]["\165\x73\x65\162\x73"] = $model->query($sql); goto KLNg4; zP4j3: $list[$key]["\x69\x64"] = $val["\x67\x6f\x6f\x64\x73\151\x64"]; goto bPNJc; jBx43: } goto Ogw_R; ZMxF7: echo JSON_OUT($result); goto f6Q3w; H3ttM: $result = $model->pagenation($sql); goto veyY7; geLp5: $result["\x61\x74\x74\x61\x63\x68\x75\x72\x6c"] = $_W["\141\164\x74\x61\x63\x68\x75\162\x6c"]; goto cbOfL; veyY7: foreach ($result["\x64\141\x74\141\163\145\164"] as $key => $val) { goto KQnwT; L2UOa: $result["\144\141\x74\x61\163\x65\164"][$key]["\x73\164\157\160\163\164\x61\155\160"] = strtotime($val["\163\164\157\160\164\x69\x6d\145"]); goto yUlhp; yUlhp: $result["\x64\141\x74\141\x73\x65\x74"][$key]["\x70\162\x69\143\145\x6c\157\x77"] = floatval($val["\160\x72\151\x63\x65\154\157\167"]); goto n9OMZ; n9OMZ: UeZJj: goto L0WPb; KQnwT: $result["\144\x61\164\x61\x73\145\164"][$key]["\x70\162\x69\x63\145\x30"] = floatval($val["\x70\162\151\x63\145\x30"]); goto il1yg; il1yg: $result["\x64\141\164\x61\x73\x65\164"][$key]["\x70\162\151\143\x65"] = floatval($val["\160\162\x69\x63\x65"]); goto L2UOa; L0WPb: } goto lMi2b; f6Q3w: } function getKanjiaQR() { goto pzfhx; imEgh: $data = "\173\15\12\x9\11\11\42\163\x63\x65\156\x65\x22\x3a\42\x67\157\157\144\163\151\x64\x3d" . $gid . "\42\54\xd\xa\11\11\11\x22\160\x61\147\145\x22\72\42\x7a\163\x6b\137\155\141\162\x6b\x65\x74\57\x70\x61\147\145\x73\57\x64\145\164\141\151\154\163\x2f\151\x6e\144\145\170\77\x67\157\x6f\144\163\x69\144\75" . $gid . "\x22\x2c\15\12\x9\11\11\x22\167\x69\x64\x74\150\x22\x3a\62\x30\x30\xd\12\11\x9\175"; goto MuBN3; t13ww: $js = new WeixinJS($setting["\x61\x70\160\x69\x64"], $setting["\163\x65\143\162\145\164"]); goto iY7vB; pmFOT: $result["\142\141\x73\145\x36\x34"] = "\144\141\x74\141\x3a\x69\x6d\141\x67\x65\x2f\x70\156\x67\x3b\142\x61\163\145\66\x34\54" . base64_encode($res); goto kxfDF; MuBN3: $res = CURL_image($url, $data); goto pmFOT; pzfhx: $setting = getSetting(); goto t13ww; brqaD: $url = "\150\164\164\x70\163\x3a\x2f\x2f\x61\x70\x69\56\x77\x65\151\170\x69\156\56\161\161\56\x63\x6f\155\x2f\x77\170\141\57\x67\x65\x74\x77\170\x61\143\x6f\x64\x65\165\x6e\154\151\155\151\164\77\141\143\143\x65\x73\x73\137\164\157\x6b\x65\x6e\75" . $token["\x61\143\x63\145\163\x73\137\x74\157\153\x65\156"]; goto imEgh; iY7vB: $token = $js->getToken(); goto brqaD; kxfDF: } public function helpFriend() { goto yRa_8; bDaU0: if (!($rand < 0)) { goto yZ8jW; } goto F0aLL; PlVnU: $detail["\167\157\x72\x64\164\x79\x70\145"] = 1; goto GRRgt; LNEUw: $result = array("\x73\164\141\x74\165\163" => 0, "\x6d\x73\147" => "\347\240\x8d\344\273\xb7\xe5\244\261\xe8\264\xa5"); goto phMVL; katty: echo json_encode($result); goto QUVU3; wXbtF: QMSIv: goto bDaU0; DEvQq: echo json_encode($result); goto CXiw2; oReY9: $result["\155\163\x67"] = "\xe4\xb8\215\xe6\255\xa3\347\xa1\256\xe7\x9a\204\xe5\x9b\242\xe9\230\x9f\x69\x64"; goto ToNb3; QUVU3: exit; goto m7WSs; LVZPQ: echo json_encode($result); goto roOxG; m7WSs: FdpJT: goto v7Tdn; phMVL: if (!(strlen($openid) < 20)) { goto MGSa3; } goto jg0sQ; W97rC: z3EQA: goto dTnkn; v7Tdn: $price_kanjia = floatval($goods["\x70\x72\151\143\145"]) - floatval($discount["\x70\x72\x69\x63\x65\154\157\x77"]); goto uK8P5; CXiw2: exit; goto Z3CNp; AzNIZ: echo JSON_OUT($result); goto JtUMd; bfg3J: $rand = floatval($price_kanjia) - floatval($group["\156\x6f\x77\x5f\144\x69\163\x63\x6f\165\156\x74"]); goto wXbtF; Wnch5: $result["\155\163\147"] = "\346\264\xbb\xe5\212\250\345\267\xb2\350\xbf\x87\346\234\237"; goto katty; HL1Ru: $model = Model("\144\151\163\x63\x6f\x75\x6e\164"); goto yAI6a; dTnkn: $result["\x67\x72\157\165\160"] = $group = Model("\x64\151\x73\x63\157\165\x6e\164\x67\x72\x6f\x75\x70")->where("\x75\x6e\x69\141\x63\151\x64\x3d{$uniacid}\40\141\x6e\144\40\x69\x64\75{$groupid}\x20\x61\x6e\144\x20\147\157\157\x64\x73\151\x64\x3d{$gid}\40\141\x6e\x64\x20\x74\x79\160\145\75\x35")->get(); goto Y1Xvd; g4Cig: $rand = $avg * (rand(7, 13) / 10); goto GV1TX; bi6Mw: Qa29j: goto ADXUK; ToNb3: goto uI3Cp; goto GSl6r; W_ADF: f47xc: goto b1Bmb; Z3CNp: MGSa3: goto tCSaq; g6_0I: $result["\155\x73\x67"] = "\xe4\275\xa0\345\267\262\347\273\217\347\240\215\350\xbf\x87\xe4\272\x86"; goto LVZPQ; uK8P5: if (!($price_kanjia < 0)) { goto z3EQA; } goto n4ojL; GV1TX: pClLV: goto Mte4g; tCSaq: $goods = Model("\147\x6f\157\144\163")->where("\165\x6e\x69\141\x63\x69\144\x3d" . $uniacid . "\40\x61\x6e\x64\x20\151\x64\75" . $gid)->get("\x69\x64\54\x6e\x61\155\x65\54\x70\162\x69\x63\145\x2c\x70\x72\x69\143\145\60\x2c\165\156\x69\141\x63\151\144"); goto JR1Yb; qyTHh: F1ujL: goto s9l7a; ff2jt: $tab5 = $model->tablename("\144\151\x73\143\x6f\165\x6e\x74"); goto iYuCv; oMx0H: uI3Cp: goto AzNIZ; E0K_M: if (!$exist) { goto F1ujL; } goto g6_0I; aePd_: Yinp1: goto Rhieo; d6a8D: $kid = intval($_GPC["\153\151\144"]); goto jxhyd; GRRgt: goto B5YiT; goto v_7G9; yRa_8: global $_W, $_GPC; goto wabs5; wgal_: $detail["\167\x6f\162\144\x74\171\160\x65"] = 2; goto sCpDZ; ZSJ2F: $rand = floatval($price_kanjia) - floatval($group["\x6e\x6f\x77\137\144\151\163\143\157\x75\156\x74"]); goto bi6Mw; sCpDZ: B5YiT: goto sXWdY; o1XJH: $openid = trim($_GPC["\157\x70\145\x6e\151\144"]); goto LNEUw; seVH_: $exist = Model("\153\141\x6e\152\151\141\x5f\144\x65\164\x61\x69\154")->exist("\157\160\145\x6e\151\144\75\x27{$openid}\x27\40\141\x6e\144\40\147\162\157\x75\160\x69\x64\75\47" . $group["\x69\144"] . "\x27"); goto E0K_M; h34wd: Ok2SG: goto AW4IZ; pn_SY: $tab5 = $model->tablename("\x64\151\163\143\x6f\165\156\164\147\x72\157\x75\x70"); goto ecBwH; wabs5: $uniacid = intval($_W["\165\x6e\x69\141\143\151\x64"]); goto No9lw; Oof_5: $detail = array("\165\156\x69\x61\143\151\144" => $uniacid, "\x6f\x70\x65\x6e\x69\x64" => $_GPC["\157\x70\x65\156\151\x64"], "\x64\x69\x73\x63\x6f\x75\x6e\x74\x5f\x69\144" => $discount["\x69\144"], "\x67\162\157\x75\160\151\x64" => $groupid, "\x67\x6f\x6f\144\x73\151\x64" => $gid, "\x63\162\145\x61\164\145\164\151\155\x65" => time()); goto DZgCF; sXWdY: goto Yinp1; goto W_ADF; grb2q: $rand = (floatval($price_kanjia) - floatval($group["\156\x6f\x77\x5f\x64\151\163\x63\x6f\165\x6e\x74"])) / (intval($discount["\147\x72\157\165\x70\137\154\x69\155\151\x74"]) - intval($group["\x6e\157\x77\x5f\x70\145\157\160\154\x65"])); goto v4pzi; DZgCF: $detail["\x6d\157\156\x65\171\137\163\164\145\160"] = $rand; goto JeMLA; v4pzi: goto pClLV; goto AG1tf; F0aLL: $rand = 0; goto bqu8J; GsRyD: $result["\x6d\163\x67"] = "\xe7\xa0\x8d\344\xbb\267\xe5\244\261\350\xb4\245\xef\xbc\x81\350\xb6\205\345\207\xba\344\272\272\xe6\225\xb0\xe6\x88\226\351\x87\221\xe9\xa2\235\xe4\xb8\x8a\351\231\220\343\200\202"; goto dhrje; h0Lwn: $result["\x6d\x73\147"] = "\xe5\x95\206\xe5\223\201\345\267\xb2\344\270\213\346\236\266"; goto hLzz0; jxhyd: $groupid = intval($_GPC["\147\x72\x6f\165\x70\151\144"]); goto HL1Ru; s9l7a: if (!(floatval($group["\x6e\157\167\137\x64\x69\163\x63\x6f\x75\x6e\x74"]) >= floatval($price_kanjia) || intval($group["\x6e\157\167\x5f\x70\145\157\x70\154\x65"]) >= intval($discount["\x67\x72\x6f\x75\x70\137\x6c\151\x6d\151\x74"]))) { goto Ok2SG; } goto GsRyD; iYuCv: $model->query("\x55\120\x44\101\x54\x45\40{$tab5}\40\123\x45\x54\x20\x6e\x6f\x77\137\x70\145\x6f\x70\154\145\x3d\156\157\x77\137\160\x65\157\160\154\145\53\61\40\x57\110\105\x52\105\x20\151\144\x3d{$did}\40\x4c\111\115\111\x54\x20\x31"); goto pn_SY; GSl6r: UTCMG: goto seVH_; No9lw: $gid = intval($_GPC["\147\x69\x64"]); goto d6a8D; jg0sQ: $result["\x6d\x73\x67"] = "\347\240\215\xe4\273\267\345\244\xb1\xe8\264\245\xef\xbc\x81\xe6\234\252\350\x8e\267\345\217\226\xe5\x88\xb0\xe7\x94\xa8\xe6\x88\xb7\x4f\x70\145\x6e\111\x44\343\x80\202"; goto DEvQq; b1Bmb: $detail["\167\x6f\x72\144\x74\171\160\145"] = 3; goto aePd_; LaM5j: $result["\162\x61\156\144"] = $rand; goto Oof_5; x5SQ_: uQseL: goto HtG3g; roOxG: exit; goto qyTHh; i30xv: if (floatval($group["\156\x6f\x77\137\144\151\x73\143\157\165\156\x74"]) < floatval($price_kanjia) * 0.7) { goto dBgOG; } goto grb2q; JeMLA: if ($rand > $avg * 2 / 3 && $rand <= $avg) { goto f47xc; } goto g_F4P; Mte4g: if (!($rand + floatval($group["\x6e\x6f\167\x5f\144\151\x73\143\x6f\x75\x6e\x74"]) > floatval($price_kanjia))) { goto Qa29j; } goto ZSJ2F; hLzz0: echo json_encode($result); goto Nkk2B; mkKN7: exit; goto h34wd; Abetp: $result["\144\x69\163\143\157\x75\156\164"] = $discount = $model->where("\x73\164\x61\162\164\164\151\155\145\74\x3d\47{$now}\47\40\141\156\x64\x20\x73\164\x6f\x70\164\151\x6d\145\x3e\75\x27{$now}\x27\x20\x61\156\x64\40\x75\x6e\151\x61\x63\151\144\x3d{$uniacid}\x20\141\x6e\144\40\147\157\x6f\x64\x73\x69\x64\x3d{$gid}\40\x61\156\x64\x20\163\x74\141\164\x75\163\x3e\x30\40\x61\156\144\x20\164\x79\x70\x65\75\65\40")->get(); goto QW3ha; bqu8J: yZ8jW: goto LaM5j; Tn_zE: $result["\163\x74\x61\164\x75\163"] = 1; goto oMx0H; AG1tf: dBgOG: goto g4Cig; ecBwH: $model->query("\x55\120\104\101\124\x45\40{$tab5}\x20\x53\x45\x54\x20\156\x6f\167\x5f\x70\x65\x6f\x70\x6c\145\x3d\156\x6f\167\x5f\x70\x65\x6f\160\x6c\x65\53\x31\x2c\x6e\157\x77\137\144\151\x73\x63\157\x75\156\164\75\156\x6f\x77\137\x64\x69\163\143\x6f\x75\x6e\164\x2b" . $detail["\x6d\x6f\x6e\x65\x79\x5f\163\164\145\160"] . "\40\127\x48\105\122\x45\x20\x69\144\x3d" . intval($group["\151\x64"]) . "\40\x4c\111\x4d\x49\124\40\61"); goto Tn_zE; QW3ha: if (!empty($discount)) { goto FdpJT; } goto Wnch5; Nkk2B: exit; goto x5SQ_; yAI6a: $m2 = Model("\x6b\x61\x6e\152\x69\141\137\x64\145\164\x61\151\154"); goto o1XJH; g_F4P: if ($rand > $avg * 1 / 3 && $rand <= $avg * 2 / 3) { goto V_kJa; } goto PlVnU; Y1Xvd: if (intval($group["\x69\144"]) > 0) { goto UTCMG; } goto oReY9; HtG3g: $now = date("\x59\55\x6d\x2d\x64\40\x48\x3a\151\72\x73", time()); goto Abetp; dhrje: echo json_encode($result); goto mkKN7; ADXUK: if (!(intval($group["\156\157\167\x5f\x70\x65\157\160\154\145"]) == intval($discount["\x67\x72\x6f\x75\x70\137\154\x69\x6d\151\164"]) - 1)) { goto QMSIv; } goto bfg3J; v_7G9: V_kJa: goto wgal_; JR1Yb: if (!empty($goods)) { goto uQseL; } goto h0Lwn; AW4IZ: $avg = floatval($price_kanjia / $discount["\147\x72\157\x75\x70\137\x6c\x69\x6d\151\164"]); goto i30xv; Rhieo: $detid = $m2->add($detail); goto ff2jt; n4ojL: $price_kanjia = 0; goto W97rC; JtUMd: } public function createKanjia() { goto DK54A; JBcnj: if (intval($group["\151\x64"]) < 1) { goto mUvXH; } goto CJVu8; ziLld: if (!empty($discount)) { goto W3Bax; } goto Cpn7r; H6UQl: if ($rand > $avg * 2 / 3 && $rand <= $avg) { goto SQKpP; } goto YGX9x; qiM6s: $result["\155\x73\147"] = "\xe5\225\x86\xe5\223\x81\xe5\267\262\344\xb8\x8b\xe6\236\266"; goto uFfMk; uHwiQ: echo json_encode($result); goto koOar; GSuWC: SQKpP: goto KGky4; pW0nc: echo JSON_OUT($result); goto LFQYU; K8p6B: $result["\163\x74\x61\x74\165\163"] = 1; goto Xy3o7; DOVf6: if (!($rand + floatval($group["\x6e\157\167\x5f\144\151\x73\143\x6f\165\x6e\164"]) > floatval($price_kanjia))) { goto LYNFH; } goto Orha9; KGky4: $detail["\x77\157\x72\x64\x74\171\x70\145"] = 3; goto qc6Rr; DJgVM: $kid = intval($_GPC["\153\151\x64"]); goto ePLM0; AWWA7: W3Bax: goto ahlJN; q258P: $result["\162\141\156\144"] = $rand; goto ekMfD; Orha9: $rand = floatval($price_kanjia) - floatval($group["\156\157\167\137\144\151\x73\x63\x6f\x75\156\164"]); goto kA3bD; dh6T_: $result["\x64\151\x73\x63\157\x75\x6e\164"] = $discount; goto cmeZI; rpFfq: $details = $model->query($sql); goto dh6T_; Cpn7r: $result["\x6d\x73\x67"] = "\xe6\264\273\xe5\x8a\xa8\345\267\262\xe4\xb8\213\xe6\x9e\266"; goto uHwiQ; GKDaS: CSzQ6: goto jCoAk; CJVu8: $result["\x6d\163\x67"] = "\344\xb8\215\xe8\203\275\351\x87\215\345\244\215\345\x8f\x82\345\x8a\xa0\346\264\273\xe5\212\xa8\357\xbc\214\350\257\267\345\xae\214\xe6\x88\x90\345\xbd\x93\xe5\x89\215\xe6\xb4\xbb\345\x8a\xa8\xe5\x90\x8e\345\x86\x8d\xe6\x9d\245\xe5\220\247"; goto ZAvKB; Yu0xX: $tab5 = $model->tablename("\x64\x69\x73\143\157\165\156\x74"); goto zvUMM; I573S: if (!($price_kanjia < 0)) { goto Gj2C5; } goto FqhOR; cmeZI: $group["\141\x76\x61\164\141\x72"] = $group["\x6e\x69\143\153\156\141\155\x65"] = ''; goto WIw6e; Us27Y: $openid = trim($_GPC["\157\x70\x65\156\151\x64"]); goto iT1kl; ChAcW: exit; goto cYJ19; Dynlc: mUvXH: goto C60Rm; pK_VU: $uniacid = intval($_W["\165\x6e\151\x61\143\x69\x64"]); goto uFdUq; SZlsY: $detail["\167\x6f\x72\144\x74\171\160\x65"] = 1; goto HNAEJ; TUa1W: $groupid = Model("\x64\151\163\143\157\165\156\164\147\x72\x6f\x75\160")->add($group); goto sdZJz; IMjpo: bDdWx: goto DKjbl; ZAvKB: goto j3x4I; goto Dynlc; DU66Z: ml9aZ: goto f0oCT; f0oCT: goto YtXl5; goto GSuWC; NdyoD: if (!empty($goods)) { goto DXvBU; } goto qiM6s; aTfS_: $result["\155\163\x67"] = "\xe7\xa0\x8d\344\273\267\xe5\244\xb1\350\264\245\357\274\x81\346\x9c\xaa\xe8\x8e\xb7\xe5\217\226\xe5\210\xb0\347\224\xa8\xe6\210\267\x4f\x70\x65\x6e\x49\x44"; goto PTm_v; awjXX: $m2->add($detail); goto Yu0xX; DKjbl: $detail["\x77\157\162\144\x74\171\x70\145"] = 2; goto DU66Z; jCoAk: $goods = Model("\147\x6f\157\x64\163")->where("\165\156\x69\x61\143\x69\144\x3d" . $uniacid . "\40\141\156\x64\40\151\144\x3d" . $gid)->get("\x69\x64\54\x6e\141\155\x65\54\160\162\151\x63\145\x2c\160\162\x69\143\x65\x30\x2c\165\156\151\x61\143\151\x64"); goto NdyoD; YGX9x: if ($rand > $avg * 1 / 3 && $rand <= $avg * 2 / 3) { goto bDdWx; } goto SZlsY; UmzpD: exit; goto GKDaS; Xy3o7: $sql = "\x53\x45\114\105\x43\x54\x20{$tab0}\x2e\x2a\54{$tab1}\56\x6e\151\x63\x6b\156\x61\x6d\x65\54{$tab1}\56\141\166\141\164\141\162\40\x46\x52\117\115\40{$tab0}\40\114\105\x46\x54\x20\112\x4f\x49\116\x20{$tab1}\x20\117\x4e\x20{$tab0}\x2e\157\160\x65\156\x69\144\75{$tab1}\x2e\157\160\x65\x6e\151\x64\x20\127\x48\105\122\105\40{$tab0}\56\x67\162\x6f\165\x70\151\x64\x3d" . $group["\x69\144"] . "\40\x47\x52\117\125\x50\x20\x42\x59\x20{$tab0}\x2e\157\160\x65\x6e\151\x64\x20\40\117\122\104\x45\x52\40\102\x59\40{$tab0}\x2e\143\162\145\141\x74\x65\164\x69\155\x65\x20\x44\x45\x53\103\40\x4c\x49\115\111\124\x20\65"; goto rpFfq; gO2SY: $m2 = Model("\153\141\x6e\x6a\151\141\x5f\x64\x65\164\141\151\x6c"); goto Us27Y; rIxRF: $group = Model("\x64\x69\x73\x63\157\x75\156\x74\147\162\x6f\165\x70")->where("\x75\x6e\151\141\x63\x69\x64\75{$uniacid}\40\x61\156\144\40\x6f\x70\145\156\x69\144\75\x27{$openid}\47\x20\x61\156\144\x20\147\x6f\x6f\x64\x73\151\144\75{$gid}\40\141\156\x64\40\x69\144\75{$kid}\40\40\x61\x6e\x64\40\x74\171\160\x65\75\x35\x20\x61\156\144\x20\x73\x74\141\x74\165\163\75\x30")->get(); goto JBcnj; qc6Rr: YtXl5: goto awjXX; WIw6e: $result["\x67\x72\x6f\x75\x70"] = $group; goto W1bTI; PM8gU: if (!(strlen($openid) < 20)) { goto CSzQ6; } goto aTfS_; HNAEJ: goto ml9aZ; goto IMjpo; ahlJN: $price_kanjia = floatval($goods["\160\x72\151\x63\x65"]) - floatval($discount["\160\162\x69\143\145\154\157\x77"]); goto I573S; FqhOR: $price_kanjia = 0; goto hctEL; iT1kl: $result = array("\163\x74\x61\x74\x75\x73" => 0, "\155\x73\147" => "\xe5\210\233\345\xbb\272\347\240\x8d\344\xbb\xb7\xe5\244\261\350\264\xa5"); goto PM8gU; C60Rm: $avg = floatval($price_kanjia / $discount["\x67\162\x6f\x75\x70\x5f\x6c\x69\155\151\164"]); goto O2j36; DK54A: global $_W, $_GPC; goto pK_VU; DOFQ0: $detail = array("\165\x6e\x69\141\143\151\144" => $uniacid, "\x6f\160\145\156\151\144" => $_GPC["\157\160\145\156\x69\144"], "\x64\151\163\143\157\x75\156\164\x5f\x69\144" => $discount["\x69\144"], "\x67\x72\x6f\x75\x70\151\144" => $groupid, "\147\x6f\x6f\x64\x73\151\144" => $gid, "\143\x72\145\x61\164\145\164\151\155\x65" => time()); goto AfMvz; kA3bD: LYNFH: goto q258P; uFdUq: $gid = intval($_GPC["\147\151\x64"]); goto DJgVM; T508K: $discount = $model->where("\165\156\x69\141\x63\151\144\x3d{$uniacid}\40\x61\x6e\x64\x20\x67\157\157\144\x73\x69\144\75{$gid}\40\x61\156\144\x20\x73\x74\141\x74\x75\163\76\60\x20\141\156\x64\x20\x74\171\160\145\x3d\65\x20\141\x6e\144\40\x69\x64\75{$kid}")->get(); goto ziLld; uFfMk: echo json_encode($result); goto ChAcW; zvUMM: $model->query("\x55\120\104\101\x54\x45\x20{$tab5}\x20\123\105\124\x20\156\157\167\137\x70\x65\x6f\x70\154\x65\x3d\x6e\x6f\x77\137\x70\x65\157\x70\x6c\x65\53\x31\x20\127\110\x45\x52\105\x20\151\x64\x3d{$kid}\x20\114\x49\115\x49\124\40\61"); goto K8p6B; PTm_v: echo json_encode($result); goto UmzpD; cYJ19: DXvBU: goto T508K; W1bTI: j3x4I: goto pW0nc; O2j36: $rand = $avg * (rand(7, 13) / 10); goto DOVf6; sdZJz: $group["\x69\144"] = $groupid; goto DOFQ0; koOar: exit; goto AWWA7; AfMvz: $detail["\x6d\157\156\x65\171\137\163\164\x65\x70"] = $rand; goto H6UQl; ePLM0: $model = Model("\x64\x69\x73\143\157\165\x6e\x74"); goto gO2SY; hctEL: Gj2C5: goto rIxRF; ekMfD: $group = array("\165\156\x69\141\143\151\x64" => $uniacid, "\163\x68\157\160\151\144" => $discount["\163\150\x6f\160\151\x64"], "\x6f\x70\x65\x6e\151\144" => $openid, "\143\x72\x65\x61\x74\145\x74\x69\x6d\145" => time(), "\154\151\155\x69\x74\164\x69\x6d\x65" => strtotime($discount["\163\x74\x6f\x70\164\151\x6d\145"]), "\147\x6f\x6f\144\x73\x69\144" => $gid, "\x74\x79\160\145" => 5, "\144\x69\x73\x63\157\165\156\164\137\x69\x64" => $discount["\151\x64"], "\x63\x61\163\x65\151\x64" => intval($_GPC["\143\x61\x73\145\151\144"]), "\x6e\157\x77\137\160\x65\x6f\160\154\x65" => 1, "\x6e\157\x77\137\x64\151\x73\x63\157\x75\156\x74" => $rand); goto TUa1W; LFQYU: } public function getKanjiaByGoods() { goto ehkGf; a0rBJ: $goods = Model("\x67\157\157\x64\163")->where("\165\156\151\141\x63\151\x64\75{$uniacid}\x20\141\x6e\144\x20\163\x74\x61\x74\165\163\x3e\60\40\141\156\x64\x20\151\x64\x3d{$goodsid}")->get("\52"); goto X7PcF; a04Mz: $discountid = intval($_GPC["\144\151\x73\143\x6f\165\x6e\164\151\x64"]); goto Zt6kI; IKe0e: $group = $mygroup; goto rpqCq; wiNQh: $uniacid = intval($_W["\x75\x6e\x69\x61\x63\x69\144"]); goto eXx4U; jW4SR: $tab1 = $model->tablename("\x6d\145\x6d\142\145\x72"); goto klJqI; wOgtK: $case["\151\x64"] = 0; goto IZDHX; OunkI: NEdij: goto v60oI; oOLli: $model = Model("\144\151\163\x63\157\165\156\164"); goto fyLr3; Xeou_: $sql1 = "\x53\105\114\x45\103\x54\x20{$tab1}\x2e\156\x69\143\153\156\x61\x6d\145\54{$tab1}\56\141\x76\x61\x74\141\x72\x2c{$tab2}\x2e\52\40\x46\122\117\x4d\x20{$tab2}\x20\114\x45\106\124\40\x4a\x4f\x49\116\x20{$tab1}\x20\x4f\x4e\x20{$tab2}\56\x6f\160\145\156\151\144\x3d{$tab1}\56\x6f\160\145\x6e\x69\144\x20\127\x48\x45\x52\x45\x20{$tab2}\56\x75\156\151\141\x63\151\144\x3d{$uniacid}\x20\x61\x6e\144\x20{$tab2}\x2e\157\x70\x65\x6e\x69\x64\75\x27{$openid}\x27\x20\141\156\x64\x20{$tab2}\x2e\147\x6f\157\144\163\x69\144\x3d{$goodsid}\40\x61\x6e\x64\x20{$tab2}\x2e\164\x79\x70\x65\x3d\x35\40\114\111\x4d\x49\124\x20\61"; goto NaMh1; SK4jJ: $goods = Model("\147\x6f\157\x64\163")->where("\x75\156\151\141\x63\x69\x64\75{$uniacid}\x20\141\156\144\x20\163\164\x61\164\x75\x73\76\60\x20\x61\156\144\40\151\x64\x3d{$goodsid}")->get("\52"); goto f3rZp; Zt6kI: $groupid = intval($_GPC["\x67\162\157\x75\x70\151\144"]); goto IPmO0; Voka7: $sql = "\x53\105\114\x45\x43\124\40{$tab0}\x2e\x2a\x2c{$tab1}\x2e\x6e\151\143\x6b\x6e\x61\x6d\x65\54{$tab1}\56\141\x76\x61\x74\x61\162\40\x46\122\x4f\x4d\40{$tab0}\x20\114\105\106\124\x20\112\117\111\x4e\x20{$tab1}\x20\117\x4e\40{$tab0}\x2e\157\160\145\x6e\151\x64\x3d{$tab1}\56\157\x70\145\x6e\151\144\x20\127\x48\x45\x52\105\x20{$tab0}\56\147\x72\x6f\x75\160\x69\144\75" . $group["\x69\144"] . "\40\107\x52\x4f\125\x50\x20\x42\x59\x20{$tab0}\x2e\x6f\x70\x65\x6e\151\144\40\40\x4f\x52\x44\105\x52\x20\102\x59\x20{$tab0}\56\143\162\x65\x61\x74\145\164\x69\x6d\x65\x20\104\105\123\103\40\x4c\x49\115\111\124\40\x32\x30"; goto Vk6Kl; w5Va3: ILHA1: goto mDi2q; f3rZp: if (!empty($goods)) { goto NEdij; } goto kKJAe; vrACF: $case = Model("\147\157\157\x64\163\143\141\x73\145")->where("\151\x64\75" . intval($group["\143\x61\x73\145\151\x64"]))->get(); goto TK5D5; V9Ypr: NUxXn: goto VaNxA; kKJAe: echo json_encode(array("\145\162\162\x6f\162\x6e\x6f" => 404, "\x6d\163\147" => "\xe5\225\x86\345\223\x81\345\267\262\344\270\x8b\346\x9e\266")); goto CdaeM; X7PcF: $result = array("\144\x69\163\143\157\x75\156\x74" => $discount, "\155\171\147\x72\157\x75\160" => $mygroup, "\144\x65\164\x61\151\x6c\163" => $details, "\147\x72\x6f\165\x70" => $group, "\x63\x61\x73\145" => $case, "\147\x6f\x6f\144\163" => $goods); goto Ay8gk; VaNxA: $case["\147\157\157\x64\163\143\157\x75\x6e\x74"] = 1; goto jNiUP; vp5HF: $discount["\x73\164\157\160\163\x74\141\155\160"] = strtotime($discount["\163\164\x6f\x70\x74\x69\155\x65"]); goto R3Too; rpqCq: goto fAaNW; goto w5Va3; Ay8gk: echo JSON_OUT($result); goto nSutR; eLs7H: $kid = intval($_GPC["\153\x69\144"]); goto oOLli; mDi2q: $sql2 = "\123\x45\x4c\105\x43\x54\40{$tab1}\56\x6e\151\143\153\156\x61\155\145\54{$tab1}\x2e\x61\166\141\164\x61\x72\54{$tab2}\56\52\40\x46\122\117\x4d\40{$tab2}\40\114\x45\106\124\40\x4a\117\111\116\40{$tab1}\x20\117\x4e\x20{$tab2}\x2e\157\160\145\156\x69\144\x3d{$tab1}\56\157\160\x65\x6e\151\144\x20\127\x48\x45\122\105\40{$tab2}\x2e\x69\x64\x3d{$groupid}\40\x4c\x49\115\111\124\x20\x31"; goto waXfQ; Vk6Kl: $details = $model->query($sql); goto vrACF; fyLr3: $m2 = Model("\153\141\156\152\151\141\137\x64\145\x74\141\x69\154"); goto MxynN; IZDHX: goto JnJTh; goto V9Ypr; waXfQ: $group = pdo_fetch($sql2); goto m99Wy; v60oI: $discount = $model->where("\x75\x6e\x69\141\143\x69\x64\x3d{$uniacid}\40\x61\156\144\x20\151\144\x3d{$discountid}\x20\x61\x6e\x64\40\x73\x74\141\164\165\163\76\60\40\141\156\x64\40\164\x79\160\145\x3d\65")->get("\52"); goto vp5HF; jNiUP: JnJTh: goto a0rBJ; R3Too: $discount["\x69\x73\x5f\x73\x74\157\160"] = 0; goto Xeou_; TK5D5: if (!empty($case)) { goto NUxXn; } goto wOgtK; MxynN: $openid = $_GPC["\157\160\x65\x6e\151\x64"]; goto a04Mz; klJqI: $tab2 = $model->tablename("\x64\151\163\x63\157\x75\x6e\164\147\x72\x6f\165\x70"); goto SK4jJ; ehkGf: global $_W, $_GPC; goto wiNQh; eXx4U: $goodsid = intval($_GPC["\x67\x6f\x6f\144\x73\x69\144"]); goto eLs7H; IPmO0: $tab0 = $model->tablename("\x6b\141\x6e\x6a\151\x61\x5f\144\145\164\141\x69\154"); goto jW4SR; CdaeM: exit; goto OunkI; NaMh1: $mygroup = pdo_fetch($sql1); goto IqtFI; m99Wy: fAaNW: goto Voka7; IqtFI: if (intval($_GPC["\147\162\x6f\x75\x70\151\x64"])) { goto ILHA1; } goto IKe0e; nSutR: } public function cancelGroup() { goto yGsEG; psMZ3: echo json_encode($res); goto OCCvd; FeSV9: if (!$res["\x73\164\141\x74\165\x73"]) { goto xNxpd; } goto eT5Mw; yGsEG: global $_W, $_GPC; goto RPHjH; RPHjH: $where = "\157\160\x65\x6e\151\144\75\47" . $_GPC["\157\x70\145\x6e\151\144"] . "\x27\x20\141\156\144\40\x69\144\x3d" . intval($_GPC["\x67\162\157\165\x70\151\144"]); goto F0vlZ; eT5Mw: Model("\153\141\156\x6a\151\x61\137\144\x65\x74\141\x69\154")->where("\147\x72\157\165\160\151\144\x3d" . intval($_GPC["\147\162\157\165\x70\x69\x64"]))->limit(1)->delete(); goto xS7bf; F0vlZ: $res["\163\164\141\x74\165\x73"] = Model("\144\x69\x73\x63\157\165\156\164\x67\x72\x6f\x75\x70")->where($where)->limit(1)->delete(); goto FeSV9; xS7bf: xNxpd: goto psMZ3; OCCvd: } public function getOrderBySts() { goto UMHv8; Haae7: $openid = trim($_POST["\x6f\x70\x65\x6e\151\x64"]); goto PLXE1; kKSJJ: $tab1 = $model->tablename("\147\157\x6f\x64\163"); goto NSYnP; QsTeK: g5I2l: goto cfZwt; nwOSV: $groups["\x73\x71\x6c"] = $sql; goto x2zFd; UMHv8: global $_W, $_GPC; goto K3tKL; AX1es: HRUMC: goto m28G0; RPSh7: Gau7f: goto QOeEn; qL6y1: yyZhu: goto aSSRP; cM1Ub: if (!($sts != 99)) { goto Gau7f; } goto j7EbY; ALvZ7: $shops = Model("\x73\150\157\160")->where("\x69\x64\40\151\x6e\x20\50{$ids}\x29")->group("\151\x64")->getall(); goto qL6y1; m28G0: echo JSON_OUT($groups, true); goto i41gk; QOeEn: $groups = $model->pagenation($sql . "\40\x4f\x52\x44\x45\122\40\x42\131\x20\x63\x72\x65\x61\x74\145\164\151\x6d\x65\40\x64\145\163\x63"); goto nwOSV; cfZwt: if (!(strlen($ids) > 1)) { goto yyZhu; } goto nR004; NSYnP: $sql = "\x53\x45\x4c\x45\x43\x54\x20{$tab0}\x2e\52\x2c{$tab1}\56\163\150\x6f\160\151\144\x2c{$tab1}\56\x6e\x61\x6d\x65\x20\141\163\40\x67\157\x6f\x64\x73\x6e\141\x6d\x65\x2c{$tab1}\x2e\160\x69\143\x74\x75\x72\145\x2c{$tab1}\56\x70\162\x69\x63\x65\40\x46\122\117\x4d\40{$tab0}\40\114\x45\x46\x54\40\x4a\x4f\x49\116\40{$tab1}\x20\x4f\x4e\x20{$tab0}\56\147\x6f\x6f\x64\163\x69\x64\75{$tab1}\56\x69\x64\x20\x77\150\145\x72\x65\x20{$tab0}\x2e\164\171\x70\x65\75\x35\x20\x61\x6e\144\40{$tab0}\56\x75\x6e\x69\141\x63\x69\144\75{$uniacid}\x20\x61\156\144\40{$tab0}\56\x6f\160\145\x6e\x69\144\x3d\47" . $openid . "\47"; goto aPm23; nR004: $ids = substr($ids, 0, strlen($ids) - 1); goto ALvZ7; aSSRP: foreach ($groups["\144\141\164\141\x73\145\x74"] as $k => $v) { goto NVc0A; CAPb3: UzCQE: goto o0Ce8; FymVc: eV4n2: goto CAPb3; NVc0A: foreach ($shops as $key => $val) { goto V_Tzc; UUE_K: KgyRq: goto AFkie; myHV9: FR7fj: goto UUE_K; V_Tzc: if (!($v["\x73\x68\157\160\151\x64"] == $val["\151\144"])) { goto FR7fj; } goto IMOK9; IMOK9: $groups["\144\141\x74\141\x73\x65\x74"][$k]["\x73\150\157\x70\x6e\x61\x6d\145"] = $val["\156\141\155\x65"]; goto myHV9; AFkie: } goto FymVc; o0Ce8: } goto AX1es; PqDW8: $uniacid = intval($_W["\x75\156\x69\x61\x63\x69\144"]); goto Haae7; PLXE1: $tab0 = $model->tablename("\144\x69\163\x63\157\x75\156\164\x67\x72\157\165\x70"); goto kKSJJ; aPm23: $sts = intval($_GPC["\x73\x74\x73"]); goto cM1Ub; K3tKL: $model = Model("\x64\151\x73\x63\157\x75\x6e\x74\147\x72\x6f\x75\x70"); goto PqDW8; j7EbY: $sql .= "\x20\x41\116\104\40{$tab0}\56\163\164\x61\164\165\x73\x3d" . $sts; goto RPSh7; x2zFd: foreach ($groups["\144\141\164\141\x73\145\x74"] as $key => $val) { goto AjdGz; AjdGz: $ids = intval($val["\163\x68\157\x70\x69\x64"]) . "\x2c"; goto w1K7u; w1K7u: $groups["\x64\x61\x74\141\163\145\x74"][$key]["\163\x74\x6f\x70"] = date("\131\x2d\x6d\x2d\144\x20\x48\72\x69", $val["\x6c\x69\155\151\164\164\151\155\x65"]); goto beGNr; beGNr: $groups["\x64\x61\164\x61\163\x65\164"][$key]["\x63\162\x65\x61\164\145\x64\x61\x74\145"] = date("\131\x2d\155\55\144\x20\110\72\151", $val["\x63\x72\x65\x61\164\145\x74\151\x6d\145"]); goto u04iH; u04iH: UeSg6: goto L9dyY; L9dyY: } goto QsTeK; i41gk: } public function getTuijianKanjia() { goto sb21r; pesyP: echo JSON_OUT($result); goto NeZeJ; sb21r: global $_W, $_GPC; goto JzZN2; PqjZ1: $result = $model->query($sql); goto pesyP; GRfAC: $tab0 = $model->tablename("\147\157\x6f\x64\163"); goto QuDVg; JzZN2: $uniacid = intval($_W["\x75\x6e\151\141\x63\x69\144"]); goto u86wY; pW_OK: $now = date("\x59\x2d\155\x2d\144\40\110\x3a\x69\x3a\x73", time()); goto sKkv6; sKkv6: $sql = "\123\x45\114\105\x43\x54\40{$tab1}\56\x2a\x2c{$tab0}\x2e\x73\145\x6c\154\x43\x6f\x75\156\x74\54{$tab0}\x2e\x73\x65\x6c\x6c\103\157\165\x6e\x74\54{$tab1}\56\151\x64\x20\x61\x73\x20\144\151\x73\x63\x6f\x75\x6e\164\137\151\144\54{$tab0}\x2e\156\x61\x6d\x65\x2c{$tab0}\x2e\160\151\x63\x74\165\x72\145\x2c{$tab0}\56\x70\162\x69\x63\145\60\x2c{$tab0}\x2e\160\x72\151\143\145\54{$tab0}\56\160\x69\143\x74\165\x72\145\x5f\x77\151\144\145\x20\106\x52\x4f\115\x20{$tab1}\x20\114\105\106\x54\40\x20\x4a\117\x49\116\x20{$tab0}\40\117\x4e\x20{$tab0}\56\151\x64\x3d{$tab1}\x2e\147\x6f\x6f\x64\163\x69\144\x20\x77\150\x65\x72\145\40{$tab1}\x2e\x75\x6e\x69\x61\x63\151\144\x3d{$uniacid}\x20\141\x6e\144\x20{$tab1}\56\163\164\141\164\165\163\76\x30\40\141\x6e\144\40{$tab0}\x2e\x73\x74\x61\x74\165\x73\76\60\40\40\141\x6e\x64\x20{$tab1}\x2e\x74\171\160\x65\x3d\x35\40\141\x6e\x64\x20{$tab1}\56\163\164\141\x72\164\x74\x69\x6d\145\74\47" . $now . "\47\x20\x61\x6e\144\40{$tab1}\56\163\x74\157\160\164\x69\155\x65\76\x27" . $now . "\x27\x20\157\x72\144\x65\x72\x20\142\x79\x20{$tab1}\x2e\x73\164\157\160\x74\151\x6d\x65\40\144\145\x73\143\40\154\x69\155\151\164\40\x33\x30"; goto PqjZ1; QuDVg: $tab1 = $model->tablename("\144\151\163\x63\157\x75\x6e\164"); goto pW_OK; u86wY: $model = Model("\144\151\x73\x63\x6f\165\156\164"); goto GRfAC; NeZeJ: } }