<div class="col-lg-3 col-md-3 col-sm-3">
    <div class="container-fluid">
        <div class="row hidden-sm hidden-xs">
            <div class="col-lg-6 col-md-8 col-lg-offset-3 col-md-offset-2">
                <a type="button" class="btn btn-default btn-inicio-left-panel white text-center" style="background-image: url('<?php echo Yii::app()->request->baseUrl; ?>/images/patterns/add2.png');" href="<?php echo Yii::app()->createUrl('users/home') ?>">Inicio</a>
            </div>
        </div>
        <div class="row hidden-xs">
            <h3 class="text-center">
                <?php echo $model->name; ?>
                <?php echo $model->last_name; ?>
            </h3>
            <div class="col-lg-12">
                <a href="#" class="thumbnail">
                    <img src="<?php  echo Yii::app()->params['path_bucket'] . $model->profile_image; ?>"/> 
                </a>
                <div class="row text-center">
                    <div class="row panel-left-info">
                        <button type="button" class="btn btn-icon" style="padding-left: 6px !important;padding-right: 6px!important;padding-top: 2px!important;padding-bottom: 2px!important;">
                            <i class="icon ion-at"></i>
                        </button> <?php echo $model->email ?> 
                    </div>
                    <div class="row panel-left-info">
                        <span class="green">Edad:</span> <?php echo $this::getYearsOldByBirthday($model->birth_date); ?> Años 
                    </div>
                    <div class="row panel-left-info">
                        <span class="green">País:</span> <?php echo $model->country; ?>
                    </div>
                    <div class="row panel-left-info">
                        <span class="green">Ciudad:</span> <?php echo $model->city; ?>
                    </div>
                    <div class="container-fluid panel-left-info">
                        <a href="" class="green" style="float: right; font-size: 13px;" data-toggle="modal" data-target=".edit-profile-info">Editar</a>
                        <div class="row">
                            <!-- Modal Create Group-->
                            <div class="modal fade edit-profile-info" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" data-backdrop="static" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <h4 class="modal-title" id="myModalLabel">Editar datos de perfil</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <?php 
                                                        $form = $this->beginWidget('CActiveForm', array(
                                                            'id'=>'editProfileInfo',
                                                            'action' => 'edit',
                                                            'enableAjaxValidation' => true,
                                                            'clientOptions'=>array(
                                                                'validateOnSubmit'=>true,
                                                                'validateOnChange'=> false
                                                            )
                                                        )); 
                                                    ?>
                                                    <div class="col-lg-4">
                                                        <div class="form-group text-left">
                                                            <?php echo $form->label($model,'name'); ?>
                                                            <?php echo $form->textField($model,'name', array('class' => 'form-control', 'placeholder'=>'Nombre')); ?>
                                                            <?php echo $form->error($model,'name'); ?>
                                                        </div>
                                                        <div class="form-group text-left">
                                                            <?php echo $form->label($model,'country'); ?>
                                                            <?php echo $form->dropDownList($model, 'country', array('1'=>'Colombia'), array('class' => 'form-control')); ?>
                                                            <?php echo $form->error($model,'country'); ?>
                                                        </div>
                                                        <div class="form-group text-left">
                                                            <?php echo $form->label($model,'emotional_status'); ?>
                                                            <?php echo $form->dropDownList($model, 'emotional_status', array('1'=>'Soltero', '2'=>'Casado', '3'=>'Comprometido'), array('class' => 'form-control')); ?>
                                                            <?php echo $form->error($model,'emotional_status'); ?>
                                                        </div>
                                                        <div class="form-group text-left">
                                                            <?php echo $form->label($model,'childs'); ?>
                                                            <?php echo $form->dropDownList($model, 'childs', array('0'=>'No', '1'=>'Si'), array('class' => 'form-control')); ?>
                                                            <?php echo $form->error($model,'childs'); ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group text-left">
                                                            <?php echo $form->label($model,'last_name'); ?>
                                                            <?php echo $form->textField($model,'last_name', array('class' => 'form-control', 'placeholder'=>'Apellido')); ?>
                                                            <?php echo $form->error($model,'last_name'); ?>
                                                        </div>
                                                        <div class="form-group text-left">
                                                            <?php echo $form->label($model,'city'); ?>
                                                            <?php echo $form->dropDownList($model, 'city', array('1'=>'Bogotá', '2'=>'Ibague', '3'=>'Pereira'), array('class' => 'form-control')); ?>
                                                            <?php echo $form->error($model,'city'); ?>
                                                        </div>
                                                        <div class="form-group text-left">
                                                            <?php echo $form->label($model,'pets'); ?>
                                                            <?php echo $form->dropDownList($model, 'pets', array('0'=>'No', '1'=>'Si'), array('class' => 'form-control')); ?>
                                                            <?php echo $form->error($model,'pets'); ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">                                                                                      
                                                        <div class="form-group text-left">
                                                            <?php echo $form->label($model,'cellphone'); ?>
                                                            <?php echo $form->textField($model,'cellphone', array('class' => 'form-control', 'placeholder'=>'Número celular')); ?>
                                                            <?php echo $form->error($model,'cellphone'); ?>
                                                        </div>
                                                        <div class="form-group text-left">
                                                            <?php echo $form->label($model,'birth_date'); ?>
                                                            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                                                'attribute'=>'birth_date',
                                                                'model'=>$model,
                                                                'language'=>'es',
                                                                'options'=>array(
                                                                    'dateFormat'=>'yy-mm-dd',
                                                                    'changeMonth'=>true,
                                                                    'changeYear'=>true,
                                                                    'minDate'=>'-100Y',
                                                                    'maxDate'=>'-18Y',
                                                                    'yearRange'=>'-90:-16',
                                                                    'showMonthAfterYear'=>true
                                                                ),
                                                                'htmlOptions'=>array(
                                                                    'placeholder'=>'Fecha de Nacimiento',
                                                                    'class' => 'form-control'
                                                                ),
                                                            )); ?>
                                                            <?php echo $form->error($model,'birth_date'); ?>
                                                        </div>
                                                        <div class="form-group text-left">
