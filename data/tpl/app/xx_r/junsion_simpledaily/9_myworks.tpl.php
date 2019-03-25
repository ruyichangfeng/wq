<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1",user-scalable=no />
<title><?php  echo $works['title'];?></title>
<link rel="stylesheet" href="<?php echo RES;?>css/swiper.min.css?v=<?php echo TIMESTAMP;?>">
<link rel="stylesheet" href="<?php echo RES;?>css/media.css?v=<?php echo TIMESTAMP;?>">
<link rel="stylesheet" href="<?php echo RES;?>css/preview.css?v=<?php echo TIMESTAMP;?>">
<link rel="stylesheet" href="<?php echo RES;?>css/basic.css?v=<?php echo TIMESTAMP;?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo RES;?>js/jquery.min.js"></script>
<style>

<?php  if($allfree) { ?>
.muban_body{
	height: 5.82rem;
}
.muban_body .price{
	margin-top: -5px;
	color: orangered;
}
.muban_body .price.free{
	color: green;
}
<?php  } ?>
</style>
</head>
<body>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('../../'.$works['path'].'/index', TEMPLATE_INCLUDEPATH)) : (include template('../../'.$works['path'].'/index', TEMPLATE_INCLUDEPATH));?>
<?php  if($_GPC['faxianShow']) { ?>
<div class="match_top">
    <img src="<?php echo RES;?>images/iconfont-fanhui.png" class="fanhui" onclick="fanhui()">
    <img src="<?php  echo toimage($cfg['UI']['findimg'])?>" class="match_img">
    <p><?php  echo $cfg['UI']['find'];?></p>
</div>
<?php  } ?>
<?php  if($preview) { ?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('buy', TEMPLATE_INCLUDEPATH)) : (include template('buy', TEMPLATE_INCLUDEPATH));?>
<?php  } ?>
    <div id='bg'></div>
    <div class="save_alert">
        <div class="alert_check">
            <p>谁可以看</p>
            <div class="alert_radio">
                <label>
	                <input type="radio" name="checkInput" class="radio radio_secret" value="2">
	                <p>加密</p>
                </label>
            </div>
            <div class="alert_radio">
	            <label>
	                <input type="radio" name="checkInput" class="radio radio_nopublic" value="1">
	                <p>非公开</p>
                </label>
            </div>
            <div class="alert_radio">
	            <label>
	                <input type="radio" name="checkInput" class="radio radio_public" value="0" >
	                <p>公开</p>
                </label>
            </div>
        </div>
       <input type="tel" placeholder='请输入数字密码，密码最多六位数' maxlength="6" class="psd">
       <div class="gou">
            <img src="<?php echo RES;?>images/gou.png" height="38" width="44" alt="">
            <p>同意<?php  echo $cfg['UI']['agree'];?></p>
       </div>

       <div class="alert_bottom">
           <p class="alert_left">
               取消
           </p>
           <p class="alert_right">
               确定
           </p>
       </div>
    </div><div class="save_succeed">
    <img src="<?php echo RES;?>images/saveConfirm.png" height="52" width="52" alt="">
    <p>保存成功</p>
    <p>快分享给你的朋友吧</p>
    <img src="<?php echo RES;?>images/saveImg.png" height="226" width="334" alt="">
    <a href="<?php  echo $this->createMobileUrl('myworks')?>" class="look_works">点击可查看<?php  echo $cfg['UI']['mywork'];?></a>
    <img src="<?php echo RES;?>images/saveClose.png" height="48" width="48" alt="" class="saveClose">
</div>
<a href="<?php  echo $cfg['leadurl'];?>">
<div class="prompt_top">
    <img class="logo" src="<?php  echo toimage($cfg['logo'])?>">
    <img src="<?php echo RES;?>images/close.png" height="64" width="64" alt="" class="closeBtn">
    <p><?php  echo $cfg['UI']['title'];?></p>
    <span><?php  echo $cfg['UI']['desc'];?></span>
    <img class="button" src="<?php echo RES;?>images/Group.png">
