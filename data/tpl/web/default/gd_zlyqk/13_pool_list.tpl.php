<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template("base/child_header", TEMPLATE_INCLUDEPATH)) : (include template("base/child_header", TEMPLATE_INCLUDEPATH));?>
<style>
    .panel_word{width:100%;margin-bottom: 5px;margin-top:5px;color: white;}
    .panel{min-width: 14.2% !important;}
</style>
<?php  if($st_id!=100) { ?>
<div class="panel_box row">
    <div class="panel col"  style="width: 16.5%;">
        <a  href="javascript:click('all_data')"  data-url="<?php  echo $this->createWebUrl('list',array('tb'=>'pool'))?>&status=-1&ac=all_plan" style="background-color:#FF5722!important">
            <div class="panel_word newMessage">
                <span><?php  echo intval($total['0'])?></span>
                <cite>可处理</cite>
            </div>
        </a>
    </div>
    <div class="panel col"  style="width: 16.5%;">
        <a  href="javascript:click('wait_data')"  class="open_mn" data-url="<?php  echo $this->createWebUrl('list',array('tb'=>'pool'))?>&status=5&ac=wait_plan" style="background-color:#FFB800!important">
            <div class="panel_word newMessage">
                <span><?php  echo intval($total['5'])?></span>
                <cite>待处理</cite>
            </div>
        </a>
    </div>
    <div class="panel col" style="width: 16.5%;" >
        <a   href="javascript:click('end_data')"  class="open_mn" data-url="<?php  echo $this->createWebUrl('list',array('tb'=>'pool'))?>&status=10&ac=fi_plan" style="background-color:#009688!important;">
            <div class="panel_word imgAll">
                <span><?php  echo intval($total['10'])?></span>
                <cite>已处理</cite>
            </div>
        </a>
    </div>
    <!--<div class="panel col" style="width: 16.5%;" >-->
        <!--<a  href="javascript:click('doing_data')"  class="open_mn" data-url="<?php  echo $this->createWebUrl('list',array('tb'=>'pool'))?>&status=1&ac=do_plan" style="background-color:#2F4056!important;">-->
            <!--<div class="panel_word imgAll">-->
                <!--<span><?php  echo intval($total['1'])?></span>-->
                <!--<cite>处理中</cite>-->
            <!--</div>-->
        <!--</a>-->
    <!--</div>-->
    <div class="panel col" style="width: 16.5%;" >
        <a  href="javascript:click('abort_data')"   class="open_mn" data-url="<?php  echo $this->createWebUrl('list',array('tb'=>'pool'))?>&status=6&ac=end_plan" style="background-color:#1E9FFF!important">
            <div class="panel_word userAll" >
                <span><?php  echo intval($total['6'])?></span>
                <cite>已终止</cite>
            </div>
        </a>
    </div>
    <div class="panel col" style="width: 16.5%;" >
        <a  href="javascript:click('fina_data')"  class="open_mn" data-url="<?php  echo $this->createWebUrl('list',array('tb'=>'pool'))?>&status=2&ac=fina_plan" style="background-color:#393D49!important">
            <div class="panel_word userAll" >
                <span><?php  echo intval($total['2'])?></span>
                <cite>已完成</cite>
            </div>
        </a>
    </div>
</div>
<?php  } ?>
<form  class="layui-form">
<blockquote class="layui-elem-quote" style="padding-top:2px;padding-bottom: 2px;">
    <div class="layui-inline">
        <div class="layui-input-inline" style="width: 100px;padding-bottom: 3px;">
            <select name="city" id="app" lay-verify="required" style="">
                <option value="0">所有应用</option>
                <?php  if(is_array($appList)) { foreach($appList as $ak => $item) { ?>
                <option value="<?php  echo $ak;?>" <?php  if($ak==$_GPC['app']) { ?>selected<?php  } ?>><?php  echo $item;?></option>
                <?php  } } ?>
            </select>
        </div>
        <div class="layui-input-inline" style="width: 100px;padding-bottom: 3px;">
            <select name="city" id="category"  lay-verify="required">
                <option value="0">所有分类</option>
                <?php  if(is_array($categoryList)) { foreach($categoryList as $ck => $item) { ?>
                <option value="<?php  echo $ck;?>" <?php  if($ck==$_GPC['category']) { ?>selected<?php  } ?>><?php  echo $item;?></option>
                <?php  } } ?>
            </select>
        </div>
        <div class="layui-input-inline" style="width: 100px;padding-bottom: 3px;">
            <input type="text" value="<?php  echo $_GPC['gd_sn'];?>" id="gd_sn" placeholder="单号搜索" class="layui-input search_input">
        </div>
        <div class="layui-input-inline" style="width: 100px;padding-bottom: 3px;">
            <input type="text" value="<?php  echo $_GPC['name'];?>" id="name" placeholder="提交人搜索" class="layui-input search_input">
        </div>
        <div class="layui-input-inline" style="width: 100px;padding-bottom: 3px;">
            <input type="text" value="<?php  echo $_GPC['mobile'];?>" id="mobile" placeholder="电话搜索" class="layui-input search_input">
        </div>
        <div class="layui-input-inline" style="width: 100px;padding-bottom: 3px;">
            <input class="layui-input start" name="start" value="<?php  echo $_GPC['start'];?>" placeholder="起始日期" id="LAY_demorange_s">
        </div>
        <div class="layui-input-inline "  style="width: 100px;padding-bottom: 3px;">
            <input class="layui-input end" name="end" value="<?php  echo $_GPC['end'];?>" placeholder="结束日期" id="LAY_demorange_e">
        </div>
        <a class="layui-btn" lay-submit lay-filter="search">搜索</a>
        <a class="layui-btn pool_excel" lay-submit  style="margin-left: 3px;">综合导出</a>
        <a class="layui-btn app_excel" lay-submit  style="margin-left: 3px;">应用导出</a>
        <?php  if($barMenu['delete']) { ?>
        <a class="layui-btn layui-btn-danger batchDel" style="margin-left: 3px;">删除</a>
        <?php  } ?>
    </div>
