<?php
namespace Admin\TagLib;
use Think\Template\TagLib;
defined('THINK_PATH') or exit();
class Wla extends TagLib
{
	protected $tags = [
		'commentstitle' => ['attr' => '', 'close' => 0]
	];

	public function _commentstitle()
	{
		$model = M("comments");
		$all_count = $model->where(['comment_type' => ['lt', 2]])->count();
		$copending_count = $model->where(['comment_type' => 0])->count();
		$junk_count = $model->where(['comment_type' => 2])->count();
		$trash_count = $model->where(['comment_type' => 3])->count();
		$str = "";
		switch (strtolower(ACTION_NAME)) {
			case 'index':
				$str .= "评论列表($all_count)";
				$str .= "　/　<a href='" . U("copending") . "'>待审评论($copending_count)</a>";
				$str .= "　/　<a href='" . U("junk") . "'>垃圾评论($junk_count)</a>";
				$str .= "　/　<a href='" . U("trash") . "'>回收站($trash_count)</a>";
				break;
			case 'copending':
				$str .= "<a href='" . U("index") . "'>评论列表($all_count)</a>";
				$str .= "　/　待审评论($copending_count)";
				$str .= "　/　<a href='" . U("junk") . "'>垃圾评论($junk_count)</a>";
				$str .= "　/　<a href='" . U("trash") . "'>回收站($trash_count)</a>";
				break;
			case 'junk':
				$str .= "<a href='" . U("index") . "'>评论列表($all_count)</a>";
				$str .= "　/　<a href='" . U("copending") . "'>待审评论($copending_count)</a>";
				$str .= "　/　垃圾评论($junk_count)";
				$str .= "　/　<a href='" . U("trash") . "'>回收站($trash_count)</a>";
				break;
			case 'trash':
				$str .= "<a href='" . U("index") . "'>评论列表($all_count)</a>";
				$str .= "　/　<a href='" . U("copending") . "'>待审评论($copending_count)</a>";
				$str .= "　/　<a href='" . U("junk") . "'>垃圾评论($junk_count)</a>";
				$str .= "　/　回收站($trash_count)";
			default;
		}
		return $str;
	}
}