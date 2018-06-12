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
	
<script type="text/javascript" src="/Student/Public/js/ajaxfileupload/ajaxfileupload.js" ></script>
<script type="text/javascript">
$(function(){
	//作业上传提交
	$(".m-btnconfirm a").click(function(){
		var subject = $("select[name='subject']").find("option:selected").text();	//获取名称
		var teacher = $("input[name='teacher']").val();
		var describe = $("textarea[name='describe']").val();
		if(subject == "请选择科目"){
			layer.msg('您还没有选择学科！');
			return false;
		}
		if(teacher == ""){
			layer.msg('教师姓名必填！');
			return false;
		}
		if(describe == ""){
			layer.msg('作业信息必填！');
			return false;
		}
		if(describe.length > 100){
			layer.msg('作业描述过长！');
			return false;
		}
		$.ajaxFileUpload({
			url:"<?php echo U('Class/homework_sub');?>",//这个是要提交到上传的php程序文件
			secureuri:false,//是否启用安全提交
			fileElementId:'homework',//需要上传的文件域ID
			dataType: 'json',//返回数据类型
			data:{subject:subject,teacher:teacher,describe:describe},
			type: 'post',//POST方式提交
			success: function (data,status)
			{
				if(data == 'file none'){
					layer.msg("文件未上传，请重试");
					return false;
				}else if(data == 'undefind type'){
					layer.msg("未知文件类型");
					return false;
				}else if(data == 'too large'){
					layer.msg("文件过大，请上传2M以内的文件");
					return false;
				}else if(data == 'other error'){
					layer.msg("其他错误");
					return false;
				}else if(data == 'success'){
					layer.msg('作业发布成功！',{time:1500},function(){
	        			window.location.href = "<?php echo U('Class/homework_select');?>";
	        		});
				}
			},
			error: function (data,status)
			{
				layer.msg("服务器异常错误");
				return false;
			}
		})  //ajax over
	})
})
//图片本地预览
function preview(avatar){
    for(var i=0;i<document.getElementById(avatar).files.length;i++){
        var f = document.getElementById(avatar).files[i];
        var src = window.URL.createObjectURL(f);
       $("#"+avatar).next().html('<img src='+src+' width="200" height="180" />');
   } 
}
</script>
	<article class="main">
		<div class="m-body">
			<header class="m-title">
			<span>作业发布</span>
			<!--	<ul class="m-subtitle">
					<a href="#"><li class="m-underline">文字发布</li></a>
					<a href="#"><li>图片发布</li></a>
				</ul> -->
			</header>
			<seciton class="m-content">
				<div class="m-group">
					<label class="m-grouptitle">所属科目:</label>
					<select class="select" name="subject" >
						<option selected="selected" value="0">请选择科目</option>
						<option value="1">语文</option>
						<option value="2">数学</option>
						<option value="3">英语</option>
						<option value="4">自然科学</option>
					</select>
				</div>
				<div class="m-group">
					<label class="m-grouptitle">教师姓名:</label>
					<input type="text" name="teacher" placeholder="请填写教师姓名" value=""/>
				</div>
				<br>
				<input id="homework" type="file" size="45" onchange="preview('homework')" name="homework">
				预览效果：
				<div></div>
				<br><br>
				<div class="m-group">
					<label class="m-grouptitle">作业描述：</label>
					<textarea name="describe" placeholder="字数限100字以内" /></textarea>
				</div>	
				<div class="m-btnconfirm">
					<a href="javascript:void(0)">发布</a>
				</div>
			</seciton>
		</div>
	</article>

</body>
</html>