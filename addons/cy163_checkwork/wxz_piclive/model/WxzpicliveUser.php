<?php

/**
 * 用户model
 * Class WxzpicliveUser
 */
class WxzmultiroomUser extends BaseModel
{
    public $table = 'wxz_piclive_user';


    /**
     * 通过openid 获取用户信息
     */
    public function getUserInfoByOpenid($openId, $field = '*')
    {
        if (!$openId) {
            return false;
        }

        $condition = "uniacid={$this->uniacid} AND openid='{$openId}'";

        return $this->getRow($condition, $field, 'id asc');
    }

    /**
     * 根据微擎id获取用户信息
     * @param $weuid
     * @param string $field
     * @return bool|mixed
     */
    public function getUserInfoByWeUid($weuid, $field = '*')
    {
        if (!$weuid) {
            return false;
        }

        $condition = "uniacid={$this->uniacid} AND weuid='{$weuid}'";

        return $this->getRow($condition, $field, 'id asc');
    }

    /**
     * 更新用户信息
     * 返回用户id
     * @param $userInfo
     */
    public function updateUserInfo($userInfo)
    {
        $result = 0;

        if (!$userInfo['weuid']) {
            return false;
        }

        $exists = $this->getUserInfoByWeUid($userInfo['weuid'], 'id');

        if ($exists) {
            $this->updateById($exists['id'], $userInfo);
            $result = $exists['id'];
        } else {
            $userInfo['share_user_id'] = (int)$this->_GPC['share_user_id'];
            $userInfo['create_time'] = date('Y-m-d H:i:s');
            $result = $this->add($userInfo, true);
        }
        return $result;
    }

    /**
     * 同步微擎表用户
     * @param $weuserInfo
     */
    public function synUser($updateData = '')
    {
        if (!$updateData) {
            $weUserInfo = mc_fansinfo($this->_W['openid']);
            if (!$weUserInfo['openid']) {
                return false;
            }
            $updateData = array(
                'uniacid' => $this->uniacid,
                'weuid' => $weUserInfo['uid'],
                'unionid' => $weUserInfo['unionid'],
                'openid' => $weUserInfo['openid'],
                'nickname' => $weUserInfo['nickname'],
                'avatar' => $weUserInfo['avatar'],
                'gender' => $weUserInfo['gender'],
                'city' => $weUserInfo['tag']['city'],
            );
        }

        $updateData['id'] = $this->updateUserInfo($updateData);
        return $updateData;
    }

    /**
     * 更改用户关注状态状态
     * @param $userId
     * @param $anchorId
     *
     */
    public function changeUserFollow($userId, $anchorId)
    {
        $result = true;
        if (!$userId || !$anchorId) {
            return false;
        }

        $modelFollow = new BaseModel('wxz_multiroom_user_follow');

        $condition = "user_id={$userId} AND anchor_id={$anchorId}";

        $follow = $modelFollow->getRow($condition);
        if (!$follow) {
            $insertData = [
                'uniacid' => $this->uniacid,
                'user_id' => $userId,
                'anchor_id' => $anchorId,
                'follow_status' => 1,
            ];
            $insertData['create_time'] = date('Y-m-d H:i:s');
            $modelFollow->add($insertData);
            //更改用户表示
            $result = true;
        } else {
            if ($follow['follow_status'] == 1) {
                $updateData = [
                    'follow_status' => 2,
                ];
                $modelFollow->updateById($follow['id'], $updateData);
                $result = false;
            } elseif ($follow['follow_status'] == 2) {
                $updateData = [
                    'follow_status' => 1,
                ];
                $modelFollow->updateById($follow['id'], $updateData);
                $result = true;
            }
        }

        //更新用户关注数，粉丝数量
        if ($result) {
            $sql1 = "update " . tablename('wxz_multiroom_user') . " set follow_num=follow_num+1 where id={$userId}";
            $sql2 = "update " . tablename('wxz_multiroom_user') . " set follower_num=follower_num+1 where id={$anchorId}";
        } else {
            $sql1 = "update " . tablename('wxz_multiroom_user') . " set follow_num=follow_num-1 where id={$userId}";
            $sql2 = "update " . tablename('wxz_multiroom_user') . " set follower_num=follower_num-1 where id={$anchorId}";
        }
        $modelFollow->querySql($sql1);
        $modelFollow->querySql($sql2);
        return $result;
    }

    /**
     * 修改直播间用户状态
     * @param $liveId
     * @param $userId
     * @param $status
     * @return bool
     */
    public function updateLiveUserStatus($liveId, $userId, $status)
    {
        if (!$liveId || !$userId) {
            return false;
        }

        $modelLiveUser = new BaseModel('wxz_multiroom_live_user');

        $condition = "user_id={$userId} AND live_id={$liveId}";
        $row = $modelLiveUser->getRow($condition, 'user_status');

        if ($row['user_status'] != 2) {
            $modelLiveUser->update($condition, ['user_status' => $status]);
        }
    }

    /**
     * 获取用户收货地址
     * @param $userId
     */
    public function getUserAddress($userId)
    {
        if (!$userId) {
            return false;
        }

        $modelUserAddress = new BaseModel('wxz_multiroom_user_address');
        $condition = "user_id={$userId}";
        return $modelUserAddress->getRow($condition);
    }

    /**
     * 根据地址详细，获取收货地址
     */
    public function getUserAddressByDetail($contact, $mobile, $address)
    {
        if (!$contact || !$mobile || !$address) {
            return;
        }
        $modelUserAddress = new BaseModel('wxz_multiroom_user_address');

        $condition = "contact='{$contact}' AND mobile='{$mobile}' AND address='{$address}'";
        return $modelUserAddress->getRow($condition);
    }

    /**
     * 设置默认地址
     * @userId 用户id
     * @$defaultId 默认地址id
     */
    public function setAddressDefault($userId, $defaultId)
    {
        if (!$userId || !$defaultId) {
            return;
        }
        $modelUserAddress = new BaseModel('wxz_multiroom_user_address');

        $condition = "user_id={$userId}";
        $updateData = [
            'is_default' => 0,
        ];
        $modelUserAddress->update($condition, $updateData);
        $updateData1 = [
            'is_default' => 1,
        ];
        $modelUserAddress->updateById($defaultId, $updateData1);
    }

    /*
     * 添加评论
     */
    public function addComment($data)
    {
        $modelUserComment = new BaseModel('wxz_multiroom_comment');
        $data['create_time'] = date('Y-m-d H:i:s');
        return $modelUserComment->add($data);
    }

    /**
     * 搜集用户formid
     * @param $userId
     * @param $formid
     */
    public function collectFormId($userId, $formid)
    {
        $modelUserFormid = new BaseModel('wxz_multiroom_user_formid');
        if ($formid == 'the formId is a mock one') {
            return false;
        }

        $insertData = [
            'uniacid' => $this->uniacid,
            'user_id' => $userId,
            'formid' => $formid,
            'create_time' => date('Y-m-d H:i:s'),
        ];

        $ret = $modelUserFormid->add($insertData);
        return $ret;
    }

    /**
     *
     * @param string $mobile
     * @return array
     */
    public function getByMobile($mobile)
    {
        if (!$mobile) {
            return false;
        }
        $condition = "mobile='{$mobile}'";
        return $this->getRow($condition);
    }
}