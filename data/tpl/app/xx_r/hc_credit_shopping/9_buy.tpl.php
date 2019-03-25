<?php defined('IN_IA') or exit('Access Denied');?><html lang="zh-CN">
 <head> 
  <meta charset="utf-8" /> 
  <meta http-equiv="X-UA-Compatible" content="IE=edge" /> 
  <title>购买清单 - 积分商城</title> 
  <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, width=device-width" /> 
  <meta content="telephone=no" name="format-detection" /> 
  <link href="../addons/hc_credit_shopping/style/css/buy_common.css" rel="stylesheet" /> 
  <link href="../addons/hc_credit_shopping/style/css/cart.css" rel="stylesheet" /> 
  
  <script src="../addons/hc_credit_shopping/style/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="../addons/ewei_shopping/images/jquery.gcjs.js"></script>
  <style id="style-1-cropbar-clipper">/* Copyright 2014 Evernote Corporation. All rights reserved. */
.en-markup-crop-options {
    top: 18px !important;
    left: 50% !important;
    margin-left: -100px !important;
    width: 200px !important;
    border: 2px rgba(255,255,255,.38) solid !important;
    border-radius: 4px !important;
}

.en-markup-crop-options div div:first-of-type {
    margin-left: 0px !important;
}
</style> 
 </head>
 <body> 

  <div class="m-cart" id="pro-view-5" style="padding-top:0px">
    <form method="post" action="<?php  echo $this->createMobileUrl('pay_way')?>">

	<?php  if(is_array($list)) { foreach($list as $item) { ?>
	<?php  $price += $item['total'] * $item['marketprice'];?>
	<?php  $goods = $item['goods']?>
   <div class="item" id="item_<?php  echo $item['id'];?>">
    <div class="pic">
     <a href="<?php  echo $this->createMobileUrl('detail', array('id' => $goods['goodsid']))?>"><img src="<?php  echo tomedia($goods['thumb']);?>" alt="<?php  echo $goods['title'];?>" /></a>
    </div>
	
    <div class="text">
     <h1 class="title"><a href="<?php  echo $this->createMobileUrl('detail', array('id' => $goods['goodsid']))?>"><?php  echo $goods['title'];?></a></h1>
     <div>
      价格 <?php  echo intval($goods['marketprice'])?> 积分，剩余 
      <em class="remain" id='stock' ><?php  echo $goods['total'] ?></em> 
     </div>
     <div>
      购买数量
      <div class="w-number" id="pro-view-7">
	  <div style="display:none">
	  <span class='singletotalprice' id="goodsprice_<?php  echo $item['id'];?>"><?php  echo $item['total'] * $item['marketprice'] ?></span>
	  <span id="stock_<?php  echo $item['id'];?>" style='display:none'><?php  echo $goods['total'];?></span>
	  <span id="singleprice_<?php  echo $item['id'];?>"><?php  echo $goods['marketprice'];?></span>
	  </div>
       <input class="w-number-input goods_total" name="goods_<?php  echo $goods['id'];?>"  data-pro="input" price="<?php  echo $goods['marketprice'];?>" pricetotal="<?php  echo $item['totalprice'];?>" value="<?php  echo $item['total'];?>" maxbuy="<?php  echo $goods['maxbuy'];?>" id="goodsnum_<?php  echo $item['id'];?>" pattern="[0-9]*" style="height:28px" id="total"  />
       <a class="w-number-btn w-number-btn-plus" data-pro="plus" href="javascript:void(0);" onclick="addNum(<?php  echo $item['id'];?>,<?php  echo $goods['maxbuy'];?>)">+</a>
       <a class="w-number-btn w-number-btn-minus" data-pro="minus" href="javascript:void(0);" onclick="reduceNum(<?php  echo $item['id'];?>)">-</a>


<input type="hidden" class="goodsprice" name="goods_price_<?php  echo $goods['id'];?>" id="goods_price_<?php  echo $goods['id'];?>" value="<?php  echo $goods['total']*$goods['marketprice'] ?>" >

<input type="hidden"  name="goods_marketprice_<?php  echo $goods['id'];?>" id="goods_marketprice_<?php  echo $goods['id'];?>" value="<?php  echo $goods['marketprice'];?>" >

      </div>
     </div>
    <a href="javascript:void(0);" onclick="removeCart(<?php  echo $item['id'];?>)" data-pro="del" class="del"><i class="ico ico-del"></i></a>
    </div>
   </div>


   <script>
    
  $("#goodsnum_<?php  echo $item['id'];?>").keyup(function(){
    var total = 0;
    var temp = "<?php  echo $goods['id'];?>";
    var temp2 = "<?php  echo $item['id'];?>";
    var marketprice = "#"+"goods_marketprice_"+temp;
    var total = "#"+"goodsnum_"+temp2;  
    var goods_price = "#"+"goods_price_"+temp;
    var price = $(total).val() * $(marketprice).val();
    $(goods_price).val(price);

    var all_price = 0;
    var chr = $('.goods_total');
    var goods_total_price = new Array(); //或者写成：var btns= [];
    jQuery('.goodsprice').each(function(key,value){
    goods_total_price[key] = $(this).val();console.log($(this))
    all_price = all_price + parseInt(goods_total_price[key]);
    
    });
    $("#pricetotal").html(all_price);
  
  });
   </script>



   <?php  } } ?>
   
   
  <div class="m-simpleFooter" id="pro-view-3">
   <div data-pro="text" class="m-simpleFooter-text">
    <div id="pro-view-4">
     总计：
     <em class="txt-red" id="pricetotal"><?php  echo $price;?> </em>积分,当前剩余<?php  echo $credit_shoppingbi;?>积分
    </div>
   </div>
   <div data-pro="ext" class="m-simpleFooter-ext">
   <!-- <a href="<?php  echo $this->createMobileUrl('submit_order')?>"><button class="w-button w-button-main" id="pro-view-2">提交</button></a> -->
    <a ><button class="w-button w-button-main" id="pro-view-2">提交</button></a>
   </div>
  </div>
   </form>
   
  </div>  
 <!-- 
