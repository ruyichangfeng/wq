<?php
 class AddressController extends MobileBaseController { public $size = 10; public function index() { goto AphD8; i_P2h: $data["\163\x68\157\x77\x5f\154\x69\163\164"] = true; goto BZx4F; AphD8: $data["\x74\x69\x74\x6c\x65"] = "\xe6\210\x91\347\232\204\xe6\224\xb6\xe8\x8e\267\xe5\x9c\260\xe5\235\200"; goto i_P2h; brUuT: $data["\x61\x64\144\162\x65\163\163"] = $this->AddressModel->getList(["\165\x6e\x69\141\143\x69\x64" => $this->W["\165\x6e\x69\x61\143\151\144"], "\x75\x69\x64" => $this->uid], "\52"); goto J1wTy; J1wTy: $this->assign($data); goto QW5t0; QW5t0: $this->display(); goto tpYBZ; BZx4F: $data["\x66\x61\x73\164\137\155\145\x6e\165"] = false; goto brUuT; tpYBZ: } public function add() { goto U4h1j; scmlO: $data["\144\x69\x73\x74\x72\x69\143\164"] = trim($_POST["\x64\x69\x73\164\162\151\x63\x74"]); goto ZY4n9; Q72UK: yZQPw: goto WDlUd; qMJzD: $this->ajaxReturn(0, ''); goto pvH0S; lXw2g: $data["\x75\156\x69\x61\x63\151\x64"] = $this->W["\165\156\x69\x61\143\151\144"]; goto w2T6d; w2T6d: $data["\165\163\x65\162\x6e\141\x6d\145"] = trim($_POST["\165\x73\145\x72\156\141\x6d\x65"]); goto gsTzK; aTgtM: $data["\x64\145\164\141\151\x6c"] = $this->AddressModel->getOne(["\151\x64" => $id, "\165\151\x64" => $this->uid]); goto Oa8n3; xRMgo: $this->display(); goto Fu2MJ; rUzls: if ($id) { goto IOAAq; } goto e2Afj; YevKq: Dk7ro: goto b8Wb4; QvAdr: goto pGz83; goto Uz8K9; vgMZ5: foreach ($data as $key => $value) { goto TbD3u; TbD3u: if (!($value == '')) { goto Sgd2y; } goto nUHcf; dhMOK: Sgd2y: goto GGPb3; GGPb3: kYDTG: goto eDnsg; nUHcf: $this->ajaxReturn(101, "\xe5\x9c\260\xe5\x9d\x80\351\x94\x99\350\257\257"); goto dhMOK; eDnsg: } goto Q72UK; Aauom: $this->ajaxReturn(0, ''); goto z7uCO; WDlUd: $id = intval($_POST["\151\x64"]); goto rUzls; s3JuF: KCfET: goto Ydjp_; spyAr: if (!$id) { goto Dk7ro; } goto aTgtM; gsTzK: $data["\x6d\x6f\142\151\154\145"] = trim($_POST["\155\x6f\x62\151\154\145"]); goto mbxLt; U4h1j: if (!$this->ispost()) { goto KCfET; } goto iMEJw; z7uCO: pGz83: goto L9gN_; b8Wb4: $data["\x65\144\151\x74"] = true; goto hFQqb; e2Afj: if (!$this->AddressModel->add($data)) { goto t0MOq; } goto qMJzD; pvH0S: t0MOq: goto QvAdr; mbxLt: $data["\143\x69\164\171"] = trim($_POST["\143\x69\x74\171"]); goto scmlO; Ydjp_: $data["\x66\141\x73\164\x5f\x6d\x65\x6e\165"] = false; goto Pj0CE; iMEJw: $data["\x75\x69\144"] = $this->uid; goto lXw2g; ShVGg: message("\xe5\234\260\345\235\200\xe9\224\231\xe8\xaf\257", $this->createMobileUrl("\141\144\144\162\145\x73\163"), "\145\x72\162\157\162"); goto ylDg0; ylDg0: BDj1Z: goto YevKq; Uz8K9: IOAAq: goto a31S3; L9gN_: $this->ajaxReturn(102, "\346\xb7\xbb\345\212\xa0\345\244\xb1\350\264\xa5"); goto s3JuF; a31S3: $this->AddressModel->update(["\x69\144" => $id, "\165\x69\x64" => $this->uid], $data); goto Aauom; ZY4n9: $data["\x61\144\x64\x72\145\163\163"] = trim($_POST["\141\144\144\x72\145\x73\x73"]); goto EpcQj; Pj0CE: $id = trim($_GET["\151\144"]); goto spyAr; EpcQj: $data["\160\x72\157\166\151\x6e\143\145"] = trim($_POST["\x70\162\157\x76\151\x6e\143\145"]); goto vgMZ5; hFQqb: $this->assign($data); goto xRMgo; Oa8n3: if ($data["\x64\x65\164\141\x69\x6c"]) { goto BDj1Z; } goto ShVGg; Fu2MJ: } public function del() { goto hWRHZ; ycteW: zdzOE: goto Se2k4; Se2k4: NFHcs: goto KkQi_; FeW58: $this->ajaxReturn(0, ''); goto gq6ag; Hgu_Q: $this->ajaxReturn(102, "\xe5\x88\240\351\x99\244\345\244\261\350\xb4\245"); goto ycteW; Q3DO5: $result = $this->AddressModel->del(["\151\x64" => $id, "\x75\151\x64" => $this->uid]); goto MnJi8; nLKI5: ctSVu: goto Hgu_Q; hWRHZ: $id = trim($_REQUEST["\151\x64"]); goto Hd1Ex; Hd1Ex: if (!$id) { goto NFHcs; } goto Q3DO5; MnJi8: if (!$result) { goto ctSVu; } goto FeW58; gq6ag: goto zdzOE; goto nLKI5; KkQi_: } }