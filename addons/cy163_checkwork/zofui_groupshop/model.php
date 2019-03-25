<?php 

//购物车商品数量
if(!function_exists('getCartNumber')) {
	function getCartNumber(){
	  $cart = new Cart; 
	  return $cart->cartCount();
	}
}

