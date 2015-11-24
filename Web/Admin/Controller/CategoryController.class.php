<?php
namespace Admin\Controller;
use Admin\Controller\CommonController;
/**
 * 分类控制器
 */
class CategoryController extends CommonController
{
	//分类列表视图
	public function index()
	{
		//实例化详情模型
		$category = M("Terms");
		//对用户列表分页显示
		$page = getpage($category, ['taxonomy' => 0], I("get.onepagenum", C("PAGE_SIZE")));
		//获取分页标签
		$this->show = $page->show();
		//获取分页后的数据
		$category = $category->where(['taxonomy' => 0])->order('sort')->limit($page->firstRow.','.$page->listRows)->select();
		//加载无限级分类类库
		vendor('myClass.Category', "", ".php");
		$this->category = \Category::unlimitedForLevel($category, "<i class='fa fa-long-arrow-right'>&nbsp;</i>");
		$this->display();
	}

	//标签列表视图
	public function tags()
	{
		//实例化详情模型
		$tags = M("Terms");
		//对用户列表分页显示
		$page = getpage($tags, ['taxonomy' => 1], I("get.onepagenum", C("PAGE_SIZE")));
		//获取分页标签
		$this->show = $page->show();
		//获取分页后的数据
		$this->tags = $tags->where(['taxonomy' => 1])->limit($page->firstRow.','.$page->listRows)->select();
		$this->display();
	}

	//排序
	public function sort()
	{
		if (!IS_POST || empty(I("post."))) $this->error("访问出错", U('index'));
		foreach(I("post.") as $k => $v) {
			D("Terms")->where(['id' => $k])->setField('sort', $v);
		}
		$this->redirect("index");
	}

	//添加分类视图
	public function addCategory()
	{
		$this->parent = I("get.parent", 0, "intval");
		$this->display();
	}

	//添加标签视图
	public function addTag()
	{
		$this->display();
	}

	//添加分类表单
	public function addCategoryForm()
	{
		if (!IS_POST || empty(I("post."))) $this->error("访问出错", U('index'));
		$model = D("Terms");
		if (!$model->create()) {
			$this->error($model->getError(), U("index"));
		} else {
			$result = $model->add();
			if (!$result) {
				$this->error($model->getError(), U("index"));
			} else {
				$this->success("添加成功!", U("index"));
			}
		}
	}

	//添加标签表单
	public function addTagForm()
	{
		if (!IS_POST || empty(I("post."))) $this->error("访问出错", U('index'));
		$model = D("Terms");
		if (!$model->create()) {
			$this->error($model->getError(), U("tags"));
		} else {
			$result = $model->add();
			if (!$result) {
				$this->error($model->getError(), U("tags"));
			} else {
				$this->success("添加成功!", U("tags"));
			}
		}
	}

	//修改分类视图
	public function updateCategory()
	{
		if (!IS_GET || I("get.id") == "") $this->error("访问出错!", U("index"));
		$this->category = M("Terms")->where(['id' => I("get.id")])->find();
		if (!$this->category) $this->error("访问出错!", U("index"));
		$this->display();
	}

	//修改标签视图
	public function updateTag()
	{
		if (!IS_GET || I("get.id") == "") $this->error("访问出错!", U("index"));
		$this->tag = M("Terms")->where(['id' => I("get.id")])->find();
		if (!$this->tag) $this->error("访问出错!", U("index"));
		$this->display();
	}

	//修改分类表单
	public function updateCategoryForm()
	{
		if (!IS_POST || empty(I("post."))) $this->error("访问出错", U('index'));
		$model = D("Terms");
		if (!$model->create()) {
			$this->error($model->getError(), U("index"));
		} else {
			$result = $model->save();
			if ($result === false) {
				$this->error($model->getError(), U("index"));
			} else {
				$this->success("修改成功!", U("index"));
			}
		}
	}

	//修改标签表单
	public function updateTagForm()
	{
		if (!IS_POST || empty(I("post."))) $this->error("访问出错", U('index'));
		$model = D("Terms");
		$model = D("Terms");
		if (!$model->create()) {
			$this->error($model->getError(), U("tags"));
		} else {
			$result = $model->save();
			if ($result === false) {
				$this->error($model->getError(), U("tags"));
			} else {
				$this->success("修改成功!", U("tags"));
			}
		}
	}

	//删除分类
	public function deleteCategory()
	{
		if (!IS_GET || I("get.id") == "") $this->error("访问出错!", U("index"));
		$model = M("Terms");
		$category = $model->where(['id' => I("get.id")])->find();
		if (!$category) $this->error("访问出错!", U("index"));
		$parent = $model->where(['parent' => I("get.id")])->find();
		$articles = M("PostTerm")->where(['term_id' => I("get.id")])->select();
		if ($parent) {
			$this->error("该分类下还有子分类,请先删除子分类再试!", U("index"));
		} elseif ($articles) {
			$this->error("该分类下还有文章,请先删除文章或移动到另一个分类再试!", U("index"));
		} else {
			$result = $model->where(['id' => I("get.id")])->delete();
			if (!$result) {
				$this->error("删除失败!请稍后再试!", U("index"));
			} else {
				$this->success("删除成功!", U("index"));
			}
		}
	}

	//删除标签
	public function deleteTag()
	{
		if (!IS_GET || I("get.id") == "") $this->error("访问出错!", U("index"));
		$tag = M("Terms")->where(['id' => I("get.id")])->find();
		if (!$tag) $this->error("访问出错!", U("index"));
		$articles = M("PostTerm")->where(['term_id' => I("get.id")])->select();
		if ($articles) {
			$this->error("已有文章使用该标签,请先删除该文章里的本标签再试!", U("index"));
		}
		$result = M("Terms")->where(['id' => I("get.id")])->delete();
		if (!$result) {
			$this->error("删除失败!请稍后再试!", U("tags"));
		} else {
			$this->success("删除成功!", U("tags"));
		}
	}
}