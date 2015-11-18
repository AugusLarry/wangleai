<?php
namespace Admin\Model;
use Think\Model\RelationModel;
/**
 * 分类关联查询用模型
 */
class TermsModel extends RelationModel
{
	protected $fields = ['id', 'name', 'slug', 'sort', '_pk' => 'id'];
	protected $_link = [
		'TermTaxonomy' => [
			'mapping_type' => self::HAS_ONE,
			'class_name' => 'TermTaxonomy',
			'mapping_name' => 'TermTaxonomy',
			'foreign_key' => 'tid',
			'condition' => 'taxonomy=0',
			'as_fields' => 'term_taxonomy_id,tid,taxonomy,description,parent,count'
		],
	];
}