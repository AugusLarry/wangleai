<?php
namespace Admin\Controller;
use Think;
use Think\Controller;
/**
 * 后台登录控制器
 */
class LoginController extends Controller
{
	//登录视图
	public function index()
	{
		$this->display();
	}

	//登录表单处理
	public function login()
	{
		if (!IS_AJAX || empty(I("post."))) $this->error("非法访问", U('index'));
		$user = D("User");
		if ($user->create(I("post."), 4) && $user->login()) {
			$this->success("登录成功", U("Index/index"), true);
		} else {
			$this->error($user->getError(), U("Login/index"), true);
		}
	}

	//验证码
	public function verify()
	{
		$config = [
			'seKey'    => C('seKey'),
	        'codeSet'  => C('codeSet'),
	        'expire'   => C('expire'),
	        'useZh'    => C('useZh'),
	        'zhSet'    => C('zhSet'),
	        'useImgBg' => C('useImgBg'),
	        'fontSize' => C('fontSize'),
	        'useCurve' => C('useCurve'),
	        'useNoise' => C('useNoise'),
	        'imageH'   => C('imageH'),
	        'imageW'   => C('imageW'),
	        'length'   => C('length'),
	        'fontttf'  => C('fontttf'),
	        'bg'       => C('bg'),
	        'reset'    => C('reset'),
		];
		$Verify = new Think\Verify($config);
		$Verify->entry();
	}
}