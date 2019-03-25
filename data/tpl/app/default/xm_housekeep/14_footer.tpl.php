<?php defined('IN_IA') or exit('Access Denied');?><div id="footer" class="fix0 c-s403" style="width:100%; bottom:0;">
		<div class="ub">
            <a href ="<?php  echo $this->createMobileUrl('xmCover',array('name'=>'xm_housekeep'));?>" class="ub ub-pc block <?php  if($from == 'index') { ?> c-s402 t-wh <?php  } ?>;" style="width:25%">
                <div class="ub ub-ver ub-ac ub-pc">
                    <i class="iconfont icon-sort ulev1 <?php  if($from == 'index') { ?> t-wh <?php  } ?>"></i> 
                    <span class="block ulev-1 <?php  if($from == 'index') { ?> t-wh <?php  } ?>" style="">服务项目</span>
                </div>
            </a>
            <a href ="<?php  echo $this->createMobileUrl('Usercenter',array('name'=>'xm_housekeep'));?>" class="ub ub-pc block <?php  if($from == 'user') { ?> c-s402 t-wh <?php  } ?>" style="width:25%">
                <div class="ub ub-ver ub-ac ub-pc">
                    <i class="iconfont icon-nan ulev1 <?php  if($from == 'user') { ?> t-wh <?php  } ?>"></i> 
                    <span class="block ulev-1 <?php  if($from == 'user') { ?> t-wh <?php  } ?>" style="">会员中心</span>
                </div>
            </a>
            <a href ="<?php  echo $this->createMobileUrl('Question',array('name'=>'xm_housekeep'));?>" class="ub ub-pc block <?php  if($from == 'question') { ?> c-s402 t-wh <?php  } ?>;" style="width:25%">
                <div class="ub ub-ver ub-ac ub-pc">
                    <i class="iconfont icon-pinglun ulev1 <?php  if($from == 'question') { ?> t-wh <?php  } ?>"></i> 
                    <span class="block ulev-1 <?php  if($from == 'question') { ?> t-wh <?php  } ?>" style="">常见问题</span>
                </div>
            </a>
            <a href="<?php  echo $this->createMobileUrl('Service',array('name'=>'xm_housekeep'));?>" class="ub ub-pc block <?php  if($from == 'service') { ?> c-s402 t-wh <?php  } ?>;" style="width:25%">
                <div class="ub ub-ver ub-ac ub-pc">
                    <i class="iconfont icon-news ulev1 <?php  if($from == 'service') { ?> t-wh <?php  } ?>"></i> 
                    <span class="block ulev-1 <?php  if($from == 'service') { ?> t-wh <?php  } ?>" style="">服务说明</span>
                </div>
            </a>
        </div>
		
</div>
	
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	
<script type="text/javascript">
	//分享
	jssdkconfig = <?php  echo json_encode($_W['account']['jssdkconfig']);?> || {};

	// 是否启用调试
	jssdkconfig.debug = false;
	
	jssdkconfig.jsApiList = [
		'checkJsApi',
		'onMenuShareTimeline',
		'onMenuShareAppMessage',
		'onMenuShareQQ',
		'onMenuShareWeibo',
	];
	
	wx.config(jssdkconfig);
	
	wx.ready(function () {
		// 2.1 监听“分享给朋友”，按钮点击、自定义分享内容及分享结果接口
        wx.onMenuShareAppMessage({
            title: '<?php  echo $base['share_title'];?>',
            desc: '<?php  echo $base['share_content'];?>',
            link: '<?php  echo $base['link'];?>',
            imgUrl: '<?php  echo $_W['attachurl'];?><?php  echo $base['share_icon'];?>',
            trigger: function (res) {

            },
            success: function (res) {
                /*$.ajax({
					url: "<?php  echo $this->createMobileUrl('addshare', array());?>",
					type:"POST",
					data:"",
					dataType:"json",
					success: function(json){
						//alert(json);
					}
				});	*/
            },
            cancel: function (res) {

            },
            fail: function (res) {

            }
        });
		
		// 2.2 监听“分享到朋友圈”按钮点击、自定义分享内容及分享结果接口
		wx.onMenuShareTimeline({
            title: '<?php  echo $base['share_title'];?>',
            desc: '<?php  echo $base['share_content'];?>',
            link: '<?php  echo $base['link'];?>',
            imgUrl: '<?php  echo $_W['attachurl'];?><?php  echo $base['share_icon'];?>',
            trigger: function (res) {

            },
            success: function (res) {
				/*$.ajax({
					url: "<?php  echo $this->createMobileUrl('addshare', array());?>",
					type:"POST",
					data:"",
					dataType:"json",
					success: function(json){
						//alert(json);
					}
				});*/
            },
            cancel: function (res) {

            },
            fail: function (res) {
				alert('失败');
            }
        });
		
		//分享到QQ
		wx.onMenuShareQQ({
            title: '<?php  echo $base['share_title'];?>',
            desc: '<?php  echo $base['share_content'];?>',
            link: '<?php  echo $base['link'];?>',
            imgUrl: '<?php  echo $_W['attachurl'];?><?php  echo $base['share_icon'];?>',
            trigger: function (res) {

            },
            complete: function (res) {

            },
            success: function (res) {
                /*$.ajax({
					url: "<?php  echo $this->createMobileUrl('addshare', array());?>",
					type:"POST",
					data:"",
					dataType:"json",
					success: function(json){
						//alert(json);
					}
				});*/
            },
            cancel: function (res) {

            },
            fail: function (res) {

            }
        });
		
		//分享到微博
        wx.onMenuShareWeibo({
            title: '<?php  echo $base['share_title'];?>',
            desc: '<?php  echo $base['share_content'];?>',
            link: '<?php  echo $base['link'];?>',
            imgUrl: '<?php  echo $_W['attachurl'];?><?php  echo $base['share_icon'];?>',
            trigger: function (res) {

            },
            complete: function (res) {

            },
            success: function (res) {
                /*$.ajax({
					url: "<?php  echo $this->createMobileUrl('addshare', array());?>",
					type:"POST",
					data:"",
					dataType:"json",
					success: function(json){
						//alert(json);
					}
				});*/
            },
            cancel: function (res) {

            },
            fail: function (res) {

            }
        });

	});
</script>