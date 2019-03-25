<?php

/**
 * used: 
 * User: imeepos
 * Qq: 1037483576
 */
class quickmenu
{
    public $table = 'imeepos_coach_quickmenu';

    public function __construct()
    {
        $this->install();
    }

    public function getall(){
        global $_W;
        $sql = "SELECT * FROM ".tablename($this->table)." WHERE uniacid = :uniacid ORDER BY displayorder DESC ";
        $params = array('uniacid'=>$_W['uniacid']);
        $list = pdo_fetchall($sql,$params);
        return $list;
    }

    public function delete($id){
        if(empty($id)){
            return '';
        }
        pdo_delete($this->table,array('id'=>$id));
    }

    public function getList($page,$where =""){
        global $_W;
        if(empty($page)){
            $page = 1;
        }
        $psize = 20;
        $total = 0;
        $sql = "SELECT * FROM ".tablename($this->table)." WHERE uniacid = :uniacid {$where} ORDER BY create_time DESC limit ".(($page-1)*$psize).",".$psize;
        $params = array(':uniacid'=>$_W['uniacid']);
        $result = array();
        $result['list'] = pdo_fetchall($sql,$params);
        $sql = "SELECT COUNT(*) FROM ".tablename($this->table)." WHERE uniacid = :uniacid {$where}";
        $total = pdo_fetchcolumn($sql,$params);

        $result['pager'] = pagination($total, $page, $psize);
        if(empty($result)){
            return array();
        }else{
            return $result;
        }
    }
    public function update($data){
        global $_W;
        $data['uniacid'] = $_W['uniacid'];
        if(empty($data['id'])){
            pdo_insert($this->table,$data);
            $data['id'] = pdo_insertid();
        }else{
            //更新
            pdo_update($this->table,$data,array('uniacid'=>$_W['uniacid'],'id'=>$data['id']));
        }
        return $data;
    }
    public function getMenu2(){
        global $_W, $_GPC;
        $quickmenu = M('quickmenu')->getall();
        if (empty($quickmenu)) {
            return false;
        }
        $html = '<div class="js-quickmenu nav-menu-path rotate-nav has-nav-4 "><div class="nav-group">';
        foreach ($quickmenu as $quick){
            $html .='<div class="nav-group-item"><a href="'.$quick['link'].'" style="color:#fff;line-height:45px;">'.$quick['title'].'</a></div>';
        }
        $html .= '</div><div class="nav-home nav-group-item js-quickmenu-toggle"><a href="javascript:;" style="background-image:url(./resource/images/app/centerbtn.png);" class="contrl-btn" style=""></a></div></div>';
        $html .= "<script type=\"text/javascript\">
	$('.js-quickmenu').find('a').each(function(){
		if ($(this).attr('href')) {
			var url = $(this).attr('href').replace('./', '');
			if (location.href.indexOf(url) > -1) {
				var onclass = $(this).find('i').attr('js-onclass-name');
				if (onclass) {
					$(this).find('i').attr('class', onclass);
					$(this).find('i').css('color', $(this).find('i').attr('js-onclass-color'));
				}
			}
		}
	});</script>";
        return $html;
    }
    public function getMenu(){
        global $_W, $_GPC;
        $quickmenu = M('quickmenu')->getall();
        if (empty($quickmenu)) {
            return false;
        }
        $html = '<div class="js-quickmenu nav-menu-path rotate-nav has-nav-4 "><div class="nav-group">';
        foreach ($quickmenu as $quick){
            $html .='<div class="nav-group-item"><a href="'.$quick['link'].'" style="color:#fff;line-height:45px;">'.$quick['title'].'</a></div>';
        }
        $html .= '</div><div class="nav-home nav-group-item js-quickmenu-toggle"><a href="javascript:;" class="contrl-btn" style=""></a></div></div>';
        $html .= "<script type=\"text/javascript\">
	$('.js-quickmenu').find('a').each(function(){
		if ($(this).attr('href')) {
			var url = $(this).attr('href').replace('./', '');
			if (location.href.indexOf(url) > -1) {
				var onclass = $(this).find('i').attr('js-onclass-name');
				if (onclass) {
					$(this).find('i').attr('class', onclass);
					$(this).find('i').css('color', $(this).find('i').attr('js-onclass-color'));
				}
			}
		}
	});</script>";
        return $html;
    }
    public function getInfo($id){
        global $_W;
        $item = pdo_get($this->table,array('id'=>$id));
        return $item;
    }
    public function install(){
        if(!pdo_tableexists($this->table)){
            $sql = "CREATE TABLE ".tablename($this->table)." (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `uniacid` int(11) DEFAULT '0',
              PRIMARY KEY (`id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8";
            pdo_query($sql);
        }
        if(!pdo_fieldexists($this->table,'create_time')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `create_time` int(11) DEFAULT '0'");
        }
        if(!pdo_fieldexists($this->table,'title')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `title` varchar(32) DEFAULT ''");
        }
        if(!pdo_fieldexists($this->table,'icon')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `icon` varchar(320) DEFAULT ''");
        }
        if(!pdo_fieldexists($this->table,'link')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `link` varchar(320) DEFAULT ''");
        }
        if(!pdo_fieldexists($this->table,'displayorder')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `displayorder` int(11) DEFAULT '0'");
        }
        if(!pdo_fieldexists($this->table,'ido')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `ido` varchar(32) DEFAULT ''");
        }
    }
}