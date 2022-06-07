<?php
// +----------------------------------------------------------------------
// | 一品内容管理系统 [ YPCMS ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2019 东海县一品网络技术有限公司
// +----------------------------------------------------------------------
// | 官方网站: http://www.yipinjishu.com
// +----------------------------------------------------------------------
declare (strict_types = 1);
namespace app\setup\controller;
use think\Controller;
use think\facade\Config;
use think\facade\Db;
use think\facade\Request;
use think\facade\Session;
use think\facade\View;

/**
 *安装平台
 */
class Index extends Base {
	protected function initialize() {
		parent::initialize();
		$tmp = function_exists('gd_info') ? gd_info() : array();
		$config = [
			'url' => $_SERVER['HTTP_HOST'],
			'document_root' => iconv("gbk", "utf-8", $_SERVER['DOCUMENT_ROOT']),
			'server_os' => PHP_OS,
			'server_port' => $_SERVER['SERVER_PORT'],
			'server_soft' => $_SERVER['SERVER_SOFTWARE'],
			'php_version' => PHP_VERSION,
			'max_upload_size' => ini_get('upload_max_filesize'),
			'disk_size' => (int) formatSize(disk_free_space(APP_PATH)) * 1024,
			'gd' => $tmp['GD Version'] ? $tmp['GD Version'] : '未安装',
			'mysql' => function_exists('mysql_connect') || function_exists('mysqli_connect') ? '支持' : '不支持',
		];

		$action = $this->request->action();
		View::assign('action', $action);
		View::assign('config', $config);
	}
	//阅读许可协议
	public function index() {
		Session::set('setone', 1);
		return view('', ['set' => 1]);
	}
	//环境检测
	public function jiancha() {
		$isok = 1;
		if (!Session::has('setone')) {
			$this->error('安装必须按顺序来');
		}
		Session('settwo', 1);
		$dirItems = array(
			array('dir', '可写', 'check', './', '应用目录'),
			array('dir', '可写', 'check', '../config', '应用配置目录'),
			array('dir', '可写', 'check', '../public/static', '静态资源目录'),
			array('dir', '可写', 'check', '../runtime', '运行时目录'),
		);
		foreach ($dirItems as $key => $val) {
			$dirPath = APP_PATH . '/' . $val[3];
			if ('dir' == $val[0]) {
				if (!is_writable($dirPath)) {
					if (is_dir($dirPath)) {
						$val[1] = '可读';
						$val[2] = 'times text-warning';
					} else {
						$val[1] = '不存在';
						$val[2] = 'times text-warning';
					}
					$isok = 0;
				}
			}
			$dirItems[$key] = $val;
		}
		$needfuns = array(
			array('pdo', '支持', 'check', '类'),
			array('pdo_mysql', '支持', 'check', '模块'),
			array('fileinfo', '支持', 'check', '模块'),
			array('curl', '支持', 'check', '模块'),
			array('file_get_contents', '支持', 'check', '函数'),
			array('mb_strlen', '支持', 'check', '函数'),
		);

		foreach ($needfuns as &$val) {
			if (('类' == $val[3] && !class_exists($val[0]))
				|| ('模块' == $val[3] && !extension_loaded($val[0]))
				|| ('函数' == $val[3] && !function_exists($val[0]))
			) {
				$isok = 0;
				$val[1] = '不支持';
				$val[2] = 'times text-warning';
			}
		}
		View::assign('dirItems', $dirItems);
		View::assign('needfuns', $needfuns);
		return view('', ['set' => 2]);
	}
	public function setconfig() {
		if (!Session::has('settwo')) {
			$this->error('安装必须按顺序来');
		}
		Session('setthree', 1);
		return view('', ['set' => 3]);
	}
	public function esql() {

		if (!Session::has('setthree')) {
			$this->error('安装必须按顺序来');
		}
		Session('setfour', 1);
		if ($this->request->isPost()) {
			$data = $this->request->param();
			foreach ($data as $key => $value) {
				if (empty($value)) {
					$this->error('请将表单填写完整');
				}
			}
			//动态配置数据库链接
			$setconfig = ['connections' => [
				'mysql' => $data['mysql'],
			],
			];
			$dbcon = Config::get('database');
			Config::set($setconfig, 'database');
			$mysql = Config::get('database');
			try {
				$database = $data['mysql']['database'];
				$db = Db::connect('mysql')->execute("select version()");
				//写入数据库配置
				$fileCon = '<?php
return [
	// 默认使用的数据库连接配置
	\'default\' => env(\'database.driver\', \'mysql\'),

	// 自定义时间查询规则
	\'time_query_rule\' => [],

	// 自动写入时间戳字段
	// true为自动识别类型 false关闭
	// 字符串则明确指定时间字段类型 支持 int timestamp datetime date
	\'auto_timestamp\' => true,

	// 时间字段取出后的默认时间格式
	\'datetime_format\' => \'Y-m-d H:i:s\',

	// 数据库连接配置信息
	\'connections\' => [
		\'mysql\' => [
			// 数据库类型
			\'type\' => env(\'database.type\', \'mysql\'),
			// 服务器地址
			\'hostname\' => env(\'database.hostname\', \'' . $data['mysql']['hostname'] . '\'),
			// 数据库名
			\'database\' => env(\'database.database\', \'' . $data['mysql']['database'] . '\'),
			// 用户名
			\'username\' => env(\'database.username\', \'' . $data['mysql']['username'] . '\'),
			// 密码
			\'password\' => env(\'database.password\', \'' . $data['mysql']['password'] . '\'),
			// 端口
			\'hostport\' => env(\'database.hostport\', \'' . $data['mysql']['hostport'] . '\'),
			// 数据库连接参数
			\'params\' => [],
			// 数据库编码默认采用utf8
			\'charset\' => env(\'database.charset\', \'utf8\'),
			// 数据库表前缀
			\'prefix\' => env(\'database.prefix\', \'' . $data['mysql']['prefix'] . '\'),

			// 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
			\'deploy\' => 0,
			// 数据库读写是否分离 主从式有效
			\'rw_separate\' => false,
			// 读写分离后 主服务器数量
			\'master_num\' => 1,
			// 指定从服务器序号
			\'slave_no\' => \'\',
			// 是否严格检查字段是否存在
			\'fields_strict\' => true,
			// 是否需要断线重连
			\'break_reconnect\' => false,
			// 监听SQL
			\'trigger_sql\' => env(\'app_debug\', true),
			// 开启字段缓存
			\'fields_cache\' => false,
			// 字段缓存路径
			\'schema_cache_path\' => app()->getRuntimePath() . \'schema\' . DIRECTORY_SEPARATOR,
		],

		// 更多的数据库配置信息
	],
	\'salt\' => \'' . $data['admin_salt'] . '\',
	//备份文件夹
	\'backup_folder\' => \'databasebackup\',
	//备份文件大小单位M
	\'backup_size\' => 2,
	//是否压缩0不压缩1压缩
	\'compress\' => 1,
	//压缩级别123
	\'level\' => 3,
];';

				file_put_contents(APP_PATH . '../config/database.php', $fileCon);

				$envFile = '
APP_DEBUG = true

[APP]
DEFAULT_TIMEZONE = Asia/Shanghai

[DATABASE]
TYPE = mysql
HOSTNAME = ' . $data['mysql']['hostname'] . '
DATABASE = ' . $data['mysql']['database'] . '
USERNAME = ' . $data['mysql']['username'] . '
PASSWORD = ' . $data['mysql']['password'] . '
HOSTPORT = ' . $data['mysql']['hostport'] . '
CHARSET = utf8
DEBUG = false

[LANG]
default_lang = zh-cn
';
				file_put_contents(APP_PATH . '../.env', $envFile);
				Session::set('dbconfig', $data);
				$this->success('参数配置成功', '/setup.php/index/esql.html');
			} catch (\Exception $e) {
				$this->error('数据库连接失败，请检查数据库配置！');
			}
		} else {
			return view('', ['set' => 4]);
		}

	}
	public function oversql() {
		$data = Session::get('dbconfig');
		View::assign("adminuser", $data['admin_user']);
		View::assign("adminpass", $data['admin_pass']);
		return view('', ['set' => 5]);
	}
	public function dosql($i = 0) {
		if (!Session::has('setfour')) {
			$this->error('安装必须按顺序来');
		}
		$request = Request::instance();
		if (Session::has('dbconfig')) {
			$dbcon = Session::get('dbconfig');
			$sqlArr = splitSQL(APP_PATH . 'setup/config/ypcms.sql', $dbcon['mysql']['prefix']);
			$count = count($sqlArr);

			if (!$count) {
				return $this->error('恢复文件解析错误');
			}
			$sqlstr = $sqlArr[$i] . ';';

			$result = doSql($sqlstr);

			if ($result['error']) {
				$this->error($result['message'], '', [
					'sql' => $sqlToExec,
					'exception' => $result['exception'],
				]);
			}

			if ($i >= $count - 1) {
				$res['code'] = 0;
				$res['msg'] = '安装完毕';
				$adminuser = $dbcon['admin_user'];
				$adminpass = $dbcon['admin_pass'];
				$adminpass = md5($adminpass . $dbcon['admin_salt']);

				$createtime = time();
				$ip = $request->ip();
				Db::query("truncate yp_admin");
				$adminsql = "INSERT INTO `yp_admin` (`username`, `password`, `status`, `create_time`, `update_time`) VALUES
('$adminuser', '$adminpass', 1, '$createtime', '$createtime')";
				Db::query($adminsql);
				//写入安装完成标识
				file_put_contents(APP_PATH . 'setup/config/ypcms.lock', 'lock');
			} else {
				$res['code'] = 1;
			}
			$res['i'] = $i + 1;
			$res['bili'] = ceil((($i + 1) / $count * 100));
			$res['count'] = $count;
			$res['sqlstr'] = $sqlstr;
			return $res;
		}
	}
}