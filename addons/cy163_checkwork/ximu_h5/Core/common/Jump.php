<?php
/*   __________________________________________________
    |  Obfuscated by YAK Pro - Php Obfuscator          |
    |              on 2018-05-26 11:06:03              |
    |    GitHub: https://github.com/pk-fr/yakpro-po    |
    |__________________________________________________|
*/
 namespace Core\common; trait Jump { public function success($data = array(), $code = 0, $msg = "\xe6\223\215\344\xbd\234\346\210\x90\345\x8a\237") { $this->back($code, $msg, $data); } public function error($code = 204, $data = array(), $msg = '') { $this->back($code, $msg, $data); } public function back($code = 0, $msg = '', $data = array()) { goto dhyLz; sBUHb: wJtwb: goto oFJjG; m25at: pFbn2: goto IyxBn; bHKMc: if (0 === $code) { goto pFbn2; } goto wnwKj; m7yqr: goto chCIO; goto m25at; LwF1c: if (!('' == $msg)) { goto AFKPP; } goto mkKD6; wnwKj: $status = "\145\162\x72\157\162"; goto m7yqr; IyxBn: $status = "\163\165\x63\x63\145\x73\x73"; goto EWBng; oFJjG: AFKPP: goto bHKMc; mkKD6: if (!isset($codeInfo[$code])) { goto wJtwb; } goto tdy14; EWBng: chCIO: goto JuDNO; tdy14: $msg = $codeInfo[$code]; goto sBUHb; P9fv6: Response::json($ret); goto Ik3he; JuDNO: $ret = array("\143\157\144\145" => $code, "\x73\164\141\164\x75\163" => $status, "\x64\141\164\x61" => $data, "\x6d\163\147" => $msg, "\164\x69\155\x65" => $_SERVER["\x52\105\121\125\105\x53\x54\137\x54\111\115\105"]); goto P9fv6; dhyLz: $codeInfo = array(-1 => "\xe6\223\215\xe4\275\234\345\xa4\261\xe8\xb4\245", 0 => "\346\255\243\xe5\xb8\270\xe8\xbf\x94\345\233\236\346\225\xb0\xe6\215\xae", 1 => "\347\274\272\xe5\xb0\221\345\277\x85\xe8\xa6\x81\xe7\232\204\xe5\217\202\346\x95\xb0", 2 => "\xe5\x8f\x82\346\x95\260\xe6\240\274\345\xbc\217\xe4\270\215\xe6\xad\243\xe7\241\256", 3 => "\351\235\236\xe6\xb3\225\347\x94\xa8\346\210\xb7", 11 => "\346\227\xa0\xe6\263\x95\xe5\223\x8d\xe5\272\224", 204 => "\xe6\227\240\xe5\x86\x85\xe5\256\xb9", 301 => "\xe8\xb5\204\346\xba\x90\345\x9c\xb0\345\x9d\200\345\xb7\262\347\247\xbb\xe5\x8a\xa8", 400 => "\350\xaf\xb7\xe6\xb1\202\347\232\204\345\217\202\xe6\225\260\351\224\x99\350\xaf\257", 401 => "\350\257\xb7\xe6\xb1\x82\xe8\246\x81\xe6\xb1\x82\xe7\224\xa8\xe6\x88\267\347\x9a\x84\xe8\xba\xab\344\273\275\350\xae\244\xe8\xaf\201", 403 => "\xe8\xaf\xb7\346\xb1\x82\xe8\xa2\xab\346\213\222\xe7\xbb\x9d", 404 => "\xe9\224\231\xe8\257\xaf\xe6\210\226\344\xb8\215\xe5\xad\230\xe5\234\xa8\xe7\x9a\204\xe6\x95\260\xe6\x8d\256", 500 => "\xe6\234\x8d\xe5\212\xa1\xe5\231\250\345\x86\205\xe9\x83\250\351\x94\231\350\257\257\xef\274\214\346\x97\240\xe6\xb3\225\345\xae\214\xe6\x88\x90\350\257\267\346\261\202", 740 => "\347\250\x8b\xe5\272\x8f\351\x94\x99\350\257\257"); goto LwF1c; Ik3he: } }