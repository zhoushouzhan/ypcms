<?php

declare(strict_types=1);

namespace app\admin\controller;

use app\admin\validate\CheckCategory;
use app\common\model\Category as CategoryModel;
use app\common\model\Tb;
use think\exception\ValidateException;
use think\facade\Db;
use think\facade\View;

class Category extends Base
{
	protected function initialize()
	{
		parent::initialize();
		$this->table = new CategoryModel();
		//栏目树
		$category_list = CategoryModel::getLevelList();
		//模型列表
		$modList = CategoryModel::modList();
		View::assign("category_list", $category_list);
		View::assign("modList", $modList);
		$this->mod = Tb::find(9);
		$this->cols = $this->mod->cols;
		$this->colrule = $this->mod->colrule;
	}

	//栏目列表
	public function index()
	{
		return view();
	}

	//增加栏目
	public function add($pid = 0)
	{
		$data['pid'] = $pid;
		$data['map'] = ['tb' => [['mt', '=', 2]]];
		$form = app('form', ['7', $data]); //表单对象
		View::assign('form', $form->getForm());

		return view();
	}

	//保存栏目
	public function save()
	{
		if ($this->request->isPost()) {
			$data = $this->request->param();

			try {
				validate(CheckCategory::class)->check($data);
				if ($data['pid']) {
					$data['islast'] = 1;
				}
				if ($this->table::create($data)) {
					$this->success('保存成功', (string) url('add', ['pid' => $data['pid']]));
				} else {
					$this->error('保存失败');
				}
			} catch (ValidateException $e) {
				$this->error($e->getError());
			}
		}
	}

	//编辑栏目
	public function edit($id)
	{
		$r = CategoryModel::find($id);
		$r->map = ['tb' => [['mt', '=', 2]]];
		$form = app('form', ['9', $r]); //表单对象
		View::assign('form', $form->getForm());

		return view();
	}
	//移动栏目
	public function moveCategory()
	{
		$ids = $this->request->param('id');

		$pid = $this->request->param('pid');
		if ($ids && $pid) {
			$this->table::where('id', 'in', $ids)->update(['pid' => $pid]);
		}
		$rs = db::name('category')->select();
		foreach ($ids as $v) {
			$path = getPath($pid, $rs);
			if (strstr(',', $path)) {
				$pathArr = explode(',', $path);
				sort($pathArr);
				$path = implode(',', $pathArr);
			}

			db::name('category')->where('id', $v)->update(['path' => $path]);
		}
		$this->success('移动成功');
	}

	//更新栏目
	public function update($id)
	{
		if ($this->request->isPost()) {
			$data = $this->request->param();
			try {
				validate(CheckCategory::class)->check($data);
				$children = $this->table::where('path', 'like', "%,{$id},%")->column('id');
				if (in_array($data['pid'], $children)) {
					$this->error('不能移动到自己的子分类');
				}
				//父栏目
				if (!isset($data['islast']) && $data['pid'] == 0) {
					$data['islast'] = 0;
				}
				if ($data['pid'] != 0) {
					$data['islast'] = 1;
				}

				if ($this->table::update($data) !== false) {
					$this->success('更新成功');
				} else {
					$this->error('更新失败');
				}
			} catch (ValidateException $e) {
				$this->error($e->getError());
			}
		}
	}
	//删除时同时删除子类
	public function delete($id)
	{
		if ($this->table->destroy($id)) {
			$this->success('删除成功');
		} else {
			$this->error('删除失败');
		}
	}
	//栏目开关
	public function toggle($id = 0, $status = '0')
	{
		$data = [];
		if ($id) {
			if (Db::name('category')->where('id', $id)->update(['status' => $status])) {
				$this->success('操作成功');
			} else {
				$this->error('操作失败');
			}
		}
	}
}
