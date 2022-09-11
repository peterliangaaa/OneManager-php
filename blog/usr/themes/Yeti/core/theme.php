<?php
define("THEME_URL", str_replace('//usr', '/usr', str_replace(Helper::options()->siteUrl, Helper::options()->rootUrl . '/', Helper::options()->themeUrl)));
$str1 = explode('/themes/', (THEME_URL . '/'));
$str2 = explode('/', $str1[1]);
define("THEME_NAME", $str2[0]);


/**
* 是否开启加速更换CDN域名功能
*/
function stcdn($i) {
   $cdnopen = Helper::options()->cdnopen;
   $cdnurla = Helper::options()->cdnurla;
   $cdnurlb = Helper::options()->cdnurlb; 
   if ($cdnopen == '0'){
   $i = $i;
   return $i;
   }else {
   $i = str_replace($cdnurla,$cdnurlb,$i);
   return $i;
   } 
}


/**
* 是否开启加速更换CDN域名功能(图片)
*/
function stcdnimg($i) {
   $cdnopen = Helper::options()->cdnopen;
   $cdnurla = Helper::options()->cdnurla;
   $cdnurlb = Helper::options()->cdnurlb; 
   $imageView = Helper::options()->imageView;
   if ($cdnopen == '0'){
   $i = $i;
   return $i;
   }else {
   $i = str_replace($cdnurla,$cdnurlb,$i);
   return $i.$imageView;  
   } 
}




function getcateid($id){  //获取栏目id
   $db = Typecho_Db::get();
   $postnum=$db->fetchRow($db->select()->from ('table.relationships')->where ('cid=?',$id));
   return  $postnum['mid']; 
}


function catname($cid){  //获取栏目名
   $db = Typecho_Db::get();
   $postnum=$db->fetchRow($db->select()->from ('table.relationships')->where ('cid=?',$cid));
   $catname=icatename($postnum['mid']); 
   if(!$catname){$catname="none";}
   return $catname;
}

function icatename($cateid){  //获取栏目名
   $db = Typecho_Db::get();
   $postnum=$db->fetchRow($db->select()->from ('table.metas')->where ('mid=?',$cateid)->where('type=?', 'category'));
   return  $postnum['name']; 
}

function icatedescription($cateid){  //获取栏目描述
   $db = Typecho_Db::get();
   $postnum=$db->fetchRow($db->select()->from ('table.metas')->where ('mid=?',$cateid)->where('type=?', 'category'));
   return  $postnum['description']?$postnum['description']:'未设置相关栏目描述'; 
}

function icateslug($cateid){  //获取栏目分类名
   $db = Typecho_Db::get();
   $postnum=$db->fetchRow($db->select()->from ('table.metas')->where ('mid=?',$cateid)->where('type=?', 'category'));
   return  $postnum['slug']; 
}


function catename($cateid){  //获取分类栏目名
   $db = Typecho_Db::get();
   $result = $db->fetchAll($db->select()->from('table.metas')
        ->where('parent=?',$cateid)
        ->where('type=?', 'category')
        ->limit(4)
    );
   if($result){
    foreach($result as $val){   
        echo '<li> <a href="'.Helper::options()->rootUrl .'/'.$val['slug'].'" class="btn btn-light btn-w-md btn-sm">'.$val['name'].'</a></li>';
    }
   }
   else{  }
}







/**将正文转成摘要的代码*/
function cutArticle($data,$cut=0,$str="....")  
{     
    $data=strip_tags($data);//去除html标记  
    $pattern = "/&[a-zA-Z]+;/";//去除特殊符号  
    $data=preg_replace($pattern,'',$data);  
    if(!is_numeric($cut))  
        return $data;  
    if($cut>0)  
        $data=mb_strimwidth($data,0,$cut,$str); 
    return $data;  
} 


