<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('inc/header', TEMPLATE_INCLUDEPATH)) : (include template('inc/header', TEMPLATE_INCLUDEPATH));?>
<script type="text/javascript">
$(function(){
	var wxx = <?php echo WEIXIN;?>;
	if(wxx==1){
		
		wx.ready(function() {

		   wx.getLocation({

		        type: 'wgs84',// 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
		        success: function (res) {
		            var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
		            var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
		            if(latitude&&longitude){
			            $.ajax({
			            	type: 'POST',
				    		url: "<?php  echo $_W['siteroot'].'app/'.substr($this->createMobileUrl('getlalo'),2)?>"+"&rad="+Math.random(),
					    	data: {latitude:latitude,longitude:longitude},
					    	success:function(datas){
					    		if(datas.statue==1){
					    			window.location.href="<?php  echo $_W['siteroot'].'app/'.substr($this->createMobileUrl('showindex'),2)?>";
					    		}
					    	},
					    	error:function(datas){
					    		window.location.href="<?php  echo $_W['siteroot'].'app/'.substr($this->createMobileUrl('showindex',array('sta'=>2)),2)?>";
						    },
					    	dataType:'json',
			            })
			        }else{
			        	window.location.href="<?php  echo $_W['siteroot'].'app/'.substr($this->createMobileUrl('showindex',array('sta'=>2)),2)?>";
			        }
		     },
		     error: function(res){
		     	swal({
                        title: "定位获取失败",
                        text: res.errmsg,
                        html: true,
                        timer: 2000,
                        showConfirmButton: false
                    },function(){
                    	window.location.href="<?php  echo $_W['siteroot'].'app/'.substr($this->createMobileUrl('showindex',array('sta'=>2)),2)?>";
                    });
		     	
		     }
	    });
	 });
	
	}else{
		window.location.href="<?php  echo $_W['siteroot'].'app/'.substr($this->createMobileUrl('showindex',array('sta'=>2)),2)?>";
	}
})
</script>