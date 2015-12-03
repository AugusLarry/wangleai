<?php
return array(
	'DEFAULT_MODULE' => 'Index',//默认模块
	'LOAD_EXT_CONFIG' => 'db,basic,verify,upload,page,comment',//自动加载配置文件
    'URL_MODEL'       =>  2,
	'TMPL_CACHE_ON'   => false,
	'MODULE_DENY_LIST' => ['Common', 'Runtime'],
	'MODULE_ALLOW_LIST' => ['Index', 'Admin'],
	'TMPL_EXCEPTION_FILE' => APP_PATH . 'Index/View/Common/exception.html'
);