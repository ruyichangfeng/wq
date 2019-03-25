$(document).ready(function(){
    var currentMenu = $(".selectedMenu");
    $(".menu li").hover(function(){
        $(".menu li").removeClass("selectedMenu");
        $(this).addClass("selectedMenu");
    },function(){
        $(".menu li").removeClass("selectedMenu");
        $(currentMenu).addClass("selectedMenu")
    }) 
    $(".loginBtn").hover(function(){
        $(this).addClass("loginBtnSelected");
    },function(){
        $(this).removeClass("loginBtnSelected");
    })
});