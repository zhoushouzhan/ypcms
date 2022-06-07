<?php

namespace app\common\model;

use think\Model;
//本模型为系统生成
class System extends Model
{
	//数据查询后事件
	public static function onAfterRead($data)
	{
		if (class_exists('\user\System')) {
			$data = app('System')->onAfterRead($data);
		}
	}
	//数据写入前事件
	public static function onBeforeWrite($data)
	{
		if (class_exists('\user\System')) {
			$data = app('System')->onBeforeWrite($data);
		}
	}
	//数据写入后事件
	public static function onAfterWrite($data)
	{

		if (isset($data['sitelogo'])) {
			Files::bindInfo($data['sitelogo']['id'], $data['id'], $data['category_id'], 'system', 'sitelogo');
		}

		if (isset($data['footlogo'])) {
			Files::bindInfo($data['footlogo']['id'], $data['id'], $data['category_id'], 'system', 'footlogo');
		}
		if (class_exists('\user\System')) {
			$data = app('System')->onAfterWrite($data);
		}
	}
	//数据新增前事件
	public static function onBeforeInsert($data)
	{
		if (class_exists('\user\System')) {
			$data = app('System')->onBeforeInsert($data);
		}
	}
	//数据新增后事件
	public static function onAfterInsert($data)
	{
		if (class_exists('\user\System')) {
			$data = app('System')->onAfterInsert($data);
		}
	}
	//数据更新前事件
	public static function onBeforeUpdate($data)
	{
		if (class_exists('\user\System')) {
			$data = app('System')->onBeforeUpdate($data);
		}
	}
	//数据更新后事件
	public static function onAfterUpdate($data)
	{
		if (class_exists('\user\System')) {
			$data = app('System')->onAfterUpdate($data);
		}
	}
	//数据恢复前事件
	public static function onBeforeRestore($data)
	{
		if (class_exists('\user\System')) {
			$data = app('System')->onBeforeRestore($data);
		}
	}
	//数据恢复后事件
	public static function onAfterRestore($data)
	{
		if (class_exists('\user\System')) {
			$data = app('System')->onAfterRestore($data);
		}
	}
	//数据删除前事件
	public static function onBeforeDelete($data)
	{
		if (class_exists('\user\System')) {
			$data = app('System')->onBeforeDelete($data);
		}
	}
	//数据删除后事件
	public static function onAfterDelete($data)
	{
		if (class_exists('\user\System')) {
			$data = app('System')->onAfterDelete($data);
		}
	}

	//关联网站LOGO单图片
	public function getSitelogoAttr($value, $data)
	{
		return \app\common\model\Files::find($value);
	}

	//关联底部LOGO单图片
	public function getFootlogoAttr($value, $data)
	{
		return \app\common\model\Files::find($value);
	}
	//关联模型system
	public function modinfo()
	{
		return $this->belongsTo(Tb::class);
	}
	//自定义表单
	public static function appendForm($data)
	{
		if (class_exists('\user\System')) {
			$data = app('System')->appendForm($data);
		}
	}
}
