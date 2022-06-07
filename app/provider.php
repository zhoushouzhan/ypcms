<?php

use app\ExceptionHandle;
use app\Request;
use util\Auth;
use util\Qrcode;
use util\SendMsg;
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
	'qrcode' => Qrcode::class,
	'sendMsg' => SendMsg::class,
];
