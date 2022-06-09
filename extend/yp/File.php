<?php

/**
 * @Author: Administrator
 * @Date:   2021-08-04 18:59:59
 * @Last Modified by:   Administrator
 * @Last Modified time: 2021-10-10 11:15:53
 * 文件创建类
 */

namespace yp;

class File
{
	private $id;
	private $mod;
	private $modFile;
	private $controllerFile;
	private $baseFileName;
	public function __construct($data = [])
	{
		$this->mod = $data;
		//基名称首字母大写
		$this->baseFileName = $this->mod['name'];
		$this->Uname = ucfirst($this->baseFileName);
		//模型文件
		$this->modFile = APP_PATH . 'common/model/' . ucfirst($this->baseFileName) . '.php';
		//控制器文件
		$this->controllerFile = APP_PATH . 'admin/controller/' . ucfirst($this->baseFileName) . '.php';
		//模板文件(列表index,查看view,增加编辑from)
		$this->viewPath = APP_PATH . 'admin/view/' . $this->baseFileName;
		$this->indexTemp = $this->viewPath . '/index.html'; //管理列表
		$this->viewTemp = $this->viewPath . '/view.html'; //显示详情
		$this->formTemp = $this->viewPath . '/form.html'; //表单
	}
	//创建模型文件
	public function createModFile()
	{
		if ($this->baseFileName == 'Mclass') {
			return;
		}
		$modFileCode = "<?php\r\n";
		$modFileCode .= "namespace app\common\model;\r\n";
		$modFileCode .= "use think\Model;\r\n";
		$modFileCode .= "//本模型为系统生成\r\n";
		$modFileCode .= "class {$this->Uname} extends Model {\r\n";

		$modFileCode .= "//数据查询后事件\r\n";
		$modFileCode .= "public static function onAfterRead(\$data) {\r\n";
		foreach ($this->mod['cols'] as $key => $value) {
			$modFileCode .= $this->getEvent($value, 'onAfterRead');
		}
		$modFileCode .= "if (class_exists('\user\\$this->Uname')) {
			\$data = app('{$this->Uname}')->onAfterRead(\$data);
		}\n";
		$modFileCode .= "}\r\n";

