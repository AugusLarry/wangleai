<?php
return array(
	'TAGLIB_BUILD_IN' => 'Cx,Index\TagLib\Wla',
	'URL_ROUTER_ON' => true,
	'TOKEN_ON'           => true,//表单令牌
	'TOKEN_NAME'         => '_csrf',//表单令牌名称
	'TOKEN_TYPE'         => 'md5',//表单令牌加密方式
	'TOKEN_RESET'        => true,//表单提交后重置令牌
	'URL_ROUTE_RULES' => [
		'/^c_(\d+)$/' => ['List/index?id=:1'],
		'/^t_(\d+)$/' => ['Tags/index?id=:1'],
		's' => ['Search/index'],
		':id\d' => ['Show/index'],
	],
);