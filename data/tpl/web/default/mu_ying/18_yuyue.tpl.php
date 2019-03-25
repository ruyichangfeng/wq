<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<?php  if($op == 'display') { ?>
<table class="table we7-table table-hover article-list vertical-middle">
        <tr>
        	<td>id</td>
            <td>姓名</td>
            <td>手机号</td>
            <td>邮箱</td>
            <td>预约类型</td>
            <td class="text-right">操作</td>
        </tr>
        <?php  if(is_array($yuyue)) { foreach($yuyue as $item) { ?>
        <tr>
            <td>
                <?php  echo $item['id'];?>
            </td>
            <td>
                <?php  echo $item['name'];?>
            </td>
            <td>
                <?php  echo $item['tel'];?>
            </td>
            <td>
                <?php  echo $item['email'];?>
            </td>
            <td><?php  echo $item['leixin'];?></td>
            <td class="text-right">
                <a class="btn btn-default btn-sm" onclick="return confirm('此操作不可恢复，确认吗？'); return false;" href="<?php  echo $this->createWeburl('yuyue', array('id' => $item['id'], 'op' => 'delete'))?>">删除</a>
            </td>
        </tr>
        <?php  } } ?>
    </table>
<?php  } ?>
</div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>

