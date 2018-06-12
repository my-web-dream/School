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
class   ModeController extends Controller {
    /**
     * 登录界面展示
     */
    public function mode(){
       // $receive = I('post.login');
        //$result = json_decode($receive, true);
        //得到gps参数请求
        //$device_id = I('post.deviceID');
        $device_id =  I('post.deviceID');
        $data['Ring'] =  I('post.Ring');       
        $data['RingV'] =  I('post.RingV');
        $data['powerOnDateTime'] = I('post.powerOnDateTime');
        $data['powerOffDateTime'] = I('post.powerOffDateTime');
        $data['RejectOnDateTimeFlag'] = I('post.RejectOnDateTimeFlag');
        $data['RejectOnAMTime'] = I('post.RejectOnAMTime');
        $data['RejectOnPMTime'] = I('post.RejectOnPMTime');
        $data['RejectOnNightTime'] = I('post.RejectOnNightTime');
        $data['create_time'] = I('post.create_time');
        
        $res['deviceID'] = array('eq',$device_id);
        
        $mode_info = M('device_handlering')
        ->where($res)
        ->data($data)
        ->save();
      //   
       // 
      // ;//获取最新一条位置信息
            
    }
    
    public function htymode(){
        $date =  I('post.deviceID');
        
        $device_id = "SC-GD001-00256";
        $res['deviceID'] = array('eq',$device_id);

        $htymode_info = M('device_handlering') 
        ->where($res)
        -> field('Ring,RingV,powerOnDateTime,powerOffDateTime,RejectOnDateTimeFlag,RejectOnAMTime,RejectOnPMTime,RejectOnNightTime')
        ->order('create_time desc')
        ->limit(1)
         ->find();  
       
       
        echo json_encode($htymode_info); die;
    }
    
    

}