<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
    <li <?php  if($op == 'display') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('sycd', array('op' => 'display'))?>">菜单添加</a></li>
    <li <?php  if($op == 'post') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('sycd', array('op' => 'post'))?>">头条下菜单</a></li>
    <li <?php  if($op == 'content') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('sycd', array('op' => 'content'))?>">菜单链接</a></li>
</ul>
<?php  if($op == "display") { ?>
<div class="pull-right">
    <a href="<?php  echo $this->createWeburl('sycd', array('op'=>'displays'));?>"  class="btn btn-primary we7-padding-horizontal" style="margin-bottom: 20px">添加菜单内容链接</a>
</div>
<form class="form-horizontal" action="" method="post">
    <table class="table we7-table table-hover article-list vertical-middle">
        <tr>
            <td>ID</td>
            <td>标题</td>
            <td>链接</td>
            <td>图标</td>
            <td class="text-right">操作</td>
        </tr>
        <?php  if(is_array($products)) { foreach($products as $item) { ?>
        <tr>
            <td style="width: 100px;">
                <?php  echo $item['id'];?>
            </td>
            <td>
                <?php  echo $item['title'];?>
            </td>
            <td>
                <?php  echo $item['lianjie'];?>
            </td>
            <td style="width: 150px">
                <img src="<?php  echo tomedia($item['img']);?>" width="100px" alt="">
            </td>
            <td class="text-right">
                <a class="btn btn-default btn-sm" href="<?php  echo $this->createWeburl('sycd', array('id' => $item['id'], 'op' =>'displays'))?>" >编辑</a>
                <a class="btn btn-default btn-sm" onclick="return confirm('此操作不可恢复，确认吗？'); return false;" href="<?php  echo $this->createWeburl('sycd', array('id' => $item['id'], 'op' => 'delete'))?>">删除</a>
            </td>
        </tr>
        <?php  } } ?>
    </table>
</form>
<?php  } ?>
<?php  if($op == 'displays') { ?>
<form class="form-horizontal" action="" method="post">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">添加首页菜单</h3>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label for="" class="control-label col-sm-1">标题</label>
                <div class="form-controls col-sm-5" style="margin-left: 75px;">
                    <input type="text" name="title" id="title" value="<?php  echo $item['title'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off">
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">菜单标题</div>
            </div>
            <div class="form-group" style="margin-left: 20px;">
                <label for="" class="control-label col-sm-1">选择内容</label>
                <select name="lianjie" class='control-label col-sm-2' style=" width:300px;margin-left: 45px;padding-top: 2px; padding-left: 25px;";>
                        <?php  if(is_array($lianjie)) { foreach($lianjie as $v) { ?>
                            <option value="<?php  echo $v['lianjie']?>" <?php  if($v['lianjie'] == $item['lianjie']) { ?> selected="selected" <?php  } ?>><?php  echo $v['title']?></option>
                        <?php  } } ?>   
                </select>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-1">图标</label>
                <div class="form-controls col-sm-5" style="margin-left: 75px;">
                    <?php  echo tpl_form_field_image('img', $item['img'])?>
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">上传图标</div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-12">
            <input name="token" type="hidden" value="<?php  echo $_W['token'];?>" />
            <input type="submit" class="btn btn-primary col-lg-1" name="submit" value="提交" style="margin-left: 45%;" />
        </div>
    </div>
</form>
<?php  } ?>
<?php  if($op == 'post') { ?>
<form class="form-horizontal" action="" method="post">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">首页头条下菜单栏设置</h3>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">菜单①内容</label>
                <div class="form-controls col-sm-3">
                    <select name="cd1_lianjie" id="caidan_content1" class="form-control">
                        <?php  if(is_array($lianjie)) { foreach($lianjie as $item) { ?>
                        <option value="<?php  echo $item['lianjie'];?>" <?php  if($item['lianjie']==$items['cd1_lianjie']) { ?>selected<?php  } ?> ><?php  echo $item['title'];?></option>
                        <?php  } } ?>
                    </select>
                </div>
                <label for="" class="control-label col-sm-2" style="margin-right:45px">菜单①名称</label>
                <div class="form-controls col-sm-3 item_type tabbar_img">
                    <input type="text" id="cd1_title" name="cd1_title" value="<?php  echo $items['cd1_title'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">菜单①图标</label>
                <div class="form-controls col-sm-3 item_type tabbar_img">
                    <?php  echo tpl_form_field_image('cd1_img', $items['cd1_img'])?>
                </div>
            </div>
       
            <div class="line"></div>
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">菜单②内容</label>
                <div class="form-controls col-sm-3">
                    <select name="cd2_lianjie" id="caidan_content1" class="form-control">
                        <?php  if(is_array($lianjie)) { foreach($lianjie as $item) { ?>
                        <option value="<?php  echo $item['lianjie'];?>" <?php  if($item['lianjie']==$items['cd2_lianjie']) { ?>selected<?php  } ?> ><?php  echo $item['title'];?></option>
                        <?php  } } ?>
                    </select>
                </div>
                <label for="" class="control-label col-sm-2" style="margin-right:45px">菜单②名称</label>
                <div class="form-controls col-sm-3 item_type tabbar_img">
                    <input type="text" name="cd2_title" value="<?php  echo $items['cd2_title'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">菜单②图标</label>
                <div class="form-controls col-sm-3 item_type tabbar_img">
                    <?php  echo tpl_form_field_image('cd2_img', $items['cd2_img'])?>
                </div>
                
            </div>
            <div class="line"></div>
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">菜单③内容</label>
                <div class="form-controls col-sm-3">
                    <select name="cd3_lianjie" id="caidan_content1" class="form-control">
                        <?php  if(is_array($lianjie)) { foreach($lianjie as $item) { ?>
                        <option value="<?php  echo $item['lianjie'];?>" <?php  if($item['lianjie']==$items['cd3_lianjie']) { ?>selected<?php  } ?> ><?php  echo $item['title'];?></option>
                        <?php  } } ?>
                    </select>
                </div>
                <label for="" class="control-label col-sm-2" style="margin-right:45px">菜单③名称</label>
                <div class="form-controls col-sm-3 item_type tabbar_img">
                    <input type="text" name="cd3_title" value="<?php  echo $items['cd3_title'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">菜单③图标</label>
                <div class="form-controls col-sm-3 item_type tabbar_img">
                    <?php  echo tpl_form_field_image('cd3_img', $items['cd3_img'])?>
                </div>
                
            </div>
        </div>    
    </div>           
     <div class="form-group">
        <div class="col-sm-12">
            <input name="token" type="hidden" value="<?php  echo $_W['token'];?>" />
            <input type="submit" class="btn btn-primary col-lg-1" name="submit" value="提交" style="margin-left: 45%;" />
        </div>
    </div>
</form>
<?php  } ?>
<?php  if($op == "content") { ?>
<div class="alert alert-success" role="alert">
    <p>温馨提示！请按照如下添加链接</p>
    <p>关于我们：/mu_ying/gywm/gywm</p>
    <p>套餐介绍：/mu_ying/tcjg/tcjg</p>
    <p>套餐服务：/mu_ying/tcfw/tcfw</p>
    <p>明星客户：/mu_ying/mxkh/mxkh</p>
    <p>环境介绍：/mu_ying/hjjs/hjjs</p>
    <p>九大服务：/mu_ying/jdfw/jdfw</p>
    <p>常见问题：/mu_ying/cjwt/cjwt</p>
    <p>知识百科：/mu_ying/yzrj/yzrj</p>
</div>
<div class="pull-right">
    <a href="<?php  echo $this->createWeburl('sycd', array('op'=>'contents'));?>"  class="btn btn-primary we7-padding-horizontal" style="margin-bottom: 20px">添加菜单内容链接</a>
</div>

<form class="form-horizontal" action="" method="post">
    <table class="table we7-table table-hover article-list vertical-middle">
        <tr>
            <td>ID</td>
            <td>标题</td>
            <td>链接</td>
            <td class="text-right" style="display: none;">操作</td>
        </tr>
        <?php  if(is_array($products)) { foreach($products as $item) { ?>
        <tr>
            <td style="width: 100px;">
                <?php  echo $item['id'];?>
            </td>
            <td>
                <?php  echo $item['title'];?>
            </td>
            <td>
                <?php  echo $item['lianjie'];?>
            </td>
            <td class="text-right">
                <a class="btn btn-default btn-sm" href="<?php  echo $this->createWeburl('sycd', array('id' => $item['id'], 'op' =>'contents'))?>" >编辑</a>
                <a class="btn btn-default btn-sm" onclick="return confirm('此操作不可恢复，确认吗？'); return false;" href="<?php  echo $this->createWeburl('sycd', array('id' => $item['id'], 'op' => 'dd'))?>">删除</a>
            </td>
        </tr>
        <?php  } } ?>
    </table>
</form>
<?php  } ?>
<?php  if($op == 'contents') { ?>
<form class="form-horizontal" action="" method="post">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">添加首页菜单链接</h3>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label for="" class="control-label col-sm-1">标题</label>
                <div class="form-controls col-sm-5" style="margin-left: 75px;">
                    <input type="text" name="title" id="title" value="<?php  echo $item['title'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off">
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">菜单标题</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-1">菜单链接</label>
                <div class="form-controls col-sm-5" style="margin-left: 75px;">
                    <input type="text" name="lianjie" id="lianjie" value="<?php  echo $item['lianjie'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off">
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">菜单链接</div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-12">
            <input name="token" type="hidden" value="<?php  echo $_W['token'];?>" />
            <input type="submit" class="btn btn-primary col-lg-1" name="submit" value="提交" style="margin-left: 45%;" />
        </div>
    </div>
</form>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>