let app = getApp();
Page({

    onLoad: function (e) {
        this.setData({
            'siteInfo': app.siteInfo,
        });
    },
    //更新用户信息
    updateUserInfo(result) {
        var app = getApp();
        let loginRefer = wx.getStorageSync('loginRefer');
        var that = this;

        //拿到用户数据时，通过app.util.getUserinfo将加密串传递给服务端
        //服务端会解密，并保存用户数据，生成sessionid返回
        app.util.getUserInfo(function (userInfo) {
            //这回userInfo为用户信息
            //更细本地userInfo
            app.util.request({
                url: 'user/synUser',
                data: {'uid': userInfo.memberInfo.uid},
                showLoading: false,
                header: {
                    contentType: "application/json",
                },
                method: 'POST',
                cachetime: 0,
                success: function (res) {
                    wx.showToast({
                        title: '授权成功',
                        icon: 'none',
                    });
                    if (loginRefer) {
                        wx.removeStorageSync('loginRefer');
                        wx.redirectTo({
                            url: loginRefer,
                        });
                    } else {
                        //当前页面刷新
                        wx.redirectTo({
                            url: '/wxz_multiroom/pages/newindex/newindex',
                        });
                    }
                }
            });
        }, result.detail)
    },
})