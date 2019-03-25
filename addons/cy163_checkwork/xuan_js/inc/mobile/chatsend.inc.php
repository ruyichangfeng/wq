<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;
$uidopenid=m('member')->get_uidopenid();
        $chat_message = $_GPC['chat_message'];
        $chat_openid = $_GPC['chat_openid'];
        $type = $_GPC['type'];

        if($type == 'album'){ 
            $media_ids = $chat_message;

            $acc = WeAccount::create($_W['acid']);
            $file=$acc->downloadMedia(array('type'=>'image','media_id'=>$media_ids));

            $msg = array();
            
            $msg['circle_id'] = talkSign($uidopenid['uid'], $chat_openid);
            $msg['from_user_id'] = $uidopenid['uid'];
            $msg['to_user_id'] = $chat_openid;
            $msg['data'] = $file;
            $msg['readed'] = 0;
            $msg['type'] = 'album';
            $msg['created_at'] = time();
            $res = pdo_insert('xuan_js_chat', $msg);
            

        }elseif($type == 'text'){
            $msg = array();
            $msg['circle_id'] = talkSign($uidopenid['uid'], $chat_openid);
            $msg['from_user_id'] = $uidopenid['uid'];
            $msg['to_user_id'] = $chat_openid;
            $msg['data'] = $chat_message;
            $msg['readed'] = 0;
            $msg['type'] = 'text';
            $msg['created_at'] = time();
            $res = pdo_insert('xuan_js_chat', $msg);
        }elseif($type == 'item'){
            $goods_id = $_GPC['chat_message'];

            $goods=m('goods')->getone($goods_id);
            $imgk=explode('@',$goods['img']);
            if ($goods['type']==1) {
               $price=$goods['price']; 
            }else{
               $price=$goods['sprice'];
            }
            $message=array('title'=>$goods['title'],'cover'=>$imgk['0'],'price'=>$price,'id'=>$goods['id']);
            $msg = array();
            $msg['circle_id'] = talkSign($uidopenid['uid'], $chat_openid);
            $msg['from_user_id'] = $uidopenid['uid'];
            $msg['to_user_id'] = $chat_openid;
            $msg['data'] = json_encode($message);
            $msg['readed'] = 0;
            $msg['type'] = 'item';
            $msg['created_at'] = time();
            $res = pdo_insert('xuan_js_chat', $msg);
        }
 
        if($res){
            //pdo_update('sunshine_huayue_chat', array('refresh_time' => date("Y-m-d H:i:s")), array('uniacid' => $_W['uniacid'], 'talk_sign' => $msg['talk_sign']));
            //$this -> sendNoticeTpl($chat_openid, $msg['chat_message'], $_W['siteroot'] . 'app/' . $this -> createMobileUrl('messagebox'));
            $from=mc_fetch($uidopenid['uid']);   
            $data  = array(
                        "first"=>array( "value"=> '您的聊天有新回复了！'),
                        "keyword1"=>array('value' => "回复人:".$from['nickname']),
                        "keyword2"=>array('value' => "回复"),
                        "remark"=>array('value' => "点击查看"),
                );

            $user=pdo_fetch('select openid,uid from '.tablename('mc_mapping_fans').' where uid='.$chat_openid);

            $this->sendtixing($user['openid'],'xiaoxi',$data,$this->createMobileUrl('chat',array('op'=>'xiaoxi')));
            echo json_encode(array('res' => '100', 'msg' => 'success'));
        }

function talkSign($openid_a,$openid_b)
	{
		if(strcmp($openid_a,$openid_b) >= 0)
		{
			return $openid_a.":".$openid_b;
		}
		else
		{
			return $openid_b.":".$openid_a;
		}
	}