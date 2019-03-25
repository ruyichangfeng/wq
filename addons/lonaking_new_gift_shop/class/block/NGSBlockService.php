<?php
/*
 __________________________________________________
|  Encode by BajieTeam on we7                      |
|__________________________________________________|
*/

require_once dirname(__FILE__) . "\x2f\56\56\x2f\56\56\57\x2e\56\x2f\x6c\157\156\x61\153\151\156\147\x5f\x66\x6c\141\163\x68\x2f\106\154\141\x73\x68\103\x6f\x6d\x6d\x6f\x6e\123\x65\162\x76\x69\x63\145\x2e\160\150\160";
class NGSBlockService extends FlashCommonService
{
    public function __construct()
    {
        goto l4kpy;
        pxvhJ:
        $this->columns = "\151\x64\54\165\x6e\151\141\x63\x69\x64\x2c\157\x70\145\x6e\151\x64\x2c\x6d\x73\x67\151\x64\54\x63\x72\145\141\x74\145\164\151\x6d\x65\54\x73\x74\x61\x74\x75\163\54\x63\162\x65\141\164\145\x5f\164\x69\x6d\145\54\x75\160\144\141\x74\145\x5f\x74\x69\155\145";
        goto IgOXj;
        l4kpy:
        $this->plugin_name = "\x6c\x6f\x6e\141\153\151\156\x67\137\156\145\x77\137\x67\x69\x66\x74\137\163\150\157\160";
        goto cFVel;
        cFVel:
        $this->table_name = "\154\157\156\141\x6b\x69\156\x67\137\x6e\x65\x77\x5f\x67\151\x66\164\x5f\163\150\x6f\160\x5f\142\154\157\x63\x6b";
        goto pxvhJ;
        IgOXj:
    }
    private function initReceiverBlock($openid, $createtime)
    {
        goto c2L1X;
        ZtDmX:
        $arr = array("\165\156\x69\141\x63\x69\x64" => $_W["\x75\x6e\x69\x61\x63\151\144"], "\157\160\x65\x6e\x69\144" => $openid, "\x63\162\x65\141\x74\x65\x74\x69\x6d\145" => $createtime, "\163\x74\x61\164\165\163" => 1, "\143\162\145\141\164\x65\137\164\x69\155\145" => time(), "\x75\160\x64\x61\x74\145\137\x74\x69\x6d\145" => time());
        goto wB4sq;
        c2L1X:
        global $_W;
        goto ZtDmX;
        wB4sq:
        return $this->insertData($arr);
        goto cH3fO;
        cH3fO:
    }
    public function block($openid, $createtime)
    {
        goto mrTck;
        mrTck:
        $block = $this->selectOne("\40\141\156\144\40\157\x70\145\156\x69\144\75\x27{$openid}\x27\x20\x61\x6e\144\x20\143\162\145\141\x74\145\x74\151\155\x65\75\47{$createtime}\x27");
        goto Tii7s;
        mNrvr:
        c08L8:
        goto S_e63;
        yOvN3:
        $block = $this->initReceiverBlock($openid, $createtime);
        goto mNrvr;
        Tii7s:
        if (!is_null($block)) {
            goto c08L8;
        }
        goto yOvN3;
        S_e63:
        $this->log($openid, "\xe9\224\201\350\241\xa8\xe6\210\220\345\x8a\237\x2e\x2e\x2e");
        goto QnvlO;
        QnvlO:
    }
    public function unBlock($openid, $createtime)
    {
        pdo_delete($this->table_name, array("\157\x70\x65\156\151\x64" => $openid, "\143\x72\145\x61\x74\x65\x74\151\x6d\x65" => $createtime));
        $this->log($openid, "\xe8\247\243\xe9\224\201\346\210\220\345\x8a\237\x2e\56\56");
    }
    public function isBlock($openid, $createtime)
    {
        $block = $this->selectOne("\x20\141\x6e\x64\x20\157\x70\145\156\151\x64\75\x27{$openid}\x27\40\141\x6e\144\x20\143\x72\x65\141\164\145\164\151\x6d\145\75\x27{$createtime}\x27");
        return $block;
    }
}
