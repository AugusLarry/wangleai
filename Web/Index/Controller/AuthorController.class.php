<?php
namespace Index\Controller;
/**
 * 作者控制器
 */
class AuthorController extends EmptyController
{
	public function index()
	{
		$model = D("Posts");
		$where = [
			'post_author' => I("get.id"),
		];
		if (!($model->where($where)->find())) {
			$this->_empty();
			die;
		}
		//对文章列表分页显示
		$page = getPageForIndex($model, $where, I("get.onepagenum", C("PAGE_SIZE")));
		//获取分页标签
		$show = $page->show();
		//获取分页后的数据
		$posts = $model->relation(true)->where($where)->order('created_at desc')->limit($page->firstRow.','.$page->listRows)->select();
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
		}
		$this->assign("show", $show);
		$this->assign("posts", $posts);
    	$this->display();
	}
}