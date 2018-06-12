<?php

namespace Admin\Controller;

use Think\Controller;

/**
 * 首页
 */
class IndexController extends Controller {

    /**
     * 判断是否登陆
     */
    public function index() {
        $this->redirect("Login/login");
    }

}
