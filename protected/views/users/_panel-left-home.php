<div class="col-lg-3 col-md-3 col-sm-3">
    <div class="container-fluid">
        <div class="row hidden-sm hidden-xs">
            <div class="col-lg-6 col-md-6">
                <a type="button" class="btn btn-default btn-inicio-left-panel white text-center" style="background-image: url('<?php echo Yii::app()->request->baseUrl; ?>/images/patterns/add2.png');" href="<?php echo Yii::app()->createUrl('users/home') ?>">Inicio</a>
                </div>
            <div class="col-lg-6 col-md-6">   
                <a type="button" class="btn btn-default btn-inicio-left-panel white" style="background-image: url('<?php echo Yii::app()->request->baseUrl; ?>/images/patterns/add2.png');" href="<?php echo Yii::app()->createUrl('users/getProfile') ?>?user=<?php echo Yii::app()->user->getState('userId') ?>">Mi Wahapi</a>
            </div>
        </div>
        <div class="row hidden-xs">
            <h3 class="text-center">
                <?php
                    // if(isset($friend))
                    // {
                    //     echo $friend->names . " " . $friend->last_names;
                    // }
                    // else
                    // {
                        echo Yii::app()->user->getState('name') . " " . Yii::app()->user->getState('last_name');
                    // }
                ?>
            </h3>
            <div class="col-lg-12">
                <?php if( Yii::app()->controller->id === 'users' && Yii::app()->controller->action->id === 'home'){ ?>
                <div class="thumbnails" id="hover-image">
                    <div class="thumbnail">                        
                        <div class="caption">
                            <a href="#" class="btn btn-inverse" style="padding-left:6px; padding-right:6px;" id="imageProfile" data-toggle="modal" data-target="#updateProfilePicture">
                                <i class="fa fa-camera fa-2x"></i>                                
                            </a>
                            <span style="color:black;">Actualizar foto de perfil</span>
                        </div>                        
                        <img class="img-panel-left-home" src="<?php  echo Yii::app()->params['path_bucket'] . $profileImage; ?>"/>
                    </div>
                </div>

                <script type="text/javascript">
                    $(document).ready(function(){
                     
                        $("[rel='tooltip']").tooltip();    
                     
                        $('#hover-image .thumbnail').hover(
                            function(){
                                $(this).find('.caption').slideDown(250); //.fadeIn(250)
                            },
                            function(){
                                $(this).find('.caption').slideUp(250); //.fadeOut(205)
                            }
                        );    
                     
                    });        
                </script>
                <?php } else { ?>
                <a href="#" class="thumbnail">
                    <img src="<?php  echo Yii::app()->params['path_bucket'] . $profileImage; ?>"/> 
                </a>
                <?php } ?>
            </div>
        </div>
        
        <!-- PARA REMOVER || START -->
        <!-- <div id="profileLevel">
            <div id="profileLevelTitleWrapper">
                <span class="standardText">Nivel de Puntuaci&oacute;n</span>
            </div>
            <div id="profileLevelImageWrapper">
                <img />3
            </div>
            <div id="profileLevelNameWrapper">
                <span class="profileLevelName">Big tree</span>
            </div>
        </div>
        <div id="profileCalendar">
            <div id="profileCalendarTitleWrapper">
                <span class="standardText">Calendario</span>
            </div>
            <div id="profileCalendarDateWrapper">
                <span class="profileCalendarDate">Octubre 2013</span>
            </div>
            <div id="profileCalendarWrapper">

            </div>
            <div id="profileCalendarEventsWrapper">
            </div>
        </div> -->
        <!-- PARA REMOVER || STOP -->
    </div>
</div>