</blockquote>
</form>
<?php  if($st_id==-1) { ?>
<div class="layui-form news_list" style="width: 100%;overflow: scroll">
    <table class="layui-table"  style="min-width: 1700px;" >
    <colgroup>
        <col width="50">
        <col width="100">
        <col width="100">
        <col width="80">
        <col width="80">
        <col width="120">
        <col width="100">
        <col width="100">
        <col width="210">
        <col width="100">
        <col width="100">
        <col width="100">
        <col>
    </colgroup>
    <thead>
    <tr>
        <th><input type="checkbox" name="" lay-skin="primary" lay-filter="allChoose" id="allChoose"></th>
        <th>单号</th>
        <th>应用</th>
        <th>流程状态</th>
        <th>耗时</th>
        <th>数据提交人</th>
        <th>电话</th>
        <th>提交时间</th>
        <th>员工操作</th>
        <th>节点</th>
        <th>操作状态</th>
    </tr>
    </thead>
    <tbody class="news_content">
    <?php  if(is_array($dataList)) { foreach($dataList as $recorder) { ?>
    <tr>
        <td>
            <input type="checkbox" name="checked" value="<?php  echo $recorder['id'];?>" lay-skin="primary" lay-filter="choose">
            <div class="layui-unselect layui-form-checkbox" lay-skin="primary">
                <i class="layui-icon"></i>
            </div>
        </td>
        <td><?php  echo $recorder['gd_sn'];?></td>
        <td><?php  echo $recorder['app_name'];?></td>
        <td style="color:<?php  echo $recorder['color'];?>"><?php  echo $recorder['recorder_status'];?></td>
        <td><?php  echo $recorder['use_time'];?></td>
        <td><?php  echo $recorder['name'];?></td>
        <td><?php  echo $recorder['mobile'];?></td>
        <td><?php  echo date("Y-m-d H:i:s",$recorder['create_time'])?></td>
        <td>
            <?php  if($st_id==-1) { ?>
            <?php  if($barMenu['mark']) { ?>
            <?php  if($_GPC['__api']) { ?>
            <a class="layui-btn layui-btn-mini layui-bg-cyan do_mark"  data-id="<?php  echo $recorder['id'];?>" data-app="<?php  echo $recorder['app_id'];?>">接单</a>
            <?php  } ?>
            <?php  } ?>
            <?php  if($barMenu['sep']) { ?>
            <a class="layui-btn  layui-btn layui-btn-normal layui-btn-mini do_give" data-id="<?php  echo $recorder['id'];?>" data-app="<?php  echo $recorder['app_id'];?>">分配</a>
            <?php  if($recorder['staff_list']=="") { ?>
            <a class="layui-btn layui-btn-mini layui-bg-cyan edit_user"  data-id="<?php  echo $recorder['id'];?>" data-app="<?php  echo $recorder['app_id'];?>" title="修改提交人">归属</a>
            <?php  } ?>
            <?php  } ?>
            <?php  } ?>
            <?php  if($st_id==5) { ?>
            <?php  if($barMenu['doi']) { ?>
            <a class="layui-btn  layui-btn-warm layui-btn-mini doing"  data-id="<?php  echo $recorder['id'];?>" data-app="<?php  echo $recorder['app_id'];?>">处理</a>
            <?php  } ?>
            <?php  if($barMenu['sep']) { ?>
            <a class="layui-btn  layui-btn layui-btn-normal layui-btn-mini do_give"  data-id="<?php  echo $recorder['id'];?>" data-app="<?php  echo $recorder['app_id'];?>">分配</a>
            <?php  } ?>
            <?php  } ?>
            <?php  if($barMenu['edit']) { ?>
            <a class="layui-btn  layui-btn-danger layui-btn-mini news_edit" data-id="<?php  echo $recorder['recorder_id'];?>" data-app="<?php  echo $recorder['app_id'];?>">查看</a>
            <?php  } ?>
            <?php  if($barMenu['delete']) { ?>
            <a class="layui-btn layui-btn-danger layui-btn-mini news_del" data-id="<?php  echo $recorder['id'];?>" data-app="<?php  echo $recorder['app_id'];?>">删除</a>
            <?php  } ?>
        </td>
        <td><?php  echo $recorder['node_name'];?></td>
        <td><?php  echo $recorder['node_status'];?></td>
    </tr>
    <?php  } } ?>
    </tbody>
    </table>
</div>
<div id="page"></div>
<?php  } ?>

<?php  if($st_id==5) { ?>
<div class="layui-form news_list" style="width: 100%;overflow: scroll">
    <table class="layui-table" style="min-width: 1900px;" >
    <colgroup>
        <col width="50">
        <col width="120">
        <col width="100">
        <col width="100">
        <col width="100">
        <col width="120">
        <col width="120">
        <col width="160">
        <col width="210">
        <col width="100">
        <col width="100">
        <col width="100">
        <col>
    </colgroup>
    <thead>
    <tr>
        <th><input type="checkbox" name="" lay-skin="primary" lay-filter="allChoose" id="allChoose"></th>
        <th>单号</th>
        <th>应用</th>
        <th>流程状态</th>
        <th>耗时</th>
        <th>数据提交人</th>
        <th>电话</th>
        <th>提交时间</th>
        <th>员工操作</th>
        <th>节点</th>
        <th>节点状态</th>
        <th>操作状态</th>
        <th>处理时间</th>
        <th>处理人</th>
    </tr>
    </thead>
    <tbody class="news_content">
    <?php  if(is_array($dataList)) { foreach($dataList as $recorder) { ?>
    <tr>
        <td>
            <input type="checkbox" name="checked" value="<?php  echo $recorder['id'];?>" lay-skin="primary" lay-filter="choose">
            <div class="layui-unselect layui-form-checkbox" lay-skin="primary">
                <i class="layui-icon"></i>
            </div>
        </td>
        <td><?php  echo $recorder['gd_sn'];?></td>
        <td><?php  echo $recorder['app_name'];?></td>
        <td style="color:<?php  echo $recorder['color'];?>"><?php  echo $recorder['recorder_status'];?></td>
        <td><?php  echo $recorder['use_time'];?></td>
        <td><?php  echo $recorder['name'];?></td>
        <td><?php  echo $recorder['mobile'];?></td>
        <td><?php  echo date("Y-m-d H:i:s",$recorder['create_time'])?></td>
        <td>
            <?php  if($st_id==-1) { ?>
            <?php  if($barMenu['mark']) { ?>
            <?php  if($_GPC['__api']) { ?>
            <a class="layui-btn layui-btn-mini layui-bg-cyan do_mark"  data-id="<?php  echo $recorder['id'];?>" data-app="<?php  echo $recorder['app_id'];?>">接单</a>
            <?php  } ?>
            <?php  } ?>
            <?php  if($barMenu['sep']) { ?>
            <a class="layui-btn  layui-btn layui-btn-normal layui-btn-mini do_give" data-id="<?php  echo $recorder['id'];?>" data-app="<?php  echo $recorder['app_id'];?>">分配</a>
            <?php  } ?>
            <?php  } ?>
            <?php  if($st_id==5) { ?>
            <?php  if($barMenu['doi']) { ?>
            <a class="layui-btn  layui-btn-warm layui-btn-mini doing"  data-id="<?php  echo $recorder['id'];?>" data-app="<?php  echo $recorder['app_id'];?>">处理</a>
            <?php  } ?>
            <?php  if($barMenu['sep']) { ?>
            <a class="layui-btn  layui-btn layui-btn-normal layui-btn-mini do_give"  data-id="<?php  echo $recorder['id'];?>" data-app="<?php  echo $recorder['app_id'];?>">分配</a>
            <?php  } ?>
            <?php  } ?>
            <?php  if($barMenu['edit']) { ?>
            <a class="layui-btn  layui-btn-danger layui-btn-mini news_edit" data-id="<?php  echo $recorder['recorder_id'];?>" data-app="<?php  echo $recorder['app_id'];?>">查看</a>
            <?php  } ?>
            <?php  if($barMenu['delete']) { ?>
            <a class="layui-btn layui-btn-danger layui-btn-mini news_del" data-id="<?php  echo $recorder['id'];?>" data-app="<?php  echo $recorder['app_id'];?>">删除</a>
            <?php  } ?>
        </td>
        <td><?php  echo $recorder['node_name'];?></td>
        <td><?php  echo $recorder['node_name_status'];?></td>
        <td><?php  echo $recorder['node_status'];?></td>
        <td><?php  if($recorder['mark_time'] ) { ?><?php  echo date("Y-m-d H:i:s",$recorder['mark_time'])?><?php  } ?></td>
        <td><?php  echo $recorder['staff_name'];?></td>
    </tr>
    <?php  } } ?>
    </tbody>
    </table>
</div>
<div id="page"></div>
<?php  } ?>

