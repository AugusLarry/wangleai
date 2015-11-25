<?php
namespace Index\TagLib;
use Think\Template\TagLib;
defined('THINK_PATH') or exit();
class Wla extends TagLib
{
	protected $tags = [
		'navigation' => ['attr' => 'limit,order'],
		'news' => ['attr'=> 'limit,order,field'],
		'crumbs' => ['attr' => 'id,level', 'close' => 0],
	];

	public function _navigation($tag, $content)
	{
		$limit = isset($tag['limit']) ? $tag['limit'] : 10;
		$order = isset($tag['order']) ? $tag['order'] : 'id';
		$str = <<<str
<?php
	\$_nav_cate = M('Terms')->where(['taxonomy' => 0])->order("{$order}")->limit("{$limit}")->select();
	vendor('myClass.Category', "", ".php");
	\$_nav_cate = \Category::unlimitedForLayer(\$_nav_cate);
	foreach (\$_nav_cate as \$_nav_cate_v) :
		extract(\$_nav_cate_v);
		\$url = U('/Index/c_' . \$id);
?>
str;
		$str .= $content;
		$str .= '<?php endforeach;?>';
		return $str;
	}

	public function _news($tag, $content)
	{
		$limit = isset($tag['limit']) ? $tag['limit'] : 10;
		$order = isset($tag['order']) ? $tag['order'] : 'id';
		$field = isset($tag['field']) ? $tag['field'] : "";
		$str = <<<str
<?php
	\$_post_news = M("Posts")->field("{$field}")->order("{$order}")->limit("{$limit}")->select();
	foreach (\$_post_news as \$_post_news_v) :
		extract(\$_post_news_v);
		\$url = U('/Index/' . \$id);
?>
str;
		$str .= $content;
		$str .= '<?php endforeach;?>';
		return $str;
	}

	public function _crumbs($tag)
	{
		$id = I("get.id");
		$level = isset($tag['level']) ? $tag['level'] : "list";
		$str = "<div class='res-nav'><p><a href='/' title='首页'><span>首页</span></a>&nbsp;&nbsp;/&nbsp;&nbsp;";
		switch ($level) {
			case 'show':
				$title = M("Posts")->where(['id' => $id])->getField("post_title");
				$post = D("Posts")->relation("terms")->where(['id' => $id])->find();
				foreach ($post['terms'] as $value) {
					if ($value['taxonomy'] == 0) {
						$post['cate'] = [
							'id' => $value['id'],
							'name' => $value['name'],
							'parent' => $value['parent'],
						];
					}
				}
				unset($post['terms']);
				$parent = M("Terms")->where(['id' => $post['cate']['parent']])->find();
				if (empty($parent)) {
					$cateid = $post['cate']['id'];
					$catename = $post['cate']['name'];
					$str .= "<a href='" . U("/Index/c_" . $cateid) . "' title='" . $catename . "'><span>" . $catename . "</span></a>&nbsp;&nbsp;/&nbsp;&nbsp;<span>" . $post['post_title'] . "</span></p></div>";
				} else {
					$cateid = $post['cate']['id'];
					$catename = $post['cate']['name'];
					$parentid = $parent['id'];
					$parentname = $parent['name'];
					$str .= "<a href='" . U("/Index/c_" . $parentid) . "' title= '" . $parentname . "'><span>" . $parentname . "</span></a>&nbsp;&nbsp;/&nbsp;&nbsp;";
					$str .= "<a href='" . U("/Index/c_" . $cateid) . "' title='" . $catename . "'><span>" . $catename . "</span></a>&nbsp;&nbsp;/&nbsp;&nbsp;";
					$str .= "<span>" . $post['post_title'] . "</span></p></div>";
				}
				return $str;
				break;
			case 'list':
				$cate = M("Terms")->where(['id' => $id])->find();
				$parent = M("Terms")->where(['id' => $cate['parent']])->find();
				if (empty($parent)) {
					$str .= "<span>" . $cate['name'] . "</span></p></div>";
				} else {
					$str .= "<a href='" . U("/Index/c_" . $parent['id']) . "' title='" . $parent['name'] . "'><span>" . $parent['name'] . "</span></a>&nbsp;&nbsp;/&nbsp;&nbsp;<span>" . $cate['name'] . "</span></p></div>";
				}
				return $str;
				break;
			default;
		}
	}
}