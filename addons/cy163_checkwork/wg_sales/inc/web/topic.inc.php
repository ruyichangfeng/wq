<?php
/*   __________________________________________________
    |  Obfuscated by YAK Pro - Php Obfuscator          |
    |              on 2018-08-04 11:37:59              |
    |    GitHub: https://github.com/pk-fr/yakpro-po    |
    |__________________________________________________|
*/
 class Wg_sales_Web_Topic extends SalesBaseController { public static $PAGE_SIZE = 10; public function init() { goto Pr3j3; rf9Of: $this->uid = $this->site->_W["\165\x6e\x69\x61\x63\x69\144"]; goto F8iwH; OSobw: $this->site->loadmodule("\164\157\160\x69\x63\154\151\x73\164\115\x6f\144\165\154\145"); goto BBbYF; Pr3j3: parent::init(); goto rf9Of; gzxJ1: $this->site->loadmodule("\x74\157\x70\151\143\x4d\x6f\x64\165\x6c\145"); goto OSobw; F8iwH: $this->site->loadmodule("\143\x61\164\145\x67\x6f\162\171\x4d\x6f\x64\165\x6c\x65"); goto dZc6M; dZc6M: $this->site->loadmodule("\141\x72\x74\x69\x63\154\145\x4d\x6f\x64\x75\x6c\x65"); goto gzxJ1; BBbYF: } public function index() { goto C0QBr; C0QBr: $list = $this->site->topicModule->getList(["\165\156\x69\x61\143\151\x64" => $this->uid], "\x64\x69\x73\x70\x6c\x61\171\137\157\162\x64\x65\x72\x20\x61\x73\143"); goto cqOce; cqOce: $data["\154\151\163\x74"] = $list; goto gGGHj; gGGHj: $this->site->assign($data); goto HdRzJ; HdRzJ: } public function edit() { goto k6mJP; JKtY6: $re = $this->site->topicModule->update(["\x75\156\x69\141\x63\151\x64" => $this->uid, "\x69\x64" => $id], $save); goto SYW8j; AFvmi: ll8_N: goto j1fL8; But0B: $data["\164\157\160\151\x63"] = $this->site->topicModule->getOne(["\165\x6e\151\x61\143\x69\144" => $this->uid, "\x69\144" => $id]); goto b4rbK; Kz63p: ZYMHI: goto vQAYA; EJN8B: if (!$this->site->ispost()) { goto mKp7N; } goto TUzQ1; XZdgk: if (!($save["\164\151\x74\x6c\145"] == '' || trim($_POST["\x70\x69\143"]) == '')) { goto ZYMHI; } goto rFJzp; mqH_m: $re = $this->site->topicModule->add($save); goto k9FSi; xf6xn: message("\xe4\xbf\235\345\xad\230\345\244\xb1\xe8\xb4\xa5"); goto dUvtE; YROQF: $save = ["\164\x79\160\x65" => 0, "\x75\156\x69\x61\143\x69\x64" => $this->uid, "\x74\151\164\x6c\145" => trim($_POST["\x74\151\x74\154\x65"]), "\151\155\x61\147\x65" => json_encode($image_one), "\x74\x65\x78\164" => trim($_POST["\164\x65\x78\164"]), "\144\151\163\160\x6c\x61\x79\137\x6f\x72\x64\x65\x72" => intval($_POST["\144\x69\163\160\x6c\x61\171\137\157\162\x64\145\162"]), "\x63\162\145\x61\164\x65\x5f\164\151\x6d\145" => time()]; goto XZdgk; k6mJP: $id = intval($this->site->_GPC["\x69\x64"]); goto EJN8B; dUvtE: goto nM1t7; goto AFvmi; vQAYA: if ($id) { goto fcC_O; } goto mqH_m; lx7Vg: if ($re) { goto ll8_N; } goto xf6xn; k9FSi: goto J4qxc; goto GjYFo; GjYFo: fcC_O: goto JKtY6; HFYEl: $this->site->assign($data); goto ImZvj; b4rbK: $images = @json_decode($data["\x74\157\x70\x69\143"]["\x69\155\x61\147\x65"], true)[0]; goto MtjmZ; j1fL8: message("\xe4\xbf\235\xe5\xad\x98\xe6\210\x90\345\212\237", $this->site->webUrl("\164\157\160\151\143")); goto zLEBG; NsMfD: mKp7N: goto hwgKV; CFxog: Yc1h3: goto B8caE; TUzQ1: $image_one[] = ["\165\x72\154" => trim($_POST["\x70\151\143"])]; goto rAFnN; MtjmZ: $data["\x74\157\x70\151\143"]["\x69\x6d\x61\x67\145"] = $this->site->formatArrImage($images)["\x75\x72\154"]; goto CFxog; SYW8j: J4qxc: goto lx7Vg; zLEBG: nM1t7: goto NsMfD; rFJzp: message("\346\240\x87\351\242\230\xe6\x88\x96\xe5\x9b\276\xe7\211\x87\344\270\215\xe8\x83\275\xe4\xb8\272\xe7\xa9\xba"); goto Kz63p; rAFnN: $id = intval($_POST["\151\x64"]); goto YROQF; B8caE: $data["\141\162\164\x69\143\154\x65\x5f\x74\x79\x70\145"] = $this->site->article_type; goto HFYEl; hwgKV: if (!$id) { goto Yc1h3; } goto But0B; ImZvj: } public function topiclist() { goto zKt_2; nESBL: $this->site->assign($data); goto JW_Qc; nivM1: $list = $this->site->topiclistModule->getList(["\x74\157\x70\151\143\137\151\x64" => $id], "\x64\x69\163\x70\154\141\171\137\x6f\162\x64\145\162\x20\x61\163\143"); goto TWddy; AN40G: VLG9t: goto nivM1; TWddy: $data["\154\x69\163\164"] = $list; goto nESBL; zKt_2: $id = intval($this->site->_GPC["\151\144"]); goto MS5oH; seRmA: message("\344\270\223\351\xa2\x98\344\270\215\xe5\255\230\345\234\xa8"); goto AN40G; QTl8c: if ($data["\164\x6f\x70\x69\x63"]) { goto VLG9t; } goto seRmA; MS5oH: $data["\x74\x6f\x70\151\143"] = $this->site->topicModule->getOne(["\165\x6e\x69\141\x63\x69\144" => $this->uid, "\151\x64" => $id]); goto QTl8c; JW_Qc: } public function listadd() { goto MwTuS; K5zlc: $id = intval($_POST["\151\144"]); goto ffGTc; rlNF1: if (!($save["\x6a\165\155\160"] == 1 && $save["\165\162\154"] == '')) { goto Z3AcG; } goto hNMom; ex3ta: $data["\141\x72\164\x69\143\154\x65"]["\151\155\141\147\145"] = $new_image; goto E1TPS; K4SVx: if (!$id) { goto NPYMW; } goto UQxu2; XORXw: $new_image = []; goto yKGdQ; cMEMU: Z3AcG: goto OlSaH; M8wL6: $data["\164\x79\160\x65"] = $this->site->article_type; goto ft1MH; ffGTc: $save = ["\x63\141\x74\x65\x67\x6f\x72\171\x5f\151\x64" => intval($_POST["\143\141\x74\x65\147\157\162\171\x5f\x69\144"]), "\164\157\160\151\143\x5f\151\x64" => $topic_id, "\164\x79\x70\x65" => intval($_POST["\x74\171\160\x65"]), "\x61\162\164\x69\143\x6c\x65\x5f\151\x64" => intval($_POST["\141\162\164\151\143\x6c\145\x5f\x69\144"]), "\151\x6d\141\147\x65" => json_encode($image), "\165\x72\x6c" => trim($_POST["\x75\x72\x6c"]), "\153\x77" => trim($_POST["\153\167"]), "\x6a\165\x6d\x70" => intval($_POST["\152\165\x6d\160"]), "\x74\x69\x74\154\x65" => trim($_POST["\164\151\x74\x6c\x65"]), "\x63\162\x65\141\x74\145\x5f\164\x69\155\145" => time(), "\144\x69\x73\160\x6c\x61\171\137\157\x72\144\x65\x72" => intval($_POST["\x64\151\163\160\154\x61\x79\x5f\157\162\144\x65\x72"])]; goto cpW7C; bVFCg: $article = $this->site->articleModule->getOne($save["\x63\141\164\145\x67\x6f\162\171\x5f\151\x64"], ["\x69\x64" => $save["\141\x72\164\151\x63\x6c\145\x5f\x69\x64"]], ["\151\x64", "\x74\171\160\145"]); goto fzjPq; iB6OV: message("\xe6\x96\x87\347\xab\xa0\x49\104\344\xb8\x8d\xe8\x83\xbd\xe4\xb8\272\xe7\251\xba"); goto ToK0V; E1TPS: if ($data["\141\x72\164\x69\x63\x6c\145"]) { goto EQJsA; } goto MxE04; vRuZ9: message("\xe6\226\x87\xe7\xab\240\x49\x44\345\257\271\345\272\224\347\x9a\x84\346\x96\x87\xe7\xab\xa0\xe4\270\x8d\xe5\xad\x98\345\x9c\250"); goto VLalJ; XeGxs: giH5H: goto rlNF1; yKGdQ: if (!$images) { goto dEU0K; } goto Qdmrx; jiEP2: message("\xe4\xbf\x9d\345\xad\230\346\210\220\xe5\212\x9f", $this->site->webUrl("\x74\x6f\x70\151\143", ["\x5f\x77\x67" => "\164\x6f\x70\151\143\x6c\x69\163\x74", "\x69\x64" => $topic_id])); goto KDoG2; NMi4i: PBI7c: goto K4SVx; BdRup: message("\xe4\270\223\351\xa2\230\xe4\xb8\x8d\345\xad\230\xe5\234\250"); goto zW0hz; KDoG2: u7dFH: goto NMi4i; U2eI4: $re = $this->site->topiclistModule->update(["\x69\x64" => $id], $save); goto cTMGn; zV4Ua: Zfk6l: goto G2nSS; ZAwoG: Q3MZC: goto K5zlc; Zndrh: foreach ($_POST["\x70\x69\x63"] as $k => $im) { goto ynfdR; m7AMh: LG3qc: goto UCA91; g1qCP: eisQz: goto uHxYs; qW2Ic: AJsh6: goto m7AMh; ynfdR: if (!$im) { goto eisQz; } goto AHNgu; uHxYs: if (!(count($image) > 2)) { goto AJsh6; } goto y5GPV; y5GPV: goto g9F1d; goto qW2Ic; AHNgu: $image[] = ["\x75\162\154" => $this->site->formatArrImage(["\165\162\x6c" => $im])["\x75\162\x6c"]]; goto g1qCP; UCA91: } goto MM48M; cpW7C: if (!($save["\164\x69\164\154\x65"] == '')) { goto giH5H; } goto at41O; b40aj: if ($data["\x74\x6f\160\151\143"]) { goto pycE7; } goto BdRup; uAOX8: if (!$this->site->ispost()) { goto PBI7c; } goto C13W2; Fz3eL: pd_2D: goto U2eI4; XMT1j: xgLoE: goto CwSDH; OlSaH: if (!($save["\x6a\x75\155\x70"] == 0)) { goto xgLoE; } goto TrIxU; DRCrx: message("\xe4\277\x9d\345\xad\x98\345\244\261\xe8\xb4\xa5"); goto HrMaF; fzjPq: if ($article) { goto EyBvr; } goto vRuZ9; Qdmrx: foreach ($images as $im) { $new_image[]["\165\162\154"] = $this->site->formatArrImage($im)["\165\x72\154"]; MqNU7: } goto zV4Ua; ft1MH: $this->site->assign($data); goto kDEYN; at41O: message("\xe6\xa0\x87\xe9\242\230\xe4\270\215\xe8\x83\xbd\344\xb8\272\347\251\xba"); goto XeGxs; xa5lO: $data["\143\141\164\145"] = $this->site->categoryModule->getAllCategory(["\165\156\151\141\x63\x69\144" => $this->uid, "\144\x65\154" => 0]); goto uAOX8; G2nSS: dEU0K: goto ex3ta; UQxu2: $data["\x61\162\x74\x69\x63\x6c\x65"] = $this->site->topiclistModule->getOne(["\x69\x64" => $id, "\x74\157\160\x69\x63\137\x69\144" => $topic_id]); goto ZqL_o; TrIxU: if (!($save["\141\x72\164\151\x63\x6c\x65\137\x69\x64"] <= 0)) { goto AnQNA; } goto iB6OV; cl21h: if ($re) { goto j5Cz3; } goto DRCrx; MxE04: message("\xe6\226\207\347\253\240\xe4\270\215\345\255\x98\345\x9c\250"); goto RHsy0; zW0hz: pycE7: goto xa5lO; ToK0V: AnQNA: goto bVFCg; HrMaF: goto u7dFH; goto v2qN9; VLalJ: EyBvr: goto Ek0MU; hNMom: message("\x75\x72\x6c\344\270\x8d\350\x83\xbd\xe4\270\272\347\xa9\xba"); goto cMEMU; JcMMC: if (!$_POST["\x70\x69\x63"]) { goto Q3MZC; } goto Zndrh; u8ZRe: $topic_id = intval($this->site->_GPC["\164\157\160\151\143\137\151\144"]); goto cujTK; C13W2: $image = []; goto JcMMC; Ek0MU: $save["\164\171\160\x65"] = $article["\x74\x79\x70\145"]; goto XMT1j; xFEdN: goto v1CBV; goto Fz3eL; v2qN9: j5Cz3: goto jiEP2; cujTK: $data["\164\x6f\160\151\x63"] = $this->site->topicModule->getOne(["\x75\x6e\151\x61\x63\x69\x64" => $this->uid, "\x69\144" => $topic_id]); goto b40aj; sLAzN: NPYMW: goto M8wL6; RHsy0: EQJsA: goto sLAzN; MwTuS: $id = intval($this->site->_GPC["\x69\x64"]); goto u8ZRe; hDKkl: $re = $this->site->topiclistModule->add($save); goto xFEdN; MM48M: g9F1d: goto ZAwoG; ZqL_o: $images = @json_decode($data["\141\162\x74\151\x63\x6c\145"]["\151\155\141\147\x65"], true); goto XORXw; CwSDH: if ($id) { goto pd_2D; } goto hDKkl; cTMGn: v1CBV: goto cl21h; kDEYN: } public function del() { goto x9MpQ; PuodI: dDy0u: goto PkEJv; x9MpQ: $id = intval($_POST["\151\144"]); goto Nk5mY; Bed8S: goto dzbXe; goto PuodI; PkEJv: echo json_encode(["\143\157\x64\145" => 0]); goto ifpfP; bXjR7: exit; goto qog0C; ifpfP: dzbXe: goto bXjR7; cY9Dm: if ($result) { goto dDy0u; } goto SyLbU; Nk5mY: $result = $this->site->topicModule->del(["\x69\144" => $id, "\x75\156\151\141\x63\x69\144" => $this->uid]); goto cY9Dm; SyLbU: echo json_encode(["\143\x6f\x64\145" => 1, "\155\163\147" => "\345\x88\240\xe9\x99\244\345\244\261\350\264\xa5"]); goto Bed8S; qog0C: } public function detaildel() { goto HGqfp; Uq7nx: $topic = $this->site->topicModule->getOne(["\151\144" => $article["\x74\157\160\151\143\137\151\x64"], "\165\x6e\151\x61\143\151\144" => $this->uid]); goto OyaXN; uRhsa: $article = $this->site->topiclistModule->getOne(["\151\144" => $id]); goto Uq7nx; PelTz: $result = $this->site->topiclistModule->del(["\x69\144" => $id]); goto Aa0jf; HGqfp: $id = intval($_POST["\x69\x64"]); goto uRhsa; jZqtD: echo json_encode(["\143\x6f\x64\x65" => 1, "\155\x73\x67" => "\xe5\x88\xa0\351\x99\xa4\345\xa4\261\xe8\xb4\xa5"]); goto EojS4; jKQ0H: goto EiuIe; goto Lb3Xm; EojS4: exit; goto IwLKo; Lb3Xm: mMXKI: goto zW8iU; Aa0jf: if ($result) { goto mMXKI; } goto OEUNm; IwLKo: YiEjb: goto PelTz; OyaXN: if ($topic) { goto YiEjb; } goto jZqtD; zW8iU: echo json_encode(["\x63\x6f\x64\x65" => 0]); goto sv3RQ; OEUNm: echo json_encode(["\x63\157\x64\145" => 1, "\155\163\x67" => "\xe5\210\240\xe9\x99\xa4\345\xa4\261\xe8\xb4\245"]); goto jKQ0H; sv3RQ: EiuIe: goto Uc2ks; Uc2ks: exit; goto BiXai; BiXai: } }