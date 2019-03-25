function showActionList(j) {
    var f = '<div class="ux-popmenu" id="updownNav"><div class="pop-content show"><section class="card-combine">';
    for (var e = 0,
    l; l = j[e]; e++) {
        var a = typeof l[1] == "function" ? "javascript:;": l[1];
        var c = l[2] || false;
        f += '<a href="' + a + '"' + (c ? ' target="_blank"': "") + "><span>" + l[0] + "</span></a>"
    }
    f += '<a class="cancel" href="javascript:;"><span>取消</span></a></section></div></div>';
    $("body").append(f);
    var h = $("#updownNav");
    var b = h.find(".pop-content");
    var k = -(b.height() + 10);
    b.css("bottom", k + "px");
    b.animate({
        "bottom": 0
    },
    "fast",
    function() {
        h.bind("click",
        function(i) {
            if (!$.contains(b.get(0), i.target)) {
                g()
            }
        })
    });
    var g = function(i) {
        h.unbind("click");
        i = typeof i == "undefined" ? true: i;
        if (i) {
            b.animate({
                "bottom": k + "px"
            },
            "fast",
            function() {
                h.remove()
            })
        } else {
            h.remove()
        }
    };
    var d = $("a.cancel", b).click(g).siblings().click(function() {
        g(false)
    });
    for (var e = 0,
    l; l = j[e]; e++) {
        if (typeof l[1] == "function") {
            d.eq(e).click(l[1])
        }
    }
}
function showAlert(c, b) {
    b = _parseConfirmBtn(b, "确定");
    var a = '<div class="alert-popmenu" id="popupConfirm"><div class="pop-content-main"><div class="pop-txt"><p>' + c + "</p></div>" + '<div class="pop-footer-btn clearfix"><a href="javascript:;" style="width:100%;">' + b.text + "</a></div></div></div>";
    $("body").append(a);
    var d = $("#popupConfirm");
    var e = d.find(".pop-content-main");
    e.css("top", 180);
    e.find(".pop-footer-btn > a").click(function() {
        d.remove();
        if ($.isFunction(b.event)) {
            b.event()
        }
    })
}
function showConfirm(e, a, d) {
    a = _parseConfirmBtn(a, "确定");
    d = _parseConfirmBtn(d, "取消");
    var c = '<div class="alert-popmenu" id="popupConfirm"><div class="pop-content-main"><div class="pop-txt"><p>' + e + "</p></div>" + '<div class="pop-footer-btn clearfix"><a href="javascript:;">' + a.text + '</a><a class="line-left" href="javascript:;">' + d.text + "</a></div></div></div>";
    $("body").append(c);
    var f = $("#popupConfirm");
    var g = f.find(".pop-content-main");
    g.css("top", ($(window).height() - g.height()) / 2);
    var b = g.find(".pop-footer-btn > a");
    b.click(function() {
        f.remove()
    });
    if ($.isFunction(a.event)) {
        b.eq(0).click(a.event)
    }
    if ($.isFunction(d.event)) {
        b.eq(1).click(d.event)
    }
}
function _parseConfirmBtn(a, b) {
    var c = {
        text: b,
        event: null
    };
    if ($.isFunction(a)) {
        c.event = a
    } else {
        if (typeof a == "string") {
            c.text = a
        } else {
            if ($.isArray(a)) {
                c.text = a[0];
                if (a[1] && $.isFunction(a[1])) {
                    c.event = a[1]
                }
            }
        }
    }
    return c
}
function closeTip(b, a) {
    a = a || 0;
    $.post(BASE_URL + "misc/close", {
        tip: b,
        exp: a
    },
    $.noop)
}
function back() {
    window.history.back()
}
window.onerror = function(c, b, a) {
    $.post(BASE_URL + "misc/reportJsError", {
        msg: c,
        js: b,
        line: a,
        url: location.href
    })
};