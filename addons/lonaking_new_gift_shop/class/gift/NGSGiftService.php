<?php
/*
 __________________________________________________
|  Encode by BajieTeam on we7                      |
|__________________________________________________|
*/

require_once dirname(__FILE__) . "\57\56\x2e\57\x2e\x2e\x2f\x2e\x2e\57\x6c\x6f\x6e\141\153\151\156\x67\137\x66\154\x61\x73\x68\57\106\x6c\x61\163\x68\x43\157\x6d\x6d\x6f\x6e\123\x65\162\x76\151\x63\145\x2e\x70\x68\160";
class NGSGiftService extends FlashCommonService
{
    const GIFT_TYPE_RED_PACKETS = 1;
    const GIFT_TYPE_VIRTUAL = 2;
    const GIFT_TYPE_SEND = 3;
    const GIFT_TYPE_ZL = 4;
    const GIFT_TYPE_MOBILE_FEE = 5;
    const GIFT_TYPE_MOBILE_LL = 6;
    const GIFT_TYPE_SCORE_RAFFLE = 7;
    const GIFT_AUTO = 1;
    const GIFT_NOT_AUTO = 0;
    const GIFT_RAFFLE = 1;
    const GIFT_NOT_RAFFLE = 0;
    const GIFT_RAFFLE_RANDOM = 2;
    const GIFT_HB_MODE_FIXED_AMOUNT = 1;
    const GIFT_HB_MODE_RANDOM_AMOUNT = 2;
    const GIFT_STATUS_STOP = -1;
    const GIFT_STATUS_SOLD = 1;
    const GIFT_BUY_TYPE_SCORE = 1;
    const GIFT_BUY_TYPE_MONEY = 2;
    const GIFT_BUY_TYPE_SCORE_AND_MONEY = 3;
    const GIFT_VIEW_TYPE_DEFAULT = 1;
    const GIFT_VIEW_TYPE_HENG = 2;
    const GIFT_VIEW_TYPE_DEFAULT_AND_HENG = 3;
    const GIFT_ABNORMAL_OPEN = 1;
    const GIFT_ABNORMAL_CLOSE = 0;
    public function __construct()
    {
        goto CxaV0;
        oFJ0T:
        $this->table_name = "\x6c\157\x6e\141\153\x69\x6e\147\x5f\156\x65\167\x5f\147\151\x66\164\x5f\x73\150\157\160\137\x67\x69\146\x74";
        goto qDr72;
        qDr72:
        $this->columns = "\151\144\54\165\x6e\151\x61\x63\x69\x64\54\164\x79\x70\x65\54\147\162\157\x75\x70\x5f\151\144\x2c\x76\x69\x65\167\137\x74\171\x70\145\54\x61\x75\164\x6f\x2c\156\165\x6d\54\142\x75\x79\137\154\x69\155\151\164\x5f\x64\141\171\54\142\x75\x79\x5f\154\151\155\x69\x74\137\x6e\165\155\54\x62\165\x79\x5f\x6c\151\x6d\x69\164\137\x74\157\164\x61\x6c\x2c\x72\x61\x66\x66\x6c\x65\54\x72\141\146\146\154\145\137\x6d\151\156\x2c\x72\141\x66\146\x6c\x65\x5f\155\141\x78\x2c\162\x61\146\x66\x6c\145\137\x63\x68\x61\156\x63\145\54\162\141\x66\146\154\x65\137\x68\151\164\54\150\151\144\145\x2c\162\145\x64\x75\x63\x65\x5f\164\171\160\x65\x2c\x73\164\141\162\x74\x5f\144\141\x74\145\54\x65\x6e\x64\x5f\x64\x61\x74\x65\x2c\x74\x69\x74\x6c\x65\x2c\x74\x61\147\54\164\141\x67\x5f\143\157\154\157\162\54\x6c\151\x6e\153\137\x70\x68\x6f\156\x65\54\154\151\x6e\x6b\x5f\x61\144\x64\162\145\163\163\x2c\165\156\144\145\x6c\x69\x76\x65\162\x65\x64\x5f\x64\x65\163\143\x2c\163\x75\163\160\145\156\163\145\137\x64\145\163\x63\54\142\165\171\137\x74\x69\x70\54\x64\145\x73\143\162\x69\x70\x74\151\x6f\156\54\x67\x75\151\x64\x65\154\x69\x6e\x65\x73\54\144\145\x74\141\151\154\x5f\x69\155\141\147\x65\54\164\x68\165\155\x62\x6e\x61\x69\154\54\151\x63\157\156\x2c\142\x61\x6e\x6e\x65\x72\54\x6d\x61\162\x6b\x65\x74\137\160\162\x69\143\145\x2c\x62\165\171\x5f\164\171\160\x65\x2c\x73\x63\x6f\x72\x65\x2c\155\x6f\x6e\145\x79\x2c\x74\162\x61\x6e\163\137\x66\145\x65\137\160\141\x79\x5f\167\x61\171\x2c\x74\x72\141\156\x73\x5f\x66\x65\x65\x2c\162\141\x6e\x6b\54\150\142\137\x61\155\x6f\165\156\164\x2c\150\142\x5f\x6d\x6f\x64\145\x2c\150\x62\137\162\141\x6e\x64\157\155\x5f\155\x69\x6e\54\x68\x62\x5f\162\x61\156\144\157\155\137\155\141\170\54\x68\x66\137\x61\x6d\157\x75\x6e\x74\54\154\x6c\x5f\141\x6d\x6f\165\156\x74\x2c\x72\x61\x66\146\x6c\145\x5f\163\143\157\162\x65\x5f\141\155\x6f\x75\x6e\x74\x2c\x76\x61\x6c\x69\x64\x5f\x64\x61\x74\x65\x5f\164\x79\160\145\54\166\x61\x6c\x69\144\137\x64\x61\164\x65\x5f\141\x66\x74\x65\162\137\x64\141\x79\163\x2c\166\141\x6c\x69\x64\141\164\x65\x5f\163\x74\141\162\164\x5f\x64\141\164\x65\54\x76\x61\154\x69\144\x61\164\145\x5f\x65\156\144\x5f\144\141\164\145\x2c\x73\x75\143\143\x65\x73\x73\x5f\x72\x65\144\151\162\145\x63\164\54\154\141\x74\54\154\x6e\x67\x2c\x72\141\x64\x69\x75\x73\54\141\x62\156\157\162\155\x61\154\x5f\x72\141\x6e\153\54\155\x63\x5f\147\x72\x6f\x75\160\x5f\154\151\x6d\x69\x74\54\155\x63\x5f\147\x72\x6f\165\160\x2c\144\x69\x73\x74\x72\151\x62\x75\164\x65\137\x73\143\x6f\x72\x65\54\144\x69\x73\x74\x72\151\142\165\164\145\137\x61\x6d\157\165\156\164\54\x73\x68\141\x72\x65\137\x73\143\x6f\162\145\54\x73\150\x61\162\145\x5f\x61\x6d\157\165\x6e\x74\54\162\x65\167\x61\x72\144\137\163\x63\157\162\x65\54\x72\145\x77\x61\162\x64\x5f\x61\x6d\x6f\x75\x6e\x74\54\163\x74\x61\164\x75\x73\x2c\x63\x72\145\141\164\145\137\164\151\155\145\54\165\160\x64\x61\164\x65\x5f\164\151\x6d\x65\x2c\x6d\x6f\156\x65\x79\137\x74\x6f\137\x73\143\157\162\x65\137\146\154\141\x67\54\x6d\x6f\x6e\145\171\137\164\157\x5f\163\x63\157\162\145";
        goto eLff8;
        CxaV0:
        $this->plugin_name = "\154\157\156\141\x6b\x69\156\147\137\x6e\x65\167\137\x67\x69\146\164\x5f\163\x68\x6f\x70";
        goto oFJ0T;
        eLff8:
    }
    public function selectAllQuan()
    {
        return $this->selectAll("\40\x61\156\x64\x20\164\171\x70\145\75\62");
    }
    public function reduceOneGift($giftId)
    {
        $this->columnReduceCount("\156\x75\x6d", 1, $giftId);
    }
    public function pricing($gift, $userScore = 0)
    {
        goto AS6v4;
        iQIpJ:
        goto PlCIS;
        goto afr42;
        I_PF4:
        goto ESLFQ;
        goto OQHca;
        NAQmI:
        goto PlCIS;
        goto HhPxJ;
        Tl12A:
        $result["\155\157\x6e\x65\171"] = 0;
        goto iQIpJ;
        N8TqS:
        $result["\x73\143\x6f\162\145"] = 0;
        goto NAQmI;
        bUc_p:
        if ($result["\x73\143\157\x72\x65"] > 0) {
            goto Ef8sR;
        }
        goto RR_ZM;
        g8w2L:
        lGcPR:
        goto T8lIS;
        MlXZy:
        $result["\163\x63\x6f\x72\145"] = $gift["\x73\143\157\162\145"];
        goto Tl12A;
        HhPxJ:
        f1MqF:
        goto D4dZ5;
        Y38Ki:
        Ef8sR:
        goto ClZLQ;
        C5Vsi:
        cUJ3o:
        goto MlXZy;
        VH0Og:
        PlCIS:
        goto ucFqp;
        ulq_g:
        goto PlCIS;
        goto C5Vsi;
        JgJmL:
        if ($gift["\x62\165\x79\x5f\x74\x79\x70\x65"] == 2) {
            goto JNDr3;
        }
        goto eAmnB;
        qpkpB:
        if ($gift["\x62\165\x79\x5f\x74\x79\x70\145"] == 1) {
            goto cUJ3o;
        }
        goto JgJmL;
        Cfsvn:
        aLjW9:
        goto waH8N;
        sbbig:
        $result["\155\x6f\156\x65\x79"] = round($result["\x6d\x6f\x6e\x65\x79"], 2);
        goto Sm9I2;
        opvoW:
        $money = $scoreCha / $gift["\155\157\x6e\x65\171\x5f\x74\157\x5f\163\x63\x6f\x72\x65"];
        goto cAWu3;
        cAWu3:
        $result["\x73\x63\x6f\162\145"] = $userScore;
        goto Mevi1;
        waH8N:
        goto UhMQn;
        goto g8w2L;
        D4dZ5:
        $result["\x73\x63\x6f\x72\x65"] = $gift["\163\x63\157\x72\145"];
        goto RtmFM;
        RR_ZM:
        goto aLjW9;
        goto Y38Ki;
        ucFqp:
        if (!$gift["\155\157\156\x65\x79\x5f\x74\x6f\137\x73\x63\x6f\x72\x65\x5f\146\x6c\x61\x67"] || $gift["\x6d\157\x6e\x65\171\137\164\x6f\137\163\143\x6f\x72\145"] <= 0) {
            goto lGcPR;
        }
        goto bUc_p;
        OQHca:
        SMIpI:
        goto yTno5;
        Sm9I2:
        return $result;
        goto gWhkb;
        yTno5:
        $scoreCha = $result["\163\x63\x6f\x72\x65"] - $userScore;
        goto opvoW;
        RtmFM:
        $result["\155\157\156\145\x79"] = $gift["\x6d\157\156\145\171"];
        goto VH0Og;
        T8lIS:
        return $result;
        goto zc1LF;
        eAmnB:
        if ($gift["\142\x75\x79\137\164\x79\160\145"] == 3) {
            goto f1MqF;
        }
        goto ulq_g;
        Mevi1:
        $result["\x6d\157\156\145\171"] = $result["\155\x6f\x6e\x65\x79"] + $money;
        goto jqXMf;
        jqXMf:
        ESLFQ:
        goto Cfsvn;
        CN8wY:
        $result["\155\x6f\156\145\x79"] = $gift["\155\x6f\156\x65\171"];
        goto N8TqS;
        zc1LF:
        UhMQn:
        goto sbbig;
        ClZLQ:
        if ($userScore < $result["\163\143\x6f\x72\145"]) {
            goto SMIpI;
        }
        goto I_PF4;
        AS6v4:
        $result = array("\163\x63\157\162\x65" => 0, "\x6d\157\156\145\x79" => 0);
        goto qpkpB;
        afr42:
        JNDr3:
        goto CN8wY;
        gWhkb:
    }
}
