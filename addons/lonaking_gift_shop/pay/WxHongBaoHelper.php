<?php
/*
 __________________________________________________
|  Encode by BajieTeam on we7                      |
|__________________________________________________|
*/
 goto vwDpi; fB3Mr: class WxHongBaoHelper { var $parameters; function __construct() { } function setParameter($parameter, $parameterValue) { $this->parameters[CommonUtil::trimString($parameter)] = CommonUtil::trimString($parameterValue); } function getParameter($parameter) { return $this->parameters[$parameter]; } protected function create_noncestr($length = 16) { goto Kcj2q; FKhDf: $i++; goto CSKRL; WpdX7: $i = 0; goto kzycj; lOgOR: if (!($i < $length)) { goto hbUsc; } goto dxMxZ; c8RAQ: hbUsc: goto GWWyZ; Kcj2q: $chars = "\141\x62\143\144\145\146\147\x68\x69\152\x6b\x6c\155\x6e\157\160\x71\x72\163\x74\x75\166\x77\x78\x79\x7a\101\x42\x43\x44\105\x46\x47\110\111\112\x4b\114\115\116\x4f\120\121\122\x53\x54\x55\x56\x57\130\x59\132\x30\61\x32\63\64\65\x36\67\70\71"; goto OviEg; j4ul3: U7ldn: goto FKhDf; dxMxZ: $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1); goto j4ul3; OviEg: $str = ''; goto WpdX7; GWWyZ: return $str; goto i5eXf; kzycj: pQQaV: goto lOgOR; CSKRL: goto pQQaV; goto c8RAQ; i5eXf: } function check_sign_parameters() { goto y7DxK; kXRtK: AOIBz: goto aEYHm; aEYHm: return true; goto ptG3a; geGoi: return false; goto kXRtK; y7DxK: if (!($this->parameters["\156\x6f\156\143\x65\x5f\x73\x74\162"] == null || $this->parameters["\x6d\x63\x68\x5f\x62\x69\154\x6c\x6e\157"] == null || $this->parameters["\155\143\x68\x5f\151\x64"] == null || $this->parameters["\x77\170\141\x70\160\151\x64"] == null || $this->parameters["\156\151\143\x6b\x5f\x6e\141\155\x65"] == null || $this->parameters["\163\145\x6e\x64\137\x6e\x61\x6d\x65"] == null || $this->parameters["\x72\145\137\x6f\160\145\156\151\x64"] == null || $this->parameters["\164\157\x74\141\x6c\x5f\141\155\157\x75\156\164"] == null || $this->parameters["\x6d\x61\170\137\x76\x61\x6c\x75\x65"] == null || $this->parameters["\x74\157\x74\x61\x6c\137\156\165\155"] == null || $this->parameters["\x77\x69\x73\x68\x69\156\147"] == null || $this->parameters["\x63\154\151\145\x6e\x74\137\151\x70"] == null || $this->parameters["\x61\x63\164\137\x6e\x61\155\145"] == null || $this->parameters["\x72\145\x6d\x61\162\x6b"] == null)) { goto AOIBz; } goto geGoi; ptG3a: } protected function get_sign() { try { goto GjrXP; IMKCx: if (!($this->check_sign_parameters() == false)) { goto abLNT; } goto rnoMt; mwI_p: abLNT: goto LDrvr; rnoMt: throw new SDKRuntimeException("\347\x94\x9f\xe6\x88\220\347\255\xbe\xe5\220\x8d\xe5\x8f\202\xe6\x95\xb0\347\xbc\xba\345\244\261\41"); goto mwI_p; LDrvr: $commonUtil = new CommonUtil(); goto Q2l1E; nGoEs: return $md5SignUtil->sign($unSignParaString, $commonUtil->trimString(PARTNERKEY)); goto LkImQ; VhVkg: throw new SDKRuntimeException("\345\xaf\x86\351\222\245\xe4\xb8\215\350\x83\xbd\xe4\270\272\347\251\xba\41"); goto exZCn; GjrXP: if (!(null == PARTNERKEY || '' == PARTNERKEY)) { goto mbiaJ; } goto VhVkg; Q2l1E: ksort($this->parameters); goto MRvAt; exZCn: mbiaJ: goto IMKCx; ytroW: $md5SignUtil = new MD5SignUtil(); goto nGoEs; MRvAt: $unSignParaString = $commonUtil->formatQueryParaMap($this->parameters, false); goto ytroW; LkImQ: } catch (SDKRuntimeException $e) { throw new WxHongBaoException($e->errorMessage(), 10302); } } function create_hongbao_xml($retcode = 0, $reterrmsg = "\x6f\153") { try { goto lDe21; Tto1z: $commonUtil = new CommonUtil(); goto nnybM; lDe21: $this->setParameter("\x73\151\x67\156", $this->get_sign()); goto Tto1z; nnybM: return $commonUtil->arrayToXml($this->parameters); goto FG0KK; FG0KK: } catch (SDKRuntimeException $e) { throw new WxHongBaoException($e->errorMessage(), 10301); } } function curl_post_ssl($url, $vars, $second = 30, $aHeader = array()) { goto B1w0s; qv6KB: $data = curl_exec($ch); goto OEavD; BFpcU: curl_setopt($ch, CURLOPT_HTTPHEADER, $aHeader); goto VNgsn; FtQJY: curl_setopt($ch, CURLOPT_CAINFO, ATTACHMENT_ROOT . "\57\143\145\x72\x74\163\x2f" . APPID . "\162\157\x6f\164\x63\x61\56\x70\145\x6d"); goto GcWvK; u8dqX: curl_close($ch); goto SsxA1; L27rN: curl_close($ch); goto tmEyV; H4HJC: curl_setopt($ch, CURLOPT_TIMEOUT, $second); goto Fupdz; Yj2YZ: YkjAc: goto NDXKD; hpQ12: CcNFS: goto u8dqX; B1w0s: $ch = curl_init(); goto H4HJC; SsxA1: return $data; goto Yj2YZ; Phz3G: curl_setopt($ch, CURLOPT_SSLCERT, ATTACHMENT_ROOT . "\57\143\145\162\164\163\x2f" . APPID . "\141\160\x69\x63\x6c\151\x65\156\x74\137\x63\x65\162\x74\x2e\160\x65\155"); goto vAUrH; tmEyV: return false; goto Uwi8v; gpiBJ: curl_setopt($ch, CURLOPT_POSTFIELDS, $vars); goto qv6KB; ioAKE: curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); goto FZKtn; VNgsn: O22sM: goto qGaCk; FZKtn: curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); goto Phz3G; OEavD: if ($data) { goto CcNFS; } goto RBGDF; Uwi8v: goto YkjAc; goto hpQ12; qGaCk: curl_setopt($ch, CURLOPT_POST, 1); goto gpiBJ; GcWvK: if (!(count($aHeader) >= 1)) { goto O22sM; } goto BFpcU; Fupdz: curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); goto uBTas; vAUrH: curl_setopt($ch, CURLOPT_SSLKEY, ATTACHMENT_ROOT . "\57\x63\x65\162\164\x73\x2f" . APPID . "\x61\160\151\143\154\151\145\x6e\164\137\153\x65\171\x2e\x70\145\x6d"); goto FtQJY; RBGDF: $error = curl_errno($ch); goto L27rN; uBTas: curl_setopt($ch, CURLOPT_URL, $url); goto ioAKE; NDXKD: } } goto fOB1u; w65tC: include_once "\x4d\104\65\x53\151\147\x6e\125\x74\x69\154\x2e\160\x68\x70"; goto FhZrV; B2fcg: include_once "\123\104\113\122\165\x6e\x74\x69\x6d\145\105\170\x63\x65\x70\164\x69\x6f\156\x2e\x63\x6c\141\x73\163\56\160\150\x70"; goto w65tC; FhZrV: include_once "\x57\x78\110\x6f\x6e\147\102\x61\x6f\105\x78\x63\x65\160\x74\151\x6f\156\56\160\x68\160"; goto fB3Mr; vwDpi: include_once "\103\x6f\x6d\x6d\x6f\156\125\164\x69\154\x2e\x70\150\160"; goto B2fcg; fOB1u: ?>