<?php  if($st_id==3) { ?>
<div class="layui-form news_list" style="width: 100%;overflow: scroll">
    <table class="layui-table" style="min-width: 1800px;">
    <colgroup>
        <col width="50">
        <col width="160">
        <col width="160">
        <col width="150">
        <?php  if($st_id!=100) { ?>
        <col width="170">
        <?php  } ?>
        <col width="120">
        <col width="170">
        <col width="220">
        <col width="250">
        <?php  if($st_id!=100) { ?>
        <col width="120">
        <col width="120">
        <col width="120">
        <col width="220">
        <col width="120">
        <?php  } ?>
        <col width="220">
    </colgroup>
    <thead>
    <tr>
        <th><input type="checkbox" name="" lay-skin="primary" lay-filter="allChoose" id="allChoose"></th>
        <th>单号</th>
        <th>应用</th>
        <th>流程状态</th>
        <?php  if($st_id!=100) { ?>
        <th>耗时</th>
        <?php  } ?>
        <th>数据提交人</th>
        <th>电话</th>
        <th>提交时间</th>
        <th>员工操作</th>
        <?php  if($st_id!=100) { ?>
        <th>节点</th>
        <th>节点状态</th>
        <th>操作状态</th>
        <th>处理时间</th>
        <th>处理人</th>
        <?php  } ?>
        <th>取消时间</th>
    </tr>
    </thead>
    <tbody class="news_content">
    <?php  if(is_array($dataList)) { foreach($dataList as $recorder) { ?>
    <tr>
        <td>
            <input type="checkbox" name="checked" value="<?php  echo $recorder['id'];?>" lay-skin="primary" lay-filter="choose">
            <div class="layui-unselect layui-form-checkbox" lay-skin="primary">
                <i class="layui-icon"></i>
            </div>
        </td>
        <td><?php  echo $recorder['gd_sn'];?></td>
        <td><?php  echo $recorder['app_name'];?></td>
        <td style="color:<?php  echo $recorder['color'];?>"><?php  echo $recorder['recorder_status'];?></td>
        <?php  if($st_id!=100) { ?>
        <td><?php  echo $recorder['use_time'];?></td>
        <?php  } ?>
        <td><?php  echo $recorder['name'];?></td>
        <td><?php  echo $recorder['mobile'];?></td>
        <td><?php  echo date("Y-m-d H:i:s",$recorder['create_time'])?></td>
        <td>
            <?php  if($st_id==-1) { ?>
            <?php  if($barMenu['mark']) { ?>
            <?php  if($_GPC['__api']) { ?>
            <a class="layui-btn layui-btn-mini layui-bg-cyan do_mark"  data-id="<?php  echo $recorder['id'];?>" data-app="<?php  echo $recorder['app_id'];?>">接单</a>
            <?php  } ?>
            <?php  } ?>
            <?php  if($barMenu['sep']) { ?>
            <a class="layui-btn  layui-btn layui-btn-normal layui-btn-mini do_give" data-id="<?php  echo $recorder['id'];?>" data-app="<?php  echo $recorder['app_id'];?>">分配</a>
            <?php  } ?>
            <?php  } ?>
            <?php  if($st_id==5) { ?>
            <?php  if($barMenu['doi']) { ?>
            <a class="layui-btn  layui-btn-warm layui-btn-mini doing"  data-id="<?php  echo $recorder['id'];?>" data-app="<?php  echo $recorder['app_id'];?>">处理</a>
            <?php  } ?>
            <?php  if($barMenu['sep']) { ?>
            <a class="layui-btn  layui-btn layui-btn-normal layui-btn-mini do_give"  data-id="<?php  echo $recorder['id'];?>" data-app="<?php  echo $recorder['app_id'];?>">分配</a>
            <?php  } ?>
            <?php  } ?>
            <?php  if($barMenu['edit']) { ?>
            <a class="layui-btn  layui-btn-danger layui-btn-mini news_edit" data-id="<?php  echo $recorder['recorder_id'];?>" data-app="<?php  echo $recorder['app_id'];?>">查看</a>
            <?php  } ?>
            <?php  if($barMenu['delete']) { ?>
            <a class="layui-btn layui-btn-danger layui-btn-mini news_del" data-id="<?php  echo $recorder['id'];?>" data-app="<?php  echo $recorder['app_id'];?>">删除</a>
            <?php  } ?>
        </td>
        <?php  if($st_id!=100) { ?>
        <td><?php  echo $recorder['node_name'];?></td>
        <td><?php  echo $recorder['node_name_status'];?></td>
        <td><?php  echo $recorder['node_status'];?></td>
        <td><?php  if($recorder['mark_time'] ) { ?><?php  echo date("Y-m-d H:i:s",$recorder['mark_time'])?><?php  } ?></td>
        <td><?php  echo $recorder['staff_name'];?></td>
        <?php  } ?>
        <td><?php  if($recorder['cancel_time'] ) { ?><?php  echo date("Y-m-d H:i:s",$recorder['cancel_time'])?><?php  } ?></td>
    </tr>
    <?php  } } ?>
    </tbody>
    </table>
</div>
<?php  } ?>

