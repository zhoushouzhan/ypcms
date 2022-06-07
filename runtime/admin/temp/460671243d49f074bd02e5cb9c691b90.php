<?php /*a:2:{s:51:"F:\wwwroot\ypcms\app\admin\view\category\index.html";i:1653809020;s:41:"F:\wwwroot\ypcms\app\admin\view\base.html";i:1636685215;}*/ ?>
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
    <li class="layui-this">栏目管理</li>
    <li class=""><a href="<?php echo url('admin/category/add'); ?>">添加栏目</a></li>
  </ul>
  <div class="layui-tab-content">
    <div class="layui-tab-item layui-show">
      <form action="" class="layui-form" lay-filter="formCategory">
        <table class="layui-table">
          <colgroup>
            <col width="40" />
            <col width="40" />
            <col />
            <col />
            <col />
            <col width="100" />
            <col width="100" />
            <col width="100" />
            <col width="280" />
          </colgroup>
          <thead>
            <tr>
              <th>选择</th>
              <th>ID</th>
              <th>排序</th>
              <th>栏目名称</th>
              <th>路由</th>
              <th>终极栏目</th>
              <th>导航显示</th>
              <th>使用模型</th>
              <th><div align="center">操作</div></th>
            </tr>
          </thead>
          <tbody data-deltips="删除栏目会一并删除子栏目，确定？">
            <?php if(is_array($category_list) || $category_list instanceof \think\Collection || $category_list instanceof \think\Paginator): if( count($category_list)==0 ) : echo "" ;else: foreach($category_list as $key=>$vo): ?>
            <tr data-pid="<?php echo htmlspecialchars($vo['pid']); ?>">
              <td class="selectId">
                <input
                  type="checkbox"
                  name="id[]"
                  value="<?php echo htmlspecialchars($vo['id']); ?>"
                  lay-skin="primary"
                />
              </td>
              <td><?php echo htmlspecialchars($vo['id']); ?></td>
              <td><?php echo htmlspecialchars($vo['sort']); ?></td>
              <td>
                <?php if($vo['level'] != '1'): ?>|<?php for($i=1;$i<$vo['level'];$i++){echo '
                ----';} ?><?php endif; ?> <?php echo htmlspecialchars($vo['title']); ?>
              </td>
              <td>
                <?php if($vo['url']): ?>
                <a href="<?php echo htmlspecialchars($vo['url']); ?>" target="_blank"> <?php echo htmlspecialchars($vo['route']); ?></a>
                <?php endif; ?>
              </td>
              <td><?php echo !empty($vo['last']) ? "是" : "否"; ?></td>
              <td>
                <input type="checkbox" name="status"
                lay-skin="switch"<?php echo !empty($vo['status']) ? ' checked' : ''; ?> infoid="<?php echo htmlspecialchars($vo['id']); ?>"
                lay-filter="status" " lay-text="显示|关闭" value="1"
                pid="$vo.pid">
              </td>
              <td><?php echo htmlspecialchars($vo['modinfo']['alias']); ?></td>
              <td>
                <a
                  href="<?php echo url('edit',['id'=>$vo['id']]); ?>"
                  class="layui-btn layui-btn-normal layui-btn-sm"
                  >编辑</a
                >
                <a
                  data-href="<?php echo url('delete',['id'=>$vo['id']]); ?>"
                  class="layui-btn layui-btn-danger layui-btn-sm tr-delete"
                  data-id="<?php echo htmlspecialchars($vo['id']); ?>"
                  >删除</a
                >
                <?php if($vo['last'] == '0'): ?>
                <a
                  href="<?php echo url('add',['pid'=>$vo['id']]); ?>"
                  class="layui-btn layui-btn-sm"
                  >加子栏目</a
                >
                <?php endif; ?>
              </td>
            </tr>
            <?php endforeach; endif; else: echo "" ;endif; ?>
          </tbody>
          <tfoot>
            <tr>
              <td>
                <input
                  type="checkbox"
                  lay-skin="primary"
                  lay-filter="chooseAll"
                />
              </td>
              <td colspan="100">
                <div style="display: flex">
                  <div>
                    <select name="pid">
                      <option value="0">移动所选栏目</option>
                      <?php if(is_array($category_list) || $category_list instanceof \think\Collection || $category_list instanceof \think\Paginator): $i = 0; $__LIST__ = $category_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                      <option value="<?php echo htmlspecialchars($v['id']); ?>">
                        <?php if($v['level'] != '1'): ?>|<?php for($i=1;$i<$v['level'];$i++){echo '
                        ----';} ?><?php endif; ?><?php echo htmlspecialchars($v['title']); ?>
                      </option>
                      <?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                  </div>
                  <div style="padding: 0 5px">
                    <button
                      class="layui-btn"
                      type="button"
                      lay-submit
                      lay-filter="moveCategory"
                    >
                      移动
                    </button>
                  </div>
                </div>
              </td>
            </tr>
          </tfoot>
        </table>
      </form>
    </div>
  </div>
</div>

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
  form.on("switch(status)", function (data) {
    var status = data.elem.checked ? "1" : 0;
    $.ajax({
      url: '<?php echo url("toggle"); ?>',
      type: "POST",
      dataType: "json",
      data: { id: $(data.elem).attr("infoid"), status: status },
    }).done(function (res) {
      //console.log("success");
    });
  });
  form.on("submit(moveCategory)", function (data) {
    console.log(form.val("formCategory"));
    var data = form.val("formCategory");
    $.ajax({
      url: '<?php echo url("moveCategory"); ?>',
      type: "POST",
      dataType: "json",
      data: data,
    }).done(function (res) {
      if (res.code == 1) {
        layer.msg(res.msg, function () {
          location.reload();
        });
      }
    });
    return;
  });
</script>

</body>
</html>