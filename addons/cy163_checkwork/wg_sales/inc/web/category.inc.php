<?php
/*   __________________________________________________
    |  Obfuscated by YAK Pro - Php Obfuscator          |
    |              on 2018-08-04 11:37:45              |
    |    GitHub: https://github.com/pk-fr/yakpro-po    |
    |__________________________________________________|
*/
 class Wg_sales_Web_Category extends SalesBaseController { public $cate = array(); public function init() { goto noZuu; gTQAF: $this->site->loadmodule("\143\141\x74\x65\x67\157\x72\171\x4d\157\x64\x75\x6c\145"); goto y1gQC; noZuu: parent::init(); goto V17x2; V17x2: $this->uid = $this->site->_W["\165\x6e\151\x61\143\x69\x64"]; goto gTQAF; y1gQC: $this->cate = Index::getCategory(); goto ciZ_a; ciZ_a: } public function index() { goto q6nHn; q6nHn: $data["\x69\x6e\144\x65\x78"] = $this->site->getCategoryIndex(); goto PE7Am; PE7Am: $list = $this->site->categoryModule->getAllCategory(["\165\x6e\x69\141\143\151\144" => $this->uid, "\x64\x65\154" => [0, 2]]); goto XWEDG; jU6Th: dSyHZ: goto AHKkM; ctoaQ: $this->site->assign($data); goto x5Fk2; XWEDG: foreach ($list as &$value) { goto Q_XKn; zScUg: xqLBz: goto lsYwU; Y0iHV: if (!$source) { goto IF8lw; } goto qqFim; zW965: VrHhY: goto Uv6CM; Uv6CM: IF8lw: goto zScUg; Q_XKn: $source = json_decode($value["\163\157\165\x72\x63\x65"], true); goto Y0iHV; qqFim: foreach ($source as $s) { goto nVJqd; nVJqd: $d = explode("\x5f", $s); goto JMA0I; UIEBx: if (isset($this->cate[$name]["\x63\x61\164\145\x67\157\162\171"][$id])) { goto v8GUk; } goto SXZt6; CLwzp: v8GUk: goto t9P9L; H9503: a99sh: goto lho5L; SXZt6: $value["\163\157\165\x72\x63\145\137\146\162\157\155"][] = ["\151\x6e\x64\x65\170" => $name, "\x6e\x61\x6d\145" => $id]; goto mVc5X; t9P9L: $value["\163\x6f\x75\x72\x63\x65\x5f\146\162\x6f\155"][] = ["\x69\x6e\144\x65\x78" => $this->cate[$name]["\166\x61\x6c\165\145"], "\x6e\141\155\145" => $this->cate[$name]["\x63\x61\164\x65\x67\x6f\x72\x79"][$id]["\x6e\141\x6d\x65"]]; goto H9503; JMA0I: $name = $d[0]; goto ycle9; lho5L: rrP1A: goto KsylD; ycle9: $id = $d[1]; goto UIEBx; mVc5X: goto a99sh; goto CLwzp; KsylD: } goto zW965; lsYwU: } goto jU6Th; AHKkM: $data["\154\x69\x73\x74"] = $list; goto ctoaQ; x5Fk2: } public function edit() { goto iCint; hBJRQ: goto KmYjv; goto egdG_; hm1eJ: $data["\143\141\164\x65\147\157\x72\x79"] = $this->site->categoryModule->getOne($where); goto tWUtZ; OhNmk: Mrz5B: goto B0RXF; lShUo: GpxAA: goto T9TRQ; tWUtZ: $data["\x63\x61\x74\145\147\157\x72\171"]["\163\x6f\x75\x72\x63\x65"] = json_decode($data["\143\141\164\x65\x67\x6f\162\x79"]["\163\157\165\162\x63\x65"], true)[0]; goto U1zTi; FjAeR: KmYjv: goto lFAka; yz1r0: MMTzA: goto ByvL_; OcZ3C: goto H7f0a; goto ybCY9; aTjKv: bkDge: goto yz1r0; IHGnR: if (!$this->site->ispost()) { goto dQwjM; } goto iw6vu; n8PkY: if ($id) { goto J9DwE; } goto rMciv; Rtzik: $data["\x63\141\x74\145"] = $this->cate; goto CMHt3; ByvL_: if (!$id) { goto Mrz5B; } goto hm1eJ; rMciv: $result = $this->site->categoryModule->add($data); goto OcZ3C; U0fko: if ($result) { goto OY88D; } goto uQvRF; D6S0P: DNkoX: goto tFfWn; Sf6TJ: LTjk3: goto bt9k4; Fv1Ix: $id = (int) $this->site->_GPC["\x63\x61\x74\145\x67\x6f\x72\171\137\151\144"]; goto DTexh; qXA0I: $data["\152\165\155\x70"] = trim($_POST["\x6a\x75\x6d\x70"]); goto UX8qi; B0RXF: goto p0NJQ; goto lShUo; ybCY9: J9DwE: goto VQXyP; kFRky: if ($this->site->setCategoryIndex($write)) { goto Welms; } goto nBSDS; Xs12h: p0NJQ: goto Rtzik; iCint: $data = []; goto Dk54s; U1zTi: $d = explode("\137", $data["\x63\141\164\145\147\x6f\x72\171"]["\163\x6f\x75\x72\x63\145"]); goto vw2ey; T9TRQ: $data["\x63\141\164\x65\x67\157\162\171"] = $write = $this->site->getCategoryIndex(); goto IHGnR; bBGwJ: $data["\165\156\x69\141\x63\151\x64"] = $this->uid; goto YNnOO; Dk54s: if ($this->site->_GPC["\143\x61\164\145\x67\157\x72\171\x5f\151\144"] === "\60") { goto GpxAA; } goto Fv1Ix; b0wbv: if (!($name == "\x42\141\x69\144\165\x4e\145\167\x73\x53\x65\141\x72\143\x68")) { goto TiCMC; } goto AzzZN; CNerX: if ($data["\x6e\x61\155\145"]) { goto DNkoX; } goto cfN91; lFAka: dQwjM: goto Xs12h; lZ1Ul: $data["\x63\x61\x74\145\x67\x6f\x72\x79"]["\153\167"] = $id; goto OH3kq; CMHt3: $this->site->assign($data); goto yfkHP; orqDf: goto bkDge; goto Xgivz; DTexh: $where = ["\x69\144" => $id, "\165\156\151\x61\x63\151\x64" => $this->uid, "\x64\x65\x6c" => [0, 2]]; goto caBlL; LA0zf: $data["\x6e\x61\155\x65"] = trim($this->site->_GPC["\156\141\155\145"]); goto bBGwJ; iLUUr: ccQPo: goto n8PkY; iw6vu: $write["\156\x61\155\x65"] = trim($this->site->_GPC["\156\x61\x6d\145"]); goto kFRky; OH3kq: TiCMC: goto OhNmk; tFfWn: if (!($data["\x6a\165\x6d\x70"] == 1 && $data["\x75\x72\x6c"] == '')) { goto ccQPo; } goto zybIi; cfN91: message("\xe5\x88\x86\347\xb1\xbb\345\220\x8d\xe4\270\x8d\350\x83\xbd\xe4\xb8\272\xe7\251\xba"); goto D6S0P; UX8qi: $data["\x75\162\154"] = trim($_POST["\165\x72\154"]); goto il8cB; AzzZN: $data["\x63\141\x74\145\147\x6f\162\171"]["\x73\157\x75\162\x63\x65"] = "\x42\x61\151\144\165\x4e\x65\x77\x73\123\145\x61\x72\x63\150\x5f\61"; goto lZ1Ul; caBlL: if (!$this->site->ispost()) { goto MMTzA; } goto LA0zf; VQXyP: $result = $this->site->categoryModule->update($where, $data); goto ymW0o; n2Zbs: $data["\x73\157\165\162\143\x65"] = json_encode([trim($this->site->_GPC["\163\x6f\x75\x72\x63\145"])]); goto S3ovS; S3ovS: goto KAkP7; goto Sf6TJ; GyLDI: KAkP7: goto CNerX; Xgivz: OY88D: goto x6xdZ; il8cB: $data["\x64\151\x73\x70\x6c\141\171\x5f\157\x72\x64\x65\x72"] = intval($this->site->_GPC["\144\151\163\160\x6c\x61\x79\137\x6f\x72\144\x65\162"]); goto yAdwY; yAdwY: if (trim($this->site->_GPC["\163\157\165\x72\143\145"]) == "\x42\141\x69\x64\165\116\145\x77\x73\x53\x65\141\162\143\150\137\61") { goto LTjk3; } goto n2Zbs; DSVVT: $id = $d[1]; goto b0wbv; bt9k4: $data["\163\157\165\x72\143\x65"] = json_encode(["\x42\141\151\x64\x75\116\145\167\x73\123\x65\141\162\x63\x68\137" . $_POST["\x6b\167"]]); goto GyLDI; x6xdZ: message("\346\x9b\xb4\xe6\226\260\xe6\x88\x90\xe5\212\x9f", $this->site->webUrl("\143\141\x74\x65\x67\x6f\162\x79")); goto aTjKv; vw2ey: $name = $d[0]; goto DSVVT; YNnOO: $data["\143\162\x65\141\x74\145\x5f\x74\x69\x6d\145"] = time(); goto qXA0I; ymW0o: H7f0a: goto U0fko; uQvRF: message("\xe6\233\xb4\xe6\226\xb0\345\xa4\261\xe8\264\xa5", $this->site->webUrl("\143\x61\x74\145\x67\x6f\162\x79")); goto orqDf; zybIi: message("\x75\x72\154\344\270\x8d\xe8\203\xbd\xe4\270\xba\xe7\xa9\xba"); goto iLUUr; egdG_: Welms: goto mkjdR; nBSDS: message("\143\x61\x74\x65\147\x6f\x72\x79\x2e\x64\141\164\x61\346\x96\207\344\xbb\266\xe5\x86\231\345\205\xa5\xe5\244\261\350\xb4\245", $this->site->webUrl("\x63\x61\164\x65\x67\x6f\x72\171")); goto hBJRQ; mkjdR: message("\xe6\233\xb4\346\x96\xb0\346\210\x90\345\x8a\237", $this->site->webUrl("\x63\141\x74\145\x67\x6f\x72\171")); goto FjAeR; yfkHP: } function del() { goto iDVVw; eQkjp: iajax(1, "\143\x61\164\145\147\x6f\162\x79\56\144\x61\x74\x61\xe5\206\231\xe5\x85\xa5\xe5\xa4\xb1\350\264\245"); goto anm_R; zSCji: if ($id == 0) { goto a_Lq0; } goto w0m9r; lYXqO: $data["\144\145\x6c"] = $data["\x64\145\154"] ? 0 : 1; goto Fopp4; Fopp4: $result = $this->site->setCategoryIndex($data); goto nJOfl; nJOfl: if ($result) { goto tzgOL; } goto eQkjp; jdB4f: ClPZp: goto X0_Q7; Vs05M: if ($result) { goto ojrls; } goto wX8eJ; a_Zqc: iajax(0); goto jdB4f; Alu7L: iajax(0); goto gGOqt; aBa6S: ojrls: goto a_Zqc; wX8eJ: iajax(1); goto K_BFc; iDVVw: $id = (int) $this->site->_GPC["\151\x64"]; goto zSCji; pd_4Z: tzgOL: goto Alu7L; gGOqt: LtnpW: goto U_HEX; K_BFc: goto ClPZp; goto aBa6S; w0m9r: $where = ["\151\144" => $id, "\x75\x6e\151\141\143\x69\144" => $this->uid]; goto ZVC7O; U_HEX: CcNXD: goto CXUCM; X0_Q7: goto CcNXD; goto Op4dQ; anm_R: goto LtnpW; goto pd_4Z; zCxLA: $data = $this->site->getCategoryIndex(); goto lYXqO; ZVC7O: $result = $this->site->categoryModule->update($where, ["\144\145\154" => 1]); goto Vs05M; Op4dQ: a_Lq0: goto zCxLA; CXUCM: } function hide() { goto iDPUx; P5J_I: $hide = (int) $this->site->_GPC["\x68\x69\144\x65"] == 0 ? 0 : 2; goto by3ts; mn_K7: $result = $this->site->categoryModule->update($where, ["\144\145\x6c" => $hide]); goto t5U3I; nWf5I: oJsSg: goto d1Ixh; iDPUx: $id = (int) $this->site->_GPC["\151\x64"]; goto P5J_I; o5TfZ: Aqv2k: goto MS0G4; d1Ixh: iajax(0); goto o5TfZ; G8mnu: iajax(1); goto GPynw; by3ts: $where = ["\x69\144" => $id, "\x75\156\x69\x61\x63\x69\144" => $this->uid]; goto mn_K7; GPynw: goto Aqv2k; goto nWf5I; t5U3I: if ($result) { goto oJsSg; } goto G8mnu; MS0G4: } }