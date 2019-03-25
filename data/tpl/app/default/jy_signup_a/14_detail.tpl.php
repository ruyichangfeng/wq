<?php defined('IN_IA') or exit('Access Denied');?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php  echo $hd['hdname'];?></title>
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0"/>
<meta name="format-detection" content="telephone=no">
<link rel="stylesheet" href="../addons/jy_signup_a/css/swiper.min.css">
<link rel="stylesheet" type="text/css" href="../addons/jy_signup_a/css/header.css">
<link rel="stylesheet" type="text/css" href="../addons/jy_signup_a/css/second.css">
<link rel="stylesheet" type="text/css" href="../addons/jy_signup_a/css/notice.css">
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template(style, TEMPLATE_INCLUDEPATH)) : (include template(style, TEMPLATE_INCLUDEPATH));?>
<style>
	.M_detail-con img{width: 100%}
  .addressXX{color: #000;line-height: 22px}
</style>
<body>
	<header>
	    <a href="javascript:history.go(-1);"><div class="navbar-btn floL"><img class="icon-back" src="../addons/jy_signup_a/images/header-back.png"></div></a>
	    <a href="<?php  echo $this->createMobileUrl('geren')?>"><div class="navbar-btn floR"><img class="icon-back" src="../addons/jy_signup_a/images/header-person.png"></div></a>
	    <h1 class="latecolorbg"><?php  if(!empty($sitem['aname'])) { ?><?php  echo $sitem['aname'];?><?php  } else { ?>报名活动<?php  } ?></h1>
	</header>
	<div class="swiper-container">
		<div class="swiper-wrapper">
      <?php  if(is_array($thumb)) { foreach($thumb as $row) { ?>
			<div class="swiper-slide"><img src="<?php  echo $_W['attachurl'];?><?php  echo $row;?>"></div>
      <?php  } } ?>
		</div>

	</div>

   <div class="bodybox"><div class="basic-box">
       <h3 style="margin-top: 5px;margin-bottom: 8px"><?php  echo $hd['hdname'];?></h3>
		<div class="buy-box">
			<div class="price"><span class="rmb-num"><?php  if($hd['price']>0) { ?><?php  echo $hd['price'];?> 元<?php  } else { ?><?php  if($hd['jifen']>0) { ?><?php  echo $hd['jifen'];?> 积分<?php  } else { ?>免费报名<?php  } ?><?php  } ?></span></div>
			<div class="num" style="margin-left:10px;">名额 <span class="rmb-num"><?php  if(empty($hd['renshu'])) { ?>不限<?php  } else { ?><?php  echo $hd['renshu'];?><?php  } ?></span></div>
			<div class="btn">
      <?php  $now=time();?>

      <?php  if($hd['enabled']==1) { ?>
        <?php  if($hd['deadline']<time()) { ?>
        <a href="javascript:void(0)" class="buy-btn1">活动结束</a>
        <?php  } else { ?>
        <?php  if(!empty($xz) && $xz['status']!=1) { ?>
          <a href="javascript:void(0)" class="buy-btn1">已核销</a>
        <?php  } else { ?>
          <?php  if($cj==1) { ?>
          <a href="<?php  echo $this->createMobileUrl('signup',array('id'=>$id))?>" class="buy-btn"><?php  echo $hd['xiugai'];?></a>
          <?php  } else { ?>
            <?php  if($hd['starttime']>$now) { ?>
              <a href="javascript:void(0)" class="buy-btn1">仍未开始</a>
            <?php  } else { ?>
              <?php  if($hd['endtime']<$now) { ?>
                <a href="javascript:void(0)" class="buy-btn1">已经结束</a>
              <?php  } else { ?>
                <?php  if(!empty($hd['paiwei']) && !empty($hd['renshu']) && empty($hd['shenhe']) && $hd['renshu']<=$done_num) { ?>
                  <a href="javascript:void(0)" onclick="paiwei()" class="buy-btn">立马排位</a>
                <?php  } else { ?>
                  <a href="<?php  echo $this->createMobileUrl('signup',array('id'=>$id))?>" class="buy-btn"><?php  echo $hd['baoming'];?></a>
                <?php  } ?>
              <?php  } ?>
            <?php  } ?>
          <?php  } ?>
        <?php  } ?>
        <?php  } ?>
      <?php  } else { ?>
        <a href="javascript:void(0)" class="buy-btn1">活动结束</a>
      <?php  } ?>
      </div>
		</div>

		<div class="end-date"><span style="font-weight:bold">报名截止</span> <?php  echo date('m月d日 H:i',$hd['deadline'])?></div>

  </div></div>
  <div class="content">
      <?php  if(!empty($sitem['list_show'])) { ?>
    <?php  if(!empty($done)) { ?>
    <div class="M_detail">
     <div class="mod_tab"><span>有<?php  echo $done_num;?>人报名成功</span></div>
     <div class="detail-item detail-more">
      <a href="<?php  echo $this->createMobileUrl('list2',array('id'=>$id))?>" class="more-user">
        <?php  if(is_array($done)) { foreach($done as $row) { ?>
        <?php  if(!empty($row['avatar'])) { ?>
        <img class="bm-user" src="<?php  echo $row['avatar'];?>" />
        <?php  } else { ?>
        <?php  if(!empty($sitem['thumb'])) { ?>
          <img class="bm-user" src="<?php  echo $_W['attachurl'];?><?php  echo $sitem['thumb'];?>" />
        <?php  } else { ?>
          <img class="bm-user" src="../addons/jy_signup_a/images/no-50.png" />
        <?php  } ?>
        <?php  } ?>
        <?php  } } ?>
      </a>
     </div>
    </div>
    <?php  } ?>
	<!-- 免费报名类活动 -->
    <div class="M_detail">
     <div class="mod_tab"><span>有<?php  echo $hd['num'];?>人报名(含等位)</span></div>
     <div class="detail-item detail-more">
      <a href="<?php  echo $this->createMobileUrl('list',array('id'=>$id))?>" class="more-user">
        <?php  if(is_array($cy)) { foreach($cy as $row) { ?>
        <?php  if(!empty($row['avatar'])) { ?>
        <img class="bm-user" src="<?php  echo $row['avatar'];?>" />
        <?php  } else { ?>
        <?php  if(!empty($sitem['thumb'])) { ?>
          <img class="bm-user" src="<?php  echo $_W['attachurl'];?><?php  echo $sitem['thumb'];?>" />
        <?php  } else { ?>
          <img class="bm-user" src="../addons/jy_signup_a/images/no-50.png" />
        <?php  } ?>
        <?php  } ?>
      	<?php  } } ?>
      </a>
     </div>
    </div>
      <?php  } ?>
    <!-- 基本信息 -->
    <?php  if($mendian_num==1) { ?>
    <div class="msgDiv" style="margin-top:15px;border-bottom:1px solid #eee"><img style="width:14px;vertical-align:top;margin-top:3px" src="../addons/jy_signup_a/images/shop.png"><?php  echo $hd['mendianname'];?></div>
    <?php  if(!empty($hd['tel'])) { ?>
    <a class="addressXX" href="tel:<?php  echo $hd['tel'];?>"><div class="msgDiv" style="border-bottom:1px solid #eee"><img style="width:14px;vertical-align:top;margin-top:3px" src="../addons/jy_signup_a/images/tel.png"><?php  echo $hd['tel'];?></div></a>
    <?php  } ?>
    <?php  } ?>
    <?php  if($mendian_num>1) { ?>
    <a href="<?php  echo $this->createMobileUrl('mdlist',array('hdid'=>$id))?>" style="color:#000"><div class="msgDiv" style="margin-top:15px;border-bottom:1px solid #eee"><img style="width:14px;vertical-align:top;margin-top:3px" src="../addons/jy_signup_a/images/shop.png">共适用于<?php  echo $mendian_num;?>家门店，查看详情</div></a>
    <?php  } ?>

    <div class="msgDiv" style="border-bottom:1px solid #eee"><img src="../addons/jy_signup_a/images/icon-time.png"><?php  echo $hd['time'];?></div>
    <a style="color:#000;line-height:22px" href="http://api.map.baidu.com/marker?location=<?php  echo $hd['lat'];?>,<?php  echo $hd['lng'];?>&title=<?php  echo $hd['address'];?>&content=<?php  echo $hd['address'];?>&output=html&src=weiba|weiweb"><div class="msgDiv" style="margin-top:1px"><img style="vertical-align:top;margin-top:3px" src="../addons/jy_signup_a/images/icon-address.png"><?php  echo $hd['address'];?></div></a>

    <div class="M_detail">
     <div class="mod_tab"><span>说明</span></div>
     <div class="M_detail-con">
        <?php  echo htmlspecialchars_decode($hd['description'])?>
     </div>

     <div class="M_detail" id="M_detail">
      <div class="mod_tab" id="commentCon"><span>评论</span></div>

      <!-- 评论内容 -->

      <?php  if(is_array($pl)) { foreach($pl as $row) { ?>
        <div class="peopleData">
          <?php  if(!empty($row['avatar'])) { ?>
          <img class="peopleData-head" src="<?php  echo $row['avatar'];?>"/>
          <?php  } else { ?>
          <?php  if(!empty($sitem['thumb'])) { ?>
            <img class="peopleData-head" src="<?php  echo $_W['attachurl'];?><?php  echo $sitem['thumb'];?>" />
          <?php  } else { ?>
            <img class="peopleData-head" src="../addons/jy_signup_a/images/no-50.png" />
          <?php  } ?>
          <?php  } ?>
          <div class="peopleData-leftData">
            <div class="peopleData-name"><span><?php  echo $row['nicheng'];?></span>
              <?php  if(!empty($row['zan'])) { ?>
              <div class="peopleData-name-support" data-support="1" data-id="<?php  echo $row['id'];?>" onclick="supportFunc(this)">
                <img src="../addons/jy_signup_a/images/icon-agree-on.png"/><span><?php  echo $row['num'];?></span>
              </div>
              <?php  } else { ?>
              <div class="peopleData-name-support" data-support="0" data-id="<?php  echo $row['id'];?>" onclick="supportFunc(this)">
                <img src="../addons/jy_signup_a/images/icon-agree.png"/><span><?php  echo $row['num'];?></span>
              </div>
              <?php  } ?>
            </div>
            <div class="peopleData-name gray mart10"><?php  echo $row['description'];?></div>
          </div>
        </div>
      <?php  } } ?>
     </div>
     <?php  if(count($pl)==10) { ?>
     <div class="city-comm-more detail-more latecolor" id="addMore">点击加载更多评论</div>
     <?php  } ?>

     <!-- 发表评论 -->

     <div class="city-comm-cmm">
      <textarea class="city-comm-cmm-txt" id="comment" name="comment" rows="" cols="" placeholder="说点神马吧"></textarea>
      <p><a href="javascript:void(0);" class="comment-btn latecolorbg">发表评论</a></p>
     </div>
    </div>

    <!-- 新的浮动层 -->
    <div class="M_layer fix">
     <div class="layer-box2">
      <div class="layer-item">
      <?php  if(!empty($sc)) { ?>
        <a href="javascript:void(0);" class="icon-like" style="color:red" data-liked="1"><img class="icon-like-img" src="../addons/jy_signup_a/images/layer-icon1-on.png"/><label id="likedFont">已喜欢</label></a>
      <?php  } else { ?>
       <a href="javascript:void(0);" class="icon-like gray1" data-liked="0"><img class="icon-like-img" src="../addons/jy_signup_a/images/layer-icon1.png"/><label id="likedFont">喜欢</label></a>
      <?php  } ?>
      </div>

      <div class="layer-item">
       <a href="javascript:void(0);" class="icon-comment">评论</a>
      </div>

     </div>
    </div>
  <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template(footer, TEMPLATE_INCLUDEPATH)) : (include template(footer, TEMPLATE_INCLUDEPATH));?>
  <div style="height:40px"></div>
  </div>

  <script src="http://libs.baidu.com/jquery/1.10.2/jquery.min.js"></script>
  <script src="../addons/jy_signup_a/js/notice.js"></script>
  <script src="../addons/jy_signup_a/js/swiper.min.js"></script>
  <script>
  function paiwei() {
     if(confirm("目前活动报名人数已满，如需等位，点击【好】继续报名"))
     {
        window.location.href="<?php  echo $_W['siteroot'].'app/'.substr($this->createMobileUrl('signup',array('id'=>$id)),2)?>";
     }
  }

  function toAvtiveFunc(){
        $.post("<?php  echo $_W['siteroot'].'app/'.substr($this->createMobileUrl('detail',array('op'=>'cy','id'=>$_GPC['id'])),2)?>",function(data){
            if (data == 1) {
                window.location.href="<?php  echo $_W['siteroot'].'app/'.substr($this->createMobileUrl('signup'),2)?>";
            }
            else if (data==2)
            {
                window.location.href="<?php  echo $_W['siteroot'].'app/'.substr($this->createMobileUrl('login',array('id'=>$id)),2)?>";
            }
            else if (data == 3) {
                <?php  if($weixin==1) { ?>
                window.location.href="<?php  echo $_W['siteroot'].'app/'.substr($this->createMobileUrl('money',array('foo'=>'hd','id'=>$id)),2)?>";
                <?php  } else { ?>
                window.location.href="<?php  echo $_W['siteroot'].'app/'.substr($this->createMobileUrl('pc_money',array('foo'=>'hd','id'=>$id)),2)?>";
                <?php  } ?>
            }
            else if (data==4)
            {
                showNoticeFunc("已过了报名截止日期！");
            }
            else{
                showNoticeFunc("报名失败！"+data);
            }
        });
    }

