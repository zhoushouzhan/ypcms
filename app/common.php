<?php

use think\facade\Cache;
use think\facade\Db;
// 应用公共文件
//数组层级转换
function ypDataTree($data, $pid = 0, $deep = 0)
{
	$tree = [];
	foreach ($data as $row) {
		if ($row['pid'] == $pid) {
			$row['deep'] = $deep;
			$children = ypDataTree($data, $row['id'], $deep + 1);
			if ($children) {
				$row['children'] = $children;
			} else {
				$row['children'] = [];
			}
			$tree[] = $row;
		}
	}
	return $tree;
}
//格式化size显示
function formatSize($b, $times = 0)
{
	if ($b > 1024) {
		$temp = $b / 1024;
		return formatSize($temp, $times + 1);
	} else {
		$unit = 'B';
		switch ($times) {
			case '0':
				$unit = 'B';
				break;
			case '1':
				$unit = 'KB';
				break;
			case '2':
				$unit = 'MB';
				break;
			case '3':
				$unit = 'GB';
				break;
			case '4':
				$unit = 'TB';
				break;
			case '5':
				$unit = 'PB';
				break;
			case '6':
				$unit = 'EB';
				break;
			case '7':
				$unit = 'ZB';
				break;
			default:
				$unit = '单位未知';
		}
		return sprintf('%.2f', $b) . $unit;
	}
}
//键名判断
function inAarrays($str, $arr, $key)
{
	foreach ($arr as $k => $v) {
		if ($v[$key] == $str) {
			return true;
		}
	}
	return false;
}
//取得随机数
function makeStr($length)
{
	$chars = array(
		'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h',
		'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's',
		't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D',
		'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O',
		'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
		'0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '!',
		'@', '#', '$', '%', '^', '&', '*', '(', ')', '-', '_',
		'[', ']', '{', '}', '<', '>', '~', '`', '+', '=', ',',
		'.', ';', ':', '/', '?', '|'
	);
	$keys = array_rand($chars, $length);
	$password = '';
	for ($i = 0; $i < $length; $i++) {
		$password .= $chars[$keys[$i]];
	}
	return $password;
}
//返回订单号
function ordersn($pre = '')
{
	$ddno = date('YmdHis') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
	return $pre . $ddno;
}
//验证手机号码
function check_mobile_number($mobile)
{
	if (!is_numeric($mobile)) {
		return false;
	}
	$reg = '#^13[\d]{9}$|^16[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,6,7,8]{1}\d{8}$|^18[\d]{9}$|^19[\d]{9}$#';
	return preg_match($reg, $mobile) ? true : false;
}
//验证邮箱
function check_email($email)
{
	$result = trim($email);
	if (!filter_var($result, FILTER_VALIDATE_EMAIL)) {
		return false;
	}
	return true;
}
//取得随机数字
function makeNumber($length)
{
	$chars = '1234567890';
	$key = '';
	for ($i = 0; $i < $length; $i++) {
		$key .= $chars[mt_rand(0, 9)];
	}
	return $key;
}
//更新所有子节点
function updateNode($data)
{
	$update = [];
	foreach ($data as $key => $value) {
		$sid = getSid($value['id'], $data);
		if ($sid) {
			$update = ['id' => $value['id'], 'sid' => $sid];
			db::name('rule')->update($update);
		}
	}
}

//子节点获取
function getSid($pid, $data)
{
	$str = '';
	foreach ($data as $key => $value) {
		if ($pid == $value['pid']) {
			if (getSid($value['id'], $data)) {
				$str .= $value['id'] . ',' . getSid($value['id'], $data);
			} else {
				$str .= $value['id'] . ',';
			}
		}
	}
	return $str;
}
//返回栏目PATH:0,1,2
function getPath($pid, $category)
{
	$path = '';
	foreach ($category as $v) {
		if ($pid == $v['id']) {
			if ($v['pid']) {
				$path .=  $v['id'] . ',' . getPath($v['pid'], $category);
			} else {
				return  $v['id'];
			}
		}
	}
	return $path;
}


