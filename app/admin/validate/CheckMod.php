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

class CheckMod extends Validate {
	protected $rule = [
		'name' => 'require|unique:tb|max:30',
		'alias' => 'require',
		'cols' => 'require',
	];

	protected $message = [
		'name.require' => '模型名称必须填写',
		'name.unique' => '模型己存在',
		'name.max' => '模型名称最多10个字母',
		'alias.require' => '模型别名填写',
		'cols.require' => '字符信息必填',
	];
}