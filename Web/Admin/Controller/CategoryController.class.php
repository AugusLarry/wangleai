<?php
namespace Admin\Controller;
use Common\Controller\CommonController;
class CategoryController extends CommonController
{
	public function index()
	{
		$this->category = D("TermTaxonomyView")->where(['taxonomy' => 0])->select();
		$this->display();
	}

	public function addCategory()
	{
		$this->parent = D("TermTaxonomyView")->field(['tid', 'name'])->where(['taxonomy' => 0, 'parent' => 0])->select();
		$this->display();
	}

	public function addCategoryForm()
	{
		if (!IS_POST || empty(I("post."))) $this->error("访问出错", U('index'));
		$category = D("Terms");
		$data = [
			'name' => I("post.name"),
			'slug' => I("post.slug"),
			'TermTaxonomy' => [
				'taxonomy' => 0,
				'description' => I("post.description") ? I("post.description") : "",
				'parent' => I("post.parent") ? I("post.parent") : 0,
			]
		];
		if (!$category->relation(true)->add($data)) {
			$this->error($category->getError(), U("index"));
		} else {
			$this->success("添加成功!", U("index"));
		}
	}

	public function updateCategory()
	{
		if (!IS_GET || I("get.id") == "") $this->error("访问出错!", U("index"));
		$this->info = D("Terms")->relation(true)->where(['term_id' => I("get.id")])->find();
		if (!$this->info) $this->error("访问出错!", U("Admin/Index/index"));
		$where = [
			'iid' => ['NEQ', I("get.id")],
			'taxonomy' => ['EQ', 0]
		];
		$this->category = D("TermTaxonomyView")->field(['id', 'iid', 'parent', 'name', 'tid'])->where($where)->select();
		$this->display();
	}

	public function updateCategoryForm()
	{
		if (!IS_POST || empty(I("post."))) $this->error("访问出错", U('index'));
		$category = D("Terms");
		$data = [
			'term_id' => I("post.term_id"),
			'name' => I("post.name"),
			'slug' => I("post.slug"),
			'TermTaxonomy' => [
				'taxonomy' => 0,
				'description' => I("post.description") ? I("post.description") : "",
				'parent' => I("post.parent") ? I("post.parent") : 0,
			]
		];
		if ($category->relation(true)->where(['term_id' => I("post.term_id")])->save($data) === false) {
			$this->error($category->getError(), U("index"));
		} else {
			$this->success("修改成功!", U("index"));
		}
	}
}