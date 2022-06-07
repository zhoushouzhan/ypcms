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
use app\common\model\Slides as SlidesModel;
use app\common\model\Tb;
use think\facade\Db;
use think\facade\Validate;
use think\facade\View;

//本控制器为系统生成,具体功能需要您来配置
class Slides extends Base {
	protected function initialize() {
		parent::initialize();
		$this->tb = Tb::where('name', 'slides')->find();
		$this->cols = $this->tb->cols;
		$this->rules = $this->tb->colrule;
		$this->table = new SlidesModel();
		$this->ypmod = new \app\admin\controller\Ypmod($this->app);
	}

//列表
	public function index($page = 1) {
		$dataList = $this->table->order('sort', 'desc')->paginate(15, false, ['page' => $page]);
		View::assign('dataList', $dataList);
		return view();
	}
//新增
	public function add() {
//您的代码
		$form = $this->ypmod->getForm($this->cols, $this->rules, '', $this->tb);
		View::assign('form', $form);
		return view();
	}
//保存
	public function save() {
		if ($this->request->isPost()) {
			$data = $this->request->param();
			//验证规则
			$colrule = array_column(db::name('colrule')->select()->toArray(), null, 'id');
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

			if (empty($rules)) {
				$this->error('缺少验证规则，至少要有一个必填项！');
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
//编辑
	public function edit($id) {
		$r = $this->table::find($id);
		$form = $this->ypmod->getForm($this->cols, $this->rules, $r, $this->tb);
		View::assign('form', $form);
		return view();

	}
//更新
	public function update($id) {

		if ($this->request->isPost()) {
			$data = $this->request->param();

			//验证规则
			$colrule = array_column(db::name('colrule')->select()->toArray(), null, 'id');
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
			}
			//保存信息
			if ($this->table->update($data)) {
				$this->success('更新成功');
			} else {
				$this->error('更新失败');
			}
		}

	}
//删除
	public function delete($id = 0, $ids = []) {
		$id = $ids ? $ids : $id;
		if (is_array($id)) {
			$id = array_map('intval', $id); //奖字符型ID转成数字型ID，否则无法删除，这应该是TP的缺陷。
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