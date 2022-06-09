<?php

declare(strict_types=1);

namespace app\setup\controller;

use think\App;
use think\exception\HttpResponseException;
use think\exception\ValidateException;
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
	protected function success($msg = '', $url = null, $data = '', $wait = 3, array $header = [])
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
			print_r(json_encode($result));
		} else {
			$data = View::fetch('public/error', $result);
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
