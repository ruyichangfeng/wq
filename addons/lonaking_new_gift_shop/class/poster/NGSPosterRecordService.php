<?php
/*
 __________________________________________________
|  Encode by BajieTeam on we7                      |
|__________________________________________________|
*/

goto vX95r;
vX95r:
/**
 * Created by PhpStorm.
 * User: leon
 * Date: 16/3/25
 * Time: 下午1:35
 */
require_once dirname(__FILE__) . "\x2f\x2e\x2e\x2f\x2e\x2e\57\x2e\x2e\57\x6c\x6f\x6e\x61\153\151\x6e\147\x5f\x66\154\141\x73\150\x2f\x46\154\x61\163\x68\x43\x6f\x6d\x6d\x6f\156\x53\145\x72\x76\x69\x63\x65\x2e\160\150\x70";
goto YZw01;
YZw01:
require_once dirname(__FILE__) . "\57\x2e\56\57\165\x73\145\x72\57\116\x47\123\x55\x73\x65\x72\x53\145\162\x76\x69\143\x65\x2e\160\x68\x70";
goto Ta7Hr;
Ta7Hr:
class NGSPosterRecordService extends FlashCommonService
{
    private $userService;
    const POSTER_POSTING = 1;
    const POSTER_FREE = 0;
    public function __construct()
    {
        goto LFzwX;
        NAQ5_:
        $this->columns = "\151\x64\x2c\x75\x6e\x69\141\143\x69\x64\x2c\157\160\145\x6e\151\144\54\x75\x73\x65\162\x5f\x69\x64\x2c\x6d\x73\x67\x69\144\x2c\143\x72\x65\141\164\145\x74\151\x6d\145\54\x69\x6e\137\x70\x6f\163\x74\151\156\147\54\160\x6f\163\164\145\162\137\x74\151\x6d\145\163\54\x70\157\163\164\145\162\x5f\x75\160\144\x61\x74\145\x5f\x74\x69\x6d\145\x2c\143\162\x65\141\x74\145\137\x74\151\x6d\145\54\x75\160\144\141\x74\145\137\x74\151\155\145";
        goto xMC0C;
        s2rES:
        $this->table_name = "\154\x6f\156\141\153\x69\156\147\137\x6e\x65\167\137\x67\x69\x66\x74\x5f\x73\150\157\160\137\160\157\x73\x74\145\162\x5f\162\x65\143\x6f\162\x64";
        goto NAQ5_;
        LFzwX:
        $this->plugin_name = "\x6c\157\156\141\153\x69\x6e\147\x5f\156\145\167\137\147\151\x66\x74\137\163\150\157\160";
        goto s2rES;
        xMC0C:
        $this->userService = new NGSUserService();
        goto uM9X8;
        uM9X8:
    }
    private function initUserPosterRecord($openid)
    {
        goto w0U86;
        w0U86:
        global $_W;
        goto jPHRM;
        jPHRM:
        $user = $this->userService->getUserInfoInApp($openid);
        goto vfHav;
        MKVzd:
        return $record;
        goto r5Qta;
        mtxPv:
        $record = $this->insertData($arr);
        goto MKVzd;
        vfHav:
        $arr = array("\x75\x6e\151\x61\x63\x69\x64" => $_W["\165\x6e\151\141\x63\151\x64"], "\165\163\x65\x72\137\151\x64" => $user["\x69\x64"], "\143\x72\x65\x61\164\145\x5f\x74\x69\x6d\x65" => time(), "\x75\160\144\x61\x74\x65\x5f\164\x69\x6d\x65" => time(), "\x6f\x70\x65\x6e\x69\144" => $openid);
        goto mtxPv;
        r5Qta:
    }
    public function startPosting($openid)
    {
        pdo_update($this->table_name, array("\x69\156\x5f\160\x6f\163\x74\151\x6e\x67" => NGSPosterRecordService::POSTER_POSTING), array("\x6f\160\x65\156\x69\x64" => $openid));
    }
    public function endPosting($openid)
    {
        pdo_update($this->table_name, array("\151\156\137\160\x6f\x73\164\151\x6e\147" => NGSPosterRecordService::POSTER_FREE), array("\157\160\x65\156\x69\x64" => $openid));
    }
    public function updateLastPosterTime($openid)
    {
        pdo_update($this->table_name, array("\160\x6f\163\x74\x65\162\137\x75\x70\x64\141\x74\x65\x5f\164\x69\x6d\145" => time()), array("\x6f\160\x65\x6e\151\144" => $openid));
    }
    public function updateMsgId($openid, $msgId)
    {
        pdo_update($this->table_name, array("\155\163\x67\151\144" => $msgId), array("\x6f\160\x65\x6e\151\144" => $openid));
    }
    public function posterTimesPlus($openid)
    {
        pdo_query("\x75\x70\x64\x61\x74\x65\40" . tablename($this->table_name) . "\x20\x73\x65\x74\x20\x70\x6f\163\x74\x65\162\137\164\x69\155\x65\163\75\x70\x6f\163\x74\145\162\137\x74\151\x6d\x65\x73\x2b\x31\40\167\x68\145\x72\145\x20\x6f\x70\145\156\151\144\75\47{$openid}\47");
    }
    public function getPosterRecordByOpenid($openid)
    {
        goto hXNFp;
        nQVjA:
        if (!(is_null($record) || empty($record))) {
            goto CPvG2;
        }
        goto fKXvF;
        dD5Tq:
        return $record;
        goto sFiE0;
        fKXvF:
        $record = $this->initUserPosterRecord($openid);
        goto tWae3;
        hXNFp:
        $record = $this->selectOne("\x20\x61\x6e\144\x20\157\160\145\x6e\x69\x64\75\47{$openid}\47");
        goto nQVjA;
        tWae3:
        return $record;
        goto aeGvs;
        aeGvs:
        CPvG2:
        goto dD5Tq;
        sFiE0:
    }
}
