<?php
 class QrController extends MobileBaseController { public $size = 10; public function index() { goto hX7hO; u0ND2: $font_file = IA_ROOT . "\57\141\144\x64\157\x6e\x73\x2f\167\x67\137\x66\x65\x6e\170\151\141\157\x2f\162\x65\143\x6f\x75\x73\x65\57\x66\157\x6e\164\x73\x2f\x6d\x73\171\x68\x2e\164\x74\x66"; goto slr3_; apgn5: $red = imagecolorallocate($background, 255, 0, 0); goto Wwvyj; w8ghn: cg8Qt: goto jXhOV; HaS0u: $new_name[$i] .= mb_substr($name, $i * $length, $length, "\x75\164\146\55\70"); goto bE9jL; s2ufT: if (!is_file($poster)) { goto r4_mH; } goto AXjJi; y90a0: dnNxV: goto JGqZo; UJm3N: $background = imagecreatetruecolor($bg_w, $bg_h); goto wiNQL; E0uyU: if (is_dir($path)) { goto ihkgQ; } goto dk6g7; jbsWC: $this->ajaxReturn(0, '', $dir . $filename); goto NfXW0; uYnqq: $errorCorrectionLevel = "\x4c"; goto U9zwh; IvA9L: CwMFo: goto Q6Yr_; UV061: $good_info = $this->GoodsModel->getOne(["\x69\144" => $good_id], ["\147\157\x6f\x64\x73\x6e\141\155\x65", "\155\x61\162\153\145\164\160\162\151\143\x65", "\x74\150\x75\155\142", "\x75\160\x64\x61\164\x65\x5f\164\151\x6d\145"]); goto c8SFV; V8t37: qaevG: goto bJKte; VMcK8: $bg_h = 650; goto UJm3N; ZfJz4: HolxO: goto snt07; R2au9: if (strpos($good_info["\164\x68\165\155\142"], "\x68\x74\x74\160") === false) { goto zNMno; } goto jVNU_; E5wcN: r4_mH: goto VFn4V; nyOFr: include_once "\x70\x68\x70\x71\x72\x63\157\x64\145\x2e\160\x68\160"; goto lHNVB; ed6bO: TyMf0: goto qRAwZ; fjZ6u: iZcaV: goto aelb5; D8Dga: iwwNq: goto PYLRW; r2PSl: $filename = "\160\157\x73\164\x65\162\55" . $this->uid . "\x5f" . $good_id . "\137" . $good_info["\165\160\x64\141\164\x65\137\x74\151\x6d\x65"] . "\56\152\x70\x67"; goto cVM2o; Wwvyj: $black = imagecolorallocate($background, 0, 0, 0); goto VPraD; ZmkWR: imagecopyresized($background, $resource, 310, 470, 0, 0, 130, 130, imagesx($resource), imagesy($resource)); goto d6Ym2; JGqZo: imagecopyresized($background, $resource, 0, 0, 0, 0, 450, 450, imagesx($resource), imagesy($resource)); goto Jf2D1; xPDrm: $path = IA_ROOT . $dir; goto r2PSl; bzI6q: if (is_file($font_file)) { goto fBm4E; } goto u0ND2; AXjJi: $this->ajaxReturn(0, '', $dir . $filename); goto E5wcN; PamIt: $this->ajaxReturn(300, "\350\xaf\xb7\xe6\x82\xa8\xe5\234\xa8\xe5\276\xae\xe4\xbf\xa1\xe7\253\257\xe7\231\273\345\275\225"); goto V8t37; BAUKr: imagedestroy($background); goto jbsWC; uiERL: $dst_path = $this->W["\141\x74\x74\141\x63\150\x75\x72\x6c"] . $good_info["\164\x68\165\155\142"]; goto ed6bO; bE9jL: if (!(mb_strlen($new_name[$i], "\x75\x74\146\55\70") < $length)) { goto CwMFo; } goto U_rKi; lFVxV: $count = $j = 0; goto ltHWI; VFn4V: load()->func("\x66\x69\154\x65"); goto IlY9R; d6Ym2: $font_file = IA_ROOT . "\x2f\x61\144\x64\157\x6e\163\57\167\147\x5f\x66\x65\156\x78\151\x61\x6f\x2f\162\145\x63\157\x75\x73\x65\57\146\x6f\x6e\x74\x2f\x6d\x73\171\150\56\164\x74\146"; goto bzI6q; PYLRW: if (!($i < 5)) { goto iZcaV; } goto HaS0u; O8utw: if ($resource) { goto dnNxV; } goto HznZl; qRAwZ: $resource = imagecreatefromstring(file_get_contents($dst_path)); goto O8utw; Zfmal: $this->ajaxReturn(103, "\344\xba\x8c\xe7\273\264\xe7\240\201\xe7\x94\237\xe6\210\x90\xe5\244\xb1\350\264\xa5"); goto bRPv4; GNDIZ: $this->ajaxReturn(102, "\345\x95\x86\345\223\x81\344\xb8\x8d\345\xad\230\345\234\250"); goto ZfJz4; gOO1v: ihkgQ: goto nyOFr; Jf2D1: $dst_path = $qrcode; goto TzOwD; CTsJ0: mkdirs($path); goto gOO1v; bRPv4: w8h_h: goto xn8W0; E9p36: i9qBz: goto bt227; snt07: $dir = "\57\141\144\144\x6f\x6e\163\57\x77\x67\137\x66\x65\x6e\x78\151\141\157\x2f\x64\x61\x74\x61\x2f\x69\155\x61\x67\145\x73\x2f" . $this->W["\165\156\151\141\143\151\144"] . "\57" . substr($this->userInfo["\x6f\x70\x65\156\151\144"], 0, 2) . "\57"; goto xPDrm; c8SFV: if ($good_info) { goto HolxO; } goto GNDIZ; aelb5: foreach ($new_name as $key => $value) { imagefttext($background, 13, 0, 10, 490 + $key * 23, $black, $font_file, $value); KMYQm: } goto w8ghn; wiNQL: $color = imagecolorallocate($background, 255, 255, 255); goto R_u2T; tT8ii: $i++; goto zh5bL; xn8W0: $bg_w = 450; goto VMcK8; tJtSo: $this->ajaxReturn(105, "\345\xad\227\xe4\275\223\346\226\207\344\273\266\xe4\270\215\xe5\255\230\345\x9c\250"); goto E9p36; cVM2o: $poster = $path . $filename; goto s2ufT; HznZl: $this->ajaxReturn(104, "\xe5\225\206\xe5\x93\x81\346\265\267\xe6\212\245\344\xb8\215\xe5\255\230\345\x9c\xa8"); goto y90a0; zh5bL: goto iwwNq; goto fjZ6u; IlY9R: $qrcode = $path . "\160\x6f\x73\164\145\162\x2d" . $this->uid . "\137" . $good_id . "\x2d\x71\x72\x2e\x6a\160\x67"; goto E0uyU; bJKte: $good_id = (int) $_GET["\x67\x6f\157\x64\163\137\151\x64"]; goto UV061; LproU: imageColorTransparent($background, $color); goto R2au9; j2sc_: imagejpeg($background, $poster); goto BAUKr; jc0ll: zNMno: goto uiERL; QvnJQ: QRcode::png($value, $qrcode, $errorCorrectionLevel, $matrixPointSize, 1); goto IDyqs; U9zwh: $matrixPointSize = 3; goto QvnJQ; IDyqs: if (is_file($qrcode)) { goto w8h_h; } goto Zfmal; i_nLb: imagefttext($background, 10, 0, 167, 634, $black, $font_file, "\351\x95\xbf\346\x8c\x89\xe4\272\214\xe7\273\264\xe7\240\x81\xe6\211\253\347\240\201\350\xb4\xad\xe4\271\xb0"); goto j2sc_; RVYFW: $i = 0; goto D8Dga; ltHWI: $new_name = []; goto X_IcZ; Q6Yr_: E1imU: goto tT8ii; slr3_: if (is_file($font_file)) { goto i9qBz; } goto tJtSo; dk6g7: load()->func("\146\x69\x6c\x65"); goto CTsJ0; lHNVB: $value = $this->W["\x73\x69\x74\145\x72\157\157\x74"] . "\x61\160\160" . ltrim($this->createMobileUrl("\147\157\157\x64\163", ["\147\x6f\x6f\x64\163\137\151\144" => $good_id, "\146\x72\x6f\x6d\146\x75\x69\x64" => $this->uid]), "\x2e"); goto uYnqq; X_IcZ: $length = 19; goto RVYFW; n71ja: goto TyMf0; goto jc0ll; U_rKi: goto iZcaV; goto IvA9L; bt227: fBm4E: goto apgn5; jXhOV: imagefttext($background, 15, 0, 10, 610, $red, $font_file, "\xef\xbf\245" . $good_info["\155\141\162\153\145\164\x70\162\151\x63\x65"] . "\345\x85\x83"); goto i_nLb; TzOwD: $resource = imagecreatefromstring(file_get_contents($dst_path)); goto ZmkWR; R_u2T: imagefill($background, 0, 0, $color); goto LproU; VPraD: $name = $good_info["\147\157\157\144\163\x6e\141\x6d\145"]; goto lFVxV; jVNU_: $dst_path = $good_info["\164\x68\165\155\142"]; goto n71ja; hX7hO: if ($this->uid) { goto qaevG; } goto PamIt; NfXW0: } }