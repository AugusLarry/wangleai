<?php
namespace Admin\Model;
use Think\Model;
class TermsModel extends Model
{
	protected $fields = ['id', 'name', 'slug', 'sort', 'taxonomy', 'description', 'parent', 'term_count', '_pk' => 'id', '_type' => ['id' => 'bigint', 'name' => 'varchar', 'slug' => 'varchar', 'sort' => 'smallint', 'taxonomy' => 'smallint', 'description' => 'longtext', 'parent' => 'bigint', 'count' => 'bigint']];
	protected $_validate = [
		['name', 'require', '链接名称不能为空!'],
		['slug', 'require', '链接别名不能为空!'],
		['taxonomy', 'require', '链接类型不能为空!'],
		['name', '2,8', '链接名称只能在2-8个字符之间!', 0, 'length', 3],
		['slug', '2,12', '链接别名只能在2-12个字符之间!', 0, 'length', 3],
	];
	protected $_auto = [
		['term_count', 0]
	];
}