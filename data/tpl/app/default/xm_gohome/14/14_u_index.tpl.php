<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>

<style type="text/css">
.new_menu{width:100%; overflow:hidden; height:5.9rem}
.new_menu .left_menu{width:33.3%; height:6rem; padding:1rem 0; line-height:2rem;}
.new_menu .left_menu img{width:2rem; height:2rem;}
.new_menu .right_menu{width:66.6%;}
.new_menu .right_menu ul li{width:49.98%; height:3rem; line-height:3rem;}
.menu_blu{background-color:#00A7F6;}
.menu_red{background-color:#FF5555;}
.menu_blu2{background-color:#32BAAE;}
.menu_org{background-color:#FF7F00;}
.menu_green{background-color:#00D900;}
</style>
<body>
<div class="ub ub-ver page bga" id="page0">
  <!--头部 star-->
  <header class="fixed ub-fh header" style="top:0; left:0; z-index:999">
    <?php  if($this->getBase('search') == 1) { ?>
    <div class="ub ub-ac ub-pc">
      <a href="<?php  echo $this->createMobileUrl('index',array('foo'=>'city'))?>">
        <div class="ub t-wh uinn">
          <span id="city"></span>
          <i class="iconfont icon-xiala"></i>
        </div>
      </a>
      <div class="ub-f1 umar-a c-wh80 uinn3 uc-a1">
        <a href="<?php  echo $this->createMobileUrl('search',array('foo'=>'index'))?>">
          <i class="icon-sousuo iconfont"></i>
          <span class="t-gra ulev-4">输入分类、商家或区域</span>
        </a>
      </div>
      <div class="ub uinn t-wh" onClick="getScan()">
        <i class="icon-erweima1 iconfont ulev1"></i>
      </div>
    </div>
    <?php  } else { ?>
    <div class="ub-f1 tx-c uinn t-wh">
      <a href="<?php  echo $this->createMobileUrl('index',array('foo'=>'city'))?>">
        <div class="absolute t-wh uinn" style="left:0; top:0; z-index:9999">
          <span id="city"></span>
          <i class="iconfont icon-xiala"></i>
        </div>
      </a>
      <?php  echo $this->title?>
      <div onClick="getAdr()" class="absolute t-wh uinn" style="right:0; top:0; z-index:9999">
        <i class="icon-dingwei iconfont"></i>
      </div>
    </div>
    <?php  } ?>
  </header>
  <!--头部 end-->

  <div style="height:2.4rem;"></div>

  <!--banner star-->
  <div class="banner" style="">
    <div class="swiper-container">
      <div class="swiper-wrapper">
      <?php  if(is_array($adv)) { foreach($adv as $val) { ?>
        <div class="swiper-slide">
          <a href="<?php  echo $val['link'];?>">
            <img src="<?php  echo $_W['attachurl'];?><?php  echo $val['pic'];?>" width="1004" height="516" class="imgbox">
          </a>
        </div>
      <?php  } } ?>
      </div>
      <div class="swiper-pagination"></div>
    </div>
  </div>
  <!--banner end-->

  <!--内部循环导航 star-->
  <?php  if(is_array($list)) { foreach($list as $key => $vo) { ?>
  <div class="new_menu umar-b tx-c <?php  if($key==0) { ?>menu_blu<?php  } ?><?php  if($key==1) { ?>menu_red<?php  } ?><?php  if($key==2) { ?>menu_blu2<?php  } ?><?php  if($key==3) { ?>menu_org<?php  } ?><?php  if($key==4) { ?>menu_green<?php  } ?><?php  if($key==5) { ?>menu_blu<?php  } ?><?php  if($key==6) { ?>menu_red<?php  } ?><?php  if($key==7) { ?>menu_blu2<?php  } ?><?php  if($key==8) { ?>menu_org<?php  } ?><?php  if($key==9) { ?>menu_green<?php  } ?><?php  if($key>9) { ?>menu_blu<?php  } ?>">
    <div class="left_menu ufl ubr ubb b-wh">
      <?php  if($vo['child_num'] == 0) { ?>
        <a href="<?php  echo $this->createMobileUrl('templateok',array('foo'=>'index','id'=>$vo['id']))?>" class="t-wh">
      <?php  } else { ?>
        <a href="<?php  echo $this->createMobileUrl('index',array('foo'=>'child','parent_id'=>$vo['id']))?>" class="t-wh">
      <?php  } ?>
        <img src="<?php  echo $_W['attachurl'];?><?php  echo $vo['icon'];?>" width="90" height="90"> 
        <p><?php  echo $vo['type_name'];?></p>
      </a>
    </div>
    <div class="right_menu ufl">
      <ul>
        <?php  $arr = pdo_fetchall("SELECT id,type_name FROM ".tablename('xm_gohome_servetype')." WHERE weid=".$_W['uniacid']." AND parent_id=".$vo['id']." AND delstate=1 LIMIT 0,4");?>
        <?php  if(is_array($arr)) { foreach($arr as $val) { ?>
        <li class="ubr ubb b-wh ufl"><a href="<?php  echo $this->createMobileUrl('templateok',array('foo'=>'index','id'=>$val['id']))?>" class="t-wh"><?php  echo $val['type_name'];?></a></li>
        <?php  } } ?>
        <div class="clear"></div>
      </ul>
    </div>
    <div class="clear"></div>
  </div>
  <?php  } } ?>
  <!--内部循环导航 end-->

  <div style="height:3.5rem;"></div>
  <!--浮动底部-->
  <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>  
  <!--浮动底部-->
</div>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('public/footerjs', TEMPLATE_INCLUDEPATH)) : (include template('public/footerjs', TEMPLATE_INCLUDEPATH));?>

<script type="text/javascript">
var qu, qu_s, qu_f, code, lat, lng = null;
var num = 0;
wx.ready(function () {
  num += 1;
  qu_s = localStorage['qu_s'];
  qu_f = localStorage['qu_f'];
  qu   = localStorage['qu'];
  if(qu_s){
    $("#city").html(qu_s);
  }else{
    if(qu){
      $("#city").html(qu);
    }else{
      $("#city").html('定位中');
    }
  }
  getAdr();
});

function getAdr(){
  if(num == 1){
    wx.getLocation({
      type: 'gcj02',
      success: function (res) {
        lat = res.latitude;
        lng = res.longitude;
        var mapkey = "<?php  echo $this->getBase('qq_ak')?>";
        if(mapkey == ''){
          alert('获取地址失败，腾讯地图密钥未设置！');
          return false;
        }
        var app = 'gohome';
        var key = "<?php  echo $this->getBase('key_info')?>";
        $.ajax({
          url:"http://cloud.n3.cn/gohome/address.php",
          type:"POST",
          data:{"app":app,"key":key,"lat":lat,"lng":lng,"mapkey":mapkey},
          dataType:"jsonp",
          jsonp:"jsoncallback",
          success:function(res){
            code = res.adcode;
            qu   = res.qu;
            if(qu_s){
              if(qu_s != qu){
                if(qu_f){
                  $("#city").html(qu_s);
                  localStorage['qu']  = qu_s;
                  lat = localStorage['lat2'];
                  lng = localStorage['lng2'];
                }else{
                  if(window.confirm('当前定位位置为'+qu+',是否切换位置？')){
                    $("#city").html(qu);
                    localStorage['qu'] = qu;
                    localStorage['qu_s'] = qu;
                    localStorage['qu_f'] = '';
                    $.ajax({
                      url:"<?php  echo $this->createMobileUrl('index', array('foo'=>'adrstr'))?>",
                      type:"POST",
                      data:{"lat":lat,"lng":lng,"code":code,"qu":qu},
                      dataType:"json",
                      success:function(res){
                        if(res){
                          window.location.reload();
                        }else{
                          alert('地区切换失败！');
                        }
                      }
                    });
                  }else{
                    $("#city").html(qu_s);
                    localStorage['qu']  = qu_s;
                    lat = localStorage['lat2'];
                    lng = localStorage['lng2'];
                  }
                }
              }else{
                $("#city").html(qu_s);
              }
            }else{
              $.ajax({
                url:"<?php  echo $this->createMobileUrl('index', array('foo'=>'adrstr'))?>",
                type:"POST",
                data:{"lat":lat,"lng":lng,"code":code,"qu":qu},
                dataType:"json",
                success:function(res){}
              });
            }
            localStorage['adr'] = res.readdress;
            localStorage['qu_f'] = '';
            localStorage['lat'] = lat;
            localStorage['lng'] = lng;
          },
          error:function(){
            alert('错误提示:获取地址失败！');
            return false;
          }
        });
      } 
    });
  }
}

//扫码
function getScan(){
  wx.scanQRCode({
      needResult: 1,
      scanType: ["qrCode","barCode"],
      success: function (res) {
      var str = res.resultStr;
      strs = str.split(",");
      var url = $("#url").val()+'barcode_number='+strs[1]+'&m=xm_allroundo2o';
      window.location.href = url;
    }
  });
}
</script>
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=xm_gohome"></script></body>
</html>