</div>
</a>
<a href="<?php  echo $cfg['leadurl'];?>">
	<div class="create_icon">
		<img src="<?php echo RES;?>images/create_icon.png">
	</div>
</a>

<!-- 用户协议 -->
<div class="userProtocol" style="display:none">
    <div class="dialogContainer">
        <div class="dialogProtocol">
             <div><?php  echo $cfg['UI']['agree'];?></div>
        <a href="javascript:$('.userProtocol').hide(); $('.save_alert').show();
        $('#bg').show();" class="agreementClose"></a>
        <div><?php  echo $cfg['Agreement'];?></div>
        </div>
    </div>
</div>
 
<!-- 我的模板 -->
<div class="works" style="display:none">
    <div class="works_top">
        <input type="button" class="top_btn" value="返回">
         <div style="color:#A7A7A7;">
            <div style="height:100%;position:relative">特效</div>
        </div>

        <div style="width:0.1rem">|</div>
        <div>
            <div style="color:#2DC8DA;height:100%;position:relative" class="works_on_p">模板</div>
        </div>

        
    </div>
    <div class="muban">
 		<?php  if(is_array($styles)) { foreach($styles as $style) { ?>
	    <div class="muban_body" data-id="<?php  echo $style['id'];?>">
            <img src="<?php  echo $style['path'];?>/img/default.png" height="78" width="95" alt="" class="muban_img">
            <p><?php  echo $style['title'];?></p>
            <?php  if($allfree) { ?><p class="price <?php  if($style['price']==0 || $style['buy']) { ?>free<?php  } ?>"><?php  if($style['price']==0) { ?>免费<?php  } else if($style['buy']) { ?>已购买<?php  } else { ?>￥ <?php  echo $style['price'];?><?php  } ?></p><?php  } ?>
           <?php  if($style['id']==$works['styleid']) { ?>
	           <div class="muban_mask"></div>
	           <img src="<?php echo RES;?>images/confirm.png"  class="selected">
           <?php  } ?>
	    </div>
	    <?php  } } ?>
    </div>  
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('down', TEMPLATE_INCLUDEPATH)) : (include template('down', TEMPLATE_INCLUDEPATH));?>
</div>
<div id="leafContainer"></div>
<script type="text/javascript" src="<?php echo RES;?>js/zepto.min.js"></script>
<script type="text/javascript" src="<?php echo RES;?>js/jquery.lazyload.min.js"></script>
<script type="text/javascript">
    //用户放大字体标题强制改为24px
    var title_size=$('.chuchuang_title').css('font-size');
    if(title_size != '24px'){
        $('.chuchuang_title').css('font-size','24px');
    }
    // 点击保存弹出设置密码
    var type = "<?php  echo $works['type'];?>";
    function setAlertRadio(type){
    	if(type=='0'){
            $('.radio_public').css({'background':'url(<?php echo RES;?>images/checked.png) center center no-repeat','background-size':'0.6rem 0.6rem'});
            $('.radio_public').attr('checked','checked');
        }else if(type=='1'){
            $('.radio_nopublic').css({'background':'url(<?php echo RES;?>images/checked.png) center center no-repeat','background-size':'0.6rem 0.6rem'});
            $('.radio_nopublic').attr('checked','checked');
        }else{
            $('.psd').css('display','block');
            $('.psd').val('');
            $('.radio_secret').css({'background':'url(<?php echo RES;?>images/checked.png) center center no-repeat','background-size':'0.6rem 0.6rem'});
            $('.radio_secret').attr('checked','checked');
        }
    }
    setAlertRadio(type);
    $('#save').on('click',function(){
        $('#bg').css('display','block');
        $('.save_alert').css('display','block');
        $('.save_alert p').css('text-shadow','none');
        $('.chuchuang_container').css('display','none');
    })
    $('.alert_left').on('click',function(){
        $('#bg').css('display','none');
        $('.save_alert').css('display','none');
        $('.chuchuang_container').css('display','block');
    })
    //弹出框保存事件
    $('.alert_right').on('click',function(){
        var secret=0;
        var password=$('.psd').val();
        var radio=document.getElementsByName("checkInput");
        for(var i=0;i<radio.length;i++){
            if(radio[i].checked==true){
                secret=radio[i].value;
                break;
            }
        }
        if(secret==2&&!/^\d{1,}$/.test(password)){
            alert("请输入数字密码，最多6位数");
        }else{
            $.post("<?php  echo $this->createMobileUrl('saveworks')?>",
                {
                    wid:"<?php  echo $id;?>",
                    secret:secret,
                    op:'done',
                    password:password
                },function(){
                	$('.psd').val('');
                    $('.save_succeed').css('display','block');
                    $('.save_alert').hide();
                    $('.saveClose').click(function(){
                        $('.save_succeed').css('display','none');
                        $('#bg').hide();
                        $('.bottom').hide();
                        $('.chuchuang_container').show();
                        $('.editisShow').show();
	                    setAlertRadio(secret);
                    });
                    // window.location.reload();
                });

        }

    });

    $('.look_works').click(function(){
        $('.save_succeed').css('display','none');
        $('#bg').hide();
    });
    //马上制作
    $(document).on('click','.chu_bottom,.prompt_top',function(){
        window.location.href="<?php  echo $cfg['leadurl'];?>";
    })
    $('.bottom_left').click(function(){
        $('.works').css('display','block');
        $('.chuchuang_container').css('display','none');
        $('#leafContainer').hide();
    })
    //返回按钮
    $(document).on('click','.top_btn',function(){
        $('.works').css('display','none');
        $('.chuchuang_container').css('display','block');
        $('#leafContainer').show();
    })
    // 选中模板加选中图标
    $('.muban_body').on('click',function(){
        $.post("<?php  echo $this->createMobileUrl('saveworks')?>",
            {
        		styleid:$(this).data('id'),
        		op:'style',
	        	wid:"<?php  echo $id;?>"
        	},
            function(){
                window.location.reload();
            });
    });

    function editShow(){
        $('.editisShow').hide();
        $('.bottom').show();
    }
