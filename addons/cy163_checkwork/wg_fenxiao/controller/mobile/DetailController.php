<?php
 class DetailController extends MobileBaseController { public function index() { goto TOz5e; bHzSi: $video = json_decode($data["\141\162\x74\151\143\154\x65"]["\143\157\x6e\164\145\x6e\x74"], true); goto Bs1Za; JU5cG: if ($data["\x61\162\164\x69\143\x6c\145"]) { goto ihkzj; } goto SorTd; sQpqj: E38ys: goto NYkhQ; W5mWJ: B6Cr5: goto bHzSi; WoEL_: Ec390: goto JU5cG; vhc_t: $data["\141\x72\x74\x69\143\154\145"]["\x76\151\144\x65\x6f\x5f\x75\162\154"] = $video["\166\x69\x64\x65\157\137\x75\x72\154"]; goto FbOqV; NtqV_: $flag = true; goto DnerM; Xe0nF: E114r: goto jVjV9; i2A99: $s_image = $_W["\x73\x69\x74\x65\x72\x6f\x6f\x74"] . $s_image; goto nu6m2; DnerM: $data["\x61\x72\x74\x69\x63\154\x65"] = $this->ArticleModel->getOne(["\x69\144" => $id]); goto mlK0w; oqsdf: $data["\x61\162\164\x69\143\x6c\x65"]["\x63\157\156\x74\145\156\x74"] = $content; goto WoEL_; yxa74: b_nQV: goto oqsdf; xKEg1: vNhPp: goto syOri; hV3kI: goto E114r; goto W5mWJ; syOri: $this->display("\x64\x65\164\141\151\x6c\x2f\x70\x61\x79"); goto k2OEs; oXY_9: if ($flag) { goto K4pqv; } goto TmZ8A; Bs1Za: $data["\x61\x72\x74\151\143\154\145"]["\166\x69\x64\145\x6f\x5f\164\171\x70\145"] = $video["\166\x69\144\x65\x6f\x5f\164\x79\x70\x65"]; goto vhc_t; FbOqV: $data["\141\162\164\151\x63\x6c\145"]["\x69\155\141\147\x65"] = json_decode($data["\x61\162\164\151\x63\x6c\145"]["\x69\x6d\141\x67\145"], true)[0]["\165\x72\154"]; goto CeMe2; SorTd: $flag = false; goto vR4CZ; jndqy: if (!($data["\141\162\164\x69\x63\154\x65"]["\x64\141\x74\x61\x5f\164\171\160\x65"] == 1)) { goto Ec390; } goto PxRJ_; R3u2k: $this->display("\x64\x65\164\141\x69\x6c\57\x69\155\141\x67\145"); goto Kb3x4; mHAkX: $this->assign($data); goto oXY_9; loyFq: $s_images = @json_decode($data["\x61\162\x74\151\x63\x6c\145"]["\x69\x6d\141\147\145"], true); goto wb8Wt; TmZ8A: $this->display("\x64\x65\x74\x61\x69\x6c\57\x65\x72\162\x6f\162"); goto Cage_; wb8Wt: if (!(is_array($s_images) && $s_images)) { goto E38ys; } goto cuiPO; CeMe2: $data["\141\x72\164\151\143\154\145"]["\143\x6f\156\x74\x65\x6e\164"] = $video["\143\x6f\156\164\145\x6e\x74"]; goto Xe0nF; xjP4F: $c = json_decode($data["\141\x72\x74\x69\143\x6c\145"]["\x63\157\x6e\164\145\x6e\164"], true)["\x63\x6f\156\x74\x65\156\164"]; goto ChBa0; GBy8r: $data["\154\151\x73\x74"] = $this->ArticleModel->getList(["\x77\x65\151\144" => $this->W["\x75\x6e\x69\x61\143\x69\144"]], ["\151\144", "\x74\151\x74\154\145", "\165\162\154", "\x6a\165\155\160"], ["\151\144\40\144\145\163\x63"], 5); goto mHAkX; PxRJ_: $content = ''; goto xjP4F; thlPc: $data["\x73\150\141\x72\145"] = ["\164\x69\x74\154\145" => $data["\x63\157\x6e\x66\x69\x67"]["\x6e\141\x6d\x65"] . "\x2d" . $data["\141\162\x74\x69\143\x6c\x65"]["\164\151\x74\154\x65"], "\x64\x65\x73\143" => $data["\x61\162\164\x69\143\154\x65"]["\x74\x65\170\164"] ? $data["\x61\x72\164\x69\143\x6c\x65"]["\164\145\x78\x74"] : '', "\x6c\x69\156\153" => $_W["\163\151\x74\145\162\x6f\x6f\x74"] . $_SERVER["\x52\105\121\125\105\x53\124\x5f\125\122\x49"], "\x69\155\x67\x55\162\x6c" => $s_image]; goto GBy8r; TOz5e: $id = intval($_REQUEST["\151\144"]); goto NtqV_; ChBa0: foreach ($c as $value) { goto AaHzs; RrgCu: goto GVI6C; goto ueCZz; A9X96: fSZ9V: goto bUCSO; bUCSO: $data["\x73\154\x69\144\145\x72"][] = $value["\x64\141\164\141"]["\x6f\x72\151\147\x69\156\141\x6c"]; goto eI0ol; P8B6i: YmlGX: goto GDcpx; AaHzs: if ($value["\x74\171\x70\x65"] == "\151\155\x61\147\145") { goto fSZ9V; } goto xZYJo; xZYJo: if ($value["\x74\171\160\145"] == "\164\x65\170\x74") { goto j0nbt; } goto EuLCI; aX76S: GVI6C: goto P8B6i; fUdUm: $content .= "\x3c\160\76" . $value["\x64\141\164\x61"] . "\x3c\160\57\76"; goto aX76S; eI0ol: $content .= "\x3c\160\76\74\151\x6d\147\40\x73\x72\143\75\x22" . $value["\x64\x61\164\x61"]["\157\162\151\x67\x69\x6e\141\x6c"]["\165\162\x6c"] . "\42\57\x3e\74\x2f\x70\76"; goto RrgCu; EuLCI: goto GVI6C; goto A9X96; ueCZz: j0nbt: goto fUdUm; GDcpx: } goto yxa74; cuiPO: $s_image = formatArrImage($s_images[0])["\x75\x72\154"]; goto sQpqj; vR4CZ: ihkzj: goto hV3kI; Cage_: K4pqv: goto tWgW2; UVddi: if ($data["\141\162\x74\151\x63\x6c\x65"]["\x74\x79\160\145"] == 3) { goto B6Cr5; } goto jndqy; nu6m2: RfEj0: goto thlPc; mlK0w: $this->ArticleModel->update(["\151\x64" => $id], ["\162\x65\141\144\137\x74\151\x6d\145\x73\40\53\x3d" => "\61"]); goto UVddi; Kb3x4: exit; goto xKEg1; jVjV9: global $_W; goto loyFq; tWgW2: if (!($data["\x61\x72\x74\151\x63\154\x65"]["\x74\171\160\x65"] == 2)) { goto vNhPp; } goto R3u2k; NYkhQ: if (!(strpos($s_image, "\150\x74\164\160") === false)) { goto RfEj0; } goto i2A99; k2OEs: } public function praisearticle() { goto LVel7; gZqKf: $this->ArticleModel->update(["\x69\144" => $id], ["\x70\162\x61\x69\x73\x65\40\53\75" => "\61"]); goto yg22N; ECEDr: echo json_encode(["\x63\157\144\145" => 1, "\155\163\x67" => '']); goto ZZtXJ; yg22N: setcookie($key, 1, time() + 3600 * 24, "\x2f"); goto gCPc3; WMIXF: exit; goto UBqVM; BCLSr: if (!$_COOKIE[$key]) { goto XGgYn; } goto ECEDr; LVel7: $id = intval($_REQUEST["\151\x64"]); goto jpiAQ; sIIw2: XGgYn: goto gZqKf; gCPc3: echo json_encode(["\x63\157\x64\x65" => 0, "\x6d\163\147" => '']); goto WMIXF; jpiAQ: $key = "\x77\x67\x5f\163\x61\x6c\x65\x73\x5f\x70\162\141\x69\163\145\x5f\x61\162\x74\x69\143\154\x65\x5f" . $id; goto BCLSr; ZZtXJ: exit; goto sIIw2; UBqVM: } }