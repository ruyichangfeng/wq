mui.init();
$(function () {


    var courseid = $('#page-wrap').data('id'),
        isSpecial = $('#page-wrap').data('isspecial'),
        userid = $('#page-wrap').data('userid'),
        buy = $('#page-wrap').data('buy'),
        buymask = $('#page-wrap').data('buymask'),
        collect = $('.btn-like').data('collect'),
        courseName = $('#page-wrap').data('name'),
        collectLock = false, // 收藏锁 防止多次点击
        payLock = false, // 支付锁
        page = 0, // 页数,
        count = 10, // 页数
        jsApiParameters; // js支付参数    
        

    //    收藏-点击更换状态图标
    mui(document.body).on('tap', '.btn-like', function (e) {
        if (collectLock) return;
        var _this = $(this);
        collectLock = true; // 锁
        $.post(SCTOOLS.createUrl('course/CollectCourse'), { courseid: courseid, collect: collect }, function () {
            collectLock = false;// 解锁
            collect = collect == 1 ? 2 : 1;
            var url = SC.THEME_URL + '/assets/';
            if (collect == 1)
                url += 'images/like_sel.png';
            else
                url += 'images/like.png';
            _this.attr('src', url);
        }, 'json')
    });

    //    底部栏-弹窗操作
    mui(document.body).on('tap', '.btn-share', function (e) {
        $('.mask-share').show();
        $('html,body').addClass('mask-bg-fix');
    });
    mui('#page-wrap').on('tap', '.mask-share', function () {
        $(this).hide();
        $('html,body').removeClass('mask-bg-fix');
    });
    mui(document.body).on('tap', '.mask-buy', function () {

        $('.mask-buy').hide();
        $('html,body').removeClass('mask-bg-fix');
    });
    mui(document.body).on('tap', '.pay-pipe', function (e) {
        e.stopPropagation();
        if (buy != 1) {
            // 先检查用户合法性
            $.post(SCTOOLS.createUrl('user/checkUserValid'), {}, function (result) {
                if (!SCTOOLS.checkAjaxResult(result)) {
                    UTIL.layerAlert(result.state.msg);
                    return;
                }
                $('.mask-buy').show();
                $('html,body').addClass('mask-bg-fix');
            }, 'json');
        } else {
            // 已经购买
            if (isSpecial != 1) {
                // 增加学习记录
                $.post(SCTOOLS.createUrl('course/courseStudy'), { courseid: courseid, userid: userid }, function () {
                    window.location.href = SCTOOLS.createUrl('course/CoursePlay', { courseid: courseid });
                }, 'json')
            }
        }
    });
    mui(document.body).on('tap', '.free-pipe', function (e) {
        $(".sqr-mask").removeClass("none");
    });
    $(".sqr-mask .close-btn").on('click', function (e) {
        $(".sqr-mask").addClass("none");
    });
    mui(document.body).on('tap', '.mask-buy-bottom', function (e) {
        e.stopPropagation();
        //        阻止底部栏点击
    });
    //评价弹窗显示时，背景固定不动
    $(function () {
        if ($(".mask-pingjia-content").is(":visible")) {
            $('html,body').addClass('mask-bg-fix');
        }
    });
    // 购买vip
    mui('#page-wrap').on('tap', '#btn-become-vip', function () {
    })

    // 去支付
    $('#page-wrap').delegate('#btn-buy', 'tap', function (e) {
        if (payLock) return;
        payLock = true;
        e.preventDefault();
        e.stopPropagation();
        
        if(pay_type=="1"){
        	$.ajax({
	 		       type: "POST",
	 		       dataType: "json",
	 		       url:SCTOOLS.createUrl(SC.PAY_URL),
	 		       data:{ courseid: courseid, userid: userid }
	    	   	}).done(tee.charge);
        }else{
        	$.post(SCTOOLS.createUrl(SC.PAY_URL), { courseid: courseid, userid: userid }, function (resp) {
        		/*if (result.hasOwnProperty('error')) {
                window.location.href = SCTOOLS.createUrl('course/detail', { id: courseid });
            } else {
                jsApiParameters = result;
                callpay();
            }*/
        		if(resp.status==1){
        			if(resp.data){
        				$('#pay_wechat_params').val(resp.data);
        				$('#pay_wechat').submit();
        			}
        		}else{
        			UTIL.layerAlert(resp.info);
        		}
        	}, 'json');
        }
        


    });

    function callpay() {
        if (typeof WeixinJSBridge == "undefined") {
            if (document.addEventListener) {
                document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
            } else if (document.attachEvent) {
                document.attachEvent('WeixinJSBridgeReady', jsApiCall);
                document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
            }
        } else {
            jsApiCall();
        }
    }


    //调用微信JS api 支付
    function jsApiCall() {
        console.log(jsApiParameters)
        WeixinJSBridge.invoke(
            'getBrandWCPayRequest',
            jsApiParameters,
            function (res) {
                payLock = false;
                var msg = res.err_msg;
                var errcode = res.err_code;
                var errdesc = res.err_desc;
                var tip = '';
                if (msg == 'get_brand_wcpay_request:ok') {
                    tip = '支付成功';
                    setTimeout(function () {
                        window.location.href = SCTOOLS.createUrl('course/detail', { id: courseid });
                    }, 2000);
                } else if (msg == 'get_brand_wcpay_request:cancel') {
                    tip = '支付取消';
                    $('.mask-buy').hide();
                    $('html,body').removeClass('mask-bg-fix');
                } else if (msg == 'get_brand_wcpay_request:fail') {
                    tip = '支付失败:' + errdesc + errcode;
                }
                UTIL.layerAlert(tip);
            }
        );
    }


    // 专题目录点击
    mui('#page-wrap').on('tap', '.ml-item', function (e) {
        console.log(111);
        if (buy == 1) { // 已经购买
            var id = $(this).data('id');
            window.location.href = SCTOOLS.createUrl(SC.PLAY_URL, { id: id });
        }else{
        	var read = $(this).data('read');
        	if(read>0){
        		var id = $(this).data('id');
                window.location.href = SCTOOLS.createUrl(SC.PLAY_URL, { id: id });
        	}else{
	            var mask = mui.createMask();
	            mask.show();
	            $('.mui-backdrop').css('backgroundColor', 'rgba(0,0,0,0.5)');
	            var $html = $('<div class="course-detail-dialog"><div class="icon-close dialog-close-btn"></div><p class="dialog-text">购买后可收听“' + courseName + '”专题</p></div><img class="arrow" src="'+SC.THEME_URL+'/images/arrow.png">');
	            $('.mui-backdrop').append($html);
        	}
        }
    });
    mui('#page-wrap').on('tap', '.way-youhui', function (e) {
        e.stopPropagation();
        window.location.href = SCTOOLS.createUrl("course/favorableGallery", { courseid: courseid });
    });
    //导航栏点击
    mui('#page-wrap').on('tap', '.mui-slider-2 a', function (e) {
        $(this).addClass('slider-active').siblings().removeClass('slider-active');
    });

    mui('#item3mobile').pullToRefresh({
        up: {
            callback: function () {
                var self = this;
                setTimeout(function () {
                    refresh(function (result) {
                        var c = result.data.count;
                        $('#comment-list').append(result.data.html);
                        self.endPullUpToRefresh(c < count);
                    });
                }, 300);
            },
            auto: true
        }
    });

    window.courseDetailPage = 2;

    window.getFlag = true;

    $(".grid-wrap").on("scroll",function(){
        if(window.getFlag){
            var winScrollTop = $(".grid-wrap").scrollTop();
            var cHeight = document.documentElement.clientHeight;
            var sHeight = $(".grid-wrap")[0].scrollHeight;
            console.log(winScrollTop);
            console.log(sHeight);
            console.log((cHeight + winScrollTop) >= (sHeight-1));
            if((cHeight + winScrollTop) >= (sHeight-1)){
                window.getFlag = false;
                $(".no-content-tips .loading").removeClass("none");
                $.post(SCTOOLS.createUrl(SC.GET_MORE_LIST), {
                    special_id: courseid,
                    page: window.courseDetailPage++,
                    count: 9
                }, function (result) {
                    console.log(result)
                    $(".no-content-tips .loading").addClass("none");
                    if(result.data.count==0){
                        window.getFlag = false;
                        $(".grid-wrap").off("scroll");
                        //$(".no-content-tips span").removeClass("none");
                    }
                    $('.grid-list ul').append(result.data.html);
                    window.getFlag = true;
                }, 'json');   
            }
        }    
    });

    $(".fold-btn-wrap").on("click",function(){
        /*$(".detail-content").slideToggle("normal",function(){
            if($(".detail-content").css("display") == "none"){
                $(".fold-btn-hide").removeClass("none");
                $(".fold-btn-show").addClass("none");
            }else{
                $(".fold-btn-hide").addClass("none");
                $(".fold-btn-show").removeClass("none");
            }
        });*/

        if($(".detail-content").hasClass("none")){
            $(".detail-content").removeClass("none");
            $(".fold-btn-hide").addClass("none");
            $(".fold-btn-show").removeClass("none");
        }else{
            $(".detail-content").addClass("none");
            $(".fold-btn-hide").removeClass("none");
            $(".fold-btn-show").addClass("none");
        }
    });


    /**
     * 刷新逻辑
     * @param type
     */
    function refresh(cb) {
        page++;
        $.get(SCTOOLS.createUrl(SC.GET_MORE_LIST), {
            courseid: courseid,
            isspecial: isSpecial,
            page: page,
            count: count
        }, function (result) {
            cb(result);
        }, 'json');
    }

    // 判断是否自动显示购买框

    if (buymask == 1 && buy != 1) {
        $('.mask-buy').show();
        $('html,body').addClass('mask-bg-fix');
    }
})


