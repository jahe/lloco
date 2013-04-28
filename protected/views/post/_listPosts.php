<?php
foreach ($posts as $post)
{
?>
	<article>
		<header>
			<h1><?php echo $post->title; ?></h1>
		</header>
		<p><?php echo $post->content; ?></p>
		<footer>
			<p>von <?php echo $post->authorId; ?> in <?php echo $post->category; ?></p>
		</footer>
	</article>
<?php
}
?>