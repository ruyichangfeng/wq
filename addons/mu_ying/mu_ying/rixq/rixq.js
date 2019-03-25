// mu_ying/index/headlinexq/headlinexq.js
var app = getApp();
var WxParse = require('../wxParse/wxParse.js');
Page({

  /**
   * 页面的初始数据
   */
  data: {

  },

  onPullDownRefresh: function () {
    var that = this;
    var id = that.data.id;
    this.getZsbkxq(id);
  },
  onLoad: function (options) {
    var id = options.id
    this.getZsbkxq(id);
  },
  getZsbkxq: function (id) {
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/Zsbkxq',
      'data': {
        id: id,
      },
      'cachetime': '30',
      success: function (res) {
        that.setData({
          detail: res.data.data,
        })
        wx.setNavigationBarTitle({ title: that.data.detail.title })
        WxParse.wxParse('article', 'html', res.data.data.text, that, 5);
      }
    })

  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {
    this.getBase();
    this.getSycd();
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
  // 隐藏或显示导航菜单
  hideNav: function (e) {
    this.setData({
      select: (!this.data.select)
    })
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
  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {

  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {

  }
})