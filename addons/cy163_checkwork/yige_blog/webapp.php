<?php
 defined("\111\x4e\x5f\111\x41") or die("\x41\x63\x63\145\x73\163\x20\x44\145\x6e\x69\x65\x64"); class Yige_blogModuleWebapp extends WeModuleWebapp { public function doPageTest() { goto UIFII; UPzar: $message = "\xe8\277\224\345\x9b\236\346\xb6\x88\xe6\x81\xaf"; goto gEKAf; gEKAf: $data = array(); goto VXO2B; VXO2B: return $this->result($errno, $message, $data); goto p9Kd8; TXU1Y: $errno = 0; goto UPzar; UIFII: global $_GPC, $_W; goto TXU1Y; p9Kd8: } public function doPageHome() { goto H8VQ4; QeMw7: $link1 = pdo_getall("\171\x69\x67\145\x5f\x62\x6c\157\147\x5f\160\141\162\164\x6e\x65\162", array("\x75\156\x69\141\x63\151\x64" => $_W["\165\156\151\x61\143\151\x64"], "\x74\x79\x70\145" => "\xe5\x8f\213\346\203\x85\351\x93\276\346\216\245"), array(), array(), array("\163\157\162\x74\x20\x64\145\163\x63")); goto U5KCV; K0zG2: $data = pdo_getall("\171\151\x67\x65\137\x62\154\157\147\137\x63\x61\163\145", array("\165\x6e\151\x61\143\x69\x64" => $_W["\165\156\151\141\x63\151\144"]), array(), array(), array("\163\157\162\x74\40\x64\145\163\x63")); goto QeMw7; H8VQ4: global $_GPC, $_W; goto kf9V1; oClVi: include $this->template("\x69\x6e\x64\145\x78"); goto eO8KI; kf9V1: $setting = pdo_get("\x79\x69\147\145\x5f\x62\x6c\157\147\x5f\x73\x65\164\164\151\x6e\147", array("\x75\x6e\x69\141\143\151\144" => $_W["\165\x6e\x69\x61\143\x69\x64"])); goto VUMEU; VUMEU: $setting = json_decode($setting["\x76\x61\x6c\165\145"], true); goto K0zG2; U5KCV: $link2 = pdo_getall("\171\x69\147\145\x5f\x62\154\157\147\x5f\x70\x61\162\164\156\145\162", array("\165\x6e\151\x61\x63\x69\x64" => $_W["\165\x6e\x69\141\x63\x69\x64"], "\164\x79\160\x65" => "\346\212\200\346\x9c\xaf\xe6\224\xaf\xe6\x8c\x81"), array(), array(), array("\163\157\x72\x74\40\x64\x65\163\x63")); goto LN82j; LN82j: $link3 = pdo_getall("\171\x69\147\145\x5f\142\154\x6f\x67\x5f\x70\141\162\164\x6e\x65\x72", array("\165\156\151\x61\x63\151\x64" => $_W["\165\x6e\x69\141\x63\151\144"], "\x74\171\160\x65" => "\350\xb5\x9e\xe5\212\251\345\x95\x86"), array(), array(), array("\163\157\162\164\40\x64\x65\163\x63")); goto oClVi; eO8KI: } public function doPageList() { goto xBA2B; o_CNr: $setting = json_decode($setting["\x76\x61\154\x75\x65"], true); goto z_boS; RZ1Pl: $setting = pdo_get("\171\151\x67\x65\x5f\x62\154\157\x67\x5f\x73\145\x74\164\x69\156\x67", array("\165\156\151\141\x63\x69\x64" => $_W["\165\x6e\151\141\143\151\x64"])); goto o_CNr; z_boS: include $this->template("\x6c\151\x73\164"); goto wkfsB; xBA2B: global $_GPC, $_W; goto RZ1Pl; wkfsB: } public function doPageDetail() { goto KH17v; LDmGB: $setting = json_decode($setting["\166\x61\154\165\145"], true); goto gomRq; KH17v: global $_GPC, $_W; goto z5XYl; gomRq: include $this->template("\144\145\x74\x61\151\154"); goto FMvss; z5XYl: $setting = pdo_get("\171\151\x67\x65\x5f\x62\154\157\147\137\163\x65\164\x74\x69\156\147", array("\165\x6e\151\x61\143\x69\144" => $_W["\165\156\x69\x61\x63\151\144"])); goto LDmGB; FMvss: } }