<?php
/*
 __________________________________________________
|  Encode by BajieTeam on we7                      |
|__________________________________________________|
*/

/**
 * Created by PhpStorm.
 * User: leon
 * Date: 15/10/17
 * Time: 下午2:29
 */
class FlashHelper
{
    /**
     *
     */
    public static function fetchModelArrayIds($arr, $columns_name = "\151\x64")
    {
        goto eUjR3;
        dAINo:
        return $result;
        goto HK7Ki;
        N1ADh:
        foreach ($arr as $a) {
            $result[] = $a[$columns_name];
            UGE5k:
        }
        goto KO4Im;
        KO4Im:
        VrS1b:
        goto dAINo;
        eUjR3:
        $result = array();
        goto N1ADh;
        HK7Ki:
    }
    public static function fetchColumnArray($arr, $columns_name, $kill_null = false, $kill_repeat = false)
    {
        goto a2OJw;
        QCxOM:
        i2UmH:
        goto b7PYZ;
        KpGqw:
        goto im7O1;
        goto QCxOM;
        a2OJw:
        $result = array();
        goto jqMkB;
        DiF5q:
        im7O1:
        goto ulrA_;
        b7PYZ:
        return array_unique($result);
        goto DiF5q;
        wgyFm:
        ARBlp:
        goto OQcYs;
        jqMkB:
        foreach ($arr as $a) {
            goto rz0QY;
            z7MIv:
            $result[] = $a[$columns_name];
            goto HWc11;
            jnlpQ:
            r9CeD:
            goto VJ354;
            VJ354:
            e3S5K:
            goto VJmPz;
            qaSQH:
            if (empty($a[$columns_name])) {
                goto r9CeD;
            }
            goto blbbb;
            VJmPz:
            HnMHB:
            goto SvhIh;
            HWc11:
            goto e3S5K;
            goto mdQ6h;
            rz0QY:
            if ($kill_null) {
                goto PNkS2;
            }
            goto z7MIv;
            mdQ6h:
            PNkS2:
            goto qaSQH;
            blbbb:
            $result[] = $a[$columns_name];
            goto jnlpQ;
            SvhIh:
        }
        goto wgyFm;
        OQcYs:
        if ($kill_repeat) {
            goto i2UmH;
        }
        goto gh9KA;
        gh9KA:
        return $result;
        goto KpGqw;
        ulrA_:
    }
    public static function array2Map($arr, $key = "\x69\144")
    {
        goto blruP;
        h2VK6:
        foreach ($arr as $data) {
            $result[$data[$key]] = $data;
            xw5rK:
        }
        goto tdi5h;
        tdi5h:
        tp3CS:
        goto x3KQA;
        x3KQA:
        return $result;
        goto eqbbB;
        blruP:
        $result[] = array();
        goto h2VK6;
        eqbbB:
    }
}
