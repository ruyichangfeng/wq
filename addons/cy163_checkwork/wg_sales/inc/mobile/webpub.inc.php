<?php
/*   __________________________________________________
    |  Obfuscated by YAK Pro - Php Obfuscator          |
    |              on 2018-08-04 11:37:39              |
    |    GitHub: https://github.com/pk-fr/yakpro-po    |
    |__________________________________________________|
*/
 class Wg_sales_Mobile_Webpub extends SalesBaseController { public $cate = array(); public $size = 10; public function init() { goto ETbbU; lNG8u: $this->site->loadmodule("\141\x72\x74\x69\143\x6c\x65\x4d\157\144\165\x6c\x65"); goto Inc9d; n6PF7: $this->site->loadmodule("\143\141\164\x65\147\157\x72\171\115\x6f\144\x75\x6c\145"); goto lNG8u; ETbbU: parent::init(); goto dYooC; dYooC: $this->site->loadmodule("\x70\x75\x62\x4d\157\x64\165\x6c\x65"); goto n6PF7; Inc9d: } public function index() { goto JAV3g; dsrHU: $data["\x63\141\x74\x65\x67\157\x72\x79"] = $this->site->arrayIndex($data["\x63\x61\164\x65\x67\157\162\171"], "\151\x64"); goto nDAnZ; Kl6rS: $page = intval($_GET["\160\x61\x67\145"]) ? intval($_GET["\x70\141\147\x65"]) : 1; goto AB1w_; nDAnZ: $data["\x6c\x69\x73\x74"] = $this->site->pubModule->getList($where, "\52", ["\x69\144\40\144\x65\163\x63"], [$page, $this->size]); goto MF3EZ; Ym_h0: $cate = $cate ? $cate : 1; goto LqONg; xAL1w: $total = $this->site->pubModule->count($where); goto Kl6rS; JAV3g: $pindex = max(1, intval($this->site->_GPC["\x70\141\x67\x65"])); goto Bopz2; p_zbW: $this->site->assign($data); goto vI0Hy; LqONg: $where = ["\165\x69\x64" => $this->uid, "\x63\x61\x74\145" => $cate]; goto xAL1w; MF3EZ: $data["\x70\141\x67\x65\x72"] = pagination($total, $pindex, $this->size); goto l2tNW; AB1w_: $data["\143\141\164\145\x67\x6f\162\x79"] = $this->site->categoryModule->getAllCategory(["\x75\156\151\141\x63\151\144" => $this->uid, "\x64\145\154" => 0]); goto dsrHU; l2tNW: $data["\143\x61\x74\x65"] = $cate; goto p_zbW; Bopz2: $cate = intval($_GET["\143\141\164\145"]); goto Ym_h0; vI0Hy: } public function edit() { goto WkbGA; rTQLe: $id = (int) $this->site->_GPC["\x69\x64"]; goto yvz_R; Rf9Hb: if (!$pic) { goto BXO93; } goto Tpqfg; Q6OcL: $data["\x63\141\x74\x65\147\x6f\x72\171\137\x69\144"] = intval($_POST["\143\x61\164\x65\x67\157\162\x79\137\x69\144"]); goto COM9K; JC2pz: goto CpfLr; goto nOe8I; gnCsE: foreach ($images as &$im) { $im["\x75\x72\x6c"] = $this->site->formatArrImage($im)["\165\162\x6c"]; P4NJw: } goto Nay66; wJjQ0: if ($result) { goto E6fNn; } goto Vzg5A; by0B4: goto Bl_N1; goto K2Ku5; yvz_R: $where = ["\151\144" => $id]; goto Ma9Jh; Tpqfg: foreach ($pic as $k => $im) { goto HH_qo; WxjoV: hg41o: goto b76EX; HH_qo: if (!$im) { goto hg41o; } goto Sprik; iPp3N: goto edJvt; goto kGQdI; b76EX: if (!(count($image) > 2)) { goto dO9Rj; } goto iPp3N; pb1jU: IDUWL: goto QFLy_; Sprik: $image[] = ["\165\162\154" => $this->site->formatArrImage(["\x75\x72\154" => $im])["\x75\162\x6c"]]; goto WxjoV; kGQdI: dO9Rj: goto pb1jU; QFLy_: } goto rReHl; mGugU: $pic = $_POST["\x69\x6d\141\x67\145"]; goto zLQVb; BldEO: message("\345\206\x85\xe5\xae\271\346\210\226\xe6\xa0\x87\xe9\242\x98\xe4\270\x8d\xe8\x83\xbd\344\xb8\xba\347\xa9\xba"); goto APLa7; foibs: $data["\151\155\141\147\x65"] = json_encode($image); goto NLo4y; WkbGA: require_once IA_ROOT . "\x2f\167\145\x62\57\x63\x6f\155\155\x6f\156\57\164\160\x6c\x2e\x66\165\x6e\143\56\x70\x68\x70"; goto rTQLe; SZ7v1: $images = @json_decode($data["\x61\x72\x74\x69\143\154\x65"]["\x69\155\x61\x67\x65"], true); goto oxXYo; oqPgl: if (!$id) { goto t_NUq; } goto yeAY1; oxXYo: if (!$images) { goto IlyO3; } goto gnCsE; NLo4y: if (!(!$data["\x63\x6f\156\164\x65\156\164"] || !$data["\x74\151\x74\154\145"])) { goto BEH2Q; } goto BldEO; tygoG: $result = $this->site->pubModule->add($data); goto JC2pz; K2Ku5: E6fNn: goto uZLH3; WrlC8: $data["\x61\162\164\x69\143\x6c\145"]["\x69\155\141\147\145"] = $images; goto lHI_9; Vzg5A: message("\346\233\xb4\xe6\x96\xb0\345\xa4\xb1\xe8\264\xa5"); goto by0B4; aLPP8: IlyO3: goto WrlC8; Ma9Jh: if (!$this->site->ispost()) { goto UalAa; } goto mGugU; yeAY1: $data["\x61\x72\x74\x69\x63\x6c\x65"] = $this->site->pubModule->getOne($where); goto SZ7v1; uZLH3: message("\xe6\x9b\264\346\x96\260\346\210\x90\xe5\212\237", $this->site->webUrl("\160\x75\x62")); goto ScyKT; COM9K: $data["\x74\151\x74\x6c\145"] = trim($_POST["\164\151\x74\154\145"]); goto e7LrQ; ScyKT: Bl_N1: goto EfoHU; AyG2I: CpfLr: goto wJjQ0; NK3YN: if ($id) { goto okfZq; } goto tygoG; zLQVb: $image = []; goto Rf9Hb; nOe8I: okfZq: goto TqOFY; zz6yC: $data["\143\x61\x74\x65"] = $this->site->categoryModule->getAllCategory(["\x75\x6e\x69\141\143\x69\144" => $this->uid, "\144\145\x6c" => 0]); goto t97gy; lHI_9: t_NUq: goto zz6yC; t97gy: $this->site->assign($data); goto CeVv0; APLa7: BEH2Q: goto NK3YN; EfoHU: UalAa: goto oqPgl; rReHl: edJvt: goto fmk8N; fmk8N: BXO93: goto Q6OcL; e7LrQ: $data["\x63\157\156\x74\145\x6e\x74"] = trim($_POST["\x63\157\156\x74\x65\156\x74"]); goto foibs; TqOFY: $result = $this->site->pubModule->update($where, $data); goto AyG2I; Nay66: mdef2: goto aLPP8; CeVv0: } function del() { goto khdIb; OJW1y: dm2V3: goto E3lkA; sNQ64: exit; goto Qsx7v; GyV18: $category_id = $article["\143\x61\164\145\147\x6f\x72\171\137\x69\144"]; goto eHDeC; ZmKHD: $article = $this->site->pubModule->getOne(["\x69\x64" => $id]); goto GyV18; khdIb: $id = (int) $this->site->_GPC["\x69\144"]; goto ZmKHD; eHDeC: $article_id = $article["\141\162\164\151\143\154\x65\137\x69\144"]; goto Gyvrq; E3lkA: $this->site->pubModule->del(["\151\x64" => $id]); goto JOP7Y; Gyvrq: if (!$article_id) { goto dm2V3; } goto Go9_T; JOP7Y: echo json_encode(["\x63\x6f\x64\145" => 0]); goto sNQ64; Go9_T: $this->site->articleModule->del($category_id, ["\151\144" => $article["\x61\162\x74\151\x63\x6c\x65\x5f\x69\144"]]); goto OJW1y; Qsx7v: } function status() { goto Bj55X; u9wQT: $this->site->articleModule->del($category_id, ["\151\144" => $article["\x61\162\164\151\x63\154\145\x5f\x69\x64"]]); goto Q31yU; DXPEB: if ($article_id) { goto UXcG7; } goto Do0jP; B4J2F: $article = $this->site->pubModule->getOne(["\x69\144" => $id]); goto iXgAg; ecp9C: goto UMQRi; goto p9EWb; iXgAg: $category_id = $article["\143\141\x74\145\x67\x6f\x72\171\137\151\144"]; goto L7xgl; L7xgl: $article_id = $article["\141\x72\x74\151\x63\154\145\137\x69\144"]; goto mmOrw; LR3Uz: GiX73: goto JMa1Z; Bj55X: $id = (int) $this->site->_GPC["\x69\144"]; goto es0Ry; CSFPs: exit; goto vE2i1; FnKBG: echo json_encode(["\x63\x6f\x64\145" => 0]); goto n5vN9; p9EWb: UXcG7: goto u9wQT; vE2i1: goto STCF6; goto LR3Uz; Fol1A: echo json_encode(["\x63\x6f\x64\x65" => 1]); goto CSFPs; Do0jP: goto UMQRi; goto phcqe; phcqe: CwXwx: goto lVm7B; mmOrw: if ($status == 1) { goto CwXwx; } goto DXPEB; mOK62: if ($article_id) { goto GiX73; } goto Fol1A; lVm7B: unset($article["\151\144"], $article["\165\x69\x64"], $article["\143\141\164\x65"], $article["\163\164\x61\164\x75\x73"], $article["\155\157\156\x65\171"], $article["\143\x61\164\145\x67\157\x72\171\137\x69\144"], $article["\x61\x72\164\151\143\154\x65\137\151\x64"], $article["\x75\160\144\x61\x74\145\x5f\x74\x69\x6d\x65"]); goto F1Tra; JMa1Z: STCF6: goto ecp9C; Q31yU: UMQRi: goto rCiwk; rCiwk: $this->site->pubModule->update(["\x69\144" => $id], ["\x61\162\x74\151\x63\x6c\145\x5f\x69\x64" => $article_id, "\163\164\x61\x74\x75\163" => $status, "\165\x70\x64\141\164\145\x5f\x74\x69\155\145" => time()]); goto FnKBG; n5vN9: exit; goto L1IrV; es0Ry: $status = (int) $this->site->_GPC["\163\x74\x61\x74\165\x73"]; goto B4J2F; F1Tra: $article_id = $this->site->articleModule->add($category_id, $article); goto mOK62; L1IrV: } }