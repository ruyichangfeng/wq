<?php defined('IN_IA') or exit('Access Denied');?><style type="text/css">
	.topDiv{
		width: 20%;
		text-align: right;
		position: fixed;
		z-index: 10;
		right: 15px;
	}
	.topDiv-btn{
		width: 150px;
		height: 40px;
		display: inline-block;
		font-size: 1.2em;
		line-height: 40px;
		color: #fff;
		text-align: center;
		cursor: pointer;
		border-radius: 5px;
		font-weight: bolder;
		background-color: #89cd97;
	}
	.topDiv-all{
		width: 150px;
		position: absolute;
		right: 0;
		top: 40px;
		display: none;
	}
	.topDiv-content{
		width: 100%;
		height: 50px;
		font-size: 1.2em;
		line-height: 50px;
		color: #666;
		text-align: center;
		cursor: pointer;
		background-color: #f5f5f5;
		border-bottom: 1px solid #ccc;
		border-left: 1px solid #ccc;
		border-right: 1px solid #ccc;
	}
	.topDiv-content:hover{
		background-color: #4cc1c1;
		color: #fff;
		font-weight: bolder;
	}
</style>
<div class="topDiv">
	<span class="topDiv-btn" data-open="0">快速导航</span>
	<div class="topDiv-all">
		<a href="<?php  echo $this->CreateWebUrl('setting')?>"><div class="topDiv-content">基本设置</div></a>
		<a href="<?php  echo $this->CreateWebUrl('url')?>"><div class="topDiv-content">推广设置</div></a>
		<a href="<?php  echo $this->CreateWebUrl('mendian')?>"><div class="topDiv-content">商家管理</div></a>
		<a href="<?php  echo $this->CreateWebUrl('dianyuan')?>"><div class="topDiv-content">店员管理</div></a>
		<a href="<?php  echo $this->CreateWebUrl('cate')?>"><div class="topDiv-content">分类管理</div></a>
		<a href="<?php  echo $this->CreateWebUrl('huodong')?>"><div class="topDiv-content">活动管理</div></a>
		<a href="<?php  echo $this->CreateWebUrl('pl')?>"><div class="topDiv-content">活动评论管理</div></a>
		<a href="<?php  echo $this->CreateWebUrl('baoming')?>"><div class="topDiv-content">活动参与管理</div></a>
		<a href="<?php  echo $this->CreateWebUrl('success')?>"><div class="topDiv-content">成功报名管理</div></a>
		<a href="<?php  echo $this->CreateWebUrl('hexiao')?>"><div class="topDiv-content">核销管理</div></a>
		<a href="<?php  echo $this->CreateWebUrl('member')?>"><div class="topDiv-content">用户管理</div></a>
		<a href="<?php  echo $this->CreateWebUrl('stat')?>"><div class="topDiv-content">统计分析</div></a>
	</div>
</div>
<script type="text/javascript">
	$(".topDiv-btn").hover(
		function(){
			$(".topDiv-all").slideDown();
		},
		function(){
			$(".topDiv-all").hover(
				function(){
				},
				function(){
					$(".topDiv-all").slideUp();
				}
			);
		}
	);
</script>
