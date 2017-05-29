<div class="media">
    <a class="pull-left" href="#">
        <img class="media-object" src="<?php echo Yii::app()->params['path_bucket'] . $model->profile_image ?>" style="max-height: 50px; max-width: 50px;">
    </a>
    <div class="media-body">
        <h4 class="media-heading green">
            <?php
                echo CHtml::link($model->name . ' '. $model->last_name,
                    array(
                        'users/getProfile',
                        'user' => $model->_id
                    )
                );
            ?>
        </h4>
    </div>
</div>