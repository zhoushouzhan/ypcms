//载入layui
var layer = layui.layer,
    element = layui.element,
    laydate = layui.laydate,
    laypage = layui.laypage,
    upload = layui.upload,
    yptb = layui.table,
    form = layui.form,
    dropdown = layui.dropdown;
//ajax全局配置
$.ajaxSetup({
    type: "post",
    dataType: "json"
});
/**
 * 通用日期时间选择
 */
laydate.render({
    elem: '.datetime',
    istime: true,
    format: 'yyyy-MM-dd HH:mm:ss'
})
laydate.render({
    elem: '.ypcms-date',
    istime: true,
    format: 'yyyy-MM-dd'
})

/**
 * 通用表单提交(AJAX方式)
 */

form.on('submit(*)', function(data) {
    t = data.form.t;
    $.ajax({
        url: data.form.action,
        type: data.form.method,
        data: $(data.form).serialize(),
        success: function(info) {
            if (info.code === 1) {
                //正确提醒
                layer.msg(info.msg, { icon: 1, anim: 5, offset: '300px', shade: [0.8, '#393D49'], time: info.wait * 1000 }, function() {
                    if (info.data == 'new') {
                        window.location.href = info.url;
                    } else {
                        var pageBody = info.url;
                        if (info.url.indexOf('cookieurl') >= 0) {
                            pageBody = $.cookie('pageBody');
                        }
                        window.location.reload();
                        return false;
                    }
                });
            } else {
                //错误提醒
                layer.alert(info.msg, { icon: 2, title: '温馨提示', anim: 1, closeBtn: 2, offset: '300px' });
            }
            //如果有验证码刷新
            if ($('.captcha')) {
                $('.captcha').attr('src', $('.captcha').attr('src') + Math.random());
                $("input[name=verify]").val('');
            }
        }
    });
    return false;
});
//点击全选, 勾选
form.on('checkbox(chooseAll)', function(d) {
    $(".selectId input[type=checkbox]").prop('checked', d.elem.checked);
    form.render();
});
//删除全部
form.on('submit(deleteAll)', function(d) {
    var data = $(".layui-form").serialize();
    $.post('delete', data, function(data, textStatus, xhr) {
        if (data.code == 1) {
            layer.msg(data.msg, {
                icon: 1,
                time: 2000 //2秒关闭（如果不配置，默认是3秒）
            }, function() {
                window.location.href = data.url;
            });
        } else {
            layer.msg(data.msg, { icon: 5 });
        }
    }, 'json');
    return false;
});
form.on('submit(search)', function(data) {
    t = data.form.t;
    var tourl = data.form.action + '?' + $(data.form).serialize();
    tourlFun(tourl, 'pageBody');
    return false;
});
//通用批量处理
$('body').on('click', '.ajax-action', function() {
    var _action = $(this).data('action');
    layer.open({
        shade: false,
        content: '确定执行此操作？',
        btn: ['确定', '取消'],
        yes: function(index) {
            $.ajax({
                url: _action,
                data: $('.ajax-form').serialize(),
                success: function(info) {
                    if (info.code === 1) {
                        setTimeout(function() {
                            location.href = info.url;
                        }, 1000);
                    }
                    layer.msg(info.msg);
                }
            });
            layer.close(index);
        }
    });
    return false;
});
//通用全选
$('body').on('click', '.check-all', function() {
    $(this).parents('table').find('input[type="checkbox"]').prop('checked', $(this).prop('checked'));
});
//通用全选-LAYUI
form.on('checkbox(check_all)', function(data) {
    var a = data.elem.checked;
    if (a == true) {
        $(".check_s").prop("checked", true);
    } else {
        $(".check_s").prop("checked", false);
    }
    form.render('checkbox');
});
//通用删除
$('body').on('click', '.ajax-delete', function() {
    var _href = $(this).attr('href');
    layer.open({
        shade: false,
        content: '确定删除？',
        btn: ['确定', '取消'],
        yes: function(index) {
            $.ajax({
                url: _href,
                type: "get",
                success: function(info) {
                    if (info.code === 1) {
                        setTimeout(function() {
                            location.href = info.url;
                        }, 1000);
                    }
                    layer.msg(info.msg);
                }
            });
            layer.close(index);
        }
    });
    return false;
});
//清除缓存
$('#clear-cache').on('click', function() {
    var _url = $(this).data('url');
    if (_url !== 'undefined') {
        $.ajax({
            url: _url,
            success: function(data) {
                layer.msg(data.msg);
            }
        });
    }
    return false;
});
//添加|删除字段
$("body").on('click', '.addTr,.delTr', function(event) {
    event.preventDefault();
    //增加字段
    if ($(this).hasClass('addTr')) {
        var trHtml = $("#listCol>tr").eq(0).prop("outerHTML");
        var key = $("#listCol>tr").length; //序号获取
        trHtml = trHtml.replace(/cols\[\d\]/g, 'cols[' + key + ']'); //序号填充
        console.log(key);
        console.log(trHtml); //打印html
        $(this).parents("tr").after(trHtml);
        $(this).parents("tr").next().find('input[class^=old]').remove(); //移除旧字段元素
        $(this).parents("tr").next().find('input[type=text]').val(''); //清空输入框的值
        $(this).parents("tr").next().find('input[name*=sval]').val(''); //清空输入框的值
        $(this).parents("tr").next().find('input[type=checkbox]').removeAttr('checked'); //设置开关默认为关闭
        $(this).parents("tr").next().find('option').removeAttr('selected'); //设置下拉菜单为默认
        $(this).parents("tr").next().find('[type="hidden"]').remove(); //删除旧字段残留信息
        form.render(); //渲染新加的HTML
    }
    //删除字段
    if ($(this).hasClass('delTr')) {
        if ($("#listCol>tr").length > 1) {
            $(this).parents("tr").remove();
        }
    }
});
//可操作模型表格编辑
$(".dataTable").on('click', '.del,.add,.edit,.remove,.save', function(event) {
    event.preventDefault();
    var mod = $(this).parents("table").data('mod');
    var cols = mod.cols;
    //删除

    //增加
    if ($(this).hasClass('add')) {
        layer.msg('add');
        $(this).parents("tbody").find('tr').last().removeClass('layui-hide');
    }
    //放弃
    if ($(this).hasClass('remove')) {
        layer.msg('remove');
        $(this).parents("tbody").find('tr').last().addClass('layui-hide');
        $(this).parents("tbody").find('tr').last().find('input,textarea').val('');
    }
    //编辑
    //保存
    if ($(this).hasClass('save')) {
        $.each(cols, function(index, val) {
            switch (val.formItem) {
                case 'input':
                    data[val.name] = $("input[name=" + val.name + "]").val();
                    break;
                case 'date':
                    data[val.name] = $("input[name=" + val.name + "]").val();
                    break;
                case 'textarea':
                    data[val.name] = $("textarea[name=" + val.name + "]").val();
                    break;
            }
        });
        $.post('update', data, function(d, textStatus, xhr) {
            console.log(d);
        });

    }
});



