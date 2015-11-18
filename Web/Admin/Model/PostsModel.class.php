<?php
namespace Admin\Model;
use Think\Model\RelationModel;
class PostsModel extends RelationModel
{
	protected $fields = ['id', 'post_author', 'created_at', 'post_title', 'post_type', 'post_description', 'post_content', 'post_status', 'comment_status', 'comment_count', 'click_count', '_pk' => 'id'];
	protected $_link = [
		"Property" => [
			'mapping_type' => self::MANY_TO_MANY,
			'class_name' => 'Property',
			'mapping_name' => 'propertys',
			'foreign_key' => 'post_id',
			'relation_foreign_key' => 'property_id',
			'relation_table' => '__POSTS__PROPERTY__'
		],
		"TermsTaxonomy" => [
			'mapping_type' => self::MANY_TO_MANY,
			'class_name' => 'TermsTaxonomy',
			'mapping_name' => 'termstaxonomy',
			'foreign_key' => 'object_id',
			'relation_foreign_key' => 'term_taxonomy_id',
			'relation_table' => 'wla_term_relationships'
		]
	];
}