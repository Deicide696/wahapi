<div class="col-lg-3 col-md-3 col-sm-3">
    <div class="container-fluid">
        <div class="row hidden-sm hidden-xs">
            <div class="col-lg-6 col-md-6">
                <a type="button" class="btn btn-default btn-inicio-left-panel white text-center" style="background-image: url('<?php echo Yii::app()->request->baseUrl; ?>/images/patterns/add2.png');" href="<?php echo Yii::app()->request->baseUrl; ?>">Inicio</a>
                </div>
            <div class="col-lg-6 col-md-6">   
                <a type="button" class="btn btn-default btn-inicio-left-panel white" style="background-image: url('<?php echo Yii::app()->request->baseUrl; ?>/images/patterns/add2.png');" href="<?php echo Yii::app()->createUrl('groups/index'); ?>">Mis Grupos</a>
            </div>
        </div>
        <div class="row hidden-xs">
            <h3 class="text-center green">
                <?php 
                    echo CHtml::link($model->name, 
                        array(
                            'groups/getGroup',
                            'groupId' => $model->_id
                        ),
                        array('class'=>'green')
                    );
                ?>
            </h3>
            <div class="col-lg-12">
                <h4>Categoria: <span class="green" style:"font-weight: normal;"><?php echo $model->category ?></span></h4>
                <h4>Ciudad: <span class="green" style:"font-weight: normal;"><?php echo $model->city ?></span></h4>
                <h4>País: <span class="green" style:"font-weight: normal;"><?php echo $model->country ?></span></h4>
                <h4>Idioma: <span class="green" style:"font-weight: normal;"><?php echo $model->language ?></span></h4>
                <h4>Descripción:</h4>
                <?php echo $model->description ?>
                <h4>Creador: <span class="green" style:"font-weight: normal;">
                    <?php 
                        echo CHtml::link($userAdmin->name . ' ' . $userAdmin->last_name, 
                            array(
                                'users/getProfile',
                                'user' => $userAdmin->_id
                            ),
                            array('class'=>'green')
                        );
                    ?>
                </h4>
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