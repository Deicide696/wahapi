<?php
    if(isset($friend))
    {
        $this->renderPartial('//users/_panel-left-user', array(
            'model' => $friend)
        );

        $this->renderPartial('//users/_main-menu-user', array(
            'model' => $friend,
            'isFriendRequest' => $isFriendRequest)
        );
    }

    else
    {
        $this->renderPartial("//users/_panel-left-home", array(
            "profileImage" => $profileImage)
        );

        $this->renderPartial("//users/_main-menu", array(
            'newMessage' => $newMessage)
        );
    }
?>
<div class="col-lg-3 col-md-3 hidden-sm hidden-xs">
    <br><br>
</div>

<?php
    if(!isset($friend))
    {
        ?>
        <div class="col-lg-9" style="min-height: 0px;">
            <hr>
        </div>
<?php
    }

    else
    {
        ?>
        <div class="col-lg-6" style="min-height: 0px;">
            <hr>
        </div>
<?php
    }
        ?>        

<div class="col-lg-6 col-md-6 col-sm-9">
    <span class="white" style="padding: 2px 15px 5px 15px;background-color: #86b703;">
        Grupos
    </span>
    <img style="vertical-align:text-top; margin-top: -2px;margin-left: -4px;"src="<?php echo Yii::app()->request->baseUrl; ?>/images/hojas.png">
    <div class="container-fluid">

        <?php
            if(!isset($friend))
            {
        ?>
        <div class="row">
            <div class="btn-group pull-right">
                <button class="btn btn-default btn-custom white" style="background-image: url('<?php echo Yii::app()->request->baseUrl; ?>/images/patterns/add2.png')" data-toggle="modal" data-target=".bs-example-modal-sm">
                    Nuevo grupo
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
                            <h4 class="modal-title" id="myModalLabel">Crear un nuevo grupo</h4>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <?php 
                                        $form = $this->beginWidget('CActiveForm', array(
                                            'id'=>'newGroupForm',
                                            'action' => 'create',
                                            'enableAjaxValidation' => true,
                                            'clientOptions'=>array(
                                                'validateOnSubmit'=>true,
                                                'validateOnChange'=> false
                                            )
                                        )); 
                                    ?>
                                    <div class="form-group">
                                        <?php echo $form->textField($modelGroup,'name', array('class' => 'form-control', 'placeholder'=>'Nombre del grupo')); ?>
                                        <?php echo $form->error($modelGroup,'name'); ?>
                                    </div>
                                    <div class="form-group">
                                        <?php echo $form->dropDownList($modelGroup, 'category', array('seleccione'=>'Seleccione una categoria', '1'=>'Deportes', '2'=>'Aventura', '3'=>'Ecologia'), array('class' => 'form-control')); ?>
                                        <?php echo $form->error($modelGroup,'category'); ?>
                                    </div>
                                    <div class="form-group">
                                        <?php echo $form->dropDownList($modelGroup, 'country', array('seleccione'=>'Seleccione un país', 'colombia'=>'Colombia'), array('class'=>'form-control')); ?>
                                        <?php echo $form->error($modelGroup,'country'); ?>
                                    </div>
                                    <div class="form-group">
                                        <?php $form->dropDownList($modelGroup, 'city', array('seleccione'=>'Seleccione una ciudad', 'bogota'=>'Bogotá', 'ibague'=>'Ibague', 'pereira' => 'Pereira'), array('class'=>'form-control')); ?>
                                        <?php echo $form->error($modelGroup,'city'); ?>
                                    </div>
                                    <div class="form-group">
                                        <?php echo $form->textField($modelGroup,'language', array('class' => 'form-control', 'placeholder'=>'Idioma')); ?>
                                        <?php echo $form->error($modelGroup,'language'); ?>
                                    </div>
                                    <div class="form-group">
                                        <?php echo $form->textArea($modelGroup,'description', array('class' => 'form-control', 'placeholder'=>'Descripción')); ?>
                                        <?php echo $form->error($modelGroup,'description'); ?>
                                    </div>

                                    <?php echo $form->hiddenField($modelGroup,'FK_admin_id', array("value" => Yii::app()->user->getState("userId"))); ?>

                                    <?php echo CHtml::submitButton('Crear', array('class' => 'btn btn-success pull-right')); ?>

                                    <?php $this->endWidget(); ?>
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
            <h4>Busqueda de Grupos</h4>
            <div class="container-fluid" style="padding-top:15px;background-color: #ebebeb;">
                <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id'=>'searchGroupsForm',
                        'action' => 'searchGroups',
                        'clientOptions'=>array(
                            'validateOnSubmit'=>true,
                            'validateOnChange'=> false
                        )
                    ));
                ?>
                <div class="col-lg-12">
                    <div class="form-group">
                        <?php echo $form->textField($modelGroup,'name', array('class' => 'form-control', 'placeholder'=>'Nombre del grupo o palabra clave')); ?>
                        <?php echo $form->error($modelGroup,'name'); ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <?php echo $form->dropDownList($modelGroup, 'country', array(''=>'Seleccione un país', 'colombia'=>'Colombia'), array('class'=>'form-control')); ?>
                        <?php echo $form->error($modelGroup,'country'); ?>
                    </div>
                    <div class="form-group">
                        <?php echo $form->dropDownList($modelGroup, 'category', array(''=>'Seleccione una categoria', '1'=>'Deportes y Actividades', '2'=>'Aventura', '3'=>'Ecologia'), array('class' => 'form-control')); ?>
                        <?php echo $form->error($modelGroup,'category'); ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <?php echo $form->dropDownList($modelGroup, 'city', array(''=>'Seleccione una ciudad', 'bogota'=>'Bogotá', 'ibague'=>'Ibague', 'pereira' => 'Pereira'), array('class'=>'form-control')); ?>
                        <?php echo $form->error($modelGroup,'city'); ?>
                    </div>
                    <?php echo CHtml::submitButton('Buscar grupos', array('class' => 'btn btn-success')); ?>
                </div>

                <?php $this->endWidget(); ?>
            </div>
            <h3>
                <?php 
                    if(isset($friend)) 
                    {
                        echo "Grupos de " . $friend->name;
                    }

                    else
                    {
                        echo "Mis grupos";
                    }
                ?>
            </h3>
            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/separatorMedium.png">
            <br>
            
            <?php
            foreach ($groups as $group) 
            {
                echo $group;
            }
            ?>
        </div>
    </div>
</div>
<div class="col-lg-3">
    <h3>Grupos Sugeridos</h3>
</div>