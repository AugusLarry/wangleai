<?php
namespace Index\Controller;
class SearchController extends EmptyController
{
	public function index()
	{
		if (!IS_POST) {
			$this->_empty();
			die;
		}
		$keyword = I("post.s", "", "htmlspecialchars");
		if ($keyword == "") {
			$this->error("请输入要查询的内容");
			die;
		}
		$posts = M("Posts")->where(['post_title' => ['like', "%" . $keyword . "%"]])->select();
		$this->assign("posts", $posts);
		$this->assign("keyword", $keyword);
		$this->display();
	}
}