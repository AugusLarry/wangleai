<?php
namespace Admin\Controller;
use Think;
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
			$this->redirect("Login/index");
			return false;
		}
		$auth = new Think\Auth();
		$url = strtolower(MODULE_NAME . '/'. CONTROLLER_NAME . '/' . ACTION_NAME);
		if (!in_array($url, C("AUTH_CONFIG.NOT_AUTH"))) {
			if(!$auth->check($url, $_SESSION['uid'])) {
				$this->error('你没有权限',U('Admin/Index/index'));
			}
		}
		$active = [
			'uid' => $_SESSION['uid'],
			'dateline' => NOW_TIME,
			'ip' => get_client_ip(),
			'module' => $_SERVER['PHP_SELF'] . $_SERVER["QUERY_STRING"]
		];
		M("ActiveRecord")->data($active)->add();
	}
}