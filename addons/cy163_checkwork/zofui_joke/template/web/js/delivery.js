/******自提模板******/
$(function(){


	//增加一个门店
	$('body').on('click','.add_a_shop',function(){
		var num = $(this).attr('data-no');
		var str = 
				'<div class="item_cell_box express_btn_money shop_item">'
					+'<li class="item_cell_flex">'
						+'<span class="">店铺名称 </span>'
						+'<span class="frm_input_box frm_input_box_150">'
							+'<input type="text" class="frm_input"  name="shop['+num+'][name][]" value="">'
						+'</span>'
						+'<span class=""> 电话 </span>'
							+'<span class="frm_input_box frm_input_box_150">'
							+'<input type="text" class="frm_input"  name="shop['+num+'][tel][]" value="">'
							+'</span>'
							+'<span class=""> 地址 </span>'
							+'<span class="frm_input_box">'
							+'<input type="text" class="frm_input"  name="shop['+num+'][address][]" value="">'
							+'</span>'
							+'</li>'
						+'<li>'
						+'<span class="btn btn_warn btn_small delete_thisshop">删除</span>'
					+'</li>'
				'</div>'
		$(this).prev().append(str);
	});
	
	//删除门店
	$('body').on('click','.delete_thisshop',function(){
		if( $(this).parents('.shop_list').find('.shop_item').length <= 1 ){
			$(this).parents('.delivery_in_box').remove();
			return false;
		}
		$(this).parents('.shop_item').remove();
	});	
	
	

	//增加一个区域
	$('#addarea_selftake').click(function(){
		var num = $('.delivery_in_box').length;
		var addstr = 	'<div class="edit_right_item delivery_in_box">'
							+'<div class="express_btn_out">'
						   		+'<font class="" id="js_selectarea_opt">'
						   			+'<a href="javascript:;" >选择区域</a>'
						   			+'<span class="areacontent font_13px_999">'
							   			+'<input name="deliveryprovince[]" class="area_province_input" value="" type="hidden">'
							   			+'<input name="deliverycity[]" class="area_city_input" value="" type="hidden">'
							   			+'<input name="deliverycounty[]" class="area_county_input" value="" type="hidden">'
							   			+' <span class="delivery_item_province"></span> '
							   			+' <span class=""></span> '
							   			+' <span class=""></span> '
						   			+'</span>'
						   		+'</font>'
							+'</div>'
							+'<div class="shop_list">'
								+'<div class="item_cell_box express_btn_money shop_item">'
									+'<div class="item_cell_flex">'
										+'<span class=""> 店铺名称 </span>'
										+'<span class="frm_input_box frm_input_box_150">'
											+'<input type="text" class="frm_input"  name="shop['+num+'][name][]" value="">'
										+'</span>'
										+'<span class=""> 电话 </span>'
										+'<span class="frm_input_box frm_input_box_150">'
											+'<input type="text" class="frm_input"  name="shop['+num+'][tel][]" value="">'
										+'</span>'
										+'<span class=""> 地址 </span>'
										+'<span class="frm_input_box">'
											+'<input type="text" class="frm_input"  name="shop['+num+'][address][]" value="">'
										+'</span>		'
									+'</div>'
									+'<div>'
										+'<span class="btn btn_warn btn_small delete_thisshop">删除</span>'
									+'</div>'
								+'</div>	'
							+'</div>'
							+'<a href="javascript:;" class="add_a_shop" data-no="'+num+'">增加店铺</a>'
						+'</div>'
		$('.group_express_box').append(addstr);
	});
	
	
	//提交
	$('input[name=adddselftake').click(function(){
		var deliveryname = $('input[name=deliveryname]').val();
		if(deliveryname == ''){
			alert('请填写模板名称');return false;
		}
		//判断是否有重复编号
		var noarray = [];
		$('.shop_no').each(function(){
			noarray.push($(this).val());
		});
		var oldlength = noarray.length;
		$.unique(noarray)
		if(oldlength != noarray.length){
			alert('模板编号不能重复');return false;
		}
		
		var isempty = 0;
		$('.delivery_item_main input').each(function(){
			if($(this).val() == ''){
				isempty = 1;return;
			}
		});
		if(isempty == 1){
			alert('不能存在空项');return false;
		}
	});		
	
});
/******自提模板结束******/