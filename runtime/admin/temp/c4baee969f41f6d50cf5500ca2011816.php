<?php /*a:2:{s:47:"F:\wwwroot\ypcms\app\admin\view\user\index.html";i:1635867435;s:41:"F:\wwwroot\ypcms\app\admin\view\base.html";i:1636685215;}*/ ?>
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
            <li class="layui-this">会员管理</li>
            <li><a href="<?php echo url('add'); ?>">添加会员</a></li>
        </ul>
        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">

                <form class="layui-form layui-form-pane" action="<?php echo url('admin/user/index'); ?>" method="get">
                    <div class="layui-inline">
                        <label class="layui-form-label">关键词</label>
                        <div class="layui-input-inline">
                            <input type="text" name="keyword" value="<?php echo htmlspecialchars($keyword); ?>" placeholder="请输入关键词" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <button class="layui-btn">搜索</button>
                    </div>
                </form>
                <hr>

                <table class="layui-table">
                    <thead>
                    <tr>
                        <th style="width: 30px;">ID</th>
                        <th>用户名</th>
                        <th>会员组</th>
                        <th>有效期</th>
                        <th>手机</th>
                        <th>邮箱</th>
                        <th>最后登录时间</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(is_array($user_list) || $user_list instanceof \think\Collection || $user_list instanceof \think\Paginator): if( count($user_list)==0 ) : echo "" ;else: foreach($user_list as $key=>$vo): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($vo['id']); ?></td>
                        <td><?php echo htmlspecialchars($vo['username']); ?></td>
                        <td><?php echo htmlspecialchars($vo['group']['title']); ?></td>
                        <td><?php echo htmlspecialchars($vo['group_date']); ?></td>
                        <td><?php echo htmlspecialchars($vo['mobile']); ?></td>
                        <td><?php echo htmlspecialchars($vo['email']); ?></td>
                        <td><?php echo htmlspecialchars($vo['update_time']); ?></td>
                        <td>
                            <a href="<?php echo url('edit',['id'=>$vo['id']]); ?>" class="layui-btn layui-btn-normal layui-btn-sm">编辑</a>
                            <a href="<?php echo url('delete',['id'=>$vo['id']]); ?>" class="layui-btn layui-btn-danger layui-btn-sm ajax-delete">删除</a>
                        </td>
                    </tr>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                </table>
                <!--分页-->
                <?php echo $user_list->render(); ?>              
            </div>
        </div>
    </div>
<fieldset class="layui-elem-field">
  <legend>帮助</legend>
  <div class="layui-field-box">
    1、点击用户名可以查看详情。
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