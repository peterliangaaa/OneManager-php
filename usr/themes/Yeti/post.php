<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php

//  判断是否是点赞的 POST 请求
if (isset($_POST['agree'])) {
    //  判断 POST 请求中的 cid 是否是本篇文章的 cid
    if ($_POST['agree'] == $this->cid) {
        //  调用点赞函数，传入文章的 cid，然后通过 exit 输出点赞数量
        exit(agree($this->cid));
    }
    //  如果点赞的文章 cid 不是本篇文章的 cid 就输出 error 不再往下执行
    exit('error');
}

$this->need('header.php'); ?>

		<div id="site-content" class="site-content">
			<div class="container">
				<div class="row">
					<div class="col">
							<section class="pb-3 pb-e-lg-30">
							<div class="bofang_box">
							<?php if ($this->fields->videourl): ?>    
							<?php $this->need('ext/danmu/post - dmplay.php'); ?>
							<?php endif; ?>  
							</div>
							<style>
							@media (max-width:479px) { 
							.dmplay_sl{ min-height: 250px !important;}
							}
							.ifr_sl { width: 100%; height: 500px; margin-bottom: 20px; }
@media only screen and (max-width: 767px){
.ifr_sl { width: 100%; height: 220px !important; }
}
.dmplay_sl{min-height: 575px;}
							</style>
						</section>
						<section class="video-info pb-3">
							<div class="info-header">
								<div class="header-left">
								<h4><?php $this->title(); ?></h4>
								<h6>
										<svg class="mr-2" height="16" width="16"><use xlink:href="#icon-clock"></use></svg>
											<span class="mr-3"><?php echo date('Y-m-d' , $this->modified); ?></span>
										<svg class="mr-2" height="16" width="16"><use xlink:href="#icon-eye"></use></svg>
										<span class="mr-3"><?php Postviews($this); ?></span>
	
								</h6>
								</div>
								<!--
								<div class="header-right d-none d-md-block">
								<h6><span class="text-danger fs-1 mr-2">●</span>BD</h6>
								<span class="inactive-color">上市于 2020</span>
								</div>-->
								
							</div>
							<p class="intro"><?php $this->content(); ?></p>
							
							<div class="">
								<div class="my-3 text-center">
								    <?php $agree = $this->hidden?array('agree' => 0, 'recording' => true):agreeNum($this->cid); ?>
								    
									<button <?php echo $agree['recording']?'disabled':''; ?> id="agree-btn" data-cid="<?php echo $this->cid; ?>" data-url="<?php $this->permalink(); ?>" type="button" class="btn btn-action fav mr-2">
										<svg class="mr-2" height="18" width="16"><use xlink:href="#icon-heart"></use></svg>
										<span class="count digg_num agree-num"><?php echo $agree['agree']; ?></span>
									</button>

								</div>
								
				<h5 class="tags h6-md">
				<?php if( count($this->tags) == 0 ): ?>   
				<?php $this->category(',', true, 'none'); ?>
                <?php else: ?>
				<?php $this->tags('', true, ''); ?>
				<?php endif; ?>    
				</h5>
						</div>
						</section>
						<?php $this->need('lib/tuijian.php'); ?>
					</div>
					<?php $this->need('sidebar.php'); ?>
				</div>
			</div>
		</div>
<script>
//  点赞按钮点击
$('#agree-btn').on('click', function () {
  $('#agree-btn').get(0).disabled = true;  //  禁用点赞按钮
  //  发送 AJAX 请求
  $.ajax({
    //  请求方式 post
    type: 'post',
    //  url 获取点赞按钮的自定义 url 属性
    url: $('#agree-btn').attr('data-url'),
    //  发送的数据 cid，直接获取点赞按钮的 cid 属性
    data: 'agree=' + $('#agree-btn').attr('data-cid'),
    async: true,
    timeout: 30000,
    cache: false,
    //  请求成功的函数
    success: function (data) {
      var re = /\d/;  //  匹配数字的正则表达式
      //  匹配数字
      if (re.test(data)) {
        //  把点赞按钮中的点赞数量设置为传回的点赞数量
        $('#agree-btn .agree-num').html(data);
       
      }
    },
    error: function () {
      //  如果请求出错就恢复点赞按钮
      $('#agree-btn').get(0).disabled = false;
    },
  });
});

</script>
<?php $this->need('footer.php'); ?>