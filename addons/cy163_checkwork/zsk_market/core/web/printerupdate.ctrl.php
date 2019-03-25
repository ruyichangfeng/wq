 <?php
 class Printerupdate extends ZskPage
 { 
    //模板设置start
 	public function index(){
 		 global $_W,$_GPC; 
        $model=Model("printertemplete");
        $tabc= $model->tablename("printertemplete");
        $sql="SELECT * FROM $tabc WHERE uniacid=".$_W['uniacid'];
        $tplist=pdo_fetchall($sql);
 		include $this->template("web/printerupdate/printertemplete");
 	}
    public function addtemplete(){
        global $_W,$_GPC; 
        $uniacid=intval($_W['uniacid']);
        $data=array(
            "type"=>2,
            "uniacid"=>$uniacid,
            "name"=>$_GPC['tpname'],
            "type"=>$_GPC['tptype'],
            "height"=>130,
        );
        $model=Model("printertemplete");
        $res=$model->add($data);
         if($res){
            echo json_encode(array('message'=>"保存成功!",'redirect' => routeUrl('printerupdate.index'), 'type'=>true));
        }else{
            echo json_encode(array('message'=>"保存失败!",'redirect' => routeUrl('printerupdate.index'), 'type'=>false));
        }
    }
     public function delcate(){
         global $_W,$_GPC;
        $uniacid=intval($_W['uniacid']);
        $model=Model("printertemplete"); 
        $id=intval($_GPC['id']);
        $where=" id=$id and uniacid=$uniacid";
        $sts=$model->delete($where); 
        if($sts>0){
            message("删除成功",$this->routeUrl("printerupdate.index"));
        }else{
            message("删除失败",$this->routeUrl("printerupdate.index"));
        }  
        exit;
    }
     public function editview(){
        global $_W,$_GPC;
        $uniacid=intval($_W['uniacid']);
        $model=Model("printertemplete");
        $id=intval($_GPC['id']); 
        $item=$model ->where(" id=".$id." and uniacid=$uniacid")->get("*");
        $item['bgr']=$item['bg'];
        $item['bg']=$_W['attachurl'].$item['bg'];
        if($item['type']==1){//店铺名片2:3
            $widthr="600px";
            $heightr="900px";
        }
        if($item['type']==2){//商品二维码2:3
            $widthr="600px";
            $heightr="900px";
        }
        if($item['type']==3){//价格标签3:2
            $widthr="900px";
            $heightr="600px";
        }
        if($item['type']==4){//出货单:A4
            $widthr="595px";
            $heightr="842px";
        }
        $elements=json_decode($item['datas'],true);
        //处理图片
         foreach ($elements as $key => $value) {
            $width=$value['width'];
            $height=$value['height'];
            if(strpos($value['string'],'goodcode') !== false){
                 $elements[$key]['string']="<img src='".ZSK_STATIC."dsg/img/goodcode.jpg' style='width:".$width.";height:".$height."' >";
            }
            if(strpos($value['string'],'goodpicture') !== false){
                 $elements[$key]['string']="<img src='".ZSK_STATIC."dsg/img/goodpicture.jpg' style='width:".$width.";height:".$height."' >";
            }
            if(strpos($value['string'],'storecode') !== false){
                 $elements[$key]['string']="<img src='".ZSK_STATIC."dsg/img/storecode.jpg' style='width:".$width.";height:".$height."' >";
            }
            if(strpos($value['string'],'storelogo') !== false){
                 $elements[$key]['string']="<img src='".ZSK_STATIC."dsg/img/storelogo.jpg' style='width:".$width.";height:".$height."' >";
            }
             if(strpos($value['string'],'pricecode') !== false){
                 $elements[$key]['string']="<img src='".ZSK_STATIC."dsg/img/pricecode.jpg' style='width:".$width.";height:".$height."' >";
            }
             if(strpos($value['string'],'pricepicture') !== false){
                 $elements[$key]['string']="<img src='".ZSK_STATIC."dsg/img/pricepicture.jpg' style='width:".$width.";height:".$height."' >";
            }
        }
        include $this->template("web/printerupdate/post");
        exit;
    }
    public function savetemplete(){
        global $_W,$_GPC;
        $uniacid=intval($_W['uniacid']);
        $model=Model("printertemplete");
        $id=intval($_GPC['id']);
        //处理图片字符串
        $datas=json_decode($_POST['datas'],true);
        foreach ($datas as $key => $value) {
            if(strpos($value['string'],'goodcode') !== false){
                 $datas[$key]['string']="goodcode";
            }
            if(strpos($value['string'],'goodpicture') !== false){
                 $datas[$key]['string']="goodpicture";
            }
             if(strpos($value['string'],'storecode') !== false){
                 $datas[$key]['string']="storecode";
            }
             if(strpos($value['string'],'storelogo') !== false){
                 $datas[$key]['string']="storelogo";
            }
             if(strpos($value['string'],'pricecode') !== false){
                 $datas[$key]['string']="pricecode";
            }
             if(strpos($value['string'],'pricepicture') !== false){
                 $datas[$key]['string']="pricepicture";
            }
        }
        $datas=JSON_OUT($datas);
        $data=array(
            "datas"=>$datas,
            "bg"=>$_POST['bg'],
            "height"=>$_POST['height'],
            "width"=>$_POST['width'],
        ); 
        $res=$model->where("id=$id and uniacid=$uniacid")->save($data);
        if($res){
            echo json_encode(array('message'=>"模板保存成功!",'redirect' => $this->routeUrl("printerupdate.editview")."&id=".intval($_GPC['id']), 'type'=>true));
        }else{
            echo json_encode(array('message'=>"模板保存失败!",'redirect' => routeUrl('printerupdate.index'), 'type'=>false));
        }
    }
    //海报打印start
    public function printer(){
         global $_W,$_GPC; 
          $attachurl=$_W['attachurl'];
          $shopid=getShopID(); 
        $model=Model("printertemplete");
        $tabc= $model->tablename("printertemplete");
        $sql="SELECT * FROM $tabc WHERE uniacid=".$_W['uniacid'];
        $tplist=pdo_fetchall($sql);
        // foreach ($tplist as $key1 => $value1) {
        //      $tplist[$key1]['datas']=json_decode($value1['datas'],true);
        //      $tplist[$key1]['bg']=json_decode($value1['bg'],true);
        //  }
        foreach ($tplist as $key1 => $value1) {
            $item= $tplist[$key1]['type'];
          if($item['type']==1){//店铺名片2:3
            $widthr="200px";
            $heightr="300px";
        }
        if($item['type']==2){//商品二维码2:3
            $widthr="200px";
            $heightr="300px";
        }
        if($item['type']==3){//价格标签3:2
            $widthr="300px";
            $heightr="200px";
        }
        $tplist[$key1]['bg']=$_W['attachurl'].$tplist[$key1]['bg'];
        $tplist[$key1]['widthr']=$widthr;
        $tplist[$key1]['heightr']=$heightr;
        $tplist[$key1]['datas']=json_decode($value1['datas'],true);
             //处理图片
         foreach ($tplist[$key1]['datas'] as $key => $value) {
             $width=$value['width']/3;
             $height=$value['height']/3;
             $tplist[$key1]['datas'][$key]['top']= $tplist[$key1]['datas'][$key]['top']/3;
             $tplist[$key1]['datas'][$key]['width']= $tplist[$key1]['datas'][$key]['width']/3;
             $tplist[$key1]['datas'][$key]['height']= $tplist[$key1]['datas'][$key]['height']/3;
              $tplist[$key1]['datas'][$key]['size']= $tplist[$key1]['datas'][$key]['size']/3;
              $tplist[$key1]['datas'][$key]['left']= $tplist[$key1]['datas'][$key]['left']/3;
            if(strpos($value['string'],'goodcode') !== false){
                 $tplist[$key1]['datas'][$key]['string']="<img src='".ZSK_STATIC."dsg/img/goodcode.jpg' style='width:".$width.";height:".$height."' >";
            }
            if(strpos($value['string'],'goodpicture') !== false){
                 $tplist[$key1]['datas'][$key]['string']="<img src='".ZSK_STATIC."dsg/img/goodpicture.jpg' style='width:".$width.";height:".$height."' >";
            }
            if(strpos($value['string'],'storecode') !== false){
                 $tplist[$key1]['datas'][$key]['string']="<img src='".ZSK_STATIC."dsg/img/storecode.jpg' style='width:".$width.";height:".$height."' >";
            }
            if(strpos($value['string'],'storelogo') !== false){
                $tplist[$key1]['datas'][$key]['string']="<img src='".ZSK_STATIC."dsg/img/storelogo.jpg' style='width:".$width.";height:".$height."' >";
            }
             if(strpos($value['string'],'pricecode') !== false){
                $tplist[$key1]['datas'][$key]['string']="<img src='".ZSK_STATIC."dsg/img/pricecode.jpg' style='width:".$width.";height:".$height."' >";
            }
             if(strpos($value['string'],'pricepicture') !== false){
                 $tplist[$key1]['datas'][$key]['string']="<img src='".ZSK_STATIC."dsg/img/pricepicture.jpg' style='width:".$width.";height:".$height."' >";
            }
        }
        }
        $ay= array(
            '0' =>1 ,
            '1' =>2 ,
            '2' =>3 ,
             );
        $tplist2=JSON_OUT($tplist);

        //商品分类和商品
        $model=Model("category");
        $uniacid=intval($_W['uniacid']);
        $goodscates=$model->where("uniacid='".$_W['uniacid']."' and parentid=0 and status>0")->order("sort desc")->getall("id,name,logo");
        $model=Model("goods");
        $uniacid=intval($_W['uniacid']);
        $goodslist=$model->where("uniacid='".$_W['uniacid']."' and shopid='".$shopid."'")->getall("*");
        //当前店铺
        $model=Model("shop");
        $uniacid=intval($_W['uniacid']);
        $shop=$model->where("uniacid='".$_W['uniacid']."' and id=".$shopid)->get(" * ");
        $shop['express']=json_decode($shop['express'],true);
        $shop=JSON_OUT($shop);
        include $this->template("web/printerupdate/printer");
    }
     public function printerjson(){
         global $_W,$_GPC;
          $shopid=getShopID();  
        $model=Model("printertemplete");
        $tabc= $model->tablename("printertemplete");
        $sql="SELECT * FROM $tabc WHERE uniacid=".$_W['uniacid'];
        $tplist=pdo_fetchall($sql); 
        foreach ($tplist as $key1 => $value1) {
          $tplist[$key1]['bg']=$_W['attachurl'].$tplist[$key1]['bg'];
           $tplist[$key1]['datas']=json_decode($value1['datas'],true);
        }
        //商品分类和商品
        $model=Model("category");
        $uniacid=intval($_W['uniacid']);
        $goodscates=$model->where("uniacid='".$_W['uniacid']."' and parentid=0 and status>0")->order("sort desc")->getall("id,name,logo");
        foreach ($goodscates as $key => $value) {//查询出所有的子分类
           $goodscateschild=$model->where("uniacid='".$_W['uniacid']."' and  parentid=".$value['id'])->order("sort desc")->getall("id,name,logo");
           $childid=",";
           foreach ($goodscateschild as $key2 => $value2) {
              $childid.=$value2['id'].',';
           }
            $childid.=$value['id'].',';
            $goodscates[$key]["childcateid"]=$childid;
        }
        $model=Model("goods");
        $uniacid=intval($_W['uniacid']);
        $goodslist=$model->where("uniacid='".$_W['uniacid']."' and shopid='".$shopid."'")->getall("id,shopid,cateid,uniacid,name,picture,price,price0");
        //当前店铺
        $model=Model("shop");
       
        $uniacid=intval($_W['uniacid']);
        $shop=$model->where("uniacid='".$_W['uniacid']."' and id=".$shopid)->get(" * ");
        $shop['express']=json_decode($shop['express'],true);
        //获取店铺二维码
        $setting=getSetting(true);
          $wxjs=new WeixinJS($setting['appid'],$setting['secret']);
          $tk=$wxjs->getToken();
          $token=$tk['access_token']; 
          $url="https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=".$tk['access_token'];
          $json='{ 
            "scene":"'.$shopid.'",
            "page":"zsk_market/pages/shop/index",
            "width":200
          }';
          $qrcode=CURL_image($url,$json,true);
           if(intval($qrcode['errcode'])==40001){//access_token不正确
                  $tk=$wxjs->getToken(true);//强制获取token 
                 $url="https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=".$tk['access_token'];
                 $qrcode=CURL_image($url,$json,true); 
             }
             $shop['qrcode']=$qrcode;   

        $attachurl=$_W['attachurl'];
      echo JSON_OUT( array('shop' =>$shop ,'tplist2' =>$tplist,'attachurl' =>$attachurl,'goodscates' =>$goodscates,'goodslist' =>$goodslist ));
    }
     public function printerjsonorder(){
         global $_W,$_GPC;
        $shopid=getShopID();  
        $model=Model("printertemplete");
        $tabc= $model->tablename("printertemplete");
        $sql="SELECT * FROM $tabc WHERE uniacid=".$_W['uniacid']." and type=4";
        $tplist=pdo_fetch($sql); 
        $tplist['bg']=$_W['attachurl'].$tplist['bg'];
        $tplist['datas']=json_decode($tplist['datas'],true);
        foreach ($tplist['datas'] as $key => $value) {
            $tplist['datas'][$key]['string1']=$value['string'];
        }
        $attachurl=$_W['attachurl'];
      echo JSON_OUT( array('tplist2' =>$tplist,'attachurl' =>$attachurl));
    }
     public function orderdataone(){
         global $_W,$_GPC;
        $model=Model("order");
        $shopid=getShopID(); 
        $shop=Model("shop")->where("uniacid='".$_W['uniacid']."' and id=".$shopid)->get(" * ");
        $shop['express']=json_decode($shop['express'],true);
        $a= $model->tablename("order");
        $b= $model->tablename("member");
        $sql="SELECT a.*,b.nickname FROM $a as a LEFT JOIN ".$b."as b ON  a.openid=b.openid  WHERE a.order_no='".$_GPC['id']."'    group by a.id";
        $order=pdo_fetch($sql); 
         $a= $model->tablename("orderdetail");
         $b= $model->tablename("goods");
         $c= $model->tablename("goodscase");
        $sql="SELECT * FROM $a as a LEFT JOIN ".$b."as b ON  a.goodsid=b.id LEFT JOIN ".$c."as c ON  a.goodscaseid=c.id  WHERE a.order_no='".$_GPC['id']."'    group by a.id";
        $orderdetail=pdo_fetchall($sql); 
        $order['orderdetail']=$orderdetail;
      echo JSON_OUT( array('data' =>$order,'shop' =>$shop));
    }
    public function orderdataonepintuan(){
         global $_W,$_GPC;
        $model=Model("order");
        $shopid=getShopID(); 
        $shop=Model("shop")->where("uniacid='".$_W['uniacid']."' and id=".$shopid)->get(" * ");
        $shop['express']=json_decode($shop['express'],true);
        $a= $model->tablename("order");
        $b= $model->tablename("member");
        $sql="SELECT a.*,b.nickname FROM $a as a LEFT JOIN ".$b."as b ON  a.openid=b.openid  WHERE a.order_no='".$_GPC['id']."'    group by a.id";
        $order=pdo_fetch($sql);
         $a= $model->tablename("orderdetail");
         $b= $model->tablename("goods");
         $c= $model->tablename("goodscase");
        $sql="SELECT * FROM $a as a LEFT JOIN ".$b."as b ON  a.goodsid=b.id LEFT JOIN ".$c."as c ON  a.goodscaseid=c.id  WHERE a.order_no='".$_GPC['id']."'    group by a.id";
        $orderdetail=pdo_fetchall($sql); 
        $order['orderdetail']=$orderdetail;
      echo JSON_OUT( array('data' =>$order,'shop' =>$shop));
    }
    public function selectgoodscode(){
         global $_W,$_GPC;
         $goods=json_decode($_POST['goods'],true);
         //商品小程序码
        foreach ($goods as $key => $value) {
          $setting=getSetting(true);
          $uniacid=intval($_W['uniacid']);
          $shopid=getShopID();
          $wxjs=new WeixinJS($setting['appid'],$setting['secret']);
          $tk=$wxjs->getToken();
          $token=$tk['access_token']; 
          $url="https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=".$tk['access_token'];
          $json='{ 
            "scene":"'.$value['id'].'",
            "page":"zsk_market/pages/details/index",
            "width":200
          }';
          $qrcode=CURL_image($url,$json,true);
           if(intval($qrcode['errcode'])==40001){//access_token不正确
                  $tk=$wxjs->getToken(true);//强制获取token 
                 $url="https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=".$tk['access_token'];
                 $qrcode=CURL_image($url,$json,true); 
             }
             $goods[$key]['qrcode']=$qrcode;   
        }
      echo JSON_OUT( array('goods' =>$goods));
    }


}