//附件上传
$('body').on('click', '.fileCenterSelect', function(event) {
    $("#filesBox").remove();
    var filesBox = $('<div></div>');
    var filesList = $('<div></div>');
    var filesPage = $('<div></div>');
    var filesCtrl = $('<div class="layui-form-item"></div>');
    fcon = $(this).attr('fx');
    ftype = $(this).attr('ftype');
    addType = $(this).attr('addType');
    fname = $(this).attr('fname');
    fval = $(this).attr('fval');
    oldFileId = $(this).attr('oldFileId');
    if (oldFileId) {
        deleteFiles(oldFileId, 1);
        $("#" + fcon).removeAttr('src');
        $(this).removeAttr('oldFileId');
        $(this).removeClass('layui-btn-danger');
        $(this).text('点击上传');
        return;
    }
    //附件查询
    var searchHmtl = '<div class="layui-inline"><input type="text" name="title" placeholder="请输入关键词" autocomplete="off" class="layui-input" id="keyword"></div>';
    searchHmtl += '<div class="layui-inline"><button class="layui-btn layui-btn-warm filesSearch">查询</button></div>';
    searchHmtl += '<div class="layui-inline"><button class="layui-btn" id="YpcmsUpload">上传文件</button></div>';
    filesCtrl.html(searchHmtl);
    filesCtrl.attr("id", "fileCtrl").appendTo(filesBox);
    filesBox.attr("id", "filesBox").css("padding", "10px");
    filesList.attr("id", "filesdivbox").appendTo(filesBox);
    filesPage.attr("id", "filesPage").appendTo(filesBox);

    getFilesCenter(ftype);
    $("body").append(filesBox);
    var title = $(this).attr('ftitle');
    fileBox = layer.open({
        type: 1,
        title: title,
        closeBtn: 1,
        area: ['950px', '750px'],
        content: $('#filesBox'),
        end: function(index, layer) {
            $("#filesBox").html('');
        }
    });
    uploadFiles('YpcmsUpload', '', '', '');
});
$('body').on('click', '.fileSelect', function(event) {
    console.log(fcon);
    console.log(addType);
    if (addType == 'm' && fcon == 'file-container') {
        var count = $('#' + fcon).find('tr').length + 1;
        var file_list_item = '<tr>';
        file_list_item += '<td>' + count + '<input type="hidden" name="' + fname + '[]" value="' + $(this).parents().attr('fileid') + '"></td>';
        file_list_item += '<td>' + $(this).parents().attr('filename') + '</td>';
        file_list_item += '<td><a href="javascript:window.open(\'' + $(this).parents().attr('filepath') + '\');" target="_blank"><i class="fa fa-cloud-download" aria-hidden="true"></i></a></td>';
        file_list_item += '<td><div class="fileDel layui-btn layui-btn-danger layui-btn-sm" type="2">取消</div></td>';
        file_list_item += '</tr>';
        $('#' + fcon).append(file_list_item);
        $(this).remove();
        form.render();
    } else if (addType == 'm' && ftype == 'image') {
        var createHtml = '';
        createHtml += '<div class="layui-col-md2">';
        createHtml += '<div class="fileItem">';
        createHtml += '<input type="hidden" name="' + fname + '[]" value="' + $(this).parents().attr('fileid') + '">';
        createHtml += '<img src="' + $(this).parents().attr('filepath') + '" />';
        createHtml += '<div class="fileName">' + $(this).parents().attr('filename') + '</div>';
        createHtml += '<div class="fileDel layui-btn layui-btn-danger layui-btn-xs" type="1">取消</div>';
        createHtml += '</div>';
        createHtml += '</div>';
        $('#' + fcon).append(createHtml);
        $(this).remove();
    } else if (addType == 's' && fcon.indexOf('thumb') >= 0) {
        $("#" + fcon).attr('src', $(this).parent().attr('filepath'));
        $("#" + fcon).css({
            'object-fit': 'cover'
        });
        if (fval == 'path') {
            $("#" + fname).val($(this).parent().attr('filepath'));
        } else {
            $("#" + fname).val($(this).parent().attr('fileId'));
        }

        layer.close(fileBox);
        $("#filesBox").html('');
    } else {
        if (fval == 'path') {
            $("#" + fname).val($(this).parent().attr('filepath'));
        } else {
            $("#" + fname).val($(this).parent().attr('fileId'));
        }
        layer.close(fileBox);
    }
});
$("body").on('click', '.filesSearch', function(event) {
    event.preventDefault();
    var keyword = $("#keyword").val();
    if (keyword) getFilesCenter('image', 0, keyword, 0, 0);

});

