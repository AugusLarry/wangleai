<?php
namespace Common\Model;
use Think\Model;
class CommentsModel extends Model
{
	protected $fields = ['comment_id', 'comment_post_id', 'comment_author', 'comment_author_email', 'comment_author_url', 'comment_author_ip', 'created_at', 'comment_content', 'comment_type', 'comment_agent', 'comment_parent', 'user_id', '_pk' => 'comment_id'];
	protected $_validate = [
		['comment_post_id', 'require', '文章ID不能为空!'],
		['comment_author', 'require', '称呼不能为空!'],
		['comment_author_email', 'require', '邮箱不能为空!'],
		['comment_content', 'require', '评论内容不能为空!'],
		['comment_author', '2,8', '称呼只能在2-8个字符之间!', 0, 'length', 3],
	];
}