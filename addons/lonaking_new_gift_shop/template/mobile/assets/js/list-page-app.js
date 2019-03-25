$(function() {
    function a() {
        console.log("appItemNextPage:" + m + "|autoRecommendNextPage:" + n + "|appItemPage:" + o + "|autoRecommendPage:" + p),
            h = !0,
            l.show(),
            k.html("正在加载中"),
            c = g.height();
        var e = c - d;
        $("body").scrollTop(e),
            $.ajax({
                type: "post",
                url: f,
                data: {
                    type: r,
                    appItemNextPage: m,
                    appItemPage: o,
                    autoRecommendNextPage: n,
                    autoRecommendPage: p,
                    arunum: q
                },
                dataType: "json",
                success: function(a) {
                    if (h = !1, 1 === o && 0 === a.items.length) return void j.remove();
                    m = a.appItemNextPage,
                        q = a.arunum,
                    m && (o += 1),
                        n = a.autoRecommendNextPage,
                    n && (p += 1),
                    m || n || (l.hide(), k.html("没有更多了！"));
                    var c = a.items.length,
                        d = "";
                    for (i = 0; i < c; i++) d += b(a.items[i]);
                    $(".recommend").append(d)
                },
                error: function(b) {
                    l.hide(),
                        k.html('加载失败，点击<span class="themeColor">重试</span>'),
                        j.bind("click",
                            function() {
                                a(),
                                    j.unbind("click")
                            })
                }
            })
    }
    function b(a) {
        var b = [];
        return b.push('<a href="' + a.url + '" class="item ' + (a.tagClasses || "") + '">'),
            b.push('<img src="' + a.logo + '" />'),
            b.push('<div class="item-info">'),
            b.push("<h3>" + a.title + "</h3>"),
            b.push('<p class="theme-color">' + a.credits + "</p>"),
            b.push("</div>"),
        a.tagText && b.push('<div class="tag" style="border-bottom-color:' + a.tagColor + '"><span>' + a.tagText + "</span></div>"),
        a.recommendText && b.push('<button class="theme-color theme-bordercolor">' + a.recommendText + "</button>"),
            b.push("</a>"),
            b.join("")
    }
    var c, d, e, f = GET_ITEMS_URL,
        g = $(document),
        h = !1,
        j = $(".loading"),
        k = $(".loading-tip"),
        l = $(".loading-img"),
        m = _appItemNextPage,
        n = _autoRecommendNextPage,
        o = 2,
        p = 1,
        q = _arunum,
        r = _type;
    _arn && (p = 2),
    m || n || (l.hide(), k.html("")),
        g.scroll(function() {
            d = $(window).height(),
                c = g.height() - j.height(),
                e = $("body").scrollTop(),
            e + d >= c && c >= d && (h || !m && !n || a())
        })
});