<?php  if($st_id==1) { ?>
<div class="layui-form news_list" style="width: 100%;overflow: scroll">
    <table class="layui-table"style="min-width: 1700px;">
    <colgroup>
        <col width="50">
        <col width="160">
        <col width="160">
        <col width="150">
        <?php  if($st_id!=100) { ?>
        <col width="170">
        <?php  } ?>
        <col width="140">
        <col width="170">
        <col width="220">
        <col width="250">
        <?php  if($st_id!=100) { ?>
        <col width="120">
        <col width="120">
        <col width="120">
        <col width="220">
        <col width="120">
        <?php  } ?>
    </colgroup>
    <thead>
    <tr>
        <th><input type="checkbox" name="" lay-skin="primary" lay-filter="allChoose" id="allChoose"></th>
        <th>单号</th>
        <th>应用</th>
        <th>流程状态</th>
        <?php  if($st_id!=100) { ?>
        <th>耗时</th>
        <?php  } ?>
        <th>数据提交人</th>
        <th>电话</th>
        <th>提交时间</th>
        <th>员工操作</th>
        <?php  if($st_id!=100) { ?>
        <th>节点</th>
        <th>节点状态</th>
        <th>操作状态</th>
        <th>处理时间</th>
        <th>处理人</th>
        <?php  } ?>
    </tr>
    </thead>
    <tbody class="news_content">
    <?php  if(is_array($dataList)) { foreach($dataList as $recorder) { ?>
    <tr>
        <td>
            <input type="checkbox" name="checked" value="<?php  echo $recorder['id'];?>" lay-skin="primary" lay-filter="choose">
            <div class="layui-unselect layui-form-checkbox" lay-skin="primary">
                <i class="layui-icon"></i>
            </div>
        </td>
        <td><?php  echo $recorder['gd_sn'];?></td>
        <td><?php  echo $recorder['app_name'];?></td>
        <td style="color:<?php  echo $recorder['color'];?>"><?php  echo $recorder['recorder_status'];?></td>
        <?php  if($st_id!=100) { ?>
        <td><?php  echo $recorder['use_time'];?></td>
        <?php  } ?>
        <td><?php  echo $recorder['name'];?></td>
        <td><?php  echo $recorder['mobile'];?></td>
        <td><?php  echo date("Y-m-d H:i:s",$recorder['create_time'])?></td>
        <td>
            <?php  if($st_id==-1) { ?>
            <?php  if($barMenu['mark']) { ?>
            <?php  if($_GPC['__api']) { ?>
            <a class="layui-btn layui-btn-mini layui-bg-cyan do_mark"  data-id="<?php  echo $recorder['id'];?>" data-app="<?php  echo $recorder['app_id'];?>">接单</a>
            <?php  } ?>
            <?php  } ?>
            <?php  if($barMenu['sep']) { ?>
            <a class="layui-btn  layui-btn layui-btn-normal layui-btn-mini do_give" data-id="<?php  echo $recorder['id'];?>" data-app="<?php  echo $recorder['app_id'];?>">分配</a>
            <?php  } ?>
            <?php  } ?>
            <?php  if($st_id==5) { ?>
            <?php  if($barMenu['doi']) { ?>
            <a class="layui-btn  layui-btn-warm layui-btn-mini doing"  data-id="<?php  echo $recorder['id'];?>" data-app="<?php  echo $recorder['app_id'];?>">处理</a>
            <?php  } ?>
            <?php  if($barMenu['sep']) { ?>
            <a class="layui-btn  layui-btn layui-btn-normal layui-btn-mini do_give"  data-id="<?php  echo $recorder['id'];?>" data-app="<?php  echo $recorder['app_id'];?>">分配</a>
            <?php  } ?>
            <?php  } ?>
            <?php  if($barMenu['edit']) { ?>
            <a class="layui-btn  layui-btn-danger layui-btn-mini news_edit" data-id="<?php  echo $recorder['recorder_id'];?>" data-app="<?php  echo $recorder['app_id'];?>">查看</a>
            <?php  } ?>
            <?php  if($barMenu['delete']) { ?>
            <a class="layui-btn layui-btn-danger layui-btn-mini news_del" data-id="<?php  echo $recorder['id'];?>" data-app="<?php  echo $recorder['app_id'];?>">删除</a>
            <?php  } ?>
        </td>
        <?php  if($st_id!=100) { ?>
        <td><?php  echo $recorder['node_name'];?></td>
        <td><?php  echo $recorder['node_name_status'];?></td>
        <td><?php  echo $recorder['node_status'];?></td>
        <td><?php  if($recorder['mark_time'] ) { ?><?php  echo date("Y-m-d H:i:s",$recorder['mark_time'])?><?php  } ?></td>
        <td><?php  echo $recorder['staff_name'];?></td>
        <?php  } ?>
    </tr>
    <?php  } } ?>
    </tbody>
    </table>
</div>
<div id="page"></div>
<?php  } ?>

