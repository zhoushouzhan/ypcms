<?php /*a:2:{s:48:"F:\wwwroot\ypcms\app\admin\view\group\index.html";i:1654648267;s:41:"F:\wwwroot\ypcms\app\admin\view\base.html";i:1654652765;}*/ ?>
<!--
 * @Author: 一品网络技术有限公司
 * @Date: 2022-06-08 07:55:45
 * @LastEditTime: 2022-06-08 09:45:19
 * @FilePath: \ypcms\app\admin\view\base.html
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
      href="/static/src/ckeditor/plugins/codesnippet/lib/highlight/styles/default.css"
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
      <div class="layui-main" id="pageBody">
        <div class="cbtn">
          <a
            href="javascript:window.location.reload();"
            title="刷新"
            class="layui-btn layui-bg-blue layui-btn-sm fr"
            ><i class="layui-icon layui-icon-refresh"></i> 刷新</a
          >
          <a
            href="javascript:window.history.back();"
            title="刷新"
            class="layui-btn layui-bg-black layui-btn-sm fr mr"
            ><i class="layui-icon layui-icon-return"></i> 返回</a
          >
        </div>
        
<div class="layui-tab layui-tab-brief">
    <ul class="layui-tab-title">
        <li class="layui-this"><?php echo htmlspecialchars($mod['alias']); ?>列表</li>
        <li><a href="<?php echo url('add'); ?>">添加<?php echo htmlspecialchars($mod['alias']); ?></a></li>
    </ul>
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">
        <?php if($searchCol): ?>
          <form action="<?php echo url('index'); ?>" action="get" class="layui-form">
            <div class="demoTable">
              关键词：
              <div class="layui-inline">
                <input class="layui-input" name="keyboard" id="keyboard">
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
            </div>
          </form>
        <?php endif; ?>
            <form action="" class="layui-form">
            <table class="layui-table">
                <colgroup>
                    <col width="35">
                    <col width="100">
                    <?php if(is_array($listv) || $listv instanceof \think\Collection || $listv instanceof \think\Paginator): $i = 0; $__LIST__ = $listv;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <col>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                    <col width="140">
                </colgroup>
                <thead>
                <tr>
                    <th>选择</th>
                    <th>ID</th>
                    <?php if(is_array($listv) || $listv instanceof \think\Collection || $listv instanceof \think\Paginator): $i = 0; $__LIST__ = $listv;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <th><?php echo htmlspecialchars($vo['comment']); ?></th>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                    <th><div align="center">操作</div></th>
                </tr>
                </thead>
                <tbody>
                <?php if(is_array($dataList) || $dataList instanceof \think\Collection || $dataList instanceof \think\Paginator): if( count($dataList)==0 ) : echo "" ;else: foreach($dataList as $key=>$vo): ?>
                <tr>
                    <td class="selectId"><input type="checkbox" name="id[]" value="<?php echo htmlspecialchars($vo['id']); ?>" lay-skin="primary"></td>
                    <td><?php echo htmlspecialchars($vo['id']); ?></td>
                    <?php if(is_array($listv) || $listv instanceof \think\Collection || $listv instanceof \think\Paginator): $i = 0; $__LIST__ = $listv;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                    <td><?php echo htmlspecialchars($vo[$v['name']]); ?></td>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                    <td>
                        <div align="center">
                        <a href="<?php echo url('edit',['id'=>$vo['id']]); ?>" class="layui-btn layui-btn-normal layui-btn-xs" title="编辑"><i class="layui-icon layui-icon-edit"></i></a>
                        <a href="<?php echo url('delete',['id'=>$vo['id']]); ?>" class="layui-btn layui-btn-danger layui-btn-xs ajax-delete" title="移入回收站"><i class="layui-icon layui-icon-delete"></i></a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; endif; else: echo "" ;endif; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td><input type="checkbox" lay-skin="primary" lay-filter="chooseAll"></td>
                        <td colspan="<?php echo htmlspecialchars($colspan); ?>">
                            <button type="submit" class="layui-btn layui-btn-danger layui-btn-sm" lay-submit lay-filter="deleteAll">批量删除</button>
                        </td>
                    </tr>
                </tfoot>
            </table>
            </form>
            总数：<?php echo htmlspecialchars($count); ?><?php echo $dataList->render(); ?>
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
