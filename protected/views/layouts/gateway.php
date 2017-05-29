<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/profile.css" />
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/wahapi.css" />
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.css" />
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap_extend.css" />

    <!-- Include jQuery -->
    <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>

    <!-- librerías opcionales que activan el soporte de HTML5 para IE8 -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script type="text/javascript" src="http://js.pusher.com/2.2/pusher.min.js"></script>

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>

    <script type="text/javascript">
        function loadCSS(filename)
        { 
            var file = document.createElement("link")
            file.setAttribute("rel", "stylesheet")
            file.setAttribute("type", "text/css")
            file.setAttribute("href", filename)

            if (typeof file !== "undefined")
                document.getElementsByTagName("head")[0].appendChild(file)
        }
    </script>
</head>
<body>
    <div class="container-fluid" style="background-color:#86b704; background-image: url('<?php echo Yii::app()->request->baseUrl; ?>/images/bg_header.png'); border-bottom: 5px solid;">
        <div class="row">
            <div class="container">
                <button type="button" class="btn btn-icon" style="-webkit-border-radius: 50px; -moz-border-radius: 50px; border-radius: 50px; background-color:white;">
                    <a href="<?php echo Yii::app()->request->baseUrl; ?>" ><span style="font-size: 30px; color:#86b704;">Wahapi</span></a>
                </button>
            </div>
        </div>
    </div>

    <?php echo $content; ?>
    
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap.js"></script>
</body>
</html>
