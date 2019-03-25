<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
    <li><a href="<?php  echo $this->createWebUrl('servetemp', array('foo'=>'index'));?>">服务模型管理</a></li>
    <li class="active"><a href="#">模型字段管理</a></li>
</ul>

<div class="clearfix">    
    <div class="panel panel-default">
    	<div class="panel-heading">
            服务模型字段列表
        </div>
        <div class="table-responsive panel-body" style="overflow:visible;">
            <?php  if($list[0]['id'] == '') { ?>
            <div class="tx-c">暂无字段</div>
            <?php  } else { ?>
            <table class="table table-hover">
            	<thead>
                	<tr class="active">
                    	<td>描述</td>
                        <td>类型</td>
                        <td>标识</td>
                        <td>选项名称</td>
                        <td>选项值</td>
                        <td>默认值</td>
                        <td>备注</td>
                        <td>提示语</td>
                        <td>排序</td>
                        <td>操作</td>
                    </tr>
                </thead>
                <tbody>
                	<?php  if(is_array($list)) { foreach($list as $val) { ?>
                    <tr>
                    	<td><?php  echo $val['input_laber'];?></td>
                        <td>
                        <?php  if($val['input_type'] == 'text') { ?>文本<?php  } ?>
                        <?php  if($val['input_type'] == 'radio') { ?>单选<?php  } ?>
                        <?php  if($val['input_type'] == 'checkbox') { ?>复选<?php  } ?>
                        <?php  if($val['input_type'] == 'select') { ?>下拉<?php  } ?>
                        <?php  if($val['input_type'] == 'textarea') { ?>备注<?php  } ?>
                        <?php  if($val['input_type'] == 'times') { ?>日期时间<?php  } ?>
                        <?php  if($val['input_type'] == 'dates') { ?>日期<?php  } ?>
                        <?php  if($val['input_type'] == 'nums') { ?>数字<?php  } ?>
                        <?php  if($val['input_type'] == 'lbstext') { ?>地理位置<?php  } ?>
                        </td>
                        <td><?php  echo $val['input_name'];?></td>
                        <td><?php  echo $val['value_name'];?></td>
                        <td><?php  echo $val['input_value'];?></td>
                        <td><?php  echo $val['input_default'];?></td>
                        <td><?php  echo $val['remark'];?></td>
                        <td><?php  echo $val['prompts'];?></td>
                        <td><?php  echo $val['top'];?></td>
                        <td style="overflow:visible;">
                        	<div class="btn-group btn-group-sm">
								<a class="btn btn-default" href="<?php  echo $this->createWebUrl('servetemp', array('foo'=>'valueedit','id'=>$val['id'],'temp_id'=>$val['temp_id'],'temp_token'=>$val['temp_token']))?>"><i class="fa fa-edit"></i>编辑</a>
                            	<a class="btn btn-default" href="<?php  echo $this->createWebUrl('servetemp', array('foo'=>'valuedelete','id'=>$val['id'],'temp_id'=>$val['temp_id'],'temp_token'=>$val['temp_token']))?>" onclick="return confirm('确认删除该字段吗?');"><i class="fa fa-remove"></i> 删除</a>
                            </div>
                        </td>
                    </tr>
                    <?php  } } ?>
                </tbody>
            </table>
            <?php  } ?>
        </div>
    </div>
</div>

