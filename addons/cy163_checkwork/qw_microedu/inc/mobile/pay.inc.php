<?php
/**
 * Created by PhpStorm.
 * User: sks
 * Date: 16/9/26
 * Time: 下午4:15
 */
defined("IN_IA") or exit("Access Denied");
//include MODULE_ROOT."/inc/mobile/init.php";
global  $_W,$_GPC;

function user()
{
    global $_W;
    $sql = "SELECT * FROM " . tablename('qw_microedu_users') . " WHERE uniacid=:uniacid AND openid=:openid AND role_type=:role_type";
    $params = array(
        ':uniacid' => $_W['uniacid'],
        ':openid' => $_W['openid'],
        ':role_type' => 'parents'
    );

    return pdo_fetch($sql,$params);
}


if($_W['ispost'])
{
    if($_GPC['ids'])
    {
        $user = user();

        $data = array(
            'status' => 0,
            'time' => date('Y-m-d H:i:s')
        );
        $result = pdo_insert('qw_microedu_transactions', $data);
        if (!empty($result))
        {
            $transactions_id = pdo_insertid();
        }
        else
        {
            message("购买失败",$this->createMobileUrl("parent",array('page'=>'dinggou')),"error");die;
        }

        $parentscontracts_id = array();
        $invoices_id = array();
        $money = 0;
        $ids = array_unique(array_filter(explode(',',$_GPC['ids'])));
        foreach($ids as $key => $value)
        {
            $sql = "SELECT contract_name,contract_price,contract_duration FROM "
                . tablename('qw_microedu_contracts') .
                " WHERE uniacid=:uniacid AND id=:id ";
            $params = array(
                ':uniacid' => $_W['uniacid'],
                ':id' => $value
            );
            $contract = pdo_fetch($sql, $params);

            //这里加一个判断 如果之前购买过 就不再次购买了
            $sql = "SELECT id FROM "
                . tablename('qw_microedu_parentscontracts') .
                " WHERE uniacid=:uniacid AND parent_id=:parent_id AND contract_id=:contract_id AND status!=0 ";
            $params = array
            (
                ':uniacid' => $_W['uniacid'],
                ':parent_id' => $user['id'],
                ':contract_id' => $value
            );
            $parentscontract = pdo_fetch($sql,$params);
            if(!empty($parentscontract))
            {
                $parentscontracts_id[] = $parentscontract['id'];

                $data = array(
                    'uniacid' => $_W['uniacid'],
                    'parent_id' => $user['id'],
                    'item_name' => $contract['contract_name'],
                    'item_price' => $contract['contract_price'],
                    'transaction_id' => $transactions_id,
                    'parentscontracts_id' => $parentscontract['id'],
                    'status' => 0 //0失败/还没支付 1支付成功
                );

                $res = pdo_insert('qw_microedu_invoices', $data);
                if (!empty($res))
                {
                    $invoices_id[] = pdo_insertid();
                    $money = $money + $contract['contract_price'];
                }
            }
            else
            {
                $endtime = time() + $contract['contract_duration']*24*60*60;//时长
                $data = array(
                    'uniacid' => $_W['uniacid'],
                    'parent_id' => $user['id'],
                    'contract_id' => $value,
                    'contract_price' => $contract['contract_price'],
                    'contract_startdate' => date('Y-m-d'),
                    'contract_enddate' => date('Y-m-d',$endtime),
                    'status' => 0 //0为购买失败/未购买 1为购买成功 2为暂停合同
                );

                $result = pdo_insert('qw_microedu_parentscontracts', $data);
                if (!empty($result))
                {
                    $parentscontracts_id[] = pdo_insertid();

                    $data = array(
                        'uniacid' => $_W['uniacid'],
                        'parent_id' => $user['id'],
                        'item_name' => $contract['contract_name'],
                        'item_price' => $contract['contract_price'],
                        'transaction_id' => $transactions_id,
                        'parentscontracts_id' => pdo_insertid(),
                        'status' => 0 //0失败/还没支付 1支付成功
                    );

                    $res = pdo_insert('qw_microedu_invoices', $data);
                    if (!empty($res))
                    {
                        $invoices_id[] = pdo_insertid();
                        $money = $money + $contract['contract_price'];
                    }
                }
            }
        }

        if($parentscontracts_id && $invoices_id && $money)//前两个id数组不可以为空 最后一个金额必须大于0
        {
            //根据提交的信息创建订单保存post
            $params['tid'] = $transactions_id;          //充值模块中的订单号，此号码用于业务模块中区分订单，交易的识别码
            $params['user'] = "{$user['fullname']}";    //付款用户, 付款的用户名(选填项)
            $params['fee'] = $money;                    //收银台中显示需要支付的金额,只能大于 0
            $params['title'] = "家长购买合同";           //收银台中显示的标题
            $params['ordersn'] = $transactions_id;      //收银台中显示的订单号
            include $this->template("pay");
        }
        else
        {
            $parentscontracts_id = implode($parentscontracts_id,',');
            pdo_query("DELETE FROM ".tablename('qw_microedu_parentscontracts')." WHERE id in (".$parentscontracts_id.")");

            $invoices_id = implode($invoices_id,',');
            pdo_query("DELETE FROM ".tablename('qw_microedu_invoices')." WHERE id in (".$invoices_id.")");

            message("购买失败",$this->createMobileUrl("parent",array('page'=>'dinggou')),"error");die;
        }
    }
    else
    {
        message("请先选择合同",$this->createMobileUrl("parent",array('page'=>'dinggou')),"error");die;
    }
}
else
{
    message("购买失败",$this->createMobileUrl("parent",array('page'=>'dinggou')),"error");die;
}
