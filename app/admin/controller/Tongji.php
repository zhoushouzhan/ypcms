<?php
declare (strict_types = 1);
namespace app\admin\controller;
use app\BaseController;

class Tongji extends BaseController {
	public function index() {
		$type = input('type/d'); //统计类型
		$id = input('id/d'); //周期ID
		$dormId = input('dormId/d'); //宿舍ID
		$banjiId = input('banjiId/d'); //班级ID
		$bgroupId = input('bgroupId/d'); //班级ID
		$gradeId = input('gradeId/d'); //年级ID
		$StudentId = input('StudentId/d'); //学生ID
		$programId = input('programId/d'); //评分项目ID
		//统计：显示该宿舍本学期内每个周期的评分曲线
		if ($dormId && $type == 1) {
			$this->dorm1($id, $dormId);
		}
		//统计：本宿舍所有男/女生的总分，宿舍的总分，按周期分开
		//X轴：周期
		//Y轴：	1、学生总分：宿舍关联班级所有男/女生当天的总分
		//		2、宿舍总分：宿舍当天总分
		if ($dormId && $type == 2) {
			$this->dorm2($id, $dormId);
		}
		//班级统计1:当前周期内本班每日所有宿舍纪律扣分、宿舍卫生扣分、纪律+卫生总分，三条曲线图。支持查看本学期内历次周期内的曲线图
		if ($banjiId && $type == 1) {
			$this->banji1($id, $banjiId);
		}
		//
		if ($banjiId && $type == 2) {
			$this->banji2($id, $banjiId);
		}
		//班级各量化项目总分
		if ($banjiId && $type == 3) {
			$this->banjiProgram($id, $banjiId);
		}
		//本级组宿舍评分
		if ($bgroupId && $type == 1) {
			$this->bgroup1($id, $bgroupId);
		}
		//本级组与年级总分对比
		if ($bgroupId && $type == 2) {
			$this->bgroup2($id, $bgroupId);
		}
		//本级组班级量化类别总分
		if ($bgroupId && $type > 2) {
			$this->bgroupProgram($id, $bgroupId, $type);
		}

		//本年级组宿舍评分
		if ($gradeId && $type == 1) {
			$this->grade1($id, $gradeId);
		}
		//本级组班级量化类别总分
		if ($gradeId && $type > 3) {
			$this->gradeProgram($id, $gradeId, $type);
		}

		//学生均分
		if ($StudentId && $programId > 0) {
			$this->student1($id, $StudentId, $programId);
		}
	}
	//统计：显示该宿舍本学期内每个周期的评分曲线
	//周期ID，宿舍ID
	public function dorm1($id, $dormId) {
		$r = \app\common\model\Xueqi::find($id);
		$stime = $r->stime;
		$etime = $r->etime;
		$dayArr = Date_segmentation($stime, $etime);

		$allDay = $dayArr['days_list'];
		//量化类别
		$ws = 1;
		$jl = 2;
		//取出周期内宿舍评分
		$map[] = ['dorm_id', '=', $dormId];
		$map[] = ['update_time', 'between', [strtotime($stime), strtotime($etime)]];
		$map[] = ['program_id', 'in', [$ws, $jl]];

		$dormScore = \app\common\model\Score::where($map)->select();

		foreach ($allDay as $key => $value) {
			$today_ws = [];
			$today_jl = [];
			$today_fen = [];
			//取出当天卫生评分
			foreach ($dormScore as $v) {
				if (dateFmat($v->update_time, "Y-m-d") == $value && $v->program_id == $ws) {
					$today_ws[] = $v->fen;
				}
			}
			$item_ws[] = array_sum($today_ws);
			//取出当天纪律评分
			foreach ($dormScore as $v) {
				if (dateFmat($v->update_time, "Y-m-d") == $value && $v->program_id == $jl) {
					$today_jl[] = $v->fen;
				}
			}
			$item_jl[] = array_sum($today_jl);
			//当天的总分
			foreach ($dormScore as $v) {
				if (dateFmat($v->update_time, "Y-m-d") == $value) {
					$today_fen[] = $v->fen;
				}
			}
			$item_fen[] = array_sum($today_fen);
		}
		//曲线数据
		$data['legend']['data'] = ['总分', '卫生', '纪律'];
		$data['tooltip'] = ['trigger' => 'axis', 'axisPointer' => ['type' => 'shadow']];
		$data['xAxis'] = ['type' => 'category', 'data' => $allDay];
		$data['yAxis'] = ['type' => 'value'];
		$data['series'] = [
			['name' => '总分', 'data' => $item_fen, 'type' => 'line', 'smooth' => true],
			['name' => '卫生', 'data' => $item_ws, 'type' => 'line', 'smooth' => true],
			['name' => '纪律', 'data' => $item_jl, 'type' => 'line', 'smooth' => true],
		];
		$echarts['option'] = $data;
		$this->success('ok', '', '', $data);
	}
	//统计：显示本宿舍所属班级男/女性成员宿舍均分曲线，宿舍总分曲线
	//周期ID，宿舍ID
	public function dorm2($id, $dormId) {
		$r = \app\common\model\Xueqi::find($id);
		$stime = $r->stime;
		$etime = $r->etime;
		$dayArr = Date_segmentation($stime, $etime);

		$allDay = $dayArr['days_list'];
		//量化类别
		$ws = 1;
		$jl = 2;
		//取出周期内宿舍评分
		$map[] = ['dorm_id', '=', $dormId];
		$map[] = ['update_time', 'between', [strtotime($stime), strtotime($etime)]];
		$map[] = ['program_id', 'in', [$ws, $jl]];
		$dormScore = \app\common\model\Score::where($map)->select();
		foreach ($allDay as $key => $value) {
			$today_ws = [];
			$today_jl = [];
			$today_fen = [];
			//取出当天卫生评分
			foreach ($dormScore as $v) {
				if (dateFmat($v->update_time, "Y-m-d") == $value && $v->program_id == $ws) {
					$today_ws[] = $v->fen;
				}
			}
			$item_ws[] = array_sum($today_ws);
			//取出当天纪律评分
			foreach ($dormScore as $v) {
				if (dateFmat($v->update_time, "Y-m-d") == $value && $v->program_id == $jl) {
					$today_jl[] = $v->fen;
				}
			}
			$item_jl[] = array_sum($today_jl);
			//当天的总分
			foreach ($dormScore as $v) {
				if (dateFmat($v->update_time, "Y-m-d") == $value) {
					$today_fen[] = $v->fen;
				}
			}
			$item_fen[] = array_sum($today_fen);
		}
		//曲线数据
		$data['legend']['data'] = ['总分', '卫生', '纪律'];
		$data['tooltip'] = ['trigger' => 'axis', 'axisPointer' => ['type' => 'shadow']];
		$data['xAxis'] = ['type' => 'category', 'data' => $allDay];
		$data['yAxis'] = ['type' => 'value'];
		$data['series'] = [
			['name' => '总分', 'data' => $item_fen, 'type' => 'line', 'smooth' => true],
			['name' => '卫生', 'data' => $item_ws, 'type' => 'line', 'smooth' => true],
			['name' => '纪律', 'data' => $item_jl, 'type' => 'line', 'smooth' => true],
		];
		$echarts['option'] = $data;
		$this->success('ok', '', '', $data);
	}
	//班级统计1:当前周期内本班每日所有宿舍纪律扣分、宿舍卫生扣分、纪律+卫生总分，三条曲线图。支持查看本学期内历次周期内的曲线图

