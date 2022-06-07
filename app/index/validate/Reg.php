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
use think\facade\Session;
use think\Validate;

class Reg extends Validate {
	protected $rule = [
		'mobile' => 'require|unique:user|mobile|checkMobile',
		'email' => 'require|unique:user|email|checkMail',
		'regkey' => 'require|checkCode',
		'password' => 'require|length:6,16',
		'repassword' => 'require|confirm:password',
	];
	protected $message = [
		'mobile.require' => '请输入手机号码',
		'mobile.unique' => '此手机号码己存在',
		'mobile.mobile' => '手机号码格式错误',
		'password.require' => '密码必须输入',
		'password.length' => '密码长度必须在6-16个字符之间',
		'repassword.confirm' => '两次密码不一致',
	];
	protected $scene = [
		'mobile' => ['mobile', 'regkey', 'password', 'repassword'],
		'email' => ['email', 'regkey', 'password', 'repassword'],
	];

	protected function checkCode($value) {
		return $value == Session::get('checkCode') ? true : "验证码错误";
	}
	protected function checkMobile($value) {
		return $value == Session::get('mobile') ? true : "请使用接收验证码的手机号";
	}
	protected function checkMail($value) {
		return $value == Session::get('email') ? true : "请使用接收验证码的邮箱";
	}
}