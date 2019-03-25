<?php
// 输出会员等级
function echoMemberLevel($level=0)
{
	switch ($level) {
		case 0:
			echo "普通会员";
			break;
		case 1:
			echo "天会员";
			break;
		case 2:
			echo "月会员";
			break;
		case 3:
			echo "年会员";
			break;
		case 9:
			echo "代理商";
			break;
		default:
			echo "异常";
			break;
	}
}