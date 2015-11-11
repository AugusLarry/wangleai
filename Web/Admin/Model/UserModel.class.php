<?php
namespace Admin\Model;
use Think\Model;
class UserModel extends Model
{
	//定义模型字段
	protected $fields = ['id', 'username', 'email', 'password', 'display_name', 'avatar', 'description', 'status', 'password_reset_key', 'created_at', 'updated_at', 'login_ip'];
	//自定义登录自动验证规则
	public $loginRules = [
		['verify', 'require', '验证码不能为空!'],
		['username', 'require', '用户名或邮箱不能为空!'],
		['password', 'require', '密码不能为空!'],
		['password', '6,12', '密码长度在6-12位字符之间', 3, 'length'],
		['verify', 'check_verify', '验证码错误', 1, 'function']
	];
	//自定义注册自动验证规则
	public $registerRules = [
		['username', 'require', '账号不能为空!'],
		['email', 'require', '邮箱不能为空!'],
		['password', 'require', '密码不能为空!'],
		['verify', 'require', '验证码不能为空!'],
		['email', 'email', '不是正确的邮箱格式!'],
	];
}