	public function banji1($id, $banjiId) {

		$r = \app\common\model\Xueqi::find($id);
		$stime = $r->stime;
		$etime = $r->etime;
		$dayArr = Date_segmentation($stime, $etime);

		$allDay = $dayArr['days_list'];
		//量化类别
		$ws = 1;
		$jl = 2;
		//取出周期内宿舍评分
		$map[] = ['banji_id', '=', $banjiId];
		$map[] = ['update_time', 'between', [strtotime($stime), strtotime($etime)]];
		$map[] = ['program_id', 'in', [$ws, $jl]];

		$dormScore = \app\common\model\Score::where($map)->select();

		foreach ($allDay as $key => $value) {
			$today_ws = [];
			$today_jl = [];
			$today_fen = [];
			//取出当天卫生评分
			foreach ($dormScore as $v) {
				if (dateFmat($v->update_time, "Y-m-d") == $value && $v->program_id == $ws) {
					$today_ws[] = $v->fen;
				}
			}
			$item_ws[] = array_sum($today_ws);
			//取出当天纪律评分
			foreach ($dormScore as $v) {
				if (dateFmat($v->update_time, "Y-m-d") == $value && $v->program_id == $jl) {
					$today_jl[] = $v->fen;
				}
			}
			$item_jl[] = array_sum($today_jl);
			//当天的总分
			foreach ($dormScore as $v) {
				if (dateFmat($v->update_time, "Y-m-d") == $value) {
					$today_fen[] = $v->fen;
				}
			}
			$item_fen[] = array_sum($today_fen);
		}
		//曲线数据
		$data['legend']['data'] = ['总分', '卫生', '纪律'];
		$data['tooltip'] = ['trigger' => 'axis', 'axisPointer' => ['type' => 'shadow']];
		$data['xAxis'] = ['type' => 'category', 'data' => $allDay];
		$data['yAxis'] = ['type' => 'value'];
		$data['series'] = [
			['name' => '总分', 'data' => $item_fen, 'type' => 'line', 'smooth' => true],
			['name' => '卫生', 'data' => $item_ws, 'type' => 'line', 'smooth' => true],
			['name' => '纪律', 'data' => $item_jl, 'type' => 'line', 'smooth' => true],
		];
		$echarts['option'] = $data;
		$this->success('ok', '', '', $data);
	}
	//本班宿舍总分/级组宿舍总分
	public function banji2($id, $banjiId) {
		$banji = \app\common\model\Banji::find($banjiId);

		$bgroup = \app\common\model\Bgroup::find($banji->bgroup->id);

		$bgroup_dorm_ids = getBgroupDorm($bgroup->id); //级组所有宿舍
		$banji_dorm_ids = getBanjiDorm($banjiId); //班级所有宿舍

		$r = \app\common\model\Xueqi::find($id);
		$stime = $r->stime;
		$etime = $r->etime;
		$dayArr = Date_segmentation($stime, $etime);

		$allDay = $dayArr['days_list'];
		//取出周期内级组宿舍评分

		$map[] = ['dorm_id', 'in', $bgroup_dorm_ids];
		$map[] = ['update_time', 'between', [strtotime($stime), strtotime($etime)]];

		$dormScore = \app\common\model\Score::where($map)->select();
		$today_banji = [];
		$today_bgroup = [];
		foreach ($allDay as $key => $value) {
			$today_banji = [];
			$today_bgroup = [];

			//取出当天本班宿舍总分
			foreach ($dormScore as $v) {
				if (dateFmat($v->update_time, "Y-m-d") == $value && in_array($v->dorm_id, $banji_dorm_ids)) {
					$today_banji[] = $v->fen;
				}
			}
			$item_banji[] = array_sum($today_banji);
			//取出当天本级组宿舍总分
			foreach ($dormScore as $v) {
				if (dateFmat($v->update_time, "Y-m-d") == $value) {
					$today_bgroup[] = $v->fen;
				}
			}
			$item_bgroup[] = array_sum($today_bgroup);

		}
		//曲线数据
		$data['legend']['data'] = ['级组总分', '班级总分'];
		$data['tooltip'] = ['trigger' => 'axis', 'axisPointer' => ['type' => 'shadow']];
		$data['xAxis'] = ['type' => 'category', 'data' => $allDay];
		$data['yAxis'] = ['type' => 'value'];
		$data['series'] = [
			['name' => '级组总分', 'data' => $item_bgroup, 'type' => 'line', 'smooth' => true],
			['name' => '班级总分', 'data' => $item_banji, 'type' => 'line', 'smooth' => true],
		];
		$echarts['option'] = $data;
		$this->success('ok', '', '', $data);
	}

