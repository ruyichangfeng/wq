<?php
 class Home extends ZskWxapp { public function sensitive() { return ["\152\x6f\151\156" => "\xe5\x85\245\351\xa9\xbb", "\x73\x68\x6f\x70" => "\xe5\225\x86\xe5\256\266", "\x61\x67\x65\x6e\164" => "\345\x88\206\351\224\x80", "\162\165\172\x68\x75" => "\xe5\x85\xa5\351\xa9\xbb"]; } public function getSetting() { goto UgPrX; lXrhI: $set["\x73\145\156\x73\151\x74\151\x76\x65"] = $this->sensitive(); goto DrRXp; DrRXp: echo JSON_OUT($set, true); goto i0BG3; UgPrX: $set = getSetting($_GPC["\x73\x74\171\160\x65"], true); goto lXrhI; i0BG3: } public function verify() { goto meATH; WLWj6: $set = Model("\x73\145\164\164\151\156\147")->where("\x75\156\x69\141\x63\x69\144\75" . $uniacid)->get("\x75\x6e\151\x61\143\151\144\54\x77\x78\141\160\x70\x5f\x6c\x61\171\x6f\165\x74"); goto CCajz; QWBwB: $uniacid = intval($_W["\x75\x6e\x69\x61\x63\x69\x64"]); goto YnRwR; Zjf4l: echo JSON_OUT(["\x6d\x6f\x64\165\x6c\x65" => $module, "\166\145\x72\151\146\171" => $verify]); goto Fq3qa; tZOmR: $verify = ["\165\x72\x6c" => $vers["\x69\x6e\x64\x65\x78\137\x76\145\x72\x69\146\x79\137\167\145\142\165\162\x6c"], "\151\x6e\x64\145\x78\137\x76\145\x72\151\x66\171\137\x6d\x6f\x64\145" => $vers["\151\x6e\144\x65\x78\x5f\x76\145\162\151\146\x79\137\x6d\x6f\144\x65"], "\163\x74\141\164\165\163" => 0]; goto Zjf4l; meATH: global $_W, $_GPC; goto QWBwB; KSkfl: $module = pdo_fetch("\123\x45\x4c\x45\103\x54\x20\156\x61\x6d\x65\54\166\145\162\x73\151\x6f\x6e\40\x46\122\x4f\115\40{$tab}\x20\127\x48\105\x52\105\40\x6e\x61\x6d\145\x3d\x27\172\163\x6b\x5f\155\x61\x72\153\145\x74\47\x20\114\111\x4d\x49\124\x20\61"); goto WLWj6; YnRwR: $tab = tablename("\x6d\157\x64\x75\154\x65\x73"); goto KSkfl; CCajz: $vers = json_decode($set["\x77\x78\141\160\160\x5f\x6c\x61\x79\157\x75\164"], true); goto Ae1ga; Ae1ga: $url = $vers["\151\156\144\x65\x78\x5f\166\145\162\151\x66\x79\x5f\167\x65\142\165\x72\x6c"]; goto tZOmR; Fq3qa: } public function getToken() { goto Ii_OH; eZcfY: $token = $wx->getToken(); goto FMFpU; FMFpU: echo json_encode($token, true); goto UStfY; bHIQR: $set = getSetting(); goto cJ8zH; cJ8zH: $wx = new WeixinJS($set["\141\160\160\151\144"], $set["\x73\145\x63\162\x65\x74"]); goto eZcfY; Ii_OH: global $_W, $_GPC; goto bHIQR; UStfY: } public function advert() { $this->index(); } public function getAboutInfo() { goto j6ckF; NpoCV: $about = $model->where("\x75\156\151\x61\143\151\144\x20\x3d\40{$uniacid}")->get("\141\x62\157\165\164"); goto GXU01; qH9hp: $model = Model("\143\x6f\160\x79\x72\x69\x67\150\164"); goto FfPGB; GXU01: echo JSON_OUT($about["\141\x62\x6f\165\x74"]); goto e66my; FfPGB: $uniacid = intval($_W["\165\156\x69\141\x63\151\144"]); goto NpoCV; j6ckF: global $_W, $_GPC; goto qH9hp; e66my: } public function index() { goto MTvgl; TeKfM: array_push($navbar, array("\164\x65\170\x74" => "\345\210\x86\xe7\261\273", "\164\171\x70\145" => "\x63\x61\164\145", "\141\x63\164\151\x76\145" => 0)); goto KJi9q; vTsXC: array_push($navbar, array("\164\x65\x78\164" => "\xe5\217\221\xe7\216\xb0", "\164\x79\x70\145" => "\x66\x69\x6e\144", "\141\x63\164\151\x76\145" => 0)); goto injeW; rxdXB: if (!($set["\167\x78\141\160\160\x5f\x6c\x61\171\x6f\165\164"]["\164\x61\x62\x62\141\162\x5f\x6d\x69\141\157\163\x68\141\137\x73\164\141\x74\165\163"] == "\x6f\x6e")) { goto UdGN2; } goto Knd_J; Lh9k1: VgLLI: goto Xn33u; ATaLO: if (!($set["\x77\x78\x61\x70\160\137\154\x61\x79\x6f\165\164"]["\x74\141\142\x62\x61\162\137\x63\x61\x72\x74\137\163\164\141\164\x75\163"] != "\157\x66\146")) { goto XAK0b; } goto DT1Uj; Ih3Xn: array_push($navbar, array("\x74\x65\x78\164" => "\xe6\x88\x91\347\232\x84", "\x74\x79\x70\145" => "\155\x69\x6e\x65", "\x61\x63\164\151\x76\x65" => 0)); goto PW7YY; toIRm: foreach ($adverts as $key => $val) { goto Ei85Q; zAlaV: Jzuag: goto WxU40; WxU40: Gp9GN: goto C0LEI; hLPDg: GR2SJ: goto zAlaV; Ei85Q: if (!($val["\164\x79\160\x65"] == "\x67\x6f\157\x64\163" && $val["\152\165\155\x70\x74\x79\x70\x65"] == "\147\157\157\144\x73")) { goto Jzuag; } goto w_6on; w_6on: foreach ($goodslist as $k => $v) { goto X2hjl; X2hjl: if (!($v["\156\x75\x6d\142\145\162"] == $val["\147\157\x6f\144\163\156\x75\x6d"])) { goto bIxvK; } goto gqsee; sEN5b: $v["\x74\x79\160\145"] = "\x67\157\157\x64\163"; goto z87p5; gqsee: $v["\151\144"] = $val["\151\x64"]; goto HcsYF; z87p5: $v["\x6a\165\x6d\160\164\x79\x70\145"] = "\147\x6f\x6f\144\x73"; goto lsUVQ; Mzc7c: ZrdCb: goto lID70; lsUVQ: $adverts[$key] = $v; goto P9Dah; P9Dah: bIxvK: goto Mzc7c; HcsYF: $v["\x70\151\x64"] = $val["\160\141\162\145\156\x74\x69\144"]; goto sEN5b; lID70: } goto hLPDg; C0LEI: } goto bT_po; F3PSz: $copyright = Model("\x63\x6f\160\171\x72\151\x67\x68\x74")->where("\x75\156\151\x61\143\x69\x64\75" . $uniacid)->get(); goto BjR30; FiAUJ: $model = Model("\150\157\155\145\141\144\166\145\162\x74"); goto TevtP; SIMYy: $m3 = Model("\x67\157\157\144\x73"); goto BpXI4; fFlDe: if (!($set["\x77\x78\x61\x70\160\x5f\154\141\x79\157\165\x74"]["\164\141\x62\x62\141\162\x5f\153\141\156\x6a\x69\x61\137\163\x74\x61\164\165\x73"] == "\x6f\156")) { goto OYmGp; } goto X_78a; injeW: yxlhh: goto ATaLO; m6poW: $adverts = $model->order("\163\x6f\162\x74\x20\x61\163\x63")->where("\165\156\x69\x61\143\151\144\75{$uniacid}\x20\141\x6e\144\40\x73\x74\x61\x74\x75\163\76\x30")->getall("\52\54\x70\141\x72\x65\156\164\x69\144\40\x61\x73\40\160\151\144"); goto Qco3h; PW7YY: $model = Model("\151\x74\x65\x6d"); goto qMeFc; eC2OL: $navbar = array(array("\x74\x65\170\x74" => "\xe9\246\226\351\241\xb5", "\x74\x79\160\x65" => "\151\156\144\x65\170", "\x61\x63\164\151\x76\x65" => 1)); goto yngRQ; qMeFc: $item = $model->where("\165\x6e\x69\x61\143\x69\144\x3d{$uniacid}")->order("\163\x6f\162\x74\x20\x61\x73\143")->getall(); goto i88kx; h9gM8: if (!($set["\167\x78\141\160\x70\x5f\x6c\x61\x79\157\x75\x74"]["\164\x61\x62\142\141\162\x5f\160\151\156\x74\x75\x61\156\x5f\163\x74\x61\164\165\x73"] == "\x6f\156")) { goto iEuxO; } goto y31Ca; Knd_J: array_push($navbar, array("\164\x65\x78\164" => "\347\xa7\222\346\235\200", "\x74\171\160\145" => "\155\151\141\157\163\150\141", "\141\x63\x74\x69\x76\x65" => 0)); goto YtR97; jSx86: $time = date("\131\55\155\x2d\x64\x20\x48\72\x69\x3a\163", time()); goto m6poW; yngRQ: if (!($set["\x77\x78\141\x70\x70\x5f\154\141\x79\157\x75\x74"]["\x74\141\142\x62\x61\x72\137\143\x61\164\x65\x5f\163\164\x61\164\165\x73"] != "\x6f\146\146")) { goto N33ID; } goto TeKfM; DT1Uj: array_push($navbar, array("\164\x65\170\x74" => "\xe8\264\xad\xe7\x89\251\xe8\xbd\246", "\164\171\x70\145" => "\143\141\162\164", "\x61\143\x74\x69\x76\145" => 0)); goto ypokp; MTvgl: global $_W, $_GPC; goto FiAUJ; N5B0X: MOeTR: goto fFlDe; BjR30: $set["\163\x65\x6e\x73\x69\164\151\166\x65"] = $this->sensitive(); goto Xp4Hm; ME2IA: OYmGp: goto rxdXB; Xp4Hm: $data = array("\164\x61\142\142\x61\x72" => $navbar, "\x61\x74\x74\x61\143\x68\x75\x72\x6c" => $_W["\x61\164\164\141\143\150\x75\x72\154"], "\141\144\166\145\162\x74\x73" => $adverts, "\x69\x74\x65\155\x73" => $item, "\163\x68\x6f\x70" => $shop, "\x6d\x6f\144\165\x6c\x65" => $module, "\163\145\x74\164\x69\x6e\x67" => $set, "\143\x6f\160\x79\162\x69\x67\150\x74" => $copyright); goto FTaqI; TevtP: $uniacid = intval($_W["\165\x6e\x69\x61\143\151\144"]); goto jSx86; LkRJG: $nums = substr($nums, 0, strlen($nums) - 1); goto SIMYy; OoHYl: foreach ($adverts as $key => $val) { goto osiIJ; TlDil: $nums .= $val["\x67\157\x6f\x64\163\156\x75\x6d"] . "\54"; goto RK5lN; osiIJ: if (!($val["\164\171\160\145"] == "\x67\157\157\x64\x73" && $val["\x6a\x75\155\160\x74\171\x70\145"] == "\x67\x6f\157\144\163")) { goto xhoSI; } goto TlDil; cAjmT: r0O_g: goto gi3bG; RK5lN: xhoSI: goto cAjmT; gi3bG: } goto UjmaJ; tsREd: $set = getSetting("\x61\154\154", true); goto eC2OL; Xn33u: $adverts = childtree($adverts); goto tsREd; bT_po: VTN5U: goto Lh9k1; PX0Ss: $goodslist = getGoodsSimpleInfo($goodslist); goto toIRm; Qco3h: $nums = ''; goto OoHYl; BpXI4: $goodslist = $m3->where("\156\165\x6d\x62\x65\x72\x20\x69\x6e\40\50{$nums}\51\40\x61\156\x64\40\163\164\141\164\x75\163\76\x30")->group("\151\x64")->getall("\x69\x64\x2c\x6e\165\x6d\x62\145\x72\54\156\141\x6d\x65\x2c\x70\x72\151\143\x65\x2c\x70\151\143\164\x75\x72\145\54\x70\151\x63\x74\x75\x72\145\x5f\x77\151\x64\145\x2c\x73\164\x61\164\165\163\x2c\163\157\162\164\x2c\x53\125\115\x28\163\x65\154\x6c\x43\x6f\x75\x6e\x74\40\53\40\163\x65\154\x6c\103\157\165\156\164\60\x20\x29\40\101\x53\40\163\x65\x6c\154"); goto PX0Ss; w5rOS: array_push($navbar, array("\x74\145\x78\164" => "\xe6\212\xa2\350\264\xad", "\x74\171\160\145" => "\x73\x6e\141\160", "\141\x63\164\x69\x76\145" => 0)); goto N5B0X; T3ceK: fbtvR: goto F3PSz; pl4sI: iEuxO: goto Yi6Q7; KC67i: foreach ($item as $key => $val) { goto a4oeC; X6TLv: $item[$key]["\143\150\151\154\x64\x72\145\x6e"] = $orders; goto ACjmQ; CqmlL: $tab2 = $model->tablename("\x67\157\157\x64\163"); goto hddQf; tOj5l: $data = $model->query($sql); goto qSgDi; p8dlR: foreach ($cates as $k => $v) { $cids .= $v["\151\144"] . "\54"; Xzmqk: } goto e2CIn; Vz_U2: $sql = "\123\x45\x4c\x45\x43\x54\40{$tab2}\x2e\151\x64\54{$tab3}\x2e\147\x6f\x6f\x64\x73\x69\x64\x2c{$tab2}\56\140\x6e\165\x6d\142\x65\162\x60\x2c{$tab2}\x2e\160\x69\143\x74\165\x72\x65\x2c{$tab2}\56\156\x61\x6d\145\x2c{$tab2}\56\x70\x72\x69\x63\x65\54{$tab2}\56\x75\156\151\x61\143\x69\x64\x2c{$tab2}\x2e\143\141\164\x65\151\144\54{$tab2}\56\x73\145\x6c\154\103\x6f\165\156\x74\x2c{$tab2}\x2e\163\145\x6c\154\x43\x6f\x75\156\x74\60\x2c{$tab3}\56\x69\164\145\155\x69\x64\x20\x46\122\117\x4d\40{$tab2}\40\x4c\105\x46\x54\40\112\x4f\x49\116\40{$tab3}\x20\117\116\40{$tab2}\56\151\x64\75{$tab3}\56\147\157\157\144\163\151\x64\40\127\110\105\x52\x45\40{$tab2}\x2e\163\x74\141\164\x75\163\76\60\x20\x41\116\x44\40{$tab3}\56\151\164\145\155\151\x64\75" . intval($val["\151\x64"]) . "\40\x4f\x52\104\x45\x52\x20\x42\131\40{$tab2}\56\163\x6f\x72\164\40\144\x65\x73\143"; goto hCIqu; hddQf: $tab3 = $model->tablename("\x67\x6f\157\144\163\165\162\x67\145"); goto Vz_U2; ug_0_: if (!($val["\151\x74\145\155\x43\154\x61\x73\x73"] == "\143\x61\x72\157\x75\x73\x65\x6c\55\157\162\x64\x65\162")) { goto aIG1L; } goto lN6CS; TuBFb: $a = $model->tablename("\x73\x6e\x61\160\165\x70"); goto kLmyY; W7qsv: if (!($val["\x69\x74\x65\x6d\103\x6c\141\163\x73"] == "\x67\x6f\x6f\x64\x73\55\157\156\x65\155\157\x6e\145\171")) { goto CJQTf; } goto TuBFb; VGjQr: $cids = substr($cids, 0, strlen($cids) - 1); goto JbzYv; a4oeC: if (!($val["\151\x74\145\x6d\103\154\x61\x73\163"] == "\147\157\x6f\144\163\x2d\143\141\x74\145")) { goto kj6iE; } goto t12E2; AIVbH: if (!(strlen($cids) > 0)) { goto Az24d; } goto VGjQr; KUd4E: $sql = "\x53\105\x4c\105\103\x54\x20{$a}\x2e\52\54{$b}\56\x69\144\x20\x61\x73\40\141\x69\x64\40\x2c{$b}\56\163\150\x6f\160\151\144\54{$b}\x2e\x67\157\x6f\x64\x73\x69\144\x2c{$b}\56\147\157\157\x64\163\x6e\165\x6d\54{$b}\56\141\x63\164\x69\x76\x69\x74\171\x69\x64\54{$c}\56\x70\x72\x69\x63\x65\x2c{$c}\56\160\151\x63\x74\x75\x72\x65\x2c{$c}\56\x6e\x61\155\x65\x20\106\x52\117\115\x20{$a}\40\111\x4e\116\x45\x52\x20\x4a\117\111\x4e\x20{$b}\x20\x4f\116\x20{$a}\x2e\x69\144\x20\x3d\40{$b}\56\141\143\x74\151\x76\x69\164\x79\151\144\40\111\116\x4e\105\122\40\112\117\x49\116\40{$c}\x20\x4f\x4e\x20{$b}\x2e\x67\x6f\157\144\x73\151\x64\x20\x3d\40{$c}\56\x69\144\40\x57\x48\105\x52\x45\x20{$a}\x2e\163\x74\x61\162\164\164\x69\155\145\x20\74" . time() . "\40\x61\x6e\x64\40{$a}\x2e\x65\156\x64\164\151\x6d\x65\x3e" . time() . "\40\141\156\x64\x20{$a}\56\151\x64\x3d" . $val["\163\x6e\141\x70\x75\x70"] . "\x20\141\x6e\x64\40{$b}\56\152\x75\144\x67\x65\x69\x64\75\61\40\141\x6e\x64\x20\40{$a}\x2e\165\156\151\x61\143\151\144\75" . $_W["\x75\x6e\x69\x61\143\151\x64"] . "\x20\154\x69\155\x69\164\40" . $val["\162\x6f\167\163\151\x7a\145\x61\x6c\154"]; goto tOj5l; lN6CS: $goods = Model("\147\157\x6f\144\x73")->where("\165\156\x69\141\143\151\x64\75{$uniacid}\40\x61\156\x64\40\163\164\x61\164\165\x73\x3e\60")->limit(30)->order("\x52\x41\x4e\x44\50\x29")->getall("\x69\144\x2c\156\141\155\145"); goto s5rpA; GVunZ: foreach ($goods as $k => $v) { goto gBRPd; gBRPd: $or = array("\x69\144" => $k, "\147\157\157\144\163\x69\x64" => $v["\x69\144"], "\156\151\x63\153\x6e\141\x6d\145" => mb_substr($members[$k]["\x6e\151\143\153\156\x61\155\145"], 0, 1, "\165\x74\x66\x2d\x38") . "\x20\52\x2a\52\52\x20" . mb_substr($members[$k]["\x6e\151\143\153\156\x61\155\145"], mb_strlen($members[$k]["\156\151\143\x6b\x6e\x61\155\x65"], "\165\164\x66\x2d\70") - 1, 1, "\x75\164\146\x2d\70"), "\x67\x6f\x6f\144\x73\156\141\x6d\x65" => $v["\x6e\141\155\x65"]); goto BtRQO; cwBBa: Imwwg: goto snDrW; BtRQO: array_push($orders, $or); goto cwBBa; snDrW: } goto td7F_; cZ9ES: H0Ib0: goto W7qsv; mKDhS: $c = $model->tablename("\147\x6f\x6f\144\x73"); goto KUd4E; qyHb2: SRzZl: goto UEDk0; Rs1pi: CJQTf: goto iDFTj; GFdoN: $item[$key]["\143\150\x69\x6c\x64\x72\145\x6e"] = getGoodsSimpleInfo($goods); goto LY9Oj; hpyks: if (!($val["\x69\164\x65\155\103\154\x61\x73\x73"] == "\147\157\157\x64\163\55\154\151\163\164")) { goto H0Ib0; } goto CqmlL; JbzYv: $goods = Model("\147\x6f\x6f\144\163")->where("\165\x6e\151\141\143\151\x64\x3d{$uniacid}\x20\x61\156\x64\40\143\141\164\x65\x69\x64\x20\151\x6e\x20\x28{$cids}\x29\x20\141\156\x64\x20\x73\x74\141\x74\x75\x73\x3e\60")->limit(30)->order("\151\144\x20\x64\145\x73\143")->getall(); goto GFdoN; DT40z: kj6iE: goto ug_0_; s5rpA: $members = Model("\x6d\145\x6d\x62\x65\162")->group("\156\x69\x63\x6b\x6e\141\x6d\x65")->limit(30)->order("\x52\101\116\x44\x28\x29")->getall("\151\x64\x2c\156\151\143\153\x6e\141\x6d\145"); goto DsGHG; td7F_: gtVdE: goto X6TLv; UEDk0: $cates = Model("\x63\x61\164\145\147\x6f\162\x79")->where("\151\144\75" . intval($val["\x63\x61\164\x65\x69\144"]) . "\40\x6f\162\x20\160\141\162\145\x6e\164\151\x64\x3d" . intval($val["\143\141\164\145\x69\144"]))->getall("\x69\x64"); goto t0w4k; t12E2: if (!(intval($val["\x63\141\x74\145\151\144"]) == 0)) { goto SRzZl; } goto Atqwk; qSgDi: $item[$key]["\x63\150\151\x6c\x64\x72\145\156"] = $data; goto Rs1pi; t0w4k: $cids = ''; goto p8dlR; vd85n: $item[$key]["\143\150\151\154\144\x72\x65\x6e"] = getGoodsSimpleInfo($goods); goto cZ9ES; Atqwk: goto xOIbb; goto qyHb2; DsGHG: $orders = array(); goto GVunZ; e2CIn: KhZlK: goto AIVbH; hCIqu: $goods = $model->query($sql); goto vd85n; kLmyY: $b = $model->tablename("\x61\x63\x74\151\166\151\164\151\145\x73"); goto mKDhS; ACjmQ: aIG1L: goto hpyks; iDFTj: xOIbb: goto NRBbj; LY9Oj: Az24d: goto DT40z; NRBbj: } goto T3ceK; y31Ca: array_push($navbar, array("\164\x65\x78\164" => "\xe6\x8b\xbc\xe5\x9b\242", "\x74\x79\x70\x65" => "\160\x69\156\x74\165\141\156", "\x61\x63\x74\151\x76\145" => 0)); goto pl4sI; KJi9q: N33ID: goto kWqhP; Yi6Q7: if (!($set["\167\x78\141\160\x70\x5f\x6c\x61\171\157\x75\x74"]["\x74\x61\142\142\x61\x72\137\146\x69\x6e\144\137\x73\x74\141\x74\x75\x73"] == "\x6f\x6e")) { goto yxlhh; } goto vTsXC; UjmaJ: LZLnl: goto bJX94; YtR97: UdGN2: goto h9gM8; bJX94: if (!(strlen($nums) > 1)) { goto VgLLI; } goto LkRJG; FTaqI: echo JSON_OUT($data, true); goto nhHrt; kWqhP: if (!($set["\x77\x78\141\x70\160\x5f\154\141\x79\157\165\x74"]["\164\141\x62\142\141\162\137\163\156\141\x70\137\163\164\x61\x74\165\x73"] != "\157\146\x66")) { goto MOeTR; } goto w5rOS; ypokp: XAK0b: goto Ih3Xn; i88kx: $item = childtree($item); goto KC67i; X_78a: array_push($navbar, array("\x74\x65\x78\164" => "\xe7\240\x8d\xe4\273\xb7", "\164\171\x70\x65" => "\153\x61\156\x6a\x69\141", "\141\143\x74\x69\166\x65" => 0)); goto ME2IA; nhHrt: } public function collectFormID() { goto KkiPS; ok92n: $ids = $_GPC["\x69\x64\x73"]; goto Rr4Yv; gRuCV: $model = Model("\146\x6f\x72\x6d\151\144"); goto lYoib; oHrBu: $form = array("\164\x79\x70\145" => 0, "\x75\156\x69\141\x63\151\x64" => $uniacid, "\143\157\156\164\145\x6e\x74" => $_GPC["\x66\x6f\162\155\151\144"], "\x6f\x70\145\x6e\x69\x64" => $_GPC["\x6f\x70\145\x6e\x69\x64"], "\x63\x72\x65\x61\x74\x65\x74\151\x6d\x65" => time()); goto E7cjo; b6zGQ: Emadl: goto AsyXt; lYoib: $uniacid = intval($_W["\x75\156\151\x61\143\151\144"]); goto qQ8eu; v3Erw: NthTJ: goto oHrBu; WGiDB: $model->limit(8)->where("\157\x70\x65\156\x69\x64\75\x27{$openid}\x27\40\141\x6e\x64\x20\x75\x6e\151\x61\143\x69\144\x3d{$uniacid}\40")->order("\x63\x72\145\141\x74\x65\164\151\155\145\40\141\163\143")->delete(); goto v3Erw; E8TfA: if (!(strlen($openid) < 25 || strlen($_GPC["\146\x6f\162\x6d\151\144"]) < 10 || $_GPC["\x66\157\x72\155\x69\144"] == "\x74\150\145\40\146\x6f\162\x6d\111\144\40\151\163\40\x61\x20\155\x6f\143\x6b\x20\x6f\156\x65")) { goto Emadl; } goto fl8N_; TvI4b: if (!($count > 20)) { goto NthTJ; } goto WGiDB; AsyXt: $model->where("\x6f\160\145\156\151\x64\x3d\x27{$openid}\47\x20\x61\x6e\144\40\165\x6e\151\x61\143\151\x64\x3d{$uniacid}\x20\141\156\144\x20\x63\162\145\x61\164\145\x74\151\155\x65\74" . (time() - 86400 * 6))->delete(); goto UzIPZ; E7cjo: $res = $model->add($form); goto IE4qn; lKtSH: exit; goto b6zGQ; KkiPS: global $_W, $_GPC; goto gRuCV; UzIPZ: $count = $model->where("\x6f\160\145\x6e\x69\144\75\x27{$openid}\x27\x20\141\156\x64\x20\165\x6e\151\x61\143\x69\144\x3d{$uniacid}\40\141\x6e\x64\x20\x63\162\145\x61\x74\x65\164\151\x6d\x65\x3e" . (time() - 86400 * 6))->count(); goto TvI4b; Rr4Yv: $openid = $_GPC["\157\x70\145\156\151\x64"]; goto E8TfA; fl8N_: echo "\146\x6f\x72\155\151\144\40\x70\141\x72\x61\155\163\40\167\x72\x6f\x6e\x67\x21"; goto lKtSH; qQ8eu: $createtime = intval($_GPC["\x63\162\145\x61\164\x65\164\x69\x6d\145"]); goto ok92n; IE4qn: echo $res; goto PNKL2; PNKL2: } }