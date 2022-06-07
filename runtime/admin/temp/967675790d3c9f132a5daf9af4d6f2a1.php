<?php /*a:2:{s:48:"F:\wwwroot\ypcms\app\admin\view\ypmod\index.html";i:1635867436;s:41:"F:\wwwroot\ypcms\app\admin\view\base.html";i:1636685215;}*/ ?>
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
            <li class="layui-this">模型管理</li>
            <li><a href="<?php echo url('add'); ?>">添加模型</a></li>
        </ul>
        <div class="layui-tab-content">
            <form action="" method="post" class="ajax-form layui-form">
                <div class="layui-tab-item layui-show">
                    <table class="layui-table">
                        <colgroup>
                            <col width="50">
                            <col>
                            <col width="90">
                            <col>
                            <col>
                        </colgroup>
                        <thead>
                        <tr>
                            <th><center>ID</center></th>
                            <th>表名</th>
                            <th><div align="center">属性</div></th>
                            <th>注释</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(is_array($dataList) || $dataList instanceof \think\Collection || $dataList instanceof \think\Paginator): $i = 0; $__LIST__ = $dataList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <tr>
                            <td align="center" title="<?php echo htmlspecialchars($vo['id']); ?>"><?php echo htmlspecialchars($key+1); ?></td>
                            <td><?php echo htmlspecialchars($vo['name']); ?></td>
                            <td align="center"><?php echo htmlspecialchars($modclass[$vo['mt']]['name']); ?></td>
                            <td><?php echo htmlspecialchars($vo['alias']); ?></td>
                            <td>
                                <a href="<?php echo url('edit',['id'=>$vo['id']]); ?>" class="layui-btn layui-btn-normal layui-btn-xs"><i class="layui-icon layui-icon-edit"></i>编辑</a>
                                <a href="<?php echo url('mkform',['id'=>$vo['id']]); ?>" class="layui-btn layui-bg-cyan layui-btn-xs"><i class="layui-icon layui-icon-set"></i>配置</a>
                                
                                <?php if(!in_array(($vo['name']), is_array($sysmod)?$sysmod:explode(',',$sysmod))): ?>
                                <a href="<?php echo url('delete',['id'=>$vo['id']]); ?>" class="layui-btn layui-btn-danger layui-btn-xs ajax-delete"><i class="layui-icon layui-icon-delete"></i>删除</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                        </tbody>
                    </table>
                </div>
            </form>


<fieldset class="layui-elem-field">
  <legend>模型相关说明</legend>
  <div class="layui-field-box">
   <p>模型总数：<?php echo htmlspecialchars($dataList->count()); ?>个</p>
   <p>A类模型：仅表单，无列表</p>
   <p>B类模型：表单，列表，后台支持，前台支持</p>
   <p>C类模型：表单，列表，后台支持</p>
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