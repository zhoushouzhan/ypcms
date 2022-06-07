<?php
declare (strict_types = 1);

namespace app;

use think\App;
use think\exception\ValidateException;
use think\Validate;

/**
 * 控制器基础类
 */
abstract class BaseController {
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
	public function __construct(App $app) {
		$this->app = $app;
		$this->request = $this->app->request;

		// 控制器初始化
		$this->initialize();
	}

	// 初始化
	protected function initialize() {}

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
	protected function validate(array $data, $validate, array $message = [], bool $batch = false) {
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

	protected function success($msg = '', $url = null, $type = '', $data = '', $wait = 3, array $header = []) {
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

		// 把跳转模板的渲染下沉，这样在 response_send 行为里通过getData()获得的数据是一致性的格式
		if ('html' == strtolower($type)) {
			$data = View::fetch('/dispatch_jump', $result);
			$response = Response::create($data, $type, 200)->header($header);
			throw new HttpResponseException($response);
		} else {
			print_r(json_encode($result));
		}
	}
	protected function error($msg = '', $url = null, $type = '', $data = '', $code = 0, $wait = 3, array $header = []) {
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

		// 把跳转模板的渲染下沉，这样在 response_send 行为里通过getData()获得的数据是一致性的格式
		if ('html' == strtolower($type)) {
			$data = View::fetch('/dispatch_jump', $result);
			$response = Response::create($data, $type, 200)->header($header);
			throw new HttpResponseException($response);
		} else {
			die(json_encode($result));
		}
	}
}