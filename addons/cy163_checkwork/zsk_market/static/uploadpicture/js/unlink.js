var severurl = window.location.href;
 host=window.location.protocol+"//"+window.location.host;
 host2=window.location.protocol+"//"+window.location.host;
 urldr="";
if(severurl.indexOf("web") != -1){//判断为微擎模块还是独立版
    host2=host+"/web"
   host=host+"/addons/zsk_market/"
   urldr="/addons/zsk_market/"
    var severurl ="/addons/zsk_core/public/index.php/admin/upload/unlink";
    var getpublic = "/addons/zsk_core/public/";
    var deletegroup = "/addons/zsk_core/public/index.php/admin/upload/deletegroup";
}else{
     var severurl = "/admin/upload/unlink";
     var getpublic = "/";
     var deletegroup = "/admin/upload/deletegroup";
}
function doDeletGroup(elm,id){//删除分组
    layer.confirm('确定要删除吗?', {
          btn: ['是','否'] //按钮
        }, function(){
              $.ajax({  
            url: host2+"/index.php?c=site&a=entry&do=route&m=zsk_market&version_id=0&act=upload.delgroup", 
            type: "POST", 
            dataType: 'json',  
            data:{
                "id":id
            },
            success: function(data){
                 $(elm).parent().remove()
            layer.msg('删除成功', {icon: 1});
           },
           error:function(){
           }   
        })

        }, 
    );

}
function deleteMultiImage(){//多图删除
    layer.confirm('确定要删除吗?', {
          btn: ['是','否'] //按钮
        }, function(){
          var imgsrcs=[];
             $(".img-container input:checkbox:checked").each(function(){
                    var path = $(this).val();
                    var imgsrc ="/attachment/"+path;
                    imgsrcs.push(imgsrc);
                   $(this).parent().remove()
                   layer.msg('删除成功', {icon: 1});
             })
             console.log(imgsrcs);
             imgsrcs=JSON.stringify(imgsrcs)
              $.ajax({  
            url: host2+"/index.php?c=site&a=entry&do=route&m=zsk_market&version_id=0&act=upload.delpictures", 
            type: "POST", 
            dataType: 'json',  
            data:{
                "imgsrcs":imgsrcs
            },
            success: function(data){
           },
           error:function(){
           }   
        })

        }, 
    );
    
}
function deleteImage(data){//单图删除
	var difference = $(data).prev().prev().val()
	$(".public-single-img"+difference+"").val("")
    var defalut=getpublic+'statics/admin/images/nopic.jpg';
	$(data).prev().attr("src",defalut);
}
function deleteImagemore(elm){//多图删除
    $(elm).parent().remove();
}
//删除当前选中单张图片
function public_upload_click(elm){
    var path = $(elm).next().attr("src")+";"
    $(elm).parent().remove()
    $.ajax({  
        url: severurl,  
        type: "POST", 
        dataType: 'json', 
        data:"path="+path, 
        success: function(data){
            console.log(data)
       }
    })
}
//删除所有选中图片
function public_upload_delete(){
    var str = "";
    $(".public-upload-content input:checkbox:checked").each(function(){
        console.log()
        if(str!=""){
            str=str+";"+$(this).val();
        }else{
            str=$(this).val();
        }
        $(this).parent().remove()
    })
    if(str!=""){
		$.ajax({  
	        url: severurl,  
	        type: "POST", 
	        dataType: 'json', 
	        data:"path="+str, 
	        success: function(data){
	       }
	    })
	}
}
    //删除当前分组
function public_upload_deletegroup(elm){
        var id = $(elm).parent().prev().val()
        $(elm).parent().prev().prev().remove()
        $(elm).parent().prev().remove()
        $(elm).parent().remove()
        $(".public-upload-select option[value="+id+"]").remove();
        $(".public-upload-content").empty()
        $.ajax({
            url:deletegroup,
            type:"POST",
            dataType: 'json', 
            data:"id="+id, 
            success:function(data){
                
            }
        })
    }