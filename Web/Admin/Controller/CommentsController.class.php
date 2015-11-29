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
        $comments = D("Comments");
        $where = [
            'comment_type' => ['lt', 2]
        ];
        $page = getpage($comments, $where, I("get.onepagenum", C("PAGE_SIZE")));
        $this->show = $page->show();
        $this->comments = $comments->relation(true)->where($where)->order("comment_id desc")->limit($page->firstRow.','.$page->listRows)->select();
        $this->display();
    }

    //批准/驳回/垃圾/扔到回收站
    public function audit()
    {
        if (!IS_GET || I("get.id") == "") $this->error("访问出错!", U("index"));
        //获取类型(0驳回1批准2垃圾3回收)
        $type = I("get.type");
        //获取id
        $comment_id = I("get.id");
        $model = M("Comments");
        //获取子评论
        $parent = $model->where(['comment_parent' => $comment_id])->count();
        if ($parent) $this->error("该评论下还有子评论,请先删除该子评论", U("Admin/Comments/index"));
        //获取当前类型
        $comment_type = $model->where(['comment_id' => $comment_id])->getField("comment_type");
        //更改类型
        $result = $model->where(['comment_id' => $comment_id])->setField("comment_type", $type);
        //获取文章id
        $post_id = $model->where(['comment_id' => $comment_id])->getField("comment_post_id");
        //获取文章已审核的评论数量
        $comment_count = M("Posts")->where(['id' => $post_id])->getField("comment_count");
        if (!$result) {
            $this->error("操作失败,请稍后再试!", U("Admin/Comments/index"));
        } else {
            $str = "";
            switch ($type) {
                case '0':
                    $str = "驳回成功!";
                    if ($comment_count > 0 && $comment_type == 1) M("Posts")->where(['id' => $post_id])->setDec("comment_count");
                    break;
                case '1':
                    $str = "批准成功!";
                    M("Posts")->where(['id' => $post_id])->setInc("comment_count");
                    break;
                case '2':
                    $str = "已设置为垃圾评论!";
                    if ($comment_count > 0 && $comment_type == 1) M("Posts")->where(['id' => $post_id])->setDec("comment_count");
                    break;
                case '3':
                    $str = "已扔至回收站!";
                    if ($comment_count > 0 && $comment_type == 1) M("Posts")->where(['id' => $post_id])->setDec("comment_count");
                    break;
                default;
            }
            $this->success($str, U("Admin/Comments/index"));
        }
    }

    //待审评论
    public function copending()
    {
        $comments = D("Comments");
        $where = [
            'comment_type' => "0"
        ];
        $page = getpage($comments, $where, I("get.onepagenum", C("PAGE_SIZE")));
        $this->show = $page->show();
        $this->comments = $comments->relation(true)->where($where)->order("comment_id desc")->limit($page->firstRow.','.$page->listRows)->select();
        $this->display("index");
    }

    //垃圾评论
    public function junk()
    {
        $comments = D("Comments");
        $where = [
            'comment_type' => "2"
        ];
        $page = getpage($comments, $where, I("get.onepagenum", C("PAGE_SIZE")));
        $this->show = $page->show();
        $this->comments = $comments->relation(true)->where($where)->order("comment_id desc")->limit($page->firstRow.','.$page->listRows)->select();
        $this->display("junk");
    }

    //回收站
    public function trash()
    {
        $comments = D("Comments");
        $where = [
            'comment_type' => "3"
        ];
        $page = getpage($comments, $where, I("get.onepagenum", C("PAGE_SIZE")));
        $this->show = $page->show();
        $this->comments = $comments->relation(true)->where($where)->order("comment_id desc")->limit($page->firstRow.','.$page->listRows)->select();
        $this->display();
    }
}