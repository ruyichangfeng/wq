$(function () {
	var app = new Vue({
		el:'#app',
		mounted: function () {
			var that = this;
			
			//欢迎页面倒计时
			$('body').css({'position': 'fixed', 'top': -this.scroll_top + 'px' });
			function welcomeTimer() {
				var timer = setTimeout(function () {
					that.welcomeTime--;
					if (that.welcomeTime === 0) {
						that.showWelcome = false;
						$('body').css({'position': 'static'});
						$(window).scrollTop(this.scroll_top);
						clearTimeout(timer);
					} else {
						welcomeTimer();
					}
				},1000);
			}
			welcomeTimer();
			
			// 开始请求数据，成功返回data后赋值
			$.ajax({
				url: './index.php?i='+ uniacid +'&c=entry&do=index&act=imglist&m=wxz_piclive',
				type: 'POST',
				async: false,
				//cache: false, 
				//timeout : 50000, //超时时间：50秒
				dataType:'json', 
				data:{sort:false,lid:lid},
				success: function (data) {
					that.imageList = data.imageList;
					that.imageTotal = data.imageTotal;
                                        that.live_img = data.live_img;
                                        that.live_info = data.live_info;
					that.carryTotal = data.carryTotal;
					that.user_info = data.user_info;
                                        that.page = data.page;
                                        that.pageTotal = data.pageTotal;
                                        that.sortdesc = data.sortdesc;
                                        that.category = data.category;
                                        that.commentDataCount = data.commentDataCount;
					that.is_invite = data.is_invite;
                                        that.is_video = data.is_video;
                                        that.typeid = data.typeid;
                                        document.getElementById("typeid").value = data.typeid;
				},
				error:function(XMLHttpRequest, textStatus, errorThrown){ 
					//alert(XMLHttpRequest.status);
					//alert(XMLHttpRequest.readyState);
					//alert(textStatus);
				  }
			});

			// 评论数据
			$.ajax({
				url: './index.php?i='+ uniacid +'&lid='+ lid +'&c=entry&do=commentList&m=wxz_piclive',
				type: 'POST',
				async: false,
				dataType:'json',
				success: function (res) {
					that.commentData = res
				}
			});

			// 滚动条滚动到底部
			var albumBar = document.getElementById('albumBar');
			var albumBarTop = $(albumBar).offset().top;
		  	$(window).scroll(function () {
				var scroll_top = that.scroll_top = document.body.scrollTop || document.documentElement.scrollTop;
				var scroll_height = document.body.scrollHeight || document.documentElement.scrollHeight;
				var client_height = document.documentElement.clientHeight;

		  		if (albumBarTop <= scroll_top) {
		  			$(albumBar).css({'position':'fixed', 'top':'0px'});
		  		} else {
		  			$(albumBar).css({'position':'absolute', 'top':'1.8rem'});
		  		}
                                
				if ((scroll_top + client_height) > (scroll_height - 30)) {
                                    var page = that.page+1;
                                    that.page = page;
                                        //var str = JSON.stringify(that.live_info[0]['id']);
                                    if(page <= that.pageTotal){
					// 发请求，得到数据【data.imageList】，追加数据
					$.ajax({
						url: './index.php?i='+ uniacid +'&c=entry&do=index&act=imglist&m=wxz_piclive',
						type: 'POST',
						async: false,
                                                dataType:'json',
                                                data:{page:page,sort:that.sortdesc,lid:that.live_info[0]['id'],typeid:that.typeid},
						success: function (data) {
                                                    data.imageList.forEach(function (item) {
                                                            that.imageList.push(item);
                                                    });
						}
					});
                                    }
				}
			});
		},
		data: {
			imageList: [],
			category: [],
                        imageListCom:[],
                        live_img:'',
                        live_info:[],
			imageTotal: 0,
			carryTotal: 0,
                        pageTotal:0,
			is_invite : 0,
                        is_video : 0,
                        lid:0,
                        typeid:0,
			showBigPic: false,
                        showCommentBigPic:false,
			showBigPicInfo: false,
			currentBigPicIndex: 0,
			isLoadBigPic: false,
			welcomeTime: 10,
			showWelcome: true,
			scroll_top: 0,
			fixed_top: 0,
			isShowComment: false,
			componetVal: '',
			showSubNav:false,
			sort: false,
			// 当前大图片信息
			activeBigPic: {},
			// 评论数据
			commentData: [],
                        commentDataCount:0,
			showCommnetList: false,
                        showInviteList: false,
		},
		methods: {
			// 直接进入
			leaveWelcome: function () {
				this.showWelcome = false;
				$('body').css({'position': 'static'});
				$(window).scrollTop(this.scroll_top);
			},
			// 弹出更多菜单
			showMoreMenu: function (item, index) {
				var that = this;
				this.fixed_top = document.body.scrollTop || document.documentElement.scrollTop;
				//$('body').css({'position': 'fixed', 'top': -this.fixed_top + 'px' });
				this.showBigPic=true;
				that.currentBigPicIndex = index;
				this.activeBigPic = $.extend(true, {} , this.activeBigPic, item);
				that.activeBigPic.commentList = item.commentList;
				//关闭评论列表弹框
				$('body').css({'position': 'static'});
				$(window).scrollTop(this.fixed_top);
				this.showCommnetList = false;
                                this.showInviteList = false;
				//轮播器初始化
				setTimeout(function () {
					var mySwiper = new Swiper ('#swiper', {
					    loop: false,
					    initialSlide: index,
					    onSlideChangeEnd: function(swiper){
					    	var activeItem = that.imageList[swiper.activeIndex];
					    	that.currentBigPicIndex = swiper.activeIndex;
					    	that.activeBigPic = $.extend(true, {} , that.activeBigPic, activeItem);
					    	that.activeBigPic.commentList = activeItem.commentList;
					    }
				  	});  
			  	},10);
			},
                        // 弹出更多菜单
			showMoreMenuTwo: function (item, index) {
                            var that = this;
                            this.imageListCom.unshift(item);
				
				this.fixed_top = document.body.scrollTop || document.documentElement.scrollTop;
				//$('body').css({'position': 'fixed', 'top': -this.fixed_top + 'px' });
				this.showBigPic=false;
                                this.showCommentBigPic = true;
				that.currentBigPicIndex = index;
				this.activeBigPic = $.extend(true, {} , this.activeBigPic, item);
				that.activeBigPic.commentList = item.commentList;
				//关闭评论列表弹框
				$('body').css({'position': 'static'});
				$(window).scrollTop(this.fixed_top);
				this.showCommnetList = false;
                                this.showInviteList = false;
				//轮播器初始化
//				setTimeout(function () {
//					var mySwiper = new Swiper ('#swiper', {
//					    loop: false,
//					    initialSlide: 8,//index
//					    onSlideChangeEnd: function(swiper){
//					    	var activeItem = fff;//that.imageList[swiper.activeIndex];
//					    	that.currentBigPicIndex = 8;//swiper.activeIndex;
//					    	that.activeBigPic = $.extend(true, {} , that.activeBigPic, activeItem);
//					    	//that.activeBigPic.commentList = activeItem.commentList;
//					    }
//				  	});  
//			  	},10);
			},
			// 关闭更多菜单
			closeMoreMenu: function () {
				$('body').css({'position': 'static'});
				$(window).scrollTop(this.fixed_top);
				this.showBigPic=false;
                                this.showCommentBigPic=false;
			},
			// 加载大图
			uploadBigPic: function () {	
				this.isLoadBigPic = true;			
				var image = new Image();
				
				image.src = this.imageList[this.currentBigPicIndex].bigUrl;
				image.onload = function () {
					app.imageList[app.currentBigPicIndex].isLoadBigPiced = true;
					app.activeBigPic.isLoadBigPiced = true;
					app.isLoadBigPic = false;
					alert(image.width);
				};
			},
			// 点赞
			praiseFn: function () {
                            var aid = this.activeBigPic.aid;//附件图片id
				if (this.activeBigPic.isPraise) {
                                    $.ajax({
                                            url: './index.php?i='+ uniacid +'&c=entry&do=goodClick&m=wxz_piclive',
                                            type: 'POST',
                                            data:{aid:this.activeBigPic.aid,type:0},
                                            dataType:'json',
                                            success: function (res) {
                                                if(res.err == 1){
                                                    alert(res.msg);
                                                }
                                            }
                                    });
                                    //发请求，回调成功，运行下面代码
                                    this.activeBigPic.isPraise = false;
                                    this.activeBigPic.praise--;
				} else {
                                    $.ajax({
                                            url: './index.php?i='+ uniacid +'&c=entry&do=goodClick&m=wxz_piclive',
                                            type: 'POST',
                                            data:{aid:this.activeBigPic.aid,type:1},
                                            dataType:'json',
                                            success: function (res) {
                                                if(res.err == 1){
                                                    alert(res.msg);
                                                }
                                            }
                                    });
                                    //发请求，回调成功，运行下面代码
                                    this.activeBigPic.isPraise = true;
                                    this.activeBigPic.praise++;
				}

			},
			// 删除评论；@index 评论的序号，@item 评论的那条数据
			removeComponent: function (index, item) {
                            $.ajax({
                                    url: './index.php?i='+ uniacid +'&c=entry&do=delcomment&m=wxz_piclive',
                                    type: 'POST',
                                    data:{cid:item.cid},
                                    dataType:'json', 
                                    success: function (res) {
                                       if(res.err > 0){
                                           alert(res.msg);
                                       }     
                                    }
                            });
                            //删除页面展示数据
                            this.activeBigPic.commentList.splice(index, 1);
			},
			// 发布评论；@index 评论的序号，@item 评论的那条数据
			addComponet: function (index, item) {
                            var that = this;
				// 发送请求回调成功，走下面的代码
				//评论数据
				$.ajax({
					url: './index.php?i='+ uniacid +'&c=entry&do=addComment&m=wxz_piclive',
					type: 'POST',
                                        data:{commentText: this.componetVal,aid:this.activeBigPic.aid},
                                        dataType:'json', 
					async: false,
					success: function (res) {
                                            if(res.err == 1){
                                                alert(res.msg);
                                            }else{
												//this.activeBigPic.commentList = res.commentList;
												that.activeBigPic.commentList.unshift({
														cid: res.cid,
														myself:1,
														username: res.username,
														userPic: res.userPic,
														commentText: res.commentText,
														dateTime: res.dateTime
												});
												that.commentData.unshift({
													cid: res.cid,
													myself:1,
													username: res.username,
													userPic: res.userPic,
													commentText: res.commentText,
													dateTime: res.dateTime
												});
												that.componetVal = '';
											}
					}
				});
			},
			
			//下载提醒
			download: function(aid) {
                            location.href = './index.php?i='+ uniacid +'&aid='+aid+'&c=entry&do=getSourceImg&m=wxz_piclive';
				//$("#download").fadeIn(1000);
				//$("#download").fadeOut(5000);
			},
			
			//分类切换activeBigPic
			changecate: function (typeid) {
				var that = this;
				$.ajax({
					url: './index.php?i='+ uniacid +'&c=entry&do=index&act=imglist&m=wxz_piclive',
					type: 'POST',
					data:{lid: lid,typeid: typeid,sort:false},
					async: false,
					dataType:'json', 
					success: function (data) {
						that.imageList = data.imageList;
						that.imageTotal = data.imageTotal;
						that.carryTotal = data.carryTotal;
						that.user_info = data.user_info;
                                                that.page = data.page;
                                                that.sortdesc = data.sortdesc;
                                                that.category = data.category;
                                                that.typeid = data.typeid;
                                                that.lid = data.lid;
                                                that.pageTotal = data.pageTotal;
                                                document.getElementById("typeid").value = typeid;
					},
					error:function(){ 
						alert('no');
					  }
				});
			},
			
			// 显示评论弹窗
			showCommnetFn: function () {
				this.showCommnetList = true;
				this.fixed_top = document.body.scrollTop || document.documentElement.scrollTop;
				$('body').css({'position': 'fixed', 'top': -this.fixed_top + 'px' });
			},
			// 关闭评论弹窗
			hideCommentFn: function () {
				$('body').css({'position': 'static'});
				$(window).scrollTop(this.fixed_top);
				this.showCommnetList = false;
			},
                        // 显示邀请榜弹窗
			showInviteFn: function () {
				location.href = './index.php?i='+ uniacid +'&lid='+lid+'&c=entry&do=invite&m=wxz_piclive';
			},
                        // 关闭邀请榜弹窗
			hideInviteFn: function () {
				$('body').css({'position': 'static'});
				$(window).scrollTop(this.fixed_top);
				this.showInviteList = false;
			},
                        // 短视频页
			showMediaFn: function () {
				location.href = './index.php?i='+ uniacid +'&lid='+lid+'&c=entry&do=media&m=wxz_piclive';
			},
			// 排序
			pictureSort: function (e) {
				var typeid = document.getElementById("typeid").value;
				//console.log(typeid);
				// sort表示正序和倒序
				this.sort = !this.sort;
				var that = this;
				$.ajax({
					url: './index.php?i='+ uniacid +'&c=entry&do=index&act=imglist&m=wxz_piclive',
					type: 'POST',
					data:{sort:this.sort,lid:lid,typeid:typeid},
					dataType:'json', 
					success: function (res) {
						that.imageList = res.imageList;
						that.page = res.page;
                        that.sortdesc = res.sortdesc;
					}
				});
				var _top = $(window).width() / 7.5 * 1.8 * 2;
				console.log(_top)
				$('html,body').animate({scrollTop: _top + 'px'},0)
			},
			// 返回顶部
			toScrollTop: function () {
				this.scroll_top = 0;
				$('html,body').animate({scrollTop:0}, 1000);
			}
		}
	});
});