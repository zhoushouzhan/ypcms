<?php
// +----------------------------------------------------------------------
// | 一品内容管理系统 [ YPCMS ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2019 东海县一品网络技术有限公司
// +----------------------------------------------------------------------
// | 官方网站: http://www.yipinjishu.com
// +----------------------------------------------------------------------
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
		$subStr .= "<li><a href=\"" . url('index/category/index', ['categoryId' => $subMenu['id']]) . "\">" . $subMenu['title'] . "</a><ul>";
		for ($j = 0; $j < count($subMenu['children']); $j++) {
			$subStr .= getChildMenu($subMenu['children'][$j], $num);
		}
		$subStr .= "</ul></li>";
	} else {
		$subStr .= "<li><a href=\"" . url('index/category/index', ['categoryId' => $subMenu['id']]) . "\">" . $subMenu['title'] . "</a></li>";
	}
	return $subStr;
}
