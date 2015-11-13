<?php
namespace Admin\Controller;
use Common\Controller\CommonController;

/**
 * 后台首页控制器
 */
class IndexController extends CommonController
{
	//首页视图
    public function index()
    {
    	$this->display();
    }

    //退出登录
    public function logout()
    {
    	session_unset();
    	session_destroy();
    	$this->redirect("Admin/Login/index");
    }
}