<?php

/**
 * controller.php
 * 这不是一个自由软件！。
 * 任何企业和个人不允许对程序代码以任何形式任何目的再发布。
 * 开发: 冰源
 * 日期: 17-12-16
 * 时间: 上午11:14
 */

namespace app;

class controller extends \gd_zlyqkModuleSite
{
    //数据列表
    public function lists(){
        global $_GPC,$_W;
        $tbp=$this->getTabPre();
        $where = " 1=1 and uniacid={$_W['uniacid']} ";
        if(empty($_GPC['tb'])){
            message("参数错误,请重试");
        }
        $tb = strtolower($_GPC['tb']);
        $beforeMethod = "before".ucfirst($tb)."List";
        if(method_exists($this,$beforeMethod)){
            $beforeList = $this->$beforeMethod($where);
        }
        if(empty($beforeList)){
            $listRow =$this->listRow;
            $page =$this->page;
            $total = pdo_fetchcolumn("select count(*) from ".tablename($tbp.$tb)." where $where");
            $totalPage=ceil($total/$listRow);
            $sql = "select * from ".tablename($tbp.$tb). " where ".$where." order by id desc limit ".($this->page-1)*10 ." , ".$this->listRow;
            $dataList =pdo_fetchall($sql);

            $afterMethod = "after".ucfirst($tb)."List";
            if(method_exists($this,$afterMethod)){
                $dataList = $this->$afterMethod($dataList);
            }
            if(isset($dataList['dataList'])){
                foreach($dataList as $key=>$val){
                    $$key=$val;
                }
            }
        }
        $accList=$this->getCokMenu();
        $barMenu=array("add"=>0,"edit"=>0,"list"=>0,'delete'=>0,"desi"=>0,'share'=>0);
        $ad_n=strtolower($tb)."-add";
        $sar_n=strtolower($tb)."-share";
        $ed_n=strtolower($tb)."-edit";
        $rd_n=strtolower($tb)."-recorder";
        $ex_n=strtolower($tb)."-excel";
        $del_n=strtolower($tb)."-delete";
        $desi_n=strtolower($tb)."-desi";
        if(isset($accList[$ad_n]) && $accList[$ad_n]==1){
            $barMenu['add']=1;
        }
        if(isset($accList[$sar_n]) && $accList[$sar_n]==1){
            $barMenu['share']=1;
        }
        if(isset($accList[$ed_n]) && $accList[$ed_n]==1){
            $barMenu['edit']=1;
        }
        if(isset($accList[$del_n]) && $accList[$del_n]==1){
            $barMenu['delete']=1;
        }
        if(isset($accList[$desi_n]) && $accList[$desi_n]==1){
            $barMenu['desi']=1;
        }
        if(isset($accList[$rd_n]) && $accList[$rd_n]==1){
            $barMenu['recorder']=1;
        }
        if(isset($accList[$ex_n]) && $accList[$ex_n]==1){
            $barMenu['excel']=1;
        }
        include $this->template("list");
    }

    //获取表前缀
    public function getTabPre(){
        $plg = explode("_",$this->plugin);
        $tbp = isset($plg[1])?strtolower($plg[1]):'byd';
        return $tbp."_";
    }

    //添加操作
    public function add(){
        global $_W, $_GPC;
        $fresh=isset($_GPC['fresh'])?1:0;
        $tbp=$this->getTabPre();
        if(empty($_GPC['tb'])){
            message("参数错误,请重试");
        }
        $tb = strtolower($_GPC['tb']);
        $beforeMethod = "before".ucfirst($tb)."Add";
        if(method_exists($this,$beforeMethod)){
            $dataList = $this->$beforeMethod();
            if(is_array($dataList)){
                foreach($dataList as $key=>$val){
                    $$key=$val;
                }
            }
        }
        $actMethod=$tb."Act";
        if(method_exists($this,$actMethod)){
            $dataList = $this->$actMethod();
            if(is_array($dataList)){
                foreach($dataList as $key=>$val){
                    $$key=$val;
                }
            }
        }
        if ($this->isAjax) {
            $info = $_GPC['in'];
            $beforeSubmitMethod = "beforeSubmit".ucfirst($tb)."Add";
            if(method_exists($this,$beforeSubmitMethod)){
                $this->$beforeSubmitMethod($info);
            }
            $info['uniacid']=$_W['uniacid'];
            $info['create_time']=time();
            if (pdo_insert($tbp.$tb, $info)) {
                $this->msg['code'] = 1;
                $this->msg['msg'] = "添加成功";
                $afterSave = "after".ucfirst($tb)."Save";
                if(method_exists($this,$afterSave)){
                    $this->$afterSave(pdo_insertid());
                }
            } else {
                $this->msg['msg'] = "添加失败";
            }
            $this->echoAjax();
        }
        include $this->template("add");
    }