//当前位置
function get_path_info($category_id = 0)
{
	$path_info = [];
	$category = array_column(cache::get('Category'), NULL, 'id');
	$path_info = [];
	$category_ids = $category[$category_id]['path'] . $category_id;
	$ids_arr = explode(',', $category_ids);
	foreach ($ids_arr as $value) {
		if (!$value) {
			continue;
		}
		$path_info[] = $category[$value];
	}

	return $path_info;
}
//判断HTTPS
function is_https()
{
	if (defined('HTTPS') && HTTPS) {
		return true;
	}

	if (!isset($_SERVER)) {
		return FALSE;
	}

	if (!isset($_SERVER['HTTPS'])) {
		return FALSE;
	}

	if ($_SERVER['HTTPS'] === 1) {
		//Apache
		return TRUE;
	} elseif ($_SERVER['HTTPS'] === 'on') {
		//IIS
		return TRUE;
	} elseif ($_SERVER['SERVER_PORT'] == 443) {
		//其他
		return TRUE;
	}
	return FALSE;
}

//CURL发送数据-POST-GET--HTTP/HTTPS
function httprequest($url, $data = null)
{
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
	if (!empty($data)) {
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	}
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
	$output = curl_exec($curl);
	curl_close($curl);
	return $output;
}

/*
文字截取
$str:要截取的字符串
$start=0：开始位置，默认从0开始
$length：截取长度
$charset=”utf-8″：字符编码，默认UTF－8
$suffix=true：是否在截取后的字符后面显示省略号，默认true显示，false为不显示
 */
