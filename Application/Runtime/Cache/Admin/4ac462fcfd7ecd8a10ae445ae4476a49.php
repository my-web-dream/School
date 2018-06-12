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
	$(".m-btnconfirm").click(function(){
		var name = $("input[name='name']").val();
		var phone_number = $("input[name='phone_number']").val();
		//ajax提交更新
		$.post("<?php echo U('Grade/pro_info_update');?>",{name:name,phone_number:phone_number},function(data,status){
			if(data == 'success'){
				layer.msg("信息保存成功!");
				setTimeout('location()',3000);
			}else{
				layer.msg("信息保存失败，请重试");
			}
		});	//post结束
	})//click结束
})
function location(){
	window.location.reload(); //刷新当前页面
}
</script>
	<article class="main">
		<div class="m-body">
			<header class="m-title">
				<span>个人信息</span>
			</header>
			<seciton class="m-content">
				<form method="post">
				<div class="m-group">
					<label class="m-grouptitle">用户名:</label>
					<input type="text" value="<?php echo ($info["username"]); ?>" disabled/>
					<!--<span>修改信息</span>!-->
				</div>
				<div class="m-group">
					<label class="m-grouptitle">登录密码:</label>
					<input type="text" value="******" disabled/>
				</div>
				<div class="m-group">
					<label class="m-grouptitle">个人姓名:</label>
					<input type="text" name="name" value="<?php echo ($info["name"]); ?>" />
				</div>
				<div class="m-group">
					<label class="m-grouptitle">联系方式:</label>
					<input type="text" name="phone_number" value="<?php echo ($info["phone_number"]); ?>" />
				</div>
				<div class="m-group">
					<label class="m-grouptitle">权限级别:</label>
					<input type="text" value="<?php echo (session('auth_name')); ?>" disabled/>
				</div>
				<div class="m-group">
					<label class="m-grouptitle">修改时间:</label>
					<input type="text" value='<?php echo (date("Y-m-d H:i:s",$info["create_time"])); ?>' disabled/>
				</div>
				<div class="m-group">
					<label class="m-grouptitle">个人头像:</label>
					<img class="head_images" src="/Student/Public/upload/<?php echo ($info["head_img"]); ?>">	
				</div>
				<input type='file' name='editor_img' >
				<div class="m-btnconfirm">
					<a href="javascript:void(0)">保存</a>
				</div>
				</form>
			</seciton>
		</div>
	</article>

</body>
</html>