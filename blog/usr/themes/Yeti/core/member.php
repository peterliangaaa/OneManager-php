<?php

/**
 * menber.php
 * Author     : 小灯泡设计
 * Date       : 2020/4/3
 * Version    : 1.0
 * Description: 会员功能
 **/
 
 
// 获取会员各方面信息
function userok($id){
$db = Typecho_Db::get();
$userinfo=$db->fetchRow($db->select()->from ('table.users')->where ('table.users.uid=?',$id));
return $userinfo;
} 


/**会员功能是否开启*/
function ueropen(){
    if(Helper::options()->ueropen==1){
        return true; 
    }
    else{
        return false;
    }
    
    
}

// 获取会员各方面信息
function usercomments($cid,$mail){
$db = Typecho_Db::get();
$sql = $db->select()->from('table.comments')
->where('cid = ?',$cid)
->where('mail = ?', $mail)
->limit(1);
$result = $db->fetchAll($sql);
if($result) {
   return true; 
}
} 

/**输出作者评论总数，可以指定*/
function commentnum($id){
    $db = Typecho_Db::get();
    $commentnum=$db->fetchRow($db->select(array('COUNT(authorId)'=>'commentnum'))->from ('table.comments')->where ('table.comments.authorId=?',$id)->where('table.comments.type=?', 'comment'));
    $commentnum = $commentnum['commentnum'];    
	return $commentnum;
}

/**输出作者文章总数，可以指定*/
function allpostnum($id){
    $db = Typecho_Db::get();
    $postnum=$db->fetchRow($db->select(array('COUNT(authorId)'=>'allpostnum'))->from ('table.contents')->where ('table.contents.authorId=?',$id)->where('table.contents.type=?', 'post'));
    $postnum = $postnum['allpostnum'];
	if($postnum=='0')
    {
		return 0;
	}
	else{
	   return $postnum;
	}
}

//判断用户组
function yonghuzu($uid)
{
    $db   = Typecho_Db::get();
    $prow = $db->fetchRow($db->select('group')->from('table.users')->where('uid = ?', $uid));
    $group = $prow['group'];

       // 变判断的值为常量
    switch($group){
    case 'subscriber':
    return '普通会员';
    break;   // 跳出循环
    case 'administrator':
    return '管理员';
    break;
    case 'editor':
    return '编辑';
    break;
    case 'contributor':
    return '认证作者';
    break;
     }
}  

//调用用户注册时间
function reg_login($userid){
    $now = time();
    $db     = Typecho_Db::get();
    $prefix = $db->getPrefix();
    $row = $db->fetchRow($db->select('created')->from('table.users')->where('uid = ?', $userid));
    $ti = Typecho_I18n::dateWord($row['created'], $now);
    $d1 = $row['created'];//过去的某天，你来设定
    $d2 = ceil((time()-$d1)/60/60/24);//现在的时间减去过去的时间，ceil()进一函数
    return $d2;
}

/**
* 个人主页统计
* 调用<?php get_post_view($this); ?>
*/
function authorviews($uid) {
    $db = Typecho_Db::get();
    if (!array_key_exists('uviews', $db->fetchRow($db->select()->from('table.users')))) {
        $db->query('ALTER TABLE `'.$db->getPrefix().'users` ADD `uviews` INT(10) DEFAULT 0;');
    }
    $exist = $db->fetchRow($db->select('uviews')->from('table.users')->where('uid = ?', $uid))['uviews'];
    
        $cookie = Typecho_Cookie::get('author_uviews');
        $cookie = $cookie ? explode(',', $cookie) : array();
        if (!in_array($uid, $cookie)) {
            $db->query($db->update('table.users')
                ->rows(array('uviews' => (int)$exist+1))
                ->where('uid = ?', $uid));
            $exist = (int)$exist+1;
            array_push($cookie, $uid);
            $cookie = implode(',', $cookie);
            Typecho_Cookie::set('author_uviews', $cookie);
        }
    
    
    if( $exist == 0 ){
      return '0';
    }
    else{      
      $exist = convert($exist);
      return $exist;
    }
}

