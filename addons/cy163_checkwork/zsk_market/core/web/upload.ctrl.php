<?php
// 权限
class upload extends ZskPage{
    public function uploadwb(){
        global $_W,$_GPC;
        session_start();
        $shopid=getShopID(); 
        if(($_FILES["file"]["type"]=="image/png"||$_FILES["file"]["type"]=="image/jpeg"||$_FILES["file"]["type"]=="image/jpg")){
            $filename = md5($_FILES["file"]["name"].time()).'.png';
            $_GPC['groupid']=$_SESSION['groupid'];
            if($_GPC['groupid']!=0){
            $route = ZSK_PATH.'/attachment/images/'.$_W['uniacid'].'/'.$shopid.'/'.$_GPC['groupid'].'/';
            $imageval='images/'.$_W['uniacid'].'/'.$shopid.'/'.$_GPC['groupid']."/".$filename;
            }
            else{
              $route = ZSK_PATH.'/attachment/images/'.$_W['uniacid'].'/'.$shopid.'/';  
              $imageval='images/'.$_W['uniacid'].'/'.$shopid.'/'.$filename; 
          }
          $mode=0777;
            if (!is_dir($route)) 
            {
                 $s=mkdir($route, $mode, true);
            }
            if (is_dir($route)) 
            {
                $stat=move_uploaded_file($_FILES["file"]["tmp_name"],$route.$filename);
            }
            $arr = array(['route'=>$route,'image'=>$filename,'imageval'=>$imageval]);
            if($stat){
                 echo JSON_OUT(['code' => true, 'msg' => '上传成功', 'data' => $arr]); 
            }
            else{
                echo JSON_OUT(['code' => false, 'msg' => '错误提交']);
            }
          
        }else{
            
        }
    }
     public function showpictures(){//查询出上传的所有图片
        global $_W,$_GPC;
        $shopid=getShopID();
        //获取所有图片
            $dir = ZSK_PATH."/attachment/images/".$_W['uniacid'].'/'.$shopid.'/'; 
            $filenames=[];
            $filePath="";
            if (is_dir($dir)){
                if ($dh = opendir($dir)){
                    while (($file = readdir($dh))!= false){
                        //文件名的全路径 包含文件名
                       if(strpos($file,".png")||strpos($value,".jpg")||strpos($value,".jpeg")){
                        $filePath .= "images/".$_W['uniacid'].'/'.$shopid.'/'.$file."|";
                      }
                    }
                    closedir($dh);
                }
            }
            $filenames=explode("|",$filePath); 
            //获取分组
             $model=Model("attachment_group");
            $tabc= $model->tablename("attachment_group");
            $sql="SELECT * FROM $tabc WHERE uniacid=".$_W['uniacid']." and shopid=".$shopid;
        $group=pdo_fetchall($sql);
        $num=count($filenames)-1;
        unset($filenames[$num]);
        // foreach ($filenames as $key => $value) {
        //       if(!strpos($value,".png")&&!strpos($value,".jpg")&&!strpos($value,".jpeg")){
        //         unset($filenames[$key]);
        //       }
        //     }
            echo JSON_OUT(['filenames' => $filenames,'group' => $group]);
     }
         public function addgroup(){//添加分组
           global $_W,$_GPC; 
           $shopid=getShopID(); 
            $uniacid=intval($_W['uniacid']);
            $data=array(
                "type"=>1,
                "uniacid"=>$uniacid,
                "name"=>$_GPC['group'],
                "shopid"=>$shopid,
            );
        $model=Model("attachment_group");
        $res=$model->add($data);
            $tabc= $model->tablename("attachment_group");
            $sql="SELECT * FROM $tabc WHERE id=".$res;
        $group=pdo_fetch($sql); 
         if($res){
            echo json_encode(array('message'=>"保存成功!",'type'=>true,'group'=>$group));
        }else{
            echo json_encode(array('message'=>"保存失败!",'type'=>false,'group'=>$group));
        }

        }
         public function editgroup(){//添加分组
           global $_W,$_GPC; 
           $id=$_GPC['id'];
            $data=array(
                "name"=>$_GPC['group'],
            );
        $model=Model("attachment_group");
        $res=$model->where("id=$id")->save($data);
         if($res){
            echo json_encode(array('message'=>"修改成功!",'type'=>true));
        }else{
            echo json_encode(array('message'=>"修改失败!",'type'=>false));
        }

        }
         public function selectgroup(){//选中分组
             session_start();
             global $_W,$_GPC;
             $_SESSION["groupid"]=$_GPC['id'];
             $id=$_GPC['id'];
             $shopid=getShopID(); 
             if($id){
            $dir = ZSK_PATH."/attachment/images/".$_W['uniacid'].'/'.$shopid.'/'.$id; 
          }
          else{
             $dir = ZSK_PATH."/attachment/images/".$_W['uniacid'].'/'.$shopid; 
          }
            $filenames=[];
            $filePath="";
            if (is_dir($dir)){
                if ($dh = opendir($dir)){
                    while (($file = readdir($dh))!= false){
                        //文件名的全路径 包含文件名
                       if($id){
                        if(strpos($file,".png")||strpos($value,".jpg")||strpos($value,".jpeg")){
                        $filePath .= "images/".$_W['uniacid'].'/'.$shopid.'/'.$id.'/'.$file."|";
                        }
                      }
                      else{
                        if(strpos($file,".png")||strpos($value,".jpg")||strpos($value,".jpeg")){
                         $filePath .= "images/".$_W['uniacid'].'/'.$shopid.'/'.$file."|";
                       }
                      }
                    }
                    closedir($dh);
                }
            }
            $filenames=explode("|",$filePath);
            $num=count($filenames)-1;
            unset($filenames[$num]);
            echo JSON_OUT(['filenames' => $filenames,'group' => $group]);
         }
         public function delpictures(){//删除图片
          global $_W,$_GPC;
          $imgsrcs=json_decode($_POST['imgsrcs'],true);
          foreach ($imgsrcs as $key => $value) {
            var_dump($value);
            $sta=unlink(ZSK_PATH.$value);
          }

         }
         public function delgroup(){//删除分组
          global $_W,$_GPC;
        $uniacid=intval($_W['uniacid']);
        $model=Model("attachment_group"); 
        $id=intval($_GPC['id']);
        $where=" id=$id and uniacid=$uniacid";
        $sts=$model->delete($where); 
        if($sts>0){
          echo json_encode(array('message'=>"删除成功!",'type'=>true));
        }else{
           echo json_encode(array('message'=>"删除失败!",'type'=>true));
        }  
        exit;
         }
    public function uploadwb1(){
        global $_W,$_GPC;
        session_start();
        $shopid=getShopID();
        if(($_FILES["file"]["type"]=="image/png"||$_FILES["file"]["type"]=="image/jpeg"||$_FILES["file"]["type"]=="image/jpg")){
            $filename = md5($_FILES["file"]["name"].time()).'.png';
            $_GPC['groupid']=$_SESSION['groupid'];
            if($_GPC['groupid']!=0){
                $route = ZSK_PATH.'/attachment/images/'.$_W['uniacid'].'/'.$shopid.'/'.$_GPC['groupid'].'/';
                $imageval='images/'.$_W['uniacid'].'/'.$shopid.'/'.$_GPC['groupid']."/".$filename;
            }
            else{
                $route = ZSK_PATH.'/attachment/images/'.$_W['uniacid'].'/'.$shopid.'/';
                $imageval='images/'.$_W['uniacid'].'/'.$shopid.'/'.$filename;
            }
            $mode=0777;
            if (!is_dir($route))
            {
                $s=mkdir($route, $mode, true);
            }

            if (is_dir($route))
            {
                $stat=move_uploaded_file($_FILES["file"]["tmp_name"],$route.$filename);
            }
            $arr = array('title'=>$filename,'src'=>$_W['attachurl'].$imageval,'imageval'=>$imageval);
            if($stat){
                echo JSON_OUT(['code' => 0, 'msg' => '上传成功', 'data' => $arr]);
            }
            else{
                echo JSON_OUT(['code' => false, 'msg' => '错误提交']);
            }
        }else{

        }
    }
}