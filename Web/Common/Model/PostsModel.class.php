<?php
namespace Common\Model;
use Think\Model\RelationModel;
class PostsModel extends RelationModel
{
	protected $fields = ['id', 'post_author', 'created_at', 'post_title', 'post_type', 'post_description', 'post_content', 'post_status', 'comment_status', 'comment_count', 'click_count', '_pk' => 'id'];
	protected $_link = [
		"Terms" => [//标签
			'mapping_type' => self::MANY_TO_MANY,//与POSTS表关联方式
			'class_name' => 'Terms',//关联表的类名
			'mapping_name' => 'terms',//关联表数据外层键值,不能与POSTS表字段重复
			'foreign_key' => 'post_id',//POSTS表外键
			'relation_foreign_key' => 'term_id',//关联表外键
			'relation_table' => 'wla_post_term',//中间表名称
		],
		"Property" => [//属性
			'mapping_type' => self::MANY_TO_MANY,
			'class_name' => 'Property',
			'mapping_name' => 'property',
			'foreign_key' => 'post_id',
			'relation_foreign_key' => 'property_id',
			'relation_table' => 'wla_post_property',
		],
	];
}