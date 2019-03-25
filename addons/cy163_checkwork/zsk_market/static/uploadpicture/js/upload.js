 host=window.location.protocol+"//"+window.location.host;
 host2=window.location.protocol+"//"+window.location.host;
 siteroot="/attachment/"
 editgroup=host+"/index.php?c=site&a=entry&do=route&m=zsk_market&version_id=0&act=upload.editgroup"
 selectgroup=host+"/index.php?c=site&a=entry&do=route&m=zsk_market&version_id=0&act=upload.selectgroup"
 picturesall=host+"/index.php?c=site&a=entry&do=route&m=zsk_market&version_id=0&act=upload.showpictures"
 namedata=""
 limitnumdata=1
 pagedatar=[];
 var severurl = window.location.href;
 console.log(severurl);
         if(severurl.indexOf("web") != -1){//判断为微擎模块还是独立版
            //微擎
             picturesall=host+"/index.php?c=site&a=entry&do=route&m=zsk_market&version_id=0&act=upload.showpictures"
              host2=host+"/web"
             host=host+"/addons/zsk_market/"
              editgroup=host2+"/index.php?c=site&a=entry&do=route&m=zsk_market&version_id=0&act=upload.editgroup"
 selectgroup=host+"/index.php?c=site&a=entry&do=route&m=zsk_market&version_id=0&act=upload.selectgroup"

                var severurl = host2+"/index.php?c=site&a=entry&do=route&m=zsk_market&version_id=0&act=upload.uploadwb";
               var swfurl = host+'/static/uploadpicture/js/Uploader.swf';
                var siteroot="/attachment/"
                editgroup=host2+"/index.php?c=site&a=entry&do=route&m=zsk_market&version_id=0&act=upload.editgroup"
 selectgroup=host2+"/index.php?c=site&a=entry&do=route&m=zsk_market&version_id=0&act=upload.selectgroup"
            }else{
                //独立
                var groupidpicture=$("#groupidpicture").val()
                var severurl = host+"/index.php?c=site&a=entry&do=route&m=zsk_market&version_id=0&act=upload.uploadwb";
                 var swfurl = host+'/static/uploadpicture/js/Uploader.swf';
                var siteroot="/attachment/"
            }
var stat = '';
function public_imgclickclose(){
     $("#materialModalr").css("display","none")
}
function public_imgclick(name,limitnum){
    namedata=name;
    if(limitnum){
    limitnumdata=limitnum;
     }
     else{
       limitnumdata=1;  
     }
    $("#materialModalr").css("display","block") 
    $.ajax({  
            url: picturesall,
            type: "POST", 
            dataType: 'json',  
            success: function(data){

                  public_upload_group(data.group)
                  pagedatar=data
                  public_upload_page(0)
           },
           error:function(){
           }   
        })
        

      // 初始化Web Uploader
     
      console.log(WebUploader);
    var uploader = WebUploader.create({
            // 选完文件后，是否自动上传。
            auto: true,
            // swf文件路径
            swf: swfurl,
            // 文件接收服务端。
            server: severurl,
            chunked: true,           //开启分片上传
            chunkSize: 512 * 1024,   //每一片的大小
            chunkRetry: 100,         // 如果遇到网络错误,重新上传次数
            threads: 3,              //上传并发数。允许同时最大上传进程数。
            // 选择文件的按钮。可选。
            // 内部根据当前运行是创建，可能是input元素，也可能是flash.
            pick: {
                id: '#picker',
                label: '上传图片'
            },
            method:'POST',
            // 只允许选择图片文件。
            accept: {
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                mimeTypes: 'image/*'
            }
});

    uploader.on( 'fileQueued', function( file ) {
         console.log(file.name);
    });
    uploader.onFileQueued = function( file ) {
                addFile( file );
            };
       uploader.on('uploadSuccess', function(file,res){
               if(res.code==1){
                var path=host+siteroot+res.data[0].imageval;
                    public_multiple_img(path,res.data[0].imageval)
               }else {
                console.log("失败")
               }
           
        })
      
}
//上传图片成功添加图片
            function public_multiple_img(path,img){
                if(path.indexOf(".png")>=0||path.indexOf(".jpg")>=0||path.indexOf(".jpeg")>=0){
                 var data='<div class="item ng-scope "  ng-repeat="(key, value) in images" onclick="public_click(this)" style="background-image: url('+path+')"><div class="name ng-binding">'+img+'</div><div class="mask"><span class="wi wi-right"></span> </div><div class="del" ng-click="delItem(value,$event)"> </div><input hidden type="checkbox"  value="'+img+'" name="public-upload-img"></div>'
                  $(".img-container").append(data)
                }
            }
            function addFile( file ) {
                filename = file.name;
                file.orgname=filename;
                var index1 = filename.lastIndexOf(".");
                var index2 = filename.length;
                var ext = filename.substring(index1, index2);//后缀名
                file.name = WebUploader.guid() + ext;//重命名图片
            }
