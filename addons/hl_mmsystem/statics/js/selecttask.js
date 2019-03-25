function refresh(){
    location.reload();
}

var isCheckAll = false;  
function swapCheck() {  
    if (isCheckAll) {  
        $("input[type='checkbox']").each(function() {  
            this.checked = false;  
        });  
        isCheckAll = false;  
    } else {  
        $("input[type='checkbox']").each(function() {  
            this.checked = true;  
        });  
            isCheckAll = true;  
    }  
}

/**
 *QQ表情选择器
 */
function qqEmoji(elm, target, callback) {
	require(["emoji"], function() {
		$(function() {
			var emotions_html = window.util.templates["emoji-content-qq.tpl"];
			$(elm).popover({
				html: !0,
				content: emotions_html,
				placement: "bottom"
			});
			$(elm).one("shown.bs.popover", function() {
				$(elm).next().mouseleave(function() {
					$(elm).popover('hide');
				});
				$(elm).next().delegate(".eItem", "mouseover", function() {
					var emo_img = '<img src="' + $(this).attr("data-gifurl") + '" alt="mo-' + $(this).attr("data-title") + '" />';
					var emo_txt = '/' + $(this).attr("data-code");
					$(elm).next().find(".emotionsGif").html(emo_img);
				});
				$(elm).next().delegate(".eItem", "click", function() {
					var emo_txt = '/' + $(this).attr("data-code");
					var cont = $(target).val() + emo_txt;
					$(target).val(cont);
					$(elm).popover('hide');
					if ($.isFunction(callback)) {
						callback(emo_txt, elm, target);
					}
				});
			});
		});
	});
};

/**
 *数据选择器
 */
function select_templ(id1,id2){
    var urlStrValue = window.location.pathname;
    if(urlStrValue.indexOf("index") >= 0 ) {
        urlStrValue= "./index.php?c=site&a=entry&op=select_templ&do=selector&m=hl_mmsystem";
    }else if((urlStrValue.indexOf("hladministrator") >= 0 )) {
        urlStrValue= "./hladministrator.php?c=site&a=entry&op=select_templ&do=selector&m=hl_mmsystem";
    }
    new $.flavr({
        title   : '模板选择器',
        content : '<div id="select_templ"></div>',
        buttons : {
            close : {text:'关闭'}
        },
        closeOverlay : true,
        closeEsc     : true
    });
    $.ajax({
        url: urlStrValue,
        cache: false,
        data:{id1:id1, id2:id2}
    }).done(function (html) {
        $("#select_templ").append(html);
    });
}

function select_task(id1,id2){
    var urlStrValue = window.location.pathname;
    if(urlStrValue.indexOf("index") >= 0 ) {
        urlStrValue= "./index.php?c=site&a=entry&op=select_task&do=selector&m=hl_mmsystem";
    }else if((urlStrValue.indexOf("hladministrator") >= 0 )) {
        urlStrValue= "./hladministrator.php?c=site&a=entry&op=select_task&do=selector&m=hl_mmsystem";
    }
    new $.flavr({
        title   : '任务选择器',
        content : '<div id="select_task"></div>',
        buttons : {
            close : {text:'关闭'}
        },
        closeOverlay : true,
        closeEsc     : true
    });
    $.ajax({
        url: urlStrValue,
        cache: false,
        data:{id1:id1, id2:id2}
    }).done(function (html) {
        $("#select_task").append(html);
    });
}

function select_fans(id1,id2,close){
    var closebtn_title = '关闭';
    if(close == 'no'){
        var closebtn_title = '选择完毕后，请点这里';
    }
    var urlStrValue = window.location.pathname;
    if(urlStrValue.indexOf("index") >= 0 ) {
        urlStrValue= "./index.php?c=site&a=entry&op=select_fans&do=selector&m=hl_mmsystem&close="+close;
    }else if((urlStrValue.indexOf("hladministrator") >= 0 )) {
        urlStrValue= "./hladministrator.php?c=site&a=entry&op=select_fans&do=selector&m=hl_mmsystem&close="+close;
    }
    new $.flavr({
        title   : '粉丝选择器',
        content : '<div id="select_templ"></div>',
        buttons : {
            close : {text:closebtn_title}
        },
        closeOverlay : true,
        closeEsc     : true
    });

    $.ajax({
        url: urlStrValue,
        cache: false,
        data:{id1:id1, id2:id2}
    }).done(function (html) {
        $("#select_templ").append(html);
    });
}

function updatedb(){
    new $.flavr({
        content  : 'Here is the dialog #3',
        position : 'bottom-right',
        closeOverlay : true,
        closeEsc     : true
    });
}