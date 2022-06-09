<?php /*a:2:{s:47:"F:\wwwroot\ypcms\app\admin\view\mclass\add.html";i:1654646145;s:41:"F:\wwwroot\ypcms\app\admin\view\base.html";i:1654652765;}*/ ?>
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
    <ul class="layui-tab-title">
        <li class=""><a href="<?php echo url('index'); ?>">分类管理</a></li>
        <li class="layui-this">添加分类</li>
    </ul>
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">
            <form class="layui-form form-container" action="<?php echo url('save'); ?>" method="post">
                <input type="hidden" name="pid" value="<?php echo htmlspecialchars($pid); ?>">
                <div class="layui-form-item">
                    <label class="layui-form-label">名称</label>
                    <div class="layui-input-block">
                        <textarea name="titles" id="titles" cols="30" rows="10" required  lay-verify="required" class="layui-textarea"></textarea>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn" lay-submit lay-filter="*">提交</button>
                        <button type="button" onclick="javascript:history.go(-1);" class="layui-btn layui-btn-warm">返回</button>
                        <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<hr>
<fieldset class="layui-elem-field">
  <legend>说明</legend>
  <div class="layui-field-box">
	分类为批量添加式，一行一个<br>
	如同时添加序号，用竖线隔开，如：语文|99
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
