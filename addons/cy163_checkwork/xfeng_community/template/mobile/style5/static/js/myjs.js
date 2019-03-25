/**
 * Created by admin on 2016/12/2.
 */
$(function(){
    var mySwiper = $('.banner .swiper-container').swiper({
        pagination:'.banner .swiper-pagination',
        observer: true, //修改swiper自己或子元素时，自动初始化swiper
        observeParents: true, //修改swiper的父元素时，自动初始化swiper
        autoplay : 3000
    });

    var swiper = new Swiper('.case .swiper-container', {
        pagination: '.swiper-pagination',
        observer: true, //修改swiper自己或子元素时，自动初始化swiper
        observeParents: true, //修改swiper的父元素时，自动初始化swiper
//            autoplay : 3000
    });
})

// /*通知轮播*/
$(function () {
    var $this = $(".scrollNews");
    var t =null;
    $this.hover(function () {
        clearInterval(t);
    },function () {
        t = setInterval(function () {
            scrollNews ($this);
        },4000);
    }).trigger("mouseleave");
});
function scrollNews(obj) {
    var $self = obj.find('.yy');
    var lineHeight = $self.find(".notice").eq(0).height();
    $self.animate({"marginTop": -lineHeight +"px"}, 600 , function(){
        $self.css({marginTop:0}).find(".notice").eq(0).appendTo($self);
    })
}
//加载更多
$(document).on('click','.open-preloader-title',function () {
    $.showIndicator();
    setTimeout(function (){
       $.hideIndicator();
    },2000);
})


