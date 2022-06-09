<?php
/*
 * @Author: 一品网络技术有限公司
 * @Date: 2021-11-08 08:30:36
 * @LastEditTime: 2022-06-09 07:15:53
 * @FilePath: \ypcms\app\admin\controller\Login.php
 * @Description:
 * 联系QQ:58055648
 * Copyright (c) 2022 by 东海县一品网络技术有限公司, All Rights Reserved.
 */

declare(strict_types=1);

namespace app\admin\controller;

use app\admin\validate\CheckLogin;
use app\BaseController;
use app\common\model\Admin;
use think\exception\ValidateException;
use think\facade\Db;
use think\facade\Session;
use think\facade\View;

class Login extends BaseController
{
	public function index()
	{
		$site = Db::name('system')->find(1);
		View::assign('site', $site);
		return view();
	}
	public function doLogin()
	{

		if ($this->request->isPost()) {
			//获取登录信息
			$data = $this->request->only(['username', 'password', 'verify']);
			//验证登录信息
			try {
				validate(CheckLogin::class)->check($data);

				$data['ip'] = $this->request->ip();
				$admin_id = Admin::login($data);
				if ($admin_id >= 1) {

					Session::set('admin_id', $admin_id);
					Session::set('admin_name', $data['username']);
					//设置校区

					$this->success('登录成功', '/index/index', '', 'new');
				} else {
					$this->error('登录失败');
				}
			} catch (ValidateException $e) {
				$this->error($e->getError());
			}
		}
	}
	public function logout()
	{
		Session::delete('admin_id');
		$this->success('退出成功', '/login');
	}
}
