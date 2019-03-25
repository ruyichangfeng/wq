<?php
/**
 * @author
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class Wg_CallModule extends WeModule {

    public $replies = array();
    public function fieldsFormDisplay($rid = 0) {

    }
    
    public function fieldsFormValidate($rid = 0) {

    }
    
    public function fieldsFormSubmit($rid = 0) {
        if(empty($this->replies)){
            return true;   //如果不是文章类型，直接return
        }
        $sql = 'SELECT `id` FROM ' . tablename($this->tablename) . " WHERE `rid` = :rid";
        $replies = pdo_fetchall($sql, array(':rid' => $rid), 'id');
        $replyids = array_keys($replies);
        $indexs = array();
        foreach($this->replies as &$group) {
            $parent_id = -1;
            foreach($group as $reply) {
                if($parent_id <= 0) {
                    if($reply['parent_id'] == 0) {
                        $parent_id = $reply['id'];
                    } elseif($reply['parent_id'] > 0) {
                        $parent_id = $reply['parent_id'];
                    }
                }
            }
            if($parent_id == -1) {
                                $i = 0;
                foreach($group as $reply) {
                    if(!$i) {
                        $i++;
                        $reply['rid'] = $rid;
                        $reply['parent_id'] = 0;
                        pdo_insert($this->tablename, $reply);
                        $parent_id = pdo_insertid();
                    } else {
                        $reply['parent_id'] = $parent_id;
                        $reply['rid'] = $rid;
                        pdo_insert($this->tablename, $reply);
                    }
                }
                pdo_update($this->tablename, array('parent_id' => 0), array('id' => $parent_id));
            } else {
                $i = 0;
                foreach($group as $reply) {
                    if(!$i) {
                        $new_parent_id = $reply['id'];
                        $i++;
                    }
                    $arr[] = $reply['id'];
                    $reply['parent_id'] = $parent_id;
                    if (in_array($reply['id'], $replyids)) {
                        pdo_update($this->tablename, $reply, array('id' => $reply['id']));
                        $index = array_search($reply['id'], $replyids);
                        unset($replyids[$index]);
                    } else {
                        $reply['rid'] = $rid;
                        pdo_insert($this->tablename, $reply);
                    }
                }
                if(!in_array($parent_id, $arr)) {
                    $parent_id = $new_parent_id;
                }
                pdo_update($this->tablename, array('parent_id' => $new_parent_id), array('parent_id' => $parent_id));
                pdo_update($this->tablename, array('parent_id' => 0), array('id' => $new_parent_id));
            }
        }

        if (!empty($replyids)) {
            $replies = array_values($replyids);
            $replyids = implode(',', $replyids);
            $sql = 'DELETE FROM '. tablename($this->tablename) . " WHERE `id` IN ({$replyids})";
            pdo_query($sql);
        }
        return true;
    }
    
    public function ruleDeleted($rid = 0) {
        pdo_delete($this->tablename, array('rid' => $rid));
        return true;
    }
    public function settingsDisplay($settings) {
        global $_W, $_GPC;
        load()->func('file');
       //点击模块设置时将调用此方法呈现模块设置页面，$settings 为模块设置参数, 结构为数组。这个参数系统针对不同公众账号独立保存。
        //在此呈现页面中自行处理post请求并保存设置参数（通过使用$this->saveSettings()来实现）
        if (checksubmit()) {
            $data = $_GPC['data'];
            //字段验证, 并获得正确的数据$data
            if (empty($data['dailitiaojian'])) {
                message('请选择成为代理条件');
            }
            if (empty($data['querenshouhuo'])) {
                message('自动确认收货时间，不能为空');
            }
            if ($data['dailitiaojian'] == 2 && empty($data['goumaidanshu'])) {
                message('购买单数不能为空');
            }
            if ($data['dailitiaojian'] == 3 && empty($data['goumaiqianshu'])) {
                message('购买钱数不能为空');
            }
            if (!empty($_FILES['apiclient_cert_file']['name'])) {
                $file = file_upload($_FILES['apiclient_cert_file']);
                if (is_error($file)) {
                    message('apiclient_cert证书保存失败, 请保证目录可写' . $file['message']);
                } else {
                    $_GPC['apiclient_cert'] = empty($file['path']) ? trim($_GPC['apiclient_cert']) : ATTACHMENT_ROOT . $file['path'];
                }
            }
            if (!empty($_FILES['apiclient_key_file']['name'])) {
                $file = file_upload($_FILES['apiclient_key_file']);
                if (is_error($file)) {
                    message('apiclient_key证书保存失败, 请保证目录可写' . $file['message']);
                } else {
                    $_GPC['apiclient_key'] = empty($file['path']) ? trim($_GPC['apiclient_key']) : ATTACHMENT_ROOT . $file['path'];
                }
            }
            if (!empty($_FILES['rootca_file']['name'])) {
                $file = file_upload($_FILES['rootca_file']);
                if (is_error($file)) {
                    message('rootca证书保存失败, 请保证目录可写' . $file['message']);
                } else {
                    $_GPC['rootca'] = empty($file['path']) ? trim($_GPC['rootca']) : ATTACHMENT_ROOT . $file['path'];
                }
            }
            //组建数组
            $cfg = array(
                'level' => intval($data['level']) ,
                'dailitiaojian' => intval($data['dailitiaojian']) ,
                'querenshouhuo' => $data['querenshouhuo']+0 ,
                'goumaidanshu' => intval($data['goumaidanshu']) ,
                'jkcun' => intval($data['jkcun']) ,
                'goumaiqianshu' => intval($data['goumaiqianshu']) ,
                'yijiyongjin' => $data['yijiyongjin'] + 0,
                'erjiyongjin' => $data['erjiyongjin'] + 0,
                'sanjiyongjin' => $data['sanjiyongjin'] + 0,
                'zengjiajifen' => $data['zengjiajifen'] + 0,
                'noguanzhu' => trim($data['noguanzhu']) ,
                'guanzhuhuifu' => trim($data['guanzhuhuifu']) ,
                'xinzengguanzhu' => trim($data['xinzengguanzhu']) ,
                'jinrushangcheng' => intval($data['jinrushangcheng']) ,
                'goumaisanji' => trim($data['goumaisanji']) ,
                'xiajijifen' => trim($data['xiajijifen']),
                'apiclient_cert' => trim($_GPC['apiclient_cert']),
                'apiclient_key' => trim($_GPC['apiclient_key']),
                'rootca' => trim($_GPC['rootca']),
                'hongbaozhufu' => trim($data['hongbaozhufu']),
                'honbaoip' => trim($data['honbaoip']),
                'act_name' => trim($data['act_name']),
                'remark' => trim($data['remark']),
                'fahuotongzhi'=>trim($data['fahuotongzhi']),
                'quxiaodingdan'=>trim($data['quxiaodingdan']),
                'shopname'=>trim($data['shopname']),
                'comment'=>trim($data['comment']),
                'gou'=>trim($data['gou']),
                'tel'=>trim($data['tel']),
                'shopgonggao'=>trim($data['shopgonggao']),
                'thumb'=>trim($data['thumb']),
                'wqpay'=>trim($data['wqpay']),
                'banner'=>trim($data['banner']),
                'qr_code'=>trim($data['qr_code']),
                'copyright'=>trim($data['copyright']),
                'service'=>trim($data['service']),
//                    'kw'=>trim($data['kw']),
                'dingdanshengcheng'=>trim($data['dingdanshengcheng']),
                'seller'=>trim($data['seller']),
                'admin'=>trim($data['admin']),
                'nohongbao'=>trim($data['nohongbao']),
                'kami'=>trim($data['kami']),
                'xiajirenshu'=>intval($data['xiajirenshu'])
            );
            if (!$this->saveSettings($cfg)) {
                message('保存信息失败', 'refresh', 'error');
            } else {
                message('保存信息成功', 'refresh', 'success');
            }
        }
        //这里来展示设置项表单
        include $this->template('setting');

    }



    private function arrayIndex($arr, $key) {
        $new_arr = [];
        foreach($arr as $value) {
            $new_arr[$value[$key]] = $value;
        }
        return $new_arr;
    }
}
