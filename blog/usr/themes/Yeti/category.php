<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

<div id="site-content" class="site-content pt-0">
	<div id="list_videos_common_videos_list">
		<section class="content-header">
			<div class="container">
				<div class="title-with-avatar center">
					<div class="title-box">
						<h2 class="h3-md mb-1"><?php $this->archiveTitle(array( 'category'  =>  _t('%s'), 'search' => _t('包含关键字 %s 的文章'), 'tag' => _t('标签 %s 下的文章'), 'author' => _t('%s 发布的文章')), '', ''); ?></h2>
						<span class="inactive-color fs-2 mb-0"><?php echo $this->getDescription(); ?></span>
					</div>
				</div>
			</div>
		</section>
		<div class="container">
			<section class="pb-3 pb-e-lg-40">
				<div class="row gutter-20">
				 	
				 	<?php if($this->have()):?>
                    <?php while($this->next()): ?>    
				 	<div class="col-6 col-sm-4 col-lg-3">
						<div class="video-img-box mb-e-20">
							<div class="img-box cover-md">
								<a href="<?php $this->permalink() ?>">
									<img class="lazyload" src="<?php $this->options->lazyimg(); ?>" data-src="<?php echo stcdnimg($this->fields->img); ?>" data-preview="">
								</a>
							</div>
							<div class="detail">
								<h6 class="title"><a href="<?php $this->permalink() ?>"><?php $this->title() ?></a></h6>
								<p class="sub-title">
									<svg class="mr-1" height="15" width="15">
										<use xlink:href="#icon-eye"></use>
									</svg><?php Postviews($this); ?>	
									<svg class="ml-3 mr-1" height="13" width="13">
										<use xlink:href="#icon-heart-inline"></use>
									</svg><?php echo zannum($this->cid); ?>									
								</p>
							</div>
							
						</div>
					</div>
					<?php endwhile; ?>
					<?php endif; ?>
					
					
				</div>
			</section>
		</div>
		<?php $this->need('lib/pagination.php'); ?>
	</div>
</div>

<?php $this->need('footer.php'); ?>