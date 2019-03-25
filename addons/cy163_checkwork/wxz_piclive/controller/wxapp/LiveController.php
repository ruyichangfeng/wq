<?php
/**
 * 直播间数据接口
 * Created by PhpStorm.
 * User: lirui
 * Date: 2018/3/1
 * Time: 下午2:21
 */

class LiveController extends BaseController
{

    /**
    * 新建直播间
    */
    public function ActionCreateLive()
    {
        //$modelLive = new Model_WxzpicliveLive();
        // $modelShop = new Model_WxzSuperstoreShop();
        // $userShop = $modelShop->getUserShop($this->userId);
        $insertData = [
            'uniacid' => $this->uniacid,
            'shop_id' => $userShop['id'],
            'live_status' => 0,
            'name' => trim($this->_GPC['name']),
            'category1_id' => (int)$this->_GPC['category1_id'],
        ];
        if (!$this->isDefaultImg($this->_GPC['thumb'])) {
            $insertData['thumb'] = $this->_GPC['thumb'];
        }
        if (!$this->isDefaultImg($this->_GPC['cover'])) {
            $insertData['cover'] = $this->_GPC['cover'];
        }

        $player = $this->_GPC['player'];
        $player['player_source'] = $this->_GPC['curPlayType'];
        $insertData['player'] = serialize($player);
        $insertData['create_time'] = date('Y-m-d H:i:s');
        $liveId = $ret = $modelLive->add($insertData);

        if ($ret !== false) {
            //插入直播间商品
            $goodsIds = explode(',', $this->_GPC['checkedGoods']);
            foreach ($goodsIds as $goodsId) {
                $insertData = [
                    'live_id' => $ret,
                    'goods_id' => $goodsId,
                    'good_status' => 1,
                ];
                $modelLive->addLiveGoods($insertData);
            }

            //默认店长是主播
            $modelLiveAnchor = new BaseModel('wxz_superstore_live_anchor');
            $insertData = [
                'uniacid' => $this->uniacid,
                'live_id' => $ret,
                'user_id' => $this->userId,
                'create_time' => date('Y-m-d H:i:s'),
            ];
            $modelLiveAnchor->add($insertData);

            //阿里云播放器地址单独拼接
            if ($player['player_source'] == 5) {
                $playerRet = Model_WxzsuperstoreLive::getAliPlayerUrl($liveId);
                $player['push_url'] = $playerRet['push_url'];
                //默认开启回放
                $player['url'] = $playerRet['url'];
                $player['is_record'] = $playerRet['is_record'];
                $modelLive->setAliRecordConfig($liveId);
                $updateData = [
                    'player' => serialize($player),
                ];
                $modelLive->updateById($liveId, $updateData);
            }

            $this->ajaxSucceed();
        } else {
            $this->ajaxError('保存失败');
        }
    }

    /**
     * 获取直播间列表
     */
    public function ActionList()
    {
        $modelLive = new Model_WxzmultiroomLive();
        $condition = "uniacid={$this->uniacid} AND is_del=0";
        $list = $modelLive->getAll($condition, '*', 'teacher_id desc,sort desc,id desc');
        $this->ajaxSucceed('', $list);
    }

