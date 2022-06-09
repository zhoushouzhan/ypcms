<?php

declare(strict_types=1);

namespace app\index\controller;

use app\common\model\Category as CategoryMode;
use think\facade\Cache;
use think\facade\Db;
use think\facade\View;

class Content extends Base
{
	protected function initialize()
	{
		parent::initialize();
		$this->categoryId = $this->request->param('categoryId/d');
		//栏目信息
		$this->category = CategoryMode::find($this->categoryId);
		$this->modName = ucfirst($this->category->modinfo->name);
		$modelName = "\app\common\model\\$this->modName";
		$this->table = new $modelName;
		View::assign('category', $this->category);
		View::assign('pagetitle', $this->category->name);
	}
	public function index($id)
	{
		$r = $this->table::where("create_time|id", $id)->find();
		$r->inc('hits')->update();

		$next_r = $this->table::where('id', '<', $id)->where('category_id', $this->categoryId)->find();
		$pre_r = $this->table::where('id', '>', $id)->where('category_id', $this->categoryId)->find();
		if ($next_r) {
			$url = url('index/article/read', ['cid' => $next_r->category_id, 'id' => $next_r->id]);
			$title = $next_r->title;
			$next = "<a href=\"{$url}\">{$title}</a>";
		} else {
			$next = '<span>暂无</span>';
		}
		if ($pre_r) {
			$url = url('index/article/read', ['cid' => $pre_r->category_id, 'id' => $pre_r->id]);
			$title = $pre_r->title;
			$pre = "<a href=\"{$url}\">{$title}</a>";
		} else {
			$pre = '<span>暂无</span>';
		}


		View::assign('r', $r);
		View::assign('pre', $pre);
		View::assign('next', $next);
		//模板
		$template = $this->category->modinfo->name . '/content';
		return View($template);
	}
}
