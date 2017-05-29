<li class="media">
    <a class="pull-left" href="#">
        <!-- <img class="media-object" src="<?php echo Yii::app()->request->baseUrl; ?>/images/cp_comment.png" alt="..."> -->
        <img src="<?php  echo Yii::app()->params['path_bucket'] . $profileImage; ?>" style="max-width:35px; max-height:35px;"/>
    </a>
    <div class="media-body text-left">
        <h5 class="media-heading">
            <?php echo $userName; ?>
        </h5>
        <?php echo $model->comment; ?>
    </div>
</li>