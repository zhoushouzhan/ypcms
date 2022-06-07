<?php
/*
 * @Author: 一品网络技术有限公司
 * @Date: 2021-11-08 08:30:36
 * @LastEditTime: 2022-05-22 15:06:50
 * @FilePath: \ypcms\app\admin\controller\Index.php
 * @Description:
 * 联系QQ:58055648
 * Copyright (c) 2022 by 东海县一品网络技术有限公司, All Rights Reserved.
 */
// +----------------------------------------------------------------------
// | 一品内容管理系统 [ YPCMS ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2019 东海县一品网络技术有限公司
// +----------------------------------------------------------------------
// | 官方网站: http://www.yipinjishu.com
// +----------------------------------------------------------------------
declare(strict_types=1);

namespace app\admin\controller;

use think\facade\Db;
use think\facade\View;

class Index extends Base
{

	public function index()
	{
		$version = Db::query('SELECT VERSION() AS ver');
		$config = [
			'url' => $_SERVER['HTTP_HOST'],
			'document_root' => iconv("gbk", "utf-8", $_SERVER['DOCUMENT_ROOT']),
			'server_os' => PHP_OS,
			'server_port' => $_SERVER['SERVER_PORT'],
			'server_soft' => $_SERVER['SERVER_SOFTWARE'],
			'php_version' => PHP_VERSION,
			'mysql_version' => $version[0]['ver'],
			'max_upload_size' => ini_get('upload_max_filesize'),
		];
		View::assign('config', $config);
		View::assign('version', $this->app::VERSION);


		return view();
	}
	public function welcome()
	{
		$version = Db::query('SELECT VERSION() AS ver');
		$config = [
			'url' => $_SERVER['HTTP_HOST'],
			'document_root' => iconv("gbk", "utf-8", $_SERVER['DOCUMENT_ROOT']),
			'server_os' => PHP_OS,
			'server_port' => $_SERVER['SERVER_PORT'],
			'server_soft' => $_SERVER['SERVER_SOFTWARE'],
			'php_version' => PHP_VERSION,
			'mysql_version' => $version[0]['ver'],
			'max_upload_size' => ini_get('upload_max_filesize'),
		];
		View::assign('config', $config);
		View::assign('version', $this->app::VERSION);

		return view();
	}
}
