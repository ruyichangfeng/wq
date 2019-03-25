<?php defined('IN_IA') or exit('Access Denied');?>﻿<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>

<div class="main">
    <form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php  echo $items['id'];?>" />
        <div class="panel panel-default">
            <div class="panel-heading">
                基本设置
            </div>
            <div class="panel-body">

                <!--<div style="display:none" class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">系统名称</label>
                    <div class="col-sm-7 col-xs-12">
                        <input type="text" name="aname" class="form-control" value="<?php  echo $items['aname'];?>" />
                    </div>
                </div>
                <div style="display:none"  class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">系统标题</label>
                    <div class="col-sm-7 col-xs-12">
                        <input type="text" name="title" class="form-control" value="<?php  echo $items['title'];?>" />
                    </div>
                </div>-->
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">首页背景图</label>
                    <div class="col-sm-7 col-xs-12">
                         <?php  echo tpl_form_field_image('background_images', $items['background_images'])?>
                        <span class="help-block">大小建议1024X604</span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">LOGO</label>
                    <div class="col-sm-7 col-xs-12">
                        <?php  echo tpl_form_field_image('logo', $items['logo'])?>
                        <span class="help-block">大小建议128X128</span>
                    </div>
                </div>
                
                 <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">图标颜色</label>
                    <div class="col-sm-7 col-xs-12">
                       <?php  echo tpl_form_field_color('button_color', $items['button_color'])?>
                    </div>
                </div>
                
                 <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">公告文字颜色</label>
                    <div class="col-sm-7 col-xs-12">
                       <?php  echo tpl_form_field_color('link_color', $items['link_color'])?>
                    </div>
                </div>
                
                 <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">导航文字颜色</label>
                    <div class="col-sm-7 col-xs-12">
                       <?php  echo tpl_form_field_color('link_color1', $items['link_color1'])?>
                    </div>
                </div>
                
                
                 <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">图标左</label>
                    <div class="col-sm-7 col-xs-12">
                        <?php  echo tpl_form_field_image('nav_icon', $items['nav_icon'])?>
                        <span class="help-block">大小建议64X64 </span>  <span class="help-block" style="color: red;">&nbsp;(留空则默认)</span>
                    </div>
                </div>
                
                 <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">图标左文字</label>
                    <div class="col-sm-7 col-xs-12">
                       <input type="text"  name="nav_link" class="form-control"  value="<?php  echo $items['nav_link'];?>" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">图标左链接</label>
                    <div class="col-sm-7 col-xs-12">
                        <?php  echo tpl_form_field_link('nav_url',$items['nav_url']);?>
                        <span class="help-block"></span>

                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">图标右</label>
                    <div class="col-sm-7 col-xs-12">
                        <?php  echo tpl_form_field_image('tel_icon', $items['tel_icon'])?>
                        <span class="help-block">大小建议64X64</span> <span class="help-block" style="color: red">&nbsp;(留空则默认)</span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">图标右文字</label>
                    <div class="col-sm-7 col-xs-12">
                       <input type="text"  name="tel_link" class="form-control"  value="<?php  echo $items['tel_link'];?>" />
                    </div>
                </div>
                
                 <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">联系电话</label>
                    <div class="col-sm-7 col-xs-12">
                 <!--      <?php  echo tpl_form_field_link('tel_url',$items['tel_url']);?>-->
                          <input type="text"  name="tel_url" class="form-control"  value="<?php  echo $items['tel_url'];?>" />
                       <!-- <span class="help-block"></span>-->

                    </div>
                </div>
                
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">版权模块</label>
                    <div class="col-sm-7 col-xs-12">
                       <input type="text"  name="copyright" class="form-control"  value="<?php  echo $items['copyright'];?>" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">公告内容</label>
                    <div class="col-sm-7 col-xs-12">
                       <textarea  name="context" class="form-control"  value="<?php  echo $items['context'];?>" ><?php  echo $items['context'];?></textarea>
                    </div>
                </div>
                
                 <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">标题1</label>
                    <div class="col-sm-7 col-xs-12">
                       <input type="text"  name="title1" class="form-control"  value="<?php  echo $items['title1'];?>" />
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">标题2</label>
                    <div class="col-sm-7 col-xs-12">
                       <input type="text"  name="title2" class="form-control"  value="<?php  echo $items['title2'];?>" />
                    </div>
                </div>
                
                 <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">自定义标题</label>
                    <div class="col-sm-7 col-xs-12">
                       <input type="text"  name="top_title" class="form-control"  value="<?php  echo $items['top_title'];?>" />
                    </div>
                </div>
                
     
                
                  <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">消息模板底部提示</label>
                    <div class="col-sm-7 col-xs-12">
                       <input type="text"  name="reply_color" class="form-control"  value="<?php  echo $items['reply_color'];?>" />

                    </div>
                </div>
                
                 <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">管理消息模板跳转</label>
                    <div class="col-sm-7 col-xs-12">
                       <input type="text"  name="reply_url" class="form-control"  value="<?php  echo $items['reply_url'];?>" />

                    </div>
                </div>
                
                 <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">客户消息模板跳转</label>
                    <div class="col-sm-7 col-xs-12">
                       <input type="text"  name="news_url" class="form-control"  value="<?php  echo $items['news_url'];?>" />

                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">分享标题</label>
                    <div class="col-sm-7 col-xs-12">
                       <input type="text"  name="share_title" class="form-control"  value="<?php  echo $items['share_title'];?>" />

                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">分享内容</label>
                    <div class="col-sm-7 col-xs-12">
                       <input type="text"  name="share_context" class="form-control"  value="<?php  echo $items['share_context'];?>" />

                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">分享头像</label>
                    <div class="col-sm-7 col-xs-12">
                    	 <?php  echo tpl_form_field_image('share_logo', $items['share_logo'])?>
                    <!--   <input type="text"  name="share_logo" class="form-control"  value="<?php  echo $items['share_logo'];?>" />-->
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                    <div class="col-sm-9 col-xs-12">
                        <input name="submit" type="submit" value="提交" class="btn btn-primary span3"> 
                        <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                        <input type="hidden" name="id" value="<?php  echo $items['id'];?>" />
                    </div>
                </div>

                </form>
            </div>