<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/4
 * Time: 16:37
 */

include_once "excelAdmin.php";

/**
 * 获取某参数分类下的数据
 * $type  systemconfig_type 分类
 */
function getconfigbytype($type, $tb_name)
{
    global $_W, $_GPC;
    /** 获取参数配置信息 */
    $systemconfig_where = array();
    $systemconfig_where['config_uniacid'] = $_W['uniacid'];
    if($type != '')
    {
        $systemconfig_where['config_type'] = $type;
    }
    $systemconfig_array = array();

    $systemconfig_array = pdo_getall($tb_name, $systemconfig_where, array('config_key','config_value'));

    $systemconfig_list = array();

    if(count($systemconfig_array) > 0)
    {
        foreach($systemconfig_array as $k=>$v)
        {
            $systemconfig_list[$v['config_key']] = $v['config_value'];
        }
    }
    /** 获取参数配置信息 */

    return $systemconfig_list;
}

/**
 * 更新某参数分组下的 有所更改的 字段内容
 * $type systemconfig_type 分类
 * $systemconfig_list 该分组下的  已存储信息
 * $create 表单提交内容
 */
function updateconfigbytype($type, $systemconfig_list, $create, $tb_name)
{
    global $_W, $_GPC;
    $chazhi = array();
    $insertarr = array();
    foreach ($create as $ks=>$vs)
    {
        if(array_key_exists($ks, $systemconfig_list))
        {
            /** 存在键值 */
            if($systemconfig_list[$ks] != $vs)
            {
                $chazhi[$ks] = $create[$ks];
            }

        } else
        {
            $insertarr[$ks]=$vs;
        }
    }
    $state = true;
    if(count($chazhi) > 0)
    {
        foreach ($chazhi as $k =>$v)
        {
            if($state)
            {
                $sql="UPDATE  ".tablename($tb_name)." SET config_value = '".$v."'  where config_uniacid = ".$_W['uniacid']."  and config_key = '".$k."' and config_type =  '".$type."'";
                $result = pdo_query($sql);
                if(empty($result))
                {
                    $state = false;
                }
            }
        }
    }

    if($state)
    {
        if(count($insertarr) > 0)
        {
            $sql="INSERT INTO ".tablename($tb_name)." (config_uniacid,config_type,config_key,config_value ) VALUES";
            foreach ($insertarr as $k=>$v)
            {
                $sql.= " (".$_W['uniacid'].",'".$type."','".$k."','".$v."'),";
            }
            $insertsql = substr($sql,0,-1);
            $state = pdo_query($insertsql);
        }
    }

    return $state;
}


/*
 * 搜索粉丝信息
 * **/
function selectFansAndMember($content)
{
    global $_W;
    $sql = " select * from ". tablename('mc_mapping_fans') . " as b left join ".tablename('mc_members'). " as a on a.uid = b.uid where (a.nickname like :nickname or a.mobile = :mobile or b.openid = :openid) and a.uniacid = :uniacid limit 0, 8";
    $params = array(
        ':mobile'=>$content,
        ':nickname'=>'%'.$content.'%',
        ':openid'=>$content,
        ':uniacid'=>$_W['uniacid']
    );
    $result = pdo_fetchall($sql, $params);
    return $result;
}
/*
 * 处理搜索后的粉丝信息
 * **/
function makeSearchToStr($data = array())
{
    $str = '';
    if (empty($data))
    {
        $str .= '<tr><td>未找到相关信息</td></tr>';
    }
    foreach ($data as $item)
    {
        $str .= '<tr><td><P style="line-height:40px; width: 300px; white-space:normal;"><img src="'.tomedia($item['avatar']).'" width=40px height=40px align=left alt="" style="margin-right: 5px">'.$item['nickname'].'</P></td><td></td><td>'.$item['mobile'].'</td><td></td><td></td><td><a href="javascript:chooseFans(\''.$item["openid"].'\',\''.$item["nickname"].'\', \''.$item['avatar'].'\')">选择</a></td></tr><tr >';
    }

    return $str;
}

/** 把项目类型转换为option */
function makePtypeToOption($ptype = array())
{
    $str = '<option value="" selected>请选择</option>';
    if (!empty($ptype))
    {
        foreach ($ptype as $key=>$item)
        {
            $str .= '<option value="'.$item['ptype_id'].'">'.$item['ptype_title'].'</option>';
        }
    }

    return $str;
}
/*
 * 把门店转换为option
 * **/
