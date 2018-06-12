<?php
namespace Admin\Model;
use Think\Model;

/**
 * 管理员信息
 */
class AdminModel extends Model {
	/**
	 * 设备信息分页显示
	 */
	public function page($page){	//页数，日期，编号，类型
		$page_size = 10;	//每页10条数据
		$start_data = ($page-1) * $page_size;	//设定数据起始位置
		//查询设备总数量
		$info = M('Device_handlering')
		-> field('id')
		-> select();
		$total = count($info);	//总条数
		//查询当前页符合条件数量
		$select_info = M('Device_handlering')
		-> field('id,deviceID,IMEI,IMSI,create_time,is_bind')
		-> order('create_time desc')
		-> limit($start_data,$page_size)
		-> select();
		//输出总页数
		$total_pages = ceil($total/$page_size);	//ceil,floor
		return array('page'=>$page,
				'total_pages'=>$total_pages,
				'select_info'=>$select_info,
		);
	}
	
}
