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
//解除绑定
function cancel(device_id){	//传入学生id号
	layer.open({
		  title: '提示',
		  content: '您确定要解除绑定么？',
		  //yes的回掉函数
		  yes: function(index,layero){
			//alert(id);return false;
			$.post("<?php echo U('Class/stu_bind_cancel');?>",{device_id:device_id},function(data,status){
				if(data == 'success'){	//添加成功，刷新当前页
					layer.msg('恭喜您，解除绑定成功！',{time:1500},function(){
		        		window.location.href = "<?php echo U('Class/stu_bind_status');?>";  
		        	});
				}else{
					layer.msg("解除绑定失败，请重试");
				}
			})//ajax解除绑定
		 }
	});     
}
//数据详情
function detail(device_id,name){
	$.post("<?php echo U('Class/stu_bind_detail');?>",{device_id:device_id},function(data,status){
		if(data){	//返回数据成功
			 $("input[name='name']").val(name);
			 $("input[name='device_id']").val(device_id);
			 $("input[name='imei']").val(data.IMEI);
			 $("input[name='imsi']").val(data.IMSI);
			 $("input[name='collectRate']").val(data.collectRate);
			 $("input[name='uploadRate']").val(data.uploadRate);
			 $("input[name='powerOnDateTime']").val(data.powerOnDateTime);
			 $("input[name='powerOffDateTime']").val(data.powerOffDateTime);
			 $("input[name='sos']").val(data.sos);
		}else{
			layer.msg("查询失败，请重试");
		}
	});
}
</script>
	<article class="main">
		<div class="m-body">
			<header class="m-title">
				<span>已绑定信息</span>
			</header>
			<seciton class="m-content">
				<div class="m-data">
					<table>
						<thead>
							<tr>
								<th> <input type="checkbox"> </th>
								<th> 序号 </th>
								<th> 学生姓名 </th>
								<th> 学生证编号 </th>
								<th> 采集频率 </th>
								<th> 上传频率 </th>
								<th> 操作 </th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($info)): $i = 0; $__LIST__ = $info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i;?><tr>
								<td><input type="checkbox"></td>
								<td><?php echo ($i); ?></td>
								<td><?php echo ($va["name"]); ?></td>
								<td><?php echo ($va["device_id"]); ?></td>
								<td><?php echo ($va["collectRate"]); ?></td>
								<td><?php echo ($va["uploadRate"]); ?></td>
								<td>
									<a href="javascript:void(0)" data-reveal-id="de_bind_detail" data-animation="fade" class="add-member" onclick="detail('<?php echo ($va["device_id"]); ?>','<?php echo ($va["name"]); ?>')">查看详情</a>
									&nbsp;&nbsp;&nbsp;
									<a href="#" class="add-member" onclick="cancel('<?php echo ($va["device_id"]); ?>')">解除绑定</a>
								</td>
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						</tbody>
					</table>
				</div>
			</seciton>
		</div>
	</article>
	
	
	<!--学生设备详细信息弹窗 -->
	<div id="de_bind_detail" class="reveal-modal large">
		<p class="d-title">详细信息<span></span></p>
		<a class="close-reveal-modal">&#215;</a>		
		<div class="add-member">
			<div class="d-textbox">
				<label>学生姓名:<span style="color:red">*</span><span class="check_stu_name" style="color:red"></span></label>
				<input type="text" name="name" placeholder="请输入学生姓名"/>
			</div>
			<div class="d-textbox">
				<label>学生证编号:<span style="color:red">*</span><span class="check_device_id" style="color:red"></span></label>
				<input type="text" name="device_id" placeholder="请输入学生证编号"/>
				<span></span>
			</div>
			<div class="d-textbox">
				<label>IMEI号:<span style="color:red">*</span><span class="check_imei" style="color:red"></span></label>
				<input type="text" name="imei" placeholder="请输入IMEI号"/>
				<span></span>
			</div>
			<div class="d-textbox">
				<label>IMSI号:<span style="color:red">*</span><span class="chekc_imsi" style="color:red"></span></label>
				<input type="text" name="imsi" placeholder="请输入IMSI号"/>
				<span></span>
			</div>
			<div class="d-textbox">
				<label>采集频率:<span style="color:red">*</span><span class="check_collectRate" style="color:red"></span></label>
				<input type="text" name="collectRate" value=""/>
				<span></span>
			</div>
			<div class="d-textbox">
				<label>上传频率:<span style="color:red">*</span><span class="check_uploadRate" style="color:red"></span></label>
				<input type="text" name="uploadRate" value=""/>
				<span></span>
			</div>
			<div class="d-textbox">
				<label>开机时间:<span style="color:red">*</span><span class="check_powerOnDateTime" style="color:red"></span></label>
				<input type="text" name="powerOnDateTime" value=""/>
				<span></span>
			</div>
			<div class="d-textbox">
				<label>关机时间:<span style="color:red">*</span><span class="check_powerOffDateTime" style="color:red"></span></label>
				<input type="text" name="powerOffDateTime" value=""/>
				<span></span>
			</div>
			<div class="d-textbox">
				<label>求救电话:<span style="color:red">*</span><span class="check_sos" style="color:red"></span></label>
				<input type="text" name="sos" value=""/>
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