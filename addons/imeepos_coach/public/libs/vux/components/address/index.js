!function(t,e){"object"==typeof exports&&"object"==typeof module?module.exports=e():"function"==typeof define&&define.amd?define([],e):"object"==typeof exports?exports.vuxAddress=e():t.vuxAddress=e()}(this,function(){return function(t){function e(o){if(n[o])return n[o].exports;var r=n[o]={exports:{},id:o,loaded:!1};return t[o].call(r.exports,r,r.exports,e),r.loaded=!0,r.exports}var n={};return e.m=t,e.c=n,e.p="",e(0)}([function(t,e,n){t.exports=n(80)},function(t,e){var n=Object;t.exports={create:n.create,getProto:n.getPrototypeOf,isEnum:{}.propertyIsEnumerable,getDesc:n.getOwnPropertyDescriptor,setDesc:n.defineProperty,setDescs:n.defineProperties,getKeys:n.keys,getNames:n.getOwnPropertyNames,getSymbols:n.getOwnPropertySymbols,each:[].forEach}},function(t,e){var n=t.exports={version:"1.2.6"};"number"==typeof __e&&(__e=n)},function(t,e){var n=t.exports="undefined"!=typeof window&&window.Math==Math?window:"undefined"!=typeof self&&self.Math==Math?self:Function("return this")();"number"==typeof __g&&(__g=n)},function(t,e){t.exports=function(t){try{return!!t()}catch(e){return!0}}},function(t,e,n){var o=n(54),r=n(9);t.exports=function(t){return o(r(t))}},function(t,e){"use strict";function n(t,e,n){if("function"==typeof Array.prototype.find)return t.find(e,n);n=n||this;var o,r=t.length;if("function"!=typeof e)throw new TypeError(e+" is not a function");for(o=0;r>o;o++)if(e.call(n,t[o],o,t))return t[o]}t.exports=n},function(t,e){t.exports=function(t,e){if(t.map)return t.map(e);for(var o=[],r=0;r<t.length;r++){var i=t[r];n.call(t,r)&&o.push(e(i,r,t))}return o};var n=Object.prototype.hasOwnProperty},function(t,e){var n={}.toString;t.exports=function(t){return n.call(t).slice(8,-1)}},function(t,e){t.exports=function(t){if(void 0==t)throw TypeError("Can't call method on  "+t);return t}},function(t,e,n){t.exports=!n(4)(function(){return 7!=Object.defineProperty({},"a",{get:function(){return 7}}).a})},function(t,e,n){var o=n(3),r=n(2),i=n(50),a="prototype",s=function(t,e,n){var u,l,c,p=t&s.F,f=t&s.G,_=t&s.S,d=t&s.P,h=t&s.B,v=t&s.W,m=f?r:r[e]||(r[e]={}),g=f?o:_?o[e]:(o[e]||{})[a];f&&(n=e);for(u in n)l=!p&&g&&u in g,l&&u in m||(c=l?g[u]:n[u],m[u]=f&&"function"!=typeof g[u]?n[u]:h&&l?i(c,o):v&&g[u]==c?function(t){var e=function(e){return this instanceof t?new t(e):t(e)};return e[a]=t[a],e}(c):d&&"function"==typeof c?i(Function.call,c):c,d&&((m[a]||(m[a]={}))[u]=c))};s.F=1,s.G=2,s.S=4,s.P=8,s.B=16,s.W=32,t.exports=s},function(t,e){var n={}.hasOwnProperty;t.exports=function(t,e){return n.call(t,e)}},function(t,e){t.exports=function(t,e){return{enumerable:!(1&t),configurable:!(2&t),writable:!(4&t),value:e}}},function(t,e,n){var o=n(3),r="__core-js_shared__",i=o[r]||(o[r]={});t.exports=function(t){return i[t]||(i[t]={})}},function(t,e){var n=0,o=Math.random();t.exports=function(t){return"Symbol(".concat(void 0===t?"":t,")_",(++n+o).toString(36))}},function(t,e,n){var o=n(14)("wks"),r=n(15),i=n(3).Symbol;t.exports=function(t){return o[t]||(o[t]=i&&i[t]||(i||r)("Symbol."+t))}},function(t,e,n){var o,r;o=n(22),r=n(74),t.exports=o||{},t.exports.__esModule&&(t.exports=t.exports["default"]),r&&(("function"==typeof t.exports?t.exports.options||(t.exports.options={}):t.exports).template=r)},function(t,e,n){var o,r;n(67),o=n(23),r=n(75),t.exports=o||{},t.exports.__esModule&&(t.exports=t.exports["default"]),r&&(("function"==typeof t.exports?t.exports.options||(t.exports.options={}):t.exports).template=r)},function(t,e){t.exports=function(t,e,o){if(t.filter)return t.filter(e,o);if(void 0===t||null===t)throw new TypeError;if("function"!=typeof e)throw new TypeError;for(var r=[],i=0;i<t.length;i++)if(n.call(t,i)){var a=t[i];e.call(o,a,i,t)&&r.push(a)}return r};var n=Object.prototype.hasOwnProperty},function(t,e,n){"use strict";function o(t){return t&&t.__esModule?t:{"default":t}}Object.defineProperty(e,"__esModule",{value:!0});var r=n(34),i=o(r),a=n(84),s=o(a);e["default"]={components:{PopupPicker:s["default"]},props:{title:{type:String,required:!0},value:{type:Array,twoWay:!0,"default":function(){return[]}},rawValue:{type:Boolean,"default":!1},list:{type:Array,required:!0},inlineDesc:String},beforeCompile:function(){this.value.length&&this.rawValue&&(this.value=(0,i["default"])(this.value,this.list).split(" "))}}},function(t,e,n){"use strict";function o(t){return t&&t.__esModule?t:{"default":t}}Object.defineProperty(e,"__esModule",{value:!0});var r=n(82),i=o(r),a=n(38);e["default"]={components:{InlineDesc:i["default"]},props:{title:String,value:String,isLink:Boolean,inlineDesc:String,primary:{type:String,"default":"title"},link:{type:[String,Object]}},methods:{onClick:function(){(0,a.go)(this.link,this.$router)}}}},function(t,e){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var n=["-moz-box-","-webkit-box-",""];e["default"]={props:{span:{type:[Number,String]}},methods:{buildWidth:function(t){return"number"==typeof t?1>t?t:t/12:"string"==typeof t?t.replace("px","")/this.bodyWidth:void 0}},computed:{style:function(){var t={},e="horizontal"===this.$parent.orient?"marginLeft":"marginTop";if(t[e]=this.$parent.gutter+"px",this.span)for(var o=0;o<n.length;o++)t[n[o]+"flex"]="0 0 "+100*this.buildWidth(this.span)+"%";return t}},data:function(){return{bodyWidth:document.documentElement.offsetWidth}}}},function(t,e){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e["default"]={props:{gutter:{type:Number,"default":8},orient:{type:String,"default":"horizontal"}}}},function(t,e,n){"use strict";function o(t){return t&&t.__esModule?t:{"default":t}}Object.defineProperty(e,"__esModule",{value:!0});var r=n(29),i=o(r),a=n(18),s=o(a),u=n(17),l=o(u),c=n(28),p=o(c);e["default"]={components:{Flexbox:s["default"],FlexboxItem:l["default"]},created:function(){if(0!==this.columns){var t=this.columns;this.store=new p["default"](this.data,t),this.data=this.store.getColumns(this.value)}},ready:function(){var t=this;this.$nextTick(function(){t.render(t.data,t.value)})},props:{data:{type:Array},columns:{type:Number,"default":0},value:{type:Array,twoWay:!0},itemClass:{type:String,"default":"scroller-item"}},methods:{getId:function(t){return"#vux-picker-"+this.uuid+"-"+t},render:function(t,e){this.count=this.data.length;var n=this;if(t&&t.length){var o=this.data.length;if(e.length<o)for(var r=0;o>r;r++)n.value.$set(r,t[r][0].value||t[r][0]);for(var a=function(o){n.scroller[o]&&n.scroller[o].destroy(),n.scroller[o]=new i["default"](n.getId(o),{data:t[o],defaultValue:e[o]||t[o][0].value,itemClass:n.item_class,onSelect:function(t){n.value.$set(o,t),n.$emit("on-change",n.getValue()),0!==n.columns&&n.renderChain(o+1)}}),n.value&&n.scroller[o].select(e[o])},s=0;s<t.length;s++)a(s)}},renderChain:function(t){if(0!==this.columns&&!(t>this.count-1)){var e=this,n=this.getId(t);this.scroller[t].destroy();var o=this.store.getChildren(e.getValue()[t-1]);this.scroller[t]=new i["default"](n,{data:o,itemClass:e.item_class,onSelect:function(n){e.value.$set(t,n),e.$emit("on-change",e.getValue()),e.renderChain(t+1)}}),this.value.$set(t,o[0].value),this.renderChain(t+1)}},getValue:function(){for(var t=[],e=0;e<this.data.length;e++)t.push(this.scroller[e].value);return t}},data:function(){return{scroller:[],count:0,uuid:Math.random().toString(36).substring(3,8)}},watch:{value:function(t,e){if(0!==this.columns)t!==e&&(this.data=this.store.getColumns(t),this.$nextTick(function(){this.render(this.data,t)}));else for(var n=0;n<t.length;n++)this.scroller[n].value!==t[n]&&this.scroller[n].select(t[n])},data:function(t){var e=this;if("[object Array]"===Object.prototype.toString.call(t[0]))this.$nextTick(function(){e.render(t,e.value),e.$nextTick(function(){e.$emit("on-change",e.getValue())})});else if(0!==this.columns){var n=this.columns;this.store=new p["default"](t,n),this.data=this.store.getColumns(this.value)}}},beforeDestroy:function(){for(var t=0;t<this.count;t++)this.scroller[t].destroy(),this.scroller[t]=null}}},function(t,e,n){"use strict";function o(t){return t&&t.__esModule?t:{"default":t}}Object.defineProperty(e,"__esModule",{value:!0});var r=n(83),i=o(r),a=n(81),s=o(a),u=n(85),l=o(u),c=n(18),p=o(c),f=n(17),_=o(f),d=n(33),h=o(d),v=n(35),m=o(v),g=n(37),y=o(g);e["default"]={mixins:[y["default"]],components:{Picker:i["default"],Cell:s["default"],Popup:l["default"],Flexbox:p["default"],FlexboxItem:_["default"]},filters:{array2string:h["default"],value2name:m["default"]},props:{title:String,data:{type:Array,"default":function(){return[]}},columns:{type:Number,"default":0},value:{type:Array,"default":function(){return[]},twoWay:!0},showName:{type:Boolean,"default":!1},inlineDesc:String},methods:{onClick:function(){this.show=!0},onHide:function(t){this.show=!1}},data:function(){return{show:!1}}}},function(t,e,n){"use strict";function o(t){return t&&t.__esModule?t:{"default":t}}Object.defineProperty(e,"__esModule",{value:!0});var r=n(31),i=o(r);e["default"]={props:{show:{type:Boolean,"default":!1,twoWay:!0},height:{type:String,"default":"auto"}},ready:function(){var t=this;this.popup=new i["default"]({container:t.$el,innerHTML:"",onOpen:function(e){t.show=!0},onClose:function(e){t.show=!1}})},data:function(){return{hasFirstShow:!1}},watch:{show:function(t){t?(this.popup.show(),this.hasFirstShow||(this.$emit("on-first-show"),this.hasFirstShow=!0)):this.popup.hide()}},beforeDestroy:function(){this.popup.destroy()}}},function(t,e){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var n=Date.now||function(){return+new Date},o={},r=1,i=60,a=1e3;e["default"]={requestAnimationFrame:function(){var t=window.requestAnimationFrame||window.webkitRequestAnimationFrame;return function(e,n){t(e,n)}}(),stop:function(t){var e=null!=o[t];return e&&(o[t]=null),e},isRunning:function(t){return null!=o[t]},start:function s(t,e,u,l,c,p){var f=this,s=n(),_=s,d=0,h=0,v=r++;if(p||(p=document.body),v%20===0){var m={};for(var g in o)m[g]=!0;o=m}var y=function x(r){var m=r!==!0,g=n();if(!o[v]||e&&!e(v))return o[v]=null,void(u&&u(i-h/((g-s)/a),v,!1));if(m)for(var y=Math.round((g-_)/(a/i))-1,b=0;b<Math.min(y,4);b++)x(!0),h++;l&&(d=(g-s)/l,d>1&&(d=1));var w=c?c(d):d;t(w,g,m)!==!1&&1!==d||!m?m&&(_=g,f.requestAnimationFrame(x,p)):(o[v]=null,u&&u(i-h/((g-s)/a),v,1===d||null==l))};return o[v]=!0,f.requestAnimationFrame(y,p),v}}},function(t,e,n){"use strict";function o(t){return t&&t.__esModule?t:{"default":t}}Object.defineProperty(e,"__esModule",{value:!0});var r=n(42),i=o(r),a=n(43),s=o(a),u=n(19),l=o(u),c=function(){function t(e,n){(0,i["default"])(this,t),this.data=e,this.count=n}return(0,s["default"])(t,[{key:"getChildren",value:function(t){return(0,l["default"])(this.data,function(e){return e.parent===t})}},{key:"getFirstColumn",value:function(){return(0,l["default"])(this.data,function(t){return!t.parent||0===t.parent})}},{key:"getColumns",value:function(t){for(var e=[],n=0;n<this.count;n++)if(0===n)e.push(this.getFirstColumn());else if(t[n])e.push(this.getChildren(t[n-1]));else{var o=e[n-1][0].value;e.push(this.getChildren(o))}return e}}]),t}();e["default"]=c},function(t,e,n){"use strict";function o(t){return t&&t.__esModule?t:{"default":t}}var r=n(27),i=o(r),a=n(30),s='\n<div class="scroller-component" data-role="component">\n  <div class="scroller-mask" data-role="mask"></div>\n  <div class="scroller-indicator" data-role="indicator"></div>\n  <div class="scroller-content" data-role="content"></div>\n</div>\n',u=function(t,e){var n=this;e=e||{},n.options={itemClass:"scroller-item",onSelect:function(){},defaultValue:0,data:[]};for(var o in e)void 0!==e[o]&&(n.options[o]=e[o]);n.__container=(0,a.getElement)(t);var r=document.createElement("div");r.innerHTML=e.template||s;var i=n.__component=r.querySelector("[data-role=component]"),u=n.__content=i.querySelector("[data-role=content]"),l=i.querySelector("[data-role=indicator]"),c=n.options.data,p="";c.length&&c[0].constructor===Object?c.forEach(function(t){p+='<div class="'+n.options.itemClass+'" data-value="'+t.value+'">'+t.name+"</div>"}):c.forEach(function(t){p+='<div class="'+n.options.itemClass+'" data-value="'+t+'">'+t+"</div>"}),u.innerHTML=p,n.__container.appendChild(i),n.__itemHeight=parseInt((0,a.getComputedStyle)(l,"height"),10),n.__callback=e.callback||function(t){u.style.webkitTransform="translate3d(0, "+-t+"px, 0)"};var f=i.getBoundingClientRect();n.__clientTop=f.top+i.clientTop||0,n.__setDimensions(i.clientHeight,u.offsetHeight),0===i.clientHeight&&n.__setDimensions(parseInt((0,a.getComputedStyle)(i,"height"),10),204),n.select(n.options.defaultValue,!1),i.addEventListener("touchstart",function(t){t.target.tagName.match(/input|textarea|select/i)||(t.preventDefault(),n.__doTouchStart(t.touches,t.timeStamp))},!1),i.addEventListener("touchmove",function(t){n.__doTouchMove(t.touches,t.timeStamp)},!1),i.addEventListener("touchend",function(t){n.__doTouchEnd(t.timeStamp)},!1)},l={value:null,__prevValue:null,__isSingleTouch:!1,__isTracking:!1,__didDecelerationComplete:!1,__isGesturing:!1,__isDragging:!1,__isDecelerating:!1,__isAnimating:!1,__clientTop:0,__clientHeight:0,__contentHeight:0,__itemHeight:0,__scrollTop:0,__minScrollTop:0,__maxScrollTop:0,__scheduledTop:0,__lastTouchTop:null,__lastTouchMove:null,__positions:null,__minDecelerationScrollTop:null,__maxDecelerationScrollTop:null,__decelerationVelocityY:null,__setDimensions:function(t,e){var n=this;n.__clientHeight=t,n.__contentHeight=e;var o=n.options.data.length,r=Math.round(n.__clientHeight/n.__itemHeight);n.__minScrollTop=-n.__itemHeight*(r/2),n.__maxScrollTop=n.__minScrollTop+o*n.__itemHeight-.1},selectByIndex:function(t,e){var n=this;0>t||t>n.__content.childElementCount-1||(n.__scrollTop=n.__minScrollTop+t*n.__itemHeight,n.scrollTo(n.__scrollTop,e),n.__selectItem(n.__content.children[t]))},select:function(t,e){for(var n=this,o=n.__content.children,r=0,i=o.length;i>r;r++)if(o[r].dataset.value===t)return void n.selectByIndex(r,e);n.selectByIndex(0,e)},getValue:function(){return this.value},scrollTo:function(t,e){var n=this;return e=void 0===e?!0:e,n.__isDecelerating&&(i["default"].stop(n.__isDecelerating),n.__isDecelerating=!1),t=Math.round(t/n.__itemHeight)*n.__itemHeight,t=Math.max(Math.min(n.__maxScrollTop,t),n.__minScrollTop),t!==n.__scrollTop&&e?void n.__publish(t,250):(n.__publish(t),void n.__scrollingComplete())},destroy:function(){this.__component.parentNode&&this.__component.parentNode.removeChild(this.__component)},__selectItem:function(t){var e=this,n=e.options.itemClass+"-selected",o=e.__content.querySelector("."+n);o&&o.classList.remove(n),t.classList.add(n),null!==e.value&&(e.__prevValue=e.value),e.value=t.dataset.value},__scrollingComplete:function(){var t=this,e=Math.round((t.__scrollTop-t.__minScrollTop-t.__itemHeight/2)/t.__itemHeight);t.__selectItem(t.__content.children[e]),null!==t.__prevValue&&t.__prevValue!==t.value&&t.options.onSelect(t.value)},__doTouchStart:function(t,e){var n=this;if(null==t.length)throw new Error("Invalid touch list: "+t);if(e instanceof Date&&(e=e.valueOf()),"number"!=typeof e)throw new Error("Invalid timestamp value: "+e);n.__interruptedAnimation=!0,n.__isDecelerating&&(i["default"].stop(n.__isDecelerating),n.__isDecelerating=!1,n.__interruptedAnimation=!0),n.__isAnimating&&(i["default"].stop(n.__isAnimating),n.__isAnimating=!1,n.__interruptedAnimation=!0);var o,r=1===t.length;o=r?t[0].pageY:Math.abs(t[0].pageY+t[1].pageY)/2,n.__initialTouchTop=o,n.__lastTouchTop=o,n.__lastTouchMove=e,n.__lastScale=1,n.__enableScrollY=!r,n.__isTracking=!0,n.__didDecelerationComplete=!1,n.__isDragging=!r,n.__isSingleTouch=r,n.__positions=[]},__doTouchMove:function(t,e,n){var o=this;if(null==t.length)throw new Error("Invalid touch list: "+t);if(e instanceof Date&&(e=e.valueOf()),"number"!=typeof e)throw new Error("Invalid timestamp value: "+e);if(o.__isTracking){var r;r=2===t.length?Math.abs(t[0].pageY+t[1].pageY)/2:t[0].pageY;var i=o.__positions;if(o.__isDragging){var a=r-o.__lastTouchTop,s=o.__scrollTop;if(o.__enableScrollY){s-=a;var u=o.__minScrollTop,l=o.__maxScrollTop;(s>l||u>s)&&(s=s>l?l:u)}i.length>40&&i.splice(0,20),i.push(s,e),o.__publish(s)}else{var c=0,p=5,f=Math.abs(r-o.__initialTouchTop);o.__enableScrollY=f>=c,i.push(o.__scrollTop,e),o.__isDragging=o.__enableScrollY&&f>=p,o.__isDragging&&(o.__interruptedAnimation=!1)}o.__lastTouchTop=r,o.__lastTouchMove=e,o.__lastScale=n}},__doTouchEnd:function(t){var e=this;if(t instanceof Date&&(t=t.valueOf()),"number"!=typeof t)throw new Error("Invalid timestamp value: "+t);if(e.__isTracking){if(e.__isTracking=!1,e.__isDragging&&(e.__isDragging=!1,e.__isSingleTouch&&t-e.__lastTouchMove<=100)){for(var n=e.__positions,o=n.length-1,r=o,i=o;i>0&&n[i]>e.__lastTouchMove-100;i-=2)r=i;if(r!==o){var a=n[o]-n[r],s=e.__scrollTop-n[r-1];e.__decelerationVelocityY=s/a*(1e3/60);var u=4;Math.abs(e.__decelerationVelocityY)>u&&e.__startDeceleration(t)}}e.__isDecelerating||e.scrollTo(e.__scrollTop),e.__positions.length=0}},__publish:function(t,e){var n=this,o=n.__isAnimating;if(o&&(i["default"].stop(o),n.__isAnimating=!1),e){n.__scheduledTop=t;var r=n.__scrollTop,s=t-r,u=function(t,e,o){n.__scrollTop=r+s*t,n.__callback&&n.__callback(n.__scrollTop)},l=function(t){return n.__isAnimating===t},c=function(t,e,o){e===n.__isAnimating&&(n.__isAnimating=!1),(n.__didDecelerationComplete||o)&&n.__scrollingComplete()};n.__isAnimating=i["default"].start(u,l,c,e,o?a.easeOutCubic:a.easeInOutCubic)}else n.__scheduledTop=n.__scrollTop=t,n.__callback&&n.__callback(t)},__startDeceleration:function(t){var e=this;e.__minDecelerationScrollTop=e.__minScrollTop,e.__maxDecelerationScrollTop=e.__maxScrollTop;var n=function(t,n,o){e.__stepThroughDeceleration(o)},o=.5,r=function(){var t=Math.abs(e.__decelerationVelocityY)>=o;return t||(e.__didDecelerationComplete=!0),t},a=function(t,n,o){return e.__isDecelerating=!1,e.__scrollTop<=e.__minScrollTop||e.__scrollTop>=e.__maxScrollTop?void e.scrollTo(e.__scrollTop):void(e.__didDecelerationComplete&&e.__scrollingComplete())};e.__isDecelerating=i["default"].start(n,r,a)},__stepThroughDeceleration:function(t){var e=this,n=e.__scrollTop+e.__decelerationVelocityY,o=Math.max(Math.min(e.__maxDecelerationScrollTop,n),e.__minDecelerationScrollTop);o!==n&&(n=o,e.__decelerationVelocityY=0),Math.abs(e.__decelerationVelocityY)<=1?Math.abs(n%e.__itemHeight)<1&&(e.__decelerationVelocityY=0):e.__decelerationVelocityY*=.95,e.__publish(n)}};for(var c in l)u.prototype[c]=l[c];t.exports=u},function(t,e){"use strict";function n(t){return"string"==typeof t?document.querySelector(t):t}function o(t,e){var n=window.getComputedStyle(t);return n[e]||""}function r(t){return Math.pow(t-1,3)+1}function i(t){return(t/=.5)<1?.5*Math.pow(t,3):.5*(Math.pow(t-2,3)+2)}Object.defineProperty(e,"__esModule",{value:!0}),e.getElement=n,e.getComputedStyle=o,e.easeOutCubic=r,e.easeInOutCubic=i},function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var o=n(36),r=n(32),i=function(t){this.params={},"[object Object]"===Object.prototype.toString.call(t)&&(this.params={input:t.input||"",container:document.querySelector(t.input)||"",innerHTML:t.innerHTML||"",onOpen:t.onOpen||function(){},onClose:t.onClose||function(){},_open:t._open||function(){},_close:t._close||function(){}}),!!document.querySelectorAll(".picker-mask").length<=0&&(this.divMask=document.createElement("a"),this.divMask.className="picker-mask",this.divMask.href="javascript:void(0)",document.body.appendChild(this.divMask));var e;return e=t.container?t.container:document.createElement("div"),e.className="picker-dialog",t.container||document.body.appendChild(e),this.mask=document.querySelector(".picker-mask"),this.container=document.querySelectorAll(".picker-dialog"),this.container=this.container[this.container.length-1],this._bindEvents(),t=null,this};o.mixTo(i),i.prototype.updateInputPosition=function(){this._hackInputFocus()},i.prototype._bindEvents=function(){function t(t){e.hide(),e.emit("close")}var e=this;return r.tap(this.mask,t),this},i.prototype.show=function(){var t=this;return t.mask.classList.add("show"),t.container.classList.add("show"),t.params._open&&t.params._open(this),t.params.onOpen&&t.params.onOpen(this),this},i.prototype.hide=function(){var t=this;return t.container.classList.remove("show"),document.querySelector(".picker-dialog.show")||t.mask.classList.remove("show"),t.params._close&&t.params._close(this),t.params.onClose&&t.params.onClose(this),this},i.prototype.html=function(t){return this.container.innerHTML=t,this},i.prototype.destroy=function(){this.mask&&this.mask.parentNode&&this.mask.parentNode.removeChild(this.mask)},e["default"]=i},function(t,e){"use strict";var n={tap:function(t,e){return t?(t.__tap={},t.__tap.event={start:function(e){e.stopPropagation(),t.__tap.clickabled=!0,t.__tap.starttime=e.timeStamp,t.__tap.startPageX=e.changedTouches[0].pageX,t.__tap.startPageY=e.changedTouches[0].pageY},move:function(e){(Math.abs(e.changedTouches[0].pageX-t.__tap.startPageX)>=5||Math.abs(e.changedTouches[0].pageY-t.__tap.startPageY)>=5)&&(t.__tap.clickabled=!1)},end:function(n){n.stopPropagation(),n.preventDefault(),n.timeStamp-t.__tap.starttime>30&&n.timeStamp-t.__tap.starttime<300&&t.__tap.clickabled&&e&&e(n)},click:function(t){t.stopPropagation(),e&&e(t)}},/AppleWebKit.*Mobile.*/.test(navigator.userAgent.match())?(t.addEventListener("touchstart",t.__tap.event.start,!1),t.addEventListener("touchmove",t.__tap.event.move,!1),t.addEventListener("touchend",t.__tap.event.end,!1)):t.addEventListener("click",t.__tap.event.click,!1),t):console.error("tap对象不能为空")},untap:function(t){return t?(t.__tap=t.__tap||{},/AppleWebKit.*Mobile.*/.test(navigator.userAgent.match())&&t.__tap.event?(t.__tap.event.start&&t.removeEventListener("touchstart",t.__tap.event.start,!1),t.__tap.event.move&&t.removeEventListener("touchmove",t.__tap.event.move,!1),t.__tap.event.end&&t.removeEventListener("touchend",t.__tap.event.end,!1)):t.__tap.event&&t.__tap.event.click&&t.removeEventListener("click",t.__tap.event.click,!1),t):console.error("untap对象不能为空")}};t.exports=n},function(t,e){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e["default"]=function(t){return 1===t.length?t[0]:t.join(" ")}},function(t,e,n){"use strict";function o(t){return t&&t.__esModule?t:{"default":t}}Object.defineProperty(e,"__esModule",{value:!0}),e["default"]=function(t,e){var n=(0,i["default"])(t,function(n,o){var r="";return 2===o?(r=(0,s["default"])(e,function(e){return e.name===t[1]}),(0,s["default"])(e,function(t){return t.name===n&&t.parent===r.value})):(0,s["default"])(e,function(t){return t.name===n})});return(0,i["default"])(n,function(t){return t.value}).join(" ")};var r=n(7),i=o(r),a=n(6),s=o(a)},function(t,e,n){"use strict";function o(t){return t&&t.__esModule?t:{"default":t}}Object.defineProperty(e,"__esModule",{value:!0}),e["default"]=function(t,e){var n=(0,i["default"])(t,function(t,n){return(0,s["default"])(e,function(e){return e.value===t})});return(0,i["default"])(n,function(t){return t.name}).join(" ").replace("--","")};var r=n(7),i=o(r),a=n(6),s=o(a)},function(t,e,n){"use strict";function o(t){return t&&t.__esModule?t:{"default":t}}function r(){}function i(t,e,n){var o=!0;if(t){var r=0,i=t.length,a=e[0],s=e[1],u=e[2];switch(e.length){case 0:for(;i>r;r+=2)o=t[r].call(t[r+1]||n)!==!1&&o;break;case 1:for(;i>r;r+=2)o=t[r].call(t[r+1]||n,a)!==!1&&o;break;case 2:for(;i>r;r+=2)o=t[r].call(t[r+1]||n,a,s)!==!1&&o;break;case 3:for(;i>r;r+=2)o=t[r].call(t[r+1]||n,a,s,u)!==!1&&o;break;default:for(;i>r;r+=2)o=t[r].apply(t[r+1]||n,e)!==!1&&o}}return o}function a(t){return"[object Function]"===Object.prototype.toString.call(t)}var s=n(40),u=o(s),l=/\s+/;r.prototype.on=function(t,e,n){var o,r,i;if(!e)return this;for(o=this.__events||(this.__events={}),t=t.split(l);r=t.shift();)i=o[r]||(o[r]=[]),i.push(e,n);return this},r.prototype.once=function(t,e,n){var o=this,r=function i(){o.off(t,i),e.apply(n||o,arguments)};return this.on(t,r,n)},r.prototype.off=function(t,e,n){var o,r,i,a;if(!(o=this.__events))return this;if(!(t||e||n))return delete this.__events,this;for(t=t?t.split(l):c(o);r=t.shift();)if(i=o[r])if(e||n)for(a=i.length-2;a>=0;a-=2)e&&i[a]!==e||n&&i[a+1]!==n||i.splice(a,2);else delete o[r];return this},r.prototype.trigger=function(t){var e,n,o,r,a,s,u=[],c=!0;if(!(e=this.__events))return this;for(t=t.split(l),a=1,s=arguments.length;s>a;a++)u[a-1]=arguments[a];for(;n=t.shift();)(o=e.all)&&(o=o.slice()),(r=e[n])&&(r=r.slice()),"all"!==n&&(c=i(r,u,this)&&c),c=i(o,[n].concat(u),this)&&c;return c},r.prototype.emit=r.prototype.trigger;var c=u["default"];c||(c=function(t){var e=[];for(var n in t)t.hasOwnProperty(n)&&e.push(n);return e}),r.mixTo=function(t){function e(e){t[e]=function(){return n[e].apply(i,Array.prototype.slice.call(arguments)),this}}var n=r.prototype;if(a(t))for(var o in n)n.hasOwnProperty(o)&&(t.prototype[o]=n[o]);else{var i=new r;for(var s in n)n.hasOwnProperty(s)&&e(s)}},t.exports=r},function(t,e){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e["default"]={created:function(){this.uuid=Math.random().toString(36).substring(3,8)}}},function(t,e,n){"use strict";function o(t){return t&&t.__esModule?t:{"default":t}}function r(t,e){if(!/^javas/.test(t)&&t){var n="object"===("undefined"==typeof t?"undefined":(0,s["default"])(t))||"string"==typeof t&&!/http/.test(t);n?e.go(t):window.location.href=t}}function i(t,e){return!e||e._history||"string"!=typeof t||/http/.test(t)?t&&"object"!==("undefined"==typeof t?"undefined":(0,s["default"])(t))?t:"javascript:void(0);":"#!"+t}Object.defineProperty(e,"__esModule",{value:!0});var a=n(44),s=o(a);e.go=r,e.getUrl=i},function(t,e,n){t.exports={"default":n(45),__esModule:!0}},function(t,e,n){t.exports={"default":n(46),__esModule:!0}},function(t,e,n){t.exports={"default":n(47),__esModule:!0}},function(t,e){"use strict";e.__esModule=!0,e["default"]=function(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}},function(t,e,n){"use strict";function o(t){return t&&t.__esModule?t:{"default":t}}e.__esModule=!0;var r=n(39),i=o(r);e["default"]=function(){function t(t,e){for(var n=0;n<e.length;n++){var o=e[n];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),(0,i["default"])(t,o.key,o)}}return function(e,n,o){return n&&t(e.prototype,n),o&&t(e,o),e}}()},function(t,e,n){"use strict";var o=n(41)["default"];e["default"]=function(t){return t&&t.constructor===o?"symbol":typeof t},e.__esModule=!0},function(t,e,n){var o=n(1);t.exports=function(t,e,n){return o.setDesc(t,e,n)}},function(t,e,n){n(63),t.exports=n(2).Object.keys},function(t,e,n){n(65),n(64),t.exports=n(2).Symbol},function(t,e){t.exports=function(t){if("function"!=typeof t)throw TypeError(t+" is not a function!");return t}},function(t,e,n){var o=n(56);t.exports=function(t){if(!o(t))throw TypeError(t+" is not an object!");return t}},function(t,e,n){var o=n(48);t.exports=function(t,e,n){if(o(t),void 0===e)return t;switch(n){case 1:return function(n){return t.call(e,n)};case 2:return function(n,o){return t.call(e,n,o)};case 3:return function(n,o,r){return t.call(e,n,o,r)}}return function(){return t.apply(e,arguments)}}},function(t,e,n){var o=n(1);t.exports=function(t){var e=o.getKeys(t),n=o.getSymbols;if(n)for(var r,i=n(t),a=o.isEnum,s=0;i.length>s;)a.call(t,r=i[s++])&&e.push(r);return e}},function(t,e,n){var o=n(5),r=n(1).getNames,i={}.toString,a="object"==typeof window&&Object.getOwnPropertyNames?Object.getOwnPropertyNames(window):[],s=function(t){try{return r(t)}catch(e){return a.slice()}};t.exports.get=function(t){return a&&"[object Window]"==i.call(t)?s(t):r(o(t))}},function(t,e,n){var o=n(1),r=n(13);t.exports=n(10)?function(t,e,n){return o.setDesc(t,e,r(1,n))}:function(t,e,n){return t[e]=n,t}},function(t,e,n){var o=n(8);t.exports=Object("z").propertyIsEnumerable(0)?Object:function(t){return"String"==o(t)?t.split(""):Object(t)}},function(t,e,n){var o=n(8);t.exports=Array.isArray||function(t){return"Array"==o(t)}},function(t,e){t.exports=function(t){return"object"==typeof t?null!==t:"function"==typeof t}},function(t,e,n){var o=n(1),r=n(5);t.exports=function(t,e){for(var n,i=r(t),a=o.getKeys(i),s=a.length,u=0;s>u;)if(i[n=a[u++]]===e)return n}},function(t,e){t.exports=!0},function(t,e,n){var o=n(11),r=n(2),i=n(4);t.exports=function(t,e){var n=(r.Object||{})[t]||Object[t],a={};a[t]=e(n),o(o.S+o.F*i(function(){n(1)}),"Object",a)}},function(t,e,n){t.exports=n(53)},function(t,e,n){var o=n(1).setDesc,r=n(12),i=n(16)("toStringTag");t.exports=function(t,e,n){t&&!r(t=n?t:t.prototype,i)&&o(t,i,{configurable:!0,value:e})}},function(t,e,n){var o=n(9);t.exports=function(t){return Object(o(t))}},function(t,e,n){var o=n(62);n(59)("keys",function(t){return function(e){return t(o(e))}})},function(t,e){},function(t,e,n){"use strict";var o=n(1),r=n(3),i=n(12),a=n(10),s=n(11),u=n(60),l=n(4),c=n(14),p=n(61),f=n(15),_=n(16),d=n(57),h=n(52),v=n(51),m=n(55),g=n(49),y=n(5),x=n(13),b=o.getDesc,w=o.setDesc,S=o.create,T=h.get,k=r.Symbol,M=r.JSON,O=M&&M.stringify,D=!1,C=_("_hidden"),j=o.isEnum,P=c("symbol-registry"),E=c("symbols"),A="function"==typeof k,H=Object.prototype,I=a&&l(function(){return 7!=S(w({},"a",{get:function(){return w(this,"a",{value:7}).a}})).a})?function(t,e,n){var o=b(H,e);o&&delete H[e],w(t,e,n),o&&t!==H&&w(H,e,o)}:w,L=function(t){var e=E[t]=S(k.prototype);return e._k=t,a&&D&&I(H,t,{configurable:!0,set:function(e){i(this,C)&&i(this[C],t)&&(this[C][t]=!1),I(this,t,x(1,e))}}),e},F=function(t){return"symbol"==typeof t},N=function(t,e,n){return n&&i(E,e)?(n.enumerable?(i(t,C)&&t[C][e]&&(t[C][e]=!1),n=S(n,{enumerable:x(0,!1)})):(i(t,C)||w(t,C,x(1,{})),t[C][e]=!0),I(t,e,n)):w(t,e,n)},V=function(t,e){g(t);for(var n,o=v(e=y(e)),r=0,i=o.length;i>r;)N(t,n=o[r++],e[n]);return t},Y=function(t,e){return void 0===e?S(t):V(S(t),e)},q=function(t){var e=j.call(this,t);return e||!i(this,t)||!i(E,t)||i(this,C)&&this[C][t]?e:!0},$=function(t,e){var n=b(t=y(t),e);return!n||!i(E,e)||i(t,C)&&t[C][e]||(n.enumerable=!0),n},W=function(t){for(var e,n=T(y(t)),o=[],r=0;n.length>r;)i(E,e=n[r++])||e==C||o.push(e);return o},B=function(t){for(var e,n=T(y(t)),o=[],r=0;n.length>r;)i(E,e=n[r++])&&o.push(E[e]);return o},z=function(t){if(void 0!==t&&!F(t)){for(var e,n,o=[t],r=1,i=arguments;i.length>r;)o.push(i[r++]);return e=o[1],"function"==typeof e&&(n=e),!n&&m(e)||(e=function(t,e){return n&&(e=n.call(this,t,e)),F(e)?void 0:e}),o[1]=e,O.apply(M,o)}},K=l(function(){var t=k();return"[null]"!=O([t])||"{}"!=O({a:t})||"{}"!=O(Object(t))});A||(k=function(){if(F(this))throw TypeError("Symbol is not a constructor");return L(f(arguments.length>0?arguments[0]:void 0))},u(k.prototype,"toString",function(){return this._k}),F=function(t){return t instanceof k},o.create=Y,o.isEnum=q,o.getDesc=$,o.setDesc=N,o.setDescs=V,o.getNames=h.get=W,o.getSymbols=B,a&&!n(58)&&u(H,"propertyIsEnumerable",q,!0));var G={"for":function(t){return i(P,t+="")?P[t]:P[t]=k(t)},keyFor:function(t){return d(P,t)},useSetter:function(){D=!0},useSimple:function(){D=!1}};o.each.call("hasInstance,isConcatSpreadable,iterator,match,replace,search,species,split,toPrimitive,toStringTag,unscopables".split(","),function(t){var e=_(t);G[t]=A?e:L(e)}),D=!0,s(s.G+s.W,{Symbol:k}),s(s.S,"Symbol",G),s(s.S+s.F*!A,"Object",{create:Y,defineProperty:N,defineProperties:V,getOwnPropertyDescriptor:$,getOwnPropertyNames:W,getOwnPropertySymbols:B}),M&&s(s.S+s.F*(!A||K),"JSON",{stringify:z}),p(k,"Symbol"),p(Math,"Math",!0),p(r.JSON,"JSON",!0)},function(t,e){},function(t,e){},function(t,e){},function(t,e){},function(t,e){},function(t,e){},function(t,e){t.exports="<popup-picker :columns=3 :data=list :title=title :value.sync=value show-name :inline-desc=inlineDesc></popup-picker>"},function(t,e){t.exports="<div class=weui_cell :class=\"{'vux-tap-active': isLink || !!link}\" @click=onClick> <div class=weui_cell_hd> <slot name=icon></slot> </div> <div class=weui_cell_bd :class=\"{'weui_cell_primary':primary==='title'}\"> <p> {{title}} <slot name=after-title></slot> </p> <inline-desc>{{inlineDesc}}</inline-desc> </div> <div class=weui_cell_ft :class=\"{'weui_cell_primary':primary==='content', 'with_arrow': isLink || !!link}\"> {{value}} <slot name=value></slot> <slot></slot> </div> </div>";
},function(t,e){t.exports="<div class=vux-flexbox-item :style=style> <slot></slot> </div>"},function(t,e){t.exports="<div class=vux-flexbox :class=\"{'vux-flex-col': orient === 'vertical', 'vux-flex-row': orient === 'horizontal'}\"> <slot></slot> </div>"},function(t,e){t.exports="<span class=vux-label-desc><slot></slot></span>"},function(t,e){t.exports="<div class=vux-picker> <flexbox :gutter=0> <flexbox-item v-for=\"(index, one) in data\" style=margin-left:0> <div class=vux-picker-item :id=\"'vux-picker-' + uuid + '-' + index\"></div> </flexbox-item> </flexbox> </div>"},function(t,e){t.exports="<cell :title=title primary=content is-link :inline-desc=inlineDesc @click=onClick> <span class=vux-popup-picker-value slot=value v-if=!showName>{{value | array2string}}</span> <span class=vux-popup-picker-value slot=value v-else>{{value | value2name data}}</span> </cell> <popup :show.sync=show class=vux-popup-picker :id=\"'vux-popup-picker-'+uuid\"> <div class=vux-container> <div class=vux-header> <flexbox> <flexbox-item style=text-align:left;padding-left:15px;line-height:44px @click=onHide(false)>取消</flexbox-item> <flexbox-item style=text-align:right;padding-right:15px;line-height:44px @click=onHide(true)>完成</flexbox-item> </flexbox> </div> <picker :data=data :value.sync=value :columns=columns :container=\"'#vux-popup-picker-'+uuid\"></picker> </div> </popup>"},function(t,e){t.exports="<div v-show=show transition=popup :style={height:height} class=vux-popup> <slot></slot> </div>"},function(t,e,n){var o,r;o=n(20),r=n(72),t.exports=o||{},t.exports.__esModule&&(t.exports=t.exports["default"]),r&&(("function"==typeof t.exports?t.exports.options||(t.exports.options={}):t.exports).template=r)},function(t,e,n){var o,r;n(66),o=n(21),r=n(73),t.exports=o||{},t.exports.__esModule&&(t.exports=t.exports["default"]),r&&(("function"==typeof t.exports?t.exports.options||(t.exports.options={}):t.exports).template=r)},function(t,e,n){var o,r;n(68),r=n(76),t.exports=o||{},t.exports.__esModule&&(t.exports=t.exports["default"]),r&&(("function"==typeof t.exports?t.exports.options||(t.exports.options={}):t.exports).template=r)},function(t,e,n){var o,r;n(69),o=n(24),r=n(77),t.exports=o||{},t.exports.__esModule&&(t.exports=t.exports["default"]),r&&(("function"==typeof t.exports?t.exports.options||(t.exports.options={}):t.exports).template=r)},function(t,e,n){var o,r;n(70),o=n(25),r=n(78),t.exports=o||{},t.exports.__esModule&&(t.exports=t.exports["default"]),r&&(("function"==typeof t.exports?t.exports.options||(t.exports.options={}):t.exports).template=r)},function(t,e,n){var o,r;n(71),o=n(26),r=n(79),t.exports=o||{},t.exports.__esModule&&(t.exports=t.exports["default"]),r&&(("function"==typeof t.exports?t.exports.options||(t.exports.options={}):t.exports).template=r)}])});