<div class="clearfix">    
    <form id="theform" class="form form-horizontal" action="<?php  echo $this->createWebUrl('servetemp', array('foo'=>'baseok'));?>" method="post">
    <input type="hidden" name="temp_id" value="<?php  echo $temp_id;?>" >
    <input type="hidden" name="temp_token" value="<?php  echo $temp_token;?>" >
        <div class="panel panel-default">
            <div class="panel-heading">
                字段需求
            </div>
            <div class="panel-body">
                是否需要价格字段:
                <label class="radio-inline">
                	<input type="radio" name="price" value="1" <?php  if($item['price']==1) { ?> checked <?php  } ?>>需要
                </label>
                <label class="radio-inline">
                	<input type="radio" name="price" value="0" <?php  if($item['price']==0) { ?> checked <?php  } ?>>不需要
                </label>
                <br />
                <br />
                是否需要距离字段:
                <label class="radio-inline">
                	<input type="radio" name="juli" value="1" onclick="radiosub(1)" <?php  if($item['juli']==1) { ?> checked <?php  } ?>>需要
                </label>
                <label class="radio-inline">
                	<input type="radio" name="juli" value="0" onclick="radiosub(0)" <?php  if($item['juli']==0) { ?> checked <?php  } ?>>不需要
                </label>
                <br />
                <div id="input_show" style="display:none;">
                <span style="color:red;">
                注意：请输入需要计算距离的两个字段标识(字段类型必须是地理位置)
                </span>
                <br/>
                字段名称一：<input type="text" name="input_1" id="input_1" value="<?php  echo $item['input_1'];?>" />
                字段名称二：<input type="text" name="input_2" id="input_2" value="<?php  echo $item['input_2'];?>" />
                </div>
                
                <input name="submit" type="submit" value="提交"/>
                <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
            </div>
            <div class="panel-footer" style="color:red;">
        	
        	</div>
        </div>
    </form>  
</div>

<div class="clearfix">    
    <form id="theform" class="form form-horizontal" action="<?php  echo $this->createWebUrl('servetemp', array('foo'=>'valueaddok'));?>" method="post">
    <input type="hidden" name="temp_id" value="<?php  echo $temp_id;?>" >
    <input type="hidden" name="temp_token" value="<?php  echo $temp_token;?>" >
        <div class="panel panel-default">
            <div class="panel-heading">
                添加模型字段
            </div>
            <div class="panel-body">
                显示描述:
                <input type="text" name="input_laber" id="input_laber">
                字段类型:
                <select name="input_type" id="input_type" onchange="check()">
                	<option value="">------选择字段类型------</option>
                    <option value="text">单行文本</option>
                    <option value="radio">单选</option>
                    <option value="checkbox">复选</option>
                    <option value="select">下拉</option>
                    <option value="textarea">多行文本</option>
                    <option value="times">日期时间</option>
                    <option value="dates">日期</option>
                    <option value="nums">数字</option>
                    <option value="lbstext">地理位置</option>
                </select>
                字段标识:
                <input type="text" name="input_name" id="input_name">
                <br/><label style="color:red;">[字段标识只能由半角的数字，字母和下划线（"_"），并且不能以数字开头]</label> 
                <br/>
                <div id="show1" style="display:block;">
                选项名称:
                <input type="text" name="value_name" id="value_name" placeholder="选项名称1||选项名称2||选项名称3">
                &nbsp;&nbsp;&nbsp;选项值:
                <input type="text" name="input_value" id="input_value" placeholder="选项值1||选项值2||选项值3">
                </div>
                <br/><br />
                &nbsp;&nbsp;&nbsp;&nbsp;默认值:
                <input type="text" name="input_default" id="input_default">
                备注:
                <input type="text" name="remark" id="remark">
                
                <div id="show2" style="display:block">
                提示语:
                <input type="text" name="prompts" id="prompts">
                </div>
                排序参数:
                <input type="text" name="top" id="top">
                
                <input name="submit" type="submit" value="提交"/>
                <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                
            </div>
            <div class="panel-footer" style="color:red;">
        	
        	</div>
        </div>
    </form>  
</div>

