<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>学生管理系统_年级负责人</title>
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
					年级管理
					<span class="n-uparrow"></span>
					<span class="n-line"></span>
					<ul class="n-submenu">
						<li><a href="<?php echo U('Grade/grade_info');?>">年级基本信息</a></li>
						<li><a href="<?php echo U('Grade/grade_leader_info');?>">管理员</a></li>
					</ul>
				</li>
				<li class="n-firstlevel">
					班级管理
					<span class="n-uparrow"></span>
					<span class="n-line"></span>
					<ul class="n-submenu">
						<li><a href="<?php echo U('Grade/class_info');?>">班级管理</a></li>
						<!-- <li><a href="<?php echo U('Grade/class_leader_info');?>">班级负责人</a></li>-->
					</ul>
				</li>
				<li class="n-firstlevel">
					通知发布
					<span class="n-uparrow"></span>
					<span class="n-line"></span>
					<ul class="n-submenu">
						<li><a href="<?php echo U('Grade/notice');?>">通知发布</a></li>
						<li><a href="<?php echo U('Grade/notice_select');?>">发布记录</a></li>
					</ul>
				</li>
				<li class="n-firstlevel">
					个人信息
					<span class="n-uparrow"></span>
					<span class="n-line"></span>
					<ul class="n-submenu">
						<li><a href="<?php echo U('Grade/pro_info');?>">个人信息管理</a></li>
					</ul>
				</li>
				<li class="n-firstlevel">
					测试专区
					<span class="n-uparrow"></span>
					<span class="n-line"></span>
					<ul class="n-submenu">
						<li>测试1</li>
						<li>测试2</li>
					</ul>
				</li>
			</ul>
		</div>
	</nav> <!-- 导航条结束 -->
	
<script type="text/javascript">
$(function(){
	$("#editor_info .d-comfire").click(function(){
		var grade_name = $("input[name='grade_name']").val();
		var grade_leader = $("input[name='grade_leader']").val();
		var grade_phone = $("input[name='grade_phone']").val();
//		var grade_school = $("input[name='grade_school']").val();
		//ajax提交更新
		$.post("<?php echo U('Grade/grade_info_update');?>",{grade_name:grade_name,grade_leader:grade_leader,grade_phone:grade_phone},function(data,status){
			if(data == 'success'){
				layer.msg("信息保存成功!",{time:1500},function(){
					window.location.reload(); //刷新当前页面
				});
			}else{
				layer.msg("信息保存失败，请重试");
			}
		});	//post结束
	})
})
</script>
	<article class="main">
		<div class="m-body">
			<header class="m-title">
				<span>年级信息</span>
			</header>
			<seciton class="m-content">
				<div class="m-group">
					<label class="m-grouptitle">当前年级:</label>
					<input type="text" value="<?php echo ($info["name"]); ?>" readonly/>
				</div>
				<div class="m-group">
					<label class="m-grouptitle">年级负责人:</label>
					<input type="text" value="<?php echo ($info["leader"]); ?>" readonly/>
				</div>
				<div class="m-group">
					<label class="m-grouptitle">联系方式:</label>
					<input type="text" value="<?php echo ($info["phone_number"]); ?>" readonly/>
				</div>
				<div class="m-group">
					<label class="m-grouptitle">所属学校:</label>
					<input type="text" value="<?php echo ($info["sch_name"]); ?>" readonly/>
				</div>
				<div class="m-btnconfirm">
					<a href="javascript:void(0)" data-reveal-id="editor_info" data-animation="fade">编辑</a>
				</div>
			</seciton>
		</div>
	</article>
	
	<!-- 修改年级信息 -->
	<div id="editor_info" class="reveal-modal large">
		<p class="d-title">修改班级信息<span></span></p>
		<a class="close-reveal-modal">&#215;</a>		
		<div class="add-member">
			<div class="d-textbox">
				<label>当前年级:<span style="color:red">*</span><span class="class_name" style="color:red"></span></label>
				<input type="text" name="grade_name" value="<?php echo ($info["name"]); ?>"/>
			</div>
			<div class="d-textbox">
				<label>主要负责人:<span style="color:red">*</span><span class="class_leader" style="color:red"></span></label>
				<input type="text" name="grade_leader" value="<?php echo ($info["leader"]); ?>"/>
				<span></span>
			</div>
			<div class="d-textbox">
				<label>联系方式:<span style="color:red">*</span><span class="class_phone" style="color:red"></span></label>
				<input type="text"  name="grade_phone" value="<?php echo ($info["phone_number"]); ?>"/>
				<span></span>
			</div>
			<div class="d-textbox">
				<label>所属学校:<span style="color:red">*</span><span class="class_school" style="color:red"></span></label>
				<input type="text"  name="grade_school" value="<?php echo ($info["sch_name"]); ?>" readonly/>
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