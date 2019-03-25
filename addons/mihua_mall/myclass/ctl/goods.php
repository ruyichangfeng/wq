<?php 
namespace myclass\ctl;

class goods {
    //从 goods_list 组合出 名字(,)
    public function composeGoodsName($goods_list){
        $goods_name = getSomeFromArr($goods_list,'title');
        return implode(',',$goods_name);
    }

}