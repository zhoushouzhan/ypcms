<?php
// +----------------------------------------------------------------------
// | 一品内容管理系统 [ YPCMS ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2019 东海县一品网络技术有限公司
// +----------------------------------------------------------------------
// | 官方网站: http://www.yipinjishu.com
// +----------------------------------------------------------------------
declare (strict_types = 1);
namespace app\admin\validate;

use think\Validate;

/**
 * 后台登录验证
 * Class Login
 * @package app\admin\validate
 */
class CheckLogin extends Validate {
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