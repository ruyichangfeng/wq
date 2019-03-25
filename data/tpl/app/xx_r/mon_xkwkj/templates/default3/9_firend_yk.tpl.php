<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <title><?php  echo $xkwkj['title'];?></title>

    <link rel="stylesheet" type="text/css"  href="<?php echo MON_XKWKJ_RES;?>template/mobile/templates/default3/css/sweet-alert.css" />
    <script type="text/javascript" src="<?php echo MON_XKWKJ_RES;?>template/mobile/templates/default3/js/sweet-alert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo MON_XKWKJ_RES;?>template/mobile/templates/default3/css/main.css?v=2">
    <link rel="stylesheet" type="text/css" href="<?php echo MON_XKWKJ_RES;?>template/mobile/templates/default3/css/mui.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo MON_XKWKJ_RES;?>template/mobile/templates/default3/css/index.css">
    <link rel="stylesheet" type="text/css" href="<?php echo MON_XKWKJ_RES;?>template/mobile/templates/default3/css/animate.css">
    <link rel="stylesheet" type="text/css" href="<?php echo MON_XKWKJ_RES;?>template/mobile/templates/default2/css/jquery.flipcountdown.css"/>
    <script src="<?php echo MON_XKWKJ_RES;?>template/mobile/templates/default3/js/zepto.js" type="text/javascript" type="text/javascript"></script>
    <script src="<?php echo MON_XKWKJ_RES;?>template/mobile/templates/default3/js/jquery.js" type="text/javascript"></script>
    <script src="<?php echo MON_XKWKJ_RES;?>template/mobile/templates/default3/js/jquery.flipcountdown.js" type="text/javascript"></script>





    <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('share', TEMPLATE_INCLUDEPATH)) : (include template('share', TEMPLATE_INCLUDEPATH));?>

    <script>
        $(function () {
          <?php  if(TIMESTAMP <$xkwkj['endtime']) { ?>
            var NY =<?php  echo $xkwkj['endtime'];?>;
            $('#new_year').flipcountdown({
                size: "xs", tick: function () {
                    var nol = function (h) {
                        return h > 9 ? h : '0' + h;
                    }
                    var range = NY - Math.round((new Date()).getTime() / 1000), secday = 86400, sechour = 3600, days = parseInt(range / secday), hours = parseInt((range % secday) / sechour), min = parseInt(((range % secday) % sechour) / 60), sec = ((range % secday) % sechour) % 60;
                    return nol(days) + ' ' + nol(hours) + ' ' + nol(min) + ' ' + nol(sec) + ' ';
                }
            });
            $(".xdsoft_digit2:eq(0)").text('天');
            $(".xdsoft_digit2:eq(1)").text('时');
            $(".xdsoft_digit2:eq(2)").text('分');
            $(".xdsoft_digit2:eq(3)").text('秒');

            <?php  } ?>
    });
    </script>

    <style>
        .share-text {
            position: fixed;
            z-index: 15;
            top: 11px;
            right: 18px;
            width: 288px;
            height: 356px;
            background: url("<?php  echo MonUtil::defaultImg(MonUtil::$IMG_SHARE_BG,$xkwkj)?>") no-repeat;
            -webkit-background-size: 100% auto;
            -moz-background-size: 100% auto;
            background-size: 100% auto;
        }
    </style>
</head>
<body class="index">

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('templates/default3/kj_announcement', TEMPLATE_INCLUDEPATH)) : (include template('templates/default3/kj_announcement', TEMPLATE_INCLUDEPATH));?>
<header>

    <div class="banner-top">
        <div class="left-div" style="float: left"><span><font class="color-red"><?php  echo $xkwkj['vcount'];?></font>人查看</span> <font class="color-red"><?php  echo $xkwkj['sharecount'];?></font>人分享</span> <font class="color-red"><?php  echo $joinCount;?></font>人报名</span>  <span><font class="color-red">剩余<?php  echo $leftCount;?></font>件</span></div>
    </div>
    <banner>
        <div id="slider"><img src="<?php  echo MonUtil::getpicurl($goods['p_pic'])?>">
            <div class="banner-title color-white">  <a href="<?php  echo $goods['p_url'];?>" class="banner-title color-white" style="text-decoration: underline; "><?php  echo $xkwkj['title'];?></a></div>
        </div>
    </banner>
