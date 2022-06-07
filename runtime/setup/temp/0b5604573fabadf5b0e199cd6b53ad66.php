<?php /*a:2:{s:48:"F:\wwwroot\ypcms\app\setup\view\index\index.html";i:1589588449;s:41:"F:\wwwroot\ypcms\app\setup\view\base.html";i:1589598701;}*/ ?>
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

                
<div class="xieyi">
<h2>《一品内容管理系统》 用户协议</h2>
<p>版权所有 (c) 2016~<?php echo date('Y'); ?>，东海县一品网络技术有限公司。</p>
<p>感谢您选择一品内容管理系统（以下简称YPCMS），希望我们的努力能为您提供一个极简、极致、极速的PHP快速开发解决方案。</p>
<p>用户须知：本协议是您与东海县一品网络技术有限公司（以下简称一品网络）之间关于您使用YPCMS产品及服务的法律协议。无论您是个人还是组织、用途如何（包括以学习和研究为目的），均需仔细阅读本协议。请您审阅并接受或不接受本服务条款。如您不接受本服务条款，您应不使用或主动取消YPCMS产品。否则，您的任何对一品CMS的相关服务的注册、登陆、下载、查看等使用行为将被视为您对本服务条款全部接受。</p>
<p>本服务条款一旦发生变更, 一品网络将在产品官网上公布修改内容。修改后的服务条款一旦在网站公布即有效代替原来的服务条款。您可随时登陆官网查阅最新版服务条款。如果您接受本条款，即表示您接受协议各项条件的约束。如果您不同意本服务条款，则不能获得使用本服务的权利。您若有违反本条款规定，一品网络有权随时中止或终止您对YPCMS产品的使用资格并保留追究相关法律责任的权利。</p>
<p>在理解、同意、并遵守本协议的全部条款后，方可开始使用YPCMS产品。您也可能与一品网络直接签订另一书面协议，以补充或者取代本协议的全部或者部分。</p>
<p>一品网络拥有YPCMS的全部知识产权，包括商标和著作权。本软件只供许可协议，并非出售。一品网络只允许您在遵守本协议各项条款的情况下复制、下载、安装、使用或者以其他方式受益于本软件的功能或者知识产权。</p>
<p>个人非商业用途可免费使用（但不包括其衍生产品、插件或者服务），也可以根据个人实际情况选择是否购买授权。</p>
<p>非个人用户（泛指非个人的团体，如企业、政府单位、教育机构、协会团体、厂矿、工作室等）必须购买软件授权后方可使用。</p>
<p>您可以在协议规定的约束和限制范围内修改YPCMS以适应您的网站要求，但免费版必须保留软件版本信息的正常显示及相关连接正常。</p>
<p>禁止去除YPCMS源码里的版权信息，商业授权版本可去除后台界面及前台界面的相关版权信息。</p>
<p>禁止在YPCMS整体或任何部分基础上发展任何派生版本、修改版本或第三方版本用于重新分发。</p>
<p>未经官方许可，不得对本软件或与之关联的商业授权进行出租、出售、抵押或发放子许可证。</p>
</div>
<div class="nextBtn">
	<a href="/setup.php/index/jiancha.html" class="layui-btn">接受</a>
	<button type="button" class="layui-btn layui-btn-danger" onclick="closewin();">不接受</button>
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