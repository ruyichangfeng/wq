<?php
/**
 * 传图抽奖模块处理程序
 *
 * @author wuyou8888
 * @url 
 */
defined('IN_IA') or exit('Access Denied');

class Chuantu_chuantuModuleProcessor extends WeModuleProcessor {
	public function respond() {
        global $_W;
        $setting = $this -> module['config'];
        $now = TIMESTAMP;
        $exp = $setting['endtime'];
        if($now<$setting['starttime']){
            return $this->respText('活动还未开始');
        }
        $url  = $this->buildSiteUrl($this->createMobileurl('index'));
        $lingqu = "<a href='$url'>点击领取</a>";
        //return $this->respText($lingqu);
        if($now<=$exp){

            $user = pdo_fetch('SELECT * from '.tablename('chuantu_user')." where openid='$_W[openid]' and uniacid=$_W[uniacid]");
            if(empty($user)){
                $access_token = WeAccount::token();
                $openid = $_W['openid'];
                $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
                $return = ihttp_get($url);
                $content =$return['content'];
                $content = json_decode($content,true);
                $user['uniacid'] = $_W['uniacid'];
                $user['openid'] = $_W['openid'];
                $user['json_nickname'] = json_encode($content['nickname']);
                $user['nickname'] = $content['nickname'];
                $user['unionid'] = $content['unionid'];
                $user['sex'] =  $content['sex'];
                $user['city'] =  $content['city'];
                $user['province'] =  $content['province'];
                $user['country'] =  $content['country'];
                $user['headimgurl'] =  $content['headimgurl'];
                $user['picurl'] = $this->message['picurl'];
                $user['createtime'] = TIMESTAMP;
                if($user['openid']){
                    $result = pdo_insert('chuantu_user', $user);
                }
            }
            $count = pdo_fetchcolumn('SELECT count(*) from '.tablename('chuantu_upload')." where openid='$_W[openid]' and uniacid=$_W[uniacid]");
            if($count>=$setting['total']){
                $join = pdo_fetchAll('SELECT bianhao FROM '.tablename('chuantu_upload')." where openid='$_W[openid]' and uniacid=$_W[uniacid] order by bianhao asc ");
                foreach ($join as $val) {
                    $joins[] = $val['bianhao'];
                }
                return $this->respText("你已使用完$setting[total]次机会，请以后有机会再参与啦，你参与的楼层为：".implode(',', $joins));
            }

            //传图
            load()->func('file');
            load()->func('communication');
            $media['type'] = 'image';
            $media['media_id'] = $this->message['mediaid'];
            $acc = WeAccount::create();
            $avatar = $acc -> downloadMedia($media);
            $upload['picurl'] = '/' . $avatar;
            $upload['createtime'] = TIMESTAMP;
            $upload['uniacid'] = $_W['uniacid'];
            $upload['openid'] = $_W['openid'];
            //获取最后编号
            $last = pdo_fetch('SELECT bianhao FROM '.tablename('chuantu_upload')." where uniacid=$_W[uniacid] order by bianhao desc ");
            if($last['bianhao']>=$setting['floor_total']){
                $respText = '啊哦，您来得太晚，电影票已经抢完了';
                return $this->respText( $respText);
            }
            if($last[bianhao]<=0){
                $upload['bianhao'] =1;
            }else{
                $upload['bianhao'] = $last['bianhao']+1;
            }

            $result = pdo_insert('chuantu_upload', $upload);
            $respText = str_replace('#bianhao#', $upload['bianhao'], $setting['comment']);
            $respText = str_replace('#url#', $lingqu, $respText);
            return $this->respText( $respText);
        }else{
            return $this->respText('活动已经超过时间了！');
        }
    }
}