<?php defined('IN_IA') or exit('Access Denied');?><ul class="nav nav-tabs">
<li  <?php  if($_GPC['do']=="liveList") { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('liveList');?>">直播间管理</a></li>
<li <?php  if($_GPC['do']=="liveSetting") { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('liveSetting',array('rid' =>$rid));?>">直播间设置</a></li>
<li <?php  if($_GPC['do']=="live_menu") { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('live_menu',array('rid' =>$rid));?>">导航栏管理</a></li>
<?php  if($_GPC['do']=="live_type") { ?><li <?php  if($_GPC['do']=="live_type") { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('live_type',array('rid' =>$rid));?>">新增栏目</a></li><?php  } ?>
<li <?php  if($_GPC['do']=="live_edit" ) { ?>class="active"<?php  } else { ?>style="display:none;"<?php  } ?>><a href="<?php  echo $this->createWebUrl('live_edit',array('rid' =>$rid));?>">直播间栏目编辑</a></li>
<li <?php  if($_GPC['do']=="video_type_edit") { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('video_type_edit',array('rid' =>$rid));?>">播放器设置</a></li>
<li <?php  if($_GPC['do']=="spread_adv_edit") { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('spread_adv_edit',array('rid' =>$rid));?>">开屏广告</a></li>
<li  <?php  if($_GPC['do']=="livePic") { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('livePic',array('rid'=>$rid))?>">图文直播</a></li>
<li  <?php  if($_GPC['do']=="comment") { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('comment',array('rid'=>$rid))?>">观众评论</a></li>
<?php  if($_GPC['do']=="sendGroupPacket") { ?><li  <?php  if($_GPC['do']=="sendGroupPacket") { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('sendGroupPacket',array('rid'=>$rid))?>">群红包</a></li><?php  } ?>
<?php  if($_GPC['do']=="dummyComment") { ?><li  <?php  if($_GPC['do']=="dummyComment") { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('dummyComment',array('rid'=>$rid))?>">虚拟评论</a></li><?php  } ?>
<?php  if($_GPC['do']=="reply") { ?><li  <?php  if($_GPC['do']=="reply") { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('reply',array('rid'=>$rid))?>">回复</a></li><?php  } ?>
<li  <?php  if($_GPC['do']=="redpacketlivesetting") { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('redpacketlivesetting',array('rid'=>$rid))?>">红包设置</a></li>
<li  <?php  if($_GPC['do']=="users") { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('users',array('rid'=>$rid))?>">观众列表</a></li>
<li  <?php  if($_GPC['do']=="pay") { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('pay',array('rid'=>$rid))?>">付费列表</a></li>
<li  <?php  if($_GPC['do']=="ds") { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('ds',array('rid'=>$rid))?>">打赏列表</a></li>
<li  <?php  if($_GPC['do']=="ds_edit") { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('ds_edit',array('rid'=>$rid))?>">打赏设置</a></li>
<li  <?php  if($_GPC['do']=="gift_list") { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('gift_list',array('rid'=>$rid))?>">礼物列表</a></li>
<li  <?php  if($_GPC['do']=="sendgiftlist") { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('sendgiftlist',array('rid'=>$rid))?>">送礼物列表</a></li>
<?php  if($_GPC['do']=="gift_edit") { ?><li  <?php  if($_GPC['do']=="ds_edit") { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('gift_edit',array('rid'=>$rid))?>">礼物设置</a></li><?php  } ?>
<li  <?php  if($_GPC['do']=="roll_adv_edit") { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('roll_adv_edit',array('rid'=>$rid))?>">滚动广告</a></li>
<li  <?php  if($_GPC['do']=="resetnum") { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('resetnum',array('rid'=>$rid))?>">人数重置</a></li>
<li  <?php  if($_GPC['do']=="area_edit") { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('area_edit',array('rid'=>$rid))?>">区域限制</a></li>
<li  <?php  if($_GPC['do']=="invitation") { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('invitation',array('rid'=>$rid))?>">邀请卡设置</a></li>
<li  <?php  if($_GPC['do']=="limit_edit") { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('limit_edit',array('rid'=>$rid))?>">观看限制</a></li>
<li  <?php  if($_GPC['do']=="share_edit") { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('share_edit',array('rid'=>$rid))?>">分享设置</a></li>
<li  <?php  if($_GPC['do']=="noticelist") { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('noticelist',array('rid'=>$rid))?>">消息通知</a></li>
<li  <?php  if($_GPC['do']=="zanpic") { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('zanpic',array('rid'=>$rid))?>">点赞图片</a></li>
<li  <?php  if($_GPC['do']=="accredit") { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('accredit',array('rid'=>$rid))?>">授权中心</a></li>
<?php  if($_GPC['do']=="notice") { ?><li  <?php  if($_GPC['do']=="notice") { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('notice',array('rid'=>$rid))?>">添加消息通知</a></li><?php  } ?>
<?php  if($_GPC['do']=="noticelog") { ?><li  <?php  if($_GPC['do']=="noticelog") { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('noticelog',array('rid'=>$rid))?>">群发详情</a></li><?php  } ?>
</ul>