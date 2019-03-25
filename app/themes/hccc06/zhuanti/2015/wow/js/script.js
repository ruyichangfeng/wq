$(function(){
    //定义常用变量
    function getRand(){
        return  parseInt(Math.random()*100000);
    }

    /**
     * 导航条
     */

    function init(){
        var sectionArray = $('.js-section');

        for(var i=0; i<sectionArray.length-1; i++){
            var objP = $(sectionArray[i])
                , objN = $(sectionArray[i+1]);
            if($(window).scrollTop()>= (objP.offset().top-200)
                && $(window).scrollTop()<(objN.offset().top-200)){
                $('.js-nav li').removeClass('active');
                $($('.js-nav li')[i]).addClass('active');
            }
        }
    }

    var flag = true;

    $(window).scroll(function(){
        if(flag){
            init();
        }
    });

    $('.js-nav li').click(function(){
        flag = false;
        $('.js-nav li').removeClass('active');
        $(this).addClass('active');
        $("html,body").animate({scrollTop:($('#'+$(this).attr('name')).offset().top-60)},500, function(){
            flag = true;
        });

    })

    function changeBanner(){
        if($(window).width() < 620){
            $('.section1 img').attr('src', '/zhuanti/2015/wow/image/mBanner.jpg?ver=20150226');
        }else{
            $('.section1 img').attr('src', '/zhuanti/2015/wow/image/banner.jpg?ver=201502261810');
        }
    }

    changeBanner();

    $(window).resize(function(){
        changeBanner();
    })

    $('.icon-meet').mouseenter(function(){
        $(this).find('span').css('display', 'block');
    })

    $('.icon-meet').mouseleave(function(){
        $(this).find('span').css('display', 'none');
    })



    /*var imgW = 1920;
    var imgBox = $('.section1')
        , imgBanner = imgBox.find('img')
        ;
    $(window).resize(function(){
        imgChange();
    });
    imgChange();
    function imgChange(){
        var width = $(window).width();
        if(width > 980){
            imgBox.css({'width':(width+'px'), 'overflow':'hidden'});
            imgBanner.css({'margin-left':((width-imgW)/2+'px'), 'max-width':('1920px')});
        }else{
            imgBox.css({'width':'auto','overflow':'visible'});
            imgBanner.css({'max-width':'100%', 'margin-left':'0'});
        }
    }*/



    //弹出案例信息
    $('body').on('click', '.js-rater-vote', function(){
        var btn = $(this)
            , oParent = btn.parents('.js-item-vote')
            , tid = oParent.attr('tid')
            , id = 'showVoteBox'
            , strTitle = oParent.find('.js-rater-title').html()
            , strBody
            , cmtItem = ''
            , url = '/ztcommentlist'
            , param = {
                is_ajax: 1
                , huxiu_hash_code: huxiu_hash_code
                , random: getRand()
                , tid: tid
                , zid: zt_id
            }
            ;

        var strEmail = '';
        if(uid == 0){
            strEmail =  '邮箱<input type="text" placeholder="请输入邮箱" />';
        }

        if($('.js-vote-box').hasClass('voted-box')){
            var strVote = '<button class="btn btn-vote voted" type="button">已结束</button>';
        }else{
            var strVote = '<button class="btn btn-vote js-btn-vote" type="button">投&ensp;票</button>';
            if($('#vote_item_'+tid).find('.js-btn-vote').hasClass('voted')){
                strVote = '<button class="btn btn-vote voted" type="button">已投票</button>';
            }else if(uid == 0){
                strVote = '<button class="btn btn-vote js-btn-login" type="button">投&emsp;票</button>';
            }
        }



        if(is_mobile == 1){
            $('#vote_item_'+tid).find('.js-box-left embed').parent().html('<a href="'+ $('#vote_item_'+tid).attr('url') +'" target="_self">点击观看</a>');
        }

        var  boxLeft = oParent.find('.js-box-left').html();

        if(boxLeft == undefined){
            boxLeft = $('#vote_item_'+tid).find('.js-box-left').html();
        }

        strBody =
            '<div class="d-cnt">' +
                '<div class="d-left">'+ boxLeft +'</div>' +
                '</div> '
        ;

        dialogShow(id, strTitle, strBody);

        $.post(url, param, function(data){
            data = eval('('+data+')');
            if(data.is_success == 1){

                var delHtml = '';
                if(uid == 1320027){
                    var delHtml = '<span class="btn btn-mini js-btn-del">删除</span>';
                }

                $.each(data.content, function(i, ele){
                    cmtItem +=  '<li class="clearfix js-cmt-item" pid="'+ ele.id +'">' +
                        '<div class="cmt-head"><img src="'+ ele.avatar +'" alt="评委头像"></div>' +
                        '<div class="cmt-cnt-box">' +
                        '<div class="cmt-rater">'+ ele.username +'：</div>' +
                        '<div class="cmt-cnt">'+ ele.comment + delHtml +'</div>' +
                        '</div>' +
                        '</li>'
                    ;

                });

            }else{
                cmtItem = '获取案例评论信息失败！';
            }
            $('#showVoteBox').find('.js-cmt-box').html(cmtItem)

        });

    });



    /**
     * 点击删除评论按钮
     */
    $('body').on('click', '.js-btn-del', function(){
        var btn = $(this)
            , oParent = btn.parents('.js-cmt-item')
            , url = '/zhuantis/del_update/ztcomment'
            , param = {
                is_ajax: 1
                , huxiu_hash_code: huxiu_hash_code
                , pid: oParent.attr('pid')
            }
        ;
        $.post(url, param, function(data){
            data = eval('('+data+')');
            if(data.is_success == 1){
                oParent.remove();
            }else{
                alert(data.msg);
            }
        })
    })

    /**
     * 点击发布评论按钮
     */
    $('body').on('click', '.js-btn-publish', function(){
        var btn = $(this)
            , oText = btn.parents('.js-d-cmt-box').find('textarea')
            , oEmail = btn.parents('.js-d-cmt-box').find('input')
            , oUl = btn.parents('.js-d-cmt-box').find('.cmt-box')
            , tid = btn.parents('.js-d-cmt-box').attr('tid')
            ;

        if(!btn.hasClass('disabled') && btn.hasClass('btn-publish-blue')){
            btn.addClass('disabled');

            if(oText.val() == ''){
                alert('评论内容不能为空！');
                btn.removeClass('disabled');
                return;
            }

            if(oEmail.val() == ''){
                alert('邮箱不能为空！');
                btn.removeClass('disabled');
                return;
            }

            var url = '/ztaddcomment'
                , param = {
                    is_ajax: 1
                    , huxiu_hash_code: huxiu_hash_code
                    , random: getRand()
                    , tid: tid
                    , zt_id: zt_id
                    , comment: oText.val()
                    , username: oEmail.val()
                }

            $.post(url, param, function(data){
                data = eval('(' +data +")");
                if(data.is_success == 1){
                    if(oUl.find('li').length == 0){
                        oUl.html('');
                    }

                    var avatar = data.avatar;
                    if(avatar == null){
                        avatar = 'http://images.huxiu.com/404.jpg';
                    }

                    var delHtml = '';
                    if(uid == 1320027){
                        var delHtml = '<span class="btn btn-mini js-btn-del">删除</span>';
                    }

                    var str = '<li class="clearfix"><div class="cmt-head"><img src="'+ avatar +'" alt="评委头像"></div><div class="cmt-cnt-box"><div class="cmt-rater">'+ data.username +'：</div><div class="cmt-cnt">'+ oText.val() + delHtml +'</div></div></li>'
                        ;
                    oUl.prepend(str);
                    oText.val('');
                    btn.removeClass('btn-publish-blue');
                }else{
                    alert(data.msg);
                }
                btn.removeClass('disabled');
            })

        }

    })

    /**
     * 发布评论按钮状态切换
     */
    $('body').on('keyup', '#showVoteBox textarea', function(){
        if($(this).val().length > 0){
            $(this).parents('#showVoteBox').find('.btn-publish').addClass('btn-publish-blue');
        }else{
            $(this).parents('#showVoteBox').find('.btn-publish').removeClass('btn-publish-blue');
        }
    });

    /**
     *  投票
     */
    $('body').on('click', '.js-btn-vote', function(){
        var btn = $(this);
        if(!btn.hasClass('disabled') && !btn.hasClass('voted')){
            btn.addClass('disabled');
            var strBody = '<div class="dialog-suc"><span>投票成功!</span></div>'
                , btn = $(this)
                , oNum = btn.parents('.js-item-vote').find('.js-num')
                , tid = btn.parents('.js-item-vote').attr('tid')
                , pollid = $('.js-vote-box').attr('pollid')
                ;
            if(undefined == tid || '' == tid){
                tid = btn.parents('.js-d-cmt-box').attr('tid');
                oNum = $('#vote_item_'+tid).find('.js-num')
            }
            var url = '/votedo'
                , param = {
                    is_ajax: 1
                    , huxiu_hash_code: huxiu_hash_code
                    , random: getRand()
                    , choiceid: tid
                    , voteid:pollid
                }
                ;

            $.post(url, param, function(data){
                data = eval('('+data+')');
                if(data.is_success == 1){
                    oNum.html(parseInt(oNum.html())+1);
                    btn.addClass('voted').html('已投票');
                    if(btn.parents('.js-item-vote').length == 0){
                        $('#vote_item_'+tid).find('.js-btn-vote').addClass('voted').html('已投票');
                    }
                }else{
                    strBody = '<div class="dialog-suc"><span>'+ data.message +'</span></div>';
                    dialogShow('showVotingBox', '<i></i>提交失败', strBody);
                }
                btn.removeClass('disabled');
            })

        }
    });

    /**
     * 弹窗
     * @param id
     * @param title
     * @param strBody
     */
    function dialogShow(id, title, strBody){
        var html = '<div id="'+ id +'" class="modal fade in" aria-hidden="true">' +
                        '<div class="modal-header">' +
                            '<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>' +
                            '<h4>'+ title +'</h4>' +
                        '</div>' +
                        '<div class="modal-body">' +
                            strBody  +
                        '</div>' +
                        '<div class="modal-footer">' +
            //                '<button aria-hidden="true" data-dismiss="modal" class="btn btn-success article-delete" typeid="44810" typename="aid">确定</button>' +
                            '<button aria-hidden="true" data-dismiss="modal" class="btn-close">关闭</button>' +
                        '</div>' +
                '</div>';


        if($('.modal').length > 0){
            $('.modal').remove();
            $('.modal-backdrop').remove();
            $('body').removeClass('open');
        }


        $('body').append(html);

        $('.modal').modal('show');
    }


 /*   function stopSlide(){
        *//*var el = document.querySelector('.modal');
        var sy = 0;
        $(document).bind(el, 'touchstart', function (e) {
            sy = e.pageY;
        })

        $(document).bind(el, 'touchmove', function (e) {
            var down = (e.pageY - sy > 0);
            //top
            if (down && el.scrollTop <= 0) {
                e.preventDefault();
            }
            //bottom
            if (!down && el.scrollTop >= el.scrollHeight - el.clientHeight) {
                e.preventDefault();
            }
        })*//*

        $(document).bind(scrollable, 'touchmove', function (e) {
            e.stopPropagation();
        });


    }*/


    $('body').on('show', '.modal', function () {
        $('body').addClass('open');
//        stopSlide();
    })

    $('body').on('hide', '.modal', function () {
        $('body').removeClass('open');
    })


    /**
     * 登录注册流程
     */

    $('body').on('click', '.js-btn-login', function(){
        showLoginBox('虎嗅帐号登录', '登录', 'btn-login');
    });

    $('body').on('click', '.js-btn-create', function(){
        $('#showAccountBoxModal').modal('toggle');
        showCreateBox('一键生成帐号', '生成帐号', 'btn-create');
    });

    function showLoginBox(title,btnName, className){
        var mBody = '<div class="control-group">' +
                '<label class="control-label" for="username"><i class="red">*</i>用户名：</label>' +
                '<div class="controls">' +
                '<input type="text" id="username" name="pro[username]" placeholder="用户名">' +
                '</div>' +
                '</div>'+
                '<div class="control-group">' +
                '<label class="control-label" for="password"><i class="red">*</i>密码：</label>' +
                '<div class="controls">' +
                '<input type="password" id="password" name="pro[password]" placeholder="密码">' +
                '</div>' +
                '</div>'
            ;
        var message = '<div class="alert hide">' +
            '<div class="box-ctt"></div>' +
            '</div>';

        var t = '<h3>'+title+'</h3>';
        var box = '<div id="showAccountBoxModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">' +
                '<div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><div class="t-h2">'+t+'</div>' +
                '</div>' +
                '<div class="modal-body">'+message+mBody+'</div>' +
                '<div class="modal-footer"><button type="button" class="btn '+ className +'">'+btnName+'</button><button type="button" class="btn js-btn-create">注册</button></div>' +
                '</div>'
            ;

        if($('.modal').length > 0){
            $('.modal').modal('hide');
        }

        if($('#showAccountBoxModal').length == 0){
            $('body').append(box);
        }
        $('#showAccountBoxModal').modal('toggle');

    }

    function showCreateBox(title,btnName, className){

        var mBody = '<div class="control-group">' +
                '<label class="control-label" for="username"><i class="red">*</i>用户名：</label>' +
                '<div class="controls">' +
                '<input type="text" id="username" name="pro[username]" placeholder="用户名">' +
                '</div>' +
                '</div>'+
                '<div class="control-group">' +
                '<label class="control-label" for="username"><i class="red">*</i>邮箱：</label>' +
                '<div class="controls">' +
                '<input type="text" id="email" name="pro[email]" placeholder="邮箱">' +
                '</div>' +
                '</div>'+
                '<div class="control-group">' +
                '<label class="control-label" for="password"><i class="red">*</i>密码：</label>' +
                '<div class="controls">' +
                '<input type="password" id="password" name="pro[password]" placeholder="密码">' +
                '</div>' +
                '</div>'
            ;
        var message = '<div class="alert hide">' +
            '<div class="box-ctt"></div>' +
            '</div>';

        var t = '<h3>'+title+'</h3>';
        var box = '<div id="showCreateBoxModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">' +
                '<div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><div class="t-h2">'+t+'</div>' +
                '</div>' +
                '<div class="modal-body">'+message+mBody+'</div>' +
                '<div class="modal-footer"></button><button type="button" class="btn '+ className +'">'+btnName+'</button></div>' +
                '</div>'
            ;

        if($('.modal').length > 0){
            $('.modal').modal('hide');
        }

        if($('#showCreateBoxModal').length == 0){
            $('body').append(box);
        }
        $('#showCreateBoxModal').modal('toggle');

    }

    $('body').on( 'click', '#showCreateBoxModal .btn-create', function(){
        var name = $('#showCreateBoxModal #username').val()
            , password = $('#showCreateBoxModal #password').val()
            , email = $('#showCreateBoxModal #email').val()
            , param = {
//                'username':encodeURI(name)
                'username':name
                , 'password':password
                , 'email':email
                , 'huxiu_hash_code': huxiu_hash_code
                , 'is_ajax':1
            }
            , url = '/zhuanti/fastreg'
            , urlCheck = '/user/check_reg_username'
            ;

        var obj = $('#showCreateBoxModal .alert');
        obj.attr('class', 'alert hide');
        $.post(url, param, function(data){
            var data = eval('('+data+')');
            if(data.is_success == 1){
                obj.addClass('alert-success').removeClass('hide').html(data.message);
                setTimeout(function(){
                    window.location.reload();
                },2000);

            }else{
                obj.addClass('alert-error').removeClass('hide').html(data.message);
            }
        });


        /*//判断用户名是否存在
        $.post(urlCheck
            , {'username':encodeURI(name), 'huxiu_hash_code':huxiu_hash_code, 'is_ajax':1}
            , function(data){
                var data = eval('('+data+')');
                if(data.result == 1){

                    var obj = $('#showCreateBoxModal .alert');
                    obj.attr('class', 'alert hide');
                    $.post(url, param, function(data){
                        var data = eval('('+data+')');
                        if(data.is_success == 1){
                            obj.addClass('alert-success').removeClass('hide').html(data.message);
                            setTimeout(function(){
                                window.location.reload();
                            },2000);

                        }else{
                            obj.addClass('alert-error').removeClass('hide').html(data.message);
                        }
                    });
                }else{
                    $('#showCreateBoxModal .alert').attr('class', 'alert alert-error').html(data.msg);
                }
            });*/
    });


    $('body').on( 'click', '#showAccountBoxModal .btn-login', function(){
        var name = $('#showAccountBoxModal #username').val()
            , password = $('#showAccountBoxModal #password').val()
            , param = {
//                'username':encodeURI(name)
                'username':name
                , 'password':password
                , 'huxiu_hash_code': huxiu_hash_code
                , 'is_ajax':1
            }
            , url = '/zhuanti/login'
            , urlCheck = '/user/check_reg_username'
            ;

        /*if($(this).hasClass('btn-login')){
            url = '/zhuanti/login';
            urlCheck = '/user/check_login_name'
        }*/

        accountOpt(url, param, $('#showAccountBoxModal .alert'));


        /*   //判断用户名是否存在
           $.post(urlCheck
               , {'username':encodeURI(name), 'huxiu_hash_code':huxiu_hash_code, 'is_ajax':1}
               , function(data){
                   var data = eval('('+data+')');
                   if(data.result == 2){
                       accountOpt(url, param, $('#showAccountBoxModal .alert'));
                   }else{
                       $('#showAccountBoxModal .alert').attr('class', 'alert alert-error').html(data.msg);
                   }
               });*/

    });

    function accountOpt(url, param, obj){
        obj.attr('class', 'alert hide');
        $.post(url, param, function(data){
            var data = eval('('+data+')');
            if(data.is_success == 1){
//                var str = '，<a class="alink" href="http://www.huxiu.com/">点击这里</a>'+'回到虎嗅首页。';
                obj.addClass('alert-success').removeClass('hide').html(data.message);
                setTimeout(function(){
                    window.location.reload();
                },2000);

            }else{
                obj.addClass('alert-error').removeClass('hide').html(data.message);
            }

        });

    }



});