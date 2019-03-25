/*运费模板*/

$(function(){

	//添加一个地区
	$('#add_express').click(function(){
		var addstr = 
						'<div class="edit_right_item item_cell_box align_center">'
							+'<li class="item_cell_flex express_btn_out">'
									+'<div class="area_item">'
										+'<span class="font_13px_999"></span>'
									+'</div>'
								+'<a href="javascript:;" class="edit_province" >编辑地区 </a>'
								+'<input type="hidden" name="express[area][]" class="area_value_input"  value="" />'
								+'<a href="javascript:;" class="btn_44b549 delete_express">删除</a>'
							+'</li>'
							+'<li class="express_btn_money">'
								+'<span class=""> 下单量 </span>'
								+'<span class="frm_input_box frm_input_box_70">'
									+'<input type="text" class="frm_input"  name="express[num][]" value="">'
								+'</span>'
								+'<span class=""> 件内，邮费 </span>'
								+'<span class="frm_input_box frm_input_box_70">'
									+'<input type="text" class="frm_input"  name="express[money][]" value="">'
								+'</span>'
								+'<span class=""> 元，每增加 </span>'
								+'<span class="frm_input_box frm_input_box_70">'
									+'<input type="text" class="frm_input"  name="express[numex][]" value="">'
								+'</span>'
								+'<span class=""> 件，加邮费 </span>'
								+'<span class="frm_input_box frm_input_box_70">'
									+'<input type="text" class="frm_input"  name="express[moneyex][]" value="">'
								+'</span>'
								+'<span class=""> 元</span>'
							+'</li>'
						+'</div>';
		$('.group_express_box').append(addstr);
	});
	
	//删除地区选择项
	$('body').on('click','.delete_express',function(){
		$(this).parents('.edit_right_item').remove();
	});

	//编辑地区
	$('body').on('click','.edit_province',function(){
		$('.activity_editbox').removeClass('activity_editbox');
		var thisbox = $(this).parents('.edit_right_item');
		thisbox.addClass('activity_editbox');
		initAreaData();
		$('.ui-draggable').show();
	});
	
	//关闭操作框
	$('.close_this').click(function(){
		hideAreaTable();
	});
	
	
	//删除相应的选项
	$('body').on('click','.express_box .as_scope_del',function(){
		var name = $(this).attr('data-name');
		$('.jsLevel2').each(function(){
			if($(this).attr('data-name') == name){
				$(this).removeClass('disabled');
			}
		});		
		$(this).parents('.selected_scope_item').remove();
		
	});
	
	//全选当前省份下的城市
	$('body').on('click','.express_box .father_menu .show_sub_icon',function(){
		var thisclass = $(this).parents('dd');
		var needarray = [];
		thisclass.find('.jsLevel2').each(function(){
			if(!$(this).hasClass('disabled')){
				$(this).addClass('disabled');
				var value = $(this).attr('data-name');
				needarray.push(value);
			}
		});
		addToSelectedList(needarray);
	});
	

	
	//展开二级城市
	$('body').on('click','.express_box .jsLevel1',function(){
		if($(this).parent().siblings().is(":visible")){
			$(this).parent().siblings().hide();
		}else{
			$(this).parent().siblings().show();
		}
	});
	//添加城市
	$('body').on('click','.express_box .jsLevel2',function(){
		if($(this).hasClass('disabled')) return false;
		var name = $(this).attr('data-name');
		$(this).addClass('disabled');
		
		var	str = '<li class="selected_scope_item jsItem " data-name="'+name+'" >'
							+'<span class="item_name">'+name+'</span>'
							+'<a href="javascript:;" class="as_scope_del jsClose" data-name="'+name+'">×</a>'
						+'</li>';
		
		$('.jsToList').append(str);
		
	});	
	
	//确定选择城市
	$('.express_box #confirm_inexpress').click(function(){
		var namearray = '';
		$('.selected_scope_item').each(function(){
			namearray += $(this).attr('data-name')+',';
		});
		$('.activity_editbox').find('.area_item span').text(namearray);
		$('.activity_editbox').find('.area_value_input').val(namearray);
		hideAreaTable();
	});
	
	//提交
	$("form").submit(function(e){
		var expressname = $('input[name=expressname]').val();
		if(expressname == ''){
			webAlert('请填写模板名称');
			return false;
		}
		var isempty = 0;
		$('.edit_right_list input').each(function(){
			if($(this).val() == ''){
				isempty = 1;return;
			}
		});
		if(isempty == 1){
			webAlert('区域运费不能存在空项');
			return false;
		}
	});
	
	//插入到已选择列表
	function addToSelectedList(array){
		var selectedstr = '';
		for(var i =0;i<array.length;i++){
			selectedstr += '<li class="selected_scope_item jsItem " data-name="'+array[i]+'" >'
							+'<span class="item_name">'+array[i]+'</span>'
							+'<a href="javascript:;" class="as_scope_del jsClose" data-name="'+array[i]+'">×</a>'
						+'</li>';
		}
		$('.jsToList').append(selectedstr);
	};
	
	function hideAreaTable(){
		$('.jsLevel2').each(function(){
			$(this).removeClass('disabled');
		});
		$('.ui-draggable').hide();		
	};
	
	//初始数据
	function initAreaData(){
		if($('.js_dd_list').html() == ''){
			var str = '';
			for(var i= 0;i<areadata.length;i++){
				var strin = '';
				for(var j=0;j<areadata[i].sub.length;j++){
					strin += '<ul class="sub_scope_list" style="display:none">'
								+'<li>'
									+'<a data-id="'+areadata[i].sub[j].id+'" data-name="'+areadata[i].sub[j].name+'" href="javascript:;" class="jsLevel jsLevel2">'+areadata[i].sub[j].name+'</a>'
								+'</li>'
							+'</ul>';
				}
				
				str += '<dd>'
							+'<a href="javascript:;" class="jsLevel father_menu" data-id="'+areadata[i].id+'" data-name="'+areadata[i].name+'">'
								+'<i class="jsToggle sub_icon show_sub_icon">+</i>'
								+'<span class="item_name jsLevel1">'+areadata[i].name+'</span>'
							+'</a>'
							+strin
						+'</dd>';				
			}
			$('.js_dd_list').html(str);
			
		};
		
		//所有已选择的 设置不能再选择
		var selected= '';
		$('.area_value_input').each(function(){
			selected += $(this).val();
		});
		selected = selected.replace(/,$/,'');
		selectedArray = selected.split(","); //其余的值,数组		
	
		$('.jsLevel2').each(function(){
		
			for(var i=0;i<selectedArray.length;i++ ){
				if($(this).attr('data-name') == selectedArray[i]){
					$(this).addClass('disabled');
				}
			}
		});		
		
		
		//当前已选择的值 插入到已选择列表
		var thisselected = $('.activity_editbox').find('.area_value_input').val();

		$('.jsToList').empty();
		if(thisselected != ''){
			thisselected = thisselected.replace(/,$/,'');
			selectedArray = thisselected.split(",");
			
			addToSelectedList(selectedArray);
		}
	};	
	
	
});
/* 运费模板结束 */