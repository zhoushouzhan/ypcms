<?php /*a:2:{s:51:"F:\wwwroot\ypcms\view/pc\index\article\content.html";i:1654681008;s:42:"F:\wwwroot\ypcms\view/pc\index\layout.html";i:1654731769;}*/ ?>
<!--
 * @Author: 一品网络技术有限公司
 * @Date: 2022-06-08 07:55:50
 * @LastEditTime: 2022-06-09 07:42:31
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
    <title>首页 - <?php echo htmlspecialchars($site['sitename']); ?></title>
    <meta name="keywords" content="<?php echo htmlspecialchars($site['keyword']); ?>" />
    <meta name="description" content="<?php echo htmlspecialchars($site['description']); ?>" />
    <meta http-equiv="Access-Control-Allow-Origin" content="*" />
    <link rel="stylesheet" href="/static/src/layui/css/layui.css">

    <link rel="stylesheet" href="/static/src/ckeditor/plugins/codesnippet/lib/highlight/styles/foundation.css">
    <link rel="stylesheet" href="/static/default/css/style.css?v=<?php echo time(); ?>">
    
<style>
  .hljs-ln-numbers {
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;

    text-align: center;
    color: #ccc;
    vertical-align: top;
    padding-right: 5px;

    /* your custom style here */
  }

  /* for block of code */
  .hljs-ln-code {
    padding-left: 1em;
  }
</style>

</head>
<body>

<div class="head layui-main">
    <div class="logo">
        <a href="<?php echo url('index/index/index'); ?>">一品内容管理系统</a>
    </div>
    <div class="search">
        <form class="layui-form" action="<?php echo url('index/search/index'); ?>" method="get" style="width:390px;float: right;margin-top: 10px;">
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
<div class="path_info mt10 layui-main">
  当前位置：
  <span class="layui-breadcrumb">
    <a href="/">首页</a>
    <?php $_result=get_path_info($r['category_id']);if(is_array($_result) || $_result instanceof \think\Collection || $_result instanceof \think\Paginator): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
    <a href="<?php echo htmlspecialchars($vo['url']); ?>"><?php echo htmlspecialchars($vo['title']); ?></a>
    <?php endforeach; endif; else: echo "" ;endif; ?>
  </span>
</div>
<div class="article_content layui-main">
  <h1><?php echo htmlspecialchars($r['title']); ?></h1>
  <div class="info">
    <span>发布时间：<?php echo htmlspecialchars($r['create_time']); ?></span>
    <span>点击量：<?php echo htmlspecialchars($r['hits']); ?></span>
    <span>作者：<?php echo htmlspecialchars($r['author']); ?></span>
    <span>来源：<?php echo htmlspecialchars($r['source']); ?></span>
  </div>
  <div class="content">
    <?php echo $r['content']; if($r['price']): ?>
    <p class="need_money">本内容需支付 <?php echo htmlspecialchars($r['price']); ?>元 查看</p>
    <button class="layui-btn layui-bg-red layui-btn-fluid add_order">
      <i class="layui-icon">&#xe65e;</i> 点此支付
    </button>
    <?php endif; ?>
  </div>
  <hr />
  <div class="ctrl_btn">
    <button type="button" class="layui-btn layui-bg-red addfav">
      <i class="layui-icon"><?php if($r['isFav']): ?>&#xe68f;<?php else: ?>&#xe68c;<?php endif; ?></i>
    </button>
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


<script>
  $(".addfav").click(function (event) {
    $.ajax({
      url: '<?php echo url("index/user/addFavorites"); ?>',
      type: "POST",
      dataType: "json",
      data: { id: "<?php echo htmlspecialchars($r['id']); ?>", type: "Article" },
    })
      .done(function (res) {
        if (res.code == 1) {
          layer.msg(res.msg, { icon: 1 }, function () {
            window.location.reload();
          });
        } else {
          layer.msg(res.msg, { icon: 2 }, function () {
            window.location.reload();
          });
        }
      })
      .fail(function () {
        console.log("error");
      });
  });
  //购买
  $(".add_order").click(function (event) {
    $.ajax({
      url: '<?php echo url("index/order/add"); ?>',
      type: "POST",
      dataType: "json",
      data: { category_id: "<?php echo htmlspecialchars($r['category_id']); ?>", id: "<?php echo htmlspecialchars($r['id']); ?>" },
    })
      .done(function (res) {
        window.location.href = res.url;
      })
      .fail(function () {
        console.log("error");
      })
      .always(function () {
        console.log("complete");
      });
  });
  //代码高亮插件
  hljs.initHighlightingOnLoad();
  hljs.initLineNumbersOnLoad();
</script>

</body>
</html>