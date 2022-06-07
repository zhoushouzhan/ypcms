<?php
$awesomecss = __DIR__ . DIRECTORY_SEPARATOR . 'static/src/font-awesome/css/font-awesome.css';
$con = file_get_contents($awesomecss);
preg_match_all('/\.(.*)\:before/U', $con, $rs);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>icon</title>
	<link rel="stylesheet" href="static/src/font-awesome/css/font-awesome.css">
	<style>
		ul{list-style: none;text-align: center;line-height: 50px;}
		li{float: left;width: 50px;height: 50px;font-size: 22px;color: #666;border-left:1px solid #ddd;box-sizing: border-box;border-top:1px solid #ddd; }
		li:hover{color: #333;cursor: pointer;border-left:1px solid #ddd;border-top:1px solid #ddd;background: #B2DCB1;}
	</style>
</head>
<body>
<div align="center">
		<h2>图标选择</h2>
	共<span id="nums">900</span>个
</div>

<ul>
<?php
foreach ($rs[1] as $key => $value) {
	?>
<li title="<?=$value?>"><i class="fa <?=$value?>"></i></li>
<?php
}
?>
</ul>

<script src="static/src/jquery/jquery.min.js"></script>
<script src="static/src/layui/layui.js"></script>
<script>
var layer= layui.layer;
	document.getElementById('nums').innerHTML='<?=$key?>';
	$("li").click(function(event) {
		/* Act on the event */
		var index = parent.layer.getFrameIndex(window.name)
		parent.$("#icon").val('fa '+$(this).attr('title'));
		parent.layer.close(index);
	});
</script>
</body>
</html>