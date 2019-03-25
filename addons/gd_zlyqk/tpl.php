<?php
defined('IN_IA') or exit('Access Denied');
error_reporting(0);
class tpl extends WeModuleSite{

    public $fHeader="";
    public $footer="";

    public $photo="";
    public $voice="";
    public $baseH="";
    public $baseF="";
    public $pNum=1;
    public $pName,$vName;
    public $price=0;
    public $property=array();
    public $propertyFm;
    public $isHeader=false;

    public $subMenu="";

    public $_fHeader="";
    public $_footer="";

    public $_photo="";
    public $_voice="";
    public $_baseH="";
    public $_baseF="";
    public $_pNum=1;
    public $_pName,$_vName;
    public $_price=0;
    public $_property=array();
    public $_propertyFm;
    public $_isHeader=false;
    public $_subMenu="";
    public $med="";
    public $memberInfo;
    public $adminInfo;

    public function createMobileForm($appId,$memberInfo,$adminInfo){
        $this->memberInfo =$memberInfo;
        $this->adminInfo =$adminInfo;
        $appPay=pdo_get("gd_app",array("id"=>$appId));
        $property=isset($appPay['property'])?json_decode($appPay['property'],true):array();
        $appInfo = pdo_get("gd_source_form",array("app_id"=>$appId));
        $page="";
        $page .=$this->_hidden("app_id",$appId);
        $page .=$this->_hidden("_fm","index");
        $form = empty($appId)?array():json_decode($appInfo['source'],true);
        if($appPay['tpl']!="index"){
            return $form;
        }
        $isShow = (!isset($appPay)|| $appPay['is_submit']==0)?true:false;
        $search=false;
        foreach($form as $val){
            if($val['type']=='search'){
                $search=true;
            }
            $func="_".$val['type'];
            $page .= $this->$func($val);
        }
//        foreach($property as $val){
//            $this->property[]=pdo_get("gd_property",array("id"=>$val));
//        }
//        $this->propertyFm=$this->createProperty();
        if(!empty($this->fHeader)){
            $this->fHeader .=$this->propertyFm;
            $this->fHeader .="</div>";
        }
        $html = $this->fHeader.$page.$this->baseH.$this->photo.$this->voice.$this->med.$this->baseF;
        $html .=$this->footer;
        $menu =$this->getMenus($isShow,$search);
        if(!empty($html)){
            $html .=$menu;
        }
        return $html;
    }

    public function getMenus($showBtn=true,$search=false){
        $show="";
        $this->subMenu="";
        if($showBtn){
            $display="";
            if($search){
                $display=" style='display:none' ";
            }
            $this->subMenu='
                <div class="weui-btn-area" '.$display.'>
                    <a class="weui-btn weui-btn_primary form_submit" href="javascript:" id="showTooltips">确定</a>
                </div> 
        ';
        }
        return $this->subMenu;
    }

    //添加数据
    public function createProperty(){
        if(empty($this->property)){
            return "";
        }
        $option="";
        foreach($this->property as $val){
            $pay="";
            if($val['pay']>0){
                $pay = "(支付".$val['pay']."元)";
            }
            $option .= '<option value="'.$val["id"].'">'.$val['name'].$pay.'</option>';
        }
        $el ='
            <div class="weui-cell weui-cell_select"  style="padding-left: 15px;">
                <div class="weui-cell__hd">
                    <label for="" class="weui-label  them-title">级别</label>
                </div>
                <div class="weui-cell__bd">
                    <select class="weui-select" name="property" style="padding-left:0">
                        <option value="0">默认</option>'
                        .$option.
                    '</select>
                </div>
            </div>';
        return $el;
    }

    public function createFrom($memberInfo,$adminInfo,$flowId,$nodeId,$recorderId,$appId,$lineId,$nodeInfo=false,$payMoney=0){
        global $_GPC,$_W;
        $this->memberInfo=$memberInfo;
        $this->adminInfo =$adminInfo;
        if(!$nodeInfo){
            $nodeInfo = pdo_get("gd_node",array("flow_id"=>$flowId,'id'=>$nodeId));
        }
        $this->price=$payMoney;
        $page="";
        $page .=$this->_hidden("app_id",$appId);
        $page .=$this->_hidden("line_id",$lineId);
        $page .=$this->_hidden("recorder_id",$recorderId);
        $page .=$this->_hidden("flow_id",$nodeInfo['flow_id']);
        $page .=$this->_hidden("node_id",$nodeInfo['id']);
        $page .=$this->_hidden("_fm","mark");
        $form = json_decode($nodeInfo['form_list'],true);
        //如果线路单独配置了表单则,需要替换伟单独线路
        $lineInfo = pdo_get("gd_preline",array("line_id"=>$lineId,'flow_id'=>$flowId));
        if(!empty($lineInfo) && !empty($lineInfo['form_list'])){
            $form = json_decode($lineInfo['form_list'],true);
        }
        if(isset($_GPC['check'])){
            $hasUrl="";
            $hasSer="";
            $cls ="";
            $totalCol=0;
            $hidCol=0;
            foreach($form as $val){
                $totalCol +=1;
                if($val['type']=='url' && $val['pl']!=""){
                    $hasUrl = $val['pl'];
                    $uid = $_W['member']['uid'];
                    if(strstr($hasUrl,"?")){
                        $hasUrl .="&uid=".$uid;
                    }else{
                        $hasUrl .="?uid=".$uid;
                    }
                    $hidCol +=1;
                }
                if($val['type']=='doser'){
                   $cls=$val['py'];
                   $hasSer=$val['pl'];
                    $hidCol +=1;
                }
                if($val['type']=='remind'){
                    $hidCol +=1;
                }
            }
            if((empty($form) || $totalCol==$hidCol) && $payMoney==0 ){
                $this->msg['data'] ="app_id=".$appId."&line_id=".$lineId."&recorder_id=".$recorderId."&flow_id=".$nodeInfo['flow_id']."&node_id=".$nodeInfo['id']."&_fm=mark";
                if($hasSer){
                    $this->msg['data']=$this->msg['data']."&$cls=$hasSer";
                }
                $this->msg['url']=$hasUrl;
                $this->echoAjax();
            }else{
                $this->msg['code']=1;
                $this->echoAjax();
            }
        }
        foreach($form as $val){
            $func="_".$val['type'];
            $page .= $this->$func($val);
        }
        if(!empty($this->fHeader)){
            $this->fHeader .="</div>";
        }
        $html = $this->fHeader.$page.$this->baseH.$this->photo.$this->voice.$this->med.$this->baseF;
        $html .=$this->footer;
        $menu = $this->getMenus();
        if(!empty($html)){
            $html .=$menu;
        }
        return $html;
    }

    //创建注册表单
    public function createRegisterForm($form){
        $page="";
        foreach($form as $val){
            $func="_".$val['type'];
            $page .= $this->$func($val);
        }
        return $page;
    }

    public function _hidden($name,$val){
        $this->isHeader=true;
        return "<input type='hidden' name='{$name}' value='{$val}'>";
    }

    public function _url($node){
        global $_W;
        $url = $node['pl'];
        if(empty($url)) return "";
        $uid = $_W['member']['uid'];
        if(strstr($url,"?")){
            $url .="&uid=".$uid;
        }else{
            $url .="?uid=".$uid;
        }
        return "<input type='hidden' class='zh_url'  value='{$url}'>";
    }

    public function _sms($node){
        $this->isHeader=true;
        $require=" weiui-require ";
        $ele='
                <div class="weui-cell them-cell">
                    <div class="weui-cell__hd">
                        <label for="" class="weui-label  them-title">电话</label>
                    </div>
                    <div class="weui-cell__bd">
                        <input  class="weui-input '.$require.' " style="font-size:15px;" name='.$node['py'].' id="sms"   type="number" placeholder="请填写手机号" data-msg="请填写手机号码" nullmsg="请填写手机号" datatype="n11-11" errormsg="手机号长度为11字符" />
                    </div>
                </div>
                <div class="weui-cell them-cell">
                    <div class="weui-cell__hd">
                        <label for="" class="weui-label  them-title">验证码</label>
                    </div>
                    <div class="weui-cell__bd">
                        <input  class="weui-input '.$require.' " style="font-size:15px;" name="sms_code" id="sms_code"   type="number" nullmsg="请填写验证码" datatype="n4-6"  errormsg="验证码长度错误"  data-msg="请填写验证码" placeholder="验证码" />
                    </div>
                    <div class="weui-cell__ft"  style="width:100px;height:30px;padding-right:10px;">
                        <input type="button" class="weui-btn weui-btn_mini weui-btn_primary sms_code_get" value="获取验证码"  >
                    </div>
                </div>
        ';
        return $ele;
    }

