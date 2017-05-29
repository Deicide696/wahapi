<?php
/* @var $this GroupsController */
/* @var $model Groups */

$this->breadcrumbs=array(
	'Groups'=>array('index'),
	$model->_id=>array('view','id'=>$model->_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Groups', 'url'=>array('index')),
	array('label'=>'Create Groups', 'url'=>array('create')),
	array('label'=>'View Groups', 'url'=>array('view', 'id'=>$model->_id)),
	array('label'=>'Manage Groups', 'url'=>array('admin')),
);
?>

<h1>Update Groups <?php echo $model->_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>