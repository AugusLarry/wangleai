<?php
namespace Admin\Model;
use Think\Model\RelationModel;
/**
 * 标签关联查询用模型
 */
class TagsModel extends RelationModel
{
	protected $tableName = "term_taxonomy";
	protected $fields = ['term_taxonomy_id', 'tid', 'taxonomy', 'description', 'parent', 'count', '_pk' => 'term_taxonomy_id'];
	protected $_link = [
		'Terms' => [
			'mapping_type' => self::BELONGS_TO,
			'class_name' => 'Terms',
			'mapping_name' => 'Terms',
			'foreign_key' => 'tid',
			'as_fields' => 'id,name,slug,sort'
		],
	];
}