/*输出作者发表的评论*/
class Widget_Post_AuthorComment extends Widget_Abstract_Comments
{
    public function execute()
    {
        global $AuthorCommentId;//全局作者id
        $select  = $this->select()->limit($this->parameter->pageSize)
        ->where('table.comments.status = ?', 'approved')
        ->where('table.comments.authorId = ?', $AuthorCommentId)//获取作者id
        ->where('table.comments.type = ?', 'comment')
        ->order('table.comments.coid', Typecho_Db::SORT_DESC);//根据coid排序
        $this->db->fetchAll($select, array($this, 'push'));
        
    }
}


/**
* 弹出信息<?php Notice(); ?>
*/
function Notice($txt) {
    /*发出提示*/
    if($txt){
    Typecho_Widget::widget('Widget_Notice')->set(array($txt)); 
    }
}

/**
* 个人签名
* 调用<?php getintro($this); ?>
*/
function getintro($uid,$intros) {
    $db = Typecho_Db::get();
    if (!array_key_exists('introduce', $db->fetchRow($db->select()->from('table.users')))) {
        $db->query('ALTER TABLE `'.$db->getPrefix().'users` ADD `introduce` varchar(200) DEFAULT NULL;');
    }
    $exist = $db->fetchRow($db->select('introduce')->from('table.users')->where('uid = ?', $uid))['introduce'];
    $db->query($db->update('table.users')
                ->rows(array('introduce' => $intros))
                ->where('uid = ?', $uid));
    /*发出提示*/
    Notice('签名已经更新!');
    //Typecho_Widget::widget('Widget_Notice')->set(array('签名已经更新!')); 
}




function reintro($uid) {
    $db = Typecho_Db::get();
    
    if (!array_key_exists('introduce', $db->fetchRow($db->select()->from('table.users')))) {
        $db->query('ALTER TABLE `'.$db->getPrefix().'users` ADD `introduce` varchar(200) DEFAULT NULL;');
    }
    
    $exist = $db->fetchRow($db->select('introduce')->from('table.users')->where('uid = ?', $uid))['introduce'];
    if($exist==''){$exist = '作者有点忙，还没写简介';}
    return $exist;
}



/** 输出该作者审核文章列表 */
function authorwaiting($authorid,$lock){
    if($authorid){ 
        $limit = 10;
        $db = Typecho_Db::get();
        $result = $db->fetchAll($db->select()->from('table.contents')
            ->where('authorId = ?',$authorid)
            ->where('status = ?','waiting')
            ->where('type = ?', 'post')
            ->limit($limit)
            ->order('created', Typecho_Db::SORT_DESC)        
        );
        if($result){
            foreach($result as $val){                
                $val = Typecho_Widget::widget('Widget_Abstract_Contents')->push($val);
                $post_title = htmlspecialchars($val['title']);
                $permalink = $val['permalink'];
				$commentsNum = $val['commentsNum'];
				$post_text = preg_replace('/($s*$)|(^s*^)/m', '',strip_tags($val['text'])); //获取内容
				$cont_text = cutArticle($post_text,150);
			    $post_views = convert($val['views']);
			    $post_agree = $val['agree'];
				$cont_time = Typecho_I18n::dateWord($val['created'], $now);
				
				$siteUrl = Helper::options()->siteUrl;
				//删除
		        Typecho_Widget::widget('Widget_Security')->to($security);
				$img =  $db->fetchAll($db->select()->from('table.fields')->where('name = ? AND cid = ?','img',$val['cid']));
					if(count($img) !=0){
						//var_dump($img);
						$img=$img['0']['str_value'];						
                        if($img){}
						else{
                          $img= Thumbnail($val['text'],0);
						}                        						 
					}	 
		

                echo '<div class="list-item block"><div class="media border border-light col-4 col-md-2"><div class="media-content" style="background-image:url('.$img.')"></div></div><div class="list-content"><div class="list-body"><div class="list-title h6 h-2x">'.$post_title.'</div><div class="list-desc text-secondary d-none d-xl-block mt-2"><div class="h-2x">'.$cont_text.'</div></div></div><div class="list-footer"><div class="d-flex align-items-center flex-fill text-xs text-muted"> <span class="badge bg-warning me-2">待审</span><span class="badge bg-warning me-2">';
                ?><a href="<?php $security->index('/action/contents-post-edit?do=delete&cid='.$val['cid'].''); ?>" onclick="javascript:return p_del()">删除</a><?php
                echo '</span><div class="flex-fill"></div><div class="flex-shrink-0">'.$cont_time.'</div></div></div></div></div>';
                    
                    
            }
        }
        
        else{ echo ''; }
        
    }else{
        echo '请设置要调用的作者ID';
    }
}



