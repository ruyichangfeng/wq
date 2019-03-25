<?php defined('IN_IA') or exit('Access Denied');?><html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <style type="text/css">
        html, body, #canvas {
            height: 100%;
            padding: 0;
        }
        #save-button {
            position: absolute;
            bottom: 20px;
            right: 50%;
            display: inline-block;
            background-color: #009688;
            color: #fff;
            white-space: nowrap;
            text-align: center;
            border: none;
            border-radius: 2px;
            cursor: pointer;
            opacity: .9;
            height: 44px;
            line-height: 44px;
            padding: 0 25px;
            font-size: 16px;
        }
        .djs-context-pad .entry{width: 24px !important;}
        .act_bar{
            position: fixed;right:20px;top:150px;width: 46px;background: #FAFAFA;border: solid 1px #CCC;border-radius: 2px;box-shadow: 0 1px 2px rgba(0,0,0,0.3);display: none
        }
        .form_bar{
            position: fixed;right:20px;top:150px;width: 46px;background: #FAFAFA;border: solid 1px #CCC;border-radius: 2px;box-shadow: 0 1px 2px rgba(0,0,0,0.3);display: none
        }
        .select_user{float: left;width: 40px;margin-left:3px;margin-top:10px;}
        .select_line_form{float: left;width: 40px;margin-left:3px;}
        .select_form{float: left;width: 40px;margin-top:10px;margin-bottom:10px;margin-left:3px;}
    </style>
    <link rel="stylesheet" href="<?php echo MODULE_URL;?>/static/fl/css/diagram-js.css">
    <link rel="stylesheet" href="<?php echo MODULE_URL;?>/static/fl/css/bpmn-font/css/bpmn-embedded.css">
</head>
<body>
<input type="hidden" name="id" id="flow_id" value="<?php  echo $id;?>">
<div id="canvas"></div>
<button id="save-button">保存</button>
<div class="act_bar">
    <img class="select_user"  src="<?php echo MODULE_URL;?>/static/fl/images/p.png">
    <img class="select_form"  src="<?php echo MODULE_URL;?>/static/fl/images/t.png">
</div>
<div class="form_bar">
    <img class="select_line_form"  src="<?php echo MODULE_URL;?>/static/fl/images/t.png">
</div>
<script>
    var node_id;
    var line_id;
    var line_name;
    var node_name;
    var flow_id="<?php  echo $id;?>";
    var xml ='<?php  echo $xml;?>';
    var url="<?php  echo $this->createWebUrl('desiFlow')?>&flow_id="+flow_id;
    var who_list=new Object();
    var form_list = new Object();
    var line_form_list=new Object();
    var who_type = new Object();
    <?php  if(is_array($confList)) { foreach($confList as $val) { ?>
        who_list["<?php  echo $val['node_sid'];?>"]="<?php  echo $val['id'];?>";
        form_list["<?php  echo $val['node_sid'];?>"]="<?php  echo $val['id'];?>";
    <?php  } } ?>
</script>
<script src="<?php echo MODULE_URL;?>/static/mobile/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo MODULE_URL;?>/static/admin/layui/layui.js"></script>
<script src="<?php echo MODULE_URL;?>/static/fl/js/bpmn-modeler.js"></script>
<script src="<?php echo MODULE_URL;?>/static/fl/js/modeler.js"></script>
<script>
    layui.use(['layer'], function(){
        //选择处理人员
        $(".select_user").click(function(){
            layui.layer.open({
                type: 2,
                area: ['500px', '90%'],
                shade: 0.8,
                closeBtn: 1,
                shadeClose: true,
                content: '<?php  echo $this->createWebUrl("SelectUser2")?>&node_id='+node_id+"&flow_id="+flow_id
            });
        });

        //选择处理表单
        $(".select_form").click(function(){
            // var index = layui.layer.open({
            //     title : "设计表单",
            //     type : 2,
            //     area: ['970px', '98%'],
            //     content : "<?php  echo $this->createWebUrl('desFm2')?>&id="+node_id+"&flow_id="+flow_id,
            // });
            window.open("<?php  echo $this->createWebUrl('desFm2')?>&id="+node_id+"&flow_id="+flow_id);
            return false;
        });

        //选择处理表单
        $(".select_line_form").click(function(){
            // var index = layui.layer.open({
            //     title : "设计表单",
            //     type : 2,
            //     area: ['970px', '98%'],
            //     content : "<?php  echo $this->createWebUrl('desFm3')?>&id="+line_id+"&flow_id="+flow_id,
            // });
            window.open("<?php  echo $this->createWebUrl('desFm3')?>&id="+line_id+"&flow_id="+flow_id);
            return false;
        });
    });

    //显示选择员工,选择表单
    $("body").on("click",".djs-element:gt(1)",function(){
        node_id=$(this).attr("data-element-id");
        if(node_id.indexOf('Task_')<0){
            return false;
        }
        $(".act_bar").show();
        $(".form_bar").hide();
        node_name=($(this).find("tspan").text());
    });

    $("body").on("click",".djs-connection",function(){
        line_id=$(this).attr("data-element-id");
        $(".act_bar").hide();
        $(".form_bar").show();
    });

    //编辑处理人员
    function addWho(nodeId,id,role){
        who_list[nodeId]=id;
        who_type[nodeId]=role;
    }

    //编辑表单
    function addForm(nodeId,id){
        form_list[nodeId]=id;
    }

    //编辑表单
    function addLineForm(line_id,id){
        line_form_list[line_id]=id;
    }
</script>
</body>
</html>