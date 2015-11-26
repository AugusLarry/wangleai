<?php
namespace Index\Controller;
use Think\Controller;
/**
 * 首页控制器
 */
class ShowController extends Controller
{
    public function index()
    {
    	if (!IS_GET || I("get.") == "") $this->error("访问出错!", U("Admin/Category/index"));
    	$this->post = M("Posts")->where(['id' => I("get.id")])->find();
    	$this->display();
    }

    public function addComment()
    {
    	if (!IS_AJAX || empty(I("post."))) $this->error("访问出错", U('/Index/'));
    	p(I("post."));die;
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
    		"comment_parent" => I("parent", "", "intval"),
    		"user_id" => I("uid", "", "intval")
    	];
    	$model = D("Comments");
    	if (!$model->create($data)) {
    		$this->error($model->getError(), U("/Index/" . I("post.post_id")), true);
    	} else {
    		M("Posts")->where(['id' => I("post.post_id")])->setInc("comment_count");
    		$this->success("评论已提交,请等待管理员审核!", U("/Index/" . I("post.post_id")), true);
    	}
    }
}