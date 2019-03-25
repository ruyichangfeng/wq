<?php
/**
 * 我们约会吧模块微站定义
 *
 * @author tjtjtj
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class Tjtjtj_qlbmModuleSite extends WeModuleSite {

	public function doMobileIndex() {

		global $_W,$_GPC;

		define("ASSETS_PATH",MODULE_URL."assets/");

		$setting = pdo_fetch("SELECT * FROM ".tablename("tjtjtj_yuehui_config")." WHERE acid = ".$_W['account']['acid']);

		//$count = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename("tjtjtj_yuehui_xinxi")." WHERE acid = ".$_W['account']['acid']);

		


		include $this->template("index");

		

		


	}

	public function doMobileDosave()
	{
		global $_W,$_GPC;

		if($_W['ispost'])
		{
			$data = array(
				'user' => $_GPC['name'],
				'sex'  => $_GPC['sex'],
				'age'  => $_GPC['age'],
				'hunyin'=>$_GPC['hyzk'],
				'tel'  => $_GPC['phone'],
				'danwei'=>$_GPC['danwei'],
				'time' => date("Y-m-d H:i:s"),
				'acid' => $_W['account']['acid'],
 			);

 			$sql = "SELECT tel FROM ".tablename("tjtjtj_yuehui_xinxi")." WHERE tel = :tel";

 			$IS = pdo_fetch($sql,array(':tel'=>$data['tel']));

 			if(empty($IS))
 			{
 				if(pdo_insert("tjtjtj_yuehui_xinxi",$data))
	 			{
	 				$error['status'] = 1;
	 				$error['text'] = "报名成功";
	 				echo json_encode($error);
	 			}
	 			else
	 			{
	 				$error['status'] = 0;
	 				$error['text'] = "请求错误";
	 				echo json_encode($error);
	 			}
 			}
 			else
 			{
 				$error['status'] = -1;
 				$error['text'] = "请勿重复报名！";
 				echo json_encode($error);
 			}

 			
		}
	}

	public function doWebDodel()
	{
		global $_W,$_GPC;
			$id = intval($_GPC['id']);
			
			if(pdo_delete("tjtjtj_yuehui_xinxi",array('id'=>$id)))
			{
				echo json_encode(1);
			}
			else
			{
				echo json_encode(0);
			}
	}
	public function doWebCanshu() {
		//这个操作被定义用来呈现 管理中心导航菜单
		global $_W,$_GPC;

		$setting = pdo_fetch("SELECT * FROM ".tablename("tjtjtj_yuehui_config")." WHERE acid = ".$_W['account']['acid']);

		if($_W['ispost'])
		{
			$data = array(
				'title' => $_GPC['title'],
				'start_time' => strtotime($_GPC['start_time']),
				'end_time' => strtotime($_GPC['end_time']),
				'dingimg' => $_GPC['dingimg'],
				'xuimg' => $_GPC['xuimg'],
				'baoimg' => $_GPC['baoimg'],
				'jieimg' => $_GPC['jieimg'],
				);

			$IS = pdo_fetch("SELECT * FROM ".tablename("tjtjtj_yuehui_config")." WHERE acid = ".$_W['account']['acid']);

			if(empty($IS))
			{
				$data['acid'] = $_W['account']['acid'];

				pdo_insert("tjtjtj_yuehui_config",$data);

				message("设置成功!","","success");
			}
			else
			{
				pdo_update("tjtjtj_yuehui_config",$data,array('acid' => $_W['account']['acid']));
				message("设置成功!","","success");
			}
		}

		include $this->template("web/canshu");
	}
	public function doWebBaoming() {
		//这个操作被定义用来呈现 管理中心导航菜单
		global $_W,$_GPC;

		$pageindex = intval($_GPC['page']); // 当前页码
		$pagesize = 10;
		$sql = "SELECT COUNT(*) FROM ".tablename("tjtjtj_yuehui_xinxi")." WHERE acid = ".$_W['account']['acid'];
		$total = pdo_fetchcolumn($sql);
		$pager = pagination($total, $pageindex, $pagesize);

		$result = pdo_fetchall("SELECT * FROM ".tablename("tjtjtj_yuehui_xinxi")." WHERE acid = :acid",array(':acid'=>$_W['account']['acid']));

		include $this->template("web/baoming");
	}

	public function doWebExcel()
	{
		global $_W,$_GPC;
		header("Content-Type:text/html;charset=utf-8");
		define("EXCEL_PATH",MODULE_URL."assets/Classes/");
		


		$data = pdo_fetchall("SELECT * FROM ".tablename("tjtjtj_yuehui_xinxi")." WHERE acid = ".$_W['account']['acid']);

		foreach($data as $k => $v)
		{
			if($data[$k]['sex'] == 1)
			{
				$data[$k]['sex'] = "男";
			}
			else
			{
				$data[$k]['sex'] = "女";
			}
			if($data[$k]['hunyin'] == 1)
			{
				$data[$k]['hunyin'] = "已婚";
			}
			else
			{
				$data[$k]['hunyin'] = "未婚";
			}
		}

		$this->push($data,"用户等级信息表");

	}

	public function push($data,$name='Excel'){
		include_once "assets/Classes/PHPExcel.php";
          error_reporting(E_ALL);
          date_default_timezone_set('Europe/London');
         $objPHPExcel = new PHPExcel();
        /*以下是一些设置 ，什么作者  标题啊之类的*/
         $objPHPExcel->getProperties()->setCreator("技术支持1978273707")
                               ->setLastModifiedBy("技术支持1978273707")
                               ->setTitle("数据EXCEL导出")
                               ->setSubject("数据EXCEL导出")
                               ->setDescription("备份数据")
                               ->setKeywords("excel")
                              ->setCategory("result file");
         /*以下就是对处理Excel里的数据， 横着取数据，主要是这一步，其他基本都不要改*/
        foreach($data as $k => $v){
             $num=$k+1;
             $objPHPExcel->setActiveSheetIndex(0)
                         //Excel的第A列，uid是你查出数组的键值，下面以此类推
                          ->setCellValue('A'.$num, $v['user'])    
                          ->setCellValue('B'.$num, $v['sex'])
                          ->setCellValue('C'.$num, $v['age'])
                          ->setCellValue('D'.$num, $v['hunyin'])
                          ->setCellValue('E'.$num, $v['tel'])
                          ->setCellValue('F'.$num, $v['danwei'])
                          ->setCellValue('G'.$num, $v['time']);
            }
            $objPHPExcel->getActiveSheet()->setTitle('User');
            $objPHPExcel->setActiveSheetIndex(0);
             header('Content-Type: application/vnd.ms-excel');
             header('Content-Disposition: attachment;filename="'.$name.'.xlsx"');
             header('Cache-Control: max-age=0');
             $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
             $objWriter->save('php://output');
             exit;
      }

}