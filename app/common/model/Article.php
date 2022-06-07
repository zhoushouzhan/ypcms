<?php
namespace app\common\model;
use think\Model;
//本模型为系统生成
class Article extends Model {
//数据查询后事件
public static function onAfterRead($data) {
if (class_exists('\user\Article')) {
			$data = app('Article')->onAfterRead($data);
		}
}
//数据写入前事件
public static function onBeforeWrite($data) {
if (class_exists('\user\Article')) {
			$data = app('Article')->onBeforeWrite($data);
		}
}
//数据写入后事件
public static function onAfterWrite($data) {

				if (isset($data['thumb'])) {
					Files::bindInfo($data['thumb']['id'], $data['id'], $data['category_id'], 'article', 'thumb');
				}
			
				if (isset($data['content'])) {
					Files::bindEditor($data['id'], $data['category_id'], 'article', 'content',$data['content']);
				}
			if (class_exists('\user\Article')) {
			$data = app('Article')->onAfterWrite($data);
		}
}
//数据新增前事件
public static function onBeforeInsert($data) {
if (class_exists('\user\Article')) {
			$data = app('Article')->onBeforeInsert($data);
		}
}
//数据新增后事件
public static function onAfterInsert($data) {
if (class_exists('\user\Article')) {
			$data = app('Article')->onAfterInsert($data);
		}
}
//数据更新前事件
public static function onBeforeUpdate($data) {
if (class_exists('\user\Article')) {
			$data = app('Article')->onBeforeUpdate($data);
		}
}
//数据更新后事件
public static function onAfterUpdate($data) {
if (class_exists('\user\Article')) {
			$data = app('Article')->onAfterUpdate($data);
		}
}
//数据恢复前事件
public static function onBeforeRestore($data) {
if (class_exists('\user\Article')) {
			$data = app('Article')->onBeforeRestore($data);
		}
}
//数据恢复后事件
public static function onAfterRestore($data) {
if (class_exists('\user\Article')) {
			$data = app('Article')->onAfterRestore($data);
		}
}
//数据删除前事件
public static function onBeforeDelete($data) {
if (class_exists('\user\Article')) {
			$data = app('Article')->onBeforeDelete($data);
		}
}
//数据删除后事件
public static function onAfterDelete($data) {
if (class_exists('\user\Article')) {
			$data = app('Article')->onAfterDelete($data);
		}
}

//关联栏目
	public function category() {
		return $this->belongsTo(\app\common\model\Category::class);
	}
			
//关联管理员
	public function admin() {
		return $this->belongsTo(\app\common\model\Admin::class);
	}
			
//关联会员
	public function user() {
		return $this->belongsTo(\app\common\model\User::class);
	}
			
//关联图片单图片
public function getThumbAttr($value, $data) {
	return \app\common\model\Files::find($value);
}
			
//关联审核单选
	public function getEnabledAttr($value, $data) {
		return \app\common\model\Mclass::where('id', $value)->find();
	}
			
//关联推荐下拉
	public function getRecommendAttr($value, $data) {
		return \app\common\model\Mclass::where('id', $value)->find();
	}
			//关联模型article
public function modinfo() {
return $this->belongsTo(Tb::class);
}
//自定义表单
public static function appendForm($data) {
if (class_exists('\user\Article')) {
				$data = app('Article')->appendForm($data);
			}
}
}
?>