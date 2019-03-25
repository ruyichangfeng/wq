<?php
/**
 * 线下积分宝模块处理程序
 *
 * @author wenjing
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');
define('OD_ROOT', IA_ROOT . '/addons/Jlsh_jfb');

class Jlsh_jfbModuleProcessor extends WeModuleProcessor {
	public function respond() {
	
	    global $_W,$_GPC;							
	    $rid = $this->rule;				
	    $uniacid = $_W['uniacid'];						
	    $repeat = 0;						
	    $openid = $this->message['from'];						
	    load()->model('mc');		
	    $uid = mc_openid2uid($openid);								
	    
	    $rsql = "select id from ".tablename('rule')." where id=".$rid;		
	    $rlist = pdo_fetch($rsql);						
	    if(empty($rlist)){			
	        return $this->respText("二维码已失效！");						
	        exit();		
	    }	

	    $ssql = "select addrepeat from ".tablename('jfb_setting')." where weid=".$uniacid;		
	    $slist = pdo_fetch($ssql);								
	    if(!empty($slist['addrepeat'])){						
	        $repeat = $slist['addrepeat'];				
	    }						
	    
	    $jilu_sql = "select id,addtime from ".tablename('jfb_jifenjilu')." where rid=".$rid." and openid = '".$openid."'  ";				
	    $jilu_list = pdo_fetch($jilu_sql);					
	    if(empty($jilu_list) || $repeat == 1){								
	        $content = $this->message['content'];									
	        $content = str_replace("jlsh_jfb","",$content);												
	        
	        $jifen_sql = "select j.jifennumber,j.codetype,j.jftype,j.content from ".tablename('jfb_jifenlist')." as j left join ".tablename('jfb_qrcode')." as q on j.id = q.rid where j.ruleid=".$rid." and j.weid =".$uniacid;						
	        $jifen_list = pdo_fetch($jifen_sql);									
	        $content = $jifen_list['jifennumber'];						
	        if($jifen_list['codetype'] == 1){	
	            load()->model('mc');
	            	
	            $user = pdo_fetch('select nickname,credit2 from '.tablename('mc_members').' where uid = :uid',array(":uid"=>$uid));																	
	            if(empty($user)){					
	                return $this->respText("充值异常,请告知店员重新生成二维码");				
	            }else{		

	                if($jifen_list['jftype'] == 0)
	                    mc_credit_update($uid,'credit2',$jifen_list['jifennumber'],array($uid,"增加余额".$jifen_list['jifennumber']));
	                else{
	                    if($user['credit2'] < $jifen_list['jifennumber']){
	                        return $this->respText("余额不足,扣除失败!剩余:".$user['credit2']);
	                    }
	                    mc_credit_update($uid,'credit2','-'.$jifen_list['jifennumber'],array($uid,"减少余额".$jifen_list['jifennumber']));
	                }
	                							
	                $cqsql = "SELECT mendian,dianyuan FROM " . tablename('jfb_jifenlist') . " WHERE weid = :weid and ruleid = :ruleid";					
	                $cqlist = pdo_fetch($cqsql,array(':weid'=>$uniacid,':ruleid'=>$rid));
										
					$jilu_data = array(							
					    'weid' => $uniacid,							
					    'title' => '充值',							
					    'yuenum' => $jifen_list['jifennumber'],							
					    'rid' => $rid,							
					    'addtime1' => TIMESTAMP,							
					    'mcid' => $uid,							
					    'mendian' => empty($cqlist)?0:$cqlist['mendian'],							
					    'dianyuan' => empty($cqlist)?0:$cqlist['dianyuan'],														
					    'openid' => $openid,							
					    'jftype' => $jifen_list['jftype'],							
					    'codetype' => 1					
					    
					);					
					pdo_insert('jfb_jifenjilu',$jilu_data);																	
					$mdlist = pdo_fetch("select ifhui,number1 from ".tablename('jfb_mendian')." where weid = :weid and id = :id",array(':weid'=>$uniacid,':id'=>$cqlist['mendian']));										
					if($mdlist['ifhui']==1&&$jifen_list['jftype']==1){												
					    pdo_update("jfb_mendian",array('number1'=>($mdlist['number1'] + $jifen_list['jifennumber']),'numtime1'=>TIMESTAMP),array('id'=>$cqlist['mendian']));												
					        
					    $r_data = array(
							'weid' => $uniacid,
							'mendian' => empty($cqlist)?0:$cqlist['mendian'],
							'yuangong' => empty($cqlist)?0:$cqlist['dianyuan'],
							'mcid' => $uid,
							'type' => 1,								
					        'number' => $jifen_list['jifennumber'],								
					        'addtime' => TIMESTAMP,
						);
						pdo_insert('jfb_recover',$r_data);		
					}

					$ssql = "SELECT * FROM " . tablename('jfb_setting') . " WHERE weid = :weid";					
					$setting = pdo_fetch($ssql,array(':weid'=>$uniacid));	

					$qsql = "SELECT * FROM " . tablename('jfb_qrcode') . " WHERE weid = :weid and rid = :rid";
					$qlist = pdo_fetch($qsql,array(':weid'=>$uniacid,':rid'=>$rid));
					if($repeat == 0){					
					    pdo_delete("rule",array('id'=>$rid));					
					    pdo_delete("rule_keyword",array('rid'=>$rid));										
					    pdo_delete('jfb_qrcode',array('rid'=>$content));
					    if(!empty($qlist))	
					    pdo_delete('qrcode',array('qrcid'=>$qlist['sceneid']));
					}																
					
					if(!empty($setting)){
						$str = str_replace('{nickname}',$user['nickname'],$setting['tishi']);
						$str = str_replace('{jifen}',$jifen_list['jifennumber'],$str);						
						$str = str_replace('积分','余额',$str);

						
						if($jifen_list['jftype'] == 0){
							$str = str_replace('获得','充值',$str);
							$str = str_replace('{sum}',($user['credit2'] + $jifen_list['jifennumber']),$str);
						}
						else{
							$str = str_replace('获得','扣除',$str);
							$str = str_replace('{sum}',($user['credit2'] - $jifen_list['jifennumber']),$str);
						}
						return $this->respText($str);
					}else{
						if($jifen_list['jftype'] == 0)
							return $this->respText("亲爱的".$user['nickname'].',为您充值'.$jifen_list['jifennumber'].',您有'.($user['credit2']+$jifen_list['jifennumber']).'余额');						
						else
							return $this->respText("亲爱的".$user['nickname'].',扣除您'.$jifen_list['jifennumber'].'余额,您有'.($user['credit2']-$jifen_list['jifennumber']).'余额');
					}													
	            }						
	        }else{												
	            if(empty($content)||empty($jifen_list)){										
	                return $this->respText("积分添加异常,请告知店员重新生成二维码");								
	            }else {															
	                $user = pdo_fetch('select nickname,credit1 from '.tablename('mc_members').' where uid = :uid',array(":uid"=>$uid));															
	                if(empty($user)){												
	                    return $this->respText("积分添加异常,请告知店员重新生成二维码");										
	                }else{																								
	                    if($jifen_list['jftype'] == 0)														
	                        mc_credit_update($uid,'credit1',$jifen_list['jifennumber'],array($uid,"增加积分".$jifen_list['jifennumber']));												
	                    else{														
	                        if($user['credit1'] < $jifen_list['jifennumber']){															
	                            return $this->respText("积分不足,扣除失败!剩余:".$user['credit1']);														
	                        }														
	                        mc_credit_update($uid,'credit1','-'.$jifen_list['jifennumber'],array($uid,"减少积分".$jifen_list['jifennumber']));											
	                    }												
	                    $cqsql = "SELECT mendian,dianyuan FROM " . tablename('jfb_jifenlist') . " WHERE weid = :weid and ruleid = :ruleid";						
	                    $cqlist = pdo_fetch($cqsql,array(':weid'=>$uniacid,':ruleid'=>$rid));												
	                    $jilu_data = array(								
	                        'weid' => $uniacid,								
	                        'title' => '积分',								
	                        'jifen' => $jifen_list['jifennumber'],								
	                        'rid' => $rid,								
	                        'addtime' => TIMESTAMP,								
	                        'mcid' => $uid,																
	                        'mendian' => empty($cqlist)?0:$cqlist['mendian'],																
	                        'dianyuan' => empty($cqlist)?0:$cqlist['dianyuan'],																
	                        'openid' => $openid,																
	                        'jftype' => $jifen_list['jftype'],																
	                        'content' => $jifen_list['content']						
	                        
	                    );						
	                    pdo_insert('jfb_jifenjilu',$jilu_data);							
	                    $mdlist = pdo_fetch("select ifhui,number from ".tablename('jfb_mendian')." where weid = :weid and id = :id",array(':weid'=>$uniacid,':id'=>$cqlist['mendian']));
							
						if($mdlist['ifhui']==1&&$jifen_list['jftype']==1){
						
							pdo_update("jfb_mendian",array('number'=>($mdlist['number'] + $jifen_list['jifennumber']),'numtime'=>TIMESTAMP),array('id'=>$cqlist['mendian']));														
							$r_data = array(
									'weid' => $uniacid,
									'mendian' => empty($cqlist)?0:$cqlist['mendian'],
									'yuangong' => empty($cqlist)?0:$cqlist['dianyuan'],
									'mcid' => $uid,
									'type' => 0,
									'number' => $jifen_list['jifennumber'],
									'addtime' => TIMESTAMP,
							);
							pdo_insert('jfb_recover',$r_data);
						}								

						$ssql = "SELECT * FROM " . tablename('jfb_setting') . " WHERE weid = :weid";						
						$setting = pdo_fetch($ssql,array(':weid'=>$uniacid));	
						
						
						$qsql = "SELECT * FROM " . tablename('jfb_qrcode') . " WHERE weid = :weid and rid = :rid";
						$qlist = pdo_fetch($qsql,array(':weid'=>$uniacid,':rid'=>$rid));
						
						if($repeat == 0){																			
						    pdo_delete("rule",array('id'=>$rid));						
						    pdo_delete("rule_keyword",array('rid'=>$rid));												
						    pdo_delete('jfb_qrcode',array('rid'=>$content));	
						    if(!empty($qlist))
						    pdo_delete('qrcode',array('qrcid'=>$qlist['sceneid']));
						}																		
						if(!empty($setting)){														
						    $str = str_replace('{nickname}',$user['nickname'],$setting['tishi']);														
						    $str = str_replace('{jifen}',$jifen_list['jifennumber'],$str);																					
						    if($jifen_list['jftype'] == 0){										
						        $str = str_replace('获得','增加',$str);								
						        $str = str_replace('{sum}',($user['credit1'] + $jifen_list['jifennumber']),$str);							
						    }							
						    else{ 								
						        $str = str_replace('获得','减少',$str);								
						        $str = str_replace('{sum}',($user['credit1'] - $jifen_list['jifennumber']),$str);							
						    }							
						    return $this->respText($str);												
						}else{							
						    if($jifen_list['jftype'] == 0)								
						        return $this->respText("亲爱的".$user['nickname'].',您增加了'.$jifen_list['jifennumber'].'积分,您有'.($user['credit1']+$jifen_list['jifennumber']).'积分');							
						    else 								
						        return $this->respText("亲爱的".$user['nickname'].',您减少了'.$jifen_list['jifennumber'].'积分,您有'.($user['credit1']-$jifen_list['jifennumber']).'积分');						
						}																							
	                }								
	            }						
	        }					
	    }else{							
	        return $this->respText("此二维码已被使用,请联系店员重新生成二维码");					
	    }					
	}
}