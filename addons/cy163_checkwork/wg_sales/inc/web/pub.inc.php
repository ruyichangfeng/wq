<?php
/*   __________________________________________________
    |  Obfuscated by YAK Pro - Php Obfuscator          |
    |              on 2018-08-04 11:37:49              |
    |    GitHub: https://github.com/pk-fr/yakpro-po    |
    |__________________________________________________|
*/
 class Wg_sales_Web_Pub extends SalesBaseController { public $cate = array(); public $size = 10; public function init() { goto LN0F1; kbVmS: $this->site->loadmodule("\x70\165\x62\x4d\x6f\144\165\154\145"); goto CIhI0; Tpm7S: $this->uid = $this->site->_W["\165\156\x69\141\143\x69\x64"]; goto kbVmS; LN0F1: parent::init(); goto Tpm7S; CIhI0: $this->site->loadmodule("\143\141\164\145\x67\157\162\x79\x4d\157\144\x75\154\x65"); goto Rbc1I; Rbc1I: $this->site->loadmodule("\141\162\164\x69\x63\x6c\145\x4d\157\x64\165\154\145"); goto ZXRgR; ZXRgR: } public function index() { goto ASYXV; MLlgP: $cate = $cate ? $cate : 1; goto qdNvo; nLAw5: $data["\x63\141\x74\145\x67\157\162\171"] = $this->site->arrayIndex($data["\x63\x61\x74\145\147\x6f\x72\x79"], "\151\x64"); goto yhmhf; GDoXI: $this->site->assign($data); goto Toqcv; qdNvo: $where = ["\x75\156\151\x61\x63\x69\144" => $this->site->_W["\165\156\151\x61\x63\x69\x64"], "\143\x61\x74\x65" => $cate]; goto Winja; JFUbb: $page = intval($_GET["\x70\x61\x67\x65"]) ? intval($_GET["\160\141\147\145"]) : 1; goto PIyYq; pOxkk: $data["\x70\141\x67\x65\x72"] = pagination($total, $pindex, $this->size); goto YyKUv; PIyYq: $data["\143\x61\164\145\x67\x6f\x72\x79"] = $this->site->categoryModule->getAllCategory(["\x75\156\151\x61\143\x69\x64" => $this->uid, "\x64\145\x6c" => 0]); goto nLAw5; cdWsm: $cate = intval($_GET["\x63\x61\x74\x65"]); goto MLlgP; yhmhf: $data["\x6c\x69\x73\x74"] = $this->site->pubModule->getList($where, "\x2a", ["\151\144\x20\144\x65\163\x63"], [$page, $this->size]); goto pOxkk; ASYXV: $pindex = max(1, intval($this->site->_GPC["\x70\141\x67\145"])); goto cdWsm; YyKUv: $data["\143\x61\x74\145"] = $cate; goto GDoXI; Winja: $total = $this->site->pubModule->count($where); goto JFUbb; Toqcv: } public function edit() { goto MIFqs; CtI77: $data["\x63\x6f\x6e\x74\145\156\164"] = trim($_POST["\x63\157\x6e\164\x65\156\x74"]); goto dV9ws; adB_I: foreach ($images as &$im) { $im["\x75\x72\x6c"] = $this->site->formatArrImage($im)["\x75\x72\x6c"]; Fkg1F: } goto a_Rb8; EPS24: $image = []; goto CniUb; sXmaE: $result = $this->site->pubModule->add($data); goto KUW1S; cvThf: if ($result) { goto i0Ffc; } goto vaKii; gROtA: $data["\141\x72\x74\151\x63\154\145"] = $this->site->pubModule->getOne($where); goto V8lX4; vaKii: message("\xe6\233\264\xe6\226\xb0\xe5\xa4\261\xe8\264\xa5"); goto UbCDI; zmhFa: EUr7J: goto IXJqI; LeClc: PpiPC: goto PPeZo; DuiqU: i0Ffc: goto rNUPB; vz6If: W3U5f: goto nEh1N; AFLc1: zIzB0: goto v_NnO; YLN7p: $data["\x74\151\x74\x6c\x65"] = trim($_POST["\x74\151\164\x6c\x65"]); goto CtI77; VddYa: if (!(!$data["\143\157\x6e\x74\145\156\164"] || !$data["\164\x69\x74\154\x65"])) { goto FSgcZ; } goto za2FX; V8lX4: $images = @json_decode($data["\x61\x72\x74\151\x63\154\x65"]["\x69\x6d\x61\147\145"], true); goto pzG4E; phwhk: x2hVJ: goto rxOe5; hpXAC: $pic = $_POST["\x69\x6d\141\147\145"]; goto EPS24; eHCxF: $this->site->assign($data); goto NJ2QO; pzG4E: if (!$images) { goto W3U5f; } goto adB_I; B3z3Q: if ($id) { goto zIzB0; } goto sXmaE; IXJqI: $data["\143\x61\164\145"] = $this->site->categoryModule->getAllCategory(["\165\156\x69\141\143\151\x64" => $this->uid, "\x64\x65\154" => 0]); goto eHCxF; v_NnO: $result = $this->site->pubModule->update($where, $data); goto wBO5m; W60og: if (!$this->site->ispost()) { goto x2hVJ; } goto hpXAC; rxOe5: if (!$id) { goto EUr7J; } goto gROtA; fTyg2: $data["\x63\141\x74\145\147\x6f\162\x79\x5f\x69\144"] = intval($_POST["\143\x61\164\x65\147\157\x72\x79\137\151\x64"]); goto YLN7p; KUW1S: goto fjBrf; goto AFLc1; CniUb: if (!$pic) { goto V5A_P; } goto lx7Q4; a_Rb8: MBtsj: goto vz6If; nEh1N: $data["\x61\x72\x74\151\143\x6c\145"]["\x69\155\141\147\x65"] = $images; goto zmhFa; vdHg5: FSgcZ: goto B3z3Q; za2FX: message("\xe5\206\205\xe5\xae\xb9\xe6\x88\226\346\240\x87\xe9\242\x98\xe4\xb8\x8d\xe8\203\xbd\344\270\272\xe7\xa9\xba"); goto vdHg5; dV9ws: $data["\x69\x6d\x61\147\x65"] = json_encode($image); goto VddYa; DEH81: $where = ["\x69\x64" => $id]; goto W60og; lTKNn: CLpH1: goto phwhk; rNUPB: message("\346\x9b\xb4\xe6\226\xb0\xe6\x88\220\xe5\212\237", $this->site->webUrl("\x70\165\x62")); goto lTKNn; PPeZo: V5A_P: goto fTyg2; MIFqs: $id = (int) $this->site->_GPC["\151\x64"]; goto DEH81; UbCDI: goto CLpH1; goto DuiqU; lx7Q4: foreach ($pic as $k => $im) { goto wIi15; wIi15: if (!$im) { goto H3R4S; } goto hR01i; hR01i: $image[] = ["\165\x72\x6c" => $this->site->formatArrImage(["\x75\x72\x6c" => $im])["\165\162\x6c"]]; goto RS_79; iI8jR: EAbOC: goto lBxl6; lBxl6: x_EXt: goto k1NxK; FWTpn: goto PpiPC; goto iI8jR; SKHb0: if (!(count($image) > 2)) { goto EAbOC; } goto FWTpn; RS_79: H3R4S: goto SKHb0; k1NxK: } goto LeClc; wBO5m: fjBrf: goto cvThf; NJ2QO: } function del() { goto pIOb0; wTTY3: echo json_encode(["\x63\157\144\145" => 0]); goto KU0Kq; KU0Kq: exit; goto m37bp; DbWK5: $category_id = $article["\x63\x61\x74\x65\147\157\x72\x79\x5f\x69\x64"]; goto B_EUx; YayHX: if (!$article_id) { goto Cw2yt; } goto yo38_; D7eHy: Cw2yt: goto v1ToO; SUMx7: $article = $this->site->pubModule->getOne(["\151\144" => $id]); goto DbWK5; B_EUx: $article_id = $article["\141\162\164\x69\x63\154\x65\x5f\x69\x64"]; goto YayHX; pIOb0: $id = (int) $this->site->_GPC["\x69\144"]; goto SUMx7; yo38_: $this->site->articleModule->del($category_id, ["\151\x64" => $article["\141\x72\x74\151\143\154\x65\x5f\151\144"]]); goto D7eHy; v1ToO: $this->site->pubModule->del(["\151\144" => $id]); goto wTTY3; m37bp: } function status() { goto qtM6E; zpbBt: uWIaX: goto BQVLu; Wf4JF: if ($article_id) { goto cOYR5; } goto BIvl1; BIvl1: goto iyHtk; goto wQMkA; Y9y56: unset($article["\165\156\151\141\x63\151\144"], $article["\151\x64"], $article["\165\x69\144"], $article["\x63\x61\x74\x65"], $article["\163\x74\141\x74\165\163"], $article["\x6d\x6f\156\x65\x79"], $article["\x63\x61\164\x65\147\x6f\162\x79\x5f\x69\x64"], $article["\141\x72\x74\x69\x63\x6c\145\137\x69\144"], $article["\x75\x70\x64\141\x74\145\x5f\x74\151\155\x65"]); goto j3uD3; qenP3: $this->site->articleModule->del($category_id, ["\x69\x64" => $article["\x61\162\164\x69\x63\154\145\x5f\151\144"]]); goto Gaakv; dZYiQ: exit; goto sWYXU; cOR5J: $this->site->pubModule->update(["\x69\144" => $id], ["\x61\x72\164\x69\143\154\145\137\151\144" => $article_id, "\163\164\141\x74\x75\x73" => $status, "\x75\x70\x64\x61\x74\x65\x5f\x74\151\155\x65" => time()]); goto JdZz7; eFR03: goto iyHtk; goto LIxfx; UgFXc: $article = $this->site->pubModule->getOne(["\151\144" => $id]); goto QXeBd; HaAe9: if ($status == 1) { goto QlndR; } goto Wf4JF; QXeBd: $category_id = $article["\143\x61\x74\x65\147\x6f\162\171\x5f\151\144"]; goto lXpur; USshl: if ($article_id) { goto uWIaX; } goto FBdtW; wQMkA: QlndR: goto Y9y56; LIxfx: cOYR5: goto qenP3; j3uD3: $article_id = $this->site->articleModule->add($category_id, $article); goto USshl; yjf_X: $status = (int) $this->site->_GPC["\163\164\x61\x74\165\x73"]; goto UgFXc; JdZz7: echo json_encode(["\143\157\144\145" => 0]); goto TXe0P; TXe0P: exit; goto LWb0k; qtM6E: $id = (int) $this->site->_GPC["\151\x64"]; goto yjf_X; Gaakv: iyHtk: goto cOR5J; lXpur: $article_id = $article["\x61\162\164\151\x63\x6c\145\137\151\x64"]; goto HaAe9; sWYXU: goto aooIA; goto zpbBt; BQVLu: aooIA: goto eFR03; FBdtW: echo json_encode(["\x63\157\144\x65" => 1]); goto dZYiQ; LWb0k: } }