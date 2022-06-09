<?php

declare(strict_types=1);

namespace app\common\model;

use think\Model;

class Rule extends Model
{
	protected $auto = ['sid'];

	public static function onAfterInsert($data)
	{
		updateNode(self::select());
	}
	public static function onAfterUpdate($data)
	{
		updateNode(self::select());
	}
	public static function onAfterDelete($data)
	{
		updateNode(self::select());
	}

	//创建节点菜单
	public static function createMenu($data)
	{
		if ($data['node_id'] < 0 || $data['node_id'] == 14) {
			return '';
		}
		$controllerName = ucfirst($data['name']);
		//创建列表
		if ($data['mt'] == 1) {
			$indexName = 'set' . $controllerName;
		} else {
			$indexName = 'index';
		}
		$pid = Rule::insertGetId([
			'pid' => $data['node_id'],
			'title' => $data['alias'] . '列表',
			'sort' => $data['nodesort'],
			'status' => 1,
			'type' => 1,
			'tb_id' => $data['id'],
			'name' => 'admin/' . $controllerName . '/' . $indexName,
		]);
		//创建增删改查
		Rule::create([
			'pid' => $pid,
			'title' => '增加',
			'status' => 0,
			'type' => 1,
			'tb_id' => $data['id'],
			'name' => 'admin/' . $controllerName . '/add',
		]);
		Rule::create([
			'pid' => $pid,
			'title' => '保存',
			'status' => 0,
			'type' => 1,
			'tb_id' => $data['id'],
			'name' => 'admin/' . $controllerName . '/save',
		]);
		Rule::create([
			'pid' => $pid,
			'title' => '编辑',
			'status' => 0,
			'type' => 1,
			'tb_id' => $data['id'],
			'name' => 'admin/' . $controllerName . '/edit',
		]);
		Rule::create([
			'pid' => $pid,
			'title' => '更新',
			'status' => 0,
			'type' => 1,
			'tb_id' => $data['id'],
			'name' => 'admin/' . $controllerName . '/update',
		]);
		Rule::create([
			'pid' => $pid,
			'title' => '删除',
			'status' => 0,
			'type' => 1,
			'tb_id' => $data['id'],
			'name' => 'admin/' . $controllerName . '/delete',
		]);
	}
}
