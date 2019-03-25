$(function(){

	common();
	queueueue();
	// 计划任务
	function queueueue(){
		Http('post','html','queue',{},function(data){},false);
		setInterval(function(){
			Http('post','html','queue',{},function(data){},false);
		},10000);		
	}
	
	// 拖拽
	$( ".multi-img-details" ).sortable();
	$( ".multi-img-details" ).disableSelection();	


	// 选择区域
	$('body').on('click','#js_selectarea_opt a',function(){
		var  obj = new areaSelect($(this).next());
		obj.init();
		$('.ui-draggable').show();
	});

	// 管理员
	$('#add_admin').click(function(){
		var html = '<div class="edit_right_item admin_item">'
						+'管理员昵称<span class="frm_input_box frm_input_box_150">'
							+'<input type="text" class="frm_input"  name="adminnick[]" value="">'
							+'<input type="hidden" class="frm_input"  name="adminhead[]" value="">'
							+'<input type="hidden" class="frm_input"  name="adminopenid[]" value="">'
						+'</span>'
						+'<a href="javascript:;" class="search_admin"> 搜索</a> 管理员头像 '
						+'<span class="frm_input_box_150" style="display: inline-block;">'
							+' <img src="" width="40px" height="40px">'
						+'</span>'
						+'<a href="javascript:;" class="delete_params"> 删除</a>'
					+'</div>';
		$('.group_admin_box').append(html);
	});

	$('body').on('click','.search_admin',function(){
		var _this = $(this);
		var postdata = {
			nick : _this.parents('.admin_item').find('input[name="adminnick[]"]').val()
		};
		Http('post','json','findadmin',postdata,function(data){
			if(data.status == 200){
				_this.prev().find('input[name="adminnick[]"]').val(data.obj.nick).next().val(data.obj.headimgurl).next().val(data.obj.openid);
				_this.next().find('img').attr('src',data.obj.headimgurl);
				webAlert('已搜索到，保存后才生效');
			}else{
				webAlert(data.res);
			}
		},true);
	});


	// 添加ip拦截区域
	$('#addiparea').click(function(){
		$(this).hide();
		$(this).prev().show();
	});

	$('#confirm_addiplimit').click(function(){
		var name = $('#iplimit_name').val();
		if( name == '' ) return false;
		var str = '<label class="frm_checkbox_label selected" > '
		     			+'<i class="icon_checkbox"></i> '
		     			+'<span class="lbl_content">'+name+'</span> '
		     			+'<input type="checkbox" class="frm_checkbox" checked value="'+name+'" name="iplimit[]" /> '
		     		+'</label>';
		$('.iplimit_list').append(str);
	});

	// 增减余额
	$('.confirm_copyrule').click(function(){
		var $this = $(this);
		var parent = $this.parents('.jsDropdownsList')
		var data = {
			money : parent.find('input[name=money]').val(),
			uid : $(this).attr('id')
		};
		
		if(data.money == '' || data.money == 0 ||  !/\d/.test(data.money) ){
			webAlert('请填写正确的数值');
			return false;
		}
		if(confirm('确定要操作吗？')){
			Http('post','json','editmoney',data,function(data){
				if(data.status == 200){
					webAlert('操作成功');
					setTimeout(function(){
						location.href = "";
					},500);
				}else{
					webAlert(data.res);
				}
			},true);
		}

	})

	//复制团购
	$('.copy_good').click(function(){

		var $this = $(this);
		var data = {
			id : $this.attr('oid')
		};
		
		Http('post','json','copygood',data,function(data){
			if(data.status == 200){
				webAlert(data.res);
				setTimeout(function(){
					location.href = "";
				},500);
			}else{
				webAlert(data.res);
			}
		},true);
	});

	// 复制链接
	require(['jquery.zclip'], function(){
		$('.copy_url').zclip({
			path: './resource/components/zclip/ZeroClipboard.swf',
			copy: function(){
				return $(this).attr('data-href');
			},
			afterCopy: function(){
				webAlert('复制成功');
			}
		});
	});	
	// 清理缓存
	$('.deletecache').click(function(){
		var type = $(this).attr('type');
		if(confirm('确定删除吗？')){
			Http('post','html','deletecache',{type:type},function(data){
				if(data == 1){
					webAlert('已删除');
				}else{
					webAlert('删除失败');
				}
			},true);
		}
	});
	//设置计划任务
	$('.queue_btn').click(function(){
		Http('post','json','setqueue',{},function(data){
			if(data.status == 200){
				webAlert('已设置');
			}else{
				webAlert('设置异常，删除缓存然后再试下。');
			}
		},true);
	});


	// 导入数据 改变显示文字
	$('input[name=inputfile]').change(function(){
		var v = $(this).val();
		$(this).prev().text(v);
	});


	// 编辑排序
	var nowvalue;
	$('.edit_number_input').focus(function(){
		$(this).addClass('edit_number_input_act');
		nowvalue = $(this).val();
	});
	$('.edit_number_input').blur(function(){
		$(this).removeClass('edit_number_input_act');
		if(nowvalue == $(this).val()) return false;
		var data = {
			type : $(this).attr('inputtype'),
			value : $(this).val(),
			name : $(this).attr('inputname'),
			id : $(this).attr('id')
		};
		Http('post','html','editvalue',data,function(data){},true);
	});


	// 搜索
	$('.js_search').click(function(){
		$(this).parents('form').submit();
	});

	// 拉黑和恢复
	$('.edit_user').click(function(){
		var data = {
			type : $(this).attr('type'),
			id : $(this).attr('id')
		};
		if(confirm('确定执行操作吗？')){
			Http('post','html','edituser',data,function(data){
				if(data == 1){
					alert('操作完成');
					location.href = "";
				}else{
					alert('操作失败');
				}
			},true);
		}
	});


	

	// 切换参数设置
	$('.js_top').click(function(){
		$('.js_top').removeClass('selected');
		var thisclass = $(this).attr('showme');
		$(this).addClass('selected');
		$('.settings_group').each(function(){
			if($(this).hasClass(thisclass)){
				$(this).show();
			}else{
				$(this).hide();
			}
		})
	});


})

	function common(){

		//点击相应位置隐藏筛选/下拉
		$('body').on('click',function(e) {
			if($(e.target).parents('.dropdown_topbar').length <= 0){
				$('.dropdown_menu').each(function(){
					var $this = $(this);
					if($this.hasClass('open')) $this.removeClass('open');
				})
			}
		});	

		// table内编辑框
		$('.drop_down_editbtn').click(function(){
			$('.jsDropdownsList').hide();
			$(this).next().find('.jsDropdownsList').toggle();
		})
		$('body').on('click','.dropdown_edit_cancel',function(){
			$(this).parents('.jsDropdownsList').hide();
		});

		// 自动选择单选框
		$('.frm_radio').each(function(){
			var $this = $(this);
			if($this.attr('checked')){
				$this.parents('.frm_radio_label').addClass('selected');
			}
		});
		$('.frm_checkbox').each(function(){
			var $this = $(this);
			if($this.attr('checked')){
				$this.parents('.frm_checkbox_label').addClass('selected');
			}
		});		

		// checkbox
		$('body').on('click','.frm_radio_label',function(e){
			e.preventDefault();
			
			var $this = $(this);
			var name = $this.find('input[type=radio]').prop('name');
			
			$('input[name='+name+']').each(function(){
				$(this).prop('checked',false);
				$(this).parents('.frm_radio_label').removeClass('selected');
			})
			$this.addClass('selected').find('input').prop('checked',true);
		});


		// 复选框 包括全选
		$('body').on('click','.frm_checkbox_label',function(e){
			var checkbox = $(this).find('input[type=checkbox]');
			var isall = $(this).prop('for') == 'selectAll';
			if(checkbox.prop("checked")){
				checkbox.prop("checked",false);
				$(this).removeClass('selected');
				if(isall){
					$('tbody input[type=checkbox]').each(function(){
						$(this).parents('.frm_checkbox_label').removeClass('selected');
						$(this).prop("checked",false);
					})
				}
			}else{
				checkbox.prop("checked",true);
				$(this).addClass('selected');
				if(isall){
					$('tbody input[type=checkbox]').each(function(){					
						$(this).parents('.frm_checkbox_label').addClass('selected');
						$(this).prop("checked",true);
					})
				}
			}
			e.preventDefault();
		});


		// 下拉
		$('body').on('click','.dropdown_menu',function(e){
			var $this = nowdropdown = $(this);
			if($this.hasClass('open')){
				$this.removeClass('open');
			}else{
				$this.addClass('open');
				$('.dropdown_menu').not(this).each(function(){
					if( $(this).hasClass('open') ) $(this).removeClass('open');
				})
			}
		});

		// 切换
		$('body').on('click','.change_item .frm_radio_label',function(){
			var item = $(this).parents('.change_item').attr('item');
			$('.'+item).hide();
			var show = $(this).attr('show');
			$('.'+show).show();		
		});
		
		// select
		$('.select_item').click(function(){
			var id = $(this).attr('id');
			var text = $(this).text();
			var parent = $(this).parents('.dropdown_menu');
			parent.find('input').val(id);
			parent.find('.jsBtLabel').text(text);
		})

	};


	function webAlert(str){
		if($('#webalert').length > 0){
			$('#webalert .alertcontent').text(str);
			alertShow();
		}else{
			var div = '<div id="webalert" style="position:fixed;z-index:99999;top:20px;left:50%;width:500px;height:35px;margin-left:-250px;background:red;">\
					<div class="alertcontent" style="font-size: 16px;color:#fff;text-align:center;line-height: 35px;">'+str+'</div></div>';
			$('body').append(div);
			alertShow();
		}
	};

	function alertShow() {
		$('#webalert').show('fast',function(){
			setTimeout(function(){$('#webalert').hide();},3000);
		})
	};

	//http请求
	 function Http(type,datatype,op,data,successCall,isloading,beforeCall,comCall){
		$.ajax({
			type: type,
			url: ajaxUrl(op),
			dataType: datatype,
			data : data,
			beforeSend:function(){
				if(beforeCall) beforeCall();
				if(isloading) loading();
			},
			success: function(data){
				if(successCall) successCall(data);
			},
			complete:function(){
				if(comCall) comCall();
				if(isloading) loaded();
			},				
			error: function(xhr, type){
				console.log(xhr);
			}
		});	
	};

	function ajaxUrl(op){
		return window.sysinfo.siteroot + 'web/index.php?c=site&a=entry&op='+op+'&do=ajax&m=zofui_timeredbag';
	};
	
	function loading(){
		var html = 
			'<div id="loading" class="loading">'+
			'<div class="load_mask"></div>'+
			'<div class="modal-loading">'+
			'	<div class="modal-loading-in">'+
			'		<img style="width:48px; height:48px;" src="../attachment/images/global/loading.gif"><p>处理中，勿关闭本页</p>'+
			'	</div>'+
			'</div>'+
			'</div>';
		$(document.body).append(html);
	};
	
	function loaded(){
		$('.loading').remove();
	};


	/***地区选择***/
	function areaSelect (element) {
		//if(typeof areaSelect.areaobj === 'object') return areaSelect.areaobj;
		this.elem = element;
		//areaSelect.areaobj = this;
		this.bindEvent();
	};

	areaSelect.prototype.init = function(){
		var self = this;
		if ($('.delivery_privince .js_dd_list').html() == ''){		
			var province = '';
			for(var i=0;i<citydata.length;i++){
				province += '<dd>'
								+'<a href="javascript:;" class="jsLevel father_menu jsLevel1" data-name="'+citydata[i].text+'">'
									+'<span class="item_name">'+citydata[i].text+'</span>'
								+'</a>'
							+'</dd>';
			}
			$('.delivery_privince .js_dd_list').html(province);
		}
		
		var provincevalue = self.elem.find('.area_province_input').val();

		if(provincevalue != ''){
			var cityvalue = self.elem.find('.area_city_input').val();
			var countyvalue = self.elem.find('.area_county_input').val();
			
			$('.jsLevel1').each(function(){	
				if($(this).attr('data-name') == provincevalue) $(this).addClass('selected');
			});
			
			self.appendCityStr(provincevalue,cityvalue); //城市

			countyvalue = countyvalue.replace(/,$/,'');
			countyarray = countyvalue.split(","); //数组
			
			self.appendCountyStr(provincevalue,cityvalue,countyarray); //区县
		}else{
			$('.delivery_city .js_dd_list').empty();
			$('.delivery_county .js_dd_list').empty();
		}

	};

	areaSelect.prototype.bindEvent = function(){
		var self = this;
		//点击一级展开二级
		$('body').off('click','.delivery_box .jsLevel1').on('click','.delivery_box .jsLevel1',function(){
			var province = $(this).attr('data-name');
			$('.delivery_privince .selected').removeClass('selected');
			$(this).addClass('selected');
			self.appendCityStr(province,'');
		});		
		//点击二级展开三级
		$('body').off('click','.delivery_box .jsLevel2').on('click','.delivery_box .jsLevel2',function(){
			var province = $(this).attr('data-province'),
				city = $(this).attr('data-name');
			$('.delivery_city .selected').removeClass('selected');
			$(this).addClass('selected');
			self.appendCountyStr(province,city,[]);
		});	

		//选择区县
		$('body').off('click','.delivery_box .jsLevel3').on('click','.delivery_box .jsLevel3',function(){

			if($(this).hasClass('disabled')) return false;
			/*var province = $(this).attr('data-province'),
				city = $(this).attr('data-city'),
				county = $(this).attr('data-name');*/

			if($(this).hasClass('selected')){
				$(this).removeClass('selected');
			}else{
				$(this).addClass('selected');
			}
		});	
	
		//确定选择
		$('#confirm_indelivery').off('click').on('click',function(){

			var province = '',
				city = '',
				county = '';
			$('.delivery_county .selected').each(function(){
				province = $(this).attr('data-province');
				city = $(this).attr('data-city');
				county += $(this).attr('data-name') + ',';
			});
		
			self.elem.find('.area_province_input').val(province).next().val(city).next().val(county);
			self.elem.find('.delivery_item_province').text(province).next().text(city).next().text(county);
			self.hideDeliveryTable();
		});
		
		
		//关闭操作框
		$('.delivery_close').off('click').on('click',function(){
			self.hideDeliveryTable();
		});			
		
	};
	
	//插入城市数据
	areaSelect.prototype.appendCityStr = function (province,city){
		
		for(var i=0;i<citydata.length;i++){
			if(citydata[i].text == province){
				var citystr = '';
				for(var j=0;j<citydata[i].children.length;j++){
					var selectstr = '';
					if(city == citydata[i].children[j].text) selectstr = 'selected';
					citystr += '<dd>'
									+'<a href="javascript:;" class="jsLevel father_menu jsLevel2 '+selectstr+'" data-province="'+province+'" data-name="'+citydata[i].children[j].text+'">'
										+'<span class="item_name">'+citydata[i].children[j].text+'</span>'
									+'</a>'
								+'</dd>';
					
				}
				$('.delivery_city .js_dd_list').html(citystr);
				$('.delivery_county .js_dd_list').empty();
				return false;
			}
		}		
		
	};
	
	areaSelect.prototype.appendCountyStr = function (province,city,countyarray){
		//已经选择了的地区，
		var selectedcountystr = '';
		$('.area_county_input').each(function(){
			selectedcountystr += $(this).val() + ',';
		});
		selectedcountystr = selectedcountystr.replace(/,$/,'');
		selectedcountystr = selectedcountystr.split(","); //数组
		
		for(var i=0;i<citydata.length;i++){
			if(citydata[i].text == province){
				for(var j=0;j<citydata[i].children.length;j++){			
					if(citydata[i].children[j].text == city){
						var county = '';
						for(var k=0;k<citydata[i].children[j].children.length;k++){
							if($.inArray(citydata[i].children[j].children[k], countyarray) >= 0  || $.inArray(citydata[i].children[j].children[k], selectedcountystr) < 0 ){
								var selectedstr = '';
								if( $.inArray(citydata[i].children[j].children[k], countyarray) >= 0 ) selectedstr = 'selected';
								
								county += '<dd>'
												+'<a href="javascript:;" class="jsLevel father_menu jsLevel3 '+selectedstr+'" data-province="'+province+'" data-city="'+city+'" data-name="'+citydata[i].children[j].children[k]+'">'
													+'<span class="item_name">'+citydata[i].children[j].children[k]+'</span>'
												+'</a>'
											+'</dd>';								
							}
						}
						
						$('.delivery_county .js_dd_list').html(county);
						return false;						
					}
				}
			}
		}
	};
	
	areaSelect.prototype.hideDeliveryTable = function (){
		$('.delivery_box .selected').removeClass('selected');
		$('.ui-draggable').hide();
		self = null;
	};
