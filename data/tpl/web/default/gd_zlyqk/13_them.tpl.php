<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template("base/child_header", TEMPLATE_INCLUDEPATH)) : (include template("base/child_header", TEMPLATE_INCLUDEPATH));?>
<style>
    #cp1,#cp2,#cp3,#cp4{position: absolute;top:-2px;right: 7px;}
</style>
<div style="width: 350px;float: left;padding-left:10px;padding-top:30px;">
<iframe style="height: 550px;width:350px;overflow: scroll;border: 0;background:#cecece" src="/app/<?php  echo $this->createMobileUrl('index')?>&app_id=<?php  echo $_GPC['app'];?>" id="ifm">
</iframe>
</div>
<div style="width: 400px;float: right;margin-top:30px;">
    <script type="text/javascript" src="<?php echo MODULE_URL;?>/static/color/jquery.js"></script>
    <script type="text/javascript" src="<?php echo MODULE_URL;?>/static/color/jquery.colorpicker.js"></script>
    <form class="layui-form" >
        <input type="hidden" name="app" value="<?php  echo $app;?>">
        <div class="layui-form-item">
            <label class="layui-form-label">页面背景</label>
            <div class="layui-input-block" id="imgList">
                <input type="hidden" id="cov" class="covs" name="bg" value="<?php  echo $them['bg'];?>" >
                <input type="file" name="file" class="layui-upload-file">
                <img src="/<?php  echo $them['bg'];?>" id="imgs"  style=" height:35px;margin-left:20px; <?php  if(empty($them['bg']) ) { ?> display: none; <?php  } ?>">
                <a href="javascript:" class="rem layui-btn layui-btn-danger layui-btn-mini" style="margin-left:15px;padding-left:7px;padding-right:7px;">删除</a>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">显示宽度</label>
            <div class="layui-input-block" style="width: 180px;">
                <input type="text" name="width" required  value="<?php  echo $them['width'];?>"  id="page_width" placeholder="百分数:90%" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">顶部距离</label>
            <div class="layui-input-block" style="width: 180px;">
                <input type="number" name="top" required  id="page_top" value="<?php  echo $them['top'];?>" placeholder="整数，填90就是90px" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">元素间距</label>
            <div class="layui-input-block" style="width: 180px;">
                <input type="number" name="margin" required value="<?php  echo $them['margin'];?>"  id="page_margin" placeholder="整数，填10就是10px" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">元素圆角</label>
            <div class="layui-input-block" style="width: 180px;">
                <input type="number" name="radius" required id="page_radius" value="<?php  echo $them['radius'];?>"   placeholder="整数，填0无圆角" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">主题色调</label>
            <div class="layui-input-block" style="width: 180px;">
                <input type="text" name="them" required id="co1" value="<?php  echo $them['them'];?>"   placeholder="#f08500" autocomplete="off" class="layui-input">
                <img src="<?php echo MODULE_URL;?>/static/color/colorpicker.png" id="cp1" style="cursor:pointer;float: left;margin-top:12px;margin-right:5px;"/>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">字体大小</label>
            <div class="layui-input-block" style="width: 180px;">
                <input type="text" name="font" id="page_font" required value="<?php  echo $them['font'];?>"  placeholder="整数，建议填写15" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">标题颜色</label>
            <div class="layui-input-block" style="width: 180px;">
                <input type="text" name="title" required id="co2" value="<?php  echo $them['title'];?>"  placeholder="#f08500" autocomplete="off" class="layui-input">
                <img src="<?php echo MODULE_URL;?>/static/color/colorpicker.png" id="cp2" style="cursor:pointer;float: left;margin-top:12px;margin-right:5px;"/>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">字体颜色</label>
            <div class="layui-input-block" style="width: 180px;">
                <input type="text" name="body" required id="co3"  value="<?php  echo $them['body'];?>"   placeholder="#f08500" autocomplete="off" class="layui-input">
                <img src="<?php echo MODULE_URL;?>/static/color/colorpicker.png" id="cp3" style="cursor:pointer;float: left;margin-top:12px;margin-right:5px;"/>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">元素边框</label>
            <div class="layui-input-block">
                <input type="radio" name="border" <?php  if(empty($them['border']) || $them['border']==1 ) { ?> checked <?php  } ?> lay-filter="rd" value="1" title="有" checked>
                <input type="radio" name="border" lay-filter="rd" <?php  if($them['border']==0 ) { ?> checked <?php  } ?> value="0" title="无" >
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="addAdmin">保存</button>
            </div>
        </div>
    </form>
