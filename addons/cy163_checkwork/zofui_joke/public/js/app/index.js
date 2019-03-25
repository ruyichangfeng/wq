    (function (doc, win) {
        var docEl = doc.documentElement,
            resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
            recalc = function () {
                var clientWidth = docEl.clientWidth;
                if (!clientWidth) return;
                if (clientWidth >= 750) {
                    docEl.style.fontSize = '40px';
                } else {
                    docEl.style.fontSize = 20 * (clientWidth / 320) + 'px';
                }
                
                //var height = $(doc).height();
                //$('body').height(height+100);
            };

        if (!doc.addEventListener) return;
        win.addEventListener(resizeEvt, recalc, false);
        doc.addEventListener('DOMContentLoaded', recalc, false);
    })(document, window);






	var wxJs = {};	
	wxJs.shareSuccess = function(){
		tool.ajax(tool.url('ajaxdeal','sharesuccess'),'post','json',{uid:settings.uid},function(data){
		},true)
	};


$(function(){


	$('.u-back_btn').click(function(){
		location.href = tool.url('index');
	});

	$('.confirm_btna').click(function(){
		$('.m-share').show();
	});

	$('.m-share').click(function(){
		$(this).hide();
	});

	$('.confirm_btnb').click(function(){
		if( settings.level <= 3 || ( settings.level == 4 && settings.jointype == 1 ) ){

			$('#sub_me').show();
			$('.atom-dialog').css({'top':'-100%'}).animate({
				'top' : '15%'
			},500,'ease',function(){
				$('.atom-dialog').addClass('elastic');
			});

		}else{
			location.href = tool.url('index');
		}
	});

	$('body').off('click','.close_token').on('click','.close_token',function(){
		$('.atom-dialog').animate({
			'top' : '-70%'
		},500,'ease',function(){
			$('#sub_me').hide();
			$('.atom-dialog').removeClass('elastic');
		});
	});


	FastClick.attach(document.body);

	wx.ready(function () {
		sharedata = {
			title: settings.sharetitle,
			desc: settings.sharedesc,
			link: settings.sharelink,
			imgUrl: settings.shareimg,
			success: function(){
				wxJs.shareSuccess();
			},
			cancel: function(){}
		};
		wx.onMenuShareAppMessage(sharedata);
		wx.onMenuShareTimeline(sharedata);
	});
})

	

	
