<?php
// +----------------------------------------------------------------------
// | 一品内容管理系统 [ 搜索程序代码 ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2019 东海县一品网络技术有限公司
// +----------------------------------------------------------------------
// | 官方网站: http://www.yipinjishu.com
// +----------------------------------------------------------------------
declare (strict_types = 1);
namespace app\index\controller;
use app\common\model\Tb;
use think\facade\View;

class Search extends Base {
	protected function initialize() {
		parent::initialize();
		//获取内容模型
		$this->modList = Tb::where('category', 1)->select();

	}
	public function index($keywords = "", $page = 1, $limit = 2) {

		View::assign('pagetitle', '搜索');
		View::assign('keywords', $keywords);
		$map = [];
		//查询
		$keyword = trim($keywords);
		if (!empty($keywords)) {
			$map[] = ['title', 'like', "%{$keywords}%"];
		}
		//遍历模型并按标题查询
		foreach ($this->modList as $key => $value) {
			$modName = $value['name'];
			$modelName = "\app\common\model\\$modName";
			$mod = new $modelName;
			$dataList[$modName] = $mod->where($map)->paginate($limit, false, ['page' => $page]);
			//获取总数
			$this->modList[$key]['total'] = $dataList[$modName]->total();
		}
		View::assign('modList', $this->modList);
		View::assign('dataList', $dataList);
		//模板
		return View();
	}
}