    public function _point($node){
        $this->isHeader=true;
        return "<input type='hidden' name='".$node['py']."' value='".$node['pl']."' ><input type='hidden' name='points' value='".$node['pl']."' >";
    }

    public function _input($node){
        $this->isHeader=true;
        $mPl=empty($node['pl'])?'请填写'.$node['label']:$node['pl'];
        $require="";
        $nullMsg="";
        $errMsg="";
        if($node['rq']){
            $require=" weiui-require ";
            $nullMsg='nullmsg="请填写'.$node['label'].'"';
            $errMsg='  datatype="*" ';
        }
        if(intval($node['len'])>0){
            $nullMsg='nullmsg="请填写'.$node['label'].'"';
            if(strstr($node['len'],"-")){
                $errMsg='  datatype="*'.$node['len'].'" errormsg="'.$node['label'].'长度是'.$node['len'].'字符" ';
            }else{
                $errMsg='  datatype="*'.$node['len'].'-'.$node['len'].'" errormsg="'.$node['label'].'长度是'.$node['len'].'字符" ';
            }
        }
        $val = $this->funcVal($node);
        $ele='
                <div class="weui-cell them-cell">
                    <div class="weui-cell__hd">
                        <label for="" class="weui-label  them-title"> '.$node["label"].'</label>
                    </div>
                    <div class="weui-cell__bd">
                        <input class="weui-input '.$require.' " value="'.$val.'" name="'.$node['py'].'" type="text" data-msg="请填写'.$node['label'].'" '.$nullMsg.' '.$errMsg.' placeholder="'.$mPl.'"/>
                    </div>
                </div>
        ';
        return $ele;
    }

    public function _search($node){
        $this->isHeader=true;
        $mPl=empty($node['pl'])?'请输入'.$node['label']:$node['pl'];
        $require="";
        $nullMsg="";
        $errMsg="";
        if($node['rq']){
            $require=" weiui-require ";
            $nullMsg='nullmsg="请输入'.$node['label'].'"';
            $errMsg='  datatype="*" ';
        }
        if(intval($node['len'])>0){
            $nullMsg='nullmsg="请输入'.$node['label'].'"';
            if(strstr($node['len'],"-")){
                $errMsg='  datatype="*'.$node['len'].'" errormsg="'.$node['label'].'长度是'.$node['len'].'字符" ';
            }else{
                $errMsg='  datatype="*'.$node['len'].'-'.$node['len'].'" errormsg="'.$node['label'].'长度是'.$node['len'].'字符" ';
            }
        }
        $val = $this->funcVal($node);
        $ele='
                <div class="weui-cell them-cell search_box" data-class="'.$node['py'].'">
                    <div class="weui-cell__hd">
                        <label for="" class="weui-label  them-title lb"> '.$node["label"].'</label>
                    </div>
                    <div class="weui-cell__bd ">
                        <input class="weui-input search_change '.$require.'" data-id="'.$node['pl'].'" data-class="'.$node['py'].'"  type="text" data-msg="请输入'.$node['label'].'" '.$nullMsg.' '.$errMsg.' placeholder="请输入'.$node['label'].'"/>
                        <input type="hidden" class="lvse" name="'.$node['py'].'" value="">
                    </div>
                    <div class="weui-cell__ft search_icon" style="display: none">
                        <i class="weui-icon-warn hd_icon"></i>
                    </div>
                </div>
        ';
        return $ele;
    }

    public function _map($node){
        $info=$node['pl'];
        $arrInfo = explode("|",$info);
        $lc = explode(",",$arrInfo[1]);
        $ele='<div class="weui-cell them-cell" style="padding: 10px;"><div  id="container" style="height:200px;width: 100%;" data-name="'.$arrInfo[0].'" data-lat="'.$lc[1].'" data-lnt="'.$lc[0].'">'.$arrInfo[0].'</div></div>';
        return $ele;
    }

    public function _inku($node){
        $this->isHeader=true;
        $require="";
        //获取项目数量
        $storeId = $node['pl'];
        //获取表信息
        $storeInfo = pdo_get("gd_zlk",array("id"=>$storeId));
        $colInfo =json_decode($storeInfo['xml'],true);
        $nameCol="";
        $priceCol="";
        foreach($colInfo as $val){
            if($val['type']=="price"){
                $priceCol=$val['py'];
            }
            if($val['type']=="name"){
                $nameCol=$val['py'];
            }
        }
        //获取项目信息
        $goodsList =pdo_getall($storeInfo['table']);
        $ele ='
            <div class="weui-cell weui-cell_select" style="padding-left: 15px;color:#999999 !important;">
                 <div class="weui-cell__hd">
                        <label for="" class="weui-label  them-title"> '.$storeInfo['name'].'</label>
                 </div>
                <div class="weui-cell__bd">
                    <select class="weui-select store_box" name="ku_info" style="padding-left:0;color:#999999 !important;">';
                    foreach($goodsList as $key=> $val){
                        if($key==0){
                            $ele .=' <option selected  value="'.$val['id'].'-'.$storeId.'-'.$val[$priceCol].'">'.$val[$nameCol].'</option>';
                        }else{
                            $ele .=' <option  value="'.$val['id'].'-'.$storeId.'-'.$val[$priceCol].'">'.$val[$nameCol].'</option>';
                        }
                    }
                $ele .='</select>
                </div>
            </div>
        ';
        $mPl=empty($node['pl'])?'请填写'.$node['label']:$node['pl'];
        $nullMsg="";
        $errMsg="";
        if($node['rq']){
            $require=" weiui-require ";
            $nullMsg='nullmsg="请填写'.$node['label'].'"';
            $errMsg='  datatype="*" ';
        }
        if(intval($node['len'])>0){
            $nullMsg='nullmsg="请填写'.$node['label'].'"';
            if(strstr($node['len'],"-")){
                $errMsg='  datatype="*'.$node['len'].'" errormsg="'.$node['label'].'长度是'.$node['len'].'字符" ';
            }else{
                $errMsg='  datatype="*'.$node['len'].'-'.$node['len'].'" errormsg="'.$node['label'].'长度是'.$node['len'].'字符" ';
            }
        }
        $val = $this->funcVal($node);
        $ele .='
                <div class="weui-cell">
                    <div class="weui-cell__hd">
                        <label for="" class="weui-label"> '.$node["label"].'</label>
                    </div>
                    <div class="weui-cell__bd">
                        <input class="weui-input in_num cac_num'.$require.' " value="'.$val.'" name="'.$node['py'].'" type="text" '.$nullMsg.' '.$errMsg.' data-msg="请填写'.$node['label'].'"  placeholder="'.$mPl.'"/>
                    </div>
                </div>
        ';
        return $ele;
    }

