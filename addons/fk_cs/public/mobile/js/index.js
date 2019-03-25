$(document).ready(function () {
        $("#fabu").on('click',function () {
            $("#fbform").show();
        });

    });

    function show_info(uid,lid) {
        window.location.href = "{php echo $show_url}&uid="+uid+"&lid="+lid;
    }


    var winH = $(window).height(); 
    $(window).scroll(function () { 
      var pageH = $(document.body).height(); //页面总高度 
      var scrollT = $(window).scrollTop(); //滚动条top 
      var aa = (pageH-winH-scrollT)/winH; 
      var pageindex = $("#pageindex").val();
    if(aa<0.02){ 
        // $.ajax({
        //     url : "{php echo $this->createMobileUrl('Index')}",
        //     //dataType:'json',
        //     type:'post',
        //     data:{
        //         dos : 'ajax_get',
        //         page : pageindex,
        //     },
        //     success:function(res)
        //     {
        //         $("#pageindex").attr("value",parseInt(pageindex)+1);
        //         var obj1 = eval(res);
        //         alert(1);

        //     }

        // });
        $.post("{php echo $this->createMobileUrl('Pages')}",{
            dos : 'ajax_get',
            page : pageindex,
        },function(res){
            $("#pageindex").attr("value",parseInt(pageindex)+1);
            var data = $.parseJSON(res);
            var html = "";
            $.each(data,function(k,v){
                    var img = "";
                    $.each(v.img,function(k,v){
                        img += '<img src="'+v.name+'" alt="">';
                    });
                
                html = '<div class="content" style="width:100%; margin-top:20px;" onClick="show_info('+v.uid+','+v.id+')"><div class="userimg" style="margin-top:10px; width:40px; height:40px; margin-left:10px; border: 1px solid #336699;"><img src="'+v.headimg+'" width="30px;" height="30px;" ></div><div class="username" style="margin-left:60px; margin-top:-58px; color:#666666;"><p style="font-size:0.9em;"><strong>'+v.user+'</strong></p></div>    <div class="time1" style="margin-left:60px; margin-top:-12px; color:#999999;"><p style="font-size:0.8em;">'+v.time+'</p></div><div class="usercontent" style="margin-left:60px; margin-top:-10px; color: #333333; margin-right:5px;"><p style="font-size:0.9em;">'+v.info+'</p></div><div class="userimg1" style="margin-left:60px; margin-top:-10px; margin-bottom:15px;">'+img;
                
                $("#html_append").append(html);
            });
        });
    } 

    }); 
