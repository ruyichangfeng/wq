<?php
/**
 * Created by IntelliJ IDEA.
 * User: codeMonkey QQ:2463619823
 * Date: 2017/6/26
 * Time: 21:27
 */
defined('IN_IA') or exit('Access Denied');

		$indexsetting = DBUtil::findUnique(DBUtil::$TABLE_XKWKJ_INDEX_SETTING, array(':weid' => $this->weid));

       $ppts =pdo_fetchall("select * from ".tablename(DBUtil::$TABLE_XKWKJ_PPTS)." c where p_type=:p_type order by dsort asc ",array(":p_type"=>self::PPT_INDEX));

		if (checksubmit('submit')) {
			$data = array(
				'weid' => $this->weid,
				'announcement' => trim($_GPC['announcement']),
				'banner_bg' => trim($_GPC['banner_bg']),
				'banner_url' => trim($_GPC['banner_url']),
				'share_title' => $_GPC['share_title'],
				'share_icon' => $_GPC['share_icon'],
				'share_content' => $_GPC['share_content'],
				'ppt_enable' => $_GPC['ppt_enable'],
				'category_enable' => $_GPC['category_enable']
			);
			if (!empty($indexsetting)) {
				DBUtil::updateById(DBUtil::$TABLE_XKWKJ_INDEX_SETTING, $data, $indexsetting['id']);
			} else {
				DBUtil::create(DBUtil::$TABLE_XKWKJ_INDEX_SETTING, $data);
			}


			$pptIds = array();
			$pids = $_GPC['pptids'];
			$dsorts = $_GPC['dsorts'];
			$pptnames = $_GPC['pptnames'];
			$imagess = $_GPC['imagess'];
			$ppt_urls = $_GPC['ppt_urls'];
			if (is_array($pids)) {
				foreach ($pids as $key => $value) {
					$value = intval($value);

					$d = array(
						'dsort' => $dsorts[$key],
						'pptname' => $pptnames[$key],
						'images' => $imagess[$key],
						'ppt_url' => $ppt_urls[$key],
						"createtime" => TIMESTAMP,
						'p_type' =>self::PPT_INDEX,
						'weid' => $this->weid
					);

					if (empty($value)) {
						DBUtil::create(DBUtil::$TABLE_XKWKJ_PPTS, $d);
						$pptIds[] = pdo_insertid();
					} else {
						DBUtil::updateById(DBUtil::$TABLE_XKWKJ_PPTS, $d, $value);
						$pptIds[] = $value;
					}

				}

				$p_type = self::PPT_INDEX;

				if (count($pptIds) > 0) {
					pdo_query("delete from " . tablename(DBUtil::$TABLE_XKWKJ_PPTS) . " where p_type='{$p_type}' and id not in (" . implode(",", $pptIds) . ")");
				} else {
					pdo_query("delete from " . tablename(DBUtil::$TABLE_XKWKJ_PPTS) . " where p_type='{$p_type}' ");
				}
			}



			message('首页参数设置成功！', $this->createWebUrl('IndexSetting', array(
				'op' => 'display'
			)), 'success');
		}
		include $this->template("index_setting");