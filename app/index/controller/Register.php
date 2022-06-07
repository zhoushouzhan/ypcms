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
use app\index\validate\Reg;
use think\exception\ValidateException;
use think\facade\Session;
use think\facade\View;

class Register extends Base {
	public function index() {

		if (Session::has('userid')) {
			return redirect('/user/index');
		}

		if ($this->request->isPost()) {
			$data = $this->request->post();

			$sender = $data['sender'];
			if (check_email($sender)) {
				$data['email'] = $sender;
				$scene = 'email';
			}
			if (check_mobile_number($sender)) {
				$data['mobile'] = $sender;
				$scene = 'mobile';
			}
			try {
				validate(Reg::class)->scene($scene)->check($data);
				$data['status'] = 1; //默认状态
				$data['salt'] = makeStr(6);
				$data['rnd'] = makeStr(20);
				$data['group_id'] = 1;
				$data['password'] = md5(md5($data['password']) . $data['salt']);
				if ($reg = User::create($data)) {
					//默认会员组为1
					$this->success('注册成功', (string) url('index/Login/index'));
				} else {
					$this->error('注册失败');
				}

			} catch (ValidateException $e) {
				$this->error($e->getError());
			}
		} else {
			return view('user/register');
		}
	}
}
