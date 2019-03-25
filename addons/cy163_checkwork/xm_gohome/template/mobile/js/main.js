/*绑定touchstart事件*/
//var btn = $(".btn");
//document.body.addEventListener('touchstart', function () { }); 
$("body").on('touchstart', function () { }); 
var h = document.documentElement.clientHeight;
var w = document.documentElement.clientWidth;
$("#page0").css('min-height',h);
$(".top-con").css('height',h);
$(".slideToppic").css('min-height',h);
$("#paiming").css('width',w);
$(window).resize(function(){
	var h = document.documentElement.clientHeight;
	var w = document.documentElement.clientWidth;
	$("#page0").css('min-height',h);
	$(".slideToppic").css('min-height',h);
	$("#paiming").css('width',w);
	//alert("窗口尺寸变了");
	})
//提示弹出及关闭
	$(".tanchu").css('height',h);
	$(".dt-btn").on("click",function(){
		//$(".tanchu").show();
		$(".tanchu").show('');
		/*$(".tanchu").animate({
  opacity: 0.75, left: '50px',
  color: '#abcdef',
  rotateZ: '45deg', translate3d: '0,10px,0'
}, 500, 'ease-in')*///动画
	});
$("#yanshi").on("click",function(){
		$("#shenqing").fadeIn();
		/*$("#sqform").animate({
			  opacity: 0.75, height:'toggle'
			}, 500, 'ease-in')*/
	});
$(".close").on("click",function(){
		$("#shenqing").fadeOut();
	});

//导航跟踪
if(pagename=='index'){
	$(".xm #index").addClass("active");
	$(".xm #index").siblings('').removeClass("active");
};
if(pagename=='orderlist'){
	$(".xm #orderl").addClass("active");
	$(".xm #orderl").siblings('').removeClass("active");
};
if(pagename=='ucindex'){
	$(".xm #ucindex").addClass("active");
	$(".xm #ucindex").siblings('').removeClass("active");
};
if(pagename=='fwsm'){
	$(".xm #fwsm").addClass("active");
	$(".xm #fwsm").siblings('').removeClass("active");
};
if(pagename=='cjwt'){
	$(".xm #cjwt").addClass("active");
	$(".xm #cjwt").siblings('').removeClass("active");
};