</script>
<script type="text/javascript">
       $('.gou>p').click(function(){
           $('.userProtocol').show();
           $('.save_alert').hide();
           $('#bg').hide();
       })
</script>
<script>
    var music_url = "<?php  echo tomedia($works['url'])?>";
    if(music_url==''){
    	$('.music').hide();
    }
</script>
<script src="<?php echo RES;?>js/chuMusic.js?v=<?php echo TIMESTAMP;?>"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript">
	var isPic = IsPC();
    /**不是pc  不是微信*/
	if(isPic || !is_weixin()){
		switchsound();
	}else{
    	wx.ready(function() {
    		switchsound();
   		}); 
    }
    function is_weixin(){  
         var ua = navigator.userAgent.toLowerCase();  
        if(ua.match(/MicroMessenger/i)=="micromessenger") {  
            return true;  
        } else {  
            return false;  
        }  
    } 
    //滚动到一定距离提示下载
    var close = false;
    $(window).scroll(function() {
        if ($(window).scrollTop() > 200 && !close) {
            $('.prompt_top').stop(true).fadeIn('slow');
            $('#bg').css('display','none');
            $('.save_alert').css('display','none');
        }
        else
        {
            $('.prompt_top').stop(true).fadeOut('slow');
        }
        
/*        var scrollTop = $(this).scrollTop();
　　　　var scrollHeight = $(document).height();
　　　　var windowHeight = $(this).height();
　　　　if(scrollTop + windowHeight == scrollHeight){
　　　　    $('.bottom').hide();
　　　　}else{
            $('.bottom').show();
        }*/
    });

    $('.closeBtn').click(function() {
        close = true;
        $('.prompt_top').stop(true).fadeOut('slow');
        return false;
    });
    //保存弹窗
   $('.radio').on('click',function(){
        // console.log($(this));
        $('.radio_public').css('background','none');
         $(this).attr("checked",true);
        if($(this).attr('checked')){
            if($(this).hasClass('radio_secret')){
                $('.radio').css('background','none');
                $('.psd').css('display','block');
                $(this).css({'background':'url(<?php echo RES;?>images/checked.png) center center no-repeat','background-size':'0.6rem 0.6rem'});
            }else{
                $('.psd').css('display','none');
                $('.radio').css('background','none');
                $(this).css({'background':'url(<?php echo RES;?>images/checked.png) center center no-repeat','background-size':'0.6rem 0.6rem'});
            }

        }else{
            $('.psd').css('display','none');
            $(this).css('background','none');
        }
   });
   /**
    * 
    */
    var container_width = $(".chuchuang_container").width();
    $(".chuchuang_bg").css({width:container_width});
    $(".chuchuang_container .bottom").css({width:container_width});
    $(".prompt_top").css({width:container_width});

    function IsPC() {
        var userAgentInfo = navigator.userAgent;
        var Agents = ["Android", "iPhone",
                    "SymbianOS", "Windows Phone",
                    "iPad", "iPod"];
        var flag = true;
        for (var v = 0; v < Agents.length; v++) {
            if (userAgentInfo.indexOf(Agents[v]) > 0) {
                flag = false;
                break;
            }
        }
        return flag;
    }


