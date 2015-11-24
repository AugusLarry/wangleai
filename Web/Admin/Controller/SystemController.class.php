<?php
namespace Admin\Controller;
use Admin\Controller\CommonController;
/**
 * 系统设置控制器
 */
class SystemController extends CommonController
{
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