<?php
    /**
     * Created by PhpStorm.
     * User: larry
     * Date: 2015/11/29
     * Time: 15:43
     * For:评论控制器
     */
namespace Admin\Controller;
use Admin\Controller\CommonController;
class CommentsController extends CommonController
{
    //评论视图
    public function index()
    {
        $this->comments = D("Comments")->relation(true)->where(['comment_type' =>['lt', 2]])->select();
        $this->display();
    }
}