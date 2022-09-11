<?php

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
require_once("core/theme.php");
require_once("core/oin.php");
require_once("core/member.php");
require_once("core/admin_set.php");
function themeConfig($form)
{
    $index = Helper::options()->siteUrl;
?>  
    <link rel="stylesheet" href="<?php echo THEME_URL ?>/core/setting.s.css">
    <script src="<?php echo THEME_URL ?>/core/setjs.js"></script>
    <script src="//cdn.staticfile.org/jquery/3.4.1/jquery.min.js"></script>  
    <div class="j-setting-contain">
        <link href="<?php echo THEME_URL ?>/core/j.setting.min.css" rel="stylesheet" type="text/css" />
        <div>
            <div class="j-aside">
                <div class="logo">设置面板</div>
                <ul class="j-setting-tab">
                    <li data-current="j-setting-notice">最新公告 Noti</li>
                    <li data-current="j-setting-global">常规设置 Set</li>
                    <li data-current="j-setting-index">首页设置 Index</li>
                    <li data-current="j-setting-color">风格样式 Style</li>
                    <li data-current="j-setting-aside">边栏页脚 Side</li>
                    <li data-current="j-setting-seo">SEO设置 Seo</li>
                    
                </ul>
                <?php require_once("core/backup.php"); ?>
            </div>
        </div>
        
    <div class="j-setting-notice">
    <!--公告-->  
    <div class="miracles-pannel pannel_clo">
    <span class="spimes_logo" href="javascript:;"></span>
	<h1>Yeti 设置面板</h1>
	<p>Yeti 自适应视频模板。</p>
    <hr><p>提交sitemap可以向搜索提交网站的sitemap文件，帮助spider更好的抓取您的网站。</p>
    <p>sitemap.xml地图：<a href='<?php echo $index ?>sitemap.xml' target='_blank'><?php echo $index ?>sitemap.xml</a> <a href='https://ziyuan.baidu.com/linksubmit'>(地图提交)</a><p>
 
	</div>
	
	<!--公告-->  
    </div>
        <script src="<?php echo THEME_URL ?>/core/j.setting.min.js"></script>
    <?php
    
    //网站模式

	$favicon = new Typecho_Widget_Helper_Form_Element_Text('favicon', NULL, NULL, _t('favicon地址'), _t('一般为http://www.yourblog.com/image.png,支持 https:// 或 //,留空则不设置favicon'));
    $form->addInput($favicon);
    $favicon->setAttribute('class', 'j-setting-content j-setting-global');

    $logoimg = new Typecho_Widget_Helper_Form_Element_Text('logoimg', NULL, NULL, _t('logo地址'), _t('一般为http://www.yourblog.com/image.png,支持 https:// 或 //'));
    $form->addInput($logoimg);
    $logoimg->setAttribute('class', 'j-setting-content j-setting-global');
    
    $lazyimg = new Typecho_Widget_Helper_Form_Element_Text('lazyimg', NULL, NULL, _t('lazyimg地址'), _t('一般为http://www.yourblog.com/image.png,支持 https:// 或 //'));
    $form->addInput($lazyimg);
    $lazyimg->setAttribute('class', 'j-setting-content j-setting-global');
    
    $dhtop = new Typecho_Widget_Helper_Form_Element_Text('dhtop', NULL, NULL, _t('首页推荐文章id设置'), _t('首页推荐文章id设置'));
    $form->addInput($dhtop); 
    $dhtop->setAttribute('class', 'j-setting-content j-setting-global');
    
    $topnav = new Typecho_Widget_Helper_Form_Element_Textarea('topnav', NULL, NULL, _t('头部导航链接'), _t('一行一个链接,格式为：名称|链接'));
    $form->addInput($topnav);
    $topnav->setAttribute('class', 'j-setting-content j-setting-index');
    
  	$webcss = new Typecho_Widget_Helper_Form_Element_Textarea('webcss', NULL, NULL, _t('自定义CSS'), _t('自定义样式'));
    $form->addInput($webcss);
    $webcss->setAttribute('class', 'j-setting-content j-setting-color');

	$tophtml = new Typecho_Widget_Helper_Form_Element_Textarea('tophtml', NULL, NULL, _t('页头代码'), _t('添加在页面</head>前,比如：站长平台HTML验证代码,谷歌分析代码'));
    $form->addInput($tophtml);
    $tophtml->setAttribute('class', 'j-setting-content j-setting-aside');

	$foothtml = new Typecho_Widget_Helper_Form_Element_Textarea('foothtml', NULL, NULL, _t('页脚代码'), _t('添加在页面</body>前,比如：客服工具等js代码，注意 统计代码不在这里填！！'));
    $form->addInput($foothtml);
    $foothtml->setAttribute('class', 'j-setting-content j-setting-aside');
  
	$footnav = new Typecho_Widget_Helper_Form_Element_Textarea('footnav', NULL, NULL, _t('页脚版权设置'), _t('页脚版权/备案信息，比如：版权所有 本站内容未经书面许可,禁止一切形式的转载。粤ICP备123456号-1. All rights reserved.'));
    $form->addInput($footnav);
    $footnav->setAttribute('class', 'j-setting-content j-setting-aside');

    $zztj = new Typecho_Widget_Helper_Form_Element_Text('zztj', NULL, NULL, _t('网站统计代码'), _t('在这里填入你的网站统计代码,这个可以到百度统计或者cnzz上申请。'));
    $form->addInput($zztj);
    $zztj->setAttribute('class', 'j-setting-content j-setting-aside');

	$footernav = new Typecho_Widget_Helper_Form_Element_Textarea('footernav', NULL, NULL, _t('底部链接（友情链接）'), _t('一行一个链接,格式为：名称|链接'));
    $form->addInput($footernav);
    $footernav->setAttribute('class', 'j-setting-content j-setting-aside');
  
    $seotitle = new Typecho_Widget_Helper_Form_Element_Text('seotitle', NULL, NULL, _t('首页标题<b style="color: red;">✱</b>'), _t('首页SEO标题，不设置默认显示[设置]里面的站点标题和描述，<b style="color: red;">关键字和描述，请到程序设置</b>'));
    $form->addInput($seotitle);
    $seotitle->setAttribute('class', 'j-setting-content j-setting-seo');

	$themecompress = new Typecho_Widget_Helper_Form_Element_Select('themecompress',array('0'=>'不开启','1'=>'开启'),'0','HTML压缩功能','是否开启HTML压缩功能,缩减页面代码');
    $form->addInput($themecompress);
    $themecompress->setAttribute('class', 'j-setting-content j-setting-seo');

	
    $cdnopen = new Typecho_Widget_Helper_Form_Element_Select('cdnopen',array('0'=>'不开启','1'=>'开启'),'0','开启镜像存储','可不开启，关闭状态下，镜像存储，镜像源，子域名cdn则无效');
    $form->addInput($cdnopen);	
    $cdnopen->setAttribute('class', 'j-setting-content j-setting-seo');
	
	$cdnurla = new Typecho_Widget_Helper_Form_Element_Text('cdnurla', NULL, NULL, _t('镜像存储-镜像源'), _t('利用镜像存储做cdn缓存图片文件,格式：www.yourblog.com/ ,记得带上/,不带http或者https,和七牛之类云存储所填的保持一致'));
    $form->addInput($cdnurla);
    $cdnurla->setAttribute('class', 'j-setting-content j-setting-seo');

	$cdnurlb = new Typecho_Widget_Helper_Form_Element_Text('cdnurlb', NULL, NULL, _t('镜像存储-子域名'), _t('利用镜像存储做cdn缓存图片文件,和第三方存储所填的域名保持一致即可,格式：xxx.yourblog.com/ '));
    $form->addInput($cdnurlb);
    $cdnurlb->setAttribute('class', 'j-setting-content j-setting-seo');
    
    $imageView = new Typecho_Widget_Helper_Form_Element_Text('imageView', NULL, NULL, _t('文章内第三方存储图片后缀'), _t('第三方存储的处理接口样式，填入则开启,注意开头是否需要以？开头 '));
    $form->addInput($imageView);
    $imageView->setAttribute('class', 'j-setting-content j-setting-seo');


}