<?php  if($st_id==2) { ?>
<div class="layui-form news_list" style="width: 100%;overflow: scroll">
    <table class="layui-table" <?php  if($st_id==100) { ?> style="min-width: 1600px;" <?php  } else { ?> style="min-width: 2500px;" <?php  } ?>  >
    <colgroup>
        <col width="50">
        <col width="160">
        <col width="160">
        <col width="150">
        <?php  if($st_id!=100) { ?>
        <col width="170">
        <?php  } ?>
        <col width="120">
        <col width="170">
        <col width="200">
        <col width="200">
        <?php  if($st_id!=100) { ?>
        <col width="120">
        <col width="120">
        <col width="120">
        <col width="200">
        <col width="120">
        <?php  } ?>
        <col width="210">
    </colgroup>
    <thead>
    <tr>
        <th><input type="checkbox" name="" lay-skin="primary" lay-filter="allChoose" id="allChoose"></th>
        <th>单号</th>
        <th>应用</th>
        <th>流程状态</th>
        <?php  if($st_id!=100) { ?>
        <th>耗时</th>
        <?php  } ?>
        <th>数据提交人</th>
        <th>电话</th>
        <th>提交时间</th>
        <th>员工操作</th>
        <?php  if($st_id!=100) { ?>
        <th>节点</th>
        <th>节点状态</th>
        <th>操作状态</th>
        <th>处理时间</th>
        <th>处理人</th>
        <?php  } ?>
        <th>完成时间</th>
    </tr>
    </thead>
    <tbody class="news_content">
    <?php  if(is_array($dataList)) { foreach($dataList as $recorder) { ?>
    <tr>
        <td>
            <input type="checkbox" name="checked" value="<?php  echo $recorder['id'];?>" lay-skin="primary" lay-filter="choose">
            <div class="layui-unselect layui-form-checkbox" lay-skin="primary">
                <i class="layui-icon"></i>
            </div>
        </td>
        <td><?php  echo $recorder['gd_sn'];?></td>
        <td><?php  echo $recorder['app_name'];?></td>
        <td style="color:<?php  echo $recorder['color'];?>"><?php  echo $recorder['recorder_status'];?></td>
        <?php  if($st_id!=100) { ?>
        <td><?php  echo $recorder['use_time'];?></td>
        <?php  } ?>
        <td><?php  echo $recorder['name'];?></td>
        <td><?php  echo $recorder['mobile'];?></td>
        <td><?php  echo date("Y-m-d H:i:s",$recorder['create_time'])?></td>
        <td>
            <?php  if($st_id==-1) { ?>
            <?php  if($barMenu['mark']) { ?>
            <?php  if($_GPC['__api']) { ?>
            <a class="layui-btn layui-btn-mini layui-bg-cyan do_mark"  data-id="<?php  echo $recorder['id'];?>" data-app="<?php  echo $recorder['app_id'];?>">接单</a>
            <?php  } ?>
            <?php  } ?>
            <?php  if($barMenu['sep']) { ?>
            <a class="layui-btn  layui-btn layui-btn-normal layui-btn-mini do_give" data-id="<?php  echo $recorder['id'];?>" data-app="<?php  echo $recorder['app_id'];?>">分配</a>
            <?php  } ?>
            <?php  } ?>
            <?php  if($st_id==5) { ?>
            <?php  if($barMenu['doi']) { ?>
            <a class="layui-btn  layui-btn-warm layui-btn-mini doing"  data-id="<?php  echo $recorder['id'];?>" data-app="<?php  echo $recorder['app_id'];?>">处理</a>
            <?php  } ?>
            <?php  if($barMenu['sep']) { ?>
            <a class="layui-btn  layui-btn layui-btn-normal layui-btn-mini do_give"  data-id="<?php  echo $recorder['id'];?>" data-app="<?php  echo $recorder['app_id'];?>">分配</a>
            <?php  } ?>
            <?php  } ?>
            <?php  if($barMenu['edit']) { ?>
            <a class="layui-btn  layui-btn-danger layui-btn-mini news_edit" data-id="<?php  echo $recorder['recorder_id'];?>" data-app="<?php  echo $recorder['app_id'];?>">查看</a>
            <?php  } ?>
            <?php  if($barMenu['delete']) { ?>
            <a class="layui-btn layui-btn-danger layui-btn-mini news_del" data-id="<?php  echo $recorder['id'];?>" data-app="<?php  echo $recorder['app_id'];?>">删除</a>
            <?php  } ?>
        </td>
        <?php  if($st_id!=100) { ?>
        <td><?php  echo $recorder['node_name'];?></td>
        <td><?php  echo $recorder['node_name_status'];?></td>
        <td><?php  echo $recorder['node_status'];?></td>
        <td><?php  if($recorder['mark_time'] ) { ?><?php  echo date("Y-m-d H:i:s",$recorder['mark_time'])?><?php  } ?></td>
        <td><?php  echo $recorder['staff_name'];?></td>
        <?php  } ?>
        <td><?php  if($recorder['source_status']==2) { ?><?php  if($recorder['end_time'] ) { ?><?php  echo date("Y-m-d H:i:s",$recorder['end_time'])?><?php  } ?><?php  } ?></td>
    </tr>
    <?php  } } ?>
    </tbody>
    </table>
</div>
<div id="page"></div>
<?php  } ?>

<?php  if($st_id==6) { ?>
<div class="layui-form news_list" style="width: 100%;overflow: scroll">
    <table class="layui-table" <?php  if($st_id==100) { ?> style="min-width: 1700px;" <?php  } else { ?> style="min-width: 2500px;" <?php  } ?>  >
    <colgroup>
        <col width="50">
        <col width="160">
        <col width="160">
        <col width="150">
        <?php  if($st_id!=100) { ?>
        <col width="170">
        <?php  } ?>
        <col width="120">
        <col width="170">
        <col width="220">
        <col width="250">
        <?php  if($st_id!=100) { ?>
        <col width="120">
        <col width="120">
        <col width="120">
        <col width="220">
        <col width="120">
        <?php  } ?>
        <col width="220">
    </colgroup>
    <thead>
    <tr>
        <th><input type="checkbox" name="" lay-skin="primary" lay-filter="allChoose" id="allChoose"></th>
        <th>单号</th>
        <th>应用</th>
        <th>流程状态</th>
        <?php  if($st_id!=100) { ?>
        <th>耗时</th>
        <?php  } ?>
        <th>数据提交人</th>
        <th>电话</th>
        <th>提交时间</th>
        <th>员工操作</th>
        <?php  if($st_id!=100) { ?>
        <th>节点</th>
        <th>节点状态</th>
        <th>操作状态</th>
        <th>处理时间</th>
        <th>处理人</th>
        <?php  } ?>
        <th>终止时间</th>
    </tr>
    </thead>
    <tbody class="news_content">
    <?php  if(is_array($dataList)) { foreach($dataList as $recorder) { ?>
    <tr>
        <td>
            <input type="checkbox" name="checked" value="<?php  echo $recorder['id'];?>" lay-skin="primary" lay-filter="choose">
            <div class="layui-unselect layui-form-checkbox" lay-skin="primary">
                <i class="layui-icon"></i>
            </div>
        </td>
        <td><?php  echo $recorder['gd_sn'];?></td>
        <td><?php  echo $recorder['app_name'];?></td>
        <td style="color:<?php  echo $recorder['color'];?>"><?php  echo $recorder['recorder_status'];?></td>
        <?php  if($st_id!=100) { ?>
        <td><?php  echo $recorder['use_time'];?></td>
        <?php  } ?>
        <td><?php  echo $recorder['name'];?></td>
        <td><?php  echo $recorder['mobile'];?></td>
        <td><?php  echo date("Y-m-d H:i:s",$recorder['create_time'])?></td>
        <td>
            <?php  if($st_id==-1) { ?>
            <?php  if($barMenu['mark']) { ?>
            <?php  if($_GPC['__api']) { ?>
            <a class="layui-btn layui-btn-mini layui-bg-cyan do_mark"  data-id="<?php  echo $recorder['id'];?>" data-app="<?php  echo $recorder['app_id'];?>">接单</a>
            <?php  } ?>
            <?php  } ?>
            <?php  if($barMenu['sep']) { ?>
            <a class="layui-btn  layui-btn layui-btn-normal layui-btn-mini do_give" data-id="<?php  echo $recorder['id'];?>" data-app="<?php  echo $recorder['app_id'];?>">分配</a>
            <?php  } ?>
            <?php  } ?>
            <?php  if($st_id==5) { ?>
            <?php  if($barMenu['doi']) { ?>
            <a class="layui-btn  layui-btn-warm layui-btn-mini doing"  data-id="<?php  echo $recorder['id'];?>" data-app="<?php  echo $recorder['app_id'];?>">处理</a>
            <?php  } ?>
            <?php  if($barMenu['sep']) { ?>
            <a class="layui-btn  layui-btn layui-btn-normal layui-btn-mini do_give"  data-id="<?php  echo $recorder['id'];?>" data-app="<?php  echo $recorder['app_id'];?>">分配</a>
            <?php  } ?>
            <?php  } ?>
            <?php  if($barMenu['edit']) { ?>
            <a class="layui-btn  layui-btn-danger layui-btn-mini news_edit" data-id="<?php  echo $recorder['recorder_id'];?>" data-app="<?php  echo $recorder['app_id'];?>">查看</a>
            <?php  } ?>
            <?php  if($barMenu['delete']) { ?>
            <a class="layui-btn layui-btn-danger layui-btn-mini news_del" data-id="<?php  echo $recorder['id'];?>" data-app="<?php  echo $recorder['app_id'];?>">删除</a>
            <?php  } ?>
        </td>
        <?php  if($st_id!=100) { ?>
        <td><?php  echo $recorder['node_name'];?></td>
        <td><?php  echo $recorder['node_name_status'];?></td>
        <td><?php  echo $recorder['node_status'];?></td>
        <td><?php  if($recorder['mark_time'] ) { ?><?php  echo date("Y-m-d H:i:s",$recorder['mark_time'])?><?php  } ?></td>
        <td><?php  echo $recorder['staff_name'];?></td>
        <?php  } ?>
        <td><?php  echo date("Y-m-d H:i:s",$recorder['end_time'])?></td>
    </tr>
    <?php  } } ?>
    </tbody>
    </table>
</div>
<div id="page"></div>
<?php  } ?>

