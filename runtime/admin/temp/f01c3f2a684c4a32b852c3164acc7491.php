<?php /*a:2:{s:47:"F:\wwwroot\ypcms\app\admin\view\menu\index.html";i:1635867428;s:41:"F:\wwwroot\ypcms\app\admin\view\base.html";i:1636685215;}*/ ?>
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
    .ruleTitle{cursor: pointer;}
    .ruleTitle i{width: 10px;}
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
    <ul class="layui-tab-title">
        <li class="layui-this">后台节点</li>
        <li class=""><a href="<?php echo url('admin/menu/add'); ?>">添加节点</a></li>
    </ul>
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">
            <table class="layui-table">

              <colgroup>
                <col width="60">
                <col width="70">
                <col width="200">
                <col>
                <col width="60">
                <col width="260">
              </colgroup>

                <thead>
                <tr>
                    <th>ID</th>
                    <th>排序</th>
                    <th>名称</th>
                    <th>控制器方法</th>
                    <th>状态</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php if(is_array($dataList) || $dataList instanceof \think\Collection || $dataList instanceof \think\Paginator): if( count($dataList)==0 ) : echo "" ;else: foreach($dataList as $key=>$vo): ?>
                <tr data-id="<?php echo htmlspecialchars($vo['id']); ?>" data-sid="<?php echo htmlspecialchars($vo['sid']); ?>" data-pid="<?php echo htmlspecialchars($vo['pid']); ?>"<?php if($vo['pid']!=0): ?> class="layui-hide"<?php endif; ?>>
                    <td><?php echo htmlspecialchars($vo['id']); ?></td>
                    <td><?php echo htmlspecialchars($vo['sort']); ?></td>
                    <td class="ruleTitle"><?php if($vo['pid']==0 && $vo['sid']): ?><i class="fa fa-caret-right"></i><?php endif; if($vo['level'] != '1'): ?>|<?php for($i=1;$i<$vo['level'];$i++){echo ' ----';} ?><?php endif; ?> <?php echo htmlspecialchars($vo['title']); ?></td>
                    <td><kbd><?php echo htmlspecialchars($vo['name']); ?></kbd></td>
                    <td><?php echo $vo['status']==1 ? '显示' : '隐藏'; ?></td>
                    <td>
                        <a href="<?php echo url('add',['pid'=>$vo['id']]); ?>" class="layui-btn layui-btn-sm">添加子节点</a>
                        <a href="<?php echo url('edit',['id'=>$vo['id']]); ?>" class="layui-btn layui-btn-normal layui-btn-sm">编辑</a>
                        <a href="<?php echo url('delete',['id'=>$vo['id']]); ?>" class="layui-btn layui-btn-danger layui-btn-sm this-delete">删除</a>
                    </td>
                </tr>
                <?php endforeach; endif; else: echo "" ;endif; ?>
                </tbody>
            </table>
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
//节点管理层级控制
$("#pageBody").on("click",".ruleTitle",function(e) {
    /* Act on the event */
    if($(this).find('i').hasClass('fa-caret-right')){
        $(this).find('i').removeClass('fa-caret-right').addClass('fa-caret-down');
        var sid=$(this).parents("tr").data('sid');
        if(!sid) return false;
        var sidArr=sid.split(',');
        $("tr").each(function(index, el) {
            var id=$(el).data('id');
            id=String(id);
            if(sidArr.indexOf(id)>=0){
                $(el).removeClass('layui-hide');
            }
        });
    }else if($(this).find('i').hasClass('fa-caret-down')){
        $(this).find('i').removeClass('fa-caret-down').addClass('fa-caret-right');
        var sid=$(this).parents("tr").data('sid');
        if(!sid) return false;
        var sidArr=sid.split(',');
        $("tr").each(function(index, el) {
            var id=$(el).data('id');
            id=String(id);
            if(sidArr.indexOf(id)>=0){
                $(el).addClass('layui-hide');
            }
        });
    }
});
//删除节点
$(".this-delete").click(function(event) {
    /* Act on the event */
    log('xx');
    var _href = $(this).attr('href');
    layer.open({
        title:'提示',
        shade: false,
        content: '删除节点会一并删除子节点，确定？',
        btn: ['确定', '取消'],
        yes: function (index) {
            $.ajax({
                url: _href,
                type: "get",
                success: function (info) {
                    if (info.code === 1) {
                        layer.msg(info.msg);
                        $.each(info.data.split(','),function(index, el) {
                            $("tr[data-id="+el+"]").fadeTo('slow', 0.01, function() {
                                $(this).slideUp("fast",function(){
                                    $(this).remove();
                                })
                            });                           
                        });
                    }
                }
            });
            layer.close(index);
        }
    });
    return false;
});
</script>

</body>
</html>