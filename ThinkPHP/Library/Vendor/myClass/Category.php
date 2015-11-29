<?php
class Category
{
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