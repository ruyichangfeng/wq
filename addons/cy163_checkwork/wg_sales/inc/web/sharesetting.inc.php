<?php
/*   __________________________________________________
    |  Obfuscated by YAK Pro - Php Obfuscator          |
    |              on 2018-08-04 11:37:54              |
    |    GitHub: https://github.com/pk-fr/yakpro-po    |
    |__________________________________________________|
*/
 class Wg_sales_Web_Sharesetting extends SalesBaseController { public $cate = array(); public function init() { parent::init(); $this->uid = $this->site->_W["\x75\x6e\x69\141\143\x69\x64"]; } public function index() { goto VMmFe; t70l7: $this->site->assign($data); goto Sueuo; edBeA: message("\346\233\264\346\226\xb0\xe6\210\220\xe5\212\237", $this->site->webUrl("\x73\150\141\x72\145\x73\145\x74\164\x69\156\x67")); goto cPOwN; VMmFe: $data = $this->site->_getCache("\x73\x68\141\162\x65"); goto xXEMg; WoPiE: iYF69: goto t70l7; nksxb: $write["\x70\x69\x63\165\x72\154"] = trim($this->site->_GPC["\x70\x69\x63\165\162\x6c"]); goto CbU17; kUU9i: imApB: goto edBeA; IaCOR: $write["\164\x69\164\x6c\145"] = trim($this->site->_GPC["\x74\x69\x74\154\145"]); goto H19v3; cPOwN: se5v3: goto WoPiE; xXEMg: if (!$this->site->ispost()) { goto iYF69; } goto IaCOR; OsyRQ: goto se5v3; goto kUU9i; H19v3: $write["\144\x65\163\x63\x72\x69\160\x74\151\x6f\156"] = trim($this->site->_GPC["\x64\145\163\143\x72\x69\x70\x74\151\x6f\x6e"]); goto nksxb; CbU17: if ($this->site->_setCache("\163\x68\141\162\145", $write)) { goto imApB; } goto iVD4K; iVD4K: message("\345\206\x99\xe5\205\xa5\345\244\xb1\xe8\xb4\245", $this->site->webUrl("\x73\x68\141\x72\x65\163\x65\164\x74\151\x6e\x67")); goto OsyRQ; Sueuo: } }