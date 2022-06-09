<?php
/*
 * @Author: 一品网络技术有限公司
 * @Date: 2022-06-08 07:55:45
 * @LastEditTime: 2022-06-08 18:16:00
 * @FilePath: \ypcms\app\index\controller\Api.php
 * @Description:
 * 联系QQ:58055648
 * Copyright (c) 2022 by 东海县一品网络技术有限公司, All Rights Reserved.
 */

declare(strict_types=1);

namespace app\index\controller;

class Api extends Base
{
	protected function initialize()
	{
		$this->sendMsg = app('sendMsg');
		$this->qrcode = app('qrcode');
	}
	public function index()
	{
	}
	//发送手机短信，邮箱短信
	public function getCode()
	{
		$this->sendMsg->getCode();
	}
	//二维码
	public function ypqr($str)
	{
		$errorCorrectionLevel = 'L';
		$matrixPointSize = 10;
		$this->qrcode::png($str, false, $errorCorrectionLevel, $matrixPointSize, 2);
	}
}
