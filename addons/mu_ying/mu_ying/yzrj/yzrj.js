var page=1;
var app = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    all: true,
    itemList: [],
    ismore: true,
    yes:false,
    no:true
  },
  // 隐藏或显示导航菜单
  hideNav: function (e) {
    this.setData({
      select: (!this.data.select)
    })
  },
  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {
    this.getBase();
    // this.getZsbk();
    this.getSycd();
  },
  getSycd: function () {
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/Sycd',
      'cachetime': '30',
      success: function (res) {
        console.log(res)
        that.setData({
          sycd: res.data.data,
        })
      },
      fail: function (err) {
        console.log(err)
      },

    })
  },
  getBase: function () {
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/Base',
      'cachetime': '30',
      success: function (res) {
        console.log(res)
        that.setData({
          baseinfo: res.data.data,
        })
        wx.setNavigationBarTitle({ title: that.data.baseinfo.title })
      },
      fail: function (err) {
        console.log(err)
      },

    })
  },
  getZsbk: function (_page) {
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/Zsbk',
      data:{page:_page},
      'cachetime': '30',
      success: function (res) {
        var list_t = that.data.itemList;
        var len = res.data.data.length;
        for (var i = 0; i < len; i++) {
          list_t.push(res.data.data[i]);
        }
        // that.setData({ itemList: list_t });
        that.setData({
          zsbk: res.data.data,
          itemList: list_t
        })
      },
      fail: function (err) {
        console.log(err)
      },

    })
  },


  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    //app.setAppColor();
    page = 1;
    this.getZsbk(page);
  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {
    
  },

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function () {
    
  },

  /**
   * 生命周期函数--监听页面卸载
   */
  onUnload: function () {
    
  },

  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh: function () {
    wx.showNavigationBarLoading();
    setTimeout(function () {
      wx.hideNavigationBarLoading();
      wx.stopPullDownRefresh();
    }, 1000)
  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {
    var that = this;
    console.log("more========" + page);
    if (that.data.ismore) {
      // wx.showToast({
      //   title: '加载更多...',
      // })
      that.setData({
        yes: true,
        no: false
      })
      page++;
      that.getZsbk(page);
    } else {
      // wx.showToast({
      //   title: app.globalData.nomoretext
      // });
      that.setData({
        yes: false,
        no: true
      })
    }
  },
  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {
    var that = this;
    return {
      title: that.data.title
    }
  },
  // /* 一键拨号*/
  // call: function () {
  //   var that = this;
  //   var tel = that.data.baseinfo.tel;
  //   wx.makePhoneCall({
  //     phoneNumber: tel,
  //     fail: () => {
  //       console.log("调用失败")
  //       wx.showModal({
  //         title: '调用电话失败',
  //         content: '小程序官方正在解决这个问题，请手动拨打电话：' + tel + "，已将号码复制到粘贴板",
  //         success: function (res) {
  //           wx.setClipboardData({
  //             data: tel
  //           })
  //         }
  //       })
  //     }
  //   })
  // },
  /* 一键拨号*/
  call: function (e) {
    var that = this;
    var tel = that.data.baseinfo.tel
    wx.makePhoneCall({
      phoneNumber: tel
    })
  },
})