<?php
defined ( 'IN_IA' ) or exit ( 'Access Denied' );
require_once 'class/dev.php';
class Cx_tcbdModuleSite extends WeModuleSite {
	public $tablename = 'cx_tcbd_form';
	
	public function doWebIndex2(){
		global $_GPC, $_W;
		
		load ()->model ( 'reply' );
		$pindex = max ( 1, intval ( $_GPC ['page'] ) );
		$psize = 20;
		$sql = "uniacid = :uniacid AND `module` = :module";
		$params = array ();
		$params [':uniacid'] = $_W ['uniacid'];
		$params [':module'] = 'cx_tcbd';
		
		if (isset ( $_GPC ['keywords'] )) {
			$sql .= ' AND `name` LIKE :keywords';
			$params [':keywords'] = "%{$_GPC['keywords']}%";
		}
		$list = reply_search ( $sql, $params, $pindex, $psize, $total );
		$pager = pagination ( $total, $pindex, $psize );
		
		if (! empty ( $list )) {
			foreach ( $list as &$item ) {
				$condition = "`rid`={$item['id']}";
				$item ['keywords'] = reply_keywords_search ( $condition );
				$bigwheel = pdo_fetch ( "SELECT fansnum, viewnum,valid_time_start as starttime,valid_time_end as endtime FROM " . tablename ( 'cx_bd_form' ) . " WHERE rid = :rid ", array (
						':rid' => $item ['id'] 
				) );
				$item ['fansnum'] = $bigwheel ['fansnum'];
				$item ['viewnum'] = $bigwheel ['viewnum'];
				$item ['starttime'] = date ( 'Y-m-d H:i', $bigwheel ['starttime'] );
				$endtime = $bigwheel ['endtime'] + 86399;
				$item ['endtime'] = date ( 'Y-m-d H:i', $endtime );
			}
		}
		include $this->template ( 'index' );		
	}
}
?>