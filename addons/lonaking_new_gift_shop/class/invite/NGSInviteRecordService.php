<?php
/*
 __________________________________________________
|  Encode by BajieTeam on we7                      |
|__________________________________________________|
*/

require_once dirname(__FILE__) . "\x2f\x2e\56\x2f\56\x2e\x2f\x2e\x2e\x2f\154\x6f\x6e\141\x6b\151\x6e\147\137\146\x6c\x61\163\150\x2f\106\x6c\x61\x73\150\103\x6f\x6d\x6d\x6f\156\123\145\x72\x76\x69\143\x65\x2e\x70\x68\x70";
class NGSInviteRecordService extends FlashCommonService
{
    const STATUS_SUBSCRIBE = 1;
    const STATUS_UNSUBSCRIBE = 2;
    const SCORE_MONEY_RESULT_NOT_FINISHED = 0;
    const SCORE_MONEY_RESULT_FINISHED = 1;
    public function __construct()
    {
        goto NFKiB;
        bIsOA:
        $this->table_name = "\x6c\157\156\x61\153\151\x6e\147\x5f\156\145\167\137\x67\151\x66\x74\x5f\163\150\157\160\137\151\x6e\x76\x69\164\145\x5f\162\145\x63\157\x72\144";
        goto VHYrm;
        VHYrm:
        $this->columns = "\151\x64\x2c\165\x6e\x69\x61\143\x69\x64\54\x75\x73\145\162\137\151\144\x2c\165\151\144\x2c\x6f\160\145\156\x69\x64\x2c\x6e\151\143\x6b\x6e\x61\155\145\x2c\x69\156\166\x69\164\x65\137\x75\163\x65\162\x5f\151\x64\x2c\151\x6e\166\x69\x74\x65\137\x75\x69\144\x2c\151\x6e\166\x69\x74\x65\x5f\x6f\x70\145\x6e\151\x64\54\151\156\166\151\x74\x65\x5f\x6e\x69\143\153\156\141\155\145\x2c\163\143\x6f\x72\x65\x2c\155\157\x6e\x65\x79\54\163\x74\141\164\x75\163\x2c\154\145\166\x65\x6c\54\163\143\x6f\162\145\137\x72\145\163\165\154\164\54\155\x6f\156\145\x79\137\x72\x65\163\165\154\x74\54\x63\162\145\141\x74\145\x5f\164\151\x6d\145\54\x75\x70\x64\141\164\145\137\164\x69\155\145";
        goto EwwsH;
        NFKiB:
        $this->plugin_name = "\x6c\157\x6e\141\x6b\151\x6e\147\137\156\x65\167\x5f\x67\x69\146\164\x5f\163\x68\x6f\x70";
        goto bIsOA;
        EwwsH:
    }
    public function createSubscribeRecord($user, $inviteUser, $level, $uniacid)
    {
        return $this->create($user, $inviteUser, NGSInviteRecordService::STATUS_SUBSCRIBE, $level, $uniacid);
    }
    public function createUnSubscribeRecord($user, $inviteUser, $level, $uniacid)
    {
        return $this->create($user, $inviteUser, NGSInviteRecordService::STATUS_UNSUBSCRIBE, $level, $uniacid);
    }
    private function create($user, $inviteUser, $status, $level, $uniacid)
    {
        $invite_record = $this->insertData(array("\x75\156\151\x61\x63\x69\144" => $uniacid, "\165\163\x65\x72\x5f\151\144" => $user["\151\x64"], "\x75\151\x64" => $user["\x75\x69\144"], "\157\160\x65\x6e\151\x64" => $user["\x6f\160\145\x6e\x69\144"], "\156\151\x63\x6b\x6e\x61\155\145" => $user["\x6e\x69\x63\153\x6e\141\155\145"], "\x69\156\x76\x69\164\145\x5f\165\163\145\x72\137\x69\144" => $inviteUser["\x69\144"], "\151\156\x76\x69\164\145\137\165\x69\x64" => $inviteUser["\x75\x69\x64"], "\x69\x6e\x76\151\164\145\137\157\160\145\x6e\x69\x64" => $inviteUser["\157\160\x65\156\151\144"], "\x69\x6e\166\151\x74\145\x5f\x6e\151\143\x6b\x6e\x61\155\x65" => $inviteUser["\x6e\x69\143\153\156\141\155\145"], "\x73\143\x6f\x72\145" => 0, "\x6d\157\x6e\x65\x79" => 0, "\163\164\141\x74\x75\x73" => $status, "\x63\x72\145\x61\x74\x65\137\x74\x69\x6d\x65" => time(), "\x75\x70\144\x61\164\x65\137\x74\151\x6d\145" => time(), "\154\145\x76\145\154" => $level, "\163\143\157\162\x65\x5f\x72\145\x73\x75\x6c\164" => NGSInviteRecordService::SCORE_MONEY_RESULT_NOT_FINISHED, "\x6d\157\x6e\x65\x79\137\x72\145\x73\x75\154\x74" => NGSInviteRecordService::SCORE_MONEY_RESULT_NOT_FINISHED));
        return $invite_record;
    }
    public function scoreStart($invite_record, $score)
    {
        goto InWy8;
        h2Af6:
        $invite_record["\x75\160\x64\x61\x74\145\x5f\164\151\155\145"] = time();
        goto UCGbU;
        HDzFM:
        return $invite_record;
        goto sX3Ss;
        InWy8:
        $invite_record["\x73\143\157\162\145"] = $score;
        goto h2Af6;
        UCGbU:
        $invite_record = $this->updateData($invite_record);
        goto HDzFM;
        sX3Ss:
    }
    public function moneyStart($invite_record, $money)
    {
        goto fV1Y7;
        UP0Ai:
        $invite_record = $this->updateData($invite_record);
        goto L7ovw;
        L7ovw:
        return $invite_record;
        goto EFzvv;
        q9KHG:
        $invite_record["\165\160\144\x61\x74\145\x5f\164\x69\155\x65"] = time();
        goto UP0Ai;
        fV1Y7:
        $invite_record["\155\157\156\x65\171"] = $money;
        goto q9KHG;
        EFzvv:
    }
    public function scoreMoneyStart($invite_record, $score, $money)
    {
        goto I2Kso;
        LtQjP:
        return $invite_record;
        goto nL6OT;
        qJx10:
        $invite_record["\165\160\144\x61\164\145\x5f\164\151\155\x65"] = time();
        goto LcJ5O;
        I2Kso:
        $invite_record["\x73\143\x6f\162\x65"] = $score;
        goto blqEL;
        blqEL:
        $invite_record["\155\157\x6e\145\x79"] = $money;
        goto qJx10;
        LcJ5O:
        $invite_record = $this->updateData($invite_record);
        goto LtQjP;
        nL6OT:
    }
    public function scoreSuccess($invite_record)
    {
        goto bkT42;
        b3bg2:
        $invite_record["\165\160\x64\141\x74\145\137\x74\151\155\145"] = time();
        goto VWdxU;
        VWdxU:
        $invite_record = $this->updateData($invite_record);
        goto XtSaO;
        bkT42:
        $invite_record["\x73\x63\157\x72\145\137\x72\145\x73\165\154\x74"] = NGSInviteRecordService::SCORE_MONEY_RESULT_FINISHED;
        goto b3bg2;
        XtSaO:
        return $invite_record;
        goto SwMY9;
        SwMY9:
    }
    public function moneySuccess($invite_record)
    {
        goto aAPhI;
        VZgG4:
        $invite_record["\x75\160\x64\x61\164\x65\x5f\164\151\155\x65"] = time();
        goto q_fyL;
        q_fyL:
        $invite_record = $this->updateData($invite_record);
        goto UccJL;
        UccJL:
        return $invite_record;
        goto HrRRX;
        aAPhI:
        $invite_record["\x6d\x6f\156\145\x79\x5f\x72\145\163\165\154\164"] = NGSInviteRecordService::SCORE_MONEY_RESULT_FINISHED;
        goto VZgG4;
        HrRRX:
    }
}
