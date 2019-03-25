<?php
/*
 __________________________________________________
|  Encode by BajieTeam on we7                      |
|__________________________________________________|
*/

/**
 * Created by PhpStorm.
 * User: leon
 * Date: 16/4/24
 * Time: 下午2:02
 */
require_once dirname(__FILE__) . "\x2f\56\56\x2f\x46\x6c\x61\163\150\103\x6f\x6d\155\157\156\x53\145\x72\166\151\x63\x65\56\x70\x68\x70";
class FlashMcGroupService extends FlashCommonService
{
    public function __construct()
    {
        goto o6D_1;
        o6D_1:
        $this->table_name = "\x6d\x63\137\x67\x72\x6f\165\x70\x73";
        goto Podk4;
        Podk4:
        $this->columns = "\x2a";
        goto Uj_wk;
        Uj_wk:
        $this->plugin_name = "\154\157\x6e\x61\153\x69\156\x67\x5f\146\x6c\141\163\150";
        goto UwIy5;
        UwIy5:
    }
    public function selectByIds($groupIds)
    {
        goto dCz0K;
        OVG5F:
        EDjO6:
        goto QIb0D;
        Hc14K:
        throw new Exception("\345\217\x82\xe6\x95\260\344\270\xba\347\xa9\xba", 404);
        goto Rn5d4;
        QIb0D:
        if (!(sizeof($groupIds) <= 0)) {
            goto VcKnb;
        }
        goto Hc14K;
        MnRex:
        throw new Exception("\346\237\xa5\xe8\xaf\xa2\345\x8f\x82\346\225\260\xe5\xbc\202\xe5\270\xb8", 404);
        goto OVG5F;
        dM7W3:
        $idsStr = implode("\54", $groupIds);
        goto BV4rc;
        yIi2L:
        $data_list = pdo_fetchall("\x53\105\114\105\x43\124\x20" . $this->columns . "\x20\106\x52\x4f\115\x20" . tablename($this->table_name) . "\x20\127\x48\105\x52\105\40\x67\162\x6f\x75\160\x69\x64\x20\x69\156\x20{$in}");
        goto FiOC4;
        FiOC4:
        return $data_list;
        goto t4hho;
        dCz0K:
        if (is_array($groupIds)) {
            goto EDjO6;
        }
        goto MnRex;
        sdcQy:
        $ids = array_unique($groupIds);
        goto dM7W3;
        Rn5d4:
        VcKnb:
        goto sdcQy;
        BV4rc:
        $in = "\x28" . $idsStr . "\51";
        goto yIi2L;
        t4hho:
    }
    public function getUserMcGroupByUid($uid)
    {
        goto iS5h7;
        W8xGj:
        $data = pdo_fetch("\x53\105\x4c\105\103\x54\x20" . $this->columns . "\40\106\122\x4f\115\40" . tablename($this->table_name) . "\x20\x57\x48\105\122\105\x20\x67\162\157\x75\x70\x69\x64\x3d\x27{$groupID}\x27");
        goto jnW1k;
        YKCtX:
        $groupID = $member["\x67\x72\x6f\165\160\151\x64"];
        goto W8xGj;
        iS5h7:
        $member = pdo_fetch("\x73\x65\154\x65\143\164\x20\x2a\x20\146\162\157\x6d\40" . tablename("\x6d\143\x5f\x6d\x65\x6d\142\145\162\163") . "\40\167\150\145\x72\x65\x20\165\x69\144\75\x27{$uid}\47");
        goto YKCtX;
        jnW1k:
        return $data;
        goto xL2sI;
        xL2sI:
    }
}
