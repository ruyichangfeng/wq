<?php
/*
 __________________________________________________
|  Encode by BajieTeam on we7                      |
|__________________________________________________|
*/

require_once dirname(__FILE__) . "\57\56\56\57\x2e\x2e\57\x2e\56\x2f\154\157\156\x61\153\x69\x6e\147\137\146\x6c\x61\x73\x68\57\106\x6c\x61\x73\150\x43\x6f\155\x6d\157\x6e\123\145\x72\166\x69\x63\x65\x2e\x70\x68\160";
class NGSGiftImageService extends FlashCommonService
{
    public function __construct()
    {
        goto cNLq7;
        cNLq7:
        $this->plugin_name = "\154\157\156\x61\x6b\151\x6e\x67\137\x6e\x65\x77\137\147\x69\x66\x74\x5f\x73\x68\x6f\x70";
        goto uhMp8;
        f0LU4:
        $this->columns = "\x69\144\54\x75\156\x69\141\x63\x69\x64\54\x67\151\146\x74\x5f\x69\x64\x2c\164\x79\160\145\x2c\162\141\x66\146\x6c\145\x2c\x73\x74\141\162\164\x5f\144\x61\164\145\x2c\145\x6e\x64\x5f\144\141\164\x65\54\164\x69\164\x6c\145\x2c\164\141\147\54\x74\141\147\137\x63\x6f\154\157\x72\x2c\154\x69\x6e\x6b\137\x70\150\x6f\156\x65\54\x6c\x69\x6e\153\137\141\x64\144\x72\x65\x73\163\x2c\165\x6e\144\145\x6c\x69\166\145\162\x65\144\137\x64\145\x73\x63\x2c\x73\x75\163\x70\x65\156\163\145\x5f\x64\x65\163\x63\54\144\145\x73\x63\162\151\x70\164\151\157\x6e\x2c\147\x75\151\x64\145\x6c\151\x6e\145\x73\54\x64\145\164\x61\151\x6c\137\151\155\x61\147\x65\54\x74\150\x75\x6d\x62\156\x61\x69\154\x2c\x69\x63\x6f\156\54\142\x61\156\156\x65\x72\x2c\x6d\x61\x72\x6b\145\164\x5f\x70\x72\151\143\x65\x2c\142\165\171\x5f\x74\171\160\x65\54\x73\143\157\x72\x65\x2c\x6d\157\x6e\145\171\54\164\x72\141\156\x73\x5f\146\145\x65\137\160\x61\x79\137\167\141\x79\x2c\164\162\141\x6e\x73\x5f\x66\x65\x65\54\x68\x62\137\x61\x6d\157\165\156\164\54\x68\x62\137\155\157\x64\145\54\x68\x62\137\x72\x61\x6e\144\157\x6d\137\155\x69\x6e\x2c\x68\x62\x5f\162\141\156\144\157\x6d\137\x6d\x61\x78\54\150\x66\137\x61\x6d\157\165\x6e\164\54\154\154\137\x61\155\x6f\x75\156\164\x2c\x72\x61\x66\146\154\145\x5f\x73\143\157\x72\145\137\x61\155\157\165\x6e\164\x2c\x76\x61\x6c\151\x64\137\x64\x61\164\145\137\x74\171\160\x65\x2c\x76\141\x6c\x69\144\137\144\141\x74\x65\137\x61\146\x74\145\x72\x5f\x64\x61\171\x73\54\x76\x61\x6c\151\x64\x61\x74\145\x5f\x73\x74\x61\162\164\137\144\x61\x74\145\x2c\x76\x61\x6c\x69\144\x61\164\145\x5f\145\156\144\137\x64\x61\x74\x65\x2c\x73\x75\143\143\x65\x73\163\x5f\x72\145\144\x69\162\x65\x63\x74\54\141\x62\156\x6f\x72\x6d\x61\x6c\x5f\162\x61\156\x6b\54\144\x69\163\164\162\151\x62\165\164\x65\x5f\163\143\157\x72\x65\54\x64\151\163\x74\162\x69\x62\165\164\145\x5f\x61\x6d\157\x75\x6e\164\x2c\163\150\x61\x72\145\x5f\x73\x63\x6f\162\145\x2c\163\x68\x61\162\x65\137\141\x6d\x6f\165\x6e\164\x2c\162\x65\x77\141\x72\x64\137\163\x63\157\x72\145\x2c\162\145\167\x61\x72\144\137\141\x6d\157\165\x6e\164\x2c\143\x72\145\x61\x74\x65\137\x74\151\155\x65\x2c\x75\x70\144\141\x74\x65\x5f\164\151\155\145";
        goto ZzPo0;
        uhMp8:
        $this->table_name = "\x6c\157\x6e\141\x6b\x69\x6e\x67\137\156\145\167\137\147\151\146\164\137\x73\150\x6f\160\137\147\151\x66\164\137\151\155\x61\x67\x65";
        goto f0LU4;
        ZzPo0:
    }
    public function gift2Image($gift)
    {
        $image = array("\x75\156\x69\141\x63\151\144" => $gift["\165\x6e\151\x61\x63\151\144"], "\x67\151\x66\x74\x5f\x69\x64" => $gift["\x69\144"], "\164\x79\160\x65" => $gift["\x74\x79\x70\145"], "\162\x61\x66\x66\x6c\145" => $gift["\x72\141\146\146\154\x65"], "\x73\x74\141\x72\164\x5f\x64\x61\164\x65" => $gift["\163\164\141\162\164\137\x64\141\x74\x65"], "\145\x6e\x64\x5f\144\x61\x74\x65" => $gift["\145\x6e\144\x5f\144\141\x74\x65"], "\x74\151\164\x6c\x65" => $gift["\x74\151\x74\x6c\x65"], "\164\x61\x67" => $gift["\164\141\x67"], "\164\141\x67\137\143\157\x6c\157\162" => $gift["\164\x61\147\137\x63\x6f\x6c\157\x72"], "\x6c\151\156\153\137\x70\150\x6f\156\145" => $gift["\154\x69\156\153\137\160\150\157\x6e\x65"], "\154\x69\156\x6b\137\141\144\x64\162\145\x73\163" => $gift["\x6c\151\156\x6b\x5f\141\144\x64\162\145\x73\x73"], "\x75\156\144\145\x6c\151\166\145\162\x65\144\x5f\144\x65\x73\x63" => $gift["\x75\156\x64\x65\x6c\x69\166\145\x72\145\144\137\144\x65\x73\x63"], "\x73\x75\x73\160\x65\156\163\145\137\x64\x65\163\x63" => $gift["\x73\165\x73\160\145\x6e\x73\145\137\x64\x65\x73\143"], "\144\x65\x73\x63\x72\x69\160\164\x69\157\x6e" => $gift["\144\145\x73\x63\x72\151\x70\x74\x69\x6f\156"], "\147\x75\x69\144\x65\154\x69\x6e\x65\163" => $gift["\x67\x75\151\144\x65\x6c\x69\x6e\x65\x73"], "\x64\145\x74\141\x69\x6c\x5f\151\155\141\147\145" => $gift["\x64\x65\x74\x61\151\154\137\x69\155\141\x67\145"], "\x74\x68\165\155\x62\x6e\141\151\154" => $gift["\x74\150\165\x6d\142\x6e\x61\x69\x6c"], "\x69\x63\157\x6e" => $gift["\x69\x63\157\x6e"], "\142\x61\x6e\x6e\x65\x72" => $gift["\x62\141\156\156\145\x72"], "\155\141\x72\x6b\145\164\137\x70\162\151\x63\x65" => $gift["\x6d\141\162\153\145\x74\x5f\x70\x72\151\x63\x65"], "\142\x75\171\137\x74\171\160\145" => $gift["\142\x75\171\x5f\x74\171\x70\x65"], "\x73\143\x6f\x72\x65" => $gift["\x73\143\157\x72\145"], "\x6d\157\156\x65\x79" => $gift["\x6d\157\156\x65\171"], "\x74\162\x61\156\x73\x5f\146\x65\145\137\x70\x61\x79\x5f\167\x61\x79" => $gift["\164\162\x61\x6e\163\137\146\x65\x65\x5f\160\141\x79\x5f\167\x61\x79"], "\164\x72\x61\156\163\x5f\x66\145\145" => $gift["\x74\x72\141\x6e\163\x5f\146\x65\x65"], "\150\x62\137\141\155\157\165\156\164" => $gift["\150\142\x5f\x61\x6d\x6f\x75\156\x74"], "\150\142\x5f\x6d\157\x64\x65" => $gift["\x68\142\137\155\157\x64\x65"], "\x68\x62\x5f\162\141\x6e\x64\157\x6d\x5f\x6d\x69\156" => $gift["\150\x62\x5f\x72\x61\x6e\144\x6f\x6d\x5f\155\x69\156"], "\x68\142\137\x72\x61\x6e\x64\157\155\137\155\141\x78" => $gift["\x68\142\x5f\162\x61\156\x64\157\155\137\155\141\170"], "\150\146\137\x61\x6d\157\x75\156\164" => $gift["\x68\146\137\x61\155\x6f\x75\x6e\x74"], "\154\154\x5f\141\x6d\x6f\165\156\164" => $gift["\154\x6c\x5f\x61\x6d\157\165\x6e\x74"], "\162\x61\146\x66\x6c\x65\137\x73\x63\x6f\162\x65\137\x61\155\157\165\156\x74" => $gift["\x72\x61\146\146\154\x65\x5f\163\143\157\162\x65\x5f\x61\155\157\165\156\x74"], "\166\x61\x6c\x69\144\x5f\144\x61\x74\145\x5f\164\x79\x70\145" => $gift["\x76\141\x6c\x69\x64\x5f\144\x61\x74\145\x5f\x74\171\160\145"], "\166\x61\x6c\x69\x64\x5f\144\x61\164\145\x5f\x61\146\164\145\162\x5f\144\141\171\x73" => $gift["\x76\x61\x6c\x69\x64\x5f\x64\x61\164\145\x5f\x61\x66\164\x65\162\137\144\141\x79\x73"], "\x76\141\154\151\144\141\x74\145\x5f\x73\x74\141\162\x74\137\x64\x61\x74\x65" => $gift["\166\x61\x6c\x69\144\x61\x74\145\137\163\164\x61\162\164\137\144\x61\164\x65"], "\166\141\154\151\x64\141\x74\145\137\x65\156\144\x5f\x64\x61\x74\x65" => $gift["\166\141\154\151\x64\x61\x74\x65\137\145\156\x64\137\144\x61\164\145"], "\163\x75\x63\143\x65\x73\163\x5f\162\145\144\x69\162\x65\x63\x74" => $gift["\163\x75\143\x63\145\x73\163\x5f\162\x65\x64\151\x72\145\143\x74"], "\141\142\x6e\157\162\155\141\x6c\x5f\x72\x61\x6e\153" => $gift["\x61\142\x6e\x6f\x72\155\141\x6c\x5f\162\141\156\x6b"], "\x72\x65\x77\141\162\x64\x5f\141\155\x6f\x75\156\x74" => $gift["\x72\x65\167\x61\162\x64\x5f\x61\x6d\x6f\165\x6e\164"], "\162\145\167\141\162\x64\x5f\x73\143\157\162\145" => $gift["\x72\145\x77\141\x72\144\137\163\143\157\162\145"], "\144\x69\x73\x74\162\151\142\x75\x74\145\x5f\163\x63\157\x72\145" => $gift["\144\x69\x73\x74\162\151\142\165\164\145\x5f\x73\143\x6f\x72\x65"], "\144\151\x73\164\162\151\x62\165\x74\145\137\141\155\157\x75\x6e\x74" => $gift["\144\x69\x73\164\x72\151\x62\165\164\x65\x5f\x61\x6d\157\x75\156\x74"], "\x73\x68\x61\x72\145\x5f\x73\143\157\x72\145" => $gift["\163\x68\x61\x72\145\137\163\x63\x6f\162\x65"], "\x73\150\x61\x72\x65\137\141\x6d\x6f\x75\156\x74" => $gift["\163\150\x61\162\x65\x5f\x61\x6d\x6f\x75\x6e\164"], "\x63\162\x65\141\x74\145\x5f\x74\151\155\145" => time(), "\165\x70\144\141\x74\145\x5f\164\151\x6d\145" => time());
        return $this->insertData($image);
    }
}