function makeStoreToOption($stores = array())
{
    $str = '<option value="" selected>请选择</option>';
    if (!empty($stores))
    {
        foreach ($stores as $key=>$item)
        {
            $str .= '<option value="'.$item['store_id'].'">'.$item['store_name'].'</option>';
        }
    }

    return $str;
}
/*
 * 把店员转换为option
 * **/
function makeStaffToOption($staffs = array())
{
    $str = '<option value="" selected>请选择</option>';
    if (!empty($staffs))
    {
        foreach ($staffs as $key=>$item)
        {
            $str .= '<option value="'.$item['staff_id'].'">'.$item['staff_name'].'</option>';
        }
    }

    return $str;
}
/*
 * 把项目转换为option
 * **/
function makeProjectToOption($projects = array())
{
    $str = '<option value="" selected>请选择</option>';
    if (!empty($projects))
    {
        foreach ($projects as $key=>$item)
        {
            $str .= '<option value="'.$item['project_id'].'">'.$item['project_name'].'</option>';
        }
    }

    return $str;
}

/** 预约时间转换成option */
function makeDayToOption($weeks = array())
{
    $str = '<option value="" selected>请选择</option>';
    if (!empty($weeks))
    {
        foreach ($weeks as $key=>$item)
        {
            $str .= '<option value="'.$item.'">'.$item.'</option>';
        }
    }

    return $str;
}

/** 预约时段转换成option */
function makeTimeToOption($times = array(), $counts = array())
{
    $str = '<option value="" selected>请选择</option>';
    if (!empty($times))
    {
        foreach ($times as $key=>$item)
        {
            if ($item['count'] > $counts[$key])
            {
                $str .= '<option value="'.$item['start']."-".$item['end'].'">'.$item['start']."-".$item['end'].'</option>';
            }

        }
    }

    return $str;
}

/*
 * 替换预约设置信息
 * 商家 门店 店员 项目
 * **/
function checkDatingInfo($datines, $business, $stores, $staffs, $projects)
{
    foreach ($datines as $key=>$item)
    {
        foreach ($business as $v1)
        {
            if ($item['businessid'] == $v1['business_id'])
            {
                $datines[$key]['business_name'] = $v1['business_name'];
            }
        }

        foreach ($stores as $v2)
        {
            if ($item['storeid'] == $v2['store_id'])
            {
                $datines[$key]['store_name'] = $v2['store_name'];
            }
        }

        foreach ($staffs as $v3)
        {
            if ($item['staffid'] == $v3['staff_id'])
            {
                $datines[$key]['staff_name'] = $v3['staff_name'];
            }
        }
        foreach ($projects as $v4)
        {
            if ($item['projectid'] == $v4['project_id'])
            {
                $datines[$key]['project_name'] = $v3['project_name'];
            }
        }
    }

    return $datines;
}


/**
 * 预约时间排序
 */
function DatingTimeSort($data)
{
    for ($i = 0; $i < count($data); $i++)
    {
        for ($j = 0; $j < count($data); $j++)
        {

            if ($data[$j]['start'] > $data[$j + 1]['start'])
            {
                $temp = $data[$j];
                $data[$j]['start'] = $data[$j + 1]['start'];
                $data[$j]['end'] = $data[$j + 1]['end'];
                $data[$j]['count'] = $data[$j + 1]['count'];
                $data[$j + 1]['start'] = $temp['start'];
                $data[$j + 1]['end'] = $temp['end'];
                $data[$j + 1]['count'] = $temp['count'];
            }
        }
    }

    return $data;
}

/**
 * 计算两点地理坐标之间的距离
 * @param  Decimal $longitude1 起点经度
 * @param  Decimal $latitude1  起点纬度
 * @param  Decimal $longitude2 终点经度
 * @param  Decimal $latitude2  终点纬度
 * @param  Int     $unit       单位 1:米 2:公里
 * @param  Int     $decimal    精度 保留小数位数
 * @return Decimal
 */
