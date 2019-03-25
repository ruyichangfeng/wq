<?php

namespace app\api\controller;

use app\api\model\Goods as GoodsModel;
use app\api\model\Cart as CartModel;
use app\api\model\Comment as CommentModel;
use app\api\model\User;
use app\common\service\qrcode\Goods as GoodsPoster;
use app\api\model\Setting;
/**
 * 商品控制器
 * Class Goods
 * @package app\api\controller
 */
class Goods extends Controller
{
    /**
     * 商品列表
     * @param $category_id
     * @param $search
     * @param $sortType
     * @param $sortPrice
     * @return array
     * @throws \think\exception\DbException
     */
    public function lists($category_id, $search, $sortType, $sortPrice)
    {
        $model = new GoodsModel;
        $list = $model->getList(10, $category_id, $search, $sortType, $sortPrice);
        return $this->renderSuccess(compact('list'));
    }

    /**
     * 获取商品详情
     * @param $goods_id
     * @return array
     * @throws \think\exception\DbException
     */
    public function detail($goods_id)
    {
        // 商品详情
        $detail = GoodsModel::detail($goods_id);
        if (!$detail || $detail['goods_status']['value'] !== 10) {
            return $this->renderError('很抱歉，商品信息不存在或已下架');
        }
        // 规格信息
        $specData = $detail['spec_type'] === 20 ? $detail->getManySpecData($detail['spec_rel'], $detail['spec']) : null;
//        $user = $this->getUser();
//        // 购物车商品总数量
//        $cart_total_num = (new CartModel($user['user_id']))->getTotalNum();
        //获取分享人的信息
        $uid = $this->request->get('inviter_id');
        $inviter = ['nickName' => '', 'avatarUrl' => ''];
        if ($uid) {
            $info = User::detail(['user_id' => $uid]);
            $inviter['nickName'] = $info['nickName'];
            $inviter['avatarUrl'] = $info['avatarUrl'];
        }
        $comments = (new CommentModel)->getGoodsCommentList($goods_id);
        $config = Setting::getItem('store');
        $is_show  = isset($config['is_wx_checked']) ?  $config['is_wx_checked'] : 0;
        $inviter_desc = $is_show == 0 ? '好友品质助力' : '';
        $is_show = $is_show == 0 ? 1 : 0;
        return $this->renderSuccess(compact('detail', 'cart_total_num', 'specData', 'inviter','comments','is_show','inviter_desc'));
    }

      /**
     * 获取推广二维码
     * @param $goods_id
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     * @throws \Exception
     */
    public function poster($goods_id)
    {
        // 商品详情
        $detail = GoodsModel::detail($goods_id);
        $Qrcode = new GoodsPoster($detail, $this->getUser(false));
        return $this->renderSuccess([
            'qrcode' => $Qrcode->getImage(),
        ]);
    }

}
