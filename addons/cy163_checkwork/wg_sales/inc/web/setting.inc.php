<?php
/*   __________________________________________________
    |  Obfuscated by YAK Pro - Php Obfuscator          |
    |              on 2018-08-04 11:37:53              |
    |    GitHub: https://github.com/pk-fr/yakpro-po    |
    |__________________________________________________|
*/
 class Wg_sales_Web_Setting extends SalesBaseController { public $cate = array(); public function init() { goto LJLQl; LJLQl: parent::init(); goto XNDnW; Af1za: $this->cate = Index::getCategory(); goto RdO1X; XASSX: $this->site->loadmodule("\141\162\x74\x69\x63\154\145\x41\144\x4d\x6f\144\x75\154\145"); goto Af1za; XNDnW: $this->uid = $this->site->_W["\x75\x6e\151\x61\x63\x69\144"]; goto osh7E; osh7E: $this->site->loadmodule("\x63\141\164\x65\147\157\x72\x79\115\157\x64\165\x6c\x65"); goto XASSX; RdO1X: } public function index() { goto ijmhY; tMY5z: $write["\141\144\137\63"] = trim($this->site->_GPC["\x61\x64\137\x33"]); goto ickzx; ijmhY: $data = $this->site->getSettings(); goto HooeX; wBN9X: eo4lX: goto CRqRY; HooeX: $where = ["\165\156\x69\x61\x63\151\x64" => $this->site->_W["\165\x6e\151\x61\x63\151\x64"]]; goto hSOdn; hSOdn: $data["\x61\144\x5f\x6c\x69\x73\x74"] = $this->site->articleAdModule->getList($where, "\52", ["\151\x64\40\144\x65\163\x63"]); goto NpY0P; JDmbL: $write["\x70\x69\x63"] = trim($this->site->_GPC["\x70\151\143"]); goto SXI46; NpY0P: if (!$this->site->ispost()) { goto eo4lX; } goto Xyde4; Wsm_Q: $write["\x61\144\137\62"] = trim($this->site->_GPC["\x61\x64\x5f\x32"]); goto tMY5z; xW7jD: RwvYG: goto ucn1n; QprYQ: $write["\x63\157\155\x6d\x65\x6e\x74"] = intval($this->site->_GPC["\143\x6f\x6d\155\x65\156\x74"]); goto s5_t5; LvXsl: goto A0kph; goto xW7jD; c32uT: if ($this->site->setSettings($write)) { goto RwvYG; } goto tKgbD; tKgbD: message("\x63\x61\x74\x65\147\x6f\x72\x79\56\144\x61\x74\x61\xe6\x96\x87\xe4\273\xb6\xe5\x86\x99\345\205\xa5\345\xa4\261\350\xb4\xa5", $this->site->webUrl("\x63\141\x74\x65\x67\157\x72\x79")); goto LvXsl; Xyde4: $write["\x6e\x61\155\145"] = trim($this->site->_GPC["\x6e\x61\155\145"]); goto JDmbL; ucn1n: message("\xe6\x9b\264\xe6\x96\260\346\x88\x90\345\212\x9f", $this->site->webUrl("\163\145\x74\x74\151\156\x67")); goto pll3u; CRqRY: $this->site->assign($data); goto Kpdcj; pll3u: A0kph: goto wBN9X; s5_t5: $write["\x61\144\x5f\61"] = trim($this->site->_GPC["\141\x64\x5f\x31"]); goto Wsm_Q; ickzx: $write["\x70\x61\x79"] = intval($this->site->_GPC["\160\141\171"]); goto c32uT; L48Bz: $write["\x74\157\x6b\145\156"] = trim($this->site->_GPC["\164\x6f\153\x65\x6e"]); goto QprYQ; SXI46: $write["\x73\151\x74\x65"] = trim($this->site->_GPC["\x73\x69\164\x65"]); goto L48Bz; Kpdcj: } public function menu() { $data["\154\x69\163\164"] = $this->site->_getCache("\155\145\x6e\x75"); $this->site->assign($data); } public function add() { goto Dn8Ff; pKtXL: message("\346\233\264\xe6\x96\260\345\xba\225\351\203\250\xe5\x9b\xbe\347\211\x87\xe5\xa4\261\350\264\245"); goto cAt_0; Dn8Ff: $rank = (int) $_GET["\162\x61\x6e\x6b"]; goto JPDOT; C66a1: $data["\x73\x65\x6c\x65\143\x74"] = trim($this->site->_GPC["\x73\145\154\145\x63\164"]); goto DR_5S; CqFl9: $this->site->assign($data); goto btkUx; gUiXF: message("\xe6\216\x92\345\272\217\xe4\270\x8d\350\x83\xbd\xe4\270\272\x30"); goto viDxl; h5tF3: $data["\x72\141\x6e\153"] = intval($this->site->_GPC["\x72\x61\156\x6b"]); goto xEgdb; Z8hhF: BJE2w: goto CqFl9; XW7AK: WRCX2: goto Z8hhF; qXeDd: XBUx8: goto Wml_p; BI1Fc: $data["\x75\x72\154"] = trim($this->site->_GPC["\165\x72\x6c"]); goto C66a1; xEgdb: $data["\x75\156\163\x65\154\x65\x63\x74"] = trim($this->site->_GPC["\x75\x6e\x73\145\154\145\x63\164"]); goto BI1Fc; XAAd3: geeQD: goto D2tN2; D2tN2: message("\xe6\x9b\xb4\346\x96\260\xe6\210\220\345\212\237", $this->site->webUrl("\x73\x65\x74\164\x69\156\x67", ["\x5f\x77\147" => "\x6d\145\156\165"])); goto XW7AK; cAt_0: goto WRCX2; goto XAAd3; C9pZZ: foreach ($list as $value) { goto rltCN; GAZbQ: faGhQ: goto X8XNR; X8XNR: PV1g8: goto uhVeu; rltCN: if (!($value["\162\x61\156\153"] == $rank)) { goto faGhQ; } goto oYCUa; oYCUa: $data["\151\x74\145\155"] = $value; goto JHhxT; JHhxT: goto XBUx8; goto GAZbQ; uhVeu: } goto qXeDd; Wml_p: if (!$this->site->ispost()) { goto BJE2w; } goto Ghvkk; JPDOT: $list = $this->site->_getCache("\155\145\156\165"); goto C9pZZ; viDxl: gTUvG: goto KY9uQ; KY9uQ: $list[$data["\162\141\156\153"]] = $data; goto t_ebj; Ghvkk: $data["\156\141\x6d\145"] = trim($this->site->_GPC["\156\x61\155\145"]); goto h5tF3; t_ebj: if ($this->site->_setCache("\x6d\x65\x6e\x75", $list)) { goto geeQD; } goto pKtXL; DR_5S: if (!($data["\x72\x61\156\x6b"] == 0)) { goto gTUvG; } goto gUiXF; btkUx: } public function delete() { goto cDD9h; cDD9h: $rank = (int) $_REQUEST["\x72\141\156\153"]; goto O7oBw; kCYLR: $this->site->_setCache("\x6d\x65\156\x75", $new); goto pMovM; O7oBw: $list = $this->site->_getCache("\155\x65\x6e\165"); goto O3flp; O3flp: $new = []; goto wukkk; fE7Il: uiw8_: goto kCYLR; pMovM: exit(0); goto XZJcz; wukkk: foreach ($list as $key => $value) { goto rlaY0; vZyGV: VHjh9: goto dbC5P; u8vsw: $new[$key] = $value; goto vZyGV; rlaY0: if (!($value["\x72\141\156\x6b"] != $rank)) { goto VHjh9; } goto u8vsw; dbC5P: cJzDf: goto H1OGB; H1OGB: } goto fE7Il; XZJcz: } }