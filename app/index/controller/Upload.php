<?php
// +----------------------------------------------------------------------
// | 一品内容管理系统 [ YPCMS ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2019 东海县一品网络技术有限公司
// +----------------------------------------------------------------------
// | 官方网站: http://www.yipinjishu.com
// +----------------------------------------------------------------------
declare (strict_types = 1);
//附件上传
namespace app\index\controller;
use app\common\model\Files as filesModel;
use app\common\model\User;
use think\exception\ValidateException;
use think\facade\Filesystem;

class Upload extends Base {
	protected function initialize() {
		parent::initialize();
		$this->table = new filesModel();
	}
	public function index($id = "0") {

		$file = $this->request->file('file');
		$fileSize = $this->site['upload_size'] * 1024;
		$fileExt = $this->site['upload_type'];

		$type = $this->request->param('type/s');
		$checkFile = ['files' => "filesize:{$fileSize}|fileExt:{$fileExt}"];
		try {
			validate($checkFile)->check(['files' => $file]);
			$savename = Filesystem::disk('public')->putFile('images', $file);
			$path = Filesystem::getDiskConfig('public', 'url') . '/' . str_replace('\\', '/', $savename);

			//附件入库
			$data['name'] = $file->getOriginalName();
			$data['filepath'] = $path;
			$data['addtime'] = time();
			$data['ftype'] = $file->getMime();
			$data['fsize'] = $file->getSize();
			$data['user_id'] = $this->userid;
			$data['isq'] = 1;
			$data['tag'] = $type;

			if ($id && $files = $this->table::find($id)) {
				$files->save($data);
			} else {
				$files = $this->table::create($data);
				$id = $files->id;
			}
			$this->update_field($type, $id);
			$this->success('上传成功', '', '', $data['filepath']);

		} catch (ValidateException $e) {
			return josn($e->getError());
		} catch (\Exception $e) {
			return json($e->getMessage());
		}
	}
	//编辑器上传
	public function editorfile($id = "0", $isq = "0", $isck = '') {
		$config = [
			'size' => $this->site['upload_size'] * 1024,
			'ext' => $this->site['upload_type'],
		];
		$file = $this->request->file('upload');
		$mulu = '../public/' . $this->site['upload_dir'];
		$info = $file->validate($config)->move($mulu);
		if ($info) {

			$data['name'] = $info->getInfo()['name'];
			$data['filepath'] = '/' . $this->site['upload_dir'] . '/' . $info->getSaveName();
			$data['addtime'] = time();
			$data['ftype'] = $info->getInfo()['type'];
			$data['fsize'] = $info->getInfo()['size'];
			$data['user_id'] = $this->userid;
			$data['isq'] = $isq;
			if ($id) {
				$this->table::get($id);
				unlink(YP_ROOT . $r->filepath);
				$this->table->save($data, ["id" => $id]);
			} else {
				$this->table->save($data);
				$fileId = $this->table->id;
			}
			$result = [
				'uploaded' => 1,
				'url' => $data['filepath'],
				'fileName' => $data['name'],
				'error' => ["message" => "上传成功"],
			];
		} else {
			$result = [
				'uploaded' => 0,
				'error' => ["message" => "上传失败"],
			];
		}
		return json($result);
	}
	//更新用户资料
	private function update_field($field, $v) {
		$user = User::find($this->userid);
		$user->$field = $v;
		$user->save();
	}
}