//删除附件
$("body").on('click', '.fileDel', function(event) {
    event.preventDefault();
    //编辑中解除绑定
    var type = $(this).attr('type');
    if (type == 2) {
        //下载
        var fileId = $(this).attr('oldFileId');
        if (fileId) {
            deleteFiles(fileId, 1);
        }
        $(this).parents('tr').remove();
        return;
    }
    if (type == 1) {
        //图集
        var fileId = $(this).attr('oldFileId');
        if (fileId) {
            deleteFiles(fileId, 1);
        }
        $(this).parents('.layui-col-md2').remove();
        return;
    }
    if (type == 3) {
        //管理中删除附件
        var id = $(this).attr('fileId');
        deleteFiles(id);
    }
});



//删除表格数据动画
$("body").on('click', '.tr-delete', function(event) {
    /* Act on the event */
    log('删除表格行');
    var _href = $(this).data('href');
    var tips = $(this).parents('tbody').data('deltips');
    var id = $(this).data('id');
    var tr = $(this).parents('tr');
    layer.open({
        title: '提示',
        shade: false,
        content: tips,
        btn: ['确定', '取消'],
        yes: function(index) {
            $.ajax({
                url: _href,
                type: "get",
                success: function(info) {
                    if (info.code === 1) {
                        layer.msg(info.msg, function() {
                            window.location.reload();
                        });
                    }
                }
            });
            layer.close(index);
        }
    });
});
form.on('select(selectMod)', function(data) {
    var modname = $(data.elem).find('option:selected').data('mod');
    $("input[name=modname]").val(modname);
});
form.on('select(selectCid)', function(data) {
    var pid = $(data.elem).find('option:selected').data('pid');
    if (pid > 0) {
        $(".parent").addClass('layui-hide').removeClass('layui-show');
    } else {
        $(".parent").addClass('layui-show').removeClass('layui-hide');
    }
});
//联动菜单选择事件
form.on('select(mclass)', function(data) {
    console.log('zx');
    var pid = data.value;
    var preid = $(data.elem).find('option:selected').data('preid');
    var selectHtml = $(data.elem);
    $(data.elem).parent().nextAll('.layui-input-inline').remove();
    $("#" + preid).val(pid);
    $.ajax({
            url: '/mclass/getSon',
            type: 'GET',
            dataType: 'json',
            data: { pid: pid },
        })
        .done(function(res) {
            if (res.code == 1) {
                var html = "<div class=\"layui-input-inline " + preid + "\">";
                html += "<select lay-filter=\"mclass\">";
                html += "<option value=\"\"></option>";
                $.each(res.data, function(index, val) {
                    /* iterate through array or object */
                    html += "<option value=\"" + val.id + "\" data-preid=\"" + preid + "\">" + val.title + "</option>";
                });
                html += "</select>";
                html += "</div>";
                console.log(html);
                $(data.elem).parent().after(html);
                form.render();
            }

        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });

});
//审核操作
form.on('submit(checkAll)', function(data) {
    $.ajax({
            url: 'checkInfo',
            type: 'post',
            dataType: 'json',
            data: data.field,
        })
        .done(function(data) {
            layer.msg(data.msg, { icon: 6, time: 1000, shade: [0.8, '#393D49'] }, function() {
                window.location.reload();
            });
        })
    return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
});


