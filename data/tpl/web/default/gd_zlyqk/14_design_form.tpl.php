<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="author" content="leipi.org">
    <link href="<?php echo MODULE_URL;?>/static/form/Public/css/bootstrap/css/bootstrap.css?2024" rel="stylesheet" type="text/css" />
    <!--[if lte IE 6]>
    <link rel="stylesheet" type="text/css" href="<?php echo MODULE_URL;?>/static/form/Public/css/bootstrap/css/bootstrap-ie6.css?2024">
    <![endif]-->
    <!--[if lte IE 7]>
    <link rel="stylesheet" type="text/css" href="<?php echo MODULE_URL;?>/static/form/Public/css/bootstrap/css/ie.css?2024">
    <![endif]-->
    <link href="<?php echo MODULE_URL;?>/static/form/Public/css/site.css?2024" rel="stylesheet" type="text/css" />
    <style>
        #components{  min-height: 500px; }
        li {list-style: none;float: left;margin-left:5px;}
        ul {margin-left: 0;}
        .popover{top:25px !important;}
        .component{ border: 0 !important;  }
        .popover-content form { margin: 0 auto;  width: 213px;  }
        .popover-content form .btn{ margin-right: 10px  }
        .leipiplugins{  border-radius: 0; }
        #target{background:#f5f5f5 !important;padding-left: 10px;padding-top:10px;}
        .tabbable{width: 275px;}
        .bz p{line-height:20px;margin-top: 5px;margin-bottom: 0;}
    </style>
