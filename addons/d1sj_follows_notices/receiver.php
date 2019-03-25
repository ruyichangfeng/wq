<?php
/**
 * 微信用户关注发送消息管理员模块订阅器
 *
 * @author
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class D1sj_follows_noticesModuleReceiver extends WeModuleReceiver
{
    public function receive()
    {
        global $_W, $_GPC;
        $type = $this->message['type'];
        $message = $this->message;
        //这里定义此模块进行消息订阅时的, 消息到达以后的具体处理过程, 请查看微擎文档来编写你的代码
        if ($this->message['event'] == 'subscribe') {
            $message = $this->message;
            $openid = $this->message['from'];
            //记录到关注表,先查询是否有数据，更新没有添加

            $user = $this->getuser($openid);

            $manager = $this->module['config']['openid'];
            if (!empty($manager)) {
                $template_id = $this->module['config']['template_id'];
                $res = $this->mubanxiaoxi($manager, $template_id, '', $user['nickname'], '');
            }

        }
    }

    function getAccessToken2()
    {
        global $_W, $_GPC;
        load()->classs('weixin.account');
        $accObj = WeixinAccount::create(3);
        $access_token = $accObj->fetch_token();
        return $access_token;
    }

    function getAccessToken1()
    {
        global $_W, $_GPC;
        load()->classs('weixin.account');
        $accObj = WeixinAccount::create($_W['uniacid']);
        $access_token = $accObj->fetch_token();
        return $access_token;
    }

    function getuser($openid)
    {
        global $_W, $_GPC;
        //查询用户的unionid
        $access_token = $this->getAccessToken1();
        if (!$access_token) {
            return false;
        }
        $oauth2_url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=" . $access_token . "&openid=" . $openid . "&lang=zh_CN ";
        $content = ihttp_get($oauth2_url);
        $info = @json_decode($content['content'], true);
        if (empty($info) || !is_array($info) || empty($info['openid'])) {
            return false;
        }
        return $info;
    }

    //发送模板消息
    function mubanxiaoxi($toopenid, $template_id, $link, $nickname, $time)
    {
        $wxIns = WeiXinAccount::create();
        $data = array(
            "first" => array(
                "value" => "新的用户关注",
                "color" => "#173177",
            ),
            "keyword1" => array(
                "value" => $nickname,
                "color" => "#173177",
            ),
            "keyword2" => array(
                "value" => date('Y-m-d H:i:s', time()),
                "color" => "#173177",
            ),
        );
        return $wxIns->sendTplNotice($toopenid, $template_id, $data);

    }


}