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
use app\common\model\Favorites;
use app\common\model\Order;
use app\common\model\User as UserModel;
use app\index\validate\CheckUser;
use think\exception\ValidateException;
use think\facade\Session;
use think\facade\View;

class User extends Base {
	//用户中心
	public function index() {
		return view();
	}
	//编辑个人资料
	public function edit() {
		return view();
	}
	public function update() {
		if ($this->request->isPost()) {
			$data = $this->request->param();
			try {
				validate(CheckUser::class)->scene('edit')->check($data);
				$user = UserModel::find($this->userid);
				if ($user->save($data) !== false) {
					$this->success('修改成功', (string) url("index/user/index"));
				} else {
					$this->error('操作失败');
				}
			} catch (ValidateException $e) {
				// 验证失败 输出错误信息
				$this->error($e->getError());
			}
		}
	}
	//修改密码
	public function changePass() {
		return view();
	}
	//更新密码
	public function updatePass() {
		if ($this->request->isPost()) {
			$data = $this->request->param();
			try {
				validate(CheckUser::class)->scene('changePass')->check($data);
				$user = UserModel::find($this->userid);
				$salt = makeStr(6);
				$data['salt'] = $salt;
				$data['rnd'] = makeStr(20);
				$data['password'] = md5(md5($data['password']) . $salt);
				if ($user->save($data) !== false) {
					$this->success('修改成功', (string) url("index/user/index"));
				} else {
					$this->error('操作失败');
				}
			} catch (ValidateException $e) {
				// 验证失败 输出错误信息
				$this->error($e->getError());
			}

		}
	}
	//修改安全密码
	public function safepass() {
		return $this->fetch();
	}
	//更新安全密码
	public function updatesafepass() {
		if ($this->request->isPost()) {
			$data = $this->request->param();
			$user = model('user')::get($this->userid);
			if ($data['epassword'] != $data['newepassword']) {
				$this->error('两次密码不一样');
			}
			if (md5(md5($data['oldpassword']) . $user['salt']) != $user['password']) {
				$this->error('原密码错误');
			}
			$user->epassword = md5(md5($data['epassword']));
			if ($user->save() !== false) {
				$this->success('设置成功', (string) url("index/user/index"));
			} else {
				$this->error('操作失败');
			}
		}
	}
	//手机认证
	public function setMobile() {
		if ($this->request->isPost()) {
			$data = $this->request->param();
			if ($data['checkCode'] != Session::get('checkCode')) {
				$this->error('验证码错误');
			}
			Session::set('allowSetMobile', 1);
			$this->success('验证成功', (string) url('index/user/changeMobile'));
		} else {
			if ($this->user->mobile == '') {
				Session::set('allowSetMobile', 1);
				return redirect('/user/changeMobile');
			}
			return view();
		}
	}
	//更换手机号
	public function changeMobile() {
		if ($this->request->isPost()) {
			$data = $this->request->param();
			$newMobile = $data['newMobile'];
			//手机号码是否更换检测
			if ($newMobile != Session::get('mobile')) {
				$this->error('请使用接收验证码的手机号');
			}
			//验证码检测
			if ($data['checkCode'] != Session::get('checkCode')) {
				$this->error('验证码错误');
			}
			$this->user->mobile = $newMobile;
			if ($this->user->save()) {
				$this->success('设置成功', (string) url('index/user/setMobile'));
			} else {
				$this->error('保存失败');
			}

		} else {
			if (!Session::has('allowSetMobile')) {
				return redirect('/user/index');
			}
			return view();
		}
	}
	//更新手机
	public function changeCode() {
		$data = $this->request->param();
		$checkType = isset($data['checkType']) ? $data['checkType'] : '';
		//手机验证码-直接发送到之前绑定的手机上
		if ($checkType == 'mobile') {
			$this->sendMsg->sendMobileCode($this->user->mobile);
		}
		//邮箱验证码
		if ($checkType == 'email') {
			$this->sendMsg->sendEmailCode($this->user->email);
		}
		//新手机号验证
		if (isset($data['mobile']) && empty($checkType)) {
			//查询手机号是否存在
			$count = UserModel::where('mobile', $data['mobile'])->count();
			if ($count) {
				$this->error('此手机号己存在,建议使用手机号找回密码，或联系客服');
			}
			$this->sendMsg->sendMobileCode($data['mobile']);
		}
		//新邮箱验证
		if (isset($data['email']) && empty($checkType)) {
			//查询手机号是否存在
			$count = UserModel::where('email', $data['email'])->count();
			if ($count) {
				$this->error('此邮箱己存在,建议使用邮箱找回密码，或联系客服');
			}
			$this->sendMsg->sendEmailCode($data['email']);
		}

	}
	//邮箱认证
	public function setEmail() {
		if ($this->request->isPost()) {
			$data = $this->request->param();
			if ($data['checkCode'] != Session::get('checkCode')) {
				$this->error('验证码错误');
			}
			Session::set('allowSetEmail', 1);
			$this->success('验证成功', (string) url('index/user/changeEmail'));
		} else {
			if ($this->user->email == '') {
				Session::set('allowSetEmail', 1);
				return redirect('/user/changeEmail');
			}
			return view();
		}
	}
	//更换邮箱账号
	public function changeEmail() {
		if ($this->request->isPost()) {
			$data = $this->request->param();
			$newEmail = $data['newEmail'];
			//手机号码是否更换检测
			if ($newEmail != Session::get('email')) {
				$this->error('请使用接收验证码的邮箱');
			}
			//验证码检测
			if ($data['checkCode'] != Session::get('checkCode')) {
				$this->error('验证码错误');
			}

			$this->user->email = $newEmail;
			if ($this->user->save()) {
				$this->success('设置成功', (string) url('index/user/setEmail'));
			} else {
				$this->error('保存失败');
			}
		} else {
			if (!Session::has('allowSetEmail')) {
				return redirect('/user/index');
			}
			return view();
		}
	}
	//充值
	public function buygroup() {
		if ($this->request->isPost()) {
			$data = $this->request->param();
			$r = \app\common\model\Buygroup::find($data['id']);
			//查询记录
			$oldmap[] = ['goods', '=', $data['id']];
			$oldmap[] = ['user_id', '=', $this->userid];
			$oldmap[] = ['status', '=', 0];
			if ($old = \app\common\model\Order::where($oldmap)->find()) {

				//判断订单是否失效,2小时后未付款的失效
				$create_time = (int) $old->create_time;
				$now = time();
				if ($now - $create_time < 7200) {
					$this->success('己有订单', '', '', $old);die;
				} else {
					$old->status = -1;
					$old->save();
				}

			}
			//创建订单
			$ordersn = ordersn();
			$insert['ordersn'] = $ordersn;
			$insert['goods'] = $data['id'];
			$insert['category_id'] = 0;
			$insert['money'] = $r->price;
			$insert['user_id'] = $this->userid;
			$insert['tb_id'] = 17;
			$insert['ip'] = $this->request->ip();

			//快照关键信息
			$insert['info'] = $r->toJson();
			if ($r = \app\common\model\Order::create($insert)) {
				$this->success('创建订单成功', '', '', $r);
			} else {
				$this->error('创建订单失败');
			}
		} else {
			View::assign('dataList', \app\common\model\Buygroup::select());
			return view();
		}
	}
	//订单
	public function order($page = 1) {
		$dataList = Order::where('user_id', $this->userid)->order('id', 'desc')->paginate(15, false, ['page' => $page]);
		return view('', ['dataList' => $dataList]);
	}
	//收藏
	public function favorites($page = 1) {
		$dataList = Favorites::where('user_id', $this->userid)->paginate(15, false, ['page' => $page]);
		return view('', ['dataList' => $dataList]);
	}
	//增加收藏
	public function addFavorites() {
		$data['user_id'] = $this->userid;
		$data['ypcms_id'] = $this->request->param('id');
		$data['ypcms_type'] = $this->request->param('type');

		if ($fav = Favorites::where($data)->find()) {
			$fav->delete();
			return $this->error('己取消收藏');
		}
		if (Favorites::create($data)) {
			return $this->success('收藏成功');
		};
	}

}
