<?php
namespace Admin\Controller;
use Common\Controller\CommonController;
/**
 * 分类控制器
 */
class CategoryController extends CommonController
{
	public function index()
	{
		//实例化详情模型
		$category = D("TermTaxonomy");
		//对用户列表分页显示
		$page = getpage($category, "", I("get.onepagenum", C("PAGE_SIZE")));
		//获取分页标签
		$this->show = $page->show();
		//获取分页后的数据
		$this->category = $category->relation(true)->where(['taxonomy' => 0])->order('term_taxonomy_id desc')->limit($page->firstRow.','.$page->listRows)->select();
		$this->display();
	}

	public function addCategory()
	{
		$this->display();
	}

	public function addCategoryForm()
	{
		if (!IS_POST || empty(I("post."))) $this->error("访问出错", U('index'));
		$data = [
			'name' => I("post.name"),
			'slug' => I("post.slug"),
			'TermTaxonomy' => [
				'taxonomy' => 0,
				'description' => I("post.description") ? I("post.description") : "",
				'parent' => !empty(I("post.parent")) ? I("post.parent") : 0,
				'count' => 0,
			]
		];
		$result = D("Terms")->relation(true)->add($data);
		if (!$result) {
			$this->error("添加失败!", U("index"));
		} else {
			$this->success("添加成功!", U("index"));
		}
	}
}