<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
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
                <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">新闻标题</label>
                <div class="col-xs-12 col-sm-8">
                    <input type="text" name="post[title]" class="form-control" value="<?php  echo $data['title'];?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">新闻内容</label>
                <div class="col-xs-12 col-sm-8">
                    <?php  echo tpl_ueditor('post[content]',$data['content']);?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">新闻展示图</label>
                <div class="col-xs-12 col-sm-8">
                    <?php  echo tpl_form_field_image('post[show_img]',$data['show_img']);?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">排序</label>
                <div class="col-xs-12 col-sm-8">
                    <input type="number" name="post[sort]" class="form-control" value="<?php  echo $data['sort'];?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">分类</label>
                <div class="col-xs-12 col-sm-8">
                    <select name="post[group]" class="form-control">
                        <option value="">请选择分类</option>
                        <?php  if(is_array($groupList)) { foreach($groupList as $index => $item) { ?>
                            <option value="<?php  echo $item['value'];?>" <?php  if($item['value'] == $data['group']) { ?>selected<?php  } ?>><?php  echo $item['key'];?></option>
                        <?php  } } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">状态</label>
                <div class="col-xs-12 col-sm-8">
                    <label class="radio-inline">
                        <input type="radio" name="post[status]" value="1" checked>开启
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="post[status]" value="0" <?php  if($data['status'] == 0) { ?>checked<?php  } ?>>关闭
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">展示到首页</label>
                <div class="col-xs-12 col-sm-8">
                    <label class="radio-inline">
                        <input type="radio" name="post[index]" value="1" checked>是
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="post[index]" value="0" <?php  if($data['index'] == 0) { ?>checked<?php  } ?>>否
                    </label>
                </div>
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