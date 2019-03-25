(function(a){
	//全局常量
    SC = {
    		BASE_URL:'',
    		THEME_URL:'',
    		PLAY_URL:'',
    		GET_MORE_LIST:'',
    		PAY_URL:'',
    		COMMT_URL:''
	};
    
    SC_STATE ={
    	code_success:20000,
    	code_param_null:30000,
    	code_account_notexist:30005,
    	code_form_element_error:30009,
    	msg_unknown:'发生未知错误，请重试！',
    };
    
    //全局工具
    SCTOOLS = {
        trim:function(str){
            return str.replace(/(^\s*)|(\s*$)/g,
                "").replace(/(^\u3000*)|(\u3000*$)/g,"")
        },
        empty:function(str){
            return void 0===str||null===str||""===str
        },
        emptyObj:function(obj){
            for(var c in obj)return!1;
            return!0
        },
        createUrl:function(route, params){
            var paramStr = '';
            for (var key in params) {
            	var k = '&';
            	if(paramStr == '' && route.indexOf('?')==-1){
            		k = '?';
            	}
                paramStr += k+key+'='+params[key];
            };
            //return SC.BASE_URL + '/index.php?r=' + route + paramStr;
            return SC.BASE_URL+ "" + route + paramStr;
        },
        
        checkAjaxResult:function(result,showbox){
            if(SCTOOLS.empty(result)){
                bootbox.alert(SC_STATE.msg_unknown);
                return false;
            }
            if(result.state.code != SC_STATE.code_success){
            	if(showbox==null || showbox==true){
            		//bootbox.alert(result.state.msg);
            		layer.open({
            	    	title:'信息提醒',
            	    	content: result.state.msg,
            			yes: function(index, layero){
            				layer.close(index); //如果设定了yes回调，需进行手工关闭
            			}
            		});
            		return false;
            	}
                return false;
            }
            return true;
        },

    };
    
    a('#sidebar').delegate('.nav-sidebar li', 'click', function(e) {
        if(a(this).hasClass('active')) {
            return false;
        }
        a('#sidebar').find('.active').removeClass('active');
        a(this).addClass('active');
    });
    
} )(jQuery);


