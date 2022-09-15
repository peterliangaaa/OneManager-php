<?php
/**
 * Yeti 自适应视频模板
 *
 * @package Yeti Theme
 * @author 小灯泡设计
 * @version 1.0.0
 * @link https://www.dpaoz.com/
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>
			<div id="site-content" class="site-content">
				<?php $this->need('lib/carousel.php'); ?>
				<div class="container">
					<section class="py-3 pb-e-lg-40">
						<div class="title-with-more">
							<div class="title-box">
								<h6 class="sub-title inactive-color">新鮮</h6>
								<h2 class="h3-md">最近更新</h2>
							</div>
							<div class="more">
								<a href="/index.php/label/new.html">
									更多
									<svg class="pl-1" height="20" width="20">
										<use xlink:href="#icon-arrow-right"></use>
									</svg>
								</a>
							</div>
						</div>
						<div class="jable-carousel" data-dots="yes" data-items-responsive="0:2|576:3|992:4">
							<div class="gutter-20">
								<div class="owl-carousel owl-theme-jable">
										
									<?php $this->widget('Widget_Contents_Post_Recent','pageSize=20')->to($news);?>
                                    <?php if($news->have()):?>
                                    <?php while($news->next()): ?>	
									<div class="item">
										<div class="video-img-box mb-e-20">
											<div class="img-box cover-md">
												<a href="<?php $news->permalink(); ?>">
													<img class="lazyload" src="<?php $this->options->lazyimg(); ?>" data-src="<?php echo stcdnimg($news->fields->img); ?>" data-preview="">
												</a>
											</div>
											<div class="detail">
											<h6 class="title"><a href="<?php $news->permalink(); ?>"><?php $news->title() ?></a></h6>
												<p class="sub-title">
													<svg class="mr-1" height="15" width="15">
														<use xlink:href="#icon-eye"></use>
													</svg><?php Postviews($news); ?>
													<svg class="ml-3 mr-1" height="13" width="13">
														<use xlink:href="#icon-heart-inline"></use>
													</svg><?php echo zannum($news->cid); ?>					
												</p>
											</div>
										</div>
									</div>
									<?php endwhile; ?>
                                    <?php endif; ?>	
									
							</div>
							</div>
						</div>
					</section>
					
					<section class="pb-3 pb-e-lg-40">
						<div class="title-with-more">
							<div class="title-box">
								<h6 class="sub-title inactive-color">本周</h6>
								<h2 class="h3-md">热门影片</h2>
							</div>
						</div>
						<div class="row gutter-20">
						<?php theMostViewed(); ?>
						</div>
					</section>
					<section class="pb-3 pb-e-lg-40">
						<div class="title-with-more">
							<div class="title-box">
								<h6 class="sub-title inactive-color">动态</h6>
								<h2 class="h3-md">他们在看</h2>
							</div>
						</div>
						
						<div class="row gutter-20">
						    
						    
<?php  

$html = null;
$counts = Typecho_Db::get()->fetchAll(Typecho_Db::get()
->select()                                      
->from('table.contents')
->where('type = ?', 'post')
->where('status = ?', 'publish')                                  
->order('agree', Typecho_Db::SORT_DESC)
->limit('8')
); 
foreach ($counts as $count) {              
$this->widget('Widget_Archive@hots'.$count['cid'], 'pageSize=1&type=post', 'cid='.$count['cid'])->to($ji);
$likes = $count['agree'];
$created = date('m-d', $ji->created);
$str = stcdnimg($ji->fields->img);  
$str1 = $this->options->lazyimg;
$views = $count['views']; 
							    
$html=$html.'<div class="col-6 col-sm-4 col-lg-3">
								<div class="video-img-box mb-e-20">
									<div class="img-box cover-md">
										<a href="'.$ji->permalink.'">
											<img class="lazyload" src="'.$str1.'" data-src="'.$str.'">
										</a>
										
									</div>
									<div class="detail">
										<h6 class="title"><a href="'.$ji->permalink.'">'.$ji->title.'</a></h6>
										<p class="sub-title">
											<svg class="mr-1" height="15" width="15">
												<use xlink:href="#icon-eye"></use>
											</svg>'.$views.'
											<svg class="ml-3 mr-1" height="13" width="13">
												<use xlink:href="#icon-heart-inline"></use>
											</svg>'.$likes.'
										</p>
									</div>
								</div>
							    </div>';							    


}
echo $html;                  
?> 
						    
								
								
							
						</div>
					</section>
					<?php if($this->options->footernav): ?>
					<div class="link_row">
						<div class="pannel clearfix">
							<div class="pannel_head clearfix">
								<h3 class="title">友情链接</h3>	
							</div>
							<ul class="link_text list_scroll clearfix">
							<?php footernav();?>
						    </ul>
						</div>
					</div>
					<?php endif; ?>
				</div>
			</div>

<?php $this->need('footer.php'); ?>