function getDistance($longitude1, $latitude1, $longitude2, $latitude2, $unit=2, $decimal=2){

    $EARTH_RADIUS = 6370.996; // 地球半径系数
    $PI = 3.1415926;

    $radLat1 = $latitude1 * $PI / 180.0;
    $radLat2 = $latitude2 * $PI / 180.0;

    $radLng1 = $longitude1 * $PI / 180.0;
    $radLng2 = $longitude2 * $PI /180.0;

    $a = $radLat1 - $radLat2;
    $b = $radLng1 - $radLng2;

    $distance = 2 * asin(sqrt(pow(sin($a/2),2) + cos($radLat1) * cos($radLat2) * pow(sin($b/2),2)));
    $distance = $distance * $EARTH_RADIUS * 1000;

    if($unit==2){
        $distance = $distance / 1000;
    }

    return round($distance, $decimal);

}

/** lbs 门店服务 */
function LBSStore($stores, $log, $lat)
{
    foreach ($stores as $key=>$item)
    {
        $distance = getDistance($item['store_lat'], $item['store_log'], $lat, $log);
        $stores[$key]['distance'] = $distance;
    }

   for ($i = 0; $i < count($stores) - 1; $i++)
   {
       for ($j = 0; $j < count($stores) - 1 - $i; $j++)
       {
           if ($stores[$j]['distance'] > $stores[$j + 1]['distance'])
           {
               $temp = $stores[$j];
               $stores[$j] = $stores[$j + 1];
               $stores[$j + 1] = $temp;
           }
       }
   }


    return $stores;
}

/**
 * 获取当天之后的一周日期
 * @param  date $week 当前日期
 * @return array 一周日期
 */
function riqi($week, $type = 1)
{

    $whichD = date('w', strtotime($week));
    $weeks = array();
    if ($type == 1)
    {
        $weeks[$whichD] = $week;

    } else
    {
        $weeks[$whichD] = date('m月d日', strtotime($week));
    }

    for($i = 1; $i < 7; $i++)
    {
        $date = strtotime($week) + ($i * 24 * 3600);
        $weekN = date('w', $date);
        if ($type == 1)
        {
            $date = date('Y-m-d', $date);
        } else
        {
            $date = date('m月d日', $date);
        }

        $weeks[$weekN] = $date;

    }

    return $weeks;
}

/**
 * 获取某时间段下的预约次数
 */
function getTimeCount($dating, $day)
{
    global $_W;

    $time_count = array();
    foreach ($dating['dating_time'] as $key=>$item)
    {
        $sql = ' select count(*) as total from '.tablename('wxlm_appointment_order')." where  order_staffid = :staffid and order_dating_day = :dating_day and order_dating_start = :dating_start and order_dating_end = :dating_end and order_uniacid = :uniacid and (order_state = 2 or order_state = 3)";

        $params = array(

            ':staffid' => $dating['dating_staffid'],
            ':dating_day'=>$day,
            ':dating_start' => $item['start'],
            ':dating_end' => $item['end'],
            ':uniacid' => $_W['uniacid']
        );
        $count = pdo_fetch($sql, $params);
        $time_count[$key] = $count['total'];
    }

    return $time_count;
}

/**
 * 生成一个订单号
 * **/
function build_order_no()
{
    return date('ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
}

/**
 * 检测订单号
 * **/
function getOrderNumber($i = 0)
{
    global $_W;
    if($i < 50)
    {
        /*获取一个编号*/
        $ordernumber = build_order_no();

        $paylog = pdo_get('wxlm_appointment_order', array('order_uniacid' => $_W['uniacid'],'order_number' => $ordernumber));

        if($paylog)
        {
            $i++;
            getOrderNumber($i);
        }
        else
        {
            return $ordernumber;
        }
    }
    else
    {
        return false;
    }

}

/**
 * 检测vip订单号
 * **/
function getVipNumber($i = 0)
{
    global $_W;
    if($i < 50)
    {
        /*获取一个编号*/
        $ordernumber = build_order_no();

        $paylog = pdo_get('wxlm_appointment_vip', array('vip_uniacid' => $_W['uniacid'],'vip_number' => $ordernumber));

        if($paylog)
        {
            $i++;
            getOrderNumber($i);
        }
        else
        {
            return $ordernumber;
        }
    }
    else
    {
        return false;
    }

}

/**
 * 检测march订单号
 * **/
function getMarchNumber($i = 0)
{
    global $_W;
    if($i < 50)
    {
        /*获取一个编号*/
        $ordernumber = build_order_no();
        $ordernumber = 'M'.$ordernumber;

        $paylog = pdo_get('wxlm_appointment_march', array('march_uniacid' => $_W['uniacid'],'march_number' => $ordernumber));

        if($paylog)
        {
            $i++;
            getOrderNumber($i);
        }
        else
        {
            return $ordernumber;
        }
    }
    else
    {
        return false;
    }

}

/*
 * url请求
 * **/
function _request($curl, $https=true, $method='get', $data=null)
{

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $curl);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    if($https){

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    }

    if($method == 'post'){

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }

    $str = curl_exec($ch);
    curl_close($ch);
    return $str;

}

