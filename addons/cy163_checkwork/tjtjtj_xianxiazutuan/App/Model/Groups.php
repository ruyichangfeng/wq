<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/15 0015
 * Time: 上午 10:43
 */

namespace App\Model;

use \Core\Model;

class Groups extends Model
{

    protected $tablename = 'tjtjtj_xxzt_groups';

    protected $fieldArray = array(
        'sid',
        'gid',
        'needpeople',
        'donepeople',
        'intro',
        'create_at',
        'end_at',
        'status'
    );

    /**
     * 增加组团人数
     */
    public function addGroupsPeople($nums)
    {
        return pdo_update('UPDATE '.tablename($this->tablename).' SET donepeople = donepeople + '.$nums.' WHERE uid = :uid', array(':uid' => $this->getUid()));
    }

    /**
     * 获取当前组团
     */
    public function getCurGroups()
    {
        global $_W;
        $rec = pdo_fetchall(
            'SELECT gr.uid AS groupid,gr.needpeople,gr.donepeople,gr.intro,gr.create_at,gr.end_at,gr.status,gr.deposit,good.* FROM '.tablename($this->tablename).' AS gr
            INNER JOIN '.tablename('tjtjtj_xxzt_goods').' AS good ON gr.gid = good.uid
            WHERE gr.create_at < :cat AND end_at > :eat AND gr.sid = :sid ORDER BY gr.create_at DESC', array(':cat' => time(), ':eat' => time(), ':sid' => $_W['uniacid']));
        return $rec;
    }

    /**
     * 获取组团信息
     * @var int $uid
     * @return
     */
    public function getGroups($uid)
    {
        $rec = pdo_fetch(
            'SELECT
            gr.uid AS groupid,gr.needpeople,gr.donepeople,gr.intro,gr.create_at,gr.end_at,gr.status,gr.deposit,
            good.*,
            s.thumb AS sharethumb,s.title AS sharetitle,s.description AS sharedescription
            FROM '.tablename($this->tablename).' AS gr
            INNER JOIN '.tablename('tjtjtj_xxzt_goods').' AS good ON gr.gid = good.uid
            LEFT JOIN '.tablename('tjtjtj_xxzt_share').' AS s ON good.uid = s.gid
            WHERE gr.uid = :uid
            LIMIT 1',
            array(':uid' => $uid));
        return $rec;
    }

}