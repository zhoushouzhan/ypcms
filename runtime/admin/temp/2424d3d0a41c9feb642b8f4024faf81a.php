<?php /*a:2:{s:46:"F:\wwwroot\ypcms\app\admin\view\ypmod\add.html";i:1653223492;s:41:"F:\wwwroot\ypcms\app\admin\view\base.html";i:1636685215;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>后台管理</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="stylesheet" href="/static/src/ckeditor/plugins/codesnippet/lib/highlight/styles/default.css">
    <link rel="stylesheet" href="/static/src/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/static/src/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/static/admin/css/admin.css?v=<?php echo time(); ?>">
    
<style>
  .layui-form-pane {
    margin-bottom: 10px;
  }
  .layui-form-pane .layui-form-label {
    width: 131px;
  }
  .layui-input-inline {
    position: relative;
  }
  .layui-input-inline .rmbtn {
    position: absolute;
    top: 8px;
    right: 8px;
  }
  .add_item {
    padding: 10px 10px;
  }
</style>

</head>
<body oncontextmenu="self.event.returnValue=false" onselect="return false">
<div class="layui-layout layui-layout-admin">
    
    <div class="layui-main" id="pageBody">
        <div class="cbtn">
            <a href="javascript:window.location.reload();" title="刷新" class="layui-btn layui-bg-blue layui-btn-sm fr"><i class="layui-icon layui-icon-refresh"></i> 刷新</a>
            <a href="javascript:window.history.back();" title="刷新" class="layui-btn layui-bg-black layui-btn-sm fr mr"><i class="layui-icon layui-icon-return"></i> 返回</a>
        </div>
        
<div class="layui-tab layui-tab-brief">
  <ul class="layui-tab-title">
    <li class=""><a href="<?php echo url('index'); ?>">模型管理</a></li>
    <li class="layui-this">添加模型</li>
  </ul>
  <div class="layui-tab-content layui-form">
    <form action="<?php echo url('save'); ?>" method="post" id="f1">
      <div class="layui-form-pane">
        <div class="layui-inline">
          <label class="layui-form-label">模型名称：</label>
          <div class="layui-input-inline">
            <input
              type="text"
              name="name"
              value=""
              class="layui-input"
              required
              lay-verify="required"
              placeholder="必须英文，如：User"
            />
          </div>
        </div>
        <div class="layui-inline">
          <div class="layui-input-inline">
            <select name="mt" id="mt" lay-filter="mt">
              <option value="1">A类模型</option>
              <option value="2" selected="selected">B类模型</option>
              <option value="3">C类模型</option>
            </select>
          </div>
        </div>
      </div>

      <div class="layui-form-pane">
        <div class="layui-inline">
          <label class="layui-form-label">模型别名：</label>
          <div class="layui-input-inline">
            <input
              type="text"
              name="alias"
              value=""
              class="layui-input"
              required
              lay-verify="required"
              placeholder="如：用户"
            />
          </div>
        </div>
        <div class="layui-inline" id="nodeId">
          <div class="layui-input-inline">
            <select name="node_id" lay-filter="nodeId">
              <option value="-1">选择挂载点</option>
              <option value="0">一级节点</option>
              <?php if(is_array($menu) || $menu instanceof \think\Collection || $menu instanceof \think\Paginator): if( count($menu)==0 ) : echo "" ;else: foreach($menu as $key=>$vo): ?>
              <option value="<?php echo htmlspecialchars($vo['id']); ?>"><?php echo htmlspecialchars($vo['title']); ?></option>
              <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
          </div>
        </div>
        <div class="layui-inline layui-hide" id="nodeSort">
          <div class="layui-input-inline">
            <input
              type="number"
              name="nodesort"
              value=""
              class="layui-input"
              placeholder="节点序号"
            />
          </div>
        </div>
      </div>

      <div class="layui-form-pane">
        <div class="layui-inline" id="col_groups">
          <label class="layui-form-label">字段分组：</label>
          <div class="layui-input-inline">
            <input
              type="text"
              name="col_groups[]"
              value="基础属性"
              class="layui-input"
              placeholder="请输入"
            />
            <button
              type="button"
              class="layui-btn layui-btn-xs layui-btn-danger rmbtn"
            >
              <i class="layui-icon layui-icon-close"></i>
            </button>
          </div>

          <div class="layui-input-inline add_group_item">
            <button type="button" class="layui-btn">增加</button>
          </div>
        </div>
      </div>
      <table class="layui-table" lay-size="sm">
        <colgroup>
          <col width="100" />
          <col width="160" />
          <col width="170" />
          <col width="130" />
          <col width="100" />
          <col width="100" />
          <col />
          <col />
          <col />
          <col />
          <col width="100" />
        </colgroup>
        <thead>
          <tr>
            <th>字段名</th>
            <th>表单类型</th>
            <th>字段类型</th>
            <th>长度值</th>
            <th>列宽</th>
            <th>默认值</th>
            <th>注释</th>
            <th>索引</th>
            <th>分组</th>
            <th>列表显示</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody id="listCol">
          <tr>
            <td>
              <input
                type="text"
                class="layui-input"
                name="cols[0][name]"
                required
                lay-verify="required"
              />
            </td>
            <td>
              <select name="cols[0][formItem]" lay-filter="select_type">
                <option value="0">请选择</option>
                <option value="input">单行文本框</option>
                <option value="hidden">隐藏元素</option>
                <option value="none">非表单元素</option>
                <option value="password">密码框</option>
                <option value="datetime">日期时间</option>
                <option value="date">日期</option>
                <option value="select">下拉菜单</option>
                <option value="textarea">多行文本框</option>
                <option value="editor">富文本编辑器</option>
                <option value="radio">单选框</option>
                <option value="checkbox">复选框</option>
                <option value="thumb">单图片</option>
                <option value="photo">相册</option>
                <option value="files">附件</option>
                <option value="ypmod">模型单选</option>
                <option value="ypmod_checkbox">模型多选</option>
                <option value="ypmoda">模型可操作</option>
                <option value="switch">开关</option>
                <option value="icon">图标</option>
                <option value="yesno">是|否</option>
              </select>
            </td>
            <td>
              <select name="cols[0][type]">
                <option value="INT">INT</option>
                <option value="FLOAT">FLOAT</option>
                <option value="VARCHAR">VARCHAR</option>
                <option value="TEXT">TEXT</option>
                <option value="MEDIUMTEXT">MEDIUMTEXT</option>
                <option value="JSON">JSON</option>
              </select>
            </td>
            <td>
              <input
                type="text"
                class="layui-input"
                name="cols[0][size]"
                required
                lay-verify="required"
              />
            </td>
            <td>
              <input type="text" class="layui-input" name="cols[0][colw]" />
            </td>
            <td>
              <input
                type="text"
                class="layui-input sval"
                name="cols[0][sval]"
                value=""
              />
            </td>
            <td>
              <input
                type="text"
                class="layui-input"
                name="cols[0][comment]"
                required
                lay-verify="required"
              />
            </td>

            <td>
              <select class="index" name="cols[0][index]">
                <option value="0">请选择</option>
                <option value="index">普通索引</option>
                <option value="unique">唯一索引</option>
                <option value="fulltext">全文索引</option>
              </select>
            </td>
            <td>
              <select class="col_group" name="cols[0][group]" data-val="0">
                <option value="0">基础属性</option>
              </select>
            </td>
            <td>
              <input
                type="checkbox"
                name="cols[0][listv]"
                value="1"
                lay-skin="primary"
              />
            </td>

            <td>
              <button
                type="button"
                class="layui-btn layui-btn-xs layui-bg-red delTr"
              >
                <i class="layui-icon">&#xe640;</i>
              </button>
              <button
                type="button"
                class="layui-btn layui-btn-xs layui-bg-black addTr"
              >
                <i class="layui-icon">&#xe654;</i>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
      <div>
        <button
          type="button"
          class="layui-btn layui-bg-red"
          lay-submit
          lay-filter="*"
        >
          <i class="layui-icon">&#xe652;</i>执行
        </button>
      </div>
    </form>
  </div>
</div>
<hr />
<fieldset class="layui-elem-field">
  <legend>说明</legend>
  <div class="layui-field-box">
    默认创建自增字段id<br />
    关联字段：表名_主键，如关联用户表：user_id<br />
  </div>
</fieldset>

    </div>
    
</div>
<!--JS引用-->
<script src="/static/src/jquery/jquery.min.js"></script>
<script src="/static/src/jquery/jquery.cookie.min.js"></script>
<script src="/static/src/layui/layui.js"></script>
<script src="/static/src/plupload/plupload.js?v=<?php echo time(); ?>"></script>
<script src="/static/src/ckeditor/ckeditor.js?v=<?php echo time(); ?>"></script>
<script src="/static/src/ckeditor/plugins/codesnippet/lib/highlight/highlight.pack.js?v=<?php echo time(); ?>"></script>




<script src="/static/admin/js/admin.js?v=<?php echo time(); ?>"></script>
<script src="/static/admin/js/jump.js?v=<?php echo time(); ?>"></script>

<script>
  //监听选择表单类型
  form.on("select(select_type)", function (data) {
    var name = $(data.elem).parents("tr").find(".sval").attr("name");
    console.log(name);
    if (
      data.value == "select" ||
      data.value == "radio" ||
      data.value == "checkbox"
    ) {
      var mclass = layer.open({
        title: "选择分类",
        type: 2,
        area: ["100%", "100%"],
        content: ['<?php echo url("mclass/sclass",["pid"=>0]); ?>&inputname=' + name],
      });
      return false;
    }
  });
  //监听节点
  form.on("select(nodeId)", function (data) {
    var nodeid = data.value;

    if (nodeid > 0) {
      $("#nodeSort").removeClass("layui-hide");
    } else {
      $("#nodeSort").addClass("layui-hide");
    }
  });
  //字段分组
  updataColGroup();
  $(".add_group_item").click(function () {
    var item =
      '<div class="add_item"><input type="text" value="" class="layui-input" placeholder="请输入"></div>';
    var ww = layer.open({
      type: 1,
      closeBtn: 0,
      title: "增加字段组",
      btn: ["提交", "取消"],
      yes: function (index, layero) {
        var item_name = $(".add_item>input").val();
        var html =
          '<div class="layui-input-inline"><input type="text" name="col_groups[]" value="' +
          item_name +
          '" class="layui-input" placeholder="请输入"><button type="button" class="layui-btn layui-btn-xs layui-btn-danger rmbtn"><i class="layui-icon layui-icon-close"></i></button></div>';
        $(".add_group_item").before(html);
        updataColGroup();
        layer.close(ww);
      },
      content: item,
    });
  });
  $("#col_groups").on("click", ".rmbtn", function (event) {
    event.preventDefault();
    var index = $("#col_groups")
      .find(".layui-input-inline")
      .index($(this).parent());
    if (index == 0) {
      layer.msg("不能删除第一个", { icon: "5", shade: [0.8, "#393D49"] });
      return false;
    }
    $(this).parent().remove();
    updataColGroup();
  });
  //更新字段分组
  function updataColGroup() {
    var option = "";
    $("input[name='col_groups[]']").each(function (index, el) {
      option += '<option value="' + index + '">' + $(el).val() + "</option>";
    });
    $(".col_group").html(option);
    $(".col_group").each(function (index, el) {
      var val = $(el).data("val");
      $(this).val(val);
    });
    form.render("select");
  }
</script>

</body>
</html>