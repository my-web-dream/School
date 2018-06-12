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
	//提交修改校级负责人信息,只改姓名与联系方式
	$("#sch_admin_editor .d-comfire").click(function(){
		var id =  $("#sch_admin_editor input[name='id']").val();//id参数不能传丢
		var name = $("#sch_admin_editor input[name='name']").val();
		var phone_number = $("#sch_admin_editor input[name='phone_number']").val();
		$.post("<?php echo U('Admin/sch_admin_sub');?>",{id:id,name:name,phone_number:phone_number},function(data,status){
			if(data = 'success'){
				layer.msg('恭喜您，修改信息成功！',{time:1500},function(){
	        		window.location.href = "<?php echo U('Admin/sch_admin_info');?>";  
	        	});
			}else{
				layer.msg("修改失败，请重试");
			}
		})//post结束
	})
	
})
//信息回填
function editor(id){
	$.post("<?php echo U('Admin/sch_admin_one');?>",{id:id},function(data,status){
		if(data){
			//alert(data);return false;
			$("#sch_admin_editor input[name='name']").val(data.name);
			$("#sch_admin_editor input[name='phone_number']").val(data.phone_number);
			$("#sch_admin_editor input[name='status']").val(data.status);
			$("#sch_admin_editor input[name='auth']").val(data.auth);
			$("#sch_admin_editor input[name='id']").val(data.id);
		}else{
			layer.msg("查询失败，请重试");
		}
		
	})
}
//解除绑定
function cancel(id){	//传入staff_id号
	layer.open({
		  title: '提示',
		  content: '您确定要解除该人职务？',
		  //yes的回掉函数
		  yes: function(index,layero){
			$.post("<?php echo U('Admin/sch_admin_cancel');?>",{id:id},function(data,status){
				if(data == 'success'){	//添加成功，刷新当前页
					layer.msg('恭喜您，解除职务成功！',{time:1500},function(){
		        		window.location.href = "<?php echo U('Admin/sch_admin_info');?>";  
		        	});
				}else{
					layer.msg("解除失败，请重试");
				}
			})//ajax解除绑定
		 }
	});     
}
</script>
	<article class="main">
		<div class="m-body">
			<header class="m-title">
				<span>学校负责人列表</span>
			</header>
			<seciton class="m-content">
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
				<div class="m-data">
					<table>
						<thead>
							<tr>
								<th> <input type="checkbox"> </th>
								<th> 序号 </th>
								<th> 姓名 </th>
								<th> 状态 </th>
								<th> 联系方式 </th>
								<th> 职务 </th>
								<th> 修改时间 </th>
								<th> 操作 </th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($info)): $i = 0; $__LIST__ = $info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i;?><tr>
								<td><input type="checkbox"></td>
								<td><?php echo ($i); ?></td>
								<td><?php echo ($va["name"]); ?></td>
								<td>
									<?php if($va["status"] == 1 ): ?>在职
									<?php else: ?>离职<?php endif; ?>
								</td>
								<td><?php echo ($va["phone_number"]); ?></td>
								<td>
									<?php if($va["auth"] == school): ?>校级负责人
									<?php else: ?>其它<?php endif; ?>
								</td>
								<td><?php echo (date('Y-m-d',$va["create_time"])); ?></td>
								<td>
									<a href="javascript:void(0)" data-reveal-id="sch_admin_editor" data-animation="fade" class="add-member" onclick="editor('<?php echo ($va["id"]); ?>')">修改信息</a>
									<a href="javascript:void(0)" id="sch_admin_cancel" class="add-member" onclick="cancel('<?php echo ($va["id"]); ?>')">解除职位</a>
								</td>
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						</tbody>
					</table>
				</div>
			</seciton>
		</div>
	</article>
	<!-- 修改学校负责人信息 -->
	<div id="sch_admin_editor" class="reveal-modal large">
		<p class="d-title">修改学校负责人信息<span></span></p>
		<a class="close-reveal-modal">&#215;</a>		
		<div class="add-member">
			<div class="d-textbox">
				<label>姓名:<span style="color:red">*</span></label>
				<input type="text" name="name" value=""/>
			</div>
			<div class="d-textbox">
				<label>状态:<span style="color:red">*</span></label>
				<input type="text" name="status" value="" readonly/>
				<span></span>
			</div>
			<div class="d-textbox">
				<label>联系方式:<span style="color:red">*</span></label>
				<input type="text" name="phone_number" value=""/>
				<span></span>
			</div>
			<div class="d-textbox">
				<label>职务：<span style="color:red">*</span></label>
				<input type="text"  name="auth" value="" readonly/>
				<span></span>
			</div><br><br>
			<input type="text" name="id" value="" style="display:none"/>
			<div class="d-btngroup">
				<input type="button" class="d-comfire" value="确定">
				<input type="button" class="d-cancel" value="取消">	
			</div>
		</div>	
	</div> <!-- 弹窗结束 -->

</body>
</html>