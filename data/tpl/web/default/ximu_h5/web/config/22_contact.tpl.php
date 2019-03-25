<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
    <link rel="stylesheet" type="text/css" href="<?php  echo $static;?>/css/switch-style.css"/>
    <ul class="we7-page-tab">
        <?php  if(is_array($opList)) { foreach($opList as $index => $item) { ?>
        <?php  if($item['active'] == 1) { ?>
        <li class="active"><?php  echo $item['title'];?></li>
        <?php  } else { ?>
        <li><a href="<?php  echo $item['url'];?>"><?php  echo $item['title'];?></a></li>
        <?php  } ?>
        <?php  } } ?>

    </ul>
    <div class="main">
        <form method="post" class="form-horizontal form" id="form" novalidate="novalidate" >
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">公司名称</label>
                <div class="col-xs-12 col-sm-8">
                    <input type="text" name="post[company]" class="form-control" value="<?php  echo $data['company'];?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">联系电话</label>
                <div class="col-xs-12 col-sm-8">
                    <input type="text" name="post[tel]" class="form-control" value="<?php  echo $data['tel'];?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">联系邮箱</label>
                <div class="col-xs-12 col-sm-8">
                    <input type="text" name="post[email]" class="form-control" value="<?php  echo $data['email'];?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">传真</label>
                <div class="col-xs-12 col-sm-8">
                    <input type="text" name="post[fax]" class="form-control" value="<?php  echo $data['fax'];?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">QQ</label>
                <div class="col-xs-12 col-sm-8">
                    <input type="text" name="post[qq]" class="form-control" value="<?php  echo $data['qq'];?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">微信二维码</label>
                <div class="col-xs-12 col-sm-8">
                    <?php  echo tpl_form_field_image('post[qrcode]',$data['qrcode']);?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">联系地址</label>
                <div class="col-xs-12 col-sm-8">
                    <input type="text" name="post[address]" class="form-control" value="<?php  echo $data['address'];?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">地图坐标</label>
                <div class="col-xs-12 col-sm-5">
                    <input type="text" name="post[map]" class="form-control" value="<?php  echo $data['map'];?>">
                </div>
                <label><a href="http://api.map.baidu.com/lbsapi/getpoint/index.html" target="_blank">点击获取百度地图坐标</a> </label>
            </div>

            
            <div class="form-group">
                <div class="col-xs-12 col-sm-9 col-md-10 col-lg-10 col-sm-offset-3 col-md-offset-2 col-lg-offset-2">
                    <input type="hidden" value="<?php  echo $data['id'];?>" name="post[id]">
                    <input name="submit" type="submit" value="提交" class="btn btn-primary">
                </div>
            </div>
        </form>
    </div>
    <script>
    </script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>