<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
	<li><a href="./index.php?c=platform&a=reply&do=post&m=<?php  echo $this->modulename?>">新建活动</a></li>
    <li <?php  if($op == 'list') { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createWebUrl('manage',array('op' =>'list'))?>">活动列表</a></li>
    <?php  if($op == 'award') { ?><li class="active" ><a>中奖信息</a></li><?php  } ?>
    <?php  if($op == 'player') { ?><li class="active" ><a>参与者信息</a></li><?php  } ?>
    <?php  if($op == 'friend') { ?><li class="active" ><a>助力者信息</a></li><?php  } ?>
</ul>
<style>
th{
	text-align: center !important;
}

td{
	text-align: center !important;
	white-space: normal !important;
	word-break: break-all !important;
}
</style>
<?php  if($op == 'list') { ?>
<div class="main" style="background: white;">
    <div style="padding:15px;">
        <table class="table table-hover">
            <thead class="navbar-inner">
                <tr>
                    <th>规则名称</th>					
                    <th>活动名称</th>
                    <th>活动时间</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php  if(is_array($list)) { foreach($list as $l) { ?>
                <tr>
                    <td><a href="./index.php?c=platform&a=reply&do=post&m=<?php  echo $this->modulename?>&rid=<?php  echo $l['rid'];?>"><?php  echo $l['name'];?></a></td>
                    <td><a href="./index.php?c=platform&a=reply&do=post&m=<?php  echo $this->modulename?>&rid=<?php  echo $l['rid'];?>"><?php  echo $l['title'];?></a></td>
                    <td>开始时间：<?php  echo date('Y-m-d H:i:s',$l['starttime'])?><br>结束时间：<?php  echo date('Y-m-d H:i:s',$l['endtime'])?></td>
                    <td>
                    	<a href='<?php  echo $this->createWebUrl("manage",array("op"=>"player","rid"=>$l["rid"]))?>' class="btn btn-warning btn-sm">参与会员(<?php  echo $l['attend'];?>)</a>
                    </td>
                </tr>
                <?php  } } ?>
            </tbody>
        </table>
    </div>
</div>
<?php  } else if($op == 'player') { ?>
<div class="main" style="background: white;">
    <div style="padding:15px;">
        <table class="table table-hover">
            <thead class="navbar-inner">
                <tr>
                    <th>参与者</th>
                    <?php  if($rule['ismobile']) { ?><th>手机号码</th><?php  } ?>
                    <?php  if($rule['isqq']) { ?><th>QQ</th><?php  } ?>
                    <?php  if($rule['isemail']) { ?><th>邮箱</th><?php  } ?>
                    <?php  if($rule['isaddress']) { ?><th>地址</th><?php  } ?>
					<th>剩余游戏次数</th>
                    <th>游戏分数</th>
                    <?php  if($rule['endtime'] <= time()) { ?><th>状态</th><?php  } ?>
                    <th>参与时间</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php  if(is_array($list)) { foreach($list as $k => $l) { ?>
                <tr>
                    <td><img src="<?php  echo $l['avatar'];?>" style="width: 50px;height: 50px;"><br><?php  if($l['realname']) { ?><?php  echo $l['realname'];?><?php  } else { ?><?php  echo $l['nickname'];?><?php  } ?></td>
                    <?php  if($rule['ismobile']) { ?><td><?php  echo $l['mobile'];?></td><?php  } ?>
                    <?php  if($rule['isqq']) { ?><td><?php  echo $l['qq'];?></td><?php  } ?>
                    <?php  if($rule['isemail']) { ?><td><?php  echo $l['email'];?></td><?php  } ?>
                    <?php  if($rule['isaddress']) { ?><td><?php  echo $l['address'];?></td><?php  } ?>
                    <td><?php  if($rule['endtime'] > time()) { ?><input style="width: 100px;display: inline-block;" class="form-control" type="number" min="0" name="times" value="<?php  if(empty($l['times'])) { ?>0<?php  } else { ?><?php  echo $l['times'];?><?php  } ?>"><?php  } else { ?><?php  echo $l['times'];?><?php  } ?></td>
                    <td><?php  if($rule['endtime'] > time()) { ?><input style="width: 150px;display: inline-block;" class="form-control" type="number" min="0" name="score" value="<?php  if(empty($l['score'])) { ?>0<?php  } else { ?><?php  echo $l['score'];?><?php  } ?>"><?php  } else { ?><?php  echo $l['score'];?><?php  } ?></td>
                    <?php  if($rule['endtime'] <= time()) { ?>
                    	<td><?php  if($k < $ptotal) { ?><?php  if(!$l['status']) { ?><label class="label label-danger">已中奖</label><?php  } else { ?><label class="label label-success">已发奖</label><?php  } ?><p style="margin: 0;margin-top: 5px;color: blue;font-weight: bold;}">(<?php  echo $plist[$k];?>)</p><?php  } ?></td>
                    <?php  } ?>
                    <td><?php  echo date('Y-m-d H:i:s',$l['createtime'])?></td>
                    <td>
                    <?php  if($rule['endtime'] > time()) { ?>
                    <a class="btn btn-primary btn-sm" onclick="onSave(this,<?php  echo $l['id'];?>)">保存</a>
                    <?php  } else if(!$l['status'] && $k < $ptotal) { ?>
                    <a class="btn btn-primary btn-sm" onclick="return confirm('修改后将不能恢复，确定修改吗？')" href="<?php  echo $this->createWebUrl('manage',array('op'=>'take','pid'=>$l['id'],'rid'=>$rid))?>">发奖</a>
                    <?php  } ?>
                    <a href='<?php  echo $this->createWebUrl("manage",array("op"=>"friend","pid"=>$l["id"]))?>' class="btn btn-default btn-sm">助力者(<?php  if($l['bnum']) { ?><?php  echo $l['bnum'];?><?php  } else { ?>0<?php  } ?>)</a>
                    </td>
                </tr>
                <?php  } } ?>
            </tbody>
        </table>
        <?php  echo $pager;?>
    </div>
</div>
<script>
function onSave(obj,pid){
	var tr = $(obj).parent().parent();
	var times = tr.find('input[name="times"]').val();
	var score = tr.find('input[name="score"]').val();
	$.ajax({
		url:'<?php  echo $this->createWebUrl("cheat")?>',
		type:'post',
		data:{pid:pid,score:score,times:times},
		success: function(msg){
			if(msg == '1'){
				alert('保存成功！');
			}else{
				alert('保存失败!');
				location.reload();
			}
		},
		error: function(){
			alert('发送请求失败，请重试!');
			location.reload();
		}
	});
}
</script>
<?php  } else if($op == 'friend') { ?>
<div class="main" style="background: white;">
    <div style="padding:15px;">
        <table class="table table-hover">
            <thead class="navbar-inner">
                <tr>
                    <th>姓名</th>		
                    <th>头像</th>
                    <th>助力游戏次数</th>
                    <th>助力时间</th>
                </tr>
            </thead>
            <tbody>
                <?php  if(is_array($list)) { foreach($list as $l) { ?>
                <tr>
                    <td><?php  echo $l['nickname'];?></td>
                    <td><img src="<?php  echo $l['avatar'];?>" style="width: 50px;height: 50px;"></td>
                    <td><?php  echo $l['blessing_num'];?></td>
                    <td><?php  echo date('Y-m-d H:i:s',$l['createtime'])?></td>
                </tr>
                <?php  } } ?>
            </tbody>
        </table>
        <?php  echo $pager;?>
    </div>
</div>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>