    public function _outku($node){
        $this->isHeader=true;
        $require="";
        //获取项目数量
        $storeId = $node['pl'];
        //获取表信息
        $storeInfo = pdo_get("gd_zlk",array("id"=>$storeId));
        $colInfo =json_decode($storeInfo['xml'],true);
        $nameCol="";
        $priceCol="";
        foreach($colInfo as $val){
            if($val['type']=="price"){
                $priceCol=$val['py'];
            }
            if($val['type']=="name"){
                $nameCol=$val['py'];
            }
        }
        //获取项目信息
        $goodsList =pdo_getall($storeInfo['table']);
        $ele ='
            <div class="weui-cell weui-cell_select" style="padding-left: 15px;color:#999999 !important;">
                 <div class="weui-cell__hd">
                        <label for="" class="weui-label  them-title"> '.$storeInfo['name'].'</label>
                 </div>
                <div class="weui-cell__bd">
                    <select class="weui-select store_box" name="ku_info" style="padding-left:0;color:#999999 !important;">';
        foreach($goodsList as $key=> $val){
            if($key==0){
                $ele .=' <option selected  value="'.$val['id'].'-'.$storeId.'-'.$val[$priceCol].'">'.$val[$nameCol].'</option>';
            }else{
                $ele .=' <option  value="'.$val['id'].'-'.$storeId.'-'.$val[$priceCol].'">'.$val[$nameCol].'</option>';
            }
        }
        $ele .='</select>
                </div>
            </div>
        ';
        $mPl=empty($node['pl'])?'请填写'.$node['label']:$node['pl'];
        $nullMsg="";
        $errMsg="";
        if($node['rq']){
            $require=" weiui-require ";
            $nullMsg='nullmsg="请填写'.$node['label'].'"';
            $errMsg='  datatype="*" ';
        }
        if(intval($node['len'])>0){
            $nullMsg='nullmsg="请填写'.$node['label'].'"';
            if(strstr($node['len'],"-")){
                $errMsg='  datatype="*'.$node['len'].'" errormsg="'.$node['label'].'长度是'.$node['len'].'字符" ';
            }else{
                $errMsg='  datatype="*'.$node['len'].'-'.$node['len'].'" errormsg="'.$node['label'].'长度是'.$node['len'].'字符" ';
            }
        }
        $val = $this->funcVal($node);
        $ele .='
                <div class="weui-cell">
                    <div class="weui-cell__hd">
                        <label for="" class="weui-label"> '.$node["label"].'</label>
                    </div>
                    <div class="weui-cell__bd">
                        <input class="weui-input in_num cac_num'.$require.' " value="'.$val.'" name="'.$node['py'].'" type="text" '.$nullMsg.' '.$errMsg.'  data-msg="请填写'.$node['label'].'"  placeholder="'.$mPl.'"/>
                    </div>
                </div>
        ';
        return $ele;
    }

    public function _mobile($node){
        $this->isHeader=true;
        $require="";
        $nullMsg="";
        $errMsg="";
        if($node['rq']){
            $require=" weiui-require ";
            $nullMsg='nullmsg="请填写'.$node['label'].'"';
            $errMsg='  datatype="*" ';
        }
        if(intval($node['len'])>0){
            $nullMsg='nullmsg="请填写'.$node['label'].'"';
            if(strstr($node['len'],"-")){
                $errMsg='  datatype="*'.$node['len'].'" errormsg="'.$node['label'].'长度是'.$node['len'].'字符" ';
            }else{
                $errMsg='  datatype="*'.$node['len'].'-'.$node['len'].'" errormsg="'.$node['label'].'长度是'.$node['len'].'字符" ';
            }
        }
        $val = $this->funcVal($node);
        $mPl=empty($node['pl'])?'请填写'.$node['label']:$node['pl'];
        $ele = '
                <div class="weui-cell them-cell">
                    <div class="weui-cell__hd">
                        <label for="" class="weui-label  them-title"> '.$node["label"].'</label>
                    </div>
                    <div class="weui-cell__bd">
                        <input class="weui-input '.$require.' " value="'.$val.'" type="number" name="'.$node['py'].'"  '.$nullMsg.' '.$errMsg.'  data-msg="请填写'.$node['label'].'" placeholder="'.$mPl.'" />
                    </div>
                </div>
        ';
        return $ele;
    }

    public function _city($node){
        $this->isHeader=true;
        $require="";
        $nullMsg="";
        $errMsg="";
        if($node['rq']){
            $require=" weiui-require ";
            $nullMsg='nullmsg="请选择'.$node['label'].'"';
            $errMsg='  datatype="*" ';
        }
        if(intval($node['len'])>0){
            $nullMsg='nullmsg="请选择'.$node['label'].'"';
            if(strstr($node['len'],"-")){
                $errMsg='  datatype="*'.$node['len'].'" errormsg="'.$node['label'].'长度是'.$node['len'].'字符" ';
            }else{
                $errMsg='  datatype="*'.$node['len'].'-'.$node['len'].'" errormsg="'.$node['label'].'长度是'.$node['len'].'字符" ';
            }
        }
        $mPl=empty($node['pl'])?'请选择'.$node['label']:$node['pl'];
        $ele = '
                <div class="weui-cell them-cell">
                    <div class="weui-cell__hd">
                        <label for="" class="weui-label  them-title"> '.$node["label"].'</label>
                    </div>
                    <div class="weui-cell__bd">
                        <input class="weui-input city '.$require.' " type="text" name="'.$node['py'].'" readonly onfocus="this.blur()" data-msg="请选择'.$node['label'].'" '.$nullMsg.' '.$errMsg.' placeholder="'.$mPl.'" />
                    </div>
                </div>
            <link rel="stylesheet" href="/addons/gd_zlyqk/static/address/css/LArea.min.css">
            <script src="/addons/gd_zlyqk/static/address/js/LAreaData1.js"></script>
            <script src="/addons/gd_zlyqk/static/address/js/LArea.js"></script>
        ';
        return $ele;
    }

    public function _child($node){
//        $this->isHeader=true;
//        $require="";
//        $nullMsg="";
//        $errMsg="";
//        if($node['rq']){
//            $require=" weiui-require ";
//            $nullMsg='nullmsg="请填写'.$node['label'].'"';
//        }
//        if(intval($node['len'])>0){
//            if(strstr($node['len'],"-")){
//                $errMsg='  datatype="*'.$node['len'].'" errormsg="'.$node['label'].'长度是'.$node['len'].'字符" ';
//            }else{
//                $errMsg='  datatype="*'.$node['len'].'-'.$node['len'].'" errormsg="'.$node['label'].'长度是'.$node['len'].'字符" ';
//            }
//        }else{
//            $errMsg='  datatype="*" ';
//        }
//        $ele = '
//            <div class="weui-cells__title" style="margin-top:0.5rem">
//                '.$node['label'].'
//            </div>
//            <div class="weui-cells weui-cells_form child-group">
//                <input class="weui-input fina_col'.$require.' " type="hidden" name="'.$node['py'].'" data-msg="请选择'.$node['label'].'"  '.$nullMsg.' '.$errMsg.'  placeholder="请填写列" />
//                <div class="weui-cell weui-cell_vcode">
//                    <div class="weui-cell__hd">
//                        <input class="weui-input header" type="text" placeholder="列名" style="width:100px;" />
//                    </div>
//                    <div class="weui-cell__bd">
//                        <input class="weui-input body" type="text"   placeholder="列值" />
//                    </div>
//                    <div class="weui-cell__ft" style="height:45px;">
//                        <img class="addimg" src="/addons/gd_zlyqk/static/mobile/css/ad.png" style="width:25px;margin-top:10px;margin-right:55px;">
//                    </div>
//                </div>
//            </div>
//        ';
//        return $ele;
        return "";
    }

    public function _date($node){
        $require="";
        $date=date("Y-m-d",time());
        $this->isHeader=true;
        $mPl=empty($node['pl'])?$node['label']:$node['pl'];
        $nullMsg="";
        $errMsg="";
        if($node['rq']){
            $require=" weiui-require ";
            $nullMsg='nullmsg="请选择'.$node['label'].'"';
            $errMsg='  datatype="*" ';
        }
        $ele = '
                <div class="weui-cell them-cell">
                    <div class="weui-cell__hd">
                        <label for="" class="weui-label  them-title"> '.$node["label"].'</label>
                    </div>
                    <div class="weui-cell__bd">
                        <input class="weui-input date_ui '.$require.' " name="'.$node['py'].'" type="date" value="'.$date.'" '.$nullMsg.' '.$errMsg.' data-msg="请选择日期"  placeholder="'.$mPl.'" />
                    </div>
                </div>
        ';
        return $ele;
    }

