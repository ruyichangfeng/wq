$(function() {

	//进入页面初始化数据
	$(".head-title:eq(1)").css("color", "#1E90FF");
	$(document).on("click", "#phone-money li", function() {
		//		获取用户手机和所选金额
		$("#phone-money li").removeClass("money-click");
		$(this).addClass("money-click");
	})
})
