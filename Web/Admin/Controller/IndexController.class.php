<?php
namespace Admin\Controller;

/**
 * 后台首页控制器
 */
class IndexController extends CommonController
{
	//首页视图
    public function index()
    {
        //今天0点时间戳
        $beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
        //今天24点时间戳
        $endToday=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
        //and条件,时间大于0点小于24点
        $time['created_at'] = [['gt', $beginToday],['lt', $endToday],'and'];
        //获取今天新增用户
        $newUser = M("User")->where($time)->count();
        //获取今天新增评论
        $newComment = M("Comments")->where($time)->count();
        //获取今天新增文章
        $newPost = M("Posts")->where($time)->count();
        $this->assign("newUser", $newUser);
        $this->assign("newComment", $newComment);
        $this->assign("newPost", $newPost);
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