<?php
/* @var $this GroupsController */
/* @var $model Groups */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'_id'); ?>
		<?php echo $form->textField($model,'_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'group_name'); ?>
		<?php echo $form->textField($model,'group_name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'creation_date'); ?>
		<?php echo $form->textField($model,'creation_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'FK_admin_id'); ?>
		<?php echo $form->textField($model,'FK_admin_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->