/**头部链接**/
function topnav(){
    $settings = Helper::options()->topnav;
    $topnav_list = array();
	if (strpos($settings,'|')) {
			//解析关键词数组
			$kwsets = array_filter(preg_split("/(\r|\n|\r\n)/",$settings));
			foreach ($kwsets as $kwset) {
			$topnav_list[] = explode('|',$kwset);
			}
		}
	ksort($topnav_list);  //对关键词排序，短词排在前面	
    if($topnav_list){
        $i = 0;
		$j = 1;	
		foreach ($topnav_list as $key => $val) {
        echo '<li class="nav-item d-none d-md-block"><a href="'.$val[$j].'">'.$val[$i].'</a></li>';
		}
    }
}


/**友情链接**/
function footernav(){
    $settings = Helper::options()->footernav;
    $navtops_list = array();
	if (strpos($settings,'|')) {
			//解析关键词数组
			$kwsets = array_filter(preg_split("/(\r|\n|\r\n)/",$settings));
			foreach ($kwsets as $kwset) {
			$navtops_list[] = explode('|',$kwset);
			}
		}
	ksort($navtops_list);  //对关键词排序，短词排在前面	
    if($navtops_list){
        $i = 0;
		$j = 1;	
		foreach ($navtops_list as $key => $val) {
        
        echo '<a class="text_muted" href="'.$val[$j].'" title="'.$val[$i].'" target="_blank">'.$val[$i].'</a>';
        
		}
    }
}


/**
* 阅读统计
* 调用<?php get_post_view($this); ?>
*/
function Postviews($archive) {
    $db = Typecho_Db::get();
    $cid = $archive->cid;
    if (!array_key_exists('views', $db->fetchRow($db->select()->from('table.contents')))) {
        $db->query('ALTER TABLE `'.$db->getPrefix().'contents` ADD `views` INT(10) DEFAULT 0;');
    }
    $exist = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid))['views'];
    if ($archive->is('single')) {
        $cookie = Typecho_Cookie::get('contents_views');
        $cookie = $cookie ? explode(',', $cookie) : array();
        if (!in_array($cid, $cookie)) {
            $db->query($db->update('table.contents')
                ->rows(array('views' => (int)$exist+1))
                ->where('cid = ?', $cid));
            $exist = (int)$exist+1;
            array_push($cookie, $cid);
            $cookie = implode(',', $cookie);
            Typecho_Cookie::set('contents_views', $cookie);
        }
    }
    echo $exist;
    
}









//热门访问量文章
function theMostViewed($limit = 8, $before = '<br/> - ( views: ', $after = ' times ) ')
    {
        $db = Typecho_Db::get();
        $options = Typecho_Widget::widget('Widget_Options');
        $limit = is_numeric($limit) ? $limit : 8;
        $posts = $db->fetchAll($db->select()->from('table.contents')
                 ->where('type = ? AND status = ? AND password IS NULL', 'post', 'publish')
                 ->order('views', Typecho_Db::SORT_DESC)
                 ->limit($limit)
                 );
        $i=1;         
        if ($posts) {
            foreach ($posts as $post) {
                $result = Typecho_Widget::widget('Widget_Abstract_Contents')->push($post);
                $post_title = htmlspecialchars($result['title']);
                $permalink = $result['permalink'];
				$created = date('m-d', $result['created']); 
                $post_views = convert($result['views']); 
                $img =  $db->fetchAll($db->select()->from('table.fields')->where('name = ? AND cid = ?','img',$result['cid']));
					if(count($img) !=0){
						//var_dump($img);
						$img=$img['0']['str_value'];						
                        if($img){}
						else{
                         $img=Helper::options()->lazyimg;
						}                        						 
					}
                $strimg = stcdnimg($img);
                $zan = zannum($result['cid']);
                echo '<div class="col-6 col-sm-4 col-lg-3">
								<div class="video-img-box mb-e-20">
									<div class="img-box cover-md">
										<a href="'.$permalink.'">
											<img class="lazyload" src="images/placeholder-md.jpg" data-src="'.$strimg.'" data-preview="">
										</a>
									</div>
									<div class="detail">
										<h6 class="title"><a href="'.$permalink.'">'.$post_title.'</a></h6>
										<p class="sub-title">
											<svg class="mr-1" height="15" width="15">
												<use xlink:href="#icon-eye"></use>
											</svg>'.$post_views.'										<svg class="ml-3 mr-1" height="13" width="13">
												<use xlink:href="#icon-heart-inline"></use>
											</svg>'.$zan.'									</p>
									</div>
								</div>
							</div>';
                
                
                $i++;
			 }
        } else {
          echo "暂无内容";
        }
}






