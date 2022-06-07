<?php

declare(strict_types=1);

namespace app\common\model;

use app\common\model\Files;
use app\common\model\Tb;
use think\facade\Cache;
use think\facade\Session;
use think\Model;

class Category extends Model
{
	protected $autoWriteTimestamp = true;
	protected $modid = 9;


	//数据查询后事件
	public static function onAfterRead($data)
	{
		if (class_exists('\user\Category')) {

			$data = app('Category')->onAfterRead($data);
		}
	}

	//插入数据后操作
	public static function onAfterInsert($data)
	{
		$pid = $data->pid;
		if ($pid > 0) {
			$parent = self::find($pid);
			$data->path = $parent->path . $pid . ',';
		} else {
			$data->path = ',' . 0 . ',';
		}
		$data->save();
	}
	public static function onAfterUpdate($data)
	{
	}


	//数据写入前事件
	public static function onBeforeWrite($data)
	{
	}

	//写入数据后操作
	public static function onAfterWrite($data)
	{
		//更新附件
		Files::where(['ypcms_id' => $data->id, 'ypcms_type' => 'Category'])->update(['ypcms_id' => '', 'ypcms_type' => '']);
		if ($data->thumb) {
			Files::update(['id' => $data->thumb->id, 'category_id' => $data->id, 'ypcms_id' => $data->id, 'ypcms_type' => 'Category']);
		}

		if (class_exists('\user\Category')) {
			$data = app('Category')->onAfterWrite($data);
		}

		//更新缓存
		Cache::clear();
	}
	//删除数据后操作
	public static function onAfterDelete($data)
	{
		//删除所有子栏目
		$category = self::where('path', 'like', '%,' . $data->id . ',%')->select();
		foreach ($category as $key => $value) {

			$value->delete();
		}
	}
	//获取子栏目
	public function getSon()
	{
		return self::where('pid', $pid)->select();
	}
	//标题图
	public function thumbpath()
	{
		return $this->hasone('Files', 'id', 'thumb');
	}
	//模型集
	public static function modList()
	{
		return Tb::where('mt', 2)->select();
	}
	//模型
	public function modinfo()
	{
		return $this->belongsTo(Tb::class);
	}
	//提取数据
	public function list()
	{
		return $this->modinfo->getMod();
	}
	//提取模型搜索字段
	public function getSearchCol()
	{
		$col = $this->modinfo->cols;
		$searchCol = [];
		foreach ($col as $key => $value) {
			if ($value['index']) {
				$searchCol[] = $value;
			}
		}
		return $searchCol;
	}
	//组合搜索条件
	public function keymap($data)
	{
		$keyboard = isset($data['keyboard']) ? $data['keyboard'] : 0;
		$colname = isset($data['colName']) ? $data['colName'] : 0;
		$enabled = isset($data['enabled']) ? $data['enabled'] : 0;
		$map[] = ['category_id', '=', $this->id];
		if ($enabled) {
			$map[] = ['enabled', '=', $enabled];
		}

		if ($colname) {
			$map[] = [$colname, 'like', "%$keyboard%"];
			return $map;
		}
		$col = [];
		if ($keyboard) {
			$searchCol = $this->modinfo->getSearch();
			foreach ($searchCol as $key => $value) {
				$col[] = $value['name'];
			}
			$map[] = [implode('|', $col), 'like', "%$keyboard%"];
		}

		return $map;
	}

	protected function setContentAttr($value)
	{
		return htmlspecialchars_decode($value);
	}

	public function getThumbAttr($value, $data)
	{
		return \app\common\model\Files::find($value);
	}
	public function getUrlAttr($value, $data)
	{
		return Session::get('system')['siteurl'] . $value;
	}
	//获取栏目树
	public static function getLevelList($mod = "")
	{
		$map = [];
		if ($mod) {
			$map[] = ['mod', '=', $mod];
		}
		$category_level = self::where($map)->order(['sort' => 'DESC'])->select();

		return array2level($category_level);
	}
}
