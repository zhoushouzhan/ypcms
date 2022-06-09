<?php

declare(strict_types=1);

namespace app\common\model;

use think\facade\Config;
use think\facade\Session;
use think\Model;
use think\helper\Str;

class Tb extends Model
{
	static public $sysmod = [];
	protected static function init()
	{
		self::$sysmod = Config::get('app.sysmod');
	}
	//增加前
	public static function onBeforeInsert($data)
	{
		//创建数据表
		$model = app('model', ["data" => $data])->createTable();
	}
	//增加后
	public static function onAfterInsert($data)
	{
		if (in_array($data['name'], self::$sysmod)) {
			return;
		}
		//创建节点菜单
		Rule::createMenu($data);
	}
	//删除后
	public static function onAfterDelete($data)
	{
		if (in_array($data['name'], self::$sysmod)) {
			return;
		}
		//删除模型
		$model = app('model', ["data" => $data])->removeMod();
		//删除模型文件
		$file = app('file', ["data" => $data])->removeMod();
		//删除节点菜单
		self::removeMenu($data);
		//删除控制器文件
		$file = app('file', ["data" => $data])->removeControllerFile();
		//删除模板文件
		$file = app('file', ["data" => $data])->removeViewFile();
	}
	//更新前
	public static function onBeforeUpdate($data)
	{
		//更新数据表
		$model = app('model', ["data" => $data])->updateTable();
	}
	//更新后
	public static function onAfterUpdate($data)
	{
		if (in_array($data['name'], self::$sysmod)) {
			return;
		}
		//删除节点菜单
		self::removeMenu($data);
		//创建节点菜单
		Rule::createMenu($data);
	}
	//写入前
	public static function onBeforeWrite($data)
	{
	}

	//写入后
	public static function onAfterWrite($data)
	{
		if (in_array($data['name'], self::$sysmod)) {
			return;
		}

		app('file', ["data" => $data])->createModFile();
		app('file', ["data" => $data])->createControllerFile();
		app('file', ["data" => $data])->createView();
	}
	//名称统一为小写
	public function setNameAttr($value, $data)
	{
		return Str::lower($value);
	}
	//修改字段为JSON
	public function setColsAttr($value, $data)
	{
		if ($value) {
			return json_encode($value);
		}
	}
	public function getColsAttr($value)
	{
		if ($value) {
			return json_decode($value, true);
		}
	}

	public function setColGroupsAttr($value)
	{
		if ($value) {
			return json_encode($value);
		}
	}

	public function getColGroupsAttr($value)
	{
		if ($value) {
			return json_decode($value, true);
		}
	}

	public function getColruleAttr($value)
	{
		if ($value) {
			return json_decode($value, true);
		}
	}
	public function category()
	{
		return $this->hasOne(Category::class);
	}
	public function listv()
	{
		$cols = $this->cols;
		$listv = [];
		$except = ['create_time', 'update_time'];
		foreach ($cols as $key => $value) {
			if (isset($value['listv'])) {
				if (strstr($value['name'], '_') && !in_array($value['name'], $except)) {
					$tagpos = strripos($value['name'], '_');
					$value['name'] = substr($value['name'], 0, $tagpos);
				}
				$listv[] = $value;
			}
		}
		return $listv;
	}

