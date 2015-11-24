<?php
namespace Index\Controller;
use Think\Controller;
/**
 * 首页控制器
 */
class IndexController extends Controller
{
    public function index()
    {
    	//实例化详情模型
		$posts = D("Posts");
		$where = [
			'post_status' => ['neq', 2]
		];
		//对文章列表分页显示
		$page = getPageForIndex($posts, $where, I("get.onepagenum", C("PAGE_SIZE")));
		//获取分页标签
		$this->show = $page->show();
		//获取分页后的数据
		$posts = $posts->relation(true)->where($where)->order('id')->limit($page->firstRow.','.$page->listRows)->select();
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
    	$this->category = M("Terms")->where(['taxonomy' => 0])->select();
    	$this->display();
    }
}