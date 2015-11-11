<?php
namespace Admin\Model;
use Think\Model;
class UserModel extends Model
{
	public $status = 10;
	//定义模型字段
	protected $fields = ['id', 'username', 'email', 'password', 'display_name', 'avatar', 'description', 'status', 'password_reset_key', 'created_at', 'updated_at', 'login_ip'];

	protected $_auto = [
		['created_at', 'time', 1, 'function'],
		['updated_at', 'time', 3, 'function'],
		['status', '1'],
		['login_ip', 'get_client_ip', 3, 'function'],
	];

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

	public function checkPwd()
	{
		$pwd = $this->where(['username' => I("post.username")])->field("password")->find();
		return (!$pwd || $pwd['password'] != md5(I("post.password"))) ? false : true;
	}

	public function checkStatus()
	{
		$status = $this->where(['username' => I("post.username")])->field("status")->find();
		return $status['status'] != $this->status ? false : true;
	}
}