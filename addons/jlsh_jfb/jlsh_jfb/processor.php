<?php
/**
 * 积分宝模块处理程序
 *
 * @author 
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');define('OD_ROOT', IA_ROOT . '/addons/jlsh_jfb');

class Jlsh_jfbModuleProcessor extends WeModuleProcessor {
	public function respond() {		global $_W;				$rid = $this->rule;
		$uniacid = $_W['uniacid'];						$openid = $this->message['from'];				load()->model('mc');
		$uid = mc_openid2uid($openid);						$jilu_sql = "select id from ".tablename('jfb_jifenjilu')." where rid=".$rid;
		$jilu_list = pdo_fetch($jilu_sql);
						if(empty($jilu_list)){				
			$content = $this->message['content'];			$content = str_replace("jf","",$content);												$jifen_sql = "select j.jifennumber,j.codetype from ".tablename('jfb_jifenlist')." as j left join ".tablename('jfb_qrcode')." as q on j.id = q.rid where j.ruleid=".$rid;			$jifen_list = pdo_fetch($jifen_sql);						$content = $jifen_list['jifennumber'];			$scend_id = $jifen_list['sceneid'];												if($jifen_list['codetype'] == 1){				$user = pdo_fetch('select nickname,credit2 from '.tablename('mc_members').' where uid = :uid',array(":uid"=>$uid));
					
				if(empty($user)){
					return $this->respText("充值异常,请告知店员重新生成二维码");
				}else{					mc_credit_update($uid,'credit2',$jifen_list['jifennumber'],array($uid,"线下积分宝充值".$jifen_list['jifennumber']));
					
					$cqsql = "SELECT mendian,dianyuan FROM " . tablename('jfb_jifenlist') . " WHERE weid = :weid and ruleid = :ruleid";
					$cqlist = pdo_fetch($cqsql,array(':weid'=>$uniacid,':ruleid'=>$rid));
					
					
					$jilu_data = array(
							'weid' => $uniacid,
							'title' => '充值',
							'jifen' => $jifen_list['jifennumber'],
							'rid' => $rid,
							'addtime' => TIMESTAMP,
							'mcid' => $uid,
							'mendian' => empty($cqlist)?0:$cqlist['mendian'],
							'dianyuan' => empty($cqlist)?0:$cqlist['dianyuan'],							'codetype' => 1
					);
					pdo_insert('jfb_jifenjilu',$jilu_data);
					
					
					
					$ssql = "SELECT * FROM " . tablename('jfb_setting') . " WHERE weid = :weid";
					$setting = pdo_fetch($ssql,array(':weid'=>$uniacid));
					
					
					pdo_delete("rule",array('id'=>$rid));
					pdo_delete("rule_keyword",array('rid'=>$rid));
						
					
					
					return $this->respText("亲爱的".$user['nickname'].',为您充值'.$jifen_list['jifennumber'].',您有'.($user['credit2']+$jifen_list['jifennumber']).'余额');
									}			}else{							if(empty($content)||empty($jifen_list)){					return $this->respText("积分添加异常,请告知店员重新生成二维码");				}else {					$user = pdo_fetch('select nickname,credit1 from '.tablename('mc_members').' where uid = :uid',array(":uid"=>$uid));										if(empty($user)){						return $this->respText("积分添加异常,请告知店员重新生成二维码");					}else{																		mc_credit_update($uid,'credit1',$jifen_list['jifennumber'],array($uid,"积分".$jifen_list['jifennumber']));							$cqsql = "SELECT mendian,dianyuan FROM " . tablename('jfb_jifenlist') . " WHERE weid = :weid and ruleid = :ruleid";
						$cqlist = pdo_fetch($cqsql,array(':weid'=>$uniacid,':ruleid'=>$rid));												
						$jilu_data = array(
								'weid' => $uniacid,
								'title' => '积分',
								'jifen' => $jifen_list['jifennumber'],
								'rid' => $rid,
								'addtime' => TIMESTAMP,
								'mcid' => $uid,								'mendian' => empty($cqlist)?0:$cqlist['mendian'],								'dianyuan' => empty($cqlist)?0:$cqlist['dianyuan']
						);
						pdo_insert('jfb_jifenjilu',$jilu_data);																								$ssql = "SELECT * FROM " . tablename('jfb_setting') . " WHERE weid = :weid";
						$setting = pdo_fetch($ssql,array(':weid'=>$uniacid));																		pdo_delete("rule",array('id'=>$rid));
						pdo_delete("rule_keyword",array('rid'=>$rid));
																			if(!empty($setting)){							$str = str_replace('{nickname}',$user['nickname'],$setting['tishi']);							$str = str_replace('{jifen}',$jifen_list['jifennumber'],$str);							$str = str_replace('{sum}',($user['credit1'] + $jifen_list['jifennumber']),$str);							return $this->respText($str);						}else{														return $this->respText("亲爱的".$user['nickname'].',您获得了'.$jifen_list['jifennumber'].'积分,您有'.($user['credit1']+$jifen_list['jifennumber']).'积分');
													}																		}				}			}		}else{			return $this->respText("此二维码已被使用,请联系店员重新生成二维码");		}				}
}