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

function getpage(&$m, $where, $pagesize = 10) {
    $m1=clone $m;//浅复制一个模型
    $count = $m->where($where)->count();//连惯操作后会对join等操作进行重置
    $m = $m1;//为保持在为定的连惯操作，浅复制一个模型
    $page=new Think\Page($count,$pagesize);
    $page->setConfig('header', C("HEADER"));
    $page->setConfig('prev', C("PREV"));
    $page->setConfig('next', C("NEXT"));
    $page->setConfig('last', C("LAST"));
    $page->setConfig('first', C("FIRST"));
    $page->setConfig('theme', C("THEME"));
    $page->parameter=I('get.');
    $m->limit($p->firstRow,$p->listRows);
    return $page;
}