<?php
namespace Index\Controller;
use Think\Controller;
class TagsController extends Controller
{
	public function index ()
	{
		p($_GET);die;
		$this->display();
	}
}