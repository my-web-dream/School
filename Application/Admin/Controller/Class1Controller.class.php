<?php
namespace Admin\Controller;
use Think\Controller;

/**
 * 班级信息
 */
class Class1Controller extends Controller {
	public function test(){
		$filename = MODULE_NAME.'/aa/aaa.txt';
		echo $filename;die;
		echo date('Y-m-d H:i:s','1488353363');
	}
	/**************************班级管理**********************/
	/**
	 *  班级信息(首页展示)
	 */
	public function class_info(){
		//$info = S('class_info');
		//if(!$info){
			$info = M('Class_info')->alias('class')
			->join('left join Grade_info grade on grade.id = class.grade_id')
			->join('left join School_info sch on sch.id = class.school_id')
			->where(array('class.id'=>session('auth_id')))
			->field('class.name,class.leader,class.phone_number,grade.name as grade_name,sch.name as sch_name')
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
	public function class_leader_info(){
		
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
		$result = M('Class_info')
		-> where(array('id'=>session('auth_id')))
		-> field('school_id,grade_id')
		-> find();
		$res['class_id'] = array('eq',session('auth_id'));
		$res['grade_id'] = array('eq',$result['grade_id']);
		$res['school_id'] = array('eq',$result['school_id']);
		$info = M('Student_info')
		-> where($res)
		-> field('name,sex,parent_name,parent_phone,device_id')
		-> select();
		$this -> assign('info',$info);
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
		$info = M('Class_info')
		-> where(array('id'=>session('auth_id')))
		-> field('school_id,grade_id')
		-> find();
		$data['grade_id'] = $info['grade_id'];	//年级id
		$data['school_id'] = $info['school_id'];	//学校id
		$res = M('Student_info')->add($data);	//添加学生信息
		if($res){
			echo 'add_success';
		}else{
			echo 'add_failed';
		}
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
		//多表联查学生考勤信息
		$info = D('Class') -> attend($date,$device_id);
		$this -> assign('info',$info);
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
		//多表联查学生考勤信息
		$info = D('Class') -> sos($date,$device_id);
		$this -> assign('info',$info);
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
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	/************************************************************/
    /**
     *  搜索
     */
    public function search() {
        //关键字
        $keywords = I("post.keywords");
        //结果
//        $res = M("StaffInfo")->where("object_name like '%{$keywords}%'")->limit('0,9')->select();
        $res = M("ProjectInfo")->where("name like '%{$keywords}%'")->limit('0,9')->select();
        foreach ($res as $k => $v) {
            $values[] = $v['name'];
        }
//        dump($values);exit;
        //返回json数据
        $this->ajaxreturn($values);
//        echo json_encode($values);
    }

    /**
     * 信息通知
     */
    public function new_banner() {
        $data['title'] = "信息通知";
        $data['content'] = "一条通知";
        $this->ajaxReturn($data);
    }

    /**
     * 项目部基本信息 （显示界面）
     */
    public function project_info() {
        $id = session('project_id');
        $info = M('ProjectInfo')->where(array('id' => $id))->find();
        $this->assign("info", $info);
        $this->display();
    }

    /**
     * 项目部位置（显示界面）
     */
    public function project_local() {
        $project_id = session('project_id');
        $position = M('ProjectInfo')
                ->where(array('id' => $project_id))
                ->getField('position');
        $this->assign('position', $position);
        $this->display();
    }

    /**
     * 	map_editor（编辑项目部位置页面）
     */
    public function map_editor() {
        $id = I("get.id");  //project_id
        $this->assign('id', $id);    //项目部id不要传丢
        $this->display();
    }

    /**
     * map（项目部坐标提交）
     */
    public function map_position_save() {
        $Arr = $_POST;
        //循环得到全部的postion
        for ($i = 0; $i < count($Arr['jwd']); $i++) {
            $postion.=$Arr['jwd'][$i] . ";";
            $bj.=$Arr['bj'][$i] . ";";
            if ($Arr['houzhui'][$i] == 1) {
                $Arr['gcname'][$i].="号塔基";
            } else if ($Arr['houzhui'][$i] == 3) {
                $Arr['gcname'][$i].="号施工地";
            } else if ($Arr['houzhui'][$i] == 4) {
                $Arr['gcname'][$i].="号材料站";
            } else if ($Arr['houzhui'][$i] == 5) {
                $Arr['gcname'][$i].="号项目部";
            }
            $gcname.=$Arr['gcname'][$i] . ";";
        }

        $postion = substr($postion, 0, strlen($postion) - 1);
        $bj = substr($bj, 0, strlen($bj) - 1);
        $gcname = substr($gcname, 0, strlen($gcname) - 1);
        $id = session('project_id');
        //工程区域
        $data['coordinate'] = $postion;
        $data['paintingRadius'] = $bj;
        $data['paintingname'] = $gcname;
        $ress = M("ProjectInfo")->where(array('id' => $id))->save($data);
//        if ($ress) {
//            $content = "编辑了项目id为" . session('project_id') . "的" . session('project_name') . "的工程区域位置";
//            hot_value($content);
//        }
        echo "<script>alert('工程位置更新成功');location.replace(document.referrer);</script>";
    }

    /**
     * map_coordinate_editor(输入坐标可编辑项目部)
     */
    public function map_coordinate_editor() {
        $id = session('project_id');
        $this->assign('id', $id);    //项目部id不要传丢
        $this->display();
    }

    public function map_coordinate() {
        $id = session('project_id');
        $Arr = $_POST;
        foreach ($Arr as $key => $val) {
            for ($v = 0; $v < count($val); $v++) {
                if ($val[$v] == "") {
                    if ($key == "gcname") {
                        echo "<script>alert('工程区域名不能为空！'); setTimeout(function(){
                                parent.location.reload();
                                },1000);</script>";
                        exit;
                    }
                    if ($key == "wd") {
                        echo "<script>alert('纬度不能为空！'); setTimeout(function(){
                                parent.location.reload();
                                },1000);</script>";
                        exit;
                    }
                    if ($key == "jd") {
                        echo "<script>alert('经度不能为空！'); setTimeout(function(){
                                parent.location.reload();
                                },1000);</script>";
                        exit;
                    }
                    if ($key == "bj") {
                        echo "<script>alert('半径不能为空！'); setTimeout(function(){
                                parent.location.reload();
                                },1000);</script>";
                        exit;
                    }
                }
            }
        }
        $type = I('post.type');
        for ($i = 0; $i < count($Arr['jd']); $i++) {
            if (!empty($Arr['jd'][$i]) || !empty($Arr['wd'][$i])) {
                $postion.=$Arr['jd'][$i] . "," . $Arr['wd'][$i] . ";";
                $radius.=$Arr['bj'][$i] . ";";
//                if($Arr['houzhui'][$i]==1){
//                $Arr['gcname'][$i].="号塔基";
//            }else if($Arr['houzhui'][$i]==3){
//                 $Arr['gcname'][$i].="号施工地";
//            }
//            else if($Arr['houzhui'][$i]==4){
//                 $Arr['gcname'][$i].="号材料站";
//            }
//            else if($Arr['houzhui'][$i]==5){
//                 $Arr['gcname'][$i].="号项目部";
//            }
                $posName.=$Arr['gcname'][$i] . ";";
            }
        }
        $postion = substr($postion, 0, strlen($postion) - 1);
        $radius = substr($radius, 0, strlen($radius) - 1);
        $posName = substr($posName, 0, strlen($posName) - 1);
        /*         * ****************************************************************
         * 将经纬度存入数据库
         *  1,拼接成数据库要使用的格式
         *  2,保存
         */
        $model = M('ProjectInfo');
        $result = $model->where(array('id' => $id))->save(array('position' => $postion, "radius" => $radius, "posName" => $posName, 'type' => 1));
//        if ($result) {
//            $content = "编辑了项目id为" . session('object_id') . "的" . session('project_name') . "的工程其他区域位置";
//            hot_value($content);
//        }
        //利用data拼接经纬度
        //104.06212352752688,30.67148399030799