    /**
     * 直播详情页面
     */
    public function ActionDetail()
    {
        $result = [];
        $id = $this->_GPC['id'];
        $modelLive = new Model_WxzmultiroomLive();
        $modelUser = new Model_WxzmultiroomUser();

        $liveInfo = $modelLive->getById($id);

        $modelSetting = new Model_WxzmultiroomSetting();
        $copywriting = $modelSetting->getByType(3);

        $modelLiveTeacher = new BaseModel('wxz_multiroom_live_teacher_xref');
        $condition = "live_id={$id}";
        $liveTeacher = $modelLiveTeacher->getRow($condition);
        if ($liveTeacher) {
            $teacherInfo = $modelUser->getById($liveTeacher['teacher_id']);
        }
        $result['liveInfo'] = [
            'id' => $liveInfo['id'],
            'room_no' => $liveInfo['room_no'],
            'teacher_id' => $teacherInfo['weuid'],
            'name' => $liveInfo['name'],
            'cover' => tomedia($liveInfo['cover']),
        ];

        //文案
        $result['copywriting']['live_detail_chat_warning'] = $copywriting['live_detail_chat_warning'];

        //评论
        $comments = $modelLive->getLiveComment($id);
        foreach ($comments as $comment) {
            $liveComment = [
                'id' => $comment['id'],
                'fromAccountNick' => $comment['nickname'],
                'content' => $comment['content'],
            ];
            $result['comment'][] = $liveComment;
        }

        //礼物列表
        $model = new BaseModel('wxz_multiroom_gift');
        $order = 'sort desc,id DESC';

        $condition = "`uniacid`={$this->uniacid}";
        $giftList = $model->getAll($condition, 'id,name,pic,price', $order);
        foreach ($giftList as $k => $val) {
            $giftList[$k]['pic'] = tomedia($val['pic']);
        }

        $giftList = array_chunk($giftList, 10);
        foreach ($giftList as $k => $val) {
            $giftList[$k] = array_chunk($val, 5);
        }

        $result['gift'] = $giftList;

        $this->ajaxSucceed('', $result);
    }

    /**
     * 点赞效果
     */
    public function ActionLiveLike()
    {
        $liveId = (int)$this->_GPC['live_id'];
        $model = new Model_WxzmultiroomLive();
        $condition = "id={$liveId}";
        $model->incrColumn($condition, 'good_num');
        $this->ajaxSucceed();
    }

    /**
     * 获取直播间聊天配置
     */
    public function ActionGetChatConfig()
    {
        $model = new Model_WxzmultiroomSetting();
        $modelLive = new Model_WxzmultiroomLive();

        $data = $model->getByType(1);
        $dataRet = $data['data'];
        $data = [
            'sdk_appid' => '',
            'account_type' => '',
            'room_id' => '',
            'identifier' => '',
            'user_sig' => '',
        ];
        if ($dataRet) {
            $data = [
                'sdk_appid' => $dataRet['sdk_appid'],
                'account_type' => $dataRet['account_type'],
                'room_id' => $dataRet['room_id'],
                'identifier' => $dataRet['identifier'],
                'user_sig' => $modelLive->getUserSign(),
            ];
        }
        $this->ajaxSucceed('', $data);
    }

    /**
     * 更新在线人数
     */
    public function ActionUpdateRealNum()
    {
        $liveId = (int)$this->_GPC['id'];
        $realNum = (int)$this->_GPC['realNum'];

        $modelLive = new Model_WxzmultiroomLive();
//        file_put_contents("/www/web/hefei_hfwxz_com/public_html/wxapp/addons/wxz_multiroom/debug.log", var_export($liveId, true) . "\n", FILE_APPEND);
        $ret = $modelLive->updateById($liveId, ['real_num' => $realNum]);
        if ($ret) {
            $this->ajaxSucceed();
        } else {
            $this->ajaxError('更新失败');
        }
    }

    /**
     * 更新浏览人数
     * @param $liveInfo
     */
    public function updateView($liveInfo)
    {
        $modelLiveUser = new BaseModel('wxz_multiroom_live_user');
        $modelLive = new Model_WxzmultiroomLive();

        $roomInfo = $modelLive->apiGetPushers($liveInfo['room_no']);
        $realNum = (int)count($roomInfo['data']['pushers']);


        $condition = "user_id={$this->userId} AND live_id={$liveInfo['id']}";
        $liveUser = $modelLiveUser->getRow($condition);

        if ($liveUser) {
            if ($realNum) {
                $sqlLive = "update " . tablename('wxz_multiroom_live') . " set view_num=view_num+1,real_num={$realNum} where id={$liveInfo['id']}";
                $modelLiveUser->querySql($sqlLive);
            }

            $sqlLiveUser = "update " . tablename('wxz_multiroom_live_user') . " set view_num=view_num+1 where user_id={$this->userId} AND live_id={$liveInfo['id']}";
            $modelLiveUser->querySql($sqlLiveUser);
        } else {
            $insertLiveUser = [
                'uniacid' => $this->uniacid,
                'user_id' => $this->userId,
                'live_id' => $liveInfo['id'],
                'view_num' => 1,
            ];
            $insertData['create_time'] = date('Y-m-d H:i:s');
            $modelLiveUser->add($insertLiveUser);
            $sqlLive = "update " . tablename('wxz_multiroom_live') . " set view_num=view_num+1,real_num={$realNum}";
            $modelLiveUser->querySql($sqlLive);
        }
    }

