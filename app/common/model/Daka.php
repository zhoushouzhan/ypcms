<?php
/*
 * @Author: 一品网络技术有限公司
 * @Date: 2021-11-16 17:00:09
 * @LastEditTime: 2022-05-29 08:26:54
 * @FilePath: \ypcms\app\common\model\Daka.php
 * @Description:
 * 联系QQ:58055648
 * Copyright (c) 2022 by 东海县一品网络技术有限公司, All Rights Reserved.
 */

namespace app\common\model;

use think\Model;
//本模型为系统生成
class Daka extends Model
{
	//数据查询后事件
	public static function onAfterRead($data)
	{
		if (class_exists('\user\Daka')) {

			$data = app('Daka')->onAfterRead($data);
		}
	}
	//数据写入前事件
	public static function onBeforeWrite($data)
	{
	}
	//数据写入后事件
	public static function onAfterWrite($data)
	{

		if (isset($data['photo'])) {
			Files::bindInfo($data['photo_post'], $data['id'], $data['category_id'], 'daka', 'photo');
		}
	}
	//数据新增前事件
	public static function onBeforeInsert($data)
	{
	}
	//数据新增后事件
	public static function onAfterInsert($data)
	{
	}
	//数据更新前事件
	public static function onBeforeUpdate($data)
	{
	}
	//数据更新后事件
	public static function onAfterUpdate($data)
	{
	}
	//数据恢复前事件
	public static function onBeforeRestore($data)
	{
	}
	//数据恢复后事件
	public static function onAfterRestore($data)
	{
	}
	//数据删除前事件
	public static function onBeforeDelete($data)
	{
	}
	//数据删除后事件
	public static function onAfterDelete($data)
	{
	}

	//关联栏目
	public function category()
	{
		return $this->belongsTo(\app\common\model\Category::class);
	}

	//关联用户
	public function admin()
	{
		return $this->belongsTo(\app\common\model\Admin::class);
	}

	//关联相册相册
	public function getPhotoAttr($value, $data)
	{
		$map[] = ['ypcms_id', '=', $data['id']];
		$map[] = ['ypcms_type', '=', 'daka'];
		$map[] = ['tag', '=', 'Photo'];
		return \app\common\model\Files::where($map)->select()->toArray();
	}
	//关联模型daka
	public function modinfo()
	{
		return $this->belongsTo(Tb::class);
	}
}
