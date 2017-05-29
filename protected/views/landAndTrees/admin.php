<?php
/* @var $this LandAndTreesController */
/* @var $model LandAndTrees */

$this->breadcrumbs=array(
	'Land And Trees'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List LandAndTrees', 'url'=>array('index')),
	array('label'=>'Create LandAndTrees', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#land-and-trees-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Land And Trees</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'land-and-trees-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'FK_trees_id',
		'FK_meter_land_id',
		'create_on',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
