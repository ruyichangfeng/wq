<?php
 goto zL_fx; zL_fx: ?>
﻿<?php  goto hi4Ps; hi4Ps: defined("\111\116\137\111\x41") or exit("\101\x63\143\145\163\163\x20\104\145\156\151\145\144"); goto rwz67; rwz67: class Hy_supstoreModuleReceiver extends WeModuleReceiver { public function receive() { goto fb5ck; J3liJ: ju_4Y: goto ei0Ux; azAg0: $ticket = $this->message["\164\x69\143\153\x65\164"]; goto pJYVv; NC5FO: $acc = WeAccount::create($uniacid); goto AVdk8; whIVE: if (!$store) { goto TgL4m; } goto qbFtl; pJYVv: LscV5: goto Unzzb; xpMU4: if (!isset($this->message["\164\151\x63\153\x65\x74"])) { goto LscV5; } goto azAg0; yhOF2: $event = $this->message["\x65\x76\x65\x6e\x74"]; goto NC5FO; uqyKr: E9fig: goto knYvF; IcLBV: $store = pdo_fetch("\x73\x65\x6c\x65\143\x74\40\52\x20\x66\162\x6f\155\x20" . tablename("\x68\171\137\163\x75\160\163\x74\157\162\145\x5f\x73\164\157\x72\x65") . "\x20\x77\x68\x65\162\145\x20\x75\x6e\x69\x61\x63\x69\x64\x3d{$uniacid}\x20\141\156\144\40\x74\x69\143\x6b\x65\164\75\47{$ticket}\47\x20"); goto whIVE; J4yQb: $ticket = ''; goto xpMU4; AVdk8: $sceneid = $this->message["\163\143\x65\x6e\x65"]; goto J4yQb; Unzzb: if (!($event == "\x73\165\x62\x73\143\x72\x69\142\x65")) { goto ju_4Y; } goto IcLBV; H7WUH: $fansdata = pdo_fetch("\163\x65\154\145\143\x74\40\x2a\40\146\162\x6f\155\40" . tablename("\155\143\x5f\x6d\141\x70\x70\151\156\147\x5f\x66\x61\156\x73") . "\40\167\x68\145\162\x65\40\165\x6e\151\141\x63\151\x64\x3d{$uniacid}\40\141\156\144\40\x6f\x70\145\x6e\151\x64\75\47{$openid}\x27\40"); goto L2lyV; gidJa: $openid = $this->message["\146\162\157\155"]; goto yhOF2; L2lyV: $memdata = pdo_fetch("\163\145\154\145\143\x74\40\52\x20\146\x72\157\155\x20" . tablename("\x68\x79\x5f\163\x75\x70\163\x74\157\x72\145\137\x6d\x65\155\x62\145\x72\163") . "\x20\167\150\145\x72\x65\40\x75\x6e\x69\141\143\151\x64\x3d{$uniacid}\x20\141\156\144\40\157\x70\145\156\x69\x64\75\x27{$openid}\x27\x20\157\162\144\145\x72\x20\x62\171\x20\151\x64\x20\144\145\163\143\40"); goto EYi7j; EYi7j: if (!($fansdata["\x75\x69\x64"] != $memdata["\165\x69\x64"])) { goto E9fig; } goto VM0fb; knYvF: TgL4m: goto J3liJ; qbFtl: $store_id = $store["\x69\x64"]; goto H7WUH; cLIlM: $uniacid = $this->uniacid; goto gidJa; fb5ck: global $_W, $_GPC; goto cLIlM; VM0fb: $mcmemdata = pdo_fetch("\x73\145\x6c\145\143\164\x20\52\40\x66\162\157\x6d\x20" . tablename("\155\143\137\155\x65\155\142\x65\x72\163") . "\x20\167\150\x65\x72\145\40\165\156\x69\141\143\151\144\x3d{$uniacid}\x20\x61\156\x64\40\165\151\144\x3d" . $fansdata["\165\x69\144"] . "\40"); goto uqyKr; ei0Ux: } private function postRes($access_token, $data) { goto gEve7; Hq_WE: $content = @json_decode($ret["\x63\x6f\x6e\164\x65\156\164"], true); goto Epcfp; Epcfp: return $content["\x65\162\x72\143\x6f\x64\145"]; goto c4waP; MuVkM: $ret = ihttp_request($url, $data); goto Hq_WE; k6E72: load()->func("\143\157\155\x6d\165\156\151\x63\141\164\x69\x6f\156"); goto MuVkM; gEve7: $url = "\x68\x74\164\160\x73\x3a\57\57\x61\160\151\x2e\x77\x65\151\170\151\156\56\161\x71\56\143\x6f\155\57\x63\147\x69\x2d\142\x69\x6e\57\155\x65\x73\163\141\147\145\x2f\143\x75\x73\x74\x6f\x6d\x2f\163\145\x6e\x64\77\x61\x63\x63\145\x73\x73\137\x74\157\x6b\145\x6e\75{$access_token}"; goto k6E72; c4waP: } private function getAccessToken() { goto SZM7R; xHz8X: if (!empty($acid)) { goto NUUbV; } goto q8Nl1; Am3H3: load()->model("\x61\x63\x63\157\x75\156\x74"); goto a_H5t; bzgAP: $account = WeAccount::create($acid); goto itiPm; yl5PA: return $token; goto LJbfp; q8Nl1: $acid = $_W["\165\x6e\x69\x61\x63\x69\x64"]; goto LIwlx; itiPm: $token = $account->getAccessToken(); goto yl5PA; LIwlx: NUUbV: goto bzgAP; SZM7R: global $_W; goto Am3H3; a_H5t: $acid = $_W["\141\x63\151\144"]; goto xHz8X; LJbfp: } }