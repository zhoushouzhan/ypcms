/*
* @Author: zhou
* @Date:   2020-01-12 21:17:07
* @Last Modified by:   zhou
* @Last Modified time: 2020-01-12 21:18:58
*/
    var carousel = layui.carousel;
    var $=layui.$;
    var form=layui.form;
/**
 * 通用表单提交(AJAX方式)
 */
form.on('submit(*)', function (data) {
    t=data.form.t;
    console.log(t);
    $.ajax({
        url: data.form.action,
        type: data.form.method,
        data: $(data.form).serialize(),
        success: function (info) {
            if (info.code === 1) {
                //正确提醒
                layer.msg(info.msg,{icon: 1,anim:5,offset: '300px',shade: [0.8, '#393D49'],time: 1000},function(){
                    window.location.href=info.url;
                });
            }else{
                //错误提醒
                layer.alert(info.msg,{icon: 2,title:'温馨提示',anim:1,closeBtn:2,offset: '300px'});
            }
            //如果有验证码刷新
            if($('.captcha')){
                $('.captcha').attr('src',$('.captcha').attr('src'));
                $("input[name=verify]").val('');
            }
        }
    });

    return false;
});