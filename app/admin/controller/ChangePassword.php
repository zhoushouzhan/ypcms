<?php
/*
 * @Author: 一品网络技术有限公司
 * @Date: 2022-06-08 07:55:45
 * @LastEditTime: 2022-06-09 07:15:25
 * @FilePath: \ypcms\app\admin\controller\ChangePassword.php
 * @Description:
 * 联系QQ:58055648
 * Copyright (c) 2022 by 东海县一品网络技术有限公司, All Rights Reserved.
 */

declare(strict_types=1);

namespace app\admin\controller;

use think\facade\Config;
use think\facade\Db;
use think\facade\Session;

class ChangePassword extends Base
{

	public function index()
	{
		return view('system/change_password');
	}

	public function updatePassword()
	{
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
