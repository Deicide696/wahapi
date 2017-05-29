<div class="col-lg-6 col-md-6 col-sm-9 text-center">
	<div class="container-fluid text-left" style="height:228px; background-repeat: no-repeat; background-position: 100% 100%; background-image: url('<?php echo Yii::app()->request->baseUrl; ?>/images/cover.jpg');">
	    <h4 class="white">
	        <?php echo $model->name; ?>
	        <?php echo $model->last_name; ?>
	    </h4>
	    <?php 
	        if($isFriendRequest == 0)
	        {
	            echo CHtml::ajaxLink(
	                CHtml::image(Yii::app()->request->baseUrl . '/images/profile/agregar.png'), 
	                array('addFriend'), 
	                array(
	                    'type' => 'POST',
	                    'data' => array('receiver' => "$model->_id"),
	                    'beforeSend' => 'function(){
	                        console.log("Falta bloquear el botón cuando se envía una solicitud de amistad");
	                    }',
	                    'success' => 'function(data){
	                        console.log(data);
	                        $("#btnAddFriend").remove();
	                    }' 
	                ),
	                array(
	                    'class' => 'pull-right',
	                    'style' => 'position: relative; top: 100px;',
	                    'id' => 'btnAddFriend'
	                )
	            );
	        }
	    ?>
	</div>
	<div class="container-fluid">
	    <?php
	        if($_GET['user'] === Yii::app()->user->getState('userId'))
	        {
	            $image = CHtml::image(Yii::app()->request->baseUrl . '/images/amigos_tab.png', 'Friends');
	            echo CHtml::link($image,
	                array(
	                    'users/getFriends'
	                ),
	                array('class' => 'green')
	            );
	        }

	        else
	        {   
	            $image = CHtml::image(Yii::app()->request->baseUrl . '/images/amigos_tab.png', 'Friends');
	            echo CHtml::link($image,
	                array(
	                    'users/getFriends',
	                    'user' => $_GET['user']
	                ),
	                array('class' => 'green')
	            );
	        }

	        if($_GET['user'] === Yii::app()->user->getState('userId'))
	        {
	            $image = Chtml::image(Yii::app()->request->baseUrl . '/images/grupos_tab.png', 'Groups');
	            echo CHtml::link($image,
	                array(
	                    'groups/index'
	                ),
	                array('class' => 'green')
	            );
	        }

	        else
	        {   
	            $image = CHtml::image(Yii::app()->request->baseUrl . '/images/grupos_tab.png', 'Groups');
	            echo CHtml::link($image,
	                array(
	                    'groups/index',
	                    'user' => $_GET['user']
	                ),
	                array('class' => 'green')
	            );
	        }
	    ?>
	    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/fotos_tab.png"/>
	    <a href="<?php echo Yii::app()->createUrl('users/messagesByUser', array('user' => $_GET['user'])) ?>">
	        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/mensajes_tab.png" alt="">
	    </a>
	</div>
</div>