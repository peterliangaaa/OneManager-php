<footer id="site-footer" class="site-footer py-5">
						<div class="container">
							<div class="row">
								<div class="col-lg-8 order-2 order-lg-1">
									
					<?php if($this->options->logoimg): ?>
	                <img src="<?php $this->options->logoimg();?>" class="mb-4" height="28">
	                <?php else : ?>
	                <?php $this->options->title() ?>
	                <?php endif; ?>
									
									<div>
										<a href="#" target="_blank">
											<svg height="18" width="18">
												<use xlink:href="#icon-ig"></use>
											</svg>
										</a>
										<a href="#" target="_blank">
											<svg height="18" width="18">
												<use xlink:href="#icon-fb"></use>
											</svg>
										</a>
										<p class="pt-2 m-0"><?php if($this->options->footnav){$this->options->footnav();} ?><?php $this->options->zztj(); ?></p>
											
									</div>
								</div>
								<div class="col-lg-4 order-1">
										<div class="row">
											<div class="col-6">
												<div class="widget">
													<h5 class="widget-title">关于</h5>
													<ul class="list-inline vertical-list">
														<li>
														<a href="#">投放广告</a>
														</li>
														<li>
														<a href="#">联系我们</a>
														</li>
														<li>
														<a href="#">备用网址</a>
														</li>
													</ul>
												</div>
											</div>
											<div class="col-6">
												<div class="widget">
													<h5 class="widget-title">政策</h5>
													<ul class="list-inline vertical-list">
														<li>
														<a href="#">使用条款</a>
														</li>
														<li>
														<a href="#">滥用报告</a>
														</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
							</div>
						</div>
					</footer>
					<?php $this->need('lib/svg.php'); ?>
					<?php if ($this->options->foothtml): ?>
<?php $this->options->foothtml(); ?>
<?php endif; ?>
<?php if ($this->options->themecompress == '1'):?>
<?php error_reporting(0); $html_source = ob_get_contents(); ob_clean(); print compressHtml($html_source); ob_end_flush(); ?>
<?php endif; ?>
<?php $this->footer(); ?>
				</body>
			</html>