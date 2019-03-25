var log = {
    data : {
        pageData : {
            page : 1,
            size : 10
        },
        pagerActive : true,
        user : {
            uid : null,
        },
        type : "credit1",
        urls : {
            loadCreditLogUrl : null,
        }

    },
    init : function () {
        //初始化url
        log.data.urls.loadCreditLogUrl = $("html").data("load-credit-log-url");

        log.functions.fetchRankList(function (json) {
            $(".load-more").text("加载中...");
            var creditList = json.data.data;
            log.functions.appendRankList(creditList);
            $(".load-more").text("点击加载");
        });

        log.data.user.uid = parseInt($("html").data("uid"));

        if($("html").data("credit-type") != "credit1"){
            log.data.type = $("html").data("credit-type");
        }
    },
    event : function(){
        //load more
        $(".load-more").on("click", function (e) {
            e.stopPropagation();
            if(log.data.pagerActive){
                $(".load-more").text("加载中...");
                log.functions.fetchRankList(function (json) {
                    var creditList = json.data.data;
                    if(creditList.length == 0){

                    }else{
                        log.functions.appendRankList(creditList);
                    }
                    $(".load-more").text("点击加载");
                });
            }else{
                $(".load-more").text("没有了");
            }

        })
    },

    functions : {
        appendRankList : function (creditList) {
            if(creditList.length > 0){
                var newHtml = "";
                $.each(creditList,function (index,item){
                    var numHTML = '';
                    var dateStr = formatDate(new Date(item.createtime*1000));
                    if(item.num < 0){
                        numHTML = '<div class="pre_count pre_green">'+item.num+'</div>';
                    }else{
                        numHTML = '<div class="pre_count">+'+item.num+'</div>';
                    }
                    var html = '<li data-id=""><div><h3>'+item.remark+'</h3><p>'+dateStr+'</p></div>'+numHTML+'</li>';
                    newHtml = newHtml+html;
                });
                $("ul.list section").append(newHtml);
            }else{

                log.data.pagerActive = false;
            }
        },

        fetchRankList : function(success){
            var postUrl = log.data.urls.loadCreditLogUrl;
            var postData = log.data.pageData;

            $.post(postUrl,postData, function (e) {
                var json = JSON.parse(e);
                //var json = e;
                if(json.status == 200){
                    log.data.pageData.page = log.data.pageData.page + 1;
                    success(json);
                }
            });
        }
    }
};
$(function () {
    log.init();
    log.event();
});

function formatDate(now) {
    var year = now.getFullYear();
    var month = now.getMonth() + 1;
    var date = now.getDate();
    var hour = now.getHours();
    var minute = now.getMinutes();
    var second = now.getSeconds();
    return year + "-" + month + "-" + date + "   " + hour + ":" + minute + ":" + second;
}