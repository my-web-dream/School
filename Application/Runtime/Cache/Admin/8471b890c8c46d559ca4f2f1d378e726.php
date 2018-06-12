<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>学生管理系统_班主任</title>
<link rel="stylesheet" type="text/css" href="/Student/Public/css/main.css"/>
<link rel="stylesheet" type="text/css" href="/Student/Public/css/reveal.css"/>
<script type="text/javascript" src="/Student/Public/js/jquery.min.js"></script>
<script type="text/javascript" src="/Student/Public/js/jquery.reveal.js"></script>
<script type="text/javascript" src="/Student/Public/js/input.js"></script>
<script type="text/javascript" src="/Student/Public/js/layer/layer.js"></script>
</head>
<body>
	<header class="header">
		<div class="h-left"></div>
		<div class="h-center">
			<ul>
				
				<li class="n-firstlevel">
					欢迎您&nbsp;&nbsp;&nbsp;<?php echo (session('username')); ?>!
					<span></span>
				</li>
				<li class="n-firstlevel">
					您的身份属于:&nbsp;&nbsp;&nbsp;<?php echo (session('auth_name')); ?>
					<span></span>
				</li>
				<a href="<?php echo U('Login/login_out');?>">
					<li class="n-firstlevel" >退出<span></span></li>
				</a>
			</ul>
		</div>
		<div class="h-right">
			<ul>
				<li class="h-iconfenlei"></li>
				<li class="h-iconsousuo"></li>
				<li class="h-iconback"></li>
				<li class=""></li>
				<li class=""></li>
				<li class=""></li>
				<li class=""></li>
				<li class=""></li>
			</ul>
		</div>
	</header>
	<nav class="nav"> <!-- 导航条 -->
		<div class="n-user">
			<div class="n-userimg">
				<img class="head_img" src="/Student/Public/upload/<?php echo (session('head_img')); ?>">
			</div>
			<div class="n-userstate">
				<span class="n-staicon"></span>
				<span class="n-count"></span> 
			</div>
			<div class="n-usercoordinate"> </div>
		</div>
		<div class="n-menu">
			<ul class="n-parmenu">
				<li class="n-firstlevel">
					班级管理
					<span class="n-uparrow"></span>
					<span class="n-line"></span>
					<ul class="n-submenu">
						<li><a href="<?php echo U('Class/class_info');?>">班级基本信息</a></li>
						<li><a href="<?php echo U('Class/class_teacher_info');?>">管理员</a></li>
					</ul>
				</li>
				<li class="n-firstlevel">
					学生管理
					<span class="n-uparrow"></span>
					<span class="n-line"></span>
					<ul class="n-submenu">
						<li><a href="<?php echo U('Class/student_info');?>">查看学生</a></li>
						<li><a href="<?php echo U('Class/student_orbit');?>">学生运动数据</a></li>
						<li><a href="<?php echo U('Class/student_attend');?>">学生考勤数据</a></li>
						<li><a href="<?php echo U('Class/student_sos');?>">学生报警数据</a></li>
					</ul>
				</li>
			  	<li class="n-firstlevel">
					作业管理
					<span class="n-uparrow"></span>
					<span class="n-line"></span>
					<ul class="n-submenu">
						<li><a href="<?php echo U('Class/homework');?>">作业发布</a></li>
						<li><a href="<?php echo U('Class/homework_select');?>">作业记录查看</a></li>
					</ul>
				</li>
				<li class="n-firstlevel">
					设备管理
					<span class="n-uparrow"></span>
					<span class="n-line"></span>
					<ul class="n-submenu">
						<li><a href="<?php echo U('Class/stu_bind_status');?>">已绑定信息</a></li>
						<li><a href="<?php echo U('Class/stu_nobind_status');?>">未绑定信息</a></li>
					</ul>
				</li>
				<li class="n-firstlevel">
					个人信息
					<span class="n-uparrow"></span>
					<span class="n-line"></span>
					<ul class="n-submenu">
						<li><a href="<?php echo U('Class/pro_info');?>">个人信息管理</a></li>
					</ul>
				</li>
				<li class="n-firstlevel">
					测试专区
					<span class="n-uparrow"></span>
					<span class="n-line"></span>
					<ul class="n-submenu">
						<li><a href="<?php echo U('Class/test_page');?>">测试分页</a></li>
						<li><a href="<?php echo U('Class/test_id');?>">基站ID测试</a></li>
						<li>测试5</li>
						<li>测试4</li>
						<li>测试3</li>
					</ul>
				</li>
			</ul>
		</div>
	</nav> <!-- 导航条结束 -->
	
