<?php
 defined("\111\116\x5f\x49\x41") or exit("\101\143\143\x65\163\163\40\x44\x65\156\151\x65\144"); class Lyp_welcomefullpageModuleWebapp extends WeModuleWebapp { public function __construct() { global $_W; $this->welcome = pdo_get("\x6c\171\x70\137\167\x65\x6c\143\x6f\155\145\x66\165\x6c\x6c\160\x61\x67\x65", array("\x75\156\151\x61\x63\151\144" => $_W["\165\156\x69\x61\x63\x69\144"])); } public function doPageIndex() { goto uzNtY; MxvCv: $about = !empty($welcome["\x61\142\x6f\165\164"]) ? iunserializer($welcome["\141\x62\x6f\x75\164"]) : array(); goto gnBGN; uzNtY: global $_W; goto zQ_bt; KZDE2: $technology = !empty($welcome["\164\x65\143\x68\x6e\157\x6c\x6f\x67\171"]) ? iunserializer($welcome["\164\145\143\150\156\157\154\x6f\147\x79"]) : array(); goto BAz1a; Vd5FH: $business = !empty($welcome["\142\165\163\x69\x6e\145\x73\x73"]) ? iunserializer($welcome["\142\x75\x73\151\156\145\x73\x73"]) : array(); goto v0txN; v0txN: $case = !empty($welcome["\143\x61\x73\145"]) ? iunserializer($welcome["\x63\141\x73\x65"]) : array(); goto KZDE2; rWZZu: $home = !empty($welcome["\x68\x6f\x6d\x65"]) ? iunserializer($welcome["\x68\157\x6d\x65"]) : array(); goto Vd5FH; gnBGN: $connect = !empty($welcome["\143\157\x6e\x6e\145\143\x74"]) ? iunserializer($welcome["\x63\x6f\x6e\156\x65\143\164"]) : array(); goto Q56z1; s7W08: include $this->template("\x77\145\154\143\157\155\145"); goto uzMRM; BAz1a: $marketing = !empty($welcome["\155\141\x72\x6b\145\x74\151\156\x67"]) ? iunserializer($welcome["\155\x61\162\x6b\x65\164\151\156\147"]) : array(); goto MxvCv; QkCg5: $topmenu = !empty($welcome["\x6d\145\x6e\165"]) ? iunserializer($welcome["\x6d\x65\156\165"]) : array(); goto rWZZu; Q56z1: $other = !empty($welcome["\157\x74\150\x65\x72"]) ? iunserializer($welcome["\157\x74\x68\x65\162"]) : array(); goto s7W08; zQ_bt: $welcome = $this->welcome; goto QkCg5; uzMRM: } }