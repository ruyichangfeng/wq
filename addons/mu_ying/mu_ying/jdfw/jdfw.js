var app = getApp();
var WxParse = require('../wxParse/wxParse.js');
Page({

  /**
   * 页面的初始数据
   */
  data: {
    //页面配置
    //winWidth: 0,
    //winHeight: 0,
    //tab切换
    currentTab: 0,
    
  },
  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {
    this.getBase();
    this.getFwgl();
    this.getZixun();
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
  getFwgl: function () {
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/Fwfl',
      'cachetime': '30',
      success: function (res) {
        console.log(res)
        that.setData({
          fwgl: res.data.data,
        })
        //console.log(res.data.data);
        var list = that.data.fwgl;
        //console.log('list'+list);
        for (var i = 0; i < list.length;i++){
          var fwlist = list[i].fwlist;
          //console.log(""+i+"--"+fwlist[0].text);
          WxParse.wxParse('article[' + i + ']', 'html', fwlist[0].text, that, 5);
        }
        
      },
      fail: function (err) {
        console.log(err)
      },

    })
  },
  getZixun: function () {
    var that = this;
    app.util.request({
      'url': 'entry/wxapp/Zixun',
      'cachetime': '30',
      success: function (res) {
        console.log(res)
        that.setData({
          zixun: res.data.data,
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
  
  // 滑动切换tab
  bindchange: function (e) {
    var that = this;
    that.setData({
      currentTab: e.detail.current
    })
  },
  // 点击切换tab
  swichNav: function (e) {
    var that = this;
    if (this.data.currentTab === e.target.dataset.current) {
      return false;
    } else {
      that.setData({
        currentTab: e.target.dataset.current
      })
    }
  },
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that = this;
    // 获取系统信息
    wx.getSystemInfo({
      success: function (res) {
        that.setData({
          winWidth: res.windowWidth,
          winHeight: res.windowHeight
        })
      }
    })
  },
  // 表单提交
  formSubmit: function (e) {
    if (e.detail.value.name.length == 0 || e.detail.value.tel.length == 0) {
      wx.showModal({
        content: '姓名和电话不能为空',
      })
    } else {

      wx.showModal({
        title: '提示',
        content: ' 确认提交么？ ',
        success: function (res) {
          if (res.confirm) {
            console.log('用户点击确定');
            var that = this;
            var values = e.detail.value;
            app.util.request({
              url: 'entry/wxapp/yuyue',
              data: values,
              header: { 'Content-Type': 'application/json' },
              success: function (res) {
                console.log(res.data)
                if (res.data.code == 1) {
                  wx.showToast({
                    title: '提交失败',
                  })
                } else {
                  wx.showToast({
                    title: '提交成功',
                  })


                }

              },
              fail: function (err) {
                console.log(err);
              }
            })
          } else if (res.cancel) {
            console.log('用户点击取消')
          }
        }
      });

    }

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
    setTimeout(function(){
      wx.hideNavigationBarLoading();
      wx.stopPullDownRefresh();
    },1000)
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