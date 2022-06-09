<?php

declare(strict_types=1);

namespace app\admin\controller;

use app\admin\validate\CheckMenu;
use app\common\model\Rule;
use think\exception\ValidateException;
use think\facade\View;

class Menu extends Base
{
	protected function initialize()
	{
		parent::initialize();
		$menuList = Rule::order(['sort' => 'asc', 'id' => 'ASC'])->select();
		$dataList = array2level($menuList);
		View::assign('dataList', $dataList);
	}

	public function index()
	{
		return view();
	}

	public function add($pid = '')
	{
		View::assign('pid', $pid);
		return view();
	}

	public function save()
	{
		if ($this->request->isPost()) {
			$data = $this->request->post();
			$data['type'] = 1;
			try {
				validate(CheckMenu::class)->check($data);
				if (Rule::create($data)) {
					$this->success('保存成功');
				} else {
					$this->error('保存失败');
				}
			} catch (ValidateException $e) {
				$this->error($e->getError());
			}
		}
	}

	public function edit($id)
	{
		$admin_menu = Rule::find($id);
		return view('edit', ['admin_menu' => $admin_menu]);
	}

	public function update($id)
	{
		if ($this->request->isPost()) {
			$data = $this->request->post();
			$data['type'] = 1;
			try {
				validate(CheckMenu::class)->check($data);
				if (Rule::update($data) !== false) {
					//更新子节点
					$this->success('更新成功', 'cookieurl');
				} else {
					$this->error('更新失败');
				}
			} catch (ValidateException $e) {
				$this->error($e->getError());
			}
		}
	}

	public function delete($id)
	{
		$sub_menu = Rule::find($id);
		$sids = $sub_menu->sid . $id;
		$arr = explode(',', $sids);
		$arr = array_filter($arr);
		$arr = array_map('intval', $arr); //数值转为整型
		if (count($arr) == 1) {
			$arr = $id;
		}
		if (Rule::destroy($arr)) {
			$this->success('删除成功', '', $sids);
		} else {
			$this->error('删除失败');
		}
	}
}
