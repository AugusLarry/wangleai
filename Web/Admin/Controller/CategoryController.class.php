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
}