//        session('data') = $data;          //保存到session中
//        session('coord_id') = $id;
        $url = U("Project/project_overview");     //跳转控制器中
        echo "<script>alert('工程位置更新成功');location.replace(document.referrer);</script>";
    }

    public function map_coordinate_index() {
        $data = M('Project')
                ->field('name,position,radius,posname,coordinate,paintingradius,paintingname,type')
                ->where(array('id' => session('object_id')))
                ->find();
        $data['position'].=";" . $data['coordinate'];
        $data['radius'].=";" . $data['paintingradius'];
        $data['posname'].=";" . $data['paintingname'];

        //$position为一维数组
        $array = explode(';', $data['position']);
        for ($l = 0; $l < count($array); $l++) {
            $polylines.="new BMap.Point(" . $array[$l] . "),";
        }
        $this->assign('project_name', json_encode($data['name']));
        $this->assign('polyline', $polylines);
        $count = count($array);
        //获取中心点坐标：横纵坐标的平均值
        $jd = '';
        $wd = '';
        for ($i = 0; $i < $count; $i++) {
            $jd += explode(',', $array[$i])['0'];
            $wd += explode(',', $array[$i])['1'];
        }
        $postion_jd = $jd / $count;
        $this->assign('jd', $postion_jd);
        $postion_wd = $wd / $count;
        $this->assign('wd', $postion_wd);
        $this->assign('data', json_encode(explode(';', $data["position"])));      //转换成json数据
        $this->assign('radius', json_encode(explode(';', $data["radius"])));      //转换成json数据
        $this->assign('posName', json_encode(explode(';', $data["posname"])));      //转换成json数据
        $this->display();
    }

    /**
     * 	map_show（显示页面）
     */
    public function map_show() {
        $project_id = session('object_id');
        $data = M('Project')
                ->field('name,position,radius,posname,coordinate,paintingradius,paintingname,type')
                ->where(array('id' => $project_id))
                ->find();
        $data['position'].=";" . $data['coordinate'];
        $data['radius'].=";" . $data['paintingradius'];
        $data['posname'].=";" . $data['paintingname'];
        //$position为一维数组
        $array = explode(';', $data['coordinate']);
        for ($l = 0; $l < count($array); $l++) {
            $polylines.="new BMap.Point(" . $array[$l] . "),";
        }
        $this->assign('project_name', json_encode($data['name']));
        $this->assign('polyline', $polylines);
        $count = count($array);
        //获取中心点坐标：横纵坐标的平均值
        $jd = '';
        $wd = '';
        for ($i = 0; $i < $count; $i++) {
            $jd += explode(',', $array[$i])['0'];
            $wd += explode(',', $array[$i])['1'];
        }
        $postion_jd = $jd / $count;
        $this->assign('jd', $postion_jd);
        $postion_wd = $wd / $count;
        $this->assign('wd', $postion_wd);
        if ($data['type'] == 1) {
            $this->assign('data', json_encode(explode(';', $data["position"])));      //转换成json数据
            $this->assign('radius', json_encode(explode(';', $data["radius"])));      //转换成json数据
            $this->assign('posName', json_encode(explode(';', $data["posname"])));      //转换成json数据
            $this->display('map_coordinate_index');
        } else {
            $result = "";
            for ($i = 0; $i < $count; $i++) {
                $result.= " new BMap.Point($array[$i]),";
            }
            $this->assign("project_position", $result); //项目部位置信息，显示在map_show页面
            $this->display();
        }
    }

    /**
     * 项目部成员(显示界面)
     */
    public function project_member($id) {
        //列出此公司下所有项目部成员(已排除公司管理员)
        $staff = M("Staff")
                ->where(array("auth_id" => $id, 'auth' => 'project'))
                ->where('status>-1')
                ->order('create_time')
                ->select();
        $this->assign("staff", $staff);
        $this->assign('id', $id);
        $this->display();
    }

    /**
     * 项目部工人（显示页面），包含搜索
     */
    public function con_project_worker() {
        $id = session('project_id');
        $keyword = I('get.cond', '');
        if ($keyword == "黑名单") {
            $condition = "`blacklist` = 1";
        } elseif ($keyword == "离职") {
            $count = M('WorkerInfo')
                    ->where(array('project_id' => $id))
                    ->where('status = 0 and unit_id > 2')
                    ->count();
            $Page = new \Think\Page($count, 10);
            $show = $Page->show();
            //获取项目部工人信息
            $sql = "SELECT `id`,`name`,`card_number`,`wrist_number`,`project_id`,`create_time`,`leave_time`,`unit_id`,`type_id`,`blacklist`,`status` FROM `worker_info` WHERE `project_id` = {$id} AND status=0 AND unit_id > 2 order by status desc,unit_id limit $Page->firstRow,$Page->listRows";
            $worker = M('WorkerInfo')->query($sql);
            //加入所属单位和工种
            $projects = [1 => "业主单位", 2 => "监理单位", 3 => "施工单位", 4 => "分包单位", 5 => "劳务一队", 6 => "劳务二队", 7 => "劳务三队", 8 => "劳务四队", 9 => "劳务五队"];
            $typename = M("WorkType")->getField("id,type");
            for ($i = 0; $i < count($worker); $i++) {
                $unit = $worker[$i]['unit_id'];
                $type = $worker[$i]['type_id'];
                $worker[$i]['unitname'] = $projects[$unit];  //加入所属单位
                $worker[$i]['typename'] = $typename[$type];  //加入所属工种
            }
            // 视图渲染
            $this->assign('worker', $worker);
            $this->assign("show", $show);
            $this->display("project_worker");
        } else {
            $condition = "`name` LIKE '%{$keyword}%' OR `card_number` LIKE '%{$keyword}%'  OR type_id in (select id from work_type where type like '%{$keyword}%')";
        }
        $count = M('WorkerInfo')
                ->where(array('project_id' => $id))
                ->where("status > -1 AND {$condition} AND unit_id > 2")
                ->count();
        $Page = new \Think\Page($count, 10);
        $show = $Page->show();
        //获取项目部工人信息
        $sql = "SELECT `id`,`name`,`card_number`,`wrist_number`,`project_id`,`create_time`,`leave_time`,`unit_id`,`type_id`,`blacklist`,`status` FROM `worker_info` WHERE `project_id` = {$id} AND status>-1 AND ({$condition})  AND unit_id > 2 order by status desc,blacklist desc,unit_id LIMIT $Page->firstRow,$Page->listRows";
        $worker = M('WorkerInfo')->query($sql);
        //加入所属单位和工种
        $projects = [1 => "业主单位", 2 => "监理单位", 3 => "施工单位", 4 => "分包单位", 5 => "劳务一队", 6 => "劳务二队", 7 => "劳务三队", 8 => "劳务四队", 9 => "劳务五队"];
        $typename = M("WorkType")->getField("id,type");
        for ($i = 0; $i < count($worker); $i++) {
            $unit = $worker[$i]['unit_id'];
            $type = $worker[$i]['type_id'];
            $worker[$i]['unitname'] = $projects[$unit];
            $worker[$i]['typename'] = $typename[$type];
        }
        // 视图渲染
        $this->assign('worker', $worker);
        $this->assign("show", $show);
        $this->display("project_worker");
    }

    /**
     * 项目部工人（监理），包含搜索
     */
    public function sup_project_worker() {
        $id = session('project_id');
        $keyword = I('get.cond', '');
        if ($keyword == "黑名单") {
            $condition = "`blacklist` = 1";
        } elseif ($keyword == "离职") {
            $count = M('WorkerInfo')
                    ->where(array('project_id' => $id))
                    ->where('status = 0 and unit_id > 1')
                    ->count();
            $Page = new \Think\Page($count, 10);
            $show = $Page->show();
            //获取项目部工人信息
            $sql = "SELECT `id`,`name`,`card_number`,`wrist_number`,`project_id`,`create_time`,`leave_time`,`unit_id`,`type_id`,`blacklist`,`status` FROM `worker_info` WHERE `project_id` = {$id} AND status=0 AND unit_id > 1 order by status desc,unit_id limit $Page->firstRow,$Page->listRows";
            $worker = M('WorkerInfo')->query($sql);
            //加入所属单位和工种
            $projects = [1 => "业主单位", 2 => "监理单位", 3 => "施工单位", 4 => "分包单位", 5 => "劳务一队", 6 => "劳务二队", 7 => "劳务三队", 8 => "劳务四队", 9 => "劳务五队"];
            $typename = M("WorkType")->getField("id,type");
            for ($i = 0; $i < count($worker); $i++) {
                $unit = $worker[$i]['unit_id'];
                $type = $worker[$i]['type_id'];
                $worker[$i]['unitname'] = $projects[$unit];  //加入所属单位
                $worker[$i]['typename'] = $typename[$type];  //加入所属工种
            }
            // 视图渲染
            $this->assign('worker', $worker);
            $this->assign("show", $show);
            $this->display("project_worker");
        } else {
            $condition = "`name` LIKE '%{$keyword}%' OR `card_number` LIKE '%{$keyword}%'  OR type_id in (select id from work_type where type like '%{$keyword}%')";
        }
        $count = M('WorkerInfo')
                ->where(array('project_id' => $id))
                ->where("status > -1 AND {$condition} AND unit_id > 1")
                ->count();
        $Page = new \Think\Page($count, 10);
        $show = $Page->show();
        //获取项目部工人信息
        $sql = "SELECT `id`,`name`,`card_number`,`wrist_number`,`project_id`,`create_time`,`leave_time`,`unit_id`,`type_id`,`blacklist`,`status` FROM `worker_info` WHERE `project_id` = {$id} AND status>-1 AND ({$condition})  AND unit_id > 1 order by status desc,blacklist desc,unit_id LIMIT $Page->firstRow,$Page->listRows";
        $worker = M('WorkerInfo')->query($sql);
        //加入所属单位和工种
        $projects = [1 => "业主单位", 2 => "监理单位", 3 => "施工单位", 4 => "分包单位", 5 => "劳务一队", 6 => "劳务二队", 7 => "劳务三队", 8 => "劳务四队", 9 => "劳务五队"];
        $typename = M("WorkType")->getField("id,type");
        for ($i = 0; $i < count($worker); $i++) {
            $unit = $worker[$i]['unit_id'];
            $type = $worker[$i]['type_id'];
            $worker[$i]['unitname'] = $projects[$unit];
            $worker[$i]['typename'] = $typename[$type];
        }
        // 视图渲染
        $this->assign('worker', $worker);
        $this->assign("show", $show);
        $this->display("project_worker");
    }

    /**
     * 添加工人信息(提交方法)
     */
    public function project_worker_add_sub() {
        $data['project_id'] = session('project_id');
        $data['name'] = I("post.name");
        $data['age'] = I("post.age");
        $data['card_number'] = I("post.card_number");
        $data['wrist_number'] = I("post.wrist_number");
        $data['phone_number'] = I("post.phone_number");
        $data['type_id'] = I("post.select_work_type");
        $data['emergency_people'] = I("post.emergency_people");
        $data['emergency_phone'] = I("post.emergency_phone");
        $data['unit_id'] = I("post.unit");
        $data['create_time'] = time();
        $is_grant['is_grant'] = '1';
        M('DeviceHandlering')->where(array('deviceID' => $data['wrist_number']))->save($is_grant);
        //添加信息入员工信息表
        $info = M("WorkerInfo")->add($data);
        if ($info) {
//            echo "<script>parent.layer.msg('添加工人信息成功！'); setTimeout(function(){
//                                    parent.location.reload();
//                                    },1000);</script>";
            $this->success("添加人员成功");
        } else {
            $this->error("添加失败，请重新添加");
        }
    }

    /**
     * 添加工人信息检查手环ID
     */
    public function check_add_wrist_only() {
        $wrist_number = I("post.wrist_number");
        $wrist = M('DeviceHandlering')
                ->where(array("deviceID" => $wrist_number))
                ->field('id,is_grant')
                ->find();
        if (!$wrist['id']) {
            $data = 'no_device';
        } else {
            if ($wrist['is_grant'] == '1') {
                $data = 'is_used';
            } else {
                $data = 'no_used';
            }
        }
        $this->ajaxReturn($data);
    }

    /**
     * 	添加工人信息检验身份证号是否唯一 
     */
    public function check_add_card_only() {
        $card_number = I("post.card_number");
        $card_id = M('WorkerInfo')->where(array("card_number" => $card_number))->getField('id');
//        $card_black = M('Blacklist')->where(array("card_number" => $card_number))->getField('id');
        if ($card_id) {
            $types = M('WorkerInfo')->where(array("card_number" => $card_number))->field('status')->select();
            foreach ($types as $type) {
                if ($type['status'] == 0) {
                    $data = 'no_used';
                } else {
                    $data = 'is_used';
                }
            }
        }
//        else if ($card_black) {
//            $data = 'black_list'; //列入黑名单
//        } 
        else {
            $data = 'no_used';  //没有被使用
        }
        $this->ajaxReturn($data);
    }

    /**
     * 更新工人信息检验身份证号唯一
     */
    public function check_update_card_only() {
        $wrist_number = I("post.wrist_number");
        $card_number = I("post.card_number");
        $info = M('Worker')->
                where(array("card_number" => $card_number))
                ->field('id,wrist_number') //找到id和手环编号
                ->find();
        $card_black = M('Black_list')->
                where(array("card_number" => $card_number))
                ->getField('id');
        if ($card_black) {
            $data = 'black_list'; //已被拉黑
        } else if (!$info['id']) {
            $data = 'no_used';  //没有被使用,可以使用
        } else {      //已存在，判断该身份证号是不是自己的
            if ($wrist_number != $info['wrist_number']) {
                $data = 'is_used';
            } else {     //是自己的身份证号
                $data = 'no_used';
            }
        }
        $this->ajaxReturn($data);
    }

    /**
     * 更新工人信息——检验工种是否存在
     */
    public function check_work_type_exist() {
        $work_type = I("post.work_type");
        $id = M('Work_type')
                ->where(array('type' => $work_type))
                ->getfield('id');
        if (!$id) {  //提交工种不存在
            echo "none";
        } else {
            echo "ok";
        }
    }

    /**
     * 更新工人单位——检验单位是否存在
     */
    public function check_work_unit_exist() {
        $work_unit = I("post.work_unit");
        $id = M('Worker')
                ->where(array('unit' => $work_unit))
                ->getfield('id');
        if (!$id) {  //提交工种不存在
            echo "none";
        } else {
            echo "ok";
        }
    }

