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
		//实例化详情模型
		$posts = D("Posts");
		//对用户列表分页显示
		$page = getpage($posts, "", I("get.onepagenum", C("PAGE_SIZE")));
		//获取分页标签
		$this->show = $page->show();
		//获取分页后的数据
		$posts = $posts->relation(true)->where('post_status<>2')->order('id')->limit($page->firstRow.','.$page->listRows)->select();
		// p($posts);
		foreach ($posts as $key => $val) {
			foreach ($val['terms'] as $k => $v) {
				if ($v['taxonomy'] == 0) {
					$posts[$key]['category'][0]['id'] = $v['id'];
					$posts[$key]['category'][0]['name'] = $v['name'];
				}
				if ($v['taxonomy'] == 1) {
					$posts[$key]['tags'][] = $v['name'];
				}
			}
			unset($posts[$key]['terms']);
			unset($posts[$key]['property']);
		}
		$this->posts = $posts;
		$this->display();
	}

	//添加文章
	public function addArticle()
	{
		$model = D("Terms");
		$category = $model->where(['taxonomy' => 0])->select();
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
		$tags = D("Terms")->where(['taxonomy' => 1])->where("name like '%".$wd."%' or slug like '%".$wd."%' ")->select();
		foreach($tags as $v){
        	$suggestions[]= array('title' => $v['name']);
        }
		echo json_encode(array('data' => $suggestions));
	}

	//添加文章表单
	public function addArticleForm()
	{
		if (!IS_POST || empty(I("post."))) $this->error("访问出错", U('index'));
		//先组合POSTS表数据
		$data = [
			'post_author' => I("post.post_author", "", "htmlspecialchars"),
			'created_at' => NOW_TIME,
			'post_title' => I("post.post_title", "", "htmlspecialchars"),
			'post_type' => I("post.post_type", 0, "intval"),
			'post_description' => I("post.post_description", "", "htmlspecialchars"),
			'post_content' => I("post.post_content", "", "htmlspecialchars"),
			'post_status' => I("post.status", 0, "intval"),
			'comment_status' => I("post.comment_status", 0, "intval"),
			'comment_count' => 0,
			'click_count' => 0,
		];
		p($_POST);die;
		//如果存在标签
		if (isset($_POST['tags'])) {
			//将表单里标签最后一个","去掉并分割成数组
			$tags = explode(",", rtrim(trim(I("post.tags")), ","));
			//查询出所有的标签
			$model = D("Terms")->where(['taxonomy' => 1])->select();
			//$TagsData(设置要插入标签的数据);$Tids(设置所有添加标签的ID)
			$TagsData = $Tids = [];
			//如果还没有标签
			if (!$model) {
				foreach ($tags as $k => $v) {//直接循环插入Terms表
					$TagsData['name'] = $v;
					$TagsData['slug'] = $v;
					$TagsData['sort'] = 0;
					$TagsData['taxonomy'] = 1;
					$TagsData['description'] = "";
					$TagsData['parent'] = 0;
					$TagsData['term_count'] = 1;
					$Tids[] = M("Terms")->data($TagsData)->add();
				}
			} else {
				// 取出所有的标签名
				$TagsName = array_column($model, 'name');
				foreach ($tags as $v) {//循环表单提交过来的标签名
					if (in_array($v, $TagsName)){//如果该标签已存在,将该标签count值加1
						$id = M("Terms")->where(['name' => $v])->getField("id");
						M("Terms")->where(['id' => $id])->setInc('term_count');
						$Tids[] = $id;
					} else {//如果该标签不存在,组合该标签数据并插入Terms表
						$TagsData['name'] = $v;
						$TagsData['slug'] = $v;
						$TagsData['sort'] = 0;
						$TagsData['taxonomy'] = 1;
						$TagsData['description'] = "";
						$TagsData['parent'] = 0;
						$TagsData['term_count'] = 1;
						$Tids[] = M("Terms")->data($TagsData)->add();
					}
				}
			}//这里返回所有表单提交的标签ID
			//这里组合标签数据到$data中
			//注意组合格式应该是一个二维数组
			//terms => [//terms是data数组的一个子元素,而terms的子元素必须是索引数组
			//	0 => ['id' => id]//每个索引数组的键为terms表的主键ID
			//	1 => ['id' => id]
			//]
			foreach ($Tids as $k => $v) {
				$data['terms'][$k]['id'] = $v;
			}
		}
		//如果存在属性
		if (isset($_POST['property'])){
			foreach ($_POST['property'] as $v) {
				//这里组合方式跟上面terms一样
				$data['property'][]['id'] = $v;
			}
		}
		//将分类ID组合进data数组
		$data['terms'][]['id'] = I("post.post_category", "", "intval");
		//将该分类count加一
		M("Terms")->where(['id' => I("post.post_category")])->setInc("term_count");
		//多对多插入
		$result = D("Posts")->relation(true)->add($data);
		if ($result === false) {
			$this->error("添加失败!", U("index"));
		} else {
			$this->success("添加成功!", U("index"));
		}
	}

	//修改文章
	public function updateArticle()
	{
		if (!IS_GET || I("get.id") == "") $this->error("访问出错!", U("index"));
		$post = D("Posts")->relation(true)->where(['id' => I("get.id")])->find();
		if (!$post) $this->error("访问出错!", U("index"));
		$tags = $attr = [];
		foreach ($post as $key => $val) {
			if ($key == "terms") {
				foreach ($val as $k => $v) {
					if ($v['taxonomy'] == 0) {
						$post['category'] = $v['id'];
					}
					if ($v['taxonomy'] == 1) {
						$tags[] = $v['name'];
					}
				}
			}
			if ($key == "property") {
				foreach ($val as $k => $v) {
					$attr[] = $v['id'];
				}
			}
			unset($post['terms']);
			unset($post['property']);
		}
		$this->post = $post;
		$this->tags = $tags;
		$this->attr = $attr;
		$category = M("Terms")->where(['taxonomy' => 0])->select();
		vendor('myClass.Category', "", ".php");
		$this->category = \Category::unlimitedForLevel($category, "--");
		$this->property = M("Property")->select();
		$this->display();
	}

	//修改文章表单
	public function updateArticleForm()
	{
		if (!IS_POST || empty(I("post."))) $this->error("访问出错", U('index'));
		$post = M("Posts");
		$created_at = $post->where(['id' => I("post.id")])->getField("created_at");
		$comment_count = $post->where(['id' => I("post.id")])->getField("comment_count");
		$click_count = $post->where(['id' => I("post.id")])->getField("click_count");
		//先组合POSTS表数据
		$data = [
			'post_author' => I("post.post_author", "", "htmlspecialchars"),
			'created_at' => $created_at,
			'post_title' => I("post.post_title", "", "htmlspecialchars"),
			'post_type' => I("post.post_type", 0, "intval"),
			'post_description' => I("post.post_description", "", "htmlspecialchars"),
			'post_content' => I("post.post_content", "", "htmlspecialchars"),
			'post_status' => I("post.status", 0, "intval"),
			'comment_status' => I("post.comment_status", 0, "intval"),
			'comment_count' => $comment_count,
			'click_count' => $click_count,
		];
		$term = M("Terms");
		//如果存在标签
		if (isset($_POST['tags']) && !empty($_POST['tags'])) {
			//将表单里标签最后一个","去掉并分割成数组
			$tags = explode(",", rtrim(trim(I("post.tags")), ","));
			//查询出所有的标签
			$model = D("Terms")->where(['taxonomy' => 1])->select();
			//$TagsData(设置要插入标签的数据);$Tids(设置所有添加标签的ID)
			$TagsData = $Tids = [];
			//如果还没有标签
			if (!$model) {
				foreach ($tags as $k => $v) {//直接循环插入Terms表
					$where = [
						'taxonomy' => 1,
						'name' => $v
					];
					$TagsData['name'] = $v;
					$TagsData['slug'] = $v;
					$TagsData['sort'] = 0;
					$TagsData['taxonomy'] = 1;
					$TagsData['description'] = "";
					$TagsData['parent'] = 0;
					$TagsData['term_count'] = $term->where($where)->getField("term_count");
					$Tids[] = M("Terms")->data($TagsData)->add();
				}
			} else {
				// 取出所有的标签名
				$TagsName = array_column($model, 'name');
				//取出之前的标签
				$old_post = D("Posts")->relation("terms")->where(['id' => I("post.id")])->find();
				$old_terms = $old_post['terms'];
				//删除数组中的分类
				foreach ($old_terms as $k => $v) {
					if ($v['taxonomy'] == 0) {
						unset($old_terms[$k]);
					}
				}
				//循环之前的标签
				foreach ($old_terms as $v) {
					if (!in_array($v['name'], $tags)) {//如果之前的标签名不在新提交的标签名里,则将之前的标签count减一
						if (M("Terms")->where(['id' => $v['id']])->getField("term_count") > 0) {
							M("Terms")->where(['id' => $v['id']])->setDec("term_count");
						}
					}
				}
				foreach ($tags as $v) {//循环表单提交过来的标签名
					if (in_array($v, $TagsName)){//如果该标签已存在标签表里
						$id = M("Terms")->where(['name' => $v])->getField("id");
						M("Terms")->where(['id' => $id])->setInc('term_count');
						$Tids[] = $id;
					} else {//如果该标签不存在,组合该标签数据并插入Terms表
						$TagsData['name'] = $v;
						$TagsData['slug'] = $v;
						$TagsData['sort'] = 0;
						$TagsData['taxonomy'] = 1;
						$TagsData['description'] = "";
						$TagsData['parent'] = 0;
						$TagsData['term_count'] = 1;
						$Tids[] = M("Terms")->data($TagsData)->add();
					}
				}
			}//这里返回所有表单提交的标签ID
			//这里组合标签数据到$data中
			//注意组合格式应该是一个二维数组
			//terms => [//terms是data数组的一个子元素,而terms的子元素必须是索引数组
			//	0 => ['id' => id]//每个索引数组的键为terms表的主键ID
			//	1 => ['id' => id]
			//]
			foreach ($Tids as $k => $v) {
				$data['terms'][$k]['id'] = $v;
			}
		}
		//如果存在属性
		if (isset($_POST['property'])){
			foreach ($_POST['property'] as $v) {
				//这里组合方式跟上面terms一样
				$data['property'][]['id'] = $v;
			}
		}
		//表单提交过来的分类ID
		$post_category = I("post.post_category", "", "intval");
		//取出旧的分类ID
		$old_category = I("post.old_category");
		if ($old_category != $post_category) {//如果更换过分类
			$old_count = M("Terms")->where(['id' => $old_category])->getField("term_count");
			if ($old_count >= 1) {
				M("Terms")->where(['id' => $old_category])->setDec("term_count");//将之前分类的count减一
			}
			M("Terms")->where(['id' => $post_category])->setInc("term_count");//将新分类的count加一
		}
		//将分类ID组合进data数组
		$data['terms'][]['id'] = $post_category;
		//多对多更新
		$result = D("Posts")->relation(true)->where(['id' => I("post.id")])->save($data);
		if ($result === false) {
			$this->error("修改失败!", U("index"));
		} else {
			$this->success("修改成功!", U("index"));
		}
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