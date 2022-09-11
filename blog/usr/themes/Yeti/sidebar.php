                        <div class="col right-sidebar">
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
$html=$html.'<div class="col-6 col-sm-4 col-lg-12">
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
											</svg>'.$views.'											<svg class="ml-3 mr-1" height="13" width="13">
												<use xlink:href="#icon-heart-inline"></use>
											</svg>'.$likes.'										</p>
									</div>
								</div>
							    </div>';


}
echo $html;                  
?> 
							
							
						</div>
					</div>