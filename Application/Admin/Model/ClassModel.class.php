<?php
namespace Admin\Model;
use Think\Model;

/**
 * 班级信息
 */
class ClassModel extends Model {
	/**
	 * 学生基本信息 
	 */
	public function student_info(){
		$grade_id = M('Class_info')
		-> where(array('id'=>session('auth_id')))
		-> getField('grade_id');
		//查找条件：所在年级，所在班级
		$res['class_id'] = array('eq',session('auth_id'));
		$res['grade_id'] = array('eq',$grade_id);
		$info = M('Student_info')
		-> where($res)
		-> field('name,sex,parent_name,parent_phone,device_id')
		-> select();
		return $info;
	}
	/**
	 * 查询学生考勤/报警数据+分页显示
	 */
	public function realtime($page,$date,$device_id,$type){	//页数，日期，编号，类型
		
		$page_size = 10;	//每页10条数据
		$start_data = ($page-1) * $page_size;	//设定数据起始位置
		$date = strtotime($date);	//获取前台提交时间
		//获取当日起止时间戳
		$start = mktime(0,0,0,date("m",$date),date("d", $date),date("Y", $date));
		$end = mktime(23,59,59,date("m",$date),date("d", $date),date("Y", $date));
		//查询条件
		$res['data.utcDateTime'] = array('BETWEEN',array($start,$end));
		$res['data.deviceID'] = array('eq',$device_id);
		$res['data.type'] = array('eq',$type);
		//查询当日总的数据数量
		$info = M('Data_handlering') ->alias('data')
		-> where($res)
		-> field('data.deviceID,data.IMEI,data.IMSI')
		-> select();
		$total = count($info);	//总条数
		//查询当前页符合条件数量
		$select_info = M('Data_handlering') ->alias('data')
		->join('left join Student_info stu on data.deviceID = stu.device_id')
		-> where($res)
		-> field('stu.name,data.utcDateTime,data.deviceID,data.IMEI,data.IMSI')
		-> order('data.utcDateTime desc')
		-> limit($start_data,$page_size)
		-> select();
		//输出总页数
		$total_pages = ceil($total/$page_size);	//ceil,floor
		return array('page'=>$page,
				'total_pages'=>$total_pages,
				'select_info'=>$select_info,
		);
	}
	/**
	 * 查询学生位置
	 */
	public function position($date,$device_id){
		//获取当日起止时间戳
		$start = mktime(0,0,0,date("m",$date),date("d", $date),date("Y", $date));
		$end = mktime(23,59,59,date("m",$date),date("d", $date),date("Y", $date));
		//查询条件
		$res['utcDateTime'] = array('BETWEEN',array($start,$end));
		$res['deviceID'] = array('eq',$device_id);
		$res['longitude'] = array('neq','0.0000000');//不查询无效数据
		$res['latitude'] = array('neq','0.0000000');//不查询无效数据
		$data = M('Data_handlering')
		-> where($res)
		-> field('deviceID,longitude,latitude,utcDateTime')
		-> select();
		//通过第三方接口纠偏(WGS-BD)
		$jd = '';$wd = '';$post_data = '';
		foreach($data as $key=>$val){
			$jd .= $val['longitude'].';';
			$wd .= $val['latitude'].';';
		}
		$jd =rtrim($jd,';');
		$wd =rtrim($wd,';');
		//发送字符串组装
		$post_data = 'lats='.$wd.'&lngs='.$jd.'&type=5';
		$url = 'http://api.zdoz.net/transmore.ashx';
		$curl = new \Admin\Controller\PublicController();
		$json_data = $curl -> curl_post($url,$post_data);
		//转换新数组结果展示
		$data_array = json_decode($json_data,true);//已转换为百度地图数据
		
		$count = count($data_array);	//计算结果数量
		//设置中心点
		$jd_center='';$wd_center='';$jd_total='';$wd_total='';
		//转化为百度地图需求
		for($I=0;$I<$count;$I++){
			$jd_total += $data_array[$I]['Lng'];
			$wd_total += $data_array[$I]['Lat'];
			$str[$I] = $data_array[$I]['Lng'].','.$data_array[$I]['Lat'];
			$orbit .= " new BMap.Point($str[$I]),";
			$arr[$I]['position'] = " new BMap.Point($str[$I])";
			$arr[$I]['utcDateTime'] = $data[$I]['utcDateTime'];	//原查询时间
		}
		$jd_center = $jd_total / $count;	//经度中心点
		$wd_center = $wd_total / $count;	//纬度中心点
		return array('orbit'=>$orbit,'arr'=>$arr,'jd_center'=>$jd_center,'wd_center'=>$wd_center);	//返回轨迹和文字标注
	}	
	/**
	 * 查询基站ID数据 
	 */
	public function base_id($date,$device_id){
		$date = strtotime($date);
		//获取当日起止时间戳
		$start = mktime(0,0,0,date("m",$date),date("d", $date),date("Y", $date));
		$end = mktime(23,59,59,date("m",$date),date("d", $date),date("Y", $date));
		//查询条件
		$res['utcDateTime'] = array('BETWEEN',array($start,$end));
		$res['deviceID'] = array('eq',$device_id);
		$info = M('Data_handlering')
		-> where($res)
		-> field('LBS')
		-> limit(10)
		-> select();
		return $info;
	}
}
