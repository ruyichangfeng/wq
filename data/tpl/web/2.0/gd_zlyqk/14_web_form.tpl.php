<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template("base/child_header", TEMPLATE_INCLUDEPATH)) : (include template("base/child_header", TEMPLATE_INCLUDEPATH));?>
<form class="layui-form" >
    <div class="layui-form-item">
        <label class="layui-form-label">操作</label>
        <div class="layui-input-block">
            <?php  if(is_array($nodeStatus)) { foreach($nodeStatus as $node) { ?>
            <input type="radio" name="do_status" lay-filter="noss" value="<?php  echo $node['id'];?>" title="<?php  echo $node['name'];?>" <?php  if($lineId==$node['id']) { ?>checked<?php  } ?>>
            <?php  } } ?>
        </div>
    </div>
    <?php  echo $html;?>
    <input type="hidden" name="app_id" value="<?php  echo $_GPC['app'];?>">
    <input type="hidden" name="line_id" value="<?php  echo $_GPC['line_id'];?>">
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit="" lay-filter="addAdmin">立即提交</button>
        </div>
    </div>
</form>
<script>
    var $;
    layui.use(['form','jquery','upload'], function(){
        var form = layui.form();
        $ = layui.jquery;

        form.on('radio(noss)', function(data){
            var url="<?php  echo $this->createWebUrl('wDoing')?>&app=<?php  echo $appId;?>&id=<?php  echo $id;?>&line_id="+data.value;
            location.href=url;
        });

        form.on('submit(addAdmin)', function(data){
            if(!$("input[name='do_status']:checked").val()){
                layer.msg("请选择操作",{icon: 2});
                return false;
            }
            var post=$("form").serialize();
            $.post("<?php  echo $this->createWebUrl('doFm')?>&Ajax=",{data:post},function(response){
                layer.msg(response.msg,{icon: response.code});
                if(response.code==1){
                    setTimeout(function(){
                        parent.location.reload();
                    },1000);
                }
            },"json");
            return false;
        });

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


        //删除图片
        $("body").on("click",'.rem',function(){
            $(".img_box").html("");
            $("#cov").val("");
        });
    });

    function setlb(str,ids,id){
        $("#"+id).parent().parent().find("#imgList").find(".b").val(ids);
        $("#"+id).parent().find(".l_box").html(str);
        layer.close(index)
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
