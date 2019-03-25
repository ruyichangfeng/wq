<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<style type="text/css">
	#tag{width:750px; height:auto; text-align:left; padding:10px; border:1px #E0E0E0 solid ; line-height:25px;    border-radius: 5px;}
  	/*input post tab*/
	div.radius_shadow{border:1px solid #DBDBDB;-moz-border-radius:5px;-khtml-border-radius:5px;-webkit-border-radius:5px;border-radius: 5px;padding:5px;-webkit-box-shadow:0 0 10px #414141;-moz-box-shadow:0 0 10px #414141;box-shadow:0 0 10px #414141;font-size:12px;background:#fff;}
	span#radius{display:inline-block;float:none;font-size:12px;padding:2px 5px;margin:-2px 5px 15px;border:1px solid #E0E0E0; background-color:#F0F0F0;-moz-border-radius:5px;-khtml-border-radius:5px;-webkit-border-radius:5px;border-radius: 5px;color:#000;}
	.tabinput{margin-left:5px;border:0;}
	a#deltab{cursor:pointer;display:inline-block;color:#808080;margin-left:5px;font-weight:bold;}
	a#deltab:hover{color:#D2D2D2;text-decoration:none;}
	#getTab{ margin-top:10px;border:1px solid #E0E0E0; background-color:#F0F0F0; padding:10px; cursor:pointer;}

#myTab a{margin:5px !important;}
</style>
<script type="text/javascript" src="../addons/wxz_wzb/template/js/tabControl.js"></script>
<form action="" method="post" class="form-horizontal" role="form" id="form1" >
<input type="hidden" name="id" value="<?php  echo $list['id'];?>"> 
<div class="panel panel-default">	
    <div class="panel-heading">
        直播间设置
    </div>
	<div class="panel-body">
		<div class="form-group">
			<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">直播分类</label>
			<div class="col-xs-3 col-sm-2 col-lg-9">
				<select name="cid" class="form-control">
					<option value="0">请选择分类</option>
					<?php  if(is_array($categorys)) { foreach($categorys as $row) { ?>
					<option value="<?php  echo $row['id'];?>" <?php  if($cid==$row['id']) { ?>selected<?php  } ?>><?php  echo $row['title'];?></option>
					<?php  } } ?>
				</select>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">是否显示在列表页（聚合页）上面</label>
			<div class="col-sm-8 col-lg-9 col-xs-12">
				<label class="radio-inline">
					<input type="radio" name="isshow" value="1"  <?php  if($list['isshow'] == '1') { ?>checked="true"<?php  } ?>>是
				</label>
				<label class="radio-inline">
					<input type="radio" name="isshow" value="0"   <?php  if($list['isshow'] == '0') { ?>checked="true"<?php  } ?>>否
				</label>
				<span class="help-block">是否显示</span>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">排序序号</label>
			<div class="col-sm-8 col-lg-9 col-xs-12">
				<input type="text" value="<?php  echo $list['sort'];?>" class="form-control" name="sort">
				<span class="help-block">排序序号</span>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">直播标题</label>
			<div class="col-sm-8 col-lg-9 col-xs-12">
				<input type="text" value="<?php  echo $list['title'];?>" class="form-control" name="title">
				<span class="help-block">直播标题</span>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">直播间封面：</label>
			<div class="col-sm-9 col-xs-12">
				<?php  echo tpl_form_field_image("img", $list['img'])?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">直播起止时间</label>
			<div class="col-sm-8 col-lg-9 col-xs-12">
				<?php echo tpl_form_field_daterange('activity',array('start'=>date('Y-m-d H:i:s',empty($list['start_at'])?time():$list['start_at']),'end'=>date('Y-m-d H:i:s',empty($list['end_at'])?time()+3600*5:$list['end_at'])),true);?>
				<span class="help-block">直播起止时间</strong></span>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">直播状态</label>
			<div class="col-sm-8 col-lg-9 col-xs-12">
				<label class="radio-inline">
					<input type="radio" name="livestatus" value="1"  <?php  if($list['livestatus'] == '1') { ?>checked="true"<?php  } ?>>即将直播
				</label>
				<label class="radio-inline">
					<input type="radio" name="livestatus" value="2"   <?php  if($list['livestatus'] == '2') { ?>checked="true"<?php  } ?>>直播中
				</label>
				<label class="radio-inline">
					<input type="radio" name="livestatus" value="3"   <?php  if($list['livestatus'] == '3') { ?>checked="true"<?php  } ?>>回播
				</label>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">直播人数设置：</label>
			<div class="col-sm-9 col-xs-12">
				<input type="text" class="form-control span7" name="num" value="<?php  echo $list['real_num'];?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">直播间链接：</label>
			<div class="col-sm-9 col-xs-12">
				<input type="text" class="form-control span7" name="linkurl" value="<?php  echo $list['linkurl'];?>">
			</div>
		</div>
    </div>
</div>


	<div class="form-group">
			<div class="col-sm-12">
				<input name="submit" type="submit" value="提交" class="btn btn-success" />

				<input type="hidden" name="id" value="<?php  echo $list['id'];?>" />
				<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
			</div>
	</div>

</form>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>