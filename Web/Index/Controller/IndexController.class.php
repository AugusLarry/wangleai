<?php
namespace Index\Controller;
use Think\Controller;
/**
 * 首页控制器
 */
class IndexController extends Controller
{
    public function index()
    {
    	$this->category = M("Terms")->where(['taxonomy' => 0])->select();
    	$this->display();
    }
}