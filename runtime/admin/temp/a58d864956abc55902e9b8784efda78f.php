<?php /*a:2:{s:48:"F:\wwwroot\ypcms\app\admin\view\files\index.html";i:1653795970;s:41:"F:\wwwroot\ypcms\app\admin\view\base.html";i:1636685215;}*/ ?>
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
            <li class="layui-this">附件管理</li>
            <li class=""><a href="<?php echo url('add'); ?>">上传附件</a></li>
        </ul>
        <div class="layui-tab-content">

            <form class="layui-form layui-form-pane" action="<?php echo url('index'); ?>" method="get">
                <div class="layui-inline">
                    <label class="layui-form-label">关键词</label>
                    <div class="layui-input-inline">
                        <input type="text" name="keyword" value="<?php echo htmlspecialchars($keyword); ?>" placeholder="请输入关键词" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <button class="layui-btn" lay-submit lay-filter="search">搜索</button>
                </div>
                <div class="layui-inline">
                    <a class="layui-btn layui-btn-danger" href="<?php echo url('index',['isuse'=>0]); ?>">清理未使用中的附件</a>
                </div>

            </form>
            <hr>

            <form action="" method="post" class="ajax-form">
                <button type="button" class="layui-btn layui-btn-danger layui-btn-small ajax-action" data-action="<?php echo url('delete'); ?>">删除</button>
                <div class="layui-tab-item layui-show">
                    <table class="layui-table">
                        <thead>
                        <tr>
                            <th style="width: 15px;"><input type="checkbox" class="check-all"></th>
                            <th style="width: 30px;">ID</th>
                            <th>标题</th>
                            <th>尺寸</th>
                            <th>是否使用</th>
                            <th>信息</th>
                            <th>模型</th>
                            <th>字段</th>
                            <th>上传时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(is_array($files_list) || $files_list instanceof \think\Collection || $files_list instanceof \think\Paginator): if( count($files_list)==0 ) : echo "" ;else: foreach($files_list as $key=>$vo): ?>
                        <tr>
                            <td><input type="checkbox" name="ids[]" value="<?php echo htmlspecialchars($vo['id']); ?>"></td>
                            <td class="<?php echo $vo['isq']==1 ? "red" : "blue"; ?>"><?php echo htmlspecialchars($vo['id']); ?></td>
                            <td>
                                <a href="<?php echo htmlspecialchars($vo['filepath']); ?>" target="_blank"><?php echo htmlspecialchars($vo['name']); ?></a>
                            </td>
                            <td><?php echo htmlspecialchars(formatSize($vo['fsize'])); ?></td>
                            <td><?php echo !empty($vo['ypcms_id']) ? '<span class="layui-badge layui-bg-blue">使用中</span>' : '<span class="layui-badge layui-bg-orange">空闲中</span>'; ?></td>
                            <td><?php echo htmlspecialchars($vo['ypcms_id']); ?></td>
                            <td><?php echo htmlspecialchars($vo['ypcms_type']); ?></td>
                            <td><?php echo htmlspecialchars((isset($vo['tag']) && ($vo['tag'] !== '')?$vo['tag']:"无")); ?></td>
                            <td><?php echo htmlspecialchars($vo['create_time']); ?></td>
                            <td>
                                <a href="<?php echo url('delete',['ids'=>$vo['id']]); ?>" class="layui-btn layui-btn-danger layui-btn-sm ajax-delete">删除</a>
                            </td>
                        </tr>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                        </tbody>
                    </table>
                    <?php echo $files_list->render(); ?>

                    <fieldset class="layui-elem-field layui-field-title">
                      <legend>辅助说明</legend>
                      <div class="layui-field-box">
                        1、第一列ID颜色意义：<span class="red">红色</span>是后台上传，<span class="blue">蓝色</span>是前台上传<br>
                        2、点击标题可以预览
                      </div>
                    </fieldset>

                </div>
            </form>
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