    public function _time($node){
        $this->isHeader=true;
        $require="";
        $mPl=empty($node['pl'])?$node['label']:$node['pl'];
        $nullMsg="";
        $errMsg="";
        if($node['rq']){
            $require=" weiui-require ";
            $errMsg='  datatype="*" ';
            $nullMsg='nullmsg="请选择'.$node['label'].'"';
        }
        $ele = '
                <div class="weui-cell them-cell">
                    <div class="weui-cell__hd">
                        <label for="" class="weui-label  them-title"> '.$node["label"].'</label>
                    </div>
                    <div class="weui-cell__bd">
                        <input class="weui-input date_ui '.$require.' " name="'.$node['py'].'" '.$nullMsg.' '.$errMsg.' type="datetime-local" value="" data-msg="请选择时间"  placeholder="'.$mPl.'" />
                    </div>
                </div>
        ';
        return $ele;
    }

    public function _number($node){
        $this->isHeader=true;
        $require="";
        $nullMsg="";
        $errMsg="";
        $df = empty($node['pl'])?0:$node['pl'];
        if($node['rq']){
            $require=" weiui-require ";
            $nullMsg='nullmsg="请填写'.$node['label'].'"';
            $errMsg='  datatype="*" ';
        }
        if(intval($node['len'])>0){
            $nullMsg='nullmsg="请填写'.$node['label'].'"';
            if(strstr($node['len'],"-")){
                $errMsg='  datatype="*'.$node['len'].'" errormsg="'.$node['label'].'长度是'.$node['len'].'字符" ';
            }else{
                $errMsg='  datatype="*'.$node['len'].'-'.$node['len'].'" errormsg="'.$node['label'].'长度是'.$node['len'].'字符" ';
            }
        }
        $mPl='请填写'.$node['label'];
        $ele = '
                <div class="weui-cell them-cell">
                    <div class="weui-cell__hd">
                        <label for="" class="weui-label  them-title"> '.$node["label"].'</label>
                    </div>
                    <div class="weui-cell__bd">
                        <input class="weui-input cac_num'.$require.' " value="'.$df.'" type="number" name="'.$node['py'].'" '.$nullMsg.' '.$errMsg.' pattern="[0-9]*"  data-msg="请填写'.$node['label'].'" placeholder="'.$mPl.'" />
                    </div>
                </div>
                <script> var '.$node['py'].'=0 ; </script>
        ';
        return $ele;
    }

    public function _cac($node){
        $this->isHeader=true;
        $require="";
        $nullMsg="";
        $errMsg="";
        if($node['rq']){
            $require=" weiui-require ";
            $nullMsg='nullmsg="计算失败"';
            $errMsg='  datatype="*" ';
        }
        if(intval($node['len'])>0){
            $nullMsg='nullmsg="计算失败"';
            if(strstr($node['len'],"-")){
                $errMsg='  datatype="*'.$node['len'].'" errormsg="'.$node['label'].'长度是'.$node['len'].'字符" ';
            }else{
                $errMsg='  datatype="*'.$node['len'].'-'.$node['len'].'" errormsg="'.$node['label'].'长度是'.$node['len'].'字符" ';
            }
        }
        $mPl=empty($node['pl'])?'请填写'.$node['label']:$node['pl'];
        $ele = '
                <div class="weui-cell them-cell">
                    <div class="weui-cell__hd">
                        <label for="" class="weui-label  them-title"> '.$node["label"].'</label>
                    </div>
                    <div class="weui-cell__bd">
                        <input class="weui-input cac_c'.$require.' "  type="number" id="'.$node['py'].'" name="'.$node['py'].'" data-gs="'.$node['cac'].'"  '.$nullMsg.' '.$errMsg.' readonly  pattern="[0-9]*"  data-msg="请填写'.$node['label'].'" placeholder="0" />
                    </div>
                </div>
        ';
        return $ele;
    }

    public function _local($node){
        $this->isHeader=true;
        $require="";
        $nullMsg="";
        $errMsg="";
        if($node['rq']){
            $require=" weiui-require ";
            $nullMsg='nullmsg="获取字符置失败"';
            $errMsg='  datatype="*" ';
        }
        if(intval($node['len'])>0){
            $nullMsg='nullmsg="获取字符置失败"';
            if(strstr($node['len'],"-")){
                $errMsg='  datatype="*'.$node['len'].'" errormsg="'.$node['label'].'长度是'.$node['len'].'字符" ';
            }else{
                $errMsg='  datatype="*'.$node['len'].'-'.$node['len'].'" errormsg="'.$node['label'].'长度是'.$node['len'].'字符" ';
            }
        }
        $ele='
                <div class="weui-cell them-cell">
                    <div class="weui-cell__hd">
                        <label for="" class="weui-label  them-title"> '.$node["label"].'</label>
                    </div>
                    <div class="weui-cell__bd">
                        <input type="hidden" name="address[name]" value="'.$node['py'].'">
                        <input type="hidden" name="address[lat]" id="lat">
                        <input type="hidden" name="address[lnt]" id="lnt">
                        <input class="weui-input '.$require.' " style="" name="address[value]" id="local_p" value=""  type="text"  '.$nullMsg.' '.$errMsg.' placeholder="获取字符置" />
                    </div>
                    <div class="weui-cell__ft"  style="width:40px;height:30px;">
                        <img class="view_address" src="'.MODULE_URL.'/static/mobile/images/lc.png" style="width:35px;">
                    </div>
                </div>
                <script charset="utf-8" src="https://map.qq.com/api/js?v=2.exp&key=VY3BZ-WRWWQ-WUP5C-GKZ6R-WNOSV-G3BZR"></script>
        ';
        return $ele;
    }

    public function _doadm($node){
        global $_GPC;
        $this->isHeader=true;
        $require="";
        $nullMsg="";
        $errMsg="";
        if($node['rq']){
            $require=" weiui-require ";
            $nullMsg='nullmsg="请选择员工"';
            $errMsg=' datatype="*" ';
        }
        $adminId="";
        $adminName="";
        if(isset($_GPC['admin'])){
            $admin = pdo_get("gd_admin",array("id"=>$_GPC['admin']));
            $adminId =empty($admin)?"":$admin['id'];
            $adminName =empty($admin)?"":$admin['name'];
        }
        $ele='
                <div class="weui-cell them-cell">
                    <div class="weui-cell__hd">
                        <label for="" class="weui-label  them-title"> '.$node["label"].'</label>
                    </div>
                    <div class="weui-cell__bd">
                        <input type="hidden" name="'.$node["py"].'" id="user_val" value="'.$adminId.'">
                        <input class="weui-input '.$require.' " style=""  readonly id="s_user" value="'.$adminName.'"  type="text"  '.$nullMsg.' '.$errMsg.' placeholder="点击右侧选择" />
                    </div>
                    <div class="weui-cell__ft"  style="width:40px;height:30px;">
                        <img class="view_user" data-group="'.$node['pl'].'" src="'.MODULE_URL.'/static/mobile/images/people.png" style="width:35px;">
                    </div>
                </div>
        ';
        return $ele;
    }

    public function _doser($node){
        $this->isHeader=true;
        $ele='
                <div class="weui-cell them-cell" style="display: none">
                    <div class="weui-cell__bd">
                        <input class="weui-input" name="'.$node["py"].'" readonly  value="'.$node['pl'].'"  type="text"  />
                    </div>
                </div>
        ';
        return $ele;
    }

    public function _dogroup($node){
        $this->isHeader=true;
        $require="";
        $nullMsg="";
        $errMsg="";
        if($node['rq']){
            $require=" weiui-require ";
            $nullMsg='nullmsg="请选会员组';
            $errMsg='  datatype="*" ';
        }
        //检查是否有默认值
        $gid="";
        $gname="";
        if(!empty($node['pl'])){
            $id=explode("|",$node['pl']);
            if(!empty($id['1'])){
                $gInfo = pdo_get("mc_groups",array("groupid"=>$id[1]));
                if(!empty($gInfo)){
                    $gid = $gInfo['groupid'];
                    $gname = $gInfo['title'];
                }
            }
        }
        $errMsg='  datatype="*" ';
        $ele='
                <div class="weui-cell them-cell">
                    <div class="weui-cell__hd">
                        <label for="" class="weui-label  them-title"> '.$node["label"].'</label>
                    </div>
                    <div class="weui-cell__bd">
                        <input type="hidden" name="'.$node["py"].'" value="'.$gid.'" id="group_val">
                        <input class="weui-input '.$require.' "  readonly  id="s_group" value="'.$gname.'"  type="text"  '.$nullMsg.' '.$errMsg.' placeholder="选择会员组" />
                    </div>
                    <div class="weui-cell__ft"  style="width:30px;height:30px;">
                        <img class="view_group" src="'.MODULE_URL.'/static/mobile/images/fz.png" style="width:25px;">
                    </div>
                </div>
        ';
        return $ele;
    }