//渲染分组
 function public_upload_group(group){
    $(".category-menu-group").html("");
    for (var i = group.length - 1; i >= 0; i--) {
        var option = '<div class="name ng-binding ct-groupchild" onclick="public_upload_classification(this,'+group[i].id+')"><span class="wi wi-file"></span><span class="namecaty">'+group[i].name+'</span> <input type="text"   value="'+group[i].name+'" style="display:none;height:25px" onBlur="public_upload_doaddgroup(this,'+group[i].id+')">   <span class="setting" v-show="!value.editable &amp;&amp; !value.editing" onclick="doDeletGroup(this,'+group[i].id+')" style = "left:3px;color:red;width:20px"><i class="glyphicon glyphicon-trash" style="line-height:44px"></i></span><span class="setting" v-show="!value.editable &amp;&amp; !value.editing" onclick="doEditGroup(this)"> <i class="glyphicon glyphicon-cog" style="line-height:44px"></i> </span></div>';
         $(".category-menu-group").append(option)
    }
 } 
// 选中图片
 function public_click(elm){
    console.log($(elm).find(":checkbox").attr("checked"));
    if($(elm).find(":checkbox").attr("checked")){
        $(elm).find(":checkbox").attr("checked", false);
        $(elm).css("border","2px solid #fff");
    }else{
        $(elm).find(":checkbox").attr("checked", true);
        $(elm).css("border","2px solid #118EEA");
    }
}
//全选
function public_upload_selected(elm){
    console.log(elm.checked);
    if(elm.checked) {
        $("input[name='public-upload-img']").attr('checked',true);
        $("input[name='public-upload-img']").parent().css("border","2px solid #118EEA");
    }else {
        $("input[name='public-upload-img']").attr('checked',false);
        $("input[name='public-upload-img']").parent().css("border","1px solid #fff");
    }
}
//确认选中图片
function public_upload_success(elm){
    $(".img-container input:checkbox:checked").each(function(){
            var path = $(this).val();
            var imgsrc =host+"/attachment/"+path;
            console.log(limitnumdata);
             console.log(namedata);
            if(limitnumdata==1){
                $(" input[name='"+namedata+"'] ").val(path)
                $(" #"+namedata).attr('src',imgsrc);
                $(".mult-figure-img"+namedata).attr('src',imgsrc);
            }else{
                // if(multiple_img==1){
                    // $(".multiple_img").val("2")
                    // $(".multi-img-details").empty();
                    var setdata1 = '<div class="multi-item" style="float:left;margin-right:3px">'
                    var setdata2 = '<img src="' + imgsrc + '"  class="img-responsive img-thumbnail" width="150px" height="90px" />'
                    var setdata3 = '<input type="hidden" name="' + namedata + '[]" value="' + path + '">'
                    var setdata4 = '<em class="close" title="删除这张图片" onclick="deleteImagemore(this)">×</em></div>'
                     var setdata5 = '<img src="' + imgsrc + '"  />'
                    var setdata = setdata1+setdata2+setdata3+setdata4
                    $(".multi-img-details"+namedata).append(setdata)
                    $("iframe[textarea='"+namedata+"']").contents().find("body").append(setdata5);
                // }else{
                //     var setdata1 = '<div class="multi-item" style="float:left;margin-right:3px">'
                //     var setdata2 = '<img src="' + path + '" onerror="this.src=\'' + chatrimgdefault + '\'; this.title="\'图片未找到.\'" class="img-responsive img-thumbnail" width="150px" height="90px" />'
                //     var setdata3 = '<input type="hidden" name="' + chartimgname + '[]" value="' + path + '">'
                //     var setdata4 = '<em class="close" title="删除这张图片" onclick="deleteMultiImage(this)">×</em></div>'
                //     var setdata = setdata1+setdata2+setdata3+setdata4
                //     $(".multi-img-details").append(setdata)
                // }
            }
    })
    //$('#myimgModal'+difference+'').modal('hide');
    public_imgclickclose();
}
 function public_upload_success1(elm){
     $(".img-container input:checkbox:checked").each(function(){
         // var multiple_img = $(".multiple_img").val()
         // var fileNumLimit = $(".fileNumLimit"+difference+"").val();
         var path = $(this).val();
         var imgsrc =host+"/attachment/"+path;

     })
     public_imgclickclose();
 }
    //移动选中图片
