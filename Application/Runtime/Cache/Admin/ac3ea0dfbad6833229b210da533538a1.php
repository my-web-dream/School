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
	//单选按钮切换
	$("#on_work").click(function(){
		$("input[name='is_on_work']").attr('checked',true);
		$("input[name='is_on_all']").attr('checked',false);
	})
	$("#on_all").click(function(){
		$("input[name='is_on_work']").attr('checked',false);
		$("input[name='is_on_all']").attr('checked',true);
	})
	$("#off_work").click(function(){
		$("input[name='is_off_work']").attr('checked',true);
		$("input[name='is_off_all']").attr('checked',false);
	})
	$("#off_all").click(function(){
		$("input[name='is_off_work']").attr('checked',false);
		$("input[name='is_off_all']").attr('checked',true);
	})
	//表单提交
	$(".m-btnconfirm").click(function(){
		var deviceID = $("input[name='deviceID']").val();
		var IMEI = $("input[name='IMEI']").val();
		var IMSI = $("input[name='IMSI']").val();
		var collectRate = $("input[name='collectRate']").val();
		var uploadRate = $("input[name='uploadRate']").val();
		var bluetooth_station = $("input[name='bluetooth_station']").val();
		var powerOnDateTime = $("input[name='powerOnDateTime']").val();
		var powerOffDateTime = $("input[name='powerOffDateTime']").val();
		var powerOnDateTimeFlag = $("input[name='powerOnDateTimeFlag']:checked").val();
		var powerOffDateTimeFlag = $("input[name='powerOffDateTimeFlag']:checked").val();
		var LBS_School = $("input[name='LBS_School']").val();
		var LBS_Home = $("input[name='LBS_Home']").val();
		var SOS = $("input[name='SOS']").val();
		var Friend = $("input[name='Friend']").val();
		if(!deviceID){
			layer.msg("设备ID必填！");
			return false;
		}
		if(!IMEI){
			layer.msg("IMEI号必填！");
			return false;
		}
		if(!IMSI){
			layer.msg("IMSI号必填！");
			return false;
		}
		if(!collectRate){
			layer.msg("采集频率必填！");
			return false;
		}
		if(!uploadRate){
			layer.msg("上传频率必填！");
			return false;
		}
		if(!bluetooth_station){
			layer.msg("蓝牙基站号必填！");
			return false;
		}
		if(!powerOnDateTime){
			layer.msg("开机时间必填！");
			return false;
		}
		if(!powerOffDateTime){
			layer.msg("关机时间必填！");
			return false;
		}
		if(!LBS_School){
			layer.msg("学校基站必填！");
			return false;
		}
		if(!LBS_Home){
			layer.msg("家庭基站必填！");
			return false;
		}
		if(!SOS){
			layer.msg("求助号码必填！");
			return false;
		}
		if(!Friend){
			layer.msg("亲情号码必填！");
			return false;
		}
		var arr = new Array();
		arr[0] = deviceID;
		arr[1] = IMEI;
		arr[2] = IMSI;
		arr[3] = collectRate;
		arr[4] = uploadRate;
		arr[5] = bluetooth_station;
		arr[6] = powerOnDateTime;
		arr[7] = powerOffDateTime;
		arr[8] = powerOnDateTimeFlag;
		arr[9] = powerOffDateTimeFlag;
		arr[10] = LBS_School;
		arr[11] = LBS_Home;
		arr[12] = SOS;
		arr[13] = Friend;
		$.post("<?php echo U('Admin/device_add_sub');?>",{arr:arr},function(data,status){
			if(data == 'success'){
				layer.msg("恭喜您添加设备成功",{time:2000},function(){
					window.location.href = "<?php echo U('Admin/device_info');?>";
				});
			}else{
				layer.msg("添加设备失败，请重试");
			}
		});//ajax提交结束
	})
})
</script>
	<article class="main">
		<div class="m-body">
			<header class="m-title">
				<span>添加设备</span>
			</header>
			<seciton class="m-content">
				<div class="m-group">
					<label class="m-grouptitle">设备ID:<span style="color:red">*</span></label>
					<input type="text" name="deviceID" value=""/>
				</div>
				<div class="m-group">
					<label class="m-grouptitle">IMEI号:<span style="color:red">*</span></label>
					<input type="text" name="IMEI" value="" />
				</div>
				<div class="m-group">
					<label class="m-grouptitle">IMSI号:<span style="color:red">*</span></label>
					<input type="text" name="IMSI"  value="" />
				</div>
				<div class="m-group">
					<label class="m-grouptitle">采集频率:<span style="color:red">*</span></label>
					<input type="text" name="collectRate" value="" />
				</div>
				<div class="m-group">
					<label class="m-grouptitle">上传频率:<span style="color:red">*</span></label>
					<input type="text" name="uploadRate" value="" />
				</div>
				<div class="m-group">
					<label class="m-grouptitle">蓝牙基站:<span style="color:red">*</span></label>
					<input type="text"  name="bluetooth_station" value="" />
				</div>
				<div class="m-group">
					<label class="m-grouptitle">开机时间:<span style="color:red">*</span></label>
					<input type="text" name="powerOnDateTime" value="" />
				</div>
				<div class="m-group">
					<label class="m-grouptitle">关机时间:<span style="color:red">*</span></label>
					<input type="text" name="powerOffDateTime" value="" />
				</div>
				<div class="d-radwrap" style="width:610px;margin-top:10px;margin-bottom:15px;float:left;">
					<label>开机日期:</label>
					<div class="d-rdogroup">
						<div>
							<input type="radio" id="on_work" name="powerOnDateTimeFlag" value="5" >
							<label for="on_work">工作日</label>							
						</div>
						<div>
							<input type="radio" id="on_all" name="powerOnDateTimeFlag" value="7" checked>
							<label for="on_all">全天</label>							
						</div>
					</div>
				</div>
				<div class="d-radwrap" style="width:300px;margin-top:10px;margin-bottom:15px;float:left;">
					<label>关机日期:</label>
					<div class="d-rdogroup">
						<div>
							<input type="radio" id="off_work" name="powerOffDateTimeFlag" value="5" >
							<label for="off_work">工作日</label>							
						</div>
						<div>
							<input type="radio" id="off_all" name="powerOffDateTimeFlag" value="7" checked>
							<label for="off_all">全天</label>							
						</div>
					</div>
				</div>
				<div class="m-group">
					<label class="m-grouptitle">学校基站:<span style="color:red">*</span></label>
					<input type="text" name="LBS_School" value="" />
				</div>
				<div class="m-group">
					<label class="m-grouptitle">家庭基站:<span style="color:red">*</span></label>
					<input type="text" name="LBS_Home" value="" />
				</div>
				<div class="m-group">
					<label class="m-grouptitle">SOS号码:<span style="color:red">*</span></label>
					<input type="text" name="SOS" value="" />
				</div>
				<div class="m-group">
					<label class="m-grouptitle">亲情号:<span style="color:red">*</span></label>
					<input type="text" name="Friend" value="" />
				</div>
				<div class="m-btnconfirm">
					<a href="javascript:void(0)" >提交</a>
				</div>
			</seciton>
		</div>
	</article>


</body>
</html>