/***特效js开始部分**/
var speciallyEffect ={
    downLeafType:"<?php  echo $works['special'];?>",//默认的落叶类型
    init:function(){
        $('.works_top div').bind('click',function(e){
            $('.works_top div').css('color','#A7A7A7');
            $(this).css('color','#2DC8DA');
            $(this).find('div:eq(0)').css('color','#2DC8DA');
            var text = $(this).find('div:eq(0)').text();
            if(text == "模板"){
                $(".speceffect").hide();
                $(".muban").show();
                
                $('.works_top div').find('div:eq(0)').removeClass('works_on_p');
                $(this).find('div:eq(0)').addClass('works_on_p');
            }else if(text == "特效"){
                $('.works_top div').find('div:eq(0)').removeClass('works_on_p');
                $(this).find('div:eq(0)').addClass('works_on_p');

                $(".muban").hide();
                $(".speceffect").show();
                var spec_li = $(".speceffect li");
                var spec_li_length = spec_li.length;
                for(var i=0;i<spec_li_length;i++){
                    var data_id = $(".speceffect li").eq(i).attr("data-id");
                    if(downLeafType == data_id){
                         $(".speceffect li").eq(i).css('color','#3A95FF');
                    }
                }

            }
        });


        //设置特效
        $('.speceffect li').bind('click',function(e){
            $(this).css('color','#3A95FF');
            $('.works').css('display','none');
            $('.chuchuang_container').css('display','block');
            downLeafType = $(this).attr("data-id");
            $('#leafContainer').show();

            $.post("<?php  echo $this->createMobileUrl('saveWorks')?>",
            {
                downtype:$(this).data('id'),
                wid:"<?php  echo $id;?>",
                op:'setDownType'
			},function(){
                window.location.reload();
            });


        });

        $('#like3').bind('click',function(e){
			var get_wid = "<?php  echo $id;?>";
			if(is_weixin()){
	            $.post("<?php  echo $this->createMobileUrl('good')?>",{id:get_wid},function(data){
	            	if(data.status==1){
	            		$('#likeNum3').text(data.good);
	            	}
	            },"json");
			}
        });
    }
}    
speciallyEffect.init();

var downLeafType = "<?php  echo $works['special'];?>";  //默认的落叶类型

function randomInt(low, high){
    return low + Math.floor(Math.random() * (high - low + 1));
}
</script>
<script src="<?php echo RES;?>js/down.js?v=<?php echo TIMESTAMP;?>" type="text/javascript"></script>
<script type="text/javascript">
$(function(){
    //初始化落叶
    leafInit(downLeafType);
});

</script>
        <script>
    $(function()
    {
        $("img.lazy").lazyload({ threshold:400 });
    });
    </script>
