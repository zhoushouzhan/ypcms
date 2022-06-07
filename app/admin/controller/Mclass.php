<?php
// +----------------------------------------------------------------------
// | 一品内容管理系统 [ YPCMS ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2019 东海县一品网络技术有限公司
// +----------------------------------------------------------------------
// | 官方网站: http://www.yipinjishu.com
// +----------------------------------------------------------------------
declare (strict_types = 1);
//无限分类管理
namespace app\admin\controller;
use app\common\model\Mclass as MclassModel;
use think\facade\View;

class Mclass extends Base {
	protected function initialize() {
		parent::initialize();
		$this->table = new MclassModel();
		$this->data = $this->table::select();
	}
//列表
	public function index($pid = 0, $limit = 20, $page = 1) {
		$map[] = ['pid', '=', $pid];
		$pathArr = [];
		if ($pid) {
			$r = $this->table->where('id', $pid)->find();
			$path = $r->path;
			$pathArr = $this->table->where('id', 'in', $path)->select();
			//无子分类向上一级
			if (!$count = $this->table->where($map)->count()) {
				$jumpUrl = (string) url('mclass/index', ['pid' => $r->pid]);
				return redirect($jumpUrl);
			}
		}
		$dataList = $this->table->where($map)->order('sort', 'desc')->paginate($limit, false, ['page' => $page]);
		View::assign('pathArr', $pathArr);
		View::assign('dataList', $dataList);
		View::assign('r', $this->table::find($pid));
		View::assign('pid', $pid);
		return view();
	}
//添加
	public function add($pid = 0) {
		$pathArr = [];
		if ($pid) {
			$r = $this->table->where('id', $pid)->find();
			$path = $r->path;
			$pathArr = $this->table->where('id', 'in', $path)->select();
		}
		View::assign('pathArr', $pathArr);
		View::assign('r', $this->table::find($pid));
		View::assign('pid', $pid);
		return view('add');
	}
//保存
	public function save() {
		if (input("?post.titles")) {
			$titles = input('post.titles');
			$pid = input('post.pid/d');
			$path = input('post.path');
			foreach (explode("\r\n", $titles) as $key => $value) {
				$arr = explode('|', $value);
				if (empty(trim($arr[0]))) {
					continue;
				}
				$data[$key]['title'] = trim($arr[0]);
				$data[$key]['sort'] = isset($arr[1]) ? (int) $arr[1] : 0;
				$data[$key]['pid'] = input('post.pid/d');
			}
			if ($this->table->saveAll($data)) {
				$this->success('保存成功', (string) url('mclass/index', ['pid' => $pid]));
			} else {
				$this->error('保存失败');
			}
		} else {
			$this->error('请输入正确的分类');
		}
	}
//更新
	public function update($id) {
		if ($this->request->isPost()) {
			$data = $this->request->param();
			$update = [];
			foreach ($data['id'] as $k => $id) {
				$update[$k]['id'] = $id;
				$update[$k]['sort'] = $data['sort'][$k];
				$update[$k]['title'] = $data['title'][$k];
			}
			if ($this->table->saveAll($update)) {
				$this->success('更新成功');
			} else {
				$this->error('更新失败');
			}
		}
	}
//删除时同时删除子类
	public function delete($ids) {
		$data = $this->table->select();
		if (is_array($ids)) {
			$ids = array_map('intval', $ids); //数值转为整型
			if (count($ids) == 1) {
				$ids = (int) $ids[0];
			}
		}
		if ($this->table->destroy($ids)) {
			$this->success('删除成功');
		} else {
			$this->error('删除失败');
		}
	}
//模型中选择器
	public function sclass($pid = 0, $limit = 20, $page = 1) {
		$map[] = ['pid', '=', $pid];
		$pathArr = $this->table->field('id,pid,title')->select();
		$dataList = $this->table->where($map)->order('sort', 'asc')->paginate($limit, false, ['page' => $page]);
		View::assign('dataList', $dataList);
		View::assign('r', $this->table::find($pid));
		View::assign('pid', $pid);
		return view();
	}
//分类输出
	public function getSon($pid) {
		$arr['code'] = 0;
		$arr['data'] = [];
		foreach ($this->data as $key => $value) {
			if ($value['id'] == $pid && $value['havesid']) {
				$arr['code'] = 1;
			}
			if ($value['pid'] == $pid) {
				$arr['data'][] = $value;
			}
		}
		return $arr;
	}
//分类关系输出
	public function getSelected($id, $pid) {
		$arr = [];
		$pathArr = [];
		if (!empty($id)) {
			//更新
			foreach ($this->data as $key => $value) {
				if ($value['id'] == $id) {
					$path = $value['path'];
				}
			}
			//选择指定节点以后的分类
			$pathArr = explode($pid, $path . $id);
			$pathArr = explode(',', $pid . $pathArr[1]);
			$selectNode = [];
			foreach ($pathArr as $k) {
				if ($k == 0) {
					continue;
				}
				foreach ($this->data as $v) {
					if ($k == $v['pid']) {
						if (in_array($v['id'], $pathArr)) {
							$v['current'] = 1;
						} else {
							$v['current'] = 0;
						}
						$selectNode[$k][] = $v;
					}
				}
			}
		} else {
			//新增
			foreach ($this->data as $key => $value) {
				if ($value['pid'] ==
					$pid) {$arr[] = $value;}}$selectNode[] = $arr;}

		return $selectNode;
	}
}