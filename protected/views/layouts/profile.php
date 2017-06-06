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
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/animate.css" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/font-awesome.min.css">

    <!-- Font Ionicons -->
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ionicons.min.css">

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

    <style>
        @font-face {
            font-family: 'b-mce';
            src: url('<?php echo Yii::app()->request->baseUrl; ?>/fonts/b-mce.eot');
            src: url('<?php echo Yii::app()->request->baseUrl; ?>/fonts/b-mce.eot?#iefix') format('embedded-opentype'),
                 url('<?php echo Yii::app()->request->baseUrl; ?>/fonts/b-mce.woff') format('woff'),
                 url('<?php echo Yii::app()->request->baseUrl; ?>/fonts/b-mce.ttf') format('truetype'),
                 url('<?php echo Yii::app()->request->baseUrl; ?>/fonts/b-mce.svg#b-mce') format('svg');
            font-weight: normal;
            font-style: normal;
        }
    </style>
</head>
<body>
    <div class="container-fluid " style="background-color:#86b704; background-image: url('<?php echo Yii::app()->request->baseUrl; ?>/images/bg_header.png'); border-bottom: 5px solid rgb(86,56,30);">
        <div class="row">
            <div class="container">
                <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12 text-center">
                    <!-- <button type="button" class="btn btn-icon" style="-webkit-border-radius: 50px; -moz-border-radius: 50px; border-radius: 50px; background-color:white;padding-bottom: 0px;"> -->
                    <button type="button" class="btn btn-icon" style="padding-bottom: 1px; background-color: transparent;">
                        <a href="<?php echo Yii::app()->createUrl('users/home') ?>" >
                            <span style="font-size: 30px; color:white; display: -webkit-box;">
                                <div style="font-family: 'b-mce';">W</div>
                                <div style="font-family: 'b-mce'; margin-top: -8px;">ahapi</div>
                            </span>
                        </a>
                    </button>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12 text-center no-padding-left-right">
                    <div class="dropdown">
                        <button id="btnNewFNotification" data-toggle="dropdown" href="#" type="button" class="btn btn-transparent no-padding" style="background-image: url('<?php echo Yii::app()->request->baseUrl; ?>/images/notifications/new_friends.png'); background-repeat:no-repeat; margin-top: 10px;height: 39px;width: 35px; margin-right:10px;">
                            <?php
                                $numFriendsRequest = count($this->friendsRequest);
                                echo ($numFriendsRequest > 0) ? '<span id="newFNotification" class="badge badge-red" style="top:-20px; left:15px;">' . $numFriendsRequest . '</span>':"";

                                $numFriendsConfirmation = count($this->friendsConfirmation);
                                echo ($numFriendsConfirmation > 0) ? '<span id="newFNotification" class="badge badge-red" style="top:-20px; left:15px;">' . $numFriendsConfirmation . '</span>':"";
                            ?>
                        </button>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                            <?php
                                
                                $i = 0;

                                foreach ($this->friendsRequest as $friendRequest) 
                                {
                                    if($i === 0)
                                    {
                                        echo '<li role="presentation" class="dropdown-header dropdown-header-custom">Nuevos amigos</li>';
                                    }

                                    $friendId = $friendRequest->_id;

                                    echo '<div id="fNotification' . $friendId . '" class="media">';
                                    echo '<a class="pull-left" href="#">';
                                    echo '<img class="media-object" src="https://fbcdn-profile-a.akamaihd.net/hprofile-ak-prn1/50488_330049117033753_483067197_q.jpg">';
                                    echo '</a>';
                                    echo '<div class="media-body">';
                                    echo '<strong>' . $friendRequest->name . " " . $friendRequest->last_name . "</strong> quiere ser tu amigo en Wahapi. ";
                                    echo '<div class="btn-group">';
                                    // Button "Agregar"
                                    echo CHtml::ajaxLink(
                                        "Agregar",
                                        array('responseRequestNewFriend'), 
                                        array(
                                            "type" => "POST",
                                            "data" => array("accepted" => "$friendRequest->_id"),
                                            "beforeSend" => "function(){
                                                var numNotification = $.trim($('#newFNotification').html());

                                                if(numNotification > 0)
                                                {
                                                    var newNum = numNotification - 1;

                                                    if(newNum !== 0)
                                                    {
                                                        $('#newFNotification').html(newNum);
                                                    }

                                                    else
                                                    {
                                                        $('#newFNotification').html('');
                                                    }
                                                }

                                                else
                                                {
                                                    $('#newFNotification').html('');
                                                }
                                            }",
                                            "success" => "function(){
                                                $('#fNotification$friendId').remove();
                                            }"
                                        ),
                                        array(
                                            "type" => "button",
                                            "class" => "btn btn-default btn-custom white",
                                            "style" => "background-image: url('" . Yii::app()->request->baseUrl . "/images/patterns/add2.png');"
                                        )
                                    );
                                    // Button "Glyphicon plus"
                                    echo CHtml::ajaxLink(
                                        '<span class="glyphicon glyphicon-plus"></span>',
                                        array('responseRequestNewFriend'), 
                                        array(
                                            "type" => "POST",
                                            "data" => array("accepted" => "$friendRequest->_id"),
                                            "beforeSend" => "function(){
                                                var numNotification = $.trim($('#newFNotification').html());

                                                if(numNotification > 0)
                                                {
                                                    var newNum = numNotification - 1;

                                                    if(newNum !== 0)
                                                    {
                                                        $('#newFNotification').html(newNum);
                                                    }

                                                    else
                                                    {
                                                        $('#newFNotification').html('');
                                                    }
                                                }

                                                else
                                                {
                                                    $('#newFNotification').html('');
                                                }
                                            }",
                                            "success" => "function(){
                                                $('#fNotification$friendId').remove();
                                            }"
                                        ),
                                        array(
                                            "type" => "button",
                                            "class" => "btn btn-default btn-custom white",
                                            "style" => "background-color: #855b3b"
                                        )
                                    );
                                    echo '</div>';
                                    echo ' - ';
                                    // Button "Rechazar"
                                    echo CHtml::ajaxButton(
                                        "Rechazar",
                                        array('responseRequestNewFriend'), 
                                        array(
                                            "type" => "POST",
                                            "data" => array("canceled" => "$friendRequest->_id"),
                                            "beforeSend" => "function(){
                                                var numNotification = $.trim($('#newFNotification').html());

                                                if(numNotification > 0)
                                                {
                                                    var newNum = numNotification - 1;

                                                    if(newNum !== 0)
                                                    {
                                                        $('#newFNotification').html(newNum);
                                                    }

                                                    else
                                                    {
                                                        $('#newFNotification').html('');
                                                    }
                                                }

                                                else
                                                {
                                                    $('#newFNotification').html('');
                                                }
                                            }",
                                            "success" => "function(){
                                                $('#fNotification$friendId').remove();
                                            }"
                                        )
                                    );
                                    echo '</div>';
                                    echo '</div>';
                                    echo '<li role="presentation" class="divider divider-custom"></li>';
                                    $i ++;
                                }

                                foreach ($this->friendsConfirmation as $friendConfirmation) 
                                {
                                    if($i === 0)
                                    {
                                        echo '<li role="presentation" class="dropdown-header dropdown-header-custom">Solicitudes de amistad aceptadas</li>';
                                    }

                                    $friendId = $friendConfirmation->_id;

                                    echo '<div id="notificationNewFriend' . $friendId . '" class="media">';
                                    echo '<a class="pull-left" href="#">';
                                    echo '<img class="media-object" src="https://fbcdn-profile-a.akamaihd.net/hprofile-ak-prn1/50488_330049117033753_483067197_q.jpg">';
                                    echo '</a>';
                                    echo '<div class="media-body">';
                                    echo '<strong>' . $friendConfirmation->name . " " . $friendConfirmation->last_name . "</strong> acepto tu solicitud de amistad. "; // " <button id='perfil" . $friendId . "'>Listo</button> ó <a type='button' href='/wahapi/users/getProfile?user=" . $friendId . "'> ir a Perfil</a>";
                                    echo CHtml::ajaxLink(
                                        "Listo",
                                        array('readFriendConfirmation'), 
                                        array(
                                            "type" => "POST",
                                            "data" => array("checked" => $friendId),
                                            "beforeSend" => "function(){
                                                var numNotification = $.trim($('#newFNotification').html());

                                                if(numNotification > 0)
                                                {
                                                    var newNum = numNotification - 1;

                                                    if(newNum !== 0)
                                                    {
                                                        $('#newFNotification').html(newNum);
                                                    }

                                                    else
                                                    {
                                                        $('#newFNotification').html('');
                                                    }
                                                }

                                                else
                                                {
                                                    $('#newFNotification').html('');
                                                }
                                            }",
                                            "success" => "function(){
                                                $('#notificationNewFriend$friendId').remove();
                                            }"
                                        ),
                                        array(
                                            "type" => "button",
                                            "class" => "btn btn-default btn-custom white",
                                            "style" => "background-image: url('" . Yii::app()->request->baseUrl . "/images/patterns/add2.png');"
                                        )
                                    );
                                    echo '</div>';
                                    echo '</div>';                                    
                                    echo '<li role="presentation" class="divider divider-custom"></li>';
                                    $i ++;
                                }
                            ?>
                        </ul>
                    </div>
                    <div class="dropdown">
                        <button id="btnNewWNotification" data-toggle="dropdown" href="#" type="button" class="btn btn-transparent no-padding" style="background-image: url('<?php echo Yii::app()->request->baseUrl; ?>/images/notifications/new_wallpost.png'); background-repeat:no-repeat; margin-top: 10px;height: 39px;width: 35px; margin-right:10px;">
                            <?php
                                $numWallPostNotifications = count($this->wallPostNotifications);
                                echo ($numWallPostNotifications > 0) ? '<span id="newWNotification" class="badge badge-red" style="top:-20px; left:15px;">' . $numWallPostNotifications . '</span>':"";
                            ?>
                        </button>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                            <?php

                                $i = 0;

                                foreach ($this->wallPostNotifications as $wallPostNotification) 
                                {
                                    if($i === 0)
                                    {
                                        echo '<li role="presentation" class="dropdown-header dropdown-header-custom">Notificaciones de usuarios</li>';
                                    }

                                    $wallpostFeedUserId = $wallPostNotification['feed'];

                                    echo "<div id='wNotification" . $wallpostFeedUserId . "' >";
                                    echo "<strong>" . $wallPostNotification['friend']->name . "</strong> te ha hecho una publicación - <a href='" . Yii::app()->createUrl("users/viewNotification") . "?feed=" . $wallpostFeedUserId . "' id='verPublicacion" . $wallpostFeedUserId . "'> Ver publicación</a>";
                                    echo "</div>";
                                    echo '<li role="presentation" class="divider divider-custom"></li>';
                                    $i ++;
                                }
                            ?>
                        </ul>
                    </div>
                    <div class="dropdown">
                        <button id="btnNewGNotification"  data-toggle="dropdown" href="#" type="button" class="btn btn-transparent no-padding" style="background-image: url('<?php echo Yii::app()->request->baseUrl; ?>/images/notifications/new_groups.png'); background-repeat:no-repeat; margin-top: 10px;height: 39px;width: 35px; margin-right:10px;">
                            <?php
                                $numGroupNotifications = count($this->newGroupNotifications) + count($this->groupNotifications);
                                echo ($numGroupNotifications > 0) ? '<span id="newGNotification" class="badge badge-red" style="top:-20px; left:15px;">' . $numGroupNotifications . '</span>':"";
                            ?>
                        </button>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                            <?php

                                $i = 0;

                                foreach ($this->newGroupNotifications as $newGroupNotification) 
                                {
                                    if($i === 0)
                                    {
                                        echo '<li role="presentation" class="dropdown-header dropdown-header-custom">Nuevos grupos</li>';
                                    }

                                    echo "<div id='gNotification" . $newGroupNotification->_id . "' >";
                                    echo "Haz sido invitado a pertenecer al grupo <strong>" . $newGroupNotification->name . "</strong> ";
                                    echo '<div class="btn-group">';
                                    // Button "Aceptar"
                                    echo CHtml::ajaxLink(
                                        "Aceptar",
                                        array('groups/responseRequestNewGroup'), 
                                        array(
                                            "type" => "POST",
                                            "data" => array("acceptedGroupId" => "$newGroupNotification->_id"),
                                            "beforeSend" => "function(){
                                                var numNotification = $.trim($('#newGNotification').html());

                                                if(numNotification > 0)
                                                {
                                                    var newNum = numNotification - 1;

                                                    if(newNum !== 0)
                                                    {
                                                        $('#newGNotification').html(newNum);
                                                    }
                                                    
                                                    else
                                                    {
                                                        $('#newGNotification').html('');
                                                    }
                                                }

                                                else
                                                {
                                                    $('#newGNotification').html('');
                                                }
                                            }",
                                            "success" => "function(){
                                                $('#gNotification$newGroupNotification->_id').remove();
                                            }"
                                        ),
                                        array(
                                            "type" => "button",
                                            "class" => "btn btn-default btn-custom white",
                                            "style" => "background-image: url('" . Yii::app()->request->baseUrl . "/images/patterns/add2.png');"
                                        )
                                    );
                                    // Button "Glyphicon plus"
                                    echo CHtml::ajaxLink(
                                        '<span class="glyphicon glyphicon-plus"></span>',
                                        array('groups/responseRequestNewGroup'), 
                                        array(
                                            "type" => "POST",
                                            "data" => array("acceptedGroupId" => "$newGroupNotification->_id"),
                                            "beforeSend" => "function(){
                                                var numNotification = $.trim($('#newGNotification').html());

                                                if(numNotification > 0)
                                                {
                                                    var newNum = numNotification - 1;

                                                    if(newNum !== 0)
                                                    {
                                                        $('#newGNotification').html(newNum);
                                                    }
                                                    
                                                    else
                                                    {
                                                        $('#newGNotification').html('');
                                                    }
                                                }

                                                else
                                                {
                                                    $('#newGNotification').html('');
                                                }
                                            }",
                                            "success" => "function(){
                                                $('#gNotification$newGroupNotification->_id').remove();
                                            }"
                                        ),
                                        array(
                                            "type" => "button",
                                            "class" => "btn btn-default btn-custom white",
                                            "style" => "background-color: #855b3b"
                                        )
                                    );
                                    echo "</div>";
                                    echo " - ";
                                    echo CHtml::ajaxLink(
                                        "Rechazar",
                                        array('groups/responseRequestNewGroup'), 
                                        array(
                                            "type" => "POST",
                                            "data" => array("canceledGroupId" => "$newGroupNotification->_id"),
                                            "beforeSend" => "function(){
                                                var numNotification = $.trim($('#newGNotification').html());

                                                if(numNotification > 0)
                                                {
                                                    var newNum = numNotification - 1;

                                                    if(newNum !== 0)
                                                    {
                                                        $('#newGNotification').html(newNum);
                                                    }
                                                    
                                                    else
                                                    {
                                                        $('#newGNotification').html('');
                                                    }
                                                }

                                                else
                                                {
                                                    $('#newGNotification').html('');
                                                }
                                            }",
                                            "success" => "function(){
                                                $('#gNotification$newGroupNotification->_id').remove();
                                            }"
                                        )
                                    );
                                    echo "</div>";
                                    // echo "</div>";
                                    echo '<li role="presentation" class="divider divider-custom"></li>';
                                    $i ++;
                                }

                                $j = 0;

                                foreach ($this->groupNotifications as $groupNotification) 
                                { 
                                    if($j === 0)
                                    {
                                        echo '<li role="presentation" class="dropdown-header dropdown-header-custom">Notificaciones de grupos</li>';
                                    }

                                    $wallpostFeedGroupId = $groupNotification['feed']->FK_feed_id;
                                    $wallpostFeedId = $groupNotification['feed']->id;

                                    echo '<div id="grNotification' . $wallpostFeedId . '" class="media" >';
                                    echo '<a class="pull-left" href="#">';
                                    echo '<img class="media-object" src="https://fbcdn-profile-a.akamaihd.net/hprofile-ak-prn1/50488_330049117033753_483067197_q.jpg">';
                                    echo '</a>';
                                    echo '<div class="media-body">';
                                    echo '<strong>' . $groupNotification['userGroup']->name . ' ' . $groupNotification['userGroup']->last_name . '</strong> ha hecho una publicación en el grupo <strong>' . $groupNotification['group']->name . '</strong> - <a href="' . Yii::app()->createUrl('users/viewNotification') . '?feedGroup=' . $wallpostFeedGroupId . '&notificationGroupId=' . $wallpostFeedId . '" id="verPublicacionGrupo' . $wallpostFeedGroupId . '"> Ver Publicación </a>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '<li role="presentation" class="divider divider-custom"></li>';
                                    $i ++;
                                }
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <?php
                        $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                            'name'=>'value',
                            'value'=>'',
                            'source'=>$this->createUrl('users/autocomplete'),
                            'options'=>array(
                                'showAnim'=>'fold',
                                'minLength'=>'2',
                                'select'=>"js:function(event, ui)
                                {
                                    window.location = '" . Yii::app()->createUrl('users/getProfile') . "?user=' + ui.item[\"_id\"];
                                }"
                            ),
                            'htmlOptions'=>array(
                                'id'=>'searchBar',
                                'placeholder'=>'Buscar amigos'
                            )
                        ));
                    ?>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-2">
                    <a class="pull-right" href="<?php echo Yii::app()->createUrl('users/logout') ?>" style="color:white">
                        Cerrar sesi&oacute;n <span class="glyphicon glyphicon-cog" style="color:white"></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <?php echo $content; ?>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="text-muted">Copyright &COPY; Wahapi, Powered by Colombia P&uacute;blica &REG; 2013 - 2017</p>
        </div>
    </footer>

    <script>
        loadCSS("<?php echo Yii::app()->request->baseUrl; ?>/css/profile.css");
    </script>
    <script type="text/javascript">
        $("#fNotifications").hide();
        $("#friendsNotifications").click(function () {
            $("#fNotifications").each(function() {
                displaying = $(this).css("display");
                if(displaying == "block") {
                    $(this).fadeOut('slow',function() {
                        $(this).css("display","none");
                    });
                }
                else 
                {
                    $(this).fadeIn('slow',function() {
                        $(this).css("display","block");
                    });
                }
            });
            return false;
        });

        $("#wNotifications").hide();
        $("#wallPostNotifications").click(function () {
            $("#wNotifications").each(function() {
                displaying = $(this).css("display");
                if(displaying == "block") {
                    $(this).fadeOut('slow',function() {
                        $(this).css("display","none");
                    });
                }
                else 
                {
                    $(this).fadeIn('slow',function() {
                        $(this).css("display","block");
                    });
                }
            });
            return false;
        });

        $("#gNotifications").hide();
        $("#groupNotifications").click(function () {
            $("#gNotifications").each(function() {
                displaying = $(this).css("display");
                if(displaying == "block") {
                    $(this).fadeOut('slow',function() {
                        $(this).css("display","none");
                    });
                }
                else 
                {
                    $(this).fadeIn('slow',function() {
                        $(this).css("display","block");
                    });
                }
            });
            return false;
        });
    </script>
    <script>
        $(function() {
            // Enable pusher logging - don't include this in production
            Pusher.log = function(message) {
                if (window.console && window.console.log) {
                    window.console.log(message);
                }
            };

            var pusher = new Pusher('c5ae8a56127aa7a257cd');

            var channel = pusher.subscribe('user<?php echo Yii::app()->user->getState("userId") ?>');

            channel.bind('newFriend', function(data) {

                if ($('#newFNotification').length)
                {
                    var numNotification = parseInt($.trim($('#newFNotification').html()));

                    var newNum = numNotification + 1;

                    $('#newFNotification').html(newNum);
                }

                else
                {
                    $('#btnNewFNotification').html('<span id="newFNotification" class="badge badge-red" style="top:-20px; left:15px;">1</span>');
                    $('#btnNewFNotification + ul').append('<li role="presentation" class="dropdown-header dropdown-header-custom">Nuevos amigos</li>');
                }

                $('#btnNewFNotification + ul').append('<div id="fNotification' + data.idRequestFriend + '" class="media"> <a class="pull-left" href="#"> <img class="media-object" src="https://fbcdn-profile-a.akamaihd.net/hprofile-ak-prn1/50488_330049117033753_483067197_q.jpg"> </a> <div class="media-body"> <strong>' + data.nameRequesterFriend + '</strong> quiere ser tu amigo en Wahapi. <div class="btn-group"> <button class="btn btn-default btn-custom white" style="background-image: url(\'<?php echo Yii::app()->request->baseUrl; ?>/images/patterns/add2.png\')" id="aceptarFNotification' + data.idRequestFriend + '">Aceptar</button> <button type="button" class="btn btn-default btn-custom white" style="background-color: #855b3b"; id="aceptarFNotificationIcon' + data.idRequestFriend + '"><span class="glyphicon glyphicon-plus"></span></button></div> - <button id="cancelarFNotification' + data.idRequestFriend + '"> Rechazar </button></div></div><li role="presentation" class="divider divider-custom"></li>');

                $("#aceptarFNotification" + data.idRequestFriend).click(function (){
                    $.ajax({
                        type: "POST",
                        url: 'responseRequestNewFriend',
                        data: {"accepted" : data.idRequestFriend},
                        dataType: 'json',
                        beforeSend: function()
                        {
                            var numNotification = $.trim($('#newFNotification').html());

                            if(numNotification > 0)
                            {
                                var newNum = numNotification - 1;

                                if(newNum !== 0)
                                {
                                    $('#newFNotification').html(newNum);
                                }

                                else
                                {
                                    $('#newFNotification').html('');
                                }
                            }

                            else
                            {
                                $('#newFNotification').html('');
                            }
                        },
                        success: function(response)
                        {
                            $('#fNotification' + data.idRequestFriend).remove();
                        }
                    });
                });
                
                $("#aceptarFNotificationIcon" + data.idRequestFriend).click(function (){
                    $.ajax({
                        type: "POST",
                        url: 'responseRequestNewFriend',
                        data: {"accepted" : data.idRequestFriend},
                        dataType: 'json',
                        beforeSend: function()
                        {   console.log("entra");
                            var numNotification = $.trim($('#newFNotification').html());

                            if(numNotification > 0)
                            {
                                var newNum = numNotification - 1;

                                if(newNum !== 0)
                                {
                                    $('#newFNotification').html(newNum);
                                }

                                else
                                {
                                    $('#newFNotification').html('');
                                }
                            }

                            else
                            {
                                $('#newFNotification').html('');
                            }
                        },
                        success: function(response)
                        {
                            $('#fNotification' + data.idRequestFriend).remove();
                        }
                    });
                });

                $("#cancelarFNotification" + data.idRequestFriend).click(function (){
                    $.ajax({
                        type: "POST",
                        url: 'responseRequestNewFriend',
                        data: {"canceled" : data.idRequestFriend},
                        dataType: 'json',
                        beforeSend: function()
                        {
                            var numNotification = $.trim($('#newFNotification').html());

                            if(numNotification > 0)
                            {
                                var newNum = numNotification - 1;

                                if(newNum !== 0)
                                {
                                    $('#newFNotification').html(newNum);
                                }

                                else
                                {
                                    $('#newFNotification').html('');
                                }
                            }

                            else
                            {
                                $('#newFNotification').html('');
                            }
                        },
                        success: function(response)
                        {
                            $('#fNotification' + data.idRequestFriend).remove();
                        }
                    });
                });
            });

            channel.bind('notificationNewFriend', function(data) {

                if ($('#newFNotification').length)
                {
                    var numNotification = parseInt($.trim($('#newFNotification').html()));

                    var newNum = numNotification + 1;

                    $('#newFNotification').html(newNum);
                }

                else
                {
                    $('#btnNewFNotification').html('<span id="newFNotification" class="badge badge-red" style="top:-20px; left:15px;">1</span>');
                    $('#btnNewFNotification + ul').append('<li role="presentation" class="dropdown-header dropdown-header-custom">Solicitudes de amistad aceptadas</li>');
                }

                $('#btnNewFNotification + ul').append('<div id="notificationNewFriend' + data.idNotificationNewFriend + '"><strong>' + data.nameNotificationNewFriend + '</strong> acepto tu solicitud de amistad. Ahora es tu amigo - <button id="perfil' + data.idNotificationNewFriend + '">Listo</button> ó <a type="button" href="/wahapi/users/getProfile?user=' + data.idNotificationNewFriend + '"> ir a Perfil</a>');

                $("#perfil" + data.idNotificationNewFriend).click(function (){

                    var numNotification = $.trim($('#newFNotification').html());

                    if(numNotification > 0)
                    {
                        var newNum = numNotification - 1;

                        if(newNum !== 0)
                        {
                            $('#newFNotification').html(newNum);
                        }

                        else
                        {
                            $('#newFNotification').html('');
                        }
                    }

                    else
                    {
                        $('#newFNotification').html('');
                    }

                    $('#notificationNewFriend' + data.idNotificationNewFriend).remove();
                });
            });

            channel.bind('newWallpost', function(data) {

                if ($('#newWNotification').length)
                {
                    var numNotification = parseInt($.trim($('#newWNotification').html()));

                    var newNum = numNotification + 1;

                    $('#newWNotification').html(newNum);
                }

                else
                {
                    $('#btnNewWNotification').html('<span id="newWNotification" class="badge badge-red" style="top:-20px; left:15px;">1</span>');
                    $('#btnNewWNotification + ul').append('<li role="presentation" class="dropdown-header dropdown-header-custom">Notificaciones de usuarios</li>');
                }

                $('#btnNewWNotification + ul').append('<div id="wNotification' + data.idFeed + '"><strong>' + data.nameFriend + '</strong> te ha hecho una publicación - <a href="<?php echo Yii::app()->createUrl("users/viewNotification") . "?feed=' + data.idFeed  + '" ?>" id="verPublicacion' + data.idFeed + '">Ver publicación</a>');

                // $.growl(data.nameFriend + ' te ha hecho una publicación');
                $.growl({
                    icon: 'glyphicon glyphicon-envelope',
                    title: ' Nueva notificación: ',
                    message: '<strong>' + data.nameFriend + '</strong> te ha hecho una publicación',
                    url: 'https://github.com/mouse0270/bootstrap-growl'
                },{
                    element: 'body',
                    type: "success",
                    allow_dismiss: true,
                    placement: {
                        from: "bottom",
                        align: "right"
                    },
                    offset: 20,
                    spacing: 10,
                    z_index: 1031,
                    delay: 5000,
                    timer: 1000,
                    url_target: '_blank',
                    mouse_over: false,
                    animate: {
                        enter: 'animated fadeInDown',
                        exit: 'animated fadeOutUp'
                    },
                    icon_type: 'class',
                    template: '<div data-growl="container" class="alert" role="alert"><button type="button" class="close" data-growl="dismiss"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button><span data-growl="icon"></span><span data-growl="title"></span><span data-growl="message"></span><a href="#" data-growl="url"></a></div>'});
            });

            channel.bind('newGroup', function(data) {

                if ($('#newGNotification').length)
                {
                    var numNotification = parseInt($.trim($('#newGNotification').html()));

                    var newNum = numNotification + 1;

                    $('#newGNotification').html(newNum);
                }

                else
                {
                    $('#btnNewGNotification').html('<span id="newGNotification" class="badge badge-red" style="top:-20px; left:15px;">1</span>');
                    $('#btnNewGNotification + ul').append('<li role="presentation" class="dropdown-header dropdown-header-custom">Notificaciones de grupos</li>');
                }
                
                $('#btnNewGNotification + ul').append('<div id="gNotification' + data.idNewGroup + '"> Haz sido invitado a pertenecer al grupo <strong>' + data.nameNewGroup + ' </strong> - <a href="javascript: void(0)" id="pertenecerGrupo' + data.idNewGroup + '">Pertenecer al grupo</a> - <a href="javascript: void(0)" id="declinarGrupo' + data.idNewGroup + '">Declinar grupo</a>');
                $("#pertenecerGrupo" + data.idNewGroup).click(function (){
                    $.ajax({
                        type: "POST",
                        url: "<?php echo Yii::app()->createUrl('groups/responseRequestNewGroup') ?>",
                        data: {"acceptedGroupId" : data.idNewGroup},
                        beforeSend: function()
                        {
                            var numNotification = $.trim($('#newGNotification').html());

                            if(numNotification > 0)
                            {
                                var newNum = numNotification - 1;

                                if(newNum !== 0)
                                {
                                    $('#newGNotification').html(newNum);
                                }

                                else
                                {
                                    $('#newGNotification').html('');
                                }
                            }

                            else
                            {
                                $('#newGNotification').html('');
                            }
                        },
                        success: function(resp)
                        {
                            $('#gNotification' + data.idNewGroup).remove();
                        }
                    });
                });
                $("#declinarGrupo" + data.idNewGroup).click(function (){
                    $.ajax({
                        type: "POST",
                        url: "<?php echo Yii::app()->createUrl('groups/responseRequestNewGroup') ?>",
                        data: {"canceledGroupId" : data.idNewGroup},
                        beforeSend: function()
                        {
                            var numNotification = $.trim($('#newGNotification').html());

                            if(numNotification > 0)
                            {
                                var newNum = numNotification - 1;

                                if(newNum !== 0)
                                {
                                    $('#newGNotification').html(newNum);
                                }

                                else
                                {
                                    $('#newGNotification').html('');
                                }
                            }

                            else
                            {
                                $('#newGNotification').html('');
                            }
                        },
                        success: function(resp)
                        {
                            $('#gNotification' + data.idNewGroup).remove();
                        }
                    });
                });
            });

            channel.bind('newWallpostGroup', function(data) {

                if($('#newGNotification').length)
                {
                    var numNotification = parseInt($.trim($('#newGNotification').html()));

                    var newNum = numNotification + 1;

                    $('#newGNotification').html(newNum);   
                }

                else
                {
                    $('#btnNewGNotification').html('<span id="newGNotification" class="badge badge-red" style="top:-20px; left:15px;">1</span>');
                    $('#btnNewGNotification + ul').append('<li role="presentation" class="dropdown-header dropdown-header-custom">Notificaciones de grupos</li>');
                }

                $('#btnNewGNotification + ul').append('<div id="gWNotification' + data.idWallpostFeedGroup + '">' + data.nameUser + ' ha hecho una publicación en el grupo <strong>' + data.nameGroup + '</strong> - <a href="<?php echo Yii::app()->createUrl("users/viewNotification") . "?feedGroup=' + data.idWallpostFeedGroup + '&notificationGroupId=' + data.idWallpostFeed + '" ?>" id="verPublicacionGrupo' + data.idWallpostFeedGroup + '">Ver publicación</a>');
            });
        });
    </script>

    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap-growl.min.js"></script>

    <!-- jQuery Read More -->
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/js/readmore.min.js">

    <script>
        $('#desc').readmore();
    </script>

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
