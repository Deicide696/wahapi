<div class="col-lg-6" style="margin-bottom: 20px;">
	<div class="media">
		<a class="media-left" href="#">
	    	<img style="float: left;margin-left: 5px;" src="<?php echo Yii::app()->request->baseUrl; ?>/images/iconoGrupo.png">
	  	</a>
	<div class="media-body">
	    <h4 class="media-heading"><?php echo CHtml::link($model->name, 'getGroup?groupId=' . $model->_id) ?></h4>
	    <?php echo count($members); ?> miembros
	  	</div>
	</div>
</div>