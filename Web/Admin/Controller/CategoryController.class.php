<?php
namespace Admin\Controller;
use Common\Controller\CommonController;
/**
 * 分类控制器
 */
class CategoryController extends CommonController
{
	//分类列表视图
	public function index()
	{
		//实例化详情模型
		$category = D("Terms");
		//对用户列表分页显示
		$page = getpage($category, "", I("get.onepagenum", C("PAGE_SIZE")));
		//获取分页标签
		$this->show = $page->show();
		//获取分页后的数据
		$category = $category->relation(true)->order('sort')->limit($page->firstRow.','.$page->listRows)->select();
		//加载无限级分类类库
		vendor('myClass.Category', "", ".php");
		$this->category = \Category::unlimitedForLevel($category, "<i class='fa fa-long-arrow-right'>&nbsp;</i>");
		$this->display();
	}

	//对分类排序
	public function sortCategory()
	{
		if (!IS_POST || empty(I("post."))) $this->error("访问出错", U('index'));
		$db = M("Terms");
		foreach (I("post.") as $id => $sort) {
			$db->where(['id' => $id])->setField('sort', $sort);
		}
		$this->redirect('Admin/Category/index');
	}

	//添加分类
	public function addCategory()
	{
		$this->parent = I('parent', 0, 'intval');
		$this->display();
	}

	//添加分类表单
	public function addCategoryForm()
	{
		if (!IS_POST || empty(I("post."))) $this->error("访问出错", U('index'));
		$data = [
			'name' => I("post.name"),
			'slug' => I("post.slug"),
			'TermTaxonomy' => [
				'taxonomy' => 0,
				'description' => I("description", "", 'htmlspecialchars'),
				'parent' => I("parent", 0, 'intval'),
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

	//修改分类
	public function updateCategory()
	{
		if (!IS_GET || I("get.id") == "") $this->error("访问出错!", U("Admin/Index/index"));
		$this->category = D("Terms")->relation(true)->where(['id' => I("get.id")])->find();
		if (!$this->category) $this->error("访问出错!", U("Admin/Index/index"));
		$this->display();
	}

	//修改分类表单
	public function updateCategoryForm()
	{
		if (!IS_POST || empty(I("post."))) $this->error("访问出错", U('index'));
		$data = [
			'name' => I("post.name"),
			'slug' => I("post.slug"),
			'TermTaxonomy' => [
				'taxonomy' => 0,
				'description' => I("description", "", "htmlspecialchars"),
				'parent' => I("parent", 0, "intval"),
				'count' => I("count", 0, "intval")
			],
		];
		$result = D("TermsUpdate")->relation(true)->where(['id' => I("post.id")])->save($data);
		if (!$result) {
			$this->error("修改失败!", U("index"));
		} else {
			$this->success("修改成功!", U("index"));
		}
	}

	//删除分类
	public function deleteCategory()
	{
		if (!IS_GET || I("get.id") == "") $this->error("访问出错!", U("Admin/Index/index"));
		$category = D("Terms")->relation(true)->where(['id' => I("get.id")])->find();
		if (!$category) $this->error("访问出错!", U("Admin/Index/index"));
		$categorys = M("TermTaxonomy")->where(['parent' => I("get.id")])->getField("tid");
		if (!empty($categorys)) $this->error("该分类下还有子分类,请先删除子分类再试!", U("index"));
		$result = D("TermsUpdate")->relation(true)->delete(I("get.id"));
		if (!$result) {
			$this->error("删除失败!", U("index"));
		} else {
			$this->success("删除成功!", U("index"));
		}
	}
}