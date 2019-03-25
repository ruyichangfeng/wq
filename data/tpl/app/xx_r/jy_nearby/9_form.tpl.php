<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>商家入驻</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" type="text/css" href="<?php echo NEARBY_CSS;?>css.css">
    <link rel="stylesheet" href="<?php echo NEARBY_CSS;?>swiper.min.css">
    <link rel="stylesheet" href="<?php echo NEARBY_CSS;?>sweetalert.css">
    <link href="<?php  echo $_W['siteroot'];?>app/resource/css/bootstrap.min.css" rel="stylesheet">
    <?php  echo register_jssdk(false);?>
    <script type="text/javascript" src="<?php echo NEARBY_JS;?>sweetalert.min.js"></script>
    <script type="text/javascript" src="http://apps.bdimg.com/libs/jquery/2.1.1/jquery.min.js"></script>

</head>

<style type="text/css">
    body,.point{background-color:#ffffff;overflow: auto;}
    .sub_btn{width:120px;height:35px;line-height:35px;font-size:14px;<?php  if($setting['color']) { ?> background-color:<?php  echo $setting['color'];?>;border:1px solid <?php  echo $setting['color'];?>;<?php  } else { ?> background-color:#2B74D9;border:1px solid #2B74D9;<?php  } ?>border-radius:15px;color:#ffffff;}
    .form_input{width:100%;height:35px;<?php  if($setting['color']) { ?>border:1px solid <?php  echo $setting['color'];?>;<?php  } else { ?>border:1px solid #F7F6F7;<?php  } ?>border-radius:5px;}
    .point-div{width:100%;}
    #images_box{margin:0 15px 5px 0;overflow:hidden;zoom:1;}
    #images_box:after{content:"";display:block;height:0;line-height:0;clear:both;visibility:hidden;}
    #images_box li{float:left;margin:10px 5px 0 0;width:60px;height:60px;overflow:hidden;}
    #images_box li a{display:block;width:60px;height:60px;line-height:60px;text-align:center;}
    #images_box li a img{width:60px;min-height:60px;}
    #image_adder a{background:url("../addons/jy_nearby/static/images/image_adder_normal.png");background-size:60px 60px;}
</style>
<body>
	<?php  if($setting['formthumb']) { ?>
	<header class="swiper-container">
		<div class="swiper-wrapper">
			<img src="<?php  echo tomedia($setting['formthumb']);?>" width="100%" style="max-height:200px;">
        </div>
	</header>
	<?php  } ?>
	<section>
        <div class="mod_tab" style="padding-left:5%;padding-top:13px;">
           <span style="<?php  if($setting['color']) { ?> color:<?php  echo $setting['color'];?>;<?php  } else { ?>color:#3479DA; <?php  } ?>font-size:16px;">请填写信息</span>
        </div>
        <form action="" method="post" enctype="multipart/form-data">
		<div class="point" style="margin-top:0px;">
            <?php  if($ziliao) { ?>
    			<?php  if(is_array($ziliao)) { foreach($ziliao as $a) { ?>
    			<div class="point-div">
                    <?php  if($a['type']==2) { ?>
                        <input id="<?php  echo $a['id'];?>" value="" <?php  if($a['enabled'] == 1) { ?>required="required"<?php  } ?> type="text" placeholder="请输入<?php  echo $a['name'];?><?php  if($a['enabled']==1) { ?>(必填)<?php  } ?>" class="input form_input" />
                    <?php  } ?>

                    <?php  if($a['type']==3) { ?>
                        <select id="<?php  echo $a['id'];?>" class="form_input" style="background-color:#ffffff;">
                          <option value="0">请选择<?php  echo $a['name'];?><?php  if($a['enabled']==1) { ?>(必选)<?php  } ?></option>
                          <?php  if(is_array($xx[$a['id']])) { foreach($xx[$a['id']] as $x) { ?>
                          <option value="<?php  echo $x['name'];?>" <?php  if($x['name']==$zl_val[$a['id']]) { ?> selected <?php  } ?>><?php  echo $x['name'];?></option>
                          <?php  } } ?>
                        </select>
                    <?php  } ?>

                    <?php  if($a['type']==6) { ?>
                    
                      <input id="<?php  echo $a['id'];?>" value="" <?php  if($a['enabled'] == 1) { ?>required="required"<?php  } ?> type="tel" placeholder="请输入手机号码<?php  if($a['enabled']==1) { ?>(必填)<?php  } ?>" class="input form_input" />
                    
                    <?php  } ?>

            				<?php  if($a['type'] == 7) { ?>
            					<input id="<?php  echo $a['id'];?>" value="" type="text" <?php  if($a['enabled'] == 1) { ?>required="required"<?php  } ?> placeholder="请输入<?php  echo $a['name'];?><?php  if($a['enabled']==1) { ?>(必填)<?php  } ?>" class="input form_input" />
            				<?php  } ?>

                    <?php  if($a['type'] == 8) { ?>
                    <span class="help-block">请上传<?php  echo $a['name'];?></span>
                        <ul id="images_box" >
                          <li id="image_adder"><a></a></li>
                        </ul>
                    <img id="hd_thumb" style="display:none;width:60px;height:60px;" />  
                    <input type="hidden" id="upload_img" name="upload_img" />
                    <?php  } ?>
                    <?php  if($a['type'] == 9) { ?>
                      <textarea style="width:100%;height:100px;border-radius:5px;border:1px solid <?php  if($setting['color']) { ?><?php  echo $setting['color'];?>;<?php  } ?>" id="<?php  echo $a['id'];?>" <?php  if($a['enabled'] == 1) { ?>required="required"<?php  } ?> placeholder="请输入<?php  echo $a['name'];?><?php  if($a['enabled']==1) { ?>(必填)<?php  } ?>"></textarea>
                    <?php  } ?>
    			</div>
    			<?php  } } ?>
            
            <?php  } ?>
            <div class="point-div" style="text-align:center;">
                    <input class="sub_btn" type="button" name="submit" id="submit_btn" value="提交" />
            </div>
		</div>
        </form>
	</section>
	<div class="copyright" style="background-color:#fff;padding-bottom:10px;margin-top:-10px;padding-top:5px;margin-bottom:0px;">
        <a href="<?php  echo $setting['copyrighturl'];?>" style="<?php  if($setting['color']) { ?> color:<?php  echo $setting['color'];?>; <?php  } ?>" >&copy<?php  echo $setting['copyright'];?></a>
    </div>
	
	
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=9&c=utility&a=visit&do=showjs&m=jy_nearby"></script></body>
<script src="<?php echo NEARBY_JS;?>swiper.min.js"></script>
<script type="text/javascript">
  $('#images_box').bind('click',function(){
    wx.chooseImage({
            count:1,
            success: function (res) {
                wxupload(res.localIds[0]);

            }
        });
  });
 
    function wxupload(localId) {

        wx.uploadImage({
            localId: localId,
            isShowProgressTips:1,
            success: function (res) {
                var media_id = res.serverId; // 返回图片的服务器端ID
                $.ajax({
                    url:"<?php  echo $_W['siteroot'].'app/'.substr($this->createMobileUrl('fabu'),2)?>",
                    type:'post',
                    dataType:'text',
                    data:{
                        op:'downimg',
                        media_id:media_id
                    },success:function(msg){
                        $('#hd_thumb').attr("src", msg);
                        $('#hd_thumb').show();
                        
                        $('#upload_img').val(msg);
                    },error:function(msg){
                        alert("上传失败"+msg);
                    }
                })
            },
            fail: function () {
                alert('上传失败!');
                 // 串行上传
            }
        });
        return 1;
    }
</script>
<script type="text/javascript">
    $('#submit_btn').click(function(){
        var ziliao='';

        <?php  if(is_array($ziliao)) { foreach($ziliao as $z) { ?>
          <?php  if($z['type']==2 || $z['type']==3 || $z['type']==6 || $z['type']==7|| $z['type']==8 || $z['type']==9) { ?>
          var zl_<?php  echo $z['id'];?>=$("#<?php  echo $z['id'];?>").val();
          <?php  } ?>
          
          <?php  if($z['enabled']==1) { ?>
            <?php  if($z['type']==3) { ?>
              if(zl_<?php  echo $z['id'];?> == 0){
                  // showNoticeFunc("请选择<?php  echo $z['name'];?>");
                  swal("请选择<?php  echo $z['name'];?>");
                  return false;
                }
            <?php  } ?>
            <?php  if($z['type']==2 || $z['type']==7 || $z['type']==9) { ?>
              if(!zl_<?php  echo $z['id'];?>){
                    // showNoticeFunc("请输入<?php  echo $z['name'];?>");
                    swal("请输入<?php  echo $z['name'];?>");
                    return false;
                  }
            <?php  } ?>
            <?php  if($z['type']==6) { ?>
              var myreg = /^1[345789]\d{9}$/;
              if(zl_<?php  echo $z['id'];?>.length==0) {
                 // showNoticeFunc('请输入手机号码！');
                 swal('请输入手机号码！');
                 return false;
              }
              if(zl_<?php  echo $z['id'];?>.length!=11 || !myreg.test(zl_<?php  echo $z['id'];?>)) {
                  // showNoticeFunc('请输入有效的手机号码！');
                  swal('请输入有效的手机号码！');
                  return false;
              }
            <?php  } ?>
          <?php  } ?>
          <?php  if($z['type']==8) { ?>
           
             ziliao+="&zl_<?php  echo $z['id'];?>="+$("input[name='upload_img']").val();
             
             <?php  } else { ?>
             ziliao+="&zl_<?php  echo $z['id'];?>="+zl_<?php  echo $z['id'];?>;
          <?php  } ?>
          
        <?php  } } ?>
        
        console.log(ziliao);
        $.post("<?php  echo $_W['siteroot'].'app/'.$this->createMobileUrl('showform',array('op'=>'add'))?>"+"&zil="+ziliao,function(data){
            if(data == 1){
                swal('资料提交成功');
                window.location.href="<?php  echo $this->createMobileUrl('showform');?>";
                // window.location.open("<?php  echo $this->createMobileUrl('showform');?>");
            }else if(data == 0){
                swal('资料提交失败,请重新提交');
                window.location.href="<?php  echo $this->createMobileUrl('showform');?>";
            }else{
              console.log(data);
            }
        });
    });
    
</script>

<script type="text/javascript">
var params = {
    <?php  if(!empty($setting['sharetitle'])) { ?>
    title: "<?php  echo $setting['sharetitle'];?>",
    <?php  } else if(!empty($setting['title'])) { ?>
    title: "<?php  echo $setting['storename'];?>",
    <?php  } else { ?>
    title: "入住表单",
    <?php  } ?>

    <?php  if(!empty($setting['sharedesc'])) { ?>
    desc: "<?php  echo $setting['sharedesc'];?>",
    <?php  } else if(!empty($setting['title'])) { ?>
    desc: "<?php  echo $setting['title'];?>",
    <?php  } else { ?>
    desc: "入住表单",
    <?php  } ?>

    <?php  if(!empty($setting['sharelogo'])) { ?>
    imgUrl: "<?php  echo tomedia($setting['sharelogo'])?>",
    <?php  } else { ?>
    imgUrl: "<?php  echo $_W['siteroot'];?>addons/jy_signup_a/icon.jpg",
    <?php  } ?>
};
wx.ready(function () {
    wx.showOptionMenu();
    wx.onMenuShareAppMessage.call(this, params);
    wx.onMenuShareTimeline.call(this, params);
});
</script>
</html>