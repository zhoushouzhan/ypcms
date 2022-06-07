<?php
// +----------------------------------------------------------------------
// | 一品内容管理系统 [ YPCMS ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2019 东海县一品网络技术有限公司
// +----------------------------------------------------------------------
// | 官方网站: http://www.yipinjishu.com
// +----------------------------------------------------------------------
declare(strict_types=1);

namespace app\index\controller;

use app\common\model\User;
use think\App;
use think\exception\ValidateException;
use think\facade\Cache;
use think\facade\Db;
use think\facade\Session;
use think\facade\View;
use think\Validate;

/**
 * 控制器基础类
 */
abstract class Base
{
	/**
	 * Request实例
	 * @var \think\Request
	 */
	protected $request;

	/**
	 * 应用实例
	 * @var \think\App
	 */
	protected $app;

	/**
	 * 是否批量验证
	 * @var bool
	 */
	protected $batchValidate = false;

	/**
	 * 控制器中间件
	 * @var array
	 */
	protected $middleware = ['checkLogin'];

	/**
	 * 构造方法
	 * @access public
	 * @param  App  $app  应用对象
	 */
	public function __construct(App $app)
	{
		$this->app = $app;
		$this->request = $this->app->request;
		$this->sendMsg = app('sendMsg');
		$this->categoryId = (int) $this->request->param('categoryId');
		$this->modName = (string) $this->request->param('mod_name');
		// 控制器初始化
		$this->initialize();
	}

	// 初始化
	protected function initialize()
	{
		$this->checkAuth();
		$this->getSystem();
		View::assign([
			'category_id' => $this->categoryId,
		]);
	}
	protected function getSystem()
	{
		if (Cache::has('site')) {
			$this->site = Cache::get('site');
		} else {
			$this->site = Db::name('system')->find(1);
			Cache::set('site', $this->site);
		}
		View::assign('site', $this->site);
		if (!Cache::has('Category')) {
			$this->category = Db::name('Category')->order('sort', 'desc')->where('status', 1)->select()->toArray();
			Cache::set('Category', $this->category, 3600);
		} else {
			$this->category = Cache::get('Category');
		}
		$category = array_column($this->category, NULL, 'id');
		$parent_ids_arr = [];
		if ($this->categoryId) {
			$parent_ids = $category[$this->categoryId]['path'] . $this->categoryId;
			$parent_ids_arr = array_filter(explode(',', $parent_ids));
		}
		//构建导航
		$nav = [];
		foreach ($this->category as $key => $value) {
			if ($value['status'] == 0) {
				continue;
			}
			if (in_array($value['id'], $parent_ids_arr)) {
				$value['current'] = 1;
			} else {
				$value['current'] = 0;
			}

			$nav[$key] = $value;
		}
		View::assign('nav', ypDataTree($nav)); //栏目转成树形结构ypDataTree
	}
	protected function checkAuth()
	{
		$this->userid = Session::get('userid');
		$controller = $this->request->controller();
		$action = $this->request->action();

		View::assign('controller', $controller);
		View::assign('action', $action);

		if ($this->userid) {
			$this->user = User::find($this->userid);
			View::assign("user", $this->user);
		}
	}

	/**
	 * 验证数据
	 * @access protected
	 * @param  array        $data     数据
	 * @param  string|array $validate 验证器名或者验证规则数组
	 * @param  array        $message  提示信息
	 * @param  bool         $batch    是否批量验证
	 * @return array|string|true
	 * @throws ValidateException
	 */
	protected function validate(array $data, $validate, array $message = [], bool $batch = false)
	{
		if (is_array($validate)) {
			$v = new Validate();
			$v->rule($validate);
		} else {
			if (strpos($validate, '.')) {
				// 支持场景
				[$validate, $scene] = explode('.', $validate);
			}
			$class = false !== strpos($validate, '\\') ? $validate : $this->app->parseClass('validate', $validate);
			$v = new $class();
			if (!empty($scene)) {
				$v->scene($scene);
			}
		}

		$v->message($message);

		// 是否批量验证
		if ($batch || $this->batchValidate) {
			$v->batch(true);
		}

		return $v->failException(true)->check($data);
	}

	protected function success($msg = '', $url = null, $type = '', $data = '', $wait = 3, array $header = [])
	{
		if (is_null($url) && isset($_SERVER["HTTP_REFERER"])) {
			$url = $_SERVER["HTTP_REFERER"];
		}
		$result = [
			'code' => 1,
			'msg' => $msg,
			'data' => $data,
			'url' => $url,
			'wait' => $wait,
		];

		print_r(json_encode($result));
	}
	protected function error($msg = '', $url = null, $type = '', $data = '', $code = 0, $wait = 3, array $header = [])
	{
		if (is_null($url) && isset($_SERVER["HTTP_REFERER"])) {
			$url = $_SERVER["HTTP_REFERER"];
		}

		$result = [
			'code' => $code,
			'msg' => $msg,
			'data' => $data,
			'url' => $url,
			'wait' => $wait,
		];

		print_r(json_encode($result));
		die;
	}
}