    public function _pp($node){
        $this->isHeader=true;
        $require="";
        $nullMsg="";
        $errMsg="";
        if($node['rq']){
            $require=" weiui-require ";
            $nullMsg='nullmsg="请选分类"';
            $errMsg=' datatype="*"';
        }
        //检查是否有默认值
        $ele='
                <div class="weui-cell them-cell">
                    <div class="weui-cell__hd">
                        <label for="" class="weui-label  them-title"> '.$node["label"].'</label>
                    </div>
                    <div class="weui-cell__bd">
                        <input class="weui-input '.$require.' "  readonly  id="pps" name="'.$node["py"].'" value=""  type="text"  '.$nullMsg.' '.$errMsg.' placeholder="选择分类" />
                    </div>
                    <div class="weui-cell__ft"  style="width:30px;height:30px;">
                        <img class="view_pp" src="'.MODULE_URL.'/static/mobile/images/fz.png" style="width:25px;">
                    </div>
                </div>
        ';
        return $ele;
    }

    public function _pay($node){
        $this->isHeader=false;
        $tp=$tpl =empty($node['pl'])?"支付#元":$node['pl'];
        $tpl =str_replace("#",$this->price,$tpl);
        $ele = '
            <label for="weuiAgree" class="weui-agree" style="padding-left: 5px;">
                <input type="hidden"  name="pay" value="'.$node['py'].'">
                <input id="weuiAgree" type="checkbox" onclick="return false;"  checked class="weui-agree__checkbox">
                <span class="weui-agree__text pay_text">
                    '.$tpl.'
                </span>
            </label>
             <script> tpls="'.$tp.'";</script>
        ';
        return $ele;
    }

    public function _radio($node){
        $this->isHeader=false;
        $valueList=explode(",",$node['pl']);
        $first=1;
        $ele='
            <div class="weui-cells__title  them-title" style="margin-top:0.5rem">
                '.$node["label"].'
            </div>
            <div class="weui-cells weui-cells_radio them-cell">';
        foreach($valueList as $key=>$val){
            $rand = "x".rand(1000,9000);
            $checked="";
            if($key==0){
                $checked='checked="checked"';
            }
            $spr=explode("|",$val);
            $name = count($spr)==2?$spr[0]:$val;
            $ky = count($spr)==2?$spr[1]:1;
            if($key==0){
                $first =$ky;
            }
            $ele .= '
                <label class="weui-cell weui-check__label them-color" for="'.$rand.'">
                    <div class="weui-cell__bd">
                        <p>'.$name.'</p>
                    </div>
                    <div class="weui-cell__ft">
                        <input type="radio" class="weui-check cac_num_radio" data-id="'.$ky.'" value="'.$name.'" name="'.$node['py'].'" id="'.$rand.'" '.$checked.' />
                        <span class="weui-icon-checked"></span>
                    </div>
                </label>
            ';
        }
        $ele .='</div>
        <script> var '.$node['py'].'='.$first.' ; </script>';
        return $ele;
    }

    public function _checkbox($node){
        $this->isHeader=false;
        $valueList=explode(",",$node['pl']);
        $require="";
        $first=0;
        if($node['rq']){
            $require=" weiui-require ";
        }
        $ele ='
            <div class="weui-cells__title  them-title" style="margin-top:0.5rem">
                '.$node["label"].'
            </div>
            <div class="weui-cells weui-cells_checkbox">
            <input type="hidden" name="'.$node['py'].'" class="checkbox_val '.$require.'" data-msg="请选择'.$node['label'].'">
            ';
        foreach($valueList as $key=>$val){
            $rand = "x".rand(1000,9000);
            $checked="";
            if($key==0){
                $checked='checked="checked"';
            }
            $spr=explode("|",$val);
            $name = count($spr)==2?$spr[0]:$val;
            $ky = count($spr)==2?$spr[1]:1;
            if($key==0){
                $first =$ky;
            }
            $ele .= '
                <label class="weui-cell them-cell weui-check__label them-color" for="'.$rand.'">
                    <div class="weui-cell__hd">
                        <input type="checkbox" class="weui-check checkbox_list cac_num_checkbox" data-id="'.$ky.'" data-name="'.$node['py'].'" value="'.$name.'"  id="'.$rand.'" '.$checked.' />
                        <i class="weui-icon-checked"></i>
                    </div>
                    <div class="weui-cell__bd">
                        <p>'.$name.'</p>
                    </div>
                </label>
            ';
        }
        $ele.='</div>
        <script> var '.$node['py'].'='.$first.' ; </script>';
        return $ele;
    }

    public function _label($node){
      $this->isHeader=true;
      if(!$this->isHeader){
            $ele='
            <div class="weui-cells__tips">
                '.htmlspecialchars_decode($node["pl"]).'
            </div>
        ';
            $this->baseF .=$ele;
        }else{
            $ele='
            <div class="weui-cells__tips in_tips">
                '.htmlspecialchars_decode($node["pl"]).'
            </div>
        ';
            return $ele;
        }
    }

    public function _price($node){
        $require="";
        $this->isHeader=true;
        $nullMsg="";
        $errMsg="";
        if($node['rq']){
            $require=" weiui-require ";
            $nullMsg='nullmsg="请填写'.$node['label'].'"';
            $errMsg='  datatype="*" ';
        }
        $mPl=empty($node['pl'])?'请填写'.$node['label']:$node['pl'];
        $ele='
                <div class="weui-cell them-cell price_input" >
                    <div class="weui-cell__hd">
                        <label for="" class="weui-label"> '.$node["label"].'</label>
                    </div>
                    <div class="weui-cell__bd">
                        <input class="weui-input price_nd cac_num'.$require.' "  name="'.$node['py'].'" value="'.$node['pl'].'" '.$nullMsg.' '.$errMsg.' type="text" data-msg="请填写'.$node['label'].'" placeholder="'.$mPl.'" />
                    </div>
                </div>
                <script> price="'.$node['pl'].'";</script>
        ';
        return $ele;
    }

    public function _sign($node){
        $require="";
        $this->isHeader=true;
        if($node['rq']){
            $require=" weiui-require ";
        }
        $ele = '
            <label for="weuiAgree" class="weui-agree">
                <input type="hidden" name="sign[name]" value="'.$node['py'].'">
                <input type="hidden" name="sign[value]" id="sign_addr" class="'.$require.'">
                <input type="hidden" name="sign[lat]" id="sign_lat">
                <input type="hidden" name="sign[lnt]" id="sign_lnt">
                <input id="weuiAgree" type="checkbox" onclick="return false;"  checked class="weui-agree__checkbox sign">
                <span class="weui-agree__text">'.$node['label'].'</span>
            </label>
        ';
        return $ele;
    }

    public function _photo($node){
        $require="";
        $nullMsg="";
        $errMsg="";
        $node['pl'] = empty($node['pl'])?4:$node['pl'];
        if($node['rq']){
            $require=" weiui-require ";
            $nullMsg='nullmsg="请选择'.$node['label'].'"';
            $errMsg='  datatype="*" ';
        }
        $ico1 =MODULE_URL.'/static/mobile/images/add.png';
        $ele = '
        <div class="weui-cells weui-cells_form them-cell" style="margin-top:0.5rem;">
            <div class="weui-cell them-cell">
                <div class="weui-cell__bd">
                    <div class="weui-uploader">
                        <div class="weui-uploader__hd">
                            <p class="weui-uploader__title  them-title">'.$node['label'].'</p>
                            <div class="weui-uploader__info"><span class="have_'.$node['py'].'">0</span>/'.$node['pl'].'</div>
                        </div>
                        <div class="weui-uploader__bd">
                            <ul class="weui-uploader__files img_'.$node['py'].'">
                            </ul>
                            <div class="weui-uploader__input-box" data-local="" data-total="'.$node['pl'].'" data-select="'.$node['py'].'">
                                 <input id="uploaderInput" class="weui-uploader__input '.$require. $node['py'].'" name="'.$node['py'].'" type="hidden" value="" '.$nullMsg. 'data-msg="请拍照上传'.$node['label'].'" '.$errMsg.' placeholder="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
        return $ele;
    }