	public function bgroup1($id, $bgroupId) {
		$r = \app\common\model\Xueqi::find($id);
		$stime = $r->stime;
		$etime = $r->etime;
		$dayArr = Date_segmentation($stime, $etime);

		$allDay = $dayArr['days_list'];
		//量化类别
		$ws = 1;
		$jl = 2;
		//取出周期内宿舍评分
		$bgroup = \app\common\model\Bgroup::find($bgroupId);
		$map[] = ['banji_id', 'in', $bgroup->banji->column('id')];
		$map[] = ['update_time', 'between', [strtotime($stime), strtotime($etime)]];
		$map[] = ['program_id', 'in', [$ws, $jl]];

		$dormScore = \app\common\model\Score::where($map)->select();

		foreach ($allDay as $key => $value) {
			$today_ws = [];
			$today_jl = [];
			$today_fen = [];
			//取出当天卫生评分
			foreach ($dormScore as $v) {
				if (dateFmat($v->update_time, "Y-m-d") == $value && $v->program_id == $ws) {
					$today_ws[] = $v->fen;
				}
			}
			$item_ws[] = array_sum($today_ws);
			//取出当天纪律评分
			foreach ($dormScore as $v) {
				if (dateFmat($v->update_time, "Y-m-d") == $value && $v->program_id == $jl) {
					$today_jl[] = $v->fen;
				}
			}
			$item_jl[] = array_sum($today_jl);
			//当天的总分
			foreach ($dormScore as $v) {
				if (dateFmat($v->update_time, "Y-m-d") == $value) {
					$today_fen[] = $v->fen;
				}
			}
			$item_fen[] = array_sum($today_fen);
		}
		//曲线数据
		$data['legend']['data'] = ['总分', '卫生', '纪律'];
		$data['tooltip'] = ['trigger' => 'axis', 'axisPointer' => ['type' => 'shadow']];
		$data['xAxis'] = ['type' => 'category', 'data' => $allDay];
		$data['yAxis'] = ['type' => 'value'];
		$data['series'] = [
			['name' => '总分', 'data' => $item_fen, 'type' => 'line', 'smooth' => true],
			['name' => '卫生', 'data' => $item_ws, 'type' => 'line', 'smooth' => true],
			['name' => '纪律', 'data' => $item_jl, 'type' => 'line', 'smooth' => true],
		];
		$echarts['option'] = $data;
		$this->success('ok', '', '', $data);
	}

