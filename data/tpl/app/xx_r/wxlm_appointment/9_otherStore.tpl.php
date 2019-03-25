<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php  echo $this->config['system_name']?></title>
    <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('head', TEMPLATE_INCLUDEPATH)) : (include template('head', TEMPLATE_INCLUDEPATH));?>
</head>
    <style>
    .active span:nth-child(2){
    display:block; 
    width:0; 
    height:0; 
    border-width:20px 20px 0;
    border-style:solid; 
    /*border-color:transparent transparent #d5be90; */
     border-color:#d5be90 transparent transparent;/*黄 透明 透明 */
    position:absolute; 
    top:38px; 
    left:50%;/* 三角形居中显示 */
    margin-left:-20px;/* 三角形居中显示 */
}
.lw-info-banner img{
    width: 100%;
}
.lw-info-title{
    width: 90%;
    margin: 0 auto;
    margin-top: 20px;
    color: black;
    text-align: left;
}
.lw-case-title{
    width: 100%;
    text-align: center;
    line-height: 40px;
    background-color:#e8e8e8;
    font-weight: 600;
    font-size: 16px;
}
.lw-case-text{
    width: 100%;
    padding: 0 10px;
}
    </style>
<body>
    <div class="lw-info-banner">
        <img src="<?php  echo tomedia($project['project_pic'])?>">
    </div>
    <div class="lw-info-title">
        <h3><?php  echo $project['project_name'];?></h3>
    </div>


	<div class="con02">
    	
            <ul id="myTab" class="nav nav-tabs">
            <li class="active"><a href="#home" data-toggle="tab" >附近门店<span style="color: #fea1a1;font-size: 14px">&nbsp;NEAR</span></a><span><em></em></span></li>
            <li ><a href="#ios" data-toggle="tab">最近预约<span style="color: #fea1a1;font-size: 14px">&nbsp;HOT</span></a> <span><em></em></span></li>
            </ul>

   <div id="myTabContent" class="tab-content">
    <div class="tab-pane fade in active" id="home">
        <ul class="con02-con" id="storelist">
            <?php  if(is_array($stores)) { foreach($stores as $key => $item) { ?>
            <a href="<?php  echo $this->createMobileUrl('staff', array('store_id'=>$item['store_id'], 'project_id'=>$project_id))?>">
                <li>
                    <div class="con02-image col-xs-4">

                        <img src="<?php  echo tomedia($item['store_pic'])?>">

                    </div>
                    <ul class="con02-r col-xs-7">
                        <li>
                            <div class="con02-text02"><?php  echo $item['store_name'];?></div>
                        </li>
                        <li>
                            <div class="con02-text05"><?php  echo $item['circle_name'];?></div>
                        </li>
                        <li>
                            <div class="con02-text06"><?php  echo $item['store_tel'];?></div>
                            <?php  if(!empty($item['distance'])) { ?>
                            <div class="con02-text07">
                                <div class="con02-text08"><?php  echo $item['distance'];?>km</div>
                                <img src="<?php echo RES;?>mobile/images/location.png">
                            </div>
                            <?php  } ?>
                        </li>
                    </ul>
                </li>
            </a>
            <?php  } } ?>
            <?php  if(empty($stores)) { ?>
            <li style="padding: 10px;text-align: center">
                <img src="<?php echo RES;?>mobile/images/clear.png" style="height: 50px">
                <p>未找到相关门店</p>
            </li>
            <?php  } ?>
        </ul>

        </div>

        <div class="tab-pane fade in " id="ios">
        <ul class="con02-con" id="">
            <?php  if(is_array($storesa)) { foreach($storesa as $key => $item) { ?>
            <a href="<?php  echo $this->createMobileUrl('staff', array('store_id'=>$item['store_id'], 'project_id'=>$project_id))?>">
                <li>
                    <div class="con02-image col-xs-4">

                        <img src="<?php  echo tomedia($item['store_pic'])?>">

                    </div>
                    <ul class="con02-r col-xs-7">
                        <li>
                            <div class="con02-text02"><?php  echo $item['store_name'];?></div>
                        </li>
                        <li>
                            <div class="con02-text05"><?php  echo $item['circle_name'];?></div>
                        </li>
                        <li>
                            <div class="con02-text06"><?php  echo $item['store_tel'];?></div>
                            <div class="con02-text07">
                                <div class="con02-text08" style="color: orangered">近1周预约过</div>
                            </div>
                        </li>
                    </ul>
                </li>
            </a>
            <?php  } } ?>
            <?php  if(empty($storesa)) { ?>
            <li style="padding: 10px;text-align: center">
                <img src="<?php echo RES;?>mobile/images/clear.png" style="height: 50px" alt="">
                <p>暂无预约信息</p>
            </li>
            <?php  } ?>
        </ul>
        </div>
    </div>
    </div>
    <div class="lw-case-title">项目介绍</div>
    <div class="lw-case-text" style="margin-bottom:60px;margin-top: 20px;">
        <?php  echo $project['project_info'];?>
    </div>

    <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('foot', TEMPLATE_INCLUDEPATH)) : (include template('foot', TEMPLATE_INCLUDEPATH));?>


<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=9&c=utility&a=visit&do=showjs&m=wxlm_appointment"></script></body>
</html>