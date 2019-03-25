<?php
/*
 __________________________________________________
|  Encode by BajieTeam on we7                      |
|__________________________________________________|
*/

/**
 * Created by PhpStorm.
 * User: leon
 * Date: 16/3/23
 * Time: 下午3:08
 */
require_once dirname(__FILE__) . "\57\x2e\x2e\x2f\56\x2e\57\x2e\x2e\57\154\x6f\x6e\x61\x6b\x69\x6e\147\137\146\154\141\x73\x68\57\x46\x6c\x61\x73\x68\103\x6f\x6d\155\x6f\156\123\145\162\166\151\x63\x65\x2e\x70\150\160";
class NGSMaxSceneService extends FlashCommonService
{
    public function __construct()
    {
        goto FkM2a;
        FkM2a:
        $this->plugin_name = "\154\157\156\x61\153\151\x6e\x67\137\156\145\167\x5f\x67\151\146\164\137\163\x68\x6f\x70";
        goto VCFlj;
        KIXx0:
        $this->columns = "\151\x64\54\x75\156\151\x61\143\151\x64\x2c\x6d\141\x78\137\x73\143\x65\156\x65\x5f\151\144\x2c\x63\162\145\141\x74\x65\x5f\x74\x69\155\x65\x2c\165\160\144\x61\x74\x65\x5f\x74\x69\x6d\x65";
        goto vGHF_;
        VCFlj:
        $this->table_name = "\154\x6f\156\141\153\x69\x6e\x67\137\156\145\167\137\147\151\146\x74\x5f\x73\x68\157\x70\x5f\x6d\141\170\137\x73\x63\145\156\x65";
        goto KIXx0;
        vGHF_:
    }
    public function generateOneInviteCode($uniacid)
    {
        goto I3W38;
        EoIN6:
        $one["\x6d\x61\170\x5f\x73\x63\145\156\x65\137\151\x64"] = $one["\x6d\x61\170\137\x73\143\145\156\145\137\x69\144"] + 1;
        goto y2i8p;
        Ru3Q5:
        k9iEz:
        goto GfdLa;
        D_uGW:
        z3syN:
        goto Z5puA;
        y2i8p:
        $this->updateData($one);
        goto JHfB3;
        eaClI:
        $this->insertData($one);
        goto bHAk1;
        I3W38:
        $one = $this->selectOne();
        goto MMJE2;
        bHAk1:
        return 1;
        goto D_uGW;
        GfdLa:
        $one = array("\165\156\151\x61\x63\x69\144" => $uniacid, "\x6d\x61\x78\x5f\x73\x63\x65\156\145\137\151\x64" => 1, "\143\x72\145\x61\x74\145\137\x74\151\x6d\x65" => time(), "\165\160\144\141\x74\145\137\164\151\x6d\x65" => time());
        goto eaClI;
        JHfB3:
        return $code;
        goto KO19n;
        KO19n:
        goto z3syN;
        goto Ru3Q5;
        MMJE2:
        if ($one == false) {
            goto k9iEz;
        }
        goto CWnrg;
        CWnrg:
        $code = $one["\x6d\141\x78\137\163\143\x65\156\x65\x5f\x69\x64"];
        goto EoIN6;
        Z5puA:
    }
}
