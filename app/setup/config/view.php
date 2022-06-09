<?php
/*
 * @Author: 一品网络技术有限公司
 * @Date: 2022-06-08 07:55:45
 * @LastEditTime: 2022-06-09 07:28:27
 * @FilePath: \ypcms\app\setup\config\view.php
 * @Description:
 * 联系QQ:58055648
 * Copyright (c) 2022 by 东海县一品网络技术有限公司, All Rights Reserved.
 */

declare(strict_types=1);
return [
	// 模板引擎类型使用Think
	'type' => 'Think',
	// 默认模板渲染规则 1 解析为小写+下划线 2 全部转换小写 3 保持操作方法
	'auto_rule' => 1,
	// 模板目录名
	'view_dir_name' => 'view',
	// 模板后缀
	'view_suffix' => 'html',
	// 模板文件名分隔符
	'view_depr' => DIRECTORY_SEPARATOR,
	// 模板引擎普通标签开始标记
	'tpl_begin' => '{',
	// 模板引擎普通标签结束标记
	'tpl_end' => '}',
	// 标签库标签开始标记
	'taglib_begin' => '{',
	// 标签库标签结束标记
	'taglib_end' => '}',
	// 默认的过滤方法htmlentities,不转义{$data.name|raw}
	'default_filter' => 'htmlspecialchars',
	//模板缓存
	'tpl_cache' => false,
	//替换字符
	'tpl_replace_string' => [
		'__STATIC__' => '/static',
	],
];