</div>
<script>

    layui.use(['form','jquery','upload'], function(){
        var form = layui.form();
        var $ = layui.jquery;
        layui.layer.photos({
            photos: '#imgList'
            ,anim: 5
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
                $("#imgs").show();
                $("#imgs").attr("src","/"+res.url);
                $("#cov").val(res.url);
                setBackground(res.url);
            }
        });

        form.on('radio(rd)', function(data){
            setPageBorder(data.value);
        });

        form.on('submit(addAdmin)', function(data){
            $.post("<?php  echo $this->createWebUrl($_GPC['do'])?>&Ajax=",{them:data.field},function(response){
                layer.msg(response.msg,{icon: response.code});
                if(response.code==1){
                    setTimeout(function(){
                            parent.location.reload();
                    },1000);
                }
            },"json");
            return false;
        });
    });

    $(".rem").click(function(){
        $(this).parent().find("img").hide();
        $(this).parent().find(".covs").val("");
        $("#ifm").contents().find(".them-page").css('background-image',"none");
    });

    $("#page_width").bind("input propertychange change",function(event){
        setPageWidth($(this).val())
    });

    $("#page_top").bind("input propertychange change",function(event){
        setPageTop($(this).val())
    });

    $("#page_margin").bind("input propertychange change",function(event){
        setPageMargin($(this).val())
    });

    $("#page_radius").bind("input propertychange change",function(event){
        setPageRadius($(this).val())
    });

    $("#page_font").bind("input propertychange change",function(event){
        setPageFont($(this).val())
    });

    //标题颜色设置
    $("#co2").bind("input propertychange change",function(event){
        setTitleColor($(this).val())
    });

    //颜色设置
    $("#co3").bind("input propertychange change",function(event){
        setColor($(this).val())
    });

    //主題設置co1
    $("#co1").bind("input propertychange change",function(event){
        setThemColor($(this).val())
    });

    //设置背景
    function setBackground(url){
        //them-page
        // $("#ifm").contents().find(".page__bd").css('background-image','url(/'+url+')');
        $("#ifm").contents().find(".them-page").css('background-image','url(/'+url+')');
    }

    function setPageBorder(border){
        //them-cell
        // if(border==0){
        //     $("#ifm").contents().find(".weui-cell").removeClass("yes_border").addClass("no_border");
        //     $("#ifm").contents().find(".weui-cells_radio").removeClass("yes_border").addClass("no_border");
        //     $("#ifm").contents().find(".weui-cells_form").removeClass("yes_border").addClass("no_border");
        //     $("#ifm").contents().find(".weui-cells_checkbox").removeClass("yes_border").addClass("no_border");
        // }else{
        //     $("#ifm").contents().find(".weui-cell").removeClass("no_border").addClass("yes_border");
        //     $("#ifm").contents().find(".weui-cells_radio").removeClass("no_border").addClass("yes_border");
        //     $("#ifm").contents().find(".weui-cells_form").removeClass("no_border").addClass("yes_border");
        //     $("#ifm").contents().find(".weui-cells_checkbox").removeClass("no_border").addClass("yes_border");
        // }
        if(border==0){
            $("#ifm").contents().find(".them-cell").removeClass("yes_border").addClass("no_border");
        }else{
            $("#ifm").contents().find(".them-cell").removeClass("no_border").addClass("yes_border");
        }
    }

    function setTitleColor(color){
        $("#ifm").contents().find(".them-title").css("color",color);
    }

    function setColor(color){
        $("#ifm").contents().find(".them-cell").css("color",color);
        $("#ifm").contents().find(".them-color").css("color",color);
    }

    function setThemColor(color){
        $("#ifm").contents().find(".weui-btn_primary").css("background",color);
    }

    //设置宽度
    function setPageWidth(width){
        if(width.indexOf('%')==-1){
            width = width+"%";
        }
        //them-tab
        // $("#ifm").contents().find(".weui-tab").css("width",width).css("display","block").css("margin","0 auto");
        $("#ifm").contents().find(".them-tab").css("width",width).css("display","block").css("margin","0 auto");
    }

    //设置顶部距离
    function setPageTop(top){
        //them-tab
        // $("#ifm").contents().find(".weui-tab").css("padding-top",top+"px");
        $("#ifm").contents().find(".them-tab").css("padding-top",top+"px");
    }

    function setPageMargin(margin){
        //them-cell
        // $("#ifm").contents().find(".weui-cell").css("margin-bottom",margin+"px");
        // $("#ifm").contents().find(".weui-cells_radio").css("margin-bottom",margin+"px");
        $("#ifm").contents().find(".them-cell").css("margin-bottom",margin+"px");
    }

    function setPageFont(font){
        //them-cell
        $("#ifm").contents().find(".them-cell").css("font-size",font+"px");
    }

    function setPageRadius(radius){
        //them-cell
        // $("#ifm").contents().find(".weui-cell").css("border-radius",radius+"px");
        // $("#ifm").contents().find(".weui-cells_radio").css("border-radius",radius+"px");
        // $("#ifm").contents().find(".weui-cells_form").css("border-radius",radius+"px");
        // $("#ifm").contents().find(".weui-cells_checkbox").css("border-radius",radius+"px");
        $("#ifm").contents().find(".them-cell").css("border-radius",radius+"px");
    }

    $("#cp1").colorpicker({
        fillcolor:false,
        success:function(o,color){
            setThemColor(color);
            $("#co1").val(color);
        }
    });
    $("#cp2").colorpicker({
        fillcolor:false,
        success:function(o,color){
            setTitleColor(color)
            $("#co2").val(color);
        }
    });
    $("#cp3").colorpicker({
        fillcolor:false,
        success:function(o,color){
            setColor(color)
            $("#co3").val(color);
        }
    });
    $("#cp4").colorpicker({
        fillcolor:false,
        success:function(o,color){
            $("#co4").val(color);
        }
    });
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template("base/child_footer", TEMPLATE_INCLUDEPATH)) : (include template("base/child_footer", TEMPLATE_INCLUDEPATH));?>