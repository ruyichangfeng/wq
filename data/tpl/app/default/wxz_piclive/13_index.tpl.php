<?php defined('IN_IA') or exit('Access Denied');?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0"/>
<title><?php  if($live['live_name']) { ?><?php  echo $live['live_name'];?><?php  } else { ?><?php  echo $_W['page']['title'];?><?php  } ?></title>
<link rel="stylesheet" type="text/css" href="../addons/wxz_piclive/template/mobile/css/swiper.css" />
<link rel="stylesheet" type="text/css" href="../addons/wxz_piclive/template/mobile/css/style.css?v3" />
<link rel="stylesheet" type="text/css" href="../addons/wxz_piclive/css/font-awesome.min.css" />
<script type="text/javascript" src="../addons/wxz_piclive/template/mobile/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="../addons/wxz_piclive/template/mobile/js/common.js"></script>
<script type="text/javascript" src="../addons/wxz_piclive/template/mobile/js/swiper.js"></script>
<script type="text/javascript" src="../addons/wxz_piclive/template/mobile/js/vue.js"></script>
<script type="text/javascript" src="../addons/wxz_piclive/template/mobile/js/index.js?v283"></script>
<script src="//res.wx.qq.com/open/js/jweixin-1.1.0.js"></script>
<script type="text/javascript">
 //yyyy-MM-dd
function codefans(){
var box=document.getElementById("zhezhao");
box.style.display="none"; 
}
setTimeout("codefans()",2000);
 var getDateFormat = function(options){
  options = options || {};
  options.sign = options.sign || 'yyyy-MM-dd HH:mm:ss';
  var _complete = function(n){
   return (n>9) ? n : '0' + n;
  }
  var d = new Date();
  var year = d.getFullYear();
  var month = _complete(d.getMonth()+1);
  var day = _complete(d.getDate());
  var hours = _complete(d.getHours());
  var minutes = _complete(d.getMinutes());
  var second = _complete(d.getSeconds());
  var result = options.sign;
  result = result.replace('yyyy', year);
  result = result.replace('MM', month);
  result = result.replace('dd', day);
  result = result.replace('HH', hours);
  result = result.replace('mm', minutes);
  result = result.replace('ss', second);
  return result;
 }

</script>
<script>
    wx.config({
        debug: false,
        appId: "<?php  echo $_W['account']['jssdkconfig']['appId'];?>",
        timestamp: "<?php  echo $_W['account']['jssdkconfig']['timestamp'];?>",
        nonceStr: "<?php  echo $_W['account']['jssdkconfig']['nonceStr'];?>",
        signature: "<?php  echo $_W['account']['jssdkconfig']['signature'];?>",
        jsApiList: ["onMenuShareAppMessage", "onMenuShareTimeline", "onMenuShareQQ"]
    });
    wx.ready(function () {
        sharedata = {
            title: "<?php  echo htmlspecialchars_decode($live['live_name'])?>",
            desc: "<?php  echo htmlspecialchars_decode($live['live_brief'])?>",
            link:"<?php  echo $_W['siteroot'].str_replace('./','app/',$this->createMobileurl('index',array('i' => $_W['weid'],'lid'=>$live['id'],'share_uid'=>$_W['fans']['uid'])))?>",
            imgUrl: "<?php  echo tomedia($live['original_img'])?>",
            success: function () {
                //alert(111);
            },
            cancel: function () {
                //alert('分享取消');
            }
        };
        wx.onMenuShareTimeline(sharedata);
        wx.onMenuShareAppMessage(sharedata);
	wx.onMenuShareQQ(sharedata);
    });
</script>
</head>
<body>
	<div id="zhezhao" style="background-color: #000; position: absolute; left: 0; top: 0; width: 100%; height: 100%; z-index: 10001; color: #fff; text-align: center;">
		<div style="padding-top: 45%;">加载中</div>
	</div>
