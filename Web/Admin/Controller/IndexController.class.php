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
        $beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
        $endToday=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
        $time['created_at'] = [['gt', $beginToday],['lt', $endToday],'and'];
        $this->newUser = M("User")->where($time)->count();
        $this->newComment = M("Comments")->where($time)->count();
        $this->newPost = M("Posts")->where($time)->count();
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