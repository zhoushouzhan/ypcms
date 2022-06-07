<?php
// +----------------------------------------------------------------------
// | 一品内容管理系统 [ 详情展示 ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2019 东海县一品网络技术有限公司
// +----------------------------------------------------------------------
// | 官方网站: http://www.yipinjishu.com
// +----------------------------------------------------------------------
declare (strict_types = 1);
namespace app\index\controller;
use app\common\model\Category as CategoryMode;
use think\facade\Cache;
use think\facade\Db;
use think\facade\View;

class Content extends Base {
	protected function initialize() {
		parent::initialize();
		$this->categoryId = $this->request->param('categoryId/d');
		//栏目信息
		$this->category = CategoryMode::find($this->categoryId);
		$this->modName = ucfirst($this->category->modinfo->name);
		$modelName = "\app\common\model\\$this->modName";
		$this->table = new $modelName;
		View::assign('category', $this->category);
		View::assign('pagetitle', $this->category->name);
	}
	public function index($id) {
		$r = $this->table::find($id);
		//统计点击量
		$ip = $this->request->ip();

		if (Cache::has('ipData')) {
			$ipdata = Cache::get('ipData');
		} else {
			$ipdata = [];
		}
		if (!in_array($ip, $ipdata)) {
			Db::name($this->modName)->where('id', $id)->inc('hits', 1)->update();
		}
		$ipdata[] = $ip;
		Cache::set('ipData', $ipdata);
		$next_r = $this->table::where('id', '<', $id)->where('category_id', $this->categoryId)->find();
		$pre_r = $this->table::where('id', '>', $id)->where('category_id', $this->categoryId)->find();
		if ($next_r) {
			$url = url('index/article/read', ['cid' => $next_r->category_id, 'id' => $next_r->id]);
			$title = $next_r->title;
			$next = "<a href=\"{$url}\">{$title}</a>";
		} else {
			$next = '<span>暂无</span>';
		}
		if ($pre_r) {
			$url = url('index/article/read', ['cid' => $pre_r->category_id, 'id' => $pre_r->id]);
			$title = $pre_r->title;
			$pre = "<a href=\"{$url}\">{$title}</a>";
		} else {
			$pre = '<span>暂无</span>';
		}
		//检测是否收藏过
		$r->isFav = 0;
		if (isset($this->userid) && $r->favorites) {
			$favUserIdArr = array_column($r->favorites->toArray(), 'user_id');
			if (in_array($this->userid, $favUserIdArr)) {
				$r->isFav = 1;
			}
		}
		//检测是否付费
		$r->havePrice = 0;
		if (isset($this->userid)) {
			$r->havePrice = \app\common\model\Order::where([
				'goods' => $id,
				'category_id' => $this->categoryId,
				'user_id' => $this->userid,
				'status' => 1,
			])->count();
		} else {
			$r->havePrice = \app\common\model\Order::where([
				'goods' => $id,
				'category_id' => $this->categoryId,
				'ip' => $this->request->ip(),
				'status' => 1,
			])->count();

		}
		//处理付费内容
		if (isset($r->price) && $r->price > 0 && $r->havePrice == 0) {
			$r->content = '';
		}

		View::assign('r', $r);
		View::assign('pre', $pre);
		View::assign('next', $next);
		//模板
		$template = $this->category->modinfo->name . '/content';
		return View($template);
	}
}
