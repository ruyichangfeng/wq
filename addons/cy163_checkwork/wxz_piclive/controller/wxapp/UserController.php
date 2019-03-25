<?php

/**
 *
 * 用户相关
 */
class UserController extends BaseController
{
    /**
     * 更新本地用户信息
     */
    public function ActionSynUser()
    {
        global $_GPC, $_W;
        $uid = (int)$this->_GPC['uid'];
        $userInfo = mc_fansinfo($uid);
        if (!$userInfo) {
            $this->ajaxError('微擎用户不存在');
        }
        $updateData = [
            'uniacid' => $userInfo['uniacid'],
            'weuid' => $userInfo['uid'],
            'unionid' => $userInfo['unionid'],
            'openid' => $userInfo['openid'],
            'nickname' => $userInfo['nickname'],
            'city' => $userInfo['tag']['city'],
            'gender' => $userInfo['gender'],
            'avatar' => $userInfo['avatar'],
        ];

        $modelUser = new Model_WxzmultiroomUser();
        $userInfo = $modelUser->synUser($updateData);

        $this->userId = $userInfo['id'];
        $this->userNickName = $userInfo['nickname'];
        $_SESSION['wxz_multiroom_user_id'] = $this->userId;
        $_SESSION['wxz_multiroom_user_nickname'] = $this->userNickName;

        $this->ajaxSucceed();
    }

    /**
     * 添加评论
     */
    public function ActionAddComment()
    {
        $liveId = $this->_GPC['live_id'];
        $content = $this->_GPC['content'];
        $nickname = $this->_GPC['nickname'];
        $type = (int)$this->_GPC['type'];
        $userId = $this->userId;
        if (!$content) {
            $this->ajaxError('评论内容不能为空!');
        }
        if (!$userId) {
            $this->ajaxError('用户未登录');
        }

        $insertData = [
            'uniacid' => $this->uniacid,
            'user_id' => $this->userId,
            'nickname' => $nickname,
            'live_id' => $liveId,
            'type' => $type,
            'content' => $content,
        ];
        $modelUser = new Model_WxzmultiroomUser();
        $modelUser->addComment($insertData);
        $this->ajaxSucceed();
    }


    /**
     * 更新用户
     */
    public function ActionCollectFormId()
    {
        $formid = $this->_GPC['formid'];
        $modelUser = new Model_WxzmultiroomUser();

        $updateData = ['formid' => $formid];

        $ret = $modelUser->collectFormId($this->userId, $formid);

        if ($ret !== false) {
            $this->ajaxSucceed();
        } else {
            $this->ajaxError('更新失败');
        }
    }

    /**
     * 用户申请提现
     */
    public function ActionWithdraw()
    {
        $model = new BaseModel('wxz_multiroom_apply_withdraw');
        $modelUser = new Model_WxzmultiroomUser();
        $modelOrder = new Model_WxzmultiroomOrder();

        //查看是否有正在审核的
        $condition = "user_id={$this->userId} AND wstatus=1";
        $count = $model->getCount($condition);
        if ($count) {
            $this->ajaxError('提现审核中');
        }
        //查看余额是否>1
        $userInfo = $modelUser->getById($this->userId);
        if ($userInfo['balance'] < 100) {
            $this->ajaxError('余额不足，提现最少金额100积分');
        }

        $orderNo = $modelOrder->generateOrderNo();

        //插入提现记录
        $insertData = [
            'uniacid' => $this->uniacid,
            'order_no' => $orderNo,
            'user_id' => $this->userId,
            'money' => $userInfo['balance'],
            'create_time' => date('Y-m-d H:i:s'),
        ];

        $ret = $model->add($insertData);
        if ($ret) {
            $this->ajaxSucceed();
        } else {
            $this->ajaxError('插入失败');
        }
    }

    /**
     * 获取个人中心需要的数据
     */
    public function ActionPersonInfo()
    {
        $result = [];
        //获取待付款和待收货数量
        $modelUser = new Model_WxzmultiroomUser();


        $memberInfo = $modelUser->getById($this->userId);
        $result['memberInfo'] = $memberInfo;

        $modelLiveTeacher = new BaseModel('wxz_multiroom_live_teacher_xref');
        $condition = "teacher_id={$this->userId}";

        $liveTeacher = $modelLiveTeacher->getRow($condition);
        $result['memberInfo']['live_id'] = $liveTeacher['live_id'];

//        $result['memberInfo']['balance'] = number_format($memberInfo['balance'] / 100, 2, '.', '');
//        $result['memberInfo']['total_money'] = number_format($memberInfo['total_money'] / 100, 2, '.', '');
//        $result['memberInfo']['withdraw_money'] = number_format(($memberInfo['total_money'] - $memberInfo['balance']) / 100, 2, '.', '');
        $this->ajaxSucceed('', $result);
    }

    /**
     * 老师修改直播间价格
     */
    public function ActionTeacherSetPrice()
    {
        $modelLiveTeacher = new BaseModel('wxz_multiroom_live_teacher_xref');
        $modelLive = new Model_WxzmultiroomLive();

        $expendMinute = (int)$this->_GPC['expend_minute'];

        $condition = "teacher_id={$this->userId}";
        $teacherLives = $modelLiveTeacher->getAll($condition);
        if ($teacherLives) {
            $liveIds = array_column($teacherLives, 'live_id');
            $condition = "id in(" . implode(',', $liveIds) . ")";
            $updateData = [
                'expend_minute' => $expendMinute,
            ];
            $ret = $modelLive->update($condition, $updateData);
            if ($ret) {
                $this->ajaxSucceed();
            } else {
                $this->ajaxError('保存失败');
            }
        }

        $this->ajaxSucceed();
    }

