<?php
namespace App\Controller;
use \Think\Controller;
/**
 * App登录对接
 */
// 指定字符格式
//header("Content-type:text/html;charset=utf-8");
// 指定允许其他域名访问
//header("Access-Control-Allow-Origin:*");
// 响应类型
//header("Access-Control-Allow-Methods:POST");
// 响应头设置
//header("Access-Control-Allow-Headers:x-requested-with,content-type");
/**
 * App登录响应
 * @xueji
 */
class AttendController extends Controller {
    /**
     * 登录界面展示
     */   
    public function attend(){
        $startdate =  I('post.startDatetime');
        $enddate =  I('post.endDatetime');
        
        $startdate = strtotime($startdate);
        $enddate = strtotime($enddate);
        $start = mktime(0,0,0,date("m",$startdate),date("d", $startdate),date("Y", $startdate));
        $end = mktime(23,59,59,date("m",$enddate),date("d", $enddate),date("Y", $enddate)); 

        $res['data.utcDateTime'] = array('BETWEEN',array($start,$end));
        $device_id = "SC-GD001-00256";
        $res['data.deviceID'] = array('eq',$device_id);
        $res['data.type'] = array('eq','BT');//不查询无效数据

		$attend_info = M('Data_handlering') ->alias('data')
		-> join('left join Student_info stu on data.deviceID = stu.device_id')
		-> where($res)
		->order('utcDateTime asc')
		-> field('stu.name,data.utcDateTime')
		-> select();    
       
       
        echo json_encode($attend_info); 
        die;
    }
    
    public function htyattend(){
        $nowstartdate =  I('post.nowstartDatetime');
        $nowenddate =  I('post.nowendDatetime');
    

    
        $res['data.utcDateTime'] = array('BETWEEN',array($nowstartdate,$nowenddate));
        $device_id = "SC-GD001-00256";
        $res['data.deviceID'] = array('eq',$device_id);
        $res['data.type'] = array('eq','BT');//不查询无效数据
    
        $htyattend_info = M('Data_handlering') ->alias('data')
        -> join('left join Student_info stu on data.deviceID = stu.device_id')
        -> where($res)
        ->order('utcDateTime asc')
        -> field('stu.name,data.utcDateTime')
        -> select();
         
         
        echo json_encode($htyattend_info,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        die;
    }    

}