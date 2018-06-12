<?php
namespace Admin\Controller;
use Think\Controller;
header("Content-type: text/html; charset=utf-8");
/**
 * 班级信息
 */
class ClassController extends Controller {
	//初始化类，用于监测用户是否登录
	public function _initialize(){
		if(!$_SESSION['username']){
			$this -> redirect("Login/login");
		}
	}
	public function test(){
		$lng1 = 106.54518775002;
		$lat1 = 29.643151628487;
		$lng2 = 106.54518774052;
		$lat2 = 29.64314207773;
		//发送字符串组装
		//$post_data = 'lats='.$lat.'&lngs='.$lng.'&type=5';
		http://api.zdoz.net/getdistance.aspx?lat1=30.58682940864&lng1=103.99733279143&lat2=30.586832515536&lng2=103.99733279315
		$url = "http://api.zdoz.net/getdistance.aspx?lat1=".$lat1."&lng1=".$lng1."&lat2=".$lat2."&lng2=".$lng2;
		$curl = new \Admin\Controller\PublicController();
		$json_data = $curl -> curl($url);
		//转换新数组结果展示
		//$data = json_decode($json_data,true);//已转换为百度地图数据
		var_dump($json_data);
	}
	/**************************班级管理**********************/
	/**
	 *  班级信息(首页展示)
	 */
	public function class_info(){
		//$info = S('class_info');
		//if(!$info){
		$info = M('Class_info')->alias('class')
		->join('join Grade_info grade on grade.id = class.grade_id')
		->where(array('class.id'=>session('auth_id')))
		->field('class.name,class.teacher,class.teacher_phone,grade.name as grade_name')
		->find();
			//班级信息添加缓存
			//S('class_info',$info,3600);
		//}
		$this -> assign('info',$info);
		$this -> display();
	}
	/**
	 *  班级负责人信息
	 */
	public function class_teacher_info(){
		$info = M('Staff_info')
			->where(array('auth'=>'class','auth_id'=>session('auth_id')))
			->field('name,object_name,phone_number')
			->select();
		$this -> assign('info',$info);
		$this -> display();
	}
	/**************************学生管理**********************/
	/**
	 * 学生基本信息
	 */
	public function student_info(){
		$student_info = D("Class") -> student_info();
		//将查询到的学生信息传入Excel方法
		$this -> assign('info',$student_info);
		$this -> display();
	}
	/**
	 * 添加学生信息
	 */
	public function student_info_add(){
		$arr = I('post.arr');	//获取前台数组
		$data['name'] = $arr['0'];	//学生姓名
		$data['sex'] = $arr['1'];	//学生性别
		$data['device_id'] = $arr['2'];	//学生证编号
		$data['parent_name'] = $arr['3'];	//联系人姓名
		$data['parent_phone'] = $arr['4'];	//联系人电话
		$data['class_id'] = session('auth_id');	//班级id
		$grade_id = M('Class_info')
		-> where(array('id'=>session('auth_id')))
		-> getField('grade_id');
		$data['grade_id'] = $grade_id;	//年级id
		$data['school_id'] = "";	//学校id
		$res = M('Student_info')->add($data);	//添加学生信息
		if($res){
			echo 'add_success';
		}else{
			echo 'add_failed';
		}
	}
	/**
	 * 学生信息导出 
	 */
	public function student_data_export(){
		$student_info = D("Class") -> student_info();
		$dir = "./Public/excel/class/";
		$bt = array(					//Excel表头设置
				'0'=>'学生姓名',
				'1'=>'学生性别',
				'2'=>'学生证编号',
				'3'=>'联系人姓名',
				'4'=>'联系人电话',
		);
		$public = new PublicController();
		$public -> Excel($dir,$student_info,$bt);
		echo "export_success";
	}
	/**
	 *  班级学生运动轨迹
	 */
	public function student_orbit(){
		//默认显示当日时间，有时间则显示该日
		$now = I('get.date');
		$_GET['time'] = default_time($now);//用于前台显示
		$date = strtotime($now);	//获取前台提交时间
		$device_id = I('get.device_id');	//设备id
		$result = D('Class') -> position($date,$device_id);
		$orbit = $result['orbit'];
		$arr = $result['arr'];
		$jd_center = $result['jd_center'];
		$wd_center = $result['wd_center'];
		//首次展示无经纬度坐标,设置初始默认坐标
		if(!$jd_center && !$wd_center){
			$jd_center = '104.06';
			$wd_center = '30.67';
		}
		$this -> assign('jd_center',$jd_center);	//经度中心坐标
		$this -> assign('wd_center',$wd_center);//纬度中心坐标
		$this -> assign('orbit',$orbit);	//轨迹
		$this -> assign('arr',$arr);	//轨迹+文字标记
		$this -> display();
	}
	/**
	 * 学生考勤管理 
	 */
	public function student_attend(){
		//默认显示当日时间，有时间则显示该日
		$date = I('get.date');//获取前台提交时间
		$_GET['time'] = default_time($date);//用于前台显示
		$device_id = I('get.device_id');	//设备id
		$page = I('get.page');	//获取当前是第几页
		if(!$page){	//首次访问此页为1
			$page = 1;
		}
		$test = 'no';
		//查询考勤信息
		$type = 'BT';
		//进行查询
		$res = D('Class')-> realtime($page,$date,$device_id,$type);	//页数，日期，编号，类型
		if($res['select_info']){
			$test = 'yes';
		}
		$this -> assign("test",$test);//返回测试结果
		$this -> assign("date",$date);//返回时间
		$this -> assign("device_id",$device_id);//返回日期
		$this -> assign('total_pages',$res['total_pages']);//显示总页数
		$this -> assign('page',$res['page']);	//显示第几页
		$this -> assign('info',$res['select_info']);	//显示当前页的数据
		$this -> display();
	}
	/**
	 * 学生报警管理
	 */
	public function student_sos(){
		//默认显示当日时间，有时间则显示该日
		$date = I('get.date');//获取前台提交时间
		$_GET['time'] = default_time($date);//用于前台显示
		$device_id = I('get.device_id');	//设备id
		$page = I('get.page');	//获取当前是第几页
		if(!$page){	//首次访问此页为1
			$page = 1;
		}
		$test = 'no';
		//查询报警数据
		$type = 'SOS';
		$res = D('Class')-> realtime($page,$date,$device_id,$type);//页数，日期，编号，类型
		if($res['select_info']){
			$test = 'yes';
		}
		$this -> assign("test",$test);//返回测试结果
		$this -> assign("date",$date);//返回时间
		$this -> assign("device_id",$device_id);//返回日期
		$this -> assign('total_pages',$res['total_pages']);//显示总页数
		$this -> assign('page',$res['page']);	//显示第几页
		$this -> assign('info',$res['select_info']);	//显示当前页的数据
		$this -> display();
	}
	/**
	 * 学生报警地图展示 
	 */
	public function student_sos_map(){
		$jd = I("get.longitude");
		$wd = I('get.latitude');
		$date_time = I('get.date').' '.I('get.time');
		$this -> assign('jd',$jd);
		$this -> assign('wd',$wd);
		$this -> assign('date_time',$date_time);
		$this -> display();
	}
	/*****************************学生作业管理**********************/
	/**
	 * 作业发布
	 */
	public function homework(){
		$this -> display();
	}
	/**
	 * 作业入库  ajax提交
	 */
	public function homework_sub(){
		$file = $_FILES['homework'];	//获取图片信息
		$data['grade_id'] = M('Class_info')
		-> where(array('id'=>session('auth_id')))
		-> getField('grade_id');
		$data['subject'] = I("post.subject");
		$data['teacher'] = I("post.teacher");
		$data['class_id'] = session('auth_id');
		$data['create_time'] = time();
		$data['describe'] = I("post.describe");
		$table_name = 'homework';
		$public = new PublicController();
		$res = $public -> file_upload($data,$file,$table_name);
		$this -> ajaxReturn($res,'json');die;
	}
	/**
	 * 作业查看
	 */
	public function homework_select(){
		$grade_id = M('Class_info')
		-> where(array('id'=>session('auth_id')))
		-> getField('grade_id');
		$res['grade_id'] = array('eq',$grade_id);
		$res['class_id'] = array('eq',session('auth_id'));
		$info = M("Homework")
		-> where($res)
		-> field('id,teacher,subject,create_time')
		-> select();
		$this -> assign("info",$info);
		$this -> display();
	}
	/**
	 *  作业详情单独查看 ajax
	 */
	public function homework_detail_select(){
		$id = I("post.id");
		$describe = M("Homework")
		-> where(array('id'=>$id))
		-> field('describe,image')
		-> find();
		$this -> ajaxReturn($describe,'json');
	}
	/***************************班级设备管理**********************/
	/*
	 * 已绑定信息 
	 */
	public function stu_bind_status(){
		$grade_id = M('Class_info')
		-> where(array('id'=>session('auth_id')))
		-> getField('grade_id');
		//查询当前班级已绑定设备的学生信息
		$res['stu.class_id'] = array('eq',session('auth_id'));
		$res['stu.grade_id'] = array('eq',$grade_id);
		$res['stu.device_id'] = array('neq','');	
		$info = M('Student_info')->alias('stu')
		->join('left join device_handlering de on de.deviceID = stu.device_id')
		->where($res)
		->field('stu.name,stu.device_id,de.collectRate,de.uploadRate')
		->select();
		$this -> assign('info',$info);
		$this -> display();
	}
	//学生绑定信息详情，ajax返回
	public function stu_bind_detail(){
		$device_id = I('post.device_id');
		$info = M('Device_handlering')
		-> where(array('deviceID'=>$device_id))
		-> field('IMEI,IMSI,collectRate,uploadRate,powerOnDateTime,powerOffDateTime,sos')
		-> find();
		$this ->ajaxReturn($info);die;
	}
	//学生同设备解除绑定 ajax
	public function stu_bind_cancel(){
		$stu_dev_id = I('post.device_id');
		//更新学生表字段,使用setField方法
		$res_stu = M('Student_info')
		-> where(array('device_id'=>$stu_dev_id))
		-> setField('device_id','');	//学生绑定设备字段设为空
		//更新设备表字段，使用setField方法
		$result = array("is_bind"=>"0","bind_class"=>"");//更改信息
		$res_dev = M('Device_handlering')
		-> where(array('deviceID'=>$stu_dev_id))
		-> setField($result);	//更新两个字段
		if($res_dev && $res_stu){
			echo "success";
		}else{
			echo "false";
		}
		die;
	}
	//未绑定信息
	public function stu_nobind_status(){
		$grade_id = M('Class_info')
		-> where(array('id'=>session('auth_id')))
		-> getField('grade_id');
		//查询当前班级未绑定设备的学生信息
		$res['class_id'] = array('eq',session('auth_id'));
		$res['grade_id'] = array('eq',$grade_id);
		$res['device_id'] = array('eq','');
		$info = M('Student_info')
		->where($res)
		->field('name,sex,parent_name,parent_phone')
		->select();
		$this -> assign('info',$info);
		$this -> display();
	}
	/*
	 * 查询五个可用设备
	 */
	public function enable_device(){
		$info = M('Device_handlering')
		-> where(array("is_bind"=>'0'))
		-> order('create_time asc')
		-> field('deviceID')
		-> limit(5)
		-> select();
		$str = '';//拼接字符串
		foreach($info as $key=>$val){
			$str .= $val['deviceID'].'        ';
		}
		$str = rtrim($str,' ');//删除右侧空格
		echo $str;
	}
	/*
	 * 学生绑定设备 
	 */
	public function stu_bind_confirm(){
		$name = I('post.stu_name');
		$device_id = I('post.device_id');
		//防止重名问题，保证唯一性
		$grade_id = M('Class_info')
		-> where(array('id'=>session('auth_id')))
		-> getField('grade_id');
		//更新学生表字段,使用setField方法
		$stu['class_id'] = array('eq',session('auth_id'));
		$stu['grade_id'] = array('eq',$grade_id);
		$stu['name'] = array('eq',$name);
		$res_stu = M('Student_info')
		-> where($stu)
		-> setField('device_id',$device_id);	//学生绑定设备
		//更新设备表字段，使用setField方法
		$result = array("is_bind"=>"1","bind_class"=>session('auth_id'));//更改信息
		$res_dev = M('Device_handlering')
		-> where(array('deviceID'=>$device_id))
		-> setField($result);	//更新两个字段
		if($res_dev && $res_stu){
			echo "success";
		}else{
			echo "false";
		}
		die;
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
	/********************************测试类*****************************/
	public function test_page(){
		echo "";
	}
	public function test_id(){
		$device_id = I('get.device_id');
		$date = I('get.date');
		$res = D('Class') -> base_id($date,$device_id);
		//var_dump($res);
		//拆分每条数据的基站信息，拆分为二维数组
		$res_next = array();$arr_lbs = array();$arr_change=array();
		foreach($res as $key=>$val){
			$res_next[$key] = explode("#",$val['LBS']);
		}
		//var_dump($res_next);
		//对得到的二维数组进行截取
		foreach($res_next as $key=>$val){
			//通过字符串截取得到新数组
			for($i=0;$i<3;$i++){
				$arr_lbs[$key][$i] = substr($val[$i],12,8);//得到需要的基站信息
			}
		}
		//var_dump($arr_lbs);
		//将截取后的二维数组转化为一维数组
		$start = 0;
		foreach($arr_lbs as $key=>$val){
			for($i=0;$i<3;$i++){
				$arr_change[$start] = $val[$i];
				$start++;
			}
		}
		//var_dump($arr_change);die;
		$arr_key = array();$arr_value = array();
		//数值分离
		foreach($arr_change as $key=>$val){
			$arr_key[$key] = explode(":",$val)[0];
			$arr_value[$key] = explode(":",$val)[1];
		}
		//得到两个数组
		var_dump($arr_key);var_dump($arr_value);die;
		$count = count($arr_key);
		for($ii=0;$ii<$count;$ii++){
			
		}
		$test = 'no';
		if($res){
			$test = 'yes';
		}
		$this -> assign('test',$test);
		$this -> display();
	}
}
