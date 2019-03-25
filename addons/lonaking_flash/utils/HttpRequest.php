<?php
/*
 __________________________________________________
|  Encode by BajieTeam on we7                      |
|__________________________________________________|
*/

class HttpRequest
{
    public static function get($url, $params = array(), $header = '', $timeout = 15)
    {
        goto SnnnW;
        uZT7t:
        j72WM:
        goto JyuRL;
        djUj3:
        return self::uCurl($url, "\107\x45\124", array(), $header, $timeout);
        goto DOaCV;
        BYI2A:
        foreach ($params as $key => $value) {
            goto FXHu2;
            jhUxL:
            aGm2Q:
            goto dYYin;
            DzIKr:
            $url .= "\x26" . $key . "\x3d" . $value;
            goto vf9MB;
            HIzZ6:
            $first = true;
            goto ZwYoQ;
            ZwYoQ:
            gndyF:
            goto ZIoH_;
            vf9MB:
            goto gndyF;
            goto jhUxL;
            ZIoH_:
            AgUh3:
            goto Ee47V;
            FXHu2:
            if ($first == false) {
                goto aGm2Q;
            }
            goto DzIKr;
            dYYin:
            $url .= "\x3f" . $key . "\x3d" . $value;
            goto HIzZ6;
            Ee47V:
        }
        goto uZT7t;
        SnnnW:
        if (empty($params)) {
            goto ZdYD4;
        }
        goto kxIR8;
        kxIR8:
        $first = $normal = strpos($url, "\77");
        goto BYI2A;
        JyuRL:
        ZdYD4:
        goto djUj3;
        DOaCV:
    }
    public static function post($url, $data = array(), $header = '', $timeout = 15)
    {
        return self::uCurl($url, "\x50\117\123\124", $data, $header, $timeout);
    }
    private static function uCurl($url, $method, $params = array(), $header = '', $timeout = 15)
    {
        goto StLIw;
        cHPgo:
        sAhcW:
        goto QpT7Z;
        zdDZH:
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        goto Ld2Uv;
        YEkP2:
        $res = $data;
        goto Q2FRB;
        kh7_8:
        $data = curl_exec($curl);
        goto zdDZH;
        uI1E0:
        Vga7I:
        goto kh7_8;
        l1C6n:
        if ($status == 200) {
            goto eSXQL;
        }
        goto DNBMM;
        LeCWm:
        goto sAhcW;
        goto pRrcY;
        cX9hw:
        $header[] = "\x41\143\143\x65\160\x74\55\114\141\156\x67\x75\x61\x67\145\x3a\40\172\150\55\103\x4e\x3b\161\75\60\56\70";
        goto hkP4U;
        iyJe8:
        eSXQL:
        goto YEkP2;
        c3OlT:
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        goto cZKZw;
        dmK9G:
        curl_setopt($curl, CURLOPT_URL, $url);
        goto Jd_to;
        Q2FRB:
        return $res;
        goto g33A4;
        DNBMM:
        return false;
        goto zsEcc;
        cZKZw:
        if ($header == '') {
            goto GYRK0;
        }
        goto Rcw86;
        I1grk:
        ZyPL8:
        goto uI1E0;
        hkP4U:
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        goto cHPgo;
        QpT7Z:
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
        goto xzWtp;
        Jd_to:
        curl_setopt($curl, CURLOPT_HEADER, false);
        goto OR_Nt;
        StLIw:
        $curl = curl_init();
        goto dmK9G;
        Ld2Uv:
        curl_close($curl);
        goto l1C6n;
        g33A4:
        z6rVU:
        goto clQS7;
        Rcw86:
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        goto LeCWm;
        pRrcY:
        GYRK0:
        goto cX9hw;
        zsEcc:
        goto z6rVU;
        goto iyJe8;
        ZPJ4C:
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        goto c3OlT;
        xzWtp:
        switch ($method) {
            case "\x47\105\x54":
                curl_setopt($curl, CURLOPT_HTTPGET, true);
                goto Vga7I;
            case "\120\x4f\x53\x54":
                goto X7oND;
                ItT_8:
                curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
                goto ODLdn;
                iTW1Y:
                curl_setopt($curl, CURLOPT_NOBODY, true);
                goto ItT_8;
                ODLdn:
                goto Vga7I;
                goto BUynj;
                X7oND:
                curl_setopt($curl, CURLOPT_POST, true);
                goto iTW1Y;
                BUynj:
            case "\120\125\124":
                goto Gnlik;
                Se67H:
                goto Vga7I;
                goto qAw1C;
                pFm5v:
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));
                goto Se67H;
                Gnlik:
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "\120\125\124");
                goto pFm5v;
                qAw1C:
            case "\104\x45\114\105\124\x45":
                goto LDg_z;
                LDg_z:
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "\104\105\114\x45\x54\105");
                goto KlP8i;
                ccN62:
                goto Vga7I;
                goto eLmCW;
                KlP8i:
                curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
                goto ccN62;
                eLmCW:
        }
        goto I1grk;
        OR_Nt:
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        goto ZPJ4C;
        clQS7:
    }
}
