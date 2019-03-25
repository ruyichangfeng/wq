<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template("base/child_header", TEMPLATE_INCLUDEPATH)) : (include template("base/child_header", TEMPLATE_INCLUDEPATH));?>
<form class="layui-form" style="margin-top: 50px;float: left">
    <input type="hidden" name="member_id" id="member_id"  <?php  if($memberInfo['id']) { ?> value="<?php  echo $memberInfo['id'];?>" <?php  } else { ?> value="0" <?php  } ?>>
    <div class="layui-form-item">
        <label class="layui-form-label">选择应用</label>
        <div class="layui-input-block">
            <input type="hidden" id="app_i" name="app_id" value="0">
            <input type="text" id="app" name="app_name" required=""  style="width: 295px;float: left;margin-right:5px;"  placeholder="选择应用" autocomplete="off" class="layui-input">
            <button  class="layui-btn layui-btn-danger select_app" style="width:100px;float: left" >选择</button>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">创建人</label>
        <div class="layui-input-block">
            <input type="text" id="name" name="name"  style="width: 145px;float: left;margin-right:5px;"   <?php  if($memberInfo['name']) { ?> value="<?php  echo $memberInfo['name'];?>" <?php  } ?> placeholder="姓名" autocomplete="off" class="layui-input">
            <input type="text" id="mobile" name="mobile" style="width: 145px;float: left;margin-right:5px;"  <?php  if($memberInfo['mobile']) { ?> value="<?php  echo $memberInfo['mobile'];?>" <?php  } ?> style="width: 400px"  placeholder="电话" autocomplete="off" class="layui-input">
            <button  class="layui-btn layui-btn-danger save" style="width:100px;float: left" >选择</button>
        </div>
    </div>
    <div class="add_fmo">
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit="" lay-filter="addAdmin">立即提交</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
    </div>
</form>

<script>
    var $;
    var form;
    var laydate;
    var start;
    var select_id;
    var index;
    layui.use(['form','jquery','laydate','upload'], function(){
        form = layui.form();
        $ = layui.jquery;

        $(".save").click(function(){
            var url = "<?php  echo $this->createWebUrl('list',array('tb'=>'member','mode'=>'select'))?>";
            var index = layui.layer.open({
                title : "选择会员",
                type : 2,
                area :["600px","90%"],
                content : url
            });
            return false;
        });

        $("body").on('click','.select_ld',function(){
            var id =select_id = $(this).attr("data-id");
            var url = "<?php  echo $this->createWebUrl('selectL')?>&id="+id;
            index = layui.layer.open({
                title : "请选择",
                type : 2,
                area :["400px","70%"],
                content : url
            });
            return false;
        });

        $(".select_app").click(function(){
            var url = "<?php  echo $this->createWebUrl('list',array('tb'=>'app','mode'=>'select'))?>";
            var index = layui.layer.open({
                title : "选择应用",
                type : 2,
                area :["600px","90%"],
                content : url
            });
            return false;
        });

        form.on('submit(addAdmin)', function(data){
            var post=$("form").serialize();
            $.post("<?php  echo $this->createWebUrl('addPl')?>&Ajax=",{post:post},function(response){
                layer.msg(response.msg,{icon: response.code});
                if(response.code==1){
                    setTimeout(function(){
                        location.reload();
                    },1000);
                }
            },"json");
            return false;
        });

        laydate = layui.laydate;
        start = {
            max: '2099-06-16 23:59:59'
            ,istoday: true
            ,choose: function(datas){
                end.min = datas;
                end.start = datas;
            }
        };
        $("body").on("click","#LAY_demorange_s",function(){
            start.elem = this;
            laydate(start);
        });

        start = {
            max: '2099-06-16 23:59:59'
            ,istoday: true
            ,format: 'YYYY-MM-DD hh:mm:ss',
            istime: true
            ,choose: function(datas){
                end.min = datas;
                end.start = datas;
            }
        };

        $("body").on("click","#LAY_demorange_t",function(){
            start.elem = this;
            laydate(start);
        });

        //删除图片
        $("body").on("click",'.rem',function(){
            $(".img_box").html("");
            $("#cov").val("");
        });

        $("body").on('click','.s_lb',function(){
            var url = "<?php  echo $this->createWebUrl('selectB')?>&id="+$(this).attr("id");
            index = layui.layer.open({
                title : "选择标签",
                type : 2,
                area :["600px","90%"],
                content : url
            });
            return false;
        });

    });


    function pluginSelectMember(id,name,mobile){
        $("#member_id").val(id);
        $("#name").val(name);
        $("#mobile").val(mobile);
    }

    function setS(str){
        $("#ld_"+select_id).val(str);
        layui.layer.close(index);
    }

    function setlb(str,ids,id){
        $("#"+id).parent().parent().find("#imgList").find(".b").val(ids);
        $("#"+id).parent().find(".l_box").html(str);
        layer.close(index)
    }

    function pluginSelectApp(id,name){
        $("#app").val(name);
        $("#app_i").val(id);
        //获取需要填写的表单
        $.post("<?php  echo $this->createWebUrl('getFmo')?>",{app_id:id},function(response){
            if(response !=""){
                $(".add_fmo").html(response);
                layui.upload({
                    elem: '.layui-upload-file',
                    url: "<?php  echo $this->createWebUrl('upload')?>",
                    method: 'post',
                    ext:'jpg|png|gif',
                    success: function (res) {
                        layui.layer.msg(res.msg);
                        if(res.code==2){
                            return false;
                        }
                        $(".img_box").append(' <img src="/'+res.url+'" id="imgs"  style=" height:35px;margin-left:20px;">');
                        $("#cov").val($("#cov").val()+","+res.url);
                    }
                });
                layui.upload({
                    elem: '.layui-file',
                    title: '附件上传',
                    url: "<?php  echo $this->createWebUrl('upload')?>&fj=1",
                    method: 'post',
                    type: 'file',
                    ext:'zip|rar|doc|docx|txt|xls|xlsx|pdf',
                    success: function (res,input) {
                        var atrr = input.getAttribute('id');
                        layui.layer.msg(res.msg);
                        if(res.code==2){
                            return false;
                        }
                        var vObj=$("#"+atrr+"_n");
                        var lObj =$("#"+atrr+"_l");
                        vObj.parent().find(".file_box").append("<span onclick='rmv($(this))'  class='layui-btn layui-btn-mini'>"+res.name+"</span>")
                        vObj.val((vObj.val()=="")?res.name:vObj.val()+","+res.name);
                        lObj.val((lObj.val()=="")?res.url:lObj.val()+","+res.url);
                    }
                });
                form.render();
            }
        });
    }


    function rmv(that){
        var text = that.text();
        //删除文件名
        var txt = that.parent().parent().find(".lb");
        var tArr = txt.val().split(",");
        var index = 0;
        for(i=0;i<tArr.length;i++){
            if(tArr[i]==text){
                index =i;
                continue;
            }
        }
        tArr.splice(index,1)
        txt.val(tArr.join(","))

        //删除文件路径
        var txt = that.parent().parent().find(".fj");
        var tArr = txt.val().split(",");
        tArr.splice(index,1)
        txt.val(tArr.join(","))
        that.remove();
    }

</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template("base/child_footer", TEMPLATE_INCLUDEPATH)) : (include template("base/child_footer", TEMPLATE_INCLUDEPATH));?>
