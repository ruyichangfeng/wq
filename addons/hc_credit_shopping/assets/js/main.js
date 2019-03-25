Zepto(function($){
	$("div.swipe").Swipe({auto: 3000,callback: function(index, elem) {
		$(elem).closest("div.swipe").find("div.swipe-indicators>span").removeClass("active").eq(index).addClass("active");
	}});
	$("div.dropdown").on("click",'label',function(){
		var par=$(this).parent();
		$("div.dropdown.active").not(par).removeClass("active");
		par.toggleClass("active");
	});
	$(".numberBox span").on("click",function(){
		var input=$(this).parent().find("input"),span=$(this).parent().find("span");
		var val=parseInt(input.val()),maxv=parseInt(input.attr("max"));
		if(isNaN(val))val=1;
		val += $(this).index()==0?-1:1;
		if(val<1){
			val=1;
		}else if(val>maxv){ //限购数量
			val=maxv;
		}
		input.val(val);
	});	
  $('#starInput span').on("click",function(){
	  var idx=Math.ceil(($(this).index()+1)/2);
	  var odd=$('#starInput span:nth-child(odd)');
	  var even=$('#starInput span:nth-child(even)');
	  odd.slice(0,idx).show();
	  odd.slice(idx).hide();
	  even.slice(0,idx).hide();
	  even.slice(idx).show();
	  $("#Star").val(idx);
  });
});