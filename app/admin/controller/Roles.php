<?php
/*
 * @Author: 一品网络技术有限公司
 * @Date: 2022-06-08 07:55:45
 * @LastEditTime: 2022-06-09 07:16:07
 * @FilePath: \ypcms\app\admin\controller\Roles.php
 * @Description:
 * 联系QQ:58055648
 * Copyright (c) 2022 by 东海县一品网络技术有限公司, All Rights Reserved.
 */

declare(strict_types=1);

namespace app\admin\controller;

use app\common\model\Roles as rolesModel;
use app\common\model\Rule;
use think\facade\View;

/**
 * 后台角色控制器
 * @package app\admin\controller
 */
class Roles extends Base
{
	/**
	 * 角色
	 */
	public function index()
	{
		View::assign('dataList', rolesModel::order('sort', 'desc')->select());
		return view();
	}
	/**
	 * 增加角色
	 */
	public function add()
	{
		return view();
	}
	/**
	 * 保存角色
	 */
	public function save()
	{
		if ($this->request->isPost()) {
			$data = $this->request->param();
			if (rolesModel::create($data) !== false) {
				$this->success('保存成功');
			} else {
				$this->error('保存失败');
			}
		}
	}
	/**
	 * 编辑角色
	 */
	public function edit($id)
	{
		View::assign([
			'auth_group' => rolesModel::find($id),
			'roles' => rolesModel::where('id', 'notin', [1])->select(),
		]);
		return view();
	}
	/**
	 * 更新角色
	 */
	public function update()
	{
		if ($this->request->isPost()) {
			$data = $this->request->param();
			$id = $data['id'];
			if ($id == 1 && $data['status'] != 1) {
				$this->error('超级管理组不可禁用');
			}
			if (rolesModel::update($data) !== false) {
				$this->success('更新成功');
			} else {
				$this->error('更新失败');
			}
		}
	}

	/**
	 * 角色授权
	 */
	public function auth($id)
	{
		$dataList = Rule::field('id,pid,title,sid')->select()->toArray();
		$checkedData = rolesModel::find($id);
		$checkedData = $checkedData->rules;

		$arr = explode(',', $checkedData);
		$arr = array_map('intval', $arr);
		foreach ($dataList as $key => $value) {
			$value['checked'] = false;
			if (in_array($value['id'], $arr) && empty($value['sid'])) {
				$value['checked'] = true;
			}
			$newData[$key] = $value;
		}
		$dataList = ypDataTree($newData);
		$dataList = json_encode($dataList);

		View::assign('dataList', $dataList);
		View::assign('id', $id);
		return view();
	}
	/**
	 * 更新角色权限
	 */
	public function updateAuth()
	{
		if ($this->request->isPost()) {
			$data = $this->request->param();

			if (rolesModel::update($data) !== false) {
				$this->success('授权成功');
			} else {
				$this->error('授权失败');
			}
		}
	}
	/**
	 * 删除角色
	 */
	public function delete($id)
	{
		if ($id == 1) {
			$this->error('超级管理组不可删除');
		}
		$Role = rolesModel::find($id);
		if ($Role->delete()) {
			//同时删除角色与用户关系
			$Role->admin()->detach();
			$this->success('删除成功');
		} else {
			$this->error('删除失败');
		}
	}
}
