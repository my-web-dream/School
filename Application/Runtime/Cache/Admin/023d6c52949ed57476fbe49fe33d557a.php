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
	
<script type="text/javascript">
$(function(){
	$("#editor_info .d-comfire").click(function(){
		layer.msg("请填写用户账号");
	})
})
</script>
	<article class="main">
		<div class="m-body">
			<header class="m-title">
				<span>班级信息</span>
			</header>
			<seciton class="m-content">
				<div class="m-group">
					<label class="m-grouptitle">班级名称:</label>
					<input type="text" value="<?php echo ($info["name"]); ?>" readonly/>
				</div>
				<div class="m-group">
					<label class="m-grouptitle">主要负责人:</label>
					<input type="text" value="<?php echo ($info["teacher"]); ?>" readonly/>
				</div>
				<div class="m-group">
					<label class="m-grouptitle">联系方式:</label>
					<input type="text" value="<?php echo ($info["teacher_phone"]); ?>" readonly/>
				</div>
				<div class="m-group">
					<label class="m-grouptitle">所属学校:</label>
					<input type="text" value="<?php echo (session('sch_name')); ?>" readonly/>
				</div>
				<div class="m-group">
					<label class="m-grouptitle">所属年级:</label>
					<input type="text" value="<?php echo ($info["grade_name"]); ?>" readonly/>
				</div>
				<div class="m-btnconfirm">
					<a href="javascript:void(0)" data-reveal-id="editor_info" data-animation="fade">编辑</a>
				</div>
			</seciton>
		</div>
	</article>
	
	<!-- 修改班级信息 -->
	<div id="editor_info" class="reveal-modal large">
		<p class="d-title">修改班级信息<span></span></p>
		<a class="close-reveal-modal">&#215;</a>		
		<div class="add-member">
			<div class="d-textbox">
				<label>班级名称:<span style="color:red">*</span><span class="class_name" style="color:red"></span></label>
				<input type="text" name="class_name" value="<?php echo ($info["name"]); ?>"/>
			</div>
			<div class="d-textbox">
				<label>主要负责人:<span style="color:red">*</span><span class="class_leader" style="color:red"></span></label>
				<input type="text" name="class_leader" value="<?php echo ($info["teacher"]); ?>"/>
				<span></span>
			</div>
			<div class="d-textbox">
				<label>联系方式:<span style="color:red">*</span><span class="class_phone" style="color:red"></span></label>
				<input type="text"  name="class_phone" value="<?php echo ($info["teacher_phone"]); ?>"/>
				<span></span>
			</div>
			<div class="d-textbox">
				<label>所属学校:<span style="color:red">*</span></label>
				<input type="text"  name="class_school" value="<?php echo (session('sch_name')); ?>" readonly/>
				<span></span>
			</div>
			<div class="d-textbox">
				<label>所属年级:<span style="color:red">*</span><span class="class_grade" style="color:red"></span></label>
				<input type="text" name="class_grade" value="<?php echo ($info["grade_name"]); ?>" readonly/>
				<span></span>
			</div><br><br>
			<div class="d-btngroup">
				<input type="button" class="d-comfire" value="确定">
				<input type="button" class="d-cancel" value="取消">	
			</div>
		</div>	
	</div> <!-- 弹窗结束 -->

</body>
</html>