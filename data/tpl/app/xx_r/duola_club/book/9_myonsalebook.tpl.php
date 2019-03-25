<?php defined('IN_IA') or exit('Access Denied');?><!--正文导航-->
<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black"/>
    <meta content="telephone=no" name="format-detection" />
    <style>
        body > a:first-child,body > a:first-child img{ width: 0px !important; height: 0px !important; overflow: hidden; position: absolute}
        body{padding-bottom: 0 !important;}
        .weui-navbar__item span{
            display: block;
        }
        .tt a{display: inline-block;height:20px;padding: 0 0 0 15px;}
    </style>
    <meta id="viewport" name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0">
    <title><?php  echo $data['school']['title'];?></title>
    <link rel="stylesheet" href="<?php echo MODULE_URL;?>public/mobile/css/weixin.css">
    <link rel="stylesheet" href="<?php echo MODULE_URL;?>public/mobile/css/jAlert.css">
    <link type="text/css" rel="stylesheet" href="<?php echo OSSURL;?>public/mobile/css/greenStyle.css?v=4.60120" />
    <link rel="stylesheet" href="<?php echo MODULE_URL;?>public/mobile/css/weui.min.css">
    <link rel="stylesheet" href="<?php echo OSSURL;?>public/mobile/css/resetnew.css">
    <link rel="stylesheet" href="<?php echo MODULE_URL;?>template/mobile/style/css/weui.css">
    <script src="http://libs.baidu.com/jquery/1.10.2/jquery.min.js"></script>
    <script src="<?php echo OSSURL;?>public/mobile/js/tx.js"></script>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <script type="text/javascript" src="<?php echo OSSURL;?>public/mobile/js/PromptBoxUtil.js?v=4.80309"></script>
    <script src="<?php echo MODULE_URL;?>public/mobile/js/zepto.min.js"></script>
    <script type="text/javascript" src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <script src="<?php echo MODULE_URL;?>public/mobile/js/weui.min.js"></script>
    <?php  echo register_jssdk();?>
</head>
<body>
<div class="page">
    <div class="page__hd" style="padding-bottom: 65px;">
        <div class="weui-tab">
            <div class="weui-navbar" style="position: fixed;z-index: 10000">
                <div class="weui-navbar__item" style="color: #FFF;background-color: #1071b7;">
                    <a href="#">
                        <span>我的闲书库</span>
                        <span><?php  echo $data['userAccount']['onSaleAmount'];?></span>
                    </a>
                </div>
                <div class="weui-navbar__item" style="color: #FFF;background-color: #1071b7;">
                    <a href="#">
                        <span style="display: inline-block">我的闲书币</span>
                        <span><?php  echo $data['balance'];?></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="page__bd">
        <div class="weui-panel weui-panel_access">
            <div class="weui-panel__hd">上架闲书列表</div>
            <div class="weui-panel__bd">
                <?php  if(is_array($data['data']['onSaleBooks'])) { foreach($data['data']['onSaleBooks'] as $item) { ?>
                <a href="javascript:void(0);" class="weui-media-box weui-media-box_appmsg">
                    <div class="weui-media-box__hd">
                        <img class="weui-media-box__thumb" src="<?php  echo $item['images_medium'];?>" alt="">
                    </div>
                    <div class="weui-media-box__bd">
                        <h4 class="weui-media-box__title"><?php  echo $item['title'];?></h4>
                        <ul class="weui-media-box__info" style="margin-top: 0px;">
                            <li class="weui-media-box__info__meta"><?php  echo $item['author'];?></li>
                            <li class="weui-media-box__info__meta">￥<?php  echo $item['price'];?></li>
                        </ul>
                        <p style="text-overflow:ellipsis;white-space:nowrap;overflow:hidden;width:200px;"><?php  echo $item['summary'];?></p>
                    </div>
                </a>
                <div class="tt">
                    <div id="<?php  echo $item['id'];?>jianjie" style="display: none;">
                        <?php  echo $item['summary'];?>
                    </div>
                    <a class="weui-form-preview__btn weui-form-preview__btn_default" href="<?php  echo $this->createMobileUrl('mybook',array('schoolid'=>$data['schoolid'],'bookid' => $item['id'],'owneropenid' => $item['openid'],'op' => 'show_img'))?>">图片</a>
                    <a class="weui-form-preview__btn weui-form-preview__btn_default" data-jAlert data-title="简介" data-content="#<?php  echo $item['id'];?>jianjie" href="#">简介</a>
                    <a class="weui-form-preview__btn weui-form-preview__btn_default" href="<?php  echo $this->createMobileUrl('commentlist',array('schoolid'=>$data['schoolid'],'bookid' => $item['id']))?>">点评</a>
                    <a class="weui-form-preview__btn weui-form-preview__btn_primary" onclick="unSaleBook(this,<?php  echo $item['mybookid'];?>);">点我下架</a>
                </div>
                <?php  } } ?>
            </div>
        </div>
    </div>
    <div class="js_dialog" id="panel1" style="display: none;">
        <div class="weui-mask"></div>
        <div class="weui-dialog" style="width: 95%">
            <div class="weui-dialog__hd"><strong class="weui-dialog__title">温馨提示</strong>
            </div>
            <div class="weui-dialog__bd" id="alert_content">

            </div>
            <div class="weui-dialog__ft">
                <a onclick="hidePanel('panel1');" class="weui-dialog__btn weui-dialog__btn_default" style="color:#353535;">取消下架</a>
                <a href="./index.php?i=9&c=entry&do=index&m=jing_cash&schoolid=<?php  echo $data['schoolid'];?>" class="weui-dialog__btn weui-dialog__btn_default" style="color:#353535;">押金增额</a>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?php echo OSSURL;?>public/mobile/js/PromptBoxUtil.js?v=4.80309"></script>
