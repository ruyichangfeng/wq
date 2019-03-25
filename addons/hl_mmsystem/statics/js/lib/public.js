/**
 * Created by zhoufeng on 2017/6/19.
 */
$(function() {
    $("#checkAll").click(function() {
        var checked = $(this).get(0).checked;
        var group = $(this).data('group');
        $("#regionid[data-group='" +group + "']").each(function(){
            $(this).get(0).checked = checked;
        })
    });
    //省
    $('.tpl-province').change(function(){
        var province =$('.tpl-province').val();
        if(province){
            $.getJSON("../web/index.php?c=site&a=entry&do=cregion&m=xfeng_community",{province:province},function(data){
                var region ="";
                region += "<div class='checkbox checkbox-success checkbox-inline' >";
                region += "<input type='checkbox' id='checkAll' name='checkAll' data-group='regionid' />";
                region += "<label for='checkAll'> 全部 </label></div>";
                for (var o in data) {
                    var che = '';
                    if(regionids){
                        if($.inArray(data[o].id,regionids)!=-1){
                            che = 'checked';
                        }
                    }
                    region += "<div class='checkbox checkbox-success checkbox-inline' >";
                    region += "<input type='checkbox' id='regionid_"+data[o].id+"' value='" + data[o].id + "' data-group='regionid' name='regionid'"+che+">" ;
                    region += "<label for='regionid_"+data[o].id+"'> "+data[o].title+" </label></div>";
                }
                $('.content').html(region);
                $('.region').show();
                $("#checkAll").click(function() {
                    var checked = $(this).get(0).checked;
                    var group = $(this).data('group');
                    $("input:checkbox[data-group='" +group + "']").each(function(){
                        $(this).get(0).checked = checked;
                    })
                });
            })
        }

    })
    //市
    $('.tpl-city').change(function(){
        var city =$('.tpl-city').val();
        if(city){
            $.getJSON("../web/index.php?c=site&a=entry&do=cregion&m=xfeng_community",{city:city},function(data){
                var region ="";
                region += "<div class='checkbox checkbox-success checkbox-inline' >";
                region += "<input type='checkbox' id='checkAll' name='checkAll' data-group='regionid'  />";
                region += "<label for='checkAll'>全部</label></div>";
                for (var o in data) {
                    var che = '';
                    if(regionids){
                        if($.inArray(data[o].id,regionids)!=-1){
                            che = 'checked';
                        }
                    }
                    region += "<div class='checkbox checkbox-success checkbox-inline' >";
                    region += "<input type='checkbox' id='regionid_"+data[o].id+"' value='" + data[o].id + "' data-group='regionid' name='regionid'"+che+">" ;
                    region += "<label for='regionid_"+data[o].id+"'> "+data[o].title+" </label></div>";
                }
                $('.content').html(region);
                $('.region').show();
                $("#checkAll").click(function() {
                    var checked = $(this).get(0).checked;
                    var group = $(this).data('group');
                    $("input:checkbox[data-group='" +group + "']").each(function(){
                        $(this).get(0).checked = checked;
                    })
                });
            })
        }

    })
    //区
    $('.tpl-district').change(function(){
        var dist =$('.tpl-district').val();
        if(dist){
            $.getJSON("../web/index.php?c=site&a=entry&do=cregion&m=xfeng_community",{dist:dist},function(data){
                var region ="";
                region += "<div class='checkbox checkbox-success checkbox-inline' >";
                region += "<input type='checkbox' id='checkAll' name='checkAll' data-group='regionid'  />";
                region += "<label for='checkAll'>全部</label></div>";
                for (var o in data) {
                    var che = '';
                    if(regionids){
                        if($.inArray(data[o].id,regionids)!=-1){
                            che = 'checked';
                        }
                    }
                    region += "<div class='checkbox checkbox-success checkbox-inline' >";
                    region += "<input type='checkbox' id='regionid_"+data[o].id+"' value='" + data[o].id + "' data-group='regionid' name='regionid'"+che+">" ;
                    region += "<label for='regionid_"+data[o].id+"'> "+data[o].title+" </label></div>";
                }
                $('.content').html(region);
                $('.region').show();
                $("#checkAll").click(function() {
                    var checked = $(this).get(0).checked;
                    var group = $(this).data('group');
                    $("input:checkbox[data-group='" +group + "']").each(function(){
                        $(this).get(0).checked = checked;
                    })
                });
            })
        }

    })

});
