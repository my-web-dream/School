<?php
namespace Admin\Controller;
use Think\Controller;

/**
 * 班级信息
 */
class GradeController extends Controller {
	
	/**************************年级管理**********************/
	/**
	 *  年级信息(首页展示) ok
	 */
	public function grade_info(){
		$info = M('Grade_info')->alias('grade')
			->join('left join School_info sch on sch.id = grade.school_id')
			->where(array('grade.id'=>session('auth_id')))
			->field('grade.name,grade.leader,grade.phone_number,sch.name as sch_name')
			->find();
		$this -> assign('info',$info);
		$this -> display();
	}
	/**
	 *  年级信息_修改(ajax) ok
	 */
	public function grade_info_update(){
		$data['name'] = I("post.grade_name");
		$data['leader'] = I("post.grade_leader");
		$data['phone_number'] = I("post.grade_phone");
		$res = M('grade_info')
		->where(array('id'=>session('auth_id')))
		->save($data);
		if($res)
		{
			echo 'success';
		}else{
			echo 'failed';
		}
	}
	/**
	 *  年级管理员信息 ok
	 */
	public function grade_leader_info(){
		$info = M('Staff_info')
			->where(array('auth'=>'grade','auth_id'=>session('auth_id')))
			->field('name,object_name,phone_number')
			->select();
		$this -> assign('info',$info);
		$this -> display();
	}
	/**************************班级管理**********************/
	/**
	 * 班级基本信息 ok
	 */
	public function class_info(){
		$info = M('Class_info')
		-> where(array('grade_id'=>session('auth_id')))
		-> select();
		$this -> assign('info',$info);
		$this -> display();
	}
	/**
	 * 班级信息添加  ok
	 */
	public function class_info_add(){
		$data['name'] = I('post.name');
		$data['teacher'] = I('post.teacher');
		$data['teacher_phone'] = I('post.teacher_phone');
		$data['create_time'] = time();
		$data['grade_id'] = session('auth_id');
		$res = M('Class_info') -> add($data);
		if($res)
		{
			echo 'success';
		}else{
			echo 'failed';
		}
	}
	/**
	 * 班级负责人信息 
	 */
	public function class_leader_info(){
		$id = I('get.id');
		$res['auth'] = array('eq','class');
		$res['auth_id'] = array('eq',$id);
		$info = M('Staff_info')
		->where($res)
		->field('name,object_name,phone_number')
		->select();
		$this -> assign('info',$info); 
		$this -> display();
	}
	/**
	 * 班级学生信息
	 */
	public function class_student_info(){
		$id = I('get.id');
		$info = M('Student_info')
		->where(array('class_id'=>$id))
		->field('name,sex,device_id,parent_phone,parent_name')
		->select();
		$this -> assign('info',$info);
		$this -> display();
	}
	/**************************发布通知**********************/
	/**
	 * 编写通知 
	 */
	public function notice(){
		$this -> display();
	}
	/**
	 * 通知提交 
	 */
	public function notice_release(){
		$file = $_FILES['notice'];	//获取图片信息
		$data['auth'] = 'grade';
		$data['auth_id'] = session('auth_id');
		$data['title'] = I('post.title');
		$data['describe'] = I('post.describe');
		$data['create_time'] = time();
		$table_name = 'notice';
		$public = new PublicController();
		$res = $public -> file_upload($data,$file,$table_name);
		$this -> ajaxReturn($res,'json');die;
	}
	/**
	 * 查看已发布的通知 
	 */
	public function notice_select(){
		$res['auth'] = array('eq','grade');
		$res['auth_id'] = array('eq',session('auth_id'));
		$info = M('Notice')
		-> where($res)
		-> field('id,title,create_time')
		-> select();
		$this -> assign('info',$info);
		$this -> display();
	}
	/**
	 *  通知详情单独查看 ajax
	 */
	public function notice_detail_select(){
		$id = I("post.id");
		$describe = M("Notice")
		-> where(array('id'=>$id))
		-> field('describe,image')
		-> find();
		$this -> ajaxReturn($describe,'json');
	}
	/**************************个人信息管理**********************/
	/**
	 * 个人信息管理
	 */
	public function pro_info(){
		$username = session('username');
		$public = new PublicController();
		$info = $public -> pro_info($username);
		$this -> assign('info',$info);
		$this -> display();
	}
	/**
	 * 个人信息管理--更新
	 */
	public function pro_info_update(){
		$data['name'] = I('post.name');
		$data['phone_number'] = I("post.phone_number");
		//$file = $_FILES['editor_img'];	//上传头像
		$data['create_time'] = time();	
		$res = M('Staff_info')
		-> where(array('username'=>session('username')))
		-> save($data);
		if($res){
			echo 'success';
		}else{
			echo 'failed';
		}
	}

}
