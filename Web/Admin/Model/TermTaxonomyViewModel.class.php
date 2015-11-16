<?php
namespace Admin\Model;
use Think\Model\ViewModel;
class TermTaxonomyViewModel extends ViewModel
{
	public $viewFields = [
		'term_taxonomy' => ['term_taxonomy_id' => 'id', 'term_id' => 'iid', 'description', 'parent', 'count', '_as' => 'info', '_type' => 'LEFT'],
		'terms' => ['term_id' => 'tid', 'name', 'slug', '_on' => 'info.term_id=terms.term_id'],
	];
}