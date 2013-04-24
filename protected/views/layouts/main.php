<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Bootstrap -->
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.css" rel="stylesheet" media="screen">

		<style type="text/css">
			body {
				padding-top: 60px;
				padding-bottom: 40px;
			}
		</style>

		<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-responsive.css" rel="stylesheet">
    </head>
    <body>
        <!-- Navigationsleiste -->
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <!-- Collapse-Button -->
                    <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="brand" href="<?php echo Yii::app()->createUrl('post/show'); ?>">lloco</a>
                    <div class="nav-collapse collapse">
                        <ul class="nav">
	                    </ul>
	                    <ul class="nav pull-right">
	                    	<?php
	                    	if (Yii::app()->user->isGuest)
	                    		$this->widget('LLoginForm');
	                    	else
	                    		$this->widget('LUserMenu');
	                    	?>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
            </div>
        </div>

        <div class="container">
        <?php echo $content; ?>
        </div>

        <footer class="container">
            <div class="row">
                <div class="span4">
                    <p>
                        <span class="label label-important"><i class="icon-map-marker icon-white"></i> <strong><span id="posts"> </span></strong> Posts
                    </p>
                </div>
            </div>
        </footer>

        <script src="http://code.jquery.com/jquery.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap.min.js"></script>
        <script src="http://localhost:8000/socket.io/socket.io.js"></script>
        <script>
            window.onload = function () {
                var socket = io.connect("http://localhost:8000");
                
                var postsSpan = document.getElementById("posts");
                
                socket.on('status', function (data) {
                    var status = JSON.parse(data);
                    postsSpan.firstChild.nodeValue = status.posts;
                });
            }
    </script>
    </body>
</html>