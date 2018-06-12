<?php
namespace Admin\Controller;
use Think\Controller;

/**
 * 该类为登录类，用于系统登录页面
 */
header("Content-type:text/html;charset=utf-8");

class AdminController extends Controller{
	/*********************************学校管理***************************/
    /**
     * 学校信息
     */
	public function test(){
		echo date('Y-m-d H:i:s','1491010755');
	}
    public function sch_info(){
    	$info = M('School_info') -> find();
    	$this -> assign("info",$info);
        $this -> display();
    }
    /**
     * 学校信息编辑 ajax
     */
    public function sch_info_editor(){
    	$arr = I("post.arr");
    	$sch['name'] = $arr['0'];
    	$sch['position'] = $arr['1'];
    	$sch['leader'] = $arr['2'];
    	$sch['phone_number'] = $arr['3'];
    	$sch['create_time'] = time();
    	$res = M('School_info') -> where(array('id'=>1)) -> save($sch);
    	if($res){	//修改成功
    		echo 'success';
    	}else{
    		echo 'failed';
    	}
    }
	/**
	 * 学校负责人 
	 */
    public function sch_admin_info(){
    	$info = M('Staff_info') 
    	-> where(array('auth'=>'school','status'=>1))
    	-> field('id,name,auth,create_time,status,phone_number')
    	-> select();
    	$this -> assign("info",$info);
    	$this -> display();
    }
    /**
     * 单个负责人信息 ajax
     */
    public function sch_admin_one(){
    	$id = I('post.id');
    	$info = M('Staff_info')
    	-> where(array('id'=>$id))
    	-> field('id,name,auth,status,phone_number')
    	-> find();
    	if($info['status'] == '1'){
    		$info['status'] = '在职';
    	}else{
    		$info['status'] = '离职';
    	}
    	if($info['auth'] == 'school'){
    		$info['auth'] = '校级负责人';
    	}else{
    		$info['auth'] = '其它';
    	}
    	$this -> ajaxreturn($info);
    }
    /**
     * 学校负责人信息更新(伪删除)
     */
    public function sch_admin_sub(){
    	$id = I('post.id');
    	$sch['name'] = I('post.name');
    	$sch['phone_number'] = I('post.phone_number');
    	$sch['create_time'] = time();
    	$res = M('Staff_info') 
    	-> where(array('id'=>$id))
    	-> save($sch);
    	if($res){	//更新成功
    		echo 'success';
    	}else{
    		echo 'failed';
    	}
    }
    /**
     * 学校负责人解除职务(伪删除)
     */
    public function sch_admin_cancel(){
    	$id = I("post.id");
    	$res = M('Staff_info')
    	-> where(array('id'=>$id))
    	-> setField('status',0);	//sttatus改为0
    	if($res){	//修改成功
    		echo 'success';
    	}else{
    		echo 'failed';
    	}
    }
	/****************************设备基本信息********************************/
    /**
     * 添加设备信息 
     */
    public function device_add(){
    	$this -> display();
    }
    /**
     * 添加设备提交
     */
    public function device_add_sub(){
    	$arr = I('post.arr');
    	$data['deviceID'] = $arr['0'];	//设备ID
    	$data['IMEI'] = $arr['1'];	
    	$data['IMSI'] = $arr['2'];
    	$data['collectRate'] = $arr['3'];
    	$data['uploadRate'] = $arr['4'];
    	$data['bluetooth_station'] = $arr['5'];
    	$data['powerOnDateTime'] = $arr['6'];
    	$data['powerOffDateTime'] = $arr['7'];
    	$data['powerOnDateTimeFlag'] = $arr['8'];
    	if($data['powerOnDateTimeFlag'] == '5'){
    		$data['powerOnDateTimeFlag'] = '1111100';	//工作日
    	}else{
    		$data['powerOnDateTimeFlag'] = '1111111';	//全天
    	}
    	$data['powerOffDateTimeFlag'] = $arr['9'];
    	if($data['powerOffDateTimeFlag'] == '5'){
    		$data['powerOffDateTimeFlag'] = '1111100';	//工作日
    	}else{
    		$data['powerOffDateTimeFlag'] = '1111111';	//全天
    	}
    	$data['LBS_School'] = $arr['10'];
    	$data['LBS_Home'] = $arr['11'];
    	$data['SOS'] = $arr['12'];
    	$data['Friend'] = $arr['13'];
    	$data['create_time'] = time();
    	$res = M('Device_handlering') ->add($data);
    	if($res){
    		$this -> ajaxReturn('success');
    	}else{
    		$this -> ajaxReturn('failed');
    	}
    }
    /**
     * 设备信息显示
     */
    public function device_info(){
    	$page = I('get.page');
    	if(!$page){
    		$page = 1;
    	}
    	$res = D('Admin') -> page($page);
    	//var_dump($res);
    	$page = $res['page'];	//当前页数
    	$total_pages = $res['total_pages'];//总页数
    	$info = $res['select_info'];//数据信息
    	$this -> assign('page',$page);
    	$this -> assign('total_pages',$total_pages);
    	$this -> assign('info',$info);
    	$this -> display();
    }
    /**
     * 单个设备信息 
     */
    public function device_info_only(){
    	$id = I('post.id');
    	$info = M('Device_handlering')
    	-> where(array('id'=>$id))
    	-> find();
    	$this -> ajaxReturn($info);
    }
    /**
     * 单个设备信息更新
     */
    public function device_info_update(){
    	$id = I('post.id');
       	$up['collectRate'] = I('post.collectRate');
    	$up['uploadRate'] = I('post.uploadRate');
    	$up['powerOnDateTime'] = I('post.powerOnDateTime');
    	$up['powerOffDateTime'] = I('post.powerOffDateTime');
    	$up['SOS'] = I('post.SOS');
    	$up['Friend'] = I('post.Friend');
    	$up['create_time'] = time();
    	$res = M('Device_handlering')
    	-> where(array('id'=>$id))
    	-> save($up);
    	if($res){
    		echo 'success';
    	}else{
    		echo 'failed';
    	}
    }
}
