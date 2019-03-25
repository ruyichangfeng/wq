$(function(){
    $('img').each(function(index,obj){
        var img = $(obj);
        if(typeof(img.attr("data-src")) != 'undefined'){
            var src = img.data('src');
            var placeholder = SC.THEME_URL+'/images/pic_def.jpg';
            if(img.data('placeholder'))placeholder = img.data('placeholder');
            img.attr('src',placeholder);
            var image = new Image();
            image.onload = function(){
                img.attr('src',image.src);
            }
            // 延迟加载
            setTimeout(function(){
                image.src = src;
            },500);
        }
    });
});