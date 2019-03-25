<?php defined('IN_IA') or exit('Access Denied');?>    <div class="m-footer">
        <div class="foot">
            <P>目前有<span class="col-red"><?php  echo $total;?></span>位选手参与</P>
            <P>本次活动截止目前共计<span class="col-red"><?php  echo $activity['viewnums'];?></span>访问人次</P>
        </div>
    </div> 
    <div class="m-copyright">
         <?php  if($activity['tongji']!='') { ?><?php  echo $activity['tongji'];?><?php  } ?>
        <P></P>
    </div>  
</div>
<!--页面框架结束--> 
<script type="text/javascript">
var i=0;
$(function(){
	if (/(iPhone|iPad|iPod|iOS)/i.test(navigator.userAgent)) {
			$(".m-center *[style]").each(function(){ 
			      var font_size = $(this).css("font-size");
			      font_size = parseFloat(font_size.replace('px',''));
			      var rem = (font_size/100).toFixed(2)+"rem";
			      $(this).css("font-size",rem);
		  }) 
	} 
})
document.querySelector('body').addEventListener('touchmove', function(e) {
	if (!document.querySelector('.g-main').contains(e.target)) { e.preventDefault();
    }
})
		wx.ready(function(){
				 wx.onMenuShareTimeline({
				        title: '<?php  echo $share_title;?>',
				        link: '<?php  echo $share_url;?>', 
				        imgUrl: '<?php  echo $share_logo;?>', 
				        success: function () {  },
				        cancel: function () {   }
				 });
				 wx.onMenuShareAppMessage({ 
				        desc: '<?php  echo $share_desc;?>',
				        title: '<?php  echo $share_title;?>',
				        link: '<?php  echo $share_url;?>', 
				        imgUrl: '<?php  echo $share_logo;?>', 
				        type: 'link',
				        dataUrl: '',
				        success: function () {   },
				        cancel: function () {   }
				    });
				 
				   wx.hideMenuItems({
					    menuList: ["menuItem:exposeArticle","menuItem:originPage"] // 要隐藏的菜单项，只能隐藏“传播类”和“保护类”按钮，所有menu项见附录3
					});
		}); 
</script> 
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=9&c=utility&a=visit&do=showjs&m=numa_vote"></script></body>
</html>