<?php /*a:2:{s:50:"F:\wwwroot\ypcms\app\admin\view\colrule\index.html";i:1635867422;s:41:"F:\wwwroot\ypcms\app\admin\view\base.html";i:1636685215;}*/ ?>
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
        <li class="layui-this">验证规则管理</li>
    </ul>
    <div class="layui-tab-content">
        <form action="<?php echo url('save'); ?>" method="post" class="ajax-form">
            <input type="hidden" name="id" value="">
            <div class="layui-form-item">
                <div class="layui-input-inline">
                    <input type="text" name="name" required lay-verify="required" placeholder="规则名" class="layui-input">
                </div>
                <div class="layui-input-inline">
                    <input type="text" name="rule" required lay-verify="required" placeholder="规则" class="layui-input">
                </div>
                <div class="layui-input-inline">
                    <input type="text" name="msg" required lay-verify="required" placeholder="提示" class="layui-input">
                </div>
                <div class="layui-input-inline">
                    <button class="layui-btn" lay-submit lay-filter="*">提交</button>
                </div>
            </div>
        </form>
        <div class="layui-tab-item layui-show">
            <table class="layui-table">
                <thead>
                    <tr>
                        <th style="width: 30px;">ID</th>
                        <th>规则名</th>
                        <th>规则</th>
                        <th>提示</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(is_array($dataList) || $dataList instanceof \think\Collection || $dataList instanceof \think\Paginator): if( count($dataList)==0 ) : echo "" ;else: foreach($dataList as $key=>$vo): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($vo['id']); ?></td>
                        <td><?php echo htmlspecialchars($vo['name']); ?></td>
                        <td><?php echo htmlspecialchars($vo['rule']); ?></td>
                        <td><?php echo htmlspecialchars($vo['msg']); ?></td>
                        <td>
                            <a href="<?php echo url('delete',['id'=>$vo['id']]); ?>" class="layui-btn layui-btn-danger layui-btn-sm ajax-delete">删除</a>
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

</body>
</html>