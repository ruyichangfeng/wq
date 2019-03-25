<?php

namespace app\store\model;

use app\common\model\Setting as SettingModel;
use think\Cache;
use think\DB;

/**
 * 系统设置模型
 * Class Wxapp
 * @package app\store\model
 */
class Setting extends SettingModel
{
    /**
     * 设置项描述
     * @var array
     */
    private $describe = [
        'sms' => '短信通知',
        'storage' => '上传设置',
        'store' => '商城设置',
        'trade' => '交易设置',
    ];

    /**
     * 更新系统设置
     * @param $key
     * @param $values
     * @return bool
     * @throws \think\exception\DbException
     */
    public function edit($key, $values)
    {
        $model = self::detail($key) ?: $this;
        // 删除系统设置缓存
        Cache::rm('setting_' . self::$wxapp_id);
        return $model->save([
            'key' => $key,
            'describe' => $this->describe[$key],
            'values' => $values,
            'wxapp_id' => self::$wxapp_id,
        ]) !== false ?: false;
    }

    //获取微擎 底部版权信息
    public function getWqSetting($type){
        $config = call_user_func(function () {
            $config = [];
            require __DIR__ . '/../../../../../../data/config.php';
            return $config['db']['master'];
        });
        $setting = DB::table($config['tablepre'].'core_settings')->where(['key' => $type])->field('value')->find();
        return unserialize($setting['value']);
    }

}
