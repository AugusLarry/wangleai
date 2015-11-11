<?php
namespace Admin\Controller;
use Think\Controller;

/**
 * 后台首页控制器
 */
class IndexController extends Controller
{
	//首页视图
    public function index()
    {
    	$this->display();
    }
}