    //编辑操作
    public function edit(){
        global $_GPC;
        $tb = strtolower($_GPC['tb']);
        $tbp = $this->getTabPre();
        $id =$_GPC['id'];
        $beforeMethod = "before".ucfirst($tb)."Edit";
        if(method_exists($this,$beforeMethod)){
            $dataList = $this->$beforeMethod();
            if(is_array($dataList)){
                foreach($dataList as $key=>$val){
                    $$key=$val;
                }
            }
        }
        $actMethod=$tb."Act";
        if(method_exists($this,$actMethod)){
            $dataList = $this->$actMethod();
            if(is_array($dataList)){
                foreach($dataList as $key=>$val){
                    $$key=$val;
                }
            }
        }
        if(empty($tb) || empty($id)){
            message("非法操作,刷新重试");
        }
        //记录消息
        $recorder = pdo_get($tbp.$tb,array("id"=>$id));
        if(empty($recorder)){
            message("记录信息已被删除");
        }
        $afterMethod = "after".ucfirst($tb)."Edit";
        if(method_exists($this,$afterMethod)){
            $dataList = $this->$afterMethod($recorder);
            if(is_array($dataList)){
                foreach($dataList as $key=>$val){
                    $$key=$val;
                }
            }
        }
        //如果是保存信息
        if($this->isAjax){
            $info = $_GPC['in'];
            $beforeSubmitMethod = "beforeSubmit".ucfirst($tb)."Edit";
            if(method_exists($this,$beforeSubmitMethod)){
                $this->$beforeSubmitMethod($info);
            }
            if(pdo_update($tbp.$tb,$info,array("id"=>$id))){
                $afterSave = "after".ucfirst($tb)."SaveEd";
                if(method_exists($this,$afterSave)){
                    $this->$afterSave($id);
                }
                $this->msg['msg']="编辑成功";
                $this->msg['code']=1;
                $this->echoAjax();
            }
            $this->msg['msg']="编辑失败";
            $this->echoAjax();
        }
        include $this->template("add");
    }

    //删除操作
    public function delete(){
        global $_GPC;
        $tb = strtolower($_GPC['tb']);
        $tbp = $this->getTabPre();
        $beforeMethod = "before".ucfirst($tb)."Delete";
        $id =$_GPC['id'];
        if(empty($tb) || empty($id)){
            $this->msg['msg']="操作非法,请刷新从试";
            $this->echoAjax();
        }
        if(method_exists($this,$beforeMethod)){
            $this->$beforeMethod($id);
        }
        $tb = $tbp.$tb;
        if(strstr($id,",")){
            $ids = explode(",",$id);
            foreach($ids as $id){
                if(empty($id)){
                    continue;
                }
                pdo_delete($tb,array("id"=>$id));
            }
            $this->msg['code']=1;
            $this->msg['msg']="删除成功";
            $this->echoAjax();
        }
        if(pdo_delete($tb,array("id"=>$id))){
            $this->msg['code']=1;
            $this->msg['msg']="删除成功";
            $this->echoAjax();
        }
        $this->msg['msg']="删除失败";
        echo $this->echoAjax();
    }

    //插件微信路径生成
    public function createPMobileUrl($action,$controller="",$param=array()){
        if(empty($controller)){
            $controller = $this->pClass;
        }
        if(empty($action)){
            $action = $this->pDo;
        }
        $doPath = $controller."_".$action;
        $param['plugin']=$this->plugin;
        return $this->createMobileUrl($doPath,$param);
    }

    //插件后台路径生成
    public function createPWebUrl($action,$controller="",$param=array()){
        if(empty($controller)){
            $controller = $this->pClass;
        }
        if(empty($action)){
            $action = $this->pDo;
        }
        $doPath = "_".$controller."_".$action;
        $param['plugin']=$this->plugin;
        return $this->createWebUrl($doPath,$param);
    }


    //模板编译
    public function template($tp, $flag = TEMPLATE_DISPLAY){
        global $_W;
        $this->pRoot = __DIR__.'/'.$this->plugin;
        $isCom =strstr($tp,'/') ? true:false;
        if($isCom){
            $files = explode("/",$tp);
            $compile = IA_ROOT . "/data/tpl/app/{$_W['template']}/{$this->plugin}/{$files[0]}-{$files[1]}.tpl.php";
        }else{
            $compile = IA_ROOT . "/data/tpl/app/{$_W['template']}/{$this->plugin}/{$this->pClass}-{$tp}.tpl.php";
        }
        if($this->pAdmin){
            if($isCom){
                $source ="/view/admin/".$tp.".html";
            }else{
                $source ="/view/admin/".$this->pClass."/".$tp.".html";
            }
        }else{
            if($isCom){
                $source ="/view/mobile/".$tp.".html";
            }else{
                $source ="/view/mobile/".$this->pClass."/".$tp.".html";
            }
        }
        $tpPath=$this->pRoot.$source;
        if(!is_file($tpPath)) {
            exit("Error: template source '{$source}' is not exist!");
        }
        $paths = pathinfo($compile);
        $compile = str_replace($paths['filename'], $_W['uniacid'] . '_' . $paths['filename'], $compile);
        if (DEVELOPMENT || !is_file($compile) || filemtime($tpPath) > filemtime($compile)) {
            template_compile($tpPath, $compile, true);
        }
        switch ($flag) {
            case TEMPLATE_DISPLAY:
                return $compile;
            default:
                extract($GLOBALS, EXTR_SKIP);
                include $compile;
                break;
            case TEMPLATE_FETCH:
                extract($GLOBALS, EXTR_SKIP);
                ob_flush();
                ob_clean();
                ob_start();
                include $compile;
                $contents = ob_get_contents();
                ob_clean();
                return $contents;
                break;
            case TEMPLATE_INCLUDEPATH:
                return $compile;
                break;
        }
    }
}