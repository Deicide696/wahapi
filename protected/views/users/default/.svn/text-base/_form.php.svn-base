<?php
/* @var $this UsersController */
/* @var $model Users */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'users-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pwd'); ?>
		<?php echo $form->textField($model,'pwd',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'pwd'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'last_name'); ?>
		<?php echo $form->textField($model,'last_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'last_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'country'); ?>
		<?php echo $form->textField($model,'country',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'country'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'city'); ?>
		<?php echo $form->textField($model,'city',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'city'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'birth_date'); ?>
		<?php echo $form->textField($model,'birth_date'); ?>
		<?php echo $form->error($model,'birth_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'genre'); ?>
		<?php echo $form->textField($model,'genre',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'genre'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'profile_image'); ?>
		<?php echo $form->textField($model,'profile_image',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'profile_image'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'level'); ?>
		<?php echo $form->textField($model,'level'); ?>
		<?php echo $form->error($model,'level'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'hide_age'); ?>
		<?php echo $form->textField($model,'hide_age'); ?>
		<?php echo $form->error($model,'hide_age'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'hide_email'); ?>
		<?php echo $form->textField($model,'hide_email'); ?>
		<?php echo $form->error($model,'hide_email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'registered_on'); ?>
		<?php echo $form->textField($model,'registered_on'); ?>
		<?php echo $form->error($model,'registered_on'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->