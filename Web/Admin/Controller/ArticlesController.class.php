<?php
namespace Admin\Controller;
use Common\Controller\CommonController;
/**
 * 文章控制器
 */
class ArticlesController extends CommonController
{
	//文章列表
	public function index()
	{
		$this->display();
	}

	//添加文章
	public function addArticle()
	{
		$category = D("Terms")->relation(true)->select();
		vendor('myClass.Category', "", ".php");
		$this->category = \Category::unlimitedForLevel($category, "--");
		$this->property = M("Property")->where(['status' => 1])->select();
		$this->display();
	}

	//添加文章表单
	public function addArticleForm()
	{
		p($_POST);
	}

	//属性列表
	public function property()
	{
		$this->property = M("Property")->select();
		$this->display();
	}

	//添加属性
	public function addProperty()
	{
		$this->display();
	}

	//添加属性表单
	public function addPropertyForm()
	{
		if (!IS_POST || empty(I("post."))) $this->error("访问出错", U('index'));
		$property = D("Property");
		if (!$property->create()) {
			$this->error($property->getError(), U("property"));
		} else {
			$property->add();
			$this->success("添加成功!", U("property"));
		}
	}

	//修改属性
	public function updateProperty()
	{
		if (!IS_GET || I("get.id") == "") $this->error("访问出错!", U("index"));
		$this->property = M("Property")->where(['id' => I("get.id")])->find();
		if (!$this->property) $this->error("访问出错!", U("property"));
		$this->display();
	}

	//修改属性表单
	public function updatePropertyForm()
	{
		if (!IS_POST || empty(I("post."))) $this->error("访问出错", U('index'));
		$property = D("Property");
		if (!$property->create()) {
			$this->error($property->getError(), U("property"));
		} else {
			$property->save(I("post."));
			$this->success("修改成功!", U("property"));
		}
	}
}