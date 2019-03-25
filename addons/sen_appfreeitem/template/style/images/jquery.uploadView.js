// 图片上传前预览插件
//Power By 勾国印
//QQ:245629560
//Blog:http://www.gouguoyin.cn
(function($){  
	$.fn.uploadView = function(options){
		var defaults = {
			'uploadBox': '.js_uploadBox', 
			'showBox' : '.js_showBox', //用于展示图片的容器
			'width' : '0', //原始宽度
			'height': '0' //原始高度
		};
		var config = $.extend(defaults, options);
		
		var showBox = config.showBox;
		var uploadBox = config.uploadBox;
		var width = config.width;
		var height = config.height;
		
		
		$(this).each(function(i){
		    $(this).change(function(e){
		      handleFileSelect($(this), width, height);
		    });
		});
		
		var handleFileSelect = function(obj, _w, _h){
		
			  if (typeof FileReader == "undefined") {
			    return false;
			  }
			  var thisClosest = obj.closest(uploadBox);
			  if (typeof thisClosest.length == "undefined") {
			    return;
			  }
			  
			  var files = obj[0].files;
			  var f = files[0];
			  if (!isAllowFile(f.name)) {
			    alert("请上传常规格式的图片,如：jpg,png,gif等");
			    return false;
			  }
			  
			  var reader = new FileReader();
			  reader.onload = (function(theFile){
				      return function (e) {
				        var tmpSrc = e.target.result;
				        if (tmpSrc.lastIndexOf('data:base64') != -1) {
						  tmpSrc = tmpSrc.replace('data:base64', 'data:image/jpeg;base64');
						} else if (tmpSrc.lastIndexOf('data:,') != -1) {
						  tmpSrc = tmpSrc.replace('data:,', 'data:image/jpeg;base64,');
						}
						
						var img = '<img title="点击删除图片" src="' + tmpSrc + '"/>';
						//consoleLog(reader, img);
						//thisClosest.find(showBox).show().html(img);
						thisClosest.find(showBox).removeClass('hidden').html(img);
						if (_w > 0 && _h > 0) {
						  cssObj = { 'width':_w+'px', 'height':_h+'px' };
						} else if (_w > 0 && _h <= 0) {
						  cssObj = { 'width':_w+'px' };
						} else if (_h > 0 && _w <= 0) {
						  cssObj = { 'height':_h+'px' };
						} else {
						  cssObj = { 'max-width':'360px', 'max-height':'200px' };
						}
						thisClosest.find(showBox+" img").css( cssObj );
				     };
			  })(f)
			  reader.readAsDataURL(f);
	
		}
		//获取上传文件的后缀名
		var getFileExt = function(fileName){
			  if (!fileName) {
				    return '';
				  }
				  
				  var _index = fileName.lastIndexOf('.');
				  if (_index < 1) {
				    return '';
				  }
				  
				  return fileName.substr(_index+1);
			};
		//是否是允许上传文件格式	
	    var isAllowFile = function(fileName, allowType){

			  var fileExt = getFileExt(fileName).toLowerCase();
			  if (!allowType) {
			    allowType = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];
			  }
			  
			  if ($.inArray(fileExt, allowType) != -1) {
			    return true;
			  }
			  
			  return false;

		}		

	};
	

})(jQuery);

