<?php
namespace Admin\Model;
use Think\Model\RelationModel;
class PostsModel extends RelationModel
{
	protected $fields = ['id', 'post_author', 'created_at', 'post_title', 'post_type', 'post_description', 'post_content', 'post_status', 'comment_status', 'comment_count', 'click_count', '_pk' => 'id'];
	protected $_link = [
		"Terms" => [
			'mapping_type' => self::MANY_TO_MANY,
			'class_name' => 'Terms',
			'mapping_name' => 'terms',
			'foreign_key' => 'post_id',
			'relation_foreign_key' => 'term_id',
			'relation_table' => 'wla_post_term',
		],
		"Property" => [
			'mapping_type' => self::MANY_TO_MANY,
			'class_name' => 'Property',
			'mapping_name' => 'property',
			'foreign_key' => 'post_id',
			'relation_foreign_key' => 'property_id',
			'relation_table' => 'wla_post_property',
		],
	];
}