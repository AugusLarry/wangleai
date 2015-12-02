<?php
namespace Index\Controller;
/**
 * 内容页控制器
 */
class ShowController extends EmptyController
{
	/**
	 * 内容页视图
	 */
    public function index()
    {
        $model = M("Posts");
        $where = ['id' => I("get.id")];
		if (!($model->where($where)->find())) {
			$this->_empty();
			die;
		}
		//将该文章点击率加1
        $model->where($where)->setInc("click_count");
		/** @var 获取文章 $post */
		$post = $model->where($where)->find();
		$cookie = [
			'author' => cookie(C('COMMENT_COOKIE_PREFIX') . "_comment_author"),
			'email' => cookie(C('COMMENT_COOKIE_PREFIX') . "_comment_author_email"),
			'url' => cookie(C('COMMENT_COOKIE_PREFIX') . '_comment_author_url')
		];
        $article_name = $model->where($where)->getField("post_title");
		$this->assign("post", $post);
		$this->assign("cookie", $cookie);
		$this->assign("article_name", $article_name);
    	$this->display();
    }

	/**
	 * 添加评论表单
	 */
    public function addComment()
    {
    	if (!IS_AJAX || empty(I("post."))) $this->error("访问出错", U('/Index/'));
        $post_id = I("post.post_id", "", "intval");
        $comment_status = M("Posts")->where(['id' => $post_id])->getField("comment_status");
        if (!C("COMMENT_ON") || $comment_status) $this->error("该文章已经关闭评论,请稍后再试!", U("/Index/" . I("post.post_id")), true);
		//如果检测到session,说明已经提交过一次评论
		if (session('?uname')) {
			//获取最后一次评论
			$pre_create_time = M("Comments")->where(['comment_author' => I("post.author")])->order("comment_id desc")->limit(1)->find();
			//如果当前时间小于最后一次评论时间加上系统设置的评论间隔时间,则返回不让评论
			if (NOW_TIME < (C("COMMENT_TIME") + $pre_create_time['created_at'])) {
				$this->error("你评论的太频繁了,请稍后再试!", U("/Index/" . I("post.post_id")), true);
			}
		}
		//组合评论表数据
    	$data = [
    		"comment_post_id" => I("post.post_id", "", "intval"),
    		"comment_author" => I("author", "", "strip_tags"),
    		"comment_author_email" => I("email", "", "strip_tags"),
    		"comment_author_url" => I("url", "", "strip_tags"),
    		"comment_author_ip" => get_client_ip(),
    		"created_at" => NOW_TIME,
    		"comment_content" => I("text", "", "htmlspecialchars"),
    		"comment_type" => 0,
    		"comment_agent" => get_client_browser("|-|"),
    		"comment_parent" => I("parent", 0, "intval"),
    		"user_id" => I("post.uid", "", "intval"),
            "_c" => I("post._c", "", "strip_tags")
    	];
    	$model = D("Comments");
    	if (!$model->create($data)) {
            $this->error($model->getError(), U("/Index/" . I("post.post_id")), true);
    	} else {
            $result = $model->add($data);
            if (!$result) {
                $this->error($model->getError(), U("/Index/" . I("post.post_id")), true);
            } else {
				if (!cookie(C('COMMENT_COOKIE_PREFIX') . '_comment_author') || !session('?uname')) {
					session("uname", $data['comment_author']);
					session("uemail", $data['comment_author_email']);
					session("uurl", $data['comment_author_url']);
					cookie("comment_author", urlencode($data['comment_author']), ['prefix' => C("COMMENT_COOKIE_PREFIX") . "_", 'expire' => 60*60*24*365]);
					cookie("comment_author_email", urlencode($data['comment_author_email']), ['prefix' => C("COMMENT_COOKIE_PREFIX") . "_", 'expire' => 60*60*24*365]);
					cookie("comment_author_url", urlencode($data['comment_author_url']), ['prefix' => C("COMMENT_COOKIE_PREFIX") . "_", 'expire' => 60*60*24*365]);
				}
                $this->success("评论已提交,请等待管理员审核!", U("/Index/" . I("post.post_id")), true);
            }
    	}
    }
}