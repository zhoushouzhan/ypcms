<?php
// +----------------------------------------------------------------------
// | 一品内容管理系统 [ YPCMS ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2019 东海县一品网络技术有限公司
// +----------------------------------------------------------------------
// | 官方网站: http://www.yipinjishu.com
// +----------------------------------------------------------------------
declare(strict_types=1);

namespace app\admin\controller;

use app\admin\validate\CheckAdmin;
use app\common\model\Admin as AdminModel;
use app\common\model\Roles;
use app\common\model\Tb;
use think\exception\ValidateException;
use think\facade\Config;
use think\facade\Db;
use think\facade\Session;
use think\facade\Validate;
use think\facade\View;

class Admin extends Base
{

	protected function initialize()
	{
		parent::initialize();
		$this->tb = Tb::where('name', 'Admin')->find();
		$this->cols = $this->tb->cols;
		$this->rules = $this->tb->colrule;
		$this->table = new AdminModel();

		//是否支持搜索
		$searchCol = $this->tb->getSearch();
		View::assign('listv', $this->tb->listv());
		View::assign('colspan', count($this->tb->listv()) + 2);
		View::assign('searchCol', $searchCol);
		View::assign('mod', $this->tb);
		View::assign('roles', Roles::select());
	}

	//管理员列表
	public function index($keyboard = '', $page = 1, $limit = 20)
	{
		$map = [];
		if ($keyboard) {
			$map[] = ['a.username|a.mobile|a.truename', 'like', "%$keyboard%"];
		}

		$dataList = AdminModel::alias('a')->where($map)->order('id', 'asc')->paginate(['list_rows' => $limit, 'query' => $this->request->param()]);

		View::assign('dataList', $dataList);
		return view();
	}
	//增加管理员
	public function add()
	{
		$data['admin'] = $this->admin;
		$form = app('form', [$this->tb->id, $data]); //表单对象
		View::assign('form', $form->getForm());
		return view('form');
	}

	//保存用户
	public function save()
	{
		if ($this->request->isPost()) {
			$data = $this->request->param();
			//密码为空时不做更新
			if (isset($data['password']) && $data['password'] == '') {
				unset($data['password']);
			}

			//验证规则
			$colrule = array_column(Db::name('colrule')->select()->toArray(), null, 'id');
			//获取单列
			$cols = array_column($this->cols, null, 'name');
			//表单验证
			if (empty($this->rules)) {
				$this->error('缺少验证规则，至少要有一个必填项！');
			} else {
				foreach ($this->rules as $key => $value) {
					$ruleArr = [];
					foreach ($value as $k => $v) {
						$rule = $colrule[$v]['rule'];
						$rule = str_replace('{col}', $key, $rule);
						$rule = str_replace('{mod}', $this->tb->name, $rule);
						$ruleArr[] = $rule;
					}
					$rules[$key] = implode('|', $ruleArr);
				}
				foreach ($this->rules as $key => $value) {
					foreach ($value as $k => $v) {
						//相同确认
						$rule = str_replace('confirm:confirm_{col}', 'confirm', $colrule[$v]['rule']);
						//账号唯一
						$rule = str_replace('unique:{mod}', 'unique', $rule);
						$msgs[$key . '.' . $rule] = str_replace("{col}", $cols[$key]['comment'], $colrule[$v]['msg']);
					}
				}
				//halt($msgs);
				$validate = Validate::rule($rules)->message($msgs);
				if (!$validate->check($data)) {
					$this->error($validate->getError());
				} else {
					//保存信息
					$data = $this->tb->saveData($data); //组合字段内容
					if ($this->table->save($data)) {
						$this->success('保存成功', (string) url('index'));
					} else {
						$this->error('保存失败');
					}
				}
			}
		}
	}
	//编辑管理员
	public function edit($id)
	{

		$r = $this->table::find($id); //查询数据
		$r = $this->tb->editData($r); //组合字段内容
		$r->admin = $this->admin;
		$form = app('form', [$this->tb->id, $r]); //表单对象
		View::assign('form', $form->getForm());
		View::assign('r', $r);
		return view('form');
	}
	//更新管理员
	public function update($id)
	{
		if ($this->request->isPost()) {
			$admin = AdminModel::find($id);
			$data = $this->request->param();
			$data['schoolid'] = Session::get('schoolid');
			//验证登录信息
			try {
				validate(CheckAdmin::class)->check($data);
				//更改密码
				if (!empty($data['password']) && !empty($data['confirm_password'])) {
					$data['password'] = md5($data['password'] . Config::get('database.salt'));
				} else {
					unset($data['password']);
				}

				if ($admin->save($data) !== false) {

					$this->success('更新成功');
				} else {
					$this->error('更新失败');
				}
			} catch (ValidateException $e) {
				$this->error($e->getError());
			}
		}
	}
	//删除管理员
	public function delete($id)
	{
		if (is_array($id)) {
			foreach ($id as $key => $value) {
				// code...
				if ($value == 1) {
					$this->error('超级管理员不能删除');
				}
			}
			$id = array_map('intval', $id);
		} else {
			if ($id == 1) {
				$this->error('超级管理员不能删除');
			}
		}

		if ($id) {
			if ($this->table::destroy($id)) {
				$this->success('删除成功');
			} else {
				$this->error('删除失败');
			}
		} else {
			$this->error('请选择需要删除的条目');
		}
	}
}
