<?php
/*
 __________________________________________________
|  Encode by BajieTeam on we7                      |
|__________________________________________________|
*/

/**
 * 本代码出自一位前辈之手，由于作者被封，无法与其取得联系，如有侵权，请联系本人 QQ 1214512299
 */
class MD5SignUtil
{
    function sign($content, $key)
    {
        try {
            goto Vatif;
            k18cA:
            py_qx:
            goto It2IN;
            It2IN:
            if (!(null == $content)) {
                goto CrZ9T;
            }
            goto cuYrG;
            fhDC3:
            throw new SDKRuntimeException("\xe5\257\x86\351\222\245\344\270\x8d\xe8\203\275\344\xb8\xba\xe7\251\xba\357\274\201" . "\x3c\142\162\x3e");
            goto k18cA;
            Tirw1:
            $signStr = $content . "\x26\153\145\171\75" . $key;
            goto L1Ntc;
            HGkmd:
            CrZ9T:
            goto Tirw1;
            L1Ntc:
            return strtoupper(md5($signStr));
            goto kq1sj;
            Vatif:
            if (!(null == $key)) {
                goto py_qx;
            }
            goto fhDC3;
            cuYrG:
            throw new SDKRuntimeException("\347\xad\276\xe5\x90\x8d\345\x86\205\xe5\xae\271\344\270\215\350\203\xbd\xe4\270\272\xe7\xa9\272" . "\74\142\162\x3e");
            goto HGkmd;
            kq1sj:
        } catch (SDKRuntimeException $e) {
            die($e->errorMessage());
        }
    }
    function verifySignature($content, $sign, $md5Key)
    {
        goto TkKTy;
        TkKTy:
        $signStr = $content . "\x26\153\145\x79\75" . $md5Key;
        goto KKvAl;
        KKvAl:
        $calculateSign = strtolower(md5($signStr));
        goto H3iEe;
        H3iEe:
        $tenpaySign = strtolower($sign);
        goto oJzK2;
        oJzK2:
        return $calculateSign == $tenpaySign;
        goto lN5fo;
        lN5fo:
    }
}
?>
