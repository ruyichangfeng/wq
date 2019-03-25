<?php
//获取报名数据
//加载视图
global $_W,$_GPC;

$module='baoming';
$module_chinese="报名";
require_once dirname(__FILE__).'/common_mobile.php';



if(checksubmit('status')){
	$baomingstatus = "baoming";
}elseif(checksubmit('baomingstatus2')){
	$baomingstatus = "请假";
}elseif(checksubmit('baomingstatus3')){
	$baomingstatus = "待定";
}else{
	$baomingstatus=null;
}

if($baomingstatus){
	$data_players=pdo_fetch("SELECT * FROM ".tablename('wactivity_players')." WHERE `openid`=:openid AND `uniacid`=:uniacid",array(':openid'=>$_W['fans']['openid'],':uniacid'=>$_W['uniacid']));	
    $matchid=$_GPC['matchid'];    
    $price=$_GPC['price'];    
    $timebaoming_start=substr($_GPC['timebaoming_start'],0,strpos($_GPC['timebaoming_start']," 星期"));
    $timebaoming_end=substr($_GPC['timebaoming_end'],0,strpos($_GPC['timebaoming_end']," 星期"));

	if($data_players){
		if($data_players['img'] !== $_W['fans']['headimgurl']) {
            $data_players['img']=$_W['fans']['headimgurl'];
            $data_players['create_time']=date('y-m-d h:i:s',time());
            $result=pdo_update('wactivity_players', $data_players, array('openid' => $_W['fans']['openid'],'uniacid'=>$_W['uniacid']));            
            if($result){                 
                echo '<script type="text/javascript">alert("更新会员表头像成功！");</script>';
            }else{
                echo '<script type="text/javascript">alert("更新会员表头像失败！");</script>';
            }
        }		
	$data_baoming['nickname']=$_W['fans']['nickname']; 
	$data_baoming['id']=$data_players['id'];
	$data_baoming['name']=$data_players['name'];
	$data_baoming['baomingstatus']=$baomingstatus;
	$data_baoming['matchid']=$matchid;
	$data_baoming['price']=$price;
	$data_baoming['uniacid']=$_W['uniacid'];
	$data_baoming['create_time']=date('y-m-d h:i:s',time());	

	$data_groups_baomingnum=pdo_fetch("SELECT * FROM ".tablename('wactivity_groups')." WHERE `uniacid`=:uniacid AND `groupname`=:groupname",array(':uniacid'=>$_W['uniacid'],':groupname'=>$data_players['groupname']));

	$data_groups=pdo_fetchall("SELECT * FROM ".tablename('wactivity_groups')." WHERE `uniacid`=:uniacid",array(':uniacid'=>$_W['uniacid']));
	foreach($data_groups as $index_groups=>$item_groups){	
		$str="num".$index_groups;					
		// $data_groups[$index_groups]['havebaomingnum']=$_GPC[$str];
		if($item_groups['groupname'] == $data_players['groupname']){
			$havebaomingnum = $_GPC[$str];
		}
	}		
	
		$data=pdo_fetch("SELECT * FROM ".tablename('wactivity_baoming')." WHERE `matchid`=:matchid AND `id`=:id AND `uniacid`=:uniacid",array(':matchid'=>$data_baoming['matchid'],':id'=>$data_baoming['id'],':uniacid'=>$data_baoming['uniacid']));    
	    if($data){
	        if($data['paystatus'] == 1) {
	            if($data['baomingstatus'] != $data_baoming['baomingstatus']) {		             
	                $result=pdo_update('wactivity_baoming', array('baomingstatus' => $data_baoming['baomingstatus'],'create_time'=>$data_baoming['create_time']), array('matchid' => $data_baoming['matchid'],'id'=>$data_baoming['id'],'uniacid'=>$data_baoming['uniacid']));

	                if($result){	
	                		                     
	                	if($data_baoming['baomingstatus'] == "请假"){	
	                		// if($data['baomingstatus'] == "baoming"){
	                		// 	$data_players['joinnum']-=1;
	                		// 	$data_players['chuqinratio']=$data_players['joinnum']/$data_players['totalnum']*100;
	                			
	                		// 	updatejoinnum($data_players);
	                			
	                		// }		                	
	                        echo '<script type="text/javascript">alert("更改状态为请假成功！");</script>';
		            	}
		            	else if($data_baoming['baomingstatus'] == "待定"){			
		            		// if($data['baomingstatus'] == "baoming"){
	               //  			$data_players['joinnum']-=1;
	               //  			$data_players['chuqinratio']=$data_players['joinnum']/$data_players['totalnum']*100;
	               //  			updatejoinnum($data_players);
	               //  		}            	
	                        echo '<script type="text/javascript">alert("更改状态为待定成功！");</script>';
		            	}
	                    else if($data_baoming['baomingstatus'] == "baoming"){		
	                    	
	        			// $data_players['joinnum']+=1;
	        			// $data_players['chuqinratio']=$data_players['joinnum']/$data_players['totalnum']*100;
	        			// updatejoinnum($data_players);
	                		                   
	                        echo '<script type="text/javascript">alert("更改状态为报名成功！");</script>';
	                    }
	                }else{		                    
	                    echo '<script type="text/javascript">alert("操作失败，请重新操作一次！");</script>';
	                }
	            } else{
	            	message('您已经报过本场活动，请勿重复报名！', $this->createMobileUrl('baoming', array()), 'error');
	                //echo '<script type="text/javascript">alert("您已经报过本场活动，请勿重复报名！");</script>'; 
	            }	            
	        }else{
	            if($data_baoming['baomingstatus'] == 'baoming'){  
	                $data_baoming['baomingid']=$data['baomingid'];   

	                if($data_baoming['price']>0){	

	                	$result=pdo_update('wactivity_baoming', array('baomingstatus' => $data_baoming['baomingstatus'],'create_time'=>$data_baoming['create_time']), array('matchid' => $data_baoming['matchid'],'id'=>$data_baoming['id'],'uniacid'=>$data_baoming['uniacid']));
	                	
	                	if($result){
	                		$tid=sprintf('%010s',$data_baoming['baomingid']).time();	
	      		                		      	
		                    $params = array(
								'tid' => $tid,      //充值模块中的订单号，此号码用于业务模块中区分订单，交易的识别码
								'ordersn' => $data_baoming['baomingid'],  //收银台中显示的订单号
								'title' => '活动费用',          //收银台中显示的标题
								'fee' => $data_baoming['price'],      //收银台中显示需要支付的金额,只能大于 0
								'user' => $_W['member']['uid'],     //付款用户, 付款的用户名(选填项)
							);
							//调用pay方法								
							$this->pay($params);
						}else{
		                    echo '<script type="text/javascript">alert("报名失败，请重新操作一次！");</script>';    
		                }
	                }else{
	                    $data_baoming['paystatus']=1;		                    
	                    $result=pdo_update('wactivity_baoming', array('baomingstatus' => $data_baoming['baomingstatus'],'create_time'=>$data_baoming['create_time']), array('matchid' => $data_baoming['matchid'],'id'=>$data_baoming['id'],'uniacid'=>$data_baoming['uniacid']));
	                    if($result){	
	                    	// $data_players['joinnum']+=1;
	                    	// $data_players['chuqinratio']=$data_players['joinnum']/$data_players['totalnum']*100;
	                    	// updatejoinnum($data_players);	

	                        echo '<script type="text/javascript">alert("更改状态为报名成功！");</script>';
	                    }else{		                        
	                        echo '<script type="text/javascript">alert("操作失败，请重新操作一次！");</script>';
	                    }
	                }
	            }else{
	                if($data['baomingstatus'] != $data_baoming['baomingstatus']) {		                    
	                    $result=pdo_update('wactivity_baoming', array('baomingstatus' => $data_baoming['baomingstatus']), array('matchid' => $data_baoming['matchid'],'id'=>$data_baoming['id'],'uniacid'=>$data_baoming['uniacid']));
	                    if($result){		                         
	                         if($data_baoming['baomingstatus'] == "请假"){				                	
	                            echo '<script type="text/javascript">alert("更改状态为请假成功！");</script>';
			            	}
			            	else if($data_baoming['baomingstatus'] == "待定"){
	                            echo '<script type="text/javascript">alert("更改状态为待定成功！");</script>';
			            	}
	                    }else{
	                        echo '<script type="text/javascript">alert("操作失败，请重新操作一次！");</script>';
	                    }
	                } else{
	                	message('您已经报过本场活动，请勿重复报名！', $this->createMobileUrl('baoming', array()), 'error');
	                    //echo '<script type="text/javascript">alert("您已经报过本场活动，请勿重复报名！");</script>';
	                }		                
	            }
	        }
	        
	    } else{
	        if($data_baoming['baomingstatus'] == 'baoming'){
	        	if($data_groups_baomingnum['expect_baomingnum'] <= $havebaomingnum){
					message('报名人数已满，请下次活动尽早报名！', $this->createMobileUrl('baoming', array()), 'error');
				}else{
		            if($data_baoming['price']>0){
		                $data_baoming['paystatus']=0; 		                              
		                $result=pdo_insert('wactivity_baoming',$data_baoming);
		                if($result){
		                    $data_baoming['baomingid']=pdo_insertid();   
		                    
		                    $tid=sprintf('%010s',$data_baoming['baomingid']).time();
		                    $params = array(
								'tid' => $tid,      //充值模块中的订单号，此号码用于业务模块中区分订单，交易的识别码
								'ordersn' => $data_baoming['baomingid'],  //收银台中显示的订单号
								'title' => '活动费用',          //收银台中显示的标题
								'fee' => $data_baoming['price'],      //收银台中显示需要支付的金额,只能大于 0
								'user' => $_W['member']['uid'],     //付款用户, 付款的用户名(选填项)
							);
							//调用pay方法
							$this->pay($params); 		                    
		                }else{
		                    echo '<script type="text/javascript">alert("报名失败，请重新操作一次！");</script>';    
		                }
		            }else{
		                $data_baoming['paystatus']=1;
		                $result=pdo_insert('wactivity_baoming',$data_baoming);
		                if($result){
		                	// $data_players['joinnum']+=1;
		                	// $data_players['chuqinratio']=$data_players['joinnum']/$data_players['totalnum']*100;
		                	// updatejoinnum($data_players);
		                    echo '<script type="text/javascript">alert("报名成功！");</script>';
		                }else{  
		                    echo '<script type="text/javascript">alert("报名失败，请重新操作一次！");</script>';     
		                }
		            }
		        }
	               
	        }else{
	            $result=pdo_insert('wactivity_baoming',$data_baoming);
	            if($result){
	                if($data_baoming['baomingstatus'] == "请假"){
	                    echo '<script type="text/javascript">alert("请假成功！");</script>';
	            	}
	            	else if($data_baoming['baomingstatus'] == "待定"){
	                    echo '<script type="text/javascript">alert("待定成功！");</script>';
	            	}
	            }else{
	                echo '<script type="text/javascript">alert("操作失败，请重新操作一次！");</script>';
	            }
	        }   
	    }
	    header('location:' . $this->createMobileUrl('baoming', array()));
		
	}else{
		message('请补充您的姓名和电话信息,方便及时联系您', $this->createMobileUrl('addusers', array()), 'success');
		//header('location:' . $this->createMobileUrl('addusers', array()));
	}
}else{
	
	list($data_matches_new,$data_total_group)=displaydetails($module,$module_chinese);	
	include $this->template("baoming");
}
