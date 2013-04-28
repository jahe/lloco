
<div class="row">
	<div class="span6">
	<?php
	foreach ($posts as $postnr => $postdata)
	{
	?>
	<article>
		<header>
			<h1><?php echo $postdata->title; ?></h1>
		</header>
		<p><?php echo $postdata->content; ?></p>
		<footer>
			<p>von <?php echo $postdata->_id; ?> in <?php echo $postdata->category; ?></p>
		</footer>
	</article>
	<?php
	}
	?>
	</div>
	<div class="span6">
		<div id="map" style="height:600px;">
		</div>
	</div>
</div>