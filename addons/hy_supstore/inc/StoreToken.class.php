<?php
 class StoreToken { private $tokenSalt = "\x48\131\x53\x55\x50\x45\x52\x53\x54\x4f\x52\105"; private $tokenExpireIn = 60; public function check($token) { goto kWLjC; l0F1U: if (!cache_load($token)) { goto B68WQ; } goto fEIGe; vl2qk: return false; goto jyZU4; AAm9N: B68WQ: goto vl2qk; fEIGe: return true; goto AAm9N; kWLjC: global $_W, $_GPC; goto l0F1U; jyZU4: } public function getToken() { goto VPsH7; VPsH7: global $_W, $_GPC; goto NMg_l; Fn_eK: return $token; goto Xjvuz; NMg_l: $token = $this->saveToCache(); goto Fn_eK; Xjvuz: } private function saveToCache() { goto tnXOq; iW1t9: return false; goto on0iU; yS73S: $expire_in = $this->tokenExpireIn; goto HXDnL; P8Vwj: if ($result) { goto UGW7C; } goto iW1t9; on0iU: UGW7C: goto pAE2B; tnXOq: $token = $this->generateToken(); goto ka19M; HXDnL: $result = cache_write($token, $data[$token], $expire_in); goto P8Vwj; ka19M: $data[$token] = TIMESTAMP; goto yS73S; pAE2B: return $token; goto oDVSh; oDVSh: } private function generateToken() { goto ELFNw; qL_aA: $timestamp = TIMESTAMP; goto uK3jt; uK3jt: $tokenSalt = $this->tokenSalt; goto Mr76c; Mr76c: return md5($randChar . $timestamp . $tokenSalt); goto mFW56; ELFNw: $randChar = $this->getRandChar(35); goto qL_aA; mFW56: } private function getRandChar($length = 32, $char = "\x30\x31\62\x33\x34\x35\66\67\x38\71\141\142\143\144\x65\146\147\x68\x69\152\153\x6c\155\156\x6f\160\x71\x72\x73\164\x75\166\x77\170\171\x7a\101\102\103\104\105\106\x47\x48\111\112\x4b\114\115\116\x4f\x50\121\122\123\124\125\126\127\130\x59\x5a") { goto DtX1J; b9Pr2: $string .= $char[mt_rand(0, strlen($char) - 1)]; goto jKS8e; smI9U: $i--; goto oavBB; oavBB: goto L7EZv; goto aU7sR; RuzAs: $i = $length; goto v4MOo; DtX1J: if (!(!is_int($length) || $length < 0)) { goto B5mTK; } goto d4hh7; Fa0sl: B5mTK: goto m3qIe; v4MOo: L7EZv: goto AwTel; AwTel: if (!($i > 0)) { goto Odqv7; } goto b9Pr2; d4hh7: return false; goto Fa0sl; m3qIe: $string = ''; goto RuzAs; aU7sR: Odqv7: goto ED2lG; jKS8e: iMDAw: goto smI9U; ED2lG: return $string; goto PyDHr; PyDHr: } public function delete($token) { global $_W, $_GPC; cache_delete($token); } }