<?php
/*
 * @Author: 一品网络技术有限公司
 * @Date: 2022-05-13 16:20:43
 * @LastEditTime: 2022-05-29 11:23:03
 * @FilePath: \ypcms\app\common\model\Ad.php
 * @Description:
 * 联系QQ:58055648
 * Copyright (c) 2022 by 东海县一品网络技术有限公司, All Rights Reserved.
 */

namespace app\common\model;

use think\Model;
//本模型为系统生成
class Ad extends Model
{
	//数据查询后事件
	public static function onAfterRead($data)
	{
		if (class_exists('\user\Ad')) {
			$data = app('Ad')->onAfterRead($data);
		}
	}
	//数据写入前事件
	public static function onBeforeWrite($data)
	{
		if (class_exists('\user\Ad')) {
			$data = app('Ad')->onBeforeWrite($data);
		}
	}
	//数据写入后事件
	public static function onAfterWrite($data)
	{

		if (isset($data['thumb'])) {
			Files::bindInfo($data['thumb']['id'], $data['id'], $data['category_id'], 'ad', 'thumb');
		}
		if (class_exists('\user\Ad')) {
			$data = app('Ad')->onAfterWrite($data);
		}
	}
	//数据新增前事件
	public static function onBeforeInsert($data)
	{
		if (class_exists('\user\Ad')) {
			$data = app('Ad')->onBeforeInsert($data);
		}
	}
	//数据新增后事件
	public static function onAfterInsert($data)
	{
		if (class_exists('\user\Ad')) {
			$data = app('Ad')->onAfterInsert($data);
		}
	}
	//数据更新前事件
	public static function onBeforeUpdate($data)
	{
		if (class_exists('\user\Ad')) {
			$data = app('Ad')->onBeforeUpdate($data);
		}
	}
	//数据更新后事件
	public static function onAfterUpdate($data)
	{
		if (class_exists('\user\Ad')) {
			$data = app('Ad')->onAfterUpdate($data);
		}
	}
	//数据恢复前事件
	public static function onBeforeRestore($data)
	{
		if (class_exists('\user\Ad')) {
			$data = app('Ad')->onBeforeRestore($data);
		}
	}
	//数据恢复后事件
	public static function onAfterRestore($data)
	{
		if (class_exists('\user\Ad')) {
			$data = app('Ad')->onAfterRestore($data);
		}
	}
	//数据删除前事件
	public static function onBeforeDelete($data)
	{
		if (class_exists('\user\Ad')) {
			$data = app('Ad')->onBeforeDelete($data);
		}
	}
	//数据删除后事件
	public static function onAfterDelete($data)
	{
		if (class_exists('\user\Ad')) {
			$data = app('Ad')->onAfterDelete($data);
		}
	}

	//关联图片单图片
	public function getThumbAttr($value, $data)
	{
		return \app\common\model\Files::find($value);
	}
	//关联模型ad
	public function modinfo()
	{
		return $this->belongsTo(Tb::class);
	}
	//自定义表单
	public static function appendForm($data)
	{
		if (class_exists('\user\Ad')) {
			return app('Ad')->appendForm($data);
		}
	}
}
