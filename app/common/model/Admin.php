<?php

declare(strict_types=1);

namespace app\common\model;

use app\common\model\Roles;
use think\facade\Config;
use think\facade\Session;
use think\Model;

/**
 * 后台管理员模型
 * @package app\admin\model
 */
class Admin extends Model
{


	//数据更新前事件
	public static function onBeforeUpdate($data)
	{
	}

	//数据写入后事件
	public static function onAfterWrite($data)
	{
		if (isset($data['thumb'])) {
			Files::bindInfo($data['thumb']['id'], $data['id'], 0, 'Admin', 'thumb');
		}

		//角色
		if (isset($data['roles_id'])) {
			$data->roles()->detach();
			if ($data['roles_id']) {
				$data->roles()->saveAll($data['roles_id']);
			}
		}
	}

	//数据删除后事件
	public static function onAfterDelete($data)
	{
		//删除角色
		$data->roles()->detach();
	}

	public static function login($data)
	{
		$where[] = ['username', '=', $data['username']];
		$where[] = ['status', '=', 1];
		if ($admin = self::where($where)->find()) {
			if ($admin->password != md5($data['password'] . Config::get('database.salt'))) {
				return 0;
			} else {
				//记录最后登录IP
				$admin->last_ip = $data['ip'];
				$admin->save();
				return $admin->id;
			}
		} else {
			return -1;
		}
	}

	public function getThumbAttr($value, $data)
	{
		return \app\common\model\Files::find($value);
	}
	public function roles()
	{
		return $this->belongsToMany(Roles::class, 'access');
	}

	public static function appendForm($data)
	{
		$item = "";
		//当前管理员能管理的权限

		$roles = Roles::select();
		//用户带有的权限
		$userRoles = [];
		if (isset($data['id'])) {
			$userRoles = array_column($data->roles->toArray(), 'id');
		}

		$checkbox = '';
		foreach ($roles as $v) {
			if (in_array($v->id, $userRoles)) {
				$checkbox .= "<input type=\"checkbox\" name=\"roles_id[]\" value=\"{$v['id']}\" lay-skin=\"primary\" title=\"{$v['title']}\" checked>";
			} else {
				$checkbox .= "<input type=\"checkbox\" name=\"roles_id[]\" value=\"{$v['id']}\" lay-skin=\"primary\" title=\"{$v['title']}\">";
			}
		}
		$item .= "<div class=\"layui-form-item\">
                    <label class=\"layui-form-label\">管理组</label>
                    <div class=\"layui-input-block\">
                    {$checkbox}
                    </div>
                  </div>";
		$arr[0] = $item;
		return $arr;
	}
}
