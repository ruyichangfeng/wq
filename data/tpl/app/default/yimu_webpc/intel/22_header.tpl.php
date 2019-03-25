<?php defined('IN_IA') or exit('Access Denied');?><!--头部-->
<head>
    <meta charset="UTF-8">
    <title><?php  echo $setting['title'];?></title>
    <meta name="keywords" content="<?php  echo $setting['keywords'];?>" /> 
    <meta name="description" content="<?php  echo $setting['description'];?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php  echo $_W['siteroot'];?>addons/yimu_webpc/template/webapp/intel/css/swiper.css">
    <link rel="stylesheet" href="<?php  echo $_W['siteroot'];?>addons/yimu_webpc/template/webapp/intel/css/style.css">
    <link rel="stylesheet" href="<?php  echo $_W['siteroot'];?>addons/yimu_webpc/template/webapp/intel/css/animate.min.css">
    <script src="<?php  echo $_W['siteroot'];?>addons/yimu_webpc/template/webapp/intel/js/jquery.min.js"></script>
    <script src="<?php  echo $_W['siteroot'];?>addons/yimu_webpc/template/webapp/intel/js/wow.min.js"></script>
    <script src="<?php  echo $_W['siteroot'];?>addons/yimu_webpc/template/webapp/intel/js/script.js"></script>
    <link rel="shortcut icon" href="<?php  echo $_W['siteroot'];?>attachment/<?php  echo $setting['favicon'];?>" /> 
</head>
        <header>
           <div class="menuContainer">
            <div class="logoBox">
                <img src="<?php  echo $_W['siteroot'];?>attachment/<?php  echo $setting['flogo'];?>" alt="" class="yimuLogo">
            </div>
            <nav>
                <ul class="menu">
                	
                    <?php  if($unnemu['indexbt'] == 1) { ?><a href="<?php  echo url('entry/webapp/index', array('m' => 'yimu_webpc'))?>"><li <?php  if($_GPC['do']=='index') { ?>class="selectedMenu"<?php  } ?>><?php  echo $nemu['index'];?></li></a><?php  } ?>
                    <?php  if($unnemu['productbt'] == 1) { ?><a href="<?php  echo url('entry/webapp/product', array('m' => 'yimu_webpc'))?>"><li <?php  if($_GPC['do']=='product') { ?>class="selectedMenu"<?php  } ?> ><?php  echo $nemu['product'];?></li></a><?php  } ?>
                    <?php  if($unnemu['casebt'] == 1) { ?><a href="<?php  echo url('entry/webapp/cases', array('m' => 'yimu_webpc'))?>"><li <?php  if($_GPC['do']=='cases') { ?>class="selectedMenu"<?php  } ?>><?php  echo $nemu['case'];?></li></a><?php  } ?>
                    <?php  if($unnemu['aboutbt'] == 1) { ?><a href="<?php  echo url('entry/webapp/aboutus', array('m' => 'yimu_webpc'))?>"><li <?php  if($_GPC['do']=='aboutus') { ?>class="selectedMenu"<?php  } ?>><?php  echo $nemu['about'];?></li></a><?php  } ?>
                    <?php  if($unnemu['agentbt'] == 1) { ?><a href="<?php  echo url('entry/webapp/joinus', array('m' => 'yimu_webpc'))?>"><li <?php  if($_GPC['do']=='joinus') { ?>class="selectedMenu"<?php  } ?>><?php  echo $nemu['agent'];?></li></a><?php  } ?>
                    <?php  if($unnemu['programbt'] == 1) { ?><a href="<?php  echo url('entry/webapp/news', array('m' => 'yimu_webpc'))?>"><li <?php  if($_GPC['do']=='news') { ?>class="selectedMenu"<?php  } ?>><?php  echo $nemu['program'];?></li></a><?php  } ?>
                </ul>
            </nav>
            <?php  if($unnemu['dlbt'] == 1) { ?>
            <div class="loginBox">
                <div class="loginBtn"><a target="_blank" href="<?php  echo $nemu['url'];?>"><?php  echo $nemu['dl'];?></a></div>
            </div>
            <?php  } ?>
           </div>
        </header>
       
    
    <script src="<?php  echo $_W['siteroot'];?>addons/yimu_webpc/template/webapp/intel/js/swiper.js"></script>
    