</header>


<main>
    <div class="mui-card-content">
        <div class="banner-time">
            <?php  if($status == $this::$KJ_STATUS_ZC) { ?>
            <?php  if(TIMESTAMP < $xkwkj['endtime']) { ?>
            <div style="height:23px;line-height:23px;text-align:center;">活动到期时间</div>
            <?php  } else { ?>
            <div style="height:23px;line-height:23px;text-align:center;">活动已结束</div>
            <?php  } ?>
            <?php  if(TIMESTAMP <$xkwkj['endtime']) { ?>
            <div id="new_year" style="text-align:center;"></div>
            <?php  } ?>

            <?php  } else { ?>
            <div>
                <div style="height:23px;line-height:23px;text-align:center; color: yellow"><?php  echo $statusText;?></div>
            </div>
            <?php  } ?>

        </div>
    </div>

    <div class="mui-card-content mui-card-content1">
        <div class="left"><font class="color-orange">原价:</font> <font class="color-red"><?php  echo $xkwkj['p_y_price'];?>元</font></div>
        <div class="right"><font class="color-orange">底价:</font> <font class="color-red"><?php  echo $xkwkj['p_low_price'];?>元</font></div>
        <div class="clear"></div>
        <div class="card-button">
            <div class="container zlinfo" style="margin-top:10px"><h4><?php  echo $firend['nickname'];?>，<?php  echo $this->getTipMsg($xkwkj, $this::$TIP_FK_ALREADY)?></h4>
                <table style="border: 1px solid #c5c8d0;width:100%" cellspacing="0">
                    <tr>
                        <td style="padding: 8px 6px;border-bottom: 1px solid #c5c8d0;border-right:1px solid #c5c8d0;text-align:center">
                            好友昵称
                        </td>
                        <td style="border-bottom: 1px solid #c5c8d0;border-right:1px solid #c5c8d0;width:33%;text-align:center">
                            当前价格
                        </td>
                        <td style="border-bottom: 1px solid #c5c8d0;width:33%;text-align:center">已砍价格</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 6px;border-right:1px solid #c5c8d0;text-align:center"><?php  echo $user['nickname'];?></td>
                        <td style="border-right:1px solid #c5c8d0;text-align:center"><font
                                color="red"><strong><?php  echo $user['price'];?></strong></font>
                        </td>
                        <td style="text-align:center"><?php  echo round($xkwkj['p_y_price']-$user['price'], 2)?></td>
                    </tr>
                </table>
                <p>活动结束时间：<?php  echo date("Y-m-d H:i", $xkwkj['endtime'])?></p>

                <div class="act cf">

                    <a  href="javascript:join()" class="btn-base btn-3" style="background-color:#ff685c;width:49%;float:left;"><i></i><span>我也要</span></a>

                    <a class="btn-base btn-share" style="background-color:#9AA1B4;width:49%;float:right;"><span style="color:#fff">找人帮他砍</span></a>

                </div>
            </div>
        </div>
    </div>


    <div class="mui-card-content">
        <div class="card-title card-text"><i></i>活动说明</div>
        <?php  echo $xkwkj['kj_intro'];?>
    </div>



    <div class="mui-card-content">
        <div class="card-title card-text"><i></i>排行榜</div>
        <div class="card-rank">

            <div class="joinList">
                <div class="container">
                    <article>

                        <ul class="scrollUl">
                            <li class="on" id="m01" >排行榜</li>
                            <li  id="m02" >帮砍团</li>
                        </ul>

                        <section>


                            <section id="srank">
                                <table class="wx_list" cellspacing="0">
                                    <tbody>
                                    <tr class="btitle">
                                        <td class="order" >排名</td>
                                        <td class="author" style="text-align: center">昵称</td>
                                        <td class="order" width="30px" style="text-align: center" >头像</td>
                                        <td class="jphone" style="text-align: center" >砍掉金额</td>
                                        <td class="jphone" style="text-align: center" >当前金额</td>
                                    </tr>

                                    <?php 
                                    for ($index = 0; $index <count($ranklist); $index++) {
                                        $rankuser = $ranklist[$index];
                                ?>
                                    <tr class=" <?php  if($index+1 <= $zl['top_tag']) {echo 'top ';} if(($index+1)%2 == 0 ) {echo 'two';}  ?>">
                                        <td class="order"><?php  echo $index+1; ?></td>
                                        <td class="author"  style="text-align: center" ><?php   echo $rankuser['nickname'];  ?></td>
                                        <td class="author" style="text-align: center" ><img src="<?php   echo $rankuser['headimgurl'];  ?>" height="30px;" width="30px"></td>
                                        <td class="jphone" style="text-align: center" ><?php  echo  round($xkwkj['p_y_price']-$rankuser['price'], 2) ?></td>
                                        <td class="floor zhuli_c" style="text-align: center" ><?php  echo $rankuser['price'] ; ?></td>
                                    </tr>
                                    <?php 
                                    }
                                ?>

                                    </tbody>
                                </table>
                            </section>


                            <section id="shelp" style="display: none">
                                <table class="wx_list" cellspacing="0">
                                    <tbody>
                                    <tr class="btitle">
                                        <td class="order" style="text-align: center">帮砍昵称</td>
                                        <td class="order" style="text-align: center" >帮砍头像</td>
                                        <td class="author" style="text-align: center">砍掉金额</td>
                                    </tr>

                                    <?php 
                                    for ($index = 0; $index <count($friends); $index++) {
                                        $friend = $friends[$index];
                                      ?>
                                    <tr class=" ">





                                        <td class="author"  style="text-align: center" ><?php   echo $friend['user_name'];  ?></td>
                                        <td class="author" style="text-align: center" ><img src="<?php   echo $friend['avatar'];  ?>" height="30px;" width="30px"></td>
                                        <td class="floor zhuli_c" style="text-align: center" ><?php  echo  $friend['amount'] ?></td>



                                    </tr>

                                    <?php 
                                         }
                                    ?>

                                    </tbody>
                                </table>
                            </section>


                        </section>
                    </article>
                </div>
            </div>

        </div>
    </div>