//    /**
//     * 更新工人基本信息
//     */
//    public function project_worker_update() {
//        $worker_id = I("post.id"); //获取工人的ID
//        $data = M('WorkerInfo')->find($worker_id); //找到该工人信息
//        $data['work_type'] = M('WorkType')
//                ->where(array('id' => $data['type_id']))
//                ->getField('type');  //查询工人工种
//        if ($data) {
//            $this->ajaxReturn($data);
//        } else {
//            echo false;
//        }
//    }
//
//    /**
//     * 更新工人信息（提交方法）
//     */
//    public function project_worker_update_sub() {
//        $worker_id = decode(I("post.worker_id")); //工人id
//        $data['type_id'] = I("post.work_type");     //取得工种id
//        $data['unit'] = I("post.unit");     //企业所属单位
//        $data['name'] = I("post.name");
//        $data['age'] = I("post.age");
//        $data['card_number'] = I("post.card_number");
//        $data['phone_number'] = I("post.phone_number");
//        $data['address'] = I("post.address");
//        $data['is_mobile_attend'] = I("post.is_mobile_attend");
//        $data['emergency_people'] = I("post.emergency_people");
//        $data['emergency_phone'] = I("post.emergency_phone");
//        //先去检验该员工是否存在密码
//        $password_exist = M('Worker')->where(array('id' => $worker_id))->getField('password');
//        if ($data['is_mobile_attend'] == 1) {
//            $password = I("post.password");  //为"______"
//            //存在原密码
//            if ($password_exist) {
//                if ($password == "______") {
//                    ; //为初始则未修改密码
//                } else { //密码已修改
//                    $data['password'] = md5($password); //密码加密处理
//                }
//            }
//            //不存在原密码，为首次添加
//            else {
//                $data['password'] = md5($password);
//            }
//        }
//        $data['create_time'] = time();
//
//        $ress = M('Worker')->where(array('id' => $worker_id))->save($data);
//        if ($ress) {
//            $content = "更新了员工id为" . $worker_id . "的个人信息";
//            hot_value($content);
//        }
//        echo "<script>parent.layer.msg('更新工人信息成功！'); setTimeout(function(){
//                                parent.location.reload();
//                                },1000);</script>";
//    }

    /**
     * 工人照片回填
     */
    public function project_worker_image() {
        $wrist_number = I('post.wrist_number');
        $data = M('WorkerInfo')->where(array('wrist_number' => $wrist_number))
                ->field('name,wrist_number,image')
                ->find();
        $this->ajaxReturn($data);
    }

    /**
     * 工人照片上传(提交入库)
     */
    public function project_worker_image_sub() {
        $wrist_number = I('post.wrist_number');
        $flag = 1; //上传成功与否标志
        $file = $_FILES['head_image'];  //$_FILES文件数组，$file为二维数组
        if (!$file['name']) {  //禁止非空上传
            echo "<script>parent.layer.msg('未上传文件禁止保存！'); setTimeout(function(){
                                parent.location.reload();
                                },1000);</script>";
            die;
        }
        if (isset($file) && $file['name'] != "") {
            $array = array("image/jpg", "image/png", "image/jpeg");
            $file_type = $file['type'];  //查看图片类型
            if (!in_array($file_type, $array)) {
                echo "<script>parent.layer.msg('系统仅支持jpg,jpeg,png格式图片,请重新上传！'); setTimeout(function(){
                                parent.location.reload();
                                },1000);</script>";
                ;
                die;
            }
            if ($file['size'] > 1048576) {
                echo "<script>parent.layer.msg('图片大小不能超过1M！'); setTimeout(function(){
                                parent.location.reload();
                                },1000);</script>";
                ;
                die;
            }
            $type = strrchr($file['name'], "."); //寻找"."在字符串中最后一次出现的位置及以后的信息（获取类型）
            $time = date("YmdHis");
            $filename = $wrist_number . '_' . $time . $type; //设置图片名称唯一
            if (is_uploaded_file($file['tmp_name'])) {
                if (move_uploaded_file($file['tmp_name'], "./Public/upload/worker_image/" . $filename)) {
                    $data['image'] = $filename; //图片名称
                    $path = "./Public/upload/worker_image/" . $filename; //图片具体路径
                    //TP图像处理
                    $image_thumb = new \Think\Image(); //实例化
                    $image_thumb->open($path); //打开对应路径的图片
                    $image_thumb->thumb(100, 100, \Think\Image::IMAGE_THUMB_FIXED)->save($path); //固定大小剪裁
                } else {
                    $flag = 0;
                }
            } else {
                $flag = 0;
            }
        }
        if ($flag == 0) {
            echo "<script>parent.layer.msg('上传头像失败！'); setTimeout(function(){
                                parent.location.reload();
                                },1000);</script>";
            die;
        }
        //上传成功后，需要删除原图
        $last_img = M('Worker')->where(array('wrist_number' => $wrist_number))->getField("image");
        if ($last_img != 'default.jpg') {
            unlink("./Public/upload/worker_image/" . $last_img);
        }
        $ress = M('Worker')->where(array('wrist_number' => $wrist_number))->save($data);
        if ($ress) {
            $worker_name = M('Worker')->where(array('wrist_number' => $wrist_number))->field('id')->select();
            $content = "更新了员工id为" . $worker_name[0]['id'] . "的头像";
            hot_value($content);
        }
        echo "<script>parent.layer.msg('保存工人头像成功！'); setTimeout(function(){
                                parent.location.reload();
                                },1000);</script>";
    }

    /**
     * 批量删除项目部工人
     */
    public function del_project_worker() {
        $arr = I("post.del_project_worker");  //数组worker表ID
        //1,根据id获取到worker表中的信息
        $data['id'] = array('IN', $arr);
        $arr_wrist_number = M('worker')->where($data)->select();
        //2,取出wrist_number 做成一维数组
        $deviceID = array();
        foreach ($arr_wrist_number as $v) {
            $deviceID[] = $v['wrist_number'];
        }
        $count = count($deviceID);      //计算数组的长度
        $status = array();
        //3,循环时执行sql语句
        //根据 deviceID = wrist_number 更新 device_handlering 表中的 is_grant 字段信息
        for ($i = 0; $i < $count; ++$i) {
            $status = M('Device_handlering')->where(array('deviceID' => $deviceID[$i]))->setField('is_grant', 0);
        }
        $id_cont = "";
        foreach ($arr as $key => $val) {
            $id_cont = $id_cont . $val . ",";
        }
        $id_cont = rtrim($id_cont, ",");
        $data = array(
            'status' => -1,
        );
        if ($status && M('Worker')->where(array('id' => array('in', $id_cont)))->save($data)) {
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }

    /**
     * 单个员工离职
     */
    public function leave_project_worker_one() {
        $id = I("post.id");
        $amount = I("post.amount");
        $info = I("post.info");
        $data = array(
            'leave_time' => NOW_TIME,
            'leave_amount' => $amount,
            'leave_info' => $info,
            'status' => 0,
        );
        if (M('WorkerInfo')->where(array('id' => $id))->save($data)) {
            $this->success("离职成功");
        } else {
            $this->error("离职失败，请稍后再试");
        }
    }

    /**
     * 单个删除项目部工人
     */
    public function del_project_worker_one() {
        $id = decode(I("get.id"));    //Worker表主键ID
        //1,根据worker查出wrist_number
        $wrist_number = M('Worker')->where(array('id' => $id))->getField('wrist_number');
        //2,根据 deviceID = wrist_number 更新字段
        $status = M('Device_handlering')->where(array('deviceID' => $wrist_number))->setField('is_grant', 0);
        $data = array(
            'status' => -1,
        );
        if ($status && M('Worker')->where(array('id' => $id))->save($data)) {
            $this->success("删除成功");
        } else {
            $this->error("删除失败！");
        }
    }

    /**
     * 工人位置(显示界面)
     */
    public function worker_local() {
        $test = 'no';
        $project_id = session('object_id'); //项目部id
        //分页类
        $count = M("Worker")->where(array('project_id' => $project_id))->count();
        $Page = new \Think\Page($count, 10); // 实例化分页类 传入总记录数和每页显示的记录数(10)
        $show = $Page->show(); // 分页显示输出
        $info = M("Worker")
                ->where(array('project_id' => $project_id))
                ->limit($Page->firstRow . ',' . $Page->listRows)
                ->order('convert(name using gbk)')
                ->select();
        if ($info) {
            $test = 'yes';
        }
        $this->assign("test", $test);
        $this->assign("info", $info);
        $this->assign("show", $show);
        $this->display();
    }

    /**
     * 工人位置
     */
    public function worker_local_map() {
        $project_id = I('get.project_id');  //获取项目部id
        if (isset($_GET['time'])) {
            $return_time = I('get.time');
            $time = strtotime(I('get.time'));
        } else {
            $return_time = date("Y-m-d", NOW_TIME);
            $time = NOW_TIME;
        }
        $wrist_number = I('get.wrist_number'); //获取手环ID
        $ps = M('ProjectInfo')
                ->field('name,position,radius,posname,coordinate,paintingradius,paintingname,type')
                ->where(array('id' => $project_id))
                ->find();
        $array = explode(';', $ps['coordinate']);
        if (!empty($ps['position'])) {
            $ps['coordinate'].=";" . $ps['position'];
            $ps['paintingradius'].=";" . $ps['radius'];
            $ps['paintingname'].=";" . $ps['posname'];
        }
        $count = count($array);
        //获取中心点坐标：横纵坐标的平均值
        $jd = '';
        $wd = '';
        for ($i = 0; $i < $count; $i++) {
            $jd += explode(',', $array[$i])['0'];
            $wd += explode(',', $array[$i])['1'];
        }
        $position_jd = $jd / $count;
        $this->assign('jd', $position_jd);
        $position_wd = $wd / $count;
        $this->assign('wd', $position_wd);
        if ($ps['type'] == 1) {
            $position_t = "";
            for ($i = 0; $i < $count; $i++) {
                $position_t.= " new BMap.Point($array[$i]),";
            }
            $positions = rtrim($position_t, ",");  //删除字符串右侧空格
            $this->assign('positions', $positions);
            $this->assign('namea', json_encode(explode(';', $ps["name"])));      //转换成json数据
            $this->assign('data', json_encode(explode(';', $ps["coordinate"])));      //转换成json数据
            $this->assign('radius', json_encode(explode(';', $ps["paintingradius"])));      //转换成json数据
            $this->assign('paintingnames', json_encode(explode(';', $ps["paintingname"])));      //转换成json数据
            $this->assign('type', 1);
        } else {
            $this->assign('data', "1");
            $position_t = "";
            for ($i = 0; $i < $count; $i++) {
                $position_t.= " new BMap.Point($array[$i]),";
            }
            $position = rtrim($position_t, ",");  //删除字符串右侧空格
            $this->assign("project_position", $position);  //显示项目部位置信息
            $this->assign('type', $ps['type']);
        }
        //获取工人位置
        $start = mktime(0, 0, 0, date("m", $time), date("d", $time), date("Y", $time));
        $end = mktime(23, 59, 59, date("m", $time), date("d", $time), date("Y", $time));
        $data['utcDateTime'] = array('BETWEEN', array($start, $end)); //设置今日起至时间
        $data['deviceID'] = array('eq', $wrist_number);
        //过滤经纬度错误信息
        $data['longitude'] = array('neq', '0');
        $data['latitude'] = array('neq', '0');
        $info = M('Data_handlering')
                ->where($data)
                ->field('utcdatetime,longitude,latitude')
                ->order('utcdatetime desc')
                ->limit(0, 100)      //由于地图只能识别100个坐标点,所以只取100条数据
                ->select();
        //循环输出工人位置信息和对应时间
        $worker_local = "";
        $worker_time = "";
        $position = "";
        $times = [];
        foreach ($info as $key => $val) {
            $position .= "{$val['longitude']},{$val['latitude']};";     //取出坐标点,拼接成API需要的格式
            $worker_local .= "new BMap.Point({$val['longitude']},{$val['latitude']}),";
            $worker_time .= "'" . date('Y-m-d H:i:s', $val['utcdatetime']) . "',";
            $times[] = date('H:i:s', $val['utcdatetime']);
        }
        $position = rtrim($position, ';');       //取出最后一个";"分号
        $worker_local = rtrim($worker_local, ',');
        $worker_time = rtrim($worker_time, ',');
        //根据坐标获取百度地图API的纠正坐标
        $url = "http://api.map.baidu.com/geoconv/v1/?coords=$position&from=1&to=5&ak=z3hc18DC7zkuwqEWpWsEkZAi";
        $url_response = @file_get_contents($url);           //获取纠正后的坐标信息
        $url_response = json_decode($url_response, true);    //参数为true表示为数组
        $url_responses = "";
        $Point = '';
        $arrays = [];
        $labers = [];
        foreach ($url_response['result'] as $key => $val) {
            $url_responses .= "new BMap.Point({$val['x']},{$val['y']}),";
            $Point = "new BMap.Point({$val['x']},{$val['y']}),";
            $arrays[] = "new BMap.Point({$val['x']},{$val['y']})";
            $labers[] = $val['x'] . "," . $val['y'];
        }
        $this->assign('labers', json_encode($labers));
        $this->assign("times", json_encode($times)); //显示所选工人当天全部位置对应时间
        $Point = rtrim($Point, ',');         //取出最后一个","号
        $url_responses = rtrim($url_responses, ',');         //取出最后一个","号
        $this->assign("url_responses", $url_responses);    //显示所选工人当天坐标信息
        $this->assign("worker_position", $worker_local); //显示所选工人当天全部位置信息
        $this->assign("info_worker_time", $worker_time); //显示所选工人当天全部位置对应时间
        $this->assign("count", count($info));
        $this->assign('Point', $Point);        //传入员工坐标
        if ($url_responses)
            $this->display();
        else
            $this->show("该工人(" . I('get.worker_name') . ")在" . $return_time . "无北斗GPS数据！");
    }

    /**
     * 考勤数据(界面设计)
     */
    public function worker_attend() {
        $condition = I('get.cond');
        $project_id = session('object_id'); //项目部id
        $test = 'no';
        $select_day = I("get.time", date("Y-m-d")); //提交的查询时间
        $select_time = strtotime($select_day); //将提交查询日期转换为时间戳
        //获取提交日期的起止时间戳
        $start = mktime(0, 0, 0, date("m", $select_time), date("d", $select_time), date("Y", $select_time));
        $end = mktime(23, 59, 59, date("m", $select_time), date("d", $select_time), date("Y", $select_time));
        $data['a.time'] = array('BETWEEN', array($start, $end)); //time为当日时间戳
        $data['w.project_id'] = array('eq', $project_id);
        if ($condition != '') {
            $data['_string'] = "w.name like '%{$condition}%' or w.card_number like '%{$condition}%'";
        }
        //分页类
        $count = M('Attend_data')->alias('a')
                ->join('left join __WORKER__ w on a.wrist_number = w.wrist_number')
                ->where($data)
                ->count();
        $Page = new \Think\Page($count, 10); // 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show = $Page->show(); // 分页显示输出
        //Worker和Attend_data表关联查询，通过wrist_number字段关联
        $info = M('Attend_data')->alias('a')
                ->join('left join __WORKER__ w on a.wrist_number = w.wrist_number')
                ->field('a.time,a.onchecktime,a.offchecktime,a.status,w.name,w.card_number,w.wrist_number,w.project_id')
                ->where($data)
                ->limit($Page->firstRow . ',' . $Page->listRows)
                ->select();
        //加入上下班时间
        $st = M('Project')
                ->where(array('id' => $project_id))
                ->field('ontime,offtime')
                ->find();
        foreach ($info as $key => $val) {
            //通过函数判断上下班状态
            $info[$key]['attend_status'] = worker_attend($st['ontime'], $st['offtime'], $val['onchecktime'], $val['offchecktime']);
        }
        if ($info) {
            $test = 'yes';
        }
        cookie('status', 'worker_attend');
        $this->assign("test", $test);
        $this->assign("info", $info);
        $this->assign("show", $show);
        $this->assign("day", $select_day);
        $this->display();
    }

    /**
     * 查看单月信息
     */
    public function worker_attend_month() {
        $condition = I('get.cond');
        $id = session('object_id');
        $select_day = I("get.time");
        if ($select_day != "") {
            $start = strtotime($select_day);
            $end = strtotime(date("Y-m", strtotime("+1 month", strtotime($select_day)))) - 1;
            $time = strtotime($select_day);
        } else {
            $time = NOW_TIME;
            $select_day = date('Y-m', $time);
            $start = strtotime($select_day);
            $end = strtotime(date("Y-m", strtotime("+1 month", strtotime($select_day)))) - 1;
        }
        $datetime = date("Y-m", $time);
        //分页类
        $count = M('Worker')
                ->where(array('project_id' => $id))
                ->where("`create_time` < {$end} AND (status = 1 OR (`leave_time` > {$start}))")
                ->count();
        $Page = new \Think\Page($count, 10);
        $show = $Page->show();
        //获取项目部工人信息
        if ($condition != "") {
            $sql = "SELECT `id`,`name`,`card_number`,`is_mobile_attend`,`wrist_number`,`project_id`,`create_time`,`leave_time`,`unit`,`type_id`,`blacklist`,`status` FROM `worker` WHERE `project_id` = {$id} AND (`create_time` < {$end} AND (status = 1 OR (`leave_time` > {$start}))) AND (`name` like '%{$condition}%' OR `card_number` like '%{$condition}%') order by status desc,unit LIMIT {$Page->firstRow},{$Page->listRows}";
        } else {
            $sql = "SELECT `id`,`name`,`card_number`,`is_mobile_attend`,`wrist_number`,`project_id`,`create_time`,`leave_time`,`unit`,`type_id`,`blacklist`,`status` FROM `worker` WHERE `project_id` = {$id} AND (`create_time` < {$end} AND (status = 1 OR (`leave_time` > {$start}))) order by status desc,unit LIMIT {$Page->firstRow},{$Page->listRows}";
        }
        $worker = M('Worker')->query($sql);
        //加入所属单位和工种
        $projects = [1 => "业主单位", 2 => "监理单位", 3 => "施工单位", 4 => "分包单位", 5 => "运维单位", 6 => "劳务一队", 7 => "劳务二队", 8 => "劳务三队", 9 => "劳务四队", 10 => "劳务五队"];
        $typename = M("WorkType")->getField("id,type");
        for ($i = 0; $i < count($worker); $i++) {
            $unit = $worker[$i]['unit'];
            $type = $worker[$i]['type_id'];
            $worker[$i]['unitname'] = $projects[$unit];  //加入所属单位
            $worker[$i]['typename'] = $typename[$type];  //加入所属工种
        }
        //模板显示
        cookie('status', 'worker_attend_month');
        $this->assign('worker', $worker);
        $this->assign("show", $show);
        $this->assign("time", $datetime);
        $this->display('worker_attend');
    }

    /**
     * 查看年度考勤
     */
    public function worker_attend_year() {
        $id = session('object_id');
        $start = strtotime(date('Y-01-01 00:00:00'));
        $end = NOW_TIME;
        //分页类
        $count = M('Worker')
                ->where(array('project_id' => $id))
                ->where("`create_time` < {$end} AND (status = 1 OR (`leave_time` > {$start}))")
                ->count();
        $Page = new \Think\Page($count, 10);
        $show = $Page->show();
        //获取项目部工人信息
        $sql = "SELECT `id`,`name`,`card_number`,`is_mobile_attend`,`wrist_number`,`project_id`,`create_time`,`leave_time`,`unit`,`type_id`,`blacklist`,`status` FROM `worker` WHERE `project_id` = {$id} AND (`create_time` < {$end} AND (status = 1 OR (`leave_time` > {$start}))) order by status desc,unit LIMIT {$Page->firstRow},{$Page->listRows}";
        $worker = M('Worker')->query($sql);
        //加入所属单位和工种
        $projects = [1 => "业主单位", 2 => "监理单位", 3 => "施工单位", 4 => "分包单位", 5 => "运维单位", 6 => "劳务一队", 7 => "劳务二队", 8 => "劳务三队", 9 => "劳务四队", 10 => "劳务五队"];
        $typename = M("WorkType")->getField("id,type");
        for ($i = 0; $i < count($worker); $i++) {
            $unit = $worker[$i]['unit'];
            $type = $worker[$i]['type_id'];
            $worker[$i]['unitname'] = $projects[$unit];  //加入所属单位
            $worker[$i]['typename'] = $typename[$type];  //加入所属工种
        }
        //模板显示
        cookie('status', 'worker_attend_year');
        $this->assign('worker', $worker);
        $this->assign("show", $show);
        $this->display('worker_attend');
    }

    /**
     * 工人考勤——运动量分析
     */
    public function worker_attend_activity_ajax() {
        $wrist_number = I('post.wrist_number');
        $date = I('post.date');
        $select_time = strtotime($date); //将提交查询日期转换为时间戳
        //获取提交日期的起止时间戳
        $start = mktime(0, 0, 0, date("m", $select_time), date("d", $select_time), date("Y", $select_time));
        $end = mktime(23, 59, 59, date("m", $select_time), date("d", $select_time), date("Y", $select_time));
        $data['utcDateTime'] = array('BETWEEN', array($start, $end));
        $data['deviceID'] = array('eq', $wrist_number);
        //获取当日该员工所有手环数据
        $info = M('Data_handlering')
                ->where($data)
                ->field('deltax,deltay,deltaz')
                ->select();
        //查询该员工当日运动量总个数
        $total = M('Data_handlering')
                ->where($data)
                ->field('deltax,deltay,deltaz')
                ->count();
        //运动量统计初始为空
        $activity = '0'; //运动总量
        $res = array('k1' => '0', 'k2' => '0', 'k3' => '0', 'k4' => '0');
        foreach ($info as $key => $val) {
            $info[$key]['activity'] = $val['deltax'] + $val['deltay'] + $val['deltaz'];
            $activity = $activity + $info[$key]['activity'];
            $res = worker_attend_activity($info[$key]['activity'], $res['k1'], $res['k2'], $res['k3'], $res['k4']);
        }
        $static_percent = $res['k1'] / $total * 100;
        $low_percent = $res['k2'] / $total * 100;
        $medium_percent = $res['k3'] / $total * 100;
        $high_percent = $res['k4'] / $total * 100;
        //整合:保留小数点后两位
        $static_percent = sprintf("%.2f", $static_percent);
        $low_percent = sprintf("%.2f", $low_percent);
        $medium_percent = sprintf("%.2f", $medium_percent);
        $high_percent = sprintf("%.2f", $high_percent);
        //组装返回一维数组
        $result = array('activity' => $activity, 'static_percent' => $static_percent, 'low_percent' => $low_percent, 'medium_percent' => $medium_percent, 'high_percent' => $high_percent);
        $this->ajaxreturn($result);
    }

    /**
     * 工人体征(界面展示)
     */
    public function worker_life() {
        $time = I('get.time', date("Y-m-d H:i:s"));
        $cond = I('get.cond');
        $wrist_id = I('get.wrist_number');
        $project_id = session('object_id');
        if ($time && !$cond) { //查询全部员工
            $res = $this->worker_life_select($time, $project_id); //调用查询函数
            if (!$res)
                $res = 'no'; //今日所有员工体症无异常
        }
        else if ($time && $cond) {  //查询1个员工
            $res = $this->worker_life_select_one($time, $cond, $wrist_id); //调用查询函数
            if (!$res)
                $res = 'no'; //今日该员工体症无异常
        }
        $this->assign("show", $res['k1']);
        $this->assign("info", $res['k2']);
        $this->display();
    }

    /**
     * 工程项目人员的工作状态查询(仅查询一小时内的)
     * @param int $id  员工id
     */
    public function worker_life_one($id) {
        $select_time = NOW_TIME;
        $start = $select_time - 3600;
        $end = $select_time;
        //构造查询条件
        $data['h.utcDateTime'] = array('BETWEEN', array($start, $end));
        $condition = array(
            'w.id' => $id,
        );
        $info = M('Data_handlering')->alias('h')
                ->join('left join __WORKER__ w on w.wrist_number = h.deviceID')
                ->field('w.name,w.card_number,w.wrist_number,h.id,h.temperature,h.humidity,h.deltax,h.deltay,h.deltaz,h.utcDateTime')
                ->where($condition)
                ->where($data)
                ->order('h.utcDateTime desc')
                ->select();
        // 运动量统计
        foreach ($info as $key => $val) {
            $info[$key]['utcdatetime'] = date("Y-m-d H:i:s", $val['utcdatetime']);
            $info[$key]['temperature'] = number_format($val['temperature'], 2, '.', '');
            $info[$key]['activity'] = $val['deltax'] + $val['deltay'] + $val['deltaz'];
            // 进入检测函数，对体温进行检测
            $info[$key]['temp_status'] = worker_healthy_temp($val['temperature']);
            // 进入函数检测，对运动量进行检测
            $info[$key]['activity_status'] = worker_healthy_activity($info[$key]['activity']);
        }
        echo json_encode($info);
    }

    /**
     * 工人体征(按条件查询)-查询全部工人数据（已采用正式表！）
     */
    public function worker_life_select($time, $project_ids) {
        $select_day = $time; //获取所选日期
        $select_time = strtotime($select_day); //将所选日期转化为时间戳
        //获取提交日期的起止时间戳
        $start = mktime(0, 0, 0, date("m", $select_time), date("d", $select_time), date("Y", $select_time));
        $end = mktime(23, 59, 59, date("m", $select_time), date("d", $select_time), date("Y", $select_time));
        $data['w.project_id'] = array('eq', $project_ids); //项目部id
        $data['h.utcDateTime'] = array('BETWEEN', array($start, $end)); //设置今日起至时间        //分页类
        $count = M('Data_handlering')->alias('h')
                        ->join('left join __WORKER__ w on w.wrist_number = h.deviceID')
                        ->field('w.name,w.card_number,w.project_id,w.phone_number,w.wrist_number,h.id,h.temperature,h.humidity,h.deltax,h.deltay,h.deltaz,h.utcDateTime')
                        ->where($data)->count();
        $Page = new \Think\Page($count, 10); // 实例化分页类 传入总记录数和每页显示的记录数(10)
        $show = $Page->show(); // 分页显示输出
        //开始查询
        $info = M('Data_handlering')->alias('h')
                ->join('left join __WORKER__ w on w.wrist_number = h.deviceID')
                ->field('w.name,w.card_number,w.project_id,w.phone_number,w.wrist_number,h.id,h.temperature,h.humidity,h.deltax,h.deltay,h.deltaz,h.utcDateTime')
                ->where($data) //查询条件归纳为：当前项目部下，在起止时间内，状态为1的所有数据
                ->order('h.utcDateTime desc')
                ->limit($Page->firstRow . ',' . $Page->listRows)
                ->select();
        //运动量统计
        foreach ($info as $key => $val) {
            $info[$key]['activity'] = $val['deltax'] + $val['deltay'] + $val['deltaz'];
            //进入检测函数，对体温进行检测
            $info[$key]['temp_status'] = worker_healthy_temp($val['temperature']);
            //进入函数检测，对运动量进行检测
            $info[$key]['activity_status'] = worker_healthy_activity($info[$key]['activity']);
        }
        return array("k1" => $show, "k2" => $info);
    }

    /**
     * 工人体征-按条件查询-单人数据(已采用正式表！)
     */
    public function worker_life_select_one($time, $cond, $wrist_id) {
        //根据姓名找该成员手环编号
        if (!$wrist_id) {
            $condition = array(
                'name' => array('like', '%' . $cond . '%'),
                'wrist_number' => array('like', '%' . $cond . '%'),
                '_logic' => 'OR',
            );
            $wrist_number = M('Worker')->where($condition)->getField('wrist_number');
        } else {
            $wrist_number = $wrist_id;  //重名情况，二次提交选择的员工直接得到手环编号
        }
        //接收前台提交日期
        $select_day = $time;
        $select_time = strtotime($select_day); //将所选日期转化为时间戳
        //获取起止时间戳
        $start = mktime(0, 0, 0, date("m", $select_time), date("d", $select_time), date("Y", $select_time));
        $end = mktime(23, 59, 59, date("m", $select_time), date("d", $select_time), date("Y", $select_time));
        //构造查询条件
        $data['h.deviceID'] = array('eq', $wrist_number);
        $data['h.utcDateTime'] = array('BETWEEN', array($start, $end)); //设置今日时间区间
        //分页类
        $count = M('Data_handlering')->alias('h')
                ->join('left join __WORKER__ w on w.wrist_number = h.deviceID')
                ->field('w.name,w.card_number,w.wrist_number,h.id,h.temperature,h.humidity,h.deltax,h.deltay,h.deltaz,h.utcDateTime')
                ->where($data)
                ->count();
        $Page = new \Think\Page($count, 10); // 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show = $Page->show(); // 分页显示输出
        //开始查询
        $info = M('Data_handlering')->alias('h')
                ->join('left join __WORKER__ w on w.wrist_number = h.deviceID')
                ->field('w.name,w.card_number,w.wrist_number,h.id,h.temperature,h.humidity,h.deltax,h.deltay,h.deltaz,h.utcDateTime')
                ->where($data)
                ->limit($Page->firstRow . ',' . $Page->listRows)
                ->select();
        //添加运动量信息
        foreach ($info as $key => $val) {
            $info[$key]['activity'] = $val['deltax'] + $val['deltay'] + $val['deltaz'];
            //进入检测函数，对体温进行检测
            $info[$key]['temp_status'] = worker_healthy_temp($val['temperature']);
            //进入函数检测，对运动量进行检测
            $info[$key]['activity_status'] = worker_healthy_activity($info[$key]['activity']);
        }
        return array("k1" => $show, "k2" => $info);
    }

    /**
     * 工人体征（Ajax判断查询人是否存在）
     */
    public function check_worker_life_name_only() {
        $name = I("post.name");
        $data = M("Worker")->where(array('name' => $name))->field('id,wrist_number,name,card_number')->select();
        if ($data) {
            if (count($data) == 1) {
                echo 'one';  //该名称只有一个员工
            } else {
                echo JSON($data); //该名称有不止一个员工,且返回的二维数组
            }
        } else { //没有该员工
            echo 'none';
        }
    }

    /**
     * 工人体征（Ajax回填个人数据）
     */
    public function worker_life_detail() {
        $data_id = decode(I("post.id")); //获取手环数据id
        $info = M('Data_handlering')->find($data_id);
        $info['temperature'] = number_format($info['temperature'], 2, '.', '');
        $info['humidity'] = number_format($info['humidity'], 2, '.', '');
        $info['batterylevel'] = number_format($info['batterylevel'], 4, '.', '');
        if ($info) {
            //电量转换
            $info['batterylevel'] = $info['batterylevel'] * 100;
            $this->ajaxReturn($info);
        } else {
            echo false;
        }
    }

    /**
     * 工人体征(统计图分析)
     */
    public function worker_life_graph() {
        $wrist_number = I("get.wrist_number");  //员工手环编号--唯一标识
        $worker_name = I("get.worker_name"); //获取员工姓名
        $time = I("get.time", date("Y-m-d H:i:s"));    //获取提交查询时间
        $time_str = strtotime($time);  //将提交时间转化为时间戳
        //获取所选日期当天的舒适和末尾时间戳		
        $start = mktime(0, 0, 0, date("m", $time_str), date("d", $time_str), date("Y", $time_str));
        $end = mktime(23, 59, 59, date("m", $time_str), date("d", $time_str), date("Y", $time_str));
        $data['utcDateTime'] = array('BETWEEN', array($start, $end)); //显示当天范围内数据
        $data['deviceID'] = array('eq', $wrist_number); //工人手环编号作为唯一标示
        $info = M('DataHandlering')
                ->where($data)
                ->field('utcdatetime,temperature,deltax,deltay,deltaz,humidity,batterylevel')
                ->order('utcdatetime')
                ->select(); //查询出该员工当天所有体征数据，以二维数组形式显示
        $worker_time_combine = ''; //初始拼接工人时间空
        $worker_temp_combine = ''; //初始拼接工人体温空
        $worker_sport_combine = ''; //初始拼接工人运动量空
        $wrist_battery_combine = ''; //初始拼接工人电池电量空
        foreach ($info as $key => $val) {
            $val_change['time'] = date("H:i:s", $val['utcdatetime']); //将每一个时间戳转化为标准格式
            $worker_time_combine .= $val_change['time'] . ','; //将标准格式的时间连接起来
            $worker_temp_combine .= $val['temperature'] . ',';
            //远动量拼接
            $info[$key]['activity'] = $val['deltax'] + $val['deltay'] + $val['deltaz'];
            $worker_sport_combine .= $info[$key]['activity'] . ',';
            $worker_humidity_combine .= $val['humidity'] . ',';
            //电池电量拼接
            $wrist_battery_combine .= $val['batterylevel'] * '100' . ',';
        }
        $worker_time = rtrim($worker_time_combine, ',');   //删除最后一个逗号
        $worker_time = str_replace(',', "','", $worker_time); //将原" , "改为"  ','  "
        $worker_temp = rtrim($worker_temp_combine, ',');
        $worker_sport = rtrim($worker_sport_combine, ',');
        $worker_humidity = rtrim($worker_humidity_combine, ',');
        $wrist_battery = rtrim($wrist_battery_combine, ',');
        //var_dump($worker_temp);die;
        $this->assign("time", $time); //前台显示提交日期
        $this->assign("worker_name", $worker_name); //前台显示员工姓名
        $this->assign("worker_time", $worker_time); //显示该员工一天所有时间数据
        $this->assign("worker_temp", $worker_temp); //显示该员工一天所有体温数据
        $this->assign("worker_sport", $worker_sport); //显示该员工一天所有运动量数据
        $this->assign("worker_humidity", $worker_humidity); //显示该员工一天所有运动量数据
        $this->assign("wrist_battery", $wrist_battery); //显示该员工一天所电池电量
        $this->display();
    }

    /**
     * 项目进度列表展示
     */
    public function project_schedule() {
        $id = session('project_id');
        $test = 'no';
        $select_day = I("get.time", date("Y-m-d H:i:s"));
        $time_str = strtotime($select_day);
        //获取提交日期的起止时间戳
        $start = mktime(0, 0, 0, date("m", $time_str), date("d", $time_str), date("Y", $time_str));
        $end = mktime(23, 59, 59, date("m", $time_str), date("d", $time_str), date("Y", $time_str));
        //查询条件
        $data['time'] = array('BETWEEN', array($start, $end));
        $data['project_id'] = array('eq', $id);
        //分页类
        $count = M('ProjectSchedule')
                ->where($data)
                ->count();
        $Page = new \Think\Page($count, 10);
        $show = $Page->show();
        //关联查询
        $info = M('ProjectSchedule')
                ->field('id,username,title,time,meeting,detail,weather,temperature')
                ->where($data)
                ->limit($Page->firstRow . ',' . $Page->listRows)
                ->select();
        $this->assign("schedule", $info);
        $this->assign("show", $show);
        $this->display();
    }

    /**
     * 项目进度详情展示
     */
    public function project_schedule_detail() {
        $project_schedule_id = I("post.id");
        $data = M('ProjectSchedule')->alias('s')
                ->join('left join project_info pro on s.project_id = pro.id')
                ->field('pro.name,s.id,s.username,s.title,s.meeting,s.detail,s.weather,s.temperature,s.image,s.rate')
                ->where(array('s.id' => $project_schedule_id))
                ->find();
        if ($data) {
            $this->ajaxReturn($data);
        }
    }

    /**
     * Ajax查看现有工人种类
     */
    public function work_type_select() {
        $info['auth'] = array('eq', 'company');
        $project_id = session('project_id');
        $company_id = M('Project')->where(array('id' => $project_id))->getField('company_id');
        $info['auth_id'] = array('eq', $company_id);
        $info['_logic'] = 'AND';
        $next[0] = $info;
        $next[1] = array('auth' => 'group');
        $next['_logic'] = 'OR';
        $data = M('work_type')
                ->where($next)
                ->select();
        $this->ajaxReturn($data);
    }

    //查询自己项目部下所有工人异常信息
    public function wrist_warning() {
        $id = session('project_id');
        $select_day = I("get.time", date("Y-m-d H:i:s"));
        $select_time = strtotime($select_day);
        $start = mktime(0, 0, 0, date("m", $select_time), date("d", $select_time), date("Y", $select_time));
        $end = mktime(23, 59, 59, date("m", $select_time), date("d", $select_time), date("Y", $select_time));
        $data['wi.utcDateTime'] = array('BETWEEN', array($start, $end));
        $data['wi.type'] = array('in', 'sos,normal');
        $data['pro.id'] = array('eq', $id);
        //分页类
        $count = M('WarningInfo')->alias('wi')
                ->join('left join worker_info w on w.wrist_number = wi.wrist_number')
                ->join('left join project_info pro on pro.id = w.project_id')
                ->where($data)
                ->count();
        $Page = new \Think\Page($count, 10);
        $show = $Page->show();
        $info = M('WarningInfo')->alias('wi')
                ->join('left join worker_info w on w.wrist_number = wi.wrist_number')
                ->join('left join project_info pro on pro.id = w.project_id')
                ->where($data)
                ->field('wi.id,wi.wrist_number as wrist,wi.type,wi.utcdatetime,pro.id as pro_id,pro.name as pro_name,w.name,w.phone_number,w.emergency_people,w.emergency_phone,pro.construction_name as con_name,pro.construction_phone as con_phone,wi.longitude,wi.latitude')
                ->limit($Page->firstRow . ',' . $Page->listRows)
                ->order('utcdatetime desc')
                ->select();
        $this->assign("show", $show);
        $this->assign("data_info", $info);
        $this->display();
    }

    /**
     * 告警信息
     */
    public function wrist_warning_map() {
        $auth_id = I('get.projet_id');                             //获取告警项目部ID
        $utcdatetime = I('get.utcdatetime');                    //获取告警时间
        $deviceid = I('get.deviceid');                          //获取告警设备ID
        $longitude = I('get.longitude');
        $latitude = I('get.latitude');
        //获取项目部位置
        $ps = M('ProjectInfo')
                ->field('name,position,radius,posname,coordinate,paintingradius,paintingname,type')
                ->where(array('id' => $auth_id))
                ->find();
        $array = explode(';', $ps['coordinate']);
        $count = count($array);
        if (!empty($ps['position'])) {
            $ps['coordinate'].=";" . $ps['position'];
            $ps['paintingradius'].=";" . $ps['radius'];
            $ps['paintingname'].=";" . $ps['posname'];
        }
        //获取中心点坐标：横纵坐标的平均值
        $jd = '';
        $wd = '';
        for ($i = 0; $i < $count; $i++) {
            $jd += explode(',', $array[$i])['0'];
            $wd += explode(',', $array[$i])['1'];
        }
        if ($ps['type'] == 1) {
            $position_t = "";
            for ($s = 0; $s < $count; $s++) {
                $position_t.= " new BMap.Point($array[$s]),";
            }
            $positions = rtrim($position_t, ",");  //删除字符串右侧空格
            $this->assign('positions', $positions);
            $this->assign('namea', json_encode(explode(';', $ps["name"])));      //转换成json数据
            $this->assign('data', json_encode(explode(';', $ps["coordinate"])));      //转换成json数据
            $this->assign('radius', json_encode(explode(';', $ps["paintingradius"])));      //转换成json数据
            $this->assign('paintingnames', json_encode(explode(';', $ps["paintingname"])));      //转换成json数据
            $this->assign('type', 1);
        } else {
            $this->assign('data', "1");
            $position_t = "";
            for ($i = 0; $i < $count; $i++) {
                $position_t.= " new BMap.Point($array[$i]),";
            }
            $position = rtrim($position_t, ",");  //删除字符串右侧空格
            $this->assign("project_position", $position);  //显示项目部位置信息
            $this->assign('type', $ps['type']);
        }
        //获取告警员工信息
        $worker = M('WorkerInfo')
                ->where(['wrist_number' => $deviceid])
                ->field('name,phone_number,emergency_people,emergency_phone')
                ->select();

        $worker_str = "告警人姓名:" . $worker[0]['name'] . "    电话:" . $worker[0]['phone_number']
                . "<br />紧急联系人:" . $worker[0]['emergency_people'] . "    电话:" . $worker[0]['emergency_phone'];
        //获取项目部上级信息
        $auth_obj = M('ProjectInfo')
                ->where(['id' => $auth_id])
                ->field('proprietor_name,proprietor_phone,supervision_name,supervision_phone,construction_name,construction_phone')
                ->select();
        $auth_str = "<br />";
        for ($i = 0; $i < count($auth_obj); $i++) {
            $auth_str.="业主联系人:" . $auth_obj[$i]['proprietor_name'] . " 电话:" . $auth_obj[$i]['proprietor_phone'] . "<br />监理联系人:" . $auth_obj[$i]['supervision_name'] . " 电话:" . $auth_obj[$i]['supervision_phone'] . "<br />施工联系人:" . $auth_obj[$i]['construction_name'] . " 电话:" . $auth_obj[$i]['construction_phone'] . "<br />";
        }
//        dump($auth_str);exit;

        $zuobiao = "{$longitude},{$latitude}";     //取出坐标点,拼接成API需要的格式
        $url = "http://api.map.baidu.com/geoconv/v1/?coords=$zuobiao&from=1&to=5&ak=z3hc18DC7zkuwqEWpWsEkZAi";
        $url_response = @file_get_contents($url);           //获取纠正后的坐标信息
        $url_response = json_decode($url_response, true);    //参数为true表示为数组
        $points = "new BMap.Point(" . $url_response['result'][0]['x'] . "," . $url_response['result'][0]['y'] . ")"; //中心点
        $str = $worker_str . $auth_str;       //告警信息提示
//        dump($str);exit;
        if ($longitude == "0.0000000") {
            echo "该告警点无坐标信息!<br /><br />" . $str;
            exit;
        }
//        $this->assign('point', $point);
        $this->assign('poinst', $points);
        $this->assign('str', $str);
        $this->display();
    }

    /**
     * 处理告警信息
     */
    public function wrist_warning_deal_with() {
        $wrist_number = I("post.worker_wrist_number");
        $utcdatetime = I("post.warning_time");
        $cause = I('post.cause');
        $save['type'] = 'normal';
        $save['cause'] = $cause;
        $save['deal_time'] = NOW_TIME;
        if (M('WarningInfo')->where(array('wrist_number' => $wrist_number))->save($save)) {
            if (M('DataHandlering')->where("deviceID = '{$wrist_number}' and utcDateTime = '{$utcdatetime}'")->save($save)) {
                echo "<script>parent.layer.msg('处理成功'); setTimeout(function(){
                                parent.location.reload();
                                },1000);</script>";
            } else {
                echo "<script>parent.layer.msg('处理失败，请重新处理！'); setTimeout(function(){
                                parent.location.reload();
                                },1000);</script>";
            }
        } else {
            echo "<script>parent.layer.msg('处理失败，请重新处理！'); setTimeout(function(){
                                parent.location.reload();
                                },1000);</script>";
        }
    }

    /**
     * 员工总览
     */
    public function project_overview() {
        $danwei = [];
        $laowuNum = 0;
        $shidao = [];
        $laowuShi = [];
        $time = strtotime(date('Y-m-d', strtotime('0 day')));
//        //1,在session中获取项目部id
        $project_id = session('project_id');
//        //2,根据项目部id在worker表中查询出该项目部所有的手环编号
        $wrist_numbers = M("WorkerInfo")->field("wrist_number")->where(array('id' => $project_id))->select();
//        //3,根据worker的手环编号等于data_handlering的手环编号查询出(最新)的经纬度
        $date = date('Y-m-d');
//        //根据项目部的id查询到该项目部的上下班时间(onTime offTime)
        $ontime = M('ProjectInfo')->where(array('id' => $project_id))->field('am_onTime')->select();
        $offtime = M('ProjectInfo')->where(array('id' => $project_id))->field('pm_offTime')->select();
//        //查询项目部坐标
        $ps = M('ProjectInfo')
                ->field('name,position,radius,posname,coordinate,paintingradius,paintingname,type')
                ->where(array('id' => $project_id))
                ->find();
        $this->assign('project_name', $ps['name']);
        if ($ps['position'] == "") {
            $ps['position'] = $ps['coordinate'];
        } else {
            $ps['position'].=";" . $ps['coordinate'];
        }
        if ($ps['radius'] == "") {
            $ps['radius'] = $ps['paintingradius'];
        } else {
            $ps['radius'].=";" . $ps['paintingradius'];
        }
        if ($ps['posname'] == "") {
            $ps['posname'] = $ps['paintingname'];
        } else {
            $ps['posname'].=";" . $ps['paintingname'];
        }

        $ps['posname'].=";" . $ps['paintingname'];
        $coords = $ps['coordinate'];
        cookie('project_name', $ps['name']);
        $array = explode(';', $coords);
        for ($l = 0; $l < count($array); $l++) {
            if ($array[$l] != "") {
                $polylines.="new BMap.Point(" . $array[$l] . "),";
            }
        }
        //统计单位应到
        $woker_arr = M('WorkerInfo')->where(array('project_id' => $project_id))->field('name,wrist_number,type_id,unit_id')->select();
        for ($p = 0; $p < count($woker_arr); $p++) {
            //统计应到人数
            if ($woker_arr[$p]['unit_id'] == 1) {
                $danwei['yezhu'] ++;
            } else if ($woker_arr[$p]['unit_id'] == 2) {
                $danwei['jianli'] ++;
            } else if ($woker_arr[$p]['unit_id'] == 3) {
                $danwei['shigong'] ++;
            } else if ($woker_arr[$p]['unit_id'] == 4) {
                $danwei['fenbao'] ++;
            } else {
                $danwei['laowu'] ++;
            }
            //统计应到劳务各职位人数
            $laowu[$woker_arr[$p]['type_id']] ++;
            if ($woker_arr[$p]['type_id'] > 1 && $woker_arr[$p]['type_id'] < 21) {
                $laowuNum++;
            }
            //统计实到
            $woker_posin = M('DataHandlering')->where("utcDateTime>'{$time}' and deviceID='{$woker_arr[$p]['wrist_number']}'")->field('longitude,latitude')->order('utcDateTime')->limit('1')->select();
            if (!empty($woker_posin)) {
                if ($woker_arr[$p]['unit_id'] == 1) {
                    $shidao['yezhu'] ++;
                } else if ($woker_arr[$p]['unit_id'] == 2) {
                    $shidao['jianli'] ++;
                } else if ($woker_arr[$p]['unit_id'] == 3) {
                    $shidao['shigong'] ++;
                } else if ($woker_arr[$p]['unit_id'] == 4) {
                    $shidao['fenbao'] ++;
                } else {
                    $shidao['laowu'] ++;
                }
                if ($woker_arr[$p]['type_id'] > 1 && $woker_arr[$p]['type_id'] < 21) {
                    $laowuShi[$woker_arr[$p]['type_id']] ++;
                    $laowuShi['laodan'] ++;
                }
            }
        }
//                dump($laowuNum);exit;
        $this->assign('danwei', $danwei);
        $this->assign('shidao', $shidao);
        $this->assign('laowuShi', $laowuShi);
        $this->assign('laowuNum', $laowuNum);
        $this->assign('laowu', $laowu);
        //线段
        $this->assign('project_name', json_encode($ps['name']));
        $this->assign('polyline', $polylines);
        $count = count($array);
        $this->assign('positions', json_encode(explode(';', $ps["position"])));      //转换成json数据
        $this->assign('radius', json_encode(explode(';', $ps["radius"])));      //转换成json数据
        $this->assign('posName', json_encode(explode(';', $ps["posname"])));      //转换成json数据
        $this->assign('type', $ps['type']);
        $this->assign('pro_id', json_encode($project_id));

        //将取出的时间拆分
        $on = explode(":", $ontime[0]["am_ontime"]);
        $off = explode(":", $offtime[0]["pm_offtime"]);


        //转换成时间戳
        $strto_time = strtotime($date);
        $start = mktime($on[0], $on[1], 0, date("m", $strto_time), date("d", $strto_time), date("Y", $strto_time));
        $end = mktime($off[0], $off[1], 59, date("m", $strto_time), date("d", $strto_time), date("Y", $strto_time));
        $sql = "select c.* from (SELECT da.id,da.type as da_type,da.longitude,da.latitude,da.deviceID,w.wrist_number,w.name,wtp.type FROM data_handlering da left join worker_info w on w.wrist_number = da.deviceID left join project_info pro on pro.id = w.project_id left join work_type wtp on wtp.id = w.type_id WHERE da.utcDateTime BETWEEN $start AND $end AND w.project_id = $project_id ORDER BY da.utcDateTime desc) as c group by c.deviceID";
        $info = M('DataHandlering')->query($sql);

        $str = "";
        foreach ($info as $k => $v) {
            $str .= "{$v['longitude']},{$v['latitude']};";
        }
        $str = rtrim($str, ';');     //去除最后一个';'号
        //坐标转换
        $url = "http://api.map.baidu.com/geoconv/v1/?coords=$str&from=1&to=5&ak=z3hc18DC7zkuwqEWpWsEkZAi";
        $url_str = @file_get_contents($url);        //获取页面url的数据
        $url_str = json_decode($url_str, true);      //解析json
        $str_result = "";
        foreach ($url_str["result"] as $k => $v) {
            $str_result .= $v["x"] . ',' . $v["y"] . ';';
        }
        $data = array();
        foreach ($info as $k => $v) {
            $data[] = array(
                'title' => '工人最新数据',
                'worker_name' => $v["name"],
                'equipment_number' => $v['deviceid'],
                'point' => explode(';', $str_result)[$k],
                'worker_type' => $v["type"],
                'time' => substr($v['da_type'], 4),
            );
        }
        $this->assign('project_id', $project_id);
        $this->assign('data', json_encode($data));
        $this->display();
    }

    public function getListParentId() {
        $parent_id = I('get.parent_id');
        $data = M('WorkType')->where(array('company' => $parent_id))->select();
        $this->ajaxReturn($data);
    }

    /**
     * 员工离开区域查询
     */
    public function worker_leave() {
        $id = session('project_id');
        $select_day = I("get.time", date("Y-m-d H:i:s")); //提交的查询时间
        $select_time = strtotime($select_day);
        $start = mktime(0, 0, 0, date("m", $select_time), date("d", $select_time), date("Y", $select_time));
        $start = date('Y-m-d H:i:s', $start);
        $end = mktime(23, 59, 59, date("m", $select_time), date("d", $select_time), date("Y", $select_time));
        $end = date('Y-m-d H:i:s', $end);
        $data['outtime'] = array('BETWEEN', array($start, $end));
        $data['project_id'] = array('eq', $id);
        $count = M('WorkerLeave')
                ->join('left join `work_type` wt on wt.id = work_type_id')
                ->where($data)
                ->where('status=0')
                ->count();
        $Page = new \Think\Page($count, 10);
        $show = $Page->show();
        $info = M('WorkerLeave')
                ->join('left join `work_type` wt on wt.id = work_type_id')
                ->where($data)
                ->where('status=0')
                ->limit($Page->firstRow . ',' . $Page->listRows)
                ->order('outtime desc')
                ->select();
        $this->assign("show", $show);
        $this->assign("data_info", $info);
        $this->display();
    }

    /**
     * 取消区域异常
     * @param type $id
     */
    public function cancel_leave($id) {
        $data = array(
            'status' => 1,
        );
        if (M('WorkerLeave')->where(array('id' => $id))->save($data)) {
            $this->success("取消成功");
        } else {
            $this->error("取消失败");
        }
    }

    public function warning_time() {
        $id = session('project_id');
        $select_day = date('Y-m-d H:i:s', time());
        $select_time = strtotime($select_day);
        $start = mktime(0, 0, 0, date("m", $select_time), date("d", $select_time), date("Y", $select_time));
        $end = mktime(23, 59, 59, date("m", $select_time), date("d", $select_time), date("Y", $select_time));
        $data['wi.utcDateTime'] = array('BETWEEN', array($start, $end));
        $data['wi.type'] = array('eq', 'sos');
        $data['pro.id'] = array('eq', $id);
        $info = M('WarningInfo')->alias('wi')
                ->join('left join worker_info w on w.wrist_number = wi.wrist_number')
                ->join('left join project_info pro on pro.id = w.project_id')
                ->where($data)
                ->select();
        if ($info) {
            $this->ajaxReturn('warning');
        }
    }

    /**
     * 查看告警处理结果
     */
    public function deal_result() {
        $id = I("post.id");
        $info = M('WarningInfo')->where(array('id' => $id))->find();
        $info['utcdatetime'] = date('Y-m-d H:i:s', $info['utcdatetime']);
        $info['deal_time'] = date('Y-m-d H:i:s', $info['deal_time']);
        $this->ajaxReturn($info);
    }

    /**
     * 查看当日设备考勤
     */
    public function device_attend() {
        //关键字
        $condition = I('post.cond');
        if ($condition != '') {
            $data['_string'] = "name like '%{$condition}%' or card_number like '%{$condition}%'";
        }
        //获取项目id
        $project_id = session('project_id');
        $select_day = I("post.time", date("Y-m-d"));
        $data['date'] = array('eq', $select_day);
        $data['project_id'] = $project_id;
        $count = M("DeviceAttend")->where($data)->count();
        $Page = new \Think\Page($count, 10);
        $show = $Page->show();
        $info = M("DeviceAttend")->where($data)->limit("$Page->firstRow,$Page->listRows")->select();
        $this->assign('attend', 'attend_day');      //给页面说明这是查看当天
        $this->assign('day', $select_day);          //回显搜索的日期
        $this->assign('info', $info);               //参数信息
        $this->assign('show', $show);                //分页
        $this->display();
    }

    /**
     * 设备查看当月设备考勤
     */
    public function device_attend_month() {
        //获取项目id
        $project_id = session('project_id');
        $condition = I('post.cond');     //关键字
        $select_day = I("post.time", date("Y-m"));    //搜索时间
        if ($condition != '') {
            $data['_string'] = "name like '%{$condition}%' or card_number like '%{$condition}%'";
        }
        //算出选中的月初和月末
        if ($select_day != "") {
            $month_start = strtotime($select_day);
            $month_end = strtotime(date("Y-m", strtotime("+1 month", strtotime($select_day)))) - 1;
            $time = strtotime($select_day);
        } else {
            $time = NOW_TIME;
            $select_day = date('Y-m', $time);
            $month_start = strtotime($select_day);
            $month_end = strtotime(date("Y-m", strtotime("+1 month", strtotime($select_day)))) - 1;
        }
        //返回时间
        $datetime = date("Y-m", $time);
        //UTCtime在月初和月末之间
        $data['utcDateTime'] = array('between', array($month_start, $month_end));
        $data['project_id'] = $project_id;
        //分页
        $count = M("DeviceAttend")->where($data)->count();
        $Page = new \Think\Page($count, 10);
        $show = $Page->show();
        $info = M('DeviceAttend')->where($data)->limit("$Page->firstRow,$Page->listRows")->select();

        $this->assign('info', $info);                   //回显级别信息
        $this->assign('attend', 'attend_month');        //说明这是月份考勤
        $this->assign('time', $datetime);               //回显搜索的日期
        $this->assign('show', $show);                   //分页
        $this->display('device_attend');                //视图展示
    }

    /**
     * 设备查看年度设备考勤
     */
    public function device_attend_year() {
        //获取项目id
        $project_id = session('project_id');
        $condition = I('post.cond');
        if ($condition != '') {
            $data['_string'] = "name like '%{$condition}%' or card_number like '%{$condition}%'";
        }
        //计算出年初年末
        $start = strtotime(date('Y-01-01 00:00:00'));
        $end = NOW_TIME;
        $data['utcDateTime'] = array('between', array($start, $end));
        $data['project_id'] = $project_id;
        //分页
        $count = M("DeviceAttend")->where($data)->count();
        $Page = new \Think\Page($count, 10);
        $show = $Page->show();
        $info = M('DeviceAttend')->where($data)->limit("$Page->firstRow,$Page->listRows")->select();
        $this->assign('info', $info);               //显示基本信息
        $this->assign('attend', 'attend_year');     //告知页面是年考勤
        $this->assign('show', $show);               //分页
        $this->display('device_attend');
    }

    /**
     * 查看离职评价
     */
    public function judge_view() {
        $id = I('post.id');
        $info = M('WorkerInfo')->where(array('id' => $id))->field('leave_amount,leave_info')->find();
        $this->ajaxReturn($info);
    }

