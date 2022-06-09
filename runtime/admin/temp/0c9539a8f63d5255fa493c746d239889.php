<?php /*a:2:{s:57:"F:\wwwroot\ypcms\app\admin\view\database\import_list.html";i:1654646145;s:41:"F:\wwwroot\ypcms\app\admin\view\base.html";i:1654652765;}*/ ?>
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
            <li><a href="<?php echo url('index',['type'=>'export']); ?>">备份数据库</a></li>
            <li class="layui-this"><a href="<?php echo url('index',['type'=>'import']); ?>">还原数据库</a></li>
            <li><a href="<?php echo url('dosql'); ?>">执行SQL</a></li>
        </ul>
        <div class="layui-tab-content">
            <form action="" method="post" class="ajax-form">
            <table class="layui-table">
                <thead>
                <tr>
                    <th style="width: 150px;">备份文件</th>
                    <th style="width: 50px;">文件数</th>
                    <th>压缩格式</th>
                    <th>数据大小</th>
                    <th>创建时间</th>
                    <th style="width: 160px;">操作</th>
                </tr>
                </thead>
                <tbody>
                <?php if(is_array($datalist) || $datalist instanceof \think\Collection || $datalist instanceof \think\Paginator): if( count($datalist)==0 ) : echo "" ;else: foreach($datalist as $key=>$vo): ?>
                <tr>
                    <td><?php echo htmlspecialchars(date("Ymd-His",!is_numeric($vo['name'])? strtotime($vo['name']) : $vo['name'])); ?></td>
                    <td><?php echo htmlspecialchars($vo['part']); ?></td>
                    <td><?php echo htmlspecialchars($vo['compress']); ?></td>
                    <td><?php echo htmlspecialchars(formatSize($vo['size'])); ?></td>
                    <td><?php echo htmlspecialchars(date("Y-m-d H:i:s",!is_numeric($vo['time'])? strtotime($vo['time']) : $vo['time'])); ?></td>
                    <td>
                        <a ajaxhref="<?php echo url('import',['time'=>$vo['name']]); ?>" class="layui-btn layui-btn-normal layui-btn-sm import">还原</a>
                        <a href="<?php echo url('delete',['tables'=>$vo['name']]); ?>" class="layui-btn layui-btn-danger layui-btn-sm ajax-delete">删除</a>
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
    
<script>
$(document).ready(function() {
	$("a.import").click(function(event) {
		/* Act on the event */
		var url=$(this).attr('ajaxhref');
		var index = layer.load(1);
		$.get(url, function(data) {
			layer.close(index);  
			layer.alert(data.msg);
		});
		return;
	});
});
function upperCase(x){
    var y=document.getElementById(x).value
    document.getElementById(x).value=y.toUpperCase()
}
</script>

  </body>
</html>
