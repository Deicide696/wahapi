<div class="col-lg-6 col-md-3 col-lg-offset-6 col-md-offset-9 no-padding-left-right" style="margin-top:10px; margin-bottom:10px;">
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
        <?php echo $form->error($loginModel,'username'); ?>

        <span id="helpBlock" class="help-block" style="color:black;">
            <?php echo $form->checkBox($loginModel,'rememberMe'); ?>
            <?php echo $form->label($loginModel,'rememberMe', array('style' => 'margin-bottom: 0px; font-weight:normal;')); ?>
            <?php echo $form->error($loginModel,'rememberMe'); ?>
        </span>
    </div>

    <div class="form-group">
        <?php echo $form->passwordField($loginModel,'password', array('class' => 'form-control', 'placeholder'=>'Contraseña')); ?>
        <?php echo $form->error($loginModel,'password'); ?>

        <span id="helpBlock" class="help-block">
            <?php echo CHtml::link('¿Ha olvidado su contraseña?', array('users/recoveryPassword'), array('style'=>'color:black;')); ?>
        </span>
    </div>

    <?php echo CHtml::submitButton('Ingresar', array('class' => 'btn btn-warning', 'style' => 'margin-top:-34px;')); ?>

    <?php $this->endWidget(); ?>
</div>
<div class="col-lg-12" style="padding-left:0px; padding-right:0px;">
    <div class="row" style="background-color:#eaeaef;">
        <div class="col-lg-12 text-center">
            <h2>Recupera tu cuenta Wahapi</h2>

			<div class="col-lg-4 col-lg-offset-4">
	            <?php 
			        $form=$this->beginWidget('CActiveForm', array(
			            'id'=>'recoveryForm',
			            'enableAjaxValidation' => true,
			            'clientOptions'=>array(
			                'validateOnSubmit'=>true,
			                'validateOnChange'=> false),
			            'htmlOptions' => array(
			                'class' => 'form-horizontal',
			                'role' => 'form')
			        ));
			    ?>
			    <div class="form-group">
			    	<label for="inputEmail3" class="col-sm-5 control-label">Correo Electrónico</label>
			        <div class="col-sm-7">
			        	<?php echo $form->textField($loginModel,'username', array('class' => 'form-control', 'for' => 'inputEmailRecovery', 'placeholder'=>'Correo electrónico')); ?>
			        	<?php echo $form->error($loginModel,'username'); ?>
			        </div>
			    </div>

			    <?php echo CHtml::submitButton('Ingresar', array('class' => 'btn btn-warning')); ?>
			    <?php echo CHtml::link('Cancelar', array('users/recoveryPassword'), array('class'=>'btn btn-default', 'style' => 'background-color:#c5c7c5; color:black;')); ?>

			    <?php $this->endWidget(); ?>
			 </div>
        </div>
    </div>
</div>