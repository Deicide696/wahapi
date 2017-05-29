<?php
    $this->renderPartial("//groups/_panel-left", array(
        'model' => $model,
        'userAdmin' => $userAdmin,
        'isMember' => $isMember)
    );
?>
<div class="col-lg-6 col-md-6 col-sm-9 text-center">
    <div class="container-fluid text-left" style="height:228px; background-repeat: no-repeat; background-position: 100% 100%; background-image: url('<?php echo Yii::app()->request->baseUrl; ?>/images/cover.jpg');">
        <?php 
            // if($isMember === 0 || $isMember == 1)
            if($isMember === 0)
            {
                // echo CHtml::ajaxLink(
                //     CHtml::image(Yii::app()->request->baseUrl . '/images/profile/agregar.png'), 
                //     array('addFriend'), 
                //     array(
                //         'type' => 'POST',
                //         'data' => array('receiver' => "$isMember->FK_id"),
                //         'success' => 'function(data){
                //             console.log(data);
                //             $("#btnAddFriend").remove();
                //         }' 
                //     ),
                //     array(
                //         'style' => 'position:absolute;top: 160px;margin-left: 440px;',
                //         'id' => 'btnAddFriend'
                //     )
                // );

                // Provisional NO EN PRODUCCION!!!!
                echo CHtml::image(Yii::app()->request->baseUrl . '/images/profile/agregar.png');
            }
        ?>
    </div>
    <div class="container-fluid">
        <div class="row">
            <?php 
                $image = CHtml::image(Yii::app()->request->baseUrl . '/images/amigosGrupo.png', 'Friends Group');
                echo CHtml::link($image,
                    array(
                        'groups/getMembers',
                        'groupId' => $_GET['groupId']
                    ),
                    array('class' => 'green')
                );

                $image = CHtml::image(Yii::app()->request->baseUrl . '/images/fotos_tab.png', 'Photos Group');
                echo CHtml::link($image,
                    // array(
                    //     'groups/index',
                    //     'user' => $_GET['user']
                    // ),
                    array('class' => 'green')
                );
            ?>
        </div>
        <?php
            if($isMember == 1)
            {
        ?>
        <div class="row">
            <div class="btn-group pull-right">
                <button class="btn btn-default btn-custom white" style="background-image: url('<?php echo Yii::app()->request->baseUrl; ?>/images/patterns/add2.png')" data-toggle="modal" data-target=".bs-example-modal-sm">
                    Invitar Amigo
                </button>
                <button type="button" class="btn btn-default btn-custom white" style="background-color: #855b3b" ;="" data-toggle="modal" data-target=".bs-example-modal-sm">
                    <span class="glyphicon glyphicon-plus"></span>
                </button>
            </div>
            <!-- Modal Create Group-->
            <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" data-backdrop="static" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title" id="myModalLabel">Invitar a un amigo</h4>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid">
                                <?php
                                    $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
                                        'name'=>'addPeople',
                                        'source'=>$this->createUrl("searchFriendToRequest?groupId=$model->_id"),
                                        'options'=>array(
                                            'minLength'=>'1',
                                            'select'=>"js:function(event, ui) {
                                                $.ajax({
                                                    type: 'POST',
                                                    url: 'requestGroup',
                                                    data: {'userId' : ui.item[\"id\"], 'groupId' : $model->_id},
                                                    success: function(data)
                                                    {   
                                                        $('#addPeople').val('');
                                                        $('#addPeople').attr('placeholder', 'Invita otro amigo');
                                                        $('#people').append(ui.item.label);
                                                        $('#container-people').css({'display': 'block'});
                                                    }
                                                });
                                                console.log(ui.item.id);
                                                return false;
                                            }"
                                        ),
                                        'htmlOptions'=>array(
                                            'id' => 'addPeople',
                                            'placeholder' => 'Nombre de un amigo'
                                        ),
                                    ));
                                ?>
                            </div>
                            <div id="container-people" class="row" style="display:none;">
                                <div class="col-lg12">
                                    <h4>Amigos Invitados al grupo:</h4>
                                    <div id="people">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
            }
        ?>
        <div class="row">
            <?php 
                if($isMember == 1)
                {
                    $groupId = $model->_id;
                    
                    $this->widget('zii.widgets.jui.CJuiTabs', array(
                        'tabs' => array(
                            'Status' => array('ajax' => $this->createUrl('status') . '?groupId=' . $groupId),
                            // 'Denuncio' => array('ajax' => $this->createUrl('users/complaint')),
                            // panel 3 contains the content rendered by a partial view
                        ),
                        // additional javascript options for the tabs plugin
                        'options' => array(
                            'collapsible' => false,
                        ),
                    ));
            ?>
        </div>
        <div class="row">
            <div id="allPost">
                <ul class="media-list">
                    <?php 
                        foreach ($posts as $post) 
                        {
                            echo $post;
                        }
                    }
                    ?>
                </ul>
                <div id="posts">
                    <ol>
                        <li class="psbody">
                            <div class="psimg">
                                <?php
                                    if(Yii::app()->user->getState('userId') === '66')
                                    {
                                        echo '<img src="'. Yii::app()->request->baseUrl. '/images/profile/arbolesWahapi.png" width="100px" height="100px"/>';
                                    }
                                    else if(Yii::app()->user->getState('userId') === '68')
                                    {
                                        echo '<img src="'. Yii::app()->request->baseUrl. '/images/profile/arbolesWahapi.png" width="100px" height="100px"/>';
                                    }
                                ?>
                            </div>
                            <div class="pstext">
                                <div class="psuser">
                                    <strong>Bienvenido a Wahapi</strong>
                                </div>
                                Esto es Wahapi! Acabas de unirte a la primera nueva red social dedicada a la protecci&oacute;n y conservaci&oacute;n del medio ambiente.
                            </div> 
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>