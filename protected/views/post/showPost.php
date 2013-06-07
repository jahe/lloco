<?php
//Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/showPostMap.js', CClientScript::POS_END);

if (!Yii::app()->user->isGuest)
{
	//Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/likedislike.js', CClientScript::POS_END);
//Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/comment.js', CClientScript::POS_END);
}

//echo '<pre>'; print_r($post); echo '<pre/>';

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/showPost.css');
?>


<article class="span8">
	<header class="postHeader">
		<?php
		if (!Yii::app()->user->isGuest)
			if($post['authorId']->__toString() === Yii::app()->user->id->__toString())
			{
		?>
			<div class="pull-right">
				<button id="postDelete" class="btn btn-mini btn-danger">Löschen</button>
			</div>
			<script type="text/javascript">
				(function() {
					$(document).ready(function() {
						$('#postDelete').click(function() {
							console.log("deleeeeeeete post!");
							$.ajax({
								url: "<?php echo Yii::app()->createUrl('post/delete'); ?>",
								data: {postid : "<?php echo $post['_id']; ?>"},
								datatype: "json",
								type: "POST",
								success: function(data) {
									window.location.replace("<?php echo Yii::app()->createAbsoluteUrl('post/overview'); ?>");
								}
							});
						});
					});
				})();
			</script>
		<?php
			}
		?>
		<div class="pull-left">
			<a href="<?php echo Yii::app()->createUrl('user/profile', ['user' => $post['author']]); ?>">
				<img src="<?php echo Yii::app()->createUrl('user/getprofileimg', ['user' => $post['author'], 'width' => 64, 'height' => 64]); ?>">
			</a>
		</div>
		<div style="overflow: hidden;">
			<p><a href="<?php echo Yii::app()->createUrl('user/profile', ['user' => $post['author']]); ?>">
				<?php echo $post['author']; ?>
			</a> in <span class="label label-success"><i class="icon-map-marker icon-white"></i> <?php echo $post['category']; ?></span></p>
			<h4><?php echo $post['title']; ?></h4>
			<p><?php echo date('d.m.Y, H:i \U\h\r', $post['createTime']); ?></p>
		</div>
	</header>
	<div>
		<p><?php echo $post['content']; ?></p>
		<div class="tabbable"> <!-- Only required for left/right tabs -->
			<ul class="nav nav-tabs">
				<li><a href="#mapTab" data-toggle="tab">Map</a></li>
			<?php
			if (count($post['pics']) > 0)
			{
			?>
				<li><a href="#picsTab" data-toggle="tab">Bilder</a></li>
			<?php
			}
			?>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="mapTab">
					<div id="map" style="height: 200px">
					</div>
				</div>
			<?php
			if (count($post['pics']) > 0)
			{
			?>
				<div class="tab-pane" id="picsTab">
					<div id="postCarousel" class="carousel slide">
						<ol class="carousel-indicators">
						<?php
						for ($i = 0; $i < count($post['pics']); $i++)
						{
						?>
							<li data-target="#myCarousel" data-slide-to="<?php echo $i; ?>"></li>
						<?php
						}
						?>
						</ol>
						<!-- Carousel items -->
						<div class="carousel-inner">
						<?php
						for ($i = 0; $i < count($post['pics']); $i++)
						{
						?>
							<div class="item <?php echo $i == 0 ? "active" : ""; ?>">
								<img src="<?php echo Yii::app()->createUrl('post/getimg', ['fileid' => $post['pics'][$i]->__toString()]); ?>">
							</div>
						<?php
						}
						?>
						</div>
						<!-- Carousel nav -->
						<a class="carousel-control left" href="#postCarousel" data-slide="prev">&lsaquo;</a>
						<a class="carousel-control right" href="#postCarousel" data-slide="next">&rsaquo;</a>
					</div>
				</div>
			<?php
			}
			?>
			</div>
		</div>
	</div>
	<footer>
		<div style="overflow: hidden;">
			<?php
			if (!Yii::app()->user->isGuest)
			{
				?>
				<div class="pull-left">
					<button id="likebutton" type="button" class="<?php echo $post['likestate'] === 'like' ? 'active' : "" ?> btn btn-small"><i class="icon-thumbs-up"></i> Like</button>
					<!--<button type="button" class="btn btn-small"><i class="icon-circle-blank"></i></button>-->
					<button id="dislikebutton" type="button" class="<?php echo $post['likestate'] === 'dislike' ? 'active' : "" ?> btn btn-small"><i class="icon-thumbs-down"></i> Dislike</button>
				</div>
				<?php
			}
			?>
			<div class="pull-right">
				<div class="progress">
					<?php
					$likes = count($post['likes']);
					$dislikes = count($post['dislikes']);
					$likePercent = 0;
					$dislikePercent = 0;
					if ($likes + $dislikes > 0)
					{
						$likePercent = $likes * 100 / ($likes + $dislikes);
						$dislikePercent = $dislikes * 100 / ($likes + $dislikes);
					}
					?>
					<div id="likeProgress" class="bar bar-success" style="width: <?php echo $likePercent;?>%;"></div>
					<div id="dislikeProgress" class="bar bar-danger" style="width: <?php echo $dislikePercent;?>%;"></div>
				</div>
				<p><i class="icon-thumbs-up"></i> <span id="likeCounter"><?php echo $likes; ?></span> <i class="icon-thumbs-down"></i> <span id="dislikeCounter"><?php echo $dislikes; ?></span></p>
			</div>
		</div>
	</footer>
	<aside>
		<h4 style="display: inline-block">Kommentare</h4> <button id="reloadButton" class="btn btn-mini btn-info"><i class="icon-rotate-right icon-white"></i></button>
		<?php
		if (!Yii::app()->user->isGuest)
		{
		?>
			<div class="clearfix">
				<div class="pull-left">
					<img src="<?php echo Yii::app()->createUrl('user/getprofileimg', ['user' => Yii::app()->user->username, 'width' => 64, 'height' => 64]); ?>">
				</div>
				<div style="overflow: hidden;">
					<form id="commentForm" action="" method="POST">
						<input type="text" name="content" id="commentText" style="overflow: hidden; display: block; width: 100%;" placeholder="Hier Kommentar schreiben..."></textarea>
						<button type="submit" id="commentButton" class="btn btn-primary pull-right">Posten</button>
					</form>
				</div>
			</div>
			<hr>
		<?php
		}
		?>

		<section id="commentList">
		<?php
		$this->renderPartial('listedComments', ['comments' => $post['comments']]);
		?>
		</section>
	</aside>
