<?php
	//code_start	
	!defined('ZSK_PREFIX') && define('ZSK_PREFIX','azsk_shop');
	$tabJson='There is a json string';
 
	$tabs=pdo_fetchall("SHOW TABLES LIKE '%".ZSK_PREFIX."%'");
	$sys_tables=array(); 
	foreach ($tabs as $sss => $ss) {  
		$tt=array_values($ss); 
		$tab=$tt[0];
		$table=pdo_fetchall("desc `$tab`");
		$s=strpos($tab,ZSK_PREFIX); 
		$tab2=substr($tab,$s,strlen($tab)-$s);
		$sys_tables[$tab2]=$table; 
	}
	$zsk_check_tables=json_decode($tabJson,true); 
	foreach ($zsk_check_tables as $tab => $fields) {  
		$existed=false;
		foreach ($sys_tables as $k => $v) {
			if($tab==$k){
				$existed=true;
			}
		}
		
		//$table=tablename($tab); 
		$table="ims_".$tab; 
		if($debug){
			echo "检查数据表：".$table."\r\n";
		}
		if(!$existed){ 
			$field=$fields[0];
			unset($fields[0]);
			$sql="CREATE TABLE $table (";
			$sql.="`".$field['Field']."` ".$field['Type'];
			if(strtoupper($field['Key'])=="PRI"){
				$sql.=" PRIMARY KEY ";
			}else if(strtoupper($field['Key'])=="UNI"){
				$sql.=" UNIQUE KEY ";
			}
			if(strtoupper($field['Null'])=="NO"){
				$sql.=" NOT NULL ";
			}
			if(strtoupper($field['Key'])!="PRI"&&(strtoupper($field['Key'])!="UNI")){
				 if($field['Default']==NULL){

		          }else if(strtoupper($field['Default'])=="NULL"){
		            $sql.=" DEFAULT NULL ";
		          }else{
		            $sql.=" DEFAULT '".$field['Default']."'";
		          }
			} 
			if(strlen($field['Extra'])>1){
				$sql.=" ".$field['Extra'];
			}
			$sql.=" ) ENGINE=MyISAM DEFAULT CHARSET=utf8;"; 

		 	pdo_query($sql);
		 	if($debug){
				echo  $sql."\r\n";
			}
		} 
		//已经存在这个表
		$sys_fields=pdo_fetchall("DESC $table ");
	 
		foreach ($fields as $key2 => $field) {
			$existed2=false;
			$sameid=null;
			foreach ($sys_fields as $k2=> $v2) {
				if($field['Field']==$v2['Field']){
					$existed2=true;
					$sameid=$k2;
				} 
			}

			if($existed2){
				//存在，检查结构是否一致。
				//ALTER TABLE `ims_azsk_shop_category` CHANGE `uniacid` `uniacid` VARCHAR(30) NULL DEFAULT NULL;
				$sql="ALTER TABLE $table CHANGE `".$field['Field']."` `".$field['Field']."` ".$field['Type']."  "; 
				$changed=false; 
				 
				if(strtoupper($field['Null'])=="NO"){
					$sql.=" NOT NULL ";
					if($field['Default']==NULL){

			        }else if(strtoupper($field['Default'])=="NULL"){
			            $sql.=" DEFAULT NULL ";
			        }else{
			            $sql.=" DEFAULT '".$field['Default']."'";
			        }

				}else if(strtoupper($field['Default'])=="NULL"){
					$sql.=" DEFAULT NULL ";
				}else{
					if($field['Default']==NULL){

			        }else{
			            $sql.=" DEFAULT '".$field['Default']."'";
			        }
				}
				if($sys_fields[$sameid]['Extra']!=$field['Extra']||$sys_fields[$sameid]['Type']!=$field['Type']){
					$sql.=" ".$field['Extra'];
					$changed=true;
				}  
				if($sys_fields[$sameid]['Type']!=$field['Type']){ 
					$changed=true;  
				} 
				if($sys_fields[$sameid]['Null']!=$field['Null']){
					$changed=true;
				} 
				if($sys_fields[$sameid]['Default']!=$field['Default']){
				   $changed=true;
				}
				//暂时无法修改操作主键和自增等特殊操作
				 
				if($changed){ 
					 pdo_query($sql);
					 if($debug){
						echo  $sql."\r\n";
					}
				}
			 
			}else{
				//不存在字段，创建。
				$sql="ALTER TABLE $table ADD ";
				$sql.="`".$field['Field']."` ".$field['Type'];
				if(strtoupper($field['Key'])=="PRI"){
					$sql.=" PRIMARY KEY ";
				}else if(strtoupper($field['Key'])=="UNI"){
					$sql.=" UNIQUE KEY ";
				}
				if(strtoupper($field['Null'])=="NO"){
					$sql.=" NOT NULL ";
					if($field['Default']==NULL){

			        }else if(strtoupper($field['Default'])=="NULL"){
			            $sql.=" DEFAULT NULL ";
			        }else{
			            $sql.=" DEFAULT '".$field['Default']."'";
			        }

				}else if(strtoupper($field['Default'])=="NULL"){
					$sql.=" DEFAULT NULL ";
				}else{
					if($field['Default']==NULL){

			        }else{
			            $sql.=" DEFAULT '".$field['Default']."'";
			        }
				}
				if(strlen($field['Extra'])>1){
					$sql.=" ".$field['Extra'];
				}  
				if($debug){
					echo $sql."\r\n";
				}
				pdo_query($sql); 
			}
		}
		  
	} 
	//update-end
	
	//更新手动操作，上面这一行不要删
	

	//根据版本号来更新内容：
	$tab=tablename('modules');
 	$module=pdo_fetch("SELECT name,version,author FROM $tab WHERE name='zsk_market' LIMIT 1");

 	if(version_compare($module['version'], "6.1.18","<")){
 		//低于3.1.15版本，商家多分类需要改变数据结构，必变新分类有逗号导致原来的分类查不出来
 		$tab=tablename("azsk_shop_setting");
 		$sql="UPDATE $tab set agent='".json_encode(['auto_sign'=>"on","auto_levelup"=>"on"])."' where agent is null";
 		pdo_query($sql);
 	}

	$tab=tablename("azsk_shop_shop");
	$sql="UPDATE $tab SET balance_freezing=0 where balance_freezing<0";
	pdo_query($sql);

//code_end
 