<?php
/* @var $this LandAndTreesController */
/* @var $model LandAndTrees */

$this->breadcrumbs=array(
	'Land And Trees'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List LandAndTrees', 'url'=>array('index')),
	array('label'=>'Manage LandAndTrees', 'url'=>array('admin')),
);
?>

<h1>Create LandAndTrees</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>