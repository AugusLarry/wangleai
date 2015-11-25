<?php
namespace Index\Controller;
use Think\Controller;
class SearchController extends Controller
{
	public function index()
	{
		if (!I("post.") || empty(I("post."))) $this->display();
		$keyword = I("post.s", "", "htmlspecialchars");
		$this->posts = M("Posts")->where(['name' => $keyword])->select();
		$this->keyword = $keyword;
		$this->display();
	}
}