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
use app\common\model\Group as GroupModel;
use think\facade\View;

class Group extends Base {
	protected $user_group_model;

	protected function initialize() {
		parent::initialize();
		$this->table = new GroupModel();
	}
//列表
	public function index() {
		$dataList = $this->table->select();
		return view('', ['dataList' => $dataList]);
	}
//添加
	public function add() {
		return view();
	}
//保存
	public function save() {
		if ($this->request->isPost()) {
			$data = $this->request->post();

			if ($this->table->save($data) !== false) {
				$this->success('保存成功');
			} else {
				$this->error('保存失败');
			}
		}
	}
//编辑
	public function edit($id) {
		$user_group = $this->table->find($id);

		return view('edit', ['user_group' => $user_group]);
	}
//更新
	public function update($id) {
		if ($this->request->isPost()) {
			$data = $this->request->post();

			if ($this->table::update($data) !== false) {
				$this->success('更新成功');
			} else {
				$this->error('更新失败');
			}
		}
	}
//删除
	public function delete($id) {
		if ($id == 1) {
			$this->error('超级管理组不可删除');
		}
		if ($this->table->destroy($id)) {
			$this->success('删除成功');
		} else {
			$this->error('删除失败');
		}
	}
}