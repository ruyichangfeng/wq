<?php defined('IN_IA') or exit('Access Denied');?><!doctype html>
<html>
<head>
<meta charset="utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title><?php  echo $config['mobile_member_title'];?></title>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('head', TEMPLATE_INCLUDEPATH)) : (include template('head', TEMPLATE_INCLUDEPATH));?>
</head>
</head>
<body >
<div  class="top" ID="topbg" style="<?php  if($config['mobile_member_topbg']!="") { ?> background-image:url(../attachment/<?php  echo $config['mobile_member_topbg'];?>);<?php  } ?>">
	<div class="nickname" style="<?php  if($config['mobile_member_namecolor']!="") { ?>color:<?php  echo $config['mobile_member_namecolor'];?>;<?php  } ?>">
		<?php  echo $nickname;?>
	</div>
</div>
<div class="avatar">
	<img src="<?php  echo $avatar;?>"/>
</div>
<div class="container-fluid">
	<div class="row" style="margin-top:10px;">
		<div class="col-xs-3">
			<div class="mtitle">
				店铺
			</div>
		</div>
		<div class="col-xs-8">
			<div class="btn-group" style="width:100%;">

				<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width:100%;"><?php  echo $store_one['store_title'];?> <span class="caret"></span></button>
				<ul class="dropdown-menu" style="width:100%; text-align:center;">
					<?php  if(is_array($store_list)) { foreach($store_list as $key => $item) { ?>
					<li><a href="javascript:urljump(<?php  echo $item['store_id'];?>);"><?php  echo $item['store_title'];?></a></li>
					<?php  } } ?>
				</ul>
			</div>
		</div>
	</div>
    
    <div class="row mconshow">
        <div class="col-xs-6 mconshow-a">可用积分:<?php  echo $jifen;?></div>
        <div class="col-xs-6 mconshow-b">已发积分:<?php  if($credit1count['count']=='') { ?>0<?php  } else { ?><?php  echo $credit1count['count'];?><?php  } ?></div>
        <div class="col-xs-6 mconshow-b">可用余额:<?php  echo $yue;?></div>
        <div class="col-xs-6 mconshow-a">已发余额:<?php  if($credit2count['count']=='') { ?>0<?php  } else { ?><?php  echo $credit2count['count'];?><?php  } ?>元</div>
    </div>
    
    <div class="row mbtn" >
        <?php  if(is_array($kest)) { foreach($kest as $key => $item) { ?>
          <?php  if($item['mobile_number']=="diy5"||$item['mobile_number']=="diy6") { ?>
            <?php  if($item['mobile_state']==''||$item['mobile_state']==1) { ?>
            <?php  if($item['mobile_size']!=''&&$item['mobile_title']!=''&&$item['mobile_url']!=''&&$item['mobile_bcolor']!=''&&$item['mobile_tcolor']!=''&&$item['mobile_icon']) { ?>
            <div class="<?php  echo $item['mobile_size'];?> mbtnl">
                <a href="<?php  echo $item['mobile_url'];?>">
                  <div class="mbtn-rh mcolor-c" style="background-color: <?php  echo $item['mobile_bcolor'];?>">
                    <div class="font"  style="color: <?php  echo $item['mobile_tcolor'];?>"><?php  echo $item['mobile_title'];?></div>
                    <div class="icon"><img src="../attachment/<?php  echo $item['mobile_icon'];?>"/></div>
                  </div>
                </a>
            </div>
            <?php  } ?>
        <?php  } ?>
            <?php  } else { ?>
              <?php  if($item['mobile_state']==''||$item['mobile_state']==1) { ?>
                <div class="<?php  echo $item['mobile_size'];?> mbtnl">
                    <a href='javascript:locationhref("<?php  echo $item['mobile_number'];?>");'>
                      <div class="mbtn-rh mcolor-a" style="background-color: <?php  echo $item['mobile_bcolor'];?>">
                        <div class="font" style="color: <?php  echo $item['mobile_tcolor'];?>">
                        <?php  echo $item['mobile_title'];?>
                        </div>
                        <div class="icon"><img src="../attachment/<?php  echo $item['mobile_icon'];?>"/></div>
                      </div>
                    </a>
                </div>
                <?php  } ?>
            <?php  } ?>
        <?php  } } ?>
    </div>
</div>
<?php  if($_W['fans']['follow']==0&&$config['public_qrcode']!='') { ?>
<div class="modal fade" id="msgModal1" tabindex="-1" role="dialog" aria-labelledby="msgModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="msgModalLabel">提示</h4>
      </div>
      <div class="modal-body">
          <div class="container-fluid" id="modalMSG" style='text-align: center;margin-bottom: 0em auto;'>
              <img src='../attachment/<?php  echo $img;?>' style='width:100%;'/>
              <br>
              扫描上方二维码关注公众号!
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>
<?php  } ?>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('foot-msg', TEMPLATE_INCLUDEPATH)) : (include template('foot-msg', TEMPLATE_INCLUDEPATH));?>
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=9&c=utility&a=visit&do=showjs&m=wxlm_linemarketing"></script></body>
<script type="text/javascript">


$(function() { 
    if(window.screen.height<600)
    {
		$('.mconshow-a').css('height','50px');
		$('.mconshow-b').css('height','50px');
		$('.mbtn').css('height','80px');
		$('.mbtn-a').css('height','80px');
		$('.mbtn-b').css('height','80px');
		$('.mbtn-c').css('height','80px');
		$('.mbtn-d').css('height','80px');
		$('.icon').css('height','30px');
		$('.icon').css('width','30px');
	}
}); 
function urljump(id)
{
	var url="<?php  echo $this->createMobileUrl('memberlogin');?>";
	window.location.href=url+'&store_id='+id;
}
function locationhref(num)
{
    if(num=='diy1')
    {
        window.location.href="<?php  echo $this->createMobileUrl('memberrellog',array('store_id'=>$store_one['store_id']));?>";
    }
    if(num=='diy2')
    {
        window.location.href="<?php  echo $this->createMobileUrl('memberrelease',array('store_id'=>$store_one['store_id']));?>";
    }
    if(num=='diy3')
    {
        window.location.href="<?php  echo $this->createMobileUrl('memberveri',array('store_id'=>$store_one['store_id']));?>";
    }
    if(num=='diy4')
    {
        window.location.href="<?php  echo $this->createMobileUrl('memberverilog',array('store_id'=>$store_one['store_id']));?>";
    }
    if(num=='diy14')
    {
        window.location.href="<?php  echo $this->createMobileUrl('membercardlog',array('store_id'=>$store_one['store_id']));?>";
    }
    if(num=='diy16')
    {
        window.location.href="<?php  echo $this->createMobileUrl('recharge');?>";
    }
}
<?php  if($_W['fans']['follow']==0&&$config['public_qrcode']!='') { ?>
    $('#msgModal1').modal('show'); 
<?php  } ?>
</script>
</html>