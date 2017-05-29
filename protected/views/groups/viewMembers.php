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
                    // array(
                    //     'users/getFriends',
                    //     'user' => $_GET['user']
                    // ),
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
                                                        console.log(data + ' views/groups/wallpost');
                                                    }
                                                });
                                                console.log(ui.item[\"id\"]);
                                                return false;
                                            }"
                                        ),
                                        'htmlOptions'=>array(
                                            // 'style'=>'height:20px;',
                                        ),
                                    ));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
            }
        ?>
        <div class="container-fluid">
            <div class="row">
                <?php
                    foreach ($members as $member) 
                    {
                        echo $member;
                    }
                ?>
            </div>
        </div>
    </div>
</div>