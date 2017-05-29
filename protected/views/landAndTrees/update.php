<?php
/* @var $this LandAndTreesController */
/* @var $model LandAndTrees */

$this->breadcrumbs=array(
	'Land And Trees'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List LandAndTrees', 'url'=>array('index')),
	array('label'=>'Create LandAndTrees', 'url'=>array('create')),
	array('label'=>'View LandAndTrees', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage LandAndTrees', 'url'=>array('admin')),
);
?>

<h1>Update LandAndTrees <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>