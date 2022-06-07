<?php
// +----------------------------------------------------------------------
// | 一品内容管理系统 [ YPCMS ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2019 东海县一品网络技术有限公司
// +----------------------------------------------------------------------
// | 官方网站: http://www.yipinjishu.com
// +----------------------------------------------------------------------
declare (strict_types = 1);
namespace app\index\controller;
use app\common\model\User;
use app\index\validate\Login as LoginVal;
use think\exception\ValidateException;
use think\facade\Session;
use think\facade\View;

class Login extends Base {
	public function index() {
		if ($this->request->isPost()) {
			$data = $this->request->param();
			try {
				validate(LoginVal::class)->check($data);
				$r = User::where('username|mobile|email', $data['sender'])->find();
				if (!$r) {
					$this->error('此用户不存在');
				}
				if (md5(md5($data['password']) . $r['salt']) != $r['password']) {
					$this->error('密码错误');
				}
				if ($r['status'] == 0) {
					$this->error('当前用户己禁用');
				}
				Session::set('userid', $r['id']);
				Session::set('nickname', $r['nickname']);
				Session::set('usermobile', $r['mobile']);
				$r->update_time = time();
				$r->ip = $this->request->ip();
				$r->id = $r['id'];
				$r->loginnum = ['inc', 1];
				$r->save();
				$jumpurl = (string) url('index/user/index');
				//前往之前页面
				if (Session::has('jumpurl')) {
					$jumpurl = Session::get('jumpurl');
				}
				$this->success('登录成功', $jumpurl);
			} catch (ValidateException $e) {
				$this->error($e->getError());
			}
		} else {
			return view('user/login');
		}
	}
	public function loginout() {
		Session::delete('userid');
		Session::delete('nickname');
		Session::delete('usermobile');
		$this->success('退出成功', '/index');
	}
}