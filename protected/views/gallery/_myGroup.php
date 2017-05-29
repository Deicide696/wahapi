<div style="text-align:left;">
	<img style="float: left;margin-left: 5px;" src="<?php echo Yii::app()->request->baseUrl; ?>/images/iconoGrupo.png">
    <span style="color:#86b703;padding-left: 5px;"><?php echo CHtml::link($model->name, 'getGroup?groupId=' . $model->_id) ?></a></span>
    <br>
    <span style="padding-left: 5px;"><?php echo count($members); ?> miembros</span>
</div>