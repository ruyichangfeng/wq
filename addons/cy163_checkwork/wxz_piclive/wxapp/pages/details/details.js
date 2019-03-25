var P = require('../../lib/wxpage')

P('knowledge', {
  data: {},
  onPageLaunch: function () {
  },
  onAppLaunch: function (opts) {
  },
  onLoad: function () {
    var that = this;
   
  },

  routeTo(e){
    var url = e.currentTarget.dataset.url;
    console.log(url);
    this.$route(url);
  },

  onReady: function () {

  },

  onPlay: function () {

  },

  onPlayNav: function () {

  },

  onShow: function () {
    console.log('[pages/knowledge] 页面展示')
  },

  onAwake: function (t) {
    console.log('[pages/knowledge] 程序被唤醒：', t)
  },

  onClickBefore: function (e) {
    console.log('## On click before')
  },

  onClickAfter: function (e) {
  },

  onTouchend: function (e) {
  },

  onTTap: function () {
  }
})
