var common = {
    data : {

    },
    init : function () {

    },
    event : function(){
        $(".target").on("click", function (e) {
            e.stopPropagation();
            var targetUrl = $(this).data("href");
            window.location.href = targetUrl;
        });
    },

    functions : {

    }
};
$(function () {
    common.init();
    common.event();
});