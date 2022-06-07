<?php /*a:2:{s:45:"F:\wwwroot\ypcms\app\admin\view\menu\add.html";i:1635867427;s:41:"F:\wwwroot\ypcms\app\admin\view\base.html";i:1636685215;}*/ ?>
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
        
<!--tab标签-->
<div class="layui-tab layui-tab-brief">
    <ul class="layui-tab-title">
        <li class=""><a href="<?php echo url('admin/menu/index'); ?>">后台节点</a></li>
        <li class="layui-this">添加节点</li>
    </ul>
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">
            <form class="layui-form form-container" action="<?php echo url('admin/menu/save'); ?>" method="post" name="add">
                <div class="layui-form-item">
                    <label class="layui-form-label">上级节点</label>
                    <div class="layui-input-block">
                        <select name="pid" lay-verify="required">
                            <option value="0">一级节点</option>
                            <?php if(is_array($dataList) || $dataList instanceof \think\Collection || $dataList instanceof \think\Paginator): if( count($dataList)==0 ) : echo "" ;else: foreach($dataList as $key=>$vo): ?>
                            <option value="<?php echo htmlspecialchars($vo['id']); ?>" <?php if($pid==$vo['id']): ?> selected="selected" <?php endif; ?>><?php if($vo['level'] != '1'): ?>|<?php for($i=1;$i<$vo['level'];$i++){echo ' ----' ;} ?><?php endif; ?> <?php echo htmlspecialchars($vo['title']); ?></option> <?php endforeach; endif; else: echo "" ;endif; ?> </select>
                    </div>
                    </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">节点名称</label>
                    <div class="layui-input-block">
                        <input type="text" name="title" value="" required lay-verify="required" placeholder="请输入菜单名称" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                        <label class="layui-form-label">控制器方法</label>
                        <div class="layui-input-block">
                            <input type="text" name="name" value="" required lay-verify="required" placeholder="请输入控制器方法 如：admin/Index/index" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">图标</label>
                        <div class="layui-input-inline">
                            <input type="text" name="icon" id="icon" value="" placeholder="如：fa fa-home" class="layui-input">
                        </div>
                        <div class="layui-input-inline">
                            <button type="button" class="layui-btn layui-btn-primary" id="selectIcon"><i class="layui-icon">&#xe66b;</i></button>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">状态</label>
                        <div class="layui-input-block">
                            <input type="radio" name="status" value="1" title="显示" checked="checked">
                            <input type="radio" name="status" value="0" title="隐藏">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">排序</label>
                        <div class="layui-input-block">
                            <input type="text" name="sort" value="0" required lay-verify="required" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <input type="hidden" name="sid" value="">
                            <button class="layui-btn" lay-submit lay-filter="*">保存</button>
                            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
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

<script>
    jQuery(document).ready(function($) {
        $("#selectIcon").click(function(event) {
            /* Act on the event */
            var index=layer.open({
                title:'选择图标',
                type:2,
                content:['/icon.php'],
                area: ['100%', '100%']
            })
        });
    });
</script>

</body>
</html>