function public_upload_move(elm){
    var cate = $(elm).val()
    var str = "";
    var catemove = $(".public_upload_cateid").val()
    $(".public-upload-content input:checkbox:checked").each(function(){
       if(str!=""){
            str=str+";"+$(this).next().val();
        }else{
            str=$(this).next().val();
        }
        // if(catemove>0){
             $(this).parent().remove()
        // }
    })
    if(str!=""){
        $.ajax({  
            url: moveurl,  
            type: "POST", 
            dataType: 'json', 
            data:"id="+str+"&cate="+cate, 
            success: function(data){

           }
        })
    }
}
 //查询全部图片
function selectallimg(){
    $.ajax({
        url:selectpath,
        type: "POST", 
        dataType: 'json',  
        success: function(data){
            // console.log(data)
            $(".public-upload-content").empty()
            $.each( data, function(i, n){
                var path = n.path
                if(path.indexOf("upload") == -1){
                    var path = qiniuurl+"/"+n.path
                }
                var data ='<div class="public-upload-images"><img class="public-upload-click" onclick="public_upload_click(this)" src="'+getpublic+'statics/admin/images/check.png"><img onclick="public_click(this)" class="public-upload-img" src="'+path+'"><input hidden type="checkbox" value="'+path+'" name="public-upload-img"><input hidden value="'+n.id+'"></input></div>'           
                $(".public-upload-content").append(data)
            });   
        }
    })
}
//查询当前分类图片
function selectcateimg(cate){
    $.ajax({
        url:uploadcate,
        type: "POST", 
        dataType: 'json',
        data:"cate="+cate,
        success: function(data){
            //获取当前分类图片
            if(data.length>0){
                $.each( data, function(i, n){
                    var path = n.path
                    if(path.indexOf("upload") == -1){
                        var path = qiniuurl+"/"+n.path
                    }
                    var data ='<div class="public-upload-images"><img class="public-upload-click" onclick="public_upload_click(this)" src="'+getpublic+'statics/admin/images/check.png"><img onclick="public_click(this)" class="public-upload-img" src="'+path+'"><input hidden type="checkbox" value="'+path+'" name="public-upload-img"><input hidden value="'+n.id+'"></input></div>'           
                    $(".public-upload-content").append(data)
                })
            }
        }
    })
}
 //查询分类
function selectallcate(){
    $(".public-upload-ul").empty()
    var fistdata = '<li class="text-left public-upload-ulimg" style="cursor:pointer;color:#118EEA" onclick="public_upload_classification(this)"><div class="text-center">▪　全部　▪</div></li>'
    $(".public-upload-ul").append(fistdata)
    $.ajax({
        url:cateulr,
        type: "POST", 
        dataType: 'json',  
        success: function(data){
            $.each( data, function(i, n){
                var data = '<li class="text-left public-upload-ulimg" onclick="public_upload_classification(this)" style="cursor:pointer;"><div class="text-center public-upload-text">'+n.catename+'</div></li><input hidden value="'+n.id+'">';
                $(".public-upload-ul").append(data)
                var option = '<option value="'+n.id+'">'+n.catename+'</option>';
                $(".public-upload-select").append(option)
            });              
        }
    })
}
//查询选中当前分类
function public_upload_classification(elm,id){
    $(".ct-groupchild").css("background-color","#F4F5F9")
    $(elm).css("background-color","#fff")
    $("#groupidpicture").val(id)
    window.groupid=id
    $.ajax({
        url:selectgroup,
        type: "POST", 
        dataType: 'json',
        data:"id="+id,
        success: function(data){
            pagedatar=data
            public_upload_page(0)
        }
    })

}
//添加分类
function public_upload_addgroup(){
    $.ajax({
        url: host2+"/index.php?c=site&a=entry&do=route&m=zsk_market&version_id=0&act=upload.addgroup", 
        type: "POST", 
        dataType: 'json',
        data:"group=未命名",
        success: function(data){
            if(data.type){
                var group=data.group
             var option = '<div class="name ng-binding ct-groupchild" onclick="public_upload_classification(this,'+group.id+')"><span class="wi wi-file"></span><span class="namecaty">'+group.name+'</span> <input type="text"   value="'+group.name+'" style="display:none;height:25px" onBlur="public_upload_doaddgroup(this,'+group.id+')">   <span class="setting" v-show="!value.editable &amp;&amp; !value.editing" onclick="doDeletGroup(this,'+group.id+')" style = "left:3px;color:red;width:20px"><i class="glyphicon glyphicon-trash" style="line-height:44px"></i></span><span class="setting" v-show="!value.editable &amp;&amp; !value.editing" onclick="doEditGroup(this)"> <i class="glyphicon glyphicon-cog" style="line-height:44px"></i> </span></div>';
         $(".category-menu-group").append(option)
             }
        }
    })
}
//修改名称
function doEditGroup(elm){
    $(elm).parent().find('input').css("display","");
    $(elm).parent().find('.namecaty').css("display","none");
    $(elm).parent().find('input').focus();

}
function public_upload_editor(elm){
    dataname = $(elm).parent().prev().prev(".public-upload-ulimg").find(".text-center").text()
    if(dataname.indexOf("▪") != -1){
        var length = dataname.length
        var end = length-2
        var dataname = dataname.substring(2,end)
    }
    var data ='<li class="text-left public-upload-ulimg"><input type="text" class="public_upload_input text-center"  value="'+dataname+'"><span class="pbulic_upload_bluecheck" onclick="public_upload_doaddgroup(this)"><img style="width:14px" src="'+getpublic+'plugins/images/bluecheck.png"></span></li>';
    $(elm).parent().prev().prev(".public-upload-ulimg").remove()
    $(elm).parent().prev().before(data)
    
}

