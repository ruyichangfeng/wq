define(function(require, exports, module) {

	var ProgressBar = require('../lib/progressbar');


	// Android 2.3.x 动画退化处理
	function decideAndroid23(ua) {
		ua = (ua || navigator.userAgent).toLowerCase();
		return ua.match(/android.2\.3/) ? true : false;
	}

	if(decideAndroid23()){
		$("body").addClass("android23");
	}



	/*
	 * 生成会员身份态环形图表
	 * 
	 * @param {string} wrapper - wrapper div
	 * @param {int} v1 - 游戏加成当前值
	 * @param {int} v2 - 成长加速当前值
	 * @param {int} v3 - 等级加速当前值
	 * @param {int} s1 - 超会对应的游戏加成值
	 * @param {int} s2 - 超会对应的成长加速值
	 * @param {int} s3 - 超会对应的等级加速值
	 * @param {int} sum1 - 游戏加成最大值
	 * @param {int} sum2 - 成长加速最大值
	 * @param {int} sum3 - 等级加速最大值
	 * @param {int} duration - 动画时长
	 * @param {function} fn  - 短时间内连续快速点击 5 次后调用的函数
	 *
	 */
	function drawVipDount(wrapper, v1, v2, v3, s1, s2, s3, sum1, sum2, sum3, duration, fn) {

	    var played = false,	// 动画是否已经播放过
	    	$svg = $(wrapper),
	        $avatar = $('.avatar'),
	        $front = $avatar.find('.front'),
	        $back = $avatar.find('.back'),
	        $num1 = $('.desc p:nth-child(3) em'),
	        $num2 = $('.desc p:nth-child(2) em'),
	        $num3 = $('.desc p:nth-child(1) em'),

	        tmp1 = 0,
	        tmp2 = 0,
	        tmp3 = 1,

	        click = 0,		// 快速点击5次头像彩蛋标识符
	        threshold = 3,	// 距离圆环多远时执行动画
	        dountTop = $svg.offset().top,
	        dountHeight = $svg.height(),
	        screenHeight = document.documentElement.clientHeight;

	        $num1.text(tmp1);
	        $num2.text(tmp2);
	        $num3.text(tmp3);

	        $front.css({'-webkit-transition': 'all ease '+duration+'ms'});
	        $back.css({'-webkit-transition': 'all ease '+duration+'ms'});
	        $front.append('<span class="circle"></span>');

	    var circle1 = new ProgressBar.Circle(wrapper, {
	        color: '#ff7c75',
	        strokeWidth: 6.4,
	        trailColor: 'transparent',
	        duration: duration
	    });
	    circle1.svg.setAttribute('viewBox', '-30 -30 160 160');


	    var circle2 = new ProgressBar.Circle(wrapper, {
	        color: '#f9625a',
	        strokeWidth: 5,
	        trailColor: 'transparent',
	        duration: duration
	    });
	    circle2.svg.setAttribute('viewBox', '-11 -11 122 122');


	    var circle3 = new ProgressBar.Circle(wrapper, {
	        color: '#ee362c',
	        strokeWidth: 4,
	        trailColor: 'transparent',
	        duration: duration
	    });

	    
	    var circle4 = new ProgressBar.Circle(wrapper, {
	        color: '#fee682',
	        strokeWidth: 6.4,
	        trailColor: '#f9f9f9',
	        duration: duration
	    });
	    circle4.svg.setAttribute('style', '-webkit-transform: rotate('+v1/sum1*360+'deg); z-index: 1;')
	    circle4.svg.setAttribute('viewBox', '-30 -30 160 160');
	    

	    var circle5 = new ProgressBar.Circle(wrapper, {
	        color: '#fddd59',
	        strokeWidth: 5,
	        trailColor: '#f9f9f9',
	        duration: duration
	    });
	    circle5.svg.setAttribute('style', '-webkit-transform: rotate('+v2/sum2*360+'deg); z-index: 1;')
	    circle5.svg.setAttribute('viewBox', '-11 -11 122 122');


	    var circle6 = new ProgressBar.Circle(wrapper, {
	        color: '#fcd73e',
	        strokeWidth: 4,
	        trailColor: '#f9f9f9',
	        duration: duration
	    });
	    circle6.svg.setAttribute('style', '-webkit-transform: rotate('+v3/sum3*360+'deg); z-index: 1;')


	    // 滚动触发动画
	    $(window).on('scroll', function() {
	        if (document.body.scrollTop + screenHeight >= dountTop + dountHeight + threshold && document.body.scrollTop <= dountTop - threshold) {
	            dountAnimate();
	        } else {
	            played = false;
	        }
	    });


	    if (document.body.scrollTop + screenHeight >= dountTop + dountHeight + threshold && document.body.scrollTop <= dountTop - threshold) {
	        dountAnimate();
	    }

	    // 点击触发动画
	    $avatar.on('tap', function() {
	        click++;
	        if (click >= 5) {
	            fn ? fn() : '';
	        }
	        else {
	            throttle(function() {
	                click = 0;
	            }, 1500);
	            if (!$avatar.hasClass('switch')) {
	                dountAnimate();
					$avatar.addClass('active');
					setTimeout(function(){
					  	$avatar.removeClass('active');
					}, 100);
	            }
	        }
	    });


	    // 圆环动画
	    function dountAnimate() {
	        if (played === true) {
	            return;
	        }
	        played = true;

	        if (circle1.value() < 0.001) {
	        	tmp1 = numChange(1, $num1, tmp1, v1, v1/8, 0);
		        tmp2 = numChange(1, $num2, tmp2, v2, v2/8, 0);
		        tmp3 = numChange(1, $num3, tmp3, v3, v3/8, 1);

	            circle1.animate(v1/sum1, function() {
	                setTimeout(function() {
	                    $avatar.addClass('switch');
	                    tmp1 = numChange(1, $num1, tmp1, s1, (s1-v1)/8, 0);
	                    circle4.animate(s1/sum1-v1/sum1, function() {
	                        setTimeout(function() {
	                            $avatar.removeClass('switch');
	                            tmp1 = numChange(0, $num1, tmp1, v1, (s1-v1)/8, 0);
	                            circle4.animate(0, function() {
	                            	played = false;
	                            	$front.addClass('wave');
	                            });
	                        }, 500);
	                    });
	                }, 300);
	            });
	            circle2.animate(v2/sum2, function() {
	                setTimeout(function() {
	                    tmp2 = numChange(1, $num2, tmp2, s2, (s2-v2)/8, 0);
	                    circle5.animate(s2/sum2-v2/sum2, function() {
	                        setTimeout(function() {
	                            tmp2 = numChange(0, $num2, tmp2, v2, (s2-v2)/8, 0);
	                            circle5.animate(0, function() {
	                            	played = false;
	                            });
	                        }, 500);
	                    });
	                }, 300)
	            });
	            circle3.animate(v3/sum3, function() {
	                setTimeout(function() {
	                    tmp3 = numChange(1, $num3, tmp3, s3, Math.abs((s3-v3-1)/8), 1);
	                    circle6.animate(s3/sum3-v3/sum3, function() {
	                        setTimeout(function() {
	                            tmp3 = numChange(0, $num3, tmp3, v3, Math.abs((s3-v3-1)/8), 1);
	                            circle6.animate(0, function() {
	                            	played = false;
	                            });
	                        }, 500);
	                    });    
	                }, 300)
	            });
	        }
	        else {
	        	$front.removeClass('wave');
	        	tmp1 = numChange(1, $num1, tmp1, s1, (s1-v1)/8, 0);
		        tmp2 = numChange(1, $num2, tmp2, s2, (s2-v2)/8, 0);
		        tmp3 = numChange(1, $num3, tmp3, s3, (s3-v3)/8, 1);

	            $avatar.addClass('switch');
	            circle4.animate(s1/sum1-v1/sum1, function() {
	                setTimeout(function() {
	                    $avatar.removeClass('switch');
	                    tmp1 = numChange(0, $num1, tmp1, v1, (s1-v1)/8, 0);
	                    circle4.animate(0, function() {
	                    	played = false;
	                    	$front.addClass('wave');
	                    });
	                }, 300);
	            });
	            circle5.animate(s2/sum2-v2/sum2, function() {
	                setTimeout(function() {
	                    tmp2 = numChange(0, $num2, tmp2, v2, (s2-v2)/8, 0);
	                    circle5.animate(0, function() {
	                    	played = false;
	                    });
	                }, 300);
	            });
	            circle6.animate(s3/sum3-v3/sum3, function() {
	                setTimeout(function() {
	                    tmp3 = numChange(0, $num3, tmp3, v3, Math.abs((s3-v3-1)/8), 1);
	                    circle6.animate(0, function() {
	                    	played = false;
	                    });
	                }, 300);
	            });
	        }
	    }
	}





	/*
	 * 生成超级会员身份态环形图表
	 * 
	 * @param {string} wrapper - wrapper div
	 * @param {boolean} isSvip8 - 是否 SVIP8
	 * @param {int} rank - 好友圈排名
	 * @param {int} s1 - 游戏加成当前值
	 * @param {int} s2 - 成长加速当前值
	 * @param {int} s3 - 等级加速当前值
	 * @param {int} sum1 - 游戏加成最大值
	 * @param {int} sum2 - 成长加速最大值
	 * @param {int} sum3 - 等级加速最大值
	 * @param {int} duration - 动画时长
	 * @param {function} fn  - 短时间内连续快速点击 5 次后调用的函数
	 *
	 */
	function drawSvipDount(wrapper, isSvip8, rank, s1, s2, s3, sum1, sum2, sum3, duration, fn) {

	    var played = false,
	    	$svg = $(wrapper),
	        $avatar = $('.avatar'),
	        $front = $avatar.find('.front'),
	        $back = $avatar.find('.back'),
	        // $other = $avatar.find('.other'),
	        $desc = $('.desc'),
	        $num1 = $('.desc p:nth-child(3) em'),
	        $num2 = $('.desc p:nth-child(2) em'),
	        $num3 = $('.desc p:nth-child(1) em'),

	        tmp1 = sum1,
	        tmp2 = sum2,
	        tmp3 = sum3,

	        click = 0,
	        threshold = 3,
	        delay = 0,
	        dountTop = $svg.offset().top,
	        dountHeight = $svg.height(),
	        screenHeight = document.documentElement.clientHeight;

	        $num1.text(sum1);
	        $num2.text(sum2);
	        $num3.text(sum3);

	        if (isSvip8) {
	            tmp1 = 0;
	            tmp2 = 0;
	            tmp3 = 0;
	            $num1.text(0);
	            $num2.text(0);
	            $num3.text(0);
	        }
	        $front.css({'-webkit-transition': '-webkit-transform ease 700ms'});
	        $back.css({'-webkit-transition': '-webkit-transform ease 700ms'});
	        $back.append('<span class="circle"></span>');
	        // $other.css({'-webkit-transition': '-webkit-transform ease 700ms'});


	    var circle1 = new ProgressBar.Circle(wrapper, {
	        color: '#fee682',
	        strokeWidth: 6.4,
	        trailColor: '#f9f9f9',
	        easing: "easeOut",
	        duration: duration
	    });
	    if (!isSvip8) {
	        circle1.set(1);
	    }
	    circle1.svg.setAttribute('viewBox', '-30 -30 160 160');


	    var circle2 = new ProgressBar.Circle(wrapper, {
	        color: '#fddd59',
	        strokeWidth: 5,
	        trailColor: '#f9f9f9',
	        easing: "easeOut",
	        duration: duration
	    });
	    if (!isSvip8) {
	        circle2.set(1);
	    }
	    circle2.svg.setAttribute('viewBox', '-11 -11 122 122');


	    var circle3 = new ProgressBar.Circle(wrapper, {
	        color: '#fcd73e',
	        strokeWidth: 4,
	        trailColor: '#f9f9f9',
	        easing: "easeOut",
	        duration: duration
	    });
	    if (!isSvip8) {
	        circle3.set(1)
	    }


	    // 滚动触发动画
	    $(window).on('scroll', function() {
	        if (document.body.scrollTop + screenHeight >= dountTop + dountHeight + threshold && document.body.scrollTop <= dountTop - threshold) {
	            dountAnimate();
	        } else {
	            if (played === false && (document.body.scrollTop >= dountTop + dountHeight || document.body.scrollTop < dountTop - screenHeight)) {
	                if (isSvip8) {
	                    tmp1 = numChange(0, $num1, tmp1, 0, sum1/(duration/100), 0);
	                    tmp2 = numChange(0, $num2, tmp2, 0, sum2/(duration/100), 0);
	                    tmp3 = numChange(0, $num3, tmp3, 0, sum3/(duration/100), 1);    
	                    circle1.animate(0);
	                    circle2.animate(0);
	                    circle3.animate(0);
	                }
	                else {
	                    tmp1 = numChange(1, $num1, tmp1, sum1, (sum1-s1)/8, 0);
	                    tmp2 = numChange(1, $num2, tmp2, sum2, (sum2-s2)/8, 0);
	                    tmp3 = numChange(1, $num3, tmp3, sum3, (sum3-s3)/8, 1);    
	                    circle1.animate(1);
	                    circle2.animate(1);
	                    circle3.animate(1);
	                }
	                played = false;
	                $avatar.removeClass('switch');
	            }
	        }
	    });

	    if (document.body.scrollTop + screenHeight >= dountTop + dountHeight + threshold && document.body.scrollTop <= dountTop - threshold) {
	        dountAnimate();
	    }

	    // 点击触发动画
	    $avatar.on('tap', function() {
	        click++;
	        if (click >= 5) {
	            fn ? fn() : '';
	        }
	        else {
	            throttle(function() {
	                click = 0;
	            }, 1500);
	            if ($avatar.hasClass('switch')) {
	                dountAnimate('manual');
	                $avatar.addClass('active');
					setTimeout(function(){
					  	$avatar.removeClass('active');
					}, 100);
	            }
	        }
	    });


	    // 圆环动画
	    function dountAnimate(type) {
	        if (played === true) {
	            return;
	        }
	        played = true;

	        if (type === 'manual') {
	        	$back.removeClass('wave');

	        	if (isSvip8) {
	                tmp1 = 0;
	                tmp2 = 0;
	                tmp3 = 0;
	                circle1.set(0);
	                circle2.set(0);
	                circle3.set(0);
	            }
	            else {
	                tmp1 = numChange(1, $num1, tmp1, sum1, (sum1-s1)/8, 0);
	                tmp2 = numChange(1, $num2, tmp2, sum2, (sum2-s2)/8, 0);
	                tmp3 = numChange(1, $num3, tmp3, sum3, (sum3-s3)/8, 1);    
	                circle1.animate(1);
	                circle2.animate(1);
	                circle3.animate(1);
	            }
	            $avatar.removeClass('switch');
	        }

	        delay = type ? isSvip8 ? 0 : 1200 : 0;

	        setTimeout(function() {
	        	if (isSvip8) {
		            tmp1 = numChange(1, $num1, tmp1, sum1, sum1/(duration/100), 0);
		            tmp2 = numChange(1, $num2, tmp2, sum2, sum2/(duration/100), 0);
		            tmp3 = numChange(1, $num3, tmp3, sum3, sum3/(duration/100), 1);
		        }
		        else {
		            tmp1 = numChange(0, $num1, tmp1, s1, (sum1-s1)/8, 0);
		            tmp2 = numChange(0, $num2, tmp2, s2, (sum2-s2)/8, 0);
		            tmp3 = numChange(0, $num3, tmp3, s3, (sum3-s3)/8, 1);
		        }

		        if (isSvip8) {
					setTimeout(function() {
					 	$avatar.addClass('switch');
					  	played = false;
					}, 2000);
			    }
		        else {
					setTimeout(function() {
						$avatar.addClass('switch');
						played = false;
					}, 800);
		        }
		        if (isSvip8) {
		            circle1.animate(1, function() {
		                $desc.addClass('move');
		                setTimeout(function() {
		                	$back.addClass('wave');	
		                }, 1000);
		            });
		            circle2.animate(1);
		            circle3.animate(1);
		        }
		        else {
		            circle1.animate(s1/sum1, function() {
		                $desc.addClass('move');
		                setTimeout(function() {
		                	$back.addClass('wave');	
		                }, 1000);
		            });
		            circle2.animate(s2/sum2);
		            circle3.animate(s3/sum3);
		        }
	        }, delay);
	    }
	}





	/*
	 * 生成过期会员身份态环形图表
	 * 
	 * @param {string} wrapper - wrapper div
	 * @param {int} rank - 好友圈排名
	 * @param {int} s1 - 超会对应游戏加成值
	 * @param {int} s2 - 超会对应成长加速值
	 * @param {int} s3 - 超会对应等级加速值
	 * @param {int} sum1 - 游戏加成最大值
	 * @param {int} sum2 - 成长加速最大值
	 * @param {int} sum3 - 等级加速最大值
	 * @param {int} duration - 动画时长
	 * @param {function} fn  - 短时间内连续快速点击 5 次后调用的函数
	 *
	 */
	function drawOverdueDount(wrapper, rank, s1, s2, s3, sum1, sum2, sum3, duration, fn) {

	    var played = false,
	    	$svg = $(wrapper),
	        $avatar = $('.avatar'),
	        $front = $avatar.find('.front'),
	        $back = $avatar.find('.back'),
	        // $other = $avatar.find('.other'),
	        $desc = $('.desc'),
	        $num1 = $('.desc p:nth-child(3) em'),
	        $num2 = $('.desc p:nth-child(2) em'),
	        $num3 = $('.desc p:nth-child(1) em'),
	        $span1 = $('.desc p:nth-child(1) span'),

	        tmp1 = s1,
	        tmp2 = s2,
	        tmp3 = s3,

	        delay = 0,
	        click = 0, 
	        threshold = 3,
	        dountTop = $svg.offset().top,
	        dountHeight = $svg.height(),
	        screenHeight = document.documentElement.clientHeight;

	        $num1.text(s1);
	        $num2.text(s2);
	        $num3.text(s3);
	        $front.css({'-webkit-transition': 'all ease 1000ms'});
	        $back.css({'-webkit-transition': 'all ease 1000ms'});
	        $back.append('<span class="circle"></span>');	
	        // $other.css({'-webkit-transition': 'all ease 1000ms'});

	    var circle1 = new ProgressBar.Circle(wrapper, {
	        color: '#fee682',
	        strokeWidth: 6.4,
	        trailColor: '#f9f9f9',
	        easing: "easeOut",
	        duration: duration
	    });
	    circle1.set(s1/sum1);
	    circle1.svg.setAttribute('viewBox', '-30 -30 160 160');


	    var circle2 = new ProgressBar.Circle(wrapper, {
	        color: '#fddd59',
	        strokeWidth: 5,
	        trailColor: '#f9f9f9',
	        easing: "easeOut",
	        duration: duration
	    });
	    circle2.set(s2/sum2);
	    circle2.svg.setAttribute('viewBox', '-11 -11 122 122');


	    var circle3 = new ProgressBar.Circle(wrapper, {
	        color: '#fcd73e',
	        strokeWidth: 4,
	        trailColor: '#f9f9f9',
	        easing: "easeOut",
	        duration: duration
	    });
	    circle3.set(s3/sum3);


	    // 滚动触发动画
	    $(window).on('scroll', function() {
	        if (document.body.scrollTop + screenHeight >= dountTop + dountHeight + threshold && document.body.scrollTop <= dountTop - threshold) {
	            dountAnimate();
	        } else {
	            if (played === false && (document.body.scrollTop >= dountTop + dountHeight || document.body.scrollTop < dountTop - screenHeight)) {
	                tmp1 = numChange(1, $num1, tmp1, s1, s1/(duration/100), 0);
	                tmp2 = numChange(1, $num2, tmp2, s2, s2/(duration/100), 0);
	                tmp3 = numChange(1, $num3, tmp3, s3, s3/(duration/100), 1);
	                circle1.animate(s1/sum1);
	                circle2.animate(s2/sum2);
	                circle3.animate(s3/sum3);

	                played = false;
	                $span1.html('倍QQ等级加速');
	                $avatar.removeClass('switch');
	            }
	        }
	    });

	    // 点击触发动画
	    $avatar.on('tap', function() {
	        click++;
	        if (click >= 5) {
	            fn();
	        }
	        else {
	            throttle(function() {
	                click = 0;
	            }, 1500);
	            if ($avatar.hasClass('switch')) {
	                dountAnimate('manual');
	                $avatar.addClass('active');
					setTimeout(function(){
					  	$avatar.removeClass('active');
					}, 100);
	            }
	        }
	    });

	    if (document.body.scrollTop + screenHeight >= dountTop + dountHeight + threshold && document.body.scrollTop <= dountTop - threshold) {
	        dountAnimate();
	    }

	    // 圆环动画
	    function dountAnimate(type) {
	        if (played === true) {
	            return;
	        }
	        played = true;

	        if (type === 'manual') {
	        	$back.removeClass('wave');

	        	tmp1 = numChange(1, $num1, tmp1, s1, s1/(duration/100), 0);
	            tmp2 = numChange(1, $num2, tmp2, s2, s2/(duration/100), 0);
	            tmp3 = numChange(1, $num3, tmp3, s3, s3/(duration/100), 1);
	            circle1.animate(s1/sum1);
	            circle2.animate(s2/sum2);
	            circle3.animate(s3/sum3);

	            played = false;
	            $span1.html('倍QQ等级加速');
	            $avatar.removeClass('switch');
	        }

	        delay = type ? 2000 : 300;

	        setTimeout(function() {
	        	tmp1 = numChange(0, $num1, tmp1, 0, s1/(duration/100), 0);
		        tmp2 = numChange(0, $num2, tmp2, 0, s2/(duration/100), 0);
		        tmp3 = numChange(0, $num3, tmp3, 0, s3/(duration/100), 1, '', function() {
		        	$num3.text('无');
		        	$span1.html('QQ等级加速');
		        });

		        setTimeout(function() {
		            $avatar.addClass('switch');
		            $desc.addClass('move');
		            $back.addClass('wave');
		            played = false;
		        }, duration-1000);

		        circle1.animate(0);
		        circle2.animate(0);
		        circle3.animate(0);
	        }, delay);
	    	
	    }
	}







	/*
	 * 数字垂直跑马灯滚动（宽度自适应）
	 * 
	 * @param {string} wrapper  - 传入类名
	 * @param {int} change     - 变动值
	 *
	 */
	function numMarquee(wrapper, change) {
		if (typeof change !== 'number') {
			return;
		}
		this.wrapper = $(wrapper);
		this.wrapper.find('.rank .change').text(change);

		if (this.wrapper.offset().left < 1) {
			this.wrapper.css({
				'margin-left': Math.ceil(Math.abs(this.wrapper.offset().left))+2
			})	
		}
	}

	numMarquee.prototype = {
		show: function() {
			this.wrapper.css({
				'opacity': 1,
				'top': -10
			});
			return this;
		},
		hide: function() {
			this.wrapper.css({
				'opacity': 0,
				'top': 0
			});
			return this;
		}
	}







	/*
	 * 数字递增递减函数
	 * 
	 * @param {string} flag - 增减还是递减 (1:递增, else: 递减)
	 * @param {object} obj  - 传入 jQuery 对象
	 * @param {int} tmp     - 呈现于页面中的数字，也是递增递减的基数
	 * @param {int} last    - 最终的数值
	 * @param {int} step    - 递增递减的幅度
	 * @param {int} point   - 保留小数点后几位
	 * @param {int} suffix  - 数字的后缀（单位）
	 *
	 */
	function numChange(flag, obj, tmp, last, step, point, suffix, callback) {
	    suffix = suffix ? suffix : '';
	    var timer = function() {
	        setTimeout(function() {
	            flag === 1 ? tmp+=step:tmp-=step;
	            obj.text(tmp.toFixed(point)+suffix);

	            if(flag === 1 ? tmp<=last:tmp>=last){
	                timer();
	            }
	            else {
	                obj.text(last+suffix);
	                callback ? callback() : '';
	            }
	        }, 60);
	    }
	    if (step != 0) {
	        timer();
	        return last;
	    }
	}







	/*
	 * 函数节流（计算短时间内点击数）
	 * @param {function} fu - 要执行的函数 
	 * @param {int} delay   - 时间阈值
	 *
	 */
	function throttle(method, delay, context) {
	    clearTimeout(method.tId);
	    method.tId = setTimeout(function(){
	        method.call(context);
	    }, delay);
	}





	
	module.exports = {
		'drawVipDount': drawVipDount,
		'drawSvipDount': drawSvipDount,
		'drawOverdueDount': drawOverdueDount,
		'numMarquee': numMarquee
	};





});