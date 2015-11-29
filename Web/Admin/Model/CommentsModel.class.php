<?php
    /**
     * Created by PhpStorm.
     * User: larry
     * Date: 2015/11/29
     * Time: 15:26
     * For: 评论关联模型
     */
namespace Admin\Model;
use Think\Model\RelationModel;

class CommentsModel extends RelationModel
{
    protected $fields = ['comment_id', 'comment_post_id', 'comment_author', 'comment_author_email', 'comment_author_url', 'comment_author_ip', 'created_at', 'comment_content', 'comment_type', 'comment_agent', 'comment_parent', 'user_id', '_pk' => 'comment_id'];
    protected $_link = [
        'Posts' => [
            'mapping_type' => self::BELONGS_TO,//与POSTS表关联方式
            'class_name' => 'Posts',//关联表的类名
            'mapping_name' => 'post',//关联表数据外层键值,不能与POSTS表字段重复
            'foreign_key' => 'comment_post_id',//Comments表外键
            'mapping_fields' => 'id,post_title,comment_count',
            'as_fields' => 'id:pid,post_title,comment_count',
        ],
        'User' => [
            'mapping_type' => self::BELONGS_TO,//与User表关联方式
            'class_name' => 'User',//关联表的类名
            'mapping_name' => 'user',//关联表数据外层键值,不能与POSTS表字段重复
            'foreign_key' => 'user_id',//Comments表外键
            'mapping_fields' => 'avatar',
            'as_fields' => 'avatar'
        ],
    ];
}