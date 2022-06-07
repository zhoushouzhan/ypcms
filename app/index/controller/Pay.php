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
use app\common\model\Order;

//本控制器为系统生成,具体功能需要您来配置
class Pay extends Base {
	protected function initialize() {
		parent::initialize();
		$this->order = Order::where('ordersn', $this->request->param('ordersn'))->find();
	}

//支付
	public function index($paytype = '', $ordersn = '') {
		$data['money'] = $this->order->money;
		$data['ordersn'] = $ordersn;
		$data['ordername'] = '购买' . $this->order->info->title;
		$data['body'] = '购买' . $this->order->info->title;
		//购买内容模型信息
		if (isset($this->order->info->tb_id)) {
			$data['return'] = (string) url('index/article/read', ['category_id' => $this->order->category_id, 'id' => $this->order->goods]);
		}
		//购买会员组
		if (isset($this->order->info->group_id)) {
			$data['return'] = (string) url('index/user/index');
		}

		$paytype = ucfirst($paytype);
		$payController = "\app\api\controller\\$paytype";
		$topay = new $payController($this->app);
		$topay->index($data);

	}
//支付监听
	public function paystatus($ordersn) {
		if ($this->order->status[1] == 1) {
			$this->success('支付成功', (string) url("index/article/read", ['category_id' => $this->order->category_id, 'id' => $this->order->goods]), $this->order);
		} else {
			$this->error('您尚未支付');
		}
	}
//支付成功异步处理
	public function notifyOrder($ordersn) {
		$r = Order::where('ordersn', $ordersn)->find();

		//充值会员组
		if ($r->tb_id == 17) {
			$buyGroup = \app\common\model\Buygroup::where('id', $r->goods)->find();
			$r->user->group_id = $buyGroup->group_id;
			$r->user->group_date = ['inc', $buyGroup->day];
			$r->user->save();
		}

		return $ordersn;
	}
}