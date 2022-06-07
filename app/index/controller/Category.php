<?php
// +----------------------------------------------------------------------
// | 一品内容管理系统 [ 栏目显示程序代码 ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2019 东海县一品网络技术有限公司
// +----------------------------------------------------------------------
// | 官方网站: http://www.yipinjishu.com
// +----------------------------------------------------------------------
declare (strict_types = 1);
namespace app\index\controller;
use app\common\model\Category as CategoryMode;
use think\facade\View;

class Category extends Base {
	protected function initialize() {
		parent::initialize();
		$this->categoryId = $this->request->param('categoryId/d');
		//栏目信息
		$this->category = CategoryMode::find($this->categoryId);

		$modName = ucfirst($this->category->modinfo->name);
		$modelName = "\app\common\model\\$modName";
		$this->table = new $modelName;
		View::assign('category', $this->category);
		View::assign('pagetitle', $this->category->name);
	}

	public function index($keywords = "", $page = 1, $limit = 20) {
		$map = [];
		//查询
		$keyword = trim($keywords);
		if (!empty($keywords)) {

			$map[] = ['title', 'like', "%{$keywords}%"];
		}
		//子栏目判断
		if (!$this->category->islast[0]) {
			$sonids = CategoryMode::where('pid', $this->categoryId)->column('id');
			$map[] = ['category_id', 'in', $sonids];
			$tempname = 'index';
		} else {
			$map[] = ['category_id', '=', $this->categoryId];
			$tempname = 'category';
		}

		$dataList = $this->table->where($map)->paginate($limit, false, ['page' => $page]);
		View::assign('dataList', $dataList);
		//模板
		$template = $this->category->modinfo->name . '/' . $tempname;
		return View($template);

	}
}
