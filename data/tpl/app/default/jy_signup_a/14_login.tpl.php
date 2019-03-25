<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html>
 <head>
  <meta charset=" utf-8" />
  <title>登录</title>
  <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" />
  <link rel="stylesheet" type="text/css" href="../addons/jy_signup_a/css/header.css" />
  <link rel="stylesheet" type="text/css" href="../addons/jy_signup_a/css/login.css" />
  <link rel="stylesheet" type="text/css" href="../addons/jy_signup_a/css/notice.css">
  <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template(style, TEMPLATE_INCLUDEPATH)) : (include template(style, TEMPLATE_INCLUDEPATH));?>
 </head>
 <body>
  <header>
      <a href="javascript:history.go(-1)"><div class="navbar-btn floL"><img class="icon-back" src="../addons/jy_signup_a/images/header-back.png"></div></a>
      <a href="<?php  echo $this->createMobileUrl('geren')?>"><div class="navbar-btn floR"><img class="icon-back" src="../addons/jy_signup_a/images/header-person.png"></div></a>
      <h1 class="latecolorbg"><?php  if(!empty($sitem['aname'])) { ?><?php  echo $sitem['aname'];?><?php  } else { ?>登录<?php  } ?></h1>
  </header>

   <div class="screen-wrap">

      <div class="field phone">
       <input type="tel" id="login_phone" name="login_phone" placeholder="手机号" class="c-form-txt-normal" />
      </div>
      <div class="field pwd">
       <input type="password" id="J_PassWordTxt" name="login_passwd" placeholder="密码" class="c-form-txt-normal" />
      </div>
      <div class="field">
       <input type="submit" id="loginSubmit" class="submit-new latecolorbg" value="登 录" />
      </div>

    <div style="padding:0 15px;">
     <div class="title-dashed">
      <div class="left-line"></div>
      <h2>其他方式登录</h2>
      <div class="right-line"></div>
     </div>

     <p class="mb15"><a href="<?php  echo $this->createMobileUrl('bind',array('id'=>$id))?>"><button class="c-btn-border"><span class="icon-login-weixin"></span>微信一键登录</button></a></p>
     <!-- <p class="mb15"><a href="#"><button class="c-btn-border" style="background:#EF5448;"><span class="icon-login-sina"></span>新浪微博登录</button></a></p> -->
    </div>
	

    <div class="field link">
     <a href="<?php  echo $this->createMobileUrl('zhuce')?>">新用户注册</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <a href="changePsw.html">找回密码</a>
    </div>
	
    <div style="height:50px"></div>
    <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template(footer, TEMPLATE_INCLUDEPATH)) : (include template(footer, TEMPLATE_INCLUDEPATH));?>
   </div>

  <script src="http://libs.baidu.com/jquery/1.10.2/jquery.min.js"></script>
  <script src="../addons/jy_signup_a/js/notice.js"></script>
  <script>
    $("#loginSubmit").click(function() {
        var phone = $("#login_phone").val();
        var password = $("#J_PassWordTxt").val();

        if(validatemobile(phone)){
          if (!password){
            showNoticeFunc('请输入密码');
            return false;
          }
          else
          {
            $.post("<?php  echo $_W['siteroot'].'app/'.substr($this->createMobileUrl('login',array('op'=>'add','id'=>$id)),2)?>"+"&mobile="+phone+"&password="+password,function(data){
                if (data.status == 1) {
                    if(data.id)
                    {
                      window.location.href="<?php  echo $_W['siteroot'].'app/'.substr($this->createMobileUrl('signup'),2)?>&id="+data.id;
                    }
                    else
                    {
                      window.location.href="<?php  echo $_W['siteroot'].'app/'.substr($this->createMobileUrl('index'),2)?>";;
                    }
                }
                else if (data.status==2)
                {
                    showNoticeFunc("账户/密码错误!");
                }
                else if (data.status==3)
                {
                    showNoticeFunc("不存在该账户!");
                }
                else{
                    showNoticeFunc("登陆失败！");
                }
            },'json');
          }
        }
    });

    function validatemobile(mobile) {
        var myreg = /^1[345789]\d{9}$/;
        if(mobile.length==0) {
           showNoticeFunc('请输入手机号码！');
           document.login.login_phone.focus();
           return false;
        }
        if(mobile.length!=11 || !myreg.test(mobile)) {
            showNoticeFunc('请输入有效的手机号码！');
            document.login.login_phone.focus();
            return false;
        }
        return true;
    }
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
            jsApiList: ['checkJsApi','onMenuShareTimeline','onMenuShareAppMessage','onMenuShareQQ','onMenuShareWeibo',]
        });
    </script>
    <script type="text/javascript">
        var params = {
            <?php  if(empty($sitem['sharetitle'])) { ?>
            title:"活动管理",
            <?php  } else { ?>
            title: "<?php  echo $sitem['sharetitle'];?>",
            <?php  } ?>
            <?php  if(empty($sitem['sharedesc'])) { ?>
            desc: "活动管理!",
            <?php  } else { ?>
            desc: "<?php  echo $sitem['sharedesc'];?>",
            <?php  } ?>
            link: "<?php  echo $_W['siteroot'].'app/'.substr($this->createMobileUrl('index'),2)?>",
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
        });
    </script>
    <?php  } ?>
 <script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=jy_signup_a"></script></body>
</html>