<script>
    var maxbuy = <?php echo empty($goods['maxbuy']) ? "0" : $goods['maxbuy']?>;


   function addNum() {
        var total = $("#total");
        if (!total.isInt()) {
            total.val("1");
        }
        var stock = $("#stock").html() == '' ? -1 : parseInt($("#stock").html());
        var mb = maxbuy;
        if (mb > stock && stock != -1) {
            mb = stock;
        }
        var num = parseInt(total.val()) + 1;
        if (num > stock) {
            alert("您最多可购买 " + stock + " 件!", true);
            num--;
        }
        if (num > mb && mb > 0) {
            alert("您最多可购买 " + mb + " 件!", true);
            num = mb;
        }
        total.val(num);
    }

    function reduceNum() {
        var total = $("#total");
        if (!total.isInt()) {
            total.val("1");
        }
        var num = parseInt(total.val());
        if (num - 1 <= 0) {
            return;
        }
        num--;
        total.val(num);
    }
</script> 
-->
<script>
	function addNum(id,maxbuy){
		var mb = maxbuy;
		 var stock =$("#stock_" + id).html()==''?-1:parseInt($("#stock_" + id).html());
				if(mb>stock && stock!=-1){
					mb = stock;
				}
		var num = parseInt( $("#goodsnum_" + id).val() ) + 1;
		if(num>mb && mb>0){
			alert("最多只能购买 " + mb + " 件!",true);
			return;
		}
		$("#goodsnum_" + id).val(num);
		var price = parseFloat( $("#singleprice_"+id).html() ) * num;
		$("#goodsprice_" + id).html(price);
    console.log("#goodsprice_" + id);
		canculate();
		updateCart(id,num);
	}
	function reduceNum(id){
		var num = parseInt( $("#goodsnum_" + id).val() );
		if(num-1<=0){
			return;
		}
		num--;
		//alert(parseFloat( $("#singleprice_"+id).html() ));
		$("#goodsnum_" + id).val(num);
		var price = parseFloat( $("#singleprice_"+id).html() ) * num;
		$("#goodsprice_" + id).html(price);
		canculate();
		updateCart(id,num);
	}
function canculate(){
		var total = 0;
		$(".singletotalprice").each(function(){
			total+=parseFloat( $(this).html() );
		});
		$("#pricetotal").html(total);
	}
	function updateCart(id,num){
		var url = "<?php  echo murl('entry//mycart',array('m'=>'hc_credit_shopping','op'=>'update'), true)?>"+ "&id=" + id+"&num=" + num;
		$.getJSON(url, function(s){

		});
	}
	
	function removeCart(id){
		if (confirm('您确定要删除此商品吗？')) {
			alert("正在处理数据...");
			var url = "<?php  echo murl('entry//mycart',array('m'=>'hc_credit_shopping','op'=>'remove'), true)?>"+ "&id=" + id;
			$.getJSON(url, function(s){
			console.log("#item_" + s.cartid);
				$("#item_" + s.cartid).remove();
				if($(".shopcart-item").length<=0){
					$("#cartempty").show();
					$("#cartfooter").hide();
				}
				//tip_close();
				canculate();
			});
		}
	}	
	
	
	
</script>  
  
  
  
  
  
 <script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=9&c=utility&a=visit&do=showjs&m=hc_credit_shopping"></script></body>
</html>