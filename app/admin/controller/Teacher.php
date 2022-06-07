<?php
declare (strict_types = 1);
namespace app\admin\controller;
use think\facade\View;

class Teacher extends Base {
	protected function initialize() {
		parent::initialize();
		$this->grade = \app\common\model\Grade::select();
		View::assign('gradeList', $this->grade);
	}

	public function index($page = 1, $keyboard = '', $limit = 15) {
		$grade_id = input('grade_id') ? input('grade_id') : $this->grade[0]->id;
		$bgroup_id = input('bgroup_id');
		$teacher = [];
		$bgroup = [];

		foreach ($this->grade as $key => $value) {
			if ($grade_id == $value->id) {
				$bgroup = $value->bgroup;
				$bgroup_id = $bgroup_id ? $bgroup_id : $value->bgroup[0]->id;
				foreach ($bgroup as $k => $v) {
					if ($v->id == $bgroup_id) {
						$teacher = $v->teacher;
					}
				}
			}
		}
		View::assign('grade_id', $grade_id);
		View::assign('bgroup', $bgroup);
		View::assign('bgroup_id', $bgroup_id);
		View::assign('teacher', $teacher);
		return view('');
	}

	public function view($id = 0) {
		if (!$r = \app\common\model\Admin::find($id)) {
			$this->error('错误');
		}
		View::assign('r', $r);

		return view();
	}
}
?>