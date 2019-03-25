define(function(require, exports, module) {

	/*
	 * 生成成长值半圆环图表
	 * 
	 * @param {string} wrapper - wrapper div
	 * @param {int} value - 当前成长值
	 * @param {int} sum - 总成长值
	 * @param {int} duration - 动画时长
	 * @param {boolean} isSvip - 是否超级会员
	 * @param {boolean} isAndroid - 是否安卓手机
	 *
	 */
	function drawGrowth(wrapper, value, sum, duration, isSvip, isAndroid) {

		var $num = $('.circle-mask span'),
			$left = $('.circle-left .left'),
			$right = $('.circle-right .right'),
			$unit = $('.my-growth > span'),
			$circle = $('.circle'),
			leftDegree = 122,		// 左边圆环占据的角度
			leftStartDegree = 58,	// 左边圆环开始的角度
			rightDegree = 104,		// 右边圆环占据角度
			duration = 700;


		// 初始化
		$unit.text(sum+'/天');
		if (isSvip) {
			$circle.addClass('svip');
		} else {
			$circle.addClass('vip');
		}

		if (isAndroid) {
			$num.text(value);
		} else {
			numChange(1, $num, 0, value, value/10, 0);
		}

		if (value <= sum/2) {
			if (isAndroid) {
				$left.css({'-webkit-transition-duration': 0});
			} else {
				$left.css({'-webkit-transition-duration': duration +'ms'});	
			}
			
			if (value < 0) {
				$left.css({'-webkit-transform': 'rotate(0deg)'})
			} else {
				$left.css({
					'-webkit-transform': 'rotate('+((value/sum)*2*leftDegree+leftStartDegree)+'deg)'
				})
			}
		}
		else {
			if (isAndroid) {
				$left.css({
					'-webkit-transition-duration': 0,
					'-webkit-transform': 'rotate(180deg)'
				});
				$right.css({
					'-webkit-transition-duration': 0,
					'-webkit-transform': 'rotate('+((value-sum/2)/(sum/2))*rightDegree+'deg)'
				});
				if (value === sum) {
					$unit.addClass('full');
				}
			} else {
				$left.css({
					'-webkit-transition-timing-function': 'linear',
					'-webkit-transition-duration': (duration/(180+rightDegree))*180 +'ms',
					'-webkit-transform': 'rotate(180deg)'
				});
				$left.on('webkitTransitionEnd', function() {
					$right.css({
						'-webkit-transition-timing-function': 'linear',
						'-webkit-transition-duration': (duration/(180+rightDegree))*rightDegree +'ms',
						'-webkit-transform': 'rotate('+((value-sum/2)/(sum/2))*rightDegree+'deg)'
					});
				});
				if (value === sum) {
					$right.on('webkitTransitionEnd', function() {
						$unit.addClass('full');
					});
				}
			}
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



	module.exports = {
		'drawGrowth': drawGrowth
	};

});