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
//ajax查看通知详细信息
function des(id){
	var src = $("#image")[0].src;	//获取src属性
	//ajax提交，弹窗提示ok
    $.post("<?php echo U('Grade/notice_detail_select');?>",{id:id},function(data,status){
    	$("#notice_info textarea").val(data.describe);	//显示通知详情
    	$("#images").attr("src",src+data.image);	//显示通知图片
    });	//post  
}

</script>
	<article class="main">
		<div class="m-body">
			<header class="m-title">
				<span>通知发布记录</span>
			</header>
			<seciton class="m-content">
				<div class="m-data">
					<table>
						<thead>
							<tr>
								<th> <input type="checkbox"> </th>
								<th> 序号 </th>
								<th> 标题 </th>
								<th> 发布时间 </th>
								<th> 详情 </th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($info)): $i = 0; $__LIST__ = $info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i;?><tr>
								<td><input type="checkbox"></td>
								<td><?php echo ($i); ?></td>
								<td><?php echo ($va["title"]); ?></td>
								<td><?php echo (date("Y-m-d H:i:s",$va["create_time"])); ?></td>
								<td>
									<a href="javascript:void(0)" data-reveal-id="notice_info" data-animation="fade" class="add-member" onclick="des('<?php echo ($va["id"]); ?>')">通知详情</a>
								</td>
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						</tbody>
					</table>
				</div>
			</seciton>
		</div>
	</article>
	
	<!-- 查看作业详情 -->
	<div id="notice_info" class="reveal-modal large">
		<p class="d-title">通知描述<span></span></p>
		<a class="close-reveal-modal">&#215;</a>		
		<div class="add-member">
			<div class="d-textbox">
				<label>描述详情:</label>
				<textarea name="describe" readonly></textarea>
				<br><br>
				<img id='image' src="/Student/Public/upload/notice/" alt="" style="display:none">
				<img id='images' src="" alt="">	<!-- 此文本框用于显示图片 -->
			</div><br><br>
			<div class="d-btngroup">
				<input type="button" class="d-cancel" value="关闭">	
			</div> 
		</div>	
	</div> <!-- 弹窗结束 -->

</body>
</html>