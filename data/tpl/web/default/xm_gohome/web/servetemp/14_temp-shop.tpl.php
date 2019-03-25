<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
    <li><a href="<?php  echo $this->createWebUrl('servetemp', array('foo'=>'index'));?>">服务模型管理</a></li>
    <li><a href="<?php  echo  $this->createWebUrl('servetemp', array('foo'=>'add'));?>">添加服务模型</a></li>
    <li class="active"><a href="<?php  echo $this->createWebUrl('servetemp', array('foo'=>'center'));?>">模型市场</a></li>
</ul>

<style>
.module .thumbnails{padding:0; margin:0 0 0 -15px;}
.module li{position:relative; margin-left:15px; float:left;}
.module-priority{vertical-align:middle; height:30px; line-height:30px;cursor:pointer;}
span.module-priority{cursor:default;}
.module-priority select{vertical-align:middle; width:inherit; margin:0;}
.module-pic{width:100%;min-height:135px; overflow:hidden;position:relative;}
.module-pic > img{display:block; width:100%; height:500px; margin:0 auto;}
.module-pic .official{position:absolute; top:5px; right:5px;}
.module-button{padding:9px 0; height:30px; line-height:30px; box-sizing:content-box;}
.module-button .popover{width:auto;left:auto;top:auto;bottom:0;right:0;margin:0;margin-bottom:55px;line-height:20px;}
.module-button .popover-content {padding:5px 10px; overflow:hidden;}
.module-button .popover .arrow{left:85%;}
.module-button .popover select{width:100%;}
.module-detail{position:absolute;bottom:0;filter:Alpha(opacity=70);background:#000;background:rgba(0, 0, 0, 0.7);width:100%;font-family:arial,宋体b8b\4f53,sans-serif;}
.module-detail p{padding:0 9px; margin:0;}
.module-detail h5{color:#FFF;font-weight:normal;padding:0 9px;}
.module-detail h5 small,.module-detail p{color:#CCC;}
p.module-brief{margin-bottom:10px; font-size:12px;}
p.module-description{display:block;padding:3px 10px;}
</style>
<div class="module">
	<?php  echo $idStr;?>
</div>

<input type="hidden" id="geturl" value="<?php  echo $geturl;?>"  />
<script>
function getInfo(tmpid){
	
	var app      = "<?php  echo $app;?>";
	var weid     = "<?php  echo $weid;?>";
	var key_info = "<?php  echo $key_info;?>";
	var geturl   = $("#geturl").val();
	
	$.ajax({
		url: geturl,
		type:"POST",
		data:{"app":app,"key_info":key_info,"tmpid":tmpid,"weid":weid},
		dataType:"jsonp",
		jsonp:"jsoncallback",
		success: function(res){

			$.ajax({
				url: "<?php  echo $this->createWebUrl('servetemp', array('foo'=>'centerok'));?>",
				type:"POST",
				data:{"temp_name":res.title,"temp_token":res.tmpname,"ex":res.ex,"bodystr":res.bodystr},
				dataType:"json",
				success: function(res1){
					
					if(res1==0){
						alert('该模型已存在！');
					}
					if(res1==1){
						alert('模型下载失败!');
					}
					if(res1==2){
						alert('模型下载成功，请根据实际情况修改参数后使用！');
					}
					if(res1==3){
						alert('与系统模型名称重复，请修改系统的原来模型名称后再来下载！');
					}
				}
			});
		}
	});
}
</script>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
