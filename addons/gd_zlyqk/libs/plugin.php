<?php
/**
 * plugin.php
 * 这不是一个自由软件！。
 * 任何企业和个人不允许对程序代码以任何形式任何目的再发布。
 * 开发: 冰源
 * 日期: 18-1-20
 * 时间: 下午3:33
 */

namespace ext\libs;


class plugin extends base
{
    //获取插件列表
    public function getPluginList(){
        $pList = array();
        $iList =array();
        $dir = MODULE_ROOT."/apps";
        $fileList= scandir($dir);
        foreach($fileList as $file){
            if($file=="." || $file==".." || $file=="libs") continue;
            $filePath = $dir."/".$file;
            if(!is_dir($filePath)) continue;

            //解析插件
            $settingFile = $filePath."/install.json";
            if(!file_exists($settingFile)) continue;
            $item =json_decode(file_get_contents($settingFile),true);
            $item['cover']= str_replace(IA_ROOT,"",MODULE_ROOT)."/apps/".$item['plugin_str']."/icon.png";
            $pList[]=$item;
        }
        $installList = pdo_getall("gd_plugin");
        foreach($installList as $val){
            $ins[$val['plugin_str']]=$val;
        }
        foreach($pList as $key=>$vl){
            if(isset($ins[$vl['plugin_str']])){
                $pList[$key]['status']=$ins[$vl['plugin_str']]['status'];
            }else{
                $pList[$key]['status']=0;
            }
        }
        return $pList;
    }

    //获取可用插件
    public function getHavePlugin(){
        $haveList = pdo_getall("gd_plugin",array("status"=>1));
        return $haveList;
    }

    //操作插件
    public function actPlugin(){
        global $_GPC;
        $act=$_GPC['d'];
        $name = $_GPC['pl'];
        if($act=='install'){
            $config = MODULE_ROOT."/apps/".$name."/install.json";
            if(!file_exists($config)){
                $this->msg['msg']="插件配置错误";
                $this->echoAjax();
            }
            $config =json_decode(file_get_contents($config),true);
            $config['cover']=str_replace(IA_ROOT,"",MODULE_ROOT)."/apps/".$name."/icon.png";
            $config['create_time']=time();
            $config['status']=1;
            if(pdo_insert("gd_plugin",$config)){
                $sql = MODULE_ROOT."/apps/".$name."/db.sql";
                if(file_exists($sql)){
                    pdo_run(file_get_contents($sql));
                }
                $this->msg['code']=1;
                $this->msg['msg']="安装成功";
                $this->echoAjax();
            }
            $this->msg['msg']="安装成功";
        }else if($act=='resume'){
            pdo_update("gd_plugin",array("status"=>1),array("plugin_str"=>$name));
            $this->msg['code']=1;
            $this->msg['msg']="启用成功";
            $this->echoAjax();
        }else{
            pdo_update("gd_plugin",array("status"=>2),array("plugin_str"=>$name));
            $this->msg['code']=1;
            $this->msg['msg']="停用成功";
            $this->echoAjax();
        }
    }

}