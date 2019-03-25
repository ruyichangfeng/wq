$(function () {
    var $outline = $('#outline'),
        player = $('audio').audioPlayer(),
        page = 0,
        count = 10,
        $page = $('#page-wrap'),
        courseid = $page.data('courseid'),
        isSpecial = $page.data('special'),
        name = $page.data('name'),
        requstionLock = false,// 提问锁
        pullObject = null;
    
    var audio = document.querySelector('audio');

    /**
     * 创建图文轮播效果
     * 
     */
    function createSlider() {
        var $sliderItem = $('<div class="mui-slider-item"><a href="#"></div>'),
            $img = outlineConvertToObject($outline),
            imgLength = $img.length,
            $slider = $('.mui-slider-group'),
            $currentPicIndex = $('#currentPicIndex'),
            $textIntro = $('#textIntro'),
            $totalPicCount = $('#totalPicCount');
        
        if (imgLength != 0) {
            for (var i = 0; i < imgLength; i++) {
                var $target = $sliderItem.clone().append($img[i].img);
                $slider.append($target);
            }

            $totalPicCount.text(imgLength);
            
            $textIntro.html($img[0].text).scrollTop(0);

            mui('.mui-slider').slider({ interval: 0 });    // 设置手动滑动图片

            $('.mui-slider')
                .on('slide', function (e) { // 图片序号展示
                    var index = event.detail.slideNumber;
                    $currentPicIndex.text(index + 1);
                    $textIntro
                        .html($img[index].text)
                        .animate({ scrollTop: 0 }, 500);
                })
                .css({
                    'absolute': 'absolute',
                    'top': '50%',
                    'transform': 'translate(0, -50%)',
                    '-webkit-transform': 'translate(0, -50%)'
                });

            $('.imgCountTip').show();

        } else {
            $slider.append($('#cover').clone());
        }
    }
    
    /**
     * 获取图片数量
     * @returns
     */
    function getImgNumber(){
    	$img = outlineConvertToObject($outline);
        return $img.length;
    }

    /**
     * outline dom 结构转为Object
     *    
     * @returns 
     */
    function outlineConvertToObject($obj) {
        var outlineImgIndex = [],
            outline = [],
            paragraph = $obj.children('p'),
            paragraphLength = paragraph.length;


        for (var i = 0; i < paragraphLength; i++) {
            if ($(paragraph[i]).find('img').length > 0) {
                var outlineObject = {
                    img: null,
                    text: ''
                };
                outlineImgIndex.push(i);
                outlineObject.img = $($(paragraph[i]).find('img')).clone();
                for (var j = i + 1; j < paragraphLength; j++) {
                    if ($(paragraph[j]).find('img').length > 0) {
                        break;
                    } else {
                        outlineObject.text += '&nbsp;&nbsp;&nbsp;&nbsp;' + $(paragraph[j]).text() + '</br>';
                    }
                }
                outline.push(outlineObject);
            }
        }

        return outline;
    }

    /**
     * 移动播放器
     * 
     */
    function movePlayer() {
        console.log(location.hash);
        var $audioplayer = $('.audioplayer').find('audio').get(0);
        try {
        	var isPlaying1 = !audio.paused;
        } catch(err) {
        }
        
        if (location.hash === '#/detail' || location.hash === '#/message') {
            if ($('.course-play-audio').children('.audioplayer').length != 0) {
                $('.audioplayer').addClass('detail-audioplayer');
                $('.audioplayer-playpause').addClass('detail-playpause');
                $('.audioplayer-time').addClass('none');
                $('.audioplayer-bar').addClass('detail-playbar');
                $('#audio-control').append($('.audioplayer'));
            }
        } else if (location.hash === '') {
            if ($('.course-play-audio').children('.audioplayer').length == 0) {
                $('.audioplayer').removeClass('detail-audioplayer');
                $('.audioplayer-playpause').removeClass('detail-playpause');
                $('.audioplayer-time').removeClass('none');
                $('.audioplayer-bar').removeClass('detail-playbar');
                $('.course-play-audio').prepend($('.audioplayer'));
            }
        }
        try {
        	var isPlaying2 = !audio.paused;
        	if (isPlaying1 && !isPlaying2) {
        		audio.play();
        	}
        } catch(err) {
        }

    }

    /**
     * 监听路由变化
     * 
     * @param {any} cb 
     */
    function hashChangeListener(target, cb) {
        $(window).on('hashchange', function () {
            if (location.hash === target) {
                cb();
            }
        });
    }


    /**
     * 展示详情页
     * 
     */
    function showDetail() {
        //UTIL.changeTitle(name);
        showModule(['course-play-detail', 'player-box']);
        movePlayer();
    }

    /**
     * 展示留言板
     * 
     */
    function showMessage() {
        //UTIL.changeTitle('讨论区');
        showModule(['course-play-message', 'player-box']);
        movePlayer();
    }

    /**
     * 展示播放页
     * 
     */
    function showPlayer() {
       // UTIL.changeTitle(name);
        showModule(['player']);
        movePlayer();
    }
    
    /**
     * 显示图片左右滑动提示指导语
     * @returns
     */
    function showImgTips(){
    	$('.course-play-welcome')
        .show()
        .click(function () {
            $(this).hide();
        });
    }

    /**
     * 初始化页面
     * 
     */
    function initPage() {
        switch (location.hash) {
            case '#/detail':
                showDetail();
                break;
            case '#/message':
                showMessage();
                break;
            case '':
                showPlayer();
                if(localStorage.getItem('is_showed_welcome_page') == null && getImgNumber() > 1){
                	showImgTips();
                	localStorage.setItem('is_showed_welcome_page', true);
                }
                break;
                
        }

        hashChangeListener('#/detail', showDetail);
        hashChangeListener('#/message', showMessage);
        hashChangeListener('', showPlayer);
        createSlider();
        // 问答列表

        pullObject = mui('#message').pullToRefresh({

            up: {
                callback: function () {
                    console.log("callback");
                    var self = this;
                    setTimeout(function () {
                        refresh(function (result) {
                            var c = result.data.count;

                            $('#wenda-list').append(result.data.html);
                            if(c == 0){
                            	setNoMoreContentTips('<div style="padding-top: 2rem;">还没有评论哦，来第一个评论吧！</div>', c < count);
                            }else {
                            	self.endPullUpToRefresh(c < count);
                            }
                        });
                    }, 300);
                },
                auto: true
            }
        });
        
        // 监听页面关闭前的事件
        window.onbeforeunload = function () {
            player[0].pause();
            $('video')[0].pause();
        }

        var btnSubmit = $('#btn-huida'),
            inp = $('#inp-huida');
        // 回答问题  tap导致失效
        $('#page-wrap').on('touchend', '.btn-huida', function (e) {
            e.preventDefault();
            e.stopPropagation();
            var id = $(this).data('id');
            var name = $(this).parent().parent().find('.name').text();
            inp.attr('placeholder', '回复：' + name);
            // 设置按钮的id跟按钮的逻辑类型
            btnSubmit.data('id', id);
            btnSubmit.data('type', 2);
            btnSubmit.text('回复');
            inp.trigger('click').focus();
        });

        btnSubmit.on('click', function () {


            if (requstionLock) return;
            var _this = $(this);
            var content = inp.val();
            var type = _this.data('type'); //1 提问  2回复
            var m = type == 1 ? '评论' : '回复';
            var msg = m + '内容不能为空';
            if (!content) {
                UTIL.layerAlert(msg);
                return;
            }
            requstionLock = true;
            var post = { courseid: courseid, content: content };
            if (type != 1) {
                post['id'] = _this.data('id');
            }

//            alert(SCTOOLS.createUrl('course/ajaxQA'));

            $.post(SCTOOLS.createUrl(SC.COMMT_URL,{op:'tj'}), post, function (result) {
                requstionLock = false;
                if (!SCTOOLS.checkAjaxResult(result)) {
                    UTIL.layerAlert(result.state.msg);
                    return;
                }
                // $('#wrap').animate({scrollTop:0},500);                           
                inp.val('');
                UTIL.layerAlert(m + "成功");
                btnSubmit.data('type', 1);
                // btnSubmit.text('提问');
                inp.attr('placeholder', '说点什么吧');
                setTimeout(function () {
                    page = 0;
                    refresh(function (result) {

                        pullObject.options.up.contentnomore = '没有更多数据';

                        $('#wenda-list').html(result.data.html);
                        setNoMoreContentTips('没有更多数据', true);
                        $('.audio-comment-times').html('&nbsp;' + (parseInt($('.audio-comment-times').text()) + 1));
                    });
                }, 200);
            }, 'json');
        });


        $('.audioplayer-playpause').on('click', function () {
            $('.audio-rotating').show();
            t = setInterval(loop, 500);
        })

        // 失去焦点, 键盘开始收起, 隐藏inputBox; 等键盘完全收起, 再显示inputBox, 设置在底部, 避免闪跳
        $('input').focus(function () {
            $('#message').scrollTop(1000)
        })

    }


    function loop() {
    	try {
	        var buffered = audio.buffered,
	            loaded = 0;
	        
	        if (buffered.length) {
	        	if(buffered.end(0)>10){
	        		clearInterval(t);
	                $('.audio-rotating').remove();
	        	}
	            loaded = buffered.end(0) / audio.duration;
	        }
	        if (loaded > 0.1) {
	            clearInterval(t);
	            $('.audio-rotating').remove();
	        } 
    	}catch(err){
    		clearInterval(t);
            $('.audio-rotating').remove();
    	}
        
    }
    
    /**
     * 设置没有更多评论提示语
     * @param pullObject
     * @param contentnomore
     * @param isEndUp
     * @returns
     */
    function setNoMoreContentTips(contentnomore, isEndUp){
    	pullObject.options.up.contentnomore = contentnomore;
    	pullObject.endPullUpToRefresh(isEndUp);
    }


    /**
     * 计算行数函数
     * 
     * @param {any} ele 
     * @returns 
     */
    function countLines(ele) {
        var styles = window.getComputedStyle(ele, null);
        var lh = parseInt(styles.lineHeight, 10);
        var h = parseInt(styles.height, 10);
        var lc = Math.round(h / lh);
        //console.log('line count:', lc, 'line-height:', lh, 'height:', h);
        return lc;
    }

    /**
     * 刷新逻辑
     * @param type
     */
    function refresh(cb) {
        console.log("in refresh");
        page++;
        $.get(SCTOOLS.createUrl(SC.COMMT_URL), {
            courseid: courseid,
            page: page,
            count: count
        }, function (result) {
            console.log("cb");
            cb(result);
            _txtOpenControl();
        }, 'json');
    }

    /**
     * 文字超过3行显示展开全文控制
     * @private
     */
    function _txtOpenControl(hideTxt) {
        var target = $('.txt');
        target.each(function (index, obj) {
            var exec = true;
            // 点击全部回答
            if (hideTxt) {
                var hide = $(obj).parent().data('hide');
                if (hide != 1) exec = false;
            }
            if (exec) {
                var num = countLines(obj);
                if (num >= 4) {
                    $(obj).addClass('line-clamp-3');
                    $(obj).parent().find('.btn-show-all').show();
                }
            }
        })
    }

    /**
     * 控制模块展示，隐藏
     * 
     * @param {Array} moduleName 
     */
    function showModule(moduleName) {
        $('.module').hide();
        for (var i = 0; i < moduleName.length; i++) {
            $('.' + moduleName[i]).show();
        }
    }
    //阻止微信下拉漏底
    function preventDrapdown(){
        $('.course-play-slider').on('touchmove', function (e) {
            $('body').on('touchmove', function (e) {
                e.preventDefault(); 
            }); 
        });
        $('.course-play-slider').on('touchend', function (e) {
            $('body').off('touchmove');
        });

        $(".imgCountTip").on('touchmove',function(e){
            $('body').on('touchmove', function (e) {
                e.preventDefault(); 
            });
        });
        
        $('.textIntro').bind('touchstart',function(e){
            startX = e.originalEvent.changedTouches[0].pageX,
            startY = e.originalEvent.changedTouches[0].pageY;
        });
        $('.textIntro').bind('touchmove',function(e){
            //获取滑动屏幕时的X,Y
            endX = e.originalEvent.changedTouches[0].pageX,
            endY = e.originalEvent.changedTouches[0].pageY;
            //获取滑动距离
            distanceX = endX-startX;
            distanceY = endY-startY;
            //判断滑动方向
            if(Math.abs(distanceX)<Math.abs(distanceY) && distanceY<0){
                console.log('往上滑动');
                if(($(".textIntro").scrollTop()+$(".textIntro")[0].offsetHeight)>=$(".textIntro")[0].scrollHeight){
                    $('body').on('touchmove', function (e) {
                        e.preventDefault(); 
                    });
                }

            }else if(Math.abs(distanceX)<Math.abs(distanceY) && distanceY>0){
                console.log('往下滑动');
                if($(".textIntro").scrollTop() <= 0){
                    $('body').on('touchmove', function (e) {
                        e.preventDefault(); 
                    });
                }         
            }else{
                console.log('点击未滑动');
            }
        });
        $('.textIntro').on('touchend', function (e) {  
            $('body').off('touchmove');     
        });
        
    }

    preventDrapdown();

    initPage();

})