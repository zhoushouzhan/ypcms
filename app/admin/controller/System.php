<?php
/*
 * @Author: 一品网络技术有限公司
 * @Date: 2022-06-08 07:55:45
 * @LastEditTime: 2022-06-09 07:16:46
 * @FilePath: \ypcms\app\admin\controller\System.php
 * @Description:
 * 联系QQ:58055648
 * Copyright (c) 2022 by 东海县一品网络技术有限公司, All Rights Reserved.
 */

declare(strict_types=1);

namespace app\admin\controller;

use app\common\model\System as systemModel;
use app\common\model\Tb;
use think\facade\Db;
use think\facade\Validate;
use think\facade\View;

class system extends Base
{
	protected function initialize()
	{
		parent::initialize();
		$this->tb = Tb::where('name', 'system')->find();
		$this->cols = $this->tb->cols;
		$this->rules = $this->tb->colrule;
		$this->table = new systemModel();
		$this->mod = new \app\admin\controller\Ypmod($this->app);

		View::assign('mod', $this->tb);
	}

	public function setsystem()
	{
		$data = $this->table->find(1);
		$form = app('form', ['2', $data]); //表单对象
		View::assign('form', $form->getForm());
		return view('form');
	}

	public function save()
	{
		if ($this->request->isPost()) {
			$data = $this->request->param();
			$data = $this->tb->saveData($data); //组合字段内容
			//验证规则
			$colrule = array_column(Db::name('colrule')->select()->toArray(), null, 'id');
			//获取单列
			$cols = array_column($this->cols, null, 'name');
			//表单验证
			if (empty($this->rules)) {
				$this->error('缺少验证规则，至少要有一个必填项！');
			} else {
				foreach ($this->rules as $key => $value) {
					$ruleStr = [];
					foreach ($value as $k => $v) {
						$ruleStr[] = $colrule[$v]['rule'];
					}
					$rules[$key] = implode('\|', $ruleStr);
				}
				foreach ($this->rules as $key => $value) {
					foreach ($value as $k => $v) {
						$msgs[$key . '.' . $colrule[$v]['rule']] = str_replace("{col}", $cols[$key]['comment'], $colrule[$v]['msg']);
					}
				}
				$validate = Validate::rule($rules)->message($msgs);
				if (!$validate->check($data)) {
					$this->error($validate->getError());
				} else {
					//保存信息
					if ($this->table->save($data)) {
						$this->success('保存成功', (string) url('setsystem'));
					} else {
						$this->error('保存失败');
					}
				}
			}
		}
	}

	public function update()
	{
		$data = $this->tb->saveData($this->request->param()); //组合字段内容
		//验证规则
		$colrule = array_column(Db::name('colrule')->select()->toArray(), null, 'id');
		//获取单列
		$cols = array_column($this->cols, null, 'name');
		//表单验证
		foreach ($this->rules as $key => $value) {
			$ruleStr = [];
			foreach ($value as $k => $v) {
				$ruleStr[] = $colrule[$v]['rule'];
			}
			$rules[$key] = implode('|', $ruleStr);
		}
		foreach ($this->rules as $key => $value) {
			foreach ($value as $k => $v) {
				$msgs[$key . '.' . $colrule[$v]['rule']] = str_replace("{col}", $cols[$key]['comment'], $colrule[$v]['msg']);
			}
		}
		$validate = Validate::rule($rules)->message($msgs);
		if (!$validate->check($data)) {
			$this->error($validate->getError());
		} else {
			//保存信息
			if ($this->table::update($data)) {
				$this->success('更新成功', (string) url('setsystem'));
			} else {
				$this->error('更新失败');
			}
		}
	}
}
