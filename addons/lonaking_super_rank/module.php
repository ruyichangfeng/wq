<?php
/*
 __________________________________________________
|  Encode by BajieTeam on we7                      |
|__________________________________________________|
*/
 defined("\111\116\137\111\x41") or die("\x41\x63\x63\x65\x73\x73\40\x44\145\156\x69\x65\144"); class Lonaking_super_rankModule extends WeModule { public function fieldsFormDisplay($rid = 0) { } public function fieldsFormValidate($rid = 0) { return ''; } public function fieldsFormSubmit($rid) { } public function ruleDeleted($rid) { } public function settingsDisplay($settings) { goto FsKBo; mG1mx: $flag = $this->saveSettings($data); goto c8x9n; DAUYp: zEjcq: goto A9L4A; A9L4A: message("\344\277\xa1\346\201\xaf\xe4\277\235\345\255\x98\346\210\220\345\212\x9f", '', "\163\165\x63\143\x65\x73\x73"); goto EhUY6; FsKBo: global $_W, $_GPC; goto vyRvS; a1ZOO: include $this->template("\x73\x65\x74\x74\151\156\x67"); goto tawSX; c8x9n: if ($flag) { goto zEjcq; } goto UjBTV; EhUY6: dB4fe: goto QHYdU; zr02C: if (!checksubmit()) { goto cMTP1; } goto mG1mx; QHYdU: cMTP1: goto kHZsN; kHZsN: load()->func("\164\x70\154"); goto a1ZOO; UjBTV: message("\xe4\xbf\xa1\xe6\201\257\344\xbf\x9d\345\xad\x98\345\244\261\xe8\264\245", '', "\x65\162\162\x6f\162"); goto GLccQ; GLccQ: goto dB4fe; goto DAUYp; vyRvS: $data = $_GPC["\x64\x61\164\x61"]; goto zr02C; tawSX: } }