	public function bgroup2($id, $bgroupId) {
		$bgroup = \app\common\model\Bgroup::find($bgroupId);

		$grade = \app\common\model\Grade::find($bgroup->grade->id);

		$bgroup_dorm_ids = getBgroupDorm($bgroupId); //级组所有宿舍
		$grade_dorm_ids = getGradeDorm($bgroup->grade->id); //年级所有宿舍

		$r = \app\common\model\Xueqi::find($id);
		$stime = $r->stime;
		$etime = $r->etime;
		$dayArr = Date_segmentation($stime, $etime);

		$allDay = $dayArr['days_list'];
		//取出周期内级组宿舍评分

		$map[] = ['dorm_id', 'in', $grade_dorm_ids];
		$map[] = ['update_time', 'between', [strtotime($stime), strtotime($etime)]];
		$map[] = ['status', '=', 1];
		$dormScore = \app\common\model\Score::OnlySch()->where($map)->select();

		$today_banji = [];
		$today_bgroup = [];
		foreach ($allDay as $key => $value) {
			$today_bgroup = [];
			$today_grade = [];

			//取出当天本级组宿舍总分
			foreach ($dormScore as $v) {
				if (dateFmat($v->update_time, "Y-m-d") == $value && in_array($v->dorm_id, $bgroup_dorm_ids)) {
					$today_bgroup[] = $v->fen;
				}
			}
			$item_bgroup[] = array_sum($today_bgroup);
			//取出当天本年级宿舍总分
			foreach ($dormScore as $v) {
				if (dateFmat($v->update_time, "Y-m-d") == $value) {
					$today_grade[] = $v->fen;
				}
			}
			$item_grade[] = array_sum($today_grade);

		}
		//曲线数据
		$data['legend']['data'] = ['年级宿舍总分', '级组宿舍总分'];
		$data['tooltip'] = ['trigger' => 'axis', 'axisPointer' => ['type' => 'shadow']];
		$data['xAxis'] = ['type' => 'category', 'data' => $allDay];
		$data['yAxis'] = ['type' => 'value'];
		$data['series'] = [
			['name' => '年级宿舍总分', 'data' => $item_grade, 'type' => 'line', 'smooth' => true],
			['name' => '级组宿舍总分', 'data' => $item_bgroup, 'type' => 'line', 'smooth' => true],
		];
		$echarts['option'] = $data;
		$this->success('ok', '', '', $data);
	}

