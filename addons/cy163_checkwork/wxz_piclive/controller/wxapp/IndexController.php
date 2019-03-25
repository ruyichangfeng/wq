<?php
/**
 * 首页相关接口
 * Created by PhpStorm.
 * User: lirui
 * Date: 2018/3/1
 * Time: 下午2:21
 */

class IndexController extends BaseController
{
    public function ActionIndex()
    {
        //获取banner
        $model = new BaseModel('wxz_multiroom_banner');
        $condition = "`uniacid`={$this->uniacid}";
        $result['banner'] = $model->getAll($condition);
        foreach ($result['banner'] as $k => $v) {
            $result['banner'][$k]['jump_data'] = iunserializer($v['jump_data']);
            $result['banner'][$k]['pic'] = tomedia($v['pic']);
        }

        //获取推荐分类
        $modelCategory = new BaseModel('wxz_multiroom_category');
        $modelLive = new Model_WxzmultiroomLive();

        $condition = "`uniacid`={$this->uniacid} AND is_del=0 AND show_index=1";
        $result['category'] = $modelCategory->getAll($condition);

        foreach ($result['category'] as $k => $v) {
            $result['category'][$k]['pic'] = tomedia($v['pic']);
        }
        $result['category'] = array_chunk($result['category'], 4);

        $model = new Model_WxzmultiroomSetting();
        $type = 7;
        $info = $model->getByType($type);
        $ids = $info['recommend'];
        $recommentPics = $info['recomment_pics'];

        $result['bg_pourout'] = tomedia($info['bg_pourout']);

        if ($ids) {
            $ids = explode(',', $ids);
            $recommentPics = explode(',', $recommentPics);

            $result['recommend'] = $modelLive->getById($ids);

            $i = 0;
            foreach ($result['recommend'] as $k => $v) {
                $result['recommend'][$k]['thumb'] = tomedia($recommentPics[$i]);
                $i++;
            }
            $result['recommend'] = array_chunk($result['recommend'], 2);
        }

        $this->ajaxSucceed('', $result);
    }

    public function ActionTest()
    {
        var_dump(111);
        die;
//        $_SESSION['session_test'] = 123123;
//        $userInfo = mc_fansinfo($this->_W['openid']);
//        var_dump($this->userId);
//        die;
//        var_dump($_SESSION);
//        die;
    }

    /**
     * 首页直播间列表
     */
    public function ActionIndexLiveList()
    {
        $result = [];

        //其他分类
        $page = (int)$this->_GPC['pid'];//页面id
        $page = max(1, $page);
        $pageNum = (int)$this->_GPC['page_num'];//一页显示数量
        $modelSetting = new Model_WxzmultiroomSetting();
        $copywriting = $modelSetting->getByType(3);

        if (!$pageNum) {
            $pageNum = 20;//默认显示20页
        }

        $modelLive = new Model_WxzmultiroomLive();

        $category = (int)$this->_GPC['cid'];//分类id,-1 热门，-2 最新 -3 关注 >0 商品分类id

        if (!$category) {
            $category = -1;
        }

        $order = "sort desc";
//        $condition = "uniacid={$this->uniacid} AND is_del=0 AND live_status=1 AND is_show=1";
        $condition = "uniacid={$this->uniacid} AND is_del=0 AND is_show=1";

        if ($category == -1) {
            $order = "sort desc,view_num desc";//热门直播间
        } else if ($category == -2) {
            $order = "id desc";//最新直播间
        } elseif ($category > 0) {
            //判断是一级分类还是二级分类
            $modelGoodCategory = new BaseModel('wxz_multiroom_goods_category');
            $categoryInfo = $modelGoodCategory->getById($category, 'parent_id');
            if ($categoryInfo['parent_id'] == 0) {
                $condition .= " AND category1_id={$category}";
            } else {
                $condition .= " AND category2_id={$category}";
            }
            $order = "view_num desc";//直播间分类
        }

        $offset = ($page - 1) * $pageNum;
        $limit = $offset . ',' . $pageNum;

        if ($category == -3) {
            //获取关注的直播间列表
            #1. 获取用户
            $liveList = $modelLive->getUserFollowOnLives($this->userId);
        } else {
            $liveList = $modelLive->getAll($condition, '*', $order, $limit);
        }

        //获取商品，格式化数据
        foreach ($liveList as $live) {
            $anchorInfo = $modelLive->getLiveAnchorInfo($live['id']);

            $liveInfo = [
                'id' => $live['id'],
                'name' => $live['name'],
                'thumb' => tomedia($live['thumb']),
                'live_status' => $live['live_status'],
                'view_num' => $live['view_num_type'] == 1 ? $live['view_num'] : $live['real_num'],
                'good_num' => $live['good_num'],
                //主播信息
                'anchor' => [
                    'id' => $anchorInfo['id'],
                    'nickname' => $anchorInfo['nickname'],
                ],
            ];
            //直播间商品
            $liveGoods = $modelLive->getLiveGoods($live['id'], 3);
            $liveGoodsCount = $modelLive->getLiveCountGoods($live['id']);
            $liveInfo['goods_num'] = $liveGoodsCount;
            if ($liveGoods) {
                foreach ($liveGoods as $liveGood) {
                    $liveInfo['goods'][] = [
                        'id' => $liveGood['id'],
                        'thumb' => tomedia($liveGood['thumb']),
                    ];
                }
                $liveInfo['goods_unit'] = $liveGood['unit'];
                $liveInfo['index_live_goods_list_desc'] = $copywriting['index_live_goods_list_desc'];
            }

            $result[] = $liveInfo;
        }
        $this->ajaxSucceed('', $result);
    }

    /**
     * 首页推荐分类
     */
    public function ActionIndexCategory()
    {
        $result = [];

        $modelLive = new Model_WxzmultiroomLive();
        $categorys = $modelLive->getRecommendCategorys();
        $result = [
            ['cid' => -1, 'cname' => '热门'],
            ['cid' => -2, 'cname' => '最新'],
            ['cid' => -3, 'cname' => '关注'],
        ];
        //格式化数据
        foreach ($categorys as $category) {
            $result[] = ['cid' => $category['id'], 'cname' => $category['name']];
        }

        $this->ajaxSucceed('', $result);
    }

    /**
     * 获取微信小程序审核开关数据
     */
    public function ActionAppCheckData()
    {
        $type = 4;
        $model = new Model_WxzmultiroomSetting();
        $setting = $model->getByType($type);
        unset($setting['data'], $setting['id'], $setting['uniacid'], $setting['type'], $setting['update_time']);
        if ($setting['logo']) {
            $setting['logo'] = tomedia($setting['logo']);
        }
        if ($setting['thumbs']) {
            $setting['thumb_list'] = explode(';', $setting['thumbs']);
            unset($setting['thumbs']);
            $setting['thumb_list'] = array_map(function ($v) {
                return tomedia($v);
            }, $setting['thumb_list']);
        }

        $this->ajaxSucceed('', $setting);
    }

    /**
     * 获取站点信息å
     */
    public function ActionSiteInfo()
    {
        $type = 2;
        $model = new WxzpicliveSetting();
        $info = [];//$model->getByType($type);

        $result = [
            'logo' => tomedia($info['logo']),
            'version' => $info['version'] ? $info['version'] : '1.0.0',
            'navigationBarTitleText' => $info['zh_name'],
        ];

        //顶部导航数据格式化
        $result['data'] = wxzClearEmptyArr($result['data']);
        $this->ajaxSucceed('', $result);
    }

}