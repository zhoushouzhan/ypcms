<?php /*a:2:{s:49:"F:\wwwroot\ypcms\app\admin\view\mclass\index.html";i:1635867427;s:41:"F:\wwwroot\ypcms\app\admin\view\base.html";i:1636685215;}*/ ?>
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
        <li class="layui-this">分类管理</li>
        <li class=""><a href="<?php echo url('add'); ?>">添加分类</a></li>
    </ul>
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">
            <div class="layui-row">
                <div class="layui-col-md6">
                    <button type="button" class="layui-btn layui-btn-sm layui-bg-red ajax-action" data-action="<?php echo url('delete'); ?>">批量删除</button>
                    <button type="button" class="layui-btn layui-btn-sm ajax-action" data-action="<?php echo url('update'); ?>">批量提交</button>
                </div>
                <div class="layui-col-md6" align="right" style="padding-top: 6px;">
                    当前位置：
                    <span class="layui-breadcrumb">
                        <a href="<?php echo url('index'); ?>">分类列表</a>
                        <?php if(is_array($pathArr) || $pathArr instanceof \think\Collection || $pathArr instanceof \think\Paginator): $i = 0; $__LIST__ = $pathArr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <a href="<?php echo url('index',['pid'=>$vo['id']]); ?>"><?php echo htmlspecialchars($vo['title']); ?></a>
                        <?php endforeach; endif; else: echo "" ;endif; if($pid): ?>
                        <a><cite><?php echo htmlspecialchars($r['title']); ?></cite></a>
                        <?php endif; ?>
                    </span>
                </div>
            </div>
            <form action="" class="layui-form ajax-form">
                <table class="layui-table">
                    <colgroup>
                        <col width="30">
                        <col width="60">
                        <col width="90">
                        <col>
                        <col>
                        <col width="180">
                    </colgroup>
                    <thead>
                        <tr>
                            <th><input type="checkbox" lay-skin="primary" lay-filter="check_all"></th>
                            <th>ID</th>
                            <th>排序</th>
                            <th>名称</th>
                            <th>子类管理</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(is_array($dataList) || $dataList instanceof \think\Collection || $dataList instanceof \think\Paginator): if( count($dataList)==0 ) : echo "" ;else: foreach($dataList as $key=>$vo): ?>
                        <tr>
                            <td><input type="checkbox" name="ids[]" value="<?php echo htmlspecialchars($vo['id']); ?>" class="check_s" lay-skin="primary"></td>
                            <td><?php echo htmlspecialchars($vo['id']); ?><input type="hidden" name="id[]" value="<?php echo htmlspecialchars($vo['id']); ?>"></td>
                            <td><input type="number" name="sort[]" class="layui-input" value="<?php echo htmlspecialchars($vo['sort']); ?>"></td>
                            <td><input type="text" name="title[]" value="<?php echo htmlspecialchars($vo['title']); ?>" class="layui-input"></td>
                            <?php if($vo['havesid']): ?>
                            <td><a href="<?php echo url('index',['pid'=>$vo['id']]); ?>" style="color: blue">查看子类</a></td>
                            <?php else: ?>
                            <td>没有子类</td>
                            <?php endif; ?>
                            <td>
                                <a href="<?php echo url('delete',['ids'=>$vo['id']]); ?>" class="layui-btn layui-btn-danger layui-btn-sm ajax-delete"><i class="layui-icon">&#xe640;</i></a>
                                <a href="<?php echo url('add',['pid'=>$vo['id']]); ?>" class="layui-btn layui-btn-sm"><i class="layui-icon">&#xe654;</i></a>
                            </td>
                        </tr>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>
<hr>
<fieldset class="layui-elem-field">
  <legend>说明</legend>
  <div class="layui-field-box">
  无限分类主要为第三级之外的分类提供帮助<br>
  如：地区联动
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

</body>
</html>