<?php defined('IN_IA') or exit('Access Denied');?><link rel="stylesheet" href="<?php echo ROOT;?>style/style1/css/001.css?v=<?php echo TIMESTAMP;?>">
<div class="chuchuang_container" >
   <div class="chuchuang_bg"></div>
   <div class="chuchuang_main">
       <h1 class="chuchuang_title"><?php  echo $works['title'];?></h1>
       <div class="chuchuang_meta clearfix">
           <span><?php  echo date('Y-m-d',$works['createtime'])?></span>
           <span><a href="<?php  echo $this->createMobileUrl('myworks',array('mid'=>$mem['id']))?>" class="chuchuang_name"><?php  echo $mem['nickname'];?></a></span>
           <span>阅读：<?php  echo $works['read'];?></span>
           <span class="music" onclick="switchsound()">
               <i play="on" id="music_icon"></i>
               <span id="music_desc"><?php  echo $works['mtitle'];?></span>
           </span>
       </div>
       <div class="chuchuang_content">
		<?php  if(is_array($works['imgs'])) { foreach($works['imgs'] as $k => $item) { ?>
		<div class="section section-border fill">
			<p class="section_text" style="color: <?php  echo $item['color'];?>;font-size: <?php  echo $item['big'];?>;text-align: <?php  echo $item['align'];?>;font-weight: <?php  echo $item['bold'];?>;"><?php  echo $item['content'];?></p>
			<img data-original="<?php  echo $item['img'];?>" class="section_img img-border lazy" src="<?php  echo $item['img'];?>" onclick="preview(<?php  echo $k;?>)">               
		</div>
		<?php  } } ?>
       	<div style="height:2.1rem;width:100%;"></div>
  		</div>
	</div>
	<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('works_footer', TEMPLATE_INCLUDEPATH)) : (include template('works_footer', TEMPLATE_INCLUDEPATH));?>
</div>