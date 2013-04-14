<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Bootstrap -->
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <style>
            body {
                padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
            }
        </style>



        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

        <!--<link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/main.css">
        <script src="js/vendor/modernizr-2.6.2.min.js"></script>-->
    </head>
    <body>
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    </button>
                    <a class="brand" href="<?php echo Yii::app()->baseUrl; ?>">lloco</a>
                    <div class="nav-collapse collapse">
                        <ul class="nav">
                        <li class="active"><a href="<?php echo $this->createUrl('post/show'); ?>">Home</a></li>
                        <li><a href="<?php echo $this->createUrl('post/create'); ?>">Neuer Post</a></li>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
            </div>
        </div>

        <div class="container">
        <?php echo $content; ?>
        </div>

        <script src="http://code.jquery.com/jquery.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap.min.js"></script>
    </body>
</html>