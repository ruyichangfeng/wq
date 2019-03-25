var commonObj = {
	init: function () {
		commonObj.remSize();
	},
	remSize: function () {
		var dpr,scale;
		var docEl = document.documentElement;
		var metaEl = document.querySelector('meta[name="viewport"]');
		dpr = window.devicePixelRatio || 1;
		scale = 1 / dpr;
		// 设置viewport，进行缩放，达到高清效果
		// metaEl.setAttribute('content', 'width=device-width,initial-scale=' + scale + ',maximum-scale=' + scale + ', minimum-scale=' + scale + ',user-scalable=no');
		docEl.style.fontSize=docEl.clientWidth  / 3.75+"px";
		// docEl.setAttribute('dpr',dpr);
	}
};
$(function () {
	commonObj.init();
	$(window).resize(function () {commonObj.remSize();})
});