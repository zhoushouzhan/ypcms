<?php
// +----------------------------------------------------------------------
// | 一品内容管理系统 [ YPCMS ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2019 东海县一品网络技术有限公司
// +----------------------------------------------------------------------
// | 官方网站: http://www.yipinjishu.com
// +----------------------------------------------------------------------
declare (strict_types = 1);
namespace app\index\validate;

use think\Validate;

class Login extends Validate {
	protected $rule = [
		'sender' => 'require',
		'password' => 'require',
		'verify' => 'require|captcha',
	];

	protected $message = [
		'sender.require' => '请输入账号/手机号/邮箱',
		'password.require' => '请输入密码',
		'verify.require' => '请输入验证码',
		'verify.captcha' => '验证码不正确',
	];
}