<?php

declare(strict_types=1);

namespace app\admin\controller;


use think\facade\Db;
use think\facade\Validate;
use think\facade\View;

class Listinfo extends Base
{
	public $cid = "";
	public $category = "";
	public $cols = "";
	public $rules = "";
	public $enabled = [];
	protected function initialize()
	{
		parent::initialize();
		$this->category_id = $this->request->param('category_id/d');
		$this->ypmod = new \app\admin\controller\Ypmod($this->app);
		//栏目
		$this->category = \app\common\model\Category::find($this->category_id);
		//当前表
		$this->table = $this->category->list();
		//所有列
		$this->cols = $this->category->modinfo->cols;
		//是否支持搜索
		$searchCol = $this->category->getSearchCol();
		//是否有审核
		$this->enabled = $this->category->modinfo->getEnabled();
		View::assign('enabled', $this->enabled);
		//搜索字段
		View::assign('searchCol', $searchCol);
		//列表显示列
		$this->listv = $this->category->modinfo->listv();
		//验证
		$this->rules = $this->category->modinfo->colrule;
		View::assign('category_id', $this->category_id);
		View::assign('category', $this->category);
		View::assign("cols", $this->cols);
		View::assign("listv", $this->listv);
	}

	//列表
	public function index($page = 1, $limit = 15)
	{
		$map = $this->category->keymap($this->request->param());
		$dataList = $this->table::where($map)->order('id', 'desc')->paginate(['list_rows' => $limit, 'query' => $this->request->param()]);
		View::assign('dataList', $dataList);
		return view();
	}
	//增加信息
	public function add()
	{
		//赋值
		$data['category_id'] = $this->category_id; //栏目
		$data['admin_id'] = $this->admin; //发布人
		$r = $this->category->modinfo->addData($data); //组合字段内容
		$form = app('form', ['id' => $this->category->modinfo->id, 'data' => $data]); //表单对象
		View::assign('form', $form->getForm());
		View::assign('r', $r);
		$template = $this->category->modinfo->name . '/form';
		return view($template);
	}
	//保存信息
	public function save($category_id = 0)
	{
		if ($this->request->isPost()) {
			$data = $this->category->modinfo->saveData($this->request->param()); //组合字段内容

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
					if ($this->table::create($data)) {
						$this->success('保存成功', (string) url('index', ['category_id' => $this->category_id]));
					} else {
						$this->error('保存失败');
					}
				}
			}
		}
	}
	//编辑信息
	public function edit($id)
	{
		$r = $this->table::find($id); //查询数据
		$r = $this->category->modinfo->editData($r); //组合字段内容
		$r['admin_id'] = $this->admin; //编辑人员
		$form = app('form', ['id' => $this->category->modinfo->id, 'data' => $r]); //表单对象
		View::assign('form', $form->getForm());
		View::assign('r', $r);
		$template = $this->category->modinfo->name . '/form';
		return view($template);
	}
	//更新
	public function update($id = 0)
	{
		if ($this->request->isPost()) {
			$data = $this->category->modinfo->saveData($this->request->param()); //组合字段内容

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
					$this->success('更新成功', (string) url('index', ['category_id' => $this->category_id]));
				} else {
					$this->error('更新失败');
				}
			}
		}
	}
	//审核
	public function checkInfo()
	{
		if ($this->request->isPost()) {
			$data = $this->request->param();
			foreach ($data['id'] as $k => $v) {
				$list[] = ['id' => $v, 'enabled' => $this->enabled[$data['enabled'][$k]]];
			}
			$mod = new $this->table;
			if ($mod->saveAll($list)) {
				$this->success('审核操作成功');
			} else {
				$this->error('系统错误');
			}
		}
	}
	//删除信息
	public function delete($id = 0, $ids = [])
	{
		$id = $ids ? $ids : $id;
		if (is_array($id)) {
			$id = array_map('intval', $id); //奖字符型ID转成数字型ID，否则无法删除，这应该是TP的缺陷。
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
	//导出数据
	public function export()
	{
	}
	//导入数据
	public function import()
	{
	}
}
