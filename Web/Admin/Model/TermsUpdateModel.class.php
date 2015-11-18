<?php
namespace Admin\Model;
use Think\Model\RelationModel;
/**
 * 分类表关联更新用模型
 */
class TermsUpdateModel extends RelationModel
{
	protected $tableName = "terms";
	protected $fields = ['id', 'name', 'slug', 'sort', '_pk' => 'id'];
	protected $_link = [
		'TermTaxonomy' => [
			'mapping_type' => self::HAS_ONE,
			'class_name' => 'TermTaxonomy',
			'mapping_name' => 'TermTaxonomy',
			'foreign_key' => 'tid',
			'as_fields' => 'term_taxonomy_id,tid,taxonomy,description,parent,count'
		],
	];
}