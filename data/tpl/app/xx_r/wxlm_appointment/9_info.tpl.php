<?php defined('IN_IA') or exit('Access Denied');?><!doctype html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
    <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('head', TEMPLATE_INCLUDEPATH)) : (include template('head', TEMPLATE_INCLUDEPATH));?>
    <title><?php  echo $this->config['system_name']?></title>
</head>
<style>

    .collection
    {
        width: 30px;
        position: fixed;
        top: 50px;
        right: 30px;
        z-index: 999;
    }
.explore01_show-con01-image01 img{width:100%;}
.explore01_show-con01-image001 img{width:100%;}
.explore01_show-con01-text01{font-family:"Microsoft YaHei";
    font-size:14px;
    color:#858585;
    line-height:20px;
    float:left;
    margin-left:6px;
    margin-top:2px;}
.explore01_show-con01-text001{font-family:"Microsoft YaHei";
    font-size:14px;
    color:#858585;
    line-height:20px;
    float:left;
    margin-left:6px;
    margin-top:2px;}
.explore01_show-con01-b{overflow: hidden;
    margin-top: 20px;}
.explore01_show-con01-b li{width:30%;
    height:30px;
    border:1px solid #d7d6db;
    border-radius:3px;
    font-family:"Microsoft YaHei";
    font-size:12px;
    color:#a0a0a0;
    line-height:30px;
    text-align:center;
    margin:4px 4px;}
.explore01_show-con01-text02{width:100%;
    height:100px;
    font-family:"Microsoft YaHei";
    font-size:12px;
    color:#a0a0a0;
    line-height:20px;
    margin-top:20px;}


.explore01_show-con02_con{width:100%;
    overflow: hidden;
    margin-top: 8px;}
.explore01_show-con02_con li{width:94%;
    margin-left:3%;
    border-top:1px solid #e3e3e3;
    overflow:hidden;
    padding:10px 0;}
