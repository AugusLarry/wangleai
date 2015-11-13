<?php
namespace Admin\Model;
use Think\Model;
class AuthRuleModel extends Model
{
	protected $_validate = [
		['name', 'require', '必须填写规则唯一标识'],
		['title', 'require', '必须填写规则中文描述'],
		['name', '', '已经存在相同的规则,请重新填写', 0, 'unique', 1],
	];
}