<style>
.component-classifyBar{position: absolute;bottom: -36px;left: -10px;}
.default-image{background:#fff url("../addons/wxz_piclive/preview.gif") no-repeat center center;}
</style>
<script>
var uniacid = "<?php  echo $_W['uniacid']?>";
var lid = "<?php  echo $lid?>";
var typeid = "<?php  echo $typeid?>";
var navimg = "<?php  echo tomedia($live['original_img'])?>";
</script>


<div id="app" style="background:#000;width:100%;min-height:100%;">
    <div class="welcome" v-show="showWelcome" :style="{backgroundImage: 'url('+ navimg +')'}">
        <span class="welcome-time">{{welcomeTime}}s</span>
        <a href="javascript:;" class="leaveWelcome" @click="leaveWelcome">进入直播相册</a>
    </div>
    <div style="width: 3.75rem; height: 1.8rem;">
    	<a href="javascript:;" class="album-banner" v-if="live_img && live_info[0].video_code == ''" >
       		<!--<img class="component-image album-banner-image" :src=""/> -->
                    <img class="component-image album-banner-image default-image" :src="live_img"/>
       		<div href="javascript:;" class="album-count" style="top: 1.5rem;">
       			<i class="fa fa-star fa-fw"></i> {{carryTotal}} | <i class="fa fa-photo fa-fw"></i> {{imageTotal}}
       		</div>
        </a>
        <div style="width:100%; height: 100%;" v-else><?php  echo $live['video_code'];?></div>
    </div>    
    <!-- 导航 -->
    <div class="album-functionBar" id="albumBar" style="color: rgb(255, 255, 255); top: 1.8rem; position: absolute;">
    	<div class="album-functionBar-bg" style="background: rgba(38, 38, 43, 0.8);"></div> 
        <div>
            <div class="album-classify album-functionBar-item">
                <button class="album-functionBar-button" @click="showSubNav = !showSubNav;">
                        <i class="fa fa-reorder fa-fw"></i> <span>分类</span>
                </button> 
                <ul v-show="showSubNav" class="component-classifyBar album-classify-sortBar" style="color: rgb(255, 255, 255); background: rgba(38, 38, 43, 0.8);">
                                <!--<li active="false" @click="changecate(1)">主题演讲</li>-->
                                <li v-for="(item,index) in category" active="false" @click="changecate(index)">{{item}}</li>
                </ul>
            </div> 
            <!-- <button class="album-functionBar-button album-functionBar-puzzle"><i class="iconfont icon-puzzle"></i> <span>拼图</span></button>  -->
            <div class="album-sort album-functionBar-item">
                <button class="album-functionBar-button" @click.stop.prevent="pictureSort">
                    <i class="fa fa-sort fa-fw"></i>
                    <span v-if="sort">逆序</span>
                    <span v-else>正序</span>
                </button>
                    <input type="hidden" id="typeid" value="">
            </div> 
            <button class="album-functionBar-button album-functionBar-comment" @click="showCommnetFn">
                        <i class="fa fa-commenting fa-fw"></i> <span>评论</span> 
                        <div class="album-functionBar-commonCount" v-if="commentDataCount > 0">{{commentDataCount}}</div>
            </button>
            <button class="album-functionBar-button album-functionBar-comment" @click="showInviteFn" v-if="is_invite">
                        <i class="fa fa-user-circle-o"></i> <span>人气榜</span> 
            </button>
            <button class="album-functionBar-button album-functionBar-comment" @click="showMediaFn" v-if="is_video">
                        <i class="fa fa-youtube-play"></i> <span>短视频</span> 
            </button>
        </div>
    </div>
    <!-- 内容区域 -->
    <ul class="image-content" v-show="showContentList">
    	<li v-for="(item,index) in imageList" @click="showMoreMenu(item, index)"><img class='default-image' :src="item.smallUrl" @load="successLoadImg" @error="errorLoadImg"/></li>
    </ul>
    <!-- 大图弹窗 -->
    <div id="bigpic-pop" class="bigpic-pop" v-if="showBigPic" style="z-index:1001">
    	<button class="tool-close" @click="closeMoreMenu"><i class="">×</i></button>
    	<div class="swiper-container swiper1" id="swiper">
		    <div class="swiper-wrapper">
                <div class="swiper-slide position_new" v-if="item.show_type==0" v-for="(item,index) in imageList">
                    <div>
                        <img :src="item.midUrl" v-if="!activeBigPic.isLoadBigPiced" />
                        <img :src="item.midUrl" :data-bigurl="item.bigUrl" v-else />
                    </div>
                    <button class="album-bigImageLayer-loadImage"   v-if="item.isLoadBigPiced" @click="showBigImageLayer(item,index,$event)">加载大图({{item.bigImgSize}}MB)</button>
                    <div class="album-bigImageLayer-size" v-show="item.currentSize">当前图片{{item.currentSize}}KB，可长按保存</div>
                    <div class="album-bigImageLayer-loadgif"></div>
                </div>
                <div class="swiper-slide swiper-slide2" v-else>
                    <div>
                        <img :src="item.midUrl" v-if="!activeBigPic.isLoadBigPiced" />
                        <img :src="item.midUrl" :data-bigurl="item.bigUrl" v-else />
                    </div>
                    <button class="album-bigImageLayer-loadImage"  v-if="item.isLoadBigPiced" @click="showBigImageLayer(item,index,$event)">加载大图({{item.bigImgSize}}MB)</button>
                    <div class="album-bigImageLayer-size" v-show="item.currentSize">当前图片{{item.currentSize}}KB，可长按保存</div>
                    <div class="album-bigImageLayer-loadgif"></div>
                </div>
		    </div>
		</div>

    	<div class="album-bigImageLayer-bottom">
    		<div class="component-comment" @click.stop="showBigPicInfo=true;">
    			<i class="album-imageInfo-icon fa fa-photo fa-fw fa-lg"></i>
    			<div class="tool-layout" @click.stop="showBigPicInfo=false;" v-if="showBigPicInfo">
    				<ul class="album-imageInfo-info">
    					<li class="clearfix">
    						<label class="pull-left">文件大小</label> 
    						<div class="pull-right text-overflow">{{activeBigPic.bigImgSize}}MB</div>
    					</li> 
    					<li class="clearfix">
    						<label class="pull-left">拍摄时间</label> 
    						<div class="pull-right text-overflow">{{activeBigPic.dateTime}}</div>
    					</li> 
    					<li class="clearfix">
    						<label class="pull-left">文件编号</label> 
    						<div class="pull-right text-overflow">{{activeBigPic.picId}}</div>
    					</li>
    				</ul>
    			</div>
    		</div> 
    		<div class="component-comment" @click="praiseFn">
                <i class="component-praise-icon fa fa-star fa-fw fa-lg" v-if="activeBigPic.isPraise==true"></i>
                <i class="component-praise-icon fa fa-star-o fa-fw fa-lg" v-else></i>
                <span class="component-praise-num" v-if="activeBigPic.praise != 0">{{activeBigPic.praise}}</span>
            </div> 
    		<div class="component-comment">
                <i class="component-comment-icon fa fa-commenting fa-fw fa-lg" @click="isShowComment=true;componetVal='';"></i> 
                <span class="component-comment-num" v-if="activeBigPic.commentList.length != 0">{{activeBigPic.commentList.length}}</span>
                <div class="component-commentBox" v-if="isShowComment">
                    <button class="tool-close" @click="isShowComment=false;"><i>×</i></button> 
                    <div class="component-commentBox-top clearfix">
                        <div class="component-commentBox-input">
                            <textarea id="component-commentBox-input" v-model="componetVal" placeholder="我也来说点什么吧..." maxlength="100"></textarea>
                        </div> 
                        <div class="component-commentBox-submit fr">
                            <button v-for="(item,index) in user_info" @click="addComponet(index, item)">发布</button>
                        </div> 
                        <span class="component-commentBox-count">{{componetVal.length}} / 100</span>
                    </div> 
                    <!-- 评论主题内容 -->
                    <div class="component-commentBox-main">
                        <div class="component-commentBox-main-top"><span>{{activeBigPic.commentList.length}}</span>条评论(点击评论可回复)</div> 
                        <div class="component-scroll component-commentBox-main-msg">
                            <section class="component-scroll-list"> <!----> 
                                <div class="component-item" v-for="(item,index) in activeBigPic.commentList">
                                    <div class="component-item-top">
                                        <div class="image"><img :src="item.userPic"/></div>
                                        <p class="username">{{item.username}}</p>
                                        <a href="javascript:;" @click="removeComponent(index, item)" v-if="item.myself == 1">删除</a>
                                        <span class="dateTime">{{item.dateTime}}</span>
                                    </div>
                                    <p class="component-text">{{item.commentText}}</p>
                                </div>
                                <div class="component-scroll-bottomOffset" style="height: 0rem;"></div>
                            </section> <!---->
                        </div>
                    </div>
                </div>
            </div> 
                <!--<a href="javascript:;" class="album-bigImageLayer-btn album-bigImageLayer-download" @click="download(activeBigPic.aid)"><i class="iconfont icon-download"></i>下载</a>--> 
            <!--<button class="album-bigImageLayer-btn" @click="uploadBigPic" >
            	<span v-if="isLoadBigPic">大图加载中</span>
            	<span v-else>加载大图</span>
            </button>-->
        </div>
    </div>
    <!-- 评论大图弹窗 -->
    <div class="bigpic-pop2 comment-pop" v-if="showCommentBigPic">
    	<button class="tool-close" @click="closeMoreMenu"><i class="">×</i></button>

    	<div class="swiper-container swiper1" id="swiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide position_new" v-if="item.show_type==0" v-for="(item,index) in imageList">
                    <div>
                        <img :src="item.midUrl" v-if="!activeBigPic.isLoadBigPiced" />
                        <img :src="item.midUrl" :data-bigurl="item.bigUrl" v-else />
                    </div>
                    <button class="album-bigImageLayer-loadImage"   v-if="item.isLoadBigPiced" @click="showBigImageLayer(item,index,$event)">加载大图({{item.bigImgSize}}MB)</button>
                    <div class="album-bigImageLayer-size" v-show="item.currentSize">当前图片{{item.currentSize}}KB，可长按保存</div>
                    <div class="album-bigImageLayer-loadgif"></div>
                </div>
                <div class="swiper-slide swiper-slide2" v-else>
                    <div>
                        <img :src="item.midUrl" v-if="!activeBigPic.isLoadBigPiced" />
                        <img :src="item.midUrl" :data-bigurl="item.bigUrl" v-else />
                    </div>
                    <button class="album-bigImageLayer-loadImage"  v-if="item.isLoadBigPiced" @click="showBigImageLayer(item,index,$event)">加载大图({{item.bigImgSize}}MB)</button>
                    <div class="album-bigImageLayer-size" v-show="item.currentSize">当前图片{{item.currentSize}}KB，可长按保存</div>
                    <div class="album-bigImageLayer-loadgif"></div>
                </div>
            </div>
        </div>
        <div class="album-bigImageLayer-bottom">
    		<div class="component-comment" @click.stop="showBigPicInfo=true;">
    			<i class="album-imageInfo-icon fa fa-photo fa-fw fa-lg"></i>
    			<div class="tool-layout" @click.stop="showBigPicInfo=false;" v-if="showBigPicInfo">
    				<ul class="album-imageInfo-info">
    					<li class="clearfix">
    						<label class="pull-left">文件大小</label> 
    						<div class="pull-right text-overflow">{{activeBigPic.bigImgSize}}</div>
    					</li> 
    					<li class="clearfix">
    						<label class="pull-left">拍摄时间</label> 
    						<div class="pull-right text-overflow">{{activeBigPic.dateTime}}</div>
    					</li> 
    					<li class="clearfix">
    						<label class="pull-left">文件编号</label> 
    						<div class="pull-right text-overflow">{{activeBigPic.picId}}</div>
    					</li>
    				</ul>
    			</div>
    		</div> 
    		<div class="component-comment" @click="praiseFn">
                    <i class="component-praise-icon fa fa-star fa-fw fa-lg" v-if="activeBigPic.isPraise==true"></i>
                <i class="component-praise-icon fa fa-star-o fa-fw fa-lg" v-else></i>
                <span class="component-praise-num" v-if="activeBigPic.praise != 0">{{activeBigPic.praise}}</span>
            </div> 
    		<div class="component-comment">
                <i class="component-comment-icon fa fa-commenting fa-fw fa-lg" @click="isShowComment=true;componetVal='';"></i> 
                <span class="component-comment-num" v-if="activeBigPic.commentList.length != 0">{{activeBigPic.commentList.length}}</span>
                <div class="component-commentBox" v-if="isShowComment">
                    <button class="tool-close" @click="isShowComment=false;"><i>×</i></button> 
                    <div class="component-commentBox-top clearfix">
                        <div class="component-commentBox-input">
                            <textarea id="component-commentBox-input" v-model="componetVal" placeholder="我也来说点什么吧..." maxlength="100"></textarea>
                        </div> 
                        <div class="component-commentBox-submit fr">
                            <button v-for="(item,index) in user_info" @click="addComponet(index, item)">发布</button>
                        </div> 
                        <span class="component-commentBox-count">{{componetVal.length}} / 100</span>
                    </div> 
                    <!-- 评论主题内容 -->
                    <div class="component-commentBox-main">
                        <div class="component-commentBox-main-top"><span>{{activeBigPic.commentList.length}}</span>条评论(点击评论可回复)</div> 
                        <div class="component-scroll component-commentBox-main-msg">
                            <section class="component-scroll-list"> <!----> 
                                <div class="component-item" v-for="(item,index) in activeBigPic.commentList">
                                    <div class="component-item-top">
                                        <div class="image"><img :src="item.userPic"/></div>
                                        <p class="username">{{item.username}}</p>
                                        <a href="javascript:;" @click="removeComponent(index, item)" v-if="item.myself == 1">删除</a>
                                        <span class="dateTime">{{item.dateTime}}</span>
                                    </div>
                                    <p class="component-text">{{item.commentText}}</p>
                                </div>
                                <div class="component-scroll-bottomOffset" style="height: 0rem;"></div>
                            </section> <!---->
                        </div>
                    </div>
                </div>
            </div> 
    		<!--<a href="javascript:;" class="album-bigImageLayer-btn album-bigImageLayer-download" @click="download()"><i class="iconfont icon-download"></i>下载
            </a> 
            <button class="album-bigImageLayer-btn" @click="uploadBigPic" v-if="!activeBigPic.isLoadBigPiced">
            	<span v-if="isLoadBigPic">大图加载中</span>
            	<span v-else>加载大图({{activeBigPic.size}})</span>
            </button>-->
        </div>
    </div>

    <!-- 评论弹窗 -->
    <div class="album-albumComment" v-show="showCommnetList" style="display:none;">
        <section class="album-albumComment">
            <button class="tool-close" @click="hideCommentFn"><i class="">×</i></button> 
            <h2 class="album-albumComment-title">点击照片可参与评论</h2> 
            <div class="component-scroll album-albumComment-list">
                <section class="component-scroll-list">
                    <div class="album-albumImageItem" v-for="(item,index) in commentData" @click="showMoreMenuTwo(item, index)">
                        <a class="album-albumImageItem-left">
                            <img :src="item.userPic" />
                        </a> 
                        <div class="album-albumImageItem-right">
                            <div class="album-albumImageItem-top">
                                <span class="album-albumImageItem-nick">{{item.username}}</span> 
                                <span class="album-albumImageItem-time">{{item.dateTime}}</span>
                            </div> 
                            <div class="album-albumImageItem-text" v-if="item.commentText">{{item.commentText}}</div>
                        </div>
                    </div>
                    <div class="component-scroll-bottomOffset" style="height: 0rem;"></div>
                </section>
            </div>
        </section>
    </div>
    <!-- 找我弹框 -->
    <div class="album-albumComment" v-show="showMeList" style="display:none;">
        <section class="album-albumComment">
            <!--<button class="tool-close" @click="hideCommentFn"><i class="">×</i></button>--> 
            <div style="height:.46rem;background:#000;padding-top:5px;">
                <p class="album-albumComment-title" style="line-height:.2rem;">我们为您找到{{meImgCount}}张相似照片，根据相似度从上到下排列。</p> 
                <p class="album-albumComment-title" style="line-height:.2rem;">提醒：为了帮您找到更多照片，可能有部分照片不准确。</p> 
            </div>
            <div class="component-scroll album-albumComment-list">
                <ul class="image-content" v-show="showMeList" style="margin-top:0px;">
                    <li v-for="(item,index) in imageList" @click="showMoreMenu(item, index)"><img class='default-image' :src="item.smallUrl" @load="successLoadImg" @error="errorLoadImg"/></li>
                </ul>
            </div>
        </section>
    </div>
    <!-- 找我find me-->
    <div id="component-pop-me" class="bigpic-pop component-pop-me" v-show="showMe" style="display:none;">
        <!--<button class="tool-close" @click="closeMoreMenu"><i class="">×</i></button>-->
        <p class="des">用“找我”人脸识别功能，可快速查找相册里的照片</p>
        <div class="avatar">
            <div class="upload_warp_img" v-if="imgMeList.length!=0">
                <div class="upload_warp_img_div" v-for="(item, index) in imgMeList">
                  <div class="upload_warp_img_div_top"></div>
                  <img :src="item.file.src" width="150" style="position:relative;top:15px;">
                </div>
            </div>
            <img v-if="imgMeList.length==0" src="/addons/wxz_piclive/template/mobile/images/avatar_default.png">
        </div>
        <p id="findMeBtn" style="display:none;"><button class="album-upload-btn" @click="findmeUploadBtn"><span>找&nbsp;&nbsp;我</span></button></p>
        <button class="album-upload-btn" @click="fileMeClick"><span id="album-upload-btn-text">上传图片</span></button>
        <input @change="fileMeChange($event)" type="file" id="upload_file" style="display: none">
        <input type="hidden" name="meImgUrl" id="meImgUrl">
    </div>

	<!-- 提醒弹框 -->
	<!--<div id="download" style="width:100%;position:fixed;bottom:65px;text-align:center;color:#fff;z-index:999;display:none;">请长按图片下载</div>-->
    <aside class="component-scroll-backTop component-scroll-me"  @click="toFindMe" >
        <p><i class="fa fa-user-circle-o"></i></p> <p class="component-verticalBotton-text">找我</p>
    </aside>
    <!-- 返回顶部 -->
    <aside class="component-scroll-backTop" v-show="scroll_top>50" @click="toScrollTop">↑</aside>
    <!--批量处理图片-->
    <img :src="cronUrl" width="0" height="0" />
    <!--批量处理图片-->
</div>

<script>
Vue.prototype.successLoadImg = function(event) {
  if (event.target.complete == true) {
    event.target.classList.remove("default-image");
    var imgParentNode = event.target.parentNode;
    if(imgParentNode.classList.contains('show-img')==true){
      imgParentNode.style.background = "#000";
    }
  }
};
Vue.prototype.errorLoadImg = function(event) {
  event.target.classList.add("default-image");
};

</script>

<script>;</script><script type="text/javascript" src="https://simplife.cc/app/index.php?i=13&c=utility&a=visit&do=showjs&m=wxz_piclive"></script></body>
</html>