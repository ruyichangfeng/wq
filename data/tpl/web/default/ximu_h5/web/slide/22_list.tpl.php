<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>

<ul class="we7-page-tab">
    <?php  if(is_array($opList)) { foreach($opList as $index => $item) { ?>
    <?php  if($item['active'] == 1) { ?>
    <li class="active"><?php  echo $item['title'];?></li>
    <?php  } else { ?>
    <li><a href="<?php  echo $item['url'];?>"><?php  echo $item['title'];?></a></li>
    <?php  } ?>
    <?php  } } ?>
</ul>

<div class="main">
    <div class="panel panel-info">
        <div class="panel-heading">筛选</div>
        <div class="panel-body">
            <form action=" " method="get" class="form-horizontal" role="form" id="searchform">
                <div class="col-xs-12 col-sm-3 col-md-3col-lg-3">
                    <div class="input-group">
                        <span class="input-group-addon"  >标题</span>
                        <input class="form-control"  name="seachkey">
                    </div>


                </div>

                <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
                    <button class="btn btn-default" type="button" id="btnseach"><i class="fa fa-search"></i> 搜索</button>

                    <a class="btn btn-default"
                       href="<?php  echo $this->createWebUrl($_GPC['do'], array('op'=>'edit'));?>">
                        增加</a>
                </div>
            </form>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">列表</div>
        <div class="panel-body">
            <div class="table-responsive panel-body">
                <div class="ibox-content" id="pfrom">
                    <!--data-detail-view="true"   data-detail-formatter="detailFormatter"-->
                    <table id="table" class="dotable" data-toggle="table"
                           data-url="<?php  echo $this->createWebUrl($_GPC['do'], array('op'=>'getJson'))?>"
                           data-sort-name="id" data-sort-order="desc" data-query-params="queryparams"
                           data-page-number="1" data-page-size="15" data-mobile-responsive="true" data-show-refresh="true" data-show-toggle="true">
                        <thead>
                        <tr>
                            <th data-checkbox="true"></th>
                            <th data-field="title" data-sortable="true">标题</th>
                            <th data-field="images" data-sortable="true" data-width="10%" data-formatter="formatimg">图片</th>
                            <th data-field="url" data-sortable="true" data-width="26%"> 跳转地址</th>
                            <th data-field="status" data-sortable="true" data-formatter="formatstatus"
                                data-events="operatestatus">状态
                            </th>
                            <th data-field="add_time" data-sortable="true">创建时间</th>

                            <th data-field="order" data-sortable="true">排序</th>

                            <th data-events="operateEvents" data-formatter="operateFormatter" data-width="16%"
                                data-title="操作" data-align="center">操作
                            </th>
                        </tr>
                        </thead>
                    </table>
                    <button type="button" class="btn btn-danger " style="margin-right:5px;" id="delselct">删除选中</button>
                    <br>
                    <br>
                    说明：
                    <a class="btn btn btn-default btn-xs"> <i class="fa fa-square-o fa-lg"></i></a>禁用 <a
                        class="btn btn-primary  btn-xs"> <i class="fa fa-check-square-o fa-lg"></i></a> 开启
                </div>
            </div>
        </div>
    </div>
</div>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/common/xmjscode', TEMPLATE_INCLUDEPATH)) : (include template('web/common/xmjscode', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/common/xmjscss', TEMPLATE_INCLUDEPATH)) : (include template('web/common/xmjscss', TEMPLATE_INCLUDEPATH));?>

<link href="https://cdn.bootcss.com/sweetalert/1.1.3/sweetalert.min.css" rel="stylesheet">
<script src="https://cdn.bootcss.com/sweetalert/1.1.3/sweetalert.min.js"></script>
<script type="text/javascript">
    <!--数据搜索-->
    $(function () {
        $("#btnseach").click(function () {
            setseach();
            $("#table").bootstrapTable('refresh');
        })
    })
    $saechparas = null;
    function setseach() {
        $saechparas = {};
        $saechparas = $("#searchform").serializeArray();
    }
    function queryparams(params) {
        //
        if ($saechparas == null) {
            setseach()
        }
        $.each($saechparas, function (i, field) {
            params[field.name] = field.value;
        });
        return params;
    }

    $(function () {
        $("#delselct").click(function () {
            $pdadta = $("#table").bootstrapTable('getSelections');
            if ($pdadta.length < 1) {
                swal({
                    title: "错误",
                    text: "选选择删除内容",
                    type: "error",
                    timer: 2000
                });
            }
            else {
                swal(
                    {

                        title: "确认删除" + $pdadta.length + "条记录吗",
                        text:"删除后将无法恢复，请谨慎操作！",
                        type:"warning",
                        showCancelButton:true,
                        confirmButtonColor:"#DD6B55",
                        confirmButtonText:"是的，我要删除！",
                        cancelButtonText:"让我再考虑一下…",
                        closeOnConfirm:false,
                        closeOnCancel:false
                    },
                    function(isConfirm)
                    {
                        if(isConfirm)
                        {
                            var _postdata = {};
                            var ids = [];
                            $.each($pdadta, function (i, field) {

                                ids.push(field["id"]);
                            });
                            _postdata["ids"] = ids.join(",");
                            $.ajax("<?php  echo $this->createWebUrl($_GPC['do'], array('op'=>'delete'));?>", {
                                method: 'POST',
                                data: _postdata,
                                dataType: 'json'
                            }).done(function (response) {
                                if (parseInt(response["status"]) === 1) {
                                    message({
                                        title: "提示",
                                        text: "删除成功",
                                        type: "success",
                                        timer: 1500
                                    });

                                    $("#table").bootstrapTable('refresh');
                                }
                                else {
                                    message({
                                        title: "错误",
                                        text: "删除失败",
                                        type: "error",
                                        timer: 2000
                                    });
                                }
                            });
                        }
                        else{
                            swal({title:"已取消",
                                text:"您取消了删除操作！",
                                type:"error"})
                        }
                    }
                );
            }
        })

    });
