<?php /*a:2:{s:51:"F:\wwwroot\ypcms\app\admin\view\database\dosql.html";i:1654646145;s:41:"F:\wwwroot\ypcms\app\admin\view\base.html";i:1654646145;}*/ ?>
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
.biglabel .layui-form-label {
    width: 120px;
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
    <ul class="layui-tab-title sideHref">
        <li><a href="<?php echo url('index',['type'=>'export']); ?>">备份数据库</a></li>
        <li><a href="<?php echo url('index',['type'=>'import']); ?>">还原数据库</a></li>
        <li class="layui-this">执行SQL</li>
    </ul>
    <div class="layui-tab-content">
        <form action="<?php echo url('dosql'); ?>" method="post" class="ajax-form">
            <div class="layui-form-item layui-form-text">
                <textarea name="query" id="query" placeholder="请输入SQL语句，关系重大，请谨慎操作。" class="layui-textarea" rows="8"></textarea>
            </div>
            <div class="layui-form-item">
                <button class="layui-btn layui-btn-danger" lay-submit lay-filter="*">执行</button>
            </div>
        </form>
        <fieldset class="layui-elem-field">
            <legend>辅助说明</legend>
            <div class="layui-field-box">
                1、多条语句请用&quot;回车&quot;格开,每条语句以&quot;;&quot;结束，数据表前缀可用：&quot; [!pre!] &quot;表示
                <hr>
                2、执行SQL语句关系重大，请做好备份。
            </div>
        </fieldset>
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