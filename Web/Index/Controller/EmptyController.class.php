<?php
    /**
     * Created by PhpStorm.
     * User: larry
     * Date: 2015/12/2
     * Time: 9:19
     * 404控制器
     */
namespace Index\Controller;
use Think\Controller;
class EmptyController extends Controller
{
    public function _empty()
    {
        header("HTTP/1.0 404 Not Found");
        header('Status: 404 Not Found');
        $this->display('Common:404');
    }

    public function index()
    {
        header("HTTP/1.0 404 Not Found");
        header('Status: 404 Not Found');
        $this->display('Common:404');
    }
}