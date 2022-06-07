<?php
// +----------------------------------------------------------------------
// | 一品内容管理系统 [ YPCMS ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2019 东海县一品网络技术有限公司
// +----------------------------------------------------------------------
// | 官方网站: http://www.yipinjishu.com
// +----------------------------------------------------------------------
declare (strict_types = 1);

namespace app\index\middleware;
use app\BaseController;
use think\facade\Session;

class CheckLogin extends BaseController {
	/**
	 * 后台权限验证文件
	 *
	 * @param \think\Request $request
	 * @param \Closure       $next
	 * @return Response
	 */
	public function handle($request, \Closure $next) {
		//检测是否登录
		if (!Session::has('userid') && $request->controller() == 'User') {
			if ($request->isAjax()) {
				$this->error('您还没登录', '/login/index');
			} else {
				return redirect('/login/index');
			}
		}
		return $next($request);
	}
}
