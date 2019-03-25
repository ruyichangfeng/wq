$.ajax({
    url: "http://dzgbk.hfxync.com/x34utf8/plugin.php?id=wxz_live:index&pmod=index&do=apply&act=apply&do=uploadVideoTest",
    dataType: 'json',
    success: function (res) {
        var token = res.uptoken;
        var domain = res.domain;
        var config = {
            useCdnDomain: true,
            disableStatisticsReport: false,
            retryCount: 6
        };
        var putExtra = {
            fname: "",
            params: {},
            mimeType: null
        };
        $(".nav-box")
            .find("a")
            .each(function (index) {
                $(this).on("click", function (e) {
                    switch (e.target.name) {
                        case "h5":
                            uploadWithSDK(token, putExtra, config, domain);
                            break;
                        case "expand":
                            uploadWithOthers(token, putExtra, config, domain);
                            break;
                        case "directForm":
                            uploadWithForm(token, putExtra, config);
                            break;
                        default:
                            "";
                    }
                });
            });
        imageControl(domain);
        uploadWithSDK(token, putExtra, config, domain);
    }
})
