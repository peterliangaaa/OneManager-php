<nav class="app-nav">

				<div class="container">
					<div class="title-box">
						<h2 class="h3-md">分类</h2>
					</div>
					<div class="row gutter-20 pb-5">
					    
					<?php $this->widget('Widget_Metas_Category_List')->to($category); ?>
					<?php while($category->next()): ?>
					<div class="col-6 col-sm-4 col-lg-3 mb-3">
							<a class="h5 text-light" href="<?php $category->permalink(); ?>"><?php $category->name(); ?></a>
					</div>
					<?php endwhile; ?>
					</div>
					
										<div class="title-box">
						<h2 class="h3-md">视频</h2>
					</div>
					<div class="row gutter-20 pb-3">
					    
<?php $this->widget('Widget_Metas_Tag_Cloud', array('sort' => 'count', 'ignoreZeroCount' => true, 'desc' => true, 'limit' => 12))->to($tags); ?>
<?php if($tags->have()): ?>
<?php while ($tags->next()): ?>
<div class="col-6 col-sm-4 col-lg-3 mb-3">
<a class="tag text-light" href="<?php $tags->permalink(); ?>"><?php $tags->name(); ?></a>
</div>
<?php endwhile; ?>
<?php else: ?>
<?php _e('没有任何标签'); ?>
<?php endif; ?>	
					</div>
								</div>
			</nav>
			<header id="site-header" class="site-header">
				<div class="container">
					<div class="row header-wrap">
	
						<div class="col-auto col-md-5">
							<div class="app-nav-toggle">
								<div class="lines">
									<div class="line-1"></div>
									<div class="line-2"></div>
									<div class="line-3"></div>
								</div>
							</div>
							<nav class="navbar navbar-expand-lg">
								<div class="collapse navbar-collapse">
									<ul class="navbar-nav">
									    <li class="nav-item d-none d-md-block">
											<a href="<?php $this->options->siteUrl(); ?>"><?php _e('首页'); ?></a>
										</li>
									    <?php topnav();?>
									</ul>
								</div>
							</nav>
						</div>
						<div class="col-auto col-md-2 justify-content-center p-0">
					<a class="logo" href="<?php $this->options->siteUrl(); ?>">
					<?php if($this->options->logoimg): ?>
	                <img src="<?php $this->options->logoimg();?>" alt="<?php $this->options->title() ?>" />
	                <?php else : ?>
	                <?php $this->options->title() ?>
	                <?php endif; ?>
					</a>	
						</div>
						<div class="col-auto header-right">
							<div class="search">
								<form class="h-100 d-flex align-items-center" id="search" action="/index.php/vod/search.html" method="get" onSubmit="return qrsearch();">
									<label for="inputSearch" class="m-0">
										<svg height="22" width="22">
											<use xlink:href="#icon-search"></use>
										</svg>
									</label>
									<input id="inputSearch" class="h-100 fs-3" name="wd" placeholder="搜索.." value="">
								</form>
							</div>

							</div>
	
					</div>
				</div>
			</header>