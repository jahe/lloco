<section>
<h1>Kommentare</h1>
<?php foreach ($comments as $comment): ?>
	<article>
		<header>
			<h1><?php echo CHtml::encode($comment->title); ?></h1>
			<p><?php echo date('d.m.Y, H:i \U\h\r', $comment->createTime); ?></p>
		</header>
		<p><?php echo nl2br(CHtml::encode($comment->content)); ?></p>
	</article>
<?php endforeach; ?>
</section>