.explore01_show-con02_con li:last-child{border-bottom:1px solid #e3e3e3;}
.explore01_show-con02_con  .col-xs-3{overflow:hidden;
    text-align:center;}
.explore01_show-con02_con li img{width:100%;}
.explore01_show-con02_con  .col-xs-9{overflow:hidden;
    padding:0;}
.explore01_show-con02-text01{font-family:"Microsoft YaHei";
    font-size:12px;
    color:#6b7e8c;
    margin-top:2px;}
.explore01_show-con02-text02{font-family:"Microsoft YaHei";
    font-size:12px;
    color:#454545;
    line-height:20px;
    margin-top:4px;}

.explore01_show-con02-text03{width:100%;
    height:20px;
    text-align:center;}
.explore01_show-con02-text04{width:100%;
    font-family:"Microsoft YaHei";
    font-size:12px;
    color:#454545;
    line-height:20px;
    text-align:center;}
.explore01_show-con02-image{width:10%;
    float:right;
    line-height:40px;}
.explore01_show-con02-image img{width:34%;
    margin-left: 14px;}

.explore01_show-con01-t .col-xs-8{padding-left:0;
    margin-top:4px;}
.explore01_show-con02-image01 {
    width:8%;
    float: left;}
.explore01_show-con02-image01 img{
    width:100%;}
.explore01_show-con01-t .col-xs-3{padding:0;
    margin-left: 25px;}
.explore01_show-con01-r input{width:100%;
    height:30px;
    background-color:#fe6732;
    border-radius:4px;
    font-family:"Microsoft YaHei";
    font-size:12px;
    color:#fff;}
.wbk{width:100%;
    height:100px;
    border-radius:10px;
    border:1px solid #999;
    margin-top:10px;
    overflow:hidden;
    position:relative;}
.explore01_show-con02-text002{width:90%;
    font-family:"Microsoft YaHei";
    font-size:12px;
    color:#a0a0a0;
    line-height:20px;
    resize:none;
    border:none;
    margin:10px auto 0;
    display:block;
    outline:none;
    clear:both;

}
.explore01_show-con02-text003{width: 97%;
    margin-top: 5px;
    font-family:"Microsoft YaHei";
    font-size:12px;
    color:#a0a0a0;
    text-align: right;
}
.explore01_show-con02-text003 span{font-size:14px;
    color:red;}
</style>

<body>
<div class="box">

    <a  class="collection_1" href="javascript:getCollection(1)" <?php  if(empty($collection)) { ?>style="display: none"<?php  } ?>><img  class="collection" src="<?php echo RES;?>mobile/images/xing01.png" alt=""></a>
    <a class="collection_2" href="javascript:getCollection(2)" <?php  if(!empty($collection)) { ?>style="display: none"<?php  } ?>><img  class="collection" src="<?php echo RES;?>mobile/images/xing001.png" alt=""></a>
    <div class="tops">
        <div class="col-xs-2 text01-l">
            <a href="javascript:" onclick="history.back(); ">
                <img src="<?php echo RES;?>mobile/images/back-white.png">
            </a>
        </div>
        <div class="col-xs-8 text01-c">预约信息</div>
    </div>
    <div class="cont-box">
    	<ul class="cont" style="margin-bottom: 5px;">
        	<li>
            	<div class="cont-t">
                	<div class="cont-image01">
                        <img src="<?php  echo tomedia($store['store_pic'])?>" width="100%">
                    </div>
                </div>
                <div class="cont-c">
                	<div class="cont-text01"><?php  echo $store['store_name'];?></div>
                </div>
                <div class="wz">
                    <a href="<?php  echo $urladdr;?>" style="text-decoration:none;color:#999;">
                        <div class="wz-l">
                            <div class="wz-l-image">
                                <img src="<?php echo RES;?>mobile/images/info-location.png">
                            </div>
                            <div class="wz-l-text"> <?php  echo $store['store_address'];?></div>
                            <div style="float: right; padding-top: 3px "><img src="<?php echo RES;?>mobile/images/right.png"  alt="" style="height: 15px"></div>
                        </div>
                    </a>
                    <a href="tel:<?php  echo $store['store_tel'];?>" style="text-decoration:none;color:#999;">
                        <div class="wz-l">
                            <div class="wz-l-image01">
                                <img src="<?php echo RES;?>mobile/images/info-tel.png">
                            </div>
                            <div class="wz-l-text"><?php  echo $store['store_tel'];?></div>
                            <div style="float: right; padding-top: 3px "><img src="<?php echo RES;?>mobile/images/right.png"  alt="" style="height: 15px"></div>
                        </div>
                    </a>
                </div>
            </li>
        </ul>
        <div class="explore01_show-con01">
            <div class="explore01_show-con01-t">
                <div class="explore01_show-con01-image01">
                    <img src="<?php echo RES;?>mobile/images/info-store.png">
                </div>
                <div class="explore01_show-con01-text01">门店详情</div>
            </div>
            <div style="padding: 10px">
                <?php  echo $store['store_info'];?>
            </div>
        </div>    

        <div class="explore01_show-con01" style="margin-bottom: 0; <?php  if(empty($order_list)) { ?>padding:0 10px 80px;<?php  } ?>">
            <div class="explore01_show-con01-t">
                <div class="explore01_show-con01-image01">
                    <img src="<?php echo RES;?>/mobile/images/tihuan3.png">
                </div>
                <div class="explore01_show-con01-text01">门店点评</div>
            </div>
            <ul class="explore01_show-con02_con" id="comment_list" style="position:static;">

                
            </ul>
            <a class="explore01_show-con02-text03" href="javascript:ajaxchuli();">
                <div class="explore01_show-con02-text04" id="pingluntishi">查看更多</div>
                <!--<div class="explore01_show-con02-image">
                    <img src="<?php echo RES;?>/public/discount/images/right.png">
                </div>-->
            </a>
        </div>

        <?php  if(!empty($order_list)) { ?>
        <div class="explore01_show-con01" style="padding:0 10px 80px;margin-top: -18px;">
           <form action="<?php  echo $this->createMobileUrl('comment')?>" role="form" class="form-inline myform" method="post"  id="form1" onSubmit="return checksubmit();">
                <div class="explore01_show-con01-t">
                    <div class="col-xs-8 explore01_show-con01-l">
                        <div class="explore01_show-con02-image01">
                            <img src="<?php echo RES;?>/mobile/images/tihuan4.png">
                        </div>
                        <div class="explore01_show-con01-text01">我要点评</div>
                    </div>
                    <div class="col-xs-3 explore01_show-con01-r">
                        <input type="hidden" name="qf" value="comment">
                        <input type="hidden" name="comment[comment_storeid]" value="<?php  echo $store_id;?>">
                        <input type="submit" value="发表">
                    </div>
                </div>
                <div class="wbk" style="margin-bottom: 10px;">
                    <textarea class="explore01_show-con02-text002" name="comment[comment_text]" maxlength="25" id="t1" onkeyup="checkLen()" placeholder="评论信息" rows="3"></textarea>
                    <div class="explore01_show-con02-text003" style="text-align: right;">您还可以输入 <span id="count">25</span> 个文字</div> 
                </div>
            </form>
        </div>
        <?php  } ?>
        <div class="explore01_show-con02">
            <a href="<?php  echo $this->createMobileUrl('project', array('store_id'=>$store['store_id']))?>" >查看预约项目</a>
        </div>
    </div>
    <input type="hidden" id="store_id"  value="<?php  echo $store_id;?>">
</div>
<script>
    var storeid=$('#store_id').val();
    var lastID=999999999999;
    //滚动条到页面底部加载更多案例 
    $(function(){
        ajaxchuli();
    })
    function ajaxchuli()
    {
         $.ajax({  
          type:"POST",
          url: "<?php  echo $this->createMobileUrl('conmmentlist');?>",
          data:{store_id:storeid,"lastID":lastID,"pageSize":5},
          dataType:"json",
          async:false,
          success:function(data){
            //清空联动数据
            if(data.result=="success")
            { 
                var op="";
                for (var i = 0; i < data.rs.length; i++) {
                    
                    op+='<li><div class="col-xs-3">';
                    op+='<img src="'+data.rs[i]["fans_avatar"]+'" class="img-circle" style="width:80%;"></div>';
                    op+='<div class="col-xs-9">';
                    op+='<div class="explore01_show-con02-text01">'+data.rs[i]["fans_nickname"]+'</div>'
                    op+='<div class="explore01_show-con02-text02">'+data.rs[i]["comment_text"]+'</div>';
                    op+=' </div></li>';
                    if(data.rs.length < 5)
                    {
                        lastID=0; 
                        $('#pingluntishi').html('');
                    }else{
                        lastID=data.rs[i].comment_id; 
                    }
                }
                 $("#comment_list").append(op);
            }else{
              lastID=0; 
              $('#pingluntishi').html('暂无评论信息')
            }
          }
      });
    }

    function checkLen()
    {
            var maxChars = 25;//最多字符数  
            var t1=$('#t1').val();
            if (t1.length <= maxChars)  
            {  
                var curr = maxChars - t1.length;  
                $("#count").text(curr);
            }
    }

    function checksubmit()
    {
            if($('#t1').val()=='')
            {
                alert('请输入评论信息');
                return false;

            }

            return true;

    }

    /** 收藏 */
    function getCollection(type) {

        $.ajax({

            url:"<?php  echo $this->createMobileUrl('ajaxCollection')?>",
            type:"post",
            data:{storeid:storeid},
            success:function (res) {

                if (res == 1)
                {
                    $('.collection_1').css('display', 'block')
                    $('.collection_2').css('display', 'none')

                } else if (res == 2)
                {
                    $('.collection_1').css('display', 'none')
                    $('.collection_2').css('display', 'block')
                }


            }
        })
    }

</script>
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=9&c=utility&a=visit&do=showjs&m=wxlm_appointment"></script></body>
</html>
