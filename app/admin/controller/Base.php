<?php
declare(strict_types=1);
namespace app\admin\controller;

use think\App;
use think\exception\HttpResponseException;
use think\facade\Cache;
use think\facade\Config;
use think\facade\Db;
use think\facade\Session;
use think\facade\View;
use think\Response;
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
	protected $admin;
	protected $notCheck;
	/**
	 * 应用实例
	 * @var \think\App
	 */
	protected $app;
	protected $category;
	/**
	 * 是否批量验证
	 * @var bool
	 */
	protected $batchValidate = false;

	/**
	 * 控制器中间件
	 * @var array
	 */
	protected $middleware = [];

	/**
	 * 构造方法
	 * @access public
	 * @param  App  $app  应用对象
	 */
	public function __construct(App $app)
	{
		$this->app = $app;
		$this->request = $this->app->request;

		// 控制器初始化
		$this->initialize();
	}

	// 初始化
	protected function initialize()
	{
		$this->getSystem();
		$this->getMenu();
		$this->checkAuth();
	}

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

	protected function checkAuth()
	{
		//检测是否登录
		if (!Session::has('admin_id')) {
			$this->error('您还没有登录', (string) url('admin/login/index'), '', 0);
		}
		$admin_id = Session::get('admin_id');
		//取得管理
		$this->admin = \app\common\model\Admin::find($admin_id);
		//权限ID
		$this->admin->rolesID = array_column($this->admin->roles->toArray(), 'id');

		//节点ID
		$node_id = [];
		foreach ($this->admin->roles as $key => $value) {
			$rules = explode(',', $value->rules);
			$node_id = array_merge($rules, $node_id);
		}
		$node_id = array_unique($node_id);
		$this->admin->ruleId = $node_id;
		$controller = $this->request->controller();
		$action = $this->request->action();

		if (!in_array('admin/' . $controller . '/' . $action, $this->notCheck)) {
			$auth = app('auth'); //权限对象
			$admin_id = Session::get('admin_id');
			if (!$auth->check('admin/' . $controller . '/' . $action, $admin_id) && $admin_id != 1) {
				$this->error('没有权限');
			}
		}
		View::assign('admin', $this->admin);
	}

	//系统配置信息
	protected function getSystem()
	{

		$this->notCheck = [
			'admin/Index/index',
			'admin/AuthGroup/getjson',
			'admin/System/clear',
			'admin/Api/gettree',
			'admin/Listinfo/checkInfo', //审核
			'admin/Index/welcome',
			'admin/Tongji/index',
		];
		if (!$this->site = Cache::get('system')) {
			$this->site = Db::name('system')->where('id', '1')->find();
			Cache::set('system', $this->site);
		}

		View::assign('site', $this->site);
		if (!Cache::has('Category')) {
			$this->category = Db::name('Category')->order('sort', 'asc')->select()->toArray();
			Cache::set('Category', $this->category);
		} else {
			$this->category = Cache::get('Category');
		}

		//模板路径
		$view_path = $this->app->getappPath() . Config::get('view.view_dir_name') . DIRECTORY_SEPARATOR;
		Cache::set('view_path', $view_path);
	}
	//系统菜单
	protected function getMenu()
	{
		$menu = [];
		$admin_id = Session::get('admin_id');
		$this->admin = $admin_id;
		$auth = app('auth'); //权限对象
		$controller = $this->request->controller(); //当前控制器
		$action = $this->request->action(); //当前方法
		$ruleId = 0; //当前节点ID
		$parentId = 0; //父节点ID
		$childMenu = []; //二级菜单
		$category_id = (int) input('category_id');

		//当前栏目
		$parent_ids_arr = [];
		if ($category_id) {
			$newCategory = array_column($this->category, NULL, 'id');
			$parent_ids = $newCategory[$category_id]['path'] . $category_id;
			$parent_ids_arr = array_filter(explode(',', $parent_ids));
		}
		//权限菜单
		$ruleList = Db::name('rule')->order(['sort' => 'ASC', 'id' => 'ASC'])->select()->toArray();

		//查出当前节点ID
		$ruleName = strtolower("admin/{$controller}/{$action}");
		foreach ($ruleList as $key => $value) {
			$name = strtolower($value['name']);
			if ($ruleName == $name) {
				$ruleId = $value['id'];
			}
		}

		if (!$ruleId && !in_array($ruleName, $this->notCheck)) {
			$this->error('节点不存在' . $ruleName);
		}
		$parentId = get_parent_id($ruleList, $ruleId);
		//创建菜单一级菜单
		foreach ($ruleList as $value) {
			//根据权限显示菜单 超级管理员权限不限 这里指定ID1为超级管理员
			if ($value['status'] == 0) {
				continue;
			}
			$value['current'] = 0; //当前菜单
			$sidArray = [];
			if (!empty($value['sid'])) {
				$sidArray = explode(',', $value['sid']);
				$sidArray = array_filter($sidArray);
				if (in_array($ruleId, $sidArray)) {
					$value['current'] = 1;
				}
			}
			if ($ruleId == $value['id']) {
				$value['current'] = 1;
			}

			if ($auth->check($value['name'], $admin_id) || $admin_id == 1) {
				$value['name'] = (string) url($value['name']);
				$menu[] = $value;
			}
		}

		//构建目录树
		$menu = ypDataTree($menu);
		//获取栏目 用于内容管理
		foreach ($this->category as $key => $value) {
			$this->category[$key]['name'] = (string) url('admin/Listinfo/index', ['category_id' => $value['id']]);
			$this->category[$key]['current'] = (in_array($value['id'], $parent_ids_arr) ? 1 : 0);
		}
		//栏目挂载到内容管理节点
		foreach ($menu as $key => $value) {
			if ($value['title'] == '内容管理') {
				$menu[$key]['children'] = ypDataTree($this->category);
			}
		}
		//创建二级菜单
		foreach ($menu as $key => $value) {
			if ($value['id'] == $parentId) {
				$childMenu = $value;
			}
		}
		$this->menu = $menu;
		View::assign('menu', $menu);
		View::assign('childMenu', $childMenu);
	}

	/**
	 * 操作成功跳转的快捷方法
	 * @access protected
	 * @param  mixed     $msg 提示信息
	 * @param  string    $url 跳转的URL地址
	 * @param  mixed     $data 返回的数据
	 * @param  integer   $wait 跳转等待时间
	 * @param  array     $header 发送的Header信息
	 * @return void
	 */
	protected function success($msg = '', $url = null, $data = '', $wait = 1, array $header = [])
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
		// AJAX返回JSON
		if ($this->request->isAjax()) {
			die(json_encode($result));
		} else {
			$data = View::fetch('public/success', $result);
			$response = Response::create($data, 'html', 200)->header($header);
			throw new HttpResponseException($response);
		}
	}
	/**
	 * 操作错误跳转的快捷方法
	 * @access protected
	 * @param  mixed     $msg 提示信息
	 * @param  string    $url 跳转的URL地址
	 * @param  mixed     $data 返回的数据
	 * @param  integer   $wait 跳转等待时间
	 * @param  array     $header 发送的Header信息
	 * @return void
	 */
	protected function error($msg = '', $url = null, $data = '', $wait = 3, array $header = [])
	{
		if (is_null($url) && isset($_SERVER["HTTP_REFERER"])) {
			$url = $_SERVER["HTTP_REFERER"];
		}
		$result = [
			'code' => 0,
			'msg' => $msg,
			'data' => $data,
			'url' => $url,
			'wait' => $wait,
		];
		// AJAX返回JSON
		if ($this->request->isAjax()) {
			die(json_encode($result));
		} else {
			$data = View::fetch('public/error', $result);
			$response = Response::create($data, 'html', 200)->header($header);
			throw new HttpResponseException($response);
		}
	}
}
