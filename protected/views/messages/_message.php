<div class="media">
    <a class="pull-left" href="#">
        <img class="media-object" src="<?php echo Yii::app()->params['path_bucket'] . $profileImage ?>" style="max-height: 50px; max-width: 50px;">
    </a>
    <div class="media-body">
        <h4 class="media-heading green"><?php echo $creator ?></h4>
        <?php echo $message ?>
    </div>
</div>