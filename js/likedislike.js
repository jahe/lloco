/* Liken und Disliken */

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
	})

	function toggleLikeDislikeState(toggle) {
		$.ajax({
			url: "<?php echo Yii::app()->createUrl('post/likedislike'); ?>",
			data: {postid: "<?php echo $post['_id']; ?>", toggle : toggle},
			datatype: "json",
			type: "POST",
			success: function(data) {
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
})();