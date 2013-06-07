<?php
foreach ($posts as $post)
{
?>
<section>
	<header>
		<h3><a href="<?php echo Yii::app()->createUrl('post/show', ['postid' => $post['_id']]); ?>"><?php echo $post['title']; ?></a></h3>
		<p><?php echo date('d.m.Y, H:i \U\h\r', $post['createTime']); ?></p>
	</header>
	<p><?php echo $post['content']; ?></p>
	<footer>
		<p>von <?php echo $post['author']; ?> in <?php echo $post['category']; ?></p>
	</footer>
</section>
<hr>
<?php
}
?>
