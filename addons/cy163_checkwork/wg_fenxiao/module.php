<?php
/**
 * @author
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class Wg_fenxiaoModule extends WeModule {
    public $tablename = 'wg_fenxiao_news_reply';
    public $replies = array();
    public function fieldsFormDisplay($rid = 0) {
        global $_W;
        load()->func('tpl');
        $replies = array();
        $replies = pdo_fetchall("SELECT * FROM ".tablename($this->tablename)." WHERE rid = :rid AND parent_id = -1 ORDER BY `displayorder` DESC, id ASC", array(':rid' => $rid));
        if(!empty($replies)) {
                        $parent_id = $replies[0]['id'];
            pdo_update($this->tablename, array('parent_id' => $parent_id), array('rid' => $rid));
            pdo_update($this->tablename, array('parent_id' => 0), array('rid' => $rid, 'id' => $parent_id));
        }
        $rows = pdo_fetchall("SELECT * FROM ".tablename($this->tablename)." WHERE rid = :rid ORDER BY `parent_id` ASC, `id` ASC", array(':rid' => $rid));
        $replies = array();
        foreach($rows as &$row) {
            if(!empty($row['thumb'])) {
                $row['thumb'] = tomedia($row['thumb']);
            }
            if (empty($row['parent_id'])) {
                $replies[$row['id']][] = $row;
            } else {
                $replies[$row['parent_id']][] = $row;
            }
        }
        $replies = array_values($replies);
        include $this->template('news');
    }
    
    public function fieldsFormValidate($rid = 0) {
        global $_GPC, $_W;
        if($_GPC['iswenzhang'] == 2){
            return '';
        } 
        $this->replies = @json_decode(htmlspecialchars_decode($_GPC['replies']), true);
        if(empty($this->replies)) {
            return '必须填写有效的回复内容.';
        }
        $column = array('id', 'parent_id', 'title', 'author', 'displayorder', 'thumb', 'description', 'content', 'url', 'incontent', 'createtime');
        foreach($this->replies as $i => &$group) {
            foreach($group as $k => &$v) {
                if(empty($v)) {
                    unset($group[$k]);
                    continue;
                }
                if (trim($v['title']) == '') {
                    return '必须填写有效的标题.';
                }
                if (trim($v['thumb']) == '') {
                    return '必须填写有效的封面链接地址.';
                }
                $v['thumb'] = str_replace($_W['attachurl'], '', $v['thumb']);
                $v['content'] = htmlspecialchars_decode($v['content']);
                $v['createtime'] = TIMESTAMP;
                $v = array_elements($column, $v);
            }
            if(empty($group)) {
                unset($i);
            }
        }
        if(empty($this->replies)) {
            return '必须填写有效的回复内容.';
        }
        return '';
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
        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'morenshezhi'; //默认op
        if ($operation == 'morenshezhi') {
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
                    'xiajirenshu'=>intval($data['xiajirenshu']),
                    'gou_thumb'=>trim($data['gou_thumb']),
                    'gou_name'=>trim($data['gou_name']),
                    'gou_url'=>trim($data['gou_url']),
                    'poster'=>trim($data['poster']),
                    'apply_agent'=>trim($data['apply_agent']),

                );
                if (!$this->saveSettings($cfg)) {
                    message('保存信息失败', 'refresh', 'error');
                } else {
                    message('保存信息成功', 'refresh', 'success');
                }
            }
            //这里来展示设置项表单
            include $this->template('setting');
        } elseif ($operation = 'fxsdengji') {
            $oop = !empty($_GPC['oop']) ? $_GPC['oop'] : 'fxsdengjiManager'; //默认oop
            if ($oop == 'fxsdengjiAdd') {
                $id = intval($_GPC['id']); //获取id，判断是否是修改操作
                if (!empty($id)) { //存在查出来
                    $item = pdo_fetch("SELECT * FROM " . tablename('wg_fenxiao_member_level') . " WHERE id = '$id'");
                    if (empty($item)) {
                        message('抱歉，分销商等级不存在或是已经删除！', '', 'error');
                    }
                }else{//不存在，即为新添加
                    $item = array(
                        'onenum'=>9999,
                        'twonum'=>9999,
                        'threenum'=>9999
                    );
                }
                if (checksubmit()) {
                    $level = $_GPC['level'] + 0;
                    if ($level < 1) {
                        message('请正确填写：等级权重');
                    }
                    if (empty($_GPC['levelname'])) {
                        message('等级名称,不能为空');
                    }
                    if (empty($_GPC['jifen'])) {
                        message('升级所需积分，不能为空');
                    }
                    if (empty($_GPC['zhekou'])) {
                        message('购买时享受折扣，不能为空');
                    }
                    $data = array(
                        'weid' => intval($_W['uniacid']) ,
                        'level' => intval($level) ,
                        'levelname' => trim($_GPC['levelname']) ,
                        'jifen' => intval($_GPC['jifen']) ,
                        'zhekou' => $_GPC['zhekou'] + 0,
                        'yijiyongjin' => $_GPC['yijiyongjin'] + 0,
                        'erjiyongjin' => $_GPC['erjiyongjin'] + 0,
                        'sanjiyongjin' => $_GPC['sanjiyongjin'] + 0,
                        'yicijiangli' => $_GPC['yicijiangli'] + 0,
                        'meidanjiangli' => $_GPC['meidanjiangli'] + 0,
                        'onenum' => $_GPC['onenum'] + 0,
                        'twonum' => $_GPC['twonum'] + 0,
                        'threenum' => $_GPC['threenum'] + 0
                    );
                    if (!empty($id)) { //如果id不为空
                        pdo_update('wg_fenxiao_member_level', $data, array(
                            'id' => $id
                        ));
                    } else {
                        pdo_insert('wg_fenxiao_member_level', $data);
                        $id = pdo_insertid();
                    }

                    $this->updateJifen();
                    message('分销商等级更新成功！', murl('profile/module/setting', array(
                        'op' => 'fxsdengji',
                        'oop' => 'fxsdengjiAdd',
                        'm' => strtolower($this->modulename) ,
                        'id' => $id
                    )) , 'success');
                }
            } elseif ($oop == 'fxsdengjiManager') {
                $sql = 'SELECT * FROM ' . tablename('wg_fenxiao_member_level') . ' WHERE `weid` = :weid ORDER BY `level` DESC';
                $list = pdo_fetchall($sql, array(
                    ':weid' => $_W['uniacid']
                ));
            } elseif ($oop == 'fxsdengjiDel') {
                $id = intval($_GPC['id']); //获取id
                pdo_delete('wg_fenxiao_member_level', array(
                    'id' => $id
                ));
                $this->updateJifen();
                message('删除成功！', referer() , 'success');
            }
            include $this->template('fxsdengji');
        }
    }

    private function updateJifen() {
        global $_W;
        $key = 'members:level:uid:%s';
        $key = sprintf($key, $_W['uniacid']);

        $sql = 'SELECT * FROM ' . tablename('wg_fenxiao_member_level') . ' WHERE `weid` = :weid ORDER BY `level` DESC';
        $data = pdo_fetchall($sql, array(
            ':weid' => $_W['uniacid']
        ));

        $data = $this->arrayIndex($data, 'level');
        cache_write($key, [
            'data' => $data
        ],3600*12);
    }

    private function arrayIndex($arr, $key) {
        $new_arr = [];
        foreach($arr as $value) {
            $new_arr[$value[$key]] = $value;
        }
        return $new_arr;
    }
}
