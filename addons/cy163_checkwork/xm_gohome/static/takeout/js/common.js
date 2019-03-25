
	//窗口滚动后，导航悬浮
	$(window).scroll(function() {
		if ($(window).scrollTop() > 0) {
			$(".header").addClass('fixedStyle');
		}
		else {
			$(".header").removeClass('fixedStyle');
		}
	});
	$(window).scroll(function() {
		if ($(window).scrollTop() > 0) {
			$(".pro_header").addClass('fixedStyle1');
		}
		else {
			$(".pro_header").removeClass('fixedStyle1');
		}
	});
	$(window).scroll(function() {
		if ($(window).scrollTop() > 0) {
			$(".tab_xuanka").addClass('fixedStyle2');
		}
		else {
			$(".tab_xuanka").removeClass('fixedStyle2');
		}
	});
	$(window).scroll(function() {
		if ($(window).scrollTop() > 0) {
			$("#nav").addClass('fixedstyle3');
		}
		else {
			$("#nav").removeClass('fixedstyle3');
		}
	});
	$(window).scroll(function() {
		if ($(window).scrollTop() > 0) {
			$(".order_right").addClass('fixedstyle4');
		}
		else {
			$(".order_right").removeClass('fixedstyle4');
		}
	});
	
    var swiper = new Swiper('.banner .swiper-container', {
        pagination: '.swiper-pagination',
        paginationClickable: true,
        spaceBetween: 30,
        centeredSlides: true,
        autoplay: 2500,
        autoplayDisableOnInteraction: false
    });
	 var swiper = new Swiper('.menu .swiper-container', {
        pagination: '.swiper-pagination',
        paginationClickable: true,
        spaceBetween: 30,
        centeredSlides: true,
    });
	var tjser = new Swiper('.tj .swiper-container', {
	autoplay: 5000,
	spaceBetween: 7
  });
   var swiper = new Swiper('.wm_banner .swiper-container', {
        pagination: '.swiper-pagination',
        paginationClickable: true,
        spaceBetween: 30,
        centeredSlides: true,
        autoplay: 3000,
        autoplayDisableOnInteraction: false
    });
  var swiper = new Swiper('.imgbox3 .swiper-container', {
        pagination: '.swiper-pagination',
        paginationClickable: true,
        spaceBetween: 30,
        centeredSlides: true,
        autoplay: 5000,
        autoplayDisableOnInteraction: false
    });
  function displayPanel(selector){ 
		var	$self	=$(selector);		//点击的连接标签A
		var	$next	=$self.parent().next('div');//a标签父节点相邻的兄弟节点slidePanel
		var	rowCount	=$next.find('dd').size();	//获取单个li的个数
		var	lineHeight	=$next.find('dd').eq(0).height();	//单个li的高度
		var	minHeight	=lineHeight*1;	//最小显示高度
		var	maxHeight	=rowCount*lineHeight;	//最大显示高度
		var	hasExpend	=$self.hasClass('expend');	//当展开后的标记样式 不需要实质上的任何CSS定义  arraow-up为向上的小箭头样式 arrow-down为向下的小箭头样式
		if(hasExpend){//如果已经展开,则要执行折叠操作
			$next.animate({'height':minHeight+'px'},'slow',function(){
				$self.removeClass('expend arrow-up').addClass('arrow-down');	
			});
		}else{
			$self.addClass('expend');
			$next.animate({'height':maxHeight+'px'},'slow',function(){
				$self.removeClass('arrow-down').addClass('expend arrow-up');	
			});
		}
	
	}
function showdiv(targetid,objN){
   
      var target=document.getElementById(targetid);
      var clicktext=document.getElementById(objN)

            if (target.style.display=="block"){
                target.style.display="none";
                clicktext.innerText="查看更多";
  

            } else {
                target.style.display="block";
                clicktext.innerText='收起';
            }
   
}

var GradList = document.getElementById("QuacorGrading").getElementsByTagName("input");
for(var di=0;di<parseInt(document.getElementById("QuacorGradingValue").getElementsByTagName("font")[0].innerHTML);di++){
	GradList[di].style.backgroundPosition = 'left center';
};
for(var i=0;i < GradList.length;i++){
	//GradList[i].onmouseover = function(){
	GradList[i].onclick = function(){
		for(var Qi=0;Qi<GradList.length;Qi++){
			GradList[Qi].style.backgroundPosition = 'right center';
		}
		for(var Qii=0;Qii<this.name;Qii++){
			GradList[Qii].style.backgroundPosition = 'left center';
		}
		document.getElementById("QuacorGradingValue").innerHTML = '<font>'+this.name+'</font>';
	}
};
var GradList1 = document.getElementById("QuacorGrading1").getElementsByTagName("input");
for(var di=0;di<parseInt(document.getElementById("QuacorGradingValue1").getElementsByTagName("font")[0].innerHTML);di++){
	GradList1[di].style.backgroundPosition = 'left center';
};
for(var i=0;i < GradList1.length;i++){
	//GradList[i].onmouseover = function(){
	GradList1[i].onclick = function(){
		for(var Qi=0;Qi<GradList.length;Qi++){
			GradList1[Qi].style.backgroundPosition = 'right center';
		}
		for(var Qii=0;Qii<this.name;Qii++){
			GradList1[Qii].style.backgroundPosition = 'left center';
		}
		document.getElementById("QuacorGradingValue1").innerHTML = '<font>'+this.name+'</font>';
	}
};
