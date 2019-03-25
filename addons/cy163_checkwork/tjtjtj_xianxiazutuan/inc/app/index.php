<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/15 0015
 * Time: 上午 10:40
 */

$groupsModel = \App\Service\Factory::proGroupsModel();

$curgroups   = $groupsModel->getCurGroups();

if (count($curgroups) == 1) {
    $groups = $curgroups[0];
    $groups['atlas'] = explode('$', $groups['atlas']);
    include_once $this->template('groups');exit;
}

//获取幻灯片
$sliders = \App\Service\Factory::proSlidersModel()->getAll();

include_once $this->template('index');