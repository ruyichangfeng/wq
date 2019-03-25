<?php
/*
 __________________________________________________
|  Encode by BajieTeam on we7                      |
|__________________________________________________|
*/

goto N3qrx;
vaYsa:
require_once dirname(__FILE__) . "\57\x2e\56\57\56\56\x2f\x2e\x2e\x2f\x6c\157\x6e\x61\x6b\x69\x6e\147\x5f\x66\154\141\163\150\x2f\x46\154\141\163\150\110\x42\x53\145\x72\166\151\x63\x65\56\x70\x68\160";
goto gfXzm;
N3qrx:
require_once dirname(__FILE__) . "\x2f\56\56\x2f\56\x2e\57\56\x2e\57\154\157\156\141\x6b\x69\x6e\147\x5f\x66\x6c\x61\163\x68\x2f\x46\x6c\x61\163\150\x43\x6f\155\x6d\x6f\156\x53\x65\x72\x76\151\143\x65\56\x70\150\160";
goto vaYsa;
gfXzm:
require_once dirname(__FILE__) . "\x2f\56\x2e\x2f\56\x2e\x2f\56\x2e\x2f\154\x6f\x6e\141\x6b\x69\x6e\147\x5f\x66\154\x61\163\x68\x2f\160\x61\x79\x2f\106\x6c\141\x73\150\110\x6f\x6e\147\x42\141\157\105\170\143\x65\160\164\x69\157\156\x2e\x70\x68\160";
goto cD_hf;
cD_hf:
class NGSHbService extends FlashCommonService
{
    const MODE_DEFAULT = 0;
    const MODE_BORROW_OAUTH = 1;
    public function __construct()
    {
        goto AOxjg;
        AmAPr:
        $this->table_name = "\x6c\157\156\x61\x6b\x69\156\x67\137\156\145\167\x5f\x67\x69\x66\x74\x5f\x73\x68\157\160\137\x68\142\137\x63\157\x6e\x66\x69\147";
        goto iN2VL;
        iN2VL:
        $this->columns = "\151\144\54\165\156\x69\x61\143\151\144\x2c\155\x6f\144\145\x2c\141\160\160\x69\x64\x2c\x6d\x63\150\151\144\x2c\160\141\x73\163\x6b\145\171\x2c\x6e\151\143\153\x5f\x6e\x61\155\145\54\163\x65\x6e\x64\137\156\141\x6d\145\54\x77\151\163\150\151\156\x67\x2c\141\x63\164\137\156\x61\155\x65\54\162\x65\155\141\162\x6b\x2c\143\x6c\x69\145\x6e\164\x5f\x69\160\x2c\141\x70\x69\143\154\151\145\x6e\x74\137\x63\x65\162\x74\x2c\x61\x70\151\x63\154\151\x65\x6e\164\x5f\143\145\x72\x74\x5f\143\157\156\164\x65\x6e\164\54\x61\160\x69\143\154\151\x65\x6e\164\137\153\x65\x79\54\141\x70\151\x63\154\151\x65\156\164\x5f\x6b\x65\x79\x5f\143\157\x6e\164\145\x6e\164\54\x72\157\x6f\164\x63\x61\x2c\x72\157\x6f\x74\x63\141\x5f\143\x6f\156\164\145\156\x74\x2c\143\x72\145\x61\x74\x65\137\x74\x69\x6d\x65\x2c\x75\x70\144\141\x74\x65\x5f\164\151\155\x65";
        goto OF7hS;
        AOxjg:
        $this->plugin_name = "\154\157\156\x61\x6b\151\x6e\x67\137\x6e\x65\167\x5f\x67\151\146\164\x5f\x73\150\x6f\160";
        goto AmAPr;
        OF7hS:
    }
    public function send($openid, $money)
    {
        goto fsvUQ;
        APtMu:
        try {
            $HBService->send();
        } catch (FlashHongBaoException $e) {
            $this->log($e->getMessage(), "\xe7\xba\xa2\xe5\214\x85\345\x8f\x91\346\224\276\xe5\xa4\261\xe8\xb4\245\345\216\x9f\345\x9b\240");
            throw new Exception($e->getErrorMessage(), $e->getErrorCode());
        }
        goto C_lQA;
        fsvUQ:
        $config = $this->selectOne();
        goto lE_wr;
        lE_wr:
        $HBService = new FlashHBService($openid, $money, $config);
        goto APtMu;
        C_lQA:
    }
    public function getHbConfig($uniacid)
    {
        goto n5s12;
        n5s12:
        $config = $this->selectOne();
        goto Iaom8;
        KiNHr:
        return $this->selectOne();
        goto D_E4r;
        URmHN:
        F_kdA:
        goto KiNHr;
        Y4pWh:
        $this->insertData($arr);
        goto URmHN;
        VpP37:
        $arr = array("\x75\x6e\151\141\143\151\144" => $uniacid);
        goto Y4pWh;
        Iaom8:
        if (!empty($config)) {
            goto F_kdA;
        }
        goto VpP37;
        D_E4r:
    }
}
