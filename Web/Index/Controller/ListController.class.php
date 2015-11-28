<?php
namespace Index\Controller;
use Think\Controller;
/**
 * 列表页控制器
 */
class ListController extends Controller
{
    public function index()
    {
    	if (!IS_GET || I("get.") == "") $this->error("访问出错!", U("/Index/"));
    	$parentid = implode(",", array_column(M("Terms")->where(['parent' => I("get.id")])->select(), "id"));
		$articles_id = implode(",", array_column(M("PostTerm")->where(['term_id' => ['in', $parentid . "," . I("get.id")]])->select(), "post_id"));
		$posts = D("Posts");
		$where = [
			'id' => ['in', $articles_id],
		];
		//对文章列表分页显示
		$page = getPageForIndex($posts, $where, I("get.onepagenum", C("PAGE_SIZE")));
		//获取分页标签
		$this->show = $page->show();
		//获取分页后的数据
		$posts = $posts->relation(true)->where($where)->order('created_at desc')->limit($page->firstRow.','.$page->listRows)->select();
		foreach ($posts as $key => $val) {
			foreach ($val['terms'] as $k => $v) {
				if ($v['taxonomy'] == 0) {
					$posts[$key]['category'][0]['id'] = $v['id'];
					$posts[$key]['category'][0]['name'] = $v['name'];
				}
				if ($v['taxonomy'] == 1) {
					$posts[$key]['tags'][] = [
						'id' => $v['id'],
						'name' => $v['name']
					];
				}
			}
			unset($posts[$key]['terms']);
			unset($posts[$key]['property']);
		}
		$this->posts = $posts;
    	$this->display();
    }
}