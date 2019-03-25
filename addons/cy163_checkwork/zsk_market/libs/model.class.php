<?php
class Model
{
	private $prefix = "azsk_shop"; 
    private $table;//表全名
    private $tab;//表缩写名  
	private $sql;//最后一个sql  
	private $debugOn=true;//是否显示sql错误   
	private $preQuerySts=false;//不执行语句返回
	private $wherestr="";
	private $orderstr="";
	private $limitstr=""; 
	private $groupstr="";
	function __construct($name){  
		$this->tab=$this->prefix."_".$name;
		$this->table=" ".tablename($this->prefix."_".$name)." "; 
		 
	}
	function table($name){
		$this->reset();
		$this->table=" ".tablename($this->prefix."_".$name)." "; 
		return $this;
	}
	function reset(){
		$this->wherestr="";
		$this->orderstr="";
		$this->limitstr="";
		$this->groupstr="";
	}
	function tablename($tab){ 
		$table=tablename($this->prefix."_".$tab); 
		return $table;
	}
	//避免字段与关键字冲突记得字段写成这样： `where`
	function where($str=""){
		$this->wherestr=$str; 
		return $this;
	} 
	//避免字段与关键字冲突记得字段写成这样： `limit`
	function limit($str=""){
		$this->limitstr=$str; 
		return $this;
	}
	//避免字段与关键字冲突记得字段写成这样： `order`
	function order($str=""){
		$this->orderstr=$str; 
		return $this;
	}
	//避免字段与关键字冲突记得字段写成这样： `group`
	function group($str=""){
		$this->groupstr=$str; 
		return $this;
	}

	//echo $model->lastSql();//返回最后一次执行的语句
	function lastSql(){
		return $this->sql;
	}  
	//echo $model->preQuery()->save($data);//返回未执行的语句
	function preQuery($stop=true){ 
		$this->preQuerySts=$stop;
		return $this;	
	}
	//是否存在
	function exist($where){
		if(strlen($where)>=3){
			$this->wherestr=$where; 
		}
		$sql= $this->__replace("SELECT * FROM ".$this->table." WHERE 1=1 limit 1");
		$this->reset();
		$this->sql=$sql;
		if($this->preQuerySts==true){
			return $this->sql;
		}else{
			$res=pdo_fetch($sql);
			if(!empty($res)){
				return true;
			} 
		} 
		return false;
	}   
	//获取数量
	function count(){
		$tb=$this->table;
		$sql = $this->__replace("SELECT count(*) as `total` FROM $tb"); 
		$this->reset(); 
		$this->sql=$sql;
		if($this->preQuerySts==true){
			return $this->sql;
		}else{
			$total=pdo_fetchcolumn($sql); 
			return intval($total);
		}  
	}
	//执行普通sql语句，返回结果集或者影响行数
	function query($sql){
		$sql= $this->__replace($sql);
		$this->sql=$sql;
		$this->reset();
		if(preg_match("/insert/i",$sql)>0||preg_match("/INSERT/i",$sql)>0){
			if($this->preQuerySts==true){
				return $this->sql;
			}else{
				$res=pdo_query($sql); 
				return $res;
			}
		}else{
			if($this->preQuerySts==true){
				return $this->sql;
			}else{
				$res=pdo_fetchall($sql);
				return $res;
			}
		}
	}
	//获取所有数据
	function getall($field="*"){
		$tb=$this->table;
		$sql =  $this->__replace("SELECT $field FROM $tb $where $order ");
		$this->sql=$sql;
		$this->reset();
		if($this->preQuerySts==true){
			return $this->sql;
		}else{
			$res = pdo_fetchall($sql);
			return $res;
		}
	}
	//获取单个数据对象
	function get($field="*"){
		$tb=$this->table;
		$this->limitstr="1";
		$sql =  $this->__replace("SELECT $field FROM $tb");
		$this->sql=$sql;
		$this->reset();
		if($this->preQuerySts==true){
			return $this->sql;
		}else{
			$res = pdo_fetch($sql) ;
			return $res;
		}
		
	}
	
