
var _emo= {
    _text: ["[笑]", "[感冒]", "[流泪]", "[发怒]", "[爱慕]", "[吐舌]", "[发呆]", "[可爱]", "[调皮]", "[寒]", "[呲牙]", "[闭嘴]", "[害羞]", "[苦闷]", "[难过]", "[流汗]", "[犯困]", "[惊恐]", "[咖啡]", "[炸弹]", "[西瓜]", "[爱心]", "[心碎]"],
    _indexOf: function(text) {
        if (_emo._text.indexOf) {
            return _emo._text.indexOf(text);
        }
        for (var i = 0, _len = _emo._text.length; i < _len; i++) {
            if (_emo._text[i] == text) {
                return i;
            }
        }
        return -1;
    },
    _insertFun: null,
    _show: function(id, fun) {
        _emo._insertFun = fun;
        if ($("#" + id).children().length == 0) {
            var _html = "<ul>";
            for (var i = 0; i < 23; i++) {
                _html += "<li class='emo' ontouchstart='' onclick='_emo._insert(" + i + ")'><img src='" + _imgCdn + "face/" + (i + 1) + ".png'></li>";
            }
            _html += "</ul>";
            $("#" + id).html(_html);
        }
        $("#" + id).show();
    },
    _hide: function(id) {
        $("#" + id).hide();
    },
    _insert: function(index) {
        (_emo._insertFun)(index);
		var btn = $("#dt_review_form_post");
		if (btn.attr('class')=='button_1_disabled') {
            btn.removeClass("button_1_disabled");
        }
 
    },
    _toCode: function(content) {
        return content.replace(/\[[\u4e00-\u9fa5]{1,2}\]/g, function(a) {
            var _code = _emo._indexOf(a) + 1;
            return _code == 0 ? a : "[/" + _code + "]";
        });
    }
};

/**评论框*/
var _reviewBox = {
  _currentTop: 0,
  _iosSet: function() {
    var y = $(window).height();
    _reviewBox._currentTop = $(document).scrollTop();
    document.body.scrollTop = 0;
    $("body").css({"height": y + _reviewBox._currentTop + "px","overflow": "hidden","margin-top": -_reviewBox._currentTop + "px"});
    $("#cover2").height(y);
  },
  _show: function(uName, nick) {
    /*var _thisNext = _info._type.replace(_info._type, function($1) {
      return $1 ? ($1.substring(0, 1).toUpperCase() + $1.substring(1)) : '';
    });*/
    //_cover._show("cover2");
	$("#cover2").show();
    $("#dt_review_box").show();
    _reviewBox._inputed();
    if (navigator.userAgent.match(/ipad|iphone|ipod/i) != null) {
      $("#dt_review_form_content").focus();
    } else {
      _reviewBox._iosSet();
    }
    $("#cover2").bind("click", _reviewBox._hide);
  },
  _hide: function() {
    if (_user._useIOs()) {
      $("body").css({"height": "auto","overflow": "auto","margin-top": "0px"});
    }
    _cover._hide("cover2");
    $("#dt_review_box").hide();
    _emo._hide("dt_review_box_emo");
    $("body").css({"height": "auto","overflow": "auto"});
  },
  
  _touch: function() {
    if (!_user._useIOs()) {
      return;
    }
    $("#cover2").unbind("click");
    setTimeout(function() {
      $("#cover2").bind("click", _reviewBox._hide);
    }, 1000);
    _emo._hide("dt_review_box_emo");
    $("#dt_review_form_content").focus();
  },
  _focus: function() {
    if (_user._useIOs()) {
      return;
    }
    _emo._hide("dt_review_box_emo");
    with($("#dt_review_form_content")) {
      var _value = $("#dt_review_form_content").val();
      $("#dt_review_form_content").val("");
      $("#dt_review_form_content").val(_value);
    }
  },
  _blur: function() {
    _reviewBox._setTemp("review_content", $("#dt_review_form_content").val());
    _reviewBeforeLogin._setTemp("review_replyUid", _review._replyUid);
  },
  /*_inputed: function() {
	if(Trim($("#dt_review_form_content").val(),'g')==''){
			$("#dt_review_form_post").attr("class",'button_1');
	}else{
			$("#dt_review_form_post").attr("class",'button_1_disabled');
	}
  },*/
  _setTemp: function(key, value) {
    _t._set(key + "_" + _info._type + "_" + _info._id + "_" + _review._replyUid, value);
  },
  _getTemp: function(key) {
    return _t._get(key + "_" + _info._type + "_" + _info._id + "_" + _review._replyUid);
  },
  _showEmo: function() {
	 if($("#dt_review_box_emo").css('display')=='none'){
		_emo._show("dt_review_box_emo", function(index) {
		  $("#dt_review_form_content").val($("#dt_review_form_content").val() + _emo._text[index]);
		  //_reviewBox._inputed();
		  //_reviewBox._blur();
		});
	 }else{
		_emo._hide("dt_review_box_emo");
	 }
  }
};
function Trim(str,is_global)
        {
            var result;
            result = str.replace(/(^\s+)|(\s+$)/g,"");
            if(is_global.toLowerCase()=="g")
            {
                result = result.replace(/\s/g,"");
             }
            return result;
}