<!--                                                            --><?php //echo $form->label($model,'religion'); ?>
<!--                                                            --><?php //echo $form->dropDownList($model, 'religion', array('0'=>'Cristiano', '1'=>'Catolico', '2'=>'Musulman'), array('class' => 'form-control')); ?>
<!--                                                            --><?php //echo $form->error($model,'religion'); ?>
                                                        </div>
                                                    </div>                                    
                                                    <div class="col-lg-12">
                                                        <?php echo CHtml::submitButton('Actuaizar', array('class' => 'btn btn-success pull-right')); ?>
                                                    </div>

                                                    <?php $this->endWidget(); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <li class="psbody2">
                        <div class="psimg2">
                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/profile/arbolesWahapi.png">
                        </div>
                        <div class="pstext">
                            <div class="psuser">
                                <span style="font-size: 20px; text-align:left;">Número <br>de arboles</span>
                            </div>
                            <strong style='font-size: 18px;color:#000;'>0</strong>
                        </div> 
                    </li>
                    <li class="psbody2">
                        <div class="psimg2">
                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/profile/arbolesWahapi.png">
                        </div>
                        <div class="pstext">
                            <div class="psuser">
                                <span style="font-size: 20px; text-align:left;">Número <br>de metros</span>
                            </div>
                            <strong style='font-size: 18px;color:#000;'>0</strong>
                        </div> 
                    </li>
                    <li class="psbody2">
                        <div class="psimg2">
                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/profile/arbolesWahapi.png">
                        </div>
                        <div class="pstext">
                            <div class="psuser">
                                <span style="font-size: 20px; text-align:left;">Grupos</span>
                            </div>
                            <strong style='font-size: 18px;color:#000;'>0</strong>
                        </div> 
                    </li>
                    <li class="psbody2">
                        <div class="psimg2">
                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/profile/arbolesWahapi.png">
                        </div>
                        <div class="pstext">
                            <div class="psuser">
                                <span style="font-size: 20px; text-align:left;">Logros</span>
                            </div>
                            <strong style='font-size: 18px;color:#000;'>0</strong>
                        </div> 
                    </li>
                </div>
            </div>
        </div>
    </div>
</div>