<?php
/*
 * @Author: 一品网络技术有限公司
 * @Date: 2022-06-08 07:55:45
 * @LastEditTime: 2022-06-08 11:20:05
 * @FilePath: \ypcms\app\index\common.php
 * @Description:
 * 联系QQ:58055648
 * Copyright (c) 2022 by 东海县一品网络技术有限公司, All Rights Reserved.
 */

declare(strict_types=1);
//通用查询函数
function model($tbname, $map = [], $limit = 0, $order = [])
{
	$tbname = ucfirst($tbname);
	$modelName = "\app\common\model\\$tbname";
	$model = new $modelName;
	return $model->where($map)->limit($limit)->order($order)->select();
}
function hidePhone($mobile)
{
	return preg_replace('/(\d{3})([\d\s]+)(\d{4})/', '$1****$3', $mobile);
}
//递归子目录
function getChildMenu($subMenu, $num)
{
	$num++;
	$subStr = "";
	if (isset($subMenu['children']) && count($subMenu['children']) > 0) {
		$subStr .= "<li><a href=\"" . $subMenu['url'] . "\">" . $subMenu['title'] . "</a><ul>";
		for ($j = 0; $j < count($subMenu['children']); $j++) {
			$subStr .= getChildMenu($subMenu['children'][$j], $num);
		}
		$subStr .= "</ul></li>";
	} else {
		$subStr .= "<li><a href=\"" . $subMenu['url'] . "\">" . $subMenu['title'] . "</a></li>";
	}
	return $subStr;
}
