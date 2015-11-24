<?php
return array(
	'TAGLIB_BUILD_IN' => 'Cx,Index\TagLib\Wla',
	'URL_ROUTER_ON' => true,
	'URL_ROUTE_RULES' => [
		'/^c_(\d+)$/' => ['List/index?id=:1'],
		'/^t_(\d+)$/' => ['Tags/index?id=:1'],
		':id\d' => ['Show/index'],
	],
);