/*
 * http请求
 * **/
function httpPost($url,$data){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

    $res = curl_exec($curl);
    curl_close($curl);
    return $res;
}

/**
 * 订单处理
 */
function dealOrders($orders, $business, $stores, $staffs, $projects, $pc = 1)
{

    foreach ($orders as $key=>$item)
    {
        if ($pc == 2)
        {
            $orders[$key]['order_businessid'] = $business['business_name'];

        } else
        {
            foreach ($business as $busines)
            {

                if ($item['order_businessid'] == $busines['business_id'])
                {

                    $orders[$key]['order_businessid'] = $busines['business_name'];
                    break;
                }
            }
        }


        foreach ($stores as $storitem)
        {
            if ($item['order_storeid'] == $storitem['store_id'])
            {
                $orders[$key]['order_storeid'] = $storitem['store_name'];
                break;
            }
        }

        foreach ($staffs as $staitem)
        {
            if ($item['order_staffid'] == $staitem['staff_id'])
            {
                $orders[$key]['order_staffid'] = $staitem['staff_name'];
                break;
            }
        }

        foreach ($projects as $proitem) {
            if ($item['order_projectid'] == $proitem['project_id'])
            {
                $orders[$key]['order_projectid'] = $proitem['project_name'];
                break;
            }
        }

        if ($item['order_state'] == 1)
        {
            $orders[$key]['order_state'] = '未支付';

        } else if ($item['order_state'] == 2)
        {
            $orders[$key]['order_state'] = '已支付';

        } else if ($item['order_state'] == 3)
        {
            $orders[$key]['order_state'] = '已完成';

        } else if ($item['order_state'] == 4)
        {
            $orders[$key]['order_state'] = '关闭';
        }else if ($item['order_state'] == 5)
        {
            $orders[$key]['order_state'] = '失效';
        }


        if ($item['order_pay_type'] == 1)
        {
            $orders[$key]['order_pay_type'] = "免支付";

        } else if ($item['order_pay_type'] == 2)
        {
            $orders[$key]['order_pay_type'] = "在线支付";

        } else if ($item['order_pay_type'] == 3)
        {
            $orders[$key]['order_pay_type'] = "会员卡";
        }
    }

    return $orders;
}

function getnicknameavatar($openid)
{
    load()->model('mc');
    $tag=array();
    $list = pdo_get('mc_mapping_fans',array('openid'=>$openid));
    if (!empty($list)) {
        $list['tag_show'] = mc_show_tag($list['groupid']);
        $list['groupid'] = trim($list['groupid'], ',');
        if (!empty($list['uid'])) {
            $user = mc_fetch($list['uid'], array('realname', 'nickname', 'mobile', 'email', 'avatar'));
        }
        if (!empty($list['tag']) && is_string($list['tag'])) {
            if (is_base64($list['tag'])) {
                $tag = base64_decode($list['tag']);
            }
            if (is_serialized($tag)) {
                $tag = @iunserializer($tag);
            }
            if (!empty($tag['headimgurl'])) {
                $tag['avatar'] = tomedia($tag['headimgurl']);
            }
        }
        if (empty($tag)) {
            $tag = array();
        }
    }
    return $tag;
}

