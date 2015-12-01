<?php
namespace Admin\Controller;
/**
 * 系统设置控制器
 */
class SystemController extends CommonController
{
	//基本设置
	public function index()
	{
		$this->display();
	}

	//基本设置提交表单
	public function updateBasic()
	{
		$data = [
			"SITE_URL" => I("post.SITE_URL"),
		    'SITE_INDEX_URL' => I("post.SITE_INDEX_URL"),
		    'SITE_INDEX_NAME' => I("post.SITE_INDEX_NAME"),
		    'SITE_WEB_NAME' => I("post.SITE_WEB_NAME"),
		    'SITE_POWERBY' => $_POST['SITE_POWERBY'],
		    'SITE_KEYWORDS' => I("post.SITE_KEYWORDS"),
		    'SITE_DESCRIPTION' => I("post.SITE_DESCRIPTION"),
		    'SITE_BEIAN' => I("post.SITE_BEIAN"),
		    'SITE_INDEX_DESCRIPTION' => I("post.SITE_INDEX_DESCRIPTION"),
		];
		if (FConf("basic", $data, CONF_PATH)) {
			$this->success('修改成功', U("Admin/System/index"), 2);
		} else {
			$this->error('修改失败,请修改' . CONF_PATH . 'index.php文件权限!', U("Admin/System/index"), 5);
		}
	}

	//评论设置
	public function comment()
	{
		$this->display();
	}

	//评论提交表单
	public function updateComment()
	{
		$data = [
			"COMMENT_ON" => I("post.COMMENT_ON") ? true : false,
		    'COMMENT_LEVEL' => (int) I("post.COMMENT_LEVEL"),
		    'COMMENT_TIME' => (int) I("post.COMMENT_TIME"),
		    'COMMENT_COOKIE_PREFIX' => I("post.COMMENT_COOKIE_PREFIX"),
		];
		if (FConf("comment", $data, CONF_PATH)) {
			$this->success('修改成功', U("Admin/System/comment"), 2);
		} else {
			$this->error('修改失败,请修改' . CONF_PATH . 'comment.php文件权限!', U("Admin/System/comment"), 5);
		}
	}

	//分页设置
	public function page()
	{
		$this->display();
	}

	//分页提交表单
	public function updatePage()
	{
		$data = [
			"HEADER" => $_POST['HEADER'],
		    'PREV' => I("post.PREV"),
		    'NEXT' => I("post.NEXT"),
		    'FIRST' => I("post.FIRST"),
		    'LAST' => I("post.LAST"),
		    'THEME' => I("post.THEME"),
		    'VAR_PAGE' => I("post.VAR_PAGE"),
		    'PAGE_SIZE' => I("post.PAGE_SIZE")
		];
		if (FConf("page", $data, CONF_PATH)) {
			$this->success('修改成功', U("Admin/System/page"), 2);
		} else {
			$this->error('修改失败,请修改' . CONF_PATH . 'page.php文件权限!', U("Admin/System/page"), 5);
		}
	}

	//上传设置
	public function upload()
	{
		$this->display();
	}

	//上传提交表单
	public function updateUpload()
	{
		$data = [
			'maxSize'    => (int) I("post.maxSize"),
		    'rootPath' => I("post.rootPath"),
		    'savePath' => I("post.savePath"),
		    'saveName' => I("post.saveName"),
			'saveExt'    => I("post.saveExt"),
		    'replace'  => (int) I("post.replace") ? true : false,
		    'exts'   => I("post.exts"),
		    'mimes'    => I("post.mimes"),
		    'autoSub' => (int) I("post.autoSub") ? true : false,
		    'hash'   => (int) I("post.hash") ? true : false,
		    'callback'   => (int) I("post.callback") ? true : false
		];
		if (FConf("upload", $data, CONF_PATH)) {
			$this->success('修改成功', U("Admin/System/upload"), 2);
		} else {
			$this->error('修改失败,请修改' . CONF_PATH . 'upload.php文件权限!', U("Admin/System/upload"), 5);
		}
	}

	//验证码设置视图
	public function verify()
	{
		C('TOKEN_ON',false);
		$this->display();
	}

	//验证码提交表单
	public function updateVerify()
	{
		$data = [
		    'useZh'    => I("post.useZh") ? true : false,
		    'useImgBg' => I("post.useImgBg") ? true : false,
		    'useCurve' => I("post.useCurve") ? true : false,
		    'useNoise' => I("post.useNoise") ? true : false,
			'seKey'    => I("post.seKey"),
		    'codeSet'  => I("post.codeSet"),
		    'expire'   => (int) I("post.expire"),
		    'zhSet'    => I("post.zhSet"),
		    'fontSize' => (int) I("post.fontSize"),
		    'imageH'   => (int) I("post.imageH"),
		    'imageW'   => (int) I("post.imageW"),
		    'length'   => (int) I("post.length"),
		    'fontttf'  => I("post.fontttf"),
		    'bg'       => explode(",", I("post.bg")),
		    'reset'    => I("post.reset") ? true : false,
		];
		if (FConf("verify", $data, CONF_PATH)) {
			$this->success('修改成功', U("Admin/System/verify"), 2);
		} else {
			$this->error('修改失败,请修改' . CONF_PATH . 'verify.php文件权限!', U("Admin/System/verify"), 5);
		}
	}
}