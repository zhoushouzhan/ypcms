<?php

declare(strict_types=1);

namespace app\admin\controller;

use app\admin\validate\CheckRule;
use think\exception\ValidateException;
use think\facade\Db;
use think\facade\View;
use think\Validate;

class Colrule extends Base
{
	protected $tableList;
	protected $dbpre;
	protected $dbname;
	protected function initialize()
	{
		parent::initialize();
	}
	//规则管理
	public function index()
	{
		$dataList = DB::name('colrule')->select();
		View::assign('dataList', $dataList);
		return view();
	}
	//保存
	public function save()
	{
		if ($this->request->isPost()) {
			$data = $this->request->param();
			try {
				validate(CheckRule::class)->check($data);
				if ($data['id']) {
					if (Db::name('colrule')->data($data)->insert()) {
						$this->success('更新成功');
					} else {
						$this->error('更新失败');
					}
				}
				if (Db::name('colrule')->data($data)->insert()) {
					$this->success('保存成功');
				} else {
					$this->error('保存失败');
				}
			} catch (ValidateException $e) {
				$this->error($e->getError());
			}
		}
	}
	//删除
	public function delete($id = 0)
	{
		if ($id) {
			if (Db::name('colrule')->delete($id)) {
				$this->success('删除成功');
			} else {
				$this->error('删除失败');
			}
		} else {
			$this->error('请选择删除对象');
		}
	}
}