	//年级宿舍评分
	public function grade1($id, $gradeId) {
		$r = \app\common\model\Xueqi::find($id);
		$stime = $r->stime;
		$etime = $r->etime;
		$dayArr = Date_segmentation($stime, $etime, 7);

		$allDay = $dayArr['days_list'];
		//量化类别
		$ws = 1;
		$jl = 2;
		//取出周期内宿舍评分
		$grade = \app\common\model\Grade::find($gradeId);
		$map[] = ['banji_id', 'in', $grade->banji->column('id')];
		$map[] = ['update_time', 'between', [strtotime($stime), strtotime($etime)]];
		$map[] = ['program_id', 'in', [$ws, $jl]];
		$map[] = ['status', '=', 1];
		$dormScore = \app\common\model\Score::OnlySch()->where($map)->select();

		foreach ($allDay as $key => $value) {
			$today_ws = [];
			$today_jl = [];
			$today_fen = [];
			//取出当天卫生评分
			foreach ($dormScore as $v) {
				if (dateFmat($v->update_time, "Y-m-d") == $value && $v->program_id == $ws) {
					$today_ws[] = $v->fen;
				}
			}
			$item_ws[] = array_sum($today_ws);
			//取出当天纪律评分
			foreach ($dormScore as $v) {
				if (dateFmat($v->update_time, "Y-m-d") == $value && $v->program_id == $jl) {
					$today_jl[] = $v->fen;
				}
			}
			$item_jl[] = array_sum($today_jl);
			//当天的总分
			foreach ($dormScore as $v) {
				if (dateFmat($v->update_time, "Y-m-d") == $value) {
					$today_fen[] = $v->fen;
				}
			}
			$item_fen[] = array_sum($today_fen);
		}
		//曲线数据
		$data['legend']['data'] = ['总分', '卫生', '纪律'];
		$data['tooltip'] = ['trigger' => 'axis', 'axisPointer' => ['type' => 'shadow']];
		$data['xAxis'] = ['type' => 'category', 'data' => $allDay];
		$data['yAxis'] = ['type' => 'value'];
		$data['series'] = [
			['name' => '总分', 'data' => $item_fen, 'type' => 'line', 'smooth' => true],
			['name' => '卫生', 'data' => $item_ws, 'type' => 'line', 'smooth' => true],
			['name' => '纪律', 'data' => $item_jl, 'type' => 'line', 'smooth' => true],
		];
		$echarts['option'] = $data;
		$this->success('ok', '', '', $data);
	}
	public function student1($id, $studentid, $programId) {

		$r = \app\common\model\Xueqi::find($id);
		$stime = $r->stime;
		$etime = $r->etime;
		$dayArr = Date_segmentation($stime, $etime);

		$allDay = $dayArr['days_list'];

		//评分项目
		$program = \app\common\model\Program::find($programId);
		if (!$program) {
			halt('error programId');
		}

		//计算每天的数据

		$student = \app\common\model\Student::find($studentid);
		$banji_id = $student->banji_id;
		$map[] = ['banji_id', '=', $banji_id];
		$map[] = ['program_id', '=', $programId];
		$Score = \app\common\model\Xfen::where($map)->select();
		foreach ($allDay as $key => $value) {
			$today_student = [];
			$today_banji = [];
			//取出学生当天项目分
			foreach ($Score as $v) {
				if (dateFmat($v->update_time, "Y-m-d") == $value && $v->student_id == $studentid) {
					$today_student[] = $v->fen;
				}
			}
			$item_student_fen[] = array_sum($today_student);
			//取出班级当天项目总分
			foreach ($Score as $v) {
				if (dateFmat($v->update_time, "Y-m-d") == $value) {
					$today_banji[] = $v->fen;
				}
			}
			$item_banji_fen[] = array_sum($today_banji);
		}

		//曲线数据
		$title = $student->banji->title . '班' . $student->title . $program->title . $r->title . '曲线对照图';
		$data['title'] = ['show' => true, 'text' => $title];
		$data['legend']['data'] = [$program->title, '班级平均分'];
		$data['tooltip'] = ['trigger' => 'axis', 'axisPointer' => ['type' => 'shadow']];
		$data['xAxis'] = ['type' => 'category', 'data' => $allDay];
		$data['yAxis'] = ['type' => 'value'];
		$data['series'] = [
			['name' => $program->title, 'data' => $item_student_fen, 'type' => 'line', 'smooth' => true],
			['name' => '班级平均分', 'data' => $item_banji_fen, 'type' => 'line', 'smooth' => true],
		];
		$leida = $this->student_leida($id, $studentid);
		$echart['line'] = $data;
		$echart['leida'] = $leida;
		$this->success('ok', '', '', $echart);
	}

