<?php
namespace Admin\Controller;
use Common\Controller\CommonController;
/**
 * 用户管理控制器
 */
class UserController extends CommonController
{
	//用户列表
	public function index()
	{
		$this->user = D("User")->field(['id', 'username', 'email', 'updated_at', 'login_ip', 'status'])->select();
		$this->display();
	}

	//用户详情
	public function details()
	{
		$this->display();
	}

	//添加用户
	public function addUser()
	{
		
	}
}