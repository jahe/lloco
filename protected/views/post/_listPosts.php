<?php
foreach ($posts as $post)
{
?>
	<article>
		<header>
			<h1><?php echo CHtml::link($post->title, Yii::app()->createUrl('post/view', array('id' => $post->_id))); ?></h1>
			<p><?php echo date('d.m.Y, H:i \U\h\r', $post->createTime); ?>
			in 
			<?php
				$distance = Post::distance($location[0], $location[1], $post->longitude, $post->latitude);
				if ($distance < 1.0)
					echo round($distance * 1000.0, 2) . ' m';
				else
					echo round($distance, 2) . ' km';
			?> Entfernung</p>
		</header>
		<p><?php echo $post->content; ?></p>
		<footer>
			<p>von <?php echo $post->authorId; ?> in <?php echo $post->category; ?></p>
		</footer>
	</article>
	<hr>
<?php
}
?>