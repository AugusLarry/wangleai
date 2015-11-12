<?php
namespace Admin\Model;
use Think\Model;
/**
 * 用户模型
 */
class UserModel extends Model
{
	//定义默认用户状态
	public $status = 10;
	//定义模型字段
	protected $fields = ['id', 'username', 'email', 'password', 'display_name', 'avatar', 'description', 'status', 'password_reset_key', 'created_at', 'updated_at', 'login_ip'];

	//自动验证
	protected $_validate = [
		['username', 'require', '账号不能为空!'],
		['password', 'require', '密码不能为空!'],
		['verify', 'require', '验证码不能为空!'],
		['username', '6,12', '账号长度在6-12位字符之间', 1, 'length'],
		['password', '6,12', '密码长度在6-12位字符之间', 1, 'length'],
		['verify', 'check_verify', '验证码错误', 1, 'function'],
		['email', 'email', '不是正确的邮箱格式!', 0, 'regex', 1],
		['password', 'checkPwd', '用户名或密码错误', 1, 'callback', 4],//登录的时候验证
		['status', 'checkStatus', '用户被锁定,请联系管理员!', 1, 'callback', 4],//登录的时候验证
	];

	//验证密码
	public function checkPwd()
	{
		$pwd = $this->where(['username' => I("post.username")])->field("password")->find();
		return (!$pwd || $pwd['password'] !== md5(I("post.password"))) ? false : true;
	}

	//验证用户状态
	public function checkStatus()
	{
		$status = $this->where(['username' => I("post.username")])->field("status")->find();
		return $status['status'] != $this->status ? false : true;
	}

	//登录后处理(更新时间及IP，存SESSION)
	public function login()
	{
		$user = $this->where(['username' => I("post.username")])->find();
		if ($user) {
			$login_time = date('Y-m-d H:i:s', $user['updated_at']);
			$login_ip = $user['login_ip'];
			$data = [
				'id' => $user['id'],
				'updated_at' => NOW_TIME,
				'login_ip' => get_client_ip()
			];
			$this->save($data);
			session("uid", $user['id']);
			session("uname", $user['username']);
			session("login_time", $login_time);
			session("login_ip",$login_ip);
			return true;
		}
		return false;
	}
}