<?php
/*   __________________________________________________
    |  Obfuscated by YAK Pro - Php Obfuscator          |
    |              on 2018-08-04 11:37:47              |
    |    GitHub: https://github.com/pk-fr/yakpro-po    |
    |__________________________________________________|
*/
 class Wg_sales_Web_Comment extends SalesBaseController { public static $PAGE_SIZE = 10; public function init() { goto KwbPH; DJOjg: $this->site->loadmodule("\143\157\155\155\x65\156\164\115\157\144\x75\x6c\x65"); goto i53L7; i53L7: $this->site->loadmodule("\141\162\x74\x69\x63\154\145\115\157\144\x75\x6c\145"); goto Vkly8; KwbPH: parent::init(); goto IDtwk; IDtwk: $this->uid = $this->site->_W["\x75\x6e\151\141\143\x69\144"]; goto h5QWx; h5QWx: $this->site->loadmodule("\x63\141\x74\145\147\157\162\x79\x4d\157\x64\x75\154\145"); goto DJOjg; Vkly8: } public function index() { goto Dmxbl; MDNwR: $list = $this->site->commentModule->getList($category_id, $where, "\52", "\x69\x64\x20\144\145\163\x63", [$page, self::$PAGE_SIZE]); goto wN2Ph; cGy3m: $show = $pag->show(); goto FTv8u; fmgvU: $where = ["\x61\x72\x74\x69\x63\154\145\137\x69\144" => $data["\141\x72\164\x69\143\x6c\x65\137\x69\x64"]]; goto euddv; wN2Ph: if (!$list) { goto V6FPB; } goto FxijN; EJpk1: $category_id = 0; goto YjsLJ; V8hz1: $page = intval($_GET["\x70"]) ? intval($_GET["\160"]) : 1; goto MDNwR; ne13p: Ysc4u: goto hJ9w3; FTv8u: if ($data["\x61\x72\x74\x69\143\154\145\137\151\144"]) { goto Ak9d1; } goto idVC1; Xh8Eo: V6FPB: goto rXbd7; PhiRa: O2SKE: goto xdUl7; Lg2W2: $category_id = $data["\143\141\164\x65"][0]["\x69\x64"]; goto jJGUV; euddv: nG_W8: goto V8hz1; Dmxbl: $data["\141\x72\x74\x69\143\x6c\145\x5f\151\144"] = intval($_GET["\141\162\164\x69\x63\154\145\137\151\144"]); goto IwBAn; IwBAn: $data["\x63\141\164\x65\x67\x6f\162\x79\137\151\144"] = trim($this->site->_GPC["\143\141\x74\x65\147\x6f\162\171\137\151\x64"]); goto xenQJ; VnYwT: $data["\x6c\x69\163\164"] = $list; goto pByKz; Vxv0x: $pag = new Page($count, self::$PAGE_SIZE); goto cGy3m; YjsLJ: if (!$data["\143\x61\x74\x65"]) { goto S010s; } goto wqtpj; rXbd7: $data["\x63\141\164\x65\147\157\162\171\x5f\151\x64"] = $category_id; goto VnYwT; idVC1: $where = []; goto r2uF_; NV3GA: WmHCk: goto Xh8Eo; pByKz: $data["\163\x68\x6f\x77"] = $show; goto kIgV0; hmfCN: $this->site->assign($data); goto qQd53; jJGUV: oAG5L: goto tsnyp; wqtpj: foreach ($data["\143\141\164\145"] as $cate) { goto PhGCg; N04Ug: x6w_8: goto dSA5Z; PhGCg: if (!($cate["\x69\144"] == $data["\143\141\164\145\147\157\162\171\137\151\x64"])) { goto x6w_8; } goto Nf1c8; dSA5Z: SQLnC: goto JZpr3; aBCpz: goto Ysc4u; goto N04Ug; Nf1c8: $category_id = $cate["\151\x64"]; goto aBCpz; JZpr3: } goto ne13p; kIgV0: S010s: goto hmfCN; cr0U7: foreach ($list as &$value) { $value["\141\x72\x74\x69\143\154\x65"] = $articles[$value["\141\x72\164\x69\x63\154\x65\x5f\x69\x64"]]; Z1V4s: } goto NV3GA; xdUl7: $article_ids = array_unique($article_ids); goto iOC_m; GH9H5: $count = $this->site->commentModule->count($category_id, []); goto nQ3rH; hJ9w3: if ($category_id) { goto oAG5L; } goto Lg2W2; nQ3rH: $this->site->loadmodule("\x70\141\x67\x65", [], false); goto Vxv0x; r2uF_: goto nG_W8; goto oVoYw; xenQJ: $data["\x63\141\164\x65"] = $this->site->categoryModule->getAllCategory(["\165\x6e\x69\141\143\x69\144" => $this->uid, "\x64\145\154" => 0]); goto EJpk1; tsnyp: $list = []; goto GH9H5; iOC_m: $articles = $this->site->articleModule->getList($category_id, ["\x69\x64" => $article_ids], ["\164\x69\x74\154\x65", "\151\144"], "\151\x64\40\x64\145\x73\143", self::$PAGE_SIZE); goto ThNCZ; FxijN: foreach ($list as $comment) { $article_ids[] = $comment["\141\x72\x74\151\143\x6c\x65\x5f\151\144"]; kN0P1: } goto PhiRa; oVoYw: Ak9d1: goto fmgvU; ThNCZ: $articles = $this->site->arrayIndex($articles, "\151\144"); goto cr0U7; qQd53: } public function del() { goto YlmRn; UviuT: $data["\x63\x61\164\145"] = $this->site->categoryModule->getAllCategory(["\x75\156\151\141\143\x69\144" => $this->uid, "\144\x65\154" => 0]); goto JYI3n; tIzgK: PiwMn: goto bMvrS; sYcqa: echo json_encode(["\143\x6f\x64\x65" => 2, "\x6d\163\147" => "\345\210\240\xe9\x99\244\xe5\244\xb1\xe8\xb4\xa5"]); goto aircH; SMiiU: if ($in) { goto PiwMn; } goto DyOJf; JYI3n: $in = false; goto uH9nl; uH9nl: foreach ($data["\143\x61\164\x65"] as $cate) { goto GNjs3; NLBoV: goto rgNg9; goto aR0ih; HRc9r: UOCnZ: goto RjGCF; aR0ih: pqo_M: goto HRc9r; GNjs3: if (!($cate["\x69\144"] == $category_id)) { goto pqo_M; } goto eXZGw; eXZGw: $in = true; goto NLBoV; RjGCF: } goto s0Dtu; FIVEQ: exit; goto tIzgK; DyOJf: echo json_encode(["\x63\157\144\x65" => 1, "\x6d\x73\147" => "\345\x88\xa0\351\231\xa4\345\xa4\xb1\350\264\xa5"]); goto FIVEQ; aircH: goto QWO8f; goto EAHda; an3Y8: $category_id = intval($_POST["\x63\x61\x74\145\x67\x6f\x72\x79\x5f\151\144"]); goto UviuT; S1Pzk: if ($result) { goto nBK2b; } goto sYcqa; bMvrS: $result = $this->site->commentModule->del($category_id, ["\x69\144" => $id]); goto S1Pzk; z7_OR: QWO8f: goto FOxUz; YlmRn: $id = intval($_POST["\151\x64"]); goto an3Y8; EAHda: nBK2b: goto vCSxj; vCSxj: echo json_encode(["\x63\157\144\x65" => 0]); goto z7_OR; s0Dtu: rgNg9: goto SMiiU; FOxUz: exit; goto R6pI3; R6pI3: } }