<?php /*a:2:{s:51:"F:\wwwroot\ypcms\app\admin\view\listinfo\index.html";i:1653796203;s:41:"F:\wwwroot\ypcms\app\admin\view\base.html";i:1636685215;}*/ ?>
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
    
<style>
  .layui-form-checked[lay-skin="primary"] i {
    border: none;
    background: #0984bf;
  }
  .layui-form-checked[lay-skin="primary"] i:hover {
    border: none;
  }
</style>

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
    <li class="layui-this"><?php echo htmlspecialchars($category['title']); ?>列表</li>
    <li class="">
      <a href="<?php echo url('add',['category_id'=>$category['id']]); ?>">添加信息</a>
    </li>
  </ul>
  <div class="layui-tab-content">
    <?php if($searchCol): ?>
    <form action="<?php echo url('index'); ?>" action="get" class="layui-form">
      <input type="hidden" name="category_id" value="<?php echo htmlspecialchars($category['id']); ?>" />
      <?php if($enabled): ?>
      <input type="hidden" name="enabled" value="<?php echo htmlspecialchars(app('request')->param('enabled')); ?>" />
      <?php endif; ?>
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
        <div class="layui-inline">
          <select name="colName" id="colName">
            <?php if(is_array($searchCol) || $searchCol instanceof \think\Collection || $searchCol instanceof \think\Paginator): $i = 0; $__LIST__ = $searchCol;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
            <option value="<?php echo htmlspecialchars($v['name']); ?>"><?php echo htmlspecialchars($v['comment']); ?></option>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            <option value="0">搜索全部</option>
          </select>
        </div>
        <button class="layui-btn">搜索</button>
        <div class="fr">
          <?php if($enabled): if(is_array($enabled) || $enabled instanceof \think\Collection || $enabled instanceof \think\Paginator): $i = 0;$__LIST__ = is_array($enabled) ? array_slice($enabled,0,2, true) : $enabled->slice(0,2, true); if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
          <a
            href="<?php echo url('index',['enabled'=>$v['id'],'category_id'=>$category_id]); ?>"
            class="layui-btn <?php if(app('request')->param('enabled')==$v['id']): ?>layui-btn-danger<?php else: ?>layui-btn-primary<?php endif; ?>"
            ><?php echo htmlspecialchars($v['title']); ?></a
          >
          <?php endforeach; endif; else: echo "" ;endif; ?> <?php endif; ?>
        </div>
      </div>
    </form>
    <?php endif; ?>
    <form action="<?php echo url('index'); ?>" class="layui-form" action="get">
      <input type="hidden" name="category_id" value="<?php echo htmlspecialchars($category['id']); ?>" />
      <table class="layui-table">
        <colgroup>
          <col width="40" />
          <col width="40" />
          <?php if(is_array($listv) || $listv instanceof \think\Collection || $listv instanceof \think\Paginator): if( count($listv)==0 ) : echo "" ;else: foreach($listv as $key=>$v): ?>
          <col width="<?php echo htmlspecialchars($v['colw']); ?>" />
          <?php endforeach; endif; else: echo "" ;endif; ?>
          <col width="140" />
        </colgroup>
        <thead>
          <tr>
            <th>选择</th>
            <th>ID</th>
            <?php if(is_array($listv) || $listv instanceof \think\Collection || $listv instanceof \think\Paginator): if( count($listv)==0 ) : echo "" ;else: foreach($listv as $key=>$v): ?>
            <th><?php echo htmlspecialchars($v['comment']); ?></th>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            <th><div align="center">操作</div></th>
          </tr>
        </thead>
        <tbody>
          <?php if(is_array($dataList) || $dataList instanceof \think\Collection || $dataList instanceof \think\Paginator): if( count($dataList)==0 ) : echo "" ;else: foreach($dataList as $key=>$vo): ?>
          <tr>
            <td class="selectId">
              <input
                type="checkbox"
                name="id[]"
                lay-skin="primary"
                value="<?php echo htmlspecialchars($vo['id']); ?>"
              />
              <input type="hidden" name="enabled[]" value="<?php echo htmlspecialchars($vo['enabled']['id']); ?>" />
            </td>
            <td><?php echo htmlspecialchars($vo['id']); ?></td>
            <?php if(is_array($listv) || $listv instanceof \think\Collection || $listv instanceof \think\Paginator): if( count($listv)==0 ) : echo "" ;else: foreach($listv as $key=>$v): switch($v['name']): case "category": ?>
            <td><?php echo htmlspecialchars($vo[$v['name']]->title); ?></td>
            <?php break; case "admin": ?>
            <td><?php echo htmlspecialchars($vo[$v['name']]->username); ?></td>
            <?php break; case "title": ?>
            <td>
              <a href="<?php echo htmlspecialchars($vo['url']); ?>" target="_blank"
                ><?php echo htmlspecialchars($vo[$v['name']]); if($vo['thumb']): ?><i class="layui-icon"
                  >&#xe64a;</i
                ><?php endif; ?></a
              >
            </td>
            <?php break; case "enabled": ?>
            <td><?php echo htmlspecialchars($vo[$v['name']]['title']); ?></td>
            <?php break; case "recommend": ?>
            <td><?php echo htmlspecialchars($vo[$v['name']]['title']); ?></td>
            <?php break; default: if($v['formItem']=='select'): ?>
            <td><?php echo htmlspecialchars($vo[$v['name']]->pathInfo); ?></td>
            <?php else: ?>
            <td><?php echo htmlspecialchars($vo[$v['name']]); ?></td>
            <?php endif; ?> <?php endswitch; ?> <?php endforeach; endif; else: echo "" ;endif; ?>
            <td>
              <a
                href="<?php echo url('edit',['id'=>$vo['id'],'category_id'=>$vo['category_id']]); ?>"
                class="layui-btn layui-btn-normal layui-btn-sm"
                >编辑</a
              >
              <a
                href="<?php echo url('delete',['id'=>$vo['id'],'category_id'=>$vo['category_id']]); ?>"
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
            <td colspan="90">
              <button
                type="submit"
                class="layui-btn layui-btn-danger layui-btn-sm"
                lay-submit
                lay-filter="deleteAll"
              >
                删除
              </button>
              <?php if($enabled): ?>
              <button
                type="submit"
                class="layui-btn layui-btn-sm"
                lay-submit
                lay-filter="checkAll"
              >
                审核/取消审核
              </button>
              <?php endif; ?>
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