<?php
/*
 __________________________________________________
|  Encode by BajieTeam on we7                      |
|__________________________________________________|
*/

goto G4tIR;
PHLqk:
require_once dirname(__FILE__) . "\57\x2e\56\57\56\56\57\106\154\x61\163\150\125\163\145\162\x53\x65\x72\166\x69\143\145\56\160\x68\160";
goto wWz2D;
G4tIR:
/**
 * Created by PhpStorm.
 * User: leon
 * Date: 15/11/16
 * Time: 下午12:57
 */
require_once dirname(__FILE__) . "\x2f\x2e\56\x2f\x2e\56\57\106\x6c\x61\163\150\103\157\x6d\155\157\156\x53\145\x72\x76\x69\x63\x65\56\x70\x68\x70";
goto PHLqk;
wWz2D:
class FlashCreditService extends FlashCommonService
{
    private $flashUserService;
    /**
     * CreditUtils constructor.
     */
    public function __construct()
    {
        goto X65DV;
        X65DV:
        $this->table_name = "\x6d\x63\137\x63\162\145\144\151\x74\163\137\162\x65\x63\157\162\144";
        goto isDo5;
        Jm1iI:
        $this->flashUserService = new FlashUserService();
        goto Qy9MD;
        isDo5:
        $this->columns = "\x2a";
        goto q7zqk;
        q7zqk:
        $this->plugin_name = "\x6c\x6f\156\141\x6b\151\x6e\x67\x5f\146\x6c\x61\163\x68";
        goto Jm1iI;
        Qy9MD:
    }
    public function fetchUserCreditRecordPage($openid, $pageIndex = '', $pageSize = '', $creditType = "\143\162\145\x64\x69\164\x31")
    {
        goto IPGwg;
        JaHWG:
        $pageSize = $pageSize >= 10 ? $pageSize : 10;
        goto bdUgs;
        IPGwg:
        $pageIndex = max(1, $pageIndex);
        goto JaHWG;
        bdUgs:
        $uid = $this->flashUserService->fetchUid($openid);
        goto U29Vj;
        TAQiT:
        return $page;
        goto RkzmG;
        U29Vj:
        $page = $this->selectPageOrderBy("\101\116\104\x20\165\x69\x64\75{$uid}\x20\101\x4e\x44\40\143\162\x65\144\x69\164\164\x79\x70\x65\x3d\x27{$creditType}\47", "\143\x72\145\x61\164\145\164\151\x6d\x65\x20\104\105\x53\x43\54", $pageIndex, $pageSize);
        goto TAQiT;
        RkzmG:
    }
}