	//删除节点菜单
	public static function removeMenu($data)
	{
		Rule::where('tb_id', $data['id'])->delete();
	}
	//组合录入表单字段
	public function addData($data)
	{
		foreach ($this->cols as $key => $value) {
			$r[$value['name']] = isset($data[$value['name']]) ? $data[$value['name']] : '';
			switch ($value['formItem']) {
				case 'select':
					$r[$value['name'] . 'Select'] = Mclass::getSelected($r[$value['name']], $value['sval']);
					break;
				case 'checkbox':
					$r[$value['name'] . 'Checkbox'] = Mclass::getCheckbox($r[$value['name']], $value['sval']);
					break;
				case 'radio':
					$r[$value['name'] . 'Radio'] = Mclass::getRadio($r[$value['name']], $value['sval']);
					break;
				case 'photo':
					$r[$value['name'] . 'res'] = [];
					break;
				case 'files':
					$r['files'] = [];
					break;
				default:
					# code...
					break;
			}
		}
		return $r;
	}
	//组合编辑表单字段
	public function editData($data)
	{
		foreach ($this->cols as $key => $value) {
			switch ($value['formItem']) {
				case 'select':
					$data[$value['name'] . 'Select'] = isset($data[$value['name']]) ? Mclass::getSelected($data[$value['name']]->id, $value['sval']) : Mclass::getSelected(0, $value['sval']);
					break;
				case 'checkbox':
					$data[$value['name'] . 'Checkbox'] = isset($data[$value['name']]) ? Mclass::getCheckbox($data[$value['name']], $value['sval']) : Mclass::getCheckbox(0, $value['sval']);
					break;
				case 'radio':
					$data[$value['name'] . 'Radio'] = isset($data[$value['name']]) ? Mclass::getRadio($data[$value['name']]->id, $value['sval']) : Mclass::getRadio(0, $value['sval']);
					break;
				default:
					# code...
					break;
			}
		}
		return $data;
	}
	//组合保存字段
	public function saveData($data)
	{
		foreach ($this->cols as $key => $value) {
			if ($value['name'] == 'create_time' || $value['name'] == 'update_time' || !isset($data[$value['name']]) || empty($data[$value['name']])) {
				continue;
			}

			switch ($value['formItem']) {
				case 'select':
					$r[$value['name']] = isset($data[$value['name']]) ? $data[$value['name']] : '';
					break;
				case 'checkbox':
					$r[$value['name']] = isset($data[$value['name']]) ? implode(',', $data[$value['name']]) : '';
					break;

				case 'photo':
					$r[$value['name'] . '_post'] = $data[$value['name']];
					break;
				case 'files':
					$r[$value['name']] = isset($data[$value['name']]) ? implode(',', $data[$value['name']]) : '';
					break;
				case 'password':
					$r[$value['name']] = md5($data[$value['name']] . Config::get('database.salt'));
					break;
				default:
					$r[$value['name']] = isset($data[$value['name']]) ? $data[$value['name']] : $value['sval'];
					break;
			}
		}
		if (isset($data['id'])) {
			$r['id'] = $data['id'];
		}
		$r['schoolid'] = Session::get('schoolid');
		$r['admin_id'] = Session::get('admin_id');
		$r = array_merge($data, $r);

		return $r;
	}
	//返回模型数据
	public function getMod()
	{
		$modName = ucfirst($this->getData()['name']);
		return ("\app\common\model\\$modName");
	}
	//返回索引字段
	public function getSearch()
	{
		$searchCol = [];
		foreach ($this->cols as $key => $value) {
			if ($value['index']) {
				$searchCol[] = $value;
			}
		}
		return $searchCol;
	}
	//组合搜索条件
	public function keymap($data)
	{
		$map = [];
		$keyboard = isset($data['keyboard']) ? $data['keyboard'] : 0;
		$colname = isset($data['colName']) ? $data['colName'] : 0;
		$enabled = isset($data['enabled']) ? $data['enabled'] : 0;
		if ($enabled) {
			$map[] = ['enabled', '=', $enabled];
		}

		if ($colname) {
			$map[] = [$colname, 'like', "%$keyboard%"];
			return $map;
		}
		$col = [];
		if ($keyboard) {
			$searchCol = $this->getSearch();
			foreach ($searchCol as $key => $value) {
				$col[] = $value['name'];
			}
			$map[] = [implode('|', $col), 'like', "%$keyboard%"];
		}

		return $map;
	}
	//返回审核字段
	public function getEnabled()
	{
		$enabled = [];
		foreach ($this->cols as $key => $value) {
			if ($value['name'] == 'enabled') {
				$enabled = Mclass::where('pid', $value['sval'])->select()->toArray();
				$newEnabled = array_column($enabled, 'id');
				$enabled[$newEnabled[0]] = $newEnabled[1];
				$enabled[$newEnabled[1]] = $newEnabled[0];
				break;
			}
		}
		return $enabled;
	}
}
