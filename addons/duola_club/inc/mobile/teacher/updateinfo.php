<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
global $_W, $_GPC;
$weid = $_W['uniacid'];
$schoolid = intval($_GPC['schoolid']);
$openid = $_W['openid'];

//查询是否用户登录

$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $schoolid));
$user = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " where :schoolid = schoolid And :weid = weid And :openid = openid", array(
    ':weid' => $weid,
    ':schoolid' => $schoolid,
    ':openid'=> $openid
), 'id');
$category = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " WHERE weid =  '{$weid}' AND schoolid ={$schoolid} ORDER BY sid ASC, ssort DESC", array(':weid' => $weid, ':schoolid' => $schoolid), 'sid');
$xueqi = $km = $districtCenter = $xq = $sd = $courseCats = $classSize = array();
foreach($category as $key => $value){
    switch($value['type']){
        case 'semester':
            $xueqi[] = $value;
            break;
        case 'subject':
            $km[] = $value;
            if($user['km_id1'] == $value['sid']){
                $user['km1_name'] = $value['sname'];
            }
            if($user['km_id2'] == $value['sid']){
                $user['km2_name'] = $value['sname'];
            }
            if($user['km_id3'] == $value['sid']){
                $user['km3_name'] = $value['sname'];
            }
            break;
        case 'districtCenter':
            $districtCenter[] = $value;
            if($user['district_center_id'] == $value['sid']){
                $user['centerName'] = $value['sname'];
            }
            break;
        case 'week':
            $xq[] = $value;
            break;
        case 'timeframe':
            $sd[] = $value;
            break;
        case 'courseClassification':
            $courseCats[] = $value;
            break;
        case 'classSize':
            $classSize[] = $value;
            break;
        default:
            break;
    }
}
$op = $_GPC['op'] ? $_GPC['op'] : 'display';
if($op == 'POST'){
    if (! $_GPC ['schoolid'] || ! $_W ['openid'] || !$_GPC['tid']) {
        die ( json_encode ( array (
            'result' => false,
            'msg' => '非法请求！'
        ) ) );
    }
    $data = array(
        'tname' => $_GPC['tname'],
        'mobile' => $_GPC['mobile'],
        'birthdate' => strtotime($_GPC['birthdate']),
        'sex'   => $_GPC['sex'],
        'email' => $_GPC['email'],
        'district_center_id' => $_GPC['district_center_id'],
        'km_id1' => $_GPC['km_id1'],
        'km_id2' => $_GPC['km_id2'],
        'km_id3' => $_GPC['km_id3'],
        'info' => $_GPC['info'],
        'headinfo' => $_GPC['headinfo'],
        'jinyan' => $_GPC['jinyan']
    );
    $res = pdo_update($this->table_teachers,$data,array('id' => $_GPC['tid']));
    if(!empty($res)){
        die(json_encode(array('result' => true,'msg' => '更新成功!')));
    }else{
        die(json_encode(array('result' => false,'msg' => '更新失败!')));
    }
}elseif($op == 'uploadImg'){
    if (! $_GPC ['schoolid'] || ! $_W ['openid'] || !$_GPC['tid']) {
        die ( json_encode ( array (
            'result' => false,
            'msg' => '非法请求！'
        ) ) );
    }
    $data = array(
        'tname' => $_GPC['tname'],
        'mobile' => $_GPC['mobile'],
        'birthdate' => $_GPC['birthdate'],
        'sex'   => $_GPC['sex'],
        'email' => $_GPC['email'],
        'district_center_id' => $_GPC['district_center_id'],
        'km_id1' => $_GPC['km_id1'],
        'km_id2' => $_GPC['km_id2'],
        'km_id3' => $_GPC['km_id3'],
        'info' => $_GPC['info'],
        'headinfo' => $_GPC['headinfo'],
        'jinyan' => $_GPC['jinyan']
    );
    if(!empty($_GPC['qrImg'])){
        load()->func('communication');
        load()->classs('weixin.account');
        load()->func('file');
        $accObj= WeixinAccount::create($_W['account']['acid']);
        $access_token = $accObj->fetch_token();
        $token2 =  $access_token;
        $photoUrl = $_GPC ['qrImg'];
        if(!empty($photoUrl)) {
            $url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token2.'&media_id='.$photoUrl;
            $pic_data = ihttp_request($url);
            $path = "images/";
            $picurl = $path.random(30) .".jpg";
            file_write($picurl,$pic_data['content']);
            if (!empty($_W['setting']['remote']['type'])) { //
                $remotestatus = file_remote_upload($picurl); //
                if (is_error($remotestatus)) {
                    message('远程附件上传失败，请检查配置并重新上传');
                }
            }
        }
        $data['qrImg'] = $picurl;
    }
    $res = pdo_update($this->table_teachers,$data,array('id' => $_GPC['tid']));
    if(!empty($res)){
        die(json_encode(array('result' => true,'msg' => '上传成功!')));
    }else{
        die(json_encode(array('result' => false,'msg' => '上传失败!')));
    }
}else{
    include $this->template(''.$school['style3'].'/updateinfo');
}
?>