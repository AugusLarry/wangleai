<?php
return [
	'TMPL_PARSE_STRING'  => [//模板变量
		'__PUBLIC__' => __ROOT__ . '/Public/static-admin'
	],
	'URL_HTML_SUFFIX'    => '',//伪静态后缀
	'TOKEN_ON'           => true,//表单令牌
	'TOKEN_NAME'         => '_csrf',//表单令牌名称
	'TOKEN_TYPE'         => 'md5',//表单令牌加密方式
	'TOKEN_RESET'        => true,//表单提交后重置令牌
	'TMPL_CACHE_ON'      => false,//模板缓存
	'HTML_CACHE_ON'      => false,//静态缓存
	'HTTP_CACHE_CONTROL' => 'no-cache',//HTTP请求缓存控制
	'AUTH_CONFIG'        => [//AUTH权限验证
		'AUTH_ON'           => false,  // 认证开关
		'AUTH_TYPE'         => 1, // 认证方式，1为实时认证；2为登录认证。
		'AUTH_GROUP'        => 'wla_auth_group', // 用户组数据表名
		'AUTH_GROUP_ACCESS' => 'wla_auth_group_access', // 用户-用户组关系表
		'AUTH_RULE'         => 'wla_auth_rule', // 权限规则表
		'AUTH_USER'         => 'wla_user', // 用户信息表
		'NOT_AUTH'			=> ['admin/index/index', 'admin/index/logout'],
    ],
    'SHOW_PAGE_TRACE' =>true,
];