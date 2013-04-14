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
		<p>von <?php echo $postdata->username; ?></p>
	</footer>
</article>
<?php
}
?>