//侧边菜单跳转
$("#sideTree").on('click', 'a', function(event) {
    event.preventDefault();
    /* Act on the event */
    var url = $(this).attr('href');
    $("#ypbox").attr('src', url);
    return;
});
$("body").on('click', '.toypbox', function(event) {
    event.preventDefault();
    /* Act on the event */
    var url = $(this).attr('href');
    $("#ypbox").attr('src', url);
    return;
});


//附件管理中心
function getFilesCenter(type, page, keyword, infoid, userid) {
    $.ajax({
            url: '/files/getjson',
            type: 'get',
            dataType: 'json',
            data: { ftype: type, page: page, keyword: keyword },
        })
        .done(function(res) {
            var createHtml = '<div class="layui-row layui-col-space10">';
            $.each(res.data, function(index, el) {
                createHtml += '<div class="layui-col-md2">';
                createHtml += '<div class="fileItem" filepath="' + el.filepath + '" filename="' + el.name + '" fileid="' + el.id + '">';
                if (ftype == 'image') {
                    createHtml += '<img src="' + el.filepath + '" />';
                } else {
                    createHtml += '<i class="fa fa-file-archive-o" aria-hidden="true"></i>';
                }
                createHtml += '<div class="fileName">' + el.name + '</div>';
                createHtml += '<div class="fileDel layui-btn layui-btn-danger layui-btn-xs" type="3" fileid="' + el.id + '">删除</div>';
                createHtml += '<div class="fileSelect layui-btn layui-btn-normal layui-btn-xs" fileid="' + el.id + '">' + (addType == 'm' ? "插入" : "选择") + '</div>';
                createHtml += '</div>';
                createHtml += '</div>';
            });
            createHtml += '</div>';
            $('#filesdivbox').html(createHtml);
            //执行一个laypage实例
            laypage.render({
                elem: 'filesPage' //注意，这里的 filesPage 是 ID，不用加 # 号
                    ,
                count: res.total //数据总数，从服务端得到
                    ,
                limit: 24,
                curr: res.current_page,
                jump: function(obj, first) {
                    if (!first) {
                        getFilesCenter(type, obj.curr);
                    }
                }
            });
        })
}