function supportFunc(obj){
  var txt = parseInt($(obj).find("span").text());
    var hdcommentid=$(obj).data("id");
    var index = $(obj).parent().parent().parent().index()-1;
    if($(obj).data("support") == "0"){
      $.post("<?php  echo $_W['siteroot'].'app/'.substr($this->createMobileUrl('detail',array('op'=>'zan','id'=>$id)),2)?>"+"&hdcommentid="+hdcommentid,function(data){
          if (data == 1) {
            $(".peopleData-name-support").eq(index).find("img").attr("src","../addons/jy_signup_a/images/icon-agree-on.png");
            $(".peopleData-name-support").eq(index).find("span").text(txt+1);
            $(".peopleData-name-support").eq(index).data("support","1");
          }
          else if(data ==2) {
            window.location.href="<?php  echo $_W['siteroot'].'app/'.substr($this->createMobileUrl('login'),2)?>";
          }
          else{
              showNoticeFunc("操作失败！");
          }
      });
    }
    else{
      $.post("<?php  echo $_W['siteroot'].'app/'.substr($this->createMobileUrl('detail',array('op'=>'zan','id'=>$id)),2)?>"+"&hdcommentid="+hdcommentid,function(data){
          if (data == 1) {
            $(".peopleData-name-support").eq(index).find("img").attr("src","../addons/jy_signup_a/images/icon-agree.png");
            $(".peopleData-name-support").eq(index).find("span").text(txt-1);
            $(".peopleData-name-support").eq(index).data("support","0");
          }
          else if(data ==2) {
            window.location.href="<?php  echo $_W['siteroot'].'app/'.substr($this->createMobileUrl('login'),2)?>";
          }
          else{
              showNoticeFunc("操作失败！");
          }
      });
    }
}

  // 喜欢
  $(".icon-like").bind("click",function(){
    if($(this).data("liked") == "0"){
      $.post("<?php  echo $_W['siteroot'].'app/'.substr($this->createMobileUrl('detail',array('op'=>'sc','id'=>$id)),2)?>",function(data){
          if (data == 1) {
            $(".icon-like-img").attr("src","../addons/jy_signup_a/images/layer-icon1-on.png");
            $(".icon-like").removeClass("gray1").addClass("red");
            $("#likedFont").text("已喜欢");
            $(".icon-like").data("liked","1");
          }
          else if(data ==2) {
            window.location.href="<?php  echo $_W['siteroot'].'app/'.substr($this->createMobileUrl('login'),2)?>";
          }
          else{
              showNoticeFunc("操作失败！");
          }
      });
    }
    else{
      $.post("<?php  echo $_W['siteroot'].'app/'.substr($this->createMobileUrl('detail',array('op'=>'sc','id'=>$id)),2)?>",function(data){
          if (data == 1) {
            $(".icon-like-img").attr("src","../addons/jy_signup_a/images/layer-icon1.png");
            $(".icon-like").removeClass("red").addClass("gray1");
            $("#likedFont").text("喜欢");
            $(".icon-like").data("liked","0");
          }
          else if(data ==2) {
            window.location.href="<?php  echo $_W['siteroot'].'app/'.substr($this->createMobileUrl('login'),2)?>";
          }
          else{
              showNoticeFunc("操作失败！");
          }
      });
    }
  });

  // 评论
  $(".icon-comment").bind("click",function(){
    $("#comment").focus();
  });
  $(".comment-btn").bind("click",function(){
    var str = $("#comment").val();
    if(str == ""){
      showNoticeFunc("请输入评论内容!");
    }
    else
    {
      $.post("<?php  echo $_W['siteroot'].'app/'.substr($this->createMobileUrl('detail',array('op'=>'pl','id'=>$id)),2)?>"+"&pl="+$("#comment").val(),function(data){
          if (data.status == 1) {
            showNoticeFunc("评论成功！");
            $("#comment").val("");
            $("#commentCon").after(data.log);
            $("html,body").animate({scrollTop:$("#M_detail").offset().top-80}, 200);
          }
          else if(data.status ==2) {
            window.location.href="<?php  echo $_W['siteroot'].'app/'.substr($this->createMobileUrl('login'),2)?>";
          }
          else{
              showNoticeFunc("评论失败！");
          }
      },"json");
    }
  });

  var pindex=1;
  //加载更多
  $("#addMore").bind("click",function(){
      $.post("<?php  echo $_W['siteroot'].'app/'.substr($this->createMobileUrl('detail',array('op'=>'hq','id'=>$id)),2)?>"+"&pindex="+pindex,function(data){
        if (data.status == 1) {
          pindex++;
          $("#M_detail").append(data.log);



          if(data.num<10){
              $("#addMore").hide();
            }
        }
        else
        {
          showNoticeFunc("获取失败！");
        }
      },"json");
  });

  // 报名框浮动
  window.onscroll = function () {Scroll();}
  function Scroll() {
      var Y = $(".basic-box").height() + 60;

      if ($(window).scrollTop() >= Y){
        $(".basic-box").css({
          "position":"fixed",
          "top":"0",
          "padding":"10px",
          "max-width":"460px"
        });
      }
      else{
        $(".basic-box").css({"position":"relative","max-width":"480px","padding":"10px 2%"});
      }
  }

  // 轮播图
  var swiper = new Swiper(".swiper-container", {
    loop: true,
    autoplay:2500
  });
  </script>
  <?php  if($weixin==1) { ?>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>

    <?php  $signPackage=$_W['account']['jssdkconfig'];?>
    <script>

        var appid = '<?php  echo $_W['account']['jssdkconfig']['appId'];?>';
        var timestamp = '<?php  echo $_W['account']['jssdkconfig']['timestamp'];?>';
        var nonceStr = '<?php  echo $_W['account']['jssdkconfig']['nonceStr'];?>';
        var signature = '<?php  echo $_W['account']['jssdkconfig']['signature'];?>';

        wx.config({
            debug: false,
            appId: appid,
            timestamp: timestamp,
            nonceStr: nonceStr,
            signature: signature,
            jsApiList: ['checkJsApi','onMenuShareTimeline','onMenuShareAppMessage','onMenuShareQQ','onMenuShareWeibo','getLocation']
        });
    </script>
    <script type="text/javascript">
        var params = {
            title: "<?php  echo $hd['hdname'];?>",
            <?php  if(empty($sitem['sharedesc'])) { ?>
            desc: "活动管理!",
            <?php  } else { ?>
            desc: "<?php  echo $sitem['sharedesc'];?>",
            <?php  } ?>
            link: "<?php  echo $_W['siteroot'].'app/'.substr($this->createMobileUrl('detail',array('id'=>$id)),2)?>",
            <?php  if(empty($sitem['sharelogo'])) { ?>
            imgUrl: "<?php  echo $_W['siteroot'];?>addons/jy_signup_a/icon.jpg",
            <?php  } else { ?>
            imgUrl: "<?php  echo $_W['attachurl'];?><?php  echo $sitem['sharelogo'];?>",
            <?php  } ?>
        };
        wx.ready(function () {
            wx.showOptionMenu();
            wx.onMenuShareAppMessage.call(this, params);
            wx.onMenuShareTimeline.call(this, params);

            <?php  if(!empty($sitem['gps'])) { ?>
            wx.getLocation({
                type: 'wgs84', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
                success: function (res) {
                    var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
                    var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
                    var speed = res.speed; // 速度，以米/每秒计
                    var accuracy = res.accuracy; // 位置精度
                    $.post("<?php  echo $_W['siteroot'].'app/'.substr($this->createMobileUrl('location'),2)?>"+"&lat="+latitude+"&lng="+longitude,function(data){
                        if (data == 1) {
                        }
                        else{
                            alert("提交地理位置失败！");
                        }
                    });
                }
            });
            <?php  } ?>
        });
    </script>
    <?php  } ?>

<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=jy_signup_a"></script></body>
</style>
