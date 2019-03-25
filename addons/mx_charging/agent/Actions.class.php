<?php
	class Actions{
		protected $links;
		protected $db_fix; //后缀名
		public function __construct(){
			require_once "db_config.php";		
			 $this->db_fix = $config['db']['master']['tablepre']."xc_";
			$dsn = 'mysql:dbname='.$config['db']['master']['database'].';host='.$config['db']['master']['host'].'';
			try {
				$dbh = new PDO($dsn, $config['db']['master']['username'],$config['db']['master']['password'],array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8';"));
				$this->links = $dbh;
			} catch (PDOException $e) {
				return  $e->getMessage();
			}
		}
		//检查数据表是否正常传递
		public function check_table($data){
			if(!empty($data['table'])){
				return $this->db_fix .$data['table'];
			}else{
				echo "<script>alert('检查数据表是否正常传递');</script>";
				return false;
			}
		}
		//检查查询字段是否传递
		public function check_field($data){
			if(!empty($data['field'])){
				return $data['field'];
			}else{
				return "*";
			}
		}
		//检查条件是否存在
		public function check_where($data){
			if(!empty($data['where'])){
				return " where ".$data['where'];
			}else{
				return "";
			}
		}
		//检测条数是否存在
		public function check_limit($data){
			if(!empty($data['limit'])){
				return " limit ".$data['limit'];
			}else{
				return "";
			}
		}
		//检测排序是否存在
		public function check_order($data){
			if(!empty($data['order'])){
				return " order by ".$data['order'];
			}else{
				return "";
			}
		}	
		//数据添加
		public function Add($tab,$data){  // $tab(string) ,$where(array)
			$field_str = ""; //字段
			$bind_str = ""; //占位符
			$value_str = []; //字段值数组格式
			foreach($data as $k=>$v){
				$field_str .= $k.",";
				$bind_str .= "?,";
				$value_str[] = $v;
			}
			$sql="insert into ".$this->db_fix .$tab."(".trim($field_str,",").") values(".trim($bind_str,",").")";
			$stmt=$this->links->prepare($sql); 
			$stmt->execute($value_str);
			$result = $this->links->lastInsertId();			
			if($result){
				return $result;
			}else{
				return false;
			}
		}
		
		//数据单条查询,where....and, 返回索引数组
		public function  Find($data){		
			$sql="select ".$this->check_field($data)."  from ".$this->check_table($data) . $this->check_where($data)."";
			//print_r($sql);
			//file_put_contents("1.txt",$sql);
			$stmt=$this->links->prepare($sql);
			$stmt->execute();
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			if($result){
				return $result[0];
			}else{
				return false;
			}
		}		
		//数据结果集查询,条件可以无条件
		public function Select($data){			
			$sql="select ".$this->check_field($data)."  from ".$this->check_table($data)." ".$this->check_where($data)." ".$this->check_order($data)." ".$this->check_limit($data)."";
			//print_r($sql);			
			$stmt=$this->links->prepare($sql);
			$stmt->execute();
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			if($result){
				return $result;
			}else{
				return false;
			}			
		}
      
      //单条数据库不带前缀，需写数据表全称
		public function  Find2($data,$tab){		
			$sql="select ".$this->check_field($data)."  from ".$tab . $this->check_where($data)."";
			//print_r($sql);
			$stmt=$this->links->prepare($sql);
			$stmt->execute();
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			if($result){
				return $result[0];
			}else{
				return false;
			}
		}
		//图表求和
		public function getSUM($uniacid,$aid){	
			//循环 年 -  月 - 日
			for($i = 7; $i > 0; $i--){		
				$date_strtotime_y[] =  date('Y-m-d', strtotime('-'.($i+1).' day'))."|".date('Y-m-d', strtotime('-'.$i.' day'));  //年月日
			}
			$str ="";
			for($i=0;$i<count($date_strtotime_y);$i++){
				 $date_arr = explode("|",$date_strtotime_y[$i]);
				//开始时间时间戳  --- 结束时间时间戳			
				
				$sql="select SUM(pay_money) from  ".$this->db_fix."financial"." where uniacid= ".$uniacid." and status=1 and aid=".$aid." and times between '".strtotime($date_arr[0])."' and '".strtotime($date_arr[1])."'";

				
				$selectAllCount = $this->links->prepare($sql);
				$selectAllCount->execute();
				$count[] = $selectAllCount->fetchColumn(0);	
		   } 

		   
		   return $count;
		
		}
		
		
		
		
		
		//反应影响行数
		public function getCount($data){			
			$sql="select ".$this->check_field($data)."  from ".$this->check_table($data)." ".$this->check_where($data)." ".$this->check_order($data)." ".$this->check_limit($data)."";
			//print_r($sql);
			$stmt=$this->links->prepare($sql);
			$stmt->execute();
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			if($result){
				return count($result);
			}else{
				return false;
			}			
		}
		
		//单条数据编辑处理,返回影响行数
		public function Update($data,$value){  //			
			$field_str = "";
			$value_arr = [];
			foreach($value as $k=>$v){
				$field_str .= $k."=?,";
				$value_arr[] = $v;
			}
			$sql="update ".$this->check_table($data)." set ".trim($field_str,",")." ".$this->check_where($data)."";
			//print_r($sql);
			//exit;
			$stmt = $this->links->prepare($sql);
			$result=$stmt->execute($value_arr);
			if($result){
				return $result;
			}else{
				return false;
			}
		}
		
		//数据删除
		public function Del($data){
			$sql="delete from ".$this->check_table($data)." ".$this->check_where($data)."";
			//print_r($sql);
			$stmt=$this->links->prepare($sql);
			$result=$stmt->execute();
			if($result){
				return true;
			}else{
				return false;
			} 
		}
		
		//成功跳转
		public function success($msg,$url){
			echo "<script>alert('$msg');window.location.href='$url';</script>";
			exit;
		}
		//失败跳转
		public function error($msg){
			echo  "<script>alert('$msg');window.history.back();</script>";
			exit;
		}
		function __destruct(){
			$this->links=null;
			
		}
	
	}