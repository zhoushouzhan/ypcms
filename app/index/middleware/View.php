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
use think\facade\Config;

class View {
	/**
	 * 判断终端
	 *
	 * @param \think\Request $request
	 * @param \Closure       $next
	 * @return Response
	 */
	public function handle($request, \Closure $next) {
		$viewPath = Config::get('view.view_dir_name');
		if (Config::get('view.mobile') == true && $request->isMobile()) {
			Config::set(['view_dir_name' => str_replace('{device}', 'mobile', $viewPath)], 'view');
		} else {
			Config::set(['view_dir_name' => str_replace('{device}', 'pc', $viewPath)], 'view');
		}
		$response = $next($request);
		return $response;
	}
}
