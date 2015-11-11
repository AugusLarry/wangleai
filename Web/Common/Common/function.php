<?php
function p ($arr)
{
	echo '<pre>' . print_r($arr, true) . '</pre>';
}

function check_verify ($code, $id = '')
{
	$verify = new \Think\Verify();
	return $verify->check($code, $id);
}