</article>






	<script type="text/javascript">

	function reloadComments() {
		$.ajax({
			url: "<?php echo Yii::app()->createUrl('post/getcomments'); ?>",
			// Daten, die an Server gesendet werden soll in JSON Notation
			data: {postid : "<?php echo $post['_id']; ?>"},
			datatype: "html",
			// Methode POST oder GET
			type: "GET",
			// Callback-Funktion, die die Posts im JSON-Format aufbereitet und auf der Map darstellt
			success: function(data) {
				$('#commentList').empty().append(data);
			}
		});
	}

	(function() {
		$(document).ready(function() {
			$("#likebutton").click(function() {
				$("#likebutton").button('toggle');
				toggleLikeDislikeState('like');
			});
			$("#dislikebutton").click(function() {
				$("#dislikebutton").button('toggle');
				toggleLikeDislikeState('dislike');
			});

			$("#reloadButton").click(function() {
				reloadComments();
			});

			$("#commentForm").submit(function() {
				sendComment();

				return false;
			});

			map = new L.Map('map');
			tile = new L.TileLayer('http://{s}.tile.cloudmade.com/8b600904281b42a6a54945da0a804c5d/997/256/{z}/{x}/{y}.png');

			var startPunkt = new L.LatLng(<?php echo $post['location'][1]; ?>, <?php echo $post['location'][0]; ?>);
			map.setView(startPunkt, 13).addLayer(tile);
			L.marker([<?php echo $post['location'][1]; ?>, <?php echo $post['location'][0]; ?>]).addTo(map);
		});

		function reloadLikeStats() {
			$.ajax({
				url: "<?php echo Yii::app()->createUrl('post/getlikestats'); ?>",
				data: {postid: "<?php echo $post['_id']; ?>"},
				datatype: "json",
				type: "GET",
				success: function(data) {
					$('#likeCounter').text(data.likes);
					$('#dislikeCounter').text(data.dislikes);

					var likePercent = 0.0;
					var dislikePercent = 0.0;

					if (data.likes + data.dislikes > 0) {
						likePercent = data.likes * 100 / (data.likes + data.dislikes);
						dislikePercent = data.dislikes * 100 / (data.likes + data.dislikes);
					}

					$('#likeProgress').css("width", likePercent + "%");
					$('#dislikeProgress').css("width", dislikePercent + "%");
				}
			});
		}

		function toggleLikeDislikeState(toggle) {
			$.ajax({
				url: "<?php echo Yii::app()->createUrl('post/likedislike'); ?>",
				data: {postid: "<?php echo $post['_id']; ?>", toggle : toggle},
				datatype: "json",
				type: "POST",
				success: function(data) {
					reloadLikeStats();
					switch(data.state) {
						case 'like':
							$("#likebutton").addClass('active');
							$("#dislikebutton").removeClass('active');
							break;
						case 'dislike':
							$("#likebutton").removeClass('active');
							$("#dislikebutton").addClass('active');
							break;
						case 'neutral':
							$("#likebutton").removeClass('active');
							$("#dislikebutton").removeClass('active');
							break;
						default:
							break;
					}
				}
			});
		}

		function sendComment() {
			var text = $('#commentText').val();
			$('#commentText').val("");

			if (text !== "")
			{
				$.ajax({
					url: "<?php echo Yii::app()->createUrl('post/createcomment'); ?>",
					data: {postId : "<?php echo $post['_id']; ?>", content : text},
					datatype: "json",
					type: "POST",
					success: function(data) {
						reloadComments();
					}
				});
			}
		}
	})();
	</script>