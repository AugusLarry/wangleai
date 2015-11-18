<?php
namespace Admin\Model;
use Think\Model;
class PropertyModel extends Model
{
	protected $fields = ['id', 'property', 'status', '_pk' => 'id'];
	protected $_validate = [
		['property', 'require', '属性名不能为空!'],
		['status', 'require', '属性状态不能为空!'],
		['property', '2,6', '属性名只能在2到6个字符之间!', 2, 'length']
	];
	protected $_auto = [
		['status', 1]
	];
}