<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2019 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]
namespace think;
// [ PHP版本检查 ]
header("Content-type: text/html; charset=utf-8");
if (version_compare(PHP_VERSION, '7.1', '<')) {
	die('PHP版本过低，最少需要PHP7.1，请升级PHP版本！');
}
//运行目录
define('YP_ROOT', __DIR__ . DIRECTORY_SEPARATOR);
//应用目录
define('APP_PATH', YP_ROOT . '../app/');
require __DIR__ . '/../vendor/autoload.php';

// 执行HTTP应用并响应
$http = (new App())->http;
//判断是否安装过
if (is_file('../app/setup/config/ypcms.lock')) {
	header('Location:/index.php');
} else {
	$response = $http->run();
}
$response->send();
$http->end($response);