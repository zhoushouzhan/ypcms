<?php
/*
 * @Author: 一品网络技术有限公司
 * @Date: 2022-06-08 07:55:45
 * @LastEditTime: 2022-06-09 07:21:06
 * @FilePath: \ypcms\app\admin\validate\CheckMenu.php
 * @Description:
 * 联系QQ:58055648
 * Copyright (c) 2022 by 东海县一品网络技术有限公司, All Rights Reserved.
 */

declare(strict_types=1);

namespace app\admin\validate;

use think\Validate;

class CheckMenu extends Validate
{
	protected $rule = [
		'pid' => 'require',
		'title' => 'require',
		'name' => 'require',
		'sort' => 'require|number',
	];

	protected $message = [
		'pid.require' => '请选择上级菜单',
		'title.require' => '请输入菜单名称',
		'name.require' => '请输入控制器方法',
		'sort.require' => '请输入排序',
		'sort.number' => '排序只能填写数字',
	];
}
