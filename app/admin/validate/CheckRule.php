<?php
/*
 * @Author: 一品网络技术有限公司
 * @Date: 2022-06-08 07:55:45
 * @LastEditTime: 2022-06-09 07:21:17
 * @FilePath: \ypcms\app\admin\validate\CheckRule.php
 * @Description:
 * 联系QQ:58055648
 * Copyright (c) 2022 by 东海县一品网络技术有限公司, All Rights Reserved.
 */

declare(strict_types=1);

namespace app\admin\validate;

use think\Validate;

class CheckRule extends Validate
{
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