    public function ActionEnterRoom()
    {
        $modelLive = new Model_WxzmultiroomLive();
        $modelUser = new Model_WxzmultiroomUser();

        $id = (int)$this->_GPC['id'];
        $info = $modelLive->getById($id);
        $userInfo = $modelUser->getById($this->userId, 'weuid');

        //判断是否是直播间老师
        $modelLiveTeacher = new BaseModel('wxz_multiroom_live_teacher_xref');
        $condition = "live_id={$id} AND teacher_id={$this->userId}";
        $isAnchor = $modelLiveTeacher->getCount($condition);

        //判断直播间人数
        if ($isAnchor) {
            $roomNo = $modelLive->apiCreateRoom($id, $userInfo['weuid'], $info['name']);

            $roomNo = $roomNo['data'];
            $modelLive->updateById($id, ['room_no' => $roomNo, 'teacher_id' => $userInfo['weuid']]);
            $this->ajaxSucceed('', ['room_no' => $roomNo]);
        } else {
            if ($info['teacher_id'] <= 0) {
                $this->ajaxError('主播不在，暂未开播');
            }
            //学生进入
            $this->ajaxSucceed('', ['room_no' => $info['room_no']]);
        }
    }

    /**
     * 离开直播间
     */
    public function ActionLeave()
    {
        $modelLiveUser = new BaseModel('wxz_multiroom_live_user');
        $modelLive = new Model_WxzmultiroomLive();
        $modelUser = new Model_WxzmultiroomUser();

        $id = $this->_GPC['id'];

        $liveInfo = $modelLive->getById($id);
//        $roomInfo = $modelLive->apiGetPushers($liveInfo['room_no']);

//        $realNum = count($roomInfo['data']['pushers']);

        $realNum = max(0, $liveInfo['real_num'] - 1);

        $sqlLive = "update " . tablename('wxz_multiroom_live') . " set real_num={$realNum} where id={$id}";
        $modelLiveUser->querySql($sqlLive);

        $modelLiveTeacher = new BaseModel('wxz_multiroom_live_teacher_xref');
        $condition = "live_id={$id} AND teacher_id={$this->userId}";
        $anchor = $modelLiveTeacher->getRow($condition);

        $userInfo = $modelUser->getById($anchor['teacher_id'], 'weuid');

        //老师下线操作
        if ($anchor && $liveInfo['teacher_id'] == $userInfo['weuid']) {
            $modelLive->updateById($id, ['teacher_id' => 0, 'real_num' => 0]);
        }

        $this->ajaxSucceed();
    }

    /**
     * 给老师发送礼物
     */
    public function ActionSendGift()
    {
        $giftId = (int)$this->_GPC['id'];
        $liveiId = (int)$this->_GPC['live_id'];
        $teacherId = (int)$this->_GPC['teacher_id'];

        $modelConsume = new BaseModel('wxz_multiroom_consume');
        $modelGift = new BaseModel('wxz_multiroom_gift');
        $modelUser = new Model_WxzmultiroomUser();

        $userInfo = $modelUser->getById($this->userId);
        $giftInfo = $modelGift->getById($giftId);
        $teacherInfo = $modelUser->getUserInfoByWeUid($teacherId);

        if ($userInfo['balance'] < $giftInfo['price']) {
            $this->ajaxError('账户余额不足，请到个人中心充值');
        }

        //插入消费记录
        $inserData = [
            'uniacid' => $this->uniacid,
            'user_id' => $this->userId,
            'teacher_id' => $teacherInfo['id'],
            'live_id' => $liveiId,
            'gift_id' => $giftId,
            'amount' => $giftInfo['price'],
            'type' => 2,
            'create_time' => date('Y-m-d H:i:s'),
        ];

        $modelConsume->add($inserData);

        //更新用户余额
        $condition = "id={$teacherInfo['id']}";
        $modelUser->incrColumn($condition, 'balance', (int)$giftInfo['price']);

        $condition = "id={$userInfo['id']}";
        $modelUser->reduceColumn($condition, 'balance', (int)$giftInfo['price']);
        $this->ajaxSucceed();
    }

