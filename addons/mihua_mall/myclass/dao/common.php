<?php 
namespace myclass\dao;

class common{
    protected $table_name;
    protected $table;
    public    $uniacid;
    public    $each_page = 20;
    public    $params    = array();

    public function _set($name,$value){
        $this->$name = $value;
    }
    //赋值全局量
    public function setGlobal(){
        global $_W;
        $this->uniacid   = $_W['uniacid'];
    }
    //设置table  
    public function setTable($table_name){
        $this->table_name = $table_name;
        $this->table      = tablename($table_name);
    }
    //add
    public function add($arr){
        $arr['uniacid']     = $this->uniacid;
        $arr['add_time']    = time();
        pdo_insert($this->table_name,$arr);
        return pdo_insertid();
    }
    //edit
    public function edit($where,$up=false){
        if($up){
            pdo_update($this->table_name,$up,$where);
        }
        $g = 0;
        foreach ($where as $key => $value) {
            if($g!=0){
                $where_str .= " and ";
            }
            $where_str       .= $key."=:{$key} "; 
            $params[":".$key] = $value;
            $g++;
        }
        $result    = pdo_fetch("select * from ".$this->table." where ".$where_str,$params);
        return $result;
    }
    //delete
    public function delete($where,$force=false){
        //非强制则需要加uniacid来删除
        if(!$force){
            $where['uniacid'] = $this->uniacid;
        }
        if($where){
            pdo_delete($this->table_name,$where);
        }
    }
    //获取列表
    public function getList($params,$in_where=false,$pages=1){
        $params[":uniacid"]     = $this->uniacid;
        $where                  = composeParamsToWhere($params);
        if($in_where){
            $where              = $where." and ".$in_where;
        }
        $start                  = $pages>0 ? $pages : 1;
        $limit_sql              = ($start-1)*$this->each_page.','.$this->each_page;
        $count                  = pdo_fetchcolumn("select count(add_time) num from ".$this->table." where ".$where."  ",$params);
        $list                   = pdo_fetchall("select *  from ".$this->table." where ".$where." order by add_time desc limit ".$limit_sql,$params);
        return array('count'=>$count,'list'=>$list);
    }
    public function dataList($params,$in_where=false,$pages=1){
      $this->_set('each_page',100000);
      return $this->getList($params,$in_where,$pages);
    }  

}