<?php
if (count($comments) > 0)
{
	foreach ($comments as $comment)
	{
	?>
		<div class="clearfix">
			<?php
			if (!Yii::app()->user->isGuest)
				if($comment['authorId']->__toString() === Yii::app()->user->id->__toString())
				{
			?>
				<div class="pull-right">
					<button class="btn btn-mini btn-danger commentDelete" commentid="<?php echo $comment['_id']; ?>">Löschen</button>
				</div>
			<?php
				}
			?>
			<div class="pull-left">
				<a href="<?php echo Yii::app()->createUrl('user/profile', ['user' => $comment['author']]); ?>">
					<img class="img-polaroid" src="<?php echo Yii::app()->createUrl('user/getprofileimg', ['user' => $comment['author'], 'width' => 64, 'height' => 64]); ?>">
				</a>
			</div>
			<div>
				<header>
					<p>
						<a href="<?php echo Yii::app()->createUrl('user/profile', ['user' => $comment['author']]); ?>">
							<?php echo $comment['author']; ?>
						</a>, <?php echo date('d.m.Y, H:i \U\h\r', $comment['createTime']); ?>
					</p>
				</header>
				<p><?php echo $comment['content']; ?></p>
			</div>
		</div>
		<hr>
	<?php
	}
	?>
	<script type="text/javascript">
	(function() {
			$(document).ready(function() {
				$('.commentDelete').click(function(event) {
					$.ajax({
						url: "<?php echo Yii::app()->createUrl('post/deletecomment'); ?>",
						// Daten, die an Server gesendet werden soll in JSON Notation
						data: {commentid : event.target.attributes.commentid.value},
						datatype: "json",
						// Methode POST oder GET
						type: "POST",
						// Callback-Funktion, die die Posts im JSON-Format aufbereitet und auf der Map darstellt
						success: function(data) {
							if (data.done === false)
								alert("Du bist nicht der Author dieses Kommentars. Du darfst ihn nicht löschen!");
							
							reloadComments();
						}
					});
				});
			})
		})();
	</script>
<?php
}
else
	echo ("<p>Es wurde noch kein Kommentar hinterlassen.</p>");
?>