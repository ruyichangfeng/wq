$(function(){
	var delParent;
	var defaults = {
		fileType         : ["jpg","png","bmp","jpeg",'JPG',"PNG","BMP","JPEG"],   // 上传文件的类型
		fileSize         : 1024 * 1024 * 10                  // 上传文件的大小 10M
	};
		/*点击图片的文本框*/
	$(".photoimg").change(function(){	 
		var idFile = $(this).attr("id");
		var uploadUrl = $(this).attr("data-url");
		var _this = $(this);
		var file = document.getElementById(idFile);
		var imgContainer = $(this).parents(".list-playerimg"); //存放图片的父亲元素
		var fileList = file.files; //获取的图片文件
		var input = $(this).parent();//文本框的父亲元素
		var imgArr = [];
		//遍历得到的图片文件
		var numUp = imgContainer.find("img").length;
		var totalNum = numUp + fileList.length;  //总的数量
		if(fileList.length > 5 || totalNum > 5 ){
			layer.open({
			    content: '上传图片数目不可以超过5个，请重新选择'
			    ,skin: 'msg'
			    ,time: 2 //2秒后自动关闭
			  }); //一次选择上传超过5个 或者是已经上传和这次上传的到的总数也不可以超过5个 
		}
		else if(numUp < 5){
			fileList = validateUp(fileList);
			for(var i = 0;i<fileList.length;i++){
			 var imgUrl = window.URL.createObjectURL(fileList[i]);
			  
			 var $section = $("<li>");
		     imgContainer.append($section);
		     var $span = $("<img src='"+imgUrl+"' class='pics' ><i class='del remove_pic'><a href='javascript:void(0)' >X</a></i>");
		     uploadImage(uploadUrl,fileList[i],function(data){ 
			 		  eval("var result_data="+data);
			 		  if(result_data.status==1){
			 			 $span.appendTo($section); 
			 			 var $input_pics = $("<input type='hidden' name='pics[]' value='"+result_data.data+"'>");
			 			 $input_pics.appendTo($section);	
			 		  }else{
			 			 console.log(result_data.message);
			 			 return -1;
			 		  } 
			  })
			 imgArr.push(imgUrl);   
		     $(".remove_pic").on("click",function(event){
				    event.preventDefault();
					event.stopPropagation(); 
				    $(this).parents("li").remove();
				    _this.parents("li").show();
			 });   
		     $(".pics").on("click",function(event){ 
				    event.preventDefault();
					event.stopPropagation(); 
					$(".pics").removeClass("selected-img");
				    $('#thumb').val($(this).siblings("input").val());
				    $(this).addClass("selected-img");
				    _this.parents("li").show();
			 }); 
		   }
		} 
		 numUp = imgContainer.find("img").length;
		if(numUp >= 5){
			$(this).parents("li").hide();
		}
	}); 
	function validateUp(files){
			var arrFiles = [];//替换的文件数组
			for(var i = 0, file; file = files[i]; i++){
				//获取文件上传的后缀名
				var newStr = file.name.split("").reverse().join("");
				if(newStr.split(".")[0] != null){
						var type = newStr.split(".")[0].split("").reverse().join("");
						console.log(type+"===type===");
						if(jQuery.inArray(type, defaults.fileType) > -1){
							// 类型符合，可以上传
							if (file.size >= defaults.fileSize) {
								console.log(file.size);
								layer.open({
								    content:'您这个"'+ file.name +'"文件大小过大'
								    ,skin: 'msg'
								    ,time: 2 //2秒后自动关闭
								  });  
							} else {
								// 在这里需要判断当前所有文件中
								arrFiles.push(file);	
							}
						}else{
							layer.open({
							    content: '您这个"'+ file.name +'"上传类型不符合'
							    ,skin: 'msg'
							    ,time: 2 //2秒后自动关闭
							  }); 
						}
					}else{
						layer.open({
						    content: '您这个"'+ file.name +'"没有类型, 无法识别'
						    ,skin: 'msg'
						    ,time: 2 //2秒后自动关闭
						  });  
					}
			}
			return arrFiles;
		}
		
	   function uploadImage(url,file,callfunc){
			var xhr = new XMLHttpRequest(); 
	        xhr.open("post",url, true);
	        xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
	        xhr.onreadystatechange = function() {
	            if (xhr.readyState == 4) {
	                var flag = xhr.responseText;
	                console.log(flag); 
	                callfunc.call(this,flag);
	            };
	        };
	        //表单数据
	        var fd = new FormData();
	        fd.append("myImage",file);
	        //执行发送        
	        xhr.send(fd);        
		}  
})
