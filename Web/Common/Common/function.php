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

function FConf($name, $value='', $path=DATA_PATH) {
    static $_cache  = array();
    $filename       = $path . $name . '.php';
    if ('' !== $value) {
        if (is_null($value)) {
            // 删除缓存
            return false !== strpos($name,'*')?array_map("unlink", glob($filename)):unlink($filename);
        } else {
            // 缓存数据
            $dir            =   dirname($filename);
            // 目录不存在则创建
            if (!is_dir($dir))
                mkdir($dir,0755,true);
            $_cache[$name]  =   $value;
            return file_put_contents($filename,strip_whitespace("<?php\treturn ".var_export($value,true).";?>"));
        }
    }
}