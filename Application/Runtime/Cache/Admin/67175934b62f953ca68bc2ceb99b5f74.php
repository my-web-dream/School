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
	//ajax导出表格
	$(".export").click(function(){
		$.post("<?php echo U('Class/student_data_export');?>",{},function(data,status){
			if(data == 'export_success'){	//添加成功，刷新当前页
				layer.msg('恭喜您，数据导出成功！',{time:1500},function(){
        			window.location.href = "<?php echo U('Class/student_info');?>";  
        		});
			}else{
				layer.msg("数据导出失败，请重试");
			}
		})
	});
	
	//学生信息提交
	$('#add_student .d-comfire').click(function(){
		var stu_name = $("input[name='stu_name']").val();
		var stu_sex = $("input[name='stu_sex']").val();
		var device_id = $("input[name='device_id']").val();
		var stu_parent = $("input[name='stu_parent']").val();
		var stu_parent_phone = $("input[name='stu_parent_phone']").val();
		if(!stu_name){
			layer.msg("请填写学生姓名");
			return false;
		}
		if(!stu_sex){
			layer.msg("请选择学生性别");
			return false;
		}
		if(!device_id){
			layer.msg("请添加学生证编号");
			return false;
		}
		if(!stu_parent){
			layer.msg("请填写学生联系人");
			return false;
		}
		if(!stu_parent_phone){
			layer.msg("请填写学生联系人电话");
			return false;
		}
		var arr = new Array();
		arr['0'] = stu_name;arr['1'] = stu_sex;arr['2'] = device_id;
		arr['3'] = stu_parent;arr['4'] = stu_parent_phone;
		//ajax提交
		$.post("<?php echo U('Class/student_info_add');?>",{arr:arr},function(data,status){
			if(data == 'add_success'){	//添加成功，刷新当前页
				layer.msg('恭喜您，添加学生信息成功！',{time:1500},function(){
        			window.location.href = "<?php echo U('Class/student_info');?>";  
        		});
			}else{
				layer.msg("添加学生信息失败，请重试");
			}
		})
	})
	
})
</script>
	<article class="main">
		<div class="m-body">
			<header class="m-title">
				<span>班级学生</span>
			</header>
			<seciton class="m-content">
				<div class="m-btngroup">
					<div class="m-btnadd">
						<span class="m-btnicon"></span>
						<a href="javascript:void(0)" data-reveal-id="add_student" data-animation="fade">		
						<span>添加</span>
						</a>
					</div>
					<div class="m-btndelete">
						<span class="m-btnicon"></span>
						<span>删除</span>
					</div>
				</div>
				<input type="button" class="export" value="导出"/>
				<div class="m-data">
					<table>
						<thead>
							<tr>
								<th> <input type="checkbox"> </th>
								<th> 序号 </th>
								<th> 学生姓名 </th>
								<th> 学生性别 </th>
								<th> 学生证编号 </th>
								<th> 联系人姓名 </th>
								<th> 联系人电话 </th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($info)): $i = 0; $__LIST__ = $info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i;?><tr>
								<td><input type="checkbox"></td>
								<td><?php echo ($i); ?></td>
								<td><?php echo ($va["name"]); ?></td>
								<td><?php echo ($va["sex"]); ?></td>
								<td><?php echo ($va["device_id"]); ?></td>
								<td><?php echo ($va["parent_name"]); ?></td>
								<td><?php echo ($va["parent_phone"]); ?></td>
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						</tbody>
					</table>
				</div>
			</seciton>
		</div>
	</article>
	
	
	<!-- 添加学生弹窗 -->
	<div id="add_student" class="reveal-modal large">
		<p class="d-title">修改班级信息<span></span></p>
		<a class="close-reveal-modal">&#215;</a>		
		<div class="add-member">
			<div class="d-textbox">
				<label>学生姓名:<span style="color:red">*</span><span class="check_stu_name" style="color:red"></span></label>
				<input type="text" name="stu_name" placeholder="请输入学生姓名"/>
			</div>
			<div class="d-textbox">
				<label>学生证编号:<span style="color:red">*</span><span class="check_device_id" style="color:red"></span></label>
				<input type="text" name="device_id" placeholder="请输入学生证编号"/>
				<span></span>
			</div>
			<div class="d-textbox">
				<label>学生性别:<span style="color:red">*</span><span class="check_stu_sex" style="color:red"></span></label>
				<input type="text"  name="stu_sex" placeholder="请选择性别"/>
				<span></span>
			</div>
			<div class="d-textbox">
				<label>联系人姓名:<span style="color:red">*</span><span class="check_stu_parent" style="color:red"></span></label>
				<input type="text"  name="stu_parent" placeholder="请输入家长姓名"/>
				<span></span>
			</div>
			<div class="d-textbox">
				<label>联系人电话:<span style="color:red">*</span><span class="check_stu_parent_phone" style="color:red"></span></label>
				<input type="text"  name="stu_parent_phone" value=""/>
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