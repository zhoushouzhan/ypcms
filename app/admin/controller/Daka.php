<?php
declare (strict_types = 1);
namespace app\admin\controller;
use app\common\model\Daka as dakaModel;
use app\common\model\Tb;
use think\facade\Db;
use think\facade\Validate;
use think\facade\View;
class daka extends Base {
	protected function initialize() {
		parent::initialize();
		$this->tb = Tb::where('name', 'daka')->find();
		$this->cols = $this->tb->cols;
		$this->rules = $this->tb->colrule;
		$this->table = new dakaModel();
		$this->ypmod = new \app\admin\controller\Ypmod($this->app);
		//是否支持搜索
		$searchCol = $this->tb->getSearch();
		//是否有审核
		$this->enabled = $this->tb->getEnabled();
		View::assign('listv', $this->tb->listv());
		View::assign('colspan', count($this->tb->listv()) + 2);
		View::assign('searchCol', $searchCol);
		View::assign('enabled', $this->enabled);
		View::assign('mod', $this->tb);
	}

	public function index($page = 1, $keyboard = '', $limit = 15) {
		$map = $this->tb->keymap($this->request->param());
		$dataList = $this->table->where($map)->paginate($limit, false, ['page' => $page]);
		View::assign('dataList', $dataList);
		View::assign('count', $dataList->total());
		return view('');
	}

	public function add() {
		$form = app('form', [$this->tb->id]); //表单对象
		View::assign('form', $form->getForm());
		return view('form');
	}

	public function save() {
		if ($this->request->isPost()) {
			$data=$this->request->param();
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
						$this->success('保存成功', (string) url('index'));
					} else {
						$this->error('保存失败');
					}
				}
			}
		}
	}
	public function edit($id) {
		$r = $this->table::find($id); //查询数据
		$r = $this->tb->editData($r); //组合字段内容
		$form = app('form', [$this->tb->id,$r]); //表单对象
		View::assign('form', $form->getForm());
		View::assign('r', $r);
		return view('form');
	}
	public function update($id=0) {
		if ($this->request->isPost()) {
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
				if ($this->table::update($data)) {
					$this->success('更新成功', (string) url('index'));
				} else {
					$this->error('更新失败');
				}
			}

		}
	}
	public function delete($id) {
		if (is_array($id)) {
			$id = array_map('intval', $id);
		}
		if ($id) {
			if ($this->table->destroy($id)) {
				$this->success('删除成功');
			} else {
				$this->error('删除失败');
			}
		} else {
			$this->error('请选择需要删除的条目');
		}
	}
}
?>