/** 下载预约记录信息 */
function downloadRecord($orders)
{
    $info = array();
    foreach ($orders as $key=>$item)
    {
        $info[$key]['order_number'] = $item['order_number'];
        $info[$key]['order_username'] = $item['order_username'];
        $info[$key]['order_userphone'] = $item['order_userphone'];
        $info[$key]['order_businessid'] = $item['order_businessid'];
        $info[$key]['order_storeid'] = $item['order_storeid'];
        $info[$key]['order_projectid'] = $item['order_projectid'];
        $info[$key]['order_staffid'] = $item['order_staffid'];
        $info[$key]['order_dating_day'] = $item['order_dating_day'];
        $info[$key]['order_dating_time'] = $item['order_dating_start']."-".$item['order_dating_end'];
        $info[$key]['order_pay_type'] = $item['order_pay_type'];
        $info[$key]['order_state'] = $item['order_state'];
    }

    $title[0] = "订单号";
    $title[1] = "预约人姓名";
    $title[2] = "预约人电话";
    $title[3] = "商家";
    $title[4] = "门店";
    $title[5] = "项目";
    $title[6] = "员工";
    $title[7] = "预约日期";
    $title[8] = "预约时段";
    $title[9] = "支付方式";
    $title[10] = "订单状态";

    $excel = importDataForObj($info, $title);
    download($excel, 'appointment');


}

/** 获取门店评论待审核信息 */
function getCommentCount($stores)
{
    global $_W;

    foreach ($stores as $key=>$item)
    {
        $sql = "select count(*) as total from ".tablename('wxlm_appointment_comment'). " where comment_uniacid = :uniacid and comment_storeid = :storeid and comment_state = 1";
        $params = array(
            ':uniacid'=>$_W['uniacid'],
            ':storeid'=>$item['store_id'],
        );

        $total = pdo_fetch($sql, $params);

        $stores[$key]['comment'] = $total['total'];
    }

    return $stores;
}

/**
 *
 * 产生随机字符串，不长于32位
 * @param int $length
 * @return 产生的随机字符串
 */
function getRandStr($length = 32, $type = 1)
{
    if ($type == 1)
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";

    } else if ($type == 2)
    {
        $chars = "abcdefghijklmnopqrstuvwxyz";

    } else if ($type == 3)
    {
        $chars = "0123456789";
    }

    $str = "";
    for ( $i = 0; $i < $length; $i++ )  {
        $str .= substr($chars, mt_rand(0, strlen($chars)-1), 1);
    }
    return $str;
}

/** 获取账号 */
function getAdmin($i = 0)
{
    global $_W;

    if($i < 50)
    {
        echo 1;
        $admin_account = getRandStr(6, 2);

        $adminlog = pdo_get('wxlm_appointment_admin', array('admin_uniacid' => $_W['uniacid'],'admin_account' => $admin_account));

        if($adminlog)
        {
            $i++;
            getAdmin($i);
        }
        else
        {
            return $admin_account;
        }
    }
    else
    {
        return false;
    }

}


function getfirstchar($s0){
    $firstchar_ord=ord(strtoupper($s0{0}));
    if (($firstchar_ord>=65 and $firstchar_ord<=91)or($firstchar_ord>=48 and $firstchar_ord<=57)) return $s0{0};
    $s=iconv("UTF-8","gb2312", $s0);
    $asc=ord($s{0})*256+ord($s{1})-65536;
    if($asc>=-20319 and $asc<=-20284)return "A";
    if($asc>=-20283 and $asc<=-19776)return "B";
    if($asc>=-19775 and $asc<=-19219)return "C";
    if($asc>=-19218 and $asc<=-18711)return "D";
    if($asc>=-18710 and $asc<=-18527)return "E";
    if($asc>=-18526 and $asc<=-18240)return "F";
    if($asc>=-18239 and $asc<=-17923)return "G";
    if($asc>=-17922 and $asc<=-17418)return "H";
    if($asc>=-17417 and $asc<=-16475)return "J";
    if($asc>=-16474 and $asc<=-16213)return "K";
    if($asc>=-16212 and $asc<=-15641)return "L";
    if($asc>=-15640 and $asc<=-15166)return "M";
    if($asc>=-15165 and $asc<=-14923)return "N";
    if($asc>=-14922 and $asc<=-14915)return "O";
    if($asc>=-14914 and $asc<=-14631)return "P";
    if($asc>=-14630 and $asc<=-14150)return "Q";
    if($asc>=-14149 and $asc<=-14091)return "R";
    if($asc>=-14090 and $asc<=-13319)return "S";
    if($asc>=-13318 and $asc<=-12839)return "T";
    if($asc>=-12838 and $asc<=-12557)return "W";
    if($asc>=-12556 and $asc<=-11848)return "X";
    if($asc>=-11847 and $asc<=-11056)return "Y";
    if($asc>=-11055 and $asc<=-10247)return "Z";
    return null;
}