<?php
// +----------------------------------------------------------------------
// | 一品内容管理系统 [ YPCMS ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2019 东海县一品网络技术有限公司
// +----------------------------------------------------------------------
// | 官方网站: http://www.yipinjishu.com
// +----------------------------------------------------------------------
declare (strict_types = 1);
namespace app\index\controller;
use think\facade\Cache;
use think\facade\Db;
use think\facade\View;

class Article extends Base {
	protected function initialize() {
		parent::initialize();
		$this->table = new \app\common\model\Article;
		$this->mod = \app\common\model\Tb::where('name', 'article')->find();
		View::assign([
			'pagetitle' => '文章',
			'mod' => $this->mod,
		]);
	}
	public function index($keywords = "", $page = 1, $limit = 20) {
		$map = [];
		if ($keywords) {
			$map[] = ['title', 'like', "%$keywords%"];
		}

		$dataList = $this->table->where($map)->paginate($limit, false, ['page' => $page]);
		View::assign([
			'dataList' => $dataList,
		]);
		return view();
	}
	//内页
	public function read($id) {
		$r = $this->table::find($id);
		//统计点击量
		$ip = $this->request->ip();

		if (Cache::has('ipData')) {
			$ipdata = Cache::get('ipData');
		} else {
			$ipdata = [];
		}
		if (!in_array($ip, $ipdata)) {
			Db::name('article')->where('id', $id)->inc('hits', 1)->update();
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
		return view();
	}
}
