<?php /*a:1:{s:51:"F:\wwwroot\ypcms\app\admin\view\public\success.html";i:1654646145;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>系统提示</title>
	<link rel="stylesheet" href="/static/src/layui/css/layui.css" media="all">
	<style>
.site-idea{margin: 150px 0; font-size: 0; text-align: center; font-weight: 300;}
.site-idea li{display: inline-block; vertical-align: top; *display: inline; *zoom:1; font-size: 14px;background: white;}
.site-idea li{width: 298px; height: 184px; padding: 30px; line-height: 24px; margin-left: 30px; border: 1px solid #d2d2d2; text-align: left;}
.site-idea li:first-child{margin-left: 0}
.site-idea .layui-field-title{border:none;}
.site-idea .layui-field-title legend{margin: 0 20px 20px 0; padding: 0 20px;}
.jump{margin-top: 20px; text-align: center;}
	</style>
</head>
<body bgcolor="#f6f6f6">
	<div class="layui-main">
		<ul class="site-idea">
		    <li>
		        <fieldset class="layui-elem-field layui-field-title">
		            <p align="center" style="color: #0a0;"><i class="layui-icon layui-icon-face-smile" style="font-size: 50px"></i></p>
		            <p align="center" style="line-height: 33px;color: #0a0;font-weight: bold;font-size: 22px;padding-top: 20px;"><?php echo htmlspecialchars($msg); ?></p>
		            <p class="jump">
		                <b id="wait"><?php echo htmlspecialchars($wait); ?></b> 秒后页面将自动跳转
		            </p>
		            <hr>
		            <p>
		                <a href="<?php echo htmlspecialchars($url); ?>" id="href" class="layui-btn layui-bg-red">立即跳转</a>
		            </p>
		        </fieldset>
		    </li>
		</ul> 
	</div>
	<script type="text/javascript">
	(function(){
	var wait = document.getElementById('wait'),href = document.getElementById('href').href;
	var interval = setInterval(function(){
		var time = wait.innerHTML;
		if(time <= 0) {
			location.href=href; clearInterval(interval);
			return false;
		};
		--wait.innerHTML
	}, 1000);
	})();
	</script>
</body>
</html>