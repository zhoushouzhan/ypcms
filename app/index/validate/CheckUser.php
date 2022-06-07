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

class CheckUser extends Validate {
	protected $rule = [
		'username' => 'require|unique:user|alpha|length:4,22',
		'nickname' => 'checkstr',
		'password' => 'require|length:6,16',
		'repassword' => 'require|confirm:password',
	];
	protected $message = [
		'username.require' => '用户名必需填写',
		'username.unique' => '此用户名己存在',
		'username.alpha' => '用户名只能用字母',
		'username.alpha' => '用户名只能用字母',
		'username.length' => '用户名长度必须在4-22个字母之间',
		'password.require' => '密码必须输入',
		'password.length' => '密码长度必须在6-16个字符之间',
		'repassword.confirm' => '两次密码不一致',
	];

	// 验证昵称
	protected function checkstr($value) {
		if (!preg_match("/^[\x{4e00}-\x{9fa5}A-Za-z]+$/u", $value)) {
			//echo "<font color=red>您输入的[" . $value . "]含有违法字符</font>";
			return '昵称只能包含汉字与字母';
		}
		return true;
	}
	//验证场景
	protected $scene = [
		'edit' => ['username', 'nickname'],
		'changePass' => ['password', 'repassword'],
	];

}