    /**
     * 申请成为老师
     */
    public function ActionApplyTeacher()
    {
        $modelapplyTeacher = new BaseModel('wxz_multiroom_apply_teacher');

        //查看是否有在审核的
        $condition = "user_id={$this->userId} AND wstatus=1";
        $exists = $modelapplyTeacher->getCount($condition);
        if ($exists) {
            $this->ajaxError('审核中，请耐心等待');
        }

        $insertData = [
            'uniacid' => $this->uniacid,
            'category_id' => (int)$this->_GPC['category_id'],
            'user_id' => $this->userId,
            'username' => trim($this->_GPC['username']),
            'mobile' => trim($this->_GPC['mobile']),
            'agent_mobile' => trim($this->_GPC['agent_mobile']),
            'intro' => trim($this->_GPC['intro']),
            'live_name' => trim($this->_GPC['live_name']),
            'live_desc' => trim($this->_GPC['live_desc']),
            'expend_minute' => (int)$this->_GPC['expend_minute'],
            'create_time' => date('Y-m-d H:i:s'),
        ];
        $ret = $modelapplyTeacher->add($insertData);
        if ($ret) {
            $this->ajaxSucceed();
        } else {
            $this->ajaxError('保存失败');
        }
    }

    /**
     * 获取老师房间资料
     */
    public function ActionGetLiveInfo()
    {
        $liveInfo = [];
        $modelLive = new Model_WxzmultiroomLive();
        $modelUser = new Model_WxzmultiroomUser();

        $modelLiveTeacher = new BaseModel('wxz_multiroom_live_teacher_xref');

        $condition = "teacher_id={$this->userId}";
        $row = $modelLiveTeacher->getRow($condition);
        if ($row) {
            $liveInfo = $modelLive->getById($row['live_id']);
        }

        $liveInfo['user_info'] = $modelUser->getById($this->userId);

        $this->ajaxSucceed('', $liveInfo);
    }

    public function ActionUserEditLive()
    {
        $modelLive = new Model_WxzmultiroomLive();
        $modelUser = new Model_WxzmultiroomUser();

        $modelLiveTeacher = new BaseModel('wxz_multiroom_live_teacher_xref');

        $condition = "teacher_id={$this->userId}";
        $row = $modelLiveTeacher->getRow($condition);

        if ($row) {

            $videoNum = 3;
            $video_intro = [];
            for ($i = 1; $i <= $videoNum; $i++) {
                if ($this->_GPC["video_intro{$i}"] != 'undefined') {
                    $video_intro[] = $this->_GPC["video_intro{$i}"];
                }
            }


            $saveData = [
                'name' => trim($this->_GPC['live_name']),
                'desc' => trim($this->_GPC['live_desc']),
                'video_intro' => implode(';', $video_intro),
                'category_id' => (int)$this->_GPC['category_id'],
                'expend_minute' => (int)$this->_GPC['expend_minute'],
            ];
            $modelLive->updateById($row['live_id'], $saveData);

            $intro = trim($this->_GPC['intro']);
            $modelUser->updateById($this->userId, ['intro' => $intro]);
        }
        $this->ajaxSucceed();
    }

    /**
     * 获取老师介绍数据
     */
    public function ActionGetTeacherInfo()
    {
        $result = [];
        $modelUser = new Model_WxzmultiroomUser();
        $modelLive = new Model_WxzmultiroomLive();

        $modelCategory = new BaseModel('wxz_multiroom_category');
        $modelConsume = new BaseModel('wxz_multiroom_consume');
        $modelLiveTeacher = new BaseModel('wxz_multiroom_live_teacher_xref');

        $teacherId = (int)$this->_GPC['teacher_id'];

        $userInfo = $modelUser->getById($teacherId);

        //获取rensh人数
        $condition = "uniacid={$this->uniacid} AND teacher_id={$teacherId} AND type=1";
        $consult = $modelConsume->getRow($condition, 'count(DISTINCT `user_id`) num');
        $consult = $consult['num'];

        //获取点赞数
        $condition = "teacher_id={$teacherId}";
        $liveTeacher = $modelLiveTeacher->getRow($condition, 'live_id');
        $liveId = $liveTeacher['live_id'];

        $liveInfo = $modelLive->getById($liveId, 'good_num,expend_minute,`desc`,category_id,video_intro');
        $goodNum = $liveInfo['good_num'];

        $category = $modelCategory->getById($liveInfo['category_id']);
        //获取打赏数
        $condition = "uniacid={$this->uniacid} AND teacher_id={$teacherId} AND type=2";
        $reward = $modelConsume->getRow($condition, 'count(DISTINCT `user_id`) num');
        $reward = $reward['num'];

        $result = [
            'username' => $userInfo['username'],
            'avatar' => $userInfo['avatar'],
            'intro' => $userInfo['intro'],
            'consult' => $consult,
            'live_id' => $liveId,
            'expend_minute' => $liveInfo['expend_minute'],
            'live_desc' => $liveInfo['desc'],
            'category_name' => $category['name'],
            'reward' => $reward,
            'good_num' => $goodNum,
            'video_intro' => [],
            'city' => $userInfo['city'],
        ];
        if ($liveInfo['video_intro']) {
            $result['video_intro'] = explode(';', $liveInfo['video_intro']);
        }
        $this->ajaxSucceed('', $result);
    }
}