</head>
<body>
<div class="container">
    <div class="row clearfix" style="margin-top: 25px;">
        <div class="span5" style="width: 400px;margin-left:100px;">
                <div id="build" style="background-size: cover;width: 320px;height: 600px;background: #f5f5f5" >
                    <input type="hidden" name="app_id" id="app_id" value="<?php  echo $appId;?>">
                    <form id="target" class="form-horizontal">
                        <fieldset style="height: 580px;overflow-y: scroll;">
                            <?php  if(is_array($formArr)) { foreach($formArr as $form) { ?>
                            <?php  if($form['type']=='input') { ?>
                            <div class="control-group component" rel="popover" title="<?php  echo $form['label'];?>" trigger="manual"
                                 data-content="
                                      <form class='form'>
                                        <div class='controls'>
                                          <label class='control-label'>控件名称</label> <input type='text' id='orgname'  placeholder='必填项'>
                                          <label class='control-label'>默认值</label> <input type='text' id='orgvalue'  placeholder='默认值'>
                                          <label class='control-label'>默认值函数</label>
                                          <select id='orgfunc'>
                                            <option value=''>--</option>
                                            <option value='_name'>会员姓名</option>
                                            <option value='_mobile'>会员电话</option>
                                            <option value='_staff_name'>员工姓名</option>
                                            <option value='_staff_mobile'>员工电话</option>
                                          </select>
                                          <label class='control-label'>查看权限</label>
                                          <select id='orgsee'>
                                            <option value=0>所有人</option>
                                            <option value=1>员工</option>
                                            <option value=2>同部门</option>
                                            <option value=3>管理员</option>
                                          </select>
                                          <label class='control-label'>必填<input type='checkbox' id='orgrequire' style='margin-left:20px;margin-top:0' <?php  if($form['rq']) { ?> checked <?php  } ?> ></label>
                                          <button class='btn btn-info' type='button'>确定</button><button class='btn btn-danger' type='button'>取消</button>
                                        </div>
                                      </form>"
                            >
                                <label class="control-label leipiplugins-orgname"><?php  echo $form['label'];?></label>
                                <div class="controls">
                                    <input name="leipiNewField" type="text" placeholder="填写<?php  echo $form['label'];?>" title="<?php  echo $form['label'];?>" data-name="<?php  echo $form['py'];?>" data-type="input" value="<?php  echo $form['pl'];?>" data-func="<?php  echo $form['func'];?>" data-see="<?php  echo $form['see'];?>"  data-require="<?php  echo $form['rq'];?>" class="leipiplugins" leipiplugins="text"/>
                                </div>
                            </div>
                            <?php  } ?>
                            <?php  if($form['type']=='mobile') { ?>
                            <div class="control-group component" rel="popover" title="<?php  echo $form['label'];?>" trigger="manual"
                                 data-content="
                                      <form class='form'>
                                        <div class='controls'>
                                          <label class='control-label'>控件名称</label> <input type='text' id='orgname' placeholder='必填项'>
                                          <label class='control-label'>默认值</label> <input type='text' id='orgvalue' placeholder='默认值'>
                                          <label class='control-label'>默认值函数</label>
                                          <select id='orgfunc'>
                                            <option value=''>--</option>
                                            <option value='_name'>会员姓名</option>
                                            <option value='_mobile'>会员电话</option>
                                            <option value='_staff_name'>员工姓名</option>
                                            <option value='_staff_mobile'>员工电话</option>
                                          </select>
                                          <label class='control-label'>查看权限</label>
                                          <select id='orgsee'>
                                            <option value=0>所有人</option>
                                            <option value=1>员工</option>
                                            <option value=2>同部门</option>
                                            <option value=3>管理员</option>
                                          </select>
                                          <label class='control-label'>必填<input type='checkbox' id='orgrequire' style='margin-left:20px;margin-top:0' <?php  if($form['rq']) { ?> checked <?php  } ?>></label>
                                          <button class='btn btn-info' type='button'>确定</button><button class='btn btn-danger' type='button'>取消</button>
                                        </div>
                                      </form>"
                            >
                                <label class="control-label leipiplugins-orgname"><?php  echo $form['label'];?></label>
                                <div class="controls">
                                    <input name="leipiNewField" type="text" placeholder="填写<?php  echo $form['label'];?>" data-func="<?php  echo $form['func'];?>" data-see="<?php  echo $form['see'];?>" data-name="<?php  echo $form['py'];?>" data-type="mobile" data-require="<?php  echo $form['rq'];?>"  value="<?php  echo $form['pl'];?>" title="<?php  echo $form['label'];?>" class="leipiplugins" leipiplugins="text"/>
                                </div>
                            </div>
                            <?php  } ?>
                            <?php  if($form['type']=='number') { ?>
                            <div class="control-group component" rel="popover" title="<?php  echo $form['label'];?>" trigger="manual"
                                 data-content="
                                    <form class='form'>
                                        <div class='controls'>
                                          <label class='control-label'>控件名称</label> <input type='text' id='orgname' placeholder='必填项'>
                                          <label class='control-label'>默认值</label> <input type='text' id='orgvalue' placeholder='默认值'>
                                          <label class='control-label'>查看权限</label>
                                          <select id='orgsee'>
                                            <option value=0>所有人</option>
                                            <option value=1>员工</option>
                                            <option value=2>同部门</option>
                                            <option value=3>管理员</option>
                                          </select>
                                          <label class='control-label'>必填<input type='checkbox' id='orgrequire' style='margin-left:20px;margin-top:0' <?php  if($form['rq']) { ?> checked <?php  } ?>></label>
                                          <hr/>
                                          <button class='btn btn-info' type='button'>确定</button><button class='btn btn-danger' type='button'>取消</button>
                                        </div>
                                      </form>"
                            >
                                <label class="control-label leipiplugins-orgname"><?php  echo $form['label'];?></label>
                                <div class="controls">
                                    <input name="leipiNewField" type="text" placeholder="填写<?php  echo $form['label'];?>" data-func="<?php  echo $form['func'];?>" data-see="<?php  echo $form['see'];?>" data-name="<?php  echo $form['py'];?>" data-require="<?php  echo $form['rq'];?>" data-type="number"  title="<?php  echo $form['label'];?>"  value="<?php  echo $form['pl'];?>" class="leipiplugins" leipiplugins="text"/>
                                </div>
                            </div>
                            <?php  } ?>
                            <?php  if($form['type']=='cac') { ?>
                            <div class="control-group component" rel="popover" title="<?php  echo $form['label'];?>" trigger="manual"
                                 data-content="
                                      <form class='form'>
                                        <div class='controls'>
                                          <label class='control-label'>控件名称</label> <input type='text' id='orgname' placeholder='必填项'>
                                          <label class='control-label'>计算方式</label> <input type='text' id='orgvalue' placeholder='' readonly style='margin-top:10px;'><button class='btn cac_btn' type='button'>编辑</button>
                                          <label class='control-label'>查看权限</label>
                                          <select id='orgsee'>
                                            <option value=0>所有人</option>
                                            <option value=1>员工</option>
                                            <option value=2>同部门</option>
                                            <option value=3>管理员</option>
                                          </select>
                                          <hr/>
                                          <button class='btn btn-info' type='button'>确定</button><button class='btn btn-danger' type='button'>取消</button>
                                        </div>
                                      </form>"
                            >
                                <label class="control-label leipiplugins-orgname"><?php  echo $form['label'];?></label>
                                <div class="controls">
                                    <input name="leipiNewField" type="text" placeholder="填选择计算方式" data-func="<?php  echo $form['func'];?>" data-see="<?php  echo $form['see'];?>" data-require="<?php  echo $form['rq'];?>" data-type="cac" data-name="<?php  echo $form['py'];?>"  title="<?php  echo $form['label'];?>"  value="<?php  echo $form['pl'];?>" class="leipiplugins" leipiplugins="text"/>
                                </div>
                            </div>
                            <?php  } ?>
                            <?php  if($form['type']=='inku') { ?>
                            <div class="control-group component" rel="popover" title="<?php  echo $form['label'];?>" trigger="manual"
                                 data-content="
                                      <form class='form'>
                                        <div class='controls'>
                                          <label class='control-label'>控件名称</label> <input type='text' id='orgname' placeholder='必填项'>
                                          <label class='control-label'>绑定表单</label> <input type='text' class='in_num' id='orgvalue' placeholder='' readonly style='margin-top:10px;'><button class='btn in_button' type='button'>选择</button>
                                          <label class='control-label'>查看权限</label>
                                          <select id='orgsee'>
                                            <option value=0>所有人</option>
                                            <option value=1>员工</option>
                                            <option value=2>同部门</option>
                                            <option value=3>管理员</option>
                                          </select>
                                          <label class='control-label'>必填<input type='checkbox' id='orgrequire' style='margin-left:20px;margin-top:0'></label>
                                          <hr/>
                                          <button class='btn btn-info' type='button'>确定</button><button class='btn btn-danger' type='button'>取消</button>
                                        </div>
                                      </form>"
                            >
                                <label class="control-label leipiplugins-orgname"><?php  echo $form['label'];?></label>
                                <div class="controls">
                                    <input name="leipiNewField" type="text" placeholder="绑定库存表字段" data-func="<?php  echo $form['func'];?>" data-see="<?php  echo $form['see'];?>" data-require="<?php  echo $form['rq'];?>" data-type="inku" data-name="<?php  echo $form['py'];?>"  title="<?php  echo $form['label'];?>"  value="<?php  echo $form['pl'];?>" class="leipiplugins" leipiplugins="text"/>
                                </div>
                            </div>
                            <?php  } ?>
                            <?php  if($form['type']=='outku') { ?>
                            <div class="control-group component" rel="popover" title="<?php  echo $form['label'];?>" trigger="manual"
                                 data-content="
                                      <form class='form'>
                                        <div class='controls'>
                                          <label class='control-label'>控件名称</label> <input type='text' id='orgname' placeholder='必填项'>
                                          <label class='control-label'>绑定表单</label> <input type='text' class='out_num' id='orgvalue' placeholder='' readonly style='margin-top:10px;'><button class='btn out_button' type='button'>选择</button>
                                          <label class='control-label'>查看权限</label>
                                          <select id='orgsee'>
                                            <option value=0>所有人</option>
                                            <option value=1>员工</option>
                                            <option value=2>同部门</option>
                                            <option value=3>管理员</option>
                                          </select>
                                          <label class='control-label'>必填<input type='checkbox' id='orgrequire' style='margin-left:20px;margin-top:0'></label>
                                          <hr/>
                                          <button class='btn btn-info' type='button'>确定</button><button class='btn btn-danger' type='button'>取消</button>
                                        </div>
                                      </form>"
                            >
                                <label class="control-label leipiplugins-orgname"><?php  echo $form['label'];?></label>
                                <div class="controls">
                                    <input name="leipiNewField" type="text" placeholder="绑定库存表字段" data-func="<?php  echo $form['func'];?>" data-see="<?php  echo $form['see'];?>" data-require="<?php  echo $form['rq'];?>" data-type="outku" data-name="<?php  echo $form['py'];?>"  title="<?php  echo $form['label'];?>"  value="<?php  echo $form['pl'];?>" class="leipiplugins" leipiplugins="text"/>
                                </div>
                            </div>
                            <?php  } ?>
                            <?php  if($form['type']=='date') { ?>
                            <div class="control-group component" rel="popover" title="<?php  echo $form['label'];?>" trigger="manual"
                                 data-content="
                                      <form class='form'>
                                        <div class='controls'>
                                          <label class='control-label'>控件名称</label> <input type='text' id='orgname' placeholder='必填项'>
                                          <label class='control-label'>默认值</label> <input type='text' id='orgvalue' placeholder='默认值'>
                                          <label class='control-label'>查看权限</label>
                                          <select id='orgsee'>
                                            <option value=0>所有人</option>
                                            <option value=1>员工</option>
                                            <option value=2>同部门</option>
                                            <option value=3>管理员</option>
                                          </select>
                                          <label class='control-label'>必填<input type='checkbox' id='orgrequire' style='margin-left:20px;margin-top:0' <?php  if($form['rq']) { ?> checked <?php  } ?>></label>
                                          <hr/>
                                          <button class='btn btn-info' type='button'>确定</button><button class='btn btn-danger' type='button'>取消</button>
                                        </div>
                                      </form>"
                            >
                                <label class="control-label leipiplugins-orgname"><?php  echo $form['label'];?></label>
                                <div class="controls">
                                    <input name="leipiNewField" type="text" placeholder="填写<?php  echo $form['label'];?>" data-func="<?php  echo $form['func'];?>" data-see="<?php  echo $form['see'];?>" data-require="<?php  echo $form['rq'];?>" data-name="<?php  echo $form['py'];?>" data-type="date"  title="<?php  echo $form['label'];?>"  value="<?php  echo $form['pl'];?>" class="leipiplugins" leipiplugins="text"/>
                                </div>
                            </div>
                            <?php  } ?>
                            <?php  if($form['type']=='time') { ?>
                            <div class="control-group component" rel="popover" title="<?php  echo $form['label'];?>" trigger="manual"
                                 data-content="
                                      <form class='form'>
                                        <div class='controls'>
                                          <label class='control-label'>控件名称</label> <input type='text' id='orgname' placeholder='必填项'>
                                          <label class='control-label'>默认值</label> <input type='text' id='orgvalue' placeholder='默认值'>
                                          <label class='control-label'>查看权限</label>
                                          <select id='orgsee'>
                                            <option value=0>所有人</option>
                                            <option value=1>员工</option>
                                            <option value=2>同部门</option>
                                            <option value=3>管理员</option>
                                          </select>
                                          <label class='control-label'>必填<input type='checkbox' id='orgrequire' style='margin-left:20px;margin-top:0' <?php  if($form['rq']) { ?> checked <?php  } ?>></label>
                                          <hr/>
                                          <button class='btn btn-info' type='button'>确定</button><button class='btn btn-danger' type='button'>取消</button>
                                        </div>
                                      </form>"
                            >
                                <label class="control-label leipiplugins-orgname"><?php  echo $form['label'];?></label>
                                <div class="controls">
                                    <input name="leipiNewField" type="text" placeholder="填写<?php  echo $form['label'];?>" data-func="<?php  echo $form['func'];?>" data-see="<?php  echo $form['see'];?>" data-require="<?php  echo $form['rq'];?>" data-name="<?php  echo $form['py'];?>" data-type="time"  title="<?php  echo $form['label'];?>"  value="<?php  echo $form['pl'];?>" class="leipiplugins" leipiplugins="text"/>
                                </div>
                            </div>
                            <?php  } ?>
                            <?php  if($form['type']=='textarea') { ?>
                            <div class="control-group component" rel="popover" title="<?php  echo $form['label'];?>" trigger="manual"
                                 data-content="
                                      <form class='form'>
                                        <div class='controls'>
                                          <label class='control-label'>控件名称</label> <input type='text' id='orgname' placeholder='必填项'>
                                          <label class='control-label'>默认值</label> <input type='text' id='orgvalue' placeholder='默认值'>
                                          <label class='control-label'>默认值函数</label>
                                          <select id='orgfunc'>
                                            <option value=''>--</option>
                                            <option value='_name'>会员姓名</option>
                                            <option value='_mobile'>会员电话</option>
                                            <option value='_staff_name'>员工姓名</option>
                                            <option value='_staff_mobile'>员工电话</option>
                                          </select>
                                          <label class='control-label'>查看权限</label>
                                          <select id='orgsee'>
                                            <option value=0>所有人</option>
                                            <option value=1>员工</option>
                                            <option value=2>同部门</option>
                                            <option value=3>管理员</option>
                                          </select>
                                          <label class='control-label'>必填<input type='checkbox' id='orgrequire' style='margin-left:20px;margin-top:0' <?php  if($form['rq']) { ?> checked <?php  } ?>></label>
                                          <hr/>
                                          <button class='btn btn-info' type='button'>确定</button><button class='btn btn-danger' type='button'>取消</button>
                                        </div>
                                      </form>"
                            >
                                <label class="control-label leipiplugins-orgname"><?php  echo $form['label'];?></label>
                                <div class="controls">
                                    <div class="textarea">
                                        <textarea name="leipiNewField" title="<?php  echo $form['label'];?>" placeholder="填写<?php  echo $form['label'];?>" data-func="<?php  echo $form['func'];?>" data-see="<?php  echo $form['see'];?>" data-require="<?php  echo $form['rq'];?>" data-name="<?php  echo $form['py'];?>" data-type="textarea" class="leipiplugins" leipiplugins="textarea"/> <?php  echo $form['pl'];?></textarea>
                                    </div>
                                </div>
                            </div>
                            <?php  } ?>
                            <?php  if($form['type']=='radio') { ?>
                            <div class="control-group component" rel="popover" title="<?php  echo $form['label'];?>" trigger="manual"
                                 data-content="
                                      <form class='form'>
                                        <div class='controls'>
                                          <label class='control-label'>控件名称</label> <input type='text' id='orgname' placeholder='必填项'>
                                          <label class='control-label'>下拉选项</label>
                                          <textarea style='min-height: 150px' id='orgvalue'></textarea>
                                          <p class='help-block'>一行一个选项</p>
                                          <label class='control-label'>查看权限</label>
                                          <select id='orgsee'>
                                            <option value=0>所有人</option>
                                            <option value=1>员工</option>
                                            <option value=2>同部门</option>
                                            <option value=3>管理员</option>
                                          </select>
                                          <label class='control-label'>必填<input type='checkbox' id='orgrequire' style='margin-left:20px;margin-top:0' <?php  if($form['rq']) { ?> checked <?php  } ?>></label>
                                          <hr/>
                                          <button class='btn btn-info' type='button'>确定</button><button class='btn btn-danger' type='button'>取消</button>
                                        </div>
                                      </form>"
                            >
                                <label class="control-label leipiplugins-orgname"><?php  echo $form['label'];?></label>
                                <div class="controls">
                                    <select name="leipiNewField" title="<?php  echo $form['label'];?>" data-func="<?php  echo $form['func'];?>" data-see="<?php  echo $form['see'];?>" data-value="" data-name="<?php  echo $form['py'];?>" data-require="<?php  echo $form['rq'];?>" data-type="radio"  class="leipiplugins" leipiplugins="select">
                                       <?php  if(is_array($form['pl'])) { foreach($form['pl'] as $vl) { ?>
                                        <?php  if($vl !="") { ?>
                                        <option><?php  echo $vl;?></option>
                                        <?php  } ?>
                                       <?php  } } ?>
                                    </select>
                                </div>
                            </div>
                            <?php  } ?>
                            <?php  if($form['type']=='select') { ?>
                            <div class="control-group component" rel="popover" title="<?php  echo $form['label'];?>" trigger="manual"
                                 data-content="
                                      <form class='form'>
                                        <div class='controls'>
                                          <label class='control-label'>控件名称</label> <input type='text' id='orgname' placeholder='必填项'>
                                          <label class='control-label'>下拉选项</label>
                                          <textarea style='min-height: 150px' id='orgvalue'></textarea>
                                          <p class='help-block'>一行一个选项</p>
                                          <label class='control-label'>查看权限</label>
                                          <select id='orgsee'>
                                            <option value=0>所有人</option>
                                            <option value=1>员工</option>
                                            <option value=2>同部门</option>
                                            <option value=3>管理员</option>
                                          </select>
                                          <label class='control-label'>必填<input type='checkbox' id='orgrequire' style='margin-left:20px;margin-top:0' <?php  if($form['rq']) { ?> checked <?php  } ?>></label>
                                          <hr/>
                                          <button class='btn btn-info' type='button'>确定</button><button class='btn btn-danger' type='button'>取消</button>
                                        </div>
                                      </form>"
                            >
                                <label class="control-label leipiplugins-orgname"><?php  echo $form['label'];?></label>
                                <div class="controls">
                                    <select name="leipiNewField" title="<?php  echo $form['label'];?>" data-func="<?php  echo $form['func'];?>" data-see="<?php  echo $form['see'];?>" data-value="" data-name="<?php  echo $form['py'];?>" data-require="<?php  echo $form['rq'];?>" data-type="select"  class="leipiplugins" leipiplugins="select">
                                        <?php  if(is_array($form['pl'])) { foreach($form['pl'] as $vl) { ?>
                                        <?php  if($vl !="") { ?>
                                        <option><?php  echo $vl;?></option>
                                        <?php  } ?>
                                        <?php  } } ?>
                                    </select>
                                </div>
                            </div>
                            <?php  } ?>
                            <?php  if($form['type']=='checkbox') { ?>
                            <div class="control-group component" rel="popover" title="<?php  echo $form['label'];?>" trigger="manual"
                                 data-content="
                                      <form class='form'>
                                        <div class='controls'>
                                          <label class='control-label'>控件名称</label> <input type='text' id='orgname' placeholder='必填项'>
                                          <label class='control-label'>下拉选项</label>
                                          <textarea style='min-height: 150px' id='orgvalue'></textarea>
                                          <p class='help-block'>一行一个选项</p>
                                          <label class='control-label'>查看权限</label>
                                          <select id='orgsee'>
                                            <option value=0>所有人</option>
                                            <option value=1>员工</option>
                                            <option value=2>同部门</option>
                                            <option value=3>管理员</option>
                                          </select>
                                          <label class='control-label'>必填<input type='checkbox' id='orgrequire' style='margin-left:20px;margin-top:0' <?php  if($form['rq']) { ?> checked <?php  } ?>></label>
                                          <hr/>
                                          <button class='btn btn-info' type='button'>确定</button><button class='btn btn-danger' type='button'>取消</button>
                                        </div>
                                      </form>"
                            >
                                <label class="control-label leipiplugins-orgname"><?php  echo $form['label'];?></label>
                                <div class="controls">
                                    <select name="leipiNewField" title="<?php  echo $form['label'];?>" data-func="<?php  echo $form['func'];?>" data-see="<?php  echo $form['see'];?>" data-value="" data-name="<?php  echo $form['py'];?>" data-require="<?php  echo $form['rq'];?>" data-type="checkbox"  class="leipiplugins" leipiplugins="select">
                                        <?php  if(is_array($form['pl'])) { foreach($form['pl'] as $vl) { ?>
                                        <?php  if($vl !="") { ?>
                                        <option><?php  echo $vl;?></option>
                                        <?php  } ?>
                                        <?php  } } ?>
                                    </select>
                                </div>
                            </div>
                            <?php  } ?>
                            <?php  if($form['type']=='photo') { ?>
                            <div class="control-group component" rel="popover" title="<?php  echo $form['label'];?>" trigger="manual"
                                 data-content="
                                      <form class='form'>
                                        <div class='controls'>
                                          <label class='control-label'>控件名称</label> <input type='text' id='orgname' placeholder='必填项'>
                                          <label class='control-label'>照片数</label> <input type='text' id='orgvalue' placeholder='默认值'>
                                          <label class='control-label'>查看权限</label>
                                          <select id='orgsee'>
                                            <option value=0>所有人</option>
                                            <option value=1>员工</option>
                                            <option value=2>同部门</option>
                                            <option value=3>管理员</option>
                                          </select>
                                          <label class='control-label'>必填<input type='checkbox' id='orgrequire' style='margin-left:20px;margin-top:0' <?php  if($form['rq']) { ?> checked <?php  } ?>></label>
                                          <hr/>
                                          <button class='btn btn-info' type='button'>确定</button><button class='btn btn-danger' type='button'>取消</button>
                                        </div>
                                      </form>"
                            >
                                <label class="control-label leipiplugins-orgname"><?php  echo $form['label'];?></label>
                                <div class="controls">
                                    <img src="/addons/gd_zlyqk//static/mobile/images/add.png" style="width: 35px;">
                                    <input name="leipiNewField" type="hidden" title="<?php  echo $form['label'];?>"  data-func="<?php  echo $form['func'];?>" data-see="<?php  echo $form['see'];?>" value="<?php  echo $form['pl'];?>" data-name="<?php  echo $form['py'];?>" data-require="<?php  echo $form['rq'];?>" data-type="photo" class="leipiplugins" leipiplugins="text"/>
                                </div>
                            </div>
                            <?php  } ?>
                            <?php  if($form['type']=='voice') { ?>
                            <div class="control-group component" title="<?php  echo $form['label'];?>" rel="popover"  trigger="manual"
                                 data-content="
                                      <form class='form'>
                                        <div class='controls'>
                                          <label class='control-label'>控件名称</label> <input type='text' id='orgname' placeholder='必填项'>
                                          <label class='control-label'>查看权限</label>
                                          <select id='orgsee'>
                                            <option value=0>所有人</option>
                                            <option value=1>员工</option>
                                            <option value=2>同部门</option>
                                            <option value=3>管理员</option>
                                          </select>
                                          <label class='control-label'>必填<input type='checkbox' id='orgrequire' style='margin-left:20px;margin-top:0'></label>
                                          <hr/>
                                          <button class='btn btn-info' type='button'>确定</button><button class='btn btn-danger' type='button'>取消</button>
                                        </div>
                                      </form>">
                                <label class="control-label leipiplugins-orgname"><?php  echo $form['label'];?></label>
                                <div class="controls">
                                    <input name="leipiNewField" type="hidden"  title="<?php  echo $form['label'];?>" data-func="<?php  echo $form['func'];?>" data-see="<?php  echo $form['see'];?>" data-type="voice"  value="" class="leipiplugins" leipiplugins="text"/>
                                    <img src="/addons/gd_zlyqk//static/mobile/images/voice.png" style="width: 35px;">
                                </div>
                            </div>
                            <?php  } ?>
                            <?php  if($form['type']=='label') { ?>
                            <div class="control-group component" >
                                <label class="control-label leipiplugins-orgname" style="width: 0"></label>
                                <div class="controls" style="margin-left: 5px;">
                                    <input name="leipiNewField" type="hidden" data-func="<?php  echo $form['func'];?>" data-see="<?php  echo $form['see'];?>"  data-type="label" data-require=""  value='<?php  echo htmlspecialchars_decode($form['pl'])?>' title="<?php  echo $form['label'];?>" class="leipiplugins" leipiplugins="text"/>
                                    <label class="lp_lb bz" style="line-height: 40px;"><?php  if($form['pl']) { ?><?php  echo htmlspecialchars_decode($form['pl'])?><?php  } else { ?>备注内容<?php  } ?></label>
                                </div>
                            </div>
                            <?php  } ?>
                            <?php  if($form['type']=='pay') { ?>
                            <div class="control-group component" rel="popover" title="<?php  echo $form['label'];?>" trigger="manual"
                                 data-content="
                                      <form class='form'>
                                        <div class='controls'>
                                          <label class='control-label' style='display:none'>控件名称</label> <input type='text' id='orgname' style='display:none' placeholder='必填项'>
                                          <label class='control-label'>显示格式</label> <input type='text' id='orgvalue' value='' placeholder='默认值'>
                                          <p>#为站位符(例:支付1元)</p>
                                          <hr/>
                                          <button class='btn btn-info' type='button'>确定</button><button class='btn btn-danger' type='button'>取消</button>
                                        </div>
                                      </form>"
                                 >
                                <label class="control-label leipiplugins-orgname"><?php  echo $form['label'];?></label>
                                <div class="controls">
                                    <input name="leipiNewField" type="hidden"  title="<?php  echo $form['label'];?>" data-func="<?php  echo $form['func'];?>" data-see="<?php  echo $form['see'];?>" value="<?php  echo $form['pl'];?>" data-type="pay" data-name="<?php  echo $form['py'];?>" class="leipiplugins" leipiplugins="text"/>
                                    <label class="checkbox" style="padding-top: 5px;">
                                        支付#元
                                    </label>
                                </div>
                            </div>
                            <?php  } ?>
                            <?php  if($form['type']=='price') { ?>
                            <div class="control-group component" rel="popover" title="<?php  echo $form['label'];?>" trigger="manual"
                                 data-content="
                                      <form class='form'>
                                        <div class='controls'>
                                          <label class='control-label'>控件名称</label> <input type='text' id='orgname' placeholder='必填项'>
                                          <label class='control-label'>默认值</label> <input type='text' id='orgvalue' placeholder='默认值'>
                                          <label class='control-label'>查看权限</label>
                                          <select id='orgsee'>
                                            <option value=0>所有人</option>
                                            <option value=1>员工</option>
                                            <option value=2>同部门</option>
                                            <option value=3>管理员</option>
                                          </select>
                                          <label class='control-label'>必填<input type='checkbox' id='orgrequire' style='margin-left:20px;margin-top:0' <?php  if($form['rq']) { ?> checked <?php  } ?>></label>
                                          <p>下一节点支付金额</p>
                                          <hr/>
                                          <button class='btn btn-info' type='button'>确定</button><button class='btn btn-danger' type='button'>取消</button>
                                        </div>
                                      </form>"
                            >
                                <label class="control-label leipiplugins-orgname"><?php  echo $form['label'];?></label>
                                <div class="controls">
                                    <input name="leipiNewField" type="text" placeholder="填写<?php  echo $form['label'];?>" data-func="<?php  echo $form['func'];?>" data-see="<?php  echo $form['see'];?>" data-name="<?php  echo $form['py'];?>" data-type="price" title="<?php  echo $form['label'];?>" data-require="<?php  echo $form['rq'];?>"   value="<?php  echo $form['pl'];?>" class="leipiplugins" leipiplugins="text"/>
                                </div>
                            </div>
                            <?php  } ?>
                            <?php  if($form['type']=='city') { ?>
                            <div class="control-group component" rel="popover" title="<?php  echo $form['label'];?>" trigger="manual"
                                 data-content="
                                     <form class='form'>
                                        <div class='controls'>
                                          <label class='control-label'>控件名称</label> <input type='text' id='orgname' placeholder='必填项'>
                                          <label class='control-label'>默认值</label> <input type='text' id='orgvalue' placeholder='默认值'>
                                          <label class='control-label'>查看权限</label>
                                          <select id='orgsee'>
                                            <option value=0>所有人</option>
                                            <option value=1>员工</option>
                                            <option value=2>同部门</option>
                                            <option value=3>管理员</option>
                                          </select>
                                          <label class='control-label'>必填<input type='checkbox' id='orgrequire' style='margin-left:20px;margin-top:0' <?php  if($form['rq']) { ?> checked <?php  } ?>></label>
                                          <hr/>
                                          <button class='btn btn-info' type='button'>确定</button><button class='btn btn-danger' type='button'>取消</button>
                                        </div>
                                      </form>"
                            >
                                <label class="control-label leipiplugins-orgname"><?php  echo $form['label'];?></label>
                                <div class="controls">
                                    <input name="leipiNewField" type="text" placeholder="选择<?php  echo $form['label'];?>" data-func="<?php  echo $form['func'];?>" data-see="<?php  echo $form['see'];?>" data-name="<?php  echo $form['py'];?>" data-require="<?php  echo $form['rq'];?>" readonly data-type="city"  title="<?php  echo $form['label'];?>"  value="" class="leipiplugins" leipiplugins="text"/>
                                </div>
                            </div>
                            <?php  } ?>
                            <?php  if($form['type']=='local') { ?>
                            <div class="control-group component" rel="popover" title="<?php  echo $form['label'];?>" trigger="manual"
                                 data-content="
                                      <form class='form'>
                                        <div class='controls'>
                                          <label class='control-label'>控件名称</label> <input type='text' id='orgname' placeholder='必填项'>
                                          <label class='control-label'>默认值</label> <input type='text' id='orgvalue' placeholder='默认值'>
                                          <label class='control-label'>查看权限</label>
                                          <select id='orgsee'>
                                            <option value=0>所有人</option>
                                            <option value=1>员工</option>
                                            <option value=2>同部门</option>
                                            <option value=3>管理员</option>
                                          </select>
                                          <hr/>
                                          <button class='btn btn-info' type='button'>确定</button><button class='btn btn-danger' type='button'>取消</button>
                                        </div>
                                      </form>"
                            >
                                <label class="control-label leipiplugins-orgname"><?php  echo $form['label'];?></label>
                                <div class="controls">
                                    <input name="leipiNewField" type="text" data-func="<?php  echo $form['func'];?>" data-see="<?php  echo $form['see'];?>" data-require="" data-type="local" data-name="<?php  echo $form['py'];?>" placeholder="云南省昆明市(自动定位)" title="<?php  echo $form['label'];?>" readonly class="leipiplugins" leipiplugins="text"/>
                                </div>
                            </div>
                            <?php  } ?>
                            <?php  if($form['type']=='map') { ?>
                            <div class="control-group component" rel="popover" title="<?php  echo $form['label'];?>" trigger="manual"
                                 data-content="
                                      <form class='form'>
                                        <div class='controls'>
                                          <label class='control-label'>控件名称</label> <input type='text' id='orgname' placeholder='必填项'>
                                          <label class='control-label'>选取位置</label> <input type='text' class='v_map' id='orgvalue' placeholder='' readonly style='margin-top:10px;'><button class='btn map_btn' type='button'>编辑</button>
                                          <hr/>
                                          <button class='btn btn-info' type='button'>确定</button><button class='btn btn-danger' type='button'>取消</button>
                                        </div>
                                      </form>"
                            >
                                <label class="control-label leipiplugins-orgname"><?php  echo $form['label'];?></label>
                                <div class="controls">
                                    <input name="leipiNewField" type="text" placeholder="位置展示" data-func=""  data-name="<?php  echo $form['py'];?>" data-see="" data-require="" data-type="map"  title="<?php  echo $form['label'];?>"  value="<?php  echo $form['pl'];?>" class="leipiplugins" leipiplugins="text"/>
                                </div>
                            </div>
                            <?php  } ?>
                            <?php  if($form['type']=='point') { ?>
                            <div class="control-group component" rel="popover" title="<?php  echo $form['label'];?>" trigger="manual"
                                 data-content="
                                      <form class='form'>
                                        <div class='controls'>
                                          <label class='control-label'>控件名称</label> <input type='text' id='orgname' placeholder='必填项'>
                                          <label class='control-label'>默认值</label> <input type='text' id='orgvalue' placeholder='默认值'>
                                          <label class='control-label'>查看权限</label>
                                          <select id='orgsee'>
                                            <option value=0>所有人</option>
                                            <option value=1>员工</option>
                                            <option value=2>同部门</option>
                                            <option value=3>管理员</option>
                                          </select>
                                          <label class='control-label'>必填<input type='checkbox' id='orgrequire' style='margin-left:20px;margin-top:0' <?php  if($form['rq']) { ?> checked <?php  } ?>></label>
                                          <p>完成节点可获得积分</p>
                                          <hr/>
                                          <button class='btn btn-info' type='button'>确定</button><button class='btn btn-danger' type='button'>取消</button>
                                        </div>
                                      </form>"
                            >
                                <label class="control-label leipiplugins-orgname"><?php  echo $form['label'];?></label>
                                <div class="controls">
                                    <input name="leipiNewField city" type="text" placeholder="填写<?php  echo $form['label'];?>"  data-func="<?php  echo $form['func'];?>" data-see="<?php  echo $form['see'];?>" data-type="point" data-name="<?php  echo $form['py'];?>" title="<?php  echo $form['label'];?>" data-require=""  value="" class="leipiplugins" leipiplugins="text"/>
                                </div>
                            </div>
                            <?php  } ?>
                            <?php  if($form['type']=='child') { ?>
                            <div class="control-group component" rel="popover" title="<?php  echo $form['label'];?>" trigger="manual"
                                 data-content="
                                      <form class='form'>
                                        <div class='controls'>
                                          <label class='control-label'>控件名称</label> <input type='text' id='orgname' placeholder='必填项'>
                                          <label class='control-label'>可添加数</label> <input type='text' id='orgvalue' >
                                          <label class='control-label'>查看权限</label>
                                          <select id='orgsee'>
                                            <option value=0>所有人</option>
                                            <option value=1>员工</option>
                                            <option value=2>同部门</option>
                                            <option value=3>管理员</option>
                                          </select>
                                          <label class='control-label'>必填<input type='checkbox' id='orgrequire' style='margin-left:20px;margin-top:0'></label>
                                          <hr/>
                                          <button class='btn btn-info' type='button'>确定</button><button class='btn btn-danger' type='button'>取消</button>
                                        </div>
                                      </form>"
                            >
                                <label class="control-label leipiplugins-orgname"><?php  echo $form['label'];?></label>
                                <div class="controls">
                                    <input name="leipiNewField" type="text" placeholder="动态添加列"  data-func="<?php  echo $form['func'];?>" data-see="<?php  echo $form['see'];?>" data-type="child" data-name="<?php  echo $form['py'];?>" title="<?php  echo $form['label'];?>" data-require=""  value="<?php  echo $form['pl'];?>" class="leipiplugins" leipiplugins="text"/>
                                </div>
                            </div>
                            <?php  } ?>
                            <?php  if($form['type']=='sms') { ?>
                            <div class="control-group component"  >
                                <label class="control-label leipiplugins-orgname">手机号码</label>
                                <div class="controls controls-row">
                                    <input name="leipiNewField" type="text" placeholder="填写号码"  value="" style="margin-bottom: 10px;" />
                                </div>
                                <label class="control-label leipiplugins-orgname"><?php  echo $form['label'];?></label>
                                <div class="controls controls-row">
                                    <input name="leipiNewField" type="text" placeholder="验证码" title="<?php  echo $form['label'];?>" data-func="<?php  echo $form['func'];?>" data-see="<?php  echo $form['see'];?>" data-name="<?php  echo $form['py'];?>" data-type="sms"  value="" class="leipiplugins" style="width: 130px;" leipiplugins="text"/>
                                    <button type="button" class="btn">获取</button>
                                </div>
                            </div>
                            <?php  } ?>

                            <?php  if($form['type']=='ld') { ?>
                            <div class="control-group component" rel="popover" title="多级联动" trigger="manual"
                                 data-content="
                                      <form class='form'>
                                        <div class='controls'>
                                          <label class='control-label'>控件名称</label> <input type='text' id='orgname' placeholder='必填项'>
                                          <label class='control-label'>下拉选项</label>
                                          <input style='width:200px;' class='class_ld' id='orgvalue'>
                                          <p class='help-block'><a href='javascript:' class='select_ld'>选择</a></p>
                                          <label class='control-label'>查看权限</label>
                                          <select id='orgsee'>
                                            <option value=0>所有人</option>
                                            <option value=1>员工</option>
                                            <option value=2>同部门</option>
                                            <option value=3>管理员</option>
                                          </select>
                                          <label class='control-label'>必填<input type='checkbox' id='orgrequire' style='margin-left:20px;margin-top:0'></label>
                                          <hr/>
                                          <button class='联动btn btn-info' type='button'>确定</button><button class='btn btn-danger' type='button'>取消</button>
                                        </div>
                                      </form>"
                            >
                                <label class="control-label leipiplugins-orgname"><?php  echo $form['label'];?></label>
                                <div class="controls">
                                    <input name="leipiNewField" type="text" placeholder="请选择" title="<?php  echo $form['label'];?>"  data-func="<?php  echo $form['func'];?>" data-see="<?php  echo $form['see'];?>" data-name="<?php  echo $form['py'];?>"  data-type="ld" value="<?php  echo $form['pl'];?>"   class="leipiplugins" leipiplugins="text"/>
                                </div>
                            </div>
                            <?php  } ?>
                            <?php  } } ?>
                        </fieldset>
                    </form>
                </div>
        </div>
        <div class="span4" style="width: 275px;">
            <div class="tabbable">
                <ul class="nav nav-tabs" id="navtab">
                    <li class="active"><a href="#1" data-toggle="tab">常用控件</a></li>
                    <li class><a href="#2" data-toggle="tab">系统控件</a></li>
                    <li class><a href="#3" data-toggle="tab">数据控件</a></li>
                </ul>
                <form class="form-horizontal" id="components">
                    <fieldset>
                        <div class="tab-content">
                            <div class="tab-pane active" id="1">
                                <div class="control-group component" rel="popover" title="单行文本" trigger="manual"
                                     data-content="
                                      <form class='form'>
                                        <div class='controls'>
                                          <label class='control-label'>控件名称</label> <input type='text' id='orgname'  placeholder='必填项'>
                                          <label class='control-label'>默认值</label> <input type='text' id='orgvalue' placeholder='默认值'>
                                          <label class='control-label'>默认值函数</label>
                                          <select id='orgfunc'>
                                            <option value=''>--</option>
                                            <option value='_name'>会员姓名</option>
                                            <option value='_mobile'>会员电话</option>
                                            <option value='_staff_name'>员工姓名</option>
                                            <option value='_staff_mobile'>员工电话</option>
                                          </select>
                                          <label class='control-label'>查看权限</label>
                                          <select id='orgsee'>
                                            <option value=0>所有人</option>
                                            <option value=1>员工</option>
                                            <option value=2>同部门</option>
                                            <option value=3>管理员</option>
                                          </select>
                                          <label class='control-label'>必填<input type='checkbox' id='orgrequire' style='margin-left:20px;margin-top:0'></label>
                                          <button class='btn btn-info' type='button'>确定</button><button class='btn btn-danger' type='button'>取消</button>
                                        </div>
                                      </form>"
                                >
                                    <label class="control-label leipiplugins-orgname">单行文本</label>
                                    <div class="controls">
                                        <input name="leipiNewField" type="text" placeholder="默认值" title="单行文本" data-func="" data-see="" data-type="input"  data-require="" class="leipiplugins" leipiplugins="text"/>
                                    </div>
                                </div>

                                <div class="control-group component" rel="popover" title="手机号码" trigger="manual"
                                     data-content="
                                      <form class='form'>
                                        <div class='controls'>
                                          <label class='control-label'>控件名称</label> <input type='text' id='orgname' placeholder='必填项'>
                                          <label class='control-label'>默认值</label> <input type='text' id='orgvalue' placeholder='默认值'>
                                          <label class='control-label'>默认值函数</label>
                                          <select id='orgfunc'>
                                            <option value=''>--</option>
                                            <option value='_name'>会员姓名</option>
                                            <option value='_mobile'>会员电话</option>
                                            <option value='_staff_name'>员工姓名</option>
                                            <option value='_staff_mobile'>员工电话</option>
                                          </select>
                                          <label class='control-label'>查看权限</label>
                                          <select id='orgsee'>
                                            <option value=0>所有人</option>
                                            <option value=1>员工</option>
                                            <option value=2>同部门</option>
                                            <option value=3>管理员</option>
                                          </select>
                                          <label class='control-label'>必填<input type='checkbox' id='orgrequire' style='margin-left:20px;margin-top:0'></label>
                                          <button class='btn btn-info' type='button'>确定</button><button class='btn btn-danger' type='button'>取消</button>
                                        </div>
                                      </form>"
                                >
                                    <label class="control-label leipiplugins-orgname">手机号码</label>
                                    <div class="controls">
                                        <input name="leipiNewField" type="text" placeholder="默认值" data-func="" data-see="" data-type="mobile" data-require=""  value="" title="填写号码" class="leipiplugins" leipiplugins="text"/>
                                    </div>
                                </div>

                                <div class="control-group component" rel="popover" title="日期控件" trigger="manual"
                                     data-content="
                                      <form class='form'>
                                        <div class='controls'>
                                          <label class='control-label'>控件名称</label> <input type='text' id='orgname' placeholder='必填项'>
                                          <label class='control-label'>默认值</label> <input type='text' id='orgvalue' placeholder='默认值'>
                                          <label class='control-label'>查看权限</label>
                                          <select id='orgsee'>
                                            <option value=0>所有人</option>
                                            <option value=1>员工</option>
                                            <option value=2>同部门</option>
                                            <option value=3>管理员</option>
                                          </select>
                                          <label class='control-label'>必填<input type='checkbox' id='orgrequire' style='margin-left:20px;margin-top:0'></label>
                                          <hr/>
                                          <button class='btn btn-info' type='button'>确定</button><button class='btn btn-danger' type='button'>取消</button>
                                        </div>
                                      </form>"
                                >
                                    <label class="control-label leipiplugins-orgname">日期控件</label>
                                    <div class="controls">
                                        <input name="leipiNewField" type="text" placeholder="默认值" data-func="" data-see="" data-require="" data-type="date"  title="日期控件"  value="" class="leipiplugins" leipiplugins="text"/>
                                    </div>
                                </div>
                                <div class="control-group component" rel="popover" title="时间控件" trigger="manual"
                                     data-content="
                                      <form class='form'>
                                        <div class='controls'>
                                          <label class='control-label'>控件名称</label> <input type='text' id='orgname' placeholder='必填项'>
                                          <label class='control-label'>默认值</label> <input type='text' id='orgvalue' placeholder='默认值'>
                                          <label class='control-label'>查看权限</label>
                                          <select id='orgsee'>
                                            <option value=0>所有人</option>
                                            <option value=1>员工</option>
                                            <option value=2>同部门</option>
                                            <option value=3>管理员</option>
                                          </select>
                                          <label class='control-label'>必填<input type='checkbox' id='orgrequire' style='margin-left:20px;margin-top:0'></label>
                                          <hr/>
                                          <button class='btn btn-info' type='button'>确定</button><button class='btn btn-danger' type='button'>取消</button>
                                        </div>
                                      </form>"
                                >
                                    <label class="control-label leipiplugins-orgname">时间控件</label>
                                    <div class="controls">
                                        <input name="leipiNewField" type="text" placeholder="默认值" data-func="" data-see="" data-require="" data-type="time"  title="时间控件"  value="" class="leipiplugins" leipiplugins="text"/>
                                    </div>
                                </div>
                                <div class="control-group component" rel="popover" title="数字控件" trigger="manual"
                                     data-content="
                                     <form class='form'>
                                        <div class='controls'>
                                          <label class='control-label'>控件名称</label> <input type='text' id='orgname' placeholder='必填项'>
                                          <label class='control-label'>默认值</label> <input type='text' id='orgvalue' placeholder='默认值'>
                                          <label class='control-label'>查看权限</label>
                                          <select id='orgsee'>
                                            <option value=0>所有人</option>
                                            <option value=1>员工</option>
                                            <option value=2>同部门</option>
                                            <option value=3>管理员</option>
                                          </select>
                                          <label class='control-label'>必填<input type='checkbox' id='orgrequire' style='margin-left:20px;margin-top:0' <?php  if($form['rq']) { ?> checked <?php  } ?>></label>
                                          <hr/>
                                          <button class='btn btn-info' type='button'>确定</button><button class='btn btn-danger' type='button'>取消</button>
                                        </div>
                                      </form>"
                                >
                                    <label class="control-label leipiplugins-orgname">数字控件</label>
                                    <div class="controls">
                                        <input name="leipiNewField" type="text" placeholder="数字,可计算"  data-func="" data-see="" data-require="" data-type="number"  title="数字控件"  value="" class="leipiplugins" leipiplugins="text"/>
                                    </div>
                                </div>
                                <div class="control-group component" rel="popover" title="城市选择" trigger="manual"
                                     data-content="
                                     <form class='form'>
                                        <div class='controls'>
                                          <label class='control-label'>控件名称</label> <input type='text' id='orgname' placeholder='必填项'>
                                          <label class='control-label'>默认值</label> <input type='text' id='orgvalue' placeholder='默认值'>
                                          <label class='control-label'>查看权限</label>
                                          <select id='orgsee'>
                                            <option value=0>所有人</option>
                                            <option value=1>员工</option>
                                            <option value=2>同部门</option>
                                            <option value=3>管理员</option>
                                          </select>
                                          <label class='control-label'>必填<input type='checkbox' id='orgrequire' style='margin-left:20px;margin-top:0' <?php  if($form['rq']) { ?> checked <?php  } ?>></label>
                                          <hr/>
                                          <button class='btn btn-info' type='button'>确定</button><button class='btn btn-danger' type='button'>取消</button>
                                        </div>
                                      </form>"
                                >
                                    <label class="control-label leipiplugins-orgname">城市选择</label>
                                    <div class="controls">
                                        <input name="leipiNewField city" type="text" placeholder="省,市,县" data-func="" data-see="" data-require="" readonly data-type="city"  title="城市选择"  value="" class="leipiplugins" leipiplugins="text"/>
                                    </div>
                                </div>

                                <div class="control-group component" rel="popover" title="多行文本" trigger="manual"
                                     data-content="
                                      <form class='form'>
                                        <div class='controls'>
                                          <label class='control-label'>控件名称</label> <input type='text' id='orgname' placeholder='必填项'>
                                          <label class='control-label'>默认值</label> <input type='text' id='orgvalue' placeholder='默认值'>
                                          <label class='control-label'>默认值函数</label>
                                          <select id='orgfunc'>
                                            <option value=''>--</option>
                                            <option value='_name'>会员姓名</option>
                                            <option value='_mobile'>会员电话</option>
                                            <option value='_staff_name'>员工姓名</option>
                                            <option value='_staff_mobile'>员工电话</option>
                                          </select>
                                          <label class='control-label'>查看权限</label>
                                          <select id='orgsee'>
                                            <option value=0>所有人</option>
                                            <option value=1>员工</option>
                                            <option value=2>同部门</option>
                                            <option value=3>管理员</option>
                                          </select>
                                          <label class='control-label'>必填<input type='checkbox' id='orgrequire' style='margin-left:20px;margin-top:0'></label>
                                          <hr/>
                                          <button class='btn btn-info' type='button'>确定</button><button class='btn btn-danger' type='button'>取消</button>
                                        </div>
                                      </form>"
                                >
                                    <label class="control-label leipiplugins-orgname">多行文本</label>
                                    <div class="controls">
                                        <div class="textarea">
                                            <textarea title="多行文本" name="leipiNewField" title="多行文本" data-func="" data-see="" data-require=""  data-type="textarea" class="leipiplugins" leipiplugins="textarea"/> </textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="control-group component" rel="popover" title="单选控件" trigger="manual"
                                     data-content="
                                      <form class='form'>
                                        <div class='controls'>
                                          <label class='control-label'>控件名称</label> <input type='text' id='orgname' placeholder='必填项'>
                                          <label class='control-label'>下拉选项</label>
                                          <textarea style='min-height: 150px;width:200px;' id='orgvalue' ></textarea>
                                          <p class='help-block'>一行一个选项</p>
                                          <label class='control-label'>查看权限</label>
                                          <select id='orgsee'>
                                            <option value=0>所有人</option>
                                            <option value=1>员工</option>
                                            <option value=2>同部门</option>
                                            <option value=3>管理员</option>
                                          </select>
                                          <label class='control-label'>必填<input type='checkbox' id='orgrequire' style='margin-left:20px;margin-top:0'></label>
                                          <hr/>
                                          <button class='btn btn-info' type='button'>确定</button><button class='btn btn-danger' type='button'>取消</button>
                                        </div>
                                      </form>"
                                >
                                    <label class="control-label leipiplugins-orgname">单选控件</label>
                                    <div class="controls">
                                        <select name="leipiNewField" title="单选控件" data-func="" data-see="" data-value="" data-require="" data-type="radio"  class="leipiplugins" leipiplugins="select">
                                            <option>选项一</option>
                                            <option>选项二</option>
                                            <option>选项三</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="control-group component" rel="popover" title="下拉控件" trigger="manual"
                                     data-content="
                                      <form class='form'>
                                        <div class='controls'>
                                          <label class='control-label'>控件名称</label> <input type='text' id='orgname' placeholder='必填项'>
                                          <label class='control-label'>下拉选项</label>
                                          <textarea style='min-height: 150px;width:200px;' id='orgvalue'></textarea>
                                          <p class='help-block'>一行一个选项</p>
                                          <label class='control-label'>查看权限</label>
                                          <select id='orgsee'>
                                            <option value=0>所有人</option>
                                            <option value=1>员工</option>
                                            <option value=2>同部门</option>
                                            <option value=3>管理员</option>
                                          </select>
                                          <label class='control-label'>必填<input type='checkbox' id='orgrequire' style='margin-left:20px;margin-top:0'></label>
                                          <hr/>
                                          <button class='btn btn-info' type='button'>确定</button><button class='btn btn-danger' type='button'>取消</button>
                                        </div>
                                      </form>"
                                >
                                    <label class="control-label leipiplugins-orgname">下拉控件</label>
                                    <div class="controls">
                                        <select name="leipiNewField" title="下拉控件" data-func="" data-see="" data-value="" data-require="" data-type="select"  class="leipiplugins" leipiplugins="select">
                                            <option>选项一</option>
                                            <option>选项二</option>
                                            <option>选项三</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group component" rel="popover" title="多选控件" trigger="manual"
                                     data-content="
                                      <form class='form'>
                                        <div class='controls'>
                                          <label class='control-label'>控件名称</label> <input type='text' id='orgname' placeholder='必填项'>
                                          <label class='control-label'>下拉选项</label>
                                          <textarea style='min-height: 150px;width:200px;' id='orgvalue'></textarea>
                                          <p class='help-block'>一行一个选项</p>
                                          <label class='control-label'>查看权限</label>
                                          <select id='orgsee'>
                                            <option value=0>所有人</option>
                                            <option value=1>员工</option>
                                            <option value=2>同部门</option>
                                            <option value=3>管理员</option>
                                          </select>
                                          <label class='control-label'>必填<input type='checkbox' id='orgrequire' style='margin-left:20px;margin-top:0'></label>
                                          <hr/>
                                          <button class='btn btn-info' type='button'>确定</button><button class='btn btn-danger' type='button'>取消</button>
                                        </div>
                                      </form>"
                                >
                                    <label class="control-label leipiplugins-orgname">多选控件</label>
                                    <div class="controls">
                                        <select name="leipiNewField" title="多选控件" data-func="" data-see="" data-value="" data-require="" data-type="checkbox"  class="leipiplugins" leipiplugins="select">
                                            <option>选项一</option>
                                            <option>选项二</option>
                                            <option>选项三</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group component" rel="popover" title="多级联动" trigger="manual"
                                     data-content="
                                      <form class='form'>
                                        <div class='controls'>
                                          <label class='control-label'>控件名称</label> <input type='text' id='orgname' placeholder='必填项'>
                                          <label class='control-label'>下拉选项</label>
                                          <input style='width:200px;' class='class_ld' id='orgvalue'>
                                          <p class='help-block'><a href='javascript:' class='select_ld'>选择</a></p>
                                          <label class='control-label'>查看权限</label>
                                          <select id='orgsee'>
                                            <option value=0>所有人</option>
                                            <option value=1>员工</option>
                                            <option value=2>同部门</option>
                                            <option value=3>管理员</option>
                                          </select>
                                          <label class='control-label'>必填<input type='checkbox' id='orgrequire' style='margin-left:20px;margin-top:0'></label>
                                          <hr/>
                                          <button class='btn btn-info' type='button'>确定</button><button class='btn btn-danger' type='button'>取消</button>
                                        </div>
                                      </form>"
                                >
                                    <label class="control-label leipiplugins-orgname">多级联动</label>
                                    <div class="controls">
                                        <input name="leipiNewField" type="text" placeholder="请选择" title="多级联动" data-func="" data-see="" data-type="ld"   class="leipiplugins" leipiplugins="text"/>
                                    </div>
                                </div>
                                <div class="control-group component">
                                    <label class="control-label leipiplugins-orgname" style="width: 0"></label>
                                    <div class="controls" style="margin-left: 5px;">
                                        <input name="leipiNewField" type="hidden" placeholder="默认值" data-type="label" data-require=""  value="" title="说明" class="leipiplugins" leipiplugins="text"/>
                                        <label class="lp_lb bz" style="line-height: 40px;">备注内容</label>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="2">
                                <div class="control-group component" rel="popover" title="拍照" trigger="manual"
                                     data-content="
                                      <form class='form'>
                                        <div class='controls'>
                                          <label class='control-label'>控件名称</label> <input type='text' id='orgname' placeholder='必填项'>
                                          <label class='control-label'>照片数</label> <input type='text' id='orgvalue' placeholder='默认值'>
                                          <label class='control-label'>查看权限</label>
                                          <select id='orgsee'>
                                            <option value=0>所有人</option>
                                            <option value=1>员工</option>
                                            <option value=2>同部门</option>
                                            <option value=3>管理员</option>
                                          </select>
                                          <label class='control-label'>必填<input type='checkbox' id='orgrequire' style='margin-left:20px;margin-top:0'></label>
                                          <hr/>
                                          <button class='btn btn-info' type='button'>确定</button><button class='btn btn-danger' type='button'>取消</button>
                                        </div>
                                      </form>"
                                >
                                    <label class="control-label leipiplugins-orgname">拍照</label>
                                    <div class="controls">
                                        <img src="/addons/gd_zlyqk//static/mobile/images/add.png" style="width: 35px;">
                                        <input name="leipiNewField" type="hidden" title="拍照" data-require="" data-func="" data-see="" data-type="photo" class="leipiplugins" leipiplugins="text"/>
                                    </div>
                                </div>
                                <div class="control-group component" rel="popover" title="语音" trigger="manual"
                                     data-content="
                                      <form class='form'>
                                        <div class='controls'>
                                          <label class='control-label'>控件名称</label> <input type='text' id='orgname' placeholder='必填项'>
                                          <label class='control-label'>查看权限</label>
                                          <select id='orgsee'>
                                            <option value=0>所有人</option>
                                            <option value=1>员工</option>
                                            <option value=2>同部门</option>
                                            <option value=3>管理员</option>
                                          </select>
                                          <label class='control-label'>必填<input type='checkbox' id='orgrequire' style='margin-left:20px;margin-top:0'></label>
                                          <hr/>
                                          <button class='btn btn-info' type='button'>确定</button><button class='btn btn-danger' type='button'>取消</button>
                                        </div>
                                      </form>">
                                    <label class="control-label leipiplugins-orgname">语音</label>
                                    <div class="controls">
                                        <input name="leipiNewField" type="hidden"  title="语音" data-type="voice" data-func="" data-see=""  data-require="" value="" class="leipiplugins" leipiplugins="text"/>
                                        <img src="/addons/gd_zlyqk//static/mobile/images/voice.png" style="width: 35px;">
                                    </div>
                                </div>
                                <div class="control-group component"  rel="popover" title="<?php  echo $form['label'];?>" trigger="manual"
                                     data-content="
                                      <form class='form'>
                                        <div class='controls'>
                                          <label class='control-label' style='display:none'>控件名称</label> <input type='text' id='orgname' style='display:none' placeholder='必填项'>
                                          <label class='control-label'>显示格式</label> <input type='text' id='orgvalue' value='' placeholder='默认值'>
                                          <p>#为站位符(例:支付1元)</p>
                                          <hr/>
                                          <button class='btn btn-info' type='button'>确定</button><button class='btn btn-danger' type='button'>取消</button>
                                        </div>
                                      </form>"
                                >
                                    <label class="control-label leipiplugins-orgname">支付</label>
                                    <div class="controls">
                                        <input name="leipiNewField" type="hidden"  title="支付" data-func="" data-see="" value="支付#元" data-type="pay" class="leipiplugins" leipiplugins="text"/>
                                        <label class="checkbox"  style="padding-top: 5px;">
                                             支付#元
                                        </label>
                                    </div>
                                </div>
                                <div class="control-group component" rel="popover" title="计算" trigger="manual"
                                     data-content="
                                      <form class='form'>
                                        <div class='controls'>
                                          <label class='control-label'>控件名称</label> <input type='text' id='orgname' placeholder='必填项'>
                                          <label class='control-label'>计算方式</label> <input type='text' id='orgvalue' placeholder='' readonly style='margin-top:10px;'><button class='btn cac_btn' type='button'>编辑</button>
                                          <label class='control-label'>查看权限</label>
                                          <select id='orgsee'>
                                            <option value=0>所有人</option>
                                            <option value=1>员工</option>
                                            <option value=2>同部门</option>
                                            <option value=3>管理员</option>
                                          </select>
                                          <hr/>
                                          <button class='btn btn-info' type='button'>确定</button><button class='btn btn-danger' type='button'>取消</button>
                                        </div>
                                      </form>"
                                >
                                    <label class="control-label leipiplugins-orgname">计算</label>
                                    <div class="controls">
                                        <input name="leipiNewField" type="text" placeholder="计算" data-func="" data-see="" data-require="" data-type="cac"  title="计算"  value="" class="leipiplugins" leipiplugins="text"/>
                                    </div>
                                </div>
                                <div class="control-group component" rel="popover" title="单价" trigger="manual"
                                     data-content="
                                      <form class='form'>
                                        <div class='controls'>
                                          <label class='control-label'>控件名称</label> <input type='text' id='orgname' placeholder='必填项'>
                                          <label class='control-label'>默认值</label> <input type='text' id='orgvalue' placeholder='默认值'>
                                          <label class='control-label'>查看权限</label>
                                          <select id='orgsee'>
                                            <option value=0>所有人</option>
                                            <option value=1>员工</option>
                                            <option value=2>同部门</option>
                                            <option value=3>管理员</option>
                                          </select>
                                          <label class='control-label'>必填<input type='checkbox' id='orgrequire' style='margin-left:20px;margin-top:0'></label>
                                          <p>下一节点支付金额</p>
                                          <hr/>
                                          <button class='btn btn-info' type='button'>确定</button><button class='btn btn-danger' type='button'>取消</button>
                                        </div>
                                      </form>"
                                >
                                    <label class="control-label leipiplugins-orgname">单价</label>
                                    <div class="controls">
                                        <input name="leipiNewField" type="text" placeholder="填写价格,可默认值" data-func="" data-see="" data-type="price" title="单价" data-require=""   value="" class="leipiplugins" leipiplugins="text"/>
                                    </div>
                                </div>
                                <div class="control-group component" rel="popover" title="位置" trigger="manual"
                                     data-content="
                                      <form class='form'>
                                        <div class='controls'>
                                          <label class='control-label'>控件名称</label> <input type='text' id='orgname' placeholder='必填项'>
                                          <label class='control-label'>默认值</label> <input type='text' id='orgvalue' placeholder='默认值'>
                                          <label class='control-label'>查看权限</label>
                                          <select id='orgsee'>
                                            <option value=0>所有人</option>
                                            <option value=1>员工</option>
                                            <option value=2>同部门</option>
                                            <option value=3>管理员</option>
                                          </select>
                                          <button class='btn btn-info' type='button'>确定</button><button class='btn btn-danger' type='button'>取消</button>
                                        </div>
                                      </form>"
                                >
                                    <label class="control-label leipiplugins-orgname">位置</label>
                                    <div class="controls">
                                        <input name="leipiNewField" type="text" data-func="" data-see="" data-require="" data-type="local" placeholder="云南省昆明市(自动定位)" title="位置" readonly class="leipiplugins" leipiplugins="text"/>
                                    </div>
                                </div>
                                <div class="control-group component"  >
                                    <label class="control-label leipiplugins-orgname">手机号</label>
                                    <div class="controls controls-row">
                                        <input name="leipiNewField" type="text" placeholder="填写号码"  value="" style="margin-bottom: 10px;" />
                                    </div>
                                    <label class="control-label leipiplugins-orgname">验证码</label>
                                    <div class="controls controls-row">
                                        <input name="leipiNewField" type="text" placeholder="验证码" title="验证码" data-type="sms"  value="" class="leipiplugins" style="width: 130px;" leipiplugins="text"/>
                                        <button type="button" class="btn">获取</button>
                                    </div>
                                </div>
                                <div class="control-group component" rel="popover" title="积分" trigger="manual"
                                     data-content="
                                      <form class='form'>
                                        <div class='controls'>
                                          <label class='control-label'>控件名称</label> <input type='text' id='orgname' placeholder='必填项'>
                                          <label class='control-label'>默认值</label> <input type='text' id='orgvalue' placeholder='默认值'>
                                          <label class='control-label'>查看权限</label>
                                          <select id='orgsee'>
                                            <option value=0>所有人</option>
                                            <option value=1>员工</option>
                                            <option value=2>同部门</option>
                                            <option value=3>管理员</option>
                                          </select>
                                          <label class='control-label'>必填<input type='checkbox' id='orgrequire' style='margin-left:20px;margin-top:0'></label>
                                          <p>完成节点可获得积分</p>
                                          <hr/>
                                          <button class='btn btn-info' type='button'>确定</button><button class='btn btn-danger' type='button'>取消</button>
                                        </div>
                                      </form>"
                                >
                                    <label class="control-label leipiplugins-orgname">积分</label>
                                    <div class="controls">
                                        <input name="leipiNewField" type="text" placeholder="填写积分" data-func="" data-see="" data-type="point" title="积分" data-require=""  value="" class="leipiplugins" leipiplugins="text"/>
                                    </div>
                                </div>
                                <div class="control-group component" rel="popover" title="子表单" trigger="manual"
                                     data-content="
                                      <form class='form'>
                                        <div class='controls'>
                                          <label class='control-label'>控件名称</label> <input type='text' id='orgname' placeholder='必填项'>
                                          <label class='control-label'>可添加数</label> <input type='text' id='orgvalue' >
                                          <label class='control-label'>查看权限</label>
                                          <select id='orgsee'>
                                            <option value=0>所有人</option>
                                            <option value=1>员工</option>
                                            <option value=2>同部门</option>
                                            <option value=3>管理员</option>
                                          </select>
                                          <label class='control-label'>必填<input type='checkbox' id='orgrequire' style='margin-left:20px;margin-top:0'></label>
                                          <hr/>
                                          <button class='btn btn-info' type='button'>确定</button><button class='btn btn-danger' type='button'>取消</button>
                                        </div>
                                      </form>"
                                >
                                    <label class="control-label leipiplugins-orgname">子表单</label>
                                    <div class="controls">
                                        <input name="leipiNewField" type="text" placeholder="动态添加列" data-func="" data-see="" data-type="child" title="子表单" data-require=""  value="" class="leipiplugins" leipiplugins="text"/>
                                    </div>
                                </div>
                                <div class="control-group component" rel="popover" title="位置展示" trigger="manual"
                                     data-content="
                                      <form class='form'>
                                        <div class='controls'>
                                          <label class='control-label'>控件名称</label> <input type='text' id='orgname' placeholder='必填项'>
                                          <label class='control-label'>选取位置</label> <input type='text' class='v_map' id='orgvalue' placeholder='' readonly style='margin-top:10px;'><button class='btn map_btn' type='button'>获取</button>
                                          <hr/>
                                          <button class='btn btn-info' type='button'>确定</button><button class='btn btn-danger' type='button'>取消</button>
                                        </div>
                                      </form>"
                                >
                                    <label class="control-label leipiplugins-orgname">位置展示</label>
                                    <div class="controls">
                                        <input name="leipiNewField" type="text" placeholder="位置展示" id="view_map" data-func="" data-see="" data-require="" data-type="map"  title="位置展示"  value="" class="leipiplugins" leipiplugins="text"/>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="3">
                                <div class="control-group component" rel="popover" title="入库组件" trigger="manual"
                                     data-content="
                                      <form class='form'>
                                        <div class='controls'>
                                          <label class='control-label'>控件名称</label> <input type='text' id='orgname' placeholder='必填项'>
                                          <label class='control-label'>绑定字段</label> <input type='text' class='in_num' id='orgvalue' placeholder='' readonly style='margin-top:10px;'><button class='btn in_button' type='button'>编辑</button>
                                          <label class='control-label'>查看权限</label>
                                          <select id='orgsee'>
                                            <option value=0>所有人</option>
                                            <option value=1>员工</option>
                                            <option value=2>同部门</option>
                                            <option value=3>管理员</option>
                                          </select>
                                          <label class='control-label'>必填<input type='checkbox' id='orgrequire' style='margin-left:20px;margin-top:0'></label>
                                          <hr/>
                                          <button class='btn btn-info' type='button'>确定</button><button class='btn btn-danger' type='button'>取消</button>
                                        </div>
                                      </form>"
                                >
                                    <label class="control-label leipiplugins-orgname">入库组件</label>
                                    <div class="controls">
                                        <input name="leipiNewField" type="text" placeholder="入库组件" data-func="" data-see="" data-require="" data-type="inku"  title="入库组件"  value="" class="leipiplugins" leipiplugins="text"/>
                                    </div>
                                </div>
                                <div class="control-group component" rel="popover" title="出库组件" trigger="manual"
                                     data-content="
                                      <form class='form'>
                                        <div class='controls'>
                                          <label class='control-label'>控件名称</label> <input type='text' id='orgname' placeholder='必填项'>
                                          <label class='control-label'>绑定字段</label> <input type='text' class='out_num' id='orgvalue' placeholder='' readonly style='margin-top:10px;'><button class='btn out_button' type='button'>编辑</button>
                                          <label class='control-label'>查看权限</label>
                                          <select id='orgsee'>
                                            <option value=0>所有人</option>
                                            <option value=1>员工</option>
                                            <option value=2>同部门</option>
                                            <option value=3>管理员</option>
                                          </select>
                                          <label class='control-label'>必填<input type='checkbox' id='orgrequire' style='margin-left:20px;margin-top:0'></label>
                                          <hr/>
                                          <button class='btn btn-info' type='button'>确定</button><button class='btn btn-danger' type='button'>取消</button>
                                        </div>
                                      </form>"
                                >
                                    <label class="control-label leipiplugins-orgname">出库组件</label>
                                    <div class="controls">
                                        <input name="leipiNewField" type="text" placeholder="出库组件" data-func="" data-see="" data-require="" data-type="outku"  title="出库组件"  value="" class="leipiplugins" leipiplugins="text"/>
                                    </div>
                                </div>
                            </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
    <div class="row cac" style="display: none">
        <div class="row" style="padding-top: 10px;margin-left:15px;">
            <div>
                <div>
                    <input type="text" class="cld fst" style="width: 375px;height: 30px;margin-left:5px;float: left">
                    <a class="btn tj" style="width: 40px;height:30px;margin-top:0;margin-left: 45px;float:left" href="javascript:">条件</a>
                </div>
                <div class="cdct">
                </div>
            </div>
            <div class="left" style="width: 440px;float: left;">
                <ul class="list_li">
                </ul>
            </div>
            <div class="right" style="width: 100px;float: left">
                <table style="font-size: 20px;font-weight: 800">
                    <tr >
                        <td><a class="btn btn-info act" style="width: 40px;margin-top:3px;height:30px;" href="javascript:">+</a></td>
                    </tr>
                    <tr >
                        <td><a class="btn btn-info act" style="width: 40px;margin-top:3px;height:30px;" href="javascript:">-</a></td>
                    </tr>
                    <tr >
                        <td><a class="btn btn-info act" style="width: 40px;margin-top:3px;height:30px;" href="javascript:">*</a></td>
                    </tr>
                    <tr >
                        <td><a class="btn btn-info act" style="width: 40px;margin-top:3px;height:30px;" href="javascript:">/</a></td>
                    </tr>
                    <tr >
                        <td><a class="btn btn-info act" style="width: 40px;margin-top:3px;height:30px;" href="javascript:">.</a></td>
                    </tr>
                    <tr >
                        <td><a class="btn btn-info clean" style="width: 40px;margin-top:3px;height:30px;" href="javascript:">清除</a></td>
                    </tr>
                </table>
            </div>
            <div >
                <a style="margin-top:20px;width: 490px;height: 30px;line-height: 30px;" href="javascript:" class="btn btn-danger ok" >确定</a>
            </div>
        </div>
    </div>
    <div class="row clearfix" style="margin-top:20px;">
        <div class="span5">
            <div class="controls controls-row" style="text-align: center">
                <button type="button" class="btn btn-large btn-success btns" style="padding-left: 30px;padding-right: 30px;line-height: 23px;height:40px;">保存</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" charset="utf-8" src="<?php echo MODULE_URL;?>/static/form/Public/js/jquery-1.7.2.min.js?2024"></script>
