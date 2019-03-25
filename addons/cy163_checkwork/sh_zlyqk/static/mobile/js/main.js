!function (e) {
    "use strict";
    !function () {
        e(document).on("click", ".alert .btn-close,.alert .js_btn-cancle", function (t) {
            t.preventDefault(), e(this).parents(".alert").fadeOut("300", function () {
                e(this).removeClass("show")
            })
        }), e(".fullpage").height(e(window).height()), e("body").on("click", "header .btn-menu", function (t) {
            t.preventDefault(), e(".menu-overly,.menu").fadeIn(300)
        }), e("body").on("click", ".menu-overly", function (t) {
            t.preventDefault(), e(".menu-overly,.menu").fadeOut("300")
        }), e("body").on("click", ".page1 .list span", function (t) {
            t.preventDefault(), e(this).siblings().removeClass("on"), e(this).addClass("on")
        })
    }()
}(jQuery), TouchSlide({
    slideCell: "#js_banner",
    titCell: ".hd ul",
    mainCell: ".bd ul",
    effect: "leftLoop",
    autoPlay: !0,
    autoPage: !0,
    switchLoad: "_src"
}), TouchSlide({
    slideCell: "#tabBox1", endFun: function (e) {
        var t = document.getElementById("tabBox1-bd");
        t.parentNode.style.height = t.children[e].children[0].offsetHeight + 50 + "px", e > 0 && (t.parentNode.style.transition = "200ms")
    }
});

$(".menu-overly").click(function(){
    $(this).css("display","none");
});