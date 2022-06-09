<?php
/*
 * @Author: 一品网络技术有限公司
 * @Date: 2022-06-08 07:55:45
 * @LastEditTime: 2022-06-09 07:20:58
 * @FilePath: \ypcms\app\admin\validate\CheckLogin.php
 * @Description:
 * 联系QQ:58055648
 * Copyright (c) 2022 by 东海县一品网络技术有限公司, All Rights Reserved.
 */

declare(strict_types=1);

namespace app\admin\validate;

use think\Validate;

/**
 * 后台登录验证
 * Class Login
 * @package app\admin\validate
 */
class CheckLogin extends Validate
{
	protected $rule = [
		'username' => 'require',
		'password' => 'require',
		'verify' => 'require|captcha',
	];

	protected $message = [
		'username.require' => '请输入用户名',
		'password.require' => '请输入密码',
		'verify.require' => '请输入验证码',
		'verify.captcha' => '验证码不正确',
	];
}
