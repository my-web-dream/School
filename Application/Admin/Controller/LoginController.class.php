<?php
namespace Admin\Controller;
use Think\Controller;

/**
 * 该类为登录类，用于系统登录页面
 */
header("Content-type:text/html;charset=utf-8");

class LoginController extends Controller {

    /**
     * 登录界面展示
     */
    public function login() {
        $this->display();
    }

    /**
     * 登陆跳转
     */
    public function login_in() {
        // 获取用户名和密码
        $username = I('post.username');
        $password = I('post.password');
        $res = '';
        $info = M('Staff_info')
        	->where(array('username' => $username,'status'=>1))
        	->find();
        if(!$info){	//用户不存在
        	$this->error('用户不存在');
        }else{	//用户名正确
        	cookie('username', $username);	//用户名
        	cookie('password', $password);	//用户名
        	if(md5($password) == $info['password']){ //用户名正确+密码正确
        		session('username', $username);	//用户名
        		
        		session('auth', $info['auth']);	//权限
        		session('auth_id', $info['auth_id']);	//权限id
        		session('head_img', $info['head_img']);	//头像
        		//学校名称，全局使用
        		$sch_name = M('School_info') -> getField('name');
        		session('sch_name',$sch_name);
        		if($info['auth'] == 'admin'){
        			session('auth_name','系统管理员');
        			$this->redirect('Admin/sch_info','', 3,'页面跳转中...');
        		}else if($info['auth'] == 'school'){
        			session('auth_name','学校负责人');
        			$this->redirect('school/school_info','', 3,'页面跳转中...');
        		}else if($info['auth'] == 'grade'){
        			session('auth_name','年级负责人');
        			$this->redirect('grade/grade_info','', 3,'页面跳转中...');
        		}else if($info['auth'] == 'class'){
        			session('auth_name','班级负责人');
        			$this->redirect('Class/class_info','', 3,'页面跳转中...');
        		}else if($info['auth'] == 'device'){
        			session('auth_name','设备管理员');
        			$this->redirect('Device/device_info','', 3,'页面跳转中...');
        		}
        	}
        	else{ //用户名正确+密码错误
        		$this->error('密码错误');
        	}
       	} //用户名正确结束
    }

    /**
     * 用户退出操作
     */
    public function login_out() {
        session(null);
        cookie(null);
        $this->redirect('Login/login');
        die;
    }

}
