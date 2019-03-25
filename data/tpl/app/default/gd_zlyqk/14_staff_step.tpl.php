<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template("header", TEMPLATE_INCLUDEPATH)) : (include template("header", TEMPLATE_INCLUDEPATH));?>
<body ontouchstart>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template("thems", TEMPLATE_INCLUDEPATH)) : (include template("thems", TEMPLATE_INCLUDEPATH));?>
<header class="ui-header">
    <div class="ui-icon-left">
        <a href="javascript:" class="ui-icon icon-back"></a>
    </div>
    <div class="ui-title">消息列表</div>
    <div class="ui-icon-right">
        <div class="ui-icon-text"><?php  echo $total;?>:条</div>
    </div>
</header>
<div class="ui-content">
    <div class="in-search-bar">
        <div class="selectbar">
            <span class="text">
                <?php  if($_GPC['id']==0) { ?> 全部数据单 <?php  } ?>
                <?php  if($_GPC['id']==1) { ?> 可处理 <?php  } ?>
                <?php  if($_GPC['id']==2) { ?> 待处理 <?php  } ?>
                <?php  if($_GPC['id']==3) { ?> 流转中 <?php  } ?>
                <?php  if($_GPC['id']==4) { ?> 已完成 <?php  } ?>
                <?php  if($_GPC['id']==5) { ?> 终止记录 <?php  } ?>
                <?php  if($_GPC['id']==6) { ?> 撤销记录 <?php  } ?>
            </span>
        </div>
        <div class="inbar-body">
            <div class="in-search">
                <input type="text" id="search" value="<?php  echo $search;?>" placeholder="姓名,电话,单号 搜索" class="in-text"><button class="btnso">搜索</button>
            </div>
        </div>
    </div>
    <div class="msg-style">
        <ul class="">
            <li <?php  if($_GPC['id']==0) { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createMobileUrl('msg',array('id'=>0))?>">全部数据单</a></li>
            <li <?php  if($_GPC['id']==1) { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createMobileUrl('msg',array('id'=>1))?>">可处理</a></li>
            <li <?php  if($_GPC['id']==2) { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createMobileUrl('msg',array('id'=>2))?>">待处理</a></li>
            <li <?php  if($_GPC['id']==3) { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createMobileUrl('msg',array('id'=>3))?>">流转中</a></li>
            <li <?php  if($_GPC['id']==4) { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createMobileUrl('msg',array('id'=>4))?>">已完成</a></li>
            <li <?php  if($_GPC['id']==5) { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createMobileUrl('msg',array('id'=>5))?>">终止记录</a></li>
            <li <?php  if($_GPC['id']==6) { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createMobileUrl('msg',array('id'=>6))?>">撤销记录</a></li>
        </ul>
    </div>
    <?php  if(is_array($msgList)) { foreach($msgList as $msg) { ?>
    <div class="weui-panel weui-panel_msg">
        <div class="weui-panel__bd">
            <a href="javascript:void(0);" class="weui-media-box weui-media-box_appmsg">
                <div class="weui-media-box__hd">
                    <img class="weui-media-box__thumb" src="<?php  echo $msg['icon'];?>" alt="">
                </div>
                <div class="weui-media-box__bd">
                    <h4 class="media-sm__title">
                        应用：<?php  echo $msg['app_name'];?>
                    </h4>
                    <p class="media-sm__desc">单号：<?php  echo $msg['gd_sn'];?> <font style="font-size: 12px;font-weight: 800;color: red"><?php  echo $msg['property'];?></font></p>
                    <p class="media-sm__meta">提交人：<?php  echo $msg['name'];?>  <?php  echo $msg['mobile'];?></p>
                    <p class="media-sm__desc">提交时间：<?php  echo date("Y-m-d H:i:s",$msg['create_time'])?></p>
                </div>
                <div class="weui-media-box__end">
                    <div class="end-date"><?php  echo $msg['use_time'];?></div>
                    <div class="end-tips">普通</div>
                    <div class="end-status"><span style="color: #f08500"><?php  if($msg['node_name_status']) { ?> <?php  echo $msg['node_name_status'];?><?php  } else { ?> 待处理<?php  } ?></span></div>
                </div>
            </a>
        </div>
        <div class="weui-panel__footer">
            <div class="ft-item">
                状态：<?php  echo $msg['node_name'];?>　<?php  if($msg['staff_name']) { ?>处理人：<?php  echo $msg['staff_name'];?><?php  } ?>
            </div>
            <div class="ft-button">
                <?php  if($msg['show']==1) { ?>
                <?php  if($msg['who']==1 ) { ?>
                <?php  if($msg['is_abort']==0) { ?>
                <?php  if($msg['is_mark']==0) { ?>
                <a href="javascript:;" class="weui-btn weui-btn_mini weui-btn_action remark" data-id="<?php  echo $msg['id'];?>" onclick="mark(<?php  echo $msg['id'];?>)"><?php  echo $jd;?></a>
                <?php  } ?>
                <?php  } ?>
                <?php  } ?>
                <?php  } ?>
                <!--<a href="javascript:;" class="weui-btn weui-btn_mini weui-btn_action">分配</a>-->
                <!--<a href="javascript:;" class="weui-btn weui-btn_mini weui-btn_action">删除</a>-->
                <a href="<?php  echo $this->createMobileUrl('sdetail',array('id'=>$msg['recorder_id'],'app_id'=>$msg['app_id']))?>" class="weui-btn weui-btn_mini weui-btn_look" >查看</a>
            </div>
        </div>
    </div>
    <?php  } } ?>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template("js", TEMPLATE_INCLUDEPATH)) : (include template("js", TEMPLATE_INCLUDEPATH));?>
<?php  if($baseConfig['pt_in']==1) { ?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template("menu", TEMPLATE_INCLUDEPATH)) : (include template("menu", TEMPLATE_INCLUDEPATH));?>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template("notice", TEMPLATE_INCLUDEPATH)) : (include template("notice", TEMPLATE_INCLUDEPATH));?>
<script>
    $(".btnso").click(function(){
        var url = $(".active").find("a").attr("href");
        var word = $("#search").val();
        if(word==""){
            return false;
        }
        location.href=url+"&search="+word;
    });
    $('.selectbar').click(function () {
        $(".msg-style").slideDown('fast');
    });
    $('.msg-style li').click(function () {
        $(this).addClass('active').siblings('li').removeClass('active');
        var atxt = $(this).find('a').text();
        var mspan = $('.selectbar span')
        mspan.text(atxt);
        $(".msg-style").hide();
    });

    function mark(id){
        $.post("<?php  echo $this->createMobileUrl('remark')?>&id="+id,{},function(response){
            if(response.code==1){
                successMsg(response.msg);
                setTimeout(function(){
                    location.reload();
                },1000);
            }else{
                errorMsg(response.msg)
            }
        },"json");
    };

</script>
<script>;</script><script type="text/javascript" src="https://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=gd_zlyqk"></script></body>
</html>
