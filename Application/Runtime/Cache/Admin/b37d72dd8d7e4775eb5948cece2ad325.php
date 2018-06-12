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
	
<style type="text/css">
/*添加按钮样式修改*/
.m-btnadd a {
	text-decoration:none;
	color:blue;
}
.m-btnadd a:hover{
	color:red;
}
</style>
<script type="text/javascript">
$(function(){
	//提交绑定信息
	$("#de_bind .d-comfire").click(function(){
		var stu_name = $("#de_bind input[name='stu_name']").val();
		var device_id = $("#de_bind input[name='device_id']").val();
		$.post("<?php echo U('Class/stu_bind_confirm');?>",{stu_name:stu_name,device_id:device_id},function(data,status){
			if(data == 'success'){	//绑定成功
				layer.msg('恭喜您，学生绑定设备成功！',{time:1500},function(){
        			window.location.href = "<?php echo U('Class/stu_nobind_status');?>";  
        		});
			}else{
				layer.msg("学生绑定设备失败，请重试");
			}
		})
	});
})
//申请设备绑定
function bind(stu_name){
	$("#de_bind input[name='stu_name']").val(stu_name);
	//ajax查询可用设备编号，查询5个
	$.post("<?php echo U('Class/enable_device');?>",{},function(data,status){
		if(data){	//添加成功，刷新当前页
			$("#de_bind textarea[name='device']").val(data);
		}else{
			layer.msg("对不起，已无可用设备！");
		}
	})//ajax解除绑定
}
</script>
	<article class="main">
		<div class="m-body">
			<header class="m-title">
				<span>未绑定信息</span>
			</header>
			<seciton class="m-content">
				<div class="m-data">
					<table>
						<thead>
							<tr>
								<th> <input type="checkbox"> </th>
								<th> 序号 </th>
								<th> 学生姓名 </th>
								<th> 学生性别 </th>
								<th> 联系人姓名 </th>
								<th> 联系人电话 </th>
								<th> 操作 </th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($info)): $i = 0; $__LIST__ = $info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i;?><tr>
								<td><input type="checkbox"></td>
								<td><?php echo ($i); ?></td>
								<td><?php echo ($va["name"]); ?></td>
								<td><?php echo ($va["sex"]); ?></td>
								<td><?php echo ($va["parent_name"]); ?></td>
								<td><?php echo ($va["parent_phone"]); ?></td>
								<td>
									<a href="javascript:void(0)" data-reveal-id="de_bind" data-animation="fade" class="add-member" onclick="bind('<?php echo ($va["name"]); ?>')">申请绑定</a>
								</td>
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						</tbody>
					</table>
				</div>
			</seciton>
		</div>
	</article>
	
	
	<!-- 添加学生弹窗 -->
	<div id="de_bind" class="reveal-modal large">
		<p class="d-title">申请设备绑定<span></span></p>
		<a class="close-reveal-modal">&#215;</a>		
		<div class="add-member">
			<div class="d-textbox">
				<label>学生姓名:<span style="color:red">*</span></label>
				<input type="text" name="stu_name" readonly/>
			</div>
			<div class="d-textbox">
				<label>学生证编号:<span style="color:red">*</span><span class="check_device_id" style="color:red"></span></label>
				<input type="text" name="device_id" placeholder="请输入学生证编号"/>
				<span></span>
			</div>
			<div class="d-textbox">
				<label>当前可用编号(请任选其中一个，并复制):</label>
				<textarea name="device" readonly></textarea>
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