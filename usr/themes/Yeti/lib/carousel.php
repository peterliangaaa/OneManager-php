<?php if ($this->options->dhtop): ?>
<div class="jable-carousel jable-animate overflow-h" data-animation="slideRight" data-animation-item=".item"
				 data-auto-width="no" data-dots="no" data-loop="yes" data-center="yes" data-items-responsive="0:2|992:4">
					<div class="gutter-20 gutter-xl-30 pb-3">
						<div class="owl-carousel">
						    
<?php 
$lunbotop = $this->options->dhtop;
$hang = explode(",", $lunbotop);
$n=count($hang);
$html="";
for($i=0;$i<$n;$i++){
$this->widget('Widget_Archive@lunbotop'.$i, 'pageSize=1&type=post', 'cid='.$hang[$i])->to($jis);
if($i==0){$no=" sx_no";}else{$no="";}
$str = stcdnimg($jis->fields->img);
$str1 = $this->options->lazyimg;

$html=$html.'<div class="item">
								<div class="video-img-box">
									<div class="img-box">
										<a href="'.$jis->permalink.'">
											<img class="lazyload" src="'.$str1.'" data-src="'.$str.'">
											<div class="ribbon-top-left">精選</div>
										</a>
									</div>
								</div>
							</div>';

}
echo $html;
?>
						    
							
													
						</div>
					</div>
				</div>
<?php endif; ?>				