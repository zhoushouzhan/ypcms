<?php
// +----------------------------------------------------------------------
// | 一品内容管理系统 [ YPCMS ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2019 东海县一品网络技术有限公司
// +----------------------------------------------------------------------
// | 官方网站: http://www.yipinjishu.com
// +----------------------------------------------------------------------
declare (strict_types = 1);
namespace app\admin\validate;

use think\Validate;

class CheckCategory extends Validate {
	protected $rule = [
		'pid' => 'require',
		'title' => 'require',
		'tb_id' => 'require|checkTb',
	];

	protected $message = [
		'pid.require' => '请选择上级栏目',
		'title.require' => '请输入栏目名称',
		'tb_id.require' => '请选择模型',
	];

	// 自定义验证规则
	protected function checkTb($value, $rule, $data = []) {
		if ($value <= 0) {
			return '请选择模型';
		}
		return true;
	}
}