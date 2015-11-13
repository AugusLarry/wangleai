<?php
return array(
	'TMPL_PARSE_STRING' => [
		'__PUBLIC__' => __ROOT__ . '/Public/static-admin'
	],
	'URL_HTML_SUFFIX' => '',
	'TOKEN_ON' => true,
	'TOKEN_NAME' => '_csrf',
	'TOKEN_TYPE' => 'md5',
	'TOKEN_RESET' => true,
	'TMPL_CACHE_ON' => false,
	'HTML_CACHE_ON' => false,
	'HTTP_CACHE_CONTROL' => 'no-cache',
	'AUTH_CONFIG' => array(
        'AUTH_ON' => true,  // 认证开关
        'AUTH_TYPE' => 1, // 认证方式，1为实时认证；2为登录认证。
        'AUTH_GROUP' => 'wla_auth_group', // 用户组数据表名
        'AUTH_GROUP_ACCESS' => 'wla_auth_group_access', // 用户-用户组关系表
        'AUTH_RULE' => 'wla_auth_rule', // 权限规则表
        'AUTH_USER' => 'wla_user', // 用户信息表
    ),
);