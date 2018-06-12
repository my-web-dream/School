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
class GpsController extends Controller {
    /**
     * 登录界面展示
     */
    public function gps(){
       // $receive = I('post.login');
        //$result = json_decode($receive, true);
        //得到gps参数请求
        //$device_id = I('post.deviceID');
        $device_id = "SC-GD001-00256";
        $res['deviceID'] = array('eq',$device_id);     
        $res['longitude'] = array('neq','0.0000000');//不查询无效数据
        $res['latitude'] = array('neq','0.0000000');
        
        $gps_info = M('data_handlering') 
        ->where($res)
        -> field('deviceID,longitude,latitude,utcDateTime')
        ->order('utcDateTime desc')
        ->limit(1)
         ->find();
      //   
       // 
      // ;//获取最新一条位置信息
        
        $Longitude = $gps_info['longitude'];
        $Latitude = $gps_info['latitude'];
        $utcDateTime = $gps_info['utcDateTime'];
    
        	$response = array(
        			'Longitude' => $Longitude,
        			'Latitude' => $Latitude,
        	        'utcDateTime' => $utcDateTime
        	);
        	echo json_encode($response); die;
    }
    
    public function htygps(){
        $date =  I('post.Datetime');
        
        $date = strtotime($date);
        $start = mktime(0,0,0,date("m",$date),date("d", $date),date("Y", $date));
        $end = mktime(23,59,59,date("m",$date),date("d", $date),date("Y", $date)); 

        $res['utcDateTime'] = array('BETWEEN',array($start,$end));
        $device_id = "SC-GD001-00256";
        $res['deviceID'] = array('eq',$device_id);
        $res['longitude'] = array('neq','0.0000000');//不查询无效数据
        $res['latitude'] = array('neq','0.0000000');

        $htygps_info = M('data_handlering')
        ->where($res)
        -> field('longitude,latitude,utcDateTime')
        ->select();      
       
       
        echo json_encode($htygps_info); die;
    }
    
    

}