</main>



<footer class="footer" style="background: transparent">
    <div class="mask-transparent none"></div>
    <div class="mask-black none">
        <div class="share-text"></div>
    </div>
</footer>




<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('shotmenu', TEMPLATE_INCLUDEPATH)) : (include template('shotmenu', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('templates/default3/foot', TEMPLATE_INCLUDEPATH)) : (include template('templates/default3/foot', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('follow', TEMPLATE_INCLUDEPATH)) : (include template('follow', TEMPLATE_INCLUDEPATH));?>

<script src="<?php echo MON_XKWKJ_RES;?>template/mobile/templates/default2/js/main.js" type="text/javascript" type="text/javascript"></script>

<script>
    $(function(){

    });


    function join() {

        <?php  if($xkwkj['join_follow_enable']==1) { ?>
            var follow = <?php  echo $follow;?>;
            if (follow == 1) {
                showFollow(true);
            } else {
                window.top.location.href ="<?php  echo MonUtil::str_murl($this->createMobileUrl ( 'auth',array('kid'=>$xkwkj['id'],'au'=>Value::$REDIRECT_USER_INDEX, 'fu'=> $au ),true))?>";
            }

       <?php  } else { ?>
             window.top.location.href ="<?php  echo MonUtil::str_murl($this->createMobileUrl ( 'auth',array('kid'=>$xkwkj['id'],'au'=>Value::$REDIRECT_USER_INDEX, 'fu'=> $au),true))?>";
       <?php  } ?>
   }


</script>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('gmusic', TEMPLATE_INCLUDEPATH)) : (include template('gmusic', TEMPLATE_INCLUDEPATH));?>
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=9&c=utility&a=visit&do=showjs&m=mon_xkwkj"></script></body>


<script>

    $(function() {


        $("#m01").click(function(){
                    $(this).addClass("on");
                    $("#m02").removeClass("on");
                    $("#srank").show();
                    $("#shelp").hide();
                }
        );

        $("#m02").click(function(){
                    $(this).addClass("on");
                    $("#m01").removeClass("on");

                    $("#srank").hide();
                    $("#shelp").show();

                }
        );

    });

    function tipMsg(txt){
        swal({
                    title: "提示",
                    text: txt,
                    type: "warning",
                    showCancelButton: false,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "确定",
                    closeOnConfirm: true },
                function(){

                });
    }


</script>
</html>