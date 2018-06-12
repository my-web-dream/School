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
	//班级添加
	$('#add_class .d-comfire').click(function(){
		var name = $("input[name='name']").val();
		var teacher = $("input[name='teacher']").val();
		var teacher_phone = $("input[name='teacher_phone']").val();
		if(!name){
			layer.msg("请填写班级名称");
			return false;
		}
		if(!teacher){
			layer.msg("请填写教师姓名");
			return false;
		}
		if(!teacher_phone){
			layer.msg("请填写联系方式");
			return false;
		}
		//ajax提交
		$.post("<?php echo U('Grade/class_info_add');?>",{name:name,teacher:teacher,teacher_phone:teacher_phone},function(data,status){
			if(data == 'success'){	//添加成功，刷新当前页
				layer.msg('恭喜您，添加班级成功！',{time:1500},function(){
        			window.location.href = "<?php echo U('Grade/class_info');?>";  
        		});
			}else{
				layer.msg("添加班级失败，请重试");
			}
		})
	})
	
})
//查看班级负责人
function class_leader_info(id){
	$url = "<?php echo U('Grade/class_leader_info');?>"+'?id='+id;	//id传入
	window.location.href = $url;
}
//查看班级学生
function class_student_info(id,name){
	$url = "<?php echo U('Grade/class_student_info');?>"+'?id='+id;	//id传入,name传入
	window.location.href = $url;
}
</script>
	<article class="main">
		<div class="m-body">
			<header class="m-title">
				<span>班级管理</span>
			</header>
			<seciton class="m-content">
				<div class="m-btngroup">
					<div class="m-btnadd">
						<span class="m-btnicon"></span>
						<a href="javascript:void(0)" data-reveal-id="add_class" data-animation="fade">		
						<span>添加</span>
						</a>
					</div>
					<div class="m-btndelete">
						<span class="m-btnicon"></span>
						<span>删除</span>
					</div>
				</div>
				<div class="m-data">
					<table>
						<thead>
							<tr>
								<th> <input type="checkbox"> </th>
								<th> 序号 </th>
								<th> 班级名称 </th>
								<th> 班主任 </th>
								<th> 联系方式 </th>
								<th> 修改时间 </th>
								<th> 操作 </th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($info)): $i = 0; $__LIST__ = $info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i;?><tr>
								<td><input type="checkbox"></td>
								<td><?php echo ($i); ?></td>
								<td><?php echo ($va["name"]); ?></td>
								<td><?php echo ($va["teacher"]); ?></td>
								<td><?php echo ($va["teacher_phone"]); ?></td>
								<td><?php echo (date('Y-m-d H:i:s',$va["create_time"])); ?></td>
								<td>
									<a href="javascript:void(0);" class="add-member" onclick="class_leader_info('<?php echo ($va["id"]); ?>')">查看负责人</a>
									<a href="javascript:void(0);" class="add-member" onclick="class_student_info('<?php echo ($va["id"]); ?>','<?php echo ($va["name"]); ?>')">查看学生</a>
								</td>
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						</tbody>
					</table>
				</div>
			</seciton>
		</div>
	</article>
	
	
	<!-- 添加班级弹窗 -->
	<div id="add_class" class="reveal-modal large">
		<p class="d-title">添加班级<span></span></p>
		<a class="close-reveal-modal">&#215;</a>		
		<div class="add-member">
			<div class="d-textbox">
				<label>班级名称:<span style="color:red">*</span></label>
				<input type="text" name="name" placeholder="请输入班级名称"/>
			</div>
			<div class="d-textbox">
				<label>班主任:<span style="color:red">*</span></label>
				<input type="text" name="teacher" placeholder="请输入班主任姓名"/>
				<span></span>
			</div>
			<div class="d-textbox">
				<label>联系方式:<span style="color:red">*</span></label>
				<input type="text" name="teacher_phone" placeholder="请输入联系方式"/>
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