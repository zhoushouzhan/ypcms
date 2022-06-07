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

class CheckRule extends Validate {
	protected $rule = [
		'name' => 'require',
		'rule' => 'require',
		'msg' => 'require',
	];

	protected $message = [
		'name.require' => '规则名称必填',
		'rule.require' => '规则必填',
		'msg.require' => '提示信息必填',
	];
}