//格式化文件大小
function renderSize(value) {
    if (null == value || value == '') {
        return "0 Bytes";
    }
    var unitArr = new Array("Bytes", "KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB");
    var index = 0,
        srcsize = parseFloat(value);
    index = Math.floor(Math.log(srcsize) / Math.log(1024));
    var size = srcsize / Math.pow(1024, index);
    //  保留的小数位数
    size = size.toFixed(2);
    return size + unitArr[index];
}

//鼠标经过图片文件时预览
function mouseViewImg(obj) {
    var x = 5;
    var y = 15;
    var imgBox = '<div id="imageTip" class="layui-hide"><img alt="" src="" class="clsImg"></div>';
    imgbox.appendTo('body');
    obj.mousemove(function(e) {
        $("#imageTip>img").attr("src", this.src);
        $("#imageTip").css({
            "top": (e.pageY + y) + "px",
            "left": (e.pageX + x) + "px"
        }).show(3000); //显示图片 

    });
    obj.mouseout(function() {
        $("#imageTip").hide(); //隐藏图片
    });
}

//附件上传,ID,格式,尺寸,数量
function uploadFiles(elem, ext, maxsize, nums, params) {
    var uploader = new plupload.Uploader({
        browse_button: elem,
        file_data_name: 'file',
        runtimes: 'html5',
        url: '/api/upload.html',
        multi_selection: true
    });
    uploader.init();
    uploader.bind('UploadComplete', function(uploader, res) {
        $('#filesdivbox').html('');
        getFilesCenter(ftype);
    });
    uploader.bind('FileUploaded', function(uploader, file, res) {
        var response = $.parseJSON(res.response);
        if (response.code == 0) {
            layer.msg(response.msg);
        }
    });
    uploader.bind('FilesAdded', function(uploader, files) {
        uploader.start();
    });
}
//删除附件:ID,删除0|解绑1
function deleteFiles(id, bind) {
    $.getJSON('/files/del/', { id: id, bind: bind }, function(data) {
        layer.msg(data.msg);
        $('#filesdivbox').html('');
        getFilesCenter(ftype);
    });
}

function log(res) {
    console.log(res);
}

function CKupdate() {
    for (instance in CKEDITOR.instances)
        CKEDITOR.instances[instance].updateElement();
}


//画图
function doecharts(id,opt){
    var chartDom=document.getElementById(id);
    var myChart = echarts.init(chartDom, 'dark');
    myChart.setOption(opt);
}