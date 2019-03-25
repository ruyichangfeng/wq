<?php
/*   __________________________________________________
    |  Obfuscated by YAK Pro - Php Obfuscator          |
    |              on 2018-07-11 14:50:05              |
    |    GitHub: https://github.com/pk-fr/yakpro-po    |
    |__________________________________________________|
*/
 class AddressController extends CallMobileBaseController { public $size = 10; public function index() { goto W6WFz; YUUGd: $this->UserModel->update(["\151\144" => $this->uid], $t); goto LLSbw; lrf70: $data["\164\x69\164\x6c\145"] = "\346\210\x91\347\232\x84\346\224\xb6\350\216\267\xe5\x9c\260\xe5\x9d\x80"; goto Wsbiw; zDLDA: $t["\x6d\157\142\x69\154\x65"] = trim($_POST["\155\x6f\142\x69\154\x65"]); goto BL7Qw; BL7Qw: $t["\x61\x64\x64\x72\145\163\x73"] = trim($_POST["\141\x64\144\162\145\163\x73"]); goto YUUGd; Wsbiw: $t["\156\141\155\x65"] = trim($_POST["\156\141\x6d\x65"]); goto zDLDA; FP1sL: EDIb0: goto lrf70; W6WFz: if ($this->uid) { goto EDIb0; } goto HycpH; LLSbw: $this->ajaxReturn(200, ''); goto BnExi; HycpH: $this->ajaxReturn(300, "\350\257\267\xe6\x82\250\xe5\x9c\xa8\345\xbe\xae\344\277\xa1\347\xab\xaf\346\211\223\345\xbc\200"); goto FP1sL; BnExi: } }