<div class="clearfix">    
    <form id="theform" class="form form-horizontal" action="<?php  echo $this->createWebUrl('servetemp', array('foo'=>'gongshiok'));?>" method="post">
    <input type="hidden" name="temp1_id" value="<?php  echo $temp_id;?>" >
    <input type="hidden" name="temp1_token" value="<?php  echo $temp_token;?>" >
        <div class="panel panel-default">
            <div class="panel-body">
                计算公式:
                <textarea name="jsgs" id="jsgs" cols="110" rows="10"><?php  echo base64_decode($this->getJsgs($temp_id))?></textarea>
                <input name="submit" type="submit" value="提交"/>
                <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                
            </div>
            <div class="panel-footer" style="color:red;">
        	提示：请用上面列表中的字段标识进行公式计算，只支持加减乘除；
        	</div>
            <div class="panel-heading">
                <strong>添加价格计算公式，计算结果将显示在模型页的价格显示框</strong>
<div> 单选类型：r("字段标识")        <br/>
                  下拉、文本、数字：c("字段标识") <br/> 复选：取所有选中值的和：d("字段标识")  取某个选中项的值：d("字段标识"，顺序号)，如：d("fxk",2)表示取第二个选项的值。      <br/>市场价：{xm_price_a}      <br/>优惠价：{xm_price_b}     <br />
              多行文本，日期时间暂无法参与计算<br/>
              <strong>可以使用加法(+)、减法（-）、乘法（*）、除法(/)运算，可以使用括号设置运算优先级,可以使用if进行条件判断。</strong><br/>
              公式格式为 “ sum = 公式; ” 例：sum=(r("fdemoa")+c("fdemo2")); <strong>当只需要显示某一个字段值无须进行计算时，请用sum = r(或者c、d)("字段标识")+0;</strong></div>
            </div>
        </div>
    </form>  
</div>

<div class="clearfix">    
    <!--<form id="theform" class="form form-horizontal" action="<?php  echo $this->createWebUrl('postok', array());?>" method="post">-->
        <div class="panel panel-default">
            <div class="panel-heading">
                生成模板：当所有参数设置好后点击生成模板
            </div>
            <div class="panel-body">
               <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                    <div class="col-md-2 col-lg-1">
                        <!--
                        <input name="submit" type="submit" value="生成模板" class="btn btn-primary btn-block" />
                        <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                        -->
                        <input name="submit" type="submit" onclick="getTempOk()" value="生成模型" class="btn btn-primary btn-block" />
                    </div>
                </div>
            </div>
            <div class="panel-footer" style="color:red;">
        	
        	</div>
        </div>
    <!--</form>-->
</div>

<script type="text/javascript">
$(document).ready(function(){
	var value="";
	var radio=document.getElementsByName("juli");
	for(var i=0;i<radio.length;i++){
		if(radio[i].checked==true){
			value=radio[i].value;
			break;
		}
	}
	if(value == 1){
		document.getElementById('input_show').style.display = 'block';
	}else{
		document.getElementById('input_show').style.display = 'none';
	}
})

function check(){
	var r=document.getElementById("input_type").value;
	if(r=="text" || r=="textarea" || r=="times" || r=="dates" || r=="lbstext"){
		document.getElementById('show1').style.display = 'none';
		document.getElementById('show2').style.display = 'block';
	}
	if(r=="radio" || r=="checkbox" || r=="select"){
		document.getElementById('show1').style.display = 'block';
		document.getElementById('show2').style.display = 'none';
	}
	if(r=="nums"){
		document.getElementById('show1').style.display = 'none';
		document.getElementById('show2').style.display = 'none';
	}
}

function radiosub(id){
	if(id == 1){
		document.getElementById('input_show').style.display = 'block';
	}else{
		document.getElementById('input_show').style.display = 'none';
	}
}

function getTempOk(){
	var temp_id = "<?php  echo $temp_id;?>";
	var temp_token = "<?php  echo $temp_token;?>";

	$.ajax({
		url: "<?php  echo $this->createWebUrl('servetemp', array('foo'=>'setModel'));?>",
		type:"POST",
		data:{"temp_token":temp_token, "temp_id":temp_id},
		dataType:"json",
		success: function(res){
			if(res == 1){
				alert('模型生成成功！');
			}else{
				alert('模型生成失败，请重试！');
			}
		}
	});
}
</script>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>