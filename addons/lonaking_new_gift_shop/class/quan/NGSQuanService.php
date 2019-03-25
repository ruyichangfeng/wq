<?php
/*
 __________________________________________________
|  Encode by BajieTeam on we7                      |
|__________________________________________________|
*/

goto ngWee;
z_6YC:
require_once dirname(__FILE__) . "\57\56\x2e\57\165\x73\x65\x72\x2f\x4e\107\x53\125\163\x65\x72\x53\145\x72\x76\151\x63\x65\56\160\150\160";
goto Ften6;
ngWee:
require_once dirname(__FILE__) . "\x2f\x2e\x2e\57\56\x2e\x2f\56\x2e\57\x6c\157\156\x61\153\151\156\x67\x5f\x66\154\141\x73\x68\x2f\106\x6c\141\x73\x68\x43\x6f\x6d\155\157\156\x53\145\x72\x76\x69\x63\x65\x2e\x70\150\160";
goto z_6YC;
Ften6:
/**
 * 49
 * Class NGSQuanService
 */
class NGSQuanService extends FlashCommonService
{
    private $userService;
    public function __construct()
    {
        goto eVJ79;
        fvWlp:
        $this->table_name = "\x6c\157\156\x61\x6b\151\156\147\137\x6e\x65\167\137\147\151\x66\164\x5f\163\150\157\x70\x5f\161\165\141\156";
        goto vO_8Z;
        BVnaz:
        $this->userService = new NGSUserService();
        goto tj65S;
        eVJ79:
        $this->plugin_name = "\x6c\157\156\141\x6b\x69\156\x67\137\156\x65\167\137\x67\x69\x66\164\137\163\x68\157\160";
        goto fvWlp;
        vO_8Z:
        $this->columns = "\x69\x64\x2c\165\156\x69\141\143\151\x64\x2c\164\x79\160\145\54\147\151\x66\164\137\x69\144\x2c\x68\x61\x6f\x2c\166\141\154\x75\145\x2c\163\164\141\x74\165\x73\54\164\151\x6d\x65\54\x74\151\x6d\145\163\54\x75\151\x64\54\x75\163\145\x72\x5f\x69\x64\54\x6f\x70\145\x6e\151\144\x2c\x67\145\x74\137\x74\x69\x6d\145\54\143\x72\x65\141\x74\145\x5f\x74\151\x6d\x65\x2c\165\x70\x64\141\164\145\137\164\x69\155\x65";
        goto BVnaz;
        tj65S:
    }
    public function giveAQuanToUser($giftId, $user)
    {
        goto ZGzMc;
        txfP3:
        $quan["\165\151\144"] = $user["\165\151\144"];
        goto A73DH;
        iVVJq:
        $quan["\x67\145\164\x5f\164\x69\155\x65"] = time();
        goto hRrKs;
        xIQ_3:
        $quan["\x6f\160\x65\x6e\151\x64"] = $user["\157\x70\145\156\x69\144"];
        goto DkAQW;
        hRrKs:
        $quan["\x75\x70\x64\141\x74\x65\x5f\164\151\155\145"] = time();
        goto xIQ_3;
        QLVN3:
        throw new Exception("\xe6\xb2\241\346\234\x89\xe8\xb6\263\345\244\237\xe7\x9a\204\xe5\x88\xb8\345\217\221\xe6\x94\276\xe7\273\x99\xe7\x94\250\xe6\210\267", 4901);
        goto L7bLy;
        DkAQW:
        return $this->updateData($quan);
        goto L7kSc;
        oIUVA:
        $quan["\x75\x73\145\x72\137\x69\x64"] = $user["\x69\144"];
        goto txfP3;
        ZGzMc:
        $quan = $this->selectOne("\40\x61\x6e\144\40\147\151\146\164\137\x69\x64\75{$giftId}\x20\141\x6e\144\x20\163\164\141\164\x75\x73\x3d\60");
        goto LxrqA;
        A73DH:
        $quan["\163\x74\x61\164\x75\163"] = 1;
        goto z3_tp;
        LxrqA:
        if (!(null == $quan || empty($quan))) {
            goto Dl6ki;
        }
        goto QLVN3;
        L7bLy:
        Dl6ki:
        goto JNM77;
        JNM77:
        $user = $this->userService->getByIdOrObj($user);
        goto oIUVA;
        z3_tp:
        $quan["\164\x69\155\145\x73"] = $quan["\x74\151\155\x65\x73"] + 1;
        goto iVVJq;
        L7kSc:
    }
}
