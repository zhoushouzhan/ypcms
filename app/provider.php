<?php
/*
 * @Author: 一品网络技术有限公司
 * @Date: 2022-06-08 07:55:45
 * @LastEditTime: 2022-06-09 07:29:13
 * @FilePath: \ypcms\app\provider.php
 * @Description:
 * 联系QQ:58055648
 * Copyright (c) 2022 by 东海县一品网络技术有限公司, All Rights Reserved.
 */

use app\ExceptionHandle;
use app\Request;
use util\Auth;
use yp\File;
use yp\Form;
use yp\Model;
// 容器Provider定义文件
return [
	'think\Request' => Request::class,
	'think\exception\Handle' => ExceptionHandle::class,
	'auth' => Auth::class,
	'form' => Form::class,
	'model' => Model::class,
	'file' => File::class,

];
