<?php
/**
 * 传图抽奖模块定义
 *
 * @author wuyou8888
 * @url 
 */
defined('IN_IA') or exit('Access Denied');

class Chuantu_chuantuModule extends WeModule {

	public function settingsDisplay($setting){
        global $_GPC, $_W;
        load()->func('tpl');
        if (checksubmit()) {
            $cfg = array(
                'starttime' => strtotime($_GPC['starttime']),
                'endtime' => strtotime($_GPC['endtime']),
                'total' => $_GPC['total'],
                'floor' => $_GPC['floor'],
                'rule'  =>$_GPC['rule'],
                'tips'  =>$_GPC['tips'],
                'error'  =>$_GPC['error'],
                'send_type'=>$_GPC['send_type'],
                'comment'  =>$_GPC['comment'],
                'PrizeTotal'=>$_GPC['PrizeTotal'],
                'floor_total' =>$_GPC['floor_total'],
            );

            if (!empty($_GPC['img'])) {
                $cfg['img'] = $_GPC['img'];
            }


            if ($this->saveSettings($cfg)) {
                message('保存成功', 'refresh');
            }
        }

        include $this->template('setting');
    }

}