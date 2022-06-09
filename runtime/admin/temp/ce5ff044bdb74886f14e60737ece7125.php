<?php /*a:2:{s:46:"F:\wwwroot\ypcms\app\admin\view\files\add.html";i:1654646145;s:41:"F:\wwwroot\ypcms\app\admin\view\base.html";i:1654652765;}*/ ?>
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
            <li class=""><a href="<?php echo url('index'); ?>">附件管理</a></li>
            <li class="layui-this">上传附件</li>
        </ul>
        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
            	<button class="layui-btn" id="selectFiles">选择文件</button>
<table class="layui-table">
  <colgroup>
    <col width="60">
    <col width="400">
    <col>
  </colgroup>
  <thead>
    <tr>
      <th>序号</th>
      <th>文件名</th>
      <th>尺寸</th>
      <th>状态</th>
      <th>操作</th>
    </tr> 
  </thead>
  <tbody></tbody>
  <tfoot class="layui-hide">
  	<tr>
  		<td colspan="3"><div id="fileStatus"></div></td>
  		<td colspan="2">
  			<button class="layui-btn layui-btn-normal layui-btn-sm" id="uploadFiles">全部上传</button>
  		</td>
  	</tr>
  </tfoot>
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
var filelistbox = $('tbody');

upload.render({
  elem: '#selectFiles'
  ,bindAction:'#uploadFiles'
  ,url: '<?php echo url("api/upload"); ?>'
  ,multiple:true
  ,auto:false
  ,accept:'file'
  ,acceptMime: '<?php echo htmlspecialchars($allowType); ?>' //允许上传的文件类型
  ,size: <?php echo htmlspecialchars($allowSize); ?> //最大允许上传的文件大小
  ,choose: function(obj){
  	files = obj.pushFile();
	obj.preview(function(index, file, result){
  		var count=$("tbody>tr").length+1;
  	    count++;
  		var tr = $(['<tr id="' + index + '">'
  		, '<td>'+count+'</td>'
  		, '<td>' +file.name + '</td>'
  		, '<td>'+renderSize(file.size)+'</td>'
  		, '<td>'
  		, '<span class="layui-badge layui-bg-gray">待上传</span>'
  		, '</td>'
  		, '<td>'
  		, '<button class="layui-btn layui-btn-xs layui-btn-danger removefile"><i class="layui-icon">&#x1007;</i>移除</button>'
  		, '</td>'
  		, '</tr>'].join(''));
  		tr.find('.removefile').on('click', function () {
  			delete files[index]; //删除对应的文件
  			tr.remove();
  		});
	    filelistbox.append(tr);
	    $('#fileStatus').html('共<span class="layui-badge"> '+(count-1)+' </span>个待传文件，点击右边按钮开始上传!');
	    $('tfoot').removeClass('layui-hide');
    });
  }
  ,done: function(res, index, upload){ //上传后的回调
	var tr=filelistbox.find('tr#'+index),tds=tr.children();
  	if (res.code == 1) { //上传成功
  		delete files[index];
  		tds.eq(3).html('<span class="layui-badge layui-bg-green">上传成功</span>');
  	}
  	else{
  		tds.eq(3).html('<span class="layui-badge">'+res.msg+'</span>');
  	}
  }
  ,allDone: function(obj){ //当文件全部被提交后，才触发
    //console.log(obj.total); //得到总文件数
    //console.log(obj.successful); //请求成功的文件数
    //console.log(obj.aborted); //请求失败的文件数
    layer.msg('上传完毕'); 
  }

});
</script>

  </body>
</html>
