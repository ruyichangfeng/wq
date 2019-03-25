<?php
/*
 __________________________________________________
|  Encode by BajieTeam on we7                      |
|__________________________________________________|
*/

class HttpJsonRequest
{
    public static function get($url, $params = array(), $header = '')
    {
        goto q3XPd;
        q3XPd:
        if (empty($params)) {
            goto S3_V5;
        }
        goto ebub4;
        qthfS:
        return self::uCurl($url, "\x47\105\124", array(), $header);
        goto cgvA4;
        ebub4:
        $first = $normal = strpos($url, "\77");
        goto HG8Dw;
        HG8Dw:
        foreach ($params as $key => $value) {
            goto mpKWR;
            QJHPB:
            $url .= "\77" . $key . "\x3d" . $value;
            goto o2NOn;
            HbhMU:
            YKNDS:
            goto QJHPB;
            o2NOn:
            $first = true;
            goto T6cep;
            T6cep:
            BTfb3:
            goto DHqKI;
            j1PIc:
            $url .= "\46" . $key . "\75" . $value;
            goto ueXs1;
            DHqKI:
            OnjLs:
            goto c7nRF;
            mpKWR:
            if ($first == false) {
                goto YKNDS;
            }
            goto j1PIc;
            ueXs1:
            goto BTfb3;
            goto HbhMU;
            c7nRF:
        }
        goto oKelN;
        oKelN:
        VA1LR:
        goto HZxLK;
        HZxLK:
        S3_V5:
        goto qthfS;
        cgvA4:
    }
    public static function post($url, $data = array(), $header = '')
    {
        return self::uCurl($url, "\120\117\123\x54", $data, $header);
    }
    private static function uCurl($url, $method, $params = array(), $header = '')
    {
        goto HcPJh;
        UtmEu:
        goto Xumxx;
        goto reOQm;
        Lluv1:
        Tw6W8:
        goto uMfWk;
        SEKby:
        $timeout = 15;
        goto KUCtP;
        SWzIO:
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        goto OQ6xP;
        Frj9Y:
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
        goto MAdDH;
        b2rlN:
        XMpEw:
        goto Frj9Y;
        jAwCQ:
        $data = curl_exec($curl);
        goto Y_Vkb;
        MAdDH:
        switch ($method) {
            case "\x47\105\124":
                curl_setopt($curl, CURLOPT_HTTPGET, true);
                goto L7pH7;
            case "\x50\x4f\123\x54":
                goto jLkFp;
                sEu5E:
                curl_setopt($curl, CURLOPT_NOBODY, true);
                goto HWEvZ;
                jLkFp:
                curl_setopt($curl, CURLOPT_POST, true);
                goto sEu5E;
                HWEvZ:
                curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
                goto YtJDr;
                YtJDr:
                goto L7pH7;
                goto kdVTy;
                kdVTy:
            case "\x50\x55\x54":
                goto fWBKJ;
                yXWYr:
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));
                goto y596A;
                y596A:
                goto L7pH7;
                goto AKH8Z;
                fWBKJ:
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "\120\x55\x54");
                goto yXWYr;
                AKH8Z:
            case "\104\x45\114\x45\x54\x45":
                goto c1XY1;
                iZWSJ:
                curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
                goto gpaHX;
                gpaHX:
                goto L7pH7;
                goto N_1Lg;
                c1XY1:
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "\x44\x45\114\105\x54\105");
                goto iZWSJ;
                N_1Lg:
        }
        goto ZqRGG;
        lcg_8:
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        goto b2rlN;
        ZqRGG:
        dvMEv:
        goto S3RF3;
        cTSOJ:
        goto XMpEw;
        goto Lluv1;
        OQ6xP:
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        goto pdCsr;
        b6FTW:
        curl_close($curl);
        goto dz3M0;
        reOQm:
        xvCzQ:
        goto kg5bu;
        dhckN:
        return false;
        goto UtmEu;
        KTsmn:
        return $res;
        goto R7qRv;
        Y_Vkb:
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        goto b6FTW;
        B_FJz:
        curl_setopt($curl, CURLOPT_HEADER, false);
        goto huf1T;
        R7qRv:
        Xumxx:
        goto hjMe7;
        pdCsr:
        if ($header == '') {
            goto Tw6W8;
        }
        goto XbhsV;
        dz3M0:
        if ($status == 200) {
            goto xvCzQ;
        }
        goto dhckN;
        KUCtP:
        curl_setopt($curl, CURLOPT_URL, $url);
        goto B_FJz;
        huf1T:
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        goto SWzIO;
        S3RF3:
        L7pH7:
        goto jAwCQ;
        uMfWk:
        $header[] = "\x41\143\143\145\x70\x74\55\x4c\x61\156\147\165\141\147\x65\72\40\x7a\150\55\x43\116\x3b\161\x3d\x30\x2e\x38";
        goto lcg_8;
        kg5bu:
        $res = json_decode($data, true);
        goto KTsmn;
        HcPJh:
        $curl = curl_init();
        goto SEKby;
        XbhsV:
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        goto cTSOJ;
        hjMe7:
    }
}
