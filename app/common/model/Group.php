<?php
// +----------------------------------------------------------------------
// | 一品内容管理系统 [ YPCMS ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2019 东海县一品网络技术有限公司
// +----------------------------------------------------------------------
// | 官方网站: http://www.yipinjishu.com
// +----------------------------------------------------------------------
declare (strict_types = 1);
namespace app\common\model;
use app\common\model\User;
use think\Model;

//本模型为系统生成,具体功能需要您来配置
class group extends Model {
//您的代码
	public function user() {
		return $this->hasMany(User::class);
	}
	public function buygroup() {
		return $this->hasMany(buygroup::class);
	}

}
?>