<?php /*a:2:{s:51:"F:\wwwroot\ypcms\app\admin\view\database\index.html";i:1654646145;s:41:"F:\wwwroot\ypcms\app\admin\view\base.html";i:1654652765;}*/ ?>
<!--
 * @Author: 一品网络技术有限公司
 * @Date: 2022-06-08 07:55:45
 * @LastEditTime: 2022-06-08 09:45:19
 * @FilePath: \ypcms\app\admin\view\base.html
 * @Description:
 * 联系QQ:58055648
 * Copyright (c) 2022 by 东海县一品网络技术有限公司, All Rights Reserved.
-->
<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="UTF-8" />
    <title>后台管理</title>
    <meta name="renderer" content="webkit" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <link
      rel="stylesheet"
      href="/static/src/ckeditor/plugins/codesnippet/lib/highlight/styles/default.css"
    />
    <link
      rel="stylesheet"
      href="/static/src/layui/css/layui.css"
      media="all"
    />
    <link rel="stylesheet" href="/static/fonts/remixicon.css" />
    <link rel="stylesheet" href="/admin/css/admin.css?v=<?php echo time(); ?>" />
    
<style>
    .biglabel .layui-form-label{width: 120px;}
</style>

  </head>
  <body oncontextmenu="self.event.returnValue=false" onselect="return false">
    <div class="layui-layout layui-layout-admin">
      <div class="layui-main" id="pageBody">
        <div class="cbtn">
          <a
            href="javascript:window.location.reload();"
            title="刷新"
            class="layui-btn layui-bg-blue layui-btn-sm fr"
            ><i class="layui-icon layui-icon-refresh"></i> 刷新</a
          >
          <a
            href="javascript:window.history.back();"
            title="刷新"
            class="layui-btn layui-bg-black layui-btn-sm fr mr"
            ><i class="layui-icon layui-icon-return"></i> 返回</a
          >
        </div>
        
<div class="layui-tab layui-tab-brief">
    <ul class="layui-tab-title sideHref">
        <li class="layui-this"><a href="<?php echo url('index'); ?>">备份数据库</a></li>
        <li><a href="<?php echo url('importList'); ?>">还原数据库</a></li>
        <li><a href="<?php echo url('dosql'); ?>">执行SQL</a></li>
    </ul>
    <div class="layui-tab-content">
        <form action="" method="post" class="ajax-form">
        <button type="button" class="layui-btn layui-btn-sm ajax-action" data-action="<?php echo url('export'); ?>">备份</button>
        <button type="button" class="layui-btn layui-btn-warm layui-btn-sm ajax-action" data-action="<?php echo url('optimize'); ?>">优化</button>
        <button type="button" class="layui-btn layui-btn-danger layui-btn-sm ajax-action" data-action="<?php echo url('repair'); ?>">修复</button>
        <table class="layui-table">
            <thead>
            <tr>
                <th style="width: 15px;"><input type="checkbox" class="check-all"></th>
                <th style="width: 30px;">表名</th>
                <th style="width: 30px;">行数</th>
                <th>大小</th>
                <th>冗余</th>
                <th>备注</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($tableList) || $tableList instanceof \think\Collection || $tableList instanceof \think\Paginator): if( count($tableList)==0 ) : echo "" ;else: foreach($tableList as $key=>$vo): ?>
            <tr>
                <td><input type="checkbox" name="tables[]" value="<?php echo htmlspecialchars($vo['name']); ?>"></td>
                <td><?php echo htmlspecialchars($vo['name']); ?></td>
                <td><?php echo htmlspecialchars($vo['rows']); ?></td>
                <td><?php echo htmlspecialchars(formatSize($vo['data_length'])); ?></td>
                <td><?php echo htmlspecialchars($vo['data_free']); ?></td>
                <td><?php echo htmlspecialchars($vo['comment']); ?></td>
                <td>
                    <a href="<?php echo url('optimize',['tables'=>$vo['name']]); ?>" class="layui-btn layui-btn-warm layui-btn-sm ajax-url">优化</a>
                    <a href="<?php echo url('repair',['tables'=>$vo['name']]); ?>" class="layui-btn layui-bg-blue layui-btn-sm ajax-url">修复</a>
                    <a href="<?php echo url('column',['tables'=>$vo['name']]); ?>" class="layui-btn layui-btn-primary layui-btn-sm">字段查看</a>
                </td>
            </tr>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
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
