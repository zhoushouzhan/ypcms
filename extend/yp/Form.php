<?php

/**
 * @Author: Administrator
 * @Date:   2021-08-04 18:59:59
 * @Last Modified by:   Administrator
 * @Last Modified time: 2021-10-13 14:44:47
 * 表单创建类
 */

namespace yp;

use app\common\model\Mclass;
use app\common\model\Tb;

class Form
{
	private $mod;
	private $data;
	public function __construct($id, $data = [])
	{
		$this->mod = Tb::find($id);
		$this->data = $data;
	}
	//创建表单
	public function getForm()
	{
		//提交地址:保存/更新
		$actionUrl = isset($this->data['id']) ? (string) url('update') : (string) url('save');
		//标签组
		$colGroups = $this->mod->col_groups;
		//字段
		foreach ($colGroups as $k => $v) {
			$colGroupsItem[$k] = '';
		}

		foreach ($this->mod->cols as $key => $value) {
			if (isset($this->data['hidden']) && in_array($value['name'], $this->data['hidden'])) {
				continue;
			}
			if (!isset($value['group'])) {
				continue;
			}
			//非表单元素跳过
			if ($value['formItem'] == 'none') {
				continue;
			}
			//组内字段生成表单
			$colGroupsItem[$value['group']] .= $this->getCol($value, $this->mod->colrule, $this->data);
		}
		//组建表单
		$formTab = "<form class=\"layui-form form-container\" action=\"{$actionUrl}\" method=\"post\">";
		//更新条件字段
		if (isset($this->data->id)) {
			$formTab .= "<input type=\"hidden\" name=\"id\" value=\"{$this->data->id}\">";
		}
		$formTab .= "<input type=\"hidden\" name=\"modId\" value=\"{$this->mod->id}\">";
		$formTab .= '<div class="layui-tab layui-tab-brief" lay-filter="' . $this->mod->name . '">';
		$formTab .= '<ul class="layui-tab-title">';
		//表单组
		foreach ($colGroups as $no => $name) {
			$class = $no ? '' : ' class="layui-this"';
			$formTab .= '<li' . $class . '>' . $name . '</li>';
		}
		$formTab .= '</ul>';
		$formTab .= '<div class="layui-tab-content">';
		//自定义表单项目
		$appendForm = [];
		if (method_exists($this->mod->getMod(), 'appendForm')) {
			$appendForm = $this->mod->getMod()::appendForm($this->data);
		}

		//字段分组
		foreach ($colGroups as $key => $value) {
			$show = $key ? '' : ' layui-show';



			$colGroupsItem[$key] = $colGroupsItem[$key] . (isset($appendForm[$key]) ? $appendForm[$key] : ''); //附上自定义表单
			$formTab .= '<div class="layui-tab-item' . $show . '">' . $colGroupsItem[$key] . '</div>';
		}
		$formTab .= "</div></div>";
		//编辑器属性
		$editrupdate = '';
		if (strstr($formTab, 'ypcms-editor')) {
			$editrupdate = ' onclick="CKupdate();"';
		}

		$formTab .= "<div class=\"layui-form-item\">";
		$formTab .= "<div class=\"layui-input-block\">";
		$formTab .= "<button class=\"layui-btn layui-btn-danger\" lay-submit lay-filter=\"{$this->mod->name}\"{$editrupdate}>提交</button>";
		$formTab .= "<button type=\"reset\" class=\"layui-btn layui-btn-primary\">重置</button>";
		$formTab .= "</div></div></form>";

		return $formTab;
	}
	//获取表单项目
	private function getCol($col, $rules, $data)
	{
		$name = $col['name'];
		//表单元素
		$item = '';
		//表单类型
		$type = $col['formItem'];
		//编辑器
		$editor = '';
		//必填项
		$required = '';
		//表格
		$trlist = '';
		$placeholder = '';
		//必填项
		if (isset($rules) && in_array('1', $rules)) {
			$required = " lay-verify=\"required\"";
		}
		//表单初始值
		$value = $col['sval'];



		//己赋值特殊字段处理
		if (isset($data[$col['name']])) {
			switch ($type) {
					//处理附件集
				case 'files':
					$value = $data->$name;
					foreach ($value as $key => $vo) {
						$key++;
						$trlist .= "<tr>
                        <td>{$key}<input type=\"hidden\" name=\"{$col['name']}[]\" value=\"{$vo['id']}\"></td>
                        <td>{$vo['name']}</td>
                        <td><a href=\"{$vo['filepath']}\" target=\"_blank\"><i class=\"fa fa-cloud-download\" aria-hidden=\"true\"></i></a></td>
                        <td><div class=\"fileDel layui-btn layui-btn-danger\" type=\"2\" oldFileId=\"{$vo['id']}\"><i class=\"layui-icon\">&#x1007;</i>移除</div></td>
                    </tr>";
					}
					break;
					//处理相册
				case 'photo':
					$value = $data->$name;
					if (!$value) {
						break;
					}
					$trlist = '';
					foreach ($value as $key => $vo) {
						$key++;
						$trlist .= "<div class=\"layui-col-md2\">
                        <div class=\"fileItem\">
                        <input type=\"hidden\" name=\"{$col['name']}[]\" value=\"{$vo['id']}\">
                        <img src=\"{$vo['filepath']}\" />
                        <div class=\"fileName\">{$vo['name']}</div>
                        <div class=\"fileDel layui-btn layui-btn-danger layui-btn-xs\" type=\"1\" oldFileId=\"{$vo['id']}\">取消</div>
                        </div>
                        </div>";
					}
					break;
				default:
					$value = $data[$col['name']];
					break;
			}
		}

		//字段HTML
		switch ($type) {
			case 'input':
				$item = "<div class=\"layui-form-item\">
                    <label class=\"layui-form-label\">{$col['comment']}</label>
                    <div class=\"layui-input-block\">
                      <input type=\"text\" name=\"{$col['name']}\"{$required} class=\"layui-input\" value=\"{$value}\">
                    </div>
                  </div>";
				break;
			case 'hidden':
				if (is_array($value)) {
					$value = '';
				}

				$item = "<input type=\"hidden\" name=\"{$col['name']}\" value=\"{$value}\">";

				break;

			case 'password':
				$placeholder = 'placeholder="请填写密码"';
				if ($value) {
					$placeholder = 'placeholder="不改密码请留空"';
				}

				$item = "<div class=\"layui-form-item\">
                    <label class=\"layui-form-label\">{$col['comment']}</label>
                    <div class=\"layui-input-block\">
                      <input type=\"password\" name=\"{$col['name']}\"{$required} class=\"layui-input\" {$placeholder} value=\"\">
                    </div>
                  </div>";
				$item .= "<div class=\"layui-form-item\">
                    <label class=\"layui-form-label\">确认密码</label>
                    <div class=\"layui-input-block\">
                      <input type=\"password\" name=\"confirm_password\"{$required} class=\"layui-input\"  {$placeholder} value=\"\">
                    </div>
                  </div>";

				break;
			case 'date':
				$item = "<div class=\"layui-form-item\">
                    <label class=\"layui-form-label\">{$col['comment']}</label>
                    <div class=\"layui-input-block\">
                      <input type=\"text\" name=\"{$col['name']}\"{$required}  autocomplete=\"off\" class=\"layui-input ypcms-date\" value=\"{$value}\">
                    </div>
                  </div>";
				break;
			case 'datetime':
				$item = "<div class=\"layui-form-item\">
                    <label class=\"layui-form-label\">{$col['comment']}</label>
                    <div class=\"layui-input-block\">
                      <input type=\"text\" name=\"{$col['name']}\"{$required} class=\"layui-input datetime\" value=\"{$value}\">
                    </div>
                  </div>";
				break;

			case 'select':
				$selectedId = isset($value->id) ? $value->id : 0;
				$tree = Mclass::getSelected($selectedId, $col['sval']);
				$selects = '';
				foreach ($tree as $k => $vas) {
					$option = "<option value=\"\"></option>";
					foreach ($vas as $v) {
						if ($v['current'] == 1) {
							$option .= "<option value=\"{$v['id']}\" data-preid=\"{$col['name']}\" selected>{$v['title']}</option>";
						} else {
							$option .= "<option value=\"{$v['id']}\" data-preid=\"{$col['name']}\">{$v['title']}</option>";
						}
					}
					$selects .= "<div class=\"layui-input-inline {$col['name']}\">
                        <select lay-filter=\"mclass\">{$option}</select>
                    </div>";
				}
				$item = "<div class=\"layui-form-item\">
                    <input type=\"hidden\" name=\"{$col['name']}\" value=\"{$selectedId}\" id=\"{$col['name']}\">
                    <label class=\"layui-form-label\">{$col['comment']}</label>
                    {$selects}
                  </div>";

				break;
			case 'textarea':
				$item = "<div class=\"layui-form-item\">
                    <label class=\"layui-form-label\">{$col['comment']}</label>
                    <div class=\"layui-input-block\">
                        <textarea name=\"{$col['name']}\"{$required} placeholder=\"请输入内容\" class=\"layui-textarea\">{$value}</textarea>
                    </div>
                  </div>";
				break;
			case 'editor':
				$item = "<div class=\"layui-form-item\">
                    <label class=\"layui-form-label\">{$col['comment']}</label>
                    <div class=\"layui-input-block\">
                        <textarea name=\"{$col['name']}\"{$required} placeholder=\"请输入内容\" class=\"layui-textarea ypcms-editor\">{$value}</textarea>
                    </div>
                  </div>";
				break;
			case 'radio':
				$mclass_data = Mclass::where('pid', $col['sval'])->select()->toArray();
				$radio = '';
				//设置禁用项
				$disabledItem = [];
				if (isset($data[$col['name']]['disabled'])) {
					$disabledItem = $data[$col['name']]['disabled'];
				}
				foreach ($mclass_data as $v) {
					$checkedId = isset($value->id) ? $value->id : 0;
					$disabled = '';
					if (in_array($v['id'], $disabledItem)) {
						$disabled = ' disabled';
					}
					if ($v['id'] == $checkedId) {
						$radio .= "<input type=\"radio\" name=\"{$col['name']}\" value=\"{$v['id']}\" title=\"{$v['title']}\" lay-filter=\"{$col['name']}\" checked{$disabled}>";
					} else {
						$radio .= "<input type=\"radio\" name=\"{$col['name']}\" value=\"{$v['id']}\" title=\"{$v['title']}\" lay-filter=\"{$col['name']}\"{$disabled}>";
					}
				}
				$item = "<div class=\"layui-form-item\" id=\"{$col['name']}Item\">
                    <label class=\"layui-form-label\">{$col['comment']}</label>
                    <div class=\"layui-input-block\">
                    	{$radio}
                    </div>
                  </div>";
				break;
			case 'checkbox':
				$mclass_data = Mclass::where('pid', $col['sval'])->select()->toArray();
				$checkbox = '';
				$mclass_id = [];
				if ($value) {
					$mclass_id = $value->column('id');
				}
				foreach ($mclass_data as $v) {
					if (in_array($v['id'], $mclass_id)) {
						$checkbox .= "<input type=\"checkbox\" name=\"{$col['name']}[]\" value=\"{$v['id']}\" title=\"{$v['title']}\" checked>";
					} else {
						$checkbox .= "<input type=\"checkbox\" name=\"{$col['name']}[]\" value=\"{$v['id']}\" title=\"{$v['title']}\">";
					}
				}
				$item = "<div class=\"layui-form-item\">
                    <label class=\"layui-form-label\">{$col['comment']}</label>
                    <div class=\"layui-input-block\">
                        {$checkbox}
                    </div>
                  </div>";
				break;
			case 'thumb':
				$fileid = 0;
				if (empty($value)) {
					$thumbsrc = '/static/admin/images/default_thumb.png';
				} else {
					$thumbsrc = $value->filepath;
					$fileid = $value->id;
				}
				$item = "<div class=\"layui-form-item\">
                    <label class=\"layui-form-label\">{$col['comment']}</label>
                        <div class=\"layui-input-block\">
                           <div class=\"layui-upload-list\">
                            <input type=\"hidden\" name=\"{$col['name']}\" value=\"{$fileid}\" id=\"{$col['name']}\">
                            <img class=\"layui-upload-img\" id=\"thumb{$col['name']}\" src=\"{$thumbsrc}\">
                            <p class=\"thumblog layui-btn layui-btn-sm fileCenterSelect\" ftype=\"image\" ftitle=\"选择缩略图\" fx=\"thumb{$col['name']}\" fname=\"{$col['name']}\" addType=\"s\" oldFileId=\"\">点击上传</p>
                          </div>
                        </div>
                  </div>";
				break;
			case 'photo':
				$item = "<div class=\"layui-form-item\">
                        <label class=\"layui-form-label\">{$col['comment']}</label>
                        <div class=\"layui-input-block\">
                            <button type=\"button\" class=\"layui-btn fileCenterSelect\" ftype=\"image\" ftitle=\"选择图片\" fx=\"{$col['name']}Item\" fname=\"{$col['name']}\" addType=\"m\">上传图集</button>
                            <div class=\"layui-row layui-col-space10\" id=\"{$col['name']}Item\">{$trlist}</div>
                        </div>
                    </div>";
				break;
			case 'files':
				$item = "<div class=\"layui-form-item\">
                    <label class=\"layui-form-label\">{$col['comment']}</label>
                        <div class=\"layui-input-block\">
                            <button type=\"button\" class=\"layui-btn layui-btn-danger fileCenterSelect\" ftype=\"application\" ftitle=\"选择附件\" fx=\"file-container\" fname=\"{$col['name']}\" addType=\"m\">上传附件</button>
                            <div class=\"file-container\">
                                <table class=\"layui-table\">
                                  <colgroup>
                                    <col width=\"60\">
                                    <col>
                                    <col width=\"60\">
                                    <col width=\"80\">
                                  </colgroup>
                                  <thead>
                                    <tr>
                                        <th>序号</th>
                                        <th>名称</th>
                                        <th>链接</th>
                                        <th>操作</th>
                                    </tr>
                                  </thead>
                                  <tbody id=\"file-container\">{$trlist}</tbody>
                                </table>
                            </div>
                        </div>
                  </div>";
				break;
			case 'switch':
				$checked = $value ? ' checked' : '';
				$item = "<div class=\"layui-form-item\">
                    <label class=\"layui-form-label\">{$col['comment']}</label>
                    <div class=\"layui-input-block\">
                    <input type=\"hidden\" name=\"{$col['name']}\" value=\"0\">
                    <input type=\"checkbox\" name=\"{$col['name']}\" value=\"1\" lay-text=\"开启|关闭\" lay-skin=\"switch\"{$checked}></div>
                  </div>";
				break;
			case 'icon':
				$checked = $value ? ' checked' : '';
				$item = "<div class=\"layui-form-item\">
                    <label class=\"layui-form-label\">{$col['comment']}</label>
                    <div class=\"layui-input-inline\"><input type=\"text\" name=\"{$col['name']}\"{$required} class=\"layui-input\" value=\"{$value}\" id=\"{$col['name']}\"></div>
                    <div class=\"layui-input-inline\"><button type=\"button\" class=\"layui-btn layui-btn-primary\" id=\"selectIcon\"><i class=\"layui-icon\">&#xe66b;</i></button></div>
                  </div>";
				break;
				//绑定模型:只选择对应模型单字段
			case 'ypmod':
				$nameArr = explode("_", $col['name']);
				$thismod = Tb::where('name', $nameArr[0])->find();
				$map = [];
				if (isset($this->data['map'][$nameArr[0]])) {
					$map[] = $this->data['map'][$nameArr[0]];
				}

				$mods = $thismod->getMod()::where($map)->select();
				$selects = '';
				$option = "<option value=\"0\">请选择</option>";
				foreach ($mods as $v) {
					if ($value == $v['id']) {
						$option .= "<option value=\"{$v['id']}\" selected>{$v['alias']}</option>";
					} else {
						$option .= "<option value=\"{$v['id']}\">{$v['alias']}</option>";
					}
				}
				$selects = "<div class=\"layui-input-inline\" id=\"hasmod\">
                    <select name=\"{$col['name']}\" lay-filter=\"hasmod\">{$option}</select>
                </div>";
				$item = "<div class=\"layui-form-item\">
                    <label class=\"layui-form-label\">{$col['comment']}</label>
                    {$selects}
                  </div>";
				break;
				//绑定模型:可操作绑定的模型数据
			case 'ypmodb':
				$nameArr = explode("_", $col['name']);
				$thismod = Tb::where('name', $nameArr[0])->find();
				$listv = $thismod->listv();
				//表头
				$th = "";
				foreach ($listv as $key => $vo) {
					$th .= "<th>{$vo['comment']}</th>";
				}
				//数据
				$td = "";
				$tr = "";
				$colw = "";
				foreach ($listv as $key => $value) {
					$colw .= "<col width=\"{$value['colw']}\">";
				}
				if (isset($data['id'])) {
					$dataList = $data[$nameArr[0]];
					foreach ($dataList as $k => $v) {
						$td = "";
						foreach ($listv as $key => $value) {
							$td .= "<td>{$v[$value['name']]}</td>";
						}
						$tr .= "<tr data-val=\"{$v}\">{$td}</tr>";
					}
				}
				$item = "<div class=\"layui-form-item\">
                    <label class=\"layui-form-label\">{$col['comment']}</label>
                    <div class=\"layui-input-block\">

<table class=\"layui-table dataTable\" data-mod='{$thismod}'>
                <colgroup>
                	{$colw}
                    <col width=\"110\">
                </colgroup>
  <thead>
    <tr>{$th}</tr>
  </thead>
  <tbody>{$tr}</tbody>
</table>
                	</div>
                  </div>";
				break;

			case 'yesno':
				$no = $yes = '';
				if ($value == 1) {
					$yes = "checked";
				} else {
					$no = "checked";
				}

				$radio = "<input type=\"radio\" name=\"{$col['name']}\" value=\"1\" title=\"是\"{$yes}>";
				$radio .= "<input type=\"radio\" name=\"{$col['name']}\" value=\"0\" title=\"否\"{$no}>";
				$item = "<div class=\"layui-form-item\">
                    <label class=\"layui-form-label\">{$col['comment']}</label>
                    <div class=\"layui-input-block\">
                    	{$radio}
                    </div>
                  </div>";
				break;
			case 'sex':
				$nan = $nv = '';
				if ($value == '男') {
					$nan = "checked";
				}
				if ($value == '女') {
					$nv = "checked";
				}
				$radio = "<input type=\"radio\" name=\"{$col['name']}\" value=\"1\" title=\"男\"{$nan}>";
				$radio .= "<input type=\"radio\" name=\"{$col['name']}\" value=\"2\" title=\"女\"{$nv}>";
				$item = "<div class=\"layui-form-item\">
                    <label class=\"layui-form-label\">{$col['comment']}</label>
                    <div class=\"layui-input-block\">
                    	{$radio}
                    </div>
                  </div>";
				break;
			default:
				# code...
				break;
		}
		return $item;
	}
}