function msubstr($str, $start = 0, $length, $charset = "utf-8", $suffix = true)
{
	if (function_exists("mb_substr")) {
		if ($suffix) {
			return mb_substr($str, $start, $length, $charset) . "...";
		} else {
			return mb_substr($str, $start, $length, $charset);
		}
	} elseif (function_exists('iconv_substr')) {
		if ($suffix) {
			return iconv_substr($str, $start, $length, $charset) . "...";
		} else {
			return iconv_substr($str, $start, $length, $charset);
		}
	}
	$re['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
	$re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
	$re['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
	$re['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
	preg_match_all($re[$charset], $str, $match);
	$slice = join("", array_slice($match[0], $start, $length));
	if ($suffix) {
		return $slice . "...";
	} else {
		return $slice;
	}
}

//取出班级所有宿舍
function getBanjiDorm($banjiID)
{

	$banji = \app\common\model\Banji::find($banjiID);

	$student = $banji->student;
	$dorm = [];
	foreach ($student as $key => $value) {
		$dorm[$value->dorm_id] = $value->dorm_id;
	}
	return $dorm;
}
//取出级组所有宿舍
function getBgroupDorm($bgroupId)
{
	$bgroup = \app\common\model\Bgroup::find($bgroupId);
	$dorm = [];

	foreach ($bgroup->banji as $key => $value) {
		$dorm = array_merge($dorm, getBanjiDorm($value->id));
	}
	return $dorm;
}
//取出年级所有宿舍
function getGradeDorm($gradeId)
{
	$grade = \app\common\model\Grade::find($gradeId);
	$dorm = [];
	foreach ($grade->banji as $key => $value) {
		$dorm = array_merge($dorm, getBanjiDorm($value->id));
	}
	return $dorm;
}

//取出班级所有学生
function getBanjiStudent($banjiID, $sex = 0)
{

	$map[] = ['banji_id', '=', $banjiID];
	if ($sex) {
		$map[] = ['sex', '=', $sex];
	}

	return \app\common\model\Student::where($map)->select()->toArray();
}

//取出级组所有学生
function getBgroupStudent($bgroupId, $sex = 0)
{
	$bgroup = \app\common\model\Bgroup::find($bgroupId);
	$student = [];

	foreach ($bgroup->banji as $key => $value) {
		$student = array_merge($student, getBanjiStudent($value->id, $sex));
	}
	return $student;
}

/**
 * 服务：将时间段按天进行分割
 * @param string $start_date   @起始日期('Y-m-d H:i:s')
 * @param string $end_date     @结束日期('Y-m-d H:i:s')
 * @return array $mix_time_data=array(
'start_date'=>array([N]'Y-m-d H:i:s'),
'end_date'=>array([N]'Y-m-d H:i:s'),
'days_list'=>array([N]'Y-m-d'),
'days_inline'=>array([N]'Y-m-d H:i:s'),
'times_inline'=>array([N]'time()')
)
 */
function Date_segmentation($start_date, $end_date, $i = 1)
{
	/******************************* 时间分割 ***************************/

	//如果为空，则从今天的0点为开始时间
	if (!empty($start_date)) {
		$start_date = date('Y-m-d H:i:s', strtotime($start_date));
	} else {
		$start_date = date('Y-m-d 00:00:00', time());
	}

	//如果为空，则以明天的0点为结束时间（不存在24:00:00，只会有00:00:00）
	if (!empty($end_date)) {
		$end_date = date('Y-m-d H:i:s', strtotime($end_date));
	} else {
		$end_date = date('Y-m-d 00:00:00', strtotime('+1 day'));
	}

	//between 查询 要求必须是从低到高
	if ($start_date > $end_date) {
		$ttt = $start_date;
		$start_date = $end_date;
		$end_date = $ttt;
	} elseif ($start_date == $end_date) {
		echo '时间输入错误';
		die;
	}

	$time_s = strtotime($start_date);
	$time_e = strtotime($end_date);
	$seconds_in_a_day = 86400 * $i;

	//生成中间时间点数组（时间戳格式、日期时间格式、日期序列）
	$days_inline_array = array();
	$times_inline_array = array();

	//日期序列
	$days_list = array();
	//判断开始和结束时间是不是在同一天
	$days_inline_array[0] = $start_date; //初始化第一个时间点
	$times_inline_array[0] = $time_s; //初始化第一个时间点
	$days_list[] = date('Y-m-d', $time_s); //初始化第一天
	if (
		date('Y-m-d', $time_s)
		== date('Y-m-d', $time_e)
	) {
		$days_inline_array[1] = $end_date;
		$times_inline_array[1] = $time_e;
	} else {
		/**
		 * A.取开始时间的第二天凌晨0点
		 * B.用结束时间减去A
		 * C.用B除86400取商，取余
		 * D.用A按C的商循环+86400，取得分割时间点，如果C没有余数，则最后一个时间点 与 循环最后一个时间点一致
		 */
		$A_temp = date('Y-m-d 00:00:00', $time_s + $seconds_in_a_day);
		$A = strtotime($A_temp);
		$B = $time_e - $A;
		$C_quotient = floor($B / $seconds_in_a_day); //商舍去法取整
		$C_remainder = fmod($B, $seconds_in_a_day); //余数

		$days_inline_array[1] = $A_temp;
		$times_inline_array[1] = $A;
		$days_list[] = date('Y-m-d', $A); //第二天
		for ($increase_time = $A, $c_count_t = 1; $c_count_t <= $C_quotient; $c_count_t++) {
			$increase_time += $seconds_in_a_day;
			$days_inline_array[] = date('Y-m-d H:i:s', $increase_time);
			$times_inline_array[] = $increase_time;
			$days_list[] = date('Y-m-d', $increase_time);
		}
		$days_inline_array[] = $end_date;
		$times_inline_array[] = $time_e;
	}

	return array(
		'start_date' => $start_date,
		'end_date' => $end_date,
		'days_list' => $days_list,
		'days_inline' => $days_inline_array,
		'times_inline' => $times_inline_array,
	);
}

function dateFmat($date, $format)
{
	return date($format, strtotime($date));
}

function getWeek()
{
	$weekarray = ["日", "一", "二", "三", "四", "五", "六"];
	return "星期" . $weekarray[date("w")];
}