<?php  if($st_id==10) { ?>
<div class="layui-form news_list" style="width: 100%;overflow: scroll">
    <table class="layui-table" <?php  if($st_id==100) { ?> style="min-width: 1700px;" <?php  } else { ?> style="min-width: 2500px;" <?php  } ?>  >
        <colgroup>
            <col width="50">
            <col width="160">
            <col width="160">
            <col width="150">
            <?php  if($st_id!=100) { ?>
            <col width="170">
            <?php  } ?>
            <col width="140">
            <col width="170">
            <col width="200">
            <col width="250">
            <?php  if($st_id!=100) { ?>
            <col width="120">
            <col width="120">
            <col width="120">
            <col width="220">
            <col width="120">
            <?php  } ?>
        </colgroup>
        <thead>
        <tr>
            <th><input type="checkbox" name="" lay-skin="primary" lay-filter="allChoose" id="allChoose"></th>
            <th>单号</th>
            <th>应用</th>
            <th>流程状态</th>
            <?php  if($st_id!=100) { ?>
            <th>耗时</th>
            <?php  } ?>
            <th>数据提交人</th>
            <th>电话</th>
            <th>提交时间</th>
            <th>员工操作</th>
            <?php  if($st_id!=100) { ?>
            <th>节点</th>
            <th>节点状态</th>
            <th>操作状态</th>
            <th>处理时间</th>
            <th>处理人</th>
            <?php  } ?>
        </tr>
        </thead>
        <tbody class="news_content">
        <?php  if(is_array($dataList)) { foreach($dataList as $recorder) { ?>
        <tr>
            <td>
                <input type="checkbox" name="checked" value="<?php  echo $recorder['id'];?>" lay-skin="primary" lay-filter="choose">
                <div class="layui-unselect layui-form-checkbox" lay-skin="primary">
                    <i class="layui-icon"></i>
                </div>
            </td>
            <td><?php  echo $recorder['gd_sn'];?></td>
            <td><?php  echo $recorder['app_name'];?></td>
            <td style="color:<?php  echo $recorder['color'];?>"><?php  echo $recorder['recorder_status'];?></td>
            <?php  if($st_id!=100) { ?>
            <td><?php  echo $recorder['use_time'];?></td>
            <?php  } ?>
            <td><?php  echo $recorder['name'];?></td>
            <td><?php  echo $recorder['mobile'];?></td>
            <td><?php  echo date("Y-m-d H:i:s",$recorder['create_time'])?></td>
            <td>
                <?php  if($st_id==-1) { ?>
                <?php  if($barMenu['mark']) { ?>
                <?php  if($_GPC['__api']) { ?>
                <a class="layui-btn layui-btn-mini layui-bg-cyan do_mark"  data-id="<?php  echo $recorder['id'];?>" data-app="<?php  echo $recorder['app_id'];?>">接单</a>
                <?php  } ?>
                <?php  } ?>
                <?php  if($barMenu['sep']) { ?>
                <a class="layui-btn  layui-btn layui-btn-normal layui-btn-mini do_give" data-id="<?php  echo $recorder['id'];?>" data-app="<?php  echo $recorder['app_id'];?>">分配</a>
                <?php  } ?>
                <?php  } ?>
                <?php  if($st_id==5) { ?>
                <?php  if($barMenu['doi']) { ?>
                <a class="layui-btn  layui-btn-warm layui-btn-mini doing"  data-id="<?php  echo $recorder['id'];?>" data-app="<?php  echo $recorder['app_id'];?>">处理</a>
                <?php  } ?>
                <?php  if($barMenu['sep']) { ?>
                <a class="layui-btn  layui-btn layui-btn-normal layui-btn-mini do_give"  data-id="<?php  echo $recorder['id'];?>" data-app="<?php  echo $recorder['app_id'];?>">分配</a>
                <?php  } ?>
                <?php  } ?>
                <?php  if($barMenu['edit']) { ?>
                <a class="layui-btn  layui-btn-danger layui-btn-mini news_edit" data-id="<?php  echo $recorder['recorder_id'];?>" data-app="<?php  echo $recorder['app_id'];?>">查看</a>
                <?php  } ?>
                <?php  if($barMenu['delete']) { ?>
                <a class="layui-btn layui-btn-danger layui-btn-mini news_del" data-id="<?php  echo $recorder['id'];?>" data-app="<?php  echo $recorder['app_id'];?>">删除</a>
                <?php  } ?>
            </td>
            <?php  if($st_id!=100) { ?>
            <td><?php  echo $recorder['node_name'];?></td>
            <td><?php  echo $recorder['node_name_status'];?></td>
            <td><?php  echo $recorder['node_status'];?></td>
            <td><?php  if($recorder['mark_time'] ) { ?><?php  echo date("Y-m-d H:i:s",$recorder['mark_time'])?><?php  } ?></td>
            <td><?php  echo $recorder['staff_name'];?></td>
            <?php  } ?>
        </tr>
        <?php  } } ?>
        </tbody>
    </table>
</div>
<div id="page"></div>
<?php  } ?>