    /**
     * 直播间扣费
     */
    public function ActionLiveDeduction()
    {
        $modelLive = new Model_WxzmultiroomLive();
        $modelConsume = new BaseModel('wxz_multiroom_consume');
        $modelUser = new Model_WxzmultiroomUser();
        $modelAgentTeacher = new BaseModel('wxz_multiroom_agent_teacher_xref');
        $modelLiveTeacher = new BaseModel('wxz_multiroom_live_teacher_xref');

        $userInfo = $modelUser->getById($this->userId);

        $id = (int)$this->_GPC['id'];

        $liveInfo = $modelLive->getById($id);

        $condition = "live_id={$id}";
        $liveTeacher = $modelLiveTeacher->getRow($condition);

        if (!$liveTeacher) {
            $this->ajaxError('直播间没有老师');
        }

        $teacherInfo = $modelUser->getById($liveTeacher['teacher_id']);//直播间老师信息

        if (!$liveInfo['teacher_id'] && ($userInfo['weuid'] != $teacherInfo['weuid'])) {
            $this->ajaxError('老师不在直播间');
        }

        //老师不扣费
        //老师
        if ($userInfo['weuid'] == $teacherInfo['weuid']) {
            $this->ajaxSucceed();
        }

        //免费
        if ($liveInfo['expend_minute'] <= 0) {
            $this->ajaxSucceed();
        }

        //结束时间未到不扣费
        $nowTime = time();
        $nowtTime = $nowTime;
        $condition = "user_id={$this->userId} AND live_id={$id} AND teacher_id={$liveInfo['teacher_id']} AND watch_end_time>'{$nowtTime}'";
        $consume = $modelConsume->getRow($condition, 'id,amount');

        if ($consume) {
            $this->ajaxSucceed();
        }

        //查看是否有前70分钟的观看记录，如果有则合并，
        $lastTime = $nowTime - 50;
        $condition = "user_id={$this->userId} AND live_id={$id} AND teacher_id={$liveInfo['teacher_id']} AND watch_end_time>='{$lastTime}'";
        $consume = $modelConsume->getRow($condition, 'id,amount');

        //余额不足
        if ($userInfo['balance'] < $liveInfo['expend_minute']) {
            $this->ajaxError('账户余额不足，请到个人中心充值');
        }
        if ($consume) {
            $update = [
                'watch_end_time' => time() + 60,
                'amount' => $consume['amount'] + $liveInfo['expend_minute'],
            ];
            $ret = $modelConsume->updateById($consume['id'], $update);
            $consumeId = $consume['id'];
        } else {
            $inseretData = [
                'uniacid' => $this->uniacid,
                'live_id' => $id,
                'user_id' => $this->userId,
                'watch_start_time' => time(),
                'watch_end_time' => time() + 60,
                'teacher_id' => $liveInfo['teacher_id'],
                'amount' => $liveInfo['expend_minute'],
                'type' => 1,
                'create_time' => date('Y-m-d H:i:s'),
            ];
            $ret = $modelConsume->add($inseretData);
            $consumeId = $ret;
        }

        //扣除用户积分
        $condition = "id={$this->userId}";
        $modelUser->reduceColumn($condition, 'balance', $liveInfo['expend_minute']);

        if ($ret) {
            //分配佣金
            $type = 6;
            $model = new Model_WxzmultiroomSetting();
            $info = $model->getByType($type);
            if ($info) {
                $teacherInfo = $modelUser->getUserInfoByWeUid($liveInfo['teacher_id']);
                if ($teacherInfo) {
                    $amountTeacher = $info['teacher'] / 100 * $liveInfo['expend_minute'];
                    $amountAgent = $info['agent'] / 100 * $liveInfo['expend_minute'];

                    $modelCommissionLog = new BaseModel('wxz_multiroom_commission_log');
                    $commissionLog = [
                        'uniacid' => $this->uniacid,
                        'user_id' => $this->userId,
                        'live_id' => $id,
                        'consume_id' => $consumeId,
                        'teacher_id' => $teacherInfo['id'],
                        'teacher_money' => $amountTeacher,
                    ];

                    $updateData = [
                        'balance' => $teacherInfo['balance'] + $amountTeacher,
                        'total_money' => $teacherInfo['total_money'] + $amountTeacher,
                    ];
                    $modelUser->updateById($teacherInfo['id'], $updateData);

                    //经纪人
                    $condition = "teacher_id={$teacherInfo['id']}";
                    $teacherAgent = $modelAgentTeacher->getRow($condition, 'id,agent_id');

                    if ($teacherAgent) {
                        $agentInfo = $modelUser->getById($teacherAgent['agent_id']);
                        $updateData = [
                            'balance' => $agentInfo['balance'] + $amountAgent,
                            'total_money' => $agentInfo['total_money'] + $amountAgent,
                        ];
                        $modelUser->updateById($teacherAgent['agent_id'], $updateData);

                        $commissionLog['agent_id'] = (int)$teacherAgent['agent_id'];
                        $commissionLog['agent_money'] = $amountAgent;
                    }
                    $commissionLog['create_time'] = date('Y-m-d H:i:s');

                    //判断是否存在
                    $condition = "consume_id={$consumeId}";
                    $commissionLogInfo = $modelCommissionLog->getRow($condition);
                    if ($commissionLogInfo) {
                        $commissionLog['teacher_money'] = $commissionLogInfo['teacher_money'] + $amountTeacher;
                        $commissionLog['agent_money'] = $commissionLogInfo['agent_money'] + $amountAgent;
                        $modelCommissionLog->updateById($commissionLogInfo['id'], $commissionLog);
                    } else {
                        $modelCommissionLog->add($commissionLog);
                    }
                }
            }
            $this->ajaxSucceed();
        } else {
            $this->ajaxError('保存失败');
        }
    }

