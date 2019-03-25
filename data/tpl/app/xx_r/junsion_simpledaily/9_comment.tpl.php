<?php defined('IN_IA') or exit('Access Denied');?><style>
.rich_media_area_extra {
padding: 0 15px 0;
}
.rich_tips.with_line {
border-top: 1px dotted #e1e1e1;
}
.rich_tips {
margin-top: 25px;
margin-bottom: 0;
min-height: 24px;
text-align: center;
}
.rich_tips.discuss_title_line {
margin-top: 50px;
}
.rich_tips.with_line {
line-height: 16px;
}
.rich_tips .tips, .rich_tips .rich_icon {
vertical-align: middle;
}
.rich_tips.with_line .tips {
position: relative;
top: -12px;
padding-left: 16px;
padding-right: 16px;
background-color: #fff;
}
.rich_tips.with_line .tips {
top: -11px;
padding-left: .35em;
padding-right: .35em;
}
.discuss_icon_tips {
margin-bottom: 20px;
}
.title_bottom_tips {
margin-top: -10px;
}
.tr {
text-align: left;
}
.discuss_icon_tips a {
color: #607fa6;
text-decoration: none;
}
.discuss_icon_tips .icon_edit {
width: 12px;
}
.rich_media_extra img {
vertical-align: middle;
margin-top: -3px;
}
.discuss_icon_tips img {
vertical-align: middle;
margin-left: 3px;
margin-top: -4px;
}
.discuss_icon_tips img {
height: auto!important;
}
.discuss_list {
margin-top: -5px;
padding-bottom: 20px;
font-size: 16px;
}
.discuss_item {
position: relative;
padding-left: 45px;
margin-top: 26px;
}
.discuss_item .user_info {
min-height: 20px;
overflow: hidden;
}
.discuss_item .nickname {
display: block;
font-weight: 400;
font-style: normal;
color: #727272;
width: 9em;
overflow: hidden;
text-overflow: ellipsis;
white-space: nowrap;
word-wrap: normal;
}
.discuss_item .avatar {
position: absolute;
top: 0;
left: 0;
top: 3px;
width: 35px;
height: 35px;
background-color: #ccc;
vertical-align: top;
margin-top: 0;
border-radius: 2px;
-moz-border-radius: 2px;
-webkit-border-radius: 2px;
}
.discuss_item .discuss_message {
word-wrap: break-word;
-webkit-hyphens: auto;
-ms-hyphens: auto;
hyphens: auto;
overflow: hidden;
color: #7d7d7d;
line-height: 1.5;
}
.discuss_item .discuss_extra_info {
color: #8c8c8c;
font-size: 12px;
}
.discuss_item:after {
content: "\200B";
display: block;
height: 0;
clear: both;
}
.delcomment{
	float: right;
    border: 1px solid #607fa6;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    text-align: center;
    line-height: 17px;
}
.check_btn{
	color: #fff;
    background-color: #5cb85c;
    border-color: #4cae4c;
    display: inline-block;
    padding: 6px 12px;
    margin-bottom: 0;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.42857143;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-image: none;
    border: 1px solid transparent;
    border-radius: 4px;
}
</style>
<div class="rich_media_area_extra comment_list">
	<!-- <div class="rich_tips with_line title_tips discuss_title_line">
		<span class="tips">精选留言</span>
	</div> -->
	<div class="jun_adv_line">
		<hr><font>精选留言</font>
	</div>
	<?php  if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) { ?>
	<p class="discuss_icon_tips title_bottom_tips tr" id="js_cmt_addbtn1"
		style="display: block;">
		<a href="<?php  echo $this->createMobileUrl('editComment',array('wid'=>base64_encode($works['id'])))?>">写留言<img class="icon_edit"
			src="../addons/junsion_simpledaily/resource/images/icon_edit.png"
			alt="">
		</a>
	</p>
	<?php  } ?>
	<ul class="discuss_list">
		<?php  if(is_array($comments)) { foreach($comments as $k => $comment) { ?>
		<li class="discuss_item">
			<?php  if($frommyworks) { ?><a data-id="<?php  echo $comment['id'];?>" class="delcomment" onclick="delcomment(this)">x</a><?php  } ?>
			<div class="user_info">
				<strong class="nickname"><?php  echo $comment['nickname'];?></strong> <img class="avatar"
					src="<?php  echo $comment['avatar'];?>">
			</div>
			<div class="discuss_message">
				<span class="discuss_status"></span>
				<div class="discuss_message_content">
					<?php  echo $comment['content'];?>
				</div>
			</div>
			<p class="discuss_extra_info"><?php  echo $this->sub_day($comment['createtime']);?></p>
		</li>
		<?php  } } ?>
	</ul>
	<?php  if($k==4) { ?>
		<div style="width: 100%;text-align: center;"><input type="button" class="check_btn" value="查看更多"></div>	
	<?php  } ?>
</div>
<script>
$('.check_btn').click(function (){
	var obj = $(this);
	$.ajax({
		url: "<?php  echo $this->createMobileUrl('editcomment', array('wid'=>base64_encode($works['id'])))?>",
		type: "post",
		dataType: "json",
		success: function(data){
			console.log(data);
			var str = '';
			$.each(data, function(i){
				str += '<li class="discuss_item">';
				<?php  if($frommyworks) { ?>str += '<a data-id="'+data[i].id+'" class="delcomment" onclick="delcomment(this)">x</a>';<?php  } ?>
				str += '<div class="user_info">'+
						'<strong class="nickname">'+data[i].nickname+'</strong> <img class="avatar"src="'+data[i].avatar+'">'+
					'</div>'+
					'<div class="discuss_message">'+
						'<span class="discuss_status"></span>'+
						'<div class="discuss_message_content">'
							+data[i].content+
						'</div>'+
					'</div>'+
					'<p class="discuss_extra_info">'+data[i].createtime+'</p>'+
				'</li>';
			});
			$('.discuss_list').html(str);
			$(obj).parent().remove();
		}
	});
});
function delcomment(obj){
	if(!confirm('确定删除吗')) {
		return false;
	}
	var id = $(obj).data('id');
	$.ajax({
		url: "<?php  echo $this->createMobileUrl('delComment')?>",
		type: "post",
		data: {id: id},
		success: function(){
			$(obj).parent().remove();
		}
	});	
}

</script>