	//保存，返回影响行数 
	function save($data){
		$tb=$this->table;
		$set ="";
		foreach ($data as $key => $val) {
			$set.="`$key`='".$val."',";
		}
		$set=substr($set,0,strlen($set)-1);
		$sql =  $this->__replace("UPDATE $tb SET $set $where $limit");
		$this->sql=$sql; 
		$this->reset();
		if($this->preQuerySts==true){
			return $this->sql;
		}else{
			$res=pdo_query($sql);
			return $res;
		}
		
	}
	//返回插入行id
	function add($data){  
		$tb=$this->table;
		$fields="";
		$values="";if(empty($data))return 0;
		foreach ($data as $key => $val) {
			
			$fields.="`".$key."`,";
			$values.='\''.$val.'\',';
		}
		$fields=substr($fields,0,strlen($fields)-1); 
		$values=substr($values,0,strlen($values)-1); 
		$sql =  "INSERT INTO $tb ($fields) VALUES ($values)" ;
		$this->sql=$sql;  
		$this->reset();
		if($this->preQuerySts==true){
			return $this->sql;
		}else{
			$res = pdo_insert($this->tab,$data);  
			return intval(pdo_insertid()); 
		}
		
	} 
	//批量插入
	function addall($datas){
		$tb=$this->table;
		$fields="";
		$values="";
		$buff=true;
		if(count($datas)<1)return false;
		foreach ($datas as $key => $val) {
			if(empty($val))continue;
			$values.="(";
			foreach ($val as $k=> $v) {
				if($buff){
					$fields.="`".$k."`,";
					
				} 
				$values.='\''.$v.'\',';
			}
			$buff=false;
			$values=substr($values,0,strlen($values)-1); 
			$values.="),";
			
		}
		$fields=substr($fields,0,strlen($fields)-1); 
		$values=substr($values,0,strlen($values)-1); 
		$sql =  "INSERT INTO $tb ($fields) VALUES $values;" ;
		$this->sql=$sql;
		$this->reset();
		if($this->preQuerySts==true){
			return $this->sql;
		}else{ 
			 
			$res=pdo_query($sql); 
			return $res; 
		}
	}
	//返回boolean，没有where条件时不执行
	//直接传值覆盖where()传值，如：$m->where("id=2")->delete("id=1");删除id=1
	function delete($where=""){
		$tb=$this->table;	
		$sql="DELETE FROM $tb ";
		if(strlen(trim($where))>2 || strlen($this->wherestr)>0){
			if(strlen(trim($where))>2){
				$this->wherestr=$where;
			}
			$sql =$this->__replace("DELETE FROM $tb ");
			$this->sql=$sql; 
			$this->reset();
			if($this->preQuerySts==true){
				return $this->sql;
			}else{
				$res = pdo_query($sql);
				return intval($res);
			}
		}else { 

			return false;
		}
	} 
	function fetch($sql){
		$this->reset();
		return pdo_fetch($sql);
	}
	//分页，返回array，包括page，pagecount，total，dataset，size
	//例：page("U_ID,U_Name","U_Status=1","U_ID desc")
	//参数全部可缺省，其中page和size使用get或post传上来
	function page($fields="*",$page0=0,$size0=0){
		global $_W,$_GPC;
		$tb=$this->table;  
		$page=1;
		if(intval($_GPC['page'])>0){ 
			$page=intval($_GPC['page']);
		} 
		if(intval($_GPC['size'])>0&&intval($_GPC['size'])<1001){
			$size=intval($_GPC['size']);
		}else{
			$size=10;
		}
		if(intval($page0)>0){
			$page=$page0;
		}
		if(intval($size0)>0){
			$size=$size0;
		}
		$data=array(
			"dataset"=>array(),
			"page"=>$page,
			"pagecount"=>0,
			"count"=>0,
			"size"=>$size,
			"url"=>""//指明下一跳去哪里
		); 
		$sql0= $this->__replace("SELECT count(*) FROM ".$this->table." $where");
		$this->sql=$sql0;
		if($this->preQuerySts==true){
			return $this->sql;
		}else{
			$data['count']=intval(pdo_fetchcolumn($sql0));
		}
		
		$data['pagecount']=ceil($data['count']/$size);
		if($page>$data['pagecount']){//当前页大于页数
			$page=$data['pagecount'];
			$data['page']=$page;
			return $data;
		}
		$start=intval(($page-1)*$size);//开始从第几行查
		$this->limitstr=intval(($page-1)*$size).",$size";
		if($start>$data['count']||$start<0){//条数不符，提前返回
			return $data;
		}	
		$sql= $this->__replace("SELECT $fields FROM ".$this->table." ");
		$this->sql=$sql;
		$this->reset();
		if($this->preQuerySts==true){
			return $this->sql;
		}else{
			$data["dataset"]=pdo_fetchall($sql,array("fields"=>$fields));
			return $data;
		}
		
	}
	//自定义sql分页查询，适用于链表查询，自定义查询。返回array，包括page，pagecount，total，dataset，size
	//pagenation("select a.* from a left join b on a.id=b.aid where a.id=1 ");
	//参数全部可缺省，其中page和size使用get或post传上来,$sql语句格式的 语句中只能出现一次select和from
	function pagenation($sql,$page0=0,$size0=0){
		global $_GPC,$_W;
		if(intval($_GPC['page'])>0){ 
			$page=intval($_GPC['page']);
		}else{
			$page=1;
		}

		if(intval($_GPC['size'])>0&&intval($_GPC['size'])<1001){
			$size=intval($_GPC['size']);
		}else{
			$size=10;
		} 
		if(intval($page0)>0){
			$page=$page0;
		}
		if(intval($size0)>0){
			$size=$size0;
		}
		
	 
		$data=array(
			"dataset"=>array(),
			"page"=>$page,
			"pagecount"=>0,
			"count"=>0,
			"size"=>$size,
			"url"=>""//指明下一跳去哪里
		);
		$strPos2=stripos($sql, "from");
		$sql0="SELECT count(*) FROM ".substr($sql,$strPos2+4,strlen($sql)-($strPos2+4));
		$this->sql=$sql0;
		//var_dump($sql0); 
		if($this->preQuerySts==true){
			return $this->sql0;
		}else{ 
			$pos=stripos($sql0,"group by");
			if($pos!==false){
				$sql0=substr($sql0,0,$pos);
			}
			$data['count']=intval(pdo_fetchcolumn($sql0));
		}
		
		$data['pagecount']=ceil($data['count']/$size);
		if($page>$data['pagecount']){
			$page=$data['pagecount'];
			$data['page']=$page;
			return $data;
		}

		$start=intval(($page-1)*$size);//开始从第几行查
		$this->limitstr=intval(($page-1)*$size).",$size";
		if($start>$data['count']||$start<0){//条数不符，提前返回
			return $data;
		}	
		$sql= $this->__replace($sql);  
		$this->reset();
		if($this->preQuerySts==true){
			return $this->sql;
		}else{
			$data["dataset"]=pdo_fetchall($sql);
			return $data;
		}
	} 
	function pagelimit($sql){
		global $_GPC,$_W;
		if(intval($_GPC['page'])>0){ 
			$page=intval($_GPC['page']);
		}else{
			$page=1;
		}

		if(intval($_GPC['size'])>0&&intval($_GPC['size'])<1001){
			$size=intval($_GPC['size']);
		}else{
			$size=10;
		} 
		if(intval($page0)>0){
			$page=$page0;
		}
		if(intval($size0)>0){
			$size=$size0;
		}
		$strPos2=stripos($sql, "from");
	 
		$data=array(
			"dataset"=>array(),
			"page"=>$page,
			"pagecount"=>0,
			"count"=>0,
			"limitstr"=>"1",
			"size"=>$size,
			"url"=>""//指明下一跳去哪里
		);
		
		$sql0="SELECT count(*) FROM ".substr($sql,$strPos2+4,strlen($sql)-($strPos2+4));
		$this->sql=$sql0;

		//var_dump($sql0); 
		if($this->preQuerySts==true){
			return $this->sql0;
		}else{
			$data['count']=intval(pdo_fetchcolumn($sql0));
		} 
		$data['pagecount']=ceil($data['count']/$size);
		if($page>$data['pagecount']){
			$page=$data['pagecount'];
			$data['page']=$page;
			return $data;
		}

		$start=intval(($page-1)*$size);//开始从第几行查
		$data['limitstr']=intval(($page-1)*$size).",$size";
		return $data;
	} 
	function __replace($sql){//执行一些替换
		global $_W;
		$sql=str_replace(":table", $this->table, $sql);//替换sql语句中的:table  
		$isW=stripos($sql," where ");
		if($isW===false){//不匹配where
			if(strlen(trim($this->wherestr))>2){//替换where
				$sql=$sql." WHERE ".$this->wherestr." ";
			} 
		}else{
			if(strlen(trim($this->wherestr))>2){//替换where
				$sql=str_ireplace("WHERE"," WHERE ".$this->wherestr." AND ", $sql);
			} 
		}
		
		$isG=stripos($sql," group by ");

		if($isG===false){//不匹配group
			if(strlen(trim($this->groupstr))>0){ 
				$sql=$sql."GROUP BY ".$this->groupstr." "; 
			}  
		}else{
			if(strlen(trim($this->groupstr))>0){ 
				$sql=str_ireplace("GROUP BY", " GROUP BY ".$this->groupstr.", ", $sql); 
			}  
		} 
		$isO=stripos($sql," order by ");

		if($isO===false){//不匹配order
			if(strlen(trim($this->orderstr))>3){ 
				$sql=$sql."ORDER BY ".$this->orderstr." "; 
			}  
		}else{
			if(strlen(trim($this->orderstr))>3){ 
				$sql=str_ireplace("ORDER BY", " ORDER BY ".$this->orderstr.", ", $sql); 
			}  
		} 
		$isL=stripos($sql," limit "); 
		if($isL===false){//不匹配limit 
			if(strlen(trim($this->limitstr))>0){ 
				$sql=$sql." LIMIT ".$this->limitstr." "; 
			}  
		}
		//$this->reset();
		return $sql;
	}
	
}