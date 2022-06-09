<?php /*a:2:{s:49:"F:\wwwroot\ypcms\view/pc\index\article\index.html";i:1654735318;s:42:"F:\wwwroot\ypcms\view/pc\index\layout.html";i:1654736262;}*/ ?>
<!--
 * @Author: 一品网络技术有限公司
 * @Date: 2022-06-08 07:55:50
 * @LastEditTime: 2022-06-09 08:57:42
 * @FilePath: \ypcms\view\pc\index\layout.html
 * @Description:
 * 联系QQ:58055648
 * Copyright (c) 2022 by 东海县一品网络技术有限公司, All Rights Reserved.
-->
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <title><?php echo htmlspecialchars($category['title']); ?> - <?php echo htmlspecialchars($site['sitename']); ?></title>
    <meta name="keywords" content="<?php echo htmlspecialchars($site['keyword']); ?>" />
    <meta name="description" content="<?php echo htmlspecialchars($site['description']); ?>" />
    <meta http-equiv="Access-Control-Allow-Origin" content="*" />
    <link rel="stylesheet" href="/static/src/layui/css/layui.css">

    <link rel="stylesheet" href="/static/src/ckeditor/plugins/codesnippet/lib/highlight/styles/foundation.css">
    <link rel="stylesheet" href="/static/default/css/style.css?v=<?php echo time(); ?>">
    
</head>
<body>

<div class="head layui-main">
    <div class="logo">
        <a href="<?php echo url('index/index/index'); ?>">一品内容管理系统</a>
    </div>
    <div class="search">
        <form class="layui-form" action="/article.html" method="get" style="width:390px;float: right;margin-top: 10px;">
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

<div class="ad layui-main mt10">ad</div>
<div class="path_info mt10 layui-main">
  当前位置：
  <span class="layui-breadcrumb">
    <a href="/">首页</a>
    <?php if(isset($category)): $_result=get_path_info($category->id);if(is_array($_result) || $_result instanceof \think\Collection || $_result instanceof \think\Paginator): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
    <a href="<?php echo htmlspecialchars($vo['url']); ?>"><?php echo htmlspecialchars($vo['title']); ?></a>
    <?php endforeach; endif; else: echo "" ;endif; else: ?>
    <a href=""><?php echo htmlspecialchars($mod['alias']); ?></a>
    <?php endif; ?>
  </span>
</div>
<div class="article">
  <div class="layui-main">
    <div class="h-box">
      <div class="h-tit"><?php echo htmlspecialchars($category['title']); ?></div>
    </div>
    <div class="h-con">
      <ul class="clearfix">
        <?php if(is_array($dataList) || $dataList instanceof \think\Collection || $dataList instanceof \think\Paginator): $i = 0; $__LIST__ = $dataList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
        <li>
          <div class="titlepic">
            <a href="<?php echo htmlspecialchars($vo['url']); ?>">
              <img
                src="<?php echo htmlspecialchars((isset($vo['thumb']['filepath']) && ($vo['thumb']['filepath'] !== '')?$vo['thumb']['filepath']:'/static/images/nopic.gif')); ?>"
              />
            </a>
          </div>
          <div class="info">
            <div class="tit">
              <a href="<?php echo htmlspecialchars($vo['category']['url']); ?>"><?php echo htmlspecialchars($vo['category']['title']); ?></a>-<a
                href="<?php echo htmlspecialchars($vo['url']); ?>"
                ><?php echo htmlspecialchars($vo['title']); ?></a
              >
            </div>
            <div class="smalltext"><?php echo htmlspecialchars(msubstr($vo['intro'],0,75)); ?></div>
            <div class="info-foot">
              <span>发布时间：<?php echo htmlspecialchars($vo['create_time']); ?></span>
              <span>浏览量：<?php echo htmlspecialchars($vo['hits']); ?></span>
            </div>
          </div>
        </li>
        <?php endforeach; endif; else: echo "" ;endif; ?>
      </ul>
    </div>
    <div class="pages"><?php echo $dataList->render(); ?></div>
  </div>
</div>

<div class="footer">
    <div class="layui-main">

    <div class="copyright">
        <p>&copy;&nbsp;2020&nbsp;bnxf.net&nbsp;&nbsp;<a href="http://beian.miit.gov.cn/" target="_blank"><?php echo htmlspecialchars($site['icpnumber']); ?></a></p>
    </div>


</div>
</div>

<script src="/static/src/layui/layui.js"></script>
<script src="/static/src/ckeditor/plugins/codesnippet/lib/highlight/highlight.pack.js?v=<?php echo time(); ?>"></script>
<script src="/static/src/ckeditor/plugins/codesnippet/lib/highlight/highlightjs-line-numbers.js"></script>
<script src="/static/default/js/base.js"></script>


</body>
</html>