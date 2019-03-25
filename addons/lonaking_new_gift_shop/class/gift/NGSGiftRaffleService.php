<?php
/*
 __________________________________________________
|  Encode by BajieTeam on we7                      |
|__________________________________________________|
*/

require_once dirname(__FILE__) . "\57\x2e\56\57\x2e\56\57\x2e\x2e\57\154\x6f\x6e\141\x6b\x69\156\147\137\x66\x6c\x61\163\x68\x2f\x46\x6c\141\x73\x68\x43\x6f\x6d\155\157\156\x53\145\162\x76\x69\143\145\56\160\150\160";
class NGSGiftRaffleService extends FlashCommonService
{
    public function __construct()
    {
        goto g9iv2;
        BxioG:
        $this->columns = "\x69\144\x2c\165\x6e\x69\141\x63\x69\x64\x2c\147\151\x66\164\x5f\151\144\54\x74\151\x6d\145\x2c\x63\162\x65\141\x74\145\x5f\164\151\x6d\145\x2c\165\x70\x64\x61\x74\x65\137\164\x69\155\x65";
        goto idPGr;
        g9iv2:
        $this->plugin_name = "\154\157\156\141\x6b\x69\156\x67\x5f\x6e\145\167\x5f\147\x69\x66\x74\137\x73\x68\x6f\x70";
        goto cz1DF;
        cz1DF:
        $this->table_name = "\154\x6f\x6e\141\x6b\151\x6e\147\137\156\x65\167\137\147\151\x66\x74\137\163\150\x6f\160\137\x67\151\146\x74\137\162\x61\x66\146\x6c\145";
        goto BxioG;
        idPGr:
    }
    public function raffleGo($gift_id)
    {
        goto ArAgs;
        QqRbN:
        return $raffle["\x74\151\x6d\145"];
        goto KnKbr;
        tDTxR:
        $raffle = $this->init($gift_id);
        goto QqRbN;
        sJlnj:
        return $raffle["\164\x69\x6d\145"];
        goto okldO;
        BqqgG:
        $this->columnAddCount("\x74\151\155\145", 1, $raffle["\151\144"]);
        goto sJlnj;
        Iyo_d:
        $raffle["\164\x69\x6d\145"] = $raffle["\164\x69\x6d\145"] + 1;
        goto BqqgG;
        ArAgs:
        $raffle = $this->selectOne("\x20\141\156\144\x20\147\151\x66\x74\137\x69\144\75{$gift_id}");
        goto zR7yl;
        zR7yl:
        if (!empty($raffle)) {
            goto TkEUT;
        }
        goto tDTxR;
        KnKbr:
        TkEUT:
        goto Iyo_d;
        okldO:
    }
    private function init($gift_id)
    {
        goto sgR_Q;
        dqXQ6:
        return $raffle;
        goto DBsSR;
        dyV1z:
        $raffle = array("\x75\156\x69\141\143\x69\x64" => $_W["\165\x6e\151\141\143\151\x64"], "\147\x69\146\x74\x5f\x69\144" => $gift_id, "\x74\x69\155\x65" => 1, "\x63\162\x65\141\x74\145\137\x74\151\x6d\x65" => time(), "\165\160\x64\x61\x74\x65\137\x74\x69\x6d\x65" => time());
        goto fg8zT;
        sgR_Q:
        global $_W;
        goto dyV1z;
        fg8zT:
        $raffle = $this->insertData($raffle);
        goto dqXQ6;
        DBsSR:
    }
}
