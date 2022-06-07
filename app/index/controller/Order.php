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
use app\common\model\Category;
use app\common\model\Order as OrderModel;
use app\common\model\Pay;
use think\facade\View;

//本控制器为系统生成,具体功能需要您来配置
class Order extends Base {
	protected function initialize() {
		parent::initialize();
		if ($this->request->param('category_id')) {
			$this->cid = $this->request->param('category_id');
			//栏目
			$this->category = Category::find($this->cid);
			//模型
			$modName = ucfirst($this->category->modinfo->name);
			$modelName = "\app\common\model\\$modName";
			$this->table = new $modelName;
		}
	}

//下单
	public function add($id = 0) {
		if (!$id) {
			$this->error('no id');
		}
		$r = $this->table::find($id);
		if (!$r) {
			$this->error('no data');
		}
		//检查是否己有订单
		$oldmap[] = ['goods', '=', $id];
		$oldmap[] = ['category_id', '=', $this->cid];
		$oldmap[] = ['status', '=', 0];
		$oldmap[] = ['ip', '=', $this->request->ip()];
		$old = OrderModel::where($oldmap)->find();

		if ($old) {
			//判断订单是否失效,2小时后未付款的失效
			$create_time = (int) $old->create_time;
			$now = time();
			if ($now - $create_time < 7200) {
				$tourl = (string) url('index/order/details', ['ordersn' => $old->ordersn]);
				$this->success('己有订单', $tourl, 'json');die;
			} else {
				$old->status = -1;
				$old->save();
			}
		}
		//创建订单
		$ordersn = ordersn();
		$insert['ordersn'] = $ordersn;
		$insert['goods'] = $id;
		$insert['category_id'] = $this->cid;
		$insert['money'] = $r->price;
		$insert['ip'] = $this->request->ip();
		$insert['tb_id'] = $this->category->modinfo->id;
		if (isset($this->userid)) {
			$insert['user_id'] = $this->userid;
		}

		//快照关键信息
		$insert['info'] = $r->visible(['title', 'price', 'intro'])->toJson();
		if ($r = OrderModel::create($insert)) {
			$tourl = (string) url('index/order/details', ['ordersn' => $ordersn]);
			$this->success('创建订单成功', $tourl, '', $r);
		} else {
			$this->error('创建订单失败');
		}

	}
//查看订单
	public function details($ordersn = 0) {
		$r = OrderModel::where('ordersn', $ordersn)->find();
		$paylist = Pay::where('enabled', 1)->select();
		View::assign([
			'r' => $r,
			'paylist' => $paylist,
		]);
		return view();
	}
}