<?php defined('IN_IA') or exit('Access Denied');?>


<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>积分商城</title>
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, width=device-width">
<meta content="telephone=no" name="format-detection" />
        <link rel="stylesheet" href="../addons/hc_credit_shopping/style/img/p/yymobile/1509301730/css/common.css">
        <link rel="stylesheet" href="../addons/hc_credit_shopping/style/img/p/yymobile/1509301730/css/user.css">
		<script src="../addons/hc_credit_shopping/style/js/jquery-1.11.1.min.js"></script>

</head>




<body class="" onload="msg()">
<div class="m-user" id="dvWrapper">
        <div class="m-simpleHeader" id="dvHeader">
            <a href="<?php  echo $this->createMobileUrl('list')?>" data-pro="back" data-back="true" class="m-simpleHeader-back"><i class="ico ico-back"></i></a>
            
            <h1>个人中心</h1>
        </div>
    <div class="m-user-index">
    <div class="m-user-summary">
        <img class="bg" src="http://mimg.127.net/p/yymobile/lib/img/user/summary_bg.png" width="100%" />
        <div class="info">
            <div class="m-user-avatar">    <img width="50" height="50" onerror="this.src='../addons/hc_credit_shopping/style/img/90.jpg'" src="<?php  echo $member['headimg'];?>" />
</div>
            <div class="txt">
                <div class="name"><?php  echo $member['nickname'];?></div>
                <div class="money">余额：<span class="num"><?php  echo $credit_shoppingbi;?></span>积分<!--<a href="http://m.1.163.com/pay/recharge.do" class="w-button w-button-s m-user-summary-btn-normal">充值</a>--></div>
            </div>
        </div>
        <a class="aside">
            <b class="ico-next"></b>
        </a>
    </div>
        <div class="m-user-bar">
           <a href="<?php  echo $this->createMobileUrl('myorder',array('status'=>2))?>" class="w-bar">订单记录<span class="w-bar-ext"><b class="ico-next"></b></span></a>
		   <a href="<?php  echo $this->createMobileUrl('bi_order')?>" class="w-bar">积分购买<span class="w-bar-ext"><b class="ico-next"></b></span></a>
		   <a href="<?php  echo $this->createMobileUrl('myaddress')?>" class="w-bar">收货地址<span class="w-bar-ext"><b class="ico-next"></b></span></a>
		
		</div>
        <div class="m-user-bar">
        </div>
    </div>
    <div class="m-user-duobaoRecord" id="duobaoRcd_dvWrapper" style="display:none;"></div>
    <div class="m-user-duobaoRecord" id="win_dvWrapper" style="display:none;"></div>
    <div class="m-user-shareList" id="share_dvWrapper" style="display:none;"></div>
    <div class="m-user-wishList" id="wish_dvWrapper" style="display:none;"></div>
</div>
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=9&c=utility&a=visit&do=showjs&m=hc_credit_shopping"></script></body>



<!--转发js-->
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<?php  $signPackage=$_W['account']['jssdkconfig'];?>	           
<?php  $setting=$this->module['config'];?>	           
<script type="text/javascript">
  wx.config({
    debug: false,
    appId: '<?php  echo $signPackage["appId"];?>',
    timestamp: '<?php  echo $signPackage["timestamp"];?>',
    nonceStr: '<?php  echo $signPackage["nonceStr"];?>',
    signature: '<?php  echo $signPackage["signature"];?>',
    jsApiList: [
      'onMenuShareAppMessage',
	  'onMenuShareTimeline',
	  'onMenuShareQQ',	  
    ]
  });
  wx.ready(function () {
    wx.onMenuShareAppMessage({
      title: "<?php  echo $setting['zhuanfa_title'];?>",
      desc: "<?php  echo $setting['zhuanfa_content'];?>",
      link: "<?php  echo $_W['siteroot'].'app/'.$this->createMobileUrl('list',array(),true)?>",
      imgUrl: "<?php  echo $_W['attachurl'].$setting['zhuanfa_img']?>",
      trigger: function (res) {
        //alert('用户点击发送给朋友');
      },
      success: function (res) {
        //window.location.href =adurl;//分享成功回调
      },
      cancel: function (res) {
       //window.location.href =adurl;//取消回调
      },
      fail: function (res) {
        alert(JSON.stringify(res));//失败回调
      }
    });
	wx.onMenuShareTimeline({
      title: "<?php  echo $setting['zhuanfa_title'];?>",
      desc: "<?php  echo $setting['zhuanfa_content'];?>",
      link: "<?php  echo $_W['siteroot'].'app/'.$this->createMobileUrl('list',array(),true)?>",
      imgUrl: "<?php  echo $_W['attachurl'].$setting['zhuanfa_img']?>",
      trigger: function (res) {
        //alert('用户点击发送给朋友');
      },
      success: function (res) {
        //window.location.href =adurl;//分享成功回调
      },
      cancel: function (res) {
       //window.location.href =adurl;//取消回调
      },
      fail: function (res) {
        alert(JSON.stringify(res));//失败回调
      }
    });
	wx.onMenuShareQQ({
      title: "<?php  echo $setting['zhuanfa_title'];?>",
      desc: "<?php  echo $setting['zhuanfa_content'];?>",
      link: "<?php  echo $_W['siteroot'].'app/'.$this->createMobileUrl('list',array(),true)?>",
      imgUrl: "<?php  echo $_W['attachurl'].$setting['zhuanfa_img']?>",
      trigger: function (res) {
        //alert('用户点击发送给朋友');
      },
      success: function (res) {
        //window.location.href =adurl;//分享成功回调
      },
      cancel: function (res) {
       //window.location.href =adurl;//取消回调
      },
      fail: function (res) {
        alert(JSON.stringify(res));//失败回调
      }
    });
	
	
	
	
  });
  

  
  
  
  
</script>




</html>

