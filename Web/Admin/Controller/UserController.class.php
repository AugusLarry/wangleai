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
		if (!IS_GET) $this->error("访问出错!", U("Admin/Index/index"));
		$this->user = D("User")->where(['id' => I("get.id")])->find();
		$this->group = D("AuthGroup")->where(['status' => 1])->field(['id', 'title'])->select();
		/*p($this->user);
		p($this->group);die;*/
		$this->display();
	}

	//添加用户
	public function addUser()
	{
		
	}

	//规则列表
	public function rule()
	{
		$this->rule = D("AuthRule")->select();
		$this->display();
	}

	//添加规则
	public function addRule()
	{
		$this->display();
	}

	//添加规则表单
	public function addRuleForm()
	{
		$rule = D("AuthRule");
		if (!$rule->create(I("post."))) {
			$this->error($rule->getError(), U("Admin/User/addRule"));
		} else {
			$rule->data(I("post."))->add();
			$this->success("添加成功", U("Admin/User/rule"));
		}
	}

	//修改规则
	public function updateRule()
	{
		if (!IS_GET) $this->error("访问出错!", U("Admin/Index/index"));
		$this->rule = D("AuthRule")->where(['id' => I("get.id")])->find();
		$this->display();
	}

	//修改规则表单
	public function updateRuleForm()
	{
		if (!IS_POST || empty(I("post."))) $this->error("访问出错!", U("Admin/Index/index"));
		$rule = D("AuthRule");
		if (!$rule->create(I("post."))) {
			$this->error($rule->getError(), U("Admin/User/updateRule", ['id' => I("post.id")]));
		} else {
			$rule->data(I("post."))->save();
			$this->success("修改成功", U("Admin/User/rule"));
		}
	}

	//角色列表
	public function group()
	{
		$this->group = D("AuthGroup")->select();
		$this->display();
	}

	//添加角色
	public function addGroup()
	{
		$this->rule = D("AuthRule")->field(['id', 'title'])->select();
		$this->display();
	}

	//添加角色表单
	public function addGroupForm()
	{
		if (!IS_POST || empty(I("post."))) $this->error("访问出错!", U("Admin/Index/index"));
		$group = D("AuthGroup");
		$data = I("post.");
		$data['rules'] = implode(",", $data['rules']);
		if (!$group->create($data)) {
			$this->error($group->getError(), U("Admin/User/addGroup"));
		} else {
			$group->data($data)->add();
			$this->success("添加成功", U("Admin/User/group"));
		}
	}

	//修改角色
	public function updateGroup()
	{
		if (!IS_GET) $this->error("访问出错!", U("Admin/Index/index"));
		$group = D("AuthGroup")->where(['id' => I("get.id")])->find();
		$group["rules"] = explode(",", $group["rules"]);
		$this->rule = D("AuthRule")->where(['status' => 1])->field(['id', 'title'])->select();
		$this->group = $group;
		$this->display();
	}

	//修改角色表单
	public function updateGroupForm()
	{
		if (!IS_POST || empty(I("post."))) $this->error("访问出错!", U("Admin/Index/index"));
		$group = D("AuthGroup");
		$data = I("post.");
		$data['rules'] = implode(",", $data['rules']);
		if (!$group->create($data)) {
			$this->error($group->getError(), U("Admin/User/updateRule", ['id' => I("post.id")]));
		} else {
			$group->data($data)->save();
			$this->success("修改成功", U("Admin/User/group"));
		}
	}
}