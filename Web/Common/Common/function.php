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

function getPageForIndex(&$m, $where, $pagesize = 10) {
    $m1=clone $m;//浅复制一个模型
    $count = $m->where($where)->count();//连惯操作后会对join等操作进行重置
    $m = $m1;//为保持在为定的连惯操作，浅复制一个模型
    $page=new Think\Page($count,$pagesize);
    $page->setConfig('prev', "<i class='fa fa-angle-left' title='上一页'></i>");
    $page->setConfig('next', "<i class='fa fa-angle-right' title='下一页'></i>");
    $page->setConfig('last', "<i class='fa fa-angle-double-right' title='最后一页'></i>");
    $page->setConfig('first', "<i class='fa fa-angle-double-left' title='首页'></i>");
    $page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
    $page->parameter=I('get.');
    $m->limit($p->firstRow,$p->listRows);
    return $page;
}

/**
 * 获取客户端浏览器类型
 * @param  string $glue 浏览器类型和版本号之间的连接符
 * @return string|array 传递连接符则连接浏览器类型和版本号返回字符串否则直接返回数组 false为未知浏览器类型
 */
function get_client_browser($glue = null) {
    $browser = array();
    $agent = $_SERVER['HTTP_USER_AGENT']; //获取客户端信息

    /* 定义浏览器特性正则表达式 */
    $regex = array(
        'ie'      => '/(MSIE) (\d+\.\d)/',
        'chrome'  => '/(Chrome)\/(\d+\.\d+)/',
        'firefox' => '/(Firefox)\/(\d+\.\d+)/',
        'opera'   => '/(Opera)\/(\d+\.\d+)/',
        'safari'  => '/Version\/(\d+\.\d+\.\d) (Safari)/',
    );
    foreach($regex as $type => $reg) {
        preg_match($reg, $agent, $data);
        if(!empty($data) && is_array($data)){
            $browser = $type === 'safari' ? array($data[2], $data[1]) : array($data[1], $data[2]);
            break;
        }
    }
    return empty($browser) ? false : (is_null($glue) ? $browser : implode($glue, $browser));
}