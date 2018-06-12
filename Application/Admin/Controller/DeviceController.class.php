<?php
namespace Admin\Controller;
use Think\Controller;

/**
 * 该类为登录类，用于系统登录页面
 */
header("Content-type:text/html;charset=utf-8");

class DeviceController extends Controller{
	
	public function test(){
		echo date('Y-m-d H:i:s','1491010755');
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