	public function student_leida($id, $studentid) {
		$student = \app\common\model\Student::find($studentid);
		$program = \app\common\model\Program::where('find_in_set(:id,fenlei)', ['id' => 3397])->select();

		foreach ($program as $key => $value) {
			$legend[] = $value->title;
			//各项目总分
			$radar['name'] = $value->title;
			$radar['max'] = 100;
			$indicator[] = $radar;
			//各项目班级分
			$banji_fen[] = \app\common\model\Xfen::where(['banji_id' => $student->banji->id, 'program_id' => $value->id])->sum('fen');
			//各项目学生分
			$student_fen[] = \app\common\model\Xfen::where(['student_id' => $student->id, 'program_id' => $value->id])->sum('fen');
		}

		$leida_data[] = ['value' => $banji_fen, 'name' => $student->grade->name . $student->banji->title . '班'];
		$leida_data[] = ['value' => $student_fen, 'name' => $student->title];

		$data['title']['text'] = $student->title . '多元发展数据与班级同学均分对比';
		$data['legend']['data'] = [$student->grade->name . $student->banji->title . '班', $student->title];

		$data['radar']['indicator'] = $indicator;
		$data['series']['name'] = '学生数据';
		$data['series']['type'] = 'radar';
		$data['series']['data'] = $leida_data;
		return $data;

	}
	//班级项目分数统计
	//周期，班级ID，项目ID
	public function banjiScore($banjiID, $programId) {

	}
	//周期分成每天
	public function zhouqi($id) {
		$r = \app\common\model\Xueqi::find($id);
		$stime = $r->stime;
		$etime = $r->etime;
		$dayArr = Date_segmentation($stime, $etime);
		$r->allDay = $dayArr['days_list'];
		return $r;
	}
	//各年级级组宿舍概况
	public function tdorm($id) {
		$grade = new \app\common\model\Grade();
		$zhouqi = \app\common\model\Xueqi::find($id);
		$stime = $zhouqi->stime;
		$etime = $zhouqi->etime;
		$dayArr = Date_segmentation($stime, $etime);
		$allDay = $dayArr['days_list'];

		$gradeData = $grade->select();
		$barData = [];
		foreach ($gradeData as $key => $value) {
			$series = [];
			$option['title']['text'] = "第" . $zhouqi->title . $value->name . "各级组宿舍概况";
			$option['tooltip'] = ['trigger' => 'axis', 'axisPointer' => ['type' => 'shadow']];
			$option['legend']['data'] = $value->bgroup->column('title');
			$option['xAxis']['data'] = $allDay;
			$option['yAxis']['type'] = 'value';

			foreach ($value->bgroup as $k => $v) {

				$jizu['name'] = $v->title;
				$jizu['type'] = 'bar';
				$jizu['data'] = $this->tjdorm($allDay, $v->banji->column('id'));
				$series[] = $jizu;
			}

			$option['series'] = $series;

			//汇总
			$barData[$value->id] = $option;
		}
		//halt($barData);
		return $barData;

	}
	//天数，学生
	protected function tjdorm($allDay, $ids) {
		$today_fen = [];

		$map[] = ['banji_id', 'in', $ids];
		$map[] = ['program_id', 'in', '1,2'];

		$ScoreMod = new \app\common\model\Score();

		$Score = $ScoreMod->OnlySch()->where($map)->select();

		foreach ($allDay as $key => $value) {
			$fen = [];
			//取出学生当天项目分
			foreach ($Score as $v) {
				if (dateFmat($v->update_time, "Y-m-d") == $value) {
					$fen[] = $v->fen;
				}
			}
			$today_fen[] = array_sum($fen);
		}
		return $today_fen;
	}
//全部级组统计