    public function _voice($node){
        $require="";
        $nullMsg="";
        $errMsg="";
        if($node['rq']){
            $require=" weiui-require ";
            $nullMsg='nullmsg="请录音"';
            $errMsg='  datatype="*" ';
        }
        if(intval($node['len'])>0){
            if(strstr($node['len'],"-")){
                $errMsg='  datatype="*'.$node['len'].'" errormsg="'.$node['label'].'长度是'.$node['len'].'字符" ';
            }else{
                $errMsg='  datatype="*'.$node['len'].'-'.$node['len'].'" errormsg="'.$node['label'].'长度是'.$node['len'].'字符" ';
            }
        }else{
            $errMsg='  datatype="*" ';
        }
        $ico =MODULE_URL.'/static/mobile/images/voice.png';
        $ele = '
        <div class="weui-cells them-cell weui-cells_form" style="margin-top:0.5rem;">
            <div class="weui-cell them-cell">
                <div class="weui-cell__bd">
                    <div class="weui-uploader">
                        <div class="weui-uploader__hd">
                            <p class="weui-uploader__title  them-title">'.$node['label'].'</p>
                        </div>
                        <div class="weui-uploader__bd">
                            <ul class="weui-uploader__files" id="uploaderFiles">
                            </ul>
                            <a class="weui-uploader__file voice_btn " data-select="'.$node['py'].'" style="background-image:url('.$ico.');border:1px solid #D9D9D9;color:"></a>
                            <input id="uploaderInput" data-local="" class="weui-uploader__input ' . $require .  $node['py'].'" name="'.$node['py'].'" '.$nullMsg.' type="hidden" value="" data-msg="请录音'.$node['label'].'"  placeholder="">
                        </div>
                    </div>
                </div>
            </div>
        </div>';
        return $ele;
    }

    public function _select($node){
        $this->isHeader=true;
        $first=1;
        $valueList=explode(",",$node['pl']);
        $ele ='
            <div class="weui-cell weui-cell_select them-cell" style="padding-left: 15px;color:#999999 !important;">
                 <div class="weui-cell__hd">
                        <label for="" class="weui-label  them-title"> '.$node["label"].'</label>
                 </div>
                <div class="weui-cell__bd">
                    <select class="weui-select cac_num _select" name="'.$node['py'].'" style="padding-left:0;color:#999999 !important;">';
                foreach($valueList as $key=> $val){
                    $spr=explode("|",$val);
                    $name = count($spr)==2?$spr[0]:$val;
                    $ky = count($spr)==2?$spr[1]:1;
                    if($key==0){
                        $first =$ky;
                    }
                    $ele .=' <option data-id="'.$ky.'" value="'.$name.'">'.$name.'</option>';
                }
                $ele .='</select>
                </div>
            </div>
            <script> var '.$node['py'].'='.$first.' ; </script>
        ';
       return $ele;
    }

    public function _ld($node){
        $this->isHeader=true;
        $valueList=explode("#",$node['pl']);
        if(empty($valueList[1])){
            return "";
        }
        //获取联动菜单名字
        $first=pdo_get("gd_ld",array("id"=>$valueList['1']));
        if(empty($first)){
            return "";
        }
        //获取下一
        $nextList=pdo_getall("gd_ld",array("parent_id"=>$first['id']));
        $ele ='
            <div class="weui-cell weui-cell_select ld_select them-cell" style="padding-left: 15px;">
                 <div class="weui-cell__hd">
                        <label for="" class="weui-label select_ld_lb  them-title"> '.$node["label"].'</label>
                 </div>
                <div class="weui-cell__bd">
                    <input type="hidden" name="'.$node['py'].'" class="select_result">
                    <select class="weui-select select_ld select_cm level_0 them-cell" style="padding-left:0">';
                    $ele .=' <option  value="0">请选择</option>';
                    foreach($nextList as $val){
                        $ele .=' <option  value="'.$val['id'].'">'.$val['name'].'</option>';
                    }
                    $ele .='</select>
                </div>
            </div>
        ';
        return $ele;
    }

    public function _textarea($node){
        $maxLen = 1000;
        if(!empty($node['len'])){
            $linfo = explode("-",$node['len']);
            if(count($linfo)==2){
                $maxLen = $linfo[1];
            }
        }
        $this->isHeader=true;
        $require="";
        $nullMsg="";
        $errMsg="";
        if($node['rq']){
            $require=" weiui-require ";
            $nullMsg='nullmsg="请填写'.$node['label'].'"';
            $errMsg='  datatype="*" ';
        }
        if(intval($node['len'])>0){
            $nullMsg='nullmsg="请填写'.$node['label'].'"';
            if(strstr($node['len'],"-")){
                $errMsg='  datatype="*'.$node['len'].'" errormsg="'.$node['label'].'长度是'.$node['len'].'字符" ';
            }else{
                $errMsg='  datatype="*'.$node['len'].'-'.$node['len'].'" errormsg="'.$node['label'].'长度是'.$node['len'].'字符" ';
            }
        }
        $ret=trim($node['pl']);
        $mPl=empty($node['pl'])?'请填写'.$node['label']:$node['pl'];
        $ele='
            <div class="weui-cells__title  them-title" style="margin-top:0.5rem">
                '.$node["label"].'
            </div>
            <div class="weui-cells weui-cells_form them-cell">
                <div class="weui-cell them-cell">
                    <div class="weui-cell__bd">
                        <textarea class="weui-textarea'.$require.'" placeholder="'.$mPl.'" data-msg="请填写'.$node["label"].'" '.$nullMsg.' '.$errMsg.' name="'.$node['py'].'" rows="3"></textarea>
                        <div class="weui-textarea-counter">
                            <span class="area_num">0</span>/'.$maxLen.
                        '</div>
                    </div>
                </div>
            </div>
        ';
        return $ele;
    }

    public function _sg($node){
        $ele='
            <div class="weui-cells__title  them-title" style="margin-top:0.5rem">
                '.$node["label"].'
            </div>
            <div class="weui-cells weui-cells_form them-cell">
                <div class="weui-cell them-cell">
                    <div class="weui-cell__bd">
                        <input type="hidden" name="'.$node['py'].'" id="'.$node['py'].'">
                        <div class="js-signature" data-class="'.$node['py'].'" data-height="150" data-border="1px solid #f08500" data-line-color="#bc0000" data-auto-fit="true"></div>
                        <img src="'.MODULE_URL.'static/weui/images/qc.png" style="width:20px;position: absolute;top:130px;right:25px;" id="s_cl">
                    </div>
                </div>
            </div>
            <script src="'.MODULE_URL.'static/weui/js/jq-signature.js"></script>
        ';
        return $ele;
    }

    public function _lastdate($node){
        return '<input type="hidden" name="'.$node['py'].'" >';
    }

