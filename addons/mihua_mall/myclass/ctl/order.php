<?php 
namespace myclass\ctl;

class order {
    //order_id 查到该订单的商品
    public function orderIdFindGoods($id){
        $class_orderGoods 					 = D('orderGoods');
        $class_goods                         = D('goods');
        $class_orderGoods->params[':orderid'] = $id;
        $result = $class_orderGoods->paramsList();
        $list   = $result['list'];
        foreach ($list as $key => $value) {
            $goods_list[$key] = $class_goods->dataEdit($value['goodsid']);
        }
        return $goods_list;
    }
}