<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta content="telephone=no" name="format-detection">
    <title>
        <?php  if($group) { ?><?php  echo $group['name'];?><?php  } else { ?>所有兑换项<?php  } ?>
    </title>
    <link rel="stylesheet" href="<?php  echo $resource['prefix'];?>assets/css/normalize.min.css?t=20151016">
    <link rel="stylesheet" href="<?php  echo $resource['prefix'];?>assets/css/list-page-v11.19.css">
    <style>
        .theme-color{color: <?php  echo $html['config']['theme_color'];?>;}
        .theme-bgcolor{background-color: <?php  echo $html['config']['theme_color'];?>;}
        .theme-bordercolor{border-color: <?php  echo $html['config']['theme_color'];?>;}
        /* radio */
        .radio-group.cur{border-color:<?php  echo $html['config']['theme_color'];?>; }
        .radio-group .cur-arrow{border-color: <?php  echo $html['config']['theme_color'];?> transparent transparent <?php  echo $html['config']['theme_color'];?>;}
        .description a {color: <?php  echo $html['config']['theme_color'];?>;}
    </style>
    <style>
        .noRecord p{font-size:10px;padding:10px 0px 0px;}
    </style>

</head>
<body>

<section id="main">
    <?php  if($page['count'] > 0) { ?>
    <div class="recommend single-row">
        <?php  if(is_array($page['data'])) { foreach($page['data'] as $good) { ?>
        <a href="<?php  echo $this->createMobileUrl('Good',array('id'=>$good['id'],'invite_id'=>$_GPC['invite_id']))?>" class="item">
            <img src="<?php  echo tomedia($good['thumbnail'])?>">
            <div class="item-info">
                <h3><?php  echo $good['title'];?></h3>
                <p class="theme-color"><?php  if($good['buy_type'] == NGSGiftService::GIFT_BUY_TYPE_SCORE) { ?><?php  echo $good['score'];?><?php  if($this->module['config']['score_name']) { ?><?php  echo $this->module['config']['score_name']?><?php  } else { ?>积分<?php  } ?><?php  } else if($good['buy_type'] == NGSGiftService::GIFT_BUY_TYPE_MONEY) { ?><?php  echo $good['money'];?>元<?php  } else if($good['buy_type'] == NGSGiftService::GIFT_BUY_TYPE_SCORE_AND_MONEY) { ?><?php  echo $good['score'];?><?php  if($this->module['config']['score_name']) { ?><?php  echo $this->module['config']['score_name']?><?php  } else { ?>积分<?php  } ?> + <?php  echo $good['money'];?>元<?php  } ?>
                </p>
            </div>
            <div class="tag" style="border-bottom-color:<?php  echo $good['tag_color'];?>;"><span><?php  echo $good['tag'];?></span></div>
            <button class="theme-color theme-bordercolor">
                <?php  if($good['buy_type'] == 2) { ?>
                <?php  if($good['num'] <= 0) { ?>售完<?php  } else { ?>购买<?php  } ?>
                <?php  } else { ?>
                <?php  if($good['num'] <= 0) { ?>兑完<?php  } else { ?>兑换<?php  } ?>
                <?php  } ?>
            </button>
        </a>
        <?php  } } ?>
    </div>
    <?php  } else { ?>
    <div class="noRecord">
        <img src="<?php  echo $resource['prefix'];?>/images/noRecord.png" width="66">
        <p>列表为空</p>
    </div>
    <?php  } ?>
</section>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('copyright', TEMPLATE_INCLUDEPATH)) : (include template('copyright', TEMPLATE_INCLUDEPATH));?>

<script src="<?php  echo $resource['prefix'];?>assets/js/zepto.min.js" type="text/javascript"></script>
<script>
    const GET_ITEMS_URL = "<?php  echo $resource['urls']['GoodList'];?>&ajax=true&group=<?php  echo $_GPC['group'];?>";
    const _appItemNextPage = '<?php  echo $html["end"];?>';
    const _autoRecommendNextPage = true;
    const _arunum = 3;
    const _arn = false;
    const _type = "<?php  echo $html['type'];?>";
</script>
<script src="<?php  echo $resource['prefix'];?>assets/js/fastclick.min.js"></script>
<script src="<?php  echo $resource['prefix'];?>assets/js/list-page-app.js"></script>
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=9&c=utility&a=visit&do=showjs&m=lonaking_new_gift_shop"></script></body></html>