		$modFileCode .= "//数据写入前事件\r\n";
		$modFileCode .= "public static function onBeforeWrite(\$data) {\r\n";
		foreach ($this->mod['cols'] as $key => $value) {
			$modFileCode .= $this->getEvent($value, 'onBeforeWrite');
		}
		$modFileCode .= "if (class_exists('\user\\$this->Uname')) {
			\$data = app('{$this->Uname}')->onBeforeWrite(\$data);
		}\n";
		$modFileCode .= "}\r\n";
		$modFileCode .= "//数据写入后事件\r\n";
		$modFileCode .= "public static function onAfterWrite(\$data) {\r\n";
		foreach ($this->mod['cols'] as $key => $value) {
			$modFileCode .= $this->getEvent($value, 'onAfterWrite');
		}
		$modFileCode .= "if (class_exists('\user\\$this->Uname')) {
			\$data = app('{$this->Uname}')->onAfterWrite(\$data);
		}\n";

		$modFileCode .= "}\r\n";

		$modFileCode .= "//数据新增前事件\r\n";
		$modFileCode .= "public static function onBeforeInsert(\$data) {\r\n";
		foreach ($this->mod['cols'] as $key => $value) {
			$modFileCode .= $this->getEvent($value, 'onBeforeInsert');
		}
		$modFileCode .= "if (class_exists('\user\\$this->Uname')) {
			\$data = app('{$this->Uname}')->onBeforeInsert(\$data);
		}\n";
		$modFileCode .= "}\r\n";
		$modFileCode .= "//数据新增后事件\r\n";
		$modFileCode .= "public static function onAfterInsert(\$data) {\r\n";
		foreach ($this->mod['cols'] as $key => $value) {
			$modFileCode .= $this->getEvent($value, 'onAfterInsert');
		}
		$modFileCode .= "if (class_exists('\user\\$this->Uname')) {
			\$data = app('{$this->Uname}')->onAfterInsert(\$data);
		}\n";
		$modFileCode .= "}\r\n";

		$modFileCode .= "//数据更新前事件\r\n";
		$modFileCode .= "public static function onBeforeUpdate(\$data) {\r\n";
		foreach ($this->mod['cols'] as $key => $value) {
			$modFileCode .= $this->getEvent($value, 'onBeforeUpdate');
		}
		$modFileCode .= "if (class_exists('\user\\$this->Uname')) {
			\$data = app('{$this->Uname}')->onBeforeUpdate(\$data);
		}\n";
		$modFileCode .= "}\r\n";

		$modFileCode .= "//数据更新后事件\r\n";
		$modFileCode .= "public static function onAfterUpdate(\$data) {\r\n";
		foreach ($this->mod['cols'] as $key => $value) {
			$modFileCode .= $this->getEvent($value, 'onAfterUpdate');
		}
		$modFileCode .= "if (class_exists('\user\\$this->Uname')) {
			\$data = app('{$this->Uname}')->onAfterUpdate(\$data);
		}\n";
		$modFileCode .= "}\r\n";

		$modFileCode .= "//数据恢复前事件\r\n";
		$modFileCode .= "public static function onBeforeRestore(\$data) {\r\n";
		foreach ($this->mod['cols'] as $key => $value) {
			$modFileCode .= $this->getEvent($value, 'onBeforeRestore');
		}
		$modFileCode .= "if (class_exists('\user\\$this->Uname')) {
			\$data = app('{$this->Uname}')->onBeforeRestore(\$data);
		}\n";
		$modFileCode .= "}\r\n";

		$modFileCode .= "//数据恢复后事件\r\n";
		$modFileCode .= "public static function onAfterRestore(\$data) {\r\n";
		foreach ($this->mod['cols'] as $key => $value) {
			$modFileCode .= $this->getEvent($value, 'onAfterRestore');
		}
		$modFileCode .= "if (class_exists('\user\\$this->Uname')) {
			\$data = app('{$this->Uname}')->onAfterRestore(\$data);
		}\n";
		$modFileCode .= "}\r\n";

		$modFileCode .= "//数据删除前事件\r\n";
		$modFileCode .= "public static function onBeforeDelete(\$data) {\r\n";
		foreach ($this->mod['cols'] as $key => $value) {
			$modFileCode .= $this->getEvent($value, 'onBeforeDelete');
		}
		$modFileCode .= "if (class_exists('\user\\$this->Uname')) {
			\$data = app('{$this->Uname}')->onBeforeDelete(\$data);
		}\n";
		$modFileCode .= "}\r\n";

		$modFileCode .= "//数据删除后事件\r\n";
		$modFileCode .= "public static function onAfterDelete(\$data) {\r\n";
		foreach ($this->mod['cols'] as $key => $value) {
			$modFileCode .= $this->getEvent($value, 'onAfterDelete');
		}
		$modFileCode .= "if (class_exists('\user\\$this->Uname')) {
			\$data = app('{$this->Uname}')->onAfterDelete(\$data);
		}\n";
		$modFileCode .= "}\r\n";

		foreach ($this->mod['cols'] as $key => $value) {
			$modFileCode .= $this->getColAttr($value);
		}

		$modFileCode .= "//关联模型{$this->baseFileName}\r\n";
		$modFileCode .= "public function modinfo() {\r\n";
		$modFileCode .= "return \$this->belongsTo(Tb::class);\r\n";
		$modFileCode .= "}\r\n";

		$modFileCode .= "//自定义表单\r\n";
		$modFileCode .= "public static function appendForm(\$data) {\r\n";

		$modFileCode .= "if (class_exists('\user\\$this->Uname')) {
				\$data = app('{$this->Uname}')->appendForm(\$data);
			}\n";

		$modFileCode .= "}\r\n";


		$modFileCode .= "}\r\n?>";
		file_put_contents($this->modFile, $modFileCode);
	}
	//删除模型文件
	public function removeMod()
	{
		if (file_exists($this->modFile)) {
			unlink($this->modFile);
		}
	}
	//设置事件
	public function getEvent($col, $t)
	{
		$attrCode = '';
		switch ($t) {
			case 'onAfterRead':
				//查询后事件
				$attrCode = $this->onAfterRead($col);
				break;
			case 'onBeforeInsert':
				//新增前事件
				$attrCode = $this->onBeforeInsert($col);
				break;
			case 'onAfterInsert':
				//新增后事件
				$attrCode = $this->onAfterInsert($col);
				break;
			case 'onBeforeUpdate':
				//更新前事件
				$attrCode = $this->onBeforeUpdate($col);
				break;
			case 'onAfterUpdate':
				//更新后事件
				$attrCode = $this->onAfterUpdate($col);
				break;
			case 'onBeforeWrite':
				//新增或更新前事件
				$attrCode = $this->onBeforeWrite($col);
				break;
			case 'onAfterWrite':
				//新增或更新后事件
				$attrCode = $this->onAfterWrite($col);
				break;
			case 'onBeforeDelete':
				//删除前事件
				$attrCode = $this->onBeforeDelete($col);
				break;
			case 'onAfterDelete':
				//删除后事件
				$attrCode = $this->onAfterDelete($col);
				break;
			case 'onBeforeRestore':
				//恢复前事件
				$attrCode = $this->onBeforeRestore($col);
				break;
			case 'onAfterRestore':
				//恢复后事件
				$attrCode = $this->onAfterRestore($col);
				break;
		}
		return $attrCode;
	}
	//事件开始
	private function onAfterRead($col)
	{
		$type = $col['formItem'];
		$name = $col['name'];
		return '';
	}
	private function onBeforeInsert($col)
	{
		return '';
	}
	private function onAfterInsert($col)
	{
		$name = ucfirst($col['name']);
		$codeStr = '';
		return $codeStr;
	}
	private function onBeforeUpdate($col)
	{
		$name = ucfirst($col['name']);
		$codeStr = '';
		return $codeStr;
	}
	private function onAfterUpdate($col)
	{
		return '';
	}
	private function onBeforeWrite($col)
	{
		return '';
	}
	private function onAfterWrite($col)
	{

		$name = $col['name'];
		$codeStr = '';
		switch ($col['formItem']) {
				//绑定标题图
			case 'thumb':
				$codeStr = "
				if (isset(\$data['$name'])) {
					Files::bindInfo(\$data['$name']['id'], \$data['id'], \$data['category_id'], '$this->baseFileName', '$name');
				}
			";
				break;
				//绑定相册
			case 'photo':
				$codeStr = "
				if (isset(\$data['$name'])) {
					Files::bindInfo(\$data['{$name}_post'], \$data['id'], \$data['category_id'], '$this->baseFileName', '$name');
				}
			";
				break;
				//绑定附件
			case 'files':
				$codeStr = "
				if (isset(\$data['$name'])) {
					\$ids = array_column(\$data['$name'], 'id');
					Files::bindInfo(\$ids, \$data['id'], \$data['category_id'], '$this->baseFileName', '$name');
				}
			";
				break;
				//编辑器绑定附件
			case 'editor':
				$codeStr = "
				if (isset(\$data['$name'])) {
					Files::bindEditor(\$data['id'], \$data['category_id'], '$this->baseFileName', '$name',\$data['$name']);
				}
			";
				break;
		}

		return $codeStr;
	}
	private function onBeforeDelete($col)
	{
		return '';
	}
	private function onAfterDelete($col)
	{
		return '';
	}
	private function onBeforeRestore($col)
	{
		return '';
	}
	private function onAfterRestore($col)
	{
		return '';
	}
	//事件结束
	//解析特殊字段
	public function getColAttr($col)
	{
		$name = ucfirst($col['name']);
		$comment = $col['comment'];
		$type = $col['formItem'];
		$attrCode = '';
		switch ($type) {
			case 'thumb':
				$attrCode = "
//关联{$comment}单图片
public function get{$name}Attr(\$value, \$data) {
	return \app\common\model\Files::find(\$value);
}
			";
				break;
			case 'photo':
				$attrCode = "
//关联{$comment}相册
	public function get{$name}Attr(\$value, \$data) {
		\$map[] = ['ypcms_id', '=', \$data['id']];
		\$map[] = ['ypcms_type', '=', '{$this->baseFileName}'];
		\$map[] = ['tag', '=', '{$name}'];
		return \app\common\model\Files::where(\$map)->select()->toArray();
	}
			";
				break;
			case 'files':
				$attrCode = "
//关联{$comment}附件
	public function get{$name}Attr(\$value, \$data) {
		return \app\common\model\Files::where('id', 'in', \$value)->select()->toArray();
	}
			";
				break;
			case 'radio':
				$attrCode = "
//关联{$comment}单选
	public function get{$name}Attr(\$value, \$data) {
		return \app\common\model\Mclass::where('id', \$value)->find();
	}
			";
				break;
			case 'select':
				$attrCode = "
//关联{$comment}下拉
	public function get{$name}Attr(\$value, \$data) {
		return \app\common\model\Mclass::where('id', \$value)->find();
	}
			";
				break;

			default:
				//关联字段
				if (strstr($col['name'], '_')) {
					$colArr = explode('_', $col['name']);
					$modName = $colArr[0];
					if ($colArr[1] == 'time') {
						return;
					}
					$bigModName = ucfirst($modName);
					$attrCode = "
//关联{$comment}
	public function {$colArr[0]}() {
		return \$this->belongsTo(\app\common\model\\$bigModName::class);
	}
			";
				}

				break;
		}

		return $attrCode;
	}

	//创建控制器文件
	public function createControllerFile()
	{
		//A类模型控制器
		$modname = ucfirst($this->baseFileName);
		if ($this->mod['mt'] == 1) {
			$modid = $this->mod['id'];
			$controllerFileCode = "<?php
declare (strict_types = 1);
namespace app\\admin\\controller;
use app\\common\model\\{$modname} as {$this->baseFileName}Model;
use app\\common\\model\\Tb;
use think\\facade\\Db;
use think\\facade\\Validate;
use think\\facade\\View;
class {$this->baseFileName} extends Base {
	protected function initialize() {
		parent::initialize();
		\$this->tb = Tb::where('name', '{$this->baseFileName}')->find();
		\$this->cols = \$this->tb->cols;
		\$this->rules = \$this->tb->colrule;
		\$this->table = new {$this->baseFileName}Model();
		\$this->mod = new \\app\\admin\\controller\\Ypmod(\$this->app);

		View::assign('mod', \$this->tb);
	}

	public function set{$this->baseFileName}() {
		\$data = \$this->table->find(1);
		\$form = app('form', ['$modid', \$data]); //表单对象
		View::assign('form', \$form->getForm());
		return view('form');
	}

	public function save() {
		if (\$this->request->isPost()) {
			\$data=\$this->request->param();
			\$data = \$this->tb->saveData(\$data); //组合字段内容
			//验证规则
			\$colrule = array_column(Db::name('colrule')->select()->toArray(), null, 'id');
			//获取单列
			\$cols = array_column(\$this->cols, null, 'name');
			//表单验证
			if (empty(\$this->rules)) {
				\$this->error('缺少验证规则，至少要有一个必填项！');
			} else {
				foreach (\$this->rules as \$key => \$value) {
					\$ruleStr = [];
					foreach (\$value as \$k => \$v) {
						\$ruleStr[] = \$colrule[\$v]['rule'];
					}
					\$rules[\$key] = implode('\|', \$ruleStr);
				}
				foreach (\$this->rules as \$key => \$value) {
					foreach (\$value as \$k => \$v) {
						\$msgs[\$key . '.' . \$colrule[\$v]['rule']] = str_replace(\"{col}\", \$cols[\$key]['comment'], \$colrule[\$v]['msg']);
					}
				}
				\$validate = Validate::rule(\$rules)->message(\$msgs);
				if (!\$validate->check(\$data)) {
					\$this->error(\$validate->getError());
				} else {
					//保存信息
					if (\$this->table->save(\$data)) {
						\$this->success('保存成功', (string) url('set{$this->baseFileName}'));
					} else {
						\$this->error('保存失败');
					}
				}
			}
		}
	}

	public function update() {
		\$data = \$this->tb->saveData(\$this->request->param()); //组合字段内容
		//验证规则
		\$colrule = array_column(Db::name('colrule')->select()->toArray(), null, 'id');
		//获取单列
		\$cols = array_column(\$this->cols, null, 'name');
		//表单验证
		foreach (\$this->rules as \$key => \$value) {
			\$ruleStr = [];
			foreach (\$value as \$k => \$v) {
				\$ruleStr[] = \$colrule[\$v]['rule'];
			}
			\$rules[\$key] = implode('|', \$ruleStr);
		}
		foreach (\$this->rules as \$key => \$value) {
			foreach (\$value as \$k => \$v) {
				\$msgs[\$key . '.' . \$colrule[\$v]['rule']] = str_replace(\"{col}\", \$cols[\$key]['comment'], \$colrule[\$v]['msg']);
			}
		}
		\$validate = Validate::rule(\$rules)->message(\$msgs);
		if (!\$validate->check(\$data)) {
			\$this->error(\$validate->getError());
		} else {
			//保存信息
			if (\$this->table::update(\$data)) {
				\$this->success('更新成功', (string) url('set{$this->baseFileName}'));
			} else {
				\$this->error('更新失败');
			}
		}
	}
}
?>";
		} else {
			//B类模型控制器
			$controllerFileCode = "<?php
declare (strict_types = 1);
namespace app\\admin\\controller;
use app\\common\model\\{$modname} as {$this->baseFileName}Model;
use app\\common\\model\\Tb;
use think\\facade\\Db;
use think\\facade\\Validate;
use think\\facade\\View;
class {$this->baseFileName} extends Base {
	protected function initialize() {
		parent::initialize();
		\$this->tb = Tb::where('name', '{$this->baseFileName}')->find();
		\$this->cols = \$this->tb->cols;
		\$this->rules = \$this->tb->colrule;
		\$this->table = new {$this->baseFileName}Model();
		\$this->ypmod = new \\app\\admin\\controller\\Ypmod(\$this->app);
		//是否支持搜索
		\$searchCol = \$this->tb->getSearch();
		//是否有审核
		\$this->enabled = \$this->tb->getEnabled();
		View::assign('listv', \$this->tb->listv());
		View::assign('colspan', count(\$this->tb->listv()) + 2);
		View::assign('searchCol', \$searchCol);
		View::assign('enabled', \$this->enabled);
		View::assign('mod', \$this->tb);
	}

	public function index(\$page = 1, \$keyboard = '', \$limit = 15) {
		\$map = \$this->tb->keymap(\$this->request->param());
		\$dataList = \$this->table->where(\$map)->paginate(\$limit, false, ['page' => \$page]);
		View::assign('dataList', \$dataList);
		View::assign('count', \$dataList->total());
		return view('');
	}

	public function add() {
		\$form = app('form', [\$this->tb->id]); //表单对象
		View::assign('form', \$form->getForm());
		return view('form');
	}

	public function save() {
		if (\$this->request->isPost()) {
			\$data=\$this->request->param();
			\$data = \$this->tb->saveData(\$data); //组合字段内容
			//验证规则
			\$colrule = array_column(Db::name('colrule')->select()->toArray(), null, 'id');
			//获取单列
			\$cols = array_column(\$this->cols, null, 'name');
			//表单验证
			if (empty(\$this->rules)) {
				\$this->error('缺少验证规则，至少要有一个必填项！');
			} else {
				foreach (\$this->rules as \$key => \$value) {
					\$ruleStr = [];
					foreach (\$value as \$k => \$v) {
						\$ruleStr[] = \$colrule[\$v]['rule'];
					}
					\$rules[\$key] = implode('\|', \$ruleStr);
				}
				foreach (\$this->rules as \$key => \$value) {
					foreach (\$value as \$k => \$v) {
						\$msgs[\$key . '.' . \$colrule[\$v]['rule']] = str_replace(\"{col}\", \$cols[\$key]['comment'], \$colrule[\$v]['msg']);
					}
				}
				\$validate = Validate::rule(\$rules)->message(\$msgs);
				if (!\$validate->check(\$data)) {
					\$this->error(\$validate->getError());
				} else {
					//保存信息
					if (\$this->table->save(\$data)) {
						\$this->success('保存成功', (string) url('index'));
					} else {
						\$this->error('保存失败');
					}
				}
			}
		}
	}
	public function edit(\$id) {
		\$r = \$this->table::find(\$id); //查询数据
		\$r = \$this->tb->editData(\$r); //组合字段内容
		\$form = app('form', [\$this->tb->id,\$r]); //表单对象
		View::assign('form', \$form->getForm());
		View::assign('r', \$r);
		return view('form');
	}
	public function update(\$id=0) {
		if (\$this->request->isPost()) {
			\$data = \$this->tb->saveData(\$this->request->param()); //组合字段内容
			//验证规则
			\$colrule = array_column(Db::name('colrule')->select()->toArray(), null, 'id');
			//获取单列
			\$cols = array_column(\$this->cols, null, 'name');
			//表单验证
			foreach (\$this->rules as \$key => \$value) {
				\$ruleStr = [];
				foreach (\$value as \$k => \$v) {
					\$ruleStr[] = \$colrule[\$v]['rule'];
				}
				\$rules[\$key] = implode('\|', \$ruleStr);
			}
			foreach (\$this->rules as \$key => \$value) {
				foreach (\$value as \$k => \$v) {
					\$msgs[\$key . '.' . \$colrule[\$v]['rule']] = str_replace(\"{col}\", \$cols[\$key]['comment'], \$colrule[\$v]['msg']);
				}
			}
			\$validate = Validate::rule(\$rules)->message(\$msgs);
			if (!\$validate->check(\$data)) {
				\$this->error(\$validate->getError());
			} else {
				if (\$this->table::update(\$data)) {
					\$this->success('更新成功', (string) url('index'));
				} else {
					\$this->error('更新失败');
				}
			}

		}
	}
	public function delete(\$id) {
		if (is_array(\$id)) {
			\$id = array_map('intval', \$id);
		}
		if (\$id) {
			if (\$this->table->destroy(\$id)) {
				\$this->success('删除成功');
			} else {
				\$this->error('删除失败');
			}
		} else {
			\$this->error('请选择需要删除的条目');
		}
	}
}
?>";
		}
		file_put_contents($this->controllerFile, $controllerFileCode);
	}

	//删除控制器文件
	public function removeControllerFile()
	{
		if (file_exists($this->controllerFile)) {
			unlink($this->controllerFile);
		}
	}

	//创建模板文件
	public function createView()
	{
		if ($this->mod['menu'] == 1) {
			$indexTemp = file_get_contents(APP_PATH . 'admin/view/public/indexTemp.html');
		} else {
			$indexTemp = file_get_contents(APP_PATH . 'admin/view/public/indexTemp2.html');
		}

		$viewTemp = file_get_contents(APP_PATH . 'admin/view/public/viewTemp.html');
		$formTemp = file_get_contents(APP_PATH . 'admin/view/public/formTemp.html');
		$ckeditor = ''; //编辑器
		foreach ($this->mod['cols'] as $key => $value) {
			$type = $value['formItem'];
			//加载编辑器配置文件
			if ($value['formItem'] == 'editor') {
				$ckeditor .= '
    $(function() {
        CKEDITOR.replace(\'' . $value['name'] . '\',{
            customConfig : \'__STATIC__/src/ckeditor/ypconfig.js?v={:time()}\'
        });
    });
';
			}
		}
		$formTemp .= '{block name="script"}<script>' . $ckeditor . '</script>{/block}';
		MkDirs($this->viewPath, 0755, true);
		if ($this->mod['mt'] == 1) {
			file_put_contents($this->formTemp, $formTemp);
		} else {
			file_put_contents($this->indexTemp, $indexTemp);
			file_put_contents($this->viewTemp, $viewTemp);
			file_put_contents($this->formTemp, $formTemp);
		}
	}
	//删除模板文件
	public function removeViewFile()
	{
		removeDir($this->viewPath, true);
	}
}