    /**
     *  获取分类列表
     */
    public function ActionGetList()
    {
        $cid = (int)$this->_GPC['cid'];
        $modelLive = new Model_WxzmultiroomLive();
        $modelUser = new Model_WxzmultiroomUser();
        $modelLiveTeacher = new BaseModel('wxz_multiroom_live_teacher_xref');

        $condition = "category_id={$cid} AND is_del=0";
        $list = $modelLive->getAll($condition, '*', 'teacher_id desc,sort desc');
        foreach ($list as $k => $v) {
            $list[$k]['thumb'] = tomedia($v['thumb']);
            $condition = "live_id={$v['id']}";
            $liveTeacher = $modelLiveTeacher->getRow($condition);
            if ($liveTeacher) {
                $list[$k]['teacher_info'] = $modelUser->getById($liveTeacher['teacher_id'], 'id,username,avatar,intro');
                $list[$k]['teacher_info']['avatar'] = tomedia($list[$k]['teacher_info']['avatar']);
            }
        }
        $this->ajaxSucceed('', $list);
    }

    /**
     * 获取分类列表
     */
    public function ActionGetCategorys()
    {
        $modelCategory = new BaseModel('wxz_multiroom_category');
        $condition = "uniacid={$this->uniacid} AND is_del=0";
        $categorys = $modelCategory->getAll($condition);
//        $categorys = wxzFormatArrayByKey($categorys, 'id');
        $this->ajaxSucceed('', $categorys);
    }

}