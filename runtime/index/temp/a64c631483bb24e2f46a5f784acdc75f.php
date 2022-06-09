<?php /*a:2:{s:49:"F:\wwwroot\ypcms\view/pc\index\user\register.html";i:1654646150;s:42:"F:\wwwroot\ypcms\view/pc\index\layout.html";i:1654683557;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <title>用户注册 - <?php echo htmlspecialchars($site['sitename']); ?></title>
    <meta name="keywords" content="<?php echo htmlspecialchars($site['keyword']); ?>" />
    <meta name="description" content="<?php echo htmlspecialchars($site['description']); ?>" />
    <meta http-equiv="Access-Control-Allow-Origin" content="*" />
    <link rel="stylesheet" href="/static/src/layui/css/layui.css">

    <link rel="stylesheet" href="/static/src/ckeditor/plugins/codesnippet/lib/highlight/styles/foundation.css">
    <link rel="stylesheet" href="/static/default/css/style.css?v=<?php echo time(); ?>">
    
</head>
<body>
<div class="top-bar">
    <div class="layui-main">
        <div class="toplogin fl">

        <?php if(app('request')->session('userid')): ?>
        <span>您好，<?php if($user['username']): ?><?php echo htmlspecialchars($user['username']); elseif($user['email']): ?><?php echo htmlspecialchars($user['email']); elseif($user['mobile']): ?><?php echo htmlspecialchars($user['mobile']); ?><?php endif; ?>，<a href="<?php echo url('index/user/index'); ?>">会员中心</a>，<a href="<?php echo url('index/login/loginout'); ?>" class="ajax_url">退出</a></span>
        <?php else: ?>
           <ul>
                <li class="h">
                    <a href="<?php echo url('index/login/index'); ?>">登录</a>
                </li>
                <li><a href="<?php echo url('index/register/index'); ?>">注册</a></li>
           </ul>

        <?php endif; ?>
        </div>
        <div class="olink fr">
            <a href="">站内公告 <span class="layui-badge">61728</span></a>
            <span class="yline">|</span>
            <a href="">关于我们</a>
            <span class="yline">|</span>
            <a href="">帮助中心</a>
            <span class="yline">|</span>
            <a href="">联系我们</a>
        </div>
    </div>
</div>
<div class="head layui-main">
    <div class="logo">
        <a href="<?php echo url('index/index/index'); ?>">一品内容管理系统</a>
    </div>
    <div class="search">
        <form class="layui-form" action="<?php echo url('index/search/index'); ?>" method="get" style="width: 511px;float: right;margin-top: 10px;">
          <div class="layui-form-item">
            <div class="layui-input-inline" style="width: 300px;">
              <input type="text" name="keywords" required  lay-verify="required" placeholder="请输入关键词" autocomplete="off" class="layui-input">
            </div>


            <div class="layui-input-inline" style="width: 66px;">
                <button class="layui-btn layui-btn-primary" lay-submit lay-filter="search">搜索</button>
            </div>
          </div>
        </form>
    </div>
</div>
<nav class="menu layui-main">
    <ul class="nav">
        <li<?php if(!$category_id): ?> class="current"<?php endif; ?>><a href="<?php echo url('index/index/index'); ?>">首页</a></li>
        <?php if(is_array($nav) || $nav instanceof \think\Collection || $nav instanceof \think\Paginator): $i = 0; $__LIST__ = $nav;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
        <li<?php if($vo['current']==1): ?> class="current"<?php endif; ?>>
            <a href="<?php echo htmlspecialchars($vo['url']); ?>"><?php echo htmlspecialchars($vo['title']); ?></a>
            <?php if($vo['children']): ?>
            <ul>
                <?php if(is_array($vo['children']) || $vo['children'] instanceof \think\Collection || $vo['children'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['children'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vs): $mod = ($i % 2 );++$i;?>
                <?php echo getChildMenu($vs,0); ?>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
            <?php endif; ?>
        </li>
        <?php endforeach; endif; else: echo "" ;endif; ?>
    </ul>
</nav>

<div class="register">
	<div class="layui-main">
		<div class="login-ad"></div>
		<div class="login-form">
			<div class="layui-tab layui-tab-brief regtab">
			  <ul class="layui-tab-title">
			    <li class="layui-this">注册</li>
			    <li><a href="<?php echo url('index/login/index'); ?>">登录</a></li>
			  </ul>
			  <div class="layui-tab-content">
			    <div class="layui-tab-item layui-show">
			        <form action="<?php echo url('index/register/index'); ?>" method="post" class="layui-form">
			            <div class="reg">
			                <div class="mobile">
			                    <input type="text" maxlength="60" name="sender" id="sender" lay-verify="required" placeholder="请输入手机号或邮箱">
			                </div>
			                <div class="checkcode">
			                    <input type="text" maxlength="6" name="regkey" lay-verify="number" placeholder="验证码">
			                    <button type="button" class="layui-btn layui-bg-red getPhoneCode" data-url="<?php echo url('api/getCode'); ?>">免费获取验证码</button>
			                </div>
			                <div class="pass">
			                    <input type="text" maxlength="16" name="password" onfocus="this.type='password'" placeholder="密码 （6-16位字符，区分大小写）">
			                </div>
			                <div class="pass">
			                    <input type="text" maxlength="16" name="repassword" onfocus="this.type='password'" placeholder="确认密码">
			                </div>
			                <div class="yinsi">
			                    <input type="checkbox" name="xieyi" title="同意" lay-skin="primary" lay-filter="rengke" lay-verify="otherReq">
			                    《<a href="javascript:;">笨鸟先飞注册协议</a>》和《<a href="javascript:;">隐私政策</a>》
			                </div>
			                <div class="regbtn">
			                    <button type="button" lay-submit lay-filter="register" class="layui-btn layui-bg-gray layui-btn-fluid layui-btn-radius layui-btn-disabled">注册</button>
			                </div>
			            </div>
			        </form>
			    </div>
			  </div>
			</div>
		</div>
	</div>
</div>

<div class="footer">
    <div class="layui-main">
    <div class="link">
        <?php $_result=model('article');if(is_array($_result) || $_result instanceof \think\Collection || $_result instanceof \think\Paginator): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
        <a href="<?php echo url('index/article/read',['category_id'=>$vo['category_id'],'id'=>$vo['id']]); ?>"><?php echo htmlspecialchars($vo['title']); ?></a>
        <?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
    <div class="copyright">
        <p>&copy;&nbsp;2020&nbsp;bnxf.net&nbsp;&nbsp;<a href="http://beian.miit.gov.cn/" target="_blank"><?php echo htmlspecialchars($site['icpnumber']); ?></a></p>
    </div>

    <div class="weibox">
        <div class="l" id="qq">
            <div class="qqqr"><a target="_blank" href="//shang.qq.com/wpa/qunwpa?idkey=fd461985e36ab9428dd899dcba5f9bc52505d8632b045bf974968f5db6518465"><img src="/static/default/images/qqqqr.png" alt=""></a></div>
            <div class="wlo">
                <i class="fa fa-qq"></i>
            </div>
            <p>QQ群</p>
        </div>
        <div class="l" id="wx">
            <div class="wxqr"><img src="/static/default/images/wxqqr.jpg" alt=""></div>
            <div class="wlo">
                <i class="fa fa-weixin"></i>
            </div>
            <p>微信群</p>
        </div>
    </div>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="/static/src/layui/layui.js"></script>
<script src="/static/src/ckeditor/plugins/codesnippet/lib/highlight/highlight.pack.js?v=<?php echo time(); ?>"></script>
<script src="/static/src/ckeditor/plugins/codesnippet/lib/highlight/highlightjs-line-numbers.js"></script>
<script src="/static/default/js/base.js"></script>


</body>
</html>