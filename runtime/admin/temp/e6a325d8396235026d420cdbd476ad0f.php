<?php /*a:2:{s:46:"F:\wwwroot\ypcms\app\admin\view\pay\index.html";i:1590545960;s:41:"F:\wwwroot\ypcms\app\admin\view\base.html";i:1654652765;}*/ ?>
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
        <li class="layui-this">支付接口管理</li>
    </ul>
    <div class="layui-tab-content">
        <form action="" class="layui-form">
        <div class="layui-tab-item layui-show">
            <table class="layui-table">
                <thead>
                <tr>
                    <th style="width: 30px;">ID</th>
                    <th>接口名称</th>
                    <th>控制器名</th>
                    <th width="200">开关</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php if(is_array($dataList) || $dataList instanceof \think\Collection || $dataList instanceof \think\Paginator): if( count($dataList)==0 ) : echo "" ;else: foreach($dataList as $key=>$vo): ?>
                <tr>
                    <td><?php echo htmlspecialchars($vo['id']); ?></td>
                    <td><?php echo htmlspecialchars($vo['title']); ?></td>

                    <td><?php echo htmlspecialchars($vo['name']); ?></td>
                    <td>
                        <input type="checkbox" name="enabled" lay-skin="switch"<?php echo !empty($vo['enabled']) ? ' checked' : ''; ?> infoid="<?php echo htmlspecialchars($vo['id']); ?>" lay-filter="enabled" " lay-text="开启|关闭" value="1">
                    </td>

                    <td>
                        <a href="<?php echo url('setpay',['id'=>$vo['id']]); ?>" class="layui-btn layui-btn-normal layui-btn-sm">配置</a>
                        <a href="<?php echo url('delete',['id'=>$vo['id']]); ?>" class="layui-btn layui-btn-danger layui-btn-sm ajax-delete">删除</a>
                    </td>
                </tr>
                <?php endforeach; endif; else: echo "" ;endif; ?>
                </tbody>
            </table>
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
    
<script>
form.on('switch(enabled)', function(data){
  var enabled=data.elem.checked?'1':0;
  $.ajax({
      url: '<?php echo url("toggle"); ?>',
      type: 'POST',
      dataType: 'json',
      data: {id: $(data.elem).attr('infoid'),enabled:enabled},
  })
  .done(function(res) {
      //console.log("success");
  });
});
</script>

  </body>
</html>