<script src="<?php echo MODULE_URL;?>/template/mobile/style/js/weui.js" type="text/javascript"></script>
<script type="text/javascript">
    var PB = new PromptBox();
    $("#closed").on('click',function(){
        $("#bookCart").hide();
    });
    function hidePanel(id) {
        $("#"+id).hide();
    }
    //闲书下架
    function unSaleBook(obj,id){
        var submitData = {
            schoolid : "<?php  echo $data['schoolid'];?>",
            weid     : "<?php  echo $data['weid'];?>",
            openid   : "<?php  echo $data['openid'];?>",
            id       : id,
        };
        Weui.confirm({"title":"确定下架?","content":'',"cancelCallback":function(e){
        },"sureCallback":function(e){
            $.post("<?php  echo $this->createMobileUrl('myonsalebook',array('op'=>'unsale'))?>", submitData, function (data) {
                if (data.result) {
//                    Weui.alert(data.msg);
                    window.location.href = "<?php  echo $this->createMobileUrl('myonsalebook', array('schoolid' => $data['schoolid'],'status' => 2), true)?>";
                } else {
                    if(data.errorCode == 2){
                       $("#panel1").show();
                       document.getElementById('alert_content').innerHTML='小主,您需补足'+data.amount+'闲书币，方可下架剩余书。';
                    }else{
                        Weui.alert(data.msg);
                    }
                }
            }, 'json');
        }
        });
    }
</script>
<?php  include $this->template('footer');?>
<script src="<?php echo MODULE_URL;?>public/mobile/js/jAlert.js"></script>
<script src="<?php echo MODULE_URL;?>public/mobile/js/jAlert-functions.js"></script>
<script>
    $(document).ready(function(e) {
        $("#wrap").css("min-height", $(document).height());
        $.jAlert('attach');
    });
</script>
<script type="text/javascript">
    $(function() {

        WeixinJSShowShareMenu();

        WeixinJSShowProfileMenuAndShare();

        wx.ready(function () {
            sharedata = {
                title: "<?php  echo $data['data']['mcInfo']['nickname'];?>的已上架书库",
                desc: "<?php  echo $data['data']['content'];?>",
                link: "<?php  echo $data['data']['links'];?>",
                imgUrl: "<?php  echo $data['data']['imgUrl'];?>",
                success: function(){

                },
                cancel: function(){

                }
            };
            sharedata1 = {
                title: "<?php  echo $data['data']['mcInfo']['nickname'];?>的已上架书库",
                desc: "<?php  echo $data['data']['content'];?>",
                link: "<?php  echo $data['data']['links'];?>",
                imgUrl: "<?php  echo $data['data']['imgUrl'];?>",
                success: function(){

                },
                cancel: function(){

                }
            };
            wx.onMenuShareAppMessage(sharedata);
            wx.onMenuShareTimeline(sharedata1);
        });

    });

    function WeixinJSShowShareMenu(){
        if (typeof wx != "undefined"){
            wx.ready(function () {
                wx.showMenuItems({
                    menuList: ['menuItem:share:appMessage','menuItem:share:timeline'] // 要显示的菜单项，所有menu项见附录3
                });
            });
        }
    }


    function WeixinJSShowProfileMenuAndShare(){

        if (typeof wx != "undefined"){
            wx.ready(function () {
                wx.showMenuItems({
                    menuList: ['menuItem:share:appMessage','menuItem:share:timeline','menuItem:profile','menuItem:addContact','menuItem:favorite'] // 要显示的菜单项，所有menu项见附录3
                });
            });
        }
    }
</script>
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=9&c=utility&a=visit&do=showjs&m=duola_club"></script></body>
</html>