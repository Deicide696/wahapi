<div class="col-lg-6 col-md-6 col-sm-9 text-center">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12w col-md-15w col-lg-offset-20 col-md-offset-12-5">
                <a href="<?php echo Yii::app()->createUrl('users/AllConversations'); ?>">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/mensajes_tab.png" data-toggle="tooltip" data-placement="bottom" title="Mis mensajes" />
                <span style="position: relative; top: -18px;">
                <?php
                    $numNewMessage = count($newMessage);
                    if($numNewMessage > 0)
                    {
                        echo '<span class="badge badge-red">';
                        echo $numNewMessage;
                        echo '</span>';
                    }

                    else
                    {
                        echo '&nbsp;';
                    }
                ?>
                </span>
                </a>
                <?php if( Yii::app()->controller->id === 'users' && Yii::app()->controller->action->id === 'AllConversations'){ ?>
                <h4 class="green" style="-webkit-transform: rotate(-90deg);margin-top: -21px; margin-bottom: 2px;">&#9658;</h4>
                <?php } ?>
            </div>
            <div class="col-lg-12w col-md-15w">
                <a href="<?php echo Yii::app()->createUrl('users/getFriends'); ?>">
                    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/amigos_tab.png" data-toggle="tooltip" data-placement="bottom" title="Mis amigos" />
                    <span style="position: relative; top: -18px;">&nbsp;</span>
                </a>
                <?php if( Yii::app()->controller->id === 'users' && Yii::app()->controller->action->id === 'getFriends'){ ?>
                <h4 class="green" style="-webkit-transform: rotate(-90deg);margin-top: -21px; margin-bottom: 2px;">&#9658;</h4>
                <?php } ?>
            </div>
            <div class="col-lg-12w col-md-15w">
                <a href="<?php echo Yii::app()->createUrl('groups/index'); ?>">
                    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/grupos_tab.png" data-toggle="tooltip" data-placement="bottom" title="Mis grupos" />
                    <span style="position: relative; top: -18px;">&nbsp;</span>
                </a>
                <?php if( Yii::app()->controller->id === 'groups'){ ?>
                <h4 class="green" style="-webkit-transform: rotate(-90deg);margin-top: -21px; margin-bottom: 2px;">&#9658;</h4>
                <?php } ?>
            </div>
            <div class="col-lg-12w col-md-15w">
                <a href="<?php echo Yii::app()->createUrl('landAndTrees/index'); ?>">
                    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/arboles_tab.png" data-toggle="tooltip" data-placement="bottom" title="Mis Arboles" />
                    <span style="position: relative; top: -18px;">&nbsp;</span>
                </a>
                <?php if( Yii::app()->controller->id === 'landAndTrees'){ ?>
                <h4 class="green" style="-webkit-transform: rotate(-90deg);margin-top: -21px; margin-bottom: 2px;">&#9658;</h4>
                <?php } ?>
            </div>
            <div class="col-lg-12w col-md-15w">
                <a href="<?php echo Yii::app()->createUrl('users/gallery'); ?>">
                    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/fotos_tab.png" data-toggle="tooltip" data-placement="bottom" title="Mis Fotos" />
                    <span style="position: relative; top: -18px;">&nbsp;</span>
                </a>
                <?php if( Yii::app()->controller->id === ''){ ?>
                <h4 class="green" style="-webkit-transform: rotate(-90deg);margin-top: -21px; margin-bottom: 2px;">&#9658;</h4>
                <?php } ?>
            </div>
        </div>
    </div>
</div>