<?php
class cgc_voice_book{
  public function __construct(){
    $this->table_name = __CLASS__;
    $this->columns = "*";
  }

  public function  selectByOpenid ($openid){
    global $_W;
    $uniacid = $_W["uniacid"];
    $ret = pdo_fetch("SELECT ". $this->columns ." FROM ". tablename($this->table_name) ." WHERE uniacid=$uniacid and openid=:openid ",array(":openid"=>$openid));
    return $ret;
  }

  public function deleteAll() {
    global $_W;
    $condition = "`uniacid`=:uniacid";
    $pars = array();
    $pars[":uniacid"] = $_W["uniacid"];
    $sql = "delete FROM " . tablename($this->table_name) . " WHERE {$condition}";
    return pdo_query($sql, $pars);
  }

  public function insert($entity) {
    global $_W;
    $ret = pdo_insert($this->table_name, $entity);
    if(!empty($ret)) {
      $id = pdo_insertid();
      return $id;
    }
    return false;
  }

  public function modify($id, $entity) {
    global $_W;
    $id = intval($id);
    $ret = pdo_update($this->table_name, $entity, array("id"=>$id));
    return $ret;
  }

  public function modifyByOpenid($openid, $entity) {
    global $_W;
    $pars["uniacid"] = $_W["uniacid"];
    $pars["openid"] = $openid; 
    $ret = pdo_update($this->table_name, $entity, $pars);
    return $ret;
  }

  public function delete($id) {
    global $_W;
    $pars = array();
    $pars[":uniacid"] = $_W["uniacid"];
    $pars[":id"] = $id;
    $sql = "DELETE FROM " . tablename($this->table_name) . " WHERE `uniacid`=:uniacid AND `id`=:id";
    $ret=pdo_query($sql, $pars); 
    return $ret;
    }

  public function selectByConAll($con){
    global $_W;
    $uniacid = $_W["uniacid"];
    $ret = pdo_fetchall("SELECT ". $this->columns ." FROM ". tablename($this->table_name) ." WHERE uniacid=$uniacid $con ");
    return $ret;
  }

  public function getOne($id) {
    global $_W;
    $condition = "`uniacid`=:uniacid AND `id`=:id";
    $pars = array();
    $pars[":uniacid"] = $_W["uniacid"];
    $pars[":id"] = $id;
    $sql = "SELECT * FROM " . tablename($this->table_name) . " WHERE {$condition}";
    $entity = pdo_fetch($sql, $pars);
    return $entity;
  }

  public function get($ids){
    global $_W;
    $condition = "`uniacid`=:uniacid AND `id` in (". $ids.")";
    $pars = array();
    $pars[":uniacid"] = $_W["uniacid"];
    $sql = "SELECT * FROM " . tablename($this->table_name) . " WHERE {$condition}";
    $r = pdo_fetchall($sql, $pars);
    return $r;
  }

  public function getAll($con, $pindex = 0, $psize = 20, &$total = 0) {
    global $_W;
    $sql = "SELECT COUNT(*) FROM " . tablename($this->table_name) . " b WHERE {$con}";
    $total = pdo_fetchcolumn($sql);
    $start = ($pindex - 1) * $psize;
    $sql = "SELECT b.*,c.name class_name FROM " . tablename($this->table_name) . " b left join ".tablename('cgc_voice_book_class')." c on b.class = c.id WHERE {$con} ORDER BY `id` desc LIMIT {$start},{$psize}";
    $ds = pdo_fetchall($sql);
    return $ds;
  }
  
  public function getAllAndRead($con, $pindex = 0, $psize = 20, &$total = 0, $openid) {
  	global $_W;
  	$sql = "SELECT COUNT(*) FROM " . tablename($this->table_name) . " WHERE {$con}";
  	$total = pdo_fetchcolumn($sql);
  	$start = ($pindex - 1) * $psize;
  	$sql = "SELECT * FROM (SELECT book.*,study.id isread FROM " . tablename($this->table_name) . " book left join (select * from ".tablename('cgc_voice_book_study')." where openid = '{$openid}') study on book.id=study.book_id) t"
  		." WHERE {$con} ORDER BY `id` desc LIMIT {$start},{$psize}";
  	$ds = pdo_fetchall($sql);
  	return $ds;
  }

  public function getAllColumn($con){
    global $_W;
    $sql = "SELECT COUNT(*) FROM " . tablename($this->table_name) . " WHERE {$con}";
    $total = pdo_fetchcolumn($sql);
    return $total;
  }
}
