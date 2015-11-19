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
		$model = D("Tags");
		$category = $model->relation(true)->where(['taxonomy' => 0])->select();
		vendor('myClass.Category', "", ".php");
		$this->category = \Category::unlimitedForLevel($category, "--");
		$this->property = M("Property")->where(['status' => 1])->select();
		$this->display();
	}

	//ajax获取相似标签
	public function getTags()
	{
		$wd = I("post.keyword");
		//实例化详情模型
		$tags = D("Terms")->relation(true)->where("name like '%".$wd."%' or slug like '%".$wd."%' ")->select();
		foreach($tags as $v){
			if ($v['taxonomy'] == "") {
            	$suggestions[]= array('title' => $v['name'], 'id' => $v['id']);
            }
        }
		echo json_encode(array('data' => $suggestions));
	}

	//添加文章表单
	public function addArticleForm()
	{
		if (!IS_POST || empty(I("post."))) $this->error("访问出错", U('index'));
		$data = [
			'post_author' => I("post.post_author", "", "htmlspecialchars"),
			'create_at' => NOW_TIME,
			'post_title' => I("post.post_title", "", "htmlspecialchars"),
			'post_type' => I("post.post_type", 0, "intval"),
			'post_description' => I("post.post_description", "", "htmlspecialchars"),
			'post_content' => I("post.content", "", "htmlspecialchars"),
			'post_status' => I("post.status", 0, "intval"),
			'comment_status' => I("post.comment_status", 0, "intval"),
			'comment_count' => 0,
			'click_count' => 0,
		];
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