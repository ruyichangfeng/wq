<?php
/*
 __________________________________________________
|  Encode by BajieTeam on we7                      |
|__________________________________________________|
*/
 class MD5SignUtil { function sign($content, $key) { try { goto er8CL; CLM1d: return strtoupper(md5($signStr)); goto F2At9; D_gE7: throw new SDKRuntimeException("\350\264\xa2\344\xbb\x98\351\200\x9a\347\255\xbe\xe5\x90\215\x6b\x65\171\344\xb8\x8d\350\x83\275\xe4\xb8\xba\347\251\272\xef\274\201" . "\x3c\x62\x72\x3e"); goto kHqEC; HKN_4: throw new SDKRuntimeException("\xe8\xb4\242\344\xbb\x98\351\x80\x9a\347\255\xbe\xe5\x90\x8d\xe5\206\x85\345\xae\271\344\270\215\350\x83\275\xe4\xb8\272\xe7\251\xba" . "\x3c\142\162\x3e"); goto JjTqU; JjTqU: bDPiE: goto aZzvF; aZzvF: $signStr = $content . "\x26\153\x65\x79\75" . $key; goto CLM1d; er8CL: if (!(null == $key)) { goto KfSWi; } goto D_gE7; v4bWv: if (!(null == $content)) { goto bDPiE; } goto HKN_4; kHqEC: KfSWi: goto v4bWv; F2At9: } catch (SDKRuntimeException $e) { die($e->errorMessage()); } } function verifySignature($content, $sign, $md5Key) { goto syS8c; X_NZv: $calculateSign = strtolower(md5($signStr)); goto MqowT; Zl3Fi: return $calculateSign == $tenpaySign; goto t6x7S; syS8c: $signStr = $content . "\46\x6b\x65\x79\x3d" . $md5Key; goto X_NZv; MqowT: $tenpaySign = strtolower($sign); goto Zl3Fi; t6x7S: } } ?>
