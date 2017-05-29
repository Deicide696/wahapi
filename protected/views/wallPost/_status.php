<?php
// Wallpost friend
if(isset($_GET['userProfileId']))
{
    $userProfile = $_GET['userProfileId'];
?>
<form method="post" id="statusForm">
    <input type='text' placeholder='Escribe que estas pensando' id='status' name='status'>
	<input type="button" class="btn btn-success" id='statusButton' value="Publicar">
</form>

<script>   
$(function(){
    $("#statusButton").click(function(){
        $.ajax({
    		type: "POST",
            url: "status?userProfileId=<?php echo $userProfile ?>",
            data: $("#statusForm").serialize(), // Adjuntar los campos del formulario enviado.
            beforeSend: function(){
                $('#statusButton').attr("disabled", true);
            },
            success: function(data)
            {	
            	$('#status').val('');
                $("#allPost").prepend(data); // Mostrar la respuestas del script en el DOM.
                $('#statusButton').attr("disabled", false);
            }
        });
        return false; // Evitar ejecutar el submit del formulario.
    });

    $("#status").keypress(function(e){
        if(e.which == 13)
        {
            $.ajax({
                type: "POST",
                url: "status?userProfileId=<?php echo $userProfile ?>",
                data: $("#statusForm").serialize(), // Adjuntar los campos del formulario enviado.
                beforeSend: function(){
                    $('#status').attr("disabled", true);
                },
                success: function(data)
                {   
                    $('#status').val('');
                    $("#allPost").prepend(data); // Mostrar la respuestas del script en el DOM.
                    $('#status').attr("disabled", false);
                }
            });
            return false; // Evitar ejecutar el submit del formulario.
        }
    });
});
</script>

<?php
}

//Wallpost group
else if(isset($_GET['groupId']))
{
    $groupId = $_GET['groupId'];
?>

<form method="post" id="statusForm">
    <input type='text' placeholder='Comparte algo en el grupo' id='status' name='status'>
    <input type="button" class="btn btn-success" id='statusButton' value="Publicar">
</form>

<script>   
$(function(){
    $("#statusButton").click(function(){
        $.ajax({
            type: "POST",
            url: "status?groupId=<?php echo $groupId ?>",
            data: $("#statusForm").serialize(), // Adjuntar los campos del formulario enviado.
            beforeSend: function(){
                $('#statusButton').attr("disabled", true);
            },
            success: function(data)
            {   
                $('#status').val('');
                $("#allPost").prepend(data); // Mostrar la respuestas del script PHP.
                $('#statusButton').attr("disabled", false);
            }
        });
        return false; // Evitar ejecutar el submit del formulario.
    });

    $("#status").keypress(function(e){
        if(e.which == 13)
        {
            $.ajax({
                type: "POST",
                url: "status?groupId=<?php echo $groupId ?>",
                data: $("#statusForm").serialize(), // Adjuntar los campos del formulario enviado.
                beforeSend: function(){
                    $('#status').attr("disabled", true);
                },
                success: function(data)
                {   
                    $('#status').val('');
                    $("#allPost").prepend(data); // Mostrar la respuestas del script PHP.
                    $('#status').attr("disabled", false);
                }
            });
            return false; // Evitar ejecutar el submit del formulario.
        }
    });
});
</script>
<?php
}

//Wallpost yourself
else
{
    $userProfileId = Yii::app()->user->getState('userId');
?>
<form method="post" id="statusForm">
    <input type='text' placeholder='Escribe que estas pensando' id='status' name='status'>
    <input type="button" class="btn btn-success" id='statusButton' value="Publicar">
</form>

<script>   
$(function(){
    $("#statusButton").click(function(){
        $.ajax({
            type: "POST",
            url: "status?userProfileId=<?php echo $userProfileId ?>",
            data: $("#statusForm").serialize(), // Adjuntar los campos del formulario enviado.
            beforeSend: function(){
                $('#statusButton').attr("disabled", true);
            },
            success: function(data)
            {   
                $('#status').val('');
                $("#allPost").prepend(data); // Mostrar la respuestas del script PHP.
                $('#statusButton').attr("disabled", false);
            }
        });
        return false; // Evitar ejecutar el submit del formulario.
    });

    $("#status").keypress(function(e){
        if(e.which == 13)
        {
            $.ajax({
                type: "POST",
                url: "status?userProfileId=<?php echo $userProfileId ?>",
                data: $("#statusForm").serialize(), // Adjuntar los campos del formulario enviado.
                beforeSend: function(){
                    $('#status').attr("disabled", true);
                },
                success: function(data)
                {   
                    $('#status').val('');
                    $("#allPost").prepend(data); // Mostrar la respuestas del script PHP.
                    $('#status').attr("disabled", false);
                }
            });
            return false; // Evitar ejecutar el submit del formulario.
        }
    });
});
</script>
<?php
}
?>