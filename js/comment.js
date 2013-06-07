/* Kommentare Schreiben */

(function() {
	$(document).ready(function() {
		$('#commentButton').click(function() {
			sendComment();
		});
	});

	function sendComment() {
		var text = $('#commentText').val();
		if (text !== "")
		{
			$.ajax({
				url: "<?php echo Yii::app()->createUrl('post/createcomment'); ?>",
				// Daten, die an Server gesendet werden soll in JSON Notation
				data: {postId : "<?php echo $post['_id']; ?>", content : text},
				datatype: "json",
				// Methode POST oder GET
				type: "POST",
				// Callback-Funktion, die die Posts im JSON-Format aufbereitet und auf der Map darstellt
				success: function(data) {
					console.log(data);
				}
			});
		}
	}
})();