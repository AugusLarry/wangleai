<?php
class Category
{
	//组合分类列表(二维数组,视图用)
	public static function unlimitedForLevel($cate, $html = '--', $parent = 0, $level = 0)
	{
		$arr = [];
		foreach ($cate as $v) {
			if ($v['parent'] == $parent) {
				$v['level'] = $level + 1;
				$v['html'] = str_repeat($html, $level);
				$arr[] = $v;
				$arr = array_merge($arr, self::unlimitedForLevel($cate, $html, $v['id'], $level + 1));
			}
		}
		return $arr;
	}

	//组合分类列表(多维数组)
	public static function unlimitedForLayer($cate, $parent = 0)
	{
		$arr = [];
		foreach ($cate as $v) {
			if ($v['parent'] == $parent) {
				$v['child'] = self::unlimitedForLayer($cate, $v['id']);
				$arr[] = $v;
			}
		}
		return $arr;
	}

	//组合评论列表(二维数组)
	public static function unlimitedForComment($comment, $parent = 0, $level = 0)
	{
		$arr = [];
		foreach ($comment as $v) {
			if ($v['comment_parent'] == $parent) {
				$v['level'] = $level;
				$arr[] = $v;
				$arr = array_merge($arr, self::unlimitedForComment($comment, $v['comment_id'], $level + 1));
			}
		}
		return $arr;
	}
}