(function($) {
	$(".joa_load_app").live('click', function() {
		var pid = $(this).attr("data-pid");
		if(!$.yangtata.dialog.islogin()) return ;
		$.ajax({
			url: yangtataER.root + '/?m=ajax&a=like',
				type: 'POST',
				data: {
				pid: pid
			},
			dataType: 'json',
			success: function(result){
				if(result.status == 1){
					$.yangtata.tip({content:result.msg, icon:'success'});
				}else if(result.status == 2){
					$.yangtata.tip({content:result.msg, icon:'error'});
				}else{
					$.yangtata.tip({content:result.msg, icon:'error'});
				}
			}
		});
		  
	});

})(jQuery);