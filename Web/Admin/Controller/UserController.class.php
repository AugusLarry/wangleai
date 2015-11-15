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
		$user = D("User");
		$page = getpage($user, "", I("get.onepagenum", C("PAGE_SIZE")));
		$this->show = $page->show();
		$fields = ['id', 'username', 'email', 'updated_at', 'login_ip', 'status'];
		$this->user = $user->field($fields)->order('id desc')->limit($page->firstRow.','.$page->listRows)->select();
		$this->display();
	}

	//用户详情
	public function details()
	{
		if (!IS_GET || I("get.id") == "") $this->error("访问出错!", U("Admin/Index/index"));
		$auth = new \Think\Auth();
		$this->group = current($auth->getGroups(I("get.id")));
		$this->user = D("User")->where(['id' => I("get.id")])->find();
		if (!$this->user) $this->error("访问出错!", U("Admin/Index/index"));
		$active = M("ActiveRecord");
		$page = getpage($active, ['uid' => I("get.id")], I("get.onepagenum", C("PAGE_SIZE")));
		$this->show = $page->show();
		$this->active = $active->where(['uid' => I("get.id")])->order('id desc')->limit($page->firstRow.','.$page->listRows)->select();
		$this->display();
	}

	//添加用户
	public function addUser()
	{
		$this->group = D("AuthGroup")->order('id desc')->select();
		$this->display();
	}

	//添加用户表单
	public function addUserForm()
	{
		if (!IS_POST || empty(I("post."))) $this->error("访问出错", U('details'));
		$user = D("User");
		if ($user->create(I("post."), 1) && $user->addUser()) {
			$this->success("添加成功", U("index"));
		} else {
			$this->error($user->getError(), U("Login/index"));
		}
	}

	//修改用户
	public function updateUser()
	{
		if (!IS_GET || I("get.id") == "") $this->error("访问出错!", U("details"));
		$this->user = D("User")->where(['id' => I("get.id")])->find();
		if (!$this->user) $this->error("访问出错!", U("Admin/Index/index"));
		$this->group = D("AuthGroup")->order('id desc')->select();
		$this->group_id = M("AuthGroupAccess")->where(['uid' => $this->user['id']])->getField("group_id");
		$this->display();
	}

	//修改用户表单
	public function updateUserForm()
	{
		if (!IS_POST || empty(I("post."))) $this->error("访问出错!", U("Admin/Index/index"));
		$user = D("User");
		if (!$user->create(I("post."), 2)) {
			$this->error($user->getError(), U("Admin/User/details", ['id' => I("post.id")]));
		} else {
			$user->save();
			$data = ['group_id' => I("post.group")];
			M("AuthGroupAccess")->where(['uid' => I("post.id")])->save($data);
			$this->success("修改成功", U("Admin/User/details", ['id' => I("get.id")]));
		}
	}

	//删除用户
	public function deleteUser()
	{
		if (!IS_GET || I("get.id") == "") $this->error("访问出错!", U("details"));
		$user = D("User")->where(['id' => I("get.id")])->find();
		if (!$user) $this->error("访问出错!", U("details"));
		if ($user['status'] == 10) $this->error("该用户为启用状态,请先修改用户状态再删除!", U("details", ['id' => I("get.id")]), 5);
		if (!D("User")->deleteUserAndThisGroup(I("get.id"))){
			$this->error($user->getError(), U("Admin/User/details", ['id' => I("get.id")]));
		} else {
			$this->success("成功删除该用户!", U("Admin/User/index"));
		}
	}

	//角色列表
	public function group()
	{
		$group = D("AuthGroup");
		$page = getpage($group, "", I("get.onepagenum", C("PAGE_SIZE")));
		$this->show = $page->show();
		$this->group = $group->order('id desc')->limit($page->firstRow.','.$page->listRows)->select();
		$this->display();
	}

	//添加角色
	public function addGroup()
	{
		$this->rule = D("AuthRule")->field(['id', 'title'])->order('id desc')->select();
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
		if (!IS_GET || I("get.id") == "") $this->error("访问出错!", U("Admin/Index/index"));
		$group = D("AuthGroup")->where(['id' => I("get.id")])->find();
		if (!$group) $this->error("访问出错!", U("Admin/Index/index"));
		$group["rules"] = explode(",", $group["rules"]);
		$this->rule = D("AuthRule")->where(['status' => 1])->field(['id', 'title'])->order('id desc')->select();
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

	//规则列表
	public function rule()
	{
		$rule = D("AuthRule");
		$page = getpage($rule, "", I("get.onepagenum", C("PAGE_SIZE")));
		$this->show = $page->show();
		$this->rule = $rule->order('id desc')->limit($page->firstRow.','.$page->listRows)->select();
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
		if (!IS_GET || I("get.id") == "") $this->error("访问出错!", U("Admin/Index/index"));
		$this->rule = D("AuthRule")->where(['id' => I("get.id")])->find();
		if (!$this->rule) $this->error("访问出错!", U("Admin/Index/index"));
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

	//上传头像
	public function upload()
	{
		if (!IS_AJAX || empty(I("post."))) $this->error("非法访问", U('index'));
		$config = [
			'mimes'        => C("mimes"),
		    'maxSize'      => C("maxSize"),
		    'exts'         => C("exts"),
		    'autoSub'      => C("autoSub"),
		    'subName'      => C("subName"),
		    'rootPath'     => C("rootPath"),
		    'savePath'     => C("savePath"),
		    'saveName'     => C("saveName"),
		    'saveExt'      => C("saveExt"),
		    'replace'      => C("replace"),
		    'hash'         => C("hash"),
		    'callback'     => C("callback"),
		    'driver'       => C("driver"),
		    'driverConfig' => C("driverConfig"),
		];
		$upload = new \Think\Upload($config);// 实例化上传类
		$upload->maxSize = 1024*1021*5;//设置上传大小为5M
		$upload->exts = ['jpg', 'gif', 'png', 'jpeg'];//设置上传文件后缀
		$upload->savePath = 'avatar/';//设置保存目录
		$info = $upload->uploadOne($_FILES['upload']);
		if (!$info) {
			$this->error($upload->getError(), "", true);
		} else {
			$avatar = ltrim($upload->rootPath . $info['savepath'] . $info['savename'], ".");
			$this->success($avatar, "", true);
		}
	}
}