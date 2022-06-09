<?php /*a:2:{s:48:"F:\wwwroot\ypcms\app\admin\view\index\index.html";i:1654646145;s:43:"F:\wwwroot\ypcms\app\admin\view\layout.html";i:1654652750;}*/ ?>
<!--
 * @Author: 一品网络技术有限公司
 * @Date: 2021-11-08 08:30:37
 * @LastEditTime: 2022-06-08 09:45:50
 * @FilePath: \ypcms\app\admin\view\layout.html
 * @Description:
 * 联系QQ:58055648
 * Copyright (c) 2022 by 东海县一品网络技术有限公司, All Rights Reserved.
-->
<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="UTF-8" />
    <title>后台管理</title>
    <meta name="renderer" content="webkit" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <link
      rel="stylesheet"
      href="/static/src/ckeditor/plugins/codesnippet/lib/highlight/styles/default.css?v=<?php echo time(); ?>"
    />
    <link
      rel="stylesheet"
      href="/static/src/layui/css/layui.css"
      media="all"
    />
    <link rel="stylesheet" href="/static/fonts/remixicon.css" />
    <link rel="stylesheet" href="/admin/css/admin.css?v=<?php echo time(); ?>" />
    
  </head>
  <body oncontextmenu="self.event.returnValue=false" onselect="return false">
    <div class="layui-layout layui-layout-admin">
      <!--头部-->
      <div class="layui-header">
        <a href="<?php echo url('admin/index/index'); ?>"
          ><img
            class="logo"
            src="/static/admin/images/admin_logo.png"
            alt=""
        /></a>
        <ul class="layui-nav otherItem">
          <li class="layui-nav-item">
            <a href="<?php echo htmlspecialchars($site['siteurl']); ?>" target="_blank"
              ><i class="ri-home-line"></i> 前台</a
            >
          </li>
          <li class="layui-nav-item">
            <a href="" data-url="<?php echo url('admin/api/clear'); ?>" id="clear-cache"
              ><i class="ri-refresh-line"></i> 清缓存</a
            >
          </li>
          <li class="layui-nav-item">
            <a href="javascript:;"
              ><i class="ri-user-line"></i> <?php echo htmlspecialchars($admin['username']); ?></a
            >
            <dl class="layui-nav-child">
              <dd>
                <a href="<?php echo url('admin/change_password/index'); ?>" class="toypbox"
                  >修改密码</a
                >
              </dd>
              <dd>
                <a href="<?php echo url('admin/login/logout'); ?>" class="ajax-logout"
                  >退出登录</a
                >
              </dd>
            </dl>
          </li>
        </ul>
        <ul class="layui-nav sysItem">
          <?php if(is_array($menu) || $menu instanceof \think\Collection || $menu instanceof \think\Paginator): if( count($menu)==0 ) : echo "" ;else: foreach($menu as $key=>$vo): ?>
          <li class="layui-nav-item<?php echo $vo['current']==1 ? ' layui-this' : ''; ?>">
            <a
              nav-href="<?php echo url('admin/api/getTree',['pid'=>$vo['id'],'sid'=>$vo['sid']]); ?>"
              ><i class="<?php echo htmlspecialchars($vo['icon']); ?>"></i> <?php echo htmlspecialchars($vo['title']); ?></a
            >
          </li>
          <?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
      </div>
      <!--侧边导航-->
      <div class="layui-side layui-bg-black">
        <div class="layui-side-scroll">
          <ul class="layui-nav layui-nav-tree" id="sideTree">
            <?php if($childMenu): if(is_array($childMenu['children']) || $childMenu['children'] instanceof \think\Collection || $childMenu['children'] instanceof \think\Paginator): if( count($childMenu['children'])==0 ) : echo "" ;else: foreach($childMenu['children'] as $key=>$vo): if($vo['children']): ?>
            <li class="layui-nav-item<?php echo $vo['current']==1 ? ' layui-nav-itemed' : ''; ?>">
              <a href="javascript:;"><i class="<?php echo htmlspecialchars($vo['icon']); ?>"></i> <?php echo htmlspecialchars($vo['title']); ?></a>
              <dl class="layui-nav-child">
                <?php if(is_array($vo['children']) || $vo['children'] instanceof \think\Collection || $vo['children'] instanceof \think\Paginator): if( count($vo['children'])==0 ) : echo "" ;else: foreach($vo['children'] as $key=>$vs): ?> <?php echo getChildMenu($vs,0); ?>
                <?php endforeach; endif; else: echo "" ;endif; ?>
              </dl>
            </li>
            <?php else: ?>
            <li class="layui-nav-item<?php echo $vo['current']==1 ? ' layui-this' : ''; ?>">
              <a href="<?php echo htmlspecialchars($vo['name']); ?>"><i class="<?php echo htmlspecialchars($vo['icon']); ?>"></i> <?php echo htmlspecialchars($vo['title']); ?></a>
            </li>
            <?php endif; ?> <?php endforeach; endif; else: echo "" ;endif; ?> <?php endif; ?>
          </ul>
        </div>
      </div>
      <div class="layui-body" id="pageBody">
        <iframe
          src="<?php echo url('admin/index/welcome'); ?>"
          frameborder="0"
          class="yp-iframe"
          id="ypbox"
        ></iframe>
      </div>
      <div class="layui-clear"></div>
    </div>
    <!--JS引用-->
    <script src="/static/src/jquery/jquery.min.js"></script>
    <script src="/static/src/jquery/jquery.cookie.min.js"></script>
    <script src="/static/src/layui/layui.js?v=<?php echo time(); ?>"></script>
    <script src="/static/src/plupload/plupload.js?v=<?php echo time(); ?>"></script>
    <script src="/static/src/ckeditor/ckeditor.js?v=<?php echo time(); ?>"></script>
    <script src="/static/src/ckeditor/plugins/codesnippet/lib/highlight/highlight.pack.js?v=<?php echo time(); ?>"></script>
    <script src="/static/admin/js/admin.js?v=<?php echo time(); ?>"></script>
    <script src="/static/admin/js/jump.js?v=<?php echo time(); ?>"></script>
    
  </body>
</html>
