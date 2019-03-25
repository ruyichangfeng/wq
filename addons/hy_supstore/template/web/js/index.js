$(function(){

    layui.use(['laydate', 'laypage', 'form', 'layer', 'table', 'carousel', 'upload', 'element'], function() {
        var $ = layui.jquery,
            form = layui.form,
            laydate = layui.laydate,
            layer = layui.layer, //弹层
            element = layui.element; //元素操作

        //常规用法
        laydate.render({
            elem: '#starttime'
        });
        laydate.render({
            elem: '#endtime'
        });

        //监听左侧菜单点击
        element.on('nav(left-menu)', function(elem) {
            addTab(elem[0].innerText, elem[0].attributes[1].nodeValue, elem[0].id);
        });

        /**
         * 新增tab选项卡，如果已经存在则打开已经存在的，不存在则新增
         * @param tabTitle 选项卡标题名称
         * @param tabUrl 选项卡链接的页面URL
         * @param tabId 选项卡id
         */
        function addTab(tabTitle, tabUrl, tabId) {
            if ($(".layui-tab-title li[lay-id=" + tabId + "]").length > 0) {
                element.tabDelete('tab-switch', tabId);
                addTab(tabTitle, tabUrl, tabId);
            } else {
                element.tabAdd('tab-switch', {
                    title: tabTitle,
                    content: '<iframe src=' + tabUrl + ' width="100%" style="min-height: 450px;" frameborder="0" scrolling="auto" onload="setIframeHeight(this)"></iframe>', // 选项卡内容，支持传入html
                    id: tabId //选项卡标题的lay-id属性值
                });
                element.tabChange('tab-switch', tabId); //切换到新增的tab上
            }
        }
    });

    //侧边导航切换
    $('#changeSide').on('click',function(){
        if($(this).hasClass('change-side-right')){
            changeRight();
        }else{
            changeLeft();
        }

    })
    //向右切换
    function changeRight(){
        $('#layuiSideIndex').animate({ 
            left: -180,
        }, 500 );
        $('#hrakheight.layui-body').animate({ 
            left: 0,
        }, 500 );
        $('#changeSide').children('i').html('&#xe66b;');
        $('#changeSide').removeClass('change-side-right').addClass('change-side-left');
    }
    //向左切换
    function changeLeft(){
        $('#layuiSideIndex').animate({ 
            left: 0,
        }, 500 );
        $('#hrakheight.layui-body').animate({ 
            left: 180,
        }, 500 );
        $('#changeSide').children('i').html('&#xe668;');
        $('#changeSide').removeClass('change-side-left').addClass('change-side-right');
    }
    //随浏览器宽度 变换导航
    if($(window).width() < 980) changeRight();
    $(window).resize(function () {
        if($(window).width() < 980){
            $('#layuiSideIndex').css('left','-180px');
            $('#hrakheight.layui-body').css('left','0');
            $('#changeSide').children('i').html('&#xe66b;');
            $('#changeSide').removeClass('change-side-right').addClass('change-side-left');
        }else{
            $('#layuiSideIndex').css('left','0');
            $('#hrakheight.layui-body').css('left','180px');
            $('#changeSide').children('i').html('&#xe668;');
            $('#changeSide').removeClass('change-side-left').addClass('change-side-right');
        }
    });
})

/**
 * ifrme自适应页面高度，需要设定min-height
 * @param iframe
 */
function setIframeHeight(iframe) {
    if (iframe) {
        var mydiv = document.getElementById("hrakheight");
        //获取#mydiv的高度
        var divheight = mydiv.offsetHeight;
        iframe.height = divheight - 85;

    }
};