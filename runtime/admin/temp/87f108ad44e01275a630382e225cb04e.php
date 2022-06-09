<?php /*a:2:{s:49:"F:\wwwroot\ypcms\app\admin\view\ypmod\mkform.html";i:1654646145;s:41:"F:\wwwroot\ypcms\app\admin\view\base.html";i:1654646145;}*/ ?>
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
    
<style>
#mkform{display: flex;display:-webkit-flex;flex-direction: row;}
.fbox{height:100%;padding: 5px;}
.fbox:nth-child(1){width:40%;border-right: 1px solid #ddd;}
.fbox:nth-child(2){width:60%;}
.fbox h2{height: 50px;}
</style>

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
            <li class=""><a href="<?php echo url('index'); ?>">模型管理</a></li>
            <li class=""><a href="<?php echo url('add'); ?>">添加模型</a></li>
            <li class="layui-this">模型表单</li>
            <li><a href="<?php echo url('rule',['id'=>$r['id']]); ?>">验证规则</a></li>
            <li><a href="<?php echo url('hasmod',['id'=>$r['id']]); ?>">关联设置</a></li>
        </ul>
        <div class="layui-tab-content">
            <form action="" method="post" class="ajax-form layui-form" id="f1">
              <input type="hidden" name="id" value="<?php echo htmlspecialchars($r['id']); ?>">
                <div id="mkform">
                   <div class="fbox">
                    <h2 align="center">验证规则指定</h2>

<div class="layui-collapse">

<?php if(is_array($cols) || $cols instanceof \think\Collection || $cols instanceof \think\Paginator): $i = 0; $__LIST__ = $cols;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
  <div class="layui-colla-item">
    <h2 class="layui-colla-title"><?php echo htmlspecialchars($v['comment']); ?></h2>
    <div class="layui-colla-content layui-show">
      <?php if(is_array($rules) || $rules instanceof \think\Collection || $rules instanceof \think\Paginator): $i = 0; $__LIST__ = $rules;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$gz): $mod = ($i % 2 );++$i;?>
        <input type="checkbox" name="rule[<?php echo htmlspecialchars($v['name']); ?>][]" title="<?php echo htmlspecialchars($gz['name']); ?>" value="<?php echo htmlspecialchars($gz['id']); ?>" lay-skin="primary" lay-filter="selectRule"<?php if(isset($colrule[$v['name']]) && in_array($gz['id'],$colrule[$v['name']])): ?> checked <?php endif; ?>>
      <?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
  </div>
<?php endforeach; endif; else: echo "" ;endif; ?>

</div>


                   </div>
                   <div class="fbox">
                   	<h2 align="center">表单预览</h2>



<?php echo $form; ?> 




<fieldset class="layui-elem-field">
    <legend>说明</legend>
    <div class="layui-field-box">
        <p>此表单仅供预览！</p>
    </div>
</fieldset>

                   </div>
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
	$("#mkform").height($(".layui-body").height()-90);
	
	<?php if(isset($editor)): ?>
        CKEDITOR.replace('content',{
            customConfig : '/static/src/ckeditor/ypconfig.js?v=<?php echo time(); ?>'
        });    
	<?php endif; ?>

form.on('checkbox(selectRule)', function(data){
  var postData=$("#f1").serialize();
  $.ajax({
    url: '<?php echo url("updateRule"); ?>',
    type: 'POST',
    dataType: 'json',
    data: postData,
  })
  .done(function(res) {
    console.log("success");
  })
  .fail(function() {
    console.log("error");
  })
  .always(function() {
    console.log("complete");
  });
  
  console.log(data);
  console.log(data.elem); //得到checkbox原始DOM对象
  console.log(data.elem.checked); //是否被选中，true或者false
  console.log(data.value); //复选框value值，也可以通过data.elem.value得到
  console.log(data.othis); //得到美化后的DOM对象
}); 
</script>

</body>
</html>