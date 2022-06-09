<?php
declare(strict_types=1);
function array2level($array, $pid = 0, $level = 1)
{
	static $list = [];
	foreach ($array as $v) {
		if ($v['pid'] == $pid) {
			$v['level'] = $level;
			$list[] = $v;
			array2level($array, $v['id'], $level + 1);
		}
	}
	return $list;
}
//获取父ID1
function get_parent_id($data, $id)
{
	foreach ($data as $key => $value) {
		if ($value['id'] == $id) {
			if ($value['pid']) {
				return get_parent_id($data, $value['pid']);
			} else {
				return $value['id'];
			}
		}
	}
}
//创建目录
function MkDirs($dir)
{
	return is_dir($dir) or (MkDirs(dirname($dir)) and mkdir($dir, 0777));
}
//递归子目录
function getChildMenu($subMenu, $num)
{
	$num++;
	$subStr = "";
	if (isset($subMenu['children']) && count($subMenu['children']) > 0) {
		$subStr .= "<dd><ul><li class=\"layui-nav-item\" ><a style=\"margin-left:" . ($num * 10) . "px\"  href=\"javascript:;\"><i class='" . $subMenu['icon'] . "'></i> " . $subMenu['title'] . "</a><dl class=\"layui-nav-child\">\n";
		for ($j = 0; $j < count($subMenu['children']); $j++) {
			$subStr .= getChildMenu($subMenu['children'][$j], $num);
		}
		$subStr .= "</dl></li></ul></dd>";
	} else {
		$subStr .= "<dd><a style=\"margin-left:" . ($num * 10) . "px\" href=\"" . $subMenu['name'] . "\"><i class='" . $subMenu['icon'] . "'></i> " . $subMenu['title'] . "</a></dd>";
	}
	return $subStr;
}
//删除目录及文件
function removeDir($path, $delDir = false)
{
	if (is_array($path)) {
		foreach ($path as $subPath) {
			removeDir($subPath, $delDir);
		}
	}
	if (is_dir($path)) {
		$handle = opendir($path);
		if ($handle) {
			while (false !== ($item = readdir($handle))) {
				if ($item != "." && $item != "..") {
					is_dir("$path/$item") ? removeDir("$path/$item", $delDir) : unlink("$path/$item");
				}
			}
			closedir($handle);
			if ($delDir) {
				return rmdir($path);
			}
		}
	} else {
		if (file_exists($path)) {
			return unlink($path);
		} else {
			return false;
		}
	}
}
//导入时间格式化
function GetData($val)
{
	$jd = GregorianToJD(1, 1, 1970);
	$gregorian = JDToGregorian($jd + intval($val) - 25569);
	return $gregorian;
}
function isDate($str, $format = 'Y/m/d')
{
	$unixTime_1 = strtotime($str);
	if (!is_numeric($unixTime_1)) {
		return false;
	}
	$checkDate = date($format, $unixTime_1);
	$unixTime_2 = strtotime($checkDate);
	if ($unixTime_1 == $unixTime_2) {
		return true;
	} else {
		return false;
	}
}
function RestaDeArrays($vectorA, $vectorB)
{
	$cantA = count($vectorA);
	$cantB = count($vectorB);
	$No_saca = 0;
	for ($i = 0; $i < $cantA; $i++) {
		for ($j = 0; $j < $cantB; $j++) {
			if ($vectorA[$i] == $vectorB[$j]) {
				$No_saca = 1;
			}
		}
		if ($No_saca == 0) {
			$nuevo_array[] = $vectorA[$i];
		} else {
			$No_saca = 0;
		}
	}
	return $nuevo_array;
}
