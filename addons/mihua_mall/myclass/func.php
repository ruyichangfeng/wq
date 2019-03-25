<?php 
    //初始化隔离公众号
    function beginDoUniacid(){
        $tables = array(
            'mihua_zt',//专题
            'mihua_mall_red',//红包
            'mihua_mall_msg',//站内信
            'mihua_mall_qiandao',//签到
            'mihua_mall_comment',//评论
            'mihua_mall_zan',
            'mihua_mall_msg_template',
            'mihua_mall_follow',
            'mihua_mall_qr',
            'mihua_mall_phb_medal',
            'mihua_mall_address',
            'mihua_mall_adv',
            'mihua_mall_cart',
            'mihua_mall_category',
            'mihua_mall_commission',
            'mihua_mall_credit_award',
            'mihua_mall_credit_request',
            'mihua_mall_express',
            'mihua_mall_feedback',
            'mihua_mall_goods',
            'mihua_mall_goods_option',
            'mihua_mall_goods_param',
            'mihua_mall_member',
            'mihua_mall_order',
            'mihua_mall_order_goods',
            'mihua_mall_product',
            'mihua_mall_rules',
            'mihua_mall_rule',
            'mihua_mall_share_history',
            'mihua_mall_spec',
            'mihua_mall_spec_item',
            'mihua_mall_share_history',
            'mihua_mall_share_history',
        );
        $adds = array(
            'uniacid',
            'add_time'
        );
        foreach ($tables as $value) {
            foreach($adds as $row){
                if(!pdo_fieldexists( $value, $row)) {
                    pdo_query("ALTER TABLE ".tablename($value)." ADD ".$row." int(11) unsigned  DEFAULT '0';");
                }
            }
        }
    }
    //把参数组合成where_sql【and】
    function composeParamsToWhere($params){
        foreach ($params as $key => $value) {
            $name    = trim($key,':');
            if($before)
                $strs[]  = $before.'.'.$name."=".$key;
            else 
                $strs[]  = $name."=".$key;
        }
        return implode(' and ',$strs);      
    }
    //接收新增，更新参数
    function getNewUpdateData($in_data,$class_in){
        $in = array();
        foreach ($in_data as $key => $value) {
            if($class_in->$key){
                $in[$key] = $value;
           }
       }
       return $in;       
    }
    //获取手机上当前用户的uid 
    function getMemberUid(){
        global $_W;
        $member_uid = $_W['member']['uid']? $_W['member']['uid']:$_SESSION['member_uid'];
        return $member_uid;
    }
    //从数组从获取键值组成新的数组
    function getSomeFromArr($arr,$in_key){
        foreach ($arr as $key => $value) {
            $out_arr[$key] = $value[$in_key];
        }
        return $out_arr;
    }