<script type="text/javascript"  src="<?php echo MODULE_URL;?>/static/form/Public/js/formbuild/bootstrap/js/bootstrap.min.js?2024"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo MODULE_URL;?>/static/form/Public/js/formbuild/leipi.form.build.core.js?2024"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo MODULE_URL;?>/static/form/Public/js/formbuild/leipi.form.build.plugins.js?2024"></script>
<script type="text/javascript" src="<?php echo MODULE_URL;?>/static/admin/layui/layui.js"></script>
<script>
    var layer;
    var index;
    var randomNum;
    var sLay;
    var _body=$("body");
    var current;
    var html='<div class="gs">'+
            '<input type="text" class="cld" placeholder="计算公式" style="width: 205px;height: 30px;margin-left:5px;">'+
            '<input type="text" class="gt xy" placeholder="大于" style="width: 65px;height: 30px;margin-left:5px;">'+
            '<input type="text" class="lt dy" placeholder="小于" style="width: 66px;height: 30px;margin-left:5px;">'+
            '<span style="margin-left: 40px;">'+
            '<a href="javascript:" class="add" style="line-height: 30px;font-size: 18px;">+</a>'+
            '<a href="javascript:" class="div" style="margin-left: 15px;line-height: 30px;font-size: 18px;">-</a>'+
            '</span>';
    layui.use('layer', function(){
        var layer = layui.layer;
    });
    _body.on("click",".cld",function(){
        current =$(this);
    });
    _body.on("click",".is_pay",function(){
        if($(this).hasClass("btn-danger")){
            $(this).removeClass("btn-danger");
        }else{
            $(this).addClass("btn-danger");
        }
    });
    _body.on("click",".tj",function(){
        if($(this).hasClass("btn-danger")){
            $(this).removeClass("btn-danger")
            $(".cdct").html("");
        }else{
            $(this).addClass("btn-danger");
            $(".cdct").html(html);
        }
    });

    //入库插件选择
    _body.on("click",".in_button",function(){
        var url = "<?php  echo $this->createWebUrl('selectStore')?>&type=in";
        index = layui.layer.open({
            title : "选择",
            type : 2,
            area:['500px',"500px"],
            content : url
        });
    });

    //入库插件选择
    _body.on("click",".out_button",function(){
        var url = "<?php  echo $this->createWebUrl('selectStore')?>&type=out";
        index = layui.layer.open({
            title : "选择",
            type : 2,
            area:['500px',"500px"],
            content : url
        });
    });

    function addStore(id){
        $(".in_num").val(id);
        layer.close(index);
    }
    function outStore(id){
        $(".out_num").val(id);
        layer.close(index);
    }
    //出库插件选择
    _body.on("click",".out_button",function(){
    });

    //添加条件列
    _body.on("click",".add",function(){
        $(".cdct").append(html);
    });

    _body.on("click",".div",function(){
        $(this).parent().parent().remove();
    });

    //选择绑定项目
    _body.on("click",".select_ld",function(){
        $(this).addClass("cur_ld");
        var url = "<?php  echo $this->createWebUrl('selectLd')?>";
        index = layui.layer.open({
            title : false,
            type : 2,
            area:['500px',"500px"],
            content : url
        });
    });
    //添加收取列表
    function setLd(name ,id){
        var area=$(".cur_ld").parent().prev();
        area.val(name+"#"+id);
        layer.close(index);
        $(".cur_ld").removeClass("cur_ld");
    }

    _body.on("click",".clean",function(){
        current.val("");
    });
    _body.on("click",".ok",function(){
        var classes =$(".cls_cl").val();
        //如果有条件
        var gsStr = $(".layui-layer-content").find(".fst").val();
        if(gsStr=="" && gsStr!="undefined"){
            layer.msg("请选择公式",{icon:2});
            return false;
        }
        var tjStr="";
        if($(".tj").hasClass("btn-danger")){
            $(".layui-layer-content").find(".gs").each(function(){
                var cGd=$(this).children(".cld").val();
                if(cGd!=""){
                    var lt =$(this).find(".xy").val();
                    var gt=$(this).find(".dy").val();
                    if(lt=="" || gt==""){
                        layer.msg("请填写条件",{icon:2});
                        return false;
                    }else if(cGd==""){
                        layer.msg("请选择公式",{icon:2});
                        return false;
                    }
                    tjStr+=cGd+"#"+lt+"#"+gt+"|";
                }
            });
            if(tjStr!=""){
                gsStr +="##";
                gsStr +=tjStr;
            }
        }
        if($(".is_pay").hasClass("btn-danger")){
            if(tjStr==""){
                gsStr +="|p";
            }else{
                gsStr +="p";
            }
        }
        $("."+classes).parent().find("#orgvalue").val(gsStr);
        $(".cld").val("");
        $(".lt").val("");
        $(".gt").val("");
        layui.layer.close(sLay);
    });

    //选取地理位置
    _body.on("click",".map_btn",function(){
        var url = "<?php  echo $this->createWebUrl('selectMap')?>&wz=";
        var index = layui.layer.open({
            title : "编辑字段",
            type : 2,
            area:["90%","550px"],
            content : url,
            success : function(layero, index){
                setTimeout(function(){
                    layui.layer.tips('点击此处返回设计', '.layui-layer-setwin .layui-layer-close', {tips: 3});
                },500)
            }
        });

    });

    function selectLct(lc,addr){
        $('.v_map').val(addr+"|"+lc);
    }

    _body.on("click",".cac_btn",function(){
        //获取可以计算的表单
        var nameList=new Array();
        var source =$(this).parent().find("#orgvalue").val();
        $("#target").find(".leipiplugins").each(function(){
            if($(this).attr("data-type")=="number" || $(this).attr("data-type")=="price" || $(this).attr("data-type")=="outku"){
                nameList.push($(this).attr("title"))
            }
        });
        randomNum = Math.random()*1000;
        randomNum = "dls_"+Math.floor(randomNum);
        //创建表单
        var strList="";
        for(var i=0;i<nameList.length;i++){
            strList +='<li><a class="btn act" style="width: 100px;margin-top:5px;height:30px;line-height: 30px;" href="javascript:">'+nameList[i]+'</a></li>';
        }
        strList +='<li><a class="btn is_pay" style="width: 100px;margin-top:5px;height:30px;line-height: 30px;" href="javascript:">支付</a></li>';
        strList +='<li><a class="btn act" style="width: 100px;margin-top:5px;height:30px;line-height: 30px;" href="javascript:">(</a></li>';
        strList +='<li><a class="btn act" style="width: 100px;margin-top:5px;height:30px;line-height: 30px;" href="javascript:">)</a></li>';
        strList +='<li><a class="btn act" style="width: 100px;margin-top:5px;height:30px;line-height: 30px;" href="javascript:">9</a></li>';
        strList +='<li><a class="btn act" style="width: 100px;margin-top:5px;height:30px;line-height: 30px;" href="javascript:">8</a></li>';
        strList +='<li><a class="btn act" style="width: 100px;margin-top:5px;height:30px;line-height: 30px;" href="javascript:">7</a></li>';
        strList +='<li><a class="btn act" style="width: 100px;margin-top:5px;height:30px;line-height: 30px;" href="javascript:">6</a></li>';
        strList +='<li><a class="btn act" style="width: 100px;margin-top:5px;height:30px;line-height: 30px;" href="javascript:">5</a></li>';
        strList +='<li><a class="btn act" style="width: 100px;margin-top:5px;height:30px;line-height: 30px;" href="javascript:">4</a></li>';
        strList +='<li><a class="btn act" style="width: 100px;margin-top:5px;height:30px;line-height: 30px;" href="javascript:">3</a></li>';
        strList +='<li><a class="btn act" style="width: 100px;margin-top:5px;height:30px;line-height: 30px;" href="javascript:">2</a></li>';
        strList +='<li><a class="btn act" style="width: 100px;margin-top:5px;height:30px;line-height: 30px;" href="javascript:">1</a></li>';
        strList +='<li><a class="btn act" style="width: 100px;margin-top:5px;height:30px;line-height: 30px;" href="javascript:">0</a></li>';
        strList +='<input type=hidden class="cls_cl" value="'+randomNum+'">';
        $(this).addClass(randomNum);
        $(".list_li").html(strList);
        var html=$(".cac").html();
        sLay = layui.layer.open({
            type: 1,
            area: ['570px', '560px'],
            content:html
        });
        current=$(".layui-layer-content").find(".fst");
        //解析公式
        var gsList=source.split("##");
        if(gsList.length==1){
            var gsLs=source.split("|");
            if(gsLs.length==2 && gsLs[1]=="p"){
                current.val(gsLs[0]);
                $(".layui-layer-content").find(".is_pay").addClass("btn-danger");
            }else{
                current.val(gsList);
            }
        }else{
            $(".tj").addClass("btn-danger");
            current.val(gsList[0]);
            var tjStr=gsList[1];
            var tjList=tjStr.split("|");
            for(var i=0;i<tjList.length;i++){
                if(tjList[i]!="" && tjList[i]!="p"){
                    var gjs=tjList[i].split("#");
                    var ele ='<div class="gs">'+
                            '<input type="text" class="cld" placeholder="计算公式" value="'+gjs[0]+'" style="width: 205px;height: 30px;margin-left:5px;">'+
                            '<input type="text" class="gt xy" placeholder="大于" value="'+gjs[1]+'" style="width: 65px;height: 30px;margin-left:5px;">'+
                            '<input type="text" class="lt dy" placeholder="小于" value="'+gjs[2]+'" style="width: 66px;height: 30px;margin-left:5px;">'+
                            '<span style="margin-left: 40px;">'+
                            '<a href="javascript:" class="add" style="line-height: 30px;font-size: 18px;">+</a>'+
                            '<a href="javascript:" class="div" style="margin-left: 15px;line-height: 30px;font-size: 18px;">-</a>'+
                            '</span>';
                    $(".layui-layer-content").find(".cdct").append(ele);
                }else if(tjList[i]=="p"){
                    $(".layui-layer-content").find(".is_pay").addClass("btn-danger");
                }
            }
        }

    });

    _body.on("click",".bz",function(){
        var rand=parseInt(Math.random()*10000);
        var rand_class="lb_"+rand;
        $(this).addClass(rand_class);
        var url = "<?php  echo $this->createWebUrl('editor')?>&rand_class="+rand_class;
        index = layui.layer.open({
            title : "备注",
            type : 2,
            area:['830px',"530px"],
            content : url
        });
    });

    function setHid(className){
        $("."+className).prev().val($("."+className).html());
    }

    _body.on("click",".act",function(){
        var text=current.val();
        var ac =$(this).text();
        current.val(text+ac);
    });

    $(".btns").click(function(){
        var formList = $("#build .leipiplugins");
        var post=new Array();
        $.each(formList, function(i,e){
            var item=new Object();
            item.label=$(e).attr("title");
            item.form=$(e).attr("data-type");
            item.py=$(e).attr("data-name");
            if(item.form=='select'){
                item.pl="";
                $(e).children("option").each(function(){
                    if($(this).val()!='undefined'){
                        item.pl += (item.pl=="")?$(this).val():","+$(this).val();
                    }
                });
            }else if(item.form=='checkbox'){
                item.pl="";
                $(e).children("option").each(function(){
                    if($(this).val()!='undefined'){
                        item.pl += (item.pl=="")?$(this).val():","+$(this).val();
                    }
                });
            }else if(item.form=='radio'){
                item.pl="";
                $(e).children("option").each(function(){
                    if($(this).val()!='undefined'){
                        item.pl += (item.pl=="")?$(this).val():","+$(this).val();
                    }
                });
            }else{
                item.pl=$(e).val();
            }
            item.rq=$(e).attr("data-require");
            item.func =$(e).attr("data-func");
            item.see =$(e).attr("data-see");
            post.push(item);
        });
        var postUrl = "<?php  echo $postUrl;?>";
        $.post(postUrl,{data:JSON.stringify(post)},function(response){
            layer.msg(response.msg,{icon: response.code});
            if(response.code==1){
                setTimeout(function(){
                    var index = parent.layer.getFrameIndex(window.name);
                    parent.layer.close(index);
                },1000);
            }
        },"json");
    });
</script>
</body>
</html>