<?php
namespace app\common\model;
use think\Model;
//本模型为系统生成
class Tags extends Model {
//数据查询后事件
public static function onAfterRead($data) {
}
//数据写入前事件
public static function onBeforeWrite($data) {
}
//数据写入后事件
public static function onAfterWrite($data) {

				if (isset($data['thumb'])) {
					Files::bindInfo($data['thumb']['id'], $data['id'], $data['category_id'], 'Tags', 'thumb');
				}
			}
//数据新增前事件
public static function onBeforeInsert($data) {
}
//数据新增后事件
public static function onAfterInsert($data) {
}
//数据更新前事件
public static function onBeforeUpdate($data) {
}
//数据更新后事件
public static function onAfterUpdate($data) {
}
//数据恢复前事件
public static function onBeforeRestore($data) {
}
//数据恢复后事件
public static function onAfterRestore($data) {
}
//数据删除前事件
public static function onBeforeDelete($data) {
}
//数据删除后事件
public static function onAfterDelete($data) {
}

//关联图标单图片
public function getThumbAttr($value, $data) {
	return \app\common\model\Files::find($value);
}
			//关联模型Tags
public function modinfo() {
return $this->belongsTo(Tb::class);
}
}
?>