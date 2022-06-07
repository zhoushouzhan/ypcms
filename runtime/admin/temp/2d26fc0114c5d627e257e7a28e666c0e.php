<?php /*a:2:{s:46:"F:\wwwroot\ypcms\app\admin\view\roles\add.html";i:1652516673;s:41:"F:\wwwroot\ypcms\app\admin\view\base.html";i:1636685215;}*/ ?>
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
    <li class=""><a href="<?php echo url('index'); ?>">角色</a></li>
    <li class="layui-this">添加角色</li>
  </ul>
  <div class="layui-tab-content">
    <div class="layui-tab-item layui-show">
      <form
        class="layui-form form-container"
        action="<?php echo url('save'); ?>"
        method="post"
      >
        <div class="layui-form-item">
          <label class="layui-form-label">名称</label>
          <div class="layui-input-block">
            <input
              type="text"
              name="title"
              value=""
              required
              lay-verify="required"
              placeholder="请输入权限组名称"
              class="layui-input"
            />
          </div>
        </div>
        <div class="layui-form-item">
          <label class="layui-form-label">状态</label>
          <div class="layui-input-block">
            <input
              type="radio"
              name="status"
              value="1"
              title="启用"
              checked="checked"
            />
            <input type="radio" name="status" value="0" title="禁用" />
          </div>
        </div>
        <div class="layui-form-item">
          <label class="layui-form-label">描述</label>
          <div class="layui-input-block">
            <textarea name="intro" id="intro" class="layui-textarea"></textarea>
          </div>
        </div>
        <div class="layui-form-item">
          <label class="layui-form-label">序号</label>
          <div class="layui-input-block">
            <input type="text" name="sort" value="" class="layui-input" />
          </div>
        </div>
        <div class="layui-form-item">
          <div class="layui-input-block">
            <button class="layui-btn" lay-submit lay-filter="*">保存</button>
            <button type="reset" class="layui-btn layui-btn-primary">
              重置
            </button>
          </div>
        </div>
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

</body>
</html>