<?php
// +----------------------------------------------------------------------
// | 一品内容管理系统 [ YPCMS ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2019 东海县一品网络技术有限公司
// +----------------------------------------------------------------------
// | 官方网站: http://www.yipinjishu.com
// +----------------------------------------------------------------------
declare (strict_types = 1);
use think\facade\Db;
//解析SQL文件为单条语句
function splitSQL($file, $pre, $defaultpre = "yp_") {
	if (file_exists($file)) {
		//读取SQL文件
		$sql = file_get_contents($file);
		$sql = str_replace("\r", "\n", $sql);
		$sql = str_replace("BEGIN;\n", '', $sql); //兼容 navicat 导出的 insert 语句
		$sql = str_replace("COMMIT;\n", '', $sql); //兼容 navicat 导出的 insert 语句
		$sql = trim($sql);
		//替换表前缀
		$sql = str_replace(" `{$defaultpre}", " `{$pre}", $sql);
		$sqls = explode(";\n", $sql);
		return $sqls;
	}
}

function doSql($sql) {
	$sql = trim($sql);
	preg_match('/CREATE TABLE .+ `([^ ]*)`/', $sql, $matches);
	if ($matches) {
		$table_name = $matches[1];
		$msg = "创建数据表{$table_name}";
		try {
			Db::query($sql);
			return [
				'error' => 0,
				'message' => $msg . ' 成功！',
			];
		} catch (\Exception $e) {
			return [
				'error' => 1,
				'message' => $msg . ' 失败！',
				'exception' => $e->getTraceAsString(),
			];
		}

	} else {
		try {
			Db::query($sql);
			return [
				'error' => 0,
				'message' => 'SQL执行成功!',
			];
		} catch (\Exception $e) {
			return [
				'error' => 0,
				'message' => 'SQL执行失败！',
				'exception' => $e->getTraceAsString(),
			];
		}
	}
}