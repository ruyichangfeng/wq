<?php
 goto c1CqH; c1CqH: ?>
 <?php  goto tiDsx; tiDsx: class Homeadvert extends ZskPage { public function index() { goto txcYa; NZ11U: $mods = $model->order("\163\x6f\x72\164\40\x61\163\143")->where("\x75\156\151\141\143\x69\144\75{$uniacid}")->getall("\52\x2c\x70\x61\162\145\156\x74\151\144\40\x61\163\x20\160\151\144"); goto GhrNh; DSPYw: jbbYW: goto krh31; f_Yyy: $model = Model("\x67\157\157\x64\163"); goto whBxT; krh31: MBqwf: goto cqMPA; hEoFv: foreach ($mods as $key => $val) { goto fc3dC; R9w3x: sQo2v: goto pAvIg; fc3dC: foreach ($goodslist as $k2 => $goods) { goto sRzsC; wOXJ1: $mods[$key]["\160\151\x63\164\x75\x72\145"] = $goods["\x70\x69\x63\164\165\162\145"]; goto lAQ56; sRzsC: if (!(intval($val["\x70\x61\162\145\156\x74\x69\x64"]) > 0 && $val["\x6a\x75\155\160\x74\171\160\145"] == "\x67\157\157\x64\163" && $val["\x67\157\x6f\144\163\x6e\x75\155"] == $goods["\x6e\x75\155\142\x65\x72"])) { goto BlTWw; } goto AgLwS; HGWR1: if (!(strlen($val["\x70\151\x63\x74\165\x72\x65"]) < 5)) { goto N3WXp; } goto wOXJ1; lAQ56: N3WXp: goto hGdL8; hGdL8: BlTWw: goto EFmav; EFmav: ZZUse: goto BNes4; AgLwS: $mods[$key]["\164\x69\x74\x6c\145"] = "\x5b" . $goods["\156\x75\155\x62\x65\162"] . "\x5d\40" . $goods["\156\x61\155\145"]; goto HGWR1; BNes4: } goto SmaX0; SmaX0: hhTVW: goto R9w3x; pAvIg: } goto DSPYw; whBxT: $goodslist = $model->where("\156\165\155\142\145\x72\40\151\156\x20\50{$gids}\51")->getall("\151\144\54\x6e\165\155\x62\x65\162\x2c\156\x61\155\x65\x2c\x70\x69\x63\164\165\162\x65"); goto hEoFv; cqMPA: $mods = childtree($mods); goto FHje3; xPcsc: $uniacid = intval($_W["\165\x6e\151\141\143\x69\144"]); goto MBmni; PeAZj: foreach ($mods as $k => $v) { goto MazhP; pLzjT: mwNNT: goto Ly3fD; liFmB: Heqtc: goto pLzjT; YVJ3m: switch ($v["\x6a\x75\155\160\164\171\x70\x65"]) { case "\x67\x6f\157\x64\x73": goto Hq5qB; rQdKc: goto sgUgA; goto mOpRr; HsIQE: $gids .= $v["\x67\157\x6f\x64\x73\156\165\x6d"] . "\x2c"; goto rQdKc; Hq5qB: $mods[$k]["\x74\x79\160\145\x6e\x61\155\x65"] = "\xe5\x95\206\xe5\223\x81\350\xaf\246\346\203\205"; goto HsIQE; mOpRr: case "\x63\141\x74\145": $mods[$k]["\164\171\160\145\x6e\141\x6d\145"] = "\xe5\210\206\347\xb1\xbb\345\225\206\xe5\x93\x81\345\x88\227\350\xa1\xa8"; goto sgUgA; case "\164\x6f\160\151\143": $mods[$k]["\x74\x79\160\x65\x6e\141\x6d\x65"] = "\xe6\xb4\273\345\x8a\xa8\344\xb8\x93\351\242\230"; goto sgUgA; default: $mods[$k]["\164\x79\x70\x65\156\141\155\145"] = "\344\270\x8d\350\267\263\350\xbd\254"; goto sgUgA; } goto zLg2s; KO8Uq: sgUgA: goto QlODB; zLg2s: VbehY: goto KO8Uq; Ly3fD: if (!(intval($v["\x70\141\162\x65\156\x74\x69\x64"]) > 0)) { goto OqtLU; } goto YVJ3m; QlODB: OqtLU: goto wGr1y; MazhP: switch ($v["\x74\171\x70\145"]) { case "\x73\167\151\160\x65\x72": $mods[$k]["\164\x79\160\145\x6e\141\155\x65"] = "\350\275\256\346\222\255\345\233\276"; goto mwNNT; case "\141\x64\x76\x65\x72\x74": $mods[$k]["\x74\x79\160\145\156\141\155\145"] = "\345\x9b\xbe\347\211\x87"; goto mwNNT; case "\x73\x65\141\x72\143\x68": $mods[$k]["\164\x79\x70\145\156\x61\155\145"] = "\346\x90\x9c\xe7\264\xa2\346\214\x89\xe9\222\xae"; goto mwNNT; case "\x63\157\x75\x70\x6f\156": $mods[$k]["\x74\171\160\x65\x6e\141\155\145"] = "\xe4\xbc\230\xe6\x83\xa0\xe5\x88\270\x20"; goto mwNNT; case "\156\141\x76\x62\141\x72": $mods[$k]["\x74\x79\160\145\x6e\141\x6d\145"] = "\345\xaf\274\xe8\x88\252\xe6\xa0\217"; goto mwNNT; case "\x67\157\x6f\144\x73": $mods[$k]["\164\171\x70\145\x6e\x61\155\x65"] = "\345\x95\x86\xe5\223\201\xe5\x88\227\350\241\xa8"; goto mwNNT; case "\x68\x6f\164\x67\x6f\157\x64\163": $mods[$k]["\164\x79\x70\x65\156\141\x6d\145"] = "\345\225\x86\xe5\x93\x81\xe5\x88\206\351\241\xb5"; goto mwNNT; case "\156\157\x74\x69\x63\145": $mods[$k]["\x74\171\160\x65\156\141\155\x65"] = "\345\205\254\345\221\212"; goto mwNNT; default: goto mwNNT; } goto liFmB; wGr1y: wy0vq: goto rxE72; rxE72: } goto wOoyU; byWqg: if (!(strlen($gids) > 1)) { goto MBqwf; } goto xxy8P; txcYa: global $_W, $_GPC; goto xPcsc; FHje3: include $this->template("\x77\145\x62\x2f\150\x6f\x6d\145\57\154\141\171\x6f\165\164"); goto ifwkG; GhrNh: $gids = ''; goto PeAZj; wOoyU: ZFuwJ: goto byWqg; MBmni: $model = Model("\x68\157\155\145\141\x64\x76\145\x72\164"); goto NZ11U; xxy8P: $gids = substr($gids, 0, strlen($gids) - 1); goto f_Yyy; ifwkG: } public function edit0() { goto gsKhe; eYPOs: $aid = intval($_GPC["\141\151\144"]); goto hmlw3; X7ZsS: include $this->template("\x77\145\142\57\150\x6f\x6d\145\x2f\141\144\x76\x65\x72\164\55\145\144\151\164\x30"); goto UA8Pj; hmlw3: $advert = $model->where("\165\x6e\x69\x61\x63\x69\x64\75{$uniacid}\x20\x61\x6e\144\x20\x69\144\x3d{$aid}")->get(); goto X7ZsS; gsKhe: global $_W, $_GPC; goto sVSmM; kqQTn: $model = Model("\x68\157\155\x65\x61\x64\166\x65\x72\164"); goto eYPOs; sVSmM: $uniacid = intval($_W["\x75\x6e\x69\141\143\151\x64"]); goto kqQTn; UA8Pj: } public function edit1() { goto VgWOu; t0tHT: $advert = $model->where("\165\156\151\141\143\x69\x64\x3d{$uniacid}\x20\141\x6e\144\x20\151\x64\75{$aid}")->get(); goto XJ3wv; F9cCe: $uniacid = intval($_W["\x75\156\x69\x61\x63\x69\x64"]); goto LbigY; XJ3wv: $pid = intval($_GPC["\160\x69\144"]); goto aKboj; RGlwi: include $this->template("\x77\145\142\x2f\150\157\x6d\145\57\141\x64\166\145\x72\x74\x2d\145\x64\151\x74\61"); goto cW_8X; VgWOu: global $_W, $_GPC; goto F9cCe; XuIn3: $aid = intval($_GPC["\x61\151\144"]); goto t0tHT; WfFL7: $topics = Model("\x74\157\160\151\x63")->order("\x60\144\141\164\x65\x60\x20\x64\145\x73\x63")->where("\x75\156\x69\x61\x63\151\144\x3d{$uniacid}")->limit(500)->getall(); goto RGlwi; aKboj: $parent = $model->where("\165\156\x69\x61\143\x69\x64\x3d{$uniacid}\40\x61\156\144\x20\x69\144\75{$pid}")->get(); goto mtua5; LbigY: $model = Model("\x68\157\155\145\141\x64\166\145\x72\164"); goto XuIn3; vSu_3: $cates = childtree($cates); goto WfFL7; mtua5: $cates = Model("\143\x61\x74\x65\x67\157\162\x79")->where("\165\156\x69\141\x63\151\144\75{$uniacid}")->getall("\x2a\x2c\160\141\162\145\x6e\164\151\x64\x20\x61\x73\x20\x70\x69\x64"); goto vSu_3; cW_8X: } public function listview() { goto fbg6P; k0QZu: $cates = childtree($res); goto O4iLH; HSstV: $where .= "\40\x61\x6e\x64\40\156\141\155\145\x20\154\x69\153\145\x20\x27\x25" . $name . "\x25\x27"; goto Y1wJU; fHRRH: if (!strlen($name)) { goto CFK1y; } goto HSstV; htrM3: foreach ($res as $key => $val) { goto Z4haz; YuD81: if (intval($val["\151\x6e\x64\x65\x78\x50\154\141\171"]) == 1) { goto Rz0Ck; } goto bw1Id; bw1Id: $res[$key]["\x69\160\x6c\141\171"] = "\x3c\163\160\141\156\x20\163\164\171\x6c\145\x3d\x22\x63\157\154\157\162\x3a\x23\71\x39\71\x3b\42\76\346\x97\xa0\74\x2f\163\x70\x61\156\x3e"; goto qpkH2; kYbDl: Rz0Ck: goto Zlo3g; nkr3N: $res[$key]["\x73\x74\163"] = "\74\163\x70\141\x6e\x20\x73\164\x79\x6c\x65\75\x22\x63\x6f\154\157\x72\x3a\43\62\x32\x42\61\x34\x43\x3b\x22\x3e\345\220\257\xe7\x94\xa8\x3c\x2f\163\160\x61\x6e\x3e"; goto BMbhN; Z4haz: if (intval($val["\x73\164\x61\x74\165\163"]) > 0) { goto AeRVL; } goto GOqtE; jwKaj: AeRVL: goto nkr3N; fkYaT: $res[$key]["\163\x72\143"] = $_W["\141\x74\x74\x61\143\150\x75\162\154"] . $val["\154\x6f\x67\157"]; goto NJkdZ; Zlo3g: $res[$key]["\x69\x70\x6c\x61\x79"] = "\x3c\163\x70\141\x6e\x20\x73\164\171\154\x65\x3d\42\143\x6f\x6c\x6f\x72\x3a\x23\x30\x30\101\x32\105\70\73\x22\x3e\xe6\216\250\350\215\x90\x3c\x2f\x73\160\x61\x6e\x3e"; goto FVkwP; FVkwP: XM09t: goto fkYaT; BMbhN: C8Wty: goto YuD81; GOqtE: $res[$key]["\x73\x74\x73"] = "\74\163\x70\x61\x6e\40\x73\x74\x79\154\x65\75\x22\143\157\154\x6f\x72\x3a\43\71\x39\x39\73\42\x3e\347\xa6\x81\347\224\xa8\74\x2f\163\x70\141\156\76"; goto mo3JX; NJkdZ: nZBDh: goto LsmGx; mo3JX: goto C8Wty; goto jwKaj; qpkH2: goto XM09t; goto kYbDl; LsmGx: } goto vciTi; BEFGh: $where = "\x75\x6e\151\141\x63\151\144\x3d{$uniacid}"; goto fHRRH; RYWTO: $model = Model("\143\141\x74\145\x67\157\162\171"); goto b0e36; RcBPk: $uniacid = intval($_W["\x75\156\151\x61\x63\151\x64"]); goto RYWTO; b0e36: $name = trim($_GPC["\156\141\155\x65"]); goto BEFGh; yWBJv: $res = $model->where("\165\156\x69\x61\x63\x69\x64\x3d{$uniacid}")->getall("\52\x2c\x70\141\x72\145\156\164\x69\144\x20\x61\163\x20\160\x69\144"); goto htrM3; Y1wJU: $params["\x6e\141\155\x65"] = $name; goto sNaDX; O4iLH: include $this->template("\x77\x65\142\x2f\x63\141\x74\x65\x2f\x63\141\x74\x65\55\154\151\163\164"); goto O0_8j; fbg6P: global $_W, $_GPC; goto RcBPk; vciTi: XnjL6: goto k0QZu; sNaDX: CFK1y: goto yWBJv; O0_8j: } public function saveAdvert() { goto xA1Ne; N0NCn: goto lE0L3; goto PbjEX; rmKse: $aid = intval($_GPC["\141\x69\144"]); goto s7H6n; C10T8: goto WnjBX; goto NFzub; nRc3W: PCCvM: goto TmG1E; WLSQz: ke9Y2: goto K_S7g; n9Bwl: $model->add($advert); goto n36eS; wwsj6: $model = Model("\150\x6f\155\x65\x61\144\166\x65\x72\164"); goto YUH1d; s7H6n: $advert = array("\165\x6e\x69\141\143\x69\x64" => $uniacid, "\x70\141\x72\x65\156\164\x69\144" => $pid, "\x74\151\164\x6c\x65" => trim($_POST["\156\x61\155\145"]), "\163\157\162\x74" => intval($_POST["\x73\x6f\162\x74"]), "\x74\171\x70\x65" => trim($_GPC["\164\x79\160\x65"]), "\152\165\x6d\160\x74\x79\x70\x65" => trim($_GPC["\x6a\165\x6d\160\164\171\160\x65"]), "\x73\x74\x61\x74\x75\x73" => intval($_POST["\x73\x74\163"]), "\160\x69\143\164\165\162\x65" => trim($_POST["\x70\151\143\x74\165\162\145"]), "\147\157\x6f\144\x73\x6e\165\x6d" => intval($_GPC["\147\x6f\x6f\144\163\x6e\x75\x6d"]), "\x63\141\164\x65\151\144" => intval($_GPC["\143\x61\x74\145\151\x64"]), "\x74\x6f\160\x69\143\151\x64" => intval($_GPC["\164\x6f\160\151\x63\x69\x64"]), "\x72\157\x77\x73\x69\172\145" => intval($_GPC["\x72\x6f\x77\163\151\x7a\145"]), "\151\163\x64\x65\146\x61\x75\154\x74" => intval($_GPC["\x64\x65\146\141\165\154\164"]), "\x63\157\x6e\164\x65\156\164" => $_GPC["\x63\157\x6e\x74\x65\x6e\x74"], "\163\150\157\x77\x74\151\x74\x6c\145" => intval($_GPC["\x73\150\x6f\x77\164\x69\x74\x6c\145"])); goto UzVQy; PbjEX: mYqrD: goto Ml7Hr; NFzub: hqawi: goto rkNvT; fc1Oz: lE0L3: goto DztWY; UzVQy: if (!(intval($_GPC["\147\157\x6f\144\163\x6e\165\155"]) > 0)) { goto BrGyg; } goto kxeJo; dLZwJ: if ($size < 1 || $size > 5) { goto mYqrD; } goto v4IN0; l3jrY: $model->where("\x75\156\151\141\143\x69\144\75{$uniacid}\40\x61\156\x64\x20\x69\144\75{$aid}")->save($advert); goto nRc3W; DztWY: if ($aid > 0) { goto EO4Wm; } goto n9Bwl; v4IN0: $advert["\162\x6f\167\163\151\x7a\x65"] = $size; goto N0NCn; YUH1d: $pid = intval($_POST["\x70\x69\144"]); goto rmKse; utU22: $hei = floatval($_GPC["\162\x6f\x77\150\145\x69\147\150\x74"]); goto T8P8k; T8P8k: if ($hei < 0.1 || $hei > 1) { goto hqawi; } goto iAt43; kxeJo: $sts = Model("\x67\x6f\x6f\x64\163")->exist("\x6e\x75\155\x62\145\x72\x3d\47" . $_GPC["\147\157\x6f\x64\163\156\165\x6d"] . "\x27"); goto QUTp0; TmG1E: message("\xe4\xbf\x9d\xe5\xad\230\xe6\x88\220\xe5\212\x9f", $this->routeUrl("\x68\157\x6d\145\x61\144\166\x65\x72\x74\x2e\x69\x6e\x64\x65\170")); goto FO2ul; rkNvT: $advert["\x72\x6f\167\150\x65\x69\147\150\164"] = 0.5; goto wXZcT; Ml7Hr: $advert["\x72\x6f\167\163\151\x7a\x65"] = 1; goto fc1Oz; iAt43: $advert["\x72\157\x77\x68\x65\151\x67\150\164"] = $hei; goto C10T8; wXZcT: WnjBX: goto nCjb9; QUTp0: if ($sts) { goto ke9Y2; } goto JpXh1; zQjJt: EO4Wm: goto l3jrY; nCjb9: $size = intval($_GPC["\162\157\167\163\151\x7a\145"]); goto dLZwJ; JpXh1: message("\345\225\206\xe5\223\x81\347\xbc\226\345\x8f\xb7\xe9\x94\x99\xe8\xaf\xaf"); goto WLSQz; xA1Ne: global $_W, $_GPC; goto mDlb3; n36eS: goto PCCvM; goto zQjJt; K_S7g: BrGyg: goto utU22; mDlb3: $uniacid = intval($_W["\x75\156\x69\141\143\x69\x64"]); goto wwsj6; FO2ul: } public function editview() { goto an1xz; SQCLt: if (!(intval($cate["\160\x61\x72\x65\156\164\x69\144"]) > 0)) { goto zw2bO; } goto KmZnf; rUJdH: $uniacid = intval($_W["\165\156\x69\141\143\x69\x64"]); goto Akzc6; erFgh: exit; goto Yeap6; J1O43: $parent = "\344\270\x80\xe7\xba\xa7\xe5\210\x86\xe7\261\273"; goto SQCLt; PnPrw: $cate = $model->where("\151\x64\75" . $cid . "\x20\x61\x6e\144\40\x75\x6e\x69\x61\143\151\x64\x3d{$uniacid}")->get("\x2a"); goto J1O43; yDxGE: $cid = intval($_GPC["\x63\151\x64"]); goto PnPrw; an1xz: global $_W, $_GPC; goto rUJdH; dC_m3: zw2bO: goto fWHmT; fWHmT: include $this->template("\x77\x65\142\57\x63\141\x74\x65\x2f\143\141\164\145\x2d\145\144\151\164"); goto erFgh; Akzc6: $model = Model("\143\x61\x74\x65\147\x6f\x72\x79"); goto yDxGE; B5cPU: $parent = $name["\156\x61\x6d\x65"]; goto dC_m3; KmZnf: $name = $model->where("\x69\144\75" . intval($cate["\160\x61\162\145\x6e\x74\151\x64"]) . "\40\141\156\144\40\x75\x6e\151\141\143\x69\x64\75{$uniacid}")->get("\x2a"); goto B5cPU; Yeap6: } public function manage() { goto kwTO3; kwTO3: global $_W, $_GPC; goto WjGQ9; ijR5W: $pid = intval($_GPC["\x70\151\x64"]); goto ejA78; c3xW6: include $this->template("\167\x65\142\57\x68\157\155\x65\x2f\x6c\x61\171\x6f\165\x74\55\x63\x68\151\154\x64\x72\145\156"); goto mNIyv; VBcYn: $model = Model("\150\x6f\x6d\145\x61\144\166\145\x72\164"); goto ijR5W; WjGQ9: $uniacid = intval($_W["\x75\156\x69\141\143\151\144"]); goto VBcYn; ejA78: $parent = $model->where("\x75\x6e\x69\x61\143\x69\x64\x3d{$uniacid}\40\141\156\144\40\151\x64\75{$pid}")->get(); goto c3xW6; mNIyv: } public function chgStatus() { goto H_sFL; lRpkt: $res = $model->where("\x75\156\x69\141\143\x69\144\75{$uniacid}\40\x61\156\x64\x20\x69\x64\75{$aid}\40")->limit(1)->save(array("\163\x74\141\164\x75\163" => $sts)); goto MNEFx; VEOvd: $aid = intval($_GPC["\x61\151\144"]); goto xGw2J; H_sFL: global $_W, $_GPC; goto Jtd1O; Jtd1O: $uniacid = intval($_W["\165\x6e\151\141\143\x69\144"]); goto W_ieJ; W_ieJ: $model = Model("\x68\x6f\x6d\145\141\x64\166\145\x72\164"); goto VEOvd; xGw2J: $sts = intval($_GPC["\163\164\x61\164\x75\163"]); goto lRpkt; MNEFx: message("\xe4\xbf\xae\346\x94\xb9\346\x88\x90\xe5\x8a\237", $this->routeUrl("\150\157\155\x65\x61\144\x76\145\x72\x74\56\x69\156\x64\x65\170")); goto g9rsj; g9rsj: } public function delAdvert() { goto mp63b; Y9TSK: $uniacid = intval($_W["\x75\x6e\151\x61\143\x69\x64"]); goto iDtCn; zE9XJ: $res = $model->where("\165\x6e\x69\141\x63\x69\x64\x3d{$uniacid}\x20\x61\156\x64\x20\x69\144\75{$aid}\40")->limit(1)->delete(); goto bLKkf; iDtCn: $model = Model("\150\x6f\x6d\x65\x61\144\166\x65\x72\x74"); goto XDeKv; mp63b: global $_W, $_GPC; goto Y9TSK; bLKkf: message("\345\210\xa0\351\x99\xa4\346\x88\x90\345\212\x9f", $this->routeUrl("\x68\157\155\145\141\144\x76\145\162\164\x2e\x69\x6e\144\x65\170")); goto jLqtk; XDeKv: $aid = intval($_GPC["\x61\x69\x64"]); goto zE9XJ; jLqtk: } } goto Khcfs; Khcfs: ?>