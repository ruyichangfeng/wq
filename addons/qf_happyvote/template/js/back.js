//后台增加和修改验证
// $("#form1").submit(function (e) {

//     var name = form.votename.value;
//     if (name == null || name.trim().length == 0) {
//         form.votename.focus();
//         $("#spanname").html("*标题填写有误");
//         return false;
//     }
//     $("#spanname").html("");

//     var imgobj = $("input[name='voteimg']").val();
//     if (imgobj == "") {
//         $("#spanimg").html("*请选择图片");
//         return false;
//     }

//     if (!/\.jpeg|\.jpg|\.gif|\.png/gi.test(imgobj)) {
//         $("#spanimg").html("*图片格式有误");
//         return false;
//     }
//     $("#spanimg").html("");

//     var textobj = form.votetext.value;
//     if (textobj == "") {
//         $("#spantext").html("*活动详情不能为空");
//         return false;
//     }
//     $("#spantext").html("");

// });

// //后台增加和修改验证
// function btnnumber(id) {
//     $("#" + id).val($("#" + id).val().replace(/[^\d]/g, ''));
// }

// //后台修改参与人数据验证
// $("#form2").submit(function (e) {

//     var nameobj = $("input[name='context']").val();
//     if (nameobj == null || nameobj.trim().length == 0) {
//         form.context.focus();
//         $("#spantext").html("*标题填写有误");
//         return false;
//     }
//     $("#spanname").html("");

//     var imgobj = $("input[name='img']").val();
//     if (imgobj == "") {
//         $("#spanimg").html("*请选择图片");
//         return false;
//     }

//     if (!/\.jpeg|\.jpg|\.gif|\.png/gi.test(imgobj)) {
//         $("#spanimg").html("*图片格式有误");
//         return false;
//     }
//     $("#spanimg").html("");


//     var textobj = form.username.value;
//     if (textobj == "" ) {
//         form.username.focus();
//         $("#spanname").html("*姓名不能为空");
//         return false;
//     }
//     if (textobj.length > 50 ) {
//         form.username.focus();
//         $("#spanname").html("*长度不能超过50");
//         return false;
//     }
//     $("#spanname").html("");

//     var telphone = $("input[name='telphone']").val();
//     if((!(/^1[3|4|5|8][0-9]\d{4,8}$/.test(telphone)))){
//         form.telphone.focus();
//         $("#spanphone").html("*请输入正确的手机号码，方便联系您兑换奖品");
//         return false;
//     }
//     $("#spanphone").html("");
// });