<?php
/*
 * @Author: 一品网络技术有限公司
 * @Date: 2022-06-08 07:55:45
 * @LastEditTime: 2022-06-08 11:25:03
 * @FilePath: \ypcms\app\index\route\route.php
 * @Description:
 * 联系QQ:58055648
 * Copyright (c) 2022 by 东海县一品网络技术有限公司, All Rights Reserved.
 */
// +----------------------------------------------------------------------
// | 一品内容管理系统 [ 前端路由规则 ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2019 东海县一品网络技术有限公司
// +----------------------------------------------------------------------
// | 官方网站: http://www.yipinjishu.com
// +----------------------------------------------------------------------
declare(strict_types=1);

use think\facade\Route;

Route::domain('admin', function () {
	Route::rule('doLogin', 'admin/login/doLogin');
});
Route::get('index', 'index/index/index', 'GET');
