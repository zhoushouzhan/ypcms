<?php
// +----------------------------------------------------------------------
// | 一品内容管理系统 [ YPCMS ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2019 东海县一品网络技术有限公司
// +----------------------------------------------------------------------
// | 官方网站: http://www.yipinjishu.com
// +----------------------------------------------------------------------
declare (strict_types = 1);
namespace app\admin\controller;

use think\facade\Config;
use think\facade\Db;
use think\facade\Session;

class ChangePassword extends Base {

	public function index() {
		return view('system/change_password');
	}

	public function updatePassword() {
		if ($this->request->isPost()) {
			$admin_id = Session::get('admin_id');
			$data = $this->request->param();
			$result = Db::name('admin')->find($admin_id);
			$old_password = md5($data['old_password'] . Config::get('database.salt'));
			$new_password = md5($data['password'] . Config::get('database.salt'));
			if ($result['password'] == $old_password) {
				if ($data['password'] == $data['confirm_password']) {
					if (Db::name('admin')->where(['id' => $admin_id])->update(['password' => $new_password]) !== false) {
						$this->success('修改成功');
					} else {
						$this->error('修改失败');
					}
				} else {
					$this->error('两次密码输入不一致');
				}
			} else {
				$this->error('原密码不正确');
			}
		}
	}
}