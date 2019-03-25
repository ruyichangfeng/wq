<?php

global $_GPC;
$this->baseDir = $basePath = IA_ROOT."/addons/gd_zlyqk";
$version =$_GPC["version"];
$url = $this->OsUrl."getConfigs?version=".$version;
$fileList = file_get_contents($url);
$fileListArr=json_decode($fileList,true);
foreach($fileListArr as $key=> $file){
    $local = $this->baseDir."/".$file['name'];
    $dir = dirname($local);
    if(!file_exists($dir)){
        mkdir($dir,0777,true);
        $this->fileList[$key]['name']=$file['name'];
        $this->fileList[$key]['local']=$local;
    }else if(!file_exists($local)){
        $this->fileList[$key]['name']=$file['name'];
        $this->fileList[$key]['local']=$local;
    }else if(filemtime($local)<$file['time']){
        $this->fileList[$key]['name']=$file['name'];
        $this->fileList[$key]['local']=$local;
    }
}
echo json_encode(array("total"=>count($this->fileList),'file'=>$this->fileList));