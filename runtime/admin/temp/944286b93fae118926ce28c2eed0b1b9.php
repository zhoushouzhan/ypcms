<?php /*a:1:{s:48:"F:\wwwroot\ypcms\app\admin\view\login\index.html";i:1653631027;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8" />
    <title><?php echo htmlspecialchars($site['sitename']); ?>后台登录</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link
      rel="stylesheet"
      href="/static/src/layui/css/layui.css?d=<?php echo date('YmdHis'); ?>"
    />
    <link
      rel="stylesheet"
      href="/static/admin/css/admin.css?d=<?php echo date('YmdHis'); ?>"
    />
  </head>
  <body oncontextmenu="self.event.returnValue=false" onselect="return false">
    <div class="loginbg">
      <div class="login">
        <div class="logo"><img src="/static/admin/images/yplogo.png" /></div>
        <div class="login-title"><?php echo htmlspecialchars($site['sitename']); ?></div>
        <form
          class="layui-form login-form"
          action="<?php echo url('doLogin'); ?>"
          method="post"
        >
          <input type="hidden" name="__token__" value="<?php echo token(); ?>" />
          <div class="layui-form-item">
            <div class="layui-input-block">
              <input
                type="text"
                name="username"
                required
                lay-verify="required"
                autocomplete="off"
                class="layui-input"
                placeholder="账号|手机号"
                readonly="readonly"
              />
            </div>
          </div>
          <div class="layui-form-item">
            <div class="layui-input-block">
              <input
                type="password"
                name="password"
                required
                lay-verify="required"
                class="layui-input"
                placeholder="密码"
                readonly="readonly"
              />
            </div>
          </div>
          <div class="layui-form-item">
            <div class="layui-input-block">
              <input
                type="text"
                name="verify"
                required
                lay-verify="required"
                class="layui-input layui-input-inline"
                placeholder="验证码"
              />
              <img
                src="<?php echo captcha_src(); ?>"
                alt="点击更换"
                title="点击更换"
                onclick="this.src='<?php echo captcha_src(); ?>?time='+Math.random()"
                class="captcha"
              />
            </div>
          </div>
          <div class="layui-form-item">
            <div class="layui-input-block">
              <button class="layui-btn" lay-submit lay-filter="*">登 录</button>
            </div>
          </div>
          <div class="copy">
            &copy;2018-<?php echo date("Y"); ?>&nbsp; 东海县一品网络技术有限公司
          </div>
        </form>
      </div>
    </div>
    <script>
      // 定义全局JS变量
      var YPVAR = {
        base_url: "/static",
      };
    </script>
    <script src="/static/src/jquery/jquery.min.js"></script>
    <script src="/static/src/jquery/jquery.cookie.min.js"></script>
    <script src="/static/src/layui/layui.js?d=<?php echo date('YmdHis'); ?>"></script>
    <script src="/static/admin/js/admin.js?d=<?php echo date('YmdHis'); ?>"></script>
    <script>
      //清空自动填充
      setTimeout(function removeReadonly() {
        $("input[name=username],input[name=password]").removeAttr("readonly");
      }, 1000);
      //顶窗检测
      if (top.location != self.location) {
        top.location = self.location;
      }
    </script>
  </body>
</html>
