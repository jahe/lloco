<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<div id="postCarousel" class="carousel slide">
	<ol class="carousel-indicators">
		<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
		<li data-target="#myCarousel" data-slide-to="1"></li>
		<li data-target="#myCarousel" data-slide-to="2"></li>
	</ol>
	<!-- Carousel items -->
	<div class="carousel-inner">
		<div class="active item">
			<img alt="land1" src="http://www.whitegadget.com/attachments/pc-wallpapers/16950d1224057972-landscape-wallpaper-blue-river-scenery-wallpapers.jpg">
			<div class="carousel-caption">
				<h4>First Thumbnail label</h4>
				<p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
			</div>
		</div>
		<div class="item">
			<img alt="land2" src="http://upload.wikimedia.org/wikipedia/commons/e/e2/Norway_sheep_and_landscape.jpg">
		</div>
		<div class="item">
			<img alt="löwe" src="http://thumb.baseheadart.com/afP_7.jpg">
		</div>
	</div>
	<!-- Carousel nav -->
	<a class="carousel-control left" href="#postCarousel" data-slide="prev">&lsaquo;</a>
	<a class="carousel-control right" href="#postCarousel" data-slide="next">&rsaquo;</a>
</div>