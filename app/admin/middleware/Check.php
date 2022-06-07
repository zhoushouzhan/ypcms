<?php
// +----------------------------------------------------------------------
// | 一品内容管理系统 [ YPCMS ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2019 东海县一品网络技术有限公司
// +----------------------------------------------------------------------
// | 官方网站: http://www.yipinjishu.com
// +----------------------------------------------------------------------
declare (strict_types = 1);

namespace app\admin\middleware;
use think\facade\Session;

class Check {
	/**
	 * 后台权限验证文件
	 *
	 * @param \think\Request $request
	 * @param \Closure       $next
	 * @return Response
	 */
	public function handle($request, \Closure $next) {
		//检测是否登录
		if (!Session::has('admin_id')) {
			return redirect('/login/index');
		}
		return $next($request);
	}
}
