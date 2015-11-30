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
        $comments = $comments->relation(true)->where($where)->order("comment_id desc")->limit($page->firstRow.','.$page->listRows)->select();
        vendor('myClass.Category', "", ".php");
        $this->comments = \Category::unlimitedForComment($comments);
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
        $parent = $model->where(['comment_parent' => $comment_id, 'comment_type' => 1])->count();
        if ($parent) $this->error("该评论下还有已审核子评论,请先删除该子评论", U("Admin/Comments/index"));
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

    //通过文章查看所有已通过审核评论
    public function getCommentsByArticle()
    {
        $comments = D("Comments");
        $where = [
            'comment_post_id' => I("get.comment_post_id"),
            'comment_type' => I("get.comment_type")
        ];
        $page = getpage($comments, $where, I("get.onepagenum", C("PAGE_SIZE")));
        $this->show = $page->show();
        $this->comments = $comments->relation(true)->where($where)->order("comment_id desc")->limit($page->firstRow.','.$page->listRows)->select();
        $this->display();
    }

    //回复评论
    public function reply()
    {
        if (!IS_POST || empty(I("post."))) $this->error("访问出错", U('index'));
        //组合评论表数据
        $data = [
            'comment_post_id' => I("post.pid", "", "intval"),
            'comment_author' => urldecode(cookie(C("COMMENT_COOKIE_PREFIX") . "_comment_author")),
            'comment_author_email' => urldecode(cookie(C("COMMENT_COOKIE_PREFIX") . "_comment_author_email")),
            'comment_author_url' => urldecode(cookie(C("COMMENT_COOKIE_PREFIX") . "_comment_author_url")),
            'comment_author_ip' => get_client_ip(),
            'created_at' => NOW_TIME,
            'comment_content' => rtrim(I("post.content", "", "htmlspecialchars"), "&lt;br&gt;"),
            'comment_type' => 1,
            'comment_agent' => get_client_browser("|-|"),
            'comment_parent' => I("post.parent", "", "intval"),
            "user_id" => session("uid"),
            '_csrf' => I("post._csrf", "", "strip_tags")
        ];
        //获取父评论ID
        $parent_id = I("post.parent");
        $model = M("Comments");
        if (!$model->create($data)) {
            $this->error($model->getError(), U("index"));
        } else {
            //保存评论
            $model->add($data);
            //获取父评论状态
            $parent_comment_type = $model->where(['comment_id' => $parent_id])->getField("comment_type");
            $post = M("Posts");
            //如果父评论状态已经是审核过了
            if ($parent_comment_type == 1) {
                //将该评论对应的文章的评论总数加1
                $post->where(['id' => $data['comment_post_id']])->setInc("comment_count");
            } else {
                //将父评论状态设置为已审核
                //将该评论对应的文章的评论总数加2
                $model->where(['comment_id' => $parent_id])->setField("comment_type", 1);
                $post->where(['id' => $data['comment_post_id']])->setInc("comment_count", 2);
            }
            $this->success("回复成功!", U("index"));
        }
    }

    //删除评论
    public function delete()
    {
        if (!IS_GET || I("get.id") == "") $this->error("访问出错!", U("index"));
        $comment_id = I("get.id", "", "intval");
        $model = M("Comments");
        $parent = $model->where(['comment_parent' => $comment_id])->count();
        if ($parent) $this->error("该评论下还有子评论,请先删除子评论!", U("index"));
        $result = $model->where(['comment_id' => $comment_id])->delete();
        if (!$result) {
            $this->error($model->getError(), U("index"));
        } else {
            $this->success("删除成功!", U("index"));
        }
    }

    //编辑评论
    public function update()
    {
        if (!IS_POST || empty(I("post."))) $this->error("访问出错", U('index'));
        $data = [
            'comment_id' => I("post.id", "", "intval"),
            'comment_author' => I("post.author", "", "strip_tags"),
            'comment_author_email' => I("post.email", "", "strip_tags"),
            'comment_author_url' => I("post.url", "", "strip_tags"),
            'comment_content' => I("post.content", "", "htmlspecialchars"),
            'comment_type' => 1
        ];
        $model = M("Comments");
        $default_comment_type = $model->where(['comment_id' => $data['comment_id']])->getField("comment_type");
        if ($model->create($data)) {
            $this->error($model->getError(), U("index"));
        } else {
            $result = $model->save($data);
            if (!$result) {
                $this->error($model->getError(), U("index"));
            } else {
                if ($default_comment_type != 1) {
                    $post_id = $model->where(['comment_id' => $data['comment_id']])->getField("comment_post_id");
                    M("Posts")->where(['id' => $post_id])->setInc("comment_count");
                }
                $this->success("修改成功!", U("index"));
            }
        }
    }
}