/*
* imgBox - jQuery Plugin
* ！！！！！可惜不兼容firefox 和chrom浏览器
* 简单的点击小图显示大图插件
* Copyright (c) 2011- 2012 流星剑
* 前台调用时需要写属性href=大图地址，title=图片说明文字如：<div class="imgbox" href="UpLoadFiles/20111101/2011110121005745.jpg" title="图片测试效果">
*还需要写一个显示大图的div
*        <div id="box">  需要写上id名称
*                 <div id="close"></div>
*                   <img src="" /></img>
*                <div>  图片测试效果</div>
*       </div>
* 调用时<script type="text/javascript"> $(function () {  $(".imgbox").imgBox({ idName: "#box" }) }) </script>
* Version: 1.0.0 (19/12/2011)
* Requires: jQuery v1.3+
* 博客地址：http://www.cnblogs.com/Jaylong/
* 网址：http://www.51yyx.com
*/

(function ($) {
    $.fn.imgBox = function (opts){
        var width = $(window).width();
        var height = $(window).height();
        var defaults={idName:"#lightbox"};
        var obj= $.extend({}, defaults, opts);
        var id = $(obj.idName);
		var img = new Image();
		$("img",$(this)).css("cursor","pointer");
        id.hide();
        $(this).click(function (e) {
			img.src = $(this).attr("href");
            $("*").stop(); //停止所有正在运行的动画
            id.hide();
			//显示图片加载动画
			var loading="<div id=\"loading\"><img src='Images/loading.gif'/></div>";
			$("body").append(loading);
			$("#loading").css({
			    top: (height-100)/2+"px",
                left: (width-100)/2+"px",
                position: "absolute",
                backgroundColor: "#9c9c9c",
				widht:100+"px"
			})
		//图片加载完成清除loading
            img.onload=function(){
			 	  $("#loading").remove();
		   }
			//图片加载完执行
			if(img.complete)
			{
		   $("#loading").remove();
			 $("img", id).attr("src", img.src);
            $("div:eq(1)", id).html($(this).attr("title"));
            //追加一个层，使背景变灰
            $("body").append("<div id='greybackground'></div>");
            $("#greybackground").css({
                opacity: "0.5",
                height: "100%",
                width: "100%",
                top: 0,
                left: 0,
			  //  cursor:"pointer",
                position: "absolute",
                backgroundColor: "#9c9c9c"
            });
            //设置样式
             id.css({
                position: "absolute",
                border: "5px solid #ccc",
                "text-align": "center",
                width: img.width
              })
            $("#close", id).css({
                position: "absolute",
                top: -13 + "px",
                left: img.width - 10 + "px",
                width: "26px",
                height: "26px",
                background: "url(Images/fancybox.png) -42px 0",
                cursor: "pointer"
            })

            $("div:eq(1)", id).css({
                "font-size": "12px", "font-family": "Arial", margin: "5px"
            })
			 id.css({ "top": (height - img.height) / 2 + "px", "left": (width - img.width) / 2 - 17 + "px", "z-index": 1000 }).fadeIn("slow");
			}     //end 图片加载
        })//end click 事件

       // $("#greybackground").click(function(){
		 //    id.fadeOut("slow");
			// $(this).remove();
	//	})
        $("#close", id).click(function () {
           id.fadeOut("slow");
            $("#greybackground").remove();
        })
    }
}) (jQuery)
