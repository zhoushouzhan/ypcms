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

use app\admin\validate\CheckUser;
use app\common\model\Group;
use app\common\model\User as UserModel;
use think\exception\ValidateException;
use think\facade\View;

class User extends Base {
	protected function initialize() {
		parent::initialize();
		$this->table = new UserModel();
	}

	public function index($keyword = '', $page = 1) {
		$map = [];
		if ($keyword) {
			$map[] = ['username|mobile|email', 'like', "%{$keyword}%"];
		}
		$user_list = $this->table->where($map)->order('id DESC')->paginate(15, false, ['page' => $page]);

		return view('index', ['user_list' => $user_list, 'keyword' => $keyword]);
	}

	public function add() {
		$group = Group::select()->toArray();
		View::assign(['group' => $group]);
		return view();
	}

	public function save() {
		if ($this->request->isPost()) {
			$data = $this->request->post();

			try {
				validate(CheckUser::class)->scene('add')->check($data);
				$data['rnd'] = makeStr(20);
				$data['salt'] = makeStr(6);
				$data['password'] = md5(md5($data['password']) . $data['salt']);
				if ($user = UserModel::create($data)) {
					$this->success('保存成功');
				} else {
					$this->error('保存失败');
				}

			} catch (ValidateException $e) {
				$this->error($e->getError());
			}
		}
	}

	public function edit($id) {
		$user = $this->table->find($id);
		$group = Group::select();
		View::assign(['group' => $group, 'user' => $user]);
		return view();
	}

	public function update($id) {
		if ($this->request->isPost()) {
			$data = $this->request->post();

			try {
				validate(CheckUser::class)->scene('update')->check($data);
				//更新密码
				if (!empty($data['password']) && !empty($data['repassword'])) {
					if ($data['password'] != $data['repassword']) {
						$this->error('两次密码不一致');die;
					}
					$data['rnd'] = makeStr(20);
					$data['salt'] = makeStr(6);
					$data['password'] = md5(md5($data['password']) . $data['salt']);
				}
				if ($user = UserModel::update($data)) {
					$this->success('更新成功');
				} else {
					$this->error('更新失败');
				}
			} catch (ValidateException $e) {
				$this->error($e->getError());
			}

		}
	}

	public function details($id) {
		$user = $this->table->find($id);
		return view('', ['user' => $user]);
	}

	public function delete($id) {
		if ($this->table->destroy($id)) {
			$this->success('删除成功');
		} else {
			$this->error('删除失败');
		}
	}
}