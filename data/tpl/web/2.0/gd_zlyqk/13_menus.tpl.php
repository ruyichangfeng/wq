<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('base/header', TEMPLATE_INCLUDEPATH)) : (include template('base/header', TEMPLATE_INCLUDEPATH));?>
        <!-- 左侧导航 -->
    <div class="layui-side layui-bg-black">
        <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('base/menu', TEMPLATE_INCLUDEPATH)) : (include template('base/menu', TEMPLATE_INCLUDEPATH));?>
    </div>
    <!-- 右侧内容 -->
    <div class="layui-body layui-form" style="bottom:0">
        <div class="layui-tab marg0" lay-filter="bodyTab" id="top_tabs_box">
            <ul class="layui-tab-title top_tab" id="top_tabs">
                <?php  if(empty($appInfo)) { ?>
                <li class="layui-this" lay-id=""><i class="iconfont icon-computer"></i> <cite>添加应用(默认应用)</cite></li>
                <?php  } else if(empty($appInfo['table'])) { ?>
                <li class="layui-this" lay-id=""><i class="iconfont icon-computer"></i> <cite>设计表单(<?php  echo $appInfo['name'];?>)</cite></li>
                <?php  } else { ?>
                <li class="layui-this" lay-id=""><i class="iconfont icon-computer"></i> <cite>数据池列表</cite></li>
                <?php  } ?>
            </ul>
            <ul class="layui-nav closeBox">
                <li class="layui-nav-item">
                    <a href="javascript:;"><i class="iconfont icon-caozuo"></i> 页面操作</a>
                    <dl class="layui-nav-child">
                        <dd><a href="javascript:;" class="closePageOther"><i class="iconfont icon-prohibit"></i> 关闭其他</a></dd>
                        <dd><a href="javascript:;" class="closePageAll"><i class="iconfont icon-guanbi"></i> 关闭全部</a></dd>
                    </dl>
                </li>
            </ul>
            <div class="layui-tab-content clildFrame">
                <div class="layui-tab-item layui-show">
                    <?php  if(empty($appInfo)) { ?>
                    <iframe src="<?php  echo $this->createWebUrl('list',array('tb'=>'app','fresh'=>1))?>"></iframe>
                    <?php  } else if(empty($appInfo['table'])) { ?>
                    <iframe src="<?php  echo $this->createWebUrl('addForm',array('id'=>$appInfo['id'],'fresh'=>1,'de'=>'add'))?>"></iframe>
                    <?php  } else { ?>
                    <iframe src="<?php  echo $this->createWebUrl('list',array('tb'=>'pool'))?>&status=-1&ac=all_plan"></iframe>
                    <?php  } ?>
                </div>
            </div>
        </div>
    </div>
    <div id="notice" style="display: none">
        <h1 style="text-align: center;color:#009688;font-size: 20px;margin-top:50px;"><?php  echo $result['msg'];?></h1>
        <p style="text-align: center;margin-top:10px;font-size:15px;color:#FF5722">如您已购买系统,请联系开发人员</p>
        <?php  if($result['data']=='bad') { ?>
        <p style="text-align: center;margin-top:15px;"><button class="layui-btn js layui-btn-warm layui-btn-xs">解锁</button></p>
        <?php  } else { ?>
        <p style="text-align: center;margin-top:15px;"><a href="javascript:">请尽快处理</a></p>
        <?php  } ?>
    </div>
    <!-- 底部 -->
    <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('base/footer', TEMPLATE_INCLUDEPATH)) : (include template('base/footer', TEMPLATE_INCLUDEPATH));?>
</div>

<!-- 移动导航 -->
<div class="site-tree-mobile layui-hide"><i class="layui-icon">&#xe602;</i></div>
<div class="site-mobile-shade"></div>

<script type="text/javascript" src="<?php echo MODULE_URL;?>/static/admin/layui/layui.js"></script>
<script type="text/javascript" src="<?php echo MODULE_URL;?>/static/admin/js/leftNav.js"></script>
<script type="text/javascript" src="<?php echo MODULE_URL;?>/static/admin/js/index.js"></script>
<script>
    var $,layer;
    var ly;
    var timer;
    layui.use(['jquery','layer'], function(){
        $ = layui.jquery;
        layer = layui.layer;
        <?php  if($notice) { ?>
        var html =$("#notice").html();
        ly=layer.open({
            title : false,
            type : 1,
            area:["500px","250px"],
            content :html
        });
        <?php  } ?>

        <?php  if($baseConfig['doc_help']==1) { ?>
        <?php  if(empty($notice)) { ?>
        var title;
        var url;
        var cat,art;
        $('.doc-help').hover(function(){
            var that = $(this);
            timer = setTimeout(function(){
                cat = that.attr('data-cat');
                art = that.attr('data-art');
                if(art==''){
                    title=cat
                    url='http://bd.k9k.org/index.php?search=分类:'+cat;
                }else{
                   title=art
                   url='http://bd.k9k.org/index.php?search='+title+"&category="+cat;
                }
                $('#help-link').attr("href",url);
                $("#help-title").html(title);
            },300);
        },function(){
            clearTimeout(timer);
        });
        <?php  } ?>
        <?php  } ?>

        $("body").on("click",".js",function(){
            var url="<?php  echo $this->createWebUrl('openLock')?>";
            layer.prompt({title: '系统解锁', formType: 1}, function(pass, index){
                $.post(url,{pass:pass},function(response){
                    layer.close(index);
                    layer.msg(response.msg,{icon: response.code});
                    if(response.code==1){
                        layer.close(ly);
                    }
                },"json");
            });
        });
    });

    function setAdmin(){
        var url = "<?php  echo $this->createWebUrl('setAdmin')?>";
        layer.open({
            title : false,
            type : 2,
            area:["500px","70%"],
            content : url
        });
    }

    //修改密码
    function changePwd(){
        var url = "<?php  echo $this->createWebUrl('setPassword')?>";
        layer.open({
            title : false,
            type : 2,
            area:["500px","300px;"],
            content : url
        });
    }
</script>
</body>
</html>