	public function allBgroup($id) {
		$zhouqi = $this->zhouqi($id);
		$grade = \app\common\model\Grade::select();

		$bgroup = \app\common\model\Bgroup::select();

		foreach ($grade as $k => $g) {
			$bgroup = $g->bgroup;
			//曲线数据
			$title = "第" . $zhouqi->title . $g->name . "各级组自主自律概况";
			$data['title'] = ['show' => true, 'text' => $title, 'x' => 'center', 'y' => 'top'];
			$data['legend']['data'] = $bgroup->column('title');
			$data['legend']['top'] = "6%";
			$data['tooltip'] = ['trigger' => 'axis', 'axisPointer' => ['type' => 'shadow']];
			$data['xAxis'] = ['type' => 'category', 'data' => $zhouqi->allDay];
			$data['yAxis'] = ['type' => 'value'];
			$bgroupData = [];
			$series = [];
			foreach ($bgroup as $key => $value) {
				$bgroupData['name'] = $value->title;
				$bgroupData['type'] = 'line';
				$bgroupData['smooth'] = true;
				$bgroupData['data'] = $this->tjbgroup($zhouqi->allDay, $value);
				$series[] = $bgroupData;
			}

			$data['series'] = $series;
			$gradeGrid[$g->id] = $data;
		}

		return $gradeGrid;

	}
	protected function tjbgroup($allDay, $bgroup) {
		$today_fen = [];

		//获取学生

		$banjiId = $bgroup->banji->column('id');
		$map[] = ['banji_id', 'in', $banjiId];
		$map[] = ['program_id', '=', 4];
		$map[] = ['status', '=', 1];
		$Score = \app\common\model\Score::OnlySch()->where($map)->select();

		foreach ($allDay as $key => $value) {
			//取出级组学生当天项目分\
			$fen = [];
			foreach ($Score as $v) {
				if (dateFmat($v->update_time, "Y-m-d") == $value) {
					$fen[] = $v->fen;
				}
			}
			$today_fen[] = array_sum($fen);
		}
		return $today_fen;
	}
	//获取级组多元雷达
	public function bgroupRadar($id) {

		$zhouqi = $this->zhouqi($id);
		$bgroup = \app\common\model\Bgroup::select();

		$program = \app\common\model\Program::where('find_in_set(:id,fenlei)', ['id' => 3410])->select();
		$optionData = [];
		foreach ($bgroup as $key => $value) {
			$radar['title']['text'] = $value->title;
			$radar['legend']['data'] = [$value->title, $value->grade->name];
			$radar['tooltip']['trigger'] = 'axis';
			$radar['radar']['indicator'] = [];
			$radarData = [];
			foreach ($program as $k => $v) {
				$indicator['name'] = $v->title;
				//$indicator['max'] = \app\common\model\Score::where('program_id', $v->id)->sum('fen');
				$indicator['max'] = 10 * 4 * 5;
				$radar['radar']['indicator'][] = $indicator;
			}
			$radar['series']['name'] = '雷达图';
			$radar['series']['type'] = 'radar';
			$radar['series']['tooltip'] = ['trigger' => 'item'];
			//级组分
			$radarData[0]['value'] = $this->getDayradar($zhouqi, $value, $program);
			$radarData[0]['name'] = $value->title;
			//年级分
			$radarData[1]['value'] = $this->getDayradar($zhouqi, $value->grade, $program);
			$radarData[1]['name'] = $value->grade->name;

			$radar['series']['data'] = $radarData;
			$optionData[$value->id] = $radar;
		}
		//halt($optionData);
		return $optionData;
	}
	//$bgroup即是级组，又是年级，同样可以取得班级
	public function getDayradar($zhouqi, $bgroup, $program) {
		$today_fen = [];
		//获取级组

		$map[] = ['banji_id', 'in', $bgroup->banji->column('id')];
		$map[] = ['update_time', 'between', [strtotime($zhouqi->stime), strtotime($zhouqi->etime)]];

		$Score = \app\common\model\Score::where($map)->fetchSql(false)->select();

		//halt($Score);

		foreach ($program as $key => $value) {
			//取出周期内项目总分
			$fen = [];
			foreach ($Score as $v) {
				if ($v->program_id == $value->id) {
					$fen[] = $v->fen;
				}
			}
			$today_fen[] = array_sum($fen);
			//$today_fen[] = rand(10, 200);
		}
		return $today_fen;
	}
	//级组班级量化项目总分对比

	public function bgroupProgram($id, $bgroupId, $programId) {
		$r = \app\common\model\Xueqi::find($id);
		$stime = $r->stime;
		$etime = $r->etime;
		$dayArr = Date_segmentation($stime, $etime);

		$allDay = $dayArr['days_list'];

		//评分项目
		$program = \app\common\model\Program::find($programId);
		if (!$program) {
			halt('error programId');
		}

		$bgroup = \app\common\model\Bgroup::find($bgroupId);

		//循环班级
		foreach ($bgroup->banji as $key => $value) {
			$series['name'] = $value->title;
			$series['data'] = $this->bgroupProgramData($allDay, $value, $program);
			$series['type'] = 'line';
			$series['smooth'] = true;
			$data['series'][] = $series;
		}

		//曲线数据
		$title = $bgroup->title . $program->title . '曲线对照图';
		$data['title'] = ['show' => true, 'text' => $title];
		$data['legend']['data'] = $bgroup->banji->column('title');
		$data['tooltip'] = ['trigger' => 'axis', 'axisPointer' => ['type' => 'shadow']];
		$data['xAxis'] = ['type' => 'category', 'data' => $allDay];
		$data['yAxis'] = ['type' => 'value'];
		//halt($data);
		$this->success('ok', '', '', $data);
	}

