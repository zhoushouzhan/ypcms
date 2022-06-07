<?php
// +----------------------------------------------------------------------
// | 一品内容管理系统 [ 前端路由规则 ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2019 东海县一品网络技术有限公司
// +----------------------------------------------------------------------
// | 官方网站: http://www.yipinjishu.com
// +----------------------------------------------------------------------
declare (strict_types = 1);
use think\facade\Route;
Route::domain('admin', function () {
	Route::rule('doLogin', 'admin/login/doLogin');
});
Route::get('index', 'index/index/index', 'GET');

//栏目规则
Route::get('Category/:categoryId$', 'index/Category/index', 'GET');

//信息内容路由规则
Route::get('Content/:categoryId-:id$', 'index/content/index');