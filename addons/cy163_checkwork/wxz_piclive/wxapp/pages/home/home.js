//var P = require('../../lib/wxpage')
import data from './data';
import { $wuxGallery } from '../../dist/index'

var app = getApp();

Page({
  data: {
    siteInfo: app.siteInfo,
    pictureSrc: 'http://www.jiaodudesign.com/images/pic-img-004.jpg',
    picInfo: data,
    current: 'tab1',
    tabsindex: 0,
    imgtabindex: 0,
    imgDateShow: true,
    visibleDetails: false,
    visibleQRcode: false,
    scrollClassZ:null,
    scrollClassY: null,
    //canIUse: wx.canIUse('button.open-type.getUserInfo'),
  },
  onLoad: function() {
    var that = this;
    app.util.request({
      url: 'entry/wxapp/index',
      data: {
        m: 'wxz_piclive',
      },
      cachetime: 30,
      success: function (res) {
        if (res.data.errno == 0) {
          typeof cb == "function" && cb(res);
        } else {
          failGo(res.data.message);
        }
      },
      fail: function () {
        failGo('请检查连接地址');
      }
    })
    wx.getSystemInfo({
      success: function(res) {
        that.setData({
          height80: res.windowHeight * 0.8,
          height70: res.windowHeight * 0.7,
          height60: res.windowHeight * 0.6,
          height50: res.windowHeight * 0.5,
          height40: res.windowHeight * 0.4,
          height30: res.windowHeight * 0.3,
          height20: res.windowHeight * 0.2,
          height10: res.windowHeight * 0.1,
          videoHeight: res.windowHeight * 1,
          videoWidth: res.windowWidth * 1,
        })
      }
    });
    // 查看是否授权
    // wx.getSetting({
    //   success: function (res) {
    //     if (res.authSetting['scope.userInfo']) {
    //       wx.getUserInfo({
    //         success: function (res) {
    //           console.log(66666888)
    //           //用户已经授权过
    //         }
    //       })
    //     }
    //   }
    // });
    wx.request({
      url: 'https://hefei.hfwxz.com/app/index.php?i=22&v=1.0.0&from=wxapp&m=wxz_piclive&do=index&wdo=siteInfo&c=entry&a=wxapp&&sign=aa2276fc581e866ec09484c15b71a4da',//上线的话必须是https，没有appId的本地请求貌似不受影响
      data: {},
      method: 'GET', // OPTIONS, GET, HEAD, POST, PUT, DELETE, TRACE, CONNECT
      // header: {}, // 设置请求的 header
      success: function (res) {
        console.log(res);
      },
      fail: function () {
        // fail
      },
      complete: function () {
        // complete
      }
    });
    

  },

  bindGetUserInfo: function (e) {
    console.log(e.detail.userInfo)
    if (e.detail.userInfo) {
      //用户按了允许授权按钮
      console.log('yes');
    } else {
      //用户按了拒绝按钮
      console.log('no');
    }
  },

  //图片倒序
  onImgReverse(){
    const imgBox = this.data.picInfo[0].content;
    for (var i = 0; i < imgBox.length; i++){
      var imgNwe = imgBox[i].childcontent.reverse();
      var imgText = 'picInfo[0].content['+i+'].childcontent';
      this.setData({
        [imgText]:imgNwe
      })
    }
  },

  //日期排列
  showDate() {
    this.setData({
      imgDateShow: !this.data.imgDateShow
    })
  },

  //相册功能
  showGalleryHotImg(e) {
    const imgID = e.currentTarget.id;
    var current = e.currentTarget.dataset.current;
    const index = this.data.tabsindex;
    const liveindex = this.data.imgtabindex;
    const urls = [];
    if (index == 0){
      const hotimg = this.data.picInfo[index].content[liveindex].childcontent;
      for (var k = 0; k < imgID; k++){
        current = current + hotimg[k].imgSrc.length;
      }
      for (var i = 0; i < hotimg.length; i++) {
        for (var j = 0; j < hotimg[i].imgSrc.length; j++){
          urls.push(hotimg[i].imgSrc[j]);
        }
      }
    }else{
      const hotimg = this.data.picInfo[index].content;
      for (var i = 0; i < hotimg.length; i++) {
        urls[i] = hotimg[i].hotImgSrc;
      }
    }
    $wuxGallery().show({
      current,
      urls: urls.map((n) => ({
        image: n,
        remark: n
      })),
      showDelete: false,
      indicatorDots: false,
      indicatorActiveColor: '#04BE02',
    })
  },

  //弹出详情
  openDetails(){
    this.setData({
      visibleDetails: true,
    })
  },
  //关闭详情
  closeDetails() {
    this.setData({
      visibleDetails: false,
    })
  },

  //弹出二维码
  openQRcode() {
    this.setData({
      visibleQRcode: true,
    })
  },
  //关闭二维码
  closeQRcode() {
    this.setData({
      visibleQRcode: false,
    })
  },

  //滚动事件
  scroll(e) {
    var that = this
    var scrolltop = e.detail.scrollTop;
    if (scrolltop > 200){
      that.setData({
        scrollClassZ: 'flexZ',
        scrollClassY: 'flexY',
      })
    }else{
      that.setData({
        scrollClassZ: null,
        scrollClassY: null,
      })
    }
  },

  onTabsChange(e) {
    console.log('onTabsChange', e)
    const {
      key
    } = e.detail
    const tabsindex = this.data.picInfo.map((n) => n.key).indexOf(key)

    this.setData({
      key,
      tabsindex,
    })
    console.log('onTabsChange2', this.data.tabsindex)
  },

  onChangeScrollTab(e) {
    console.log('onChangeScrollTab', e)
    const {
      key
    } = e.detail
    const imgtabindex = this.data.picInfo[0].content.map((n) => n.key).indexOf(key)
    this.setData({
      current: e.detail.key,
      imgtabindex
    })
    console.log('onChangeScrollTab', this.data.imgtabindex)
  },

  

  onReady: function() {
  },
  onPlay: function() {
    this.$route('play?cid=123')
  },
  onPlayNav: function() {
    wx.navigateTo({
      url: '/pages/play?cid=abcd'
    })
  },
  onShow: function() {
    console.log('[pages/home] 页面展示')
  },
  onAwake: function(t) {
    console.log('[pages/home] 程序被唤醒：', t)
  },
  onClickBefore: function(e) {
    console.log('## On click before')
  },
  onClickAfter: function(e) {},
  onTouchend: function(e) {},
  onTTap: function() {},
  callFromComponent: function(name) {
    console.log('!!! call from component:', name)
  }
})