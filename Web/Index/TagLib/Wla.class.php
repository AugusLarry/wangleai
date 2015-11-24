<?php
namespace Index\TagLib;
use Think\Template\TagLib;
defined('THINK_PATH') or exit();
class Wla extends TagLib
{
	protected $tags = [
		'navigation' => ['attr' => 'limit,order'],
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
?>
str;
		$str .= $content;
		$str .= '<?php endforeach;?>';
		return $str;
	}
}