<?php 

class Forbid { function __construct() { } static function remove($openid) { $data['forbid_status'] = 'y'; $data['forbid_add_time'] = date("Y-m-d H:i:s"); $data['forbid_end_time'] = '3000-12-12'; $where['openid'] = $openid; return MemberTableHandle::update($data,$where); } static function restore($openid) { $data['forbid_status'] = 'n'; $data['forbid_add_time'] = date("Y-m-d H:i:s"); $where['openid'] = $openid; return MemberTableHandle::update($data,$where); } static function isAllow($openid) { $info = MemberTableHandle::info($openid); if($info['forbid_status'] != 'y') { return true; } return false; } }

?>