/** 处理文章缩略图 */
function Thumbnail($contx,$imgnum){ 
  
    $pattern = '/\<img.*?src\=\"(.*?)\"[^>]*>/i'; 
    $patternMD = '/\!\[.*?\]\((http(s)?:\/\/.*?(jpg|png))/i';
    $patternMDfoot = '/\[.*?\]:\s*(http(s)?:\/\/.*?(jpg|png))/i';
    //如果文章内有插图，则调用插图
    if (preg_match_all($pattern, $contx, $thumbUrl)) { 
        return $thumbUrl[1][$imgnum];
    }    
    //如果是内联式markdown格式的图片
    else if (preg_match_all($patternMD, $contx, $thumbUrl)) {
        return $thumbUrl[1][$imgnum];
    }
    //如果是脚注式markdown格式的图片
    else if (preg_match_all($patternMDfoot, $contx, $thumbUrl)) {
        return $thumbUrl[1][$imgnum];
    }

    //如果真的没有图片，就调用一张随机图片
    else{
        $adimg = ""; // 缩略图路径
        return $adimg;
    }

}


/**点赞**/

function agreeNum($cid) {
    $db = Typecho_Db::get();
    $prefix = $db->getPrefix();
    //  判断点赞数量字段是否存在
    if (!array_key_exists('agree', $db->fetchRow($db->select()->from('table.contents')))) {
        //  在文章表中创建一个字段用来存储点赞数量
        $db->query('ALTER TABLE `' . $prefix . 'contents` ADD `agree` INT(10) NOT NULL DEFAULT 0;');
    }

    //  查询出点赞数量
    $agree = $db->fetchRow($db->select('table.contents.agree')->from('table.contents')->where('cid = ?', $cid));
    //  获取记录点赞的 Cookie
    $AgreeRecording = Typecho_Cookie::get('typechoAgreeRecording');
    //  判断记录点赞的 Cookie 是否存在
    if (empty($AgreeRecording)) {
        //  如果不存在就写入 Cookie
        Typecho_Cookie::set('typechoAgreeRecording', json_encode(array(0)));
    }

    //  返回
    return array(
        //  点赞数量
        'agree' => $agree['agree'],
        //  文章是否点赞过
        'recording' => in_array($cid, json_decode(Typecho_Cookie::get('typechoAgreeRecording')))?true:false
    );
}

function agree($cid) {
    $db = Typecho_Db::get();
    //  根据文章的 `cid` 查询出点赞数量
    $agree = $db->fetchRow($db->select('table.contents.agree')->from('table.contents')->where('cid = ?', $cid));

    //  获取点赞记录的 Cookie
    $agreeRecording = Typecho_Cookie::get('typechoAgreeRecording');
    //  判断 Cookie 是否存在
    if (empty($agreeRecording)) {
        //  如果 cookie 不存在就创建 cookie
        Typecho_Cookie::set('typechoAgreeRecording', json_encode(array($cid)));
    }else {
        //  把 Cookie 的 JSON 字符串转换为 PHP 对象
        $agreeRecording = json_decode($agreeRecording);
        //  判断文章是否点赞过
        if (in_array($cid, $agreeRecording)) {
            //  如果当前文章的 cid 在 cookie 中就返回文章的赞数，不再往下执行
            return $agree['agree'];
        }
        //  添加点赞文章的 cid
        array_push($agreeRecording, $cid);
        //  保存 Cookie
        Typecho_Cookie::set('typechoAgreeRecording', json_encode($agreeRecording));
    }

    //  更新点赞字段，让点赞字段 +1
    $db->query($db->update('table.contents')->rows(array('agree' => (int)$agree['agree'] + 1))->where('cid = ?', $cid));
    //  查询出点赞数量
    $agree = $db->fetchRow($db->select('table.contents.agree')->from('table.contents')->where('cid = ?', $cid));
    //  返回点赞数量
    
    return $agree['agree'];
}





