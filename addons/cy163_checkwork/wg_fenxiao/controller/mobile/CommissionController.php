<?php
 class CommissionController extends MobileBaseController { public function index() { goto zZIBh; EkNYs: $this->data["\x74\x69\155\x65"] = $time * 3600 * 24; goto LvEpM; nsaze: $this->data["\x73\164\141\164\165\163"] = $_GET["\163\164\x61\164\x75\x73"] ? $_GET["\163\164\x61\x74\165\163"] : "\141\x6c\154"; goto EkNYs; brWHw: $time = $this->site->configs["\x63\157\x6e\146\151\147"]["\161\165\x65\162\145\156\x73\x68\x6f\x75\x68\165\157"]; goto sJLe5; sJLe5: $time = $time ? $time : 10000; goto nsaze; IwaF2: $this->display(); goto tLUpL; zZIBh: $this->data["\164\x69\x74\x6c\145"] = "\xe6\210\221\347\x9a\204\344\xbd\xa3\xe9\x87\x91"; goto brWHw; LvEpM: $this->assign($this->data); goto IwaF2; tLUpL: } public function more() { goto lYMWo; quju_: $this->ajaxReturn(0, '', ["\154\x69\x73\x74" => $list, "\160\141\147\145" => $page + 1, "\x6d\157\x72\145" => $more]); goto HhjEU; Z15VU: goto qlzEy; goto RVLOu; BsJAr: $time = $time ? $time : 10000; goto I873n; sfj4j: $time = $this->site->configs["\143\157\156\x66\151\x67"]["\x71\165\x65\x72\145\156\x73\150\157\165\x68\165\157"]; goto BsJAr; Qdhze: if ($status == "\165\156\160\x61\x79") { goto LVXbi; } goto HMlaP; HpNvw: $where["\x73\164\141\164\x75\163"] = 1; goto Z15VU; F_pO9: $where["\x75\151\144"] = $this->uid; goto sfj4j; xaEwl: ykiSv: goto RmFRA; grUVt: vFolu: goto pjU82; fwsPp: $list = $this->CommissionModel->getList($where, "\x2a", [], [$page, 10]); goto QyFZW; lYMWo: $page = intval($_GET["\x70\141\147\x65"]); goto vYWA6; i7ghq: if ($status == "\160\141\171\x65\x64") { goto bA6Lh; } goto Qdhze; h4H3x: bA6Lh: goto HpNvw; N4vKB: $where["\x73\x74\x61\164\x75\163"] = 0; goto eMAJF; eMAJF: goto qlzEy; goto h4H3x; QyFZW: $more = true; goto dbKAI; vYWA6: $status = $_GET["\x73\164\141\164\165\163"]; goto F_pO9; UQp0U: $where["\163\x74\x61\164\165\x73"] = 0; goto RjUpe; QywV7: if (!$list) { goto yuoxI; } goto AXJo0; RjUpe: qlzEy: goto fwsPp; dbKAI: if (!(count($list) < 10)) { goto aSryd; } goto LoG_j; pjU82: $where["\x66\x61\150\165\157\x73\x68\151\x6a\x69\x61\156\x20\76"] = 0; goto bbRAh; RmFRA: yuoxI: goto quju_; RVLOu: LVXbi: goto UQp0U; SiwEW: aSryd: goto QywV7; HMlaP: goto qlzEy; goto grUVt; I873n: if ($status == "\x70\x61\171") { goto vFolu; } goto i7ghq; LoG_j: $more = false; goto SiwEW; bbRAh: $where["\x66\141\x68\165\157\163\150\151\x6a\x69\x61\x6e\40\x3c"] = time() - $time * 3600 * 24; goto N4vKB; AXJo0: foreach ($list as &$value) { goto lssl2; vnHTW: qiJjG: goto MJgQE; YeMZ8: goto qiJjG; goto irq7B; AuzMs: NIYGx: goto pAf3G; irq7B: WO_vP: goto sfL9H; szrG_: if ($value["\146\141\150\165\157\163\150\151\152\x69\x61\x6e"] == 0) { goto WO_vP; } goto iXsKa; MJgQE: PNoON: goto AuzMs; lssl2: $value["\x74\151\x6d\x65"] = date("\x59\x2d\155\x2d\144\x20\x48\72\x69\x3a\163", $value["\143\x72\x65\x61\164\x65\164\151\155\x65"]); goto ZJmiP; ZJmiP: if (!($value["\x73\x74\x61\x74\165\x73"] == 0)) { goto PNoON; } goto szrG_; sfL9H: $value["\x74\145\x78\x74"] = "\xe6\x9c\xaa\345\217\x91\350\264\247"; goto vnHTW; iXsKa: $value["\x74\x65\x78\164"] = $this->formatTime($value["\x66\x61\150\165\x6f\163\150\151\x6a\151\x61\156"] + $time * 3600 * 24 - time()); goto YeMZ8; pAf3G: } goto xaEwl; HhjEU: } public function getmoney() { goto w46kt; t8c05: $result = $this->CommissionModel->update($where, ["\x73\164\x61\164\165\163" => 1, "\165\x70\x64\141\164\145\137\x74\151\x6d\x65" => time()]); goto xXwOF; KS_yi: $this->ajaxReturn(102, "\xe6\217\x90\347\x8e\260\345\244\261\xe8\264\xa5\133\x32\x5d"); goto efEd2; s1Z_o: $success = $this->MemberModel->update(["\151\144" => $this->uid], $update); goto XrHJm; yW31O: aMnpV: goto Rzq9j; xXwOF: if ($result) { goto xzOJp; } goto hZ5Sd; ye1KI: $time = $time * 3600 * 24; goto EcHOt; u6PKm: hWvW2: goto TkXzk; XrHJm: if ($success) { goto EOoOm; } goto lKyYK; efEd2: xzOJp: goto CaQ00; TkXzk: $this->ajaxReturn(102, "\346\217\x90\347\216\260\xe5\xa4\261\350\264\xa5\133\x32\135"); goto Oz4bh; wyNRW: $this->ajaxReturn(0, ''); goto u6PKm; FQM0n: $this->CommissionModel->commit(); goto wyNRW; Rzq9j: $time = $this->site->configs["\143\157\156\146\x69\147"]["\161\165\x65\162\145\x6e\163\150\x6f\165\150\165\x6f"]; goto qaZk1; tLFY0: $where["\x73\x74\x61\164\165\x73"] = 0; goto Dv1qF; qaZk1: $time = $time ? $time : 10000; goto ye1KI; OqNxb: $where["\151\144"] = $id; goto xJ0Zi; Dv1qF: $this->CommissionModel->begin(); goto t8c05; lKyYK: $this->CommissionModel->rollback(); goto d3lcR; CHa62: EOoOm: goto FQM0n; EcHOt: if (!($data["\146\141\150\x75\x6f\x73\150\x69\152\151\x61\156"] > 0 && $data["\x66\141\150\165\x6f\163\x68\151\x6a\151\x61\156"] < time() - $time)) { goto hWvW2; } goto JfkY3; xJ0Zi: $data = $this->CommissionModel->getOne($where, "\x2a"); goto xPCK1; d3lcR: $this->ajaxReturn(103, "\346\x8f\220\347\216\260\xe5\244\261\xe8\264\245\x5b\63\135"); goto CHa62; w46kt: $id = intval($_POST["\x69\x64"]); goto UMeAZ; KjWB7: $this->ajaxReturn(101, "\xe6\x8f\220\xe7\x8e\260\xe5\xa4\xb1\xe8\264\245\x5b\61\x5d"); goto yW31O; UMeAZ: $where["\x75\151\x64"] = $this->uid; goto OqNxb; CaQ00: $update = ["\x63\x6f\x6d\155\x69\x73\x73\x69\x6f\156\x20\53\75" => $data["\155\x6f\x6e\x65\x79"]]; goto s1Z_o; xPCK1: if ($data) { goto aMnpV; } goto KjWB7; ajRYk: $where["\146\141\150\165\157\163\150\x69\x6a\x69\141\x6e\40\x3c"] = time() - $time; goto tLFY0; JfkY3: $where["\146\x61\150\165\157\x73\x68\x69\x6a\151\x61\x6e\40\x3e"] = 0; goto ajRYk; hZ5Sd: $this->CommissionModel->rollback(); goto KS_yi; Oz4bh: } public function formatTime($time) { goto P_8UE; uDzT_: goto a6cXw; goto vaOBB; QBwqa: nRKbF: goto ST026; u4pkU: if ($t < 60 * 60) { goto ZHoBr; } goto r8FTl; r8FTl: if ($t < 60 * 60 * 24) { goto sqxrT; } goto T0f93; HeVj8: a6cXw: goto yvS1Q; SE1zp: $text = floor($t / 3600) . "\345\xb0\x8f\346\227\xb6\345\x88\xb0\350\xb4\246"; goto HeVj8; MDWRb: goto a6cXw; goto n0gFE; yvS1Q: return $text; goto LjhGu; b5cNx: $text = $t . "\xe7\247\x92\xe5\x88\xb0\xe8\264\246"; goto u67x8; qRwPb: $text = "\345\xb7\xb2\xe5\210\xb0\350\xb4\xa6"; goto uDzT_; A1HBR: ZHoBr: goto gmaey; qUdqt: if ($t < 60) { goto NnJXE; } goto u4pkU; ST026: $t = $time; goto IRp7i; P_8UE: if ($time) { goto nRKbF; } goto WkSkM; vaOBB: NnJXE: goto b5cNx; u67x8: goto a6cXw; goto A1HBR; WkSkM: return "\xe6\234\252\347\237\245"; goto QBwqa; erifW: sqxrT: goto SE1zp; T0f93: $text = floor($t / 86400) . "\345\xa4\xa9\xe5\x88\260\350\xb4\xa6"; goto MDWRb; n0gFE: Gew_V: goto qRwPb; IRp7i: if ($t <= 0) { goto Gew_V; } goto qUdqt; PTLLS: goto a6cXw; goto erifW; gmaey: $text = floor($t / 60) . "\345\210\x86\351\222\x9f\xe5\210\260\350\xb4\246"; goto PTLLS; LjhGu: } }