<?php
/**
 * 微早教模块订阅器
 *
 * @author 泉微
 * @url http://www.leshuju.cn
 */
defined('IN_IA') or exit('Access Denied');
//include "inc/function/function.php";
class Qw_microeduModuleReceiver extends WeModuleReceiver {
	public function receive() {
		$type = $this->message['type'];
        global $_W;
        $uniacid = $_W['uniacid'];
        load()->model('mc');
        $userinfo =mc_oauth_userinfo();
        $fromuser = $this->message['from'];
        if (empty($fromuser)) {
            return false;
        }
        if ($this->message['msgtype'] == 'event') {
            if ($this->message['event'] == 'subscribe' && !empty($this->message['ticket'])) {
                $scene_id = str_replace('qrscene_', '',$this->message['eventkey']);
                $qrid = pdo_fetch("SELECT id FROM ".tablename('qrcode')." WHERE qrcid=:qrcid AND uniacid=:uniacid", array(':qrcid'=>$scene_id, ':uniacid' => $_W['uniacid']));
                $consultant_xq = pdo_fetch("SELECT * FROM ".tablename('qw_microedu_consultants')." WHERE codeid=:qrid AND uniacid=:uniacid", array(':qrid'=>$qrid['id'], ':uniacid' => $_W['uniacid']));
                $users_xq = pdo_fetch("SELECT * FROM ".tablename('qw_microedu_users')." WHERE uniacid=:uniacid AND role_id=:role_id AND role_type='consultants'",array(':uniacid'=>$_W['uniacid'],':role_id'=>$consultant_xq['id']));
                $this->sendtext("您成功通过".$users_xq['fullname']."关注平台",$fromuser);
                //添加老师
                $sql= "SELECT * FROM ".tablename("qw_microedu_users")." WHERE uniacid='$uniacid' AND openid='$fromuser'";
                    $user = pdo_fetch($sql);
                    $this->sendtext($sql,$fromuser);
                    // 若当前用户不存在于 qw_microedu_users 表内，插入用户和家长记录，并设置用户身份为家长
                    if (empty($user)) {
                        $parent = array(
                            'uniacid' => $_W['uniacid'],
                            //'avatar' => $_W['fans']['tag']['avatar'],
                            'consultant_id'=>$consultant_xq['id']
                        );

                        $result = pdo_insert('qw_microedu_parents',$parent);

                        if ($result) {
                            $parent_id = pdo_insertid();
                            $user_data = array(
                                'uniacid' => $_W['uniacid'],
                                'role_type' => 'parents',
                                'role_id' => $parent_id,
                                'uid' => $_W['fans']['uid'],
                                'openid' => $fromuser,
                            );
                            $r =pdo_insert('qw_microedu_users', $user_data);
                            if($r){
                                $this->sendtext("您成功注册为家长,顾问是".$users_xq['fullname'],$fromuser);
                            }
                        }
                    }else{
                        $this->sendtext("您之前关注过本平台",$fromuser);
                    }
            }
        }

    }

		//这里定义此模块进行消息订阅时的, 消息到达以后的具体处理过程, 请查看微擎文档来编写你的代码
    public function sendtext($text,$openid){
        global $_GPC, $_W;
        load() -> func('tpl');
        load() -> model('mc');
        $acc = WeAccount::create($_W['account']['acid']);
        $send = array("touser" =>$openid, "msgtype" => "text", "text" => array("content" => urlencode($text)));
        $res = $acc -> sendCustomNotice($send);
    }
}