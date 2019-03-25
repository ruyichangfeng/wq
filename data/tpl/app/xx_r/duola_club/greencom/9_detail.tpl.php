<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php  echo $title;?></title>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width initial-scale=1.0 maximum-scale=1.0 user-scalable=yes" />
<link rel="stylesheet" href="<?php echo MODULE_URL;?>public/mobile/css/weixin.css">
<link rel="stylesheet" href="<?php echo MODULE_URL;?>public/mobile/css/weui.css">
<link type="text/css" rel="stylesheet" href="<?php echo OSSURL;?>public/mobile/css/wxIndexnew.css?v=4.920329" />
<link type="text/css" rel="stylesheet" href="<?php echo OSSURL;?>public/mobile/css/greenStyle.css?v=4.920120" />
<?php  echo register_jssdk();?>
<script src="<?php echo MODULE_URL;?>public/mobile/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo OSSURL;?>public/mobile/js/swipe.js"></script>
<script src="<?php echo OSSURL;?>public/mobile/js/banner.js"></script>
</head>
<body>
<style type="text/css">
.box_swipe {overflow: hidden;position: relative;}
.box_swipe ul {overflow: hidden;position: relative;}
.box_swipe ul > li {float:left;width:100%;position: relative;}
.box_swipe ul > li a{color:#FFF;text-decoration:none;}
.box_swipe ul > li .title{position: absolute;bottom:6px;display: block;width: 70%;height:20px;padding:0 10px;text-overflow: ellipsis;white-space: nowrap;overflow: hidden;z-index:100;font-size: 16px;line-height: 20px;}
.box_swipe>ol{height:20px;position: relative;z-index:10;margin-top:-25px;text-align:right;padding-right:15px;background-color:rgba(0,0,0,0.3);}
.box_swipe>ol>li{display:inline-block;margin-bottom:1px;width:8px;height:8px;background-color:#757575;border-radius: 8px;}
.box_swipe>ol>li.on{background-color:#ffffff;}
.topannounce {background:#000;color: #fff;background-size: 100%;z-index: 9999999;}
.newsList ul li .content{height:70px;margin: 15px 10px 15px 120px;position:relative;}
.newsList ul li .content .t{width: inherit;height:20px;line-height:20px;color:#666666;font-size: 15px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
.newsList ul li .content .b{width:100%;height:40px;line-height:20px;font-size: 10px;overflow:hidden;color:#999999;margin-top:10px;}
#speaker {width: 100%;background-color: #fff;}
#s-word {font-size: 14px;width: 100%;height: 30px;left: 20px;}
#s-word a {color:#000000;text-decoration: none; margin-right:60px;font-size: 14px;}
</style>
<?php  if(!empty($item['gonggao'])) { ?>
	<script type="text/javascript">
        $('#s-fork').click(function(){
            $('#topannounce').hide();
              //$("#players").css("top",0);
             // $(".mui-global-m-smart-banner").css("top",0);
        });
	</script>	
<?php  } ?>
<div class="all">
<?php  if(!empty($banners)) { ?>
<div class="showPic">
  <div id="banner_box" class="box_swipe" style="  max-width: 640px;  margin: 0 auto;  margin-bottom: 0px;">
      <ul id="bheight">
          <?php  if(is_array($barr)) { foreach($barr as $mid => $banner) { ?>
            <li>
                <a href="<?php  if(empty($banner['link'])) { ?>#<?php  } else { ?><?php  echo $banner['link'];?><?php  } ?>"><img src="<?php  echo toimage($banner['thumb'])?>" alt="<?php  echo $banner['bannername'];?>"  width='100%' style="max-height:600px;" />
                </a>
                <span class="title" style="color:#fff;"><?php  echo $banner['bannername'];?></span>
            </li>
          <?php  } } ?>
      </ul>
      <ol>
        <?php  if(is_array($barr)) { foreach($barr as $slideNum => $banner) { ?>
          <li<?php  if($slideNum == 0) { ?> class="on"<?php  } ?>></li>
        <?php  } } ?>
      </ol>
  </div>
</div>
  <?php  } ?>
<div class="btnList" style="border-bottom:none;">
	<ul>
		<li style="float: center; display: block; align: 25%;">
		<?php  if(is_array($icon1)) { foreach($icon1 as $item_2) { ?>
			<div class="btnDiv">
				<a href="<?php  echo $item_2['url'];?>">
					<div class="ico" style="height: 32px;">
						<img alt src="<?php  echo tomedia($item_2['icon'])?>" style="-webkit-touch-callout: none; -webkit-user-select: none;">
					</div>
					<span><?php  echo $item_2['name'];?></span>
				</a>
			</div>
		<?php  } } ?>	
		</li>
	</ul>
</div>
<?php  if(!empty($icon2)) { ?>
<div class="btnList" style="border-bottom:none;">
	<ul>
		<li style="float: center; display: block; align: 25%;">
		<?php  if(is_array($icon2)) { foreach($icon2 as $item_3) { ?>
			<div class="btnDiv">
				<a href="<?php  echo $item_3['url'];?>">
					<div class="ico" style="height: 32px;">
						<img alt src="<?php  echo tomedia($item_3['icon'])?>" style="-webkit-touch-callout: none; -webkit-user-select: none;">
					</div>
					<span><?php  echo $item_3['name'];?></span>
				</a>
			</div>
		<?php  } } ?>	
		</li>
	</ul>
</div>
<?php  } ?>
<div class="line"></div>
	<?php  if($list1) { ?>
	<div class="newsList">
		<div class="top">
			<div class="title">闲书简介</div>
			<div class="more">
				<a href="<?php  echo $this->createMobileUrl('newslist', array('op' => 'article', 'schoolid' => $schoolid), true)?>">更多</a>
			</div>
		</div>
		<ul>
			<?php  if(is_array($list1)) { foreach($list1 as $item1) { ?>
			<a href="<?php  echo $this->createMobileUrl('new', array('schoolid' => $schoolid, 'id' => $item1['id']), true)?>">
				<li>
					<div class="img">
						<img alt src="<?php  echo tomedia($item1['thumb']);?>" style="top: 0px; left: 0px; height: 100%; width: 100%; -webkit-touch-callout: none; -webkit-user-select: none;">
					</div>
					<div class="content">
						<div class="t"><?php  echo $item1['title'];?></div>
						<div class="b"  style="text-overflow:ellipsis;white-space:nowrap;overflow:hidden;width:200px;"><?php  echo $item1['description'];?></div>
						<!--<div class="time"><?php  echo date('m-d', $item1['createtime'])?></div>-->
					</div>
				</li>
			</a>
			<?php  } } ?>
		</ul>
	</div>
	<div class="line"></div>
	<?php  } ?>
	<?php  if($list2) { ?>
	<div class="newsList">
		<div class="top">
			<div class="title">闲书规则</div>
			<div class="more">
				<a href="<?php  echo $this->createMobileUrl('newslist', array('op' => 'news', 'schoolid' => $schoolid), true)?>">更多</a>
			</div>
		</div>
		<ul>
			<?php  if(is_array($list2)) { foreach($list2 as $item_3) { ?>
			<a href="<?php  echo $this->createMobileUrl('new', array('schoolid' => $schoolid, 'id' => $item_3['id']), true)?>">
				<li>
					<div class="img">
						<img alt src="<?php  echo tomedia($item_3['thumb']);?>" style="top: 0px; left: 0px; height: 100%; width: 100%; -webkit-touch-callout: none; -webkit-user-select: none;">
					</div>
					<div class="content">
						<div class="t"><?php  echo $item_3['title'];?></div>
						<div class="b"  style="text-overflow:ellipsis;white-space:nowrap;overflow:hidden;width:200px;"><?php  echo $item_3['description'];?></div>
						<!--<div class="time"><?php  echo date('m-d', $item1['createtime'])?></div>-->
					</div>
				</li>
			</a>
			<?php  } } ?>
		</ul>
	</div>
	<div class="line"></div>
	<?php  } ?>
	<?php  if($list3) { ?>
	<div class="newsList">
		<div class="top">
			<div class="title">闲书指南</div>
			<div class="more">
				<a href="<?php  echo $this->createMobileUrl('newslist', array('op' => 'wenzhang', 'schoolid' => $schoolid), true)?>">更多</a>
			</div>
		</div>
		<ul>
			<?php  if(is_array($list3)) { foreach($list3 as $item_4) { ?>
			<a href="<?php  echo $this->createMobileUrl('new', array('schoolid' => $schoolid, 'id' => $item_4['id']), true)?>">
				<li>
					<div class="img">
						<img alt src="<?php  echo tomedia($item_4['thumb']);?>" style="top: 0px; left: 0px; height: 100%; width: 100%; -webkit-touch-callout: none; -webkit-user-select: none;">
					</div>
					<div class="content">
						<div class="t"><?php  echo $item_4['title'];?></div>
						<div class="b"  style="text-overflow:ellipsis;white-space:nowrap;overflow:hidden;width:200px;"><?php  echo $item_4['description'];?></div>
						<!--<div class="time"><?php  echo date('m-d', $item1['createtime'])?></div>-->
					</div>
				</li>
			</a>
			<?php  } } ?>
		</ul>
	</div>
	<?php  } ?>
	<!--<div class="line" style="padding-bottom:65px;"></div>-->
	<?php  if(count($books) > 0) { ?>
	<div class="page">
		<div class="page__bd">
			<div class="weui-panel weui-panel_access">
				<div class="weui-panel__hd">
					<div id="topannounce" class="topannounce" style="z-index: 0;">
					<div id="speaker">
					<span id="s-word">
						<marquee behavior="scroll" scrollamount="4" direction="left" width="100%">
							<a>
								<?php  echo $item['gonggao'];?>
							</a>
						</marquee>
					</span>
						</div>
					</div>
					<div style="text-align: center;">
						<a style="font-size: 14px;<?php  if($c_lb == 'children') { ?>color:#dd8a37<?php  } ?>" onclick="showLb('children')">附&nbsp近&nbsp儿&nbsp童&nbsp读&nbsp物</a>&nbsp&nbsp&nbsp&nbsp|&nbsp&nbsp&nbsp&nbsp<a onclick="showLb('adult')" style="font-size: 14px;<?php  if($c_lb == 'adult') { ?>color:#dd8a37<?php  } ?>">附&nbsp近&nbsp成&nbsp人&nbsp读&nbsp物</a>
					</div>

				</div>
				<?php  if(is_array($books)) { foreach($books as $item_5) { ?>
					<div class="weui-panel__bd" onclick="showList('<?php  echo $item_5['ownerOpenId'];?>');" style="border-bottom: solid 1px #E5E5E5">
						<a href="javascript:void(0);" class="weui-media-box weui-media-box_appmsg">
							<div class="weui-media-box__hd">
								<img class="weui-media-box__thumb" src="<?php  echo $item_5['book']['images_medium'];?>" alt="">
							</div>
							<div class="weui-media-box__bd">
								<h4 class="weui-media-box__title"><?php  echo $item_5['book']['title'];?></h4>
								<!--<ul class="weui-media-box__info" style="margin-top: 0px;">-->
									<!--<li class="weui-media-box__info__meta"><?php  echo $item_5['book']['author'];?></li>-->
									<!--<li class="weui-media-box__info__meta"><?php  echo $item_5['book']['price'];?>闲书币</li>-->
								<!--</ul>-->
								<p style="text-overflow:ellipsis;white-space:nowrap;overflow:hidden;width:200px;font-size: 14px;"><?php  echo $item_5['book']['author'];?></p>
								<p style="text-overflow:ellipsis;white-space:nowrap;overflow:hidden;width:200px;font-size: 14px;">原价:<?php  echo $item_5['book']['price'];?> &nbsp;&nbsp;<span style="color: #dd8a37">闲书币:<?php  echo $item_5['book']['price'];?></span></p>
							</div>
						</a>
					</div>
				<?php  } } ?>
			</div>
		</div>
	</div>
	<?php  } ?>
<?php  if($list) { ?>
	<?php  if(is_array($list)) { foreach($list as $article) { ?>
	<!--<div class="newsList">-->
		<!--<div class="top">-->
			<!--<div class="title"><?php  echo $article['article']['title'];?></div>-->
			<?php  if(count($article['courses']) > 0) { ?>
			<!--<div class="more">-->
				<!--<a href="<?php  echo $this->createMobileUrl('kc', array('op' => '', 'schoolid' => $schoolid,'lb_id' => $article['article']['cat_id']), true)?>">更多</a>-->
			<!--</div>-->
			<?php  } ?>
		<!--</div>-->
		<!--<ul>-->
		<?php  if(is_array($article['courses'])) { foreach($article['courses'] as $item1) { ?>
			<?php  if($item1['yibao'] < $item1['minge']) { ?>
				<!--<a href="<?php  echo $this->createMobileUrl('kcinfo', array('schoolid' => $schoolid, 'id' => $item1['id']), true)?>">-->
					<!--<li>-->
					<!--<div class="img">-->
					<!--<img alt src="<?php  echo tomedia($item1['thumb']);?>" style="top: 0px; left: 0px; height: 100%; width: 100%; -webkit-touch-callout: none; -webkit-user-select: none;">-->
					<!--</div>-->
					<!--<div class="content">-->
					<!--<div class="t"><?php  echo $item1['name'];?></div>-->
					<!--<div class="label label-warning" style="color: red;padding-top: 10px;"><?php  if($item1['cose'] == '0.00') { ?>免费<?php  } else { ?>￥<?php  echo $item1['cose'];?><?php  } ?></div>-->
					<!--<div class="b"  style="text-overflow:ellipsis;white-space:nowrap;overflow:hidden;width:200px;"><?php  echo $item1['class_describe'];?></div>-->
					<!--&lt;!&ndash;<div class="time"><?php  echo date('m-d', $item1['createtime'])?></div>&ndash;&gt;-->
					<!--</div>-->
				<!--</li>-->
				<!--</a>-->
			<?php  } ?>
		<?php  } } ?>
		<!--</ul>-->
	<!--</div>-->
	<?php  } } ?>
	<!--<div class="line" style="padding-bottom: 1px;"></div>-->
<?php  } ?>
</div>
   <?php  include $this->template('footer');?> 
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=9&c=utility&a=visit&do=showjs&m=duola_club"></script></body>
<script type="text/javascript">
$(function() {

	WeixinJSShowShareMenu();

    WeixinJSShowProfileMenuAndShare();

    wx.ready(function () {
        sharedata = {
            title: '<?php  echo $item['title'];?>',
            desc: '闲书共享|教育技能共享|授课空间共享|家庭教育服务平台',
            link: '<?php  echo $links;?>',
            imgUrl: '<?php  echo $imgsUrl;?>',
            success: function(){

            },
            cancel: function(){

            }
        };
        sharedata1 = {
            title: '<?php  echo $item['title'];?>',
            desc: '闲书共享|教育技能共享|授课空间共享|家庭教育服务平台',
            link: '<?php  echo $links;?>',
            imgUrl: '<?php  echo $imgsUrl;?>',
            success: function(){

            },
            cancel: function(){

            }
        };
        wx.onMenuShareAppMessage(sharedata);
        wx.onMenuShareTimeline(sharedata1);
    });
		
});

function WeixinJSShowShareMenu(){
	if (typeof wx != "undefined"){
		wx.ready(function () {
			wx.showMenuItems({
			    menuList: ['menuItem:share:appMessage','menuItem:share:timeline'] // 要显示的菜单项，所有menu项见附录3
			});
		});
	}
}	


function WeixinJSShowProfileMenuAndShare(){
	
	if (typeof wx != "undefined"){
		wx.ready(function () {
			wx.showMenuItems({
			    menuList: ['menuItem:share:appMessage','menuItem:share:timeline','menuItem:profile','menuItem:addContact','menuItem:favorite'] // 要显示的菜单项，所有menu项见附录3
			});
		});
	}
}
function showList(openid) {
    window.location.href = "<?php  echo $this->createMobileUrl('bookCenter',array('schoolid' => $schoolid))?>"+'&ownerOpenId='+openid;
}
function showLb(lb) {
	window.location.href = "<?php  echo $this->createMobileUrl('detail',array('schoolid' => $schoolid))?>"+'&c_lb='+lb;
}
</script>	
</html>