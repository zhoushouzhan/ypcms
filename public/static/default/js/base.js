var layer = layui.layer,form=layui.form,carousel = layui.carousel,element = layui.element,$=layui.$,upload = layui.upload;
//获取验证码
$("body").on('click', '.getPhoneCode', function(event) {
    var that = $(this);
    var url = $(this).data('url');
    var sender = $("#sender").val();
    if (!isMobile(sender) && !isEmail(sender)) {
        layer.msg('请输入正确的手机号或邮箱', { icon: 2 });
        return false;
    }
    var index = layer.load(1);
    $.post(url, { sender: sender }, function(data, textStatus, xhr) {
      console.log(data);
        if (data.code == 1) {
            layer.msg(data.msg, { icon: 1 });
            daojishi(that);
        } else {
            layer.msg(data.msg, { icon: 2 });
        }
        layer.close(index);
    }, 'json');
});

//上传头像
var upuserpic=upload.render({
  elem:'#upuserpic',
  url:'/upload/index',
  multiple:false,
  data:{type:'userpic',id:$("#upuserpic").data('id')},
  done:function(res){
    if(res.code){
      $(".userpic img").attr('src',res.data);
      layer.msg(res.msg,{icon:1});
    }else{
      layer.msg(res.msg,{icon:2});
    }
  }
});

//通用表单提交(AJAX方式)
form.on('submit(*)', function (data) {
    $.ajax({
        url: data.form.action,
        type: 'POST',
        dataType: 'json',
        data: $(data.form).serialize(),
        success: function (info) {
            if (info.code === 1) {
                //正确提醒
                layer.msg(info.msg,{icon: 1,anim:5,offset: '300px',shade: [0.8, '#393D49'],time: info.wait*1000},function(){
                    window.location.href=info.url;
                });
            }else{
                //错误提醒
                layer.alert(info.msg,{icon: 2,title:'温馨提示',anim:1,closeBtn:2,offset: '300px'});
            }
            //如果有验证码刷新
            if($('.captcha')){
                $('.captcha').attr('src',$('.captcha').attr('src')+Math.random());
                $("input[name=verify]").val('');
            }
        }
    });
    return false;
});

//协议认可
form.on('checkbox(rengke)',function(data){
	if(data.elem.checked){
		$(".regbtn>button").removeClass('layui-btn-disabled layui-bg-gray').addClass('layui-bg-red');
	}else{
		$(".regbtn>button").addClass('layui-btn-disabled layui-bg-gray').removeClass('layui-bg-red');
	}
});
//注册
form.on('submit(register)',function(data){
	var url=$(data.form).attr('action');
	var data=data.field;
	$.ajax({
		url: url,
		type: 'POST',
		dataType: 'json',
		data: data,
	})
	.done(function(res) {
		if(res.code==1){
			layer.msg(res.msg,{icon:1,time:1000},function(){
				window.location.href='/';
			});

		}else{
			layer.msg(res.msg,{icon:2});
		}
	});
	return false;
});
//登陆
form.on('submit(login)',function(data){
	var url=$(data.form).attr('action');
	var data=data.field;
	$.ajax({
		url: url,
		type: 'POST',
		dataType: 'json',
		data: data,
	})
	.done(function(res) {
		if(res.code==1){
			layer.msg(res.msg,{icon:1,time:1000},function(){
				window.location.href=res.url;
			});

		}else{
			layer.msg(res.msg,{icon:2});
		}
	});
	return false;
});
//表单验证
form.verify({
  otherReq: function(value, item) {
      var verifyName = $(item).attr('name'),
          verifyType = $(item).attr('type'),
          formElem = $(item).parents('.layui-form'),
          verifyElem = formElem.find('input[name=' + verifyName + ']'),
          isTrue = verifyElem.is(':checked'),
          reqText=$(item).attr('lay-reqText');
          focusElem = verifyElem.next().find('i.layui-icon');
      if (!isTrue || !value) {
          //定位焦点
          focusElem.css(verifyType == 'radio' ? { "color": "#FF5722" } : { "border-color": "#FF5722" });
          //对非输入框设置焦点
          focusElem.first().attr("tabIndex", "1").css("outline", "0").blur(function() {
              focusElem.css(verifyType == 'radio' ? { "color": "" } : { "border-color": "" });
          }).focus();
          return reqText?reqText:'有必填项没填写';
      }
  }
});
//个人中心认证Tips
var tips;
$(".cert>div").on({
  mouseenter:function(event) {
    var that=this;
    var title=$(this).data('title');
    var xy=$(this).data('xy');
    tips=layer.tips(title,that,{tips:xy});
  },
  mouseleave:function(event) {
    layer.close(tips);
  }
});

$(".ajax_url").click(function(event) {
    $.get($(this).attr('href'), function(data) {
        layer.msg(data.msg, function() {
            window.location.reload();
        });
    }, 'json');
    return false;
});


$("ul.nav li").hover(function() {
    $(this).addClass("on");
},
function() {
    $(this).removeClass("on");
})


//以下是共用函数
//===============
//倒计时
var count = 60;
function daojishi(o) {
    if (count == 0) {
        $(o).removeClass('layui-btn-disabled layui-bg-gray').removeAttr('disabled').addClass('layui-bg-red');
        $(o).text("免费获取");
        count = 60;
    } else {
        $(o).addClass('layui-btn-disabled layui-bg-gray').attr('disabled','disabled').removeClass('layui-bg-red');
        $(o).text( count + "秒后过期");
        count--;
        setTimeout(function(){daojishi(o)},1000)
    }
}
//验证手机号
function isMobile(phone) {
    var myreg=/^[1][3,4,5,6,7,8,9][0-9]{9}$/;
    if (!myreg.test(phone)) {
        return false;
    } else {
        return true;
    }
}
//验证邮箱
function isEmail(email) {
    var myreg = /^\w+((.\w+)|(-\w+))@[A-Za-z0-9]+((.|-)[A-Za-z0-9]+).[A-Za-z0-9]+$/;
    if (!myreg.test(email)) {
        return false;
    } else {
        return true;
    }
}