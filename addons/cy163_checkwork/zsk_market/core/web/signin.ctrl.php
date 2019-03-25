<?php

class signin extends ZskPage{

    public function login(){
        global $_W,$_GPC;
        include $this->template("web/signin/login");
    }

    public function verification(){
        global $_W,$_GPC;
        $record = array();
        $salt = '123';
        $record['username'] = htmldecode($_GPC['username']);
        $record['password'] = user_hash(htmldecode($_GPC['password']),$salt);
        $record['lastvisit'] = time();
        $record['lastip'] = $_SERVER["REMOTE_ADDR"];
        $userwhere = "select * from `ims_users` where username='".$record['username']."' and password='".$record['password']."'";
        $userInfo = pdo_query($userwhere);
        if($userInfo){

        }else{
            message('账号密码错误');
        }
        include $this->template("web/signin/login");
    }

    /**
     * @param $passwordinput
     * @param $salt
     * @return string
     *  加密方式
     */
    function user_hash($passwordinput, $salt) {
        global $_W;
        $passwordinput = "{$passwordinput}-{$salt}-{$_W['config']['setting']['authkey']}";
        return sha1($passwordinput);
    }

}