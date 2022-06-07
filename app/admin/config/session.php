<?php
return [
	// session name
	'name' => 'YPCMSADMINSESSIONID',
	// SESSION_ID的提交变量,解决flash上传跨域
	'var_session_id' => 'ypcms',
	// 驱动方式 支持file cache
	'type' => 'file',
	// 存储连接标识 当type使用cache的时候有效
	'store' => null,
	// 过期时间
	'expire' => 3600,
	// 前缀
	'prefix' => 'admin',
	//序列化
	'serialize' => ['json_encode', 'json_decode'],
];
