<?php
 class Sms { public function sendSms1() { goto sOgpM; fbB4x: $status = $this->send_verify($mobile, $code); goto wczak; wczak: return $status; goto jjm_u; sU51z: $code = rand(100000, 999999); goto fbB4x; sOgpM: $mobile = "\x31\70\x37\x31\x33\x35\61\62\65\71\x38"; goto sU51z; jjm_u: } public function sendSms($mobile, $verify_code, $content) { goto b5zJV; QeTho: if (!($content == null || $content == '')) { goto VBY4g; } goto ABRZ3; v5Vqv: $params["\x53\151\147\x6e\141\164\165\162\145"] = $this->computeSignature($params, $accessKeySecret); goto wWgdg; nfUSM: $params["\x54\145\155\x70\154\141\164\x65\120\141\x72\x61\155"] = "\173\42\x63\157\144\145\42\72\x22" . $verify_code . "\42\x2c\42\160\162\x6f\144\165\x63\164\42\72\42" . $content . "\42\x7d"; goto hfUxs; X5nzD: if (!($content == 0)) { goto oDLfv; } goto KKhX9; BEp1E: $result = json_decode($result, true); goto QROlY; m_aOE: curl_setopt($ch, CURLOPT_TIMEOUT, 10); goto KHx0Z; HX57e: VBY4g: goto MMsfW; YNSUj: oDLfv: goto QeTho; nGY5h: curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); goto rFIay; QXsUm: pWPFn: goto pOpmX; fJOeO: $uniacid = $_W["\165\x6e\x69\x61\143\151\144"]; goto kAFd9; wWgdg: $url = "\150\x74\164\x70\x3a\x2f\x2f\x64\171\x73\x6d\x73\141\160\x69\x2e\x61\x6c\x69\x79\x75\x6e\x63\x73\x2e\143\157\x6d\x2f\77" . http_build_query($params); goto scjZY; KHx0Z: $result = curl_exec($ch); goto K5Bgm; u0X0T: curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); goto m_aOE; S0nu8: $params = array("\123\151\x67\x6e\116\141\155\145" => $SignName, "\x46\157\x72\155\141\x74" => "\112\x53\x4f\116", "\126\x65\x72\x73\151\x6f\x6e" => "\62\x30\x31\x37\x2d\x30\x35\55\x32\65", "\x41\x63\143\x65\163\163\x4b\x65\x79\x49\x64" => $accessKeyId, "\x53\x69\147\x6e\x61\x74\165\162\145\x56\x65\x72\163\x69\x6f\156" => "\61\56\x30", "\x53\151\147\156\x61\x74\165\162\145\115\x65\164\x68\157\x64" => "\x48\x4d\101\x43\x2d\123\x48\x41\61", "\123\x69\147\x6e\x61\164\x75\x72\145\x4e\x6f\156\143\x65" => uniqid(), "\124\x69\x6d\145\x73\164\141\x6d\x70" => gmdate("\131\55\x6d\x2d\x64\134\x54\x48\x3a\151\x3a\163\134\x5a"), "\x41\x63\164\151\x6f\156" => "\123\145\x6e\144\123\155\x73", "\x54\x65\x6d\x70\154\141\x74\145\x43\x6f\144\145" => $TemplateCode, "\120\x68\x6f\x6e\x65\x4e\165\155\x62\145\162\163" => $mobile); goto X5nzD; kAFd9: $base = pdo_fetch("\x73\145\154\x65\143\164\40\x2a\x20\146\162\157\155\x20" . tablename("\150\x79\x5f\x73\x75\160\163\x74\157\x72\145\137\x62\157\163\163") . "\x20\40\x77\x68\145\162\145\x20\x75\156\x69\x61\143\x69\x64\x3d{$uniacid}\x20"); goto Fj5JK; r2Smv: return true; goto Z7H3J; pOpmX: return $result; goto fUBpD; hfUxs: Mo3SD: goto v5Vqv; l7Dty: $SignName = $base["\123\x69\147\x6e\x4e\x61\155\145"]; goto Ci1xa; QROlY: if (!($result["\x43\x6f\x64\145"] == "\x4f\x4b")) { goto pWPFn; } goto r2Smv; fUBpD: exit; goto tV_fq; KKhX9: $params["\124\x65\x6d\160\x6c\x61\164\145\x50\x61\162\141\x6d"] = "\173\x22\x63\x6f\144\145\x22\72\x22" . $verify_code . "\x22\54\x22\160\x72\x6f\x64\x75\143\x74\x22\x3a\x22" . '' . "\42\x7d"; goto YNSUj; Fj5JK: $accessKeyId = $base["\x61\143\143\x65\x73\x73\x4b\145\171\111\x64"]; goto DmJqH; Ci1xa: $TemplateCode = $base["\124\x65\x6d\x70\154\x61\164\x65\103\x6f\x64\145"]; goto S0nu8; scjZY: $ch = curl_init(); goto c70ko; MMsfW: if (!$content) { goto Mo3SD; } goto nfUSM; K5Bgm: curl_close($ch); goto BEp1E; rFIay: curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); goto u0X0T; ABRZ3: $params["\x54\x65\155\160\x6c\x61\x74\145\120\141\162\141\155"] = "\x7b\42\x63\157\144\x65\42\x3a\x22" . $verify_code . "\x22\x7d"; goto HX57e; Z7H3J: exit; goto QXsUm; b5zJV: global $_W, $_GPC; goto fJOeO; c70ko: curl_setopt($ch, CURLOPT_URL, $url); goto nGY5h; DmJqH: $accessKeySecret = $base["\141\x63\143\145\x73\x73\x4b\x65\x79\x53\145\143\x72\145\x74"]; goto l7Dty; tV_fq: } public function computeSignature($parameters, $accessKeySecret) { goto YzyJe; cHxbp: foreach ($parameters as $key => $value) { $canonicalizedQueryString .= "\46" . $this->percentEncode($key) . "\75" . $this->percentEncode($value); oaAMo: } goto xWbk8; YzyJe: ksort($parameters); goto zD0Zj; zD0Zj: $canonicalizedQueryString = ''; goto cHxbp; i5sPx: return $signature; goto cr67_; U76zR: $stringToSign = "\107\x45\x54\46\45\x32\106\x26" . $this->percentencode(substr($canonicalizedQueryString, 1)); goto b8rBa; b8rBa: $signature = base64_encode(hash_hmac("\163\150\x61\61", $stringToSign, $accessKeySecret . "\46", true)); goto i5sPx; xWbk8: hMhSs: goto U76zR; cr67_: } public function percentEncode($string) { goto aLJAd; aLJAd: $string = urlencode($string); goto Xmg2S; M2L0U: $string = preg_replace("\57\134\x2a\57", "\x25\x32\101", $string); goto Pr_o7; J_xc3: return $string; goto gc6m6; Xmg2S: $string = preg_replace("\x2f\134\x2b\57", "\45\x32\x30", $string); goto M2L0U; Pr_o7: $string = preg_replace("\57\x25\x37\105\57", "\176", $string); goto J_xc3; gc6m6: } } ?>