//执行修改
function public_upload_doaddgroup(elm,id){
    $(elm).css("display","none");
    $(elm).parent().find('.namecaty').css("display","");  
    var group=$(elm).val();
    var groupspan=$(elm).parent().find('.namecaty').html();
    if(group!=groupspan){
    $.ajax({
        url:editgroup,
        type: "POST", 
        dataType: 'json',
        data:"group="+group+"&id="+id,
        success: function(data){
        if(data.type){ 
            layer.msg(data.message);
            $(elm).parent().find('.namecaty').html(group)
        }
        else{
            layer.msg("修改失败");
        }
        }
    })
    }
}
//分页效果
function public_upload_page(stas){
    var pageData=pagedatar.filenames;
    if(!pageData){
   $(".img-container").html("")
    }
    var Count = pageData.length;//记录条数
    var PageSize=10;//设置每页示数目
    var PageCount=Math.ceil(Count/PageSize);//计算总页数
    if(stas==0){
        var currentPage =1;
    }else{
     var currentPage =stas;//当前页，默认为1。
    }                                    
    //造个简单的分页按钮
     var tempStr = "<span>共"+PageCount+"页</span>";
    if(currentPage>1){
        tempStr+='<li><a href="#" page="1" class="pager-nav" selectPage="1" onclick="public_upload_page(1)">首页</a></li>';
        tempStr+='<li><a href="#" page="1" class="pager-nav" selectPage="'+(currentPage-1)+'" onclick="public_upload_page('+(currentPage-1)+')">上一页</a></li>';
    }
            if(currentPage<=7){
                for(var i=1; i<=(PageCount<=10?PageCount:10); i++){
                     if(i==currentPage){
                       tempStr+='<li><a href="#" style="background-color:#337AB7;color:#fff" page="'+i+'" class="pager-nav" selectPage="'+i+'" onclick="public_upload_page('+i+')">'+i+'</a></li>';
                   }else{
                       tempStr+='<li><a href="#" page="'+i+'" class="pager-nav" selectPage="'+i+'" onclick="public_upload_page('+i+')">'+i+'</a></li>';
                    }
                }
            }else if(currentPage>7 && PageCount<=(currentPage+5)){
                for(var i=PageCount-9; i<=PageCount; i++){
                    if(i==currentPage){
                       tempStr+='<li><a href="#" style="background-color:#337AB7;color:#fff" page="'+i+'" class="pager-nav" selectPage="'+i+'" onclick="public_upload_page('+i+')">'+i+'</a></li>';
                    }else{
                      tempStr+='<li><a href="#" page="'+i+'" class="pager-nav" selectPage="'+i+'" onclick="public_upload_page('+i+')">'+i+'</a></li>';
               
                    }
                }
            }else if(currentPage>7 && PageCount>(currentPage+5)){
                for(var i=currentPage-5; i<=currentPage+4; i++){
                    if(i==currentPage){
                        tempStr+='<li><a href="#" style="background-color:#337AB7;color:#fff" page="'+i+'" class="pager-nav" selectPage="'+i+'" onclick="public_upload_page('+i+')">'+i+'</a></li>';
                    }else{
                        tempStr+='<li><a href="#" page="'+i+'" class="pager-nav" selectPage="'+i+'" onclick="public_upload_page('+i+')">'+i+'</a></li>';
               
                    }
                }
            }
    if(currentPage<PageCount){
      tempStr+='<li><a href="#" page="1" class="pager-nav" selectPage="'+(currentPage+1)+'" onclick="public_upload_page('+(currentPage+1)+')">下一页</a></li>';
      tempStr+='<li><a href="#" page="1" class="pager-nav" selectPage="'+PageCount+'" onclick="public_upload_page('+PageCount+')">尾页</a></li>';
      }
    $('.material-pager ul').html(tempStr);
    $(".img-container ul").html("")
    $(".img-container").html("")
    for(i=(currentPage-1)*PageSize;i<PageSize*currentPage;i++){ 
        var path=host+siteroot+pageData[i];
              public_multiple_img(path,pageData[i])
    }
}