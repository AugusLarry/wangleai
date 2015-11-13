<?php
namespace Admin\Model;
use Think\Model;
class AuthGroupModel extends Model
{
	protected $_validate = [
		['title', 'require', '必须填写角色名称'],
		['title', '', '已经存在相同的角色,请重新填写', 0, 'unique', 1],
	];

	public function getRuleByGroup($id)
	{
		$group = $this->where(['id' => $id])->find();
		$rule["rules"] = D("AuthRule")->where(['id' => ['in', $group['rules']]], ['status' => 1])->field(['id', 'title'])->select();
		return array_merge($group, $rule);
	}
}