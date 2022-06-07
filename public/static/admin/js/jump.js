//一级导航
$("body").on('click', '.sysItem>li', function(event) {
    event.preventDefault();
    var navurl=$(this).find('a').attr('nav-href');
    var sysItemindex=$(this).index();
    $.cookie('sysItemindex',sysItemindex,{expires:7});
    $.cookie('navurl',navurl,{expires:7});
    tonavFun(navurl);
    return false;
});




//退出
$(".ajax-logout").click(function(event) {
    var _href = $(this).attr('href');
    layer.open({
        title:'提示',
        shade: false,
        content: '确定退出吗？',
        btn: ['确定', '取消'],
        yes: function (index) {
            $.ajax({
                url: _href,
                type: "get",
                success: function (info) {
                    if (info.code === 1) {
                        $.cookie('pageBody',null);
                        $.cookie('trees',null);
                        $.cookie('sysItemindex',null);
                        $.cookie('sideTree',null);
                        setTimeout(function () {
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
//导航处理
function tonavFun(tourl) {
    if (tourl) {
        console.log('执行导航'+tourl);
        $.ajax({
                url: tourl,
                type: 'GET',
                dataType: 'json',
            })
            .done(function(res) {
                if(res.code==1){
                    var treeItem = '';
                    $.each(res.data.children,function(index, el) {
                        treeItem+= '<li class="layui-nav-item">'
                        if(el.children.length>0){
                            treeItem+='<a href="javascript:;"><i class="'+el.icon+'"></i> '+el.title+'</a>';
                            treeItem+= '<dl class="layui-nav-child">';
                            $.each(el.children,function(i, e) {
                                treeItem+=getChildMenu(e,0);
                            });

                            treeItem+= '</dl>';
                        }else{
                            treeItem+='<a href="'+el.name+'"><i class="'+el.icon+'"></i> '+el.title+'</a>';
                        }
                        treeItem+= '</li>'
                    });
                    $("#sideTree").html('');
                    $("#sideTree").html(treeItem);
                    element.render();
                }else{
                    layer.msg(res.msg,{icon:2});
                }
            })
            .fail(function(e) {
                console.log("errorTOurl");
            })
            .always(function() {
                setSide();
            });
    }
}

function setSide(){
    //选中二级导航
    $('#sideTree li').removeClass('layui-nav-itemed');
    $('#sideTree li').removeClass('layui-this');
    if($.cookie('trees')){
        var trees=$.cookie('trees');
        trees=$.parseJSON(trees); 
    }else{
        trees={li:-1,dd:-1}
    }
     console.log('节点');
     console.log(trees);
    if(trees.dd>=0){
        $('#sideTree li').eq(trees.li).addClass('layui-nav-itemed');
    }else{
        if(trees.li>=0){
            if($('#sideTree li').eq(trees.li).find('dd').length>0){
                $('#sideTree li').eq(trees.li).addClass('layui-nav-itemed');
                $('#sideTree li').eq(trees.li).find('dd').eq(trees.dd).addClass('layui-this');
            }else{
                $('#sideTree li').eq(trees.li).addClass('layui-nav-itemed').addClass('layui-this');
            }
        }
    }
}
var menuCell = 10;
function getChildMenu(subMenu,num) {
        console.log("num: "+num);
        console.log(subMenu);
        num++;
        var subStr = "";
        if(subMenu.children!=null&&subMenu.children.length>0){
            subStr+="<dd><ul><li class=\"layui-nav-item\" ><a style=\"margin-left: "+num*menuCell+"px\" class=\"\" href=\"javascript:;\"><i class='"+ subMenu.icon +"'></i> "+subMenu.title+"</a>" +
                    "<dl class=\"layui-nav-child\">\n";
            for( var j = 0; j <subMenu.children.length; j++){
                subStr+=getChildMenu(subMenu.children[j],num);
            }
            subStr+="</dl></li></ul></dd>";
        }else{
            subStr+="<dd><a style=\"margin-left:"+num*menuCell+"px\" href=\""+subMenu.name+"\"><i class='"+ subMenu.icon +"'></i> "+subMenu.title+"</a></dd>";
        }
        return subStr;
}