<article>
	<header>
		<h1><?php echo $post->title; ?></h1>
		<p><?php echo date('d.m.Y, H:i \U\h\r', $post->createTime); ?>
			in 
			<?php
				/*$distance = Post::distance($location[0], $location[1], $post->longitude, $post->latitude);
				if ($distance < 1.0)
					echo round($distance * 1000.0, 2) . ' m';
				else
					echo round($distance, 2) . ' km';*/
			?> Entfernung</p>
	</header>
	<p><?php echo $post->content; ?></p>
</article>

<p><?php echo $post->commentCount(); ?> Kommentare</p>

<?php
	//$this->renderPartial('_comments', array('comments' => $post->comments()));
	$this->renderPartial('_comments', array('comments' => $comments));
?>

<?php
	$this->renderPartial('/comment/_form', array('comment' => $comment));
?>