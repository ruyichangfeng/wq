<?php
/*   __________________________________________________
    |  Obfuscated by YAK Pro - Php Obfuscator          |
    |              on 2018-07-11 14:50:09              |
    |    GitHub: https://github.com/pk-fr/yakpro-po    |
    |__________________________________________________|
*/
 class MemberController extends CallWebBaseController { public $size = 10; public function index() { goto P0f63; KGtR_: $this->assign($data); goto jt9u0; dswyA: $where["\x69\x64"] = $uid; goto nZcjW; jt9u0: $this->display(); goto cuqQx; McWO5: $data["\x6c\151\x73\164"] = $this->UserModel->getList($where, "\x2a", ["\151\x64\x20\144\145\x73\x63"], [$pindex, $this->size]); goto KGtR_; ehTID: $data["\160\141\147\145\x72"] = pagination($total, $pindex, $this->size); goto McWO5; P0f63: $pindex = max(1, intval($this->GPC["\160\141\147\145"])); goto d1uu2; d1uu2: $uid = intval($this->GPC["\165\x69\144"]); goto UyRnK; YiccX: $total = $this->UserModel->count($where); goto ehTID; UyRnK: $where = ["\165\x6e\151\141\x63\151\x64" => $this->W["\165\156\151\141\x63\151\x64"]]; goto rNTOS; nZcjW: vfPsr: goto YiccX; rNTOS: if (!$uid) { goto vfPsr; } goto dswyA; cuqQx: } }