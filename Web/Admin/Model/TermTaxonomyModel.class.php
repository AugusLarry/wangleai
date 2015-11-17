<?php
namespace Admin\Model;
use Think\Model\RelationModel;
class TermTaxonomyModel extends RelationModel
{
	protected $fields = ['term_taxonomy_id', 'tid', 'taxonomy', 'description', 'parent', 'count', '_pk' => 'term_taxonomy_id'];
	protected $_link = [
		'Terms' => [
			'mapping_type' => self::BELONGS_TO,//关联关系BELONGS_TO表示当前这个详细信息模型属于terms表
			'class_name' => 'Terms',//关联另一个模型的类名,不需要存在模型类
			'mapping_name' => 'Terms',//关联映射名称(在关联另一张表中查询出的结果中以什么键值显示,不可与当前模型字段冲突)
			'foreign_key' => 'tid',//关联外键名称(当前模型的外键)
			'as_fields' => 'id,name,slug',//将关联的另一个模型字段映射成当前模型的字段
		],
	];
}