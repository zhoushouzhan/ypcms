<?php
/*
 * @Author: 一品网络技术有限公司
 * @Date: 2022-06-08 07:55:45
 * @LastEditTime: 2022-06-09 07:20:50
 * @FilePath: \ypcms\app\admin\validate\CheckCategory.php
 * @Description:
 * 联系QQ:58055648
 * Copyright (c) 2022 by 东海县一品网络技术有限公司, All Rights Reserved.
 */

declare(strict_types=1);

namespace app\admin\validate;

use think\Validate;

class CheckCategory extends Validate
{
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
	protected function checkTb($value, $rule, $data = [])
	{
		if ($value <= 0) {
			return '请选择模型';
		}
		return true;
	}
}
