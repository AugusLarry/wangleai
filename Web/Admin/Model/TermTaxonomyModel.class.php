<?php
namespace Admin\Model;
use Think\Model\RelationModel;
class TermTaxonomyModel extends RelationModel
{
	protected $fields = ['term_taxonomy_id', 'term_id', 'taxonomy', 'description', 'parent', 'count', '_pk' => 'term_taxonomy_id'];

	protected $_validate = [
		['term_id', 'require', '链接id不能为空'],
		['taxonomy', 'require', '链接类型不能为空'],
	];

	protected $_auto = [
		['count', '0']
	];
}