<?php 
namespace myclass\ctl;
class platform{
    //获取mihua_mall所在的组
    public function getLianhuSchoolGroup(){
        $list        = pdo_fetchall("select * from  ".tablename("uni_group")." ");
        $group_ids[] = '-1';
        foreach($list as $row){
            $modules = unserialize($row['modules']);
            if($modules){
                foreach ($modules as  $value) {
                    if($value=='mihua_mall'){
                        $group_ids[]=$row['id'];
                        break;
                    }
                }
            }
        }
        $this->group_ids = $group_ids;
        return $group_ids;
    }
    //该公众号有没有mihua_mall的权限
    public function validPlatformLianhuSchool($uniacid){
        if(!$this->group_ids){
            $this->getLianhuSchoolGroup();
        }
        $in_str   = implode(',',$this->group_ids);
        $result   = pdo_fetch("select * from ".tablename('uni_account_group')." where  uniacid = ".$uniacid." and groupid in (".$in_str.") ");       
        return $result;
    }
    //获取所有有权限的公众号
    public function getAllPlatform(){
 	        $sql    = "SELECT * FROM ". tablename('uni_account'). " as a LEFT JOIN". tablename('account'). " as b ON a.default_acid = b.acid where b.isdeleted <> 1 order by a.`rank` DESC, a.`uniacid` DESC ";
            $list   = pdo_fetchall($sql, $pars);
            if(!empty($list)) {
                foreach($list as $unia => &$account) {
                    $account['details'] = uni_accounts($account['uniacid']);
                    $account['setmeal'] = uni_setmeal($account['uniacid']);
                    $have_power         = $this->validPlatformLianhuSchool($account['uniacid']);
                    $have_power = true;
                    if(!$have_power)
                        unset($list[$unia]);
                }
            } 
            return $list;
    }

}