<?php /*a:2:{s:50:"F:\wwwroot\ypcms\app\setup\view\index\jiancha.html";i:1654646145;s:41:"F:\wwwroot\ypcms\app\setup\view\base.html";i:1654646145;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>一品内容管理系统 - 安装</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="stylesheet" href="/static/src/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/static/src/font-awesome/css/font-awesome.min.css">
    <style>
        body{background:#06041A;padding-top: 150px;}
        .yp-content{width: 1005px; margin:0 auto;background:white;border-radius: 5px;}
        .yp-box{}
        .yp-box:after{clear: both;content: '.';display: block;width: 0;height: 0;visibility: hidden;}
        .menuBox{float: left;width: 220px;height: 100%;padding-left: 15px;}
        .menuBox ul li{text-align: center;height: 50px;line-height: 50px;border-bottom: 1px solid #ddd;color: #333;}
        .menuBox ul li.on{font-weight: bold;color: #f00;}
        .menuBox .logo{text-align: center;font-size: 26px;padding: 30px 0 15px 0;color: #333;}
        .rightBox{width: 768px;height: 100%;float: right;}
        .xieyi{height:100%;font-size: 16px; line-height: 26px;padding: 15px;background: white;overflow-y: auto;}
        .xieyi h2{text-align: center;padding: 22px 0;}
        .xieyi p{text-indent: 2em;}
        .huanjing{padding: 15px;}
        .installing{background: gray;padding: 50px 15px;border-radius: 5px;}
        .nextBtn{margin-top: 10px; padding-left: 18px;}
        .oversql {}
        .oversql .icon{font-size: 2em; color: #e00;}
        .oversql .icon span{line-height: 36px;display: inline-block;float: left;}
        .oversql .icon span i{font-size: 2em;}
        .oversql .tips{font-size: 22px;padding: 15px 0;}
        .oversql .info{font-size: 22px;color: red;line-height: 40px;}
        .footer{text-align: center;padding: 15px 0;border-top:1px solid #ccc;margin-top: 30px;}
    </style>
    <!--[if lt IE 9]>
    <script src="__ADMINDST__/js/html5shiv.min.js"></script>
    <script src="__ADMINDST__/js/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <div class="yp-content">
        <div class="yp-box">
            <div class="menuBox">
                <div class="logo">YPCMS</div>
                <ul>
                    <li<?php if($set==1): ?> class="on"<?php endif; ?>>一、许可协议</li>
                    <li<?php if($set==2): ?> class="on"<?php endif; ?>>二、环境检测</li>
                    <li<?php if($set==3): ?> class="on"<?php endif; ?>>三、参数配置</li>
                    <li<?php if($set==4): ?> class="on"<?php endif; ?>>四、开始安装</li>
                    <li<?php if($set==5): ?> class="on"<?php endif; ?>>五、完成安装</li>
                </ul>
            </div>
            <div class="rightBox">

                
<div class="huanjing">
<blockquote class="layui-elem-quote">检测运行环境</blockquote>
<table class="layui-table">
  <tbody>
  	<tr class="layui-bg-cyan">
  		<td width="100">项目</td>
  		<td width="200">一品CMS所需配置</td>
  		<td>当前服务器配置</td>
  		<td width="100">检测结果</td>
  	</tr>
    <tr>
      <td>操作系统</td>
      <td>不限制</td>
      <td><?php echo htmlspecialchars($config['server_os']); ?></td>
      <td><span class="layui-badge layui-bg-green">通过</span></td>
    </tr>
    <tr>
      <td>PHP版本</td>
      <td>>=5.6</td>
      <td><?php echo htmlspecialchars($config['php_version']); ?></td>
      <td><?php if($config['php_version']>=5.6): ?><span class="layui-badge layui-bg-green">通过</span><?php else: ?><span class="layui-badge layui-bg-red">未通过</span><?php endif; ?></td>
    </tr>
    <tr>
      <td>MySql支持</td>
      <td>必须</td>
      <td><?php echo htmlspecialchars($config['mysql']); ?></td>
      <td><?php if($config['mysql']): ?><span class="layui-badge layui-bg-green">通过</span><?php else: ?><span class="layui-badge layui-bg-red">未通过</span><?php endif; ?></td>
    </tr>

    <tr>
      <td>网站空间</td>
      <td>>=100M</td>
      <td><?php echo htmlspecialchars($config['disk_size']); ?>M</td>
      <td><?php if($config['disk_size']>=100): ?><span class="layui-badge layui-bg-green">通过</span><?php else: ?><span class="layui-badge layui-bg-red">未通过</span><?php endif; ?></td>

    </tr>
    <tr>
      <td>附件上传</td>
      <td>>=2M</td>
      <td><?php echo htmlspecialchars($config['max_upload_size']); ?></td>
      <td><?php if($config['max_upload_size']>=2): ?><span class="layui-badge layui-bg-green">通过</span><?php else: ?><span class="layui-badge layui-bg-red">未通过</span><?php endif; ?></td>
    </tr>
    <tr>
      <td>GD库</td>
      <td>必须</td>
      <td><?php echo htmlspecialchars($config['gd']); ?></td>
      <td><?php if($config['gd']): ?><span class="layui-badge layui-bg-green">通过</span><?php else: ?><span class="layui-badge layui-bg-red">未通过</span><?php endif; ?></td>
    </tr>
  </tbody>
</table>
<blockquote class="layui-elem-quote">检测目录权限</blockquote>
<table class="layui-table">
  <tbody>
  	<tr class="layui-bg-cyan">
  		<td width="100">目录文件名称</td>
  		<td width="200">说明</td>
  		<td>所需状态</td>
  		<td width="100">当前状态</td>
  	</tr>
  	<?php if(is_array($dirItems) || $dirItems instanceof \think\Collection || $dirItems instanceof \think\Paginator): $i = 0; $__LIST__ = $dirItems;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
    <tr>
      <td><?php echo htmlspecialchars($v[3]); ?></td>
      <td><?php echo htmlspecialchars($v[4]); ?></td>
      <td>可写</td>
      <td><?php if($v[1]=='可写'): ?><span class="layui-badge layui-bg-green">通过</span><?php else: ?><span class="layui-badge layui-bg-red">未通过</span><?php endif; ?></td>
    </tr>
	<?php endforeach; endif; else: echo "" ;endif; ?>

  </tbody>
</table>
<blockquote class="layui-elem-quote">依懒扩展组件</blockquote>
<table class="layui-table">
  <tbody>
  	<tr class="layui-bg-cyan">
  		<td width="100">名称</td>
  		<td width="200">类型</td>
  		<td>所需状态</td>
  		<td width="100">当前状态</td>
  	</tr>
  	<?php if(is_array($needfuns) || $needfuns instanceof \think\Collection || $needfuns instanceof \think\Paginator): $i = 0; $__LIST__ = $needfuns;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
    <tr>
      <td><?php echo htmlspecialchars($v[0]); ?></td>
      <td><?php echo htmlspecialchars($v[3]); ?></td>
      <td>支持</td>
      <td><?php if($v[1]=='支持'): ?><span class="layui-badge layui-bg-green">通过</span><?php else: ?><span class="layui-badge layui-bg-red">未通过</span><?php endif; ?></td>
    </tr>
	<?php endforeach; endif; else: echo "" ;endif; ?>

  </tbody>
</table>

</div>
<div class="nextBtn">
  <a href="/setup.php/index/setconfig.html" class="layui-btn">下一步</a>
  <a href="javascript:history.go(-1)" class="layui-btn layui-btn-primary">返回上一步</a>
</div>


               
            </div>
        </div>



        <div class="footer">
           <p>2016-<?php echo date('Y'); ?> &copy; <a href="http://www.yipinjishu.com" target="_blank">一品网络技术有限公司</a></p>
        </div>
    </div>

<script src="/static/src/layui/layui.js?t=<?php echo time(); ?>"></script>
<script language="javascript">
layui.use(['layer', 'form','element'], function(){
    var $=layui.jquery,layer = layui.layer,form = layui.form,element = layui.element;
    
    $(".layui-ajax").click(function(event) {
        $.ajax({
            url: $("form").attr('action'),
            type: 'POST',
            dataType: 'json',
            data: $("form").serialize(),
        })
        .done(function(res) {
            if(res.code==1){
                var index=layer.alert(res.msg,{icon:1},function(r){
                    window.location.href=res.url;
                });
            }else{
                layer.alert(res.msg, {icon: 2}); 
            }
        })
        .fail(function() {
            console.log("error");
        });
        return false;  
    });

});
function closewin() {
    if (confirm("您确定要关闭本页吗？")) {
        window.location.href="about:blank";
        window.close();
    } else {}
}
</script>
</body>
</html>