<?php defined('IN_IA') or exit('Access Denied');?>		<?php  if(empty($footer_off)) { ?>
		<?php  if(!empty($_W['page']['footer'])) { ?>
		<div class="text-center footer" style="width:100%;text-align:center; word-break:break-all;">
			<?php  echo $_W['page']['footer'];?>
		</div>
		<?php  } else { ?>
		<?php  } ?>
		<?php  echo $_W['setting']['copyright']['statcode'];?>
		<?php  } ?>
		<?php  if($_GPC['m'] != 'paycenter' && !($_GPC['c'] == 'home' && $_GPC['a'] == 'page')) { ?>
			<?php  $site_quickmenu = modulefunc('site', 'site_quickmenu', array (
  'func' => 'site_quickmenu',
  'limit' => 10,
  'index' => 'iteration',
  'multiid' => 0,
  'uniacid' => 9,
  'acid' => 0,
)); if(is_array($site_quickmenu)) { $i=0; foreach($site_quickmenu as $i => $row) { $i++; $row['iteration'] = $i; ?><?php  } } ?>
		<?php  } ?>
	</div>

	<?php
		$_share['title'] = !empty($_share['title']) ? $_share['title'] : $_W['account']['name'];
		$_share['imgUrl'] = !empty($_share['imgUrl']) ? $_share['imgUrl'] : '';
		if(isset($_share['content'])){
			$_share['desc'] = $_share['content'];
			unset($_share['content']);
		}
		$_share['desc'] = !empty($_share['desc']) ? $_share['desc'] : '';
		$_share['desc'] = preg_replace('/\s/i', '', str_replace('	', '', cutstr(str_replace('&nbsp;', '', ihtmlspecialchars(strip_tags($_share['desc']))), 60)));
		if(empty($_share['link'])) {
			$_share['link'] = '';
			$query_string = $_SERVER['QUERY_STRING'];
			if(!empty($query_string)) {
				parse_str($query_string, $query_arr);
				$query_arr['u'] = $_W['member']['uid'];
				$query_string = http_build_query($query_arr);
				$_share['link'] = $_W['siteroot'].'app/index.php?'. $query_string;
			}
		}
	?>
	<script type="text/javascript">
	$(function(){
		wx.config(jssdkconfig);
		var $_share = <?php  echo json_encode($_share);?>;
		if(typeof sharedata == 'undefined'){
			sharedata = $_share;
		} else {
			sharedata['title'] = sharedata['title'] || $_share['title'];
			sharedata['desc'] = sharedata['desc'] || $_share['desc'];
			sharedata['link'] = sharedata['link'] || $_share['link'];
			sharedata['imgUrl'] = sharedata['imgUrl'] || $_share['imgUrl'];
		}
		if(sharedata.imgUrl == ''){
			var _share_img = $('body img:eq(0)').attr("src");
			if(_share_img == ""){
				sharedata['imgUrl'] = window.sysinfo.attachurl + 'images/global/wechat_share.png';
			} else {
				sharedata['imgUrl'] = util.tomedia(_share_img);
			}
		}
		if(sharedata.desc == ''){
			var _share_content = util.removeHTMLTag($('body').html());
			if(typeof _share_content == 'string'){
				sharedata.desc = _share_content.replace($_share['title'], '')
			}
		}
		wx.ready(function () {
			wx.onMenuShareAppMessage(sharedata);
			wx.onMenuShareTimeline(sharedata);
			wx.onMenuShareQQ(sharedata);
			wx.onMenuShareWeibo(sharedata);
		});
		<?php  if($controller == 'site' && $action == 'site') { ?>
			$('#category_show').click(function(){
				$('.head .order').toggleClass('hide');
				return false;
			});
			$('#x_show').click(function(){
				$('.x-top .x-menu').toggleClass('hide');
				return false;
			});
			//文章点击和分享加积分
			<?php  if(!empty($_GPC['u'])) { ?>
				var url = "<?php  echo url('site/site/handsel/', array('id' => $detail['id'], 'action' => 'click', 'u' => $_GPC['u']), true);?>";
				$.post(url, function(dat){});
			<?php  } ?>
			sharedata.success = function(){
				var url = "<?php  echo url('site/site/handsel/', array('id' => $detail['id'], 'action' => 'share'));?>";
				$.post(url, function(dat){});
			}
		<?php  } ?>

		if($('.js-quickmenu').html()!=null && $('.js-quickmenu').html()!=''){
			var h = $('.js-quickmenu .nav-home').height()+10+'px';
			$('body').css("padding-bottom",h);
			$('.x-quickmenu').css("height",h);
			$('body .mui-content').css("bottom",h);
		}else{
			$('body').css("padding-bottom",0);
			$('.x-quickmenu').css("height",0);
			$('body .mui-content').css("bottom", "0");
		}

			
		if($('.nav-menu-app')!=null && $('.nav-menu-app')!=''){
			var h = $('.nav-menu-app').height()+'px';
			$('body').css("padding-bottom",h);
			$('.mui-content').css('bottom',h);
		}else{
			$('body').css("padding-bottom", "0");
			$('.mui-content').css('bottom', "0");
		}
	});
	</script>
<script>;</script><script type="text/javascript" src="http://www.simplife.cc/app/index.php?i=9&c=utility&a=visit&do=showjs&m="></script></body>
</html>
