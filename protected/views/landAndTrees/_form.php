<?php
/* @var $this LandAndTreesController */
/* @var $model LandAndTrees */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'land-and-trees-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'FK_trees_id'); ?>
		<?php echo $form->textField($model,'FK_trees_id'); ?>
		<?php echo $form->error($model,'FK_trees_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'FK_meter_land_id'); ?>
		<?php echo $form->textField($model,'FK_meter_land_id'); ?>
		<?php echo $form->error($model,'FK_meter_land_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'create_on'); ?>
		<?php echo $form->textField($model,'create_on'); ?>
		<?php echo $form->error($model,'create_on'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->