    public function _char($node){
        $maxLen = 1000;
        if(!empty($node['len'])){
            $linfo = explode("-",$node['len']);
            if(count($linfo)==2){
                $maxLen = $linfo[1];
            }
        }
        $this->isHeader=true;
        $require="";
        $nullMsg="";
        $errMsg="";
        if($node['rq']){
            $require=" weiui-require ";
            $nullMsg='nullmsg="请填写'.$node['label'].'"';
            $errMsg='  datatype="*" ';
        }
        if(intval($node['len'])>0){
            $nullMsg='nullmsg="请填写'.$node['label'].'"';
            if(strstr($node['len'],"-")){
                $errMsg='  datatype="*'.$node['len'].'" errormsg="'.$node['label'].'长度是'.$node['len'].'字符" ';
            }else{
                $errMsg='  datatype="*'.$node['len'].'-'.$node['len'].'" errormsg="'.$node['label'].'长度是'.$node['len'].'字符" ';
            }
        }
        $ret=trim($node['pl']);
        //转化几个和默认值
        $df="";
        $price=0;
        $fh=0;
        if(!empty($ret)){
            $linfo = explode("|",$ret);
            if(count($linfo)==2 || count($linfo)==3){
                $df=$linfo[0];
                $price = $linfo[1];
            }
            if(count($linfo)==3){
                $fh=1;
            }
        }
        $mPl=empty($df)?'请填写'.$node['label']:$df;
        $ele='
            <div class="weui-cells__title  them-title" style="margin-top:0.5rem">
                '.$node["label"].'<span data-money="0" class="'.$node['py'].'"></span>
            </div>
            <div class="weui-cells weui-cells_form them-cell">
                <div class="weui-cell them-cell">
                    <div class="weui-cell__bd">
                        <input data-money="0" data-price="'.$price.'" data-fh="'.$fh.'" class="weui-textarea char_pay'.$require.'" placeholder="'.$mPl.'" data-msg="请填写'.$node["label"].'" '.$nullMsg.' '.$errMsg.' name="'.$node['py'].'" rows="3"></input>
                        <div class="weui-textarea-counter">
                            <span class="area_num">0</span>/'.$maxLen.
                        '</div>
                    </div>
                </div>
            </div>
        ';
        return $ele;
    }

    public function _show($node){
        $this->isHeader=true;
        $div = explode("|",$node['pl']);
        $msg = $div[0];
        $money=0;
        if(count($div)==2){
            $money = $div[1];
        }
        $txt = str_replace("#","<span id='show_m' data-money='".$money."'>".$money."</span>",$msg);
        $ele='
                <div class="weui-cell them-cell" style="margin-top:5px;">
                    <div class="weui-cell__hd">
                        <label for="" class="weui-label  them-title"> '.$node["label"].'</label>
                    </div>
                    <div class="weui-cell__bd">
                       <input type="hidden" name="'.$node["py"].'" id="sum_m" data-tp="'.$msg.'">
                     '.$txt.'
                    </div>
                </div>
        ';
        return $ele;
    }

    public function __createAForm($appId){
        $appPay=pdo_get("gd_app",array("id"=>$appId));
        $property=isset($appPay['property'])?json_decode($appPay['property'],true):array();
        $appInfo = pdo_get("gd_source_form",array("app_id"=>$appId));
        $page="";
        $page .=$this->_hidden("app_id",$appId);
        $form = empty($appId)?array():json_decode($appInfo['source'],true);
        foreach($form as $val){
            $func="__".$val['type'];
            $page .= $this->$func($val);
        }
        $html = $this->fHeader.$page.$this->baseH.$this->photo.$this->voice.$this->med.$this->baseF;
        return $html;
    }

    //创建电脑端表单
    public function __createFrom($flowId,$nodeId,$recorderId,$appId,$lineId,$nodeInfo=false,$payMoney=0){
        if(!$nodeInfo){
            $nodeInfo = pdo_get("gd_node",array("flow_id"=>$flowId,'id'=>$nodeId));
        }
        $this->price=$payMoney;
        $page="";
        $page .=$this->__hidden("app_id",$appId);
        $page .=$this->__hidden("recorder_id",$recorderId);
        $page .=$this->__hidden("line_id",$lineId);
        $page .=$this->__hidden("flow_id",$nodeInfo['flow_id']);
        $page .=$this->__hidden("node_id",$nodeInfo['id']);
        $page .=$this->__hidden("_fm","mark");

        $form = json_decode($nodeInfo['form_list'],true);
        $lineInfo = pdo_get("gd_preline",array("line_id"=>$lineId,'flow_id'=>$flowId));
        if(!empty($lineInfo) && !empty($lineInfo['form_list'])){
            $form = json_decode($lineInfo['form_list'],true);
        }
        foreach($form as $val){
            $func="__".$val['type'];
            $page .= $this->$func($val);
        }
        $html = $this->fHeader.$page.$this->baseH.$this->photo.$this->voice.$this->baseF;
        $html .=$this->footer;
        return $html;
    }

    public function __hidden($name,$val){
        return "<input type='hidden' name='{$name}' value='{$val}'>";
    }

    public function __point($node){
        $this->fHeader .= "<input type='hidden' name='".$node['py']."' value='".$node['pl']."' ><input type='hidden' name='points' value='".$node['pl']."' >";
    }

    public function __input($node){
        $this->isHeader=true;
        $require="";
        if($node['rq']){
            $require=" require ";
        }
        $ele='
            <div class="layui-form-item">
                <label class="layui-form-label">'.$node["label"].'</label>
                <div class="layui-input-block">
                    <input type="text" name="'.$node['py'].'"  style="width: 400px;" lay-verify="'.$require.'" placeholder="请填写'.$node['label'].'" autocomplete="off" class="layui-input">
                </div>
            </div>
        ';
        $this->fHeader .=$ele;
    }

    public function __number($node){
        $this->isHeader=true;
        $require="";
        if($node['rq']){
            $require=" require ";
        }
        $ele='
            <div class="layui-form-item">
                <label class="layui-form-label">'.$node["label"].'</label>
                <div class="layui-input-block">
                    <input type="number" name="'.$node['py'].'"  style="width: 400px;" lay-verify="'.$require.'" placeholder="请填写'.$node['label'].'" autocomplete="off" class="layui-input">
                </div>
            </div>
        ';
        $this->fHeader .=$ele;
    }

    public function __cac($node){
        $this->isHeader=true;
        $require="";
        if($node['rq']){
            $require=" require ";
        }
        $ele='
            <div class="layui-form-item">
                <label class="layui-form-label">'.$node["label"].'</label>
                <div class="layui-input-block">
                    <input type="text" name="'.$node['py'].'"  style="width: 400px;" lay-verify="'.$require.'" placeholder="请填写'.$node['label'].'" autocomplete="off" class="layui-input">
                </div>
            </div>
        ';
        $this->fHeader .=$ele;
    }

    public function __mobile($node){
        $this->isHeader=true;
        $require="";
        if($node['rq']){
            $require=" require ";
        }
        $ele = '
            <div class="layui-form-item">
                <label class="layui-form-label">'.$node["label"].'</label>
                <div class="layui-input-block">
                    <input type="number" name="'.$node['py'].'"  style="width: 400px;" lay-verify="'.$require.'" placeholder="请填写'.$node['label'].'" autocomplete="off" class="layui-input">
                </div>
            </div>
        ';
        $this->fHeader .=$ele;
    }

    public function __city($node){
        $this->isHeader=true;
        $require="";
        if($node['rq']){
            $require=" require ";
        }
        $ele='
            <div class="layui-form-item">
                <label class="layui-form-label">'.$node["label"].'</label>
                <div class="layui-input-block">
                    <input type="text" name="'.$node['py'].'"  style="width: 400px;" lay-verify="'.$require.'" placeholder="省,市,区/县" autocomplete="off" class="layui-input">
                </div>
            </div>
        ';
        $this->fHeader .=$ele;
    }

    public function __checkbox($node){
    }

    public function __date($node){
        $date=date("Y-m-d",time());
        $this->isHeader=true;
        $require="";
        if($node['rq']){
            $require=" require ";
        }
        $ele = '
            <div class="layui-form-item">
                <label class="layui-form-label">'.$node["label"].'</label>
                <div class="layui-input-block">
                    <input class="layui-input start"  style="width:400px;" name="'.$node['py'].'" value="'.$date.'" placeholder="请选择'.$node['label'].'" id="LAY_demorange_s">
                </div>
            </div>
        ';
        $this->fHeader .=$ele;
    }

    public function __time($node){
        $date=date("Y-m-d",time());
        $this->isHeader=true;
        $require="";
        if($node['rq']){
            $require=" require ";
        }
        $ele = '
            <div class="layui-form-item">
                <label class="layui-form-label">'.$node["label"].'</label>
                <div class="layui-input-block">
                 <input class="layui-input start" type="text" style="width:400px;" name="'.$node['py'].'" value="'.$date.'" placeholder="请选择'.$node['label'].'" id="LAY_demorange_t">
                </div>
            </div>
        ';
        $this->fHeader .=$ele;
    }

