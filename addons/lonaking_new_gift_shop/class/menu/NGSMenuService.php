<?php
/*
 __________________________________________________
|  Encode by BajieTeam on we7                      |
|__________________________________________________|
*/

require_once dirname(__FILE__) . "\57\56\56\x2f\56\x2e\57\x2e\56\57\x6c\x6f\x6e\x61\x6b\151\156\x67\137\x66\154\x61\x73\150\x2f\x46\x6c\141\163\150\103\x6f\x6d\155\x6f\156\x53\145\162\166\151\143\145\x2e\160\x68\160";
class NGSMenuService extends FlashCommonService
{
    public function __construct()
    {
        goto By7YJ;
        By7YJ:
        $this->plugin_name = "\154\x6f\x6e\141\153\151\x6e\x67\137\x6e\145\167\137\147\151\x66\164\x5f\x73\x68\x6f\x70";
        goto F1M6r;
        F1M6r:
        $this->table_name = "\154\x6f\156\141\x6b\151\x6e\x67\x5f\156\145\167\x5f\x67\x69\x66\164\137\x73\150\157\x70\x5f\155\x65\x6e\165";
        goto zRy4M;
        zRy4M:
        $this->columns = "\151\x64\54\165\156\x69\x61\143\151\144\x2c\x74\171\x70\145\54\156\141\155\x65\54\x69\x63\157\x6e\54\165\x72\154\x2c\x63\154\x69\143\153\x2c\162\x61\156\153\x2c\x63\162\145\141\x74\x65\x5f\x74\x69\155\145\54\165\160\x64\141\164\145\x5f\x74\151\x6d\145";
        goto jp6Cg;
        jp6Cg:
    }
    public function getAllTabMenus()
    {
        return $this->selectAll("\40\141\x6e\144\40\164\171\x70\x65\75\62\x20\157\x72\x64\145\x72\40\x62\x79\x20\162\x61\156\153\40\x64\145\163\143");
    }
    public function getAllHomeMenus()
    {
        return $this->selectAllOrderBy("\40\141\x6e\144\40\x74\x79\x70\x65\75\61", "\162\x61\x6e\153\40\x44\x45\x53\x43\x2c");
    }
}