	public function bgroupProgramData($allDay, $banji, $program) {
		$today_fen = [];

		//获取学生

		$map[] = ['banji_id', '=', $banji->id];
		$map[] = ['program_id', '=', $program->id];
		$map[] = ['status', '=', 1];
		$Score = \app\common\model\Score::OnlySch()->where($map)->select();

		foreach ($allDay as $key => $value) {
			//取出级组学生当天项目分\
			$fen = [];
			foreach ($Score as $v) {
				if (dateFmat($v->update_time, "Y-m-d") == $value) {
					$fen[] = $v->fen;
				}
			}
			$today_fen[] = array_sum($fen);
		}
		return $today_fen;
	}

//本年级各级组量化项目总分对比
	public function gradeProgram($id, $gradeId, $programId) {
		$r = \app\common\model\Xueqi::find($id);
		$stime = $r->stime;
		$etime = $r->etime;
		$dayArr = Date_segmentation($stime, $etime);

		$allDay = $dayArr['days_list'];

		//评分项目
		$program = \app\common\model\Program::find($programId);
		if (!$program) {
			halt('error programId');
		}

		$grade = \app\common\model\Grade::find($gradeId);

		//循环级组
		foreach ($grade->bgroup as $key => $value) {
			$series['name'] = $value->title;
			$series['data'] = $this->gradeProgramData($allDay, $value, $program);
			$series['type'] = 'line';
			$series['smooth'] = true;
			$data['series'][] = $series;
		}

		//曲线数据
		$title = $grade->name . $program->title . '曲线对照图';
		$data['title'] = ['show' => true, 'text' => $title];
		$data['legend']['data'] = $grade->bgroup->column('title');
		$data['tooltip'] = ['trigger' => 'axis', 'axisPointer' => ['type' => 'shadow']];
		$data['xAxis'] = ['type' => 'category', 'data' => $allDay];
		$data['yAxis'] = ['type' => 'value'];
		//halt($data);
		$this->success('ok', '', '', $data);
	}

	public function gradeProgramData($allDay, $bgroup, $program) {
		$today_fen = [];

		//获取学生

		$map[] = ['banji_id', 'in', $bgroup->banji->column('id')];
		$map[] = ['program_id', '=', $program->id];
		$map[] = ['status', '=', 1];
		$Score = \app\common\model\Score::OnlySch()->where($map)->select();

		foreach ($allDay as $key => $value) {
			//取出级组学生当天项目分\
			$fen = [];
			foreach ($Score as $v) {
				if (dateFmat($v->update_time, "Y-m-d") == $value) {
					$fen[] = $v->fen;
				}
			}
			$today_fen[] = array_sum($fen);
		}
		return $today_fen;
	}
//班级各量化项目总分
	public function banjiProgram($id, $banjiId) {
		$r = \app\common\model\Xueqi::find($id);
		$stime = $r->stime;
		$etime = $r->etime;
		$dayArr = Date_segmentation($stime, $etime);

		$allDay = $dayArr['days_list'];

		//评分项目
		$program = \app\common\model\Program::where("find_in_set('3410', fenlei)")->select();
		$banji = \app\common\model\Banji::find($banjiId);

		//循环级组
		foreach ($program as $key => $value) {
			$series['name'] = $value->title;
			$series['data'] = $this->banjiProgramData($allDay, $banji, $value);
			$series['type'] = 'line';
			$series['smooth'] = true;
			$data['series'][] = $series;
		}

		//曲线数据
		$title = $banji->title . '各量化项目曲线对照图';
		$data['title'] = ['show' => true, 'text' => $title];
		$data['legend']['data'] = $program->column('title');
		$data['tooltip'] = ['trigger' => 'axis', 'axisPointer' => ['type' => 'shadow']];
		$data['xAxis'] = ['type' => 'category', 'data' => $allDay];
		$data['yAxis'] = ['type' => 'value'];
		//halt($data);
		$this->success('ok', '', '', $data);
	}
	public function banjiProgramData($allDay, $banji, $program) {
		$today_fen = [];

		//获取学生

		$map[] = ['banji_id', '=', $banji->id];
		$map[] = ['program_id', '=', $program->id];
		$map[] = ['status', '=', 1];
		$Score = \app\common\model\Score::OnlySch()->where($map)->select();

		foreach ($allDay as $key => $value) {
			//取出本班本项目当天总分
			$fen = [];
			foreach ($Score as $v) {
				if (dateFmat($v->update_time, "Y-m-d") == $value) {
					$fen[] = $v->fen;
				}
			}
			$today_fen[] = array_sum($fen);
		}
		return $today_fen;
	}

}