    public function __hb($node){

    }

    public function __local($node){
        $this->isHeader=true;
        $require="";
        if($node['rq']){
            $require=" require ";
        }
        $ele='
             <div class="layui-form-item">
                <input type="hidden" name="address[name]" value="'.$node['py'].'">
                <input type="hidden" name="address[lat]" id="lat">
                <input type="hidden" name="address[lnt]" id="lnt">
                <label class="layui-form-label">'.$node["label"].'</label>
                <div class="layui-input-block">
                    <input type="text" name="address[value]"   id="local_p"  style="width: 400px;float:left" lay-verify="'.$require.'" placeholder="请选择'.$node["label"].'" autocomplete="off" class="layui-input">
                </div>
            </div>
        ';
        $this->fHeader .=$ele;
    }

    public function __radio($node){
        $this->isHeader=false;
        $valueList=explode(",",$node['pl']);
        $opt="";
        foreach($valueList as $key=>$val){
            $opt .=' <input type="radio" name="'.$node['py'].'" value="'.$key.'" title="'.$val.'">';
        }
        $ele = '
            <div class="layui-form-item">
            <label class="layui-form-label"> '.$node["label"].'</label>
            <div class="layui-input-block">
              '.$opt.'
            </div>
          </div>
        ';
        return $ele;
    }

    public function _radio_zh($node){
        $this->isHeader=false;
        $valueList=explode(",",$node['pl']);
        $opt="";
        if($node['rq']){
            $require=" weiui-require ";
            $nullMsg=' nullmsg="请填写'.$node['label'].'"';
            $errMsg='  datatype="*" ';
        }
        $df=array_pop($valueList);
        foreach($valueList as $key=>$val){
            $opt .=' <option  value="'.$val.'">'.$val.'</option>';
        }
        $ele = '
            <div class="weui-cell weui-cell_select weui-cell_select-before them-cell">
                <div class="weui-cell__hd">
                    <select class="weui-select pre_val">'.$opt.'</select>
                </div>
                <div class="weui-cell__bd">
                    <input type="hidden" name="'.$node['py'].'" class="boxs">
                    <input class="weui-input box_val"   type="text"'.$nullMsg.' '.$errMsg.' placeholder="'.$df.'">
                </div>
            </div>
        ';
        return $ele;
    }

    public function __price($node){
        $require="";
        if($node['rq']){
            $require="require ";
        }
        $ele='
                <div class="layui-form-item">
                    <label class="layui-form-label">'.$node["label"].'</label>
                    <div class="layui-input-block">
                        <input type="text" name="'.$node['py'].'"  value="'.$node['pl'].'"  style="width: 400px;" lay-verify="'.$require.'" placeholder="请填写'.$node["label"].'" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <script> price="'.$node['pl'].'";</script>
        ';
        $this->fHeader .=$ele;
    }

    public function __sign($node){
    }
    public function __photo($node){
        $this->isHeader=true;
        $require="";
        if($node['rq']){
            $require=" require ";
        }
        $ele='
            <div class="layui-form-item">
            <label class="layui-form-label">'.$node["label"].'</label>
            <div class="layui-input-block" id="imgList">
                <input type="hidden" id="cov" class="covs" name="'.$node['py'].'">
                <input type="file" name="file" class="layui-upload-file">
                <span class="img_box">          
                </span>
                <a href="javascript:" class="rem layui-btn layui-btn-danger layui-btn-mini" style="margin-left:15px;width: 30px;">删除</a>
            </div>
            </div>
        ';
        $this->fHeader .=$ele;
    }

    public function __file($node){
        $this->isHeader=true;
        $require="";
        if($node['rq']){
            $require=" require ";
        }
        $ele='
            <div class="layui-form-item">
            <label class="layui-form-label">'.$node["label"].'</label>
            <div class="layui-input-block" id="imgList">
                <input type="hidden"  class="b" id="'.$node['py'].'_b" name="'.$node['py'].'_b">
                <input type="hidden"  class="fj" id="'.$node['py'].'_l" name="'.$node['py'].'">
                <input type="hidden"  class="lb" id="'.$node['py'].'_n"  name="'.$node['py'].'_lb">
                <input type="file" name="file" id="'.$node['py'].'" class="layui-file">
                <span class="file_box">          
                </span>
            </div>
            <p style="margin-left: 110px;margin-top:10px;">
                <span  class="layui-btn layui-btn-mini s_lb" id="'.$node['py'].'_a">标签&nbsp;&nbsp;</span>
                 <span class="l_box">   
                 </span>
            </p>
            </div>
        ';
        $this->fHeader .=$ele;
    }

    public function __voice($node){
    }

    public function __pay($node){
    }


    public function __select($node){
        $this->isHeader=true;
        $valueList=explode(",",$node['pl']);
        $opt="";
        foreach($valueList as $key=> $val){
            $opt .=' <option  value="'.$val.'">'.$val.'</option>';
        }
        $ele ='
            <div class="layui-form-item">
            <label class="layui-form-label">'.$node["label"].'</label>
            <div class="layui-input-block" style="width:400px;">
              <select name="'.$node['py'].'" lay-verify="required" style="width:300px">
                <option value=""></option>'
                    .$opt.
              '</select>
            </div>
            </div>
        ';
        $this->fHeader .=$ele;
    }

    public function __ld($node){
        $this->isHeader=true;
        if(empty($this->fHeader)){
            $this->fHeader='<div class="weui-cells weui-cells_form">';
        }
        $valueList=explode("#",$node['pl']);
        if(empty($valueList[1])){
            return "";
        }
        //获取联动菜单名字
        $first=pdo_get("gd_ld",array("id"=>$valueList['1']));
        if(empty($first)){
            return "";
        }
        $ele ='
            <div class="layui-form-item">
                <label class="layui-form-label">'.$node['label'].'</label>
                <div class="layui-input-block">
                    <input type="text" id="ld_'.$first['id'].'" name="app_name" required="" style="width: 295px;float: left;margin-right:5px;" placeholder="请选择" autocomplete="off" class="layui-input">
                    <button class="layui-btn  select_ld" data-id="'.$first['id'].'" style="width:100px;float: left">选择</button>
                </div>
            </div>
        ';
        $this->fHeader .=$ele;
    }

    public function __textarea($node){
        $this->isHeader=false;
        $require="";
        if($node['rq']){
            $require=" require ";
        }
        $ele='
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">'.$node["label"].'</label>
                <div class="layui-input-block">
                  <textarea style="width: 400px;" name="'.$node['py'].'" placeholder="请填写'.$node["label"].'" class="layui-textarea"></textarea>
                </div>
            </div>
        ';
        return $ele;
    }

    //表单调用系统内置
    public function funcVal($node){
        global $_W;
        if(!empty($node['func'])){
            if($node['func']=="_name"){
                return isset($this->memberInfo['name'])?$this->memberInfo['name']:"";
            }else if($node['func']=="_mobile"){
                return isset($this->memberInfo['mobile'])?$this->memberInfo['mobile']:"";
            }else if($node['func']=="_staff_name"){
                return isset($this->adminInfo['name'])?$this->adminInfo['name']:"";
            }else if($node['func']=="_staff_mobile"){
                return isset($this->adminInfo['mobile'])?$this->adminInfo['mobile']:"";
            }else{
                //获取扩展列数据
                $extInfo=array();
                $memberInfo = pdo_get("gd_member",array("uid"=>$_W['member']['uid']));
                if(!empty($memberInfo)){
                    $list = pdo_getall("gd_member_ext",array("id >"=>0));
                    foreach($list as $info){
                        $table=$info['table'];
                        $ext = pdo_get($table,array("member_id"=>$memberInfo['id']));
                        if(!empty($extInfo)){
                            $extInfo = array_merge($extInfo,$ext);
                        }else{
                            $extInfo = $ext;
                        }
                    }
                    return isset($extInfo[$node['func']])?$extInfo[$node['func']]:"";
                }
            }
        }
        return "";
    }
}