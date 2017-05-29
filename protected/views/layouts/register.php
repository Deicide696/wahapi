<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css" /> -->

	<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/profile.css" />
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.css" />
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap_extend.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body style="background-image:url('<?php echo Yii::app()->request->baseUrl; ?>/images/bg_patron_register.png'); background-repeat: repeat-x; background-color:#eaeaef;">
	<div class="container" style="background-image:url('<?php echo Yii::app()->request->baseUrl; ?>/images/header.png'); background-repeat: no-repeat;">
		<?php echo $content; ?>
	</div>
	<script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-24044119-10', 'auto');
        ga('send', 'pageview');
    </script>
</body>
</html>
