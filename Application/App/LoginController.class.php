<?php
namespace App\Controller;
use \Think\Controller;
/**
 * App登录对接
 */
// 指定字符格式
//header("Content-type:text/html;charset=utf-8");
// 指定允许其他域名访问
//header("Access-Control-Allow-Origin:*");
// 响应类型
//header("Access-Control-Allow-Methods:POST");
// 响应头设置
//header("Access-Control-Allow-Headers:x-requested-with,content-type");
/**
 * App登录响应
 * @xueji
 */
class LoginController extends Controller {
    /**
     * 登录界面展示
     */
    public function login(){
       // $receive = I('post.login');
        //$result = json_decode($receive, true);
        //得到手机端用户名密码
        $username = I('post.username');
        $password = I('post.password');
        $info = M('Staff_info') 
        ->where(array('username'=>$username))
        ->find();
        if(!$info){	//账号不存在
        	$response = array(
        			'status' => '0',
        			'describe' => '对不起，账号不存在'
        	);
        	echo json_encode($response); die;
        }else{
        	if(md5($password) != $info['password']){	//密码错误
        		$response = array(
        				'status' => '0',
        				'describe' => '对不起，密码错误'
        		);
        		echo json_encode($response); die;
        	}else{		//密码正确
        		$response = array(
        				'status' => '1',
        				'describe' => '登陆成功',
        				'auth' => $info['auth'],
        				'img' => '121.40.92.106/OBD/Public/upload/img/'.$info['img'],
        		);
        		echo json_encode($response); die;
        	}
        }
    }
    

}