var credit1 = {
    data : {
        pageData : {
            page : 1,
            size : 10
        },
        rank : 1,
        pagerActive : true,
        user : {
            uid : null,
        },
        type : "credit1"

    },
    init : function () {
        credit1.functions.fetchRankList(function (json) {
            $(".load-more").text("加载中...");
            var creditList = json.data.data;
            credit1.functions.appendRankList(creditList);
            $(".load-more").text("点击加载");
        });

        credit1.data.user.uid = parseInt($("html").data("uid"));

        if($("html").data("credit-type") != "credit1"){
            credit1.data.type = $("html").data("credit-type");
        }

    },
    event : function(){
        //load more
        $(".load-more").on("click", function (e) {
            e.stopPropagation();
            if(credit1.data.pagerActive){
                $(".load-more").text("加载中...");
                credit1.functions.fetchRankList(function (json) {
                    var creditList = json.data.data;
                    if(creditList.length == 0){

                    }else{
                        credit1.functions.appendRankList(creditList);
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
                    if(index == 0 && credit1.data.rank == 1){
                        if(item.uid == credit1.data.user.uid){
                            return true;
                        }
                    }
                    var sexColor = "blue";
                    if(item.gender == 2){
                        sexColor = "pink";
                    }
                    var rank = credit1.data.rank;
                    credit1.data.rank = credit1.data.rank + 1;
                    var numHTML = "";
                    if(credit1.data.type == "credit1"){
                        numHTML = '<span class="num">'+item.credit1+'</span>分';
                    }else if(credit1.data.type == "credit2"){
                        numHTML = '<span class="num">'+item.credit2+'</span>元';
                    }
                    //var html = '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 list-group-item item"><div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 head-image"><img class="img-circle" src="'+d.avatar+'"></div><div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-info"><span class="name">'+d.nickname+' <i class="icon-user blue"></i></span><br><span class="icon-map-marker icon-gray">'+d.country+d.province+d.city＋'</span></div><div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 score text-center"><span class="num">'+d.credit1+'</span>分</div><div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 rank text-center">+credit1.data.pageData.rank+</div></div>';
                    var html = '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 list-group-item item" data-item-uid="'+item.uid+'"><div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 head-image"><img class="img-circle" src="'+item.avatar+'"></div><div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-info"><span class="name">'+item.nickname+' <i class="icon-user '+sexColor+'"></i></span><br><span class="icon-map-marker icon-gray">&nbsp;&nbsp;'+item.nationality+'·'+item.resideprovince+'·'+item.residecity+'</span></div><div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 score text-center">'+numHTML+'</div><div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 rank text-center">'+rank+'</div></div>';
                    newHtml = newHtml+html;
                });
                $(".record-list").append(newHtml);
            }else{

                credit1.data.pagerActive = false;
            }
        },

        fetchRankList : function(success){
            var postUrl = $('html').data('rank-list-url');
            var postData = credit1.data.pageData;

            $.post(postUrl,postData, function (e) {
                var json = JSON.parse(e);
                //var json = e;
                if(json.status == 200){
                    credit1.data.pageData.page = credit1.data.pageData.page + 1;
                    success(json);
                }
            });
        }
    }
};
$(function () {
    credit1.init();
    credit1.event();
});