<?php
namespace Admin\Model;
use Think\Model\RelationModel;
class TermsModel extends RelationModel
{
	protected $fields = ['term_id', 'name', 'slug', '_pk' => 'id'];
	protected $_link = [
		'TermTaxonomy' => [
			'mapping_type' => self::HAS_ONE,
			'class_name' => 'TermTaxonomy',
			'mapping_name' => 'TermTaxonomy',
			'foreign_key' => 'tid',
		],
	];
}