<?php
/*   __________________________________________________
    |  Obfuscated by YAK Pro - Php Obfuscator          |
    |              on 2018-05-26 11:06:35              |
    |    GitHub: https://github.com/pk-fr/yakpro-po    |
    |__________________________________________________|
*/
 namespace Core\model; use Core\common\Model; use Core\common\Request; class wxapp extends Model { private static $attachurl; function __construct() { global $_W; self::$attachurl = $_W["\141\164\x74\x61\x63\x68\165\162\x6c"]; } public function getSlide() { $sidle = $this->table("\150\x35\x5f\x73\x6c\151\144\145")->where(array("\x73\164\141\164\x75\x73" => 1))->order("\x61\x64\x64\137\x74\151\x6d\x65\x20\x64\x65\163\x63")->limit(0, 10)->select(); return $this->_formatList($sidle); } public function getSysInfo() { goto eYGRQ; VLB2S: u9KU3: goto QY8QD; eYGRQ: $config = $this->table("\150\65\137\143\x6f\x6e\x66\x69\147")->field("\x63\157\x6e\164\x65\156\164")->select(); goto yZGYO; R6sUf: foreach ($config as $item) { goto s8Qdc; TN341: $configs = array_merge($configs, $item); goto AodVH; s8Qdc: $item = json_decode($item["\143\x6f\x6e\164\x65\156\164"], true); goto TN341; AodVH: g2wkP: goto nq7VE; nq7VE: } goto VLB2S; yZGYO: $configs = array(); goto R6sUf; QY8QD: return $configs; goto dvcaq; dvcaq: } public function catsList() { $list = array(array("\x69\x64" => "\x31", "\156\141\155\x65" => "\345\x85\xb3\344\xba\216\xe6\210\221\xe4\xbb\xac", "\x74\150\x75\155\x62" => "\56\57\141\x62\157\165\164\x2e\x70\156\147", "\x74\x79\x70\x65" => 1, "\x75\x72\x6c" => "\x2e\x2e\x2f\141\x62\x6f\x75\x74\x2f\141\x62\x6f\165\164"), array("\151\144" => "\62", "\x6e\141\155\145" => "\xe4\xba\xa7\345\223\x81\xe5\xb1\225\xe7\244\272", "\164\x68\x75\x6d\x62" => "\56\x2f\x70\162\157\x64\165\x63\x74\56\160\x6e\147", "\164\x79\160\145" => 1, "\165\162\x6c" => "\x2e\56\x2f\154\x69\163\x74\57\154\x69\x73\x74\77\164\x79\x70\x65\75\x32"), array("\x69\144" => "\63", "\156\141\155\145" => "\346\226\xb0\351\227\xbb\xe8\265\x84\350\xae\257", "\x74\x68\165\155\142" => "\56\x2f\x6e\145\167\x73\56\160\x6e\x67", "\164\171\x70\x65" => 2, "\165\x72\154" => "\x2e\56\57\x6c\151\163\x74\57\x6c\x69\x73\164"), array("\x69\144" => "\x34", "\x6e\141\155\x65" => "\350\201\224\347\263\273\346\210\x91\xe4\273\254", "\x74\x68\165\x6d\142" => "\x2e\x2f\143\157\x6e\164\x61\143\164\x2e\x70\x6e\x67", "\164\171\160\x65" => 1, "\x75\162\x6c" => "\56\56\x2f\x63\x6f\156\164\x61\143\x74\57\x63\x6f\x6e\x74\141\143\x74")); return $list; } public function getShowList() { goto j8541; j8541: $newsList = $this->table("\x68\65\x5f\x6e\145\167\x73")->where(array("\x73\164\141\x74\165\x73" => 1, "\151\x6e\144\145\170" => 1))->order("\x73\x6f\x72\x74\x20\x64\145\x73\x63\x20\141\144\144\x5f\x74\151\x6d\x65\x20\x64\x65\163\x63")->limit(0, 8)->select(); goto Yz7xh; be1Tp: return $list; goto H9Yzc; Yz7xh: $productList = $this->table("\150\65\x5f\x6c\151\163\x74")->where(array("\163\164\x61\x74\x75\x73" => 1))->order("\163\157\162\x74\x20\x64\145\163\143\40\141\x64\x64\137\x74\x69\155\145\40\144\145\163\x63")->limit(0, 5)->select(); goto vAjR3; vAjR3: $list = array(array("\x69\144" => 2, "\156\141\155\x65" => "\xe4\272\247\xe5\x93\201\345\xb1\x95\xe7\244\272", "\x74\x79\160\x65" => 1, "\154\151\163\x74" => $this->_formatList($productList), "\165\x72\x6c" => "\x2e\x2e\57\154\x69\163\x74\x2f\154\151\163\164\x3f\164\x79\160\x65\x3d\62"), array("\151\144" => 3, "\x6e\141\x6d\x65" => "\346\x96\xb0\xe9\x97\xbb\350\265\x84\350\256\257", "\x74\x79\160\x65" => 2, "\x6c\151\163\164" => $this->_formatList($newsList), "\x75\162\x6c" => "\56\56\57\154\x69\x73\x74\57\x6c\151\x73\164")); goto be1Tp; H9Yzc: } private function _formatList($list) { goto ZnI82; ZnI82: foreach ($list as $k => $v) { goto A5Mz_; Wv9jw: $list[$k]["\151\x6d\x61\147\145\x73"] = self::$attachurl . $v["\x69\x6d\x61\x67\x65\x73"]; goto WnGKZ; PuZES: if (!$v["\163\x68\x6f\167\137\151\155\147"]) { goto qb6N9; } goto P_5q0; VeWuK: $list[$k]["\x75\x72\x6c"] = "\x2e\x2e\57\143\x6f\x6e\164\x65\156\164\x2f\143\157\156\164\x65\x6e\164\77\151\x64\75" . $v["\x69\144"]; goto NyABx; A5Mz_: if (!$v["\x69\155\141\x67\145\163"]) { goto GP78x; } goto Wv9jw; s2diD: hct5N: goto PuZES; rhVlR: $list[$k]["\x74\x68\x75\x6d\142"] = self::$attachurl . $v["\151\x6d\147"]; goto s2diD; vQMCi: oymi8: goto e9nrv; WnGKZ: GP78x: goto WmZ1W; ALo5j: $list[$k]["\x75\x72\154"] = "\56\56\x2f\x63\157\156\x74\145\x6e\x74\x2f\143\157\156\164\x65\156\x74\x3f\x74\x79\160\145\75\62\x26\151\144\75" . $v["\x69\x64"]; goto vQMCi; NyABx: if (!$v["\x69\x6d\x67"]) { goto oymi8; } goto ALo5j; WmZ1W: if (!$v["\151\x6d\147"]) { goto hct5N; } goto rhVlR; lqZ_G: $list[$k]["\x74\151\164\154\x65"] = isset($v["\156\x61\x6d\145"]) ? $v["\x6e\141\x6d\x65"] : $v["\x74\x69\164\x6c\x65"]; goto OmvZv; P_5q0: $list[$k]["\x74\150\x75\155\x62"] = self::$attachurl . $v["\x73\x68\157\x77\137\x69\x6d\147"]; goto QisRm; e9nrv: zAOit: goto p6mil; OmvZv: $list[$k]["\x61\x64\x64\137\x74\151\155\145"] = date("\x59\55\x6d\55\x64\x20\x48\72\151\72\x73", $v["\141\144\144\x5f\x74\151\x6d\145"]); goto VeWuK; QisRm: qb6N9: goto lqZ_G; p6mil: } goto K7op7; hXx7o: return $list; goto SO9Bd; K7op7: SehFp: goto hXx7o; SO9Bd: } public function dataList() { goto X6uy9; VKILj: $list = $this->table("\x68\65\137\x6c\151\x73\x74")->field("\x69\x64\54\156\x61\x6d\145\54\151\x6d\147\x2c\x61\144\144\137\x74\x69\155\145")->where(array("\163\164\141\x74\x75\x73" => 1))->limit($page, 8)->order("\141\x64\144\137\x74\151\155\145\40\x64\x65\x73\143")->select(); goto g2UTy; z7kpo: $list = $this->table("\x68\65\x5f\156\x65\x77\x73")->field("\151\x64\54\164\x69\164\x6c\145\x2c\x73\x68\x6f\167\x5f\x69\x6d\147\54\x61\x64\x64\137\x74\151\x6d\x65")->where(array("\x73\164\x61\164\165\x73" => 1))->limit($page, 8)->order("\x61\144\x64\137\164\151\x6d\145\40\144\x65\x73\x63")->select(); goto yOws3; t0DS7: eY4vO: goto VKILj; g2UTy: $catName = "\344\xba\247\xe5\x93\x81\xe5\xb1\225\347\244\xba"; goto QhQhr; kW4lR: $data = array("\x6c\151\163\x74" => $this->_formatList($list), "\143\141\x74\x6e\141\155\x65" => $catName, "\137\160\141\x67\145" => $page + 1); goto TPRZb; QhQhr: AW5ek: goto kW4lR; eqcBL: if ($type == 2) { goto eY4vO; } goto z7kpo; nPVIw: goto AW5ek; goto t0DS7; X6uy9: $type = Request::params("\164\171\160\x65"); goto izYBU; yOws3: $catName = "\346\x96\260\xe9\x97\xbb\345\222\xa8\350\257\xa2"; goto nPVIw; izYBU: $page = Request::params("\x70\141\x67\145"); goto eqcBL; TPRZb: return $data; goto J9n8i; J9n8i: } public function getOne() { goto s2RBx; YHgQh: tuHaj: goto n3uMk; J3PW5: $data["\x63\x6f\x6e\x74\145\156\x74"] = $data["\x64\x65\163\x63"]; goto CmyQ9; hXnhE: $data = Model::table("\x68\x35\x5f\x6e\x65\x77\163")->where(array("\151\144" => $id))->find(); goto c0C3K; B5JNs: if ($type == 2) { goto tuHaj; } goto hXnhE; s2RBx: $id = Request::params("\151\x64"); goto OB7zI; OB7zI: $type = Request::params("\164\171\160\145", 1); goto B5JNs; c0C3K: goto f46YJ; goto YHgQh; CmyQ9: f46YJ: goto SA7sS; ctTD2: return $data; goto g6x40; n3uMk: $data = Model::table("\150\65\x5f\x6c\151\163\164")->where(array("\151\144" => $id))->find(); goto nr17v; nr17v: $data["\164\x69\x74\154\145"] = $data["\156\x61\155\145"]; goto J3PW5; SA7sS: $data["\x61\144\144\x5f\164\x69\155\145"] = date("\x59\x2d\x6d\x2d\x64\40\x48\x3a\x69\72\163", $data["\x61\x64\x64\x5f\164\x69\155\145"]); goto ctTD2; g6x40: } public function getSet($key) { goto RZBeB; IrJmd: $data = json_decode($data["\143\x6f\156\x74\145\x6e\164"], true); goto aDVDW; aDVDW: return $data; goto sUSuX; RZBeB: $data = Model::table("\150\x35\137\143\x6f\156\146\x69\x67")->where(array("\x6b\145\171" => $key))->find(); goto IrJmd; sUSuX: } }