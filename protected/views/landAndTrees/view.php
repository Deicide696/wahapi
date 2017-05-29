<?php
/* @var $this LandAndTreesController */
/* @var $model LandAndTrees */

$this->breadcrumbs=array(
	'Land And Trees'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List LandAndTrees', 'url'=>array('index')),
	array('label'=>'Create LandAndTrees', 'url'=>array('create')),
	array('label'=>'Update LandAndTrees', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete LandAndTrees', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage LandAndTrees', 'url'=>array('admin')),
);
?>

<h1>View LandAndTrees #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'FK_trees_id',
		'FK_meter_land_id',
		'create_on',
	),
)); ?>