//    /**
//     * 天气和环境温度
//     */
//    public function weather() {
//        $id = session('project_id');
//        $select_day = I("get.time", date("Y-m-d H:i:s"));
//        $time_str = strtotime($select_day);
//        $start = mktime(0, 0, 0, date("m", $time_str), date("d", $time_str), date("Y", $time_str));
//        $end = mktime(23, 59, 59, date("m", $time_str), date("d", $time_str), date("Y", $time_str));
//        $data['time'] = array('BETWEEN', array($start, $end));
//        $count = M('ProjectSchedule')
//                ->where(array('project_id' => $id))
//                ->where($data)
//                ->count();
//        $Page = new \Think\Page($count, 10);
//        $show = $Page->show();
//        $info = M('ProjectSchedule')
//                ->where(array('project_id' => $id))
//                ->where($data)
//                ->field('time,weather,temperature')
//                ->limit("$Page->firstRow,$Page->listRows")
//                ->select();
//        $this->assign('info', $info);
//        $this->assign("show", $show);
//        $this->display();
//    }

    /**
     * 现场人员黑名单添加
     */
    public function add_worker_black_list() {
        $card_number = I("post.card_number");
        $data['unique_id'] = $card_number;
        $data['name'] = I("post.name");
        $data['auth'] = 'worker';
        $data['project_id'] = session('project_id');
        $data['create_time'] = NOW_TIME;
        $data['defriend_reason'] = I("post.reason");
        $data['verify_status'] = '110';
        if (M('BlackList')->add($data)) {
            if (M('WorkerInfo')->where(array('card_number' => $card_number))->save(array('blacklist' => 2))) {
                echo "<script>alert('添加成功，请等待审核');location.replace(document.referrer);</script>";
            } else {
                echo "<script>alert('添加失败，请稍后重新添加');location.replace(document.referrer);</script>";
            }
        } else {
            echo "<script>alert('添加失败，请稍后重新添加');location.replace(document.referrer);</script>";
        }
    }

    /**
     * 管理人员黑名单添加
     */
    public function add_manage_black_list() {
        $card_number = I("post.card_number");
        $data['unique_id'] = $card_number;
        $data['name'] = I("post.name");
        $data['auth'] = 'manager';
        $data['project_id'] = session('project_id');
        $data['create_time'] = NOW_TIME;
        $data['defriend_reason'] = I("post.reason");
        $data['verify_status'] = '110';
        if (M('BlackList')->add($data)) {
            if (M('WorkerInfo')->where(array('card_number' => $card_number))->save(array('blacklist' => 2))) {
                echo "<script>alert('添加成功，请等待审核');location.replace(document.referrer);</script>";
            } else {
                echo "<script>alert('添加失败，请稍后重新添加');location.replace(document.referrer);</script>";
            }
        } else {
            echo "<script>alert('添加失败，请稍后重新添加');location.replace(document.referrer);</script>";
        }
    }

    /**
     * 设备考勤Excel打印
     */
    public function device_excel() {
        // 获取数据
        $project_id = session('object_id');
        //通过id找到该项目所有的设备
        $select_day = I("get.time", date("Y-m-d"));
        $data['date'] = array('eq', $select_day);
        $data['project_id'] = $project_id;
        $info = M("Device_attend_day")->where($data)->select();
        foreach ($info as $key => $val) {
            //通过函数判断上下班状态
            if ($info[$key]['ad_status'] == '0') {
                $info[$key]['ad_status'] = '正常';
            } elseif ($info[$key]['ad_status'] == '1') {
                $info[$key]['ad_status'] = '迟到';
            } elseif ($info[$key]['ad_status'] == '2') {
                $info[$key]['ad_status'] = '早退';
            } elseif ($info[$key]['ad_status'] == '3') {
                $info[$key]['ad_status'] = '迟到且早退';
            } elseif ($info[$key]['ad_status'] == '4') {
                $info[$key]['ad_status'] = '异常';
            } else {
                $info[$key]['ad_status'] = '旷工';
            }
        }
        Vendor('PHPExcel.PHPExcel');
        $excel = new \PHPExcel();
        $letter = array('A', 'B', 'C', 'D', 'E', 'F', 'G');
        $tableheader = array('序号', '姓名', '身份证号', '日期', '上班时间', '下班时间', '考勤状态');
        for ($i = 0; $i < count($tableheader); $i++) {
            $excel->getActiveSheet()->setCellValue("$letter[$i]1", "$tableheader[$i]");
        }

        $data = array();
        foreach ($info as $key => $value) {
            $data[$key][1] = $key + 1;
            $data[$key][2] = $value['name'];
            $data[$key][3] = $value['card_number'];
            $data[$key][4] = $value['date'];
            $data[$key][5] = $value['worker_amtime'];
            $data[$key][6] = $value['worker_pmtime'];
            $data[$key][7] = $value['ad_status'];
        }
        //填充表格信息
        for ($i = 2; $i <= count($data) + 1; $i++) {
            $j = 0;
            foreach ($data[$i - 2] as $key => $value) {
                $excel->getActiveSheet()->setCellValue("$letter[$j]$i", "$value");
                $j++;
            }
        }
        $content = "下载了项目id为" . session('object_id') . "的" . session('project_name') . "的设备考勤表";
        hot_value($content);
        //创建Excel输入对象
        $write = new \PHPExcel_Writer_Excel5($excel);
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");
        header('Content-Disposition:attachment;filename="' . $select_day . '设备考勤.xls"');
        header("Content-Transfer-Encoding:binary");
        $write->save('php://output');
    }

    /**
     * 打卡机考勤Excel
     */
    public function attend_excel() {
        // 获取数据
        $project_id = session('object_id');
        $select_day = I("get.time");
        $select_time = strtotime($select_day);
        //获取提交日期的起止时间戳
        $start = mktime(0, 0, 0, date("m", $select_time), date("d", $select_time), date("Y", $select_time));
        $end = mktime(23, 59, 59, date("m", $select_time), date("d", $select_time), date("Y", $select_time));
        $data['a.time'] = array('BETWEEN', array($start, $end));
        $data['w.project_id'] = array('eq', $project_id);
        $info = M('AttendData')->alias('a')
                ->join('left join __WORKER__ w on a.wrist_number = w.wrist_number')
                ->field('a.time,a.onchecktime,a.offchecktime,a.status,w.name,w.card_number,w.wrist_number,w.project_id')
                ->where($data)
                ->select();
        //加入上下班时间
        $st = M('Project')
                ->where(array('id' => $project_id))
                ->field('ontime,offtime')
                ->find();
        foreach ($info as $key => $val) {
            //通过函数判断上下班状态
            $info[$key]['attend_status'] = worker_attend($st['ontime'], $st['offtime'], $val['onchecktime'], $val['offchecktime']);
            if ($info[$key]['attend_status'] == '0') {
                $info[$key]['attend_status'] = '旷工';
            } elseif ($info[$key]['attend_status'] == '1') {
                $info[$key]['attend_status'] = '异常';
            } elseif ($info[$key]['attend_status'] == '2') {
                $info[$key]['attend_status'] = '正常';
            } else {
                $info[$key]['attend_status'] = '迟到/早退';
            }
        }
        Vendor('PHPExcel.PHPExcel');
        $excel = new \PHPExcel();
        $letter = array('A', 'B', 'C', 'D', 'E', 'F', 'G');
        $tableheader = array('序号', '姓名', '身份证号', '日期', '上班时间', '下班时间', '考勤状态');
        for ($i = 0; $i < count($tableheader); $i++) {
            $excel->getActiveSheet()->setCellValue("$letter[$i]1", "$tableheader[$i]");
        }
        $data = array();
        foreach ($info as $key => $value) {
            $data[$key][1] = $key + 1;
            $data[$key][2] = $value['name'];
            $data[$key][3] = $value['card_number'];
            $data[$key][4] = date('Y-m-d', $value['time']);
            $data[$key][5] = $value['onchecktime'];
            $data[$key][6] = $value['offchecktime'];
            $data[$key][7] = $value['attend_status'];
        }
        //填充表格信息
        for ($i = 2; $i <= count($data) + 1; $i++) {
            $j = 0;
            foreach ($data[$i - 2] as $key => $value) {
                $excel->getActiveSheet()->setCellValue("$letter[$j]$i", "$value");
                $j++;
            }
        }
        $content = "下载了项目id为" . session('object_id') . "的" . session('project_name') . "的打卡机考勤表";
        hot_value($content);
        //创建Excel输入对象
        $write = new \PHPExcel_Writer_Excel5($excel);
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");
        header('Content-Disposition:attachment;filename="' . $select_day . '打卡考勤.xls"');
        header("Content-Transfer-Encoding:binary");
        $write->save('php://output');
    }

    /**
     * 显示设置选项
     */
    public function setting() {
        $id = session('project_id');
        $info = M('ProjectInfo')->where(array('id' => $id))->find();
        $this->assign("info", $info);
        $this->display();
    }

    /**
     * 调整设置选项
     */
    public function update_setting() {
        $data['id'] = session('project_id');
        $data['am_onTime'] = I("post.am_ontime");
        $data['am_offTime'] = I("post.am_offtime");
        $data['pm_onTime'] = I("post.pm_ontime");
        $data['pm_offTime'] = I("post.pm_offtime");
//        $ontime = strtotime($data['am_onTime']);
//        $power_ontime = date('H:i', $ontime - 3600);
//        $offtime = strtotime($data['pm_offTime']);
//        $power_offtime = date('H:i', $offtime + 3600);
//        // 1.先查询此工程项目所有的设备
//        $info = M('WorkerInfo')->where(array('project_id' => $data['id']))->where('status>-1')->field('wrist_number')->select();
//        $power = array();
//        foreach ($info as $value) {
//            $power[] = $value['wrist_number'];
//        }
//        // 2.根据上下班时间修改设备开关机时间
//        $datetime = array(
//            'powerOnDateTime' => $power_ontime,
//            'powerOffDateTime' => $power_offtime,
//        );
//        $condition = array(
//            'deviceID' => array('in', $power),
//        );
//        M('DeviceHandlering')->where($condition)->save($datetime);
        if (M('ProjectInfo')->save($data)) {
            $this->success("更新信息成功");
        } else {
            $this->error("更新失败，请稍后再试！");
        }
    }

    /**
     * 修改密码页面
     */
    public function staff_info() {
        $this->display();
    }

    /**
     * 提交密码修改
     */
    public function password_update() {
        $id = session('user_id');
        $password = I('post.new_pwd');
        $result = M('StaffInfo')->where(array('id' => $id))->save(array('password' => md5($password)));
        if ($result) {
            $this->success("密码修改成功");
        } else {
            $this->error("密码修改失败，请稍后再试");
        }
    }

    /**
     * 联系我们
     */
    public function contact_us() {
        $this->display();
    }

    /**
     * 添加监理人员
     */
    public function project_sup_add_sub() {
        $data['project_id'] = session('project_id');
        $data['name'] = I('post.sup_name');
        $data['card_number'] = I('post.sup_card');
        $data['wrist_number'] = I('post.sup_wrist');
        $data['phone_number'] = I('post.sup_phone');
        $data['unit_id'] = 2;
        $data['type_id'] = I('post.select_work_type');
        $data['create_time'] = NOW_TIME;
        $info = M("WorkerInfo")->add($data);
        if ($info) {
            echo "<script>alert('添加成功');location.replace(document.referrer);</script>";
        } else {
            echo "<script>alert('添加失败，请重新添加');location.replace(document.referrer);</script>";
        }
    }

    /**
     * 通知通告
     */
    public function notice_info() {
        $project_id = session('project_id');
        $proprietor_id = M("ProjectInfo")->where(array('id' => $project_id))->field("proprietor_id")->find();
        $company_id = M('ProprietorInfo')->where(array('id' => $proprietor_id['proprietor_id']))->field("company_id")->find();
        $count = M('NoticeInfo')
                ->where("level = 'group' or (level = 'company' and level_id = {$company_id['company_id']})")
                ->where("status = 1")
                ->count();
        $Page = new \Think\Page($count, 10);
        $show = $Page->show();
        $info = M('NoticeInfo')
                ->where("level = 'group' or (level = 'company' and level_id = {$company_id['company_id']})")
                ->where("status = 1")
                ->limit($Page->firstRow . ',' . $Page->listRows)
                ->order('create_time desc')
                ->select();
        foreach ($info as $key => $value) {
            if ($value['level'] == "group") {
                $info[$key]['level'] = "四川省电力公司";
            } else {
                $leve_name = M('CompanyInfo')->where(array('id' => $value['level_id']))->field('name')->find();
                $info[$key]['level'] = $leve_name['name'];
            }
        }
        $this->assign('notice', $info);
        $this->assign("show", $show);
        $this->display();
    }

    /**
     * 显示通知具体内容
     * @param type $id 通知id
     */
    public function show_notice($id) {
        $info = M('NoticeInfo')->where(array('id' => $id))->find();
        $info['create_time'] = date('Y-m-d H:i:s', $info['create_time']);
        if ($info['level'] == 'group') {
            $info['level'] = '四川省电力公司';
        } else {
            $leve_name = M('CompanyInfo')->where(array('id' => $info['level_id']))->filed('name')->find();
            $info['level'] = $leve_name['name'];
        }
        $this->ajaxReturn($info);
    }

    /**
     * 现场员工黑名单查看（监理）
     */
    public function sup_black_list() {
        $project_id = session('project_id');
        $info = M('BlackList')->where(array('project_id' => $project_id))->where("auth = 'worker'")->select();
        $this->assign('black', $info);
        $this->display();
    }

    /**
     * 管理人员黑名单查看（监理）
     */
    public function sup_manage_black_list() {
        $project_id = session('project_id');
        $info = M('BlackList')->where(array('project_id' => $project_id))->where("auth = 'manager'")->select();
        $this->assign('black', $info);
        $this->display();
    }

    /**
     * 现场员工黑名单查看（施工）
     */
    public function con_black_list() {
        $project_id = session('project_id');
        $info = M('BlackList')->where(array('project_id' => $project_id))->where("auth = 'worker'")->select();
        $this->assign('black', $info);
        $this->display();
    }

    /**
     * 管理人员黑名单查看（施工）
     */
    public function con_manage_black_list() {
        $project_id = session('project_id');
        $info = M('BlackList')->where(array('project_id' => $project_id))->where("auth = 'manager'")->select();
        $this->assign('black', $info);
        $this->display();
    }

    /**
     * 分包单位黑名单查看（施工）
     */
    public function con_unit_black_list() {
        $project_id = session('project_id');
        $info = M('BlackList')->where("project_id = {$project_id} or project_id = 0")->where("auth = 'unit'")->select();
        $this->assign('black', $info);
        $this->display();
    }

    /**
     * 回显拉黑原因
     */
    public function show_reason($id) {
        $info = M('BlackList')->where(array('id' => $id))->find();
        $this->ajaxReturn($info);
    }

    /**
     * 监理单位审核员工黑名单
     */
    public function verify_worker_blacklist() {
        $id = I('post.id');
        $status = I('post.status');
        if ($status == 1) {
            $data['verify_status'] = '120';
            if (M('BlackList')->where(array('id' => $id))->save($data)) {
                echo "<script>alert('审核成功');location.replace(document.referrer);</script>";
            } else {
                echo "<script>alert('审核失败，请稍后重试');location.replace(document.referrer);</script>";
            }
        } else {
            $data['verify_status'] = '112';
            if (M('BlackList')->where(array('id' => $id))->save($data)) {
                echo "<script>alert('审核成功');location.replace(document.referrer);</script>";
            } else {
                echo "<script>alert('审核失败，请稍后重试');location.replace(document.referrer);</script>";
            }
        }
    }

    /**
     * 施工单位确定最后黑名单状态（添加审核未通过）
     */
    public function query_add_blacklist_false() {
        $card_number = I('get.card_number');
        $data = array(
            'blacklist' => '0',
        );
        if (M('BlackList')->where(array('unique_id' => $card_number))->delete()) {
            if (M('WorkerInfo')->where(array('card_number' => $card_number))->save($data)) {
                $this->success("确定成功");
            } else {
                $this->error("确定失败，请稍后再试");
            }
        } else {
            $this->error("确定失败，请稍后再试");
        }
    }

    /**
     * 施工单位确定最后黑名单状态（移除审核通过）
     */
    public function query_remove_blacklist_true() {
        $card_number = I('get.card_number');
        $data = array(
            'blacklist' => '0',
        );
        if (M('BlackList')->where(array('unique_id' => $card_number))->delete()) {
            if (M('WorkerInfo')->where(array('card_number' => $card_number))->save($data)) {
                $this->success("确定成功");
            } else {
                $this->error("确定失败，请稍后再试");
            }
        } else {
            $this->error("确定失败，请稍后再试");
        }
    }

    /**
     * 施工单位确定最后黑名单状态（移除审核未通过）
     */
    public function query_remove_blacklist_false() {
        $card_number = I('get.card_number');
        $data = array(
            'verify_status' => '0',
        );
        if (M('BlackList')->where(array('unique_id' => $card_number))->save($data)) {
            $this->success("确定成功");
        } else {
            $this->error("确定失败，请稍后再试");
        }
    }

    /**
     * 施工单位确定最后黑名单状态（添加审核通过）
     */
    public function query_add_blacklist_true() {
        $card_number = I('get.card_number');
        $data = array(
            'blacklist' => '1',
        );
        if (M('BlackList')->where(array('unique_id' => $card_number))->save(array('verify_status' => 0))) {
            if (M('WorkerInfo')->where(array('card_number' => $card_number))->save($data)) {
                $this->success("确定成功");
            } else {
                $this->error("确定失败，请稍后再试");
            }
        } else {
            $this->error("确定失败，请稍后再试");
        }
    }

    /**
     * 施工单位确定最后黑名单状态（添加审核未通过）
     */
    public function query_add_unit_blacklist_false() {
        $card_number = I('get.card_number');
        if (M('BlackList')->where(array('unique_id' => $card_number))->delete()) {
            $this->success("确定成功");
        } else {
            $this->error("确定失败，请稍后再试");
        }
    }

    /**
     * 施工单位确定最后黑名单状态（移除审核通过）
     */
    public function query_add_uint_blacklist_true() {
        $card_number = I('get.card_number');
        if (M('BlackList')->where(array('unique_id' => $card_number))->save(array('verify_status' => 0))) {
            $this->success("确定成功");
        } else {
            $this->error("确定失败，请稍后再试");
        }
    }

    /**
     * 施工单位确定最后黑名单状态（移除审核未通过）
     */
    public function query_remove_unit_blacklist_false() {
        $card_number = I('get.card_number');
        $data = array(
            'verify_status' => '0',
        );
        if (M('BlackList')->where(array('unique_id' => $card_number))->save($data)) {
            $this->success("确定成功");
        } else {
            $this->error("确定失败，请稍后再试");
        }
    }

    /**
     * 施工单位确定最后黑名单状态（移除审核通过）
     */
    public function query_remove_unit_blacklist_true() {
        $card_number = I('get.card_number');
        if (M('BlackList')->where(array('unique_id' => $card_number))->delete()) {
            $this->success("确定成功");
        } else {
            $this->error("确定失败，请稍后再试");
        }
    }

    /**
     * 提交移除黑名单
     */
    public function remove_black_list() {
        $id = I('post.id');
        $remove_reason = I('post.remove_reason');
        $data = array(
            'verify_status' => 210,
            'remove_reason' => $remove_reason,
        );
        if (M('BlackList')->where(array('id' => $id))->save($data)) {
            $this->success("提交成功，等待审核");
        } else {
            $this->error("提交失败，请重新提交");
        }
    }

    /**
     * 移除黑名单审核
     */
    public function verify_remove_worker_blacklist() {
        $id = I('post.id');
        $status = I('post.remove_status');
        if ($status == 1) {
            $data['verify_status'] = '220';
            if (M('BlackList')->where(array('id' => $id))->save($data)) {
                echo "<script>alert('审核成功');location.replace(document.referrer);</script>";
            } else {
                echo "<script>alert('审核失败，请稍后重试');location.replace(document.referrer);</script>";
            }
        } else {
            $data['verify_status'] = '212';
            if (M('BlackList')->where(array('id' => $id))->save($data)) {
                echo "<script>alert('审核成功');location.replace(document.referrer);</script>";
            } else {
                echo "<script>alert('审核失败，请稍后重试');location.replace(document.referrer);</script>";
            }
        }
    }

    /**
     * 分包单位黑名单添加
     */
    public function add_unit_black_list() {
        $card_number = I("post.card_number");
        $data['unique_id'] = $card_number;
        $data['name'] = I("post.name");
        $data['auth'] = 'unit';
        $data['project_id'] = session('project_id');
        $data['create_time'] = NOW_TIME;
        $data['defriend_reason'] = I("post.reason");
        $data['verify_status'] = '110';
        if (M('BlackList')->add($data)) {
            echo "<script>alert('添加成功，请等待审核');location.replace(document.referrer);</script>";
        } else {
            echo "<script>alert('添加失败，请稍后重新添加');location.replace(document.referrer);</script>";
        }
    }

    /**
     * 分包单位黑名单查看（监理）
     */
    public function sup_unit_black_list() {
        $project_id = session('project_id');
        $info = M('BlackList')->where("project_id = {$project_id} or project_id = 0")->where("auth = 'unit'")->select();
        $this->assign('black', $info);
        $this->display();
    }

}