<link rel="stylesheet" type="text/css" href="/Student/Public/js/datetimepicker/jquery.datetimepicker.css"/>
<script src="/Student/Public/js/datetimepicker/jquery.js"></script>
<script src="/Student/Public/js/datetimepicker/build/jquery.datetimepicker.full.js"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=z3hc18DC7zkuwqEWpWsEkZAi"></script>
<script type="text/javascript" src="http://api.map.baidu.com/library/CurveLine/1.5/src/CurveLine.min.js"></script>
<script type="text/javascript">
$(function(){
	$("#find_student_orbit").click(function(){	//跳转到编辑页面
		var date = $("input[name='date']").val();
		var device_id = $("input[name='device_id']").val();
		//ajax加密关键信息
//		$.post("<?php echo U('Class/code');?>",{device_id:device_id},function(data,status){
//			var url = "<?php echo U('Class/student_orbit');?>" + '?date='+date+"&device_id="+data;  
//			window.location.href = url;  
//		})
		var url = "<?php echo U('Class/student_orbit');?>" + '?date='+date+"&device_id="+device_id;  
		window.location.href = url;  
	});
	//日期控件调整
	$("#datetimepicker").datetimepicker({
		  minView: "month",//设置只显示到月份
		  language:  'zh-CN',
		  format : "20y-m-d",//日期格式
		  autoclose:true,//选中关闭
		  todayBtn: true//今日按钮
	});
})
</script>
	<article class="main">
		<div class="m-body">
			<header class="m-title">
				<span>学生运动轨迹</span>
			</header>
			<seciton class="m-content">
				<div class="m-group">
					<form action="" method="get">
			  			<input type="text" name=date id='datetimepicker' style="width:150px">
			  			<input name="device_id" type="text"  value="<?php echo ($_GET['device_id']); ?>" placeholder="请输入设备号" style="width:150px;"/>
			  			&nbsp;&nbsp;参考格式：SC-GD001-00256
			  			<br/><br/><div class="m-btnconfirm" id="find_student_orbit">查看</div>
		    		</form>
	    		</div>
	    		<script type="text/javascript">
	 				$('#datetimepicker').datetimepicker({value:'<?php echo ($_GET['time']); ?>',step:10});
				</script>
	    		<br><br>		
				<div id="container" style="width:100%;height:600px;border:1px solid gray">	
	     		
	 			</div>
			</seciton>
		</div>
	</article>
<script type="text/javascript">
	//百度地图API功能
	var map = new BMap.Map("container");
	//103.996028,30.58615
	map.centerAndZoom(new BMap.Point(<?php echo ($jd_center); ?>,<?php echo ($wd_center); ?>), 15);	//设置中心坐标及地图等级
	//添加控件
	map.addControl(new BMap.NavigationControl());               // 添加平移缩放控件  
	map.addControl(new BMap.ScaleControl());                    // 添加比例尺控件  
		map.addControl(new BMap.OverviewMapControl());              //添加缩略地图控件
		map.addControl(new BMap.MapTypeControl());          		//添加地图类型控件  
	//创建弧线
	map.enableScrollWheelZoom();
	var points = [<?php echo ($orbit); ?>];
	var curve = new BMapLib.CurveLine(points, {strokeColor:"blue", strokeWeight:3, strokeOpacity:0.5}); //创建弧线对象
	map.addOverlay(curve); //添加到地图中
	curve.enableEditing(); //开启编辑功能
	//创建中心点和中心圆
//	var point = new BMap.Point(<?php echo ($jd_center); ?>,<?php echo ($wd_center); ?>);
//	var marker = new BMap.Marker(point); // 创建点
//	var circle = new BMap.Circle(point,120,{strokeColor:"blue", strokeWeight:2, strokeOpacity:0.5}); //创建圆(中心点，半径，颜色宽度，弧度等级)
//	map.addOverlay(marker);            //增加点
//	map.addOverlay(circle);            //增加圆
	//循环输出时间文字标签
	<?php if(is_array($arr)): $i = 0; $__LIST__ = $arr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i;?>var opts = { position : <?php echo ($va["position"]); ?>,	// 指定文本标注所在的地理位置
		  	 		 offset   : new BMap.Size(10,-10)    //设置文本偏移量
					}
		var label = new BMap.Label('<?php echo (date("Y-m-d H:i:s",$va["utcDateTime"])); ?>', opts);  // 创建文本标注对象
		map.addOverlay(label);<?php endforeach; endif; else: echo "" ;endif; ?>
</script>

</body>
</html>