<?php /*a:2:{s:47:"F:\wwwroot\ypcms\app\setup\view\index\esql.html";i:1654646145;s:41:"F:\wwwroot\ypcms\app\setup\view\base.html";i:1654646145;}*/ ?>
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
	<blockquote class="layui-elem-quote">正在安装，请耐心等待~</blockquote>
	<div class="installing">
		<div class="layui-progress layui-progress-big" lay-filter="installprogress">
		  <div class="layui-progress-bar layui-progress-big layui-bg-red"></div>
		</div>
	</div>
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
    
dosql();

function dosql(i){
    $.ajax({
        url: '/setup.php/index/dosql.html',
        type: 'GET',
        dataType: 'json',
        data: {"i":i},
    })
    .done(function(res) {
        if(res.code){
            element.progress('installprogress', res.bili+'%');
            dosql(res.i);
        }else{
        element.progress('installprogress', res.bili+'%');
            layer.alert(res.msg, {icon: 1},function(){
                window.location.href='/setup.php/index/oversql.html';
            }); 
        }
    })
    .fail(function() {
        console.log("error");
    });
}

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