/**
 * Created by momo on 2017/11/15.
 */
/* 下拉刷新
function o(e) {
    c = h ? e.screenY : e.touches[0].screenY;
    var t = c - s;
    t > 0 && (e.preventDefault(),
    t < m && i(t),
    t >= m && t <= m + f && i(m + .3 * (t - m)))
}
function a() {
    var e = refresh.css("height");
    return Number(e.replace("rem", ""))
}
function i(e) {
    e = 2 * e / 100,
        refresh.css({
            height: e + "rem",
            "transition-prototype": "height",
            "transition-duration": "0ms"
        })
}
function r(e) {
    e = e || 0,
        refresh.css({
            height: e + "rem",
            "transition-prototype": "height",
            "transition-duration": "800ms"
        })
}
var wrapper = document.getElementById("wrapper"),
    refresh = $("#refresh-block"),
    m = 30, f = 120,
    v = "touchstart", w = "touchmove", x = "touchend";
refresh.css({
    "transition-timing-function": "cubic-bezier(0.1, 0.57, 0.1, 1)"
});
document.body.addEventListener(w, function(e) {
    e.stopPropagation(), e.stopImmediatePropagation()
});
wrapper.addEventListener(v, function(e) {
    refresh.show();
    refresh.find("p").text("下拉刷新"),
        s = h ? e.screenY : e.touches[0].screenY,
    document.body.scrollHeight - document.body.scrollTop - document.body.clientHeight >= 0 && wrapper.addEventListener(w, o)
});
wrapper.addEventListener(x, function(e) {
    wrapper.removeEventListener(w, o);
    var t = a();
    t >= .75 ? (r(.75),
        refresh.find("p").text("更新中..."),
        loadingdata()) : r()
});
*/
function formatTemplate(dta, tmpl) {
    var format = {
        name: function(x) {
            return x
        }
    };
    return tmpl.replace(/{([a-zA-Z_0-9]+)}/g, function(m1, m2) {
        if (!m2) {
            return "";
        }
        return (format && format[m2]) ? format[m2](dta[m2]) : dta[m2];
    });
}
function scollers() {
    if($(window).scrollTop()  > 500) {
        $('#backToTop').show();
    } else {
        $('#backToTop').hide();
    }
    if(category_id <=0) {
        return;
    }
    if (totalheight = parseFloat($(window).height()) + parseFloat($(window).scrollTop()),
        $(document).height() <= totalheight + max) {
        if (loading) {
            return;
        }else {
            loading = true;
            loadingdata();
        }


    }
}
template_id0 = $('#template_pic0').html();
template_id1 = $('#template_pic1').html();
template_id3 = $('#template_pic3').html();
template_pic_video = $('#template_pic_video').html();
function getHtml(id) {
    if(id == 0) {
        return template_id0;
    }else if(id == 1) {
        return template_id1;
    }else if(id == 3) {
        return template_id3;
    }
}
function loadingdata() {
    $("#loadmore").show(),
        $.getJSON(more_url,
            {
            category_id:category_id,
            id: last_id
            },
            function(data) {
                $("#loadmore").hide();
                if(last_id==0) {
                    $('#carousel').hide();
                }
                if(data.slider.length > 0) {
                    mySwiper.removeAllSlides(); //移除全部
                    $('#carousel').show();
                    $.each(data.slider, function (key, dat) {
                        mySwiper.appendSlide(formatTemplate(dat,slider_content));
                    });
                    mySwiper.updateSlidesSize();
                    // mySwiper.updatePagination();
                    mySwiper.slideTo(1, 500, false);//切换到第一个slide，速度为1秒
                    mySwiper.startAutoplay();
                }
                last_id = data.min_id;
                $.each(data.article, function (key, dat) {

                    if(dat.type == 3) {
                        $('#main').append(formatTemplate(dat,template_pic_video));
                    }else {
                        $('#main').append(formatTemplate(dat,getHtml(dat.count)));
                    }

                });
                loading= false;
                if(!data.more) {
                    loading = true;
                }
            });
}
var max = 70, loading= false;
window.addEventListener("scroll", scollers);
loading = true;
loadingdata();
$('.scroller-menu').click(function () {
    var id = $(this).attr('data-id');
    var url = $(this).attr('data-url');
    if(url) {
        location = url;
    }else {
        category_id = id;
        if(category_id >0) {
            $('#top-news').hide();
        }else {
            $('#top-news').show();
        }
        history.pushState(null, null, edit_url+'&category_id='+id);
        last_id = 0;
        loading = true;
        $('.now-scroller').removeClass('now-scroller');
        $(this).addClass('now-scroller');
        $('#main').html('');
        loadingdata();
    }

});