<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>学生管理系统_系统管理员</title>
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
					学校管理
					<span class="n-uparrow"></span>
					<span class="n-line"></span>
					<ul class="n-submenu">
						<li><a href="<?php echo U('Admin/sch_info');?>">学校列表</a></li>
						<li><a href="<?php echo U('Admin/sch_admin_info');?>">学校负责人</a></li>
					</ul>
				</li>
				<li class="n-firstlevel">
					设备管理
					<span class="n-uparrow"></span>
					<span class="n-line"></span>
					<ul class="n-submenu">
						<li><a href="<?php echo U('Admin/device_add');?>">添加设备</a></li>
						<li><a href="<?php echo U('Admin/device_info');?>">设备基本信息</a></li>
						<li><a href="<?php echo U('Class/student_orbit');?>">设备列表</a></li>
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
		var name = $("input[name='name']").val();
		var position = $("input[name='position']").val();
		var leader = $("input[name='leader']").val();
		var phone_number = $("input[name='phone_number']").val();
		if(!name){
			layer.msg("学校名称必填！");
		}
		if(!position){
			layer.msg("学校位置必填！");
		}
		if(!leader){
			layer.msg("学校负责人必填！");
		}
		if(!phone_number){
			layer.msg("联系方式必填！");
		}
		var arr = new Array();
		arr[0] = name;arr[1] = position;arr[2] = leader;arr[3] = phone_number;
		$.post("<?php echo U('Admin/sch_info_editor');?>",{arr:arr},function(data,status){
			if(data == 'success'){
				layer.msg("恭喜您修改成功",{time:1500},function(){
					window.location.href = "<?php echo U('Admin/sch_info');?>";
				});
			}else{
				layer.msg("修改失败，请重试");
			}
		});//ajax提交结束
	})
})
</script>
	<article class="main">
		<div class="m-body">
			<header class="m-title">
				<span>当前管理学校</span>
			</header>
			<seciton class="m-content">
				<div class="m-group">
					<label class="m-grouptitle">学校名称:</label>
					<input type="text" value="<?php echo ($info["name"]); ?>" readonly/>
				</div>
				<div class="m-group">
					<label class="m-grouptitle">学校位置:</label>
					<input type="text" value="<?php echo ($info["position"]); ?>" readonly/>
				</div>
				<div class="m-group">
					<label class="m-grouptitle">学校负责人:</label>
					<input type="text" value="<?php echo ($info["leader"]); ?>" readonly/>
				</div>
				<div class="m-group">
					<label class="m-grouptitle">学校负责人联系方式:</label>
					<input type="text" value="<?php echo ($info["phone_number"]); ?>" readonly/>
				</div>
				<div class="m-group">
					<label class="m-grouptitle">信息修改时间:</label>
					<input type="text" value="<?php echo (date("Y-m-d",$info["create_time"])); ?>" readonly/>
				</div>
				<div class="m-btnconfirm">
					<a href="javascript:void(0)" data-reveal-id="editor_info" data-animation="fade">编辑</a>
				</div>
			</seciton>
		</div>
	</article>
	
	<!-- 修改学校信息 -->
	<div id="editor_info" class="reveal-modal large">
		<p class="d-title">修改学校信息<span></span></p>
		<a class="close-reveal-modal">&#215;</a>		
		<div class="add-member">
			<div class="d-textbox">
				<label>学校名称:<span style="color:red">*</span><span class="name" style="color:red"></span></label>
				<input type="text" name="name" value="<?php echo ($info["name"]); ?>"/>
			</div>
			<div class="d-textbox">
				<label>学校位置:<span style="color:red">*</span><span class="position" style="color:red"></span></label>
				<input type="text" name="position" value="<?php echo ($info["position"]); ?>"/>
				<span></span>
			</div>
			<div class="d-textbox">
				<label>学校负责人:<span style="color:red">*</span><span class="leader" style="color:red"></span></label>
				<input type="text"  name="leader" value="<?php echo ($info["leader"]); ?>"/>
				<span></span>
			</div>
			<div class="d-textbox">
				<label>联系方式：<span style="color:red">*</span><span class="phone_number" style="color:red"></span></label>
				<input type="text"  name="phone_number" value="<?php echo ($info["phone_number"]); ?>"/>
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