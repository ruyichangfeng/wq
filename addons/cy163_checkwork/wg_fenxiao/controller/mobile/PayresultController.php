<?php
 class PayresultController extends BaseController { public $settings; public function index($params) { goto cfCly; LSHzf: $data = ["\167\145\151\144" => $order["\167\x65\151\x64"], "\x75\151\144" => $parent2, "\x6f\x72\x64\x65\162\x73\156" => $order["\x6f\162\x64\145\x72\x73\156"], "\x70" => 2, "\x6d\x6f\156\145\x79" => $compute["\143\x6f\155\155\x69\163\151\157\x6e\x32"], "\x63\162\145\x61\x74\x65\164\151\155\145" => time(), "\x66\x61\x68\165\x6f\163\x68\x69\152\151\141\x6e" => $fahuoshijian]; goto diuYJ; tgD7p: return 400; goto kbgCz; fXCg9: $jifen_info[2] = $jifen2; goto aRrOy; njFf4: goto m1Rre; goto dKQI6; ThvFn: if ($level) { goto crYnb; } goto FkmD_; T5zqq: if (!$params["\164\x69\144"]) { goto A4o8q; } goto yxUwU; hCF6W: $data = ["\x77\145\x69\x64" => $order["\x77\x65\x69\144"], "\x75\x69\x64" => $parent1, "\157\162\144\145\162\163\x6e" => $order["\157\x72\144\x65\162\163\x6e"], "\x70" => 1, "\x6d\x6f\156\x65\x79" => $compute["\143\x6f\x6d\155\151\x73\151\157\x6e\x31"], "\x63\x72\145\141\164\x65\x74\151\x6d\x65" => time(), "\x66\x61\150\165\157\x73\x68\x69\152\x69\x61\x6e" => $fahuoshijian]; goto GqOMf; cfCly: if ($params) { goto FW6T4; } goto tgD7p; FeZ3D: $this->OrderModel->begin(); goto e0WOM; LgmH3: $data = ["\x77\145\151\144" => $order["\167\x65\151\144"], "\165\151\144" => $parent3, "\x6f\x72\x64\x65\x72\x73\x6e" => $order["\157\162\x64\x65\x72\x73\156"], "\160" => 3, "\155\157\156\x65\x79" => $compute["\143\157\x6d\155\151\x73\x69\157\156\x33"], "\143\x72\145\141\164\x65\164\x69\x6d\145" => time(), "\x66\141\150\x75\157\163\150\151\152\x69\141\x6e" => $fahuoshijian]; goto uUbXL; VsQ0a: goto m1Rre; goto zRk79; RUArH: $level = $this->settings["\154\145\x76\145\x6c"]; goto J1z0O; KbP__: if (!($parent3 && $jifen3 > 0 && $level > 2)) { goto xbwfE; } goto d9XNG; KHOLM: mc_credit_update($uid, "\x63\x72\x65\x64\151\x74\61", $order["\152\x69\x66\145\x6e"], array(0, "\xe8\264\255\xe4\271\xb0\xe5\225\x86\xe5\x93\x81\xe5\242\236\xe5\x8a\240\347\247\257\xe5\x88\206" . $order["\152\151\x66\145\156"])); goto v05My; ZfmQy: jL4Xm: goto eLxqV; N4iO9: if (!($params["\x66\162\x6f\155"] == "\162\x65\x74\x75\162\x6e")) { goto GO1xl; } goto TZyVN; Rk9mq: $this->sendMyPaySuccessPush($user_info, $this->settings["\147\x6f\165\x6d\x61\151\163\141\156\x6a\x69"], $order, $uniacid, $order["\152\151\x66\145\x6e"]); goto jHSIa; Rvwr8: $this->sendSanJiGouMai($user_info, $parent3, $this->settings["\147\157\165\x6d\141\x69\x73\x61\x6e\x6a\x69"], $order, $uniacid, (int) $jifen_info[3], $data["\155\x6f\156\x65\x79"], 3, $this->settings["\x71\x75\x65\162\x65\156\x73\150\157\x75\150\165\157"]); goto FAuge; GI7bi: $params["\x6f\165\x74\137\164\x72\x61\x64\145\137\156\x6f"] = $order["\x6f\x72\x64\145\x72\163\x6e"]; goto eG82W; dhAuw: $coupon_id = isset($params["\x63\x61\x72\144\x5f\151\144"]) ? $params["\x63\x61\162\x64\137\151\x64"] : 0; goto hjzXZ; qBueV: $this->addJifen($order["\155\x65\x6d\142\x65\162\151\144"], $order["\x6a\x69\146\145\x6e"], "\xe8\256\242\xe5\215\x95\72" . $order["\157\x72\144\x65\162\163\156"], $user_info, $uniacid); goto EM14O; bnOji: $this->addJifen($parent1, $jifen1, "\350\256\242\xe5\x8d\225\72" . $order["\157\162\x64\145\x72\x73\x6e"], [], $uniacid); goto BbgZH; d9XNG: $jifen_info[3] = $jifen3; goto LJD6N; Jfs7e: $this->sendSellerPush($uniacid, $this->settings["\x73\145\154\154\x65\162"], $this->settings["\x64\151\156\147\x64\141\x6e\x73\x68\x65\x6e\x67\143\x68\145\156\147"], $order, $order_detail[0], $user_info); goto TWarV; m0OkS: cRrsg: goto gpxU8; Ia8A5: $this->OrderModel->update(["\151\x64" => $order["\x69\144"]], $compute); goto Q0rsU; E1Jj2: XRVBR: goto VnUqZ; zmDkb: if (!($order["\163\164\141\x74\165\163"] != 0)) { goto WD4_D; } goto Ss0VS; coqpi: yg4rB: goto dhAuw; EM14O: load()->model("\155\143"); goto VO27F; wI6e1: if (!$this->settings["\147\x6f\x75\155\141\x69\163\x61\156\152\151"]) { goto tbRbO; } goto NJN6I; X_JfQ: $parent3 = $order["\160\141\x72\145\156\164\63"]; goto cFThg; gpxU8: $uniacid = $order["\x77\145\x69\x64"]; goto EvfeY; jHSIa: b2Nu6: goto FqbXY; mY0T9: if (!($user_info["\x6f\162\x64\145\x72\137\x6e\x75\155"] == 1 && $this->settings["\x78\151\141\152\x69\162\x65\156\x73\150\x75"])) { goto zlpLE; } goto uTFJV; diuYJ: $this->CommissionModel->add($data); goto wI6e1; PP4rH: XrnHI: goto obbs8; ur1g4: $compute = $this->compute_commision($order, $order_detail); goto jYHyJ; e0WOM: $goods_ids = []; goto T_fZD; K96Lo: $order_detail = $this->OrderDetailModel->getList(["\x6f\162\144\x65\x72\x5f\151\x64" => $order["\x69\x64"]], ["\x69\x64", "\x67\x6f\157\144\x73\137\x69\144", "\164\x69\164\x6c\x65", "\160\162\x69\x63\145", "\141\155\x6f\165\x6e\x74", "\x74\x79\160\x65\137\164\x69\164\x6c\145", "\164\x79\160\145\137\151\144", "\147\157\157\x64\x73\164\x79\160\x65", "\x67\x6f\x6f\x64\x73\x70\x61\163\x73\x74\171\160\x65"]); goto I2Yeh; FqbXY: if (!(!empty($this->settings["\x73\x65\x6c\x6c\x65\162"]) && !empty($this->settings["\x64\151\156\x67\x64\x61\156\x73\150\145\156\147\x63\150\145\x6e\x67"]))) { goto iWZvX; } goto Jfs7e; r8plX: rWV1O: goto zmDkb; boWE2: $jifen2 = intval($jifen1 * $this->settings["\170\x69\x61\x6a\x69\152\151\x66\x65\156"] / 100); goto JJERK; zhHr2: return 0; goto PP4rH; e1wed: $user_info = $this->MemberModel->getOne(["\x69\144" => $order["\155\145\155\x62\145\162\151\x64"]]); goto FeZ3D; eG82W: $this->settings = $this->getSettings($order["\167\x65\151\144"]); goto RUArH; H0my0: aWKyS: goto e59Wd; aRrOy: $this->addJifen($parent2, $jifen2, "\xe8\xae\xa2\xe5\215\225\x3a" . $order["\x6f\162\x64\145\x72\x73\156"], [], $uniacid); goto HNF4q; hjzXZ: $params["\164\162\x61\156\163\x61\143\x74\151\157\x6e\137\151\x64"] = $params["\x74\x72\x61\156\163\141\x63\x74\x69\x6f\x6e\137\x69\x64"] ? $params["\x74\x72\x61\156\x73\141\x63\164\151\157\156\137\x69\144"] : $params["\164\x61\147"]["\x74\162\141\156\163\x61\x63\x74\x69\157\x6e\137\x69\144"]; goto tyseg; FAuge: Dp2sU: goto mXpyd; k1_EE: mP40w: goto qBueV; SsFWw: return 103; goto WgEAk; obbs8: return 400; goto Cb5lz; J1z0O: if ($order) { goto rWV1O; } goto QhjFe; VnUqZ: if (!($parent3 && $compute["\x63\157\155\155\151\x73\x69\157\x6e\63"])) { goto Eupt7; } goto LgmH3; sjvPP: if (!($parent2 && $jifen2 > 0 && $level > 1)) { goto zGdfx; } goto fXCg9; TWarV: iWZvX: goto ThvFn; YiKGd: if (!($parent1 && $jifen1 > 0)) { goto wBTaA; } goto qKgur; RpJIy: GO1xl: goto UltBT; JurhS: $virtual_goods = true; goto e1wed; BbgZH: wBTaA: goto mnbIU; LJD6N: $this->addJifen($parent3, $jifen3, "\xe8\256\242\345\215\225\72" . $order["\157\x72\x64\x65\162\163\x6e"], [], $uniacid); goto jKZWQ; MfNUx: if (!($parent2 && $compute["\143\157\155\x6d\x69\x73\151\x6f\156\x32"])) { goto XRVBR; } goto LSHzf; cFThg: $jifen_info = []; goto AdUYD; tyseg: $result = $this->OrderModel->update(["\x6f\162\x64\145\x72\x73\x6e" => $params["\x6f\x75\x74\137\x74\162\141\x64\145\x5f\x6e\157"], "\x73\x74\141\x74\165\163" => 0], ["\163\164\141\x74\x75\x73" => $virtual_goods ? 3 : 1, "\x7a\x68\151\146\165\x74\151\x6d\x65" => time(), "\x70\x61\171\164\171\x70\145" => "\x77\145\143\150\141\164", "\x74\162\141\156\x73\151\x64" => $params["\x74\x72\141\156\x73\141\143\x74\x69\157\x6e\137\x69\144"], "\x66\x61\150\x75\157\x74\151\155\145" => $fahuoshijian, "\163\150\157\165\150\x75\x6f\164\x69\155\x65" => $fahuoshijian, "\x63\x6f\x75\160\157\x6e\x5f\x69\144" => $coupon_id, "\162\x65\141\154\x5f\x70\x61\x79" => $params["\143\x61\162\x64\137\146\145\145"] ? $params["\x63\141\x72\144\137\146\x65\145"] : 0]); goto VPQIR; cwZml: h9I0M: goto ubFVF; mXpyd: Eupt7: goto A_G7O; FkmD_: return 0; goto F7Qky; EvfeY: if (0) { goto MFxo4; } goto nGjQI; zRk79: MFxo4: goto njFf4; F7Qky: crYnb: goto zcz9a; A_G7O: dn_bz: goto zhHr2; v05My: if (!$this->settings["\147\157\165\x6d\141\x69\163\x61\156\x6a\x69"]) { goto b2Nu6; } goto Rk9mq; z1q1R: $order = $this->OrderModel->getOne(["\157\162\144\145\162\163\x6e" => $params["\x6f\x75\164\x5f\x74\162\141\144\x65\137\x6e\x6f"]], "\x2a"); goto m0OkS; nGjQI: if (!$this->_checkSign($order, $params) && $params["\x6f\165\164\137\164\162\x61\x64\145\137\x6e\x6f"]) { goto v2hGR; } goto VsQ0a; mqbnY: WD4_D: goto K96Lo; zcz9a: $parent1 = $order["\160\141\x72\145\156\164\x31"]; goto NNvEZ; K72SG: if (!$level) { goto mP40w; } goto MrlOi; HNF4q: zGdfx: goto KbP__; QhjFe: return 101; goto r8plX; GqOMf: $this->CommissionModel->add($data); goto zA74b; T_fZD: foreach ($order_detail as $detail) { goto q2YzW; Yaqmg: $custom = array("\155\x73\147\164\x79\160\145" => "\x74\145\170\164", "\x74\145\x78\164" => array("\x63\157\x6e\164\145\156\164" => urlencode($msg)), "\x74\x6f\165\x73\x65\162" => $this->settings["\163\145\154\x6c\x65\x72"]); goto HsF7a; JNskZ: if (!$url["\147\x6f\157\x64\163\154\151\x61\156\x6a\x69\x65"]) { goto sA687; } goto tY_Iu; F3Hpe: $goods_ids[] = $detail["\147\157\x6f\x64\163\137\151\144"]; goto FMIIu; nJ1Ja: KMiNj: goto fbjtb; JtJyk: $msg = "\345\215\xa1\xe5\xaf\x86\xe7\xbc\272\350\264\247\xe8\xaf\267\xe8\x81\x94\xe7\263\273\xe5\225\206\346\210\267\350\xa1\xa5\350\264\xa7\357\xbc\x9a" . $this->settings["\164\x65\154"]; goto XRfTu; GQb2s: $sql = "\x55\x50\x44\x41\x54\x45\40" . tablename("\167\147\137\x66\145\156\170\x69\141\x6f\x5f\x70\141\x73\x73\167\144\163") . "\x20\x53\x45\124\x20\x60\165\151\144\x60\75\x27" . $order["\155\145\x6d\x62\x65\162\151\x64"] . "\47\54\140\163\x74\141\164\165\163\x60\75\x31\54\140\157\162\x64\x65\x72\137\144\x65\164\141\151\154\137\151\144\140\x3d\x27" . $detail["\x69\144"] . "\47\x2c\x60\x75\160\144\141\164\145\x5f\164\x69\155\145\x60\x3d\47" . time() . "\x27\x20\x57\110\x45\x52\105\x20\x60\x74\x79\160\x65\140\75" . $detail["\x67\x6f\x6f\144\x73\160\x61\x73\x73\164\x79\160\145"] . "\x20\101\116\104\40\x73\x74\141\164\165\163\x3d\60\40\154\x69\155\151\164\40" . $detail["\x61\155\157\x75\156\x74"]; goto gmS5j; MhZTY: foreach ($list as $code) { $str .= $code["\x63\157\144\x65"] . "\15\12"; vqhGD: } goto nJ1Ja; H1JgQ: if (!$url["\x67\x6f\157\144\163\154\151\x61\156\152\x69\145"]) { goto HTlnH; } goto nDzui; bq2BH: $url = $this->GoodsAttributeModel->getOne(["\x67\x6f\157\x64\163\x5f\151\144" => $detail["\x67\157\x6f\144\163\137\151\x64"]], ["\x67\157\157\x64\x73\x6c\151\x61\156\x6a\151\x65", "\x67\x6f\x6f\144\x73\154\x69\141\156\152\x69\145\163\x68\165\x6f\155\x69\x6e\147"]); goto opZRR; YZ3W9: $acc = self::getWeAccount($uniacid); goto p4JT_; C8NN1: $virtual_goods = false; goto bxOCA; oSACi: $this->GoodsModel->update(["\x69\x64" => $detail["\147\x6f\x6f\144\x73\137\151\144"]], ["\x73\145\x6c\x6c\x5f\x74\157\164\141\x6c\40\x2b\x3d" => $detail["\141\155\x6f\165\x6e\x74"]]); goto xIKQ3; JVkvg: $acc->sendCustomNotice($custom); goto fUuAm; nDzui: $msg .= "\15\xa\346\225\231\347\250\213\346\210\226\350\xaf\264\xe6\230\216\344\xb8\272\357\xbc\232" . $url["\147\x6f\157\x64\x73\x6c\151\141\x6e\152\151\x65\163\x68\x75\x6f\x6d\x69\x6e\x67"]; goto HH2iC; uToCk: if ($detail["\x67\157\157\144\163\x74\171\160\145"] != 1) { goto RvCT0; } goto GQb2s; vuuiF: dmtzH: goto Th7EV; opZRR: $msg = "\xe6\202\250\350\264\255\344\271\260\347\x9a\204\xe5\225\206\xe5\x93\x81\xe5\x8d\xa1\345\257\x86\344\xb8\272\xef\xbc\x9a\15\12" . rtrim(trim($str), "\174"); goto H1JgQ; fbjtb: $this->OrderDetailModel->update(["\151\x64" => $detail["\151\x64"]], ["\162\145\155\141\162\x6b" => $str]); goto bq2BH; FMIIu: $this->GoodsTypeModel->update(["\x69\144" => $detail["\x74\x79\160\145\137\151\144"]], ["\x61\x6d\x6f\x75\x6e\x74\137\163\145\x6c\x6c\x20\53\75" => $detail["\x61\155\157\165\156\x74"]]); goto oSACi; moceR: $msg = "\345\x8d\xa1\345\xaf\x86\347\274\272\xe8\xb4\xa7\xe8\257\xb7\xe8\241\xa5\xe8\264\247\40" . $detail["\164\x69\164\x6c\145"] . "\x5b\151\x64\72" . $detail["\147\x6f\x6f\144\x73\137\151\144"] . "\x5d\40\x2d\x20" . $detail["\x74\171\160\x65\x5f\x74\151\x74\154\145"]; goto Yaqmg; Th7EV: goto f4G6J; goto q0VB3; XRfTu: $custom = array("\x6d\x73\x67\164\171\160\x65" => "\164\x65\170\164", "\x74\145\x78\164" => array("\x63\157\x6e\164\x65\x6e\164" => urlencode($msg)), "\164\x6f\165\x73\x65\162" => $user_info["\x6f\x70\145\x6e\151\144"]); goto YZ3W9; YsypW: $custom = array("\x6d\x73\x67\164\x79\x70\x65" => "\164\x65\170\x74", "\164\x65\x78\164" => array("\143\157\156\x74\145\x6e\x74" => urlencode($msg)), "\x74\x6f\165\x73\145\162" => $user_info["\x6f\x70\145\x6e\x69\x64"]); goto jtUCM; p4JT_: $acc->sendCustomNotice($custom); goto moceR; gmS5j: $result = $this->PasswdsModel->query($sql); goto ODve4; n3Jkk: sA687: goto YsypW; jtUCM: $acc = self::getWeAccount($uniacid); goto CWXP8; q0VB3: RvCT0: goto C8NN1; HH2iC: HTlnH: goto JNskZ; c7iUX: $str = ''; goto MhZTY; bxOCA: f4G6J: goto iAS_r; q2YzW: if (!$detail["\164\x79\160\145\137\x69\144"]) { goto sCYBR; } goto F3Hpe; CWXP8: $acc->sendCustomNotice($custom); goto vuuiF; HsF7a: $acc = self::getWeAccount($uniacid); goto JVkvg; xIKQ3: sCYBR: goto uToCk; Tg3La: ukbpz: goto SBMFE; fUuAm: goto dmtzH; goto Tg3La; tY_Iu: $msg .= "\xd\12\xe9\223\xbe\346\x8e\245\xe4\270\272\357\274\232" . $url["\x67\x6f\x6f\144\x73\154\151\141\156\152\151\x65"]; goto n3Jkk; ODve4: if ($result) { goto ukbpz; } goto JtJyk; iAS_r: QEfoR: goto Lh0AN; SBMFE: $list = $this->PasswdsModel->getList(["\x6f\162\x64\x65\x72\x5f\144\145\164\x61\x69\x6c\x5f\x69\x64" => $detail["\x69\x64"]], ["\143\x6f\144\145"]); goto c7iUX; Lh0AN: } goto H0my0; jKZWQ: xbwfE: goto mY0T9; LK2mZ: $where["\157\x72\x64\145\x72\137\156\157"] = $params["\x6f\x75\164\137\164\162\x61\x64\x65\137\x6e\x6f"]; goto WMQ3b; MrlOi: $user_info["\x69\x73\x61\147\145\156\x74"] = $this->_editIsAgent($user_info); goto k1_EE; TZyVN: message('', $this->createMobileUrl("\x6d\171\157\x72\144\145\x72")); goto RpJIy; mnbIU: Ujc2w: goto ur1g4; VO27F: $uid = mc_openid2uid($user_info["\157\x70\145\156\151\x64"]); goto KHOLM; WgEAk: IF0JG: goto JurhS; Q0rsU: if (!($parent1 && $compute["\143\157\x6d\x6d\151\x73\151\157\x6e\61"])) { goto iM357; } goto hCF6W; zA74b: if (!$this->settings["\x67\157\x75\x6d\141\151\x73\x61\x6e\x6a\151"]) { goto jL4Xm; } goto j7ud6; AdUYD: if (!($this->settings["\170\x69\x61\152\151\x6a\x69\x66\145\x6e"] > 0 && $order["\x6a\151\146\145\156"])) { goto Ujc2w; } goto IRu0m; Ss0VS: return 102; goto mqbnY; dKQI6: v2hGR: goto jmxXc; qKgur: $jifen_info[1] = $jifen1; goto bnOji; yxUwU: $order = $this->OrderModel->getOne(["\157\x72\x64\145\162\163\156" => $params["\164\x69\x64"]], "\x2a"); goto N4iO9; eLxqV: iM357: goto MfNUx; uUbXL: $this->CommissionModel->add($data); goto yeQal; I2Yeh: if ($order_detail) { goto IF0JG; } goto SsFWw; kbgCz: FW6T4: goto snN0D; rmh9o: $fahuoshijian = time(); goto coqpi; KdrOA: $this->OrderModel->rollback(); goto VNRj_; yeQal: if (!$this->settings["\x67\157\165\x6d\141\151\x73\x61\x6e\x6a\x69"]) { goto Dp2sU; } goto Rvwr8; jYHyJ: if (!$compute) { goto dn_bz; } goto Ia8A5; NJN6I: $this->sendSanJiGouMai($user_info, $parent2, $this->settings["\147\157\165\x6d\x61\151\x73\141\x6e\152\x69"], $order, $uniacid, (int) $jifen_info[2], $data["\155\x6f\x6e\x65\x79"], 2, $this->settings["\x71\x75\x65\162\145\x6e\163\x68\157\x75\150\165\157"]); goto V5jzN; V5jzN: tbRbO: goto E1Jj2; jL3Dd: if (!($params["\x6f\165\x74\137\x74\x72\141\144\145\x5f\x6e\157"] || $order)) { goto XrnHI; } goto LK2mZ; uTFJV: $jifen1 += $this->settings["\x78\x69\x61\152\151\x72\145\156\163\150\165"]; goto pYczE; ubFVF: $this->OrderModel->commit(); goto Apbjw; VNRj_: return 104; goto cwZml; snN0D: $order = []; goto T5zqq; WMQ3b: if ($order) { goto cRrsg; } goto z1q1R; VPQIR: if (!(!$result || $result <= 0)) { goto h9I0M; } goto KdrOA; pYczE: zlpLE: goto YiKGd; Apbjw: $this->MemberModel->update(["\151\x64" => $order["\155\x65\155\x62\145\162\151\x64"]], ["\143\x6f\x6e\163\x75\x6d\145\40\53\75" => $order["\157\x72\144\x65\x72\160\162\151\x63\x65"], "\157\162\144\145\x72\x5f\156\x75\x6d\x20\53\75" => 1]); goto FsP_H; j7ud6: $this->sendSanJiGouMai($user_info, $parent1, $this->settings["\147\x6f\x75\155\141\151\163\141\156\152\151"], $order, $uniacid, (int) $jifen_info[1], $data["\x6d\x6f\x6e\145\x79"], 1, $this->settings["\161\165\145\162\x65\156\163\x68\157\165\x68\x75\157"]); goto ZfmQy; jmxXc: return 399; goto oXTyY; NNvEZ: $parent2 = $order["\160\141\x72\145\x6e\x74\62"]; goto X_JfQ; oXTyY: m1Rre: goto GI7bi; e59Wd: $fahuoshijian = 0; goto YUOVc; UltBT: A4o8q: goto jL3Dd; FsP_H: $user_info = $this->MemberModel->getOne(["\151\144" => $order["\x6d\x65\x6d\x62\145\x72\151\x64"]]); goto K72SG; IRu0m: $jifen1 = intval($order["\x6a\151\146\145\x6e"] * $this->settings["\x78\151\141\152\x69\x6a\151\x66\x65\156"] / 100); goto boWE2; YUOVc: if (!$virtual_goods) { goto yg4rB; } goto rmh9o; JJERK: $jifen3 = intval($jifen2 * $this->settings["\x78\x69\141\152\151\x6a\x69\x66\x65\156"] / 100); goto sjvPP; Cb5lz: } private function _editIsAgent($user_info) { goto njnlY; njnlY: $condition = $this->settings["\144\141\151\x6c\x69\164\151\141\x6f\x6a\x69\x61\x6e"]; goto S9dJe; ppOdN: return true; goto qkk_N; oqHMg: bW7gq: goto qa4JS; qg18P: return true; goto oqHMg; xuYyJ: $need_money = $this->settings["\x67\157\165\155\x61\151\x71\x69\141\x6e\163\150\x75"]; goto kNc64; qfmsU: $this->MemberModel->update(["\x69\144" => $user_info["\151\x64"]], ["\x69\163\141\147\x65\x6e\164" => 1, "\141\x67\x65\x6e\x74\164\151\155\x65" => time()]); goto ppOdN; dhhFd: $this->MemberModel->update(["\x69\144" => $user_info["\x69\144"]], ["\151\163\x61\x67\x65\x6e\164" => 1, "\141\147\145\156\x74\164\x69\x6d\x65" => time()]); goto qg18P; kJQnm: $need_order_num = $this->settings["\147\157\165\155\x61\x69\x64\x61\156\x73\150\165"]; goto kt35J; kt35J: if (!($curr_order_num >= $need_order_num)) { goto dysrP; } goto qfmsU; peQtq: if ($condition == 3) { goto Hm_nI; } goto nw3ou; Ey3Ph: goto CJ473; goto QiGnV; Pexkf: Hm_nI: goto xuYyJ; qa4JS: pSXcp: goto yIJ8I; kNc64: if (!($user_info["\143\157\156\x73\x75\x6d\145"] >= $need_money)) { goto bW7gq; } goto dhhFd; QiGnV: OmsYd: goto qH0R2; S9dJe: if ($user_info["\x69\163\141\147\x65\x6e\x74"] == 0) { goto OmsYd; } goto pICci; qH0R2: if ($condition == 2) { goto uyK51; } goto peQtq; eY4ql: goto CJ473; goto eRaG9; yIJ8I: return false; goto eY4ql; qkk_N: dysrP: goto ofRWI; h3wMb: return true; goto Hol4K; rpTu6: $curr_order_num = $user_info["\x6f\162\x64\x65\162\x5f\156\x75\x6d"]; goto kJQnm; nqtoO: uyK51: goto rpTu6; eRaG9: YUqJY: goto h3wMb; Hol4K: CJ473: goto ooNaj; ofRWI: goto pSXcp; goto Pexkf; nw3ou: goto pSXcp; goto nqtoO; pICci: if ($user_info["\151\x73\141\x67\145\156\x74"] == 1) { goto YUqJY; } goto Ey3Ph; ooNaj: } private function compute_commision($order, $order_detail, $goods_attrs = array()) { goto cvS1G; cvS1G: if (!($order["\x70\141\x72\145\156\164\x31"] == 0 && $order["\160\141\x72\145\x6e\x74\x32"] == 0 && $order["\x70\141\x72\145\x6e\x74\63"] == 0)) { goto BY2_m; } goto L6xDq; i7qB2: XOoRX: goto ozCeV; SKSSO: yE7s5: goto IaBHL; Q9Gmh: $goods_commision = []; goto bT29X; ozCeV: $goods_ids = array_unique($goods_ids); goto wOS7f; sofiZ: return ["\x63\157\155\155\151\163\x69\x6f\x6e\x5f\x74\x69\155\x65" => time(), "\x63\x6f\155\155\x69\x73\x69\x6f\156\x31" => $commision1, "\143\157\155\x6d\151\163\x69\157\x6e\x32" => $commision2, "\143\x6f\x6d\x6d\151\x73\151\157\x6e\x33" => $commision3]; goto yXJN4; SlEjR: CLvcx: goto hX3BN; IaBHL: Rmes8: goto sofiZ; fGGwK: $this->crontab_log("\143\157\155\160\165\164\x65\x5f\x63\x6f\x6d\x6d\x69\x73\151\x6f\156\72\xe4\xbd\243\xe9\x87\x91\x3a" . $commision1 . "\174" . $commision2 . "\174" . $commision3); goto iY0C5; MToGO: foreach ($order_detail as $detail) { $goods_ids[] = $detail["\x67\157\157\144\x73\137\151\x64"]; qcfwb: } goto i7qB2; v4tCt: if ($goods_attrs) { goto CLvcx; } goto u6BGb; OMwUZ: $goods_attrs = $this->arrayIndex($goods_attrs, "\x67\x6f\157\x64\163\137\x69\144"); goto SlEjR; mCiJS: foreach ($order_detail as $value) { goto MUJ8O; jv1lr: frK1_: goto SmAL1; MUJ8O: if (!($goods_commision[$value["\x69\x64"]]["\x63\x6f\x6d\x6d\151\x73\x69\157\156\x31"] > 0 || $goods_commision[$value["\151\144"]]["\x63\157\x6d\x6d\x69\x73\151\157\x6e\62"] > 0 || $goods_commision[$value["\151\x64"]]["\143\x6f\155\155\151\163\151\x6f\156\63"] > 0)) { goto D7wXG; } goto RRB4e; MHrA8: D7wXG: goto jv1lr; RRB4e: $this->OrderDetailModel->update(["\151\144" => $value["\151\144"]], ["\143\x6f\155\155\151\163\151\157\156\x31" => $goods_commision[$value["\151\144"]]["\x63\157\155\155\151\163\x69\157\x6e\61"], "\143\157\155\x6d\x69\163\151\157\x6e\x32" => $goods_commision[$value["\151\144"]]["\x63\x6f\155\155\x69\163\x69\157\156\62"], "\143\x6f\155\155\x69\163\x69\x6f\x6e\x33" => $goods_commision[$value["\x69\x64"]]["\143\x6f\x6d\x6d\x69\163\151\157\156\63"]]); goto MHrA8; SmAL1: } goto bwrwG; LkpdD: BY2_m: goto v4tCt; aj37D: foreach ($goods_total as $g_id => $value) { goto kzfg9; EiTRS: t7sJ6: goto AHZFf; kzfg9: if (!($value > 0)) { goto KdRS2; } goto QOUgK; Wwobm: KdRS2: goto EiTRS; QOUgK: $this->GoodsAttributeModel->update(["\147\x6f\157\144\163\137\151\x64" => $g_id], ["\x79\157\156\147\152\151\x6e\x5f\x75\163\145\144\x20\x2b\x3d" => $value]); goto Wwobm; AHZFf: } goto SKSSO; L7jHU: DNwny: goto fGGwK; bwrwG: MLtc0: goto aj37D; u6BGb: $goods_ids = []; goto MToGO; hX3BN: $commision1 = $commision2 = $commision3 = 0; goto Q9Gmh; bT29X: $goods_total = []; goto tKfrs; iY0C5: if (!($commision1 > 0 || $commision2 > 0 || $commision3 > 0)) { goto Rmes8; } goto mCiJS; wOS7f: $goods_attrs = $this->GoodsAttributeModel->getList(["\147\157\157\x64\x73\137\x69\x64" => $goods_ids], ["\x67\x6f\x6f\144\163\137\x69\x64", "\172\157\x6e\147\171\x6f\156\x67\x6a\151\156", "\x79\157\156\147\x6a\x69\x6e\x5f\x75\x73\145\144", "\144\165\x6c\151\171\157\156\147\152\151\156", "\171\157\x6e\147\x6a\x69\x6e\61", "\x79\x6f\156\x67\152\x69\156\x32", "\171\157\x6e\147\x6a\x69\156\x33", "\x66\145\x6e\170\x69\141\x6f"]); goto OMwUZ; L6xDq: return ["\x63\157\155\x6d\151\163\151\157\x6e\137\x74\x69\x6d\x65" => time(), "\x63\157\x6d\x6d\151\x73\151\x6f\x6e\61" => 0, "\143\x6f\x6d\x6d\x69\x73\151\157\156\x32" => 0, "\143\157\x6d\155\151\163\x69\x6f\156\x33" => 0]; goto LkpdD; tKfrs: foreach ($order_detail as &$detail) { goto ULUlW; mNIz7: $detail["\x63\157\155\155\151\163\x69\x6f\156\x31"] = $detail["\143\157\155\155\151\x73\x69\157\x6e\62"] = $detail["\x63\157\155\x6d\151\x73\x69\x6f\156\x33"] = 0; goto UGkvl; uhwDt: $detail["\143\x6f\x6d\155\151\x73\x69\x6f\156\61"] = $detail["\x70\162\x69\143\145"] * $goods_info["\x79\x6f\156\x67\152\151\x6e\x31"] * $detail["\x61\x6d\157\x75\156\x74"] / 100; goto BIo9w; QngPF: $commision1 += $detail["\143\x6f\x6d\x6d\x69\x73\x69\157\x6e\x31"]; goto m_Oon; pnupO: $detail["\x63\157\x6d\155\151\x73\151\157\156\x32"] = $detail["\160\x72\151\143\145"] * $this->settings["\x65\162\152\151\171\157\x6e\x67\152\151\156"] * $detail["\x61\x6d\x6f\165\156\164"] / 100; goto wsMby; L7p4Y: $commision3 += $detail["\x63\157\155\155\x69\x73\x69\x6f\x6e\x33"]; goto ga6nj; wsMby: $detail["\143\157\x6d\x6d\x69\163\x69\157\x6e\63"] = $detail["\x70\162\x69\143\145"] * $this->settings["\x73\x61\156\152\x69\171\x6f\156\x67\x6a\x69\x6e"] * $detail["\141\155\157\x75\156\164"] / 100; goto oXi9Z; Dkm30: $detail["\143\157\155\x6d\x69\x73\x69\x6f\x6e\61"] = number_format($detail["\x63\157\x6d\x6d\151\163\151\x6f\156\x31"], 2, "\x2e", ''); goto qoCvj; O6qB9: EBo1m: goto N5ApG; RjV2f: $detail["\143\x6f\x6d\x6d\x69\x73\x69\x6f\156\61"] = $goods_info["\x79\157\x6e\x67\x6a\151\156\61"] * $detail["\141\x6d\157\165\156\x74"]; goto BTgtj; sKaoP: goto yhTIw; goto o2x8o; Z1vCC: $this->crontab_log("\x63\x6f\x6d\160\165\x74\145\x5f\x63\x6f\155\155\151\x73\x69\x6f\x6e\72" . $detail["\147\157\x6f\x64\163\137\x69\156\146\157"]["\144\165\154\151\171\157\x6e\x67\152\x69\x6e"] . "\345\225\206\345\223\x81\xe4\xbd\xa3\351\x87\221\x49\104\xef\274\232" . $detail["\147\157\x6f\144\x73\137\x69\144"] . "\x2d" . $detail["\143\x6f\x6d\155\x69\x73\151\x6f\x6e\x31"] . "\55" . $detail["\x63\157\155\155\x69\163\151\157\x6e\62"] . "\x2d" . $detail["\x63\x6f\x6d\155\x69\x73\x69\x6f\156\x33"]); goto O6qB9; N5ApG: $goods_commision[$detail["\x69\144"]]["\x63\x6f\x6d\x6d\x69\163\151\x6f\x6e\61"] += $detail["\x63\157\x6d\x6d\151\163\151\x6f\156\x31"]; goto oMk4S; Du6AE: if ($goods_info["\x66\145\x6e\x78\x69\x61\x6f"]) { goto Wnd7U; } goto Vlsus; L41ER: $this->crontab_log("\143\157\x6d\160\x75\x74\x65\x5f\143\x6f\x6d\155\151\163\151\157\156\72\xe5\225\x86\xe5\223\x81\344\xbd\243\351\207\x91\x49\x44\xef\274\x9a" . $detail["\147\157\157\144\x73\x5f\x69\144"] . "\xe4\xbd\243\xe9\207\x91\xe5\267\xb2\347\x94\xa8\xe5\256\x8c" . $goods_info["\x79\157\156\x67\x6a\151\156\137\x75\163\145\x64"] . "\76" . $goods_info["\172\x6f\x6e\x67\171\x6f\156\147\x6a\x69\x6e"]); goto sKaoP; pdOFX: if (!($goods_info["\x7a\x6f\156\x67\x79\x6f\x6e\147\152\151\156"] > 0 && $goods_info["\171\x6f\156\147\x6a\x69\156\137\x75\x73\145\144"] >= $goods_info["\x7a\157\x6e\x67\171\x6f\x6e\x67\x6a\x69\x6e"])) { goto kabj1; } goto L41ER; qoCvj: $detail["\x63\x6f\155\155\x69\163\x69\x6f\x6e\x32"] = number_format($detail["\x63\157\155\155\x69\163\x69\157\156\62"], 2, "\56", ''); goto EQMW3; TS4up: $detail["\x63\157\x6d\x6d\x69\163\x69\157\156\61"] = $detail["\160\162\x69\x63\x65"] * $this->settings["\171\151\x6a\x69\171\157\x6e\147\x6a\151\x6e"] * $detail["\141\155\x6f\x75\156\164"] / 100; goto pnupO; YYQ5h: goto XSKn6; goto jUxg_; BTgtj: $detail["\x63\x6f\155\x6d\151\163\151\x6f\x6e\62"] = $goods_info["\171\157\x6e\x67\x6a\151\156\x32"] * $detail["\141\x6d\x6f\165\156\164"]; goto uhgQM; ga6nj: yhTIw: goto SHv3Y; oMk4S: $goods_commision[$detail["\x69\x64"]]["\143\157\155\155\x69\x73\x69\x6f\x6e\62"] += $detail["\x63\x6f\x6d\x6d\x69\163\x69\157\x6e\x32"]; goto Ahphw; CRMu1: vlsNL: goto RjV2f; ULUlW: $goods_info = $goods_attrs[$detail["\x67\157\x6f\x64\163\x5f\x69\144"]]; goto LEZ9b; BIo9w: $detail["\x63\x6f\155\155\x69\163\151\x6f\x6e\62"] = $detail["\160\x72\151\143\145"] * $goods_info["\x79\157\x6e\147\x6a\151\x6e\x32"] * $detail["\x61\155\157\165\x6e\x74"] / 100; goto gTJot; OxJbz: if ($goods_info["\144\165\x6c\x69\171\157\156\147\152\x69\x6e"] == 1) { goto vlsNL; } goto emn5D; LrRdg: Wnd7U: goto pdOFX; a9vZK: XSKn6: goto Dkm30; uhgQM: $detail["\143\157\x6d\x6d\x69\x73\x69\x6f\x6e\63"] = $goods_info["\x79\157\x6e\147\x6a\x69\x6e\63"] * $detail["\x61\155\157\x75\156\164"]; goto YYQ5h; gTJot: $detail["\x63\157\155\x6d\x69\x73\x69\157\156\x33"] = $detail["\160\x72\151\x63\x65"] * $goods_info["\171\157\x6e\147\x6a\151\156\x33"] * $detail["\x61\155\x6f\165\156\164"] / 100; goto a9vZK; LEZ9b: $detail["\147\x6f\157\144\163\x5f\151\156\x66\157"] = $goods_info; goto Du6AE; oXi9Z: goto XSKn6; goto CRMu1; jUxg_: Goneq: goto uhwDt; m_Oon: $commision2 += $detail["\x63\157\x6d\x6d\x69\163\x69\157\156\x32"]; goto L7p4Y; o2x8o: kabj1: goto OxJbz; UGkvl: goto EBo1m; goto LrRdg; ptlHx: $goods_total[$detail["\147\157\x6f\144\x73\137\x69\144"]] += $detail["\x63\x6f\155\155\151\163\x69\x6f\x6e\x31"] + $detail["\143\157\x6d\155\151\x73\x69\157\x6e\x32"] + $detail["\143\157\x6d\x6d\x69\x73\x69\x6f\x6e\63"]; goto QngPF; Vlsus: $this->crontab_log("\143\157\x6d\160\165\164\145\x5f\143\x6f\155\x6d\151\x73\x69\x6f\x6e\x3a\345\x95\206\xe5\223\201\344\275\243\xe9\207\x91\111\x44\357\xbc\232" . $detail["\x67\157\157\144\163\x5f\x69\x64"] . "\xe4\275\243\xe9\207\221\xe5\x85\xb3\xe9\x97\xad"); goto mNIz7; Ahphw: $goods_commision[$detail["\x69\144"]]["\143\x6f\x6d\155\x69\163\151\x6f\156\63"] += $detail["\x63\157\x6d\x6d\151\x73\x69\157\156\63"]; goto ptlHx; EQMW3: $detail["\143\x6f\x6d\155\x69\x73\151\157\x6e\63"] = number_format($detail["\143\x6f\x6d\x6d\151\163\x69\x6f\156\63"], 2, "\x2e", ''); goto Z1vCC; emn5D: if ($goods_info["\144\165\154\151\171\x6f\x6e\147\x6a\151\156"] == 2) { goto Goneq; } goto TS4up; SHv3Y: } goto L7jHU; yXJN4: } private function _checkSign($order, $get) { goto I1uq3; bS2BR: wXH0R: goto PByIk; B2hyB: $sign = strtoupper(md5($string1 . "\x6b\x65\171\x3d{$wechat["\x73\x69\x67\x6e\153\145\x79"]}")); goto XJ5Pv; XJ5Pv: if (!($sign == $get["\163\151\x67\156"])) { goto e5FVF; } goto EiPCC; qhpF6: auNjD: goto E4VW5; E5vRB: $wechat["\x73\x69\147\156\153\145\171"] = $facilitator_setting["\160\x61\x79\155\145\x6e\x74"]["\167\x65\143\150\141\x74\137\x66\x61\143\151\154\x69\x74\141\164\x6f\162"]["\163\151\147\156\x6b\x65\x79"]; goto Jxr2g; E4VW5: $facilitator_setting = uni_setting($wechat["\x73\x65\x72\x76\x69\143\x65"], array("\x70\141\171\x6d\x65\156\x74")); goto E5vRB; PErNn: ksort($get); goto pYMSb; W5W2d: if (intval($wechat["\163\x77\x69\x74\x63\x68"]) == 3) { goto auNjD; } goto H0Mnf; gDJhn: foreach ($get as $k => $v) { goto Ch6CA; Ch6CA: if (!($v != '' && $k != "\163\151\x67\156")) { goto iBlpo; } goto K3FRe; YypvT: prY5B: goto ZNSy2; H4h7y: iBlpo: goto YypvT; K3FRe: $string1 .= "{$k}\x3d{$v}\46"; goto H4h7y; ZNSy2: } goto cz29t; qdITn: goto QUTp2; goto qhpF6; amrvN: if (empty($wechat)) { goto wXH0R; } goto PErNn; I1uq3: $setting = uni_setting($order["\167\x65\151\144"], array("\x70\x61\171\x6d\x65\x6e\164")); goto DmPIw; WbrYB: e5FVF: goto bS2BR; cz29t: cqIQE: goto W5W2d; PByIk: return false; goto ckgJ7; Jxr2g: QUTp2: goto B2hyB; EiPCC: return true; goto WbrYB; H0Mnf: $wechat["\163\151\x67\156\x6b\145\171"] = $wechat["\x76\x65\x72\x73\151\x6f\x6e"] == 1 ? $wechat["\x6b\145\171"] : $wechat["\x73\151\147\156\153\145\171"]; goto qdITn; DmPIw: $wechat = $setting["\160\141\171\155\145\156\x74"]["\x77\145\143\x68\x61\x74"]; goto amrvN; pYMSb: $string1 = ''; goto gDJhn; ckgJ7: } }