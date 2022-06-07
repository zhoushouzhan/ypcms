<?php
// +----------------------------------------------------------------------
// | 一品内容管理系统 [ YPCMS ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2019 东海县一品网络技术有限公司
// +----------------------------------------------------------------------
// | 官方网站: http://www.yipinjishu.com
// +----------------------------------------------------------------------
declare(strict_types=1);

namespace app\common\model;

use think\Model;

//本模型为系统生成,具体功能需要您来配置
class user extends Model
{
	//关联头像
	public function fileUserpic()
	{
		return $this->hasOne(Files::class)->where('tag', 'userpic');
	}
	//用户组
	public function group()
	{
		return $this->belongsTo(Group::class);
	}

	//收藏夹
	public function favorites()
	{
		return $this->morphMany(Favorites::class, 'ypcms', 'Article');
	}
	//订单
	public function order()
	{
		return $this->morphMany(Order::class);
	}
}