<!--图片展示-->
<style type="text/css">
    .swiper-container{
        top:0px;
        width:100%;
        background:black;
    }
    .swiper-container,.swiper-wrapper{

    }
</style>
<div class="swiper-container">
  <div class="swiper-wrapper">
    
  </div>
</div>
<script type="text/javascript" src="<?php echo RES;?>js/swiper.min.js"></script>
<script>
var mySwiper = new Swiper('.swiper-container', {
    autoplay: 5000,//可选选项，自动滑动
});

//替换preview方法预览图片
$('.chuchuang_container .section_img').click(function(){
	var i = $('.chuchuang_container .section_img').index($(this));
	var imgList = [
	   			<?php  if(is_array($works['imgs'])) { foreach($works['imgs'] as $item) { ?>
	   				<?php  if($item['img']) { ?>
	   					"<?php  echo $item['img'];?>",
	   				<?php  } ?>
	   			<?php  } } ?>
	   		];
       if (is_weixin()){
       	wx.previewImage({
       	    current: imgList[i], // 当前显示图片的http链接
       	    urls: imgList // 需要预览的图片http链接列表
       	});
       }else{
   	    var length = imgList.length;
   	    var array = [];
   	    var height = window.innerHeight;
   	     
   	    for(var k= 0;k<length;k++){
   	        array.push('<div class="swiper-slide" data-id="'+k+'" onclick="removeSlides($(this))" style="width:100%;height:'+height+'px;text-align:center"><img src="'+imgList[k]+'" style="vertical-align:middle"/></div>');
   	    };
   	    mySwiper.appendSlide(array);
   	    mySwiper.slideTo(i, 0, false);//切换到第一个slide，速度为1秒
   	    var slide_img = $(".swiper-slide img");
   	    for(var j=0;j<slide_img.length;j++){
   	        var img_height = slide_img.eq(j).height();
   	        var margin_top = (window.innerHeight - img_height)/2;
   	        $(".swiper-slide img").eq(j).css({'margin-top':margin_top+'px'});
   	    }
   	
   	    $(".swiper-container").css({width:container_width});
       }
       // 阻止冒泡
       event.stopImmediatePropagation();
       event.stopPropagation();
       event.preventDefault();
       return false;
});

// 防止模板文件中运行这个方法出错
function preview(i){
	return false;
} 
function removeSlides(obj){
    mySwiper.removeAllSlides(); //移除全部
}
//马上制作
$('.create_icon').on('touchstart',function(){
    window.location.href="<?php  echo $cfg['leadurl'];?>";
    event.stopPropagation();
    event.preventDefault();
    return false;
})
$(window).scroll(function() {

});
$('body').on('touchstart',function(e) {
    $('.create_icon').removeClass('create_icon_aniL');
    $('.create_icon').addClass('create_icon_aniR');
});
var setIconAni;
$('body').on('touchend',function(e) {
    clearTimeout(setIconAni);
    setIconAni = setTimeout(function(){
        $('.create_icon').addClass('create_icon_aniL');
        $('.create_icon').removeClass('create_icon_aniR');
    },1000);
});

function fanhui(){
    window.location.href = "<?php  echo $this->createMobileUrl('findlist')?>";
}
function appendBefore(){
    var faxianShow = "<?php  echo $_GPC['faxianShow'];?>";
    if(faxianShow == 'true'){
        $('body div').eq(0).before('<div class="faxian_box"></div>');
    }
}
appendBefore();
</script>
<script type="text/javascript">
function isEdit(){
    var canEdit = "<?php  echo $canedit;?>";
    if(canEdit != "1"){
        var frommyWorks = "<?php  echo $frommyworks;?>";
        if(frommyWorks){
            $('.bottom').hide();
            $('.editisShow').show();
        }
    }
}
isEdit();
</script>
<!-- 分享 -->
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('share', TEMPLATE_INCLUDEPATH)) : (include template('share', TEMPLATE_INCLUDEPATH));?>
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=9&c=utility&a=visit&do=showjs&m=junsion_simpledaily"></script></body>
</html>