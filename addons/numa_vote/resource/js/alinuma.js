/**
 * 
 */
var alinuma = (function(window){ 
	var alinuma={};
	
	//获取当前脚本文件路径
    var  _getcurrentpath=function(){
	    	var js=document.scripts;
	    	var str = location.href; 
	    	var arr = str.split("/");
	    	arr.splice(arr.length-2) 
	    	var dir = arr.join("/"); 
	    	var jsPath;
	    	for(var i=0;i<js.length;i++){
	    	 if(js[i].src.indexOf("alinuma.js")>-1){
	    	   jsPath=js[i].src.substring(0,js[i].src.lastIndexOf("/")+1);
	    	 }
	    	}
	    	jsPath = jsPath.replace(dir,"");
	    	return jsPath;
    } 
	var layer_path = "../../../.."+_getcurrentpath()+"layer"; 
	var layer_css ="css!../../../.."+_getcurrentpath()+"/skin/default/layer"; 
	/**
	 * 打开窗口
	 * @url 页面地址
	 * @width 窗口宽度
	 * @height 窗口高度
	 * @fixed 位置适应true 固定false
	 * @maxmin 大小窗口true可调整
	 */
     alinuma.openFrame=function(url,width,height,fixed,maxmin,title){
    	 var url = url||"";
    	 var width = width?width+"px":"600px";
    	 var height = height?height+"px":"400px";
    	 var title = title?title:'新窗口';
    	 var fixed = (typeof(fixed=='undefined'))?true:fixed;
    	 var maxmin = (typeof(maxmin=='undefined'))?true:maxmin;
    	 require([layer_path,layer_css],function(layer){  
    		 layer.open({
    			  type: 2,
    			  title:title,
    			  area: [width, height],
    			  fixed: fixed, //不固定
    			  maxmin: maxmin,
    			  content: url
    		 });
    	 }) 
     }  
     /**
      *提示弹窗
      */
      alinuma.alert = function(message,icon){
    	  var icon = icon || 1;
    	  require([layer_path,layer_css],function(layer){  
    		  layer.alert(message, {icon: icon});
     	 }) 
      }
     /**
 	 * 打开窗口
 	 * @element 元素
 	 */
      alinuma.openWindow=function(element){
	     	 var url = $(element).attr("data-url") || "";
	     	 var width = $(element).attr("data-width") ;
	     	 var height = $(element).attr("data-height");
	     	 var fixed = $(element).attr("data-fixed");
	     	 var maxmin =  $(element).attr("data-maxmin");
	     	 var title =  $(element).attr("data-title");
	     	 alinuma.openFrame(url,width,height,fixed,maxmin,title);
      }  
      /**
       * 预览图片
       */
      alinuma.previewImage =function(element){
    	  var width= $(element).attr("data-width") ||'300px';
    	  var height = $(element).attr("data-height") || 'auto';
    	  var title =  $(element).attr("alt") || false;
    	  var src = $(element).attr("src")||"";
    	  require([layer_path,layer_css],function(layer){  
    		  layer.open({
    			  type: 1,
    			  title: title,
    			  closeBtn: 1,
    			  shadeClose: true,
    			  area:[width,height],
    			  skin: 'yourclass',
    			  content: '<img src="'+src+'" width="100%" '+(height!=""?' height="100%"':'')+ '/>'
    			});
     	 }) 
      }
      /**
       * 关闭窗口
       */
       alinuma.closeFrame = function(index){
    	   require([layer_path,layer_css],function(layer){  
    		   layer.close(index);
      	 }) 
       }
      /**
       * 地址及坐标赋值
       */
       alinuma.setMapPosition = function(value,index,mapjwd,address){
    	    value = value.split("|");  
			$("#"+mapjwd).val(value[0]);
			$("#"+address).val(value[1]); 
			alinuma.closeFrame(index) 
       }
       /**
        * 数组去除重复
        */
        alinuma.array_unique = function(arr){
    	   			// 遍历arr，把元素分别放入tmp数组(不存在才放)
			    	var tmp = new Array();
			    	for(var i in arr){
			    	//该元素在tmp内部不存在才允许追加
					  	if(tmp.indexOf(arr[i])==-1){
					    	tmp.push(arr[i]);
					    }
			    	}
			    	return tmp;
    	 }
    return alinuma; 
	
}(window));

(function($){ 
	$.fn.AutoResizeImage = function(maxWidth,maxHeight){  
				$(this).each(function(){ 
					var img = new Image();
					var objImg = $(this)[0];
					img.src = objImg.src;
					var hRatio;
					var wRatio;
					var Ratio = 1;
					var w = img.width;
					var h = img.height;
					wRatio = maxWidth / w;
					hRatio = maxHeight / h;
					if (maxWidth ==0 && maxHeight==0){
						Ratio = 1;
					}else if (maxWidth==0){//
					if (hRatio<1) Ratio = hRatio;
					}else if (maxHeight==0){
					if (wRatio<1) Ratio = wRatio;
					}else if (wRatio<1 || hRatio<1){
						Ratio = (wRatio<=hRatio?wRatio:hRatio);
					}
					if (Ratio<1){
							w = w * Ratio;
							h = h * Ratio;
					}
					objImg.height = h;
					objImg.width = w;
			 }) 
	 } 
}($))
