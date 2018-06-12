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
						<li><a href="<?php echo U('Class/class_leader_info');?>">管理员</a></li>
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
	
	<article class="main">
		<div class="m-body">
			<header class="m-title">
				<span>管理员</span>
			</header>
			<seciton class="m-content">
				<!--  
				<div class="m-btngroup">
					<div class="m-btnadd">
						<span  class="m-btnicon"></span>
						<span>添加</span>
					</div>
					<div class="m-btndelete">
						<span class="m-btnicon"></span>
						<span>删除</span>
					</div>
				</div>
				-->
				<div class="m-data">
					<table>
						<thead>
							<tr>
								<th> <input type="checkbox"> </th>
								<th> 序号 </th>
								<th> 姓名 </th>
								<th> 班级名称 </th>
								<th> 联系方式 </th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($info)): $i = 0; $__LIST__ = $info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i;?><tr>
								<td><input type="checkbox"></td>
								<td><?php echo ($i); ?></td>
								<td><?php echo ($va["name"]); ?></td>
								<td><?php echo ($va["object_name"]); ?></td>
								<td><?php echo ($va["phone_number"]); ?></td>
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						</tbody>
					</table>
				</div>
			</seciton>
		</div>
	</article>

</body>
</html>