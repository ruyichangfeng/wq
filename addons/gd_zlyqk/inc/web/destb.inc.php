<?php
global $_GPC,$_W;
//保存注册扩展信息
$id =$_GPC['id'];
$formInfo=pdo_get("gd_zlk",array("id"=>$id));
if($this->isAjax){
    $dataList=json_decode(htmlspecialchars_decode($_GPC['data']),true);
    $formArr=$this->parseDesForm($dataList);
    //创建信息表,如果表存在更新字段
    //创建表,如果不存在
    $update['xml']=json_encode($formArr);
    if(empty($formInfo['table'])){
        $tableName="gd_zlk_".rand(1000,9999);
        $update['table']=$tableName;
        foreach($formArr as $val){
            $col=$val['py'];
            $colSql .="  `".$col."` text , ";
        }
        $createSql="CREATE TABLE ".tablename($tableName)." (`id` int(11) NOT NULL AUTO_INCREMENT,`uniacid` int(11) NOT NULL DEFAULT '0',".$colSql." `create_time` int  DEFAULT 0,`status` int  DEFAULT 1,PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        pdo_run($createSql);
    }else{//更新表结构
        $fCols=array();
        $addCols=array();
        $tableName =tablename($formInfo['table']);
        $cols= pdo_fetchallfields($tableName);
        foreach($cols as $vl){
            $fCols[$vl]=$vl;
        }
        foreach($formArr as $val){
            if(!isset($fCols[$val['py']])){
                $addCols[]=$val;
            }
        }
        $addCol="";
        $div="";
        foreach($addCols as $val){
            $col=$val['py'];
            $div = empty($addCol) ? " " : " , ";
            $addCol .=" $div ADD COLUMN `".$col."` text  ";
        }
        if(!empty($addCol)){
            $addSql="ALTER TABLE `".$tableName."`".$addCol.";";
            pdo_run($addSql);
        }
    }
    $isInsert=pdo_update("gd_zlk",$update,array("id"=>$id));
    if($isInsert){
        $this->msg['code']=1;
        $this->msg['msg']="保存成功";
        $this->echoAjax();
    }
    $this->msg['msg']="保存失败";
    $this->echoAjax();
}
$postUrl=$this->createWebUrl('destb',array("id"=>$id));
$formArr = json_decode($formInfo['xml'],true);
foreach($formArr as $key=>$val){
    if(in_array($val['type'],array("select","radio"))){
        $formArr[$key]['pl']=explode(",",$val['pl']);
    }
}
include $this->template("design_col");