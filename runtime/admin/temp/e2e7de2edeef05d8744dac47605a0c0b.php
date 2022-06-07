<?php /*a:2:{s:48:"F:\wwwroot\ypcms\app\admin\view\admin\index.html";i:1652509708;s:41:"F:\wwwroot\ypcms\app\admin\view\base.html";i:1636685215;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>后台管理</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="stylesheet" href="/static/src/ckeditor/plugins/codesnippet/lib/highlight/styles/default.css">
    <link rel="stylesheet" href="/static/src/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/static/src/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/static/admin/css/admin.css?v=<?php echo time(); ?>">
    
</head>
<body oncontextmenu="self.event.returnValue=false" onselect="return false">
<div class="layui-layout layui-layout-admin">
    
    <div class="layui-main" id="pageBody">
        <div class="cbtn">
            <a href="javascript:window.location.reload();" title="刷新" class="layui-btn layui-bg-blue layui-btn-sm fr"><i class="layui-icon layui-icon-refresh"></i> 刷新</a>
            <a href="javascript:window.history.back();" title="刷新" class="layui-btn layui-bg-black layui-btn-sm fr mr"><i class="layui-icon layui-icon-return"></i> 返回</a>
        </div>
        
<div class="layui-tab layui-tab-brief">
  <ul class="layui-tab-title">
    <li class="layui-this">用户列表</li>
    <li><a href="<?php echo url('add'); ?>">添加用户</a></li>
  </ul>
  <div class="layui-tab-content">
    <div class="layui-tab-item layui-show">
      <form action="<?php echo url('index'); ?>" action="get" class="layui-form">
        <div class="demoTable">
          关键词：
          <div class="layui-inline">
            <input
              class="layui-input"
              name="keyboard"
              id="keyboard"
              autocomplete="off"
            />
          </div>
          <button class="layui-btn">搜索</button>
        </div>
      </form>

      <form action="" class="layui-form">
        <table class="layui-table">
          <colgroup>
            <col width="35" />
          </colgroup>

          <thead>
            <tr>
              <th></th>
              <th style="width: 30px">ID</th>
              <th>账号</th>
              <th>姓名</th>
              <th>手机号</th>
              <th>用户组</th>
              <th>状态</th>
              <th>更新时间</th>
              <th>操作</th>
            </tr>
          </thead>
          <tbody>
            <?php if(is_array($dataList) || $dataList instanceof \think\Collection || $dataList instanceof \think\Paginator): if( count($dataList)==0 ) : echo "" ;else: foreach($dataList as $key=>$vo): ?>
            <tr>
              <td class="selectId">
                <input type="checkbox" name="id[]" value="<?php echo htmlspecialchars($vo['id']); ?>"
                lay-skin="primary"<?php if($vo['id']==1): ?> disabled<?php endif; ?>>
              </td>
              <td><?php echo htmlspecialchars($vo['id']); ?></td>
              <td><?php echo htmlspecialchars($vo['username']); ?></td>
              <td><?php echo (isset($vo['truename']) && ($vo['truename'] !== '')?$vo['truename']:"/"); ?></td>
              <td><?php echo htmlspecialchars($vo['mobile']); ?></td>
              <td>
                <?php if(is_array($vo['roles']) || $vo['roles'] instanceof \think\Collection || $vo['roles'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['roles'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                <span class="layui-badge layui-bg-blue"><?php echo htmlspecialchars($v['title']); ?></span>
                <?php endforeach; endif; else: echo "" ;endif; ?>
              </td>

              <td><?php echo $vo['status']==1 ? '启用' : '关闭'; ?></td>

              <td><?php echo htmlspecialchars($vo['update_time']); ?></td>
              <td>
                <a
                  href="<?php echo url('edit',['id'=>$vo['id']]); ?>"
                  class="layui-btn layui-btn-normal layui-btn-sm"
                  >编辑</a
                >
                <a
                  href="<?php echo url('delete',['id'=>$vo['id']]); ?>"
                  class="layui-btn layui-btn-danger layui-btn-sm ajax-delete"
                  >删除</a
                >
              </td>
            </tr>
            <?php endforeach; endif; else: echo "" ;endif; ?>
          </tbody>

          <tfoot>
            <tr>
              <td>
                <input
                  type="checkbox"
                  lay-skin="primary"
                  lay-filter="chooseAll"
                />
              </td>
              <td colspan="11">
                <button
                  type="submit"
                  class="layui-btn layui-btn-danger layui-btn-sm"
                  lay-submit
                  lay-filter="deleteAll"
                >
                  批量删除
                </button>
              </td>
            </tr>
          </tfoot>
        </table>
      </form>

      <?php echo $dataList->render(); ?>
    </div>
  </div>
</div>

    </div>
    
</div>
<!--JS引用-->
<script src="/static/src/jquery/jquery.min.js"></script>
<script src="/static/src/jquery/jquery.cookie.min.js"></script>
<script src="/static/src/layui/layui.js"></script>
<script src="/static/src/plupload/plupload.js?v=<?php echo time(); ?>"></script>
<script src="/static/src/ckeditor/ckeditor.js?v=<?php echo time(); ?>"></script>
<script src="/static/src/ckeditor/plugins/codesnippet/lib/highlight/highlight.pack.js?v=<?php echo time(); ?>"></script>




<script src="/static/admin/js/admin.js?v=<?php echo time(); ?>"></script>
<script src="/static/admin/js/jump.js?v=<?php echo time(); ?>"></script>

</body>
</html>