<?php
/*
 * @Author: 一品网络技术有限公司
 * @Date: 2022-06-08 07:55:45
 * @LastEditTime: 2022-06-09 07:21:12
 * @FilePath: \ypcms\app\admin\validate\CheckMod.php
 * @Description:
 * 联系QQ:58055648
 * Copyright (c) 2022 by 东海县一品网络技术有限公司, All Rights Reserved.
 */

declare(strict_types=1);

namespace app\admin\validate;

use think\Validate;

class CheckMod extends Validate
{
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
