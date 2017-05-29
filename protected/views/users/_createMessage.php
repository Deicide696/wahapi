<?php echo CHtml::beginForm(); ?>

<?php echo CHtml::textArea("content", "", array("id" => "content")); ?>
<?php echo CHtml::hiddenField("FK_creator", $creator, array("id" => "FK_creator")); ?>
<?php echo CHtml::hiddenField("FK_receiver", $receiver, array("id" => "FK_receiver")); ?>

<?php
echo CHtml::ajaxSubmitButton(
    'Ingresar',
    array('sendMessage'),
    array(
        "success"=>"function(data){
            alert('El mensaje se ha enviado');
            $('#message').dialog('close');
        }",
    )
);
?>

<?php echo CHtml::endForm(); ?>
