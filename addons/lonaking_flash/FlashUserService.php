<?php
/*
 __________________________________________________
|  Encode by BajieTeam on we7                      |
|__________________________________________________|
*/

/**
 * Created by PhpStorm.
 * User: leon
 * Date: 15/9/2
 * Time: 下午4:46
 * Exception 5开头
 */
class FlashUserService
{
    /**
     * 增加用户积分数量
     * @param $score
     * @param $openid
     */
    public function addUserScore($score, $openid, $log = '')
    {
        $this->updateUserScore($score, $openid, $log);
    }
    /**
     * 减少用户数量
     * @param $score
     * @param $openid
     */
    public function reduceUserScore($score, $openid, $log = '')
    {
        goto JBkKK;
        JBkKK:
        if ($score < 0) {
            goto zxqBu;
        }
        goto Pl0oj;
        NopMo:
        goto UZjmU;
        goto s7IWK;
        Pl0oj:
        $this->updateUserScore($score * -1, $openid, $log);
        goto NopMo;
        RweoN:
        $this->updateUserScore($score, $openid, $log);
        goto SdUpY;
        s7IWK:
        zxqBu:
        goto RweoN;
        SdUpY:
        UZjmU:
        goto cQUA7;
        cQUA7:
    }
    /**
     * 更新用户积分
     * @param $score
     * @param $openid
     */
    public function updateUserScore($score, $openid, $log = '')
    {
        $this->updateUserCredit("\143\x72\x65\x64\x69\x74\61", $score, $openid, $log);
    }
    public function updateUserMoney($money, $openid, $log = '')
    {
        $this->updateUserCredit("\x63\x72\x65\x64\151\164\x32", $money, $openid, $log);
    }
    public function addUserMoney($money, $openid, $log = '')
    {
        goto UUJKn;
        nckDm:
        EJFRl:
        goto TT76d;
        UUJKn:
        if (!($money < 0)) {
            goto EJFRl;
        }
        goto N2cHG;
        TT76d:
        $this->updateUserMoney($money, $openid, $log);
        goto LSBrU;
        N2cHG:
        $money = $money * -1;
        goto nckDm;
        LSBrU:
    }
    public function reduceUserMoney($money, $openid, $log = '')
    {
        goto mzSln;
        QKs41:
        $this->updateUserMoney($money, $openid, $log);
        goto ZkeIC;
        HmIdl:
        $this->updateUserMoney($money * -1, $openid, $log);
        goto ebdbX;
        xXOll:
        GkD4j:
        goto QKs41;
        mzSln:
        if ($money < 0) {
            goto GkD4j;
        }
        goto HmIdl;
        ebdbX:
        goto CiN4m;
        goto xXOll;
        ZkeIC:
        CiN4m:
        goto n4oqu;
        n4oqu:
    }
    private function updateUserCredit($type = "\x63\162\145\144\x69\164\x31", $value, $openid, $log = '')
    {
        goto rViW9;
        nZi_j:
        $log_arr = array();
        goto C0AI5;
        Tp1FG:
        $log_arr[1] = $log == '' ? "\xe6\x9c\xaa\xe8\256\260\xe5\xbd\225" : $log;
        goto W4_Zi;
        rViW9:
        load()->model("\155\x63");
        goto mjjfZ;
        J2BGn:
        mc_credit_update($uid, $type, $value, $log_arr);
        goto TunGp;
        C0AI5:
        $log_arr[0] = $uid;
        goto Tp1FG;
        W4_Zi:
        $log_arr[2] = '';
        goto J2BGn;
        mjjfZ:
        $uid = mc_openid2uid($openid);
        goto nZi_j;
        TunGp:
    }
    /**
     * 获取用户积分
     * @param $openid
     */
    public function fetchUserScore($openid)
    {
        goto N3tZg;
        IJXgS:
        $credits = mc_credit_fetch($uid, array("\143\x72\x65\x64\x69\x74\x31"));
        goto wtwDj;
        wtwDj:
        return $credits["\x63\162\x65\x64\151\164\61"];
        goto Fpqgj;
        N3tZg:
        load()->model("\155\x63");
        goto DxlaG;
        DxlaG:
        $uid = mc_openid2uid($openid);
        goto IJXgS;
        Fpqgj:
    }
    /**
     * 获取用户余额
     * @param $openid
     * @return mixed
     */
    public function fetchUserMoney($openid)
    {
        goto VOEbb;
        kzJ8L:
        return $credits["\143\x72\x65\144\x69\x74\62"];
        goto X53t6;
        Qhcmc:
        $credits = mc_credit_fetch($uid, array("\143\x72\x65\x64\151\164\x32"));
        goto kzJ8L;
        bjP2s:
        $uid = mc_openid2uid($openid);
        goto Qhcmc;
        VOEbb:
        load()->model("\155\143");
        goto bjP2s;
        X53t6:
    }
    /**
     * 获取用户积分，得到一个数组
     * @param $openid
     * @return array
     */
    public function fetchUserCredit($openid)
    {
        goto dyvH3;
        gx5QF:
        return $credits;
        goto Yz1jS;
        BjOoa:
        $uid = mc_openid2uid($openid);
        goto nuhbv;
        nuhbv:
        $credits = mc_credit_fetch($uid);
        goto gx5QF;
        dyvH3:
        load()->model("\x6d\x63");
        goto BjOoa;
        Yz1jS:
    }
    /**
     * 获取粉丝信息，包含粉丝的积分 mc_fansinfo
     * @param $openid
     * @return bool
     */
    public function fetchFansInfo($openid)
    {
        goto ujwmq;
        fcDeV:
        if (!empty($user)) {
            goto rMCbM;
        }
        goto aRUaT;
        HYhbo:
        rMCbM:
        goto psvQR;
        psvQR:
        $user["\x63\162\x65\x64\x69\164"] = $this->fetchUserCredit($openid);
        goto SH2Ar;
        i1Kbs:
        $user = mc_fansinfo($openid, $_W["\141\x63\143\x6f\x75\x6e\x74"]["\x61\143\151\144"]);
        goto fcDeV;
        SH2Ar:
        $user["\x73\143\157\x72\145"] = intval($user["\143\162\145\x64\x69\164"]["\x63\x72\x65\144\x69\x74\x31"]);
        goto Qs9In;
        aRUaT:
        $this->oauthFansInfo();
        goto R2ZJ3;
        Qs9In:
        $user["\155\157\156\x65\171"] = $user["\143\x72\x65\144\x69\164"]["\143\x72\x65\x64\x69\164\62"];
        goto txkCr;
        ujwmq:
        global $_W;
        goto bR68_;
        R2ZJ3:
        return $this->fetchFansInfo($openid);
        goto HYhbo;
        txkCr:
        return $user;
        goto Gu3Ju;
        bR68_:
        load()->model("\x6d\143");
        goto i1Kbs;
        Gu3Ju:
    }
    /**
    * 通过授权获取用户信息
    * @return array|bool {
                   "subscribe": 1,
                   "openid": "dsfsdajlfsjldfjsadk",
                   "nickname": "abc",
                   "sex": 1,
                   "language": "zh_CN",
                   "city": "昌平",
                   "province": "北京",
                   "country": "中国",
                   "subscribe_time": 1449370178,
                   "remark": "",
                   "groupid": 0,
                   "avatar": "http://wx.qlogo.cn/mmopen//0"
                   }
    *
    * 过期 请勿使用
    */
    public function authFansInfo()
    {
        goto aNP6f;
        abqIl:
        $user["\x74\x61\x67"] = $tagUserInfo;
        goto TriJf;
        uu0gu:
        $user = $this->fetchFansInfo($_W["\x6f\x70\x65\156\x69\144"]);
        goto synhC;
        synhC:
        if (!(is_null($user) || empty($user["\164\x61\x67"]["\x6e\151\x63\153\x6e\141\x6d\x65"]))) {
            goto N0XQ_;
        }
        goto d9Yds;
        aNP6f:
        global $_W;
        goto YwRRl;
        H5bh9:
        $user = $this->fetchFansInfo($_W["\x6f\x70\x65\x6e\x69\144"]);
        goto abqIl;
        YwRRl:
        load()->model("\155\x63");
        goto uu0gu;
        TriJf:
        N0XQ_:
        goto POFdv;
        wZZRh:
        $user["\x6d\157\x6e\x65\x79"] = $user["\x63\162\x65\x64\x69\x74"]["\x63\162\145\144\x69\164\62"];
        goto YdJRw;
        ynUuj:
        $user["\163\x63\x6f\x72\x65"] = intval($user["\x63\162\145\144\x69\164"]["\x63\162\x65\x64\151\x74\x31"]);
        goto wZZRh;
        POFdv:
        $user["\x63\x72\x65\x64\x69\x74"] = $this->fetchUserCredit($_W["\x6f\160\145\x6e\x69\x64"]);
        goto ynUuj;
        d9Yds:
        $tagUserInfo = mc_oauth_userinfo();
        goto H5bh9;
        YdJRw:
        return $user;
        goto rjKbD;
        rjKbD:
    }
    /**
    * 请使用此方法
    * @return array|bool{
               "subscribe": 1,
               "openid": "dsfsdajlfsjldfjsadk",
               "nickname": "abc",
               "sex": 1,
               "language": "zh_CN",
               "city": "昌平",
               "province": "北京",
               "country": "中国",
               "subscribe_time": 1449370178,
               "remark": "",
               "groupid": 0,
               "avatar": "http://wx.qlogo.cn/mmopen//0"
               }
    */
    public function oauthFansInfo()
    {
        goto obbl1;
        ON22N:
        $user = mc_oauth_userinfo();
        goto eYYcT;
        EX2BY:
        load()->model("\x6d\x63");
        goto ON22N;
        obbl1:
        global $_W;
        goto EX2BY;
        eYYcT:
        return $user;
        goto vV3xw;
        vV3xw:
    }
    /**
     * 获取用户的uid
     * @param $openid
     * @return array|bool
     */
    public function fetchUid($openid)
    {
        goto JO_oW;
        jMAW6:
        $uid = mc_openid2uid($openid);
        goto canVH;
        canVH:
        return $uid;
        goto ZhJYq;
        JO_oW:
        load()->model("\x6d\x63");
        goto jMAW6;
        ZhJYq:
    }
}
