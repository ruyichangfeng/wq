var tb = (function () {
	var inputtype = new Array("", "单行文本", "多行文本", "单项选择","多项选择","日期","时间","富文本","车牌","图片");
	var checktype = new Array("", "电话", "身份证号码");
	var yesno = new Array("否", "是");
	var datas = new Array();
	var getdatas = function () {
		return datas;
	};
	var setsn = function(){
		for (var d in datas){
			if (!datas[d].sn){
				var t = new Date().getTime();
				t = t.toString();
				var r = Math.floor(Math.random () * 900) + 100;
				r = r.toString();
				datas[d].sn = t + r;
			}
		}
	};
	var getnextsortnumber = function () {
		var i = 1;
		for (var d in datas) {
			if (datas[d].sortnumber >= i) {
				i = datas[d].sortnumber + 1;
			}
		}
		return i;
	};
	var checkdata = function (d) {
		if (d.title.length == 0) {
			return "名称必须填写";
		}
		if (d.inputtype == 3) {
			if (d.options.length == 0) {
				return "选择项必须填写";
			}
		}
		return "";
	};
	var input = function (t, l) {
		var s = "";
		var t = parseInt(t);
		switch (t) {
		case 1:
			s = "<input type='text'>";
			break;
		case 2:
			s = "<textarea></textarea>";
			break;
		case 3:
			s = "<select>";
			for (var k in l) {
				s = s + "<option value =" + l[k] + ">" + l[k] + "</option>"
			}
			s = s + "</select>";
			break;
		case 4:
			for (var k in l){
				s = s + "<label><input type='checkbox' name='checkbox'>" + l[k] + "</label>";
			}
			break;
		case 5:
			s = "<input type='text'>";
			break;	
		case 6:
			s = "<input type='text'>";
			break;
		case 7:
			s = "<textarea></textarea>";
			break;	
		case 8:
			s = "<select><option value ='1'>京</option><option value ='2'>津</option><option value ='3'>沪</option></select><input type='text'>";
			break;	
		case 9:
			s = "<input type='file'>";
			break;			
		default:
			s = "";
		}
		return s;
	};
	var refresh = function (el) {
		var el = arguments[0] ? arguments[0] : "#bctbody";
		var s = "";
		datas.sort(function (a, b) {
			return a.sortnumber - b.sortnumber
		});
		var d;
		for (d in datas) {
			s = s + "<tr>";
			s = s + "<td>" + datas[d].title + "</td>";
			s = s + "<td>" + datas[d].desc + "</td>";
			s = s + "<td>" + inputtype[datas[d].inputtype] + "</td>";
			s = s + "<td>" + checktype[datas[d].checktype] + "</td>";
			s = s + "<td>" + input(datas[d].inputtype, datas[d].options) + "</td>";
			s = s + "<td>" + yesno[datas[d].isneed] + "</td>";
			s = s + "<td>" + datas[d].sortnumber + "</td>";
			s = s + "<td>" + datas[d].errormsg + "</td>";
			s = s + "<td>" + "<a href='javascript:;' class='editinput' data='" + d + "'>"
				 + "<span class='glyphicon glyphicon-pencil'></span></a>"
				 + "&nbsp;"
				 + "<a href='javascript:;' class='removeedit' data='" + d + "'><span class='glyphicon glyphicon-trash'></span></a>"
				 + "</td>";
			s = s + "</tr>";
		}
		$(el).html(s);
	};
	var append = function (d) {
		datas.push(d);
		setsn();
	};
	var update = function (i, d) {
		datas[i] = d;
		setsn();
	};
	var remove = function (i) {
		datas.splice(i, 1);
	};
	var getinput = function (i) {
		return datas[i];
	};
	var initdata = function (oridata) {
		datas = datas.concat(oridata);
		setsn();
	};
	return {
		get : getinput,
		update : update,
		append : append,
		remove : remove,
		refresh : refresh,
		init : initdata,
		getnextsortnumber : getnextsortnumber,
		checkdata : checkdata,
		getdatas : getdatas
	}
})();

