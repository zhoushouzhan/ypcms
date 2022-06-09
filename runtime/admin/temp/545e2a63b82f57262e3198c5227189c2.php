<?php /*a:2:{s:47:"F:\wwwroot\ypcms\app\admin\view\ypmod\edit.html";i:1654677922;s:41:"F:\wwwroot\ypcms\app\admin\view\base.html";i:1654652765;}*/ ?>
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
    
<style>
    .layui-form-pane{margin-bottom: 10px;}
    .layui-form-pane .layui-form-label{width: 131px;}
    .layui-input-inline{position: relative;}
    .layui-input-inline .rmbtn{position: absolute;top: 8px;right: 8px;}
    .add_item{padding: 10px 10px;}
</style>

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
        <li><a href="<?php echo url('index'); ?>">模型管理</a></li>
        <li><a href="<?php echo url('add'); ?>">添加模型</a></li>
        <li class="layui-this">编辑模型</li>
    </ul>
    <div class="layui-tab-content layui-form">
        <form action="<?php echo url('update'); ?>" method="post" id="f1">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($r['id']); ?>">
            <input type="hidden" name="category" value="<?php echo htmlspecialchars($r['category']); ?>">
            <div class="layui-form-pane">
                <div class="layui-inline">
                    <label class="layui-form-label">模型名称：</label>
                    <div class="layui-input-inline">
                        <input type="text" name="name" value="<?php echo htmlspecialchars($r['name']); ?>" class="layui-input" readonly="">
                    </div>
                </div>
                <div class="layui-inline">
                    <div class="layui-input-inline">
                        <select name="mt" id="mt" lay-filter="mt">
                            <option value="1"<?php if($r['mt']==1): ?> selected="selected"<?php endif; ?>>A类模型</option>
                            <option value="2"<?php if($r['mt']==2): ?> selected="selected"<?php endif; ?>>B类模型</option>
                            <option value="3"<?php if($r['mt']==3): ?> selected="selected"<?php endif; ?>>C类模型</option>
                        </select>
                    </div>
                </div>
                <div class="layui-inline">
                    <div class="layui-input-inline">
                        <select name="menu" id="menu">
                            <option value="0" <?php echo $r['menu']==0 ? 'selected' : ''; ?>>后台不能录入</option>
                            <option value="1" <?php echo $r['menu']==1 ? 'selected' : ''; ?>>后台可录入</option>
                          </select>
                    </div>
                  </div>
            </div>
            <div class="layui-form-pane">
                <div class="layui-inline">
                    <label class="layui-form-label">模型别名：</label>
                    <div class="layui-input-inline">
                        <input type="text" name="alias" value="<?php echo htmlspecialchars($r['alias']); ?>" class="layui-input" required lay-verify="required" placeholder="如：用户">
                    </div>
                </div>
                <div class="layui-inline" id="nodeId">
                    <div class="layui-input-inline">
                        <select name="node_id" lay-filter="nodeId">
                            <option value="-1">选择挂载点</option>
                            <option value="0" <?php if(0==$r['node_id']): ?> selected<?php endif; ?>>一级节点</option>
                            <?php if(is_array($menu) || $menu instanceof \think\Collection || $menu instanceof \think\Paginator): if( count($menu)==0 ) : echo "" ;else: foreach($menu as $key=>$vo): ?>
                            <option value="<?php echo htmlspecialchars($vo['id']); ?>"<?php if($vo['id']==$r['node_id']): ?> selected<?php endif; ?>><?php echo htmlspecialchars($vo['title']); ?></option>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                </div>
                <div class="layui-inline <?php if(!$r['node_id']): ?>layui-hide<?php endif; ?>" id="nodeSort">
                    <div class="layui-input-inline">
                        <input type="number" name="nodesort" value="<?php echo htmlspecialchars($r['nodesort']); ?>" class="layui-input" placeholder="序号">
                    </div>
                </div>

            </div>
            <div class="layui-form-pane">
                <div class="layui-inline" id="col_groups">
                    <label class="layui-form-label">字段分组：</label>
                    <?php if(is_array($r['col_groups']) || $r['col_groups'] instanceof \think\Collection || $r['col_groups'] instanceof \think\Paginator): $i = 0; $__LIST__ = $r['col_groups'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <div class="layui-input-inline">
                        <input type="text" name="col_groups[]" value="<?php echo htmlspecialchars($vo); ?>" class="layui-input" placeholder="请输入">
                        <button type="button" class="layui-btn layui-btn-xs layui-btn-danger rmbtn"><i class="layui-icon layui-icon-close"></i></button>
                    </div>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                    <div class="layui-input-inline add_group_item">
                        <button type="button" class="layui-btn">
                          增加
                        </button>
                    </div>
                </div>
            </div>

            <table class="layui-table" lay-size="sm">
                <colgroup>
                    <col width="100">
                    <col width="160">
                    <col width="170">
                    <col width="130">
                    <col width="100">
                    <col width="100">
                    <col>
                    <col>
                    <col>
                    <col>
                    <col width="100">
                </colgroup>
                <thead>
                    <tr>
                        <th>字段名</th>
                        <th>表单类型</th>
                        <th>字段类型</th>
                        <th>长度值</th>
                        <th>列宽</th>
                        <th>默认值</th>
                        <th>注释</th>
                        <th>索引</th>
                        <th>分组</th>
                        <th>列表</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody id="listCol">
                    <?php if(is_array($r['cols']) || $r['cols'] instanceof \think\Collection || $r['cols'] instanceof \think\Paginator): $i = 0; $__LIST__ = $r['cols'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;
if(!isset($vo['colw'])){
$vo['colw']='';
}

?>

                    <tr>
                        <td>
                            <input type="hidden" name="oldcols[<?php echo htmlspecialchars($i-1); ?>][name]" value="<?php echo htmlspecialchars($vo['name']); ?>">
                            <input type="hidden" name="oldcols[<?php echo htmlspecialchars($i-1); ?>][formItem]" value="<?php echo htmlspecialchars($vo['formItem']); ?>">
                            <input type="hidden" name="oldcols[<?php echo htmlspecialchars($i-1); ?>][type]" value="<?php echo htmlspecialchars($vo['type']); ?>">
                            <input type="hidden" name="oldcols[<?php echo htmlspecialchars($i-1); ?>][size]" value="<?php echo htmlspecialchars($vo['size']); ?>">
                            <input type="hidden" name="oldcols[<?php echo htmlspecialchars($i-1); ?>][colw]" value="<?php echo htmlspecialchars($vo['colw']); ?>">
                            <input type="hidden" name="oldcols[<?php echo htmlspecialchars($i-1); ?>][sval]" value="<?php echo htmlspecialchars($vo['sval']); ?>">
                            <input type="hidden" name="oldcols[<?php echo htmlspecialchars($i-1); ?>][comment]" value="<?php echo htmlspecialchars($vo['comment']); ?>">
                            <input type="hidden" name="oldcols[<?php echo htmlspecialchars($i-1); ?>][index]" value="<?php echo htmlspecialchars($vo['index']); ?>">
                            <input type="text" class="layui-input" name="cols[<?php echo htmlspecialchars($i-1); ?>][name]" value="<?php echo htmlspecialchars($vo['name']); ?>">
                        </td>
                        <td>
                            <select class="column_type" name="cols[<?php echo htmlspecialchars($i-1); ?>][formItem]" lay-filter="select_type">
                                <option value="0">请选择</option>
                                <option value="input" <?php echo $vo['formItem']=='input' ? " selected" : ""; ?>>单行文本框</option>
                                <option value="hidden" <?php echo $vo['formItem']=='hidden' ? " selected" : ""; ?>>隐藏元素</option>
                                <option value="none" <?php echo $vo['formItem']=='none' ? " selected" : ""; ?>>非表单元素</option>
                                <option value="password" <?php echo $vo['formItem']=='password' ? " selected" : ""; ?>>密码框</option>
                                <option value="datetime" <?php echo $vo['formItem']=='datetime' ? " selected" : ""; ?>>日期时间</option>
                                <option value="date" <?php echo $vo['formItem']=='date' ? " selected" : ""; ?>>日期</option>
                                <option value="select" <?php echo $vo['formItem']=='select' ? " selected" : ""; ?>>下拉菜单</option>
                                <option value="textarea" <?php echo $vo['formItem']=='textarea' ? " selected" : ""; ?>>多行文本框</option>
                                <option value="editor" <?php echo $vo['formItem']=='editor' ? " selected" : ""; ?>>富文本编辑器</option>
                                <option value="radio" <?php echo $vo['formItem']=='radio' ? " selected" : ""; ?>>单选框</option>
                                <option value="checkbox" <?php echo $vo['formItem']=='checkbox' ? " selected" : ""; ?>>复选框</option>
                                <option value="thumb" <?php echo $vo['formItem']=='thumb' ? " selected" : ""; ?>>单图片</option>
                                <option value="photo" <?php echo $vo['formItem']=='photo' ? " selected" : ""; ?>>相册</option>
                                <option value="files" <?php echo $vo['formItem']=='files' ? " selected" : ""; ?>>附件</option>
                                <option value="ypmod" <?php echo $vo['formItem']=='ypmod' ? " selected" : ""; ?>>模型单选</option>
                                <option value="ypmod_checkbox" <?php echo $vo['formItem']=='ypmod_checkbox' ? " selected" : ""; ?>>模型多选</option>
                                <option value="ypmodb" <?php echo $vo['formItem']=='ypmodb' ? " selected" : ""; ?>>模型可操作</option>
                                <option value="switch" <?php echo $vo['formItem']=='switch' ? " selected" : ""; ?>>开关</option>
                                <option value="icon" <?php echo $vo['formItem']=='icon' ? " selected" : ""; ?>>图标</option>
                                <option value="yesno" <?php echo $vo['formItem']=='yesno' ? " selected" : ""; ?>>是|否</option>
                                <option value="sex" <?php echo $vo['formItem']=='sex' ? " selected" : ""; ?>>性别</option>
                            </select>
                        </td>
                        <td>
                            <select class="column_type" name="cols[<?php echo htmlspecialchars($i-1); ?>][type]">
                                <option value="0">请选择</option>
                                <option value="INT" <?php echo $vo['type']=='INT' ? " selected" : ""; ?>>INT</option>
                                <option value="FLOAT" <?php echo $vo['type']=='FLOAT' ? " selected" : ""; ?>>FLOAT</option>
                                <option value="VARCHAR" <?php echo $vo['type']=='VARCHAR' ? " selected" : ""; ?>>VARCHAR</option>
                                <option value="TEXT" <?php echo $vo['type']=='TEXT' ? " selected" : ""; ?>>TEXT</option>
                                <option value="MEDIUMTEXT" <?php echo $vo['type']=='MEDIUMTEXT' ? " selected" : ""; ?>>MEDIUMTEXT</option>
                                <option value="JSON" <?php echo $vo['type']=='JSON' ? " selected" : ""; ?>>JSON</option>
                            </select>
                        </td>
                        <td><input type="text" class="layui-input" name="cols[<?php echo htmlspecialchars($i-1); ?>][size]" value="<?php echo htmlspecialchars($vo['size']); ?>" required lay-verify="required"></td>
                        <td><input type="text" class="layui-input" name="cols[<?php echo htmlspecialchars($i-1); ?>][colw]" value="<?php echo htmlspecialchars($vo['colw']); ?>"></td>
                        <td><input type="text" class="layui-input sval" name="cols[<?php echo htmlspecialchars($i-1); ?>][sval]" value="<?php echo htmlspecialchars((isset($vo['sval']) && ($vo['sval'] !== '')?$vo['sval']:'')); ?>"></td>
                        <td><input type="text" class="layui-input" name="cols[<?php echo htmlspecialchars($i-1); ?>][comment]" value="<?php echo htmlspecialchars($vo['comment']); ?>" required lay-verify="required"></td>
                        <td>
                            <select class="index" name="cols[<?php echo htmlspecialchars($i-1); ?>][index]">
                                <option value="0">无索引</option>
                                <option value="index" <?php echo $vo['index']=='index' ? " selected" : ""; ?>>普通索引</option>
                                <option value="unique" <?php echo $vo['index']=='unique' ? " selected" : ""; ?>>唯一索引</option>
                                <option value="fulltext" <?php echo $vo['index']=='fulltext' ? " selected" : ""; ?>>全文索引</option>
                            </select>
                        </td>
                        <td>
                            <select class="col_group" name="cols[<?php echo htmlspecialchars($i-1); ?>][group]" data-val="<?php echo !empty($vo['group']) ? htmlspecialchars($vo['group']) : '0'; ?>">
                                <option value="0">基础属性</option>
                            </select>
                        </td>
                        <td>
                            <input type="checkbox" name="cols[<?php echo htmlspecialchars($i-1); ?>][listv]" value="1" lay-skin="primary"<?php if(isset($vo['listv'])): ?> checked<?php endif; ?>>
                        </td>
                        <td>
                            <button type="button" class="layui-btn layui-btn-xs layui-bg-red delTr"><i class="layui-icon">&#xe640;</i></button>
                            <button type="button" class="layui-btn layui-btn-xs layui-bg-black addTr"><i class="layui-icon">&#xe654;</i></button>
                        </td>
                    </tr>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </tbody>
            </table>
            <div>
                <button type="button" class="layui-btn layui-bg-red" lay-submit lay-filter="*"><i class="layui-icon">&#xe652;</i>执行</button>
            </div>
        </form>
    </div>
</div>
<hr>
<fieldset class="layui-elem-field">
    <legend>说明</legend>
    <div class="layui-field-box">
        <p>功能字段：</p>
        <p>1、enabled审核字段</p>
        <p>2、下划线为关联字段，时间除外</p>
    </div>
</fieldset>

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
    
<script src="/static/admin/js/jquery.tablednd.js"></script>
<script>
//表格排序
$("#listCol").tableDnD({
    //滚动的速度
    scrollAmount: 10,
    onDragClass: 'highlight',
    //当拖动排序完成后
    onDrop: function(table, row) {
        //获取id为table的元素
        var table = document.getElementById("listCol");
        //获取table元素所包含的tr元素集合
        var tr = table.getElementsByTagName("tr");
        //遍历所有的tr
        for (var i = 0; i < tr.length; i++) {
            //获取拖动排序结束后新表格中，row id的结果
            var rowid = tr[i].getAttribute("id");
            //console.log("排序完成后表格的第 " + (i+1) + " 行id为 : " + rowid);
        }
    },
    onDragStart: function(table, row) {
        //console.log(row.id);
    },
});
//监听选择表单类型
form.on('select(select_type)', function(data){
  var name= $(data.elem).parents('tr').find('.sval').attr('name');
  if(data.value=='select'||data.value=='radio'||data.value=='checkbox'){
    var mclass=layer.open({
      title:'选择分类',
      type:2,
      area:['100%','100%'],
      content:['<?php echo url("mclass/sclass",["pid"=>0]); ?>&inputname='+name]
    })
    return false;
  }
});
//监听节点
form.on('select(nodeId)',function(data){
    var nodeid=data.value;

    if(nodeid>0){
        $("#nodeSort").removeClass('layui-hide');
    }else{
        $("#nodeSort").addClass('layui-hide');
    }
});
form.on('checkbox(category)', function(data){
  if(data.elem.checked){
    $("[name='category']").val(1);
  }else{
    $("[name='category']").val(0);
  }
});
//字段分组
updataColGroup();
$(".add_group_item").click(function(){
    var item='<div class="add_item"><input type="text" value="" class="layui-input" placeholder="请输入"></div>';
    var ww=layer.open({
        type:1,
        closeBtn:0,
        title:'增加字段组',
        btn:['提交','取消'],
        yes:function(index,layero){
            var item_name=$(".add_item>input").val();
            var html='<div class="layui-input-inline"><input type="text" name="col_groups[]" value="'+item_name+'" class="layui-input" placeholder="请输入"><button type="button" class="layui-btn layui-btn-xs layui-btn-danger rmbtn"><i class="layui-icon layui-icon-close"></i></button></div>';
            $(".add_group_item").before(html);
            updataColGroup();
            layer.close(ww);
        },
        content:item
    });
});
$("#col_groups").on('click', '.rmbtn', function(event) {
    event.preventDefault();
    var index=$("#col_groups").find('.layui-input-inline').index($(this).parent());
    if(index==0){
        layer.msg('不能删除第一个',{icon:'5',shade: [0.8, '#393D49']});
        return false;
    }
    $(this).parent().remove();
    updataColGroup();
});
//选择图标
jQuery(document).ready(function($) {
    $("#selectIcon").click(function(event) {
        /* Act on the event */
        var index = layer.open({
            title: '选择图标',
            type: 2,
            content: ['/icon.php'],
            area: ['100%', '100%']
        })
    });
});

//更新字段分组
function updataColGroup(){
    var option='';
    $("input[name='col_groups[]']").each(function(index, el) {
        option+='<option value="'+index+'">'+$(el).val()+'</option>';
    });
    $(".col_group").html(option);
    $(".col_group").each(function(index, el) {
        var val=$(el).data('val');
        $(this).val(val);
    });
    form.render('select');
}
</script>

  </body>
</html>
