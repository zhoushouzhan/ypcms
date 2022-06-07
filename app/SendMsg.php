<?php
namespace util;
use app\BaseController;
use PHPMailer\PHPMailer\PHPMailer;
use think\facade\Request;
use think\facade\Session;

class Sendmsg extends BaseController {
	protected $appid;
	protected $appkey;
	protected $url;
	protected $mobile;
	protected function initialize() {
		//APPID
		$this->appid = '';
		//APPKEY
		$this->appkey = '';
		$this->project = '';
		//接口地址
		$this->url = 'https://api.mysubmail.com/message/xsend';
	}
	//注册手机验证码
	public function reg() {
		//注册验证码模板
		$project = 'w22Qd2';
		$code = makeNumber(6);
		Session::set('mobile', $this->mobile);
		Session::set('regKey', $code);
		$data['appid'] = $this->appid;
		$data['to'] = $this->mobile;
		$data['project'] = $project;
		$data['signature'] = $this->appkey;
		$data['vars'] = json_encode(array("code" => $code, "time" => 60));
		$i = 0;
		$params_str = '';
		foreach ($data as $k => $value) {
			$i++;
			$params_str .= ($i > 1 ? "&" : "") . $k . "=" . $value;
		}
		$res = httprequest($this->url, $params_str);
		$res = json_decode($res, true);

		if ($res['status'] == 'success') {
			$this->success('注册验证码发送成功');
		} else {
			$this->error('短信发送失败');
		}
	}

	public function getCode() {
		$sender = $this->request->param('sender');
		if (check_mobile_number($sender)) {
			$this->sendMobileCode($sender);
		}
		if (check_email($sender)) {
			$this->sendEmailCode($sender);
		}
	}

	//发送手机验证码
	public function sendMobileCode($mobile) {
		//注册验证码模板
		$params_str = '';
		$code = makeNumber(6);
		Session::set('mobile', $mobile);
		Session::set('checkCode', $code);
		$data['appid'] = $this->appid;
		$data['to'] = $mobile;
		$data['project'] = $this->project;
		$data['signature'] = $this->appkey;
		$data['vars'] = json_encode(array("code" => $code, "time" => 60));
		$i = 0;
		foreach ($data as $k => $value) {
			$i++;
			$params_str .= ($i > 1 ? "&" : "") . $k . "=" . $value;
		}
		$res = httprequest($this->url, $params_str);
		$res = json_decode($res, true);
		if ($res['status'] == 'success') {
			$this->success('手机验证码发送成功');
		} else {
			$this->error('短信发送失败');
		}
	}
	//发送邮箱验证码
	public function sendEmailCode($email) {
		//邮箱验证码模板
		$code = makeNumber(6);
		Session::set('email', $email);
		Session::set('checkCode', $code);
		$title = "您的验证码";
		$send = $this->sendmail($title, $code, $email);
		if ($send == 'ok') {
			$this->success('发送成功');
		} else {
			$this->error('发送失败:' . $send);
		}
	}
	public function sendmail($title = "", $content = "", $toemail = "") {
		$mail = new PHPMailer();
		$mail->isSMTP(); // 使用SMTP服务
		$mail->CharSet = "utf8"; // 编码格式为utf8，不设置编码的话，中文会出现乱码
		$mail->Host = "ssl://smtp.163.com"; // 发送方的SMTP服务器地址
		$mail->SMTPAuth = true; // 是否使用身份验证
		$mail->Username = ""; // 发送方的163邮箱用户名
		$mail->Password = ""; // 客户端授权密码
		$mail->SMTPSecure = "ssl"; // 使用ssl协议方式
		$mail->Port = 994; // 163邮箱的ssl协议方式端口号是465/994
		$mail->setFrom("发件人", "zhl"); // 设置发件人信息
		$mail->addAddress($toemail, '收件'); // 设置收件人信息
		$mail->Subject = $title; // 邮件标题
		$mail->Body = $content; // 邮件正文
		if ($mail->send()) {
			return 'ok';
		} else {
			return $mail->ErrorInfo;
		}
	}
}