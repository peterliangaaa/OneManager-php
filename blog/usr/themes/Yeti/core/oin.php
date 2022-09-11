<?php


/**输出点赞数*/
function zannum($cid){
    $db = Typecho_Db::get();
    $exist = 0;
    $prefix = $db->getPrefix();
    //  判断点赞数量字段是否存在
    if (!array_key_exists('agree', $db->fetchRow($db->select()->from('table.contents')))) {
        //  在文章表中创建一个字段用来存储点赞数量
        $db->query('ALTER TABLE `' . $prefix . 'contents` ADD `agree` INT(10) NOT NULL DEFAULT 0;');
    }
    if (array_key_exists('agree', $db->fetchRow($db->select()->from('table.contents')))) {   
    $exist = $db->fetchRow($db->select('agree')->from('table.contents')->where('cid = ?', $cid))['agree'];
    }
    return $exist == 0 ? '0 ' : $exist.'';
}

/**
 * 时间友好化
 *
 * @access public
 * @param mixed
 * @return
 */
function formatTime($time){
    if (!$time)
 
        return false;
 
    $fdate = '';
 
    $d = time() - intval($time);
 
    $ld = $time - mktime(0, 0, 0, 0, 0, date('Y')); //得出年
 
    $md = $time - mktime(0, 0, 0, date('m'), 0, date('Y')); //得出月
 
    $byd = $time - mktime(0, 0, 0, date('m'), date('d') - 2, date('Y')); //前天
 
    $yd = $time - mktime(0, 0, 0, date('m'), date('d') - 1, date('Y')); //昨天
 
    $dd = $time - mktime(0, 0, 0, date('m'), date('d'), date('Y')); //今天
 
    $td = $time - mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')); //明天
 
    $atd = $time - mktime(0, 0, 0, date('m'), date('d') + 2, date('Y')); //后天
 
    if ($d == 0) {
 
        $fdate = '刚刚';
 
    } else {
 
        switch ($d) {
 
            case $d < $atd:
 
                $fdate = date('Y-m-d', $time);
 
                break;
 
            case $d < $td:
 
                $fdate = '后天' . date('H:i', $time);
 
                break;
 
            case $d < 0:
 
                $fdate = '明天' . date('H:i', $time);
 
                break;
 
            case $d < 60:
 
                $fdate = $d . '秒前';
 
                break;
 
            case $d < 3600:
 
                $fdate = floor($d / 60) . '分钟前';
 
                break;
 
            case $d < $dd:
 
                $fdate = floor($d / 3600) . '小时前';
 
                break;
 
            case $d < $yd:
 
                $fdate = '昨天' . date('H:i', $time);
 
                break;
 
            case $d < $byd:
 
                $fdate = '前天' . date('H:i', $time);
 
                break;
 
            case $d < $md:
 
                $fdate = date('m-d H:i', $time);
 
                break;
 
            case $d < $ld:
 
                $fdate = date('m-d', $time);
 
                break;
 
            default:
 
                $fdate = date('Y-m-d', $time);
 
                break;
        }
 
    }
 
    return $fdate;

}

/** 阅读数友好化 */
function convert($num) 
{
    if ($num >= 100000)
    {
        $num = round($num / 10000) .'w';
    } 
    else if ($num >= 10000) 
    {
        $num = round($num / 10000, 1) .'w';
    } 
    else if($num >= 1000) 
    {
        $num = round($num / 1000, 1) . 'k';
    }
    return $num;
}



