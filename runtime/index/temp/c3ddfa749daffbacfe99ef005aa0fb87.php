<?php /*a:3:{s:45:"F:\wwwroot\ypcms\view/pc\index\user\edit.html";i:1654646150;s:42:"F:\wwwroot\ypcms\view/pc\index\layout.html";i:1654683557;s:45:"F:\wwwroot\ypcms\view/pc\index\user\menu.html";i:1654646150;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <title>修改资料 - <?php echo htmlspecialchars($site['sitename']); ?></title>
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

<div class="ad layui-main mt10"></div>
<div class="userpage layui-main">
    <div class="user-left">
      <div class="userpic">
    <a href="<?php echo url('index/user/index'); ?>"><img src="<?php echo htmlspecialchars((isset($user['fileUserpic']['filepath']) && ($user['fileUserpic']['filepath'] !== '')?$user['fileUserpic']['filepath']:"/static/images/nouserpic.gif")); ?>"></a>
    <div class="text" id="upuserpic" data-id="<?php echo htmlspecialchars($user['userpic']); ?>">更换头像</div>
</div>
<div class="username">
<p><?php echo htmlspecialchars($user['nickname']); ?></p>
<p>ID：<?php echo htmlspecialchars($user['id']); ?></p>
</div>
<div class="cert">
    <div data-title="VIP会员" data-xy="1"<?php if($user['id_card']): ?> class="on"<?php endif; ?>><i class="layui-icon">&#xe612;</i></div>
    <div data-title="手机认证" data-xy="3"<?php if($user['mobile']): ?> class="on"<?php endif; ?>><i class="layui-icon">&#xe63b;</i></div>
    <div data-title="邮箱认证" data-xy="1"<?php if($user['email']): ?> class="on"<?php endif; ?>><i class="layui-icon">&#xe618;</i></div>
    <div data-title="关注公众号" data-xy="4"<?php if($user['epassword']): ?> class="on"<?php endif; ?>><i class="layui-icon">&#xe673;</i></div>
</div>
<ul class="layui-nav layui-nav-tree" lay-filter="usermenu">
    <li class="layui-nav-item layui-nav-itemed">
        <a href="javascript:;">管理菜单</a>
        <dl class="layui-nav-child">
            <dd><a href="<?php echo url('index/user/edit'); ?>">修改资料</a></dd>
            <dd><a href="<?php echo url('index/user/changePass'); ?>">修改密码</a></dd>
            <dd><a href="<?php echo url('index/user/setMobile'); ?>">手机认证</a></dd>
            <dd><a href="<?php echo url('index/user/setEmail'); ?>">邮箱认证</a></dd>
            <dd><a href="<?php echo url('index/user/favorites'); ?>">收藏管理</a></dd>
        </dl>
    </li>
    <li class="layui-nav-item layui-nav-itemed">
        <a href="javascript:;">财务中心</a>
        <dl class="layui-nav-child">
            <dd><a href="<?php echo url('index/user/buygroup'); ?>">购买会员组</a></dd>
            <dd><a href="<?php echo url('index/user/order'); ?>">我的订单</a></dd>
        </dl>
    </li>
    <li class="layui-nav-item">
        <a href="<?php echo url('index/login/loginout'); ?>" class="ajax_url">安全退出</a>
    </li>
</ul>
    </div>
	<div class="user-main">
		<div class="layui-tab layui-tab-brief">
		    <ul class="layui-tab-title">
		        <li class="layui-this">修改资料</li>
		    </ul>
		    <div class="layui-tab-content">
		        <form class="layui-form" action="<?php echo url('update'); ?>" method="post">
		            <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">
		            <div class="layui-form-item">
		                <label class="layui-form-label">用户名</label>
		                <div class="layui-input-inline">
		                    <input type="text" name="username" class="layui-input" value="<?php echo htmlspecialchars($user['username']); ?>" <?php if($user['username']!=''): ?> disabled="" <?php endif; ?>>
		                </div>
		            </div>
		            <div class="layui-form-item">
		                <label class="layui-form-label">昵称</label>
		                <div class="layui-input-inline">
		                    <input type="text" name="nickname" class="layui-input" value="<?php echo htmlspecialchars($user['nickname']); ?>">
		                </div>
		            </div>
		            <div class="layui-form-item">
		                <div class="layui-input-block">
		                    <button class="layui-btn layui-bg-red" lay-submit lay-filter="*">立即提交</button>
		                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
		                </div>
		            </div>
		        </form>
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