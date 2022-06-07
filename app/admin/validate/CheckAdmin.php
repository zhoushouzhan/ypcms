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
 * 管理员验证器
 * Class AdminUser
 * @package app\admin\validate
 */
class CheckAdmin extends Validate {
	protected $rule = [
		'username' => 'require|unique:admin',
		'password' => 'confirm:confirm_password',
		'confirm_password' => 'confirm:password',
		'status' => 'require',
		'roles_id' => 'require',
	];

	protected $message = [
		'username.require' => '请输入用户名',
		'username.unique' => '用户名已存在',
		'password.confirm' => '两次输入密码不一致',
		'confirm_password.confirm' => '两次输入密码不一致',
		'status.require' => '请选择状态',
		'roles_id.require' => '请选择所属权限组',
	];
}