//后台编辑器添加功能
function themeFields($layout) {
  
    $img = new Typecho_Widget_Helper_Form_Element_Text('img', NULL, NULL, _t('封面图'), _t('在这里填入一个图片 URL 地址, 以添加显示本文的缩略图，留空则显示默认缩略图'));
    $img->input->setAttribute('class', 't-basics-find');
    $layout->addItem($img);
    
    $videourl = new Typecho_Widget_Helper_Form_Element_Text('videourl', NULL, NULL, _t('视频链接'), _t('在这里填入一个视频 URL 地址, 以添加显示视频，留空则没有'));
    $videourl->input->setAttribute('class', 't-basics-find');
    $layout->addItem($videourl); 
	
}




function themeInit($archive) {
    
/* 强制用户关闭反垃圾保护 */
Helper::options()->commentsAntiSpam = false;
/* 强制用户关闭检查来源URL */
Helper::options()->commentsCheckReferer = false;
/* 强制用户强制要求填写邮箱 */
Helper::options()->commentsRequireMail = true;
/* 强制用户强制要求无需填写url */
Helper::options()->commentsRequireURL = false; 
Helper::options()->commentsMaxNestingLevels = '5'; //最大嵌套层数
Helper::options()->commentsOrder = 'DESC'; //将最新的评论展示在前
Helper::options()->commentsHTMLTagAllowed = '<a href=""> <img src=""> <img src="" class=""> <code> <del>';

}




//自定义字段扩展
Typecho_Plugin::factory('admin/write-post.php')->bottom = array('diyfield', 'one');
Typecho_Plugin::factory('admin/write-page.php')->bottom = array('diyfield', 'one');
class diyfield {
    public static function one()
    {
    ?>
    <style>
        .tabss{margin:10px;clear:both;display:block;height:30px;padding:0}.tabss a{outline:none!important}
    </style>
  
    <script>
        $(function(){
            var tabs = '<ul class="typecho-option-tabs tabss" style=""><li class="current" id="t-basics"><a href="javascript:;">基础设置</a></li><li class="" id="t-seo"><a href="javascript:;">SEO设置</a></li></ul>';
            $("#custom-field-expand").after(tabs);
        
            //初始化，全部隐藏
            $("#custom-field>table>tbody").find("tr").hide();
        
            //初始化显示
            $(".tabss>li.current").parent().siblings("table").find('.t-basics-find').parent().parent().parent().show();
        
        
            $(".tabss li").click(function(){
                var clasz = this.id;
                //删除同胞的current
                $(this).siblings().removeClass('current');
                //自身添加current
                $(this).addClass('current');
                //全部隐藏
                $("#custom-field>table>tbody").find("tr").hide();
                //显示自身底下的子元素
                $(".tabss>li.current").parent().siblings("table").find('.'+clasz+'-find').parent().parent().parent().show();

            });
        
        
        });
    </script>

<?php
    }
}


?>




