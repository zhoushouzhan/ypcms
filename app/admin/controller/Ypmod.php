<?php

declare(strict_types=1);

namespace app\admin\controller;

use app\admin\validate\CheckMod;
use app\common\model\Rule;
use app\common\model\Tb;
use think\facade\Config;
use think\facade\Db;
use think\facade\View;
use think\Validate;

class Ypmod extends Base
{
	protected $tableList;
	protected $dbpre;
	protected $dbname;
	protected $model;
	protected function initialize()
	{
		parent::initialize();
		$this->dbname = Config::get('database.connections.mysql.database');
		$this->dbpre = Config::get('database.connections.mysql.prefix');
		$this->tableList = Db::query("SHOW TABLE STATUS");
		$this->tableList = array_map('array_change_key_case', $this->tableList);
		$this->auth_rule_model = new Rule();
		$this->sysmod = Config::get('app.sysmod');
		$map[] = ['id', '<>', '5'];
		$admin_menu_list = $this->auth_rule_model->where($map)->order(['sort' => 'DESC', 'id' => 'ASC'])->select();
		$menuNode = array2level($admin_menu_list);
		View::assign('menuNode', $menuNode);
		View::assign('sysmod', $this->sysmod);
		View::assign('modclass', Config::get('app.modclass'));
	}
	public function index()
	{
		$dataList = Tb::order('id', 'asc')->select();
		View::assign('dataList', $dataList);
		return view();
	}
	//增加模型
	public function add()
	{
		return view();
	}
	//保存模型
	public function save()
	{
		if ($this->request->isPost()) {
			$data = $this->request->param();
			$valCheck = validate(CheckMod::class)->check($data);
			if ($valCheck !== true) {
				$this->error($valCheck->getError());
			}
			if ($mod = Tb::create($data)) {
				$this->success("增加模型成功！");
			}
		}
	}
	//编辑模型
	public function edit($id)
	{
		$r = Tb::find($id);
		View::assign('r', $r);
		return view();
	}
	//更新模型
	public function update($id = 0)
	{
		if (!$id) {
			$this->error('ID不存在');
		}
		$r = Tb::find($id);
		if (!$r) {
			$this->error('数据不存在');
		}
		$data = $this->request->param();
		//验证
		$valCheck = validate(CheckMod::class)->check($data);
		if ($valCheck !== true) {
			$this->error($valCheck->getError());
		}

		//表名称
		$data['name'] = $r->name;
		//表名
		$tbname = $this->dbpre . $r->name;
		//更新数据
		if ($r->save($data)) {
			$this->success("模型更新成功！");
		}
	}
	//表单
	public function mkform($id)
	{
		$r = Tb::find($id);
		$rules = Db::name('colrule')->select();
		$cols = $r->cols;
		$colrule = $r->colrule;
		$form = app('form', [$id]); //表单对象
		View::assign('form', $form->getForm());

		View::assign('r', $r);
		View::assign('cols', $cols);
		View::assign('rules', $rules);
		View::assign('colrule', $colrule);
		return view();
	}
	//表单
	public function rule($id)
	{
		$r = Tb::find($id);
		$rules = Db::name('colrule')->select();
		$cols = $r->cols;
		$colrule = $r->colrule;
		$form = $this->getForm($cols, $colrule, '', $r);
		View::assign('r', $r);
		View::assign('cols', $cols);
		View::assign('form', $form);
		View::assign('rules', $rules);
		View::assign('colrule', $colrule);
		return view();
	}

	//字段规则
	public function updateRule()
	{
		if ($this->request->isPost()) {
			$data = $this->request->param();
			$id = $data['id'];
			if (!isset($data['rule'])) {
				return Db::name('tb')->where('id', $id)->update(['colrule' => '']);
			}
			$colrule = json_encode($data['rule']);
			if (Db::name('tb')->where('id', $id)->update(['colrule' => $colrule])) {
				$this->success('保存成功');
			} else {
				$this->error('保存失败');
			}
		}
	}

	//删除模型
	public function delete($id = 0)
	{
		if ($id) {
			if (Tb::destroy($id)) {
				$this->success('删除成功');
			} else {
				$this->error('删除失败');
			}
		} else {
			$this->error('请选择删除对象');
		}
	}
}
