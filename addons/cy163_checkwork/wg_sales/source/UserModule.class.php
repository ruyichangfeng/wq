<?php

class UserModule {

    public $table = 'wg_sales_user';

    public function update($where, $data) {
        $ret = pdo_update($this->table, $data, $where);
        if ($ret !== false) {
            return true;
        } else {
            return false;
        }
    }

    public function getOne($where,$field = '*') {
        $ret = pdo_get($this->table, $where, $field);
        if (!empty($ret)) {
            return $ret;
        } else {
            return array();
        }
    }

    public function getList($where, $field = '*') {
        return pdo_getall($this->table,$where,$field);
    }

    public function add($data) {
        //同步分销商城
        if($_GET['fromfuid'] && module_fetch('wg_fenxiao')) {

            $user = pdo_get('wg_fenxiao_member', [
                'openid'    => $data['openid'],
                'weid'      => $data['uniacid'],
            ], 'id');
            if(!$user) {
                $fromsales = $this->getOne([
                    'id' => intval($_GET['fromfuid'])
                ]);
                $fromfenxiao = pdo_get('wg_fenxiao_member', [
                    'openid'    => $fromsales['openid'],
                    'weid'      => $fromsales['uniacid'],
                ], 'id');

                //当前作者是否注册
                $tofenxiao = pdo_get('wg_fenxiao_member', [
                    'openid'    => $data['openid'],
                    'weid'      => $data['uniacid'],
                ], 'id');

                //原来作者已经注册分销
                if($fromfenxiao) {
                    //当前作者是否注册

                    if(!$tofenxiao) {
                        $datato = [
                            'openid'    => $data['openid'],
                            'weid'      => $data['uniacid'],
                            'nickname'  => $data['nickname'],
                            'avatar'    => $data['headimgurl'],
                            'parent_id' => $fromfenxiao['id']
                        ];
                        pdo_insert('wg_fenxiao_member', $datato);
                    }

                }else {
                    //注册分销
                    $datafrom = [
                        'openid'    => $fromsales['openid'],
                        'weid'      => $fromsales['uniacid'],
                        'nickname'  => $fromsales['nickname'],
                        'avatar'    => $fromsales['headimgurl'],
                        'parent_id' => 0
                    ];
                    $fromid = pdo_insert('wg_fenxiao_member', $datafrom);
                    //当前用户没有注册分销
                    if(!$tofenxiao) {
                        $datato = [
                            'openid'    => $data['openid'],
                            'weid'      => $data['uniacid'],
                            'nickname'  => $data['nickname'],
                            'avatar'    => $data['headimgurl'],
                            'parent_id' => pdo_insertid()
                        ];
                        pdo_insert('wg_fenxiao_member', $datato);
                    }
                }
            }

        }
        $ret   = pdo_insert($this->table, $data);
        if (!empty($ret)) {
            $cid =  pdo_insertid();
            return $cid;
        }
        return false;
    }
}
