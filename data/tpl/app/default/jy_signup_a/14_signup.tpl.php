<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>


  <link rel="stylesheet" type="text/css" href="../addons/jy_signup_a/css/header.css?13323">
  <link rel="stylesheet" type="text/css" href="../addons/jy_signup_a/css/notice.css">
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template(style, TEMPLATE_INCLUDEPATH)) : (include template(style, TEMPLATE_INCLUDEPATH));?>
  <style>
  body{background: #fff;}
    .M_page {
        width:100%;
        background-color:#fff;
        -webkit-transform:none;
        color:#939393;
    }
    .M_detail {
        margin:7px 0 0;
    }
    .M_module {
        margin:7px 0 0;
    }
    .M_detail .mod_tab {
        height:30px;
        line-height:30px;
        width:95%;
        padding-left: 2%;
        overflow:hidden;
        color:#A2A2A2;
        font-size:12px;
    }
    .M_module .item-box {
        border-top: 1px solid #EAEAEA;
    }
    .M_module .item {
        background:#FFF;
        line-height: 35px;
        font-size: 12px;
        display: table;
        width: 100%;
        color:#666666;
        border-bottom: 1px solid #EAEAEA;
    }
    .M_module .item .input {
        font-size:13px;
        padding:10px 2px;
        width:95%;
        border: 0 none;
        margin-left: 10px
    }
    @media screen and (min-width: 414px){
      .M_module .item .input {
          font-size:13px;
          padding:10px 0;
          width:95%;
          border: 0 none;
          margin-left: 10px
      }
    }
    .M_module .item select {
        font-size:13px;
        padding:10px 0;
        width:95%;
        border: none;
        color: #a9a9a9;
        margin-left: 10px
    }
    .M_module .item .textarea {
        font-size:13px;
        padding:10px 0;
        border: 0 none;
        width: 95%;
    }
    .M_button {
        padding:10px;
    }
    .M_button .btn1 {
        width:100%;
        height:40px;
        line-height:40px;
        font-size:16px;
        color:#FFF;
        /*background:#46CEC0;*/
        text-align:center;
        border-radius: 4px;
        display:inline-block;
    }
    .M_button .btn2 {
        width:100%;
        height:40px;
        line-height:40px;
        font-size:16px;
        color:#FFF;
        background:#b8b8b8;
        text-align:center;
        border-radius: 4px;
        display:inline-block;
        margin-top:10px;
    }
    .M_result .result-btn {
        padding:20px 50px 20px;
    }
    .M_result .result-btn .btn {
        width: 100%;
        height: 40px;
        line-height: 40px;
        font-size: 16px;
        color: #FFF;
        /*background: #46CEC0;*/
        text-align: center;
        border-radius: 4px;
        display: inline-block;
    }
    .M_title {
        padding:10px 10px 0;
        font-size:16px;
        /*color:#46CEC0;*/
    }
    .M_result .result-icon {
        width:90px;
        height:80px;
        background:url("../addons/jy_signup_a/images/icon-result.png") no-repeat center center;
        background-size:45px;
        margin:0 auto;
    }
    .M_result .result-text {
        color:#828282;
        font-size:16px;
        line-height:150%;
        text-align: center;
    }
    #share{
      position: fixed;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0,0,0,.8);
      display: none;
    }
    #share>img{width: 100%}
    input,select{outline: none;border:none;background:none;-webkit-appearance:none}
    /*#sex,#education{padding: 0 10px}*/
    <?php  if(IMS_VERSION>=0.8) { ?>
    .help-block img{
       max-width: 100%;
       max-height: 250px;
    }
    <?php  } ?>
  </style>
 </head>
 <body>

    <header>
      <a href="javascript:history.go(-1)"><div class="navbar-btn floL"><img class="icon-back" src="../addons/jy_signup_a/images/header-back.png"></div></a>
      <a href="<?php  echo $this->createMobileUrl('geren')?>"><div class="navbar-btn floR"><img class="icon-back" src="../addons/jy_signup_a/images/header-person.png"></div></a>
      <h1 class="latecolorbg" style="margin:0;padding:0"><?php  if(!empty($sitem['aname'])) { ?><?php  echo $sitem['aname'];?><?php  } else { ?>报名<?php  } ?></h1>
    </header>

   <div class="M_page" id="wannago" style="-webkit-transform-origin: 0px 0px; opacity: 1; -webkit-transform: scale(1, 1)">
    <!-- 活动标题 -->
    <div class="M_title latecolor">
     <?php  echo $hd['hdname'];?>
    </div>
    <div class="col-xs-12">
    <!-- 联系方式 -->
    <?php  if(!empty($ziliao)) { ?>
     <div class="M_detail M_module">
      <div class="mod_tab">
       <span>报名信息</span>
      </div>
      <div class="item-box">
      <?php  if(is_array($ziliao)) { foreach($ziliao as $z) { ?>

       <div class="item">
          <?php  if($z['type']==2) { ?>
              <input id="<?php  echo $z['id'];?>" value="<?php  echo $zl_val[$z['id']];?>" type="text" placeholder="请输入<?php  echo $z['name'];?><?php  if($z['enabled']==1) { ?>(必填)<?php  } ?>" class="input" />
          <?php  } ?>
          <?php  if($z['type']==3) { ?>
            <select id="<?php  echo $z['id'];?>">
              <option value="0">请选择<?php  echo $z['name'];?><?php  if($z['enabled']==1) { ?>(必选)<?php  } ?></option>
              <?php  if(is_array($xx[$z['id']])) { foreach($xx[$z['id']] as $x) { ?>
              <option value="<?php  echo $x['name'];?>" <?php  if($x['name']==$zl_val[$z['id']]) { ?> selected <?php  } ?>><?php  echo $x['name'];?></option>
              <?php  } } ?>
            </select>
          <?php  } ?>
          <?php  if($z['type']==6) { ?>
            <?php  if(!empty($cy)) { ?>
              <input id="<?php  echo $z['id'];?>" value="<?php  echo $zl_val[$z['id']];?>" type="tel" placeholder="请输入手机号码<?php  if($z['enabled']==1) { ?>(必填)<?php  } ?>" class="input" />
            <?php  } else { ?>
              <input id="<?php  echo $z['id'];?>" value="<?php  echo $member['mobile'];?>" type="tel" placeholder="请输入手机号码<?php  if($z['enabled']==1) { ?>(必填)<?php  } ?>" class="input" />
            <?php  } ?>
          <?php  } ?>
          <?php  if($z['type']==7) { ?>
            <?php  if(!empty($cy)) { ?>
              <input id="<?php  echo $z['id'];?>" value="<?php  echo $zl_val[$z['id']];?>" type="text" placeholder="请输入真实姓名<?php  if($z['enabled']==1) { ?>(必填)<?php  } ?>" class="input" />
            <?php  } else { ?>
              <input id="<?php  echo $z['id'];?>" value="<?php  echo $member['nicheng'];?>" type="text" placeholder="请输入真实姓名<?php  if($z['enabled']==1) { ?>(必填)<?php  } ?>" class="input" />
            <?php  } ?>
          <?php  } ?>
           <?php  if($z['type']==8) { ?>
           <span><?php  echo $z['name'];?></span>

              <?php  echo tpl_form_field_image('img'.$z['id'], $zl_val[$z['id']])?>
              <script type="text/javascript">
                   $(function(){
                      <?php  $zl_val[$z['id']] = explode(',',$zl_val[$z['id']])?>
                      <?php  if(!empty($zl_val[$z['id']]['0'])) { ?>
                      <?php  if(is_array($zl_val[$z['id']])) { foreach($zl_val[$z['id']] as $r) { ?>
                         $('.js-image-img101').parent().find('.js-image-preview').append('<input type="hidden" value="<?php  echo $r;?>" name="img101[]" /><img src="<?php  echo tomedia($r)?>" data-id="<?php  echo md5($r)?>"  />');
                       <?php  } } ?>
                       <?php  } ?>
                   })
              </script>
          <?php  } ?>
       </div>
       <?php  } } ?>
       <!-- -->
      </div>
     </div>
     <?php  } ?>


     <!-- 说点啥 -->
     <div class="M_detail M_module">

      <div class="mod_tab">
       <span>评论</span>
      </div>
      <div class="item-box" style="line-height:100%;">
       <div class="item" style="line-height:100%;">
        <textarea class="textarea" name="saywhat" id="saywhat" placeholder="评论还没写？不可以呦~写下您对本次活动的期许，让小看更好地为您准备惊喜。"></textarea>
       </div>
      </div>
     </div>
         </div>
		 
     <div class="M_button">
      <a class="btn1 btn-buy s_save latecolorbg" href="javascript:submitFunc()">提交报名</a>
      <?php  if(!empty($cy)  ) { ?>

        <?php  if(!empty($xz) && empty($hd['qx'])  ) { ?>
        <?php  } else { ?>
		  <?php  if(!empty($hd['paiwei'])  ||   $xz['status']==1 ) { ?>
          <a href="javascript:noFunc();" class="btn2">我不参加了</a>
          <?php  } ?>

        <?php  } ?>
      <?php  } ?>
      <a href="<?php  echo $this->createMobileUrl('detail',array('id'=>$id))?>" class="btn2">取&nbsp;&nbsp;&nbsp;&nbsp;消</a>
     </div>

  <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template(footer, TEMPLATE_INCLUDEPATH)) : (include template(footer, TEMPLATE_INCLUDEPATH));?>
   </div>

   <div class="M_page" id="resultPage" style="display:none">
    <div class="M_result">
        <div class="result-icon"></div>
        <div class="result-text">
          恭喜！您已成功报名
          <br/><?php  echo $hd['hdname'];?>
        </div>

        <div class="result-btn">
          <a href="<?php  echo $this->createMobileUrl('myplan')?>" class="btn latecolorbg">查看我的报名</a>
        </div>
    </div>

    <div class="M_button">
      <a href="javascript:void(0);" class="btn1" id="shareBtn" style="margin-bottom:10px;">分享给好友</a>
      <a href="<?php  echo $this->createMobileUrl('index')?>" class="btn1">查看更多活动</a>
    </div>
  </div>

  <div id="share"><img src="../addons/jy_signup_a/images/favor_weixin.png"></div>
  <script src="../addons/jy_signup_a/js/notice.js"></script>
  <script>

  $(function(){
    $('title').html("<?php  echo $hd['hdname'];?>");
  })
  window.onload = function(){

    var sex = $("#sex").val();
    var education = $("#education").val();
    if(sex == "0"){
      $("#sex").css("color","#a9a9a9");
    }else{
      $("#sex").css("color","#000");
    }
    if(education == "0"){
      $("#education").css("color","#a9a9a9");
    }else{
      $("#education").css("color","#000");
    }

  }
  $("#sex").change(function() {
    if($(this).val() == "0"){
      $("#sex").css("color","#a9a9a9");
    }else{
      $("#sex").css("color","#000");
    }
  });
  $("#education").change(function() {
    if($(this).val() == "0"){
      $("#education").css("color","#a9a9a9");
    }else{
      $("#education").css("color","#000");
    }
  });
  </script>
  <script>
  function submitFunc(){
    var ziliao='';

    var saywhat = $("#saywhat");

     <?php  if($hd['is_must']==1) { ?>
      if(!saywhat.val()){
              showNoticeFunc("请填写评论!");
              return false;
        }
     <?php  } ?>
    <?php  if(is_array($ziliao)) { foreach($ziliao as $z) { ?>
      <?php  if($z['type']==2 || $z['type']==3 || $z['type']==6 || $z['type']==7|| $z['type']==8) { ?>
      var zl_<?php  echo $z['id'];?>=$("#<?php  echo $z['id'];?>").val();
      <?php  } ?>
      <?php  if($z['enabled']==1) { ?>
        <?php  if($z['type']==3) { ?>
          if(zl_<?php  echo $z['id'];?> == 0){
              showNoticeFunc("请选择<?php  echo $z['name'];?>");
              return false;
            }
        <?php  } ?>
        <?php  if($z['type']==2 || $z['type']==7) { ?>
          if(!zl_<?php  echo $z['id'];?>){
                showNoticeFunc("请输入<?php  echo $z['name'];?>");
                return false;
              }
        <?php  } ?>
        <?php  if($z['type']==6) { ?>
          var myreg = /^1[345789]\d{9}$/;
          if(zl_<?php  echo $z['id'];?>.length==0) {
             showNoticeFunc('请输入手机号码！');
             return false;
          }
          if(zl_<?php  echo $z['id'];?>.length!=11 || !myreg.test(zl_<?php  echo $z['id'];?>)) {
              showNoticeFunc('请输入有效的手机号码！');
              return false;
          }
        <?php  } ?>
      <?php  } ?>
      <?php  if($z['type']==8) { ?>
          ziliao+="&zl_<?php  echo $z['id'];?>=";
          var img_<?php  echo $z['id'];?> = $("input[name='img<?php  echo $z['id'];?>[]']");
          var i_<?php  echo $z['id'];?> = 0;
          $("input[name='img<?php  echo $z['id'];?>']").each(function(){
                 if(i_<?php  echo $z['id'];?>==0){
                    ziliao+= $(this).val();
                 }else{
                   ziliao+= ","+$(this).val();
                 }
                 i_<?php  echo $z['id'];?>++;
          });

         <?php  } else { ?>
         ziliao+="&zl_<?php  echo $z['id'];?>="+zl_<?php  echo $z['id'];?>;
      <?php  } ?>

    <?php  } } ?>

    var pl = $("#saywhat").val();
    // alert(ziliao);
    // return false;
      if(pl){
          ziliao+="&pl="+pl;
      }

    $.post("<?php  echo $_W['siteroot'].'app/'.substr($this->createMobileUrl('signup',array('op'=>'add','id'=>$id)),2)?>"+ziliao,function(data){
        if (data == 1) {
            $("#wannago").hide();
            $("#resultPage").show();
        }
        else if(data==2)
        {
          <?php  if($weixin==1) { ?>
            window.location.href="<?php  echo $_W['siteroot'].'app/'.substr($this->createMobileUrl('money',array('id'=>$id)),2)?>";
          <?php  } else { ?>
            window.location.href="<?php  echo $_W['siteroot'].'app/'.substr($this->createMobileUrl('pc_money',array('id'=>$id,'mid'=>$mid)),2)?>";
          <?php  } ?>
        }
        else if(data==3)
        {
          showNoticeFunc("<?php  echo $hd['diyjf'];?>");
        }
        else if(data==4)
        {
          showNoticeFunc("该活动仍未开始！");
        }
        else if(data==5)
        {
          showNoticeFunc("该活动仍已经结束！");
        }
        else{
            showNoticeFunc("报名失败！");
        }
    });
  }

  function noFunc(){
    $.post("<?php  echo $_W['siteroot'].'app/'.substr($this->createMobileUrl('signup',array('op'=>'no','id'=>$id)),2)?>",function(data){
          if (data == 1) {
              showNoticeFunc("取消报名成功！");
              setTimeout(function(){
                  window.location.href="<?php  echo $_W['siteroot'].'app/'.substr($this->createMobileUrl('detail',array('id'=>$id)),2)?>";
              }, 1500);
          }
          else if(data==2)
          {
            showNoticeFunc("取消报名成功！报名费用将在工作人员审核后退还给你!");
            setTimeout(function(){
                  window.location.href="<?php  echo $_W['siteroot'].'app/'.substr($this->createMobileUrl('detail',array('id'=>$id)),2)?>";
              }, 2000);
          }
          else if(data==3)
          {
            showNoticeFunc("你已被选中，无法取消报名！");
          }
          else if(data==4)
          {
            showNoticeFunc("你未报名该活动，无法进行取消！返回重试！");
          }
          else{
              showNoticeFunc("操作失败！"+data);
          }
      });
  }

  $("#shareBtn").bind("click",function(){
    $("#share").show();
  });
  $("#share").bind("click",function(){
    $(this).hide();
  });

  //
  function validatemobile(mobile) {
      var myreg = /^1[345789]\d{9}$/;
      if(mobile.length==0) {
         showNoticeFunc('请输入手机号码！');
         return false;
      }
      if(mobile.length!=11 || !myreg.test(mobile)) {
          showNoticeFunc('请输入有效的手机号码！');
          return false;
      }
      return true;
  }
  function IsEmail(email){
    var str = email.trim();
    if(str.length!=0){
      reg=/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
      if(!reg.test(str)){
          return false;
      }
    }
    return true;
  }
  </script>
  <?php  if($weixin==1) { ?>

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
<script>
    $(".mui-image-preview").on('click','img',function(){
      var id = $(this).attr('data-id');
      $(".js-submit").attr('data-id',id);
      return false;
        // alert(id);
    })

</script>
 <script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=jy_signup_a"></script></body>
</html>
