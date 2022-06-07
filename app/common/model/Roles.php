<?php
declare (strict_types = 1);
namespace app\common\model;
use think\facade\Session;
use think\Model;

class Roles extends Model {
	//用户信息
	public function admin() {
		$schoolid = Session::get('schoolid');
		return $this->belongsToMany('Admin', 'Access')->where('schoolid', $schoolid);
	}
}