require(['jquery', 'util', 'json2'], function ($, u) {
	$(document).ready(function () {
		$(document).on("click", ".editinput", function () {
			var key = $(this).attr("data");
			if (!key) {
				key = -1;
			}
			$("input[name='key']").val(key);
			key = parseInt(key);
			if (key >= 0) {
				var d = tb.get(key);
				$("input[name='inputtitle']").val(d.title);
				$("input[name='desc']").val(d.desc);
				$("input[name='inputtype']:checked").prop("checked", false);
				$("input[name='inputtype'][value='" + d.inputtype + "']").prop("checked", true);
				$("input[name='checktype']:checked").prop("checked", false);
				$("input[name='checktype'][value='" + d.checktype + "']").prop("checked", true);
				if (d.isneed == 1) {
					$("input[name='isneed']").prop("checked", true);
				} else {
					$("input[name='isneed']").prop("checked", false);
				}
				$("input[name='sortnumber']").val(d.sortnumber);
				$("input[name='errormsg']").val(d.errormsg);
				$("textarea[name='options']").val(d.options.join(";\r"));
				if (d.inputtype == 3 || d.inputtype == 4) {
					$("#optiongroup").show();
				} else {
					$("#optiongroup").hide();
				}
			} else {
				$("input[name='inputtitle']").val("");
				$("input[name='desc']").val("");
				$("input[name='inputtype']:checked").prop("checked", false);
				$("input[name='inputtype'][value='1']").prop("checked", true);
				$("input[name='checktype']:checked").prop("checked", false);
				$("input[name='checktype'][value='0']").prop("checked", true);
				$("input[name='isneed']").prop("checked", false);
				$("input[name='sortnumber']").val(tb.getnextsortnumber());
				$("input[name='errormsg']").val("");
				$("textarea[name='options']").val("");
				$("#optiongroup").hide();
			}
			$("#myModal").modal("show");
		});
		$(document).on("click", ".removeedit", function () {
			var key = $(this).attr("data");
			key = parseInt(key);
			if (key >= 0) {
				tb.remove(key);
				tb.refresh();
				var dts = tb.getdatas();
				var s = JSON.stringify(dts);
				$("#forms").val(s);
			}
		});
	});

	$(document).ready(function () {
		//初始化表单
		var inputs = $("#forms").val();
		if (inputs.length == 0) {
			return;
		}
		inputs = eval("(" + inputs + ")");
		tb.init(inputs);
		tb.refresh();
	});

	$("#saveinput").click(function () {
		var key = $("input[name='key']").val();
		var title = $("input[name='inputtitle']").val();
		var desc = $("input[name='desc']").val();
		var inputtype = $("input[name='inputtype']:checked").val();
		var checktype = $("input[name='checktype']:checked").val();
		var isneed = $("input[name='isneed']").prop('checked') ? 1 : 0;
		var sortnumber = $("input[name='sortnumber']").val();
		var errormsg = $("input[name='errormsg']").val();
		var t = $("textarea[name='options']").val();
		t = t.replace(/\r/g, "");
		t = t.replace(/\n/g, "");
		t = t.replace(/；/g, ";");
		var options = t.split(";");
		for (var k in options) {
			if (options[k].length == 0) {
				options.splice(k, 1);
			}
		}
		var d = {
			title : title,
			desc : desc,
			inputtype : parseInt(inputtype),
			checktype : parseInt(checktype),
			isneed : parseInt(isneed),
			sortnumber : parseInt(sortnumber),
			errormsg : errormsg,
			options : options
		};
		var r = tb.checkdata(d);
		if (r.length > 0) {
			alert(r);
			return;
		}
		if (key < 0) {
			tb.append(d);
		} else {
			tb.update(key, d);
		}
		tb.refresh();
		var dts = tb.getdatas();
		var s = JSON.stringify(dts);
		$("#forms").val(s);
		$("#myModal").modal("hide");
	});

	$("input[name='inputtype']").click(function () {
		var inputtype = $("input[name='inputtype']:checked").val();
		if (inputtype == 3 || inputtype == 4) {
			$("#optiongroup").show();
		} else {
			$("#optiongroup").hide();
		}
	});
});