/** 输出该作者最近草稿文章列表 */
function authordraft($authorid,$lock){
    if($authorid){ 
        $limit = 10;
        $db = Typecho_Db::get();
        $result = $db->fetchAll($db->select()->from('table.contents')
            ->where('authorId = ?',$authorid)
            //->where('status = ?','publish')
            ->where('type = ?', 'post_draft')
            ->limit($limit)
            ->order('created', Typecho_Db::SORT_DESC)        
        );
        if($result){
            foreach($result as $val){                
                $val = Typecho_Widget::widget('Widget_Abstract_Contents')->push($val);
                $post_title = htmlspecialchars($val['title']);
                $permalink = $val['permalink'];
				$commentsNum = $val['commentsNum'];
				$post_text = preg_replace('/($s*$)|(^s*^)/m', '',strip_tags($val['text'])); //获取内容
				$cont_text = cutArticle($post_text,150);
			    $post_views = convert($val['views']);
			    $post_agree = $val['agree'];
				$cont_time = Typecho_I18n::dateWord($val['created'], $now);
				
				$siteUrl = Helper::options()->siteUrl;
				$gaoedit = Helper::options()->gaoedit;
				$edit = '<a href="'.$siteUrl.''.$gaoedit.'.html?tid='.$val['cid'].'">编辑</a>';
				
				//删除
		        Typecho_Widget::widget('Widget_Security')->to($security);

				
				$img =  $db->fetchAll($db->select()->from('table.fields')->where('name = ? AND cid = ?','img',$val['cid']));
					if(count($img) !=0){
						//var_dump($img);
						$img=$img['0']['str_value'];						
                        if($img){}
						else{
                          $img= Thumbnail($val['text'],0);
						}                        						 
					}	 
		
		
		echo '<div class="list-item block"><div class="media border border-light col-4 col-md-2"><div class="media-content" style="background-image:url('.$img.')"></div></div><div class="list-content"><div class="list-body"><div class="list-title h6 h-2x">'.$post_title.'</div><div class="list-desc text-secondary d-none d-xl-block mt-2"><div class="h-2x">'.$cont_text.'</div></div></div><div class="list-footer"><div class="d-flex align-items-center flex-fill text-xs text-muted"> <span class="badge bg-warning me-2">草稿</span><span class="badge bg-warning me-2">';
		?><a href="<?php $security->index('/action/contents-post-edit?do=delete&cid='.$val['cid'].''); ?>" onclick="javascript:return p_del()">删除</a><?php
		echo '</span><div class="flex-fill"></div><div class="flex-shrink-0">'.$edit.'</div></div></div></div></div>';
                     

            }
        }
        
        else{ echo ''; }
        
    }else{
        echo '请设置要调用的作者ID';
    }
}





/**
 * 回复触发
 */
Typecho_Plugin::factory('Widget_Feedback')->comment = array('ComWechat', 'sc_send');
class ComWechat {
    public static function sc_send($comment, $post)
    {

       /*发出提示*/
       Notice('操作成功!');

       if ($comment['authorId'] == 1) {
            return $comment;
        }        
             
       $text = "有人在您的博客发表了评论";
       $desp = "**".$comment['author']."** 在 [「".$post->title."」](".$post->permalink." \"".$post->title."\") 中说到: \n\n > ".$comment['text'];
       
       Deng_Plugin::newsend($text,$desp);
       
       
      
       return $comment;
    }
}



