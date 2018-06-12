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
	
<script type="text/javascript" src="/Student/Public/js/ajaxfileupload/ajaxfileupload.js" ></script>
<script type="text/javascript">
$(function(){
	$(".m-btnconfirm a").click(function(){
		var title = $("input[name='title']").val();
		var describe = $("textarea[name='describe']").val();
		if(title == ""){
			layer.msg('标题必填！');
			return false;
		}
		if(describe == ""){
			layer.msg('内容必填！');
			return false;
		}
		if(describe.length > 100){
			layer.msg('内容过长！');
			return false;
		}
		$.ajaxFileUpload({
			url:"<?php echo U('Grade/notice_release');?>",//这个是要提交到上传的php程序文件
			secureuri:false,//是否启用安全提交
			fileElementId:'notice',//需要上传的文件域ID
			dataType: 'json',//返回数据类型
			data:{title:title,describe:describe},
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
					layer.msg('消息发布成功！',{time:1500},function(){
	        			window.location.href = "<?php echo U('Grade/notice_select');?>";
	        		});
				}
			},
			error: function (data,status)
			{
				layer.msg("服务器异常错误");
				return false;
			}
		})  //ajax over
		//ajax提交，弹窗提示ok
//        $.post("<?php echo U('Grade/notice_release');?>",{title:title,describe:describe},function(data,status){
//        	if(data == 'success'){
//        		layer.msg('通知发布成功！',{time:1500},function(){
//        			window.location.href = "<?php echo U('Grade/notice_select');?>";
//        		});
//        	}else{
//        		layer.msg('通知发布失败,请重试！');
//        	}
//        });	//post   
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
				<span>通知发布</span>
			</header>
			<seciton class="m-content">
				<div class="m-group">
					<label class="m-grouptitle">标题:</label>
					<input type="text" name="title" placeholder="请填写标题" value=""/>
				</div><br>
				<input id="notice" type="file" onchange="preview('notice')" size="45" name="notice">
				预览效果：
				<div></div>
				<br><br>
				<div class="m-group">
					<label class="m-grouptitle">内容：</label>
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