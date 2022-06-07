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
use think\facade\Db;
use think\Validate;

class CheckUser extends Validate {
	protected $rule = [
		'id' => 'require|checkInfo',
		'username' => 'require|unique:user',
		'group_id' => 'require',
		'password' => 'require|length:6,16',
		'repassword' => 'require|confirm:password',

	];
	protected $message = [
		'group_id.require' => '请选择会员组',

	];
	protected function checkInfo($value, $rule, $data) {
		$r = db::name('user')->where('id|username', $value)->find();
		//检测用户名是否存在
		if ($r['username'] != $data['username']) {
			$map[] = ['username', '=', $data['username']];
			$map[] = ['id', '<>', $data['id']];
			if (db::name('user')->where($map)->count()) {
				return '用户名己存在';
			}
		}
		//检测手机号是否存在
		if ($r['mobile'] != $data['mobile']) {
			$map[] = ['mobile', '=', $data['mobile']];
			$map[] = ['id', '<>', $data['id']];
			if (db::name('user')->where($map)->count()) {
				return '手机号己存在';
			}
		}
		//检测邮箱是否存在
		if ($r['email'] != $data['email']) {
			$map[] = ['email', '=', $data['email']];
			$map[] = ['id', '<>', $data['id']];
			if (db::name('user')->where($map)->count()) {
				return '邮箱己存在';
			}
		}
		return true;
	}

	protected $scene = [
		'add' => ['username', 'password', 'repassword', 'group'],
		'update' => ['id', 'group'],
	];

}