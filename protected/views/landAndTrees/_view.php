<?php
/* @var $this LandAndTreesController */
/* @var $data LandAndTrees */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('FK_trees_id')); ?>:</b>
	<?php echo CHtml::encode($data->FK_trees_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('FK_meter_land_id')); ?>:</b>
	<?php echo CHtml::encode($data->FK_meter_land_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_on')); ?>:</b>
	<?php echo CHtml::encode($data->create_on); ?>
	<br />


</div>