/* 数据表格参数设置*/
    $.extend($.fn.bootstrapTable.defaults, {
        striped:true, /* 隔行换色*/
        iconsPrefix:'fa',
        icons:{refresh: 'fa-refresh icon-refresh',
            toggle: 'fa-list-alt icon-list-alt'},
        method: 'post',
        pagination: true,
        sidePagination: 'server',
        contentType: 'application/x-www-form-urlencoded; charset=UTF-8',

        onClickCell: function (field, value, row, $element) {


        },
        onLoadSuccess: function () {
            /* 生成二维码*/
//            $("#pfrom").find(".per").each(function () {
//                $(this).qrcode({
//                    text: $(this).attr("href"),
//                    height: 150,
//                    width: 150
//                });
//            })
        }
    });
    /* 数据表格列参数设置*/
    $.extend($.fn.bootstrapTable.columnDefaults, {
        align: 'center',
        valign: 'middle'
    });

    /* 操作*/
    function operateFormatter(value, row, index) {
        var myhtml = [];
        myhtml.push(
            '<a class="btn btn-primary btn-xs" href="' + "<?php  echo $this->createWebUrl($_GPC['do'], array('op'=>'edit','iflag'=>$_GPC['iflag'],__title=>$_GPC['__title']));?>&id=" + row['id'] + '">',
            '<i class="fa fa-edit"></i> ',
            '</a>  ',
            '<a class="btn btn-danger btn-xs delete" href="javascript:void(0)"  >',
            '<i class="fa fa-close" aria-hidden="true"></i>',
            '</a>'

        );
        return myhtml.join('');
    }

    /* 图片*/
    function formatimg(value,row,index) {
        return  '<img src="/attachment/'+value+'" width="100%" >'

    }
    var operateEvents = {
        /* 删除*/
        "click a.delete": function (e, value, row, index) {
            var _postdata = {};
            _postdata["ids"] = row["id"];
            swal(
                {title:"您确定要删除这条信息吗",
                    text:"删除后将无法恢复，请谨慎操作！",
                    type:"warning",
                    showCancelButton:true,
                    confirmButtonColor:"#DD6B55",
                    confirmButtonText:"是的，我要删除！",
                    cancelButtonText:"让我再考虑一下…",
                    closeOnConfirm:false,
                    closeOnCancel:false
                },
                function(isConfirm)
                {
                    if(isConfirm)
                    {
                        $.ajax("<?php  echo $this->createWebUrl($_GPC['do'], array('op'=>'delete'));?>", {
                            method: 'POST',
                            data: _postdata,
                            dataType: 'json'
                        }).done(function (response) {
                            if (parseInt(response["status"]) === 1) {
                                message({
                                    title: "提示",
                                    text: "删除成功",
                                    type: "success",
                                    timer: 1500
                                });

                                $("#table").bootstrapTable('refresh');
                            }
                            else {
                                message({
                                    title: "错误",
                                    text: "删除失败",
                                    type: "error",
                                    timer: 2000
                                });

                            }
                        });
                    }
                    else{
                        swal({title:"已取消",
                            text:"您取消了删除操作！",
                            type:"error"})
                    }
                }
            );
        },
        "click a.testgroupmessage":function(e, value, row, index){
            var _postdata = {};
            _postdata["id"] = row["id"];
            _postdata["mobanid"] = row["mobanid"];
            _postdata["keyval"] = row["keyval"];

            $.ajax("<?php  echo $this->createWebUrl($_GPC['do'], array('op'=>'testgroupmessage'));?>", {
                method: 'POST',
                data: _postdata,
                dataType: 'json'
            }).done(function (response) {

                swal({
                    title: '请查看有没有收到模版消息',
                    type: 'info',
                    html:
                    '返回数据：'+JSON.stringify(response)
                })
            });
        },
        "click a.er":function(e, value, row, index){

            xpagecss.xload();
          var  _postdata={};
            _postdata["id"]=row["id"];

            $.ajax("<?php  echo $this->createWebUrl($_GPC['do'], array('op'=>'geter'));?>", {
                method: 'POST',
                data: _postdata,
                dataType: 'json'
            }).done(function (response) {
                if( typeof(response)!=='undefined'&& typeof(response["url"])!=='undefined'){


                    swal({
                        html: '<div id="er" url="'+response["url"]+'">'+response["url"]+'</div>'
                    })



                    var  url = $("#er").attr('url');
                    $("#er").html('').qrcode({
                        render: 'canvas',
                        width: 120,
                        height: 120,
                        text: url
                    });

                }
                else {

                    xpagecss.error(JSON.stringify(response));

                }

            });
        }
    }

    /* 改变状态*/
    var operatestatus = {
        'click a': function (e, value, row, index) {

            var _postdata = {};
            _postdata["id"] = row["id"];
            _postdata["status"] = value;
            $actindex = index;

            $.ajax("<?php  echo $this->createWebUrl($_GPC['do'], array('op'=>'midstatus'));?>", {
                method: 'POST',
                data: _postdata,
                dataType: 'json'
            }).done(function (response) {
                if (parseInt(response["status"]) === 1) {
                    message({
                        title: "提示",
                        text: "操作成功",
                        type: "success",
                        timer: 1500
                    });

                    $("#table").bootstrapTable('updateRow', {
                        index: $actindex,
                        row: {
                            status: -_postdata["status"]
                        }
                    });
                }
                else {
                    message({
                        title: "错误",
                        text: "操作失败",
                        type: "error",
                        timer: 2000
                    });
                }
            });
        }
    }
    var operateisindex = {
        'click a': function (e, value, row, index) {

            var _postdata = {};
            _postdata["id"] = row["id"];
            _postdata["status"] = value;
            $actindex = index;

            $.ajax("<?php  echo $this->createWebUrl($_GPC['do'], array('op'=>'midisindex'));?>", {
                method: 'POST',
                data: _postdata,
                dataType: 'json'
            }).done(function (response) {
                if (parseInt(response["status"]) === 1) {
                    message({
                        title: "提示",
                        text: "操作成功",
                        type: "success",
                        timer: 1500
                    });

                    $("#table").bootstrapTable('updateRow', {
                        index: $actindex,
                        row: {
                            isindex: -_postdata["status"]
                        }
                    });
                }
                else {
                    message({
                        title: "错误",
                        text: "操作失败",
                        type: "error",
                        timer: 2000
                    });
                }
            });
        }
    }
    /* 状态*/
    function formatstatus(value, row, index) {
        if (value == -1) {

            return '<a class="btn btn btn-default btn-xs" data-value="-1"  data-filed="status" > <i class="fa fa-square-o fa-lg"></i></a> ';
        }
        else {
            return '<a class="btn btn-primary  btn-xs"  data-value="1" data-filed="status" > <i class="fa fa-check-square-o fa-lg"></i></a>'
        }
    }
    function formatisindex(value, row, index) {
        if (value == -1) {

            return '<a class="btn btn btn-default btn-xs" data-value="-1"  data-filed="status" > <i class="fa fa-square-o fa-lg"></i></a> ';
        }
        else {
            return '<a class="btn btn-primary  btn-xs"  data-value="1" data-filed="status" > <i class="fa fa-check-square-o fa-lg"></i></a>'
        }
    }

    var xpagecss = {
        xload: function () {

            message({
                title: "操作中",
                text: "",
                imageUrl: "../addons/<?php  echo $_GPC['m']?>/resource/images/xload1.gif",
                showConfirmButton: false,
                allowOutsideClick: true
            })
        },
        close: function () {
            swal.close();
        },
        "ok":function () {
            var $message= arguments[0] ? arguments[0] : "错误";
            var $title = arguments[1] ? arguments[1] : "错误";
            swal(
                $title,
                $message,
                'success'
            )
        },
        error:function () {
            var $message= arguments[0] ? arguments[0] : "错误";
            var $title = arguments[1] ? arguments[1] : "错误";
            swal(
                $title,
                $message,
                'error'
            )
        },
        deleterows: function ($ids) {
            var _postdata = {};
            _postdata["ids"] = $ids;


            $.ajax("<?php  echo $this->createWebUrl($_GPC['do'], array('op'=>'delete'));?>}", {
                method: 'POST',
                data: _postdata,
                dataType: 'json'
            }).done(function (response) {
                if (parseInt(response["status"]) === 1) {
                    message({
                        title: "提示",
                        text: "删除成功",
                        type: "success",
                        timer: 1500
                    });

                    $("#table").bootstrapTable('refresh');
                }
                else {
                    message({
                        title: "错误",
                        text: "删除失败",
                        type: "error",
                        timer: 2000
                    });

                }
            });
        }
    };

    function message($opdata) {
        swal($opdata);
    }


</script>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>