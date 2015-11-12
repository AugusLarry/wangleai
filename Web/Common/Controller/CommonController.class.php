<?php
namespace Common\Controller;
use Think\Controller;
/**
 * 前后台公用控制器
 */
class CommonController extends Controller
{
	//自动验证
	public function _initialize ()
	{
		if (!isset($_SESSION['uid'])) {
			$this->error("请重新登录!", U("Login/index"));
		}
	}
}