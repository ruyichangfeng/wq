<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>

<ul class="nav nav-tabs">
    <li><a href="<?php  echo $this->createWebUrl('servetemp', array('foo'=>'index'));?>">服务模型管理</a></li>
    <li class="active"><a href="#">模型字段管理</a></li>
</ul>

<div class="clearfix">    
    <form id="theform" class="form form-horizontal" action="<?php  echo $this->createWebUrl('servetemp', array('foo'=>'valueeditok'));?>" method="post">
    <input type="hidden" name="id" value="<?php  echo $item['id'];?>" >
    <input type="hidden" name="temp_id" value="<?php  echo $item['temp_id'];?>" >
    <input type="hidden" name="temp_token" value="<?php  echo $item['temp_token'];?>" >
        <div class="panel panel-default">
            <div class="panel-heading">
                修改模型字段
                <!--<span style="color: red;">[注意：默认的服务时间、姓名、联系电话、性别的标识只能是ftime、fname、fmobile、fsex，不能改变且在添加时不能重复]</span>-->
            </div>
            <div class="panel-body">
                显示描述:
                <input type="text" name="input_laber" id="input_laber" value="<?php  echo $item['input_laber'];?>" >
                字段类型:
                <select name="input_type" id="input_type" onchange="check()">
                	<option value="">------选择字段类型------</option>
                    <option value="text" <?php  if($item['input_type'] == 'text') { ?> selected <?php  } ?>>单行文本</option>
                    <option value="radio" <?php  if($item['input_type'] == 'radio') { ?> selected <?php  } ?>>单选</option>
                    <option value="checkbox" <?php  if($item['input_type'] == 'checkbox') { ?> selected <?php  } ?>>复选</option>
                    <option value="select" <?php  if($item['input_type'] == 'select') { ?> selected <?php  } ?>>下拉</option>
                    <option value="textarea" <?php  if($item['input_type'] == 'textarea') { ?> selected <?php  } ?>>多行文本</option>
                    <option value="times" <?php  if($item['input_type'] == 'times') { ?> selected <?php  } ?>>日期时间</option>
                    <option value="dates" <?php  if($item['input_type'] == 'dates') { ?> selected <?php  } ?>>日期</option>
                    <option value="nums" <?php  if($item['input_type'] == 'nums') { ?> selected <?php  } ?>>数字</option>
                    <option value="lbstext" <?php  if($item['input_type'] == 'lbstext') { ?> selected <?php  } ?>>地理位置</option>
                </select>
                字段标识:
                <input type="text" name="input_name" id="input_name" value="<?php  echo $item['input_name'];?>" readonly>
                <label style="color:red;">[字段标识只能由半角的数字，字母和下划线（"_"），并且不能以数字开头]</label> 
                <br/><br/>
                <div id="show1" style="display:block;">
                选项名称:
                <input type="text" name="value_name" id="value_name" placeholder="选项名称1||选项名称2||选项名称3" value="<?php  echo $item['value_name'];?>">
                &nbsp;&nbsp;&nbsp;选项值:
                <input type="text" name="input_value" id="input_value" placeholder="选项值1||选项值2||选项值3" value="<?php  echo $item['input_value'];?>">
                </div>
                &nbsp;&nbsp;&nbsp;&nbsp;默认值:
                <input type="text" name="input_default" id="input_default" value="<?php  echo $item['input_default'];?>">
                
                备注:
                <input type="text" name="remark" id="remark" value="<?php  echo $item['remark'];?>">
                
                <div id="show2" style="display:block">
                提示语:
                <input type="text" name="prompts" id="prompts" value="<?php  echo $item['prompts'];?>">
                </div>
                
                排序参数:
                <input type="text" name="top" id="top" value="<?php  echo $item['top'];?>">
                
                <input name="submit" type="submit" value="提交"/>
                <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                
            </div>
            <div class="panel-footer" style="color:red;">
        	提示：<br/>
            1.当字段类型为文本和备注时，选项值不需要填写，默认值视个人情况而定；<br/>
            2.当字段类型为单选、复选、下拉时，必须的有选项值和选项名称，并用“||”隔开，并一一对应，如【选项值1||选项值2||选项值3】=》【选项名称1||选项名称2||选项名称3】，并指定默认值；<br/>
            3.排序参数即为在手段端显示的熟悉，从小到大；
        	</div>
        </div>
    </form>  
</div>

<script>
$(document).ready(function(){
	check();
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
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>