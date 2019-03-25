<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header-jw', TEMPLATE_INCLUDEPATH)) : (include template('header-jw', TEMPLATE_INCLUDEPATH));?>
<style>
body{font-family:"微软雅黑";font-size:16px; background:#efefef;}
/*头部*/
.my-title{ width:100%; height:48px; background:#F8f8f8; border-bottom:1px solid #eee; line-height:48px;; position:relative;}
.title_tx{ max-width:640px; min-width:320px; margin:0 auto; text-align:center; display:block; font-size:16px;}
.topback a{ display:block; width:48px; height:48px; position:absolute; top:0; left:0;}
.topback i{ display:block; width:14px; height:30px;background-image:url(<?php  echo MODULE_URL?>images/arrow_left_b.png); background-position:50% 50%; background-repeat:no-repeat; opacity:0.5; background-size:90%; position:absolute;left:18px; top:9px;}
.topback a i{ margin:0; opacity:0.5;}
.topback a:hover{ background:#fff; border-radius:100%;}
/*头部*/
/*list*/
.mui-table-view {position: relative;padding-left: 0;margin-top: 15px;margin-bottom: 0;list-style: none;background-color: #fff;}
.mui-table-view-cell {position: relative;padding: 11px 15px;overflow: hidden;border-bottom: 1px solid #ddd;}
.mui-table-view-cell .mui-btn{position: relative;display: block;padding: inherit;margin: -11px -15px;overflow: hidden;color: inherit;white-space: nowrap;}
.mui-table-view-cell .mui-ellipsis-2{float: left;}
.mui-table-view-cell .mui-text-right{float: right;display: block;}
.mui-table-view-cell .point{color: #04be02; text-align:right;display: block;font-size:18px;}
.mui-table-view-cell .point i{font-size:12px;color:#999;}
.mui-table-view-cell .mui-block{display: block;}
.hoso_no{overflow:hidden;border-bottom: 1px solid #ddd; padding: 15px;padding-bottom:10px; background:#fff;}
.hoso_no img{ display:block; width:40px; height:40px; border-radius:100%; float:left;}
.hoso_no .hoso_nickname{height:40px;line-height: 40px;padding-left:60px; color:#888; font-size:1.1em;}
</style>

<div class="my-title">
    <div class="title_tx">
          <div class="topback"><a href="<?php  echo url('mc/home');?>"><i class="img_bg"></i></a></div>
          <div class="posit_tx">赠送记录</div>
    </div>
</div>
<div class="credits-display">
	<div class="hoso_no">
		<img src="<?php  echo $_W['fans']['avatar'];?>" />
		<div class="hoso_nickname">
			<p>当前积分：<span><?php  echo $credits['credit1'];?>，余额：<?php  echo $credits['credit2'];?></p>
		</div>
	</div>
	<ul class="mui-table-view mui-credits" id="list">
    <?php  if(is_array($list)) { foreach($list as $index => $item) { ?>
			<li class="mui-table-view-cell">
					<div class="mui-row">
						<div class="mui-ellipsis-2"><?php  echo $item['tp_cn'];?><?php  echo $item['yue'];?></div>
						<div class="mui-text-right">
							<span class="point">+<?php  echo $item['point'];?></span>
							<span class="mui-block mui-text-muted mui-small"><?php  echo $item['addtime2'];?></span>
						</div>
					</div>
			</li>
         <?php  } } ?>
	</ul>
    <?php  if($total>$psize) { ?>
	<div class="weui-infinite-scroll">
		  <div class="infinite-preloader"></div>
		  正在加载
	</div>
    <?php  } ?>
</div>

<?php  if($total>0) { ?>
<script type="text/javascript">
	var loading = false;
	var total = <?php  echo $total;?>;
	var pageNum = 1;
	var pageSize = <?php  echo $psize;?>;
	var tpl = '<li class="mui-table-view-cell">'+
				'<div class="mui-row">'+
					'<div class="mui-ellipsis-2">{tp_cn}{yue}</div>'+
					'<div class="mui-text-right">'+
						'<span class="point">+{point}</span>'+
						'<span class="mui-block mui-text-muted mui-small">{addtime2}</span>'+
					'</div>'+
				'</div>'+
			'</li>';
	
	$(document.body).infinite().on("infinite", function() {
		if(loading) return;
        loading = true;
        setTimeout(load_data, 2000);
	});
	
	function load_data(){
		pageNum++;
		args = {'total':total,'page':pageNum,'psize':pageSize};
		$.ajax({
			type:'post',
			url:"<?php  echo $this->createMobileUrl('index')?>",
			data:args,
			dataType:'json',
			//jsonp:'callback',
			success:function(result){
				if(result.status!=1) return;
				if(pageNum*pageSize>=total){
					$('.weui-infinite-scroll').hide();	
				}
				var list = result.data;
				sz = list.length;
				if(!sz) return;	
				loading = false;
				var html = '';
				for(var i=0;i<sz;i++){
					row = list[i];
					line = tpl;
					line = line.replace('{tp_cn}', row.tp_cn);
					line = line.replace('{yue}', row.yue);
					line = line.replace('{point}', row.point);	
					line = line.replace('{addtime2}', row.addtime2);				
					html += line;
				}
				$('#list').append(html);
			}
		});
	}
</script>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>