$(function() {
	$('nav#mmenu').mmenu({
		extensions	: [ 'effect-slide-menu', 'pageshadow' ],
		counters	: false,
		navbar 		: {
			title		: '菜单',
		},
		navbars		: [
			 {
				position	: 'top',
				content		: [
					'prev',
					'title',
					'close'
				]
			}, {
				position	: 'bottom',
				content		: [
					''
				]
			} 
		]
	});
	
	
	$(".sou_img").click(function(){
		$(".sou_nei").slideToggle();
	})
	
	$(".pro_qie span").click(function(){
		$(this).addClass("active").siblings("span").removeClass();
		$(".pro_com .pro_com_ul").eq($(this).index()).show().siblings(".pro_com_ul").hide();
	})
	
	$(".sou_nei img").click(function(){
		$(".search_mask").show()	;
	})
	$(".sure").click(function(){
		$(".search_mask").hide();
	})
	
		

    
	
});

	/*表单验证*/
 function checknn(){

    na=form1.yourname.value;

    if( na.length <1 || na.length >12)

    {
        $("input#name").addClass("rred");
        $('input#name').attr('placeholder', '长度不正确').val("");

    }



}
 
    //验证电话

    function checkphobe(){

        psd1=form1.yourphone.value;

        if(psd1.length!=11){

            $("input#phone").addClass("rred");
            $('input#phone').attr('placeholder', '长度不正确').val("");

        }

    }


    //验证邮箱

    function checkemail(){

        apos=form1.youremail.value.indexOf("@");

        dotpos=form1.youremail.value.lastIndexOf(".");


        if (apos<1||dotpos-apos<2)

        {
            $("input#email").addClass("rred");
            $('input#email').attr('placeholder', '输入错误').val("");

        }


    }

    //验证地址

    function checkadd(){

        dizhi=form1.youradd.value;

        if(dizhi.length<1){

            $("input#add").addClass("rred");
            $('input#add').attr('placeholder', '不能为空').val("");

        }

    }
    
  function checkti(){

        biaoti=form1.yourti.value;

        if(biaoti.length<1){
            $("input#ti").addClass("rred");
            $('input#ti').attr('placeholder', '不能为空').val("");

        }

    }
  
 //验证内容

    function checkcont(){

        contant=form1.yourcont.value;

        if(contant.length<1){

            $("textarea#cont").addClass("rred");
            $('textarea#cont').attr('placeholder', '不能为空');

        }

    }

    //验证验证码

    function checkyan(){

        yanzhengma=form1.youryan.value;

        if(yanzhengma.length<1){

            $("input#yan").addClass("rred");
            $('input#yan').attr('placeholder', '不能为空');

        }

    }