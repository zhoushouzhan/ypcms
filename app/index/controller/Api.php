<?php
declare (strict_types = 1);
namespace app\index\controller;

class Api extends Base {
	protected function initialize() {
		$this->sendMsg = app('sendMsg');
		$this->qrcode = app('qrcode');
		//当前周期
		$map[] = ['stime', '<', time()];
		$map[] = ['etime', '>', time()];
		$map[] = ['ftype', '=', 3409];
		$this->zhouqi = \app\common\model\Xueqi::where($map)->find();
		$dayArr = Date_segmentation($this->zhouqi->stime, $this->zhouqi->etime);
		$this->zhouqi->allDay = $dayArr['days_list'];

	}
	public function index() {
		return 'x';
	}
}