<?php

/**
 * @Author: Administrator
 * @Date:   2021-08-04 18:59:59
 * @Last Modified by:   Administrator
 * @Last Modified time: 2021-09-04 10:10:18
 * 模型创建类
 */

namespace yp;
use app\common\model\Tb;
use think\facade\Config;
use think\facade\Db;

class Model {
	private $id;
	private $modFile;
	private $controllerFile;
	private $viewPath;
	private $mod;
	private $baseFileName; //基名称
	private $dbname;
	private $tbname;
	public function __construct($id = 0, $data = []) {
		if ($id) {
			$this->mod = Tb::find($id);
		}
		if ($data) {
			$this->mod = $data;
		}
		//基名称首字母大写
		$this->baseFileName = ucfirst($this->mod['name']);
		$this->dbname = Config::get('database.connections.mysql.database');
		$this->tbname = Config::get('database.connections.mysql.prefix') . $this->mod['name'];

	}
//创建数据表
	public function createTable() {
		//表名
		$tbname = $this->tbname;
		//删除存在的数据表
		Db::execute("DROP TABLE IF EXISTS `{$tbname}`;");
		//组建SQL语句
		$createSql = "CREATE TABLE `{$tbname}` (";
		//默认加入ID字段为主键自增
		$createSql .= "`id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',";
		//默认加入删除字段
		$createSql .= "`delete_time` int(10) UNSIGNED NOT NULL COMMENT '删除时间',";
		//索引
		$indexs = [];
		$unique = [];
		$fulltext = [];
		//创建自定义字段
		foreach ($this->mod['cols'] as $key => $value) {
			extract($value);
			switch ($type) {
			case 'INT':
				$createSql .= "`{$name}` {$type}({$size}) SIGNED NOT NULL COMMENT '{$comment}',";
				break;
			case 'FLOAT':
				$createSql .= "`{$name}` {$type}({$size}) SIGNED NOT NULL COMMENT '{$comment}',";
				break;
			case 'VARCHAR':
				$createSql .= "`{$name}` {$type}({$size}) NOT NULL DEFAULT '' COMMENT '{$comment}',";
				break;
			case 'TEXT':
				$createSql .= "`{$name}` {$type}({$size}) NOT NULL DEFAULT '' COMMENT '{$comment}',";
				break;
			case 'MEDIUMTEXT':
				$createSql .= "`{$name}` {$type} NOT NULL DEFAULT '' COMMENT '{$comment}',";
				break;
			case 'JSON':
				$createSql .= "`{$name}` {$type} NOT NULL COMMENT '{$comment}',";
				break;
			default:
				break;
			}
			//索引
			if ($index == 'index') {
				$indexs[] = "`{$name}`";
			}
			//唯一
			if ($index == 'unique') {
				$unique[] = "`{$name}`";
			}
			//全文
			if ($index == 'fulltext') {
				$fulltext[] = "`{$name}`";
			}
		}
		//添加主键
		$createSql .= "PRIMARY KEY (`id`)";
		$alias = $this->mod['alias'];
		//设置编码
		$createSql .= ") ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='{$alias}';";
		//执行
		Db::execute("$createSql");
		//创建索引
		if ($indexs) {
			foreach ($indexs as $key => $value) {
				Db::execute("ALTER TABLE `{$tbname}` ADD INDEX $value ($value);");
			}
		}
		if ($unique) {
			foreach ($unique as $key => $value) {
				Db::execute("ALTER TABLE `{$tbname}` ADD UNIQUE $value ($value);");
			}
		}
		if ($fulltext) {
			foreach ($fulltext as $key => $value) {
				Db::execute("ALTER TABLE `{$tbname}` ADD UNIQUE $value ($value);");
			}
		}
		return true;
	}
	//更新数据表
	public function updateTable() {
		$tbname = $this->tbname;
		$dbname = $this->dbname;
		$r = Tb::find($this->mod['id']);
		$oldCols = $r->cols;
		//表中己有字段
		$oldCols = array_column($oldCols, 'name');
		//当前提交的字段
		$newCols = array_column($this->mod['cols'], 'name');
		//当前提交的原来字段
		$oldData = $this->mod['oldcols'];
		$thisOldCols = [];
		//增加字段|更新字段
		foreach ($this->mod['cols'] as $key => $value) {
			//更新字段名[字段名变化，表单有，表无],针对修改字段名的情况
			if (!in_array($value['name'], $oldCols) && isset($oldData[$key])) {
				self::updateCol($oldData[$key], $value, $tbname);
			}
			//更新[字段名变化，表有，表单无],针对删除字段又重新录入相同字段名
			elseif (in_array($value['name'], $oldCols) && !isset($oldData[$key])) {
				foreach ($r->cols as $k => $v) {
					if ($v['name'] == $value['name']) {
						$thisOldCols = $v;
					}
				}
				self::updateCol($thisOldCols, $value, $tbname);
			}
			//更新[字段信息发生变化],针对修改了字段属性
			elseif (isset($oldData[$key]) && $value != $oldData[$key]) {
				foreach ($r->cols as $k => $v) {
					if ($v['name'] == $value['name']) {
						$thisOldCols = $v;
					}
				}
				self::updateCol($thisOldCols, $value, $tbname);
			}
			//新增[表无，表单无]
			elseif (!in_array($value['name'], $oldCols) && !isset($oldData[$key])) {
				self::addCol($value, $dbname, $tbname);
			}
		}
		//删除字段
		self::removeCol($oldCols, $this->mod, $dbname, $tbname);
	}
	//增加字段
	public static function addCol($value, $dbname, $tbname) {

		$name = $value['name'];
		$query = '';
		$index = '';
		switch ($value['type']) {
		case 'INT':
			$query = "ALTER TABLE {$tbname} ADD `{$value['name']}` {$value['type']}({$value['size']}) SIGNED NOT NULL COMMENT '{$value['comment']}'";
			break;
		case 'FLOAT':
			$query = "ALTER TABLE {$tbname} ADD `{$value['name']}` {$value['type']}({$value['size']}) SIGNED NOT NULL COMMENT '{$value['comment']}'";
			break;
		case 'VARCHAR':
			$query = "ALTER TABLE {$tbname} ADD `{$value['name']}` {$value['type']}({$value['size']}) NOT NULL DEFAULT '' COMMENT '{$value['comment']}'";
			break;
		case 'TEXT':
			$query = "ALTER TABLE {$tbname} ADD `{$value['name']}` {$value['type']}({$value['size']}) NOT NULL DEFAULT '' COMMENT '{$value['comment']}'";
			break;
		case 'MEDIUMTEXT':
			$query = "ALTER TABLE {$tbname} ADD `{$value['name']}` {$value['type']} NOT NULL DEFAULT '' COMMENT '{$value['comment']}'";
			break;
		case 'JSON':
			$query = "ALTER TABLE {$tbname} ADD `{$value['name']}` {$value['type']} NOT NULL COMMENT '{$value['comment']}'";
			break;

		default:
			# code...
			break;
		}

		//索引
		if ($value['index'] == 'index') {
			$index = "ALTER TABLE `{$tbname}` ADD INDEX (`{$value['name']}`);";
		}
		//唯一
		if ($value['index'] == 'unique') {
			$index = "ALTER TABLE `{$tbname}` ADD UNIQUE (`{$value['name']}`);";
		}
		//全文索引
		if ($value['index'] == 'fulltext') {
			$index = "ALTER TABLE `{$tbname}` ADD FULLTEXT (`{$value['name']}`);";
		}

		if (!empty($query)) {
			$sql = "SELECT * FROM information_schema.columns WHERE TABLE_SCHEMA='{$dbname}' AND TABLE_NAME = '{$tbname}' AND COLUMN_NAME = '{$name}'";
			$res = Db::execute($sql);
			if ($res > 0) {
				Db::execute("ALTER TABLE {$tbname} DROP {$name}");
			}
			Db::execute($query);
		}
		//创建索引
		if (!empty($index)) {
			Db::execute($index);
		}
	}
	//更新字段:原字段名，新字段情况，表名
	public static function updateCol($oldData, $value, $tbname) {
		$oldname = $oldData['name'];
		$query = '';
		switch ($value['type']) {
		case 'INT':
			$query = "ALTER TABLE {$tbname} CHANGE `{$oldname}` `{$value['name']}` {$value['type']}({$value['size']}) SIGNED NOT NULL COMMENT '{$value['comment']}'";
			break;
		case 'FLOAT':
			$query = "ALTER TABLE {$tbname} CHANGE `{$oldname}` `{$value['name']}` {$value['type']}({$value['size']}) SIGNED NOT NULL COMMENT '{$value['comment']}'";
			break;
		case 'VARCHAR':
			$query = "ALTER TABLE {$tbname} CHANGE `{$oldname}` `{$value['name']}` {$value['type']}({$value['size']}) NOT NULL DEFAULT '' COMMENT '{$value['comment']}'";
			break;
		case 'TEXT':
			$query = "ALTER TABLE {$tbname} CHANGE `{$oldname}` `{$value['name']}` {$value['type']}({$value['size']}) NOT NULL DEFAULT '' COMMENT '{$value['comment']}'";
			break;
		case 'MEDIUMTEXT':
			$query = "ALTER TABLE {$tbname} CHANGE `{$oldname}` `{$value['name']}` {$value['type']} NOT NULL DEFAULT '' COMMENT '{$value['comment']}'";
			break;
		case 'JSON':
			$query = "ALTER TABLE {$tbname} CHANGE `{$oldname}` `{$value['name']}` {$value['type']} NOT NULL COMMENT '{$value['comment']}'";
			break;
		default:
			# code...
			break;
		}
		if (!empty($query)) {
			Db::execute($query);
		}

		//索引
		if ($value['index'] != $oldData['index']) {

			switch ($value['index']) {
			case 'index':
				$index = "ALTER TABLE `{$tbname}` ADD INDEX(`{$value['name']}`);";
				break;
			case 'unique':
				$index = "ALTER TABLE `{$tbname}` ADD UNIQUE(`{$value['name']}`);";
				break;
			case 'fulltext':
				$index = "ALTER TABLE `{$tbname}` ADD FULLTEXT(`{$value['name']}`);";
				break;
			default:
				$index = '0';
				break;
			}
			//查询己有索引，如果更新时己存在要先删除再添加，因为不能更新修改索引
			$showIndex = "SHOW INDEX FROM `{$tbname}`";
			$indexData = Db::query($showIndex);
			$indexItem = array_column($indexData, 'Column_name');
			//索引字段和索引名是两回事，删除要用索引名
			foreach ($indexData as $key => $v) {
				if ($value['name'] == $v['Column_name']) {
					$keyName = $v['Key_name'];
					$dropIndex = "ALTER TABLE `{$tbname}` DROP INDEX `{$keyName}`;";
					Db::execute($dropIndex);
				}
			}
			if ($index) {
				Db::execute($index);
			}
		}
	}
	//删除字段
	public static function removeCol($oldCols, $data, $dbname, $tbname) {
		//新字段
		$newCols = array_column($data['cols'], 'name');
		foreach ($oldCols as $value) {
			if (!in_array($value, $newCols)) {
				$sql = "SELECT * FROM information_schema.columns WHERE TABLE_SCHEMA='{$dbname}' AND TABLE_NAME = '{$tbname}' AND COLUMN_NAME = '{$value}'";
				$res = Db::execute($sql);
				if ($res > 0) {
					Db::execute("ALTER TABLE {$tbname} DROP {$value}");
				}
			}
		}
	}
	//删除模型
	public function removeMod() {
		//删除数据表
		Db::execute("DROP TABLE {$this->tbname}");
	}
}