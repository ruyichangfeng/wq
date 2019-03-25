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
						that.showContentList = true;
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
			//var app = document.getElementById('app');
			//var appScrollHeight = $(app).scrollHeight();
		  	$(window).scroll(function () {
				var scroll_top = that.scroll_top = document.body.scrollTop || document.documentElement.scrollTop;
				var scroll_height = document.documentElement.scrollHeight;
				var client_height = document.documentElement.clientHeight;
				var bottom = scroll_top/client_height;
				//console.log(scroll_top+'--'+scroll_height+'---'+client_height+'---'+bottom);
		  		if (albumBarTop <= scroll_top) {
		  			$(albumBar).css({'position':'fixed', 'top':'0px'});
		  		} else {
		  			$(albumBar).css({'position':'absolute', 'top':'1.8rem'});
		  		}
                                
				if ((scroll_top + client_height) >= (scroll_height - 30)) {	
	                var page = that.page+1;
	                if(page <= that.pageTotal){
	                	console.log(page);
						// 发请求，得到数据【data.imageList】，追加数据
						$.ajax({
							url: './index.php?i='+ uniacid +'&c=entry&do=index&act=imglist&m=wxz_piclive',
							type: 'POST',
							async: false,
                            dataType:'json',
                            data:{page:page,sort:that.sortdesc,lid:that.live_info[0]['id'],typeid:that.typeid},
                            timeout: 30000, //超时时间：50秒
					        beforeSend:function(XMLHttpRequest){
					            console.log("正在处理，请稍后···"); 
					        }, 
							success: function (data) {
								that.page = page;
                                data.imageList.forEach(function (item) {
                                        that.imageList.push(item);
                                });
							},
							// 请求完成后的回调函数 (请求成功或失败之后均调用)
					        complete:function(XMLHttpRequest,textStatus){
					            console.log('加载完成'+textStatus);
					        }, 
					        // 请求失败时调用此函数。
					        error:function(XMLHttpRequest,textStatus,errorThrown){
					            console.log("请求对象XMLHttpRequest: "+XMLHttpRequest.readyState);
								console.log("错误类型textStatus: "+textStatus);
								console.log("异常对象errorThrown: "+errorThrown);

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
			showContentList: false,
			// 当前大图片信息
			activeBigPic: {},
			// 评论数据
			commentData: [],
            commentDataCount:0,
			showCommnetList: false,
            showInviteList: false,
            showMe: false,
            imgMeList: [],
		},
		methods: {
			// 直接进入
			leaveWelcome: function () {
				this.showWelcome = false;
				this.showContentList = true;
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
					    	//获取当前图片信息
					    	app.getImageInfo(swiper.activeIndex);
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
				//获取当前图片信息
				app.getImageInfo(index);
			},
			// 关闭更多菜单
			closeMoreMenu: function () {
				$('body').css({'position': 'static'});
				$(window).scrollTop(this.fixed_top);
				this.showBigPic=false;
                this.showCommentBigPic=false;
			},
			//获取图片信息
			getImageInfo: function (currentIndex) {
				$.ajax({
                        url: './index.php?i='+ uniacid +'&c=entry&do=image&op=info&m=wxz_piclive',
                        type: 'POST',
                        data:{aid:app.imageList[currentIndex].aid},
                        dataType:'json',
                        success: function (res) {
                            if(res.err == 0){
                            	app.imageList[currentIndex].currentSize = res.data.size;
                                console.log(res.data.size);
                            }
                        }
                });
			},
			// 加载大图
			// uploadBigPic: function () {	
			// 	this.isLoadBigPic = true;			
			// 	var image = new Image();
				
			// 	image.src = this.imageList[this.currentBigPicIndex].bigUrl;
			// 	image.onload = function () {
			// 		app.imageList[app.currentBigPicIndex].isLoadBigPiced = true;
			// 		app.activeBigPic.isLoadBigPiced = true;
			// 		app.isLoadBigPic = false;
			// 		//alert(image.width);
			// 	};
			// },
			//加载大图
			showBigImageLayer: function (item,index,event) {
				this.isLoadBigPic = true;
				
				
				var image = new Image();
				//image.src = app.imageList[this.currentBigPicIndex].bigUrl;
				//获取当前图片信息
            	$.ajax({
                        url: './index.php?i='+ uniacid +'&c=entry&do=image&op=info&m=wxz_piclive',
                        type: 'POST',
                        data:{aid:app.imageList[this.currentBigPicIndex].aid,flag:1},
                        dataType:'json',
                        beforeSend: function () {
					        event.target.innerText = '加载中...';
					    },
                        success: function (res) {
                            if(res.err == 0){
                                event.target.innerText = '已完成';
                                app.imageList[index].midUrl = app.imageList[index].bigUrl;
                                app.imageList[index].isLoadBigPiced = false;
                            }
                        }
                })
				
				image.onload = function () {
					//app.activeBigPic.isLoadBigPiced = true;
					//app.isLoadBigPic = false;
					//alert(image.width);
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
						console.log('加载分类错误');
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
				console.log('pictureSort:'+typeid);
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
			},
			//找我 findme
			toFindMe: function() {
				this.showMe = true;
			},
			//findme 上传图片
			fileMeClick(){
		        document.getElementById('upload_file').click()
		    },
		    fileMeChange(el){
		        if (!el.target.files[0].size) return;
		        this.fileMeList(el.target.files);
		        el.target.value = ''
		    },
		    fileMeList(files){
		        for (let i = 0; i < files.length; i++) {
				  this.fileAdd(files[i]);
				}
		    },
		    fileMeAdd(file){
		        this.size = this.size + file.size;//总大小
		        let reader = new FileReader();
		        reader.vue = this;
		        reader.readAsDataURL(file);
		        reader.onload = function () {
		          file.src = this.result;
		          this.vue.imgMeList = [];
		          this.vue.imgMeList.push({
		            file
		          });
		        }
		    },
		}
	});
});