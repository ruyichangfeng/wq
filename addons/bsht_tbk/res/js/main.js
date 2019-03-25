// 图片延迟替换函数
	function lazy_img(){			
			var lazy = $('.lazy-bk');
			lazy.each(function(){
				var self = $(this),
					srcImg = self.attr('data-bk');

				$('<img />')
					.on('load',function(){
						if(self.is('img')){
							self.attr('src',srcImg)
						}else{
							self.css({
								'background-image'	: 'url('+srcImg+')',
								'background-size'	: 'cover'
							})
						}
					})
					.attr("src",srcImg);

				self.removeClass('lazy-bk');
			})	
	}
// 图片延迟替换函数