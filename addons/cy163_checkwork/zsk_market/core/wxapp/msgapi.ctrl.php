<?php
 class Msgapi extends ZskWxapp { private $setting; public function index() { goto I1uiY; shndb: $_SESSION[ZSK_MODULE . "\137\x73\145\164\x74\151\x6e\x67\137" . $uniacid] = $setting; goto JOTvy; RW7Ti: $this->setting = $setting; goto Z6eqx; Z6eqx: if (isset($_GET["\145\x63\x68\x6f\x73\x74\162"])) { goto s5BEy; } goto KDlsN; mLAB8: $setting = getSetting("\x61\x6c\x6c"); goto M8thQ; gtMIt: s5BEy: goto u7XGP; XFaAf: if (!(strlen($setting["\x74\x6f\153\145\156"]) < 10)) { goto cV_yt; } goto ivO3J; tATmW: $encoding = randCharNumber(43); goto jzwYv; PCmYf: define("\x4d\123\107\101\120\111\x5f\124\x4f\113\105\116", $setting["\x74\x6f\153\145\156"]); goto RW7Ti; Oknsf: $setting["\164\157\153\145\x6e"] = $token; goto D9lQ9; wzX2B: goto KnLRk; goto gtMIt; iDlx0: Model("\163\145\x74\x74\151\x6e\x67")->where("\165\x6e\151\x61\x63\151\x64\75{$uniacid}")->limit(1)->save(array("\x74\x6f\x6b\145\x6e" => $token)); goto Oknsf; M8thQ: $uniacid = intval($_W["\x75\x6e\x69\141\143\151\144"]); goto XFaAf; I1uiY: global $_W; goto mLAB8; D9lQ9: $_SESSION[ZSK_MODULE . "\x5f\x73\x65\x74\x74\151\156\x67\x5f" . $uniacid] = $setting; goto k7REw; jzwYv: Model("\163\x65\x74\x74\151\x6e\147")->where("\165\x6e\x69\141\143\x69\144\75{$uniacid}")->limit(1)->save(array("\145\156\143\x6f\x64\x69\156\147" => $encoding)); goto yCYYB; bujqt: KnLRk: goto DC31q; ivO3J: $token = randCharNumber(32); goto iDlx0; k7REw: cV_yt: goto lBT71; u7XGP: $this->valid(); goto bujqt; yCYYB: $setting["\x65\156\x63\157\x64\x69\x6e\x67"] = $encoding; goto shndb; lBT71: if (!(strlen($setting["\145\156\143\157\x64\151\x6e\x67"]) < 10)) { goto XGLMt; } goto tATmW; KDlsN: $this->response(); goto wzX2B; JOTvy: XGLMt: goto PCmYf; DC31q: } public function response() { goto WntHa; Zbf0e: $token = $wxjs->getToken(true); goto RqLic; rMA6A: feGhH: goto PYo9v; PYo9v: goto b0bRM; goto KO3zr; c2Vsa: $path .= "\x2f" . date("\x6d", time()); goto P1UaU; AxSrK: if (!(intval($res["\145\162\x72\143\157\144\x65"]) > 10000)) { goto wP4ZN; } goto Zbf0e; eNETE: $time = time(); goto pjnrB; vfdsI: $form_MsgType = $postObj->MsgType; goto m3tmK; JBaZ0: $url = "\150\164\164\x70\x73\72\57\x2f\x61\x70\x69\56\167\145\151\170\151\x6e\56\161\161\56\143\157\155\57\x63\x67\151\55\x62\151\156\x2f\155\x65\163\x73\141\147\145\x2f\x63\165\x73\164\x6f\155\57\x73\x65\x6e\x64\x3f\141\x63\x63\x65\163\163\x5f\x74\x6f\153\x65\156\x3d" . $token["\141\x63\143\145\x73\x73\x5f\x74\x6f\x6b\x65\156"]; goto E4Qlm; PQJ0I: pE8hG: goto GQ59p; pNcLI: $filename = $setting["\141\160\160\151\x64"] . "\137" . time() . rand(100, 999) . "\56\152\160\147"; goto Lg3n3; m3tmK: $createTime = $postObj->CreateTime; goto lP8WB; GQ59p: $picUrl = $postObj->PicUrl; goto eIsCX; nFZdV: $postStr = $GLOBALS["\110\124\124\x50\x5f\122\x41\127\x5f\120\x4f\123\124\x5f\104\x41\x54\101"]; goto m9mS8; A2u22: $code = $this->curl_media($url, "\x69\155\x61\147\x65"); goto npOUX; XQQLO: if (!empty($postStr)) { goto OTMvp; } goto jM78u; zHjoW: $toUsername = $postObj->ToUserName; goto vfdsI; ib66y: $token = $wxjs->getToken(); goto FrMW5; mAjLa: $json = "\x7b\15\12\x20\40\40\x20\x20\x20\x20\x20\40\x20\x20\x20\40\x20\40\x20\40\x20\40\40\x20\x20\40\40\40\x20\40\x20\x22\x74\x6f\165\x73\145\x72\x22\x3a\42" . $fromUsername . "\x22\x2c\xd\12\x20\x20\40\40\x20\x20\x20\40\40\x20\x20\x20\40\40\40\x20\40\40\x20\x20\40\x20\40\x20\x20\x20\40\40\42\155\x73\x67\x74\x79\160\x65\x22\72\42\x74\x65\170\164\x22\x2c\15\xa\x20\40\x20\x20\40\40\40\x20\x20\40\40\40\40\40\40\40\40\40\40\40\40\40\x20\x20\x20\40\40\40\x22\x74\145\170\164\x22\72\15\12\x20\40\40\x20\x20\x20\40\40\x20\x20\40\x20\40\x20\x20\x20\40\x20\40\x20\x20\40\40\40\x20\40\40\x20\x7b\xd\12\x20\40\x20\40\40\x20\40\x20\x20\x20\x20\x20\x20\x20\x20\40\40\40\x20\40\40\40\40\x20\40\x20\40\40\40\x20\40\40\x20\42\143\157\x6e\164\145\156\x74\42\72\42" . $setting["\162\x65\x70\154\x79\x5f\152\x6f\151\156"] . "\x22\15\xa\40\40\x20\x20\x20\x20\40\x20\40\40\40\x20\x20\x20\40\40\x20\40\40\x20\40\x20\x20\x20\x20\x20\40\x20\175\15\xa\x20\x20\x20\40\x20\40\40\40\x20\x20\40\x20\x20\40\40\x20\40\x20\x20\x20\40\40\x20\40\x7d"; goto alf4V; Rpj42: if (is_dir($path)) { goto f4xmn; } goto uLJKj; qc4zD: fwrite($ifp, base64_decode($base_img)); goto gCUme; tAvqF: pz2B_: goto sFNP0; UlXr5: n_0M8: goto SIQhQ; r8qQC: if (intval($auto["\151\x64"]) < 1) { goto Hhr9X; } goto cAMh0; E4Qlm: $json = "\x7b\15\12\40\40\x20\x20\x20\40\x20\x20\40\40\x20\x20\40\x20\x20\x20\x20\40\x20\40\x20\40\x20\x20\40\x20\x20\40\x20\40\x20\40\42\x74\x6f\x75\x73\145\x72\x22\72\x22" . $fromUsername . "\x22\x2c\xd\xa\40\x20\x20\40\40\40\40\x20\40\40\40\x20\x20\x20\40\x20\40\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\40\40\40\x20\42\x6d\163\147\164\x79\160\145\42\x3a\42\x74\145\x78\164\x22\x2c\xd\xa\40\x20\x20\40\x20\x20\40\x20\x20\40\x20\40\40\x20\x20\40\x20\40\x20\40\x20\40\40\x20\x20\x20\40\40\x20\x20\x20\x20\42\164\145\170\x74\x22\72\xd\xa\40\40\40\40\40\40\x20\x20\x20\x20\x20\x20\40\x20\x20\40\40\40\x20\x20\40\40\x20\x20\x20\40\40\40\x20\x20\40\40\173\xd\12\x20\40\x20\40\x20\40\x20\40\x20\40\40\40\40\x20\40\40\x20\40\x20\40\40\x20\40\x20\40\x20\40\40\x20\x20\40\x20\40\40\x20\40\40\x22\143\x6f\x6e\164\x65\x6e\164\42\72\x22" . $auto["\x72\145\x70\x6c\171"] . "\x22\15\xa\x20\40\40\40\40\x20\x20\x20\x20\40\40\40\x20\x20\40\x20\40\x20\x20\40\x20\x20\x20\x20\x20\40\40\x20\40\x20\x20\x20\175\xd\12\x20\40\40\40\x20\x20\40\x20\x20\40\x20\40\40\x20\x20\40\x20\x20\40\x20\40\40\x20\x20\40\40\40\40\175"; goto cdwo_; aOExY: $url = "\150\164\164\x70\163\72\57\57\x61\x70\x69\56\x77\x65\151\170\x69\x6e\56\161\161\x2e\x63\x6f\155\57\x63\x67\x69\55\x62\x69\156\x2f\x6d\x65\163\163\141\x67\145\57\x63\165\163\164\x6f\x6d\57\x73\x65\156\x64\x3f\x61\143\x63\x65\163\163\x5f\x74\157\153\x65\156\x3d" . $token["\141\143\x63\x65\163\163\137\164\157\x6b\x65\156"]; goto mAjLa; xKsuo: XWyAi: goto U6FXw; SIQhQ: $path .= "\57" . date("\x59", time()); goto Rpj42; EBjRK: $this->noticeMsg($msg); goto MaAUP; T_afH: S2zBU: goto Bz0TV; ij3v9: goto ngJnZ; goto UAg8y; Fgw2j: goto S2zBU; goto xKsuo; W9wWb: goto Hr3dr; goto Fr4V6; g8vdY: $token = $wxjs->getToken(true); goto IrcOU; RqLic: $res = CURL_send($url, $json); goto dh1pf; npOUX: $res = base64_encode($code); goto oQc1f; IrcOU: $res = CURL_send($url, $json); goto rMA6A; zCl39: if ($form_MsgType == "\x69\155\141\x67\145") { goto pE8hG; } goto yyeMh; BzEOo: goto pz2B_; goto grrel; sFNP0: ngJnZ: goto eP4WQ; UAg8y: OTMvp: goto aswME; jykxc: $source = $sm->where("\x69\x64\x3d" . $auto["\x73\x6f\x75\x72\143\145\x69\144"])->get(); goto MYpyX; AUG8k: $db = Model("\x6d\x73\x67\x61\160\x69"); goto RJGWa; zsDWI: $postStr = file_get_contents("\160\x68\160\72\57\57\x69\x6e\160\165\x74"); goto I7n5A; Bz0TV: goto AVqLh; goto PQJ0I; yyeMh: if (!empty($keyword)) { goto XWyAi; } goto M9swm; alf4V: $res = CURL_send($url, $json); goto AxSrK; C2QXG: $contentStr = "\350\260\242\350\260\242\346\202\250\347\232\x84\xe5\233\236\345\xa4\x8d\41"; goto ooCPk; eWelw: if (is_dir($path)) { goto n_0M8; } goto cPe9l; NcZ9N: echo $resultStr; goto T_afH; YUCpa: $auto = $model->where("\x6b\x65\171\167\x6f\162\x64\x3d\47" . $keyword . "\47\x20\141\156\144\40\x75\156\x69\x61\143\151\144\75\47" . $uniacid . "\x27")->get(); goto r8qQC; la6X1: if (!(strlen(trim($setting["\162\145\160\154\171\x5f\x6a\x6f\151\156"])) > 0)) { goto GSuRZ; } goto uoJZF; aswME: $postObj = simplexml_load_string($postStr, "\x53\x69\155\160\154\x65\130\115\114\x45\154\x65\155\x65\x6e\164", LIBXML_NOCDATA); goto YaCJh; tQ7KZ: $path = IAROOT . "\57\x61\164\x74\141\143\x68\x6d\145\156\x74\x2f\151\155\141\147\145\x73\x2f" . $uniacid; goto eWelw; m9mS8: if (!empty($postStr)) { goto KM0R3; } goto zsDWI; P1UaU: if (is_dir($path)) { goto SJMuU; } goto bQiGN; jM78u: echo ''; goto fqyqP; gmYNl: Dglw6: goto tAvqF; YaCJh: $fromUsername = $postObj->FromUserName; goto zHjoW; grrel: F51yP: goto HIWOw; uLJKj: mkdir($path); goto V0xF8; uoJZF: $wxjs = new WeixinJS($_W["\141\x63\143\x6f\x75\156\x74"]["\x6b\x65\171"], $_W["\141\x63\x63\x6f\x75\156\x74"]["\163\x65\143\162\x65\164"]); goto ukdGn; Qq2qO: $ifp = fopen($output_file, "\167\53"); goto qc4zD; sUNFY: b0bRM: goto W9wWb; M2f5i: $token = $wxjs->getToken(); goto JBaZ0; U6FXw: $model = Model("\x6b\x65\171\x77\157\162\144"); goto YUCpa; RJGWa: $msg["\x69\144"] = $db->add($msg); goto EBjRK; dmENp: $wxjs = new WeixinJS($_W["\141\x63\143\x6f\165\156\164"]["\x6b\x65\171"], $_W["\x61\143\x63\157\165\156\164"]["\163\145\143\162\x65\x74"]); goto M2f5i; cdwo_: $res = CURL_send($url, $json); goto GONGk; l2B40: $msg["\143\157\156\164\145\x6e\x74"] = "\133\345\x9b\276\xe7\x89\207\xe4\xbf\xa1\xe6\201\257\x5d"; goto ynFV8; t3KQi: $db = Model("\155\x65\163\x73\x61\x67\145"); goto gelRg; GONGk: if (!(intval($res["\x65\x72\x72\143\x6f\144\x65"]) > 10000)) { goto feGhH; } goto g8vdY; rSMKZ: $output_file = $path . "\57" . $filename; goto Qq2qO; ynFV8: $this->noticeMsg($msg); goto RyRdp; gMVRh: $wxjs = new WeixinJS($_W["\141\143\143\157\165\156\164"]["\153\145\x79"], $_W["\x61\143\143\157\165\x6e\x74"]["\x73\145\143\162\145\164"]); goto ib66y; dh1pf: wP4ZN: goto y9Zhm; cAMh0: if (intval($auto["\163\157\x75\x72\x63\145\151\x64"])) { goto hgSPW; } goto dmENp; gCUme: fclose($ifp); goto kNUZS; oOh9U: $sm = Model("\x73\157\165\x72\x63\145"); goto jykxc; cPe9l: mkdir($path); goto UlXr5; oQc1f: $base_img = str_replace("\144\141\164\141\72\151\155\x61\147\x65\x2f\x6a\x70\x67\x3b\x62\141\x73\145\x36\64\54", '', $res); goto tQ7KZ; FrMW5: $url = "\x68\164\164\160\x73\x3a\57\57\x61\x70\x69\x2e\x77\145\x69\170\x69\x6e\56\161\x71\x2e\143\x6f\x6d\57\x63\x67\151\55\142\x69\156\x2f\155\x65\x64\x69\141\57\147\145\x74\x3f\x61\x63\x63\145\163\163\x5f\x74\157\153\x65\x6e\x3d" . $token["\141\x63\x63\145\x73\x73\x5f\164\x6f\153\x65\156"] . "\x26\x6d\145\x64\151\141\137\151\144\x3d" . $mediaId; goto A2u22; rBd26: $msg = array("\x75\156\151\141\143\151\x64" => $uniacid, "\143\157\156\164\x65\x6e\x74" => $keyword, "\164\157\x75\163\145\162" => $toUsername, "\x66\x72\157\x6d\165\163\145\x72" => $fromUsername, "\164\171\x70\x65" => $form_MsgType, "\x63\162\145\x61\164\145\164\151\155\x65" => $createTime); goto AUG8k; M9swm: echo "\x49\156\x70\165\x74\40\163\x6f\155\x65\x74\150\x69\156\147\x2e\x2e\x2e"; goto Fgw2j; dvYzm: SJMuU: goto pNcLI; eIsCX: $mediaId = $postObj->MediaId; goto gMVRh; kNUZS: $msg = array("\141\160\160\x69\144" => $setting["\141\160\x70\x69\x64"], "\x75\x6e\x69\141\x63\151\x64" => $uniacid, "\143\157\156\164\145\156\x74" => $keyword, "\x74\x6f\165\x73\145\162" => $toUsername, "\146\x72\157\x6d\165\163\145\162" => $fromUsername, "\x74\x79\160\145" => $form_MsgType, "\x63\162\145\141\164\145\164\x69\155\x65" => $createTime, "\x63\157\156\x74\145\x6e\x74" => $keyword, "\160\x69\143\x74\x75\x72\145" => $picture, "\155\x65\x64\x69\141\137\151\144" => $mediaId); goto t3KQi; fqyqP: exit; goto ij3v9; gelRg: $msg["\151\144"] = $db->add($msg); goto l2B40; ooCPk: $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr); goto NcZ9N; KO3zr: hgSPW: goto oOh9U; RyRdp: AVqLh: goto BzEOo; MaAUP: Hr3dr: goto N33BB; pjnrB: if ($form_MsgType == "\145\x76\x65\156\164") { goto F51yP; } goto zCl39; bQiGN: mkdir($path); goto dvYzm; I7n5A: KM0R3: goto XQQLO; ukdGn: $token = $wxjs->getToken(); goto aOExY; lP8WB: $keyword = trim($postObj->Content); goto eNETE; WntHa: global $_W; goto ZiG7N; ZiG7N: $uniacid = intval($_W["\165\156\x69\141\143\x69\144"]); goto DRhzQ; DRhzQ: $setting = $this->setting; goto nFZdV; Lg3n3: $picture = "\x69\x6d\141\x67\145\163\57" . $uniacid . "\57" . date("\131", time()) . "\57" . date("\x6d", time()) . "\x2f" . $filename; goto rSMKZ; V0xF8: f4xmn: goto c2Vsa; MYpyX: $this->sendSource($fromUsername, $source); goto sUNFY; N33BB: $msgType = "\164\145\x78\x74"; goto C2QXG; y9Zhm: GSuRZ: goto gmYNl; HIWOw: if (!($form_Event == "\x75\x73\145\162\137\145\x6e\164\x65\162\x5f\164\145\x6d\160\x73\x65\x73\x73\151\x6f\156")) { goto Dglw6; } goto la6X1; Fr4V6: Hhr9X: goto rBd26; eP4WQ: } public function sendMsg() { goto BZwp8; j1pio: $res["\x73\x74\x61\164\165\x73"] = $mid; goto Q7c1o; daSxe: $msg = array("\143\x72\145\x61\164\x65\164\151\x6d\145" => time(), "\x73\x68\x6f\160\x69\144" => 0, "\162\145\x70\154\x79\x69\144" => 0, "\x72\145\160\154\171\163\x74\163" => 0, "\164\171\160\x65" => $_GPC["\164\x79\160\x65"], "\143\x6f\156\x74\145\156\164" => $_GPC["\x63\x6f\x6e\x74\x65\x6e\x74"], "\146\162\157\x6d\165\163\x65\x72" => $_W["\x61\x63\x63\157\165\x6e\164"]["\x6f\162\x69\147\151\x6e\141\154"], "\x74\157\165\x73\x65\162" => $_GPC["\x74\157\165\163\x65\162"], "\x75\x6e\151\141\143\151\x64" => $uniacid, "\x6b\x65\x66\x75\157\160\x65\156\151\144" => $_GPC["\153\x65\x66\x75\157\160\x65\x6e\151\144"]); goto ZKcXu; szQSU: if (!$mid) { goto ZW57l; } goto TdHAk; BZwp8: global $_W, $_GPC; goto qSNVf; h4eFN: echo json_encode($res); goto No8p4; qSNVf: $uniacid = intval($_W["\x75\x6e\151\x61\143\x69\x64"]); goto daSxe; TdHAk: $res = $this->sendSource($_GPC["\x74\x6f\x75\163\145\x72"], $msg); goto BWy8F; ZKcXu: $model = Model("\155\x73\x67\x61\160\x69"); goto y8Q7Q; y8Q7Q: $mid = $model->add($msg); goto szQSU; BWy8F: ZW57l: goto j1pio; Q7c1o: $res["\155\145\x73\163\141\x67\145"] = $model->where("\151\x64\75{$mid}")->get(); goto h4eFN; No8p4: } public function sendSource($openid, $source) { goto RSkfQ; N0iKK: switch ($source["\x74\x79\160\x65"]) { case "\x24\x73\x65\x74\x74\x69\x6e\147\x5f\165\162\154": goto j3GtM; j3GtM: $tag = "\74\141\x20\x68\162\x65\x66\x3d\47\x68\x74\x74\160\72\x2f\x2f\x77\167\x77\56\x71\161\56\x63\x6f\x6d\47\40\x64\x61\164\141\55\x6d\x69\156\x69\x70\x72\x6f\147\162\141\155\x2d\x61\x70\160\x69\144\x3d\47" . $source["\x61\x70\160\151\144"] . "\47\40\x64\x61\164\x61\55\155\x69\156\151\x70\162\x6f\x67\x72\141\x6d\x2d\160\x61\x74\x68\75\x27" . $source["\x70\x61\x67\x65\160\141\x74\150"] . "\47\76" . $source["\156\x61\155\145"] . "\74\57\141\76"; goto Ey1yr; esTIF: goto bAXNQ; goto Ux8_p; Ey1yr: $json = "\x7b\xd\xa\40\40\x20\x20\40\x20\x20\x20\x20\40\40\x20\40\x20\40\x20\x20\x20\40\x20\x22\x74\157\165\163\145\162\x22\x3a\42" . $openid . "\42\x2c\15\12\x20\x20\x20\x20\x20\x20\40\40\x20\40\x20\x20\x20\x20\40\x20\40\40\x20\x20\x22\x6d\x73\x67\x74\171\160\145\42\x3a\x22\164\145\x78\164\x22\x2c\xd\xa\40\40\40\x20\x20\40\40\x20\x20\x20\x20\x20\40\40\40\x20\40\40\40\x20\42\164\145\170\x74\x22\72\15\12\x20\40\x20\x20\40\40\x20\40\40\x20\40\40\40\x20\x20\x20\x20\x20\40\x20\173\xd\12\x20\x20\x20\40\40\40\40\40\40\x20\x20\40\x20\x20\x20\x20\40\x20\40\x20\x20\x20\x20\x20\x20\x22\x63\157\x6e\x74\x65\156\164\42\72\42" . $tag . "\x22\xd\12\x20\40\40\x20\40\40\x20\x20\40\x20\x20\x20\40\40\40\40\x20\x20\40\40\175\xd\12\40\40\x20\x20\x20\x20\40\40\40\x20\40\x20\x20\x20\x20\x20\175"; goto esTIF; Ux8_p: case "\x74\145\x78\x74": $json = "\x7b\15\12\40\40\x20\40\x20\40\x20\40\x20\x20\x20\40\x20\x20\x20\x20\x20\x20\40\x20\x22\x74\157\165\163\x65\162\x22\x3a\42" . $openid . "\42\x2c\xd\xa\40\40\x20\x20\x20\40\x20\x20\x20\40\x20\x20\40\x20\40\x20\x20\40\x20\40\x22\155\163\147\x74\x79\160\x65\42\72\x22\x74\x65\x78\164\42\54\15\xa\40\40\40\40\40\40\40\x20\x20\x20\40\x20\40\40\x20\x20\x20\x20\x20\x20\x22\164\145\x78\164\x22\x3a\15\xa\40\x20\x20\40\x20\40\40\x20\40\x20\x20\40\40\40\40\40\x20\40\40\x20\x7b\xd\xa\40\x20\40\40\40\40\40\x20\x20\40\40\x20\x20\40\x20\x20\40\40\40\40\x20\x20\40\x20\x20\42\143\157\x6e\x74\x65\x6e\164\x22\72\42" . $source["\143\157\x6e\164\x65\x6e\x74"] . "\x22\15\xa\40\40\40\40\x20\40\x20\40\x20\x20\x20\40\40\40\x20\40\40\x20\x20\40\175\xd\12\40\x20\x20\40\40\x20\x20\x20\40\40\x20\x20\x20\40\40\x20\x7d"; goto bAXNQ; case "\151\155\x61\147\145": $json = "\173\xd\12\40\x20\x20\40\40\40\40\40\40\40\40\x20\x20\x20\40\40\x20\x20\40\40\42\x74\157\x75\163\145\162\x22\72\42" . $openid . "\x22\54\15\12\40\x20\40\40\x20\x20\x20\40\x20\x20\x20\40\x20\x20\x20\x20\40\40\x20\x20\x22\x6d\x73\x67\164\x79\160\x65\42\72\42\151\155\141\x67\x65\x22\54\xd\xa\x20\x20\40\x20\40\x20\40\40\40\x20\x20\40\40\40\40\x20\40\x20\40\x20\x22\x69\155\141\147\x65\x22\x3a\xd\xa\40\40\40\40\x20\40\x20\40\40\40\x20\x20\x20\40\40\40\40\x20\40\x20\173\15\xa\40\x20\40\40\x20\40\x20\x20\40\x20\40\40\x20\40\40\x20\x20\40\40\x20\40\x20\40\40\40\x22\x6d\145\x64\151\141\x5f\151\x64\42\x3a\x22" . $source["\x6d\x65\144\151\x61\x5f\151\x64"] . "\x22\15\xa\x20\40\40\40\40\x20\40\x20\x20\40\40\x20\40\x20\40\x20\40\40\40\x20\175\15\xa\40\40\x20\x20\x20\x20\x20\x20\40\x20\40\x20\40\x20\x20\40\175"; goto bAXNQ; case "\x24\163\x65\164\x74\x69\x6e\x67\x5f\143\141\162\x64": $json = "\x7b\15\xa\40\x20\40\x20\40\x20\40\x20\x20\40\x20\x20\40\40\40\x20\42\x74\157\165\x73\x65\162\x22\x3a\x22" . $openid . "\42\x2c\15\xa\x20\x20\x20\x20\40\x20\x20\x20\x20\x20\x20\40\40\40\x20\40\42\155\163\x67\x74\x79\x70\145\x22\72\42\155\151\x6e\151\x70\162\x6f\147\162\x61\155\160\141\147\x65\x22\x2c\15\12\x20\40\x20\40\x20\40\x20\x20\40\40\40\x20\40\x20\40\x20\x22\x6d\151\x6e\x69\x70\162\157\147\162\141\x6d\x70\141\147\x65\x22\x3a\x7b\15\xa\40\40\40\x20\40\40\40\40\40\40\x20\x20\40\x20\x20\x20\40\40\x20\x20\42\x74\x69\x74\154\x65\42\x3a\x22" . $source["\156\x61\x6d\145"] . "\x22\54\15\12\x20\40\40\x20\40\x20\40\40\40\40\x20\40\x20\x20\x20\x20\40\40\x20\x20\x22\155\x65\144\x69\141\x5f\x69\x64\x22\x3a\x22" . $source["\155\x65\144\x69\141\x5f\151\x64"] . "\x22\x2c\15\xa\x20\40\40\x20\40\40\x20\x20\40\x20\40\x20\40\40\x20\x20\x20\x20\x20\40\x22\160\x61\x67\x65\x70\x61\x74\150\x22\72\42" . $source["\x70\141\147\x65\x70\x61\164\150"] . "\x22\15\xa\40\x20\x20\x20\40\x20\40\x20\x20\x20\40\x20\x20\x20\40\40\175\15\12\40\40\x20\x20\40\40\x20\40\x20\x20\40\x20\40\x20\40\40\175"; goto bAXNQ; case "\167\145\x62\137\x75\x72\x6c": goto WPQ38; PPDc7: $json = "\173\15\xa\x20\40\x20\40\40\x20\x20\40\40\40\40\40\40\x20\x20\40\x20\x20\x20\x20\x22\164\x6f\165\x73\x65\x72\42\72\x22" . $openid . "\42\54\xd\12\x20\x20\x20\40\x20\x20\40\x20\40\x20\x20\40\40\40\40\x20\x20\x20\x20\40\42\x6d\163\147\164\171\x70\x65\x22\x3a\42\x74\145\170\164\x22\54\15\12\40\40\x20\40\x20\40\x20\40\40\x20\x20\40\40\40\40\x20\40\40\x20\x20\42\164\x65\x78\x74\42\72\xd\12\x20\x20\40\40\x20\40\40\x20\40\40\40\40\40\x20\x20\x20\40\x20\x20\x20\x7b\15\xa\40\x20\x20\x20\40\40\x20\x20\40\x20\40\x20\40\x20\40\40\x20\40\40\x20\40\x20\40\40\x20\42\x63\x6f\156\164\x65\156\164\x22\72\x22" . $url . "\42\xd\xa\40\x20\40\40\40\40\40\40\40\40\x20\x20\x20\40\x20\40\40\40\40\x20\x7d\15\12\40\x20\x20\40\40\40\40\x20\x20\x20\40\40\40\40\x20\40\175"; goto grpW1; grpW1: goto bAXNQ; goto sSsZA; WPQ38: $url = "\74\x61\40\x68\162\145\146\75\x27" . $source["\x75\x72\x6c"] . "\47\x3e" . $source["\156\141\155\x65"] . "\74\57\x61\x3e"; goto PPDc7; sSsZA: case "\x69\x6d\x61\147\145\x5f\164\145\x78\x74": $json = "\173\15\xa\40\40\40\x20\40\x20\40\x20\40\x20\40\40\40\x20\40\40\40\40\x20\40\42\x74\157\165\x73\145\162\42\72\40\x22" . $openid . "\42\x2c\15\xa\x20\40\x20\40\40\40\40\x20\x20\x20\40\40\x20\40\40\40\40\40\x20\x20\x22\155\163\147\x74\171\160\x65\x22\x3a\x20\x22\154\x69\x6e\x6b\42\x2c\xd\xa\40\40\40\x20\x20\x20\40\40\x20\40\x20\x20\x20\x20\x20\x20\x20\x20\40\40\x22\x6c\151\x6e\x6b\x22\72\173\15\12\40\40\40\40\40\40\40\40\40\40\40\40\40\x20\40\x20\40\x20\x20\40\40\x20\40\40\x22\164\151\x74\x6c\145\x22\72\40\x22" . $source["\164\151\164\x6c\145"] . "\42\x2c\xd\12\x20\x20\x20\40\x20\40\x20\40\x20\x20\x20\x20\x20\40\40\x20\40\40\40\40\x20\40\40\x20\x22\144\145\163\x63\162\x69\160\x74\x69\157\x6e\42\72\40\42" . $source["\x64\145\x73\143\162\151\160\164\151\x6f\x6e"] . "\42\x2c\xd\xa\40\40\40\40\40\40\40\x20\x20\x20\x20\40\40\x20\x20\x20\40\x20\x20\x20\40\40\x20\40\x22\165\162\154\x22\72\40\42" . $source["\x75\x72\154"] . "\x22\x2c\15\xa\40\40\40\40\40\40\x20\40\40\x20\x20\x20\40\40\40\40\40\x20\x20\x20\40\40\40\40\42\x74\x68\x75\155\142\x5f\x75\x72\154\42\72\x22" . $source["\x75\x72\x6c"] . "\x22\54\xd\12\x20\x20\40\40\40\x20\40\40\40\40\40\40\40\x20\40\40\40\x20\x20\x20\40\40\40\40\42\x70\x69\x63\x75\x72\154\42\72\x20\42" . $_W["\141\164\x74\141\143\x68\x75\x72\154"] . $source["\x74\x68\165\155\142"] . "\x22\15\xa\40\x20\40\40\40\40\40\x20\40\x20\40\x20\x20\40\40\x20\40\x20\x20\x20\175\15\xa\x20\40\x20\40\40\x20\x20\40\x20\40\x20\x20\40\x20\40\40\x7d"; goto bAXNQ; default: goto bAXNQ; } goto Umbmo; RSkfQ: global $_W, $_GPC; goto BKJ2P; dYXiR: vH0wZ: goto JFqqU; WWQjd: bAXNQ: goto DqVLr; HbXV5: $url = "\x68\x74\164\160\163\x3a\x2f\x2f\x61\x70\151\56\167\x65\151\x78\x69\x6e\56\161\x71\56\143\x6f\155\57\143\x67\151\x2d\142\x69\x6e\x2f\x6d\145\163\163\141\x67\145\57\143\x75\163\x74\157\x6d\x2f\x73\x65\x6e\x64\77\x61\143\143\x65\163\x73\x5f\164\x6f\x6b\145\156\75" . $token["\x61\143\x63\145\163\163\x5f\164\x6f\153\145\156"]; goto vwa9K; Eo0PW: $url = "\150\164\x74\160\x73\72\x2f\57\x61\x70\151\56\167\145\151\x78\151\x6e\x2e\161\x71\x2e\x63\157\155\57\143\x67\151\x2d\142\151\x6e\x2f\x6d\x65\163\163\x61\147\x65\x2f\x74\x65\155\160\154\x61\x74\x65\57\163\x65\156\x64\77\141\143\143\145\163\x73\137\x74\157\x6b\145\x6e\x3d" . $token["\x61\x63\143\x65\x73\x73\137\164\157\153\145\156"]; goto UIm6J; CsQjW: $token = $wxjs->getToken(); goto HbXV5; PGMpQ: $token = $wxjs->getToken(true); goto Eo0PW; Umbmo: YKYHt: goto WWQjd; UIm6J: $res = CURL_send($url, $json); goto dYXiR; JFqqU: return $res; goto nBBs1; PwOxe: if (!($res["\x65\x72\162\x63\x6f\x64\145"] == "\x34\x30\x30\x30\x31")) { goto vH0wZ; } goto PGMpQ; DqVLr: $wxjs = new WeixinJS($_W["\x61\143\143\157\165\156\164"]["\x6b\x65\171"], $_W["\141\x63\x63\x6f\165\156\164"]["\x73\145\143\162\145\x74"]); goto CsQjW; vwa9K: $res = CURL_send($url, $json); goto PwOxe; BKJ2P: $setting = $this->setting; goto N0iKK; nBBs1: } public function noticeMsg($msg) { goto m7j9w; YCUoq: $token = $wxjs->getToken(); goto OKCx7; nXJkK: $setting = $this->setting; goto eXP1L; eXP1L: $member = Model("\155\x65\x6d\142\145\x72")->where("\x6f\x70\145\x6e\151\x64\x3d\47" . $msg["\x66\162\157\x6d\x75\163\145\x72"] . "\47")->get(); goto GiVxQ; UwhHs: global $_W; goto PkE37; m7j9w: $current = "\x68\164\164\x70\x3a\x2f\57" . $_SERVER["\x48\124\x54\120\137\x48\117\123\124"] . $_SERVER["\x50\110\x50\x5f\123\x45\114\x46"]; goto Up2DT; AJwVy: $kefus = $model->where("\165\156\151\141\x63\x69\x64\75{$uniacid}\x20\x61\156\144\x20\164\x79\160\x65\75\64\x20\141\156\144\40\163\x74\141\x74\x75\163\76\60")->limit(5)->getall(); goto Fs8NR; Up2DT: $sitearr = explode("\x2f\x61\x64\144\157\x6e\163", $current); goto ZldRv; GiVxQ: $model = Model("\x70\x75\x73\x68\145\162"); goto AJwVy; ZldRv: $url0 = $sitearr[0] . "\57\141\x70\160\x2f\151\x6e\144\145\x78\56\160\150\160\77\x69\x3d" . $msg["\165\156\151\141\143\x69\144"] . "\46\x63\75\x65\156\164\x72\x79\46\x64\x6f\x3d\x72\x6f\165\164\x65\46\x6d\x3d\x67\x69\172\x5f\163\145\162\166\151\x63\x65\x26\x61\x63\x74\75\143\x68\141\164\56\x63\150\x61\164\166\151\145\167\x26\141\160\x70\151\144\75" . $msg["\141\160\160\x69\x64"] . "\x26\146\162\x6f\x6d\x75\163\145\x72\x3d" . $msg["\x66\x72\x6f\x6d\x75\x73\x65\x72"] . "\46\x6d\151\144\x3d" . $msg["\x69\144"]; goto UwhHs; Fs8NR: $wxjs = new WeixinJS($setting["\167\x78\137\x61\160\x70\x69\x64"], $setting["\167\170\137\163\145\143\162\145\x74"]); goto YCUoq; OKCx7: foreach ($kefus as $key => $kefu) { goto uvzN2; UDbmr: $token = $wxjs->getToken(true); goto pyQ7w; J0lb_: if (!($res["\145\162\x72\x63\x6f\x64\145"] == "\x34\60\x30\60\61")) { goto YJW_M; } goto UDbmr; e3PRQ: debug_log($jsonStr); goto pqd9C; pqd9C: debug_log($res); goto d8LGw; d8LGw: EMvco: goto fjdWS; uvzN2: $jsonStr = "\x7b\xd\xa\x20\x20\x20\x20\x20\40\x20\40\x20\40\x20\x20\40\x20\x20\x20\40\x20\40\x22\x74\x6f\165\x73\x65\x72\42\x3a\42" . $kefu["\x6f\160\x65\x6e\x69\x64"] . "\x22\54\xd\12\40\40\40\40\40\40\40\x20\x20\x20\x20\x20\40\x20\40\x20\x20\x20\40\x22\164\145\155\160\x6c\x61\164\145\137\151\x64\42\x3a\42" . $setting["\x77\170\137\x63\x6f\156\146"]["\x6d\x73\147\141\160\151\x5f\164\145\155\x70\154\x61\x74\x65\137\x69\x64"] . "\x22\x2c\xd\xa\x20\x20\40\x20\x20\x20\x20\40\x20\x20\40\40\x20\x20\x20\40\x20\40\40\42\155\151\x6e\151\x70\162\157\x67\162\141\x6d\x22\x3a\173\15\xa\40\40\x20\x20\x20\40\x20\x20\40\x20\40\x20\40\x20\x20\x20\40\x20\x20\40\x20\42\x61\x70\160\x69\144\42\72\x22" . $_W["\x61\x63\x63\157\x75\156\164"]["\x6b\145\x79"] . "\x22\x2c\xd\12\x20\40\x20\40\40\x20\x20\40\40\40\x20\40\40\40\40\40\x20\x20\x20\40\x20\x22\x70\x61\147\x65\x70\x61\164\x68\x22\x3a\42\x2f\x7a\x73\x6b\x5f\155\x61\x72\x6b\x65\x74\57\160\141\147\145\x73\57\141\x64\x6d\151\x6e\x2f\151\x6e\x64\x65\170\x2f\155\145\x73\x73\x61\x67\145\77\x66\162\157\155\x75\163\x65\x72\75" . $msg["\x66\x72\157\155\165\163\145\x72"] . "\x22\xd\xa\x20\x20\40\40\x20\x20\40\40\x20\40\40\40\x20\40\40\40\x20\40\x20\x7d\x2c\15\12\40\40\x20\40\40\x20\x20\40\x20\x20\x20\x20\40\x20\40\x20\40\x20\40\42\144\x61\x74\x61\x22\x3a\173\15\12\40\x20\x20\40\40\x20\40\40\x20\x20\x20\x20\40\40\40\x20\x20\x20\40\40\x20\40\40\40\x20\x20\40\42\146\x69\162\163\164\42\x3a\x20\173\15\12\x20\x20\x20\40\40\40\40\40\x20\40\x20\x20\x20\x20\x20\x20\40\x20\x20\x20\x20\x20\x20\x20\40\40\x20\x20\40\x20\40\x22\166\141\154\x75\x65\x22\x3a\42\xe3\x80\220" . $setting["\156\x61\155\145"] . "\xe3\x80\x91\346\234\x89\346\x96\xb0\xe7\232\x84\345\256\xa2\346\234\x8d\xe6\xb6\210\xe6\201\257\x22\54\15\12\x20\x20\40\40\40\x20\x20\40\40\x20\40\40\40\x20\x20\x20\x20\40\x20\x20\x20\x20\40\40\x20\x20\40\40\x20\x20\x20\x22\143\157\x6c\x6f\x72\42\72\42\x23\61\67\63\61\x37\x37\x22\15\xa\x20\40\x20\40\x20\x20\40\x20\x20\x20\40\x20\40\40\40\x20\x20\x20\x20\x20\40\40\x20\40\x20\x20\40\175\54\xd\xa\40\x20\x20\40\40\x20\40\x20\40\x20\40\x20\x20\40\40\x20\40\40\x20\x20\x20\x20\x20\40\x20\40\x20\42\x6b\x65\x79\x77\x6f\x72\x64\x31\x22\x3a\173\15\12\x20\x20\40\40\40\40\x20\40\40\40\40\40\x20\x20\40\x20\x20\x20\40\x20\40\40\x20\x20\40\40\40\40\40\x20\x20\42\166\x61\x6c\165\x65\42\72\42" . $member["\x6e\151\x63\x6b\x6e\x61\x6d\x65"] . "\42\54\15\xa\x20\x20\x20\40\x20\40\x20\40\40\40\40\x20\40\x20\x20\40\40\40\40\40\x20\x20\x20\40\40\40\40\x20\x20\40\x20\x22\x63\157\x6c\x6f\162\42\72\x22\43\x31\67\x33\61\67\67\x22\15\xa\40\x20\x20\x20\40\40\x20\40\x20\40\x20\40\x20\40\40\40\40\x20\40\x20\x20\x20\x20\x20\x20\x20\40\x7d\x2c\x20\xd\xa\40\40\40\x20\x20\40\x20\40\x20\x20\x20\40\x20\x20\x20\x20\40\x20\x20\x20\x20\x20\x20\x20\x20\40\40\x22\153\x65\x79\167\x6f\x72\x64\62\42\72\x20\x7b\xd\xa\40\x20\40\x20\40\x20\40\40\x20\40\40\x20\40\40\x20\40\40\x20\40\x20\x20\40\40\x20\x20\x20\40\40\40\x20\40\42\x76\141\x6c\x75\x65\42\x3a\x22" . $msg["\x63\x6f\156\x74\x65\x6e\x74"] . "\42\54\15\xa\40\40\x20\40\40\x20\40\x20\x20\40\x20\x20\40\40\40\40\40\x20\x20\x20\40\40\40\x20\40\40\x20\x20\x20\40\x20\x22\143\x6f\x6c\x6f\x72\42\x3a\x22\43\61\x37\x33\x31\x37\x37\x22\15\xa\40\40\40\40\40\x20\x20\x20\x20\x20\40\x20\x20\40\x20\x20\x20\x20\x20\40\x20\40\40\x20\x20\40\40\175\54\40\15\12\40\x20\x20\40\x20\40\x20\x20\40\40\x20\40\x20\40\40\40\40\40\40\40\x20\x20\x20\x20\40\40\40\42\x72\145\155\x61\162\153\42\x3a\173\xd\xa\40\x20\x20\x20\40\x20\40\x20\x20\x20\40\40\x20\40\40\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\40\x20\x20\x22\x76\141\154\165\x65\x22\72\42\xe6\227\xb6\xe9\x97\xb4\357\274\232" . date("\131\xe5\xb9\xb4\x6d\xe6\234\x88\144\346\x97\xa5\x20\x48\72\x69", time()) . "\357\274\x8c\xe8\xaf\xb7\xe5\260\275\xe5\277\xab\350\xbf\x9b\xe8\xa1\x8c\345\x9b\x9e\xe5\244\215\xef\274\x81\x22\x2c\xd\12\40\40\x20\x20\x20\x20\40\40\40\40\40\40\x20\x20\x20\x20\x20\40\x20\40\40\40\40\40\x20\40\x20\x20\x20\x20\40\42\143\157\154\157\x72\x22\72\x22\x23\71\x39\x39\71\x39\x39\x22\15\xa\x20\40\x20\x20\x20\40\x20\40\40\40\x20\40\40\x20\40\40\40\40\x20\40\40\x20\x20\40\40\40\40\175\15\12\x20\40\x20\x20\40\x20\x20\40\x20\x20\x20\40\x20\40\40\x20\x20\40\x20\175\xd\xa\40\x20\x20\x20\40\40\x20\x20\40\40\40\x20\40\40\40\175"; goto NP04P; T9i9l: $res = CURL_send($url, $jsonStr, 8); goto XGHYF; XGHYF: YJW_M: goto e3PRQ; G77M2: $res = CURL_send($url, $jsonStr, 8); goto J0lb_; pyQ7w: $url = "\x68\x74\164\x70\x73\x3a\x2f\x2f\x61\160\x69\x2e\x77\145\151\x78\151\x6e\56\161\161\56\143\x6f\x6d\57\x63\147\x69\55\142\x69\156\x2f\x6d\x65\163\x73\x61\x67\x65\57\x74\145\x6d\160\154\141\164\x65\x2f\x73\145\156\144\x3f\141\143\143\145\163\x73\x5f\x74\x6f\153\145\x6e\x3d" . $token["\141\x63\143\145\x73\x73\137\164\x6f\153\x65\156"]; goto T9i9l; NP04P: $url = "\x68\164\164\x70\163\x3a\57\x2f\141\x70\x69\x2e\x77\x65\151\170\x69\156\56\x71\x71\x2e\143\157\x6d\x2f\x63\x67\x69\55\x62\151\x6e\57\x6d\145\x73\163\141\x67\145\x2f\164\x65\155\160\x6c\x61\x74\x65\57\x73\x65\x6e\x64\77\141\143\143\x65\x73\163\x5f\164\157\153\145\x6e\75" . $token["\x61\143\x63\x65\x73\163\137\164\157\153\145\156"]; goto G77M2; fjdWS: } goto grbsi; grbsi: Zep2j: goto B4NIq; PkE37: $uniacid = intval($_W["\x75\x6e\x69\x61\x63\x69\x64"]); goto nXJkK; B4NIq: } public function valid() { goto gcLkM; fQA0m: Px3pt: goto pxLg7; E0ARE: exit; goto fQA0m; Sib0N: echo $echoStr; goto E0ARE; vGoGp: if (!$this->checkSignature()) { goto Px3pt; } goto Sib0N; gcLkM: $echoStr = $_GET["\145\143\x68\157\x73\164\x72"]; goto vGoGp; pxLg7: } private function checkSignature() { goto iUT9x; jmDD5: $tmpStr = sha1($tmpStr); goto Hsa40; FHURj: $token = MSGAPI_TOKEN; goto uJb5o; MKFXD: XowTJ: goto BlN0d; uJb5o: $tmpArr = array($token, $timestamp, $nonce); goto gk9pZ; Hsa40: if ($tmpStr == $signature) { goto UxVga; } goto ntejB; xh3U5: $tmpStr = implode($tmpArr); goto jmDD5; ZGEpI: $timestamp = $_GET["\164\151\155\145\163\x74\141\155\160"]; goto R1ERl; w05Bw: goto XowTJ; goto GTEUJ; R1ERl: $nonce = $_GET["\x6e\x6f\156\143\145"]; goto FHURj; GTEUJ: UxVga: goto XecQy; XecQy: return true; goto MKFXD; ntejB: return false; goto w05Bw; iUT9x: $signature = $_GET["\x73\151\x67\x6e\x61\x74\x75\x72\x65"]; goto ZGEpI; gk9pZ: sort($tmpArr); goto xh3U5; BlN0d: } public function getmsgbyuser() { goto aOxyf; H7HLA: aKZNq: goto AWL3u; mcYHm: $sql = "\x53\x45\114\105\x43\x54\40\104\111\x53\124\111\x4e\103\x54\x20{$tab0}\x2e\x69\x64\x20\x61\x73\x20\x6d\x69\x64\54{$tab0}\56\x2a\54{$tab1}\x2e\x61\166\x61\164\141\x72\40\x61\x73\x20\153\145\146\165\141\166\x61\164\x61\x72\54{$tab1}\56\x6e\151\143\153\x6e\141\155\145\x20\141\163\x20\153\x65\146\x75\156\x69\143\153\x6e\x61\155\145\40\x46\x52\117\x4d\x20{$tab0}\x20\x4c\x45\x46\x54\x20\112\x4f\x49\x4e\40{$tab1}\x20\117\x4e\x20{$tab0}\x2e\153\x65\146\165\x6f\160\145\x6e\151\x64\x3d{$tab1}\56\157\160\145\x6e\151\144\x20\127\110\105\x52\105\40{$tab0}\56\x75\156\151\x61\143\151\x64\75{$uniacid}\x20\141\x6e\144\40\50{$tab0}\x2e\146\x72\x6f\x6d\165\x73\x65\x72\75\47{$openid}\47\40\157\x72\x20{$tab0}\x2e\164\157\165\163\145\162\x3d\x27{$openid}\x27\51\40\141\x6e\144\40{$tab0}\56\143\x72\x65\x61\164\145\164\x69\x6d\x65\74\x3d{$startstamp}\40\x4f\x52\x44\x45\x52\40\x42\x59\x20{$tab0}\x2e\x63\x72\x65\x61\164\x65\x74\x69\155\145\x20\x64\145\163\143\x20"; goto zCqp7; stAaA: echo JSON_OUT($page); goto fbq1R; tFUsQ: $tab0 = $model->tablename("\155\163\x67\141\x70\151"); goto YZyeh; RX5qU: $model = Model("\155\163\147\x61\x70\151"); goto tFUsQ; V3ycy: foreach ($page["\x64\141\x74\141\x73\x65\x74"] as $key => $val) { goto h04c9; q1uPM: nNw_t: goto wxB7D; FZs58: $page["\144\141\164\141\x73\x65\x74"][$key]["\164\151\155\x65"] = date("\155\346\x9c\210\x64\346\227\xa5\40\x48\72\x69\72\x73", $val["\143\x72\145\x61\164\x65\x74\x69\x6d\x65"]); goto SdRIi; OG3IC: $page["\144\141\164\x61\163\145\x74"][$key]["\164\x69\x6d\x65"] = date("\x48\x3a\x69\72\163", $val["\x63\162\x65\141\164\145\x74\x69\x6d\145"]); goto QuywK; QuywK: goto dyNJS; goto k14xj; k14xj: zxC0L: goto FZs58; qm3T9: if (date("\x59\x2d\x6d\55\144", $val["\x63\x72\x65\141\x74\145\x74\151\155\x65"]) != date("\x59\x2d\155\x2d\x64", time())) { goto zxC0L; } goto OG3IC; h04c9: $page["\144\x61\164\x61\163\145\164"][$key]["\x64\x61\164\145\x74\x69\x6d\x65"] = date("\131\x2d\x6d\55\144\x20\110\72\x69\x3a\x73", $val["\x63\x72\x65\141\x74\x65\x74\151\155\145"]); goto qm3T9; SdRIi: dyNJS: goto q1uPM; wxB7D: } goto H7HLA; aOxyf: global $_W, $_GPC; goto s7VZu; ZuWMh: $openid = trim($_GPC["\146\162\157\x6d\x75\163\x65\162"]); goto euv2k; zCqp7: $page = $model->pagenation($sql); goto V3ycy; AWL3u: $page["\x74\x69\155\x65\163\164\141\155\160"] = time(); goto stAaA; s7VZu: $uniacid = intval($_W["\x75\x6e\151\141\x63\151\x64"]); goto ZuWMh; euv2k: $startstamp = intval($_GPC["\163\164\141\162\164\163\164\141\x6d\160"]); goto RX5qU; YZyeh: $tab1 = $model->tablename("\155\145\155\142\x65\x72"); goto mcYHm; fbq1R: } public function getfromuser() { goto rGmAp; QUvQb: $user = Model("\x6d\145\155\142\145\x72")->where("\x6f\160\145\156\151\x64\x3d\47{$openid}\47\40\x61\x6e\x64\40\x75\x6e\x69\x61\x63\x69\144\75{$uniacid}")->get(); goto Xk3mJ; x5Pjj: $uniacid = intval($_W["\x75\x6e\x69\141\143\x69\144"]); goto mnYNv; mnYNv: $openid = trim($_GPC["\146\x72\x6f\155\x75\163\x65\x72"]); goto QUvQb; rGmAp: global $_W, $_GPC; goto x5Pjj; Xk3mJ: echo JSON_OUT($user); goto TItgT; TItgT: } public function getnewmsg() { goto s8NhY; OPFna: $laststamp = intval($_GPC["\154\141\x73\164\163\164\141\x6d\x70"]); goto eoqew; Czuc5: JHTkw: goto LiS9e; LiS9e: echo JSON_OUT(array("\x64\x61\164\141\x73\x65\x74" => $msgs, "\154\141\x73\164\163\x74\141\155\x70" => time())); goto vHMO3; eoqew: $msgs = Model("\x6d\x73\147\x61\160\151")->where("\143\x72\x65\x61\x74\145\164\151\155\x65\76{$laststamp}\x20\x61\156\144\40\165\156\151\x61\x63\151\144\x3d{$uniacid}\40\141\x6e\x64\40\x28\146\x72\x6f\x6d\165\163\145\162\x3d\x27" . $openid . "\47\x20\157\x72\x20\164\157\x75\163\145\162\75\47" . $openid . "\x27\51")->order("\143\x72\145\x61\x74\x65\x74\151\x6d\145\40\x64\145\x73\143")->getall(); goto PBItr; PBItr: foreach ($msgs as $key => $val) { goto yZwCD; SBVph: LX27S: goto DYzTM; yZwCD: $msgs[$key]["\144\141\164\145\x74\151\x6d\x65"] = date("\x59\55\155\55\144\40\x48\72\x69\72\163", $val["\143\x72\145\x61\164\x65\164\x69\x6d\x65"]); goto ozMe7; ZDB1K: LKq6g: goto jVyaa; Ou2xi: goto TW_zm; goto SBVph; ozMe7: if (date("\131\55\155\55\x64", $val["\143\x72\145\141\164\145\164\x69\x6d\x65"]) != date("\131\x2d\155\x2d\x64", time())) { goto LX27S; } goto bmKnj; BFONI: TW_zm: goto ZDB1K; DYzTM: $msgs[$key]["\164\151\155\x65"] = date("\155\346\x9c\x88\x64\xe6\x97\xa5\x20\110\72\151\x3a\x73", $val["\143\x72\x65\x61\x74\x65\x74\151\x6d\145"]); goto BFONI; bmKnj: $msgs[$key]["\x74\x69\155\145"] = date("\x48\x3a\151\x3a\x73", $val["\x63\162\145\141\164\x65\x74\151\155\x65"]); goto Ou2xi; jVyaa: } goto Czuc5; s8NhY: global $_W, $_GPC; goto a3Sse; bd_8T: $openid = trim($_GPC["\x66\162\157\155\x75\163\x65\162"]); goto OPFna; a3Sse: $uniacid = intval($_W["\x75\x6e\151\x61\x63\x69\x64"]); goto bd_8T; vHMO3: } }