// 生成地图
function getxml(){

        $doc = new \DOMDocument('1.0','utf-8');//引入类并且规定版本编码
        $urlset = $doc->createElement("urlset");//创建节点 
        
        $db = Typecho_Db::get();
        $result = $db->fetchAll($db->select()->from('table.contents')
        ->where('status = ?','publish')
        ->where('type = ?', 'post')
        ->where('created <= unix_timestamp(now())', 'post') //添加这一句避免未达到时间的文章提前曝光
        ->limit(100)
        ->order('created', Typecho_Db::SORT_DESC)
        );
        if($result){
        foreach($result as $val){            
            $val = Typecho_Widget::widget('Widget_Abstract_Contents')->push($val);
            $permalink = $val['permalink'];
            $created = date('Y-m-d', $val['created']);   
                
        /*循环输出节点*/        
        $url = $doc->createElement("url");//创建节点  
		$loc = $doc->createElement("loc");//创建节点
		$lastmod = $doc->createElement("lastmod");//创建节点
		$urlset->appendChild($url);//
        $url->appendChild($loc);//讲loc放到url下
		$url->appendChild($lastmod );
        $content = $doc -> createTextNode($permalink);//设置标签内容
        $contime = $doc -> createTextNode($created);//设置标签内容
        $loc  -> appendChild($content);//将标签内容赋给标签
		$lastmod  -> appendChild($contime);//将标签内容赋给标签    
        
        }}

        $doc->appendChild($urlset);//创建顶级节点
        $doc->save("./../sitemap.xml");//保存代码
        echo "<script>alert('地图生成')</script>";
}






/** HTML压缩功能 */
function compressHtml($html_source) {
    $chunks = preg_split('/(<!--<nocompress>-->.*?<!--<\/nocompress>-->|<nocompress>.*?<\/nocompress>|<pre.*?\/pre>|<textarea.*?\/textarea>|<script.*?\/script>)/msi', $html_source, -1, PREG_SPLIT_DELIM_CAPTURE);
    $compress = '';
    foreach ($chunks as $c) {
        if (strtolower(substr($c, 0, 19)) == '<!--<nocompress>-->') {
            $c = substr($c, 19, strlen($c) - 19 - 20);
            $compress .= $c;
            continue;
        } else if (strtolower(substr($c, 0, 12)) == '<nocompress>') {
            $c = substr($c, 12, strlen($c) - 12 - 13);
            $compress .= $c;
            continue;
        } else if (strtolower(substr($c, 0, 4)) == '<pre' || strtolower(substr($c, 0, 9)) == '<textarea') {
            $compress .= $c;
            continue;
        } else if (strtolower(substr($c, 0, 7)) == '<script' && strpos($c, '//') != false && (strpos($c, "\r") !== false || strpos($c, "\n") !== false)) {
            $tmps = preg_split('/(\r|\n)/ms', $c, -1, PREG_SPLIT_NO_EMPTY);
            $c = '';
            foreach ($tmps as $tmp) {
                if (strpos($tmp, '//') !== false) {
                    if (substr(trim($tmp), 0, 2) == '//') {
                        continue;
                    }
                    $chars = preg_split('//', $tmp, -1, PREG_SPLIT_NO_EMPTY);
                    $is_quot = $is_apos = false;
                    foreach ($chars as $key => $char) {
                        if ($char == '"' && $chars[$key - 1] != '\\' && !$is_apos) {
                            $is_quot = !$is_quot;
                        } else if ($char == '\'' && $chars[$key - 1] != '\\' && !$is_quot) {
                            $is_apos = !$is_apos;
                        } else if ($char == '/' && $chars[$key + 1] == '/' && !$is_quot && !$is_apos) {
                            $tmp = substr($tmp, 0, $key);
                            break;
                        }
                    }
                }
                $c .= $tmp;
            }
        }
        $c = preg_replace('/[\\n\\r\\t]+/', ' ', $c);
        $c = preg_replace('/\\s{2,}/', ' ', $c);
        $c = preg_replace('/>\\s</', '> <', $c);
        $c = preg_replace('/\\/\\*.*?\\*\\//i', '', $c);
        $c = preg_replace('/<!--[^!]*-->/', '', $c);
        $compress .= $c;
    }
    return $compress;
}





