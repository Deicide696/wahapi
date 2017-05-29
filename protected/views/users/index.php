<div class="col-lg-6 col-md-3 col-lg-offset-6 col-md-offset-9 no-padding-left-right" style="margin-top:10px; margin-bottom:68px;">
    <?php 
        $form=$this->beginWidget('CActiveForm', array(
            'id'=>'loginForm',
            'enableAjaxValidation' => true,
            'clientOptions'=>array(
                'validateOnSubmit'=>true,
                'validateOnChange'=> false),
            'htmlOptions' => array(
                'class' => 'form-inline pull-right',
                'role' => 'form')
        ));
    ?>
    <div class="form-group">
        <?php echo $form->textField($loginModel,'username', array('class' => 'form-control', 'placeholder'=>'Correo electrónico')); ?>
        <?php echo $form->error($loginModel,'username', array('class' => 'white')); ?>

        <span id="helpBlock" class="help-block" style="color:black;">
            <?php echo $form->checkBox($loginModel,'rememberMe'); ?>
            <?php echo $form->label($loginModel,'rememberMe', array('style' => 'margin-bottom: 0px; font-weight:normal;')); ?>
            <?php echo $form->error($loginModel,'rememberMe'); ?>
        </span>
    </div>

    <div class="form-group">
        <?php echo $form->passwordField($loginModel,'password', array('class' => 'form-control', 'placeholder'=>'Contraseña')); ?>
        <?php echo $form->error($loginModel,'password', array('class' => 'white')); ?>

        <span id="helpBlock" class="help-block">
            <?php echo CHtml::link('¿Ha olvidado su contraseña?', array('users/recoveryPassword'), array('style'=>'color:black;')); ?>
        </span>
    </div>

    <?php 
         echo CHtml::submitButton('Ingresar', array('class' => 'btn btn-warning', 'style' => 'margin-top:-34px;')); 
    ?>

    <?php $this->endWidget(); ?>
</div>
<div class="col-lg-12" style="padding-left:0px; padding-right:0px;">
    <div class="row" style="background-color:#eaeaef;">
        <div class="col-lg-8">
            <div class="col-lg-2">
                <br>
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/start/play.png" />
            </div>
            <div class="col-lg-10" style="padding-left:0px;">
                <h2 class="green">CONOCE LA PRIMERA RED SOCIAL</h1>
                <h4>Para la conservación y protección del planeta</h4>
            </div>
            <div class="col-lg-12">
                <iframe width="720" height="405" src="//www.youtube-nocookie.com/embed/_marCDw5bjk?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>
        <div class="col-lg-4" style="background-image:url('<?php echo Yii::app()->request->baseUrl; ?>/images/tierra.png');-moz-border-radius-bottomright: 20px;-webkit-border-bottom-right-radius: 20px;border-bottom-right-radius: 20px;-moz-border-radius-bottomleft: 20px;-webkit-border-bottom-left-radius: 20px;border-bottom-left-radius: 20px;padding-bottom: 20px;">
            <div class="row" style="background-image:url('<?php echo Yii::app()->request->baseUrl; ?>/images/patron_register.png'); background-repeat: repeat-x;">
                <div class="container-fluid">
                    <h3 class="white">Regístrate Gratis</h3>
                    <?php $form=$this->beginWidget('CActiveForm', array(
                        'id'=>'registerForm',
                        'enableAjaxValidation' => true,
                        'clientOptions'=>array(
                            'validateOnSubmit'=>true,
                            'validateOnChange'=> false
                        )
                    )); ?>
                    
                    <div class="col-lg-6" style="padding-left:0px; padding-right:7px;">
                        <div class="form-group">
                            <?php echo $form->textField($model,'name', array('class' => 'form-control', 'placeholder'=>'Nombre')); ?>
                            <?php echo $form->error($model,'name', array('class' => 'white')); ?>
                        </div>
                    </div>
                    <div class="col-lg-6" style="padding-left:7px; padding-right:0px;">
                        <div class="form-group">
                            <?php echo $form->textField($model,'last_name', array('class' => 'form-control', 'placeholder'=>'Apellidos')); ?>
                            <?php echo $form->error($model,'last_name', array('class' => 'white')); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?php echo $form->emailField($model,'email', array('class' => 'form-control', 'placeholder'=>'Tu correo electrónico')); ?>
                        <?php echo $form->error($model,'email', array('class' => 'white')); ?>
                    </div>
                    <div class="form-group">
                        <?php echo CHtml::emailField('reEmail', false ,array('class' => 'form-control', 'placeholder'=>'Vuelve a escribir tu correo')); ?>
                    </div>
                    
                    <div class="col-lg-6" style="padding-left:0px; padding-right:7px;">
                        <div class="form-group">
                            <?php echo $form->passwordField($model,'pwd', array('class' => 'form-control', 'placeholder'=> 'Contraseña')); ?>
                            <?php echo $form->error($model,'pwd', array('class' => 'white')); ?>
                        </div>
                    </div>
                    <div class="col-lg-6" style="padding-left:7px; padding-right:0px;">
                        <div class="form-group">
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
                            <?php echo $form->error($model,'birth_date', array('class' => 'white')); ?>
                        </div>
                    </div>
                    <div class="col-lg-6" style="padding-left:0px; padding-right:7px;">
                        <div class="form-group">
                            <?php echo $form->dropDownList($model,'country', array('Colombia'=>'Colombia'), array('class'=>'form-control')); ?>
                            <?php echo $form->error($model,'country', array('class' => 'white')); ?>
                        </div>
                    </div>
                    <div class="col-lg-6" style="padding-left:7px; padding-right:0px;">
                        <div class="form-group">
                            <?php echo $form->dropDownList($model,'city', array('Bogotá'=>'Bogotá', 'Ibague'=>'Ibague', 'Pereira' => 'Pereira'), array('class'=>'form-control')); ?>
                            <?php echo $form->error($model,'city', array('class' => 'white')); ?>
                        </div>
                    </div>
                    <?php echo CHtml::label('Sexo', false, array('class' => 'white')); ?>
                    <br>

                    <?php echo $form->radioButtonList($model,'genre', array('mujer' => 'Mujer', 'hombre' => 'Hombre')); ?>
                    <?php echo $form->error($model,'genre', array('class' => 'white')); ?>

                    <br><br>

                    <?php echo $form->checkBox($model, 'accept_terms');?>
                    <?php echo CHtml::link('Terminos y Condiciones', Yii::app()->request->baseUrl . '/files/terminos.pdf', array('target'=>'_blank'));  ?>
                    <?php echo $form->error($model,'accept_terms', array('class' => 'white')); ?>

                    <br><br>

                    <?php 
                     echo CHtml::submitButton('Registrarse', array('class' => 'btn btn-warning pull-right'));
                    ?>

                    <?php 
                        // echo CHtml::submitButton('Registrarse', array('class' => 'btn btn-warning pull-right')); 
                    ?>

                    <?php $this->endWidget(); ?>
                </div>
            </div>
        </div>
    </div>
</div>