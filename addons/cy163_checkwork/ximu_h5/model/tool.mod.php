<?php
/*   __________________________________________________
    |  Obfuscated by YAK Pro - Php Obfuscator          |
    |              on 2018-05-26 11:06:28              |
    |    GitHub: https://github.com/pk-fr/yakpro-po    |
    |__________________________________________________|
*/
 goto MaWdG; R7cPy: function handleOperation($table) { goto NJR5M; p1Dzo: wtnM8: goto hvUNe; gB2kP: if (!$ids) { goto N3dvD; } goto LNul_; QJXig: $back = array("\x6d\163\147" => "\xe5\210\240\351\x99\244\xe6\210\x90\345\x8a\237", "\x74\x79\x70\x65" => "\x73\165\143\x63\x65\x73\163"); goto p1Dzo; YkNms: if (!$result) { goto TDDed; } goto Bfcff; iLz3_: $ids[] = $_GPC["\x69\144"]; goto id64E; yVtX4: D3KE3: goto pFI9o; G2TA7: $back = array("\x6d\x73\x67" => "\346\223\215\344\275\x9c\xe5\244\xb1\xe8\xb4\xa5", "\164\171\160\145" => "\x65\x72\x72\x6f\162"); goto YkNms; Bfcff: $back = array("\x6d\x73\x67" => "\xe6\x93\215\344\xbd\x9c\346\210\x90\xe5\x8a\x9f", "\164\171\x70\145" => "\x73\x75\x63\143\x65\x73\x73"); goto us0aH; gRCzb: zKNYX: goto eciCO; Syt5M: ji02g: goto Uh4RF; LFsLR: if ($_W["\x69\x73\x70\x6f\163\x74"] && $_GPC["\x6f\x70"] == "\x73\145\164") { goto Fcu01; } goto SsbIy; UqHAa: $result = configInfo($data); goto iCdww; hvUNe: N3dvD: goto Syt5M; Jk3Vg: $back = array(); goto wy2DO; Uh4RF: return $back; goto A6w1U; esATN: if (!$result) { goto llvM0; } goto NOjcx; m321Y: ww4As: goto FxCVa; eciCO: if (!$result) { goto wtnM8; } goto QJXig; p4cG2: JVUwN: goto iLz3_; LNul_: $_delKey = $_GPC["\x73\157\146\164\137\144\145\154\137\x6b\x65\171"]; goto jCqUJ; FxCVa: $back = array("\155\163\x67" => "\xe5\210\xa0\xe9\x99\244\xe5\xa4\xb1\350\264\xa5", "\164\171\160\x65" => "\145\162\162\x6f\162"); goto gB2kP; teU8e: goto ji02g; goto fFP13; nfdhc: $ids = explode("\54", $_GPC["\x69\x64\163"]); goto m321Y; id64E: if (empty($_GPC["\x69\x64\163"])) { goto ww4As; } goto nfdhc; NbKg6: HcATI: goto U8qGj; SsbIy: if ($_GPC["\x6f\x70"] == "\x64\145\x6c") { goto JVUwN; } goto Gffpj; NOjcx: $back = array("\x6d\x73\147" => "\xe6\x93\215\344\275\x9c\xe6\x88\220\xe5\212\237", "\164\x79\x70\x65" => "\163\x75\x63\143\x65\163\x73"); goto pn62o; U8qGj: $result = dataInsertOrUpdate($table, $data); goto G2TA7; jCqUJ: if ($_delKey) { goto D3KE3; } goto xxg3z; fFP13: Fcu01: goto UqHAa; YlAFe: $back["\x72\145\144\x69\x72\145\143\164\125\162\x6c"] = parseUrlCreateNew(array("\x6f\160" => "\x73\145\164")); goto ehAf0; pn62o: llvM0: goto YlAFe; pFI9o: $result = pdo_update($table, array($_delKey => 1), array("\x69\x64" => $ids)); goto gRCzb; iCdww: $back = array("\155\163\x67" => "\346\x93\x8d\344\275\234\xe5\xa4\xb1\xe8\264\245", "\164\x79\160\145" => "\x65\162\x72\x6f\162"); goto esATN; NJR5M: global $_W, $_GPC; goto Jk3Vg; zBsCJ: goto zKNYX; goto yVtX4; xxg3z: $result = pdo_delete($table, array("\x69\x64" => $ids)); goto zBsCJ; wy2DO: $data = $_GPC["\160\157\x73\164"]; goto wye41; us0aH: TDDed: goto teU8e; wye41: if ($_W["\151\163\160\x6f\163\164"] && $_GPC["\x6f\160"] == "\145\144\151\x74") { goto HcATI; } goto LFsLR; Gffpj: goto ji02g; goto NbKg6; ehAf0: goto ji02g; goto p4cG2; A6w1U: } goto D62fK; gIv2J: function parseUrlCreateNew($params = array()) { goto Uq0Cp; Af0D_: $defaultKeys = array("\x63", "\141", "\x6d", "\x69", "\x6a", "\x65\x69\144", "\x76\x65\162\x73\151\157\156\x5f\151\144", "\x64\157"); goto m1sQX; g3bml: parse_str($parseUrlArr["\x71\165\145\x72\x79"], $queryArr); goto Af0D_; gZL9v: $parseUrlArr = parse_url($_W["\163\x69\x74\145\x75\162\x6c"]); goto g3bml; sHYOX: return $url; goto TgfWN; Hnrd_: Xd_Q1: goto Y20eF; Y20eF: $queryArr = array_merge($queryArr, $params); goto VRmVJ; Uq0Cp: global $_W; goto gZL9v; VRmVJ: $url = $parseUrlArr["\x70\141\164\x68"] . "\77" . http_build_query($queryArr); goto sHYOX; m1sQX: foreach ($queryArr as $k => $v) { goto plcS0; plcS0: if (in_array($k, $defaultKeys)) { goto zUKtb; } goto NLF24; PsY0L: MGdN8: goto BGGLK; NLF24: unset($queryArr[$k]); goto jRot_; jRot_: zUKtb: goto PsY0L; BGGLK: } goto Hnrd_; TgfWN: } goto e7mdo; SzFHY: function dataInsertOrUpdate($table, $data, $where = array()) { goto S7xBl; HTmzX: $eId = pdo_get($table, array("\151\144" => $data["\151\144"]), array("\151\x64")); goto xg1uw; S7xBl: $data = array_merge($data, array("\x75\x70\x64\141\164\145\137\x74\151\x6d\145" => time())); goto XkA0k; evOOS: $data["\x61\x64\144\137\x74\151\x6d\145"] = time(); goto v_5O6; S8o3b: Gzfmo: goto q3nBd; xnyOY: $where = array("\151\x64" => $eId); goto S8o3b; DDyUc: return pdo_update($table, $data, $where); goto pcF4D; xg1uw: if (!$eId) { goto Gzfmo; } goto xnyOY; pu_XN: if (!empty($where)) { goto IqiG1; } goto evOOS; q3nBd: HSKAW: goto pu_XN; v_5O6: return pdo_insert($table, $data); goto qbEFc; XkA0k: if (!(empty($where) && $data["\151\x64"])) { goto HSKAW; } goto HTmzX; qbEFc: IqiG1: goto DDyUc; pcF4D: } goto Bq7UA; D62fK: function formatDataList($list) { goto AkakZ; lFLvl: Jy9mX: goto EGGr0; AkakZ: foreach ($list as $k => $v) { goto fK0Iu; qmaX_: $list[$k] = $_v; goto Pb551; fK0Iu: $_v = array_merge($v, array("\x61\144\144\137\164\151\155\145" => date("\x59\55\155\x2d\144\40\110\72\151\72\x73", $v["\x61\144\x64\137\164\x69\x6d\145"]), "\165\x70\x64\x61\x74\145\x5f\164\151\x6d\x65" => date("\131\55\x6d\x2d\x64\x20\x48\72\x69\x3a\x73", $v["\165\x70\x64\x61\x74\145\x5f\164\151\x6d\x65"]), "\145\x64\151\x74\137\165\x72\x6c" => parseUrlCreateNew(array("\157\160" => "\x65\x64\x69\164", "\x69\x64" => $v["\x69\x64"])), "\x64\x65\154\x5f\x75\162\x6c" => parseUrlCreateNew(array("\x6f\160" => "\144\145\x6c", "\x69\144" => $v["\151\144"])), "\x73\x74\141\164\165\163" => $v["\x73\x74\141\164\x75\163"] ? "\xe5\xbc\200\xe5\x90\xaf" : "\345\205\263\351\227\xad")); goto qmaX_; Pb551: UmHSn: goto XE_mp; XE_mp: } goto lFLvl; EGGr0: return $list; goto FPXMZ; FPXMZ: } goto SzFHY; e7mdo: function getFillData($table) { goto hzhij; PXl1j: P2jVb: goto KXsI1; CYU_K: if (!$_GPC["\151\144"]) { goto i7s5I; } goto WNUDN; a276E: i7s5I: goto Dader; K24N7: goto ec9Oj; goto PXl1j; Dader: $_config = pdo_get("\x68\65\x5f\143\157\156\x66\151\147", array("\153\145\171" => $key), array("\143\157\156\164\145\x6e\x74")); goto eTyv3; hzhij: global $_GPC; goto qH2Ix; tWfzK: ec9Oj: goto Tc0SR; JdK4l: t3U8t: goto lDrgO; lxhiR: $data["\143\157\156\164\x65\x6e\164"] = json_decode($data["\143\157\156\164\x65\156\164"], true); goto JdK4l; qH2Ix: $data = array(); goto M35Ed; Tc0SR: return $data; goto dbvLx; UwsAR: if ($_GPC["\x6f\160"] == "\163\145\164") { goto P2jVb; } goto mtJde; e8lng: if (!$data) { goto t3U8t; } goto lxhiR; lDrgO: $data["\x6b\145\x79"] = $key; goto tWfzK; YJleH: e4U2R: goto K24N7; bvJQQ: hlfW6: goto CYU_K; KXsI1: $data = pdo_get("\x68\x35\137\x63\157\x6e\146\151\147", array("\x6b\145\x79" => $key)); goto e8lng; WNUDN: $data = pdo_get($table, array("\151\x64" => $_GPC["\151\144"])); goto a276E; wU38B: if ($_GPC["\x6f\160"] == "\x65\144\x69\164") { goto hlfW6; } goto UwsAR; eTyv3: if (!$_config) { goto e4U2R; } goto pjcks; mtJde: goto ec9Oj; goto bvJQQ; M35Ed: $key = $_GPC["\x64\x6f"] . "\x5f\163\145\x74"; goto wU38B; pjcks: $data["\137\143\x6f\156\146\x69\x67"] = json_decode($_config["\143\x6f\156\164\x65\x6e\164"], true); goto YJleH; dbvLx: } goto Ds6My; MaWdG: defined("\111\116\137\x49\x41") or die("\101\143\x63\145\x73\x73\x20\x44\x65\x6e\151\x65\x64"); goto R7cPy; Bq7UA: function configInfo($data) { goto PAPyz; f639a: $table = "\x68\x35\137\143\157\x6e\146\151\x67"; goto JGNk1; hJZ6y: $where = array(); goto CUNYI; JGNk1: if (!empty($data["\x6b\145\171"])) { goto Re78c; } goto ORG0z; PAPyz: global $_GPC; goto f639a; ORG0z: $data["\153\145\171"] = $_GPC["\144\x6f"] . "\137\163\x65\164"; goto RcbaS; RcbaS: Re78c: goto YsUXC; w771y: $eId = pdo_get($table, array("\x6b\x65\171" => $data["\153\145\171"]), array("\151\x64")); goto zJMEg; OfTpL: if (!empty($eId)) { goto G0M4U; } goto w771y; Qzm7r: return pdo_insert($table, $list); goto eiTWu; gNbbt: $list["\165\x70\x64\141\x74\x65\x5f\164\151\155\145"] = time(); goto EXx0_; zJMEg: G0M4U: goto hJZ6y; CUNYI: if (!$eId) { goto zbAAE; } goto gNbbt; jZ0vm: if (!empty($where)) { goto hncNd; } goto Gjomq; eiTWu: hncNd: goto kuv6Z; Gjomq: $list["\x61\x64\x64\x5f\x74\x69\155\x65"] = time(); goto Qzm7r; YsUXC: $data["\163\x74\x61\164\165\163"] = isset($data["\x73\x74\x61\164\x75\x73"]) ? 1 : 0; goto Mj8bP; Mj8bP: $list["\x63\157\156\x74\x65\156\164"] = json_encode($data); goto PaIXD; kuv6Z: return pdo_update($table, $list, $where); goto V2Azg; EXx0_: $where = array("\151\x64" => $eId); goto H9OEs; aFg2x: $eId = $data["\151\144"]; goto OfTpL; H9OEs: zbAAE: goto jZ0vm; PaIXD: $list["\153\145\171"] = $data["\x6b\x65\x79"]; goto aFg2x; V2Azg: } goto gIv2J; Ds6My: function createOpList($opList) { goto ZmmJ8; Dmvnb: foreach ($opList as $k => $v) { goto xkRuE; M0BvD: Ygioy: goto hSCgQ; LTRr0: $_currentOp["\x61\x63\x74\151\166\145"] = 1; goto hab7f; NDsm7: $active = 1; goto LTRr0; pAJ54: $_currentOp = array("\x74\x69\x74\x6c\x65" => $v, "\x75\x72\x6c" => $_url); goto A0Q6Y; xkRuE: $_url = parseUrlCreateNew(array_filter(array("\157\160" => $k))); goto pAJ54; XPvsw: $list[] = $_currentOp; goto M0BvD; hab7f: Qp7wW: goto XPvsw; A0Q6Y: if (!($_GPC["\x6f\160"] == (string) $k)) { goto Qp7wW; } goto NDsm7; hSCgQ: } goto pSjOC; pSjOC: iE4BC: goto gomKL; offLx: $active = 0; goto nYxnf; XC7p8: return $list; goto v4XTY; gomKL: if (!empty($active)) { goto z_ZPd; } goto HyPmm; nYxnf: $list = array(); goto Dmvnb; ZmmJ8: global $_GPC; goto offLx; NJBy4: z_ZPd: goto XC7p8; HyPmm: $list[0]["\x61\143\164\x69\x76\x65"] = 1; goto NJBy4; v4XTY: }