Typecho_Plugin::factory('admin/write-post.php')->bottom = array('tagshelper', 'tagslist');
class tagshelper {
    public static function tagslist()
    {      
    $tag="";$taglist="";$i=0;//循环一次利用到两个位置
Typecho_Widget::widget('Widget_Metas_Tag_Cloud', 'sort=count&desc=1&limit=200')->to($tags);
while ($tags->next()) {
$tag=$tag."'".$tags->name."',";
$taglist=$taglist."<a id=".$i." onclick=\"$(\'#tags\').tokenInput(\'add\', {id: \'".$tags->name."\', tags: \'".$tags->name."\'});\">".$tags->name."</a>";
$i++;
}
?><style>.Posthelper a{cursor: pointer; padding: 0px 6px; margin: 2px 0;display: inline-block;border-radius: 2px;text-decoration: none;}
.Posthelper a:hover{background: #ccc;color: #fff;}.fullscreen #tab-files{right: 0;}/*解决全屏状态下鼠标放到附件上传按钮上导致的窗口抖动问题*/
</style>
<script>
  function chaall () {
   var html='';
 $("#file-list li .insert").each(function(){
   var t = $(this), p = t.parents('li');
   var file=t.text();
   var url= p.data('url');
   var isImage= p.data('image');
   if ($("input[name='markdown']").val()==1) {
   html = isImage ? html+'\n!['+file+'](' + url + ')\n':''+html+'';
   }else{
   html = isImage ? html+'<img src="' + url + '" alt="' + file + '" />\n':''+html+'';
   }
    });
   var textarea = $('#text');
   textarea.replaceSelection(html);return false;
    }

    function chaquan () {
   var html='';
 $("#file-list li .insert").each(function(){
   var t = $(this), p = t.parents('li');
   var file=t.text();
   var url= p.data('url');
   var isImage= p.data('image');
   if ($("input[name='markdown']").val()==1) {
   html = isImage ? html+'':html+'\n['+file+'](' + url + ')\n';
   }else{
   html = isImage ? html+'':html+'<a href="' + url + '"/>' + file + '</a>\n';
   }
    });
   var textarea = $('#text');
   textarea.replaceSelection(html);return false;
    }
function filter_method(text, badword){
    //获取文本输入框中的内容
    var value = text;
    var res = '';
    //遍历敏感词数组
    for(var i=0; i<badword.length; i++){
        var reg = new RegExp(badword[i],"g");
        //判断内容中是否包括敏感词		
        if (value.indexOf(badword[i]) > -1) {
            $('#tags').tokenInput('add', {id: badword[i], tags: badword[i]});
        }
    }
    return;
}
var badwords = [<?php echo $tag; ?>];
function chatag(){
var textarea=$('#text').val();
filter_method(textarea, badwords); 
}
  $(document).ready(function(){
    $('#file-list').after('<div class="Posthelper"><a class="w-100" onclick=\"chaall()\" style="background: #467B96;background-color: #3c6a81;text-align: center; padding: 5px 0; color: #fbfbfb; box-shadow: 0 1px 5px #ddd;">插入所有图片</a><a class="w-100" onclick=\"chaquan()\" style="background: #467B96;background-color: #3c6a81;text-align: center; padding: 5px 0; color: #fbfbfb; box-shadow: 0 1px 5px #ddd;">插入所有非图片附件</a></div>');
    $('#tags').after('<div style="margin-top: 35px;" class="Posthelper"><ul style="list-style: none;border: 1px solid #D9D9D6;padding: 6px 12px; max-height: 240px;overflow: auto;background-color: #FFF;border-radius: 2px;margin-bottom: 0;"><?php echo $taglist; ?></ul><a class="w-100" onclick=\"chatag()\" style="background: #467B96;background-color: #3c6a81;text-align: center; padding: 5px 0; color: #fbfbfb; box-shadow: 0 1px 5px #ddd;">检测内容插入标签</a></div>');
  }); 
  </script>
<?php
    }
}