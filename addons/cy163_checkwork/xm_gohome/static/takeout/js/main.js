/*绑定touchstart事件*/
//var btn = $(".btn");
//document.body.addEventListener('touchstart', function () { }); 
$("body").on('touchstart', function () { }); 
var h = document.documentElement.clientHeight;
var w = document.documentElement.clientWidth;
$("#page0").css('min-height',h);
$(".top-con").css('height',h);
$(".slideToppic").css('min-height',h);
$("#paiming").css('width',w);
$(window).resize(function(){
	var h = document.documentElement.clientHeight;
	var w = document.documentElement.clientWidth;
	$("#page0").css('min-height',h);
	$(".slideToppic").css('min-height',h);
	$("#paiming").css('width',w);
	//alert("窗口尺寸变了");
	})
//提示弹出及关闭
	$(".tanchu").css('height',h);
	$(".dt-btn").on("click",function(){
		//$(".tanchu").show();
		$(".tanchu").show('');
		/*$(".tanchu").animate({
  opacity: 0.75, left: '50px',
  color: '#abcdef',
  rotateZ: '45deg', translate3d: '0,10px,0'
}, 500, 'ease-in')*///动画
	});
$("#yanshi").on("click",function(){
		$("#shenqing").fadeIn();
		/*$("#sqform").animate({
			  opacity: 0.75, height:'toggle'
			}, 500, 'ease-in')*/
	});
$(".close").on("click",function(){
		$("#shenqing").fadeOut();
	});


function getIndexAdr(){
  $("#city").html('定位中');
  wx.getLocation({
      type: 'gcj02',
      success: function (res) {
        lat = res.latitude;
        lng = res.longitude;
        localStorage['lat'] = lat;
        localStorage['lng'] = lng;

        mapkey = $("#mapkey").val();
        if(mapkey == ''){
          alert('获取地址失败，腾讯地图密钥未设置！');
        }
        $.ajax({
          url:"http://cloud.n3.cn/gohome/address.php",
          type:"POST",
          data:{"lat":lat,"lng":lng,"mapkey":mapkey},
          dataType:"jsonp",
          jsonp:"jsoncallback",
          success:function(res){
            qu = res.qu;
            if(qu_s){
              if(qu_s != qu){
                if(qu_f){
                  $("#city").html(qu_s);
                  localStorage['qu']  = qu_s;
                }else{
                  if(window.confirm('当前定位位置为'+qu+',是否切换位置？')){
                    $("#city").html(qu);
                    localStorage['qu']   = qu;
                    localStorage['qu_s'] = qu;
                    localStorage['qu_f'] = '';
                  }else{
                    $("#city").html(qu_s);
                    localStorage['qu']  = qu_s;
                  }
                }
              }else{
                $("#city").html(qu);
                localStorage['qu']  = qu;
              }
            }else{
              $("#city").html(qu);
              localStorage['qu']  = qu;
            }
            localStorage['adr'] = res.readdress;
            localStorage['qu_f'] = '';
            getInit();
          },
          error:function(){
            alert('error!');
          }
        });
      } 
  });
}
	
	