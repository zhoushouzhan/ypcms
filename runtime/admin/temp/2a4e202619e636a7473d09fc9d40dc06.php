<?php /*a:2:{s:50:"F:\wwwroot\ypcms\app\admin\view\index\welcome.html";i:1636334202;s:41:"F:\wwwroot\ypcms\app\admin\view\base.html";i:1636685215;}*/ ?>
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
        .htit{font-size: 26px;text-align: center;}
        .tbox{display: flex;flex-direction: column; margin-top: 30px;flex-wrap: wrap;}
        .tbox .item{flex:1;}
        .radarBox{display: flex;flex-wrap: wrap;justify-content: space-between;}
        .radarBox .item{width: 33.333%;}
    </style>

</head>
<body oncontextmenu="self.event.returnValue=false" onselect="return false">
<div class="layui-layout layui-layout-admin">
    
    <div class="layui-main" id="pageBody">
        <div class="cbtn">
            <a href="javascript:window.location.reload();" title="刷新" class="layui-btn layui-bg-blue layui-btn-sm fr"><i class="layui-icon layui-icon-refresh"></i> 刷新</a>
            <a href="javascript:window.history.back();" title="刷新" class="layui-btn layui-bg-black layui-btn-sm fr mr"><i class="layui-icon layui-icon-return"></i> 返回</a>
        </div>
        
    <!--tab标签-->
<div class="layui-tab layui-tab-brief">
                <div class="layui-main">
                    
                    您好，<?php echo htmlspecialchars($admin['truename']); ?>，您的系统角色为
                    <?php if(is_array($admin['roles']) || $admin['roles'] instanceof \think\Collection || $admin['roles'] instanceof \think\Paginator): $i = 0; $__LIST__ = $admin['roles'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <span class="layui-badge layui-bg-green"><?php echo htmlspecialchars($vo['title']); ?></span>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
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


<script src="/static/src/echarts/echarts.js"></script>



<script src="/static/admin/js/admin.js?v=<?php echo time(); ?>"></script>
<script src="/static/admin/js/jump.js?v=<?php echo time(); ?>"></script>

</body>
</html>