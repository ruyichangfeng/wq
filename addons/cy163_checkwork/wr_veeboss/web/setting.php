<?php

        $item = pdo_fetch("select * from " . tablename($this->modulename . '_setting') . " where weid =:weid", array(':weid' => $_W['uniacid']));

        if (checksubmit('submit')) {
            $data = array(
                'weid' => $_W['uniacid'],
                'url' => trim($_GPC['url']),
                'key' => trim($_GPC['key']),
            );

            if (!empty($item)) {
                pdo_update($this->modulename . '_setting', $data, array('weid' => $_W['uniacid']));
            } else {
                pdo_insert($this->modulename . '_setting', $data);
            }

            message('操作成功', $this->createWebUrl('setting'), 'success');
        }

        include $this->template('setting');
?>