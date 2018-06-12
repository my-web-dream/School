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
	//更新设备配置信息
	$("#device_detail_info .d-comfire").click(function(){
		var id =  $("#device_detail_info input[name='id']").val();//id参数不能传丢
		var collectRate = $("#device_detail_info input[name='collectRate']").val();
		var uploadRate = $("#device_detail_info input[name='uploadRate']").val();
		var powerOnDateTime = $("#device_detail_info input[name='powerOnDateTime']").val();
		var powerOffDateTime = $("#device_detail_info input[name='powerOffDateTime']").val();
		var SOS = $("#device_detail_info input[name='SOS']").val();
		var Friend = $("#device_detail_info input[name='Friend']").val();
		$.post("<?php echo U('Admin/device_info_update');?>",{id:id,collectRate:collectRate,uploadRate:uploadRate,powerOnDateTime:powerOnDateTime,powerOffDateTime:powerOffDateTime,SOS:SOS,Friend:Friend},function(data,status){
			if(data = 'success'){
				layer.msg('恭喜您，修改配置信息成功！',{time:1500},function(){
	        		window.location.href = "<?php echo U('Admin/device_info');?>";  
	        	});
			}else{
				layer.msg("修改失败，请重试");
			}
		})//post结束
	})
	
})
//设备配置信息回填
function editor(id){
	$.post("<?php echo U('Admin/device_info_only');?>",{id:id},function(data,status){
		if(data){
			$("#device_detail_info input[name='deviceID']").val(data.deviceID);
			$("#device_detail_info input[name='IMEI']").val(data.IMEI);
			$("#device_detail_info input[name='IMSI']").val(data.IMSI);
			$("#device_detail_info input[name='collectRate']").val(data.collectRate);
			$("#device_detail_info input[name='uploadRate']").val(data.uploadRate);
			$("#device_detail_info input[name='powerOnDateTime']").val(data.powerOnDateTime);
			$("#device_detail_info input[name='powerOffDateTime']").val(data.powerOffDateTime);
			$("#device_detail_info input[name='SOS']").val(data.SOS);
			$("#device_detail_info input[name='Friend']").val(data.Friend);
			$("#device_detail_info input[name='id']").val(data.id);
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
				<span>设备基本信息</span>
			</header>
			<seciton class="m-content">
				<!-- 
				<div class="m-btngroup">
					<div class="m-btnadd">
						<span  class="m-btnicon"></span>
						<span>
							<a href="javascript:void(0)" data-reveal-id="device_add" data-animation="fade">添加</a>
						</span>
					</div>
					<div class="m-btndelete">
						<span class="m-btnicon"></span>
						<span>删除</span>
					</div>
				</div> -->
				<div class="m-data">
					<table>
						<thead>
							<tr>
								<th> <input type="checkbox"> </th>
								<th> 序号 </th>
								<th> 设备编号 </th>
								<th> IMEI </th>
								<th> IMSI </th>
								<th> 使用情况 </th>
								<th> 修改时间 </th>
								<th> 操作 </th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($info)): $i = 0; $__LIST__ = $info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i;?><tr>
								<td><input type="checkbox"></td>
								<td><?php echo ($i); ?></td>
								<td><?php echo ($va["deviceID"]); ?></td>
								<td><?php echo ($va["IMEI"]); ?></td>
								<td><?php echo ($va["IMSI"]); ?></td>
								<td>
									<?php if($va["is_bind"] == 1 ): ?>已使用
									<?php else: ?>未使用<?php endif; ?>
								</td>
								<td><?php echo (date('Y-m-d',$va["create_time"])); ?></td>							
								<td>
									<a href="javascript:void(0)" data-reveal-id="device_detail_info" data-animation="fade" class="add-member" onclick="editor('<?php echo ($va["id"]); ?>')">修改信息</a>
									<a href="javascript:void(0)" id="other" class="add-member" onclick="other('<?php echo ($va["id"]); ?>')">其它</a>
								</td>
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						</tbody>
					</table>
				</div>
				<!-- 分页符 -->
				<div class='page'>
					<?php if($page > 1): ?><!-- 首页不显示该信息 -->
						<a href="<?php echo U('Admin/device_info',array('page'=>1));?>">首页</a>
						<a href="<?php echo U('Admin/device_info',array('page'=>$page-1));?>">上一页</a>
					<?php else: ?>
						<span class='disable'>首页</span>
						<span class='disable'>上一页</span><?php endif; ?>
					<?php if($page < $total_pages): ?><!-- 尾页不显示该信息 -->
						<a href="<?php echo U('Admin/device_info',array('page'=>$page+1));?>">下一页</a>
						<a href="<?php echo U('Admin/device_info',array('page'=>$total_pages));?>">尾页</a>
					<?php else: ?>
						<span class='disable'>下一页</span>
						<span class='disable'>尾页</span><?php endif; ?>
					共 <?php echo ($total_pages); ?> 页
					当前为第 <?php echo ($page); ?> 页
					<form action="<?php echo U('Admin/device_info');?>" method="get">
						跳转到第<input type="text" name="page" size='2'>页
						<input type="submit" value="确定">
					</form> 
					
				</div>
			</seciton>
		</div>
	</article>
	<!-- 修改设备配置信息 -->
	<div id="device_detail_info" class="reveal-modal large">
		<p class="d-title">修改设备信息<span></span></p>
		<a class="close-reveal-modal">&#215;</a>		
		<div class="add-member">
			<div class="d-textbox">
				<label>设备ID:<span style="color:red">*</span></label>
				<input type="text" name="deviceID" value="" readonly/>
			</div>
			<div class="d-textbox">
				<label>IMEI号:<span style="color:red">*</span></label>
				<input type="text" name="IMEI" value="" readonly/>
				<span></span>
			</div>
			<div class="d-textbox">
				<label>IMSI号:<span style="color:red">*</span></label>
				<input type="text" name="IMSI" value="" readonly/>
				<span></span>
			</div>
			<div class="d-textbox">
				<label>采集频率:<span style="color:red">*</span></label>
				<input type="text" name="collectRate" value="" />
				<span></span>
			</div>
			<div class="d-textbox">
				<label>上传频率:<span style="color:red">*</span></label>
				<input type="text" name="uploadRate" value="" />
				<span></span>
			</div>
			<div class="d-textbox">
				<label>开机时间:<span style="color:red">*</span></label>
				<input type="text" name="powerOnDateTime" value="" />
				<span></span>
			</div>
			<div class="d-textbox">
				<label>关机时间:<span style="color:red">*</span></label>
				<input type="text" name="powerOffDateTime" value="" />
				<span></span>
			</div>
			<div class="d-textbox">
				<label>SOS号码:<span style="color:red">*</span></label>
				<input type="text" name="SOS" value="" />
				<span></span>
			</div>
			<div class="d-textbox">
				<label>亲情号:<span style="color:red">*</span></label>
				<input type="text" name="Friend" value="" />
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