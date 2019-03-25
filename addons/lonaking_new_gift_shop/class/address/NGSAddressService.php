<?php
/*
 __________________________________________________
|  Encode by BajieTeam on we7                      |
|__________________________________________________|
*/

/**
 * Created by PhpStorm.
 * User: leon
 * Date: 16/3/6
 * Time: 上午12:14
 */
require_once dirname(__FILE__) . "\57\x2e\56\x2f\x2e\56\57\56\56\x2f\x6c\x6f\x6e\141\x6b\x69\x6e\147\x5f\146\154\x61\163\150\57\106\154\141\x73\150\103\157\x6d\155\x6f\156\x53\145\x72\x76\x69\x63\145\x2e\160\150\160";
class NGSAddressService extends FlashCommonService
{
    public function __construct()
    {
        goto Q50aO;
        XXDDI:
        $this->columns = "\151\x64\x2c\165\x6e\x69\x61\x63\151\144\x2c\x6e\141\x6d\145\x2c\x6d\157\142\x69\x6c\145\x2c\141\x64\x64\162\145\163\163\x2c\x70\x72\157\x76\x69\x6e\x63\145\54\143\151\164\171\54\141\x72\145\141\x2c\x75\163\x65\x72\x5f\151\x64\54\x6f\x70\145\156\151\144\x2c\162\145\155\141\x72\153\54\143\162\x65\x61\x74\145\137\x74\151\155\x65\54\x75\160\x64\x61\164\x65\137\164\151\x6d\145";
        goto jmjd4;
        g3FXk:
        $this->table_name = "\154\157\x6e\141\x6b\x69\x6e\x67\137\x6e\145\167\137\147\151\146\164\x5f\163\x68\x6f\160\137\141\x64\x64\162\145\x73\163";
        goto XXDDI;
        Q50aO:
        $this->plugin_name = "\x6c\x6f\156\x61\x6b\151\156\x67\137\x6e\x65\x77\x5f\147\x69\x66\164\x5f\x73\x68\157\x70";
        goto g3FXk;
        jmjd4:
    }
    public function getAddressByOpenid($openid = '')
    {
        goto gRbgP;
        c2wRH:
        $address = $this->selectOne("\40\141\156\x64\40\157\160\145\x6e\151\x64\75\47{$openid}\x27");
        goto aLbtA;
        ePRfY:
        $openid = empty($openid) ? $_W["\157\x70\x65\156\151\144"] : $openid;
        goto c2wRH;
        aLbtA:
        return $address;
        goto zHfWs;
        gRbgP:
        global $_W, $_GPC;
        goto ePRfY;
        zHfWs:
    }
}
