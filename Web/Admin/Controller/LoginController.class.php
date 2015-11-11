<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller
{
	public function index()
	{
		$this->display();
	}

	public function login()
	{
		if (!IS_AJAX || empty(I("post."))) {
			$this->error("非法访问", U('index'));
		}
		$user = D("User");
		if (!$user->create(I("post."), 4)) {
			$this->error($user->getError(), U("Login/index"), true);
		} else {
			$this->success("登录成功", U("Index/index"), true);
		}
	}

	public function verify()
	{
		$config = [
			'imageW' => '120',
			'imageH' => '34',
			'fontSize' => '18',
			'bg' => [26,188,156],
			'length' => 4,
			'useNoise' => false,
			'useCurve' => false
		];
		$Verify = new \Think\Verify($config);
		$Verify->entry();
	}
}