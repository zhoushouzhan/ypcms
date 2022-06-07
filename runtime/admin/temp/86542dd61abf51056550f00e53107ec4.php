<?php /*a:2:{s:47:"F:\wwwroot\ypcms\app\admin\view\roles\auth.html";i:1635867430;s:41:"F:\wwwroot\ypcms\app\admin\view\base.html";i:1636685215;}*/ ?>
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
        <li class=""><a href="<?php echo url('add'); ?>">添加角色</a></li>
        <li class="layui-this">编辑角色</li>
    </ul>
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">
            <div id="test12" class="demo-tree-more"></div>
        </div>
    </div>
    <input type="hidden" id="group_id" name="id" value="<?php echo htmlspecialchars($id); ?>">
    <button class="layui-btn" id="auth-btn">授权</button>
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
var data = <?php echo $dataList; ?>

    tree=layui.tree;
    tree.render({
        elem: '#test12',
        data: data,
        showCheckbox: true,  //是否显示复选框
        onlyIconControl:true,
        id: 'demoId',
        isJump: true, //是否允许点击节点时弹出新窗口跳转
        click: function(obj){
          var data = obj.data;  //获取当前点击的节点数据
          layer.msg('状态：'+ obj.state + '<br>节点数据：' + JSON.stringify(data));
        }
    });

    /**
     * 授权提交
     */
    $("#auth-btn").on("click", function () {
        var checked_ids;
        checked_ids = tree.getChecked('demoId'); // 获取当前选中的checkbox
        checked_ids=getid(checked_ids);
        if(checked_ids){
            checked_ids=checked_ids.substr(0,checked_ids.length-1);
        }
        $.ajax({
            url: "<?php echo url('updateAuth'); ?>",
            type: "post",
            cache: false,
            data: {
                id: <?php echo htmlspecialchars($id); ?>,
                rules: checked_ids
            },
            success: function (data) {
                if(data.code === 1){
                    setTimeout(function () {
                        location.href = data.url;
                    }, 1000);
                }
                layer.msg(data.msg);
            }
        });
    });
    //遍历数组
    function getid(obj,id){
        id=id?id:'';
        $.each(obj, function(i, e) {
            id+=e.id+',';
            if(e.children){
                id+=getid(e.children);
            }
        });
        return id;
    }

</script>

</body>
</html>