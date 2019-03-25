<?php

/**
 * demo model
 * Class Model_WxzSampleDemo
 */
class WxzpicliveSetting extends BaseModel
{
    public $table = 'wxz_piclive_setting';

    public static $types = [
        1 => '直播参数设置',
        2 => '小程序站点信息',
        3 => '界面文案',
        4 => '小程序审核开关数据',
        5 => '小程序全局UI配置',
        6 => '分佣配置',
        7 => '首页推荐列表',
    ];

    /**
     * 通过type获取配置
     * @param int $param1
     * @param string $param2
     * @return array
     */
    public function getByType($type, $format = 'unserilize')
    {
        if (!$type) {
            return;
        }

        if (!is_array($type)) {
            $condition = "uniacid={$this->uniacid} AND type={$type}";
            $result = $this->getRow($condition);

            if ($format && $result) {
                switch ($format) {
                    case 'unserilize':
                        $result['data'] = iunserializer($result['data']);
                        $result = array_merge($result, $result['data']);
                        break;
                }
            }
        } else {
            $condition = "uniacid={$this->uniacid} AND type in(" . implode(',', $type) . ")";
            $list = $this->getAll($condition);

            foreach ($list as $row) {
                if ($format) {
                    switch ($format) {
                        case 'unserilize':
                            $row['data'] = iunserializer($row['data']);
                            $row = array_merge($row, $row['data']);
                            break;
                    }
                }
                $result[$row['type']] = $row;
            }
        }
        return $result;
    }

    /**
     * 保存type数据
     * @param type $type
     * @param type $data
     */
    public function saveTypeData($type, $data)
    {
        if (!$type || !$data) {
            return;
        }
        $typeInfo = $this->getByType($type);
        if ($typeInfo) {
            $result = $this->updateById($typeInfo['id'], $data);
        } else {
            $data['type'] = $type;
            $result = $this->add($data);
        }
        return $result;
    }

    /**
     * 通过数组生成小程序配置
     * @param $info
     */
    public function buildSiteInfo($info)
    {
        if (!$info) {
            return;
        }

        ksort($info);
        $json = "var siteinfo = \n";
        $json .= wxzJsonEncode($info);
        $json .= ";module.exports = siteinfo;";
        //写入文件
        $dir = ADDON_PATH . '/wxz_multiroom/';
        if (!is_writable($dir)) {
            exit("请给{$dir}目录写入权限");
        }
        $ret = file_put_contents($dir . 'siteinfo.js', $json);
        if (!$ret) {
            exit("siteinfo.js 写入失败");
        }

        //替换的变量
        $appVars = [
            'window' =>
                [
                    'navigationBarTitleText' => $info['zh_name'],
                ],
        ];
        $appPath = $dir . "app.json";

        $this->setJsonData($appVars, $appPath);
    }

    /**
     * 替换变量
     * @param $vars
     * @param $path
     */
    public function setJsonData($vars, $path)
    {
        if (!file_exists($path)) {
            exit("{$path} 路径不存在");
        }

        $appContent = file_get_contents($path);
        $jsonDatas = json_decode($appContent, true);

        foreach ($jsonDatas as $k => $jsonData) {
            if (isset($vars[$k]) && !is_array($vars[$k])) {
                $jsonDatas[$k] = $vars[$k];
            }
            if (is_array($jsonData)) {
                foreach ($jsonData as $k1 => $json) {
                    if (isset($vars[$k][$k1])) {
                        $jsonDatas[$k][$k1] = $vars[$k][$k1];
                    }
                }
            }
        }
        $jsonDatas = stripslashes(json_encode($jsonDatas, JSON_UNESCAPED_UNICODE));
        $ret = file_put_contents($path, $jsonDatas);
        if (!$ret) {
            exit("{$path} 写入失败");
        }
    }

    /**
     * 读取app json数据
     */
    public function getAppJson()
    {
        $path = ADDON_PATH . '/app/app.json';
        $content = file_get_contents($path);
        $jsonArr = json_decode($content, true);
        var_dump($jsonArr);
        die;
    }

    /**
     * 获取底部导航列表
     */
    public function getNavBarList()
    {
        $result = [];

        $model = new BaseModel('wxz_multiroom_app_nav');

        $condition = "uniacid={$this->uniacid}";
        $list = $model->getAll($condition, '*', 'sort desc,id desc');

        foreach ($list as $k => $row) {
            $list[$k]['jump_data'] = iunserializer($list[$k]['jump_data']);
            $result[] = [
                'type' => $row['type'],
                'text' => $row['name'],
                'pagePath' => $list[$k]['jump_data']['page'],
                'iconPath' => tomedia($row['icon']),
                'selectedIconPath' => tomedia($row['select_icon']),
                'jumpData' => $list[$k]['jump_data'],
            ];
        }
        return $result;
    }
}