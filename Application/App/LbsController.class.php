<?php
namespace App\Controller;

use \Think\Controller;

class LbsController extends Controller
{

    public function Lbs_info()
    {
        $startdate = I('post.startDatetime');
        $enddate = I('post.endDatetime');
        
        $startdate = strtotime($startdate);
        $enddate = strtotime($enddate);
        $start = mktime(0, 0, 0, date("m", $startdate), date("d", $startdate), date("Y", $startdate));
        $end = mktime(23, 59, 59, date("m", $enddate), date("d", $enddate), date("Y", $enddate));
        
        $res['data.utcDateTime'] = array(
            'BETWEEN',
            array(
                $start,
                $end
            )
        );
        $device_id = "SC-GD001-00256";
        $res['data.deviceID'] = array(
            'eq',
            $device_id
        );
        $attend_info = M('data_handlering')->where($res)
            ->field('LBS')
            ->select();
        
        var_dump($attend_info);
    }
}