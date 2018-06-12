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
	
<script type="text/javascript" src="/Student/Public/js/highcharts.js"></script>
<script type="text/javascript" src="/Student/Public/js/exporting.js"></script>
<script type="text/javascript">
$(function(){
	$("#find_student_attend").click(function(){	//跳转到编辑页面
		var date = $("input[name='date']").val();
		var device_id = $("input[name='device_id']").val();
		var url = "<?php echo U('Class/test_id');?>" + '?date='+date+"&device_id="+device_id;
		window.location.href = url;  
	});
})
//chart相关JS代码
//左侧Javascript代码
	$(function () {
		Highcharts.setOptions({
            lang: {
               　			printChart:"打印图表",
            	downloadJPEG: "下载JPEG图片" , 
            	downloadPDF: "下载PDF文档"  ,
            	downloadPNG: "下载PNG图片"  ,
            	downloadSVG: "下载SVG矢量图" , 
            	exportButtonTitle: "导出图片" 
            }
        });
		$('#speed').highcharts({
	        title: {
	            text: '设备 "<?php echo ($device_id); ?>" 于 "<?php echo ($date); ?>" 的"车速"数据统计',
	            x: -20 //center
	        },
	        xAxis: {
	            categories: ['<?php echo ($worker_time); ?>']
	        },
	        yAxis: {
	            title: {
	                text: '车速'
	            },
	            plotLines: [{
	                value: 0,
	                width: 1,
	                color: '#808080'
	            }]
	        },
	        tooltip: {
	            valueSuffix: 'km/h'
	        },
	        legend: {
	            layout: 'vertical',
	            align: 'right',
	            verticalAlign: 'middle',
	            borderWidth: 0
	        },
	        colors: [
	        	'orange'
	        ],
	        credits:{
	        	enabled:false	//取消显示版权
	        },
	        series: [{
	            name: '车速',
	            data: [<?php echo ($worker_spd); ?>]
	        }]
	    });
		
		$('#mile').highcharts({
	        title: {
	            text: '设备 "<?php echo ($device_id); ?>" 于 "<?php echo ($date); ?>" 日的"里程"数据统计',
	            x: -20 //center
	        },
	        xAxis: {
	            categories: ['<?php echo ($worker_time); ?>']
	        },
	        yAxis: {
	            title: {
	                text: '里程'
	            },
	            plotLines: [{
	                value: 0,
	                width: 1,
	                color: '#808080'
	            }]
	        },
	        tooltip: {
	            valueSuffix: 'km'
	        },
	        legend: {
	            layout: 'vertical',
	            align: 'right',
	            verticalAlign: 'middle',
	            borderWidth: 0
	        },
	        credits:{
	        	enabled:false	//取消显示版权
	        },
	        series: [{
	            name: '行驶里程',
	            data: [<?php echo ($worker_mile); ?>]
	        }]
	    });
		
		$('#fuel').highcharts({
	        title: {
	            text: '设备 "<?php echo ($device_id); ?> 于 "<?php echo ($date); ?>" 的"油耗"数据统计',
	            x: -20 //center
	        },
	        colors: [
	 	        	'green'
	 	        ],
	        xAxis: {
	            categories: ['<?php echo ($worker_time); ?>']
	        },
	        yAxis: {
	            title: {
	                text: '油耗'
	            },
	            plotLines: [{
	                value: 0,
	                width: 1,
	                color: '#808080'
	            }]
	        },
	        credits:{
	        	enabled:false	//取消显示版权
	        },
	        tooltip: {
	            valueSuffix: 'rh'
	        },
	        legend: {
	            layout: 'vertical',
	            align: 'right',
	            verticalAlign: 'middle',
	            borderWidth: 0
	        },
	        series: [{
	            name: '油耗数据',
	            data: [<?php echo ($worker_fuel); ?>]
	        }]
	    });
});
</script>
	<article class="main">
		<div class="m-body">
			<header class="m-title">
				<span>学生考勤管理</span>
			</header>
			<seciton class="m-content">
				<div class="m-group">
					<form action="" method="get">
			  			<input name="date" type="date" value="<?php echo ($_GET['time']); ?>" style="width:150px;"/>
			  			<input name="device_id" type="text"  value="<?php echo ($_GET['device_id']); ?>" placeholder="请输入设备号" style="width:150px;"/>
			  			&nbsp;&nbsp;参考格式：SC-GD001-00256
			  			<br><div class="m-btnconfirm" id="find_student_attend">查看</div>
		    		</form>
	    		</div>
	    		<div class="m-data">
					<?php if(($test) == "no"): ?><h2 align="center">当前暂无相关信息，请重新输入查询条件</h2>
             		<?php else: ?>
                  		<div id="speed" style="min-width:700px;height:400px"></div>
                  		<div id="mile" style="min-width:700px;height:400px"></div>
                  		<div id="fuel" style="min-width:700px;height:400px"></div><?php endif; ?>
				</div>
			</seciton>
		</div>
	</article>

</body>
</html>