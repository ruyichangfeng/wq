<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
global $_GPC, $_W;
$action = 'book';
$schoolid = intval($_GPC['schoolid']);
$GLOBALS['frames'] = $this->getNaveMenu($_GPC['schoolid'],$action);
$weid = $_W['uniacid'];
$page = $_GPC['page'] ? $_GPC['page'] : 1;
$pageSize = $_GPC['pageSize'] ? $_GPC['pageSize'] : 20;
$from = $pageSize*($page-1);
$logo = pdo_fetch("SELECT logo,title FROM " . tablename($this->table_index) . " WHERE id = '{$schoolid}'");
$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where id = :id ORDER BY ssort DESC", array(':id' => $schoolid));

$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

$it = pdo_fetch("SELECT * FROM " . tablename($this->table_classify) . " WHERE sid = :sid", array(':sid' => $sid));

$category = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " WHERE weid =  '{$weid}' AND schoolid ={$schoolid} ORDER BY sid ASC, ssort DESC", array(':weid' => $weid, ':schoolid' => $schoolid), 'sid');
$book_lb = $book_age = array();
foreach($category as $key => $value){
    switch($value['type']){
        case 'book_lb':
            $book_lb[$value['sid']] = $value;
            break;
        case 'book_age':
            $book_age[$value['sid']] = $value;
            break;
        default:
            break;
    }
}

if (empty($schoolid)) {
    message('没有选中任何学校!');
}

if ($operation == 'post') {
    load()->func('tpl');
    $id = intval($_GPC['id']);
    if (!empty($id)) {
        $item = pdo_fetch("SELECT * FROM " . tablename($this->table_book) . " WHERE id = :id", array(':id' => $id));

        if (empty($item)) {
            message('抱歉，不存在或是已经删除！', '', 'error');
        } else {
            if (!empty($item['thumb_url'])) {
                $item['thumbArr'] = explode('|', $item['thumb_url']);
            }
        }
    }
    if (checksubmit('submit')) {

        $data = array(
            'cat_id' => trim($_GPC['lb_id']),
            'age_id' => trim($_GPC['age_id']),
            'price'  => $_GPC['price'],
        );
        if (empty($id)) {
            pdo_insert($this->table_teachers, $data);
        } else {
            unset($data['dateline']);
            pdo_update($this->table_book, $data, array('id' => $id));
        }
        message('操作成功', $this->createWebUrl('book', array('op' => 'display', 'schoolid' => $schoolid)), 'success');
    }
} elseif ($operation == 'display') {

    $pindex = max(1, intval($_GPC['page']));
    $psize = 8;
    $condition = '';
    if (!empty($_GPC['keyword'])) {
        $keyWord = trim($_GPC['keyword']);
        $condition .= " AND instr(title,'{$keyWord}')";
    }

    if (!empty($_GPC['lb_id'])) {
        $bj_id = $_GPC['lb_id'];
        $condition .= " AND cat_id='{$_GPC['lb_id']}'";
    }

    if (!empty($_GPC['age_id'])) {
        $km_id = $_GPC['age_id'];
        $condition .= " AND age_id='{$_GPC['age_id']}'";
    }
    $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_book) . " WHERE id > 0 {$condition} ORDER BY id ASC limit {$from},{$pageSize}");
    $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' .tablename($this->table_book));

    $pager = pagination($total, $pindex, $psize);
}elseif($operation == 'delete'){
    $id = intval($_GPC['id']);
    if (!empty($id)) {
        $item = pdo_fetch("SELECT * FROM " . tablename($this->table_book) . " WHERE id = :id", array(':id' => $id));

        if (!empty($item)) {
            pdo_delete($this->table_book,array('id' => $id));
            message('操作成功', $this->createWebUrl('book', array('op' => 'display', 'schoolid' => $schoolid)), 'success');
        }else{
            message('抱歉，不存在或是已经删除！', '', 'error');
        }
    }else{
        message('抱歉，不存在或是已经删除！', '', 'error');
    }
}
include $this->template ( 'web/'.$action );
?>