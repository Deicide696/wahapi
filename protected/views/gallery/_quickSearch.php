<form method="post" id="quickSearchForm">
    <input type='text' placeholder='Buscar grupos' id='quickSearch' name='quickSearch'>
	<input type="button" class="greenButton" id='statusButton' value="Buscar">
</form>

<script>   
$(function(){
    $("#statusButton").click(function(){
        $.ajax({
    		type: "POST",
            url: "status?userProfileId=",
            data: $("#statusForm").serialize(), // Adjuntar los campos del formulario enviado.
            success: function(data)
            {	
            	$('#status').val('');
                $("#allPost").prepend(data); // Mostrar la respuestas del script PHP.
            }
        });
        return false; // Evitar ejecutar el submit del formulario.
    });

    $("#status").keypress(function(e){
        if(e.which == 13)
        {
            $.ajax({
                type: "POST",
                url: "status?userProfileId=",
                data: $("#statusForm").serialize(), // Adjuntar los campos del formulario enviado.
                success: function(data)
                {   
                    $('#status').val('');
                    $("#allPost").prepend(data); // Mostrar la respuestas del script PHP.
                }
            });
            return false; // Evitar ejecutar el submit del formulario.
        }
    });
});
</script>