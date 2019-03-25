<?php
/**
 * 购物车类 Cookies 保存，保存周期为1天 注意：浏览器必须支持Cookie才能够使用
 */
 
class Cart {
	private $cartArray = array(); // 存放购物车的二维数组
	private $cartCount; // 统计购物车数量
	public $expires = 2678400; // Cookies过期时间，如果为0则不保存到本地 单位为秒 /一个月。
	/**
	 * 构造函数 初始化操作 如果$Id不为空，则直接添加到购物车
	 *
	 */
	public function __construct($id = '',$title = '',$nowPrice = '',$count = '',$rule = '',$image = '') {
		if ($id != '' && is_numeric($id)) {
			$this->addCart($id,$title,$nowPrice,$count,$rule,$image);
		}
	}
	/**
	 * 添加商品到购物车
	 *
	 * @param int $id 商品的编号
	 * @param string $title 商品名称
	 * @param decimal $nowPrice 商品价格
	 * @param int $count 商品数量
	 * @param int $rule 商品规格	 
	 * @param string $image 商品图片
	 * @return 如果商品存在，则在原来的数量上加1，并返回true
	 */
	public function addCart($id,$title,$nowPrice,$count,$rule,$image) {
		$this->cartArray = $this->cartView(); // 把数据读取并写入数组
		if ($this->checkItem($id)) { // 检测商品是否存在
			$this->modifyCart($id,$count,$rule,$nowPrice,'edit'); // 已存在修改
			return true;
		}
		$this->cartArray[$id]['id'] = $id;
		$this->cartArray[$id]['title'] = $title;
		$this->cartArray[$id]['price'] = $nowPrice;
		$this->cartArray[$id]['count'] = $count;
		$this->cartArray[$id]['rule'] = $rule;
		$this->cartArray[$id]['image'] = $image;
		return $this->save();
	}
	
	//批量删除，不能使用modifyCart循环批量删除，因为cookie需要刷新一次获取一次，如果循环删除始终获取的是初始的值，而不是修改后的值
	public function deleteManyCart($idarray){
		if(!is_array($idarray)) return false;
		$this->cartArray = $this->cartView(); // 把数据读取并写入数组		
		foreach ($this->cartArray as $item) {
			foreach($idarray as $k => $v){
				if($item['id'] == $v) unset($this->cartArray[$v]);
			}
		}
		return $this->save();
	}	
	
	
	/**
	 * 修改购物车里的商品
	 *
	 * @param int $id 商品id
	 * @param int $count 商品数量
	 * @param int $type 修改类型 add：加 minus:减 edit:修改 clear:清空
	 * @return 如果修改失败，则返回false
	 */
	public function modifyCart($id, $count,$rule,$price, $type = '') {
		$tmpId = $id;
		$this->cartArray = $this->cartView(); // 把数据读取并写入数组
		$tmpArray = &$this->cartArray;  // 引用
		if (!is_array($tmpArray)) return false;
		if ($id < 1) {
			return false;
		}
		foreach ($tmpArray as $item) {
			if ($item['id'] === $tmpId) {
				switch ($type) {
					case 'add': // 添加数量 一般$Count为1
						$tmpArray[$tmpId]['count'] += $count;
						$tmpArray[$tmpId]['rule'] = $rule;
						$tmpArray[$tmpId]['price'] = $price;
						break;
					case 'minus': // 减少数量
						$tmpArray[$tmpId]['count'] -= $count;
						$tmpArray[$tmpId]['rule'] = $rule;
						$tmpArray[$tmpId]['price'] = $price;
						break;
					case 'edit': // 修改数量
						if ($count == 0) {
							unset($tmpArray[$tmpId]);
							break;
						} else {
							$tmpArray[$tmpId]['count'] = $count;
							$tmpArray[$tmpId]['rule'] = $rule;
							$tmpArray[$tmpId]['price'] = $price;
							break;
						}
					case 'clear': //删除商品
						unset($tmpArray[$tmpId]);
						break;
					default:
						break;
				}
			}
		}
		return $this->save();
	}
	/**
	 * 清空购物车
	 *
	 */
	public function removeAll() {
		$str = self::structCartString();
		return setcookie($str,'',time()-$this->expires - 3600);
	}
	
	
	/**
	 * 用户唯一购物车cookie标识
	 *
	 * @return array 返回一个字符串
	 */	
	private static function structCartString(){
		global $_W;			
		$rump = substr($_W['openid'], -6);
		return 'fshopcart'.$rump.$_W['uniacid'];
	}	
	
	/**
	 * 查看购物车信息
	 *
	 * @return array 返回一个二维数组
	 */
	public function cartView() {
		
		$str = self::structCartString();
		$cookie = $_COOKIE[$str];	
		if (empty($cookie)) return array();
		$cart = authcode($cookie,'DECODE'); //解密			
		return iunserializer($cart);	 //反序列
	}
	/**
	 * 检查购物车是否有商品
	 *
	 * @return bool 如果有商品，返回true，否则false
	 */
	public function checkCart() {
		$tmpArray = $this->cartView();
		if (count($tmpArray) < 1) {			
			return false;
		}
		return true;
	}

	/**
	 * 统计商品数量
	 *
	 * @return int
	 */
	public function cartCount() {
		$tmpArray = $this->cartView();
			
		$tmpCount = count($tmpArray);		
		$this->cartCount = $tmpCount;
		return $tmpCount;
	}
	/**
	 * 保存商品 如果不使用构造方法，此方法必须使用
	 *
	 */
	public function save() {
		$tmpArray = $this->cartArray;
		$tmpSerialize = authcode(iserializer($tmpArray),'ENCODE');
		$str = self::structCartString();
		return setcookie($str,$tmpSerialize,time()+$this->expires);
	}
	/**
	 * 检查购物车商品是否存在
	 *
	 * @param int $id
	 * @return bool 如果存在 true 否则false
	 */
	private function checkItem($id) {
		$tmpArray = $this->cartArray = $this->cartView();
		return is_array($tmpArray[$id]);
	}
}
?>