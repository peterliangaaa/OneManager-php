<?php $this->related(4)->to($relatedPosts); ?>	
<?php if ($relatedPosts->have()): ?>
<section class="pb-3 pb-e-lg-40">
							<div class="title-with-more">
								<div class="title-box">
									<h6 class="sub-title inactive-color">推荐</h6>
									<h2 class="h3-md">猜你喜欢</h2>
								</div>
							</div>
							<div class="row gutter-20">
									
								<?php while ($relatedPosts->next()): ?>	
								<div class="col-6 col-sm-4 col-lg-3">
									<div class="video-img-box mb-e-20">
										<div class="img-box cover-md">
											<a href="<?php $relatedPosts->permalink(); ?>">
												<img class="lazyload" src="<?php $this->options->lazyimg(); ?>" data-src="<?php echo stcdnimg($relatedPosts->fields->img); ?>" data-preview="">
											</a>
										
										</div>
										<div class="detail">
											<h6 class="title"><a href="<?php $relatedPosts->permalink(); ?>"><?php $relatedPosts->title(); ?></a></h6>
											<p class="sub-title">
												<svg class="mr-1" height="15" width="15">
													<use xlink:href="#icon-eye"></use>
												</svg><?php Postviews($relatedPosts); ?>
												<svg class="ml-3 mr-1" height="13" width="13">
													<use xlink:href="#icon-heart-inline"></use>
												</svg><?php echo zannum($relatedPosts->cid); ?>	
											</p>
										</div>

									</div>
								</div>
								<?php endwhile; ?>
							</div>
</section>
<?php endif; ?>	