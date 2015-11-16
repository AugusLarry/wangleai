<?php
namespace Admin\Model;
use Think\Model\RelationModel;
class TermsModel extends RelationModel
{
	protected $fields = ['term_id', 'name', 'slug', '_pk' => 'term_id'];

	protected $_validate = [
		['name', 'require', '分类名称不能为空!'],
		['slug', 'require', '分类别名不能为空!'],
		['name', '2,6', '分类名称长度只能在2-6个字符之间!', 1, 'length'],
		['name', '', '分类名称已存在!', 0, 'unique', 1],
		['slug', '', '分类别名已存在!', 0, 'unique', 1]
	];

	protected $_link = [
		'TermTaxonomy' => [
			'mapping_type' => self::HAS_ONE,
			'class_name' => 'TermTaxonomy',
			'mapping_name' => 'TermTaxonomy',
			'foreign_key' => 'term_id',
			'mapping_key' => 'term_id',
			'as_fields' => 'description,parent'
		],
	];
}