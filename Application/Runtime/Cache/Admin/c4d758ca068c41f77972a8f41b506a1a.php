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
						<li><a href="<?php echo U('Class/device_bind');?>">已绑定设备</a></li>
						<li><a href="<?php echo U('Class/device_notbind');?>">未绑定设备</a></li>
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
<script type="text/javascript">
$(function(){
	$("#find_student_attend").click(function(){	//跳转到编辑页面
		var date = $("input[name='date']").val();
		var device_id = $("input[name='device_id']").val();
		var url = "<?php echo U('Class/student_sos');?>" + '?date='+date+"&device_id="+device_id;
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
function map(name,deviceID,longitude,latitude,time){
	var date = $("input[name='date']").val();
	//设置后台地址
	var url = '<?php echo U("Class/student_sos_map");?>'+'?date='+date+'&time='+time+
		'&student_name='+name +'&deviceID='+deviceID+'&longitude='+longitude+'&latitude='+latitude;
	window.open(url,'newwindow', 'height=530, width=1200, top=104, left=50, toolbar=no, menubar=no, scrollbars=no,resizable=no,location=no, status=no');
}
</script>
	<article class="main">
		<div class="m-body">
			<header class="m-title">
				<span>学生报警管理</span>
			</header>
			<seciton class="m-content">
				<div class="m-group">
					<form action="" method="get">
			  			<input type="text" name=date id='datetimepicker' style="width:150px">
			  			<input name="device_id" type="text"  value="<?php echo ($_GET['device_id']); ?>" placeholder="请输入设备号" style="width:150px;"/>
			  			&nbsp;&nbsp;参考格式：SC-GD001-00256
			  			<br><div class="m-btnconfirm" id="find_student_attend">查看</div>
		    		</form>
	    		</div>
	    		<script type="text/javascript">
	 				$('#datetimepicker').datetimepicker({value:'<?php echo ($_GET['time']); ?>',step:10});
				</script>
	    		<div class="m-data">
	    			<?php if(($test) == "no"): ?><h2 align="center">当前暂无相关信息，请重新输入查询条件</h2>
             		<?php else: ?>
						<table>
							<thead>
								<tr>
									<th> <input type="checkbox"> </th>
									<th> 序号 </th>
									<th> 学生姓名 </th>
									<th> 设备编号 </th>
									<th> IMEI </th>
									<th> IMSI </th>
									<th> 报警时间 </th>
									<th> 详情 </th>
								</tr>
							</thead>
							<tbody>
								<?php if(is_array($info)): $i = 0; $__LIST__ = $info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i;?><tr>
									<td><input type="checkbox"></td>
									<td><?php echo ($i); ?></td>
									<td><?php echo ($va["name"]); ?></td>
									<td><?php echo ($va["deviceID"]); ?></td>
									<td><?php echo ($va["IMEI"]); ?></td>
									<td><?php echo ($va["IMSI"]); ?></td>
									<td><?php echo (date("H:i:s",$va["utcDateTime"])); ?></td>
									<td>
										<a href="#" class="add-member" onclick="map('<?php echo ($va["name"]); ?>','<?php echo ($va["deviceID"]); ?>','<?php echo ($va["longitude"]); ?>','<?php echo ($va["latitude"]); ?>','<?php echo (date("H:i:s",$va["utcDateTime"])); ?>')">查看详情</a>
									</td>
								</tr><?php endforeach; endif; else: echo "" ;endif; ?>
							</tbody>
						</table>
						<!-- 分页符 -->
						<div class='page'>
							<?php if($page > 1): ?><!-- 首页不显示该信息 -->
								<a href="<?php echo U('Class/student_sos',array('page'=>1,'device_id'=>$device_id,'date'=>$date));?>">首页</a>
								<a href="<?php echo U('Class/student_sos',array('page'=>$page-1,'device_id'=>$device_id,'date'=>$date));?>">上一页</a>
							<?php else: ?>
								<span class='disable'>首页</span>
								<span class='disable'>上一页</span><?php endif; ?>
							<?php if($page < $total_pages): ?><!-- 尾页不显示该信息 -->
								<a href="<?php echo U('Class/student_sos',array('page'=>$page+1,'device_id'=>$device_id,'date'=>$date));?>">下一页</a>
								<a href="<?php echo U('Class/student_sos',array('page'=>$total_pages,'device_id'=>$device_id,'date'=>$date));?>">尾页</a>
							<?php else: ?>
								<span class='disable'>下一页</span>
								<span class='disable'>尾页</span><?php endif; ?>
							共 <?php echo ($total_pages); ?> 页
							当前为第 <?php echo ($page); ?> 页
							<form action="<?php echo U('Class/student_sos',array('device_id'=>$device_id,'date'=>$date));?>" method="get">
								跳转到第<input type="text" name="page" size='2'>页
								<input type="submit" value="确定">
							</form> 
						</div>
						<!-- 分页符结束 --><?php endif; ?>
				</div>
			</seciton>
		</div>
	</article>

</body>
</html>