<?php  if($st_id==100) { ?>
<div class="layui-form news_list" style="width: 100%;overflow: scroll">
    <table class="layui-table" <?php  if($st_id==100) { ?> style="min-width: 1400px;" <?php  } else { ?> style="min-width: 2500px;" <?php  } ?>  >
    <colgroup>
        <col width="50">
        <col width="160">
        <col width="160">
        <col width="150">
        <col width="140">
        <col width="170">
        <col width="200">
        <col width="250">
        <col width="200">
        <col width="200">
    </colgroup>
    <thead>
    <tr>
        <th><input type="checkbox" name="" lay-skin="primary" lay-filter="allChoose" id="allChoose"></th>
        <th>单号</th>
        <th>应用</th>
        <th>流程状态</th>
        <th>数据提交人</th>
        <th>电话</th>
        <th>提交时间</th>
        <th>操作</th>
        <th>完成时间</th>
        <th>取消时间</th>
    </tr>
    </thead>
    <tbody class="news_content">
    <?php  if(is_array($dataList)) { foreach($dataList as $recorder) { ?>
    <tr>
        <td>
            <input type="checkbox" name="checked" value="<?php  echo $recorder['id'];?>" lay-skin="primary" lay-filter="choose">
            <div class="layui-unselect layui-form-checkbox" lay-skin="primary">
                <i class="layui-icon"></i>
            </div>
        </td>
        <td><?php  echo $recorder['gd_sn'];?></td>
        <td><?php  echo $recorder['app_name'];?></td>
        <td style="color:<?php  echo $recorder['color'];?>"><?php  echo $recorder['recorder_status'];?></td>
        <td><?php  echo $recorder['name'];?></td>
        <td><?php  echo $recorder['mobile'];?></td>
        <td><?php  echo date("Y-m-d H:i:s",$recorder['create_time'])?></td>
        <td>
            <?php  if($st_id==-1) { ?>
            <?php  if($barMenu['mark']) { ?>
            <?php  if($_GPC['__api']) { ?>
            <a class="layui-btn layui-btn-mini layui-bg-cyan do_mark"  data-id="<?php  echo $recorder['id'];?>" data-app="<?php  echo $recorder['app_id'];?>">接单</a>
            <?php  } ?>
            <?php  } ?>
            <?php  if($barMenu['sep']) { ?>
            <a class="layui-btn  layui-btn layui-btn-normal layui-btn-mini do_give" data-id="<?php  echo $recorder['id'];?>" data-app="<?php  echo $recorder['app_id'];?>">分配</a>
            <?php  } ?>
            <?php  } ?>
            <?php  if($st_id==5) { ?>
            <?php  if($barMenu['doi']) { ?>
            <a class="layui-btn  layui-btn-warm layui-btn-mini doing"  data-id="<?php  echo $recorder['id'];?>" data-app="<?php  echo $recorder['app_id'];?>">处理</a>
            <?php  } ?>
            <?php  if($barMenu['sep']) { ?>
            <a class="layui-btn  layui-btn layui-btn-normal layui-btn-mini do_give"  data-id="<?php  echo $recorder['id'];?>" data-app="<?php  echo $recorder['app_id'];?>">分配</a>
            <?php  } ?>
            <?php  } ?>
            <?php  if($barMenu['edit']) { ?>
            <a class="layui-btn  layui-btn-danger layui-btn-mini news_edit" data-id="<?php  echo $recorder['recorder_id'];?>" data-app="<?php  echo $recorder['app_id'];?>">查看</a>
            <?php  } ?>
            <?php  if($barMenu['delete']) { ?>
            <a class="layui-btn layui-btn-danger layui-btn-mini news_del" data-id="<?php  echo $recorder['id'];?>" data-app="<?php  echo $recorder['app_id'];?>">删除</a>
            <?php  } ?>
        </td>
        <td><?php  if($recorder['source_status']==2) { ?><?php  if($recorder['end_time'] ) { ?><?php  echo date("Y-m-d H:i:s",$recorder['end_time'])?><?php  } ?><?php  } ?></td>
        <td><?php  if($recorder['cancel_time'] ) { ?><?php  echo date("Y-m-d H:i:s",$recorder['cancel_time'])?><?php  } ?></td>
    </tr>
    <?php  } } ?>
    </tbody>
    </table>
</div>
<div id="page"></div>
<?php  } ?>
<script>
    var _this;
    var url;
    var $;
    layui.use(['form','jquery','laypage'], function(){
        var name,mobile,gd_sn,status,start,end,app,category,property;
        var setting =new Object();

        $ = layui.jquery;
        var form = layui.form();

        form.on('submit(search)', function(data){
            name=$("#name").val();
            mobile=$("#mobile").val();
            gd_sn=$("#gd_sn").val();
            status ="<?php  echo $_GPC['status'];?>";
            start=$(".start").val();
            end =$(".end").val();
            app =$("#app").val();
            category =$("#category").val();
            property =$("#property").val();
            url = "<?php  echo $this->createWebUrl('list',array('tb'=>'pool'))?>"+"&mobile="+mobile+"&name="+name+"&status="+status+"&start="+start+"&end="+end+"&gd_sn="+gd_sn+"&app="+app+"&category="+category+"&property="+property+"&ac=<?php  echo $_GPC['ac'];?>";
            location.href=url;
            return false;
        });

        //分页
        setting.cont="page";
        setting.pages="<?php  echo $totalPage;?>";
        setting.curr="<?php  echo $page;?>";
        setting.skip=true;
        setting.hash="page";
        setting.jump=function(obj, first){
            name=$("#name").val();
            mobile=$("#mobile").val();
            gd_sn=$("#gd_sn").val();
            status ="<?php  echo $_GPC['status'];?>";
            start=$(".start").val();
            end =$(".end").val();
            app =$("#app").val();
            category =$("#category").val();
            property =$("#property").val();
            if(first!=true){
                url = "<?php  echo $this->createWebUrl('list',array('tb'=>'pool'))?>"+"&mobile="+mobile+"&name="+name+"&status="+status+"&start="+start+"&end="+end+"&gd_sn="+gd_sn+"&page="+obj.curr+"&app="+app+"&category="+category+"&property="+property+"&ac=<?php  echo $_GPC['ac'];?>";
                window.location.href =url;
            }
        };
        layui.laypage(setting);

        //综合倒出
        $(".pool_excel").click(function(){
            name=$("#name").val();
            mobile=$("#mobile").val();
            gd_sn=$("#gd_sn").val();
            status ="<?php  echo $_GPC['status'];?>";
            start=$(".start").val();
            end =$(".end").val();
            app =$("#app").val();
            category =$("#category").val();
            property =$("#property").val();
            url = "<?php  echo $this->createWebUrl('poolExcel')?>"+"&mobile="+mobile+"&name="+name+"&status="+status+"&start="+start+"&end="+end+"&gd_sn="+gd_sn+"&app="+app+"&category="+category+"&property="+property;
            appDown(url,1,"");
        });

        var lay;
        //应用倒出
        $(".app_excel").click(function(){
            name=$("#name").val();
            start=$(".start").val();
            end =$(".end").val();
            app =$("#app").val();
            if(app==0){
                layer.msg("请选择倒出应用",{icon: 2});
                return false;
            }
            url = "<?php  echo $this->createWebUrl('appExcel')?>"+"&name="+name+"&start="+start+"&end="+end+"&app="+app;
            appDown(url,1,"");
        });

        //下载文件
        function appDown(url,page,table){
            $.post(url,{page:page,table:table},function(response){
                if(response.code==0){
                    setTimeout(function(){
                        lay =layer.msg("正在处第："+page+"页",{
                            time: 20000
                        });
                        appDown(url,response.page,response.table);
                    },1000);
                }else{
                    setTimeout(function() {
                        layer.close(lay);
                        location.href="<?php  echo $this->createWebUrl('fDown')?>&file="+response.csv+"&table="+response.table;
                    },1000);

                }
            },'json');
        }

        //删除操作
        $(".news_del").on("click",function(){
            var _this = $(this);
            layer.confirm('确定删除此信息？',{icon:3, title:'提示信息'},function(index){
                var id =_this.attr("data-id");
                $.post("<?php  echo $this->createWebUrl('delete')?>&tb=pool&id="+id,function(response){
                    layer.msg(response.msg,{icon: response.code});
                    if(response.code==1){
                       _this.parents("tr").remove();
                    }
                },'json');
            });
        });

        //标记操作
        $(".do_mark").click(function(){
            var app=$(this).attr("data-app");
            var id =$(this).attr("data-id");
            _this=$(this);
            $.post("<?php  echo $this->createWebUrl('wMark')?>",{app:app,id:id},function(response){
                layer.msg(response.msg,{icon: response.code});
                setTimeout(function(){
                    if(response.code==1){
                        location.reload();
                    }
                },1000);
            },"json");
        });

        //分配
        $(".do_give").click(function(){
            var app=$(this).attr("data-app");
            var id =$(this).attr("data-id");
            var url="<?php  echo $this->createWebUrl('wGive')?>&app="+app+"&id="+id;
            var index = layui.layer.open({
                title : "分配人员",
                type : 2,
                area : ["530px","85%"],
                content : url
            });
        });

        //修改提交人
        $(".edit_user").click(function(){
            var app=$(this).attr("data-app");
            var id =$(this).attr("data-id");
            var url="<?php  echo $this->createWebUrl('list',array('mode'=>'select','tb'=>'member','tp'=>1))?>&app="+app+"&id="+id;
            var index = layui.layer.open({
                title : "修改提交人",
                type : 2,
                area : ["530px","85%"],
                content : url
            });
        });

        //处理
        $(".doing").click(function(){
            var app=$(this).attr("data-app");
            var id =$(this).attr("data-id");
            var url="<?php  echo $this->createWebUrl('wDoing')?>&app="+app+"&id="+id;
            var index = layui.layer.open({
                title : "处理流程",
                type : 2,
                area : ["600px","98%"],
                content : url
            });
        });

        //详情操作
        $(".news_edit").on("click",function(){
            var id = $(this).attr("data-id");
            var app = $(this).attr("data-app");
            var url = "<?php  echo $this->createWebUrl('viewRecorder')?>&id="+id+"&app_id="+app;
            var index = layui.layer.open({
                title : "查看消息",
                type : 2,
                area : ["750px","98%"],
                content : url
            });
        });
        //批量删除
        $(".batchDel").click(function(){
            var $checkbox = $('.news_list tbody input[type="checkbox"][name="checked"]:checked');
            if($checkbox.is(":checked")){
                layer.confirm('确定删除选中的信息？',{icon:3, title:'提示信息'},function(index){
                    var id="";
                    $checkbox.each(function(){
                        id += (id=="") ? $(this).val() :","+$(this).val();
                    });
                    $.post("<?php  echo $this->createWebUrl('delete')?>&tb=pool&id="+id,function(response){
                        layer.msg(response.msg,{icon: response.code});
                        if(response.code==1){
                            setTimeout(function(){
                                location.reload();
                            },1200);
                        }
                    },'json');
                    layer.msg("删除成功");
                })
            }else{
                layer.msg("请选择需要删除的文章");
            }
        });

        layui.use('laydate', function(){
            var laydate = layui.laydate;

            var start = {
                max: '2099-06-16 23:59:59'
                ,istoday: true
                ,choose: function(datas){
                    end.min = datas;
                    end.start = datas;
                }
            };

            var end = {
                max: '2099-06-16 23:59:59'
                ,istoday: false
                ,choose: function(datas){
                    start.max = datas;
                }
            };

            document.getElementById('LAY_demorange_s').onclick = function(){
                start.elem = this;
                laydate(start);
            };
            document.getElementById('LAY_demorange_e').onclick = function(){
                end.elem = this
                laydate(end);
            };
        });

        //全选
        form.on('checkbox(allChoose)', function(data){
            var child = $(data.elem).parents('table').find('tbody input[type="checkbox"]:not([name="show"])');
            child.each(function(index, item){
                item.checked = data.elem.checked;
            });
            form.render('checkbox');
        });
    });

    function pluginGiveMember(id,name,poolId){
        $.post("<?php  echo $this->createWebUrl('giveMember')?>",{id:id,pool_id:poolId},function(response){
            layer.msg(response.msg);
            if(response.code==1){
                setTimeout(function(){
                    location.reload();
                },1000);
            }
        },"json");
    }


    function click(act){
        parent.click(act);
    }
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template("base/child_footer", TEMPLATE_INCLUDEPATH)) : (include template("base/child_footer", TEMPLATE_INCLUDEPATH));?>